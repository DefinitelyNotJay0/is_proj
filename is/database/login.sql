-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 10:22 AM
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
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstName`, `email`, `password`) VALUES
(1, 'admin', 'admin@admin.com', 'theAdmin00');

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_stocks`
--

INSERT INTO `product_stocks` (`id`, `product_name`, `image_path`, `price`, `quantity`, `category`) VALUES
(1, 'Seraph T800', 'pic/seraphT800.jpg', 23000.00, 10, 'Frames'),
(2, 'Cervelo P5', 'pic/cerveloP5.jpg', 340000.00, 5, 'Frames'),
(3, 'Argon 18 ElectronPro', 'pic/argon18.jpg', 365000.00, 3, 'Frames'),
(4, 'Sugino Zen CrankSet', 'pic/suginoCrankset.jpg', 20000.00, 15, 'Crankset'),
(5, 'Sugino Zen Chainring', 'pic/suginoZenRing.jpg', 10000.00, 20, 'Chainring'),
(6, 'DuraAce Track Hubs', 'pic/duraAceHubs.jpg', 25000.00, 10, 'Hubs'),
(7, 'Izumi Jet Black', 'pic/izumiJetBlack.jpg', 3000.00, 25, 'Chains'),
(8, 'BMC TimeMachine', 'pic/bmc_timemachine.jpg', 120000.00, 10, 'Frames'),
(9, 'Alpina Fork', 'pic/alpinaFork.jpg', 3000.00, 12, 'Forks'),
(10, 'Alpina Dropbar', 'pic/alpina_dropbar.jpg', 6000.00, 10, 'Dropbars'),
(11, 'Giro Gloves', 'pic/giro_gloves.jpg', 1500.00, 4, 'Gloves'),
(12, 'Giro Helmet', 'pic/giro_helmet.jpg', 5000.00, 7, 'Helmets'),
(13, 'Cycling Shoes', 'pic/specialized_shoes.jpg', 12000.00, 3, 'Shoes');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sale_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_name`, `quantity`, `sale_date`) VALUES
(1, 'Road Bike', 50, '2025-05-01'),
(2, 'Mountain Bike', 30, '2025-05-02'),
(3, 'Helmet', 70, '2025-05-03'),
(4, 'Cycling Shoes', 40, '2025-05-04'),
(5, 'Gloves', 25, '2025-05-05'),
(6, 'Road Bike', 20, '2025-05-06'),
(7, 'Helmet', 15, '2025-05-07'),
(8, 'Mountain Bike', 10, '2025-05-08'),
(9, 'Cycling Shoes', 30, '2025-05-09'),
(10, 'Gloves', 5, '2025-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `sales_history`
--

CREATE TABLE `sales_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `sale_type` enum('online','physical') NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_history`
--

INSERT INTO `sales_history` (`id`, `product_id`, `sale_date`, `sale_type`, `quantity`) VALUES
(13, 1, '2025-01-15', 'physical', 5),
(14, 2, '2025-01-20', 'online', 3),
(15, 3, '2025-02-10', 'physical', 7),
(16, 4, '2025-02-15', 'online', 4),
(17, 5, '2025-03-05', 'physical', 8),
(18, 6, '2025-03-12', 'online', 6),
(19, 7, '2025-04-08', 'physical', 10),
(20, 8, '2025-04-18', 'online', 7),
(21, 9, '2025-05-02', 'physical', 12),
(22, 10, '2025-05-20', 'online', 9),
(23, 11, '2025-06-10', 'physical', 15),
(24, 12, '2025-06-25', 'online', 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`) VALUES
(0, 'noel', 'cerbito jr.', 'cerbito0806@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e'),
(0, 'Welcome', 'Admin', 'admin@admin.com', '$2y$10$0x.3SyzfGp5rumZIxd/a/../7U6gRhMcnbNTq2B.Cxu'),
(0, 'robert', 'cerbito', 'robertcerbito@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e'),
(0, 'leon', 'cebits', 'leon@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e'),
(0, 'jay', 'cerbito', 'jay@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_history`
--
ALTER TABLE `sales_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sales_history`
--
ALTER TABLE `sales_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
