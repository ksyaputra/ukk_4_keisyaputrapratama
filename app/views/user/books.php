<div class="page-header">
    <div>
        <h1>📚 Jelajahi Buku</h1>
        <p>Temukan buku favorit Anda dari koleksi perpustakaan kami</p>
    </div>
    <div class="search-box">
        <span class="search-icon">🔍</span>
        <form method="GET" action="<?= BASEURL; ?>/user/books">
            <input type="text" name="search" placeholder="Cari judul atau penulis..." value="<?= $data['keyword'] ?? ''; ?>">
        </form>
    </div>
</div>

<?php if(!empty($data['keyword'])): ?>
    <div class="alert alert-success">
        🔍 Menampilkan hasil pencarian untuk: <strong>"<?= htmlspecialchars($data['keyword']); ?>"</strong> — <?= count($data['books']); ?> buku ditemukan
        <a href="<?= BASEURL; ?>/user/books" style="margin-left:auto;">✖ Reset</a>
    </div>
<?php endif; ?>

<?php if(empty($data['books'])): ?>
    <div class="card">
        <div class="card-body">
            <div class="empty-state">
                <div class="icon">📚</div>
                <h3>Tidak Ada Buku Ditemukan</h3>
                <p>Coba gunakan kata kunci pencarian yang berbeda.</p>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="book-grid">
        <?php foreach($data['books'] as $book): ?>
        <div class="book-card">
            <div class="book-cover">
                📖
                <?php if($book['category_name']): ?>
                    <span class="category-tag"><?= $book['category_name']; ?></span>
                <?php endif; ?>
            </div>
            <div class="book-info">
                <h4><?= $book['title']; ?></h4>
                <p class="author">oleh <?= $book['author']; ?> · <?= $book['publish_year']; ?></p>
                <div class="book-meta">
                    <?php if($book['quantity'] > 0): ?>
                        <span class="stock available">✅ <?= $book['quantity']; ?> tersedia</span>
                    <?php else: ?>
                        <span class="stock empty">❌ Stok habis</span>
                    <?php endif; ?>
                    <a href="<?= BASEURL; ?>/user/bookDetail/<?= $book['id']; ?>" class="btn btn-primary btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
