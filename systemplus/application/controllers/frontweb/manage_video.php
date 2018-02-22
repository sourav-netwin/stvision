<?php
	class Manage_video extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			authSessionMenu($this);
			$this->lang->load('message' , 'english');
			$this->load->helper('frontweb/backend');
			$this->load->model('frontweb/admin_model' , '' , TRUE);
		}

		//This function is used to show the listing page for the video gallery authontication details
		function index()
		{
			$data['credentialDetails'] = $this->admin_model->getVideoCredentialDetails();
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage video';
			$data['title'] = 'plus-ed.com | Manage video';
			$this->ltelayout->view('frontweb/manage_video' , $data);
		}

		//This function is used to generate the password against every centre through ajax request
		function generate_password()
		{
			//Delete old data
			$this->admin_model->commonDelete(TABLE_PLUS_VIDEO , "plus_video_id != ''");

			//Get centre details
			$centreArr = $this->admin_model->commonGetData('id' , '((attivo = 1) or (attivo = 0 and is_mini_stay = 1))' , TABLE_CENTRE , 2);

			if(!empty($centreArr))
			{
				foreach($centreArr as $value)
				{
					$insertData = array(
						'centre' => $value['id'],
						'password' => $this->generateRandomString(),
						'manager_password' => $this->generateRandomString()
					);
					$this->admin_model->commonAdd(TABLE_PLUS_VIDEO , $insertData);
				}
			}
			echo '';
		}

		//This function is used to get the random string
		public function generateRandomString($length = 10)
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for($i = 0 ; $i < $length ; $i++)
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			return $randomString;
		}

		//This function is used to edit the password and update in database
		function edit()
		{
			if($this->input->post('plus_video_id'))
			{
				$data = array(
					'password' => $this->input->post('password'),
					'manager_password' => $this->input->post('manager_password')
				);
				$this->admin_model->commonUpdate(TABLE_PLUS_VIDEO , 'plus_video_id = '.$this->input->post('plus_video_id') , $data);
			}
			echo TRUE;
		}
	}
