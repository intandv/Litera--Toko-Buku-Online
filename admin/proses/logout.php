<?php 
session_start();
session_destroy();

// Setelah logout admin, kembali ke halaman awal website
header('Location: ../../index.php');
exit;
?>
