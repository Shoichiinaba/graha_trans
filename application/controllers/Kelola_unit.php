<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelola_unit extends AUTH_Controller
{

    var $template = 'template/index';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Unit_model');
        $this->load->library('upload');
        $this->load->helper('encryption_helper');
    }

    public function index()
    {
        $data['tittle']               = 'Graha Transport | Kelola Unit';
        $data['userdata']             = $this->userdata;
        $data['filter_kategori']      = $this->Unit_model->get_filter_kategori();
        $data['tahun']                = $this->Unit_model->get_filter_tahun();
        $data['transmisi']        = $this->Unit_model->get_filter_transmisi();
        $data['content']              = 'page_admin/unit/unit_mobil';
        $data['script']               = 'page_admin/unit/unit_js';
        $this->load->view($this->template, $data);
    }

    public function fetch()
    {
        $output = '';

        // Ambil input
        $limit = (int) $this->input->post('limit');
        $start = (int) $this->input->post('start');

        // Validasi
        if ($limit <= 0) {
            $limit = 10; // default jumlah data
        }

        if ($start < 0) {
            $start = 0;
        }

        $search            = trim($this->input->post('search'));
        $filter_kategori  = trim($this->input->post('unit_kategori'));
        $filter_tahun     = trim($this->input->post('tahun'));
        $filter_transmisi = trim($this->input->post('transmisi'));

        // Ambil data
        $data = $this->Unit_model->get_unit(
            $limit,
            $start,
            $search,
            $filter_kategori,
            $filter_tahun,
            $filter_transmisi
        );

        $total_data = $this->Unit_model->count_unit(
            $search,
            $filter_kategori,
            $filter_tahun,
            $filter_transmisi
        );

        // Hindari division by zero
        $total_pages = ($limit > 0) ? ceil($total_data / $limit) : 1;

        if ($data->num_rows() > 0) {

            foreach ($data->result() as $prop) {

                $date = new DateTime($prop->tanggal_upload);
                $formattedDate = $date->format('j F Y');

                $harga = floor($prop->price) == $prop->price
                    ? number_format($prop->price, 0, ',', '.')
                    : number_format($prop->price, 1, ',', '.');

                $output .= '
                <div class="col-lg-6 col-md-6 col-sm-6 pb-2">

                    <!-- Desktop -->
                    <div class="row d-none d-md-flex align-items-center p-2">
                        <div class="card position-relative">
                            <div class="row">

                                <div class="image-pro position-relative">
                                    <div class="ribbon ribbon-top-left">
                                        <span>' . $prop->tataletak_web . '</span>
                                    </div>

                                    <img class="card-img card-img-left"
                                        src="' . base_url('assets/img/car/' . $prop->gambar) . '"
                                        alt="Card image" />

                                    <a class="btn btn-primary btn-view btn-edit"
                                        data-id="'. $prop->id_unit .'">
                                            <i class="menu-icon tf-icons bx bx-bot text-white"></i>
                                            Edit
                                    </a>

                                    <a class="btn btn-danger btn-del" title="hapus" data-id="'. $prop->id_unit .'">
                                        <i class="menu-icon tf-icons bx bx-trash text-white"></i>
                                        Delete
                                    </a>
                                </div>

                                <div class="col-md-8">

                                    <div class="desk pt-2 pb-1">

                                        <div class="row mb-3">
                                            <div class="col-lg-5">
                                                <p class="card-text badge bg-warning rounded-3">
                                                    <small class="text-white text-uppercase">
                                                        ' . $prop->kategori . '
                                                    </small>
                                                </p>
                                            </div>
                                        </div>

                                        <h3 class="harga text-primary mb-2">
                                            Rp. ' . $harga .' K
                                        </h3>

                                        <h4 class="display-7 unit pt-0 mb-1 d-flex align-items-center">
                                            ' . $prop->nama_unit . '
                                            <span class="badge bg-label-warning ms-2 shadow-lg rounded-3 px-8 py-7 fs-6">
                                                ' . $prop->transmition . '
                                            </span>
                                        </h4>

                                        <div>
                                            <small class="footer-link me-4">Fuel : ' . $prop->fuel . '</small>
                                            <small class="footer-link me-4">Seat : ' . $prop->seat . '</small>
                                            <small class="footer-link me-4">Tahun : ' . $prop->tahun . '</small>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="position-absolute top-0 end-0 mt-2 me-3">
                                <p class="card-text">
                                    <small class="text-muted tayang">
                                        Tayang Sejak ' . $formattedDate . '
                                    </small>
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Mobile -->
                    <div class="d-block d-md-none">

                        <div class="card shadow-sm">

                            <img class="card-img-top"
                                src="' . base_url('assets/img/car/' . $prop->gambar) . '"
                                alt="Card image">

                            <div class="card-body pt-3">

                                <div class="d-flex justify-content-between align-items-center mb-2">

                                    <p class="card-text badge bg-warning rounded-3 mb-0">
                                        <small class="text-white text-uppercase">
                                            ' . $prop->kategori . '
                                        </small>
                                    </p>

                                    <p class="card-text mb-0">
                                        <small class="text-muted">
                                            Tayang Sejak ' . $formattedDate . '
                                        </small>
                                    </p>

                                </div>

                                <h3 class="harga text-primary mb-2">
                                    Rp. ' . $harga . '
                                </h3>

                                <h4 class="unit mb-1">
                                    ' . $prop->nama_unit . '
                                </h4>

                                <div class="d-flex justify-content-between mb-3">
                                    <small class="footer-link">Fuel : ' . $prop->fuel . '</small>
                                    <small class="footer-link">Seat : ' . $prop->seat . '</small>
                                    <small class="footer-link">Transmisi : ' . $prop->transmition . '</small>
                                    <small class="footer-link">Tahun : ' . $prop->tahun . '</small>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>';
            }

            echo json_encode([
                'data' => $output,
                'total_pages' => $total_pages,
                'total_data' => $total_data
            ]);

        } else {

            echo json_encode([
                'data' => '',
                'total_pages' => 0,
                'total_data' => 0
            ]);
        }
    }

