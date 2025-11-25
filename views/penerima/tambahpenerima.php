<?php
// ============================================================
// File : views/penerima/tambahpenerima.php
// Deskripsi : Form tambah penerima bantuan
// ============================================================

session_start();
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Cek login admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: ?hal=login");
    exit;
}

?>

<?php include PAGES_PATH . 'header.php'; ?>

<div class="container mt-4">
    <h2>Tambah Data Penerima</h2>

    <form action="?hal=prosespenerima" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label">NISP</label>
            <input type="text" name="nisp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Penerima</label>
            <input type="text" name="nama_penerima" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <input type="text" name="kelas" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <input type="text" name="status" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Pendapatan Orang Tua</label>
            <input type="number" name="pendapatan_orang_tua" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="?hal=datapenerima" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include PAGES_PATH . 'footer.php'; ?>
