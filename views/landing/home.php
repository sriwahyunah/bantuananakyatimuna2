<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Bantuan Anak Yatim - Tema Gold</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- CSS Tema Gold -->
    <link rel="stylesheet" href="style-gold.css">
</head>
<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Aplikasi Bantuan Anak Yatim</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Program Bantuan</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Donasi</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Kontak</a></li>
            </ul>

            <div class="ms-3">
                <button class="btn btn-outline-light btn-sm me-2">Login Penerima</button>
                <button class="btn btn-danger btn-sm">Login Admin</button>
            </div>
        </div>
    </div>
</nav>


<!-- ================= HERO ================= -->
<section class="hero text-center text-white">
    <div class="container">
        <h1>Selamat Datang di Sistem Bantuan Anak Yatim</h1>
        <p class="mt-3">Platform untuk mengelola donasi dan penyaluran bantuan secara transparan dan profesional.</p>
        <button class="btn btn-light btn-lg mt-3 fw-semibold">Lihat Program Bantuan</button>
    </div>
</section>


<!-- ================= CONTENT ================= -->
<div class="container my-5">
    <div class="row">

        <!-- ===== DAFTAR BANTUAN ===== -->
        <div class="col-lg-8">
            <h3 class="fw-bold mb-4">Daftar Bantuan</h3>

            <div class="card-bantuan d-flex align-items-center">
                <img src="https://cdn-icons-png.flaticon.com/512/1048/1048953.png" height="60" class="me-3">
                <div>
                    <h5 class="fw-bold mb-1">bantuananakyatim</h5>
                    <p class="text-muted mb-2">Nominal Bantuan: <strong>Rp 1.000.000</strong></p>
                    <button class="btn btn-dark btn-sm">Lihat Detail</button>
                </div>
            </div>
        </div>


        <!-- ===== SIDEBAR INFO ===== -->
        <div class="col-lg-4">
            <div class="sidebar-box mb-4">
                <h5 class="fw-bold mb-3">Informasi</h5>
                <p>Sistem manajemen bantuan anak yatim dengan tampilan premium dan elegan.</p>

                <h6 class="fw-bold mt-4">Kategori Bantuan</h6>
                <span class="badge gold-badge">Pendidikan</span>
                <span class="badge gold-badge">Kesehatan</span>
                <span class="badge gold-badge">Kebutuhan Harian</span>
                <span class="badge gold-badge">Beasiswa</span>
                <span class="badge gold-badge">Santunan Khusus</span>

                <h6 class="fw-bold mt-4">Status Penyaluran</h6>
                <span class="status-active">AKTIF</span>
                <p class="mt-2 text-muted">Penyaluran bantuan berjalan dengan baik.</p>

                <p class="text-muted">Jam operasional: 08.00 – 20.00 WIB</p>
            </div>
        </div>

    </div>
</div>


<!-- ================= FOOTER ================= -->
<footer>
    <p class="mb-0">© 2025 Aplikasi Bantuan Anak Yatim<br>Tampilan Tema Gold Premium</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
