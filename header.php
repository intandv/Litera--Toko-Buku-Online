<?php 
if (session_status() == PHP_SESSION_NONE) {
	session_start();
   
}
include 'koneksi/koneksi.php';

// Simpan kode customer jika sudah login
if (isset($_SESSION['kd_cs'])) {
	$kode_cs = $_SESSION['kd_cs'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<title>Litera - Toko Buku Online</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- ✅ Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- ✅ Bootstrap Icons -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
	<!-- ✅ Font dan Style -->
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

	<style>
		body {
			font-family: 'Roboto', sans-serif;
		}
		.card-title {
			font-size: 1rem;
			font-weight: bold;
		}
		.card-text {
			font-size: 0.9rem;
		}
		.navbar-nav .nav-link {
		font-size: 1.2rem;
		font-weight: bold;
		text-transform: uppercase; /* opsional, hapus kalau nggak mau kapital semua */
	}
	.navbar-brand {
		font-size: 1.8rem;
		font-weight: bold;
		color: rgb(22, 84, 14) !important;
	}
	</style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
	<div class="container">
		<a class="navbar-brand fw-bold text-success" href="#">📚 Litera - Toko Buku Online</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ms-auto">
				<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
				<li class="nav-item"><a class="nav-link" href="index.php#produk">Produk</a></li>
				<li class="nav-item"><a class="nav-link" href="about.php">Tentang Kami</a></li>

				<!-- 🛒 Tampilkan jumlah keranjang -->
				<?php 
				if (isset($_SESSION['kd_cs'])) {
					$kode_cs = $_SESSION['kd_cs'];
					$cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kode_cs'");

					if (!$cek) {
						// Query gagal, tampilkan error (opsional)
						echo "Query error: " . mysqli_error($conn);
						$jumlah = 0;
					} else {
						$jumlah = mysqli_num_rows($cek);
					}
					echo "<li class='nav-item'><a class='nav-link' href='keranjang.php'><i class='bi bi-cart'></i> [$jumlah]</a></li>";
				} else {
					echo "<li class='nav-item'><a class='nav-link' href='keranjang.php'><i class='bi bi-cart'></i> [0]</a></li>";
				}

				if (!isset($_SESSION['user'])): ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
							<i class="bi bi-person-circle"></i> Akun
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="user_login.php">Login</a></li>
							<li><a class="dropdown-item" href="register.php">Register</a></li>
							<li><a class="dropdown-item" href="admin/">Admin Panel</a></li>
						</ul>
					</li>
				<?php else: ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
							<i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['user']); ?>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="riwayat_pesanan.php">Riwayat Pesanan</a></li>
							<li><a class="dropdown-item" href="proses/logout.php">Log Out</a></li>
						</ul>
					</li>
				<?php endif; ?>

			</ul>
		</div>
	</div>
</nav>
