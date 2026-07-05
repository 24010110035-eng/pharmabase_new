<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Obat_model');
	}

	public function index()
	{
		$data['obat'] = $this->Obat_model->get_all();
		$data['keyword'] = '';

		$this->load->view('layout/header', array('title' => 'Katalog Obat'));
		$this->load->view('obat/index', $data);
		$this->load->view('layout/footer');
	}

	public function cari()
	{
		$keyword = $this->input->get('keyword', TRUE);
		$data['obat'] = $keyword ? $this->Obat_model->cari($keyword) : $this->Obat_model->get_all();
		$data['keyword'] = $keyword;

		$this->load->view('layout/header', array('title' => 'Hasil Pencarian Obat'));
		$this->load->view('obat/index', $data);
		$this->load->view('layout/footer');
	}

	public function tambah()
	{
		$this->require_role(array('admin', 'apoteker'));

		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('kode_obat', 'Kode Obat', 'required|trim|is_unique[obat.kode_obat]');
			$this->form_validation->set_rules('nama_obat', 'Nama Obat', 'required|trim');
			$this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
			$this->form_validation->set_rules('stok', 'Stok', 'required|integer');

			if ($this->form_validation->run()) {
				$this->Obat_model->create(array(
					'kode_obat'           => $this->input->post('kode_obat'),
					'nama_obat'           => $this->input->post('nama_obat'),
					'zat_aktif'           => $this->input->post('zat_aktif'),
					'kategori'            => $this->input->post('kategori'),
					'harga'               => $this->input->post('harga'),
					'stok'                => $this->input->post('stok'),
					'stok_minimum'        => $this->input->post('stok_minimum') ?: 10,
					'tanggal_kedaluwarsa' => $this->input->post('tanggal_kedaluwarsa'),
					'no_registrasi_bpom'  => $this->input->post('no_registrasi_bpom'),
					'deskripsi'           => $this->input->post('deskripsi'),
				));
				$this->session->set_flashdata('success', 'Data obat berhasil ditambahkan.');
				redirect('obat');
				return;
			}
		}

		$this->load->view('layout/header', array('title' => 'Tambah Obat'));
		$this->load->view('obat/form', array('obat' => null));
		$this->load->view('layout/footer');
	}

	public function edit($id)
	{
		$this->require_role(array('admin', 'apoteker'));
		$obat = $this->Obat_model->get_by_id($id);
		if (!$obat) show_404();

		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('nama_obat', 'Nama Obat', 'required|trim');
			$this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
			$this->form_validation->set_rules('stok', 'Stok', 'required|integer');

			if ($this->form_validation->run()) {
				$this->Obat_model->update($id, array(
					'nama_obat'           => $this->input->post('nama_obat'),
					'zat_aktif'           => $this->input->post('zat_aktif'),
					'kategori'            => $this->input->post('kategori'),
					'harga'               => $this->input->post('harga'),
					'stok'                => $this->input->post('stok'),
					'stok_minimum'        => $this->input->post('stok_minimum') ?: 10,
					'tanggal_kedaluwarsa' => $this->input->post('tanggal_kedaluwarsa'),
					'no_registrasi_bpom'  => $this->input->post('no_registrasi_bpom'),
					'deskripsi'           => $this->input->post('deskripsi'),
				));
				$this->session->set_flashdata('success', 'Data obat berhasil diperbarui.');
				redirect('obat');
				return;
			}
		}

		$this->load->view('layout/header', array('title' => 'Edit Obat'));
		$this->load->view('obat/form', array('obat' => $obat));
		$this->load->view('layout/footer');
	}

	public function hapus($id)
	{
		$this->require_role(array('admin', 'apoteker'));
		$this->Obat_model->delete($id);
		$this->session->set_flashdata('success', 'Data obat berhasil dihapus.');
		redirect('obat');
	}
}