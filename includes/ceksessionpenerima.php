<?php
// ============================================================
// File: includes/ceksessionpenerima.php
// Deskripsi: Mengecek session login khusus penerima
// ============================================================

// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah penerima sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || ($_SESSION['role'] ?? '') !== 'penerima') {
    // Belum login atau bukan penerima → redirect ke halaman login penerima
    header("Location: " . BASE_URL . "?hal=loginpenerima");
    exit;
}

// (Opsional) Set variabel global penerima
$id_penerima   = $_SESSION['id_penerima'] ?? null;
$nama_penerima = $_SESSION['nama_penerima'] ?? null;
$username     = $_SESSION['username'] ?? null;
$foto         = $_SESSION['foto'] ?? null;
$role         = $_SESSION['role'] ?? null;