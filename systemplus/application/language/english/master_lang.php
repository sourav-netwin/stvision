<?php
/*---------------For manage adult course module(Start)---------------*/
	$lang['manage_adult_course']['dbName'] = TABLE_PLUS_MANAGE_ADULT_COURSE;
	$lang['manage_adult_course']['key'] = 'adult_course_id';
	$lang['manage_adult_course']['title'] = 'Adult Course';
	$lang['manage_adult_course']['list'] = array(
		'title' => array(
			'columnTitle' => 'Title',
			'type' => 'text',
			'columnNo' => 1
		),
		'slug' => array(
			'columnTitle' => 'Slug',
			'type' => 'text',
			'columnNo' => 2
		),
		'image' => array(
			'columnTitle' => 'Image',
			'type' => 'image',
			'uploadPath' => ADULT_COURSE_IMAGE_PATH,
			'columnNo' => 3,
			'thumbHeight' => ADULT_COURSE_THUMB_HEIGHT,
			'thumbWidth' => ADULT_COURSE_THUMB_WIDTH
		)
	);
	$lang['manage_adult_course']['list']['actionColumn'] = array(
		'columnNo' => 4,
		'actionType' => array('edit' , 'delete' , 'status')
	);
	$lang['manage_adult_course']['listWhere'] = 'delete_flag = 0';
	$lang['manage_adult_course']['statusField'] = 'status';
	$lang['manage_adult_course']['field'] = array(
		'title' => array(
			'fieldLabel' => 'Title',
			'type' => 'text',
			'validation' => 'required|validData|maxlength:200',
			'placeholder' => 'Title'
		),
		'slug' => array(
			'fieldLabel' => 'Slug',
			'type' => 'text',
			'validation' => 'required|validData|maxlength:200|duplicate',
			'placeholder' => 'Slug'
		),
		'description' => array(
			'fieldLabel' => 'Description',
			'type' => 'textarea',
			'rows' => 2,
			'validation' => 'required',
			'summernote' => 1
		),
		'image' => array(
			'fieldLabel' => 'Upload image',
			'type' => 'file',
			'fileType' => 'image',
			'validation' => 'imageRequired|checkImageExt|checkImageWidth',
			'uploadPath' => ADULT_COURSE_IMAGE_PATH,
			'width' => ADULT_COURSE_WIDTH,
			'height' => ADULT_COURSE_HEIGHT,
			'thumbHeight' => ADULT_COURSE_THUMB_HEIGHT,
			'thumbWidth' => ADULT_COURSE_THUMB_WIDTH
		)
	);
/*---------------For manage adult course module(End)---------------*/

/*---------------For manage fixed activity module(Start)---------------*/
	$lang['manage_fixed_activity']['dbName'] = TABLE_MASTER_ACTIVITY;
	$lang['manage_fixed_activity']['key'] = 'master_activity_id';
	$lang['manage_fixed_activity']['title'] = 'Master Activity';
	$lang['manage_fixed_activity']['list'] = array(
		'centre_id' => array(
			'columnTitle' => 'Centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'columnNo' => 1
		),
		'student_group' => array(
			'columnTitle' => 'Student\'s group',
			'type' => 'dropdown',
			'module' => 'manage_student_group',
			'columnNo' => 2
		),
		'activity_name' => array(
			'columnTitle' => 'Activity name',
			'type' => 'text',
			'columnNo' => 3
		),
		'arrival_date' => array(
			'columnTitle' => 'Arrival date',
			'type' => 'date',
			'columnNo' => 4
		),
		'departure_date' => array(
			'columnTitle' => 'Departure date',
			'type' => 'date',
			'columnNo' => 5
		)
	);
	$lang['manage_fixed_activity']['list']['actionColumn'] = array(
		'columnNo' => 6,
		'actionType' => array('edit' , 'delete')
	);
	$lang['manage_fixed_activity']['deleteCheck'] = 'manage_master_activity_dates';
/*---------------For manage fixed activity module(End)---------------*/

/*---------------For manage master activity dates(Start)---------------*/
	$lang['manage_master_activity_dates']['dbName'] = TABLE_FIXED_DAY_ACTIVITY;
	$lang['manage_master_activity_dates']['key'] = 'fixed_day_activity_id';
	$lang['manage_master_activity_dates']['foreignKey'] = 'master_activity_id';
	$lang['manage_master_activity_dates']['deleteCheck'] = 'manage_master_activity_details';
/*---------------For manage master activity dates(End)---------------*/

/*---------------For manage master activity details(Start)---------------*/
	$lang['manage_master_activity_details']['dbName'] = TABLE_FIXED_DAY_ACTIVITY_DETAILS;
	$lang['manage_master_activity_details']['key'] = 'fixed_day_activity_details_id';
	$lang['manage_master_activity_details']['foreignKey'] = 'fixed_day_activity_id';
	$lang['manage_master_activity_details']['deleteCheck'] = 'manage_master_activity_managedby';
