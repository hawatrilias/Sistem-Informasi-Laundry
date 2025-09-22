-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2025 at 09:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `jenis_laundry`
--

CREATE TABLE `jenis_laundry` (
  `id_jenis` int(255) NOT NULL,
  `jenis_laundry` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_laundry`
--

INSERT INTO `jenis_laundry` (`id_jenis`, `jenis_laundry`, `harga`) VALUES
(11111, 'pakaian', 5000.00),
(22222, 'seprai', 15000.00),
(33333, 'selimut', 20000.00),
(44444, 'jaket', 10000.00),
(55555, 'karpet', 30000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(225) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`) VALUES
(10101, 'Hana Caraka'),
(20202, 'Data Sawala'),
(30303, 'Maga Batanga');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(225) NOT NULL,
  `id_pelanggan` int(255) NOT NULL,
  `tanggal_terima` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `id_jenis` int(225) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `jumlah` int(255) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `tanggal_terima`, `tanggal_selesai`, `id_jenis`, `harga`, `jumlah`, `total`) VALUES
(1, 10101, '2011-11-01', '2025-09-22', 2025, 5000.00, 2, 10000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_laundry`
--
ALTER TABLE `jenis_laundry`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_laundry`
--
ALTER TABLE `jenis_laundry`
  MODIFY `id_jenis` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55556;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30304;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
