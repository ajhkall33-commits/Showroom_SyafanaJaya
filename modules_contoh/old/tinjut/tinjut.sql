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
-- Table structure for table `tinjut`
--

CREATE TABLE `tinjut` (
  `id_tiket` int(11) NOT NULL,
  `pembuat` varchar(11) NOT NULL,
  `fasilitas` varchar(11) NOT NULL,
  `tanggal_start` datetime NOT NULL,
  `tanggal_end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tinjut`
--

INSERT INTO `tinjut` (`id_tiket`, `pembuat`, `fasilitas`, `tanggal_start`, `tanggal_end`) VALUES
(1, 'elza', '18', '2024-01-15 11:51:00', '2024-01-15 11:24:00'),
(1, 'satrio', '19', '2024-01-15 11:54:00', '2024-01-15 11:05:00'),
(1, 'elza', '18', '2024-01-15 12:13:00', '2024-01-15 12:13:00'),
(1, 'elza', '18', '2024-01-15 12:13:00', '2024-01-15 12:13:00'),
(1, 'elza', '19', '2024-01-15 12:09:00', '2024-01-15 12:37:00'),
(1, 'elza', '13', '2024-01-15 12:16:00', '2024-01-15 12:38:00'),
(1, 'elza', '18', '2024-01-15 12:17:00', '2024-01-15 12:45:00'),
(1, 'elza', '10', '2024-01-15 12:30:00', '2024-01-15 12:53:00'),
(1, 'elza', '0', '2024-01-15 12:37:00', '2024-01-15 12:00:00'),
(1, 'elza', '-', '2024-01-15 12:44:00', '2024-01-15 12:00:00'),
(1, '$_SESSION', '10', '2024-01-15 13:09:00', '2024-01-15 13:09:00'),
(1, '$_SESSION', '5', '2024-01-15 16:15:00', '2024-01-15 16:37:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
