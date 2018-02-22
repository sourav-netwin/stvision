<?php
	class Program_course extends Controller
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
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage course program';
			$data['title'] = 'plus-ed.com | Manage course program';
			$this->ltelayout->view('frontweb/program_course_list' , $data);
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
				$programData = $this->admin_model->getProgramCourseDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir'] , $languageId);

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
					'program_course_status' => ($this->input->post('program_status') == 1) ? 0 : 1
				);
				$this->admin_model->commonUpdate(TABLE_PROGRAM_COURSE , 'program_course_id = '.$this->input->post('program_id') , $data);
				echo TRUE;
			}
		}

		//This function is used to perform both add and edit operation for program course module
		function add_edit($id = NULL)
		{
			$imageError = $imageErrorFront = '';
			if($this->input->post('flag'))
			{
				$file_name = $this->input->post('oldImg');
				$fileNameFront = $this->input->post('oldImgFront');
				//For the program logo
				if($this->input->post('imageChangeFlag') == 2)
				{
					$uploadData = $this->image_upload->do_upload('./'.PROGRAM_COURSE_IMAGE_PATH , 'program_course_logo' , UPLOAD_IMAGE_SIZE , PROGRAM_COURSE_WIDTH , PROGRAM_COURSE_HEIGHT);
					if($uploadData['errorFlag'] == 0)
					{
						//Delete old file
						if($this->input->post('flag') == 'es' && $file_name != '')
						{
							if(file_exists('./'.PROGRAM_COURSE_IMAGE_PATH.$file_name))
								unlink('./'.PROGRAM_COURSE_IMAGE_PATH.$file_name);
							if(file_exists('./'.PROGRAM_COURSE_IMAGE_PATH.getThumbnailName($file_name)))
								unlink('./'.PROGRAM_COURSE_IMAGE_PATH.getThumbnailName($file_name));
						}
						$file_name = $uploadData['fileName'];
					}
					else
						$imageError = $uploadData['errorMessage'];
				}
				//For home page image
				if($this->input->post('imageChangeFlagFront') == 2)
				{
					$uploadData = $this->image_upload->do_upload('./'.PROGRAM_FRONT_IMAGE_PATH , 'program_front_image' , UPLOAD_IMAGE_SIZE , PROGRAM_FRONT_WIDTH , PROGRAM_FRONT_HEIGHT);
					if($uploadData['errorFlag'] == 0)
					{
						//Delete old file
						if($this->input->post('flag') == 'es' && $fileNameFront != '')
						{
							if(file_exists('./'.PROGRAM_FRONT_IMAGE_PATH.$fileNameFront))
								unlink('./'.PROGRAM_FRONT_IMAGE_PATH.$fileNameFront);
							if(file_exists('./'.PROGRAM_FRONT_IMAGE_PATH.getThumbnailName($fileNameFront)))
								unlink('./'.PROGRAM_FRONT_IMAGE_PATH.getThumbnailName($fileNameFront));
						}
						$fileNameFront = $uploadData['fileName'];
					}
					else
						$imageErrorFront = $uploadData['errorMessage'];
				}
				//Add/update record in database
				if($imageError == '' && $imageErrorFront == '')
				{
					$updateData = array(
						'program_course_name' => $this->input->post('program_course_name'),
						'program_course_description' => $this->input->post('program_course_description'),
						'program_course_logo' => $file_name,
						'program_front_image' => $fileNameFront
					);
					if($this->input->post('flag') == 'as')
					{
						//Insert slug data in the main database
						$slugName = str_replace(' ' , '-' , $this->input->post('program_course_name'));
						$updateData['sequence_slug'] = $slugName;

						$this->admin_model->commonAdd(TABLE_PROGRAM_COURSE , $updateData);
						//Insert slug name in the sequence setting table
						$this->admin_model->insertSlug($this->input->post('program_course_name') , $slugName);

						$this->session->set_flashdata('success_message', str_replace('**module**' , 'Program course' , $this->lang->line('add_success_message')));
					}
					elseif($this->input->post('flag') == 'es')
					{
						$this->admin_model->commonUpdate(TABLE_PROGRAM_COURSE , 'program_course_id = '.$id , $updateData);
						$this->session->set_flashdata('success_message', str_replace('**module**' , 'Program course' , $this->lang->line('edit_success_message')));
					}

					//For image cropping
					if($this->input->post('imageChangeFlag') == 2 && $this->input->post('imageChangeFlagFront') == 2)
						$this->_handleCropping($file_name , 'logo' , PROGRAM_COURSE_WIDTH , PROGRAM_COURSE_HEIGHT , PROGRAM_COURSE_THUMB_WIDTH , PROGRAM_COURSE_THUMB_HEIGHT , 1 , $fileNameFront);
					elseif($this->input->post('imageChangeFlag') == 2)
						$this->_handleCropping($file_name , 'logo' , PROGRAM_COURSE_WIDTH , PROGRAM_COURSE_HEIGHT , PROGRAM_COURSE_THUMB_WIDTH , PROGRAM_COURSE_THUMB_HEIGHT);
					elseif($this->input->post('imageChangeFlagFront') == 2)
						$this->_handleCropping($fileNameFront , 'front_image' , PROGRAM_FRONT_WIDTH , PROGRAM_FRONT_HEIGHT , PROGRAM_FRONT_THUMB_WIDTH , PROGRAM_FRONT_THUMB_HEIGHT);
					redirect('/frontweb/program_course');
				}
			}
			if($id != '')
			{
				$post = $this->admin_model->commonGetData('program_course_id , program_course_name , program_course_description , program_course_logo , program_front_image' , 'program_course_id = '.$id , TABLE_PROGRAM_COURSE , 1);
				$data['post'] = $post;
			}
			$data['id'] = $id;
			$data['flag'] = ($id != '') ? 'es' : 'as';
			$data['imageError'] = $imageError;
			$data['imageErrorFront'] = $imageErrorFront;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = ($id != '') ? 'Edit course program' : 'Add course program';
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/program_course_add_edit' , $data);
		}

		//Function is used to delete record from DB
		function delete($id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);
			$this->admin_model->commonUpdate(TABLE_PROGRAM_COURSE , 'program_course_id = '.$id , $updateData);
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'Program course' , $this->lang->line('delete_success_message')));
			redirect('/frontweb/program_course');
		}

		/****************Image Cropping functionality Start******************/
		public function crop_again($fileName = NULL , $flag = NULL , $width = NULL , $height = NULL , $thumbWidth = NULL , $thumbHeight = NULL)
		{
			$this->_handleCropping($fileName , $flag , $width , $height , $thumbWidth , $thumbHeight);
		}

		public function _handleCropping($fileName = NULL , $flag = NULL , $width = NULL , $height = NULL , $thumbWidth = NULL , $thumbHeight = NULL , $actionForFront = NULL , $frontFileName = NULL)
		{
			$this->cropInit($fileName , $flag , $width , $height , $thumbWidth , $thumbHeight , $actionForFront , $frontFileName);
			$this->cropping->image();
			exit();
		}

		public function process($action = NULL)
		{
			$this->cropInit();
			$this->cropping->process($action);
		}

		public function cropInit($file_name = NULL , $flag = NULL , $width = NULL , $height = NULL , $thumbWidth = NULL , $thumbHeight = NULL , $actionForFront = NULL , $frontFileName = NULL)
		{
			if($flag == 'logo')
				$path = PROGRAM_COURSE_IMAGE_PATH;
			elseif($flag == 'front_image')
				$path = PROGRAM_FRONT_IMAGE_PATH;
			$param = array();
			if(empty($file_name))
				$param = $this->session->userdata("cropData");
			else
			{
				$param = array(
					'imageAbsPath' => FCPATH . $path,
					'imageDestPath' => FCPATH . $path,
					'imageName' => $file_name,
					'imageNewName' => $file_name,
					'imagePath' => base_url() . $path,
					'imageWidth' => $width,
					'imageHeight' => $height,
					'thumbWidth' => $thumbWidth,
					'thumbHeight' => $thumbHeight,
					'redirectTo' => 'frontweb/program_course',
					'formCallbackAction' => 'frontweb/program_course/process'
				);
				if($actionForFront == 1)
					$param['redirectTo'] = 'frontweb/program_course/crop_again/'.$frontFileName.'/front_image/'.PROGRAM_FRONT_WIDTH.'/'.PROGRAM_FRONT_HEIGHT.'/'.PROGRAM_FRONT_THUMB_WIDTH.'/'.PROGRAM_FRONT_THUMB_HEIGHT;
				$this->session->set_userdata("cropData" , $param);
			}
			$this->load->library("cropping" , $param);
		}
		/******************Image Cropping functionality End*********************/
	}
?>