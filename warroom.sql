-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2014 at 06:11 PM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `warroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `city_target`
--

CREATE TABLE IF NOT EXISTS `city_target` (
  `city_id` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`city_id`),
  UNIQUE KEY `city_id` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city_target`
--

INSERT INTO `city_target` (`city_id`, `target`, `start_date`, `end_date`) VALUES
(1, 200000, '2014-01-01', '2014-01-31'),
(2, 200000, '2014-01-01', '2014-01-31'),
(3, 200000, '2014-01-01', '2014-01-31'),
(4, 200000, '2014-01-01', '2014-01-31'),
(5, 200000, '2014-01-01', '2014-01-31'),
(6, 200000, '2014-01-01', '2014-01-31'),
(7, 200000, '2014-01-01', '2014-01-31');

-- --------------------------------------------------------

--
-- Table structure for table `conversation`
--

CREATE TABLE IF NOT EXISTS `conversation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=140 ;

--
-- Dumping data for table `conversation`
--

INSERT INTO `conversation` (`id`, `user_id`, `created_at`) VALUES
(2, 1, '2014-01-01 13:21:53'),
(3, 1, '2014-01-15 13:36:21'),
(4, 1, '2014-01-15 13:36:56'),
(5, 1, '2014-01-15 13:39:22'),
(6, 1, '2014-01-15 13:39:54'),
(7, 1, '2014-01-15 13:40:26'),
(8, 1, '2014-01-15 13:40:52'),
(9, 1, '2014-01-15 13:42:23'),
(10, 1, '2014-01-15 13:42:37'),
(11, 1, '2014-01-15 13:42:38'),
(12, 1, '2014-01-15 13:42:46'),
(13, 1, '2014-01-15 13:45:36'),
(14, 1, '2014-01-15 13:47:18'),
(15, 1, '2014-01-15 13:47:51'),
(16, 1, '2014-01-15 13:48:10'),
(17, 1, '2014-01-15 14:24:51'),
(18, 1, '2014-01-15 14:29:12'),
(19, 1, '2014-01-15 14:29:18'),
(20, 1, '2014-01-15 14:29:42'),
(21, 1, '2014-01-15 14:30:03'),
(22, 1, '2014-01-15 14:30:34'),
(23, 1, '2014-01-15 14:30:55'),
(24, 1, '2014-01-15 14:31:25'),
(25, 1, '2014-01-15 14:31:56'),
(26, 1, '2014-01-15 14:32:19'),
(27, 1, '2014-01-15 14:32:45'),
(28, 1, '2014-01-15 14:33:00'),
(29, 1, '2014-01-15 14:33:01'),
(30, 1, '2014-01-15 14:33:55'),
(31, 1, '2014-01-15 14:34:30'),
(32, 1, '2014-01-15 14:34:45'),
(33, 1, '2014-01-15 14:34:54'),
(34, 1, '2014-01-15 14:35:05'),
(35, 1, '2014-01-15 14:36:54'),
(36, 1, '2014-01-15 14:37:32'),
(37, 1, '2014-01-15 14:37:59'),
(38, 1, '2014-01-15 14:38:55'),
(39, 1, '2014-01-15 14:53:09'),
(40, 1, '2014-01-15 14:53:36'),
(41, 1, '2014-01-15 14:54:19'),
(42, 1, '2014-01-15 14:55:09'),
(43, 1, '2014-01-15 14:55:52'),
(44, 1, '2014-01-15 14:56:23'),
(45, 1, '2014-01-15 14:56:26'),
(46, 1, '2014-01-15 14:57:04'),
(47, 1, '2014-01-15 14:57:38'),
(48, 1, '2014-01-15 14:57:41'),
(49, 1, '2014-01-15 14:57:50'),
(50, 1, '2014-01-15 14:57:59'),
(51, 1, '2014-01-15 14:58:24'),
(52, 1, '2014-01-15 14:58:30'),
(53, 1, '2014-01-15 14:58:31'),
(54, 1, '2014-01-15 14:58:33'),
(55, 1, '2014-01-15 14:58:35'),
(56, 1, '2014-01-15 14:58:36'),
(57, 1, '2014-01-15 14:58:38'),
(58, 1, '2014-01-15 15:00:33'),
(59, 1, '2014-01-15 15:00:35'),
(60, 1, '2014-01-15 15:00:37'),
(61, 1, '2014-01-15 15:00:39'),
(62, 1, '2014-01-15 15:00:41'),
(63, 1, '2014-01-15 15:00:45'),
(64, 1, '2014-01-15 15:00:56'),
(65, 1, '2014-01-15 15:05:35'),
(66, 1, '2014-01-15 15:11:40'),
(67, 1, '2014-01-15 15:17:18'),
(68, 1, '2014-01-15 15:18:05'),
(69, 1, '2014-01-15 15:18:54'),
(70, 1, '2014-01-15 15:18:57'),
(71, 1, '2014-01-15 15:18:59'),
(72, 1, '2014-01-15 15:19:00'),
(73, 1, '2014-01-15 15:19:01'),
(74, 1, '2014-01-15 15:19:02'),
(75, 1, '2014-01-15 15:19:04'),
(76, 1, '2014-01-15 15:19:05'),
(77, 1, '2014-01-15 15:21:07'),
(78, 1, '2014-01-15 15:24:46'),
(79, 1, '2014-01-15 15:34:48'),
(80, 1, '2014-01-15 15:34:56'),
(81, 1, '2014-01-15 16:05:33'),
(82, 1, '2014-01-15 16:09:03'),
(83, 1, '2014-01-15 16:09:21'),
(84, 1, '2014-01-15 16:40:08'),
(85, 1, '2014-01-15 17:13:03'),
(86, 1, '2014-01-15 17:36:12'),
(87, 1, '2014-01-15 17:36:14'),
(88, 1, '2014-01-15 17:41:21'),
(89, 1, '2014-01-15 18:49:33'),
(90, 1, '2014-01-15 19:57:54'),
(91, 1, '2014-01-15 19:59:17'),
(92, 1, '2014-01-15 20:30:06'),
(93, 1, '2014-01-15 20:30:19'),
(94, 1, '2014-01-15 20:30:24'),
(95, 1, '2014-01-15 20:30:30'),
(96, 1, '2014-01-15 20:30:36'),
(97, 1, '2014-01-15 20:38:40'),
(98, 1, '2014-01-15 20:42:41'),
(99, 1, '2014-01-15 23:12:17'),
(100, 1, '2014-01-15 23:12:19'),
(101, 1, '2014-01-15 23:12:20'),
(102, 1, '2014-01-15 23:12:22'),
(103, 1, '2014-01-15 23:12:24'),
(104, 1, '2014-01-15 23:12:25'),
(105, 1, '2014-01-15 23:12:27'),
(106, 1, '2014-01-16 00:11:46'),
(107, 1, '2014-01-16 00:14:59'),
(108, 1, '2014-01-16 00:15:01'),
(109, 1, '2014-01-16 00:15:28'),
(110, 1, '2014-01-16 00:15:34'),
(111, 1, '2014-01-16 01:01:38'),
(112, 1, '2014-01-16 15:20:37'),
(113, 1, '2014-01-16 15:20:41'),
(114, 1, '2014-01-16 19:53:19'),
(115, 1, '2014-01-16 19:54:07'),
(116, 1, '2014-01-16 22:33:38'),
(117, 1, '2014-01-16 22:33:41'),
(118, 1, '2014-01-17 12:42:49'),
(119, 1, '2014-01-17 12:54:53'),
(120, 1, '2014-01-17 17:46:26'),
(121, 1, '2014-01-17 17:46:27'),
(122, 1, '2014-01-21 17:08:20'),
(123, 1, '2014-01-21 20:49:59'),
(124, 1, '2014-01-21 20:50:01'),
(125, 1, '2014-01-21 21:02:02'),
(126, 1, '2014-01-21 21:02:45'),
(127, 1, '2014-01-21 21:14:21'),
(128, 1, '2014-01-21 21:14:23'),
(129, 1, '2014-01-21 21:14:25'),
(130, 1, '2014-01-21 21:14:43'),
(131, 1, '2014-01-23 13:27:30'),
(132, 1, '2014-01-23 13:27:32'),
(133, 1, '2014-01-23 13:27:34'),
(134, 1, '2014-01-23 13:27:36'),
(135, 1, '2014-01-23 13:27:38'),
(136, 1, '2014-01-23 13:27:46'),
(137, 1, '2014-01-23 13:27:51'),
(138, 1, '2014-01-23 13:27:59'),
(139, 1, '2014-01-23 20:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_01_17_141301_create_user_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `money_pledged`
--

CREATE TABLE IF NOT EXISTS `money_pledged` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pledged_amount` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `money_pledged`
--

