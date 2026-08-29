<?php
$obat = $obat ?? null;
$isEdit = $obat !== null;
?>
<?= view('layouts/header', ['title' => $isEdit ? 'Edit Obat' : 'Tambah Obat', 'active' => 'obat']) ?>

<div class="page-header">
    <h5 class="mb-0"><?= $isEdit ? 'Edit Obat' : 'Tambah Obat' ?></h5>
    <a href="<?= site_url('obat') ?>" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= esc($action) ?>" method="post" autocomplete="off">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                    <input type="text" name="nama_obat" class="form-control" required
                           value="<?= esc($isEdit ? $obat['nama_obat'] : old('nama_obat')) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Input <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_input" class="form-control" required
                           value="<?= esc($isEdit ? $obat['tanggal_input'] : (old('tanggal_input') ?: date('Y-m-d'))) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Periode Stok (MM-YYYY) <span class="text-danger">*</span></label>
                    <input type="text" name="periode_stok" class="form-control" required placeholder="08-2026"
                           value="<?= esc($isEdit ? $obat['periode_stok'] : (old('periode_stok') ?: date('m-Y'))) ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                    <input type="number" name="stok_awal" id="stok_awal" class="form-control" min="0" required
                           value="<?= esc($isEdit ? $obat['stok_awal'] : old('stok_awal')) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stok Masuk <span class="text-danger">*</span></label>
                    <input type="number" name="stok_masuk" id="stok_masuk" class="form-control" min="0" required
                           value="<?= esc($isEdit ? $obat['stok_masuk'] : old('stok_masuk')) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stok Keluar <span class="text-danger">*</span></label>
                    <input type="number" name="stok_keluar" id="stok_keluar" class="form-control" min="0" required
                           value="<?= esc($isEdit ? $obat['stok_keluar'] : old('stok_keluar')) ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Stok Akhir (Otomatis)</label>
                    <input type="text" id="stok_akhir" class="form-control bg-light" readonly
                           value="<?= esc($isEdit ? $obat['stok_akhir'] : '0') ?>">
                    <small class="text-muted">Stok Akhir = Stok Awal + Stok Masuk - Stok Keluar</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Expired <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_expired" class="form-control" required
                           value="<?= esc($isEdit ? $obat['tanggal_expired'] : old('tanggal_expired')) ?>">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> <?= $isEdit ? 'Simpan Perubahan' : 'Simpan' ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function hitungStokAkhir() {
        var awal = parseInt($('#stok_awal').val()) || 0;
        var masuk = parseInt($('#stok_masuk').val()) || 0;
        var keluar = parseInt($('#stok_keluar').val()) || 0;
        $('#stok_akhir').val(awal + masuk - keluar);
    }

    $('#stok_awal, #stok_masuk, #stok_keluar').on('input', hitungStokAkhir);
</script>

<?= view('layouts/footer') ?>
