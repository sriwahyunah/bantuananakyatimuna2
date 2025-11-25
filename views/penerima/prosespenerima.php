<?php
// ============================================================
// File: views/penerima/prosespenerima.php
// Deskripsi: Proses tambah data penerima bantuan
// ============================================================

session_start();
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Cek login user (admin/petugas)
if (!isset($_SESSION['id_user'])) {
    header("Location: " . BASE_URL . "?hal=otentikasiuser/login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nisp       = $_POST['nisp'] ?? '';
    $nama       = $_POST['nama_penerima'] ?? '';
    $kelas      = $_POST['kelas'] ?? '';
    $tanggal_lah  = $_POST['tanggal_lahir'] ?? '';
    $alamat     = $_POST['alamat'] ?? '';
    $status     = $_POST['status'] ?? '';
    $pendapatan = $_POST['pendapatan_orang_tua'] ?? '';

    // Validasi wajib isi
    if (empty($nisp) || empty($nama) || empty($kelas) || empty($tanggal_lah) || empty($alamat)) {
        $_SESSION['error'] = "Semua field wajib diisi!";
        header("Location: ?hal=penerima/tambah");
        exit;
    }

    // Upload Foto (opsional)
    $foto_filename = null;

    if (!empty($_FILES['foto']['name'])) {
        if ($_FILES['foto']['error'] === 0) {

            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $foto_filename = 'penerima_' . time() . '.' . $ext;

            $upload_path = __DIR__ . '/uploads/' . $foto_filename;
            move_uploaded_file($_FILES['foto']['tmp_name'], $upload_path);
        }
    }

    try {
        // Insert ke tabel penerima
        $sql = "INSERT INTO penerima 
                (nisp, nama_penerima, kelas, tanggal_lahir, alamat, status, pendapatan_orang_tua, foto)
                VALUES (:nisp, :nama, :kelas, :tanggal_lahir
, :alamat, :status, :pendapatan, :foto)";

        $stmt = $koneksi->prepare($sql);
        $stmt->execute([
            ":nisp"        => $nisp,
            ":nama"        => $nama,
            ":kelas"       => $kelas,
            ":tanggal_lahir"   => $tanggal_lahir,
            ":alamat"      => $alamat,
            ":status"      => $status,
            ":pendapatan"  => $pendapatan,
            ":foto"        => $foto_filename
        ]);

        $_SESSION['success'] = "Data penerima berhasil ditambahkan!";
        header("Location: ?hal=penerima/daftar");
        exit;
    } catch (Exception $e) {

        $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
        header("Location: ?hal=penerima/tambah");
        exit;
    }
} else {
    header("Location: ?hal=penerima/daftar");
    exit;
}
