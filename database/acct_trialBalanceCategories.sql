-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 13, 2017 at 02:50 PM
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
(1, 'NVEiSZpleSya5G06', 'INVENTORY MANAGEMENT SYSTEM', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(2, 'ny79lTLzrIenwm8B', 'Discount/Commission', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(3, 'wlge2pPUC2WObeUp', 'General & Administrative', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(4, 'VktpB4bmEzSF3DUZ', 'Marketing & Promotional', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(5, 'h2v6V9eoD1Ng7q4a', 'Operating Expenses\r\n', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(6, '1mp5GKUZjvwkTZhr', 'Non Financial Cost', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(7, 'fRtLTMnyNjtuxUQ2', 'Motor Vehicle Expenses', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(8, 'ufpJZc020RLt13hW', 'Website Expenses', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(9, '8TfKAjQbFVtDREL3', 'Employment Expenses', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(10, 'ovFklz2C6n8Yv2sp', 'Occupancy Costs', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(11, 'eNIat1bmtFwcqM98', 'Finacial Cost', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(12, 'RtIJVnpDj6rFOvCn', 'Land or Buildings', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(13, 'V1ElTQx9yWIDH9OK', 'Plant & Equipment - General', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(14, '3YNMk0UB8uC93Hnx', 'Computer Equipment - Hardware', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(15, '69VU8ysla86V3ZS4', 'Computer Equipment - Software', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(16, '5TWs1JFKFWH3VvoZ', 'Furniture & Fixtures', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(17, 'YHKmAVaIEZ4HDLWG', 'Motor Vehicles', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(18, '7DQIbpM5mxlGaj5N', 'Office Equipment', 'expense', 0, '2017-10-05', '2017-10-05', 1),
(20, 'MsVfObrT4PI1QmGV', 'Purchase Return', 'expense', 1, '2017-10-05', '2017-10-05', 1),
(21, 'FUXcYlCpKlAp2yGq', 'Sales Return', 'expense', 1, '2017-10-05', '2017-10-05', 1),
(22, 'q5rYG6iDglQ0kaMp', 'Sales Discounts given', 'expense', 2, '2017-10-05', '2017-10-05', 1),
(23, 'ONdz9pjalp75rw8G', 'Sales Commissions paid', 'expense', 2, '2017-10-05', '2017-10-05', 1),
(24, 'lNR6XkSKjUR68quF', 'Bank charges', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(25, 'xNjUpX86geC5qOrh', 'Credit card commission', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(26, 'BXxs0mpFZianSTFN', 'Consultant fees', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(27, 'rZOAfNWESgIkb5cF', 'Office Supplies', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(28, 'k0rbXLtsedSBrGhn', 'License fees', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(29, 'NOU8TFKuuGxFUQtV', 'Business insurance', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(30, 'EQLawBeFtNWf5P6M', 'Audit Fees', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(31, 'TW8QEmB6oP1Bu70X', 'Afilation Fess', 'expense', 3, '2017-10-05', '2017-10-05', 1),
(32, 'Lsq2Om3nMFfcirAn', 'Advertising', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(33, 'erdkOLEvdkDZrfne', 'Promotion - General', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(34, 'cVt6ZWuJx2qA0C1w', 'Promotion - Other', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(35, 'FlzDOAB8jywzJCWd', 'Donations', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(36, 'rEIm9QDRS6MgjY0G', 'Prizes distribute', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(37, 'rL6ZfH1KNxbR7cDr', 'Free of Sample Goods', 'expense', 4, '2017-10-05', '2017-10-05', 1),
(38, 'uAXistaeEfOIAgBd', 'Newspapers & magazines', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(39, 'Z3bgwHFSeQdF5WA4', 'Parking/Taxis/Tolls', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(40, 'QWs0khyEYXdBQCib', 'Entertainment/Meals', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(41, 'CjcEPhF65shoZflb', 'Travel/Accomodation', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(42, 'UlFzDf4LpvqNcuHx', 'Laundry/dry cleaning', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(43, 'Bb21DslGkbirKmzy', 'Cleaning & cleaning products', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(44, 'iIBsGYyk9TcRagLQ', 'Sundry supplies', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(45, 'm1JThG3QpTrYmS4g', 'Equipment hire', 'expense', 5, '2017-10-05', '2017-10-05', 1),
(46, 'TW7s2mgUE06AIj2l', 'Depreciation', 'expense', 6, '2017-10-05', '2017-10-05', 1),
(47, 'MVCTpQaRYLIXzTHv', 'Bad Debts', 'expense', 6, '2017-10-05', '2017-10-05', 1),
(48, 'qOPwvGfsN0sS9TcJ', 'Fuel', 'expense', 7, '2017-10-05', '2017-10-05', 1),
(49, 'F2ThfVWQEu28g13G', 'Vehicle service costs', 'expense', 7, '2017-10-05', '2017-10-05', 1),
(50, 'LXwImrFDD30jvUVb', 'Tyres & other replacement costs', 'expense', 7, '2017-10-05', '2017-10-05', 1),
(51, 'QPqyFHCDAfUupRzg', 'Motors Insurance', 'expense', 7, '2017-10-05', '2017-10-05', 1),
(52, 'jDgLoQMUuH5cFMWl', 'Motor Registrations', 'expense', 7, '2017-10-05', '2017-10-05', 1),
(53, 'HVT4AU7Mo3eY9gFz', 'Domain name registration', 'expense', 8, '2017-10-05', '2017-10-05', 1),
(54, 'aF1B8xytrG1Weon4', 'Hosting expenses', 'expense', 8, '2017-10-05', '2017-10-05', 1),
(55, 'aXdzg2MEp4Sarzei', 'Salaries/Wages', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(56, 'KQyigjax1lgQo4Lp', 'PAYE', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(57, 'idZT6whPpgV6S7N3', 'Superannuation', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(58, 'xfAj0Jq2D4C1I7Fa', 'Other - Employee Benefits', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(59, 'qSMuzHtftDCixLro', 'Recruitment costs', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(60, 'wzdWlJmjAFvgdBUO', 'Workcover Insurance', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(61, 'QGJfTiptTdygD40W', 'Staff Training and Professional Development', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(62, 'Z1qgHrAERSbOaP6E', 'Staff Recruitment Expneses', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(63, '2xDbi30MbI5hfeFD', 'Staff welfare expenses', 'expense', 9, '2017-10-05', '2017-10-05', 1),
(64, 'SHAR9cDorlFYxoBX', 'Postage and Courier Cost', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(65, 'Rq43l5fIytV5oQ8p', 'Electricity/Gas', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(66, 'JvOhVkcEoErybBdG', 'Telephones', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(67, 'A73qZxyVDScbXt2Y', 'Property Insurance', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(68, 's1r3zh7QX4SQ3p7N', 'Rates', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(69, '92XnbOA0GUu7wDsX', 'Rent', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(70, 'vuJ65ZgBHRWsCGaO', 'Repair & maintenance', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(71, 'cdnQkuUa1pdlRnHE', 'Waste removal', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(72, 'qL6bRiwu7AbP1ySB', 'Water', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(73, 'U8KNZ7BOOPvVCZFd', 'Internet Expenses', 'expense', 10, '2017-10-05', '2017-10-05', 1),
(74, 'k1sGNBj2pVCRLfAx', 'Interest charges', 'expense', 11, '2017-10-05', '2017-10-05', 1),
(75, 'UYN4JcQ1WQ0FT7Ul', 'Land Purchased Expenses', 'expense', 12, '2017-10-05', '2017-10-05', 1),
(76, 'APhkMiHCNid8mMaG', 'Land Improvement', 'expense', 12, '2017-10-05', '2017-10-05', 1),
(77, '9FRN4VXEURWg9r3u', 'Building Purchase Expenses', 'expense', 12, '2017-10-05', '2017-10-05', 1),
(78, 'nRxKwe8Xtn8zAIh5', 'Building Improvement Expenses', 'expense', 12, '2017-10-05', '2017-10-05', 1),
(79, 'CAdH2us1yS4OcxRo', 'Machinery Purchase Expenses', 'expense', 13, '2017-10-05', '2017-10-05', 1),
(80, 'ginD7FdGKQpTXSB6', 'Plant Purchase Expenses', 'expense', 13, '2017-10-05', '2017-10-05', 1),
(81, 'haydNRH8V7JvKXg8', 'Computer Expenses', 'expense', 14, '2017-10-05', '2017-10-05', 1),
(82, '6l0RYP5fBsiDyW2S', 'Software Expenses', 'expense', 15, '2017-10-05', '2017-10-05', 1),
(83, '4DVAzriuuG032dkP', 'Table Purcahse Expenses', 'expense', 16, '2017-10-05', '2017-10-05', 1),
(84, 'bLiDUuMV4vZDwGeE', 'Cabinet Purcahse Expenses', 'expense', 16, '2017-10-05', '2017-10-05', 1),
(85, 'TNOlI8mKie9d1zqL', 'Chair Purchase Expenses', 'expense', 16, '2017-10-05', '2017-10-05', 1),
(86, 'mekytvHRPncUiG0b', 'Car Purchases Expenses', 'expense', 17, '2017-10-05', '2017-10-05', 1),
(87, 'eGSwuCibQjG8lkB9', 'Bike Purchase Expenses', 'expense', 17, '2017-10-05', '2017-10-05', 1),
(88, 'kPbVfONGCdNJp6uh', 'Telephones purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(89, 'k42KZru1JDgnLhxV', 'Router Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(90, 'BLMDYrbSbnIGH6Ql', 'Epbx System Purchase', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(91, 'o69SQ2v1G17bc2zt', 'Printer Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(92, 'BFkZvRDmKtP4jUfN', 'Fax Machine Purchase expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(93, '6zwMxV9PhgcXieSx', 'Video Projector Purchase expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(94, 'sn0B8ISWiTFHVJEu', 'Photocopier Machine Purchase', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(95, '8FMnGy0mrXA5qhyo', 'Film Recorder Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(96, 'jsKNoyd4vmrOzaS7', 'Refrijrator Purchase Expenses', 'expense', 18, '2017-10-05', '2017-10-05', 1),
(97, 'WndswSTqvFdalYMX', 'Sales', 'income', 0, '2017-10-05', '2017-10-05', 1),
(98, 'U92h8H3yP2EAxY8r', 'Sale of goods/services', 'income', 97, '2017-10-05', '2017-10-05', 1),
(99, '0kdhe3ZXxen4c7IW', 'Sundry Income', 'income', 97, '2017-10-05', '2017-10-05', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acct_trialBalanceCategories`
--
ALTER TABLE `acct_trialBalanceCategories`
  ADD PRIMARY KEY (`categoryID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acct_trialBalanceCategories`
--
ALTER TABLE `acct_trialBalanceCategories`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
