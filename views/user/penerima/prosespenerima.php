<?php
include "../koneksi.php";

$proses = $_GET['proses'];

// =========================
// PROSES TAMBAH PENERIMA
// =========================
if ($proses == "tambah") {

    $nisp = $_POST['nisp'];
    $nama = $_POST['nama_penerima'];
    $kelas = $_POST['kelas'];
    $tgl = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];
    $pendapatan = $_POST['pendapatan_orang_tua'];

    // upload foto
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if ($foto != "") {
        $ext = pathinfo($foto, PATHINFO_EXTENSION);
        $fotoBaru = "penerima_" . time() . "." . $ext;
        move_uploaded_file($tmp, "../upload/" . $fotoBaru);
    } else {
        $fotoBaru = "";
    }

    $query = mysqli_query($koneksi, "
        INSERT INTO penerima 
        (nisp, nama_penerima, kelas, tanggal_lahir, alamat, status, pendapatan_orang_tua, foto)
        VALUES ('$nisp', '$nama', '$kelas', '$tgl', '$alamat', '$status', '$pendapatan', '$fotoBaru')
    ");

    if ($query) {
        echo "<script>alert('Penerima berhasil ditambah'); 
        window.location='../index.php?halaman=penerima';</script>";
    } else {
        echo "<script>alert('Gagal menambah penerima'); history.back();</script>";
    }
}



// =========================
// PROSES EDIT PENERIMA
// =========================
elseif ($proses == "edit") {

    $id = $_POST['id_penerima'];
    $nisp = $_POST['nisp'];
    $nama = $_POST['nama_penerima'];
    $kelas = $_POST['kelas'];
    $tgl = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];
    $pendapatan = $_POST['pendapatan_orang_tua'];

    // cek foto baru
    if ($_FILES['foto']['name'] != "") {
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($foto, PATHINFO_EXTENSION);
        $fotoBaru = "penerima_" . time() . "." . $ext;

        move_uploaded_file($tmp, "../upload/" . $fotoBaru);

        $upFoto = ", foto='$fotoBaru'";
    } else {
        $upFoto = "";
    }

    $query = mysqli_query($koneksi, "
        UPDATE penerima SET 
            nisp='$nisp',
            nama_penerima='$nama',
            kelas='$kelas',
            tanggal_lahir='$tgl',
            alamat='$alamat',
            status='$status',
            pendapatan_orang_tua='$pendapatan'
            $upFoto
        WHERE id_penerima='$id'
    ");

    if ($query) {
        echo "<script>alert('Data penerima berhasil diperbarui'); 
        window.location='../index.php?halaman=penerima';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data penerima'); history.back();</script>";
    }
}



// =========================
// PROSES HAPUS PENERIMA
// =========================
elseif ($proses == "hapus") {

    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "DELETE FROM penerima WHERE id_penerima='$id'");

    if ($query) {
        echo "<script>alert('Penerima berhasil dihapus'); 
        window.location='../index.php?halaman=penerima';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data'); history.back();</script>";
    }
}

?>
