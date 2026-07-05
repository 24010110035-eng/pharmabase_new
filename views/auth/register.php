<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Apotek Sehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(to bottom, #f0fdf4, #ffffff); min-height: 100vh; }
        .navbar-brand-icon { background-color: #16a34a; border-radius: 12px; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">

    <div class="w-100" style="max-width: 420px;">
        <div class="card border-0 shadow-lg rounded-4 p-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="navbar-brand-icon mx-auto mb-3">
                        <i class="bi bi-plus-lg text-white fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Buat Akun Baru</h5>
                    <p class="text-muted small">Daftar sebagai pelanggan Apotek Sehat</p>
                </div>

                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger py-2 small"><?= validation_errors() ?></div>
                <?php endif; ?>

                <form action="<?= site_url('auth/register') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="<?= set_value('nama_lengkap') ?>" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">No. Telepon</label>
                        <input type="text" name="no_telp" value="<?= set_value('no_telp') ?>" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Alamat</label>
                        <textarea name="alamat" rows="2" class="form-control"><?= set_value('alamat') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Riwayat Alergi (opsional)</label>
                        <textarea name="riwayat_alergi" rows="2" class="form-control"><?= set_value('riwayat_alergi') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Username</label>
                        <input type="text" name="username" value="<?= set_value('username') ?>" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Password</label>
                        <input type="password" name="password" minlength="6" required class="form-control" placeholder="Minimal 6 karakter">
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-medium">Daftar</button>
                </form>

                <p class="text-center small text-muted mt-4 mb-0">
                    Sudah punya akun?
                    <a href="<?= site_url('login') ?>" class="text-success fw-medium text-decoration-none">Masuk di sini</a>
                </p>
            </div>
        </div>
        <p class="text-center text-muted small mt-4">© <?= date('Y') ?> Apotek Sehat. Semua hak dilindungi.</p>
    </div>

</body>
</html>