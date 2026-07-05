<main class="container-fluid p-4 p-md-5">
    <h4 class="fw-bold text-dark mb-4">
        <?= ($role === 'admin' || $role === 'apoteker') ? 'Riwayat Transaksi' : 'Riwayat Pembelian Saya' ?>
    </h4>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="get" class="row g-2 align-items-end mb-4">
                <div class="col-auto">
                    <label class="form-label small text-muted mb-1">Dari Tanggal</label>
                    <input type="date" name="dari" value="<?= htmlspecialchars($dari ?? '') ?>" class="form-control">
                </div>
                <div class="col-auto">
                    <label class="form-label small text-muted mb-1">Sampai Tanggal</label>
                    <input type="date" name="sampai" value="<?= htmlspecialchars($sampai ?? '') ?>" class="form-control">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">Filter</button>
                </div>
                <div class="col-auto">
                    <a href="<?= site_url('transaksi/history') ?>" class="btn btn-link text-muted text-decoration-none">Reset</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>No. Nota</th>
                            <th>Tanggal</th>
                            <?php if ($role === 'admin' || $role === 'apoteker'): ?>
                            <th>Kasir</th>
                            <th>Pelanggan</th>
                            <?php endif; ?>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($history)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($history as $t): ?>
                        <tr>
                            <td class="fw-medium"><?= htmlspecialchars($t->no_nota) ?></td>
                            <td class="text-muted"><?= date('d/m/Y H:i', strtotime($t->created_at)) ?></td>
                            <?php if ($role === 'admin' || $role === 'apoteker'): ?>
                            <td class="text-muted"><?= htmlspecialchars($t->nama_kasir ?? '-') ?></td>
                            <td class="text-muted"><?= htmlspecialchars($t->nama_pelanggan ?? 'Umum') ?></td>
                            <?php endif; ?>
                            <td class="fw-semibold">Rp <?= number_format($t->total, 0, ',', '.') ?></td>
                            <td>
                                <?php $badge = ($t->status === 'returned') ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success'; ?>
                                <span class="badge <?= $badge ?>">
                                    <?= ($t->status === 'returned') ? 'Retur' : 'Sukses' ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <?php if (($role === 'admin' || $role === 'apoteker') && $t->status !== 'returned'): ?>
                                <a href="<?= site_url('transaksi/retur/' . $t->id) ?>" onclick="return confirm('Proses retur transaksi ini?')"
                                   class="btn btn-sm btn-outline-danger">Retur</a>
                                <?php else: ?>
                                <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>