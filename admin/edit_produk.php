<?php
include 'header.php';
include '../koneksi/koneksi.php';

$kode = $_GET['kode'];
$data = mysqli_query($conn, "SELECT * FROM buku WHERE kode_buku = '$kode'");
$row = mysqli_fetch_assoc($data);

if (!$row) {
    echo "<script>alert('Data tidak ditemukan'); window.location='m_produk.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $harga = $_POST['harga'];

    if ($_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../img/buku/$image");
    } else {
        $image = $row['cover'];
    }

    $update = mysqli_query($conn, "UPDATE buku SET judul='$judul', penulis='$penulis', harga='$harga', cover='$image' WHERE kode_buku='$kode'");
    if ($update) {
        echo "<script>alert('Berhasil diupdate'); window.location='m_produk.php';</script>";
    } else {
        echo "<script>alert('Gagal update');</script>";
    }
}
?>

<div class="container">
    <h2>Edit Produk</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Kode Buku</label>
            <input type="text" class="form-control" value="<?= $row['kode_buku']; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= $row['judul']; ?>" required>
        </div>
        <div class="form-group">
            <label>Penulis</label>
            <input type="text" name="penulis" class="form-control" value="<?= $row['penulis']; ?>" required>
        </div>
        <div class="form-group">
            <label>Penerbit</label>
            <input type="text" name="penerbit" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="<?= $row['harga']; ?>" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" name="deskripsi" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Ganti Cover (opsional)</label>
            <input type="file" name="image" class="form-control">
            <img src="../img/buku/<?= $row['cover']; ?>" width="80">
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="m_produk.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
