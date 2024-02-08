-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2024 at 02:58 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fName` text NOT NULL,
  `lName` text NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `reg_date` int(11) NOT NULL,
  `last_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fName`, `lName`, `username`, `email`, `password`, `reg_date`, `last_login`) VALUES
(1, 'Quiz', 'Admin', 'admin', 'admin@quizapp.com', '$2y$10$spTFyNNlh.lMzEHOxPUY4.7b2Uh8vTQ2Gnfv2B3734LGNmyrRZr4C', 1665506571, 1665506571);

-- --------------------------------------------------------

--
-- Table structure for table `attempted`
--

CREATE TABLE `attempted` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `attempts` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  `date_started` int(11) NOT NULL,
  `date_submited` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attempted`
--

INSERT INTO `attempted` (`id`, `user_id`, `quiz_id`, `attempts`, `score`, `percentage`, `date_started`, `date_submited`) VALUES
(2, 9, 4, 27, 1, 50, 1672428694, 1672428700),
(7, 5, 4, 1, 2, 100, 1672427872, 1672427908),
(9, 15, 1, 1, 2, 67, 1679960042, 1679960066),
(10, 5, 1, 1, 0, 0, 1699380341, 1699380369);

-- --------------------------------------------------------

--
-- Table structure for table `attempts`
--

CREATE TABLE `attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` int(11) NOT NULL,
  `correct` int(11) NOT NULL,
  `date_started` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attempts`
--

INSERT INTO `attempts` (`id`, `user_id`, `quiz_id`, `question_id`, `answer`, `correct`, `date_started`) VALUES
(107, 5, 4, 1, 74, 74, 1672427872),
(108, 5, 4, 2, 84, 84, 1672427872),
(140, 9, 4, 1, 0, 0, 1673784675),
(141, 9, 4, 2, 0, 0, 1673784675),
(145, 9, 1, 1, 0, 0, 1678564515),
(146, 9, 1, 2, 0, 0, 1678564515),
(147, 9, 1, 3, 0, 0, 1678564515),
(154, 15, 1, 1, 0, 0, 1679960589),
(155, 15, 1, 2, 0, 0, 1679960589),
(156, 15, 1, 3, 0, 0, 1679960589),
(160, 5, 1, 1, 0, 0, 1699380392),
(161, 5, 1, 2, 0, 0, 1699380392),
(162, 5, 1, 3, 0, 0, 1699380392);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_id` text NOT NULL,
  `class_name` text NOT NULL,
  `teacher` int(11) DEFAULT 0,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_id`, `class_name`, `teacher`, `date_created`) VALUES
(1, '1584', '100 Level', 1, 1666432998),
(2, '6865', '200 Level', 0, 1666433951),
(3, '8512', '300 Level', 0, 1666474682),
(5, '3541', '500 Level', 0, 1666474710),
(9, '8247', '400 Level', 0, 1666487041);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_id` text NOT NULL,
  `course_category_id` int(11) NOT NULL,
  `course_name` text NOT NULL,
  `course_short_name` text NOT NULL,
  `level` int(11) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_id`, `course_category_id`, `course_name`, `course_short_name`, `level`, `date_created`) VALUES
(1, '60302', 4, 'Introduction to Plant Biology', 'BIOL 111', 1, 1666483309),
(2, '66754', 4, 'Introduction to Animal Biology', 'BIOL 113', 1, 1666484032),
(3, '47974', 1, 'Trigonometry', 'MATHS 103', 1, 1666484684),
(7, '99319', 1, 'Differential And Integral Calculus', 'MATHS 105', 1, 1677889627),
(8, '28682', 1, 'Sets And Number Systems', 'MATHS 101', 1, 1677889673),
(9, '66661', 3, 'Introductory Chemistry Practical 1', 'CHEM 161', 1, 1677889787),
(10, '10139', 3, 'Introductory Inorganic Chemistry', 'CHEM 121', 1, 1677889823),
(11, '61220', 3, 'Introductory General Chemistry', 'CHEM 101', 1, 1677889855),
(12, '95358', 7, 'General Physics Practical 1', 'PHYS 161', 1, 1677889929),
(13, '89967', 7, 'Heat And Properties Of Matter', 'PHYS 131', 1, 1677889968),
(14, '70945', 7, 'Introductory Mechanics', 'PHYS 111', 1, 1677889998);

-- --------------------------------------------------------

--
-- Table structure for table `course_category`
--

CREATE TABLE `course_category` (
  `id` int(11) NOT NULL,
  `cat_id` text NOT NULL,
  `cat_name` text NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_category`
