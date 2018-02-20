-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2016 at 02:04 PM
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
-- Table structure for table `plused_role`
--

DROP TABLE IF EXISTS `plused_role`;
CREATE TABLE IF NOT EXISTS `plused_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Pk',
  `role_name` varchar(255) NOT NULL COMMENT 'Name of the role',
  `role_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Role active/inactive status',
  `role_is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'This is for soft delete the role',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=551 ;

--
-- Dumping data for table `plused_role`
--

INSERT INTO `plused_role` (`role_id`, `role_name`, `role_created_on`, `role_is_active`, `role_is_deleted`) VALUES
(1, 'Super user', '2016-08-03 13:59:21', 1, 0),
(100, 'Backoffice operator', '2016-08-03 13:59:21', 1, 0),
(502, 'Students', '2016-08-05 14:36:47', 1, 0),
(501, 'Group leader', '2016-08-08 08:59:03', 1, 0),
(500, 'Teacher', '2016-09-01 13:25:01', 1, 0),
(400, 'Course Director', '2016-09-05 11:00:37', 1, 0),
(99, 'Agents', '2016-09-13 09:42:30', 1, 0),
(98, 'Account Manager', '2016-09-13 09:42:59', 1, 0),
(97, 'Media Viewer', '2016-09-13 09:43:07', 1, 0),
(550, 'ST History reports', '2016-10-07 11:02:19', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `plused_role_access`
--

DROP TABLE IF EXISTS `plused_role_access`;
CREATE TABLE IF NOT EXISTS `plused_role_access` (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Pk',
  `acc_role_id` int(11) NOT NULL COMMENT 'Fk for role table',
  `acc_menu_id` int(11) NOT NULL COMMENT 'Fk for menus',
  PRIMARY KEY (`acc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=550 ;

--
-- Dumping data for table `plused_role_access`
--

INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES
(381, 502, 44),
(379, 502, 41),
(490, 1, 48),
(394, 501, 52),
(393, 501, 51),
(395, 501, 53),
(382, 502, 46),
(493, 99, 107),
(494, 99, 108),
(101, 502, 45),
(157, 502, 43),
(380, 502, 42),
(392, 501, 50),
(399, 100, 55),
(398, 100, 5),
(405, 100, 59),
(401, 100, 57),
(402, 100, 58),
(403, 100, 1),
(406, 100, 56),
(407, 100, 60),
(408, 100, 62),
(409, 100, 61),
(410, 100, 7),
(411, 100, 40),
(412, 100, 39),
(413, 100, 6),
(414, 100, 64),
(415, 100, 65),
(416, 100, 66),
(417, 100, 67),
(418, 100, 72),
(419, 100, 73),
(420, 100, 80),
(421, 100, 79),
(422, 100, 82),
(423, 100, 83),
(424, 100, 84),
(425, 100, 85),
(426, 100, 86),
(427, 100, 87),
(428, 100, 88),
(429, 100, 76),
(430, 100, 89),
(431, 100, 90),
(432, 100, 77),
(433, 100, 91),
(434, 100, 92),
(435, 100, 78),
(436, 100, 93),
(437, 100, 94),
(438, 500, 95),
(439, 500, 100),
(440, 500, 96),
(441, 500, 97),
(442, 500, 99),
(443, 500, 98),
(444, 100, 101),
(445, 400, 1),
(464, 400, 102),
(466, 400, 103),
(465, 400, 56),
(452, 400, 5),
(513, 100, 118),
(514, 100, 4),
(472, 1, 1),
(492, 1, 49),
(491, 1, 106),
(469, 1, 47),
(468, 400, 65),
(467, 400, 58),
(499, 100, 2),
(509, 100, 114),
(510, 100, 115),
(511, 100, 116),
(512, 100, 117),
(502, 100, 113),
(498, 99, 112),
(497, 99, 111),
(496, 99, 110),
(495, 99, 109),
(488, 400, 105),
(487, 400, 104),
(508, 100, 3),
(515, 100, 119),
(516, 99, 120),
(517, 99, 121),
(518, 99, 122),
(519, 99, 123),
(520, 99, 124),
(521, 99, 125),
(522, 99, 126),
(523, 99, 127),
(524, 99, 128),
(525, 99, 129),
(526, 99, 130),
(527, 99, 131),
(528, 99, 132),
(529, 97, 131),
(530, 97, 132),
(531, 98, 108),
(532, 98, 109),
(533, 98, 110),
(534, 98, 111),
(535, 98, 112),
(536, 98, 107),
(537, 98, 133),
(538, 98, 134),
(539, 98, 135),
(540, 98, 136),
(541, 98, 137),
(546, 550, 141),
(543, 550, 138),
(548, 550, 142),
(549, 550, 143);

