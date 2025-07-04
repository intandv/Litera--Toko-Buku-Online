<?php
session_start();
include 'koneksi/koneksi.php'; // ✅ Perbaikan path

if (!isset($_SESSION['kd_cs'])) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}

$kode_cs = $_SESSION['kd_cs'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil & bersihkan input
    $provinsi = mysqli_real_escape_string($conn, trim($_POST['prov']));
    $kota     = mysqli_real_escape_string($conn, trim($_POST['kota']));
    $alamat   = mysqli_real_escape_string($conn, trim($_POST['almt']));
    $kode_pos = mysqli_real_escape_string($conn, trim($_POST['kopos']));

    // Validasi input
    if (empty($provinsi) || empty($kota) || empty($alamat) || empty($kode_pos)) {
        echo "<script>alert('Silakan lengkapi semua data pengiriman.'); window.location='checkout.php?kode_cs=$kode_cs';</script>";
        exit;
    }

    // Ambil data dari keranjang
    $query_keranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kode_cs'");
    if (mysqli_num_rows($query_keranjang) == 0) {
        echo "<script>alert('Keranjang Anda kosong.'); window.location='keranjang.php';</script>";
        exit;
    }

    $total_harga = 0;
    $rincian = [];

    while ($item = mysqli_fetch_assoc($query_keranjang)) {
        $judul  = $item['judul'];
        $qty    = $item['qty'];
        $harga  = $item['harga'];
        $subtotal = $harga * $qty;

        $total_harga += $subtotal;
        $rincian[] = "$judul (x$qty) - Rp " . number_format($subtotal, 0, ',', '.');
    }

    $rincian_pesanan = implode("\n", $rincian);
    $tanggal = date('Y-m-d');

    // Simpan ke tabel pesanan
    $insert = mysqli_query($conn, "INSERT INTO pesanan 
        (kode_customer, tanggal_pesanan, total_harga, status, provinsi, kota, alamat, kode_pos, rincian_pesanan) 
        VALUES 
        ('$kode_cs', '$tanggal', $total_harga, 'Menunggu', '$provinsi', '$kota', '$alamat', '$kode_pos', '$rincian_pesanan')
    ");


$id_pesanan = mysqli_insert_id($conn); // ambil ID pesanan terakhir yang baru saja dimasukkan

$query_keranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kode_cs'");
while ($item = mysqli_fetch_assoc($query_keranjang)) {
    $judul  = $item['judul'];
    $qty    = $item['qty'];
    $harga  = $item['harga'];
    
    mysqli_query($conn, "INSERT INTO pesanan_detail (id_pesanan, kode_buku, judul, qty, harga)
                         VALUES ('$id_pesanan', '{$item['kode_buku']}', '$judul', '$qty', '$harga')");
}


    if ($insert) {
        // Hapus isi keranjang
        mysqli_query($conn, "DELETE FROM keranjang WHERE kode_customer = '$kode_cs'");

        echo "<script>alert('Pesanan berhasil disimpan'); window.location='riwayat_pesanan.php';</script>";
    } else {
        die("Gagal menyimpan pesanan: " . mysqli_error($conn));
    }
}
?>
