<?= view('layouts/header', ['title' => 'Data Pasien', 'active' => 'pasien']) ?>

<div class="page-header">
    <h5 class="mb-0">Data Pasien</h5>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2">
        <form action="<?= site_url('resepsionis/pasien') ?>" method="get" class="row g-2 align-items-center">
            <div class="col-sm-8 col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Cari nama pasien..."
                           value="<?= esc($keyword) ?>">
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
                <?php if ($keyword !== ''): ?>
                    <a href="<?= site_url('resepsionis/pasien') ?>" class="btn btn-outline-secondary">Reset</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Jumlah Resep</th>
                    <th>Pertama Kali</th>
                    <th>Terakhir Kunjungan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pasien)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Tidak ada data pasien.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; ?>
                    <?php foreach ($pasien as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-semibold"><?= esc($p['nama_pasien']) ?></td>
                            <td><span class="badge text-bg-info"><?= esc($p['jumlah_resep']) ?></span></td>
                            <td><?= esc($p['pertama_kali']) ?></td>
                            <td><?= esc($p['terakhir_kunjungan']) ?></td>
                            <td>
                                <a href="<?= site_url('resepsionis/pasien/detail/' . rawurlencode($p['nama_pasien'])) ?>" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    <span class="text-muted small">Total: <?= count($pasien) ?> pasien</span>
</div>

<?= view('layouts/footer') ?>
