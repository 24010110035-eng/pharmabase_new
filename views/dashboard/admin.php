<main class="container-fluid p-4 p-md-5">
    <h4 class="fw-bold text-dark">Selamat datang, <?= htmlspecialchars($this->user['nama']) ?> 👋</h4>
    <p class="text-muted mb-4">Berikut ringkasan apotek hari ini.</p>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <!-- Kartu Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex p-2 mb-3">
                        <i class="bi bi-capsule text-primary fs-5"></i>
                    </div>
                    <p class="text-muted small mb-1">Total Obat</p>
                    <h5 class="fw-bold mb-0"><?= (int) $total_obat ?></h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="bg-danger bg-opacity-10 rounded-3 d-inline-flex p-2 mb-3">
                        <i class="bi bi-exclamation-triangle text-danger fs-5"></i>
                    </div>
                    <p class="text-muted small mb-1">Stok Kritis</p>
                    <h5 class="fw-bold mb-0"><?= count($stok_kritis) ?> obat</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex p-2 mb-3">
                        <i class="bi bi-receipt text-success fs-5"></i>
                    </div>
                    <p class="text-muted small mb-1">Transaksi Tercatat</p>
                    <h5 class="fw-bold mb-0"><?= count($history) ?></h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="bg-purple bg-opacity-10 rounded-3 d-inline-flex p-2 mb-3" style="background-color:#f3e8ff;">
                        <i class="bi bi-person-badge fs-5" style="color:#9333ea;"></i>
                    </div>
                    <p class="text-muted small mb-1">Peran Anda</p>
                    <h5 class="fw-bold mb-0 text-capitalize"><?= htmlspecialchars($this->user['role']) ?></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <a href="<?= site_url('kasir') ?>" class="card border-0 shadow-sm text-center text-decoration-none h-100">
                <div class="card-body">
                    <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex p-3 mb-2">
                        <i class="bi bi-cart3 text-primary fs-4"></i>
                    </div>
                    <p class="fw-semibold text-dark mb-0">Kasir</p>
                    <p class="text-muted small">Buat transaksi baru</p>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="<?= site_url('obat') ?>" class="card border-0 shadow-sm text-center text-decoration-none h-100">
                <div class="card-body">
                    <div class="d-inline-flex p-3 mb-2 rounded-3" style="background-color:#f3e8ff;">
                        <i class="bi bi-capsule fs-4" style="color:#9333ea;"></i>
                    </div>
                    <p class="fw-semibold text-dark mb-0">Data Obat</p>
                    <p class="text-muted small">Kelola stok & harga</p>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="<?= site_url('pelanggan') ?>" class="card border-0 shadow-sm text-center text-decoration-none h-100">
                <div class="card-body">
                    <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex p-3 mb-2">
                        <i class="bi bi-people text-success fs-4"></i>
                    </div>
                    <p class="fw-semibold text-dark mb-0">Pelanggan</p>
                    <p class="text-muted small">Kelola data pelanggan</p>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-3">
        <!-- Obat Stok Kritis -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">Obat Stok Kritis</h6>
                        <a href="<?= site_url('obat') ?>" class="small text-success text-decoration-none">Lihat semua</a>
                    </div>

                    <?php if (empty($stok_kritis)): ?>
                        <div class="text-center py-4">
                            <i class="bi bi-check-circle text-success fs-2"></i>
                            <p class="text-muted small mt-2 mb-0">Semua stok obat aman, tidak ada yang kritis.</p>
                        </div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($stok_kritis as $o): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <p class="fw-medium mb-0"><?= htmlspecialchars($o->nama_obat) ?></p>
                                    <p class="text-muted small mb-0">Min. stok: <?= (int) $o->stok_minimum ?></p>
                                </div>
                                <span class="badge bg-danger-subtle text-danger rounded-pill">
                                    <?= (int) $o->stok ?> tersisa
                                </span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">Transaksi Terbaru</h6>
                        <a href="<?= site_url('transaksi/history') ?>" class="small text-success text-decoration-none">Lihat semua</a>
                    </div>

                    <?php if (empty($history)): ?>
                        <div class="text-center py-4">
                            <i class="bi bi-receipt text-muted fs-2"></i>
                            <p class="text-muted small mt-2 mb-0">Belum ada transaksi tercatat.</p>
                        </div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($history as $t): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <p class="fw-medium mb-0"><?= htmlspecialchars($t->no_nota) ?></p>
                                    <p class="text-muted small mb-0"><?= date('d/m/Y H:i', strtotime($t->created_at)) ?></p>
                                </div>
                                <span class="fw-semibold">Rp <?= number_format($t->total, 0, ',', '.') ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>