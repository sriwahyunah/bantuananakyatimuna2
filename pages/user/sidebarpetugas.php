<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <a href="dashboard.php?hal=dashboardpetugas" class="brand-link text-center">
    <span class="brand-text font-weight-bold">Bantuan Anak Yatim</span>
  </a>

  <div class="sidebar">

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= BASE_URL ?>uploads/user/<?= htmlspecialchars($fotoUser) ?>"
             class="img-circle elevation-2">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= htmlspecialchars($namaUser) ?> (Petugas)</a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column">

        <li class="nav-item">
          <a href="?hal=dashboardpetugas" class="nav-link"><i class="nav-icon fas fa-home"></i><p>Dashboard</p></a>
        </li>

        <li class="nav-item">
          <a href="?hal=bantuan/daftarbantuan" class="nav-link"><i class="nav-icon fas fa-hand-holding-heart"></i><p>Kelola Bantuan</p></a>
        </li>

        <li class="nav-item">
          <a href="?hal=penerima/daftarpenerima" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Kelola Penerima</p></a>
        </li>

        <li class="nav-item">
          <a href="?hal=transaksi/daftartransaksi" class="nav-link"><i class="nav-icon fas fa-exchange-alt"></i><p>Transaksi</p></a>
        </li>

        <li class="nav-item">
          <a href="?hal=laporan/daftarlaporan" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Laporan</p></a>
        </li>

        <li class="nav-item mt-3">
          <a href="?hal=logout" class="nav-link text-danger"><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p></a>
        </li>

      </ul>
    </nav>

  </div>
</aside>
