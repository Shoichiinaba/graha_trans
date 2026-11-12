<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perawatan_unit extends AUTH_Controller
{
    var $template = 'template/index';

    public function __construct()
    {
        parent::__construct();
        $this->require_roles(array('Admin', 'Owner', 'admin_oprational'));
        $this->load->model('Perawatan_model');
        $this->load->model('Sewa_model');
        $this->load->helper('rental');
    }

    public function index()
    {
        $data['tittle']       = 'Graha Transport | Perawatan & Biaya Unit';
        $data['userdata']     = $this->userdata;
        $data['unit_garasi']  = $this->Sewa_model->get_unit_garasi_list();
        $data['upcoming_due'] = $this->Perawatan_model->get_upcoming_due(14);
        $data['content']      = 'page_admin/perawatan/perawatan';
        $data['script']       = 'page_admin/perawatan/perawatan_js';
        $this->load->view($this->template, $data);
    }

    private function _collect_filters()
    {
        return array(
            'bulan'            => trim((string) $this->input->get_post('bulan')),
            'jenis_biaya'      => trim((string) $this->input->get_post('jenis_biaya')),
            'id_unit'          => trim((string) $this->input->get_post('id_unit')),
            'status_perawatan' => trim((string) $this->input->get_post('status_perawatan')),
            'search'           => trim((string) $this->input->get_post('search'))
        );
    }

    public function fetch()
    {
        $filters = $this->_collect_filters();
        $rows = $this->Perawatan_model->get_all($filters, 'DESC');
        $summary = $this->Perawatan_model->get_summary($filters);
        $upcoming = $this->Perawatan_model->get_upcoming_due(14);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'status'       => 'success',
                'summary'      => $summary,
                'rows'         => $rows,
                'upcoming_due' => $upcoming
            )));
    }

    public function get_detail()
    {
        $id = (int) $this->input->post('id_perawatan');
        $row = $this->Perawatan_model->get_by_id($id);
        if (!$row) {
            echo json_encode(array('status' => 'error', 'message' => 'Data perawatan tidak ditemukan.'));
            return;
        }
        echo json_encode(array('status' => 'success', 'data' => $row));
    }

    private function _parse_post()
    {
        $id_unit = (int) $this->input->post('id_unit');
        $nama_unit = trim((string) $this->input->post('nama_unit', true));
        if ($id_unit > 0) {
            $u = $this->db->get_where('unit_mobil', array('id_unit' => $id_unit))->row();
            if ($u) {
                $nama_unit = $u->nama_unit;
            }
        }
        if ($nama_unit === '') {
            return array('error' => 'Unit mobil wajib dipilih atau diisi.');
        }

        $jenis = trim((string) $this->input->post('jenis_biaya'));
        if (!in_array($jenis, array('servis', 'asuransi', 'pajak', 'lainnya'), true)) {
            $jenis = 'servis';
        }

        $judul = trim((string) $this->input->post('judul_biaya', true));
        if ($judul === '') {
            return array('error' => 'Judul / keterangan biaya wajib diisi.');
        }

        $tgl = trim((string) $this->input->post('tanggal_transaksi'));
        if ($tgl === '') {
            $tgl = date('Y-m-d');
        }

        $nominal = max(0, (float) $this->input->post('nominal'));
        $km_now_raw = trim((string) $this->input->post('km_saat_ini'));
        $km_next_raw = trim((string) $this->input->post('km_berikutnya'));
        $due_raw = trim((string) $this->input->post('tanggal_jatuh_tempo'));

        $status = trim((string) $this->input->post('status_perawatan'));
        if ($jenis !== 'servis') {
            $status = 'Selesai';
        } elseif (!in_array($status, array('Proses', 'Selesai'), true)) {
            $status = 'Selesai';
        }

        return array(
            'id_unit'             => $id_unit > 0 ? $id_unit : null,
            'nama_unit'           => $nama_unit,
            'plat_nomor'          => strtoupper(trim((string) $this->input->post('plat_nomor', true))),
            'jenis_biaya'         => $jenis,
            'judul_biaya'         => $judul,
            'tanggal_transaksi'   => $tgl,
            'nominal'             => $nominal,
            'vendor_bengkel'      => trim((string) $this->input->post('vendor_bengkel', true)),
            'km_saat_ini'         => ($km_now_raw !== '') ? max(0, (int) $km_now_raw) : null,
            'km_berikutnya'       => ($km_next_raw !== '') ? max(0, (int) $km_next_raw) : null,
            'tanggal_jatuh_tempo' => ($due_raw !== '') ? $due_raw : null,
            'status_perawatan'    => $status,
            'keterangan'          => trim((string) $this->input->post('keterangan', true))
        );
    }

    public function simpan()
    {
        $parsed = $this->_parse_post();
        if (isset($parsed['error'])) {
            echo json_encode(array('status' => 'error', 'message' => $parsed['error']));
            return;
        }
        $parsed['created_by'] = isset($this->userdata->id_agency) ? (int) $this->userdata->id_agency : null;
        $id = $this->Perawatan_model->insert($parsed);

        echo json_encode(array(
            'status'       => 'success',
            'message'      => 'Catatan biaya perawatan unit berhasil disimpan.',
            'id_perawatan' => $id
        ));
    }

    public function update()
    {
        $id = (int) $this->input->post('id_perawatan');
        if ($id <= 0) {
            echo json_encode(array('status' => 'error', 'message' => 'ID perawatan tidak valid.'));
            return;
        }
        $parsed = $this->_parse_post();
        if (isset($parsed['error'])) {
            echo json_encode(array('status' => 'error', 'message' => $parsed['error']));
            return;
        }
        $ok = $this->Perawatan_model->update($id, $parsed);
        echo json_encode(array(
            'status'  => $ok ? 'success' : 'error',
            'message' => $ok ? 'Data perawatan berhasil diperbarui.' : 'Data perawatan tidak ditemukan.'
        ));
    }

    public function selesai()
    {
        $id = (int) $this->input->post('id_perawatan');
        $ok = $this->Perawatan_model->mark_selesai($id);
        echo json_encode(array(
            'status'  => $ok ? 'success' : 'error',
            'message' => $ok ? 'Perawatan selesai, status unit disinkronkan ke Ready.' : 'Data tidak ditemukan.'
        ));
    }

    public function hapus()
    {
        $id = (int) $this->input->post('id_perawatan');
        $ok = $this->Perawatan_model->delete($id);
        echo json_encode(array(
            'status'  => $ok ? 'success' : 'error',
            'message' => $ok ? 'Catatan biaya perawatan berhasil dihapus.' : 'Data tidak ditemukan.'
        ));
    }

    private function _jenis_label($jenis)
    {
        $map = array(
            'servis'   => 'Servis & Oli',
            'asuransi' => 'Asuransi',
            'pajak'    => 'Pajak / KIR',
            'lainnya'  => 'Lainnya'
        );
        return isset($map[$jenis]) ? $map[$jenis] : ucfirst($jenis);
    }

    public function cetak_laporan()
    {
        $filters = $this->_collect_filters();
        $rows = $this->Perawatan_model->get_all($filters, 'ASC');
        $summary = $this->Perawatan_model->get_summary($filters);

        $periode_label = 'Semua Periode';
        if (!empty($filters['bulan'])) {
            $parts = explode('-', $filters['bulan']);
            if (count($parts) === 2) {
                $periode_label = 'Bulan ' . nama_bulan_id($parts[1]) . ' ' . $parts[0];
            }
        }

        require_once APPPATH . 'libraries/tcpdf/Tcpdf.php';

        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('CV. Graha Transport');
        $pdf->SetAuthor('CV. Graha Transport');
        $pdf->SetTitle('Laporan Biaya Perawatan Unit CV. Graha Transport');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();

        $header_html = '
        <table cellpadding="5" cellspacing="0" border="0" style="width:100%;">
            <tr>
                <td style="background-color:#1A44B2; color:#ffffff; text-align:center; font-size:13pt; font-weight:bold;">
                    LAPORAN BIAYA PERAWATAN, ASURANSI &amp; PAJAK UNIT CV. GRAHA TRANSPORT
                </td>
            </tr>
            <tr>
                <td style="text-align:center; font-size:10pt; font-weight:bold; color:#222222; padding-top:4px;">
                    ' . htmlspecialchars($periode_label) . '
                </td>
            </tr>
        </table>';
        $pdf->writeHTML($header_html, true, false, true, false, '');
        $pdf->Ln(2);

        if (empty($rows)) {
            $pdf->SetFont('helvetica', 'I', 10);
            $pdf->Cell(0, 10, 'Tidak ada data biaya perawatan pada periode yang dipilih.', 0, 1, 'C');
        } else {
            $tbl = '<table cellpadding="4" cellspacing="0" border="1" style="border-color:#555555; width:100%; font-size:8pt;">'
                . '<thead>'
                . '<tr style="background-color:#1f4e78; color:#ffffff; font-weight:bold;">'
                . '<th width="4%" align="center">No</th>'
                . '<th width="9%" align="center">Tanggal</th>'
                . '<th width="14%" align="left">Unit &amp; Plat</th>'
                . '<th width="10%" align="center">Kategori</th>'
                . '<th width="20%" align="left">Rincian / Pekerjaan</th>'
                . '<th width="13%" align="left">Bengkel / Vendor</th>'
                . '<th width="10%" align="center">Kilometer</th>'
                . '<th width="9%" align="center">Jatuh Tempo</th>'
                . '<th width="11%" align="right">Nominal</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';

            $no = 1;
            foreach ($rows as $r) {
                $km_txt = '-';
                if (!empty($r->km_saat_ini) || !empty($r->km_berikutnya)) {
                    $km_txt = ($r->km_saat_ini ? number_format((int) $r->km_saat_ini, 0, ',', '.') : '-')
                        . ($r->km_berikutnya ? ' -> ' . number_format((int) $r->km_berikutnya, 0, ',', '.') : '');
                }
                $tbl .= '<tr>'
                    . '<td width="4%" align="center">' . $no++ . '</td>'
                    . '<td width="9%" align="center">' . format_tanggal_id($r->tanggal_transaksi) . '</td>'
                    . '<td width="14%" align="left"><b>' . htmlspecialchars($r->nama_unit) . '</b>' . (!empty($r->plat_nomor) ? '<br/>' . htmlspecialchars($r->plat_nomor) : '') . '</td>'
                    . '<td width="10%" align="center">' . htmlspecialchars($this->_jenis_label($r->jenis_biaya)) . '</td>'
                    . '<td width="20%" align="left"><b>' . htmlspecialchars($r->judul_biaya) . '</b>' . (!empty($r->keterangan) ? '<br/>' . htmlspecialchars($r->keterangan) : '') . '</td>'
                    . '<td width="13%" align="left">' . htmlspecialchars($r->vendor_bengkel ?: '-') . '</td>'
                    . '<td width="10%" align="center">' . htmlspecialchars($km_txt) . '</td>'
                    . '<td width="9%" align="center">' . format_tanggal_id($r->tanggal_jatuh_tempo) . '</td>'
                    . '<td width="11%" align="right"><b>' . format_rupiah($r->nominal) . '</b></td>'
                    . '</tr>';
            }

            $tbl .= '<tr style="background-color:#f2f4f8; font-weight:bold;">'
                . '<td colspan="8" align="right">TOTAL BIAYA PERAWATAN (' . count($rows) . ' ITEM)</td>'
                . '<td align="right" style="color:#c0392b;">' . format_rupiah($summary['total_biaya']) . '</td>'
                . '</tr>'
                . '</tbody></table><br/>';

            $tbl .= '<table cellpadding="5" cellspacing="0" border="1" style="border-color:#555555; width:100%; font-size:8.5pt;">'
                . '<tr style="background-color:#e9eef7; font-weight:bold;">'
                . '<td width="25%">Servis &amp; Oli: ' . format_rupiah($summary['total_servis']) . '</td>'
                . '<td width="25%">Asuransi: ' . format_rupiah($summary['total_asuransi']) . '</td>'
                . '<td width="25%">Pajak / KIR: ' . format_rupiah($summary['total_pajak']) . '</td>'
                . '<td width="25%">Lainnya: ' . format_rupiah($summary['total_lainnya']) . '</td>'
                . '</tr>'
                . '</table>';

            $pdf->writeHTML($tbl, true, false, true, false, '');
        }

        $filename = 'Laporan_Perawatan_Unit_' . date('Ymd_His') . '.pdf';
        $pdf->Output($filename, 'I');
    }

    public function export_excel()
    {
        $filters = $this->_collect_filters();
        $rows = $this->Perawatan_model->get_all($filters, 'ASC');
        $summary = $this->Perawatan_model->get_summary($filters);

        $prev_err = error_reporting(E_ERROR | E_PARSE);
        require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $excel = new PHPExcel();
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle('Biaya Perawatan');

        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'LAPORAN BIAYA PERAWATAN, ASURANSI & PAJAK UNIT - CV. GRAHA TRANSPORT');
        $sheet->getStyle('A1')->applyFromArray(array(
            'font' => array('bold' => true, 'size' => 13, 'color' => array('rgb' => 'FFFFFF')),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '1A44B2')),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)
        ));
        $sheet->getRowDimension(1)->setRowHeight(24);

        $headers = array('No', 'Tanggal', 'Nama Unit', 'Plat Nomor', 'Kategori', 'Rincian Biaya', 'Bengkel / Vendor', 'KM Sekarang -> Berikutnya', 'Jatuh Tempo', 'Nominal');
        $cols = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        foreach ($headers as $idx => $h) {
            $cell = $cols[$idx] . '3';
            $sheet->setCellValue($cell, $h);
            $sheet->getStyle($cell)->applyFromArray(array(
                'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '4472C4')),
                'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ));
        }

        $r_idx = 4;
        $no = 1;
        foreach ($rows as $row) {
            $km_txt = ($row->km_saat_ini ? number_format((int) $row->km_saat_ini, 0, ',', '.') : '-')
                . ($row->km_berikutnya ? ' -> ' . number_format((int) $row->km_berikutnya, 0, ',', '.') : '');
            $sheet->setCellValue('A' . $r_idx, $no++);
            $sheet->setCellValue('B' . $r_idx, format_tanggal_id($row->tanggal_transaksi));
            $sheet->setCellValue('C' . $r_idx, $row->nama_unit);
            $sheet->setCellValue('D' . $r_idx, $row->plat_nomor ?: '-');
            $sheet->setCellValue('E' . $r_idx, $this->_jenis_label($row->jenis_biaya));
            $sheet->setCellValue('F' . $r_idx, $row->judul_biaya . ($row->keterangan ? ' (' . $row->keterangan . ')' : ''));
            $sheet->setCellValue('G' . $r_idx, $row->vendor_bengkel ?: '-');
            $sheet->setCellValue('H' . $r_idx, $km_txt);
            $sheet->setCellValue('I' . $r_idx, format_tanggal_id($row->tanggal_jatuh_tempo));
            $sheet->setCellValue('J' . $r_idx, (float) $row->nominal);
            $sheet->getStyle('J' . $r_idx)->getNumberFormat()->setFormatCode('"Rp"#,##0');
            $r_idx++;
        }

        $sheet->mergeCells('A' . $r_idx . ':I' . $r_idx);
        $sheet->setCellValue('A' . $r_idx, 'TOTAL BIAYA PERAWATAN');
        $sheet->setCellValue('J' . $r_idx, (float) $summary['total_biaya']);
        $sheet->getStyle('A' . $r_idx . ':J' . $r_idx)->getFont()->setBold(true);
        $sheet->getStyle('J' . $r_idx)->getNumberFormat()->setFormatCode('"Rp"#,##0');

        foreach ($cols as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        $filename = 'Laporan_Perawatan_Unit_' . date('Ymd_His') . '.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $writer->save('php://output');
        error_reporting($prev_err);
        exit;
    }
}
