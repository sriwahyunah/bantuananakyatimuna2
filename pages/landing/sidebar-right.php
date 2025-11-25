<?php
// ===============================================
// SIDEBAR KANAN FINAL – Sistem Bantuan Anak Yatim
// ===============================================

// Contoh data kategori bantuan (statis seperti pola asli)
$kategori = [
    "Pendidikan",
    "Kesehatan",
    "Kebutuhan Harian",
    "Beasiswa",
    "Santunan Khusus"
];

?>

<div class="sidebar-right p-3 bg-white shadow-sm rounded">

    <!-- INFORMASI SISTEM -->
    <h5 class="fw-bold">Informasi</h5>
    <p class="text-muted small">
        Sistem manajemen bantuan anak yatim.<br>
        Membantu penyaluran donasi secara tepat sasaran.
    </p>

    <hr>

    <!-- KATEGORI BANTUAN -->
    <h6 class="fw-bold mt-3">Kategori Bantuan</h6>
    <div class="tag-cloud">
        <?php foreach ($kategori as $kat): ?>
            <span class="badge bg-primary mb-1"><?= $kat ?></span>
        <?php endforeach; ?>
    </div>

    <hr>

    <!-- STATUS LAYANAN -->
    <h6 class="fw-bold mt-3">Status Penyaluran</h6>
    <p class="small">
        <span class="badge bg-success">Aktif</span> Penyaluran bantuan sedang berjalan.
    </p>

    <p class="small text-muted">
        Jam operasional: 08.00 – 20.00 WIB
    </p>

</div>
