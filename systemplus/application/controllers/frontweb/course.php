<?php
	class Course extends Controller
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

		//This function is used to show listing page for the course
		public function index()
		{
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage course';
			$data['title'] = 'plus-ed.com | Manage course';
			$this->ltelayout->view('frontweb/course_list' , $data);
		}

		//This function is used to get all course details from DB and display in datatable
		public function get_course()
		{
			if($this->input->post('draw'))
			{
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');
				//For now , only english
				$languageId = 1;
				$responseArr = array();
				$programData = $this->admin_model->getCourseDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir'] , $languageId);

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
			if($this->input->post('course_id'))
			{
				$data = array(
					'course_status' => ($this->input->post('course_status') == 1) ? 0 : 1
				);
				$this->admin_model->updateCourse($this->input->post('course_id') , $data);
				echo TRUE;
			}
		}

		//This function is used to add courses in DB
		public function add()
		{
			$imageError = $imageErrorHome = '';
			if($this->input->post('language_id'))
			{
				if($_FILES['course_image']['name'] != '')
					$uploadData = $this->image_upload->do_upload('./'.COURSE_IMAGE_PATH , 'course_image' , UPLOAD_IMAGE_SIZE , COURSE_WIDTH , COURSE_HEIGHT);
				if($_FILES['course_front_image']['name'] != '')
					$uploadDataFront = $this->image_upload->do_upload('./'.COURSE_FRONT_IMAGE_PATH , 'course_front_image' , UPLOAD_IMAGE_SIZE , COURSE_FRONT_WIDTH , COURSE_FRONT_HEIGHT);
				if($uploadData['errorFlag'] == 0 && $uploadDataFront['errorFlag'] == 0)
				{
					$postData = array(
						'language_id' => $this->input->post('language_id'),
						'course_name' => $this->input->post('course_name'),
						'corse_description' => $this->input->post('corse_description'),
						'specification_option' => $this->input->post('specification_option'),
						'specification_value' => $this->input->post('specification_value'),
					);
					$this->admin_model->addCourse($postData , $uploadData['fileName'] , $uploadDataFront['fileName']);
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'Course' , $this->lang->line('add_success_message')));
					$this->_handleCropping($uploadData['fileName'] , 'add' , 'course_image' , COURSE_WIDTH , COURSE_HEIGHT , COURSE_THUMB_WIDTH , COURSE_THUMB_HEIGHT , 1 , $uploadDataFront['fileName']);
					redirect('/frontweb/course');
				}
				else
				{
					$imageError = $uploadData['errorMessage'];
					$imageErrorHome = $uploadDataFront['errorMessage'];
				}
			}
			$data['imageError'] = $imageError;
			$data['imageErrorHome'] = $imageErrorHome;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Add course';
			$data['title'] = 'plus-ed.com | Add course';
			$this->ltelayout->view('frontweb/course_add' , $data);
		}

		//This function is used to show edit page and edit record from DB
		function edit($id = NULL)
		{
			$imageError = $imageErrorHome = '';
			if($this->input->post('language_id'))
			{
				$file_name = $this->input->post('oldImg');
				$file_name_front = $this->input->post('oldImgHome');
				if($this->input->post('imageChangeFlag') == 2)
				{
					$uploadData = $this->image_upload->do_upload('./'.COURSE_IMAGE_PATH , 'course_image' , UPLOAD_IMAGE_SIZE , COURSE_WIDTH , COURSE_HEIGHT);
					if($uploadData['errorFlag'] == 0)
					{
						//Delete old file
						if(file_exists('./'.COURSE_IMAGE_PATH.$file_name))
							unlink('./'.COURSE_IMAGE_PATH.$file_name);
						if(file_exists('./'.COURSE_IMAGE_PATH.getThumbnailName($file_name)))
							unlink('./'.COURSE_IMAGE_PATH.getThumbnailName($file_name));
						$file_name = $uploadData['fileName'];
					}
					else
						$imageError = $uploadData['errorMessage'];
				}
				if($this->input->post('imageChangeFlagHome') == 2)
				{
					$uploadDataFront = $this->image_upload->do_upload('./'.COURSE_FRONT_IMAGE_PATH , 'course_front_image' , UPLOAD_IMAGE_SIZE , COURSE_FRONT_WIDTH , COURSE_FRONT_HEIGHT);
					if($uploadDataFront['errorFlag'] == 0)
					{
						//Delete old file
						if(file_exists('./'.COURSE_FRONT_IMAGE_PATH.$file_name_front))
							unlink('./'.COURSE_FRONT_IMAGE_PATH.$file_name_front);
						if(file_exists('./'.COURSE_FRONT_IMAGE_PATH.getThumbnailName($file_name_front)))
							unlink('./'.COURSE_FRONT_IMAGE_PATH.getThumbnailName($file_name_front));
						$file_name_front = $uploadDataFront['fileName'];
					}
					else
						$imageErrorHome = $uploadData['errorMessage'];
				}
				if($imageError == '' && $imageErrorHome == '')
				{
					$postData = array(
						'language_id' => $this->input->post('language_id'),
						'course_name' => $this->input->post('course_name'),
						'corse_description' => $this->input->post('corse_description'),
						'specification_option' => $this->input->post('specification_option'),
						'specification_value' => $this->input->post('specification_value'),
					);
					$this->admin_model->updateCourseData($id , $postData , $file_name , $file_name_front);
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'Course' , $this->lang->line('edit_success_message')));
					if($this->input->post('imageChangeFlag') == 2 && $this->input->post('imageChangeFlagHome') == 2)
						$this->_handleCropping($file_name , 'edit' , 'course_image' , COURSE_WIDTH , COURSE_HEIGHT , COURSE_THUMB_WIDTH , COURSE_THUMB_HEIGHT , 1 , $file_name_front);
					elseif($this->input->post('imageChangeFlag') == 2)
						$this->_handleCropping($file_name , 'edit' , 'course_image' , COURSE_WIDTH , COURSE_HEIGHT , COURSE_THUMB_WIDTH , COURSE_THUMB_HEIGHT);
					elseif($this->input->post('imageChangeFlagHome') == 2)
						$this->_handleCropping($file_name_front , 'edit' , 'course_front_image' , COURSE_FRONT_WIDTH , COURSE_FRONT_HEIGHT , COURSE_FRONT_THUMB_WIDTH , COURSE_FRONT_THUMB_HEIGHT);
					redirect('/frontweb/course');
				}
			}

			$post = $this->admin_model->getEditCourseData($id , 1);
			$data['post'] = $post;
			$data['imageError'] = $imageError;
			$data['imageErrorHome'] = $imageErrorHome;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Edit course';
			$data['title'] = 'plus-ed.com | Edit course';
			$this->ltelayout->view('frontweb/course_edit' , $data);
		}

		//Function is used to delete record from DB
		function delete($id = NULL)
		{
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'Course' , $this->lang->line('delete_success_message')));
			$this->admin_model->deleteCourse($id);
			redirect('/frontweb/course');
		}

		//Function is used to get all the features related to the selected course
		function get_course_feature()
		{
			$str = '';
			$feature_arr = $this->admin_model->getCourseFeature($this->input->post('course_id'));

			if(!empty($feature_arr))
			{
				foreach($feature_arr as $key => $value)
				{
					$str.= '<div id="add_more_wrapper_'.($key+1).'" class="add_more_wrapper border-box">
								<div class="form-group">
									<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Title<span class="required">*</span></label>
									<div class="col-md-9 col-sm-9 col-xs-12">';
					$inputFieldAttribute = array(
						'name' => 'feature_title['.($key+1).']',
						'id' => 'feature_title['.($key+1).']',
						'class' => 'form-control',
						'placeholder' => 'Title',
						'value' => $value['feature_title']
					);
					$str.= form_input($inputFieldAttribute);
					$str.= '</div>
							<div class="clearfix"></div>
							</div>
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">';
					$inputFieldAttribute = array(
						'name' => 'feature_description['.($key+1).']',
						'id' => 'feature_description_'.($key+1),
						'class' => 'form-control summernote',
						'placeholder' => 'Title',
						'value' => $value['feature_description']
					);
					$str.= form_textarea($inputFieldAttribute);
					$str.= '<span id="descriptionErrorMessage_'.($key+1).'" style="color:#ff0000"></span>';
					$str.= '</div></div>
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload image <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="hidden" name="imageChangeFlag['.($key+1).']" id="imageChangeFlag_'.($key+1).'" value="1" />
									<input type="hidden" id="imgWidthErrorFlag_'.($key+1).'" value="1" />
									<input type="hidden" name="oldImg['.($key+1).']" id="oldImg_'.($key+1).'" value="'.$value['feature_image'].'" />
									<label for="feature_image_'.($key+1).'">';
					$imgPath = ($value['feature_image'] != '') ? base_url().'uploads/course_feature/'.$value['feature_image'] : LTE.'frontweb/no_flag.jpg';
					$str.= '<img height="50" width="180" class="uploadImageProgramClass" src="'.$imgPath.'"/></label>';
					$inputFieldAttribute = array(
						'id' => 'feature_image_'.($key+1),
						'name' => 'feature_image_'.($key+1),
						'type' => 'file',
						'style' => 'visibility: hidden;',
						'class' => 'feature_image_class'
					);
					$str.= form_input($inputFieldAttribute);
					$str.= '<small style="display:block">
								( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; image size should be exact 800 X 500 pixel )
							</small>
							<span id="imgErrorMessage_'.($key+1).'" style="color:#ff0000"></span>
							</div></div></div>';
					if(count($feature_arr) == ($key + 1))
						$str.= '<div style="float: right;"><i class="fa fa-lg fa-plus-circle add_more_icon" aria-hidden="true" data-block_no='.($key+1).'></i></div><div class="clearfix"></div>';
					else
						$str.= '<div style="float: right;"><i class="fa fa-lg fa-minus-circle remove_more_icon" aria-hidden="true" data-block_no='.($key+1).'></i></div><div class="clearfix"></div>';
				}
			}
			else
			{
				$str.= '<div id="add_more_wrapper_1" class="add_more_wrapper border-box">
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Title<span class="required">*</span></label>
								<div class="col-md-9 col-sm-9 col-xs-12">';
				$inputFieldAttribute = array(
					'name' => 'feature_title[1]',
					'id' => 'feature_title[1]',
					'class' => 'form-control',
					'placeholder' => 'Title'
				);
				$str.= form_input($inputFieldAttribute);
				$str.= '</div>
						<div class="clearfix"></div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
							<div class="col-md-9 col-sm-9 col-xs-12">';
				$inputFieldAttribute = array(
					'name' => 'feature_description[1]',
					'id' => 'feature_description_1',
					'class' => 'form-control summernote',
					'placeholder' => 'Title'
				);
				$str.= form_textarea($inputFieldAttribute);
				$str.= '<span id="descriptionErrorMessage_1" style="color:#ff0000"></span>';
				$str.= '</div></div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="imageChangeFlag[1]" id="imageChangeFlag_1" value="1" />
								<input type="hidden" id="imgWidthErrorFlag_1" value="1" />
								<input type="hidden" name="oldImg[1]" id="oldImg_1" value="" />
								<label for="feature_image_1">';
				$imgPath = LTE.'frontweb/no_flag.jpg';
				$str.= '<img height="50" width="180" class="uploadImageProgramClass" src="'.$imgPath.'"/></label>';
				$inputFieldAttribute = array(
					'id' => 'feature_image_1',
					'name' => 'feature_image_1',
					'type' => 'file',
					'style' => 'visibility: hidden;',
					'class' => 'feature_image_class'
				);
				$str.= form_input($inputFieldAttribute);
				$str.= '<small style="display:block">
							( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; image size should be exact 800 X 500 pixel )
						</small>
						<span id="imgErrorMessage_1" style="color:#ff0000"></span>
						</div></div></div>';
				$str.= '<div style="float: right;"><i class="fa fa-lg fa-plus-circle add_more_icon" aria-hidden="true" data-block_no=1></i></div><div class="clearfix"></div>';
			}

			$data['total_record'] = (count($feature_arr) == 0) ? 1 : count($feature_arr);
			$data['str'] = $str;
			echo json_encode($data);
		}

		//This function is used to add course features in DB
		function add_course_feature()
		{
			$postArray = array(
				'global_more_count' => $this->input->post('global_more_count'),
				'course_id' => $this->input->post('course_id'),
				'feature_title' => $this->input->post('feature_title'),
				'feature_description' => $this->input->post('feature_description'),
				'imageChangeFlag' => $this->input->post('imageChangeFlag'),
				'oldImg' => $this->input->post('oldImg')
			);
			if($postArray)
			{
				for($i = 1 ; $i <= $postArray['global_more_count'] ; $i++)
				{
					$postData[$i]['feature_title'] = $postArray['feature_title'][$i];
					$postData[$i]['feature_description'] = $postArray['feature_description'][$i];
					$postData[$i]['course_id'] = $postArray['course_id'];
					if($postArray['imageChangeFlag'][$i] == 1)
						$postData[$i]['feature_image'] = $postArray['oldImg'][$i];
					else
					{
						$uploadData = $this->image_upload->do_upload('./uploads/course_feature/' , 'feature_image_'.$i , UPLOAD_IMAGE_SIZE , 800 , 500);
						if($uploadData['errorFlag'] == 0)
						{
							//Delete old file if exist
							if($postArray['oldImg'][$i] != '')
							{
								if(file_exists('./uploads/course_feature/'.$postArray['oldImg'][$i]))
									unlink('./uploads/course_feature/'.$postArray['oldImg'][$i]);
							}
							$postData[$i]['feature_image'] = $uploadData['fileName'];
						}
						else
							$postData[$i]['feature_image'] = '';
					}
				}
				$this->admin_model->updateCourseFeature($postArray['course_id'] , $postData);
				$this->session->set_flashdata('success_message', str_replace('**module**' , 'Course' , $this->lang->line('edit_success_message')));
				redirect('/frontweb/course');
			}
		}

		//This function is used to show application form managemnet form
		function show_form_management()
		{
			$str = '';
			$formData = $this->admin_model->commonGetData('*' , '' , TABLE_MANAGE_APPLICATION_FORM , 2 , 'sequence' , 'asc');
			$count = (count($formData) == 0) ? 1 : count($formData);
			for($i = 1 ; $i <= $count ; $i++)
			{
				$labelName = isset($formData[$i-1]['label_name']) ? $formData[$i-1]['label_name'] : '';
				$fieldType = isset($formData[$i-1]['field_type']) ? $formData[$i-1]['field_type'] : '';
				$checkedFlag = (isset($formData[$i-1]['required_flag']) && $formData[$i-1]['required_flag'] == 1) ? 'checked' : '';
				$fieldSequence = isset($formData[$i-1]['sequence']) ? $formData[$i-1]['sequence'] : '';
				$str.= '<div id="sectionWrapper_'.$i.'" class="sectionWrapper">
							<div style="border: 1px solid #ccc;padding: 15px;">
								<div class="form-group">
									<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Label Name<span class="required">*</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<textarea name="label_name['.$i.']" id="label_name['.$i.']" class="form-control labelName" rows="2" required>'.$labelName.'</textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Field Type <span class="required">*</span></label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										'.form_dropdown('field_type['.$i.']' , getFieldDropdown() , $fieldType , 'class="form-control fieldType" id="field_type['.$i.']" required').
									'</div>
								</div>';
				if($fieldType == 'checkbox' || $fieldType == 'radio' || $fieldType == 'dropdown')
				{
					$str.= '<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Field Values<span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea name="multiple_value['.$i.']" id="multiple_value['.$i.']" class="form-control multipleValue" rows="2" required>'.$formData[$i-1]['multiple_value'].'</textarea>
								</div>
							</div>';
				}
				$str.= '<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Sequence</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" class="form-control fieldSequence" style="width: 51px;" name="sequence['.$i.']" id="sequence['.$i.']" value="'.$fieldSequence.'" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Required</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="checkbox" class="requiredFlag" name="required_flag['.$i.']" id="required_flag['.$i.']" value="1" '.$checkedFlag.'>
							</div>
						</div>
					</div>
					<div class="addRemoveSection" style="float: right;">';
				if($count != 1)
					$str.= '<i class="fa fa-lg fa-minus-circle remove_section" aria-hidden="true"></i>';
				if($i == $count)
					$str.= '<i class="fa fa-lg fa-plus-circle add_section" aria-hidden="true"></i>';
				$str.= '</div>
						<div class="clearfix"></div><hr>
						<div>';
			}
			$data = array(
				'count' => $count,
				'design' => $str
			);
			echo json_encode($data);
		}

		//This function is used to update the application form management
		function update_form()
		{
			if($this->input->post('globalCount'))
			{
				$labelnameArr = $this->input->post('label_name');
				$fieldTypeArr = $this->input->post('field_type');
				$requiredFlagArr = $this->input->post('required_flag');
				$multiplevalueArr = $this->input->post('multiple_value');
				$sequenceArr = $this->input->post('sequence');
				if(!empty($labelnameArr))
				{
					$this->admin_model->commonDelete(TABLE_MANAGE_APPLICATION_FORM , "label_name != ''");
					foreach($labelnameArr as $key => $value)
					{
						$insertData = array(
							'label_name' => $value,
							'field_type' => $fieldTypeArr[$key],
							'required_flag' => (isset($requiredFlagArr[$key])) ? $requiredFlagArr[$key] : '',
							'multiple_value' => (isset($multiplevalueArr[$key])) ? $multiplevalueArr[$key] : '',
							'sequence' => $sequenceArr[$key]
						);
						$this->admin_model->commonAdd(TABLE_MANAGE_APPLICATION_FORM , $insertData);
					}
				}
				$this->session->set_flashdata('success_message', str_replace('**module**' , 'Course' , $this->lang->line('edit_success_message')));
				redirect('/frontweb/course');
			}
		}

		//This function is used to show the enquiry form details
		function show_enquiry_form()
		{
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Show enquiry form';
			$data['title'] = 'plus-ed.com | Show enquiry form';
			$this->ltelayout->view('frontweb/enquiry_form_list' , $data);
		}

		//This function is used to get all enquiry form details from DB and display in datatable
		public function get_form_details()
		{
			if($this->input->post('draw'))
			{
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');
				//For now , only english
				$languageId = 1;
				$responseArr = array();
				$programData = $this->admin_model->getFormDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir'] , $languageId);

				$responseArr['draw'] = $this->input->post('draw');
				$responseArr['recordsTotal'] = $programData['count_all'];
				$responseArr['recordsFiltered'] = $programData['count_filtered'];
				$responseArr['data'] = $programData['data'];
				echo json_encode($responseArr);
			}
		}

		//This function is used to get the form details filled by an user for enquiry form
		function get_user_form()
		{
			if($this->input->post('user'))
			{
				$result = $this->admin_model->commonGetData('field_name , field_value' , 'user = '.$this->input->post('user') , TABLE_APPLICATION_FORM_DATA , 2);
				$str = '';
				if(!empty($result))
				{
					foreach($result as $value)
					{
						$str.= '<div class="form-group">
									<label style="color: #999;" class="control-label custom-control-label col-xs-12">
										'.$value['field_name'].'
									</label>
									<div class="col-xs-12">
										<span class="span-form-control">
											'.$value['field_value'].'
										</span>
									</div>
								</div>
								<div class="clearfix"></div><br>';
					}
				}
				echo $str;
			}
		}

		/****************Image Cropping functionality Start******************/
		public function crop_again($fileName = NULL , $flag = NULL , $pathFlag = NULL , $width = NULL , $height = NULL , $thumbWidth = NULL , $thumbHeight = NULL)
		{
			$this->_handleCropping($fileName , $flag , $pathFlag , $width , $height , $thumbWidth , $thumbHeight);
		}

		public function _handleCropping($fileName = NULL , $flag = NULL , $pathFlag = NULL , $width = NULL , $height = NULL , $thumbWidth = NULL , $thumbHeight = NULL , $actionForFront = NULL , $frontFileName = NULL)
		{
			$this->cropInit($fileName , $flag , $pathFlag , $width , $height , $thumbWidth , $thumbHeight , $actionForFront , $frontFileName);
			$this->cropping->image();
			exit();
		}

		public function process($action = NULL)
		{
			$this->cropInit();
			$this->cropping->process($action);
		}

		public function cropInit($file_name = NULL , $flag = NULL , $pathFlag = NULL , $width = NULL , $height = NULL , $thumbWidth = NULL , $thumbHeight = NULL , $actionForFront = NULL , $frontFileName = NULL)
		{
			if($pathFlag == 'course_image')
				$path = COURSE_IMAGE_PATH;
			elseif($pathFlag == 'course_front_image')
				$path = COURSE_FRONT_IMAGE_PATH;
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
					'redirectTo' => 'frontweb/course',
					'formCallbackAction' => 'frontweb/course/process'
				);
				if($actionForFront == 1)
					$param['redirectTo'] = 'frontweb/course/crop_again/'.$frontFileName.'/'.$flag.'/course_front_image/'.COURSE_FRONT_WIDTH.'/'.COURSE_FRONT_HEIGHT.'/'.COURSE_FRONT_THUMB_WIDTH.'/'.COURSE_FRONT_THUMB_HEIGHT;
				$this->session->set_userdata("cropData" , $param);
			}
			$this->load->library("cropping" , $param);
		}
		/******************Image Cropping functionality End*********************/
	}
?>