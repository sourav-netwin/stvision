<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/* THEME */

//define('APP_THEME', 'OLD');
define('APP_THEME', 'LTE');

if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "192.168.21.11" || $_SERVER['HTTP_HOST'] == "192.168.21.12" || $_SERVER['HTTP_HOST'] == "192.168.43.97")
    define('LTE', '/stvision/vision/lte/');
else
    define('LTE', '/vision_ag/lte/');

define('AGENT_SECTION', 'NEW'); // set this to "NEW" if you want to load new section for agents.

define('LTE_BOOTSTRAP', LTE . '/bootstrap/');
define('LTE_PLUGINS', LTE . '/plugins/');

/* INVOICE BOOKING PDF */
define('BOOKING_INVOICE_FILE', '../teacherApplications/bookinginvoice/');

/* Tuition specific CONSTANTS */
define('CONTRACT_PDF_FILE', '../teacherApplications/teachers/contracts/contract.pdf');
define('COURSE_DIRECTOR_HELP_DOCUMENT', '../teacherApplications/course_director/vision_tuition_guide_for_course_director.pdf');
define('ACADEMIC_CONTRACT_FILE_PATH', '../teacherApplications/academicContracts/');
define('CV_FILE_PATH', '../teacherApplications/cv/');
define('OTHER_FILE_PATH', '../teacherApplications/other/');
define('PASSPORT_ID_CARD_FILE', '../teacherApplications/passportidcard/');
define('OFFICE_OTHER_FILE_PATH', '../teacherApplications/office_other/');
define('SENT_JOB_OFFER_PATH', '../teacherApplications/pdf/');
define('JOB_OFFER_TERM_SPECIFICATION_PATH', '../teacherApplications/pdf/specification/');
define('PLUS_SENDER_EMAIL_ADDRESS', "recruitment@plus-ed.com");
define('PLUS_SELES_SENDER_EMAIL_ADDRESS', "sales@plus-ed.com");

define('CLASS_STUDENTS_AVALABILITY', 15);
define('NATIONALITY_FILES_PATH', "img/flags/nationality/");
/* End:Tuition specific CONTANTS */

/*Start: Constants for excursion export and import*/
define('EXPORT_TEMP_PATH', "/var/www/html/www.plus-ed.com/vision_ag/excel/"); //is the path for temporary storage of operator export files. Change according to server path
//define('EXPORT_TEMP_PATH',"D:/wamp/www/stvision/vision/excel/");//is the path for temporary storage of operator export files. Change according to server path
define('EXPORT_BACKUP_PATH', "/var/www/html/www.plus-ed.com/vision_ag/excel/backup/"); //is the path for storing backup files during import process. Change according to server path
//define('EXPORT_BACKUP_PATH',"D:/wamp/www/stvision/vision/excel/backup/");//is the path for storing backup files during import process. Change according to server path
define('EXPORT_TIME_LIMIT', 300); //is the additional time given for export/import process.
define('EXPORT_MEM_LIMIT', "256M"); //is the additional memory given for export/import process.
/*End: Constants for excursion export and import*/

/*Start : Constants for Rosters section*/
define('PLUS_ROOT', "/var/www/html/www.plus-ed.com/"); //is the root absolute path for plus-ed.com. Change according to server path
/*End : Constants for Rosters section*/

/*Start: constants for CM view*/
define('CMCSV_PATH', "/var/www/html/www.plus-ed.com/vision_ag/downloads/export_csv/" . time() . "_pax_list.csv"); //is the path for saving CM csv files
define('TICKET_CM_PATH', "/var/www/html/www.plus-ed.com/vision_ag/excel/"); //is the path for saving CM ticket attachments
define('TICKET_BO_PATH', "/var/www/html/www.plus-ed.com/vision_ag/excel/"); //is the path for saving backoffice ticket reply attachments
define('TICKET_CM_DWNLD', "http://www.plus-ed.com/vision_ag/excel/"); //is the path for downloading CM ticket attachments
define('TICKET_BO_DWNLD', "http://www.plus-ed.com/vision_ag/excel/"); //is the path for downloading backoffice ticket reply attachments
define('PAYMENT_CM_PATH', "/var/www/html/www.plus-ed.com/vision_ag/excel/cmDocuments/"); //is the path for saving CM payment documents
define('PAYMENT_CM_DWNLD', "http://www.plus-ed.com/vision_ag/excel/cmDocuments/"); //is the path for downloading CM payment documents
/*End: constants for CM view*/

