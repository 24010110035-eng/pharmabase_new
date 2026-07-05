<main class="container-fluid p-4 p-md-5">
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="<?= site_url('pelanggan') ?>" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h4 class="fw-bold text-dark mb-0">Tambah Pelanggan</h4>
    </div>

    <?php if (validation_errors()): ?>
        <div class="alert alert-danger" style="max-width: 560px;">
            <?= validation_errors() ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm" style="max-width: 560px;">
        <div class="card-body p-4">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label small text-muted">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="<?= set_value('nama_lengkap') ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Username</label>
                    <input type="text" name="username" value="<?= set_value('username') ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Password</label>
                    <input type="password" name="password" minlength="6" required class="form-control" placeholder="Minimal 6 karakter">
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">No. Telepon</label>
                    <input type="text" name="no_telp" value="<?= set_value('no_telp') ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Alamat</label>
                    <textarea name="alamat" rows="2" class="form-control"><?= set_value('alamat') ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label small text-muted">Riwayat Alergi (opsional)</label>
                    <textarea name="riwayat_alergi" rows="2" class="form-control"><?= set_value('riwayat_alergi') ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4">Simpan</button>
                    <a href="<?= site_url('pelanggan') ?>" class="btn btn-outline-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</main>