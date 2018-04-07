-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2018 at 06:48 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `poll`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbadministrators`
--

CREATE TABLE IF NOT EXISTS `tbadministrators` (
  `admin_id` int(5) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbadministrators`
--

INSERT INTO `tbadministrators` (`admin_id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'Rohit ', 'Suri', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `tbcandidates`
--

CREATE TABLE IF NOT EXISTS `tbcandidates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `election_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `tbcandidates`
--

INSERT INTO `tbcandidates` (`id`, `candidate_id`, `election_id`) VALUES
(23, 6, 3),
(24, 5, 4),
(25, 6, 4),
(26, 1, 4),
(27, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbelections`
--

CREATE TABLE IF NOT EXISTS `tbelections` (
  `election_id` int(11) NOT NULL AUTO_INCREMENT,
  `election_name` varchar(255) NOT NULL,
  `reg_date` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('S','F','P','C') NOT NULL,
  PRIMARY KEY (`election_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbelections`
--

INSERT INTO `tbelections` (`election_id`, `election_name`, `reg_date`, `start_date`, `end_date`, `status`) VALUES
(1, 'Municipality Election Bakura', '2018-03-31', '2018-03-25', '2018-03-31', 'C'),
(2, 'Municipality Election 24 N Pngs', '2018-03-04', '2018-03-25', '2018-03-31', 'S'),
(3, 'Municipality Election Panihati', '2018-03-01', '2018-03-04', '2018-03-17', 'S'),
(4, 'Municipality Election Kamarhati', '2018-03-12', '2018-03-18', '2018-03-24', 'F'),
(5, 'Municipality Election Dunlop', '2018-03-01', '2018-03-20', '2018-03-24', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `tbmembers`
--

CREATE TABLE IF NOT EXISTS `tbmembers` (
  `member_id` int(5) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `voter_id` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `voter_status` int(11) NOT NULL DEFAULT '0',
  `candi_status` int(11) NOT NULL DEFAULT '0',
  `is_candidate` int(11) NOT NULL DEFAULT '0',
  `milestones` text NOT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `voter_id` (`voter_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbmembers`
--

INSERT INTO `tbmembers` (`member_id`, `first_name`, `last_name`, `email`, `voter_id`, `password`, `voter_status`, `candi_status`, `is_candidate`, `milestones`) VALUES
(1, 'Md. Rezwanul', 'Haque', 'rezwan@gmail.com', '1996471408', '202cb962ac59075b964b07152d234b70', 1, 1, 1, 'hOW U DOIN?\r\nhahaha\r\nlulz\r\nluli'),
(2, 'Mahbub', 'Alam', 'mahbub@gmail.com', '1986471407', '202cb962ac59075b964b07152d234b70', 1, 1, 1, 'Mahbub\r\nLast Name:\r\nAlam\r\nEmail:\r\nmahbub@gmail.com\r\nVoter Id:\r\n1986471407\r\nPassword:\r\nEncrypted\r\nCandidate Status:\r\nYou are a candidate\r\nching CHING CHUI CHUI'),
(5, 'Rohit', 'Suri', 'rohit@gmail.com', '1996471407', '202cb962ac59075b964b07152d234b70', 1, 1, 1, 'Hello I am a very good neta.\r\nI do nice things. LOLz.\r\nOk bye.'),
(6, 'Aditya', 'Suri', 'asuri@gmail.com', '1234567890', '202cb962ac59075b964b07152d234b70', 1, 1, 1, '1.I did this.\r\n2.I did that\r\n3.I did this also\r\n4.I did that also \r\n5.I am the sword master');

-- --------------------------------------------------------

--
-- Table structure for table `tbvote`
--

CREATE TABLE IF NOT EXISTS `tbvote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voter_id` int(11) NOT NULL,
  `election_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbvote`
--

INSERT INTO `tbvote` (`id`, `voter_id`, `election_id`, `candidate_id`) VALUES
(1, 1, 3, 6),
(2, 2, 4, 5),
(3, 1, 4, 5),
(4, 5, 4, 2),
(5, 6, 4, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
