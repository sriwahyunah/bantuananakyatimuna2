<?php
// =======================================
// File: dashboard.php - Routing Backend Bantuan Anak Yatim
// Versi Perbaikan Lengkap
// =======================================

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'fungsivalidasi.php';

session_start();

// =======================================
// 1️⃣ Tentukan Role & Folder View
// - Tidak ada folder "petugas", jadi semuanya dipusatkan ke folder "views/user"
// =======================================

$role = $_SESSION['role'] ?? '';

switch ($role) {
    case 'petugas':
        $viewFolder = 'views/user';
        $defaultPage = 'dashboardpetugas';
        break;

    case 'penerima':
        $viewFolder = 'views/penerima';
        $defaultPage = 'dashboardpenerima';
        break;

    default:
        // fallback aman jika role kosong / tidak dikenal
        $viewFolder = 'views/user';
        $defaultPage = 'dashboardpetugas';
        break;
}


// =======================================
// 2️⃣ Ambil halaman dari GET parameter
// =======================================
$hal = $_GET['hal'] ?? $defaultPage;
$halPath = explode('/', $hal);


// =======================================
// 3️⃣ Bangun path file view berdasarkan struktur folder
// =======================================
if (count($halPath) > 1) {
    // Contoh: hal=bantuan/daftarbantuan
    $module = $halPath[0];
    $page   = $halPath[1];

    $file = BASE_PATH . "/{$viewFolder}/{$module}/{$page}.php";

} else {
    // Contoh: hal=dashboardpetugas
    $file = BASE_PATH . "/{$viewFolder}/{$hal}.php";
}


// =======================================
// 4️⃣ Jika file tidak ditemukan → fallback otomatis
// =======================================
if (!file_exists($file)) {

    $fallbacks = [
        'user'      => 'user/daftaruser',
        'bantuan'   => 'bantuan/daftarbantuan',
        'penerima'  => 'penerima/daftarpenerima',
        'transaksi' => 'transaksi/daftartransaksi',
        'laporan'   => 'laporan/daftarlaporan'
    ];

    $parent = $halPath[0] ?? '';

    if (isset($fallbacks[$parent])) {
        $file = BASE_PATH . "/{$viewFolder}/" . $fallbacks[$parent] . ".php";
    } else {
        // fallback terakhir ke dashboard utama
        $file = BASE_PATH . "/{$viewFolder}/{$defaultPage}.php";
    }
}


// =======================================
// 5️⃣ Load file view (FINAL)
// =======================================
if (!file_exists($file)) {
    die("⚠️ File view tidak ditemukan:<br><b>{$file}</b>");
}

include $file;

?>
