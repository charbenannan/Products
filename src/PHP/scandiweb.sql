-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2023 at 11:00 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scandiweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `size` int(11) DEFAULT 0,
  `weight` int(11) DEFAULT 0,
  `height` int(11) DEFAULT 0,
  `width` int(11) DEFAULT 0,
  `length` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `product_type`, `name`, `price`, `size`, `weight`, `height`, `width`, `length`, `created_at`) VALUES
(1, 'JVC200120', 'DVD', 'Acme Disc', 1, 700, NULL, NULL, NULL, NULL, '2023-01-28 20:25:32'),
(2, 'JVC200121', 'DVD', 'Acme Disc', 1, 700, NULL, NULL, NULL, NULL, '2023-01-28 20:25:38'),
(3, 'JVC200122', 'DVD', 'Acme Disc', 1, 700, NULL, NULL, NULL, NULL, '2023-01-28 20:25:43'),
(4, 'JVC200123', 'DVD', 'Acme Disc', 1, 700, NULL, NULL, NULL, NULL, '2023-01-28 20:25:50'),
(5, 'GGWP0001', 'Book', 'War and Peace', 20, NULL, 2, NULL, NULL, NULL, '2023-01-28 20:39:06'),
(6, 'GGWP0002', 'Book', 'War and Peace', 20, NULL, 2, NULL, NULL, NULL, '2023-01-28 20:39:14'),
(7, 'GGWP0003', 'Book', 'War and Peace', 20, NULL, 2, NULL, NULL, NULL, '2023-01-28 20:39:19'),
(8, 'GGWP0004', 'Book', 'War and Peace', 20, NULL, 2, NULL, NULL, NULL, '2023-01-28 20:39:23'),
(9, 'TR120500', 'Furniture', 'Chair', 40, NULL, NULL, 24, 45, 15, '2023-01-28 20:41:07'),
(10, 'TR120501', 'Furniture', 'Chair', 40, NULL, NULL, 24, 45, 15, '2023-01-28 20:41:11'),
(11, 'TR120502', 'Furniture', 'Chair', 40, NULL, NULL, 24, 45, 15, '2023-01-28 20:41:16'),
(12, 'TR120503', 'Furniture', 'Chair', 40, NULL, NULL, 24, 45, 15, '2023-01-28 20:41:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
