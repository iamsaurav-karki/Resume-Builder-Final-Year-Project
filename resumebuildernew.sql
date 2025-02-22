-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2025 at 06:35 PM
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
-- Database: `resumebuilder`
--

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE `educations` (
  `id` int(11) NOT NULL,
  `resume_id` int(11) NOT NULL,
  `course` varchar(250) NOT NULL,
  `institute` varchar(250) NOT NULL,
  `started` varchar(100) NOT NULL,
  `ended` date DEFAULT NULL,
  `currently_studying` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`id`, `resume_id`, `course`, `institute`, `started`, `ended`, `currently_studying`) VALUES
(27, 14, 'BIT', 'ASCOL', '2022-01-02', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` int(11) NOT NULL,
  `resume_id` int(11) NOT NULL,
  `position` varchar(250) NOT NULL,
  `company` varchar(250) NOT NULL,
  `job_desc` text NOT NULL,
  `started` date DEFAULT NULL,
  `ended` date DEFAULT NULL,
  `currently_working` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `resume_id`, `position`, `company`, `job_desc`, `started`, `ended`, `currently_working`) VALUES
(38, 14, 'QA', 'Ultrabyte International Pvt.Ltd', 'worked as a manual tester', '2016-05-11', '2019-01-23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `email_id` varchar(250) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `marital_status` varchar(30) NOT NULL,
  `hobbies` varchar(250) NOT NULL,
  `languages` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `objective` text NOT NULL,
  `slug` varchar(250) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `resume_title` varchar(250) NOT NULL,
  `background` varchar(250) NOT NULL DEFAULT '"',
  `font` varchar(250) NOT NULL DEFAULT '''Poppins'', sans-serif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resumes`
--

INSERT INTO `resumes` (`id`, `user_id`, `full_name`, `email_id`, `mobile_no`, `dob`, `gender`, `religion`, `nationality`, `marital_status`, `hobbies`, `languages`, `address`, `objective`, `slug`, `updated_at`, `resume_title`, `background`, `font`) VALUES
(14, 1, 'Gobinda Karkee', 'gobinda@gmail.com', '9812324354', '2003-01-05', 'Male', 'Hindu', 'Nepali', 'Married', 'Watching Sports', 'Nepali,English', 'lainchaur', 'Detail-oriented Quality Assurance Engineer with experience in manual and automated testing, dedicated to ensuring the highest quality of software products through thorough testing, bug detection, and performance analysis.', 'xPQH8KAs1DLYF4G5', '0000-00-00 00:00:00', 'Quality Assurance', 'tile8.png', '\'Mukta Mahee\'');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `resume_id` int(11) NOT NULL,
  `skill` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `resume_id`, `skill`) VALUES
(34, 14, 'Selenium'),
(35, 14, 'Cypress');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `email_id` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email_id`, `password`, `otp`, `otp_expiry`) VALUES
(1, 'saurav karki', 'sauravkarki102@gmail.com', '$2y$10$FNyE1fhfu1/RrJNXciVyTekx5QzUnIjwNp8K1q9T7O1OsDbQxgOMu', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resumes`
--
ALTER TABLE `resumes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `educations`
--
ALTER TABLE `educations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `resumes`
--
ALTER TABLE `resumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
