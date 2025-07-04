<?php
session_start();
include 'koneksi/koneksi.php';
include 'header.php';

if (!isset($_SESSION['kd_cs'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}

$kode_cs = $_SESSION['kd_cs'];

// Ambil data pesanan customer
$query = mysqli_query($conn, "SELECT * FROM pesanan WHERE kode_customer = '$kode_cs' ORDER BY id_pesanan DESC");
?>

<div class="container" style="padding-bottom: 200px">
   <h2 class="text-center text-success fw-bold" style="width: 100%; border-bottom: 4px solid #28a745;">
    <b>Riwayat Pesanan</b>
</h2>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-success">
            <tr>
                <th>No</th>
                <th>No Pesanan</th>
                <th>Tanggal</th>
                <th>Rincian Pesanan</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $id_pesanan = $row['id_pesanan'];
                    // Ambil detail pesanan
                    $detailQuery = mysqli_query($conn, "SELECT * FROM pesanan_detail WHERE id_pesanan = $id_pesanan");

                    $rincian = "";
                    while ($detail = mysqli_fetch_assoc($detailQuery)) {
                        $subtotal = $detail['harga'] * $detail['qty'];
                        $rincian .= htmlspecialchars($detail['judul']) 
                                   . " x " . $detail['qty'] 
                                   . " (Rp" . number_format($detail['harga'], 0, ',', '.') . ")"
                                   . " = Rp" . number_format($subtotal, 0, ',', '.') 
                                   . "\n";
                    }
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><a href="detail_pesanan.php?id=<?= $id_pesanan; ?>"><?= $id_pesanan; ?></a></td>
                    <td><?= date('d-m-Y', strtotime($row['tanggal_pesanan'])); ?></td>
                    <td><pre style="white-space: pre-wrap;"><?= $rincian; ?></pre></td>
                    <td>Rp<?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Belum ada riwayat pesanan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?> 