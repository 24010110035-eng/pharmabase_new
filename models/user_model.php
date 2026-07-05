<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'users';

    public function get_by_username($username)
    {
        return $this->db->get_where($this->table, array('username' => $username))->row();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function create($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['status']   = 'aktif';
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function verify_password($password_input, $hashed_password)
    {
        return password_verify($password_input, $hashed_password);
    }
}