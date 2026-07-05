<main class="container-fluid p-4 p-md-5">
    <h4 class="fw-bold text-dark mb-4">Kasir</h4>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <div class="row g-3">
        <!-- Kolom kiri: daftar obat + keranjang -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <input type="text" id="cariObat" class="form-control mb-3" placeholder="Cari nama obat / kode obat" onkeyup="filterObat()">

                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
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
                                    <td><?= rupiah($o->harga) ?></td>
                                    <td>
                                        <span class="badge <?= ($o->stok <= $o->stok_minimum) ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' ?>">
                                            <?= (int) $o->stok ?>
                                        </span>
                                    </td>
                                    <td style="width: 90px;">
                                        <form action="<?= site_url('kasir/tambah_item') ?>" method="post" class="d-flex align-items-center gap-1">
                                            <input type="hidden" name="obat_id" value="<?= $o->id ?>">
                                            <input type="number" name="qty" value="1" min="1" max="<?= (int) $o->stok ?>"
                                                   class="form-control form-control-sm" style="width: 60px;">
                                    </td>
                                    <td class="text-end">
                                            <button type="submit" class="btn btn-sm btn-success" <?= $o->stok < 1 ? 'disabled' : '' ?>>
                                                <i class="bi bi-plus-lg"></i>
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

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Keranjang</h6>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr class="text-muted small">
                                    <th>Obat</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($cart)): ?>
                                <tr><td colspan="4" class="text-center text-muted py-4">Keranjang masih kosong.</td></tr>
                                <?php endif; ?>
                                <?php $subtotal_total = 0; ?>
                                <?php foreach ($cart as $item): ?>
                                <?php $baris_subtotal = $item['harga_satuan'] * $item['qty']; $subtotal_total += $baris_subtotal; ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['nama_obat']) ?></td>
                                    <td><?= rupiah($item['harga_satuan']) ?></td>
                                    <td><?= (int) $item['qty'] ?></td>
                                    <td class="fw-medium"><?= rupiah($baris_subtotal) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom kanan: ringkasan & pembayaran -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Ringkasan Pembayaran</h6>

                    <form action="<?= site_url('kasir/proses') ?>" method="post">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Pelanggan (opsional)</label>
                            <select name="pelanggan_id" class="form-select">
                                <option value="">Pelanggan Umum</option>
                                <?php foreach ($pelanggan as $p): ?>
                                <option value="<?= $p->id ?>"><?= htmlspecialchars($p->nama_lengkap) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Subtotal</span>
                            <span class="fw-medium text-dark" id="subtotalText"><?= rupiah($subtotal_total ?? 0) ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-semibold">Total</span>
                            <span class="fw-bold text-success fs-5" id="totalBelanja" data-total="<?= (int) ($subtotal_total ?? 0) ?>">
                                <?= rupiah($subtotal_total ?? 0) ?>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Dibayar</label>
                            <input type="number" name="dibayar" id="dibayar" min="0" class="form-control" placeholder="0" required>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted small">Kembalian</span>
                            <span class="fw-semibold text-success" id="kembalian">Rp 0</span>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mb-2" <?= empty($cart) ? 'disabled' : '' ?>>
                            Proses Pembayaran
                        </button>
                    </form>
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

    const totalEl = document.getElementById('totalBelanja');
    const total = totalEl ? parseInt(totalEl.dataset.total, 10) : 0;
    const dibayarInput = document.getElementById('dibayar');
    const kembalianEl = document.getElementById('kembalian');

    if (dibayarInput) {
        dibayarInput.addEventListener('input', function () {
            const dibayar = parseInt(this.value || 0, 10);
            const kembalian = dibayar - total;
            kembalianEl.textContent = 'Rp ' + (kembalian > 0 ? kembalian : 0).toLocaleString('id-ID');
            kembalianEl.classList.toggle('text-danger', kembalian < 0);
            kembalianEl.classList.toggle('text-success', kembalian >= 0);
        });
    }
</script>