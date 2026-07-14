<?php

class GenerateKey_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function save_key($key_name, $api_key)
    {
        $data = array(
            'user_id'    => 1,
            'key_name'   => $key_name,
            'api_key'    => $api_key,
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('api_keys', $data);
    }

    public function is_valid_key($api_key)
    {
        $this->db->select('id, status');
        $this->db->from('api_keys');
        $this->db->where('api_key', $api_key);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            if ($result->status === 'active') {
                return 'active';
            } else {
                return 'inactive';
            }
        } else {
            return FALSE;
        }
    }

    public function get_key($limit, $start, $search = '') {
        if ($start < 0) $start = 0;

        $this->db->select('*');
        $this->db->from('api_keys');

        if (!empty($search)) {
            $this->db->like('api_keys.api_key', $search);
        }

        $this->db->order_by("api_keys.id", "ASC");
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        return $query;
    }

    public function count_key($search = '')
    {
        $this->db->select('*');
        $this->db->from('api_keys');
        if (!empty($search)) {
            $this->db->like('api_keys.api_key', $search);
        }
        return $this->db->count_all_results();
    }

    public function delete_key($id_key) {
        $this->db->where('id', $id_key);
        return $this->db->delete('api_keys');
    }
}