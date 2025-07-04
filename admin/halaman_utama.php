<?php 
include 'header.php';

// Ambil jumlah pesanan berdasarkan status di tabel pesanan
// Status: Menunggu, Dibatalkan, Diterima

$result1 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pesanan WHERE status = 'Menunggu'");
$data1 = mysqli_fetch_assoc($result1);
$jml1 = $data1['total'];

$result2 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pesanan WHERE status = 'Dibatalkan'");
$data2 = mysqli_fetch_assoc($result2);
$jml2 = $data2['total'];

$result3 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pesanan WHERE status = 'Diterima'");
$data3 = mysqli_fetch_assoc($result3);
$jml3 = $data3['total'];
?>

<div class="container">
    <div class="row">
        <!-- PESANAN BARU -->
        <div class="col-md-4">
            <div style="background-color: #dfdfdf; padding: 20px;">
                <h4>PESANAN BARU</h4>
                <h4 style="font-size: 56pt;"><b><?= $jml1; ?></b></h4>
            </div>
        </div>

        <!-- PESANAN DIBATALKAN -->
        <div class="col-md-4">
            <div style="background-color: #dfdfdf; padding: 20px;">
                <h4>PESANAN DIBATALKAN</h4>
                <h4 style="font-size: 56pt;"><b><?= $jml2; ?></b></h4>
            </div>
        </div>

        <!-- PESANAN DITERIMA -->
        <div class="col-md-4">
            <div style="background-color: #dfdfdf; padding: 20px;">
                <h4>PESANAN DITERIMA</h4>
                <h4 style="font-size: 56pt;"><b><?= $jml3; ?></b></h4>
            </div>
        </div>
    </div>
</div>

<br><br><br><br><br>

<?php include 'footer.php'; ?>
