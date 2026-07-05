</div>
</div>

<footer class="text-center text-muted small py-4 border-top bg-white">
    &copy; <?= date('Y') ?> Apotek Sehat. Semua hak dilindungi.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Tutup sidebar mobile saat klik di luar area sidebar
    document.addEventListener('click', function (e) {
        const sidebar = document.getElementById('sidebarMenu');
        const toggleBtn = e.target.closest('button');
        if (sidebar && sidebar.classList.contains('show') &&
            !sidebar.contains(e.target) &&
            !(toggleBtn && toggleBtn.previousElementSibling === null && toggleBtn.closest('nav'))) {
            if (!e.target.closest('.sidebar') && !e.target.closest('button')) {
                sidebar.classList.remove('show');
            }
        }
    });
</script>

</body>
</html>