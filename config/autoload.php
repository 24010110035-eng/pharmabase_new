<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| File ini menentukan library, helper, dan hal lain yang dimuat otomatis
| di setiap request. Lihat dokumentasi CodeIgniter 3 untuk detail lengkap.
*/

$autoload['packages'] = array();

// 'database' & 'session' wajib untuk seluruh fitur Pharmabase (login, CRUD, transaksi).
// 'form_validation' dipakai di semua controller untuk validasi input form.
$autoload['libraries'] = array('database', 'session', 'form_validation');

$autoload['drivers'] = array();

// 'url' untuk base_url()/site_url(), 'form' untuk form_open()/form_close(),
// 'security' untuk html_escape() & xss cleaning.
$autoload['helper'] = array('url', 'form', 'security', 'app');

$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array('User_model', 'Pelanggan_model', 'Obat_model', 'Transaksi_model');
