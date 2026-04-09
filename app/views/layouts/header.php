<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title']; ?> | Perpustakaan Digital</title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/public/css/style.css">
</head>
<body>
<?php $role = $data['user']['role'] ?? 'user'; ?>
<?php if($role === 'admin'): ?>
    <header class="navbar">
        <div class="container">
            <a href="<?= BASEURL; ?>/admin" class="navbar-brand">
                <span class="brand-icon">📚</span>
                Perpus<span class="green">Digital</span>
            </a>
            <ul class="navbar-nav">
                <li><a href="<?= BASEURL; ?>/admin" class="nav-link <?= ($data['page'] ?? '') == 'dashboard' ? 'active' : ''; ?>">📊 Dashboard</a></li>
                <li><a href="<?= BASEURL; ?>/admin/categories" class="nav-link <?= ($data['page'] ?? '') == 'categories' ? 'active' : ''; ?>">🏷️ Kategori</a></li>
                <li><a href="<?= BASEURL; ?>/admin/books" class="nav-link <?= ($data['page'] ?? '') == 'books' ? 'active' : ''; ?>">📕 Buku</a></li>
                <li><a href="<?= BASEURL; ?>/admin/members" class="nav-link <?= ($data['page'] ?? '') == 'members' ? 'active' : ''; ?>">👥 Anggota</a></li>
                <li><a href="<?= BASEURL; ?>/admin/loans" class="nav-link <?= ($data['page'] ?? '') == 'loans' ? 'active' : ''; ?>">🔄 Peminjaman</a></li>
                <li><a href="<?= BASEURL; ?>/auth/logout" class="nav-link logout-link">🚪 Logout</a></li>
            </ul>
        </div>
    </header>
<?php else: ?>
    <header class="navbar">
        <div class="container">
            <a href="<?= BASEURL; ?>/user" class="navbar-brand">
                <span class="brand-icon">📚</span>
                Perpus<span class="green">Digital</span>
            </a>
            <ul class="navbar-nav">
                <li><a href="<?= BASEURL; ?>/user" class="nav-link <?= ($data['page'] ?? '') == 'dashboard' ? 'active' : ''; ?>">🏠 Beranda</a></li>
                <li><a href="<?= BASEURL; ?>/user/books" class="nav-link <?= ($data['page'] ?? '') == 'books' ? 'active' : ''; ?>">📚 Jelajahi Buku</a></li>
                <li><a href="<?= BASEURL; ?>/user/loans" class="nav-link <?= ($data['page'] ?? '') == 'loans' ? 'active' : ''; ?>">📋 Peminjaman Saya</a></li>
                <li><a href="<?= BASEURL; ?>/user/profile" class="nav-link <?= ($data['page'] ?? '') == 'profile' ? 'active' : ''; ?>">👤 Profil</a></li>
                <li><a href="<?= BASEURL; ?>/auth/logout" class="nav-link logout-link">🚪 Logout</a></li>
            </ul>
        </div>
    </header>
<?php endif; ?>

    <main class="content-area">
        <div class="container">

            <?php if(isset($_SESSION['flash'])): ?>
                <div class="alert alert-danger">⚠️ <?= $_SESSION['flash']; unset($_SESSION['flash']); ?></div>
            <?php endif; ?>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success">✅ <?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
