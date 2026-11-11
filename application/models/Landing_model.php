<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing_model extends CI_Model
{

    public function get_unit($limit, $start, $kategori = '')
    {
        if ($start < 0) {
            $start = 0;
        }

        $this->db->select('*');
        $this->db->from('unit_mobil');

        // Filter berdasarkan tata letak web
        if (!empty($kategori)) {
            $this->db->where('tataletak_web', $kategori);
        }

        $this->db->order_by('id_unit', 'DESC');
        $this->db->limit($limit, $start);

        return $this->db->get();
    }

    public function count_unit($kategori = '')
    {
        $this->db->from('unit_mobil');

        // Filter berdasarkan tata letak web
        if (!empty($kategori)) {
            $this->db->where('tataletak_web', $kategori);
        }

        return $this->db->count_all_results();
    }

    public function get_berita($limit, $start)
    {
        if ($start < 0) {
            $start = 0;
        }

        $this->db->select('*');
        $this->db->from('berita');

        // Hanya tampilkan berita yang Publish
        $this->db->where('status_berita', 'Terindex');

        // Berita terbaru
        $this->db->order_by("STR_TO_DATE(tgl_berita,'%d %M %Y')", "DESC", false);


        $this->db->limit($limit, $start);

        return $this->db->get();
    }

    public function count_berita()
    {
        $this->db->from('berita');

        $this->db->where('status_berita', 'Terindex');

        return $this->db->count_all_results();
    }

    public function detail_berita($slug)
    {
        // Ambil semua berita yang sudah terindex
        $this->db->where('status_berita', 'Terindex');
        $query = $this->db->get('berita');

        if ($query->num_rows() == 0) {
            return false;
        }

        foreach ($query->result() as $row) {

            // Bandingkan slug yang dihasilkan dari judul dengan slug URL
            if (url_title($row->judul_berita, '-', TRUE) === $slug) {
                return $row;
            }

        }

        return false;
    }

    public function update_view($id_berita)
    {
        $this->db->set('view_berita', 'view_berita+1', FALSE);
        $this->db->where('id_berita', $id_berita);
        $this->db->update('berita');
    }

    public function isi_berita($id_berita)
    {
        return $this->db
            ->where('berita_id', $id_berita)
            ->order_by('id_data_berita', 'ASC')
            ->get('data_berita');
    }

    public function foto_berita($id_data_berita)
    {
        return $this->db
            ->where('data_berita_id', $id_data_berita)
            ->order_by('id_foto_berita', 'ASC')
            ->get('foto_berita');
    }

    public function berita_populer($id_berita, $limit = 3)
    {
        return $this->db
            ->where('status_berita', 'Terindex')
            ->where('id_berita !=', $id_berita)
            ->order_by('view_berita', 'DESC')
            ->order_by('tgl_berita', 'DESC')
            ->limit($limit)
            ->get('berita')
            ->result();
    }

    public function berita_terbaru($id_berita, $limit = 3)
    {
        $query = $this->db
            ->where('status_berita', 'Terindex')
            ->where('id_berita !=', $id_berita)
            ->order_by("STR_TO_DATE(tgl_berita,'%d %M %Y')", "DESC", false)
            ->limit($limit)
            ->get('berita');

        if ($query->num_rows() == 0) {

            $query = $this->db
                ->where('status_berita', 'Terindex')
                ->order_by("STR_TO_DATE(tgl_berita,'%d %M %Y')", "DESC", false)
                ->limit($limit)
                ->get('berita');
        }

        return $query->result();
    }

    // code tag berita
    public function berita_by_tag($tag)
    {
        $this->db->select('*');
        $this->db->from('berita');

        // Hanya artikel yang sudah terindex
        $this->db->where('status_berita', 'Terindex');

        // Cari berdasarkan tag
        $this->db->where("FIND_IN_SET(".$this->db->escape($tag).", REPLACE(tag_berita, ', ', ',')) !=", 0, false);

        // Urutkan artikel terbaru
        $this->db->order_by("STR_TO_DATE(tgl_berita,'%d %M %Y')", "DESC", false);

        return $this->db->get()->result();
    }

    public function get_tag($tag, $limit, $start)
    {
        $this->db
            ->select("*, STR_TO_DATE(tgl_berita,'%Y-%m-%d') as tanggal", false)
            ->from('berita')
            ->where('status_berita', 'Terindex')
            ->where("FIND_IN_SET(".$this->db->escape($tag).", REPLACE(tag_berita, ', ', ',')) !=",0,false)
            ->order_by('tanggal','DESC')
            ->limit($limit,$start);

        return $this->db->get();
    }

    public function count_tag($tag)
    {
        $this->db
            ->from('berita')
            ->where('status_berita','Terindex')
            ->where("FIND_IN_SET(".$this->db->escape($tag).", REPLACE(tag_berita, ', ', ',')) !=",0,false);

        return $this->db->count_all_results();
    }

    public function get_banner_biasa()
    {
        return $this->db
            ->where('type_banner', 'biasa')
            ->order_by('created', 'DESC')
            ->get('banner');
    }

    public function get_banner_promo()
    {
        return $this->db
            ->where('type_banner', 'promo')
            ->order_by('created', 'DESC')
            ->get('banner');
    }

    public function get_banner_client()
    {
        return $this->db
            ->where('type_banner', 'client')
            ->order_by('id_banner', 'ASC')
            ->get('banner');
    }

    // kode untuk sitemap
    public function get_all_sitemap()
    {
        return $this->db
            ->where('status_berita','Terindex')
            ->order_by('tgl_berita','DESC')
            ->get('berita')
            ->result();
    }

    public function semua_tag()
    {
        $this->db->select('tag_berita');
        $query = $this->db->get('berita');

        $tags = [];

        foreach ($query->result() as $row) {

            $arr = explode(',', $row->tag_berita);

            foreach ($arr as $tag) {

                $tag = trim($tag);

                if ($tag != '') {
                    $tags[$tag] = $tag;
                }
            }
        }

        natcasesort($tags);

        return array_values($tags);
    }
}