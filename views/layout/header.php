<?php
$role = $this->user['role'] ?? 'pelanggan';
$current_url = uri_string();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Sehat<?= isset($title) ? ' - ' . htmlspecialchars($title) : '' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            min-height: calc(100vh - 56px);
            background-color: #fff;
            border-right: 1px solid #e9ecef;
        }
        .sidebar .nav-link {
            color: #6c757d;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 2px;
            font-size: 0.9rem;
        }
        .sidebar .nav-link i {
            width: 20px;
        }
        .sidebar .nav-link:hover {
            background-color: #f3f4f6;
            color: #16a34a;
        }
        .sidebar .nav-link.active {
            background-color: #dcfce7;
            color: #16a34a;
            font-weight: 600;
        }
        .navbar-brand-icon {
            background-color: #16a34a;
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .content-wrapper {
            min-height: calc(100vh - 56px);
        }
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 56px;
                left: 0;
                z-index: 1030;
                transform: translateX(-100%);
                transition: transform 0.2s ease-in-out;
            }
            .sidebar.show {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>

<!-- Navbar atas -->
<nav class="navbar navbar-light bg-white border-bottom sticky-top px-3">
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-light d-md-none" onclick="document.getElementById('sidebarMenu').classList.toggle('show')">
            <i class="bi bi-list fs-5"></i>
        </button>
        <span class="navbar-brand-icon">
            <i class="bi bi-plus-lg text-white"></i>
        </span>
        <span class="fw-bold fs-5 text-dark">Apotek Sehat</span>
    </div>

    <div class="dropdown">
        <button class="btn btn-light d-flex align-items-center gap-2 border-0" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle fs-4 text-secondary"></i>
            <span class="d-none d-sm-inline small fw-medium text-dark"><?= htmlspecialchars($this->user['nama'] ?? '') ?></span>
            <span class="badge bg-light text-secondary border text-uppercase" style="font-size: 0.65rem;"><?= htmlspecialchars($role) ?></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <?php if ($role === 'pelanggan'): ?>
            <li><a class="dropdown-item" href="<?= site_url('pelanggan/profil') ?>"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
            <li><hr class="dropdown-divider"></li>
            <?php endif; ?>
            <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
    </div>
</nav>

<div class="d-flex">
    <!-- Sidebar -->
    <aside class="sidebar p-3" id="sidebarMenu">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="<?= site_url('dashboard') ?>" class="nav-link d-flex align-items-center <?= (strpos($current_url, 'dashboard') === 0) ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <?php if (in_array($role, array('admin', 'apoteker'), true)): ?>
            <li class="nav-item">
                <a href="<?= site_url('obat') ?>" class="nav-link d-flex align-items-center <?= (strpos($current_url, 'obat') === 0) ? 'active' : '' ?>">
                    <i class="bi bi-capsule me-2"></i> Data Obat
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('kasir') ?>" class="nav-link d-flex align-items-center <?= (strpos($current_url, 'kasir') === 0 || strpos($current_url, 'transaksi/kasir') === 0) ? 'active' : '' ?>">
                    <i class="bi bi-cart3 me-2"></i> Kasir
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('pelanggan') ?>" class="nav-link d-flex align-items-center <?= (strpos($current_url, 'pelanggan') === 0) ? 'active' : '' ?>">
                    <i class="bi bi-people me-2"></i> Pelanggan
                </a>
            </li>
            <?php endif; ?>

            <li class="nav-item">
                <a href="<?= site_url('transaksi/history') ?>" class="nav-link d-flex align-items-center <?= (strpos($current_url, 'transaksi/history') === 0) ? 'active' : '' ?>">
                    <i class="bi bi-receipt me-2"></i> Riwayat Transaksi
                </a>
            </li>

            <?php if ($role === 'pelanggan'): ?>
            <li class="nav-item">
                <a href="<?= site_url('beli') ?>" class="nav-link d-flex align-items-center <?= (strpos($current_url, 'beli') === 0) ? 'active' : '' ?>">
                    <i class="bi bi-bag-plus me-2"></i> Beli Obat
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('pelanggan/profil') ?>" class="nav-link d-flex align-items-center <?= (strpos($current_url, 'pelanggan/profil') === 0) ? 'active' : '' ?>">
                    <i class="bi bi-person me-2"></i> Profil Saya
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <hr>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="<?= site_url('logout') ?>" class="nav-link d-flex align-items-center text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- Konten halaman dimulai di sini, ditutup di footer.php -->
    <div class="content-wrapper flex-grow-1">