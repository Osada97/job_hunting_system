-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 27, 2021 at 08:53 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobhunting2`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_cv`
--

DROP TABLE IF EXISTS `additional_cv`;
CREATE TABLE IF NOT EXISTS `additional_cv` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `chs_headings` varchar(255) NOT NULL,
  `chs_title` varchar(255) NOT NULL,
  `chs_date` varchar(255) NOT NULL,
  `chs_company` varchar(255) NOT NULL,
  `chs_description` varchar(500) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `fk_chs` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `additional_cv`
--

INSERT INTO `additional_cv` (`no`, `user_id`, `chs_headings`, `chs_title`, `chs_date`, `chs_company`, `chs_description`) VALUES
(11, 74, 'Two Year experience at cargiles', 'Lab Assistant ', '2016-09', 'cargiles ', 'cargiles cargilescargilescargilescargiles cargilescargilescargiles cargilescargiles '),
(13, 75, 'Two Year experience at cargiles', 'Lab Assistant ', '2018-02', 'cargiles ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ');

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

DROP TABLE IF EXISTS `awards`;
CREATE TABLE IF NOT EXISTS `awards` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `aw_title` varchar(255) DEFAULT NULL,
  `aw_institute` varchar(255) DEFAULT NULL,
  `aw_year` varchar(255) DEFAULT NULL,
  `aw_description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`no`),
  KEY `fk_aw` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`no`, `user_id`, `aw_title`, `aw_institute`, `aw_year`, `aw_description`) VALUES
(31, 76, 'BEst web Developer', 'ondev groups', '2018-02', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. '),
(32, 75, 'BEst web Developer', 'ondev groups', '2021-06', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ');

-- --------------------------------------------------------

--
-- Table structure for table `cv`
--

DROP TABLE IF EXISTS `cv`;
CREATE TABLE IF NOT EXISTS `cv` (
  `user_id` int(200) NOT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `birth_day` varchar(255) NOT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cv`
--

