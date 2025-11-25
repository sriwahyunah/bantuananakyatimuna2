<?php
// Koneksi database (sesuaikan)
include __DIR__ . "/../../../includes/koneksi.php";


?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Bantuan</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }

        .table thead th {
            text-align: center;
        }

        .btn-sm {
            padding: 4px 10px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Data Bantuan</h4>
            </div>

            <div class="card-body">

                <a href="?hal=bantuan/tambah" class="btn btn-success mb-3">
                    ➕ Tambah Bantuan
                </a>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Bantuan</th>
                                <th>Nominal (Rp)</th>
                                <th>Keterangan</th>
                                <th width="150px">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            $data = mysqli_query($koneksi, "SELECT * FROM bantuan");

                            if (mysqli_num_rows($data) == 0) {
                            ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        <em>Belum ada data bantuan.</em>
                                    </td>
                                </tr>
                            <?php
                            }

                            while ($row = mysqli_fetch_array($data)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama_bantuan']); ?></td>
                                    <td>Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                                    <td><?= htmlspecialchars($row['keterangan']); ?></td>
                                    <td class="text-center">

                                    <td class="text-center">

                                    <td class="text-center">

                                    <td class="text-center">

                                        <!-- BTN EDIT -->
                                        <a href="?hal=bantuan/editbantuan&id=<?= $row['id']; ?>"
                                            class="btn btn-warning btn-sm">
                                            ✏ Edit
                                        </a>

                                        <!-- BTN HAPUS -->
                                        <a href="?hal=bantuan/hapusbantuan&id=<?= $row['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            🗑 Hapuss
                                        </a>

                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer text-muted text-sm">
                Data bantuan yang tersedia dalam sistem.
            </div>
        </div>
        </section>