/* Date: 12-Apr-2016 | Sandip Kalbhile */
ALTER TABLE `plused_teacher_application` ADD `ta_ni_number` VARCHAR( 100 ) NOT NULL AFTER `ta_signed_offer_received` ,
ADD `ta_right_to_work_uk` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `ta_ni_number` ,
ADD `ta_ni_category` VARCHAR( 100 ) NOT NULL AFTER `ta_right_to_work_uk` ,
ADD `ta_making_slr` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT 'Are you making Student Loan Repayments? Yes/No 	if yest ask for Plan 1 / Plan 2' AFTER `ta_ni_category` ,
ADD `ta_slr_plan` VARCHAR( 20 ) NOT NULL AFTER `ta_making_slr` ,
ADD `ta_p45_status` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT 'Will you provide a P45 when you start?' AFTER `ta_slr_plan` ,
ADD `ta_p45_starter_declaration` VARCHAR( 20 ) NOT NULL COMMENT 'P45, If No please select 1 starter declaration A/B/C' AFTER `ta_p45_status`;

CREATE TABLE IF NOT EXISTS `pulsed_teachers_bank_detail` (
  `tbd_id` int(11) NOT NULL AUTO_INCREMENT,
  `tbd_user_id` int(11) NOT NULL,
  `tbd_currency_type` enum('GBP','Overseas') NOT NULL,
  `tbd_account_name` varchar(255) NOT NULL,
  `tbd_sort_code` varchar(100) NOT NULL,
  `tbd_account_number` varchar(100) NOT NULL,
  `tbd_iban` varchar(255) NOT NULL,
  `tbd_swift_bic` varchar(255) NOT NULL,
  `tbd_created_on` datetime NOT NULL,
  `tbd_created_by` int(11) NOT NULL,
  PRIMARY KEY (`tbd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

/* Date: 15-Apr-2016 | Sandip Kalbhile */
ALTER TABLE `plused_teacher_application` ADD `ta_read_cv` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `ta_signed_offer_received`;

/* Date: 25-04-2016 | Sandip Kalbhile */
ALTER TABLE `pulsed_job_contract` ADD `joc_contract_signed` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `joc_returnee`;


/* Date: 25-04-2016 | Arunsankar */
CREATE TABLE `plused_temp_campus` (  `tec_id` int(11) NOT NULL AUTO_INCREMENT,  `template` varchar(20) NOT NULL,  `centri_id` int(11) NOT NULL,  `tec_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  `tec_updated_on` timestamp NULL DEFAULT NULL,  PRIMARY KEY (`tec_id`));

/* Date: 27-04-2016 | Sandip Kalbhile */
ALTER TABLE `pulsed_job_contract` ADD `joc_contract_file` VARCHAR( 255 ) NOT NULL AFTER `joc_contract_signed`;


/*Date: 03-May-2016 | Arunsankar S*/
ALTER TABLE `plused_rows` ADD `lockPax` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `lang_knowledge`
ALTER TABLE `plused_rows` ADD `template` VARCHAR( 10 ) NULL DEFAULT NULL AFTER `lockPax` , ADD `template_date` TIMESTAMP NULL DEFAULT NULL AFTER `template`;
ALTER TABLE `plused_book` ADD `template` VARCHAR( 10 ) NULL DEFAULT NULL AFTER `flag_gl_compliant` ,ADD `template_date` TIMESTAMP NULL DEFAULT NULL AFTER `template`;

/*Date: 04-May-2016 | Arunsankar S*/
CREATE TABLE `plused_nationality` (  `nat_id` int(11) NOT NULL AUTO_INCREMENT,  `nationality` varchar(50) NOT NULL,  `active` tinyint(4) NOT NULL DEFAULT '1',  PRIMARY KEY (`nat_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1

/* Date: 02-05-2016 | Sandip Kalbhile*/
ALTER TABLE `pulsed_job_contract` ADD `joc_staff_priority` INT( 10 ) NOT NULL DEFAULT '0' AFTER `joc_contract_file`;

/* Date: 06-05-2016 | Arunsankar S*/
ALTER TABLE `plused_nationality` ADD `continent` varchar( 50 ) DEFAULT NULL AFTER `nationality`;

CREATE TABLE `plused_temp_nationality` (  `ten_id` int(11) NOT NULL AUTO_INCREMENT,  `template` varchar(20) NOT NULL,  `nat_id` int(11) NOT NULL,  `ten_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  `ten_updated_on` timestamp NULL DEFAULT NULL,  PRIMARY KEY (`ten_id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/* Date: 12-05-2016 | Arunsankar S*/
CREATE TABLE `plused_roster_supplement_types` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `description` varchar(50) NOT NULL,  PRIMARY KEY (`id`),  UNIQUE KEY `description` (`description`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `plused_roster_supplements` (  `plr_id` int(11) NOT NULL AUTO_INCREMENT,  `supl_id` int(11) NOT NULL,  `centri_id` int(11) NOT NULL,  `description` varchar(50) NOT NULL,  `active` tinyint(4) NOT NULL DEFAULT '1',  PRIMARY KEY (`plr_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `plused_pax_supplement` (  `plx_id` int(11) NOT NULL AUTO_INCREMENT,  `uuid` varchar(12) NOT NULL,  `plr_id` int(11) NOT NULL,  PRIMARY KEY (`plx_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* Date: 20-05-2016 | Sandip Kalbhile */
INSERT INTO `plused_job_positions` (`pos_id`, `pos_position`, `pos_created_on`) VALUES
(4, 'Activity Leader', '2016-05-19 00:00:00'),
(5, 'Choreographer', '2016-05-20 00:00:00'),
(6, 'Excursion Guide', '2016-05-20 00:00:00');

/* Date: 01-June-2016 | Sandip Kalbhile */
ALTER TABLE `plused_class_students` CHANGE `cs_booking_id` `cs_booking_id` VARCHAR( 12 ) NOT NULL COMMENT 'Reference to students';
CREATE TABLE IF NOT EXISTS `plused_language_knowledge` (
  `lk_id` int(11) NOT NULL AUTO_INCREMENT,
  `lk_uuid` varchar(100) NOT NULL,
  `lk_lang_knowledge` int(11) NOT NULL,
  `lk_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`lk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


/*Date: 08-June-2016 | Arunsankar */
CREATE TABLE `plused_ticket_cm` (  `ptc_id` int(11) NOT NULL AUTO_INCREMENT,  `campus_id` int(11) NOT NULL,  `ptc_priority` varchar(10) NOT NULL,  `ptc_category` varchar(50) NOT NULL,  `ptc_title` varchar(100) NOT NULL,  `ptc_content` varchar(2000) NOT NULL,  `ptc_attachment` varchar(260) NOT NULL,  `ptc_ref_booking` varchar(50) NOT NULL,  `ptc_bo_reply` varchar(2000) NOT NULL,  `ptc_bo_attachment` varchar(255) NOT NULL,  `ptc_bo_reply_time` timestamp NULL DEFAULT NULL,  `ptc_bo_reply_by` int(11) NOT NULL,  `ptc_closed` tinyint(4) NOT NULL DEFAULT '0',  `ptc_created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  `ptc_created_by` int(11) NOT NULL,  `ptc_active` tinyint(4) NOT NULL DEFAULT '1',  PRIMARY KEY (`ptc_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;


/* Date: 10-Jun-2016 | Sandip Kalbhile */
ALTER TABLE `plused_nationality` ADD `nat_flag` VARCHAR( 255 ) NOT NULL AFTER `continent`;

/*Date: 14-June-2016 | Arunsankar */
ALTER TABLE `plused_ticket_cm` ADD `ptc_cm_read` TINYINT NOT NULL DEFAULT '0' AFTER `ptc_closed` , ADD `ptc_bo_read` TINYINT NOT NULL DEFAULT '0' AFTER `ptc_cm_read`

/*Date: 15-June-2016 | Preeti M */
INSERT INTO `members` (`id`, `first_name`, `last_name`, `username`, `password`, `email`, `role`, `campusid_ref`) VALUES (NULL, 'test', 'user', 'testuser', 'password', 'testuser@test.com', 'webservice_user', '0');

/*Date: 17-June-2016 | Preeti M */
CREATE TABLE IF NOT EXISTS `webservice_book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_prenotazione` int(11) NOT NULL,
  `id_passeggero` int(11) NOT NULL,
  `passeggero` varchar(255) NOT NULL,
  `tipologia_passeggero` varchar(4) NOT NULL,
  `glf` varchar(3) NOT NULL,
  `glf_id_genitore` int(11) NOT NULL,
  `glf_genitore_nominativo` varchar(255) NOT NULL,
  `id_accompagnatore` int(11) NOT NULL,
  `accompagnatore` varchar(255) NOT NULL,
  `id_collaboratore` int(11) NOT NULL,
  `collaboratore` varchar(255) NOT NULL,
  `codice_prodotto` varchar(255) NOT NULL,
  `prodotto` varchar(255) NOT NULL,
  `codice_destinazione` varchar(255) NOT NULL,
  `destinazione` varchar(255) NOT NULL,
  `data_iniziale` datetime NOT NULL,
  `data_finale` datetime NOT NULL,
  `sistemazione` varchar(255) NOT NULL,
  `costo_base` int(11) NOT NULL,
  `importo_tasse_volo` float NOT NULL,
  `importo_aeroporto_aggiuntivo` int(11) NOT NULL,
  `supplementi` float NOT NULL,
  `trinity` int(11) NOT NULL,
  `magic_eu` int(11) NOT NULL,
  `sup_magic_eu` int(11) NOT NULL,
  `magic_usa` int(11) NOT NULL,
  `sup_magic_usa` int(11) NOT NULL,
  `pagamenti` int(11) NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `plused_ticket_cm` ADD `ptc_cm_read` TINYINT NOT NULL DEFAULT '0' AFTER `ptc_closed` , ADD `ptc_bo_read` TINYINT NOT NULL DEFAULT '0' AFTER `ptc_cm_read`;

/*Date: 16-June-2016 | Arunsankar */
ALTER TABLE `plused_ticket_cm` ADD `ptc_closed_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `ptc_closed` ;

/*Date: 23-Jun-2016 | Sandip Kalbhile */
ALTER TABLE `pulsed_class_lessons` CHANGE `cl_teacher_id` `cl_teacher_id` INT( 11 ) NOT NULL COMMENT 'Its teachers contract id, Ref. id from pulsed_job_contract table';


/*Date: 29-June-2016 | Arunsankar*/
CREATE TABLE `plused_fincm_payments` ( `pcp_id` int(10) unsigned NOT NULL AUTO_INCREMENT, `campus_id` int(10) unsigned NOT NULL,`pcp_book_id` int(9) NOT NULL,`pcp_ref_book` int(9) DEFAULT NULL, `pcp_amount` varchar(10) COLLATE utf8_unicode_ci NOT NULL, `pcp_currency` varchar(3) COLLATE utf8_unicode_ci NOT NULL, `pcp_pay_date` date DEFAULT NULL, `pcp_added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, `pcp_pay_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL, `pcp_service` varchar(20) COLLATE utf8_unicode_ci NOT NULL, `pcp_method` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,`pcp_document` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,PRIMARY KEY (`pcp_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `plused_fincm_services` (  `pcse_id` int(10) unsigned NOT NULL AUTO_INCREMENT,  `pcse_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,  `pcse_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  PRIMARY KEY (`pcse_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Date: 29-Jun-2016 | Sandip Kalbhile */
ALTER TABLE `plused_teacher_application` ADD `ta_passport_or_id_card` VARCHAR( 255 ) NOT NULL COMMENT 'users passport or id card uploaded' AFTER `ta_other_document`;

/*Date: 29-Jun-2016 | Sandip Kalbhile */
ALTER TABLE `pulsed_class_lessons` ADD `cl_course_director_marked` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT 'flag to know that course director has marked teachers status present/absent' AFTER `cl_presence_of_teacher`;

/*Date: 07-July-2016 | Arunsankar*/
ALTER TABLE plused_fincm_payments MODIFY pcp_book_id VARCHAR(50);

/*Date: 30-June-2016 | Preeti M */
CREATE TABLE IF NOT EXISTS `pax_level` (
  `pl_id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(2) NOT NULL,
  `level` varchar(10) NOT NULL,
  `service` varchar(18) NOT NULL,
  `min_pax` int(11) NOT NULL,
  `max_pax` int(11) NOT NULL,
  `accomodation` varchar(10) NOT NULL,
  `product` varchar(10) NOT NULL,
  `reimbursement` int(11) NOT NULL,
  PRIMARY KEY (`pl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/* Date: 12-July-2016 Sandip Kalbhile */
CREATE TABLE IF NOT EXISTS `plused_job_contract_rating` (
  `rat_id` int(11) NOT NULL AUTO_INCREMENT,
  `rat_contract_id` int(11) NOT NULL,
  `rat_application_id` int(11) NOT NULL,
  `rat_stars` int(11) NOT NULL,
  `rat_review_text` varchar(300) NOT NULL,
  PRIMARY KEY (`rat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


/* Date: 18-Jul-2016 Sandip Kalbhile */
--
-- Table structure for table `plused_test_answers`
--

CREATE TABLE IF NOT EXISTS `plused_test_answers` (
  `tans_id` int(11) NOT NULL AUTO_INCREMENT,
  `tans_opt_id` int(11) NOT NULL COMMENT 'This will be the answer mark by students',
  `tans_uuid` varchar(100) NOT NULL COMMENT 'ref. key of plused row',
  `tans_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'question attempted timestamp',
  PRIMARY KEY (`tans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `plused_test_options`
--

CREATE TABLE IF NOT EXISTS `plused_test_options` (
  `opt_id` int(11) NOT NULL AUTO_INCREMENT,
  `opt_que_id` int(11) NOT NULL COMMENT 'Foreign key for question table',
  `opt_text` varchar(255) NOT NULL,
  `opt_correct_answer` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'This will be the flag to mark correct answer',
  PRIMARY KEY (`opt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `plused_test_question`
--

CREATE TABLE IF NOT EXISTS `plused_test_question` (
  `tque_id` int(11) NOT NULL AUTO_INCREMENT,
  `tque_test_id` int(11) NOT NULL COMMENT 'Test foreign key',
  `tque_question` varchar(500) NOT NULL,
  `tque_section` varchar(255) NOT NULL COMMENT 'this is to categories question like Accomadation, tuition',
  PRIMARY KEY (`tque_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `plused_test_student`
--

CREATE TABLE IF NOT EXISTS `plused_test_student` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
  `test_type` enum('Survey','Test') NOT NULL COMMENT 'This for type Survey or Test',
  `test_title` varchar(255) NOT NULL COMMENT 'this will be the test title',
  PRIMARY KEY (`test_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/* Date: 18-Jul-2016 Arun Sankar */
ALTER TABLE `plused_test_answers` ADD `tans_week` INT( 11 ) NOT NULL AFTER `tans_date`;
/* Date: 19-Jul-2016 Arun Sankar */
ALTER TABLE `plused_test_answers` ADD `trans_survey_value` INT NOT NULL AFTER `tans_week`;
ALTER TABLE `plused_test_answers` CHANGE `tans_week` `tans_week` VARCHAR( 50 ) NOT NULL ;
/* Date: 20-Jul-2016 Arun Sankar */
ALTER TABLE `plused_test_submited` ADD `ts_week` VARCHAR( 50 ) NOT NULL AFTER `ts_test_id`

/* Date: 19-Jul-2016 Sandip Kalbhile */
ALTER TABLE `plused_test_answers` ADD `tans_ques_id` INT( 11 ) NOT NULL AFTER `tans_id`;
ALTER TABLE `plused_test_answers` CHANGE `tans_date` `tans_date` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'question attempted timestamp';

/* Date: 20-Jul-2016 Sandip Kalbhile */
CREATE TABLE IF NOT EXISTS `plused_test_submited` (
  `ts_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Test submited pk',
  `ts_uuid` int(11) NOT NULL COMMENT 'Fk for students plused row',
  `ts_test_id` int(11) NOT NULL COMMENT 'Fk for test table which is submited by students',
  `ts_submitted_on` datetime NOT NULL COMMENT 'Date of test submitted',
  PRIMARY KEY (`ts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/* Date: 20-Jul-2016 Arunsankar */
ALTER TABLE `plused_test_submited` CHANGE `ts_uuid` `ts_uuid` VARCHAR( 50 ) NOT NULL COMMENT 'Fk for students plused row';

/* Date: 25-Jul-2016 Preeti M */

CREATE TABLE IF NOT EXISTS `st_history` (
  `sh_id` int(11) NOT NULL AUTO_INCREMENT,
  `anno` year(4) NOT NULL,
  `id_prenotazione` int(11) NOT NULL,
  `id_prenotazione_web` int(11) NOT NULL,
  `data_prenotazione` datetime NOT NULL,
  `id_opzione` int(11) NOT NULL,
  `opzione_pax` int(11) NOT NULL,
  `opzione_opzionato` tinyint(1) NOT NULL,
  `id_nominativo_opzione` int(11) NOT NULL,
  `nominativo_opzione` varchar(255) NOT NULL,
  `id_collaboratore` int(11) NOT NULL,
  `collaboratore` varchar(255) NOT NULL,
  `id_accompagnatore` int(11) NOT NULL,
  `accompagnatore` varchar(255) NOT NULL,
  `accompagantore_azienda` varchar(255) NOT NULL,
  `id_passeggero` int(11) NOT NULL,
  `passeggero` varchar(255) NOT NULL,
  `passeggero_azienda` varchar(255) NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `provincia` varchar(2) NOT NULL,
  `comune` varchar(255) NOT NULL,
  `cap` int(11) NOT NULL,
  `data_iscrizione` datetime NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `indirizzo_spedizione` varchar(50) NOT NULL,
  `cap_spedizione` varchar(255) NOT NULL,
  `comune_spedizione` varchar(255) NOT NULL,
  `provincia_spedizione` varchar(255) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `fax` varchar(25) NOT NULL,
  `cellulare` varchar(25) NOT NULL,
  `telefono_estivo` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `partita_iva` int(11) NOT NULL,
  `codice_fiscale` varchar(50) NOT NULL,
  `id_tipologia_cliente` int(11) NOT NULL,
  `tipo_cliente` varchar(25) NOT NULL,
  `data_nascita` datetime NOT NULL,
  `comune_nascita` varchar(255) NOT NULL,
  `comune_codice_nascita` varchar(255) NOT NULL,
  `provincia_nascita` varchar(2) NOT NULL,
  `nazione_nascita` varchar(255) NOT NULL,
  `email_riferimento` varchar(50) NOT NULL,
  `sesso` varchar(1) NOT NULL,
  `uscita_serale` enum('SI','NO') NOT NULL,
  `salute` varchar(255) NOT NULL,
  `figli` tinyint(1) NOT NULL,
  `stato_civile` enum('SI','NO') NOT NULL,
  `coniuge` varchar(50) NOT NULL,
  `coniuge_societa` varchar(255) NOT NULL,
  `coniuge_professione` varchar(255) NOT NULL,
  `tipologia_scuola` varchar(255) NOT NULL,
  `materia` varchar(255) NOT NULL,
  `lingua` varchar(255) NOT NULL,
  `opera_settore` enum('SI','NO') NOT NULL,
  `itc` enum('SI','NO') NOT NULL,
  `collaboratore_passato` enum('SI','NO') NOT NULL,
  `azienda` varchar(255) NOT NULL,
  `id_azienda` int(11) NOT NULL,
  `padre_nome` varchar(50) NOT NULL,
  `padre_cognome` varchar(50) NOT NULL,
  `padre_cellulare` varchar(25) NOT NULL,
  `padre_telefono` varchar(25) NOT NULL,
  `padre_email` varchar(50) NOT NULL,
  `padre_professione` varchar(255) NOT NULL,
  `padre_data_nascita` datetime NOT NULL,
  `madre_nome` varchar(50) NOT NULL,
  `madre_cognome` varchar(50) NOT NULL,
  `madre_cellulare` varchar(25) NOT NULL,
  `madre_telefono` varchar(25) NOT NULL,
  `madre_email` varchar(50) NOT NULL,
  `madre_professione` varchar(255) NOT NULL,
  `madre_data_nascita` datetime NOT NULL,
  `documento_tipologia` varchar(100) NOT NULL,
  `documento_numero` varchar(10) NOT NULL,
  `documento_data_rilascio` datetime NOT NULL,
  `documento_data_scadenza` datetime NOT NULL,
  `documento_luogo_rilascio` varchar(100) NOT NULL,
  `documento_rilasciato` varchar(255) NOT NULL,
  `documento_nazione` varchar(50) NOT NULL,
  `regione` varchar(50) NOT NULL,
  `macro_regione` varchar(10) NOT NULL,
  `nazione` varchar(10) NOT NULL,
  `id_corporate` int(11) NOT NULL,
  `tipo_fattura` varchar(20) NOT NULL,
  `glf` enum('SI','NO') NOT NULL,
  `pnr` varchar(20) NOT NULL,
  `data_partenza` datetime NOT NULL,
  `data_arrivo_ritorno` datetime NOT NULL,
  `apt_partenza` varchar(3) NOT NULL,
  `campus_data_arrivo` datetime NOT NULL,
  `campus_data_partenza` datetime NOT NULL,
  `codice_famiglia` varchar(255) NOT NULL,
  `famiglia` varchar(255) NOT NULL,
  `alloggiare` varchar(255) NOT NULL,
  `tipologia_passeggero` varchar(3) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `codice_prodotto` varchar(255) NOT NULL,
  `prodotto` varchar(255) NOT NULL,
  `tipologia_prodotto` varchar(255) NOT NULL,
  `pax` int(11) NOT NULL,
  `sistemazione` varchar(50) NOT NULL,
  `codice_destinazione` varchar(255) NOT NULL,
  `destinazione` varchar(255) NOT NULL,
  `destinazione_nazione` varchar(255) NOT NULL,
  `livello` varchar(255) NOT NULL,
  `costo_base` int(11) NOT NULL,
  `costo_arpt_aggiuntivo` int(11) NOT NULL,
  `supplementi` int(11) NOT NULL,
  `pagamenti` int(11) NOT NULL,
  PRIMARY KEY (`sh_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/* Date: 11-Aug-2016 Arunsankar */
ALTER TABLE `plused_survey_users` CHANGE `su_group_leader_id` `su_group_leader_uuid` VARCHAR( 50 ) NOT NULL COMMENT 'Group leader id ref. id from plused_row';

/* Date: 10-Aug-2016 Sandip Kalbhile
Please find below table .sql file in same dir. (plused_role_menu(+2 table).sql)
*/
ALTER TABLE `plused_role_menu` ADD `mnu_caption` VARCHAR(255) NOT NULL COMMENT 'This is the caption for menu if there are some duplicates' AFTER `mnu_menu_name`;

/* Date: 17-Aug-2016 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES
(47, 0, 'Role management', '', '', 1, 1, 'Left', 1, '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(48, 47, 'Roles', '', 'roles', 1, 2, 'Left', 1, '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(49, 47, 'Menu access', '', 'roleaccess', 1, 2, 'Left', 2, '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(50, 0, 'Dashboard', 'Group leader', 'survey/dashboard', 1, 1, 'Left', 1, '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(51, 0, 'Take the survey', '', '', 2, 1, 'Left', 1, '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(52, 51, 'Take survey 1', '', 'survey/view/report1', 1, 2, 'Left', 1, '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0),
(53, 51, 'Take survey 2', '', 'survey/view/report2', 1, 2, 'Left', 2, '2016-08-17 00:00:00', 1, '2016-08-17 00:00:00', 1, 0);

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES
(56, 5, 'Campus rooms', '', 'campusrooms', 1, 2, 'Left', 2, '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(55, 5, 'Courses', '', 'backoffice/campusCourses', 1, 2, 'Left', 1, '2016-08-19 00:00:00', 1, '2016-08-19 00:00:00', 1, 0),
(57, 5, 'Staff priority', '', 'staff/priority', 1, 2, 'Left', 3, '2016-08-22 00:00:00', 1, '2016-08-22 00:00:00', 1, 0),
(58, 5, 'Tuitions schedule', '', 'tuitions', 1, 2, 'Left', 4, '2016-08-23 00:00:00', 1, '2016-08-23 00:00:00', 1, 0),
(59, 56, 'Create new room', 'Internal link', 'campusrooms/addedit', 1, 3, 'Left', 1, '2016-08-23 00:00:00', 1, '2016-08-23 00:00:00', 1, 0),
(60, 55, 'Create new course', 'Internal link', 'backoffice/addcourse', 1, 3, 'Left', 1, '2016-08-23 00:00:00', 1, '2016-08-23 00:00:00', 1, 0);

/*Date: 24-Aug-2016 Arunsankar*/
UPDATE `plused_role_menu` SET `mnu_url` = 'survey/report' WHERE `plused_role_menu`.`mnu_menuid` =40;
UPDATE `plused_role_menu` SET `mnu_url` = 'survey/studentsreport' WHERE `plused_role_menu`.`mnu_menuid` =39;

/* Date: 25-Aug-2016 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '56', 'Delete room', 'Internal action', 'campusrooms/deleterooms', '1', '3', 'Left', '2', '2016-08-25 00:00:00', '1', '2016-08-25 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '55', 'Delete course', 'Internal action', 'backoffice/deletecourse', '1', '3', 'Left', '2', '2016-08-25 00:00:00', '1', '2016-08-25 00:00:00', '1', '0');
/*Date: 25-Aug-2016 Arunsankar*/
INSERT INTO `plused_role_menu` (
`mnu_menuid` ,
`mnu_parent_menu_id` ,
`mnu_menu_name` ,
`mnu_caption` ,
`mnu_url` ,
`mnu_status` ,
`mnu_level` ,
`mnu_type` ,
`mnu_sequence` ,
`mnu_created_on` ,
`mnu_created_by` ,
`mnu_modified_on` ,
`mnu_modified_by` ,
`is_deleted`
)
VALUES (
NULL , '0', 'Students', '', '', '1', '1', 'Left', '1', '2016-08-25 00:00:00', '123', '', '123', '0'
), (
NULL , '54', 'Test report', 'Student test report', 'studentsreport', '1', '2', 'Left', '2', '2016-08-25 00:00:00', '123', '2016-08-25 00:00:00', '123', '0'
);
INSERT INTO `plused_role_access` (
`acc_id` ,
`acc_role_id` ,
`acc_menu_id`
)
VALUES (
NULL , '100', '54'
), (
NULL , '100', '55'
);
INSERT INTO `plused_role_menu` (
`mnu_menuid` ,
`mnu_parent_menu_id` ,
`mnu_menu_name` ,
`mnu_caption` ,
`mnu_url` ,
`mnu_status` ,
`mnu_level` ,
`mnu_type` ,
`mnu_sequence` ,
`mnu_created_on` ,
`mnu_created_by` ,
`mnu_modified_on` ,
`mnu_modified_by` ,
`is_deleted`
)
VALUES (
NULL , '0', 'Excursion management', '', '', '1', '1', 'Left', '1', '2016-08-25 00:00:00', '123', '2016-08-25 00:00:00', '123', '0'
);
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '56', 'Join campus and companies', '', 'joincampuscompany', '1', '2', 'Left', '1', '2016-08-25 00:00:00', '123', '2016-08-25 00:00:00', '123', '0'), (NULL, '56', 'Export and import', '', 'excursionexportimport', '1', '2', 'Left', '2', '2016-08-25 00:00:00', '123', '2016-08-25 00:00:00', '123', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '56', 'Delete room', 'Internal action', 'campusrooms/deleterooms', '1', '3', 'Left', '2', '2016-08-25 00:00:00', '1', '2016-08-25 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '55', 'Delete course', 'Internal action', 'backoffice/deletecourse', '1', '3', 'Left', '2', '2016-08-25 00:00:00', '1', '2016-08-25 00:00:00', '1', '0');

/* Date: 26-Aug-2016 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '5', 'Class timetable', '', 'tuitions/plan', '1', '2', 'Left', '5', '2016-08-26 00:00:00', '1', '2016-08-26 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '5', 'Tuitions schedule report', '', 'tuitionsreports', '1', '2', 'Left', '6', '2016-08-26 00:00:00', '1', '2016-08-26 00:00:00', '1', '0');

/* Date: 29-Aug-2016 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '0', 'Teacher work report', '', 'tuitionsreports/teachers', '1', '2', 'Left', '7', '2016-08-29 00:00:00', '1', '2016-08-29 00:00:00', '1', '0');

/*Date: 30-Aug-2016 Arunsankar*/
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`)
VALUES (NULL, '40', 'View survey report', 'Internal link', 'survey/questionsreport', '1', '3', 'Left', '1', '2016-08-30 00:00:00', '123', '2016-08-30 00:00:00', '123', '0'),
(NULL, '39', 'Students report result', 'Internal link', 'survey/questionsstudentreport', '1', '3', 'Left', '1', '2016-08-30 00:00:00', '123', '2016-08-30 00:00:00', '123', '0'),
(NULL, '67', 'Excursion export', 'Internal link', 'excursionexportimport/export', '1', '3', 'Left', '1', '2016-08-30 00:00:00', '123', '2016-08-30 00:00:00', '123', '0'),
(NULL, '69', 'Join template campus submit', 'Internal link', 'jointemplatecampus/joinTempCamp', '1', '3', 'Left', '1', '2016-08-30 00:00:00', '123', '2016-08-30 00:00:00', '123', '0'),
(NULL, '71', 'Template nationality submit', 'Internal link', 'jointemplatenationality/joinTempNat', '1', '3', 'Left', '1', '2016-08-30 00:00:00', '123', '2016-08-30 00:00:00', '123', '0');
/*Date: 31-Aug-2016 Arunsankar*/
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '6', 'Contract', '', 'contract', '1', '2', 'Left', '1', '2016-08-31 00:00:00', '123', '2016-08-31 00:00:00', '123', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '6', 'Contract payrolls', '', 'contract/payrolls', '1', '2', 'Left', '2', '2016-08-31 00:00:00', '123', '2016-08-31 00:00:00', '123', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '86', 'Export contract', 'Internal link', 'contract/exportcontract', '1', '3', 'Top', '1', '2016-08-31 00:00:00', '123', '2016-08-31 00:00:00', '123', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '86', 'Contract add edit', 'Internal link', 'contract/addedit', '1', '3', 'Left', '2', '2016-08-31 00:00:00', '123', '2016-08-31 00:00:00', '123', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '86', 'Delete contract', '', 'contract/deletecontract', '1', '3', 'Left', '3', '2016-08-31 00:00:00', '123', '2016-08-31 00:00:00', '123', '0');

/* Date: 01-Sep-2016 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES
(NULL, 6, 'Teachers CV review', '', 'teachers/review', 1, 2, 'Left', 1, '2016-08-25 00:00:00', 1, '2016-08-25 00:00:00', 1, 0),
(NULL, 6, 'Job offer history', '', 'jobofferhistory', 1, 2, 'Left', 3, '2016-08-25 00:00:00', 1, '2016-08-25 00:00:00', 1, 0),
(NULL, 6, 'Teachers interviews', '', 'teachers/profilereview', 1, 2, 'Left', 2, '2016-08-25 00:00:00', 1, '2016-08-25 00:00:00', 1, 0);

INSERT INTO `plused_role` (
`role_id` ,
`role_name` ,
`role_created_on` ,
`role_is_active` ,
`role_is_deleted`
)
VALUES (
'500', 'Teacher',
CURRENT_TIMESTAMP , '1', '0'
);

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES
(NULL, 0, 'Dashboard', 'User section', 'users/dashboard', 1, 1, 'Left', 1, '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(NULL, 0, 'My account', 'User section', '', 1, 1, 'Left', 2, '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(NULL, 96, 'Personal information', 'User section', 'users/documents', 1, 2, 'Left', 1, '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(NULL, 96, 'Contracts', 'User contract', 'users/contracts', 1, 2, 'Left', 2, '2016-08-31 00:00:00', 123, '2016-08-31 00:00:00', 123, 0),
(NULL, 97, 'Edit profile', 'User section', 'users/editprofile', 1, 3, 'Left', 1, '2016-09-01 00:00:00', 123, '2016-09-01 00:00:00', 123, 0),
(NULL, 95, 'User profile', 'User section', 'users/profile', 1, 3, 'Left', 2, '2016-09-01 00:00:00', 123, '2016-09-01 00:00:00', 123, 0);

/* Date: 05-Sep-2016 Sandip Kalbhile */
INSERT INTO `plused_role` (`role_id`, `role_name`, `role_created_on`, `role_is_active`, `role_is_deleted`) VALUES ('400', 'Course Director', CURRENT_TIMESTAMP, '1', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '0', 'Edit application', 'Internal link', 'teachers/editapp', '1', '3', 'Left', '1', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid` ,`mnu_parent_menu_id` ,`mnu_menu_name` ,`mnu_caption` ,`mnu_url` ,`mnu_status` ,`mnu_level` ,`mnu_type` ,`mnu_sequence` ,`mnu_created_on` ,`mnu_created_by` ,`mnu_modified_on` ,`mnu_modified_by` ,`is_deleted`)
VALUES (
NULL , '56', 'View listing', 'for course director only', 'campusrooms/index', '1', '3', 'Left', '3', '2016-08-25 00:00:00', '1', '2016-08-25 00:00:00', '1', '0'
);

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '5', 'Language knowledge', '', 'tuitions/updatelang', '1', '2', 'Left', '2', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '5', 'Teachers details', '', 'tuitions/teachers', '1', '2', 'Left', '6', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '5', 'Teachers review', '', 'tuitions/teachersreview', '1', '2', 'Left', '7', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');


ALTER TABLE `plused_role_menu` ADD `mnu_icon_class` VARCHAR( 255 ) NOT NULL AFTER `mnu_sequence`;

/* Date: 20 Sept 2016 || Sandip Kalbhile */
ALTER TABLE `st_history` ADD `collaboratoreProvincia` VARCHAR( 255 ) NOT NULL AFTER `collaboratore` ,
ADD `collaboratoreNazione` VARCHAR( 255 ) NOT NULL AFTER `collaboratoreProvincia` ,
ADD `collaboratoreRegione` VARCHAR( 255 ) NOT NULL AFTER `collaboratoreNazione` ,
ADD `collaboratoreMacroRegione` VARCHAR( 255 ) NOT NULL AFTER `collaboratoreRegione`;

/* Date: 22-Sep-2016 Sandip Kalbhile */
INSERT INTO `vision_plus`.`plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '0', 'Enrol', '', '', '1', '1', 'Left', '3', 'fa-sign-in', '2014-12-20 06:55:49', '123', '2014-12-30 12:42:21', '123', '0');

INSERT INTO `vision_plus`.`plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '120', 'Enrol new group', '', 'agents/enrol', '1', '2', 'Left', '1', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

/* Date: 14-Oct-2016 Sandip Kalbhile */
INSERT INTO `vision_plus`.`members` (`id`, `first_name`, `last_name`, `username`, `password`, `email`, `role`, `campusid_ref`) VALUES (NULL, 'test', 'user', 'rem_user', '123456', 'genknooz4@gmail.com', 'reimbursement', '0');

/* Date: 27-Oct-2016 Arunsankar */
CREATE TABLE IF NOT EXISTS `plused_campus_image` (
  `campus_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `campus_id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`campus_image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `plused_campus_pdf` (
  `campus_pdf_id` int(11) NOT NULL AUTO_INCREMENT,
  `campus_id` int(11) NOT NULL,
  `pdf_title_1` varchar(20) NOT NULL,
  `pdf_path_1` varchar(255) NOT NULL,
  `pdf_title_2` varchar(20) NOT NULL,
  `pdf_path_2` varchar(255) NOT NULL,
  `pdf_title_3` varchar(20) NOT NULL,
  `pdf_path_3` varchar(255) NOT NULL,
  PRIMARY KEY (`campus_pdf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/* Date: 28-Oct-2016 Arunsankar */
CREATE TABLE IF NOT EXISTS `plused_campus_single_pdf` (
  `campus_single_pdf_id` int(11) NOT NULL AUTO_INCREMENT,
  `campus_id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `pdf_path` varchar(255) NOT NULL,
  PRIMARY KEY (`campus_single_pdf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/* Date: 08/Nov/2016 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (158, '138', 'Compare professori pax', '', 'sthistory/compareprofessori', '1', '2', 'Left', '4', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES
(565, 550, 158);

/* Date: 11/Nov/2016 Sandip Kalbhile */
ALTER TABLE `st_history` ADD INDEX ( `collaboratore` ) ;


/* Date: 14/Nov/2016 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES
(160, 0, 'Campus review', '', '', 1, 1, 'Left', 2, 'fa-list', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(161, 160, 'Review by date', '', 'backoffice/ca_reviewbydate_pax_new', 1, 2, 'Left', 1, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(162, 0, 'Bookings review', '', '', 1, 1, 'Left', 3, 'fa-calendar-check-o', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(163, 162, 'Bookings and excursions', '', 'backoffice/ca_viewAllBookings', 1, 2, 'Left', 1, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(164, 0, 'Transportation', '', '', 1, 1, 'Left', 4, 'fa-truck', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(165, 164, 'View booked transfers', '', 'backoffice/ca_viewBookedTransfers', 1, 2, 'Left', 1, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(166, 164, 'Companies details', '', 'backoffice/companiesDetails', 1, 2, 'Left', 2, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(167, 0, 'Manage ticket', '', '', 1, 1, 'Left', 5, 'fa-ticket', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(168, 167, 'Open ticket', '', 'backoffice/openTicket', 1, 2, 'Left', 1, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(169, 167, 'Recap', '', 'backoffice/recapTicket', 1, 2, 'Left', 2, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(170, 0, 'GL and students credentials', '', '', 1, 1, 'Left', 6, 'fa-user', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(171, 170, 'GL and students list', '', 'backoffice/glCredentials', 1, 2, 'Left', 1, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(172, 0, 'Petty cash', '', '', 1, 1, 'Left', 7, 'fa-money', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(173, 172, 'Payments', '', 'backoffice/bsPayments', 1, 2, 'Left', 1, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0);



/* Date: 16-Nov-2016 Sangip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '0', 'Included excursions', '', '', '1', '1', 'Left', '15', 'fa-university', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '176', 'Book included excursions', '', 'backoffice/setUnplannedExcursions', '1', '2', 'Left', '1', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '176', 'Review included excursions', '', 'backoffice/viewPlannedExcursions', '1', '2', 'Left', '2', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');

INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES
(645, 1, 176),
(646, 1, 177),
(647, 1, 178);

/* Date: 17-Nov-2016 Sangip Kalbhile */
INSERT INTO `vision_plus`.`plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '0', 'Extra excursions', '', '', '1', '1', 'Left', '17', 'fa-university', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `vision_plus`.`plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '188', 'Book extra excursions', '', 'backoffice/setUnplannedAllExcursions', '1', '2', 'Left', '1', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `vision_plus`.`plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '188', 'Rewiew extra excursions', '', 'backoffice/viewPlannedAllExcursions', '1', '2', 'Left', '2', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES
(657, 1, 188),
(658, 1, 189),
(659, 1, 190);


/* Date: 21-Nov-2016 Sangip Kalbhile */
INSERT INTO `vision_plus`.`plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (191, '138', 'Compare professori II chart', '', 'sthistory/compareprofessorisecond/chart', '1', '2', 'Left', '6', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');
INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES
(660, 550, 191);

/* Date: 21-Nov-2016 Arunsankar */
INSERT INTO `vision_plus`.`plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '138', 'Report for pax (diretti)', '', 'sthistory/reportpax', '1', '2', 'Left', '6', '', '', '', '', '', '0');
INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES
(661, 550, 192);

/* Date: 28-Nov-2016 Sandip Kalbhile */
ALTER TABLE `agnt_accommodation` ADD `accom_type` ENUM( "Students", "Group Leaders" ) NOT NULL DEFAULT 'Students' COMMENT 'Type of accomodation' AFTER `accom_name`;

/* Date: 2-Dec-2016 Arunsankar */
ALTER TABLE `agnt_packages` ADD `pack_full_price` DOUBLE(10,2) NOT NULL AFTER `pack_expiry_date`, ADD `pack_price_a` DOUBLE(10,2) NOT NULL AFTER `pack_full_price`, ADD `pack_price_b` DOUBLE(10,2) NOT NULL AFTER `pack_price_a`, ADD `pack_price_c` DOUBLE(10,2) NOT NULL AFTER `pack_price_b`;

/* Date: 12-Dec-2016 Sandip Kalbhile */
ALTER TABLE `agnt_package_services` ADD `serv_week` VARCHAR( 50 ) NOT NULL COMMENT 'Week for excursion' AFTER `serv_service_type`
ALTER TABLE `agnt_packages` ADD `pack_week_1` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT 'First week for package is valid' AFTER `pack_campus_id` ;
ALTER TABLE `agnt_packages` ADD `pack_week_2` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT 'Second week for excursion' AFTER `pack_week_1` ;
ALTER TABLE `agnt_packages` ADD `pack_week_3` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT 'Third week for excursion' AFTER `pack_week_2` ;

/* Date: 9-Dec-2016 Arunsankar */
ALTER TABLE `agnt_package_compositions` ADD `pcomp_week` INT NOT NULL AFTER `pcomp_activity_id`;
ALTER TABLE `agnt_booked_pax` CHANGE `booked_accomodation` `booked_package_composition` INT(11) NOT NULL COMMENT 'Type of package composition';

/* Date: 19-Dec-2016 Sandip Kalbhile */
ALTER TABLE `agnt_package_services` ADD `serv_extra_night` DOUBLE NOT NULL COMMENT 'Extra night charges for accommodations' AFTER `serv_cost`;
ALTER TABLE `agnt_packages` ADD `pack_free_gl_per_pax` INT NOT NULL COMMENT 'Free GK accommodation per number of pax' AFTER `pack_week_3`;


/* Date: 20-Dec-2016 Sandip Kalbhile */
ALTER TABLE `st_history`
CHANGE `id_opzione` `id_opzione` VARCHAR( 255 ) NOT NULL ,
CHANGE `id_nominativo_opzione` `id_nominativo_opzione` VARCHAR( 255 ) NOT NULL ,
CHANGE `id_nominativo_opzione` `id_nominativo_opzione` VARCHAR( 255 ) NOT NULL ,
CHANGE `id_collaboratore` `id_collaboratore` VARCHAR( 255 ) NOT NULL ,
CHANGE `id_accompagnatore` `id_accompagnatore` VARCHAR( 255 ) NOT NULL ,
CHANGE `id_tipologia_cliente` `id_tipologia_cliente` VARCHAR( 255 ) NOT NULL ,
CHANGE `id_azienda` `id_azienda` VARCHAR( 255 ) NOT NULL ,
CHANGE `id_corporate` `id_corporate` VARCHAR( 255 ) NOT NULL ,
CHANGE `id_prodotto` `id_prodotto` VARCHAR( 255 ) NOT NULL ,
CHANGE `costo_base` `costo_base` VARCHAR( 255 ) NOT NULL ,
CHANGE `costo_arpt_aggiuntivo` `costo_arpt_aggiuntivo` VARCHAR( 255 ) NOT NULL ,
CHANGE `supplementi` `supplementi` VARCHAR( 255 ) NOT NULL ,
CHANGE `pagamenti` `pagamenti` VARCHAR( 255 ) NOT NULL;

/* Date: 19-Dec-2016 Arunsankar */
ALTER TABLE `agnt_booked_pax` ADD `booked_package_accomodation` INT NOT NULL COMMENT 'Accomodation id for GL' AFTER `booked_package_composition`;
ALTER TABLE `agnt_booked_pax` CHANGE `booked_package_accomodation` `booked_package_accomodation` INT(11) NOT NULL DEFAULT '0' COMMENT 'Accomodation id for GL';
ALTER TABLE `agnt_booked_pax` CHANGE `booked_package_composition` `booked_package_composition` INT(11) NOT NULL DEFAULT '0' COMMENT 'Type of package composition';
ALTER TABLE `agnt_enrol_bookings` ADD `total_price` VARCHAR(255) NOT NULL COMMENT 'Total cost of booking' AFTER `enrol_departure_date`;

/* Date: 26-Dec-2016 Sandip Kalbhile */
ALTER TABLE `agnt_packages` ADD `pack_for_location` INT( 1 ) NOT NULL DEFAULT '0' COMMENT 'Package is for specific location/agents' AFTER `pack_price_c`;
ALTER TABLE `agnt_packages` ADD `pack_location_region` INT( 10 ) NOT NULL COMMENT 'Region for package' AFTER `pack_for_location`;
ALTER TABLE `agnt_packages` ADD `pack_location_country` VARCHAR( 255 ) NOT NULL COMMENT 'csv countries for package location' AFTER `pack_location_region`;

/* Date: 29-Dec-2016 Arunsankar */
ALTER TABLE `agnt_enrol_bookings` ADD `free_gl_count` INT(11) NOT NULL DEFAULT '0' AFTER `enrol_departure_date`;
ALTER TABLE `agnt_booked_pax` ADD `booked_is_free` TINYINT(1) NOT NULL DEFAULT '0' AFTER `booked_tipo_pax`;
ALTER TABLE `agnt_enrol_bookings` ADD`total_price` varchar(255) NOT NULL COMMENT 'Total cost of booking' AFTER `free_gl_count`;

/* Date: 2-Jan-2017 Sandip Kalbhile */
ALTER TABLE `agnt_packages`  ADD `pack_cd_salary` DOUBLE(10,2) NOT NULL COMMENT 'Course director salary' AFTER `pack_location_country`,
ADD `pack_cd_accomodation` DOUBLE(10,2) NOT NULL COMMENT 'Course director accomodation' AFTER `pack_cd_salary`,
ADD `pack_acd_salary` DOUBLE(10,2) NOT NULL COMMENT 'Assitant course director salary' AFTER `pack_cd_accomodation`,
ADD `pack_acd_accomodation` DOUBLE(10,2) NOT NULL COMMENT 'Assitant course director accomodaton' AFTER `pack_acd_salary`,
ADD `pack_cm_salary` DOUBLE(10,2) NOT NULL COMMENT 'Campus manager salary' AFTER `pack_acd_accomodation`,
ADD `pack_cm_accomodation` DOUBLE(10,2) NOT NULL COMMENT 'Campus manager accomodation' AFTER `pack_cm_salary`,
ADD `pack_acm_salary` DOUBLE(10,2) NOT NULL COMMENT 'Assistant campus manager salary' AFTER `pack_cm_accomodation`,
ADD `pack_acm_accomodation` DOUBLE(10,2) NOT NULL COMMENT 'Assistant campus manager accomodation' AFTER `pack_acm_salary`,
ADD `pack_teacher_accomodation` DOUBLE(10,2) NOT NULL COMMENT 'Teacher accomodation' AFTER `pack_acm_accomodation`,
ADD `pack_teacher_lunch` DOUBLE(10,2) NOT NULL COMMENT 'Teacher lunch' AFTER `pack_teacher_accomodation`,
ADD `pack_travelling` DOUBLE(10,2) NOT NULL COMMENT 'Travel per pax per week' AFTER `pack_teacher_lunch`,
ADD `pack_printing_stationary` DOUBLE(10,2) NOT NULL COMMENT 'Printing or stationaory per pax per week' AFTER `pack_travelling`,
ADD `pack_books` DOUBLE(10,2) NOT NULL COMMENT 'Books per pax per week' AFTER `pack_printing_stationary`,
ADD `pack_expenses` DOUBLE(10,2) NOT NULL COMMENT 'Expenses per pax per week' AFTER `pack_books`

/* Date: 5-Jan-2016 Arunsankar */
ALTER TABLE `agnt_packages` ADD `pack_extra_gl_price` DOUBLE(10,2) NOT NULL COMMENT 'Price for extra GL' AFTER `pack_free_gl_per_pax`;
ALTER TABLE `agnt_enrol_bookings` ADD `enrol_agent_id` INT(11) NOT NULL AFTER `enroll_id`;

/* Date: 13-Jan-2017 Sandip Kalbhile */
ALTER TABLE `agnt_package_compositions` ADD `pcomp_staff_charges` DOUBLE( 10, 2 ) NOT NULL AFTER `pcomp_excursion_cost` ,
ADD `pcomp_other_charges` DOUBLE( 10, 2 ) NOT NULL AFTER `pcomp_staff_charges`

/* Date: 13-Jan-2016 Arunsankar */
CREATE TABLE IF NOT EXISTS `plused_campus_video` (
  `campus_video_id` int(11) NOT NULL AUTO_INCREMENT,
  `campus_id` int(11) NOT NULL,
  `campus_video_1` varchar(255) NOT NULL,
  `campus_video_2` varchar(255) NOT NULL,
  `campus_video_3` varchar(255) NOT NULL,
  PRIMARY KEY (`campus_video_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `plused_campus_video` ADD `campus_video_4` VARCHAR(255) NOT NULL AFTER `campus_video_3`;

/* Date: 18-Jan-2017 Sandip Kalbhile */
UPDATE `vision_plus`.`plused_role_menu` SET `mnu_menu_name` = 'Review extra excursions' WHERE `plused_role_menu`.`mnu_menuid` =190;

/* Date: 31-Jan-2017 Arunsankar */
ALTER TABLE `agenti` ADD `pricecategory` VARCHAR(10) NOT NULL DEFAULT 'No profile' ;

/* Date: 2-Feb-2017 Arunsankar */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '131', 'College images', '', 'agents/imageGallery/college', '1', '2', 'Left', '1', '', '', '', '', '', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '131', 'Cities images', '', 'agents/imageGallery/city', '1', '2', 'Left', '2', '', '', '', '', '', '0');

INSERT INTO `vision_plus`.`plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '131', 'Students images', '', 'agents/imageGallery/student', '1', '2', 'Left', '3', '', '', '', '', '', '0');

INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES
(NULL, '99', '193'),
(NULL, '99', '194'),
(NULL, '99', '195');

DELETE FROM `plused_role_access` WHERE `acc_role_id` = 99 AND `acc_menu_id` = 132;

ALTER TABLE `plused_campus_image` ADD `category` ENUM('college', 'city', 'student') NOT NULL COMMENT 'College/City/Student' AFTER `title`;

/* Date: 6-Feb-2017 Arunsankar */
ALTER TABLE `agnt_enrol_bookings` ADD `status` ENUM('1','2','3','4','5') NOT NULL DEFAULT '1' COMMENT '1 - tbc, 2 - active, 3 - confirmed, 4 - rejected, 5 - elapsed' AFTER `total_price`;
ALTER TABLE `agnt_enrol_bookings` ADD `enrol_lock_pax` TINYINT(1) NOT NULL DEFAULT '0' AFTER `status`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_surname` VARCHAR(50) NULL DEFAULT NULL AFTER `booked_is_free`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_name` VARCHAR(50) NULL DEFAULT NULL AFTER `booked_pax_surname`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_gender` VARCHAR(1) NULL DEFAULT NULL AFTER `booked_pax_name`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_dob` DATE NULL DEFAULT NULL AFTER `booked_pax_gender`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_nationality` VARCHAR(50) NOT NULL AFTER `booked_pax_dob`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_passport_no` VARCHAR(50) NOT NULL AFTER `booked_pax_nationality`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_salute` VARCHAR(10) NOT NULL AFTER `booked_is_free`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_share_room` VARCHAR(100) NOT NULL AFTER `booked_pax_passport_no`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_gl_rif` VARCHAR(150) NOT NULL AFTER `booked_pax_share_room`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_campus_arrival_date` DATETIME NOT NULL AFTER `booked_pax_gl_rif`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_campus_departure_date` DATETIME NOT NULL AFTER `booked_pax_campus_arrival_date`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_arrival_flight_date` DATETIME NOT NULL AFTER `booked_pax_campus_departure_date`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_transfer_in` TINYINT(1) NOT NULL DEFAULT '0' AFTER `booked_pax_arrival_flight_date`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_arrival_airport` VARCHAR(3) NULL DEFAULT NULL AFTER `booked_pax_transfer_in`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_arrival_flight_number` VARCHAR(15) NOT NULL AFTER `booked_pax_arrival_airport`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_departure_flight_date` DATETIME NOT NULL AFTER `booked_pax_arrival_flight_number`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_transfer_out` TINYINT(1) NOT NULL DEFAULT '0' AFTER `booked_pax_departure_flight_date`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_departure_airport` VARCHAR(3) NOT NULL AFTER `booked_pax_transfer_out`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_departure_flight_number` VARCHAR(15) NOT NULL AFTER `booked_pax_departure_airport`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_visa` TINYINT(1) NOT NULL DEFAULT '0' AFTER `booked_pax_departure_flight_date`;
ALTER TABLE `agnt_booked_pax` ADD `booked_pax_departure_arrival_airport` VARCHAR(3) NOT NULL AFTER `booked_pax_departure_flight_number`, ADD `booked_pax_arrival_departure_airport` VARCHAR(3) NOT NULL AFTER `booked_pax_departure_arrival_airport`;
ALTER TABLE `agnt_booked_pax` ADD `booked_lock_pax` TINYINT(1) NOT NULL DEFAULT '0' AFTER `booked_pax_arrival_departure_airport`;



ALTER TABLE `agnt_booked_pax` ADD `booked_template` VARCHAR(10) NULL DEFAULT NULL AFTER `booked_lock_pax`;
ALTER TABLE `agnt_enrol_bookings` ADD `enrol_download_visa` TINYINT(1) NOT NULL DEFAULT '0' AFTER `enrol_lock_pax`;
ALTER TABLE `agnt_booked_pax` ADD `booked_template_date` TIMESTAMP NULL DEFAULT NULL AFTER `booked_template`;
ALTER TABLE `agnt_enrol_bookings` ADD `enrol_template` VARCHAR(10) NULL DEFAULT NULL AFTER `enrol_download_visa`, ADD `enrol_template_date` TIMESTAMP NULL DEFAULT NULL AFTER `enrol_template`;


/* Date: 10-Feb-2017 Sandip Kalbhile */
ALTER TABLE `plused_language_knowledge` ADD `lk_listening_comprehension` INT(11) NOT NULL AFTER `lk_lang_knowledge`, ADD `lk_oral_test` INT(11) NOT NULL AFTER `lk_listening_comprehension`;

/* Date: 10-Feb-2017 Sandip Kalbhile */
ALTER TABLE `plused_language_knowledge` ADD `lk_listening_comprehension` INT(11) NOT NULL AFTER `lk_lang_knowledge`, ADD `lk_oral_test` INT(11) NOT NULL AFTER `lk_listening_comprehension`;

ALTER TABLE `agenti` ADD `pricecategory` VARCHAR( 10 ) NOT NULL AFTER `ranking`;

/* Date: 15-Feb-2017 Sandip Kalbhile */
ALTER TABLE `plused_language_knowledge` ADD `lk_english_test_score` INT NOT NULL AFTER `lk_oral_test`;

/* Date: 16-Feb-2017 Arunsankar */
ALTER TABLE `plused_ticket_cm` ADD `ptc_sender_type` ENUM('Campus Manager', 'Course Director', 'Backoffice') NOT NULL DEFAULT 'Campus Manager' COMMENT 'Type of user who opens ticket' AFTER `ptc_bo_read`;

ALTER TABLE `plused_ticket_cm` ADD `ptc_receiver_type` ENUM('Campus Manager', 'Course Director', 'Backoffice') NOT NULL DEFAULT 'Backoffice' COMMENT 'Type of user who opens ticket' AFTER `ptc_sender_type`

INSERT INTO `vision_plus`.`plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '93', 'Open ticket', '', 'ticketmanagement/openTicket', '1', '2', 'Left', '2', '', '', '', '', '', '0');

INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES
(NULL, '400', '167'),
(NULL, '400', '168'),
(NULL, '400', '169'),
(NULL, '100', '195');

/* Date: 02-Mar-2017 Sandip Kalbhile */
ALTER TABLE `agnt_package_services` ADD `serv_extra_activity` DOUBLE( 10, 2 ) NOT NULL AFTER `serv_extra_night`;
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '3', 'Map bookings', '', 'mapbookings/index', '1', '2', 'Left', '6', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

CREATE TABLE `agnt_map_packbooking` (
 `pbmap_id` int(11) NOT NULL AUTO_INCREMENT,
 `pbmap_package_id` int(11) NOT NULL,
 `pbmap_book_id` int(11) NOT NULL,
 PRIMARY KEY (`pbmap_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1

/* Date: 08-Mar-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '6', 'Upload new position', '', 'teachers/uploadposition', '1', '2', 'Left', '6', '', '2016-08-31 00:00:00', '123', '2016-08-31 00:00:00', '123', '0');

/* Date: 10-Mar-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '123', 'Generate booking', 'Internal', 'packages/bookinginvoice', '1', '2', 'Left', '1', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

/* Date: 14-Mar-2017 Sandip Kalbhile */
ALTER TABLE `agnt_booking_invoice` ADD `inv_old_booking` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `inv_booking_id`; 

/* Date: 8-March-2017 Arunsankar */
UPDATE `plused_role_menu` SET `mnu_caption` = 'CM and CD' WHERE `plused_role_menu`.`mnu_menuid` = 167;
UPDATE `plused_role_menu` SET `mnu_caption` = 'Backoffice' WHERE `plused_role_menu`.`mnu_menuid` = 93;

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '0', 'Special booking', '', '', '1', '1', 'Left', '19', 'fa-sign-in', '', '', '', '', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '196', 'Enrol booking', '', 'specialbooking', '1', '2', 'Left', '1', '', '', '', '', '', '0');

INSERT INTO `vision_plus`.`plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '196', 'Inserted bookings', '', 'specialbooking/enrolledBookings', '1', '2', 'Left', '2', '', '', '', '', '', '0');

INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES
(NULL, '100', '196'),
(NULL, '100', '197'),
(NULL, '100', '198');

CREATE TABLE IF NOT EXISTS `plused_special_bookings` (
  `sb_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Pk special booking id',
  `sb_center_id` int(11) NOT NULL COMMENT 'Selected center id',
  `sb_accomodation_id` int(11) NOT NULL COMMENT 'Selected accomodation id',
  `sb_number_of_week` int(11) NOT NULL COMMENT 'Number of weeks for bookings',
  `sb_number_of_staff` int(11) NOT NULL COMMENT 'Number of staff persons for bookings',
  `sb_arrival_date` datetime NOT NULL COMMENT 'Arrival date for the bookings',
  `sb_departure_date` datetime NOT NULL COMMENT 'Departure date for the bookings',
  `sb_created_on` datetime NOT NULL COMMENT 'Date when booking is entered',
  PRIMARY KEY (`sb_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='This is the table to store special bookings' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `plused_special_booking_pax` (
  `sb_pax_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Pk special booking pax id',
  `sb_id` int(11) NOT NULL COMMENT 'Enrolled special booking id',
  `sb_pax_surname` varchar(50) DEFAULT NULL,
  `sb_pax_name` varchar(50) DEFAULT NULL,
  `sb_pax_dob` date DEFAULT NULL,
  `sb_pax_position` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sb_pax_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/* Date: 10-Mar-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '123', 'Generate booking', 'Internal', 'packages/bookinginvoice', '1', '2', 'Left', '1', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

/* Date: 14-Mar-2017 Sandip Kalbhile */
ALTER TABLE `agnt_booking_invoice` ADD `inv_old_booking` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `inv_booking_id`; 


/* Date: 22-Mar-2017 Arunshankar*/
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '0', 'Agent management', '', '', '1', '1', 'Left', '20', 'fa-users', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '205', 'Agents list', '', 'manageagents', '1', '2', 'Left', '1', '', '2017-02-06 00:00:00', '0', '2017-02-06 00:00:00', '0', '0');

/* Date: 21-Mar-2017 Sandip Kalbhile */
ALTER TABLE `pulsed_job_offer_letters` CHANGE `jof_teacher_type` `jof_teacher_type` ENUM( '', 'London', 'Non London', 'Academy 1', 'Academy 2', 'Academy', 'Dublin', 'Non-res horizontal zig zag' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '';



/* Date: 05-Apr-2017 Sandip Kalbhile */
ALTER TABLE `agnt_excursions` ADD `exc_old_exc_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `exc_brief_description`;


/* Date: 06-Apr-2017 Arunshankar */
ALTER TABLE `plused_book` ADD `flag_transfer` TINYINT(1) NULL DEFAULT NULL ;


/* Date: 05-Apr-2017 Sandip Kalbhile */
ALTER TABLE `agnt_excursions` ADD `exc_old_exc_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `exc_brief_description`;

/* Date: 06-Apr-2017 Arunshankar */
ALTER TABLE `plused_book` ADD `flag_transfer` TINYINT(1) NULL DEFAULT NULL ;

/* Date: 05-Apr-2017 Sandip Kalbhile */
ALTER TABLE `agnt_excursions` ADD `exc_type` VARCHAR(50) NULL DEFAULT NULL AFTER `exc_old_exc_id`;
ALTER TABLE `agnt_excursions` ADD `exc_days` INT(11) NULL DEFAULT NULL AFTER `exc_type`, ADD `exc_weeks` INT(11) NULL DEFAULT NULL AFTER `exc_days`, ADD `exc_airport` VARCHAR(50) NULL DEFAULT NULL AFTER `exc_weeks`;

/* Date: 25-Apr-2017 Sandip Kalbhile */
ALTER TABLE `agnt_packages` ADD `pack_extra_tuition_price` DOUBLE( 10, 2 ) NOT NULL AFTER `pack_extra_gl_price`;

/* Date: 27-Apr-2017 Sandip Kalbhile */
/* This is user defined function in database which will return number of working days, weekend days or total days */
DELIMITER $$
CREATE FUNCTION `getWorkingday`(d1 datetime,d2 datetime, retType varchar(20)) RETURNS varchar(255) CHARSET utf8
BEGIN
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

/* Date: 25-Apr-2017 Arunshankar */
INSERT INTO `plused_role` (`role_id`, `role_name`, `role_created_on`, `role_is_active`, `role_is_deleted`) VALUES (553, 'Bursars', '2017-03-09 15:02:53', '1', '0');
INSERT INTO `plused_role_access` (`acc_role_id`, `acc_menu_id`) VALUES ('553', '1'), ('553', '160'), ('553', '161'), ('553', '162'), ('553', '163'), ('553', '164'), ('553', '165'), ('553', '166'), ('553', '170'), ('553', '171'), ('553', '172'), ('553', '173');
INSERT INTO `members` (`id`, `first_name`, `last_name`, `username`, `password`, `email`, `role`, `campusid_ref`) VALUES (NULL, 'Canterbury', 'paul', 'shawn', '123456', 'info@studytours.its', 'bursars', '6');

/* Date: 28-Apr-2017 Sandip Kalbhile */
ALTER TABLE `pulsed_job_contract` ADD `job_board_as` VARCHAR(255) NULL DEFAULT NULL AFTER `joc_extra_activities`;


/* Date: 02 May 2017 Sandip Kalbhile */
ALTER TABLE `agnt_package_services` ADD `serv_extra_tuition` DOUBLE( 10, 2 ) NOT NULL AFTER `serv_extra_activity`;


/* Date: 19 May 2017 Sandip Kalbhile */
INSERT INTO `plused_fincon_services` (`pfcse_id`, `pfcse_code`, `pfcse_name`) VALUES (NULL, 'IND', 'Invoice Discount');

/* Date: 23 May 2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '3', 'Invoice history', '', 'bookinginvoice', '1', '2', 'Left', '7', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

/* Date: 24 May 2017 Arunsankar */
ALTER TABLE `pax_level` CHANGE `level` `level` VARCHAR(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

/* Date: 25 May 2017 Sandip Kalbhile */
ALTER TABLE `agnt_booking_invoice` ADD `inv_invoice_file` VARCHAR(255) NULL AFTER `inv_total_cost`;

/* Date: 24 May 2017 Arunsankar */
ALTER TABLE `pax_level` CHANGE `level` `level` VARCHAR(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

/* Date: 19 May 2017 Sandip Kalbhile */
INSERT INTO `plused_fincon_services` (`pfcse_id`, `pfcse_code`, `pfcse_name`) VALUES (NULL, 'IND', 'Invoice Discount');

/* Date: 31 May 2017 Arunsankar */
ALTER TABLE `plused_language_knowledge` ADD `is_opted_offline` INT NOT NULL AFTER `lk_english_test_score`;


/* Date: 14 June 2017 Arunsankar */
ALTER TABLE `plused_test_options` ADD INDEX(`opt_que_id`);


/* Date: 08 Jun 2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '0', 'Invoice summary', '', '', '1', '1', 'Left', '21', 'fa-files-o', '2017-06-08 00:00:00', '0', '2017-06-08 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '207', 'Invoice summary debtor report', '', 'invoice/summary', '1', '2', 'Left', '1', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '207', 'Agent detailed debtors report', '', 'invoice/customerdetails', '1', '2', 'Left', '1', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '207', 'Invoice due report', '', 'invoice/duereport', '1', '2', 'Left', '4', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '207', 'Invoice overdue report', '', 'invoice/overduereport', '1', '2', 'Left', '5', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

/* Date: 08 Jun 2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '207', 'Daily debtors statistics', '', 'invoice/debtorsstatistics', '1', '2', 'Left', '3', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

/* Date: 14 June 2017 Arunsankar */
ALTER TABLE `plused_test_options` ADD INDEX(`opt_que_id`);

/* Date: 15 Jun 2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '209', 'Invoice due report', '', 'invoice/duereport', '1', '2', 'Left', '4', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

/* Date: 19 Jun 2017 Arunsankar */
INSERT INTO `plused_role_menu` (`mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES ( '0', 'Profile', 'GL Profile Internal Link', 'survey/profile', '1', '1', 'Top', '1', 'fa-user', '2016-08-08 00:00:00', '1', '2016-08-08 00:00:00', '1', '0');

/* Date: 19 Jun 2017 Arunsankar */
INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES (NULL, '501', '214');


/* Date: 15 Jun 2017 Sandip Kalbhile */
ALTER TABLE `plused_classes` ADD `class_type` VARCHAR(50) NOT NULL DEFAULT 'Regular' AFTER `class_room_number`;

/* Date: 09-Aug-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES
(39, 'Survey detail pdf', 'Internal link', 'student_survey/print_pdf_survey_details', 1, 3, 'Left', 1, '', '2016-08-30 00:00:00', 123, '2016-08-30 00:00:00', 123, 0);

/* Date: 21-Aug-2017 Sandip Kalbhile */
ALTER TABLE `agnt_enrol_bookings` ADD `enrol_campus_id` INT(11) NOT NULL AFTER `enroll_id`;

CREATE TABLE `agnt_pack_exc_bookings` (
 `exb_id` int(11) NOT NULL AUTO_INCREMENT,
 `exb_id_book` int(9) NOT NULL,
 `exb_id_year` int(4) NOT NULL,
 `exb_id_excursion` int(11) NOT NULL,
 `exb_campus_id` int(5) NOT NULL,
 `exb_tot_pax` int(11) NOT NULL,
 `exb_excursion_date` date NOT NULL,
 `exb_type` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
 `exb_buscompany_code` varchar(10) CHARACTER SET utf8 NOT NULL,
 `exb_confirmed` enum('NO','STANDBY','YES') CHARACTER SET utf8 DEFAULT 'NO',
 `exb_modified` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`exb_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


/* Date: 25-Aug-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '176', 'Review enroll excursions', '', 'enrolexcursions/planned', '1', '2', 'Left', '3', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');


/* Date: 06-Sept-2017 SANDIP KALBHILE */
ALTER TABLE `agnt_excursions` ADD `exc_is_active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `exc_airport`, ADD `exc_is_deleted` TINYINT(1) NOT NULL DEFAULT '0' AFTER `exc_is_active`;

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '0', 'Manage excursion', '', '', '1', '1', 'Left', '22', 'fa-bus', '2017-06-08 00:00:00', '0', '2017-06-08 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '217', 'Excursion', '', 'excursion', '1', '2', 'Left', '1', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '217', 'Transfer', '', 'excursion/transfer', '1', '2', 'Left', '2', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '217', 'Campus excursion / transfer', '', 'excursion/mapcampus', '1', '2', 'Left', '3', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

UPDATE agnt_excursions SET exc_type = "excursion" WHERE exc_type != "transfer";


/* Date: 16-Oct-2017 Sandip Kalbhile */
ALTER TABLE `agnt_excursions` ADD `exc_day_type` ENUM('Full Day','Half Day') NULL DEFAULT NULL AFTER `exc_type` 
ALTER TABLE `agnt_excursions` ADD `exc_image` VARCHAR(255) NULL DEFAULT NULL AFTER `exc_day_type`;

CREATE TABLE `plused_campus_single_pdf_for_agents` ( `campus_single_pdf_id` int(11) NOT NULL AUTO_INCREMENT, `campus_id` int(11) NOT NULL, `title` varchar(20) NOT NULL, `pdf_path` varchar(255) NOT NULL, PRIMARY KEY (`campus_single_pdf_id`) ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1

ALTER TABLE `plused_campus_single_pdf_for_agents` ADD `sequence` INT(11) NOT NULL AFTER `pdf_path`;
ALTER TABLE `plused_campus_single_pdf_for_agents` CHANGE `title` `title` VARCHAR(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

/* Date: 30-Oct-2017 Sandip Kalbhile */
ALTER TABLE `plused_role_menu` CHANGE `mnu_url` `mnu_url` VARCHAR(300) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Not null if mnu_is_content = 1 menu.';
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'Edit campus', 'internal', 'backoffice/cmsEditCampus', '1', '3', 'Left', '1', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'Edit planned excursion', 'internal', 'cmsManageExcursions/planned', '1', '3', 'Left', '2', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'Edit extra excursion', 'internal', 'cmsManageExcursions/extra', '1', '3', 'Left', '3', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'Edit transfers', 'internal', 'cmsManageExcTraCampus', '1', '3', 'Left', '4', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'Add excursion', 'internal', 'backoffice/cmsAddExcursion,backoffice/cmsInsertExcursion,backoffice/cmsEditExcursion,backoffice/cmsUpdateExcursion,backoffice/cmsJoinAttrExc,backoffice/cmsJoinBusExc,backoffice/cmsAddAttractionToExc,backoffice/cmsDelAttrExc,backoffice/cmsRemoveExcursion', '1', '3', 'Left', '5', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'Edit arrival date', 'internal', 'backoffice/cmsManageDatesCampus,backoffice/cmsAddDateCampus', '1', '3', 'Left', '6', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'Manage campus availablity', 'internal', 'backoffice/cmsManageCampusAvailability,backoffice/cmsAddCampusAvailability,backoffice/cmsDelCampusAvailability', '1', '3', 'Left', '7', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'Upload PDFs', 'internal', 'backoffice/cmsUploadSinglePdfs,backoffice/getCampusSinglePdfsForAgent,backoffice/deleteCampusPdfForAgent', '1', '3', 'Left', '8', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'Upload image', 'internal', 'backoffice/cmsUploadImage,backoffice/deleteCampusImage', '1', '3', 'Left', '9', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'Upload PDF', 'internal', 'backoffice/cmsUploadSinglePdf', '1', '3', 'Left', '10', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'Add videos', 'internal', 'backoffice/cmsUploadVideo', '1', '3', 'Left', '11', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '149', 'New campus', 'internal', 'backoffice/cmsAddCampus', '1', '3', 'Left', '1', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '148', 'Manage attractions', '', 'backoffice/cmsManageAttractions', '1', '2', 'Left', '4', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');

/* Date: 31-Oct-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '114', 'Overview booking modal', '', 'backoffice/newAvail,backoffice/delRosterPax,backoffice/addRosterPax,backoffice/modRosterPax,backoffice/change_booking_status,backoffice/invoice_pdf_no_acconto', '1', '3', 'Left', '1', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

/* Date: 01-Nov-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '128', 'View attractions detail', 'internal', 'agents/viewAttractionDetail', '1', '3', 'Left', '1', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

/* Date: 02-Nov-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '177', 'Set transportation for selected ex', 'internal', 'excursion/addedit', '1', '3', 'Left', '1', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '178', 'Included excursion plan detail', 'internal', 'backoffice/busExcDetail', '1', '3', 'Left', '1', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '222', 'Excursion add edit', 'internal', 'excursion/addedit', '1', '3', 'Left', '1', '', '2016-08-19 00:00:00', '1', '2016-08-19 00:00:00', '1', '0');

/* Date: 10-Nov-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '196', 'Manage category program', '', 'categoryprogram', '1', '2', 'Left', '3', '', '2017-02-06 00:00:00', '0', '2017-02-06 00:00:00', '0', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '244', 'Add category program', '', 'categoryprogram/addedit', '1', '3', 'Left', '1', '', '2017-02-06 00:00:00', '0', '2017-02-06 00:00:00', '0', '0');

/* Date: 14-Nov-2017 Sandip Kalbhile */
ALTER TABLE `agnt_packages` ADD `pack_category_program_id` INT(11) NOT NULL AFTER `pack_campus_id`;

/* Date: 15-Nov-2017 Sandip Kalbhile */
ALTER TABLE `agnt_packages` ADD `pack_program_description` TEXT NULL DEFAULT NULL AFTER `pack_category_program_id`;

/* Date: 16-Nov-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '148', 'Add price lists pdf', '', 'pricelistpdf/pricelist', '1', '2', 'Left', '5', '', '2017-11-16 00:00:00', '0', '2017-11-16 00:00:00', '0', '0');

/* Date: 17-Nov-2017 Sandip Kalbhile */
CREATE TABLE `plused_campus_pricelist_pdf` (
 `pricelist_pdf_id` int(11) NOT NULL AUTO_INCREMENT,
 `pricelist_title` varchar(20) NOT NULL,
 `pricelist_type` enum('campus','transfer') NOT NULL DEFAULT 'campus',
 `pricelist_pdf_path` varchar(255) NOT NULL,
 PRIMARY KEY (`pricelist_pdf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1

/* Date: 17-Nov-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '64', 'Export button', 'Internal link', 'teachers/exportreview', '1', '3', 'Left', '2', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '73', 'Export button', '', 'jobofferhistory/exporthistory', '1', '3', 'Left', '1', '', '2016-08-25 00:00:00', '1', '2016-08-25 00:00:00', '1', '0');

/* Date: 05-Dec-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '0', 'Website managements', '', '', '1', '1', 'Left', '5', 'fa-globe', '2017-12-05 00:00:00', '1', '2017-12-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'Manage program banner', '', 'frontweb/program', '1', '2', 'Left', '1', '', '2017-12-05 00:00:00', '1', '2017-12-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'Course management', '', 'frontweb/course', '1', '2', 'Left', '2', '', '2017-12-05 00:00:00', '1', '2017-12-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'Manage course progarm', '', 'frontweb/program_course', '1', '2', 'Left', '3', '', '2017-12-05 00:00:00', '1', '2017-12-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'Manage junior centre', '', 'frontweb/junior_centre', '1', '2', 'Left', '4', '', '2017-12-05 00:00:00', '1', '2017-12-05 00:00:00', '1', '0');
/* sub-menus */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '250', 'Add program banner', 'Internal link', 'frontweb/program/add', '1', '3', 'Left', '1', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '250', 'Edit program banner', 'Internal link', 'frontweb/program/edit', '1', '3', 'Left', '2', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '250', 'Delete program banner', 'Internal link', 'frontweb/program/delete', '1', '3', 'Left', '3', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '251', 'Add course', 'Internal link', 'frontweb/course/add', '1', '3', 'Left', '1', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '251', 'Edit course', 'Internal link', 'frontweb/course/edit', '1', '3', 'Left', '2', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '251', 'Delete course', 'Internal link', 'frontweb/course/delete', '1', '3', 'Left', '3', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '251', 'Add course feature', 'Internal link', 'frontweb/course/add_course_feature', '1', '3', 'Left', '4', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '252', 'Add course program', 'Internal link', 'frontweb/program_course/add', '1', '3', 'Left', '1', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '252', 'Edit course program', 'Internal link', 'frontweb/program_course/edit', '1', '3', 'Left', '2', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '252', 'Delete course program', 'Internal link', 'frontweb/program_course/delete', '1', '3', 'Left', '3', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '253', 'Add junior centre', 'Internal link', 'frontweb/junior_centre/add', '1', '3', 'Left', '1', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '253', 'Edit junior centre', 'Internal link', 'frontweb/junior_centre/edit', '1', '3', 'Left', '2', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '253', 'Delete junior centre', 'Internal link', 'frontweb/junior_centre/delete', '1', '3', 'Left', '3', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');

/*****************Date : 5th December , 2017 (After 6PM)******************/
UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/program/add,frontweb/program/process' WHERE `plused_role_menu`.`mnu_menuid` = 254;
UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/course/add,frontweb/course/process,frontweb/course/crop_again' WHERE `plused_role_menu`.`mnu_menuid` = 257;
UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/program_course/add,frontweb/program_course/process' WHERE `plused_role_menu`.`mnu_menuid` = 261; 
UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/junior_centre/add,frontweb/junior_centre/process' WHERE `plused_role_menu`.`mnu_menuid` = 264;

/*******************Date : 8th December , 2017**********************/
ALTER TABLE `frontweb_junior_centre` DROP `centre_description`, DROP `centre_address`, DROP `centre_latitude`, DROP `centre_longitude`;
UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/junior_centre/add,frontweb/junior_centre/process,frontweb/junior_centre/upload_pdf_management' WHERE `plused_role_menu`.`mnu_menuid` = 264; 

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

/* Date: 12-Dec-2017 | Sourav Dhara */

UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/junior_centre/add,frontweb/junior_centre/process,frontweb/junior_centre/upload_pdf_management,frontweb/junior_centre/photo_gallery,frontweb/junior_centre/photo_gallery_add,frontweb/junior_centre/delete_photo_gallery' WHERE `plused_role_menu`.`mnu_menuid` = 264;

/* Date: 18-Dec-2017 | Sourav Dhara */

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'Manage junior mini stay', '', 'frontweb/junior_ministay', '1', '2', 'Left', '6', '', '2017-12-18 00:00:00', '1', '2017-12-18 00:00:00', '1', '0');

INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES (NULL, '300', '268');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '268', 'Add junior mini stay', 'Internal link', 'junior_ministay/add_edit', '1', '3', 'Left', '1', '', '2017-12-18 00:00:00', '1', '2017-12-18 00:00:00', '1', '0');

INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES (NULL, '300', '269');

UPDATE `plused_role_menu` SET `mnu_url` = 'junior_ministay/add_edit,frontweb/junior_ministay/process' WHERE `plused_role_menu`.`mnu_menuid` = 269;

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '268', 'Delete junior mini stay', 'Internal link', 'frontweb/junior_ministay/delete', '1', '3', 'Left', '1', '', '2017-12-18 00:00:00', '1', '2017-12-18 00:00:00', '1', '0');

INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES (NULL, '300', '270');

/* Date: 19-Dec-2017 | Sourav Dhara */

UPDATE `plused_role_menu` SET `mnu_url` = 'junior_ministay/add_edit,frontweb/junior_ministay/process,frontweb/junior_ministay/photo_gallery,frontweb/junior_ministay/delete_photo_gallery' WHERE `plused_role_menu`.`mnu_menuid` = 269;


/* Date: 22-Dec-2017 Sandip Kalbhile */
ALTER TABLE `centri` ADD `is_mini_stay` TINYINT(1) NOT NULL DEFAULT '0' AFTER `attivo`;

/* Date: 27-Dec-2017 Sandip Kalbhile */
INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '267', 'Add menu content', 'Internal link', 'frontweb/cmsmenu/content,frontweb/cmsmenu/addmenu', '1', '3', 'Left', '1', '', '2016-09-05 00:00:00', '1', '2016-09-05 00:00:00', '1', '0');


/* Date: 27-Dec-2017 | Sourav Dhara */

UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/course/add,frontweb/course/process,frontweb/course/crop_again,frontweb/course/update_form' WHERE `plused_role_menu`.`mnu_menuid` = 257;


/* Date: 29-Dec-2017 | Sourav Dhara */

UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/course/add,frontweb/course/process,frontweb/course/crop_again,frontweb/course/update_form,frontweb/course/show_enquiry_form' WHERE `plused_role_menu`.`mnu_menuid` = 257;


/* Date: 10-Jan-2018 | Sourav Dhara */

ALTER TABLE `frontweb_program_course` ADD `program_front_image` VARCHAR(200) NULL AFTER `program_course_logo`;

UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/program_course/add,frontweb/program_course/process,frontweb/program_course/add_edit,frontweb/program_course/crop_again' WHERE `plused_role_menu`.`mnu_menuid` = 261;



/* Date: 11-Jan-2018 | Sourav Dhara */

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'Manage video', '', 'frontweb/manage_video', '1', '2', 'Left', '7', '', '2018-01-11 00:00:00', '1', '2018-01-11 00:00:00', '1', '0');

INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES (NULL, '300', '272');



/* Date: 12-Jan-2018 | Sourav Dhara */

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'Manage walking tour', '', 'frontweb/walking_tour', '1', '2', 'Left', '8', '', '2018-01-12 00:00:00', '1', '2018-01-12 00:00:00', '1', '0');

INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES (NULL, '300', '273');



/* Date: 17-Jan-2018 | Sourav Dhara */

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'Manage Activity', '', 'frontweb/manage_activity', '1', '2', 'Left', '9', '', '2018-01-17 00:00:00', '1', '2018-01-17 00:00:00', '1', '0');
INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES (NULL, '300', '274');




/* Date: 18-Jan-2018 | Sourav Dhara */

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '274', 'Add activity', 'Internal link', 'frontweb/manage_activity/add_edit', '1', '3', 'Left', '1', '', '2018-01-18 00:00:00', '1', '2018-01-18 00:00:00', '1', '0');
INSERT INTO `plused_role_access` (`acc_id`, `acc_role_id`, `acc_menu_id`) VALUES (NULL, '300', '275');




/* Date: 19-Jan-2018 | Sourav Dhara */

UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/manage_activity/add_edit,frontweb/manage_activity/delete' WHERE `plused_role_menu`.`mnu_menuid` = 275;




/* Date: 22-Jan-2018 | Sourav Dhara */

UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/program/add,frontweb/program/process,frontweb/program/add_edit' WHERE `plused_role_menu`.`mnu_menuid` = 254;



/* Date: 29-Jan-2018 | Sourav Dhara */

UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/junior_centre/add,frontweb/junior_centre/process,frontweb/junior_centre/upload_pdf_management,frontweb/junior_centre/photo_gallery,frontweb/junior_centre/photo_gallery_add,frontweb/junior_centre/delete_photo_gallery,frontweb/junior_centre/add_edit' WHERE `plused_role_menu`.`mnu_menuid` = 264;



/* Date: 6-Feb-2018 | Sourav Dhara */

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'Section setting', '', 'frontweb/section_setting', '1', '2', 'Left', '9', '', '2018-02-06 00:00:00', '1', '2018-02-06 00:00:00', '1', '0');



/* Date: 13-Feb-2018 | Sourav Dhara */

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'Manage ministay program', '', 'frontweb/ministay_program', '1', '2', 'Left', '10', '', '2018-02-13 00:00:00', '1', '2018-02-13 00:00:00', '1', '0');

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '277', 'Add ministay program', 'Internal link', 'frontweb/ministay_program/add_edit', '1', '3', 'Left', '1', '', '2018-02-13 00:00:00', '1', '2018-02-13 00:00:00', '1', '0');

UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/ministay_program/add_edit,frontweb/ministay_program/process,frontweb/ministay_program/delete' WHERE `plused_role_menu`.`mnu_menuid` = 278;



/* Date: 14-Feb-2018 | Sourav Dhara */

INSERT INTO `plused_role_menu` (`mnu_menuid`, `mnu_parent_menu_id`, `mnu_menu_name`, `mnu_caption`, `mnu_url`, `mnu_status`, `mnu_level`, `mnu_type`, `mnu_sequence`, `mnu_icon_class`, `mnu_created_on`, `mnu_created_by`, `mnu_modified_on`, `mnu_modified_by`, `is_deleted`) VALUES (NULL, '249', 'Manage Adult Course', '', 'frontweb/manage_adult_course', '1', '2', 'Left', '11', '', '2018-02-14 00:00:00', '1', '2018-02-14 00:00:00', '1', '0'),
 (NULL, '279', 'Add Adult course', 'Internal link', 'frontweb/manage_adult_course/add_edit', '1', '3', 'Left', '1', '', '2018-02-14 00:00:00', '1', '2018-02-14 00:00:00', '1', '0');
 
UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/master/index/manage_adult_course' WHERE `plused_role_menu`.`mnu_menuid` = 279;
UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/master/add_edit/manage_adult_course,frontweb/master/process,frontweb/master/delete/manage_adult_course' WHERE `plused_role_menu`.`mnu_menuid` = 280; 



/* Date: 19-Feb-2018 | Sourav Dhara */

UPDATE `plused_role_menu` SET `mnu_url` = 'frontweb/junior_centre/add,frontweb/junior_centre/process,frontweb/junior_centre/upload_pdf_management,frontweb/junior_centre/photo_gallery,frontweb/junior_centre/photo_gallery_add,frontweb/junior_centre/delete_photo_gallery,frontweb/junior_centre/add_edit,frontweb/junior_centre/add_video_gallery_management' WHERE `plused_role_menu`.`mnu_menuid` = 264; 

UPDATE `plused_role_menu` SET `mnu_url` = 'junior_ministay/add_edit,frontweb/junior_ministay/process,frontweb/junior_ministay/photo_gallery,frontweb/junior_ministay/delete_photo_gallery,frontweb/junior_ministay/add_video_gallery_management' WHERE `plused_role_menu`.`mnu_menuid` = 269; 