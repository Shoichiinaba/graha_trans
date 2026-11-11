<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sewa_mobil extends AUTH_Controller
{
    var $template = 'template/index';

    public function __construct()
    {
        parent::__construct();
        $this->require_roles(array('Admin', 'Owner', 'admin_oprational'));
        $this->load->model('Sewa_model');
        $this->load->model('Kontrak_model');
        $this->load->helper('rental');
    }

    public function index()
    {
        $data['tittle']       = 'Graha Transport | Manajemen Sewa Mobil';
        $data['userdata']     = $this->userdata;
        $data['unit_garasi']  = $this->Sewa_model->get_unit_garasi_list();
        $data['vendor_list']  = $this->Sewa_model->get_vendor_suggestions();
        $data['overdue_list'] = $this->Sewa_model->get_overdue();
        $data['content']      = 'page_admin/sewa/sewa';
        $data['script']       = 'page_admin/sewa/sewa_js';
        $this->load->view($this->template, $data);
    }

    private function _collect_filters()
    {
        return array(
            'bulan'          => trim((string) $this->input->get_post('bulan')),
            'minggu'         => trim((string) $this->input->get_post('minggu')),
            'tanggal_dari'   => trim((string) $this->input->get_post('tanggal_dari')),
            'tanggal_sampai' => trim((string) $this->input->get_post('tanggal_sampai')),
            'asal_unit'      => trim((string) $this->input->get_post('asal_unit')),
            'status'         => trim((string) $this->input->get_post('status')),
            'search'         => trim((string) $this->input->get_post('search'))
        );
    }

    public function fetch()
    {
        $filters = $this->_collect_filters();
        $rows = $this->Sewa_model->get_all($filters, 'DESC');
        $grouped = $this->Sewa_model->get_grouped_by_day($filters);
        $summary = $this->Sewa_model->get_summary($filters);
        $overdue = $this->Sewa_model->get_overdue();

        $grouped_out = array();
        foreach ($grouped as $tgl => $grp) {
            $grouped_out[] = array(
                'tanggal'            => $tgl,
                'tanggal_label'      => format_hari_tanggal_id($tgl),
                'items'              => $grp['items'],
                'total_masuk'        => $grp['total_masuk'],
                'total_rent_to_rent' => $grp['total_rent_to_rent'],
                'total_unit_garasi'  => $grp['total_unit_garasi'],
                'total_unit_luar'    => $grp['total_unit_luar']
            );
        }

        $periode_label = 'Semua Periode';
        if (!empty($filters['bulan'])) {
            $parts = explode('-', $filters['bulan']);
            if (count($parts) === 2) {
                $periode_label = 'Bulan ' . nama_bulan_id($parts[1]) . ' ' . $parts[0];
                if (!empty($filters['minggu'])) {
                    $periode_label .= ' (' . label_minggu_id($filters['minggu']) . ')';
                }
            }
        } elseif (!empty($filters['tanggal_dari']) || !empty($filters['tanggal_sampai'])) {
            $dari = !empty($filters['tanggal_dari']) ? format_tanggal_panjang_id($filters['tanggal_dari']) : '...';
            $sampai = !empty($filters['tanggal_sampai']) ? format_tanggal_panjang_id($filters['tanggal_sampai']) : '...';
            $periode_label = 'Periode ' . $dari . ' s/d ' . $sampai;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'status'        => 'success',
                'periode_label' => $periode_label,
                'summary'       => $summary,
                'overdue'       => $overdue,
                'rows'          => $rows,
                'grouped'       => $grouped_out
            )));
    }

    public function get_detail()
    {
        $id_sewa = (int) $this->input->post('id_sewa');
        $sewa = $this->Sewa_model->get_by_id($id_sewa);
        if (!$sewa) {
            echo json_encode(array('status' => 'error', 'message' => 'Data sewa tidak ditemukan.'));
            return;
        }
        $perpanjangan = $this->Sewa_model->get_perpanjangan($id_sewa);
        $kontrak = $this->Kontrak_model->get_by_sewa($id_sewa);
        $booking = !empty($sewa->id_booking) ? $this->Sewa_model->get_booking_by_id($sewa->id_booking) : null;

        echo json_encode(array(
            'status'       => 'success',
            'data'         => $sewa,
            'booking'      => $booking,
            'perpanjangan' => $perpanjangan,
            'kontrak'      => $kontrak
        ));
    }

    private function _parse_units_from_post()
    {
        $units_post = $this->input->post('units');
        if (!is_array($units_post) || empty($units_post)) {
            // Fallback single-unit flat POST
            $units_post = array(
                array(
                    'id_sewa'             => $this->input->post('id_sewa'),
                    'asal_unit'           => $this->input->post('asal_unit', true),
                    'id_unit'             => $this->input->post('id_unit'),
                    'nama_unit_asal'      => $this->input->post('nama_unit_asal', true),
                    'tipe_unit'           => $this->input->post('tipe_unit', true),
                    'plat_nomor'          => $this->input->post('plat_nomor', true),
                    'tanggal_mulai'       => $this->input->post('tanggal_mulai', true),
                    'tanggal_selesai'     => $this->input->post('tanggal_selesai', true),
                    'harga_user'          => $this->input->post('harga_user'),
                    'rent_to_rent_harian' => $this->input->post('rent_to_rent_harian'),
                    'rent_to_rent'        => $this->input->post('rent_to_rent'),
                    'status'              => $this->input->post('status', true)
                )
            );
        }

        $items = array();
        $grand_total = 0;
        $earliest_date = null;

        foreach ($units_post as $idx => $u) {
            $num = $idx + 1;
            $tgl_mulai = isset($u['tanggal_mulai']) ? trim((string) $u['tanggal_mulai']) : '';
            $tgl_selesai = isset($u['tanggal_selesai']) ? trim((string) $u['tanggal_selesai']) : '';
            $tipe_unit = isset($u['tipe_unit']) ? trim((string) $u['tipe_unit']) : '';
            $plat_nomor = isset($u['plat_nomor']) ? strtoupper(trim((string) $u['plat_nomor'])) : '';
            $harga_user = isset($u['harga_user']) ? $u['harga_user'] : '';
            $asal_unit = (isset($u['asal_unit']) && $u['asal_unit'] === 'luar') ? 'luar' : 'garasi';

            if ($tgl_mulai === '' || $tgl_selesai === '' || $tipe_unit === '' || $plat_nomor === '' || $harga_user === '') {
                return array('error' => "Data Unit #{$num} belum lengkap (Tanggal, Tipe Unit, Plat Nomor, Harga User wajib diisi).");
            }
            if (strtotime($tgl_selesai) < strtotime($tgl_mulai)) {
                return array('error' => "Unit #{$num}: Tanggal Selesai tidak boleh lebih kecil dari Tanggal Mulai.");
            }

            $id_unit = ($asal_unit === 'garasi' && !empty($u['id_unit'])) ? (int) $u['id_unit'] : null;
            $nama_unit_asal = ($asal_unit === 'garasi') ? 'Garasi' : (isset($u['nama_unit_asal']) ? trim((string) $u['nama_unit_asal']) : '');
            if ($asal_unit === 'luar' && $nama_unit_asal === '') {
                return array('error' => "Unit #{$num}: Nama rental/vendor asal unit luar wajib diisi.");
            }

            $calc = $this->Sewa_model->calculate_amounts(array(
                'tanggal_mulai'       => $tgl_mulai,
                'tanggal_selesai'     => $tgl_selesai,
                'harga_user'          => $harga_user,
                'asal_unit'           => $asal_unit,
                'nama_unit_asal'      => $nama_unit_asal,
                'rent_to_rent_harian' => isset($u['rent_to_rent_harian']) ? $u['rent_to_rent_harian'] : 0,
                'rent_to_rent'        => isset($u['rent_to_rent']) ? $u['rent_to_rent'] : 0
            ));

            $status = (isset($u['status']) && in_array($u['status'], array('Open', 'Selesai'), true)) ? $u['status'] : 'Open';

            $row = array(
                'tanggal_mulai'       => $tgl_mulai,
                'tanggal_selesai'     => $tgl_selesai,
                'tanggal_kembali'     => ($status === 'Selesai') ? (!empty($u['tanggal_kembali']) ? $u['tanggal_kembali'] : $tgl_selesai) : null,
                'jam_kembali'         => ($status === 'Selesai') ? (!empty($u['jam_kembali']) ? $u['jam_kembali'] : date('H:i')) : null,
                'hari'                => $calc['hari'],
                'asal_unit'           => $asal_unit,
                'id_unit'             => $id_unit,
                'nama_unit_asal'      => $calc['nama_unit_asal'],
                'tipe_unit'           => $tipe_unit,
                'plat_nomor'          => $plat_nomor,
                'warna'               => isset($u['warna']) ? trim((string) $u['warna']) : null,
                'harga_user'          => $calc['harga_user'],
                'total_masuk'         => $calc['total_masuk'],
                'rent_to_rent_harian' => $calc['rent_to_rent_harian'],
                'rent_to_rent'        => $calc['rent_to_rent'],
                'unit_garasi'         => $calc['unit_garasi'],
                'unit_luar'           => $calc['unit_luar'],
                'status'              => $status
            );

            if (!empty($u['id_sewa'])) {
                $row['id_sewa'] = (int) $u['id_sewa'];
            }

            $items[] = $row;
            $grand_total += $calc['total_masuk'];
            if ($earliest_date === null || strtotime($tgl_mulai) < strtotime($earliest_date)) {
                $earliest_date = $tgl_mulai;
            }
        }

        return array(
            'items'         => $items,
            'grand_total'   => $grand_total,
            'earliest_date' => $earliest_date
        );
    }

    public function simpan()
    {
        $this->form_validation->set_rules('nama_user', 'Nama User', 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            echo json_encode(array(
                'status'  => 'error',
                'message' => strip_tags(validation_errors(' ', ' '))
            ));
            return;
        }

        $parsed = $this->_parse_units_from_post();
        if (isset($parsed['error'])) {
            echo json_encode(array('status' => 'error', 'message' => $parsed['error']));
            return;
        }

        $status_pembayaran = $this->input->post('status_pembayaran', true);
        if (!in_array($status_pembayaran, array('Belum Lunas', 'DP', 'Lunas'), true)) {
            $status_pembayaran = 'Belum Lunas';
        }
        $jumlah_dp = ($status_pembayaran === 'DP')
            ? (float) $this->input->post('jumlah_dp')
            : ($status_pembayaran === 'Lunas' ? $parsed['grand_total'] : 0);

        $booking_data = array(
            'no_invoice'        => $this->Sewa_model->generate_no_invoice($parsed['earliest_date']),
            'nama_user'         => trim((string) $this->input->post('nama_user', true)),
            'no_hp_user'        => trim((string) $this->input->post('no_hp_user', true)),
            'alamat_user'       => trim((string) $this->input->post('alamat_user', true)),
            'status_pembayaran' => $status_pembayaran,
            'jumlah_dp'         => $jumlah_dp,
            'catatan'           => trim((string) $this->input->post('catatan', true)),
            'created_by'        => isset($this->userdata->id_agency) ? (int) $this->userdata->id_agency : null
        );

        $res = $this->Sewa_model->insert_booking($booking_data, $parsed['items']);
        if ($res) {
            $count = count($parsed['items']);
            echo json_encode(array(
                'status'     => 'success',
                'message'    => "Transaksi sewa ({$count} unit) berhasil disimpan.",
                'id_booking' => $res['id_booking'],
                'id_sewa'    => $res['id_sewa']
            ));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menyimpan transaksi sewa.'));
        }
    }

    public function update()
    {
        $id_booking = (int) $this->input->post('id_booking');
        $id_sewa = (int) $this->input->post('id_sewa');

        if ($id_booking <= 0 && $id_sewa > 0) {
            $row = $this->Sewa_model->get_by_id($id_sewa);
            if ($row && !empty($row->id_booking)) {
                $id_booking = (int) $row->id_booking;
            }
        }

        $existing = $this->Sewa_model->get_booking_by_id($id_booking);
        if (!$existing) {
            echo json_encode(array('status' => 'error', 'message' => 'Data booking/transaksi tidak ditemukan.'));
            return;
        }

        $this->form_validation->set_rules('nama_user', 'Nama User', 'required|trim');
        if ($this->form_validation->run() === FALSE) {
            echo json_encode(array(
                'status'  => 'error',
                'message' => strip_tags(validation_errors(' ', ' '))
            ));
            return;
        }

        $parsed = $this->_parse_units_from_post();
        if (isset($parsed['error'])) {
            echo json_encode(array('status' => 'error', 'message' => $parsed['error']));
            return;
        }

        $status_pembayaran = $this->input->post('status_pembayaran', true);
        if (!in_array($status_pembayaran, array('Belum Lunas', 'DP', 'Lunas'), true)) {
            $status_pembayaran = $existing->status_pembayaran;
        }
        $jumlah_dp = ($status_pembayaran === 'DP')
            ? (float) $this->input->post('jumlah_dp')
            : ($status_pembayaran === 'Lunas' ? $parsed['grand_total'] : 0);

        $booking_data = array(
            'nama_user'         => trim((string) $this->input->post('nama_user', true)),
            'no_hp_user'        => trim((string) $this->input->post('no_hp_user', true)),
            'alamat_user'       => trim((string) $this->input->post('alamat_user', true)),
            'status_pembayaran' => $status_pembayaran,
            'jumlah_dp'         => $jumlah_dp,
            'catatan'           => trim((string) $this->input->post('catatan', true)),
            'created_by'        => isset($this->userdata->id_agency) ? (int) $this->userdata->id_agency : $existing->created_by
        );

        $ok = $this->Sewa_model->update_booking($id_booking, $booking_data, $parsed['items']);
        if ($ok) {
            echo json_encode(array(
                'status'  => 'success',
                'message' => 'Transaksi sewa berhasil diperbarui.'
            ));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal memperbarui transaksi sewa.'));
        }
    }

    public function perpanjang()
    {
        $id_sewa = (int) $this->input->post('id_sewa');
        $tanggal_selesai_baru = trim((string) $this->input->post('tanggal_selesai_baru'));
        $harga_user_harian = $this->input->post('harga_user_harian');
        $rent_to_rent_harian = $this->input->post('rent_to_rent_harian');
        $keterangan = trim((string) $this->input->post('keterangan', true));

        $sewa = $this->Sewa_model->get_by_id($id_sewa);
        if (!$sewa) {
            echo json_encode(array('status' => 'error', 'message' => 'Data transaksi tidak ditemukan.'));
            return;
        }
        if ($sewa->status === 'Selesai') {
            echo json_encode(array('status' => 'error', 'message' => 'Transaksi sudah Selesai, tidak bisa diperpanjang.'));
            return;
        }
        if (empty($tanggal_selesai_baru) || strtotime($tanggal_selesai_baru) <= strtotime($sewa->tanggal_selesai)) {
            echo json_encode(array('status' => 'error', 'message' => 'Tanggal selesai baru harus lebih besar dari tanggal selesai sebelumnya (' . format_tanggal_id($sewa->tanggal_selesai) . ').'));
            return;
        }

        $user_id = isset($this->userdata->id_agency) ? (int) $this->userdata->id_agency : null;
        $ok = $this->Sewa_model->perpanjang_sewa(
            $id_sewa,
            $tanggal_selesai_baru,
            $harga_user_harian,
            $rent_to_rent_harian,
            $keterangan,
            $user_id
        );

        if ($ok) {
            echo json_encode(array(
                'status'  => 'success',
                'message' => 'Masa sewa berhasil diperpanjang hingga ' . format_tanggal_id($tanggal_selesai_baru) . ' dan tagihan telah diperbarui.'
            ));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal memproses perpanjangan sewa.'));
        }
    }

    public function selesai()
    {
        $id_sewa = (int) $this->input->post('id_sewa');
        $tanggal_kembali = trim((string) $this->input->post('tanggal_kembali'));
        if (empty($tanggal_kembali)) {
            $tanggal_kembali = date('Y-m-d');
        }
        $jam_kembali = trim((string) $this->input->post('jam_kembali'));
        if (empty($jam_kembali)) {
            $jam_kembali = date('H:i');
        }
        $hitung_overdue = ($this->input->post('hitung_overdue') === '1' || $this->input->post('hitung_overdue') === 'true');
        $user_id = isset($this->userdata->id_agency) ? (int) $this->userdata->id_agency : null;

        $sewa = $this->Sewa_model->get_by_id($id_sewa);
        if (!$sewa) {
            echo json_encode(array('status' => 'error', 'message' => 'Data transaksi tidak ditemukan.'));
            return;
        }

        $ok = $this->Sewa_model->selesaikan_sewa($id_sewa, $tanggal_kembali, $hitung_overdue, $user_id, $jam_kembali);
        if ($ok) {
            echo json_encode(array(
                'status'  => 'success',
                'message' => 'Unit telah dikembalikan dan transaksi ditandai Selesai.'
            ));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menyelesaikan transaksi sewa.'));
        }
    }

    public function update_pembayaran()
    {
        $id_sewa = (int) $this->input->post('id_sewa');
        $sewa = $this->Sewa_model->get_by_id($id_sewa);
        if (!$sewa) {
            echo json_encode(array('status' => 'error', 'message' => 'Data tidak ditemukan.'));
            return;
        }

        $status_pembayaran = $this->input->post('status_pembayaran', true);
        if (!in_array($status_pembayaran, array('Belum Lunas', 'DP', 'Lunas'), true)) {
            echo json_encode(array('status' => 'error', 'message' => 'Status pembayaran tidak valid.'));
            return;
        }

        $booking = !empty($sewa->id_booking) ? $this->Sewa_model->get_booking_by_id($sewa->id_booking) : null;
        $total_tagihan = $booking ? (float) $booking->total_tagihan : (float) $sewa->total_masuk;

        $jumlah_dp = ($status_pembayaran === 'DP')
            ? (float) $this->input->post('jumlah_dp')
            : ($status_pembayaran === 'Lunas' ? $total_tagihan : 0);

        if ($booking) {
            $this->Sewa_model->update_pembayaran_booking($booking->id_booking, $status_pembayaran, $jumlah_dp);
        } else {
            $this->db->where('id_sewa', $id_sewa)->update('rental_transaksi', array(
                'status_pembayaran' => $status_pembayaran,
                'jumlah_dp'         => $jumlah_dp
            ));
        }

        echo json_encode(array('status' => 'success', 'message' => 'Status pembayaran berhasil diperbarui.'));
    }

    public function hapus()
    {
        $id_sewa = (int) $this->input->post('id_sewa');
        if ($this->Sewa_model->delete_sewa($id_sewa)) {
            echo json_encode(array('status' => 'success', 'message' => 'Unit transaksi berhasil dihapus.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Data transaksi tidak ditemukan.'));
        }
    }

    public function cetak_invoice($id_sewa = 0)
    {
        $sewa = $this->Sewa_model->get_by_id((int) $id_sewa);
        if (!$sewa) {
            show_404();
            return;
        }

        $booking = !empty($sewa->id_booking) ? $this->Sewa_model->get_booking_by_id($sewa->id_booking) : null;
        $items = ($booking && !empty($booking->items)) ? $booking->items : array($sewa);
        $perpanjangan = $booking
            ? $this->Sewa_model->get_perpanjangan_by_booking($booking->id_booking)
            : $this->Sewa_model->get_perpanjangan((int) $id_sewa);

        $no_invoice = $booking ? $booking->no_invoice : $sewa->no_invoice;
        $nama_user = $booking ? $booking->nama_user : $sewa->nama_user;
        $no_hp_user = $booking ? $booking->no_hp_user : $sewa->no_hp_user;
        $alamat_user = $booking ? $booking->alamat_user : $sewa->alamat_user;
        $status_pembayaran = $booking ? $booking->status_pembayaran : $sewa->status_pembayaran;
        $jumlah_dp = $booking ? (float) $booking->jumlah_dp : (float) $sewa->jumlah_dp;
        $catatan = $booking ? $booking->catatan : $sewa->catatan;

        $total_tagihan = 0;
        $min_mulai = null;
        $max_selesai = null;
        $has_open = false;
        $has_overdue = false;
        $total_berjalan = 0;

        foreach ($items as $it) {
            $total_tagihan += (float) $it->total_masuk;
            $total_berjalan += (float) $it->tagihan_berjalan;
            if ($min_mulai === null || strtotime($it->tanggal_mulai) < strtotime($min_mulai)) {
                $min_mulai = $it->tanggal_mulai;
            }
            if ($max_selesai === null || strtotime($it->tanggal_selesai) > strtotime($max_selesai)) {
                $max_selesai = $it->tanggal_selesai;
            }
            if ($it->status === 'Open') {
                $has_open = true;
            }
            if ($it->is_overdue) {
                $has_overdue = true;
            }
        }

        require_once APPPATH . 'libraries/tcpdf/Tcpdf.php';

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('CV. Graha Transport');
        $pdf->SetAuthor('CV. Graha Transport');
        $pdf->SetTitle('Invoice ' . $no_invoice);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 14, 15);
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();

        // Kop Perusahaan
        $logo_path = FCPATH . 'assets/img/logo/logo.png';
        if (file_exists($logo_path)) {
            $pdf->Image($logo_path, 15, 13, 24);
        }

        $pdf->SetXY(43, 13);
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->SetTextColor(26, 68, 178);
        $pdf->Cell(95, 7, 'CV. GRAHA TRANSPORT', 0, 1, 'L');

        $pdf->SetX(43);
        $pdf->SetFont('helvetica', '', 8.5);
        $pdf->SetTextColor(70, 70, 70);
        $pdf->Cell(95, 4.5, 'Jasa Rental & Sewa Mobil Profesional', 0, 1, 'L');
        $pdf->SetX(43);
        $pdf->Cell(95, 4.5, 'Jl. Arjuna III No.17, Mapagan, Kab. Semarang, Jawa Tengah', 0, 1, 'L');
        $pdf->SetX(43);
        $pdf->Cell(95, 4.5, 'Telp/WA: +62 813-2716-0516 | Email: grahatransportungaran@gmail.com', 0, 1, 'L');

        // Box Judul Invoice
        $pdf->SetXY(142, 13);
        $pdf->SetFillColor(26, 68, 178);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(53, 9, 'INVOICE', 0, 1, 'C', true);

        $pdf->SetX(142);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(53, 6, $no_invoice, 0, 1, 'C');
        $pdf->SetX(142);
        $pdf->SetFont('helvetica', '', 8.5);
        $pdf->Cell(53, 5, 'Tanggal: ' . format_tanggal_panjang_id(date('Y-m-d')), 0, 1, 'C');

        $pdf->Ln(4);
        $pdf->SetDrawColor(26, 68, 178);
        $pdf->SetLineWidth(0.6);
        $pdf->Line(15, 38, 195, 38);
        $pdf->SetLineWidth(0.2);

        $pdf->SetY(42);
        $est_tambahan_all = max(0, $total_berjalan - $total_tagihan);
        $total_tagihan_invoice = $total_tagihan + $est_tambahan_all;
        $dibayar = ($status_pembayaran === 'Lunas') ? $total_tagihan : $jumlah_dp;
        $sisa_bayar = max(0, $total_tagihan_invoice - $dibayar);

        $status_bayar_color = '#d9534f';
        if ($status_pembayaran === 'Lunas') {
            $status_bayar_color = '#198754';
        } elseif ($status_pembayaran === 'DP') {
            $status_bayar_color = '#fd7e14';
        }

        $status_sewa_label = $has_open ? 'Open' : 'Selesai';
        $has_akumulasi = ($est_tambahan_all > 0);

        $html_info = '<table cellpadding="4" cellspacing="0" border="0" style="width:100%; font-size:9.5pt;">'
            . '<tr>'
            . '<td width="53%" valign="top">'
            . '<span style="font-weight:bold; color:#1A44B2;">TAGIHAN KEPADA (PENYEWA):</span><br/><br/>'
            . '<span style="font-size:11pt; font-weight:bold;">' . htmlspecialchars($nama_user) . '</span><br/>'
            . 'No. HP: ' . htmlspecialchars($no_hp_user ?: '-') . '<br/>'
            . 'Alamat: ' . nl2br(htmlspecialchars($alamat_user ?: '-'))
            . '</td>'
            . '<td width="47%" valign="top">'
            . '<table cellpadding="4" cellspacing="0" border="1" style="border-color:#d9e2ef; font-size:9pt; width:100%;">'
            . '<tr style="background-color:#f4f7fc;">'
            . '<td width="42%"><b>Jumlah Unit</b></td>'
            . '<td width="58%"><b>' . count($items) . ' Unit</b></td>'
            . '</tr>'
            . '<tr>'
            . '<td width="42%"><b>Status Sewa</b></td>'
            . '<td width="58%"><b>' . htmlspecialchars($status_sewa_label) . '</b>' . ($has_akumulasi ? ' <span style="color:#dc3545;">(Lewat Toleransi 06:00)</span>' : ($has_overdue ? ' <span style="color:#b45309;">(Toleransi s/d 06:00)</span>' : '')) . '</td>'
            . '</tr>'
            . '<tr style="background-color:#f4f7fc;">'
            . '<td width="42%"><b>Pembayaran</b></td>'
            . '<td width="58%"><span style="color:' . $status_bayar_color . '; font-weight:bold;">' . htmlspecialchars($status_pembayaran) . '</span></td>'
            . '</tr>'
            . '<tr>'
            . '<td width="42%"><b>Periode Sewa</b></td>'
            . '<td width="58%">' . format_tanggal_id($min_mulai) . ' s/d ' . format_tanggal_id($max_selesai) . '</td>'
            . '</tr>'
            . '</table>'
            . '</td>'
            . '</tr>'
            . '</table>';
        $pdf->writeHTML($html_info, true, false, true, false, '');

        $pdf->Ln(3);

        // Tabel Rincian Tagihan Multi-Unit (tanpa menampilkan asal unit internal)
        $rows_html = '';
        $no = 1;
        foreach ($items as $it) {
            if ($it->status === 'Open') {
                if ((int) $it->hari_terlambat > 0) {
                    $unit_status_badge = ' <span style="color:#dc3545;">(Akumulasi +' . (int) $it->hari_terlambat . ' hr)</span>';
                } elseif (!empty($it->in_grace_period)) {
                    $unit_status_badge = ' <span style="color:#b45309;">(Toleransi s/d 06:00)</span>';
                } else {
                    $unit_status_badge = ' <span style="color:#b45309;">(Open)</span>';
                }
            } else {
                $unit_status_badge = ' <span style="color:#198754;">(Selesai)</span>';
            }

            $rows_html .= '<tr>'
                . '<td width="7%" align="center">' . $no++ . '</td>'
                . '<td width="45%" align="left">'
                . '<b>Sewa Unit ' . htmlspecialchars($it->tipe_unit) . '</b>' . $unit_status_badge . '<br/>'
                . '<span style="font-size:8.5pt; color:#555;">Plat Nomor: <b>' . htmlspecialchars($it->plat_nomor) . '</b><br/>'
                . 'Periode: ' . format_tanggal_id($it->tanggal_mulai) . ' s/d ' . format_tanggal_id($it->tanggal_selesai) . ' (00.00 - 24.00)</span>'
                . '</td>'
                . '<td width="13%" align="center">' . (int) $it->hari . ' Hari</td>'
                . '<td width="17%" align="right">' . format_rupiah($it->harga_user) . '</td>'
                . '<td width="18%" align="right"><b>' . format_rupiah($it->total_masuk) . '</b></td>'
                . '</tr>';

            if ($it->status === 'Open' && (int) $it->hari_terlambat > 0 && (float) $it->estimasi_tambahan > 0) {
                $rows_html .= '<tr style="background-color:#fff8f8;">'
                    . '<td width="7%" align="center">' . $no++ . '</td>'
                    . '<td width="45%" align="left">'
                    . '<b style="color:#dc3545;">Akumulasi Keterlambatan - ' . htmlspecialchars($it->tipe_unit) . '</b><br/>'
                    . '<span style="font-size:8.5pt; color:#666;">Plat: <b>' . htmlspecialchars($it->plat_nomor) . '</b> | Lewat toleransi ' . htmlspecialchars($it->deadline_toleransi) . ' WIB</span>'
                    . '</td>'
                    . '<td width="13%" align="center">+' . (int) $it->hari_terlambat . ' Hari</td>'
                    . '<td width="17%" align="right">' . format_rupiah($it->harga_user) . '</td>'
                    . '<td width="18%" align="right"><b style="color:#dc3545;">' . format_rupiah($it->estimasi_tambahan) . '</b></td>'
                    . '</tr>';
            }
        }

        $terbilang_sisa = ($sisa_bayar <= 0)
            ? 'Nol Rupiah (Lunas)'
            : terbilang_id($sisa_bayar) . ' Rupiah';

        $tbl_html = '<table cellpadding="6" cellspacing="0" border="1" style="border-color:#cfd8e3; width:100%; font-size:9.5pt;">'
            . '<thead>'
            . '<tr style="background-color:#1A44B2; color:#ffffff; font-weight:bold;">'
            . '<th width="7%" align="center">No</th>'
            . '<th width="45%" align="left">Deskripsi Unit &amp; Periode</th>'
            . '<th width="13%" align="center">Durasi</th>'
            . '<th width="17%" align="right">Harga / Hari</th>'
            . '<th width="18%" align="right">Total</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . $rows_html
            . '<tr style="background-color:#f8fafc;">'
            . '<td width="82%" colspan="4" align="right"><b>Total Tagihan</b></td>'
            . '<td width="18%" align="right"><b>' . format_rupiah($total_tagihan_invoice) . '</b></td>'
            . '</tr>'
            . '<tr>'
            . '<td width="82%" colspan="4" align="right">Sudah Dibayar / DP</td>'
            . '<td width="18%" align="right">' . format_rupiah($dibayar) . '</td>'
            . '</tr>'
            . '<tr style="background-color:#eef3fb;">'
            . '<td width="82%" colspan="4" align="right"><b>Sisa Tagihan</b></td>'
            . '<td width="18%" align="right"><b style="color:#1A44B2;">' . format_rupiah($sisa_bayar) . '</b></td>'
            . '</tr>'
            . '</tbody>'
            . '</table>';

        $pdf->writeHTML($tbl_html, true, false, true, false, '');

        $pdf->Ln(4);

        $terbilang_html = '<table cellpadding="6" cellspacing="0" border="1" style="border-color:#d0d7e2; width:100%; font-size:9pt;">'
            . '<tr style="background-color:#f4f7fc;">'
            . '<td width="100%"><b>Terbilang Sisa Tagihan:</b> <i>' . htmlspecialchars($terbilang_sisa) . '</i></td>'
            . '</tr>'
            . '</table>';
        $pdf->writeHTML($terbilang_html, true, false, true, false, '');

        if (!empty($perpanjangan)) {
            $pdf->Ln(2);
            $ext_html = '<div style="font-size:8.5pt; color:#333;"><b>Riwayat Perpanjangan Sewa:</b><ul style="margin:2px 0; padding-left:14px;">';
            foreach ($perpanjangan as $ext) {
                $unit_lbl = !empty($ext->tipe_unit) ? '<b>' . htmlspecialchars($ext->tipe_unit . ' (' . $ext->plat_nomor . ')</b>: ') : '';
                $ext_html .= '<li>' . $unit_lbl . format_tanggal_id($ext->tanggal_selesai_lama) . ' &rarr; ' . format_tanggal_id($ext->tanggal_selesai_baru) . ' (+' . (int) $ext->tambah_hari . ' hari, +' . format_rupiah($ext->tambahan_tagihan) . ')' . (!empty($ext->keterangan) ? ' — ' . htmlspecialchars($ext->keterangan) : '') . '</li>';
            }
            $ext_html .= '</ul></div>';
            $pdf->writeHTML($ext_html, true, false, true, false, '');
        }

        if ($has_overdue) {
            $pdf->Ln(2);
            $note_text = $has_akumulasi
                ? '<b>Catatan Akumulasi Sewa:</b> Sewa harian dihitung pukul 00.00 - 24.00 dengan toleransi pengembalian hingga pukul 06.00 WIB hari berikutnya. Akumulasi tambahan keterlambatan sebesar <b>' . format_rupiah($est_tambahan_all) . '</b> telah diperhitungkan pada Total Tagihan di atas.'
                : '<b>Masa Toleransi Pengembalian:</b> Unit telah melewati pukul 24.00 pada jadwal selesai, namun saat ini masih dalam masa toleransi pengembalian hingga pukul 06.00 WIB (Akumulasi tambahan: <b>Rp0</b>). Jika melewati pukul 06.00 WIB, biaya sewa harian akan otomatis terakumulasi.';
            $overdue_note = '<table cellpadding="6" cellspacing="0" border="1" style="border-color:#ffecb5; width:100%; font-size:8.5pt;">'
                . '<tr style="background-color:#fff3cd; color:#664d03;">'
                . '<td width="100%">' . $note_text . '</td>'
                . '</tr>'
                . '</table>';
            $pdf->writeHTML($overdue_note, true, false, true, false, '');
        }

        if (!empty($catatan)) {
            $pdf->SetFont('helvetica', '', 8.5);
            $pdf->MultiCell(0, 5, 'Catatan: ' . $catatan, 0, 'L');
        }

        $pdf->Ln(6);
        $ttd_html = '<table cellpadding="4" cellspacing="0" border="0" style="width:100%; font-size:9pt;">'
            . '<tr>'
            . '<td width="58%" valign="top">'
            . '<table cellpadding="7" cellspacing="0" border="1" style="border-color:#dce4ef; width:100%; font-size:8.8pt;">'
            . '<tr style="background-color:#fafcff;">'
            . '<td width="100%">'
            . '<b>Informasi Pembayaran:</b><br/>'
            . 'Mohon melakukan pembayaran ke rekening resmi CV. Graha Transport atau tunai melalui admin operasional.<br/>'
            . 'Konfirmasi WhatsApp: <b>+62 813-2716-0516</b><br/>'
            . '<i>Terima kasih telah mempercayakan perjalanan Anda kepada CV. Graha Transport.</i>'
            . '</td>'
            . '</tr>'
            . '</table>'
            . '</td>'
            . '<td width="42%" align="center" valign="top">'
            . 'Semarang, ' . format_tanggal_panjang_id(date('Y-m-d')) . '<br/>'
            . '<b>CV. Graha Transport</b><br/><br/><br/><br/>'
            . '<u><b>' . htmlspecialchars(isset($this->userdata->nama_agent) ? $this->userdata->nama_agent : 'Admin Operational') . '</b></u><br/>'
            . '<span style="font-size:8pt; color:#666;">' . htmlspecialchars(isset($this->userdata->position) ? $this->userdata->position : 'Operational') . '</span>'
            . '</td>'
            . '</tr>'
            . '</table>';
        $pdf->writeHTML($ttd_html, true, false, true, false, '');

        $filename = 'Invoice_' . str_replace('/', '_', $no_invoice) . '.pdf';
        $mode = ($this->input->get('download') === '1') ? 'D' : 'I';
        $pdf->Output($filename, $mode);
    }

    public function cetak_laporan()
    {
        $filters = $this->_collect_filters();
        $grouped = $this->Sewa_model->get_grouped_by_day($filters);

        $periode_label = 'Semua Periode';
        if (!empty($filters['bulan'])) {
            $parts = explode('-', $filters['bulan']);
            if (count($parts) === 2) {
                $periode_label = 'Bulan ' . nama_bulan_id($parts[1]) . ' ' . $parts[0];
                if (!empty($filters['minggu'])) {
                    $periode_label .= ' (' . label_minggu_id($filters['minggu']) . ')';
                }
            }
        } elseif (!empty($filters['tanggal_dari']) || !empty($filters['tanggal_sampai'])) {
            $dari = !empty($filters['tanggal_dari']) ? format_tanggal_panjang_id($filters['tanggal_dari']) : '...';
            $sampai = !empty($filters['tanggal_sampai']) ? format_tanggal_panjang_id($filters['tanggal_sampai']) : '...';
            $periode_label = 'Periode ' . $dari . ' s/d ' . $sampai;
        }

        require_once APPPATH . 'libraries/tcpdf/Tcpdf.php';

        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('CV. Graha Transport');
        $pdf->SetAuthor('CV. Graha Transport');
        $pdf->SetTitle('Laporan Transaksi Harian CV. Graha Transport');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(8, 10, 8);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();

        $header_html = '
        <table cellpadding="5" cellspacing="0" border="0" style="width:100%;">
            <tr>
                <td style="background-color:#38761d; color:#ffffff; text-align:center; font-size:13pt; font-weight:bold;">
                    LAPORAN TRANSAKSI HARIAN CV. GRAHA TRANSPORT
                </td>
            </tr>
            <tr>
                <td style="text-align:center; font-size:10.5pt; font-weight:bold; color:#222222; padding-top:4px;">
                    ' . htmlspecialchars($periode_label) . '
                </td>
            </tr>
        </table>';
        $pdf->writeHTML($header_html, true, false, true, false, '');
        $pdf->Ln(1);

        if (empty($grouped)) {
            $pdf->SetFont('helvetica', 'I', 10);
            $pdf->Cell(0, 10, 'Tidak ada data transaksi pada periode yang dipilih.', 0, 1, 'C');
        } else {
            $grand_garasi = 0;
            $grand_luar = 0;
            $grand_masuk = 0;

            foreach ($grouped as $tgl => $grp) {
                $grand_garasi += $grp['total_unit_garasi'];
                $grand_luar += $grp['total_unit_luar'];
                $grand_masuk += $grp['total_masuk'];

                $tbl = '
                <table cellpadding="3" cellspacing="0" border="1" style="border-color:#555555; width:100%; font-size:7.5pt; margin-bottom:8px;">
                    <thead>
                        <tr style="background-color:#1f4e78; color:#ffffff; font-weight:bold;">
                            <th colspan="14" align="center" style="font-size:9pt;">' . htmlspecialchars(format_hari_tanggal_id($tgl)) . '</th>
                        </tr>
                        <tr style="background-color:#4472c4; color:#ffffff; font-weight:bold;">
                            <th width="3%" align="center">No</th>
                            <th width="7%" align="center">Tanggal Mulai</th>
                            <th width="7%" align="center">Tanggal Selesai</th>
                            <th width="4%" align="center">Hari</th>
                            <th width="10%" align="center">Nama User</th>
                            <th width="10%" align="center">Tipe Unit</th>
                            <th width="8%" align="center">Plat Nomor</th>
                            <th width="8%" align="center">Harga User</th>
                            <th width="8%" align="center">Total Masuk</th>
                            <th width="8%" align="center">Unit</th>
                            <th width="8%" align="center">Rent to Rent</th>
                            <th width="5%" align="center">Status</th>
                            <th width="7%" align="center">Unit Garasi</th>
                            <th width="7%" align="center">Unit Luar</th>
                        </tr>
                    </thead>
                    <tbody>';

                $no = 1;
                foreach ($grp['items'] as $row) {
                    $status_cell = ($row->status === 'Open')
                        ? '<span style="color:#cc0000; font-style:italic; font-weight:bold;">Open</span>'
                        : '<span style="color:#198754;">Selesai</span>';

                    $tbl .= '
                    <tr>
                        <td width="3%" align="center" style="background-color:#f3f3f3;">' . $no++ . '</td>
                        <td width="7%" align="center" style="background-color:#f4cccc;">' . format_tanggal_id($row->tanggal_mulai) . '</td>
                        <td width="7%" align="center" style="background-color:#f4cccc;">' . format_tanggal_id($row->tanggal_selesai) . '</td>
                        <td width="4%" align="center" style="background-color:#d9ead3;">' . (int) $row->hari . '</td>
                        <td width="10%" align="left" style="background-color:#d9ead3;">' . htmlspecialchars($row->nama_user) . '</td>
                        <td width="10%" align="left" style="background-color:#efefef;">' . htmlspecialchars($row->tipe_unit) . '</td>
                        <td width="8%" align="center" style="background-color:#efefef;">' . htmlspecialchars($row->plat_nomor) . '</td>
                        <td width="8%" align="right" style="background-color:#fce5cd;">' . format_rupiah($row->harga_user) . '</td>
                        <td width="8%" align="right" style="background-color:#fce5cd;">' . format_rupiah($row->total_masuk) . '</td>
                        <td width="8%" align="center" style="background-color:#f3f3f3;">' . htmlspecialchars($row->nama_unit_asal) . '</td>
                        <td width="8%" align="right" style="background-color:#f3f3f3;">' . format_rupiah($row->rent_to_rent) . '</td>
                        <td width="5%" align="center" style="background-color:#ffffff;">' . $status_cell . '</td>
                        <td width="7%" align="right" style="background-color:#fff2cc;">' . format_rupiah($row->unit_garasi) . '</td>
                        <td width="7%" align="right" style="background-color:#fff2cc;">' . format_rupiah($row->unit_luar) . '</td>
                    </tr>';
                }

                $laba_harian = (float) $grp['total_unit_garasi'] + (float) $grp['total_unit_luar'];

                $tbl .= '
                        <tr>
                            <td colspan="12" width="86%" align="center" style="background-color:#cc0000; color:#ffffff; font-weight:bold; font-size:8.5pt;">TOTAL</td>
                            <td width="7%" align="right" style="background-color:#ffd966; font-weight:bold;">' . format_rupiah($grp['total_unit_garasi']) . '</td>
                            <td width="7%" align="right" style="background-color:#f6b26b; font-weight:bold;">' . format_rupiah($grp['total_unit_luar']) . '</td>
                        </tr>
                        <tr>
                            <td colspan="12" width="86%" align="right" style="background-color:#274e13; color:#ffffff; font-weight:bold; font-size:8.5pt;">TOTAL LABA HARIAN (Unit Garasi + Unit Luar)</td>
                            <td colspan="2" width="14%" align="center" style="background-color:#b6d7a8; color:#000000; font-weight:bold; font-size:8.5pt;">' . format_rupiah($laba_harian) . '</td>
                        </tr>
                    </tbody>
                </table>';

                $pdf->writeHTML($tbl, true, false, true, false, '');
                $pdf->Ln(2);
            }

            $grand_laba = $grand_garasi + $grand_luar;
            $grand_html = '
            <table cellpadding="4" cellspacing="0" border="1" style="border-color:#555555; width:100%; font-size:8.5pt;">
                <tr style="background-color:#eaf0f8; font-weight:bold;">
                    <td width="44%" align="right">REKAPITULASI PERIODE (' . htmlspecialchars($periode_label) . ')</td>
                    <td width="14%" align="right">Total Masuk:<br/>' . format_rupiah($grand_masuk) . '</td>
                    <td width="14%" align="right" style="background-color:#ffd966;">Unit Garasi:<br/>' . format_rupiah($grand_garasi) . '</td>
                    <td width="14%" align="right" style="background-color:#f6b26b;">Unit Luar:<br/>' . format_rupiah($grand_luar) . '</td>
                    <td width="14%" align="right" style="background-color:#38761d; color:#ffffff;">TOTAL LABA:<br/>' . format_rupiah($grand_laba) . '</td>
                </tr>
            </table>';
            $pdf->writeHTML($grand_html, true, false, true, false, '');
        }

        $filename = 'Laporan_Transaksi_Harian_' . date('Ymd_His') . '.pdf';
        $mode = ($this->input->get('download') === '1') ? 'D' : 'I';
        $pdf->Output($filename, $mode);
    }

    public function export_excel()
    {
        $filters = $this->_collect_filters();
        $grouped = $this->Sewa_model->get_grouped_by_day($filters);

        $periode_label = 'Semua Periode';
        if (!empty($filters['bulan'])) {
            $parts = explode('-', $filters['bulan']);
            if (count($parts) === 2) {
                $periode_label = 'Bulan ' . nama_bulan_id($parts[1]) . ' ' . $parts[0];
                if (!empty($filters['minggu'])) {
                    $periode_label .= ' (' . label_minggu_id($filters['minggu']) . ')';
                }
            }
        }

        $prev_err = error_reporting(E_ERROR | E_PARSE);
        require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle('Laporan Transaksi');

        $sheet->mergeCells('A1:N1');
        $sheet->setCellValue('A1', 'LAPORAN TRANSAKSI HARIAN CV. GRAHA TRANSPORT');
        $sheet->getStyle('A1')->applyFromArray(array(
            'font' => array('bold' => true, 'size' => 14, 'color' => array('rgb' => 'FFFFFF')),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '38761D')),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)
        ));
        $sheet->getRowDimension(1)->setRowHeight(26);

        $sheet->mergeCells('A2:N2');
        $sheet->setCellValue('A2', $periode_label);
        $sheet->getStyle('A2')->applyFromArray(array(
            'font' => array('bold' => true, 'size' => 11),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        ));

        $row_idx = 4;
        $headers = array('No', 'Tanggal Mulai', 'Tanggal Selesai', 'Hari', 'Nama User', 'Tipe Unit', 'Plat Nomor', 'Harga User', 'Total Masuk', 'Unit', 'Rent to Rent', 'Status', 'Unit Garasi', 'Unit Luar');

        $grand_masuk = 0;
        $grand_garasi = 0;
        $grand_luar = 0;

        foreach ($grouped as $tgl => $grp) {
            $grand_masuk += (float) $grp['total_masuk'];
            $grand_garasi += (float) $grp['total_unit_garasi'];
            $grand_luar += (float) $grp['total_unit_luar'];
            $sheet->mergeCells('A' . $row_idx . ':N' . $row_idx);
            $sheet->setCellValue('A' . $row_idx, format_hari_tanggal_id($tgl));
            $sheet->getStyle('A' . $row_idx . ':N' . $row_idx)->applyFromArray(array(
                'font' => array('bold' => true, 'size' => 11, 'color' => array('rgb' => 'FFFFFF')),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '1F4E78')),
                'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ));
            $row_idx++;

            $col = 'A';
            foreach ($headers as $h) {
                $sheet->setCellValue($col . $row_idx, $h);
                $col++;
            }
            $sheet->getStyle('A' . $row_idx . ':N' . $row_idx)->applyFromArray(array(
                'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '4472C4')),
                'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
                'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
            ));
            $row_idx++;

            $no = 1;
            foreach ($grp['items'] as $item) {
                $sheet->setCellValue('A' . $row_idx, $no++);
                $sheet->setCellValue('B' . $row_idx, format_tanggal_id($item->tanggal_mulai));
                $sheet->setCellValue('C' . $row_idx, format_tanggal_id($item->tanggal_selesai));
                $sheet->setCellValue('D' . $row_idx, (int) $item->hari);
                $sheet->setCellValue('E' . $row_idx, $item->nama_user);
                $sheet->setCellValue('F' . $row_idx, $item->tipe_unit);
                $sheet->setCellValue('G' . $row_idx, $item->plat_nomor);
                $sheet->setCellValue('H' . $row_idx, (float) $item->harga_user);
                $sheet->setCellValue('I' . $row_idx, (float) $item->total_masuk);
                $sheet->setCellValue('J' . $row_idx, $item->nama_unit_asal);
                $sheet->setCellValue('K' . $row_idx, (float) $item->rent_to_rent);
                $sheet->setCellValue('L' . $row_idx, $item->status);
                $sheet->setCellValue('M' . $row_idx, (float) $item->unit_garasi);
                $sheet->setCellValue('N' . $row_idx, (float) $item->unit_luar);

                $sheet->getStyle('B' . $row_idx . ':C' . $row_idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('F4CCCC');
                $sheet->getStyle('D' . $row_idx . ':E' . $row_idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D9EAD3');
                $sheet->getStyle('F' . $row_idx . ':G' . $row_idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('EFEFEF');
                $sheet->getStyle('H' . $row_idx . ':I' . $row_idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FCE5CD');
                $sheet->getStyle('M' . $row_idx . ':N' . $row_idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFF2CC');

                if ($item->status === 'Open') {
                    $sheet->getStyle('L' . $row_idx)->getFont()->setColor(new PHPExcel_Style_Color('CC0000'))->setItalic(true)->setBold(true);
                }

                foreach (array('H', 'I', 'K', 'M', 'N') as $numCol) {
                    $sheet->getStyle($numCol . $row_idx)->getNumberFormat()->setFormatCode('"Rp"#,##0');
                }
                $sheet->getStyle('A' . $row_idx . ':N' . $row_idx)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $row_idx++;
            }

            $sheet->mergeCells('A' . $row_idx . ':L' . $row_idx);
            $sheet->setCellValue('A' . $row_idx, 'TOTAL');
            $sheet->setCellValue('M' . $row_idx, (float) $grp['total_unit_garasi']);
            $sheet->setCellValue('N' . $row_idx, (float) $grp['total_unit_luar']);

            $sheet->getStyle('A' . $row_idx . ':L' . $row_idx)->applyFromArray(array(
                'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'CC0000')),
                'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ));
            $sheet->getStyle('M' . $row_idx)->applyFromArray(array(
                'font' => array('bold' => true),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FFD966'))
            ));
            $sheet->getStyle('N' . $row_idx)->applyFromArray(array(
                'font' => array('bold' => true),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F6B26B'))
            ));
            $sheet->getStyle('M' . $row_idx . ':N' . $row_idx)->getNumberFormat()->setFormatCode('"Rp"#,##0');
            $sheet->getStyle('A' . $row_idx . ':N' . $row_idx)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $row_idx++;
            $laba_harian = (float) $grp['total_unit_garasi'] + (float) $grp['total_unit_luar'];
            $sheet->mergeCells('A' . $row_idx . ':L' . $row_idx);
            $sheet->mergeCells('M' . $row_idx . ':N' . $row_idx);
            $sheet->setCellValue('A' . $row_idx, 'TOTAL LABA HARIAN (Unit Garasi + Unit Luar)');
            $sheet->setCellValue('M' . $row_idx, $laba_harian);
            $sheet->getStyle('A' . $row_idx . ':L' . $row_idx)->applyFromArray(array(
                'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '274E13')),
                'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ));
            $sheet->getStyle('M' . $row_idx . ':N' . $row_idx)->applyFromArray(array(
                'font' => array('bold' => true),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'B6D7A8')),
                'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ));
            $sheet->getStyle('M' . $row_idx)->getNumberFormat()->setFormatCode('"Rp"#,##0');
            $sheet->getStyle('A' . $row_idx . ':N' . $row_idx)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $row_idx += 2;
        }

        if (!empty($grouped)) {
            $grand_laba = $grand_garasi + $grand_luar;
            $sheet->mergeCells('A' . $row_idx . ':H' . $row_idx);
            $sheet->setCellValue('A' . $row_idx, 'REKAPITULASI PERIODE (' . $periode_label . ')');
            $sheet->setCellValue('I' . $row_idx, 'Total Masuk');
            $sheet->setCellValue('J' . $row_idx, $grand_masuk);
            $sheet->setCellValue('K' . $row_idx, 'Unit Garasi');
            $sheet->setCellValue('L' . $row_idx, $grand_garasi);
            $sheet->setCellValue('M' . $row_idx, 'Unit Luar');
            $sheet->setCellValue('N' . $row_idx, $grand_luar);
            $sheet->getStyle('A' . $row_idx . ':N' . $row_idx)->applyFromArray(array(
                'font' => array('bold' => true),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'EAF0F8')),
                'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
            ));
            $sheet->getStyle('L' . $row_idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFD966');
            $sheet->getStyle('N' . $row_idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('F6B26B');
            foreach (array('J', 'L', 'N') as $numCol) {
                $sheet->getStyle($numCol . $row_idx)->getNumberFormat()->setFormatCode('"Rp"#,##0');
            }
            $row_idx++;

            $sheet->mergeCells('A' . $row_idx . ':L' . $row_idx);
            $sheet->mergeCells('M' . $row_idx . ':N' . $row_idx);
            $sheet->setCellValue('A' . $row_idx, 'TOTAL LABA PERIODE (Unit Garasi + Unit Luar)');
            $sheet->setCellValue('M' . $row_idx, $grand_laba);
            $sheet->getStyle('A' . $row_idx . ':L' . $row_idx)->applyFromArray(array(
                'font' => array('bold' => true, 'size' => 11, 'color' => array('rgb' => 'FFFFFF')),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '38761D')),
                'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ));
            $sheet->getStyle('M' . $row_idx . ':N' . $row_idx)->applyFromArray(array(
                'font' => array('bold' => true, 'size' => 11),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'B6D7A8')),
                'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ));
            $sheet->getStyle('M' . $row_idx)->getNumberFormat()->setFormatCode('"Rp"#,##0');
            $sheet->getStyle('A' . $row_idx . ':N' . $row_idx)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }

        foreach (range('A', 'N') as $colID) {
            $sheet->getColumnDimension($colID)->setAutoSize(true);
        }

        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        $filename = 'Laporan_Transaksi_Harian_' . date('Ymd_His') . '.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $writer->save('php://output');
        error_reporting($prev_err);
        exit;
    }
}
