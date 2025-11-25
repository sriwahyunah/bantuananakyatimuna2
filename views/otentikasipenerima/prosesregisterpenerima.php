<?php
// ============================================================
// File: views/otentikasipenerima/prosesregisterpenerima.php
// Proses simpan data register penerima
// ============================================================

$ROOT = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR;
require_once $ROOT . 'includes/koneksi.php';
require_once $ROOT . 'includes/fungsivalidasi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASE_URL . "?hal=registerpenerima");
    exit;
}

// ==============================
// Ambil input & bersihkan
// ==============================
$nisp        = bersihkan($_POST['nisp'] ?? '');
$nama        = bersihkan($_POST['nama_penerima'] ?? '');
$kelas       = bersihkan($_POST['kelas'] ?? '');
$tgl_lahir   = bersihkan($_POST['tanggal_lahir'] ?? '');
$alamat      = bersihkan($_POST['alamat'] ?? '');
$pendapatan  = (int) ($_POST['pendapatan_orang_tua'] ?? 0);
$status      = $_POST['status'] ?? 'pending';

// ==============================
// Validasi tidak boleh kosong
// ==============================
if (!$nisp || !$nama || !$kelas || !$tgl_lahir || !$alamat || !$pendapatan) {
    header("Location: " . BASE_URL . "?hal=registerpenerima&pesan=" . urlencode("Isi semua kolom"));
    exit;
}

// ==============================
// Cek NISP sudah terpakai?
// ==============================
$stmt = $koneksi->prepare("SELECT * FROM penerima WHERE nisp = ? LIMIT 1");
$stmt->bind_param("s", $nisp);
$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    header("Location: " . BASE_URL . "?hal=registerpenerima&pesan=" . urlencode("NISP sudah terpakai"));
    exit;
}

// ==============================
// Upload foto penerima (opsional)
// ==============================
$fotoPath = null;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

    $fotoTmp  = $_FILES['foto']['tmp_name'];
    $fotoName = time() . "_" . basename($_FILES['foto']['name']);
    $target   = $ROOT . 'uploads/penerima/' . $fotoName;

    if (move_uploaded_file($fotoTmp, $target)) {
        $fotoPath = $fotoName;
    }
}

// ==============================
// Insert ke database penerima
// ==============================
$stmt = $koneksi->prepare("
    INSERT INTO penerima 
    (nisp, nama_penerima, kelas, tanggal_lahir, alamat, status, pendapatan_orang_tua, foto)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssssis",
    $nisp,
    $nama,
    $kelas,
    $tgl_lahir,
    $alamat,
    $status,
    $pendapatan,
    $fotoPath
);

// ==============================
// Eksekusi & Redirect
// ==============================
if ($stmt->execute()) {
    header("Location: " . BASE_URL . "?hal=loginpenerima&pesan=" . urlencode("Registrasi berhasil, menunggu persetujuan admin"));
    exit;
} else {
    header("Location: " . BASE_URL . "?hal=registerpenerima&pesan=" . urlencode("Gagal registrasi, coba lagi"));
    exit;
}
