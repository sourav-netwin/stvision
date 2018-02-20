-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2016 at 05:46 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2waycom_plus`
--

-- --------------------------------------------------------

--
-- Table structure for table `plused_fincm_services`
--

CREATE TABLE IF NOT EXISTS `plused_fincm_services` (
  `pcse_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pcse_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `pcse_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pcse_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `plused_fincm_services`
--

INSERT INTO `plused_fincm_services` (`pcse_id`, `pcse_code`, `pcse_name`) VALUES
(1, 'REF', 'Refreshments'),
(2, 'STT', 'Stationery'),
(3, 'STP', 'Students Prizes'),
(4, 'MOB', 'Mobile'),
(5, 'TAX', 'Taxi'),
(6, 'SPE', 'Sports equipment'),
(7, 'POS', 'Postage'),
(8, 'CRE', 'Card recharge'),
(9, 'OTH', 'Others');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
