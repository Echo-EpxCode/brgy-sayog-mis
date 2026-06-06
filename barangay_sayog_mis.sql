-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2026 at 10:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barangay_sayog_mis`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activity` text NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `reference_table` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `posted_by` int(11) DEFAULT NULL,
  `status` enum('Draft','Published') DEFAULT 'Published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `posted_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'NO CEDULA ON THRURDAY', 'HI', 1, 'Published', '2026-06-06 20:04:09', '2026-06-06 20:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `certificate_no` varchar(100) NOT NULL,
  `issued_date` date NOT NULL,
  `issued_by` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `request_id`, `certificate_no`, `issued_date`, `issued_by`, `file_path`, `created_at`) VALUES
(14, 5, 'BRGY-2026-A82141', '2026-06-07', 1, '../../assets/uploads/certificates/CERT-BRGY-2026-A82141.pdf', '2026-06-06 17:48:17'),
(15, 6, 'BRGY-2026-C8BBDF', '2026-06-07', 1, NULL, '2026-06-06 21:57:37'),
(16, 7, 'BRGY-2026-C194AF', '2026-06-07', 1, NULL, '2026-06-06 21:58:09'),
(17, 4, 'BRGY-2026-496FA1', '2026-06-07', 1, NULL, '2026-06-06 22:02:38');

-- --------------------------------------------------------

--
-- Table structure for table `document_requests`
--

