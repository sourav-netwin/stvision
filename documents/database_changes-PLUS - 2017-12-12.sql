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

CREATE TABLE `frontweb_junior_centre_dates` ( `junior_centre_dates_id` INT 
NOT NULL AUTO_INCREMENT COMMENT 'primary key' , `date` DATE NULL , `overnight` VARCHAR(255) NULL ,
 `junior_centre_id` INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY (`junior_centre_dates_id`)) ENGINE = MyISAM;
 
CREATE TABLE `frontweb_junior_centre_dates_week` ( `junior_centre_dates_week_id` 
INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , `week` INT NULL , `junior_centre_dates_id` 
INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY (`junior_centre_dates_week_id`)) ENGINE = MyISAM;

CREATE TABLE `frontweb_junior_centre_dates_program` ( `junior_centre_dates_program_id` 
INT NOT NULL AUTO_INCREMENT COMMENT 'primary key' , `program_id` INT NULL , `junior_centre_dates_id` 
INT NOT NULL COMMENT 'foreign key' , PRIMARY KEY (`junior_centre_dates_program_id`)) ENGINE = MyISAM;

/* Date: 08-Dec-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'CMS pages', '', 'frontweb/cmsmenu', '1', '2', 'Left', '5', '', '2017-12-05 00:00:00', '1', '2017-12-05 00:00:00', '1', '0');

/* Date: 11-Dec-2017 Sandip Kalbhile */
CREATE TABLE `frontweb_contentmst` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Content Master table';

CREATE TABLE `frontweb_menumst` (
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Menu Details';