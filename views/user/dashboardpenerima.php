<?php
// ==============================================
// Dashboard Admin – Sistem Bantuan Anak Yatim
// ==============================================

// Statistik
$totalBantuan   = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jml FROM bantuanananakyatimuna2_bantuan"))['jml'];
$totalPenerima  = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jml FROM bantuanananakyatimuna2_penerima"))['jml'];
$totalAdmin     = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jml FROM bantuanananakyatimuna2_admin"))['jml'];
$totalUser      = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jml FROM bantuanananakyatimuna2_user"))['jml'];
$totalTransaksi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jml FROM bantuanananakyatimuna2_transaksi"))['jml'];


// Grafik: Transaksi per Bantuan
$hasilBantuan = mysqli_query($koneksi, "
    SELECT b.nama_bantuan, COUNT(t.id_transaksi) AS jumlah
    FROM bantuanananakyatimuna2_bantuan b
    LEFT JOIN bantuanananakyatimuna2_transaksi t
        ON t.id_bantuan = b.id_bantuan
    GROUP BY b.id_bantuan
");

$labelBantuan = [];
$jumlahTrans = [];

while ($row = mysqli_fetch_assoc($hasilBantuan)) {
    $labelBantuan[] = $row['nama_bantuan'];
    $jumlahTrans[]  = $row['jumlah'];
}


// Transaksi terbaru
$transaksiTerbaru = mysqli_query($koneksi,"
    SELECT 
        t.id_transaksi,
        b.nama_bantuan,
        p.nama_penerima,
        t.nominal,
        t.tanggal_pembayaran
    FROM bantuanananakyatimuna2_transaksi t
    LEFT JOIN bantuanananakyatimuna2_bantuan b ON b.id_bantuan = t.id_bantuan
    LEFT JOIN bantuanananakyatimuna2_penerima p ON p.id_penerima = t.id_penerima
    ORDER BY t.tanggal_pembayaran DESC
    LIMIT 5
");


// User terbaru
$userTerbaru = mysqli_query($koneksi,"
    SELECT id_user, nama_user, username, role
    FROM bantuanananakyatimuna2_user
    ORDER BY id_user DESC
    LIMIT 5
");


// Include layout
include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebar.php';

?>

<div class="content p-3">
<section class="content">
<div class="container-fluid">

    <!-- STATISTIK -->
    <div class="row">
        <?php
        $stat = [
            ['warna'=>'info',    'jumlah'=>$totalBantuan,   'label'=>'Total Bantuan',   'ikon'=>'gift'],
            ['warna'=>'success', 'jumlah'=>$totalPenerima,  'label'=>'Total Penerima',  'ikon'=>'users'],
            ['warna'=>'warning', 'jumlah'=>$totalAdmin,     'label'=>'Total Admin',     'ikon'=>'user-shield'],
            ['warna'=>'danger',  'jumlah'=>$totalUser,      'label'=>'Total User',      'ikon'=>'user'],
            ['warna'=>'primary', 'jumlah'=>$totalTransaksi, 'label'=>'Total Transaksi', 'ikon'=>'exchange-alt'],
        ];

        foreach ($stat as $s) { ?>
            <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                <div class="small-box bg-<?= $s['warna'] ?> text-white p-3 shadow-sm">
                    <div class="inner">
                        <h3><?= $s['jumlah'] ?></h3>
                        <p><?= $s['label'] ?></p>
                    </div>
                    <div class="icon"><i class="fas fa-<?= $s['ikon'] ?> fa-2x"></i></div>
                </div>
            </div>
        <?php } ?>
    </div>


    <div class="row">

        <!-- Grafik -->
        <div class="col-lg-6 col-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0">Transaksi Berdasarkan Bantuan</h6>
                </div>
                <div class="card-body">
                    <canvas id="grafikBantuan" height="180"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabel -->
        <div class="col-lg-6 col-12">

            <!-- Transaksi Terbaru -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0">Transaksi Terbaru</h6>
                </div>
                <div class="card-body p-2">
                    <table class="table table-sm table-striped mb-0">
                        <thead><tr><th>Penerima</th><th>Bantuan</th><th>Nominal</th><th>Tanggal</th></tr></thead>
                        <tbody>
                        <?php while($t = mysqli_fetch_assoc($transaksiTerbaru)){ ?>
                            <tr>
                                <td><?= htmlspecialchars($t['nama_penerima']) ?></td>
                                <td><?= htmlspecialchars($t['nama_bantuan']) ?></td>
                                <td>Rp <?= number_format($t['nominal'],0,',','.') ?></td>
                                <td><?= date('d/m/Y', strtotime($t['tanggal_pembayaran'])) ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- User Terbaru -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0">User Terbaru</h6>
                </div>
                <div class="card-body p-2">
                    <table class="table table-sm table-striped mb-0">
                        <thead><tr><th>Nama</th><th>Username</th><th>Role</th></tr></thead>
                        <tbody>
                        <?php while($u = mysqli_fetch_assoc($userTerbaru)){ ?>
                            <tr>
                                <td><?= htmlspecialchars($u['nama_user']) ?></td>
                                <td><?= htmlspecialchars($u['username']) ?></td>
                                <td><?= htmlspecialchars($u['role']) ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>
</section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>

<!-- CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('grafikBantuan'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($labelBantuan) ?>,
        datasets: [{
            label: 'Jumlah Transaksi',
            data: <?= json_encode($jumlahTrans) ?>,
            backgroundColor: 'rgba(54,162,235,0.6)',
            borderColor: 'rgba(54,162,235,1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});
</script>
