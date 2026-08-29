<?= view('layouts/header', ['title' => 'Dashboard', 'active' => 'dashboard']) ?>

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
    .table-card thead th {
        background: #f8f9fa;
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .quick-tile { transition: transform .2s, box-shadow .2s; }
    .quick-tile:hover { transform: translateY(-3px); box-shadow: 0 .4rem .8rem rgba(0,0,0,.1) !important; }
    .chart-legend { display: flex; flex-direction: column; gap: .55rem; }
    .chart-legend .dot { width: 12px; height: 12px; border-radius: 50%; display: inline-block; }
</style>

<?php
$bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
?>

<div class="page-header">
    <h5 class="mb-0">Ringkasan Stok Obat dan Resep</h5>
    <span class="badge text-bg-light border fs-6 px-3 py-2">
        <i class="fa-regular fa-calendar me-1"></i><?= date('d') . ' ' . $bulan[(int) date('n') - 1] . ' ' . date('Y') ?>
    </span>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary-subtle text-primary"><i class="fa-solid fa-boxes-stacked"></i></div>
                <div>
                    <div class="fs-3 fw-bold lh-1"><?= esc($totalJenis) ?></div>
                    <div class="text-muted small mt-1">Jenis Obat</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-info-subtle text-info"><i class="fa-solid fa-pills"></i></div>
                <div>
                    <div class="fs-3 fw-bold lh-1"><?= esc(number_format($totalStok)) ?></div>
                    <div class="text-muted small mt-1">Total Stok Obat</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success-subtle text-success"><i class="fa-solid fa-circle-check"></i></div>
                <div>
                    <div class="fs-3 fw-bold lh-1"><?= esc($jumlahSehat) ?></div>
                    <div class="text-muted small mt-1">Obat Sehat</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning-subtle text-warning"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div>
                    <div class="fs-3 fw-bold lh-1"><?= esc($jumlahWaspada) ?></div>
                    <div class="text-muted small mt-1">Hampir Expired</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-danger-subtle text-danger"><i class="fa-solid fa-circle-xmark"></i></div>
                <div>
                    <div class="fs-3 fw-bold lh-1"><?= esc($jumlahExpired) ?></div>
                    <div class="text-muted small mt-1">Obat Expired</div>
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
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="fa-solid fa-chart-pie text-primary"></i> Distribusi Status Obat
            </div>
            <div class="card-body">
                <div style="height: 220px"><canvas id="statusChart"></canvas></div>
                <div class="chart-legend mt-3">
                    <div class="d-flex justify-content-between">
                        <span><span class="dot" style="background:#198754"></span> Sehat</span>
                        <span class="fw-bold"><?= esc($jumlahSehat) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><span class="dot" style="background:#ffc107"></span> Hampir Expired</span>
                        <span class="fw-bold"><?= esc($jumlahWaspada) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><span class="dot" style="background:#dc3545"></span> Expired</span>
                        <span class="fw-bold"><?= esc($jumlahExpired) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="fa-solid fa-bolt text-warning"></i> Aksi Cepat
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="<?= site_url('obat/create') ?>" class="quick-tile card border-0 shadow-sm text-center p-3 text-decoration-none text-dark h-100">
                            <div class="stat-icon bg-primary-subtle text-primary mx-auto"><i class="fa-solid fa-box"></i></div>
                            <div class="mt-2 small fw-semibold">Rekam Obat</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="<?= site_url('resep/create') ?>" class="quick-tile card border-0 shadow-sm text-center p-3 text-decoration-none text-dark h-100">
                            <div class="stat-icon bg-success-subtle text-success mx-auto"><i class="fa-solid fa-file-prescription"></i></div>
                            <div class="mt-2 small fw-semibold">Buat Resep</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="<?= site_url('obat') ?>" class="quick-tile card border-0 shadow-sm text-center p-3 text-decoration-none text-dark h-100">
                            <div class="stat-icon bg-info-subtle text-info mx-auto"><i class="fa-solid fa-tablets"></i></div>
                            <div class="mt-2 small fw-semibold">Data Obat</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="<?= site_url('resep') ?>" class="quick-tile card border-0 shadow-sm text-center p-3 text-decoration-none text-dark h-100">
                            <div class="stat-icon bg-warning-subtle text-warning mx-auto"><i class="fa-solid fa-clock-rotate-left"></i></div>
                            <div class="mt-2 small fw-semibold">Riwayat Resep</div>
                        </a>
                    </div>
                </div>

                <hr class="my-3">

                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-file-prescription text-success"></i>
                        <span class="fw-semibold">Resep Hari Ini</span>
                    </div>
                    <a href="<?= site_url('resep') ?>" class="btn btn-sm btn-outline-success">Lihat Semua</a>
                </div>
                <ul class="list-group list-group-flush">
                    <?php if (empty($resepHariIni)): ?>
                        <li class="list-group-item text-center text-muted small py-3">Belum ada resep hari ini</li>
                    <?php else: ?>
                        <?php foreach (array_slice($resepHariIni, 0, 3) as $r): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <div class="fw-semibold small"><?= esc($r['nama_pasien']) ?></div>
                                    <div class="text-muted small"><?= esc($r['nomor_resep']) ?></div>
                                </div>
                                <span class="badge text-bg-<?= badge_status_resep($r['status']) ?>"><?= esc($r['status']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100 table-card">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-triangle-exclamation text-warning"></i> Obat Hampir Expired</span>
                <span class="badge text-bg-warning"><?= esc($jumlahWaspada) ?></span>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th>Stok</th>
                            <th>Tgl Expired</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($daftarWaspada)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada obat waspada</td></tr>
                        <?php else: ?>
                            <?php foreach ($daftarWaspada as $o): ?>
                                <?php $st = status_expired($o['tanggal_expired']); ?>
                                <tr>
                                    <td><?= esc($o['nama_obat']) ?></td>
                                    <td><?= esc($o['stok_akhir']) ?></td>
                                    <td><?= esc($o['tanggal_expired']) ?></td>
                                    <td><span class="badge text-bg-<?= $st['badge'] ?>"><?= $st['label'] ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100 table-card">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-circle-xmark text-danger"></i> Obat Expired</span>
                <span class="badge text-bg-danger"><?= esc($jumlahExpired) ?></span>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th>Stok</th>
                            <th>Tgl Expired</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($daftarExpired)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada obat expired</td></tr>
                        <?php else: ?>
                            <?php foreach ($daftarExpired as $o): ?>
                                <?php $st = status_expired($o['tanggal_expired']); ?>
                                <tr>
                                    <td><?= esc($o['nama_obat']) ?></td>
                                    <td><?= esc($o['stok_akhir']) ?></td>
                                    <td><?= esc($o['tanggal_expired']) ?></td>
                                    <td><span class="badge text-bg-<?= $st['badge'] ?>"><?= $st['label'] ?></span></td>
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
        <span><i class="fa-solid fa-file-prescription text-success"></i> Resep Hari Ini</span>
        <span class="badge text-bg-success"><?= esc($jumlahResepHariIni) ?></span>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>No. Resep</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Status</th>
                    <th>Apoteker</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($resepHariIni)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada resep hari ini</td></tr>
                <?php else: ?>
                    <?php foreach ($resepHariIni as $r): ?>
                        <tr>
                            <td><?= esc($r['nomor_resep']) ?></td>
                            <td><?= esc($r['nama_pasien']) ?></td>
                            <td><?= esc($r['nama_dokter']) ?></td>
                            <td><span class="badge text-bg-<?= badge_status_resep($r['status']) ?>"><?= esc($r['status']) ?></span></td>
                            <td><?= esc($r['nama_apoteker']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$inlineScript = "
const ctx = document.getElementById('statusChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Sehat', 'Hampir Expired', 'Expired'],
        datasets: [{
            data: [{$jumlahSehat}, {$jumlahWaspada}, {$jumlahExpired}],
            backgroundColor: ['#198754', '#ffc107', '#dc3545'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '62%',
        plugins: { legend: { display: false } }
    }
});
";
?>

<?= view('layouts/footer', ['chartJs' => true, 'inlineScript' => $inlineScript]) ?>
