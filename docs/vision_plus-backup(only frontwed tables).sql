-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2018 at 02:13 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vision_plus`
--

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `getWorkingday`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getWorkingday` (`d1` DATETIME, `d2` DATETIME, `retType` VARCHAR(20)) RETURNS VARCHAR(255) CHARSET utf8 BEGIN
 DECLARE dow1, dow2,daydiff,workdays, weekenddays, retdays,hourdiff INT;
    declare newstrt_dt datetime;
   SELECT dd.iDiff, dd.iDiff - dd.iWeekEndDays AS iWorkDays, dd.iWeekEndDays into daydiff, workdays, weekenddays
  FROM (
   SELECT
     dd.iDiff,
     ((dd.iWeeks * 2) + 
      IF(dd.iSatDiff >= 0 AND dd.iSatDiff < dd.iDays, 1, 0) + 
      IF (dd.iSunDiff >= 0 AND dd.iSunDiff < dd.iDays, 1, 0)) AS iWeekEndDays
       FROM (
      SELECT  dd.iDiff, FLOOR(dd.iDiff / 7) AS iWeeks, dd.iDiff % 7 iDays, 5 - dd.iStartDay AS iSatDiff,  6 - dd.iStartDay AS iSunDiff
     FROM (
      SELECT
        1 + DATEDIFF(d2, d1) AS iDiff,
        WEEKDAY(d1) AS iStartDay
      ) AS dd
    ) AS dd
  ) AS dd ;
  if(retType = 'day_diffs') then
  set retdays = daydiff; 
 elseif(retType = 'work_days') then
  set retdays = workdays; 
 elseif(retType = 'weekend_days') then  
  set retdays = weekenddays; 
 end if; 
    RETURN retdays; 
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_adult_course_brochure`
--

DROP TABLE IF EXISTS `frontweb_adult_course_brochure`;
CREATE TABLE IF NOT EXISTS `frontweb_adult_course_brochure` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(255) DEFAULT NULL,
  `file_description` text,
  `course_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_adult_course_brochure`
--

INSERT INTO `frontweb_adult_course_brochure` (`id`, `file_name`, `file_description`, `course_id`) VALUES
(1, '1514289779.pdf', 'BROCHURE', 13);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_application_form_data`
--

