<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Pelanggan_model');   // <-- ditambahkan
	}

	public function index()
	{
		redirect('login');
	}

	public function login()
	{
		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('username', 'Username', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run()) {
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$user = $this->User_model->get_by_username($username);

				if ($user && $user->status === 'aktif' && $this->User_model->verify_password($password, $user->password)) {

					$this->session->set_userdata(array(
						'logged_in' => TRUE,
						'user_id'   => $user->id,
						'nama'      => $user->nama_lengkap,
						'username'  => $user->username,
						'role'      => $user->role,
					));

					$this->session->set_flashdata('success', 'Login berhasil. Selamat datang, ' . $user->nama_lengkap . '!');
					redirect('dashboard');
					return;
				}

				$this->session->set_flashdata('error', 'Username atau kata sandi salah, atau akun nonaktif.');
			}
		}

		// Diubah: hapus load layout/header & layout/footer,
		// karena halaman login tidak pakai sidebar/navbar.
		$this->load->view('auth/login');
	}

	public function register()
	{
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

				$this->session->set_flashdata('success', 'Registrasi berhasil. Silakan login.');
				redirect('login');
				return;
			}
		}

		// Diubah: hapus load layout/header & layout/footer
		$this->load->view('auth/register');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}