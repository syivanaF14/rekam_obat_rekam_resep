<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Aplikasi Rekam Obat & Resep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
        }
        .card-login {
            width: 100%;
            max-width: 420px;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }
        .login-logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
        }
    </style>
</head>
<body>
<div class="card card-login">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" class="login-logo">
            <h4 class="mt-3 mb-0">Aplikasi Rekam Obat</h4>
            <small class="text-muted">Rekam Obat &amp; Rekam Resep</small>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger py-2"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success py-2"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form action="<?= site_url('login') ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="username" class="form-control"
                           value="<?= old('username') ?>" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-2">Login</button>
        </form>
    </div>
</div>
</body>
</html>
