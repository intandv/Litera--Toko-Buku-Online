<?php
include 'koneksi/koneksi.php';
include 'header.php';

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

// Query dasar
$sql = "SELECT * FROM buku WHERE 1";

// Filter pencarian
if (!empty($q)) {
    $sql .= " AND (judul LIKE '%$q%' OR penulis LIKE '%$q%')";
}

// Filter kategori
if ($kategori === 'terlaris') {
    $sql .= " ORDER BY harga DESC LIMIT 12";  // Atau kolom 'penjualan' jika ada
} elseif ($kategori === 'rekomendasi') {
    $sql .= " ORDER BY judul ASC LIMIT 12"; // Bisa diganti sesuai kolom rekomendasi
} elseif ($kategori === 'serba5000') {
    $sql .= " AND harga <= 5000 ORDER BY judul ASC";
} elseif ($kategori === 'stationery') {
    $sql .= " AND kategori = 'Stationery'"; // pastikan ada kolom 'kategori'
}

$result = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
  <h3>Hasil Pencarian</h3>
  <div class="row">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100">
            <img src="img/buku/<?= htmlspecialchars($row['cover']); ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul']); ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($row['judul']); ?></h5>
              <p class="card-text"><?= htmlspecialchars($row['penulis']); ?></p>
              <p class="text-danger fw-bold mb-2">Rp<?= number_format($row['harga'], 0, ',', '.'); ?></p>

              <div class="mt-auto d-flex gap-1 justify-content-between">
                <a href="detail_produk.php?produk=<?= urlencode($row['kode_buku']); ?>" class="btn btn-warning btn-sm w-50">Detail</a>

                <?php if (isset($_SESSION['kd_cs'])): ?>
                  <form action="add.php" method="POST" class="w-50">
                    <input type="hidden" name="kode_customer" value="<?= $_SESSION['kd_cs']; ?>">
                    <input type="hidden" name="kode_buku" value="<?= $row['kode_buku']; ?>">
                    <input type="hidden" name="jml" value="1">
                    <button type="submit" class="btn btn-success btn-sm w-100">Tambah</button>
                  </form>
                <?php else: ?>
                  <a href="login.php" class="btn btn-success btn-sm w-50">Login</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-warning text-center">Tidak ditemukan hasil untuk pencarian ini.</div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include 'footer.php'; ?>
