-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 06:32 PM
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
  `ended` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`id`, `resume_id`, `course`, `institute`, `started`, `ended`) VALUES
(1, 1, 'BIT ', 'Amrit campus', 'june 2021', 'currently studying'),
(2, 2, 'BIT ', 'Amrit campus', 'june 2021', 'currently studying'),
(3, 3, 'BIT ', 'Amrit campus', 'june 2021', 'currently studying'),
(4, 4, 'BIT ', 'Amrit campus', 'june 2021', 'currently studying');

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
  `started` varchar(250) NOT NULL,
  `ended` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `resume_id`, `position`, `company`, `job_desc`, `started`, `ended`) VALUES
(1, 1, 'Front end developer', 'f1-soft', 'this is job description', 'july 2023', 'june 04 2024'),
(2, 1, 'web designer', 'bajara technologies', 'this is job description', 'july 2022', 'currently working'),
(3, 2, 'Front end developer', 'f1-soft', 'this is job description', 'july 2023', 'june 04 2024'),
(4, 2, 'web designer', 'bajara technologies', 'this is job description', 'july 2022', 'currently working'),
(5, 3, 'Front end developer', 'f1-soft', 'this is job description', 'july 2023', 'june 04 2024'),
(6, 3, 'web designer', 'bajara technologies', 'this is job description', 'july 2022', 'currently working'),
(7, 4, 'Front end developer', 'f1-soft', 'this is job description', 'july 2023', 'june 04 2024'),
(8, 4, 'web designer', 'bajara technologies', 'this is job description', 'july 2022', 'currently working');

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
  `updated_at` int(20) NOT NULL,
  `resume_title` varchar(250) NOT NULL,
  `background` varchar(250) NOT NULL DEFAULT '"',
  `font` varchar(250) NOT NULL DEFAULT '''Poppins'', sans-serif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resumes`
--

INSERT INTO `resumes` (`id`, `user_id`, `full_name`, `email_id`, `mobile_no`, `dob`, `gender`, `religion`, `nationality`, `marital_status`, `hobbies`, `languages`, `address`, `objective`, `slug`, `updated_at`, `resume_title`, `background`, `font`) VALUES
(1, 1, 'laxman shingh dhami', 'laxman@gmail.com', '9898989898', '2000-04-03', 'Male', 'Hindu', 'Nepali', 'Married', 'Reading books', 'Nepali, English', 'bhaktapur', '- this is objective', 'S7W7kZ2q54xg1VMD', 1733156800, 'Web Developer', 'tile10.png', '\'Mukta Mahee\''),
(2, 1, 'laxman shingh dhami', 'laxman@gmail.com', '9898989898', '2000-04-03', 'Male', 'Hindu', 'Nepali', 'Married', 'Reading books', 'Nepali, English', 'bhaktapur', '- this is objective', '5KsA93mC1Q7G734B', 1733156939, 'Backend Developer', 'tile10.png', '\'Mukta Mahee\''),
(3, 1, 'laxman shingh dhami', 'laxman@gmail.com', '9898989898', '2000-04-03', 'Male', 'Hindu', 'Nepali', 'Married', 'Reading books', 'Nepali, English', 'bhaktapur', '- this is objective', '2oPTveQt1um6arS5', 1733156945, 'Web Developer clone_1733156945', 'tile10.png', '\'Mukta Mahee\''),
(4, 1, 'laxman shingh dhami', 'laxman@gmail.com', '9898989898', '2000-04-03', 'Male', 'Hindu', 'Nepali', 'Married', 'Reading books', 'Nepali, English', 'bhaktapur', '- this is objective', 'E349n46vp1mxWtUf', 1733156948, 'Web Developer clone_1733156948', 'tile10.png', '\'Mukta Mahee\'');

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
(1, 1, 'html , css , js'),
(2, 1, 'React , node , express'),
(3, 1, 'figma, adobe xd'),
(4, 2, 'html , css , js'),
(5, 2, 'React , node , express'),
(6, 2, 'figma, adobe xd'),
(7, 3, 'html , css , js'),
(8, 3, 'React , node , express'),
(9, 3, 'figma, adobe xd'),
(10, 4, 'html , css , js'),
(11, 4, 'React , node , express'),
(12, 4, 'figma, adobe xd');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `email_id` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email_id`, `password`) VALUES
(1, 'saurav karki', 'karkisaurav2711@gmail.com', 'cafe8c205b216d181372b253fe095a21');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `resumes`
--
ALTER TABLE `resumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