--

INSERT INTO `course_category` (`id`, `cat_id`, `cat_name`, `date_created`) VALUES
(1, '405', 'Mathematics', 1665598103),
(2, '432', 'English', 1665598159),
(3, '147', 'Chemistry', 1666128231),
(4, '730', 'Biology', 1666128662),
(7, '602', 'Physics', 1666209850);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `userid`, `state`) VALUES
(1, 5, 1),
(5, 9, 1),
(8, 15, 0);

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_no` int(11) NOT NULL,
  `percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leaderboard`
--

INSERT INTO `leaderboard` (`id`, `user_id`, `quiz_no`, `percentage`) VALUES
(2, 5, 2, 50),
(3, 9, 2, 59),
(4, 15, 1, 67);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `head` text NOT NULL,
  `body` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `head`, `body`, `date_created`) VALUES
(1, 'Welcome Message', 'Welcome to this great platform. We hope you find our resources helpful.', '2022-11-28 08:33:14');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option` text NOT NULL,
  `answer` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `option`, `answer`) VALUES
(69, 11, 'Yes', 1),
(70, 11, 'No', 0),
(71, 11, 'Maybe', 0),
(72, 11, 'I don\'t know', 0),
(73, 11, 'None of the above', 0),
(74, 12, 'Yes', 1),
(75, 12, 'No', 0),
(76, 12, 'Partially', 0),
(77, 12, 'I don\'t know', 0),
(78, 13, 'Eye', 0),
(79, 13, 'Nose', 0),
(80, 13, 'Skin', 0),
(81, 13, 'Mouth', 1),
(82, 14, '1', 0),
(83, 14, '2', 0),
(84, 14, '3', 1),
(85, 14, '4', 0),
(90, 15, 'Hesseinberg Uncertainty Principle', 0),
(91, 15, 'De broglie\'s equation', 1),
(92, 15, 'Eistein mass equation', 0),
(93, 15, 'Schrodeinger wave equation', 0),
(94, 16, '2n', 0),
(95, 16, 'n', 0),
(96, 16, '2n2', 1),
(97, 16, '3n', 0),
(98, 17, '0 to n+2', 0),
(99, 17, '0 to n+1', 0),
(100, 17, '0 to 1,2,3', 0),
(101, 17, '0 to n-1', 1),
(102, 18, '3', 1),
(103, 18, '4', 0),
(104, 18, '5', 0),
(105, 18, '10', 0),
(106, 19, '6', 1),
(107, 19, '5', 0),
(108, 19, '10', 0),
(109, 19, '3', 0),
(110, 20, '4s, 4p, 4d, 4f', 0),
(111, 20, '5s, 5p, 5d, 5f', 0),
(112, 20, '3s, 3p, 3d, 3f', 1),
(113, 20, '2s, 2p, 2d, 2f', 0),
(114, 21, '2 electron', 0),
(115, 21, '1 electron', 0),
(116, 21, '6 electron', 1),
(117, 21, '4 electron', 0),
(118, 22, 'De broglie\'s equation', 0),
(119, 22, 'Hessenberg uncertainty principle', 0),
(120, 22, 'Quantum mechanics', 1),
(121, 22, 'Rutherford model', 0),
(122, 23, 'Emission', 0),
(123, 23, 'Absorption', 1),
(124, 23, 'Adsorption', 0),
(125, 23, 'Ground state', 0),
(126, 24, 'Size, orientation and shape', 0),
(127, 24, 'Shape, size and orientation', 0),
(128, 24, 'None of the above', 0),
(129, 24, 'Size, shape and orientation', 1),
(130, 25, '2n +1', 0),
(131, 25, '2l +1', 0),
(132, 25, '2n', 0),
(133, 25, '2l', 1),
(134, 26, '90.18K, 50.1Â°R', 0),
(135, 26, '90.18K, 162.324Â°R', 1),
(136, 26, '455.97K, 50.1Â°R', 0),
(137, 26, '455.97K, 162.324Â°R', 0),
(138, 27, '32Â°', 0),
(139, 27, '40Â°', 0),
(140, 27, '-32Â°', 0),
(141, 27, '-40Â°', 1),
(142, 28, 'mercury-in-glass thermometer', 0),
(143, 28, 'alcohol-in-glass thermometer', 0),
(144, 28, 'platinum resistance thermometer', 0),
(145, 28, 'thermocouple thermometer', 1),
(146, 29, 'mercury and water', 0),
(147, 29, 'water and alcohol', 0),
(148, 29, 'alcohol and mercury', 1),
(149, 29, 'mercury and bromine', 0),
(150, 30, '1 degree on the Kelvin scale', 0),
(151, 30, '1 degree on the celcius scale', 0),
(152, 30, '1 degree on the Fahrenheit scale', 0),
(153, 30, '1 degree on the reamur scale', 1),
(154, 31, '57oC', 0),
(155, 31, '157 oC', 0),
(156, 31, '257 oC', 0),
(157, 31, '357 oC', 1),
(158, 32, '345.652 K', 0),
(159, 32, '476 oC', 0),
(160, 32, '345.652 oC', 0),
(161, 32, '400 K', 1),
(162, 33, 'they are in contact with each other and can freely exchange energy', 0),
(163, 33, 'they have the same amount of thermal energy', 0),
(164, 33, 'they have the same temperature', 1),
(165, 33, 'none of the options', 0),
(166, 34, 'heat', 1),
(167, 34, 'temperature', 0),
(168, 34, 'specific heat', 0),
(169, 34, 'adiabatic heat', 0),
(170, 35, '44.4 oC', 1),
(171, 35, '225 oC', 0),
(172, 35, '2.25 oC', 0),
(173, 35, '68 oC', 0),
(174, 36, '20.7 oC', 0),
(175, 36, '12 oC', 0),
(176, 36, '618.46oC', 1),
(177, 36, '80 oC', 0),
(178, 37, '85.1 cm', 0),
(179, 37, '1.85 cm', 1),
(180, 37, '3.25 cm', 0),
(181, 37, '17.43 cm', 0),
(182, 38, 'thermal equilibrant', 0),
(183, 38, 'thermal equilibrium', 1),
(184, 38, 'thermal dissociation', 0),
(185, 38, 'thermodynamics', 0),
(186, 39, '0.0718 kg', 1),
(187, 39, '7.18 kg', 0),
(188, 39, '0.718 kg', 0),
(189, 39, '0.00718 kg', 0),
(190, 40, 'Fusion', 1),
(191, 40, 'combustion', 0),
(192, 40, 'specific heat capacity', 0),
(193, 40, 'Heat capacity', 0),
(194, 41, '50.9g', 0),
(195, 41, '56.2g', 0),
(196, 41, '5.26g', 0),
(197, 41, '52.6g', 1),
(198, 42, '66oC', 0),
(199, 42, '67oC', 0),
(200, 42, '0.76oC', 0),
(201, 42, '0.66oC', 1),
(202, 43, '7216J', 0),
(203, 43, '5213kJ', 0),
(204, 43, '2160kJ', 0),
(205, 43, '20kJ', 1),
(206, 44, 'increases the kinetic energy of the molecules of the solid', 1),
(207, 44, 'increases the potential energy of the molecules', 0),
(208, 44, 'increases both the kinetic energy and potential energy of the molecules', 0),
(209, 44, 'is converted to mechanical energy of the molecule', 0),
(210, 45, '67 oC', 0),
(211, 45, '12 oC', 0),
(212, 45, '279.7K', 0),
(213, 45, '300K', 1),
(214, 46, '0.042%', 1),
(215, 46, '0.039%', 0),
(216, 46, '-0.39%', 0),
(217, 46, '-0.039%', 0),
(218, 47, 'Less than 30cm', 0),
(219, 47, 'Equal to 30cm', 1),
(220, 47, 'Not predictable', 0),
(221, 47, 'More than 30cm', 0),
(222, 48, 'gases have definite shape', 0),
(223, 48, 'particles are far apart and move randomly', 1),
(224, 48, 'all of the above', 0),
(225, 48, 'non of the above', 0),
(226, 49, 'increase in the density of the vapour', 1),
(227, 49, 'increase in the number of molecules striking the liquid', 0),
(228, 49, 'increase in the liquid', 0),
(229, 49, 'all the options', 0),
(230, 50, 'their volume increases', 1),
(231, 50, 'their pressure  decreases', 0),
(232, 50, 'their pressure increases', 0),
(233, 50, 'none of the above', 0),
(234, 51, 'it isnâ€™t different', 0),
(235, 51, 'it occurs at any temperature', 1),
(236, 51, 'it happens throughout a liquid', 0),
(237, 51, 'all of the above', 0),
(238, 52, 'CV â€“ CP =R', 0),
(239, 52, 'CP â€“ CV =R', 1),
(240, 52, 'CV + CP =R', 0),
(241, 52, 'CV = R - CP', 0),
(242, 53, '15.6 Nm-2', 1),
(243, 53, '280 Nm-2', 0),
(244, 53, '18 Nm-2', 0),
(245, 53, '39 Nm-2', 0),
(246, 54, '525 K', 0),
(247, 54, '298K', 0),
(248, 54, '670K', 0),
(249, 54, '894K', 1),
(250, 55, 'bacterial and blue-green algea', 1),
(251, 55, 'bacterial and green algae', 0),
(252, 55, 'bacterial and green algae', 0),
(253, 55, 'bacterial and all the eukaryotic algae', 0),
(254, 56, 'completely false', 0),
(255, 56, 'completely true', 1),
(256, 56, 'sometimes true', 0),
(257, 56, 'sometimes false', 0),
(258, 57, 'Phenetic', 0),
(259, 57, 'Artificial', 0),
(260, 57, 'Natural', 1),
(261, 57, 'Molecular', 0),
(262, 58, 'Division', 1),
(263, 58, 'family', 0),
(264, 58, 'species', 0),
(265, 58, 'class', 0),
(266, 59, 'proctista', 1),
(267, 59, 'monera', 0),
(268, 59, 'protozoa', 0),
(269, 59, 'phycotinae', 0),
(270, 60, 'International standard for botanical nomenclature', 0),
(271, 60, 'International circle for botanical nomenclature', 0),
(272, 60, 'International authority for botanical nomenclature', 0),
(273, 60, 'International code for botanical nomenclature', 1),
(274, 61, 'Blue algae', 0),
(275, 61, 'red algae', 0),
(276, 61, 'blue-green algae', 1),
(277, 61, 'green algae', 0),
(298, 62, 'Thallophytes', 1),
(299, 62, 'Bryophytes', 0),
(300, 62, 'Pteridophtes', 0),
(301, 62, 'Anthocerophytes', 0),
(302, 63, 'Fertile', 0),
(303, 63, 'sterile', 1),
(304, 63, 'mobile', 0),
(305, 63, 'stable', 0),
(311, 5, 'Gean Lamark', 0),
(312, 5, 'Carolous Linneaus', 1),
(313, 5, 'charles Darwin', 0),
(314, 5, 'Dalton', 0),
(315, 5, 'None of the above', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL DEFAULT 0,
  `quiz_id` int(11) NOT NULL DEFAULT 0,
  `folder` int(11) NOT NULL DEFAULT 0,
  `question` text NOT NULL,
  `image` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `course_id`, `topic_id`, `quiz_id`, `folder`, `question`, `image`) VALUES
