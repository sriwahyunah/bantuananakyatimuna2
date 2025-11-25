<?php
// ============================================================
// Dashboard Penerima Bantuan
// Mengikuti pola dashboard peminjam (plug-and-play)
// ============================================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// ===============================
// Cek login penerima
// ===============================
if (!isset($_SESSION['id_penerima'])) {
    header("Location: " . BASE_URL . "?hal=otentikasiuser/loginpenerima");
    exit;
}

$id_penerima = $_SESSION['id_penerima'];

// ===============================
// Ambil data penerima
// ===============================
$stmt = $koneksi->prepare("SELECT * FROM penerima WHERE id_penerima = ? LIMIT 1");
$stmt->bind_param("i", $id_penerima);
$stmt->execute();
$penerima = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$penerima) {
    die("Data penerima tidak ditemukan.");
}

// ===============================
// Contoh Statistik → Bisa kamu sesuaikan
// ===============================

// Total bantuan diterima
$stmt1 = $koneksi->prepare("
    SELECT COUNT(*) AS total_bantuan
    FROM bantuan
    WHERE id_penerima = ?
");
$stmt1->bind_param("i", $id_penerima);
$stmt1->execute();
$totalBantuan = $stmt1->get_result()->fetch_assoc()['total_bantuan'] ?? 0;
$stmt1->close();

// Bantuan terbaru
$stmt2 = $koneksi->prepare("
    SELECT b.nama_bantuan, b.tanggal
    FROM bantuan b
    WHERE b.id_penerima = ?
    ORDER BY b.tanggal DESC
    LIMIT 5
");
$stmt2->bind_param("i", $id_penerima);
$stmt2->execute();
$latestBantuan = $stmt2->get_result();
$stmt2->close();

// ===============================
// Include layout
// ===============================
include PAGES_PATH . 'penerima/header.php';
include PAGES_PATH . 'penerima/navbar.php';
?>

<div class="container mt-4">
    <h2>Selamat Datang, <?= htmlspecialchars($penerima['nama_penerima']) ?>!</h2>
    <p>Status akun: <strong><?= htmlspecialchars($penerima['status'] ?? '-') ?></strong></p>

    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Bantuan Diterima</h5>
                    <p class="display-4"><?= $totalBantuan ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Kelas</h5>
                    <p class="display-4"><?= htmlspecialchars($penerima['kelas']) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Pendapatan Orang Tua</h5>
                    <p class="display-6">Rp <?= number_format($penerima['pendapatan_orang_tua'], 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bantuan Terbaru -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h4>Bantuan Terbaru</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Bantuan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($latestBantuan && $latestBantuan->num_rows > 0): ?>
                            <?php $no = 1; while ($row = $latestBantuan->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['nama_bantuan']) ?></td>
                                    <td><?= htmlspecialchars($row['tanggal']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center">Belum ada bantuan</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include PAGES_PATH . 'penerima/footer.php'; ?>
