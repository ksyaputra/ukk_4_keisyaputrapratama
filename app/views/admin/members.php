<div class="page-header">
    <div>
        <h1>👥 Kelola Anggota</h1>
        <p>Daftar semua anggota perpustakaan yang terdaftar</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Daftar Anggota (<?= count($data['members']); ?>)</h3>
    </div>
    <div class="card-body">
        <?php if(empty($data['members'])): ?>
            <div class="empty-state">
                <div class="icon">👥</div>
                <h3>Belum Ada Anggota</h3>
                <p>Anggota akan muncul setelah siswa mendaftar akun.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Avatar</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Terdaftar Sejak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($data['members'] as $member): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <div style="width:40px;height:40px;border-radius:8px;background:var(--primary-blue-light);display:flex;align-items:center;justify-content:center;font-size:18px;">👤</div>
                        </td>
                        <td><strong><?= $member['fullname']; ?></strong></td>
                        <td><span class="badge badge-blue">@<?= $member['username']; ?></span></td>
                        <td><?= date('d M Y', strtotime($member['created_at'])); ?></td>
                        <td>
                            <a href="<?= BASEURL; ?>/admin/deleteMember/<?= $member['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota ini? Semua data peminjaman anggota ini juga akan terhapus.')">🗑️ Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
