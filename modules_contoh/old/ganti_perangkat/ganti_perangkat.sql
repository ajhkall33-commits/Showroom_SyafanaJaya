-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2024 at 09:23 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fids`
--

-- --------------------------------------------------------

--
-- Table structure for table `ganti_perangkat`
--

CREATE TABLE `ganti_perangkat` (
  `fasilitas` varchar(255) NOT NULL,
  `no_tiket` int(11) NOT NULL,
  `perangkat_awal` varchar(255) NOT NULL,
  `perangkat_baru` varchar(255) NOT NULL,
  `lokasi_perangkatlama` varchar(255) NOT NULL,
  `jam_mulai` datetime NOT NULL,
  `jam_selesai` datetime NOT NULL,
  `foto_sebelum` varchar(255) NOT NULL,
  `foto_sesudah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ganti_perangkat`
--

INSERT INTO `ganti_perangkat` (`fasilitas`, `no_tiket`, `perangkat_awal`, `perangkat_baru`, `lokasi_perangkatlama`, `jam_mulai`, `jam_selesai`, `foto_sebelum`, `foto_sesudah`) VALUES
('2', 9, '2', '16', '8', '2024-01-03 20:26:00', '2024-01-17 15:22:00', 'Screenshot_(42).png', 'Screenshot_(42).png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ganti_perangkat`
--
ALTER TABLE `ganti_perangkat`
  ADD PRIMARY KEY (`no_tiket`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ganti_perangkat`
--
ALTER TABLE `ganti_perangkat`
  MODIFY `no_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
