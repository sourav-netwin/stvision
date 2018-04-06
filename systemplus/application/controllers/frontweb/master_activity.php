<?php
	class Master_activity extends Controller
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
			authSessionMenu($this);
			$this->load->helper('frontweb/backend');
			$this->lang->load('message' , 'english');
			$this->load->model('frontweb/admin_model' , '' , TRUE);
			$this->load->model('frontweb/master_activity_model' , '' , TRUE);
		}

		//This function is used to get the activity details and show in the report
		public function report()
		{
			$post = array();
			$groupDropdown = array('' => 'Please select group');
			if($this->input->post('flag') == 'search')
			{
				$post['centre_id'] = $this->input->post('centre_id');
				$post['student_group'] = $this->input->post('student_group');
				$post['start_date'] = $this->input->post('start_date');
				$post['end_date'] = $this->input->post('end_date');

				//Prepare group dropdown
				$result = $this->admin_model->commonGetData("group_name , student_group_id" , 'centre_id = '.$this->input->post('centre_id') , TABLE_STUDENT_GROUP , 2);
				if(!empty($result))
				{
					foreach($result as $value)
						$groupDropdown[$value['student_group_id']] = $value['group_name'];
				}

				//Save the post value for in session for the export to excel option
				$this->session->set_userdata('centre_id' , $this->input->post('centre_id'));
				$this->session->set_userdata('student_group' , $this->input->post('student_group'));
				$this->session->set_userdata('start_date' , $this->input->post('start_date'));
				$this->session->set_userdata('end_date' , $this->input->post('end_date'));
				$this->session->set_userdata('whereCondition' , '');

				$post['details'] = $this->master_activity_model->getActivityReport();
				$post['dropdownArr'] = $this->master_activity_model->getActivityFilterDropdown();
			}
			$data['post'] = $post;
			$data['groupDropdown'] = $groupDropdown;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Activity report';
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/activity_report' , $data);
		}

		//This function is usd to get the activity report ater filter search through the dropdown filter in ajax call
		public function filter_search()
		{
			if($this->input->post('centre_id'))
			{
				$whereCondition = ($this->input->post('whereCondition') != '') ? implode(' AND ' , $this->input->post('whereCondition')) : NULL;

				//Save the post value for in session for the export to excel option
				$this->session->set_userdata('centre_id' , $this->input->post('centre_id'));
				$this->session->set_userdata('student_group' , $this->input->post('student_group'));
				$this->session->set_userdata('start_date' , $this->input->post('start_date'));
				$this->session->set_userdata('end_date' , $this->input->post('end_date'));
				$this->session->set_userdata('whereCondition' , $whereCondition);

				$data['details'] = $this->master_activity_model->getActivityReport($whereCondition);
				echo json_encode($data);
			}
		}

		//This function is used to export the activity details in excel
		public function export_to_excel()
		{
			$centreDetails = $this->admin_model->commonGetdata('nome_centri' , 'id = '.$this->session->userdata('centre_id') , TABLE_CENTRE , 1);
			$data = $this->master_activity_model->getExportActivity();
			$this->load->library('export');
			$this->export->to_excel($data , str_replace(' ' , '_' , strtolower($centreDetails['nome_centri'])));
		}

		/**
		*This function is used to perform the add/edit operation for master activity module
		*
		*@param Integer $id : master activity id
		*@return NONE
		*/
		public function add_edit($id = NULL)
		{
			$post = array();
			$groupDropdown = array('' => 'Please select group');
			if($this->input->post('flag'))
			{
				if($this->input->post('flag') == 'as')
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'master activity' , $this->lang->line('add_success_message')));
				else
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'master activity' , $this->lang->line('edit_success_message')));
				redirect('/frontweb/master/index/manage_fixed_activity');
			}

			if($id != '')
			{
				$post = $this->admin_model->commonGetData("centre_id , activity_name , date_format(arrival_date , '%d-%m-%Y') as arrival_date ,
								date_format(departure_date , '%d-%m-%Y') as departure_date , student_group" , 'master_activity_id = '.$id , TABLE_MASTER_ACTIVITY , 1);

				//Prepare group dropdown
				$result = $this->admin_model->commonGetData("group_name , student_group_id" , 'centre_id = '.$post['centre_id'] , TABLE_STUDENT_GROUP , 2);
				if(!empty($result))
				{
					foreach($result as $value)
						$groupDropdown[$value['student_group_id']] = $value['group_name'];
				}

				$result = $this->admin_model->commonGetData("fixed_day_activity_id as id , date_format(date , '%d-%m-%Y') as date" , 'master_activity_id = '.$id , TABLE_FIXED_DAY_ACTIVITY , 2 , 'cast(date as DATE)' , 'asc');
				if(!empty($result))
				{
					foreach($result as $value)
						$post['datesArr'][$value['id']] = $value['date'];
					$post['details'] = $this->master_activity_model->getActivityDetails(array_keys($post['datesArr']));
				}
			}
			$data['post'] = $post;
			$data['id'] = $id;
			$data['groupDropdown'] = $groupDropdown;
			$data['flag'] = ($id != '') ? 'es' : 'as';
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = ($id != '') ? 'Edit master activity' : 'Add master activity';
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/manage_master_activity' , $data);
		}

		/**
		*This function is used to get the student group names acording to the centre through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function get_student_group()
		{
			$data = array();
			if($this->input->post('centre_id'))
				$data = $this->admin_model->commonGetData("group_name as name , student_group_id as id" , 'centre_id = '.$this->input->post('centre_id') , TABLE_STUDENT_GROUP , 2);
			echo json_encode($data);
		}

		/**
		*This function is used to check is there any duplicate master activity is present for the selected date and
		* centre or not through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function check_duplicate()
		{
			if($this->input->post('flag') == 'as')
			{
				$whereCondition = "centre_id = ".$this->input->post('centre_id')." AND
									student_group = '".$this->input->post('student_group')."' AND
									(
										(
											'".date('Y-m-d' , strtotime($this->input->post('arrival_date')))."' >= cast(arrival_date AS DATE)
											AND
											'".date('Y-m-d' , strtotime($this->input->post('arrival_date')))."' <= cast(departure_date AS DATE)
										)
										OR
										(
											'".date('Y-m-d' , strtotime($this->input->post('departure_date')))."' >= cast(arrival_date AS DATE)
											AND
											'".date('Y-m-d' , strtotime($this->input->post('departure_date')))."' <= cast(departure_date AS DATE)
										)
									)";
			}
			$result = $this->admin_model->commonGetData('count(*) as total' , $whereCondition , TABLE_MASTER_ACTIVITY , 1);
			echo ($result['total'] == 0) ? 'true' : 'false';
		}

		/**
		*This function is used to add master activity details in the database(maser and fixed activity table)
		*
		*@param NONE
		*@return NONE
		*/
		public function add_master_activity()
		{
			if($this->input->post('flag'))
			{
				$insertData = array(
					'centre_id' => $this->input->post('centre_id'),
					'activity_name' => $this->input->post('activity_name'),
					'arrival_date' => date('Y-m-d' , strtotime($this->input->post('arrival_date'))),
					'departure_date' => date('Y-m-d' , strtotime($this->input->post('departure_date'))),
					'student_group' => $this->input->post('student_group')
				);
				$masterActivityId = $this->admin_model->commonAdd(TABLE_MASTER_ACTIVITY , $insertData);
				$arrivalDate = $this->input->post('arrival_date');
				$departureDate = $this->input->post('departure_date');
				while(strtotime($arrivalDate) <= strtotime($departureDate))
				{
					$insertData = array(
						'master_activity_id' => $masterActivityId,
						'date' => date('Y-m-d' , strtotime($arrivalDate))
					);
					$this->admin_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY , $insertData);
					$arrivalDate = date('d-m-Y' , strtotime(date('Y-m-d' , strtotime($arrivalDate)).' +1 day'));
				}

				//Get the dates information from fixed activity to show in the table
				$data['datesArr'] = $this->admin_model->commonGetData("fixed_day_activity_id as id , date_format(date , '%d-%m-%Y') as date" , 'master_activity_id = '.$masterActivityId , TABLE_FIXED_DAY_ACTIVITY , 2 , 'cast(date as DATE)' , 'asc');
				echo json_encode($data);
			}
		}

		/**
		*This function is used to perform add or edit operations for the activity details through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function activity_details_add_edit()
		{
			if($this->input->post('activityDetailsFlag'))
			{
				$insertData = array(
					'program_name' => $this->input->post('program_name'),
					'location' => $this->input->post('location'),
					'activity' => $this->input->post('activity'),
					'from_time' => $this->input->post('from_time'),
					'to_time' => $this->input->post('to_time'),
					'managed_by' => $this->input->post('managed_by'),
					'fixed_day_activity_id' => $this->input->post('activityDetailsParentId')
				);
				if($this->input->post('activityDetailsFlag') == 'as')
					$activityDetailsId = $this->admin_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY_DETAILS , $insertData);
				else
					$this->admin_model->commonUpdate(TABLE_FIXED_DAY_ACTIVITY_DETAILS , "fixed_day_activity_id = ".$this->input->post('activityDetailsParentId')." AND fixed_day_activity_details_id = ".$this->input->post('activityDetailsId') , $insertData);
				echo ($this->input->post('activityDetailsFlag') == 'as') ? $activityDetailsId : $this->input->post('activityDetailsId');
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
				$this->admin_model->commonDelete(TABLE_FIXED_DAY_ACTIVITY_DETAILS , 'fixed_day_activity_details_id = '.$this->input->post('id'));
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
				$this->master_activity_model->updateActivityTiming();
				echo '';
			}
		}

		/**
		*This function is used to get the student gropup dropdown according to the centre(in acivity report module)
		*
		*@param NONE
		*@return NONE
		*/
		public function get_group_dropdown()
		{
			$data = array();
			if($this->input->post('centre_id'))
				$data = $this->admin_model->commonGetData("group_name , student_group_id" , 'centre_id = '.$this->input->post('centre_id') , TABLE_STUDENT_GROUP , 2);
			echo json_encode($data);
		}

		/**
		*This function is used to get the activity details through ajax to show in the activity modal popup form
		*
		*@param NONE
		*@return NONE
		*/
		public function get_activity_details()
		{
			$data = array();
			if($this->input->post('id'))
				$data = $this->admin_model->commonGetData("*" , 'fixed_day_activity_details_id = '.$this->input->post('id') , TABLE_FIXED_DAY_ACTIVITY_DETAILS , 1);
			echo json_encode($data);
		}

		/**
		*This function is used to copy one master activity details and add new activity(for drag/drop)
		*
		*@param NONE
		*@return NONE
		*/
		public function copy_activity_details()
		{
			$data = array();
			if($this->input->post('id'))
			{
				$result = $this->admin_model->commonGetData("program_name , location , activity , managed_by" , 'fixed_day_activity_details_id = '.$this->input->post('id') , TABLE_FIXED_DAY_ACTIVITY_DETAILS , 1);
				$insertData = array(
					'program_name' => $result['program_name'],
					'location' => $result['location'],
					'activity' => $result['activity'],
					'from_time' => $this->input->post('from_time'),
					'to_time' => $this->input->post('to_time'),
					'managed_by' => $result['managed_by'],
					'fixed_day_activity_id' => $this->input->post('fixed_day_activity_id')
				);
				$data['id'] = $this->admin_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY_DETAILS , $insertData);
				$data['name'] = $result['activity'];
			}
			echo json_encode($data);
		}

		/**
		*This function is used to get the student group dropdown details to show in the cop activity modal popup form
		*
		*@param NONE
		*@return NONE
		*/
		public function get_copy_student_group()
		{
			$data = array();
			if($this->input->post('id'))
				$data = $this->master_activity_model->getCopyStudentGroup();
			echo json_encode($data);
		}

		/**
		*This function is used to copy the whole master activity with the activity details and dates(for another student group)
		*
		*@param NONE
		*@return NONE
		*/
		public function copy()
		{
			if($this->input->post('id'))
			{
				$masterResult = $this->admin_model->commonGetData('centre_id , activity_name , arrival_date , departure_date' , 'master_activity_id = '.$this->input->post('id') , TABLE_MASTER_ACTIVITY , 1);
				$masterResult['student_group'] = $this->input->post('student_group');
				$maserId = $this->admin_model->commonAdd(TABLE_MASTER_ACTIVITY , $masterResult);

				$fixedResult = $this->admin_model->commonGetData('fixed_day_activity_id , date' , 'master_activity_id = '.$this->input->post('id') , TABLE_FIXED_DAY_ACTIVITY , 2);
				foreach($fixedResult as $fixedValue)
				{
					$insertData = array(
						'master_activity_id' => $maserId,
						'date' => $fixedValue['date']
					);
					$fixedId = $this->admin_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY , $insertData);
					$activityDetails = $this->admin_model->commonGetData('program_name , location , activity , from_time , to_time , managed_by' , 'fixed_day_activity_id = '.$fixedValue['fixed_day_activity_id'] , TABLE_FIXED_DAY_ACTIVITY_DETAILS , 2);
					if(!empty($activityDetails))
					{
						foreach($activityDetails as $value)
						{
							$value['fixed_day_activity_id'] = $fixedId;
							$this->admin_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY_DETAILS , $value);
						}
					}
				}
			}
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'master activity' , $this->lang->line('add_success_message')));
			redirect('/frontweb/master/index/manage_fixed_activity');
		}
	}
?>