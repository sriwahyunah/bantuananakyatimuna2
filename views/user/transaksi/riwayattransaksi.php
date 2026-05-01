<div class="content-wrapper">

    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Transaksi</h1>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <a href="?hal=tambahtransaksi" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Transaksi
                    </a>
                </div>

                <div class="card-body table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Penerima</th>
                                <th>Nama Bantuan</th>
                                <th>Nominal</th>
                                <th>Admin</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Foto Bukti</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($koneksi, "
                                SELECT t.*, p.nama_penerima, b.nama_bantuan, u.nama_user
                                FROM transaksi t
                                JOIN penerima p ON t.id_penerima = p.id_penerima
                                JOIN bantuan b ON t.id_bantuan = b.id_bantuan
                                JOIN user u ON t.id_user = u.id_user
                                ORDER BY t.id_transaksi DESC
                            ");

                            while ($data = mysqli_fetch_assoc($query)) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['nama_penerima'] ?></td>
                                    <td><?= $data['nama_bantuan'] ?></td>
                                    <td>Rp <?= number_format($data['nominal'],0,',','.') ?></td>
                                    <td><?= $data['nama_user'] ?></td>
                                    <td><?= date('d-m-Y', strtotime($data['tanggal_pembayaran'])) ?></td>
                                    <td>
                                        <?php if ($data['foto_bukti']) { ?>
                                            <img src="uploads/<?= $data['foto_bukti'] ?>" width="60">
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="?hal=edittransaksi&id=<?= $data['id_transaksi'] ?>" 
                                           class="btn btn-warning btn-sm">
                                           <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="?hal=prosestransaksi&hapus=<?= $data['id_transaksi'] ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Yakin ingin hapus?')">
                                           <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </section>

</div>
