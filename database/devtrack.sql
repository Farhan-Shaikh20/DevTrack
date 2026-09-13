-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2026 at 07:12 PM
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
-- Database: `devtrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `creted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `user_id`, `company_name`, `phone`, `creted_at`) VALUES
(2, 8, 'attari tech', '7359020107', '2026-09-12 15:36:50'),
(3, 9, 'ahemad tech', '+919974356867', '2026-09-13 17:02:24'),
(4, 10, 'z-tech', '9624369406', '2026-09-13 17:03:57');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('planning','in progress','testing','completed') NOT NULL DEFAULT 'planning',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `client_id`, `project_name`, `description`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 2, 'abc - project', 'for testing', '2026-09-11', '2026-10-13', 'planning', '2026-09-12 15:39:25'),
(3, 3, 'hospital menegment system', 'manage all work info and data for hospital', '2026-09-01', '2026-09-15', 'testing', '2026-09-13 17:05:41'),
(4, 4, 'E- commerce web site', 'web site for new unique project with login page , nav bar and paymetn gateway , cart and poriduct list with advanced ui', '2026-09-07', '2026-09-14', 'completed', '2026-09-13 17:06:25'),
(5, 2, 'attaris fragrance website', 'web site for fragrances  personal online store', '2026-09-11', '0000-00-00', 'in progress', '2026-09-13 17:09:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','client') NOT NULL DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'is499321@gmai.com', '$2y$10$A9/smEN/7TvMctO.yJ6q7urB0oOvWBAqvoU3N8CPdMjb8AvqUqdO6', 'admin', '2026-09-10 10:13:37'),
(2, 'client1', 'client1@gmail.com', '$2y$10$/NqTTaiGAczCK5gS9NePr.ov6sRkb.37JNC/qnEy5.CfNfbQPlyIy', 'client', '2026-09-11 21:38:50'),
(8, 'farhan', 'farhan@gmail.com', '$2y$10$Infl8sjDbaYVmoiiGkWoXur8O0re2KdsnT4waqCf49aPbcZZf835W', 'client', '2026-09-12 15:36:50'),
(9, 'ahemad', 'ahemad@gmail.com', '$2y$10$.TYFaWCE3fEe0XauKxw.UubXGB/O8Hr/77OZ1.HYF0zN0DxJWoTKW', 'client', '2026-09-13 17:02:24'),
(10, 'zaid', 'zaid@gmail.com', '$2y$10$3NrwbKRMThAFyvvjTIDOXeaY.BaN1Z6BYohT4YKsMP6c84YS/BcK6', 'client', '2026-09-13 17:03:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

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
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
