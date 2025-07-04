<?php  
include 'header.php'; 
include '../koneksi/koneksi.php'; 
?>

<style type="text/css">
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px 0;
        margin-bottom: 30px;
        border-radius: 0 0 20px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .stats-cards {
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 1px solid #e9ecef;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .stat-icon {
        font-size: 3rem;
        margin-bottom: 10px;
        color: #667eea;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: #7f8c8d;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 1px solid #e9ecef;
    }
    
    .table-header {
        background: #f8f9fa;
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .table thead th {
        background: #495057;
        color: white;
        border: none;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
        padding: 15px 10px;
        font-size: 0.9rem;
    }
    
    .table tbody td {
        vertical-align: middle;
        padding: 15px 10px;
        border-color: #e9ecef;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    
    .status-proses {
        background: #cce5ff;
        color: #004085;
        border: 1px solid #74b9ff;
    }
    
    .status-selesai {
        background: #d4edda;
        color: #155724;
        border: 1px solid #00b894;
    }
    
    .status-dibatalkan {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #e17055;
    }
    
    .rincian-pesanan {
        max-width: 300px;
        max-height: 100px;
        overflow-y: auto;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
        font-size: 0.85rem;
        line-height: 1.4;
        white-space: pre-wrap;
        word-wrap: break-word;
        border: 1px solid #e9ecef;
    }
    
    .alamat-cell {
        max-width: 250px;
        font-size: 0.9rem;
        line-height: 1.4;
    }
    
    .customer-name {
        font-weight: 600;
        color: #2c3e50;
    }
    
    .price-cell {
        font-weight: 600;
        color: #27ae60;
        font-size: 1rem;
    }
    
    .date-cell {
        font-size: 0.9rem;
        color: #5a6c7d;
    }
    
    .no-data {
        text-align: center;
        padding: 50px;
        color: #6c757d;
    }
    
    .search-filter {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid #e9ecef;
    }
    
    .btn-filter {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 10px 25px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .table-responsive {
        border-radius: 0 0 15px 15px;
    }
    
    @media (max-width: 768px) {
        .table {
            font-size: 0.8rem;
        }
        
        .rincian-pesanan {
            max-width: 200px;
            font-size: 0.75rem;
        }
        
        .alamat-cell {
            max-width: 150px;
            font-size: 0.8rem;
        }
        
        .stat-card {
            margin-bottom: 15px;
        }
    }
</style>

<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0"><i class="glyphicon glyphicon-shopping-cart"></i> Data Pesanan Customer</h1>
                <p class="mb-0 mt-2">Kelola dan pantau semua pesanan pelanggan</p>
            </div>
            <div class="col-md-4 text-right">
                <div class="text-white">
                    <small>Terakhir diupdate: <?= date('d M Y, H:i'); ?></small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <?php
    // Ambil statistik pesanan
    $total_pesanan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pesanan"));
    $pesanan_hari_ini = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pesanan WHERE DATE(tanggal_pesanan) = CURDATE()"));
    $total_pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_harga) as total FROM pesanan WHERE status != 'dibatalkan'"))['total'];
    $customer_aktif = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT kode_customer FROM pesanan WHERE DATE(tanggal_pesanan) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)"));
    ?>
    
    <!-- Statistics Cards -->
    <div class="stats-cards">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-list-alt"></i>
                    </div>
                    <div class="stat-number"><?= number_format($total_pesanan); ?></div>
                    <div class="stat-label">Total Pesanan</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </div>
                    <div class="stat-number"><?= number_format($pesanan_hari_ini); ?></div>
                    <div class="stat-label">Pesanan Hari Ini</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-usd"></i>
                    </div>
                    <div class="stat-number">Rp<?= number_format($total_pendapatan/1000000, 1); ?>M</div>
                    <div class="stat-label">Total Pendapatan</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-user"></i>
                    </div>
                    <div class="stat-number"><?= number_format($customer_aktif); ?></div>
                    <div class="stat-label">Customer Aktif</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="search-filter">
        <div class="row">
            <div class="col-md-8">
                <h5 class="mb-3"><i class="glyphicon glyphicon-filter"></i> Filter Pesanan</h5>
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama customer..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="pending" <?= (isset($_GET['status']) && $_GET['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="proses" <?= (isset($_GET['status']) && $_GET['status'] == 'proses') ? 'selected' : ''; ?>>Proses</option>
                                <option value="selesai" <?= (isset($_GET['status']) && $_GET['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                <option value="dibatalkan" <?= (isset($_GET['status']) && $_GET['status'] == 'dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal" class="form-control" value="<?= isset($_GET['tanggal']) ? $_GET['tanggal'] : ''; ?>">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-filter">
                                <i class="glyphicon glyphicon-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-right">
                <h5 class="mb-3"><i class="glyphicon glyphicon-export"></i> Export Data</h5>
                <a href="export_pesanan.php" class="btn btn-success">
                    <i class="glyphicon glyphicon-save-file"></i> Export Excel
                </a>
                <a href="javascript:void(0)" onclick="window.print()" class="btn btn-default">
                    <i class="glyphicon glyphicon-print"></i> Cetak
                </a>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <div class="table-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0"><i class="glyphicon glyphicon-th-list"></i> Daftar Pesanan</h4>
                </div>
                <div class="col-md-6 text-right">
                    <small class="text-muted">Menampilkan data pesanan terbaru</small>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Nama Customer</th>
                        <th width="12%">Tanggal</th>
                        <th width="12%">Total Harga</th>
                        <th width="10%">Status</th>
                        <th width="20%">Alamat</th>
                        <th width="26%">Rincian Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    
                    // Build query dengan filter
                    $where_conditions = [];
                    if (!empty($_GET['search'])) {
                        $search = mysqli_real_escape_string($conn, $_GET['search']);
                        $where_conditions[] = "c.nama LIKE '%$search%'";
                    }
                    if (!empty($_GET['status'])) {
                        $status = mysqli_real_escape_string($conn, $_GET['status']);
                        $where_conditions[] = "p.status = '$status'";
                    }
                    if (!empty($_GET['tanggal'])) {
                        $tanggal = mysqli_real_escape_string($conn, $_GET['tanggal']);
                        $where_conditions[] = "DATE(p.tanggal_pesanan) = '$tanggal'";
                    }
                    
                    $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
                    
                    $query = mysqli_query($conn, "SELECT p.*, c.nama
                                                FROM pesanan p
                                                JOIN customer c ON p.kode_customer = c.kode_customer
                                                $where_clause
                                                ORDER BY p.id_pesanan DESC");
                    
                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                            // Tentukan class status
                            $status_class = '';
                            switch(strtolower($row['status'])) {
                                case 'pending': $status_class = 'status-pending'; break;
                                case 'proses': $status_class = 'status-proses'; break;
                                case 'selesai': $status_class = 'status-selesai'; break;
                                case 'dibatalkan': $status_class = 'status-dibatalkan'; break;
                                default: $status_class = 'status-pending';
                            }
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="customer-name"><?= htmlspecialchars($row['nama']); ?></td>
                        <td class="date-cell">
                            <?php
                            $tanggal = $row['tanggal_pesanan'];
                            if (strlen($tanggal) > 10) {
                                echo date('d-m-Y<br><small>H:i</small>', strtotime($tanggal));
                            } else {
                                echo date('d-m-Y', strtotime($tanggal));
                            }
                            ?>
                        </td>
                        <td class="price-cell">Rp<?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td>
                            <span class="status-badge <?= $status_class; ?>">
                                <?= htmlspecialchars($row['status']); ?>
                            </span>
                        </td>
                        <td class="alamat-cell">
                            <div>
                                <?= htmlspecialchars($row['alamat']); ?><br>
                                <small class="text-muted">
                                    <?= htmlspecialchars($row['kota']); ?>, <?= htmlspecialchars($row['provinsi']); ?><br>
                                    <?= htmlspecialchars($row['kode_pos']); ?>
                                </small>
                            </div>
                        </td>
                        <td>
                            <div class="rincian-pesanan"><?= htmlspecialchars($row['rincian_pesanan']); ?></div>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else { 
                    ?>
                    <tr>
                        <td colspan="7" class="no-data">
                            <i class="glyphicon glyphicon-info-sign" style="font-size: 48px; color: #6c757d;"></i><br>
                            <h4>Tidak ada data pesanan</h4>
                            <p class="text-muted">Belum ada pesanan yang sesuai dengan filter yang dipilih</p>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<br><br>
<?php include 'footer.php'; ?>