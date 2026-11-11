<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontrak extends AUTH_Controller
{
    var $template = 'template/index';

    public function __construct()
    {
        parent::__construct();
        $this->require_roles(array('Admin', 'Owner', 'admin_oprational'));
        $this->load->model('Kontrak_model');
        $this->load->model('Sewa_model');
        $this->load->helper('rental');
    }

    public function index()
    {
        $data['tittle']          = 'Graha Transport | Kontrak Sewa Mobil';
        $data['userdata']        = $this->userdata;
        $data['sewa_options']    = $this->Kontrak_model->get_sewa_options();
        $data['unit_garasi']     = $this->Sewa_model->get_unit_garasi_list();
        $data['vendor_list']     = $this->Sewa_model->get_vendor_suggestions();
        $data['default_syarat']  = $this->Kontrak_model->default_syarat_ketentuan();
        $data['preselect_sewa']  = (int) $this->input->get('id_sewa');
        $data['content']         = 'page_admin/kontrak/kontrak';
        $data['script']          = 'page_admin/kontrak/kontrak_js';
        $this->load->view($this->template, $data);
    }

    public function fetch()
    {
        $filters = array(
            'status_kontrak' => trim((string) $this->input->post('status_kontrak')),
            'search'         => trim((string) $this->input->post('search'))
        );

        $rows = $this->Kontrak_model->get_all($filters);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'status' => 'success',
                'rows'   => $rows
            )));
    }

    public function get_detail()
    {
        $id_kontrak = (int) $this->input->post('id_kontrak');
        $kontrak = $this->Kontrak_model->get_by_id($id_kontrak);
        if (!$kontrak) {
            echo json_encode(array('status' => 'error', 'message' => 'Data kontrak tidak ditemukan.'));
            return;
        }
        echo json_encode(array('status' => 'success', 'data' => $kontrak));
    }

    public function get_sewa_info()
    {
        $id_sewa = (int) $this->input->post('id_sewa');
        $sewa = $this->Sewa_model->get_by_id($id_sewa);
        if (!$sewa) {
            echo json_encode(array('status' => 'error', 'message' => 'Data sewa tidak ditemukan.'));
            return;
        }
        $booking = !empty($sewa->id_booking) ? $this->Sewa_model->get_booking_by_id($sewa->id_booking) : null;
        $total_hari = (int) $sewa->hari;
        $jangka_waktu_default = format_jangka_waktu_id($total_hari);

        echo json_encode(array(
            'status'               => 'success',
            'data'                 => $sewa,
            'booking'              => $booking,
            'jangka_waktu_default' => $jangka_waktu_default
        ));
    }

    private function _parse_kontrak_units_post()
    {
        $units_post = $this->input->post('k_units');
        if (!is_array($units_post) || empty($units_post)) {
            $tipe = trim((string) $this->input->post('baru_tipe_unit', true));
            $plat = strtoupper(trim((string) $this->input->post('baru_plat_nomor', true)));
            $warna = trim((string) $this->input->post('warna_unit', true));
            $nilai = (float) $this->input->post('baru_total_kontrak');
            if ($tipe !== '' || $plat !== '') {
                $units_post = array(array(
                    'tipe_unit'  => $tipe,
                    'plat_nomor' => $plat,
                    'warna'      => $warna,
                    'nilai_sewa' => $nilai
                ));
            } else {
                $units_post = array();
            }
        }

        $clean = array();
        $total_nilai = 0;
        foreach ($units_post as $idx => $u) {
            $num = $idx + 1;
            $tipe = isset($u['tipe_unit']) ? trim((string) $u['tipe_unit']) : '';
            $plat = isset($u['plat_nomor']) ? strtoupper(trim((string) $u['plat_nomor'])) : '';
            $warna = isset($u['warna']) ? trim((string) $u['warna']) : '';
            $nilai = isset($u['nilai_sewa']) ? (float) $u['nilai_sewa'] : 0;

            if ($tipe === '' || $plat === '') {
                return array('error' => "Unit Kontrak #{$num}: Jenis/Merk Kendaraan dan Nomor Polisi wajib diisi.");
            }

            $clean[] = array(
                'tipe_unit'  => $tipe,
                'plat_nomor' => $plat,
                'warna'      => $warna ?: 'Hitam',
                'nilai_sewa' => $nilai
            );
            $total_nilai += $nilai;
        }

        if (empty($clean)) {
            return array('error' => 'Minimal 1 unit kendaraan wajib diisi.');
        }

        return array('units' => $clean, 'total_nilai' => $total_nilai);
    }

    public function simpan()
    {
        $mode_sumber = trim((string) $this->input->post('mode_sumber'));
        if ($mode_sumber === '') {
            $mode_sumber = 'existing';
        }

        $this->form_validation->set_rules('tanggal_kontrak', 'Tanggal Kontrak', 'required');
        $this->form_validation->set_rules('alamat_penyewa', 'Alamat Kantor / Lokasi', 'required|trim');

        if ($mode_sumber === 'kontrak_dulu') {
            $this->form_validation->set_rules('penanggung_jawab', 'Penanggung Jawab / Nama Penyewa', 'required|trim');
            $this->form_validation->set_rules('baru_tanggal_mulai', 'Tanggal Mulai', 'required');
            $this->form_validation->set_rules('baru_tanggal_selesai', 'Tanggal Selesai', 'required');
        } else {
            $this->form_validation->set_rules('id_sewa', 'Transaksi Sewa', 'required|integer');
        }

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(array(
                'status'  => 'error',
                'message' => strip_tags(validation_errors(' ', ' '))
            ));
            return;
        }

        $id_sewa = null;
        $id_booking = null;
        $tgl_mulai = null;
        $tgl_selesai = null;
        $nilai_kontrak = 0;
        $objek_unit_json = null;
        $hari_kontrak = 1;

        $nama_perusahaan = trim((string) $this->input->post('nama_perusahaan', true));
        $penanggung_jawab = trim((string) $this->input->post('penanggung_jawab', true));
        $no_hp = trim((string) $this->input->post('no_hp', true));
        $alamat_penyewa = trim((string) $this->input->post('alamat_penyewa', true));

        if ($mode_sumber === 'kontrak_dulu') {
            $tgl_mulai = $this->input->post('baru_tanggal_mulai', true);
            $tgl_selesai = $this->input->post('baru_tanggal_selesai', true);
            if (strtotime($tgl_selesai) < strtotime($tgl_mulai)) {
                echo json_encode(array('status' => 'error', 'message' => 'Tanggal Selesai tidak boleh lebih kecil dari Tanggal Mulai.'));
                return;
            }
            $parsedUnits = $this->_parse_kontrak_units_post();
            if (isset($parsedUnits['error'])) {
                echo json_encode(array('status' => 'error', 'message' => $parsedUnits['error']));
                return;
            }
            $hari_kontrak = hitung_hari_sewa($tgl_mulai, $tgl_selesai);
            $nilai_kontrak = (float) $parsedUnits['total_nilai'];
            $objek_unit_json = json_encode($parsedUnits['units']);
        } else {
            $id_sewa = (int) $this->input->post('id_sewa');
            $sewa = $this->Sewa_model->get_by_id($id_sewa);
            if (!$sewa) {
                echo json_encode(array('status' => 'error', 'message' => 'Transaksi sewa tidak valid.'));
                return;
            }
            $id_booking = !empty($sewa->id_booking) ? (int) $sewa->id_booking : null;
            $tgl_mulai = $sewa->tanggal_mulai;
            $tgl_selesai = $sewa->tanggal_selesai;
            $hari_kontrak = (int) $sewa->hari;
            if ($penanggung_jawab === '') {
                $penanggung_jawab = $sewa->nama_user;
            }
        }

        $tgl_kontrak = $this->input->post('tanggal_kontrak', true);
        $syarat = trim((string) $this->input->post('syarat_ketentuan', true));
        if ($syarat === '') {
            $syarat = $this->Kontrak_model->default_syarat_ketentuan();
        }

        $status_kontrak = $this->input->post('status_kontrak', true);
        if (!in_array($status_kontrak, array('Aktif', 'Selesai', 'Dibatalkan'), true)) {
            $status_kontrak = 'Aktif';
        }

        $jangka_waktu = trim((string) $this->input->post('jangka_waktu_label', true));
        if ($jangka_waktu === '') {
            $jangka_waktu = format_jangka_waktu_id($hari_kontrak);
        }

        $skema = trim((string) $this->input->post('skema_pembayaran', true));
        if ($skema === '') {
            $skema = 'Pembayaran biaya sewa dilakukan oleh PIHAK KEDUA langsung di awal sejumlah tersebut.';
        }

        $pihak_pertama = trim((string) $this->input->post('pihak_pertama_nama', true)) ?: 'Anggun Suryo Adi Nugroho';
        $bank_nama = trim((string) $this->input->post('bank_nama', true)) ?: 'BCA';
        $bank_no_rek = trim((string) $this->input->post('bank_no_rek', true)) ?: '2222 333 033';
        $bank_atas_nama = trim((string) $this->input->post('bank_atas_nama', true)) ?: 'GRAHA TRANSPORT CV';

        $data = array(
            'no_kontrak'         => $this->Kontrak_model->generate_no_kontrak($tgl_kontrak),
            'id_booking'         => $id_booking,
            'id_sewa'            => $id_sewa,
            'tanggal_kontrak'    => $tgl_kontrak,
            'nama_perusahaan'    => $nama_perusahaan,
            'penanggung_jawab'   => $penanggung_jawab,
            'pihak_pertama_nama' => $pihak_pertama,
            'nik_ktp'            => trim((string) $this->input->post('nik_ktp', true)),
            'no_sim'             => trim((string) $this->input->post('no_sim', true)),
            'no_hp'              => $no_hp,
            'alamat_penyewa'     => $alamat_penyewa,
            'jaminan'            => trim((string) $this->input->post('jaminan', true)),
            'tujuan_pemakaian'   => trim((string) $this->input->post('tujuan_pemakaian', true)),
            'warna_unit'         => trim((string) $this->input->post('warna_unit', true)),
            'jangka_waktu_label' => $jangka_waktu,
            'skema_pembayaran'   => $skema,
            'bank_nama'          => $bank_nama,
            'bank_no_rek'        => $bank_no_rek,
            'bank_atas_nama'     => $bank_atas_nama,
            'tanggal_mulai'      => $tgl_mulai,
            'tanggal_selesai'    => $tgl_selesai,
            'nilai_kontrak'      => $nilai_kontrak,
            'objek_unit_json'    => $objek_unit_json,
            'km_awal'            => trim((string) $this->input->post('km_awal', true)),
            'bbm_awal'           => trim((string) $this->input->post('bbm_awal', true)),
            'kelengkapan'        => trim((string) $this->input->post('kelengkapan', true)),
            'catatan_kondisi'    => trim((string) $this->input->post('catatan_kondisi', true)),
            'syarat_ketentuan'   => $syarat,
            'status_kontrak'     => $status_kontrak,
            'created_by'         => isset($this->userdata->id_agency) ? (int) $this->userdata->id_agency : null
        );

        $id_kontrak = $this->Kontrak_model->insert_kontrak($data);
        if ($id_kontrak) {
            echo json_encode(array(
                'status'     => 'success',
                'message'    => ($mode_sumber === 'kontrak_dulu')
                    ? 'Surat Kontrak berhasil dibuat. Anda dapat mencetak kontrak atau menerbitkan tagihan/invoice kapan saja.'
                    : 'Kontrak sewa berhasil dibuat.',
                'id_kontrak' => $id_kontrak,
                'id_sewa'    => $id_sewa
            ));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menyimpan kontrak sewa.'));
        }
    }

    public function update()
    {
        $id_kontrak = (int) $this->input->post('id_kontrak');
        $existing = $this->Kontrak_model->get_by_id($id_kontrak);
        if (!$existing) {
            echo json_encode(array('status' => 'error', 'message' => 'Kontrak tidak ditemukan.'));
            return;
        }

        $this->form_validation->set_rules('tanggal_kontrak', 'Tanggal Kontrak', 'required');
        $this->form_validation->set_rules('alamat_penyewa', 'Alamat Kantor / Lokasi', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(array(
                'status'  => 'error',
                'message' => strip_tags(validation_errors(' ', ' '))
            ));
            return;
        }

        $status_kontrak = $this->input->post('status_kontrak', true);
        if (!in_array($status_kontrak, array('Aktif', 'Selesai', 'Dibatalkan'), true)) {
            $status_kontrak = $existing->status_kontrak;
        }

        $penanggung_jawab = trim((string) $this->input->post('penanggung_jawab', true));
        $data = array(
            'tanggal_kontrak'    => $this->input->post('tanggal_kontrak', true),
            'nama_perusahaan'    => trim((string) $this->input->post('nama_perusahaan', true)),
            'penanggung_jawab'   => $penanggung_jawab ?: $existing->penanggung_jawab,
            'pihak_pertama_nama' => trim((string) $this->input->post('pihak_pertama_nama', true)) ?: 'Anggun Suryo Adi Nugroho',
            'nik_ktp'            => trim((string) $this->input->post('nik_ktp', true)),
            'no_sim'             => trim((string) $this->input->post('no_sim', true)),
            'no_hp'              => trim((string) $this->input->post('no_hp', true)),
            'alamat_penyewa'     => trim((string) $this->input->post('alamat_penyewa', true)),
            'jaminan'            => trim((string) $this->input->post('jaminan', true)),
            'tujuan_pemakaian'   => trim((string) $this->input->post('tujuan_pemakaian', true)),
            'warna_unit'         => trim((string) $this->input->post('warna_unit', true)),
            'jangka_waktu_label' => trim((string) $this->input->post('jangka_waktu_label', true)) ?: $existing->jangka_waktu_label,
            'skema_pembayaran'   => trim((string) $this->input->post('skema_pembayaran', true)) ?: 'Pembayaran biaya sewa dilakukan oleh PIHAK KEDUA langsung di awal sejumlah tersebut.',
            'bank_nama'          => trim((string) $this->input->post('bank_nama', true)) ?: 'BCA',
            'bank_no_rek'        => trim((string) $this->input->post('bank_no_rek', true)) ?: '2222 333 033',
            'bank_atas_nama'     => trim((string) $this->input->post('bank_atas_nama', true)) ?: 'GRAHA TRANSPORT CV',
            'km_awal'            => trim((string) $this->input->post('km_awal', true)),
            'bbm_awal'           => trim((string) $this->input->post('bbm_awal', true)),
            'kelengkapan'        => trim((string) $this->input->post('kelengkapan', true)),
            'catatan_kondisi'    => trim((string) $this->input->post('catatan_kondisi', true)),
            'syarat_ketentuan'   => trim((string) $this->input->post('syarat_ketentuan', true)),
            'status_kontrak'     => $status_kontrak
        );

        if (empty($existing->id_sewa)) {
            $tgl_mulai = $this->input->post('baru_tanggal_mulai', true) ?: $existing->tanggal_mulai;
            $tgl_selesai = $this->input->post('baru_tanggal_selesai', true) ?: $existing->tanggal_selesai;
            $parsedUnits = $this->_parse_kontrak_units_post();
            if (isset($parsedUnits['error'])) {
                echo json_encode(array('status' => 'error', 'message' => $parsedUnits['error']));
                return;
            }
            $data['tanggal_mulai'] = $tgl_mulai;
            $data['tanggal_selesai'] = $tgl_selesai;
            $data['nilai_kontrak'] = (float) $parsedUnits['total_nilai'];
            $data['objek_unit_json'] = json_encode($parsedUnits['units']);
        } else {
            $id_sewa = (int) $this->input->post('id_sewa');
            $sewa = $this->Sewa_model->get_by_id($id_sewa);
            if ($sewa) {
                $data['id_sewa'] = $id_sewa;
                $data['id_booking'] = !empty($sewa->id_booking) ? (int) $sewa->id_booking : null;
            }
        }

        $this->Kontrak_model->update_kontrak($id_kontrak, $data);
        echo json_encode(array('status' => 'success', 'message' => 'Kontrak sewa berhasil diperbarui.'));
    }

    public function buat_tagihan()
    {
        $id_kontrak = (int) $this->input->post('id_kontrak');
        $k = $this->Kontrak_model->get_by_id($id_kontrak);
        if (!$k) {
            echo json_encode(array('status' => 'error', 'message' => 'Kontrak tidak ditemukan.'));
            return;
        }
        if (!empty($k->id_sewa)) {
            echo json_encode(array('status' => 'error', 'message' => 'Kontrak ini sudah memiliki tagihan/invoice (' . $k->no_invoice . ').'));
            return;
        }

        $units_cfg = $this->input->post('tagihan_units');
        $tgl_mulai = $k->tanggal_mulai ?: $k->tanggal_kontrak;
        $tgl_selesai = $k->tanggal_selesai ?: $k->tanggal_kontrak;
        $hari = hitung_hari_sewa($tgl_mulai, $tgl_selesai);

        $items = array();
        $grand_total = 0;

        foreach ($k->units as $idx => $u) {
            $cfg = (is_array($units_cfg) && isset($units_cfg[$idx])) ? $units_cfg[$idx] : array();
            $asal = (isset($cfg['asal_unit']) && $cfg['asal_unit'] === 'luar') ? 'luar' : 'garasi';
            $id_unit = ($asal === 'garasi' && !empty($cfg['id_unit'])) ? (int) $cfg['id_unit'] : null;
            $vendor = ($asal === 'garasi') ? 'Garasi' : (isset($cfg['nama_unit_asal']) ? trim((string) $cfg['nama_unit_asal']) : '');
            if ($asal === 'luar' && $vendor === '') {
                echo json_encode(array('status' => 'error', 'message' => 'Nama rental/vendor luar untuk ' . $u->tipe_unit . ' wajib diisi.'));
                return;
            }
            $rtr = ($asal === 'luar' && isset($cfg['rent_to_rent'])) ? (float) $cfg['rent_to_rent'] : 0;
            $rtr_harian = ($hari > 0 && $rtr > 0) ? round($rtr / $hari, 2) : 0;

            $nilai_unit = isset($cfg['nilai_sewa']) ? (float) $cfg['nilai_sewa'] : (float) $u->total_masuk;
            $harga_harian = ($hari > 0) ? round($nilai_unit / $hari, 2) : $nilai_unit;

            $items[] = array(
                'tanggal_mulai'       => $tgl_mulai,
                'tanggal_selesai'     => $tgl_selesai,
                'tanggal_kembali'     => null,
                'hari'                => $hari,
                'asal_unit'           => $asal,
                'id_unit'             => $id_unit,
                'nama_unit_asal'      => $vendor,
                'tipe_unit'           => $u->tipe_unit,
                'plat_nomor'          => $u->plat_nomor,
                'warna'               => $u->warna,
                'harga_user'          => $harga_harian,
                'total_masuk'         => $nilai_unit,
                'rent_to_rent_harian' => $rtr_harian,
                'rent_to_rent'        => $rtr,
                'unit_garasi'         => ($asal === 'garasi') ? $nilai_unit : 0,
                'unit_luar'           => ($asal === 'luar') ? ($nilai_unit - $rtr) : 0,
                'status'              => 'Open'
            );
            $grand_total += $nilai_unit;
        }

        if (empty($items)) {
            echo json_encode(array('status' => 'error', 'message' => 'Daftar unit pada kontrak kosong.'));
            return;
        }

        $status_pembayaran = $this->input->post('status_pembayaran', true);
        if (!in_array($status_pembayaran, array('Belum Lunas', 'DP', 'Lunas'), true)) {
            $status_pembayaran = 'Belum Lunas';
        }
        $jumlah_dp = ($status_pembayaran === 'DP')
            ? (float) $this->input->post('jumlah_dp')
            : ($status_pembayaran === 'Lunas' ? $grand_total : 0);

        $nama_user = !empty($k->nama_perusahaan) ? $k->nama_perusahaan : ($k->penanggung_jawab ?: 'Penyewa');
        $no_invoice = $this->Sewa_model->generate_no_invoice($tgl_mulai);

        $booking_data = array(
            'no_invoice'        => $no_invoice,
            'nama_user'         => $nama_user,
            'no_hp_user'        => $k->no_hp,
            'alamat_user'       => $k->alamat_penyewa,
            'status_pembayaran' => $status_pembayaran,
            'jumlah_dp'         => $jumlah_dp,
            'catatan'           => 'Tagihan dari Kontrak ' . $k->no_kontrak,
            'created_by'        => isset($this->userdata->id_agency) ? (int) $this->userdata->id_agency : null
        );

        $res = $this->Sewa_model->insert_booking($booking_data, $items);
        if (!$res) {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menerbitkan tagihan dari kontrak.'));
            return;
        }

        $this->Kontrak_model->update_kontrak($id_kontrak, array(
            'id_booking' => (int) $res['id_booking'],
            'id_sewa'    => (int) $res['id_sewa']
        ));

        echo json_encode(array(
            'status'     => 'success',
            'message'    => 'Tagihan / Invoice ' . $no_invoice . ' berhasil diterbitkan dan masuk ke Manajemen Sewa.',
            'id_booking' => (int) $res['id_booking'],
            'id_sewa'    => (int) $res['id_sewa'],
            'no_invoice' => $no_invoice
        ));
    }

    public function update_status()
    {
        $id_kontrak = (int) $this->input->post('id_kontrak');
        $status_kontrak = $this->input->post('status_kontrak', true);
        if (!in_array($status_kontrak, array('Aktif', 'Selesai', 'Dibatalkan'), true)) {
            echo json_encode(array('status' => 'error', 'message' => 'Status kontrak tidak valid.'));
            return;
        }
        $this->Kontrak_model->update_kontrak($id_kontrak, array('status_kontrak' => $status_kontrak));
        echo json_encode(array('status' => 'success', 'message' => 'Status kontrak berhasil diperbarui.'));
    }

    public function hapus()
    {
        $id_kontrak = (int) $this->input->post('id_kontrak');
        if ($this->Kontrak_model->delete_kontrak($id_kontrak)) {
            echo json_encode(array('status' => 'success', 'message' => 'Kontrak berhasil dihapus.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus kontrak.'));
        }
    }

    public function cetak_pdf($id_kontrak = 0)
    {
        $k = $this->Kontrak_model->get_by_id((int) $id_kontrak);
        if (!$k) {
            show_404();
            return;
        }

        require_once APPPATH . 'libraries/tcpdf/Tcpdf.php';

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('CV. Graha Transport');
        $pdf->SetAuthor('CV. Graha Transport');
        $pdf->SetTitle('Surat Perjanjian Kontrak Sewa Kendaraan - ' . $k->no_kontrak);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(22, 18, 22);
        $pdf->SetAutoPageBreak(true, 18);
        $pdf->AddPage();

        $units = !empty($k->units) ? $k->units : array();
        $total_biaya_all = 0;
        $min_mulai = null;
        $max_selesai = null;
        $max_hari = 1;
        foreach ($units as $u) {
            $total_biaya_all += (float) $u->total_masuk;
            if ($min_mulai === null || strtotime($u->tanggal_mulai) < strtotime($min_mulai)) {
                $min_mulai = $u->tanggal_mulai;
            }
            if ($max_selesai === null || strtotime($u->tanggal_selesai) > strtotime($max_selesai)) {
                $max_selesai = $u->tanggal_selesai;
            }
            if ((int) $u->hari > $max_hari) {
                $max_hari = (int) $u->hari;
            }
        }
        if ($min_mulai === null) {
            $min_mulai = $k->tanggal_mulai;
        }
        if ($max_selesai === null) {
            $max_selesai = $k->tanggal_selesai;
        }
        if ($total_biaya_all <= 0 && (float) $k->nilai_kontrak > 0) {
            $total_biaya_all = (float) $k->nilai_kontrak;
        }

        $tgl_kontrak_ts = strtotime($k->tanggal_kontrak);
        $hari_kontrak = nama_hari_id($k->tanggal_kontrak);
        $tgl_kontrak_str = (int) date('j', $tgl_kontrak_ts) . ' ' . nama_bulan_id(date('n', $tgl_kontrak_ts)) . ' ' . date('Y', $tgl_kontrak_ts);

        $mulai_ts = strtotime($min_mulai);
        $selesai_ts = strtotime($max_selesai);
        $tgl_mulai_str = (int) date('j', $mulai_ts) . ' ' . nama_bulan_id(date('n', $mulai_ts)) . ' ' . date('Y', $mulai_ts);
        $tgl_selesai_str = (int) date('j', $selesai_ts) . ' ' . nama_bulan_id(date('n', $selesai_ts)) . ' ' . date('Y', $selesai_ts);

        $jangka_waktu = !empty($k->jangka_waktu_label) ? $k->jangka_waktu_label : format_jangka_waktu_id($max_hari);
        $skema_pembayaran = !empty($k->skema_pembayaran) ? $k->skema_pembayaran : 'Pembayaran biaya sewa dilakukan oleh PIHAK KEDUA langsung di awal sejumlah tersebut.';
        $bank_nama = !empty($k->bank_nama) ? $k->bank_nama : 'BCA';
        $bank_no_rek = !empty($k->bank_no_rek) ? $k->bank_no_rek : '2222 333 033';
        $bank_atas_nama = !empty($k->bank_atas_nama) ? $k->bank_atas_nama : 'GRAHA TRANSPORT CV';

        $nama_perusahaan = trim((string) $k->nama_perusahaan);
        $penanggung_jawab = trim((string) $k->penanggung_jawab) ?: $k->nama_user;
        $pihak_pertama_nama = trim((string) $k->pihak_pertama_nama) ?: 'Anggun Suryo Adi Nugroho';
        $pihak_kedua_header = ($nama_perusahaan !== '') ? strtoupper($nama_perusahaan) : strtoupper($penanggung_jawab);

        $unit_list_html = '<table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt;">';
        $no = 1;
        $warna_fallback = !empty($k->warna_unit) ? $k->warna_unit : '-';
        foreach ($units as $u) {
            $warna_item = !empty($u->warna) ? $u->warna : $warna_fallback;
            $unit_list_html .= '<tr>'
                . '<td width="8%" align="right" valign="top">' . $no++ . '.&nbsp;&nbsp;</td>'
                . '<td width="30%" valign="top">Jenis / Merk Kendaraan<br/>Nomor Polisi<br/>Warna</td>'
                . '<td width="3%" valign="top">:<br/>:<br/>:</td>'
                . '<td width="59%" valign="top">' . htmlspecialchars($u->tipe_unit) . '<br/>' . htmlspecialchars($u->plat_nomor) . '<br/>' . htmlspecialchars($warna_item) . '</td>'
                . '</tr>';
            if ($no <= count($units)) {
                $unit_list_html .= '<tr><td colspan="4" height="4"></td></tr>';
            }
        }
        $unit_list_html .= '</table>';

        $pihak2_rows = '';
        if ($nama_perusahaan !== '') {
            $pihak2_rows .= '<tr><td width="32%" valign="top">Nama Perusahaan</td><td width="3%" valign="top">:</td><td width="65%">' . htmlspecialchars($nama_perusahaan) . '</td></tr>';
            $pihak2_rows .= '<tr><td width="32%" valign="top">Penanggung Jawab</td><td width="3%" valign="top">:</td><td width="65%">' . htmlspecialchars($penanggung_jawab) . '</td></tr>';
        } else {
            $pihak2_rows .= '<tr><td width="32%" valign="top">Nama Penyewa</td><td width="3%" valign="top">:</td><td width="65%">' . htmlspecialchars($penanggung_jawab) . '</td></tr>';
        }
        if (!empty($k->nik_ktp)) {
            $pihak2_rows .= '<tr><td width="32%" valign="top">NIK / No. KTP</td><td width="3%" valign="top">:</td><td width="65%">' . htmlspecialchars($k->nik_ktp) . '</td></tr>';
        }
        if (!empty($k->no_hp)) {
            $pihak2_rows .= '<tr><td width="32%" valign="top">No. Telepon / WA</td><td width="3%" valign="top">:</td><td width="65%">' . htmlspecialchars($k->no_hp) . '</td></tr>';
        }
        $pihak2_rows .= '<tr><td width="32%" valign="top">Alamat Kantor / Lokasi</td><td width="3%" valign="top">:</td><td width="65%">' . nl2br(htmlspecialchars($k->alamat_penyewa)) . '</td></tr>';

        $unit_kata = (count($units) > 1) ? count($units) . ' (' . strtolower(terbilang_id(count($units))) . ') unit kendaraan' : 'sebuah unit kendaraan';
        $nilai_formatted = format_rupiah($total_biaya_all) . ',- (' . terbilang_id($total_biaya_all) . ' Rupiah)';

        $pdf->SetFont('helvetica', '', 10.5);
        $pdf->SetTextColor(0, 0, 0);

        $html = '
        <div style="text-align:center;">
            <span style="font-size:14pt; font-weight:bold;">SURAT PERJANJIAN KONTRAK SEWA KENDARAAN</span><br/>
            <span style="font-size:10.5pt; font-style:italic;">Nomor: ' . htmlspecialchars($k->no_kontrak) . '</span>
        </div>
        <br/>
        <p style="margin-bottom:8px;">Pada hari ini, <b>' . htmlspecialchars($hari_kontrak) . '</b>, tanggal <b>' . htmlspecialchars($tgl_kontrak_str) . '</b>, yang bertanda tangan di bawah ini:</p>

        <p style="margin-bottom:4px;"><b>1. PIHAK PERTAMA (Pemberi Sewa)</b></p>
        <table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt;">
            <tr>
                <td width="32%" valign="top">Nama Perusahaan</td>
                <td width="3%" valign="top">:</td>
                <td width="65%">CV. Graha Transport</td>
            </tr>
            <tr>
                <td width="32%" valign="top">Pekerjaan / Bidang</td>
                <td width="3%" valign="top">:</td>
                <td width="65%">Penyedia Jasa Transportasi &amp; Rental Kendaraan</td>
            </tr>
            <tr>
                <td width="32%" valign="top">Alamat</td>
                <td width="3%" valign="top">:</td>
                <td width="65%">Jl. Arjuna III No.17, Mapagan, Lerep, Kec. Ungaran Bar., Kabupaten Semarang, Jawa Tengah 50519</td>
            </tr>
        </table>
        <br/>

        <p style="margin-bottom:4px;"><b>2. PIHAK KEDUA (Penyewa)</b></p>
        <table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt;">
            ' . $pihak2_rows . '
        </table>
        <br/>

        <p style="text-align:justify; line-height:1.45;">PIHAK PERTAMA dan PIHAK KEDUA secara bersama-sama selanjutnya disebut sebagai <b>PARA PIHAK</b>. PARA PIHAK dengan ini sepakat dan mengikatkan diri dalam Perjanjian Kontrak Sewa Kendaraan dengan ketentuan dan syarat-syarat yang diatur dalam pasal-pasal sebagai berikut:</p>

        <div style="text-align:center; font-weight:bold; margin-top:10px; line-height:1.5;">
            PASAL 1:<br/>OBJEK SEWA
        </div>
        <table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt; line-height:1.45;">
            <tr>
                <td width="5%" valign="top">1.</td>
                <td width="95%" align="justify">PIHAK PERTAMA menyerahkan ' . $unit_kata . ' kepada PIHAK KEDUA, dan PIHAK KEDUA menyatakan menyewa unit kendaraan tersebut dari PIHAK PERTAMA.</td>
            </tr>
            <tr>
                <td width="5%" valign="top">2.</td>
                <td width="95%" align="justify">Spesifikasi kendaraan objek sewa sebagaimana dimaksud pada ayat 1 adalah sebagai berikut:</td>
            </tr>
        </table>
        <br/>
        ' . $unit_list_html . '

        <div style="text-align:center; font-weight:bold; margin-top:12px; line-height:1.5;">
            PASAL 2:<br/>JANGKA WAKTU KONTRAK
        </div>
        <table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt; line-height:1.45;">
            <tr>
                <td width="5%" valign="top">1.</td>
                <td width="95%" align="justify">Perjanjian sewa kendaraan ini berlaku untuk jangka waktu ' . htmlspecialchars($jangka_waktu) . '.</td>
            </tr>
            <tr>
                <td width="5%" valign="top">2.</td>
                <td width="95%" align="justify">Jangka waktu sewa sebagaimana dimaksud pada ayat 1 dimulai pada tanggal ' . htmlspecialchars($tgl_mulai_str) . ' dan berakhir pada tanggal ' . htmlspecialchars($tgl_selesai_str) . '.</td>
            </tr>
        </table>

        <div style="text-align:center; font-weight:bold; margin-top:12px; line-height:1.5;">
            PASAL 3:<br/>BIAYA SEWA DAN SKEMA PEMBAYARAN
        </div>
        <table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt; line-height:1.45;">
            <tr>
                <td width="5%" valign="top">1.</td>
                <td width="95%" align="justify">Total nilai kontrak sewa kendaraan selama ' . htmlspecialchars($jangka_waktu) . ' disepakati sebesar ' . htmlspecialchars($nilai_formatted) . '.</td>
            </tr>
            <tr>
                <td width="5%" valign="top">2.</td>
                <td width="95%" align="justify">' . nl2br(htmlspecialchars($skema_pembayaran)) . '</td>
            </tr>
            <tr>
                <td width="5%" valign="top">3.</td>
                <td width="95%" align="justify">Seluruh pembayaran dilakukan melalui transfer bank ke rekening resmi PIHAK PERTAMA :</td>
            </tr>
        </table>
        <table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt; line-height:1.4;">
            <tr>
                <td width="7%"></td>
                <td width="5%">&bull;</td>
                <td width="25%">Bank</td>
                <td width="3%">:</td>
                <td width="60%">' . htmlspecialchars($bank_nama) . '</td>
            </tr>
            <tr>
                <td width="7%"></td>
                <td width="5%">&bull;</td>
                <td width="25%">Nomor Rekening</td>
                <td width="3%">:</td>
                <td width="60%">' . htmlspecialchars($bank_no_rek) . '</td>
            </tr>
            <tr>
                <td width="7%"></td>
                <td width="5%">&bull;</td>
                <td width="25%">Atas Nama</td>
                <td width="3%">:</td>
                <td width="60%">' . htmlspecialchars($bank_atas_nama) . '</td>
            </tr>
        </table>

        <div style="text-align:center; font-weight:bold; margin-top:12px; line-height:1.5;">
            PASAL 4:<br/>HAK DAN KEWAJIBAN PIHAK PERTAMA
        </div>
        <table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt; line-height:1.45;">
            <tr><td width="5%" valign="top">1.</td><td width="95%" align="justify">PIHAK PERTAMA berkewajiban menyerahkan unit kendaraan dalam kondisi bersih, terawat, dan layak jalan pada awal masa sewa.</td></tr>
            <tr><td width="5%" valign="top">2.</td><td width="95%" align="justify">PIHAK PERTAMA berkewajiban memastikan dokumen resmi kendaraan (STNK) dalam keadaan aktif dan berlaku selama masa sewa.</td></tr>
            <tr><td width="5%" valign="top">3.</td><td width="95%" align="justify">PIHAK PERTAMA berhak menerima pembayaran sewa sesuai jadwal dan nominal yang disepakati pada Pasal 3.</td></tr>
        </table>

        <div style="text-align:center; font-weight:bold; margin-top:12px; line-height:1.5;">
            PASAL 5:<br/>HAK DAN KEWAJIBAN PIHAK KEDUA
        </div>
        <table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt; line-height:1.45;">
            <tr><td width="5%" valign="top">1.</td><td width="95%" align="justify">PIHAK KEDUA berhak mempergunakan kendaraan objek sewa untuk mendukung kegiatan operasional perusahaan/penyewa.</td></tr>
            <tr><td width="5%" valign="top">2.</td><td width="95%" align="justify">PIHAK KEDUA berkewajiban melakukan pembayaran sewa secara tepat waktu sesuai ketentuan Pasal 3.</td></tr>
            <tr><td width="5%" valign="top">3.</td><td width="95%" align="justify">PIHAK KEDUA berkewajiban merawat kendaraan dengan baik, termasuk menjaga kebersihan.</td></tr>
            <tr><td width="5%" valign="top">4.</td><td width="95%" align="justify">Biaya bahan bakar, tol, parkir, dan operasional harian sepenuhnya menjadi tanggung jawab PIHAK KEDUA.</td></tr>
            <tr><td width="5%" valign="top">5.</td><td width="95%" align="justify">PIHAK KEDUA dilarang memindahtangankan, menyewakan kembali, atau mengagunkan unit kendaraan kepada pihak lain tanpa persetujuan tertulis dari PIHAK PERTAMA.</td></tr>
        </table>

        <div style="text-align:center; font-weight:bold; margin-top:12px; line-height:1.5;">
            PASAL 6:<br/>KERUSAKAN, KECELAKAAN, DAN PELANGGARAN
        </div>
        <table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt; line-height:1.45;">
            <tr><td width="5%" valign="top">1.</td><td width="95%" align="justify">Segala bentuk kerusakan kendaraan akibat kelalaian penggunaan atau kecelakaan selama masa sewa menjadi tanggung jawab PIHAK KEDUA.</td></tr>
            <tr><td width="5%" valign="top">2.</td><td width="95%" align="justify">Segala bentuk sanksi atau denda akibat pelanggaran lalu lintas (tilang / ETLE) selama masa sewa menjadi tanggung jawab penuh PIHAK KEDUA.</td></tr>
        </table>

        <div style="text-align:center; font-weight:bold; margin-top:12px; line-height:1.5;">
            PASAL 7:<br/>PENYELESAIAN PERSELISIHAN
        </div>
        <table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt; line-height:1.45;">
            <tr><td width="5%" valign="top">1.</td><td width="95%" align="justify">Apabila terjadi perselisihan atau perbedaan pendapat yang timbul dari Pelaksanaan Perjanjian ini, PARA PIHAK sepakat untuk menyelesaikannya secara musyawarah untuk mufakat.</td></tr>
            <tr><td width="5%" valign="top">2.</td><td width="95%" align="justify">Apabila musyawarah tidak mencapai mufakat, maka PARA PIHAK sepakat untuk memilih domisili hukum yang tetap di Kepaniteraan Pengadilan Negeri setempat.</td></tr>
        </table>

        <div style="text-align:center; font-weight:bold; margin-top:12px; line-height:1.5;">
            PASAL 8:<br/>PENUTUP
        </div>
        <table cellpadding="2" cellspacing="0" border="0" style="width:100%; font-size:10.5pt; line-height:1.45;">
            <tr><td width="5%" valign="top">1.</td><td width="95%" align="justify">Surat Perjanjian ini dibuat dalam rangkap 2 (dua) bermaterai, yang masing-masing mempunyai kekuatan hukum yang sama bagi PARA PIHAK.</td></tr>
            <tr><td width="5%" valign="top">2.</td><td width="95%" align="justify">Perjanjian ini berlaku sejak ditandatangani oleh PARA PIHAK pada hari dan tanggal yang telah disebutkan di awal surat ini.</td></tr>
        </table>
        <br/><br/>';

        $pdf->writeHTML($html, true, false, true, false, '');

        if ($pdf->GetY() > 225) {
            $pdf->AddPage();
        }

        $ttd_html = '
        <table cellpadding="4" cellspacing="0" border="0" style="width:100%; font-size:10.5pt;">
            <tr>
                <td width="50%" align="center" valign="top">
                    <b>PIHAK PERTAMA<br/>CV. GRAHA TRANSPORT</b><br/><br/><br/><br/><br/>
                    ' . htmlspecialchars($pihak_pertama_nama) . '
                </td>
                <td width="50%" align="center" valign="top">
                    <b>PIHAK KEDUA<br/>' . htmlspecialchars($pihak_kedua_header) . '</b><br/><br/><br/><br/><br/>
                    ' . htmlspecialchars($penanggung_jawab) . '
                </td>
            </tr>
        </table>';
        $pdf->writeHTML($ttd_html, true, false, true, false, '');

        $filename = 'Kontrak_' . str_replace('/', '_', $k->no_kontrak) . '.pdf';
        $mode = ($this->input->get('download') === '1') ? 'D' : 'I';
        $pdf->Output($filename, $mode);
    }
}
