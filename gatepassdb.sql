-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2024 at 07:00 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gatepassdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(50) NOT NULL,
  `department_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `department_desc`) VALUES
(1, 'BSIT', 'Bachelor of Science and Information Technology'),
(2, 'BSHM', 'Bachelor in Science and Hospitality Management'),
(4, 'BSBA', 'Bachelor in Science and Business Administration'),
(7, '123', '123'),
(11, 'dy', 'dfg');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_name` varchar(50) NOT NULL,
  `department_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_name`, `department_desc`) VALUES
('BSIT', 'Bachelor of Science and Information Technology'),
('BSIT', 'Bachelor of Science and Information Technology'),
('BSBA', 'Bachelor in Science and Business Administration');

-- --------------------------------------------------------

--
-- Table structure for table `entrance`
--

CREATE TABLE `entrance` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `rfid_number` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `time_in_am` varchar(100) NOT NULL,
  `time_out_am` varchar(100) NOT NULL,
  `date_logged` date NOT NULL,
  `time_in_pm` varchar(100) NOT NULL,
  `time_out_pm` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entrance`
--

INSERT INTO `entrance` (`id`, `photo`, `rfid_number`, `full_name`, `time_in_am`, `time_out_am`, `date_logged`, `time_in_pm`, `time_out_pm`, `role`, `department`, `status`) VALUES
(35, 'world cricket championship 3 apk - apkwarehouse.org (3).jpg', '0009668899', 'yOU yOU', '09:07', '09:07', '2024-07-12', '09:07', '09:07', 'Student', 'Humss', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_no` varchar(255) NOT NULL,
  `rfid_number` varchar(10) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `role` varchar(255) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `civil_status` varchar(10) NOT NULL,
  `contact_number` varchar(11) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `department` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `complete_address` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `place_of_birth` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_no`, `rfid_number`, `last_name`, `first_name`, `middle_name`, `date_of_birth`, `role`, `sex`, `civil_status`, `contact_number`, `email_address`, `department`, `section`, `status`, `complete_address`, `photo`, `place_of_birth`) VALUES
(4, '45', '4234234234', 'Your', 'ert', '', '2024-06-03', 'Student', 'Female', 'Married', '34532345453', 'ert@GMAIL.COM', 'Accounting', '', 'Inactive', '', 'world cricket championship 3 apk - apkwarehouse.org (3).jpg', ''),
(6, 'ertert', '2342524232', 'we', 'ewrt', 'ert', '2024-06-03', 'ert', 'Male', 'Single', '23425264366', '', '', 'Einstein', 'Block', '', 'Hazelnut Latte - nsfw-games.com.png', ''),
(8, '2131243453', '3242434234', 'Ungon', 'Kyebe Jean', 'Maciar', '2024-05-30', 'Visitor', 'Female', 'Single', '23423556666', 'wer@gmail.com', 'mis', 'South', 'Active', 'aerdsr', '', 'talangnan'),
(10, '', '1231', '', '', '', '0000-00-00', '', '', '', '', '', '', '', 'Active', '', 'IPOO.png', ''),
(14, '322222', '2342342334', 'wer', 'erw', 'wer', '2024-06-17', 'Instructor', 'Female', 'Widowed', '65452342333', '', 'Humss', '', 'Active', 'dsfdfs', '', 'wertw'),
(15, '34665', '3344555333', 'wet', 'ert', 'df', '2024-05-27', 'Student', 'Female', 'Single', '', '', 'Accounting', '', 'Active', 'drwert', 'apex racer apk download.jpg', 'fffg'),
(20, '34q', '', 'eara', 'wad', 'ewsrsdrf', '2024-07-04', 'Student', 'Female', 'Single', '35246234633', 'aeras@gmail.com', 'Humss', '', 'Active', 'asdS', 'world cricket championship 3 apk download.png', 'werwet'),
(21, 'SETAERA', '', 'yOU', 'yOU', 'yOU', '2024-07-18', 'Instructor', 'Male', 'Widowed', '23423523554', 'yOU@gmail.com', 'Accounting', '', 'Active', 'afas', 'world cricket championship 3 apk - apkwarehouse.org (1).jpg', 'yOU'),
(22, '3452452', '0009668899', 'yOU', 'yOU', 'yOU', '2024-07-04', 'Student', 'Male', 'Married', '23423423444', 'yOU@gmail.com', 'Humss', '', 'Active', 'fsf', 'world cricket championship 3 apk - apkwarehouse.org (3).jpg', 'yOU');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `entrance`
--
ALTER TABLE `entrance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `entrance`
--
ALTER TABLE `entrance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
