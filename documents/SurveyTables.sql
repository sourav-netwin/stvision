-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 16, 2016 at 12:59 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vision_plus`
--

-- --------------------------------------------------------

--
-- Table structure for table `plused_survey_answers`
--

CREATE TABLE IF NOT EXISTS `plused_survey_answers` (
  `ans_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique Identifier',
  `ans_su_id` int(10) NOT NULL COMMENT 'Survey user id for ref.',
  `ans_que_id` int(10) NOT NULL COMMENT 'question id',
  `ans_yes_no` tinytext NOT NULL COMMENT '1- Yes and 0- No',
  `ans_comment` text NOT NULL COMMENT 'text comment',
  PRIMARY KEY (`ans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `plused_survey_questions`
--

CREATE TABLE IF NOT EXISTS `plused_survey_questions` (
  `que_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique Identifier',
  `que_report` enum('Report 1','Report 2') NOT NULL COMMENT 'This question is under which report?',
  `que_section_sequence` int(10) NOT NULL,
  `que_section` varchar(255) NOT NULL COMMENT 'section head text',
  `que_number` float NOT NULL COMMENT 'questions serial number',
  `que_question` varchar(255) NOT NULL COMMENT 'actual question text',
  `que_isyesno` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1- yes no type 0- for input box',
  `que_iscomment` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'If this is the section comment',
  `que_is_header` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'If this is not actual question but has some child questions under this then set this as 1',
  `que_parent_que_id` int(10) NOT NULL DEFAULT '0' COMMENT 'If this is a sub question of the question header then set parent question id here',
  PRIMARY KEY (`que_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `plused_survey_questions`
--

INSERT INTO `plused_survey_questions` (`que_id`, `que_report`, `que_section_sequence`, `que_section`, `que_number`, `que_question`, `que_isyesno`, `que_iscomment`, `que_is_header`, `que_parent_que_id`) VALUES
(1, 'Report 1', 1, 'Centre set up', 1, 'Did our staff wear PLUS uniforms when you arrived at the centre?', 1, 0, 0, 0),
(2, 'Report 1', 1, 'Centre set up', 2, 'Did the Campus Manager wear a PLUS uniform or a badge?', 1, 0, 0, 0),
(3, 'Report 1', 2, 'General Organisation', 1, 'Did PLUS staff arrange an orientation tour of campus for you and your students?', 1, 0, 0, 0),
(4, 'Report 1', 2, 'General Organisation', 2, 'Have our staff carried out fire drill?', 1, 0, 0, 0),
(5, 'Report 1', 2, 'General Organisation', 3, 'During the welcome night did the Campus Manager discuss:', 0, 0, 1, 0),
(6, 'Report 1', 2, 'General Organisation', 3.1, 'students welfare, behaviour and discipline', 1, 0, 0, 5),
(7, 'Report 1', 2, 'General Organisation', 3.2, 'grievance procedures', 1, 0, 0, 5),
(8, 'Report 1', 2, 'General Organisation', 3.3, 'leisure programme presentation', 1, 0, 0, 5),
(9, 'Report 1', 2, 'General Organisation', 3.4, 'study course and examinations', 1, 0, 0, 5),
(10, 'Report 1', 2, 'General Organisation', 4, 'During the first meeting with the Campus Manager and the Course Director, did they explain you and the other Group Leaders the following subjects?', 0, 0, 1, 0),
(11, 'Report 1', 2, 'General Organisation', 4.1, 'General supervision rules', 1, 0, 0, 10),
(12, 'Report 1', 2, 'General Organisation', 4.2, 'Risk assessment, student welfare and safety', 1, 0, 0, 10),
(13, 'Report 1', 2, 'General Organisation', 4.3, 'Students behaviour and discipline, anti-bullying policy, discilplenary actions', 1, 0, 0, 10),
(14, 'Report 1', 2, 'General Organisation', 4.4, 'Health & Safety practicalities', 1, 0, 0, 10),
(15, 'Report 1', 1, 'Centre set up', 9, 'Comments', 0, 1, 0, 0),
(16, 'Report 1', 2, 'General Organisation', 5, 'Comments', 0, 1, 0, 0),
(17, 'Report 1', 1, 'Centre set up', 3, 'Did PLUS staff offer you drinks and snacks to welcome the students?', 1, 0, 0, 0),
(18, 'Report 1', 1, 'Centre set up', 4, 'Were you and your students given a PLUS lanyard with I.D. card?', 1, 0, 0, 0),
(19, 'Report 1', 1, 'Centre set up', 5, 'Were you given a "Welcome Pack"?', 1, 0, 0, 0),
(20, 'Report 1', 1, 'Centre set up', 6, 'Was the PLUS Main board displayed and completed with photos and names of the Campus Manager and PLUS staff and the Activity Programme?', 1, 0, 0, 0),
(21, 'Report 1', 1, 'Centre set up', 7, 'Were the class rooms, the teacher''s room and Course Director office properly labelled?', 1, 0, 0, 0),
(22, 'Report 1', 1, 'Centre set up', 8, 'Were the fire exit signs in the teaching block, the accoomodation building and the refectory visible?', 1, 0, 0, 0),
(23, 'Report 1', 3, 'Activity Programme', 1, 'Is the activity programme properly organised and advertised on campus?', 1, 0, 0, 0),
(24, 'Report 1', 3, 'Activity Programme', 2, 'Are the activities adequately supervised by you and PLUS statff?', 1, 0, 0, 0),
(25, 'Report 1', 3, 'Activity Programme', 3, 'Do PLUS staff involve the students?', 1, 0, 0, 0),
(26, 'Report 1', 3, 'Activity Programme', 4, 'Are the trips by private coach properly organised?', 1, 0, 0, 0),
(27, 'Report 1', 3, 'Activity Programme', 5, 'Were they appreciated by the students?', 1, 0, 0, 0),
(28, 'Report 1', 3, 'Activity Programme', 6, 'Would you say that on the whole yours students appreciated the activity programme?', 1, 0, 0, 0),
(29, 'Report 1', 3, 'Activity Programme', 7, 'Comments', 0, 1, 0, 0),
(30, 'Report 1', 4, 'Tuition', 1, 'Is the tuition poster up to date and completed with photos and names of the Course Director and all the teachers?', 1, 0, 0, 0),
(31, 'Report 1', 4, 'Tuition', 2, 'Are the classrooms adequately sized and well lit?', 1, 0, 0, 0),
(32, 'Report 1', 4, 'Tuition', 3, 'Was the placement test correctly and properly organised?', 1, 0, 0, 0),
(33, 'Report 1', 4, 'Tuition', 4, 'Were your students placed in the right level?', 1, 0, 0, 0),
(34, 'Report 1', 4, 'Tuition', 5, 'If not, did you speak to the Course Director and was the issue resolved to your satisfaction?', 1, 0, 0, 0),
(35, 'Report 1', 4, 'Tuition', 6, 'Do teachers prepare the excursions in the class?', 1, 0, 0, 0),
(36, 'Report 1', 4, 'Tuition', 7, 'Are course descriptions displayed in each class?', 1, 0, 0, 0),
(37, 'Report 1', 4, 'Tuition', 8, 'Comments', 0, 1, 0, 0),
(38, 'Report 1', 5, 'Accommodation and Food', 1, 'Are the bedrooms in a good state of repair, cleanliness and adequately furnished?', 1, 0, 0, 0),
(39, 'Report 1', 5, 'Accommodation and Food', 2, 'Is the cleaning of the rooms satisfactory?', 1, 0, 0, 0),
(40, 'Report 1', 5, 'Accommodation and Food', 3, 'If accommodated o the same floor or flat, were the bathrooms for boys and girls properly labelled?', 1, 0, 0, 0),
(41, 'Report 1', 5, 'Accommodation and Food', 4, 'Is(Are) the common room(s) adequately sized?', 1, 0, 0, 0),
(42, 'Report 1', 5, 'Accommodation and Food', 5, 'Is the food satisfactory in terms of quality and quantity?', 1, 0, 0, 0),
(43, 'Report 1', 5, 'Accommodation and Food', 6, 'Comments', 0, 1, 0, 0),
(44, 'Report 1', 6, 'Home Stay', 1, 'Was the students pick-up properly arranged when you arrived at the center?', 1, 0, 0, 0),
(45, 'Report 1', 6, 'Home Stay', 2, 'Are your homestay students satisfied?', 1, 0, 0, 0),
(46, 'Report 1', 6, 'Home Stay', 3, 'Have you had and specific complaints?', 1, 0, 0, 0),
(47, 'Report 1', 6, 'Home Stay', 4, 'If yes, have you reported them to the Campus Manager and were they promptly addressed?', 1, 0, 0, 0),
(48, 'Report 1', 6, 'Home Stay', 5, 'Comments', 0, 1, 0, 0),
(49, 'Report 2', 1, 'In this last week have:', 1, 'You met with the Campus Manager to discuss any issues?', 0, 0, 1, 0),
(50, 'Report 2', 1, 'In this last week have:', 1.1, 'every morning', 1, 0, 0, 49),
(51, 'Report 2', 1, 'In this last week have:', 1.2, 'every other day', 1, 0, 0, 49),
(52, 'Report 2', 1, 'In this last week have:', 1.3, 'once a week', 1, 0, 0, 49),
(53, 'Report 2', 1, 'In this last week have:', 1.4, 'how often did you meet with the Course Director?', 0, 0, 0, 49),
(54, 'Report 2', 1, 'In this last week have:', 2, 'The teachers', 0, 0, 1, 0),
(55, 'Report 2', 1, 'In this last week have:', 2.1, 'been punctual in arriving and leaving the class?', 1, 0, 0, 54),
(56, 'Report 2', 1, 'In this last week have:', 2.2, 'succeeded in ensuring and maintaining a positive learning atmosphere in the class?', 1, 0, 0, 54),
(57, 'Report 2', 1, 'In this last week have:', 2.3, 'managed learning activities and interactions effectively to engage students?', 1, 0, 0, 54),
(58, 'Report 2', 1, 'In this last week have:', 2.4, 'prepared for the weekend excursion?', 1, 0, 0, 54),
(59, 'Report 2', 1, 'In this last week have:', 3, 'The students', 0, 0, 1, 0),
(60, 'Report 2', 1, 'In this last week have:', 3.1, 'show satisfaction for the general organisation of the centre and their accommodation?', 1, 0, 0, 59),
(61, 'Report 2', 1, 'In this last week have:', 3.2, 'appreciated the study course?', 1, 0, 0, 59),
(62, 'Report 2', 1, 'In this last week have:', 3.3, 'enjoyed the activity programme?', 1, 0, 0, 59),
(63, 'Report 2', 1, 'In this last week have:', 3.4, 'complained to you about anything? if yes, please let us have your comments', 1, 0, 0, 59),
(64, 'Report 2', 1, 'In this last week have:', 4, 'The activity leaders', 0, 0, 1, 0),
(65, 'Report 2', 1, 'In this last week have:', 4.1, 'prepared and run the activities in an organised and efficient way?', 1, 0, 0, 64),
(66, 'Report 2', 1, 'In this last week have:', 4.2, 'managed to create a positive and fun atmosphere within the campus?', 1, 0, 0, 64),
(67, 'Report 2', 1, 'In this last week have:', 4.3, 'been courteous and helpful?', 1, 0, 0, 64),
(68, 'Report 2', 1, 'In this last week have:', 5, 'The Campus Manager', 0, 0, 1, 0),
(69, 'Report 2', 1, 'In this last week have:', 5.1, 'efficiently run the centre?', 1, 0, 0, 68),
(70, 'Report 2', 1, 'In this last week have:', 5.2, 'maintained a professional relationship with the Group Leaders and the students?', 1, 0, 0, 68),
(71, 'Report 2', 1, 'In this last week have:', 5.3, 'shown problem-solving skills and the ability to work under pressure?', 1, 0, 0, 68),
(72, 'Report 2', 1, 'In this last week have:', 5.4, 'created a positive atmosphere on campus?', 1, 0, 0, 68),
(73, 'Report 2', 1, 'In this last week have:', 6, 'The Course Director', 0, 0, 1, 0),
(74, 'Report 2', 1, 'In this last week have:', 6.1, 'been available to discuss any academic issues?', 1, 0, 0, 73),
(75, 'Report 2', 1, 'In this last week have:', 6.2, 'managed any problems your students had with their classes?', 1, 0, 0, 73),
(76, 'Report 2', 1, 'In this last week have:', 7, 'Conclusions:', 0, 0, 1, 0),
(77, 'Report 2', 1, 'In this last week have:', 7.1, 'On the whole, would you say that your experience with us has been Satisfactory?', 1, 0, 0, 76),
(78, 'Report 2', 1, 'In this last week have:', 8, 'Comments', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `plused_survey_users`
--

CREATE TABLE IF NOT EXISTS `plused_survey_users` (
  `su_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique Identifier',
  `su_group_leader_id` int(11) NOT NULL COMMENT 'Group leader id ref. id from plused_row',
  `su_report` enum('Report 1','Report 2') NOT NULL,
  `su_name` varchar(255) NOT NULL COMMENT 'Name form plused_row table',
  `su_email` varchar(100) NOT NULL COMMENT 'Email address of user',
  `su_campus_id` int(11) NOT NULL COMMENT 'Campus id',
  `su_survey_date` datetime NOT NULL COMMENT 'Survey timestamp',
  `su_survey_status` enum('Pending','Inprogress','Completed') NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`su_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
