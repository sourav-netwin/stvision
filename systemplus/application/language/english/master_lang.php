<?php
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
?>