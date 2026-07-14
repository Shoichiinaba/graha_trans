<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class Maps extends AUTH_Controller
{
    var $template = 'template/index';
    private $api_key;

    public function __construct()
    {
        parent::__construct();
        $this->load->config('api_config');
        $this->api_key = $this->config->item('api_key');
    }

    public function index()
    {
        $data['tittle'] = 'kanpa.co.id | Kelola Maps';
        $api_url = 'https://admin.kanpa.co.id/Api/mapdata';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-API-KEY: ' . $this->api_key
        ));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response !== false && $http_code == 200) {
            $data['map_prov'] = json_decode($response, true);
        } elseif ($http_code == 401) {
            $decoded_response = json_decode($response, true);
            if (isset($decoded_response['message'])) {
                $data['error_message'] = $decoded_response['message'];
            } else {
                $data['error_message'] = 'Unauthorized access. Invalid or inactive API Key.';
            }
            $data['map_prov'] = [];
        } else {
            $data['error_message'] = 'An unexpected error occurred. Please try again later.';
            $data['map_prov'] = [];
        }

        $data['content']        = 'front/maps/map';
        $data['userdata']       = $this->userdata;
        $data['script']         = 'front/maps/map_js';
        $this->load->view($this->template, $data);
    }

    public function get_map()
    {
        $id = $this->input->post('id');

        $client = new Client();
        $api_url = 'https://admin.kanpa.co.id/Api/map?id=' . $id;

        try {
            $response = $client->request('GET', $api_url, [
                'headers' => [
                    'X-API-KEY' => $this->api_key
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $map_data = json_decode($response->getBody());

                if (isset($map_data->data[0]->svg_map)) {
                    $svg_map = trim($map_data->data[0]->svg_map);
                    echo json_encode(['svg_map' => $svg_map]);
                } else {
                    $this->session->set_flashdata('error_message', 'Data svg_map tidak ditemukan dalam respons API');
                    echo json_encode(['error' => 'Data svg_map tidak ditemukan dalam respons API']);
                }
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menghubungi API: ' . $response->getStatusCode());
                echo json_encode(['error' => 'Gagal menghubungi API']);
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error_message', 'Gagal menghubungi API: ' . $e->getMessage());
            echo json_encode(['error' => 'Gagal menghubungi API: ' . $e->getMessage()]);
        }
    }

    public function allColor()
    {
        $client = new \GuzzleHttp\Client();
        $api_url = 'https://admin.kanpa.co.id/Api/mapcolor';

        try {
            $response = $client->request('GET', $api_url, [
                'headers' => [
                    'X-API-KEY' => $this->api_key
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $response_body = $response->getBody();
                $data = json_decode($response_body, true);

                if (isset($data['data']) && is_array($data['data'])) {
                    $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(200)
                        ->set_output(json_encode([
                            'message' => '',
                            'results' => $data['data'],
                        ]));
                } else {
                    $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(200)
                        ->set_output(json_encode([
                            'message' => 'Data tidak ditemukan dalam respons API',
                            'results' => [],
                        ]));
                }
            } else {
                $this->output
                    ->set_content_type('application/json')
                    ->set_status_header($response->getStatusCode())
                    ->set_output(json_encode([
                        'message' => 'Gagal menghubungi API, status code: ' . $response->getStatusCode(),
                        'results' => [],
                    ]));
            }
        } catch (\Exception $e) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode([
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    'results' => [],
                ]));
        }
    }

}