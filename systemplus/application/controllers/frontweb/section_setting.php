<?php
	class Section_setting extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			authSessionMenu($this);
			$this->lang->load('message' , 'english');
			$this->load->helper('frontweb/backend');
			$this->load->model('frontweb/admin_model' , '' , TRUE);
			$this->load->library('frontweb/image_upload');
		}

		//This function is used to show listing page for section setting
		public function index()
		{
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Section setting';
			$data['title'] = 'plus-ed.com | Section setting';
			$this->ltelayout->view('frontweb/section_setting_list' , $data);
		}

		//This function is used to get all section setting details from DB and display in datatable
		public function get_section()
		{
			if($this->input->post('draw'))
			{
				$searchArr = $this->input->post('search');
				$responseArr = array();
				$programData = $this->admin_model->getSectionSettingDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $this->input->post('type'));

				$responseArr['draw'] = $this->input->post('draw');
				$responseArr['recordsTotal'] = $programData['count_all'];
				$responseArr['recordsFiltered'] = $programData['count_filtered'];
				$responseArr['data'] = $programData['data'];
				echo json_encode($responseArr);
			}
		}

		//This function is used to update record in the database
		function edit()
		{
			if($this->input->post('section_id'))
			{
				$data = array(
					'name' => $this->input->post('name')
				);
				$this->admin_model->commonUpdate(TABLE_PLUS_SECTION_SETTING , 'id = '.$this->input->post('section_id') , $data);
			}
			echo TRUE;
		}

		//This function is used to switch the sequence of the sections through ajax call
		function switch_sequence()
		{
			if($this->input->post('currentId') != '')
			{
				$this->admin_model->commonUpdate(TABLE_PLUS_SECTION_SETTING , 'id = '.$this->input->post('currentId') , array('sequence' => $this->input->post('switchSequence')));
				$this->admin_model->commonUpdate(TABLE_PLUS_SECTION_SETTING , 'id = '.$this->input->post('switchId') , array('sequence' => $this->input->post('currentSequence')));
			}
			echo TRUE;
		}

		//This function is used to add new section . Also update in the sequence setting table
		function add()
		{
			if($this->input->post('course_id'))
			{
				$insertData = array(
					'course_id' => $this->input->post('course_id'),
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug')
				);
				$this->admin_model->commonAdd(TABLE_PLUS_EXTRA_SECTION , $insertData);

				//Insert record in sequence setting table as well
				$this->admin_model->insertSlug($this->input->post('name') , $this->input->post('slug') , $this->input->post('course_id'));
			}
			echo TRUE;
		}

		//This function is used to check for the duplicate slug
		function check_duplicate()
		{
			if($this->input->post('slug') != '')
			{
				$result = $this->admin_model->commonGetData('id' , "slug = '".$this->input->post('slug')."'" , TABLE_PLUS_SECTION_SETTING , 1);
				echo (!empty($result)) ? "false" : "true";
			}
		}
	}
