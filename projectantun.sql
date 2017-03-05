-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2017 at 03:11 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectantun`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL DEFAULT '0',
  `class_id` int(11) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `model_id`, `class_id`, `location_id`, `price`) VALUES
(1, 1, 1, 1, 40),
(2, 1, 1, 1, 40),
(3, 1, 1, 1, 40),
(4, 1, 1, 2, 40),
(5, 1, 1, 2, 40),
(6, 2, 1, 1, 40),
(7, 2, 1, 1, 40),
(8, 2, 1, 3, 40),
(9, 3, 1, 1, 50),
(10, 3, 1, 1, 50),
(11, 3, 1, 5, 50),
(12, 4, 1, 4, 45),
(13, 4, 1, 2, 45),
(14, 4, 1, 2, 45),
(15, 4, 1, 2, 45),
(16, 5, 1, 1, 55),
(17, 5, 1, 1, 55),
(18, 5, 1, 1, 55),
(19, 5, 1, 2, 55),
(20, 5, 1, 3, 55),
(21, 6, 1, 1, 40),
(22, 6, 1, 6, 40),
(23, 6, 1, 1, 40),
(24, 6, 1, 2, 40);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `name`) VALUES
(1, 'Mostar'),
(2, 'Sarajevo'),
(3, 'Split'),
(4, 'Zagreb'),
(5, 'Banja Luka'),
(6, 'Tuzla');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `model_id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL DEFAULT '''''',
  `model` varchar(255) NOT NULL DEFAULT '''''',
  `transmission` varchar(255) NOT NULL DEFAULT '''''',
  `air_conditioning` int(11) NOT NULL,
  `seats` int(11) NOT NULL,
  `doors` int(11) NOT NULL,
  `fuel` varchar(255) NOT NULL DEFAULT '''''',
  `price` float NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`model_id`, `brand`, `model`, `transmission`, `air_conditioning`, `seats`, `doors`, `fuel`, `price`) VALUES
(1, 'Skoda', 'Fabia', 'Manual', 1, 5, 5, 'Benzin', 40),
(2, 'Hyundai', 'Accent', 'Automatic', 1, 5, 5, 'Dizel', 45),
(3, 'Toyota', 'Yaris', 'Manual', 1, 5, 5, 'Dizel', 50),
(4, 'Seat', 'Ibiza', 'Manual', 1, 5, 5, 'Dizel', 55),
(5, 'Opel', 'Astra', 'Manual', 1, 5, 5, 'Benzin', 45),
(6, 'Volkswagen', 'Polo', 'Manual', 1, 5, 5, 'Benzin', 45);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `last_change_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `car_id`, `order_date`, `order_time`, `last_change_id`) VALUES
(76, 23, 1, '2017-03-01', '23:56:47', 82),
(73, 23, 2, '2017-03-01', '23:56:29', 14),
(96, 23, 1, '2017-03-05', '01:09:44', 0),
(71, 23, 2, '2017-03-01', '23:56:02', 0),
(70, 23, 1, '2017-03-01', '23:55:53', 0),
(69, 23, 3, '2017-03-01', '23:55:00', 0),
(77, 23, 3, '2017-03-04', '14:38:54', 0),
(78, 23, 1, '2017-03-04', '15:06:50', 0),
(79, 23, 3, '2017-03-04', '15:08:23', 81),
(80, 23, 2, '2017-03-04', '15:09:24', 61),
(81, 23, 3, '2017-03-04', '15:09:50', 0),
(82, 23, 2, '2017-03-04', '15:09:55', 62),
(83, 23, 1, '2017-03-04', '15:09:58', 0),
(95, 23, 1, '2017-03-05', '01:09:29', 0),
(94, 23, 2, '2017-03-05', '01:06:21', 0),
(93, 23, 3, '2017-03-05', '01:04:47', 0),
(89, 23, 3, '2017-03-04', '16:20:10', 0),
(90, 23, 1, '2017-03-04', '16:21:43', 0),
(91, 23, 2, '2017-03-04', '16:22:34', 0),
(92, 23, 3, '2017-03-04', '16:22:39', 0),
(97, 23, 1, '2017-03-05', '02:29:51', 0),
(98, 23, 2, '2017-03-05', '02:30:17', 0),
(99, 23, 3, '2017-03-05', '02:38:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_change`
--

