<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_auth');
	}

	public function index()
	{
		$session = $this->session->userdata('status');

		$this->session->keep_flashdata('sukses');

		if ($session == '') {
			$this->load->view('page_admin/login/login');
		} else {
			redirect('Dashboard');
		}
	}


	public function login()
	{
		$this->form_validation->set_rules('username', 'Username or Email', 'required|min_length[4]|max_length[50]');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == TRUE) {

			$username = trim($this->input->post('username'));
			$password = trim($this->input->post('password'));

			$data = $this->M_auth->login($username, $password);

			if ($data == false) {
				$this->session->set_flashdata('result_login', '<br>Email atau Password yang anda masukkan salah.');
				redirect('Auth');
			} else {
				$session = [
					'userdata' => $data,
					'status' => "Logged in"
				];
				$this->session->set_userdata($session);
				redirect('Dashboard');
			}
		} else {
			$this->session->set_flashdata('result_login', '<br>Email dan Password harus diisi dengan benar.');
			redirect('Auth');
		}
	}

	function logout()
{
    $this->session->set_flashdata('sukses', 'Anda Telah Keluar dari Aplikasi');
    $this->session->sess_destroy();

    redirect('Auth');
}


}