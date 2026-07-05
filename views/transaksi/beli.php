<main class="container-fluid p-4 p-md-5">
    <h4 class="fw-bold text-dark mb-4">Beli Obat</h4>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <div class="row g-3">
        <!-- Katalog Obat -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <input type="text" id="cariObat" class="form-control mb-3" placeholder="Cari nama obat" onkeyup="filterObat()">

                    <div class="table-responsive" style="max-height: 460px; overflow-y: auto;">
                        <table class="table table-sm align-middle" id="tabelObat">
                            <thead>
                                <tr class="text-muted small">
                                    <th>Obat</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Qty</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($obat)): ?>
                                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data obat.</td></tr>
                                <?php endif; ?>
                                <?php foreach ($obat as $o): ?>
                                <tr class="baris-obat">
                                    <td class="nama-obat"><?= htmlspecialchars($o->nama_obat) ?></td>
                                    <td>Rp <?= number_format($o->harga, 0, ',', '.') ?></td>
                                    <td>
                                        <span class="badge <?= ($o->stok < 1) ? 'bg-secondary-subtle text-secondary' : 'bg-success-subtle text-success' ?>">
                                            <?= (int) $o->stok ?>
                                        </span>
                                    </td>
                                    <td style="width: 90px;">
                                        <form action="<?= site_url('beli/tambah_item') ?>" method="post" class="d-flex align-items-center gap-1">
                                            <input type="hidden" name="obat_id" value="<?= $o->id ?>">
                                            <input type="number" name="qty" value="1" min="1" max="<?= (int) $o->stok ?>"
                                                   class="form-control form-control-sm" style="width: 60px;" <?= $o->stok < 1 ? 'disabled' : '' ?>>
                                    </td>
                                    <td class="text-end">
                                            <button type="submit" class="btn btn-sm btn-success" <?= $o->stok < 1 ? 'disabled' : '' ?>>
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keranjang & Checkout -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Keranjang Saya</h6>

                    <?php if (empty($cart)): ?>
                        <div class="text-center py-4">
                            <i class="bi bi-cart text-muted fs-2"></i>
                            <p class="text-muted small mt-2 mb-0">Keranjang masih kosong.</p>
                        </div>
                    <?php else: ?>
                        <?php $total = 0; ?>
                        <ul class="list-group list-group-flush mb-3">
                            <?php foreach ($cart as $item): ?>
                            <?php $subtotal = $item['harga_satuan'] * $item['qty']; $total += $subtotal; ?>
                            <li class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium mb-0"><?= htmlspecialchars($item['nama_obat']) ?></p>
                                        <p class="text-muted small mb-0"><?= (int) $item['qty'] ?> x Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></p>
                                    </div>
                                    <div class="text-end">
                                        <p class="fw-semibold mb-1">Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
                                        <a href="<?= site_url('beli/hapus_item/' . $item['obat_id']) ?>" class="text-danger small text-decoration-none">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-semibold">Total</span>
                            <span class="fw-bold text-success fs-5">Rp <?= number_format($total, 0, ',', '.') ?></span>
                        </div>

                        <form action="<?= site_url('beli/checkout') ?>" method="post">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-lg me-1"></i> Checkout Sekarang
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function filterObat() {
        const keyword = document.getElementById('cariObat').value.toLowerCase();
        document.querySelectorAll('.baris-obat').forEach(function (row) {
            const nama = row.querySelector('.nama-obat').textContent.toLowerCase();
            row.style.display = nama.includes(keyword) ? '' : 'none';
        });
    }
</script>