/*Start: constants for Export GL Report view*/

define('BONUS_EXAM_AMOUNT', 20);
define('EXTRA_REIMBURSEMENT', 10);
define('BONUS_PRESENTAZIONE_PERCENT', 0.07);
define('FEE_ACCOMPAGNAMENTO',320);

/*End: constants for Export GL Report view*/

/* Start: constants for Campus */

define('CAMPUS_IMAGE_PATH', '../teacherApplications/campus/images/');
define('CAMPUS_PDF_PATH', '../teacherApplications/campus/pdf/');
define('CAMPUS_SINGLE_PDF_PATH', '../teacherApplications/campus/single_pdf/');
define('CAMPUS_PRICELIST_PDF_PATH', '../teacherApplications/campus/pricelist_pdf/');

define('EXCURSION_IMAGE_PATH', '../teacherApplications/excursion/images/');
// To upload pdf file for agents section.
define('CAMPUS_AGENTS_SINGLE_PDF_PATH', '../teacherApplications/campus/agents_single_pdf/');

/* End: constants for Campus */

/* Start: constants for Booking availability report */

define('AVAILABILITY_DWNLD', 'downloads/export_csv/allCSVAvailability.csv');
define('WEEKLY_AVAILABILITY_DWNLD', 'downloads/export_weekly_report');

/* End: constants for Booking availability report */

define('EXTRA_EXCURSIONS_AND_ATTRACTIONS_ZIP_FILE', 'downloads/agentsmanuals/Extra_Excursion_and_Attraction_Form.zip');

define('CONTRACT_EMPLOYMENT_SUMMER_STAFF','../teacherApplications/ContractofEmploymentSummerStaff.pdf');
define('NO_REPLY_EMAIL','noreply@plus-ed.com');

define('CATEGORY_PROGRAM_IMAGE_PATH','../teacherApplications/category_program/');
define('CROPPING_ASSETS_PATH','lte/cropping/');
define('CATEGORY_PROGRAM_WIDTH',500);
define('CATEGORY_PROGRAM_HEIGHT',500);
define('CATEGORY_PROGRAM_THUMB_WIDTH',100);
define('CATEGORY_PROGRAM_THUMB_HEIGHT',100);

define('CAMPUS_WEBSITE_IMAGE','uploads/campus_image/');
define('CAMPUS_WEBSITE_WIDTH',500);
define('CAMPUS_WEBSITE_HEIGHT',500);
define('CAMPUS_WEBSITE_THUMB_WIDTH',100);
define('CAMPUS_WEBSITE_THUMB_HEIGHT',100);

define('CAMPUS_CONTENT_PDF_FILE','uploads/campus_content_pdf/');

class BookingStatus{
    static $TBC = 1; // TO BE CONFIRMED
    static $ACTIVE = 2; // ACTIVE
    static $CONFIRMED = 3; // confirmed
    static $REJECTED = 4; // rejected
    static $ELAPSED = 5; // elapsed
}

