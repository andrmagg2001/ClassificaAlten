-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2024 at 01:24 AM
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
-- Database: `ca`
--

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `score` double NOT NULL,
  `win` int(10) UNSIGNED NOT NULL,
  `lose` int(10) UNSIGNED NOT NULL,
  `img` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `name`, `score`, `win`, `lose`, `img`) VALUES
(2, 'Stefano', 6.75, 8, 8, 'backend/skins/img/players/Stefano.png'),
(3, 'Giuliano', 10, 16, 5, 'backend/skins/img/players/Giuliano.png'),
(4, 'Luis', 6, 8, 4, 'backend/skins/img/players/lvi.png'),
(5, 'Andrea', 5.25, 8, 10, 'backend/skins/img/players/Andrea.png'),
(6, 'Valerio L', 8.75, 13, 5, 'backend/skins/img/players/ValerioL.png'),
(7, 'Luca', 3, 4, 9, 'backend/skins/img/players/Luca.png'),
(8, 'Matteo DP', 2, 2, 12, 'backend/skins/img/players/MatteoDP.png'),
(9, 'Matteo M', 2, 2, 7, 'backend/skins/img/players/MM.png'),
(10, 'Federico', 0, 0, 0, 'backend/skins/img/players/Federico.png'),
(11, 'Pier Giorgio', 0, 0, 0, 'backend/skins/img/players/pgd.jpg'),
(12, 'Gianmarco', 0, 0, 0, 'backend/skins/img/players/Zizzo.png'),
(13, 'Silvia', 0, 0, 0, 'backend/skins/img/players/Silvia.png'),
(14, 'Valerio B', 0, 0, 1, 'backend/skins/img/players/ValerioB.png'),
(15, 'Daniele A', 0, 0, 2, 'backend/skins/img/players/DanieleA.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
