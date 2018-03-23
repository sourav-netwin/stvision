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

		//This function is used to perform the add/edit operation for master activity module
		public function add_edit_old($id = NULL)
		{
			$post = array();
			if($this->input->post('flag'))
			{
				//Insert or update data
				$insertData = array(
					'centre_id' => $this->input->post('centre_id'),
					'date' => date('Y-m-d' , strtotime($this->input->post('date')))
				);
				if($this->input->post('flag') == 'as')
				{
					$insertId = $this->admin_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY , $insertData);
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'master activity' , $this->lang->line('add_success_message')));
				}
				else
				{
					$this->admin_model->commonUpdate(TABLE_FIXED_DAY_ACTIVITY , 'fixed_day_activity_id = '.$id , $insertData);
					//Delete the old record from the subtable
					$this->admin_model->commonDelete(TABLE_FIXED_DAY_ACTIVITY_DETAILS , 'fixed_day_activity_id = '.$id);
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'master activity' , $this->lang->line('edit_success_message')));
				}

				//Prepare data for subtables(activity details)
				$programNameArr = $this->input->post('program_name');
				$locationArr = $this->input->post('location');
				$activityArr = $this->input->post('activity');
				$fromTimeArr = $this->input->post('from_time');
				$toTimeArr = $this->input->post('to_time');
				$managedByArr = $this->input->post('managed_by');
				if(!empty($programNameArr))
				{
					foreach($programNameArr as $key => $value)
					{
						$insertData = array(
							'program_name' => $value,
							'location' => $locationArr[$key],
							'activity' => $activityArr[$key],
							'from_time' => $fromTimeArr[$key],
							'to_time' => $toTimeArr[$key],
							'managed_by' => $managedByArr[$key],
							'fixed_day_activity_id' => ($this->input->post('flag') == 'as') ? $insertId : $id
						);
						$this->admin_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY_DETAILS , $insertData);
					}
				}
				redirect('/frontweb/master/index/manage_fixed_activity');
			}

			//Get data to show in the edit page
			if($id != '')
				$post = $this->master_activity_model->getData($id);

			$data['post'] = $post;
			$data['id'] = $id;
			$data['flag'] = ($id != '') ? 'es' : 'as';
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = ($id != '') ? 'Edit master activity' : 'Add master activity';
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/master_activity' , $data);
		}

		//This function is used to check if any duplicate data is present for the centre and date
		public function duplicate()
		{
			if($this->input->post('flag'))
			{
				$whereCondition = "centre_id = '".$this->input->post('centre_id')."' AND date = '".date('Y-m-d' , strtotime($this->input->post('date')))."'";
				if($this->input->post('flag') == 'es')
					$whereCondition.= " AND fixed_day_activity_id != '".$this->input->post('id')."'";
				$result = $this->admin_model->commonGetData('COUNT(*) as total' , $whereCondition , TABLE_FIXED_DAY_ACTIVITY , 1);
				echo json_encode($result);
			}
		}

		//This function is used to search the activities for the selected date and show in the preview section
		public function search_activity()
		{
			$data = array();
			if($this->input->post('centre_id'))
				$data['htmlStr'] = $this->master_activity_model->previewActivity();
			echo json_encode($data);
		}

		//This function is used to get the activity details and show in the report
		public function report()
		{
			$post = array();
			if($this->input->post('flag') == 'search')
			{
				$post['centre_id'] = $this->input->post('centre_id');
				$post['start_date'] = $this->input->post('start_date');
				$post['end_date'] = $this->input->post('end_date');

				//Save the post value for in session for the export to excel option
				$this->session->set_userdata('centre_id' , $this->input->post('centre_id'));
				$this->session->set_userdata('start_date' , $this->input->post('start_date'));
				$this->session->set_userdata('end_date' , $this->input->post('end_date'));
				$this->session->set_userdata('whereCondition' , '');

				$post['details'] = $this->master_activity_model->getActivityReport();
				$post['dropdownArr'] = $this->master_activity_model->getActivityFilterDropdown();
			}
			$data['post'] = $post;
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
		*This function is used to check the duplicate dates for the copy activity module through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function copy_duplicate()
		{
			if($this->input->post('id') != '')
			{
				$dateArr = array_map(function($v){return date('Y-m-d' , strtotime($v));} , $this->input->post('datesArr'));
				$countArr = $this->master_activity_model->getDuplicateActivity($dateArr , $this->input->post('id'));
				echo ($countArr['total'] == 0) ? 'true' : 'false';
			}
		}

		/**
		*This function is used to copy one master activity for several dates
		*
		*@param NONE
		*@return NONE
		*/
		public function copy()
		{
			if($this->input->post('id') != '')
			{
				$dateArr = array_map(function($v){return date('Y-m-d' , strtotime($v));} , $this->input->post('date'));
				$masterActivity = $this->admin_model->commonGetData('centre_id' , 'fixed_day_activity_id = '.$this->input->post('id') , TABLE_FIXED_DAY_ACTIVITY , 1);
				$masterActivityDetails = $this->admin_model->commonGetData('program_name , location , activity , from_time , to_time , managed_by' , 'fixed_day_activity_id = '.$this->input->post('id') , TABLE_FIXED_DAY_ACTIVITY_DETAILS , 2);
				if(!empty($dateArr))
				{
					foreach($dateArr as $date)
					{
						$insertData = array(
							'centre_id' => $masterActivity['centre_id'],
							'date' => $date
						);
						$insertId = $this->admin_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY , $insertData);
						if(!empty($masterActivityDetails))
						{
							foreach($masterActivityDetails as $detailsArr)
							{
								$detailsArr['fixed_day_activity_id'] = $insertId;
								$this->admin_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY_DETAILS , $detailsArr);
							}
						}
					}
				}
			}
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'master activity' , $this->lang->line('add_success_message')));
			redirect('/frontweb/master/index/manage_fixed_activity');
		}
















