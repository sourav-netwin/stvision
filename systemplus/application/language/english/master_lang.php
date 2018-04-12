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
			'columnNo' => 3
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
?>