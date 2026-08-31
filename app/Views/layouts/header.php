<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Aplikasi Rekam Obat & Resep') ?> | Klinik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: linear-gradient(180deg, #0b3d91, #082c6b);
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }
        .sidebar .brand {
            color: #fff;
            font-weight: 600;
            font-size: 1.05rem;
            padding: 18px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .25);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .sidebar .brand-logo {
            width: 36px;
            height: 36px;
            object-fit: contain;
            border-radius: 6px;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, .85);
            padding: 12px 20px;
            border-radius: 0;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, .14);
        }
        .sidebar .nav-link.active {
            color: #0b3d91;
            background-color: #fff;
            font-weight: 600;
        }
        .sidebar .nav-link i {
            width: 22px;
        }
        .main {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar-app {
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
        }
        .content {
            padding: 24px;
            flex: 1;
        }
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .3s;
                z-index: 1040;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <a href="<?= site_url('dashboard') ?>" class="brand">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" class="brand-logo">
            <span>Klinik Al-Abina</span>
        </a>
        <nav class="nav flex-column mt-2">
            <?php if (session()->get('role') === 'resepsionis'): ?>
            <a class="nav-link <?= ($active ?? '') === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('resepsionis') ?>">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a class="nav-link <?= ($active ?? '') === 'pasien' ? 'active' : '' ?>" href="<?= site_url('resepsionis/pasien') ?>">
                <i class="fa-solid fa-user-injured"></i> Data Pasien
            </a>
            <a class="nav-link <?= ($active ?? '') === 'resep' ? 'active' : '' ?>" href="<?= site_url('resepsionis/resep') ?>">
                <i class="fa-solid fa-file-prescription"></i> Resep Pasien
            </a>
            <?php else: ?>
            <a class="nav-link <?= ($active ?? '') === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a class="nav-link <?= ($active ?? '') === 'obat' ? 'active' : '' ?>" href="<?= site_url('obat') ?>">
                <i class="fa-solid fa-tablets"></i> Rekam Obat
            </a>
            <a class="nav-link <?= ($active ?? '') === 'resep' ? 'active' : '' ?>" href="<?= site_url('resep') ?>">
                <i class="fa-solid fa-file-prescription"></i> Rekam Resep
            </a>
            <?php if (session()->get('role') === 'admin'): ?>
            <a class="nav-link <?= ($active ?? '') === 'users' ? 'active' : '' ?>" href="<?= site_url('users') ?>">
                <i class="fa-solid fa-users"></i> Data User
            </a>
            <?php endif; ?>
            <?php endif; ?>
        </nav>
    </aside>

    <!-- CONTENT -->
    <div class="main">
        <nav class="navbar navbar-app px-3">
            <button class="btn btn-outline-secondary d-md-none" type="button" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="fa-solid fa-bars"></i>
            </button>
            <span class="navbar-text fw-semibold"><?= esc($title ?? '') ?></span>
            <div class="d-flex align-items-center gap-2">
                <?php
                $roleBadgeClass = match(session()->get('role')) {
                    'admin' => 'danger',
                    'apoteker' => 'success',
                    'resepsionis' => 'primary',
                    default => 'secondary',
                };
                ?>
                <span class="badge text-bg-<?= $roleBadgeClass ?>">
                    <?= ucfirst(session()->get('role')) ?>
                </span>
                <span class="fw-semibold"><?= esc(session()->get('username')) ?></span>
                <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-danger">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </nav>

        <main class="content">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
