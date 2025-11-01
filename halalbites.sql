-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 01, 2025 at 06:21 PM
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
-- Database: `halalbites`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `delivery_instructions` text DEFAULT NULL,
  `branch` varchar(50) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `delivery_time` varchar(50) DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `delivery_instructions`, `branch`, `payment_method`, `delivery_time`, `special_requests`, `created_at`) VALUES
(1, 'm sidiki', 'msidiki075@gmail.com', '03277379390', 'Adnan Sami\r\nAdnan', 'hhhhhhhhh', 'uptown', 'card', 'take time', 'jjjjjjjjj', '2025-05-19 04:48:02'),
(2, 'haris', 'yasi@333gmail.com', '03277379390', 'lodhran', 'hhhhhhhhhh', 'uptown', 'card', 'take time', 'hhhh', '2025-05-19 04:51:25'),
(3, 'kali', '', '03277379390', 'multab', 'kkkk', 'uptown', 'card', 'take time', 'yyyy', '2025-05-19 04:59:06'),
(4, 'm sidiki', '', '03226677789', 'Adnan Sami\r\nAdnan', 'mo', 'uptown', 'jazzcash', 'take time', 'hhh', '2025-05-19 05:03:28'),
(5, 'zahid', 'msiddiqui99@gmail.com', '03000000567', 'Adnan Sami\r\nAdnan', 'floor 2nd', 'riverside', 'cash', 'take time', 'no need', '2025-05-19 05:06:17'),
(6, 'm sidiki', 'msidiqui99@gmail.com', '03226677789', 'Adnan Sami\r\nAdnan', 'gate', 'uptown', 'jazzcash', 'take time', 'jjjj', '2025-05-19 05:08:54'),
(7, 'Abdullah', 'ab@gamil.com', '03445666789', 'bwp', 'Gate floor', 'uptown', 'card', 'take time', 'kkkkk', '2025-05-19 05:16:14'),
(8, 'yasir', 'yasi@333gmail.com', '03000000567', 'multan', 'hello', 'uptown', 'easypaisa', 'take time', 'no need', '2025-05-19 05:22:13'),
(9, 'Asghar', 'asghar@33gamil.com', '03020976388', 'Ghreed Abad P/O Gogran Lodhran', 'instructuion', 'uptown', 'easypaisa', 'take time', 'special requst', '2025-05-19 05:25:48'),
(10, 'ahmed', 'msiddiqui99@gmail.com', '03277379390', 'Adnan Sami\r\nAdnan', 'gate', 'uptown', 'jazzcash', 'take time', 'requested', '2025-05-19 06:17:47'),
(11, 'sidiqui', 'sidiki@gmail.com', '03000000567', 'lodhran', 'hello', 'uptown', 'jazzcash', 'take time', 'special request', '2025-05-19 06:56:29'),
(12, 'm sidiki', '', '03226677789', 'Adnan Sami\r\nAdnan', 'j,', 'uptown', 'jazzcash', 'take time', 'mmmmmmm', '2025-05-19 09:24:48'),
(13, 'kaleem', 'kali@gmail.com', '03000000567', 'Multan', 'Gate Code', 'uptown', 'jazzcash', 'take time', 'utenils Needed', '2025-05-19 15:25:57'),
(14, 'siddiqui', 'msiddiqui99@gmail.com', '03277379390', 'lodhran', 'floor', 'uptown', 'easypaisa', 'take time', 'needed', '2025-05-19 15:30:17'),
(15, 'm sidiki', '', '03000000567', 'Adnan Sami\r\nAdnan', '', 'uptown', 'jazzcash', 'take time', '', '2025-05-19 16:00:29'),
(17, 'kali', 'kali@gmail.com', '03277379387', 'Ghreed Abad P/O Gogran Lodhran', 'gate', 'uptown', 'jazzcash', 'take time', 'allergies', '2025-05-20 16:03:00'),
(18, 'haris', 'msiddiqui99@gmail.com', '03000000567', 'bwp', 'gate', 'uptown', 'easypaisa', 'take time', 'ttt', '2025-05-22 07:37:24'),
(19, 'kaleem', 'yasi@333gmail.com', '03277379390', 'Ghreed Abad P/O Gogran Lodhran', 'floor', 'riverside', 'easypaisa', 'take time', 'neede', '2025-05-22 07:41:51');

-- --------------------------------------------------------

