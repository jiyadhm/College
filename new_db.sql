-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2017 at 10:21 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_db`
--
CREATE DATABASE IF NOT EXISTS `new_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `new_db`;

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `batch_id` int(11) NOT NULL,
  `course` tinyint(4) NOT NULL,
  `yearofpassing` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batch_id`, `course`, `yearofpassing`) VALUES
(2, 1, 2018),
(1, 2, 2018),
(3, 3, 2018);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` tinyint(4) NOT NULL,
  `dept` tinyint(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `coursetype` varchar(20) NOT NULL,
  `duration` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `dept`, `name`, `coursetype`, `duration`) VALUES
(1, 1, 'Computer Science and Engineering', 'B.Tech', 4),
(2, 2, 'Civil Engineering', 'B.Tech', 4),
(3, 3, 'Mechanical Engineering', 'B.Tech', 4);

-- --------------------------------------------------------

--
-- Table structure for table `dept`
--

CREATE TABLE `dept` (
  `dep_id` tinyint(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `shortname` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dept`
--

INSERT INTO `dept` (`dep_id`, `name`, `shortname`) VALUES
(0, 'Rajiv Gandhi Institute of Technology,Kottayam', '0'),
(1, 'Computer Science and Engineering', 'cse'),
(2, 'Civil Engineering', 'ce'),
(3, 'Mechanical Engineering', 'me');

-- --------------------------------------------------------

--
-- Table structure for table `family_details`
--

CREATE TABLE `family_details` (
  `id` int(11) NOT NULL,
  `name` varchar(35) NOT NULL,
  `occupation` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `mob` bigint(11) NOT NULL,
  `income` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` tinyint(4) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL,
  `acc_type` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `username`, `password`, `acc_type`) VALUES
(1, 'admin', '63a9f0ea7bb98050796b649e85481845', 3),
(2, 'staff1', '1253208465b1efa876f982d8a9e73eef', 2),
(3, '14BR10214', '2d6de75c827ab3064c5c31388cae856f', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prev_academ`
--

CREATE TABLE `prev_academ` (
  `id` int(11) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `coursetype` varchar(10) NOT NULL,
  `yearofpassing` int(4) NOT NULL,
  `institute` varchar(50) NOT NULL,
  `board_university` varchar(40) NOT NULL,
  `marks_scored` int(11) NOT NULL,
  `marks_max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stu_base`
--

CREATE TABLE `stu_base` (
  `id` int(11) NOT NULL,
  `admn_no` varchar(20) NOT NULL,
  `batch` int(11) NOT NULL,
  `dojoin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stu_base`
--

INSERT INTO `stu_base` (`id`, `admn_no`, `batch`, `dojoin`) VALUES
(1, '14BR10214', 2, '2017-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `stu_details`
--

CREATE TABLE `stu_details` (
  `id` int(11) NOT NULL,
  `name` varchar(35) NOT NULL,
  `dob` date NOT NULL,
  `category` varchar(7) NOT NULL,
  `relegion` varchar(20) DEFAULT NULL,
  `caste` varchar(20) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL,
  `mob` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stu_family`
--

CREATE TABLE `stu_family` (
  `id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL,
  `lg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stu_marks`
--

CREATE TABLE `stu_marks` (
  `stu_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `marks_sessional` int(11) NOT NULL,
  `marks_chance1` int(11) DEFAULT NULL,
  `marks_chance2` int(11) DEFAULT NULL,
  `marks_chance3` int(11) DEFAULT NULL,
  `marks_chance4` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sub_info`
--

CREATE TABLE `sub_info` (
  `sub_id` int(11) NOT NULL,
  `sub_code` varchar(10) NOT NULL,
  `name` varchar(40) NOT NULL,
  `course` tinyint(4) NOT NULL,
  `semester` int(11) NOT NULL,
  `marks_max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batch_id`),
  ADD UNIQUE KEY `course` (`course`,`yearofpassing`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `dept` (`dept`,`name`,`coursetype`);

--
-- Indexes for table `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`dep_id`),
  ADD UNIQUE KEY `shortname` (`shortname`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `family_details`
--
ALTER TABLE `family_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `prev_academ`
--
ALTER TABLE `prev_academ`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stu_base`
--
ALTER TABLE `stu_base`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admn_no` (`admn_no`);

--
-- Indexes for table `stu_details`
--
ALTER TABLE `stu_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stu_family`
--
ALTER TABLE `stu_family`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stu_marks`
--
ALTER TABLE `stu_marks`
  ADD PRIMARY KEY (`stu_id`,`sub_id`);

--
-- Indexes for table `sub_info`
--
ALTER TABLE `sub_info`
  ADD PRIMARY KEY (`sub_id`),
  ADD UNIQUE KEY `sub_code` (`sub_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `dept`
--
ALTER TABLE `dept`
  MODIFY `dep_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `prev_academ`
--
ALTER TABLE `prev_academ`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stu_base`
--
ALTER TABLE `stu_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sub_info`
--
ALTER TABLE `sub_info`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `stu_details`
--
ALTER TABLE `stu_details`
  ADD CONSTRAINT `stu_details_ibfk_1` FOREIGN KEY (`id`) REFERENCES `stu_base` (`id`);

--
-- Constraints for table `stu_family`
--
ALTER TABLE `stu_family`
  ADD CONSTRAINT `stu_family_ibfk_1` FOREIGN KEY (`id`) REFERENCES `stu_base` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
