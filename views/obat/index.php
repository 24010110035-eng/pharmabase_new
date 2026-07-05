<main class="container-fluid p-4 p-md-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold text-dark mb-0">Katalog Obat</h4>
        <?php if (in_array($this->user['role'], array('admin', 'apoteker'), true)): ?>
        <a href="<?= site_url('obat/tambah') ?>" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Obat
        </a>
        <?php endif; ?>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="get" action="<?= site_url('obat/cari') ?>" class="mb-3" style="max-width: 360px;">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>"
                           placeholder="Cari nama obat / kode obat" class="form-control">
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>Kode</th>
                            <th>Nama Obat</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Kedaluwarsa</th>
                            <?php if (in_array($this->user['role'], array('admin', 'apoteker'), true)): ?>
                            <th class="text-end">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($obat)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data obat.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($obat as $o): ?>
                        <tr>
                            <td class="text-muted"><?= htmlspecialchars($o->kode_obat) ?></td>
                            <td class="fw-medium"><?= htmlspecialchars($o->nama_obat) ?></td>
                            <td class="text-muted"><?= htmlspecialchars($o->kategori ?? '-') ?></td>
                            <td class="text-muted">Rp <?= number_format($o->harga, 0, ',', '.') ?></td>
                            <td>
                                <span class="badge <?= ($o->stok <= $o->stok_minimum) ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' ?>">
                                    <?= (int) $o->stok ?>
                                </span>
                            </td>
                            <td class="text-muted"><?= $o->tanggal_kedaluwarsa ? date('d/m/Y', strtotime($o->tanggal_kedaluwarsa)) : '-' ?></td>
                            <?php if (in_array($this->user['role'], array('admin', 'apoteker'), true)): ?>
                            <td class="text-end">
                                <a href="<?= site_url('obat/edit/' . $o->id) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= site_url('obat/hapus/' . $o->id) ?>" onclick="return confirm('Hapus obat ini?')" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>