//Database table names
define('TABLE_PROGRAM' , 'frontweb_program_banner');
define('TABLE_PROGRAM_LANGUAGE' , 'frontweb_program_banner_language');
define('TABLE_LANGUAGE' , 'frontweb_language');
define('TABLE_COURSE_MASTER' , 'frontweb_course_master');
define('TABLE_COURSE_LANGUAGE' , 'frontweb_course_language');
define('TABLE_COURSE_SPECIFICATION' , 'frontweb_course_specification');
define('TABLE_COURSE_FEATURE' , 'frontweb_course_feature');
define('TABLE_PROGRAM_COURSE' , 'frontweb_program_course');
define('TABLE_JUNIOR_CENTRE' , 'frontweb_junior_centre');
define('TABLE_JUNIOR_CENTRE_PROGRAM' , 'frontweb_junior_centre_program');
define('TABLE_CENTRE' , 'centri');
define('TABLE_JUNIOR_CENTRE_ADDON' , 'frontweb_junior_centre_addon');
define('TABLE_JUNIOR_CENTRE_FACTSHEET' , 'frontweb_junior_centre_fact_sheet');
define('TABLE_JUNIOR_CENTRE_ACTIVITY_PROGRAM' , 'frontweb_junior_centre_activity_program');
define('TABLE_JUNIOR_CENTRE_MENU' , 'frontweb_junior_centre_menu');
define('TABLE_JUNIOR_CENTRE_WALKING_TOUR' , 'frontweb_junior_centre_walking_tour');
define('TABLE_JUNIOR_CENTRE_DATES' , 'frontweb_junior_centre_dates');
define('TABLE_JUNIOR_CENTRE_DATES_WEEK' , 'frontweb_junior_centre_dates_week');
define('TABLE_JUNIOR_CENTRE_DATES_PROGRAM' , 'frontweb_junior_centre_dates_program');
define('TABLE_JUNIOR_CENTRE_PHOTO_GALLERY' , 'frontweb_junior_centre_photo_gallery');
define('TABLE_JUNIOR_CENTRE_VIDEO_GALLERY' , 'frontweb_junior_centre_video_gallery');
define('TABLE_JUNIOR_CENTRE_INTERNATIONAL_MIX' , 'frontweb_junior_centre_international_mix');
define('TABLE_JUNIOR_MINISTAY' , 'frontweb_junior_ministay');
define('TABLE_JUNIOR_MINISTAY_PHOTOGALLERY' , 'frontweb_junior_ministay_photo_gallery');
define('TABLE_JUNIOR_MINISTAY_VIDEO_GALLERY' , 'frontweb_junior_ministay_video_gallery');
define('TABLE_JUNIOR_MINISTAY_FACT_SHEET' , 'frontweb_junior_ministay_fact_sheet');
define('TABLE_JUNIOR_MINISTAY_ACTIVITY_PROGRAM' , 'frontweb_junior_ministay_activity_program');
define('TABLE_JUNIOR_MINISTAY_ADDON' , 'frontweb_junior_ministay_addon');
define('TABLE_JUNIOR_MINISTAY_MENU' , 'frontweb_junior_ministay_menu');
define('TABLE_JUNIOR_MINISTAY_WALKING_TOUR' , 'frontweb_junior_ministay_walking_tour');
define('TABLE_JUNIOR_MINISTAY_PROGRAM' , 'frontweb_junior_ministay_program');
define('TABLE_JUNIOR_MINISTAY_DATES' , 'frontweb_junior_ministay_dates');
define('TABLE_JUNIOR_MINISTAY_DATES_PROGRAM' , 'frontweb_junior_ministay_dates_program');
define('TABLE_JUNIOR_MINISTAY_DATES_WEEK' , 'frontweb_junior_ministay_dates_week');
define('TABLE_JUNIOR_MINISTAY_INTERNATIONAL_MIX' , 'frontweb_junior_ministay_international_mix');
define('TABLE_JUNIOR_MINISTAY_STATIC_PROGRAM' , 'frontweb_junior_ministay_static_program');
define('TABLE_JUNIOR_MINISTAY_SECTION' , 'frontweb_junior_ministay_section');
define('TABLE_ADULT_COURSE_BROCHURE' , 'frontweb_adult_course_brochure');
define('TABLE_MANAGE_APPLICATION_FORM' , 'frontweb_manage_application_form');
define('TABLE_APPLICATION_FORM_DATA' , 'frontweb_application_form_data');
define('TABLE_PLUS_VIDEO' , 'frontweb_plus_video');
define('TABLE_PLUS_WALKING_TOUR' , 'frontweb_plus_walking_tour');
define('TABLE_PLUS_ACTIVITY_MANAGEMENT' , 'frontweb_plus_activity');
define('TABLE_PLUS_SECTION_SETTING' , 'frontweb_section_setting');
define('TABLE_PLUS_EXTRA_SECTION' , 'frontweb_extra_section');
define('TABLE_PLUS_EXTRA_SECTION_CONTENT' , 'frontweb_extra_section_content');
define('TABLE_PLUS_MANAGE_ADULT_COURSE' , 'frontweb_manage_adult_course');

//Constant for create folder permission
define('DIR_PERMISSION' , 0755);

//Define the upload image size
define('UPLOAD_IMAGE_SIZE' , 10000);

