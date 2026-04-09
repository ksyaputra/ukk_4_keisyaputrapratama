<div class="page-header">
    <div>
        <h1>🏷️ Kelola Kategori</h1>
        <p>Tambah, edit, atau hapus kategori buku</p>
    </div>
</div>

<div class="grid-2">
    <!-- Form Tambah Kategori -->
    <div class="card">
        <div class="card-header">
            <h3>Tambah Kategori Baru</h3>
        </div>
        <div class="card-body">
            <form action="<?= BASEURL; ?>/admin/addCategory" method="POST">
                <div class="form-group">
                    <label for="name">Nama Kategori</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Fiksi, Sains, Sejarah" required>
                </div>
                <button type="submit" class="btn btn-primary">➕ Tambah Kategori</button>
            </form>
        </div>
    </div>

    <!-- Daftar Kategori -->
    <div class="card">
        <div class="card-header">
            <h3>Daftar Kategori (<?= count($data['categories']); ?>)</h3>
        </div>
        <div class="card-body">
            <?php if(empty($data['categories'])): ?>
                <div class="empty-state">
                    <div class="icon">🏷️</div>
                    <h3>Belum Ada Kategori</h3>
                    <p>Tambahkan kategori pertama untuk mengelompokkan buku.</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($data['categories'] as $cat): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= $cat['name']; ?></strong></td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?= BASEURL; ?>/admin/deleteCategory/<?= $cat['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">🗑️ Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
