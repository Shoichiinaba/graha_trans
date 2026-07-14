<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent_model extends CI_Model
{
    public function get_agent($limit = 6, $start = 0, $search = '')
    {
        if ($start < 0) $start = 0;

        $this->db->select('*');
        $this->db->from('agency');

        if (!empty($search)) {
            $this->db->like('agency.nama_agent', $search);
        }

        $this->db->order_by("agency.id_agency", "ASC");
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        return $query->result();
    }

    public function count_agent($search = '')
    {
        $this->db->select('*');
        $this->db->from('agency');
        if (!empty($search)) {
            $this->db->like('nama_agent', $search);
        }
        return $this->db->count_all_results();
    }

    public function insert_agent($data)
    {
        $this->db->insert('agency',$data);

        return $this->db->insert_id();
    }

    public function get_agent_by_id($id_agent) {
        $this->db->where('id_agency', $id_agent);
        $query = $this->db->get('agency');
        return $query->row();
    }

    public function delete_agent($id_agent)
    {
        $this->db->where('id_agency', $id_agent);
        return $this->db->delete('agency');
    }

    // code edit agent

    public function update_agent($id_agent, $data) {
        $this->db->where('id_agency', $id_agent);
        $this->db->update('agency', $data);
    }

}