INSERT INTO `money_pledged` (`id`, `user_id`, `pledged_amount`, `created_at`) VALUES
(1, 1, 0, '2014-01-15 15:07:33'),
(2, 1, 0, '2014-01-15 15:09:00'),
(3, 1, 0, '2014-01-15 15:10:00'),
(4, 1, 0, '2014-01-15 15:10:33'),
(5, 1, 0, '2014-01-15 15:11:33'),
(6, 1, 0, '2014-01-15 15:11:35'),
(7, 1, 0, '2014-01-15 15:11:37'),
(8, 1, 0, '2014-01-15 15:34:50'),
(9, 1, 0, '2014-01-15 15:34:52'),
(10, 1, 0, '2014-01-15 15:34:53'),
(11, 1, 0, '2014-01-15 15:34:54'),
(12, 1, 0, '2014-01-15 15:34:56'),
(13, 1, 0, '2014-01-15 16:08:30'),
(14, 1, 0, '2014-01-15 16:09:28'),
(15, 1, 0, '2014-01-15 16:09:48'),
(16, 1, 0, '2014-01-15 16:09:49'),
(17, 1, 0, '2014-01-15 16:09:51'),
(18, 1, 0, '2014-01-15 16:37:00'),
(19, 1, 0, '2014-01-15 17:13:50'),
(20, 1, 0, '2014-01-15 17:56:51'),
(21, 1, 0, '2014-01-15 17:56:56'),
(22, 1, 0, '2014-01-15 17:57:52'),
(23, 1, 0, '2014-01-15 17:57:55'),
(24, 1, 0, '2014-01-15 18:04:29'),
(25, 1, 0, '2014-01-15 18:07:08'),
(26, 1, 100, '2014-01-15 18:12:48'),
(27, 1, 45, '2014-01-15 19:32:28'),
(28, 1, 100, '2014-01-15 19:36:18'),
(29, 1, 100, '2014-01-15 19:38:38'),
(30, 1, 100, '2014-01-15 19:39:25'),
(31, 1, 100, '2014-01-15 19:39:32'),
(32, 1, 100, '2014-01-15 19:57:58'),
(33, 1, 100, '2014-01-15 20:30:47'),
(34, 1, 250, '2014-01-15 20:31:00'),
(35, 1, 10, '2014-01-15 20:31:07'),
(36, 1, -300, '2014-01-15 20:31:19'),
(37, 1, 0, '2014-01-16 01:01:42'),
(38, 1, 0, '2014-01-16 15:20:33'),
(39, 1, 0, '2014-01-17 12:42:51'),
(40, 1, 12, '2014-01-17 12:42:52'),
(41, 1, 0, '2014-01-21 17:08:22'),
(42, 1, 5000, '2014-01-21 22:20:04'),
(43, 1, 6000, '2014-01-21 22:21:30'),
(44, 1, -9000, '2014-01-21 22:21:48'),
(45, 1, -2000, '2014-01-21 22:39:26'),
(46, 1, 0, '2014-01-21 23:25:42'),
(47, 1, 2000, '2014-01-21 23:25:47'),
(48, 1, 0, '2014-01-21 23:30:52'),
(49, 1, 50, '2014-01-21 23:30:58'),
(50, 1, 5, '2014-01-21 23:31:08'),
(51, 1, 2000, '2014-01-22 12:23:17'),
(52, 1, 455, '2014-01-23 12:43:44');

-- --------------------------------------------------------

--
-- Table structure for table `target`
--

CREATE TABLE IF NOT EXISTS `target` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` int(11) NOT NULL,
  `target_date` date NOT NULL,
  `type` enum('conversation','money_pledged') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `target`
--

INSERT INTO `target` (`id`, `quantity`, `target_date`, `type`) VALUES
(1, 200, '2014-01-15', 'conversation'),
(2, 1000, '2014-01-15', 'money_pledged');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(2, 'Administrator', '$2y$10$tSi62sqsGZIki/wCWJVMg.JgwGyeD3AxQMhnZS57qCVOawlwOeuGm', '1234567890', 'admin@localhost', '2014-01-21 07:51:55', '2014-01-21 07:51:55');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
