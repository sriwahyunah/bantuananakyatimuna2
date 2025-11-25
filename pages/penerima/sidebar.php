<?php
// ======================================================
// Sidebar Penerima – Sistem Bantuan Anak Yatim
// ======================================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Data penerima dari session
$id_penerima   = $_SESSION['id_penerima'] ?? 0;
$nama_penerima = $_SESSION['nama_penerima'] ?? 'Penerima';
$foto_penerima = 'default.png';

// Ambil foto penerima dari DB
if ($id_penerima) {
    $q = mysqli_query($koneksi, "SELECT foto FROM bantuanananakyatimuna2_penerima WHERE id_penerima = '$id_penerima' LIMIT 1");
    $d = mysqli_fetch_assoc($q);

    if ($d && $d['foto']) {
        $filePath = UPLOADS_PATH . 'penerima/' . $d['foto'];
        if (file_exists($filePath)) {
            $foto_penerima = $d['foto'];
        }
    }
}
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Logo -->
    <a href="<?= BASE_URL ?>dashboard.php?hal=dashboardpenerima" class="brand-link text-center">
        <span class="brand-text font-weight-bold">BantuanAnakYatim</span>
    </a>

    <div class="sidebar">

        <!-- Panel User -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= BASE_URL ?>uploads/penerima/<?= htmlspecialchars($foto_penerima) ?>"
                     class="img-circle elevation-2"
                     style="width: 35px; height: 35px; object-fit: cover;">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= htmlspecialchars($nama_penerima) ?></a>
                <small class="text-muted">Penerima</small>
            </div>
        </div>

        <!-- Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>dashboard.php?hal=dashboardpenerima" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>dashboard.php?hal=bantuan/daftarbantuan" class="nav-link">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>Daftar Bantuan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>dashboard.php?hal=transaksi/riwayattransaksi" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Riwayat Transaksi</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>dashboard.php?hal=penerima/profil" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=logoutpenerima" class="nav-link text-danger">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>

    </div>
</aside>
