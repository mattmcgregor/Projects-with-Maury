-- phpMyAdmin SQL Dump
-- version 4.0.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2013 at 06:34 AM
-- Server version: 5.6.11-log
-- PHP Version: 5.5.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `user`
--
CREATE DATABASE IF NOT EXISTS `user` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `user`;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `ID` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Path` text NOT NULL,
  `Uploaded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`ID`, `Name`, `Path`, `Uploaded`, `UserID`) VALUES
(0000000004, 'en-US-3-0.bdic', 'upload/en-US-3-0.bdic', '2013-10-12 19:08:18', 25),
(0000000005, 'en-US-3-0 - Copy1.bdic', 'upload/en-US-3-0 - Copy1.bdic', '2013-10-12 19:08:33', 25),
(0000000006, 'en-US-3-0 - Copy1 - Copy - Copy.bdic', 'upload/en-US-3-0 - Copy1 - Copy - Copy.bdic', '2013-10-12 19:24:23', 25),
(0000000007, 'en-US-3-0 - Copy1 - Copy - Copy - Copy.bdic', 'upload/en-US-3-0 - Copy1 - Copy - Copy - Copy.bdic', '2013-10-12 19:25:09', 25),
(0000000008, 'en-US-3-0 - Copy1 - Copy - Copy - Copy - Copy.bdic', 'upload/en-US-3-0 - Copy1 - Copy - Copy - Copy - Copy.bdic', '2013-10-12 19:28:03', 24),
(0000000009, 'en-US-3-0 - Copy1 - Copy.bdic', 'upload/en-US-3-0 - Copy1 - Copy.bdic', '2013-10-12 19:29:57', 24),
(0000000010, '127_0_0_1.sql', 'upload/127_0_0_1.sql', '2013-10-12 20:13:33', 24);

-- --------------------------------------------------------

--
-- Table structure for table `judgement`
--

CREATE TABLE IF NOT EXISTS `judgement` (
  `AdminID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `ProposalID` int(11) NOT NULL,
  `Decision` tinyint(1) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`AdminID`,`StudentID`,`ProposalID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proposal`
--

CREATE TABLE IF NOT EXISTS `proposal` (
  `StudentID` int(11) NOT NULL,
  `FileID` int(11) NOT NULL,
  PRIMARY KEY (`StudentID`,`FileID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE IF NOT EXISTS `review` (
  `StudentID` int(11) NOT NULL,
  `FileProposalID` int(11) NOT NULL,
  `ReviewerID` int(11) NOT NULL,
  `FileReviewID` int(11) NOT NULL,
  PRIMARY KEY (`StudentID`,`FileProposalID`,`ReviewerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`StudentID`, `FileProposalID`, `ReviewerID`, `FileReviewID`) VALUES
(24, 8, 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(25) NOT NULL AUTO_INCREMENT,
  `Username` varchar(65) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `EmailAddress` varchar(255) NOT NULL,
  `Permissions` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `EmailAddress`, `Permissions`) VALUES
(23, 'test@alaska.edu', '098f6bcd4621d373cade4e832627b4f6', 'test@alaska.edu', 0),
(24, 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', 'test@test.com', 0),
(25, 'test2@test.com', 'ad0234829205b9033196ba818f7a872b', 'test2@test.com', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
