<?php
include '../koneksi/koneksi.php';

if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];

    // Hapus gambar juga jika perlu (ambil nama gambar dulu)
    $query = mysqli_query($conn, "SELECT cover FROM buku WHERE kode_buku = '$kode'");
    $data = mysqli_fetch_assoc($query);
    if (!empty($data['cover']) && file_exists("../img/buku/" . $data['cover'])) {
        unlink("../img/buku/" . $data['cover']);
    }

    $hapus = mysqli_query($conn, "DELETE FROM buku WHERE kode_buku = '$kode'");
    if ($hapus) {
        echo "<script>alert('Data berhasil dihapus'); window.location='../m_produk.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data'); window.location='../m_produk.php';</script>";
    }
} else {
    echo "<script>alert('Kode tidak ditemukan'); window.location='../m_produk.php';</script>";
}
