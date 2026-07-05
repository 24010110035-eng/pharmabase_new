<main class="flex-1 p-4 md:p-8">
            <h1 class="text-xl font-bold text-gray-800 mb-5">Edit Pelanggan</h1>

            <?php if (validation_errors()): ?>
                <div class="mb-4 px-4 py-2.5 rounded-lg bg-red-50 text-red-600 text-sm max-w-xl"><?= validation_errors() ?></div>
            <?php endif; ?>

            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 max-w-xl">
                <form method="post" class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($pelanggan['nama']) ?>" required
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($pelanggan['email']) ?>" required
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">No. HP</label>
                        <input type="text" name="no_hp" value="<?= htmlspecialchars($pelanggan['no_hp'] ?? '') ?>"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Alamat</label>
                        <textarea name="alamat" rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500"><?= htmlspecialchars($pelanggan['alamat'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Status Akun</label>
                        <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="aktif" <?= (($pelanggan['status'] ?? 'aktif') === 'aktif') ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= (($pelanggan['status'] ?? '') === 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Reset Password</label>
                        <input type="password" name="password"
                               placeholder="Kosongkan jika tidak ingin mengubah"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 rounded-lg transition">
                            Simpan
                        </button>
                        <a href="<?= site_url('pelanggan') ?>" class="flex-1 text-center border border-gray-200 text-gray-600 font-medium py-2.5 rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>