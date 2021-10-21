-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Sep 06, 2020 at 01:53 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `seventeen_july`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cartID` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userID` int(6) NOT NULL,
  PRIMARY KEY (`cartID`),
  KEY `userID` (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `userID`) VALUES
(14, 13),
(13, 9),
(12, 0),
(11, 4),
(10, 0),
(9, 10);

-- --------------------------------------------------------

--
-- Table structure for table `cartdetails`
--

DROP TABLE IF EXISTS `cartdetails`;
CREATE TABLE IF NOT EXISTS `cartdetails` (
  `cartdetailsid` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cartID` int(6) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `size` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`cartdetailsid`),
  KEY `cartID` (`cartID`) USING BTREE,
  KEY `name` (`name`(250)),
  KEY `size` (`size`(250))
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `promoID` int(11) NOT NULL AUTO_INCREMENT,
  `shoesName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`promoID`),
  KEY `sn` (`shoesName`(250))
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotion`
--

INSERT INTO `promotion` (`promoID`, `shoesName`, `discount`) VALUES
(43, 'Air Jordan 1 Retro High Off White Chicago', '0.05'),
(46, 'Air Jordan 1 Retro High Travis Scott', '0.05'),
(35, 'Nike Air Force 1 Low Off White Black White', '0.05'),
(37, 'Nike Air VaporMax Off White Black', '0.05');

-- --------------------------------------------------------

--
-- Table structure for table `shoes`
--

DROP TABLE IF EXISTS `shoes`;
CREATE TABLE IF NOT EXISTS `shoes` (
  `shoesID` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `gender` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`shoesID`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoes`
--

INSERT INTO `shoes` (`shoesID`, `brand`, `name`, `category`, `color`, `price`, `gender`, `description`) VALUES
(1, 'nike', 'Air Jordan 1 Retro High Off White Chicago', 'lifestyle', 'red', '26880.00', 'M', ''),
(26, 'nike', 'Air Jordan 1 Retro High Travis Scott', 'lifestyle', 'sail', '7000.00', 'M', ''),
(32, 'nike', 'Nike SB Dunk Low Travis Scott', 'lifestyle', 'sail', '7200.00', 'K', ''),
(17, 'nike', 'Nike Air Max 97 Off White Menta', 'lifestyle', 'menta', '3200.00', 'M', ''),
(59, 'converse', 'Converse Chuck Taylor All Star 70s Hi Off White', 'lifestyle', 'white', '2200.00', 'F', 'converse'),
(7, 'nike', 'Nike Air Force 1 Low Off White Black White', 'lifestyle', 'black', '3300.00', 'M', ''),
(38, 'nike', 'Nike Air Max 97 Off White White', 'lifestyle', 'white', '4400.00', 'F', ''),
(9, 'nike', 'Nike Air Prest Off White White', 'lifestyle', 'white', '2550.00', 'M', ''),
(19, 'nike', 'Nike Air VaporMax Off White Black', 'lifestyle', 'black', '3800.00', 'M', ''),
(31, 'nike', 'Air Jordan 1 Retro High Tie Dye', 'lifestyle', 'blue', '1300.00', 'K', ''),
(37, 'nike', 'Air Jordan 5 Retro Off White Black', 'lifestyle', 'black', '2200.00', 'M', ''),
(66, 'nike', 'Air Jordan 1 Retro High Dior', 'lifestyle', 'grey white', '50000.00', 'F', 'Diorrrr'),
(60, 'adidas', 'adidas Yeezy Boost 350 V2 Zyon', 'lifestyle', 'zyon', '1300.00', 'M', 'yeezyyyyyyyy'),
(61, 'adidas', 'adidas Yeezy Boost 350 V2 Yecheil (Non-Reflective)', 'lifestyle', 'yecheil', '1500.00', 'K', 'Yeezy adds a flare to one of its most well-known designs with the adidas Yeezy 350 Yecheil Non-Reflective, now available on StockX. This 350 V2 strays away from the usual earth tones with a colorful palette, making it stand out from previous releases. This model was released in both reflective and non-reflective variations.'),
(62, 'puma', 'Puma RS-Dreamer J. Cole Black', 'lifestyle', 'black', '800.00', 'M', 'Don’t sleep on your dreams. They keep us grinding and thriving. Few people dream bigger than hip-hop legend J. Cole and to celebrate his and others’ audacious dreams, we’ve teamed up to bring you the RS-Dreamer. We took the bold elements of the RS series and turned them into a fully playable pair of kicks. RS-Dreamer features PUMA Hoops tech, like a ProFoam midsole and a high abrasion rubber outsole, next level design, and a J. Cole’s “Dreamer” emblem to remind you to never be afraid to dream big. Never sleeping. Always dreaming.'),
(63, 'puma', 'Puma RS-X3 Puzzle Puma White', 'lifestyle', 'dazzling red', '600.00', 'F', 'X marks extreme. Exaggerated. Remixed.X³ takes things to a new level: cubed, enhanced, extra. We’ve taken the signature RS design and dialed it up to the third power. With amp...'),
(65, 'adidas', 'adidas YZY QNTM (Lifestyle Model)', 'lifestyle', 'grey white', '3000.00', 'K', 'A Unique Shoes');

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

