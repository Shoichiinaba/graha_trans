<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends AUTH_Controller
{
    var $template = 'template/index';

    public function __construct()
    {
        parent::__construct();
        $this->require_roles(array('Admin', 'Owner', 'admin_oprational'));
        $this->load->model('Notifikasi_model');
        $this->load->model('Sewa_model');
        $this->load->helper('rental');
    }

    public function index()
    {
        $setting = $this->Notifikasi_model->get_settings();
        $data['tittle']       = 'Graha Transport | Notifikasi Realtime HP';
        $data['userdata']     = $this->userdata;
        $data['setting']      = $setting;
        $data['active_subs']  = $this->Notifikasi_model->count_active_subscriptions();
        $data['overdue_list'] = $this->Sewa_model->get_overdue();
        $data['logs']         = $this->Notifikasi_model->get_logs(30);
        $data['content']      = 'page_admin/notifikasi/notifikasi';
        $data['script']       = 'page_admin/notifikasi/notifikasi_js';
        $this->load->view($this->template, $data);
    }

    public function poll()
    {
        // Otomatis cek & kirim push bila ada unit baru yang melewati masa sewa
        $dispatch = $this->Notifikasi_model->dispatch_overdue_notifications(false);
        $overdue = $dispatch['overdue'];

        $items = array();
        foreach ($overdue as $ov) {
            $items[] = array(
                'id_sewa'          => (int) $ov->id_sewa,
                'no_invoice'       => $ov->no_invoice,
                'nama_user'        => $ov->nama_user,
                'tipe_unit'        => $ov->tipe_unit,
                'plat_nomor'       => $ov->plat_nomor,
                'tanggal_selesai'    => format_tanggal_id($ov->tanggal_selesai),
                'hari_terlambat'     => (int) $ov->hari_terlambat,
                'in_grace_period'    => !empty($ov->in_grace_period),
                'deadline_toleransi' => isset($ov->deadline_toleransi) ? $ov->deadline_toleransi : '',
                'tagihan_berjalan'   => format_rupiah($ov->tagihan_berjalan)
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'status'        => 'success',
                'overdue_count' => count($items),
                'overdue_items' => $items,
                'pushed_now'    => (int) $dispatch['sent']
            )));
    }

    public function subscribe()
    {
        $endpoint = trim((string) $this->input->post('endpoint'));
        $p256dh = trim((string) $this->input->post('p256dh'));
        $auth = trim((string) $this->input->post('auth'));

        if ($endpoint === '' || $p256dh === '' || $auth === '') {
            echo json_encode(array('status' => 'error', 'message' => 'Data subscription tidak lengkap.'));
            return;
        }

        $id_agency = isset($this->userdata->id_agency) ? (int) $this->userdata->id_agency : null;
        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $id_sub = $this->Notifikasi_model->save_subscription($id_agency, $endpoint, $p256dh, $auth, $ua);

        echo json_encode(array(
            'status'      => 'success',
            'message'     => 'Perangkat HP / Browser berhasil didaftarkan untuk notifikasi realtime.',
            'id_sub'      => $id_sub,
            'active_subs' => $this->Notifikasi_model->count_active_subscriptions()
        ));
    }

    public function unsubscribe()
    {
        $endpoint = trim((string) $this->input->post('endpoint'));
        if ($endpoint !== '') {
            $this->Notifikasi_model->deactivate_subscription($endpoint);
        }
        echo json_encode(array(
            'status'      => 'success',
            'message'     => 'Langganan notifikasi perangkat dinonaktifkan.',
            'active_subs' => $this->Notifikasi_model->count_active_subscriptions()
        ));
    }

    public function save_settings()
    {
        $interval = (int) $this->input->post('reminder_interval_hours');
        if ($interval < 1) {
            $interval = 12;
        }

        $data = array(
            'reminder_interval_hours' => $interval,
            'ntfy_enabled'            => $this->input->post('ntfy_enabled') ? 1 : 0,
            'ntfy_topic'              => trim((string) $this->input->post('ntfy_topic', true)),
            'telegram_enabled'        => $this->input->post('telegram_enabled') ? 1 : 0,
            'telegram_bot_token'      => trim((string) $this->input->post('telegram_bot_token', true)),
            'telegram_chat_id'        => trim((string) $this->input->post('telegram_chat_id', true)),
            'fonnte_enabled'          => $this->input->post('fonnte_enabled') ? 1 : 0,
            'fonnte_token'            => trim((string) $this->input->post('fonnte_token', true)),
            'fonnte_target'           => trim((string) $this->input->post('fonnte_target', true))
        );

        $this->Notifikasi_model->save_settings($data);
        echo json_encode(array('status' => 'success', 'message' => 'Pengaturan channel notifikasi berhasil disimpan.'));
    }

    public function test_push()
    {
        $res = $this->Notifikasi_model->send_test_notification();
        $channels = !empty($res['channels']) ? implode(', ', $res['channels']) : 'in_app';
        echo json_encode(array(
            'status'  => 'success',
            'message' => 'Tes notifikasi dikirim melalui channel: ' . $channels,
            'detail'  => $res
        ));
    }

    public function cek_sekarang()
    {
        $res = $this->Notifikasi_model->dispatch_overdue_notifications(true);
        echo json_encode(array(
            'status'  => 'success',
            'message' => 'Pengecekan selesai. Ditemukan ' . $res['checked'] . ' unit melewati batas sewa, notifikasi dikirim untuk ' . $res['sent'] . ' unit.',
            'detail'  => $res
        ));
    }

    public function mark_read()
    {
        $this->Notifikasi_model->mark_all_read();
        echo json_encode(array('status' => 'success'));
    }
}

