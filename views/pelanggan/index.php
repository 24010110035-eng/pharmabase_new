<main class="container-fluid p-4 p-md-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold text-dark mb-0">Manajemen Pelanggan</h4>
        <a href="<?= site_url('pelanggan/tambah') ?>" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pelanggan
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>Nama</th>
                            <th>Username</th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pelanggan)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data pelanggan.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($pelanggan as $p): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-semibold"
                                         style="width:32px; height:32px; font-size: 0.8rem;">
                                        <?= strtoupper(substr($p->nama_lengkap, 0, 1)) ?>
                                    </div>
                                    <span class="fw-medium"><?= htmlspecialchars($p->nama_lengkap) ?></span>
                                </div>
                            </td>
                            <td class="text-muted"><?= htmlspecialchars($p->username) ?></td>
                            <td class="text-muted"><?= htmlspecialchars($p->no_telp ?? '-') ?></td>
                            <td>
                                <span class="badge <?= ($p->status === 'aktif') ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' ?>">
                                    <?= ucfirst($p->status) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="<?= site_url('pelanggan/edit/' . $p->id) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= site_url('pelanggan/hapus/' . $p->id) ?>" onclick="return confirm('Hapus pelanggan ini?')" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>