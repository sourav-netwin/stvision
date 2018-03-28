/* Date: 8-Dec-2017 | Sourav Dhara */

CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_fact_sheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_activity_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




/* Date: 11-Dec-2017 | Sourav Dhara */

CREATE TABLE IF NOT EXISTS `frontweb_junior_centre_walking_tour` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `file_name` varchar(200) DEFAULT NULL,
  `file_description` text,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE  `frontweb_junior_centre_dates` ( `junior_centre_dates_id` INT 
NOT NULL AUTO_INCREMENT COMMENT 'primary key' , `date` DATE NULL , `overnight` VARCHAR(255) NULL ,
 `junior_centre_id` INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY (`junior_centre_dates_id`)) ENGINE = MyISAM;
 
CREATE TABLE  `frontweb_junior_centre_dates_week` ( `junior_centre_dates_week_id` 
INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , `week` INT NULL , `junior_centre_dates_id` 
INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY (`junior_centre_dates_week_id`)) ENGINE = MyISAM;

CREATE TABLE  `frontweb_junior_centre_dates_program` ( `junior_centre_dates_program_id` 
INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , `program_id` INT NULL , `junior_centre_dates_id` 
INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY (`junior_centre_dates_program_id`)) ENGINE = MyISAM;




/* Date: 12-Dec-2017 | Sourav Dhara */

CREATE TABLE  `frontweb_junior_centre_photo_gallery` ( `junior_centre_photo_gallery_id` 
INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , `short_description` VARCHAR(255) NULL , `description` TEXT NULL ,
 `photo` VARCHAR(200) NULL , `junior_centre_id` INT NOT NULL COMMENT 'foreign key' , 
 PRIMARY KEY (`junior_centre_photo_gallery_id`)) ENGINE = MyISAM;
 
CREATE TABLE  `frontweb_junior_centre_video_gallery` ( `junior_centre_video_gallery_id` 
INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , `video_url` VARCHAR(255) NULL , `description` 
TEXT NULL , `junior_centre_id` INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY (`junior_centre_video_gallery_id`))
 ENGINE = MyISAM;
 
CREATE TABLE  `frontweb_junior_centre_international_mix` ( `junior_centre_international_mix_id` 
INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , `country_name` VARCHAR(255) NULL , `percentage` VARCHAR(200) NULL ,
 `color_code` VARCHAR(200) NULL , `junior_centre_id` INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY 
 (`junior_centre_international_mix_id`)) ENGINE = MyISAM;
 
ALTER TABLE `frontweb_junior_centre_video_gallery` ADD `video_image` VARCHAR(200) NULL AFTER `description`;

ALTER TABLE `frontweb_junior_centre_photo_gallery` ADD `sequence` INT NULL AFTER `photo`;

ALTER TABLE `frontweb_junior_centre_video_gallery` ADD `sequence` INT NULL AFTER `video_image`;

ALTER TABLE `frontweb_junior_centre_program` ADD `program_details` TEXT NULL AFTER `program_id`;

/* Date: 18-Dec-2017 | Sourav Dhara */