DROP TABLE IF EXISTS `size`;
CREATE TABLE IF NOT EXISTS `size` (
  `sizeID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `size` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`sizeID`),
  KEY `name` (`name`(250))
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`sizeID`, `name`, `size`, `quantity`) VALUES
(3, 'Air Jordan 1 Retro High Off White Chicago', 'UK 7.0', 4),
(4, 'Air Jordan 1 Retro High Off White Chicago', 'UK 7.5', 2),
(5, 'Air Jordan 1 Retro High Tie Dye', 'UK 4.5', 6),
(6, 'Air Jordan 1 Retro High Tie Dye', 'UK 4.0', 3),
(7, 'Air Jordan 1 Retro High Travis Scott', 'UK 9.0', 3),
(8, 'Air Jordan 1 Retro High Travis Scott', 'UK 8.0', 4),
(9, 'Air Jordan 5 Retro Off White Black', 'UK 5.0', 4),
(10, 'Air Jordan 5 Retro Off White Black', 'UK 4.5', 7),
(70, 'Converse Chuck Taylor All Star 70s Hi Off White', 'UK 5.0', 6),
(69, 'Converse Chuck Taylor All Star 70s Hi Off White', 'UK 4.5', 7),
(13, 'Nike Air Force 1 Low Off White Black White', 'UK 5.5', 7),
(14, 'Nike Air Force 1 Low Off White Black White', 'UK 6.5', 3),
(15, 'Nike Air Max 97 Off White Menta', 'UK 4.0', 5),
(16, 'Nike Air Max 97 Off White Menta', 'UK 7.5', 3),
(17, 'Nike Air Max 97 Off White White', 'UK 4.0', 5),
(18, 'Nike Air Max 97 Off White White', 'UK 4.5', 3),
(19, 'Nike Air Prest Off White White', 'UK 7.5', 6),
(20, 'Nike Air Prest Off White White', 'UK 8.0', 4),
(21, 'Nike Air VaporMax Off White Black', 'UK 5.0', 4),
(22, 'Nike Air VaporMax Off White Black', 'UK 6.5', 3),
(23, 'Nike SB Dunk Low Travis Scott', 'UK 7.5', 5),
(24, 'Nike SB Dunk Low Travis Scott', 'UK 8.0', 7),
(82, 'adidas YZY QNTM (Lifestyle Model)', 'UK 4.5', 4),
(81, 'adidas YZY QNTM (Lifestyle Model)', 'UK 4.0', 2),
(78, 'Puma RS-X3 Puzzle Puma White', 'UK 6.5', 4),
(77, 'Puma RS-X3 Puzzle Puma White', 'UK 5.5', 3),
(76, 'Puma RS-Dreamer J. Cole Black', 'UK 7.5', 3),
(75, 'Puma RS-Dreamer J. Cole Black', 'UK 6.5', 4),
(74, 'adidas Yeezy Boost 350 V2 Yecheil (Non-Reflective)', 'UK 5.0', 3),
(73, 'adidas Yeezy Boost 350 V2 Yecheil (Non-Reflective)', 'UK 4.5', 2),
(72, 'adidas Yeezy Boost 350 V2 Zyon', 'UK 6.5', 3),
(71, 'adidas Yeezy Boost 350 V2 Zyon', 'UK 6.0', 2),
(84, 'Air Jordan 1 Retro High Dior', 'UK 6.0', 2),
(83, 'Air Jordan 1 Retro High Dior', 'UK 5.5', 2);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `taskID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `description` text,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`taskID`),
  KEY `userID` (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`taskID`, `userID`, `description`, `status`) VALUES
(1, 4, 'Add 3 Shoes Promotion', 'Y'),
(2, 4, 'Remove Air Jordan Dior', 'Y'),
(3, 5, 'Sleep', 'N'),
(6, 4, 'Add New Jordan Shoes', 'Y'),
(7, 4, 'Remove offwhite promotion', 'Y'),
(12, 12, 'Add 3 Shoes Promotion', 'N'),
(9, 1, 'sleep pls', 'N'),
(10, 1, 'wake up', 'N'),
(11, 4, 'Clean the floor', 'Y'),
(13, 12, 'Add 2 New Shoes', 'N'),
(14, 12, 'Remove 1 Shoes Promotion', 'Y'),
(15, 17, 'Add 2 New Shoes', 'N'),
(16, 17, 'Add 3 Shoes Promotion', 'N'),
(17, 17, 'Remove 1 Shoes Promotion', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `country` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL,
  `contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `role`, `username`, `password`, `first_name`, `last_name`, `dob`, `country`, `gender`, `contact`, `create_at`) VALUES
(14, 'admin', 'admin@mail.com', '$2y$10$qSMB0/JWjevcYyyFrLxnTetRt2bjnoEIRAmUT8lk9SAfXCiBhN08K', 'admin', 'admin', '2020-09-04', 'Singapore', 'M', '0123456789', '2020-09-04 14:03:31'),
(13, 'user', 'customer@mail.com', '$2y$10$dpi5/lA2dYkRW8mBxHCOsOLmudWENjrK8/31J7.VFhG/30Jgb6xR6', 'customer', 'customer', '2020-09-04', 'Singapore', 'F', '0123456789', '2020-09-04 14:02:50'),
(17, 'staff', 'staff@mail.com', '$2y$10$WhBKL.iUnyT3iaS0ws4of.6vZ3z5HRNXEFW/UQxRn7Jhxh9opZ9zy', 'staff', 'staff', '2020-09-04', 'Singapore', 'M', '0123456789', '2020-09-04 21:23:57');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
