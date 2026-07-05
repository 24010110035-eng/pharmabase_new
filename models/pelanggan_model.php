<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends CI_Model
{
    protected $table = 'pelanggan';

    public function get_by_user_id($user_id)
    {
        return $this->db->get_where($this->table, array('user_id' => $user_id))->row();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function get_all()
    {
        return $this->db->select('pelanggan.*, users.username, users.nama_lengkap, users.status')
                          ->from($this->table)
                          ->join('users', 'users.id = pelanggan.user_id')
                          ->get()->result();
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, array('id' => $id));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array('id' => $id));
    }
}