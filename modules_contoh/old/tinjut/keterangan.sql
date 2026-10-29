-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2024 at 06:49 AM
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
-- Table structure for table `keterangan`
--

CREATE TABLE `keterangan` (
  `id_keterangan` int(255) NOT NULL,
  `id_trouble` varchar(255) NOT NULL,
  `id_detail_trouble` varchar(255) NOT NULL,
  `id_detail` varchar(255) NOT NULL,
  `id_status` varchar(255) NOT NULL,
  `id_tiket` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keterangan`
--

INSERT INTO `keterangan` (`id_keterangan`, `id_trouble`, `id_detail_trouble`, `id_detail`, `id_status`, `id_tiket`) VALUES
(6, '19', '19', '19', '19', ''),
(7, '2', '2', '2', '2', ''),
(8, '1,19', '1,19', '1,19', '1,19', ''),
(9, '1,5', '1,5', '1,5', '1,5', ''),
(10, '1,19,17,11', '1,19,17,11', '1,19,17,11', '1,19,17,13', ''),
(11, '1,18,15', '1,18,15', '1,18,15', '1,18,15', '1'),
(12, '1', '1', '1', '1', '1'),
(13, '18,19', '1,19', '1,19', '1,19', '1'),
(14, '1,17', '6,11', '8,11', '13,17', '1'),
(15, '7,12', '8,12', '10,12', '10,12', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keterangan`
--
ALTER TABLE `keterangan`
  ADD PRIMARY KEY (`id_keterangan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keterangan`
--
ALTER TABLE `keterangan`
  MODIFY `id_keterangan` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
