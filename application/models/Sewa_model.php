<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sewa_model extends CI_Model
{
    public function generate_no_invoice($tanggal = null)
    {
        $ts = $tanggal ? strtotime($tanggal) : time();
        $prefix = 'INV/GT/' . date('Ym', $ts) . '/';

        $this->db->select('no_invoice');
        $this->db->from('rental_booking');
        $this->db->like('no_invoice', $prefix, 'after');
        $this->db->order_by('id_booking', 'DESC');
        $this->db->limit(1);
        $last = $this->db->get()->row();

        $next = 1;
        if ($last && !empty($last->no_invoice)) {
            $parts = explode('/', $last->no_invoice);
            $last_num = (int) end($parts);
            $next = $last_num + 1;
        }

        // Pastikan unik juga terhadap rental_transaksi
        do {
            $candidate = $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
            $exists_b = $this->db->where('no_invoice', $candidate)->count_all_results('rental_booking');
            $exists_t = $this->db->where('no_invoice', $candidate)->count_all_results('rental_transaksi');
            if ($exists_b == 0 && $exists_t == 0) {
                return $candidate;
            }
            $next++;
        } while (true);
    }

    public function get_unit_garasi_list()
    {
        return $this->db
            ->order_by('nama_unit', 'ASC')
            ->get('unit_mobil')
            ->result();
    }

    public function get_vendor_suggestions()
    {
        return $this->db
            ->select('nama_unit_asal')
            ->from('rental_transaksi')
            ->where('asal_unit', 'luar')
            ->where('nama_unit_asal !=', '')
            ->group_by('nama_unit_asal')
            ->order_by('nama_unit_asal', 'ASC')
            ->get()
            ->result();
    }

    private function _apply_filters($filters = array())
    {
        $today = date('Y-m-d');

        if (!empty($filters['bulan'])) {
            $parts = explode('-', $filters['bulan']);
            if (count($parts) === 2) {
                $year = (int) $parts[0];
                $month = (int) $parts[1];
                $this->db->where('YEAR(rt.tanggal_mulai)', $year);
                $this->db->where('MONTH(rt.tanggal_mulai)', $month);

                if (!empty($filters['minggu'])) {
                    $week = (int) $filters['minggu'];
                    $start_day = (($week - 1) * 7) + 1;
                    $end_day = $week * 7;
                    if ($week >= 4) {
                        $end_day = 31;
                    }
                    $this->db->where('DAY(rt.tanggal_mulai) >=', $start_day);
                    $this->db->where('DAY(rt.tanggal_mulai) <=', $end_day);
                }
            }
        }

        if (!empty($filters['tanggal_dari'])) {
            $this->db->where('rt.tanggal_mulai >=', $filters['tanggal_dari']);
        }
        if (!empty($filters['tanggal_sampai'])) {
            $this->db->where('rt.tanggal_mulai <=', $filters['tanggal_sampai']);
        }

        if (!empty($filters['asal_unit']) && in_array($filters['asal_unit'], array('garasi', 'luar'), true)) {
            $this->db->where('rt.asal_unit', $filters['asal_unit']);
        }

        if (!empty($filters['status'])) {
            if ($filters['status'] === 'overdue') {
                $this->db->where('rt.status', 'Open');
                $this->db->where('rt.tanggal_selesai <', $today);
            } elseif (in_array($filters['status'], array('Open', 'Selesai'), true)) {
                $this->db->where('rt.status', $filters['status']);
            }
        }

        if (!empty($filters['search'])) {
            $keyword = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('rt.nama_user', $keyword);
            $this->db->or_like('rt.tipe_unit', $keyword);
            $this->db->or_like('rt.plat_nomor', $keyword);
            $this->db->or_like('rt.no_invoice', $keyword);
            $this->db->or_like('rt.nama_unit_asal', $keyword);
            $this->db->group_end();
        }
    }

    public function enrich_row($row)
    {
        if (!$row) {
            return null;
        }
        $is_overdue = false;
        $in_grace_period = false;
        $hari_terlambat = 0;
        $estimasi_tambahan = 0;
        $deadline_toleransi = date('d/m/Y', strtotime('+1 day', strtotime($row->tanggal_selesai))) . ' 06:00';

        if ($row->status === 'Open') {
            $akumulasi = hitung_akumulasi_terlambat($row->tanggal_selesai);
            $is_overdue = $akumulasi['is_past_date'];
            $in_grace_period = $akumulasi['in_grace_period'];
            $hari_terlambat = $akumulasi['hari_akumulasi'];
            $deadline_toleransi = $akumulasi['deadline_toleransi'];
            if ($hari_terlambat > 0) {
                $estimasi_tambahan = $hari_terlambat * (float) $row->harga_user;
            }
        }

        $row->is_overdue = $is_overdue;
        $row->in_grace_period = $in_grace_period;
        $row->hari_terlambat = $hari_terlambat;
        $row->deadline_toleransi = $deadline_toleransi;
        $row->estimasi_tambahan = $estimasi_tambahan;
        $row->tagihan_berjalan = (float) $row->total_masuk + $estimasi_tambahan;
        return $row;
    }

    public function get_all($filters = array(), $order_dir = 'ASC')
    {
        $this->db->select('rt.*, rb.status_pembayaran AS booking_status_pembayaran, rb.jumlah_dp AS booking_jumlah_dp, '
            . '(SELECT COUNT(*) FROM rental_transaksi rt2 WHERE rt2.id_booking = rt.id_booking) AS jumlah_unit_booking, '
            . '(SELECT COALESCE(SUM(rt3.total_masuk),0) FROM rental_transaksi rt3 WHERE rt3.id_booking = rt.id_booking) AS total_tagihan_booking, '
            . '(SELECT COUNT(*) FROM rental_kontrak rk WHERE (rk.id_booking IS NOT NULL AND rk.id_booking = rt.id_booking) OR rk.id_sewa = rt.id_sewa) AS jumlah_kontrak, '
            . '(SELECT MAX(rk2.id_kontrak) FROM rental_kontrak rk2 WHERE (rk2.id_booking IS NOT NULL AND rk2.id_booking = rt.id_booking) OR rk2.id_sewa = rt.id_sewa) AS id_kontrak');
        $this->db->from('rental_transaksi rt');
        $this->db->join('rental_booking rb', 'rb.id_booking = rt.id_booking', 'left');
        $this->_apply_filters($filters);
        $this->db->order_by('rt.tanggal_mulai', $order_dir);
        $this->db->order_by('rt.id_booking', $order_dir);
        $this->db->order_by('rt.id_sewa', $order_dir);

        $rows = $this->db->get()->result();
        foreach ($rows as $idx => $row) {
            if (!empty($row->booking_status_pembayaran)) {
                $row->status_pembayaran = $row->booking_status_pembayaran;
                $row->jumlah_dp = $row->booking_jumlah_dp;
            }
            if (empty($row->jumlah_unit_booking)) {
                $row->jumlah_unit_booking = 1;
                $row->total_tagihan_booking = $row->total_masuk;
            }
            $rows[$idx] = $this->enrich_row($row);
        }
        return $rows;
    }

    public function get_grouped_by_day($filters = array())
    {
        $rows = $this->get_all($filters, 'ASC');
        $grouped = array();

        foreach ($rows as $row) {
            $tgl = $row->tanggal_mulai;
            if (!isset($grouped[$tgl])) {
                $grouped[$tgl] = array(
                    'tanggal' => $tgl,
                    'items' => array(),
                    'total_masuk' => 0,
                    'total_rent_to_rent' => 0,
                    'total_unit_garasi' => 0,
                    'total_unit_luar' => 0
                );
            }
            $grouped[$tgl]['items'][] = $row;
            $grouped[$tgl]['total_masuk'] += (float) $row->total_masuk;
            $grouped[$tgl]['total_rent_to_rent'] += (float) $row->rent_to_rent;
            $grouped[$tgl]['total_unit_garasi'] += (float) $row->unit_garasi;
            $grouped[$tgl]['total_unit_luar'] += (float) $row->unit_luar;
        }

        return $grouped;
    }

    public function get_overdue()
    {
        $today = date('Y-m-d');
        $rows = $this->db
            ->from('rental_transaksi')
            ->where('status', 'Open')
            ->where('tanggal_selesai <', $today)
            ->order_by('tanggal_selesai', 'ASC')
            ->get()
            ->result();

        foreach ($rows as $idx => $row) {
            $rows[$idx] = $this->enrich_row($row);
        }
        return $rows;
    }

    public function get_summary($filters = array())
    {
        $rows = $this->get_all($filters, 'DESC');
        $summary = array(
            'total_transaksi' => count($rows),
            'total_masuk' => 0,
            'total_rent_to_rent' => 0,
            'total_unit_garasi' => 0,
            'total_unit_luar' => 0,
            'total_nett' => 0,
            'total_open' => 0,
            'total_overdue' => 0,
            'total_selesai' => 0,
            'total_tagihan_berjalan' => 0
        );

        foreach ($rows as $r) {
            $summary['total_masuk'] += (float) $r->total_masuk;
            $summary['total_rent_to_rent'] += (float) $r->rent_to_rent;
            $summary['total_unit_garasi'] += (float) $r->unit_garasi;
            $summary['total_unit_luar'] += (float) $r->unit_luar;
            $summary['total_tagihan_berjalan'] += (float) $r->tagihan_berjalan;
            if ($r->status === 'Open') {
                $summary['total_open']++;
                if ($r->is_overdue) {
                    $summary['total_overdue']++;
                }
            } else {
                $summary['total_selesai']++;
            }
        }
        $summary['total_nett'] = $summary['total_unit_garasi'] + $summary['total_unit_luar'];

        return $summary;
    }

    public function get_by_id($id_sewa)
    {
        $row = $this->db->get_where('rental_transaksi', array('id_sewa' => (int) $id_sewa))->row();
        return $this->enrich_row($row);
    }

    public function get_booking_by_id($id_booking)
    {
        $booking = $this->db->get_where('rental_booking', array('id_booking' => (int) $id_booking))->row();
        if (!$booking) {
            return null;
        }
        $items = $this->db
            ->where('id_booking', (int) $id_booking)
            ->order_by('id_sewa', 'ASC')
            ->get('rental_transaksi')
            ->result();

        $total_tagihan = 0;
        $total_garasi = 0;
        $total_luar = 0;
        $total_rtr = 0;
        foreach ($items as $idx => $it) {
            $items[$idx] = $this->enrich_row($it);
            $total_tagihan += (float) $it->total_masuk;
            $total_garasi += (float) $it->unit_garasi;
            $total_luar += (float) $it->unit_luar;
            $total_rtr += (float) $it->rent_to_rent;
        }

        $booking->items = $items;
        $booking->total_tagihan = $total_tagihan;
        $booking->total_garasi = $total_garasi;
        $booking->total_luar = $total_luar;
        $booking->total_rent_to_rent = $total_rtr;
        return $booking;
    }

    public function get_perpanjangan($id_sewa)
    {
        return $this->db
            ->where('id_sewa', (int) $id_sewa)
            ->order_by('id_perpanjangan', 'ASC')
            ->get('rental_perpanjangan')
            ->result();
    }

    public function get_perpanjangan_by_booking($id_booking)
    {
        return $this->db
            ->select('rp.*, rt.tipe_unit, rt.plat_nomor')
            ->from('rental_perpanjangan rp')
            ->join('rental_transaksi rt', 'rt.id_sewa = rp.id_sewa', 'inner')
            ->where('rt.id_booking', (int) $id_booking)
            ->order_by('rp.id_perpanjangan', 'ASC')
            ->get()
            ->result();
    }

    public function calculate_amounts($params)
    {
        $tgl_mulai = $params['tanggal_mulai'];
        $tgl_selesai = $params['tanggal_selesai'];
        $hari = hitung_hari_sewa($tgl_mulai, $tgl_selesai);
        $harga_user = (float) $params['harga_user'];
        $total_masuk = $hari * $harga_user;

        $asal_unit = ($params['asal_unit'] === 'luar') ? 'luar' : 'garasi';
        if ($asal_unit === 'garasi') {
            $nama_unit_asal = 'Garasi';
            $rent_to_rent_harian = 0;
            $rent_to_rent = 0;
            $unit_garasi = $total_masuk;
            $unit_luar = 0;
        } else {
            $nama_unit_asal = trim($params['nama_unit_asal']);
            if ($nama_unit_asal === '') {
                $nama_unit_asal = 'Unit Luar';
            }
            $rent_to_rent = isset($params['rent_to_rent']) ? (float) $params['rent_to_rent'] : 0;
            $rent_to_rent_harian = isset($params['rent_to_rent_harian']) ? (float) $params['rent_to_rent_harian'] : 0;

            if ($rent_to_rent <= 0 && $rent_to_rent_harian > 0) {
                $rent_to_rent = $hari * $rent_to_rent_harian;
            } elseif ($rent_to_rent > 0 && $rent_to_rent_harian <= 0 && $hari > 0) {
                $rent_to_rent_harian = round($rent_to_rent / $hari, 2);
            }

            $unit_garasi = 0;
            $unit_luar = $total_masuk - $rent_to_rent;
        }

        return array(
            'hari' => $hari,
            'harga_user' => $harga_user,
            'total_masuk' => $total_masuk,
            'nama_unit_asal' => $nama_unit_asal,
            'rent_to_rent_harian' => $rent_to_rent_harian,
            'rent_to_rent' => $rent_to_rent,
            'unit_garasi' => $unit_garasi,
            'unit_luar' => $unit_luar
        );
    }

    public function sync_unit_mobil_status($id_unit)
    {
        $id_unit = (int) $id_unit;
        if ($id_unit <= 0) {
            return;
        }
        $open_count = $this->db
            ->where('id_unit', $id_unit)
            ->where('asal_unit', 'garasi')
            ->where('status', 'Open')
            ->count_all_results('rental_transaksi');

        $new_status = ($open_count > 0) ? 'rental' : 'ready';
        $this->db->where('id_unit', $id_unit)->update('unit_mobil', array('status' => $new_status));
    }

    private function _apply_lunas_if_all_selesai($booking_data, $items)
    {
        $all_selesai = !empty($items);
        $total_booking = 0;
        foreach ($items as $it_chk) {
            if (!isset($it_chk['status']) || $it_chk['status'] !== 'Selesai') {
                $all_selesai = false;
            }
            $total_booking += isset($it_chk['total_masuk']) ? (float) $it_chk['total_masuk'] : 0;
        }
        if ($all_selesai) {
            $booking_data['status_pembayaran'] = 'Lunas';
            $booking_data['jumlah_dp'] = $total_booking;
        }
        return $booking_data;
    }

    public function insert_booking($booking_data, $items)
    {
        $booking_data = $this->_apply_lunas_if_all_selesai($booking_data, $items);

        $this->db->trans_start();

        $this->db->insert('rental_booking', $booking_data);
        $id_booking = $this->db->insert_id();

        $first_sewa_id = 0;
        $sync_units = array();

        foreach ($items as $item) {
            $item['id_booking'] = $id_booking;
            $item['no_invoice'] = $booking_data['no_invoice'];
            $item['nama_user'] = $booking_data['nama_user'];
            $item['no_hp_user'] = $booking_data['no_hp_user'];
            $item['alamat_user'] = $booking_data['alamat_user'];
            $item['status_pembayaran'] = $booking_data['status_pembayaran'];
            $item['jumlah_dp'] = $booking_data['jumlah_dp'];
            $item['catatan'] = $booking_data['catatan'];
            $item['created_by'] = $booking_data['created_by'];

            $this->db->insert('rental_transaksi', $item);
            $sewa_id = $this->db->insert_id();
            if ($first_sewa_id === 0) {
                $first_sewa_id = $sewa_id;
            }
            if (!empty($item['id_unit']) && $item['asal_unit'] === 'garasi') {
                $sync_units[(int) $item['id_unit']] = true;
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            foreach (array_keys($sync_units) as $uid) {
                $this->sync_unit_mobil_status($uid);
            }
            return array(
                'id_booking' => $id_booking,
                'id_sewa' => $first_sewa_id
            );
        }
        return false;
    }

    public function update_booking($id_booking, $booking_data, $items)
    {
        $existing = $this->get_booking_by_id($id_booking);
        if (!$existing) {
            return false;
        }

        $sync_units = array();
        $old_ids = array();
        foreach ($existing->items as $old_item) {
            $old_ids[] = (int) $old_item->id_sewa;
            if (!empty($old_item->id_unit)) {
                $sync_units[(int) $old_item->id_unit] = true;
            }
        }

        $booking_data = $this->_apply_lunas_if_all_selesai($booking_data, $items);

        $this->db->trans_start();

        $this->db->where('id_booking', (int) $id_booking)->update('rental_booking', $booking_data);

        $kept_ids = array();
        foreach ($items as $item) {
            $item_id = !empty($item['id_sewa']) ? (int) $item['id_sewa'] : 0;
            unset($item['id_sewa']);

            $item['id_booking'] = (int) $id_booking;
            $item['no_invoice'] = $existing->no_invoice;
            $item['nama_user'] = $booking_data['nama_user'];
            $item['no_hp_user'] = $booking_data['no_hp_user'];
            $item['alamat_user'] = $booking_data['alamat_user'];
            $item['status_pembayaran'] = $booking_data['status_pembayaran'];
            $item['jumlah_dp'] = $booking_data['jumlah_dp'];
            $item['catatan'] = $booking_data['catatan'];

            if (!empty($item['id_unit']) && $item['asal_unit'] === 'garasi') {
                $sync_units[(int) $item['id_unit']] = true;
            }

            if ($item_id > 0 && in_array($item_id, $old_ids, true)) {
                $this->db->where('id_sewa', $item_id)->update('rental_transaksi', $item);
                $kept_ids[] = $item_id;
            } else {
                $item['created_by'] = isset($booking_data['created_by']) ? $booking_data['created_by'] : $existing->created_by;
                $this->db->insert('rental_transaksi', $item);
                $kept_ids[] = $this->db->insert_id();
            }
        }

        // Hapus unit item yang dibuang dari form edit (pastikan rental_kontrak tidak putus jika menunjuk item yg dihapus)
        $deleted_ids = array_diff($old_ids, $kept_ids);
        if (!empty($deleted_ids)) {
            $replacement_id = !empty($kept_ids) ? (int) $kept_ids[0] : 0;
            if ($replacement_id > 0) {
                $this->db->where_in('id_sewa', $deleted_ids)->update('rental_kontrak', array('id_sewa' => $replacement_id));
            }
            $this->db->where_in('id_sewa', $deleted_ids)->delete('rental_transaksi');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            foreach (array_keys($sync_units) as $uid) {
                $this->sync_unit_mobil_status($uid);
            }
            return true;
        }
        return false;
    }

    public function update_pembayaran_booking($id_booking, $status_pembayaran, $jumlah_dp)
    {
        $this->db->where('id_booking', (int) $id_booking)->update('rental_booking', array(
            'status_pembayaran' => $status_pembayaran,
            'jumlah_dp' => $jumlah_dp
        ));
        $this->db->where('id_booking', (int) $id_booking)->update('rental_transaksi', array(
            'status_pembayaran' => $status_pembayaran,
            'jumlah_dp' => $jumlah_dp
        ));
        return true;
    }

    public function perpanjang_sewa($id_sewa, $tanggal_selesai_baru, $harga_user_harian = null, $rent_to_rent_harian = null, $keterangan = '', $user_id = null)
    {
        $sewa = $this->get_by_id($id_sewa);
        if (!$sewa) {
            return false;
        }

        $old_end = $sewa->tanggal_selesai;
        if (strtotime($tanggal_selesai_baru) <= strtotime($old_end)) {
            return false;
        }

        $tambah_hari = (int) round((strtotime($tanggal_selesai_baru) - strtotime($old_end)) / 86400);
        if ($tambah_hari < 1) {
            return false;
        }

        $rate_user = ($harga_user_harian !== null && $harga_user_harian !== '') ? (float) $harga_user_harian : (float) $sewa->harga_user;
        $tambahan_tagihan = $tambah_hari * $rate_user;

        $rate_rtr = 0;
        $tambahan_rtr = 0;
        if ($sewa->asal_unit === 'luar') {
            if ($rent_to_rent_harian !== null && $rent_to_rent_harian !== '') {
                $rate_rtr = (float) $rent_to_rent_harian;
            } else {
                $rate_rtr = ((float) $sewa->rent_to_rent_harian > 0)
                    ? (float) $sewa->rent_to_rent_harian
                    : ($sewa->hari > 0 ? round((float) $sewa->rent_to_rent / (int) $sewa->hari, 2) : 0);
            }
            $tambahan_rtr = $tambah_hari * $rate_rtr;
        }

        $new_hari = hitung_hari_sewa($sewa->tanggal_mulai, $tanggal_selesai_baru);
        $new_total_masuk = (float) $sewa->total_masuk + $tambahan_tagihan;
        $new_rtr = ($sewa->asal_unit === 'luar') ? ((float) $sewa->rent_to_rent + $tambahan_rtr) : 0;
        $new_unit_garasi = ($sewa->asal_unit === 'garasi') ? $new_total_masuk : 0;
        $new_unit_luar = ($sewa->asal_unit === 'luar') ? ($new_total_masuk - $new_rtr) : 0;

        $this->db->trans_start();

        $this->db->insert('rental_perpanjangan', array(
            'id_sewa' => (int) $id_sewa,
            'tanggal_selesai_lama' => $old_end,
            'tanggal_selesai_baru' => $tanggal_selesai_baru,
            'tambah_hari' => $tambah_hari,
            'harga_user_harian' => $rate_user,
            'tambahan_tagihan' => $tambahan_tagihan,
            'rent_to_rent_harian' => $rate_rtr,
            'tambahan_rent_to_rent' => $tambahan_rtr,
            'keterangan' => $keterangan,
            'created_by' => $user_id
        ));

        $this->db->where('id_sewa', (int) $id_sewa)->update('rental_transaksi', array(
            'tanggal_selesai' => $tanggal_selesai_baru,
            'hari' => $new_hari,
            'total_masuk' => $new_total_masuk,
            'rent_to_rent' => $new_rtr,
            'unit_garasi' => $new_unit_garasi,
            'unit_luar' => $new_unit_luar,
            'status' => 'Open'
        ));

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function selesaikan_sewa($id_sewa, $tanggal_kembali, $hitung_overdue = true, $user_id = null, $jam_kembali = null)
    {
        $sewa = $this->get_by_id($id_sewa);
        if (!$sewa) {
            return false;
        }

        $jam_str = !empty($jam_kembali) ? trim((string) $jam_kembali) : date('H:i:s');
        if (strlen($jam_str) === 5) {
            $jam_str .= ':00';
        }
        $akumulasi = hitung_akumulasi_terlambat($sewa->tanggal_selesai, $tanggal_kembali . ' ' . $jam_str);

        if ($hitung_overdue && $akumulasi['hari_akumulasi'] > 0) {
            $target_end_date = date('Y-m-d', strtotime($sewa->tanggal_selesai . ' +' . (int) $akumulasi['hari_akumulasi'] . ' days'));
            $this->perpanjang_sewa(
                $id_sewa,
                $target_end_date,
                (float) $sewa->harga_user,
                null,
                'Akumulasi pengembalian lewat batas 06:00 WIB (' . format_tanggal_id($tanggal_kembali) . ' ' . substr($jam_str, 0, 5) . ')',
                $user_id
            );
        }

        $this->db->where('id_sewa', (int) $id_sewa)->update('rental_transaksi', array(
            'status'          => 'Selesai',
            'tanggal_kembali' => $tanggal_kembali,
            'jam_kembali'     => substr($jam_str, 0, 5)
        ));

        // Update status kontrak & pembayaran menjadi Lunas jika seluruh unit di booking tersebut sudah Selesai
        if (!empty($sewa->id_booking)) {
            $sisa_open = $this->db
                ->where('id_booking', (int) $sewa->id_booking)
                ->where('status', 'Open')
                ->count_all_results('rental_transaksi');
            if ($sisa_open == 0) {
                $total_row = $this->db
                    ->select('COALESCE(SUM(total_masuk), 0) AS total_all')
                    ->where('id_booking', (int) $sewa->id_booking)
                    ->get('rental_transaksi')
                    ->row();
                $total_all = $total_row ? (float) $total_row->total_all : (float) $sewa->total_masuk;
                $this->update_pembayaran_booking((int) $sewa->id_booking, 'Lunas', $total_all);

                $this->db->where('id_booking', (int) $sewa->id_booking)
                    ->where('status_kontrak', 'Aktif')
                    ->update('rental_kontrak', array('status_kontrak' => 'Selesai'));
            }
        } else {
            $fresh = $this->get_by_id($id_sewa);
            $this->db->where('id_sewa', (int) $id_sewa)->update('rental_transaksi', array(
                'status_pembayaran' => 'Lunas',
                'jumlah_dp'         => $fresh ? (float) $fresh->total_masuk : (float) $sewa->total_masuk
            ));
            $this->db->where('id_sewa', (int) $id_sewa)
                ->where('status_kontrak', 'Aktif')
                ->update('rental_kontrak', array('status_kontrak' => 'Selesai'));
        }

        if ($sewa->asal_unit === 'garasi' && !empty($sewa->id_unit)) {
            $this->sync_unit_mobil_status($sewa->id_unit);
        }

        return true;
    }

    public function delete_sewa($id_sewa)
    {
        $sewa = $this->get_by_id($id_sewa);
        if (!$sewa) {
            return false;
        }
        $id_booking = !empty($sewa->id_booking) ? (int) $sewa->id_booking : 0;

        if ($id_booking > 0) {
            $count = $this->db->where('id_booking', $id_booking)->count_all_results('rental_transaksi');
            if ($count <= 1) {
                $this->db->where('id_booking', $id_booking)->update('rental_kontrak', array(
                    'id_booking' => null,
                    'id_sewa'    => null
                ));
                $this->db->where('id_booking', $id_booking)->delete('rental_booking');
            } else {
                // Pastikan kontrak yang menunjuk id_sewa ini dipindah ke unit lain dalam booking yang sama
                $other = $this->db->where('id_booking', $id_booking)->where('id_sewa !=', (int) $id_sewa)->get('rental_transaksi')->row();
                if ($other) {
                    $this->db->where('id_sewa', (int) $id_sewa)->update('rental_kontrak', array('id_sewa' => (int) $other->id_sewa));
                }
                $this->db->where('id_sewa', (int) $id_sewa)->delete('rental_transaksi');
            }
        } else {
            $this->db->where('id_sewa', (int) $id_sewa)->delete('rental_transaksi');
        }

        if ($sewa->asal_unit === 'garasi' && !empty($sewa->id_unit)) {
            $this->sync_unit_mobil_status($sewa->id_unit);
        }
        return true;
    }

    /**
     * Statistik tren bulanan (omset, laba bersih, dan jumlah unit tersewa) untuk N bulan terakhir.
     */
    public function get_monthly_trend($months = 6)
    {
        $months = max(2, min(12, (int) $months));
        $base_first = strtotime(date('Y-m-01'));
        $start_date = date('Y-m-01', strtotime('-' . ($months - 1) . ' months', $base_first));
        $end_date   = date('Y-m-t', $base_first);

        $short_months = array(
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ags',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        );

        $buckets = array();
        for ($i = $months - 1; $i >= 0; $i--) {
            $ts = strtotime('-' . $i . ' months', $base_first);
            $ym = date('Y-m', $ts);
            $m_idx = (int) date('n', $ts);
            $buckets[$ym] = array(
                'ym'           => $ym,
                'label'        => $short_months[$m_idx] . ' ' . date('Y', $ts),
                'omset'        => 0,
                'laba'         => 0,
                'unit_garasi'  => 0,
                'unit_luar'    => 0,
                'jumlah_unit'  => 0,
                'count_garasi' => 0,
                'count_luar'   => 0
            );
        }

        $rows = $this->db
            ->select("DATE_FORMAT(tanggal_mulai, '%Y-%m') AS ym, "
                . "COALESCE(SUM(total_masuk), 0) AS omset, "
                . "COALESCE(SUM(unit_garasi), 0) AS unit_garasi, "
                . "COALESCE(SUM(unit_luar), 0) AS unit_luar, "
                . "COUNT(*) AS jumlah_unit, "
                . "SUM(CASE WHEN asal_unit = 'garasi' THEN 1 ELSE 0 END) AS count_garasi, "
                . "SUM(CASE WHEN asal_unit = 'luar' THEN 1 ELSE 0 END) AS count_luar")
            ->from('rental_transaksi')
            ->where('tanggal_mulai >=', $start_date)
            ->where('tanggal_mulai <=', $end_date)
            ->group_by("DATE_FORMAT(tanggal_mulai, '%Y-%m')")
            ->get()
            ->result();

        foreach ($rows as $r) {
            if (isset($buckets[$r->ym])) {
                $ug = (float) $r->unit_garasi;
                $ul = (float) $r->unit_luar;
                $buckets[$r->ym]['omset']        = (float) $r->omset;
                $buckets[$r->ym]['unit_garasi']  = $ug;
                $buckets[$r->ym]['unit_luar']    = $ul;
                $buckets[$r->ym]['laba']         = $ug + $ul;
                $buckets[$r->ym]['jumlah_unit']  = (int) $r->jumlah_unit;
                $buckets[$r->ym]['count_garasi'] = (int) $r->count_garasi;
                $buckets[$r->ym]['count_luar']   = (int) $r->count_luar;
            }
        }

        $out = array(
            'labels'       => array(),
            'months'       => array(),
            'omset'        => array(),
            'laba'         => array(),
            'unit_garasi'  => array(),
            'unit_luar'    => array(),
            'jumlah_unit'  => array(),
            'count_garasi' => array(),
            'count_luar'   => array()
        );
        foreach ($buckets as $b) {
            $out['labels'][]       = $b['label'];
            $out['months'][]       = $b['ym'];
            $out['omset'][]        = $b['omset'];
            $out['laba'][]         = $b['laba'];
            $out['unit_garasi'][]  = $b['unit_garasi'];
            $out['unit_luar'][]    = $b['unit_luar'];
            $out['jumlah_unit'][]  = $b['jumlah_unit'];
            $out['count_garasi'][] = $b['count_garasi'];
            $out['count_luar'][]   = $b['count_luar'];
        }
        return $out;
    }

    /**
     * Perbandingan harian tanggal 1..31 antara bulan ini dan bulan lalu.
     */
    public function get_daily_comparison()
    {
        $curr_ts = strtotime(date('Y-m-01'));
        $prev_ts = strtotime('-1 month', $curr_ts);

        $curr_ym = date('Y-m', $curr_ts);
        $prev_ym = date('Y-m', $prev_ts);

        $max_days = max((int) date('t', $curr_ts), (int) date('t', $prev_ts));
        $days = array();
        $curr_omset = array_fill(0, $max_days, 0);
        $prev_omset = array_fill(0, $max_days, 0);
        $curr_unit  = array_fill(0, $max_days, 0);
        $prev_unit  = array_fill(0, $max_days, 0);

        for ($d = 1; $d <= $max_days; $d++) {
            $days[] = str_pad($d, 2, '0', STR_PAD_LEFT);
        }

        $rows = $this->db
            ->select("DATE_FORMAT(tanggal_mulai, '%Y-%m') AS ym, DAY(tanggal_mulai) AS d, "
                . "COALESCE(SUM(total_masuk), 0) AS omset, COUNT(*) AS jml")
            ->from('rental_transaksi')
            ->where('tanggal_mulai >=', date('Y-m-01', $prev_ts))
            ->where('tanggal_mulai <=', date('Y-m-t', $curr_ts))
            ->group_by("DATE_FORMAT(tanggal_mulai, '%Y-%m'), DAY(tanggal_mulai)")
            ->get()
            ->result();

        foreach ($rows as $r) {
            $idx = ((int) $r->d) - 1;
            if ($idx < 0 || $idx >= $max_days) {
                continue;
            }
            if ($r->ym === $curr_ym) {
                $curr_omset[$idx] = (float) $r->omset;
                $curr_unit[$idx]  = (int) $r->jml;
            } elseif ($r->ym === $prev_ym) {
                $prev_omset[$idx] = (float) $r->omset;
                $prev_unit[$idx]  = (int) $r->jml;
            }
        }

        return array(
            'days'          => $days,
            'current_label' => nama_bulan_id((int) date('n', $curr_ts)) . ' ' . date('Y', $curr_ts),
            'prev_label'    => nama_bulan_id((int) date('n', $prev_ts)) . ' ' . date('Y', $prev_ts),
            'current_omset' => $curr_omset,
            'prev_omset'    => $prev_omset,
            'current_unit'  => $curr_unit,
            'prev_unit'     => $prev_unit
        );
    }

    /**
     * Daftar unit paling sering disewa beserta kontribusi omsetnya.
     */
    public function get_top_units($bulan = null, $limit = 5)
    {
        $this->db->select('tipe_unit, plat_nomor, asal_unit, nama_unit_asal, '
            . 'COUNT(*) AS kali_sewa, COALESCE(SUM(hari), 0) AS total_hari, '
            . 'COALESCE(SUM(total_masuk), 0) AS total_omset, '
            . 'COALESCE(SUM(unit_garasi + unit_luar), 0) AS total_laba');
        $this->db->from('rental_transaksi');
        if (!empty($bulan)) {
            $parts = explode('-', $bulan);
            if (count($parts) === 2) {
                $this->db->where('YEAR(tanggal_mulai)', (int) $parts[0]);
                $this->db->where('MONTH(tanggal_mulai)', (int) $parts[1]);
            }
        }
        $this->db->group_by('tipe_unit, plat_nomor, asal_unit, nama_unit_asal');
        $this->db->order_by('kali_sewa', 'DESC');
        $this->db->order_by('total_omset', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    /**
     * Transaksi sewa terbaru untuk ringkasan aktivitas dashboard.
     */
    public function get_recent_transactions($limit = 6)
    {
        $rows = $this->db
            ->from('rental_transaksi')
            ->order_by('tanggal_mulai', 'DESC')
            ->order_by('id_sewa', 'DESC')
            ->limit((int) $limit)
            ->get()
            ->result();

        foreach ($rows as $idx => $row) {
            $rows[$idx] = $this->enrich_row($row);
        }
        return $rows;
    }
}
