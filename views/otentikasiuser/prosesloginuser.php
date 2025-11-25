<?php
// ==============================================
// File: views/otentikasiuser/prosesloginuser.php
// Proses backend login user (tanpa admin)
// ==============================================

$ROOT = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR;

require_once $ROOT . 'includes/konfig.php';
require_once $ROOT . 'includes/koneksi.php';
require_once $ROOT . 'includes/fungsivalidasi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil & bersihkan input
$username = bersihkan($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header("Location: " . BASE_URL . "?hal=loginuser&pesan=" . urlencode("Isi semua kolom"));
    exit;
}

// Query user berdasarkan struktur tabel
$stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Jika user ditemukan
if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    if ($user['status'] !== 'aktif') {
        header("Location: " . BASE_URL . "?hal=loginuser&pesan=" . urlencode("Akun tidak aktif"));
        exit;
    }

    if (password_verify($password, $user['password'])) {

        // Set session
        $_SESSION['loginuser'] = true;
        $_SESSION['id_user']   = $user['id_user'];
        $_SESSION['nama_user'] = $user['nama_user'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['foto']      = $user['foto'] ?? '';
        $_SESSION['role']      = $user['role'];

        // Tentukan dashboard (ADMIN DIHAPUS)
        switch ($user['role']) {
            case 'petugas':
                $hal = 'dashboardpetugas';
                break;

            case 'penerima':
                $hal = 'dashboardpenerima';
                break;

            default:
                // fallback aman
                $hal = 'dashboardpetugas';
        }

        header("Location: " . BASE_URL . "dashboard.php?hal={$hal}");
        exit;
    }
}

// Jika gagal login
header("Location: " . BASE_URL . "?hal=loginuser&pesan=" . urlencode("Username atau password salah"));
exit;
