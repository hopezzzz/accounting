-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 18, 2017 at 08:39 AM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accounting`
--

-- --------------------------------------------------------

--
-- Table structure for table `acct_banks`
--

CREATE TABLE `acct_banks` (
  `bankID` int(11) NOT NULL,
  `bankRef` varchar(55) DEFAULT NULL,
  `companyRef` varchar(55) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(55) DEFAULT NULL,
  `accountNumber` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_banks`
--

INSERT INTO `acct_banks` (`bankID`, `bankRef`, `companyRef`, `name`, `code`, `accountNumber`, `status`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(1, 'xXp9YCn8nrASg8cu', 'knM50NtHC9G7QaDr', 'test', '123', '123123', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(2, 'Docajs0wj5fzgTat', 'knM50NtHC9G7QaDr', 'sdf', 'sdf', 'sdf', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs');

-- --------------------------------------------------------

--
-- Table structure for table `acct_clientProfile`
--

CREATE TABLE `acct_clientProfile` (
  `id` int(11) NOT NULL,
  `clientProfileRef` varchar(55) DEFAULT NULL,
  `title` varchar(55) DEFAULT NULL,
  `firstName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `lastName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `phone` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `mobile` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `website` text,
  `billingAddress` text NOT NULL,
  `shippingAddress` text NOT NULL,
  `sameAsBilling` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1 for same 0 for not same',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `isDeleted` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for not deleted 1 for deleted',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_clientProfile`
--

INSERT INTO `acct_clientProfile` (`id`, `clientProfileRef`, `title`, `firstName`, `lastName`, `email`, `phone`, `mobile`, `fax`, `website`, `billingAddress`, `shippingAddress`, `sameAsBilling`, `status`, `isDeleted`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(1, 'iGAx72np809NC42i', 'Mr.', 'test', 'test', 'test@gmail.com', '(123) 123-1231', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, 0, '2017-10-07', '2017-10-07', '0'),
(2, 'Pl5SZCMtPu0QRiTA', 'Mr.', 'aaa', 'aaa', 'aaa@gmail.com', '(324) 234-2342', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, 0, '2017-10-07', '2017-10-07', '0'),
(3, 'ePrTQXYjcB67aCug', 'Mr.', 'ss', 'ss', 'sss@test.com', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, 0, '2017-10-07', '2017-10-07', '0'),
(4, 'VPxlp4mYbcUB0yxa', 'Mr.', 'Dddd', 'Ddd', 'ddd@ddd.com', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, 0, '2017-10-09', '2017-10-09', '0'),
(5, 'GaMIoy4h9BM6m2l8', 'Mr.', '54', '32030', 'test@gmail.co', '', '', '', 'http://google.com', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, 0, '2017-10-09', '2017-10-09', '0'),
(6, 'tJxjYr9pt1XBnSUO', 'Mr.', 'gurdeeep', 'singh', 'gurdeep@11wayit.com', '(777) 777-7777', '(788) 888-8888', '', '', 'a:5:{s:13:\"billingStreet\";s:4:\"test\";s:11:\"billingCity\";s:6:\"mohalo\";s:12:\"billingState\";s:7:\"puanjba\";s:17:\"billingPostalCode\";s:6:\"160071\";s:14:\"billingCountry\";s:5:\"india\";}', 'a:5:{s:14:\"shippingStreet\";s:4:\"test\";s:12:\"shippingCity\";s:6:\"mohalo\";s:13:\"shippingState\";s:7:\"puanjba\";s:18:\"shippingPostalCode\";s:6:\"160071\";s:15:\"shippingCountry\";s:5:\"india\";}', 1, 1, 0, '2017-10-12', '2017-10-12', '0'),
(7, '5FwAZTyq2EnmiogP', NULL, NULL, NULL, 'akash@1wayit.com', NULL, NULL, NULL, NULL, '', '', 0, 0, 0, '2017-10-12', NULL, NULL),
(8, 'RBV7kfOyj2MTknz6', NULL, NULL, NULL, 'gurbinder@1wayit.com', NULL, NULL, NULL, NULL, '', '', 0, 0, 0, '2017-10-12', NULL, NULL),
(9, '50aOy6qf7IayBvZ6', NULL, NULL, NULL, 'test@ff.com', NULL, NULL, NULL, NULL, '', '', 0, 0, 0, '2017-10-12', NULL, NULL),
(10, 'DHwRJtgUZMeQfgjS', NULL, NULL, NULL, 'testSDf@sdfff.dgd', NULL, NULL, NULL, NULL, '', '', 0, 0, 0, '2017-10-12', NULL, NULL),
(11, 'PjGQ267bU8M5HIN4', 'Mr.', 'dfg', 'dfg', 'dfg@sdfs.cbvb', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, 0, '2017-10-12', '2017-10-12', '0'),
(12, '0lhc8wenMVtKusNF', NULL, NULL, NULL, 'ssdfsf@gmail.com', NULL, NULL, NULL, NULL, '', '', 0, 0, 0, '2017-10-12', NULL, NULL),
(13, 'AJMKsCm34PR8wEXN', NULL, NULL, NULL, 'ttt@fff.com', NULL, NULL, NULL, NULL, '', '', 0, 0, 0, '2017-10-12', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `acct_companies`
--

CREATE TABLE `acct_companies` (
  `companyID` int(11) NOT NULL,
  `companyRef` varchar(55) DEFAULT NULL,
  `clientRef` varchar(55) DEFAULT NULL,
  `companyName` varchar(255) DEFAULT NULL,
  `companyType` varchar(255) DEFAULT NULL,
  `compRegNo` varchar(55) DEFAULT NULL,
  `vatApplied` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for yes 2 for no',
  `vatNo` varchar(100) DEFAULT NULL,
  `corporationTaxRef` varchar(255) DEFAULT NULL,
  `dateOfIncorporation` date DEFAULT NULL,
  `returnDate` date DEFAULT NULL,
  `yearEndDate` date DEFAULT NULL,
  `description` text,
  `companyLogo` varchar(255) DEFAULT NULL,
  `contactPersonName` varchar(100) DEFAULT NULL,
  `contactPersonPhone` varchar(30) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_companies`
--

INSERT INTO `acct_companies` (`companyID`, `companyRef`, `clientRef`, `companyName`, `companyType`, `compRegNo`, `vatApplied`, `vatNo`, `corporationTaxRef`, `dateOfIncorporation`, `returnDate`, `yearEndDate`, `description`, `companyLogo`, `contactPersonName`, `contactPersonPhone`, `status`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(1, '1q2OlNXsbdH46UT3', 'iGAx72np809NC42i', 'test', 'Service/Consultancy', '2342', 2, '', '', '1970-01-01', '2017-10-05', '2017-10-06', '', NULL, '', '', 1, '2017-10-07', '2017-10-07', '0'),
(2, 'ZATN2czFtzqQ2Amu', 'Pl5SZCMtPu0QRiTA', 'trrrr', 'Trading', '444', 2, '', '', '2017-10-04', '2017-10-05', '2017-10-13', '', NULL, '', '', 1, '2017-10-07', '2017-10-07', '0'),
(3, 'BA4ysbiJDgdTKoUb', 'ePrTQXYjcB67aCug', 'sdg', 'Trading', '435', 2, '', '', '1970-01-01', '2017-10-19', '2017-10-04', '', NULL, '', '', 1, '2017-10-07', '2017-10-07', '0'),
(4, 'Vm8HJeIOOcBgIJUG', 'VPxlp4mYbcUB0yxa', 'Yyyyyyfd', 'Trading', '', 2, '', '', '2017-10-31', '2017-10-26', '2017-10-26', '', NULL, '', '', 1, '2017-10-09', '2017-10-09', '0'),
(5, 'nsUdxwqoWdrnPjTM', 'tJxjYr9pt1XBnSUO', 'guruuuu', 'Trading', '213', 1, '44', '123', '2017-10-31', '2017-11-01', '2017-11-03', 'test', 'hi-tech-wall-paper-hi-tech-37969755-2560-1600.jpg', 'test', '(333) 333-3333', 1, '2017-10-12', '2017-10-12', '0'),
(6, '6sSDBU8fO8oqU4uC', '5FwAZTyq2EnmiogP', 'akash', 'Trading', NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'test', '(234) 234-2342', 1, '2017-10-12', '2017-10-12', '0'),
(7, '6Kcg4xkPOh9sAtD4', 'RBV7kfOyj2MTknz6', 'gurbinder', 'Service/Consultancy', NULL, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, 'tesrte', '(213) 423-4234', 1, '2017-10-12', '2017-10-12', '0'),
(8, 'knM50NtHC9G7QaDr', 'PjGQ267bU8M5HIN4', '345', 'Service/Consultancy', '345', 2, '', ' ', '1970-01-01', '2017-10-26', '2017-10-31', '', NULL, '', '', 1, '2017-10-12', '2017-10-12', '0');

-- --------------------------------------------------------

--
-- Table structure for table `acct_companyUsers`
--

CREATE TABLE `acct_companyUsers` (
  `comUserID` int(11) NOT NULL,
  `comUserRef` varchar(55) DEFAULT NULL,
  `companyRef` varchar(55) DEFAULT NULL,
  `title` varchar(55) DEFAULT NULL,
  `firstName` varchar(55) DEFAULT NULL,
  `lastName` varchar(55) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `phoneNo` varchar(55) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `niNumber` varchar(55) DEFAULT NULL,
  `UTR` varchar(55) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postalCode` varchar(55) DEFAULT NULL,
  `city` varchar(55) DEFAULT NULL,
  `state` varchar(55) DEFAULT NULL,
  `country` varchar(55) DEFAULT NULL,
  `isEmployee` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for no 1 for yes',
  `isShareholder` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for no 1 for yes',
  `noOfShares` varchar(30) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acct_configuration`
--

CREATE TABLE `acct_configuration` (
  `configID` int(11) NOT NULL,
  `configRef` varchar(55) DEFAULT NULL,
  `companyRef` varchar(55) DEFAULT NULL COMMENT 'set companyRef if you want to set company configuration otherwise leave it blank for site configuration',
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `status` varchar(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acct_creditors`
--

CREATE TABLE `acct_creditors` (
  `creditorID` int(11) NOT NULL,
  `creditorRef` varchar(55) DEFAULT NULL,
  `companyRef` varchar(55) DEFAULT NULL,
  `title` varchar(25) DEFAULT NULL,
  `firstName` varchar(55) DEFAULT NULL,
  `lastName` varchar(55) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(55) DEFAULT NULL,
  `mobile` varchar(55) DEFAULT NULL,
  `vatNo` varchar(55) DEFAULT NULL,
  `fax` varchar(55) DEFAULT NULL,
  `website` varchar(55) DEFAULT NULL,
  `billingAddress` text,
  `shippingAddress` text,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_creditors`
--

INSERT INTO `acct_creditors` (`creditorID`, `creditorRef`, `companyRef`, `title`, `firstName`, `lastName`, `email`, `phone`, `mobile`, `vatNo`, `fax`, `website`, `billingAddress`, `shippingAddress`, `status`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(1, 'rVpcKkbP3nGcKFtN', 'Vm8HJeIOOcBgIJUG', 'Mr.', 'rey', 'ery', 'gurdeep@1wayit.com', '(345) 353-4534', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-09', '2017-10-09', '0'),
(3, 'BeXUNc3wMtVNQar4', 'Vm8HJeIOOcBgIJUG', NULL, 'tester', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-09', '2017-10-09', 'LnOpqEtCkIqgDPAs'),
(4, 'ovJDLiruTjcJt961', 'Vm8HJeIOOcBgIJUG', NULL, 'tester', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-09', '2017-10-09', 'LnOpqEtCkIqgDPAs'),
(5, 'ankFOESfNMLZI6Vx', 'Vm8HJeIOOcBgIJUG', '', 'tester', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-09', '2017-10-09', 'LnOpqEtCkIqgDPAs'),
(6, 'cNml2FXSIBqTw3N8', 'Vm8HJeIOOcBgIJUG', NULL, 'asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-09', '2017-10-09', 'LnOpqEtCkIqgDPAs'),
(7, 'XlyBVAmObc5nxiM9', 'Vm8HJeIOOcBgIJUG', NULL, 'jacab', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-09', '2017-10-09', 'LnOpqEtCkIqgDPAs'),
(8, 'KUG9t1D2oLQYB6T1', '1q2OlNXsbdH46UT3', NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(9, 'lo3Tp0zPmaiC47Xd', 'nsUdxwqoWdrnPjTM', NULL, 'staffi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-12', '2017-10-12', 'LnOpqEtCkIqgDPAs'),
(10, '0zf2SOIuJAx1fDZT', 'nsUdxwqoWdrnPjTM', NULL, 'akash', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-12', '2017-10-12', 'LnOpqEtCkIqgDPAs'),
(11, 'Hn3YyudRAWNsbZUm', 'knM50NtHC9G7QaDr', NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(12, 'wK1zCFNj0WgysRbB', 'knM50NtHC9G7QaDr', NULL, 'Mr alex tester', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(13, 'gA6MdXxcf6EgTcOJ', 'knM50NtHC9G7QaDr', NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(14, '8X5xJjafDu5Y1jWT', 'knM50NtHC9G7QaDr', NULL, 'fghfgh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(15, '9SmNzykGZz3R1cPB', 'knM50NtHC9G7QaDr', NULL, 'fghfgh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(16, 'bNdSzJWe9qToD81y', 'knM50NtHC9G7QaDr', NULL, 'fghfgh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(17, 'Kbljx4MklFbMSYrJ', 'knM50NtHC9G7QaDr', NULL, 'fghfgh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(18, 'gH1onJWrzTIYHRiw', 'knM50NtHC9G7QaDr', NULL, 'teesss', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(19, 'bs6gtJCQuBrb9giR', 'knM50NtHC9G7QaDr', NULL, 'eeee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs');

-- --------------------------------------------------------

--
-- Table structure for table `acct_debtors`
--

CREATE TABLE `acct_debtors` (
  `debtorID` int(11) NOT NULL,
  `debtorRef` varchar(55) DEFAULT NULL,
  `companyRef` varchar(55) DEFAULT NULL,
  `title` varchar(25) DEFAULT NULL,
  `firstName` varchar(55) DEFAULT NULL,
  `lastName` varchar(55) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(55) DEFAULT NULL,
  `mobile` varchar(55) DEFAULT NULL,
  `vatNo` varchar(55) DEFAULT NULL,
  `fax` varchar(55) DEFAULT NULL,
  `website` varchar(55) DEFAULT NULL,
  `billingAddress` text,
  `shippingAddress` text,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_debtors`
--

INSERT INTO `acct_debtors` (`debtorID`, `debtorRef`, `companyRef`, `title`, `firstName`, `lastName`, `email`, `phone`, `mobile`, `vatNo`, `fax`, `website`, `billingAddress`, `shippingAddress`, `status`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(1, '37jWnNUBZT5bFmo9', 'Vm8HJeIOOcBgIJUG', 'Mr.', 'yyysdfg', 'yyy', 'yyy@yyy.com', '(234) 234-2342', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, '2017-10-09', '2017-10-09', 'LnOpqEtCkIqgDPAs'),
(2, 'SOJn1j7iiuhkoXQc', 'Vm8HJeIOOcBgIJUG', 'Mr.', 'dfd', 'df', 'dff@fffc.com', '(234) 234-2342', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-09', '2017-10-09', 'LnOpqEtCkIqgDPAs'),
(3, '6dMmD1sTQjZf9rnc', 'Vm8HJeIOOcBgIJUG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-10', '2017-10-10', 'LnOpqEtCkIqgDPAs'),
(4, 'JBxTrjESq4Fu83WZ', 'Vm8HJeIOOcBgIJUG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(5, 'WlZw1CAXLJyav0W8', 'Vm8HJeIOOcBgIJUG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(6, '1i7WlTRpQzv6VmDd', 'Vm8HJeIOOcBgIJUG', NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(7, 'WoT3eLCUHU8iJluk', 'Vm8HJeIOOcBgIJUG', NULL, 'ggggg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(8, '0HyoUnDwa5EiPKtH', '1q2OlNXsbdH46UT3', NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(9, 'uWIGTL0cSIAsKYvZ', 'nsUdxwqoWdrnPjTM', NULL, 'ravinder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-12', '2017-10-12', 'LnOpqEtCkIqgDPAs'),
(10, 'tZ7YhLieY5yXx6lk', 'knM50NtHC9G7QaDr', 'Mr.', 'aa', 'aa', 'ajaay@1wayit.com', '(333) 333-3333', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-12', '2017-10-12', 'LnOpqEtCkIqgDPAs'),
(11, 'uXkN87jFNpHrZt21', 'knM50NtHC9G7QaDr', NULL, 'sf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(12, 'DtEQ1zK4ICWQPHvj', 'knM50NtHC9G7QaDr', NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(13, 'yesaFrpUZDgBshLU', 'knM50NtHC9G7QaDr', NULL, 'eeee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs');

-- --------------------------------------------------------

--
-- Table structure for table `acct_emailTemplates`
--

CREATE TABLE `acct_emailTemplates` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `add_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_emailTemplates`
--

INSERT INTO `acct_emailTemplates` (`id`, `subject`, `description`, `add_date`) VALUES
(1, 'Verify Email', '<table border=\"0\" width=\"100%\"> 	<tbody> 		<tr> 			<td> 			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#fff; box-shadow:0 0 10px #ccc;\" width=\"600\"> 				<tbody> 					<tr> 						<td align=\"center\" height=\"100\" width=\"100\" style=\"background:url(./assets/default/images/header_bg.jpg) 0 0 repeat-x; border-top: 6px solid #566369; border-bottom:solid 1px #f5f5f5;\" valign=\"middle\">{logo}</td> 					</tr> 					<tr> 						<td> 						<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"> 							<tbody> 								<tr> 									<td width=\"15\">&nbsp;</td> 									<td width=\"570\"> 									<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"> 										<tbody> 											<tr> 												<td height=\"15\">&nbsp;</td> 											</tr> 											<tr> 												<td width=\"530\"> 												<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"> 													<tbody> 														<tr> 															<td style=\"font-family:Arial, Helvetica, sans-serif; padding:10px; font-size:13px; color:#ec7475;\"> 															<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"> 																<tbody> 																	<tr> 																		<td align=\"left\" height=\"30\" style=\"font-size:18px; font-family:Verdana, Geneva, sans-serif; color:#1f7cae; padding-bottom:22px;\" valign=\"middle\"><strong>Dear {receiver_name},</strong></td> 																	</tr> 																	<tr> 																		<td align=\"left\" style=\"color: #fff;background-color:#1f7cae; border-bottom:solid 1px #8dbfd9;font-size: 17px;height: 40px;line-height: 27px;text-align: center;margin-bottom:22px;\" valign=\"middle\"> Thanks for signing up!.<br>Your account has been created.</td> 																	</tr> 																	<tr> 																		<td align=\"center\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\"><strong><a href=\"{verification_link}\" target=\"_blank\"><button style=\"margin-top:10px;background-color: #1F7CAE;border: 1px solid #7fb797;color: #fff;cursor: pointer;font-size: 15px;padding: 5px 5px;\">Click here to verify your email</button></a></strong> 																		</td> 																	</tr> 																	<tr> 																		<td style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\"><strong><br> 																			<p>Your credentials are following : </p> 																			<p>Email    : {to}</p> 																			<p>Password : {password}</p> 																		</td> 																	</tr> 																	<tr> 																		<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:17px;color:#1f7cae;\" valign=\"top\">Regards,<br /> 																		{site_title} Team</td> 																	</tr> 																</tbody> 															</table> 															</td> 														</tr> 													</tbody> 												</table> 												</td> 											</tr> 											<tr> 												<td height=\"15\" style=\"padding-bottom:15px;\"> 												<p>*This email account is not monitored. Please do not reply to this email as we will not be able to read and respond to your messages.</p> 												</td> 											</tr> 										</tbody> 									</table> 									</td> 									<td width=\"15\">&nbsp;</td> 								</tr> 							</tbody> 						</table> 						</td> 					</tr> 					<tr> 						<td align=\"center\" style=\"padding:5px; background: none repeat scroll 0 0 #333;     border-top: 1px solid #CCCCCC;color:#fff;\" valign=\"top\"> 						<p>You have received this message by auto generated e-mail.</p>  						<center>{copyrightText}</center> 						</td> 					</tr> 				</tbody> 			</table> 			</td> 		</tr> 	</tbody> </table>', '2016-09-23'),
(2, 'Forgot Password', '<table border=\"0\" width=\"100%\">\n	<tbody>\n		<tr>\n			<td>\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#fff; box-shadow:0 0 10px #ccc;\" width=\"600\">\n				<tbody>\n					<tr>\n						<td align=\"center\" height=\"100\" style=\"background:url(./assets/default/images/header_bg.jpg) 0 0 repeat-x; border-top: 6px solid #566369; border-bottom:solid 1px #f5f5f5;\" valign=\"middle\">{logo}</td>\n					</tr>\n					<tr>\n						<td>\n						<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tbody>\n								<tr>\n									<td width=\"15\">&nbsp;</td>\n									<td width=\"570\">\n									<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n										<tbody>\n											<tr>\n												<td height=\"15\">&nbsp;</td>\n											</tr>\n											<tr>\n												<td width=\"530\">\n												<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n													<tbody>\n														<tr>\n															<td style=\"font-family:Arial, Helvetica, sans-serif; padding:10px; font-size:13px; color:#ec7475;\">\n															<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n																<tbody>\n																	<tr>\n																		<td align=\"left\" height=\"30\" style=\"font-size:18px; font-family:Verdana, Geneva, sans-serif; color:#1f7cae; padding-bottom:22px;\" valign=\"middle\"><strong>Dear {receiver_name},</strong></td>\n																	</tr>\n																	<tr>\n																		<td align=\"left\" style=\"color: #fff;background-color:#1f7cae; border-bottom:solid 1px #8dbfd9;font-size: 17px;height: 40px;line-height: 27px;text-align: center;margin-bottom:22px;\" valign=\"middle\">You recently requested to reset your password. Please use the temporary password below to log in and change your password.</td>\n																	</tr>\n																	<tr>\n																		<td align=\"center\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\"><strong><p style=\"width:125px;margin-top:10px;background-color: #1F7CAE;border: 1px solid #7fb797;color: #fff;cursor: pointer;font-size: 15px;padding: 5px 5px;\">{newPassword}</p></strong>\n																		</td>\n																	</tr>\n																	<tr>\n																		<td align=\"center\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\"><strong><p style=\"width:auto;margin-top:10px;background-color: #1F7CAE;border: 1px solid #7fb797;color: #fff;cursor: pointer;font-size: 15px;padding: 5px 5px;\"><a style=\"color:#fff;text-decoration:none\" href=\"{loginUrl}\">Click here to login</a></p></strong>\n																		</td>\n																	</tr>\n																	<tr>\n																		<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:17px;color:#1f7cae;\" valign=\"top\">Regards,<br />\n																		{site_title} Team</td>\n																	</tr>\n																</tbody>\n															</table>\n															</td>\n														</tr>\n													</tbody>\n												</table>\n												</td>\n											</tr>\n											<tr>\n												<td height=\"15\" style=\"padding-bottom:15px;\">\n												<p>*This email account is not monitored. Please do not reply to this email as we will not be able to read and respond to your messages.</p>\n												</td>\n											</tr>\n										</tbody>\n									</table>\n									</td>\n									<td width=\"15\">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td align=\"center\" style=\"padding:5px; background: none repeat scroll 0 0 #333;\n    border-top: 1px solid #CCCCCC;color:#fff;\" valign=\"top\">\n						<p>You have received this message by auto generated e-mail.</p>\n\n						<center>{copyrightText}</center>\n						</td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>\n', '2016-09-26'),
(3, 'Account Information', '<table border=\"0\" width=\"100%\">\n	<tbody>\n		<tr>\n			<td>\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#fff; box-shadow:0 0 10px #ccc;\" width=\"600\">\n				<tbody>\n					<tr>\n						<td align=\"center\" height=\"100\" style=\"background:url(./assets/default/images/header_bg.jpg) 0 0 repeat-x; border-top: 6px solid #566369; border-bottom:solid 1px #f5f5f5;\" valign=\"middle\">{logo}</td>\n					</tr>\n					<tr>\n						<td>\n						<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tbody>\n								<tr>\n									<td width=\"15\">&nbsp;</td>\n									<td width=\"570\">\n									<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n										<tbody>\n											<tr>\n												<td height=\"15\">&nbsp;</td>\n											</tr>\n											<tr>\n												<td width=\"530\">\n												<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n													<tbody>\n														<tr>\n															<td style=\"font-family:Arial, Helvetica, sans-serif; padding:10px; font-size:13px; color:#ec7475;\">\n															<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n																<tbody>\n																	<tr>\n																		<td align=\"left\" height=\"30\" style=\"font-size:18px; font-family:Verdana, Geneva, sans-serif; color:#1f7cae; padding-bottom:22px;\" valign=\"middle\"><strong>Dear {receiver_name},</strong></td>\n																	</tr>\n																	<tr>\n																		<td align=\"left\" style=\"color: #fff;background-color:#1f7cae; border-bottom:solid 1px #8dbfd9;font-size: 17px;height: 40px;line-height: 27px;text-align: center;margin-bottom:22px;\" valign=\"middle\">Your account has been successfully created with us.<br>Please use the following details to log in into the system.</td>\n																	</tr>\n																	<tr>\n																		<td style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\">\n																		<br><strong>System Link : </strong><a href=\"{site_url}\" target=\"_blank\">{site_title}</a> <br>\n																		<strong>Email 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </strong>{email}<br>\n																		<strong>Password 	&nbsp;&nbsp;&nbsp;&nbsp;: </strong>{password}<br>\n																		</td>\n																	</tr>\n																	<tr>\n																		<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:17px;color:#1f7cae;\" valign=\"top\">Regards,<br />\n																		{site_title} Team</td>\n																	</tr>\n																</tbody>\n															</table>\n															</td>\n														</tr>\n													</tbody>\n												</table>\n												</td>\n											</tr>\n											<tr>\n												<td height=\"15\" style=\"padding-bottom:15px;\">\n												<p>*This email account is not monitored. Please do not reply to this email as we will not be able to read and respond to your messages.</p>\n												</td>\n											</tr>\n										</tbody>\n									</table>\n									</td>\n									<td width=\"15\">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td align=\"center\" style=\"padding:5px; background: none repeat scroll 0 0 #333;\n    border-top: 1px solid #CCCCCC;color:#fff;\" valign=\"top\">\n						<p>You have received this message by auto generated e-mail.</p>\n\n						<center>{copyrightText}</center>\n						</td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>\n', '2016-12-14'),
(4, 'Email Changed', '<table border=\"0\" width=\"100%\">\n	<tbody>\n		<tr>\n			<td>\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#fff; box-shadow:0 0 10px #ccc;\" width=\"600\">\n				<tbody>\n					<tr>\n						<td align=\"center\" height=\"100\" width=\"100\" style=\"background:url(./assets/default/images/header_bg.jpg) 0 0 repeat-x; border-top: 6px solid #566369; border-bottom:solid 1px #f5f5f5;\" valign=\"middle\">{logo}</td>\n					</tr>\n					<tr>\n						<td>\n						<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tbody>\n								<tr>\n									<td width=\"15\">&nbsp;</td>\n									<td width=\"570\">\n									<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n										<tbody>\n											<tr>\n												<td height=\"15\">&nbsp;</td>\n											</tr>\n											<tr>\n												<td width=\"530\">\n												<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n													<tbody>\n														<tr>\n															<td style=\"font-family:Arial, Helvetica, sans-serif; padding:10px; font-size:13px; color:#ec7475;\">\n															<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n																<tbody>\n																	<tr>\n																		<td align=\"left\" height=\"30\" style=\"font-size:18px; font-family:Verdana, Geneva, sans-serif; color:#1f7cae; padding-bottom:22px;\" valign=\"middle\"><strong>Dear {receiver_name},</strong></td>\n																	</tr>\n																	<tr>\n																		<td align=\"left\" style=\"color: #fff;background-color:#1f7cae; border-bottom:solid 1px #8dbfd9;font-size: 17px;height: 40px;line-height: 27px;text-align: center;margin-bottom:22px;\" valign=\"middle\"> You have recently changed your email address to {email}. Please verify your email by clicking on below given link :-</td>\n																	</tr>																	\n																	<tr>\n																		<td align=\"center\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\"><strong><a href=\"{verification_link}\" target=\"_blank\"><button style=\"margin-top:10px;background-color: #1F7CAE;border: 1px solid #7fb797;color: #fff;cursor: pointer;font-size: 15px;padding: 5px 5px;\">Click here to verify your email</button></a></strong>\n																		</td>\n																	</tr>\n																	<tr>\n																		<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:17px;color:#1f7cae;\" valign=\"top\">Regards,<br />\n																		{site_title} Team</td>\n																	</tr>\n																</tbody>\n															</table>\n															</td>\n														</tr>\n													</tbody>\n												</table>\n												</td>\n											</tr>\n											<tr>\n												<td height=\"15\" style=\"padding-bottom:15px;\">\n												<p>*This email account is not monitored. Please do not reply to this email as we will not be able to read and respond to your messages.</p>\n												</td>\n											</tr>\n										</tbody>\n									</table>\n									</td>\n									<td width=\"15\">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td align=\"center\" style=\"padding:5px; background: none repeat scroll 0 0 #333;\n    border-top: 1px solid #CCCCCC;color:#fff;\" valign=\"top\">\n						<p>You have received this message by auto generated e-mail.</p>\n\n						<center>{copyrightText}</center>\n						</td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>\n', '2017-06-06'),
(5, 'Tagged in a comment', '<table border=\"0\" width=\"100%\">\n	<tbody>\n		<tr>\n			<td>\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#fff; box-shadow:0 0 10px #ccc;\" width=\"600\">\n				<tbody>\n					<tr>\n						<td align=\"center\" height=\"100\" style=\"background:url(./assets/default/images/header_bg.jpg) 0 0 repeat-x; border-top: 6px solid #566369; border-bottom:solid 1px #f5f5f5;\" valign=\"middle\">{logo}</td>\n					</tr>\n					<tr>\n						<td>\n						<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tbody>\n								<tr>\n									<td width=\"15\">&nbsp;</td>\n									<td width=\"570\">\n									<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n										<tbody>\n											<tr>\n												<td height=\"15\">&nbsp;</td>\n											</tr>\n											<tr>\n												<td width=\"530\">\n												<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n													<tbody>\n														<tr>\n															<td style=\"font-family:Arial, Helvetica, sans-serif; padding:10px; font-size:13px; color:#ec7475;\">\n															<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n																<tbody>\n																	<tr>\n																		<td align=\"left\" height=\"30\" style=\"font-size:18px; font-family:Verdana, Geneva, sans-serif; color:#1f7cae; padding-bottom:22px;\" valign=\"middle\"><strong>Dear {receiver_name},</strong></td>\n																	</tr>\n																	<tr>\n																		<td align=\"left\" style=\"color: #fff;background-color:#1f7cae; border-bottom:solid 1px #8dbfd9;font-size: 17px;height: 40px;line-height: 27px;text-align: center;margin-bottom:22px;\" valign=\"middle\">You have been tagged in a comment in a {companyname} - {productname} onboarding project.</td>\n																	</tr>\n																	<tr>\n																		<td style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\">\n																		<br>{comment}<br>\n																		<a style=\"margin-left:36%\" href=\"{detailpagelink}\" target=\"_blank\">\n																			<button style=\"margin-top:10px;background-color: #1F7CAE;border: 1px solid #7fb797;color: #fff;cursor: pointer;font-size: 15px;padding: 5px 5px;\">Click here to view</button></a>\n																		</td>\n																	</tr>\n																	<tr>\n																		<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:17px;color:#1f7cae;\" valign=\"top\">Regards,<br />\n																		{site_title} Team</td>\n																	</tr>\n																</tbody>\n															</table>\n															</td>\n														</tr>\n													</tbody>\n												</table>\n												</td>\n											</tr>\n											<tr>\n												<td height=\"15\" style=\"padding-bottom:15px;\">\n												<p>*This email account is not monitored. Please do not reply to this email as we will not be able to read and respond to your messages.</p>\n												</td>\n											</tr>\n										</tbody>\n									</table>\n									</td>\n									<td width=\"15\">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td align=\"center\" style=\"padding:5px; background: none repeat scroll 0 0 #333;\n    border-top: 1px solid #CCCCCC;color:#fff;\" valign=\"top\">\n						<p>You have received this message by auto generated e-mail.</p>\n\n						<center>{copyrightText}</center>\n						</td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>\n', '2017-08-31'),
(6, 'Task mark complete', '<table border=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#fff; box-shadow:0 0 10px #ccc;\" width=\"600\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" height=\"100\" style=\"background:url(./assets/default/images/header_bg.jpg) 0 0 repeat-x; border-top: 6px solid #566369; border-bottom:solid 1px #f5f5f5;\" valign=\"middle\">{logo}</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n							<tbody>\r\n								<tr>\r\n									<td width=\"15\">&nbsp;</td>\r\n									<td width=\"570\">\r\n									<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n										<tbody>\r\n											<tr>\r\n												<td height=\"15\">&nbsp;</td>\r\n											</tr>\r\n											<tr>\r\n												<td width=\"530\">\r\n												<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n													<tbody>\r\n														<tr>\r\n															<td style=\"font-family:Arial, Helvetica, sans-serif; padding:10px; font-size:13px; color:#ec7475;\">\r\n															<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n																<tbody>\r\n																	<tr>\r\n																		<td align=\"left\" height=\"30\" style=\"font-size:18px; font-family:Verdana, Geneva, sans-serif; color:#1f7cae; padding-bottom:22px;\" valign=\"middle\"><strong>Dear {receiver_name},</strong></td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td align=\"left\" style=\"color: #fff;background-color:#1f7cae; border-bottom:solid 1px #8dbfd9;font-size: 17px;height: 40px;line-height: 27px;text-align: center;margin-bottom:22px;\" valign=\"middle\">This automated email has been sent to you as a member of the {companyname} {productname} onboarding project.<br>The task {taskname} has been marked complete.</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\"><br>\r\n																		<p>\r\n																			Please see project details <a href=\"{detailpagelink}\" target=\"_blank\" style=\"text-decoration:none;color: #171717;cursor: pointer;font-size: 15px;\"> <strong>here</strong></a>\r\n																		</p>\r\n																		<p>\r\n																			To unsubscribe from these updates,  <a href=\"{unsubscribeNotificationLink}\" target=\"_blank\" style=\"text-decoration:none;color: #171717;cursor: pointer;font-size: 15px;\"> <strong> Click here</strong></a>\r\n																		</p>\r\n																		</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:17px;color:#1f7cae;\" valign=\"top\">Regards,<br />\r\n																		{site_title} Team</td>\r\n																	</tr>\r\n																</tbody>\r\n															</table>\r\n															</td>\r\n														</tr>\r\n													</tbody>\r\n												</table>\r\n												</td>\r\n											</tr>\r\n											<tr>\r\n												<td height=\"15\" style=\"padding-bottom:15px;\">\r\n												<p>*This email account is not monitored. Please do not reply to this email as we will not be able to read and respond to your messages.</p>\r\n												</td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n									<td width=\"15\">&nbsp;</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" style=\"padding:5px; background: none repeat scroll 0 0 #333;\r\n    border-top: 1px solid #CCCCCC;color:#fff;\" valign=\"top\">\r\n						<p>You have received this message by auto generated e-mail.</p>\r\n\r\n						<center>{copyrightText}</center>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '2017-08-09'),
(7, 'All tasks completed in a phase', '<table border=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#fff; box-shadow:0 0 10px #ccc;\" width=\"600\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" height=\"100\" style=\"background:url(./assets/default/images/header_bg.jpg) 0 0 repeat-x; border-top: 6px solid #566369; border-bottom:solid 1px #f5f5f5;\" valign=\"middle\">{logo}</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n							<tbody>\r\n								<tr>\r\n									<td width=\"15\">&nbsp;</td>\r\n									<td width=\"570\">\r\n									<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n										<tbody>\r\n											<tr>\r\n												<td height=\"15\">&nbsp;</td>\r\n											</tr>\r\n											<tr>\r\n												<td width=\"530\">\r\n												<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n													<tbody>\r\n														<tr>\r\n															<td style=\"font-family:Arial, Helvetica, sans-serif; padding:10px; font-size:13px; color:#ec7475;\">\r\n															<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n																<tbody>\r\n																	<tr>\r\n																		<td align=\"left\" height=\"30\" style=\"font-size:18px; font-family:Verdana, Geneva, sans-serif; color:#1f7cae; padding-bottom:22px;\" valign=\"middle\"><strong>Dear {receiver_name},</strong></td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td align=\"left\" style=\"color: #fff;background-color:#1f7cae; border-bottom:solid 1px #8dbfd9;font-size: 17px;height: 40px;line-height: 27px;text-align: center;margin-bottom:22px;\" valign=\"middle\">This automated email has been sent to you as a member of the {companyname} {productname} onboarding project.<br>The phase {phaseName} has been marked complete.</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\"><br>\r\n																		<p>\r\n																			Please see project details <a href=\"{detailpagelink}\" target=\"_blank\" style=\"text-decoration:none;color: #171717;cursor: pointer;font-size: 15px;\"> <strong>here</strong></a>\r\n																		</p>\r\n																		<p>\r\n																			To unsubscribe from these updates,  <a href=\"{unsubscribeNotificationLink}\" target=\"_blank\" style=\"text-decoration:none;color: #171717;cursor: pointer;font-size: 15px;\"> <strong> Click here</strong></a>\r\n																		</p>\r\n																		</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:17px;color:#1f7cae;\" valign=\"top\">Regards,<br />\r\n																		{site_title} Team</td>\r\n																	</tr>\r\n																</tbody>\r\n															</table>\r\n															</td>\r\n														</tr>\r\n													</tbody>\r\n												</table>\r\n												</td>\r\n											</tr>\r\n											<tr>\r\n												<td height=\"15\" style=\"padding-bottom:15px;\">\r\n												<p>*This email account is not monitored. Please do not reply to this email as we will not be able to read and respond to your messages.</p>\r\n												</td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n									<td width=\"15\">&nbsp;</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" style=\"padding:5px; background: none repeat scroll 0 0 #333;\r\n    border-top: 1px solid #CCCCCC;color:#fff;\" valign=\"top\">\r\n						<p>You have received this message by auto generated e-mail.</p>\r\n\r\n						<center>{copyrightText}</center>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '2017-08-09'),
(8, 'Task Overdue', '<table border=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#fff; box-shadow:0 0 10px #ccc;\" width=\"600\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" height=\"100\" style=\"background:url(./assets/default/images/header_bg.jpg) 0 0 repeat-x; border-top: 6px solid #566369; border-bottom:solid 1px #f5f5f5;\" valign=\"middle\">{logo}</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n							<tbody>\r\n								<tr>\r\n									<td width=\"15\">&nbsp;</td>\r\n									<td width=\"570\">\r\n									<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n										<tbody>\r\n											<tr>\r\n												<td height=\"15\">&nbsp;</td>\r\n											</tr>\r\n											<tr>\r\n												<td width=\"530\">\r\n												<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n													<tbody>\r\n														<tr>\r\n															<td style=\"font-family:Arial, Helvetica, sans-serif; padding:10px; font-size:13px; color:#ec7475;\">\r\n															<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n																<tbody>\r\n																	<tr>\r\n																		<td align=\"left\" height=\"30\" style=\"font-size:18px; font-family:Verdana, Geneva, sans-serif; color:#1f7cae; padding-bottom:22px;\" valign=\"middle\"><strong>Dear {receiver_name},</strong></td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td align=\"left\" style=\"color: #fff;background-color:#1f7cae; border-bottom:solid 1px #8dbfd9;font-size: 17px;height: 40px;line-height: 27px;text-align: center;margin-bottom:22px;\" valign=\"middle\">This automated email has been sent to you as a member of the {companyname} {productname} onboarding project.<br>The due date for task {taskName}, owned by {ownerName}  has passed.</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\"><br>\r\n																		<p>\r\n																			Please see project details <a href=\"{detailpagelink}\" target=\"_blank\" style=\"text-decoration:none;color: #171717;cursor: pointer;font-size: 15px;\"> <strong>here</strong></a>\r\n																		</p>\r\n																		<p>\r\n																			To unsubscribe from these updates,  <a href=\"{unsubscribeNotificationLink}\" target=\"_blank\" style=\"text-decoration:none;color: #171717;cursor: pointer;font-size: 15px;\"> <strong> Click here</strong></a>\r\n																		</p>\r\n																		</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:17px;color:#1f7cae;\" valign=\"top\">Regards,<br />\r\n																		{site_title} Team</td>\r\n																	</tr>\r\n																</tbody>\r\n															</table>\r\n															</td>\r\n														</tr>\r\n													</tbody>\r\n												</table>\r\n												</td>\r\n											</tr>\r\n											<tr>\r\n												<td height=\"15\" style=\"padding-bottom:15px;\">\r\n												<p>*This email account is not monitored. Please do not reply to this email as we will not be able to read and respond to your messages.</p>\r\n												</td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n									<td width=\"15\">&nbsp;</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" style=\"padding:5px; background: none repeat scroll 0 0 #333;\r\n    border-top: 1px solid #CCCCCC;color:#fff;\" valign=\"top\">\r\n						<p>You have received this message by auto generated e-mail.</p>\r\n\r\n						<center>{copyrightText}</center>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '2017-08-09'),
(9, 'Phase overdue', '<table border=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#fff; box-shadow:0 0 10px #ccc;\" width=\"600\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" height=\"100\" style=\"background:url(./assets/default/images/header_bg.jpg) 0 0 repeat-x; border-top: 6px solid #566369; border-bottom:solid 1px #f5f5f5;\" valign=\"middle\">{logo}</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n							<tbody>\r\n								<tr>\r\n									<td width=\"15\">&nbsp;</td>\r\n									<td width=\"570\">\r\n									<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n										<tbody>\r\n											<tr>\r\n												<td height=\"15\">&nbsp;</td>\r\n											</tr>\r\n											<tr>\r\n												<td width=\"530\">\r\n												<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n													<tbody>\r\n														<tr>\r\n															<td style=\"font-family:Arial, Helvetica, sans-serif; padding:10px; font-size:13px; color:#ec7475;\">\r\n															<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n																<tbody>\r\n																	<tr>\r\n																		<td align=\"left\" height=\"30\" style=\"font-size:18px; font-family:Verdana, Geneva, sans-serif; color:#1f7cae; padding-bottom:22px;\" valign=\"middle\"><strong>Dear {receiver_name},</strong></td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td align=\"left\" style=\"color: #fff;background-color:#1f7cae; border-bottom:solid 1px #8dbfd9;font-size: 17px;height: 40px;line-height: 27px;text-align: center;margin-bottom:22px;\" valign=\"middle\">This automated email has been sent to you as a member of the {companyname} {productname} onboarding project.<br>The due date for phase {phaseName} has passed.</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\"><br>\r\n																		<p>\r\n																			Please see project details <a href=\"{detailpagelink}\" target=\"_blank\" style=\"text-decoration:none;color: #171717;cursor: pointer;font-size: 15px;\"> <strong>here</strong></a>\r\n																		</p>\r\n																		<p>\r\n																			To unsubscribe from these updates,  <a href=\"{unsubscribeNotificationLink}\" target=\"_blank\" style=\"text-decoration:none;color: #171717;cursor: pointer;font-size: 15px;\"> <strong> Click here</strong></a>\r\n																		</p>\r\n																		</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:17px;color:#1f7cae;\" valign=\"top\">Regards,<br />\r\n																		{site_title} Team</td>\r\n																	</tr>\r\n																</tbody>\r\n															</table>\r\n															</td>\r\n														</tr>\r\n													</tbody>\r\n												</table>\r\n												</td>\r\n											</tr>\r\n											<tr>\r\n												<td height=\"15\" style=\"padding-bottom:15px;\">\r\n												<p>*This email account is not monitored. Please do not reply to this email as we will not be able to read and respond to your messages.</p>\r\n												</td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n									<td width=\"15\">&nbsp;</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" style=\"padding:5px; background: none repeat scroll 0 0 #333;\r\n    border-top: 1px solid #CCCCCC;color:#fff;\" valign=\"top\">\r\n						<p>You have received this message by auto generated e-mail.</p>\r\n\r\n						<center>{copyrightText}</center>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '2017-08-09'),
(10, 'Project Overdue', '<table border=\"0\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#fff; box-shadow:0 0 10px #ccc;\" width=\"600\">\r\n				<tbody>\r\n					<tr>\r\n						<td align=\"center\" height=\"100\" style=\"background:url(./assets/default/images/header_bg.jpg) 0 0 repeat-x; border-top: 6px solid #566369; border-bottom:solid 1px #f5f5f5;\" valign=\"middle\">{logo}</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n							<tbody>\r\n								<tr>\r\n									<td width=\"15\">&nbsp;</td>\r\n									<td width=\"570\">\r\n									<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n										<tbody>\r\n											<tr>\r\n												<td height=\"15\">&nbsp;</td>\r\n											</tr>\r\n											<tr>\r\n												<td width=\"530\">\r\n												<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n													<tbody>\r\n														<tr>\r\n															<td style=\"font-family:Arial, Helvetica, sans-serif; padding:10px; font-size:13px; color:#ec7475;\">\r\n															<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n																<tbody>\r\n																	<tr>\r\n																		<td align=\"left\" height=\"30\" style=\"font-size:18px; font-family:Verdana, Geneva, sans-serif; color:#1f7cae; padding-bottom:22px;\" valign=\"middle\"><strong>Dear {receiver_name},</strong></td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td align=\"left\" style=\"color: #fff;background-color:#1f7cae; border-bottom:solid 1px #8dbfd9;font-size: 17px;height: 40px;line-height: 27px;text-align: center;margin-bottom:22px;\" valign=\"middle\">This automated email has been sent to you as a member of the {companyname} {productname} onboarding project.<br>The due date for phase this project has passed.</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td style=\"font-family:Arial, Helvetica, sans-serif; font-size:13px;  color:#171717; line-height:22px; padding-bottom:15px;\" valign=\"top\"><br>\r\n																		<p>\r\n																			Please see project details <a href=\"{detailpagelink}\" target=\"_blank\" style=\"text-decoration:none;color: #171717;cursor: pointer;font-size: 15px;\"> <strong>here</strong></a>\r\n																		</p>\r\n																		<p>\r\n																			To unsubscribe from these updates,  <a href=\"{unsubscribeNotificationLink}\" target=\"_blank\" style=\"text-decoration:none;color: #171717;cursor: pointer;font-size: 15px;\"> <strong> Click here</strong></a>\r\n																		</p>\r\n																		</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:17px;color:#1f7cae;\" valign=\"top\">Regards,<br />\r\n																		{site_title} Team</td>\r\n																	</tr>\r\n																</tbody>\r\n															</table>\r\n															</td>\r\n														</tr>\r\n													</tbody>\r\n												</table>\r\n												</td>\r\n											</tr>\r\n											<tr>\r\n												<td height=\"15\" style=\"padding-bottom:15px;\">\r\n												<p>*This email account is not monitored. Please do not reply to this email as we will not be able to read and respond to your messages.</p>\r\n												</td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n									<td width=\"15\">&nbsp;</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td align=\"center\" style=\"padding:5px; background: none repeat scroll 0 0 #333;\r\n    border-top: 1px solid #CCCCCC;color:#fff;\" valign=\"top\">\r\n						<p>You have received this message by auto generated e-mail.</p>\r\n\r\n						<center>{copyrightText}</center>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '2017-08-09');

-- --------------------------------------------------------

--
-- Table structure for table `acct_fixedAssets`
--

CREATE TABLE `acct_fixedAssets` (
  `assetID` int(11) NOT NULL,
  `assetRef` varchar(55) DEFAULT NULL,
  `companyRef` varchar(55) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  `dateOfPurchase` date DEFAULT NULL,
  `depreciationPercentage` varchar(30) DEFAULT NULL,
  `taxPercentage` varchar(30) DEFAULT NULL,
  `amount` varchar(30) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acct_inventory`
--

CREATE TABLE `acct_inventory` (
  `inventoryID` int(11) NOT NULL,
  `inventoryRef` varchar(55) DEFAULT NULL,
  `companyRef` varchar(55) DEFAULT NULL,
  `inventoryCategoryRef` varchar(55) DEFAULT NULL,
  `transactionRef` varchar(255) DEFAULT NULL,
  `itemRef` varchar(255) DEFAULT NULL,
  `inventoryType` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for purchase 2 for purchase return 3 for sale 4 for sale return',
  `date` date DEFAULT NULL,
  `productRef` varchar(255) DEFAULT NULL,
  `quantity` varchar(55) DEFAULT NULL,
  `price` varchar(55) DEFAULT NULL,
  `amount` varchar(55) DEFAULT NULL COMMENT 'amount = price * quantity',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_inventory`
--

INSERT INTO `acct_inventory` (`inventoryID`, `inventoryRef`, `companyRef`, `inventoryCategoryRef`, `transactionRef`, `itemRef`, `inventoryType`, `date`, `productRef`, `quantity`, `price`, `amount`, `status`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(11, 'BdarpwjsTX8qha6u', 'Vm8HJeIOOcBgIJUG', NULL, 'GuNOzafFJeNzP7Ms', 'tOpxesvKpvHDnmK7', 1, NULL, 'kN43i5sh5gacVlwO', '1', '100', '100', 1, '2017-10-10', '2017-10-10', 'LnOpqEtCkIqgDPAs'),
(12, 'H8lT41um75NgUozv', 'Vm8HJeIOOcBgIJUG', NULL, 'GuNOzafFJeNzP7Ms', 'rP0Nm3TWVOPcnBML', 1, NULL, 'pFBGTdsMZ58R4Dpd', '2', '50', '100', 1, '2017-10-10', '2017-10-10', 'LnOpqEtCkIqgDPAs'),
(13, 'WIUDZpPJh7GOLAZT', 'Vm8HJeIOOcBgIJUG', NULL, 'GuNOzafFJeNzP7Ms', 'adkVc92hIkKulh01', 1, NULL, 'pFBGTdsMZ58R4Dpd', '3', '30', '90', 1, '2017-10-10', '2017-10-10', 'LnOpqEtCkIqgDPAs'),
(14, 'ekWfHbOP3jvVF0t5', 'Vm8HJeIOOcBgIJUG', NULL, 'QPczdRsZCDa2Wblm', 'axLfzeBHBfKNTFyk', 2, NULL, 'kN43i5sh5gacVlwO', '3', '3', '9', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(15, 'RMeulEU3opWvmLK2', 'Vm8HJeIOOcBgIJUG', NULL, '8BGtHAlCzm1TrecC', 'Phc8eYWA8iatgQYP', 2, NULL, 'A6oZd8aBxplAfv2m', '3', '3', '9', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(16, 'i6RHXQwNwXag5IAj', 'Vm8HJeIOOcBgIJUG', NULL, 'PyBSzJKlGgWaAOR1', 'BGk2SXtHjLqQm7H5', 1, NULL, '', '', '', '0', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(17, 'yUOYgXdfT2NUKuFD', 'Vm8HJeIOOcBgIJUG', NULL, 'PyBSzJKlGgWaAOR1', 'Sm9KA61WjsYAmqHE', 1, NULL, '', '', '', '0', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(18, 'pOqNVM6Dah2WxSrO', 'Vm8HJeIOOcBgIJUG', NULL, 'lTn7i1k5mMCZLrwp', 'z80tOYxdWaei0lr3', 1, NULL, 'kN43i5sh5gacVlwO', '1', '100', '100', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(20, 'ayeUAI5QHCr15AVv', 'Vm8HJeIOOcBgIJUG', NULL, 'lTn7i1k5mMCZLrwp', 'btQNqGs7yc8jQh9N', 1, NULL, NULL, '3', '30', '90', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(22, 'm0uGlJeCsMybBfC3', 'Vm8HJeIOOcBgIJUG', NULL, 'Unl6Ay58Dsbe8Wcm', '5Bv689ZMRjw61czQ', 2, NULL, 'kN43i5sh5gacVlwO', '3', '3', '9', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(23, 'MFKebv1hqetRsVOm', 'Vm8HJeIOOcBgIJUG', NULL, 'jN0UCpmoW72DHfj5', 'tIeAnQbxTlgZ43Kz', 2, NULL, 'kN43i5sh5gacVlwO', '3', '3', '9', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(29, '8fA40BObdpra3ijR', 'Vm8HJeIOOcBgIJUG', NULL, '2uCEY3PVq14wAVZK', '3YKaz1iPKzbJ1kqB', 1, NULL, 'kN43i5sh5gacVlwO', '4', '4', '16', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(30, 'pvEe7Vf1FMIZ9EpH', 'Vm8HJeIOOcBgIJUG', NULL, '2uCEY3PVq14wAVZK', 'VIy4pxCmLJXyR8gj', 1, NULL, 'A6oZd8aBxplAfv2m', '4', '4', '16', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(31, 'q9KbxFdZaZMlsPF9', '1q2OlNXsbdH46UT3', NULL, 'Eiw1P02htdIaKA1x', '60vIrFVqiGcQOUdg', 2, NULL, 'kN43i5sh5gacVlwO', '4', '4', '16', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(32, 'MolRkPmJ9pGxb3dB', '1q2OlNXsbdH46UT3', NULL, 'Eiw1P02htdIaKA1x', 'ZFQPLxGeFeD3HwWt', 2, NULL, 'pFBGTdsMZ58R4Dpd', '2', '4', '8', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(33, 'HXI0loK9WNIErCa1', '1q2OlNXsbdH46UT3', NULL, 'Eiw1P02htdIaKA1x', 'xqMErOZKaypbADFM', 2, NULL, 'pFBGTdsMZ58R4Dpd', '5', '5', '25', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(34, 'DXhJL3A4EtwxVUhJ', '1q2OlNXsbdH46UT3', NULL, 'dSp0zVoRohgUC5IH', 'WC0cGns6urZ5jW1A', 1, NULL, 'kN43i5sh5gacVlwO', '3', '33', '99', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(35, 'LJvGO72UmHrxMg27', '1q2OlNXsbdH46UT3', NULL, 'dSp0zVoRohgUC5IH', 'Tvf701YtzoW69RJZ', 1, NULL, 'A6oZd8aBxplAfv2m', '4', '4', '16', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(36, '2Cey1olJHGK21gnj', '1q2OlNXsbdH46UT3', NULL, 'Ut1vq0rngBYryt3v', '9de7BTgk94hptPLT', 2, NULL, 'A6oZd8aBxplAfv2m', '1', '100', '100', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(37, 'V1oEfYFXTOFY9y78', '1q2OlNXsbdH46UT3', NULL, 'Ut1vq0rngBYryt3v', 'EavQbdS20TbOXwgA', 2, NULL, 'A6oZd8aBxplAfv2m', '2', '50', '100', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(38, 'Kbz7qF8PiY3EvQ9T', '1q2OlNXsbdH46UT3', NULL, 'Ut1vq0rngBYryt3v', 'UF74umGfLoel3HQZ', 2, NULL, 'kN43i5sh5gacVlwO', '3', '30', '90', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(39, 'kp6vhxt2cWhnuwqa', '1q2OlNXsbdH46UT3', NULL, '3eJoE59LfE86sndZ', 'VCKo4s6gzUmvSK9D', 2, NULL, 'A6oZd8aBxplAfv2m', '1', '100', '100', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(40, 'C4bNr5at2q3YWiFr', '1q2OlNXsbdH46UT3', NULL, '3eJoE59LfE86sndZ', 'VucDjOm0fv6sJ4AS', 2, NULL, 'XrMy5TixezPkVRyG', '2', '50', '100', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(41, 'D3TkU8ZzdTbM87KH', '1q2OlNXsbdH46UT3', NULL, 'kHhUD6NV7hPIXgpx', 'KZy6BLkO6OSfEmPR', 1, NULL, 'A6oZd8aBxplAfv2m', '4', '4', '16', 1, '2017-10-11', '2017-10-11', 'LnOpqEtCkIqgDPAs'),
(42, 'czx7FKPDlSn61jCi', 'nsUdxwqoWdrnPjTM', NULL, 'SNLqBF1rGSqw0Uc3', 'nDoUzkcvGTHzPyLZ', 1, NULL, 'tEKSU4TnHwtXJq8z', '1', '100', '100', 1, '2017-10-12', '2017-10-12', 'LnOpqEtCkIqgDPAs'),
(43, 'vLDdUwlrvV0NFpmG', 'nsUdxwqoWdrnPjTM', NULL, 'SNLqBF1rGSqw0Uc3', 'QXDiK9xdAqZT4UXs', 1, NULL, 'zbNSLP3FE3raVpNt', '2', '50', '100', 1, '2017-10-12', '2017-10-12', 'LnOpqEtCkIqgDPAs'),
(44, 'U3H06WgsWAzhxGSn', 'nsUdxwqoWdrnPjTM', NULL, 'rSyb0sIn1rwkfj9A', 'ZYBHIMWcKSPY9Wr8', 1, NULL, 'tEKSU4TnHwtXJq8z', '1', '100', '100', 1, '2017-10-12', '2017-10-12', 'LnOpqEtCkIqgDPAs'),
(45, 'v5qba9eJO2KfvUud', 'nsUdxwqoWdrnPjTM', NULL, 'MbO98WvFbtVPe9jW', '87wfGsjpE4q6reDX', 2, NULL, 'tEKSU4TnHwtXJq8z', '1', '100', '100', 1, '2017-10-12', '2017-10-12', 'LnOpqEtCkIqgDPAs'),
(46, 'xfXdeIQvnuDzEK3B', 'knM50NtHC9G7QaDr', NULL, 'EN2cU3kpipbFl9Tm', 'PQnIfXpBQAFMUZGz', 1, NULL, 'XFx1fKPlt5McaUnB', '3.00', '4.00', '12', 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(47, '1bdnCAtJNtXYZwpl', 'knM50NtHC9G7QaDr', NULL, 'EN2cU3kpipbFl9Tm', 'AdwznBPk15wE93ut', 1, NULL, 'XFx1fKPlt5McaUnB', '6,666.00', '6,666.00', '36', 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(48, '8TRHPLBMyvIsWCz9', 'knM50NtHC9G7QaDr', NULL, 'zKpFhu1R01RLKZkc', 'TFBUvjoc4cU9zW0V', 2, NULL, 'XFx1fKPlt5McaUnB', '5.00', '5.00', '25', 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(50, 'dytcWrwROhQT2JPq', 'knM50NtHC9G7QaDr', NULL, 'pwVoO4J1F03z9XkM', 'fRbsUdAuKFtIeMk0', 1, NULL, 'XFx1fKPlt5McaUnB', '3.00', '3.00', '9', 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(51, 'nwT6krDP0gOMPyvG', 'knM50NtHC9G7QaDr', NULL, 'pwVoO4J1F03z9XkM', 'LqikSAtfydO85ZhV', 1, NULL, 'XFx1fKPlt5McaUnB', '5.00', '6.00', '30', 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(52, '90iZQYrPPLoAuHRr', 'knM50NtHC9G7QaDr', NULL, 'fBlSZUpFC7kBZzSx', 'brLNXIv2Um1rGEon', 1, NULL, 'XFx1fKPlt5McaUnB', '10.00', '10.00', '100', 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(53, 'n8DKaovGqAv0QsDo', 'knM50NtHC9G7QaDr', NULL, 'GbzE8WF5nEaJIYWc', 'ZtkX0mrGdakJg3iI', 1, NULL, 'XFx1fKPlt5McaUnB', '3.00', '3.00', '9', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(54, 'VLRnCjUbF86WhLcU', 'knM50NtHC9G7QaDr', NULL, 'c2n45tEsFQ3I6U89', 'C0xvNyoHvKkOqUow', 1, NULL, 'XFx1fKPlt5McaUnB', '3.00', '3.00', '9', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(55, 'KlvnoJWDMg6FmlJn', 'knM50NtHC9G7QaDr', NULL, 'iEApaYXuxV6YvmcF', 'bIA5kJhNG9raNOHX', 2, NULL, 'XFx1fKPlt5McaUnB', '3.00', '3.00', '9', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(56, '5DYWv7iEwalOT1F9', 'knM50NtHC9G7QaDr', NULL, 'YCzjEqd4PdWGpNeI', 'MCtA1RB9iy9PgRZT', 2, NULL, 'XFx1fKPlt5McaUnB', '3.00', '4.00', '12', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs');

-- --------------------------------------------------------

--
-- Table structure for table `acct_loans`
--

CREATE TABLE `acct_loans` (
  `loanID` int(11) NOT NULL,
  `loanRef` varchar(55) DEFAULT NULL,
  `companyRef` varchar(55) DEFAULT NULL,
  `loanType` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for short type 2 for long type',
  `loanSource` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for bank 2 for other',
  `loanToRef` varchar(55) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` text,
  `amount` varchar(55) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_loans`
--

INSERT INTO `acct_loans` (`loanID`, `loanRef`, `companyRef`, `loanType`, `loanSource`, `loanToRef`, `date`, `description`, `amount`, `status`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(2, 'fQi9jqYOiXQU1YJd', 'knM50NtHC9G7QaDr', 2, 2, 'fdg', '2017-11-01', '456', '45', 0, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(3, 'Ytp5wdbhNuj5J6ev', 'knM50NtHC9G7QaDr', 2, 1, 'tttt', '0000-00-00', 'sdf', '333', 0, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs');

-- --------------------------------------------------------

--
-- Table structure for table `acct_login`
--

CREATE TABLE `acct_login` (
  `id` int(11) NOT NULL,
  `clientRef` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `clientEmail` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `clientPassword` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `userType` int(11) DEFAULT NULL,
  `isEmailVerified` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for no 2 for yes',
  `addedBy` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `createdDate` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `isDeleted` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for not deleted 1 for deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_login`
--

INSERT INTO `acct_login` (`id`, `clientRef`, `clientEmail`, `clientPassword`, `userType`, `isEmailVerified`, `addedBy`, `createdDate`, `status`, `isDeleted`) VALUES
(1, 'J3v8SXpybZzHkEUc', 'admin@accounting.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 2, '0', '2017-10-04', 1, 0),
(2, 'LnOpqEtCkIqgDPAs', 'accountant@accounting.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 2, '0', '2017-10-04', 1, 0),
(28, 'iGAx72np809NC42i', 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-07', 1, 0),
(29, 'Pl5SZCMtPu0QRiTA', 'aaa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-07', 1, 0),
(30, 'ePrTQXYjcB67aCug', 'sss@test.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-07', 1, 0),
(31, 'VPxlp4mYbcUB0yxa', 'ddd@ddd.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-09', 1, 0),
(32, 'GaMIoy4h9BM6m2l8', 'test@gmail.co', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-09', 1, 0),
(33, 'tJxjYr9pt1XBnSUO', 'gurdeep@11wayit.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-12', 1, 0),
(34, '5FwAZTyq2EnmiogP', 'akash@1wayit.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, NULL, '2017-10-12', 1, 0),
(35, 'RBV7kfOyj2MTknz6', 'gurbinder@1wayit.com', '469a3ff04f96b743faf4d7d4205d5558', 3, 1, NULL, '2017-10-12', 1, 0),
(36, '50aOy6qf7IayBvZ6', 'test@ff.com', '60352c4bb73bb4a2bc8c4772b8f04ddc', 3, 1, NULL, '2017-10-12', 1, 0),
(37, 'DHwRJtgUZMeQfgjS', 'testSDf@sdfff.dgd', 'd54b6487d045528f3bdff92d843db923', 3, 1, NULL, '2017-10-12', 1, 0),
(38, 'PjGQ267bU8M5HIN4', 'dfg@sdfs.cbvb', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-12', 1, 0),
(39, '0lhc8wenMVtKusNF', 'ssdfsf@gmail.com', 'b50ccd9183eff88b81e59e09035c197c', 3, 1, NULL, '2017-10-12', 1, 0),
(40, 'AJMKsCm34PR8wEXN', 'ttt@fff.com', 'f87ba0c9e338f40aa4228197f3f6cc6f', 3, 1, NULL, '2017-10-12', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `acct_logs`
--

CREATE TABLE `acct_logs` (
  `Id` int(11) NOT NULL,
  `clientRef` varchar(55) DEFAULT NULL,
  `companyRef` varchar(55) DEFAULT NULL,
  `sourceID` varchar(55) DEFAULT NULL,
  `source` varchar(240) DEFAULT NULL COMMENT 'like purchase,sale',
  `description` varchar(240) DEFAULT NULL,
  `action` varchar(240) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acct_products`
--

CREATE TABLE `acct_products` (
  `productID` int(11) NOT NULL,
  `productRef` varchar(255) DEFAULT NULL,
  `companyRef` varchar(255) DEFAULT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `productCode` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_products`
--

INSERT INTO `acct_products` (`productID`, `productRef`, `companyRef`, `productName`, `productCode`, `status`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(1, 'tEKSU4TnHwtXJq8z', 'nsUdxwqoWdrnPjTM', 'maruti 800', NULL, 1, '2017-10-12', '2017-10-12', 'LnOpqEtCkIqgDPAs'),
(2, 'zbNSLP3FE3raVpNt', 'nsUdxwqoWdrnPjTM', 'maruti 8001', NULL, 1, '2017-10-12', '2017-10-12', 'LnOpqEtCkIqgDPAs'),
(3, 'gKuWHwfZFwoIiJR7', 'nsUdxwqoWdrnPjTM', 'maruti 200', NULL, 1, '2017-10-12', '2017-10-12', 'LnOpqEtCkIqgDPAs'),
(4, 'XFx1fKPlt5McaUnB', 'knM50NtHC9G7QaDr', 'test', NULL, 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs');

-- --------------------------------------------------------

--
-- Table structure for table `acct_shareCapital`
--

CREATE TABLE `acct_shareCapital` (
  `id` int(11) NOT NULL,
  `shareRef` varchar(55) DEFAULT NULL,
  `title` varchar(55) DEFAULT NULL,
  `firstName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `lastName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `mobile` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `address1` text NOT NULL,
  `address2` text,
  `address3` text,
  `country` varchar(20) NOT NULL,
  `zipCode` int(8) DEFAULT NULL,
  `niNumber` varchar(255) DEFAULT NULL,
  `utrNumber` varchar(255) DEFAULT NULL,
  `noOfShare` int(11) DEFAULT NULL,
  `companyRef` varchar(55) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for active 0 for inactive',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acct_shareHolder`
--

CREATE TABLE `acct_shareHolder` (
  `id` int(11) NOT NULL,
  `shareRef` varchar(55) DEFAULT NULL,
  `title` varchar(55) DEFAULT NULL,
  `firstName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `lastName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `mobile` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `address1` text NOT NULL,
  `address2` text,
  `address3` text,
  `country` varchar(20) NOT NULL,
  `zipCode` int(8) DEFAULT NULL,
  `niNumber` varchar(255) DEFAULT NULL,
  `utrNumber` varchar(255) DEFAULT NULL,
  `noOfShare` int(11) DEFAULT NULL,
  `companyRef` varchar(55) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for active 0 for inactive',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_shareHolder`
--

INSERT INTO `acct_shareHolder` (`id`, `shareRef`, `title`, `firstName`, `lastName`, `email`, `mobile`, `dob`, `address`, `address1`, `address2`, `address3`, `country`, `zipCode`, `niNumber`, `utrNumber`, `noOfShare`, `companyRef`, `status`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(2, 'DdUjrSzw2vTIl58e', 'Mr.', 'test', 'test', 'testa@gmail.com', '(123) 312-3123', '0000-00-00', '123', '12312', '3123', '1231', '123', 123, '1231', '123', 123, 'knM50NtHC9G7QaDr', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(3, 'RtnHAVcToBihxNg2', 'Mr.', 's', 'sdfdfsdf', 'sdfsd@gmai.com', '', '0000-00-00', '', '', '', '', '', 0, '234', '234', 2342, 'knM50NtHC9G7QaDr', 0, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs');

-- --------------------------------------------------------

--
-- Table structure for table `acct_transactionItems`
--

CREATE TABLE `acct_transactionItems` (
  `itemID` int(11) NOT NULL,
  `itemRef` varchar(55) DEFAULT NULL,
  `transactionRef` varchar(55) DEFAULT NULL,
  `categoryRef` varchar(55) DEFAULT NULL,
  `subcategoryRef` varchar(55) DEFAULT NULL,
  `productRef` varchar(255) DEFAULT NULL,
  `description` text,
  `quantity` varchar(255) DEFAULT NULL,
  `rate` varchar(55) DEFAULT NULL,
  `amount` varchar(55) DEFAULT NULL,
  `vatAmount` varchar(55) DEFAULT NULL,
  `vatPercentage` varchar(55) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_transactionItems`
--

INSERT INTO `acct_transactionItems` (`itemID`, `itemRef`, `transactionRef`, `categoryRef`, `subcategoryRef`, `productRef`, `description`, `quantity`, `rate`, `amount`, `vatAmount`, `vatPercentage`, `status`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(1, 'MwL75KT8A8fcPwFr', 'vVdMyNE46e2uUwaN', 'wlge2pPUC2WObeUp', 'rZOAfNWESgIkb5cF', NULL, 'office supplies', '10.00', '10.00', '100', '', '20', 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(2, '3D2tpvKjSEx9GRDP', 'vVdMyNE46e2uUwaN', 'ny79lTLzrIenwm8B', 'HSFA7m2bnsG4QN1x', NULL, 'kkk', '20.00', '5.00', '100', '', '20', 1, '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(3, 'ZtkX0mrGdakJg3iI', 'GbzE8WF5nEaJIYWc', NULL, NULL, 'XFx1fKPlt5McaUnB', 't5', '3.00', '3.00', '9', '', '3', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(4, 'C0xvNyoHvKkOqUow', 'c2n45tEsFQ3I6U89', NULL, NULL, 'XFx1fKPlt5McaUnB', '3', '3.00', '3.00', '9', '', '3', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(5, 'bIA5kJhNG9raNOHX', 'iEApaYXuxV6YvmcF', NULL, NULL, 'XFx1fKPlt5McaUnB', 'test', '3.00', '3.00', '9', '', '33', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(6, 'MCtA1RB9iy9PgRZT', 'YCzjEqd4PdWGpNeI', NULL, NULL, 'XFx1fKPlt5McaUnB', '5', '3.00', '4.00', '12', '', '5', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(7, 'csntoPkRe964wp3f', 'zf351lZXLB4kyMcn', 'wlge2pPUC2WObeUp', 'BXxs0mpFZianSTFN', NULL, 'test', '3.00', '3.00', '9', '', '3', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(8, 'TVQW1eb2cqjiQ9Uo', '9Wzo4RGvoJLpDy6T', 'wlge2pPUC2WObeUp', 'k0rbXLtsedSBrGhn', NULL, 'test', '3.00', '3.00', '9', '', '3', 1, '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs');

-- --------------------------------------------------------

--
-- Table structure for table `acct_transactions`
--

CREATE TABLE `acct_transactions` (
  `transactionID` int(11) NOT NULL,
  `invoiceNo` varchar(255) NOT NULL,
  `transactionRef` varchar(55) DEFAULT NULL,
  `companyRef` varchar(55) DEFAULT NULL,
  `transactionYear` varchar(55) NOT NULL COMMENT 'like 2015/2016',
  `transactionType` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for purchase 2 for sale 3 for expense',
  `payee` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for debtor , 2 for creditor',
  `payeeRef` varchar(55) DEFAULT NULL,
  `paymentDate` date DEFAULT NULL,
  `paymentMethod` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for cash , 2 for bank, 3 for credit card 4 card and 5 cheque',
  `subTotal` varchar(100) DEFAULT NULL,
  `vatTotal` varchar(100) DEFAULT NULL,
  `grandTotal` varchar(100) DEFAULT NULL,
  `discountType` enum('1','2') DEFAULT NULL COMMENT '1 for price,2 for percentage',
  `discountAmount` varchar(55) DEFAULT NULL,
  `commisionType` enum('1','2') DEFAULT NULL COMMENT '1 for price,2 for percentage',
  `commisionAmount` varchar(55) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0 for inactive 1 for active',
  `paymentStatus` varchar(255) DEFAULT NULL COMMENT 'pending/paid',
  `deliveryDate` varchar(255) DEFAULT NULL,
  `invoiceDate` varchar(255) DEFAULT NULL,
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_transactions`
--

INSERT INTO `acct_transactions` (`transactionID`, `invoiceNo`, `transactionRef`, `companyRef`, `transactionYear`, `transactionType`, `payee`, `payeeRef`, `paymentDate`, `paymentMethod`, `subTotal`, `vatTotal`, `grandTotal`, `discountType`, `discountAmount`, `commisionType`, `commisionAmount`, `status`, `paymentStatus`, `deliveryDate`, `invoiceDate`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(1, 'INV-0001', 'vVdMyNE46e2uUwaN', 'knM50NtHC9G7QaDr', '2017/2018', 3, 2, 'gA6MdXxcf6EgTcOJ', '2017-10-16', 2, '200.00', '40.00', '240.00', NULL, NULL, NULL, NULL, 1, 'paid', '16-10-2017', '16-10-2017', '2017-10-16', '2017-10-16', 'LnOpqEtCkIqgDPAs'),
(2, 'INV-0002', 'GbzE8WF5nEaJIYWc', 'knM50NtHC9G7QaDr', '2017/2018', 1, 2, 'gA6MdXxcf6EgTcOJ', '2017-10-31', 2, '9.00', '0.27', '9.27', '', '0.00', '', '0.00', 1, 'pending', '27-10-2017', '17-10-2017', '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(3, 'INV-0003', 'c2n45tEsFQ3I6U89', 'knM50NtHC9G7QaDr', '2017/2018', 1, 2, 'gH1onJWrzTIYHRiw', '2017-10-17', 2, '9.00', '0.27', '9.27', '', '0.00', '', '0.00', 1, 'paid', '17-10-2017', '17-10-2017', '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(4, 'INV-0004', 'iEApaYXuxV6YvmcF', 'knM50NtHC9G7QaDr', '2017/2018', 2, 1, 'DtEQ1zK4ICWQPHvj', '2017-10-19', 1, '9.00', '2.97', '11.97', '', '0.00', '', '0.00', 1, 'pending', '17-10-2017', '17-10-2017', '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(5, 'INV-0005', 'YCzjEqd4PdWGpNeI', 'knM50NtHC9G7QaDr', '2017/2018', 2, 1, 'yesaFrpUZDgBshLU', '2017-10-10', 2, '12.00', '0.60', '12.60', '', '0.00', '', '0.00', 1, 'paid', '10-10-2017', '10-10-2017', '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(6, 'INV-0006', 'zf351lZXLB4kyMcn', 'knM50NtHC9G7QaDr', '2017/2018', 3, 2, 'bs6gtJCQuBrb9giR', '2017-10-17', 1, '9.00', '0.27', '9.27', NULL, NULL, NULL, NULL, 1, 'paid', '17-10-2017', '17-10-2017', '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs'),
(7, 'INV-0007', '9Wzo4RGvoJLpDy6T', 'knM50NtHC9G7QaDr', '2017/2018', 3, 2, 'gA6MdXxcf6EgTcOJ', '2017-10-17', 4, '9.00', '0.27', '9.27', NULL, NULL, NULL, NULL, 1, 'paid', '17-10-2017', '17-10-2017', '2017-10-17', '2017-10-17', 'LnOpqEtCkIqgDPAs');

-- --------------------------------------------------------

--
-- Table structure for table `acct_trialBalanceCategories`
--

CREATE TABLE `acct_trialBalanceCategories` (
  `categoryID` int(11) NOT NULL,
  `companyRef` varchar(255) NOT NULL,
  `categoryRef` varchar(255) DEFAULT NULL,
  `ParentCategoryRef` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'income,expense,depriciation,entertainment',
  `parent` int(11) DEFAULT NULL,
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0 for inactive 1 for active',
  `addedBy` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_trialBalanceCategories`
--

INSERT INTO `acct_trialBalanceCategories` (`categoryID`, `companyRef`, `categoryRef`, `ParentCategoryRef`, `title`, `type`, `parent`, `createdDate`, `modifiedDate`, `status`, `addedBy`) VALUES
(1, '', 'NVEiSZpleSya5G06', '', 'INVENTORY MANAGEMENT SYSTEM', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(2, '', 'ny79lTLzrIenwm8B', '', 'Discount/Commission', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(3, '', 'wlge2pPUC2WObeUp', '', 'General & Administrative', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(4, '', 'VktpB4bmEzSF3DUZ', '', 'Marketing & Promotional', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(5, '', 'h2v6V9eoD1Ng7q4a', '', 'Operating Expenses\r\n', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(6, '', '1mp5GKUZjvwkTZhr', '', 'Non Financial Cost', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(7, '', 'fRtLTMnyNjtuxUQ2', '', 'Motor Vehicle Expenses', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(8, '', 'ufpJZc020RLt13hW', '', 'Website Expenses', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(9, '', '8TfKAjQbFVtDREL3', '', 'Employment Expenses', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(10, '', 'ovFklz2C6n8Yv2sp', '', 'Occupancy Costs', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(11, '', 'eNIat1bmtFwcqM98', '', 'Finacial Cost', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(12, '', 'RtIJVnpDj6rFOvCn', '', 'Land or Buildings', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(13, '', 'V1ElTQx9yWIDH9OK', '', 'Plant & Equipment - General', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(14, '', '3YNMk0UB8uC93Hnx', '', 'Computer Equipment - Hardware', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(15, '', '69VU8ysla86V3ZS4', '', 'Computer Equipment - Software', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(16, '', '5TWs1JFKFWH3VvoZ', '', 'Furniture & Fixtures', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(17, '', 'YHKmAVaIEZ4HDLWG', '', 'Motor Vehicles', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(18, '', '7DQIbpM5mxlGaj5N', '', 'Office Equipment', 'expense', 0, '2017-10-05', '2017-10-05', 1, ''),
(20, '', 'MsVfObrT4PI1QmGV', 'NVEiSZpleSya5G06', 'Purchase Return', 'expense', 1, '2017-10-05', '2017-10-05', 1, ''),
(21, '', 'FUXcYlCpKlAp2yGq', 'NVEiSZpleSya5G06', 'Sales Return', 'expense', 1, '2017-10-05', '2017-10-05', 1, ''),
(22, '', 'q5rYG6iDglQ0kaMp', 'ny79lTLzrIenwm8B', 'Sales Discounts given', 'expense', 2, '2017-10-05', '2017-10-05', 1, ''),
(23, '', 'ONdz9pjalp75rw8G', 'ny79lTLzrIenwm8B', 'Sales Commissions paid', 'expense', 2, '2017-10-05', '2017-10-05', 1, ''),
(24, '', 'lNR6XkSKjUR68quF', 'wlge2pPUC2WObeUp', 'Bank charges', 'expense', 3, '2017-10-05', '2017-10-05', 1, ''),
(25, '', 'xNjUpX86geC5qOrh', 'wlge2pPUC2WObeUp', 'Credit card commission', 'expense', 3, '2017-10-05', '2017-10-05', 1, ''),
(26, '', 'BXxs0mpFZianSTFN', 'wlge2pPUC2WObeUp', 'Consultant fees', 'expense', 3, '2017-10-05', '2017-10-05', 1, ''),
(27, '', 'rZOAfNWESgIkb5cF', 'wlge2pPUC2WObeUp', 'Office Supplies', 'expense', 3, '2017-10-05', '2017-10-05', 1, ''),
(28, '', 'k0rbXLtsedSBrGhn', 'wlge2pPUC2WObeUp', 'License fees', 'expense', 3, '2017-10-05', '2017-10-05', 1, ''),
(29, '', 'NOU8TFKuuGxFUQtV', 'wlge2pPUC2WObeUp', 'Business insurance', 'expense', 3, '2017-10-05', '2017-10-05', 1, ''),
(30, '', 'EQLawBeFtNWf5P6M', 'wlge2pPUC2WObeUp', 'Audit Fees', 'expense', 3, '2017-10-05', '2017-10-05', 1, ''),
(31, '', 'TW8QEmB6oP1Bu70X', 'wlge2pPUC2WObeUp', 'Afilation Fess', 'expense', 3, '2017-10-05', '2017-10-05', 1, ''),
(32, '', 'Lsq2Om3nMFfcirAn', 'VktpB4bmEzSF3DUZ', 'Advertising', 'expense', 4, '2017-10-05', '2017-10-05', 1, ''),
(33, '', 'erdkOLEvdkDZrfne', 'VktpB4bmEzSF3DUZ', 'Promotion - General', 'expense', 4, '2017-10-05', '2017-10-05', 1, ''),
(34, '', 'cVt6ZWuJx2qA0C1w', 'VktpB4bmEzSF3DUZ', 'Promotion - Other', 'expense', 4, '2017-10-05', '2017-10-05', 1, ''),
(35, '', 'FlzDOAB8jywzJCWd', 'VktpB4bmEzSF3DUZ', 'Donations', 'expense', 4, '2017-10-05', '2017-10-05', 1, ''),
(36, '', 'rEIm9QDRS6MgjY0G', 'VktpB4bmEzSF3DUZ', 'Prizes distribute', 'expense', 4, '2017-10-05', '2017-10-05', 1, ''),
(37, '', 'rL6ZfH1KNxbR7cDr', 'VktpB4bmEzSF3DUZ', 'Free of Sample Goods', 'expense', 4, '2017-10-05', '2017-10-05', 1, ''),
(38, '', 'uAXistaeEfOIAgBd', 'h2v6V9eoD1Ng7q4a', 'Newspapers & magazines', 'expense', 5, '2017-10-05', '2017-10-05', 1, ''),
(39, '', 'Z3bgwHFSeQdF5WA4', 'h2v6V9eoD1Ng7q4a', 'Parking/Taxis/Tolls', 'expense', 5, '2017-10-05', '2017-10-05', 1, ''),
(40, '', 'QWs0khyEYXdBQCib', 'h2v6V9eoD1Ng7q4a', 'Entertainment/Meals', 'expense', 5, '2017-10-05', '2017-10-05', 1, ''),
(41, '', 'CjcEPhF65shoZflb', 'h2v6V9eoD1Ng7q4a', 'Travel/Accomodation', 'expense', 5, '2017-10-05', '2017-10-05', 1, ''),
(42, '', 'UlFzDf4LpvqNcuHx', 'h2v6V9eoD1Ng7q4a', 'Laundry/dry cleaning', 'expense', 5, '2017-10-05', '2017-10-05', 1, ''),
(43, '', 'Bb21DslGkbirKmzy', 'h2v6V9eoD1Ng7q4a', 'Cleaning & cleaning products', 'expense', 5, '2017-10-05', '2017-10-05', 1, ''),
(44, '', 'iIBsGYyk9TcRagLQ', 'h2v6V9eoD1Ng7q4a', 'Sundry supplies', 'expense', 5, '2017-10-05', '2017-10-05', 1, ''),
(45, '', 'm1JThG3QpTrYmS4g', 'h2v6V9eoD1Ng7q4a', 'Equipment hire', 'expense', 5, '2017-10-05', '2017-10-05', 1, ''),
(46, '', 'TW7s2mgUE06AIj2l', '1mp5GKUZjvwkTZhr', 'Depreciation', 'expense', 6, '2017-10-05', '2017-10-05', 1, ''),
(47, '', 'MVCTpQaRYLIXzTHv', '1mp5GKUZjvwkTZhr', 'Bad Debts', 'expense', 6, '2017-10-05', '2017-10-05', 1, ''),
(48, '', 'qOPwvGfsN0sS9TcJ', 'fRtLTMnyNjtuxUQ2', 'Fuel', 'expense', 7, '2017-10-05', '2017-10-05', 1, ''),
(49, '', 'F2ThfVWQEu28g13G', 'fRtLTMnyNjtuxUQ2', 'Vehicle service costs', 'expense', 7, '2017-10-05', '2017-10-05', 1, ''),
(50, '', 'LXwImrFDD30jvUVb', 'fRtLTMnyNjtuxUQ2', 'Tyres & other replacement costs', 'expense', 7, '2017-10-05', '2017-10-05', 1, ''),
(51, '', 'QPqyFHCDAfUupRzg', 'fRtLTMnyNjtuxUQ2', 'Motors Insurance', 'expense', 7, '2017-10-05', '2017-10-05', 1, ''),
(52, '', 'jDgLoQMUuH5cFMWl', 'fRtLTMnyNjtuxUQ2', 'Motor Registrations', 'expense', 7, '2017-10-05', '2017-10-05', 1, ''),
(53, '', 'HVT4AU7Mo3eY9gFz', 'ufpJZc020RLt13hW', 'Domain name registration', 'expense', 8, '2017-10-05', '2017-10-05', 1, ''),
(54, '', 'aF1B8xytrG1Weon4', 'ufpJZc020RLt13hW', 'Hosting expenses', 'expense', 8, '2017-10-05', '2017-10-05', 1, ''),
(55, '', 'aXdzg2MEp4Sarzei', '8TfKAjQbFVtDREL3', 'Salaries/Wages', 'expense', 9, '2017-10-05', '2017-10-05', 1, ''),
(56, '', 'KQyigjax1lgQo4Lp', '8TfKAjQbFVtDREL3', 'PAYE', 'expense', 9, '2017-10-05', '2017-10-05', 1, ''),
(57, '', 'idZT6whPpgV6S7N3', '8TfKAjQbFVtDREL3', 'Superannuation', 'expense', 9, '2017-10-05', '2017-10-05', 1, ''),
(58, '', 'xfAj0Jq2D4C1I7Fa', '8TfKAjQbFVtDREL3', 'Other - Employee Benefits', 'expense', 9, '2017-10-05', '2017-10-05', 1, ''),
(59, '', 'qSMuzHtftDCixLro', '8TfKAjQbFVtDREL3', 'Recruitment costs', 'expense', 9, '2017-10-05', '2017-10-05', 1, ''),
(60, '', 'wzdWlJmjAFvgdBUO', '8TfKAjQbFVtDREL3', 'Workcover Insurance', 'expense', 9, '2017-10-05', '2017-10-05', 1, ''),
(61, '', 'QGJfTiptTdygD40W', '8TfKAjQbFVtDREL3', 'Staff Training and Professional Development', 'expense', 9, '2017-10-05', '2017-10-05', 1, ''),
(62, '', 'Z1qgHrAERSbOaP6E', '8TfKAjQbFVtDREL3', 'Staff Recruitment Expneses', 'expense', 9, '2017-10-05', '2017-10-05', 1, ''),
(63, '', '2xDbi30MbI5hfeFD', '8TfKAjQbFVtDREL3', 'Staff welfare expenses', 'expense', 9, '2017-10-05', '2017-10-05', 1, ''),
(64, '', 'SHAR9cDorlFYxoBX', 'ovFklz2C6n8Yv2sp', 'Postage and Courier Cost', 'expense', 10, '2017-10-05', '2017-10-05', 1, ''),
(65, '', 'Rq43l5fIytV5oQ8p', 'ovFklz2C6n8Yv2sp', 'Electricity/Gas', 'expense', 10, '2017-10-05', '2017-10-05', 1, ''),
(66, '', 'JvOhVkcEoErybBdG', 'ovFklz2C6n8Yv2sp', 'Telephones', 'expense', 10, '2017-10-05', '2017-10-05', 1, ''),
(67, '', 'A73qZxyVDScbXt2Y', 'ovFklz2C6n8Yv2sp', 'Property Insurance', 'expense', 10, '2017-10-05', '2017-10-05', 1, ''),
(68, '', 's1r3zh7QX4SQ3p7N', 'ovFklz2C6n8Yv2sp', 'Rates', 'expense', 10, '2017-10-05', '2017-10-05', 1, ''),
(69, '', '92XnbOA0GUu7wDsX', 'ovFklz2C6n8Yv2sp', 'Rent', 'expense', 10, '2017-10-05', '2017-10-05', 1, ''),
(70, '', 'vuJ65ZgBHRWsCGaO', 'ovFklz2C6n8Yv2sp', 'Repair & maintenance', 'expense', 10, '2017-10-05', '2017-10-05', 1, ''),
(71, '', 'cdnQkuUa1pdlRnHE', 'ovFklz2C6n8Yv2sp', 'Waste removal', 'expense', 10, '2017-10-05', '2017-10-05', 1, ''),
(72, '', 'qL6bRiwu7AbP1ySB', 'ovFklz2C6n8Yv2sp', 'Water', 'expense', 10, '2017-10-05', '2017-10-05', 1, ''),
(73, '', 'U8KNZ7BOOPvVCZFd', 'ovFklz2C6n8Yv2sp', 'Internet Expenses', 'expense', 10, '2017-10-05', '2017-10-05', 1, ''),
(74, '', 'k1sGNBj2pVCRLfAx', 'eNIat1bmtFwcqM98', 'Interest charges', 'expense', 11, '2017-10-05', '2017-10-05', 1, ''),
(75, '', 'UYN4JcQ1WQ0FT7Ul', 'RtIJVnpDj6rFOvCn', 'Land Purchased Expenses', 'expense', 12, '2017-10-05', '2017-10-05', 1, ''),
(76, '', 'APhkMiHCNid8mMaG', 'RtIJVnpDj6rFOvCn', 'Land Improvement', 'expense', 12, '2017-10-05', '2017-10-05', 1, ''),
(77, '', '9FRN4VXEURWg9r3u', 'RtIJVnpDj6rFOvCn', 'Building Purchase Expenses', 'expense', 12, '2017-10-05', '2017-10-05', 1, ''),
(78, '', 'nRxKwe8Xtn8zAIh5', 'RtIJVnpDj6rFOvCn', 'Building Improvement Expenses', 'expense', 12, '2017-10-05', '2017-10-05', 1, ''),
(79, '', 'CAdH2us1yS4OcxRo', 'V1ElTQx9yWIDH9OK', 'Machinery Purchase Expenses', 'expense', 13, '2017-10-05', '2017-10-05', 1, ''),
(80, '', 'ginD7FdGKQpTXSB6', 'V1ElTQx9yWIDH9OK', 'Plant Purchase Expenses', 'expense', 13, '2017-10-05', '2017-10-05', 1, ''),
(81, '', 'haydNRH8V7JvKXg8', '3YNMk0UB8uC93Hnx', 'Computer Expenses', 'expense', 14, '2017-10-05', '2017-10-05', 1, ''),
(82, '', '6l0RYP5fBsiDyW2S', '69VU8ysla86V3ZS4', 'Software Expenses', 'expense', 15, '2017-10-05', '2017-10-05', 1, ''),
(83, '', '4DVAzriuuG032dkP', '5TWs1JFKFWH3VvoZ', 'Table Purcahse Expenses', 'expense', 16, '2017-10-05', '2017-10-05', 1, ''),
(84, '', 'bLiDUuMV4vZDwGeE', '5TWs1JFKFWH3VvoZ', 'Cabinet Purcahse Expenses', 'expense', 16, '2017-10-05', '2017-10-05', 1, ''),
(85, '', 'TNOlI8mKie9d1zqL', '5TWs1JFKFWH3VvoZ', 'Chair Purchase Expenses', 'expense', 16, '2017-10-05', '2017-10-05', 1, ''),
(86, '', 'mekytvHRPncUiG0b', 'YHKmAVaIEZ4HDLWG', 'Car Purchases Expenses', 'expense', 17, '2017-10-05', '2017-10-05', 1, ''),
(87, '', 'eGSwuCibQjG8lkB9', 'YHKmAVaIEZ4HDLWG', 'Bike Purchase Expenses', 'expense', 17, '2017-10-05', '2017-10-05', 1, ''),
(88, '', 'kPbVfONGCdNJp6uh', '7DQIbpM5mxlGaj5N', 'Telephones purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1, ''),
(89, '', 'k42KZru1JDgnLhxV', '7DQIbpM5mxlGaj5N', 'Router Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1, ''),
(90, '', 'BLMDYrbSbnIGH6Ql', '7DQIbpM5mxlGaj5N', 'Epbx System Purchase', 'expense', 18, '2017-10-05', '2017-10-05', 1, ''),
(91, '', 'o69SQ2v1G17bc2zt', '7DQIbpM5mxlGaj5N', 'Printer Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1, ''),
(92, '', 'BFkZvRDmKtP4jUfN', '7DQIbpM5mxlGaj5N', 'Fax Machine Purchase expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1, ''),
(93, '', '6zwMxV9PhgcXieSx', '7DQIbpM5mxlGaj5N', 'Video Projector Purchase expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1, ''),
(94, '', 'sn0B8ISWiTFHVJEu', '7DQIbpM5mxlGaj5N', 'Photocopier Machine Purchase', 'expense', 18, '2017-10-05', '2017-10-05', 1, ''),
(95, '', '8FMnGy0mrXA5qhyo', '7DQIbpM5mxlGaj5N', 'Film Recorder Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1, ''),
(96, '', 'jsKNoyd4vmrOzaS7', '7DQIbpM5mxlGaj5N', 'Refrijrator Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1, ''),
(97, '', 'WndswSTqvFdalYMX', '', 'Sales', 'income', 0, '2017-10-05', '2017-10-05', 1, ''),
(98, '', 'U92h8H3yP2EAxY8r', 'WndswSTqvFdalYMX', 'Sale of goods/services', 'income', 97, '2017-10-05', '2017-10-05', 1, ''),
(99, '', '0kdhe3ZXxen4c7IW', 'WndswSTqvFdalYMX', 'Sundry Income', 'income', 97, '2017-10-05', '2017-10-05', 1, ''),
(100, 'knM50NtHC9G7QaDr', 'HSFA7m2bnsG4QN1x', 'ny79lTLzrIenwm8B', 'kkk', 'expense', 2, '2017-10-16', '2017-10-16', 1, 'LnOpqEtCkIqgDPAs'),
(101, 'knM50NtHC9G7QaDr', 'XtfbIcErCMIu6DqX', 'ny79lTLzrIenwm8B', 'jujnjn', 'expense', 2, '2017-10-16', '2017-10-16', 1, 'LnOpqEtCkIqgDPAs'),
(102, 'knM50NtHC9G7QaDr', 'bAq26plF72vMiHN1', 'ny79lTLzrIenwm8B', 'fffff', 'expense', 2, '2017-10-16', '2017-10-16', 1, 'LnOpqEtCkIqgDPAs'),
(103, 'knM50NtHC9G7QaDr', 'yXlfzdTrcyiGm0Oe', 'ny79lTLzrIenwm8B', 'fgggggggg', 'expense', 2, '2017-10-16', '2017-10-16', 1, 'LnOpqEtCkIqgDPAs'),
(104, 'knM50NtHC9G7QaDr', 'DqPdYH1x2zJIDSyw', 'NVEiSZpleSya5G06', 'oooooo', 'expense', 1, '2017-10-16', '2017-10-16', 1, 'LnOpqEtCkIqgDPAs'),
(105, 'knM50NtHC9G7QaDr', '5EJzfsVdc7oeIbzM', 'ny79lTLzrIenwm8B', 'tttt', 'expense', 2, '2017-10-17', '2017-10-17', 1, 'LnOpqEtCkIqgDPAs');

-- --------------------------------------------------------

--
-- Table structure for table `acct_vats`
--

CREATE TABLE `acct_vats` (
  `vatID` int(11) NOT NULL,
  `vatRef` varchar(55) DEFAULT NULL,
  `companyRef` varchar(55) DEFAULT NULL,
  `vatYear` varchar(55) DEFAULT NULL,
  `vatPercentage` varchar(55) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_vats`
--

INSERT INTO `acct_vats` (`vatID`, `vatRef`, `companyRef`, `vatYear`, `vatPercentage`, `status`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(1, 'YnjmQZbgZbBY2qfL', 'nsUdxwqoWdrnPjTM', '2017', '2', 1, '2017-10-12', '2017-10-12', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acct_banks`
--
ALTER TABLE `acct_banks`
  ADD PRIMARY KEY (`bankID`);

--
-- Indexes for table `acct_clientProfile`
--
ALTER TABLE `acct_clientProfile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acct_companies`
--
ALTER TABLE `acct_companies`
  ADD PRIMARY KEY (`companyID`);

--
-- Indexes for table `acct_companyUsers`
--
ALTER TABLE `acct_companyUsers`
  ADD PRIMARY KEY (`comUserID`);

--
-- Indexes for table `acct_configuration`
--
ALTER TABLE `acct_configuration`
  ADD PRIMARY KEY (`configID`);

--
-- Indexes for table `acct_creditors`
--
ALTER TABLE `acct_creditors`
  ADD PRIMARY KEY (`creditorID`);

--
-- Indexes for table `acct_debtors`
--
ALTER TABLE `acct_debtors`
  ADD PRIMARY KEY (`debtorID`);

--
-- Indexes for table `acct_emailTemplates`
--
ALTER TABLE `acct_emailTemplates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acct_fixedAssets`
--
ALTER TABLE `acct_fixedAssets`
  ADD PRIMARY KEY (`assetID`);

--
-- Indexes for table `acct_inventory`
--
ALTER TABLE `acct_inventory`
  ADD PRIMARY KEY (`inventoryID`);

--
-- Indexes for table `acct_loans`
--
ALTER TABLE `acct_loans`
  ADD PRIMARY KEY (`loanID`);

--
-- Indexes for table `acct_login`
--
ALTER TABLE `acct_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acct_logs`
--
ALTER TABLE `acct_logs`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `acct_products`
--
ALTER TABLE `acct_products`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `acct_shareCapital`
--
ALTER TABLE `acct_shareCapital`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acct_shareHolder`
--
ALTER TABLE `acct_shareHolder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acct_transactionItems`
--
ALTER TABLE `acct_transactionItems`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `acct_transactions`
--
ALTER TABLE `acct_transactions`
  ADD PRIMARY KEY (`transactionID`);

--
-- Indexes for table `acct_trialBalanceCategories`
--
ALTER TABLE `acct_trialBalanceCategories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `acct_vats`
--
ALTER TABLE `acct_vats`
  ADD PRIMARY KEY (`vatID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acct_banks`
--
ALTER TABLE `acct_banks`
  MODIFY `bankID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `acct_clientProfile`
--
ALTER TABLE `acct_clientProfile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `acct_companies`
--
ALTER TABLE `acct_companies`
  MODIFY `companyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `acct_companyUsers`
--
ALTER TABLE `acct_companyUsers`
  MODIFY `comUserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_configuration`
--
ALTER TABLE `acct_configuration`
  MODIFY `configID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_creditors`
--
ALTER TABLE `acct_creditors`
  MODIFY `creditorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `acct_debtors`
--
ALTER TABLE `acct_debtors`
  MODIFY `debtorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `acct_emailTemplates`
--
ALTER TABLE `acct_emailTemplates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `acct_fixedAssets`
--
ALTER TABLE `acct_fixedAssets`
  MODIFY `assetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_inventory`
--
ALTER TABLE `acct_inventory`
  MODIFY `inventoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `acct_loans`
--
ALTER TABLE `acct_loans`
  MODIFY `loanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `acct_login`
--
ALTER TABLE `acct_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `acct_logs`
--
ALTER TABLE `acct_logs`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_products`
--
ALTER TABLE `acct_products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `acct_shareCapital`
--
ALTER TABLE `acct_shareCapital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_shareHolder`
--
ALTER TABLE `acct_shareHolder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `acct_transactionItems`
--
ALTER TABLE `acct_transactionItems`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `acct_transactions`
--
ALTER TABLE `acct_transactions`
  MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `acct_trialBalanceCategories`
--
ALTER TABLE `acct_trialBalanceCategories`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `acct_vats`
--
ALTER TABLE `acct_vats`
  MODIFY `vatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
