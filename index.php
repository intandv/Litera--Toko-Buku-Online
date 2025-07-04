<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beranda - Toko Buku Online</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="stylle.css">
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
  <?php include 'header.php'; ?>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    let slideIndex = 0;
    const slides = document.querySelectorAll(".carousel-slide");

    function showSlides() {
      slides.forEach(slide => slide.classList.remove("active"));
      slideIndex = (slideIndex + 1) % slides.length;
      slides[slideIndex].classList.add("active");
      setTimeout(showSlides, 3000); // Ganti slide tiap 3 detik
    }

    if (slides.length > 0) {
      slides[0].classList.add("active");
      showSlides();
    }
  });
</script>
<form action="pencarian.php" method="GET" class="search-box">
  <select class="search-category" name="kategori">
    <option value="">Kategori</option>
  </select>
  <input type="text" name="q" class="search-input" placeholder="Cari Produk, Judul Buku, atau Penulis">
  <button type="submit" class="search-button">🔍</button>
</form>

  <section class="promo-section">
    <div class="promo-container">
      <div class="promo-left">
        <div class="carousel-container">
          <img class="carousel-slide active" src="image/banner1.jpg" alt="Slide 1">
          <img class="carousel-slide" src="image/banner13.png" alt="Slide 2">
          <img class="carousel-slide" src="image/banner11.png" alt="Slide 3">
          <img class="carousel-slide" src="image/banner15.jpg" alt="Slide 4">
        </div>
      </div>
      <div class="promo-right">
        <div class="promo-top-right">
          <img src="image/banner3.jpg" alt="Promo Kanan Atas">
        </div>
        <div class="promo-bottom-right">
          <img src="image/banner16.jpg" alt="Promo Kanan Bawah">
        </div>
      </div>
    </div>
  </section>
  <div class="icon-menu-wrapper">
  <div class="icon-menu">
  <div class="menu-item">
    <img src="img/serba5000.png" alt="">
    <span>Serba 5.000</span>
  </div>
  <div class="menu-item">
    <img src="img/buku.png" alt="">
    <span>Buku Baru</span>
  </div>
  <div class="menu-item">
    <img src="img/alattulis.png" alt="">
    <span>Buku Tulis</span>
  </div>
  <div class="menu-item">
    <img src="img/tas.png" alt="">
    <span>Tas</span>
  </div>
  <div class="menu-item">
    <img src="img/ebook.png" alt="">
    <span>Litera Digital</span>
  </div>
  <div class="menu-item">
    <img src="img/perlengkapan.png" alt="">
    <span>Stationery</span>
  </div>
</div>

<section class="rekomendasi-buku py-4" style="background-color:#fff;">
  <div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold mb-0" style="color:rgb(22, 22, 23);">Buku Terlaris</h2>
    </div>

    <!-- Konten -->
    <div class="row gx-3">
      <!-- Banner kiri -->
      <div class="col-md-2">
        <img src="image/terlaris.png" alt="Buku Terlaris" class="img-fluid p-0">
      </div>

  <!-- List Buku -->
<div class="col-md-10">
  <?php
  $buku_terlaris = mysqli_query($conn, "SELECT * FROM buku ORDER BY harga DESC LIMIT 6");
  ?>
  <div class="d-flex overflow-auto gap-3 pb-2">
    <?php while($row = mysqli_fetch_assoc($buku_terlaris)) { ?>
      <div class="book-card bg-white rounded shadow-sm p-2" style="min-width: 180px;">
        <img src="img/buku/<?= htmlspecialchars($row['cover']); ?>" alt="<?= htmlspecialchars($row['judul']); ?>" class="img-fluid rounded mb-2">
        <p class="mb-1 fw-semibold"><?= htmlspecialchars($row['judul']); ?></p>
        <small class="text-muted"><?= htmlspecialchars($row['penulis']); ?></small>
        <p class="mb-0 fw-bold text-danger">Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
        
        <div class="mt-2 d-flex gap-1 justify-content-between">
          <a href="detail_produk.php?produk=<?= urlencode($row['kode_buku']); ?>" class="btn btn-warning btn-sm w-50 text-center">Detail</a>
          
          <?php if (isset($_SESSION['kd_cs'])) { ?>
            <form action="add.php" method="POST" class="w-50">
              <input type="hidden" name="kode_customer" value="<?= $_SESSION['kd_cs']; ?>">
              <input type="hidden" name="kode_buku" value="<?= $row['kode_buku']; ?>">
              <input type="hidden" name="jml" value="1">
              <button type="submit" class="btn btn-success btn-sm w-100">Tambah</button>
            </form>
          <?php } else { ?>
            <div class="col-md-6">
                            <!-- Jika belum login, arahkan ke login -->
                            <a href="keranjang.php" class="btn btn-success w-180" role="button">
                              <i class="glyphicon glyphicon-shopping-cart"></i> Tambah</a>
                         </div>
          <?php } ?>
        </div>

      </div>
    <?php } ?>
  </div>
</div>

<section class="rekomendasi-buku py-4" style="background-color:#fff;">
  <div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0" style="color:rgb(6, 6, 6);">Buku Rekomendasi</h2>
    </div>

    <!-- Konten -->
    <div class="row gx-3">
      <!-- Banner kiri -->
      <div class="col-md-2">
        <img src="image/rekomendasi.png" alt="Buku Terlaris" class="img-fluid p-0">
      </div>
    <!-- List Buku -->