//Google API Key
define('GOOGLE_API_KEY' , 'AIzaSyAxAOuX6VZ3411GsROuhn-SxYbNC0skt9M');

//Define image location , height , width , thumb details for program banner module images
define('PROGRAM_IMAGE_PATH' , 'uploads/program/');
define('PROGRAM_WIDTH' , 1920);
define('PROGRAM_HEIGHT' , 500);
define('PROGRAM_THUMB_WIDTH' , 250);
define('PROGRAM_THUMB_HEIGHT' , 65);

//Define image location , height , width , thumb details for program module images
define('COURSE_IMAGE_PATH' , 'uploads/course/');
define('COURSE_WIDTH' , 1920);
define('COURSE_HEIGHT' , 500);
define('COURSE_THUMB_WIDTH' , 250);
define('COURSE_THUMB_HEIGHT' , 65);

define('COURSE_FRONT_IMAGE_PATH' , 'uploads/course_front/');
define('COURSE_FRONT_WIDTH' , 800);
define('COURSE_FRONT_HEIGHT' , 500);
define('COURSE_FRONT_THUMB_WIDTH' , 250);
define('COURSE_FRONT_THUMB_HEIGHT' , 156);

//Define image location , height , width , thumb details for program course module images
define('PROGRAM_COURSE_IMAGE_PATH' , 'uploads/program_course/');
define('PROGRAM_COURSE_WIDTH' , 200);
define('PROGRAM_COURSE_HEIGHT' , 187);
define('PROGRAM_COURSE_THUMB_WIDTH' , 90);
define('PROGRAM_COURSE_THUMB_HEIGHT' , 84);

//Define image location , height , width , thumb details for Junior Centre module images
define('JUNIOR_CENTRE_IMAGE_PATH' , 'uploads/junior_centre/');
define('JUNIOR_CENTRE_WIDTH' , 1920);
define('JUNIOR_CENTRE_HEIGHT' , 500);
define('JUNIOR_CENTRE_THUMB_WIDTH' , 250);
define('JUNIOR_CENTRE_THUMB_HEIGHT' , 65);

//Define image location , height , width , thumb details for My profile module images
define('MY_PROFILE_IMAGE_PATH' , 'uploads/users/');
define('MY_PROFILE_WIDTH' , 128);
define('MY_PROFILE_HEIGHT' , 128);
define('MY_PROFILE_THUMB_WIDTH' , 57);
define('MY_PROFILE_THUMB_HEIGHT' , 57);

//Define file upload location details for add on module
define('ADD_ON_FILE_PATH' , 'uploads/addon/');

//Define file upload location details for fact sheet module
define('FACTSHEET_FILE_PATH' , 'uploads/factsheet/');

//Define file upload location details for activity program module
define('ACTIVITY_PROGRAM_FILE_PATH' , 'uploads/activity_program/');

//Define file upload location details for menu module
define('MENU_FILE_PATH' , 'uploads/menu/');

//Define file upload location details for menu module
define('WALKING_TOUR_FILE_PATH' , 'uploads/walking_tour/');

//Define image location , height , width , thumb details for junior centre photo gallery images
define('PHOTO_GALLERY_IMAGE_PATH' , 'uploads/photo_gallery/');
define('PHOTO_GALLERY_WIDTH' , 800);
define('PHOTO_GALLERY_HEIGHT' , 600);
define('PHOTO_GALLERY_THUMB_WIDTH' , 200);
define('PHOTO_GALLERY_THUMB_HEIGHT' , 112);

//Define image location , height , width , thumb details for junior centre photo gallery images
define('VIDEO_GALLERY_IMAGE_PATH' , 'uploads/video_gallery/');
define('VIDEO_GALLERY_WIDTH' , 800);
define('VIDEO_GALLERY_HEIGHT' , 600);
define('VIDEO_GALLERY_THUMB_WIDTH' , 200);
define('VIDEO_GALLERY_THUMB_HEIGHT' , 112);

//Define image location , height , width , thumb details for Junior Mini Stay module images
define('JUNIOR_MINISTAY_IMAGE_PATH' , 'uploads/junior_ministay/');
define('JUNIOR_MINISTAY_WIDTH' , 1920);
define('JUNIOR_MINISTAY_HEIGHT' , 500);
define('JUNIOR_MINISTAY_THUMB_WIDTH' , 250);
define('JUNIOR_MINISTAY_THUMB_HEIGHT' , 65);

