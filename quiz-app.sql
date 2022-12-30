-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2022 at 12:39 AM
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
(1, 'Quiz', 'Admin', 'admin', 'admin@quizapp.com', '$2y$10$h6U8jhDH3HHbpahyqfyMLOwUyVG982lYwVlIJNarzYcAVmtCoHXLO', 1665506571, 1665506571);

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
(4, 9, 1, 1, 2, 100, 1672220611, 1672221004),
(6, 15, 1, 1, 1, 50, 1672222931, 1672222951),
(7, 5, 4, 1, 2, 100, 1672427872, 1672427908),
(8, 5, 1, 2, 3, 100, 1672441715, 1672441724);

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
(59, 15, 1, 1, 0, 0, 1672244431),
(60, 15, 1, 2, 0, 0, 1672244431),
(103, 9, 1, 1, 0, 0, 1672427378),
(104, 9, 1, 2, 0, 0, 1672427378),
(107, 5, 4, 1, 74, 74, 1672427872),
(108, 5, 4, 2, 84, 84, 1672427872),
(115, 9, 4, 1, 74, 74, 1672428694),
(116, 9, 4, 2, 0, 84, 1672428694),
(123, 5, 1, 1, 55, 55, 1672441715),
(124, 5, 1, 2, 69, 69, 1672441715),
(125, 5, 1, 3, 81, 81, 1672441715);

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
(3, '47974', 1, 'Trigonometry', 'MATHS 103', 1, 1666484684);

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
(5, 9, 0),
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
(2, 5, 2, 100),
(3, 9, 2, 75);

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
(54, 5, 'Gean Lamark', 0),
(55, 5, 'Carolous Linneaus', 1),
(56, 5, 'charles Darwin', 0),
(57, 5, 'Dalton', 0),
(58, 5, 'None of the above', 0),
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
(85, 14, '4', 0);

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
(14, 3, 5, 4, 0, 'How many ways can quadrtic equations be solved?', 0);

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
(2, 'BIOLOGY FOLDER', '2022-11-17 04:36:57');

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
(1, 7745610, 1, 2, 'Exercise 1', 3, 1667046240, 1673349840, 40),
(4, 8744832, 3, 5, 'Exercise 1', 1000, 1668670320, 1672471980, 1);

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
(1, 'STAFF/473', 'Odunayo', 'Joseph', 'codextra', 'insideabucampus@gmail.com', 'Zaria', '08147636364', 'Male', '$2y$10$ZppJj8CY1075WrzoVTu9R.NZboDHCcHKjVJKjvYa6qmfxEnJtLmNO', 1666579728, 1666579728);

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
(10, 1, 1, '2022-11-27 16:30:11');

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
(1, 1, 1);

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
(3, '340105', '1', 'Algae', 'Introduction to aquatic plants.', 1667170872),
(4, '680919', '3', 'Introduction', 'Welcome To Math 103.', 1667172038),
(5, '450786', '3', 'Geometry', 'Learn Geometry', 1668567723);

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
(5, 'STD/005', 'Odunayo', 'Babatunde', 'codextra', 'rebeccaodunayo288@gmail.com', 'Lagos', '08036367586', 'paid', 1, 'Male', '$2y$10$F35SjNVCkJ/IvAfZnMdLqOV4onunjsYn61k7Bu6CIKtMWzKsOxtH.', 1665444358, 1665444358),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `attempts`
--
ALTER TABLE `attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `question_folders`
--
ALTER TABLE `question_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quizes`
--
ALTER TABLE `quizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers_enrollment`
--
ALTER TABLE `teachers_enrollment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teacher_img`
--
ALTER TABLE `teacher_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
