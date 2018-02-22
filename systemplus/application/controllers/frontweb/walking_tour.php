<?php
	class Walking_tour extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			authSessionMenu($this);
			$this->lang->load('message' , 'english');
			$this->load->helper('frontweb/backend');
			$this->load->model('frontweb/admin_model' , '' , TRUE);
		}

		//This function is used to show the listing page for plus walking tour
		public function index()
		{
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage walking tour';
			$data['title'] = 'plus-ed.com | Manage walking tour';
			$this->ltelayout->view('frontweb/walking_tour_list' , $data);
		}

		//This function is used to get the details from database and show in the data table
		function get_walking_tour()
		{
			if($this->input->post('draw'))
			{
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');
				//For now , only english
				$languageId = 1;
				$responseArr = array();
				$programData = $this->admin_model->getWalkingTourDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir'] , $languageId);

				$responseArr['draw'] = $this->input->post('draw');
				$responseArr['recordsTotal'] = $programData['count_all'];
				$responseArr['recordsFiltered'] = $programData['count_all'];
				$responseArr['data'] = $programData['data'];
				echo json_encode($responseArr);
			}
		}

		//This function is used to update the video description in database through ajax call
		function update()
		{
			if($this->input->post('plus_walking_tour_id'))
			{
				$data = array(
					'description' => $this->input->post('description')
				);
				$this->admin_model->commonUpdate(TABLE_PLUS_WALKING_TOUR , 'plus_walking_tour_id = '.$this->input->post('plus_walking_tour_id') , $data);
				echo json_encode(array());
			}
		}
	}