// kode simpan tambah data unit
    public function tambah()
    {
        $uploadPath = FCPATH . 'assets/img/car/';

        // Cek folder upload
        if (!is_dir($uploadPath)) {
            echo json_encode([
                'status' => false,
                'message' => 'Folder upload tidak ditemukan : ' . $uploadPath
            ]);
            return;
        }

        // Cek permission
        if (!is_writable($uploadPath)) {
            echo json_encode([
                'status' => false,
                'message' => 'Folder tidak memiliki izin tulis.'
            ]);
            return;
        }

        $config['upload_path']   = $uploadPath;
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 10240; // 10 MB

        $this->load->library('upload');

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('gambar')) {

            echo json_encode([
                'status'  => false,
                'message' => strip_tags($this->upload->display_errors())
            ]);
            return;
        }

        $upload = $this->upload->data();

        // Compress gambar
        $this->compress_image($upload['full_path']);

        $data = [
            'nama_unit'      => $this->input->post('nama_unit', true),
            'kategori'       => $this->input->post('kategori', true),
            'tataletak_web'  => $this->input->post('tataletak_web', true),
            'seat'           => $this->input->post('seat', true),
            'fuel'           => $this->input->post('fuel', true),
            'transmition'    => $this->input->post('transmition', true),
            'tahun'          => $this->input->post('tahun', true),
            'price'          => $this->input->post('price', true),
            'gambar'         => $upload['file_name'],
            'tanggal_upload' => date('d-m-Y')
        ];

        $this->db->insert('unit_mobil', $data);

        echo json_encode([
            'status'  => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function hapus_unit()
    {
        $id_unit = $this->input->post('id_unit');

        $unit = $this->Unit_model->get_unit_by_id($id_unit);

        if ($unit) {

            $path = FCPATH . 'assets/img/car/' . $unit->gambar;

            if (!empty($unit->gambar) && file_exists($path)) {
                unlink($path);
            }

            $this->Unit_model->delete_unit($id_unit);

            echo json_encode([
                'status' => 'success',
                'message' => 'Data berhasil dihapus.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'ID Unit tidak ditemukan.'
            ]);
        }
    }


    // ubah unit
    public function get_unit()
    {
        $id = $this->input->post('id_unit');

        $unit = $this->Unit_model->get_unit_by_id($id);

        echo json_encode($unit);
    }

    public function update_unit()
    {
        $id_unit = $this->input->post('id_unit');

        // Ambil data lama
        $unit = $this->Unit_model->get_unit_by_id($id_unit);

        if (!$unit) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
            return;
        }

        $data = [
            'nama_unit'      => $this->input->post('nama_unit'),
            'kategori'       => $this->input->post('kategori'),
            'tataletak_web'  => $this->input->post('tataletak_web'),
            'seat'           => $this->input->post('seat'),
            'fuel'           => $this->input->post('fuel'),
            'transmition'    => $this->input->post('transmition'),
            'tahun'          => $this->input->post('tahun'),
            'price'          => $this->input->post('price'),
        ];

        // ============================
        // Jika ada gambar baru
        // ============================
        if (!empty($_FILES['gambar']['name'])) {


            $config['upload_path']   = './assets/img/car/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('gambar')) {

                // Hapus gambar lama
                $oldFile = FCPATH . 'assets/img/car/' . $unit->gambar;

                if (!empty($unit->gambar) && file_exists($oldFile)) {
                    unlink($oldFile);
                }

                // Simpan gambar baru
                $uploadData = $this->upload->data();
                $data['gambar'] = $uploadData['file_name'];

            } else {

                echo json_encode([
                    'status' => 'error',
                    'message' => strip_tags($this->upload->display_errors())
                ]);
                return;
            }
        }

        $this->Unit_model->update_unit($id_unit, $data);

        echo json_encode([
            'status' => 'success',
            'message' => 'Data berhasil diperbarui.'
        ]);
    }

    private function compress_image($source)
    {
        $this->load->library('image_lib');

        $config['image_library']  = 'gd2';
        $config['source_image']   = $source;
        $config['maintain_ratio'] = TRUE;

        // Resize maksimal 1600 px
        $config['width']          = 1600;
        $config['height']         = 1600;

        // kualitas
        $config['quality']        = '70%';

        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            log_message('error', $this->image_lib->display_errors());
        }

        $this->image_lib->clear();
    }

}