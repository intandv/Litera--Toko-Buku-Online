<?php 
	include 'header.php'; 
	$kode_cs = isset($_SESSION['kd_cs']) ? $_SESSION['kd_cs'] : '';
?>

<!-- PRODUK TERBARU -->
<div class="container">
	<h2 style="width: 100%; border-bottom: 4px solid rgb(128, 255, 160);"><b>Produk Kami</b></h2>

	<div class="row">
		<?php 
		$result = mysqli_query($conn, "SELECT * FROM buku");
		while ($row = mysqli_fetch_assoc($result)) {
		?>
			<div class="col-sm-6 col-md-4">
				<div class="thumbnail">
					<img src="img/buku/<?= $row['cover']; ?>" class="img-fluid" style="max-height: 300px; object-fit: cover;">
					<div class="caption">
						<h3><?= htmlspecialchars($row['judul']); ?></h3>
						<h4><?= htmlspecialchars($row['penulis']); ?></h4>
						<h4>Rp.<?= number_format($row['harga']); ?></h4>
						<div class="row">
							<div class="col-md-6">
								<a href="detail_produk.php?produk=<?= $row['kode_buku']; ?>" class="btn btn-warning btn-block">Detail</a> 
							</div>
							<div class="col-md-6">
								<?php if (!empty($kode_cs)) { ?>
									<a href="proses/add.php?produk=<?= $row['kode_buku']; ?>&kd_cs=<?= $kode_cs; ?>&hal=1" class="btn btn-success btn-block">
										<i class="glyphicon glyphicon-shopping-cart"></i> Tambah
									</a>
								<?php } else { ?>
									<a href="user_login.php" class="btn btn-success btn-block" onclick="return confirm('Silakan login terlebih dahulu untuk belanja.')">
										<i class="glyphicon glyphicon-shopping-cart"></i> Tambah
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php 
		}
		?>
	</div>
</div>

<?php include 'footer.php'; ?>
