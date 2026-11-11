<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontrak_model extends CI_Model
{
    public function generate_no_kontrak($tanggal = null)
    {
        $ts = $tanggal ? strtotime($tanggal) : time();
        $romawi = bulan_romawi(date('n', $ts));
        $tahun = date('Y', $ts);
        $suffix = '/GT/KONTRAK/' . $romawi . '/' . $tahun;

        $this->db->select('no_kontrak');
        $this->db->from('rental_kontrak');
        $this->db->like('no_kontrak', $suffix, 'before');
        $this->db->order_by('id_kontrak', 'DESC');
        $this->db->limit(1);
        $last = $this->db->get()->row();

        $next = 1;
        if ($last && !empty($last->no_kontrak)) {
            $parts = explode('/', $last->no_kontrak);
            $first_num = (int) $parts[0];
            if ($first_num > 0) {
                $next = $first_num + 1;
            }
        }

        do {
            $candidate = str_pad($next, 3, '0', STR_PAD_LEFT) . $suffix;
            $exists = $this->db->where('no_kontrak', $candidate)->count_all_results('rental_kontrak');
            if ($exists == 0) {
                return $candidate;
            }
            $next++;
        } while (true);
    }

    public function get_all($filters = array())
    {
        $this->db->select('rk.*, '
            . 'COALESCE(rb.no_invoice, rt.no_invoice) AS no_invoice, '
            . 'COALESCE(rb.nama_user, rt.nama_user, rk.nama_perusahaan, rk.penanggung_jawab) AS nama_user, '
            . 'COALESCE(rb.no_hp_user, rt.no_hp_user, rk.no_hp) AS no_hp_user, '
            . 'rt.tipe_unit, rt.plat_nomor, rt.warna, '
            . 'COALESCE(rt.tanggal_mulai, rk.tanggal_mulai) AS eff_tanggal_mulai, '
            . 'COALESCE(rt.tanggal_selesai, rk.tanggal_selesai) AS eff_tanggal_selesai, '
            . 'rt.hari, rt.harga_user, rt.total_masuk, rt.asal_unit, rt.nama_unit_asal, rt.status AS status_sewa, '
            . '(SELECT COUNT(*) FROM rental_transaksi rt2 WHERE rt2.id_booking = COALESCE(rk.id_booking, rt.id_booking)) AS jumlah_unit, '
            . '(SELECT COALESCE(SUM(rt3.total_masuk),0) FROM rental_transaksi rt3 WHERE rt3.id_booking = COALESCE(rk.id_booking, rt.id_booking)) AS total_tagihan_booking, '
            . '(SELECT GROUP_CONCAT(CONCAT(rt4.tipe_unit, " (", rt4.plat_nomor, ")") SEPARATOR ", ") FROM rental_transaksi rt4 WHERE rt4.id_booking = COALESCE(rk.id_booking, rt.id_booking)) AS daftar_unit');
        $this->db->from('rental_kontrak rk');
        $this->db->join('rental_transaksi rt', 'rt.id_sewa = rk.id_sewa', 'left');
        $this->db->join('rental_booking rb', 'rb.id_booking = COALESCE(rk.id_booking, rt.id_booking)', 'left');

        if (!empty($filters['status_kontrak'])) {
            $this->db->where('rk.status_kontrak', $filters['status_kontrak']);
        }

        if (!empty($filters['search'])) {
            $q = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('rk.no_kontrak', $q);
            $this->db->or_like('rk.nama_perusahaan', $q);
            $this->db->or_like('rk.penanggung_jawab', $q);
            $this->db->or_like('rk.objek_unit_json', $q);
            $this->db->or_like('rt.no_invoice', $q);
            $this->db->or_like('rt.nama_user', $q);
            $this->db->or_like('rt.plat_nomor', $q);
            $this->db->or_like('rt.tipe_unit', $q);
            $this->db->or_like('rk.nik_ktp', $q);
            $this->db->group_end();
        }

        $this->db->order_by('rk.id_kontrak', 'DESC');
        $rows = $this->db->get()->result();

        foreach ($rows as $idx => $r) {
            $r->tanggal_mulai = $r->eff_tanggal_mulai;
            $r->tanggal_selesai = $r->eff_tanggal_selesai;
            $r->sudah_tagihan = !empty($r->id_sewa);

            if (empty($r->id_sewa)) {
                $decoded = !empty($r->objek_unit_json) ? json_decode($r->objek_unit_json, true) : array();
                if (!is_array($decoded)) {
                    $decoded = array();
                }
                $r->jumlah_unit = count($decoded);
                $r->total_tagihan_booking = (float) $r->nilai_kontrak;
                $names = array();
                foreach ($decoded as $du) {
                    $names[] = (isset($du['tipe_unit']) ? $du['tipe_unit'] : '-') . ' (' . (isset($du['plat_nomor']) ? $du['plat_nomor'] : '-') . ')';
                }
                $r->daftar_unit = implode(', ', $names);
                if (!empty($decoded[0])) {
                    $r->tipe_unit = isset($decoded[0]['tipe_unit']) ? $decoded[0]['tipe_unit'] : '';
                    $r->plat_nomor = isset($decoded[0]['plat_nomor']) ? $decoded[0]['plat_nomor'] : '';
                    $r->warna = isset($decoded[0]['warna']) ? $decoded[0]['warna'] : $r->warna_unit;
                }
                $r->hari = (!empty($r->tanggal_mulai) && !empty($r->tanggal_selesai))
                    ? hitung_hari_sewa($r->tanggal_mulai, $r->tanggal_selesai)
                    : 1;
            }
            $rows[$idx] = $r;
        }

        return $rows;
    }

    public function get_by_id($id_kontrak)
    {
        $this->db->select('rk.*, '
            . 'COALESCE(rb.no_invoice, rt.no_invoice) AS no_invoice, '
            . 'COALESCE(rb.nama_user, rt.nama_user, rk.nama_perusahaan, rk.penanggung_jawab) AS nama_user, '
            . 'COALESCE(rb.no_hp_user, rt.no_hp_user, rk.no_hp) AS no_hp_user, '
            . 'COALESCE(rb.alamat_user, rt.alamat_user, rk.alamat_penyewa) AS alamat_user, '
            . 'COALESCE(rb.status_pembayaran, rt.status_pembayaran) AS status_pembayaran, '
            . 'COALESCE(rb.jumlah_dp, rt.jumlah_dp) AS jumlah_dp, '
            . 'rt.id_booking AS transaksi_id_booking, rt.tipe_unit, rt.plat_nomor, rt.warna, '
            . 'COALESCE(rt.tanggal_mulai, rk.tanggal_mulai) AS eff_tanggal_mulai, '
            . 'COALESCE(rt.tanggal_selesai, rk.tanggal_selesai) AS eff_tanggal_selesai, '
            . 'rt.hari, rt.harga_user, rt.total_masuk, rt.asal_unit, rt.nama_unit_asal, rt.status AS status_sewa');
        $this->db->from('rental_kontrak rk');
        $this->db->join('rental_transaksi rt', 'rt.id_sewa = rk.id_sewa', 'left');
        $this->db->join('rental_booking rb', 'rb.id_booking = COALESCE(rk.id_booking, rt.id_booking)', 'left');
        $this->db->where('rk.id_kontrak', (int) $id_kontrak);
        $row = $this->db->get()->row();

        if ($row) {
            $row->tanggal_mulai = $row->eff_tanggal_mulai;
            $row->tanggal_selesai = $row->eff_tanggal_selesai;

            $units = array();
            $booking_id = !empty($row->id_booking) ? (int) $row->id_booking : (int) $row->transaksi_id_booking;
            if (!empty($row->id_sewa)) {
                if ($booking_id > 0) {
                    $units = $this->db
                        ->where('id_booking', $booking_id)
                        ->order_by('id_sewa', 'ASC')
                        ->get('rental_transaksi')
                        ->result();
                } else {
                    $units = $this->db->where('id_sewa', (int) $row->id_sewa)->get('rental_transaksi')->result();
                }
            }

            $row->sudah_tagihan = (!empty($row->id_sewa) && !empty($units));

            if (empty($units) && !empty($row->objek_unit_json)) {
                // Kontrak standalone (belum dibuatkan tagihan/invoice atau tagihannya dihapus)
                $decoded = json_decode($row->objek_unit_json, true);
                $hari_k = (!empty($row->tanggal_mulai) && !empty($row->tanggal_selesai))
                    ? hitung_hari_sewa($row->tanggal_mulai, $row->tanggal_selesai)
                    : 1;
                if (is_array($decoded)) {
                    foreach ($decoded as $du) {
                        $sub = isset($du['nilai_sewa']) ? (float) $du['nilai_sewa'] : (float) $row->nilai_kontrak;
                        $units[] = (object) array(
                            'tipe_unit'       => isset($du['tipe_unit']) ? $du['tipe_unit'] : '',
                            'plat_nomor'      => isset($du['plat_nomor']) ? $du['plat_nomor'] : '',
                            'warna'           => isset($du['warna']) ? $du['warna'] : $row->warna_unit,
                            'tanggal_mulai'   => $row->tanggal_mulai,
                            'tanggal_selesai' => $row->tanggal_selesai,
                            'hari'            => $hari_k,
                            'harga_user'      => ($hari_k > 0) ? round($sub / $hari_k, 2) : $sub,
                            'total_masuk'     => $sub,
                            'asal_unit'       => isset($du['asal_unit']) ? $du['asal_unit'] : 'garasi',
                            'id_unit'         => isset($du['id_unit']) ? $du['id_unit'] : null,
                            'nama_unit_asal'  => isset($du['nama_unit_asal']) ? $du['nama_unit_asal'] : 'Garasi',
                            'rent_to_rent'    => isset($du['rent_to_rent']) ? (float) $du['rent_to_rent'] : 0
                        );
                    }
                }
            }

            $total_all = 0;
            foreach ($units as $u) {
                $total_all += (float) $u->total_masuk;
            }
            if ($total_all <= 0 && (float) $row->nilai_kontrak > 0) {
                $total_all = (float) $row->nilai_kontrak;
            }
            $row->units = $units;
            $row->total_tagihan_booking = $total_all;
        }
        return $row;
    }

    public function get_by_sewa($id_sewa)
    {
        $sewa = $this->db->get_where('rental_transaksi', array('id_sewa' => (int) $id_sewa))->row();
        if (!$sewa) {
            return null;
        }
        if (!empty($sewa->id_booking)) {
            $k = $this->db
                ->where('id_booking', (int) $sewa->id_booking)
                ->order_by('id_kontrak', 'DESC')
                ->get('rental_kontrak')
                ->row();
            if ($k) {
                return $k;
            }
        }
        return $this->db
            ->where('id_sewa', (int) $id_sewa)
            ->order_by('id_kontrak', 'DESC')
            ->get('rental_kontrak')
            ->row();
    }

    public function get_sewa_options()
    {
        $this->db->select('rb.id_booking, rb.no_invoice, rb.nama_user, rb.no_hp_user, rb.alamat_user, '
            . 'MIN(rt.id_sewa) AS id_sewa, '
            . 'COUNT(rt.id_sewa) AS jumlah_unit, '
            . 'GROUP_CONCAT(CONCAT(rt.tipe_unit, " / ", rt.plat_nomor) SEPARATOR ", ") AS daftar_unit, '
            . 'SUM(rt.total_masuk) AS total_tagihan, '
            . 'MAX(CASE WHEN rt.status = "Open" THEN "Open" ELSE "Selesai" END) AS status, '
            . '(SELECT COUNT(*) FROM rental_kontrak rk WHERE rk.id_booking = rb.id_booking OR rk.id_sewa = MIN(rt.id_sewa)) AS sudah_kontrak');
        $this->db->from('rental_booking rb');
        $this->db->join('rental_transaksi rt', 'rt.id_booking = rb.id_booking', 'inner');
        $this->db->group_by('rb.id_booking');
        $this->db->order_by('rb.id_booking', 'DESC');
        return $this->db->get()->result();
    }

    public function default_syarat_ketentuan()
    {
        return "1. Penyewa wajib menggunakan kendaraan sesuai tujuan yang disepakati dan dilarang memindahtangankan, menggadaikan, atau menyewakan kembali kendaraan kepada pihak ketiga.\n"
            . "2. Penyewa bertanggung jawab penuh atas keamanan kendaraan, kelengkapan surat (STNK), BBM, biaya tol, parkir, serta denda tilang/pelanggaran lalu lintas selama masa sewa.\n"
            . "3. Apabila terjadi perpanjangan masa sewa, Penyewa wajib mengonfirmasi kepada CV. Graha Transport sebelum masa sewa berakhir dan biaya sewa harian tetap terhitung sesuai tarif yang disepakati.\n"
            . "4. Keterlambatan pengembalian tanpa konfirmasi dikenakan denda sesuai ketentuan yang berlaku dan tarif sewa harian tetap berjalan.\n"
            . "5. Kerusakan atau kehilangan akibat kelalaian Penyewa menjadi tanggung jawab penuh Penyewa.";
    }

    public function insert_kontrak($data)
    {
        $this->db->insert('rental_kontrak', $data);
        return $this->db->insert_id();
    }

    public function update_kontrak($id_kontrak, $data)
    {
        return $this->db->where('id_kontrak', (int) $id_kontrak)->update('rental_kontrak', $data);
    }

    public function delete_kontrak($id_kontrak)
    {
        return $this->db->where('id_kontrak', (int) $id_kontrak)->delete('rental_kontrak');
    }
}
