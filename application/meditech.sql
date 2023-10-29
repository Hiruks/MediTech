-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2023 at 06:01 AM
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
(1, 'Pinindi', 'pinindi@123.com', 77777777, 'whitelisted', '2023-10-28'),
(2, 'hiruka', 'hiruka.karasinghe@gmail.com', 718398731, 'whitelisted', '2023-10-28'),
(3, 'amanda', 'amanda@39802.com', 444444444, 'blacklisted', '2023-10-28'),
(4, 'rivini', 'rivini@34798324.com', 718398731, 'blacklisted', '2023-10-28'),
(6, 'Erwin', 'erwin.rowell@brbr.com', 718398777, 'whitelisted', '2023-10-28'),
(7, 'Hiruka Karasinghe', 'hiruka.karasinghe@gm.c', 71833, 'whitelisted', '2023-10-28'),
(16, 'Neranji Abeyratne', 'hiruka.entry@gmail.com', 2147483647, 'whitelisted', '2023-10-28'),
(17, 'Neranji Abeyratne', 'hiruka.entry@gmail.com', 2147483647, 'whitelisted', '2023-10-28'),
(18, 'Hiruka Karasinghe', 'hiruka.karasinghe@gmail.com', 718335411, 'whitelisted', '2023-10-28');

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
(1, 'Admin', 1, 'hiruka.karasinghe@gmail.com', 'Hiruka', 'Hiruka', 718398731, '2023-10-26'),
(2, 'Sales', 2, 'hiruka.sales@gmail.com', 'Hiruka', 'Rowel', 718398731, '2023-10-28'),
(3, 'DataEntry', 2, 'hiruka.entry@gmail.com', 'Hiruka', 'Gobbels', 718398731, '2023-10-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`custID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `custID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
