<div class="page-header">
    <div>
        <h1>🔄 Kelola Peminjaman</h1>
        <p>Pantau seluruh transaksi peminjaman dan pengembalian buku</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Riwayat Peminjaman (<?= count($data['loans']); ?>)</h3>
    </div>
    <div class="card-body">
        <?php if(empty($data['loans'])): ?>
            <div class="empty-state">
                <div class="icon">📋</div>
                <h3>Belum Ada Peminjaman</h3>
                <p>Data peminjaman akan muncul ketika siswa mulai meminjam buku.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Judul Buku</th>
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
                        <td><strong><?= $loan['user_name']; ?></strong></td>
                        <td><?= $loan['book_title']; ?></td>
                        <td><?= date('d M Y', strtotime($loan['borrow_date'])); ?></td>
                        <td><?= date('d M Y', strtotime($loan['due_date'])); ?></td>
                        <td><?= $loan['return_date'] ? date('d M Y', strtotime($loan['return_date'])) : '-'; ?></td>
                        <td>
                            <?php if($loan['status'] == 'borrowed'): ?>
                                <span class="badge badge-blue">📖 Dipinjam</span>
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
                                <a href="<?= BASEURL; ?>/admin/returnLoan/<?= $loan['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi pengembalian buku ini?')">📥 Kembalikan</a>
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