DROP TABLE IF EXISTS `frontweb_application_form_data`;
CREATE TABLE IF NOT EXISTS `frontweb_application_form_data` (
  `application_form_data_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `field_name` text,
  `field_value` text,
  `user` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  PRIMARY KEY (`application_form_data_id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_application_form_data`
--

INSERT INTO `frontweb_application_form_data` (`application_form_data_id`, `field_name`, `field_value`, `user`, `added_date`) VALUES
(1, 'Name', 'test name', 1, '2017-12-29 06:29:06'),
(2, 'Gender', 'Female', 1, '2017-12-29 06:29:06'),
(3, 'Date of Birth', '2017-12-29', 1, '2017-12-29 06:29:06'),
(4, 'Telephone/Mobile', '1234567898', 1, '2017-12-29 06:29:06'),
(5, 'Email address', 'test@testsite.com', 1, '2017-12-29 06:29:06'),
(6, 'Skype name', 'test skype name', 1, '2017-12-29 06:29:06'),
(7, 'Address –including country of current residence', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their', 1, '2017-12-29 06:29:06'),
(8, 'Nationality', 'test nationality', 1, '2017-12-29 06:29:06'),
(9, 'What is the best time to speak and the time difference from where you are based with the UK GMT?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their', 1, '2017-12-29 06:29:06'),
(10, 'How did you hear about University Direct?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their', 1, '2017-12-29 06:29:06'),
(11, 'University Course(s) and level (e.g. BA/BSc/MA/MSc/PhD etc) you are interested in? ', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their', 1, '2017-12-29 06:29:06'),
(12, 'Desired university location in the UK if you have a preference e.g. London, Scotland?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their', 1, '2017-12-29 06:29:06'),
(13, 'Please list your current and pending future educational qualifications and attainment/anticipated attainment (e.g. International Baccalaureate or equivalent and subject areas):', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their', 1, '2017-12-29 06:29:06'),
(14, 'Have you got any relevant work experience? ', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their', 1, '2017-12-29 06:29:06'),
(15, 'For non-English speakers, English Language qualifications held or expected scores (e.g. IELTS scores in listening, reading, writing and speaking):', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their', 1, '2017-12-29 06:29:06'),
(16, 'How do you plan on financing your studies including your tuition fees?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their', 1, '2017-12-29 06:29:06'),
(17, 'Any other information that can help us advise you? (Work experience, disabilities, gap year information etc.):', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their', 1, '2017-12-29 06:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_centre_master_old`
--

DROP TABLE IF EXISTS `frontweb_centre_master_old`;
CREATE TABLE IF NOT EXISTS `frontweb_centre_master_old` (
  `centre_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_name` varchar(100) DEFAULT NULL,
  `centre_image` varchar(200) DEFAULT NULL,
  `region_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`centre_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_centre_master_old`
--

INSERT INTO `frontweb_centre_master_old` (`centre_id`, `centre_name`, `centre_image`, `region_id`) VALUES
(1, 'BRIGHTON', 'brighton.jpg', 1),
(2, 'CANTERBURY', 'canterbury.jpg', 1),
(3, 'CHELMSFORD', 'chelmsford.jpg', 1),
(4, 'CHESTER', 'chester.jpg', 1),
(5, 'EDINBURGH', 'edinburgh.jpg', 1),
(6, 'EFFINGHAM', 'effingham.jpg', 1),
(7, 'LIVERPOOL', 'liverpool.jpg', 1),
(8, 'LONDON GREENWICH', 'london_greenwich.jpg', 1),
(9, 'LONDON KINGSTON', 'london_kingston.jpg', 1),
(10, 'LOUGHBOROUGH', 'loughborough.jpg', 1),
(11, 'STIRLING', 'stirling.jpg', 1),
(12, 'WINDSOR', 'windsor.jpg', 1),
(13, 'LOS ANGELES', 'los_angeles.jpg', 2),
(14, 'MIAMI', 'miami.jpg', 2),
(15, 'NEW YORK CENTRAL', 'new_york_central.jpg', 2),
(16, 'NEW YORK RIDER', 'new_york_rider.jpg', 2),
(17, 'DUBLIN', 'dublin.jpg', 3),
(18, 'MALTA VILLAGE', 'malta_village.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_contentmst`
--

DROP TABLE IF EXISTS `frontweb_contentmst`;
CREATE TABLE IF NOT EXISTS `frontweb_contentmst` (
  `cont_contentid` int(8) NOT NULL AUTO_INCREMENT COMMENT 'Unique Identifier',
  `cont_menuid` int(8) NOT NULL COMMENT 'Unique Identifier (Id of the menu under which menubar is created.)',
  `cont_browser_title` varchar(100) NOT NULL COMMENT 'Used to display browser title',
  `cont_page_title` varchar(250) NOT NULL,
  `cont_url_name` varchar(80) NOT NULL COMMENT 'Unique page name which is used in url to display the contents of the particular offmenu',
  `cont_meta_description` varchar(200) NOT NULL COMMENT 'Used to display meta description which can be seen in page source',
  `cont_keywords` varchar(200) NOT NULL COMMENT 'Used to display meta keywords which can be seen in page source',
  `cont_content` text NOT NULL COMMENT 'Used to store content displayed in front end',
  `cont_pdf_file` varchar(100) NOT NULL,
  `cont_external_url` varchar(255) NOT NULL,
  `cont_content_type` int(1) NOT NULL DEFAULT '1' COMMENT '1=content,2=pdf,3=external link',
  `cont_created_on` datetime NOT NULL COMMENT 'Date on which content is added in menus, menubars or sidemenubars.',
  `cont_created_by` int(8) NOT NULL COMMENT 'Id of the user who added content in menus, menubars or sidemenubars',
  `cont_modified_on` datetime NOT NULL COMMENT 'Date on which content details are updated in menus, menubars or sidemenubars.',
  `cont_modified_by` int(8) NOT NULL COMMENT 'Id of the user who modified the content details in menus, menubars or sidemenubars',
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cont_contentid`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1 COMMENT='Content Master table';

--
-- Dumping data for table `frontweb_contentmst`
--

INSERT INTO `frontweb_contentmst` (`cont_contentid`, `cont_menuid`, `cont_browser_title`, `cont_page_title`, `cont_url_name`, `cont_meta_description`, `cont_keywords`, `cont_content`, `cont_pdf_file`, `cont_external_url`, `cont_content_type`, `cont_created_on`, `cont_created_by`, `cont_modified_on`, `cont_modified_by`, `is_deleted`) VALUES
(1, 1, 'Home', 'home', 'homepage', '', '', '<p>The above method takes <strong>three</strong> parameters as input:</p>\n<ol class="arabic simple"><li>The field name - the exact name you’ve given the form field.</li><li>A “human” name for this field, which will be inserted into the error\nmessage. For example, if your field is named “user” you might give it\na human name of “Username”.</li><li>The validation rules for this form field.</li><li>(optional) Set custom error messages on any rules given for current field. If not provided will use the default one.</li></ol>', '', '', 1, '2017-12-11 09:42:03', 0, '2017-12-11 09:42:03', 0, 0),
(2, 7, '', '', '', '', '', '', '1515392687_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(3, 8, '', '', '', '', '', '', '1515393152_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(4, 9, '', '', '', '', '', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\n<div class="col-12" style="padding: 10px;">\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\n</div>\n</div>\n<div class="col-12" style="padding: 10px;">\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\n</div>\n</div>\n</div>', '', '', 1, '2018-01-09 10:17:33', 0, '2018-01-09 10:17:33', 0, 0),
(5, 10, '', '', '', '', '', '<div class="col-12">\n<div style="padding: 4px; background-color: #fafafa;">\n<p style="margin-top: 10px; font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/carousel2.jpg?1515414171636" alt="carousel2" /></p>\n<p style="margin-top: 10px; font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">The members of our team have been carefully selected for their responsible and caring attitude and for being fun-loving and outgoing. They are the people you can turn to at any time for assistance. Our PLUS Team will ensure that students enjoy their holidays in an exciting and safe environment. PLUS promises a wonderful, memorable and enriching summer camp experience.</p>\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6; margin-left: 43px;">\n<li><span style="text-indent: -18pt;">- Qualified, experienced choreographers who are skilled to teach a variety of dance sessions.</span></li>\n<li><span style="text-indent: -18pt;">- Sports Leaders who are trained and experienced to a professional level.</span></li>\n<li><span style="text-indent: -18pt;">- Enthusiastic and energetic Activity Leaders who stimulate and entertain students.</span></li>\n</ul>\n</div>\n</div>', '', '', 1, '2018-01-09 10:20:39', 0, '2018-01-09 10:20:39', 0, 0),
(6, 11, '', '', '', '', '', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\n<div class="col-12">\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\n</ul>\n</div>\n</div>\n</div>', '', '', 1, '2018-01-09 10:18:53', 0, '2018-01-09 10:18:53', 0, 0),
(7, 3, 'About us', 'About us', 'about-us', 'Plus Education Development', 'Plus,Vision', '<div class="col-md-12" style="width: 100%; float: left; position: relative;">\n<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" style="float: left; position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px;">\n<h2 style="margin-top: 5px; color: #656565; margin-bottom: 10px; font-family: ''Roboto Condensed'', sans-serif;">Plus Educational</h2>\n<p>Professional Linguistic Upper Studies started operating in the EFL market in 1972.<br /> Today, our group with offices in London, Dublin, New York , Milan and Malta, represents one of the world''s largest and finest organisations in language teaching.</p>\n</div>\n<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12" style="float: left; width: position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px;">\n<h2 style="margin-top: 5px; color: #656565; margin-bottom: 10px; font-family: ''Roboto Condensed'', sans-serif;">General Accreditation and Quality Assurance Criteria</h2>\n<div class="list-group" style="padding-left: 0; margin-bottom: 20px;">\n<ul>\n<li class="list-group-item" style="position: relative; display: block; padding: 10px 15px; margin-bottom: -1px; background-color: #fff; border: 1px solid #ddd;">Legal requirements</li>\n<li class="list-group-item" style="position: relative; display: block; padding: 10px 15px; margin-bottom: -1px; background-color: #fff; border: 1px solid #ddd;">Premises</li>\n<li class="list-group-item" style="position: relative; display: block; padding: 10px 15px; margin-bottom: -1px; background-color: #fff; border: 1px solid #ddd;">Management</li>\n<li class="list-group-item" style="position: relative; display: block; padding: 10px 15px; margin-bottom: -1px; background-color: #fff; border: 1px solid #ddd;">Office systems</li>\n<li class="list-group-item" style="position: relative; display: block; padding: 10px 15px; margin-bottom: -1px; background-color: #fff; border: 1px solid #ddd;">Absence management and student retention</li>\n<li class="list-group-item" style="position: relative; display: block; padding: 10px 15px; margin-bottom: -1px; background-color: #fff; border: 1px solid #ddd;">Academic standards and student achievement</li>\n<li class="list-group-item" style="position: relative; display: block; padding: 10px 15px; margin-bottom: -1px; background-color: #fff; border: 1px solid #ddd;">Resources</li>\n<li class="list-group-item" style="position: relative; display: block; padding: 10px 15px; margin-bottom: -1px; background-color: #fff; border: 1px solid #ddd;">Welfare</li>\n<li class="list-group-item" style="position: relative; display: block; padding: 10px 15px; margin-bottom: -1px; background-color: #fff; border: 1px solid #ddd;">Student accommodation</li>\n</ul>\n</div>\n</div>\n</div>', '', '', 1, '2018-01-23 05:17:49', 0, '2018-01-23 05:17:49', 0, 0),
(8, 12, '', '', '', '', '', '', '1519824308_UKUNIVERSITYPLACEMENT_compressed.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(9, 13, '', '', '', '', '', '<ul class="list-unstyled" style="padding-left: 0;list-style: none;font-weight: normal;color: #8f8f8f;">\n						<li>8-10 Grosvenor Gardens,</li>\n						<li>Mezzanine floor,</li>\n						<li>London, SW1W 0DH</li>\n						<li>T. + 44 (0)20 7730 2223</li>\n						<li>F: + 44 (0)20 7730 9209</li>\n						<li>Email: plus@plus-ed.com</li>\n					</ul>', '', '', 1, '2017-12-14 10:43:16', 0, '2017-12-14 10:43:16', 0, 0),
(10, 38, '', '', '', '', '', '', '1513318742_PLUSSocialMediaPolicy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(11, 39, '', '', '', '', '', '', '1513318761_PLUSFireSafetyPolicy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(12, 40, '', '', '', '', '', '', '1513318773_PLUSSafeguardingandChildProtectionPolicy2017JFrevisedv2trackchanges2.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(13, 37, ' Terms and conditions', ' Terms and conditions', 'terms-and-condition', '', '', '<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						1. BOOKING CONDITIONS\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					By submitting the Booking Application, the Agent formally agrees to abide by PLUS Terms &amp; Conditions set herein.\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						2. DEPOSITS\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					If the booking is accepted, the Agent must pay by the date indicated, a non-refundable deposit of £ 120.00 for UK and $ 120.00 for USA per person upon&nbsp;\n					confirmation of the booking. Failing this, the places will be automatically released with no further communication. Partial payments, payment falling short of the&nbsp;\n					full amount due and/or notification of payments will not be sufficient to retain bookings. The deposit paid will be deducted from the total amount due to be paid&nbsp;\n					21 days before arrival (please refer to par 7).\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						3. PRICES\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					All prices are exclusive of any value added or any sales tax or any other tax which may become applicable and for which the Agent shall be additionally liable.\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						4. SERVICES\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					In return for the payment of the appropriate fees PLUS will provide board, tuition and activities as specified on the website. Not included in the fees are: general&nbsp;\n					expenses (except where clearly indicated), entrance to museums and attractions, airport transfers.\n					Changes of services, facilities or dates of programmes are avoided whenever possible. On rare occasions generally due to circumstances beyond PLUS’ control, or&nbsp;\n					where the bookings in a centre do not reach the minimum numbers required to viably operate it, changes may be necessary. In these circumstances PLUS shall&nbsp;\n					either offer equivalent services/facilities or refund in full all fees paid. No other claims for compensation or expenses can be considered. Neither PLUS, nor the&nbsp;\n					Agent shall be in any way liable to the client if a service cannot be supplied by reason of industrial dispute, or other cause outside their control. There is no&nbsp;\n					reduction in the course fee where a course includes a public holiday.\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						5. INSURANCE\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					The Agent shall, at its own expense, obtain and maintain throughout the duration of the courses an insurance cover for public liability, event and personal injury&nbsp;\n					liability to or the death of any person and any loss or destruction of or damage to property not attributable to any fault or neglect of the clients with an&nbsp;\n					insurance company of repute. Copies of all such insurance policies and evidence that all premiums have been paid shall be presented on PLUS’ demand.\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						6. WARRANTY &amp; LIABILITY&nbsp;\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					PLUS, its staff and representatives will not be liable for any loss, damage, illness or injury to persons or property however caused, except where such liability is&nbsp;\n					imposed by statute. Clients must have personal insurance against medical expenses, third parties, travel insurance, including inability to attend or continue a&nbsp;\n					course.\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						6.1. STUDENT WELFARE AND GROUP LEADERS’ RESPONSIBILITIES\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					PLUS only accepts closed groups accompanied by their group leader.&nbsp;\n					Except for Intensive English bookings (UK), the Group Leader must be at least 25 years old and speak fluent English.\n					The Group Leader is the ultimate person responsible for supervising his/her group constantly day and night and must comply with the student welfare, security&nbsp;\n					and safety rules set by PLUS. Group leaders’ duties and responsibilities are well defined and encompassed in the Handbook. Agents/schools are required to hand&nbsp;\n					it out to their selected staff members, drawtheir attention to the student Welfare paragraph and ultimately invite them to sign a statement of acceptance prior&nbsp;\n					to their departure.\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						7. PAYMENTS\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					The balance with final number of students is due 21 days before the arrival date. Payments must be credited to the PLUS bank account, without deduction or&nbsp;\n					setoff and free from any taxes, levies or other charges or encumbrances. If the sums due are not accredited on the date indicated, all agent’s bookings are&nbsp;\n					subject to immediate release and the deposit paid will be forfeited to PLUS. If by the term indicated on relevant invoice (s) the Agent fails to pay for clients, staff&nbsp;\n					booked over and above the places initially secured at the centre or for any extra services requested, PLUS is entitled to cancel or suspend any further service to&nbsp;\n					the Agents’ clients at any or all the centres.\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						8. CANCELLATION FEES\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					In case of cancellation, the deposit paid is forfeited to PLUS. For places cancelled the following penalties will be levied. If the booking is cancelled between:\n					• 21 days before arrival, loss of deposit paid\n					• 15 days before arrival, 70%\n					• 7 days before arrival, 100% of the total package cost.\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						9. SCHOOL REGULATIONS\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					PLUS uncompromisingly prohibits illicit drugs, violence, racism, classroom disruption and dishonesty. No drugs, tobacco products or alcohol are permitted at any&nbsp;\n					centre, function or when on excursions. Clients are expected to abide by the College disciplinary regulations, and demonstrate reasonable standards of conduct&nbsp;\n					within and outside the classroom. Failure to do this may result in expulsion from the course. In this event, no refunds become applicable.\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						10. VISA STUDENTS\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					If, in spite of a PLUS sponsorship letter, the British Embassy or American Embassy does not grant a visa, PLUS shall reimburse the initial deposit of £ 120.00 for UK&nbsp;\n					and $ 120.00 for USA upon receiving a copy of the formal Embassy document confirming such refusal. Cancellation charges still apply (please refer to par 8).\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						11. COMPLAINTS APPLICABLE TO UK\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					Over the years PLUS has been able to fully respond to students’ requirements and to minimize cause for complaints. This does not necessarily mean, however,&nbsp;\n					that something cannot go wrong. If a student is unhappy or dissatisfied with any part of the programme ie teaching, leisure activities, host family and so on, he/\n					she should observe the following procedure:&nbsp;\n					STEP 1 Discuss the problem with his/her leader who will report the problem to the Campus Manager, who should solve it within 36 working hours.&nbsp;\n					STEP 2 If the problem persists, the student can call or ask his/her group leader to office (0207 7302223 ). Necessary steps will then be taken without delay.&nbsp;\n					STEP 3 If the problem still cannot be solved, then the student may refer the complaint to: ABLS PO BOX 312, GREAT YARMOUTH NR30 9EP.&nbsp;\n					The complaint can also be sent to British Council: Customer Services, Accreditation Unit Bridgewater House, 58 Whitworth Street, Manchester M1 6BB, UK.\n					Or emailed to: accreditation.unit@britishcouncil.org The complaint must be written in English, specifying whether action has already been taken by PLUS, and\n					signed. The student should also state whether he/she is happy for the complaint to be copied to PLUS.\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						12. FORCE MAJEURE\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					If PLUS or the Agent is affected by Force Majeure it shall forthwith notify the other party of the nature and extent thereof. Neither party shall be deemed to be&nbsp;\n					in breach of this Agreement. Neither party shall or otherwise be liable to the other, by reason of any delay in performance, or non performance, of any of its\n					obligations.\n				</li>\n			</div>\n		</div>\n\n		<div class="col-md-12" style="float: left;width: 100%;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">\n			<div style="padding-left: 0;margin-bottom: 20px;" class="list-group">\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					<span style="color: #396192;font-weight: bold;">\n						13. PROPER LAW\n					</span>\n				</li>\n				<li style="position: relative;display: block;padding: 10px 15px;margin-bottom: -1px;background-color: #fff;border: 1px solid #ddd;" class="list-group-item">\n					These Terms &amp; Conditions are construed in accordance with the English Law. All disputes, controversies or claims shall be referred to and finally settled under&nbsp;\n					the rules of Arbitration of the International Chamber of Commerce of London by three arbitrators appointed in accordance with those Rules that are known and&nbsp;\n					accepted by the Parties. It is hereby agreed that the Commercial Court of London shall have exclusive jurisdiction over any judicial proceedings howsoever&nbsp;\n					related to the interpretation of these Terms &amp; Conditions which may not be deferred to arbitration.\n					Previous Terms &amp; Conditions are superseded. London, 21 December 2017 .\n				</li>\n			</div>\n		</div>', '', '', 1, '2017-12-15 06:54:51', 0, '2017-12-15 06:54:51', 0, 0),
(14, 41, '', '', '', '', '', '<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;"><b><u>Examinations- </u></b></p>\n<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">Prior to arrival, students can book and enrol to take The Trinity Graded Examination in Spoken English exam. This is a face to face oral exam at 12 different levels from Elementary to Advanced. Students will obtain an official internationally-recognised certificate from Trinity if successful. Trinity preparation lessons can also be offered (usually in the afternoons and as an extra to the study course) at an additional cost.</p>\n<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;"><b><u>Excursions and attractions- </u></b></p>\n<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">Thanks to our PLUS Vision system, you can now include more excursions to your preferred destinations in the UK and Ireland. Vision allows you to tailor your package - making it more appealing and less costly for your specific clients. You will be able to book per seat on coaches for these excursions. This provides you with the ability to create a better package at a lower rate. Various destinations are available and more information can be found in the agent’s area. </p>\n\n<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">In addition to the included sites you can make a “tailor made package” by adding additional entry places into attractions at an extra charge. The attractions offered are different per centre and dependent on location and availability. </p>', '', '', 1, '2017-12-22 07:21:02', 0, '2017-12-22 07:21:02', 0, 0),
(15, 15, '', '', '', '', '', '', '1515394480_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(16, 16, '', '', '', '', '', '', '1515394490_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(17, 18, '', '', '', '', '', '', '1516709856_choreographerjob.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(18, 17, '', '', '', '', '', '', '1516709870_campusmanagerjob.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(19, 20, '', '', '', '', '', '', '1516709881_activityleaderjob.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(20, 21, '', '', '', '', '', '', '1516709954_directorjob.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(21, 19, '', '', '', '', '', '', '1516709965_teacherjob.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(22, 22, '', '', '', '', '', '', '1515394562_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(23, 23, '', '', '', '', '', '', '1515394572_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(24, 24, '', '', '', '', '', '', '1515394580_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(25, 25, '', '', '', '', '', '', '1515394590_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(26, 26, '', '', '', '', '', '', '1515394599_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(27, 27, '', '', '', '', '', '', '1515394607_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(28, 28, '', '', '', '', '', '', '1515394617_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(29, 29, '', '', '', '', '', '', '1515394627_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(30, 30, '', '', '', '', '', '', '1515394636_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(31, 31, '', '', '', '', '', '', '1515394645_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(32, 32, '', '', '', '', '', '', '1515394655_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(33, 33, '', '', '', '', '', '', '1515394666_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(34, 34, '', '', '', '', '', '', '1515394676_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(35, 35, '', '', '', '', '', '', '1515394687_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(36, 36, '', '', '', '', '', '', '1515394697_dummy.pdf', '', 2, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(37, 4, 'Contact us', 'Contact us', 'contact-us', 'Plus Education Development', 'Plus,Vision', '<p style="padding-left: 15px;">Dear user,&nbsp;</p>\n<p style="padding-left: 15px;">To provide you with the information you require as quickly and as precisely as possible, please select one of the topics listed below:</p>\n<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-top: 30px;">\n<h3 style="font-size: 24px; font-family: ''Roboto Condensed'', sans-serif; color: #959795;">PLUS General Enquiries</h3>\n<address class="margin-bottom-30px">\n<ul class="list-unstyled" style="padding-left: 0; list-style: none; font-weight: normal; color: #8f8f8f;">\n<li>Professional Linguistic Upper Studies</li>\n<li>8-10 Grosvenor Gardens,</li>\n<li>Mezzanine floor,</li>\n<li>London, SW1W 0DH</li>\n<li style="font-size: 16px; color: #00b3f0;">Switchboard:</li>\n<li>T. + 44 (0)20 7730 2223</li>\n<li>F: + 44 (0)20 7730 9209</li>\n<li style="font-size: 16px; color: #00b3f0;">Email:</li>\n<li>plus@plus-ed.com</li>\n</ul>\n</address></div>\n<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-top: 30px;">\n<h3 style="font-size: 24px; font-family: ''Roboto Condensed'', sans-serif; color: #959795;">PLUS Academic</h3>\n<address class="margin-bottom-30px">\n<ul class="list-unstyled" style="padding-left: 0; list-style: none; font-weight: normal; color: #8f8f8f;">\n<li>Professional Linguistic Upper Studies</li>\n<li>8-10 Grosvenor Gardens,</li>\n<li>Mezzanine floor,</li>\n<li>London, SW1W 0DH</li>\n<li style="font-size: 16px; color: #00b3f0;">Switchboard:</li>\n<li>T. + 44 (0)20 7730 2223</li>\n<li>F: + 44 (0)20 7730 9209</li>\n<li style="font-size: 16px; color: #00b3f0;">Email:</li>\n<li>recruitment@plus-ed.com</li>\n</ul>\n</address></div>\n<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-top: 30px;">\n<h3 style="font-size: 24px; font-family: ''Roboto Condensed'', sans-serif; color: #959795;">PLUS Management</h3>\n<address class="margin-bottom-30px">\n<ul class="list-unstyled" style="padding-left: 0; list-style: none; font-weight: normal; color: #8f8f8f;">\n<li>Professional Linguistic Upper Studies</li>\n<li>8-10 Grosvenor Gardens,</li>\n<li>Mezzanine floor,</li>\n<li>London, SW1W 0DH</li>\n<li style="font-size: 16px; color: #00b3f0;">Switchboard:</li>\n<li>T. + 44 (0)20 7730 2223</li>\n<li>F: + 44 (0)20 7730 9209</li>\n<li style="font-size: 16px; color: #00b3f0;">Email:</li>\n<li>Leisure@plus-ed.com</li>\n</ul>\n</address></div>\n<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-top: 30px;">\n<h3 style="font-size: 24px; font-family: ''Roboto Condensed'', sans-serif; color: #959795;">PLUS Finance</h3>\n<address class="margin-bottom-30px">\n<ul class="list-unstyled" style="padding-left: 0; list-style: none; font-weight: normal; color: #8f8f8f;">\n<li>Professional Linguistic Upper Studies</li>\n<li>8-10 Grosvenor Gardens,</li>\n<li>Mezzanine floor,</li>\n<li>London, SW1W 0DH</li>\n<li style="font-size: 16px; color: #00b3f0;">Switchboard:</li>\n<li>T. + 44 (0)20 7730 2223</li>\n<li>F: + 44 (0)20 7730 9209</li>\n<li style="font-size: 16px; color: #00b3f0;">Email:</li>\n<li>finance@plus-ed.com</li>\n</ul>\n</address></div>\n<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-top: 30px;">\n<h3 style="font-size: 24px; font-family: ''Roboto Condensed'', sans-serif; color: #959795;">PLUS Operational</h3>\n<address class="margin-bottom-30px">\n<ul class="list-unstyled" style="padding-left: 0; list-style: none; font-weight: normal; color: #8f8f8f;">\n<li>Professional Linguistic Upper Studies</li>\n<li>8-10 Grosvenor Gardens,</li>\n<li>Mezzanine floor,</li>\n<li>London, SW1W 0DH</li>\n<li style="font-size: 16px; color: #00b3f0;">Switchboard:</li>\n<li>T. + 44 (0)20 7730 2223</li>\n<li>F: + 44 (0)20 7730 9209</li>\n<li style="font-size: 16px; color: #00b3f0;">Email:</li>\n<li>bookings@plus-ed.com</li>\n</ul>\n</address></div>\n<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-top: 30px;">\n<h3 style="font-size: 24px; font-family: ''Roboto Condensed'', sans-serif; color: #959795;">PLUS Agencies</h3>\n<address class="margin-bottom-30px">\n<ul class="list-unstyled" style="padding-left: 0; list-style: none; font-weight: normal; color: #8f8f8f;">\n<li>Professional Linguistic Upper Studies</li>\n<li>8-10 Grosvenor Gardens,</li>\n<li>Mezzanine floor,</li>\n<li>London, SW1W 0DH</li>\n<li style="font-size: 16px; color: #00b3f0;">Switchboard:</li>\n<li>T. + 44 (0)20 7730 2223</li>\n<li>F: + 44 (0)20 7730 9209</li>\n<li style="font-size: 16px; color: #00b3f0;">Email:</li>\n<li>plus@plus-ed.com</li>\n</ul>\n</address></div>', '', '', 1, '2018-01-30 13:37:55', 0, '2018-01-30 13:37:55', 0, 0),
(38, 42, '', '', '', '', '', '<p><img style="min-height: 300px; width: 100%;" src="../../../../uploads/tinymce/Mainmast-Room-2-1920x500.jpg?1517207045039" alt="Mainmast-Room-2-1920x500" /></p>\n<p>&nbsp;</p>\n<p>Every centre chosen by PLUS Team has been carefully analized in order to give students the best possible experience according to the type of infrastructure it offers.</p>\n<p>&nbsp;</p>\n<p>When PLUS selects a centre we carefully analyze the location, type of facilities, typology of the type of bedrooms, classes and all the logistical aspects. PLUS is able to promote a centre, once all answers from an operational organizational as well as from a clients prospective is positive.</p>', '', '', 1, '2018-01-29 06:33:37', 0, '2018-01-29 06:33:37', 0, 0),
(39, 43, '', '', '', '', '', '<p><img style="min-height: 300px; width: 100%;" src="../../../../uploads/tinymce/DLD-Homepage-banner-2017-Layout-10.jpg?1517208364367" alt="DLD-Homepage-banner-2017-Layout-10" /></p>\n<p>&nbsp;</p>\n<p>Plus provides a number of programmes between the USA and Europe in order for your students to choose the right location with the right package at the right price.</p>\n<p>&nbsp;</p>\n<p><strong>Destinations: </strong>United Kingdom, Ireland, USA &amp; Malta.</p>', '', '', 1, '2018-01-29 06:46:35', 0, '2018-01-29 06:46:35', 0, 0),
(40, 44, '', '', '', '', '', '<p><img style="min-height: 300px; width: 100%;" src="../../../../uploads/tinymce/New-International-Arrival-Student-Tour-Cropped-1920x500.jpg?1517208432910" alt="New-International-Arrival-Student-Tour-Cropped-1920x500" /></p>\n<p>&nbsp;</p>\n<p>As a provider of British Council and ABLS accredited courses, it is our mission to raise the standard and quality of experience for students, making sure that our students experience the best lessons and extra curricular activities in a safe and supervised environment.</p>\n<p>Our on-site welfare and support staff are on hand 24 hours a day- should you need any help while you are with us. All PLUS Staff undergo induction training by our Head of Operations Staff. Teachers and Leisure organisers are all specifically trained to work with non English speakers and all teachers must have a minimum TEFL qualification.</p>\n<p>&nbsp;</p>\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Who''s Who on campus?</span></h2>\n<p>&nbsp;</p>\n<p><span style="color: #3c7099;"><u>Course Director</u></span></p>\n<p>The Course Director has overall responsibility for the academic side of the programme.</p>\n<p>&nbsp;</p>\n<p><span style="color: #3c7099;"><u>Campus Manager</u></span></p>\n<p>The Campus Manager has overall responsibility for the wellbeing of all students while staying at our PLUS centre. anything!!</p>\n<p>&nbsp;</p>\n<p><span style="color: #3c7099;"><u>Activity Leader</u></span></p>\n<p>Activity Leaders run the afternoon and evening activities on campus. Students can recognise them by their PLUS T-shirts and sweatshirts.</p>\n<p>&nbsp;</p>\n<p><span style="color: #3c7099;"><u>Teacher</u></span></p>\n<p>PLUS teachers lead classes every morning and students will get to know their teacher very well.</p>', '', '', 1, '2018-01-29 06:47:28', 0, '2018-01-29 06:47:28', 0, 0),
(41, 45, 'Accomodation', 'Accomodation', 'accomodation', 'Plus Education Development', 'Plus,Vision', '<p><img style="min-height: 300px; width: 100%;" src="../../../../uploads/tinymce/Mainmast-Room-2-1920x500.jpg?1517207045039" alt="Mainmast-Room-2-1920x500" /></p>\n<p>&nbsp;</p>\n<p>Every centre chosen by PLUS Team has been carefully analized in order to give students the best possible experience according to the type of infrastructure it offers.</p>\n<p>&nbsp;</p>\n<p>When PLUS selects a centre we carefully analyze the location, type of facilities, typology of the type of bedrooms, classes and all the logistical aspects. PLUS is able to promote a centre, once all answers from an operational organizational as well as from a clients prospective is positive.</p>', '', '', 1, '2018-01-29 08:59:12', 0, '2018-01-29 08:59:12', 0, 0),
(42, 46, 'Activities On Campus', 'Activities On Campus', 'activity-on-campus', 'Plus Education Development', 'Plus,Vision', '<p><img style="min-height: 300px; width: 100%;" src="../../../../uploads/tinymce/DLD-Homepage-banner-2017-Layout-10.jpg?1517208364367" alt="DLD-Homepage-banner-2017-Layout-10" /></p>\n<p>&nbsp;</p>\n<p>Plus provides a number of programmes between the USA and Europe in order for your students to choose the right location with the right package at the right price.</p>\n<p>&nbsp;</p>\n<p><strong>Destinations: </strong>United Kingdom, Ireland, USA &amp; Malta.</p>', '', '', 1, '2018-01-29 09:00:15', 0, '2018-01-29 09:00:15', 0, 0),
(43, 47, 'Our Team', 'Our Team', 'our-team', 'Plus Education Development', 'Plus,Vision', '<p><img style="min-height: 300px; width: 100%;" src="../../../../uploads/tinymce/New-International-Arrival-Student-Tour-Cropped-1920x500.jpg?1517208432910" alt="New-International-Arrival-Student-Tour-Cropped-1920x500" /></p>\n<p>&nbsp;</p>\n<p>As a provider of British Council and ABLS accredited courses, it is our mission to raise the standard and quality of experience for students, making sure that our students experience the best lessons and extra curricular activities in a safe and supervised environment.</p>\n<p>Our on-site welfare and support staff are on hand 24 hours a day- should you need any help while you are with us. All PLUS Staff undergo induction training by our Head of Operations Staff. Teachers and Leisure organisers are all specifically trained to work with non English speakers and all teachers must have a minimum TEFL qualification.</p>\n<p>&nbsp;</p>\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Who''s Who on campus?</span></h2>\n<p>&nbsp;</p>\n<p><span style="color: #3c7099;"><u>Course Director</u></span></p>\n<p>The Course Director has overall responsibility for the academic side of the programme.</p>\n<p>&nbsp;</p>\n<p><span style="color: #3c7099;"><u>Campus Manager</u></span></p>\n<p>The Campus Manager has overall responsibility for the wellbeing of all students while staying at our PLUS centre. anything!!</p>\n<p>&nbsp;</p>\n<p><span style="color: #3c7099;"><u>Activity Leader</u></span></p>\n<p>Activity Leaders run the afternoon and evening activities on campus. Students can recognise them by their PLUS T-shirts and sweatshirts.</p>\n<p>&nbsp;</p>\n<p><span style="color: #3c7099;"><u>Teacher</u></span></p>\n<p>PLUS teachers lead classes every morning and students will get to know their teacher very well.</p>', '', '', 1, '2018-01-29 09:00:59', 0, '2018-01-29 09:00:59', 0, 0),
(44, 50, '', '', '', '', '', '<div>Direct Download</div>', '', '', 1, '2018-02-13 06:23:23', 0, '2018-02-13 06:23:23', 0, 0),
(45, 51, '', '', '', '', '', '<div>Direct Download</div>', '', '', 1, '2018-02-13 06:24:01', 0, '2018-02-13 06:24:01', 0, 0),
(46, 52, '', '', '', '', '', '<ol class="iosInstruction">\n<li>Go to App Store&nbsp;&nbsp;&nbsp;<img style="width: 70px; height: 60px;" src="../../../../uploads/tinymce/app_store.png?1518503588199" alt="app_store" /></li>\n<li>Open and search for Document by Readdle&nbsp;<img style="width: 100%; margin-left: -40px;" src="../../../../uploads/tinymce/document.png?1518503619294" alt="document" /></li>\n<li>Click OPEN to Download</li>\n<li>Click on the button on the bottom right hand side (indicated)&nbsp;<img style="width: 100%; margin-left: -25px;" src="../../../../uploads/tinymce/main_screen.png?1518503631700" alt="main_screen" /></li>\n<li>Insert the following link <u style="color: blue;">http://plus-ed.com/betaweb/plus-walking-tour</u></li>\n<li>Select YOUR Centre</li>\n<li>Insert the password (provided by the PLUS Campus Manager)</li>\n<li>Click on your walking tour or activity plan</li>\n<li>Choose the file you wish to download</li>\n<li>Click on the Harrow to save it on your IOS (Red Circle)&nbsp;<img style="width: 100%; margin-left: -25px;" src="../../../../uploads/tinymce/download.png?1518503645081" alt="download" /></li>\n<li>Once the download is terminated you can view the walking tour <strong>OFF LINE</strong></li>\n</ol>', '', '', 1, '2018-02-13 07:10:33', 0, '2018-02-13 07:10:33', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_course_feature`
--

DROP TABLE IF EXISTS `frontweb_course_feature`;
CREATE TABLE IF NOT EXISTS `frontweb_course_feature` (
  `course_feature_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `feature_title` varchar(100) DEFAULT NULL,
  `feature_description` text,
  `feature_image` varchar(200) DEFAULT NULL,
  `course_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`course_feature_id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_course_feature`
--

INSERT INTO `frontweb_course_feature` (`course_feature_id`, `feature_title`, `feature_description`, `feature_image`, `course_id`) VALUES
(38, ' COURSE LEVELS BOXED', '								<u>Level 1- Elementary:</u><br>\n								The course covers basic vocabulary such as places, families, jobs, times, interests and hobbies, food and drink. It introduces grammar for initial communication. Students also learn to introduce themselves, talk about jobs, ask questions, give a description, plan a trip, and talk about their likes and dislikes.<br>\n								<br><u>Level 2- Pre- intermediate:</u><br>\n								This level builds on students’ vocabulary, revising and developing lexis for more sophisticated interaction. Students learn to communicate on a variety of topics: talking about daily lives and routines, making comparisons, talking about free-time activities and life experiences, describing activities, people and feelings, talking about past events.<br>\n								<br><u>Level 3- Intermediate:</u><br>\n								At this level students are taught a range of techniques to increase their vocabulary while grammatical concepts are revised and reinforced. Skills and functions include: introducing themselves and each other, discussing differences, planning a trip, completing and collating surveys, making complaints, giving advice and creating an advertisement.<br>\n								<br><u>Level 4- Upper-Intermediate:</u><br>\n								Students are expected to refine and develop vocabulary topics and areas of grammatical competency. Functions include: asking for and giving personal information, making future predictions, participating in an interview, talking about character and emotions, discussing hypothetical situations, writing a magazine article.<br>\n								<br><u>Level 5- Advanced:</u><br>\n								At this level students take an active role in discovering which areas of language they need to work on and improve, and to learn ways of doing this effectively. Students work with authentic texts and begin to identify aspects of phonology such as word stress and intonation. Functions covered include: debating, hypothesising, evaluating, identifying and participating in debates on contemporary topics.<br>', '15119465581.jpg', 1),
(41, 'THE PLUS COURSE BOOK BOXED', '<div style="position: relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" src="https://www.youtube.com/embed/RKhfXO0g-PY" allowfullscreen="" width="484" height="315" frameborder="0"></iframe></div><br>', '15119465585.jpg', 1),
(40, ' EXAMS BOXED', '								PLUS is a registered centre for the Trinity Graded Examinations in Spoken English. We encourage students to take this exam because it is a spoken exam and particularly suits the emphasis of our courses.<br>\n								The Trinity examination, offered at 12 levels, tests the students’ abilities in fluency, pronunciation, accuracy of language, vocabulary range, and communication strategies. Students can enroll to take this exam before arrival and we will then organise an exam for them at the centre they are studying. Trinity preparation lessons can also be offered (usually in the afternoons and as an extra to the study course) at an additional cost.\n', '15119465582.jpg', 1),
(39, 'COURSE AIMS BOXED', '							1. Students will develop and increase their vocabulary.<br>\n								2. Students will improve their speaking and listening skills.<br>\n								3. Students will be introduced to British culture.<br>\n								4. Students will be provided with lots of opportunities to use their English in and outside the classroom.<br>\n								5. Students will build their confidence in using English.<br>6. Students will make new friends.', '1511946558.jpg', 1),
(42, 'OUR TEACHERS BOXED', 'All our teachers are professional, well-prepared and have been selected for their experience, friendliness and enthusiasm. They hold at least a certificate in ELT/TESOL or have a qualified teacher status in conformity with the British Council criteria.', '15119465583.jpg', 1),
(43, 'SYLLABUS BOXED', '								PLUS courses are designed for students who wish to become more proficient in English and more confident in their speaking and listening skills. Our highly-interactive course reflects our students’ needs and is focused on functional and communicative language studies with a specific focus on vocabulary and pronunciation. Reading and writing skills are also enhanced through course book work as well as through diary writing which is included in the daily schedule. We strongly believe that students will learn much more if they are enjoying their study so our lessons are always fun and educational.', '15119465584.jpg', 1),
(68, 'In Family', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">PLUS families have hosted students for many years. They are made up of friendly, caring,\nkind, courteous individuals who are well aware of the apprehension you may have when\ncoming to a new house. They will try their best to make you feel like a member of the family.\nBreakfast and dinner are taken with the family who will also provide students with a packed\nlunch (this may be also purchased at the school).</p>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">Families generally live no more than 45-60 minutes away from the centre.</p><p>\n</p><p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">Family stay is mostly advisable for students who are more independent with at least\nan intermediate level of English.</p><p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">Families are selected either directly by PLUS Host Family Organizers or in most cases\nby a reputable British Council accredited agency in the UK.</p>\n', '1513333639.jpg', 14),
(65, 'On Campus', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">If you are looking for a more independent lifestyle and enjoy a fun atmosphere shared with\nold and new friends from different countries, living on campus is the ideal choice for you.</p>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">You will experience real college life in a supported and secure environment and you will be\nable to take advantage of all the facilities the campus has to offer.</p><p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">These amenities are generally all close to each other: classrooms, first class sports facilities,\nthe cafeteria and other social and recreational facilities.</p>', '1513333115.jpg', 14),
(66, 'English Course', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">The courses have been designed to\nenhance students’ verbal and written\ncommunication skills in the language.\nOur EFL qualified teachers focus on\nlively learning and encourage group\ninteraction to stimulate the constant\nuse of vocabulary both within and outside\nthe class. To encourage effective\ninteraction between the students and\nteachers, the classes are small with a\nmaximum class size of 15. The courses\nare planned around 20 lessons per\nweek (45 minute each i.e. 15 hours per\nweek) at up to five different levels from\nElementary to Advanced.\nStudents are placed on a level depending\non the result of the student placement\ntest taken on the first day of\nlessons. Since students are accepted\nand taught in closed groups, it is very\nimportant that group enrolments are\ndone with students of same or similar\nlevels of English language proficiency.\nThe course books and learning supplementary\nmaterials are provided\nfree of charge and at the end of your\nstay, you will be awarded a PLUS End\nof Course Certificate.</p>', '15133336391.jpg', 14),
(67, 'Add-on Package', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">All our programmes are based on a standard package which includes:</p>\n<ul>\n<li style="display: block;">--Boarding</li>\n<li style="display: block;">--15 hours of General English Tuition</li>\n<li style="display: block;">--A maximum class size of 15 students</li>\n<li style="display: block;">--Orientation tour of campus and its facilities</li>\n<li style="display: block;">--Daily 24 hour assistance</li>\n</ul><br>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">As a PLUS partner through our online system you can Add on Package\nto the standard programme by:</p>\n<ul>\n<li style="display: block;">--Adding additional full day or half day excursions</li>\n<li style="display: block;">--Purchasing attraction tickets for the included or extra excursions</li>\n<li style="display: block;">--Adding extra hours of tuition</li>\n<li style="display: block;">--Decreasing number of students per class</li>\n<li style="display: block;">--Increasing number of lessons provided</li>\n<li style="display: block;">--Arranging activities on and off campus such as sport tournaments, discos, etc.</li>\n<li style="display: block;">--Adding Trinity Exams</li>\n</ul>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">In our agency area you can download a suggested activity programme which will provide you with an\nexample of how a programme can be arranged and a pricing structure.</p>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">You can however create an ad hoc service according to your budget, length of stay and group size. If\nthis is needed our sales team is more than happy to guide you through the booking process and provide\na programme which will best suit you and your client needs.</p>', '15133336392.jpg', 14),
(74, 'Succeeding in your studies', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">Whilst at university in the UK, students can benefit substantially through obtaining\nindependent mentoring advice. PLUS takes two approaches:</p>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n- Offering regular advice to discuss current and upcoming academic challenges<br>\n- Providing specific support at key times in the academic year<br>\n- The aim of these services are to help students succeed academically and gain\nconfidence in their academic ability.\n</p>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">This is delivered through a number of approaches including:</p>\n- Academic mentoring on all aspects of study including, project work, exam preparation\nand research skills<br>\n- Specialist advice on dissertation and project selection<br>\n- Proof reading services including stylistic writing advice<br>\n- Selecting and applying for placements in industry<br>\n- Gaining relevant work experience in university holidays.<br>\n\n', '15139427532.jpg', 13),
(72, 'Making your choice', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">Choosing a degree course and university is often a daunting prospect. PLUS provide\nspecialist support to make this process easier, providing carear advice and support in\nselecting your degree and university.</p>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">PLUS helps prospective undergraduate and postgraduate applicants (Masters Degrees\nand PhDs) to make the right choices, in the following subject areas:</p>\n- Science, Mathematics and Engineering<br>\n- Humanities and Social Sciences<br>\n- Law<br>\n- Business Studies, Economics and Finance<br>\n- Sports and Health<br>\n- Art, Design and Fashion<br>', '1513942753.jpg', 13),
(73, 'About our academic staff', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">The PLUS University Support was established to provide independent specialist advice\nand support to help prospective students make the right choice and submit a successful\napplication to university.</p>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">Whilst support in applying to university is our most popular service, we recognize that\nthis is just the start of your academic journey and we are able to support you\nthroughout your time at university in the UK.</p>\n', '15139427531.jpg', 13),
(75, 'Taught undegradute and postgraduate courses', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n									Whilst every client is different and we pride ourselves on providing a personal and impartial service,\n									our application support service has been designed to ensure our clients make the best choices and give\n									themselves:\n								</p><br><br>\n								<div style="width: 100%;">\n									<p style="width:40%;float:left; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Initial Skype call to understand the clients interests and ability\n									</p>\n									<p style="width: 20%;float: left"><img style="width: 65px;" src="images/right.png"></p>\n									<p style="width:40%;float:left;color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Undertake research outlining at least 6 universities offering suitable courses\n									</p>\n								</div>\n								<div style="width: 100%;">\n									<p style="width: 70%;float: left;"></p>\n									<p style="width: 30%;float: left"><img style="width: 65px;" src="images/down.png"></p>\n								</div>\n								<div style="width: 100%;">\n									<p style="width:40%;float:left; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Skype calls to discuss the application process and personal statement\n									</p>\n									<p style="width: 20%;float: left"><img style="width: 65px;" src="images/left.png"></p>\n									<p style="width:40%;float:left;color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Follow up Skype call/s to discuss course options\n									</p>\n								</div>\n								<div style="width: 100%;">\n									<p style="width: 30%;"><img style="width: 65px;" src="images/down.png"></p>\n									<p style="width: 70%;float: left;"></p>\n								</div>\n								<div style="width: 100%;">\n									<p style="width:40%;float:left; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Skype and written support to help the client develop the best possible application\n									</p>\n									<p style="width: 20%;float: left"><img style="width: 65px;" src="images/right.png"></p>\n									<p style="width:40%;float:left;color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Supporting submission through the UCAS process (undergraduate) and through direct applications (postgraduate). Advising on next steps\n									</p>\n								</div>\n								<div class="clearfix"></div><br><br>\n								<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n									Some courses do, however, need more support requiring further input from PLUS this includes:\n								</p><br><br>\n								<div style="width: 100%;">\n									<p style="width:50%;float:left; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Specialist advice when applying for medicine, dentistry or veterinary science\n									</p>\n									<p style="width:50%;float:left;color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Tailored support and interview preparation for Oxbridge applicants\n									</p>\n								</div>\n								<div class="clearfix"></div>\n								<div style="width: 100%;">\n									<p style="width:50%;float:left; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Information and advice about moving to the UK and living in the different university cities\n									</p>\n									<p style="width:50%;float:left;color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										More in depth careers counselling to ensure those who a less sure of their plans make the right choices\n									</p>\n								</div>\n								<div class="clearfix"></div><br><br>\n								<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n									Following a successful application, PLUS can help our clients throughout their time at University,\n									through a range of mentoring and advisory services including:\n								</p><br><br>\n								<div style="width: 100%;">\n									<p style="width:50%;float:left; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Regular academic mentoring sessions\n									</p>\n									<p style="width:50%;float:left;color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Advice and support on dissertations, projects and placement\n									</p>\n								</div>\n								<div class="clearfix"></div>', '1514281190.jpg', 13),
(76, 'Prospective undergraduate students', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n									Services being provided to a prospective undergraduate student\n								</p>\n								<h2>PHASE 1</h2><br>\n								<h3 style="color: #999 !important;font-weight: bold;">Phase 1 includes:</h3>\n								<ul>\n									<li style="display: list-item;margin-left: 30px;">Independent advice to help a student make the right choice of course and university</li>\n									<li style="display: list-item;margin-left: 30px;">Research into 5 suitable course options that meet student’s needs and expected educational attainment.</li>\n								</ul><br>\n								<h3 style="color: #999 !important;font-weight: bold;">Phase 1 Steps:</h3>\n								<ul>\n									<li style="margin-left: 30px;">1. Student completes enquiry form</li>\n									<li style="margin-left: 30px;">2. Our consultant arranges a Skype call with the student</li>\n									<li style="margin-left: 30px;">3. PLUS undertakes research into 5 suitable courses and universities based on the information identified above</li>\n									<li style="margin-left: 30px;">4. Second Skype call to present research to a student and provide an opportunity to progress to Phase 2.</li>\n								</ul><br>\n								<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">Price: £500.00</p><br>\n								<h2>PHASE 2</h2><br>\n								<h3 style="color: #999 !important;font-weight: bold;">Phase 2 includes:</h3>\n								<ul>\n									<li style="display: list-item;margin-left: 30px;">\n										Advice to ensure your UCAS form is completed and submitted correctly\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Advice on writing an accompanying personal statement\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Advice on other areas such as obtaining a suitable school reference and completing IELTS test\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Advice on what course to select as your first and insured choice.\n									</li>\n								</ul><br>\n								<h3 style="color: #999 !important;font-weight: bold;">Phase 2 Steps:</h3>\n								<ul>\n									<li style="display: list-item;margin-left: 30px;">\n										Student registers with UCAS through PLUS which is a registered UCAS centre.\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										PLUS provides guidance on completing the UCAS form, obtaining school reference and undertaking additional tests like IELTS etc.\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										PLUS provides guidance on writing a personal statement. Student writes a draft version. PLUS reviews it and provides feedback.\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Student completes administrative side of UCAS form including uploading the finalised personal statement.\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Skype call(s) are scheduled with the student as necessary to ensure the form is completed correctly.\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Student submits UCAS form.\n									</li>\n								</ul><br>\n								<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">Price: £1,200.00</p><br>', '1514281190.png', 13),
(77, 'Our team', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nAll our Academic Team is here to provide\na personalised and independent support\nfor undergraduate and postgraduate\nstudents.\n</p><br>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nHaving worked with students throughout\ntheir career, they will be the primary\npoint of contact.\n</p><br>\n\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nThe team have experience working and\nlecturing at the UK universities across\nmultidisciplinary fields such as science,\nsocial science and business.\n</p><br>\n\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nThanks to their experience we are able to\nprovide unique and specialist support and\nadvice.\n</p><br>\n\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nOur associates work in specialist fields in\nacademia, healthcare and industry.\n</p><br>', '15142811901.jpg', 13),
(78, 'Securing your place at university', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nPLUS t supports you to secure your preferred course and university. In the UK, this\nprocess involves completing a UCAS application form, which requires you to submit a\npersonal statement and for some courses attend an interview. We guide you through\nthis process, considering your academic ability and interests, working with you to\nunderstand your strengths, and increasing your confidence to succeed\nin your applications.\n</p><br>\n\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nOur expert advice provides support to students and their parents and guardians in\nconsidering the following aspects:\n</p><br>\n\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nCareers counselling, professional advice, researching choices of degree and university to\nsuit an applicant’s academic ability and interests (a minimum of six courses are\nthoroughly researched).\n</p>\n\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nAdvice on English language requirements for courses, tuition fees and scholarships\nwhere possible\n</p>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n- Advice on all aspects of the UCAS process<br>\n- Support in writing the accompanying personal statement<br>\n- Interview preparation for undergraduates and postgraduates<br>\n- Specialist support and advice in applying to Oxbridge<br>\nPostgraduate service providing support to MPhil and PhD applicants in identifying\nacademic specialists and preparing project proposals.\n</p>', '15142811902.jpg', 13),
(79, 'Living in the uk', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nComing to study in the UK from overseas is an amazing experience.\nHowever, moving to the UK is a big moment in a new students life. Ensuring that many\nof the practicalities of living in the UK are dealt with is important. PLUS provides advice\non moving to and living in the UK.\n</p><br>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nHaving a great time, making new friends and exploring new places are integral to\nstudying successfully. All universities offer a wide range of clubs and societies which are\nreally important in making friends with like minded people. Studying in the UK also\nprovides an opportunity to explore the countries rich cultural heritage and many areas\nof outstanding natural beauty.\n</p><br>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nPLUS''s mentoring programme not only supports you to excel in your studies, but also to\nmake the most of your time in the UK. We can help you in moving to the UK and once\nyou have arrived.\n</p><br>\n<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\nYour university experience will be individual to you. Our independent personal support\nmeans we are always here if you need our help or guidance.\n</p><br>', '15142811903.jpg', 13),
(80, 'Postgraduate research course', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n									With the UK being a leading nation for excellence in research there are a wealth of opportunities for\n									postgraduate students looking to develop their academic careers. PLUS offers a bespoke range of highly\n									personalised services to support our clients in securing PhD, MPhil &amp; MRes studentships.\n									<b>This process is unique</b> to <b>each</b> student but usually at the first stage follows the approach below:\n								</p><br>\n								<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n									Initial Skype call to understand the clients research interests and discuss application options\n								</p>\n								<div style="width: 100%;">\n									<p style="width: 50%;float: left;text-align: center;margin-left: -60px;"><img style="width: 65px;" src="images/down.png"></p>\n									<p style="width: 50%;float: left;text-align: center;"><img style="width: 65px;" src="images/down.png"></p>\n								</div>\n								<div style="width: 100%;">\n									<p style="width:50%;float:left; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										<u>Applying for advertised opportunity</u><br> Undertake an initial review of currently advertised opportunities\n									</p>\n									<p style="width:50%;float:left;color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										<u>Proposing own project </u><br>Provide advice on how to draft a research proposal\n									</p>\n								</div>\n								<div style="width: 100%;">\n									<p style="width: 50%;float: left;text-align: center;margin-left: -60px;"><img style="width: 65px;" src="images/down.png"></p>\n									<p style="width: 50%;float: left;text-align: center;"><img style="width: 65px;" src="images/down.png"></p>\n								</div>\n								<div style="width: 100%;">\n									<p style="width:50%;float:left; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Skype call to discuss opportunities and<br> advice on searching for further<br> opportunities\n									</p>\n									<p style="width:50%;float:left;color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Skype consultation to review students proposal and identify potential research groups\n									</p>\n								</div>\n								<div class="clearfix"></div>\n								<br>\n								<p style="width:100%;float:left;text-align: center; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n									Bespoke services\n								</p><br>\n								<div style="width: 100%;">\n									<p style="width: 50%;float: left;text-align: center;margin-left: -60px;"><img style="width: 65px;" src="images/down.png"></p>\n									<p style="width: 50%;float: left;text-align: center;"><img style="width: 65px;" src="images/down.png"></p>\n								</div>\n								<div style="width: 100%;">\n									<p style="width:50%;float:left; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Skype and written support to develop the application and to\n									</p>\n									<p style="width:50%;float:left;color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Skype and written support to develop and submit a full proposal\n									</p>\n								</div>\n								<div class="clearfix"></div><br>\n								<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n									Once the client receives their place within the research group the work begins. Postgraduate research\n									is highly rewarding but equally challenging. PLUS supports our clients throughout their research\n									through a range of mentoring and advisory services including:\n								</p><br>\n								<div style="width: 100%;">\n									<p style="width:50%;float:left; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Regular academic mentoring sessions\n									</p>\n									<p style="width:50%;float:left;color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Advice and support on thesis writing, publications and reports\n									</p>\n								</div>\n								<div style="width: 100%;">\n									<p style="width:50%;float:left; color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Presentation skills and networking\n									</p>\n									<p style="width:50%;float:left;color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n										Support in progressing their academic career post studies\n									</p>\n								</div>\n								<div class="clearfix"></div>', '15142811901.png', 13),
(81, 'Prospective postgraduate students application process', '<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">\n									Services being provided to a prospective undergraduate student\n								</p>\n								<h2>PHASE 1</h2><br>\n								<h3 style="color: #999 !important;font-weight: bold;">Phase 1 includes:</h3>\n								<ul>\n									<li style="display: list-item;margin-left: 30px;">\n										Independent advice to help a student make the right choice of course and university\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Research into 5 suitable course options that meet student’s needs and expected educational attainment.\n									</li>\n								</ul><br>\n								<h3 style="color: #999 !important;font-weight: bold;">Phase 1 Steps:</h3>\n								<ul>\n									<li style="margin-left: 30px;">1. Student completes enquiry form</li>\n									<li style="margin-left: 30px;">2. Our consultant arranges a Skype call with the student</li>\n									<li style="margin-left: 30px;">3. PLUS undertake research into 5 suitable courses and universities based on the information identified above</li>\n									<li style="margin-left: 30px;">4. Second Skype call to present research to a student and provide an opportunity to progress to Phase 2.</li>\n								</ul><br>\n								<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">Price: £500.00</p><br>\n								<h2>PHASE 2</h2><br>\n								<h3 style="color: #999 !important;font-weight: bold;">Phase 2 includes:</h3>\n								<ul>\n									<li style="display: list-item;margin-left: 30px;">\n										Advice to ensure each postgraduate application is completed and submitted correctly\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Advice in writing an accompanying personal statement\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Advice in writing a suitable CV\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Support in other areas – e.g. obtaining a suitable reference and taking IELTS tests\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Advice on what course to select when offers come through.\n									</li>\n								</ul><br>\n								<h3 style="color: #999 !important;font-weight: bold;">Phase 2 Steps:</h3>\n								<ul>\n									<li style="display: list-item;margin-left: 30px;">\n										Student registers with individual universities and completes administrative side of each application form.\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										PLUS provides advice on completing each form (via Skype calls), obtaining a reference and undertaking additional tests like IELTS etc.\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										PLUS reviews a student’s CV and provides one round of feedback.\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										PLUS provides guidance on writing a personal statement. Student writes a draft version. PLUS reviews it and provides feedback.\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										With guidance, the student finalises their personal statement.\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										Student submits each application form.\n									</li>\n									<li style="display: list-item;margin-left: 30px;">\n										When offers are through, a Skype call is arranged to provide advice on what should be student’s first and insured choice.\n									</li>\n								</ul><br>\n								<p style="color: #999 !important;font-weight: normal !important;text-transform: none !important;">Price: £1,800.00</p><br>', '15142811902.png', 13);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_course_language`
--

DROP TABLE IF EXISTS `frontweb_course_language`;
CREATE TABLE IF NOT EXISTS `frontweb_course_language` (
  `course_language_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `course_name` varchar(100) DEFAULT NULL,
  `corse_description` text,
  `language_id` int(11) DEFAULT NULL,
  `course_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`course_language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_course_language`
--

INSERT INTO `frontweb_course_language` (`course_language_id`, `course_name`, `corse_description`, `language_id`, `course_id`) VALUES
(1, 'JUNIOR SUMMER COURSES', 'Our summer school offers students opportunities to practice their English under the supervision of qualified and experienced teachers. Classes are learner-centred with all students being given the opportunity to speak as much as possible. Lessons involve the use of pair and group work, as well as whole class participation. We use specially designed text books which have been specifically written for teenage students on short summer courses. At the end of the course, students are given an end-of-course-certificate which includes assessment comments from his/her teachers.', 1, 1),
(13, 'ADULT COURSES', '<p>PLUS provides independent specialist advice and support to help prospective students\nmake the right choice and submit a successful application to university.</p><br>\n\n<p>Whilst support to prospective undergraduate and postgraduate students in applying to\nuniversity is our most popular service, we recognise that this is just the start of\nyour academic journey and we are able to support you throughout your time at\nuniversity.</p><br>\n\n<p>PLUS student focused approach is in the heart of what we do and what makes our work\nso rewarding.</p><br>\n\n<p>No one person is the same so we support the candidate and their family to make the\nbest decision and guide through every step of their university journey.</p><br>', 1, 13),
(14, 'JUNIOR MINI STAY', '<p>The quest for excellence and the client’s satisfaction has been PLUS’s mission since it\nstarted operating in 1972. Over the years, our staff, our centres and our programmes have\nchanged considerably, however, our principles have remained the same.\nWhether you stay at one of our Summer Centres or take part in one of our Mini Stay\nprogrammes in the United Kingdom, or the United States, you will enjoy\nyour study course and free time activities. More importantly, you will receive the same\nexcellent levels of care and supervision you require.</p><br>\n<p>Today PLUS, with offices in London, New York, Beijing, Milan, is among the world’s finest\norganizations specialising in the teaching of English language to students from all over the\nworld who wish to improve their proficiency of the language.</p><br>\n<p>Each Year PLUS all year round mini stay programmes run from September to May.</p><br>\n<p>The programme has been designed to offer students and Groups high quality english lessons\nand an opportunity to build a suitable package of their choice according to their own budget.\nThis has been achieved by giving each group a basic package consisting of General English lessons\nand full board accommodation as well as free time built into the programme during which groups\ncan organize varies social activities such as sports and excursions as well as attractions\nat an additional costs.</p><br>\n<p>The PLUS staff can supervise all activities and ultimetely be responsibile for students welfare.</p><br>\n\n<p><b>LEISURE ORGANIZERS</b><br>Leisure organizers run the afternoon sports, social and entertainment programmes as well the\nevening activities on campus.\nThey can also have students practise their english while playing sport and enjoy many leisure\nactivities.</p><br>\n<p><b>QUALIFIED TEACHERS</b><br>On request professional and creative staff will follow the organization of the Academy courses\nsuch as multi sport, dance, performing arts, horse riding, golf and tennis.</p>', 1, 14);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_course_master`
--

DROP TABLE IF EXISTS `frontweb_course_master`;
CREATE TABLE IF NOT EXISTS `frontweb_course_master` (
  `course_master_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `course_image` varchar(200) DEFAULT NULL,
  `course_front_image` varchar(200) DEFAULT NULL,
  `course_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active , 0:inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not deleted and 1 = deleted',
  PRIMARY KEY (`course_master_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_course_master`
--

INSERT INTO `frontweb_course_master` (`course_master_id`, `course_image`, `course_front_image`, `course_status`, `delete_flag`) VALUES
(1, '1511946212.jpg', '1511946212.jpg', 1, 0),
(14, '1513332289.jpg', '1513332289.JPG', 1, 0),
(13, '1513329286.jpg', '1513329286.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_course_specification`
--

DROP TABLE IF EXISTS `frontweb_course_specification`;
CREATE TABLE IF NOT EXISTS `frontweb_course_specification` (
  `course_specification_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `specification_option` varchar(100) DEFAULT NULL,
  `specification_value` varchar(200) DEFAULT NULL,
  `course_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`course_specification_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_course_specification`
--

INSERT INTO `frontweb_course_specification` (`course_specification_id`, `specification_option`, `specification_value`, `course_id`) VALUES
(34, 'Class Size', '15 students per class', 1),
(33, 'Time', 'Morning or/and afternoon', 1),
(32, 'Class hours', '15 hours per week', 1),
(31, 'Level', 'Elementary - Advanced', 1),
(30, 'Age', '11-17', 1),
(35, 'Course Length', 'min. 2-4 weeks', 1);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_extra_day_activity`
--

DROP TABLE IF EXISTS `frontweb_extra_day_activity`;
CREATE TABLE IF NOT EXISTS `frontweb_extra_day_activity` (
  `extra_day_activity_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `extra_master_activity_id` int(11) DEFAULT NULL COMMENT 'foreign key',
  `date` date DEFAULT NULL,
  PRIMARY KEY (`extra_day_activity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_extra_day_activity`
--

INSERT INTO `frontweb_extra_day_activity` (`extra_day_activity_id`, `extra_master_activity_id`, `date`) VALUES
(1, 1, '2016-07-19'),
(2, 1, '2016-07-20'),
(3, 1, '2016-07-21'),
(4, 1, '2016-07-22'),
(5, 1, '2016-07-23'),
(6, 1, '2016-07-24'),
(7, 1, '2016-07-25'),
(8, 1, '2016-07-26'),
(9, 1, '2016-07-27'),
(10, 1, '2016-07-28'),
(11, 1, '2016-07-29'),
(12, 1, '2016-07-30'),
(13, 1, '2016-07-31'),
(14, 1, '2016-08-01'),
(15, 1, '2016-08-02'),
(16, 1, '2016-08-03'),
(17, 1, '2016-08-04'),
(18, 1, '2016-08-05'),
(19, 1, '2016-08-06'),
(20, 1, '2016-08-07'),
(21, 1, '2016-08-08'),
(22, 1, '2016-08-09'),
(23, 1, '2016-08-10'),
(24, 1, '2016-08-11'),
(25, 1, '2016-08-12'),
(26, 1, '2016-08-13'),
(27, 1, '2016-08-14'),
(28, 1, '2016-08-15'),
(29, 1, '2016-08-16');

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_extra_day_activity_details`
--

DROP TABLE IF EXISTS `frontweb_extra_day_activity_details`;
CREATE TABLE IF NOT EXISTS `frontweb_extra_day_activity_details` (
  `extra_day_activity_details_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `from_time` time DEFAULT NULL,
  `to_time` time DEFAULT NULL,
  `managed_by` varchar(255) DEFAULT NULL,
  `extra_day_activity_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`extra_day_activity_details_id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_extra_day_activity_details`
--

INSERT INTO `frontweb_extra_day_activity_details` (`extra_day_activity_details_id`, `program_name`, `location`, `activity`, `from_time`, `to_time`, `managed_by`, `extra_day_activity_id`) VALUES
(2, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 1),
(3, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 2),
(4, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 2),
(5, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 3),
(6, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 3),
(7, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 4),
(8, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 4),
(9, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 5),
(10, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 5),
(11, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 6),
(12, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 6),
(13, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 7),
(14, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 7),
(15, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 8),
(16, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 8),
(17, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 9),
(18, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 9),
(19, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 10),
(20, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 10),
(21, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 11),
(22, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 11),
(23, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 12),
(24, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 12),
(25, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 13),
(26, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 13),
(27, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', ' ', 14),
(28, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', ' ', 14),
(29, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 15),
(30, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 15),
(31, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 16),
(32, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 16),
(33, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 17),
(34, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 17),
(35, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 18),
(36, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 18),
(37, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 19),
(38, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 19),
(39, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 20),
(40, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 20),
(41, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 21),
(42, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 21),
(43, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 22),
(44, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 22),
(45, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 23),
(46, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 23),
(47, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 24),
(48, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 24),
(49, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 25),
(50, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 25),
(51, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 26),
(52, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 26),
(53, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 27),
(54, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 27),
(55, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 28),
(56, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 28),
(57, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 29),
(58, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 29),
(59, 'Eating', 'Breakfast Room 1', 'Breakfast', '15:05:00', '16:45:00', 'updated ', 2),
(60, 'Lession', 'Hall room 1', 'Lession', '15:05:00', '16:45:00', ' ', 1),
(61, 'Lession', 'Hall room 1', 'Lession', '15:05:00', '16:45:00', 'Gabriel ', 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_extra_master_activity`
--

DROP TABLE IF EXISTS `frontweb_extra_master_activity`;
CREATE TABLE IF NOT EXISTS `frontweb_extra_master_activity` (
  `extra_master_activity_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_id` int(11) DEFAULT NULL,
  `student_group` int(11) DEFAULT NULL,
  `group_reference_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`extra_master_activity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_extra_master_activity`
--

INSERT INTO `frontweb_extra_master_activity` (`extra_master_activity_id`, `centre_id`, `student_group`, `group_reference_id`) VALUES
(1, 3, 3, 1509);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_extra_section`
--

DROP TABLE IF EXISTS `frontweb_extra_section`;
CREATE TABLE IF NOT EXISTS `frontweb_extra_section` (
  `extra_section_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `course_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`extra_section_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_extra_section`
--

INSERT INTO `frontweb_extra_section` (`extra_section_id`, `course_id`, `name`, `slug`) VALUES
(1, 1, 'Horse Riding', 'horse-riding'),
(2, 2, 'Golf Play', 'golf-play'),
(3, 1, 'New Year Program', 'new-year-program'),
(4, 1, 'Test section', 'test-section'),
(5, 1, 'Test extra section', 'test-extra-section');

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_extra_section_content`
--

DROP TABLE IF EXISTS `frontweb_extra_section_content`;
CREATE TABLE IF NOT EXISTS `frontweb_extra_section_content` (
  `extra_section_content_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_id` int(11) DEFAULT NULL,
  `extra_section_id` int(11) NOT NULL COMMENT 'foreign key',
  `description` text,
  `file_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`extra_section_content_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_extra_section_content`
--

INSERT INTO `frontweb_extra_section_content` (`extra_section_content_id`, `centre_id`, `extra_section_id`, `description`, `file_name`) VALUES
(1, 3, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1518497346.pdf'),
(2, 3, 1, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English.', '1518497376.pdf'),
(3, 1, 2, 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', '1518499032.pdf'),
(4, 3, 3, 'New year program details.', '1518500738.pdf'),
(5, 3, 4, 'test description', '1518510224.pdf'),
(6, 3, 5, 'test destails', '1518599651.pdf'),
(7, 14, 1, 'test now', '1519088608.pdf'),
(8, 3, 2, 'test now', '1519088862.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_fixed_day_activity`
--

DROP TABLE IF EXISTS `frontweb_fixed_day_activity`;
CREATE TABLE IF NOT EXISTS `frontweb_fixed_day_activity` (
  `fixed_day_activity_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `master_activity_id` int(11) DEFAULT NULL COMMENT 'foreign key',
  `date` date DEFAULT NULL,
  PRIMARY KEY (`fixed_day_activity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_fixed_day_activity`
--

INSERT INTO `frontweb_fixed_day_activity` (`fixed_day_activity_id`, `master_activity_id`, `date`) VALUES
(1, 1, '2018-03-12'),
(2, 1, '2018-03-13'),
(3, 1, '2018-03-14'),
(4, 1, '2018-03-15'),
(5, 1, '2018-03-16'),
(6, 2, '2018-03-12'),
(7, 2, '2018-03-13'),
(8, 2, '2018-03-14'),
(9, 2, '2018-03-15'),
(10, 2, '2018-03-16'),
(11, 3, '2018-03-12'),
(12, 3, '2018-03-13'),
(13, 3, '2018-03-14'),
(14, 3, '2018-03-15'),
(15, 3, '2018-03-16'),
(16, 4, '2016-07-18'),
(17, 4, '2016-07-19'),
(18, 4, '2016-07-20'),
(19, 4, '2016-07-21'),
(20, 4, '2016-07-22'),
(21, 4, '2016-07-23'),
(22, 4, '2016-07-24'),
(23, 4, '2016-07-25'),
(24, 4, '2016-07-26'),
(25, 4, '2016-07-27'),
(26, 4, '2016-07-28'),
(27, 4, '2016-07-29'),
(28, 4, '2016-07-30'),
(29, 4, '2016-07-31'),
(30, 4, '2016-08-01'),
(31, 4, '2016-08-02'),
(32, 4, '2016-08-03'),
(33, 4, '2016-08-04'),
(34, 4, '2016-08-05'),
(35, 4, '2016-08-06'),
(36, 4, '2016-08-07'),
(37, 4, '2016-08-08'),
(38, 4, '2016-08-09'),
(39, 4, '2016-08-10'),
(40, 4, '2016-08-11'),
(41, 4, '2016-08-12'),
(42, 4, '2016-08-13'),
(43, 4, '2016-08-14'),
(44, 4, '2016-08-15'),
(45, 4, '2016-08-16'),
(46, 4, '2016-08-17'),
(47, 4, '2016-08-18'),
(48, 4, '2016-08-19'),
(49, 5, '2016-07-18'),
(50, 5, '2016-07-19'),
(51, 5, '2016-07-20'),
(52, 5, '2016-07-21'),
(53, 5, '2016-07-22'),
(54, 5, '2016-07-23'),
(55, 5, '2016-07-24'),
(56, 5, '2016-07-25'),
(57, 5, '2016-07-26'),
(58, 5, '2016-07-27'),
(59, 5, '2016-07-28'),
(60, 5, '2016-07-29'),
(61, 5, '2016-07-30'),
(62, 5, '2016-07-31'),
(63, 5, '2016-08-01'),
(64, 5, '2016-08-02'),
(65, 5, '2016-08-03'),
(66, 5, '2016-08-04'),
(67, 5, '2016-08-05'),
(68, 5, '2016-08-06'),
(69, 5, '2016-08-07'),
(70, 5, '2016-08-08'),
(71, 5, '2016-08-09'),
(72, 5, '2016-08-10'),
(73, 5, '2016-08-11'),
(74, 5, '2016-08-12'),
(75, 5, '2016-08-13'),
(76, 5, '2016-08-14'),
(77, 5, '2016-08-15'),
(78, 5, '2016-08-16'),
(79, 5, '2016-08-17'),
(80, 5, '2016-08-18'),
(81, 5, '2016-08-19');

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_fixed_day_activity_details`
--

DROP TABLE IF EXISTS `frontweb_fixed_day_activity_details`;
CREATE TABLE IF NOT EXISTS `frontweb_fixed_day_activity_details` (
  `fixed_day_activity_details_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `from_time` time DEFAULT NULL,
  `to_time` time DEFAULT NULL,
  `managed_by` varchar(255) DEFAULT NULL,
  `fixed_day_activity_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`fixed_day_activity_details_id`)
) ENGINE=MyISAM AUTO_INCREMENT=177 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_fixed_day_activity_details`
--

INSERT INTO `frontweb_fixed_day_activity_details` (`fixed_day_activity_details_id`, `program_name`, `location`, `activity`, `from_time`, `to_time`, `managed_by`, `fixed_day_activity_id`) VALUES
(2, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '10:30:00', ' ', 6),
(3, 'Arrival', 'Campus', 'Arrival on campus', '10:45:00', '11:50:00', '', 1),
(4, 'Arrival', 'Campus', 'Arrival on campus', '10:45:00', '11:50:00', '', 6),
(5, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:00:00', '02:15:00', ' ', 1),
(6, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:00:00', '02:15:00', ' ', 6),
(7, 'Eating', 'Breakfast Room 1', 'Breakfast', '09:00:00', '10:30:00', '', 2),
(8, 'Eating', 'Breakfast Room 1', 'Breakfast', '09:00:00', '10:30:00', '', 7),
(9, 'Eating', 'Breakfast Room 1', 'Breakfast', '09:00:00', '10:30:00', '', 3),
(10, 'Eating', 'Breakfast Room 1', 'Breakfast', '09:00:00', '10:30:00', '', 8),
(11, 'Eating', 'Breakfast Room 1', 'Breakfast', '09:00:00', '10:30:00', '', 4),
(12, 'Eating', 'Breakfast Room 1', 'Breakfast', '09:00:00', '10:30:00', '', 9),
(13, 'Eating', 'Breakfast Room 1', 'Breakfast', '09:00:00', '10:30:00', '', 5),
(14, 'Eating', 'Breakfast Room 1', 'Breakfast', '09:00:00', '10:30:00', '', 10),
(15, 'Arrival', 'Campus', 'Arrival on campus', '12:00:00', '02:15:00', '', 2),
(16, 'Arrival', 'Campus', 'Arrival on campus', '12:00:00', '02:15:00', '', 7),
(17, 'Lession', 'Hall room 1', 'Lession', '10:45:00', '11:50:00', ' ', 2),
(18, 'Lession', 'Hall room 1', 'Lession', '10:45:00', '11:50:00', ' ', 7),
(36, 'Excursion', 'Canbridge', 'Full day in Canbridge', '12:00:00', '02:15:00', 'Gabriel ', 5),
(20, 'Lession', 'Hall room 1', 'Lession', '12:00:00', '02:15:00', '', 10),
(21, 'Excursion', 'Canbridge', 'Full day in Canbridge', '10:45:00', '11:50:00', ' ', 3),
(22, 'Excursion', 'Canbridge', 'Full day in Canbridge', '10:45:00', '11:50:00', ' ', 8),
(23, 'Excursion', 'Canbridge', 'Full day in Canbridge', '12:00:00', '02:15:00', '', 4),
(24, 'Excursion', 'Canbridge', 'Full day in Canbridge', '12:00:00', '02:15:00', '', 9),
(25, 'Excursion', 'London', 'Full day in london', '12:00:00', '02:15:00', ' ', 3),
(26, 'Excursion', 'London', 'Full day in london', '12:00:00', '02:15:00', ' ', 8),
(27, 'Excursion', 'London', 'Full day in london', '10:45:00', '11:50:00', '', 4),
(28, 'Excursion', 'London', 'Full day in london', '10:45:00', '11:50:00', '', 9),
(29, 'Lession', 'Hall room 1', 'Lession', '10:45:00', '11:50:00', 'updated ', 5),
(30, 'Lession', 'Hall room 1', 'Lession', '10:45:00', '11:50:00', 'updated ', 10),
(31, 'Eating', 'Breakfast Room 1', 'Breakfast', '01:03:00', '04:05:00', ' ', 11),
(32, 'Eating', 'Breakfast Room 1', 'Breakfast', '01:03:00', '04:05:00', '', 13),
(33, 'Lession', 'Hall room 1', 'Lession', '01:03:00', '04:05:00', ' ', 12),
(34, 'Lession', 'Hall room 1', 'Lession', '01:03:00', '04:05:00', '', 14),
(35, 'Eating', 'Breakfast Room 1', 'Breakfast', '01:03:00', '04:05:00', '', 15),
(40, 'Eating', 'Breakfast Room 1', 'Breakfast', '13:05:00', '14:20:00', '', 2),
(41, 'Excursion', 'Canbridge', 'Full day in Canbridge', '15:20:00', '16:55:00', '', 4),
(42, 'Arrival', 'Campus', 'Arrival on campus', '15:20:00', '16:55:00', '', 1),
(43, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', ' ', 30),
(44, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', ' ', 63),
(45, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 31),
(46, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 64),
(47, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 32),
(48, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 65),
(49, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 33),
(50, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 66),
(51, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 34),
(52, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 67),
(53, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 35),
(54, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 68),
(55, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 36),
(56, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 69),
(57, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 37),
(58, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 70),
(59, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 43),
(60, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 76),
(61, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 38),
(62, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 71),
(63, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 41),
(64, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 74),
(65, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 39),
(66, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 72),
(67, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 40),
(68, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 73),
(69, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 42),
(70, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 75),
(71, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 44),
(72, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 77),
(73, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 45),
(74, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 78),
(75, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 46),
(76, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 79),
(77, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 16),
(78, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 49),
(79, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 47),
(80, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 80),
(81, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 17),
(82, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 50),
(83, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 48),
(84, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 81),
(85, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 18),
(86, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 51),
(87, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 22),
(88, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 55),
(89, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 19),
(90, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 52),
(91, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 20),
(92, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 53),
(93, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 21),
(94, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 54),
(95, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 28),
(96, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 61),
(97, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 23),
(98, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 56),
(99, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 27),
(100, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 60),
(101, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 24),
(102, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 57),
(103, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 26),
(104, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 59),
(105, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 25),
(106, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 58),
(107, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 29),
(108, 'Arrival', 'Campus', 'Arrival on campus', '09:00:00', '11:30:00', '', 62),
(109, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', ' ', 30),
(110, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', ' ', 63),
(111, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 33),
(112, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 66),
(113, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 31),
(114, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 64),
(115, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 32),
(116, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 65),
(117, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 36),
(118, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 69),
(119, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 34),
(120, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 67),
(121, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 40),
(122, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 73),
(123, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 38),
(124, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 71),
(125, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 37),
(126, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 70),
(127, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 39),
(128, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 72),
(129, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 35),
(130, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 68),
(131, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 45),
(132, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 78),
(133, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 41),
(134, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 74),
(135, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 42),
(136, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 75),
(137, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 43),
(138, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 76),
(139, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 44),
(140, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 77),
(141, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 46),
(142, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 79),
(143, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 16),
(144, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 49),
(145, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 47),
(146, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 80),
(176, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 3),
(148, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 50),
(149, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 48),
(150, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 81),
(151, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 18),
(152, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 51),
(153, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 19),
(154, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 52),
(155, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 20),
(156, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 53),
(157, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 21),
(158, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 54),
(159, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 22),
(160, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 55),
(161, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 25),
(162, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 58),
(163, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 23),
(164, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 56),
(165, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 24),
(166, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 57),
(167, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 29),
(168, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 62),
(169, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 26),
(170, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 59),
(171, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 27),
(172, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 60),
(173, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 28),
(174, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 61),
(175, 'Eating', 'Breakfast Room 1', 'Breakfast', '12:10:00', '14:45:00', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre`
--

DROP TABLE IF EXISTS `frontweb_junior_centre`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre` (
  `junior_centre_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_id` int(11) DEFAULT NULL,
  `centre_banner` varchar(100) DEFAULT NULL,
  `accommodation` text,
  `course` text,
  `junior_centre_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active & 0:Inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not delete & 1:delete',
  PRIMARY KEY (`junior_centre_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre`
--

INSERT INTO `frontweb_junior_centre` (`junior_centre_id`, `centre_id`, `centre_banner`, `accommodation`, `course`, `junior_centre_status`, `delete_flag`) VALUES
(1, 36, '1513145420.jpeg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(2, 30, '1513146902.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(3, 6, '1513147968.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(4, 46, '1513148870.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(5, 27, '1513149438.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(6, 21, '1513149575.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(7, 3, '1513149681.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(8, 56, '1513149819.jpeg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(9, 20, '1513149928.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(10, 57, '1513150044.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(11, 52, '1513150164.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\n<div class="col-12" style="padding: 10px;">\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\n</div>\n</div>\n<div class="col-12" style="padding: 10px;">\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students....</p>\n</div>\n</div>\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\n<div class="col-12">\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate... </span></li>\n</ul>\n</div>\n</div>\n</div>', 1, 0),
(12, 53, '1513150554.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0);
INSERT INTO `frontweb_junior_centre` (`junior_centre_id`, `centre_id`, `centre_banner`, `accommodation`, `course`, `junior_centre_status`, `delete_flag`) VALUES
(13, 41, '1513150651.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\n<div class="col-12" style="padding: 10px;">\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\n</div>\n</div>\n<div class="col-12" style="padding: 10px;">\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students..</p>\n</div>\n</div>\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\n<div class="col-12">\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate.. </span></li>\n</ul>\n</div>\n</div>\n</div>', 1, 0),
(14, 12, '1513150726.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(15, 47, '1513150836.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(16, 66, '1513153416.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(17, 67, '1513153636.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(18, 38, '1513153764.jpg', '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_activity_program`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_activity_program`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_activity_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_activity_program`
--

INSERT INTO `frontweb_junior_centre_activity_program` (`id`, `file_name`, `file_description`, `junior_centre_id`) VALUES
(1, '1519088434.pdf', 'test now', 14);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_addon`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_addon`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_addon` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_addon`
--

INSERT INTO `frontweb_junior_centre_addon` (`id`, `file_name`, `file_description`, `junior_centre_id`) VALUES
(1, '1513233935.pdf', 'This is for the testing purpose', 3),
(2, '1518083709.pdf', 'test', 11),
(3, '1519088405.pdf', 'test now', 14);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_dates`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_dates`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_dates` (
  `junior_centre_dates_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `date` date DEFAULT NULL,
  `overnight` varchar(255) DEFAULT NULL,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_centre_dates_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_dates`
--

INSERT INTO `frontweb_junior_centre_dates` (`junior_centre_dates_id`, `date`, `overnight`, `junior_centre_id`) VALUES
(1, '2018-06-20', '', 1),
(2, '2018-07-03', '', 1),
(3, '2018-07-17', '', 1),
(4, '2018-07-31', '', 1),
(5, '2018-06-28', '', 2),
(6, '2018-07-03', '', 2),
(7, '2018-07-10', '', 2),
(8, '2018-07-19', '', 2),
(9, '2018-08-01', '', 2),
(10, '2018-06-20', '', 3),
(11, '2018-06-27', '', 3),
(12, '2018-07-04', '', 3),
(13, '2018-07-18', '', 3),
(14, '2018-07-31', '', 3),
(17, '2018-07-03', 'Overnight at the end ', 4),
(18, '2018-07-17', 'Overnight at the end', 4),
(19, '2016-10-04', '', 1),
(20, '2017-12-20', '', 1),
(21, '2018-02-16', '', 1),
(22, '2018-02-20', 'test now', 14);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_dates_program`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_dates_program`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_dates_program` (
  `junior_centre_dates_program_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_id` int(11) DEFAULT NULL,
  `junior_centre_dates_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_centre_dates_program_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_dates_program`
--

INSERT INTO `frontweb_junior_centre_dates_program` (`junior_centre_dates_program_id`, `program_id`, `junior_centre_dates_id`) VALUES
(1, 2, 1),
(2, 2, 2),
(3, 2, 3),
(4, 2, 4),
(5, 5, 5),
(6, 2, 6),
(7, 5, 6),
(8, 5, 7),
(9, 5, 8),
(10, 5, 9),
(11, 1, 10),
(12, 2, 10),
(13, 1, 11),
(14, 2, 11),
(15, 1, 12),
(16, 2, 12),
(17, 1, 13),
(18, 2, 13),
(19, 1, 14),
(20, 2, 14),
(24, 5, 18),
(23, 5, 17),
(25, 2, 19),
(43, 1, 22),
(30, 5, 20),
(29, 2, 20),
(42, 5, 21),
(41, 1, 21);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_dates_week`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_dates_week`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_dates_week` (
  `junior_centre_dates_week_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `week` int(11) DEFAULT NULL,
  `junior_centre_dates_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_centre_dates_week_id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_dates_week`
--

INSERT INTO `frontweb_junior_centre_dates_week` (`junior_centre_dates_week_id`, `week`, `junior_centre_dates_id`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 4, 1),
(4, 2, 2),
(5, 3, 2),
(6, 4, 2),
(7, 2, 3),
(8, 3, 3),
(9, 2, 4),
(10, 2, 5),
(11, 3, 5),
(12, 2, 6),
(13, 3, 6),
(14, 2, 7),
(15, 2, 8),
(16, 2, 9),
(17, 2, 10),
(18, 3, 10),
(19, 4, 10),
(20, 2, 11),
(21, 3, 11),
(22, 4, 11),
(23, 2, 12),
(24, 3, 12),
(25, 4, 12),
(26, 2, 13),
(27, 3, 13),
(28, 4, 13),
(29, 2, 14),
(35, 2, 18),
(34, 3, 17),
(33, 2, 17),
(36, 2, 19),
(40, 3, 20),
(39, 1, 20),
(41, 5, 20),
(54, 3, 21),
(53, 2, 21),
(52, 1, 21),
(55, 1, 22);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_fact_sheet`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_fact_sheet`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_fact_sheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_fact_sheet`
--

INSERT INTO `frontweb_junior_centre_fact_sheet` (`id`, `file_name`, `file_description`, `junior_centre_id`) VALUES
(1, '1518087807.pdf', 'first fact sheet', 11),
(2, '1519088422.pdf', 'test now', 14);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_international_mix`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_international_mix`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_international_mix` (
  `junior_centre_international_mix_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `country_name` varchar(255) DEFAULT NULL,
  `percentage` varchar(200) DEFAULT NULL,
  `color_code` varchar(200) DEFAULT NULL,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_centre_international_mix_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_international_mix`
--

INSERT INTO `frontweb_junior_centre_international_mix` (`junior_centre_international_mix_id`, `country_name`, `percentage`, `color_code`, `junior_centre_id`) VALUES
(1, 'Italy-IT', '50%', 'rgb(255, 0, 0)', 3),
(2, 'France-FR', '15%', 'rgb(109, 104, 172)', 3),
(3, 'Russia-RU', '5%', 'rgb(232, 229, 71)', 3),
(4, 'Bolivia-BO', '12%', 'rgb(159, 229, 245)', 3),
(5, 'Italy-IT', '20%', 'rgb(255, 0, 0)', 1),
(6, 'India-IN', '32.35%', 'rgb(139, 217, 111)', 14);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_menu`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_menu`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_menu`
--

INSERT INTO `frontweb_junior_centre_menu` (`id`, `file_name`, `file_description`, `junior_centre_id`) VALUES
(1, '1519088473.pdf', 'test now', 14);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_old`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_old`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_old` (
  `junior_centre_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_id` int(11) DEFAULT NULL,
  `centre_banner` varchar(100) DEFAULT NULL,
  `centre_description` text,
  `centre_address` text,
  `centre_latitude` varchar(100) DEFAULT NULL,
  `centre_longitude` varchar(100) DEFAULT NULL,
  `junior_centre_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active & 0:Inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not delete & 1:delete',
  PRIMARY KEY (`junior_centre_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_old`
--

INSERT INTO `frontweb_junior_centre_old` (`junior_centre_id`, `centre_id`, `centre_banner`, `centre_description`, `centre_address`, `centre_latitude`, `centre_longitude`, `junior_centre_status`, `delete_flag`) VALUES
(1, 2, '1512127952.jpg', '<p class="MsoNormal" style="font-weight: normal;">\n										<span style="font-weight: bold;">Canterbury</span> is a typical historic English city located in the\n										district of Kent in southeast of England. It is one of the most visited cities\n										in the UK. The city centre is dominated by Canterbury Cathedral - the oldest\n										Cathedral in England. &nbsp;It is an\n										impressive building with plenty of ornate details and stained glass windows.\n										There are also the ancient ruins of St. Augustine’s Abbey, St. Martin’s Church\n										and the Norman Castle and these represent the city’s history, heritage and\n										culture. The city has vibrant leisure attractions including fine restaurants,\n										welcoming pubs and quaint cafes. The city centre is a pedestrianised area with\n										charming black-and-white Victorian houses. There is also a great selection of\n										shops. Canterbury is very close to the beautiful beaches of Whitstable and\n										Herne Bay as well as stunning English countryside.\n									</p>\n\n									<p class="MsoNormal">\n										<span style="font-weight: bold;">Plus </span>hold their summer courses at the\n										University of Kent.&nbsp;<span style="font-weight: normal;">&nbsp;The University\n										is set in 450 acres of parkland and is less than a 25-minute walk\n										from the city centre. It is situated on a hill and has a stunning views of the\n										Cathedral. There are various modern buildings surrounded by green open spaces,\n										fields and forests. The campus is self-contained and includes all the necessary\n										amenities such as bars, shops, a sports centre, a bookshop and bus stops. It is\n										an open campus but very safe and offers 24-hour security. The sports facilities\n										are excellent with multi-purpose halls, squash courts, a climbing wall, playing\n										fields and many others.</span>\n									</p>\n\n									<p class="MsoNormal" style="font-weight: normal;">\n										<span style="font-weight: bold;">Campus Highlights/ Facilities</span>\n									</p>\n									<ul style="font-weight: normal;">\n										<li>\n											<span style="text-indent: -18pt;">- Green open spaces with beautiful views over the city</span>\n										</li>\n										<li>\n											<span style="text-indent: -18pt;">- Outdoor playing fields and an artificial football pitch</span>\n										</li>\n										<li>\n											<span style="text-indent: -18pt;">- Tennis courts</span>\n										</li>\n										<li>\n											<span style="text-indent: -18pt;">- Multi-purpose sports hall</span>\n										</li>\n										<li>\n											<span style="text-indent: -18pt;">- On-site cinema</span>\n										</li>\n										<li>\n											<span style="text-indent: -18pt;">- On-site bus stops</span>\n										</li>\n										<li>\n											<span style="text-indent: -18pt;">- On- site cafes, bars, a gift shop and supermarket</span>\n										</li>\n										<li>\n											<span style="text-indent: -18pt;">- Wi-Fi for students and staff.</span>\n										</li>\n									</ul>', 'canterbury', '51.280233', '1.0789089', 1, 0),
(5, 6, '1512540249.jpg', '<p>test<br></p>', 'test', '51.2775045', '1.0777892', 1, 0),
(2, 20, '1512091004.jpg', ' <div style="">Brighton is located on the south coast of England in East Sussex. It is only an hour away from Central London by train and 30 minutes away from London Gatwick, one of the main international airports in the UK. Brighton offers many attractions: The Royal Pavilion, great museums, a beautiful beach and superb shopping. Its famous seafront seafront and the Pier is full of amusements, rides and charming sea views. Brighton is home to beautiful Regency houses and colourful narrow shopping streets known as the Lanes, which are packed with vintage shops, cafes and restaurants. Nearby, there is the famous South Downs National Park with the dramatic Seven Sisters cliffs and beautiful&nbsp;English villages. It is a culturally vibrant destination&nbsp;that provides many events through&nbsp;the year: art and music festivals, horse races, beach and water-sports festival and many more .&nbsp;</div><div style=""><br></div><div style="">The PLUS centre is brand new with all the teaching, catering, accommodation and student social communal facilities located close together on this one campus. The campus is located about 4 miles to the north of Brighton making it an excellent base for exploring this corner of England on full day trips and local excursions. The town centre of Brighton is easily accessed by bus from a local bus stop or by train from Falmer, which is within walking distance. From this centre you can easily reach places like Eastbourne, Oxford, Cambridge, Arundel, Canterbury and of course central London with its fabulous museums and world class tourist attractions.</div><div style=""><div style="font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal;"><br></div><div style=""><div style=""><span style="font-family: Arial, Verdana; font-size: 12px; font-weight: bold;">Campus Highlights/ Facilities</span></div><div style=""><ul><li>- Green open spaces around the campus for students to relax</li><li>- Easy-access to Brighton city centre- a popular tourist destination</li><li>- Free Wi-Fi for students and group leaders</li><li>- Safe and secure environment</li><li>- Easy-access to the main international airports.</li></ul></div></div></div><br>						', 'brighton', '50.82253', '-0.137163', 1, 0),
(3, 3, '1512091407.jpg', ' <p class="MsoNormal" style="margin-bottom: 0.0001pt; text-align: justify;"><span style="font-weight: bold;">Chelmsford</span> is a city in Essex\r\nin the east of England. It is approximately 50km north east of London and there\r\nis a railway station with direct trains to London Liverpool Street in Central\r\nLondon (35 minutes travel time). Chelmsford is an urban area with a mix of\r\nVictorian and modern buildings and a vibrant city centre with two shopping\r\ncentres and a wide range of restaurants and pubs. Chelmsford is surrounded by many\r\nparks and picturesque English villages. Places to visit include Marsh Farm\r\nAnimal Adventure Park, Tropical Wings Zoo, Chelmsford Cathedral, Shire Hall, Chelmsford\r\nMuseum and many more.</p><p class="MsoNormal" style="margin-bottom: 0.0001pt; text-align: justify;"><span style="font-weight: bold;">The PLUS centre</span> is located at one of the largest agricultural\r\nuniversities in the UK. It is surrounded by its own farm, landscaped gardens\r\nand offers a secure university environment with plenty of open areas for\r\nrecreation. The campus is a self contained with lots of modern teaching, living\r\nand sporting facilities in modern brick buildings. The city centre is easily\r\naccessible from the campus by bus (15 minutes travel time). &nbsp;</p><p class="MsoNormal" style="font-weight: normal; margin-bottom: 0.0001pt; text-align: justify;"><o:p></o:p></p><div style="font-weight: normal;"><br></div><div style="font-weight: normal;"><span style="font-weight: bold;">Campus Highlights/ Facilities</span></div><div style="font-weight: normal;"><ul><li><span style="text-indent: -24px;">- Experience the magnificient British countryside thanks to a picturesque 220 hectare campus, including beautiful landscaped gardens</span></li><li><span style="text-indent: -18pt; text-align: justify;">- Self-contained campus with all facilities within\r\nwalking distance</span></li><li><span style="text-align: justify; text-indent: -18pt;">- Safe and secure environment</span></li><li><span style="text-indent: -18pt;">- Academy centre</span></li><li><span style="text-align: justify; text-indent: -18pt;">- Complimentary Wi-Fi for the students and group\r\nleaders</span></li><li><span style="text-align: justify; text-indent: -18pt;">- Outdoor sports facilities for football,\r\nbasketball, rugby, volleyball and tennis</span></li><li><span style="text-align: justify; text-indent: -18pt;">- Indoor sports hall</span></li><li><span style="text-align: justify; text-indent: -18pt;">- 24 hour CCTV.</span></li></ul></div><br>	', 'chelmsform', '51.7355868', '0.4685497', 1, 0),
(4, 7, '1512437788.jpg', '<p>libverpool edit<br></p>', 'liverpool', '53.4083714', '-2.9915726', 1, 0),
(6, 41, '1512540552.jpg', '<p>test<br></p>', 'chelmsford', '51.7355868', '0.4685497', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_photo_gallery`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_photo_gallery`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_photo_gallery` (
  `junior_centre_photo_gallery_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `short_description` varchar(255) DEFAULT NULL,
  `description` text,
  `photo` varchar(200) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_centre_photo_gallery_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_photo_gallery`
--

INSERT INTO `frontweb_junior_centre_photo_gallery` (`junior_centre_photo_gallery_id`, `short_description`, `description`, `photo`, `sequence`, `junior_centre_id`) VALUES
(1, 'The Campus', 'The Campus', '1513145812.jpeg', 1, 1),
(2, 'Bedroom', 'Bedroom', '1513146220.jpg', 2, 1),
(3, 'Building', 'Building', '1513146270.jpg', 3, 1),
(4, 'Cafeteria', 'Cafeteria', '1513146299.jpg', 4, 1),
(5, 'Bedroom', 'Bedroom', '1513146321.jpg', 5, 1),
(6, 'The Campus', 'The Campus', '1513147231.jpg', 1, 2),
(7, 'The Campus', 'The Campus', '1513147246.jpg', 2, 2),
(8, 'Bedroom', 'Bedroom', '1513147263.jpg', 3, 2),
(9, 'Cafeteria', 'Cafeteria', '1513147280.jpg', 4, 2),
(10, 'The Campus', 'The Campus', '1513148130.jpg', 2, 3),
(11, 'The Campus', 'The Campus', '1513149064.jpg', 1, 4),
(12, 'The Campus', 'The Campus', '1513157158.jpg', 1, 5),
(13, 'The Campus', 'The Campus', '1513157198.jpg', 1, 6),
(14, 'The Campus', 'The Campus', '1513157235.jpg', 1, 7),
(15, 'The Campus', 'The Campus', '1513157254.jpg', 1, 8),
(16, 'The Campus', 'The Campus', '1513157274.jpg', 1, 9),
(17, 'The Campus', 'The Campus', '1513157304.jpg', 1, 10),
(18, 'The Campus', 'The Campus', '1513157328.jpg', 1, 11),
(19, 'The Campus', 'The Campus', '1513157353.jpg', 1, 12),
(20, 'The Campus', 'The Campus', '1513157373.jpg', 1, 13),
(21, 'The Campus', 'The Campus', '1513157388.jpg', 1, 14),
(22, 'The Campus', 'The Campus', '1513157405.jpg', 1, 15),
(23, 'The Campus', 'The Campus', '1513157437.jpg', 1, 16),
(24, 'The Campus', 'The Campus', '1513157457.jpg', 1, 17),
(25, 'The Campus', 'The Campus', '1513157476.jpg', 1, 18),
(26, 'Cafeteria', 'Cafeteria', '1513158210.jpg', 3, 3),
(27, 'The Campus', 'The Campus', '1513161754.jpg', 1, 3),
(28, 'Class Room', 'Class Room', '1513161927.jpg', 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_program`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_program`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_program` (
  `junior_centre_program_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_id` int(11) DEFAULT NULL,
  `program_details` text,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_centre_program_id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_program`
--

INSERT INTO `frontweb_junior_centre_program` (`junior_centre_program_id`, `program_id`, `program_details`, `junior_centre_id`) VALUES
(35, 2, 'A 2-week programme includes:<ul style="font-size: 12px;"><li><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">- 1 Full Day Excursion&nbsp;to Belfast</span></li></ul><ul style="font-size: 12px;"><li><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">- 1 Full Day Excursion&nbsp;to Powerscourt Gardens (entry ticket included), Bray and Howth</span></li></ul><ul style="font-size: 12px;"><li><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">-&nbsp;1 Full Day Excursion&nbsp;to Dublin</span></li></ul><ul style="font-size: 12px;"><li><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">- 3 Half Day Excursions&nbsp;to&nbsp;Dublin &amp; Book of Kells (entry ticket included)</span></li></ul><ul style="font-size: 12px;"><li><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">- 1 Half Day Excursion&nbsp;to Malahide Castle (entry ticket included).</span></li></ul><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">A&nbsp;3-week package includes:&nbsp;</span><ul style="font-size: 12px;"><li><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">- 1 Full Day Excursion&nbsp;to Belfast</span></li></ul><ul style="font-size: 12px;"><li><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">- 1 Full Day Excursion&nbsp;to Powerscourt Gardens (entry ticket included), Bray and Howth</span></li></ul><ul style="font-size: 12px;"><li><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">-&nbsp;1 Full Day Excursion&nbsp;to Dublin</span></li></ul><ul style="font-size: 12px;"><li><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">-&nbsp;1 Full Day Excursion&nbsp;to Kilkenny Castle (entry ticket included)</span></li></ul><ul style="font-size: 12px;"><li><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">- 3 Half Day Excursions&nbsp;to Dublin &amp; Book of Kells (entry ticket included)</span></li></ul><ul style="font-size: 12px;"><li><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">- 1 Half Day Excursion&nbsp;to Howth &amp; Malahide.</span></li></ul><span style="font-size: small; font-family: Tahoma;" trebuchet="" ms";="" font-size:="" small;"="">*All excursions include a walking tour and transport is provided by a&nbsp;<span style="text-decoration-line: underline;">Private Coach</span>&nbsp;and escorted by PLUS staff.&nbsp;</span>\n', 1),
(69, 6, '													A 2-week programme includes: <br>\n<ul style="font-weight: normal;"><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to San Diego visiting: La Jolla Beach, Mission Beach, Old Town and Gas Lamp District</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting: Beverly Hills, Rodeo Drive, Hollywood Bus Tour with dinner at Hard Rock Cafe</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> Los Angeles visiting: The Getty Museum, Venice Beach, Santa Monica</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting: California Science Centre, LA Farmer''s Market & The Grove, Huntington Beach</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Malibu and Santa Barbara</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting Griffith Observatory, Downtown Los Angeles Bus Tour (Olvera Street, Union Station, pictures outside the Walt Disney Concert Hall and Staples Centre).</li></ul>\nIn addition, a 3-week programme includes:\n<br><ul style="font-weight: normal;"><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Pasadena, Universal CityWalk. Optional excursion to Norton Simon Museum.</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to UCLA, Manhattan Beach, Roundhouse Aquarium</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to  LACMA, Melrose Avenue. </li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Six Flags</li><li><span style="font-weight: bold;">- 1 Half Day Excursion:</span> Shopping at outlets.</li></ul>												', 2),
(40, 5, '<div style="font-weight: normal;">A 2-week programme includes:&nbsp;</div><div><ul><li><span style="font-weight: bold;">A Weekend away</span> in Orlando/Miami (3 days/2 nights)</li><li>- A choice of Universal Studios or Universal''s Islands of Adventure</li><li>- NASA Kennedy Space Centre</li></ul><ul><li>- <span style="font-weight: bold;">1 Full Day Excursion</span> to Miami visiting: South Beach, Art Deco District and Lincoln Road Mall, Miami Duck Tour</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Full Day Excursion</span> to Miami visiting: Miami Metromover, Perez Art Museum, Wynwood Walls, Bayside Marketplace and Hard Rock Cafe. Optional visit to take pictures of American Airlines and Miami Freedom Tower.&nbsp;</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Full Day Excursion</span> to Miami visiting: Key Biscayne and Miami Seaquarium</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Full Day Excursion</span> to Everglades including an Air Boat Tour, Alligator Farm and Dolphin Mall</li><li>-&nbsp;<span style="font-weight: bold;">1 Full Day Excursion</span>&nbsp;to Miami visiting:&nbsp;Boca Raton, Mizner Park (optional visit to Boca Raton Museum of Art), Red Reef Park (optional visit to Gumbo Limbo Nature Centre), Fort Lauderdale shopping and beach</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Half Day Excursion</span> to Miami visiting: Hollywood, Florida Beach and Boardwalk</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Half Day Excursion</span> to Miami: Aventura Mall (by shuttle)</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Half Day Excursion</span> to Miami visiting: South Beach by night</li></ul></div><div style="font-weight: normal;">In addition, a 3-week programme includes:</div><div><ul><li>- <span style="font-weight: bold;">1 Full Day Excursion</span> with Island Queen Cruise and Sawgrass Mills</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Full Day Excursion</span> to West Palm Beach</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Half Day Excursion</span> to Vizcaya Museum and Gardens</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Half Day Excursion</span> to Coral Gables Walking Tour and Shopping</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Half Day Excursion</span> to the University of Miami and Lowe Art Museum.</li></ul></div><div style="font-weight: normal;">* All overnight excursions include half board with breakfast and dinner provided.</div><div style="font-weight: normal;">* All excursions are organised by private coach and supervised by PLUS USA staff.</div>', 4),
(41, 5, '<div style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;">A 2-week Programme includes:</div><div style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;"><span style="font-weight: bold;">A Weekend away to Washington DC</span> visiting<span style="font-weight: bold;">:</span>&nbsp;</div><div style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;"><ul><li style="font-weight: normal;"><span style="font-weight: normal;">-&nbsp;</span>The National&nbsp;Museum of&nbsp;American History, Monuments and memorial tour</li><li style="font-weight: normal;"><span style="font-weight: normal;">    -</span>&nbsp;Photo opportunities at:The White House, US Capitol, Supreme Court and Library of Congress; visit the National Air and Space Museum.</li><li style="font-weight: normal;"><span style="font-weight: normal;">    - </span><span style="font-weight: bold;">1</span><span style="font-weight: normal;">&nbsp;</span><span style="font-weight: bold;">Full Day Excursion</span> to New York visiting: Central Park &amp; Strawberry Fields, Metropolitan Museum</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Full Day Excursion</span> to New York visiting: Public Library, Grand Central Terminal, Top of the Rock and Rockefeller Plaza, shopping on 5th Avenue</li><li style="font-weight: normal;"><span style="font-weight: normal;">    - </span><span style="font-weight: bold;">1</span><span style="font-weight: normal;">&nbsp;</span><span style="font-weight: bold;">Full Day Excursion</span> to New York visiting: Statue of Liberty and Ellis Island</li><li style="font-weight: normal;">-&nbsp;<span style="font-weight: bold;">1</span>&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to New York with a walking tour of Downtown NY: Wall Street, Brooklyn Bridge, Battery Park, 9/11 Memorial, World Trade Centre Oculus. Optional Excursion to the Freedom Tower or National Museum of the American Indian.</li><li style="font-weight: normal;"><span style="font-weight: normal;">-&nbsp;</span><span style="font-weight: bold;">1</span>&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to New York visiting: A walking tour of Greenwich Village, Chelsea District and Midtown Manhattan, The High Line, Herald Square, Chelsea Market, Penn Station, Madison Square Garden. Optional visit to SoHo.&nbsp;</li><li><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Full Day Excursion</span> to New York visiting a Broadway Show, Times Square, Hard Rock Cafe</li><li>-&nbsp;<span style="font-weight: bold;">1 Full Day Excursion</span>&nbsp;to New York visiting: Coney Island Beach and Broadwalk (optional visit to the Coney Island Amusement Centre and Aquarium)</li><li style="font-weight: normal;">-&nbsp;<span style="font-weight: bold;">1&nbsp;Half&nbsp;Day Excursion</span>&nbsp;to Princeton visiting: Princeton University and The Freedom Place</li><li style="font-weight: normal;">-&nbsp;<span style="font-weight: bold;">1&nbsp;Half&nbsp;Day Excursion</span>&nbsp;to Philadelphia visiting: National Constitution Centre and Liberty Bell.</li></ul></div><div style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;">In addition, a 3-week Programme includes:</div><div style=""><ul style=""><li style=""><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Ocean City Beach and Boardwalk</li><li style=""><span style="font-weight: bold;">-</span><span style="font-weight: normal;"> </span><span style="font-weight: bold;">1 Full Day Excursion</span> to Six Flags</li><li style=""><span style="font-weight: bold;">- 1 Full Day Excursion</span><span style="font-weight: normal;"> to New York visiting: Empire State Building (entrance fee included), Chinatown, Little Italy and SoHo</span></li><li style=""><span style="font-weight: bold;">- 1 Full Day Excursion</span><span style="font-weight: normal;"> to Philadelphia visiting: Philadelphia Museum of Art and Centre City</span></li><li style=""><span style="font-weight: bold;">- 1 Half Day Excursion</span><span style="font-weight: normal;"> to Delware River Tubing&nbsp;</span></li><li style=""><span style="font-weight: bold;">- 1 Half Day Excursion</span><span style="font-weight: normal;"> to The King of Prussia Mall</span></li></ul></div><div style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;">* All overnight excursions include half board with breakfast and dinner provided.&nbsp;</div><div style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;">* All excursions are organised by private coach and supervised by PLUS USA staff.</div>', 5),
(42, 1, 'A 2- week programme includes:<br><ul style="font-weight: normal;"><li>&nbsp; &nbsp; -<span style="font-weight: bold;"> 4&nbsp;Full Day Visits</span> to Edinburgh (travelcards and an entry ticket to the Edinburgh Castle included)</li><li style="font-weight: normal;">&nbsp; &nbsp; - <span style="font-weight: bold;">1 Full Day Excursion</span><span style="font-weight: normal;"> to St. Andrews and Glamis Castle (entry ticket to the castle included)&nbsp;</span></li><li style="font-weight: normal;"><span style="font-weight: normal;">&nbsp; &nbsp; - <span style="font-weight: bold;">1 Full Day</span> </span><span style="font-weight: bold;">Excursion</span> to Glasgow.</li></ul>A 3- week programme includes:<br><ul style="font-weight: normal;"><li>-<span style="font-weight: bold;">&nbsp;4&nbsp;Full Day Visits</span>&nbsp;to Edinburgh (travelcards and an entry ticket to the Edinburgh Castle included)</li><li>-&nbsp;<span style="font-weight: bold;">1 Full Day Excursion</span>&nbsp;to St. Andrews and Glamis Castle (entry ticket to the castle included)</li><li>-&nbsp;<span style="font-weight: bold;">1 Full Day</span>&nbsp;<span style="font-weight: bold;">Excursion</span>&nbsp;to Glasgow</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Stirling.</li></ul>All excursions include a walking tour* and are organised by <span style="font-weight: bold;">Private Coach</span> and escorted by PLUS staff. ', 6),
(43, 1, '<div style="font-weight: normal;">A 2-week programme includes:&nbsp;</div><div><ul><li style="font-weight: normal;"><span style="font-weight: bold;">- 4 Full Day Excursions<span style="font-weight: normal;">&nbsp;to London (travelcards included)</span></span></li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Brighton</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li></ul><div style="font-weight: normal;">A 3-week programme includes:</div><ul><li style="font-weight: normal;"><span style="font-weight: bold;">- 6 Full Day Excursions<span style="font-weight: normal;">&nbsp;to London (travelcards included)</span></span></li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Brighton</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Oxford</li></ul></div>', 7),
(45, 1, '<div>A 2-week programme includes:<br><ul><li>-&nbsp;<span style="font-weight: bold;">5 Full Day Excursions</span>&nbsp;to London (travelcards and entry tickets to London Eye, River Cruise, Shakespeare''s Globe and a meal at Planet Hollywood or Hard Rock Café included) &nbsp;</li><li>- 1&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to Oxford</li><li>- 1&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to Brighton.</li></ul>A 3-week programme includes:<br><ul><li>- 7<span style="font-weight: bold;">&nbsp;Full Day Excursions</span>&nbsp;to London (travelcards and entry tickets to London Eye, River Cruise, Shakespeare''s Globe and a meal at Planet Hollywood or Hard Rock Café included)&nbsp;&nbsp;</li><li>- 1&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to Oxford</li><li>- 1&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to Brighton</li><li>- 1&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to Cambridge.</li></ul><div>*All excursions include a walking tour and transport is provided by&nbsp;<span style="font-weight: bold; text-decoration: underline;">Private Coach</span>&nbsp;and escorted by PLUS staff.</div></div>', 8),
(46, 2, '<span style="font-weight: normal;">A 2-week programme includes:&nbsp;<ul><li>- 1&nbsp;<span style="font-weight: bold;">Full Day Excursion</span> to Manchester</li><li>- 1&nbsp;<span style="font-weight: bold;">Full Day Excursion</span> to York (entry tickets to York Minister included)</li><li>- 1&nbsp;<span style="font-weight: bold;">Full Day Excursion</span> to Wales (entry ticket to Caernarfon Castle included)</li><li>-<span style="font-weight: bold;">&nbsp;1 Full Day Excursion</span> to Liverpool.</li></ul></span>A 3-week progrmme includes:<div><ul style="font-weight: normal;"><li>- 1&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to Manchester</li><li>- 1&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to York (entry tickets to York Minister included)</li><li>- 1&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to Wales (entry ticket to Caernarfon Castle included)</li><li>-<span style="font-weight: bold;">&nbsp;1 Full Day Excursion</span>&nbsp;to Liverpool</li><li>-&nbsp;&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to Stratford-Upon-Avon.</li></ul><div style="font-weight: normal;">*All excursions include a walking tour and transport is provided by Private Coach and escorted by PLUS staff.&nbsp;</div></div>', 9),
(47, 2, '<div style="font-weight: normal;">A 2-week programme includes:</div><div style=""><ul style=""><li style="font-weight: normal;">- <span style="font-weight: bold;">2&nbsp;Full Day Excursions</span> to Edinburgh (entry ticket to Edinburgh Castle included)</li><li style="font-weight: normal;"><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Full Day Excursion</span> to Glasgow</li><li style="font-weight: normal;"><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1 Full Day Excursion</span> to St Andrews and Glamis Castle (entry ticket to the castle included)</li><li style=""><span style="font-weight: bold;">- 1 Half Day Excursion</span><span style="font-weight: normal;"> to Stirling</span></li></ul><div style="font-weight: normal;">A 3-week programme includes:</div><div style=""><ul style=""><li style="font-weight: normal;"><span style="font-weight: normal;">- </span><span style="font-weight: bold;">2&nbsp;Full Day Excursions</span>&nbsp;to Edinburgh (entry ticket to Edinburgh Castle included)</li><li style="font-weight: normal;">-&nbsp;<span style="font-weight: bold;">1 Full Day Excursion</span>&nbsp;to Glasgow</li><li style="font-weight: normal;">-&nbsp;<span style="font-weight: bold;">1 Full Day Excursion</span>&nbsp;to St Andrews and Glamis Castle (entry ticket to the castle included)</li><li style="font-weight: normal;">-&nbsp;<span style="font-weight: bold;">1 Full Day Excursion</span>&nbsp;to Loch Lomond and The Trossachs National Park</li><li style=""><span style="font-weight: bold;">- 1 Half Day Excursion</span>&nbsp;to Stirling</li></ul></div>*All excursions include a walking tour* and transport is provided by Private Coach and escorted by PLUS staff.&nbsp;</div>', 10),
(70, 3, '													A 2-week programme includes: <br><ul style="font-weight: normal;"><li><span style="font-weight: bold;">- 2 Full Day Excursions </span>to London</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Oxford</li><li><span style="font-weight: bold;">- 1 Full Day Excursion </span>to Portsmouth.</li></ul><div style="font-weight: normal;">A 3-week programme includes:</div><div style="font-weight: normal;"><ul><li><span style="font-weight: bold;">- 2 Full Day Excursions </span>to London</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Oxford</li><li><span style="font-weight: bold;">- 1 Full Day Excursion </span>to Portsmouth</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Brighton.</li></ul><div>*All excursions include a walking tour and transport is provided by<span style="text-decoration: underline;"><span style="font-weight: bold;"> Private Coach</span></span> and escorted by PLUS staff.</div></div>												', 11),
(49, 3, 'A 2-week programme includes: <br><ul style=""><li style="">-<span style="font-weight: bold;"> 1&nbsp;Full Day Excursion</span> to London</li><li style=""><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1</span>&nbsp;<span style="font-weight: bold;">Full Day Excursion</span> to Oxford</li><li style=""><span style="font-weight: normal;">-</span><span style="font-weight: bold;"> 1</span>&nbsp;<span style="font-weight: bold;">Half&nbsp;Day Excursion</span>&nbsp;to Windsor (entry ticket to Windsor Castle included).</li></ul>A 3-week programme includes:<br><ul style=""><li style="">- <span style="font-weight: bold;">2</span>&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to London</li><li style=""><span style="font-weight: normal;">- </span><span style="font-weight: bold;">1</span>&nbsp;<span style="font-weight: bold;">Full Day Excursion</span>&nbsp;to Oxford</li><li>-<span style="font-weight: bold;">&nbsp;1</span>&nbsp;<span style="font-weight: bold;">Half&nbsp;Day Excursion</span>&nbsp;to Windsor (entry ticket to Windsor Castle included).</li></ul><div style="font-weight: normal;">*All excursions include a walking tour and transport is provided by&nbsp;<span style="font-weight: bold; text-decoration: underline;">Private Coach</span>&nbsp;and escorted by PLUS staff.&nbsp;</div>', 12),
(71, 4, '													A 2-week programme includes:\n<br><ul style="font-weight: normal;"><li><span style="font-weight: bold;">- 2 Full Day Excursions</span> to London (late return; River Cruise included)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Cambridge.</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Canterbury</li><li><span style="font-weight: bold;">- 1 Half Day Excursion</span> to Chelmsford.</li></ul>A  3-week programme includes:<div style="font-weight: normal;"><ul><li><span style="font-weight: bold;">- 2 Full Day Excursions</span> to London (late return; River Cruise included)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Cambridge.</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Canterbury</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Rochester and Whitstable</li><li><span style="font-weight: bold;">- 1 Half Day Excursion</span> to Chelmsford.</li></ul><div><div>*All excursions include a walking tour* and transport is provided by <span style="text-decoration: underline;"><span style="font-weight: bold;">Private Coach</span></span> and escorted by PLUS staff. </div></div></div>												', 13),
(51, 4, '<div style="font-weight: normal;">A 2-week programme includes:&nbsp;</div><div style=""><ul style=""><li style=""><span style="font-weight: bold;">- A weekend in London </span>(2 days, 1 night; River Cruise and a meal at Planet Hollywood or Hard Rock Café included, transfers to/from London to accommodation by private coach)</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion&nbsp;</span>to Manchester</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to York.</li></ul><div style="font-weight: normal;">A 3-week programme includes:&nbsp;</div></div><div style="font-weight: normal;"><ul><li><span style="font-weight: bold;">- A weekend in London&nbsp;</span>(2 days, 1 night; River Cruise and a meal at Planet Hollywood or Hard Rock Café&nbsp;included, transfers to/from London to accommodation by private coach)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion&nbsp;</span>to Manchester</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to York</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge.</li></ul><div><br></div></div><div style="font-weight: normal;">*All excursions include a walking tour and transport is provided by<span style="text-decoration: underline;"><span style="font-weight: bold;">&nbsp;Private Coach</span></span>&nbsp;and escorted by PLUS staff.&nbsp;</div>', 14),
(53, 7, '<p class="p2" style="font-weight: normal;">A 2-week programme includes:</p><ul style="font-weight: normal;"><li><span style="font-weight: bold;">- A weekend</span>&nbsp;in London (3 days 2 nights)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Manchester</li><li><span style="font-weight: bold;">- 5 Half Day Excursions</span> to Liverpool City Centre (travelcards included).</li></ul><div style="font-weight: normal;">A 3-week programme includes:</div><div style="font-weight: normal;"><ul><li><span style="font-weight: bold;">- A weekend</span>&nbsp;in London (3 days 2 nights)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Manchester</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to York</li><li><span style="font-weight: bold;">- 7 Half Day Excursions</span>&nbsp;to Liverpool City Centre (travelcards included).</li></ul><div>*All excursions include a walking tour and transport is provided by Private Coach and escorted by PLUS staff.</div></div>', 15),
(54, 5, '<p><span style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px;">A 2-week programme includes:&nbsp;</span><br><ul style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;"><li style=""><span style="font-weight: bold;">A weekend away</span>&nbsp;to either Niagara Falls or Boston (both 2 days/1 nights).</li></ul><span style="font-weight: bold; font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;">Niagara Falls</span><br><ul style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;"><li>- Niagara Falls by Night, Hard Rock Cafe</li><li>- Maid of the Mist boat tour, Woodbury Common Outlets</li></ul><span style="font-weight: bold; font-family: Arial, Verdana; font-size: 12px;">Boston</span><br><ul style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;"><li>- Whale Watching, Faneuil Hall and Quincy Market</li><li>- Bunker Hill Monument, including a walking tour of the historic Freedom Trail, Boston Common, Boston Public Garden</li><li>- Harvard University and Cambridge, Shopping at Tanger Outlets</li></ul><span style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px;"><br><ul style="font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal;"><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to New York visiting: Top of the Rock and the Rockefeller Plaza, Times Square dinner at Hard Rock Cafe (optional tour of Grand Central Terminal)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to New York visiting: Lincoln Centre, Columbus Circle, Central Park, Strawberry Fields and &nbsp;Metropolitan Museum</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to New York with a walking tour of Greenwich Village &amp; SoHo, Chelsea District and Midtown Manhattan: High Line, Chelsea Market, Penn Station, Madison Square Garden, Herald Square, HBO Film Festival in Bryant Park (optional tour to Union Square and Flatiron Building)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to New York visiting: Fifth Avenue, Museum of Modern Art (MoMa)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to New York visiting: Statue of Liberty and Ellis Island, a walking tour of Downtown New York: Battery Park, Wall Street, 9/11 Memorial, World Trade Centre Oculus (optional visit to the Freedom Tower or National Museum of the American Indian)</li><li><span style="font-weight: bold;">- 1 Half Day Excursion</span>&nbsp;to New York visiting: Brooklyn Bridge, Chinatown, Little Italy</li><li><span style="font-weight: bold;">- 1 Half Day Excursion</span>&nbsp;to New York visiting Coney Island Beach, Boardwalk and Baseball Game (optional excursion to Coney Island Amusement Park and New York Aquarium).&nbsp;</li></ul></span><span style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px;">In addition, a 3-week programme includes:</span><span style="font-family: Arial, Verdana; font-size: 12px;"><ul style=""><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Brooklyn: Brooklyn Botanic Garden, Williamsburg</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Six Flags</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Half Day Excursion</span>&nbsp;to Bronx Zoo</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Half Day Excursion</span>&nbsp;to Midtown East, Greenacre Park, Empire State Building</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Half Day Excursion</span>&nbsp;to Upper East Side and the Guggenheim</li><li style=""><span style="font-weight: bold;">- 1 Half Day Excursion</span> to the Met Cloisters and Columbia.</li></ul></span><span style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px;">* All overnight excursions include half board with breakfast and dinner provided.&nbsp;</span></p><p><span style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px;">* All excursions are organised by private coach and supervised by PLUS USA staff.</span></p>', 16),
(56, 1, '<div style="font-weight: normal;">A 2-week programme includes:&nbsp;</div><ul style=""><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to London</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li><li style="">-&nbsp;<b>5 Half Day Excursions&nbsp;</b>to Brighton (travelcards included)</li></ul>A 3-week programme includes:<br><ul style=""><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to London</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Portsmouth</li><li>-&nbsp;<b>5 Half Day Excursions&nbsp;</b>to Brighton (travelcards included)</li></ul>', 17),
(58, 1, '<span style="text-decoration: underline;">PROGRAMME HOTEL: CLASSIC&nbsp;&nbsp;</span><br><ul><li>- Accommodation is available in a 4 Star Hotel (half board with breakfast and dinner included)&nbsp;<br></li><li>- 15 hours of General English lessons per week<br></li><li>- Private transfer to the school</li><li>- Transfers to/from the airport</li></ul><span style="text-decoration: underline;">PROGRAMME HOMESTAY: CLASSIC&nbsp;&nbsp;</span><br><ul><li>- Family Accommodation (full board with packed lunch included);&nbsp; <br></li><li>- 15 hours of General English lessons per week;<br></li><li>- Transfers to the school</li><li>- Transfers to/from the airport</li><li>- 4 transfer to a beach per week</li><li>- One disco per week with transfers included&nbsp; &nbsp;</li></ul>', 18),
(62, 1, '													<div style="font-weight: normal;">A 2-week programme includes:&nbsp;</div><ul><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursions</span>&nbsp;to London (River Cruise included)</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li><li>- <span style="font-weight: bold;">1 Half Day Excursion</span> to Whitsable.</li></ul>\n<div style="font-weight: normal;">A&nbsp;&nbsp;3-week programme includes:</div><div><ul><li style="font-weight: normal;"><span style="font-weight: bold;">- 2 Full Day Excursions</span>&nbsp;to London (River Cruise included)</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge.</li><li>- <span style="font-weight: bold;">1 Half Day Excursions</span> to Whitstable.</li></ul></div>												', 3),
(63, 2, '																										<div>A 2-week programme includes: </div>\n<ul><li><span style="font-weight: bold;">- 2 Full Day Excursions</span> to London (River Cruise included)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Cambridge</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Leeds Castle (entry ticket included) and White Cliffs</li><li><span style="font-weight: bold;">- 1 Half Day Excursion</span> to Whitstable</li><li><span style="font-weight: bold;">- 1 Half Day Excursion</span> to Rochester.</li></ul>\n<div>In addition, a 3-week programme includes:</div>\n<div><ul><li><span style="font-weight: bold;">- 3 Full Day Excursions</span> to London (River Cruise included)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Cambridge</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Leeds Castle (entry ticket included)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Brighton</li><li><span style="font-weight: bold;">- 1 Half Day Excursion</span> to Whitstable</li><li><span style="font-weight: bold;">- 1 Half Day Excursion</span> to Rochester.</li></ul></div>\n<div style="font-weight: normal;">*All excursions include a walking tour* and transport is provided by <span style="text-decoration: underline;"><span style="font-weight: bold;">Private Coach</span></span> and escorted by PLUS staff. <br></div>																								', 3),
(68, 5, '													<div>A 2-week programme includes:<br><ul style="font-weight: normal;"><li><span style="font-weight: bold;">A weekend away</span> in Las Vegas & Grand Canyon (4 days/3 nights):</li><li>- A visit to Hoover Dam, Las Vegas Strip, dinner at Hard Rock Cafe and Fremont Street LED Experience and an optional limo tour of Las Vegas </li><li>- A visit to Grand Canyon and an overnight in Arizona</li><li>- A visit to Calico Ghost Town</li><li>- Shopping at outlets</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to San Diego visiting: La Jolla Beach, Mission Beach, Old Town and Gas Lamp District</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting: Beverly Hills, Rodeo Drive, Hollywood Bus Tour with dinner at Hard Rock Cafe</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> Los Angeles visiting: The Getty Museum, Venice Beach, Santa Monica</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting: California Science Centre,  LA Farmer''s Market & The Grove, Huntington Beach</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Malibu and Santa Barbara</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting Griffith Observatory, Downtown Los Angeles Bus Tour (Olvera Street, Union Station, pictures outside the Walt Disney Concert Hall and Staples Centre).</li></ul>In addition, a 3-week programme includes: <br><ul style="font-weight: normal;"><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Pasadena, Universal CityWalk. Optional excursion to Norton Simon Museum.</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to UCLA, Manhattan Beach, Roundhouse Aquarium</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to LACMA, Melrose Avenue.  </li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Six Flags</li><li><span style="font-weight: bold;">- 1 Half Day Excursion:</span> Shopping at Outlets.</li></ul>* All overnight excursions include half board with breakfast and dinner provided.</div><div>* All excursions are organised by private coach and supervised by PLUS USA staff.</div>												', 2),
(44, 2, 'A 2-week programme includes:\n<br><ul><li style="font-weight: normal;"><span style="font-weight: bold;">- 5 Full Day Excursions<span style="font-weight: normal;">&nbsp;to London&nbsp; (travelcards, entry tickets to London Eye, River Cruise, Shakespeare''s Globe and a meal at Planet Hollywood or Hard Rock Café included)</span></span></li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Brighton</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Cambridge</li></ul>A 3-week programme includes:\n<br><ul style="font-weight: normal;"><li style="font-weight: normal;"><span style="font-weight: bold;">- 7 Full Day Excursions<span style="font-weight: normal;">&nbsp;to London&nbsp;</span></span>(travelcards, entry tickets to London Eye, River Cruise and Shakespeare''s Globe and a meal at Planet Hollywood or Hard Rock Café included)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Brighton</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Oxford</li></ul><div style="font-weight: normal;">*All excursions include a walking tour and transport is provided by&nbsp;<span style="font-weight: bold;"><span style="text-decoration: underline;">Private Coach</span></span>&nbsp;and escorted by PLUS staff.&nbsp;</div>', 7),
(52, 7, '.', 14),
(55, 6, '<span style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px;">A 2-week programme includes:&nbsp;</span><br><ul style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;"><li style="font-weight: normal;">- <span style="font-weight: bold;">1 Full Day Excursion</span>&nbsp;to New York visiting: Top of the Rock and the Rockefeller Plaza, Times Square&nbsp;dinner at Hard Rock Cafe (optional tour of Grand Central Terminal)</li><li style=""><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to New York visiting: Lincoln Centre, Columbus Circle, Central Park, Strawberry Fields and &nbsp;Metropolitan Museum</li><li style=""><span style="font-weight: bold;">- 1 Full Day Excursion</span><span style="font-weight: normal;">&nbsp;to New York with a walking tour of Greenwich Village &amp; SoHo, Chelsea District and Midtown Manhattan: High Line, Chelsea Market, Penn Station, Madison Square Garden, Herald Square, HBO Film Festival in Bryant Park (optional tour to Union Square and Flatiron Building)</span></li><li style=""><span style="font-weight: bold;">- 1 Full Day Excursion</span><span style="font-weight: normal;">&nbsp;to New York visiting: Fifth Avenue, Museum of Modern Art (MoMa)</span></li><li style=""><span style="font-weight: bold;">- 1 Full Day Excursion</span><span style="font-weight: normal;">&nbsp;to New York visiting: Statue of Liberty and Ellis Island, a walking tour of Downtown New York: Battery Park, Wall Street, 9/11 Memorial, World Trade Centre Oculus (optional visit to the Freedom Tower or National Museum of the American Indian)</span></li><li style=""><span style="font-weight: bold;">- 1 Half Day Excursion</span><span style="font-weight: normal;">&nbsp;to New York visiting: Brooklyn Bridge, Chinatown, Little Italy</span></li><li style=""><span style="font-weight: bold;">- 1 Half Day Excursion</span><span style="font-weight: normal;">&nbsp;to New York visiting Coney Island Beach, Boardwalk and Baseball Game (optional excursion to Coney Island Amusement Park and New York Aquarium).&nbsp;</span></li><li style=""><span style="font-weight: bold;">- 1 Half Day Excursion</span><span style="font-weight: normal;"> to Woodbury Common Outlets.</span></li></ul><span style="font-weight: normal; font-family: Arial, Verdana; font-size: 12px;">In addition, a 3-week programme includes:</span><ul style="font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;"><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span><span style="font-weight: normal;">&nbsp;to Brooklyn: Brooklyn Botanic Garden, Williamsburg</span></li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span><span style="font-weight: normal;">&nbsp;to Six Flags</span></li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Half Day Excursion</span><span style="font-weight: normal;">&nbsp;to Bronx Zoo</span></li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Half Day Excursion</span><span style="font-weight: normal;">&nbsp;to Midtown East, Greenacre Park, Empire State Building</span></li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Half Day Excursion</span><span style="font-weight: normal;">&nbsp;to Upper East Side and the Guggenheim.</span></li><li style=""><span style="font-weight: bold;">- 1 Half Day Excursion</span><span style="font-weight: normal;"> to the Met Cloisters and Columbia</span></li></ul>', 16),
(57, 2, '<div style="font-weight: normal;">A 2-week programme includes:&nbsp;</div><ul style=""><li style="font-weight: normal;"><span style="font-weight: bold;">- 2 Full Day Excursions</span>&nbsp;to London</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Oxford</li><li style="">- <span style="font-weight: bold;">5 Half Day&nbsp;</span><span style="font-weight: bold;">Excursions</span>&nbsp;to Brighton (travelcards included)&nbsp;</li></ul>A 3-week programme includes: <br><ul style=""><li><span style="font-weight: bold;">- 2 Full Day Excursions</span>&nbsp;to London</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Oxford</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Portsmouth</li><li>-&nbsp;<span style="font-weight: bold;">5 Half Day&nbsp;</span><span style="font-weight: bold;">Excursions</span>&nbsp;to Brighton (travelcards included)&nbsp;</li></ul><div style="font-weight: normal;">*All excursions include a walking tour* and transport for full day trips is provided by&nbsp;<span style="text-decoration-line: underline;"><span style="font-weight: bold;">Private Coach</span></span>&nbsp;and escorted by PLUS staff.&nbsp;</div>', 17),
(59, 2, '<ul><li>- Accommodation:&nbsp;4 Star Hotel; 3 Star Hotel or Homestay&nbsp;&nbsp;</li><li>- 15 hours of General English lessons per week</li><li>- Private transfers to school</li><li>- Transfer to/from the airport</li><li>- La Valletta &amp; Golden Bay</li><li>- Ghajn Tuffieha</li><li>- Sliema</li><li>- Comino Island</li><li>- 2 Disco Nights</li><li>- 1 Beach Game</li><li>- 1 Evening in the City Centre</li><li>- 1 Beach Party</li><li>- 1 Weekend trip Beach Sunday</li></ul>', 18);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_video_gallery`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_video_gallery`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_video_gallery` (
  `junior_centre_video_gallery_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `video_url` varchar(255) DEFAULT NULL,
  `description` text,
  `video_image` varchar(200) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_centre_video_gallery_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_video_gallery`
--

INSERT INTO `frontweb_junior_centre_video_gallery` (`junior_centre_video_gallery_id`, `video_url`, `description`, `video_image`, `sequence`, `junior_centre_id`) VALUES
(3, 'https://vimeo.com/203452730', 'Location', '1513147389.jpg', 1, 2),
(4, 'https://vimeo.com/203452650', 'Campus', '1513147406.jpg', 2, 2),
(6, 'https://vimeo.com/203452787', 'Campus Location', '1513149099.jpg', 1, 4),
(7, 'https://vimeo.com/203453236', 'Campus Location', '1513157585.jpg', 1, 5),
(8, 'https://vimeo.com/200796379', 'Commercial ', '1513157662.jpg', 1, 7),
(17, 'https://vimeo.com/200796403', 'test description', '1519038000.jpg', 1, 3),
(18, 'https://vimeo.com/200796403', 'test now', '1519088552.jpg', 1, 14),
(12, 'https://vimeo.com/200796403', 'test', '1519034265.jpg', 2, 4),
(14, 'https://vimeo.com/200796403', 'test', '1519035374.jpg', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_centre_walking_tour`
--

DROP TABLE IF EXISTS `frontweb_junior_centre_walking_tour`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_walking_tour` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_centre_walking_tour`
--

INSERT INTO `frontweb_junior_centre_walking_tour` (`id`, `file_name`, `file_description`, `junior_centre_id`) VALUES
(1, '1519088518.pdf', 'test now', 14);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay` (
  `junior_ministay_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_id` int(11) DEFAULT NULL,
  `centre_banner` varchar(200) DEFAULT NULL,
  `accomodation_show_flag` tinyint(1) DEFAULT NULL COMMENT '1:show & 0:not show',
  `plus_team_show_flag` tinyint(1) DEFAULT NULL COMMENT '1:show & 0:not show',
  `course_show_flag` tinyint(1) DEFAULT NULL COMMENT '1:show & 0:not show',
  `accommodation` text,
  `course` text,
  `junior_ministay_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active & 0:Inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not delete & 1:delete',
  PRIMARY KEY (`junior_ministay_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay`
--

INSERT INTO `frontweb_junior_ministay` (`junior_ministay_id`, `centre_id`, `centre_banner`, `accomodation_show_flag`, `plus_team_show_flag`, `course_show_flag`, `accommodation`, `course`, `junior_ministay_status`, `delete_flag`) VALUES
(1, 73, '1513601641.jpg', 1, 1, 1, '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(2, 48, '1513601921.jpg', 1, 1, 1, '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(3, 68, '1513601965.jpg', 1, NULL, 1, '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\n<div class="col-12" style="padding: 10px;">\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\n</div>\n</div>\n<div class="col-12" style="padding: 10px;">\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students....</p>\n</div>\n</div>\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\n<div class="col-12">\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate... </span></li>\n</ul>\n</div>\n</div>\n</div>', 1, 0),
(4, 69, '1513601992.jpg', NULL, NULL, NULL, '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(5, 70, '1513558820.jpeg', NULL, NULL, NULL, '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(6, 6, '1513558862.jpg', NULL, NULL, NULL, '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(7, 71, '1513558894.jpg', NULL, NULL, NULL, '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(8, 53, '1513558916.jpg', NULL, NULL, NULL, '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(9, 72, '1513558937.jpg', NULL, NULL, NULL, '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0),
(10, 57, '1513558965.jpg', NULL, NULL, NULL, '<p class="MsoNormal" style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.</p>\r\n<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">On Campus</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/collegefrontale.jpg?1515412862363" alt="collegefrontale" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Your new home abroad is an important part of your study experience, and we believe that time outside of school will help you learn more effectively in the classroom. We select all our accommodation carefully to ensure that you are comfortable, safe and happy during your stay.Our residences are a really fun, international environment where students from around the world live together and get to use English as the only true way of global communication. The residences are supervised by staff who are on hand to helps students day and night. Each residential centre differs slightly in the room and bathroom type, so please take a look at the programme pages in this brochure. Residential accommodation is popular with parents who are sending younger children or those who want their children to experience the tremendous fun of college life</p>\r\n</div>\r\n</div>\r\n<div class="col-12" style="padding: 10px;">\r\n<h2 class="negativo" style="padding-left: 4px; background-color: #3c7099; padding: 10px 0; color: #fff; border-radius: 4px 4px 4px 4px; font-size: 21px;"><span style="padding-left: 5px;">Home Stay</span></h2>\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/casafamiglia.jpg?1515413045302" alt="casafamiglia" />\r\n<p style="font-weight: normal; margin: 0 0 10px; font-size: 13px; color: #7b7b7b; line-height: 1.6;">Our hosts have been chosen for their interest in welcoming young people from around the world. They are picked because of the care and comfort they can offer to students who may be travelling overseas for the first time. Choosing to stay in home stay is the right option for those who want to experience real life living in that country: it will give a student the opportunity to use English in a real environment and integrate with the family. Home stay is often the first choice for slightly older students.</p>\r\n</div>\r\n</div>\r\n</div>', '<div class="row" style="clear: both; margin-right: -15px; margin-left: -15px;">\r\n<div class="col-12">\r\n<div style="padding: 4px; background-color: #fafafa;"><img style="width: 100%; height: 183px;" src="../../../../uploads/tinymce/2015117-18245511-4544-group-study1.jpg?1515413764611" alt="2015117-18245511-4544-group-study1" /><br />\r\n<ul style="font-weight: normal; margin-top: 10px; margin-bottom: 10px;">\r\n<li><span style="text-indent: -18pt;">- Placement test - written and oral test</span></li>\r\n<li><span style="text-indent: -18pt;">- 15 hours English lessons per week</span></li>\r\n<li><span style="text-indent: -18pt;">- Maximum class size 15 students</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS text book and all supplementary material for the course</span></li>\r\n<li><span style="text-indent: -18pt;">- PLUS end of course certificate </span></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_activity_program`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_activity_program`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_activity_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_ministay_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_activity_program`
--

INSERT INTO `frontweb_junior_ministay_activity_program` (`id`, `file_name`, `file_description`, `junior_ministay_id`) VALUES
(1, '1513769715.pdf', 'test activity program', 1),
(3, '1519088737.pdf', 'test now', 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_addon`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_addon`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_addon` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_ministay_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_addon`
--

INSERT INTO `frontweb_junior_ministay_addon` (`id`, `file_name`, `file_description`, `junior_ministay_id`) VALUES
(1, '1513770435.pdf', 'test addon description', 1),
(3, '1519088707.pdf', 'test now', 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_dates`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_dates`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_dates` (
  `junior_ministay_dates_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `date` date DEFAULT NULL,
  `overnight` varchar(255) DEFAULT NULL,
  `junior_ministay_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_ministay_dates_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_dates`
--

INSERT INTO `frontweb_junior_ministay_dates` (`junior_ministay_dates_id`, `date`, `overnight`, `junior_ministay_id`) VALUES
(1, '2017-12-21', 'test overnight', 1),
(2, '2018-01-01', 'test', 1),
(4, '2016-01-13', '', 1),
(5, '2015-02-16', 'test overnight updated', 1),
(6, '2018-02-20', 'test now', 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_dates_program`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_dates_program`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_dates_program` (
  `junior_ministay_dates_program_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_id` int(11) DEFAULT NULL,
  `junior_ministay_dates_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_ministay_dates_program_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_dates_program`
--

INSERT INTO `frontweb_junior_ministay_dates_program` (`junior_ministay_dates_program_id`, `program_id`, `junior_ministay_dates_id`) VALUES
(1, 4, 1),
(2, 7, 1),
(3, 5, 2),
(4, 6, 2),
(6, 3, 4),
(8, 1, 5),
(9, 5, 5),
(10, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_dates_week`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_dates_week`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_dates_week` (
  `junior_ministay_dates_week_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `week` int(11) DEFAULT NULL,
  `junior_ministay_dates_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_ministay_dates_week_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_dates_week`
--

INSERT INTO `frontweb_junior_ministay_dates_week` (`junior_ministay_dates_week_id`, `week`, `junior_ministay_dates_id`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 4, 1),
(4, 1, 2),
(5, 5, 2),
(7, 2, 4),
(9, 1, 5),
(10, 3, 5),
(11, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_fact_sheet`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_fact_sheet`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_fact_sheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) NOT NULL,
  `file_description` text NOT NULL,
  `junior_ministay_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_fact_sheet`
--

INSERT INTO `frontweb_junior_ministay_fact_sheet` (`id`, `file_name`, `file_description`, `junior_ministay_id`) VALUES
(4, '1513766113.pdf', 'test description', 1),
(3, '1513765348.pdf', 'this description id for london', 2),
(6, '1513832379.pdf', 'fact sheet testing', 1),
(7, '1519088720.pdf', 'test now', 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_international_mix`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_international_mix`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_international_mix` (
  `junior_ministay_international_mix_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `country_name` varchar(255) DEFAULT NULL,
  `percentage` varchar(200) DEFAULT NULL,
  `color_code` varchar(200) DEFAULT NULL,
  `junior_ministay_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_ministay_international_mix_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_international_mix`
--

INSERT INTO `frontweb_junior_ministay_international_mix` (`junior_ministay_international_mix_id`, `country_name`, `percentage`, `color_code`, `junior_ministay_id`) VALUES
(1, 'India-IN', '20.35%', 'rgb(230, 148, 223)', 1),
(2, 'Australia-AU', '10%', 'rgb(172, 202, 137)', 1),
(3, 'India-IN', '20%', 'rgb(163, 145, 145)', 2),
(4, 'India-IN', '20%', 'rgb(209, 171, 90)', 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_menu`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_menu`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_ministay_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_menu`
--

INSERT INTO `frontweb_junior_ministay_menu` (`id`, `file_name`, `file_description`, `junior_ministay_id`) VALUES
(1, '1513771111.pdf', 'new york menu description', 1),
(4, '1519088754.pdf', 'test now', 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_photo_gallery`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_photo_gallery`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_photo_gallery` (
  `junior_ministay_photo_gallery_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `short_description` varchar(255) DEFAULT NULL,
  `description` text,
  `photo` varchar(200) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `junior_ministay_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_ministay_photo_gallery_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_photo_gallery`
--

INSERT INTO `frontweb_junior_ministay_photo_gallery` (`junior_ministay_photo_gallery_id`, `short_description`, `description`, `photo`, `sequence`, `junior_ministay_id`) VALUES
(1, 'test', 'test description', '1513676592.jpg', 1, 1),
(2, 'test one', 'test one description', '1513676618.jpg', 2, 1),
(3, 'test two', 'test two description', '1513676646.jpg', 3, 1),
(4, 'test now', 'test now', '1519088806.jpg', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_program`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_program`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_program` (
  `junior_ministay_program_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_id` int(11) DEFAULT NULL,
  `program_details` text,
  `junior_ministay_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_ministay_program_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_program`
--

INSERT INTO `frontweb_junior_ministay_program` (`junior_ministay_program_id`, `program_id`, `program_details`, `junior_ministay_id`) VALUES
(18, 6, '																										<p>test classic superior<br></p>																								', 1),
(5, 1, '																									', 2),
(13, 1, '													<p>test<br></p>												', 4),
(8, 1, '<p>test<br></p>', 5),
(9, 1, '<p>test<br></p>', 7),
(10, 1, '<p>test<br></p>', 8),
(11, 1, '<p>test<br></p>', 6),
(12, 1, '<p>test<br></p>', 9),
(14, 1, '<p>test<br></p>', 10),
(17, 1, '																																							<div style="font-weight: normal;">A 2-week programme includes: </div><ul><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursions</span> to London (River Cruise included)</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Cambridge</li><li>- <span style="font-weight: bold;">1 Half Day Excursion</span> to Whitsable.</li></ul>\n<div style="font-weight: normal;">A  3-week programme includes:</div><div><ul><li style="font-weight: normal;"><span style="font-weight: bold;">- 2 Full Day Excursions</span> to London (River Cruise included)</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Cambridge.</li><li>- <span style="font-weight: bold;">1 Half Day Excursions</span> to Whitstable.</li></ul></div>																																				', 1),
(22, 1, '																																																				<p>test classic<br></p>																																																', 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_section`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_section`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_section` (
  `junior_ministay_section_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `static_program_id` int(11) DEFAULT NULL,
  `junior_ministay_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_ministay_section_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_section`
--

INSERT INTO `frontweb_junior_ministay_section` (`junior_ministay_section_id`, `static_program_id`, `junior_ministay_id`) VALUES
(4, 2, 2),
(3, 1, 2),
(20, 1, 3),
(12, 1, 4),
(7, 1, 5),
(8, 1, 7),
(9, 1, 8),
(10, 1, 6),
(11, 1, 9),
(13, 2, 4),
(14, 3, 10),
(16, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_static_program`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_static_program`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_static_program` (
  `junior_ministay_static_program_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_name` varchar(200) NOT NULL,
  `description` text,
  `logo` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active , 0:inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not delete and 1:deleted',
  PRIMARY KEY (`junior_ministay_static_program_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_static_program`
--

INSERT INTO `frontweb_junior_ministay_static_program` (`junior_ministay_static_program_id`, `program_name`, `description`, `logo`, `status`, `delete_flag`) VALUES
(1, 'UK Residential', 'UK Residential<p><br></p>', '1518523592.jpg', 1, 0),
(2, 'Uk Family Stay', '<p>Uk Family Stay<br></p>', '1518523651.jpg', 1, 0),
(3, 'Scotland Residential', '<p>Scotland Residential<br></p>', '1518523686.jpg', 1, 0),
(4, 'USA Family Stay', 'USA Family Stay', '1518523738.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_video_gallery`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_video_gallery`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_video_gallery` (
  `junior_ministay_video_gallery_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `video_url` varchar(255) DEFAULT NULL,
  `description` text,
  `video_image` varchar(200) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `junior_ministay_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_ministay_video_gallery_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_video_gallery`
--

INSERT INTO `frontweb_junior_ministay_video_gallery` (`junior_ministay_video_gallery_id`, `video_url`, `description`, `video_image`, `sequence`, `junior_ministay_id`) VALUES
(2, 'https://vimeo.com/200004409', 'test descruiption once more', '1513681442.jpg', 1, 1),
(3, 'https://vimeo.com/200796403', 'test description', NULL, 1, 10),
(4, 'https://vimeo.com/200796403', 'description', '1519037733.jpg', 1, 9),
(5, 'https://vimeo.com/200796403', 'description', '1519037831.jpg', 1, 8),
(6, 'https://vimeo.com/200796403', 'test now', '1519088825.jpg', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_junior_ministay_walking_tour`
--

DROP TABLE IF EXISTS `frontweb_junior_ministay_walking_tour`;
CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay_walking_tour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_ministay_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_junior_ministay_walking_tour`
--

INSERT INTO `frontweb_junior_ministay_walking_tour` (`id`, `file_name`, `file_description`, `junior_ministay_id`) VALUES
(1, '1513771936.pdf', 'test description for this centre for walking tour', 1),
(3, '1519088765.pdf', 'test now', 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_language`
--

DROP TABLE IF EXISTS `frontweb_language`;
CREATE TABLE IF NOT EXISTS `frontweb_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `language_name` varchar(100) DEFAULT NULL,
  `short_name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_language`
--

INSERT INTO `frontweb_language` (`language_id`, `language_name`, `short_name`) VALUES
(1, 'English', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_manage_adult_course`
--

DROP TABLE IF EXISTS `frontweb_manage_adult_course`;
CREATE TABLE IF NOT EXISTS `frontweb_manage_adult_course` (
  `adult_course_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 : Active & 0 : Inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not delete & 1:delete',
  PRIMARY KEY (`adult_course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_manage_adult_course`
--

INSERT INTO `frontweb_manage_adult_course` (`adult_course_id`, `title`, `slug`, `description`, `image`, `status`, `delete_flag`) VALUES
(1, 'Uk University Placement', 'uk-university-placement', '<p>PLUS provides independent specialist advice and support to help prospective students\nmake the right choice and submit a successful application to university.</p><br>\n\n<p>Whilst support to prospective undergraduate and postgraduate students in applying to\nuniversity is our most popular service, we recognise that this is just the start of\nyour academic journey and we are able to support you throughout your time at\nuniversity.</p><br>\n\n<p>PLUS student focused approach is in the heart of what we do and what makes our work\nso rewarding.</p><br>\n\n<p>No one person is the same so we support the candidate and their family to make the\nbest decision and guide through every step of their university journey.</p><br>', '1518785506.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_manage_application_form`
--

DROP TABLE IF EXISTS `frontweb_manage_application_form`;
CREATE TABLE IF NOT EXISTS `frontweb_manage_application_form` (
  `manage_application_form_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `label_name` text,
  `field_type` varchar(200) DEFAULT NULL,
  `required_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:required & 0:not required',
  `multiple_value` text,
  `sequence` int(11) DEFAULT NULL,
  PRIMARY KEY (`manage_application_form_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_manage_application_form`
--

INSERT INTO `frontweb_manage_application_form` (`manage_application_form_id`, `label_name`, `field_type`, `required_flag`, `multiple_value`, `sequence`) VALUES
(51, 'Any other information that can help us advise you? (Work experience, disabilities, gap year information etc.):', 'textarea', 0, '', 17),
(49, 'For non-English speakers, English Language qualifications held or expected scores (e.g. IELTS scores in listening, reading, writing and speaking):', 'textarea', 0, '', 15),
(50, 'How do you plan on financing your studies including your tuition fees?', 'textarea', 0, '', 16),
(48, 'Have you got any relevant work experience? ', 'textarea', 0, '', 14),
(46, 'Desired university location in the UK if you have a preference e.g. London, Scotland?', 'textarea', 0, '', 12),
(47, 'Please list your current and pending future educational qualifications and attainment/anticipated attainment (e.g. International Baccalaureate or equivalent and subject areas):', 'textarea', 0, '', 13),
(45, 'University Course(s) and level (e.g. BA/BSc/MA/MSc/PhD etc) you are interested in? ', 'textarea', 0, '', 11),
(44, 'How did you hear about University Direct?', 'textarea', 0, '', 10),
(43, 'What is the best time to speak and the time difference from where you are based with the UK GMT?', 'textarea', 0, '', 9),
(42, 'Nationality', 'name', 1, '', 8),
(40, 'Skype name', 'text', 0, '', 6),
(41, 'Address –including country of current residence', 'textarea', 1, '', 7),
(38, 'Telephone/Mobile', 'mobile', 1, '', 4),
(39, 'Email address', 'email', 1, '', 5),
(35, 'Name', 'name', 1, '', 1),
(36, 'Gender', 'radio', 1, 'Male,Female', 2),
(37, 'Date of Birth', 'date', 1, '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_master_activity`
--

DROP TABLE IF EXISTS `frontweb_master_activity`;
CREATE TABLE IF NOT EXISTS `frontweb_master_activity` (
  `master_activity_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_id` int(11) DEFAULT NULL,
  `activity_name` varchar(255) DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `student_group` int(11) DEFAULT NULL,
  PRIMARY KEY (`master_activity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_master_activity`
--

INSERT INTO `frontweb_master_activity` (`master_activity_id`, `centre_id`, `activity_name`, `arrival_date`, `departure_date`, `student_group`) VALUES
(1, 3, 'One-week Suggested Activity Programme 2018', '2018-03-12', '2018-03-16', 3),
(2, 3, 'One-week Suggested Activity Programme 2018', '2018-03-12', '2018-03-16', 4),
(3, 6, 'One-week Suggested Activity Programme 2018', '2018-03-12', '2018-03-16', 0),
(4, 3, 'Activity 2016(Jul-Aug)', '2016-07-18', '2016-08-19', 3),
(5, 3, 'Activity 2016(Jul-Aug)', '2016-07-18', '2016-08-19', 4);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_menumst`
--

DROP TABLE IF EXISTS `frontweb_menumst`;
CREATE TABLE IF NOT EXISTS `frontweb_menumst` (
  `mnu_menuid` int(8) NOT NULL AUTO_INCREMENT COMMENT 'Unique Identifier',
  `mnu_parent_menu_id` int(8) NOT NULL DEFAULT '0',
  `mnu_menu_name` varchar(50) NOT NULL COMMENT 'Menu name',
  `mnu_is_content` int(1) NOT NULL COMMENT '0 – if menu has contents. 1 – if menu has no contents.',
  `mnu_url` varchar(100) NOT NULL COMMENT 'Not null if mnu_is_content = 1 menu.',
  `mnu_status` int(1) NOT NULL DEFAULT '1' COMMENT 'In which position menu name should be listed',
  `mnu_level` int(10) NOT NULL DEFAULT '1',
  `mnu_type` enum('Top','Footer','Other') NOT NULL DEFAULT 'Top',
  `mnu_sequence` int(10) NOT NULL DEFAULT '0',
  `mnu_created_on` datetime NOT NULL COMMENT 'Date on which menu is created.',
  `mnu_created_by` int(8) NOT NULL COMMENT 'Id of the user who created the menu',
  `mnu_modified_on` datetime NOT NULL COMMENT 'Date on which menu details are modified.',
  `mnu_modified_by` int(8) NOT NULL COMMENT 'Id of the user who modified the menu details',
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mnu_menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1 COMMENT='Menu Details';

--
-- Dumping data for table `frontweb_menumst`
--

INSERT INTO `frontweb_menumst` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_is_content`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES
(1, 0, 'Home', 1, '', 1, 1, 'Top', 1, '2017-12-08 14:00:42', 0, '2017-12-08 15:05:31', 0, 0),
(2, 0, 'Brochure', 1, '', 1, 1, 'Top', 2, '2017-12-08 14:32:03', 0, '2017-12-08 15:05:24', 0, 0),
(3, 0, 'About us', 1, '', 1, 1, 'Top', 3, '2017-12-08 14:35:29', 0, '2017-12-08 15:05:16', 0, 0),
(4, 0, 'Contact', 1, '', 1, 1, 'Top', 4, '2017-12-08 14:36:25', 0, '0000-00-00 00:00:00', 0, 0),
(5, 0, 'WHICH WORKSHOP TO FIND PLUS', 1, '', 1, 1, 'Footer', 1, '2017-12-08 15:06:18', 0, '2017-12-14 10:44:02', 0, 0),
(6, 0, 'JOBS', 1, '', 1, 1, 'Footer', 3, '2017-12-08 15:12:35', 0, '2017-12-14 10:44:20', 0, 0),
(7, 2, 'PLUS Brochure (English Version)', 1, '', 1, 2, 'Top', 1, '2017-12-08 15:14:53', 0, '0000-00-00 00:00:00', 0, 0),
(8, 2, 'PLUS Brochure(Chinese Version)', 1, '', 1, 2, 'Top', 2, '2017-12-08 15:15:52', 0, '0000-00-00 00:00:00', 0, 0),
(9, 0, 'Accomodation', 1, '', 1, 1, 'Other', 1, '2017-12-11 10:32:46', 0, '0000-00-00 00:00:00', 0, 0),
(10, 0, 'Plus Team', 1, '', 1, 1, 'Other', 2, '2017-12-11 13:01:31', 0, '0000-00-00 00:00:00', 0, 0),
(11, 0, 'Course', 1, '', 1, 1, 'Other', 3, '2017-12-12 13:28:13', 0, '0000-00-00 00:00:00', 0, 0),
(12, 2, 'Uk University Placement', 1, '', 1, 2, 'Top', 3, '2017-12-13 12:13:31', 0, '0000-00-00 00:00:00', 0, 0),
(13, 0, 'Footer Address', 1, '', 1, 1, 'Other', 4, '2017-12-14 10:40:31', 0, '0000-00-00 00:00:00', 0, 0),
(14, 0, 'USEFUL INFORMATION', 1, '', 1, 1, 'Footer', 4, '2017-12-14 10:44:37', 0, '0000-00-00 00:00:00', 0, 0),
(15, 5, 'Quality form', 1, '', 1, 2, 'Footer', 1, '2017-12-14 13:19:36', 0, '0000-00-00 00:00:00', 0, 0),
(16, 5, 'Report a complaint', 1, '', 1, 2, 'Footer', 2, '2017-12-14 13:30:00', 0, '0000-00-00 00:00:00', 0, 0),
(17, 6, 'Apply for campus manager', 1, '', 1, 2, 'Footer', 2, '2017-12-14 13:30:27', 0, '0000-00-00 00:00:00', 0, 0),
(18, 6, 'Apply for Choreographer', 1, '', 1, 2, 'Footer', 1, '2017-12-14 13:30:37', 0, '2018-01-23 12:17:20', 0, 0),
(19, 6, 'Apply for teaching position', 1, '', 1, 2, 'Footer', 5, '2017-12-14 13:30:48', 0, '0000-00-00 00:00:00', 0, 0),
(20, 6, 'Apply for activity leader position', 1, '', 1, 2, 'Footer', 3, '2017-12-14 13:31:00', 0, '0000-00-00 00:00:00', 0, 0),
(21, 6, 'Apply for an Course Director position', 1, '', 1, 2, 'Footer', 4, '2017-12-14 13:31:12', 0, '2018-01-23 12:19:02', 0, 0),
(22, 14, 'Language levels', 1, '', 1, 2, 'Footer', 1, '2017-12-14 13:32:13', 0, '0000-00-00 00:00:00', 0, 0),
(23, 14, 'Insurance', 1, '', 1, 2, 'Footer', 2, '2017-12-14 13:32:25', 0, '0000-00-00 00:00:00', 0, 0),
(24, 14, 'Visa information', 1, '', 1, 2, 'Footer', 3, '2017-12-14 13:32:36', 0, '0000-00-00 00:00:00', 0, 0),
(25, 14, 'Policies', 1, '', 1, 2, 'Footer', 4, '2017-12-14 13:32:47', 0, '0000-00-00 00:00:00', 0, 0),
(26, 14, 'Welfare form', 1, '', 1, 2, 'Footer', 5, '2017-12-14 13:32:57', 0, '0000-00-00 00:00:00', 0, 0),
(27, 14, 'Customer satisfaction policy', 1, '', 1, 2, 'Footer', 6, '2017-12-14 13:33:08', 0, '0000-00-00 00:00:00', 0, 0),
(28, 14, 'Young learner age range policy', 1, '', 1, 2, 'Footer', 7, '2017-12-14 13:33:29', 0, '0000-00-00 00:00:00', 0, 0),
(29, 14, 'Child supervision policy', 1, '', 1, 2, 'Footer', 8, '2017-12-14 13:33:45', 0, '0000-00-00 00:00:00', 0, 0),
(30, 14, 'Safeguarding policy', 1, '', 1, 2, 'Footer', 9, '2017-12-14 13:33:55', 0, '0000-00-00 00:00:00', 0, 0),
(31, 14, 'Student code of conduct', 1, '', 1, 2, 'Footer', 10, '2017-12-14 13:34:06', 0, '0000-00-00 00:00:00', 0, 0),
(32, 14, 'Student absence policy', 1, '', 1, 2, 'Footer', 11, '2017-12-14 13:34:17', 0, '0000-00-00 00:00:00', 0, 0),
(33, 14, 'Unacceptable behaviour policy', 1, '', 1, 2, 'Footer', 12, '2017-12-14 13:34:32', 0, '0000-00-00 00:00:00', 0, 0),
(34, 14, 'Privacy policy', 1, '', 1, 2, 'Footer', 13, '2017-12-14 13:34:45', 0, '0000-00-00 00:00:00', 0, 0),
(35, 14, 'Anti-bullying policy', 1, '', 1, 2, 'Footer', 14, '2017-12-14 13:35:05', 0, '0000-00-00 00:00:00', 0, 0),
(36, 14, 'Accessibility statement', 1, '', 1, 2, 'Footer', 15, '2017-12-14 13:35:15', 0, '0000-00-00 00:00:00', 0, 0),
(37, 14, 'Terms and conditions', 1, '', 1, 2, 'Footer', 19, '2017-12-14 13:35:24', 0, '0000-00-00 00:00:00', 0, 0),
(38, 14, 'Plus Social Media Policy', 1, '', 1, 2, 'Footer', 16, '2017-12-15 06:17:08', 0, '0000-00-00 00:00:00', 0, 0),
(39, 14, 'Pluf Fire Safety Policy', 1, '', 1, 2, 'Footer', 17, '2017-12-15 06:17:24', 0, '0000-00-00 00:00:00', 0, 0),
(40, 14, 'Plus Safeguarding Policy', 1, '', 1, 2, 'Footer', 18, '2017-12-15 06:17:41', 0, '0000-00-00 00:00:00', 0, 0),
(41, 0, 'Add on', 1, '', 1, 1, 'Other', 5, '2017-12-22 05:49:29', 0, '0000-00-00 00:00:00', 0, 0),
(42, 0, 'Accomodation(Home Page)', 1, '', 1, 1, 'Other', 6, '2018-01-23 06:56:21', 0, '0000-00-00 00:00:00', 0, 0),
(43, 0, 'Activities On Campus', 1, '', 1, 1, 'Other', 7, '2018-01-23 09:25:41', 0, '0000-00-00 00:00:00', 0, 0),
(44, 0, 'Our Team', 1, '', 1, 1, 'Other', 8, '2018-01-23 09:47:34', 0, '0000-00-00 00:00:00', 0, 0),
(45, 1, 'ACCOMMODATION', 1, '', 1, 2, 'Top', 1, '2018-01-29 08:56:25', 0, '2018-02-16 14:46:58', 0, 0),
(46, 1, 'Activities On Campus', 1, '', 1, 2, 'Top', 2, '2018-01-29 08:57:23', 0, '0000-00-00 00:00:00', 0, 0),
(47, 1, 'Our Team', 1, '', 1, 2, 'Top', 3, '2018-01-29 08:57:36', 0, '0000-00-00 00:00:00', 0, 0),
(50, 0, 'Download Instructions for Desktop', 1, '', 1, 1, 'Other', 9, '2018-02-13 06:18:44', 0, '2018-02-13 06:23:11', 0, 0),
(51, 0, 'Download Instructions for Android', 1, '', 1, 1, 'Other', 10, '2018-02-13 06:23:36', 0, '2018-02-13 06:23:48', 0, 0),
(52, 0, 'Download Instructions for IOS', 1, '', 1, 1, 'Other', 11, '2018-02-13 06:24:24', 0, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_plus_activity`
--

DROP TABLE IF EXISTS `frontweb_plus_activity`;
CREATE TABLE IF NOT EXISTS `frontweb_plus_activity` (
  `plus_activity_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `name` varchar(255) DEFAULT NULL,
  `centre_id` int(11) DEFAULT NULL,
  `description` text,
  `front_image` varchar(255) DEFAULT NULL,
  `added_date` date DEFAULT NULL,
  `show_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 : upload image & 2 : enter text',
  `show_text` varchar(255) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active & 0:Inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not delete and 1:deleted',
  PRIMARY KEY (`plus_activity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_plus_activity`
--

INSERT INTO `frontweb_plus_activity` (`plus_activity_id`, `name`, `centre_id`, `description`, `front_image`, `added_date`, `show_type`, `show_text`, `sequence`, `status`, `delete_flag`) VALUES
(1, 'It is a long established fact that a reader', 52, '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\n</p>', '1521012690.jpg', '2018-03-14', 1, '', 1, 1, 0),
(2, 'There are many variations of passages', 52, '<p style="margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><div><br></div>', '', '2018-03-14', 2, 'There are many variations of passages', 2, 1, 0),
(3, 'The standard chunk of Lorem', 52, '<p style="margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', '', '2018-03-14', 2, 'The standard chunk of Lorem', 3, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_plus_activity_file`
--

DROP TABLE IF EXISTS `frontweb_plus_activity_file`;
CREATE TABLE IF NOT EXISTS `frontweb_plus_activity_file` (
  `plus_activity_file_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(255) DEFAULT NULL,
  `plus_activity_id` int(11) NOT NULL,
  PRIMARY KEY (`plus_activity_file_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_plus_activity_file`
--

INSERT INTO `frontweb_plus_activity_file` (`plus_activity_file_id`, `file_name`, `plus_activity_id`) VALUES
(1, '1521012690.pdf', 1),
(2, '1521012690.jpg', 1),
(3, '1521012690.xls', 1),
(4, '1521017592.pdf', 2),
(5, '1521017592.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_plus_video`
--

DROP TABLE IF EXISTS `frontweb_plus_video`;
CREATE TABLE IF NOT EXISTS `frontweb_plus_video` (
  `plus_video_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `manager_password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`plus_video_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_plus_video`
--

INSERT INTO `frontweb_plus_video` (`plus_video_id`, `centre`, `password`, `manager_password`) VALUES
(1, 3, 'uA8JgBHqi2', 'BEAwxMB8JE'),
(2, 62, 'itUB9Diu7c', 'BEGh2UOslD'),
(3, 6, 'XOIF7YTlJ0', '4wNwZwKBRc'),
(4, 12, 'AQoTKkPseG', 'RevYI4wN7i'),
(5, 52, 'KfiK9WWNeW', 'ihUQ4wHLto'),
(6, 20, 'Chester123', 'eBCSnmoJLs1'),
(7, 21, 'zEBJ7eCwwz', '0GIgvycolY'),
(8, 26, 'WzdinSllwT', 'tuNJNzdZ2U'),
(9, 27, 'dLpmMCEhmF', 'XuXw4m0ecI'),
(10, 30, 'vr3UUcRLa8', 'kEMjHpHlFn'),
(11, 47, 'pksoRQONwZ', 'UsnmvGS2Nl'),
(12, 36, '0DvMefQPvs', 'yQjlQECxpC'),
(13, 38, 'U6vz7EPQJg', 'Manager123'),
(14, 41, 'bVkH6K5ihC', 'TO9BY3Jj2n'),
(15, 42, 'sQiDiNtaKe', 'MOKMXULwdj'),
(16, 45, 'N3gnitjUdm', '6i3OQlLqgq'),
(17, 46, 'Oizma1tvjG', 'dIcSujiIx9'),
(18, 48, 'AM3zw9hq6r', 'W3KJdhtCRu'),
(19, 53, 'Id5tt5BDbk', 'CLPzTeSRBS'),
(20, 56, 'jPt3zxKAEB', '8P06PCCEAj'),
(21, 57, 'WkAKWJAg6X', 'MIoAUqgI9g'),
(22, 59, 'HXgyaos9DB', 'rnzHr7WhaG'),
(23, 60, 'cpQVlIcbQh', 'rjDGhEd2X2'),
(24, 61, 'xVaP4r9QNb', 'CsbfMvbemj'),
(25, 63, 'hdAJrNa774', 'kjjCMDszKX'),
(26, 64, 'Testtest123', 'Manager123'),
(27, 65, 'UsAWXHgPI3', 'ds9999L3hM'),
(28, 66, 'tnkGNcwIF7', 'zbzfHYt9Co'),
(29, 67, 'QVyjEbe4m1', 'QuW08WRgjg'),
(30, 68, '6m5M7oHmSY', 'RkQbMy1Bbl'),
(31, 69, 'Pmhzh1NzOG', 'XbpXtKwVz8'),
(32, 70, '9aYEJNSago', '00b4A1uplz'),
(33, 71, 'DuuuAWK6OO', 'khiKWluNQ9'),
(34, 72, 'nzH2paMRza', 'LXkGT9DiTP'),
(35, 73, 'Y6WNjGOp7a', 'Gvm6hsvCQ4');

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_plus_walking_tour`
--

DROP TABLE IF EXISTS `frontweb_plus_walking_tour`;
CREATE TABLE IF NOT EXISTS `frontweb_plus_walking_tour` (
  `plus_walking_tour_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_id` int(11) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`plus_walking_tour_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_plus_walking_tour`
--

INSERT INTO `frontweb_plus_walking_tour` (`plus_walking_tour_id`, `centre_id`, `video`, `description`) VALUES
(1, 67, '257910833.mp4', 'Brighton Half Day 1'),
(2, 67, '257912850.mp4', 'Brighton Half Day 2 '),
(3, 67, '257918123.mp4', 'Brighton Half Day 3 '),
(4, 67, '257919533.mp4', 'Brighton Half Day 4 '),
(5, 67, '257921633.mp4', 'Brighton Half Day 5 '),
(6, 67, '257922177.mp4', 'Brighton Half Day 6 '),
(7, 67, '257923257.mp4', 'Brighton Half Day 7 '),
(8, 67, '257924866.mp4', 'Brighton Half Day 8 '),
(9, 67, '257925498.mp4', 'Brighton Half Day 9 '),
(10, 6, '257925849.mp4', 'Canterbury Full Day 1 '),
(11, 6, '257922177.mp4', 'Canterbury Full Day 2 '),
(12, 6, '257923257.mp4', 'Canterbury Full Day 3 '),
(13, 6, '257924866.mp4', 'Canterbury Full Day 4 '),
(14, 6, '257927101.mp4', 'Canterbury Full Day 5 '),
(15, 6, '257928330.mp4', 'Canterbury Full Day 7 '),
(16, 41, '257922177.mp4', 'Chelmsford Full Day 1 '),
(17, 41, '257929148.mp4', 'Chelmsford Full Day 2 '),
(18, 41, '257928862.mp4', 'Chelmsford Full Day 3 '),
(19, 41, '257923257.mp4', 'Chelmsford Full Day 4 '),
(20, 41, '257924866.mp4', 'Chelmsford Full Day 5 '),
(21, 41, '257927891.mp4', 'Chelmsford Full Day 6 '),
(22, 41, '257928330.mp4', 'Chelmsford Full Day 7 '),
(23, 20, '257930200.mp4', 'Chester Full Day 1 '),
(24, 20, '258059654.mp4', 'Chester Full Day 2 '),
(25, 20, '257933862.mp4', 'Chester Full Day 3 '),
(26, 20, '257936819.mp4', 'Chester Full Day 4 '),
(27, 20, '258048466.mp4', 'Chester Full Day 5 '),
(28, 36, '258050606.mp4', 'Dublin Full Day 1 '),
(29, 36, '258050926.mp4', 'Dublin Full Day 2 '),
(30, 36, '258051295.mp4', 'Dublin Full Day 3 '),
(31, 36, '258057129.mp4', 'Dublin Full Day 4 '),
(32, 36, '258057335.mp4', 'Dublin Full Day 5 '),
(33, 21, '257904189.mp4', 'Edinburgh Half Day 1'),
(34, 21, '257907400.mp4', 'Edinburgh Half Day 2 '),
(35, 21, '258057577.mp4', 'Edinburgh Half Day 3 '),
(36, 21, '258057992.mp4', 'Edinburgh Half Day 4 '),
(37, 21, '257898261.mp4', 'Edinburgh Half Day 5 '),
(38, 21, '257896377.mp4', 'Edinburgh Half Day 6 '),
(39, 21, '257900896.mp4', 'Edinburgh Half Day 7 '),
(40, 52, '257925849.mp4', 'Effingham Full Day 1 '),
(41, 52, '257923257.mp4', 'Effingham Full Day 2 '),
(42, 52, '257924866.mp4', 'Effingham Full Day 3 '),
(43, 52, '257925498.mp4', 'Effingham Full Day 4 ');

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_program_banner`
--

DROP TABLE IF EXISTS `frontweb_program_banner`;
CREATE TABLE IF NOT EXISTS `frontweb_program_banner` (
  `program_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_image` varchar(100) DEFAULT NULL,
  `program_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active , 0:inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not deleted and 1 = deleted',
  PRIMARY KEY (`program_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_program_banner`
--

INSERT INTO `frontweb_program_banner` (`program_id`, `program_image`, `program_status`, `delete_flag`) VALUES
(1, '1511917327.jpg', 1, 0),
(2, '1511917360.jpg', 1, 0),
(3, '1511917411.jpg', 1, 0),
(4, '1511917451.jpg', 1, 0),
(5, '1511917486.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_program_banner_language`
--

DROP TABLE IF EXISTS `frontweb_program_banner_language`;
CREATE TABLE IF NOT EXISTS `frontweb_program_banner_language` (
  `program_language_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `language_id` int(11) DEFAULT NULL,
  `program_title` varchar(100) DEFAULT NULL,
  `program_short_description` varchar(200) DEFAULT NULL,
  `program_description` text,
  `program_id` int(11) DEFAULT NULL,
  `more_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`program_language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_program_banner_language`
--

INSERT INTO `frontweb_program_banner_language` (`program_language_id`, `language_id`, `program_title`, `program_short_description`, `program_description`, `program_id`, `more_link`) VALUES
(1, 1, 'JUNIOR USA SUMMER COURSE', 'Giving valuable reputation and credibility to your business', 'Giving valuable reputation and credibility to your business', 1, 'program#experience'),
(2, 1, 'THE USA EXPERIENCE PROGRAMME', 'Giving valuable reputation and credibility to your business', 'Giving valuable reputation and credibility to your business', 2, 'junior-summer-courses'),
(3, 1, 'JUNIOR ALL YEAR ROUND IN USA', 'Giving valuable reputation and credibility to your business', 'Giving valuable reputation and credibility to your business', 3, 'junior-summer-courses'),
(4, 1, 'UNIOR MINI STAY - ALL YEAR ROUND', 'Giving valuable reputation and credibility to your business', 'Giving valuable reputation and credibility to your business', 4, 'junior-mini-stay'),
(5, 1, 'UK UNIVERSITY PLACEMENT', 'Giving valuable reputation and credibility to your business', 'Giving valuable reputation and credibility to your business', 5, 'adult-course');

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_program_course`
--

DROP TABLE IF EXISTS `frontweb_program_course`;
CREATE TABLE IF NOT EXISTS `frontweb_program_course` (
  `program_course_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_course_name` varchar(100) DEFAULT NULL,
  `program_course_description` text,
  `program_course_logo` varchar(100) DEFAULT NULL,
  `program_front_image` varchar(200) DEFAULT NULL,
  `sequence_slug` varchar(255) DEFAULT NULL,
  `program_course_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active & 0:Inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not delete & 1:delete',
  PRIMARY KEY (`program_course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_program_course`
--

INSERT INTO `frontweb_program_course` (`program_course_id`, `program_course_name`, `program_course_description`, `program_course_logo`, `program_front_image`, `sequence_slug`, `program_course_status`, `delete_flag`) VALUES
(1, 'CLASSIC', '<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">The Classic package includes full board onsite or host family accommodation, expert tuition and two full day excursion per week. Also included are a full and varied onsite social and sports activities program during the day as well as an action-packed evening social program all fully organized and supervised by our energetic PLUS staff. </p>', '1515652617.jpg', '1515982530.jpg', 'classic', 1, 0),
(2, 'CLASSIC PREMIUM', '<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">The Classic Premium package includes full board onsite or host family accommodation, expert tuition and two or more full day excursion per week (including attractions). These excursions normally include a walking tour and we can offer additional attraction tickets at a reduced rate organized by PLUS.  Also included are a full and varied onsite social and sports activities program during the day as well as an action-packed evening social program all fully organized and supervised by our energetic PLUS staff. </p>', '1515652635.jpg', '1515575735.jpg', 'classic-premium', 1, 0),
(3, 'CLASSIC PLUS ACADEMY', '<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">The Academy package includes full board onsite or host family accommodation, expert tuition and two full day excursion per week. Also included are a full and varied onsite social and sports activities program during the day as well as an action-packed evening social program all fully organized and supervised by our energetic PLUS staff.  </p>\n<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">In addition to this, students can book to take specialist courses in Football, Rugby or Dance with our highly trained and experienced coaches. These sessions are 2 hours long with specific skills focusses and drills followed by an hour of games and freer practice organized by our PLUS staff. </p>', '1515652655.jpg', '1515575870.jpg', 'classic-plus-academy', 1, 0),
(4, 'CLASSIC PREMIUM PLUS ACADEMY', '<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">The Academy package includes full board onsite or host family accommodation, expert tuition and two full day excursion per week. Also included are a full and varied onsite social and sports activities program during the day as well as an action-packed evening social program all fully organized and supervised by our energetic PLUS staff. </p>\n<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">In addition to this, students can book to take specialist courses in Football, Rugby or Dance with our highly trained and experienced coaches. These sessions are 2 hours long with specific skills focusses and drills followed by an hour of games and freer practice organized by our PLUS staff. </p>', '1515652678.jpg', '1515575895.jpg', 'classic-premium-plus-academy', 1, 0),
(5, 'EXPERIENCE', '<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">Here at PLUS we have created and developed a truly unique Experience Package. This all-inclusive programme includes full board accommodation, expert tuition, exciting activity program and engaging excursions to some of the most famous sites in the world, including priority entrance to attractions and the full VIP treatment. Also included is a half board weekend away to a world-famous city depending on location. (For example, Boston, Washington, LA, San Francisco). This course is action packed and fully immersive to ensure every student has a truly rewarding and unforgettable experience in the USA. </p>', '1515652693.jpg', '1515575978.jpg', 'experience', 1, 0),
(6, 'CLASSIC SUPERIOR', '<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">The Classic Premium package includes full board onsite or host family accommodation, expert tuition and many full day excursions each week (including entrance to the attractions). Also included are a full and varied onsite social and sports activities program during the day as well as an action-packed evening social program all fully organized and supervised by our energetic PLUS staff.</p>', '1515652706.jpg', '1515575994.jpg', 'classic-superior', 1, 0),
(7, 'CLASSIC PREMIUM PLUS WEEKEND AWAY', '<p style="color: #999;text-transform: none;font-weight: normal;margin-bottom: 1em;">The academy + classic + weekend away is the course that offers a nonstop, immersive course to get the most out of your time in the UK. This course includes full board accommodation, expert tuition, full and varied social program, 2 or more excursions each week, attraction tickets included, full participation in a prebooked academy course (football, rugby or Dance) as well as a weekend away to London. Offering the chance to explore the famous capital city whilst staying at one of our London based centers or other suitable accommodation. </p>', '1515652720.jpg', '1515575919.jpg', 'classic-premium-plus-weekend-away', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_region_master_old`
--

DROP TABLE IF EXISTS `frontweb_region_master_old`;
CREATE TABLE IF NOT EXISTS `frontweb_region_master_old` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `region_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_region_master_old`
--

INSERT INTO `frontweb_region_master_old` (`region_id`, `region_name`) VALUES
(1, 'UNITED KINGDOM'),
(2, 'USA'),
(3, 'IRELAND'),
(4, 'MALTA');

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_section_setting`
--

DROP TABLE IF EXISTS `frontweb_section_setting`;
CREATE TABLE IF NOT EXISTS `frontweb_section_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `type` enum('1','2') DEFAULT NULL COMMENT '1 : junior centre & 2 : junior mini stay',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_section_setting`
--

INSERT INTO `frontweb_section_setting` (`id`, `name`, `slug`, `sequence`, `type`) VALUES
(1, 'DATES', 'dates', 1, '1'),
(2, 'ACCOMMODATION', 'accommodation', 2, '1'),
(3, 'COURSE', 'course', 3, '1'),
(4, 'SOCIAL PROGRAMMES AND SPORT', 'social-program-sport', 4, '1'),
(5, 'WALKING TOUR', 'walking-tour', 6, '1'),
(6, 'TRAVEL CARD', 'travel-card', 5, '1'),
(7, 'PLUS TEAM', 'plus-team', 7, '1'),
(8, 'CLASSIC', 'classic', 8, '1'),
(9, 'CLASSIC PREMIUM', 'classic-premium', 9, '1'),
(10, 'CLASSIC PLUS ACADEMY', 'classic-plus-academy', 10, '1'),
(11, 'CLASSIC PREMIUM PLUS ACADEMY', 'classic-premium-plus-academy', 11, '1'),
(12, 'EXPERIENCE', 'experience', 12, '1'),
(13, 'CLASSIC SUPERIOR', 'classic-superior', 13, '1'),
(14, 'CLASSIC PREMIUM PLUS WEEKEND AWAY', 'classic-premium-plus-weekend-away', 14, '1'),
(15, 'Add ON', 'add-on', 15, '1'),
(16, 'Fact Sheet', 'fact-sheet', 16, '1'),
(17, 'Activity Programmes', 'activity-program', 17, '1'),
(18, 'Menu', 'menu', 18, '1'),
(19, 'International Mix', 'international-mix', 19, '1'),
(20, 'DATES', 'dates', 3, '2'),
(21, 'ACCOMMODATION', 'accommodation', 1, '2'),
(22, 'COURSE', 'course', 4, '2'),
(23, 'SOCIAL PROGRAMMES AND SPORT', 'social-program-sport', 2, '2'),
(24, 'WALKING TOUR', 'walking-tour', 5, '2'),
(25, 'TRAVEL CARD', 'travel-card', 6, '2'),
(26, 'PLUS TEAM', 'plus-team', 7, '2'),
(27, 'CLASSIC', 'classic', 8, '2'),
(28, 'CLASSIC PREMIUM', 'classic-premium', 9, '2'),
(29, 'CLASSIC PLUS ACADEMY', 'classic-plus-academy', 10, '2'),
(30, 'CLASSIC PREMIUM PLUS ACADEMY', 'classic-premium-plus-academy', 11, '2'),
(31, 'EXPERIENCE', 'experience', 12, '2'),
(32, 'CLASSIC SUPERIOR', 'classic-superior', 13, '2'),
(33, 'CLASSIC PREMIUM PLUS WEEKEND AWAY', 'classic-premium-plus-weekend-away', 14, '2'),
(34, 'Add ON', 'add-on', 15, '2'),
(35, 'Fact Sheet', 'fact-sheet', 16, '2'),
(36, 'Activity Programmes', 'activity-program', 17, '2'),
(37, 'Menu', 'menu', 18, '2'),
(38, 'International Mix', 'international-mix', 19, '2'),
(53, 'Horse Riding', 'horse-riding', 21, '1'),
(54, 'Golf Play', 'golf-play', 20, '2'),
(55, 'New Year Program', 'new-year-program', 22, '1'),
(56, 'Test section', 'test-section', 23, '1'),
(57, 'Test extra section', 'test-extra-section', 20, '1');

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_student_group`
--

DROP TABLE IF EXISTS `frontweb_student_group`;
CREATE TABLE IF NOT EXISTS `frontweb_student_group` (
  `student_group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_id` int(11) DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `group_strength` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 : Active & 0 : Inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not delete & 1:delete',
  PRIMARY KEY (`student_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_student_group`
--

INSERT INTO `frontweb_student_group` (`student_group_id`, `centre_id`, `group_name`, `group_strength`, `status`, `delete_flag`) VALUES
(1, 52, 'Classic Group A', 50, 1, 0),
(2, 52, 'Classic Group B', 50, 1, 0),
(3, 3, 'Classic Group A', 50, 1, 0),
(4, 3, 'Classic Group B', 50, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `frontweb_walking_tour_centre_details`
--

DROP TABLE IF EXISTS `frontweb_walking_tour_centre_details`;
CREATE TABLE IF NOT EXISTS `frontweb_walking_tour_centre_details` (
  `walking_tour_centre_details_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_id` int(11) DEFAULT NULL,
  `icon_class` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` text,
  `sequence` int(11) DEFAULT NULL,
  PRIMARY KEY (`walking_tour_centre_details_id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontweb_walking_tour_centre_details`
--

INSERT INTO `frontweb_walking_tour_centre_details` (`walking_tour_centre_details_id`, `centre_id`, `icon_class`, `title`, `details`, `sequence`) VALUES
(1, 73, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(2, 73, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(3, 73, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(4, 73, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(5, 48, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(6, 48, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(7, 48, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(8, 48, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(9, 68, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(10, 68, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(11, 68, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(12, 68, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(13, 69, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(14, 69, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(15, 69, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(16, 69, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(17, 70, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(18, 70, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(19, 70, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(20, 70, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(21, 6, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(22, 6, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(23, 6, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(24, 6, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(25, 71, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(26, 71, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(27, 71, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(28, 71, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(29, 53, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(30, 53, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(31, 53, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(32, 53, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(33, 72, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(34, 72, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(35, 72, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(36, 72, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(37, 57, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(38, 57, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(39, 57, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(40, 57, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(41, 36, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(42, 36, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(43, 36, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(44, 36, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(45, 30, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(46, 30, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(47, 30, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(48, 30, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(49, 46, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(50, 46, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(51, 46, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(52, 46, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(53, 27, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(54, 27, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(55, 27, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(56, 27, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(57, 21, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(58, 21, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(59, 21, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(60, 21, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(61, 3, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(62, 3, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(63, 3, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(64, 3, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(65, 56, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(66, 56, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(67, 56, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(68, 56, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(69, 20, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(70, 20, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(71, 20, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(72, 20, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(73, 52, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(74, 52, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(75, 52, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(76, 52, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(77, 41, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(78, 41, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(79, 41, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(80, 41, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(81, 12, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(82, 12, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(83, 12, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(84, 12, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(85, 47, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(86, 47, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(87, 47, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(88, 47, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(89, 66, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(90, 66, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(91, 66, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(92, 66, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(93, 67, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(94, 67, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(95, 67, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(96, 67, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4),
(97, 38, 'fa-home', 'Address', '<p>Professional Linguistic Upper Studies</p>\r\n									<p>8-10 Grosvenor Gardens,</p>\r\n									<p>Mezzanine floor,</p>\r\n									<p>London, SW1W 0DH</p>', 1),
(98, 38, 'fa-phone', 'Telephone', '<a href="tel:+ 44 (0)20 7730 2223">+ 44 (0)20 7730 2223</a>', 2),
(99, 38, 'fa-fax', 'Fax', '<a href="tel:+ 44 (0)20 7730 9209">+ 44 (0)20 7730 9209</a>', 3),
(100, 38, 'fa-envelope', 'Email', '<a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a>', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
