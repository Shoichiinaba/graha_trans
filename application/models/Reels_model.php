<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reels_model extends CI_Model
{

    public function get_properti_select()
    {
        $this->db->select('*');
        $this->db->from('properti');
        $this->db->group_by('properti.id_properti');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_reels($data)
    {
        return $this->db->insert('reels', $data);
    }

    public function get_reel_by_id($id_reel) {
        $this->db->where('id_reel', $id_reel);
        $query = $this->db->get('reels');
        return $query->row();
    }

    public function update_reel($id_reel, $data)
    {
        $this->db->where('id_reel', $id_reel);
        $this->db->update('reels', $data);
    }

    public function delete_reel($id_reel)
    {
        $this->db->where('id_reel', $id_reel);
        return $this->db->delete('reels');
    }

    public function get_reels($limit, $start, $search = '')
    {
        if ($start < 0) $start = 0;

        $this->db->select('*');
        $this->db->from('reels');
        $this->db->join('properti', 'properti.id_properti = reels.id_properti', 'left');

            if (!empty($search)) {
                $this->db->like('reels.judul_reels', $search);
            }

        $this->db->order_by("reels.id_reel", "DESC");
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        return $query;
    }

    public function count_reels($search = '')
    {
        $this->db->select('*');
        $this->db->from('reels');
        if (!empty($search)) {
            $this->db->like('judul_reels', $search);
        }
        return $this->db->count_all_results();
    }

}