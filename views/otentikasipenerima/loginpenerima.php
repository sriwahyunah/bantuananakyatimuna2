<?php
// ============================================================
// File: views/otentikasipenerima/loginpenerima.php
// Login aplikasi bantuananakyatimuna2 untuk role penerima
// ============================================================

// Include path dan konfigurasi
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

// Mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['role']) && $_SESSION['role'] === 'penerima') {
    header("Location: " . BASE_URL . "?hal=dashboardpenerima");
    exit();
}

// Ambil pesan error jika ada
$error = $_GET['pesan'] ?? '';
?>

<style>
  .login-wrapper {
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

<div class="login-wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg border-0">

          <!-- HEADER -->
          <div class="card-header bg-primary text-center py-3">
            <h3 class="m-0 fw-bold">Login Penerima Bantuan</h3>
          </div>

          <div class="card-body p-4">

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="?hal=prosesloginpenerima">
              <div class="mb-3">
                <label for="username" class="form-label">Username / NIS</label>
                <input type="text" name="username" id="username" class="form-control" required>
              </div>

              <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
              </div>

              <div class="d-flex justify-content-between mb-3">
                <a href="<?= BASE_URL ?>?hal=registerpenerima"
                  class="btn btn-warning px-4">
                  <b>Daftar Akun Baru</b>
                </a>
                <button type="submit" class="btn btn-primary px-4">Login</button>
              </div>
            </form>

            <div class="text-center mt-1">
              <a href="<?= BASE_URL ?>">← Kembali ke Beranda</a>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function togglePassword() {
    const pass = document.getElementById('password');
    pass.type = pass.type === 'password' ? 'text' : 'password';
  }
</script>
