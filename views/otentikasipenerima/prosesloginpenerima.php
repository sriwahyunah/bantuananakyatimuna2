<?php
require_once INCLUDES_PATH . "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ?hal=loginpenerima");
    exit;
}

$nik = $_POST['nik'] ?? '';
$password = $_POST['password'] ?? '';

if ($nik === '' || $password === '') {
    header("Location: ?hal=loginpenerima&error=Harap isi semua form");
    exit;
}

// CEK DATA DI DATABASE
$query = $conn->prepare("SELECT * FROM penerima WHERE nik = ?");
$query->bind_param("s", $nik);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    header("Location: ?hal=loginpenerima&error=Akun tidak ditemukan");
    exit;
}

$data = $result->fetch_assoc();

// VALIDASI PASSWORD (gunakan password_hash)
if (!password_verify($password, $data['password'])) {
    header("Location: ?hal=loginpenerima&error=Password salah");
    exit;
}

// SIMPAN SESSION
$_SESSION['id_penerima'] = $data['id_penerima'];
$_SESSION['nik'] = $data['nik'];
$_SESSION['nama_penerima'] = $data['nama'];
$_SESSION['foto_penerima'] = $data['foto'] ?? 'default.png';

// Redirect aman
header("Location: ?hal=dashboardpenerima");
exit;
