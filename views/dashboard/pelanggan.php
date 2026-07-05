<main class="container-fluid p-4 p-md-5">
    <h4 class="fw-bold text-dark">Halo, <?= htmlspecialchars($this->user['nama']) ?> 👋</h4>
    <p class="text-muted mb-4">Selamat datang kembali di Apotek Sehat.</p>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <?php
        $total_transaksi = count($history);
        $total_belanja   = array_sum(array_map(function ($t) { return $t->total; }, $history));
        $transaksi_terakhir = !empty($history) ? $history[0] : null;
    ?>

    <!-- Kartu Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex p-2 mb-3">
                        <i class="bi bi-receipt text-success fs-5"></i>
                    </div>
                    <p class="text-muted small mb-1">Total Transaksi</p>
                    <h5 class="fw-bold mb-0"><?= (int) $total_transaksi ?></h5>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex p-2 mb-3">
                        <i class="bi bi-cash-coin text-primary fs-5"></i>
                    </div>
                    <p class="text-muted small mb-1">Total Belanja</p>
                    <h5 class="fw-bold mb-0">Rp <?= number_format($total_belanja, 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-inline-flex p-2 mb-3 rounded-3" style="background-color:#f3e8ff;">
                        <i class="bi bi-clock-history fs-5" style="color:#9333ea;"></i>
                    </div>
                    <p class="text-muted small mb-1">Transaksi Terakhir</p>
                    <h5 class="fw-bold mb-0">
                        <?= $transaksi_terakhir ? date('d/m/Y', strtotime($transaksi_terakhir->created_at)) : '-' ?>
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6">
            <a href="<?= site_url('pelanggan/profil') ?>" class="card border-0 shadow-sm text-center text-decoration-none h-100">
                <div class="card-body">
                    <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex p-3 mb-2">
                        <i class="bi bi-person text-success fs-4"></i>
                    </div>
                    <p class="fw-semibold text-dark mb-0">Profil Saya</p>
                    <p class="text-muted small">Lihat & ubah data akun</p>
                </div>
            </a>
        </div>
        <div class="col-sm-6">
            <a href="<?= site_url('transaksi/history') ?>" class="card border-0 shadow-sm text-center text-decoration-none h-100">
                <div class="card-body">
                    <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex p-3 mb-2">
                        <i class="bi bi-receipt text-primary fs-4"></i>
                    </div>
                    <p class="fw-semibold text-dark mb-0">Riwayat Pembelian</p>
                    <p class="text-muted small">Cek transaksi Anda</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Pembelian Terbaru -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-semibold mb-0">Pembelian Terbaru</h6>
                <a href="<?= site_url('transaksi/history') ?>" class="small text-success text-decoration-none">Lihat semua</a>
            </div>

            <?php if (empty($history)): ?>
                <div class="text-center py-4">
                    <i class="bi bi-receipt text-muted fs-2"></i>
                    <p class="text-muted small mt-2 mb-0">Belum ada riwayat pembelian.</p>
                </div>
            <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php foreach (array_slice($history, 0, 5) as $t): ?>
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
</main>