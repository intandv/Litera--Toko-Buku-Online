<?php  
include 'header.php';  

// Set default tanggal (hari ini)
$today = date('Y-m-d');
$date1 = $date2 = $today;  

// Jika form di-submit, ambil tanggal dari form
if (isset($_POST['submit']) && !empty($_POST['date1']) && !empty($_POST['date2'])) {     
    $date1 = $_POST['date1'];     
    $date2 = $_POST['date2']; 
    
    // Validasi tanggal
    if ($date1 > $date2) {
        $temp = $date1;
        $date1 = $date2;
        $date2 = $temp;
        $date_swapped = true;
    }
} 
?> 

<style type="text/css"> 
    @media print{ 
        .print{ 
            display: none; 
        }
        .container {
            max-width: none !important;
            padding: 0 !important;
        }
        .table {
            font-size: 12px;
        }
    } 
    
    .report-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .filter-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        border: 1px solid #e9ecef;
    }
    
    .date-filter-table {
        width: 100%;
    }
    
    .date-filter-table td {
        padding: 5px;
        vertical-align: middle;
    }
    
    .export-buttons {
        text-align: right;
    }
    
    .export-buttons .btn {
        margin-left: 10px;
        margin-bottom: 10px;
    }
    
    .table-responsive {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table thead th {
        background: #495057;
        color: white;
        border: none;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }
    
    .table tbody td {
        vertical-align: middle;
        border-color: #e9ecef;
    }
    
    .rincian-pesanan {
        max-width: 300px;
        white-space: pre-wrap;
        word-wrap: break-word;
        font-family: Arial, sans-serif;
        font-size: 12px;
        line-height: 1.4;
    }
    
    .total-row {
        background: #e8f5e8;
        font-weight: bold;
        border-top: 2px solid #28a745;
    }
    
    .no-data {
        text-align: center;
        padding: 50px;
        color: #6c757d;
        font-style: italic;
    }
    
    .btn-custom {
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 500;
    }
    
    .summary-card {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    @media (max-width: 768px) {
        .export-buttons {
            text-align: left;
            margin-top: 15px;
        }
        
        .table {
            font-size: 12px;
        }
        
        .rincian-pesanan {
            max-width: 200px;
            font-size: 11px;
        }
    }
</style>  

<div class="container"> 
    <!-- Header Laporan -->
    <div class="report-header text-center">
        <h2 class="mb-0"><i class="glyphicon glyphicon-stats"></i> Laporan Penjualan</h2>
        <?php if (isset($_POST['submit'])) { ?>
            <p class="mb-0 mt-2">Periode: <?= date('d-m-Y', strtotime($date1)); ?> s/d <?= date('d-m-Y', strtotime($date2)); ?></p>
            <?php if (isset($date_swapped)) { ?>
                <small class="text-warning"><i class="glyphicon glyphicon-info-sign"></i> Tanggal telah diurutkan otomatis</small>
            <?php } ?>
        <?php } else { ?>
            <p class="mb-0 mt-2">Silakan pilih periode untuk menampilkan laporan</p>
        <?php } ?>
    </div>

    <!-- Filter Section --> 
    <div class="filter-section print"> 
        <div class="row"> 
            <div class="col-md-8"> 
                <h4 class="mb-3"><i class="glyphicon glyphicon-filter"></i> Filter Tanggal</h4>
                <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST"> 
                    <table class="date-filter-table"> 
                        <tr> 
                            <td width="200px">
                                <label class="form-label">Tanggal Mulai:</label>
                                <input type="date" name="date1" class="form-control" value="<?= $date1; ?>" required>
                            </td> 
                            <td width="50px" class="text-center">
                                <label class="form-label">&nbsp;</label><br>
                                <strong>s/d</strong>
                            </td> 
                            <td width="200px">
                                <label class="form-label">Tanggal Akhir:</label>
                                <input type="date" name="date2" class="form-control" value="<?= $date2; ?>" required>
                            </td> 
                            <td width="120px">
                                <label class="form-label">&nbsp;</label><br>
                                <button type="submit" name="submit" class="btn btn-primary btn-custom">
                                    <i class="glyphicon glyphicon-search"></i> Tampilkan
                                </button>
                            </td> 
                        </tr> 
                    </table> 
                </form> 
            </div>  

            <!-- Export dan Cetak --> 
            <div class="col-md-4"> 
                <h4 class="mb-3"><i class="glyphicon glyphicon-export"></i> Export Data</h4>
                <div class="export-buttons">
                    <form action="exp_penjualan.php" method="POST" style="display: inline;"> 
                        <input type="hidden" name="date1" value="<?= $date1; ?>"> 
                        <input type="hidden" name="date2" value="<?= $date2; ?>"> 
                        <button type="submit" class="btn btn-success btn-custom"> 
                            <i class="glyphicon glyphicon-save-file"></i> Export Excel 
                        </button> 
                    </form>
                    <a href="javascript:void(0)" onclick="window.print()" class="btn btn-default btn-custom"> 
                        <i class="glyphicon glyphicon-print"></i> Cetak 
                    </a> 
                </div>
            </div> 
        </div> 
    </div>  

    <!-- Data Penjualan --> 
    <?php if (isset($_POST['submit']) && !empty($_POST['date1']) && !empty($_POST['date2'])) { 
        // Escape input untuk keamanan
        $date1_safe = mysqli_real_escape_string($conn, $date1);
        $date2_safe = mysqli_real_escape_string($conn, $date2);
        
        // Query dengan kondisi tanggal yang tepat
        $query = "SELECT * FROM pesanan 
                  WHERE DATE(tanggal_pesanan) BETWEEN '$date1_safe' AND '$date2_safe' 
                  ORDER BY tanggal_pesanan DESC";
        
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            die("Error dalam query: " . mysqli_error($conn));
        }
        
        $total_records = mysqli_num_rows($result);
        $no = 1; 
        $grand_total = 0; 
    ?>
    
    <!-- Summary Card -->
    <div class="summary-card">
        <div class="row">
            <div class="col-md-6">
                <h5><i class="glyphicon glyphicon-calendar"></i> Periode Laporan</h5>
                <p class="mb-0"><?= date('d F Y', strtotime($date1)); ?> - <?= date('d F Y', strtotime($date2)); ?></p>
                <?php 
                $date_diff = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24) + 1;
                echo "<small class='text-muted'>($date_diff hari)</small>";
                ?>
            </div>
            <div class="col-md-6 text-right">
                <h5><i class="glyphicon glyphicon-list-alt"></i> Total Transaksi</h5>
                <p class="mb-0"><strong><?= $total_records; ?> transaksi</strong></p>
                <?php if ($total_records > 0) { 
                    $avg_per_day = round($total_records / $date_diff, 1);
                    echo "<small class='text-muted'>Rata-rata: $avg_per_day transaksi/hari</small>";
                } ?>
            </div>
        </div>
    </div>

    <div class="table-responsive"> 
        <table class="table table-striped table-hover"> 
            <thead> 
                <tr> 
                    <th width="5%">No</th> 
                    <th width="15%">Tanggal</th> 
                    <th width="60%">Rincian Pesanan</th> 
                    <th width="20%">Total Harga</th> 
                </tr> 
            </thead> 
            <tbody> 
            <?php 
            if ($total_records > 0) {
                while ($row = mysqli_fetch_assoc($result)) { 
                    $grand_total += $row['total_harga']; 
            ?> 
                <tr> 
                    <td class="text-center"><?= $no++; ?></td> 
                    <td>
                        <?php 
                        // Format tanggal dengan lebih flexible
                        $tanggal = $row['tanggal_pesanan'];
                        if (strlen($tanggal) > 10) {
                            // Jika format datetime (YYYY-MM-DD HH:MM:SS)
                            echo date('d-m-Y H:i', strtotime($tanggal));
                        } else {
                            // Jika format date (YYYY-MM-DD)
                            echo date('d-m-Y', strtotime($tanggal));
                        }
                        ?>
                    </td> 
                    <td>
                        <div class="rincian-pesanan"><?= htmlspecialchars($row['rincian_pesanan']); ?></div>
                    </td> 
                    <td class="text-right">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td> 
                </tr> 
            <?php } ?>
                <tr class="total-row"> 
                    <td colspan="3" class="text-right"><strong><i class="glyphicon glyphicon-usd"></i> TOTAL PENJUALAN:</strong></td> 
                    <td class="text-right"><strong>Rp <?= number_format($grand_total, 0, ',', '.'); ?></strong></td> 
                </tr> 
            <?php } else { ?>
                <tr>
                    <td colspan="4" class="no-data">
                        <i class="glyphicon glyphicon-info-sign"></i><br>
                        Tidak ada data penjualan pada periode<br>
                        <strong><?= date('d-m-Y', strtotime($date1)); ?> s/d <?= date('d-m-Y', strtotime($date2)); ?></strong>
                    </td>
                </tr>
            <?php } ?>
            </tbody> 
        </table> 
    </div>
    
    <?php } else { ?>
    <div class="summary-card text-center">
        <i class="glyphicon glyphicon-info-sign" style="font-size: 48px; color: #6c757d;"></i>
        <h4 class="mt-3">Silakan pilih periode tanggal untuk menampilkan laporan</h4>
        <p class="text-muted">Gunakan filter tanggal di atas untuk melihat data penjualan</p>
    </div>
    <?php } ?>
</div>  

<br><br>
<?php include 'footer.php'; ?>