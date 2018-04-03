-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2018 at 09:15 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_masters`
--

CREATE TABLE `barang_masters` (
  `id` int(2) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `harga_laundry` int(5) NOT NULL,
  `harga_setrika` int(5) NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `qty` int(4) NOT NULL,
  `add_by` int(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_masters`
--

INSERT INTO `barang_masters` (`id`, `nama`, `harga_laundry`, `harga_setrika`, `keterangan`, `qty`, `add_by`, `created_at`, `updated_at`) VALUES
(1, 'SHIRT / KEMEJA', 1000, 700, ' -', 1, 1, NULL, NULL),
(2, 'T-SHIRT', 1000, 700, ' -', 1, 1, NULL, NULL),
(3, 'UNDERSHIRT / SINGLET', 1000, 700, ' -', 1, 1, NULL, NULL),
(4, 'UNDER PANTS / CD', 1000, 700, ' -', 1, 1, NULL, NULL),
(5, 'SHORT / CELANA PENDEK', 1000, 700, ' -', 1, 1, NULL, NULL),
(6, 'TROUSER / CELANA PANJANG', 1500, 1000, ' -', 1, 1, NULL, NULL),
(7, 'SOCKS / KAOS KAKI', 1000, 700, ' -', 1, 1, NULL, NULL),
(8, 'HANDKERCIEF / SAPUTANGAN', 1000, 700, ' -', 1, 1, NULL, NULL),
(9, 'JACKET', 1000, 700, ' -', 1, 1, NULL, NULL),
(10, 'SARONG / KAMEN', 1000, 700, ' -', 1, 1, NULL, NULL),
(11, 'SKIRT / ROK', 1000, 700, ' -', 1, 1, NULL, NULL),
(12, 'DRESS / DASTER', 1500, 1000, ' -', 1, 1, NULL, NULL),
(13, 'BRASSIERE / BH', 1000, 700, ' -', 1, 1, NULL, NULL),
(14, 'TOWEL / HANDUK S', 2000, 1000, ' -', 1, 1, NULL, NULL),
(15, 'TOWEL / HANDUK M', 2500, 1500, ' -', 1, 1, NULL, NULL),
(16, 'TOWEL / HANDUK L / XL', 3000, 2000, ' -', 1, 1, NULL, NULL),
(17, 'SHEET S / SPREI KECIL', 5000, 2000, ' -', 1, 1, NULL, NULL),
(18, 'SHEET D / SPREI BESAR', 7000, 3000, ' -', 1, 1, NULL, NULL),
(19, 'PILLOW CASES / SARUNG BANTAL', 1000, 700, ' -', 1, 1, NULL, NULL),
(20, 'BED COVER KECIL', 10000, 5000, ' -', 1, 1, NULL, NULL),
(21, 'BED COVER BESAR', 15000, 7000, ' -', 1, 1, NULL, NULL),
(22, 'ALAS MATRAS KECIL', 10000, 5000, ' -', 1, 1, NULL, NULL),
(23, 'ALAS MATRAS BESAR', 15000, 7000, ' -', 1, 1, NULL, NULL),
(24, 'KEBAYA', 1000, 700, ' -', 1, 1, NULL, NULL),
(25, 'ROMPI', 1000, 700, ' -', 1, 1, NULL, NULL),
(26, 'TOPI', 1000, 700, ' -', 1, 1, NULL, NULL),
(27, 'BONEKA S', 5000, 3000, ' -', 1, 1, NULL, NULL),
(28, 'BONEKA M', 7000, 5000, ' -', 1, 1, NULL, NULL),
(29, 'BONEKA L / XL', 10000, 7000, ' -', 1, 1, NULL, NULL),
(30, 'KORDEN S', 10000, 7000, ' -', 1, 1, NULL, NULL),
(31, 'KORDEN M', 15000, 10000, ' -', 1, 1, NULL, NULL),
(32, 'KORDEN L / XL', 20000, 15000, ' -', 1, 1, NULL, NULL),
(33, 'MUKENA ATASAN', 1500, 1000, ' -', 1, 1, NULL, NULL),
(34, 'MUKENA BAWAHAN', 1500, 1000, ' -', 1, 1, NULL, NULL),
(35, 'PAKET 10 PCS', 8000, 0, ' -', 10, 1, NULL, NULL),
(36, 'PAKET 15 PCS', 13000, 0, ' -', 15, 1, NULL, NULL),
(37, 'PAKET 20 PCS', 18000, 0, ' -', 20, 1, NULL, NULL),
(38, 'PAKET 25 PCS', 23000, 0, ' -', 25, 1, NULL, NULL),
(39, 'PAKET 30 PCS', 28000, 0, ' -', 30, 1, NULL, NULL),
(40, 'PAKET 35 PCS', 33000, 0, ' -', 35, 1, NULL, NULL),
(41, 'PAKET 40 PCS', 38000, 0, ' -', 40, 1, NULL, NULL),
(42, 'JAKET', 2000, 1500, NULL, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `biaya_bulanans`
--

CREATE TABLE `biaya_bulanans` (
  `id` int(11) NOT NULL,
  `id_master` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `add_by` int(11) NOT NULL,
  `closed` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `biaya_bulanan_masters`
--

CREATE TABLE `biaya_bulanan_masters` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `biaya` int(11) NOT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `add_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `biaya_bulanan_masters`
--

INSERT INTO `biaya_bulanan_masters` (`id`, `nama`, `biaya`, `keterangan`, `add_by`, `created_at`, `updated_at`) VALUES
(2, 'Bayar Wifi/Telp', 400000, NULL, 1, '2018-02-26 17:07:29', '2018-02-26 17:07:29'),
(5, 'Bayar Listrik & Air', 400000, NULL, 1, '2018-02-26 18:38:09', '2018-02-26 18:38:09'),
(6, 'Bayar Canang', 20000, NULL, 1, '2018-02-26 18:38:18', '2018-02-26 18:38:18'),
(7, 'Pulsa Bulanan', 25000, NULL, 1, '2018-02-26 18:38:40', '2018-02-26 18:38:40');

-- --------------------------------------------------------

--
-- Table structure for table `brg_jual_masters`
--

CREATE TABLE `brg_jual_masters` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `hpp` int(11) NOT NULL,
  `h_jual` int(11) NOT NULL,
  `add_by` int(11) NOT NULL,
  `stok` int(11) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brg_jual_masters`
--

INSERT INTO `brg_jual_masters` (`id`, `nama`, `hpp`, `h_jual`, `add_by`, `stok`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 'Parfum', 25000, 30000, 1, 15, NULL, '2018-02-22 18:04:49', '2018-02-28 17:43:29'),
(3, 'Aqua Galon', 17000, 20000, 1, 8, NULL, '2018-02-22 18:04:53', '2018-04-02 17:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `bulans`
--

CREATE TABLE `bulans` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `s_nama` varchar(3) NOT NULL,
  `eng_nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bulans`
--

INSERT INTO `bulans` (`id`, `nama`, `s_nama`, `eng_nama`) VALUES
(1, 'Januari', 'Jan', 'January'),
(2, 'Februari', 'Feb', 'February'),
(3, 'Maret', 'Mar', 'March'),
(4, 'April', 'Apr', 'April'),
(5, 'Mei', 'Mei', 'May'),
(6, 'Juni', 'Jun', 'June'),
(7, 'Juli', 'Jul', 'July'),
(8, 'Agustus', 'Agu', 'August'),
(9, 'September', 'Sep', 'September'),
(10, 'Oktober', 'Okt', 'October'),
(11, 'November', 'Nov', 'November'),
(12, 'Desember', 'Des', 'December');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `nama`, `alamat`, `phone`, `created_at`, `updated_at`) VALUES
(86, 'Agus', NULL, NULL, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(87, 'Putra', NULL, NULL, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(88, 'Bos', NULL, NULL, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(89, 'Dyah', NULL, NULL, '2018-03-06 16:00:00', '2018-03-06 16:00:00'),
(90, 'Ujang', NULL, NULL, '2018-03-06 16:00:00', '2018-03-06 16:00:00'),
(91, 'Mayun', NULL, NULL, '2018-03-07 16:00:00', '2018-03-07 16:00:00'),
(92, 'Beni', NULL, NULL, '2018-04-02 16:00:00', '2018-04-02 16:00:00'),
(93, 'Septi', NULL, NULL, '2018-04-02 16:00:00', '2018-04-02 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `data_cashes`
--

CREATE TABLE `data_cashes` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `add_by` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_cashes`
--

INSERT INTO `data_cashes` (`id`, `kode`, `nominal`, `tanggal`, `add_by`, `status`, `created_at`, `updated_at`) VALUES
(20, 'LND-0084', 130000, '2018-03-06', 1, 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(21, 'LND-0085', 12000, '2018-03-06', 1, 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(22, 'LND-0086', 100000, '2018-03-07', 1, 0, '2018-03-06 16:00:00', '2018-03-06 16:00:00'),
(23, 'LND-0087', 100000, '2018-03-07', 1, 0, '2018-03-06 16:00:00', '2018-03-06 16:00:00'),
(24, 'LND-0088', 25000, '2018-03-07', 1, 0, '2018-03-06 16:00:00', '2018-03-06 16:00:00'),
(25, 'LND-0090', 5000, '2018-04-03', 1, 0, '2018-04-02 16:00:00', '2018-04-02 16:00:00'),
(26, 'LND-0089', 40000, '2018-04-03', 1, 0, '2018-04-02 16:00:00', '2018-04-02 16:00:00'),
(27, 'LND-0091', 25000, '2018-04-03', 1, 0, '2018-04-02 16:00:00', '2018-04-02 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `gajis`
--

CREATE TABLE `gajis` (
  `id` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `gaji_pokok` int(11) NOT NULL,
  `tambahan` int(11) DEFAULT NULL,
  `potongan` int(11) DEFAULT NULL,
  `total` int(11) NOT NULL,
  `ket_tambahan` varchar(100) DEFAULT NULL,
  `ket_potongan` varchar(100) DEFAULT NULL,
  `add_by` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kas_besars`
--

CREATE TABLE `kas_besars` (
  `id` int(11) NOT NULL,
  `id_fk` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `debit` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `closed` int(11) NOT NULL,
  `add_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kas_besars`
--

INSERT INTO `kas_besars` (`id`, `id_fk`, `tanggal`, `harga`, `qty`, `debit`, `kredit`, `jenis`, `keterangan`, `closed`, `add_by`, `created_at`, `updated_at`) VALUES
(65, 19, '2018-03-06', 20000, 1, 20000, 0, 'Penjualan', 'PNJ-0001', 0, 1, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(66, 84, '2018-03-06', 130000, 1, 130000, 0, 'Pendapatan Jasa', 'LND-0084', 0, 1, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(67, 85, '2018-03-06', 12000, 1, 12000, 0, 'Pendapatan Jasa', 'LND-0085', 0, 1, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(68, 20, '2018-03-06', 20000, 1, 20000, 0, 'Penjualan', 'PNJ-0020', 0, 1, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(69, 21, '2018-03-06', 200000, 1, 200000, 0, 'Penjualan', 'PNJ-0021', 0, 1, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(70, 22, '2018-03-06', 60000, 1, 60000, 0, 'Penjualan', 'PNJ-0022', 0, 1, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(71, 86, '2018-03-07', 100000, 1, 100000, 0, 'Pendapatan Jasa', 'LND-0086', 0, 1, '2018-03-06 16:00:00', '2018-03-06 16:00:00'),
(72, 87, '2018-03-07', 100000, 1, 100000, 0, 'Pendapatan Jasa', 'LND-0087', 0, 1, '2018-03-06 16:00:00', '2018-03-06 16:00:00'),
(73, 88, '2018-03-07', 25000, 1, 25000, 0, 'Pendapatan Jasa', 'LND-0088', 0, 1, '2018-03-06 16:00:00', '2018-03-06 16:00:00'),
(74, 90, '2018-04-03', 5000, 1, 5000, 0, 'Pendapatan Jasa', 'LND-0090', 0, 1, '2018-04-02 16:00:00', '2018-04-02 16:00:00'),
(75, 89, '2018-04-03', 40000, 1, 40000, 0, 'Pendapatan Jasa', 'LND-0089', 0, 1, '2018-04-02 16:00:00', '2018-04-02 16:00:00'),
(76, 0, '2018-04-03', 10000, 2, 0, 20000, 'Kas Kecil', 'Beli Canang', 0, 1, '2018-04-02 17:38:10', '2018-04-02 17:38:10'),
(77, 23, '2018-04-03', 40000, 1, 40000, 0, 'Penjualan', 'PNJ-0023', 0, 1, '2018-04-02 16:00:00', '2018-04-02 16:00:00'),
(78, 1, '2018-04-03', 15000, 1, 0, 15000, 'Kas Kecil', 'KSC-0001', 0, 1, '2018-04-02 18:00:24', '2018-04-02 18:00:24'),
(79, 2, '2018-04-03', 10000, 1, 0, 10000, 'Kas Kecil', 'KSC-0002', 0, 1, '2018-04-02 18:13:54', '2018-04-02 18:13:54'),
(80, 91, '2018-04-03', 25000, 1, 25000, 0, 'Pendapatan Jasa', 'LND-0091', 0, 1, '2018-04-02 16:00:00', '2018-04-02 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `kas_kecils`
--

CREATE TABLE `kas_kecils` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  `add_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kas_kecils`
--

INSERT INTO `kas_kecils` (`id`, `kode`, `nominal`, `tanggal`, `status`, `closed`, `add_by`, `created_at`, `updated_at`) VALUES
(1, 'KSC-0001', 15000, '2018-04-03', 0, 0, 1, '2018-04-02 18:00:24', '2018-04-02 18:00:24'),
(2, 'KSC-0002', 10000, '2018-04-03', 0, 0, 1, '2018-04-02 18:13:54', '2018-04-02 18:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `kas_kecil_aruses`
--

CREATE TABLE `kas_kecil_aruses` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  `add_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kas_kecil_aruses`
--

INSERT INTO `kas_kecil_aruses` (`id`, `kode`, `tanggal`, `nama`, `harga`, `qty`, `total`, `keterangan`, `status`, `closed`, `add_by`, `created_at`, `updated_at`) VALUES
(1, 'KSC-0001', '2018-04-03', 'Paku', 5000, 1, 5000, NULL, 1, 0, 1, '2018-04-02 17:59:57', '2018-04-02 18:13:54'),
(2, 'KSC-0001', '2018-04-03', 'Canang', 2000, 5, 10000, NULL, 1, 0, 1, '2018-04-02 18:00:11', '2018-04-02 18:13:54'),
(3, 'KSC-0002', '2018-04-03', 'Canang', 10000, 1, 10000, NULL, 1, 0, 1, '2018-04-02 18:01:20', '2018-04-02 18:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_bulanans`
--

CREATE TABLE `laporan_bulanans` (
  `id` int(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jum_laundry` int(11) NOT NULL,
  `total_laundry` int(11) NOT NULL,
  `jum_penjualan` int(11) NOT NULL,
  `tot_penjualan` int(11) NOT NULL,
  `laba_penjualan` int(11) NOT NULL,
  `kerugian` int(11) NOT NULL,
  `other_income` int(11) NOT NULL,
  `add_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_harians`
--

CREATE TABLE `laporan_harians` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jum_laundry` int(11) NOT NULL,
  `total_laundry` int(11) NOT NULL,
  `jum_penjualan` int(11) NOT NULL,
  `tot_penjualan` int(11) NOT NULL,
  `laba_penjualan` int(11) NOT NULL,
  `fisik_uang` int(11) NOT NULL,
  `pengeluaran` int(11) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `add_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laporan_harians`
--

INSERT INTO `laporan_harians` (`id`, `tanggal`, `jum_laundry`, `total_laundry`, `jum_penjualan`, `tot_penjualan`, `laba_penjualan`, `fisik_uang`, `pengeluaran`, `keterangan`, `add_by`, `created_at`, `updated_at`) VALUES
(1, '2018-03-06', 3, 242000, 4, 300000, 45000, 142000, 0, NULL, 1, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(2, '2018-03-07', 2, 125000, 0, 0, 0, 225000, 0, NULL, 1, '2018-03-06 16:00:00', '2018-03-06 16:00:00'),
(5, '2018-04-03', 3, 70000, 1, 40000, 6000, 65000, 45000, NULL, 1, '2018-04-02 16:00:00', '2018-04-02 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `laundry_details`
--

CREATE TABLE `laundry_details` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `hanger` int(11) DEFAULT '0',
  `express` int(11) DEFAULT '0',
  `total` int(11) NOT NULL,
  `diskon_persen` double DEFAULT '0',
  `diskon_nominal` int(11) DEFAULT '0',
  `kode` varchar(30) NOT NULL,
  `harga` int(11) NOT NULL,
  `jenis` varchar(10) NOT NULL,
  `closed` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laundry_details`
--

INSERT INTO `laundry_details` (`id`, `id_barang`, `qty`, `hanger`, `express`, `total`, `diskon_persen`, `diskon_nominal`, `kode`, `harga`, `jenis`, `closed`, `created_at`, `updated_at`) VALUES
(79, 5, 10, NULL, NULL, 10000, NULL, NULL, 'LND-0059', 1000, 'laundry', 0, '2018-02-28 18:33:11', '2018-02-28 18:33:11'),
(80, 18, 3, NULL, NULL, 21000, NULL, NULL, 'LND-0060', 7000, 'laundry', 0, '2018-02-28 18:34:30', '2018-02-28 18:34:30'),
(81, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0061', 1000, 'laundry', 0, '2018-03-01 21:49:10', '2018-03-01 21:49:10'),
(82, 2, 100, NULL, NULL, 90000, 10, 10000, 'LND-0062', 1000, 'laundry', 0, '2018-03-02 17:39:48', '2018-03-02 17:39:48'),
(83, 41, 1, NULL, NULL, 38000, NULL, NULL, 'LND-0063', 38000, 'laundry', 0, '2018-03-02 16:00:00', '2018-03-02 16:00:00'),
(84, 2, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0064', 1000, 'laundry', 0, '2018-03-02 16:00:00', '2018-03-02 16:00:00'),
(86, 3, 25, NULL, NULL, 25000, NULL, NULL, 'LND-0065', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(88, 5, 25, NULL, NULL, 25000, NULL, NULL, 'LND-0069', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(89, 1, 10, NULL, NULL, 10000, NULL, NULL, 'LND-0070', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(90, 3, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0071', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(91, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0072', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(92, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0073', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(93, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0074', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(94, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0075', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(95, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0076', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(96, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0077', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(97, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0078', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(98, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0079', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(99, 2, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0080', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(100, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0081', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(101, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0082', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(102, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0083', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(103, 36, 10, NULL, NULL, 130000, NULL, NULL, 'LND-0084', 13000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(104, 42, 5, NULL, NULL, 10000, NULL, NULL, 'LND-0085', 2000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(105, 5, 2, NULL, NULL, 2000, NULL, NULL, 'LND-0085', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(106, 1, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0086', 1000, 'laundry', 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(107, 19, 100, NULL, NULL, 100000, NULL, NULL, 'LND-0087', 1000, 'laundry', 0, '2018-03-06 16:00:00', '2018-03-06 16:00:00'),
(108, 5, 25, NULL, NULL, 25000, NULL, NULL, 'LND-0088', 1000, 'laundry', 0, '2018-03-06 16:00:00', '2018-03-06 16:00:00'),
(109, 42, 20, NULL, NULL, 40000, NULL, NULL, 'LND-0089', 2000, 'laundry', 0, '2018-03-07 16:00:00', '2018-03-07 16:00:00'),
(110, 5, 3, NULL, NULL, 3000, NULL, NULL, 'LND-0090', 1000, 'laundry', 0, '2018-04-02 16:00:00', '2018-04-02 16:00:00'),
(111, 42, 1, NULL, NULL, 2000, NULL, NULL, 'LND-0090', 2000, 'laundry', 0, '2018-04-02 16:00:00', '2018-04-02 16:00:00'),
(112, 7, 5, NULL, NULL, 5000, NULL, NULL, 'LND-0091', 1000, 'laundry', 0, '2018-04-02 16:00:00', '2018-04-02 16:00:00'),
(113, 30, 2, NULL, NULL, 20000, NULL, NULL, 'LND-0091', 10000, 'laundry', 0, '2018-04-02 16:00:00', '2018-04-02 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `laundry_headers`
--

CREATE TABLE `laundry_headers` (
  `id` int(11) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `admin` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `diskon_persen` double DEFAULT NULL,
  `diskon_nominal` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_keluar` date DEFAULT NULL,
  `id_customer` int(11) NOT NULL,
  `grand_total` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `closed` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laundry_headers`
--

INSERT INTO `laundry_headers` (`id`, `kode`, `admin`, `total`, `diskon_persen`, `diskon_nominal`, `bayar`, `tgl_masuk`, `tgl_keluar`, `id_customer`, `grand_total`, `status`, `keterangan`, `closed`, `created_at`, `updated_at`) VALUES
(84, 'LND-0084', 1, 130000, 0, 0, 130000, '2018-03-06', '2018-03-06', 86, 130000, 'done', NULL, 0, '2018-03-05 16:00:00', '2018-03-05 21:20:20'),
(85, 'LND-0085', 1, 12000, 0, 0, 15000, '2018-03-06', '2018-03-06', 87, 12000, 'done', NULL, 0, '2018-03-05 16:00:00', '2018-03-05 21:20:26'),
(86, 'LND-0086', 1, 100000, NULL, NULL, 100000, '2018-03-06', '2018-03-08', 88, 100000, 'done', NULL, 0, '2018-03-05 16:00:00', '2018-03-06 17:57:53'),
(87, 'LND-0087', 1, 100000, NULL, NULL, 100000, '2018-03-07', '2018-03-09', 89, 100000, 'done', NULL, 0, '2018-03-06 16:00:00', '2018-03-06 17:57:53'),
(88, 'LND-0088', 1, 25000, NULL, NULL, 25000, '2018-03-07', '2018-03-09', 90, 25000, 'done', NULL, 0, '2018-03-06 16:00:00', '2018-03-06 17:57:53'),
(89, 'LND-0089', 1, 40000, NULL, NULL, 40000, '2018-03-08', '2018-04-03', 91, 40000, 'done', NULL, 0, '2018-03-07 16:00:00', '2018-04-02 17:36:07'),
(90, 'LND-0090', 1, 5000, 0, 0, 10000, '2018-04-03', '2018-04-03', 92, 5000, 'done', NULL, 0, '2018-04-02 16:00:00', '2018-04-02 17:35:03'),
(91, 'LND-0091', 1, 25000, 0, 0, 50000, '2018-04-03', '2018-04-03', 93, 25000, 'done', NULL, 0, '2018-04-02 16:00:00', '2018-04-02 18:23:01');

-- --------------------------------------------------------

--
-- Table structure for table `master_menus`
--

CREATE TABLE `master_menus` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_menus`
--

INSERT INTO `master_menus` (`id`, `nama`, `url`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'restok/view', '2018-03-07 01:49:27', '2018-03-06 16:00:00'),
(2, 'Data Laundry', 'laundry', '2018-03-07 01:50:24', '0000-00-00 00:00:00'),
(3, 'Penjualan', 'penjualan', '2018-03-07 01:52:37', '2018-03-07 01:52:37'),
(4, 'Arus Kas', 'aruskas', '2018-03-07 01:52:37', '2018-03-07 01:52:37'),
(5, 'Restok Barang', 'restok/view', '2018-03-07 01:53:57', '2018-03-07 01:53:57'),
(6, 'Biaya Bulanan', 'biaya-bulanan', '2018-03-07 01:53:57', '2018-03-07 01:53:57'),
(7, 'Other', 'other', '2018-03-07 01:56:14', '2018-03-07 01:56:14'),
(8, 'Master Data', 'master', '2018-03-07 01:56:14', '2018-03-07 01:56:14'),
(9, 'Laporan', 'laporan', '2018-03-07 01:56:34', '2018-03-07 01:56:34');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `others`
--

CREATE TABLE `others` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `add_by` int(11) NOT NULL,
  `jenis` int(6) NOT NULL,
  `closed` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_details`
--

CREATE TABLE `penjualan_details` (
  `id` int(11) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `id_brgjual` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `diskon_persen` double DEFAULT NULL,
  `diskon_nominal` int(11) DEFAULT NULL,
  `grand_total` int(11) NOT NULL,
  `keuntungan` int(11) NOT NULL,
  `add_by` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_details`
--

INSERT INTO `penjualan_details` (`id`, `kode`, `id_brgjual`, `qty`, `harga`, `total`, `diskon_persen`, `diskon_nominal`, `grand_total`, `keuntungan`, `add_by`, `status`, `closed`, `created_at`, `updated_at`) VALUES
(19, 'PNJ-0017', 3, 3, 20000, 60000, 0, 0, 60000, 9000, 1, 0, 0, '2018-02-28 18:18:42', '2018-02-28 18:18:42'),
(20, 'PNJ-0018', 3, 1, 20000, 20000, 0, 0, 20000, 3000, 1, 0, 0, '2018-02-28 16:00:00', '2018-02-28 16:00:00'),
(21, 'PNJ-0001', 3, 1, 20000, 20000, 0, 0, 20000, 3000, 1, 0, 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(22, 'PNJ-0020', 3, 1, 20000, 20000, 0, 0, 20000, 3000, 1, 0, 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(23, 'PNJ-0021', 3, 10, 20000, 200000, 0, 0, 200000, 30000, 1, 0, 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(24, 'PNJ-0022', 3, 3, 20000, 60000, 0, 0, 60000, 9000, 1, 0, 0, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(25, 'PNJ-0023', 3, 2, 20000, 40000, 0, 0, 40000, 6000, 1, 0, 0, '2018-04-02 16:00:00', '2018-04-02 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_headers`
--

CREATE TABLE `penjualan_headers` (
  `id` int(11) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `total` int(11) NOT NULL,
  `diskon_persen` double NOT NULL,
  `diskon_nominal` int(11) NOT NULL,
  `grand_total` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `bayar` int(11) NOT NULL,
  `total_laba` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  `add_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_headers`
--

INSERT INTO `penjualan_headers` (`id`, `kode`, `total`, `diskon_persen`, `diskon_nominal`, `grand_total`, `tanggal`, `bayar`, `total_laba`, `closed`, `add_by`, `created_at`, `updated_at`) VALUES
(19, 'PNJ-0001', 20000, 0, 0, 20000, '2018-03-06', 20000, 3000, 0, 1, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(20, 'PNJ-0020', 20000, 0, 0, 20000, '2018-03-06', 20000, 3000, 0, 1, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(21, 'PNJ-0021', 200000, 0, 0, 200000, '2018-03-06', 200000, 30000, 0, 1, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(22, 'PNJ-0022', 60000, 0, 0, 60000, '2018-03-06', 100000, 9000, 0, 1, '2018-03-05 16:00:00', '2018-03-05 16:00:00'),
(23, 'PNJ-0023', 40000, 0, 0, 40000, '2018-04-03', 50000, 6000, 0, 1, '2018-04-02 16:00:00', '2018-04-02 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `id` int(11) NOT NULL,
  `id_menu` int(4) NOT NULL,
  `admin` int(4) NOT NULL,
  `lihat` int(4) NOT NULL,
  `tambah` int(4) NOT NULL,
  `ubah` int(4) NOT NULL,
  `hapus` int(4) NOT NULL,
  `cetak` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `id_menu`, `admin`, `lihat`, `tambah`, `ubah`, `hapus`, `cetak`) VALUES
(1, 1, 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `profile_usahas`
--

CREATE TABLE `profile_usahas` (
  `id` int(11) NOT NULL,
  `nama_depan` varchar(30) NOT NULL,
  `nama_belakang` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `jam_opr` varchar(50) NOT NULL,
  `image` varchar(200) NOT NULL,
  `admin` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile_usahas`
--

INSERT INTO `profile_usahas` (`id`, `nama_depan`, `nama_belakang`, `alamat`, `phone`, `email`, `jam_opr`, `image`, `admin`, `created_at`, `updated_at`) VALUES
(1, 'Agus', 'Londre', 'Jl. Noja No. 22 Kesiman', '081237361059', 'agussuyasa@rocketmail.com', '07.00 - 22.00', 'logo2.png', 1, '2018-03-08 02:09:36', '2018-03-07 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `secrets`
--

CREATE TABLE `secrets` (
  `id` int(11) NOT NULL,
  `key_number` varchar(100) NOT NULL,
  `tgl_add` date NOT NULL,
  `tgl_exp` date NOT NULL,
  `add_by` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secrets`
--

INSERT INTO `secrets` (`id`, `key_number`, `tgl_add`, `tgl_exp`, `add_by`, `created_at`, `updated_at`) VALUES
(2, '627295e4e6777245c65620559b5018ea', '2018-02-01', '2018-07-12', '', '2018-03-03 03:22:44', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hak_akses` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `hak_akses`, `foto`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@admin.com', '$2y$10$8U4aZ0jvv0EvjzSPf8/17Ok2qFageAWjN6I.qGUuy81/bt7Vu7E6S', 'Super Admin', 'agus.JPG', 'RUXkidyVgJ4i4CALiEhQ2ck2ABsgTm8D8DJJga2D7cvUmh9DkkQx5tMgL6H6', '2018-02-11 23:25:19', '2018-04-02 22:44:18'),
(7, 'Agus Suyasa', 'rubyruck@gmail.com', '$2y$10$XF1sx/lwSBv8sbxm7q7ukO3XJAWrc9v/I248xHGOELEjhCaboxV/S', 'Admin', 'H0waSq.png', NULL, '2018-04-02 21:48:03', '2018-04-02 21:48:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_masters`
--
ALTER TABLE `barang_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biaya_bulanans`
--
ALTER TABLE `biaya_bulanans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biaya_bulanan_masters`
--
ALTER TABLE `biaya_bulanan_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brg_jual_masters`
--
ALTER TABLE `brg_jual_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bulans`
--
ALTER TABLE `bulans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_cashes`
--
ALTER TABLE `data_cashes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gajis`
--
ALTER TABLE `gajis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kas_besars`
--
ALTER TABLE `kas_besars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kas_kecils`
--
ALTER TABLE `kas_kecils`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kas_kecil_aruses`
--
ALTER TABLE `kas_kecil_aruses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_bulanans`
--
ALTER TABLE `laporan_bulanans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_harians`
--
ALTER TABLE `laporan_harians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laundry_details`
--
ALTER TABLE `laundry_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laundry_headers`
--
ALTER TABLE `laundry_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_menus`
--
ALTER TABLE `master_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `others`
--
ALTER TABLE `others`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `penjualan_details`
--
ALTER TABLE `penjualan_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan_headers`
--
ALTER TABLE `penjualan_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_usahas`
--
ALTER TABLE `profile_usahas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secrets`
--
ALTER TABLE `secrets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_masters`
--
ALTER TABLE `barang_masters`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `biaya_bulanans`
--
ALTER TABLE `biaya_bulanans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biaya_bulanan_masters`
--
ALTER TABLE `biaya_bulanan_masters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `brg_jual_masters`
--
ALTER TABLE `brg_jual_masters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bulans`
--
ALTER TABLE `bulans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `data_cashes`
--
ALTER TABLE `data_cashes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `gajis`
--
ALTER TABLE `gajis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_besars`
--
ALTER TABLE `kas_besars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `kas_kecils`
--
ALTER TABLE `kas_kecils`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kas_kecil_aruses`
--
ALTER TABLE `kas_kecil_aruses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `laporan_bulanans`
--
ALTER TABLE `laporan_bulanans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan_harians`
--
ALTER TABLE `laporan_harians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `laundry_details`
--
ALTER TABLE `laundry_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `laundry_headers`
--
ALTER TABLE `laundry_headers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `master_menus`
--
ALTER TABLE `master_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `others`
--
ALTER TABLE `others`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualan_details`
--
ALTER TABLE `penjualan_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `penjualan_headers`
--
ALTER TABLE `penjualan_headers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profile_usahas`
--
ALTER TABLE `profile_usahas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `secrets`
--
ALTER TABLE `secrets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
