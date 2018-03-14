-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2018 at 06:22 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epmtfafn_satta`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `age` smallint(6) NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `money` int(11) NOT NULL,
  `start_date_time` datetime NOT NULL,
  `last_login_date_time` datetime NOT NULL,
  `status_email` tinyint(1) NOT NULL,
  `qrcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`username`, `password`, `nickname`, `position`, `first_name`, `last_name`, `gender`, `age`, `email`, `image`, `money`, `start_date_time`, `last_login_date_time`, `status_email`, `qrcode`) VALUES
('aaaaaaaaaa', '123456789', 'aaaaaaaaaa', 'member', 'Arai', 'Team', 'm', 13, 'a101010@gmail.com', '', 0, '2018-02-20 10:00:00', '2018-02-20 10:00:00', 1, 'RJLGJEIOJjflksdjfeinbJ'),
('admin', 'admin', 'Administrator', 'admin', 'Suphawich', 'Sungkhavorn', 'm', 20, 'admin@sattagarden.com', '', 500000, '2018-02-20 00:00:00', '2018-02-20 00:00:00', 1, 'FEWGDFH#R#ED'),
('hello123', 'hello', 'MyHello', 'member', 'Hello', 'World', 'w', 17, 'hello123@gmail.com', '', 0, '2018-02-21 04:26:44', '2018-02-23 10:31:17', 1, 'RKWORIFOPVPEK'),
('supanut', '123456', 'supanut123', 'member', 'Nut', 'supanut', 'm', 21, 'supanut123@gmail.com', '', 0, '2018-02-23 09:00:00', '2018-02-23 10:00:00', 1, 'RKWORCZXVBNVPEK'),
('tammada', 'Tun222', 'Kontammada', 'member', 'Kon', 'Tammada', 'm', 22, 'kontammada@gmail.com', '', 0, '2018-02-23 05:00:00', '2018-02-24 07:00:00', 1, 'RWETSDGNFZSDAGFWF');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `notopic` smallint(6) NOT NULL,
  `nocomment` smallint(6) NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`notopic`, `nocomment`, `username`, `message`, `date_time`) VALUES
(1, 1, 'tammada', 'ความคิดเห็นที่1', '2018-02-23 11:52:25'),
(1, 2, 'supanut', 'ddd', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `noevent` int(10) UNSIGNED NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `current` smallint(6) NOT NULL,
  `capacity` smallint(6) NOT NULL,
  `price` int(11) NOT NULL,
  `imagePath` text COLLATE utf8_unicode_ci NOT NULL,
  `vdoPath` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `create_date_time` datetime NOT NULL,
  `start_date_time` datetime NOT NULL,
  `end_date_time` datetime NOT NULL,
  `location` text COLLATE utf8_unicode_ci NOT NULL,
  `condition` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`noevent`, `username`, `name`, `type`, `current`, `capacity`, `price`, `imagePath`, `vdoPath`, `description`, `create_date_time`, `start_date_time`, `end_date_time`, `location`, `condition`, `status`) VALUES
(1, 'tammada', 'อบรมการใช้ภาษาจาวา', 'event', 2, 20, 300, 'webUpload/การพัฒนา AI/organizerUpload/p1.jpg,webUpload/การพัฒนา AI/organizerUpload/p2.jpg,webUpload/การพัฒนา AI/organizerUpload/p3.jpg,', 'webUpload/การพัฒนา AI/organizerUpload/ai.mp4', 'ตารางการอบรมภาษาจาวา', '2018-02-23 10:07:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ไม่มี', 'ไม่มี', 0),
(2, 'supanut', 'การพัฒนา AI', 'seminar', 3, 10, 100, 'webUpload/การพัฒนา AI/organizerUpload/p1.jpg,webUpload/การพัฒนา AI/organizerUpload/p2.jpg,webUpload/การพัฒนา AI/organizerUpload/p3.jpg,', 'webUpload/การพัฒนา AI/organizerUpload/ai.mp4', 'ตารางงานพัฒนา AI', '2018-02-22 07:52:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ไม่มี', 'ไม่มี', 0),
(3, 'supanut', 'แนะแนวROV', 'seminar', 3, 5, 200, 'webUpload/การพัฒนา AI/organizerUpload/p1.jpg,webUpload/การพัฒนา AI/organizerUpload/p2.jpg,webUpload/การพัฒนา AI/organizerUpload/p3.jpg,', 'webUpload/การพัฒนา AI/organizerUpload/ai.mp4', 'วิธีการเล่นที่ถูกวิธี', '2018-02-22 07:52:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ไม่มี', 'ไม่มี', 0),
(4, 'supanut', 'แนะแนวVR', 'seminar', 3, 5, 200, 'webUpload/การพัฒนา AI/organizerUpload/p1.jpg,webUpload/การพัฒนา AI/organizerUpload/p2.jpg,webUpload/การพัฒนา AI/organizerUpload/p3.jpg,', 'webUpload/การพัฒนา AI/organizerUpload/ai.mp4', 'วิธีการเล่นที่ถูกวิธี', '2018-02-22 07:52:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ไม่มี', 'ไม่มี', 0),
(5, 'tammada', 'เเข่งเขียนเว็ป', 'event', 2, 20, 300, 'webUpload/การพัฒนา AI/organizerUpload/p1.jpg,webUpload/การพัฒนา AI/organizerUpload/p2.jpg,webUpload/การพัฒนา AI/organizerUpload/p3.jpg,', 'webUpload/การพัฒนา AI/organizerUpload/ai.mp4', 'ตารางการอบรมภาษาจาวา', '2018-02-23 10:07:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ไม่มี', 'ไม่มี', 0),
(6, 'tammada', 'ท่องโลกกว้าง', 'event', 2, 50, 300, 'webUpload/การพัฒนา AI/organizerUpload/p1.jpg,webUpload/การพัฒนา AI/organizerUpload/p2.jpg,webUpload/การพัฒนา AI/organizerUpload/p3.jpg,', 'webUpload/การพัฒนา AI/organizerUpload/ai.mp4', 'ตารางการอบรมภาษาจาวา', '2018-02-23 10:07:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ไม่มี', 'ไม่มี', 0),
(7, 'supanut', 'สอนเทคนิค', 'seminar', 3, 5, 200, 'webUpload/การพัฒนา AI/organizerUpload/p1.jpg,webUpload/การพัฒนา AI/organizerUpload/p2.jpg,webUpload/การพัฒนา AI/organizerUpload/p3.jpg,', 'webUpload/การพัฒนา AI/organizerUpload/ai.mp4', 'วิธีการเล่นที่ถูกวิธี', '2018-02-22 07:52:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ไม่มี', 'ไม่มี', 0);

