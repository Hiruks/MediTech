-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2023 at 05:19 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meditech`
--

-- --------------------------------------------------------

--
-- Table structure for table `creditterms`
--

CREATE TABLE `creditterms` (
  `id` int(11) NOT NULL,
  `overdue_period` int(11) NOT NULL,
  `blacklisted_period` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `creditterms`
--

INSERT INTO `creditterms` (`id`, `overdue_period`, `blacklisted_period`) VALUES
(1, 2, 3),
(2, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `custID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contactNo` int(10) NOT NULL,
  `status` enum('whitelisted','blacklisted','','') NOT NULL DEFAULT 'whitelisted',
  `registered_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`custID`, `name`, `email`, `contactNo`, `status`, `registered_date`) VALUES
(2, 'hiruka', 'hiruka.karasinghe@gmail.com', 718398731, 'whitelisted', '2023-10-28'),
(17, 'Neranji Abeyratne', 'hiruka.entry@gmail.com', 2147483647, 'blacklisted', '2023-10-28'),
(29, 'Hiruka Karasinghe', 'hiruka.karasinghe@gmail.com', 718335411, 'blacklisted', '2023-10-31'),
(31, 'Hiruka Karasinghe', 'hiruka.karasinghe@gmail.com', 718335411, 'whitelisted', '2023-10-31'),
(33, 'Hiruka K', 'hiruka.karasinghe@gmail.com', 71833541, 'whitelisted', '2023-10-31'),
(35, 'Gobbels Rowel', 'hiruka.karasinghe@gmail.com', 718335411, 'whitelisted', '2023-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `custID` int(11) NOT NULL,
  `creditTermID` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `isPaid` tinyint(1) NOT NULL DEFAULT 0,
  `created_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `custID`, `creditTermID`, `value`, `isPaid`, `created_date`) VALUES
(16, 31, 2, 12500, 1, '2023-11-12'),
(17, 2, 2, 13800, 0, '2023-11-12'),
(18, 31, 1, 1000, 1, '2023-11-12'),
(19, 35, 1, 31200, 0, '2023-11-13');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `order_product_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`order_product_id`, `order_id`, `product_id`, `quantity`) VALUES
(8, 16, 29, 4),
(9, 16, 28, 2),
(10, 17, 30, 6),
(11, 18, 28, 4),
(12, 19, 30, 9),
(13, 19, 29, 3),
(14, 19, 28, 6);

-- --------------------------------------------------------

--
-- Table structure for table `payment_records`
--

CREATE TABLE `payment_records` (
  `id` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `reciptNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_records`
--

INSERT INTO `payment_records` (`id`, `orderID`, `img`, `date`, `reciptNo`) VALUES
(5, 16, '1699780242_344024.jpeg', '2023-11-12', 269044),
(6, 18, '1699790378_630194.jpeg', '2023-11-12', 269045);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `title`, `description`, `price`, `img`, `created_date`) VALUES
(28, 'Dental MBT Brackets', 'MBT Brackets, Nickel Titanium', 250, '1699257988_423078.jpg', '2023-11-05'),
(29, 'Hygent Alginate', 'Alignate Impression material by Hygent', 3000, '1699258000_622025.jpg', '2023-11-05'),
(30, 'Xylocaine', '1% Epinephrine Injection', 2300, '1699258007_509815.jpg', '2023-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `userType` enum('DataEntry','Sales','Admin','') NOT NULL,
  `branchID` int(5) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `contactNo` int(10) NOT NULL,
  `registered_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `userType`, `branchID`, `email`, `password`, `name`, `contactNo`, `registered_date`) VALUES
(1, 'Admin', 1, 'hiruka.karasinghe@gmail.com', 'Hiruka', 'Mike', 718398731, '2023-10-26'),
(2, 'Sales', 2, 'hiruka.sales@gmail.com', 'Hiruka', 'Rowel   ', 718398731, '2023-10-28'),
(3, 'DataEntry', 2, 'hiruka.entry@gmail.com', 'Hiruka', 'Gobbels  ', 718398731, '2023-10-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `creditterms`
--
ALTER TABLE `creditterms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`custID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custID` (`custID`),
  ADD KEY `creditID` (`creditTermID`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`order_product_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment_records`
--
ALTER TABLE `payment_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderID` (`orderID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `creditterms`
--
ALTER TABLE `creditterms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `custID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `order_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payment_records`
--
ALTER TABLE `payment_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `creditID` FOREIGN KEY (`creditTermID`) REFERENCES `creditterms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `custID` FOREIGN KEY (`custID`) REFERENCES `customers` (`custID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`productID`);

--
-- Constraints for table `payment_records`
--
ALTER TABLE `payment_records`
  ADD CONSTRAINT `orderID` FOREIGN KEY (`orderID`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
