<?php
// ===============================================
// File: pages/landing/hero.php
// Deskripsi: Hero Section untuk halaman home (Bantuan Anak Yatim)
// ===============================================
?>

<div class="hero-section py-5 text-white" style="background: linear-gradient(to right, #4e73df, #224abe);">
  <div class="container text-center">
    <h1 class="display-4 fw-bold">Selamat Datang di Sistem Bantuan Anak Yatim</h1>

    <p class="lead mb-4">
      Platform untuk mengelola donasi dan penyaluran bantuan kepada anak yatim
      secara transparan dan terorganisir.
    </p>

    <a href="<?= $base_url . '?hal=program'; ?>" class="btn btn-light btn-lg shadow-sm">
      Lihat Program Bantuan
    </a>
  </div>
</div>
