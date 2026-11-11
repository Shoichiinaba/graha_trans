<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends AUTH_Controller
{

    var $template = 'template/index';
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['tittle']         = 'Graha Transportasi | Dashboard';
        $data['userdata']       = $this->userdata;
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
        $data['content']        = 'page_admin/dashboard/dashboard';
        $data['script']         = 'page_admin/dashboard/dashboard_js';
        $this->load->view($this->template, $data);
    }

}