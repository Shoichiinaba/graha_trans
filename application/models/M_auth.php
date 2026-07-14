<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {
    public function login($user, $pass) {
        $this->db->select('*');
        $this->db->from('agency');

        $this->db->group_start();
        $this->db->where('username', $user);
        $this->db->or_where('email', $user);
        $this->db->group_end();

        $data = $this->db->get();

        if ($data->num_rows() == 1) {
            $user_data = $data->row();

            if (password_verify($pass, $user_data->password)) {
                return $user_data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}