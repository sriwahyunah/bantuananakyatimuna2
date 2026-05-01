<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once INCLUDES_PATH . "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ?hal=loginpenerima");
    exit;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header("Location: ?hal=loginpenerima&pesan=Harap isi semua form");
    exit;
}

// 🔥 QUERY YANG BENAR
$query = mysqli_query($koneksi, "SELECT * FROM penerima WHERE nisp='$username'");

if (mysqli_num_rows($query) === 0) {
    header("Location: ?hal=loginpenerima&pesan=Akun tidak ditemukan");
    exit;
}

$data = mysqli_fetch_assoc($query);

// PASSWORD
if (!password_verify($password, $data['password'])) {
    header("Location: ?hal=loginpenerima&pesan=Password salah");
    exit;
}

// SESSION
$_SESSION['role'] = 'penerima';
$_SESSION['id_penerima'] = $data['id_penerima'];
$_SESSION['nama_penerima'] = $data['nama_penerima'];
$_SESSION['foto_penerima'] = $data['foto'] ?? 'default.png';

// REDIRECT
header("Location: ?hal=dashboardpenerima");
exit;