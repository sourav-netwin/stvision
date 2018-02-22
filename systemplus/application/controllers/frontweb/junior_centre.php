<?php
	class Junior_centre extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			authSessionMenu($this);
			$this->load->helper('html');
			$this->lang->load('message' , 'english');
			$this->load->helper('frontweb/backend');
			$this->load->model('frontweb/admin_model' , '' , TRUE);
			$this->load->library('frontweb/image_upload');
		}

		//This function is used to show listing page for the course
		public function index()
		{
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage junior centre';
			$data['title'] = 'plus-ed.com | Manage junior centre';
			$this->ltelayout->view('frontweb/junior_centre_list' , $data);
		}

		//This function is used to get all course details from DB and display in datatable
		public function get_junior_centre()
		{
			if($this->input->post('draw'))
			{
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');
				//For now , only english
				$languageId = 1;
				$responseArr = array();
				$programData = $this->admin_model->getjuniorCentreDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir'] , $languageId);

				$responseArr['draw'] = $this->input->post('draw');
				$responseArr['recordsTotal'] = $programData['count_all'];
				$responseArr['recordsFiltered'] = $programData['count_all'];
				$responseArr['data'] = $programData['data'];
				echo json_encode($responseArr);
			}
		}

		//Function is used to update program status through ajax call
		public function update_status()
		{
			if($this->input->post('junior_centre_id'))
			{
				$data = array(
					'junior_centre_status' => ($this->input->post('junior_centre_status') == 1) ? 0 : 1
				);
				$this->admin_model->commonUpdate(TABLE_JUNIOR_CENTRE , 'junior_centre_id = '.$this->input->post('junior_centre_id') , $data);
				echo TRUE;
			}
		}

		//This function is used to perform add/edit operation for junior centre module
		function add_edit($id = NULL)
		{
			$imageError = '';
			if($this->input->post('flag'))
			{
				$file_name = $this->input->post('oldImg');
				if($this->input->post('imageChangeFlag') == 2)
				{
					$uploadData = $this->image_upload->do_upload('./'.JUNIOR_CENTRE_IMAGE_PATH , 'centre_banner' , UPLOAD_IMAGE_SIZE , JUNIOR_CENTRE_WIDTH , JUNIOR_CENTRE_HEIGHT);
					if($uploadData['errorFlag'] == 0)
					{
						if($this->input->post('flag') == 'es')
						{
							//Delete old file
							if(file_exists('./'.JUNIOR_CENTRE_IMAGE_PATH.$file_name))
								unlink('./'.JUNIOR_CENTRE_IMAGE_PATH.$file_name);
							if(file_exists('./'.JUNIOR_CENTRE_IMAGE_PATH.getThumbnailName($file_name)))
								unlink('./'.JUNIOR_CENTRE_IMAGE_PATH.getThumbnailName($file_name));
						}
						$file_name = $uploadData['fileName'];
					}
					else
						$imageError = $uploadData['errorMessage'];
				}
				if($imageError == '')
				{
					$updateData = array(
						'centre_banner' => $file_name,
						'accommodation' => $this->input->post('accommodation'),
						'course' => $this->input->post('course')
					);
					$programDetails = $this->input->post('centre_program');

					if($this->input->post('flag') == 'as')
					{
						$updateData['centre_id'] = $this->input->post('centre_id');
						$insertId = $this->admin_model->commonAdd(TABLE_JUNIOR_CENTRE , $updateData);
						$this->session->set_flashdata('success_message', str_replace('**module**' , 'Junior centre' , $this->lang->line('add_success_message')));
					}
					elseif($this->input->post('flag') == 'es')
					{
						$this->admin_model->commonUpdate(TABLE_JUNIOR_CENTRE , 'junior_centre_id = '.$id , $updateData);
						$this->admin_model->commonDelete(TABLE_JUNIOR_CENTRE_PROGRAM , 'junior_centre_id = '.$id);
						$this->session->set_flashdata('success_message', str_replace('**module**' , 'Junior centre' , $this->lang->line('edit_success_message')));
					}
					if(!empty($programDetails))
					{
						foreach($programDetails as $value)
						{
							$subModuleData = array(
								'program_id' => $value,
								'program_details' => $this->input->post('program_'.$value),
								'junior_centre_id' => ($this->input->post('flag') == 'as') ? $insertId : $id
							);
							$this->admin_model->commonAdd(TABLE_JUNIOR_CENTRE_PROGRAM , $subModuleData);
						}
					}
					if($this->input->post('imageChangeFlag') == 2)
						$this->_handleCropping($file_name , 'add_edit');
					redirect('/frontweb/junior_centre');
				}
			}

			if($id != '')
			{
				$post = $this->admin_model->getEditJuniorCentreData($id);
				$data['post'] = $post;
			}

			$data['id'] = $id;
			$data['flag'] = ($id != '') ? 'es' : 'as';
			$data['imageError'] = $imageError;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = ($id != '') ? 'Edit junior centre' : 'Add junior centre';
			$data['title'] = 'plus-ed.com | '.$data['pageHeader'];
			$this->ltelayout->view('frontweb/junior_centre_add_edit' , $data);
		}

		//Function is used to delete record from DB
		function delete($id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);
			$this->admin_model->commonUpdate(TABLE_JUNIOR_CENTRE , 'junior_centre_id = '.$id , $updateData);
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'Junior centre' , $this->lang->line('delete_success_message')));
			redirect('/frontweb/junior_centre');
		}

		//Function is used to update data for all upload pdf management in junior centre module
		function upload_pdf_management()
		{
			if($this->input->post('juniorCentreId'))
			{
				$fileUploadErrorMsg = '';
				if($this->input->post('uploadPdfModalType') == 'addon')
					$uploadPath = ADD_ON_FILE_PATH;
				elseif($this->input->post('uploadPdfModalType') == 'factsheet')
					$uploadPath = FACTSHEET_FILE_PATH;
				elseif($this->input->post('uploadPdfModalType') == 'activity_program')
					$uploadPath = ACTIVITY_PROGRAM_FILE_PATH;
				elseif($this->input->post('uploadPdfModalType') == 'menu')
					$uploadPath = MENU_FILE_PATH;
				elseif($this->input->post('uploadPdfModalType') == 'walking_tour')
					$uploadPath = WALKING_TOUR_FILE_PATH;
				elseif($this->input->post('uploadPdfModalType') == 'brochure')
					$uploadPath = ADULT_COURSE_BROCHURE;

				if($_FILES['file_name']['name'] != '')
					$uploadData = $this->image_upload->do_upload('./'.$uploadPath , 'file_name' , '' , '' , '' , 1);
				if($uploadData['errorFlag'] == 0)
					$this->admin_model->updatePdfManagement($uploadData['fileName']);
				else
					$fileUploadErrorMsg = $uploadData['errorMessage'];
				$data = array(
					'fileUploadErrorMsg' => strip_tags($fileUploadErrorMsg)
				);
				echo json_encode($data);
			}
		}

		//Function is used to get pdf managemnet data to show in the table
		function get_pdf_management()
		{
			if($this->input->post('juniorCentreId'))
			{
				$pdfManagemnetDetails = $this->admin_model->getPdfManagement($this->input->post('juniorCentreId') , $this->input->post('uploadPdfModalType'));
				$data = array(
					'pdfManagemnetDetails' => $pdfManagemnetDetails
				);
				echo json_encode($data);
			}
		}

		//This function is used to delete record for pdf managemnet from DB
		function delete_pdf_management()
		{
			if($this->input->post('id'))
			{
				$this->admin_model->deletePdfManagement();
				echo json_encode(array());
			}
		}

		//This function is used to check centre is duplicate or not through ajax call
		function duplicateCentreCheck()
		{
			if($this->input->post('centreId'))
			{
				$result = $this->admin_model->commonGetData('count(*) as total' , 'centre_id = '.$this->input->post('centreId') , TABLE_JUNIOR_CENTRE);
				$data['status'] = ($result['total'] == 0) ? 'ok' : 'error';
				echo json_encode($data);
			}
		}

		//Function is used to get date managemnet data to show in the table
		function get_date_management()
		{
			if($this->input->post('juniorCentreId'))
			{
				$dateManagemnetDetails = $this->admin_model->getdateManagement($this->input->post('juniorCentreId') , 'junior_centre');
				$data = array(
					'dateManagemnetDetails' => $dateManagemnetDetails
				);
				echo json_encode($data);
			}
		}

		//Function is used to add/edit data for dates management in junior centre module
		function add_dates_management()
		{
			if($this->input->post('flag'))
			{
				if($this->input->post('flag') == 'as')
					$this->admin_model->addDatesManagement();
				elseif($this->input->post('flag') == 'es')
				{
					$updateData = array(
						'date' => $this->input->post('date'),
						'overnight' => $this->input->post('overnight')
					);
					$this->admin_model->commonUpdate(TABLE_JUNIOR_CENTRE_DATES , 'junior_centre_dates_id = '.$this->input->post('datesId') , $updateData);
					//For weeks
					$this->admin_model->commonDelete(TABLE_JUNIOR_CENTRE_DATES_WEEK , 'junior_centre_dates_id = '.$this->input->post('datesId'));
					$weekArr = $this->input->post('week');
					if(!empty($weekArr))
					{
						foreach($weekArr as $value)
						{
							$updateData = array(
								'week' => $value,
								'junior_centre_dates_id' => $this->input->post('datesId')
							);
							$this->admin_model->commonAdd(TABLE_JUNIOR_CENTRE_DATES_WEEK , $updateData);
						}
					}
					//For programs
					$this->admin_model->commonDelete(TABLE_JUNIOR_CENTRE_DATES_PROGRAM , 'junior_centre_dates_id = '.$this->input->post('datesId'));
					$programArr = $this->input->post('program_id');
					if(!empty($programArr))
					{
						foreach($programArr as $value)
						{
							$updateData = array(
								'program_id' => $value,
								'junior_centre_dates_id' => $this->input->post('datesId')
							);
							$this->admin_model->commonAdd(TABLE_JUNIOR_CENTRE_DATES_PROGRAM , $updateData);
						}
					}
				}
			}
			echo json_encode(array());
		}

		//This function is used to delete record for date managemnet from DB
		function delete_dates_management()
		{
			if($this->input->post('id'))
			{
				$this->admin_model->deleteDatesManagement();
				echo json_encode(array());
			}
		}

		//This function is used to show junior centre photo gallery page
		function photo_gallery($juniorCentreId = NULL)
		{
			$imageError = '';
			$data['juniorCentreId'] = $juniorCentreId;
			$data['photoGalleryDetails'] = $this->admin_model->getPhotoGalleryDetails($juniorCentreId , 'junior_centre');
			$data['imageError'] = $imageError;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage photo gallery';
			$data['title'] = 'plus-ed.com | Manage photo gallery';
			$this->ltelayout->view('frontweb/photo_gallery' , $data);
		}

		//This function is used to add record in DB for photo gallery module
		function photo_gallery_add($juniorCentreId = NULL)
		{
			if($this->input->post('short_description'))
			{
				if($_FILES['photo']['name'] != '')
					$uploadData = $this->image_upload->do_upload('./'.PHOTO_GALLERY_IMAGE_PATH , 'photo' , UPLOAD_IMAGE_SIZE , PHOTO_GALLERY_WIDTH , PHOTO_GALLERY_HEIGHT);

				if($uploadData['errorFlag'] == 0)
				{
					$result = $this->admin_model->commonGetData('count(*) as total' , 'junior_centre_id = '.$juniorCentreId , TABLE_JUNIOR_CENTRE_PHOTO_GALLERY);
					$insertData = array(
						'short_description' => $this->input->post('short_description'),
						'description' => $this->input->post('description'),
						'photo' => $uploadData['fileName'],
						'sequence' => ($result['total'] + 1),
						'junior_centre_id' => $juniorCentreId
					);
					$this->admin_model->commonAdd(TABLE_JUNIOR_CENTRE_PHOTO_GALLERY , $insertData);
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'photo gallery' , $this->lang->line('add_success_message')));
					$this->_handleCropping($uploadData['fileName'] , 'photoGallery' , $juniorCentreId);
					redirect('/frontweb/photo_gallery/'.$juniorCentreId);
				}
				else
					$imageError = $uploadData['errorMessage'];
			}
		}

		//Function is used to delete record from dartabase related to photo gallery module
		function delete_photo_gallery($id = NULL , $juniorCentreId = NULL)
		{
			if($id)
			{
				$result = $this->admin_model->commonGetData('photo' , 'junior_centre_photo_gallery_id = '.$id , TABLE_JUNIOR_CENTRE_PHOTO_GALLERY);
				if(!empty($result))
				{
					if(file_exists('./'.PHOTO_GALLERY_IMAGE_PATH.$result['photo']))
						unlink('./'.PHOTO_GALLERY_IMAGE_PATH.$result['photo']);
					if(file_exists('./'.PHOTO_GALLERY_IMAGE_PATH.getThumbnailName($result['photo'])))
						unlink('./'.PHOTO_GALLERY_IMAGE_PATH.getThumbnailName($result['photo']));
				}
				$this->admin_model->commonDelete(TABLE_JUNIOR_CENTRE_PHOTO_GALLERY , 'junior_centre_photo_gallery_id = '.$id);
				$this->session->set_flashdata('success_message', str_replace('**module**' , 'Photo gallery' , $this->lang->line('delete_success_message')));
				redirect('/frontweb/junior_centre/photo_gallery/'.$juniorCentreId);
			}
		}

		//Function is used to get video gallery managemnet data to show in the table
		function get_video_gallery_management()
		{
			if($this->input->post('juniorCentreId'))
			{
				$videoManagemnetDetails = $this->admin_model->getVideoGalleryManagement($this->input->post('juniorCentreId') , 'junior_centre');
				$data = array(
					'videoManagemnetDetails' => $videoManagemnetDetails
				);
				echo json_encode($data);
			}
		}

		//This function is used to add video management record in database
		function add_video_gallery_management()
		{
			if($this->input->post('videoJuniorCentreId'))
			{
				if($_FILES['video_image']['name'] != '')
					$uploadData = $this->image_upload->do_upload('./'.VIDEO_GALLERY_IMAGE_PATH , 'video_image' , UPLOAD_IMAGE_SIZE , VIDEO_GALLERY_WIDTH , VIDEO_GALLERY_HEIGHT);
				$result = $this->admin_model->commonGetData('count(*) as total' , 'junior_centre_id = '.$this->input->post('videoJuniorCentreId') , TABLE_JUNIOR_CENTRE_VIDEO_GALLERY);
				$postData = array(
					'video_url' => $this->input->post('video_url'),
					'description' => $this->input->post('description'),
					'video_image' => $uploadData['fileName'],
					'sequence' => ($result['total'] + 1),
					'junior_centre_id' => $this->input->post('videoJuniorCentreId')
				);
				$this->admin_model->commonAdd(TABLE_JUNIOR_CENTRE_VIDEO_GALLERY , $postData);
				$this->_handleCropping($uploadData['fileName'] , 'videoGallery');
				//echo json_encode(array());
			}
		}

		//this function is used to delete record from database for video gallery management
		function delete_video_gallery_management()
		{
			if($this->input->post('id'))
			{
				$result = $this->admin_model->commonGetData('video_image' , 'junior_centre_video_gallery_id = '.$this->input->post('id') , TABLE_JUNIOR_CENTRE_VIDEO_GALLERY);
				if(!empty($result))
				{
					if(file_exists('./'.VIDEO_GALLERY_IMAGE_PATH.$result['video_image']))
						unlink('./'.VIDEO_GALLERY_IMAGE_PATH.$result['video_image']);
					if(file_exists('./'.VIDEO_GALLERY_IMAGE_PATH.getThumbnailName($result['video_image'])))
						unlink('./'.VIDEO_GALLERY_IMAGE_PATH.getThumbnailName($result['video_image']));
				}
				$this->admin_model->commonDelete(TABLE_JUNIOR_CENTRE_VIDEO_GALLERY , 'junior_centre_video_gallery_id = '.$this->input->post('id'));
			}
			echo json_encode(array());
		}

		//this function is used to get the details of international mix from database and load in the datatable
		function get_international_mix_management()
		{
			if($this->input->post('juniorCentreId'))
			{
				$internationalMixManagemnetDetails = $this->admin_model->getInternationalMixManagement($this->input->post('juniorCentreId') , 'junior_centre');
				$data = array(
					'internationalMixManagemnetDetails' => $internationalMixManagemnetDetails
				);
				echo json_encode($data);
			}
		}

		//This function is used to add international mix management record in database
		function add_international_mix_management()
		{
			if($this->input->post('internationalMixJuniorCentreId'))
			{
				$postData = array(
					'country_name' => $this->input->post('country_name'),
					'percentage' => $this->input->post('percentage').'%',
					'color_code' => $this->input->post('color_code'),
					'junior_centre_id' => $this->input->post('internationalMixJuniorCentreId')
				);
				$this->admin_model->commonAdd(TABLE_JUNIOR_CENTRE_INTERNATIONAL_MIX , $postData);
				echo json_encode(array());
			}
		}

		//this function is used to delete record from database for video gallery management
		function delete_international_mix_management()
		{
			if($this->input->post('id'))
				$this->admin_model->commonDelete(TABLE_JUNIOR_CENTRE_INTERNATIONAL_MIX , 'junior_centre_international_mix_id = '.$this->input->post('id'));
			echo json_encode(array());
		}

		//This function is used to check country is duplicate or not through ajax call(for international mix management)
		function duplicateCountryCheck()
		{
			if($this->input->post('country') && $this->input->post('id'))
			{
				$result = $this->admin_model->commonGetData('count(*) as total' , "country_name = '".$this->input->post('country')."' AND junior_centre_id = '".$this->input->post('id')."'" , TABLE_JUNIOR_CENTRE_INTERNATIONAL_MIX);
				$data['status'] = ($result['total'] == 0) ? 'ok' : 'error';
				echo json_encode($data);
			}
		}

		//Function is used to update sequence for photo and video gallery
		function update_sequence()
		{
			if($this->input->post('id'))
			{
				if($this->input->post('module') == 'photo_gallery')
					$this->admin_model->commonUpdate(TABLE_JUNIOR_CENTRE_PHOTO_GALLERY , 'junior_centre_photo_gallery_id = '.$this->input->post('id') , array('sequence' => $this->input->post('sequence')));
				elseif($this->input->post('module') == 'video_gallery')
					$this->admin_model->commonUpdate(TABLE_JUNIOR_CENTRE_VIDEO_GALLERY , 'junior_centre_video_gallery_id = '.$this->input->post('id') , array('sequence' => $this->input->post('sequence')));
			}
			echo json_encode(array());
		}

		//This function is used to add extra sequence content in database
		function add_extra_section_content()
		{
			if($this->input->post('juniorCentreId') != '')
			{
				$fileUploadErrorMsg = '';
				if($_FILES['file_name']['name'] != '')
					$uploadData = $this->image_upload->do_upload('./'.EXTRA_SECTION_FILE_PATH , 'file_name' , '' , '' , '' , 1);
				if($uploadData['errorFlag'] == 0)
				{
					$insertData = array(
						'centre_id' => $this->input->post('juniorCentreId'),
						'extra_section_id' => $this->input->post('extra_section_id'),
						'description' => $this->input->post('description'),
						'file_name' => $uploadData['fileName']
					);
					$this->admin_model->commonAdd(TABLE_PLUS_EXTRA_SECTION_CONTENT , $insertData);
				}
				else
					$fileUploadErrorMsg = $uploadData['errorMessage'];
				$data = array(
					'fileUploadErrorMsg' => strip_tags($fileUploadErrorMsg)
				);
				echo json_encode($data);
			}
		}

		//This function is used to get the extra section content list table to show in the modal
		function get_extra_section_content()
		{
			if($this->input->post('juniorCentreId'))
			{
				$extraSectionDetails = $this->admin_model->getExtraSectionContent($this->input->post('juniorCentreId') , 1);
				$data = array(
					'extraSectionDetails' => $extraSectionDetails
				);
				echo json_encode($data);
			}
		}

		//This function is used to get the dates details to show in the edit page
		function get_edit_dates()
		{
			if($this->input->post('dates_id'))
			{
				$data = $this->admin_model->commonGetData('date , overnight' , 'junior_centre_dates_id = '.$this->input->post('dates_id') , TABLE_JUNIOR_CENTRE_DATES , 1);
				$weekData = $this->admin_model->commonGetData('group_concat(week) as week' , 'junior_centre_dates_id = '.$this->input->post('dates_id') , TABLE_JUNIOR_CENTRE_DATES_WEEK , 1);
				$programData = $this->admin_model->commonGetData('group_concat(program_id) as program' , 'junior_centre_dates_id = '.$this->input->post('dates_id') , TABLE_JUNIOR_CENTRE_DATES_PROGRAM , 1);
				$data['week'] = $weekData['week'];
				$data['program'] = $programData['program'];
				echo json_encode($data);
			}
		}

		//This function is used to delete record from DB and delete the file from deirectory for extra section content
		function delete_extra_section_content()
		{
			if($this->input->post('id'))
			{
				$fileDetails = $this->admin_model->commonGetData('file_name' , 'extra_section_content_id = '.$this->input->post('id') , TABLE_PLUS_EXTRA_SECTION_CONTENT , 1);
				if($fileDetails['file_name'] != '')
				{
					if(file_exists('./'.EXTRA_SECTION_FILE_PATH.$fileDetails['file_name']))
						unlink('./'.EXTRA_SECTION_FILE_PATH.$fileDetails['file_name']);
				}
				$this->admin_model->commonDelete(TABLE_PLUS_EXTRA_SECTION_CONTENT , 'extra_section_content_id = '.$this->input->post('id'));
				echo json_encode(array());
			}
		}

		/****************Image Cropping functionality Start******************/
		public function _handleCropping($fileName = NULL , $flag = NULL , $juniorCentreId = NULL)
		{
			$this->cropInit($fileName , $flag , $juniorCentreId);
			$this->cropping->image();
			exit();
		}

		public function process($action = NULL)
		{
			$this->cropInit();
			$this->cropping->process($action);
		}

		public function cropInit($file_name = NULL , $flag = NULL , $juniorCentreId = NULL)
		{
			if($flag == 'photoGallery')
			{
				$path = PHOTO_GALLERY_IMAGE_PATH;
				$width = PHOTO_GALLERY_WIDTH;
				$height = PHOTO_GALLERY_HEIGHT;
				$thumbWidth = PHOTO_GALLERY_THUMB_WIDTH;
				$thumbHeight = PHOTO_GALLERY_THUMB_HEIGHT;
				$redirectTo = 'frontweb/junior_centre/photo_gallery/'.$juniorCentreId;
			}
			elseif($flag == 'videoGallery')
			{
				$path = VIDEO_GALLERY_IMAGE_PATH;
				$width = VIDEO_GALLERY_WIDTH;
				$height = VIDEO_GALLERY_HEIGHT;
				$thumbWidth = VIDEO_GALLERY_THUMB_WIDTH;
				$thumbHeight = VIDEO_GALLERY_THUMB_HEIGHT;
				$redirectTo = 'frontweb/junior_centre';
			}
			else
			{
				$path = JUNIOR_CENTRE_IMAGE_PATH;
				$width = JUNIOR_CENTRE_WIDTH;
				$height = JUNIOR_CENTRE_HEIGHT;
				$thumbWidth = JUNIOR_CENTRE_THUMB_WIDTH;
				$thumbHeight = JUNIOR_CENTRE_THUMB_HEIGHT;
				$redirectTo = 'frontweb/junior_centre';
			}
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
					'redirectTo' => $redirectTo,
					'formCallbackAction' => 'frontweb/junior_centre/process'
				);
				$this->session->set_userdata("cropData" , $param);
			}
			$this->load->library("cropping" , $param);
		}
		/******************Image Cropping functionality End*********************/
	}
?>