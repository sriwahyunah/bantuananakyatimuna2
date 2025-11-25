<?php
// =======================================================
// File: index.php (root)
// Routing Aplikasi Bantuan Anak Yatim UNA2 – FULL VERSION
// =======================================================

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

session_start();

// Ambil ?hal=
$hal = isset($_GET['hal']) ? trim($_GET['hal']) : 'home';
$hal = strtolower(basename(str_replace('.php', '', $hal)));


// =======================================================
//                     ROUTING SISTEM
// =======================================================

switch ($hal) {


/* ======================================================
   LANDING PAGE
====================================================== */
case '':
case 'home':
    $file_view = VIEWS_PATH . 'landing/home.php';
    break;

case 'tentang':
case 'kontak':
case 'kategori':
case 'detilbantuan':
case 'proseskomentar':
    $file_view = VIEWS_PATH . 'landing/' . $hal . '.php';
    break;



/* ======================================================
   OTENTIKASI USER (ADMIN / PETUGAS)
====================================================== */
case 'loginuser':
case 'prosesloginuser':
case 'logoutuser':
case 'registeruser':
    $file_view = VIEWS_PATH . 'otentikasiuser/' . $hal . '.php';
    break;



/* ======================================================
   OTENTIKASI PENERIMA
====================================================== */
case 'loginpenerima':
case 'prosesloginpenerima':
case 'registerpenerima':
case 'prosesregisterpenerima':
case 'logoutpenerima':
    $file_view = VIEWS_PATH . 'otentikasipenerima/' . $hal . '.php';
    break;



/* ======================================================
   DASHBOARD PENERIMA
====================================================== */
case 'dashboardpenerima':
case 'daftarpenerimaan':
case 'editpenerimaan':
case 'prosespenerimaan':
case 'tambahpenerimaan':

    if (!isset($_SESSION['id_penerima'])) {
        header("Location: ?hal=loginpenerima");
        exit;
    }

    $file_view = VIEWS_PATH . 'penerima/' . $hal . '.php';

    include PAGES_PATH . 'penerima/header.php';
    include PAGES_PATH . 'penerima/navbar.php';

    if (file_exists($file_view)) {
        include $file_view;
    } else {
        include VIEWS_PATH . 'landing/404.php';
    }

    include PAGES_PATH . 'penerima/footer.php';
    exit;



/* ======================================================
   DASHBOARD PETUGAS / ADMIN
   (sesuai folder /views/user/)
====================================================== */
case 'dashboardpetugas':
case 'dashboardadmin':
case 'datauser':
case 'edituser':
case 'tambahuser':
case 'prosesuser':
case 'daftarbantuan':
case 'editbantuan':
case 'tambahbantuan':
case 'daftarlaporan':
case 'cetaklaporan':
case 'daftarpenerima':
case 'editpenerima':
case 'tambahpenerima':
case 'prosespenerima':
case 'daftartransaksi':
case 'edittransaksi':
case 'tambahtransaksi':
case 'prosestransaksi':

    // wajib login admin/petugas
    if (!isset($_SESSION['id_user'])) {
        header("Location: ?hal=loginuser");
        exit;
    }

    $file_view = VIEWS_PATH . 'user/' . $hal . '.php';

    include PAGES_PATH . 'user/header.php';
    include PAGES_PATH . 'user/navbar.php';
    include PAGES_PATH . 'user/sidebar.php';

    if (file_exists($file_view)) {
        include $file_view;
    } else {
        include VIEWS_PATH . 'landing/404.php';
    }

    include PAGES_PATH . 'user/footer.php';
    exit;



/* ======================================================
   HALAMAN TIDAK DITEMUKAN
====================================================== */
default:
    $file_view = VIEWS_PATH . 'landing/404.php';
    break;
}



// =======================================================
// TEMPLATE LANDING
// =======================================================

include PAGES_PATH . 'landing/header.php';
include PAGES_PATH . 'landing/navbar.php';

if ($hal === 'home') {
    include PAGES_PATH . 'landing/hero.php';
}

if (file_exists($file_view)) {
    include $file_view;
} else {
    include VIEWS_PATH . 'landing/404.php';
}

include PAGES_PATH . 'landing/footer.php';
