<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Apotek Sehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(to bottom, #f0fdf4, #ffffff); min-height: 100vh; }
        .navbar-brand-icon { background-color: #16a34a; border-radius: 12px; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">

    <div class="w-100" style="max-width: 380px;">
        <div class="card border-0 shadow-lg rounded-4 p-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="navbar-brand-icon mx-auto mb-3">
                        <i class="bi bi-plus-lg text-white fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Apotek Sehat</h5>
                    <p class="text-muted small">Masuk ke akun Anda</p>
                </div>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger py-2 small"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success py-2 small"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>

                <form action="<?= site_url('auth/login') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Username</label>
                        <input type="text" name="username" value="<?= set_value('username') ?>" required
                               placeholder="Masukkan username" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" required
                                   placeholder="Masukkan password" class="form-control">
                            <button type="button" class="btn btn-outline-secondary" onclick="const p=document.getElementById('password'); p.type = p.type==='password'?'text':'password';">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-medium">Masuk</button>
                </form>

                <p class="text-center small text-muted mt-4 mb-0">
                    Belum punya akun?
                    <a href="<?= site_url('register') ?>" class="text-success fw-medium text-decoration-none">Daftar di sini</a>
                </p>
            </div>
        </div>
        <p class="text-center text-muted small mt-4">© <?= date('Y') ?> Apotek Sehat. Semua hak dilindungi.</p>
    </div>

</body>
</html>