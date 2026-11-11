<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelola_user extends AUTH_Controller
{

    var $template = 'template/index';
    public function __construct()
    {
        parent::__construct();
        $this->require_roles(array('Admin', 'Owner'));
        $this->load->model('Agent_model');
    }

    public function index()
    {
        $data['tittle']          = 'Graha Transport | User';
        $data['userdata']        = $this->userdata;
        $data['data_agent']      = $this->Agent_model->get_agent();
        $data['content']         = 'page_admin/user/user';
        $data['script']          = 'page_admin/user/user_js';
        $this->load->view($this->template, $data);
    }

    public function fetch_agent()
    {
        $output = '';
        $limit = $this->input->post('limit');
        $start = $this->input->post('start');
        $search = $this->input->post('search');

        $data = $this->Agent_model->get_agent($limit, $start, $search);
        $total_data = $this->Agent_model->count_agent($search);
        $total_pages = ceil($total_data / $limit);

        if (count($data) > 0) {
            foreach ($data as $agn) {
                $output .= '
                            <div class="col-lg-4 mb-4 order-0">
                                <div class="card shadow-lg position-relative">
                                    <div class="card-body pb-0">
                                        <div class="w-100">
                                            <div class="card-body pt-0 mt-0 mb-0 pb-0" style="position: relative; top: -7px; left: -40px;">
                                                <div class="d-flex align-items-center w-100">
                                                    <h5 class="card-title text-primary mb-0 me-4">'. $agn->nama_agent .'</h5>
                                                    <span class="badge bg-label-primary rounded-2 badge-small">
                                                        '. $agn->position .'
                                                    </span>
                                                </div>
                                                <ul class="list-unstyled">
                                                    <li class="d-flex mb-2 pb-1 pt-2">
                                                    <div class="avatar flex-shrink-0 me-3">
                                                        <img src="'. base_url('assets/img/admin/' . $agn->foto_profil) .'"
                                                            alt="'. $agn->nama_agent .'"
                                                            class="rounded shadow"
                                                            style="
                                                                width:80px;
                                                                height:80px;
                                                                object-fit:cover;
                                                                border:3px solid #fff;
                                                            ">
                                                    </div>

                                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between" style="padding-left:35px;">
                                                            <div class="me-0">
                                                                <h6 class="mb-0">'. $agn->alamat .'</h6>
                                                                <ul>
                                                                    <li class="text-muted list">'. $agn->username .'</li>
                                                                    <li class="text-muted list">'. $agn->email .'</li>
                                                                    <li class="text-muted list">'. $agn->no_tlp .'</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hover-buttons action-buttons">
                                        <button class="btn btn-danger btn-sm shadow rounded-2 btn-delete" title="hapus"  data-id="'. $agn->id_agency .'">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary btn-edit ubah-data rounded-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit-agent"
                                        data-id="' . $agn->id_agency . '"
                                        data-nama_agent="' . $agn->nama_agent . '"
                                        data-email="' . $agn->email . '"
                                        data-no_tlp="' . $agn->no_tlp . '"
                                        data-position="' . $agn->position . '"
                                        data-alamat="' . $agn->alamat . '"
                                        data-username="' . $agn->username . '"
                                        data-foto="' . $agn->foto_profil . '">
                                        <i class="bx bx-message-rounded-edit"></i>
                                    </button>
                                    </div>
                                </div>
                            </div>';
            }
            echo json_encode([
                'data' => $output,
                'total_pages' => $total_pages
            ]);
        } else {
            echo json_encode([
                'data' => '',
                'total_pages' => $total_pages
            ]);
        }
    }

    // code daftar agent baru
    public function daftar()
    {
        $response = ['status' => 'error', 'message' => 'Gagal menyimpan data agent.'];

        // Validasi input
        $this->form_validation->set_rules('nama_agent', 'Nama Agent', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('no_tlp', 'Phone', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('posisi', 'Posisi', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response['message'] = validation_errors();
            echo json_encode($response);
            return;
        }

        //cek email
        $email = $this->db->get_where('agency',[
            'email'=>$this->input->post('email')
        ])->row();

        if($email){
            echo json_encode([
                'status'=>'error',
                'message'=>'Email sudah digunakan.'
            ]);
            return;
        }

        //cek username
        $username = $this->db->get_where('agency',[
            'username'=>$this->input->post('username')
        ])->row();

        if($username){
            echo json_encode([
                'status'=>'error',
                'message'=>'Username sudah digunakan.'
            ]);
            return;
        }

        // Data yang diinputkan
        $data = [
            'nama_agent' => $this->input->post('nama_agent'),
            'email' => $this->input->post('email'),
            'no_tlp' => $this->input->post('no_tlp'),
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'position' => $this->input->post('posisi'),
            'alamat' => $this->input->post('alamat'),
            'created' => date('Y-m-d H:i:s')
        ];

        // Upload Foto Profile
        if(isset($_FILES['file']) && $_FILES['file']['name'] != ''){

            $config['upload_path']   = './assets/img/admin/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 3072;
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload',$config);

            if($this->upload->do_upload('file')){

                $upload = $this->upload->data();

                $data['foto_profil'] = $upload['file_name'];

            }else{

                echo json_encode([
                    'status'=>'error',
                    'message'=>$this->upload->display_errors('','')
                ]);
                return;

            }

        }

        // Simpan data agent ke database
        $insert_id = $this->Agent_model->insert_agent($data);

        if ($insert_id) {
            $response['status'] = 'success';
            $response['message'] = 'Data agent berhasil disimpan.';
        }

        echo json_encode($response);
    }

    public function hapus_agent()
    {
        $id_agent = $this->input->post('id_agent');

        $agent = $this->Agent_model->get_agent_by_id($id_agent);
        if ($agent) {
            $foto_name = $agent->foto_profil;

            if (!empty($foto_name) && file_exists('./assets/img/admin/' . $foto_name)) {
                unlink('./assets/img/admin/' . $foto_name);
            }

            $this->Agent_model->delete_agent($id_agent);

            echo json_encode([
                'status' => 'success',
                'message' => 'Data berhasil dihapus.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'ID Agent tidak ditemukan.'
            ]);
        }
    }

// kode ubah data agent
    public function updateAgentData() {
        $id_agent = $this->input->post('id_agent');

        $current_agent = $this->Agent_model->get_agent_by_id($id_agent);
        $old_foto_profil = isset($current_agent->foto_profil) ? $current_agent->foto_profil : '';

        $data = array(
            'nama_agent' => $this->input->post('nama_agent'),
            'email' => $this->input->post('email'),
            'no_tlp' => $this->input->post('no_tlp'),
            'username' => $this->input->post('username'),
            'alamat' => $this->input->post('alamat'),
            'position' => $this->input->post('posisi')
        );

        // Jika ada password baru
        if ($this->input->post('password')) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }

        // Proses upload foto jika ada
        if (!empty($_FILES['foto_profil']['name'])) {
            $config['upload_path'] = './assets/img/admin/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = 'profile_' . time();
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto_profil')) {
                $upload_data = $this->upload->data();
                $new_foto_profil = $upload_data['file_name'];

                if ($old_foto_profil && file_exists('./assets/img/admin/' . $old_foto_profil)) {
                    unlink('./assets/img/admin/' . $old_foto_profil);
                }

                $data['foto_profil'] = $new_foto_profil;
            } else {
                $error = $this->upload->display_errors();
                echo json_encode(['status' => 'error', 'message' => $error]);
                return;
            }
        } else {
            $data['foto_profil'] = $old_foto_profil;
        }

        $this->Agent_model->update_agent($id_agent, $data);
        echo json_encode(['status' => 'success']);
    }
}