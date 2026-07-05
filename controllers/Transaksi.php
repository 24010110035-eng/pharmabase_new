<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Transaksi_model');
		$this->load->model('Obat_model');
		$this->load->model('Pelanggan_model');
	}

	// ============================================================
	// KASIR (admin/apoteker) — tidak berubah
	// ============================================================

	public function kasir()
	{
		$this->require_role(array('admin', 'apoteker'));

		$data['obat'] = $this->Obat_model->get_all();
		$data['pelanggan'] = $this->Pelanggan_model->get_all();
		$data['cart'] = $this->session->userdata('cart') ?: array();

		$this->load->view('layout/header', array('title' => 'Kasir Penjualan'));
		$this->load->view('transaksi/kasir', $data);
		$this->load->view('layout/footer');
	}

	public function tambah_item()
	{
		$this->require_role(array('admin', 'apoteker'));

		$obat_id = (int) $this->input->post('obat_id');
		$qty = (int) $this->input->post('qty');
		$obat = $this->Obat_model->get_by_id($obat_id);

		if (!$obat) {
			$this->session->set_flashdata('error', 'Obat tidak ditemukan.');
			redirect('kasir');
			return;
		}
		if ($qty < 1 || $qty > $obat->stok) {
			$this->session->set_flashdata('error', 'Jumlah tidak valid atau melebihi stok tersedia (' . $obat->stok . ').');
			redirect('kasir');
			return;
		}

		$cart = $this->session->userdata('cart') ?: array();
		$cart[$obat_id] = array(
			'obat_id'      => $obat->id,
			'nama_obat'    => $obat->nama_obat,
			'harga_satuan' => $obat->harga,
			'qty'          => ($cart[$obat_id]['qty'] ?? 0) + $qty,
		);
		$this->session->set_userdata('cart', $cart);
		redirect('kasir');
	}

	public function proses()
	{
		$this->require_role(array('admin', 'apoteker'));

		$cart = $this->session->userdata('cart') ?: array();
		if (empty($cart)) {
			$this->session->set_flashdata('error', 'Keranjang transaksi masih kosong.');
			redirect('kasir');
			return;
		}

		$pelanggan_id = $this->input->post('pelanggan_id') ?: null;
		$transaksi_id = $this->Transaksi_model->proses_penjualan($this->user['id'], $pelanggan_id, array_values($cart));

		if ($transaksi_id) {
			$this->session->unset_userdata('cart');
			$this->session->set_flashdata('success', 'Transaksi berhasil diproses. Struk telah dicatat.');
			redirect('transaksi/history');
			return;
		}

		$this->session->set_flashdata('error', 'Transaksi gagal diproses. Silakan cek kembali stok obat.');
		redirect('kasir');
	}

	// ============================================================
	// BELI MANDIRI (pelanggan) — BARU
	// ============================================================

	public function beli()
	{
		$this->require_role(array('pelanggan'));

		$data['obat'] = $this->Obat_model->get_all();
		$data['cart'] = $this->session->userdata('keranjang_pelanggan') ?: array();

		$this->load->view('layout/header', array('title' => 'Beli Obat'));
		$this->load->view('transaksi/beli', $data);
		$this->load->view('layout/footer');
	}

	public function tambah_item_pelanggan()
	{
		$this->require_role(array('pelanggan'));

		$obat_id = (int) $this->input->post('obat_id');
		$qty = (int) $this->input->post('qty');
		$obat = $this->Obat_model->get_by_id($obat_id);

		if (!$obat) {
			$this->session->set_flashdata('error', 'Obat tidak ditemukan.');
			redirect('beli');
			return;
		}
		if ($qty < 1 || $qty > $obat->stok) {
			$this->session->set_flashdata('error', 'Jumlah tidak valid atau melebihi stok tersedia (' . $obat->stok . ').');
			redirect('beli');
			return;
		}

		$cart = $this->session->userdata('keranjang_pelanggan') ?: array();
		$cart[$obat_id] = array(
			'obat_id'      => $obat->id,
			'nama_obat'    => $obat->nama_obat,
			'harga_satuan' => $obat->harga,
			'qty'          => ($cart[$obat_id]['qty'] ?? 0) + $qty,
		);
		$this->session->set_userdata('keranjang_pelanggan', $cart);
		redirect('beli');
	}

	public function hapus_item_pelanggan($obat_id)
	{
		$this->require_role(array('pelanggan'));

		$cart = $this->session->userdata('keranjang_pelanggan') ?: array();
		unset($cart[(int) $obat_id]);
		$this->session->set_userdata('keranjang_pelanggan', $cart);
		redirect('beli');
	}

	public function checkout_pelanggan()
	{
		$this->require_role(array('pelanggan'));

		$cart = $this->session->userdata('keranjang_pelanggan') ?: array();
		if (empty($cart)) {
			$this->session->set_flashdata('error', 'Keranjang belanja masih kosong.');
			redirect('beli');
			return;
		}

		$pelanggan = $this->Pelanggan_model->get_by_user_id($this->user['id']);
		if (!$pelanggan) {
			$this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan. Lengkapi profil Anda terlebih dahulu.');
			redirect('pelanggan/profil');
			return;
		}

		// kasir_id diisi dengan id akun pelanggan sendiri (self-checkout, bukan dilayani kasir).
		$transaksi_id = $this->Transaksi_model->proses_penjualan($this->user['id'], $pelanggan->id, array_values($cart));

		if ($transaksi_id) {
			$this->session->unset_userdata('keranjang_pelanggan');
			$this->session->set_flashdata('success', 'Pembelian berhasil diproses. Terima kasih!');
			redirect('transaksi/history');
			return;
		}

		$this->session->set_flashdata('error', 'Pembelian gagal diproses. Silakan cek kembali stok obat.');
		redirect('beli');
	}

	// ============================================================
	// HISTORY & RETUR — tidak berubah
	// ============================================================

	public function history()
	{
		$data['role']   = $this->user['role'];
		$data['dari']   = $this->input->get('dari', TRUE);
		$data['sampai'] = $this->input->get('sampai', TRUE);

		if (in_array($this->user['role'], array('admin', 'apoteker'), true)) {
			$data['history'] = $this->Transaksi_model->get_history(null, $data['dari'], $data['sampai']);
		} else {
			$pelanggan = $this->Pelanggan_model->get_by_user_id($this->user['id']);
			$data['history'] = $pelanggan ? $this->Transaksi_model->get_history($pelanggan->id, $data['dari'], $data['sampai']) : array();
		}

		$this->load->view('layout/header', array('title' => 'History Transaksi'));
		$this->load->view('transaksi/history', $data);
		$this->load->view('layout/footer');
	}

	public function retur($id)
	{
		$this->require_role(array('admin', 'apoteker'));

		$transaksi = $this->Transaksi_model->get_by_id($id);
		if (!$transaksi || $transaksi->status === 'returned') {
			$this->session->set_flashdata('error', 'Transaksi tidak ditemukan atau sudah diretur.');
			redirect('transaksi/history');
			return;
		}

		$this->Transaksi_model->retur($id);
		$this->session->set_flashdata('success', 'Retur berhasil diproses. Stok obat telah dikembalikan.');
		redirect('transaksi/history');
	}
}