(5, 1, 2, 1, 0, 'Who is the father of Biology?', 0),
(11, 1, 2, 1, 0, 'Do plants breathe?', 0),
(12, 3, 5, 4, 0, 'Do you love mathematics?', 0),
(13, 1, 2, 1, 0, 'Which of the following is not a sense organ?', 0),
(14, 3, 5, 4, 0, 'How many ways can quadrtic equations be solved?', 0),
(15, 10, 12, 15, 0, '1. Quantum Number are solutions of ___', 0),
(16, 10, 12, 15, 0, 'What is the maximum number of electron in a shell?', 0),
(17, 10, 12, 15, 0, 'What is the range of Azimuthal quantum number', 0),
(18, 10, 12, 15, 0, 'How many sub-orbital can be found in 3d orbital', 0),
(19, 10, 12, 15, 0, '3s sub-shell contain how many electron?', 0),
(20, 10, 12, 15, 0, 'What are the possible sub-shell when n=4?', 0),
(21, 10, 12, 15, 0, 'What is the number of electron in an atom in an orbital that have the following quantum number n=2 l=1', 0),
(22, 10, 12, 15, 0, 'The present day picture of the atom is based on ______?', 0),
(23, 10, 12, 15, 0, 'The transition from n=1 to n=2 indicates', 0),
(24, 10, 12, 15, 0, 'Principal, Azimuthal and magnetic quantum number are respectively related to', 0),
(25, 10, 12, 15, 0, 'The value of the magnetic quantum number are', 0),
(26, 14, 15, 14, 0, 'The normal boiling point of liquid oxygen is -182.97Â°C, what is this temperature on the Kelvin and Rankine scales?', 0),
(27, 14, 15, 14, 0, 'At what temperature do the Fahrenheit and the Celsius scales coincide?', 0),
(28, 14, 15, 14, 0, 'The thermometer that can measure rapidly changing temperature is', 0),
(29, 14, 15, 14, 0, 'Which two liquids are used in the construction of minimum and maximum thermometers', 0),
(30, 14, 15, 14, 0, 'Which one among the following denotes the smallest temperature?', 0),
(31, 14, 15, 14, 0, 'Mercury has the boiling point of', 0),
(32, 14, 15, 14, 0, 'The resistance of a platinum coil platinum resistance thermometer at 0 oC is 5 Ohms and at 100 oC is 5.39 Ohms. When this thermometer is put in hot bath, the resistance of the platinum wire is found to be 5.795 Ohms. The temperature of the bath is ?', 0),
(33, 14, 15, 14, 0, 'Two bodies can be said to be in  thermal equilibrium when', 0),
(34, 14, 15, 14, 0, 'The spontaneous transfer of energy due to a temperature difference is?', 0),
(35, 14, 15, 14, 0, 'A gas thermometer is used to measure the temperature of furnace and indicates the ice and steam point as 27 mmHg and 90 mmHg respectively. At what temperature will it record 55 mmHg', 0),
(36, 14, 15, 14, 0, 'A constant mass of gas maintained at a constant pressure has volume of 2.5 x 104m3 at 0 oC,  3.15 x 104m3 at 100 oC and 6.52 x 104m3 at normal boiling point of sulphur. The temperature corresponding to the boiling point of sulphur is?', 0),
(37, 14, 15, 14, 0, 'in a certain thermometer, the 0 oC mark corresponds to 1.50cm, the 100 oC mark corresponds to 3.25 cm. What will be the length for a corresponding temperature of 20 m oC', 0),
(38, 14, 15, 14, 0, 'When the temperature of two systems are different, they  cannot be in', 0),
(39, 14, 15, 14, 0, 'An electric heater that produces 900W of power is used to vaporize water. The amount of water at 100 oC that can be changed to steam in 3 min by the heater is?', 0),
(40, 14, 15, 14, 0, 'The heat required to convert a unit mass of solid at its melting point into liquid at the same temperature is called', 0),
(41, 14, 15, 14, 0, 'The specific heat capacity of water is 10 times that of copper. The mass of a copper at a temperature of 50oC required to raise the temperature of 100g of water from 10 oC to 12 oC is ? Assuming no energy is lost to the surrounding', 0),
(42, 14, 15, 14, 0, 'A body of specific heat capacity 450J/kg  falls to the ground from rest through a vertical of 30.5m. The change in temperature of the body on striking the ground is.', 0),
(43, 14, 15, 14, 0, 'How many joules are required to raise the temperature of 500g of copper from 20 oC to 120 oC. Take the specific heat capacity to be 400J/kgK', 0),
(44, 14, 15, 14, 0, 'The temperature of a solid does not increase during melting. The heat energy supplied', 0),
(45, 14, 15, 14, 0, 'The temperature that results when 150g of ice at 0 oC is mixed with 300g of water at 50 oC is ?', 0),
(46, 14, 15, 14, 0, 'A steel tape is calibrated at 20 oC on a cold day when temperature is -15 oC, what will be the percentage error in the tape?', 0),
(47, 14, 15, 14, 0, 'A steel tape is calibrated at 20 oC. A piece of wood is being measured by the steel tape at 10 oC and reading is 30cm on the tape. The real length of the wood is?', 0),
(48, 14, 15, 14, 0, 'Which of the following is/are correct about gases?', 0),
(49, 14, 15, 14, 0, 'A decrease in the volume of the vessel containing boiling water will yield?', 0),
(50, 14, 15, 14, 0, 'What happens to gases in a fixed container when their temperature increases', 0),
(51, 14, 15, 14, 0, 'How is evaporation different from boiling', 0),
(52, 14, 15, 14, 0, 'The mayerâ€™s equation is given by', 0),
(53, 14, 15, 14, 0, 'A  40cm3 of air at a pressure of 7Nm-2 is enclosed in metallic tube by a piston. If the piston is pushed in a distance of 12cm at a constant temperature, what will be the pressure of the air  if the cross-sectional area of the tube is 1.5 cm2 ?', 0),
(54, 14, 15, 14, 0, 'A gas occupies certain volume at 25 oC at a constant pressure. At what temperature will the volume be three times the original volume', 0),
(55, 2, 6, 5, 0, 'Two example of Monera are', 0),
(56, 2, 6, 5, 0, 'The statement â€Bacterial are strucï¿¾turally simple but biochemically complexâ€ is', 0),
(57, 2, 6, 5, 0, 'Which of the following types of classification reflects genetic and evolutionary relationship ?', 0),
(58, 2, 6, 5, 0, 'Which of the following taxonomic rank ends with the suffix â€phytaâ€', 0),
(59, 2, 6, 5, 0, 'New system of classification place bacteria in', 0),
(60, 2, 6, 5, 0, 'Plants are named according to rules contain in', 0),
(61, 2, 6, 5, 0, 'Cyanobacteria was formerly known as', 0),
(62, 1, 6, 5, 0, 'Algae and fungi are', 0),
(63, 2, 6, 5, 0, 'Gametangia of bryophytes and pterodophytes always have a protective jacket of .....cells', 0);

