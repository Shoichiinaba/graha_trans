<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AUTH_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->userdata = $this->session->userdata('userdata');

		$this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));

		if ($this->session->userdata('status') == '') {
			redirect('Auth');
		}
	}

	protected function get_user_position()
	{
		return isset($this->userdata->position) ? trim($this->userdata->position) : '';
	}

	protected function is_admin_operational()
	{
		return strtolower($this->get_user_position()) === 'admin_oprational';
	}

	protected function require_roles($allowed_roles = array())
	{
		if (empty($allowed_roles)) {
			return;
		}
		$current = strtolower($this->get_user_position());
		$normalized = array_map('strtolower', $allowed_roles);

		if (!in_array($current, $normalized, true)) {
			if ($this->input->is_ajax_request()) {
				$this->output
					->set_status_header(403)
					->set_content_type('application/json')
					->set_output(json_encode(array(
						'status' => 'error',
						'message' => 'Akses ditolak untuk role Anda.'
					)));
				exit;
			}
			$this->session->set_flashdata('error_akses', 'Anda tidak memiliki akses ke halaman tersebut.');
			redirect('Dashboard');
		}
	}
}
