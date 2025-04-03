-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 03, 2025 at 05:27 PM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u581098102_connecteasy`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogpage`
--

CREATE TABLE `blogpage` (
  `sno` int(11) NOT NULL,
  `blogimage` varchar(255) NOT NULL,
  `blogheading` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogpage`
--

INSERT INTO `blogpage` (`sno`, `blogimage`, `blogheading`) VALUES
(1, '1.jpg', 'blog');

-- --------------------------------------------------------

--
-- Table structure for table `homepage`
--

CREATE TABLE `homepage` (
  `sno` int(11) NOT NULL,
  `homeimage` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage`
--

INSERT INTO `homepage` (`sno`, `homeimage`, `heading`) VALUES
(6, 'top (1).jpg', 'Welcome to Connecteasy Travels');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `sno` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `highlight` varchar(255) NOT NULL,
  `day` int(11) NOT NULL,
  `night` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trip`
--

CREATE TABLE `trip` (
  `sno` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fromlocation` varchar(255) NOT NULL,
  `tolocation` varchar(255) NOT NULL,
  `adults` int(11) NOT NULL,
  `kids` int(11) NOT NULL,
  `typeoftrip` varchar(255) NOT NULL,
  `departdate` date NOT NULL,
  `returndate` date NOT NULL,
  `budget` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trip`
--

INSERT INTO `trip` (`sno`, `firstname`, `lastname`, `email`, `phone`, `fromlocation`, `tolocation`, `adults`, `kids`, `typeoftrip`, `departdate`, `returndate`, `budget`) VALUES
(27, 'zdykAcNi', 'GYnAXExYM', 'nvoaqkdydhnwha@yahoo.com', '3796378927', 'SMUwTHIkCE', 'ZyEHvZpdN', 0, 0, 'One Way Trip', '2024-11-07', '0000-00-00', 'luxury'),
(28, 'OmReyrJAoG', 'oBURMpYN', 'hatfielddainam@gmail.com', '7699707550', 'lULouNbOFo', 'kFXAJTeObijh', 0, 0, 'One Way Trip', '2024-11-09', '0000-00-00', 'luxury'),
(29, 'VjKiemYiCDuFK', 'dGDuZWLRHEu', 'ikbkycixt@yahoo.com', '7589731099', 'ULYOsJGQZmNWFwL', 'nAdgJkRpHfTUQB', 0, 0, 'One Way Trip', '2024-11-16', '0000-00-00', 'luxury'),
(30, 'BGHBgGaLwM', 'VTUmBBrXC', 'hmollilv2001@gmail.com', '8140592089', 'PjIOAKXTL', 'rwXiMIoBqtWRvr', 0, 0, 'One Way Trip', '2024-11-24', '0000-00-00', 'luxury'),
(31, 'mUKSChkJOZltbB', 'LwVmJAPdPOQnuqf', 'jenevabto28@gmail.com', '9756397002', 'onYSilJIwXwaMts', 'HXpcmvJWZunHbZ', 0, 0, 'One Way Trip', '2024-11-25', '0000-00-00', 'luxury'),
(32, 'YsrAivxPFfq', 'xGwojkrUKYJ', 'vqunh17@yahoo.com', '5881067213', 'GKlufqXntmqLg', 'FZLzSTvEc', 0, 0, 'One Way Trip', '2024-11-26', '0000-00-00', 'luxury'),
(33, 'dzKftTBB', 'YkwmGEwxh', 't1onzcziwqp@yahoo.com', '5515145522', 'sroSCQLiBaC', 'PYBnXCdQubI', 0, 0, 'One Way Trip', '2024-12-25', '0000-00-00', 'luxury'),
(34, 'PfRiHhBmeis', 'xBujtZhPWar', 'uyaxexejuk17@gmail.com', '6045466434', 'acHTmpEbU', 'MBcWsZKWuq', 0, 0, 'One Way Trip', '2024-12-31', '0000-00-00', 'luxury'),
(35, 'YshBqtAfp', 'FtkZCfUVZ', 'geyutahikaz532@gmail.com', '3662376982', 'pvtAphUwT', 'wypCTZPUb', 0, 0, 'One Way Trip', '2025-01-01', '0000-00-00', 'luxury'),
(36, 'zhPucRExXC', 'PccCQLxSaLrBF', 'ficofitin59@gmail.com', '6998565026', 'aONDxTrZMjONgVU', 'yPklOpitIq', 0, 0, 'One Way Trip', '2025-01-09', '0000-00-00', 'luxury'),
(37, 'UUOUMDEwjHMnvE', 'bhifaceM', 'uniqagopi92@gmail.com', '8051765852', 'QUdybmgsvfDqk', 'WCQmdCpwCcrHx', 0, 0, 'One Way Trip', '2025-01-10', '0000-00-00', 'luxury'),
(38, 'ptXxfDXnHAYy', 'ifBtHnDqdmBGb', 'hvjjmwmkchksrgm@yahoo.com', '6854771551', 'eryupmPYXVcZD', 'GpauhvDi', 0, 0, 'One Way Trip', '2025-01-19', '0000-00-00', 'luxury'),
(39, 'PdrfDmNNNioQF', 'GvjJxWlfVPsRZuT', 'hvjjmwmkchksrgm@yahoo.com', '5479351532', 'zQEhqoneIxO', 'mnAqtUEw', 0, 0, 'One Way Trip', '2025-01-20', '0000-00-00', 'luxury'),
(40, 'John', 'TestUser', 'pqeitynx@do-not-respond.me', '+10 8105137', 'MyName', 'Alice', 291, 480, 'Select Trip', '2029-01-13', '2007-10-02', 'all'),
(41, 'GCFGpduTiUrWde', 'lexXVTnwYGnI', 'wgvetqwbesdcyn@yahoo.com', '6617425397', 'MDjprUPT', 'yaDeGnBpI', 0, 0, 'One Way Trip', '2025-02-21', '0000-00-00', 'luxury'),
(42, 'Hello', 'Hello', 'gshvyvzh@testing-your-form.info', '+35 5468341045', 'Alice', 'Hello', 551, 869, 'Select Trip', '2006-09-17', '2013-05-26', 'all');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogpage`
--
ALTER TABLE `blogpage`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `homepage`
--
ALTER TABLE `homepage`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogpage`
--
ALTER TABLE `blogpage`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `homepage`
--
ALTER TABLE `homepage`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `trip`
--
ALTER TABLE `trip`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
