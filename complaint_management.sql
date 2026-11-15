-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2026 at 10:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `complaint_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$uBiEfK9Ybmgdg5BvGoBl9.mQO3NV.ikcE.sw53xaRZcf/cI2OG24W');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `complaint_no` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) DEFAULT 'General',
  `priority` enum('Low','Medium','High') DEFAULT 'Medium',
  `assigned_to` varchar(100) DEFAULT NULL,
  `admin_remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(30) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `complaint_no`, `name`, `email`, `user_id`, `subject`, `description`, `category`, `priority`, `assigned_to`, `admin_remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, NULL, NULL, NULL, 2, 'Internet Issue', 'WiFi is not working.', 'General', 'Medium', NULL, 'done ', '2026-08-07 09:39:37', '2026-08-12 12:43:11', 'Resolved'),
(2, NULL, NULL, NULL, 4, 'there is issue in a fan ', 'not working properly ', 'General', 'Medium', 'Khushboo', NULL, '2026-08-07 09:39:37', '2026-08-10 12:15:00', 'Pending'),
(3, 'CMP20260003', 'Khushboo', 'khushboo123@gmail.com', 4, 'Computer Not Working', 'very slow ', 'Technical', 'Medium', 'Khushboo', '', '2026-08-07 11:29:24', '2026-08-10 12:15:52', 'Pending'),
(4, 'CMP20260004', 'Test User ', 'testuser@gmail.com', 13, 'WiFi / Internet Issue', 'not working ', 'Technical', 'Medium', 'Not Assigned', '', '2026-08-11 09:37:55', '2026-08-11 09:37:55', 'Pending'),
(5, 'CMP20260005', 'Nihal', 'nihal123@gmail.com', 15, 'Email Problem', 'lacking ', 'Technical', 'High', 'Khushboo', 'done \r\n', '2026-08-11 10:19:59', '2026-08-11 10:34:32', 'Resolved'),
(6, 'CMP20260006', 'Test User ', 'testuser@gmail.com', 13, 'Computer Not Working', 'not working ', 'Technical', 'High', 'Khushboo', '', '2026-08-12 12:25:49', '2026-08-13 07:10:25', 'Pending'),
(7, 'CMP20260007', 'Test User ', 'testuser@gmail.com', 13, 'Network Issue', 'not working', 'Technical', 'Medium', 'Not Assigned', '', '2026-08-13 07:13:24', '2026-08-13 07:14:09', 'Resolved');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `department`, `password`, `created_at`) VALUES
(1, 'Khushboo', 'khushboo123@gmail.com', 'IT', '$2y$10$TUgCkbQUNdl7VeV0Hth3ROQbYOnKHQ1.BjIv5nHUzxYlr59XewS3G', '2026-08-07 11:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin123', 'admin'),
(2, 'Khushboo', 'khushboo@gmail.com', '12345', 'user'),
(4, 'Khushboo', 'khushboo123@gmail.com', '123456', 'user'),
(8, 'Nihal', 'khushboo1234@gmail.com', '1234567', 'user'),
(13, 'Test User ', 'testuser@gmail.com', '$2y$10$ipP/E2QooE1v70Hl3bKXl.2CvNyc/JNvOKT6dI35Vsj/yTlVPWhSq', 'user'),
(15, 'Nihal', 'nihal123@gmail.com', '$2y$10$tb3b0JV/sFcdzK4eGdni4OIAJKHSi51xA4aeR9VOEgEsBrWKTubva', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `complaint_no` (`complaint_no`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
