-- phpMyAdmin SQL Dump
-- version 4.0.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2013 at 03:56 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`ID`, `Name`, `Path`, `Uploaded`, `UserID`) VALUES
(0000000021, 'MinecraftLog.txt', 'upload/MinecraftLog.txt', '2013-10-28 19:39:44', 24),
(0000000022, 'MinecraftLog.txt', 'upload/MinecraftLog.txt', '2013-10-28 19:39:44', 24),
(0000000023, 'MinecraftLog - Copy - Copy.txt', 'upload/MinecraftLog - Copy - Copy.txt', '2013-10-28 19:43:49', 24),
(0000000024, 'test-suite 1', 'upload/test-suite 1', '2013-11-02 18:33:26', 33),
(0000000025, 'user.sql', 'upload/user.sql', '2013-11-14 16:25:23', 24);

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

--
-- Dumping data for table `proposal`
--

INSERT INTO `proposal` (`StudentID`, `FileID`) VALUES
(24, 23),
(24, 25),
(33, 24);

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
  `studentID` char(8) DEFAULT NULL,
  `lastName` char(20) DEFAULT NULL,
  `firstName` char(20) DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `EmailAddress`, `Permissions`, `studentID`, `lastName`, `firstName`) VALUES
(24, 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', 'test@test.com', 0, '', 'student', 'test'),
(25, 'test2@test.com', 'ad0234829205b9033196ba818f7a872b', 'test2@test.com', 1, NULL, 'reviewer', 'test'),
(26, 'admin@admin.com', 'e00cf25ad42683b3df678c61f42c6bda', 'admin@admin.com', 2, NULL, 'admin', 'test'),
(27, 'reviewer@alpha.net', 'a63566b3dfad8ace5c63b2e6dc9c23e8', 'reviewer@alpha.net', 1, NULL, 'Whomp', 'whomp'),
(28, 'reviewer@beta.com', 'f46815279090b5a161d036827b4d4e4c', 'reviewer@beta.com', 1, NULL, 'reviewer', 'beta'),
(33, 'greek@test.com', '1e5d05e79f10dd8aa2f79e56e7040f5b', 'greek@test.com', 0, 'delta', 'alpha', 'beta'),
(34, 'greek@test.two', '1e5d05e79f10dd8aa2f79e56e7040f5b', 'greek@test.two', 0, 'delta', 'beta', 'alpha'),
(35, 'reviewer4@test.com', '5293e8663cbb7c157ff83eeae25177d3', 'reviewer4@test.com', 1, '', 'Delta', 'Reviewer');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
