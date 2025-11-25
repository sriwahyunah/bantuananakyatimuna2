<?php
session_start();
unset($_SESSION['id_penerima']);
unset($_SESSION['nik']);
unset($_SESSION['nama_penerima']);
unset($_SESSION['foto_penerima']);

session_destroy();

header("Location: ?hal=loginpenerima");
exit;
