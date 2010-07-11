-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 11, 2010 at 05:39 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `collide`
--

-- --------------------------------------------------------

--
-- Table structure for table `c_name`
--

CREATE TABLE IF NOT EXISTS `c_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `c_name`
--

INSERT INTO `c_name` (`id`, `name`) VALUES
(1, 'collide');

-- --------------------------------------------------------

--
-- Table structure for table `c_version`
--

CREATE TABLE IF NOT EXISTS `c_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `c_version`
--


-- --------------------------------------------------------

--
-- Table structure for table `c_welcome`
--

CREATE TABLE IF NOT EXISTS `c_welcome` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `left` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `c_welcome`
--

INSERT INTO `c_welcome` (`id`, `title`, `left`, `content`) VALUES
(1, 'Collide MVC Framework', 'left panel', 'Welcome to %s MVC Framework, version %s');
