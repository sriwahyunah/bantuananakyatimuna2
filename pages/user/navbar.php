<?php
$namauser = $_SESSION['namauser'] ?? 'Pengguna';
$role     = $_SESSION['role'] ?? 'user';
$foto     = $_SESSION['foto'] ?? 'default.png';

$dashboard_url = BASE_URL . '?hal=dashboard' . $role;
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= $dashboard_url ?>" class="nav-link">Beranda</a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <img src="<?= BASE_URL ?>uploads/user/<?= $foto ?>" class="img-circle elevation-2"
             style="width:28px;height:28px;object-fit:cover;">
        <?= htmlspecialchars($namauser); ?>
      </a>

      <ul class="dropdown-menu dropdown-menu-right">
        <li><a class="dropdown-item" href="#"><i class="fas fa-id-card mr-2"></i> Profil</a></li>
        <li><a class="dropdown-item text-danger" href="?hal=logout">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout</a></li>
      </ul>

    </li>
  </ul>

</nav>

<div class="content-wrapper">