--
-- Stand-in structure for view `customer_order_count`
-- (See below for the actual view)
--
CREATE TABLE `customer_order_count` (
`customer_id` int(11)
,`customer_name` varchar(100)
,`phone` varchar(20)
,`number_of_orders` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total_amount`, `status`, `created_at`) VALUES
(1, 1, 1950.00, 'pending', '2025-05-19 04:48:02'),
(2, 2, 1800.00, 'pending', '2025-05-19 04:51:25'),
(3, 3, 750.00, 'pending', '2025-05-19 04:59:06'),
(4, 4, 2150.00, 'pending', '2025-05-19 05:03:28'),
(5, 5, 4000.00, 'pending', '2025-05-19 05:06:17'),
(6, 6, 1450.00, 'pending', '2025-05-19 05:08:54'),
(7, 7, 850.00, 'pending', '2025-05-19 05:16:14'),
(8, 8, 2440.00, 'pending', '2025-05-19 05:22:13'),
(9, 9, 1800.00, 'pending', '2025-05-19 05:25:48'),
(10, 10, 1450.00, 'pending', '2025-05-19 06:17:47'),
(11, 11, 2250.00, 'pending', '2025-05-19 06:56:29'),
(12, 12, 1160.00, 'pending', '2025-05-19 09:24:48'),
(13, 13, 1800.00, 'pending', '2025-05-19 15:25:57'),
(14, 14, 1950.00, 'pending', '2025-05-19 15:30:17'),
(15, 15, 500.00, 'pending', '2025-05-19 16:00:29'),
(17, 17, 2250.00, 'pending', '2025-05-20 16:03:00'),
(18, 18, 1450.00, 'pending', '2025-05-22 07:37:24'),
(19, 19, 1800.00, 'pending', '2025-05-22 07:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item_name`, `quantity`, `price`) VALUES
(1, 1, 'Chicken Biryani', 5, 250.00),
(2, 1, 'Beef Karahi', 2, 350.00),
(3, 2, 'Chicken Biryani', 3, 250.00),
(4, 2, 'Beef Karahi', 3, 350.00),
(5, 3, 'Chicken Biryani', 3, 250.00),
(6, 4, 'Chicken Biryani', 3, 250.00),
(7, 4, 'Beef Karahi', 4, 350.00),
(8, 5, 'Chicken Biryani', 2, 250.00),
(9, 5, 'Beef Karahi', 10, 350.00),
(10, 6, 'Chicken Biryani', 3, 250.00),
(11, 6, 'Beef Karahi', 2, 350.00),
(12, 7, 'Beef Karahi', 2, 350.00),
(13, 7, 'Lasi', 3, 50.00),
(14, 8, 'Chicken Biryani', 2, 250.00),
(15, 8, 'Chicken Tikka', 2, 300.00),
(16, 8, 'Seekh Kabab', 3, 280.00),
(17, 8, 'Kheer', 2, 100.00),
(18, 8, 'Chicken Roll', 2, 150.00),
(19, 9, 'Chicken Tikka', 3, 300.00),
(20, 9, 'Haleem', 3, 200.00),
(21, 9, 'Kheer', 3, 100.00),
(22, 10, 'Chicken Biryani', 3, 250.00),
(23, 10, 'Beef Karahi', 2, 350.00),
(24, 11, 'Chicken Biryani', 3, 250.00),
(25, 11, 'Chicken Tikka', 4, 300.00),
(26, 11, 'Kheer', 3, 100.00),
(27, 12, 'Haleem', 3, 200.00),
(28, 12, 'Seekh Kabab', 2, 280.00),
(29, 13, 'Chicken Biryani', 3, 250.00),
(30, 13, 'Beef Karahi', 3, 350.00),
(31, 14, 'Chicken Tikka', 3, 300.00),
(32, 14, 'Haleem', 3, 200.00),
(33, 14, 'Chicken Roll', 3, 150.00),
(34, 15, 'Beef Karahi', 1, 350.00),
(35, 15, 'Lassi', 3, 50.00),
(38, 17, 'Chicken Biryani', 2, 250.00),
(39, 17, 'Beef Karahi', 5, 350.00),
(40, 18, 'Chicken Biryani', 3, 250.00),
(41, 18, 'Beef Karahi', 2, 350.00),
(42, 19, 'Chicken Biryani', 3, 250.00),
(43, 19, 'Beef Karahi', 3, 350.00);

-- --------------------------------------------------------

--
-- Stand-in structure for view `popular_menu_items`
-- (See below for the actual view)
--
CREATE TABLE `popular_menu_items` (
`item_name` varchar(100)
,`total_ordered` decimal(32,0)
,`average_price` decimal(14,6)
);

-- --------------------------------------------------------

--
-- Structure for view `customer_order_count`
--
DROP TABLE IF EXISTS `customer_order_count`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `customer_order_count`  AS SELECT `customers`.`id` AS `customer_id`, `customers`.`name` AS `customer_name`, `customers`.`phone` AS `phone`, count(`orders`.`id`) AS `number_of_orders` FROM (`customers` left join `orders` on(`customers`.`id` = `orders`.`customer_id`)) GROUP BY `customers`.`id`, `customers`.`name`, `customers`.`phone` ;

-- --------------------------------------------------------

--
-- Structure for view `popular_menu_items`
--
DROP TABLE IF EXISTS `popular_menu_items`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `popular_menu_items`  AS SELECT `order_items`.`item_name` AS `item_name`, sum(`order_items`.`quantity`) AS `total_ordered`, avg(`order_items`.`price`) AS `average_price` FROM (`order_items` join `orders` on(`order_items`.`order_id` = `orders`.`id`)) WHERE `orders`.`status` <> 'cancelled' GROUP BY `order_items`.`item_name` ORDER BY sum(`order_items`.`quantity`) DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
