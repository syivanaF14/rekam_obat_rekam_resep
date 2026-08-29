<?= view('layouts/header', ['title' => 'Detail Pasien', 'active' => 'pasien']) ?>

<div class="page-header">
    <h5 class="mb-0">Detail Pasien: <?= esc($nama) ?></h5>
    <a href="<?= site_url('resepsionis/pasien') ?>" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="text-muted small">Nama Pasien</div>
                <div class="fw-bold fs-5"><?= esc($nama) ?></div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Jumlah Resep</div>
                <div class="fw-bold fs-5"><?= esc($jumlahResep) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Riwayat Resep</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>No. Resep</th>
                    <th>Tanggal</th>
                    <th>Dokter</th>
                    <th>Diagnosa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($resep)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Tidak ada resep untuk pasien ini.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($resep as $r): ?>
                        <tr>
                            <td class="fw-semibold"><?= esc($r['nomor_resep']) ?></td>
                            <td><?= esc($r['tanggal_resep']) ?></td>
                            <td><?= esc($r['nama_dokter']) ?></td>
                            <td><?= esc($r['diagnosa'] ?: '-') ?></td>
                            <td><span class="badge text-bg-<?= badge_status_resep($r['status']) ?>"><?= esc($r['status']) ?></span></td>
                            <td>
                                <a href="<?= site_url('resepsionis/resep/detail/' . $r['id']) ?>" class="btn btn-sm btn-outline-info" title="Detail Resep">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('layouts/footer') ?>