CREATE TABLE `order_change` (
  `order_change_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `change_type` varchar(255) NOT NULL DEFAULT '''''',
  `change_column` varchar(255) NOT NULL DEFAULT '''''',
  `previous_value` varchar(255) NOT NULL DEFAULT '''''',
  `new_value` varchar(255) NOT NULL DEFAULT '''''',
  `change_date` date NOT NULL,
  `change_time` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_change`
--

INSERT INTO `order_change` (`order_change_id`, `order_id`, `change_type`, `change_column`, `previous_value`, `new_value`, `change_date`, `change_time`) VALUES
(5, 75, 'update', 'dropoff_date', '2017-09-17', '2017-09-20', '2017-03-04', '00:55:41'),
(2, 76, 'update', 'dropoff_date', '2017-09-17', '2017-09-19', '2017-03-04', '00:45:11'),
(3, 76, 'update', 'dropoff_date', '2017-09-17', '2017-09-19', '2017-03-04', '00:46:11'),
(4, 76, 'update', 'dropoff_date', '2017-09-17', '2017-09-19', '2017-03-04', '00:53:11'),
(6, 74, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '11:08:30'),
(7, 73, 'update', 'pickup_date', '2017-09-12', '2017-09-15', '2017-03-04', '11:11:56'),
(8, 74, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '11:11:56'),
(9, 73, 'update', 'pickup_date', '2017-09-15', '2017-09-15', '2017-03-04', '11:13:29'),
(10, 74, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '11:13:30'),
(11, 73, 'update', 'pickup_date', '2017-09-15', '2017-09-15', '2017-03-04', '11:16:26'),
(12, 73, 'update', 'pickup_date', '2017-09-15', '2017-09-15', '2017-03-04', '11:17:06'),
(13, 73, 'update', 'pickup_date', '2017-09-15', '2017-09-15', '2017-03-04', '11:17:14'),
(14, 73, 'update', 'pickup_date', '2017-09-15', '2017-09-15', '2017-03-04', '11:17:28'),
(15, 72, 'update', 'pickup_date', '2017-09-12', '2017-09-15', '2017-03-04', '11:17:57'),
(16, 84, 'update', 'pickup_date', '2015-12-29', '2017-09-15', '2017-03-04', '16:52:32'),
(17, 84, 'update', 'pickup_date', '', '', '2017-03-04', '17:28:02'),
(18, 84, 'update', 'pickup_date', '', '', '2017-03-04', '17:28:25'),
(19, 84, 'update', 'pickup_date', '', '', '2017-03-04', '17:30:18'),
(20, 84, 'update', 'pickup_date', '', '', '2017-03-04', '17:30:37'),
(21, 84, 'update', 'pickup_date', '2017-09-15', '2017-09-15', '2017-03-04', '17:31:05'),
(22, 84, 'update', 'pickup_date', '2017-09-15', '2017-09-15', '2017-03-04', '17:31:43'),
(23, 84, 'update', 'pickup_date', '2017-09-15', '2017-09-15', '2017-03-04', '17:32:00'),
(24, 84, 'update', 'pickup_date', '2017-09-15', '2017-09-15', '2017-03-04', '17:32:33'),
(25, 84, 'update', 'dropoff_date', '2017-09-15', '2015-12-29', '2017-03-04', '17:33:15'),
(26, 84, 'update', 'dropoff_date', '2017-09-15', '2015-12-29', '2017-03-04', '17:33:31'),
(27, 84, 'update', 'dropoff_date', '2017-09-15', '2015-12-29', '2017-03-04', '17:35:31'),
(28, 84, 'update', 'dropoff_time', '2017-09-15', '00:00:00', '2017-03-04', '17:35:49'),
(29, 84, 'update', 'dropoff_time', '2017-09-15', '00:00:00', '2017-03-04', '17:36:43'),
(30, 84, 'update', 'dropoff_time', '22:00', '00:00:00', '2017-03-04', '17:37:00'),
(31, 84, 'update', 'dropoff_time', '22:00', '00:00:00', '2017-03-04', '17:37:04'),
(32, 84, 'update', 'dropoff_time', '22:00', '00:00:00', '2017-03-04', '17:37:07'),
(33, 84, 'update', 'dropoff_time', '22:00', '00:00:00', '2017-03-04', '17:39:26'),
(34, 84, 'update', 'dropoff_time', '00:00:00', '22:00', '2017-03-04', '17:39:51'),
(35, 84, 'update', 'dropoff_time', '22:00:00', '22:00', '2017-03-04', '17:39:59'),
(36, 84, 'update', 'dropoff_time', '22:00:00', '22:00', '2017-03-04', '17:40:01'),
(37, 84, 'update', 'dropoff_date', '2015-12-29', '2014-01-01', '2017-03-04', '17:40:55'),
(38, 84, 'update', 'dropoff_date', '2014-01-01', '2014-01-01', '2017-03-04', '17:41:02'),
(39, 84, 'update', 'dropoff_date', '2014-01-01', '2015-01-01', '2017-03-04', '17:41:21'),
(40, 84, 'update', 'dropoff_date', '2015-01-01', '2016-01-01', '2017-03-04', '17:46:45'),
(41, 84, 'update', 'dropoff_date', '2016-01-01', '2012-01-01', '2017-03-04', '17:48:18'),
(42, 85, 'update', 'dropoff_date', '2015-12-29', '2012-01-01', '2017-03-04', '17:58:33'),
(43, 85, 'update', 'dropoff_date', '2012-01-01', '2012-01-01', '2017-03-04', '17:58:55'),
(44, 85, 'update', 'dropoff_date', '2012-01-01', '2012-01-01', '2017-03-04', '17:59:41'),
(45, 72, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:02:11'),
(46, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:02:43'),
(47, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:02:44'),
(48, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:03:10'),
(49, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:04:01'),
(50, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:04:36'),
(51, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:05:31'),
(52, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:05:32'),
(53, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:05:53'),
(54, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:06:21'),
(55, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:06:22'),
(56, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:06:39'),
(57, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:06:59'),
(58, 84, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:07:24'),
(59, 85, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:17:50'),
(60, 86, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-04', '18:20:09'),
(61, 80, 'update', 'dropoff_date', '2015-12-12', '2012-02-01', '2017-03-05', '01:35:28'),
(62, 82, 'update', 'dropoff_date', '2015-12-16', '2012-02-01', '2017-03-05', '01:36:23'),
(63, 79, 'update', 'pickup_date', '2015-12-12', '2012-02-01', '2017-03-05', '01:37:00'),
(64, 79, 'update', 'pickup_date', '2012-02-01', '2012-02-01', '2017-03-05', '01:38:29'),
(65, 79, 'update', 'pickup_date', '2012-02-01', '2012-02-01', '2017-03-05', '03:17:56'),
(66, 79, 'update', 'pickup_date', '2012-02-01', '2012-02-01', '2017-03-05', '03:19:53'),
(67, 79, 'update', 'pickup_date', '2012-02-01', '2012-02-01', '2017-03-05', '03:19:59'),
(68, 79, 'update', 'pickup_date', '2012-02-01', '2012-02-01', '2017-03-05', '03:20:49'),
(69, 79, 'update', 'pickup_date', '2012-02-01', '2012-02-01', '2017-03-05', '03:20:54'),
(70, 79, 'update', 'pickup_date', '2012-02-01', '2015-02-01', '2017-03-05', '03:21:18'),
(71, 79, 'update', 'pickup_date', '2015-02-01', '2015-02-02', '2017-03-05', '03:21:32'),
(72, 86, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-05', '03:22:42'),
(73, 87, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-05', '03:22:55'),
(74, 88, 'delete', '\'\'', '\'\'', '\'\'', '2017-03-05', '03:23:03'),
(75, 79, 'update', 'pickup_date', '2015-02-02', '2015-02-02', '2017-03-05', '04:00:25'),
(76, 79, 'update', 'pickup_date', '2015-02-02', '2015-02-02', '2017-03-05', '04:00:50'),
(77, 79, 'update', 'pickup_date', '2015-02-02', '2015-02-02', '2017-03-05', '04:03:07'),
(78, 79, 'update', 'pickup_date', '2015-02-02', '2015-02-02', '2017-03-05', '04:03:31'),
(79, 79, 'update', 'pickup_date', '2015-02-02', '2017-04-02', '2017-03-05', '04:03:49'),
(80, 79, 'update', 'pickup_date', '2017-04-02', '2017-04-02', '2017-03-05', '04:03:51'),
(81, 79, 'update', 'dropoff_date', '2015-12-12', '2017-04-02', '2017-03-05', '04:05:18'),
(82, 76, 'update', 'dropoff_date', '2017-09-19', '2017-09-20', '2017-03-05', '04:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL DEFAULT '0',
  `pickup_location_id` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time` time NOT NULL,
  `dropoff_location_id` int(11) NOT NULL,
  `dropoff_date` date NOT NULL,
  `dropoff_time` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `payment_type_id`, `pickup_location_id`, `pickup_date`, `pickup_time`, `dropoff_location_id`, `dropoff_date`, `dropoff_time`) VALUES
(76, 1, 1, '2017-09-17', '09:00:00', 1, '2017-09-20', '22:00:00'),
(73, 1, 1, '2017-09-15', '09:00:00', 1, '2017-09-12', '22:00:00'),
(96, 1, 1, '2002-03-03', '11:11:00', 1, '2002-03-03', '11:11:00'),
(71, 1, 1, '2016-09-12', '09:00:00', 1, '2016-09-12', '22:00:00'),
(70, 1, 1, '2016-09-12', '09:00:00', 1, '2016-09-12', '22:00:00'),
(69, 1, 1, '2016-09-12', '09:00:00', 1, '2016-09-12', '22:00:00'),
(77, 1, 1, '2017-03-22', '00:00:00', 1, '2017-03-24', '00:00:00'),
(78, 1, 1, '2015-12-12', '00:00:00', 1, '2015-12-12', '00:00:00'),
(79, 1, 1, '2017-04-02', '00:00:00', 1, '2017-04-02', '00:00:00'),
(80, 1, 1, '2015-12-12', '00:00:00', 1, '2012-02-01', '00:00:00'),
(81, 1, 1, '2015-12-16', '00:00:00', 1, '2015-12-16', '00:00:00'),
(82, 1, 1, '2015-12-16', '00:00:00', 1, '2012-02-01', '00:00:00'),
(83, 1, 1, '2015-12-16', '00:00:00', 1, '2015-12-16', '00:00:00'),
(95, 1, 1, '2000-03-03', '11:11:00', 1, '2000-03-03', '11:11:00'),
(94, 1, 1, '2000-03-03', '11:11:00', 1, '2000-03-03', '11:11:00'),
(93, 1, 1, '2000-03-03', '11:11:00', 1, '2000-03-03', '11:11:00'),
(89, 1, 1, '1414-12-14', '14:14:00', 1, '1414-12-14', '14:14:00'),
(90, 1, 1, '1515-12-15', '14:14:00', 1, '1515-12-15', '14:14:00'),
(91, 1, 1, '1515-12-15', '00:00:00', 1, '1515-12-15', '00:00:00'),
(92, 1, 1, '1515-12-15', '00:00:00', 1, '1515-12-15', '00:00:00'),
(97, 1, 1, '2017-04-03', '00:00:00', 1, '2017-04-05', '00:00:00'),
(98, 1, 1, '2017-04-03', '00:00:00', 1, '2017-04-03', '03:00:00'),
(99, 1, 1, '2017-04-13', '00:00:00', 1, '2017-04-14', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `payment_type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`payment_type_id`, `name`) VALUES
(1, 'PayPal'),
(2, 'Credit Card');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT '''''',
  `last_name` varchar(255) NOT NULL DEFAULT '''''',
  `phone` varchar(255) NOT NULL DEFAULT '''''',
  `email` varchar(255) NOT NULL DEFAULT '''''',
  `user_ip` varchar(255) NOT NULL,
  `user_key` varchar(255) NOT NULL DEFAULT ''''''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `phone`, `email`, `user_ip`, `user_key`) VALUES
(23, 'Antun', 'Prskalo', '\'\'', 'antun8-8@hotmail.com', '::1', '317b613fc8c3d6c25dea0934aba2e4ea4006c2b2d13f53049e470da563fbe5ca');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`model_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_change`
--
ALTER TABLE `order_change`
  ADD PRIMARY KEY (`order_change_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`payment_type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `order_change`
--
ALTER TABLE `order_change`
  MODIFY `order_change_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `payment_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
