-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 21, 2025 at 11:02 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbkita`
--

-- --------------------------------------------------------

--
-- Table structure for table `productfish`
--

CREATE TABLE `productfish` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `kategori` varchar(100) DEFAULT NULL,
  `berat` int DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `productfish`
--

INSERT INTO `productfish` (`id`, `nama`, `deskripsi`, `kategori`, `berat`, `harga`, `gambar`) VALUES
(12, 'IKAN NILA', 'Lezat dimakan nyamnyam', 'konsumsi', 2, 50000, '1752224467_IKAN MUJAIR.jpg'),
(13, 'IKAN KOI', 'Menarik dan unik', 'hias', 1, 30000, '1752224528_IKAN KOI.jpg'),
(16, 'IKAN CUPANG', 'Indah dan berestetika', 'hias', 1, 21000, '1752224753_IKAN CUPANG.jpeg'),
(17, 'IKAN LELE', 'Air tawar, berkhasiat', 'konsumsi', 1, 19000, '1752224811_IKAN LELE.jpeg'),
(22, 'IKAN GURAME', 'Besar, Banyak Khasiat', 'konsumsi', 1, 31000, '1753091485_IKAN GURAME.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `productfish`
--
ALTER TABLE `productfish`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `productfish`
--
ALTER TABLE `productfish`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
