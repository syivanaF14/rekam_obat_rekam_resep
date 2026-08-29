<?= view('layouts/header', ['title' => 'Resep Pasien', 'active' => 'resep']) ?>

<div class="page-header">
    <h5 class="mb-0">Resep Pasien</h5>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2">
        <form action="<?= site_url('resepsionis/resep') ?>" method="get" class="row g-2 align-items-center">
            <div class="col-sm-8 col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Cari pasien, no. resep, dokter, atau tanggal..."
                           value="<?= esc($keyword) ?>">
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Belum Diambil" <?= ($status ?? '') === 'Belum Diambil' ? 'selected' : '' ?>>Belum Diambil</option>
                    <option value="Sudah Diambil" <?= ($status ?? '') === 'Sudah Diambil' ? 'selected' : '' ?>>Sudah Diambil</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
                <?php if (($keyword ?? '') !== '' || ($status ?? '') !== ''): ?>
                    <a href="<?= site_url('resepsionis/resep') ?>" class="btn btn-outline-secondary">Reset</a>
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
                    <th>No. Resep</th>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Status</th>
                    <th>Apoteker</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($resep)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Tidak ada data resep.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = ($pager->getCurrentPage() - 1) * $pager->getPerPage(); ?>
                    <?php foreach ($resep as $r): ?>
                        <?php $no++; ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td class="fw-semibold"><?= esc($r['nomor_resep']) ?></td>
                            <td><?= esc($r['tanggal_resep']) ?></td>
                            <td><?= esc($r['nama_pasien']) ?></td>
                            <td><?= esc($r['nama_dokter']) ?></td>
                            <td><span class="badge text-bg-<?= badge_status_resep($r['status']) ?>"><?= esc($r['status']) ?></span></td>
                            <td><?= esc($r['nama_apoteker']) ?></td>
                            <td>
                                <a href="<?= site_url('resepsionis/resep/detail/' . $r['id']) ?>" class="btn btn-sm btn-outline-info" title="Detail">
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

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap">
    <span class="text-muted small">Total: <?= $pager->getTotal() ?> resep</span>
    <?= $pager->links('default', 'bootstrap_pagination') ?>
</div>

<?= view('layouts/footer') ?>
