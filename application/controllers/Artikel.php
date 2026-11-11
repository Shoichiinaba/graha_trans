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
        $first_text = ''; // Digunakan untuk backup meta deskripsi jika field khusus tidak ada

        foreach ($isi->result() as $row) {
            $gallery = $this->Landing_model->foto_berita($row->id_data_berita);
            $foto = [];

            foreach ($gallery->result() as $img) {
                $foto[] = $img->file_foto_berita;
            }

            if(empty($first_text)) {
                $first_text = strip_tags($row->text_berita); // Ambil teks paragraf pertama bersih dari HTML
            }

            $listIsi[] = [
                'id_data_berita' => $row->id_data_berita,
                'text_berita'    => $row->text_berita,
                'file_foto_btn'  => $row->file_foto_btn,
                'link_btn'       => $row->link_btn,
                'foto'           => $foto
            ];
        }

        $data['semua_tag'] = $this->Landing_model->semua_tag();
        $data['title']    = $berita->judul_berita;
        $data['berita']   = $berita;
        $data['isi']      = $listIsi;

        // --- PENGATURAN SEO DINAMIS ---
        // Gunakan field meta dari database jika ada, jika tidak, potong teks artikel (150 karakter)
        $data['meta_desc'] = (isset($berita->meta_desk) && !empty($berita->meta_desk))
                            ? $berita->meta_desk
                            : substr($first_text, 0, 150) . '...';

        // Gunakan keywords dari database jika ada, jika tidak, pakai default keywords
        $data['meta_keywords'] = (isset($berita->keyword) && !empty($berita->keywords))
                        ? $berita->keyword
                        : 'rental mobil ungaran, sewa mobil ungaran, rental mobil semarang, sewa mobil semarang, rental mobil ungaran, sewa mobil ungaran, rental mobil semarang, rental mobil semarang murah, rental mobil dekat saya, rental mobil lepas kunci ungaran, rental mobil bandara ahmad yani, sewa mobil semarang, travel ungaran semarang, car rental semarang';

        // URL dinamis untuk Canonical & Open Graph
        $data['canonical_url'] = current_url();

        // Gambar dinamis untuk Open Graph (Jika berita punya cover/foto utama)
        if (!empty($berita->meta_foto)) {
            $data['meta_image'] = base_url('assets/img/berita/meta_berita/' . $berita->meta_foto);
        } else {
            $data['meta_image'] = base_url('assets/img/logo.png'); // sesuaikan lokasi logo
        }
        // ------------------------------

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

        $data['semua_tag'] = $this->Landing_model->semua_tag();
        $data['title'] = 'Artikel Tag : '.$tag;
        $data['tag']   = $tag;
        $data['canonical_url'] = base_url();

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