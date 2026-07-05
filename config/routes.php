<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login']              = 'auth/login';
$route['logout']             = 'auth/logout';
$route['register']           = 'auth/register';

$route['dashboard']          = 'dashboard/index';


$route['obat']                    = 'obat/index';
$route['obat/cari']               = 'obat/cari';
$route['obat/tambah']             = 'obat/tambah';
$route['obat/edit/(:num)']        = 'obat/edit/$1';
$route['obat/hapus/(:num)']       = 'obat/hapus/$1';


$route['kasir']                    = 'transaksi/kasir';
$route['kasir/tambah_item']        = 'transaksi/tambah_item';
$route['kasir/proses']             = 'transaksi/proses';
$route['transaksi/history']        = 'transaksi/history';
$route['transaksi/retur/(:num)']   = 'transaksi/retur/$1';


$route['pelanggan']                = 'pelanggan/index';
$route['pelanggan/profil']         = 'pelanggan/profil';
$route['pelanggan/edit/(:num)']    = 'pelanggan/edit/$1';
$route['pelanggan/hapus/(:num)']   = 'pelanggan/hapus/$1';

$route['beli']                  = 'transaksi/beli';
$route['beli/tambah_item']      = 'transaksi/tambah_item_pelanggan';
$route['beli/hapus_item/(:num)'] = 'transaksi/hapus_item_pelanggan/$1';
$route['beli/checkout']         = 'transaksi/checkout_pelanggan';

$route['pelanggan/tambah'] = 'pelanggan/tambah';