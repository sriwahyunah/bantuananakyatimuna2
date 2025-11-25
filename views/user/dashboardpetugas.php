<?php
require_once __DIR__ . '/../../includes/ceksession.php';
require_once __DIR__ . '/../../includes/koneksi.php';

/* ===============================================================
   1. AMBIL DAFTAR TABEL
   ===============================================================*/
$tabel = [];
$q = mysqli_query($koneksi, "SHOW TABLES");
while ($row = mysqli_fetch_array($q)) {
    $tabel[] = $row[0];
}

/* ===============================================================
   2. HITUNG TOTAL DATA PER TABEL
   ===============================================================*/
$statistik = [];
foreach ($tabel as $tbl) {
    $qCount = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM $tbl");
    $d = mysqli_fetch_assoc($qCount);
    $statistik[$tbl] = $d['jml'];
}

/* ===============================================================
   3. DATA TERBARU 5 ENTRI/TABEL
   ===============================================================*/
$dataTerbaru = [];
foreach ($tabel as $tbl) {

    // Kolom tabel
    $kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM $tbl");
    $fields = [];
    while ($k = mysqli_fetch_assoc($kolom)) {
        $fields[] = $k['Field'];
    }

    // 5 data terbaru
    $get = mysqli_query($koneksi, "SELECT * FROM $tbl ORDER BY 1 DESC LIMIT 5");
    $records = [];
    while ($row = mysqli_fetch_assoc($get)) {
        $records[] = $row;
    }

    $dataTerbaru[$tbl] = [
        'kolom' => $fields,
        'data'  => $records
    ];
}

/* ===============================================================
   4. CARI TABEL TRANSAKSI UNTUK GRAFIK
   ===============================================================*/
$tblTransaksi = null;
foreach ($tabel as $tbl) {
    if (strpos($tbl, 'trans') !== false || strpos($tbl, 'bayar') !== false) {
        $tblTransaksi = $tbl;
        break;
    }
}

$labelGrafik = [];
$jumlahGrafik = [];

if ($tblTransaksi) {
    $ambilGrafik = mysqli_query($koneksi, "
        SELECT 
            IFNULL(id_bantuan, 'Unknown') AS bantuan,
            COUNT(*) AS jumlah
        FROM $tblTransaksi
        GROUP BY id_bantuan
    ");

    while ($r = mysqli_fetch_assoc($ambilGrafik)) {
        $labelGrafik[] = $r['bantuan'];
        $jumlahGrafik[] = $r['jumlah'];
    }
}

/* ===============================================================
   TEMPLATE
   ===============================================================*/
include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebar.php';
?>

<style>
.small-box {
    border-radius: 8px;
    position: relative;
    overflow: hidden;
}
.small-box .icon {
    position: absolute;
    right: 15px;
    top: 15px;
    opacity: 0.2;
}
.table thead th {
    background: #f2f2f2;
}
</style>

<div class="content p-4">

    <div class="container-fluid">

        <!-- ===========================
             STATISTIK
        ============================ -->
        <div class="row">
            <?php foreach ($statistik as $namaTabel => $total): ?>
            <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                <div class="small-box bg-info text-white p-3 shadow-sm">
                    <div class="inner">
                        <h3><?= $total ?></h3>
                        <p><?= strtoupper($namaTabel) ?></p>
                    </div>
                    <div class="icon"><i class="fas fa-database fa-3x"></i></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- ===========================
             GRAFIK TRANSAKSI
        ============================ -->
        <?php if ($tblTransaksi): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0">Grafik Data Transaksi (Tabel: <?= $tblTransaksi ?>)</h6>
            </div>
            <div class="card-body">
                <canvas id="grafikTransaksi" height="100"></canvas>
            </div>
        </div>
        <?php endif; ?>

        <!-- ===========================
             DATA TERBARU PER TABEL
        ============================ -->
        <?php foreach ($dataTerbaru as $tbl => $isi): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h6 class="m-0">Data Terbaru dari Tabel: <?= $tbl ?></h6>
            </div>
            <div class="card-body p-2">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <?php foreach ($isi['kolom'] as $col): ?>
                            <th><?= $col ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($isi['data'])): ?>
                            <?php foreach ($isi['data'] as $row): ?>
                            <tr>
                                <?php foreach ($isi['kolom'] as $col): ?>
                                    <td><?= htmlspecialchars($row[$col] ?? '-') ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="20" class="text-center">Tidak ada data.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php if ($tblTransaksi): ?>
<script>
new Chart(document.getElementById('grafikTransaksi'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($labelGrafik) ?>,
        datasets: [{
            label: 'Jumlah Transaksi',
            data: <?= json_encode($jumlahGrafik) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: { 
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});
</script>
<?php endif; ?>
