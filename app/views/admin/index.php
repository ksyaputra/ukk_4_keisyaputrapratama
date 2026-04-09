<div class="page-header">
    <div>
        <h1>Dashboard Admin</h1>
        <p>Selamat datang kembali, <strong><?= $data['user']['fullname']; ?></strong> 👋</p>
    </div>
</div>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon blue">📕</div>
        <div class="stat-info">
            <h3>Total Buku</h3>
            <div class="value"><?= $data['totalBooks']; ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">👥</div>
        <div class="stat-info">
            <h3>Anggota Aktif</h3>
            <div class="value"><?= $data['totalMembers']; ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">🔄</div>
        <div class="stat-info">
            <h3>Peminjaman Aktif</h3>
            <div class="value"><?= $data['activeLoans']; ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">💰</div>
        <div class="stat-info">
            <h3>Total Denda</h3>
            <div class="value">Rp <?= number_format($data['totalFines'], 0, ',', '.'); ?></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>📋 Peminjaman Terbaru</h3>
        <a href="<?= BASEURL; ?>/admin/loans" class="btn btn-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body">
        <?php if(empty($data['recentLoans'])): ?>
            <div class="empty-state">
                <div class="icon">📭</div>
                <h3>Belum Ada Data Peminjaman</h3>
                <p>Data peminjaman akan muncul di sini ketika siswa mulai meminjam buku.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tenggat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['recentLoans'] as $loan): ?>
                    <tr>
                        <td><strong><?= $loan['user_name']; ?></strong></td>
                        <td><?= $loan['book_title']; ?></td>
                        <td><?= date('d M Y', strtotime($loan['borrow_date'])); ?></td>
                        <td><?= date('d M Y', strtotime($loan['due_date'])); ?></td>
                        <td>
                            <?php if($loan['status'] == 'borrowed'): ?>
                                <span class="badge badge-blue">📖 Dipinjam</span>
                            <?php elseif($loan['status'] == 'returned'): ?>
                                <span class="badge badge-green">✅ Dikembalikan</span>
                            <?php else: ?>
                                <span class="badge badge-red">⚠️ Terlambat</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
