<?php
$user = $user ?? null;
$isEdit = $user !== null;
?>
<?= view('layouts/header', ['title' => $isEdit ? 'Edit User' : 'Tambah User', 'active' => 'users']) ?>

<div class="page-header">
    <h5 class="mb-0"><?= $isEdit ? 'Edit User' : 'Tambah User' ?></h5>
    <a href="<?= site_url('users') ?>" class="btn btn-outline-secondary">
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
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" required
                           value="<?= esc($isEdit ? $user['username'] : old('username')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        Password <span class="text-danger"><?= $isEdit ? '(kosongkan jika tidak diubah)' : '*' ?></span>
                    </label>
                    <input type="password" name="password" class="form-control" <?= $isEdit ? '' : 'required' ?>>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" <?= ($isEdit ? $user['role'] : old('role')) === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="apoteker" <?= ($isEdit ? $user['role'] : (old('role') ?: 'apoteker')) === 'apoteker' ? 'selected' : '' ?>>Apoteker</option>
                        <option value="resepsionis" <?= ($isEdit ? $user['role'] : old('role')) === 'resepsionis' ? 'selected' : '' ?>>Resepsionis</option>
                    </select>
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

<?= view('layouts/footer') ?>
