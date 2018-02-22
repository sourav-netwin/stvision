<?php
	class Master extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			authSessionMenu($this);
			$this->lang->load('message' , 'english');
			$this->lang->load('master' , 'english');
			$this->load->helper('language');
			$this->load->helper('frontweb/backend');
			$this->load->model('frontweb/mastermodel' , '' , TRUE);
			$this->load->model('frontweb/admin_model' , '' , TRUE);
			$this->load->library('frontweb/image_upload');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<span style="color:red">', '</span>');
		}

		//This function is used to show the listing page
		public function index($moduleName = NULL)
		{
			$data['moduleName'] = $moduleName;
			$data['moduleArr'] = $this->mastermodel->getModule($moduleName);
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage '.strtolower($data['moduleArr']['title']);
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/list' , $data);
		}

		//This function is used to get details from database and show in the datatable
		public function datatable()
		{
			if($this->input->post('draw'))
			{
				$responseArr = array();
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');

				//Get the details customized data
				$programData = $this->mastermodel->getDatatable($this->input->post('moduleName') , $this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir']);

				$responseArr['draw'] = $this->input->post('draw');
				$responseArr['recordsTotal'] = $programData['count_all'];
				$responseArr['recordsFiltered'] = $programData['count_all'];
				$responseArr['data'] = $programData['data'];
				echo json_encode($responseArr);
			}
		}

		//This function is used to perform both add and edit operation for master module
		function add_edit($moduleName = NULL , $id = NULL)
		{
			$fileUploadError = array();
			$post = array();
			$moduleArr = $this->mastermodel->getModule($moduleName);
			if($this->input->post('flag'))
			{
				if(!empty($moduleArr['field']))
				{
					foreach($moduleArr['field'] as $fieldKey => $fieldValue)
					{
						//Save entered value in post variable
						if($fieldValue['type'] != 'file')
							$post[$fieldKey] = $this->input->post($fieldKey);

						//Set validation rules dynamically
						if(isset($fieldValue['validation']))
						{
							if($fieldValue['type'] == 'file')
							{
								if((strpos($fieldValue['validation'] , 'imageRequired') !== FALSE) && $_FILES[$fieldKey]['name'] == '' && $this->input->post($fieldKey.'_oldImg') == '')
									$fileUploadError[] = $this->lang->line("required_upload_image");
							}
							else
							{
								$validationRulesStr = '';
								if(strpos($fieldValue['validation'] , 'required') !== FALSE)
									$validationRulesStr = ($validationRulesStr != '') ? $validationRulesStr.'|required' : 'required';
								if(strpos($fieldValue['validation'] , 'maxlength') !== FALSE)
									$validationRulesStr = ($validationRulesStr != '') ? $validationRulesStr.'|max_length[200]' : 'max_length[200]';
								$this->form_validation->set_rules($fieldKey , $fieldValue['fieldLabel'] , $validationRulesStr);
							}
						}
					}
				}

				if($this->form_validation->run() && empty($fileUploadError))
				{
					//Upload Image
					if(!empty($moduleArr['field']))
					{
						foreach($moduleArr['field'] as $fieldKey => $fieldValue)
						{
							if($fieldValue['type'] == 'file' && $fieldValue['fileType'] == 'image')
							{
								$post[$fieldKey] = $this->input->post($fieldKey.'_oldImg');
								if($this->input->post($fieldKey.'_changeFlag') == 2)
								{
									$uploadData = $this->image_upload->do_upload('./'.$fieldValue['uploadPath'] , $fieldKey , UPLOAD_IMAGE_SIZE , $fieldValue['width'] , $fieldValue['height']);
									if($uploadData['errorFlag'] == 0)
									{
										//Delete old file from directory if exists
										if($this->input->post('flag') == 'es' && $post[$fieldKey] != '')
										{
											if(file_exists('./'.$fieldValue['uploadPath'].$post[$fieldKey]))
												unlink('./'.$fieldValue['uploadPath'].$post[$fieldKey]);
											if(file_exists('./'.$fieldValue['uploadPath'].getThumbnailName($post[$fieldKey])))
												unlink('./'.$fieldValue['uploadPath'].getThumbnailName($post[$fieldKey]));
										}
										$post[$fieldKey] = $uploadData['fileName'];
									}
									else
										$fileUploadError[] = $uploadData['errorMessage'];
								}
							}
						}
					}

					//Add or update record in database(for add/edit operation)
					if(empty($fileUploadError))
					{
						if($this->input->post('flag') == 'as')
						{
							$this->admin_model->commonAdd($moduleArr['dbName'] , $post);
							$this->session->set_flashdata('success_message', str_replace('**module**' , $moduleArr['title'] , $this->lang->line('add_success_message')));
						}
						elseif($this->input->post('flag') == 'es')
						{
							$this->admin_model->commonUpdate($moduleArr['dbName'] , $moduleArr['key'].' = '.$id , $post);
							$this->session->set_flashdata('success_message', str_replace('**module**' , $moduleArr['title'] , $this->lang->line('edit_success_message')));
						}
					}

					//Cropping image and create thumb image of newly uploaded image
					if(!empty($moduleArr['field']))
					{
						foreach($moduleArr['field'] as $fieldKey => $fieldValue)
						{
							if($fieldValue['type'] == 'file' && $fieldValue['fileType'] == 'image')
							{
								if($this->input->post($fieldKey.'_changeFlag') == 2)
									$this->_handleCropping($post[$fieldKey] , $fieldValue , $moduleName);
							}
						}
					}
					redirect('/frontweb/master/index/'.$moduleName);
				}
			}
			if($id != '')
				$post = $this->mastermodel->getFormData($moduleName , $id);

			$data['moduleName'] = $moduleName;
			$data['moduleArr'] = $moduleArr;
			$data['id'] = $id;
			$data['actionUrl'] = ($id != '') ? '/frontweb/master/add_edit/'.$moduleName.'/'.$id : '/frontweb/master/add_edit/'.$moduleName;
			$data['post'] = $post;
			$data['flag'] = ($id != '') ? 'es' : 'as';
			$data['fileUploadError'] = $fileUploadError;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = ($id != '') ? 'Edit '.strtolower($data['moduleArr']['title']) : 'Add '.strtolower($data['moduleArr']['title']);
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/add_edit' , $data);
		}

		//Function is used to update program status through ajax call
		public function update_status()
		{
			if($this->input->post('id'))
			{
				$moduleArr = $this->mastermodel->getModule($this->input->post('module'));
				$data = array(
					$moduleArr['statusField'] => ($this->input->post('status') == 1) ? 0 : 1
				);
				$this->admin_model->commonUpdate($moduleArr['dbName'] , $moduleArr['key'].' = '.$this->input->post('id') , $data);
				echo TRUE;
			}
		}

		//Function is used to perform delete operation for master module(soft delete)
		function delete($module = NULL , $id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);
			$moduleArr = $this->mastermodel->getModule($module);
			$this->admin_model->commonUpdate($moduleArr['dbName'] , $moduleArr['key'].' = '.$id , $updateData);
			$this->session->set_flashdata('success_message', str_replace('**module**' , $moduleArr['title'] , $this->lang->line('delete_success_message')));
			redirect('/frontweb/master/index/'.$module);
		}

		//This function is used to check if the field is duplicate or not for master modules
		function check_duplicate()
		{
			if($this->input->post('module'))
			{
				$moduleArr = $this->mastermodel->getModule($this->input->post('module'));
				if($this->input->post('flag') == 'as')
					$whereCondition = "(".$this->input->post('field').")='".$this->input->post('data')."'";
				elseif($this->input->post('flag') == 'es')
					$whereCondition = "(".$this->input->post('field').")='".$this->input->post('data')."' AND (".$moduleArr['key'].") != ".$this->input->post('id');
				$result = $this->admin_model->commonGetData('count(*) as total' , $whereCondition , $moduleArr['dbName'] , 1);
				echo ($result['total'] > 0) ? 'false' : 'true';
			}
		}

		/***********Image Cropping functionality for master modules Start***********/
		public function _handleCropping($fileName = NULL , $fileDetails = array() , $moduleName = NULL)
		{
			$this->cropInit($fileName , $fileDetails , $moduleName);
			$this->cropping->image();
			exit();
		}

		public function process($action = NULL)
		{
			$this->cropInit();
			$this->cropping->process($action);
		}

		public function cropInit($fileName = NULL , $fileDetails = array() , $moduleName = NULL)
		{
			$param = array();
			if(empty($fileName))
				$param = $this->session->userdata("cropData");
			else
			{
				$param = array(
					'imageAbsPath' => FCPATH . $fileDetails['uploadPath'],
					'imageDestPath' => FCPATH . $fileDetails['uploadPath'],
					'imageName' => $fileName,
					'imageNewName' => $fileName,
					'imagePath' => base_url() . $fileDetails['uploadPath'],
					'imageWidth' => $fileDetails['width'],
					'imageHeight' => $fileDetails['height'],
					'thumbWidth' => $fileDetails['thumbWidth'],
					'thumbHeight' => $fileDetails['thumbHeight'],
					'redirectTo' => 'frontweb/master/index/'.$moduleName,
					'formCallbackAction' => 'frontweb/master/process'
				);
				$this->session->set_userdata("cropData" , $param);
			}
			$this->load->library("cropping" , $param);
		}
		/***********Image Cropping functionality for master modules End************/
	}
?>