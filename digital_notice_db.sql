-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2020 at 04:27 PM
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
-- Database: `digital_notice_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `for_branchs`
--

CREATE TABLE `for_branchs` (
  `upload_id` varchar(50) NOT NULL,
  `notice_for_branch` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `for_branchs`
--

INSERT INTO `for_branchs` (`upload_id`, `notice_for_branch`) VALUES
('COLLEGE-1589139171', 'ALL'),
('COLLEGE-1589139721', 'ALL'),
('COLLEGE-1589139805', 'ALL'),
('COLLEGE-1589140038', 'ALL'),
('COLLEGE-1589140373', 'ALL'),
('COLLEGE-1591929693', 'ALL'),
('LIBRARY-1584622006', 'ALL'),
('LIBRARY-1584622033', 'ALL');

-- --------------------------------------------------------

--
-- Table structure for table `for_sections`
--

CREATE TABLE `for_sections` (
  `upload_id` varchar(50) NOT NULL,
  `notice_for_section` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `for_sections`
--

INSERT INTO `for_sections` (`upload_id`, `notice_for_section`) VALUES
('CSE-1586540099', 'ALL'),
('CSE-1586541131', 'ALL'),
('ME-1583751747', 'ALL'),
('ME-1583815603', 'ALL'),
('ME-1583816142', 'ALL');

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
('COLLEGE-1589139171', 'ALL'),
('COLLEGE-1589139721', 'ALL'),
('COLLEGE-1589139805', 'ALL'),
('COLLEGE-1589140038', 'ALL'),
('COLLEGE-1589140373', 'ALL'),
('COLLEGE-1591929693', 'ALL'),
('CSE-1586540099', 'ALL'),
('CSE-1586541131', 'ALL'),
('LIBRARY-1584622006', 'ALL'),
('LIBRARY-1584622033', 'ALL'),
('ME-1583751747', 'ALL'),
('ME-1583815603', 'ALL'),
('ME-1583816142', 'ALL');

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
  `upload_time` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`upload_id`, `notice_heading`, `notice_text`, `notice_by`, `expire_time`, `upload_time`) VALUES
('COLLEGE-1589139171', 'New Canteen', 'Opening on: JUNE 10, 2020', 'COLLEGE', 1593455400, 1589139239),
('COLLEGE-1589139721', 'Social Media Icons!', 'Can be useful to refer in poster designs, brochures..etc.\nMore icons are available below to download...', 'COLLEGE', 1622399400, 1589139759),
('COLLEGE-1589139805', 'Lock Down Extension', 'Lock Down extended up to MAY 17th.\nSo, college remains closed up to MAY 17th.', 'COLLEGE', 1589653800, 1589140029),
('COLLEGE-1589140038', '#Stay Home, \n#Stay Safe.', '', 'COLLEGE', 1590863400, 1589140083),
('COLLEGE-1589140373', 'Awareness On CORONA Virus.', '1. Cover while coughing, sneezing.\n2. Don\'t touch eyes, nose, mouth with hands.\n3. Wash hands always cleanly.\n4. If problem in respiration or coughing highly consult doctor.\n\nMore info in below files,', 'COLLEGE', 1590863400, 1589140530),
('COLLEGE-1591929693', 'Awareness On CORONA Virus.', '1. Cover while coughing, sneezing.\n2. Don\'t touch eyes, nose, mouth with hands.\n3. Wash hands always cleanly.\n4. If problem in respiration or coughing highly consult doctor.\n\nMore info in below files,', 'COLLEGE', 1593455400, 1591929760),
('CSE-1586540099', 'TECHVYUHA 2020', 'On June 10th', 'CSE', 2147483647, 2147483647),
('CSE-1586541131', 'NETWOKING CLUB', 'Newly starting this year.\nFaculty Incharge: Suresh Babu.', 'CSE', 2147483647, 2147483647),
('LIBRARY-1584622006', 'Library Cards', 'Issue date: March 31, 2020.', 'LIBRARY', 2147483647, 2147483647),
('LIBRARY-1584622033', 'Library Cards', 'Issue date: March 31, 2020.', 'LIBRARY', 2147483647, 2147483647),
('ME-1583751747', 'ICAMSME 2020', '7th - 9th Feb 2020', 'ME', 2147483647, 2147483647),
('ME-1583815603', 'Invitaion ICAMSME 2020', '', 'ME', 2147483647, 2147483647),
('ME-1583816142', 'Good Morning!', 'a warm wish.', 'ME', 2147483647, 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `notices_by`
--

CREATE TABLE `notices_by` (
  `notice_by_name` varchar(10) NOT NULL,
  `notice_by_email` varchar(50) DEFAULT NULL,
  `notice_by_pword` varchar(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notices_by`
--

