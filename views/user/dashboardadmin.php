<?php
require_once __DIR__ . '/../../includes/koneksi.php';

// Hitung statistik
$total_bantuan = $koneksi->query("SELECT COUNT(*) AS jml FROM bantuan")->fetch_assoc()['jml'] ?? 0;
$total_penerima = $koneksi->query("SELECT COUNT(*) AS jml FROM penerima")->fetch_assoc()['jml'] ?? 0;
$total_user = $koneksi->query("SELECT COUNT(*) AS jml FROM user WHERE role = 'petugas'")->fetch_assoc()['jml'] ?? 0;
$total_transaksi = $koneksi->query("SELECT COUNT(*) AS jml FROM transaksi")->fetch_assoc()['jml'] ?? 0;
?>

<div class="container mt-4">
    <h3 class="fw-bold">Dashboard Admin</h3>
    <p class="text-muted">Selamat datang di panel administrator Aplikasi Bantuan Anak Yatim.</p>

    <!-- STATISTIK -->
    <div class="row g-3">

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body">
                    <h1 class="display-6">📦</h1>
                    <h5>Total Bantuan</h5>
                    <h3><?= $total_bantuan ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body">
                    <h1 class="display-6">👥</h1>
                    <h5>Total Penerima</h5>
                    <h3><?= $total_penerima ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-warning text-white">
                <div class="card-body">
                    <h1 class="display-6">🧑‍💼</h1>
                    <h5>Total Petugas</h5>
                    <h3><?= $total_user ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-danger text-white">
                <div class="card-body">
                    <h1 class="display-6">💰</h1>
                    <h5>Total Transaksi</h5>
                    <h3><?= $total_transaksi ?></h3>
                </div>
            </div>
        </div>

    </div>

    <hr class="my-4">

    <!-- MENU UTAMA -->
    <div class="row g-3">

        <div class="col-md-3">
            <a href="?hal=kelolabantuan" class="text-decoration-none">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h1>📦</h1>
                        <h5>Kelola Bantuan</h5>
                        <p class="text-muted">Input, ubah, hapus data bantuan.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="?hal=kelolapenerima" class="text-decoration-none">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h1>👥</h1>
                        <h5>Kelola Penerima</h5>
                        <p class="text-muted">Data anak yatim & keluarga.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="?hal=kelolauser" class="text-decoration-none">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h1>🧑‍💼</h1>
                        <h5>Kelola User & Petugas</h5>
                        <p class="text-muted">Akun admin & petugas.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="?hal=laporan" class="text-decoration-none">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h1>📊</h1>
                        <h5>Laporan</h5>
                        <p class="text-muted">Cetak laporan bantuan.</p>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <hr class="my-4">

    <!-- DATA TERBARU -->
    <h4 class="fw-bold mb-3">Transaksi Terbaru</h4>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Penerima</th>
                        <th>Bantuan</th>
                        <th>Tanggal</th>
                        <th>Petugas</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $q = $koneksi->query("
                        SELECT t.*, p.nama AS penerima, b.nama_bantuan, u.nama AS petugas
                        FROM transaksi t
                        LEFT JOIN penerima p ON t.id_penerima = p.id
                        LEFT JOIN bantuan b ON t.id_bantuan = b.id
                        LEFT JOIN user u ON t.id_petugas = u.id
                        ORDER BY t.id DESC LIMIT 5
                    ");

                    if ($q->num_rows == 0) {
                        echo "<tr><td colspan='5' class='text-center'>Belum ada transaksi.</td></tr>";
                    } else {
                        $no = 1;
                        while ($r = $q->fetch_assoc()) {
                            echo "<tr>
                                <td>{$no}</td>
                                <td>{$r['penerima']}</td>
                                <td>{$r['nama_bantuan']}</td>
                                <td>{$r['tanggal']}</td>
                                <td>{$r['petugas']}</td>
                            </tr>";
                            $no++;
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
