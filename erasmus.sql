-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2025 at 12:59 PM
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
-- Database: `erasmus`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) DEFAULT NULL,
  `id_code` varchar(100) DEFAULT NULL,
  `credits` int(11) DEFAULT NULL,
  `max_capacity` int(11) DEFAULT NULL,
  `availability_datetime` datetime DEFAULT NULL,
  `availability_dateendtime` datetime DEFAULT NULL,
  `study_programme` enum('bFBI','bEMa','iAE','iFD','iMOM','iGM','iHD','Selectable_Class') NOT NULL,
  `degree_of_education` enum('1. degree','2. degree') NOT NULL DEFAULT '1. degree'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `id_code`, `credits`, `max_capacity`, `availability_datetime`, `availability_dateendtime`, `study_programme`, `degree_of_education`) VALUES
(5, 'Economy of Developing Countries (in English)', 'KMEVaHD FMV/VVA22021/22', 4, 15, '0000-00-00 00:00:00', '2024-05-11 00:09:00', 'iMOM', '2. degree'),
(6, 'Monetary Theory and Policy', 'NNC21053/21', 6, 20, '2024-05-09 00:20:00', '2024-05-11 00:20:00', 'bFBI', '1. degree'),
(7, 'Efficiency and Productivity Analysis', 'NND21251/21', 6, 20, '2024-05-09 00:20:00', '2024-05-11 00:20:00', 'iAE', '1. degree'),
(8, 'Business marketing (in English)', 'KMr OF/OOA21219/21', 5, 15, '2024-05-09 00:21:00', '2024-05-11 00:21:00', 'iMOM', '1. degree');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `enrollment_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `user_id`, `class_id`, `enrollment_date`) VALUES
(6, 2, 6, '2024-05-09'),
(7, 2, 8, '2024-05-09'),
(9, 3, 6, '2024-05-09'),
(10, 3, 7, '2024-05-09'),
(11, 3, 8, '2024-05-09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `role` varchar(100) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `school`, `role`) VALUES
(1, 'Tibor Racz', 'admin@test.com', '$2y$10$Eq5UGYx8.AtnkKOpwoVbP.TE48ztps0fQXPZ5.2iSUqjT7ae711v2', 'EUBA', 'admin'),
(2, 'user1', 'user1@gmail.com', '$2y$10$.1m5otdYLvwNRxvY/USOje6ipIKiL/ic3iDpm2I11h6bmsskDKbg.', 'EUBA', 'user'),
(3, 'user2', 'user2@gmail.com', '$2y$10$lMsp25Cjdb1lF42kfLT9ouMucri05qvuzPibABlx6oRQAkID7Bb/C', 'EUBA', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
