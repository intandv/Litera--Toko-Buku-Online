<?php
include 'header.php';
include '../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_buku = $_POST['kode_buku'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];  // disesuaikan dengan nama kolom di DB
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $penerbit = $_POST['penerbit'];


    // Cek apakah file gambar diupload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        
        // Bisa tambahkan validasi tipe file dan ukuran di sini jika perlu
        
        // Pindahkan file ke folder tujuan
        move_uploaded_file($tmp, "../img/buku/$image");
    } else {
        $image = NULL;  // Jika gambar tidak diupload
    }

    $insert = mysqli_query($conn, "INSERT INTO buku (kode_buku, judul, penulis, penerbit, harga, deskripsi, cover) 
                                   VALUES ('$kode_buku', '$judul', '$penulis', '$penerbit', '$harga', '$deskripsi', '$image')");

    if ($insert) {
        echo "<script>alert('Data berhasil ditambahkan'); window.location='m_produk.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<div class="container">
    <h2><b>Tambah Buku</b></h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Kode Buku</label>
            <input type="text" name="kode_buku" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Penulis</label>
            <input type="text" name="penulis" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Penerbit</label>
            <input type="text" name="penerbit" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" name="deskripsi" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <br>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="m_produk.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
