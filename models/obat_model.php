<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat_model extends CI_Model
{
    protected $table = 'obat';

    public function get_all($keyword = null)
    {
        if (!empty($keyword)) {
            $this->db->group_start()
                      ->like('nama_obat', $keyword)
                      ->or_like('kode_obat', $keyword)
                      ->group_end();
        }
        return $this->db->order_by('nama_obat', 'ASC')->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function get_stok_kritis()
    {
        return $this->db->where('stok <=', 'stok_minimum', FALSE)
                          ->order_by('stok', 'ASC')
                          ->get($this->table)
                          ->result();
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