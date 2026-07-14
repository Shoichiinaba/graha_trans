<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelola_banner extends AUTH_Controller
{

    var $template = 'template/index';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Banner_model');
    }

    public function index()
    {
        $data['tittle']          = 'Graha Transportasi | Banner';
        $data['userdata']        = $this->userdata;
        // $data['prop_select']     = $this->Banner_model->get_properti_select();
        $data['filter_type']     = $this->Banner_model->get_filter_type();
        $data['content']         = 'page_admin/banner/banner';
        $data['script']          = 'page_admin/banner/banner_js';
        $this->load->view($this->template, $data);
    }

    public function fetch_banner()
    {
        $output = '';
        $limit       = $this->input->post('limit');
        $start       = $this->input->post('start');
        $search      = $this->input->post('search');
        $filter_type = $this->input->post('bannerType');

        // var_dump($filter_type);
        // exit;

        $data = $this->Banner_model->get_banner($limit, $start, $search, $filter_type);
        $total_data = $this->Banner_model->count_banner($search, $filter_type);
        $total_pages = ceil($total_data / $limit);

        $output = '';
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $ban) {
                $date = new DateTime($ban->created);
                $formattedDate = $date->format('j F Y');

                $output .= '<div class="col-lg-12 col-md-12 col-sm-12 pb-2">';
                $output .= '<div class="card position-relative p-0">';
                $output .= '<div class="row align-items-center">';

                // =========================
                // Menentukan gambar banner
                // =========================
                if ($ban->type_banner == 'biasa') {

                    $banner_text = 'Biasa';
                    $banner_path = base_url('assets/img/baner_slider/' . $ban->foto_banner);

                } elseif ($ban->type_banner == 'promo') {

                    $banner_text = 'Promo';
                    $banner_path = base_url('assets/img/baner_promo/' . $ban->foto_banner);

                } else {

                    $banner_text = ucfirst($ban->type_banner);
                    $banner_path = base_url('assets/img/baner_slider/' . $ban->foto_banner);

                }

                // =========================
                // KOLOM GAMBAR
                // =========================
                $ribbon_class = ($ban->type_banner == 'promo') ? 'ribbon-promo' : 'ribbon-biasa';
                $output .= '<div class="col-md-3 banner-left position-relative">';

                $output .= '
                            <div class="ribbon ribbon-top-left '.$ribbon_class.'">
                            <span>'.$banner_text.'</span>
                            </div>

                            <div class="image-group">
                                <img src="'.$banner_path.'" alt="'.$ban->judul_promo.'">
                            </div>';
                $output .= '</div>';

                // =========================
                // KOLOM KETERANGAN
                // =========================
                $output .= '<div class="col-md-9 banner-right">';

                $output .= '<h3 class="text-primary fw-bold mb-2">'
                            .$ban->judul_promo.
                        '</h3>';

                if($ban->type_banner == 'promo'){
                    $output .= '<p class="text-muted mb-3">'
                                .$ban->ket_promo.
                            '</p>';
                }

                $output .= '<small class="banner-date text-muted">
                Tayang Sejak '.$formattedDate.'
                </small>';

                $output .= '</div>';


                $output .= '</div>'; // row
                // =========================
                // Tombol Action
                // =========================
                $output .= '
                        <div class="action-buttons">

                            <button class="btn btn-danger btn-sm btn-delete"
                                data-id="'.$ban->id_banner.'">
                                <i class="bx bx-trash"></i>
                            </button>

                            <button
                                class="btn btn-success btn-sm ms-2 ubah-data"
                                data-bs-toggle="modal"
                                data-bs-target="#edit-banner"
                                data-id_banner="'.$ban->id_banner.'"
                                data-id_unit="'.$ban->id_unit.'"
                                data-type_banner="'.$ban->type_banner.'"
                                data-judul="'.$ban->judul_promo.'"
                                data-ket="'.$ban->ket_promo.'"
                                data-diskon="'.$ban->diskon.'"
                                data-foto="'.$ban->foto_banner.'">

                                <i class="bx bx-message-rounded-edit"></i>

                            </button>

                        </div>';
                $output .= '</div>'; // card
                $output .= '</div>'; // col
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

    public function get_unit()
    {

        $data = $this->Banner_model->get_unit();

        echo json_encode($data);

    }

    public function upload_banner()
    {

        $type_banner = strtolower($this->input->post('type_banner'));

        $id_unit      = $this->input->post('id_unit');
        $judul_promo  = $this->input->post('judul_promo');
        $ket_promo    = $this->input->post('ket_promo');
        $diskon       = $this->input->post('diskon');

        if(empty($_FILES['foto_banner']['name'])){

            echo json_encode([
                'status'=>'error',
                'message'=>'File banner belum dipilih'
            ]);

            return;
        }

        $config['allowed_types']='jpg|jpeg|png|webp';
        $config['max_size']=1024;

        if($type_banner=="promo"){

            $config['upload_path']='./assets/img/baner_promo/';

        }else{

            $config['upload_path']='./assets/img/baner_slider/';

        }

        $config['file_name']=$type_banner.'_'.time();

        $this->load->library('upload');

        $this->upload->initialize($config);

        if(!$this->upload->do_upload('foto_banner')){

            echo json_encode([
                'status'=>'error',
                'message'=>$this->upload->display_errors('','')
            ]);

            return;

        }

        $upload=$this->upload->data();

        $data=array(

            'type_banner'=>$type_banner,

            'foto_banner'=>$upload['file_name'],

            'created'=>date('Y-m-d H:i:s')

        );

        if($type_banner=="promo"){

            $data['id_unit']=$id_unit;
            $data['judul_promo']=$judul_promo;
            $data['ket_promo']=$ket_promo;
            $data['diskon']=$diskon;

        }else{

            $data['id_unit']=NULL;
            $data['judul_promo']=NULL;
            $data['ket_promo']=NULL;
            $data['diskon']=NULL;

        }

        $this->Banner_model->insert_banner($data);

        echo json_encode([
            'status'=>'success',
            'message'=>'Banner berhasil ditambahkan'
        ]);

    }

    public function hapus_banner()
    {
        $id_banner = $this->input->post('id_banner');

        $banner = $this->Banner_model->get_banner_by_id($id_banner);

        if (!$banner) {

            echo json_encode([
                'status' => 'error',
                'message' => 'Data banner tidak ditemukan.'
            ]);
            return;
        }

        // Tentukan folder gambar berdasarkan type banner
        if ($banner->type_banner == 'biasa') {

            $path = FCPATH . 'assets/img/baner_slider/';

        } elseif ($banner->type_banner == 'promo') {

            $path = FCPATH . 'assets/img/baner_promo/';

        } else {

            $path = FCPATH . 'assets/img/baner_slider/';

        }

        // Hapus file jika ada
        if (!empty($banner->foto_banner)) {

            $file = $path . $banner->foto_banner;

            if (file_exists($file)) {
                unlink($file);
            }

        }

        // Hapus data database
        $this->Banner_model->delete_banner($id_banner);

        echo json_encode([
            'status' => 'success',
            'message' => 'Banner berhasil dihapus.'
        ]);
    }

    // code ubah banner
    public function updateBannerData()
    {

        $id_banner=$this->input->post('id_banner');

        $banner=$this->Banner_model->get_banner_by_id($id_banner);

        if(!$banner){

            echo json_encode([
                "status"=>"error",
                "message"=>"Banner tidak ditemukan."
            ]);

            return;

        }

        $old_type=$banner->type_banner;

        $new_type=strtolower($this->input->post("type_banner"));

        $data=[

            "type_banner"=>$new_type

        ];

        if($new_type=="promo"){

            $data["id_unit"]=$this->input->post("id_unit");
            $data["judul_promo"]=$this->input->post("judul_promo");
            $data["ket_promo"]=$this->input->post("ket_promo");
            $data["diskon"]=$this->input->post("diskon");

        }else{

            $data["id_unit"]=NULL;
            $data["judul_promo"]=NULL;
            $data["ket_promo"]=NULL;
            $data["diskon"]=NULL;

        }


        // folder lama

        $old_path=($old_type=="promo")
            ? FCPATH."assets/img/baner_promo/"
            : FCPATH."assets/img/baner_slider/";



        // folder baru

        $new_path=($new_type=="promo")
            ? FCPATH."assets/img/baner_promo/"
            : FCPATH."assets/img/baner_slider/";


        if(!empty($_FILES["foto_banner"]["name"])){

            $config["upload_path"]=$new_path;
            $config["allowed_types"]="jpg|jpeg|png|webp";
            $config["max_size"]=1024;
            $config["file_name"]=$new_type."_".time();

            $this->load->library("upload");
            $this->upload->initialize($config);

            if(!$this->upload->do_upload("foto_banner")){

                echo json_encode([
                    "status"=>"error",
                    "message"=>$this->upload->display_errors("","")
                ]);

                return;

            }

            $upload=$this->upload->data();

            $data["foto_banner"]=$upload["file_name"];

            if(file_exists($old_path.$banner->foto_banner)){

                unlink($old_path.$banner->foto_banner);

            }

        }

        $this->Banner_model->update_banner($id_banner,$data);

        echo json_encode([
            "status"=>"success",
            "message"=>"Banner berhasil diubah."
        ]);

    }


}