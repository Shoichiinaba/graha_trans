<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landingpage extends CI_Controller
{

    var $template = 'template_landing/index';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Landing_model');
    }

    public function index()
    {
        $data['canonical_url'] = base_url();
        $data['banner'] = $this->Landing_model->get_banner_biasa();
        $data['promo']  = $this->Landing_model->get_banner_promo();
        $data['client'] = $this->Landing_model->get_banner_client();
        $data['content']        = 'landing/index';
        $data['script']         = 'landing/index_js';
        $this->load->view($this->template, $data);
    }



    public function fetch_berita()
    {
        $output = '';

        // ===========================
        // Ambil Input & Validasi
        // ===========================
        $limit = (int)$this->input->post('limit');
        $start = (int)$this->input->post('start');

        if ($limit <= 0) {
            $limit = 6;
        }

        if ($start < 0) {
            $start = 0;
        }

        // ===========================
        // Ambil Data
        // ===========================
        $data       = $this->Landing_model->get_berita($limit, $start);
        $total_data = $this->Landing_model->count_berita();
        $total_pages = ($total_data > 0) ? ceil($total_data / $limit) : 0;

        // ===========================
        // Generate HTML
        // ===========================
        if ($data->num_rows() > 0) {

            foreach ($data->result() as $row) {

                $tanggal = date('d F Y', strtotime($row->tgl_berita));
                $tags    = explode(',', $row->tag_berita);

                $tag_html = '';
                foreach ($tags as $tag) {
                    if (trim($tag) !== '') {
                        $tag_html .= '
                            <span class="inline-block text-xs bg-teal-400/10 text-teal-300 px-3 py-1 rounded-full mr-2 mb-2">
                                #' . htmlspecialchars(trim($tag), ENT_QUOTES, 'UTF-8') . '
                            </span>
                        ';
                    }
                }

                $output .= '
                <article class="group rounded-[30px] overflow-hidden bg-[#1b2740] border border-white/10 hover:border-teal-400 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_0_35px_rgba(45,212,191,.20)]">

                    <div class="overflow-hidden">
                        <!-- DITAMBAHKAN: loading="lazy" -->
                        <img src="' . base_url('assets/img/berita/' . $row->foto_berita) . '"
                            alt="' . htmlspecialchars($row->meta_foto, ENT_QUOTES, 'UTF-8') . '"
                            loading="lazy"
                            class="w-full h-50 object-cover group-hover:scale-110 transition duration-700">
                    </div>

                    <div class="p-6">

                        <div class="flex justify-between text-sm text-slate-300 mb-3">
                            <span>
                                <i class="fa-solid fa-calendar-days text-teal-400" aria-hidden="true"></i>
                                ' . $tanggal . '
                            </span>

                            <span>
                                <i class="fa-solid fa-eye text-orange-400" aria-hidden="true"></i>
                                ' . number_format($row->view_berita) . '
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-white mb-3 line-clamp-2">
                            ' . htmlspecialchars($row->judul_berita, ENT_QUOTES, 'UTF-8') . '
                        </h3>

                        <p class="text-slate-300 text-sm leading-7 line-clamp-3">
                            ' . htmlspecialchars($row->meta_desk, ENT_QUOTES, 'UTF-8') . '
                        </p>

                        <div class="mt-5">
                            ' . $tag_html . '
                        </div>

                        <a href="' . base_url('Artikel/' . url_title($row->judul_berita, '-', TRUE)) . '"
                            class="inline-flex items-center gap-2 mt-6 text-teal-400 font-bold hover:gap-3 transition-all">
                            Baca Selengkapnya
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </a>

                    </div>

                </article>';
            }

            echo json_encode([
                'status'      => true,
                'data'        => $output,
                'total_data'  => $total_data,
                'total_pages' => $total_pages
            ]);
        } else {

            echo json_encode([
                'status'      => false,
                'data'        => '',
                'total_data'  => 0,
                'total_pages' => 0
            ]);
        }
    }

    public function artikel($id = null)
    {

        // ============================
        // Validasi ID
        // ============================
        if (empty($id) || !is_numeric($id)) {
            show_404();
        }

        // ============================
        // Tambah View
        // ============================
        $this->Landing_model->update_view($id);

        // ============================
        // Ambil Detail Berita
        // ============================
        $berita = $this->Landing_model->detail_berita($id);

        if (!$berita) {
            show_404();
        }

        // ============================
        // Data yang dikirim ke View
        // ============================
        $data['title'] = $berita->judul_berita;

        $data['berita'] = $berita;

        // Isi Artikel
        $data['isi'] = $this->Landing_model->isi_berita($id);

        // Gallery
        $data['gallery'] = $this->Landing_model->gallery_berita($id);

        // Sidebar Populer
        $data['populer'] = $this->Landing_model->berita_populer(5);

        // Sidebar Terbaru
        $data['terbaru'] = $this->Landing_model->berita_terbaru(5);

        // ============================
        // Load View
        // ============================
        $this->load->view('landing/detail_berita', $data);
    }
}
