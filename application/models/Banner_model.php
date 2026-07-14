<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banner_model extends CI_Model
{

    public function get_unit()
    {

        return $this->db
                    ->select('id_unit,nama_unit')
                    ->order_by('nama_unit','ASC')
                    ->get('unit_mobil')
                    ->result();
    }

    function get_filter_type()
    {
        $this->db->select('*');
        $this->db->from('banner');
        $this->db->order_by('type_banner', 'ASC');
        $this->db->group_by('banner.type_banner');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_banner($data) {
        $this->db->insert('banner', $data);
    }

    public function get_banner($limit, $start, $search = '', $filter_type) {
        if ($start < 0) $start = 0;

        $this->db->select('*');
        $this->db->from('banner');

        if (!empty($search)) {
            $this->db->like('banner.judul_promo', $search);
            $this->db->group_by('id_banner');
        }

        if (!empty($filter_type)) {
            $this->db->where('banner.type_banner', $filter_type);
        }

        $this->db->order_by("banner.id_banner", "ASC");
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        return $query;
    }

    public function count_banner($search = '', $filter_type)
    {
        $this->db->select('*');
        $this->db->from('banner');

        if (!empty($search)) {
            $this->db->like('judul_promo', $search);
        }

        if ($filter_type !== '') {
            $this->db->where('banner.type_banner', $filter_type);
        }
        return $this->db->count_all_results();
    }

    public function get_banner_by_id($id_banner)
    {
        return $this->db
                    ->where('id_banner', $id_banner)
                    ->get('banner')
                    ->row();
    }

    public function delete_banner($id_banner)
    {
        return $this->db
                    ->where('id_banner', $id_banner)
                    ->delete('banner');
    }

    public function update_banner($id_banner, $data) {
        $this->db->where('id_banner', $id_banner);
        $this->db->update('banner', $data);
    }
}