<?php 
include 'header.php';
include 'koneksi/koneksi.php';

$kode = isset($_GET['produk']) ? mysqli_real_escape_string($conn, $_GET['produk']) : '';

if (empty($kode)) {
    echo "<div class='container'><div class='alert alert-danger'>Kode buku tidak ditemukan di URL.</div></div>";
    include 'footer.php';
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM buku WHERE kode_buku = '$kode'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<div class='container'><div class='alert alert-danger'>Buku tidak ditemukan!</div></div>";
    include 'footer.php';
    exit;
}
?>

<div class="container">
    <h2 style="width: 100%; border-bottom: 4px solid #ff8680"><b>Detail Produk</b></h2>

    <div class="row">
        <div class="col-md-4">
            <div class="thumbnail">
                <img src="img/buku/<?= $row['cover']; ?>" width="400" class="img-fluid">
            </div>
        </div>

        <div class="col-md-8">
            <form action="add.php" method="POST">
                <input type="hidden" name="kode_buku" value="<?= $row['kode_buku']; ?>">

                <?php if (isset($_SESSION['kd_cs'])): ?>
                    <input type="hidden" name="kode_customer" value="<?= $_SESSION['kd_cs']; ?>">
                <?php endif; ?>

                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td><b>Judul</b></td>
                            <td><?= htmlspecialchars($row['judul']); ?></td>
                        </tr>
                        <tr>
                            <td><b>Penulis</b></td>
                            <td><?= htmlspecialchars($row['penulis']); ?></td>
                        </tr>
                        <tr>
                            <td><b>Penerbit</b></td>
                            <td><?= htmlspecialchars($row['penerbit']); ?></td>
                        </tr>
                        <tr>
                            <td><b>Harga</b></td>
                            <td>Rp.<?= number_format($row['harga']); ?></td>
                        </tr>
                        <tr>
                            <td><b>Deskripsi</b></td>
                            <td><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
                        </tr>
                        <tr>
                            <td><b>Jumlah</b></td>
                            <td><input class="form-control" type="number" min="1" name="jml" value="1" style="width: 155px;" required></td>
                        </tr>
                    </tbody>
                </table>

                <?php if (isset($_SESSION['user'])): ?>
                    <button type="submit" class="btn btn-success">
                        <i class="glyphicon glyphicon-shopping-cart"></i> Tambahkan ke Keranjang
                    </button>
                <?php else: ?>
                    <a href="user_login.php" class="btn btn-danger" onclick="return confirm('Silakan login terlebih dahulu untuk belanja.')">
                        <i class="glyphicon glyphicon-user"></i> Login untuk Belanja
                    </a>
                <?php endif; ?>
                <a href="index.php" class="btn btn-warning">Kembali Belanja</a>
            </form>
        </div>
    </div>
</div>

<br><br>

<?php include 'footer.php'; ?>
