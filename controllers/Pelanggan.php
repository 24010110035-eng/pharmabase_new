<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pelanggan_model');
		$this->load->model('User_model');
	}

	public function index()
	{
		$this->require_role(array('admin', 'apoteker'));
		$data['pelanggan'] = $this->Pelanggan_model->get_all();

		$this->load->view('layout/header', array('title' => 'Manajemen Pelanggan'));
		$this->load->view('pelanggan/index', $data);
		$this->load->view('layout/footer');
	}

	public function tambah()
	{
		$this->require_role(array('admin', 'apoteker'));

		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
			$this->form_validation->set_rules('no_telp', 'No. Telepon', 'required|trim');

			if ($this->form_validation->run()) {
				$user_id = $this->User_model->create(array(
					'username'     => $this->input->post('username'),
					'password'     => $this->input->post('password'),
					'nama_lengkap' => $this->input->post('nama_lengkap'),
					'role'         => 'pelanggan',
				));

				$this->Pelanggan_model->create(array(
					'user_id'        => $user_id,
					'alamat'         => $this->input->post('alamat'),
					'no_telp'        => $this->input->post('no_telp'),
					'riwayat_alergi' => $this->input->post('riwayat_alergi'),
				));

				$this->session->set_flashdata('success', 'Pelanggan baru berhasil ditambahkan.');
				redirect('pelanggan');
				return;
			}
		}

		$this->load->view('layout/header', array('title' => 'Tambah Pelanggan'));
		$this->load->view('pelanggan/tambah');
		$this->load->view('layout/footer');
	}

	public function profil()
	{
		$this->require_role(array('pelanggan'));

		$pelanggan = $this->Pelanggan_model->get_by_user_id($this->user['id']);

		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
			$this->form_validation->set_rules('no_telp', 'No. Telepon', 'required|trim');

			if ($this->form_validation->run()) {
				$this->User_model->update($this->user['id'], array(
					'nama_lengkap' => $this->input->post('nama_lengkap'),
				));
				$this->Pelanggan_model->update($pelanggan->id, array(
					'alamat'         => $this->input->post('alamat'),
					'no_telp'        => $this->input->post('no_telp'),
					'riwayat_alergi' => $this->input->post('riwayat_alergi'),
				));
				$this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
				redirect('pelanggan/profil');
				return;
			}
		}

		$this->load->view('layout/header', array('title' => 'Profil Saya'));
		$this->load->view('pelanggan/profil', array('pelanggan' => $pelanggan, 'user' => $this->user));
		$this->load->view('layout/footer');
	}

	public function edit($id)
	{
		$this->require_role(array('admin', 'apoteker'));
		$pelanggan = $this->Pelanggan_model->get_by_id($id);
		if (!$pelanggan) show_404();

		if ($this->input->method() === 'post') {
			$this->User_model->update($pelanggan->user_id, array(
				'nama_lengkap' => $this->input->post('nama_lengkap'),
				'status'       => $this->input->post('status'),
			));
			$this->Pelanggan_model->update($id, array(
				'alamat'         => $this->input->post('alamat'),
				'no_telp'        => $this->input->post('no_telp'),
				'riwayat_alergi' => $this->input->post('riwayat_alergi'),
			));
			$this->session->set_flashdata('success', 'Data pelanggan berhasil diperbarui.');
			redirect('pelanggan');
			return;
		}

		$this->load->view('layout/header', array('title' => 'Edit Data Pelanggan'));
		$this->load->view('pelanggan/edit', array('pelanggan' => $pelanggan));
		$this->load->view('layout/footer');
	}

	public function hapus($id)
	{
		$this->require_role(array('admin', 'apoteker'));
		$pelanggan = $this->Pelanggan_model->get_by_id($id);
		if ($pelanggan) {
			$this->User_model->delete($pelanggan->user_id);
		}
		$this->session->set_flashdata('success', 'Akun pelanggan berhasil dihapus.');
		redirect('pelanggan');
	}
}