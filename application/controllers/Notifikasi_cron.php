<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi_cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notifikasi_model');
    }

    public function run()
    {
        $token = trim((string) $this->input->get('token'));
        $setting = $this->Notifikasi_model->get_settings();

        if ($token === '' || !hash_equals((string) $setting->cron_token, $token)) {
            $this->output
                ->set_status_header(403)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'status'  => 'error',
                    'message' => 'Token cron tidak valid.'
                )));
            return;
        }

        $res = $this->Notifikasi_model->dispatch_overdue_notifications(false);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'status'       => 'success',
                'checked_at'   => date('Y-m-d H:i:s'),
                'overdue_unit' => $res['checked'],
                'notified'     => $res['sent']
            )));
    }
}

