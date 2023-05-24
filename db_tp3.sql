-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2023 at 07:45 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tp3`
--

-- --------------------------------------------------------

--
-- Table structure for table `klub`
--

CREATE TABLE `klub` (
  `klub_id` int(11) NOT NULL,
  `klub_nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `klub`
--

INSERT INTO `klub` (`klub_id`, `klub_nama`) VALUES
(1, 'Manchester City'),
(2, 'Manchester United'),
(3, 'Liverpool'),
(4, 'Tottenham Hotspur'),
(5, 'Arsenal'),
(6, 'Chelsea FC'),
(7, 'Newcastle United');

-- --------------------------------------------------------

--
-- Table structure for table `pemain`
--

CREATE TABLE `pemain` (
  `pemain_id` int(11) NOT NULL,
  `pemain_foto` varchar(255) DEFAULT NULL,
  `pemain_nama` varchar(100) DEFAULT NULL,
  `pemain_no_punggung` int(2) DEFAULT NULL,
  `pemain_tinggi` int(5) DEFAULT NULL,
  `pemain_usia` int(5) DEFAULT NULL,
  `klub_id` int(11) DEFAULT NULL,
  `posisi_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemain`
--

INSERT INTO `pemain` (`pemain_id`, `pemain_foto`, `pemain_nama`, `pemain_no_punggung`, `pemain_tinggi`, `pemain_usia`, `klub_id`, `posisi_id`) VALUES
(1, 'haaland.jpeg', 'Erling Haaland', 9, 193, 22, 1, 7),
(2, 'salah.jpg', 'Mohamed Salah', 10, 175, 30, 3, 8),
(3, 'maguire.jpg', 'Harry Maguire', 5, 194, 30, 2, 2),
(17, 'son.jpg', 'Son Heung-min', 7, 183, 30, 4, 9),
(18, 'kepa.jpg', 'Kepa Arrizabalaga', 1, 186, 28, 6, 1),
(19, 'odegard.jpeg', 'Martin Ødegaard', 8, 178, 24, 5, 6),
(20, 'kdb.jpeg', 'Kevin De Bruyne', 17, 181, 31, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `posisi`
--

CREATE TABLE `posisi` (
  `posisi_id` int(11) NOT NULL,
  `posisi_nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posisi`
--

INSERT INTO `posisi` (`posisi_id`, `posisi_nama`) VALUES
(1, 'Goal Keeper'),
(2, 'Center Back'),
(3, 'Wing Back'),
(4, 'Defender Midfielder'),
(5, 'Center Midfielder'),
(6, 'Attack Midfielder'),
(7, 'Center Forward'),
(8, 'Right Wing Forward'),
(9, 'Left Wing Forward');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `klub`
--
ALTER TABLE `klub`
  ADD PRIMARY KEY (`klub_id`);

--
-- Indexes for table `pemain`
--
ALTER TABLE `pemain`
  ADD PRIMARY KEY (`pemain_id`),
  ADD KEY `klub_id` (`klub_id`),
  ADD KEY `posisi_id` (`posisi_id`);

--
-- Indexes for table `posisi`
--
ALTER TABLE `posisi`
  ADD PRIMARY KEY (`posisi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klub`
--
ALTER TABLE `klub`
  MODIFY `klub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pemain`
--
ALTER TABLE `pemain`
  MODIFY `pemain_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `posisi`
--
ALTER TABLE `posisi`
  MODIFY `posisi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemain`
--
ALTER TABLE `pemain`
  ADD CONSTRAINT `pemain_ibfk_1` FOREIGN KEY (`klub_id`) REFERENCES `klub` (`klub_id`),
  ADD CONSTRAINT `pemain_ibfk_2` FOREIGN KEY (`posisi_id`) REFERENCES `posisi` (`posisi_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
