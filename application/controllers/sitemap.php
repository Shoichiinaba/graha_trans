<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller
{
    public function index()
    {
        header("Content-Type: text/xml;charset=UTF-8");

        $this->load->model('Landing_model');

        $data['berita'] = $this->Landing_model->get_all_sitemap();

        $this->load->view('sitemap', $data);
    }
}