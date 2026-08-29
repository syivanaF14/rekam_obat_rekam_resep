<?= view('layouts/header', ['title' => 'Dashboard Resepsionis', 'active' => 'dashboard']) ?>

<style>
    .stat-card { transition: transform .2s, box-shadow .2s; }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.12) !important; }
    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: .75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }
    .quick-tile { transition: transform .2s, box-shadow .2s; }
    .quick-tile:hover { transform: translateY(-3px); box-shadow: 0 .4rem .8rem rgba(0,0,0,.1) !important; }
    .table-card thead th {
        background: #f8f9fa;
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
</style>

<?php
$bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
?>

<div class="page-header">
    <h5 class="mb-0">Ringkasan Resep dan Pasien</h5>
    <span class="badge text-bg-light border fs-6 px-3 py-2">
        <i class="fa-regular fa-calendar me-1"></i><?= date('d') . ' ' . $bulan[(int) date('n') - 1] . ' ' . date('Y') ?>
    </span>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary-subtle text-primary"><i class="fa-solid fa-file-prescription"></i></div>
                <div>
                    <div class="fs-3 fw-bold lh-1"><?= esc($totalResep) ?></div>
                    <div class="text-muted small mt-1">Total Resep</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning-subtle text-warning"><i class="fa-solid fa-clock"></i></div>
                <div>
                    <div class="fs-3 fw-bold lh-1"><?= esc($resepBelumDiambil) ?></div>
                    <div class="text-muted small mt-1">Belum Diambil</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success-subtle text-success"><i class="fa-solid fa-circle-check"></i></div>
                <div>
                    <div class="fs-3 fw-bold lh-1"><?= esc($resepSudahDiambil) ?></div>
                    <div class="text-muted small mt-1">Sudah Diambil</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-dark-subtle text-dark"><i class="fa-solid fa-file-prescription"></i></div>
                <div>
                    <div class="fs-3 fw-bold lh-1"><?= esc($jumlahResepHariIni) ?></div>
                    <div class="text-muted small mt-1">Resep Hari Ini</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-info-subtle text-info"><i class="fa-solid fa-user-injured"></i></div>
                <div>
                    <div class="fs-3 fw-bold lh-1"><?= esc($totalPasien) ?></div>
                    <div class="text-muted small mt-1">Total Pasien</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="fa-solid fa-bolt text-warning"></i> Aksi Cepat
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <a href="<?= site_url('resepsionis/pasien') ?>" class="quick-tile card border-0 shadow-sm text-center p-3 text-decoration-none text-dark">
                        <div class="stat-icon bg-info-subtle text-info mx-auto"><i class="fa-solid fa-user-injured"></i></div>
                        <div class="mt-2 small fw-semibold">Data Pasien</div>
                    </a>
                    <a href="<?= site_url('resepsionis/resep') ?>" class="quick-tile card border-0 shadow-sm text-center p-3 text-decoration-none text-dark">
                        <div class="stat-icon bg-success-subtle text-success mx-auto"><i class="fa-solid fa-file-prescription"></i></div>
                        <div class="mt-2 small fw-semibold">Resep Pasien</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-file-prescription text-success"></i> Resep Terakhir</span>
                <a href="<?= site_url('resepsionis/resep') ?>" class="btn btn-sm btn-outline-success">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>No. Resep</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($resepTerakhir)): ?>
                            <tr><td colspan="5" class="text-center text-muted py-3">Belum ada data resep</td></tr>
                        <?php else: ?>
                            <?php foreach ($resepTerakhir as $r): ?>
                                <tr>
                                    <td class="fw-semibold"><?= esc($r['nomor_resep']) ?></td>
                                    <td><?= esc($r['nama_pasien']) ?></td>
                                    <td><?= esc($r['nama_dokter']) ?></td>
                                    <td><?= esc($r['tanggal_resep']) ?></td>
                                    <td><span class="badge text-bg-<?= badge_status_resep($r['status']) ?>"><?= esc($r['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm table-card">
    <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
        <span><i class="fa-solid fa-file-prescription text-primary"></i> Resep Hari Ini</span>
        <span class="badge text-bg-primary"><?= esc($jumlahResepHariIni) ?></span>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>No. Resep</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($resepHariIni)): ?>
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada resep hari ini</td></tr>
                <?php else: ?>
                    <?php foreach ($resepHariIni as $r): ?>
                        <tr>
                            <td><?= esc($r['nomor_resep']) ?></td>
                            <td><?= esc($r['nama_pasien']) ?></td>
                            <td><?= esc($r['nama_dokter']) ?></td>
                            <td><span class="badge text-bg-<?= badge_status_resep($r['status']) ?>"><?= esc($r['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('layouts/footer') ?>
