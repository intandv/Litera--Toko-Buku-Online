<?php 
include 'header.php';
include 'koneksi/koneksi.php';

if (isset($_POST['submit1'])) {
    $id_keranjang = $_POST['id'];
    $qty = $_POST['qty'];

    $edit = mysqli_query($conn, "UPDATE keranjang SET qty = '$qty' WHERE id_keranjang = '$id_keranjang'");
    if ($edit) {
        echo "<script>alert('Keranjang berhasil diperbarui'); window.location='keranjang.php';</script>";
    }
} elseif (isset($_GET['del'])) {
    $id_keranjang = $_GET['id'];
    $del = mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang'");
    if ($del) {
        echo "<script>alert('1 produk dihapus'); window.location='keranjang.php';</script>";
    }
}
?>

<div class="container" style="padding-bottom: 300px;">
    <h2 style="width: 100%; border-bottom: 4px solid #ff8680;"><b>Keranjang</b></h2>
    <table class="table table-striped">
        <?php 
        if (isset($_SESSION['user']) && isset($_SESSION['kd_cs'])) {
            $kode_cs = $_SESSION['kd_cs'];
            $cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kode_cs'");
            $jml = mysqli_num_rows($cek);

            if ($jml > 0) {
        ?>
        <thead>
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Judul Buku</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>SubTotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $result = mysqli_query($conn, "SELECT 
                k.id_keranjang AS keranjang, 
                k.kode_buku, 
                k.qty, 
                k.harga, 
                b.judul, 
                b.cover 
                FROM keranjang k 
                JOIN buku b ON k.kode_buku = b.kode_buku 
                WHERE k.kode_customer = '$kode_cs'");

            $no = 1;
            $hasil = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $sub = $row['harga'] * $row['qty'];
                $hasil += $sub;
            ?>
            <tr>
                <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" name="id" value="<?= $row['keranjang']; ?>">
                    <th><?= $no++; ?></th>
                    <td><img src="img/buku/<?= htmlspecialchars($row['cover']); ?>" width="100"></td>
                    <td><?= htmlspecialchars($row['judul']); ?></td>
                    <td>Rp.<?= number_format($row['harga']); ?></td>
                    <td><input type="number" name="qty" class="form-control text-center" value="<?= $row['qty']; ?>" min="1"></td>
                    <td>Rp.<?= number_format($sub); ?></td>
                    <td>
                        <button type="submit" name="submit1" class="btn btn-warning btn-sm">Update</button>
                        <a href="keranjang.php?del=1&id=<?= $row['keranjang']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin dihapus?')">Delete</a>
                    </td>
                </form>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="7" class="text-end fw-bold">Grand Total = Rp.<?= number_format($hasil); ?></td>
            </tr>
            <tr>
                <td colspan="7" class="text-end">
                    <a href="index.php" class="btn btn-success">Lanjutkan Belanja</a>
                    <a href="checkout.php?kode_cs=<?= $kode_cs; ?>" class="btn btn-primary">Checkout</a>
                </td>
            </tr>
        </tbody>
        <?php 
            } else {
                echo "<tr><td colspan='7' class='text-center bg-warning'><h5><b>KERANJANG BELANJA ANDA KOSONG</b></h5></td></tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='text-center bg-danger'><h5><b>SILAHKAN LOGIN TERLEBIH DAHULU SEBELUM BERBELANJA</b></h5></td></tr>";
        }
        ?>
    </table>
</div>

<?php include 'footer.php'; ?>
