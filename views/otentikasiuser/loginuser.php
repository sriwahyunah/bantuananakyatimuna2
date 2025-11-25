<?php
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login, redirect
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'petugas') {
        header("Location: ?hal=dashboardpetugas");
        exit;
    } elseif ($_SESSION['role'] === 'penerima') {
        header("Location: ?hal=dashboardpenerima");
        exit;
    }
}

$error = $_GET['pesan'] ?? '';
?>

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">Login User</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="?hal=prosesloginuser" method="POST">

        <div class="mb-3">
            <label>Email / Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <div class="text-center mt-3">
        <a href="?hal=registeruser">Belum punya akun? Register</a>
    </div>
</div>
