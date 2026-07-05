<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

    protected $table       = 'transaksi';
    protected $detailTable = 'transaksi_detail';

    public function __construct()
    {
        parent::__construct();
    }

    public function proses_penjualan($kasir_id, $pelanggan_id, $items)
    {
        if (empty($items)) {
            return false;
        }

        $this->db->trans_start();

        $total   = 0;
        $checked = array();

        foreach ($items as $item) {
            $obat_id = (int) $item['obat_id'];
            $qty     = (int) $item['qty'];

            $obat = $this->db->query("SELECT * FROM obat WHERE id = ? FOR UPDATE", array($obat_id))->row();

            if (!$obat || $qty < 1 || $qty > $obat->stok) {
                $this->db->trans_rollback();
                return false;
            }

            $subtotal  = $obat->harga * $qty;
            $total    += $subtotal;
            $checked[] = array(
                'obat'         => $obat,
                'qty'          => $qty,
                'harga_satuan' => $obat->harga,
                'subtotal'     => $subtotal,
            );
        }

        $this->db->insert($this->table, array(
            'no_nota'      => 'TRX-' . date('YmdHis') . '-' . rand(100, 999),
            'kasir_id'     => $kasir_id,
            'pelanggan_id' => $pelanggan_id ?: null,
            'total'        => $total,
            'status'       => 'sukses',
        ));
        $transaksi_id = $this->db->insert_id();

        foreach ($checked as $c) {
            $this->db->insert($this->detailTable, array(
                'transaksi_id' => $transaksi_id,
                'obat_id'      => $c['obat']->id,
                'qty'          => $c['qty'],
                'harga_satuan' => $c['harga_satuan'],
                'subtotal'     => $c['subtotal'],
            ));

            $this->db->set('stok', 'stok - ' . (int) $c['qty'], false)
                      ->where('id', $c['obat']->id)
                      ->update('obat');
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $transaksi_id : false;
    }

    public function get_history($pelanggan_id = null, $dari = null, $sampai = null, $limit = 200)
    {
        $this->db->select('t.*, u.nama_lengkap AS nama_kasir, pu.nama_lengkap AS nama_pelanggan')
                  ->from($this->table . ' t')
                  ->join('users u', 'u.id = t.kasir_id')
                  ->join('pelanggan p', 'p.id = t.pelanggan_id', 'left')
                  ->join('users pu', 'pu.id = p.user_id', 'left');

        if ($pelanggan_id !== null) {
            $this->db->where('t.pelanggan_id', $pelanggan_id);
        }
        if (!empty($dari)) {
            $this->db->where('DATE(t.created_at) >=', $dari);
        }
        if (!empty($sampai)) {
            $this->db->where('DATE(t.created_at) <=', $sampai);
        }

        return $this->db->order_by('t.created_at', 'DESC')->limit($limit)->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function get_items($transaksi_id)
    {
        return $this->db->select('td.*, o.nama_obat')
                          ->from($this->detailTable . ' td')
                          ->join('obat o', 'o.id = td.obat_id', 'left')
                          ->where('td.transaksi_id', $transaksi_id)
                          ->get()
                          ->result();
    }

    public function retur($id)
    {
        $this->db->trans_start();

        $items = $this->get_items($id);
        foreach ($items as $it) {
            $this->db->set('stok', 'stok + ' . (int) $it->qty, false)
                      ->where('id', $it->obat_id)
                      ->update('obat');
        }

        $this->db->where('id', $id)->update($this->table, array('status' => 'returned'));

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}