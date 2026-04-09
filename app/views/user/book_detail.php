<div class="page-header">
    <div>
        <h1>📖 <?= $data['book']['title']; ?></h1>
        <p><a href="<?= BASEURL; ?>/user/books">← Kembali ke Daftar Buku</a></p>
    </div>
</div>

<div class="grid-2">
    <!-- Info Buku -->
    <div class="card">
        <div class="card-header">
            <h3>Informasi Buku</h3>
        </div>
        <div class="card-body">
            <div style="text-align:center;padding:30px;background:var(--primary-blue-light);border-radius:var(--radius-md);margin-bottom:24px;">
                <span style="font-size:80px;">📖</span>
            </div>

            <table>
                <tr><td><strong>Judul</strong></td><td><?= $data['book']['title']; ?></td></tr>
                <tr><td><strong>Penulis</strong></td><td><?= $data['book']['author']; ?></td></tr>
                <tr><td><strong>Kategori</strong></td><td><span class="badge badge-blue"><?= $data['book']['category_name'] ?? 'Tanpa Kategori'; ?></span></td></tr>
                <tr><td><strong>Tahun Terbit</strong></td><td><?= $data['book']['publish_year']; ?></td></tr>
                <tr>
                    <td><strong>Stok Tersedia</strong></td>
                    <td>
                        <?php if($data['book']['quantity'] > 0): ?>
                            <span class="badge badge-green"><?= $data['book']['quantity']; ?> tersedia</span>
                        <?php else: ?>
                            <span class="badge badge-red">Stok Habis</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Rating</strong></td>
                    <td>
                        <div class="stars">
                            <?php 
                            $avg = round($data['rating']['avg_rating']);
                            for($i = 1; $i <= 5; $i++): ?>
                                <span class="star <?= $i <= $avg ? '' : 'empty'; ?>">★</span>
                            <?php endfor; ?>
                        </div>
                        <span class="text-muted" style="font-size:13px;margin-left:8px;">
                            (<?= number_format($data['rating']['avg_rating'], 1); ?> / 5 dari <?= $data['rating']['total']; ?> ulasan)
                        </span>
                    </td>
                </tr>
            </table>

            <div style="margin-top:24px;">
                <?php if($data['activeLoan']): ?>
                    <div class="alert alert-success" style="margin-bottom:0;">📖 Anda sedang meminjam buku ini</div>
                <?php elseif($data['book']['quantity'] > 0): ?>
                    <a href="<?= BASEURL; ?>/user/borrow/<?= $data['book']['id']; ?>" class="btn btn-primary btn-block" onclick="return confirm('Pinjam buku ini? Tenggat pengembalian 7 hari dari sekarang.')">📥 Pinjam Buku Ini</a>
                <?php else: ?>
                    <button class="btn btn-outline btn-block" disabled>❌ Stok Tidak Tersedia</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Ulasan -->
    <div class="card">
        <div class="card-header">
            <h3>💬 Ulasan & Rating</h3>
        </div>
        <div class="card-body">
            <?php if(!$data['hasReviewed']): ?>
                <form action="<?= BASEURL; ?>/user/addReview/<?= $data['book']['id']; ?>" method="POST" style="margin-bottom:28px;padding-bottom:28px;border-bottom:1px solid var(--border-color);">
                    <div class="form-group">
                        <label>Beri Rating</label>
                        <select name="rating" class="form-control" required>
                            <option value="5">⭐⭐⭐⭐⭐ Sangat Bagus (5)</option>
                            <option value="4">⭐⭐⭐⭐ Bagus (4)</option>
                            <option value="3">⭐⭐⭐ Cukup (3)</option>
                            <option value="2">⭐⭐ Kurang (2)</option>
                            <option value="1">⭐ Buruk (1)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Komentar</label>
                        <textarea name="comment" class="form-control" placeholder="Tulis kesan Anda tentang buku ini..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">📝 Kirim Ulasan</button>
                </form>
            <?php endif; ?>

            <?php if(empty($data['reviews'])): ?>
                <div class="empty-state">
                    <div class="icon">💬</div>
                    <h3>Belum Ada Ulasan</h3>
                    <p>Jadilah yang pertama memberikan ulasan!</p>
                </div>
            <?php else: ?>
                <?php foreach($data['reviews'] as $review): ?>
                <div style="padding:16px 0;border-bottom:1px solid var(--border-light);">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                        <strong><?= $review['user_name']; ?></strong>
                        <span class="text-muted" style="font-size:12px;"><?= date('d M Y', strtotime($review['created_at'])); ?></span>
                    </div>
                    <div class="stars" style="margin-bottom:8px;">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <span class="star <?= $i <= $review['rating'] ? '' : 'empty'; ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <p style="color:var(--text-medium);font-size:14px;"><?= htmlspecialchars($review['comment']); ?></p>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
