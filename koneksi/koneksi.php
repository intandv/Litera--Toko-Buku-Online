<?php 
// Konfigurasi database
$host = "localhost";
$username = "root";
$password = "";
$database_name = "db_buku";
$port = 3308;

// Koneksi ke server **langsung pilih database**
$conn = mysqli_connect($host, $username, $password, $database_name,$port);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


