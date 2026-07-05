<main class="container-fluid p-4 p-md-5">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="<?= site_url('obat') ?>" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h4 class="fw-bold text-dark mb-0">
            <?= $obat ? 'Edit Obat' : 'Tambah Obat' ?>
        </h4>
    </div>

    <?php if (validation_errors()): ?>
        <div class="alert alert-danger" style="max-width: 640px;">
            <?= validation_errors() ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm" style="max-width: 640px;">
        <div class="card-body p-4">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label small text-muted">Kode Obat</label>
                    <input type="text" name="kode_obat"
                           value="<?= htmlspecialchars($obat->kode_obat ?? set_value('kode_obat')) ?>"
                           <?= $obat ? 'readonly' : 'required' ?>
                           class="form-control <?= $obat ? 'bg-light' : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Nama Obat</label>
                    <input type="text" name="nama_obat"
                           value="<?= htmlspecialchars($obat->nama_obat ?? set_value('nama_obat')) ?>" required
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Zat Aktif</label>
                    <input type="text" name="zat_aktif"
                           value="<?= htmlspecialchars($obat->zat_aktif ?? '') ?>"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Kategori</label>
                    <input type="text" name="kategori"
                           value="<?= htmlspecialchars($obat->kategori ?? '') ?>"
                           class="form-control">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga" value="<?= $obat->harga ?? 0 ?>" min="0" required
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Stok</label>
                        <input type="number" name="stok" value="<?= $obat->stok ?? 0 ?>" min="0" required
                               class="form-control">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Stok Minimum</label>
                        <input type="number" name="stok_minimum" value="<?= $obat->stok_minimum ?? 10 ?>" min="0"
                               class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Tanggal Kedaluwarsa</label>
                        <input type="date" name="tanggal_kedaluwarsa"
                               value="<?= $obat->tanggal_kedaluwarsa ?? '' ?>"
                               class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">No. Registrasi BPOM</label>
                    <input type="text" name="no_registrasi_bpom"
                           value="<?= htmlspecialchars($obat->no_registrasi_bpom ?? '') ?>"
                           class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label small text-muted">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control"><?= htmlspecialchars($obat->deskripsi ?? '') ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-lg me-1"></i> Simpan
                    </button>
                    <a href="<?= site_url('obat') ?>" class="btn btn-outline-secondary px-4">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>