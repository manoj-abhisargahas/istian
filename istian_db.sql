-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2020 at 04:28 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `istian_db`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `insert_query_with_next_max_query_index` (`upload_id` VARCHAR(50), `student_rollno` VARCHAR(11), `query` VARCHAR(500), `query_time` INT(20)) RETURNS INT(5) NO SQL
BEGIN
DECLARE max_index INTEGER;

SELECT MAX(qa.`query_index`) INTO max_index FROM `queries_answers` qa WHERE qa.`upload_id`=upload_id;

IF max_index >= 0 THEN
	SET max_index = max_index+1;
ELSE
	SET max_index = 0;
END IF;

INSERT INTO `queries_answers` 
(`upload_id`, `query_index`, `student_rollno`, `query`, `query_time`) 
VALUES (upload_id,  max_index, student_rollno, query, query_time);

RETURN max_index;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company`) VALUES
('Accenture'),
('dropbox'),
('google'),
('infosys'),
('Infotech'),
('mindtree'),
('tcs'),
('ZOHO');

-- --------------------------------------------------------

--
-- Table structure for table `for_branches`
--

CREATE TABLE `for_branches` (
  `upload_id` varchar(50) NOT NULL,
  `notice_for_branch` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `for_branches`
--

INSERT INTO `for_branches` (`upload_id`, `notice_for_branch`) VALUES
('IMRAN-1234', 'CSE'),
('IMRAN-1234', 'ECE'),
('IMRAN-1234', 'EEE'),
('IMRAN-1583575377', 'ALL'),
('IMRAN-1583697651', 'ALL'),
('IMRAN-1584340544', 'ALL'),
('IMRAN-1584352926', 'ALL'),
('IMRAN-1585814321', 'ALL'),
('IMRAN-1586538829', 'ALL'),
('IMRAN-1586539228', 'ALL'),
('IMRAN-1587533897', 'ALL'),
('IMRAN-1587681113', 'ALL'),
('JALLEL-1586539108', 'ALL');

-- --------------------------------------------------------

--
-- Table structure for table `for_years`
--

CREATE TABLE `for_years` (
  `upload_id` varchar(50) NOT NULL,
  `notice_for_year` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `for_years`
--

INSERT INTO `for_years` (`upload_id`, `notice_for_year`) VALUES
('IMRAN-1234', 'III'),
('IMRAN-1234', 'IV'),
('IMRAN-1583575377', 'ALL'),
('IMRAN-1583697651', 'ALL'),
('IMRAN-1584340544', 'ALL'),
('IMRAN-1584352926', 'ALL'),
('IMRAN-1585814321', 'ALL'),
('IMRAN-1586538829', 'III'),
('IMRAN-1586539228', 'ALL'),
('IMRAN-1587533897', 'ALL'),
('IMRAN-1587681113', 'ALL'),
('JALLEL-1586539108', 'ALL');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `upload_id` varchar(50) NOT NULL,
  `notice_heading` varchar(200) NOT NULL,
  `notice_text` varchar(500) DEFAULT NULL,
  `notice_by` varchar(10) NOT NULL,
  `expire_time` int(20) NOT NULL,
  `upload_time` int(20) NOT NULL,
  `last_edited_time` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`upload_id`, `notice_heading`, `notice_text`, `notice_by`, `expire_time`, `upload_time`, `last_edited_time`) VALUES
('IMRAN-1234', 'Test', 'app testing', 'imran', 12345, 123, NULL),
('IMRAN-1583575377', 'Social Media Icons!', 'Can be useful to refer in poster designs, brochures..etc.\r\nMore icons are available below to download...', 'imran', 1583519400, 1583575462, NULL),
('IMRAN-1583697651', 'Advancements in Rocket Launching Vehicle', '', 'imran', 1583778600, 1583698017, NULL),
('IMRAN-1584340544', 'TEST-3', 'This is software testing.', 'imran', 1584297000, 1584340765, NULL),
('IMRAN-1584352926', 'BLACK BOX', 'Image Test:\nOriginal: 20px x 20px \nRendered: 40px x40px', 'imran', 1585593000, 1584353009, NULL),
('IMRAN-1585814321', 'Awareness On CORONA Virus.', '1. Cover while coughing, sneezing.\n2. Don\'t touch eyes, nose, mouth with hands.\n3. Wash hands always cleanly.\n4. If problem in respiration or coughing highly consult doctor.', 'imran', 1586802600, 1585814444, NULL),
('IMRAN-1586538829', 'New Canteen', 'Opening on: JUNE 10, 2020', 'imran', 1591813800, 1586538853, NULL),
('IMRAN-1586539228', 'Social Media Icons', 'Download these icons,\nuseful in making Event Posters, IMRAN Brochures etc.', 'imran', 1588185000, 1586539675, NULL),
('IMRAN-1587533897', 'Istian', 'Launching our IMRAN new domain for purpose of providing services under this domain mainly digitally.\r\nUnder this domain, IMRAN applications like STUD Home, TPO Office, DigitalNotice are developed.', 'imran', 1590949800, 1587534073, 1587691115),
('IMRAN-1587681113', 'Awareness On CORONA Virus.', '1. Cover while coughing, sneezing.\n2. Don\'t touch eyes, nose, mouth with hands.\n3. Wash hands always cleanly.\n4. If problem in respiration or coughing highly consult doctor.', 'imran', 1590949800, 1587681293, NULL),
('JALLEL-1586539108', '#Stay Home', '#Stay Safe.\r\n', 'jallel', 1590949800, 1586539206, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `queries_answers`
--

CREATE TABLE `queries_answers` (
  `upload_id` varchar(50) NOT NULL,
  `query_index` int(5) NOT NULL,
  `student_rollno` varchar(11) NOT NULL,
  `query` varchar(500) NOT NULL,
  `query_time` int(20) NOT NULL,
  `answered_status` char(3) NOT NULL DEFAULT 'NO',
  `tpo_username` varchar(10) DEFAULT NULL,
  `answer` varchar(500) DEFAULT NULL,
  `answer_time` int(20) DEFAULT NULL,
  `answer_last_edited_time` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `queries_answers`
--

INSERT INTO `queries_answers` (`upload_id`, `query_index`, `student_rollno`, `query`, `query_time`, `answered_status`, `tpo_username`, `answer`, `answer_time`, `answer_last_edited_time`) VALUES
('IMRAN-1234', 0, '16kb1a05b5', 'What is it?', 1587534073, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 1, '16kb1a05b5', '1', 2, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 2, '16kb1a05b5', '1', 2, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 3, '16kb1a05b5', '1', 2, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 4, '16kb1a05b5', '1', 2, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 5, '16kb1a05b5', '1', 2, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 6, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 7, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 8, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 9, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 10, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 11, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 12, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 13, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 14, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 15, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 16, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1234', 17, '16kb1a05b5', 'what is it?', 1587541060, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1587533897', 0, '16kb1a05a3', 'When it was launching officially by college?', 1587534073, 'PUB', 'imran', 'we are at last phase of this sem right! that\'s why it will be implemented next year!', 1587535073, NULL),
('IMRAN-1587533897', 2, '16kb1a05b5', 'they can hire students for this college company?', 1587534073, 'PRI', 'imran', 'May be possible!', 1587535500, NULL),
('IMRAN-1587533897', 3, '16kb1a05b5', 'Is development fully completed?', 1587534100, 'PUB', 'imran', 'Sample deployment also happend successfully!', 1587535200, 1587740215),
('IMRAN-1587533897', 4, '16kb1a05b5', 'is it in testing?', 1587534200, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1587533897', 5, '16kb1a05a3', 'for it maintainace is there any employees selected?', 1587534300, 'NO', NULL, NULL, NULL, NULL),
('IMRAN-1587533897', 6, '16kb1a05a3', 'Is it developed?', 1587534400, 'NO', NULL, NULL, NULL, NULL),
('JALLEL-1586539108', 0, '16kb1a05a3', 'When our college reopening?', 1587535200, 'PRI', 'jallel', 'We have to wait until lock down completes, then we can see.', 1587535900, NULL),
('JALLEL-1586539108', 1, '16kb1a05h3', 'When college reopens for next academic year? and even our exams not completed.', 1587536100, 'PUB', 'jallel', 'That is not our concern right now! We have to wait until lock down completes, then we can see.', 1587536900, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `query_files`
--

CREATE TABLE `query_files` (
  `upload_id` varchar(50) NOT NULL,
  `query_index` int(5) NOT NULL,
  `uploaded_file_name` varchar(80) NOT NULL,
  `uploaded_file_server_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `query_files`
