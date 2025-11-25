<?php
// Include koneksi
include __DIR__ . "/../../../includes/koneksi.php";

// folder foto bukti
define('FOTO_DIR', __DIR__ . '/fototransaksi/');
define('FOTO_WEB_PATH', 'views/user/transaksi/fototransaksi/');

// Query perbaikan
$query = mysqli_query($koneksi, "
    SELECT t.*, 
           p.nama_penerima, 
           b.nama_bantuan, 
           b.nominal AS nominal_bantuan,
           u.nama_user AS nama_admin
    FROM transaksi t
    JOIN penerima p ON t.id_penerima = p.id_penerima
    JOIN bantuan b ON t.id_bantuan = b.id_bantuan
    JOIN user u ON t.id_admin = u.id_user
    ORDER BY t.id_transaksi DESC
");
?>

<style>
    .table img {
        width: 70px;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .btn-group-sm .btn {
        margin-right: 4px;
        margin-bottom: 4px;
    }
</style>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Daftar Transaksi</h3>

        <a href="index.php?halaman=tambahtransaksi" 
           class="btn btn-primary btn-sm">
            + Tambah Transaksi
        </a>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th style="width:40px;">No</th>
                    <th>Nama Penerima</th>
                    <th>Nama Bantuan</th>
                    <th>Nominal</th>
                    <th>Admin</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Foto Bukti</th>
                    <th style="width:220px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) : 
                    $fotoFile = $row['foto'] ?? null;
                    $fotoFullPath = $fotoFile ? FOTO_DIR . $fotoFile : "";
                    $fotoWeb = $fotoFile ? FOTO_WEB_PATH . $fotoFile : "";
                ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>

                    <td><?= htmlspecialchars($row['nama_penerima']); ?></td>

                    <td><?= htmlspecialchars($row['nama_bantuan']); ?></td>

                    <td>Rp <?= number_format((float)$row['nominal_bantuan'], 0, ",", "."); ?></td>

                    <td><?= htmlspecialchars($row['nama_admin']); ?></td>

                    <td><?= htmlspecialchars($row['tanggal_pembayaran']); ?></td>

                    <td class="text-center">
                        <?php if ($fotoFile && file_exists($fotoFullPath)) : ?>
                            <img src="<?= htmlspecialchars($fotoWeb); ?>" alt="Bukti">
                        <?php else : ?>
                            <span class="badge bg-secondary">Belum ada</span>
                        <?php endif; ?>
                    </td>

                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="index.php?halaman=edittransaksi&id_transaksi=<?= $row['id_transaksi']; ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <a href="db/dbtransaksi.php?proses=hapus&id_transaksi=<?= $row['id_transaksi']; ?>"
                               onclick="return confirm('Yakin ingin hapus data ini?');"
                               class="btn btn-danger btn-sm">
                               <i class="fas fa-trash"></i> Hapus
                            </a>

                            <a href="index.php?halaman=detailtransaksi&id_transaksi=<?= $row['id_transaksi']; ?>"
                               class="btn btn-info btn-sm">
                               <i class="fas fa-eye"></i> Detail
                            </a>

                            <a href="views/user/transaksi/cetakstruk.php?id_transaksi=<?= $row['id_transaksi']; ?>"
                               target="_blank" class="btn btn-primary btn-sm">
                               <i class="fas fa-print"></i> Cetak
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
