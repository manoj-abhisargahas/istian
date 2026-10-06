-- phpMyAdmin header variables
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- --------------------------------------------------------

-- 1. Create your secondary databases (the primary one is created by docker-compose)
CREATE DATABASE IF NOT EXISTS istian_db CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;

-- 2. Ensure your standard user has full clearance to manage all the secondary databases
GRANT ALL PRIVILEGES ON istian_db.* TO 'user'@'%';

-- --------------------------------------------------------
-- --------------------------------------------------------

-- 3. Select your primary database to create its tables
USE digital_notice_db;
ALTER DATABASE digital_notice_db CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `for_branchs`
--

CREATE TABLE IF NOT EXISTS `for_branchs` (
  `upload_id` varchar(50) NOT NULL,
  `notice_for_branch` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `for_sections`
--

CREATE TABLE IF NOT EXISTS `for_sections` (
  `upload_id` varchar(50) NOT NULL,
  `notice_for_section` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `for_years`
--

CREATE TABLE IF NOT EXISTS `for_years` (
  `upload_id` varchar(50) NOT NULL,
  `notice_for_year` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE IF NOT EXISTS `notices` (
  `upload_id` varchar(50) NOT NULL,
  `notice_heading` varchar(200) NOT NULL,
  `notice_text` varchar(500) DEFAULT NULL,
  `notice_by` varchar(10) NOT NULL,
  `expire_time` int(20) NOT NULL,
  `upload_time` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notices_by`
--

CREATE TABLE IF NOT EXISTS `notices_by` (
  `notice_by_name` varchar(10) NOT NULL,
  `notice_by_email` varchar(50) DEFAULT NULL,
  `notice_by_pword` varchar(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notices_by`
--

INSERT IGNORE INTO `notices_by` (`notice_by_name`, `notice_by_email`, `notice_by_pword`) VALUES
('CIVIL', 'civil@nbkrist.org', 'Civil@1234'),
('COLLEGE', 'college@nbkrist.org', 'College@1234'),
('CSE', 'cse@nbkrist.org', 'Cse@1234'),
('ECE', 'ece@nbkrist.org', 'Ece@1234'),
('EEE', 'eee@nbkrist.org', 'Eee@1234'),
('IT', 'it@nbkrist.org', 'It@1234'),
('LIBRARY', 'library@nbkrist.org', 'Library@1234'),
('MECH', 'mech@nbkrist.org', 'Mech@1234');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `name` varchar(30) NOT NULL,
  `rollno` varchar(11) NOT NULL,
  `present_year` int(11) NOT NULL,
  `branch` varchar(10) NOT NULL,
  `section` varchar(2) NOT NULL,
  `cgpa` float(6,3) NOT NULL,
  `backlogs` int(11) NOT NULL,
  `batch` varchar(10) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `pword` varchar(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT IGNORE INTO `student` (`name`, `rollno`, `present_year`, `branch`, `section`, `cgpa`, `backlogs`, `batch`, `email`, `pword`) VALUES
('roopesh', '16kb1a0501', 4, 'cse', 'a', 6.500, 0, '2016-20', '16kb1a0501@nbkrist.org', '16kb1a0501'),
('vasantha', '16kb1a0596', 4, 'cse', 'B', 7.000, 0, '2016-20', '16kb1a0596@nbkrist.org', '16kb1a0596'),
('sumanth', '16kb1a05a3', 4, 'cse', 'b', 6.500, 1, '2016-20', '16kb1a05a3@nbkrist.org', '16kb1a05a3'),
('harish', '16kb1a05a4', 4, 'cse', 'B', 7.200, 0, '2016-20', '16kb1a05a4@nbkrist.org', '16kb1a05a4'),
('balaji', '16kb1a05b5', 4, 'cse', 'b', 7.000, 2, '2016-20', '16kb1a05b5@nbkrist.org', '16kb1a05b5'),
('harshini', '16kb1a05d1', 4, 'cse', 'C', 8.500, 0, '2016-20', '16kb1a05d1@nbkrist.org', '16kb1a05d1'),
('srujan', '16kb1a05h3', 4, 'cse', 'c', 6.000, 0, '2016-20', '16kb1a05h3@nbkrist.org', '16kb1a05h3');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE IF NOT EXISTS `uploaded_files` (
  `upload_id` varchar(50) NOT NULL,
  `uploaded_file_name` varchar(80) NOT NULL,
  `uploaded_file_server_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `for_branchs`
--
ALTER TABLE `for_branchs`
  ADD UNIQUE KEY `upload_id` (`upload_id`,`notice_for_branch`);

--
-- Indexes for table `for_sections`
--
ALTER TABLE `for_sections`
  ADD UNIQUE KEY `upload_id` (`upload_id`,`notice_for_section`);

--
-- Indexes for table `for_years`
--
ALTER TABLE `for_years`
  ADD UNIQUE KEY `upload_id` (`upload_id`,`notice_for_year`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`upload_id`),
  ADD KEY `notice_by` (`notice_by`);

--
-- Indexes for table `notices_by`
--
ALTER TABLE `notices_by`
  ADD PRIMARY KEY (`notice_by_name`),
  ADD UNIQUE KEY `notice_by_email` (`notice_by_email`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`rollno`),
  ADD UNIQUE KEY `email` (`email`);

-- --------------------------------------------------------

--
-- Constraints for dumped tables
--

--
-- Constraints for table `for_branchs`
--
ALTER TABLE `for_branchs`
  ADD CONSTRAINT `for_branchs_ibfk_1` FOREIGN KEY (`upload_id`) REFERENCES `notices` (`upload_id`);

--
-- Constraints for table `for_sections`
--
ALTER TABLE `for_sections`
  ADD CONSTRAINT `for_sections_ibfk_1` FOREIGN KEY (`upload_id`) REFERENCES `notices` (`upload_id`);

--
-- Constraints for table `for_years`
--
ALTER TABLE `for_years`
  ADD CONSTRAINT `for_years_ibfk_1` FOREIGN KEY (`upload_id`) REFERENCES `notices` (`upload_id`);

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `notices_ibfk_1` FOREIGN KEY (`notice_by`) REFERENCES `notices_by` (`notice_by_name`);

-- --------------------------------------------------------
-- --------------------------------------------------------

-- 4. Select your secondary database to create its tables
USE istian_db;

-- --------------------------------------------------------
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

INSERT IGNORE INTO `queries_answers` 
(`upload_id`, `query_index`, `student_rollno`, `query`, `query_time`) 
VALUES (upload_id,  max_index, student_rollno, query, query_time);

RETURN max_index;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `company` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `companies`
--

INSERT IGNORE INTO `companies` (`company`) VALUES
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

CREATE TABLE IF NOT EXISTS `for_branches` (
  `upload_id` varchar(50) NOT NULL,
  `notice_for_branch` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `for_years`
--

CREATE TABLE IF NOT EXISTS `for_years` (
  `upload_id` varchar(50) NOT NULL,
  `notice_for_year` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE IF NOT EXISTS `notices` (
  `upload_id` varchar(50) NOT NULL,
  `notice_heading` varchar(200) NOT NULL,
  `notice_text` varchar(500) DEFAULT NULL,
  `notice_by` varchar(10) NOT NULL,
  `expire_time` int(20) NOT NULL,
  `upload_time` int(20) NOT NULL,
  `last_edited_time` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queries_answers`
--

CREATE TABLE IF NOT EXISTS `queries_answers` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `query_files`
--

CREATE TABLE IF NOT EXISTS `query_files` (
  `upload_id` varchar(50) NOT NULL,
  `query_index` int(5) NOT NULL,
  `uploaded_file_name` varchar(80) NOT NULL,
  `uploaded_file_server_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_placed`
--

CREATE TABLE IF NOT EXISTS `students_placed` (
  `student_rollno` varchar(11) NOT NULL,
  `placed_company` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tpo`
--

CREATE TABLE IF NOT EXISTS `tpo` (
  `email` varchar(50) NOT NULL,
  `username` varchar(10) NOT NULL,
  `pword` varchar(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tpo_info`
--

CREATE TABLE IF NOT EXISTS `tpo_info` (
  `name` varchar(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tpo_info`
--

INSERT IGNORE INTO `tpo_info` (`name`, `email`) VALUES
('md.imran', 'imran@nbkrist.org'),
('sk.jallel', 'jallel@nbkrist.org'),
('manoj', 'manojabhisargahas1@nbkrist.org'),
('vishnu', 'vishnulokesh520@nbkrist.org');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE IF NOT EXISTS `uploaded_files` (
  `upload_id` varchar(50) NOT NULL,
  `uploaded_file_name` varchar(80) NOT NULL,
  `uploaded_file_server_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

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

-- --------------------------------------------------------

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `expire_otps` ON SCHEDULE EVERY 1 MINUTE STARTS '2020-03-01 00:00:00' ENDS '2020-05-01 00:00:00' ON COMPLETION PRESERVE DISABLE DO DELETE FROM `OTPS` WHERE (UNIX_TIMESTAMP()-generated_time>1800)$$

DELIMITER ;

-- --------------------------------------------------------
-- --------------------------------------------------------

-- 5. [THE CLOSING CLEANUP HEADERS] (Put them here to reset settings!)
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- 6. [THE FINAL COMMIT] (Saves everything permanently)
COMMIT;