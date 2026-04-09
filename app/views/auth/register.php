<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title']; ?></title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/public/css/style.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo" style="background-color: var(--primary-green);">📝</div>
            <h2 class="auth-title">Daftar <span class="green">Akun Baru</span></h2>
            <p class="auth-subtitle">Bergabunglah sebagai anggota perpustakaan</p>
            
            <?php if(isset($_SESSION['flash'])): ?>
                <div class="alert alert-danger">
                    ⚠️ <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/auth/register" method="POST">
                <div class="form-group">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Buat username" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Buat password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Ulangi password" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">📝 Daftar Sekarang</button>
            </form>
            
            <div class="text-center mt-3">
                <p class="text-muted">Sudah punya akun? <a href="<?= BASEURL; ?>/auth"><strong>Masuk di sini</strong></a></p>
            </div>
        </div>
    </div>
</body>
</html>
