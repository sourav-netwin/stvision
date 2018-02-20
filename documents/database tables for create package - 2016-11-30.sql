-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 30, 2016 at 03:39 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vision_plus`
--

-- --------------------------------------------------------

--
-- Table structure for table `agnt_accommodation`
--

DROP TABLE IF EXISTS `agnt_accommodation`;
CREATE TABLE IF NOT EXISTS `agnt_accommodation` (
  `accom_id` int(11) NOT NULL AUTO_INCREMENT,
  `accom_name` varchar(255) NOT NULL,
  `accom_type` enum('Students','Group Leaders') NOT NULL DEFAULT 'Students' COMMENT 'Type of accomodation',
  PRIMARY KEY (`accom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `agnt_accommodation`
--

INSERT INTO `agnt_accommodation` (`accom_id`, `accom_name`, `accom_type`) VALUES
(1, 'Ensuite', 'Students'),
(2, 'Standard', 'Students'),
(3, 'Homestay', 'Students'),
(4, 'Ensuite', 'Group Leaders'),
(5, 'Standard', 'Group Leaders'),
(6, 'Homestay', 'Group Leaders');

-- --------------------------------------------------------

--
-- Table structure for table `agnt_activities`
--

DROP TABLE IF EXISTS `agnt_activities`;
CREATE TABLE IF NOT EXISTS `agnt_activities` (
  `act_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Pk',
  `act_activity_name` varchar(255) NOT NULL COMMENT 'Activity name',
  `act_description` text NOT NULL COMMENT 'Description',
  `act_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'date of creation',
  `act_created_by` int(11) NOT NULL COMMENT 'inserted/created by',
  PRIMARY KEY (`act_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `agnt_activities`
--

INSERT INTO `agnt_activities` (`act_id`, `act_activity_name`, `act_description`, `act_created_on`, `act_created_by`) VALUES
(1, 'Cricket', 'Description', '2016-11-30 11:51:23', 1),
(2, 'Football', 'Description', '2016-11-30 11:51:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `agnt_campus_activities`
--

DROP TABLE IF EXISTS `agnt_campus_activities`;
CREATE TABLE IF NOT EXISTS `agnt_campus_activities` (
  `actm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Pk',
  `actm_campus_id` int(11) NOT NULL,
  `actm_act_id` int(11) NOT NULL,
  PRIMARY KEY (`actm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `agnt_campus_activities`
--

INSERT INTO `agnt_campus_activities` (`actm_id`, `actm_campus_id`, `actm_act_id`) VALUES
(1, 6, 1),
(2, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `agnt_campus_excursion`
--

DROP TABLE IF EXISTS `agnt_campus_excursion`;
CREATE TABLE IF NOT EXISTS `agnt_campus_excursion` (
  `excm_map_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Pk mapped id',
  `excm_campus_id` int(11) NOT NULL COMMENT 'Campus for which excursion is mapped',
  `excm_exc_id` int(11) NOT NULL COMMENT 'excursion id',
  PRIMARY KEY (`excm_map_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `agnt_campus_excursion`
--

INSERT INTO `agnt_campus_excursion` (`excm_map_id`, `excm_campus_id`, `excm_exc_id`) VALUES
(1, 6, 1),
(2, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `agnt_courses_type`
--

DROP TABLE IF EXISTS `agnt_courses_type`;
CREATE TABLE IF NOT EXISTS `agnt_courses_type` (
  `courses_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Pk',
  `courses_type` varchar(255) NOT NULL COMMENT 'Courses type name',
  PRIMARY KEY (`courses_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `agnt_courses_type`
--

INSERT INTO `agnt_courses_type` (`courses_type_id`, `courses_type`) VALUES
(1, 'Morning'),
(2, 'Afternoon');

-- --------------------------------------------------------

--
-- Table structure for table `agnt_excursions`
--

DROP TABLE IF EXISTS `agnt_excursions`;
CREATE TABLE IF NOT EXISTS `agnt_excursions` (
  `exc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Pk',
  `exc_excursion_name` varchar(255) NOT NULL COMMENT 'Name of the excusion',
  `exc_brief_description` text NOT NULL COMMENT 'Description',
  `exc_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'created on date',
  `exc_created_by` int(11) NOT NULL COMMENT 'inserted/created by',
  PRIMARY KEY (`exc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `agnt_excursions`
--

INSERT INTO `agnt_excursions` (`exc_id`, `exc_excursion_name`, `exc_brief_description`, `exc_created_on`, `exc_created_by`) VALUES
(1, 'Tower bridge', 'description', '2016-11-30 10:46:55', 1),
(2, 'City pride', 'description', '2016-11-30 10:46:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `agnt_packages`
--

DROP TABLE IF EXISTS `agnt_packages`;
CREATE TABLE IF NOT EXISTS `agnt_packages` (
  `pack_package_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'package primary key',
  `pack_package` varchar(255) NOT NULL COMMENT 'package name',
  `pack_campus_id` int(11) NOT NULL COMMENT 'specific campus selected id',
  `pack_start_date` datetime NOT NULL,
  `pack_expiry_date` datetime NOT NULL,
  `pack_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'package created on date',
  `pack_created_by` int(11) NOT NULL COMMENT 'package created by, login user id',
  PRIMARY KEY (`pack_package_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `agnt_packages`
--

INSERT INTO `agnt_packages` (`pack_package_id`, `pack_package`, `pack_campus_id`, `pack_start_date`, `pack_expiry_date`, `pack_created_on`, `pack_created_by`) VALUES
(4, 'Packages', 6, '2016-12-01 00:00:00', '2016-12-27 00:00:00', '2016-11-30 15:21:39', 706),
(5, 'Second Package', 6, '2016-12-01 00:00:00', '2016-12-22 00:00:00', '2016-11-30 15:23:29', 706);

-- --------------------------------------------------------

--
-- Table structure for table `agnt_package_services`
--

DROP TABLE IF EXISTS `agnt_package_services`;
CREATE TABLE IF NOT EXISTS `agnt_package_services` (
  `serv_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'pk',
  `serv_package_id` int(11) NOT NULL COMMENT 'package id',
  `serv_service_id` int(11) NOT NULL COMMENT 'selected exursion or activity id',
  `serv_service_type` enum('STD Accommodation','GL Accommodation','Excursion','Activity','Course Type') NOT NULL COMMENT 'Is it excursion or activity',
  `serv_budget` double(10,2) NOT NULL,
  `serv_cost` double(10,2) NOT NULL,
  `serv_sell_price` double(10,2) NOT NULL,
  PRIMARY KEY (`serv_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='This table will have multiple records for package excursion and attractions' AUTO_INCREMENT=18 ;

--
-- Dumping data for table `agnt_package_services`
--

INSERT INTO `agnt_package_services` (`serv_id`, `serv_package_id`, `serv_service_id`, `serv_service_type`, `serv_budget`, `serv_cost`, `serv_sell_price`) VALUES
(7, 4, 2, 'STD Accommodation', 22.00, 55.00, 66.00),
(8, 4, 3, 'STD Accommodation', 11.00, 44.00, 77.00),
(9, 5, 1, 'STD Accommodation', 11.00, 22.00, 33.00),
(10, 5, 2, 'STD Accommodation', 14.00, 25.00, 36.00),
(11, 5, 1, 'GL Accommodation', 24.00, 58.00, 68.00),
(12, 5, 2, 'GL Accommodation', 35.00, 98.00, 68.00),
(13, 5, 2, 'Excursion', 358.00, 58.00, 65.00),
(14, 5, 1, 'Excursion', 33.00, 55.00, 88.00),
(15, 5, 2, 'Activity', 33.00, 55.00, 88.00),
(16, 5, 1, 'Course Type', 24.00, 88.00, 88.00),
(17, 5, 2, 'Course Type', 33.00, 66.00, 88.00);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
