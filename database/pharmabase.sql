-- =========================================================
-- Database: pharmabase
-- Sistem Manajemen Apotek Online "Pharmabase"

-- =========================================================

CREATE DATABASE IF NOT EXISTS pharmabase CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pharmabase;

-- ---------------------------------------------------------
-- Tabel users: menyimpan akun Admin/Apoteker & Pelanggan
-- ---------------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role ENUM('admin','apoteker','pelanggan') NOT NULL DEFAULT 'pelanggan',
    status ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabel pelanggan: profil medis ringkas & kontak
-- ---------------------------------------------------------
CREATE TABLE pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    alamat TEXT,
    no_telp VARCHAR(20),
    riwayat_alergi TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabel obat: katalog obat / inventaris
-- ---------------------------------------------------------
CREATE TABLE obat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_obat VARCHAR(20) NOT NULL UNIQUE,
    nama_obat VARCHAR(150) NOT NULL,
    zat_aktif VARCHAR(150),
    kategori VARCHAR(100),
    harga DECIMAL(12,2) NOT NULL DEFAULT 0,
    stok INT NOT NULL DEFAULT 0,
    stok_minimum INT NOT NULL DEFAULT 10,
    tanggal_kedaluwarsa DATE,
    no_registrasi_bpom VARCHAR(50),
    deskripsi TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabel transaksi: header penjualan / retur
-- ---------------------------------------------------------
CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_nota VARCHAR(30) NOT NULL UNIQUE,
    kasir_id INT NOT NULL,
    pelanggan_id INT NULL,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    status ENUM('sukses','returned') NOT NULL DEFAULT 'sukses',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kasir_id) REFERENCES users(id),
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabel transaksi_detail: rincian item per transaksi
-- ---------------------------------------------------------
CREATE TABLE transaksi_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaksi_id INT NOT NULL,
    obat_id INT NOT NULL,
    qty INT NOT NULL,
    harga_satuan DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE,
    FOREIGN KEY (obat_id) REFERENCES obat(id)
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Data awal (seed): akun admin default & contoh obat
-- Username: admin | Password: admin123  (SEGERA GANTI setelah login pertama!)
-- ---------------------------------------------------------
INSERT INTO users (username, password, nama_lengkap, role) VALUES
('admin', '$2b$12$n/b1q4ypwfvALVCPj65AEeqT0anjiNtT9Xvx2dIp/MtPIuANG4LvO', 'Administrator Pharmabase', 'admin');

INSERT INTO obat (kode_obat, nama_obat, zat_aktif, kategori, harga, stok, stok_minimum, tanggal_kedaluwarsa, no_registrasi_bpom, deskripsi) VALUES
('OBT-001', 'Paracetamol 500mg', 'Paracetamol', 'Analgesik/Antipiretik', 5000, 150, 20, '2027-06-01', 'DBL1234567890A1', 'Meredakan demam dan nyeri ringan.'),
('OBT-002', 'Amoxicillin 500mg', 'Amoxicillin', 'Antibiotik', 12000, 80, 15, '2027-01-15', 'GKL7654321012A1', 'Antibiotik golongan penisilin, wajib resep.'),
('OBT-003', 'Vitamin C 1000mg', 'Ascorbic Acid', 'Suplemen', 25000, 200, 30, '2027-09-20', 'SD191234567890', 'Suplemen penambah daya tahan tubuh.'),
('OBT-004', 'Antasida Tablet', 'Aluminium Hidroksida', 'Gastrointestinal', 8000, 100, 20, '2026-12-10', 'DTL1122334455A1', 'Meredakan gejala maag dan asam lambung.'),
('OBT-005', 'Cetirizine 10mg', 'Cetirizine HCl', 'Antihistamin', 7500, 60, 15, '2027-03-05', 'DKL9988776655A1', 'Meredakan gejala alergi.');