-- --------------------------------------------------------

--
-- Table structure for table `eventmember`
--

CREATE TABLE `eventmember` (
  `noevent` smallint(6) NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `request_date_time` datetime NOT NULL,
  `join_date_time` datetime NOT NULL,
  `payment_path` text COLLATE utf8_unicode_ci NOT NULL,
  `pre_path` text COLLATE utf8_unicode_ci NOT NULL,
  `qrcode` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventmember`
--

INSERT INTO `eventmember` (`noevent`, `username`, `status`, `request_date_time`, `join_date_time`, `payment_path`, `pre_path`, `qrcode`) VALUES
(1, 'hello123', 'request', '2018-02-23 13:15:39', '0000-00-00 00:00:00', '', '', ''),
(1, 'supanut', 'accepted', '2018-02-23 10:07:12', '2018-02-23 10:07:12', '', '', ''),
(1, 'tammada', 'accepted', '2018-02-23 10:35:12', '2018-02-23 10:40:21', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `event_assessment`
--

CREATE TABLE `event_assessment` (
  `noevent` int(11) NOT NULL,
  `noassessment` tinyint(2) UNSIGNED NOT NULL,
  `answer` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `event_assessment`
--

INSERT INTO `event_assessment` (`noevent`, `noassessment`, `answer`) VALUES
(1, 1, 4),
(1, 2, 4),
(1, 3, 4),
(1, 4, 4),
(1, 5, 4),
(1, 6, 4),
(1, 7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `event_question`
--

CREATE TABLE `event_question` (
  `noevent` int(11) NOT NULL,
  `noquestion` int(11) NOT NULL,
  `question` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `notopic` int(10) UNSIGNED NOT NULL,
  `noevent` int(10) UNSIGNED NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `header` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`notopic`, `noevent`, `username`, `header`, `description`, `date_time`) VALUES
(1, 1, 'supanut', 'สอบถามปัญหาที่นี่', 'ลิสคำถามที่พบบ่อย', '2018-02-23 11:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `nolog` smallint(6) UNSIGNED NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `action` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`nolog`, `username`, `date_time`, `action`) VALUES
(1, 'suphawich', '2018-02-23 10:07:12', 'create event \"อบรมการใช้ภาษาจาวา\"'),
(2, 'tammada', '2018-02-23 10:35:12', 'request event \"อบรมการใช้ภาษาจาวา\"'),
(3, 'supanut', '2018-02-23 10:40:21', 'accepted username \"tammada\" event \"อบรมการใช้ภาษาจาวา\"'),
(4, 'supanut', '2018-02-23 11:38:17', 'create topic \"สอบถามปัญหาที่นี่\" event \"อบรมการใช้ภาษาจาวา\"'),
(5, 'tammada', '2018-02-23 11:52:25', 'create comment \"ความคิดเห็นที่1\" topic 2'),
(6, 'hello123', '2018-02-23 13:15:39', 'request event \"อบรมการใช้ภาษาจาวา\"');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`nocomment`,`notopic`),
  ADD KEY `notopic` (`notopic`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`noevent`);

--
-- Indexes for table `eventmember`
--
ALTER TABLE `eventmember`
  ADD PRIMARY KEY (`noevent`,`username`);

--
-- Indexes for table `event_assessment`
--
ALTER TABLE `event_assessment`
  ADD PRIMARY KEY (`noevent`,`noassessment`),
  ADD UNIQUE KEY `noassessment` (`noassessment`);

--
-- Indexes for table `event_question`
--
ALTER TABLE `event_question`
  ADD PRIMARY KEY (`noevent`,`noquestion`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`notopic`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`nolog`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `noevent` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `notopic` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `nolog` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
