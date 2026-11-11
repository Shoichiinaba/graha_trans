<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends AUTH_Controller
{
    var $template = 'template/index';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sewa_model');
        $this->load->helper('rental');
    }

    private function _calc_growth_pct($current, $previous)
    {
        $curr = (float) $current;
        $prev = (float) $previous;
        if ($prev <= 0) {
            return $curr > 0 ? 100.0 : 0.0;
        }
        return round((($curr - $prev) / $prev) * 100, 1);
    }

    public function index()
    {
        $curr_month = date('Y-m');
        $prev_month = date('Y-m', strtotime('first day of last month'));

        $curr_summary = $this->Sewa_model->get_summary(array('bulan' => $curr_month));
        $prev_summary = $this->Sewa_model->get_summary(array('bulan' => $prev_month));

        $trend_6m  = $this->Sewa_model->get_monthly_trend(6);
        $daily_cmp = $this->Sewa_model->get_daily_comparison();

        $top_units = $this->Sewa_model->get_top_units($curr_month, 5);
        $top_scope = 'Bulan Ini';
        if (empty($top_units)) {
            $top_units = $this->Sewa_model->get_top_units(null, 5);
            $top_scope = 'Semua Periode';
        }

        // Hitung rincian unit garasi vs luar untuk chart komposisi bulan ini (atau all-time fallback jika kosong)
        $last_idx = count($trend_6m['months']) - 1;
        $garasi_cnt_curr = $last_idx >= 0 ? (int) $trend_6m['count_garasi'][$last_idx] : 0;
        $luar_cnt_curr   = $last_idx >= 0 ? (int) $trend_6m['count_luar'][$last_idx] : 0;

        $data['tittle']             = 'Graha Transport | Dashboard Analitik';
        $data['userdata']           = $this->userdata;
        $data['total_unit']         = $this->db->count_all('unit_mobil');
        $data['unit_ready']         = $this->db->where('status', 'ready')->count_all_results('unit_mobil');
        $data['unit_rental']        = $this->db->where('status', 'rental')->count_all_results('unit_mobil');
        $data['unit_service']       = $this->db->where('status', 'service')->count_all_results('unit_mobil');
        $data['curr_month_label']   = nama_bulan_id((int) date('n')) . ' ' . date('Y');
        $data['prev_month_label']   = $daily_cmp['prev_label'];
        $data['sewa_summary']       = $curr_summary;
        $data['prev_summary']       = $prev_summary;
        $data['growth_omset']       = $this->_calc_growth_pct($curr_summary['total_masuk'], $prev_summary['total_masuk']);
        $data['growth_laba']        = $this->_calc_growth_pct($curr_summary['total_nett'], $prev_summary['total_nett']);
        $data['growth_unit']        = $this->_calc_growth_pct($curr_summary['total_transaksi'], $prev_summary['total_transaksi']);
        $data['overdue_list']       = $this->Sewa_model->get_overdue();
        $data['kontrak_aktif']      = $this->db->where('status_kontrak', 'Aktif')->count_all_results('rental_kontrak');
        $data['trend_6m']           = $trend_6m;
        $data['daily_cmp']          = $daily_cmp;
        $data['comp_counts']        = array('garasi' => $garasi_cnt_curr, 'luar' => $luar_cnt_curr);
        $data['top_units']          = $top_units;
        $data['top_scope']          = $top_scope;
        $data['recent_list']        = $this->Sewa_model->get_recent_transactions(6);

        $data['content']            = 'page_admin/dashboard/dashboard';
        $data['script']             = 'page_admin/dashboard/dashboard_js';
        $this->load->view($this->template, $data);
    }

    public function chart_data()
    {
        $months = (int) $this->input->get('months');
        if (!in_array($months, array(6, 12), true)) {
            $months = 6;
        }
        $trend = $this->Sewa_model->get_monthly_trend($months);
        $daily = $this->Sewa_model->get_daily_comparison();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'status' => 'success',
                'trend'  => $trend,
                'daily'  => $daily
            )));
    }
}
