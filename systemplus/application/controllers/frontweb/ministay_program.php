<?php
	class Ministay_program extends Controller
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

		//This function is used to show the listing page for program course
		public function index()
		{
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage ministay program';
			$data['title'] = 'plus-ed.com | Manage ministay program';
			$this->ltelayout->view('frontweb/ministay_program_list' , $data);
		}

		//This function is used to get all program course details from DB and display in datatable
		public function get_program()
		{
			if($this->input->post('draw'))
			{
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');
				//For now , only english
				$languageId = 1;
				$responseArr = array();
				$programData = $this->admin_model->getMinistayProgramDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir'] , $languageId);

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
					'status' => ($this->input->post('program_status') == 1) ? 0 : 1
				);
				$this->admin_model->commonUpdate(TABLE_JUNIOR_MINISTAY_STATIC_PROGRAM , 'junior_ministay_static_program_id = '.$this->input->post('program_id') , $data);
				echo TRUE;
			}
		}

		//This function is used to perform both add and edit operation for program course module
		function add_edit($id = NULL)
		{
			$imageError = '';
			if($this->input->post('flag'))
			{
				$file_name = $this->input->post('oldImg');
				//For the program logo
				if($this->input->post('imageChangeFlag') == 2)
				{
					$uploadData = $this->image_upload->do_upload('./'.MINISTAY_PROGRAM_IMAGE_PATH , 'logo' , UPLOAD_IMAGE_SIZE , MINISTAY_PROGRAM_WIDTH , MINISTAY_PROGRAM_HEIGHT);
					if($uploadData['errorFlag'] == 0)
					{
						//Delete old file
						if($this->input->post('flag') == 'es' && $file_name != '')
						{
							if(file_exists('./'.MINISTAY_PROGRAM_IMAGE_PATH.$file_name))
								unlink('./'.MINISTAY_PROGRAM_IMAGE_PATH.$file_name);
							if(file_exists('./'.MINISTAY_PROGRAM_IMAGE_PATH.getThumbnailName($file_name)))
								unlink('./'.MINISTAY_PROGRAM_IMAGE_PATH.getThumbnailName($file_name));
						}
						$file_name = $uploadData['fileName'];
					}
					else
						$imageError = $uploadData['errorMessage'];
				}
				//Add/update record in database
				if($imageError == '')
				{
					$updateData = array(
						'program_name' => $this->input->post('program_name'),
						'description' => $this->input->post('description'),
						'logo' => $file_name
					);
					if($this->input->post('flag') == 'as')
					{
						$insertId = $this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_STATIC_PROGRAM , $updateData);
						$this->session->set_flashdata('success_message', str_replace('**module**' , 'Ministay program' , $this->lang->line('add_success_message')));
					}
					elseif($this->input->post('flag') == 'es')
					{
						$this->admin_model->commonUpdate(TABLE_JUNIOR_MINISTAY_STATIC_PROGRAM , 'junior_ministay_static_program_id = '.$id , $updateData);
						$this->session->set_flashdata('success_message', str_replace('**module**' , 'Ministay program' , $this->lang->line('edit_success_message')));
					}

					//Save the course program details in subtable
					$courseProgram = $this->input->post('course_program');
					if($this->input->post('flag') == 'es')
						$this->admin_model->commonDelete(TABLE_MINISTAY_COURSE_PROGRAM , 'ministay_program_id = '.$id);
					if(!empty($courseProgram))
					{
						foreach($courseProgram as $programId)
						{
							$insertData = array(
								'course_program_id' => $programId,
								'ministay_program_id' => ($this->input->post('flag') == 'as') ? $insertId : $id
							);
							$this->admin_model->commonAdd(TABLE_MINISTAY_COURSE_PROGRAM , $insertData);
						}
					}

					//For image cropping
					if($this->input->post('imageChangeFlag') == 2)
						$this->_handleCropping($file_name);
					redirect('/frontweb/ministay_program');
				}
			}
			if($id != '')
			{
				$post = $this->admin_model->commonGetData('junior_ministay_static_program_id , program_name , description , logo' , 'junior_ministay_static_program_id = '.$id , TABLE_JUNIOR_MINISTAY_STATIC_PROGRAM , 1);

				//Get the course program details to show in the edit page
				$result = $this->admin_model->commonGetdata('course_program_id' , 'ministay_program_id = '.$id , TABLE_MINISTAY_COURSE_PROGRAM , 2);
				if(!empty($result))
				{
					foreach($result as $value)
						$post['course_program'][] = $value['course_program_id'];
				}

				$data['post'] = $post;
			}
			$data['id'] = $id;
			$data['flag'] = ($id != '') ? 'es' : 'as';
			$data['imageError'] = $imageError;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = ($id != '') ? 'Edit ministay program' : 'Add ministay program';
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/ministay_program_add_edit' , $data);
		}

		//Function is used to delete record from DB
		function delete($id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);
			$this->admin_model->commonUpdate(TABLE_JUNIOR_MINISTAY_STATIC_PROGRAM , 'junior_ministay_static_program_id = '.$id , $updateData);
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'Ministay Program' , $this->lang->line('delete_success_message')));
			redirect('/frontweb/ministay_program');
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
					'imageAbsPath' => FCPATH . MINISTAY_PROGRAM_IMAGE_PATH,
					'imageDestPath' => FCPATH . MINISTAY_PROGRAM_IMAGE_PATH,
					'imageName' => $file_name,
					'imageNewName' => $file_name,
					'imagePath' => base_url() . MINISTAY_PROGRAM_IMAGE_PATH,
					'imageWidth' => MINISTAY_PROGRAM_WIDTH,
					'imageHeight' => MINISTAY_PROGRAM_HEIGHT,
					'thumbWidth' => MINISTAY_PROGRAM_THUMB_WIDTH,
					'thumbHeight' => MINISTAY_PROGRAM_THUMB_HEIGHT,
					'redirectTo' => 'frontweb/ministay_program',
					'formCallbackAction' => 'frontweb/ministay_program/process'
				);
				$this->session->set_userdata("cropData" , $param);
			}
			$this->load->library("cropping" , $param);
		}
		/******************Image Cropping functionality End*********************/
	}
?>