CREATE TABLE `document_requests` (
  `id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `purpose` text NOT NULL,
  `status` enum('Pending','Approved','Rejected','Released') NOT NULL DEFAULT 'Pending',
  `remarks` text DEFAULT NULL,
  `requested_at` datetime DEFAULT current_timestamp(),
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `released_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_requests`
--

INSERT INTO `document_requests` (`id`, `resident_id`, `document_type_id`, `purpose`, `status`, `remarks`, `requested_at`, `approved_by`, `approved_at`, `released_at`, `created_at`) VALUES
(1, 1, 1, 'For employment requirement', 'Released', NULL, '2026-06-04 09:52:55', NULL, '2026-06-04 09:52:55', '2026-06-04 09:52:55', '2026-06-04 01:52:55'),
(2, 2, 2, 'For school requirement', 'Released', NULL, '2026-06-04 09:52:55', NULL, '2026-06-04 09:52:55', '2026-06-04 09:52:55', '2026-06-04 01:52:55'),
(3, 3, 3, 'For legal requirement', 'Pending', NULL, '2026-06-04 09:52:55', NULL, '2026-06-04 09:52:55', '2026-06-04 09:52:55', '2026-06-04 01:52:55'),
(4, 5, 2, 'Dragon ball', 'Released', NULL, '2026-06-07 01:23:49', 1, '2026-06-07 06:02:28', '2026-06-07 06:02:38', '2026-06-06 17:23:49'),
(5, 5, 2, 'sa', 'Released', NULL, '2026-06-07 01:29:03', 1, '2026-06-07 01:47:42', '2026-06-07 01:48:17', '2026-06-06 17:29:03'),
(6, 5, 3, 'for schoolar', 'Released', NULL, '2026-06-07 04:47:41', 1, '2026-06-07 06:12:09', '2026-06-07 06:12:21', '2026-06-06 20:47:41'),
(7, 5, 1, 'wala lang', 'Released', NULL, '2026-06-07 04:58:26', 1, '2026-06-07 05:57:44', '2026-06-07 05:58:09', '2026-06-06 20:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` int(11) NOT NULL,
  `document_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `document_name`, `description`, `created_at`) VALUES
(1, 'Barangay Clearance', NULL, '2026-06-01 04:04:41'),
(2, 'Cedula', NULL, '2026-06-01 04:04:41'),
(3, 'Certificate of Indigency', NULL, '2026-06-01 04:04:41');

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `household_no` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `birth_date` date NOT NULL,
  `civil_status` varchar(50) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `address` text NOT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `citizenship` varchar(100) DEFAULT 'Filipino',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `user_id`, `household_no`, `first_name`, `middle_name`, `last_name`, `suffix`, `gender`, `birth_date`, `civil_status`, `contact_no`, `address`, `occupation`, `citizenship`, `created_at`, `updated_at`) VALUES
(1, 1, 'HH-1001', 'Juan', 'Santos', 'Dela Cruz', '', 'Male', '1995-05-10', 'Single', '09123456789', 'Purok 12', 'Farmer', 'Filipino', '2026-06-04 01:39:17', '2026-06-04 01:39:57'),
(2, 2, 'HH-1002', 'Maria', 'Lopez', 'Santos', '', 'Female', '1992-11-20', 'Married', '09987654321', 'Purok 2', 'Teacher', 'Filipino', '2026-06-04 01:39:17', '2026-06-04 01:39:17'),
(3, 3, 'HH-1003', 'Pedro', 'Garcia', 'Reyes', '', 'Male', '1990-03-15', 'Single', '09111222333', 'Purok 3', 'Driver', 'Filipino', '2026-06-04 01:39:17', '2026-06-04 01:39:17'),
(4, 4, 'HH-0000', 'Admin', '', 'User', '', 'Male', '1990-01-01', 'Single', '09000000000', 'Barangay Hall', 'Officer', 'Filipino', '2026-06-04 01:39:17', '2026-06-04 01:39:17'),
(5, 6, '5556', 'Jonefer', 'Nano', 'Codillo', NULL, 'Male', '0000-00-00', 'Filipino', '09123456789', 'Purok 1 lgaeas, deads lagaw3e', 'None', 'Filipino', '2026-06-06 17:14:57', '2026-06-06 20:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('secretary','resident') NOT NULL DEFAULT 'resident',
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password_hash`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Barangay Secretary', 'admin@barangaysayog.com', '$2y$12$afjVQA2Sa1/e93t.sYgeUuc4cAAgb8/U9mGHX8oPxtb7q26JFIWCu', 'secretary', 'approved', '2026-06-01 04:04:41', '2026-06-01 04:04:41'),
(2, 'Juan Dela Cruz', 'juan@example.com', '$2y$10$w0pQ9c2Yq7u3cVbqvQxq9eVZq8kJ3bX1QmQZQvQvQvQvQvQvQvQvQ', 'resident', 'approved', '2026-06-04 01:39:02', '2026-06-06 22:03:14'),
(3, 'Maria Santos', 'maria@example.com', '$2y$10$w0pQ9c2Yq7u3cVbqvQxq9eVZq8kJ3bX1QmQZQvQvQvQvQvQvQvQvQ', 'resident', 'approved', '2026-06-04 01:39:02', '2026-06-04 01:39:02'),
(4, 'Pedro Reyes', 'pedro@example.com', '$2y$10$w0pQ9c2Yq7u3cVbqvQxq9eVZq8kJ3bX1QmQZQvQvQvQvQvQvQvQvQ', 'resident', 'rejected', '2026-06-04 01:39:02', '2026-06-04 01:39:02'),
(5, 'Barangay Secretary', 'admin@barangay.gov', '$2y$10$w0pQ9c2Yq7u3cVbqvQxq9eVZq8kJ3bX1QmQZQvQvQvQvQvQvQvQvQ', 'secretary', 'approved', '2026-06-04 01:39:02', '2026-06-04 01:39:02'),
(6, 'Jonefer Nano Codillo', 'codillojonefer45@gmail.com', '$2y$12$6cvhE3019K6FVvOfR/Uj9ujV/ZSub340tH6aIm2IUMhrVgHLQcwQS', 'resident', 'approved', '2026-06-06 17:14:57', '2026-06-06 17:15:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_activity_user` (`user_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_announcement_user` (`posted_by`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_no` (`certificate_no`),
  ADD KEY `fk_certificate_request` (`request_id`),
  ADD KEY `fk_certificate_user` (`issued_by`);

--
-- Indexes for table `document_requests`
--
ALTER TABLE `document_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_request_resident` (`resident_id`),
  ADD KEY `fk_request_document` (`document_type_id`),
  ADD KEY `fk_request_approver` (`approved_by`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_resident_user` (`user_id`);

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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `document_requests`
--
ALTER TABLE `document_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `fk_activity_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `fk_announcement_user` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `fk_certificate_request` FOREIGN KEY (`request_id`) REFERENCES `document_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_certificate_user` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `document_requests`
--
ALTER TABLE `document_requests`
  ADD CONSTRAINT `fk_request_approver` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_request_document` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_request_resident` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `residents`
--
ALTER TABLE `residents`
  ADD CONSTRAINT `fk_resident_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
