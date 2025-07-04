<?php 
session_start();
include 'koneksi/koneksi.php';
include 'header.php';

// Pastikan user sudah login
if (!isset($_SESSION['kd_cs'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}

$kd = mysqli_real_escape_string($conn, $_SESSION['kd_cs']);

// Ambil data customer
$cs = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '$kd'");
$rows = mysqli_fetch_assoc($cs);

// Ambil data keranjang customer
$result = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kd'");

$no = 1;
$hasil = 0;
$rincian = [];

?>

<div class="container" style="padding-bottom: 200px">
    <h2 style="width: 100%; border-bottom: 4px solid #ff8680"><b>Checkout</b></h2>
    
    <div class="row">
        <div class="col-md-6">
            <h4>Daftar Pesanan</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Buku</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if (mysqli_num_rows($result) > 0):
                    while($row = mysqli_fetch_assoc($result)):
                        $total = $row['harga'] * $row['qty'];
                        $hasil += $total;
                        // Susun rincian untuk nanti disimpan di tabel pesanan_detail
                        $rincian[] = [
                            'kode_buku' => $row['kode_buku'],
                            'judul' => $row['judul'],
                            'harga' => $row['harga'],
                            'qty' => $row['qty']
                        ];
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['judul']); ?></td>
                        <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td><?= $row['qty']; ?></td>
                        <td>Rp<?= number_format($total, 0, ',', '.'); ?></td>
                    </tr>
                <?php endwhile; ?>
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Grand Total = Rp<?= number_format($hasil, 0, ',', '.'); ?></td>
                    </tr>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center text-danger">Keranjang kosong.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (!empty($rincian)): ?>
    <div class="row mt-4">
        <div class="col-md-6 bg-success text-white p-2 rounded">
            <h5>Pastikan Pesanan Anda Sudah Benar</h5>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-6 bg-warning p-2 rounded">
            <h5>Isi Form di bawah ini</h5>
        </div>
    </div>

    <form action="order.php" method="POST" class="mt-3">
        <input type="hidden" name="kode_cs" value="<?= htmlspecialchars($kd); ?>">
        <input type="hidden" name="total" value="<?= $hasil; ?>">
        <!-- Kirimkan rincian dalam format JSON supaya mudah di-decode di proses_order.php -->
        <input type="hidden" name="rincian" value='<?= json_encode($rincian, JSON_HEX_APOS | JSON_HEX_QUOT); ?>'>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Provinsi</label>
                <input type="text" class="form-control" name="prov" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Kota</label>
                <input type="text" class="form-control" name="kota" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Alamat</label>
                <input type="text" class="form-control" name="almt" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Kode Pos</label>
                <input type="text" class="form-control" name="kopos" required>
            </div>
        </div>

        <button type="submit" class="btn btn-success"><i class="bi bi-cart-check"></i> Order Sekarang</button>
        <a href="keranjang.php" class="btn btn-danger">Cancel</a>
    </form>
    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>