/*************************************START****************************************/





		/**
		*This function is used to perform the add/edit operation for master activity module
		*
		*@param Integer $id : master activity id
		*@return NONE
		*/
		public function add_edit($id = NULL)
		{
			$post = array();
			$groupArr = array('' => 'Please select group');
			if($this->input->post('flag'))
			{
				$studentGroup = $this->admin_model->commonGetData('student_group_id' , 'centre_id = '.$this->input->post('centre_id') , TABLE_STUDENT_GROUP , 2);
				$studentGroup = (empty($studentGroup)) ? array(array('student_group_id' => '')) : $studentGroup;
				foreach($studentGroup as $groupValue)
				{
					$insertData = array(
						'centre_id' => $this->input->post('centre_id'),
						'activity_name' => $this->input->post('activity_name'),
						'arrival_date' => date('Y-m-d' , strtotime($this->input->post('arrival_date'))),
						'departure_date' => date('Y-m-d' , strtotime($this->input->post('departure_date'))),
						'student_group' => $groupValue['student_group_id'],
					);
					$masterActivityId = $this->admin_model->commonAdd(TABLE_MASTER_ACTIVITY , $insertData);

					//Prepare data for subtables(activity details)
					$programNameArr = $this->input->post('program_name');
					$locationArr = $this->input->post('location');
					$activityArr = $this->input->post('activity');
					$fromTimeArr = $this->input->post('from_time');
					$toTimeArr = $this->input->post('to_time');
					$managedByArr = $this->input->post('managed_by');
					if(!empty($programNameArr))
					{
						foreach($programNameArr as $dateValue => $detailsValue)
						{
							$insertData = array(
								'master_activity_id' => $masterActivityId,
								'date' => date('Y-m-d' , strtotime($dateValue))
							);
							$fixedDayActivityId = $this->admin_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY , $insertData);
							foreach($detailsValue as $key => $value)
							{
								$insertData = array(
									'program_name' => $value,
									'location' => $locationArr[$dateValue][$key],
									'activity' => $activityArr[$dateValue][$key],
									'from_time' => $fromTimeArr[$dateValue][$key],
									'to_time' => $toTimeArr[$dateValue][$key],
									'managed_by' => $managedByArr[$dateValue][$key],
									'fixed_day_activity_id' => $fixedDayActivityId
								);
								$this->admin_model->commonAdd(TABLE_FIXED_DAY_ACTIVITY_DETAILS , $insertData);
							}
						}
					}
				}
				$this->session->set_flashdata('success_message', str_replace('**module**' , 'master activity' , $this->lang->line('add_success_message')));
				redirect('/frontweb/master/index/manage_fixed_activity');
			}

			$data['post'] = $post;
			$data['groupArr'] = $groupArr;
			$data['id'] = $id;
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
			$groupNames = '';
			if($this->input->post('centre_id'))
			{
				$result = $this->admin_model->commonGetData("group_concat(group_name) as name" , 'centre_id = '.$this->input->post('centre_id') , TABLE_STUDENT_GROUP , 1);
				$groupNames = str_replace(',' , ' , ' , $result['name']);
			}
			echo $groupNames;
		}





/*************************************END****************************************/

















	}
?>