-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jul 04, 2025 at 11:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbpw192_18410100054`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$AIy0X1Ep6alaHDTofiChGeqq7k/d1Kc8vKQf1JZo0mKrzkkj6M626');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `kode_buku` varchar(10) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `jenis_buku` enum('Fisik','Digital') DEFAULT NULL,
  `format` enum('PDF','EPUB','Hardcover','Softcover') DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `cover` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`kode_buku`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `jenis_buku`, `format`, `deskripsi`, `harga`, `cover`) VALUES
('BK001', 'History Of The World War', 'Saut Pasaribu', 'Erlangga', '2020', 'Fisik', 'Hardcover', 'Sejarah perang dunia lengkap dan mendalam.', 70000, 'buku1.jpg'),
('BK002', 'Sepotong Hati di Angkringan', 'Joko Pinurbo', 'Gramedia', '2019', 'Fisik', 'Softcover', 'Kumpulan puisi penuh makna dan kehidupan sederhana.', 55000, 'buku2.jpg'),
('BK003', '\r\nIntroduction To Blue', 'Renita Nozahria', 'Bentang', '2022', 'Fisik', 'Softcover', 'Kisah inspiratif dengan nuansa langit biru.', 100000, 'buku5.jpg'),
('BK004', ' Membangun Website', 'Johnie Rogers Swanda', 'Informatika', '2021', 'Fisik', 'Softcover', 'Panduan lengkap membangun website dengan Bootstrap.', 80000, 'buku6.png'),
('BK005', '25 jam', 'Stefani Bella & Syahid', 'Noura Books', '2023', 'Fisik', 'Softcover', 'Refleksi kehidupan dalam keseharian penuh makna.', 85500, 'buku7.jpg'),
('BK006', 'Angkasa Dan 56 Hari', 'Destashya Wdp putra\r\n(Ravinkyu)', 'Nour Books', '2023', 'Fisik', 'Softcover', 'Mengenal Kehidupan Angkasa.', 85500, 'buku8.jpg'),
('BK007', 'Aplikasi Pemograman', 'Bunafit Nugroh', 'Republika', '2018', 'Fisik', 'Softcover', 'Sebuah buku panduan agar mahir dalam pemograman.', 80000, 'buku10.jpg'),
('BK008', 'ABC Filsafat', 'Daffin Davankaa', 'Bright Publisher', '2021', 'Fisik', 'Hardcover', 'Panduan praktis untuk membentuk kebiasaan positif yang bertahan lama.', 150000, 'buku9.jpg'),
('KB0010', 'Desa Mengapung Kota', 'intan', NULL, NULL, 'Fisik', 'PDF', NULL, 70000, 'buku4.png'),
('KB0011', 'aaa', 'aaaa', '', NULL, 'Fisik', 'PDF', '', 10000, 'buku10.jpg'),
('KB0013', 'APLIKASI DIGITAL', 'aaa', 'aaaa', NULL, 'Fisik', 'PDF', 'aaaa', 100000, 'buku3.jpg'),
('KB0015', 'abab', 'abab', 'ab', NULL, NULL, NULL, 'ab', 50000, 'buku9.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `kode_customer` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `telp` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`kode_customer`, `nama`, `email`, `username`, `password`, `telp`) VALUES
('C0001', 'Intan Devia Putri', 'intandeviap@gmail.com', 'intan', '$2y$10$eBU9onIiwkZjOAgUnJhO0eX8fGvZnv0OpWz25E9RYMRm7oPCiCHkq', '081387018014'),
('C0002', 'devia  putri', 'intandeviap@gmail.com', 'devia', '$2y$10$qJhYLHVx/d9.mQt7TRp1sOTW9rqpRhXFodq4.aI0N/I/vK5sqYH0W', '081387018014'),
('C0003', 'Amanda Mulya Putri', 'amnda@gmail.com', 'amandaaaaaaaa', '$2y$10$JDlFW05THWNozFQOnB9jG.g2Y9Pwu.0qQfERHFQ95XIT0ntFfhZ76', '081387018014');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `kode_customer` varchar(100) DEFAULT NULL,
  `kode_buku` varchar(100) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `kode_customer`, `kode_buku`, `judul`, `qty`, `harga`) VALUES
(87, 'C0006', 'BK008', 'ABC Filsafat', 1, 150000),
(88, 'C0006', 'BK005', '25 jam', 1, 85500),
(89, 'C0006', 'KB0013', 'APLIKASI DIGITAL', 1, 100000),
(95, 'C0002', 'BK002', 'Sepotong Hati di Angkringan', 1, 55000);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `kode_customer` varchar(50) NOT NULL,
  `tanggal_pesanan` date NOT NULL,
  `total_harga` int(20) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Menunggu',
  `provinsi` varchar(100) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kode_pos` varchar(20) NOT NULL,
  `rincian_pesanan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `kode_customer`, `tanggal_pesanan`, `total_harga`, `status`, `provinsi`, `kota`, `alamat`, `kode_pos`, `rincian_pesanan`) VALUES
(5, 'C0006', '2025-06-08', 68000, 'Menunggu', 'sumatera barat', 'padang', 'jln.andalas', '2', 'Aplikasi Pemograman (x1) - Rp 68.000'),
(6, 'C0006', '2025-06-08', 165500, 'Menunggu', 'sumatera barat', 'padang', 'jln.andalas', '255122', '25 jam (x1) - Rp 85.500\n Membangun Website (x1) - Rp 80.000'),
(10, 'C0006', '2025-06-09', 235500, 'Menunggu', 'sumatera barat', 'padang', 'jln.parak jigarang', '255122', 'Angkasa Dan 56 Hari (x1) - Rp 85.500\nABC Filsafat (x1) - Rp 150.000'),
(11, 'C0006', '2025-06-09', 85500, 'Menunggu', 'sumatera barat', 'padang', 'jln.parak jigarang', '255122', '25 jam (x1) - Rp 85.500'),
(12, 'C0006', '2025-06-09', 476000, 'Menunggu', 'sumatera barat', 'padang', 'jln.andalas', '255122', 'Sepotong Hati di Angkringan (x1) - Rp 55.000\nDesa Mengapung Kota (x1) - Rp 70.000\nbbbb (x2) - Rp 100.000\n25 jam (x2) - Rp 171.000\n Membangun Website (x1) - Rp 80.000'),
(13, 'C0006', '2025-06-12', 100000, 'Menunggu', 'sumatera barat', 'padang', 'jln.parak jigarang', '255122', 'Perpustakan Digital (x1) - Rp 100.000'),
(14, 'C0002', '2025-06-15', 220000, 'Menunggu', 'sumatera barat', 'padang', 'jln.andalas', '255122', 'ABC Filsafat (x1) - Rp 150.000\nHistory Of The World War (x1) - Rp 70.000'),
(15, 'C0002', '2025-06-15', 140500, 'Menunggu', 'sumatera barat', 'padang', 'jln.andalas', '255122', 'Sepotong Hati di Angkringan (x1) - Rp 55.000\nAngkasa Dan 56 Hari (x1) - Rp 85.500'),
(16, 'C0002', '2025-06-15', 160000, 'Menunggu', 'sumatera barat', 'padang', 'jln.andalas', '255122', 'Aplikasi Pemograman (x2) - Rp 160.000'),
(17, 'C0001', '2025-06-15', 150000, 'Menunggu', 'sumatera barat', 'padang', 'jln.andalas', '255122', 'ABC Filsafat (x1) - Rp 150.000'),
(18, 'C0001', '2025-06-15', 155000, 'Menunggu', 'sumatera barat', 'padang', 'jln.andalas', '255122', 'Sepotong Hati di Angkringan (x1) - Rp 55.000\nAPLIKASI DIGITAL (x1) - Rp 100.000'),
(19, 'C0003', '2025-06-16', 100000, 'Menunggu', 'Padang', 'padang', 'simpang haru', '25213', '\r\nIntroduction To Blue (x1) - Rp 100.000');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id_pesanan` int(11) NOT NULL,
  `kode_buku` varchar(50) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan_detail`
--

INSERT INTO `pesanan_detail` (`id_pesanan`, `kode_buku`, `judul`, `harga`, `qty`) VALUES
(5, 'BK007', 'Aplikasi Pemograman', 68000, 1),
(6, 'BK005', '25 jam', 85500, 1),
(6, 'BK004', ' Membangun Website', 80000, 1),
(10, 'BK006', 'Angkasa Dan 56 Hari', 85500, 1),
(10, 'BK008', 'ABC Filsafat', 150000, 1),
(11, 'BK005', '25 jam', 85500, 1),
(12, 'BK002', 'Sepotong Hati di Angkringan', 55000, 1),
(12, 'KB0010', 'Desa Mengapung Kota', 70000, 1),
(12, 'KB0012', 'bbbb', 50000, 2),
(12, 'BK005', '25 jam', 85500, 2),
(12, 'BK004', ' Membangun Website', 80000, 1),
(13, 'KB009', 'Perpustakan Digital', 100000, 1),
(14, 'BK008', 'ABC Filsafat', 150000, 1),
(14, 'BK001', 'History Of The World War', 70000, 1),
(15, 'BK002', 'Sepotong Hati di Angkringan', 55000, 1),
(15, 'BK006', 'Angkasa Dan 56 Hari', 85500, 1),
(16, 'BK007', 'Aplikasi Pemograman', 80000, 2),
(17, 'BK008', 'ABC Filsafat', 150000, 1),
(18, 'BK002', 'Sepotong Hati di Angkringan', 55000, 1),
(18, 'KB0013', 'APLIKASI DIGITAL', 100000, 1),
(19, 'BK003', '\r\nIntroduction To Blue', 100000, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`kode_customer`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD CONSTRAINT `pesanan_detail_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
