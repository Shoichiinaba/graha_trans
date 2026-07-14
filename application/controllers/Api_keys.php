<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_keys extends AUTH_Controller
{
    var $template = 'template/index';

    function __construct()
    {
        parent::__construct();
        $this->load->model('GenerateKey_model');
    }

    public function index()
    {
        $data['tittle']         = 'kanpa.co.id | Create API Keys';
        $data['userdata']       = $this->userdata;
        $data['content']        = 'page_admin/api_keys/api_keys';
        $data['script']         = 'page_admin/api_keys/api_keys_js';
        $this->load->view($this->template, $data);
    }

    // Generate API Key
    public function generate_key()
    {
        $key_name = $this->input->post('key_name');

        if (!$key_name) {
            echo json_encode(array('status' => 'fail', 'message' => 'User ID is required'));
            http_response_code(400);
            return;
        }

        $api_key = bin2hex(random_bytes(32));

        $this->GenerateKey_model->save_key($key_name, $api_key);

        echo json_encode(array('status' => 'success', 'api_key' => $api_key));
        http_response_code(200);
    }

    public function fetch_key()
    {
        $output = '';
        $limit = $this->input->post('limit');
        $start = $this->input->post('start');
        $search = $this->input->post('search');

        // Ambil data dari model
        $data = $this->GenerateKey_model->get_key($limit, $start, $search);
        $total_data = $this->GenerateKey_model->count_key($search);
        $total_pages = ceil($total_data / $limit);

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $key) {
                $date = new DateTime($key->created_at);
                $formattedDate = $date->format('j F Y');
                $status = ($key->status == 'active')
                ? '<td class="font-weight-medium"><div id="status-' . $key->id . '" class="badge rounded-pill bg-label-success status-toggle" data-id="' . $key->id . '" data-status="active"><i class="bx bx-badge-check"></i> Active</div></td>'
                : '<td class="font-weight-medium"><div id="status-' . $key->id . '" class="badge rounded-pill bg-label-warning status-toggle" data-id="' . $key->id . '" data-status="inactive"><i class="bx bx-shield-x"></i></i> Inactive</div></td>';

                $output .= '
                            <li class="d-flex mb-0 mt-0 align-items-center key-data">
                                <div class="avatar me-2">
                                    <img src="' . base_url('assets/img/icons/unicons/3d-unlocked.png') . '" alt="User" class="rounded" />
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center">
                                    <div class="me-3 flex-grow-1">
                                        <small class="text-muted d-block mb-0">Key Name</small>
                                        <h6 class="mb-0">' . $key->key_name . '</h6>
                                    </div>
                                    <div class="me-3 flex-grow-1">
                                        <small class="text-muted d-block mb-0">Key Token</small>
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-2">' . $key->api_key . '</h6>
                                            <a href="#" class="bx bxs-copy btn-copy" title="Copy" data-key="' . $key->api_key . '"></a>
                                        </div>
                                    </div>
                                    <div class="me-3 flex-grow-1">
                                        <small class="text-muted d-block mb-0">Status</small>
                                        <div class="d-flex align-items-center">' . $status . '</div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <small class="text-muted d-block mb-0">Action</small>
                                        <button type="button" class="btn btn-xs btn-outline-danger rounded-pill btn-delete" title="Hapus" data-id="' . $key->id . '">
                                            <i class="bx bxs-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>';
            }

            // Kirim output sebagai JSON
            echo json_encode([
                'data' => $output,
                'total_pages' => $total_pages
            ]);
        } else {
            // Jika tidak ada data
            echo json_encode([
                'data' => '',
                'total_pages' => $total_pages
            ]);
        }
    }

    public function update_status()
    {
        $id = $this->input->post('id');
        $current_status = $this->input->post('status');

        $new_status = ($current_status == 'active') ? 'inactive' : 'active';

        $this->db->where('id', $id);
        $this->db->update('api_keys', ['status' => $new_status]);

        // Kirim status baru kembali ke frontend
        echo json_encode(['new_status' => $new_status]);
    }

    public function hapus_dataKey() {
        $id_key = $this->input->post('id_key');

        if ($id_key) {
            $result = $this->GenerateKey_model->delete_key($id_key);
            if ($result) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID Key tidak valid.']);
        }
    }

}