-- --------------------------------------------------------

--
-- Table structure for table `question_folders`
--

CREATE TABLE `question_folders` (
  `id` int(11) NOT NULL,
  `folder_name` text NOT NULL,
  `date_created` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_folders`
--

INSERT INTO `question_folders` (`id`, `folder_name`, `date_created`) VALUES
(2, 'BIOLOGY FOLDER', '2022-11-17 04:36:57'),
(3, 'BIOL 111 MOCK', '2023-03-10 08:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `quizes`
--

CREATE TABLE `quizes` (
  `id` int(11) NOT NULL,
  `quizID` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `quiz_name` text NOT NULL,
  `attempts` int(11) NOT NULL,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT 40
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizes`
--

INSERT INTO `quizes` (`id`, `quizID`, `course_id`, `topic_id`, `quiz_name`, `attempts`, `start_date`, `end_date`, `duration`) VALUES
(1, 7745610, 1, 2, 'Exercise 1', 1000, 1667046240, 1699615440, 40),
(4, 8744832, 3, 5, 'Exercise 1', 1000, 1668670320, 1672471980, 1),
(5, 6649612, 1, 6, 'MOCK TEST', 1, 1677862020, 1677862020, 40),
(6, 5246112, 2, 7, 'MOCK TEST', 1, 1677862080, 1677862080, 40),
(7, 4061436, 3, 8, 'MOCK TEST', 1, 1677862080, 1677862080, 60),
(8, 1021745, 7, 9, 'MOCK TEST', 1, 1677862140, 1677862140, 60),
(9, 8442110, 8, 10, 'MOCK TEST', 1, 1677862140, 1677862140, 60),
(10, 6165327, 9, 11, 'MOCK TEST', 1, 1677862140, 1677862140, 40),
(12, 2212490, 11, 13, 'MOCK TEST', 1, 1677862260, 1677862260, 40),
(13, 2773859, 12, 14, 'MOCK TEST', 1, 1677862320, 1677862320, 40),
(14, 9137721, 13, 15, 'MOCK TEST', 1, 1677862320, 1677862320, 50),
(15, 9633395, 10, 12, 'MOCK TEST', 1, 1677862440, 1677862440, 40),
(16, 6484742, 14, 16, 'MOCK TEST', 1, 1677862500, 1677862500, 40);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `school_name` text DEFAULT 'Codextra International School',
  `school_short_name` text DEFAULT 'CIS',
  `school_motto` text DEFAULT 'Excelence In Educational Service',
  `facebook` text DEFAULT 'https://www.facebook.com/insideabucampus',
  `twitter` text DEFAULT 'https://www.twitter.com/insideabucampus',
  `instagram` text DEFAULT 'https://www.instagram.com/insideabucampus',
  `phone` text NOT NULL DEFAULT '09016242310'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `school_name`, `school_short_name`, `school_motto`, `facebook`, `twitter`, `instagram`, `phone`) VALUES
