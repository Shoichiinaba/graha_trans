<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller
{
    protected $template = 'template_landing/index';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Landing_model');
        $this->load->helper('url');
    }

    public function index($slug = '')
    {
        if (empty($slug)) {
            show_404();
        }

        // Cari berita berdasarkan slug dari judul
        $berita = $this->Landing_model->detail_berita($slug);

        if (!$berita) {
            show_404();
        }

        // Tambah view
        $this->Landing_model->update_view($berita->id_berita);

        // Isi artikel
        $isi = $this->Landing_model->isi_berita($berita->id_berita);

        $listIsi = [];

        foreach ($isi->result() as $row) {

            $gallery = $this->Landing_model->foto_berita($row->id_data_berita);

            $foto = [];

            foreach ($gallery->result() as $img) {
                $foto[] = $img->file_foto_berita;
            }

            $listIsi[] = [
                'id_data_berita' => $row->id_data_berita,
                'text_berita'    => $row->text_berita,
                'file_foto_btn'  => $row->file_foto_btn,
                'link_btn'       => $row->link_btn,
                'foto'           => $foto
            ];
        }

        $data['title']    = $berita->judul_berita;
        $data['berita']   = $berita;
        $data['isi']      = $listIsi;

        $data['populer'] = $this->Landing_model->berita_populer($berita->id_berita);
        $data['terbaru'] = $this->Landing_model->berita_terbaru($berita->id_berita);

        $data['content']  = 'landing/detail_berita';
        $data['script']   = 'landing/berita_js';

        $this->load->view($this->template, $data);
    }

    public function tag($slug = '')
    {
        if (empty($slug)) {
            show_404();
        }
        // contoh: kpr-subsidi -> Kpr Subsidi
        $tag = ucwords(str_replace('-', ' ', $slug));

        // Ambil semua artikel berdasarkan tag
        $data['berita'] = $this->Landing_model->berita_by_tag($tag);

        if (empty($data['berita'])) {
            show_404();
        }

        $data['title'] = 'Artikel Tag : '.$tag;
        $data['tag']   = $tag;

        // Sidebar
        $data['populer'] = $this->Landing_model->berita_populer(0, 5);
        $data['terbaru'] = $this->Landing_model->berita_terbaru(0, 5);

        $data['content'] = 'landing/tag_berita';
        $data['script']  = 'landing/berita_js';

        $this->load->view($this->template, $data);
    }

    public function fetch_tag()
    {
        $output = '';

        $slug  = $this->input->post('tag_berita');
        $limit = (int)$this->input->post('limit');
        $start = (int)$this->input->post('start');

        // var_dump($slug);
        // exit;

        if ($limit <= 0) {
            $limit = 6;
        }

        if ($start < 0) {
            $start = 0;
        }

        // slug menjadi nama tag
        $tag = ucwords(str_replace('-', ' ', $slug));

        $data = $this->Landing_model->get_tag($tag, $limit, $start);

        $total_data = $this->Landing_model->count_tag($tag);

        $total_pages = ($total_data > 0)
            ? ceil($total_data / $limit)
            : 0;

        if ($data->num_rows() > 0) {

            foreach ($data->result() as $row) {

                $tanggal = date('d F Y', strtotime($row->tanggal));

                $tags = explode(',', $row->tag_berita);

                $tag_html = '';

                foreach ($tags as $t) {

                    $tag_html .= '
                        <a href="'.base_url('tag/'.url_title(trim($t),'-',TRUE)).'">

                            <span class="inline-block
                            text-xs
                            bg-teal-400/10
                            text-teal-300
                            px-3 py-1
                            rounded-full
                            mr-2 mb-2
                            hover:bg-teal-400
                            hover:text-black
                            transition">

                                #'.trim($t).'

                            </span>

                        </a>
                    ';
                }

                $output .= '

                <article class="group rounded-[30px] overflow-hidden bg-[#13233b]
                    border border-white/10
                    hover:border-teal-400
                    transition-all duration-500
                    hover:-translate-y-2
                    hover:shadow-[0_0_35px_rgba(45,212,191,.20)]">

                    <div class="overflow-hidden">

                        <img
                            src="'.base_url('assets/img/berita/'.$row->foto_berita).'"
                            alt="'.htmlspecialchars($row->meta_foto).'"
                            class="w-full h-64 object-cover
                            group-hover:scale-110
                            transition duration-700">

                    </div>

                    <div class="p-6">

                        <div class="flex justify-between text-sm text-slate-400 mb-3">

                            <span>

                                <i class="fa-solid fa-calendar-days text-teal-400"></i>

                                '.$tanggal.'

                            </span>

                            <span>

                                <i class="fa-solid fa-eye text-orange-400"></i>

                                '.number_format($row->view_berita).'

                            </span>

                        </div>

                        <h3 class="text-xl font-bold text-white mb-4 line-clamp-2">

                            '.htmlspecialchars($row->judul_berita).'

                        </h3>

                        <p class="text-slate-400 leading-7 line-clamp-3">

                            '.htmlspecialchars($row->meta_desk).'

                        </p>

                        <div class="mt-5">

                            '.$tag_html.'

                        </div>

                        <a href="'.base_url('Artikel/'.url_title($row->judul_berita,'-',TRUE)).'"

                            class="inline-flex items-center gap-2
                            mt-6
                            text-teal-400
                            font-bold
                            hover:gap-3
                            transition-all">

                            Baca Selengkapnya

                            <i class="fa-solid fa-arrow-right"></i>

                        </a>

                    </div>

                </article>

                ';
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

}