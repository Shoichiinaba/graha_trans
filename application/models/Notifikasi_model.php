<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('WebPushSender');
        $this->load->model('Sewa_model');
        $this->load->helper('rental');
    }

    public function get_settings()
    {
        $row = $this->db->get_where('rental_notifikasi_setting', array('id' => 1))->row();
        if (!$row) {
            $token = hash('sha256', uniqid('gt_', true) . mt_rand());
            $this->db->insert('rental_notifikasi_setting', array(
                'id'                      => 1,
                'cron_token'              => $token,
                'reminder_interval_hours' => 12
            ));
            $row = $this->db->get_where('rental_notifikasi_setting', array('id' => 1))->row();
        }

        if (empty($row->vapid_public_key) || empty($row->vapid_private_pem)) {
            $keys = $this->webpushsender->generate_vapid_keys();
            if ($keys) {
                $this->db->where('id', 1)->update('rental_notifikasi_setting', array(
                    'vapid_public_key'  => $keys['public_key'],
                    'vapid_private_pem' => $keys['private_pem']
                ));
                $row->vapid_public_key = $keys['public_key'];
                $row->vapid_private_pem = $keys['private_pem'];
            }
        }

        return $row;
    }

    public function save_settings($data)
    {
        $this->get_settings();
        return $this->db->where('id', 1)->update('rental_notifikasi_setting', $data);
    }

    public function save_subscription($id_agency, $endpoint, $p256dh, $auth, $user_agent = '')
    {
        $hash = hash('sha256', $endpoint);
        $existing = $this->db->get_where('rental_push_subscription', array('endpoint_hash' => $hash))->row();

        $data = array(
            'id_agency'     => $id_agency ? (int) $id_agency : null,
            'endpoint'      => $endpoint,
            'endpoint_hash' => $hash,
            'p256dh'        => $p256dh,
            'auth'          => $auth,
            'user_agent'    => substr((string) $user_agent, 0, 255),
            'is_active'     => 1
        );

        if ($existing) {
            $this->db->where('id_sub', (int) $existing->id_sub)->update('rental_push_subscription', $data);
            return (int) $existing->id_sub;
        }
        $this->db->insert('rental_push_subscription', $data);
        return $this->db->insert_id();
    }

    public function deactivate_subscription($endpoint)
    {
        $hash = hash('sha256', $endpoint);
        return $this->db->where('endpoint_hash', $hash)->update('rental_push_subscription', array('is_active' => 0));
    }

    public function get_active_subscriptions()
    {
        return $this->db
            ->where('is_active', 1)
            ->order_by('id_sub', 'DESC')
            ->get('rental_push_subscription')
            ->result();
    }

    public function count_active_subscriptions()
    {
        return (int) $this->db->where('is_active', 1)->count_all_results('rental_push_subscription');
    }

    private function _push_to_all_channels($setting, $title, $body, $clickUrl, $tag = 'gt-overdue')
    {
        $channels_used = array('in_app');
        $web_push_sent = 0;
        $web_push_failed = 0;

        // 1. Web Push (Chrome Android / Desktop PWA)
        if (!empty($setting->vapid_public_key) && !empty($setting->vapid_private_pem)) {
            $subs = $this->get_active_subscriptions();
            if (!empty($subs)) {
                $payload = array(
                    'title'   => $title,
                    'body'    => $body,
                    'url'     => $clickUrl,
                    'tag'     => $tag,
                    'icon'    => base_url('assets/img/logo/logo.png'),
                    'badge'   => base_url('assets/img/logo/A.png')
                );
                foreach ($subs as $sub) {
                    $res = $this->webpushsender->send_web_push(
                        $sub,
                        $payload,
                        $setting->vapid_public_key,
                        $setting->vapid_private_pem,
                        $setting->vapid_subject ?: 'mailto:grahatransportungaran@gmail.com'
                    );
                    if (!empty($res['ok'])) {
                        $web_push_sent++;
                    } else {
                        $web_push_failed++;
                        if (!empty($res['expired'])) {
                            $this->db->where('id_sub', (int) $sub->id_sub)->update('rental_push_subscription', array('is_active' => 0));
                        }
                    }
                }
                if ($web_push_sent > 0) {
                    $channels_used[] = 'web_push(' . $web_push_sent . ')';
                }
            }
        }

        // 2. ntfy.sh (Android App Push - works even on local HTTP!)
        if (!empty($setting->ntfy_enabled) && !empty($setting->ntfy_topic)) {
            if ($this->webpushsender->send_ntfy($setting->ntfy_topic, $title, $body, $clickUrl)) {
                $channels_used[] = 'ntfy';
            }
        }

        // 3. Telegram Bot
        if (!empty($setting->telegram_enabled) && !empty($setting->telegram_bot_token) && !empty($setting->telegram_chat_id)) {
            $tgText = "<b>" . htmlspecialchars($title) . "</b>\n" . htmlspecialchars($body) . "\n\n<a href=\"" . htmlspecialchars($clickUrl) . "\">Buka Manajemen Sewa</a>";
            if ($this->webpushsender->send_telegram($setting->telegram_bot_token, $setting->telegram_chat_id, $tgText)) {
                $channels_used[] = 'telegram';
            }
        }

        // 4. WhatsApp Fonnte
        if (!empty($setting->fonnte_enabled) && !empty($setting->fonnte_token) && !empty($setting->fonnte_target)) {
            $waText = "*" . $title . "*\n" . $body . "\n\nLink: " . $clickUrl;
            if ($this->webpushsender->send_fonnte($setting->fonnte_token, $setting->fonnte_target, $waText)) {
                $channels_used[] = 'whatsapp';
            }
        }

        return array(
            'channels'        => $channels_used,
            'web_push_sent'   => $web_push_sent,
            'web_push_failed' => $web_push_failed
        );
    }

    public function dispatch_overdue_notifications($force = false)
    {
        $overdue = $this->Sewa_model->get_overdue();
        if (empty($overdue)) {
            return array('checked' => 0, 'sent' => 0, 'overdue' => array());
        }

        $setting = $this->get_settings();
        $interval_hours = max(1, (int) $setting->reminder_interval_hours);
        $cutoff = date('Y-m-d H:i:s', time() - ($interval_hours * 3600));
        $clickUrl = site_url('Sewa_mobil');

        $sent_count = 0;
        foreach ($overdue as $row) {
            $should_send = $force;
            if (!$should_send) {
                $last_log = $this->db
                    ->where('id_sewa', (int) $row->id_sewa)
                    ->order_by('id_notif', 'DESC')
                    ->limit(1)
                    ->get('rental_notifikasi_log')
                    ->row();

                if (!$last_log) {
                    $should_send = true;
                } elseif ((int) $row->hari_terlambat > (int) $last_log->hari_terlambat) {
                    // Segera kirim notifikasi saat melewati toleransi jam 06:00 atau bertambah hari akumulasi
                    $should_send = true;
                } elseif (strtotime($last_log->sent_at) < strtotime($cutoff)) {
                    $should_send = true;
                }
            }

            if ($should_send) {
                $title = 'Unit Perlu Ditindaklanjuti!';
                if (!empty($row->in_grace_period)) {
                    $body = $row->nama_user . ' - ' . $row->tipe_unit . ' (' . $row->plat_nomor . ') '
                        . 'melewati jadwal selesai (' . format_tanggal_id($row->tanggal_selesai) . ' 24.00) & masih masa toleransi s/d 06.00 WIB. '
                        . 'Tagihan sementara: ' . format_rupiah($row->tagihan_berjalan) . '. Segera tindaklanjuti.';
                } else {
                    $body = $row->nama_user . ' - ' . $row->tipe_unit . ' (' . $row->plat_nomor . ') '
                        . 'melewati toleransi 06.00 WIB (akumulasi +' . (int) $row->hari_terlambat . ' hari). '
                        . 'Tagihan berjalan: ' . format_rupiah($row->tagihan_berjalan) . '. Segera perpanjang atau klik Selesai.';
                }

                $res = $this->_push_to_all_channels($setting, $title, $body, $clickUrl, 'gt-overdue-' . $row->id_sewa);

                $this->db->insert('rental_notifikasi_log', array(
                    'id_sewa'        => (int) $row->id_sewa,
                    'judul'          => $title,
                    'pesan'          => $body,
                    'hari_terlambat' => (int) $row->hari_terlambat,
                    'channel'        => implode(',', $res['channels']),
                    'is_read'        => 0
                ));
                $sent_count++;
            }
        }

        return array(
            'checked' => count($overdue),
            'sent'    => $sent_count,
            'overdue' => $overdue
        );
    }

    public function send_test_notification()
    {
        $setting = $this->get_settings();
        $title = 'Tes Notifikasi Graha Transport';
        $body = 'Notifikasi realtime aktif! Peringatan unit melewati masa sewa akan langsung muncul di HP Android Anda.';
        $clickUrl = site_url('Sewa_mobil');

        return $this->_push_to_all_channels($setting, $title, $body, $clickUrl, 'gt-test-' . time());
    }

    public function get_logs($limit = 30)
    {
        return $this->db
            ->select('nl.*, rt.nama_user, rt.tipe_unit, rt.plat_nomor, rt.status AS status_sewa')
            ->from('rental_notifikasi_log nl')
            ->join('rental_transaksi rt', 'rt.id_sewa = nl.id_sewa', 'left')
            ->order_by('nl.id_notif', 'DESC')
            ->limit((int) $limit)
            ->get()
            ->result();
    }

    public function count_unread_logs()
    {
        return (int) $this->db->where('is_read', 0)->count_all_results('rental_notifikasi_log');
    }

    public function mark_all_read()
    {
        return $this->db->where('is_read', 0)->update('rental_notifikasi_log', array('is_read' => 1));
    }
}
