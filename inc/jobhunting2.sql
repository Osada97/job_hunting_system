-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 29, 2020 at 08:35 PM
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
  `chs_description` varchar(255) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `fk_chs` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `additional_cv`
--

INSERT INTO `additional_cv` (`no`, `user_id`, `chs_headings`, `chs_title`, `chs_date`, `chs_company`, `chs_description`) VALUES
(10, 70, 'Sports', 'Badminton', '2018-06', 'Vishala Girls High School Badulla ', 'lreon iasdas asdasjn asdasd adasklda asdasdasnd kmnaskd asd adoiwnfa dasdamsklda daksdnas dasdasd a sdaskl alsdasd adnaklsdasd');

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`no`, `user_id`, `aw_title`, `aw_institute`, `aw_year`, `aw_description`) VALUES
(24, 62, 'osada', 'asdsa', '2020-05', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse'),
(25, 62, 'mano', 'asdasdasd', '2020-01', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse'),
(28, 66, 'Elle', 'club', '2017-03', ''),
(29, 67, 'welder champine', 'welder sadana', '2019-01', ''),
(30, 70, 'Beast IT student in District', 'Vishaka Girls College', '2016-01', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. In incidunt expedita dolorum veniam eveniet temporibus esse unde cumque molestiae ut rerum numquam cum quo dolorem quod, dignissimos, quam iste');

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
(4, '', '', '', '', '', '', '', '', 0),
(5, 'Ilmina', 'Malshan', '', '', 'ilminamalshan@gmail.com', '0768484968', '', '', 0),
(32, 'Ilmina', 'Malshan', NULL, NULL, 'sumanasirirathnayake@gmail.com', '0768484968', 'chirthma furniture,kandegedara road,keeriyagolla,haliela.', '', 0),
(33, 'osada manohara ', 'rathnayake', 'student', '', 'osadamanohara55@gmail.com', '0768597090', 'chirthma furniture,kandegedara road,keeriyagolla,haliela.', '2020-09-03', 0),
(34, 'osada', 'Manohara', 'student', '<p>I am Build This Site</p>', 'osadamanohara56@gmail.com', '0768597090', 'chirthma furniture,kandegedara road,keeriyagolla,haliela.', '', 0),
(35, 'Dipika', 'Amarathuna', '', '', 'dipika12@gmail.com', '0768484968', 'chirthma furniture,kandegedara road,keeriyagolla,haliela.', '', 0),
(36, '', 'Chumini', '', '', 'prasdikachathumini@gmail.com', '0715685369', 'lahiru niwesa,ekanayaka mawathe,haliela.', '', 0),
(49, 'sumanasiri', 'rathnayake', '', '', 'sumanasirirathnayake55@gmail.com', '0712871409', 'chirthma furniture,kandegedara road,keeriyagolla,haliela.', '', 0),
(50, 'Osada', 'Manohara', 'student', '', 'osadamanohara@gmail.com', '0768597090', '', '', 0),
(51, 'Osada', 'Manohara', 'student', '<p><strong>I am Osada</strong></p>', 'osadamanohara57@gmail.com', '0552294959 ', 'chirthma furniture,kandegedara road,keeriyagolla,haliela.', '', 0),
(59, 'Prasadika', 'Chumini', 'student', '', 'prasadikachathumini55@gmail.com', '0768597090', 'lahiru niwesa,ekanayaka mawathe,haliela.', '', 0),
(60, 'Prasadika', 'Chumini', 'student', '', 'prasadikachathumini56@gmail.com', '0768597090', 'lahiru niwesa,ekanayaka mawathe,haliela.', '', 0),
(62, 'Osada', 'Manohara', 'student', 'Osada Manohara Is a Good Person\r\n\r\nOsada Manohara Is a Good Person', 'osadamanohara5@gmail.com', '0768597090', 'sad', '2020-09-17', 0),
(63, 'Osada', 'Manohara', NULL, NULL, 'osadamanohara555@gmail.com', '0768597090', 'Chirathma Furniture,kandegedara road,hali-ela,badulla', '2020-09-16', 0),
(64, 'navod', 'navod', 'Student ', 'I am a graphic designer', 'navodnirmal@gmail.com', '0703134569', 'zero Furniture,', '2020-03-13', 0),
(65, 'Supun', 'Harshana', 'student', '', 'supunharshana@gmail.com', '0711234567', 'gurullagama,mirigama,sri lanka', '1997-06-07', 0),
(66, 'praveen', 'thakasara', 'student', '', 'magagepraveen@gmail.com', '0779551097', '151/b,narangahahena,ampegama.', '1997-12-07', 0),
(67, 'malshan', 'mihiranga', 'student', '', 'malshanmihiranga97@gmail.com', '0789867566', '1084/1m,K.A.perera road,Malabe', '1997-11-22', 0),
(70, 'Prasadika', 'Chathumini', 'student', 'studentstudentstudentstudentstudentstudentstudentstudentstudentstudentstudent', 'prasadika@gmail.com', '0115602560', 'chirathma,kandegedara,haliela', '2020-10-01', 0);

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
  `edu_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`no`),
  KEY `fk_edu` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`no`, `user_id`, `edu_title`, `edu_year`, `edu_institute`, `edu_description`) VALUES
(37, 62, 'o/l', '2020-03', '456', 'ijo'),
(38, 62, 'o/l', '2020-09', 'Rajarata University  Of Sri Lanka', 'opjpopm  mpo  pokpokp[k'),
(39, 64, 'graphic designer', '2020-07', '', ''),
(40, 65, 'o/l', '2013-12', 'Veyangoda Central College', ''),
(41, 66, 'o/l', '2013-02', 'kularathna collage', ''),
(42, 66, 'a/l', '2016-02', 'batapoloa central collage', ''),
(43, 67, 'o/l', '2016-08', 'Sadana', ''),
(44, 33, 'o/l', '2020-06', 'Dharmadutha college', 'sacscsa'),
(45, 70, 'o/l', '2017-08', 'Badulla Vishaka Maha Vidyalaya', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. In incidunt expedita dolorum veniam eveniet temporibus esse unde cumque molestiae ut rerum numquam cum quo dolorem quod, dignissimos, quam iste'),
(46, 70, 'A/l', '2017-08', 'Badulla vishaka maha vidyalaya', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. In incidunt expedita dolorum veniam eveniet temporibus esse unde cumque molestiae ut rerum numquam cum quo dolorem quod, dignissimos, quam iste aut.');

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_ad`
--

INSERT INTO `job_ad` (`ad_no`, `company_registration_number`, `company_name`, `job_title`, `email`, `company_url`, `location`, `job_type`, `phone_number`, `monthly_salary`, `job_category`, `gender`, `maximum_age`, `minimum_age`, `minimum_qualification`, `qulification_level`, `description`, `ad_time`, `expire_time`, `is_expire`, `active`, `is_delete`) VALUES
(3, 'sadasda', '', 'afsad', 'sdadasdas', NULL, 'asdsad', 'asdasd', 'asdsad', 'asdasd', 'Customer Support/Call Centre', 'asdasd', '342', '32432', 'asdsad', '', 'sdsad', NULL, NULL, 1, 1, 0),
(6, 'HE001', 'Chirathma Furniture', 'sa', 'chirathmafurniture@gmail.com', NULL, 'Ahungalla', 'Full Time', '0552294959', '100000 - 200000', 'Consultancy/Coordination', 'any', '34', '35', '3 Years', '', 'sad', NULL, NULL, 0, 1, 0),
(8, 'HE001', 'Chirathma Furniture', 'sa', 'chirathmafurniture@gmail.com', NULL, 'Ahungalla', 'Contract', '0552294959', '50000 - 100000', 'Driver/Chauffeur/Transport', 'male', '34', '31', 'no', '', '', NULL, NULL, 0, 1, 0),
(9, 'HE001', 'Chirathma Furniture', 'sa', 'chirathmafurniture@gmail.com', NULL, 'Akurana,Akuressa', 'Full Time', '0552294959', '100000 - 200000', 'Carpentry/Woodwork/Furniture', 'male', '32', 'no', '5 Years', '', '', NULL, NULL, 0, 1, 0),
(10, 'HE001', 'Chirathma Furniture', 'Need Carpenter', 'chirathmafurniture@gmail.com', NULL, 'Badulla,Hali-ela', 'Full Time', '0552294959', '25000 - 50000', 'Other', 'female', '46', '23', 'degree', '', '<p>à¶´à·”à·„à·”à¶±à·” à·„à· à¶±à·”à¶´à·”à·„à·”à¶±à·” à·€à¶©à·” à¶šà·à¶»à·Šà¶¸à·’à¶š à·à·’à¶½à·Šà¶´à·’à¶ºà·™à¶šà·Š à¶…à·€à·à·Š&zwj;à¶ºà¶ºà·’.</p>\r\n\r\n<ul>\r\n	<li>à¶¸à·à·„à·’à¶š à¶œà·™à·€à·“à¶¸à·Š.</li>\r\n</ul>\r\n', NULL, NULL, 0, 1, 0),
(11, 'HE001', 'Chirathma Furniture', 'Need Carpenter', 'chirathmafurniture@gmail.com', '', 'colombo', 'Full Time', '552294959', '25000 - 50000', 'Other', 'male', '46', '23', 'no', '', '<p>à¶´à·”à·„à·”à¶±à·” à·„à· à¶±à·”à¶´à·”à·„à·”à¶±à·” à·€à¶©à·” à¶šà·à¶»à·Šà¶¸à·’à¶š à·à·’à¶½à·Šà¶´à·’à¶ºà·™à¶šà·Š à¶…à·€à·à·Š&zwj;à¶ºà¶ºà·’.</p>\r\n\r\n<ul>\r\n	<li>à¶¸à·à·„à·’à¶š à¶œà·™à·€à·“à¶¸à·Š.</li>\r\n</ul>\r\n', NULL, NULL, 1, 1, 0),
(12, 'HE001', 'Chirathma Furniture', 'Need Carpenter', 'chirathmafurniture@gmail.com', NULL, 'Badulla,Hali-ela', 'Full Time', '0552294959', '25000 - 50000', 'Other', 'male', '46', '23', 'no', '', '<p>à¶´à·”à·„à·”à¶±à·” à·„à· à¶±à·”à¶´à·”à·„à·”à¶±à·” à·€à¶©à·” à¶šà·à¶»à·Šà¶¸à·’à¶š à·à·’à¶½à·Šà¶´à·’à¶ºà·™à¶šà·Š à¶…à·€à·à·Š&zwj;à¶ºà¶ºà·’.</p>\r\n\r\n<ul>\r\n	<li>à¶¸à·à·„à·’à¶š à¶œà·™à·€à·“à¶¸à·Š.</li>\r\n</ul>\r\n', '2020-04-03 13:53:08', NULL, 1, 1, 0),
(13, 'HE001', 'Chirathma Furniture', 'Need Carpenter', 'chirathmafurniture@gmail.com', NULL, 'Badulla,Hali-ela', 'Full Time', '0552294959', '25000 - 50000', 'Other', 'male', '46', '23', 'no', '', '<p>à¶´à·”à·„à·”à¶±à·” à·„à· à¶±à·”à¶´à·”à·„à·”à¶±à·” à·€à¶©à·” à¶šà·à¶»à·Šà¶¸à·’à¶š à·à·’à¶½à·Šà¶´à·’à¶ºà·™à¶šà·Š à¶…à·€à·à·Š&zwj;à¶ºà¶ºà·’.</p>\r\n\r\n<ul>\r\n	<li>à¶¸à·à·„à·’à¶š à¶œà·™à·€à·“à¶¸à·Š.</li>\r\n</ul>\r\n', '2020-04-03 14:05:16', NULL, 0, 1, 0),
(14, 'HE001', 'Chirathma Furniture', 'Sales ref position', 'chirathmafurniture@gmail.com', '', 'Badulla,Bandarawela,Diyathalawa,Ella,Hali-ela,Haputale,Passara,Welimada', 'Full Time', '552294959', '25000 - 50000', 'Sales/Marketing/Merchandising', 'male', '24', '40', 'no', 'o/l', '', '2020-04-02 23:09:11', NULL, 1, 1, 0),
(15, 'HE001', 'Chirathma Furniture', 'Sales ref position', 'chirathmafurniture@gmail.com', NULL, 'Badulla,Bandarawela,Diyathalawa,Ella,Hali-ela,Haputale,Passara,Welimada', 'Full Time', '0552294959', '25000 - 50000', 'Sales/Marketing/Merchandising', 'male', '24', '40', 'no', 'o/l', '', '2020-04-02 23:19:59', NULL, 1, 1, 0),
(16, 'HE002', 'DE Com', 'Need Web devoloper', 'osadamanohara56@gmail.com', NULL, 'Badulla', 'Full Time', '0552294959', '50000 - 100000', 'IT/Programming', 'any', '40', 'No Minimum Age', 'no', '', '', '2020-04-03 14:43:59', NULL, 1, 1, 0),
(17, 'HE001', 'Chirathma Furniture', 'Sales ref position', 'chirathmafurniture@gmail.com', NULL, 'Badulla,mahiyangana', 'Full Time', '0552294959', 'not_spacified', 'Sales/Marketing/Merchandising', 'male', 'No Maximum Age', 'No Minimum Age', 'no', '', '', '2020-04-03 17:11:53', NULL, 1, 1, 0),
(18, 'HE001', 'Chirathma Furniture', 'Need Carpenter', 'chirathmafurniture@gmail.com', NULL, 'Badulla,Hali-ela', 'Full Time', '0552294959', '25000 - 50000', 'Carpentry/Woodwork/Furniture', 'male', '50', 'No Minimum Age', 'no', 'degree', '', '2020-04-03 17:42:28', NULL, 0, 1, 1),
(19, 'HE001', 'Chirathma Furniture', 'Need Carpenter', 'chirathmafurniture@gmail.com', 'https://www.chirathma.com', 'Badulla', 'Part Time', '552294959', 'Up to 25000', 'Driver/Chauffeur/Transport', 'male', '33', '47', '5 Years', 'no minimum qualification', '<p>à¶´à·”à·„à·”à¶±à·” à·à·Š&zwj;à¶»à¶¸à·’à¶šà¶ºà¶šà·” à¶…à·€à·‚à·Š&zwj;à¶ºà¶ºà·’.</p>\r\n\r\n<p>&nbsp;</p>\r\n', '2020-04-03 20:29:36', '2020-10-23 00:58:00.000000', 0, 1, 0),
(20, 'HE002', 'DE Com', 'Need SE', 'osadamanohara56@gmail.com', 'https://www.Decom.com', 'Badulla,Colombo 01', 'Full Time', '0552205698', '100000 - 200000', 'IT/Programming', 'any', '44', '20', '2 Years', 'degree', '', '2020-04-05 00:07:35', NULL, 0, 1, 1),
(21, 'HE003', 'DOT COM', 'Web Developers', 'osadamanohara55@gmail.com', 'https://www.Dotcpm.com', 'Colombo All', 'Internship', '5526522658', 'Up to 25000', 'IT/Software/Web/Database/QA', 'any', '34', '22', 'no', 'a/l', '<p><strong>Need Web Developer To our New Company. And we give a Chance to university Students Who are looking for an internship.</strong></p>\r\n', '2020-04-10 18:03:22', NULL, 0, 1, 1),
(22, 'HE001', 'Chirathma Furniture', 'Need Carpenter', 'chirathmafurniture@gmail.com', 'www.chirathma.com', 'Agunukolapelessa,Ahungalla', 'Full Time', '552294959', 'Not spacified', 'Automotive/Aviation', 'male', '30', '28', '3 Years', 'no minimum qualification', '', '2020-09-07 21:45:47', '2020-10-24 23:16:00.000000', 0, 1, 0),
(23, '069', 'zero designer', 'web designer', 'navodnirmal@gmail.comn', '', 'Agunukolapelessa', 'Full Time', '070121223231', 'Not spacified', 'Choose Category...', 'male', '34', 'No Minimum Age', 'No Minimum Qualification', 'no minimum qualification', '', '2020-09-07 22:19:57', NULL, 0, 1, 0),
(24, 'S2D-01', 'S2D Tech Solutions', 'Game Designer', 's2dtech@gmail.com', 'https://www.s2dtechsolutions.com', 'Anuradhapura,Gampaha,Negombo', 'Full Time', '3332212345', '100000 - 200000', 'IT/Programming', 'any', '35', '25', '3 Years', 'degree', '', '2020-09-07 22:33:54', '2020-12-04 02:48:00.000000', 0, 1, 0),
(25, 'H2435', 'children fashoin house', 'need counter', 'magagepraveen@gmail.com', '', 'Baddegama', 'Full Time', '0779551097', 'Not spacified', 'Accounting/Finance/Auditing', 'female', '25', '18', 'No Minimum Qualification', 'no minimum qualification', '<p>à¶´à·”à·„à·”à¶±à·” à·ƒà·šà·€à·’à¶šà·à·€à·à¶±à·Š à¶…à·€à·à·Š&zwj;à¶ºà¶ºà·’</p>\r\n', '2020-09-07 22:48:33', NULL, 1, 1, 0),
(26, 'HE0033', 'welder abc company', 'welder', 'malshanmihiranga@gmail.com', '', 'Colombo 13', 'Full Time', '0789588425', 'Not spacified', 'Choose Category...', 'any', 'No Maximum Age', 'No Minimum Age', 'No Minimum Qualification', 'degree', '', '2020-09-07 23:07:59', NULL, 1, 1, 0),
(27, 'HE001', 'Chirathma Furniture', 'Need Web Developer', 'chirathmafurniture@gmail.com', 'www.chirathma.com', 'Colombo 01', 'Full Time', '552294959', '50000 - 100000', 'IT/Programming', 'male', '28', '20', '1 Year', 'degree', '<p>Lorem&nbsp;ipsum&nbsp;dolor&nbsp;sit,&nbsp;amet&nbsp;consectetur&nbsp;adipisicing&nbsp;elit.&nbsp;Illo&nbsp;molestias,&nbsp;eveniet&nbsp;eaque&nbsp;voluptas&nbsp;magnam&nbsp;totam&nbsp;libero&nbsp;explicabo&nbsp;distinctio&nbsp;laudantium&nbsp;corporis?&nbsp;Veniam&nbsp;animi&nbsp;labore&nbsp;voluptatibus&nbsp;omnis?&nbsp;Recusandae&nbsp;debitis&nbsp;eos&nbsp;magnam&nbsp;nemo?Lorem&nbsp;ipsum&nbsp;dolor&nbsp;sit,&nbsp;amet&nbsp;consectetur&nbsp;adipisicing&nbsp;elit.&nbsp;Illo&nbsp;molestias,&nbsp;eveniet&nbsp;eaque&nbsp;voluptas&nbsp;magnam&nbsp;totam&nbsp;libero&nbsp;explicabo&nbsp;distinctio&nbsp;laudantium&nbsp;corporis?&nbsp;Veniam&nbsp;animi&nbsp;labore&nbsp;voluptatibus&nbsp;omnis?&nbsp;Recusandae&nbsp;debitis&nbsp;eos&nbsp;magnam&nbsp;nemo?Lorem&nbsp;ipsum&nbsp;dolor&nbsp;sit,&nbsp;amet&nbsp;consectetur&nbsp;adipisicing&nbsp;elit.&nbsp;Illo&nbsp;molestias,&nbsp;eveniet&nbsp;eaque&nbsp;voluptas&nbsp;magnam&nbsp;totam&nbsp;libero&nbsp;explicabo&nbsp;distinctio&nbsp;laudantium&nbsp;corporis?&nbsp;Veniam&nbsp;animi&nbsp;labore&nbsp;voluptatibus&nbsp;omnis?&nbsp;Recusandae&nbsp;debitis&nbsp;eos&nbsp;magnam&nbsp;nemo?Lorem&nbsp;ipsum&nbsp;dolor&nbsp;sit,&nbsp;amet&nbsp;consectetur&nbsp;adipisicing&nbsp;elit.&nbsp;Illo&nbsp;molestias,&nbsp;eveniet&nbsp;eaque&nbsp;voluptas&nbsp;magnam&nbsp;totam&nbsp;libero&nbsp;explicabo&nbsp;distinctio&nbsp;laudantium&nbsp;corporis?&nbsp;Veniam&nbsp;animi&nbsp;labore&nbsp;voluptatibus&nbsp;omnis?&nbsp;Recusandae&nbsp;debitis&nbsp;eos&nbsp;magnam&nbsp;nemo?</p>\r\n\r\n<p>&nbsp;</p>\r\n', '2020-10-21 17:43:22', '2020-10-23 17:42:00.000000', 1, 1, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_apply`
--

INSERT INTO `job_apply` (`apply_no`, `seeker_id`, `provider_id`, `ad_no`) VALUES
(20, 34, 'HE002', 20),
(22, 34, 'HE001', 18),
(25, 35, 'HE001', 18),
(26, 35, 'HE002', 20),
(28, 35, 'HE001', 17),
(29, 35, 'HE001', 15),
(31, 35, 'HE002', 16),
(32, 35, 'HE001', 19),
(34, 34, 'HE001', 19),
(35, 34, 'HE002', 16),
(36, 34, 'HE001', 15),
(38, 36, 'HE002', 20),
(40, 50, 'HE001', 19),
(54, 33, 'HE001', 9),
(63, 51, 'HE002', 16),
(67, 51, 'HE003', 21),
(77, 33, 'HE003', 21),
(78, 33, 'HE001', 13),
(81, 34, 'HE001', 17),
(83, 33, 'HE001', 19),
(84, 33, 'HE001', 11),
(86, 33, 'HE002', 20),
(88, 33, 'HE002', 16),
(99, 62, 'HE002', 20),
(101, 62, 'HE001', 19),
(102, 62, 'HE001', 17),
(103, 62, 'HE001', 22),
(105, 62, 'HE001', 13),
(107, 33, 'H2435', 25);

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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `professional_skills`
--

INSERT INTO `professional_skills` (`no`, `user_id`, `title`, `percentage`) VALUES
(30, 62, 'laravel live wire', '65'),
(31, 62, 'student', '27'),
(32, 62, 'student', '76'),
(33, 62, 'student', '18'),
(37, 62, 'peo laravel', '8'),
(38, 64, '', '0'),
(39, 65, 'game design', '50'),
(40, 66, 'html', '51'),
(41, 67, 'welder', '81'),
(49, 70, 'English', '51'),
(50, 70, 'Sinhala ', '94');

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
('zero designer', '069', 'navodnirmal@gmail.comn', NULL, '070121223231', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
('children fashoin house', 'H2435', 'magagepraveen@gmail.com', NULL, '0779551097', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
('Chirathma Furniture', 'HE001', 'chirathmafurniture@gmail.com', 'chirthma furniture,kandegedara road,keeriyagolla,haliela.', '0552294959', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2020-03-02', '<p>We are Best Furniture manufactures in the Badulla area. And we are manufacturing TV STANDS, TABLES, COURBDS, etc....And we are manufacturing furniture that customers request</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'www.chirathma.com', 'chirathma', 'as', 'as', 1, 0),
('DE Com', 'HE002', 'osadamanohara56@gmail.com', 'DE com,kandegedara road,keeriyagolla,haliela.', '0552294959', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2020-04-02', '', '', '', '', NULL, 1, 0),
('DOT COM', 'HE003', 'osadamanohara55@gmail.com', 'sdasad', '05526522658', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1),
('welder abc company', 'HE0033', 'malshanmihiranga@gmail.com', NULL, '0789588425', 'b7b975da6a95a9e891efad76d30b43b75a267911', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
('test', 'he005', 'osadamanohara78@gmail.com', NULL, '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
('OnDevs', 'HE010', 'ondevtech@gmail.com', NULL, '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
('S2D Tech Solutions', 'S2D-01', 's2dtech@gmail.com', NULL, '03332212345', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
('sadasd', 'sadasda', 'sadasd', NULL, 'asdasda', 'asda', '0', '0', '0', '', '', '', 0, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pwdreset`
--

INSERT INTO `pwdreset` (`pwdResetId`, `pwdResetEmail`, `pwdResetSelector`, `pwdResetToken`, `pwdResetExpire`) VALUES
(48, '', '8bcd3fe28dfa1ab5', '$2y$10$8WktzLf89Ae7cco3Z6Vh2Ob.gqZa3OwBxL7PA0wFJJu4zLTiRLnyK', '2886744421800'),
(20, 'osadamanohara@gmil.com', '0da5bcd5f651968d', '$2y$10$HGdCwhlM3xSYHRpWqr97uulnVP7wJaoYOnzRN5rZPFCRWNwaNBKr.', '2886724782000'),
(18, 'osadamanohara55@gmail.com', '32dedb9a0f53c83c', '$2y$10$wiY89elOrHZtXjQBktgpk.PQMfTaBkob0.tOsNRbTbc8IYwYlPSJS', '2886718411800'),
(28, 'osadamanohara@gmail.com', '99158164dd960c9d', '$2y$10$XIGJyGiQBqO5pnoCnbd5/.nTZphdQO1oyDZPJM6oaqr.Mq9pVSp7O', '2886726522600'),
(49, 'osadamanohara555@gmail.com', 'e9face3fe32a19b7', '$2y$10$/uVv7ralC0.fyxutiUDWKOW.atAXwu9.xyshrTpgYOYuyhfvoHpky', '2886744454200'),
(24, 'osadamanohara56@gmail.com', '5aae3cce0f242242', '$2y$10$skSc86SMlqbDbzVsHzX0S..D7cMTRtFL7P8wBL4XYHD4SKbRZzJC.', '2886725156400'),
(27, 's2dtech@gmail.com', 'd472f1c0e2d1947d', '$2y$10$O/6KF/7AtqtOzUZdUkxJZ.OX8vcVAgG7DhQKh0EGWH3aPFs7bWFTq', '2886725318400');

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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seeker`
--

INSERT INTO `seeker` (`seeker_id`, `first_name`, `last_name`, `username`, `qualification`, `email`, `phone_number`, `password`, `is_image`, `is_deleted`) VALUES
(1, '0', '0', '0', 'no', 'osada@gmail.com', '0', '0', 0, 1),
(3, 'osa', 'mano', 'im', 'no', 'osadamanohara@gmail.com', '02146532', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(5, 'Ilmina', 'Malshan', 'OggY', 'no', 'ilminamalshan@gmail.com', '0768484968', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 0, 0),
(32, 'Ilmina', 'Malshan', 'OggY', 'no', 'sumanasirirathnayake@gmail.com', '0768484968', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(33, 'osada manohara ', 'rathnayake', 'user name', 'no', 'osadamanohara55@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(34, 'osada', 'Manohara', 'OzKa', 'no', 'osadamanohara56@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(35, 'Dipika', 'Amarathuna', 'Dipika', 'no', 'dipika12@gmail.com', '0768484968', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(36, 'Prasadika', 'Chumini', 'PrSa', 'no', 'prasdikachathumini@gmail.com', '0715685369', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(49, 'sumanasiri', 'rathnayake', 'su', 'no', 'sumanasirirathnayake55@gmail.com', '0712871409', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(50, 'Osada', 'Manohara', 'osada', 'no', 'osadamanohara@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(51, 'Osada', 'Manohara', 'Osa', 'no', 'osadamanohara57@gmail.com', '0552294959 ', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(52, 'Osada', 'Manohara', 'admin', 'no', 'osadamanohara578@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(53, 'Osada', 'Manohara', 'admin', 'no', 'osadamanohara598@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(54, 'Osada', 'Manohara', 'admin', 'no', 'osadamanohara58@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(55, 'Osada', 'Manohara', 'admin', 'no', 'osadamanohara51@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(56, 'Osada', 'Manohara', 'admin', 'no', 'osadamanohara52@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(57, 'Osada', 'Manohara', 'admin', 'no', 'osadamanohara53@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(58, 'Osada', 'Manohara', 'admin', 'no', 'osadamanohara59@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(59, 'Prasadika', 'Chumini', 'Prasa', 'no', 'prasadikachathumini55@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(60, 'Prasadika', 'Chumini', 'PrSa', 'no', 'prasadikachathumini56@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(61, 'Osada', 'Man', 'admin', 'no', 'test@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(62, 'Osada', 'Manohara', 'OzKa', 'no minimum qualification', 'osadamanohara5@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(63, 'Osada', 'Manohara', 'OggY', 'degree', 'osadamanohara555@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(64, 'navod', 'nirmal', 'navod33', 'no', 'navodnirmal@gmail.com', '0703134569', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(65, 'Supun', 'Harshana', 'Supun_h', 'no', 'supunharshana@gmail.com', '0711234567', '8cb2237d0679ca88db6464eac60da96345513964', 0, 0),
(66, 'praveen', 'thakasara', 'madumal', 'no', 'magagepraveen@gmail.com', '0779551097', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 0, 0),
(67, 'malshan', 'mihiranga', 'malshan', 'no', 'malshanmihiranga97@gmail.com', '0789867566', 'b7b975da6a95a9e891efad76d30b43b75a267911', 0, 0),
(68, 'Osada', 'Manohara', 'admin', 'no', 'osadamanohara5578@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(69, 'Osada', 'Manohara', 'admin', 'no', 'osada5@gmail.com', '0768597090', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0),
(70, 'Prasadika', 'Chathumini', 'Prasa', 'no minimum qualification', 'prasadika@gmail.com', '0115602560', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0);

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
(62, '', 'Osada Mnohara rathnayake', '', 'osada97'),
(63, '__osada__', 'Osada Mnohara', 'osada_manohara', 'osada97'),
(64, '', '', '', ''),
(65, '', '', '', ''),
(66, '', 'praveen madu', '', ''),
(67, '', 'malshan mihiranga', '', ''),
(70, '', '', '', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `work_experience`
--

INSERT INTO `work_experience` (`no`, `user_id`, `wk_title`, `wk_company`, `wk_years`, `wk_description`) VALUES
(26, 62, 'CISCO', 'asdasda', '2020-02', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(32, 65, 'lab assistance', 'cargills', '2016-08', ''),
(33, 66, 'tele comiunication', 'slt', '2017-02', ''),
(34, 67, 'welder', 'welder ccc company', '2019-07', '');

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
