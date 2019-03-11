-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 06, 2017 at 10:31 AM
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
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_clientProfile`
--

INSERT INTO `acct_clientProfile` (`id`, `clientProfileRef`, `title`, `firstName`, `lastName`, `email`, `phone`, `mobile`, `fax`, `website`, `billingAddress`, `shippingAddress`, `sameAsBilling`, `status`, `createdDate`, `modifiedDate`, `addedBy`) VALUES
(1, '8xQgAaUchlx1MdCN', 'Mr.', 'gurdeep', 'singh', 'gurdeep@1wayit.com', '(123) 113-2132', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, '2017-10-04', '2017-10-04', '0'),
(2, 'sEedpZLGasEUjzbc', 'Mr.', 'jacaB', 'TESTER', 'jacab@gmail.com', '(456) 456-4564', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, '2017-10-04', '2017-10-04', '0'),
(3, 'q62ytU9Mu3Aw8lcT', 'Mr.', 'Test', 'Test', 'test@gmail.com', '(213) 123-1231', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, '2017-10-04', '2017-10-04', '0'),
(4, 'Bu82tA13OQAngYEP', 'Mr.', 'dd', 'ddd', 'ddd@gmail.com', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, '2017-10-04', '2017-10-04', '0'),
(5, 'tPEp3nVIBtxhIcON', 'Mr.', 'sdfg', 'sfdg', 'sdf@gmail.com', '(234) 234-2399', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, '2017-10-04', '2017-10-04', '0'),
(6, 'ZqFJpwm2t0pryFz3', NULL, NULL, NULL, 'tester@gmail.com', NULL, NULL, NULL, NULL, '', '', 0, 0, '2017-10-05', NULL, NULL),
(7, 'LTeMBHNZo6P4MQxq', 'Mr.', 'test', 'test', 'asd@ccc.ccc', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 0, '2017-10-05', '2017-10-05', NULL),
(8, 'b5VMtf8hS30UeI4s', 'Mr.', 'teseeee', 'eee', 'eee@ddd.dddd', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 0, 1, '2017-10-05', '2017-10-05', '0'),
(9, 'tRqniIC678YIrmew', 'Mr.', 'Eee', 'Ggg', 'ghh@gmail.com', '(234) 342-3423', '', '', '', 'a:5:{s:13:\"billingStreet\";s:3:\"ert\";s:11:\"billingCity\";s:3:\"ert\";s:12:\"billingState\";s:3:\"ert\";s:17:\"billingPostalCode\";s:3:\"ert\";s:14:\"billingCountry\";s:3:\"ert\";}', 'a:5:{s:14:\"shippingStreet\";s:3:\"ert\";s:12:\"shippingCity\";s:3:\"ert\";s:13:\"shippingState\";s:3:\"ert\";s:18:\"shippingPostalCode\";s:3:\"ert\";s:15:\"shippingCountry\";s:3:\"ert\";}', 1, 1, '2017-10-05', '2017-10-05', '0'),
(10, '95mTibqMaXjxpH76', 'Mr.', 'Resdfg', 'Sdfg', 'sdfg@gmmm.cpds', '(123) 123-1231', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, 1, '2017-10-05', '2017-10-05', '0');

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
(1, '6mgDeRUMzDlhG8k3', '8xQgAaUchlx1MdCN', 'guru', 'Trading', '234', 1, 'test', '234', '2017-10-24', '2017-10-19', '2017-10-31', 'test', NULL, '', '', 1, '2017-10-04', '2017-10-04', '0'),
(2, 'pyFhkAPiDxgUnTrX', 'sEedpZLGasEUjzbc', 'jacab', 'Trading', '2343', 1, '22332', '234', '2017-10-26', '2017-10-27', '2017-10-30', 'test', NULL, '', '', 1, '2017-10-04', '2017-10-04', '0'),
(3, '3YxGpoI4DPcIjQXO', 'q62ytU9Mu3Aw8lcT', 'test', 'Service/Consultancy', '3424', 2, '', '', '2017-10-31', '2017-10-27', '2017-11-02', '', NULL, '', '', 1, '2017-10-04', '2017-10-04', '0'),
(4, 'JoWTK2S37SbWDYsh', 'ZqFJpwm2t0pryFz3', 'tester', 'Trading', NULL, 1, '23432', NULL, NULL, NULL, NULL, NULL, NULL, 'test', '(234) 324-2342', 1, '2017-10-05', '2017-10-05', '0'),
(5, 'V1KpWzDMlz31fWXj', 'LTeMBHNZo6P4MQxq', 'test', 'Service/Consultancy', '', 2, '', '', '1970-01-01', '2017-10-05', '2017-10-11', '', NULL, '', '', 1, '2017-10-05', '2017-10-05', '0'),
(6, 'blNw9mYxqSAbMkFV', 'tRqniIC678YIrmew', 'ert', 'Service/Consultancy', 'ert', 2, '', '', '1970-01-01', '2017-10-12', '2017-10-12', '', NULL, '', '', 1, '2017-10-05', '2017-10-05', '0');

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
(1, 'PEvtXd0cwSo0hIJm', '6mgDeRUMzDlhG8k3', 'Mr.', 'alex', 'tester', 'alex@gmail.com', '(121) 321-2313', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-04', '2017-10-04', '0'),
(2, 'EaHhdSrMWZe8Exiy', 'pyFhkAPiDxgUnTrX', 'Mr.', 'jass', 'tester', 'jass@gmail.com', '(324) 234-2342', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-04', '2017-10-04', '0'),
(3, 'aeFwGHADpA6mZ8cL', '6mgDeRUMzDlhG8k3', 'Mr.', 'kalia', 'tester', 'kalia@gmail.com', '(123) 123-1231', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-04', '2017-10-04', '0'),
(4, 'pfbkYhezPEVkcprb', '6mgDeRUMzDlhG8k3', 'Mr.', 'jagga', 'test', 'jagga@gmail.com', '(234) 242-3423', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-04', '2017-10-04', '0'),
(5, '8nI5rkXpGp4tI6Jl', '6mgDeRUMzDlhG8k3', 'Mr.', 'asd', 'asd', 'asda@gmai.clm', '(123) 121-2312', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-04', '2017-10-04', '0'),
(6, 'k4hUqXoiR7YPi1Xh', '6mgDeRUMzDlhG8k3', 'Mr.', 'asdf', 'sadf', 'tsafesta@gmail.com', '(324) 234-3454', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-04', '2017-10-04', '0'),
(7, 'OXaLgISpjo3lG6Bp', 'JoWTK2S37SbWDYsh', 'Mr.', 'test', 'test', 'testa@gmail.com', '(234) 234-2342', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-05', '2017-10-05', '0'),
(8, 'rCItmSH7COlEkM4a', 'JoWTK2S37SbWDYsh', 'Mr.', 'ee', 'ee', 'eep@1wayit.com', '(324) 242-3423', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-05', '2017-10-05', '0'),
(9, 'RpO2zN6heasSGwQ3', 'JoWTK2S37SbWDYsh', 'Mr.', 'eeer', 'ee', 'eeep@1wayit.com', '(324) 234-2349', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-05', '2017-10-05', '0'),
(10, 'xYkoDSwVPMOdH6vb', 'JoWTK2S37SbWDYsh', 'Mr.', 'eerrr', 'eerr', 'eerep@1wayit.com', '(234) 234-2342', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-05', '2017-10-05', '0'),
(11, 'S3oNqnvj9Rj6JyXC', 'JoWTK2S37SbWDYsh', 'Mr.', 'eeggg', 'gg', 'eepggg@1wayit.com', '(234) 234-2342', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-05', '2017-10-05', '0'),
(12, 'Em4fX860bPXUymL6', 'JoWTK2S37SbWDYsh', 'Mr.', 'dsfs', 'sdf', 'gursdfu@gmail.com', '(234) 234-2342', '', '', '', '', 'a:5:{s:13:\"billingStreet\";s:0:\"\";s:11:\"billingCity\";s:0:\"\";s:12:\"billingState\";s:0:\"\";s:17:\"billingPostalCode\";s:0:\"\";s:14:\"billingCountry\";s:0:\"\";}', 'a:5:{s:14:\"shippingStreet\";s:0:\"\";s:12:\"shippingCity\";s:0:\"\";s:13:\"shippingState\";s:0:\"\";s:18:\"shippingPostalCode\";s:0:\"\";s:15:\"shippingCountry\";s:0:\"\";}', 1, '2017-10-05', '2017-10-05', '0');

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
(1, 'Verify Email', '', '2016-09-23'),
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
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_login`
--

