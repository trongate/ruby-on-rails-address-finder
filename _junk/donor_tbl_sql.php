-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 13, 2019 at 10:05 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `trongate_framework_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `id` int(11) NOT NULL,
  `url_string` varchar(255) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `introduction` text NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `date_of_birth` int(11) NOT NULL,
  `next_appointment` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`id`, `url_string`, `first_name`, `email`, `introduction`, `price`, `date_of_birth`, `next_appointment`, `active`) VALUES
(1, 'asdfasdf', 'David', 'david@bla.com', 'Here we go.', '88.00', 1598345434, 1698345434, 0),
(2, 'asdfasdfsdf', 'Second Item', 'info@something.com', 'Here is an introduction.', '88.00', 1534234435, 1634234435, 1),
(3, '', 'asdfasdfsd', 'dadsf@asdf.com', 'asdfasdf', '88.00', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
