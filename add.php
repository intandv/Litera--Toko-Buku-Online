<?php
session_start();
include 'koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Akses tidak valid'); window.location='index.php';</script>";
    exit;
}

if (!isset($_SESSION['kd_cs'])) {
    echo "<script>alert('Anda belum login'); window.location='login.php';</script>";
    exit;
}

if (!isset($_POST['kode_buku'])) {
    echo "<script>alert('Data tidak lengkap'); window.location='index.php';</script>";
    exit;
}

$kode_customer = mysqli_real_escape_string($conn, $_SESSION['kd_cs']);
$kode_buku = mysqli_real_escape_string($conn, $_POST['kode_buku']);
$qty = max(1, (int)($_POST['jml'] ?? 1));

$buku = mysqli_query($conn, "SELECT judul, harga FROM buku WHERE kode_buku = '$kode_buku'");
if (!$buku || mysqli_num_rows($buku) === 0) {
    echo "<script>alert('Buku tidak ditemukan'); window.location='index.php';</script>";
    exit;
}

$data = mysqli_fetch_assoc($buku);
$judul = mysqli_real_escape_string($conn, $data['judul']);
$harga = (int)$data['harga'];

$cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kode_customer' AND kode_buku = '$kode_buku'");
if (mysqli_num_rows($cek) > 0) {
    mysqli_query($conn, "UPDATE keranjang SET qty = qty + $qty WHERE kode_customer = '$kode_customer' AND kode_buku = '$kode_buku'");
} else {
    mysqli_query($conn, "INSERT INTO keranjang (kode_customer, kode_buku, judul, qty, harga) VALUES ('$kode_customer', '$kode_buku', '$judul', $qty, $harga)");
}

echo "<script>alert('Produk berhasil ditambahkan ke keranjang'); window.location='keranjang.php';</script>";
