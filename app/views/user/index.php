<div class="page-header">
    <div>
        <h1>Selamat Datang, <?= $data['user']['fullname']; ?>! 👋</h1>
        <p>Jelajahi koleksi buku dan kelola peminjaman Anda</p>
    </div>
    <a href="<?= BASEURL; ?>/user/books" class="btn btn-primary">📚 Jelajahi Buku</a>
</div>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon blue">📚</div>
        <div class="stat-info">
            <h3>Total Koleksi</h3>
            <div class="value"><?= $data['totalBooks']; ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">📖</div>
        <div class="stat-info">
            <h3>Sedang Dipinjam</h3>
            <div class="value"><?= $data['myActiveCount']; ?></div>
        </div>
    </div>
</div>

<?php if(!empty($data['activeLoans'])): ?>
<div class="card">
    <div class="card-header">
        <h3>📖 Buku yang Sedang Dipinjam</h3>
        <a href="<?= BASEURL; ?>/user/loans" class="btn btn-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Tgl Pinjam</th>
                    <th>Tenggat</th>
                    <th>Sisa Hari</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['activeLoans'] as $loan): 
                    $today = strtotime(date('Y-m-d'));
                    $due = strtotime($loan['due_date']);
                    $diff = ($due - $today) / 86400;
                ?>
                <tr>
                    <td><strong><?= $loan['book_title']; ?></strong></td>
                    <td><?= $loan['book_author']; ?></td>
                    <td><?= date('d M Y', strtotime($loan['borrow_date'])); ?></td>
                    <td><?= date('d M Y', $due); ?></td>
                    <td>
                        <?php if($diff < 0): ?>
                            <span class="badge badge-red">Terlambat <?= abs($diff); ?> hari</span>
                        <?php elseif($diff <= 2): ?>
                            <span class="badge badge-orange"><?= $diff; ?> hari lagi</span>
                        <?php else: ?>
                            <span class="badge badge-green"><?= $diff; ?> hari lagi</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= BASEURL; ?>/user/returnBook/<?= $loan['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Kembalikan buku ini?')">📥 Kembalikan</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body">
        <div class="empty-state">
            <div class="icon">📭</div>
            <h3>Belum Ada Peminjaman Aktif</h3>
            <p>Mulai jelajahi koleksi buku dan pinjam buku favorit Anda!</p>
            <a href="<?= BASEURL; ?>/user/books" class="btn btn-primary mt-3">📚 Jelajahi Buku</a>
        </div>
    </div>
</div>
<?php endif; ?>
