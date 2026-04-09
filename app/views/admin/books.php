<div class="page-header">
    <div>
        <h1>📕 Kelola Buku</h1>
        <p>Kelola seluruh koleksi buku perpustakaan</p>
    </div>
    <button onclick="document.getElementById('modalTambah').classList.add('active')" class="btn btn-primary">➕ Tambah Buku</button>
</div>

<div class="card">
    <div class="card-header">
        <h3>Daftar Buku (<?= count($data['books']); ?>)</h3>
    </div>
    <div class="card-body">
        <?php if(empty($data['books'])): ?>
            <div class="empty-state">
                <div class="icon">📚</div>
                <h3>Belum Ada Buku</h3>
                <p>Klik tombol "Tambah Buku" untuk menambahkan koleksi pertama.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($data['books'] as $book): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><strong><?= $book['title']; ?></strong></td>
                        <td><?= $book['author']; ?></td>
                        <td><span class="badge badge-blue"><?= $book['category_name'] ?? 'Tanpa Kategori'; ?></span></td>
                        <td><?= $book['publish_year']; ?></td>
                        <td>
                            <?php if($book['quantity'] > 0): ?>
                                <span class="badge badge-green"><?= $book['quantity']; ?> tersedia</span>
                            <?php else: ?>
                                <span class="badge badge-red">Habis</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-btns">
                                <button onclick="openEditBook(<?= htmlspecialchars(json_encode($book)); ?>)" class="btn btn-outline btn-sm">✏️ Edit</button>
                                <a href="<?= BASEURL; ?>/admin/deleteBook/<?= $book['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus buku ini?')">🗑️</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Tambah Buku -->
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <h3>➕ Tambah Buku Baru</h3>
            <button class="modal-close" onclick="document.getElementById('modalTambah').classList.remove('active')">&times;</button>
        </div>
        <form action="<?= BASEURL; ?>/admin/addBook" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="title" class="form-control" placeholder="Masukkan judul buku" required>
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="author" class="form-control" placeholder="Nama penulis" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach($data['categories'] as $cat): ?>
                            <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="publish_year" class="form-control" placeholder="Contoh: 2023" required>
                </div>
                <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="number" name="quantity" class="form-control" placeholder="Jumlah buku" min="0" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('modalTambah').classList.remove('active')">Batal</button>
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Buku -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            <h3>✏️ Edit Buku</h3>
            <button class="modal-close" onclick="document.getElementById('modalEdit').classList.remove('active')">&times;</button>
        </div>
        <form id="formEditBook" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="title" id="editTitle" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="author" id="editAuthor" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category_id" id="editCategory" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach($data['categories'] as $cat): ?>
                            <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="publish_year" id="editYear" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="number" name="quantity" id="editQuantity" class="form-control" min="0" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('modalEdit').classList.remove('active')">Batal</button>
                <button type="submit" class="btn btn-success">💾 Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditBook(book) {
    document.getElementById('formEditBook').action = '<?= BASEURL; ?>/admin/editBook/' + book.id;
    document.getElementById('editTitle').value = book.title;
    document.getElementById('editAuthor').value = book.author;
    document.getElementById('editCategory').value = book.category_id;
    document.getElementById('editYear').value = book.publish_year;
    document.getElementById('editQuantity').value = book.quantity;
    document.getElementById('modalEdit').classList.add('active');
}
</script>
