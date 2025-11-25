<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil semua user
$sql = "SELECT * FROM user ORDER BY id_user DESC";
$result = mysqli_query($koneksi, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php include PAGES_PATH . 'user/header.php'; ?>
<?php include PAGES_PATH . 'user/navbar.php'; ?>
<?php include PAGES_PATH . 'user/sidebar.php'; ?>

<div class="content">
    <section class="content-header">
        <h1>Daftar User</h1>
    </section>

    <section class="content">

        <!-- Tombol Tambah User -->
        <a href="<?= BASE_URL ?>dashboard.php?hal=user/tambahuser"
           class="btn btn-primary mb-3">
           Tambah User
        </a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="40">ID</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Foto</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id_user'] ?></td>
                    <td><?= htmlspecialchars($u['nama_user']) ?></td>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['role']) ?></td>
                    <td>
                        <?php if ($u['status'] == 'aktif'): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if (!empty($u['foto'])): ?>
                            <img src="<?= BASE_URL ?>uploads/user/<?= $u['foto'] ?>"
                                 width="50" style="border-radius:4px;">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="<?= BASE_URL ?>dashboard.php?hal=user/edituser&id=<?= $u['id_user'] ?>"
                           class="btn btn-sm btn-warning">Edit</a>

                        <a href="<?= BASE_URL ?>views/user/prosesuser.php?aksi=hapus&id=<?= $u['id_user'] ?>"
                           onclick="return confirm('Yakin hapus user ini?')"
                           class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>

    </section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>
