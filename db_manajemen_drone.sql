-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2026 at 09:18 AM
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
-- Database: `db_manajemen_drone`
--

-- --------------------------------------------------------

--
-- Table structure for table `drones`
--

CREATE TABLE `drones` (
  `id` int(11) NOT NULL,
  `kode_drone` varchar(20) NOT NULL,
  `merk_model` varchar(100) NOT NULL,
  `kondisi` enum('Siap Terbang','Dalam Perbaikan','Rusak') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drones`
--

INSERT INTO `drones` (`id`, `kode_drone`, `merk_model`, `kondisi`, `created_at`) VALUES
(1, 'DRN-001', 'DJI Mavic 3 Pro', 'Siap Terbang', '2026-06-06 04:35:53'),
(2, 'DRN-002', 'DJI Inspire 3', 'Rusak', '2026-06-06 04:35:53'),
(4, 'DRN-003', 'DJI T100', 'Siap Terbang', '2026-06-06 10:27:47'),
(5, 'DRN-004', 'DJI T75', 'Dalam Perbaikan', '2026-06-06 10:28:03'),
(6, 'DRN-005', 'DJI T25', 'Siap Terbang', '2026-06-06 10:28:19'),
(7, 'DRN-006', 'GX-30', 'Rusak', '2026-06-06 10:28:39'),
(8, 'DRN-004', 'DJI Agras T100', 'Rusak', '2026-06-13 06:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_kerja`
--

CREATE TABLE `lokasi_kerja` (
  `id` int(11) NOT NULL,
  `distrik` enum('Distrik Bengkal','Distrik Santan','Distrik Sebulu','Distrik Sei mao') NOT NULL,
  `no_spk` varchar(50) NOT NULL,
  `no_petak` varchar(50) NOT NULL,
  `tanggal_ops` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi_kerja`
--

INSERT INTO `lokasi_kerja` (`id`, `distrik`, `no_spk`, `no_petak`, `tanggal_ops`, `created_at`) VALUES
(2, 'Distrik Santan', '586958268', 'B32083286', '2026-06-03', '2026-06-06 04:41:47'),
(3, 'Distrik Santan', '512896874', 'B32083283', '2026-06-11', '2026-06-06 07:17:25'),
(4, 'Distrik Santan', '512896875', 'B32083285', '2026-06-24', '2026-06-12 08:09:09'),
(5, 'Distrik Sei mao', '586958256', 'A5895699', '2026-06-25', '2026-06-12 08:12:37'),
(6, 'Distrik Sebulu', '586958267', 'B32083288', '2026-06-11', '2026-06-13 06:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Admin','User') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `status`, `created_at`) VALUES
(1, 'admin', 'admin123', 'Admin', '2026-06-06 04:35:53'),
(2, 'user', 'user123', 'User', '2026-06-06 10:30:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drones`
--
ALTER TABLE `drones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi_kerja`
--
ALTER TABLE `lokasi_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drones`
--
ALTER TABLE `drones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lokasi_kerja`
--
ALTER TABLE `lokasi_kerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