(1, 'Codextra International School', 'CIS', 'Excelence In Educational Service', 'https://www.facebook.com/insideabucampus', 'https://www.twitter.com/insideabucampus', 'https://www.instagram.com/insideabucampus', '+2349016242310');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `teacherID` text DEFAULT NULL,
  `fName` text NOT NULL,
  `lName` text NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `city` text DEFAULT 'default',
  `phone` text DEFAULT '0808080',
  `sex` text NOT NULL DEFAULT 'Others',
  `password` text NOT NULL,
  `reg_date` int(11) NOT NULL,
  `last_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `teacherID`, `fName`, `lName`, `username`, `email`, `city`, `phone`, `sex`, `password`, `reg_date`, `last_login`) VALUES
(1, 'STAFF/473', 'Odunayo', 'Joseph', 'codextra', 'insideabucampus@gmail.com', 'Zaria', '08147636364', 'Male', '$2y$10$ZppJj8CY1075WrzoVTu9R.NZboDHCcHKjVJKjvYa6qmfxEnJtLmNO', 1666579728, 1666579728),
(4, 'STAFF/007', 'Bawa', 'Abubakar', 'bawa', 'bawachem101@gmail.com', 'default', '0808080', 'Others', '$2y$10$9s5PNVpXWZkYF7w9C3bEpuhs41.RnYiHdM7PfgAoPDxdJTMzMCxEu', 1678216322, 1678216322),
(5, 'STAFF/089', 'Salman', 'Abdurasheed', 'mashallah', 'mashallah@gmail.com', 'default', '0808080', 'Others', '$2y$10$Vs3TlJjVFZYNIwAOq8Boz.6rnyTBexH57yCsSgG.y6ebgFDa79urK', 1678216428, 1678216428),
(6, 'STAFF/526', 'Yuguda', 'Muhammad', 'yuguda', 'yugudamuhammad@gmail.com', 'default', '0808080', 'Others', '$2y$10$JZ7ezR63NXNn7lEbzQArwe4tj.uSPuZaAF5vNn2U9L212WcSKTELG', 1678651941, 1678651941);

-- --------------------------------------------------------

--
-- Table structure for table `teachers_enrollment`
--

CREATE TABLE `teachers_enrollment` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers_enrollment`
--

