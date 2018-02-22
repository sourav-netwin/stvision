<?php
	class Program extends Controller
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

		//This function is used to show listing page for all programs
		public function index()
		{
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage program banner';
			$data['title'] = 'plus-ed.com | Manage program banner';
			$this->ltelayout->view('frontweb/program_list' , $data);
		}

		//This function is used to get all program details from DB and display in datatable
		public function get_program()
		{
			if($this->input->post('draw'))
			{
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');
				//For now , only english
				$languageId = 1;
				$responseArr = array();
				$programData = $this->admin_model->getProgramDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir'] , $languageId);

				$responseArr['draw'] = $this->input->post('draw');
				$responseArr['recordsTotal'] = $programData['count_all'];
				$responseArr['recordsFiltered'] = $programData['count_filtered'];
				$responseArr['data'] = $programData['data'];
				echo json_encode($responseArr);
			}
		}

		//Function is used to update program status through ajax call
		public function update_status()
		{
			if($this->input->post('program_id'))
			{
				$data = array(
					'program_status' => ($this->input->post('program_status') == 1) ? 0 : 1
				);
				$this->admin_model->commonUpdate(TABLE_PROGRAM , 'program_id = '.$this->input->post('program_id') , $data);
				echo TRUE;
			}
		}

		//This function is used to perform add/edit functionality for program banner module
		function add_edit($id = NULL)
		{
			$imageError = '';
			if($this->input->post('flag'))
			{
				$file_name = $this->input->post('oldImg');
				if($this->input->post('imageChangeFlag') == 2)
				{
					$uploadData = $this->image_upload->do_upload('./'.PROGRAM_IMAGE_PATH , 'program_image' , UPLOAD_IMAGE_SIZE , PROGRAM_WIDTH , PROGRAM_HEIGHT);
					if($uploadData['errorFlag'] == 0)
					{
						if($this->input->post('flag') == 'es')
						{
							//Delete old file
							if(file_exists('./'.PROGRAM_IMAGE_PATH.$file_name))
								unlink('./'.PROGRAM_IMAGE_PATH.$file_name);
							if(file_exists('./'.PROGRAM_IMAGE_PATH.getThumbnailName($file_name)))
								unlink('./'.PROGRAM_IMAGE_PATH.getThumbnailName($file_name));
						}
						$file_name = $uploadData['fileName'];
					}
					else
						$imageError = $uploadData['errorMessage'];
				}
				if($imageError == '')
				{
					$updateData = array(
						'program_image' => $file_name
					);
					$subTabledata = array(
						'language_id' => $this->input->post('language_id'),
						'program_title' => $this->input->post('program_title'),
						'program_short_description' => $this->input->post('program_short_description'),
						'program_description' => $this->input->post('program_description'),
						'more_link' => $this->input->post('more_link')
					);
					if($this->input->post('flag') == 'as')
					{
						$insertId = $this->admin_model->commonAdd(TABLE_PROGRAM , $updateData);
						$subTabledata['program_id'] = $insertId;
						$this->admin_model->commonAdd(TABLE_PROGRAM_LANGUAGE , $subTabledata);
						$this->session->set_flashdata('success_message', str_replace('**module**' , 'Program banner' , $this->lang->line('add_success_message')));
					}
					elseif($this->input->post('flag') == 'es')
					{
						$this->admin_model->commonUpdate(TABLE_PROGRAM , 'program_id = '.$id , $updateData);
						$this->admin_model->commonUpdate(TABLE_PROGRAM_LANGUAGE , 'program_id = '.$id.' AND language_id = '.$this->input->post('language_id') , $subTabledata);
						$this->session->set_flashdata('success_message', str_replace('**module**' , 'Program banner' , $this->lang->line('edit_success_message')));
					}

					if($this->input->post('imageChangeFlag') == 2)
						$this->_handleCropping($file_name);
					redirect('/frontweb/program');
				}
			}

			if($id != '')
			{
				$post = $this->admin_model->getEditProgramData($id , 1);
				$data['post'] = $post;
			}
			$data['id'] = $id;
			$data['imageError'] = $imageError;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = ($id != '') ? 'Edit program banner' : 'Add program banner';
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/program_add_edit' , $data);
		}

		//Function is used to delete record from DB
		function delete($id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);
			$this->admin_model->commonUpdate(TABLE_PROGRAM , 'program_id = '.$id , $updateData);
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'Program banner' , $this->lang->line('delete_success_message')));
			redirect('/frontweb/program');
		}

		/****************Image Cropping functionality Start******************/
		public function _handleCropping($fileName = NULL)
		{
			$this->cropInit($fileName);
			$this->cropping->image();
			exit();
		}

		public function process($action = NULL)
		{
			$this->cropInit();
			$this->cropping->process($action);
		}

		public function cropInit($file_name = NULL)
		{
			$param = array();
			if(empty($file_name))
				$param = $this->session->userdata("cropData");
			else
			{
				$param = array(
					'imageAbsPath' => FCPATH . PROGRAM_IMAGE_PATH,
					'imageDestPath' => FCPATH . PROGRAM_IMAGE_PATH,
					'imageName' => $file_name,
					'imageNewName' => $file_name,
					'imagePath' => base_url() . PROGRAM_IMAGE_PATH,
					'imageWidth' => PROGRAM_WIDTH,
					'imageHeight' => PROGRAM_HEIGHT,
					'thumbWidth' => PROGRAM_THUMB_WIDTH,
					'thumbHeight' => PROGRAM_THUMB_HEIGHT,
					'redirectTo' => 'frontweb/program',
					'formCallbackAction' => 'frontweb/program/process'
				);
				$this->session->set_userdata("cropData" , $param);
			}
			$this->load->library("cropping" , $param);
		}
		/******************Image Cropping functionality End*********************/
	}
?>