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
	$lang['manage_fixed_activity']['dbName'] = TABLE_FIXED_DAY_ACTIVITY;
	$lang['manage_fixed_activity']['key'] = 'fixed_day_activity_id';
	$lang['manage_fixed_activity']['title'] = 'Master Activity';
	$lang['manage_fixed_activity']['list'] = array(
		'centre_id' => array(
			'columnTitle' => 'Centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'columnNo' => 1
		),
		'date' => array(
			'columnTitle' => 'Date',
			'type' => 'date',
			'columnNo' => 2
		)
	);
	$lang['manage_fixed_activity']['list']['actionColumn'] = array(
		'columnNo' => 3,
		'actionType' => array('edit')
	);
	$lang['manage_fixed_activity']['field'] = array(
		'centre_id' => array(
			'fieldLabel' => 'Select centre',
			'type' => 'dropdown',
			'module' => 'centre',
			'validation' => 'required'
		),
		'date' => array(
			'fieldLabel' => 'Select date',
			'type' => 'date',
			'validation' => 'required|duplicate:centre_id',
			'placeholder' => 'dd-mm-yyyy'
		),
		'manage_fixed_activity_details' => array(
			'type' => 'subtable',
			'module' => 'manage_fixed_activity_details'
		)
	);
/*---------------For manage fixed activity module(End)---------------*/

/*---------------For manage fixed activity Details module(Start)---------------*/
	$lang['manage_fixed_activity_details']['dbName'] = TABLE_FIXED_DAY_ACTIVITY_DETAILS;
	$lang['manage_fixed_activity_details']['key'] = 'fixed_day_activity_details_id';
	$lang['manage_fixed_activity_details']['foreignKey'] = 'fixed_day_activity_id';
	$lang['manage_fixed_activity_details']['field'] = array(
		'program_name' => array(
			'fieldLabel' => 'Program name',
			'type' => 'text',
			'validation' => 'required',
			'placeholder' => 'Program name'
		),
		'location' => array(
			'fieldLabel' => 'Location',
			'type' => 'text',
			'validation' => 'required',
			'placeholder' => 'Location'
		),
		'activity' => array(
			'fieldLabel' => 'Activity',
			'type' => 'text',
			'validation' => 'required',
			'placeholder' => 'Activity'
		),
		'from_time' => array(
			'fieldLabel' => 'From time',
			'type' => 'time',
			'validation' => 'required'
		),
		'to_time' => array(
			'fieldLabel' => 'To time',
			'type' => 'time',
			'validation' => 'required'
		),
		'managed_by' => array(
			'fieldLabel' => 'Managed by',
			'type' => 'text',
			'validation' => 'required',
			'placeholder' => 'Managed by'
		)
	);
/*---------------For manage fixed activity Details module(End)---------------*/

/*---------------For manage Centre(Start)---------------*/
	$lang['centre']['dbName'] = TABLE_CENTRE;
	$lang['centre']['key'] = 'id';
	$lang['centre']['dropdown'] = array(
		'key' => 'id',
		'value' => 'nome_centri'
	);
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
/*---------------For manage student group module(End)---------------*/
?>