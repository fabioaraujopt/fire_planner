-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 19, 2019 at 01:13 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `planner_schema`
--

-- --------------------------------------------------------

--
-- Table structure for table `detection_images`
--

CREATE TABLE `detection_images` (
                                    `detection_id` int(11) NOT NULL,
                                    `image_path` text NOT NULL,
                                    `center_lat` float(9,6) NOT NULL,
                                    `center_lng` float(9,6) NOT NULL,
                                    `status` int(11) DEFAULT NULL,
                                    `altitude` int(11) NOT NULL,
                                    `image_time` datetime DEFAULT NULL,
                                    `detection_confidence` float DEFAULT NULL,
                                    `creation_user` int(11) NOT NULL DEFAULT '0',
                                    `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detection_images`
--

INSERT INTO `detection_images` (`detection_id`, `image_path`, `center_lat`, `center_lng`, `status`, `altitude`, `image_time`, `detection_confidence`, `creation_user`, `creation_time`) VALUES
(1, '1.png', 38.676525, -9.165105, 2, 0, '2019-09-24 15:00:00', 0.9, 1, '2019-09-24 15:57:14'),
(2, '1.png', 38.676525, -9.165105, 2, 0, '2019-09-24 15:00:00', 0.9, 1, '2019-09-24 15:59:09'),
(3, '99bea0f77cfd0c6da2ce3ae2dcb32ec2.jpg', 37.936066, -8.076581, 0, 0, '2019-09-30 12:16:09', NULL, 0, '2019-09-30 13:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `detection_status`
--

CREATE TABLE `detection_status` (
                                    `status_id` int(11) NOT NULL,
                                    `status_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detection_status`
--

INSERT INTO `detection_status` (`status_id`, `status_name`) VALUES
(1, 'unconfirmed'),
(2, 'fire confirmed'),
(3, 'review mask'),
(4, 'false positive');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
                           `device_id` int(11) NOT NULL,
                           `device_ip` varchar(255) NOT NULL,
                           `device_image_ip` varchar(255) NOT NULL,
                           `device_name` varchar(255) NOT NULL,
                           `rate` int(11) NOT NULL DEFAULT '3000',
                           `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                           `creation_user` int(11) NOT NULL,
                           `in_use` int(11) NOT NULL,
                           `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`device_id`, `device_ip`, `device_image_ip`, `device_name`, `rate`, `creation_date`, `creation_user`, `in_use`, `type`) VALUES
(1, '192.168.1.154:9090', '10.5.6.7:9090', 'rics_matrice_210_rtk', 3000, '2019-09-19 15:21:29', 1, 1, 'drone'),
(2, '192.168.1.154:9090', '10.5.6.7:9090', 'vigil', 3000, '2019-09-24 22:17:17', 1, 1, 'fire_truck');

-- --------------------------------------------------------

--
-- Table structure for table `fire_detection_devices`
--

CREATE TABLE `fire_detection_devices` (
                                          `fire_detection_id` int(11) NOT NULL,
                                          `fire_detetecion_ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ground_images`
--

CREATE TABLE `ground_images` (
                                 `image_id` int(11) NOT NULL,
                                 `image_path` text NOT NULL,
                                 `image_type` int(11) NOT NULL,
                                 `workarea` int(11) NOT NULL,
                                 `top_left_lat` float(9,6) NOT NULL,
                                 `top_left_lng` float(9,6) NOT NULL,
                                 `bottom_right_lat` float(9,6) NOT NULL,
                                 `bottom_right_lng` float(9,6) NOT NULL,
                                 `creation_user` int(11) NOT NULL,
                                 `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ground_images`
--

INSERT INTO `ground_images` (`image_id`, `image_path`, `image_type`, `workarea`, `top_left_lat`, `top_left_lng`, `bottom_right_lat`, `bottom_right_lng`, `creation_user`, `creation_time`) VALUES
(1, 'image_1.png', 1, 0, 39.498768, -9.022436, 39.498318, -9.022042, 1, '2019-09-21 16:46:49'),
(3, 'image_2.png', 0, 0, 39.498768, -9.022436, 39.498318, -9.022042, 1, '2019-09-21 16:48:42'),
(4, 'image_3.png', 2, 0, 39.498768, -9.022437, 39.498318, -9.022042, 1, '2019-09-21 16:48:42'),
(7, 'image_4.png', 1, 1, 39.498665, -9.023431, 39.498165, -9.022869, 1, '2019-09-21 16:50:08'),
(8, 'image_5.png', 0, 1, 39.498665, -9.023431, 39.498165, -9.022869, 1, '2019-09-21 16:50:08'),
(11, 'image_6.png', 2, 1, 39.498665, -9.023431, 39.498165, -9.022869, 1, '2019-09-21 16:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `sensor_msgs`
--

CREATE TABLE `sensor_msgs` (
                               `msg_id` int(11) NOT NULL,
                               `msg_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sensor_msgs`
--

INSERT INTO `sensor_msgs` (`msg_id`, `msg_type`) VALUES
(1, 'sensor_msgs/NavSatFix'),
(5, 'sensor_msgs/Imu'),
(6, 'sensor_msgs/Temperature'),
(7, 'sensor_msgs/BatteryState');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `user_id` int(11) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `name` varchar(255) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `name`, `password`, `role`) VALUES
(1, 'fabio@fabio.com', 'Fábio Araújo', 'coelho123', 1),
(5, 'tony@tony.com', 'tony@tony.com', 'tony', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
                              `role_id` int(11) NOT NULL,
                              `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Operator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detection_images`
--
ALTER TABLE `detection_images`
    ADD PRIMARY KEY (`detection_id`);

--
-- Indexes for table `detection_status`
--
ALTER TABLE `detection_status`
    ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
    ADD PRIMARY KEY (`device_id`),
    ADD UNIQUE KEY `device_name` (`device_name`);

--
-- Indexes for table `fire_detection_devices`
--
ALTER TABLE `fire_detection_devices`
    ADD PRIMARY KEY (`fire_detection_id`);

--
-- Indexes for table `ground_images`
--
ALTER TABLE `ground_images`
    ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `sensor_msgs`
--
ALTER TABLE `sensor_msgs`
    ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
    ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detection_images`
--
ALTER TABLE `detection_images`
    MODIFY `detection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detection_status`
--
ALTER TABLE `detection_status`
    MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
    MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fire_detection_devices`
--
ALTER TABLE `fire_detection_devices`
    MODIFY `fire_detection_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ground_images`
--
ALTER TABLE `ground_images`
    MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sensor_msgs`
--
ALTER TABLE `sensor_msgs`
    MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
    MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;