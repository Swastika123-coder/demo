-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 09:48 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mlm_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_master`
--

CREATE TABLE `customer_master` (
  `id` bigint(255) NOT NULL,
  `customer_code` varchar(50) DEFAULT '',
  `name` varchar(150) DEFAULT '',
  `ph_num` varchar(50) DEFAULT '',
  `address` varchar(150) NOT NULL,
  `entry_user_code` varchar(50) NOT NULL,
  `entry_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_master`
--

INSERT INTO `customer_master` (`id`, `customer_code`, `name`, `ph_num`, `address`, `entry_user_code`, `entry_timestamp`, `update_timestamp`) VALUES
(1, '001', 'Abhijit Maity', '8240', '', '', '2023-05-08 12:49:22', NULL),
(2, '002', 'Sumitt', '7278', '', '', '2023-05-08 12:49:22', NULL),
(3, '003', 'Imran', '9874', '', '', '2023-05-08 12:49:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_master`
--

CREATE TABLE `menu_master` (
  `id` int(244) NOT NULL,
  `menu_code` varchar(50) DEFAULT '',
  `menu_name` varchar(150) DEFAULT '',
  `menu_icon` varchar(50) DEFAULT '',
  `icon_color` varchar(20) DEFAULT '',
  `sub_menu_status` varchar(10) DEFAULT '',
  `file_name` varchar(100) DEFAULT '',
  `folder_name` varchar(100) DEFAULT '',
  `order_num` decimal(10,0) DEFAULT NULL,
  `active` varchar(10) DEFAULT '',
  `entry_user_code` varchar(50) DEFAULT '',
  `entry_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_master`
--

INSERT INTO `menu_master` (`id`, `menu_code`, `menu_name`, `menu_icon`, `icon_color`, `sub_menu_status`, `file_name`, `folder_name`, `order_num`, `active`, `entry_user_code`, `entry_timestamp`, `update_timestamp`) VALUES
(2, 'MM_5fec5b7265be41609325426', 'System Config', 'la la-cog text-success', '', 'Yes', '', '', '1', 'Yes', 'PA_0001', '2021-02-23 00:00:00', '2022-07-25 21:12:23'),
(6, 'MC_62e041fd9a5401658864125', 'Profile Info', 'fas fa-user text-danger', '', 'Yes', '', '', '2', 'Yes', '', '2022-07-27 01:05:25', '2023-05-08 13:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `sub_menu_master`
--

CREATE TABLE `sub_menu_master` (
  `id` int(244) NOT NULL,
  `sub_menu_code` varchar(50) DEFAULT '',
  `sub_menu_name` varchar(150) DEFAULT '',
  `menu_icon` varchar(150) DEFAULT '',
  `icon_color` varchar(20) DEFAULT '',
  `menu_code` varchar(50) DEFAULT '',
  `file_name` varchar(100) DEFAULT '',
  `folder_name` varchar(100) DEFAULT '',
  `order_num` decimal(10,0) DEFAULT NULL,
  `active` varchar(10) DEFAULT '',
  `entry_user_code` varchar(50) DEFAULT '',
  `entry_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_menu_master`
--

INSERT INTO `sub_menu_master` (`id`, `sub_menu_code`, `sub_menu_name`, `menu_icon`, `icon_color`, `menu_code`, `file_name`, `folder_name`, `order_num`, `active`, `entry_user_code`, `entry_timestamp`, `update_timestamp`) VALUES
(1, 'SMC_626eee3d921351651437117', 'Create Menu', 'fa fa-circle-notch', '', 'MM_5fec5b7265be41609325426', 'menu_master', 'menu_master', '1', 'Yes', 'PA_0001', '2022-05-02 02:01:57', '2022-07-25 21:06:49'),
(2, 'SMC_626eee5724f631651437143', 'Create Sub Menu', 'fa fa-circle-notch', '', 'MM_5fec5b7265be41609325426', 'sub_menu_master', 'sub_menu_master', '2', 'Yes', 'PA_0001', '2022-05-02 02:02:23', '2022-07-25 21:42:28'),
(5, 'SMC_627282dd0c22a1651671773', 'Create User Mode', 'fa fa-circle-notch', '', 'MM_5fec5b7265be41609325426', 'create_user_mode', 'create_user_mode', '4', 'Yes', 'PA_0001', '2022-05-04 19:12:53', '2022-12-27 21:51:03'),
(6, 'SMC_6272831fc83db1651671839', 'Create User', 'fa fa-circle-notch', '', 'MM_5fec5b7265be41609325426', 'create_user', 'create_user', '6', 'Yes', 'PA_0001', '2022-05-04 19:13:59', '2022-12-27 21:51:13'),
(8, 'SMC_62735a3e12dfc1651726910', 'User Mode Permission', 'fa fa-circle-notch', '', 'MM_5fec5b7265be41609325426', 'user_mode_permission', 'user_mode_permission', '5', 'Yes', 'PA_0001', '2022-05-05 10:31:50', '2022-12-27 21:51:08'),
(23, 'SMC_62df7c8e76fd51658813582', 'System Info', 'fa fa-circle-notch', '', 'MM_5fec5b7265be41609325426', 'system_info', 'system_info', '3', 'Yes', 'PA_0001', '2022-07-26 11:03:02', NULL),
(24, 'SMC_62e0421c5d0c11658864156', 'Manage Profile', 'fa fa-circle-notch', '', 'MC_62e041fd9a5401658864125', 'manage_profile', 'manage_profile', '1', 'Yes', 'PA_0001', '2022-07-27 01:05:56', NULL),
(25, 'SMC_62e042410ee2b1658864193', 'Activity Details', 'fa fa-circle-notch', '', 'MC_62e041fd9a5401658864125', 'activity', 'activity', '3', 'Yes', 'PA_0001', '2022-07-27 01:06:33', '2022-07-27 09:45:30'),
(60, 'SMC_6316229e460bf1662395038', 'Change Password', 'fa fa-circle-notch', '', 'MC_62e041fd9a5401658864125', 'change_password', 'change_password', '2', 'Yes', 'PA_0001', '2022-09-05 21:53:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(10) NOT NULL,
  `system_name` varchar(100) DEFAULT '',
  `logo` varchar(100) DEFAULT '',
  `favicon` varchar(100) DEFAULT '',
  `email` varchar(150) DEFAULT '',
  `address` varchar(200) DEFAULT '',
  `ph_num` varchar(50) DEFAULT '',
  `entry_user_code` varchar(50) DEFAULT '',
  `entry_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `system_name`, `logo`, `favicon`, `email`, `address`, `ph_num`, `entry_user_code`, `entry_timestamp`, `update_timestamp`) VALUES
(1, 'MLM Admin', 'logo_7-4-2023-1683407871248.png', 'favicon_7-4-2023-1683407871248.png', 'mlm@mlm.com', 'Chinar Park', '1234567890', '', '2022-07-26 13:22:20', '2023-05-07 02:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `id` bigint(255) NOT NULL,
  `activity_code` varchar(50) DEFAULT '',
  `user_code` varchar(50) DEFAULT '',
  `activity_details` longtext,
  `activity_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`id`, `activity_code`, `user_code`, `activity_details`, `activity_timestamp`) VALUES
(1, 'ACT_6455ef8c084051683353484', 'PA_0001', 'You Insert A Record In Manage Menu Details', '2023-05-06 11:41:24'),
(2, 'ACT_6455f012903aa1683353618', 'PA_0001', 'You Insert A Record In Manage Menu Details', '2023-05-06 11:43:38'),
(3, 'ACT_645636b633cf31683371702', 'PA_0001', 'You Delete A Record In Manage Menu Details', '2023-05-06 16:45:02'),
(4, 'ACT_645636bad12661683371706', 'PA_0001', 'You Delete A Record In Manage Menu Details', '2023-05-06 16:45:06'),
(5, 'ACT_6456386aefe4a1683372138', 'PA_0001', 'You Insert A Record In Manage Menu Details', '2023-05-06 16:52:18'),
(6, 'ACT_64563874b69441683372148', 'PA_0001', 'You Update A Record In Manage Menu Details', '2023-05-06 16:52:28'),
(7, 'ACT_64563878d42131683372152', 'PA_0001', 'You Delete A Record In Manage Menu Details', '2023-05-06 16:52:32'),
(8, 'ACT_64568529e19f81683391785', 'PA_0001', 'You Insert A Record In Manage Sub Menu Details', '2023-05-06 22:19:45'),
(9, 'ACT_64568559b2de41683391833', 'PA_0001', 'You Delete A Record In Manage Sub Menu', '2023-05-06 22:20:33'),
(10, 'ACT_64568562852361683391842', 'PA_0001', 'You Insert A Record In Manage Sub Menu Details', '2023-05-06 22:20:42'),
(11, 'ACT_6456856d17e671683391853', 'PA_0001', 'You Update A Record In Manage Sub Menu Details', '2023-05-06 22:20:53'),
(12, 'ACT_64568573745381683391859', 'PA_0001', 'You Delete A Record In Manage Sub Menu', '2023-05-06 22:20:59'),
(13, 'ACT_6456bc2d5a79a1683405869', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:14:29'),
(14, 'ACT_6456bc2f422481683405871', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:14:31'),
(15, 'ACT_6456bc3019cda1683405872', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:14:32'),
(16, 'ACT_6456bc6f86fd21683405935', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:15:35'),
(17, 'ACT_6456bc8eb5cea1683405966', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:16:06'),
(18, 'ACT_6456bce7488b81683406055', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:17:35'),
(19, 'ACT_6456bd27535401683406119', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:18:39'),
(20, 'ACT_6456bda5aa4981683406245', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:20:45'),
(21, 'ACT_6456bde78758b1683406311', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:21:51'),
(22, 'ACT_6456be0fc2a631683406351', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:22:31'),
(23, 'ACT_6456be4dbf2381683406413', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:23:33'),
(24, 'ACT_6456be909f95a1683406480', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:24:40'),
(25, 'ACT_6456bf568daff1683406678', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:27:58'),
(26, 'ACT_6456bf88808cc1683406728', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:28:48'),
(27, 'ACT_6456bfc6a41e91683406790', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:29:50'),
(28, 'ACT_6456c05b105101683406939', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:32:19'),
(29, 'ACT_6456c0621d6911683406946', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:32:26'),
(30, 'ACT_6456c0983c2511683407000', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:33:20'),
(31, 'ACT_6456c0c36f65f1683407043', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:34:03'),
(32, 'ACT_6456c0d35f9c31683407059', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:34:19'),
(33, 'ACT_6456c14b55c721683407179', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:36:19'),
(34, 'ACT_6456c15e2d34c1683407198', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:36:38'),
(35, 'ACT_6456c1b20d6c41683407282', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:38:02'),
(36, 'ACT_6456c25b299ad1683407451', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:40:51'),
(37, 'ACT_6456c27275f391683407474', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:41:14'),
(38, 'ACT_6456c29203f881683407506', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:41:46'),
(39, 'ACT_6456c2b766b411683407543', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:42:23'),
(40, 'ACT_6456c2ef8b77d1683407599', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:43:19'),
(41, 'ACT_6456c33c92b941683407676', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:44:36'),
(42, 'ACT_6456c36b96dff1683407723', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:45:23'),
(43, 'ACT_6456c37d87d3c1683407741', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:45:41'),
(44, 'ACT_6456c3c6ada531683407814', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:46:54'),
(45, 'ACT_6456c3ff424961683407871', 'PA_0001', 'You Update A Record In Manage System Info', '2023-05-07 02:47:51'),
(46, 'ACT_6458a7e3f07741683531747', 'PA_0001', 'You Update A Record In Manage Menu Details', '2023-05-08 13:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `id` int(244) NOT NULL,
  `user_code` varchar(50) DEFAULT '',
  `user_id` varchar(50) DEFAULT '',
  `user_password` varchar(200) DEFAULT '',
  `name` varchar(150) DEFAULT '',
  `email` varchar(150) NOT NULL,
  `profile_img` varchar(100) DEFAULT '',
  `user_mode_code` varchar(50) DEFAULT '',
  `active` varchar(10) DEFAULT '',
  `entry_permission` varchar(10) DEFAULT '',
  `view_permission` varchar(10) DEFAULT '',
  `edit_permission` varchar(10) DEFAULT '',
  `delete_permissioin` varchar(10) DEFAULT '',
  `entry_user_code` varchar(50) DEFAULT '',
  `entry_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`id`, `user_code`, `user_id`, `user_password`, `name`, `email`, `profile_img`, `user_mode_code`, `active`, `entry_permission`, `view_permission`, `edit_permission`, `delete_permissioin`, `entry_user_code`, `entry_timestamp`, `update_timestamp`) VALUES
(1, 'PA_0001', 'admin', 'YWRtaW4=', 'Project Admin', 'amaity535@gmail.com', 'profile_img_27-6-2022-1658895194819.png', 'Project Admin', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'PA_0001', '0000-00-00 00:00:00', '2023-02-21 14:31:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_mode`
--

CREATE TABLE `user_mode` (
  `id` int(244) NOT NULL,
  `user_mode_code` varchar(50) DEFAULT '',
  `user_mode` varchar(50) DEFAULT '',
  `active` varchar(10) DEFAULT '',
  `entry_user_code` varchar(50) DEFAULT '',
  `entry_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` int(255) NOT NULL,
  `user_mode_code` varchar(50) DEFAULT '',
  `all_menu_code` varchar(50) DEFAULT '',
  `menu_type` varchar(20) DEFAULT '',
  `entry_user_code` varchar(50) DEFAULT '',
  `entry_timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_master`
--
ALTER TABLE `customer_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_master`
--
ALTER TABLE `menu_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_menu_master`
--
ALTER TABLE `sub_menu_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_mode`
--
ALTER TABLE `user_mode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_master`
--
ALTER TABLE `customer_master`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu_master`
--
ALTER TABLE `menu_master`
  MODIFY `id` int(244) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sub_menu_master`
--
ALTER TABLE `sub_menu_master`
  MODIFY `id` int(244) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `id` int(244) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_mode`
--
ALTER TABLE `user_mode`
  MODIFY `id` int(244) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
