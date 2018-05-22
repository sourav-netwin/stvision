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

		/**
		*This function is used to show the listing page
		*
		*@access public
		*@param String $moduleName : The name of the module
		*@return NONE
		*/
		public function index($moduleName = NULL)
		{
			$data['moduleName'] = $moduleName;
			$data['moduleArr'] = $this->mastermodel->getModule($moduleName);
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage '.strtolower($data['moduleArr']['title']);
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/list' , $data);
		}

		/**
		*This function is used to get details from database and show in the datatable
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
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

		/**
		*This function is used to perform both add and edit operation for master module
		*
		*@access public
		*@param String $moduleName : The name of the module
		*@param Integer $id : The module id
		*@return NONE
		*/
		function add_edit($moduleName = NULL , $id = NULL)
		{
			$fileUploadError = array();
			$post = $submoduleArr = $subTablePost = array();
			$moduleArr = $this->mastermodel->getModule($moduleName);
			if($this->input->post('flag'))
			{
				if(!empty($moduleArr['field']))
				{
					foreach($moduleArr['field'] as $fieldKey => $fieldValue)
					{
						//Save the submodule details in the array
						if($fieldValue['type'] == 'subtable')
							$submoduleArr = $this->mastermodel->getModule($fieldKey);
						else
						{
							//Save entered value in post variable
							if($fieldValue['type'] != 'file')
							{
								if($fieldValue['type'] == 'date')
									$post[$fieldKey] = date('Y-m-d' , strtotime($this->input->post($fieldKey)));
								else
									$post[$fieldKey] = $this->input->post($fieldKey);
							}

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
									if(strpos($fieldValue['validation'] , 'numeric') !== FALSE)
										$validationRulesStr = ($validationRulesStr != '') ? $validationRulesStr.'|numeric' : 'numeric';
									if(strpos($fieldValue['validation'] , 'maxlength') !== FALSE)
										$validationRulesStr = ($validationRulesStr != '') ? $validationRulesStr.'|max_length[200]' : 'max_length[200]';
									$this->form_validation->set_rules($fieldKey , $fieldValue['fieldLabel'] , $validationRulesStr);
								}
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
							//Save the added date and time(If required)
							if(isset($moduleArr['addedDateField']))
								$post[$moduleArr['addedDateField']] = date('Y-m-d H:i:s');

							//For sub module , save the foreign key value as reference
							if($this->input->post('foreignKeyValue') != '')
								$post[$moduleArr['foreignKey']] = $this->input->post('foreignKeyValue');

							$insertId = $this->admin_model->commonAdd($moduleArr['dbName'] , $post);
							$this->session->set_flashdata('success_message', str_replace('**module**' , $moduleArr['title'] , $this->lang->line('add_success_message')));
						}
						elseif($this->input->post('flag') == 'es')
						{
							$this->admin_model->commonUpdate($moduleArr['dbName'] , $moduleArr['key'].' = '.$id , $post);
							//Delete the subtable values for edit
							if(!empty($submoduleArr))
								$this->admin_model->commonDelete($submoduleArr['dbName'] , $submoduleArr['foreignKey'].' = '.$id);
							$this->session->set_flashdata('success_message', str_replace('**module**' , $moduleArr['title'] , $this->lang->line('edit_success_message')));
						}
					}

					//Prepare submodule post value and save in the database
					if(!empty($submoduleArr))
					{
						for($i = 0 ; $i < count($this->input->post(array_shift(array_keys($submoduleArr['field'])))) ; $i++)
						{
							$subTablePost = array();
							foreach($submoduleArr['field'] as $fieldKey => $fieldValue)
							{
								$tempPostValue = $this->input->post($fieldKey);
								$subTablePost[$fieldKey] = $tempPostValue[$i];
							}
							$subTablePost[$submoduleArr['foreignKey']] = ($this->input->post('flag') == 'as') ? $insertId : $id;
							$this->admin_model->commonAdd($submoduleArr['dbName'] , $subTablePost);
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
								{
									if($this->input->post('foreignKeyValue') != '')
										$this->_handleCropping($post[$fieldKey] , $fieldValue , $moduleName , $this->input->post('foreignKeyValue'));
									else
										$this->_handleCropping($post[$fieldKey] , $fieldValue , $moduleName);
								}
							}
						}
					}

					if($this->input->post('foreignKeyValue') != '')
						redirect('/frontweb/master/manage_submodule/'.$moduleName.'/'.$this->input->post('foreignKeyValue'));
					else
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

		/**
		*Function is used to update program status through ajax call
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
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

		/**
		*Function is used to perform delete operation for master module(soft delete)
		*
		*@access public
		*@param String $module : The name of the module
		*@param Integer $id : The module id
		*@param Integer $submoduleId : The submodule id
		*@return NONE
		*/
		public function delete($module = NULL , $id = NULL , $submoduleId = NULL)
		{
			$moduleArr = $this->mastermodel->getModule($module);
			if(isset($moduleArr['parentModule']))
			{
				foreach($moduleArr['field'] as $fieldKey => $fieldValue)
				{
					if($fieldValue['type'] == 'file')
					{
						$postData = $this->admin_model->commonGetData($fieldKey , $moduleArr['key'].' = '.$id , $moduleArr['dbName'] , 1);
						if(file_exists('./'.$fieldValue['uploadPath'].$postData[$fieldKey]))
							unlink('./'.$fieldValue['uploadPath'].$postData[$fieldKey]);
						if(file_exists('./'.$fieldValue['uploadPath'].getThumbnailName($postData[$fieldKey])))
							unlink('./'.$fieldValue['uploadPath'].getThumbnailName($postData[$fieldKey]));
					}
				}
				$this->admin_model->commonDelete($moduleArr['dbName'] , $moduleArr['key'].' = '.$id);
				redirect('/frontweb/master/manage_submodule/'.$module.'/'.$submoduleId);
			}
			//Hard delete from database with foreign key checking
			elseif(isset($moduleArr['deleteCheck']))
			{
				$this->admin_model->commonDelete($moduleArr['dbName'] , $moduleArr['key'].' = '.$id);
				$this->deleteCheck($moduleArr['deleteCheck'] , $id);
			}
			//Soft delete from database(by changing one flag)
			else
			{
				$updateData = array(
					'delete_flag' => 1
				);
				$this->admin_model->commonUpdate($moduleArr['dbName'] , $moduleArr['key'].' = '.$id , $updateData);
			}
			if($module == 'manage_extra_activity' && (strpos($_SERVER["HTTP_REFERER"] , 'manage_extra_activity') === FALSE))
				redirect('/frontweb/extra_activity/index');
			else
			{
				$this->session->set_flashdata('success_message', str_replace('**module**' , $moduleArr['title'] , $this->lang->line('delete_success_message')));
				redirect('/frontweb/master/index/'.$module);
			}
		}

		/**
		*This function is used to delete the master module data recursively for the submodules
		*
		*@access private
		*@param String $moduleName : Module name
		*@param String $idList : The foreign key id list
		*@return NONE
		*/
		private function deleteCheck($moduleName = NULL , $idList = NULL)
		{
			$moduleArr = $this->mastermodel->getModule($moduleName);
			if(isset($moduleArr['deleteCheck']))
				$referenceKeyList = $this->admin_model->commonGetData('group_concat('.$moduleArr['key'].') as id' , $moduleArr['foreignKey'].' in ('.$idList.')' , $moduleArr['dbName'] , 1);
			$this->admin_model->commonDelete($moduleArr['dbName'] , $moduleArr['foreignKey'].' in ('.$idList.')');
			if(isset($moduleArr['deleteCheck']))
				$this->deleteCheck($moduleArr['deleteCheck'] , $referenceKeyList['id']);
		}

		/**
		*This function is used to check if the field is duplicate or not for master modules
		*
		*@access public
		*@param NONE
		*@return NONE
		*/
		public function check_duplicate()
		{
			if($this->input->post('module'))
			{
				$moduleArr = $this->mastermodel->getModule($this->input->post('module'));
				$dataValue = ($moduleArr['field'][$this->input->post('field')]['type'] == 'date') ? date('Y-m-d' , strtotime($this->input->post('data'))) : $this->input->post('data');
				if($this->input->post('flag') == 'as')
					$whereCondition = "(".$this->input->post('field').")='".$dataValue."'";
				elseif($this->input->post('flag') == 'es')
					$whereCondition = "(".$this->input->post('field').")='".$dataValue."' AND (".$moduleArr['key'].") != ".$this->input->post('id');
				if($this->input->post('dependField') != '' && $this->input->post('dependValue') != '')
					$whereCondition.= ' AND ('.$this->input->post('dependField').' = '.$this->input->post('dependValue').')';
				$result = $this->admin_model->commonGetData('count(*) as total' , $whereCondition , $moduleArr['dbName'] , 1);
				echo ($result['total'] > 0) ? 'false' : 'true';
			}
		}

		/**
		*This function is used to manage submodule module (Both listing and add/edit)
		*
		*@access public
		*@param String $moduleName : Module Name
		*@param Integer $id : The foreign key id
		*@return NONE
		*/
		public function manage_submodule($moduleName = NULL , $id = NULL , $subModuleId = NULL)
		{
			$post = array();
			$moduleArr = $this->mastermodel->getModule($moduleName);
			$listResult = $this->mastermodel->getDatatable($moduleName , NULL , NULL , NULL , NULL , NULL , $id);
			if($subModuleId != '')
				$post = $this->mastermodel->getFormData($moduleName , $subModuleId);
			$data['listResult'] = $listResult['data'];
			$data['moduleName'] = $moduleName;
			$data['moduleArr'] = $moduleArr;
			$data['id'] = $id;
			$data['flag'] = ($subModuleId != '') ? 'es' : 'as';
			$data['actionUrl'] = ($subModuleId != '') ? '/frontweb/master/add_edit/'.$moduleName.'/'.$subModuleId : '/frontweb/master/add_edit/'.$moduleName;
			$data['post'] = $post;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['moduleArr']['title'];
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/manage_submodule' , $data);
		}

		/***********Image Cropping functionality for master modules Start***********/
		public function _handleCropping($fileName = NULL , $fileDetails = array() , $moduleName = NULL , $foreignKeyValue = NULL)
		{
			$this->cropInit($fileName , $fileDetails , $moduleName , $foreignKeyValue);
			$this->cropping->image();
			exit();
		}

		public function process($action = NULL)
		{
			$this->cropInit();
			$this->cropping->process($action);
		}

		public function cropInit($fileName = NULL , $fileDetails = array() , $moduleName = NULL , $foreignKeyValue = NULL)
		{
			$redirectUrl = ($foreignKeyValue != '') ? 'frontweb/master/manage_submodule/'.$moduleName.'/'.$foreignKeyValue : 'frontweb/master/index/'.$moduleName;
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
					'redirectTo' => $redirectUrl,
					'formCallbackAction' => 'frontweb/master/process'
				);
				$this->session->set_userdata("cropData" , $param);
			}
			$this->load->library("cropping" , $param);
		}
		/***********Image Cropping functionality for master modules End************/
	}
?>