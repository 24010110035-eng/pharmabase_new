<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Obat_model');
		$this->load->model('Transaksi_model');
	}

	public function index()
	{
		// require_login() dihapus - sudah otomatis ditangani MY_Controller

		if (in_array($this->user['role'], array('admin', 'apoteker'), true)) {
			$data['stok_kritis'] = $this->Obat_model->get_stok_kritis();
			$data['total_obat']  = count($this->Obat_model->get_all());
			$data['history'] = array_slice($this->Transaksi_model->get_history(), 0, 5);

			$this->load->view('layout/header', array('title' => 'Dashboard Admin'));
			$this->load->view('dashboard/admin', $data);
			$this->load->view('layout/footer');
		} else {
			$this->load->model('Pelanggan_model');
			$pelanggan = $this->Pelanggan_model->get_by_user_id($this->user['id']);
			$data['history'] = $pelanggan ? $this->Transaksi_model->get_history($pelanggan->id) : array();

			$this->load->view('layout/header', array('title' => 'Dashboard Saya'));
			$this->load->view('dashboard/pelanggan', $data);
			$this->load->view('layout/footer');
		}
	}
}