INSERT INTO `acct_login` (`id`, `clientRef`, `clientEmail`, `clientPassword`, `userType`, `isEmailVerified`, `addedBy`, `createdDate`, `status`) VALUES
(1, 'J3v8SXpybZzHkEUc', 'admin@accounting.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 2, '0', '2017-10-04', 1),
(2, 'LnOpqEtCkIqgDPAs', 'accountant@accounting.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 2, '0', '2017-10-04', 1),
(3, '8xQgAaUchlx1MdCN', 'gurdeep@1wayit.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-04', 1),
(4, 'sEedpZLGasEUjzbc', 'jacab@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-04', 1),
(5, 'q62ytU9Mu3Aw8lcT', 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-04', 1),
(6, 'Bu82tA13OQAngYEP', 'ddd@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-04', 1),
(7, 'tPEp3nVIBtxhIcON', 'sdf@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-04', 1),
(8, 'ZqFJpwm2t0pryFz3', 'tester@gmail.com', 'cf311c967371f68b46315460640c48ce', 3, 1, NULL, '2017-10-05', 1),
(9, 'LTeMBHNZo6P4MQxq', 'asd@ccc.ccc', '4692e17cfb3b0691a8a66c4027691754', 3, 1, NULL, '2017-10-05', 1),
(10, 'b5VMtf8hS30UeI4s', 'eee@ddd.dddd', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-05', 1),
(11, 'tRqniIC678YIrmew', 'ghh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-05', 1),
(12, '95mTibqMaXjxpH76', 'sdfg@gmmm.cpds', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, '0', '2017-10-05', 1);

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
  `product` varchar(255) DEFAULT NULL,
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
  `paymentMethod` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for cash , 2 for bank, 3 for credit card',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0 for inactive 1 for active',
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `addedBy` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acct_trialBalanceCategories`
--

CREATE TABLE `acct_trialBalanceCategories` (
  `categoryID` int(11) NOT NULL,
  `categoryRef` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'income,expense,depriciation,entertainment',
  `parent` int(11) DEFAULT NULL,
  `createdDate` date DEFAULT NULL,
  `modifiedDate` date DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0 for inactive 1 for active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acct_trialBalanceCategories`
--

INSERT INTO `acct_trialBalanceCategories` (`categoryID`, `categoryRef`, `title`, `type`, `parent`, `createdDate`, `modifiedDate`, `status`) VALUES
(1, NULL, 'INVENTORY MANAGEMENT SYSTEM', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(2, NULL, 'Discount/Commission', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(3, NULL, 'General & Administrative', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(4, NULL, 'Marketing & Promotional', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(5, NULL, 'Operating Expenses\r\n', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(6, NULL, 'Non Financial Cost', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(7, NULL, 'Motor Vehicle Expenses', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(8, NULL, 'Website Expenses', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(9, NULL, 'Employment Expenses', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(10, NULL, 'Occupancy Costs', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(11, NULL, 'Finacial Cost', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(12, NULL, 'Land or Buildings', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(13, NULL, 'Plant & Equipment - General', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(14, NULL, 'Computer Equipment - Hardware', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(15, NULL, 'Computer Equipment - Software', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(16, NULL, 'Furniture & Fixtures', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(17, NULL, 'Motor Vehicles', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(18, NULL, 'Office Equipment', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(20, NULL, 'Purchase Return', 'expense', 1, '2017-10-05', '2017-10-05', 1),
(21, NULL, 'Sales Return', 'expense', 1, '2017-10-05', '2017-10-05', 1),
(22, NULL, 'Sales Discounts given', 'expense', 2, '2017-10-05', '2017-10-05', 1),
(23, NULL, 'Sales Commissions paid', 'expense', 2, '2017-10-05', '2017-10-05', 1),
(24, NULL, 'Bank charges', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(25, NULL, 'Credit card commission', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(26, NULL, 'Consultant fees', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(27, NULL, 'Office Supplies', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(28, NULL, 'License fees', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(29, NULL, 'Business insurance', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(30, NULL, 'Audit Fees', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(31, NULL, 'Afilation Fess', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(32, NULL, 'Advertising', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(33, NULL, 'Promotion - General', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(34, NULL, 'Promotion - Other', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(35, NULL, 'Donations', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(36, NULL, 'Prizes distribute', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(37, NULL, 'Free of Sample Goods', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(38, NULL, 'Newspapers & magazines', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(39, NULL, 'Parking/Taxis/Tolls', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(40, NULL, 'Entertainment/Meals', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(41, NULL, 'Travel/Accomodation', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(42, NULL, 'Laundry/dry cleaning', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(43, NULL, 'Cleaning & cleaning products', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(44, NULL, 'Sundry supplies', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(45, NULL, 'Equipment hire', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(46, NULL, 'Depreciation', 'expense', 6, '2017-10-05', '2017-10-05', 1),
(47, NULL, 'Bad Debts', 'expense', 6, '2017-10-05', '2017-10-05', 1),
(48, NULL, 'Fuel', 'expense', 7, '2017-10-05', '2017-10-05', 1),
(49, NULL, 'Vehicle service costs', 'expense', 7, '2017-10-05', '2017-10-05', 1),
(50, NULL, 'Tyres & other replacement costs', 'expense', 7, '2017-10-05', '2017-10-05', 1),
(51, NULL, 'Motors Insurance', 'expense', 7, '2017-10-05', '2017-10-05', 1),
(52, NULL, 'Motor Registrations', 'expense', 7, '2017-10-05', '2017-10-05', 1),
(53, NULL, 'Domain name registration', 'expense', 8, '2017-10-05', '2017-10-05', 1),
(54, NULL, 'Hosting expenses', 'expense', 8, '2017-10-05', '2017-10-05', 1),
(55, NULL, 'Salaries/Wages', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(56, NULL, 'PAYE', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(57, NULL, 'Superannuation', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(58, NULL, 'Other - Employee Benefits', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(59, NULL, 'Recruitment costs', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(60, NULL, 'Workcover Insurance', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(61, NULL, 'Staff Training and Professional Development', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(62, NULL, 'Staff Recruitment Expneses', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(63, NULL, 'Staff welfare expenses', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(64, NULL, 'Postage and Courier Cost', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(65, NULL, 'Electricity/Gas', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(66, NULL, 'Telephones', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(67, NULL, 'Property Insurance', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(68, NULL, 'Rates', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(69, NULL, 'Rent', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(70, NULL, 'Repair & maintenance', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(71, NULL, 'Waste removal', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(72, NULL, 'Water', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(73, NULL, 'Internet Expenses', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(74, NULL, 'Interest charges', 'expense', 11, '2017-10-05', '2017-10-05', 1),
(75, NULL, 'Land Purchased Expenses', 'expense', 12, '2017-10-05', '2017-10-05', 1),
(76, NULL, 'Land Improvement', 'expense', 12, '2017-10-05', '2017-10-05', 1),
(77, NULL, 'Building Purchase Expenses', 'expense', 12, '2017-10-05', '2017-10-05', 1),
(78, NULL, 'Building Improvement Expenses', 'expense', 12, '2017-10-05', '2017-10-05', 1),
(79, NULL, 'Machinery Purchase Expenses', 'expense', 13, '2017-10-05', '2017-10-05', 1),
(80, NULL, 'Plant Purchase Expenses', 'expense', 13, '2017-10-05', '2017-10-05', 1),
(81, NULL, 'Computer Expenses', 'expense', 14, '2017-10-05', '2017-10-05', 1),
(82, NULL, 'Software Expenses', 'expense', 15, '2017-10-05', '2017-10-05', 1),
(83, NULL, 'Table Purcahse Expenses', 'expense', 16, '2017-10-05', '2017-10-05', 1),
(84, NULL, 'Cabinet Purcahse Expenses', 'expense', 16, '2017-10-05', '2017-10-05', 1),
(85, NULL, 'Chair Purchase Expenses', 'expense', 16, '2017-10-05', '2017-10-05', 1),
(86, NULL, 'Car Purchases Expenses', 'expense', 17, '2017-10-05', '2017-10-05', 1),
(87, NULL, 'Bike Purchase Expenses', 'expense', 17, '2017-10-05', '2017-10-05', 1),
(88, NULL, 'Telephones purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(89, NULL, 'Router Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(90, NULL, 'Epbx System Purchase', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(91, NULL, 'Printer Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(92, NULL, 'Fax Machine Purchase expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(93, NULL, 'Video Projector Purchase expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(94, NULL, 'Photocopier Machine Purchase', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(95, NULL, 'Film Recorder Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(96, NULL, 'Refrijrator Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1);

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
(1, 'Zecg0vAydcYSboW8', '6mgDeRUMzDlhG8k3', '2017', '4', 1, '2017-10-04', '2017-10-04', '0'),
(2, 'OeMHdXAm7pHLzMZy', 'pyFhkAPiDxgUnTrX', '2017', '22', 1, '2017-10-04', '2017-10-04', '0');

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
  MODIFY `bankID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_clientProfile`
--
ALTER TABLE `acct_clientProfile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `acct_companies`
--
ALTER TABLE `acct_companies`
  MODIFY `companyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `creditorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `acct_debtors`
--
ALTER TABLE `acct_debtors`
  MODIFY `debtorID` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `inventoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_loans`
--
ALTER TABLE `acct_loans`
  MODIFY `loanID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_login`
--
ALTER TABLE `acct_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `acct_logs`
--
ALTER TABLE `acct_logs`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_products`
--
ALTER TABLE `acct_products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_transactionItems`
--
ALTER TABLE `acct_transactionItems`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_transactions`
--
ALTER TABLE `acct_transactions`
  MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_trialBalanceCategories`
--
ALTER TABLE `acct_trialBalanceCategories`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `acct_vats`
--
ALTER TABLE `acct_vats`
  MODIFY `vatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
