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

    public function fetch()
    {
        $output = '';

        $kategori = trim((string)$this->input->post('kategori', true));
        $limit    = (int)$this->input->post('limit');
        $start    = (int)$this->input->post('start');

        if ($limit <= 0) {
            $limit = 3;
        }

        if ($start < 0) {
            $start = 0;
        }

        $data       = $this->Landing_model->get_unit($limit, $start, $kategori);
        $total_data = $this->Landing_model->count_unit($kategori);

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $harga = floor($row->price) == $row->price
                    ? number_format($row->price, 0, ',', '.')
                    : number_format($row->price, 1, ',', '.');

                $namaUnit   = htmlspecialchars($row->nama_unit, ENT_QUOTES, 'UTF-8');
                $kategoriEl = htmlspecialchars(strtoupper($row->kategori), ENT_QUOTES, 'UTF-8');
                $seat       = htmlspecialchars($row->seat, ENT_QUOTES, 'UTF-8');
                $fuel       = htmlspecialchars($row->fuel, ENT_QUOTES, 'UTF-8');
                $transmisi  = htmlspecialchars($row->transmition, ENT_QUOTES, 'UTF-8');
                $tahun      = htmlspecialchars((string)$row->tahun, ENT_QUOTES, 'UTF-8');
                $gambarUrl  = base_url('assets/img/car/' . $row->gambar);

                $statusRaw  = strtolower(trim((string)$row->status));
                $isReady    = ($statusRaw === 'ready' || $statusRaw === '');
                $statusBadge = $isReady
                    ? '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-teal-400/15 text-teal-300 border border-teal-400/30">Ready</span>'
                    : '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-400/15 text-amber-300 border border-amber-400/30">' . htmlspecialchars(ucfirst($statusRaw), ENT_QUOTES, 'UTF-8') . '</span>';

                $waText = rawurlencode('Halo Graha Transport, saya ingin booking unit ' . $row->nama_unit . ' (' . $row->tahun . '). Apakah tersedia?');
                $waUrl  = 'https://wa.me/6281327160516?text=' . $waText;

                $output .= '
                <div class="group rounded-[28px] overflow-hidden bg-[#1b2740] border border-white/10 hover:border-teal-400/70 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_0_35px_rgba(45,212,191,.18)] flex flex-col">
                    <div class="relative overflow-hidden bg-[#152036] h-56">
                        <div class="absolute inset-x-0 top-0 h-20 bg-gradient-to-b from-slate-950/65 to-transparent z-[5] pointer-events-none"></div>
                        <div class="absolute top-4 left-4 z-10">
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase bg-slate-900/80 text-white backdrop-blur-md border border-white/20 shadow">
                                ' . $kategoriEl . '
                            </span>
                        </div>
                        <div class="absolute top-4 right-4 z-10">
                            ' . $statusBadge . '
                        </div>
                        <img src="' . $gambarUrl . '"
                            alt="' . $namaUnit . '"
                            loading="lazy"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <h3 class="text-xl font-bold text-white leading-snug">' . $namaUnit . '</h3>
                                <span class="text-xs text-slate-400 font-medium shrink-0 mt-1">' . $tahun . '</span>
                            </div>

                            <div class="flex items-baseline gap-1.5 mb-5">
                                <span class="text-2xl font-extrabold text-teal-400">Rp ' . $harga . 'K</span>
                                <span class="text-xs text-slate-400">/ hari</span>
                            </div>

                            <div class="border-t border-white/10 pt-4 mb-5 grid grid-cols-3 gap-2 text-center">
                                <div class="bg-white/5 rounded-xl py-2.5 px-2">
                                    <i class="fa-solid fa-users text-teal-400 text-sm mb-1 block" aria-hidden="true"></i>
                                    <span class="text-xs text-slate-200 font-medium block truncate">' . $seat . ' Seat</span>
                                </div>
                                <div class="bg-white/5 rounded-xl py-2.5 px-2">
                                    <i class="fa-solid fa-gas-pump text-teal-400 text-sm mb-1 block" aria-hidden="true"></i>
                                    <span class="text-xs text-slate-200 font-medium block truncate">' . $fuel . '</span>
                                </div>
                                <div class="bg-white/5 rounded-xl py-2.5 px-2">
                                    <i class="fa-solid fa-gears text-teal-400 text-sm mb-1 block" aria-hidden="true"></i>
                                    <span class="text-xs text-slate-200 font-medium block truncate">' . $transmisi . '</span>
                                </div>
                            </div>
                        </div>

                        <a href="' . $waUrl . '" target="_blank" rel="noopener noreferrer"
                           class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-teal-400 hover:bg-teal-300 text-slate-900 font-bold text-sm transition shadow-lg shadow-teal-500/20">
                            <i class="fa-brands fa-whatsapp text-base" aria-hidden="true"></i>
                            Booking Sekarang
                        </a>
                    </div>
                </div>';
            }
        }

        echo json_encode([
            'status'     => true,
            'data'       => $output,
            'total_data' => (int)$total_data
        ]);
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