CREATE TABLE IF NOT EXISTS `frontweb_junior_ministay` (
  `junior_ministay_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_id` int(11) DEFAULT NULL,
  `centre_banner` varchar(200) DEFAULT NULL,
  `junior_ministay_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active & 0:Inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not delete & 1:delete',
  PRIMARY KEY (`junior_ministay_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/* Date: 19-Dec-2017 | Sourav Dhara */

CREATE TABLE  `frontweb_junior_ministay_photo_gallery` ( `junior_ministay_photo_gallery_id` INT NOT NULL 
AUTO_INCREMENT COMMENT 'primary key' , `short_description` VARCHAR(255) NULL , `description` TEXT NULL , 
`photo` VARCHAR(200) NULL , `junior_ministay_id` INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY 
(`junior_ministay_photo_gallery_id`)) ENGINE = MyISAM;

ALTER TABLE `frontweb_junior_ministay_photo_gallery` ADD `sequence` INT NULL AFTER `photo`; 

CREATE TABLE  `frontweb_junior_ministay_video_gallery` ( `junior_ministay_video_gallery_id` 
INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , `video_url` VARCHAR(255) NULL , `description` TEXT NULL , 
`video_image` VARCHAR(200) NULL , `sequence` INT NULL , `junior_ministay_id` INT NOT NULL COMMENT 'foreign key' , 
PRIMARY KEY (`junior_ministay_video_gallery_id`)) ENGINE = MyISAM;

/* Date: 20-Dec-2017 | Sourav Dhara */

ALTER TABLE `frontweb_junior_ministay` ADD `accomodation_show_flag` TINYINT(1) NULL COMMENT 
'1:show & 0:not show' AFTER `centre_banner`, ADD `plus_team_show_flag` TINYINT(1) NULL COMMENT 
'1:show & 0:not show' AFTER `accomodation_show_flag`, ADD `course_show_flag` TINYINT(1) NULL COMMENT 
'1:show & 0:not show' AFTER `plus_team_show_flag`;

CREATE TABLE  `frontweb_junior_ministay_fact_sheet` ( `id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `file_name` VARCHAR(200) NOT NULL , `file_description` TEXT NOT NULL , `junior_ministay_id` 
INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE  `frontweb_junior_ministay_activity_program` ( `id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `file_name` VARCHAR(200) NULL , `file_description` TEXT NULL , `junior_ministay_id` 
INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE  `frontweb_junior_ministay_addon` ( `id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `file_name` VARCHAR(200) NULL , `file_description` TEXT NULL , `junior_ministay_id` INT NOT NULL 
COMMENT 'foreign key' , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE  `frontweb_junior_ministay_menu` ( `id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `file_name` VARCHAR(200) NULL , `file_description` TEXT NULL , `junior_ministay_id` INT NOT NULL 
COMMENT 'foreign key' , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE  `frontweb_junior_ministay_walking_tour` ( `id` INT NOT NULL AUTO_INCREMENT , 
`file_name` VARCHAR(200) NULL , `file_description` TEXT NULL , `junior_ministay_id` INT NOT NULL COMMENT 
'foreign key' , PRIMARY KEY (`id`)) ENGINE = MyISAM;


/* Date: 21-Dec-2017 | Sourav Dhara */

CREATE TABLE  `frontweb_junior_ministay_program` ( `junior_ministay_program_id` INT NOT NULL 
AUTO_INCREMENT COMMENT 'primary key' , `program_id` INT NULL , `program_details` TEXT NULL , `junior_ministay_id` 
INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY (`junior_ministay_program_id`)) ENGINE = MyISAM;

CREATE TABLE  `frontweb_junior_ministay_dates` ( `junior_ministay_dates_id` INT NOT NULL AUTO_INCREMENT 
COMMENT 'primary key' , `date` DATE NULL , `overnight` VARCHAR(255) NULL , `junior_ministay_id` INT NOT NULL COMMENT 
'foreign key' , PRIMARY KEY (`junior_ministay_dates_id`)) ENGINE = MyISAM;

CREATE TABLE  `frontweb_junior_ministay_dates_program` ( `junior_ministay_dates_program_id` INT NOT 
NULL AUTO_INCREMENT COMMENT 'primary key' , `program_id` INT NULL , `junior_ministay_dates_id` INT NOT NULL COMMENT 
'foreign key' , PRIMARY KEY (`junior_ministay_dates_program_id`)) ENGINE = MyISAM;

CREATE TABLE  `frontweb_junior_ministay_dates_week` ( `junior_ministay_dates_week_id` INT NOT NULL 
AUTO_INCREMENT COMMENT 'primary key' , `week` INT NULL , `junior_ministay_dates_id` INT NOT NULL COMMENT 'foreign key' , 
PRIMARY KEY (`junior_ministay_dates_week_id`)) ENGINE = MyISAM;

CREATE TABLE  `frontweb_junior_ministay_international_mix` ( `junior_ministay_international_mix_id` 
INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , `country_name` VARCHAR(255) NULL , `percentage` VARCHAR(200) NULL ,
 `color_code` VARCHAR(200) NULL , `junior_ministay_id` INT NOT NULL COMMENT 'foreign key' , 
 PRIMARY KEY (`junior_ministay_international_mix_id`)) ENGINE = MyISAM;



/* Date: 22-Dec-2017 | Sourav Dhara */
 
CREATE TABLE  `frontweb_junior_ministay_static_program` ( `junior_ministay_static_program_id` INT NOT NULL
 AUTO_INCREMENT COMMENT 'primary key' , `program_name` VARCHAR(200) NOT NULL , `logo` VARCHAR(200) NOT NULL , PRIMARY KEY
 (`junior_ministay_static_program_id`)) ENGINE = MyISAM;
 
INSERT INTO `frontweb_junior_ministay_static_program` (`junior_ministay_static_program_id`, `program_name`, `logo`) 
VALUES (NULL, 'UK Residential', 'united_kingdom.png'), (NULL, 'Uk Family Stay', 'united_kingdom.png'), 
(NULL, 'Scotland Residential', 'scotland.png'), (NULL, 'USA Family Stay', 'usa.png');

CREATE TABLE  `frontweb_junior_ministay_section` ( `junior_ministay_section_id` INT NOT NULL AUTO_INCREMENT 
COMMENT 'primary key' , `static_program_id` INT NULL , `junior_ministay_id` INT NOT NULL COMMENT 'foreign key' , 
PRIMARY KEY (`junior_ministay_section_id`)) ENGINE = MyISAM;



/* Date: 26-Dec-2017 | Sourav Dhara */

CREATE TABLE  `frontweb_adult_course_brochure` ( `id` INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , 
`file_name` VARCHAR(255) NULL , `file_description` TEXT NULL , `course_id` INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY 
(`id`)) ENGINE = MyISAM;



/* Date: 27-Dec-2017 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_manage_application_form` ( `manage_application_form_id` INT NOT NULL AUTO_INCREMENT 
COMMENT 'primary key' , `label_name` INT NULL , `field_type` INT NULL , `required_flag` TINYINT(1) NOT NULL DEFAULT '0' 
COMMENT '1:required & 0:not required' , PRIMARY KEY (`manage_application_form_id`)) ENGINE = MyISAM;

ALTER TABLE `frontweb_manage_application_form` ADD `multiple_value` TEXT NULL AFTER `required_flag`;

ALTER TABLE `frontweb_manage_application_form` CHANGE `label_name` `label_name` TEXT NULL DEFAULT NULL, 
CHANGE `field_type` `field_type` VARCHAR(200) NULL DEFAULT NULL;


/* Date: 28-Dec-2017 | Sourav Dhara */

ALTER TABLE `frontweb_manage_application_form` ADD `sequence` INT NULL AFTER `multiple_value`;

CREATE TABLE `vision_plus`.`frontweb_application_form_data` ( `application_form_data_id` INT NOT NULL AUTO_INCREMENT 
COMMENT 'primary key' , `field_name` TEXT NULL , `field_value` TEXT NULL , `user` INT NULL , `added_date` DATETIME NULL , 
PRIMARY KEY (`application_form_data_id`)) ENGINE = MyISAM;



/* Date: 04-Jan-2018 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_plus_video` ( `plus_video_id` INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , 
`video_url` VARCHAR(255) NULL , `description` TEXT NULL , `video_image` VARCHAR(200) NULL , `sequence` INT NULL , 
`centre` INT NULL , PRIMARY KEY (`plus_video_id`)) ENGINE = MyISAM;



/* Date: 11-Jan-2018 | Sourav Dhara */

ALTER TABLE `frontweb_plus_video`
  DROP `video_url`,
  DROP `description`,
  DROP `video_image`,
  DROP `sequence`;
  
ALTER TABLE `frontweb_plus_video` ADD `password` VARCHAR(255) NULL AFTER `centre`;



/* Date: 12-Jan-2018 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_plus_walking_tour` ( `plus_walking_tour_id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `centre_id` INT NULL , `video` VARCHAR(255) NULL , `description` TEXT NULL , PRIMARY KEY 
(`plus_walking_tour_id`)) ENGINE = MyISAM;




/* Date: 17-Jan-2018 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_plus_activity` ( `plus_activity_id` INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , 
`centre_id` INT NULL , `file_name` VARCHAR(255) NULL , `description` TEXT NULL , `added_date` DATE NULL , PRIMARY KEY 
(`plus_activity_id`)) ENGINE = MyISAM;

ALTER TABLE `frontweb_plus_activity` ADD `name` VARCHAR(255) NULL AFTER `plus_activity_id`;

ALTER TABLE `frontweb_plus_activity` ADD `status` TINYINT(1) NOT NULL COMMENT '1:Active & 0:Inactive' 
AFTER `added_date`, ADD `delete_flag` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0:not delete and 1:deleted' AFTER `status`;

ALTER TABLE `frontweb_plus_activity` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1:Active & 0:Inactive';




/* Date: 22-Jan-2018 | Sourav Dhara */

ALTER TABLE `frontweb_program_banner_language` ADD `more_link` VARCHAR(255) NULL AFTER `program_id`;




/* Date: 25-Jan-2018 | Sourav Dhara */

ALTER TABLE `frontweb_plus_video` ADD `manager_password` VARCHAR(255) NULL AFTER `password`;



/* Date: 02-Feb-2018 | Sourav Dhara */

ALTER TABLE `frontweb_plus_activity` DROP `file_name`;

CREATE TABLE `vision_plus`.`frontweb_plus_activity_file` ( `plus_activity_file_id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `file_name` VARCHAR(255) NULL , `plus_activity_id` INT NOT NULL , PRIMARY KEY (`plus_activity_file_id`)) 
ENGINE = MyISAM;



/* Date: 08-Feb-2018 | Sourav Dhara */

ALTER TABLE `frontweb_program_course` ADD `sequence_slug` VARCHAR(255) NULL AFTER `program_front_image`;

UPDATE `frontweb_program_course` SET `sequence_slug` = 'classic' WHERE `frontweb_program_course`.`program_course_id` = 1; 
UPDATE `frontweb_program_course` SET `sequence_slug` = 'classic-premium' WHERE `frontweb_program_course`.`program_course_id` = 2; 
UPDATE `frontweb_program_course` SET `sequence_slug` = 'classic-plus-academy' WHERE `frontweb_program_course`.`program_course_id` = 3; 
UPDATE `frontweb_program_course` SET `sequence_slug` = 'classic-premium-plus-academy' WHERE `frontweb_program_course`.`program_course_id` = 4; 
UPDATE `frontweb_program_course` SET `sequence_slug` = 'experience' WHERE `frontweb_program_course`.`program_course_id` = 5; 
UPDATE `frontweb_program_course` SET `sequence_slug` = 'classic-superior' WHERE `frontweb_program_course`.`program_course_id` = 6; 
UPDATE `frontweb_program_course` SET `sequence_slug` = 'classic-premium-plus-weekend-away' WHERE `frontweb_program_course`.`program_course_id` = 7; 



/* Date: 09-Feb-2018 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_extra_section` ( `extra_section_id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `course_id` INT NULL , `name` VARCHAR(255) NULL , `slug` VARCHAR(255) NULL , PRIMARY KEY 
(`extra_section_id`)) ENGINE = MyISAM;

CREATE TABLE `vision_plus`.`frontweb_extra_section_content` ( `extra_section_content_id` INT NOT NULL AUTO_INCREMENT 
COMMENT 'primary key' , `centre_id` INT NULL , `extra_section_id` INT NOT NULL COMMENT 'foreign key' , `description` 
TEXT NULL , `file_name` VARCHAR(255) NULL , PRIMARY KEY (`extra_section_content_id`)) ENGINE = MyISAM;



/* Date: 13-Feb-2018 | Sourav Dhara */

ALTER TABLE `frontweb_junior_ministay_static_program` ADD `description` TEXT NULL AFTER `program_name`;

ALTER TABLE `frontweb_junior_ministay_static_program` ADD `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 
'1:Active , 0:inactive' AFTER `logo`, ADD `delete_flag` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 
'0:not delete and 1:deleted' AFTER `status`;



/* Date: 14-Feb-2018 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_manage_adult_course` ( `adult_course_id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `title` VARCHAR(255) NULL , `description` TEXT NULL , `image` VARCHAR(255) NULL , `status` TINYINT(1) 
NOT NULL DEFAULT '1' COMMENT '1 : Active & 0 : Inactive' , `delete_flag` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 
'0:not delete & 1:delete' , PRIMARY KEY (`adult_course_id`)) ENGINE = MyISAM;



/* Date: 16-Feb-2018 | Sourav Dhara */

ALTER TABLE `frontweb_manage_adult_course` ADD `slug` VARCHAR(255) NULL AFTER `title`;



/* Date: 19-Feb-2018 | Sourav Dhara */

ALTER TABLE `frontweb_plus_activity` ADD `front_image` VARCHAR(255) NULL AFTER `description`;



/* Date: 21-Feb-2018 | Sourav Dhara */

ALTER TABLE `frontweb_junior_centre` ADD `accommodation` TEXT NULL AFTER `centre_banner`, ADD `course` TEXT NULL AFTER `accommodation`;

ALTER TABLE `frontweb_junior_ministay` ADD `accommodation` TEXT NULL AFTER `course_show_flag`, ADD `course` TEXT NULL AFTER `accommodation`;



/* Date: 23-Feb-2018 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_walking_tour_centre_details` ( `walking_tour_centre_details_id` INT NOT NULL 
AUTO_INCREMENT COMMENT 'primary key' , `centre_id` INT NULL , `icon_class` VARCHAR(255) NULL , `title` VARCHAR(255) NULL ,
 `details` TEXT NULL , PRIMARY KEY (`walking_tour_centre_details_id`)) ENGINE = MyISAM; 
 
ALTER TABLE `frontweb_walking_tour_centre_details` ADD `sequence` INT NULL AFTER `details`;



/* Date: 26-Feb-2018 | Sourav Dhara */

ALTER TABLE `frontweb_plus_activity` ADD `show_text` VARCHAR(255) NULL AFTER `added_date`;

ALTER TABLE `frontweb_plus_activity` ADD `show_type` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1 : upload image & 2 : enter text' AFTER `added_date`; 



/* Date: 27-Feb-2018 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_fixed_day_activity` ( `fixed_day_activity_id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `centre_id` INT NULL , `date` DATE NULL , PRIMARY KEY (`fixed_day_activity_id`)) ENGINE = MyISAM;

CREATE TABLE `vision_plus`.`frontweb_fixed_day_activity_details` ( `fixed_day_activity_details_id` INT NOT NULL AUTO_INCREMENT 
COMMENT 'primary key' , `program_name` VARCHAR(255) NULL , `location` VARCHAR(255) NULL , `activity` VARCHAR(255) NULL , 
`from_time` TIME NULL , `to_time` TIME NULL , `managed_by` INT NULL , `fixed_day_activity_id` INT NOT NULL COMMENT 
'foreign key' , PRIMARY KEY (`fixed_day_activity_details_id`)) ENGINE = MyISAM; 



/* Date: 28-Feb-2018 | Sourav Dhara */

ALTER TABLE `frontweb_fixed_day_activity_details` CHANGE `managed_by` `managed_by` VARCHAR(255) NULL DEFAULT NULL; 


/* Date: 12-Mar-2018 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_extra_day_activity` ( `extra_day_activity_id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `centre_id` INT NULL , `group_name` INT NULL , `date` DATE NULL , PRIMARY KEY 
(`extra_day_activity_id`)) ENGINE = MyISAM; 

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/* Date: 14-Mar-2018 | Sourav Dhara */

ALTER TABLE `frontweb_plus_activity` ADD `sequence` INT NULL AFTER `show_text`; 

/* ----------------------------Not Executed---------------------------- */

/* Date: 20-Mar-2018 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_student_group` ( `student_group_id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `centre_id` INT NULL , `group_name` VARCHAR(255) NULL , `group_strength` INT NULL , `status` 
TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1 : Active & 0 : Inactive' , `delete_flag` TINYINT(1) NOT NULL 
DEFAULT '0' COMMENT '0:not delete & 1:delete' , PRIMARY KEY (`student_group_id`)) ENGINE = MyISAM;


/* Date: 22-Mar-2018 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_master_activity` ( `master_activity_id` INT NOT NULL AUTO_INCREMENT COMMENT
 'primary key' , `centre_id` INT NULL , `activity_name` VARCHAR(255) NULL , `arrival_date` DATE NULL , 
 `departure_date` DATE NULL , `student_group` INT NULL , PRIMARY KEY (`master_activity_id`)) ENGINE = MyISAM; 

ALTER TABLE `frontweb_fixed_day_activity` CHANGE `centre_id` `master_activity_id` INT(11) NULL DEFAULT NULL COMMENT 'foreign key'; 


/* Date: 28-Mar-2018 | Sourav Dhara */

CREATE TABLE `vision_plus`.`frontweb_extra_master_activity` ( `extra_master_activity_id` INT NOT NULL AUTO_INCREMENT COMMENT 
'primary key' , `centre_id` INT NULL , `student_group` INT NULL , `group_reference_id` INT NULL , PRIMARY KEY 
(`extra_master_activity_id`)) ENGINE = MyISAM; 

ALTER TABLE `frontweb_extra_day_activity` DROP `group_name`;

ALTER TABLE `frontweb_extra_day_activity` CHANGE `centre_id` `extra_master_activity_id` INT(11) NULL DEFAULT NULL COMMENT 'foreign key'; 