<?php
	/*Function is used to check whether any user is logged in to the system or not . If any user
	will not login to the system then it will redirect to the login page*/
	function checkAdminLogin()
	{
		$CI = &get_instance();
		if($CI->session->userdata('logged_in'))
			return TRUE;
		else
			redirect(base_url().'admin/login/index');
	}

	//This function is used to generate random string of provided length
	function rand_string($length = NULL)
	{
		$chars = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		return substr(str_shuffle($chars) , 0 , $length);
	}

	//This function is used to generate some unique and large string to validate form submission.
	function generateToken($formName = NULL)
	{
		$CI = &get_instance();
		$sessionId = $CI->session->userdata('session_id');
		$sessionId = $sessionId.time();
		$sSecurityTocken = sha1($formName.$sessionId.ENCRYPTKEY);
		$CI->session->set_userdata('securityTocken' , $sSecurityTocken);
		return $sSecurityTocken;
	}

	//This function is used to validate generated string for form submission.
	function checkToken($token = NULL)
	{
		$CI = &get_instance();
		return $token === $CI->session->userdata('securityTocken');
	}

	//Function is used to check if there is any unwanted character is present or not
	function xssExpressionMatch($aCheckData = NULL)
	{
		foreach($aCheckData as $sData)
		{
			if(preg_match("/[()+<,>\"\'%&;]/i", $sData))
				return false;
		}
		return true;
	}

	//This function is used to get language details from DB and use in dropdown
	function getLanguageDetails()
	{
		$returnArr[''] = 'Please Select';
		$CI = &get_instance();
		$result = $CI->db->select('language_id , language_name')
						->get(TABLE_LANGUAGE)->result_array();
		if(!empty($result))
		{
			foreach($result as $value)
				$returnArr[$value['language_id']] = $value['language_name'];
		}
		return $returnArr;
	}

	//Function is used to create the name of the thumb image
	if(!function_exists('getThumbnailName'))
	{
		function getThumbnailName($thumbnailImage = NULL)
		{
			if(!empty($thumbnailImage))
			{
				$thumbnailImage = pathinfo($thumbnailImage);
				if(COUNT($thumbnailImage)){
					$extn = $thumbnailImage['extension'];
					$filename = $thumbnailImage['filename'];
					$thumbnailImage = $filename."_thumb.".$extn;
				}
			}
			return $thumbnailImage;
		}
	}

	//This function is used to get centre details from DB and use in dropdown
	function getCentreDetails()
	{
		$returnArr[''] = 'Please Select Centre';
		$CI = &get_instance();
		$result = $CI->db->select('id , nome_centri')
						->where('attivo' , 1)
						->or_where('(is_mini_stay = 1 and attivo = 0)')
						->order_by('nome_centri' , 'asc')
						->get(TABLE_CENTRE)->result_array();
		if(!empty($result))
		{
			foreach($result as $value)
				$returnArr[$value['id']] = $value['nome_centri'];
		}
		return $returnArr;
	}

	//This function is used to get centre details from DB and use in dropdown
	function getCourseProgramDetails()
	{
		$returnArr = array();
		$CI = &get_instance();
		$result = $CI->db->select('program_course_id , program_course_name')
						->get(TABLE_PROGRAM_COURSE)->result_array();
		if(!empty($result))
		{
			foreach($result as $value)
				$returnArr[$value['program_course_id']] = $value['program_course_name'];
		}
		return $returnArr;
	}

	//This function is used to get the details of static sections(programs) for junior mini stay management
	function getCourseSectionDetails()
	{
		$CI = &get_instance();
		$returnArr = array();
		$result = $CI->db->select('junior_ministay_static_program_id , program_name')
							->get(TABLE_JUNIOR_MINISTAY_STATIC_PROGRAM)->result_array();
		if(!empty($result))
		{
			foreach($result as $value)
				$returnArr[$value['junior_ministay_static_program_id']] = $value['program_name'];
		}
		return $returnArr;
	}

	//This function is used to get the dropdown value for field type in application form management
	function getFieldDropdown()
	{
		return array(
			'' => 'Please Select',
			'text' => 'Textbox',
			'textarea' => 'Textarea',
			'date' => 'Datepicker',
			'email' => 'Email',
			'radio' => 'Radio Button',
			'dropdown' => 'Dropdown',
			'name' => 'Name',
			'mobile' => 'Mobile'
		);
	}

	//This function is used to get the extra section details for junior centre / junior mini stay
	function getExtraSection($courseId = NULL)
	{
		$returnArr[''] = 'Please Select';
		$CI = &get_instance();
		$result = $CI->db->select('extra_section_id , name')
						->where('course_id' , $courseId)
						->get(TABLE_PLUS_EXTRA_SECTION)->result_array();
		if(!empty($result))
		{
			foreach($result as $value)
				$returnArr[$value['extra_section_id']] = $value['name'];
		}
		return $returnArr;
	}

	/**
	*This function is used to create the from and to time dropdown and return to show in the table section
	*
	*@param String $timeSlot : This is the time slot string
	*@return String : Start and finish time dropdown
	*/
	if(!function_exists('createTimingDropdown'))
	{
		function createTimingDropdown($timeSlot = NULL)
		{
			//For hour
			$hourArr = array('' => 'HH');
			for($i = 0 ; $i <= 23 ; $i++)
			{
				$j = ($i <= 9) ? '0'.$i : $i;
				$hourArr[$j] = $j;
			}
			//For minute
			$minArr = array('' => 'MM');
			for($i = 0 ; $i <= 59 ; $i++)
			{
				$j = ($i <= 9) ? '0'.$i : $i;
				$minArr[$j] = $j;
			}
			$timeSlotArr = explode(':' , $timeSlot);
			return form_dropdown('' , $hourArr , $timeSlotArr[0] , 'class="hourDropdown"')
					.'&nbsp;&nbsp;'.form_dropdown('' , $minArr , $timeSlotArr[1] , 'class="minDropdown"');
		}
	}

	/**
	*This function is used to get the dropdown values for contact person name(used in the activity program managed by column)
	*
	*@param NONE
	*@return NONE
	*/
	if(!function_exists('getContractPersonDropdown'))
	{
		function getContractPersonDropdown()
		{
			$returnArr = array(
				'' => 'Please select'
			);
			$CI = &get_instance();
			$result = $CI->db->select("ta_id as id , concat_ws(' ' ,  ta_firstname , ta_lastname) as name" , FALSE)
								->where('ta_is_deleted' , 0)
								->order_by("concat_ws(' ' ,  ta_firstname , ta_lastname)")
								->get(TABLE_TEACHER_APPLICATION)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr[$value['id']] = $value['name'];
			}
			return $returnArr;
		}
	}