INSERT INTO `notices_by` (`notice_by_name`, `notice_by_email`, `notice_by_pword`) VALUES
('CE', 'ce@gmail.com', 'ce12345678'),
('COLLEGE', 'college@gmail.com', '12345678'),
('CSE', 'cse@gmail.com', 'cse12345678'),
('ECE', 'ece@gmail.com', 'ece12345678'),
('EEE', 'eee@gmail.com', 'eee12345678'),
('IT', 'it@gmail.com', 'it12345678'),
('LIBRARY', 'library@gmail.com', 'library12345678'),
('ME', 'me@gmail.com', 'me12345678');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`name`, `rollno`, `present_year`, `branch`, `section`, `cgpa`, `backlogs`, `batch`, `email`, `pword`) VALUES
('roopesh', '16kb1a0501', 4, 'cse', 'a', 6.500, 0, '2016-20', 'roopesh_a@yahoo.com', ''),
('vasantha', '16KB1A0596', 4, 'cse', 'B', 7.000, 0, '2016-20', 'vassantha596@gmail.com', ''),
('sumanth', '16kb1a05a3', 4, 'cse', 'b', 6.500, 1, '2016-20', 'sumanth7032@gmail.com', ''),
('harish', '16KB1A05a4', 4, 'cse', 'B', 7.200, 0, '2016-20', 'harishchinnu@gmail.com', ''),
('balaji', '16kb1a05b5', 4, 'cse', 'b', 7.000, 2, '2016-20', 'anirudhbala007@gmail.com', '12345678'),
('harshini', '16KB1A05d1', 4, 'cse', 'C', 8.500, 0, '2016-20', 'harshireddyp@gmail.com', ''),
('srujan', '16kb1a05h3', 4, 'cse', 'c', 6.000, 0, '2016-20', 'srujansanju2@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `upload_id` varchar(50) NOT NULL,
  `uploaded_file_name` varchar(80) NOT NULL,
  `uploaded_file_server_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploaded_files`
--

INSERT INTO `uploaded_files` (`upload_id`, `uploaded_file_name`, `uploaded_file_server_name`) VALUES
('ME-1583815603', 'ICAMSME2020_white_colourish.jpg', '6dcbae3114'),
('CSE-1586540099', 'Techvyuha2020_POSTER(complete).png', 'f8c09399e1'),
('COLLEGE-123', 'B.PNG', '67a356a318'),
('IMAGE-COLLEGE-1589139171', 'Aavakay.jpg', '6466451780'),
('COLLEGE-1589139670', 'Facebook.png', 'f338ef045e'),
('COLLEGE-1589139670', 'Google_Plus.png', 'efd659f3b7'),
('COLLEGE-1589139670', 'Linkedin.png', 'b89ab0c94f'),
('COLLEGE-1589139670', 'Twitter.png', '1a6a5fff59'),
('COLLEGE-1589139670', 'Youtube.png', '45983df85b'),
('COLLEGE-1589139721', 'Facebook.png', 'c707a45bb3'),
('COLLEGE-1589139721', 'Google_Plus.png', 'ca9690bc7a'),
('COLLEGE-1589139721', 'Linkedin.png', '3d273f8816'),
('COLLEGE-1589139721', 'Twitter.png', 'c4429a7137'),
('COLLEGE-1589139721', 'Youtube.png', 'f337bf9c5d'),
('IMAGE-COLLEGE-1589140283', 'HOW_DOES_CORONAVIRUS_SPREAD.jpg', '8659b6cd96'),
('COLLEGE-1589140283', 'ALWAYS_REMEMBER.jpg', '6e7a2f7f66'),
('COLLEGE-1589140283', 'PROTECT_YOURSELF_FROM_CORONAVIRUS.jpg', '25f018f847'),
('IMAGE-COLLEGE-1589140373', 'HOW_DOES_CORONAVIRUS_SPREAD.jpg', '9adc9b9c17'),
('COLLEGE-1589140373', 'ALWAYS_REMEMBER.jpg', '5e089dbdd7'),
('COLLEGE-1589140373', 'PROTECT_YOURSELF_FROM_CORONAVIRUS.jpg', 'c6f031977e'),
('IMAGE-COLLEGE-1591101662', 'ALWAYS_REMEMBER.jpg', 'ac849d6e20'),
('IMAGE-COLLEGE-1591123862', 'Aavakay.jpg', 'd8eb42bb55'),
('COLLEGE-1591283941', 'attach_file_icon.png', '5de447464a'),
('COLLEGE-1591312497', 'image_icon.png', '8b7d79a94d'),
('COLLEGE-1591312793', 'attach_file_icon.png', '15d8bf0613'),
('COLLEGE-1591326002', 'attach_file_icon_1.png', '6b5e0f438f'),
('COLLEGE-1591327604', 'attach_file_icon.png', '64acaf06f5'),
('COLLEGE-1591327604', 'attach_file_icon_1.png', 'f67dc31b98'),
('COLLEGE-1591327604', 'attach_file_icon_2.png', '63ce59cecf'),
('COLLEGE-1591327604', 'attach_file_icon_3.png', '095fb71e66'),
('COLLEGE-1591327604', 'attach_file_icon_4.png', '581de19dcd'),
('COLLEGE-1591327604', 'change_icon.png', '1afd639019'),
('COLLEGE-1591327604', 'image_icon.png', '2e18301a69'),
('COLLEGE-1591327604', 'load arrow(#999).png', '9d1a65830f'),
('COLLEGE-1591327604', 'load arrow.png', '954adfada5'),
('COLLEGE-1591327604', 'right_icon(#00aa00).png', 'c4b3957b02'),
('COLLEGE-1591327604', 'right_icon.png', 'ef2baa6863'),
('COLLEGE-1591327604', 'send_icon(#0077ff).png', '3fc0566438'),
('COLLEGE-1591327604', 'send_icon.png', '205bdb9efa'),
('COLLEGE-1591327604', 'send_icon-hover.png', '05f62be4c1'),
('COLLEGE-1591327604', 'upload_file_icon.png', '8aea53ade6'),
('COLLEGE-1591327684', 'image_icon.png', '2f5fcdc57d'),
('COLLEGE-1591327684', 'attach_file_icon.png', '6c2ce9cde0'),
('COLLEGE-1591327684', 'attach_file_icon_1.png', '6e402a4d90'),
('COLLEGE-1591327684', 'attach_file_icon_2.png', 'a5b596c5ab'),
('COLLEGE-1591327684', 'attach_file_icon.png', '8dac2b51f0'),
('COLLEGE-1591329192', 'attach_file_icon.png', '4ad58b3144'),
('COLLEGE-1591329192', 'attach_file_icon_1.png', 'c21dcceea9'),
('COLLEGE-1591329192', 'attach_file_icon_2.png', '773f264f7d'),
('COLLEGE-1591329192', 'attach_file_icon_3.png', '302993b2a1'),
('COLLEGE-1591329192', 'attach_file_icon_4.png', '1a62716f9b'),
('COLLEGE-1591329192', 'change_icon.png', '747832bcd3'),
('COLLEGE-1591329192', 'image_icon.png', '66cb921e7e'),
('COLLEGE-1591329192', 'load arrow(#999).png', '644c12ce0c'),
('COLLEGE-1591329192', 'attach_file_icon.png', '6dd69da983'),
('COLLEGE-1591329192', 'attach_file_icon.png', '9e85cce19b'),
('COLLEGE-1591329192', 'attach_file_icon_1.png', '20a1d80fef'),
('COLLEGE-1591329192', 'attach_file_icon_2.png', 'bc64058cb3'),
('COLLEGE-1591329192', 'attach_file_icon_3.png', '0ea1e439d4'),
('COLLEGE-1591329192', 'attach_file_icon_4.png', 'be93cef004'),
('COLLEGE-1591329192', 'change_icon.png', '4541b9d61c'),
('COLLEGE-1591329192', 'image_icon.png', '0d0008ad5f'),
('COLLEGE-1591329192', 'load arrow(#999).png', '609d0d29bd'),
('COLLEGE-1591329192', 'load arrow.png', '056d18c502'),
('COLLEGE-1591329192', 'right_icon(#00aa00).png', 'a7dd5423a9'),
('COLLEGE-1591329192', 'right_icon.png', 'eea050192d'),
('COLLEGE-1591329192', 'send_icon(#0077ff).png', 'acb4d27cf6'),
('COLLEGE-1591329192', 'send_icon.png', '17c76df124'),
('COLLEGE-1591329192', 'send_icon-hover.png', '64b7d620d3'),
('COLLEGE-1591329192', 'upload_file_icon.png', 'b8e9fc35b8'),
('COLLEGE-1591388095', 'attach_file_icon_1.png', '6f854651aa'),
('IMAGE-COLLEGE-1591390968', 'change_icon.png', '4d9a88e489'),
('COLLEGE-1591637407', 'Doremon.png', 'a8ecffea59'),
('COLLEGE-1591639883', 'abdul kalam.jpg', 'd105a6ec99'),
('COLLEGE-1591640878', 'abdul kalam.jpg', '65bb355ae8'),
('COLLEGE-1591643803', 'ALWAYS_REMEMBER.jpg', 'd32e5ba80f'),
('COLLEGE-1591643883', 'abdul kalam.jpg', 'c3e834a32a'),
('COLLEGE-1591645239', 'ALWAYS_REMEMBER.jpg', '305536e770'),
('COLLEGE-1591645239', 'abdul kalam.jpg', '010a44e0f1'),
('COLLEGE-1591645239', 'HOW_DOES_CORONAVIRUS_SPREAD.jpg', 'a5b162ba6a'),
('COLLEGE-1591646502', 'abdul kalam.jpg', '5b4cd608b6'),
('COLLEGE-1591646502', 'Demoracrates.jpg', '214565be79'),
('COLLEGE-1591646502', 'abdul kalam.jpg', '761ce2e103'),
('COLLEGE-1591646502', 'ALWAYS_REMEMBER.jpg', '8bdce4d32c'),
('COLLEGE-1591646502', 'HOW_DOES_CORONAVIRUS_SPREAD.jpg', '5bfb2542e5'),
('COLLEGE-1591646502', 'ALWAYS_REMEMBER.jpg', '62eb70a344'),
('COLLEGE-1591646502', 'HOW_DOES_CORONAVIRUS_SPREAD.jpg', '218ea5f554'),
('COLLEGE-1591646502', 'PROTECT_YOURSELF_FROM_CORONAVIRUS.jpg', '2c4d3a1ed9'),
('COLLEGE-1591646502', 'Feelings.jpg', '680c9fd295'),
('COLLEGE-1591646502', 'Mobile_Parts.png', '733f4e755e'),
('COLLEGE-1591646502', 'THE LION KING poster-3.jpg', '165331d9bd'),
('COLLEGE-1591646502', 'THE LION KING poster-2.jpg', 'affbb28b6f'),
('COLLEGE-1591646502', 'THE LION KING poster-1.jpg', '2f4d63e63c'),
('COLLEGE-1591646502', 'Alan-Mathison-Turing.jpg', '56af271e7f'),
('COLLEGE-1591646502', 'AlanTuring-3.jpg', '46e7c1c796'),
('COLLEGE-1591646502', 'AlanTuring-1.jpg', 'af741ab69f'),
('COLLEGE-1591646502', 'AlanTuring-2.jpg', '2efdbadec2'),
('COLLEGE-1591646502', 'brain1.jpg', 'a769e9c8f1'),
('COLLEGE-1591646502', 'emojis.jpg', 'e9c6a4bda1'),
('COLLEGE-1591646502', 'international_painting.jpg', 'c579109710'),
('COLLEGE-1591646502', 'Demoracrates.jpg', '8fa7c5ec9a'),
('COLLEGE-1591646502', 'abdul kalam.jpg', '89d556f8bd'),
('COLLEGE-1591646502', 'f.png', '0749e19414'),
('COLLEGE-1591646502', 'Budhha1.png', '2b69f4d8ac'),
('COLLEGE-1591649245', 'ALWAYS_REMEMBER.jpg', 'ff3eb08c4a'),
('COLLEGE-1591649245', 'ALWAYS_REMEMBER.jpg', '8a6731b82e'),
('COLLEGE-1591649245', 'HOW_DOES_CORONAVIRUS_SPREAD.jpg', 'c5ae46e0e0'),
('COLLEGE-1591649245', 'PROTECT_YOURSELF_FROM_CORONAVIRUS.jpg', '01a7276cf4'),
('COLLEGE-1591649245', 'Feelings.jpg', '109596c77e'),
('COLLEGE-1591649245', 'ALWAYS_REMEMBER.jpg', '0d8a4fd40b'),
('COLLEGE-1591649245', 'Feelings.jpg', '500c3c2212'),
('IMAGE-COLLEGE-1591650142', 'ALWAYS_REMEMBER.jpg', 'c3d4f929ff'),
('IMAGE-COLLEGE-1591650507', 'ALWAYS_REMEMBER.jpg', '15f2115b6a'),
('IMAGE-COLLEGE-1591650555', 'ALWAYS_REMEMBER.jpg', 'f139a22015'),
('COLLEGE-1591660450', 'ALWAYS_REMEMBER.jpg', '739f14431e'),
('IMAGE-COLLEGE-1591662118', 'ALWAYS_REMEMBER.jpg', 'e4f8c9971b'),
('COLLEGE-1591676826', 'HOW_DOES_CORONAVIRUS_SPREAD.jpg', '217ddfb6fb'),
('COLLEGE-1591677121', 'Mobile_Parts.png', 'f4141d7c4c'),
('IMAGE-COLLEGE-1591877401', 'THE LION KING poster-3.jpg', '09f808c4e7'),
('COLLEGE-1591897393', 'THE LION KING poster-3.jpg', 'b2d278fd6a'),
('COLLEGE-1591897798', 'THE LION KING poster-3.jpg', '056062482e'),
('IMAGE-COLLEGE-1591909524', 'ALWAYS_REMEMBER.jpg', '29709576f1'),
('COLLEGE-1591917349', 'Feelings.jpg', 'a5faaa6b4e'),
('IMAGE-COLLEGE-1591929693', 'HOW_DOES_CORONAVIRUS_SPREAD.jpg', '3b380cbf76'),
('COLLEGE-1591929693', 'ALWAYS_REMEMBER.jpg', 'd1b5095303'),
('COLLEGE-1591929693', 'PROTECT_YOURSELF_FROM_CORONAVIRUS.jpg', 'bce1933c43'),
('COLLEGE-1592294134', 'Jagajjalapalam_(English).txt', '168e40b4da'),
('COLLEGE-1592294134', 'CSE_NEWS_LETTER_COVER(BACK).jpg', 'e7a5490c50'),
('IMAGE-COLLEGE-1592335817', 'right_icon(#00aa00).png', 'e56d5558c1'),
('IMAGE-COLLEGE-1592341955', 'attach_file_icon(active).png', 'd45ad20619'),
('IMAGE-COLLEGE-1592342028', 'attach_file_icon(active).png', '00bb946713'),
('IMAGE-COLLEGE-1592342316', 'attach_file_icon(active).png', '039ba8bc67'),
('IMAGE-COLLEGE-1592343724', 'attach_file_icon(active).png', '65875faebf'),
('IMAGE-COLLEGE-1592344040', 'attach_file_icon(active).png', '41f474e3c5'),
('IMAGE-COLLEGE-1592344658', 'right_icon(#00aa00).png', '5a593da8b2'),
('IMAGE-COLLEGE-1592344787', 'attach_file_icon(active).png', 'b598c2b2a9'),
('IMAGE-COLLEGE-1592345077', 'attach_file_icon(active).png', 'd5bfac751d'),
('IMAGE-COLLEGE-1592345158', 'attach_file_icon(active).png', '7f48fc0277'),
('IMAGE-COLLEGE-1592346019', 'attach_file_icon(active).png', 'c05a37e693'),
('IMAGE-COLLEGE-1592346227', 'attach_file_icon(active).png', '51be4d1a89'),
('IMAGE-COLLEGE-1592347961', 'attach_file_icon(active).png', '8ab1d61280'),
('IMAGE-COLLEGE-1592351034', 'attach_file_icon(active).png', '79c5be306b'),
('IMAGE-COLLEGE-1592351236', 'attach_file_icon(active).png', 'bb8334d164'),
('IMAGE-COLLEGE-1592352106', 'attach_file_icon(active).png', '73e3fba71e'),
('IMAGE-COLLEGE-1592352280', 'attach_file_icon(active).png', '5ecab70804'),
('IMAGE-COLLEGE-1592352336', 'attach_file_icon(active).png', '5ed3d4c2f2'),
('IMAGE-COLLEGE-1592352358', 'attach_file_icon(active).png', 'd9141e8e76'),
('IMAGE-COLLEGE-1592353085', 'right_icon(#00aa00).png', '05fc929ebe'),
('IMAGE-COLLEGE-1592353210', 'attach_file_icon(active).png', '86ea00d497'),
('IMAGE-COLLEGE-1592353316', 'attach_file_icon(active).png', '91ee264cdb'),
('IMAGE-COLLEGE-1592353468', 'attach_file_icon(active).png', '387f15d8ef'),
('IMAGE-COLLEGE-1592353525', 'right_icon(#00aa00).png', 'f3ad4734f3'),
('IMAGE-COLLEGE-1592353768', 'right_icon(#00aa00).png', '81ba56e6d6'),
('IMAGE-COLLEGE-1592353907', 'right_icon(#00aa00).png', '0b08ef78cb'),
('IMAGE-COLLEGE-1592354110', 'change_icon.png', 'd747c29a46'),
('IMAGE-COLLEGE-1592359516', 'attach_file_icon(active).png', '44623e5145'),
('IMAGE-COLLEGE-1592359747', 'attach_file_icon(active).png', '0c40166d66'),
('IMAGE-COLLEGE-1592359796', 'send_icon(#0077ff).png', 'aa1a8634c1'),
('IMAGE-COLLEGE-1592361078', 'load arrow(#999).png', 'd6acffcadb'),
('IMAGE-COLLEGE-1592373086', '13227785_281029315568155_8945915862507590007_o.jpg', '1bd618a91e'),
('IMAGE-COLLEGE-1592373561', '13227785_281029315568155_8945915862507590007_o.jpg', '180805501d'),
('IMAGE-COLLEGE-1592373607', '13227785_281029315568155_8945915862507590007_o.jpg', '4b9e95ca78'),
('IMAGE-COLLEGE-1592373630', '180805501d.jpg', '5b59a5396b'),
('IMAGE-COLLEGE-1592373671', '5b59a5396b.jpg', '28e9732d3b'),
('IMAGE-COLLEGE-1592373812', '41d8b195cc.jpg', '3df9d1f5dd'),
('IMAGE-COLLEGE-1592400085', '1c8cbd18b5.jpg', '6f4bfdbded'),
('IMAGE-COLLEGE-1592400554', '8351e2e5b2.jpg', 'e5a5226e19'),
('IMAGE-COLLEGE-1592405581', '3df9d1f5dd.jpg', '4cb58056ed'),
('IMAGE-COLLEGE-1592438531', 'iete.png', 'e9b1a8e25c'),
('IMAGE-COLLEGE-1592438989', 'NBKR_LOGO-1.jpg', 'f6232a52b5'),
('IMAGE-COLLEGE-1592439693', 'NBKR_LOGO-1.jpg', 'bf312b033e'),
('IMAGE-COLLEGE-1592439902', 'NBKR_LOGO-2(png_cuted_color_shade).png', 'd59ffe17ec'),
('IMAGE-COLLEGE-1592440213', 'NBKR_LOGO-1.jpg', '51900cad5f'),
('IMAGE-COLLEGE-1592440330', 'NBKR_LOGO-1.jpg', '65f00c23e7'),
('IMAGE-COLLEGE-1592440471', 'attach_file_icon(active).png', '10e8ad617c'),
('IMAGE-COLLEGE-1592440877', 'attach_file_icon(active).png', 'c40985e67a'),
('COLLEGE-1592456868', 'attach_file_icon_3.png', '1f8271a661'),
('COLLEGE-1592459679', '3df9d1f5dd.jpg', 'ffbc239d50'),
('COLLEGE-1592460260', 'fa6b56c60e.png', 'b33c795dc6'),
('COLLEGE-1592588087', '0731264bf1.png', '5f3474bc2d'),
('COLLEGE-1592591062', 'HTML Unicode UTF-8', '65d959abb7'),
('COLLEGE-1592701145', 'Red_Car_Design(to-right).png', '1cd766626e'),
('IMAGE-COLLEGE-1592703755', 'Road_Design.png', 'e5a24035b2'),
('IMAGE-COLLEGE-1592704209', 'college.png', '5a7556a9c2'),
('IMAGE-COLLEGE-1592704267', 'Road_Design.png', '2c939b5837'),
('COLLEGE-1592704281', 'IMG-20200608-WA0000.jpg', '0df9e627f0'),
('COLLEGE-1592705303', 'Road_Design.png', '564db098c1'),
('COLLEGE-1592705337', 'Road_Design.png', '5e31006b10'),
('COLLEGE-1592705508', 'IMG-20200608-WA0000.jpg', 'dd57eacc2f'),
('IMAGE-COLLEGE-1592705783', 'Road_Design.png', '4b3cbc1b39'),
('COLLEGE-1592705783', 'Red_Car_Design(to-right).png', '2a2437a61b'),
('COLLEGE-1592706173', 'IMG-20200608-WA0000.jpg', '2121c8c263'),
('IMAGE-COLLEGE-1592706232', 'IMG_20200208_182759.jpg', '219b396e7e'),
('IMAGE-COLLEGE-1592706681', 'IMG_20200208_182759.jpg', '482792f092'),
('COLLEGE-1592705814', 'Black_Car_Design(to-left).png', 'cc725623b2'),
('COLLEGE-1592705814', 'Black_Car_Design(to-right).png', '296cc4e97b'),
('COLLEGE-1592705814', 'college.png', 'ff306cc2cb'),
('COLLEGE-1592705814', 'college_crop.png', '8ce47b6dc8'),
('COLLEGE-1592705814', 'Red_Car_Design(to-left).png', 'b6937d2596'),
('COLLEGE-1592705814', 'Red_Car_Design(to-right).png', '057ea2d581'),
('COLLEGE-1592705814', 'Road_Design.png', '33962e80cf'),
('COLLEGE-1592705814', 'White_Car_Design(to-left).png', 'c24d9d59ce'),
('COLLEGE-1592705814', 'White_Car_Design(to-right).png', '5ab1a40a9a'),
('COLLEGE-1592705814', 'White_Car_Design(to-left).png', 'bb9393e77a'),
('IMAGE-COLLEGE-1592708934', 'August-15(shortfilm_poster).jpg', 'ec4457748b'),
('IMAGE-COLLEGE-1592710221', 'Bull_Design(pen_drawing).jpg', 'b83e7e5a3b'),
('IMAGE-COLLEGE-1592729787', 'August-15(shortfilm_poster).jpg', 'd0b7c190ae'),
('IMAGE-COLLEGE-1592731242', 'August-15(shortfilm_poster).jpg', '304520ec0d'),
('IMAGE-COLLEGE-1592731437', 'Bull_Design(pen_drawing).jpg', '77972efe1e'),
('IMAGE-COLLEGE-1592732703', 'Bull_Design(pen_drawing).jpg', '12e1f3f44c'),
('IMAGE-COLLEGE-1592732703', 'August-15(shortfilm_poster).jpg', '04472a726a'),
('IMAGE-COLLEGE-1592732703', 'complex_design(pen_drawing).jpg', 'e58a452391'),
('IMAGE-COLLEGE-1592737604', 'attach_file_icon(active).png', '9ba6312515'),
('IMAGE-COLLEGE-1592737546', 'efa528594c.png', 'ec16f40d05'),
('IMAGE-COLLEGE-1592737989', 'efa528594c.png', '5872f6854e'),
('IMAGE-COLLEGE-1592738301', 'efa528594c.png', 'a66dc8ed45'),
('IMAGE-COLLEGE-1592738364', 'error_icon.png', '034f831f0a'),
('IMAGE-COLLEGE-1592738849', 'efa528594c.png', '5a3c9aeb04'),
('IMAGE-COLLEGE-1592738964', 'Aavakay.jpg', '55d4e11c82'),
('IMAGE-COLLEGE-1592740412', '6466451780.jpg', '7c9f086780'),
('IMAGE-COLLEGE-1592810198', 'Aavakay.jpg', 'abf157c416'),
('IMAGE-COLLEGE-1592825861', 'Aavakay.jpg', '4f4a7f70e4'),
('IMAGE-COLLEGE-1592825900', 'Aavakay.jpg', '26382547fa'),
('IMAGE-COLLEGE-1592825979', 'Aavakay.jpg', '32c1bfc814'),
('IMAGE-COLLEGE-1592826016', 'Aavakay.jpg', 'a40c67e9ab'),
('IMAGE-COLLEGE-1592826263', 'Aavakay.jpg', '2f4dc6a0ad'),
('IMAGE-COLLEGE-1592826512', 'Aavakay.jpg', '46973a9bc5'),
('IMAGE-COLLEGE-1592826536', 'Aavakay.jpg', '9a7eaccda5'),
('IMAGE-COLLEGE-1592826576', 'Aavakay.jpg', '9409eaae15'),
('IMAGE-COLLEGE-1592826702', 'Aavakay.jpg', '1ae8f3ea34'),
('IMAGE-COLLEGE-1592831866', 'Aavakay.jpg', '610508a2ee'),
('IMAGE-COLLEGE-1592837846', '3b380cbf76~2.jpg', '51c7772e98'),
('COLLEGE-1592849860', 'attach_file_icon(active).png', '3e3e8954c9'),
('COLLEGE-1592849860', 'attach_file_icon(passive).png', '736b5302a3'),
('COLLEGE-1592849860', 'attach_file_icon.png', '119271f416'),
('COLLEGE-1592849860', 'attach_file_icon_1.png', '74792b54bd'),
('COLLEGE-1592849860', 'attach_file_icon_2.png', 'e210a12b5f'),
('COLLEGE-1592849860', 'attach_file_icon_3.png', '91c07ef11c'),
('COLLEGE-1592849860', 'change_icon.png', '0567ed2067'),
('COLLEGE-1592849860', 'file_icon.png', 'dd7df408a6'),
('COLLEGE-1592849860', 'image_icon.png', 'c0150a4617'),
('COLLEGE-1592849860', 'load arrow(#999).png', '1ec35c09c1'),
('COLLEGE-1592849860', 'load arrow.png', 'fee367cdfd'),
('COLLEGE-1592849860', 'right_icon(#00aa00).png', 'e09803a861'),
('COLLEGE-1592849860', 'right_icon.png', '3eb4e75657'),
('COLLEGE-1592849860', 'send_icon(#0077ff).png', '387b3b9af8'),
('COLLEGE-1592849860', 'send_icon.png', 'c621cb5dff'),
('COLLEGE-1592849860', 'send_icon-hover.png', 'c28a133d57'),
('COLLEGE-1592849860', 'upload_file_icon.png', 'cabb5aa3e0'),
('IMAGE-COLLEGE-1592849860', 'ALWAYS_REMEMBER.jpg', 'ae72033321'),
('IMAGE-COLLEGE-1592874229', '3b380cbf76~2.jpg', '1c3fa43ac9'),
('IMAGE-COLLEGE-1592874295', '3b380cbf76~2.jpg', 'b4c4a73014'),
('IMAGE-COLLEGE-1592874324', 'ALWAYS_REMEMBER.jpg', '13304e53c9'),
('IMAGE-COLLEGE-1592874346', '3b380cbf76~2.jpg', 'a896764079'),
('IMAGE-COLLEGE-1592881923', 'ALWAYS_REMEMBER.jpg', '5bf2168256'),
('IMAGE-COLLEGE-1592882018', '6466451780.jpg', '2ed9b1038f'),
('IMAGE-COLLEGE-1592886610', 'ALWAYS_REMEMBER.jpg', '4fd115506e'),
('IMAGE-COLLEGE-1592886982', 'ALWAYS_REMEMBER.jpg', 'ba0030e9c9'),
('IMAGE-COLLEGE-1592887360', 'ALWAYS_REMEMBER.jpg', 'c63add19cf'),
('IMAGE-COLLEGE-1592887661', 'ALWAYS_REMEMBER.jpg', '719e97a7fa'),
('IMAGE-COLLEGE-1592888106', 'ALWAYS_REMEMBER.jpg', 'a6e4465233'),
('IMAGE-COLLEGE-1592888275', 'ALWAYS_REMEMBER.jpg', 'ea05c91791'),
('IMAGE-COLLEGE-1592888335', 'ALWAYS_REMEMBER.jpg', 'e169d75fcd'),
('IMAGE-COLLEGE-1592888663', 'ALWAYS_REMEMBER.jpg', 'f6e229e934'),
('IMAGE-COLLEGE-1592888772', 'ALWAYS_REMEMBER.jpg', '6fcb7c7d28'),
('IMAGE-COLLEGE-1592888873', 'ALWAYS_REMEMBER.jpg', 'd74972378c'),
('IMAGE-COLLEGE-1592889072', 'ALWAYS_REMEMBER.jpg', 'c14725718d'),
('IMAGE-COLLEGE-1592889106', 'ALWAYS_REMEMBER.jpg', 'a0e4ff4189'),
('IMAGE-COLLEGE-1592889146', 'ALWAYS_REMEMBER.jpg', '72af098b65'),
('IMAGE-COLLEGE-1592889285', 'ALWAYS_REMEMBER.jpg', '214b0fad16'),
('IMAGE-COLLEGE-1592889790', 'ALWAYS_REMEMBER.jpg', '173851e5fc'),
('IMAGE-COLLEGE-1592890090', 'ALWAYS_REMEMBER.jpg', 'bba747ea40'),
('IMAGE-COLLEGE-1592890158', 'ALWAYS_REMEMBER.jpg', '324fadc9fa'),
('IMAGE-COLLEGE-1592890365', 'ALWAYS_REMEMBER.jpg', '5755b6b5b3'),
('IMAGE-COLLEGE-1592890428', 'ALWAYS_REMEMBER.jpg', '0c0e5a4645'),
('IMAGE-COLLEGE-1592890506', 'ALWAYS_REMEMBER.jpg', '440ac49957'),
('IMAGE-COLLEGE-1592891074', 'ALWAYS_REMEMBER.jpg', 'caca4fe53d'),
('IMAGE-COLLEGE-1592891689', 'ALWAYS_REMEMBER.jpg', '5538db21c9'),
('IMAGE-COLLEGE-1592891792', 'ALWAYS_REMEMBER.jpg', 'fba146ff04'),
('IMAGE-COLLEGE-1592891873', 'ALWAYS_REMEMBER.jpg', '8ea87cdbfc'),
('IMAGE-COLLEGE-1592892388', 'ALWAYS_REMEMBER.jpg', 'aa21bc536a'),
('IMAGE-COLLEGE-1592892554', 'ALWAYS_REMEMBER.jpg', '78d83c18f5'),
('IMAGE-COLLEGE-1592892764', 'ALWAYS_REMEMBER.jpg', 'b622270224'),
('IMAGE-COLLEGE-1592892967', 'Mobile_Parts.png', 'c972296850'),
('IMAGE-COLLEGE-1592893080', 'ALWAYS_REMEMBER.jpg', 'dd73dfedcc'),
('IMAGE-COLLEGE-1592893171', '3b380cbf76~2.jpg', 'bbf0033015'),
('IMAGE-COLLEGE-1592893486', '29ae613d00.jpg', '85ad9c8838'),
('IMAGE-COLLEGE-1592893602', '3b380cbf76~3.jpg', 'd7eafa263d'),
('IMAGE-COLLEGE-1592893654', 'd7eafa263d.jpg', 'a0c92536b5'),
('IMAGE-COLLEGE-1592894026', 'dd73dfedcc.jpg', 'aff4a1ba22'),
('IMAGE-COLLEGE-1592894316', 'aff4a1ba22.jpg', 'fc2462f17c'),
('IMAGE-COLLEGE-1592894511', 'aff4a1ba22.jpg', '4561c59492'),
('IMAGE-COLLEGE-1592894599', 'd7eafa263d.jpg', 'e230ff93ae'),
('IMAGE-COLLEGE-1592894655', 'a0c92536b5.jpg', '27e8dd853b'),
('IMAGE-COLLEGE-1592894887', '3b380cbf76~3.jpg', '0ef9667c32'),
('IMAGE-COLLEGE-1592920617', '010a44e0f1.jpg', 'de62d1a86d'),
('IMAGE-COLLEGE-1592926680', '3b380cbf76.jpg', 'c3f7d996be'),
('IMAGE-COLLEGE-1592927411', '010a44e0f1.jpg', '07200db594'),
('COLLEGE-1592928073', '05fc929ebe.png', '838076f740'),
('IMAGE-COLLEGE-1592928410', 'fc2462f17c.jpg', 'c66c834b67'),
('IMAGE-COLLEGE-1592929197', 'c66c834b67.jpg', 'e790e6086c'),
('IMAGE-COLLEGE-1592929936', 'e790e6086c.jpg', '294f4fca11'),
('IMAGE-COLLEGE-1592929973', '294f4fca11.jpg', '6d9281ecbd'),
('IMAGE-COLLEGE-1592930241', '6d9281ecbd.jpg', '27c031cdf2'),
('IMAGE-COLLEGE-1592933688', '0c0e5a4645.jpg', '1f1cd82196'),
('IMAGE-COLLEGE-1592934944', '1f1cd82196.jpg', 'd7a5c51d5c'),
('IMAGE-COLLEGE-1592935020', 'd7a5c51d5c.jpg', '2ce94d5861'),
('IMAGE-COLLEGE-1592935129', '2ce94d5861.jpg', 'e2c5fdb4bc'),
('IMAGE-COLLEGE-1592935177', 'e2c5fdb4bc.jpg', '6ed3569346'),
('IMAGE-COLLEGE-1592936361', 'e2c5fdb4bc.jpg', '8f96b671b9'),
('IMAGE-COLLEGE-1592936477', '8f96b671b9.jpg', '822d6146d3'),
('IMAGE-COLLEGE-1592936750', '822d6146d3.jpg', '8cf6df4c07'),
('IMAGE-COLLEGE-1592937136', '8cf6df4c07.jpg', '90ff2eadb8'),
('IMAGE-COLLEGE-1592937285', '90ff2eadb8.jpg', '59a67e397a'),
('IMAGE-COLLEGE-1592937374', 'e2c5fdb4bc.jpg', 'defaa55828'),
('IMAGE-COLLEGE-1592941650', 'defaa55828.jpg', '46b590e78e'),
('IMAGE-COLLEGE-1592979002', 'aa21bc536a.jpg', '7b9df6f288'),
('IMAGE-COLLEGE-1592979332', 'aa21bc536a.jpg', '3b2fb8767b'),
('IMAGE-COLLEGE-1592979883', '3b2fb8767b.jpg', '76f45fcd9b'),
('IMAGE-COLLEGE-1592985005', '3b380cbf76.jpg', '4e066df1e9'),
('IMAGE-COLLEGE-1592985799', '3b380cbf76.jpg', '71924937ed'),
('IMAGE-COLLEGE-1592985924', '3b380cbf76.jpg', '4a8c7e3daa'),
('COLLEGE-1592985799', 'black_image.jpg', 'ffb540e542'),
('COLLEGE-1592985924', '3b380cbf76.jpg', '70f8700c00'),
('COLLEGE-1592985799', 'white_image.png', 'f10c1957d2'),
('IMAGE-COLLEGE-1592986318', '3b380cbf76.jpg', 'a5086bae02'),
('COLLEGE-1592986318', 'Marks@Janu.pdf', '1f4f9989bb'),
('COLLEGE-1592986318', 'marks@janu (1).pdf', '32073e8643'),
('COLLEGE-1592986318', '2972466_NDAnew.docx', '18b3eb7efa');

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

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `expire_otps` ON SCHEDULE EVERY 1 MINUTE STARTS '2020-04-01 00:00:00' ENDS '2020-04-30 00:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `notices_by` SET otp=null, generated_time=null WHERE (UNIX_TIMESTAMP()-generated_time>60)$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
