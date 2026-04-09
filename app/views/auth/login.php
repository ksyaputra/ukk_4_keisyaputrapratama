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
            <div class="auth-logo">📚</div>
            <h2 class="auth-title">Perpustakaan <span class="green">Digital</span></h2>
            <p class="auth-subtitle">Masuk ke akun Anda untuk melanjutkan</p>
            
            <?php if(isset($_SESSION['flash'])): ?>
                <div class="alert alert-danger">
                    ⚠️ <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    ✅ <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/auth/login" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">🔑 Masuk</button>
            </form>
            
            <div class="text-center mt-3">
                <p class="text-muted">Belum punya akun? <a href="<?= BASEURL; ?>/auth/register"><strong>Daftar Sekarang</strong></a></p>
            </div>
        </div>
    </div>
</body>
</html>