//Define image location , height , width , thumb details for junior mini stay photo gallery images
define('MINISTAY_PHOTO_GALLERY_IMAGE_PATH' , 'uploads/ministay_photo_gallery/');
define('MINISTAY_PHOTO_GALLERY_WIDTH' , 800);
define('MINISTAY_PHOTO_GALLERY_HEIGHT' , 600);
define('MINISTAY_PHOTO_GALLERY_THUMB_WIDTH' , 200);
define('MINISTAY_PHOTO_GALLERY_THUMB_HEIGHT' , 112);

//Define image location , height , width , thumb details for junior mini stay video gallery images
define('MINISTAY_VIDEO_GALLERY_IMAGE_PATH' , 'uploads/ministay_video_gallery/');
define('MINISTAY_VIDEO_GALLERY_WIDTH' , 800);
define('MINISTAY_VIDEO_GALLERY_HEIGHT' , 600);
define('MINISTAY_VIDEO_GALLERY_THUMB_WIDTH' , 200);
define('MINISTAY_VIDEO_GALLERY_THUMB_HEIGHT' , 112);

//Define file upload location details for fact sheet module for junior ministay courses
define('MINISTAY_FACTSHEET_FILE_PATH' , 'uploads/ministay_factsheet/');

//Define file upload location details for activity program module for junior ministay courses
define('MINISTAY_ACTIVITY_PROGRAM_FILE_PATH' , 'uploads/ministay_activity_program/');

//Define file upload location details for addon module for junior ministay courses
define('MINISTAY_ADDON_FILE_PATH' , 'uploads/ministay_addon/');

//Define file upload location details for menu module for junior ministay courses
define('MINISTAY_MENU_FILE_PATH' , 'uploads/ministay_menu/');

//Define file upload location details for walking tour module for junior ministay courses
define('MINISTAY_WALKING_TOUR_FILE_PATH' , 'uploads/ministay_walking_tour/');

//Define file upload location details for brochure module for adult courses
define('ADULT_COURSE_BROCHURE' , 'uploads/adult_course_brochure/');

//Constants for the Adult course id
define('ADULT_COURSE_ID' , 13);

//Define image location , height , width , thumb details for program course home page images
define('PROGRAM_FRONT_IMAGE_PATH' , 'uploads/program_course_front/');
define('PROGRAM_FRONT_WIDTH' , 624);
define('PROGRAM_FRONT_HEIGHT' , 416);
define('PROGRAM_FRONT_THUMB_WIDTH' , 200);
define('PROGRAM_FRONT_THUMB_HEIGHT' , 133);

//Define file upload location details for plus walking tour videoes
define('PLUS_WALKING_TOUR' , 'uploads/plus_walking_tour/');

//Define file upload location details for plus walking tour videoes
define('ACTIVITY_FILE_PATH' , 'uploads/manage_activity/');

//Define file upload location details for extra section content
define('EXTRA_SECTION_FILE_PATH' , 'uploads/extra_section/');

//Define section setting dropdown value
define('SECTION_SETTING_DROPDOWN' , serialize(array(1 => 'Junior Centre' , 2 => 'Junior Ministay')));

//Define image location , height , width , thumb details for ministay program module images
define('MINISTAY_PROGRAM_IMAGE_PATH' , 'uploads/ministay_program/');
define('MINISTAY_PROGRAM_WIDTH' , 200);
define('MINISTAY_PROGRAM_HEIGHT' , 200);
define('MINISTAY_PROGRAM_THUMB_WIDTH' , 90);
define('MINISTAY_PROGRAM_THUMB_HEIGHT' , 90);

//Define image location , height , width , thumb details for adult course images
define('ADULT_COURSE_IMAGE_PATH' , 'uploads/adult_course/');
define('ADULT_COURSE_WIDTH' , 1920);
define('ADULT_COURSE_HEIGHT' , 500);
define('ADULT_COURSE_THUMB_WIDTH' , 250);
define('ADULT_COURSE_THUMB_HEIGHT' , 65);

/* End of file constants.php */
/* Location: ./system/application/config/constants.php */
