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
			$this->load->model('frontweb/master_activity_model' , '' , TRUE);
			$this->load->model('frontweb/extra_activity_model' , '' , TRUE);
		}

		//This function is used to show the extra activity management page
		function index()
		{
			$post = array();
			if($this->input->post('centre_id'))
			{
				$post['centre_id'] = $this->input->post('centre_id');
				$post['date'] = $this->input->post('date');
				$post['masterActivity'] = $this->extra_activity_model->getMasterActivity();
				$centreResult = $this->admin_model->commonGetData('nome_centri' , "id = '".$this->input->post('centre_id')."'" , TABLE_CENTRE , 1);
				$post['centreDetails'] = $centreResult['nome_centri'];
				$post['groupReference'] = $this->extra_activity_model->getGroupReference();
			}
			$data['post'] = $post;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Extra activity';
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/extra_activity' , $data);
		}

		//This function is used to update the data in the database for extra activity
		function update()
		{
			$this->extra_activity_model->updateActivity();
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'Extra activity' , $this->lang->line('edit_success_message')));
			redirect('/frontweb/extra_activity');
		}

		/**
		*This function is used to get the extra activity details according to the centre , date and
		*group reference number through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function get_activity_details()
		{
			if($this->input->post('centre_id'))
			{
				$data['htmlStr'] = $this->extra_activity_model->createActivityDetails();
				echo json_encode($data);
			}
		}

		/**
		*This function is used to get the master activity details according to the details id
		*through ajax call
		*
		*@param NONE
		*@return NONE
		*/
		public function get_master_activity()
		{
			if($this->input->post('id'))
			{
				$result = $this->admin_model->commonGetData('*' , 'fixed_day_activity_details_id = '.$this->input->post('id') , TABLE_FIXED_DAY_ACTIVITY_DETAILS , 1);
				$data['htmlStr'] = $this->extra_activity_model->createHtml($result , 2);
				echo json_encode($data);
			}
		}
	}
