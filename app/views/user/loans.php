<div class="page-header">
    <div>
        <h1>📋 Peminjaman Saya</h1>
        <p>Riwayat semua peminjaman buku Anda</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Daftar Peminjaman (<?= count($data['loans']); ?>)</h3>
    </div>
    <div class="card-body">
        <?php if(empty($data['loans'])): ?>
            <div class="empty-state">
                <div class="icon">📋</div>
                <h3>Belum Ada Peminjaman</h3>
                <p>Anda belum pernah meminjam buku. Mulai pinjam sekarang!</p>
                <a href="<?= BASEURL; ?>/user/books" class="btn btn-primary mt-3">📚 Jelajahi Buku</a>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Tgl Pinjam</th>
                        <th>Tenggat</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($data['loans'] as $loan): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><strong><?= $loan['book_title']; ?></strong></td>
                        <td><?= $loan['book_author']; ?></td>
                        <td><?= date('d M Y', strtotime($loan['borrow_date'])); ?></td>
                        <td><?= date('d M Y', strtotime($loan['due_date'])); ?></td>
                        <td><?= $loan['return_date'] ? date('d M Y', strtotime($loan['return_date'])) : '-'; ?></td>
                        <td>
                            <?php if($loan['status'] == 'borrowed'): 
                                $today = strtotime(date('Y-m-d'));
                                $due = strtotime($loan['due_date']);
                                $diff = ($due - $today) / 86400;
                            ?>
                                <?php if($diff < 0): ?>
                                    <span class="badge badge-red">⚠️ Terlambat <?= abs($diff); ?> hari</span>
                                <?php elseif($diff <= 2): ?>
                                    <span class="badge badge-orange">⏰ <?= $diff; ?> hari lagi</span>
                                <?php else: ?>
                                    <span class="badge badge-blue">📖 Dipinjam</span>
                                <?php endif; ?>
                            <?php elseif($loan['status'] == 'returned'): ?>
                                <span class="badge badge-green">✅ Dikembalikan</span>
                            <?php else: ?>
                                <span class="badge badge-red">⚠️ Terlambat</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($loan['fine_amount'] > 0): ?>
                                <span class="badge badge-orange">Rp <?= number_format($loan['fine_amount'], 0, ',', '.'); ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($loan['status'] == 'borrowed'): ?>
                                <a href="<?= BASEURL; ?>/user/returnBook/<?= $loan['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Kembalikan buku ini?')">📥 Kembalikan</a>
                            <?php else: ?>
                                <span class="text-muted">Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
