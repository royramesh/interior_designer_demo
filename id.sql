-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 09:21 AM
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
-- Database: `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(255) NOT NULL,
  `password` int(4) NOT NULL,
  `otp` int(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `password`, `otp`, `created_at`) VALUES
('ripl@gmail.com', 123456, 0, '2024-09-10 12:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `image_path`, `description`, `created_at`) VALUES
(2, 'Intorior', 'uploads/gallery/3028cc4cb16a2c571990bcf7b781684b.png', 'Burj Khalifa', '2024-09-10 04:25:28'),
(3, 'Intorior', 'uploads/gallery/dd72846d69f90c759fb51c50e1687462.png', 'Burj Khalifa', '2024-09-10 04:47:18'),
(4, 'Intorior', 'uploads/gallery/4ab48119b89bdc4fe2884c6109560f76.png', 'Burj Khalifa', '2024-09-10 04:48:00'),
(5, 'Intorior', 'uploads/gallery/e9cba1d8c82c5ff2c2b1a7f42938a8c4.png', 'Burj Khalifa', '2024-09-10 04:48:31'),
(6, 'Intorior', 'uploads/gallery/aac873858c961644959de8b4a16f4d73.png', 'Burj Khalifa', '2024-09-10 04:49:03'),
(7, 'Intorior', 'uploads/gallery/e74579193bd463e5ba5fe867d1940f64.png', 'Burj Khalifa', '2024-09-10 04:49:38');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `para1` text NOT NULL,
  `para2` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `image_path`, `para1`, `para2`) VALUES
(4, 'Lighting', 'uploads/services/d8b90d411535579a329b8c9da7d9e17e.png', 'For each project we establish', 'For each project we establish relationships with partners who we know will help us. '),
(5, 'Interior Design', 'uploads/services/d6f4f21bf1afde5ab4071ffe6ba26ae7.png', 'For each project we establish', 'For each project we establish relationships with partners who we know will help us. '),
(6, 'Office Decoretion', 'uploads/services/df1345cfef1c5b3e84878ff48e0b790f.png', 'For each project we establish', 'For each project we establish relationships with partners who we know will help us. '),
(7, 'Lighting', 'uploads/services/864a4d6706b1fd6e8dfca16c0470777e.png', 'For each project we establish', 'For each project we establish relationships with partners who we know will help us. '),
(8, 'Interior Design', 'uploads/services/d356cbf430660d59df1f208650e7741c.png', 'For each project we establish', 'For each project we establish relationships with partners who we know will help us. '),
(9, 'Office Decoretion', 'uploads/services/93a3ffc93ff185bdd58de7ae7e710902.png', 'For each project we establish', 'For each project we establish relationships with partners who we know will help us. ');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `alt_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `text`, `image_path`, `alt_text`) VALUES
(8, 'Modern Interior & Design', 'uploads/slider/c4db359bde927f1d87c0e934bff51c4a.jpg', 'Modern Interior & Design'),
(9, 'Modern Interior & Design', 'uploads/slider/66eed9d8e7fb6a760fc432c837ca7f20.png', 'Modern Interior & Design');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `position` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_of_join` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `photo_path`, `email`, `contact_number`, `position`, `date_of_birth`, `date_of_join`, `created_at`, `updated_at`) VALUES
(4, 'Prasun Kanti Roy', 'uploads/team/f0131a05c5918639f311bc9df4e0a192.png', 'royinformatics@gmail.com', '07428670132', 'Designer', '2024-09-04', '2024-09-19', '2024-09-09 09:38:31', '2024-09-09 09:38:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
