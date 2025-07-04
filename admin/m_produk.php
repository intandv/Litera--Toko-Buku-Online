<?php  
include 'header.php'; 
include '../koneksi/koneksi.php';  

// Fungsi HAPUS
if (isset($_GET['hapus'])) {     
    $kode = mysqli_real_escape_string($conn, $_GET['hapus']);      

    // Ambil data cover     
    $result = mysqli_query($conn, "SELECT cover FROM buku WHERE kode_buku = '$kode'");     
    $data = mysqli_fetch_assoc($result);      

    // Hapus file gambar jika ada     
    if (!empty($data['cover']) && file_exists("../img/buku/" . $data['cover'])) {         
        unlink("../img/buku/" . $data['cover']);     
    }      

    // Hapus data dari tabel     
    $hapus = mysqli_query($conn, "DELETE FROM buku WHERE kode_buku = '$kode'");      

    if ($hapus) {         
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data produk berhasil dihapus',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                window.location='m_produk.php';
            });
        </script>";     
    } else {         
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Gagal menghapus data produk',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                window.location='m_produk.php';
            });
        </script>";     
    } 
}

// Ambil statistik produk
$total_produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM buku"));
$total_value = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(harga) as total FROM buku"))['total'];
$avg_price = $total_produk > 0 ? $total_value / $total_produk : 0;
$recent_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM buku"));
?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style type="text/css">
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 0;
        margin-bottom: 30px;
        border-radius: 0 0 30px 30px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.1;
    }
    
    .page-header .container {
        position: relative;
        z-index: 2;
    }
    
    .stats-section {
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.5s;
    }
    
    .stat-card:hover::before {
        left: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .stat-icon {
        font-size: 3.5rem;
        margin-bottom: 15px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 900;
        color: #2c3e50;
        margin-bottom: 5px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    
    .stat-label {
        color: #7f8c8d;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }
    
    .main-content {
        background: white;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
    }
    
    .content-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 25px 30px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .search-section {
        background: #f8f9fa;
        padding: 20px 30px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .search-input {
        border-radius: 25px;
        border: 2px solid #e9ecef;
        padding: 12px 20px;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-add {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        color: white;
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }
    
    .btn-add:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        color: white;
        text-decoration: none;
    }
    
    .table-container {
        padding: 0;
    }
    
    .table {
        margin-bottom: 0;
        font-size: 0.95rem;
    }
    
    .table thead th {
        background: linear-gradient(135deg, #495057, #6c757d);
        color: white;
        border: none;
        font-weight: 700;
        text-align: center;
        vertical-align: middle;
        padding: 20px 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
    }
    
    .table tbody td {
        vertical-align: middle;
        padding: 20px 15px;
        border-color: #e9ecef;
        transition: all 0.3s ease;
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
    }
    
    .table tbody tr:hover {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .product-image {
        width: 80px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    
    .product-image:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }
    
    .product-title {
        font-weight: 600;
        color: #2c3e50;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .product-author {
        color: #6c757d;
        font-size: 0.9rem;
        font-style: italic;
    }
    
    .product-price {
        font-weight: 700;
        color: #28a745;
        font-size: 1.1rem;
    }
    
    .product-code {
        background: #e9ecef;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #495057;
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(255, 193, 7, 0.3);
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
    }
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        color: white;
    }
    
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }
    
    .no-data i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #dee2e6;
    }
    
    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 20px;
        }
        
        .table {
            font-size: 0.8rem;
        }
        
        .product-image {
            width: 60px;
            height: 75px;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 5px;
        }
        
        .btn-edit, .btn-delete {
            padding: 6px 10px;
            font-size: 0.8rem;
        }
    }
    
    /* Loading Animation */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Smooth transitions */
    * {
        transition: all 0.3s ease;
    }
</style>

<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="glyphicon glyphicon-book"></i> Master Produk Buku
                </h1>
                <p class="mb-0 mt-2">Kelola koleksi buku dan produk toko Anda</p>
            </div>
            <div class="col-md-4 text-right">
                <div class="text-white">
                    <small><i class="glyphicon glyphicon-time"></i> <?= date('d M Y, H:i'); ?></small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Statistics Section -->
    <div class="stats-section">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-book"></i>
                    </div>
                    <div class="stat-number"><?= number_format($total_produk); ?></div>
                    <div class="stat-label">Total Produk</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-usd"></i>
                    </div>
                    <div class="stat-number">Rp<?= number_format($total_value/1000000, 1); ?>M</div>
                    <div class="stat-label">Total Nilai</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-stats"></i>
                    </div>
                    <div class="stat-number">Rp<?= number_format($avg_price); ?></div>
                    <div class="stat-label">Rata-rata Harga</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="glyphicon glyphicon-plus"></i>
                    </div>
                    <div class="stat-number"><?= number_format($recent_products); ?></div>
                    <div class="stat-label">Produk Baru (7 hari)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Content Header -->
        <div class="content-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="mb-0">
                        <i class="glyphicon glyphicon-th-list"></i> Daftar Produk
                    </h3>
                    <small class="text-muted">Menampilkan semua produk yang tersedia</small>
                </div>
                <div class="col-md-6 text-right">
                    <a href="tm_produk.php" class="btn-add">
                        <i class="glyphicon glyphicon-plus"></i>
                        Tambah Produk Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control search-input" placeholder="Cari produk, judul, atau penulis...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" style="border-radius: 0 25px 25px 0; border: 2px solid #e9ecef; border-left: none;">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-sort"></i> Urutkan <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="sortTable(1)">Kode Buku</a></li>
                            <li><a href="#" onclick="sortTable(2)">Judul</a></li>
                            <li><a href="#" onclick="sortTable(3)">Penulis</a></li>
                            <li><a href="#" onclick="sortTable(5)">Harga</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table" id="productTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="12%">Kode Buku</th>
                            <th width="25%">Judul Buku</th>
                            <th width="20%">Penulis</th>
                            <th width="10%">Cover</th>
                            <th width="15%">Harga</th>
                            <th width="13%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                        $result = mysqli_query($conn, "SELECT * FROM buku ORDER BY kode_buku ASC"); 
                        $no = 1; 
                        
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) { 
                        ?> 
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td>
                                    <span class="product-code"><?= htmlspecialchars($row['kode_buku']); ?></span>
                                </td>
                                <td>
                                    <div class="product-title" title="<?= htmlspecialchars($row['judul']); ?>">
                                        <?= htmlspecialchars($row['judul']); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="product-author"><?= htmlspecialchars($row['penulis']); ?></div>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($row['cover']) && file_exists("../img/buku/" . $row['cover'])) { ?>
                                        <img src="../img/buku/<?= $row['cover']; ?>" class="product-image" alt="Cover Buku">
                                    <?php } else { ?>
                                        <div style="width: 80px; height: 100px; background: #f8f9fa; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6;">
                                            <i class="glyphicon glyphicon-picture" style="font-size: 24px; color: #dee2e6;"></i>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <div class="product-price">Rp<?= number_format($row['harga'], 0, ',', '.'); ?></div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="edit_produk.php?kode=<?= $row['kode_buku']; ?>" class="btn btn-edit" title="Edit Produk">
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-delete" onclick="confirmDelete('<?= $row['kode_buku']; ?>', '<?= htmlspecialchars($row['judul']); ?>')" title="Hapus Produk">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else { 
                        ?>
                            <tr>
                                <td colspan="7" class="no-data">
                                    <i class="glyphicon glyphicon-inbox"></i>
                                    <h4>Belum ada produk</h4>
                                    <p>Mulai tambahkan produk buku pertama Anda</p>
                                    <a href="tm_produk.php" class="btn-add" style="margin-top: 15px;">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        Tambah Produk
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<br><br>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    var input = this.value.toLowerCase();
    var table = document.getElementById('productTable');
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var found = false;
        
        for (var j = 1; j < cells.length - 1; j++) { // Skip No and Action columns
            if (cells[j].textContent.toLowerCase().indexOf(input) > -1) {
                found = true;
                break;
            }
        }
        
        rows[i].style.display = found ? '' : 'none';
    }
});

// Confirm delete with SweetAlert
function confirmDelete(kode, judul) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Yakin ingin menghapus produk "${judul}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `m_produk.php?hapus=${kode}`;
        }
    });
}

// Sort table function
function sortTable(columnIndex) {
    var table = document.getElementById('productTable');
    var tbody = table.getElementsByTagName('tbody')[0];
    var rows = Array.from(tbody.getElementsByTagName('tr'));
    
    rows.sort(function(a, b) {
        var aVal = a.getElementsByTagName('td')[columnIndex].textContent.trim();
        var bVal = b.getElementsByTagName('td')[columnIndex].textContent.trim();
        
        // For price column, convert to number
        if (columnIndex === 5) {
            aVal = parseInt(aVal.replace(/[^\d]/g, ''));
            bVal = parseInt(bVal.replace(/[^\d]/g, ''));
        }
        
        return aVal > bVal ? 1 : -1;
    });
    
    rows.forEach(function(row) {
        tbody.appendChild(row);
    });
    
    // Update row numbers
    rows.forEach(function(row, index) {
        row.getElementsByTagName('td')[0].textContent = index + 1;
    });
}
</script>

<?php include 'footer.php'; ?>