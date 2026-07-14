<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unit_model extends CI_Model
{

    function get_filter_kategori()
    {
        $this->db->select('*');
        $this->db->from('Unit_mobil');
        $this->db->order_by('kategori', 'ASC');
        $this->db->group_by('unit_mobil.kategori');
        $query = $this->db->get();
        return $query->result();
    }

    function get_filter_tahun()
    {
        $this->db->select('*');
        $this->db->from('unit_mobil');
        $this->db->order_by('tahun', 'ASC');
        $this->db->group_by('unit_mobil.tahun');
        $query = $this->db->get();
        return $query->result();
    }

    function get_filter_transmisi()
    {
        $this->db->select('*');
        $this->db->from('unit_mobil');
        $this->db->order_by('transmition', 'ASC');
        $this->db->group_by('unit_mobil.transmition');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_unit($limit, $start, $search = '', $filter_kategori = '', $filter_tahun = '', $filter_transmisi = '')
    {
        if ($start < 0) {
            $start = 0;
        }

        $this->db->select('*');
        $this->db->from('unit_mobil');

        // Pencarian nama unit
        if (!empty($search)) {
            $this->db->like('unit_mobil.nama_unit', $search);
        }

        // Filter kategori
        if (!empty($filter_kategori)) {
            $this->db->where('unit_mobil.kategori', $filter_kategori);
        }

        // Filter tahun
        if (!empty($filter_tahun)) {
            $this->db->where('unit_mobil.tahun', $filter_tahun);
        }

        // Filter transmisi
        if (!empty($filter_transmisi)) {
            $this->db->where('unit_mobil.transmition', $filter_transmisi);
        }

        $this->db->order_by('unit_mobil.id_unit', 'DESC');
        $this->db->limit($limit, $start);

        return $this->db->get();
        return $query;
    }

    public function count_unit($search = '', $filter_kategori, $filter_tahun, $filter_transmisi)
    {
        $this->db->select('*');
        $this->db->from('unit_mobil');

        if (!empty($search)) {
            $this->db->like('nama_unit', $search);
        }

        if (!empty($filter_kategori)) {
            $this->db->where('kategori', $filter_kategori);
        }

        if (!empty($filter_tahun)) {
            $this->db->where('tahun', $filter_tahun);
        }

        if (!empty($filter_transmisi)) {
            $this->db->where('transmition', $filter_transmisi);
        }

        return $this->db->count_all_results();
    }


    public function get_unit_by_id($id_unit) {
        $this->db->where('id_unit', $id_unit);
        $query = $this->db->get('unit_mobil');
        return $query->row();
    }

    public function delete_unit($id_unit)
    {
        $this->db->where('id_unit', $id_unit);
        return $this->db->delete('unit_mobil');
    }

    public function update_unit($id,$data)
    {
        return $this->db
                ->where('id_unit',$id)
                ->update('unit_mobil',$data);
    }

    public function insert_promo($data) {
        return $this->db->insert('promo', $data);
    }

    function get_promo($id_properti)
    {
        $this->db->select('*');
        $this->db->from('promo');
        $this->db->where('id_properti', $id_properti);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_promo_by_id($id_promo)
    {
        return $this->db->get_where('promo', ['id_promo' => $id_promo])->row();
    }

    public function update_promo($id_promo, $data)
    {
        $this->db->where('id_promo', $id_promo);
        $this->db->update('promo', $data);
    }

}