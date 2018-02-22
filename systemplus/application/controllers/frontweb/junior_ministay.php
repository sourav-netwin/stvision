<?php
	class Junior_ministay extends Controller
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

		//This function is used to show the listing page for the junior mini stay program module
		public function index()
		{
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage junior mini stay';
			$data['title'] = 'plus-ed.com | Manage junior mini stay';
			$this->ltelayout->view('frontweb/junior_ministay_list' , $data);
		}

		//This function is used to get junior mini stay program details and show in the datatable
		function get_junior_ministay()
		{
			if($this->input->post('draw'))
			{
				$searchArr = $this->input->post('search');
				$orderArr = $this->input->post('order');
				//For now , only english
				$languageId = 1;
				$responseArr = array();
				$programData = $this->admin_model->getjuniorMiniStayDetails($this->input->post('start') , $this->input->post('length') , $searchArr['value'] , $orderArr[0]['column'] , $orderArr[0]['dir'] , $languageId);

				$responseArr['draw'] = $this->input->post('draw');
				$responseArr['recordsTotal'] = $programData['count_all'];
				$responseArr['recordsFiltered'] = $programData['count_all'];
				$responseArr['data'] = $programData['data'];
				echo json_encode($responseArr);
			}
		}

		//This function is used to update the status of the junior mini stay program
		function update_status()
		{
			if($this->input->post('junior_ministay_id'))
			{
				$data = array(
					'junior_ministay_status' => ($this->input->post('junior_ministay_status') == 1) ? 0 : 1
				);
				$this->admin_model->commonUpdate(TABLE_JUNIOR_MINISTAY , 'junior_ministay_id = '.$this->input->post('junior_ministay_id') , $data);
				echo TRUE;
			}
		}

		//This function is used to manage the add/edit functionality for the junior mini stay program
		function add_edit($id = NULL)
		{
			$imageError = '';
			$post = array();
			$title = ($id != '') ? 'Edit' : 'Add'.' junior mini stay';

			if($this->input->post('flag'))
			{
				$file_name = $this->input->post('oldImg');
				if($this->input->post('imageChangeFlag') == 2)
				{
					$uploadData = $this->image_upload->do_upload('./'.JUNIOR_MINISTAY_IMAGE_PATH , 'centre_banner' , UPLOAD_IMAGE_SIZE , JUNIOR_MINISTAY_WIDTH , JUNIOR_MINISTAY_HEIGHT);
					if($uploadData['errorFlag'] == 0)
					{
						//Delete old file for edit
						if($this->input->post('flag') == 'es')
						{
							if(file_exists('./'.JUNIOR_MINISTAY_IMAGE_PATH.$file_name))
								unlink('./'.JUNIOR_MINISTAY_IMAGE_PATH.$file_name);
							if(file_exists('./'.JUNIOR_MINISTAY_IMAGE_PATH.getThumbnailName($file_name)))
								unlink('./'.JUNIOR_MINISTAY_IMAGE_PATH.getThumbnailName($file_name));
						}
						$file_name = $uploadData['fileName'];
					}
				}
				$insertData = array(
					'centre_banner' => $file_name,
					'accommodation' => $this->input->post('accommodation'),
					'course' => $this->input->post('course')
				);
				if($this->input->post('accomodation_show_flag') != '')
					$insertData['accomodation_show_flag'] = $this->input->post('accomodation_show_flag');
				if($this->input->post('plus_team_show_flag') != '')
					$insertData['plus_team_show_flag'] = $this->input->post('plus_team_show_flag');
				if($this->input->post('course_show_flag') != '')
					$insertData['course_show_flag'] = $this->input->post('course_show_flag');
				if($this->input->post('flag') == 'as')
				{
					$insertData['centre_id'] = $this->input->post('centre_id');
					$lastId = $this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY , $insertData);

					//Add multiple programs
					$centreProgram = $this->input->post('centre_program');
					if(!empty($centreProgram))
					{
						foreach($this->input->post('centre_program') as $value)
						{
							$programData = array(
								'program_id' => $value,
								'program_details' => $this->input->post('program_'.$value),
								'junior_ministay_id' => $lastId
							);
							$this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_PROGRAM , $programData);
						}
					}

					//Add Multiple sections
					$centreSection = $this->input->post('centre_section');
					if(!empty($centreSection))
					{
						foreach($this->input->post('centre_section') as $value)
						{
							$sectionData = array(
								'static_program_id' => $value,
								'junior_ministay_id' => $lastId
							);
							$this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_SECTION , $sectionData);
						}
					}

					$this->session->set_flashdata('success_message', str_replace('**module**' , 'Junior mini stay' , $this->lang->line('add_success_message')));
				}
				elseif($this->input->post('flag') == 'es')
				{
					$this->admin_model->commonUpdate(TABLE_JUNIOR_MINISTAY , 'junior_ministay_id = '.$id , $insertData);

					//Delete old section and Add Multiple sections
					$centreSection = $this->input->post('centre_section');
					if(!empty($centreSection))
					{
						$this->admin_model->commonDelete(TABLE_JUNIOR_MINISTAY_SECTION , 'junior_ministay_id = '.$id);
						foreach($this->input->post('centre_section') as $value)
						{
							$sectionData = array(
								'static_program_id' => $value,
								'junior_ministay_id' => $id
							);
							$this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_SECTION , $sectionData);
						}
					}

					//Delete old program and Add multiple programs
					$centreProgram = $this->input->post('centre_program');
					if(!empty($centreProgram))
					{
						$this->admin_model->commonDelete(TABLE_JUNIOR_MINISTAY_PROGRAM , 'junior_ministay_id = '.$id);
						foreach($this->input->post('centre_program') as $value)
						{
							$programData = array(
								'program_id' => $value,
								'program_details' => $this->input->post('program_'.$value),
								'junior_ministay_id' => $id
							);
							$this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_PROGRAM , $programData);
						}
					}

					$this->session->set_flashdata('success_message', str_replace('**module**' , 'Junior mini stay' , $this->lang->line('edit_success_message')));
				}
				if($this->input->post('imageChangeFlag') == 2)
					$this->_handleCropping($file_name , 'miniStay');
				redirect('/frontweb/junior_ministay');
			}

			if($id != '')
			{
				$post = $this->admin_model->commonGetData('centre_id , centre_banner , accomodation_show_flag , plus_team_show_flag , course_show_flag , accommodation , course' , 'junior_ministay_id = '.$id , TABLE_JUNIOR_MINISTAY);
				$post['programDetails'] = $this->db->select('program_id , program_details , program_course_name')
											->join(TABLE_PROGRAM_COURSE , 'program_course_id = program_id' , 'left')
											->where('junior_ministay_id' , $id)
											->get(TABLE_JUNIOR_MINISTAY_PROGRAM)->result_array();
				if(!empty($post['programDetails']))
				{
					foreach($post['programDetails'] as $value)
						$centre_program[] = $value['program_id'];
				}
				else
					$centre_program = array();
				$post['centre_program'] = $centre_program;
				$post['centre_section'] = $this->admin_model->commonGetData('static_program_id' , 'junior_ministay_id = '.$id , TABLE_JUNIOR_MINISTAY_SECTION , 2);

				if(!empty($post['centre_section']))
				{
					foreach($post['centre_section'] as $value)
						$centre_section[] = $value['static_program_id'];
				}
				else
					$centre_section = array();

				$post['centre_section'] = $centre_section;
				$data['post'] = $post;
			}
			$data['imageError'] = $imageError;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = $title;
			$data['title'] = 'plus-ed.com | '.$title;
			$data['actionUrl'] = 'frontweb/junior_ministay/add_edit/'.$id;
			$data['id'] = $id;
			$this->ltelayout->view('frontweb/junior_ministay_add_edit' , $data);
		}

		//This function is used to check centre is duplicate or not through ajax call
		function duplicateCentreCheck()
		{
			if($this->input->post('centreId'))
			{
				$result = $this->admin_model->commonGetData('count(*) as total' , 'centre_id = '.$this->input->post('centreId') , TABLE_JUNIOR_MINISTAY);
				$data['status'] = ($result['total'] == 0) ? 'ok' : 'error';
				echo json_encode($data);
			}
		}

		//Function is used to delete record from DB
		function delete($id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);
			$this->admin_model->commonUpdate(TABLE_JUNIOR_MINISTAY , 'junior_ministay_id = '.$id , $updateData);
			$this->session->set_flashdata('success_message', str_replace('**module**' , 'Junior mini stay' , $this->lang->line('delete_success_message')));
			redirect('/frontweb/junior_ministay');
		}

		//This function is used to show mini stay photo gallery details and also add values in DB
		function photo_gallery($juniorMiniStayId = NULL)
		{
			$imageError = '';
			if($this->input->post('flag') == 'as')
			{
				if($_FILES['photo']['name'] != '')
					$uploadData = $this->image_upload->do_upload('./'.MINISTAY_PHOTO_GALLERY_IMAGE_PATH , 'photo' , UPLOAD_IMAGE_SIZE , MINISTAY_PHOTO_GALLERY_WIDTH , MINISTAY_PHOTO_GALLERY_HEIGHT);

				if($uploadData['errorFlag'] == 0)
				{
					$result = $this->admin_model->commonGetData('count(*) as total' , 'junior_ministay_id = '.$juniorMiniStayId , TABLE_JUNIOR_MINISTAY_PHOTOGALLERY);
					$insertData = array(
						'short_description' => $this->input->post('short_description'),
						'description' => $this->input->post('description'),
						'photo' => $uploadData['fileName'],
						'sequence' => ($result['total'] + 1),
						'junior_ministay_id' => $juniorMiniStayId
					);
					$this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_PHOTOGALLERY , $insertData);
					$this->session->set_flashdata('success_message', str_replace('**module**' , 'photo gallery' , $this->lang->line('add_success_message')));
					$this->_handleCropping($uploadData['fileName'] , 'photoGallery' , $juniorMiniStayId);
				}
				else
					$imageError = $uploadData['errorMessage'];
			}

			$data['juniorMiniStayId'] = $juniorMiniStayId;
			$data['photoGalleryDetails'] = $this->admin_model->getPhotoGalleryDetails($juniorMiniStayId , 'junior_ministay');
			$data['imageError'] = $imageError;
			$data['breadcrumb1'] = 'Website managements';
			$data['pageHeader'] = $data['breadcrumb2'] = 'Manage photo gallery';
			$data['title'] = 'plus-ed.com | Manage photo gallery';
			$this->ltelayout->view('frontweb/ministay_photo_gallery' , $data);
		}

		//Function is used to update sequence for photo and video gallery
		function update_sequence()
		{
			if($this->input->post('id'))
			{
				if($this->input->post('module') == 'photo_gallery')
					$this->admin_model->commonUpdate(TABLE_JUNIOR_MINISTAY_PHOTOGALLERY , 'junior_ministay_photo_gallery_id = '.$this->input->post('id') , array('sequence' => $this->input->post('sequence')));
				elseif($this->input->post('module') == 'video_gallery')
					$this->admin_model->commonUpdate(TABLE_JUNIOR_MINISTAY_VIDEO_GALLERY , 'junior_ministay_video_gallery_id = '.$this->input->post('id') , array('sequence' => $this->input->post('sequence')));
			}
			echo json_encode(array());
		}

		//Function is used to delete record from dartabase related to photo gallery module
		function delete_photo_gallery($id = NULL , $juniorMiniStayId = NULL)
		{
			if($id)
			{
				$result = $this->admin_model->commonGetData('photo' , 'junior_ministay_photo_gallery_id = '.$id , TABLE_JUNIOR_MINISTAY_PHOTOGALLERY);
				if(!empty($result))
				{
					if(file_exists('./'.MINISTAY_PHOTO_GALLERY_IMAGE_PATH.$result['photo']))
						unlink('./'.MINISTAY_PHOTO_GALLERY_IMAGE_PATH.$result['photo']);
					if(file_exists('./'.MINISTAY_PHOTO_GALLERY_IMAGE_PATH.getThumbnailName($result['photo'])))
						unlink('./'.MINISTAY_PHOTO_GALLERY_IMAGE_PATH.getThumbnailName($result['photo']));
				}
				$this->admin_model->commonDelete(TABLE_JUNIOR_MINISTAY_PHOTOGALLERY , 'junior_ministay_photo_gallery_id = '.$id);
				$this->session->set_flashdata('success_message', str_replace('**module**' , 'Photo gallery' , $this->lang->line('delete_success_message')));
				redirect('/frontweb/junior_ministay/photo_gallery/'.$juniorMiniStayId);
			}
		}

		//Function is used to get video gallery managemnet data to show in the table
		function get_video_gallery_management()
		{
			if($this->input->post('juniorMiniStayId'))
			{
				$videoManagemnetDetails = $this->admin_model->getVideoGalleryManagement($this->input->post('juniorMiniStayId') , 'junior_ministay');
				$data = array(
					'videoManagemnetDetails' => $videoManagemnetDetails
				);
				echo json_encode($data);
			}
		}

		//This function is used to add video management record in database
		function add_video_gallery_management()
		{
			if($this->input->post('videoJuniorMiniStayId'))
			{
				if($_FILES['video_image']['name'] != '')
					$uploadData = $this->image_upload->do_upload('./'.MINISTAY_VIDEO_GALLERY_IMAGE_PATH , 'video_image' , UPLOAD_IMAGE_SIZE , MINISTAY_VIDEO_GALLERY_WIDTH , MINISTAY_VIDEO_GALLERY_HEIGHT);
				$result = $this->admin_model->commonGetData('count(*) as total' , 'junior_ministay_id = '.$this->input->post('videoJuniorMiniStayId') , TABLE_JUNIOR_MINISTAY_VIDEO_GALLERY);
				$postData = array(
					'video_url' => $this->input->post('video_url'),
					'description' => $this->input->post('description'),
					'video_image' => $uploadData['fileName'],
					'sequence' => ($result['total'] + 1),
					'junior_ministay_id' => $this->input->post('videoJuniorMiniStayId')
				);
				$this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_VIDEO_GALLERY , $postData);
				$this->_handleCropping($uploadData['fileName'] , 'videoGallery');
				//echo json_encode(array());
			}
		}

		//this function is used to delete record from database for video gallery management
		function delete_video_gallery_management()
		{
			if($this->input->post('id'))
			{
				$result = $this->admin_model->commonGetData('video_image' , 'junior_ministay_video_gallery_id = '.$this->input->post('id') , TABLE_JUNIOR_MINISTAY_VIDEO_GALLERY);
				if(!empty($result))
				{
					if(file_exists('./'.MINISTAY_VIDEO_GALLERY_IMAGE_PATH.$result['video_image']))
						unlink('./'.MINISTAY_VIDEO_GALLERY_IMAGE_PATH.$result['video_image']);
					if(file_exists('./'.MINISTAY_VIDEO_GALLERY_IMAGE_PATH.getThumbnailName($result['video_image'])))
						unlink('./'.MINISTAY_VIDEO_GALLERY_IMAGE_PATH.getThumbnailName($result['video_image']));
				}
				$this->admin_model->commonDelete(TABLE_JUNIOR_MINISTAY_VIDEO_GALLERY , 'junior_ministay_video_gallery_id = '.$this->input->post('id'));
			}
			echo json_encode(array());
		}

		//Function is used to get pdf managemnet data to show in the table
		function get_pdf_management()
		{
			if($this->input->post('juniorMiniStayId'))
			{
				$pdfManagemnetDetails = $this->admin_model->getMiniStayPdfManagement($this->input->post('juniorMiniStayId') , $this->input->post('uploadPdfModalType'));
				$data = array(
					'pdfManagemnetDetails' => $pdfManagemnetDetails
				);
				echo json_encode($data);
			}
		}

		//Function is used to update data for all upload pdf management in junior centre module
		function upload_pdf_management()
		{
			if($this->input->post('juniorMiniStayId'))
			{
				$fileUploadErrorMsg = '';
				if($this->input->post('uploadPdfModalType') == 'addon')
					$uploadPath = MINISTAY_ADDON_FILE_PATH;
				elseif($this->input->post('uploadPdfModalType') == 'factsheet')
					$uploadPath = MINISTAY_FACTSHEET_FILE_PATH;
				elseif($this->input->post('uploadPdfModalType') == 'activity_program')
					$uploadPath = MINISTAY_ACTIVITY_PROGRAM_FILE_PATH;
				elseif($this->input->post('uploadPdfModalType') == 'menu')
					$uploadPath = MINISTAY_MENU_FILE_PATH;
				elseif($this->input->post('uploadPdfModalType') == 'walking_tour')
					$uploadPath = MINISTAY_WALKING_TOUR_FILE_PATH;

				if($_FILES['file_name']['name'] != '')
					$uploadData = $this->image_upload->do_upload('./'.$uploadPath , 'file_name' , '' , '' , '' , 1);
				if($uploadData['errorFlag'] == 0)
					$this->admin_model->addJuniorMiniStayPdfManagement($uploadData['fileName']);
				else
					$fileUploadErrorMsg = $uploadData['errorMessage'];
				$data = array(
					'fileUploadErrorMsg' => strip_tags($fileUploadErrorMsg)
				);
				echo json_encode($data);
			}
		}

		//This function is used to delete record for pdf managemnet from DB
		function delete_pdf_management()
		{
			if($this->input->post('id'))
			{
				$this->admin_model->deleteMiniStayPdfManagement();
				echo json_encode(array());
			}
		}

		//Function is used to get date managemnet data to show in the table for junior mini stay courses
		function get_date_management()
		{
			if($this->input->post('juniorMiniStayId'))
			{
				$dateManagemnetDetails = $this->admin_model->getdateManagement($this->input->post('juniorMiniStayId') , 'junior_ministay');
				$data = array(
					'dateManagemnetDetails' => $dateManagemnetDetails
				);
				echo json_encode($data);
			}
		}

		//Function is used to add data for dates management in junior centre module
		function add_dates_management()
		{
			if($this->input->post('flag'))
			{
				if($this->input->post('flag') == 'as')
				{
					$insertData = array(
						'date' => $this->input->post('date'),
						'overnight' => $this->input->post('overnight'),
						'junior_ministay_id' => $this->input->post('dateJuniorMiniStayId')
					);
					$insertId = $this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_DATES , $insertData);

					//For week section
					$weekArr = $this->input->post('week');
					if(!empty($weekArr))
					{
						foreach($this->input->post('week') as $value)
						{
							$insertData = array(
								'week' => $value,
								'junior_ministay_dates_id' => $insertId
							);
							$this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_DATES_WEEK , $insertData);
						}
					}

					//For program section
					$programArr = $this->input->post('program_id');
					if(!empty($programArr))
					{
						foreach($this->input->post('program_id') as $value)
						{
							$insertData = array(
								'program_id' => $value,
								'junior_ministay_dates_id' => $insertId
							);
							$this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_DATES_PROGRAM , $insertData);
						}
					}
				}
				elseif($this->input->post('flag') == 'es')
				{
					$updateData = array(
						'date' => $this->input->post('date'),
						'overnight' => $this->input->post('overnight')
					);
					$this->admin_model->commonUpdate(TABLE_JUNIOR_MINISTAY_DATES , 'junior_ministay_dates_id = '.$this->input->post('datesId') , $updateData);
					//For weeks
					$this->admin_model->commonDelete(TABLE_JUNIOR_MINISTAY_DATES_WEEK , 'junior_ministay_dates_id = '.$this->input->post('datesId'));
					$weekArr = $this->input->post('week');
					if(!empty($weekArr))
					{
						foreach($weekArr as $value)
						{
							$updateData = array(
								'week' => $value,
								'junior_ministay_dates_id' => $this->input->post('datesId')
							);
							$this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_DATES_WEEK , $updateData);
						}
					}
					//For programs
					$this->admin_model->commonDelete(TABLE_JUNIOR_MINISTAY_DATES_PROGRAM , 'junior_ministay_dates_id = '.$this->input->post('datesId'));
					$programArr = $this->input->post('program_id');
					if(!empty($programArr))
					{
						foreach($programArr as $value)
						{
							$updateData = array(
								'program_id' => $value,
								'junior_ministay_dates_id' => $this->input->post('datesId')
							);
							$this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_DATES_PROGRAM , $updateData);
						}
					}
				}
			}
			echo json_encode(array());
		}

		//This function is used to delete record for date managemnet from DB for junior mini stay course
		function delete_dates_management()
		{
			if($this->input->post('id'))
			{
				$this->admin_model->commonDelete(TABLE_JUNIOR_MINISTAY_DATES , 'junior_ministay_dates_id = '.$this->input->post('id'));
				$this->admin_model->commonDelete(TABLE_JUNIOR_MINISTAY_DATES_PROGRAM , 'junior_ministay_dates_id = '.$this->input->post('id'));
				$this->admin_model->commonDelete(TABLE_JUNIOR_MINISTAY_DATES_WEEK , 'junior_ministay_dates_id = '.$this->input->post('id'));
				echo json_encode(array());
			}
		}

		//this function is used to get the details of international mix from database and load in the datatable
		function get_international_mix_management()
		{
			if($this->input->post('juniorMiniStayId'))
			{
				$internationalMixManagemnetDetails = $this->admin_model->getInternationalMixManagement($this->input->post('juniorMiniStayId') , 'junior_ministay');
				$data = array(
					'internationalMixManagemnetDetails' => $internationalMixManagemnetDetails
				);
				echo json_encode($data);
			}
		}

		//This function is used to check country is duplicate or not through ajax call(for international mix management)
		function duplicateCountryCheck()
		{
			if($this->input->post('country') && $this->input->post('id'))
			{
				$result = $this->admin_model->commonGetData('count(*) as total' , "country_name = '".$this->input->post('country')."' AND junior_ministay_id = '".$this->input->post('id')."'" , TABLE_JUNIOR_MINISTAY_INTERNATIONAL_MIX);
				$data['status'] = ($result['total'] == 0) ? 'ok' : 'error';
				echo json_encode($data);
			}
		}

		//This function is used to add international mix management record in database
		function add_international_mix_management()
		{
			if($this->input->post('internationalMixJuniorMiniStayId'))
			{
				$postData = array(
					'country_name' => $this->input->post('country_name'),
					'percentage' => $this->input->post('percentage').'%',
					'color_code' => $this->input->post('color_code'),
					'junior_ministay_id' => $this->input->post('internationalMixJuniorMiniStayId')
				);
				$this->admin_model->commonAdd(TABLE_JUNIOR_MINISTAY_INTERNATIONAL_MIX , $postData);
				echo json_encode(array());
			}
		}

		//This function is used to delete record from database for video gallery management
		function delete_international_mix_management()
		{
			if($this->input->post('id'))
				$this->admin_model->commonDelete(TABLE_JUNIOR_MINISTAY_INTERNATIONAL_MIX , 'junior_ministay_international_mix_id = '.$this->input->post('id'));
			echo json_encode(array());
		}

		//This function is used to add extra sequence content in database
		function add_extra_section_content()
		{
			if($this->input->post('juniorMinistayId') != '')
			{
				$fileUploadErrorMsg = '';
				if($_FILES['file_name']['name'] != '')
					$uploadData = $this->image_upload->do_upload('./'.EXTRA_SECTION_FILE_PATH , 'file_name' , '' , '' , '' , 1);
				if($uploadData['errorFlag'] == 0)
				{
					$insertData = array(
						'centre_id' => $this->input->post('juniorMinistayId'),
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
			if($this->input->post('juniorMinistayId'))
			{
				$extraSectionDetails = $this->admin_model->getExtraSectionContent($this->input->post('juniorMinistayId') , 2);
				$data = array(
					'extraSectionDetails' => $extraSectionDetails
				);
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

		//This function is used to get the dates details to show in the edit page
		function get_edit_dates()
		{
			if($this->input->post('dates_id'))
			{
				$data = $this->admin_model->commonGetData('date , overnight' , 'junior_ministay_dates_id = '.$this->input->post('dates_id') , TABLE_JUNIOR_MINISTAY_DATES , 1);
				$weekData = $this->admin_model->commonGetData('group_concat(week) as week' , 'junior_ministay_dates_id = '.$this->input->post('dates_id') , TABLE_JUNIOR_MINISTAY_DATES_WEEK , 1);
				$programData = $this->admin_model->commonGetData('group_concat(program_id) as program' , 'junior_ministay_dates_id = '.$this->input->post('dates_id') , TABLE_JUNIOR_MINISTAY_DATES_PROGRAM , 1);
				$data['week'] = $weekData['week'];
				$data['program'] = $programData['program'];
				echo json_encode($data);
			}
		}

		/****************Image Cropping functionality Start******************/
		public function _handleCropping($fileName = NULL , $type = NULL , $id = NULL)
		{
			$this->cropInit($fileName , $type , $id);
			$this->cropping->image();
			exit();
		}

		public function process($action = NULL)
		{
			$this->cropInit();
			$this->cropping->process($action);
		}

		public function cropInit($file_name = NULL , $type = NULL , $id = NULL)
		{
			if($type == 'miniStay')
			{
				$path = JUNIOR_MINISTAY_IMAGE_PATH;
				$width = JUNIOR_MINISTAY_WIDTH;
				$height = JUNIOR_MINISTAY_HEIGHT;
				$thumbWidth = JUNIOR_MINISTAY_THUMB_WIDTH;
				$thumbHeight = JUNIOR_MINISTAY_THUMB_HEIGHT;
				$redirectTo = '/frontweb/junior_ministay';
			}
			elseif($type == 'photoGallery')
			{
				$path = MINISTAY_PHOTO_GALLERY_IMAGE_PATH;
				$width = MINISTAY_PHOTO_GALLERY_WIDTH;
				$height = MINISTAY_PHOTO_GALLERY_HEIGHT;
				$thumbWidth = MINISTAY_PHOTO_GALLERY_THUMB_WIDTH;
				$thumbHeight = MINISTAY_PHOTO_GALLERY_THUMB_HEIGHT;
				$redirectTo = '/frontweb/junior_ministay/photo_gallery/'.$id;
			}
			elseif($type == 'videoGallery')
			{
				$path = MINISTAY_VIDEO_GALLERY_IMAGE_PATH;
				$width = MINISTAY_VIDEO_GALLERY_WIDTH;
				$height = MINISTAY_VIDEO_GALLERY_HEIGHT;
				$thumbWidth = MINISTAY_VIDEO_GALLERY_THUMB_WIDTH;
				$thumbHeight = MINISTAY_VIDEO_GALLERY_THUMB_HEIGHT;
				$redirectTo = 'frontweb/junior_ministay';
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
					'formCallbackAction' => 'frontweb/junior_ministay/process'
				);
				$this->session->set_userdata("cropData" , $param);
			}
			$this->load->library("cropping" , $param);
		}
		/******************Image Cropping functionality End*********************/
	}
