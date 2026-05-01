<?php
session_start();
require_once INCLUDES_PATH . "koneksi.php";

$username = trim($_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$nama     = $_POST['nama'];

// cek NISP sudah ada
$cek = mysqli_query($koneksi, "SELECT * FROM penerima WHERE nisp='$username'");
if (mysqli_num_rows($cek) > 0) {
    header("Location: ?hal=registerpenerima&pesan=Username sudah digunakan");
    exit;
}

// simpan langsung ke penerima
mysqli_query($koneksi, "INSERT INTO penerima (nisp, password, nama_penerima) 
VALUES ('$username', '$password', '$nama')");

header("Location: ?hal=loginpenerima&pesan=Registrasi berhasil");