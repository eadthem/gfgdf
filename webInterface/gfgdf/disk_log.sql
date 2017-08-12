-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 12, 2017 at 10:04 PM
-- Server version: 10.0.29-MariaDB
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gfgdf`
--

-- --------------------------------------------------------

--
-- Table structure for table `disk_log`
--

CREATE TABLE IF NOT EXISTS `disk_log` (
  `id` bigint(20) unsigned NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `drive_erased` tinyint(1) NOT NULL,
  `smart_passed` tinyint(1) NOT NULL,
  `drive_model` char(32) NOT NULL,
  `drive_serial` char(32) NOT NULL,
  `station_ip` char(52) NOT NULL,
  `station_mac` char(20) NOT NULL,
  `note` mediumtext NOT NULL,
  `family` char(32) NOT NULL,
  `size` char(12) NOT NULL,
  `reallocatedSectCount` char(24) NOT NULL,
  `uncorrectableSectCount` char(24) NOT NULL,
  `reallocatedEventCount` char(24) NOT NULL,
  `currentPendingSectCount` char(24) NOT NULL,
  `offlineUncorrectableCount` char(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disk_log`
--
ALTER TABLE `disk_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disk_log`
--
ALTER TABLE `disk_log`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