--

INSERT INTO `query_files` (`upload_id`, `query_index`, `uploaded_file_name`, `uploaded_file_server_name`) VALUES
('IMRAN-1587533897', 4, 'xq', 'ax');

-- --------------------------------------------------------

--
-- Table structure for table `students_placed`
--

CREATE TABLE `students_placed` (
  `student_rollno` varchar(11) NOT NULL,
  `placed_company` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students_placed`
--

INSERT INTO `students_placed` (`student_rollno`, `placed_company`) VALUES
('16KB1A0501', 'mindtree'),
('16kb1a0501', 'tcs'),
('16KB1A0596', 'google'),
('16KB1A0596', 'infosys'),
('16KB1A0596', 'mindtree'),
('16KB1A0596', 'ZOHO');

-- --------------------------------------------------------

--
-- Table structure for table `tpo`
--

CREATE TABLE `tpo` (
  `email` varchar(50) NOT NULL,
  `username` varchar(10) NOT NULL,
  `pword` varchar(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpo`
--

INSERT INTO `tpo` (`email`, `username`, `pword`) VALUES
('imran@gmail.com', 'imran', '12345678'),
('jallel@gmail.com', 'jallel', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `tpo_info`
--

CREATE TABLE `tpo_info` (
  `name` varchar(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpo_info`
--

INSERT INTO `tpo_info` (`name`, `email`) VALUES
('md.imran', 'imran@gmail.com'),
('sk.jallel', 'jallel@gmail.com'),
('manoj', 'manojabhisargahas1@gmail.com'),
('vishnu', 'vishnulokesh520@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `upload_id` varchar(50) NOT NULL,
  `uploaded_file_name` varchar(80) NOT NULL,
  `uploaded_file_server_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploaded_files`
--

INSERT INTO `uploaded_files` (`upload_id`, `uploaded_file_name`, `uploaded_file_server_name`) VALUES
('IMRAN-1583575377', 'Facebook.png', '95b3fc613d'),
('IMRAN-1583575377', 'Google_Plus.png', '135ad11112'),
('IMRAN-1583575377', 'Linkedin.png', 'a32b11a2a6'),
('IMRAN-1583575377', 'Twitter.png', '85aecf4ef5'),
('IMRAN-1583575377', 'Youtube.png', '9f0b768467'),
('IMRAN-1584340544', 'around_parts.png', 'ceb4c4f168'),
('IMRAN-1584340544', 'bg.jpg', 'cb44b5a85c'),
('IMRAN-1584340544', 'Techvyuha_name.png', '897d1193f8'),
('IMRAN-1584340544', 'Techvyuha_name_with_bg.jpg', 'c75c774067'),
('IMRAN-1584340544', 'Techvyuha_name1.png', '7590e49e8a'),
('IMRAN-1584340544', 'Techvyuha2020_with_around_parts.png', '1d2edd250a'),
('IMRAN-1586539228', 'Facebook.png', '6b6c5099d5'),
('IMRAN-1586539228', 'Google_Plus.png', 'b14358961f'),
('IMRAN-1586539228', 'Linkedin.png', '2d4d7b1fda'),
('IMRAN-1586539228', 'Twitter.png', '57951522f9'),
('IMRAN-1586539228', 'Youtube.png', 'df287e3454'),
('IMRAN-1587681113', 'ALWAYS_REMEMBER.jpg', 'ca2ce0c750'),
('IMRAN-1587681113', 'HOW_DOES_CORONAVIRUS_SPREAD.jpg', '8e636633d6'),
('IMAGE-IMRAN-1587681113', 'ALWAYS_REMEMBER.jpg', 'ca2ce0c750');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company`);

--
-- Indexes for table `for_branches`
--
ALTER TABLE `for_branches`
  ADD UNIQUE KEY `upload_id_2` (`upload_id`,`notice_for_branch`),
  ADD KEY `upload_id` (`upload_id`);

--
-- Indexes for table `for_years`
--
ALTER TABLE `for_years`
  ADD UNIQUE KEY `upload_id_2` (`upload_id`,`notice_for_year`),
  ADD KEY `upload_id` (`upload_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`upload_id`),
  ADD KEY `notice_by` (`notice_by`);

--
-- Indexes for table `queries_answers`
--
ALTER TABLE `queries_answers`
  ADD UNIQUE KEY `question_id` (`upload_id`,`query_index`),
  ADD KEY `student_rollno` (`student_rollno`),
  ADD KEY `tpo_username` (`tpo_username`);

--
-- Indexes for table `query_files`
--
ALTER TABLE `query_files`
  ADD KEY `upload_id` (`upload_id`,`query_index`);

--
-- Indexes for table `students_placed`
--
ALTER TABLE `students_placed`
  ADD KEY `placed_company` (`placed_company`),
  ADD KEY `student_rollno` (`student_rollno`);

--
-- Indexes for table `tpo`
--
ALTER TABLE `tpo`
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tpo_info`
--
ALTER TABLE `tpo_info`
  ADD UNIQUE KEY `email` (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `for_branches`
--
ALTER TABLE `for_branches`
  ADD CONSTRAINT `for_branches_ibfk_1` FOREIGN KEY (`upload_id`) REFERENCES `notices` (`upload_id`);

--
-- Constraints for table `for_years`
--
ALTER TABLE `for_years`
  ADD CONSTRAINT `for_years_ibfk_1` FOREIGN KEY (`upload_id`) REFERENCES `notices` (`upload_id`);

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `notices_ibfk_1` FOREIGN KEY (`notice_by`) REFERENCES `tpo` (`username`);

--
-- Constraints for table `queries_answers`
--
ALTER TABLE `queries_answers`
  ADD CONSTRAINT `queries_answers_ibfk_2` FOREIGN KEY (`student_rollno`) REFERENCES `digital_notice_db`.`student` (`rollno`),
  ADD CONSTRAINT `queries_answers_ibfk_3` FOREIGN KEY (`tpo_username`) REFERENCES `tpo` (`username`),
  ADD CONSTRAINT `queries_answers_ibfk_4` FOREIGN KEY (`upload_id`) REFERENCES `notices` (`upload_id`);

--
-- Constraints for table `query_files`
--
ALTER TABLE `query_files`
  ADD CONSTRAINT `query_files_ibfk_1` FOREIGN KEY (`upload_id`,`query_index`) REFERENCES `queries_answers` (`upload_id`, `query_index`);

--
-- Constraints for table `students_placed`
--
ALTER TABLE `students_placed`
  ADD CONSTRAINT `students_placed_ibfk_2` FOREIGN KEY (`placed_company`) REFERENCES `companies` (`company`),
  ADD CONSTRAINT `students_placed_ibfk_3` FOREIGN KEY (`student_rollno`) REFERENCES `digital_notice_db`.`student` (`rollno`);

--
-- Constraints for table `tpo`
--
ALTER TABLE `tpo`
  ADD CONSTRAINT `tpo_ibfk_1` FOREIGN KEY (`email`) REFERENCES `tpo_info` (`email`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `expire_otps` ON SCHEDULE EVERY 1 MINUTE STARTS '2020-03-01 00:00:00' ENDS '2020-05-01 00:00:00' ON COMPLETION PRESERVE DISABLE DO DELETE FROM `OTPS` WHERE (UNIX_TIMESTAMP()-generated_time>1800)$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
