<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perawatan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sewa_model');
    }

    private function _apply_filters($filters = array())
    {
        if (!empty($filters['bulan'])) {
            $parts = explode('-', $filters['bulan']);
            if (count($parts) === 2) {
                $this->db->where('YEAR(p.tanggal_transaksi)', (int) $parts[0]);
                $this->db->where('MONTH(p.tanggal_transaksi)', (int) $parts[1]);
            }
        }

        if (!empty($filters['jenis_biaya']) && in_array($filters['jenis_biaya'], array('servis', 'asuransi', 'pajak', 'lainnya'), true)) {
            $this->db->where('p.jenis_biaya', $filters['jenis_biaya']);
        }

        if (!empty($filters['id_unit'])) {
            $this->db->where('p.id_unit', (int) $filters['id_unit']);
        }

        if (!empty($filters['status_perawatan']) && in_array($filters['status_perawatan'], array('Proses', 'Selesai'), true)) {
            $this->db->where('p.status_perawatan', $filters['status_perawatan']);
        }

        if (!empty($filters['search'])) {
            $kw = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('p.nama_unit', $kw);
            $this->db->or_like('p.plat_nomor', $kw);
            $this->db->or_like('p.judul_biaya', $kw);
            $this->db->or_like('p.vendor_bengkel', $kw);
            $this->db->or_like('p.keterangan', $kw);
            $this->db->group_end();
        }
    }

    public function get_all($filters = array(), $order_dir = 'DESC')
    {
        $this->db->select('p.*');
        $this->db->from('unit_perawatan_biaya p');
        $this->_apply_filters($filters);
        $this->db->order_by('p.tanggal_transaksi', $order_dir);
        $this->db->order_by('p.id_perawatan', $order_dir);
        $rows = $this->db->get()->result();

        $today_ts = strtotime(date('Y-m-d'));
        foreach ($rows as $r) {
            $r->due_days_left = null;
            $r->due_status = 'none';
            if (!empty($r->tanggal_jatuh_tempo) && $r->tanggal_jatuh_tempo !== '0000-00-00') {
                $due_ts = strtotime($r->tanggal_jatuh_tempo);
                $diff = (int) round(($due_ts - $today_ts) / 86400);
                $r->due_days_left = $diff;
                if ($diff < 0) {
                    $r->due_status = 'overdue';
                } elseif ($diff <= 14) {
                    $r->due_status = 'soon';
                } else {
                    $r->due_status = 'ok';
                }
            }
        }
        return $rows;
    }

    public function get_by_id($id_perawatan)
    {
        return $this->db->get_where('unit_perawatan_biaya', array('id_perawatan' => (int) $id_perawatan))->row();
    }

    public function get_summary($filters = array())
    {
        $rows = $this->get_all($filters, 'DESC');
        $summary = array(
            'total_biaya'       => 0,
            'total_servis'      => 0,
            'total_asuransi'    => 0,
            'total_pajak'       => 0,
            'total_lainnya'     => 0,
            'jumlah_record'     => count($rows),
            'sedang_servis'     => 0,
            'jatuh_tempo_dekat' => 0
        );

        foreach ($rows as $r) {
            $nom = (float) $r->nominal;
            $summary['total_biaya'] += $nom;
            if ($r->jenis_biaya === 'servis') {
                $summary['total_servis'] += $nom;
            } elseif ($r->jenis_biaya === 'asuransi') {
                $summary['total_asuransi'] += $nom;
            } elseif ($r->jenis_biaya === 'pajak') {
                $summary['total_pajak'] += $nom;
            } else {
                $summary['total_lainnya'] += $nom;
            }
            if ($r->status_perawatan === 'Proses') {
                $summary['sedang_servis']++;
            }
            if ($r->due_status === 'overdue' || $r->due_status === 'soon') {
                $summary['jatuh_tempo_dekat']++;
            }
        }
        return $summary;
    }

    /**
     * Daftar jatuh tempo terdekat (H-14 atau sudah lewat) untuk ditampilkan di halaman Perawatan.
     */
    public function get_upcoming_due($days = 14)
    {
        $limit_date = date('Y-m-d', strtotime('+' . (int) $days . ' days'));
        $rows = $this->db
            ->from('unit_perawatan_biaya')
            ->where('tanggal_jatuh_tempo IS NOT NULL', null, false)
            ->where('tanggal_jatuh_tempo !=', '0000-00-00')
            ->where('tanggal_jatuh_tempo <=', $limit_date)
            ->order_by('tanggal_jatuh_tempo', 'ASC')
            ->get()
            ->result();

        $today_ts = strtotime(date('Y-m-d'));
        foreach ($rows as $r) {
            $r->due_days_left = (int) round((strtotime($r->tanggal_jatuh_tempo) - $today_ts) / 86400);
        }
        return $rows;
    }

    /**
     * Tren biaya perawatan per bulan untuk N bulan terakhir (sinkron dengan Dashboard).
     */
    public function get_monthly_expense_trend($months = 6)
    {
        $months = max(2, min(12, (int) $months));
        $base_first = strtotime(date('Y-m-01'));
        $start_date = date('Y-m-01', strtotime('-' . ($months - 1) . ' months', $base_first));
        $end_date   = date('Y-m-t', $base_first);

        $buckets = array();
        for ($i = $months - 1; $i >= 0; $i--) {
            $ym = date('Y-m', strtotime('-' . $i . ' months', $base_first));
            $buckets[$ym] = array(
                'total_biaya' => 0,
                'servis'      => 0,
                'asuransi'    => 0,
                'pajak'       => 0,
                'lainnya'     => 0
            );
        }

        $rows = $this->db
            ->select("DATE_FORMAT(tanggal_transaksi, '%Y-%m') AS ym, "
                . "COALESCE(SUM(nominal), 0) AS total_biaya, "
                . "COALESCE(SUM(CASE WHEN jenis_biaya = 'servis' THEN nominal ELSE 0 END), 0) AS servis, "
                . "COALESCE(SUM(CASE WHEN jenis_biaya = 'asuransi' THEN nominal ELSE 0 END), 0) AS asuransi, "
                . "COALESCE(SUM(CASE WHEN jenis_biaya = 'pajak' THEN nominal ELSE 0 END), 0) AS pajak, "
                . "COALESCE(SUM(CASE WHEN jenis_biaya = 'lainnya' THEN nominal ELSE 0 END), 0) AS lainnya")
            ->from('unit_perawatan_biaya')
            ->where('tanggal_transaksi >=', $start_date)
            ->where('tanggal_transaksi <=', $end_date)
            ->group_by("DATE_FORMAT(tanggal_transaksi, '%Y-%m')")
            ->get()
            ->result();

        foreach ($rows as $r) {
            if (isset($buckets[$r->ym])) {
                $buckets[$r->ym] = array(
                    'total_biaya' => (float) $r->total_biaya,
                    'servis'      => (float) $r->servis,
                    'asuransi'    => (float) $r->asuransi,
                    'pajak'       => (float) $r->pajak,
                    'lainnya'     => (float) $r->lainnya
                );
            }
        }

        $out = array(
            'months'      => array_keys($buckets),
            'total_biaya' => array(),
            'servis'      => array(),
            'asuransi'    => array(),
            'pajak'       => array(),
            'lainnya'     => array()
        );
        foreach ($buckets as $b) {
            $out['total_biaya'][] = $b['total_biaya'];
            $out['servis'][]      = $b['servis'];
            $out['asuransi'][]    = $b['asuransi'];
            $out['pajak'][]       = $b['pajak'];
            $out['lainnya'][]     = $b['lainnya'];
        }
        return $out;
    }

    public function insert($data)
    {
        $this->db->insert('unit_perawatan_biaya', $data);
        $id = $this->db->insert_id();
        if (!empty($data['id_unit'])) {
            $this->Sewa_model->sync_unit_mobil_status((int) $data['id_unit']);
        }
        return $id;
    }

    public function update($id_perawatan, $data)
    {
        $old = $this->get_by_id($id_perawatan);
        if (!$old) {
            return false;
        }
        $this->db->where('id_perawatan', (int) $id_perawatan)->update('unit_perawatan_biaya', $data);

        if (!empty($old->id_unit)) {
            $this->Sewa_model->sync_unit_mobil_status((int) $old->id_unit);
        }
        if (!empty($data['id_unit']) && (int) $data['id_unit'] !== (int) $old->id_unit) {
            $this->Sewa_model->sync_unit_mobil_status((int) $data['id_unit']);
        }
        return true;
    }

    public function mark_selesai($id_perawatan)
    {
        $row = $this->get_by_id($id_perawatan);
        if (!$row) {
            return false;
        }
        $this->db->where('id_perawatan', (int) $id_perawatan)->update('unit_perawatan_biaya', array(
            'status_perawatan' => 'Selesai'
        ));
        if (!empty($row->id_unit)) {
            $this->Sewa_model->sync_unit_mobil_status((int) $row->id_unit);
        }
        return true;
    }

    public function delete($id_perawatan)
    {
        $row = $this->get_by_id($id_perawatan);
        if (!$row) {
            return false;
        }
        $this->db->where('id_perawatan', (int) $id_perawatan)->delete('unit_perawatan_biaya');
        if (!empty($row->id_unit)) {
            $this->Sewa_model->sync_unit_mobil_status((int) $row->id_unit);
        }
        return true;
    }
}

