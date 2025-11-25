<?php
include "../koneksi.php";

if (!isset($_GET['proses'])) {
    echo "<script>alert('Akses tidak valid!'); history.back();</script>";
    exit;
}

$proses = $_GET['proses'];

/* ============================
    PROSES UPDATE USER
============================ */
if ($proses == "update") {

    $id_user    = $_POST['id_user'];
    $nama_user  = mysqli_real_escape_string($koneksi, $_POST['nama_user']);
    $username   = mysqli_real_escape_string($koneksi, $_POST['username']);
    $role       = $_POST['role'];
    $status     = $_POST['status'];

    // Ambil data user lama untuk cek foto
    $qOld = mysqli_query($koneksi, "SELECT foto FROM user WHERE id_user = '$id_user'");
    $dOld = mysqli_fetch_assoc($qOld);
    $fotoLama = $dOld['foto'];

    /* ---------------------------
        PROSES UPLOAD FOTO
    ---------------------------- */
    $fotoBaru = $fotoLama; // default tidak berubah

    if (!empty($_FILES['foto']['name'])) {

        $namaFile = $_FILES['foto']['name'];
        $tmpFile  = $_FILES['foto']['tmp_name'];

        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (!in_array($ext, $allowed)) {
            echo "<script>alert('Format foto tidak valid! (jpg, jpeg, png)'); history.back();</script>";
            exit;
        }

        // Nama baru unik
        $fotoBaru = "user_" . time() . "." . $ext;

        // Upload foto
        move_uploaded_file($tmpFile, "../upload/" . $fotoBaru);

        // Hapus foto lama jika ada
        if ($fotoLama != "" && file_exists("../upload/" . $fotoLama)) {
            unlink("../upload/" . $fotoLama);
        }
    }

    /* ---------------------------
        UPDATE USER KE DATABASE
    ---------------------------- */
    $qUpdate = mysqli_query($koneksi, "
        UPDATE user SET
            nama_user = '$nama_user',
            username  = '$username',
            role      = '$role',
            status    = '$status',
            foto      = '$fotoBaru'
        WHERE id_user = '$id_user'
    ");

    if ($qUpdate) {
        echo "<script>alert('Data user berhasil diupdate!'); 
        window.location='../index.php?halaman=datauser';</script>";
    } else {
        echo "<script>alert('Gagal update user!'); history.back();</script>";
    }

}
?>