/*---------------For manage master activity details(End)---------------*/

/*---------------For manage master activity managed by(Start)---------------*/
	$lang['manage_master_activity_managedby']['dbName'] = TABLE_FIXED_DAY_MANAGED_BY;
	$lang['manage_master_activity_managedby']['key'] = 'fixed_day_managed_by_id';
	$lang['manage_master_activity_managedby']['foreignKey'] = 'fixed_day_activity_details_id';
/*---------------For manage master activity managed by(End)---------------*/

/*---------------For manage Centre(Start)---------------*/
	$lang['centre']['dbName'] = TABLE_CENTRE;
	$lang['centre']['key'] = 'id';
	$lang['centre']['dropdown'] = array(
		'key' => 'id',
		'value' => 'nome_centri'
	);
	$lang['centre']['listWhere'] = '((attivo = 1) OR (is_mini_stay = 1 AND attivo = 0))';
/*---------------For manage Centre(End)---------------*/

/*---------------For manage student group module(Start)---------------*/
	$lang['manage_student_group']['dbName'] = TABLE_STUDENT_GROUP;
	$lang['manage_student_group']['key'] = 'student_group_id';
	$lang['manage_student_group']['title'] = 'Student Group';
	$lang['manage_student_group']['list'] = array(
		'centre_id' => array(
			'columnTitle' => 'Centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'columnNo' => 1
		),
		'group_name' => array(
			'columnTitle' => 'Group name',
			'type' => 'text',
			'columnNo' => 2
		),
		'group_strength' => array(
			'columnTitle' => 'Group strength',
			'type' => 'text',
			'columnNo' => 3
		)
	);
	$lang['manage_student_group']['list']['actionColumn'] = array(
		'columnNo' => 4,
		'actionType' => array('edit' , 'delete' , 'status')
	);
	$lang['manage_student_group']['listWhere'] = 'delete_flag = 0';
	$lang['manage_student_group']['statusField'] = 'status';
	$lang['manage_student_group']['field'] = array(
		'centre_id' => array(
			'fieldLabel' => 'Select centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'validation' => 'required'
		),
		'group_name' => array(
			'fieldLabel' => 'Group name',
			'type' => 'text',
			'validation' => 'required|validData|maxlength:200',
			'placeholder' => 'Group name'
		),
		'group_strength' => array(
			'fieldLabel' => 'Group strength',
			'type' => 'text',
			'validation' => 'required|numeric',
			'placeholder' => 'Group strength'
		)
	);
	$lang['manage_student_group']['dropdown'] = array(
		'key' => 'student_group_id',
		'value' => 'group_name'
	);
/*---------------For manage student group module(End)---------------*/

/*---------------For manage fixed activity module(Start)---------------*/
	$lang['manage_extra_activity']['dbName'] = TABLE_EXTRA_MASTER_ACTIVITY;
	$lang['manage_extra_activity']['key'] = 'extra_master_activity_id';
	$lang['manage_extra_activity']['deleteCheck'] = 'manage_extra_activity_dates';
/*---------------For manage fixed activity module(End)---------------*/

/*---------------For manage master activity dates(Start)---------------*/
	$lang['manage_extra_activity_dates']['dbName'] = TABLE_EXTRA_DAY_ACTIVITY;
	$lang['manage_extra_activity_dates']['key'] = 'extra_day_activity_id';
	$lang['manage_extra_activity_dates']['foreignKey'] = 'extra_master_activity_id';
	$lang['manage_extra_activity_dates']['deleteCheck'] = 'manage_extra_activity_details';
/*---------------For manage master activity dates(End)---------------*/

/*---------------For manage master activity details(Start)---------------*/
	$lang['manage_extra_activity_details']['dbName'] = TABLE_EXTRA_DAY_ACTIVITY_DETAILS;
	$lang['manage_extra_activity_details']['key'] = 'extra_day_activity_details_id';
	$lang['manage_extra_activity_details']['foreignKey'] = 'extra_day_activity_id ';
	$lang['manage_extra_activity_details']['deleteCheck'] = 'manage_extra_activity_managedby';
/*---------------For manage master activity details(End)---------------*/

/*---------------For manage master activity managed by(Start)---------------*/
	$lang['manage_extra_activity_managedby']['dbName'] = TABLE_EXTRA_DAY_MANAGED_BY;
	$lang['manage_extra_activity_managedby']['key'] = 'extra_day_managed_by_id';
	$lang['manage_extra_activity_managedby']['foreignKey'] = 'extra_day_activity_details_id';
/*---------------For manage master activity managed by(End)---------------*/

