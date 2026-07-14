<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelola_video extends AUTH_Controller
{

    var $template = 'template/index';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reels_model');
    }

    public function index()
    {
        $data['tittle']          = 'kanpa.co.id | Video Reels';
        $data['userdata']        = $this->userdata;
        $data['prop_select']     = $this->Reels_model->get_properti_select();
        $data['content']         = 'page_admin/reels/reels';
        $data['script']          = 'page_admin/reels/reels_js';
        $this->load->view($this->template, $data);
    }

    public function upload_video() {
        $config['upload_path'] = './upload/videos/';
        $config['allowed_types'] = 'mp4|mov|avi|wmv';
        $config['max_size'] = 102400;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('video_reels')) {
            $data = $this->upload->data();
            $video_path = $data['file_name'];

            echo json_encode(['status' => 'success', 'video_path' => $video_path]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
        }
    }


    public function simpan_reels() {
        $id_properti    = $this->input->post('id_properti');
        $judul          = $this->input->post('judul');
        $sosial_media   = $this->input->post('sosmed');
        $deskripsi      = $this->input->post('deskripsi');
        $video          = $this->input->post('video');


        // Validasi input
        if (empty($id_properti) || empty($sosial_media) || empty($deskripsi)) {
            echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi']);
            return;
        }

        // Validasi video
        if (empty($video)) {
            echo json_encode(['status' => 'error', 'message' => 'Video tidak ada']);
            return;
        }

        $data = array(
            'id_properti' => $id_properti,
            'judul_reels' => $judul,
            'sosial_media' => $sosial_media,
            'deskripsi' => $deskripsi,
            'video' => $video,
            'uploaded' => date('d-m-Y')
        );

        // Simpan data reels
        if ($this->Reels_model->insert_reels($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Reels berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan reels']);
        }
    }

    public function fetch_reels()
    {
        $output = '';
        $limit = $this->input->post('limit');
        $start = $this->input->post('start');
        $search = $this->input->post('search');

        $data = $this->Reels_model->get_reels($limit, $start, $search);
        $total_data = $this->Reels_model->count_reels($search);
        $total_pages = ceil($total_data / $limit);

        $output = '';
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $reels) {
                $date = new DateTime($reels->uploaded);
                $formattedDate = $date->format('j F Y');

                $output .= '
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card h-100 position-relative card-hover">
                                <video class="custom-video" controls>
                                    <source src="' . base_url('upload/videos/' . $reels->video) . '" type="video/mp4">
                                </video>
                                <p class="badge-overlay card-text badge bg-warning rounded-3">
                                    <small class="text-white text-uppercase text-end">' . $reels->judul_properti . '</small>
                                </p>
                                <div class="edit-overlay">
                                    <button type="button" class="btn btn-sm btn-warning btn-edit ubah-data rounded-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#ubah-reels"
                                        data-id="' . $reels->id_reel . '"
                                        data-judul="' . $reels->judul_reels . '"
                                        data-sosmed="' . $reels->sosial_media . '"
                                        data-deskripsi="' . $reels->deskripsi . '"
                                        data-idproperti="' . $reels->id_properti . '"
                                        data-judulproperti="' . $reels->judul_properti . '"
                                        data-video="' . $reels->video . '">
                                        <i class="menu-icon tf-icons bx bx-edit"></i>Edit
                                    </button>

                                    <button type="button" class="btn btn-sm btn-danger btn-delete rounded-3"
                                        data-id="' . $reels->id_reel . '">
                                        <i class="menu-icon tf-icons bx bx-trash"></i>Hapus
                                    </button>
                                </div>
                                <div class="card-body pb-0 content-blur">
                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <h5 class="card-title">' . $reels->judul_reels . '</h5>
                                        </div>
                                    </div>
                                    <p class="card-text pt-1 mb-0 deskripsi-justify">
                                        ' . $reels->deskripsi . '
                                    </p>
                                    <div class="card-text-wrapper">
                                        <p class="card-text date-left"><small class="text-muted">' . $formattedDate . '</small></p>
                                        <p class="card-text date-right"><small class="text-muted"> ' .  $reels->views . ' Viewer</small></p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    ';

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

    public function simpan_ubah_reels()
    {
        $config['upload_path'] = './upload/videos/';
        $config['allowed_types'] = 'mp4|mov|avi';
        $config['max_size'] = 102400;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        $id_reel = $this->input->post('id_reel');

        if ($id_reel) {
            $existing_reel = $this->Reels_model->get_reel_by_id($id_reel);
            $old_video = $existing_reel->video;
        }

        // Coba upload video baru
        if ($this->upload->do_upload('video')) {
            $upload_data = $this->upload->data();
            $video_name = $upload_data['file_name'];

            // Hapus video lama dari direktori jika ada
            if (!empty($old_video) && file_exists('./upload/videos/' . $old_video)) {
                unlink('./upload/videos/' . $old_video);
            }
        } else {
            if (empty($_FILES['video']['name'])) {
                // Jika tidak ada video baru yang diunggah, gunakan video lama
                $video_name = isset($old_video) ? $old_video : '';
            } else {
                // Jika ada error selain tidak ada file yang dipilih
                $response = [
                    'status' => 'error',
                    'message' => $this->upload->display_errors()
                ];
                echo json_encode($response);
                return;
            }
        }

        // Data yang akan disimpan
        $data = [
            'id_properti' => $this->input->post('id_properti'),
            'judul_reels' => $this->input->post('ubah-judul'),
            'video' => $video_name,
            'sosial_media' => $this->input->post('ubah-sosmed'),
            'deskripsi' => $this->input->post('ubah-deskripsi'),
        ];

        if ($id_reel) {
            // Update data jika id_reel ada
            $this->Reels_model->update_reel($id_reel, $data);
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil diperbarui.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'ID Reel tidak ditemukan.'
            ];
        }

        echo json_encode($response);
    }

    // kode hapus reels
    public function hapus_reel()
    {
        $id_reel = $this->input->post('id_reel');

        $reel = $this->Reels_model->get_reel_by_id($id_reel);
        if ($reel) {
            $video_name = $reel->video;

            if (!empty($video_name) && file_exists('./upload/videos/' . $video_name)) {
                unlink('./upload/videos/' . $video_name);
            }

            $this->Reels_model->delete_reel($id_reel);

            echo json_encode([
                'status' => 'success',
                'message' => 'Data berhasil dihapus.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'ID Reel tidak ditemukan.'
            ]);
        }
    }


}