INSERT INTO `cv` (`user_id`, `first_name`, `last_name`, `title`, `description`, `email`, `phone_number`, `address`, `birth_day`, `is_deleted`) VALUES
(74, 'Supun', 'harshana', 'Student', 'My name is supun harshana.I am a undergraduate of Sri Lanka Rajarata university.', 'supunsk@gmail.com', '0711234567', 'Chirathma furniture,kandegedara rd,Hali-ela', '2020-10-21', 0),
(75, 'Osada', 'Manohara', NULL, NULL, 'osadamanohara55@gmail.com', '07768759450', 'Chirathma furniture,kandegedara rd,Hali-ela', '1997-08-17', 0),
(76, 'Osada', 'Manohara', 'Student', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ', 'osadamanohara@gmail.com', '07768759450', 'Chirathma furniture,kandegedara rd,Hali-ela', '2020-12-09', 0),
(77, 'tharindu', 'prabath', 'Student', '', 'tharindu@gmail.com', '0712030405', 'Chirathma furniture,kandegedara rd,Hali-ela', '2021-01-12', 0),
(83, 'Osada', 'Manohara', 'Student', '', 'osadamanohara555@gmail.com', '0768597090', 'Chirathma furniture,kandegedara rd,Hali-ela', '2021-01-06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `edu_title` varchar(255) DEFAULT NULL,
  `edu_year` varchar(255) DEFAULT NULL,
  `edu_institute` varchar(255) DEFAULT NULL,
  `edu_description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`no`),
  KEY `fk_edu` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`no`, `user_id`, `edu_title`, `edu_year`, `edu_institute`, `edu_description`) VALUES
(47, 74, 'Ordinary Level', '2013-12', 'Weyangoda Central', 'orem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellent'),
(48, 74, 'Advance Level', '2016-08', 'Weyangoda Central', 'orem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.orem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligu'),
(49, 76, 'Advance Level', '2019-06', 'Weyangoda Central', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. '),
(50, 75, 'Advance Level', '2020-07', 'Weyangoda Central', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. '),
(51, 75, 'Ordinary Level', '2018-02', 'Weyangoda Central', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. '),
(60, 83, 'Advance Level', '2021-03', 'Weyangoda Central', 'onknlk jbkjk njnlj cgvhv ');

-- --------------------------------------------------------

--
-- Table structure for table `job_ad`
--

DROP TABLE IF EXISTS `job_ad`;
CREATE TABLE IF NOT EXISTS `job_ad` (
  `ad_no` int(11) NOT NULL AUTO_INCREMENT,
  `company_registration_number` varchar(50) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `job_title` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `company_url` varchar(200) DEFAULT NULL,
  `location` varchar(300) DEFAULT NULL,
  `job_type` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `monthly_salary` varchar(100) DEFAULT NULL,
  `job_category` varchar(5000) DEFAULT NULL,
  `gender` varchar(30) DEFAULT NULL,
  `maximum_age` varchar(50) DEFAULT NULL,
  `minimum_age` varchar(50) DEFAULT NULL,
  `minimum_qualification` varchar(100) DEFAULT NULL,
  `qulification_level` varchar(100) DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `ad_time` datetime DEFAULT NULL,
  `expire_time` datetime(6) DEFAULT NULL,
  `is_expire` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ad_no`),
  KEY `job_ad_ibfk_1` (`company_registration_number`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_ad`
--

INSERT INTO `job_ad` (`ad_no`, `company_registration_number`, `company_name`, `job_title`, `email`, `company_url`, `location`, `job_type`, `phone_number`, `monthly_salary`, `job_category`, `gender`, `maximum_age`, `minimum_age`, `minimum_qualification`, `qulification_level`, `description`, `ad_time`, `expire_time`, `is_expire`, `active`, `is_delete`) VALUES
(34, 'CRN_001', 'Chirathma Furniture', 'Need Carpenter', 'chirathmafurniture@gmail.com', '', 'Badulla,Bandarawela', 'Full Time', '0552294959', '25000 - 50000', 'Carpentry/Woodwork/Furniture', 'male', '30', '20', '1 Year', 'no minimum qualification', '<p>à·€à¶ºà·ƒ 20à¶§ à¶±à·œà¶…à¶©à·” à¶¯à¶šà·Šà·‚ à·ƒà·šà·€à¶ºà¶šà·” à¶…à·€à·à·Š&zwj;à¶ºà¶ºà·’</p>\r\n', '2021-01-25 01:03:48', '2021-02-04 01:03:00.000000', 0, 1, 0),
(35, 'CRN_001', 'Chirathma Furniture', 'Need Cashier', 'chirathmafurniture@gmail.com', '', 'Badulla,Bandarawela', 'Full Time', '0552294959', '25000 - 50000', 'Cashier', 'any', '30', '20', '1 Year', 'a/l', '<h1><strong>à¶¸à·”à¶¯à¶½à·Š à¶…à¶ºà¶šà·à¶¸à·’ à¶…à·€à·à·Š&zwj;à¶ºà¶ºà·’&nbsp;</strong></h1>\r\n', '2021-01-25 01:06:31', '2021-02-01 01:05:00.000000', 0, 1, 0),
(36, 'CRN_001', 'Chirathma Furniture', 'Accountant', 'chirathmafurniture@gmail.com', '', 'Badulla,Bandarawela', 'Full Time', '0552294959', '50000 - 100000', 'Accounting/Finance/Auditing', 'any', '30', '20', '1 Year', 'degree', '<h2>We are looking for a suitable candidate for the above position to provide reasonable assurance over the effectiveness &amp; the consistency of the internal controls &amp; risk management mechanisms adopted by the process/Risk owners of Chirathma Group,</h2>\r\n', '2021-01-25 01:09:47', '2021-02-04 01:07:00.000000', 0, 1, 0),
(37, 'CRN_001', 'Chirathma Furniture', 'Need Seller', 'chirathmafurniture@gmail.com', '', 'Badulla,Bandarawela', 'Full Time', '0552294959', '50000 - 100000', 'Sales/Marketing/Merchandising', 'male', '30', '20', '1 Year', 'o/l', '<p><strong>A&nbsp;seller&nbsp;is responsible for initiating sales conversations and making the&nbsp;selling&nbsp;process easy for customers. They work in various settings, especially retail stores or service centers. A&nbsp;seller&#39;s&nbsp;job is to ask customers questions and recommend the best product based on their desires and needs</strong></p>\r\n', '2021-01-25 01:15:55', '2021-02-04 01:15:00.000000', 0, 1, 0),
(38, 'CRN_002', 'E & K  enterprises (pvt) lmt.', 'HELPERS', 'eshankulasinghe@gmail.com', '', 'Colombo 15', 'Full Time', '0778520847', '25000 - 50000', 'Hospitality/Tourism', 'male', '40', '20', '2 Years', 'o/l', '', '2021-01-25 01:28:45', '2021-01-31 01:28:00.000000', 0, 0, 0),
(39, 'CRN_002', 'E & K  enterprises (pvt) lmt.', 'Receptionist', 'eshankulasinghe@gmail.com', '', 'Colombo 15', 'Full Time', '0778520847', '50000 - 100000', 'Hospitality/Tourism', 'female', '25', '19', '1 Year', 'a/l', '', '2021-01-25 01:31:57', '2021-01-31 01:31:00.000000', 0, 0, 1),
(40, 'CRN_002', 'E & K  enterprises (pvt) lmt.', 'Accountant', 'eshankulasinghe@gmail.com', '', 'Colombo 15', 'Full Time', '0778520847', '100000 - 200000', 'Choose Category...', 'any', '50', '25', 'No Minimum Qualification', 'degree', '', '2021-01-25 01:33:53', '2021-01-31 01:33:00.000000', 0, 1, 0),
(41, 'CRN_002', 'E & K  enterprises (pvt) lmt.', 'Therapist', 'eshankulasinghe@gmail.com', '', 'Colombo 15', 'Part Time', '0778520847', '50000 - 100000', 'Hospitality/Tourism', 'any', '35', '20', '1 Year', 'no minimum qualification', '', '2021-01-25 01:37:40', '2021-01-31 01:37:00.000000', 0, 1, 0),
(42, 'CRN_002', 'E & K  enterprises (pvt) lmt.', 'Tour guide', 'eshankulasinghe@gmail.com', '', 'Colombo 15', 'Full Time', '0778520847', '100000 - 200000', 'Hospitality/Tourism', 'male', '35', '28', '2 Years', 'no minimum qualification', '', '2021-01-25 01:40:47', '2021-01-31 01:40:00.000000', 0, 1, 0),
(43, 'CRN_003', 'kumarasinghe delivery company', 'driver', 'kumarsinghedelivery@gmail.com', '', 'Anuradhapura', 'Full Time', '071456121', 'Not spacified', 'Driver/Chauffeur/Transport', 'male', '36', '18', 'no', 'no minimum qualification', '<p>get your opportunity&nbsp;</p>\r\n', '2021-01-25 01:48:51', '2021-01-02 01:00:00.000000', 0, 1, 0),
(44, 'CRN_003', 'kumarasinghe delivery company', 'manager', 'kumarsinghedelivery@gmail.com', '', 'Galenbindunuwewa', 'Full Time', '071456121', '25000 - 50000', 'Management/Analysts', 'male', '35', '25', '3 Years', 'degree', '<p>join with us</p>\r\n', '2021-01-25 01:51:30', '2021-01-02 01:50:00.000000', 1, 1, 0),
(45, 'CRN_003', 'kumarasinghe delivery company', 'officer', 'kumarsinghedelivery@gmail.com', '', 'Galenbindunuwewa', 'Full Time', '71456121', '25000 - 50000', 'Accounting/Finance/Auditing', 'any', '25', '18', '2 Years', 'o/l', '<p>join with us..&nbsp; please send your cv this email&nbsp;</p>\r\n\r\n<p>kumarsinghedelivery@gmail.com</p>\r\n', '2021-01-25 01:53:17', '2021-01-02 01:52:00.000000', 1, 1, 0),
(46, 'CRN_003', 'kumarasinghe delivery company', 'supervisor', 'kumarsinghedelivery@gmail.com', '', 'Anuradhapura', 'Full Time', '071456121', 'Up to 25000', 'Sales/Marketing/Merchandising', 'male', '27', '18', '2 Years', 'o/l', '<p>coming join with us ..........</p>\r\n\r\n<p>kumarsinghedelivery@gmail.com</p>\r\n', '2021-01-25 01:57:52', '2021-01-04 01:57:00.000000', 0, 1, 0),
(47, 'CRN_004', 'SK Solutions (pvt) Limited ', 'Need CEO', 'sksolutions.it@gmail.com', '', 'Gampaha', 'Full Time', '0332212236', '300000 - 400000', 'Management/Analysts', 'male', '40', '25', '3 Years', 'degree', '<p>Send your CVs soon as possible(limited time )&nbsp;</p>\r\n', '2021-01-25 02:10:10', '2021-02-16 02:09:00.000000', 0, 1, 0),
(48, 'CRN_004', 'SK Solutions (pvt) Limited ', 'Accountant', 'sksolutions.it@gmail.com', '', 'Gampaha', 'Full Time', '0332212236', '100000 - 200000', 'Accounting/Finance/Auditing', 'any', '30', '22', '2 Years', 'a/l', '', '2021-01-25 02:11:14', '2021-01-31 02:11:00.000000', 0, 1, 0),
(49, 'CRN_004', 'SK Solutions (pvt) Limited ', 'Need Graphic Designer', 'sksolutions.it@gmail.com', '', 'Gampaha', 'Full Time', '0332212236', 'Not spacified', 'IT/Software/Web/Database/QA', 'any', '30', '18', 'no', 'o/l', '', '2021-01-25 02:13:09', '2021-02-25 02:13:09.000000', 0, 1, 0),
(50, 'CRN_004', 'SK Solutions (pvt) Limited ', 'Need Data Entry Operator', 'sksolutions.it@gmail.com', '', 'Gampaha', 'Full Time', '0332212236', '25000 - 50000', 'Data Entry/Data Formatting/Type Setting', 'any', '30', '18', 'no', 'no minimum qualification', '', '2021-01-25 02:15:03', '2021-01-31 02:15:00.000000', 0, 1, 0),
(51, 'CRN_005', 'P&G Constructions (pvt) Limited', 'Need Manager', 'p&gconstructions@gmail.com', '', 'Balangoda', 'Full Time', '0767178203', '200000 - 300000', 'Management/Analysts', 'male', '30', '25', '3 Years', 'degree', '', '2021-01-25 02:20:48', '2021-01-31 02:20:00.000000', 0, 1, 0),
(52, 'CRN_005', 'P&G Constructions (pvt) Limited', 'Need Technical Officer', 'p&gconstructions@gmail.com', '', 'Balangoda', 'Full Time', '0767178203', '50000 - 100000', 'Construction/Civil Engineering/QS', 'male', '30', '20', '2 Years', 'a/l', '', '2021-01-25 02:22:26', '2021-02-08 02:22:00.000000', 0, 1, 0),
(53, 'CRN_005', 'P&G Constructions (pvt) Limited', 'Need Receptionist ', 'p&gconstructions@gmail.com', '', 'Balangoda', 'Full Time', '0767178203', '50000 - 100000', 'Office Admin/Secretarial/Receptionist', 'female', '25', '18', 'No Minimum Qualification', 'no minimum qualification', '', '2021-01-25 02:24:35', '2021-01-31 02:24:00.000000', 0, 1, 0),
(54, 'CRN_005', 'P&G Constructions (pvt) Limited', 'Need Civil Engineer', 'p&gconstructions@gmail.com', '', 'Balangoda', 'Full Time', '0767178203', '100000 - 200000', 'Engineering', 'male', '35', '30', '5 Years', 'degree', '', '2021-01-25 02:26:33', '2021-01-31 02:26:00.000000', 0, 1, 0),
(55, 'CRN_005', 'P&G Constructions (pvt) Limited', 'Need security officer', 'p&gconstructions@gmail.com', '', 'Balangoda', 'Full Time', '0767178203', '25000 - 50000', 'Security', 'male', '35', '25', '2 Years', 'o/l', '', '2021-01-25 02:27:55', '2021-01-31 02:27:00.000000', 0, 1, 0),
(56, 'CRN_006', 'Dilini Audit firm', 'Accountant', 'diliniafirm@gmail.com', '', 'Kegalle', 'Full Time', '0719671229', '25000 - 50000', 'Accounting/Finance/Auditing', 'any', '35', '22', '1 Year', 'degree', '<h3><strong>An&nbsp;<em>accountant</em>&nbsp;is a practitioner of accounting or accountancy.&nbsp;<em>Accountants</em>&nbsp;who have demonstrated competency through their professional associations</strong></h3>\r\n', '2021-01-25 11:03:49', '2021-02-04 11:03:00.000000', 0, 1, 0),
(57, 'CRN_006', 'Dilini Audit firm', 'Need Labor ', 'diliniafirm@gmail.com', '', 'Kegalle', 'Full Time', '0719671229', 'Up to 25000', 'Mason/Plumber/Helper', 'any', '30', '20', 'no', 'no minimum qualification', '<p><strong>We need labor for work our company&nbsp;</strong></p>\r\n', '2021-01-25 11:06:34', '2021-02-06 02:05:00.000000', 0, 1, 0),
(58, 'CRN_007', 'On Dev', 'Accountant', 'ondev@gmail.com', '', 'Badulla,Bandarawela', 'Full Time', '768597090', '25000 - 50000', 'Accounting/Finance/Auditing', 'any', '30', '20', '1 Year', 'degree', '<p>asd asd as adsgaas asg asf aer et dafsf asf as</p>\r\n', '2021-01-26 03:07:49', '2021-03-12 05:07:00.000000', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `job_apply`
--

DROP TABLE IF EXISTS `job_apply`;
CREATE TABLE IF NOT EXISTS `job_apply` (
  `apply_no` int(11) NOT NULL AUTO_INCREMENT,
  `seeker_id` int(100) NOT NULL,
  `provider_id` varchar(100) NOT NULL,
  `ad_no` int(100) NOT NULL,
  PRIMARY KEY (`apply_no`),
  KEY `fk_job_ad` (`ad_no`),
  KEY `fk_provider_id` (`provider_id`),
  KEY `fk_seeker_id` (`seeker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_apply`
--

INSERT INTO `job_apply` (`apply_no`, `seeker_id`, `provider_id`, `ad_no`) VALUES
(117, 75, 'CRN_007', 58),
(120, 83, 'CRN_006', 57),
(121, 83, 'CRN_001', 34);

-- --------------------------------------------------------

--
-- Table structure for table `professional_skills`
--

DROP TABLE IF EXISTS `professional_skills`;
CREATE TABLE IF NOT EXISTS `professional_skills` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `percentage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`no`),
  KEY `fk_ps` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `professional_skills`
--

INSERT INTO `professional_skills` (`no`, `user_id`, `title`, `percentage`) VALUES
(51, 74, 'JAVA', '46'),
(52, 74, 'C', '64'),
(53, 74, 'C++', '78'),
(54, 74, 'c#', '100'),
(55, 76, 'JAVA', '34'),
(56, 76, 'JS', '72'),
(57, 76, 'PHP', '43'),
(58, 75, 'JAVA', '60'),
(59, 75, 'js', '83'),
(60, 75, 'php', '62'),
(61, 75, 'JAVA', '37'),
(62, 77, '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

DROP TABLE IF EXISTS `provider`;
CREATE TABLE IF NOT EXISTS `provider` (
  `company_name` varchar(50) DEFAULT NULL,
  `company_registration_number` varchar(50) NOT NULL,
  `company_email` varchar(50) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `company_phone_number` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `date_of_founded` varchar(50) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `company_website` varchar(500) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `linked_in` varchar(100) DEFAULT NULL,
  `is_image` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`company_registration_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`company_name`, `company_registration_number`, `company_email`, `address`, `company_phone_number`, `password`, `date_of_founded`, `description`, `company_website`, `facebook`, `twitter`, `linked_in`, `is_image`, `is_deleted`) VALUES
('Chirathma Furniture', 'CRN_001', 'chirathmafurniture@gmail.com', 'Chirathma furniture,kandegedara rd,Hali-ela', '0552294959', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1996-06-25', '', '', '', '', NULL, 1, 0),
('E & K  enterprises (pvt) lmt.', 'CRN_002', 'eshankulasinghe@gmail.com', 'No,302/ colombo 15.', '0778520847', '5df7d0461105432a838f8745d52c19873cdbcda8', '2018-02-07', '', '', 'E &  K  ENTERPRISES', 'Eshan kulasinghe', NULL, 1, 0),
('kumarasinghe delivery company', 'CRN_003', 'kumarsinghedelivery@gmail.com', NULL, '071456121', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
('SK Solutions (pvt) Limited ', 'CRN_004', 'sksolutions.it@gmail.com', 'No123, airport rd,  gampaha', '0332212236', '8cb2237d0679ca88db6464eac60da96345513964', '2018-06-25', '', '', 'SK Solutions', '', NULL, 1, 0),
('P&G Constructions (pvt) Limited', 'CRN_005', 'p&gconstructions@gmail.com', NULL, '0767178203', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
('Dilini Audit firm', 'CRN_006', 'diliniafirm@gmail.com', NULL, '0719671229', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
('On Dev', 'CRN_007', 'ondev@gmail.com', 'Chirathma furniture,kandegedara rd,Hali-ela', '0768597090', '8cb2237d0679ca88db6464eac60da96345513964', '2021-01-26', '', '', '', '', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pwdreset`
--

DROP TABLE IF EXISTS `pwdreset`;
CREATE TABLE IF NOT EXISTS `pwdreset` (
  `pwdResetId` int(11) NOT NULL AUTO_INCREMENT,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpire` text NOT NULL,
  PRIMARY KEY (`pwdResetId`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seeker`
--

DROP TABLE IF EXISTS `seeker`;
CREATE TABLE IF NOT EXISTS `seeker` (
  `seeker_id` int(255) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `qualification` varchar(200) NOT NULL DEFAULT 'no',
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_image` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`seeker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seeker`
--

INSERT INTO `seeker` (`seeker_id`, `first_name`, `last_name`, `username`, `qualification`, `email`, `phone_number`, `password`, `is_image`, `is_deleted`) VALUES
(74, 'Supun', 'harshana', 'Supun_h', 'no minimum qualification', 'supunsk@gmail.com', '0711234567', '8cb2237d0679ca88db6464eac60da96345513964', 1, 0),
(75, 'Osada', 'Manohara', 'Ozka', 'degree', 'osadamanohara55@gmail.com', '07768759450', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(77, 'tharindu', 'prabath', 'tharindu_h', 'no', 'tharindu@gmail.com', '0712030405', '8cb2237d0679ca88db6464eac60da96345513964', 0, 0),
(83, 'Osada', 'Manohara', 'Ozka', 'no minimum qualification', 'osadamanohara555@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sh_media`
--

DROP TABLE IF EXISTS `sh_media`;
CREATE TABLE IF NOT EXISTS `sh_media` (
  `user_id` int(11) NOT NULL,
  `linked_in` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `git_hub` varchar(255) NOT NULL,
  KEY `fk_shm` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sh_media`
--

INSERT INTO `sh_media` (`user_id`, `linked_in`, `facebook`, `twitter`, `git_hub`) VALUES
(74, '', 'Supun Harashna', '', ''),
(75, 'osada_97', 'osada manohara', '', 'osada_97'),
(76, '', '', '', ''),
(77, '', '', '', ''),
(83, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `work_experience`
--

DROP TABLE IF EXISTS `work_experience`;
CREATE TABLE IF NOT EXISTS `work_experience` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `wk_title` varchar(255) DEFAULT NULL,
  `wk_company` varchar(255) DEFAULT NULL,
  `wk_years` varchar(255) DEFAULT NULL,
  `wk_description` varchar(2555) DEFAULT NULL,
  PRIMARY KEY (`no`),
  KEY `fk_we` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `work_experience`
--

INSERT INTO `work_experience` (`no`, `user_id`, `wk_title`, `wk_company`, `wk_years`, `wk_description`) VALUES
(36, 76, 'Teacher', 'Bdulla Central College', '2019-06', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. '),
(37, 75, 'Teacher', 'Bdulla Central College', '2020-07', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. '),
(44, 83, 'Teacher', 'Bdulla Central College', '2020-11', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_cv`
--
ALTER TABLE `additional_cv`
  ADD CONSTRAINT `fk_chs` FOREIGN KEY (`user_id`) REFERENCES `seeker` (`seeker_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `fk_aw` FOREIGN KEY (`user_id`) REFERENCES `cv` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `fk_edu` FOREIGN KEY (`user_id`) REFERENCES `cv` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_ad`
--
ALTER TABLE `job_ad`
  ADD CONSTRAINT `job_ad_ibfk_1` FOREIGN KEY (`company_registration_number`) REFERENCES `provider` (`company_registration_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_apply`
--
ALTER TABLE `job_apply`
  ADD CONSTRAINT `fk_job_ad` FOREIGN KEY (`ad_no`) REFERENCES `job_ad` (`ad_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_provider_id` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`company_registration_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seeker_id` FOREIGN KEY (`seeker_id`) REFERENCES `seeker` (`seeker_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professional_skills`
--
ALTER TABLE `professional_skills`
  ADD CONSTRAINT `fk_ps` FOREIGN KEY (`user_id`) REFERENCES `cv` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sh_media`
--
ALTER TABLE `sh_media`
  ADD CONSTRAINT `fk_shm` FOREIGN KEY (`user_id`) REFERENCES `cv` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `work_experience`
--
ALTER TABLE `work_experience`
  ADD CONSTRAINT `fk_we` FOREIGN KEY (`user_id`) REFERENCES `cv` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