/*---------------For manage walking tour module(Start)---------------*/
	$lang['manage_walking_tour']['dbName'] = TABLE_PLUS_WALKING_TOUR;
	$lang['manage_walking_tour']['key'] = 'plus_walking_tour_id';
	$lang['manage_walking_tour']['title'] = 'Walking Tour';
	$lang['manage_walking_tour']['list'] = array(
		'video_image' => array(
			'columnTitle' => 'Image',
			'type' => 'image',
			'uploadPath' => WALKING_TOUR_VIDEO_IMAGE_PATH,
			'columnNo' => 1,
			'thumbHeight' => WALKING_TOUR_VIDEO_IMAGE_THUMB_HEIGHT,
			'thumbWidth' => WALKING_TOUR_VIDEO_IMAGE_THUMB_WIDTH
		),
		'centre_id' => array(
			'columnTitle' => 'Centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'columnNo' => 2
		),
		'video' => array(
			'columnTitle' => 'Video link',
			'type' => 'link',
			'columnNo' => 3
		),
		'description' => array(
			'columnTitle' => 'Description',
			'type' => 'text',
			'columnNo' => 4
		)
	);
	$lang['manage_walking_tour']['list']['actionColumn'] = array(
		'columnNo' => 5,
		'actionType' => array('edit' , 'delete' , 'status')
	);
	$lang['manage_walking_tour']['listWhere'] = 'delete_flag = 0';
	$lang['manage_walking_tour']['statusField'] = 'status';
	$lang['manage_walking_tour']['field'] = array(
		'centre_id' => array(
			'fieldLabel' => 'Select centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'validation' => 'required'
		),
		'video' => array(
			'fieldLabel' => 'Video Url',
			'type' => 'text',
			'validation' => 'required|url|validVimeoUrl|maxlength:200',
			'placeholder' => 'Ex : http://vimeo.com/123456789'
		),
		'description' => array(
			'fieldLabel' => 'Description',
			'type' => 'textarea',
			'rows' => 2,
			'validation' => 'required'
		),
		'video_image' => array(
			'fieldLabel' => 'Upload video image',
			'type' => 'file',
			'fileType' => 'image',
			'validation' => 'imageRequired|checkImageExt|checkImageWidth',
			'uploadPath' => WALKING_TOUR_VIDEO_IMAGE_PATH,
			'width' => WALKING_TOUR_VIDEO_IMAGE_WIDTH,
			'height' => WALKING_TOUR_VIDEO_IMAGE_HEIGHT,
			'thumbHeight' => WALKING_TOUR_VIDEO_IMAGE_THUMB_HEIGHT,
			'thumbWidth' => WALKING_TOUR_VIDEO_IMAGE_THUMB_WIDTH
		)
	);
/*---------------For manage student group module(End)---------------*/

/*---------------For manage activity photo gallery module(Start)---------------*/
	$lang['manage_activity_photogallery']['dbName'] = TABLE_ACTIVITY_PHOTO_GALLERY;
	$lang['manage_activity_photogallery']['key'] = 'activity_photo_gallery_id';
	$lang['manage_activity_photogallery']['title'] = 'Activity Photo Gallery';
	$lang['manage_activity_photogallery']['list'] = array(
		'image_name' => array(
			'columnTitle' => 'Image',
			'type' => 'image',
			'uploadPath' => ACTIVITY_PHOTOGALLERY_IMAGE_PATH,
			'columnNo' => 1,
			'thumbHeight' => ACTIVITY_PHOTOGALLERY_IMAGE_THUMB_HEIGHT,
			'thumbWidth' => ACTIVITY_PHOTOGALLERY_IMAGE_THUMB_WIDTH
		),
		'centre_id' => array(
			'columnTitle' => 'Centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'columnNo' => 2
		),
		'added_date' => array(
			'columnTitle' => 'Added date',
			'type' => 'datetime',
			'columnNo' => 3
		)
	);
	$lang['manage_activity_photogallery']['list']['actionColumn'] = array(
		'columnNo' => 4,
		'actionType' => array('edit' , 'delete' , 'status')
	);
	$lang['manage_activity_photogallery']['listWhere'] = 'delete_flag = 0';
	$lang['manage_activity_photogallery']['statusField'] = 'status';
	$lang['manage_activity_photogallery']['field'] = array(
		'centre_id' => array(
			'fieldLabel' => 'Select centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'validation' => 'required'
		),
		'image_name' => array(
			'fieldLabel' => 'Upload image',
			'type' => 'file',
			'fileType' => 'image',
			'validation' => 'imageRequired|checkImageExt|checkImageWidth',
			'uploadPath' => ACTIVITY_PHOTOGALLERY_IMAGE_PATH,
			'width' => ACTIVITY_PHOTOGALLERY_IMAGE_WIDTH,
			'height' => ACTIVITY_PHOTOGALLERY_IMAGE_HEIGHT,
			'thumbHeight' => ACTIVITY_PHOTOGALLERY_IMAGE_THUMB_HEIGHT,
			'thumbWidth' => ACTIVITY_PHOTOGALLERY_IMAGE_THUMB_WIDTH
		)
	);
	$lang['manage_activity_photogallery']['addedDateField'] = 'added_date';
/*---------------For manage activity photo gallery module(End)---------------*/
?>