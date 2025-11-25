<?php
// ==============================================
// File: pages/penerima/navbar.php
// Deskripsi: Navbar + Breadcrumb otomatis + Logout Penerima
// ==============================================

// Session penerima

$namapenerima = $_SESSION['nama_penerima'] ?? "Penerima";
$foto = $_SESSION['foto_penerima'] ?? "default.png";


// Logout URL khusus penerima
$logout_url = BASE_URL . '?hal=logoutpenerima';

/**
 * =====================================================
 * Fungsi otomatis membentuk breadcrumb (Versi Penerima)
 * =====================================================
 */
if (!function_exists('buat_breadcrumb_otomatis_penerima')) {
    function buat_breadcrumb_otomatis_penerima()
    {
        $hal = $_GET['hal'] ?? 'dashboardpenerima';

        // Dashboard utama
        if ($hal === 'dashboardpenerima') {
            echo '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item active">Dashboard</li></ol>';
            return;
        }

        $parts = explode('/', $hal);
        $breadcrumb = [];

        // Tambahkan Dashboard sebagai awal
        $breadcrumb[] =
            '<li class="breadcrumb-item">
                <a href="' . BASE_URL . '?hal=dashboardpenerima">Dashboard</a>
            </li>';

        // Menu otomatis
        for ($i = 0; $i < count($parts); $i++) {

            $segment = htmlspecialchars(ucfirst(str_replace(['_', '-'], ' ', $parts[$i])));

            if ($i < count($parts) - 1) {
                $suburl = BASE_URL . '?hal=' . implode('/', array_slice($parts, 0, $i + 1));
                $breadcrumb[] = '<li class="breadcrumb-item"><a href="' . $suburl . '">' . $segment . '</a></li>';
            } else {
                $breadcrumb[] = '<li class="breadcrumb-item active">' . $segment . '</li>';
            }
        }

        echo '<ol class="breadcrumb float-sm-right">' . implode('', $breadcrumb) . '</ol>';
    }
}

/**
 * =====================================================
 * Fungsi membuat judul halaman otomatis (Versi Penerima)
 * =====================================================
 */
if (!function_exists('judul_halaman_otomatis_penerima')) {
    function judul_halaman_otomatis_penerima()
    {
        $hal = $_GET['hal'] ?? 'dashboardpenerima';
        if ($hal === 'dashboardpenerima') return 'Dashboard';

        $parts = explode('/', $hal);
        return ucfirst(str_replace(['_', '-'], ' ', end($parts)));
    }
}
?>

<!-- ============================================== -->
<!-- NAVBAR ATAS DASHBOARD PENERIMA -->
<!-- ============================================== -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <!-- Kiri: home -->
  <ul class="navbar-nav">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= BASE_URL ?>?hal=dashboardpenerima" class="nav-link">Beranda</a>
    </li>
  </ul>

  <!-- Kanan: user menu -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <img src="<?= BASE_URL ?>uploads/penerima/<?= $foto ?>"
             class="img-circle elevation-2"
             style="width:30px;height:30px;object-fit:cover;">
        <?= htmlspecialchars($namapenerima); ?> (Penerima)
      </a>

      <ul class="dropdown-menu dropdown-menu-right">
        <li><a class="dropdown-item" href="#">
            <i class="fas fa-id-card mr-2"></i> Profil
        </a></li>
        <li><a class="dropdown-item text-danger" href="<?= $logout_url ?>">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a></li>
      </ul>
    </li>
  </ul>

</nav>

<!-- ============================================== -->
<!-- HEADER + BREADCRUMB OTOMATIS (PENERIMA) -->
<!-- ============================================== -->
<div class="content-header">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <h5 class="m-0"><?= judul_halaman_otomatis_penerima(); ?></h5>
    <?php buat_breadcrumb_otomatis_penerima(); ?>
  </div>
</div>
