<?php
session_start();
include 'koneksi/koneksi.php';

if (!isset($_SESSION['kd_cs'])) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID pesanan tidak ditemukan'); window.location='riwayat_pesanan.php';</script>";
    exit;
}

$id_pesanan = (int)$_GET['id'];
$kode_cs = $_SESSION['kd_cs'];

// Cek pesanan milik user dan statusnya "Diproses"
$cek = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan = $id_pesanan AND kode_customer = '$kode_cs' AND status_pesanan = 'Diproses'");

if (mysqli_num_rows($cek) == 0) {
    echo "<script>alert('Pesanan tidak ditemukan, bukan milik Anda, atau tidak bisa dibatalkan'); window.location='riwayat_pesanan.php';</script>";
    exit;
}

// Update status pesanan menjadi Dibatalkan
$update = mysqli_query($conn, "UPDATE pesanan SET status_pesanan = 'Dibatalkan' WHERE id_pesanan = $id_pesanan");

if ($update) {
    echo "<script>alert('Pesanan berhasil dibatalkan'); window.location='riwayat_pesanan.php';</script>";
} else {
    echo "<script>alert('Gagal membatalkan pesanan'); window.location='riwayat_pesanan.php';</script>";
}
