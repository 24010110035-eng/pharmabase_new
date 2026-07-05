<main class="container-fluid p-4 p-md-5">
    <h4 class="fw-bold text-dark mb-4">Profil Saya</h4>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if (validation_errors()): ?>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm" style="max-width: 560px;">
        <div class="card-body p-4">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label small text-muted">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user['nama']) ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">No. Telepon</label>
                    <input type="text" name="no_telp" value="<?= htmlspecialchars($pelanggan->no_telp ?? '') ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Alamat</label>
                    <textarea name="alamat" rows="2" class="form-control"><?= htmlspecialchars($pelanggan->alamat ?? '') ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label small text-muted">Riwayat Alergi</label>
                    <textarea name="riwayat_alergi" rows="2" class="form-control"><?= htmlspecialchars($pelanggan->riwayat_alergi ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-success px-4">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</main>