INSERT INTO `teachers_enrollment` (`id`, `teacher_id`, `course_id`, `date_created`) VALUES
(10, 1, 1, '2022-11-27 16:30:11'),
(13, 4, 11, '2023-03-07 19:12:19'),
(14, 5, 10, '2023-03-07 19:14:41'),
(15, 6, 13, '2023-03-12 20:13:35'),
(16, 6, 14, '2023-03-12 20:13:47'),
(17, 1, 2, '2023-03-12 20:14:14');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_img`
--

CREATE TABLE `teacher_img` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher_img`
--

INSERT INTO `teacher_img` (`id`, `teacher_id`, `status`) VALUES
(1, 1, 1),
(4, 4, 0),
(5, 5, 0),
(6, 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `topicID` text NOT NULL,
  `course_id` text NOT NULL,
  `topic_name` text NOT NULL,
  `topic_desc` text NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `topicID`, `course_id`, `topic_name`, `topic_desc`, `date_created`) VALUES
(2, '121418', '1', 'Intro to Plant Biology', 'Introduction to plant biology. In this topic, you will learn the basics about plants around you.', 1666985997),
(4, '680919', '3', 'Introduction', 'Welcome To Math 103.', 1667172038),
(5, '450786', '3', 'Geometry', 'Learn Geometry', 1668567723),
(6, '640129', '1', 'BIOL 111 Mock Test', 'A good way to prepare for test is to take a mock. This mock contains likely questions you might come across in your test.', 1677890114),
(7, '505059', '2', 'BIOL 113 Mock Test', 'A better way to prepare for test is to take a mock. This mock contains likely questions you might come across in your test.', 1677890193),
(8, '353041', '3', 'MATHS 103 Mock Test', 'A good way to prepare for test is to take a mock. This mock contains likely questions you might come across in your test', 1677890240),
(9, '768598', '7', 'MATHS 105 Mock Test', 'A good way to prepare for test is to take a mock test. This mock contains likely questions you might come across in your test.', 1677890284),
(10, '115500', '8', 'MATHS 101 Mock Test', 'A good way to prepare for test is to take a mock. MATHS 101 mock test contains likely questions you might come across in your test.', 1677890344),
(11, '763159', '9', 'CHEM 161 Mock Test', 'A good way to prepare for test is to take a mock. CHEM 161 mock test contains likely questions you might come across in your test.', 1677890380),
(12, '817581', '10', 'CHEM 121 Mock Test', 'A good way to prepare for test is to take a mock. CHEM 121 mock test contains likely questions you might come across in your test.', 1677890413),
(13, '736427', '11', 'CHEM 101 Mock Test', 'A good way to prepare for test is to take a mock. CHEM101 mock test contains likely questions you might come across in your test.', 1677890445),
(14, '702274', '12', 'PHYS 161 Mock Test', 'A good way to prepare for test is to take a mock. PHYS 161 mock test contains likely questions you might come across in your test.', 1677890515),
(15, '652919', '13', 'PHYS 131 Mock Test', 'A good way to prepare for test is to take a mock. PHYS 131 mock test contains likely questions you might come across in your test.', 1677890548),
(16, '421685', '14', 'PHYS 111 Mock Test', 'A good way to prepare for test is to take a mock. PHYS 111 mock test contains likely questions you might come across in your test.', 1677890636),
(17, '364393', '10', 'Quantum Theory of Atomic orbital', 'Quantum orbital theory\nQuantum mechanics', 1678535984);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `studentID` tinytext DEFAULT NULL,
  `fName` tinytext NOT NULL,
  `lName` tinytext NOT NULL,
  `username` tinytext NOT NULL,
  `email` text NOT NULL,
  `city` tinytext DEFAULT 'default',
  `phone` tinytext DEFAULT '0808080',
  `plan` tinytext DEFAULT 'free',
  `level` int(11) DEFAULT 0,
  `sex` text NOT NULL DEFAULT 'Others',
  `password` longtext NOT NULL,
  `reg_date` int(11) NOT NULL,
  `last_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `studentID`, `fName`, `lName`, `username`, `email`, `city`, `phone`, `plan`, `level`, `sex`, `password`, `reg_date`, `last_login`) VALUES
(5, 'STD/005', 'Odunayo', 'Babatunde', 'codextra', 'rebeccaodunayo288@gmail.com', 'Lagos', '08036367586', 'paid', 1, 'Male', '$2y$10$spTFyNNlh.lMzEHOxPUY4.7b2Uh8vTQ2Gnfv2B3734LGNmyrRZr4C', 1665444358, 1665444358),
(9, 'STD/009', 'Nasir', 'Muhammad', 'NastyC', '001babyboy@gmail.com', 'default', '0808080', 'free', 1, 'Male', '$2y$10$Ylft5kfXrhoQFgotBs4WZ.bqGhkRXoAKPLDuBkFZFIPIhMkNju0mS', 1665503788, 1665503788),
(15, 'STD/0015', 'Wole', 'Odunayo', 'insideabu', 'insideabucampus@gmail.com', 'default', '0808080', 'free', 1, 'Others', '$2y$10$F35SjNVCkJ/IvAfZnMdLqOV4onunjsYn61k7Bu6CIKtMWzKsOxtH.', 1671872781, 1671872781);

-- --------------------------------------------------------

--
-- Table structure for table `users_enrollment`
--

CREATE TABLE `users_enrollment` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_enrollment`
--

