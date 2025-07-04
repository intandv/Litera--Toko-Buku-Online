<?php 
include 'header.php';

$date = date('Y-m-d'); // FORMAT YYYY-MM-DD

$date1 = $date;
$date2 = $date;

if (isset($_POST['submit'])) {
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
}
?>
<style type="text/css">
    @media print {
        .print {
            display: none;
        }
    }
</style>

<div class="container">
    <h2 style="width: 100%; border-bottom: 4px solid gray; padding-bottom: 5px;"><b>Laporan Pembatalan Pesanan</b></h2>

    <!-- Filter Tanggal -->
    <div class="row print">
        <div class="col-md-9">
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <table>
                    <tr>
                        <td><input type="date" name="date1" class="form-control" value="<?= $date1; ?>"></td>
                        <td>&nbsp; - &nbsp;</td>
                        <td><input type="date" name="date2" class="form-control" value="<?= $date2; ?>"></td>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="submit" class="btn btn-primary" value="Tampilkan"></td>
                    </tr>
                </table>
            </form>
        </div>

        <!-- Tombol Export dan Cetak -->
        <div class="col-md-3">
            <form action="exp_pembatalan.php" method="POST">
                <input type="hidden" name="date1" value="<?= $date1; ?>">
                <input type="hidden" name="date2" value="<?= $date2; ?>">
                <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save-file"></i> Export to Excel</button>
                &nbsp;
                <a href="#" onclick="window.print()" class="btn btn-default"><i class="glyphicon glyphicon-print"></i> Cetak</a>
            </form>
        </div>
    </div>

    <br><br>

    <!-- Tabel Laporan -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Rincian Pesanan</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (isset($_POST['submit'])) {
                $query = mysqli_query($conn, "
                    SELECT p.*, c.nama 
                    FROM pesanan p
                    JOIN customer c ON p.kode_customer = c.kode_customer
                    WHERE p.status = 'Dibatalkan'
                    AND p.tanggal_pesanan BETWEEN '$date1' AND '$date2'
                    ORDER BY p.tanggal_pesanan DESC
                ");

                $no = 1;
                $grand_total = 0;
                while ($row = mysqli_fetch_assoc($query)) {
                    $grand_total += $row['total_harga'];
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><pre style="margin:0; font-size:14px"><?= $row['rincian_pesanan']; ?></pre></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_pesanan'])); ?></td>
                        <td>Rp<?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Total Pembatalan</td>
                    <td class="fw-bold text-danger">Rp<?= number_format($grand_total, 0, ',', '.'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<br><br><br>
<?php include 'footer.php'; ?>
