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

    public function index()
    {
        $data['tittle']       = 'Graha Transportasi | Dashboard';
        $data['userdata']     = $this->userdata;
        $data['total_unit']   = $this->db->count_all('unit_mobil');

        $data['unit_ready'] = $this->db
            ->where('status', 'ready')
            ->count_all_results('unit_mobil');

        $data['unit_rental'] = $this->db
            ->where('status', 'rental')
            ->count_all_results('unit_mobil');

        $data['unit_service'] = $this->db
            ->where('status', 'service')
            ->count_all_results('unit_mobil');

        $data['sewa_summary'] = $this->Sewa_model->get_summary(array('bulan' => date('Y-m')));
        $data['overdue_list'] = $this->Sewa_model->get_overdue();
        $data['kontrak_aktif'] = $this->db->where('status_kontrak', 'Aktif')->count_all_results('rental_kontrak');

        $data['content']      = 'page_admin/dashboard/dashboard';
        $data['script']       = 'page_admin/dashboard/dashboard_js';
        $this->load->view($this->template, $data);
    }

}
