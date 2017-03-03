-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2017 at 11:57 PM
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
-- Table structure for table `car_class`
--

CREATE TABLE `car_class` (
  `class_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''''''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car_class`
--

INSERT INTO `car_class` (`class_id`, `name`) VALUES
(1, 'Economy'),
(2, 'Luxury'),
(3, 'Minivan'),
(4, 'Pickup');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT '''''',
  `last_name` varchar(255) NOT NULL DEFAULT '''''',
  `phone` varchar(255) NOT NULL DEFAULT '''''',
  `email` varchar(255) NOT NULL DEFAULT ''''''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `car_id`, `order_date`, `order_time`, `last_change_id`) VALUES
(76, 23, 1, '2017-03-01', '23:56:47', 4),
(75, 23, 3, '2017-03-01', '23:56:45', 5),
(74, 23, 2, '2017-03-01', '23:56:37', 0),
(73, 23, 2, '2017-03-01', '23:56:29', 0),
(72, 23, 3, '2017-03-01', '23:56:23', 0),
(71, 23, 2, '2017-03-01', '23:56:02', 0),
(70, 23, 1, '2017-03-01', '23:55:53', 0),
(69, 23, 3, '2017-03-01', '23:55:00', 0);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_change`
--

INSERT INTO `order_change` (`order_change_id`, `order_id`, `change_type`, `change_column`, `previous_value`, `new_value`, `change_date`, `change_time`) VALUES
(5, 75, 'update', 'dropoff_date', '2017-09-17', '2017-09-20', '2017-03-04', '00:55:41'),
(2, 76, 'update', 'dropoff_date', '2017-09-17', '2017-09-19', '2017-03-04', '00:45:11'),
(3, 76, 'update', 'dropoff_date', '2017-09-17', '2017-09-19', '2017-03-04', '00:46:11'),
(4, 76, 'update', 'dropoff_date', '2017-09-17', '2017-09-19', '2017-03-04', '00:53:11');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `payment_type_id`, `pickup_location_id`, `pickup_date`, `pickup_time`, `dropoff_location_id`, `dropoff_date`, `dropoff_time`) VALUES
(76, 1, 1, '2017-09-17', '09:00:00', 1, '2017-09-19', '22:00:00'),
(75, 1, 1, '2017-09-17', '09:00:00', 1, '2017-09-20', '22:00:00'),
(74, 1, 1, '2017-09-17', '09:00:00', 1, '2017-09-17', '22:00:00'),
(73, 1, 1, '2017-09-12', '09:00:00', 1, '2017-09-12', '22:00:00'),
(72, 1, 1, '2017-09-12', '09:00:00', 1, '2017-09-12', '22:00:00'),
(71, 1, 1, '2016-09-12', '09:00:00', 1, '2016-09-12', '22:00:00'),
(70, 1, 1, '2016-09-12', '09:00:00', 1, '2016-09-12', '22:00:00'),
(69, 1, 1, '2016-09-12', '09:00:00', 1, '2016-09-12', '22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `payment_type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `phone`, `email`, `user_ip`, `user_key`) VALUES
(23, 'Antun', 'Prskalo', '\'\'', 'antun8-8@hotmail.com', '::1', '138606c0797c7f8e5692839c69264bb2a3ea479c96b9a85d9c65a5b1daf92252');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `car_class`
--
ALTER TABLE `car_class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

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
-- AUTO_INCREMENT for table `car_class`
--
ALTER TABLE `car_class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `order_change`
--
ALTER TABLE `order_change`
  MODIFY `order_change_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
