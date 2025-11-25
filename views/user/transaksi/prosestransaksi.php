<?php
include "koneksi.php";

// Pastikan ada id_transaksi
if (!isset($_GET['id_transaksi'])) {
    echo "<div class='alert alert-danger'>ID Transaksi tidak ditemukan.</div>";
    exit;
}

$id_transaksi = $_GET['id_transaksi'];

// Ambil data transaksi, penerima, dan bantuan
$q = mysqli_query($koneksi, "
    SELECT t.*, 
           b.nama_bantuan, b.nominal AS nominal_bantuan,
           p.nama_penerima, p.kelas, p.nisp
    FROM transaksi t
    JOIN bantuan b ON t.id_bantuan = b.id_bantuan
    JOIN penerima p ON t.id_penerima = p.id_penerima
    WHERE t.id_transaksi = '$id_transaksi'
");

$data = mysqli_fetch_assoc($q);

if (!$data) {
    echo "<div class='alert alert-danger'>Data transaksi tidak ditemukan.</div>";
    exit;
}

$hariIni = date('Y-m-d');
$tanggal_bayar = $data['tanggal_pembayaran'];

// Hitung terlambat
$terlambat = (strtotime($hariIni) - strtotime($tanggal_bayar)) / (60 * 60 * 24);
$terlambat = ($terlambat > 0) ? $terlambat : 0;

// Hitung denda (contoh: 1000 per hari)
$denda = $terlambat * 1000;

$totalDenda = $denda;
?>

<div class="card card-outline card-primary">
  <div class="card-header bg-warning">
    <h5 class="mb-0">
      Proses Pembayaran Bantuan - 
      <b><?= htmlspecialchars($data['nama_penerima']) ?></b>
    </h5>
  </div>

  <div class="card-body">
    <form action="db/dbtransaksi.php?proses=bayar" method="POST">
      <input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">

      <table class="table table-bordered table-hover">
        <thead class="bg-info text-white text-center">
          <tr>
            <th>Nama Bantuan</th>
            <th>Nominal Bantuan</th>
            <th>Tanggal Pembayaran</th>
            <th>Status</th>
            <th>Terlambat (hari)</th>
            <th>Denda</th>
          </tr>
        </thead>

        <tbody>
          <tr class="text-center">
            <td><?= $data['nama_bantuan'] ?></td>
            <td>Rp<?= number_format($data['nominal_bantuan'], 0, ',', '.') ?></td>
            <td><?= $data['tanggal_pembayaran'] ?></td>

            <td>
              <?php if ($terlambat > 0): ?>
                <span class="badge bg-danger">Terlambat</span>
              <?php else: ?>
                <span class="badge bg-success">Tepat Waktu</span>
              <?php endif; ?>
            </td>

            <td><?= $terlambat ?></td>

            <td>Rp<?= number_format($denda, 0, ',', '.') ?></td>
          </tr>
        </tbody>
      </table>

      <hr>

      <div class="row text-center align-items-center">
        <div class="col-md-3">
          <label class="bg-info text-white w-100 p-2">Total Denda</label>
          <div class="bg-info text-white p-2 rounded">
            Rp<?= number_format($totalDenda, 0, ',', '.') ?>
          </div>
          <input type="hidden" name="totaldenda" id="totaldenda" value="<?= $totalDenda ?>">
        </div>

        <div class="col-md-2">
          <label>Bayar</label>
          <input type="number" name="dibayar" id="dibayar" class="form-control" value="0" min="0">
        </div>

        <div class="col-md-3">
          <label class="bg-danger text-white w-100 p-2">Tunggakan</label>
          <div id="tunggakan" class="bg-danger text-white p-2 rounded">
            Rp<?= number_format($totalDenda, 0, ',', '.') ?>
          </div>
        </div>

        <div class="col-md-3">
          <label class="bg-success text-white w-100 p-2">Kembalian</label>
          <div id="kembalian" class="bg-success text-white p-2 rounded">Rp0</div>
        </div>
      </div>

      <div class="mt-4 text-center">
        <a href="index.php?halaman=daftartransaksi" class="btn btn-primary">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button type="reset" class="btn btn-warning">
          <i class="fas fa-undo"></i> Reset
        </button>
        <button type="submit" class="btn btn-success">
          <i class="fas fa-save"></i> Simpan Pembayaran
        </button>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('dibayar').addEventListener('input', function() {
  let dibayar = parseInt(this.value) || 0;
  let total = parseInt(document.getElementById('totaldenda').value) || 0;

  let tunggakan = document.getElementById('tunggakan');
  let kembalian = document.getElementById('kembalian');

  if (dibayar >= total) {
    tunggakan.textContent = "Rp0";
    kembalian.textContent = "Rp" + (dibayar - total).toLocaleString('id-ID');
  } else {
    tunggakan.textContent = "Rp" + (total - dibayar).toLocaleString('id-ID');
    kembalian.textContent = "Rp0";
  }
});
</script>