-- --------------------------------------------------------

--
-- Table structure for table `plused_role_menu`
--

DROP TABLE IF EXISTS `plused_role_menu`;
CREATE TABLE IF NOT EXISTS `plused_role_menu` (
  `mnu_menuid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique Identifier',
  `mnu_parent_menu_id` int(11) NOT NULL DEFAULT '0',
  `mnu_menu_name` varchar(50) NOT NULL COMMENT 'Menu name',
  `mnu_caption` varchar(255) NOT NULL COMMENT 'This is the caption for menu if there are some duplicates',
  `mnu_url` varchar(100) NOT NULL COMMENT 'Not null if mnu_is_content = 1 menu.',
  `mnu_status` int(1) NOT NULL DEFAULT '1' COMMENT 'In which position menu name should be listed',
  `mnu_level` int(10) NOT NULL DEFAULT '1',
  `mnu_type` enum('Top','Left','Other') NOT NULL DEFAULT 'Top',
  `mnu_sequence` int(10) NOT NULL DEFAULT '0',
  `mnu_icon_class` varchar(255) NOT NULL,
  `mnu_created_on` datetime NOT NULL COMMENT 'Date on which menu is created.',
  `mnu_created_by` int(8) NOT NULL COMMENT 'Id of the user who created the menu',
  `mnu_modified_on` datetime NOT NULL COMMENT 'Date on which menu details are modified.',
  `mnu_modified_by` int(8) NOT NULL COMMENT 'Id of the user who modified the menu details',
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mnu_menuid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Menu Details' AUTO_INCREMENT=144 ;

--
-- Dumping data for table `plused_role_menu`
--

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES
(1, 0, 'Dashboard', 'Back-office operator dashboard', 'backoffice/dashboard', 1, 1, 'Left', 1, 'fa-dashboard', '2014-12-20 06:55:33', 123, '2015-07-03 10:03:03', 123, 0),
(2, 0, 'Sales and risks', '', '', 1, 1, 'Left', 2, 'fa-line-chart', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(3, 0, 'Booking', '', '', 1, 1, 'Left', 3, 'fa-files-o', '2014-12-20 06:56:19', 123, '2014-12-30 12:42:34', 123, 0),
(4, 0, 'Campus management', '', '', 1, 1, 'Left', 4, 'fa-institution', '2014-12-20 06:56:29', 123, '2014-12-30 12:42:43', 123, 0),
(5, 0, 'Tuition', '', '', 1, 1, 'Left', 5, 'fa-graduation-cap', '2014-12-20 06:56:37', 123, '2016-08-04 00:00:00', 0, 0),
(6, 0, 'Job and contracts', '', '', 1, 1, 'Left', 6, 'fa-suitcase', '2014-12-20 06:56:44', 123, '2014-12-30 12:43:19', 123, 0),
(7, 0, 'Survey', '', '', 1, 1, 'Left', 7, 'fa-paperclip', '2014-12-20 06:56:49', 123, '2014-12-30 12:42:49', 123, 0),
(40, 7, 'GL report', '', 'survey/report', 1, 2, 'Left', 1, '', '2014-12-22 06:44:27', 123, '2014-12-22 06:57:03', 123, 0),
(39, 7, 'Students report', '', 'survey/studentsreport', 1, 2, 'Left', 2, '', '2014-12-22 06:44:16', 123, '2016-08-04 00:00:00', 0, 0),
(41, 0, 'Test / Survey', '', '', 1, 1, 'Left', 8, 'fa-file-text ', '2016-08-04 00:00:00', 0, '2016-08-04 00:00:00', 0, 0),
(42, 41, 'Grammar and vocabulary', '', 'students/englishtest', 1, 2, 'Left', 1, '', '2016-08-04 00:00:00', 0, '2016-08-04 00:00:00', 0, 0),
(43, 0, 'Dashboard', 'Student dashboard', 'students/dashboard', 1, 1, 'Left', 1, 'fa-dashboard', '2016-08-08 00:00:00', 1, '2016-08-08 00:00:00', 1, 0),
(44, 41, 'Take student survey', '', 'student_survey', 1, 2, 'Left', 2, '', '2016-08-08 00:00:00', 1, '2016-08-08 00:00:00', 1, 0),
(45, 0, 'Profile', '', 'students/profile', 1, 1, 'Top', 1, 'fa-user', '2016-08-08 00:00:00', 1, '2016-08-08 00:00:00', 1, 0),
(46, 44, 'View survey', 'Internal link', 'student_survey/view', 1, 3, 'Left', 1, '', '2016-08-10 00:00:00', 1, '2016-08-10 00:00:00', 1, 0),
(47, 0, 'Role management', '', '', 1, 1, 'Left', 9, 'fa-user-secret', '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(48, 47, 'Roles', '', 'roles', 1, 2, 'Left', 1, '', '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(49, 47, 'Menu access', '', 'roleaccess', 1, 2, 'Left', 2, '', '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(50, 0, 'Dashboard', 'Group leader', 'survey/dashboard', 1, 1, 'Left', 1, 'fa-dashboard', '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(51, 0, 'Take the survey', '', '', 2, 1, 'Left', 1, 'fa-paperclip', '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(52, 51, 'Take survey 1', '', 'survey/view/report1', 1, 2, 'Left', 1, '', '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(53, 51, 'Take survey 2', '', 'survey/view/report2', 1, 2, 'Left', 2, '', '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(56, 5, 'Campus rooms', '', 'campusrooms', 1, 2, 'Left', 2, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(55, 5, 'Courses', '', 'backoffice/campusCourses', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(57, 5, 'Staff priority', '', 'staff/priority', 1, 2, 'Left', 3, '', '2016-08-22 00:00:00', 1, '2016-08-22 00:00:00', 1, 0),
(58, 5, 'Tuitions schedule', '', 'tuitions', 1, 2, 'Left', 4, '', '2016-08-23 00:00:00', 1, '2016-08-23 00:00:00', 1, 0),
(59, 56, 'Create new room', 'Internal link', 'campusrooms/addedit', 1, 3, 'Left', 1, '', '2016-08-23 00:00:00', 1, '2016-08-23 00:00:00', 1, 0),
(60, 55, 'Create new course', 'Internal link', 'backoffice/addcourse', 1, 3, 'Left', 1, '', '2016-08-23 00:00:00', 1, '2016-08-23 00:00:00', 1, 0),
(61, 56, 'Delete room', 'Internal action', 'campusrooms/deleterooms', 1, 3, 'Left', 2, '', '2016-08-25 00:00:00', 1, '2016-08-25 00:00:00', 1, 0),
(62, 55, 'Delete course', 'Internal action', 'backoffice/deletecourse', 1, 3, 'Left', 2, '', '2016-08-25 00:00:00', 1, '2016-08-25 00:00:00', 1, 0),
(65, 5, 'Class timetable', '', 'tuitions/plan', 1, 2, 'Left', 5, '', '2016-08-26 00:00:00', 1, '2016-08-26 00:00:00', 1, 0),
(64, 6, 'Teachers CV review', '', 'teachers/review', 1, 2, 'Left', 1, '', '2016-08-25 00:00:00', 1, '2016-08-25 00:00:00', 1, 0),
(66, 5, 'Tuitions schedule report', '', 'tuitionsreports', 1, 2, 'Left', 6, '', '2016-08-26 00:00:00', 1, '2016-08-26 00:00:00', 1, 0),
(67, 5, 'Teacher work report', '', 'tuitionsreports/teachers', 1, 2, 'Left', 7, '', '2016-08-29 00:00:00', 1, '2016-08-29 00:00:00', 1, 0),
(75, 39, 'Students report result', 'Internal link', 'survey/questionsstudentreport', 1, 3, 'Left', 1, '', '2016-08-30 00:00:00', 123, '2016-08-30 00:00:00', 123, 0),
(74, 40, 'View survey report', 'Internal link', 'survey/questionsreport', 1, 3, 'Left', 1, '', '2016-08-30 00:00:00', 123, '2016-08-30 00:00:00', 123, 0),
(73, 6, 'Job offer history', '', 'jobofferhistory', 1, 2, 'Left', 3, '', '2016-08-25 00:00:00', 1, '2016-08-25 00:00:00', 1, 0),
(72, 6, 'Teachers interviews', '', 'teachers/profilereview', 1, 2, 'Left', 2, '', '2016-08-25 00:00:00', 1, '2016-08-25 00:00:00', 1, 0),
(76, 88, 'Excursion export', 'Internal link', 'excursionexportimport/export', 1, 3, 'Left', 1, '', '2016-08-30 00:00:00', 123, '2016-08-30 00:00:00', 123, 0),
(77, 90, 'Join template campus submit', 'Internal link', 'jointemplatecampus/joinTempCamp', 1, 3, 'Left', 1, '', '2016-08-30 00:00:00', 123, '2016-08-30 00:00:00', 123, 0),
(78, 92, 'Template nationality submit', 'Internal link', 'jointemplatenationality/joinTempNat', 1, 3, 'Left', 1, '', '2016-08-30 00:00:00', 123, '2016-08-30 00:00:00', 123, 0),
(79, 6, 'Contract', '', 'contract', 1, 2, 'Left', 4, '', '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(80, 6, 'Contract payrolls', '', 'contract/payrolls', 1, 2, 'Left', 5, '', '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(81, 79, 'Export contract', 'Internal link', 'contract/exportcontract', 1, 3, 'Left', 1, '', '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(82, 79, 'Contract add edit', 'Internal link', 'contract/addedit', 1, 3, 'Left', 2, '', '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(83, 79, 'Delete contract', '', 'contract/deletecontract', 1, 3, 'Left', 3, '', '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(84, 0, 'Students', '', '', 1, 1, 'Left', 8, 'fa-users', '2016-08-25 00:00:00', 123, '0000-00-00 00:00:00', 123, 0),
(85, 84, 'Test report', 'Student test report', 'studentsreport', 1, 2, 'Left', 1, '', '2016-08-25 00:00:00', 123, '2016-08-25 00:00:00', 123, 0),
(86, 0, 'Excursion management', '', '', 1, 1, 'Left', 9, 'fa-plane', '2016-08-25 00:00:00', 123, '2016-08-25 00:00:00', 123, 0),
(87, 86, 'Join campus and companies', '', 'joincampuscompany', 1, 2, 'Left', 1, '', '2016-08-25 00:00:00', 123, '2016-08-25 00:00:00', 123, 0),
(88, 86, 'Export and import', '', 'excursionexportimport', 1, 2, 'Left', 2, '', '2016-08-25 00:00:00', 123, '2016-08-25 00:00:00', 123, 0),
(89, 0, 'VISA management', '', '', 1, 1, 'Left', 10, 'fa-cc-visa', '2016-08-26 00:00:00', 123, '2016-08-26 00:00:00', 123, 0),
(90, 89, 'Join template-campus', '', 'jointemplatecampus', 1, 2, 'Left', 1, '', '2016-08-26 00:00:00', 123, '2016-08-26 00:00:00', 123, 0),
(91, 0, 'Nationality management', '', '', 1, 1, 'Left', 11, 'fa-flag', '2016-08-26 00:00:00', 123, '2016-08-26 00:00:00', 123, 0),
(92, 91, 'Join template-nationality', '', 'jointemplatenationality', 1, 2, 'Left', 1, '', '2016-08-26 00:00:00', 123, '2016-08-26 00:00:00', 123, 0),
(93, 0, 'Ticket management', '', '', 1, 1, 'Left', 12, 'fa-ticket', '2016-08-26 00:00:00', 123, '2016-08-26 00:00:00', 123, 0),
(94, 93, 'Manage tickets', '', 'ticketmanagement', 1, 2, 'Left', 1, '', '2016-08-26 00:00:00', 123, '2016-08-26 00:00:00', 123, 0),
(95, 0, 'Dashboard', 'User section', 'users/dashboard', 1, 1, 'Left', 1, 'fa-dashboard', '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(96, 0, 'My account', 'User section', '', 1, 1, 'Left', 2, 'fa-user', '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(97, 96, 'Personal information', 'User section', 'users/documents', 1, 2, 'Left', 1, '', '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(98, 96, 'Contracts', 'User contract', 'users/contracts', 1, 2, 'Left', 2, '', '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(99, 97, 'Edit profile', 'User section', 'users/editprofile', 1, 3, 'Left', 1, '', '2016-09-01 00:00:00', 123, '2016-09-01 00:00:00', 123, 0),
(100, 97, 'User profile', 'User section', 'users/profile', 1, 3, 'Left', 2, '', '2016-09-01 00:00:00', 123, '2016-09-01 00:00:00', 123, 0),
(101, 64, 'Edit application', 'Internal link', 'teachers/editapp', 1, 3, 'Left', 1, '', '2016-09-05 00:00:00', 1, '2016-09-05 00:00:00', 1, 0),
(102, 56, 'View listing', 'for course director only', 'campusrooms/index', 1, 3, 'Left', 3, '', '2016-08-25 00:00:00', 1, '2016-08-25 00:00:00', 1, 0),
(103, 5, 'Language knowledge', 'for course director', 'tuitions/updatelang', 1, 2, 'Left', 3, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(104, 5, 'Teachers details', 'for course director', 'tuitions/teachers', 1, 2, 'Left', 6, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(105, 5, 'Teachers review', 'for course director', 'tuitions/teachersreview', 1, 2, 'Left', 7, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(106, 48, 'Edit Role', 'Internal link', 'roles/editRole', 1, 3, 'Left', 1, '', '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(107, 0, 'Dashboard', 'Agent dashboard', 'agents/dashboard', 1, 1, 'Left', 1, 'fa-dashboard', '2014-12-20 06:55:33', 123, '2015-07-03 10:03:03', 123, 0),
(108, 0, 'Programmes info & prices', '', '', 1, 1, 'Left', 2, 'fa-file', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(109, 108, 'Junior summer', '', 'agents/mkt_material_pj', 1, 2, 'Left', 1, 'fa-list-alt', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(110, 108, 'Junior winter', '', 'agents/mkt_material_pjw', 1, 2, 'Left', 2, 'fa-list-alt', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(111, 108, 'Pathway', '', '#', 1, 2, 'Left', 3, 'fa-list-alt', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(112, 108, 'Undergraduate', '', '#', 1, 2, 'Left', 4, 'fa-list-alt', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(113, 2, 'Sales', '', 'backoffice/salesNew', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(114, 3, 'Overview campus booking', '', 'backoffice/overviewBookingsNew', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(115, 3, 'Campus availability', '', 'backoffice/availabilityNew', 1, 2, 'Left', 2, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(116, 3, 'Review tuition day2day', '', 'backoffice/tuitionNew', 1, 2, 'Left', 3, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(117, 3, 'Download bookings (xls)', '', 'backoffice/exportCSVBookings/all/all/all/2016', 1, 2, 'Left', 4, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(118, 3, 'Download availability (xls)', '', 'backoffice/exportAvailabilityDetailNew', 1, 2, 'Left', 5, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(119, 4, 'Campus trips & participants', '', 'backoffice/new_reviewday2day_pax_new', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(120, 0, 'Enrol', '', '', 1, 1, 'Left', 3, 'fa-sign-in', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(121, 120, 'Enrol new group', '', 'agents/enrol', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(122, 120, 'Need help?', '', '', 1, 2, 'Left', 2, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(123, 0, 'Bookings review', '', '', 1, 1, 'Left', 4, 'fa-list', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(124, 123, 'Inserted bookings', '', 'agents/insertedBookings', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(125, 0, 'Extra excursions', '', '', 1, 1, 'Left', 5, 'fa-university', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(126, 125, 'Book extra excursions', '', 'agents/bookExtraExcursions/confirmed/id_centro/asc', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(127, 125, 'Review excursions prices', '', 'agents/viewExtraExcursions/confirmed/id_book/desc', 1, 2, 'Left', 2, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(128, 0, 'Attractions and entrances', '', '', 1, 1, 'Left', 6, 'fa-globe', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(129, 128, 'Available attractions', '', 'agents/viewAttractions', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(130, 128, 'View booked attractions', '', 'agents/viewBookedAttractions', 1, 2, 'Left', 2, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(131, 0, 'Media gallery', '', '', 1, 1, 'Left', 7, 'fa-picture-o', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(132, 131, 'Image gallery', '', 'agents/imageGallery', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(133, 0, 'Manage agents', '', '', 1, 1, 'Left', 3, 'fa-users', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(134, 133, 'View agents', '', 'agents/listAgents', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(135, 133, 'Insert agent/prospect', '', 'agents/insertAgent', 1, 2, 'Left', 2, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(136, 0, 'CRM Module', '', '', 1, 1, 'Left', 4, 'fa-user', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(137, 136, 'View organizer', '', 'agents/viewOrganizer/2016', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(138, 0, 'ST history data', '', '', 1, 1, 'Left', 3, 'fa-file-o', '2014-12-20 06:55:49', 123, '2014-12-30 12:42:21', 123, 0),
(139, 138, 'Import file', '', 'sthistory/import', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(140, 138, 'ST history data report', '', 'sthistory/report', 1, 2, 'Left', 2, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(141, 0, 'Dashboard', 'ST data dashboard', 'webservice/index', 1, 1, 'Left', 1, 'fa-dashboard', '2014-12-20 06:55:33', 123, '2015-07-03 10:03:03', 123, 0),
(142, 138, 'Report professori', '', 'sthistory/report/professori', 1, 2, 'Left', 1, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(143, 138, 'Report corporate', '', 'sthistory/report/corporate', 1, 2, 'Left', 2, '', '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
