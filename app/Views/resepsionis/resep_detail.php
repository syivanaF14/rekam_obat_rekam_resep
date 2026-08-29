<?= view('layouts/header', ['title' => 'Detail Resep', 'active' => 'resep']) ?>

<div class="page-header">
    <h5 class="mb-0">Detail Resep</h5>
    <a href="<?= site_url('resepsionis/resep') ?>" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="text-muted small">Nomor Resep</div>
                <div class="fw-bold"><?= esc($resep['nomor_resep']) ?></div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Tanggal Resep</div>
                <div class="fw-bold"><?= esc($resep['tanggal_resep']) ?></div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Status</div>
                <div><span class="badge text-bg-<?= badge_status_resep($resep['status']) ?>"><?= esc($resep['status']) ?></span></div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Apoteker</div>
                <div class="fw-bold"><?= esc($resep['nama_apoteker']) ?></div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Nama Pasien</div>
                <div class="fw-bold"><?= esc($resep['nama_pasien']) ?></div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Nama Dokter</div>
                <div class="fw-bold"><?= esc($resep['nama_dokter']) ?></div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Diagnosa</div>
                <div><?= esc($resep['diagnosa'] ?: '-') ?></div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Jumlah Item</div>
                <div class="fw-bold"><?= count($detail) ?> obat</div>
            </div>
            <?php if (!empty($resep['catatan'])): ?>
                <div class="col-12">
                    <div class="text-muted small">Catatan</div>
                    <div><?= nl2br(esc($resep['catatan'])) ?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Daftar Obat</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Dosis</th>
                    <th>Aturan Pakai</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($detail as $d): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($d['nama_obat']) ?></td>
                        <td class="fw-semibold"><?= esc($d['jumlah']) ?></td>
                        <td><?= esc($d['dosis'] ?: '-') ?></td>
                        <td><?= esc($d['aturan_pakai'] ?: '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('layouts/footer') ?>
