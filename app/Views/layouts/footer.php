        </main>

        <footer class="text-center text-muted small py-3 border-top">
            &copy; <?= date('Y') ?> Aplikasi Rekam Obat &amp; Rekam Resep &mdash; Program Magang Mahasiswa Klinik
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<?php if (!empty($chartJs)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<?php endif; ?>

<?php if (!empty($inlineScript)): ?>
<script>
<?= $inlineScript ?>
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('swal_success')): ?>
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('swal_success') ?>' });
</script>
<?php endif; ?>
<?php if (session()->getFlashdata('swal_error')): ?>
<script>
    Swal.fire({ icon: 'error', title: 'Gagal!', text: '<?= session()->getFlashdata('swal_error') ?>' });
</script>
<?php endif; ?>
</body>
</html>
