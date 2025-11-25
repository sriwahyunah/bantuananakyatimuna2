<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/path.php';

// 1. Cek apakah user sudah login
//    prosesloginuser.php menggunakan: $_SESSION['loginuser']
if (!isset($_SESSION['loginuser']) || $_SESSION['loginuser'] !== true) {
    header("Location: " . BASE_URL . "?hal=loginuser");
    exit;
}

// 2. Validasi role (harus sesuai ENUM dalam tabel user)
$role = $_SESSION['role'] ?? null;

if (!in_array($role, ['admin', 'petugas', 'editor'])) {
    session_destroy();
    header("Location: " . BASE_URL . "?hal=loginuser");
    exit;
}

// 3. Variabel session
$id_user   = $_SESSION['id_user']   ?? null;
$nama_user = $_SESSION['nama_user'] ?? null;
$username  = $_SESSION['username']  ?? null;
$foto      = $_SESSION['foto']      ?? null;

?>
