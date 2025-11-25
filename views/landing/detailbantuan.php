<?php
// views/landing/detilbantuan.php
// Halaman: Detil Program Bantuan Anak Yatim

require_once __DIR__ . '/../../includes/fungsivalidasi.php';
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';

// helper base_url
function base_url($path = '') {
    if (defined('BASE_URL') && !empty(BASE_URL)) {
        return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
    }
    return ltrim($path, '/');
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { include __DIR__ . '/404.php'; exit; }

// Ambil data bantuan
$bantuan = null;
$sql = "SELECT * FROM bantuan WHERE id_bantuan = ? LIMIT 1";
if ($stmt = mysqli_prepare($koneksi, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $bantuan = $res->fetch_assoc();
    mysqli_stmt_close($stmt);
}

if (!$bantuan) { include __DIR__ . '/404.php'; exit; }

$foto = $bantuan['foto'] ?? '';
$foto_path = $foto ? base_url('uploads/bantuan/' . $foto) : base_url('assets/img/no-image.png');
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-5">
            <img src="<?= $foto_path ?>" 
                 class="img-fluid rounded shadow" 
                 alt="<?= htmlspecialchars($bantuan['judul'] ?? 'Bantuan') ?>">
        </div>
        <div class="col-md-7">
            <h3><?= htmlspecialchars($bantuan['judul'] ?? 'Tidak diketahui') ?></h3>
            <p class="text-muted">
                Tanggal: <?= htmlspecialchars(isset($bantuan['tanggal']) ? date('d M Y', strtotime($bantuan['tanggal'])) : '-') ?>
            </p>
            <p><?= nl2br(htmlspecialchars($bantuan['deskripsi'] ?? 'Deskripsi belum tersedia')) ?></p>
            <hr>
            <a href="<?= base_url('?hal=loginpenerima') ?>" class="btn btn-success btn-lg">
                Login Penerima untuk Mengajukan
            </a>
        </div>
    </div>
</div>