<div class="col-md-10">
  <?php
  $buku_terlaris = mysqli_query($conn, "SELECT * FROM buku ORDER BY harga DESC LIMIT 6");
  ?>
  <div class="d-flex overflow-auto gap-3 pb-2">
    <?php while($row = mysqli_fetch_assoc($buku_terlaris)) { ?>
      <div class="book-card bg-white rounded shadow-sm p-2" style="min-width: 180px;">
        <img src="img/buku/<?= htmlspecialchars($row['cover']); ?>" alt="<?= htmlspecialchars($row['judul']); ?>" class="img-fluid rounded mb-2">
        <p class="mb-1 fw-semibold"><?= htmlspecialchars($row['judul']); ?></p>
        <small class="text-muted"><?= htmlspecialchars($row['penulis']); ?></small>
        <p class="mb-0 fw-bold text-danger">Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
        
        <div class="mt-2 d-flex gap-1 justify-content-between">
          <a href="detail_produk.php?produk=<?= urlencode($row['kode_buku']); ?>" class="btn btn-warning btn-sm w-50 text-center">Detail</a>
          
          <?php if (isset($_SESSION['kd_cs'])) { ?>
            <form action="add.php" method="POST" class="w-50">
              <input type="hidden" name="kode_customer" value="<?= $_SESSION['kd_cs']; ?>">
              <input type="hidden" name="kode_buku" value="<?= $row['kode_buku']; ?>">
              <input type="hidden" name="jml" value="1">
              <button type="submit" class="btn btn-success btn-sm w-100">Tambah</button>
            </form>
          <?php } else { ?>
            <div class="col-md-6">
                            <!-- Jika belum login, arahkan ke login -->
                            <a href="keranjang.php" class="btn btn-success w-180" role="button">
                              <i class="glyphicon glyphicon-shopping-cart"></i> Tambah</a>
                         </div>
          <?php } ?>
        </div>

      </div>
    <?php } ?>
  </div>
</div>



<!-- PRODUK TERBARU -->
<div class="container">

    <h4 class="text-center" style="font-family: Arial; padding: 10px 0; font-style: italic; line-height: 29px; border-top: 2px solid rgb(41, 103, 41); border-bottom: 2px solid rgb(21, 108, 37);">
        Litera Buku-Online adalah platform toko buku online yang menghadirkan beragam pilihan buku terbaik untuk semua kalangan. Kami hadir untuk memenuhi kebutuhan literasi masyarakat dengan menyediakan akses mudah dan cepat ke buku-buku berkualitas, baik dalam bentuk cetak maupun digital.
    </h4>

    <h2 id="produk" style="width: 100%; border-bottom: 4px solid rgb(230, 230, 230);"><b>Produk Kami</b></h2>

    <?php 
    $result = mysqli_query($conn, "SELECT * FROM buku");
    $i = 0;

    echo '<div class="row">';

    while ($row = mysqli_fetch_assoc($result)) {
        if ($i > 0 && $i % 4 == 0) {
            echo '</div><div class="row">';
        }
    ?>
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail" style="height:100%; display:flex; flex-direction: column;">
                <img src="img/buku/<?= htmlspecialchars($row['cover']); ?>" class="img-responsive" alt="<?= htmlspecialchars($row['judul']); ?>" style="max-height:240px; margin: 0 auto;">
                
                <div class="caption" style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                    <div>
                        <h3 class="mb-1 fw-semibold"><?= htmlspecialchars($row['judul']); ?></h3>
                        <h5><?= htmlspecialchars($row['penulis']); ?></h5>
                         <p><?= htmlspecialchars($row['penerbit']); ?></p>
                        <h4 class="mb-0 fw-bold text-danger">Rp<?= number_format($row['harga'], 0, ',', '.'); ?></h4>
                    </div>

                    <div class="mt-2 d-flex gap-1 justify-content-between">
                        <!-- Tombol Detail -->
                        <a href="detail_produk.php?produk=<?= urlencode($row['kode_buku']); ?>" class="btn btn-warning btn-sm w-50 text-center">Detail</a>

                        <?php if (isset($_SESSION['kd_cs'])) { ?>
                            <!-- Jika user login, tampilkan tombol Tambah -->
                            <form action="add.php" method="POST" class="w-50">
                                <input type="hidden" name="kode_customer" value="<?= $_SESSION['kd_cs']; ?>">
                                <input type="hidden" name="kode_buku" value="<?= $row['kode_buku']; ?>">
                                <input type="hidden" name="jml" value="1">
                                <button type="submit" class="btn btn-success btn-sm w-100">Tambah</button>
                            </form>
                        <?php 
                        } 
                        else { 
                          ?>
                         <div class="col-md-6">
                            <!-- Jika belum login, arahkan ke login -->
                            <a href="keranjang.php" class="btn btn-success btn-block" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah</a>
                         </div>
                         <?php
                       }
                        ?>
                    </div>

                    <?php if (isset($_SESSION['admin'])) { ?>
                    <div class="mt-2">
                        <!-- Tombol Edit untuk admin -->
                        <a href="edit_buku.php?kode=<?= urlencode($row['kode_buku']); ?>" class="btn btn-info btn-sm w-100">Edit</a>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    <?php 
        $i++;
    }

    echo '</div>';
    ?>
</div>

<br><br><br><br>
<?php include 'footer.php'; ?>
