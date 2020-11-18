-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2020 at 12:47 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scubajack`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) UNSIGNED NOT NULL,
  `question_id` int(11) UNSIGNED NOT NULL,
  `answer` varchar(150) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = YES, 0 = NO',
  `correct_index` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `is_deleted` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer`, `is_correct`, `correct_index`, `created_at`, `updated_at`, `is_deleted`) VALUES
(47, 25, 'Sandrine Homenick V', 1, 0, '2020-09-28 05:28:39', '2020-09-28 05:28:39', '0'),
(48, 25, 'Allan Kuhlman', 0, 1, '2020-09-28 05:28:39', '2020-09-28 05:28:39', '0'),
(49, 25, 'Lukas Waters Jr', 0, 2, '2020-09-28 05:28:39', '2020-09-28 05:28:39', '0'),
(50, 25, 'Prof. Emmalee Wunsch', 0, 3, '2020-09-28 05:28:39', '2020-09-28 05:28:39', '0'),
(51, 26, 'Elmira Bins', 1, 0, '2020-09-28 05:29:29', '2020-09-28 05:29:29', '0'),
(52, 26, 'Bill Ondricka', 0, 1, '2020-09-28 05:29:29', '2020-09-28 05:29:29', '0'),
(53, 26, 'Meredith O\'Connell', 0, 2, '2020-09-28 05:29:29', '2020-09-28 05:29:29', '0'),
(54, 26, 'Amara Hirthe', 0, 3, '2020-09-28 05:29:29', '2020-09-28 05:29:29', '0'),
(55, 27, 'Prof. Odell Nienow', 1, 0, '2020-09-28 05:30:26', '2020-09-28 05:30:26', '0'),
(56, 27, 'Orie Tillman', 0, 1, '2020-09-28 05:30:26', '2020-09-28 05:30:26', '0'),
(57, 27, 'Christopher Ziemann', 0, 2, '2020-09-28 05:30:26', '2020-09-28 05:30:26', '0'),
(58, 27, 'Annamae Ferry', 0, 3, '2020-09-28 05:30:26', '2020-09-28 05:30:26', '0'),
(59, 28, 'Dr. Tre Walker IV', 1, 0, '2020-09-28 05:31:08', '2020-09-28 05:31:08', '0'),
(60, 28, 'Jasper Wuckert MD', 0, 1, '2020-09-28 05:31:09', '2020-09-28 05:31:09', '0'),
(61, 28, 'Mollie Crona', 0, 2, '2020-09-28 05:31:09', '2020-09-28 05:31:09', '0'),
(62, 28, 'Julianne Schuster', 0, 3, '2020-09-28 05:31:09', '2020-09-28 05:31:09', '0'),
(63, 29, 'Rubie Bartell', 1, 0, '2020-09-28 05:31:59', '2020-09-28 05:31:59', '0'),
(64, 29, 'Gabrielle Grady MD', 0, 1, '2020-09-28 05:31:59', '2020-09-28 05:31:59', '0'),
(65, 29, 'Emiliano Schmitt', 0, 2, '2020-09-28 05:31:59', '2020-09-28 05:31:59', '0'),
(66, 29, 'Prof. Enola Hilll', 0, 3, '2020-09-28 05:31:59', '2020-09-28 05:31:59', '0'),
(67, 30, 'Kathryne Bradtke', 1, 0, '2020-09-28 05:32:36', '2020-09-28 05:32:36', '0'),
(68, 30, 'Prof. Eleanora Ritchie III', 0, 1, '2020-09-28 05:32:36', '2020-09-28 05:32:36', '0'),
(69, 30, 'Roslyn Anderson', 0, 2, '2020-09-28 05:32:36', '2020-09-28 05:32:36', '0'),
(70, 30, 'Kellie Haley', 0, 3, '2020-09-28 05:32:36', '2020-09-28 05:32:36', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users_questions_answers`
--

CREATE TABLE `users_questions_answers` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `question_id` int(11) UNSIGNED NOT NULL,
  `answer_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_questions_answers`
--

INSERT INTO `users_questions_answers` (`id`, `user_id`, `question_id`, `answer_id`, `created_at`, `updated_at`, `is_deleted`) VALUES
(19, 2, 25, 47, '2020-09-28 06:56:28', '2020-09-28 06:56:28', '0'),
(20, 2, 26, 51, '2020-09-28 06:56:31', '2020-09-28 06:56:31', '0'),
(21, 2, 27, 55, '2020-09-28 06:56:33', '2020-09-28 06:56:33', '0'),
(22, 2, 30, 67, '2020-09-28 06:56:35', '2020-09-28 06:56:35', '0'),
(23, 2, 28, 59, '2020-09-28 06:56:37', '2020-09-28 06:56:37', '0'),
(24, 2, 25, 47, '2020-09-28 07:01:04', '2020-09-28 07:01:04', '0'),
(25, 2, 28, 59, '2020-09-28 07:01:06', '2020-09-28 07:01:06', '0'),
(26, 2, 29, 63, '2020-09-28 07:01:09', '2020-09-28 07:01:09', '0'),
(27, 2, 30, 67, '2020-09-28 07:01:10', '2020-09-28 07:01:10', '0'),
(28, 2, 27, 55, '2020-09-28 07:01:11', '2020-09-28 07:01:11', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users_quiz_scores`
--

CREATE TABLE `users_quiz_scores` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `quiz` varchar(255) NOT NULL,
  `score` int(11) UNSIGNED NOT NULL,
  `num_questions` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` mediumint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_quiz_scores`
--

INSERT INTO `users_quiz_scores` (`id`, `user_id`, `quiz`, `score`, `num_questions`, `created_at`, `updated_at`, `is_deleted`) VALUES
(2, 2, 'whale sharks quiz	', 4, 5, '2020-09-28 06:56:38', '2020-09-28 06:56:38', 0),
(3, 2, 'whale sharks quiz', 5, 5, '2020-09-28 07:01:12', '2020-09-28 07:01:12', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `users_questions_answers`
--
ALTER TABLE `users_questions_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`user_id`,`question_id`,`answer_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `answer_id` (`answer_id`);

--
-- Indexes for table `users_quiz_scores`
--
ALTER TABLE `users_quiz_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `users_questions_answers`
--
ALTER TABLE `users_questions_answers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users_quiz_scores`
--
ALTER TABLE `users_quiz_scores`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_questions_answers`
--
ALTER TABLE `users_questions_answers`
  ADD CONSTRAINT `users_questions_answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `users_questions_answers_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