INSERT INTO `users_enrollment` (`id`, `student_id`, `course_id`, `date_created`) VALUES
(3, 9, 2, '2022-11-24 13:14:05'),
(9, 9, 1, '2022-11-25 03:28:18'),
(10, 9, 3, '2022-11-25 03:35:22'),
(13, 15, 1, '2022-12-28 07:35:17'),
(14, 15, 3, '2022-12-30 19:16:31'),
(15, 5, 3, '2022-12-30 19:17:34'),
(16, 5, 1, '2022-12-30 22:24:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attempted`
--
ALTER TABLE `attempted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attempts`
--
ALTER TABLE `attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_category`
--
ALTER TABLE `course_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_folders`
--
ALTER TABLE `question_folders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizes`
--
ALTER TABLE `quizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers_enrollment`
--
ALTER TABLE `teachers_enrollment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_img`
--
ALTER TABLE `teacher_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_enrollment`
--
ALTER TABLE `users_enrollment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attempted`
--
ALTER TABLE `attempted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `attempts`
--
ALTER TABLE `attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `course_category`
--
ALTER TABLE `course_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `question_folders`
--
ALTER TABLE `question_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quizes`
--
ALTER TABLE `quizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachers_enrollment`
--
ALTER TABLE `teachers_enrollment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `teacher_img`
--
ALTER TABLE `teacher_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users_enrollment`
--
ALTER TABLE `users_enrollment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
