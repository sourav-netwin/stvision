<?php
	class Extra_activity extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			authSessionMenu($this);
			$this->load->helper('frontweb/backend');
			$this->lang->load('message' , 'english');
			$this->load->model('frontweb/admin_model' , '' , TRUE);
			$this->load->model('frontweb/extra_activity_model' , '' , TRUE);
		}

		//This function is used to show the extra activity management page
		function index()
		{
			$post = array();
			$groupDropdown = array('' => 'Please select group');
			$groupReferenceDropdown = array('' => 'Please select group reference');
			if($this->input->post('centre_id'))
			{
				$post = $this->admin_model->commonGetData("date_format(arrival_date , '%d-%b-%Y') as arrival_date , date_format(departure_date , '%d-%b-%Y') as departure_date" , 'id_book = '.$this->input->post('group_reference_id') , TABLE_PLUS_BOOK , 1);
				$post['centre_id'] = $this->input->post('centre_id');
				$post['student_group'] = $this->input->post('student_group');
				$post['group_reference_id'] = $this->input->post('group_reference_id');
				//Set dropdown for student group and group reference
				$dropdownValueArr = $this->get_dropdown(1);
				if(!empty($dropdownValueArr['groupReference']))
				{
					foreach($dropdownValueArr['groupReference'] as $value)
						$groupReferenceDropdown[$value['id']] = $value['name'];
				}
				if(!empty($dropdownValueArr['studentGroup']))
				{
					foreach($dropdownValueArr['studentGroup'] as $value)
						$groupDropdown[$value['id']] = $value['name'];
				}
				$extraActivityId = $this->admin_model->commonGetData("extra_master_activity_id" , 'centre_id = '.$this->input->post('centre_id').' AND student_group = '.$this->input->post('student_group').' AND group_reference_id = '.$this->input->post('group_reference_id') , TABLE_EXTRA_MASTER_ACTIVITY , 1);
				if(empty($extraActivityId))
					$this->copyMasterActivity();
				else
				{
					$tempArr = $this->extra_activity_model->getExtraActivityDetails($extraActivityId['extra_master_activity_id']);
					$post = array_merge($post , $tempArr);
				}
			}
			$data['post'] = $post;
			$data['groupDropdown'] = $groupDropdown;
			$data['groupReferenceDropdown'] = $groupReferenceDropdown;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Extra activity';
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/extra_activity' , $data);
		}

		/**
		*This function is used to copy all master activity details in to the extra activity table
		*
		*@param NONE
		*@return NONE
		*/
		private function copyMasterActivity()
		{
			$masterActivityDetails = $this->extra_activity_model->getMaterActivityDetails();
			if(!empty($masterActivityDetails))
			{
				$insertData = array(
					'centre_id' => $this->input->post('centre_id'),
					'student_group' => $this->input->post('student_group'),
					'group_reference_id' => $this->input->post('group_reference_id')
				);
				$extraMasterId = $this->admin_model->commonAdd(TABLE_EXTRA_MASTER_ACTIVITY , $insertData);
				foreach($masterActivityDetails as $dateValue => $detailsValue)
				{
					$insertData = array(
						'extra_master_activity_id' => $extraMasterId,
						'date' => $dateValue
					);
					$extraActivityId = $this->admin_model->commonAdd(TABLE_EXTRA_DAY_ACTIVITY , $insertData);
					foreach($detailsValue as $insertValue)
					{
						$insertValue['extra_day_activity_id'] = $extraActivityId;
						$this->admin_model->commonAdd(TABLE_EXTRA_DAY_ACTIVITY_DETAILS , $insertValue);
					}
				}
			}
			return TRUE;
		}

		/**
		*This function is used to perform add or edit operations for the activity details through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function activity_details_add_edit()
		{
			$activityDetailsIdArr = array();
			if($this->input->post('flag'))
			{
				$parentIdArr = explode(',' , $this->input->post('activityDetailsParentId'));
				foreach($parentIdArr as $idValue)
				{
					$insertData = array(
						'program_name' => $this->input->post('program_name'),
						'location' => $this->input->post('location'),
						'activity' => $this->input->post('activity'),
						'from_time' => $this->input->post('from_time'),
						'to_time' => $this->input->post('to_time'),
						'managed_by' => $this->input->post('managed_by'),
						'extra_day_activity_id' => $idValue
					);
					if($this->input->post('flag') == 'as')
						$activityDetailsIdArr[] = $this->admin_model->commonAdd(TABLE_EXTRA_DAY_ACTIVITY_DETAILS , $insertData);
					else
						$this->admin_model->commonUpdate(TABLE_EXTRA_DAY_ACTIVITY_DETAILS , "extra_day_activity_id = ".$idValue." AND extra_day_activity_details_id in (".$this->input->post('activityDetailsId').")" , $insertData);
				}
				echo ($this->input->post('flag') == 'as') ? implode(',' , $activityDetailsIdArr) : $this->input->post('activityDetailsId');
			}
		}

		/**
		*This function is used to delete activity details from database through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function delete_activity_details()
		{
			if($this->input->post('id'))
			{
				$this->admin_model->commonDelete(TABLE_EXTRA_DAY_ACTIVITY_DETAILS , 'extra_day_activity_details_id in ('.$this->input->post('id').')');
				echo '';
			}

		}

		/**
		*This function is used to update activity timing through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function update_activity_time()
		{
			if($this->input->post('fieldName'))
			{
				$this->extra_activity_model->updateActivityTiming();
				echo '';
			}
		}

		/**
		*This function is used to get the student's group and the group reference dropdown values
		*through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function get_dropdown($returnType = NULL)
		{
			if($this->input->post('centre_id'))
			{
				$data['groupReference'] = $this->admin_model->commonGetData("id_book as id , concat(id_year , '_' , id_book) as name" , "(status = 'confirmed' OR status = 'active') AND id_centro = ".$this->input->post('centre_id') , TABLE_PLUS_BOOK , 2);
				$data['studentGroup'] = $this->admin_model->commonGetData("group_name as name , student_group_id as id" , 'centre_id = '.$this->input->post('centre_id') , TABLE_STUDENT_GROUP , 2);
				if($returnType == 1)
					return $data;
				else
					echo json_encode($data);
			}
		}
	}
