<div class="page-header">
    <div>
        <h1>👤 Profil Saya</h1>
        <p>Lihat dan perbarui informasi akun Anda</p>
    </div>
</div>

<div class="grid-2">
    <!-- Info Profil -->
    <div class="card">
        <div class="card-header">
            <h3>Informasi Akun</h3>
        </div>
        <div class="card-body">
            <div class="profile-card">
                <div class="profile-avatar">👤</div>
                <div class="profile-details">
                    <h2><?= $data['userData']['fullname']; ?></h2>
                    <div class="role">
                        <span class="badge badge-blue">@<?= $data['userData']['username']; ?></span>
                        <span class="badge badge-green">Anggota</span>
                    </div>
                    <p class="text-muted" style="font-size:14px;">Bergabung sejak <?= date('d M Y', strtotime($data['userData']['created_at'])); ?></p>
                </div>
            </div>

            <div class="dashboard-stats" style="grid-template-columns:repeat(2,1fr);margin-top:24px;">
                <div class="stat-card">
                    <div class="stat-icon blue">📚</div>
                    <div class="stat-info">
                        <h3>Total Peminjaman</h3>
                        <div class="value"><?= $data['totalLoans']; ?></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">📖</div>
                    <div class="stat-info">
                        <h3>Sedang Dipinjam</h3>
                        <div class="value"><?= $data['activeLoans']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profil -->
    <div class="card">
        <div class="card-header">
            <h3>✏️ Perbarui Profil</h3>
        </div>
        <div class="card-body">
            <form action="<?= BASEURL; ?>/user/updateProfile" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" value="<?= $data['userData']['username']; ?>" disabled>
                    <small class="text-muted" style="font-size:12px;margin-top:4px;display:block;">Username tidak dapat diubah</small>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="fullname" class="form-control" value="<?= $data['userData']['fullname']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">💾 Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
