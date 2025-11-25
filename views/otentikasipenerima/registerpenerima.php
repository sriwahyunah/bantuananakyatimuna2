<?php
// ============================================================
// File: views/otentikasipenerima/registerpenerima.php
// Form pendaftaran data penerima
// ============================================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_GET['pesan'] ?? '';
?>

<style>
.register-wrapper {
    min-height: calc(100vh - 100px);
    display: flex;
    justify-content: center;
    align-items: center;
}
.toggle-password {
    position: absolute;
    right: 15px;
    top: 38px;
    cursor: pointer;
    color: #777;
}
</style>

<div class="register-wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg border-0">
          <div class="card-body p-4">
            <h3 class="text-center mb-4">Form Registrasi Penerima</h3>

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="?hal=prosesregisterpenerima" enctype="multipart/form-data">

              <div class="mb-3">
                <label for="nisp" class="form-label">NISP</label>
                <input type="text" name="nisp" id="nisp" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="nama_penerima" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_penerima" id="nama_penerima" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" name="kelas" id="kelas" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" required></textarea>
              </div>

              <div class="mb-3">
                <label for="pendapatan_orang_tua" class="form-label">Pendapatan Orang Tua</label>
                <input type="number" name="pendapatan_orang_tua" id="pendapatan_orang_tua" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
              </div>

              <input type="hidden" name="status" value="pending">

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
              </div>

            </form>

            <div class="text-center mt-3">
              <a href="?hal=dashboardadmin">← Kembali</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
