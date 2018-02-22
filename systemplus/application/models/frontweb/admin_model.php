<?php
	class Admin_model extends Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		//This function is used to get program details from DB and show through datatable
		function getProgramDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL , $languageId = 1)
		{
			$resultData = array();
			$colomnArr = array('a.program_id' , 'a.program_image' , 'b.program_title' , 'b.program_short_description' , 'a.program_status');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_PROGRAM . ' a');
			$this->db->join(TABLE_PROGRAM_LANGUAGE . ' b' , 'a.program_id = b.program_id AND b.language_id = '.$languageId , 'left');

			//For checking soft deleted record
			$this->db->where('a.delete_flag' , 0);

			//For searching
			if($search_string != '')
				$this->db->where("(".$colomnArr[2]." LIKE '%".$search_string."%' OR ".$colomnArr[3]." LIKE '%".$search_string."%')");

			//For Ordering
			if($order_column != '' && $order_dir != '')
				$this->db->order_by($colomnArr[$order_column] , $order_dir);

			//For limit
			if($start != '' && $length != '')
				$this->db->limit($length , $start);

			$result = $this->db->get()->result_array();

			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $value)
				{
					$actionStr ="<div class='btn-group custom-btn-group'>";
					$actionStr .= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().'index.php/frontweb/program/add_edit/'.$value['program_id'].'" data-toggle="tooltip" data-original-title="Edit Program Banner"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a class="btn btn-xs btn-danger btn-wd-24" href="program/delete/'.$value['program_id'].'" onclick="return confirm_delete()" data-toggle="tooltip" data-original-title="Delete Program Banner"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>';
					$statusClass = ($value['program_status'] == 1) ? 'fa-check-square-o' : 'fa-square-o';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Change Status for Program Banner" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon"><span><i class="fa '.$statusClass.'" aria-hidden="true" data-toggle="modal" data-target="#juniorCentreStatus" data-status_type = '.$value['program_status'].' data-program_id = '.$value['program_id'].' ></i></span></a>';
					$actionStr .="</div>";

					$resultData[] = array(
						0 => $siNo++,
						1 => "<img src = '".base_url().PROGRAM_IMAGE_PATH.getThumbnailName($value['program_image'])."' width = 180 height = 50 />",
						2 => $value['program_title'],
						3 => $value['program_short_description'],
						4 => $actionStr
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_PROGRAM)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//This function is used to get data from DB to show in edit page
		function getEditProgramData($id = NULL , $languageId = 1)
		{
			$this->db->select('a.program_id , a.program_image , b.program_title , b.program_short_description , b.program_description , b.language_id , b.more_link');
			$this->db->from(TABLE_PROGRAM . ' a');
			$this->db->join(TABLE_PROGRAM_LANGUAGE . ' b' , 'a.program_id = b.program_id AND b.language_id = '.$languageId , 'left');
			$this->db->where('b.program_id' , $id);
			return $this->db->get()->row_array();
		}

		//This function is used to get program details from DB and show through datatable
		function getCourseDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL , $languageId = 1)
		{
			$resultData = array();
			$colomnArr = array('a.course_master_id' , 'a.course_image' , 'b.course_name' , 'a.course_status');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_COURSE_MASTER . ' a');
			$this->db->join(TABLE_COURSE_LANGUAGE . ' b' , 'a.course_master_id = b.course_id AND b.language_id = '.$languageId , 'left');

			//For checking soft deleted record
			$this->db->where('a.delete_flag' , 0);

			//For searching
			if($search_string != '')
				$this->db->where("(".$colomnArr[2]." LIKE '%".$search_string."%')");

			//For Ordering
			if($order_column != '' && $order_dir != '')
				$this->db->order_by($colomnArr[$order_column] , $order_dir);

			//For limit
			if($start != '' && $length != '')
				$this->db->limit($length , $start);

			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $value)
				{
					$actionStr ="<div class='btn-group custom-btn-group'>";
					$actionStr .= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().'index.php/frontweb/course/edit/'.$value['course_master_id'].'" data-toggle="tooltip" data-original-title="Edit Course"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a class="btn btn-xs btn-danger btn-wd-24" href="course/delete/'.$value['course_master_id'].'" onclick="return confirm_delete()" data-toggle="tooltip" data-original-title="Delete Course"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>';
					$statusClass = ($value['course_status'] == 1) ? 'fa-check-square-o' : 'fa-square-o';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Course Feature" class="btn btn-xs btn-warning min-wd-24"><i id="manageFeature" class="fa fa-cogs global-list-icon" aria-hidden="true" data-toggle="modal" data-target="#courseFeature" data-course_id = '.$value['course_master_id'].' ></i></a>';
					if($value['course_master_id'] == ADULT_COURSE_ID)
					{
						$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage BROCHURE" class="btn btn-xs btn-success btn-wd-24 pdf-management-class" data-course_master_id = '.$value['course_master_id'].'><span><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a>';
						$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Application Form" class="btn btn-xs btn-info btn-wd-24 formManagement"><span><i class="fa fa-tasks" aria-hidden="true"></i></span></a>';
						$actionStr .= '<a target="_blank" href="'.base_url().'index.php/frontweb/course/show_enquiry_form" data-toggle="tooltip" data-original-title="Show Enquiry Form" class="btn btn-xs btn-warning btn-wd-24"><span><i class="fa fa-book" aria-hidden="true"></i></span></a>';
					}
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Change Status for Course" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon"><span><i class="fa '.$statusClass.'" aria-hidden="true" data-toggle="modal" data-target="#juniorCentreStatus" data-status_type = '.$value['course_status'].' data-course_id = '.$value['course_master_id'].' ></i></span></a>';
					$actionStr .="</div>";

					$resultData[] = array(
						0 => $siNo++,
						1 => "<img src = '".base_url().COURSE_IMAGE_PATH.getThumbnailName($value['course_image'])."' width = 180 height = 50 />",
						2 => $value['course_name'],
						3 => $actionStr
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_COURSE_MASTER)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//Function is used to update program realated record in DB
		function updateCourse($id = NULL , $data = NULL)
		{
			$this->db->where('course_master_id' , $id)
					->update(TABLE_COURSE_MASTER , $data);
		}

		//Function is used to add courses related data(main table and multi-language wise + sub table) in DB
		function addCourse($data = NULL , $fileName = NULL , $frontFileName = NULL)
		{
			$insertData = array(
				'course_image' => $fileName,
				'course_front_image' => $frontFileName,
				'course_status' => 1
			);
			$this->db->insert(TABLE_COURSE_MASTER , $insertData);
			$courseId = $this->db->insert_id();

			$insertData = array(
				'language_id' => $data['language_id'],
				'course_name' => $data['course_name'],
				'corse_description' => $data['corse_description'],
				'course_id' => $courseId
			);
			$this->db->insert(TABLE_COURSE_LANGUAGE , $insertData);

			if(!empty($data['specification_option']))
			{
				foreach($data['specification_option'] as $key => $value)
				{
					if($data['specification_option'][$key] != '' && $data['specification_value'][$key] != '')
					{
						$insertData = array(
							'specification_option' => $data['specification_option'][$key],
							'specification_value' => $data['specification_value'][$key],
							'course_id' => $courseId
						);
						$this->db->insert(TABLE_COURSE_SPECIFICATION , $insertData);
					}
				}
			}
		}

		//This function is used to get data from DB to show in edit page
		function getEditCourseData($id = NULL , $languageId = 1)
		{
			$this->db->select('a.course_master_id , a.course_image , a.course_front_image , b.course_name , b.corse_description , b.language_id');
			$this->db->from(TABLE_COURSE_MASTER . ' a');
			$this->db->join(TABLE_COURSE_LANGUAGE . ' b' , 'a.course_master_id = b.course_id AND b.language_id = '.$languageId , 'left');
			$this->db->where('a.course_master_id' , $id);
			$result = $this->db->get()->row_array();
			$result['specification'] = $this->db->select('specification_option , specification_value')
												->where('course_id' , $id)
												->get(TABLE_COURSE_SPECIFICATION)->result_array();
			return $result;
		}

		//This function is used to update program data in DB
		function updateCourseData($id = NULL , $data = NULL , $fileName = NULL , $fileNameFront = NULL)
		{
			$updateData = array(
				'course_image' => $fileName,
				'course_front_image' => $fileNameFront
			);
			$this->db->where('course_master_id' , $id)
					->update(TABLE_COURSE_MASTER , $updateData);

			$updateData = array(
				'language_id' => $data['language_id'],
				'course_name' => $data['course_name'],
				'corse_description' => $data['corse_description'],
				'course_id' => $id
			);
			$this->db->where('course_id' , $id)
					->update(TABLE_COURSE_LANGUAGE , $updateData);

			$this->db->where('course_id' , $id)
					->delete(TABLE_COURSE_SPECIFICATION);
			if(!empty($data['specification_option']))
			{
				foreach($data['specification_option'] as $key => $value)
				{
					$insertData = array(
						'specification_option' => $data['specification_option'][$key],
						'specification_value' => $data['specification_value'][$key],
						'course_id' => $id
					);
					$this->db->insert(TABLE_COURSE_SPECIFICATION , $insertData);
				}
			}
		}

		//This function is used to delete record from DB for course module
		function deleteCourse($id = NULL)
		{
			$updateData = array(
				'delete_flag' => 1
			);

			$this->db->where('course_master_id' , $id)
					->update(TABLE_COURSE_MASTER , $updateData);
		}

		//Function is used to get all course features from DB
		function getCourseFeature($id = NULL)
		{
			return $this->db->select('feature_title , feature_description , feature_image , course_id')
							->where('course_id' , $id)
							->get(TABLE_COURSE_FEATURE)->result_array();
		}

		//This function is used to delete old feature data and insert the new one
		function updateCourseFeature($id =  NULL , $data = NULL)
		{
			$data = array_merge($data);
			$this->db->where('course_id' , $id)->delete(TABLE_COURSE_FEATURE);
			if(!empty($data))
			{
				foreach($data as $value)
					$this->db->insert(TABLE_COURSE_FEATURE , $value);
			}
		}

		//This function is used to get program course details from DB and show through datatable
		function getProgramCourseDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL)
		{
			$resultData = array();
			$colomnArr = array('a.program_course_id' , 'a.program_course_name' , 'a.program_course_logo' , 'a.program_course_status');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_PROGRAM_COURSE . ' a');

			//For checking soft deleted record
			$this->db->where('a.delete_flag' , 0);

			//For searching
			if($search_string != '')
				$this->db->where("(".$colomnArr[1]." LIKE '%".$search_string."%')");

			//For Ordering
			if($order_column != '' && $order_dir != '')
				$this->db->order_by($colomnArr[$order_column] , $order_dir);

			//For limit
			if($start != '' && $length != '')
				$this->db->limit($length , $start);

			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $value)
				{
					$actionStr ="<div class='btn-group custom-btn-group'>";
					$actionStr .= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().'index.php/frontweb/program_course/add_edit/'.$value['program_course_id'].'" data-toggle="tooltip" data-original-title="Edit Course Program"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a class="btn btn-xs btn-danger btn-wd-24" href="program_course/delete/'.$value['program_course_id'].'" onclick="return confirm_delete()" data-toggle="tooltip" data-original-title="Delete Course Program"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>';
					$statusClass = ($value['program_course_status'] == 1) ? 'fa-check-square-o' : 'fa-square-o';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Change Status for Course Program" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon"><span><i class="fa '.$statusClass.'" aria-hidden="true" data-toggle="modal" data-target="#juniorCentreStatus" data-status_type = '.$value['program_course_status'].' data-program_id = '.$value['program_course_id'].' ></i></span></a>';
					$actionStr .="</div>";

					$resultData[] = array(
						0 => $siNo++,
						1 => "<img src = '".base_url().PROGRAM_COURSE_IMAGE_PATH.getThumbnailName($value['program_course_logo'])."' width = 90 height = 87 />",
						2 => $value['program_course_name'],
						3 => $actionStr
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_PROGRAM_COURSE)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//This function is used to get junior centre details from DB and show through datatable
		function getjuniorCentreDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL)
		{
			$resultData = array();
			$colomnArr = array('a.junior_centre_id' , 'b.nome_centri as centre_name' , 'a.centre_banner' , 'a.junior_centre_status');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_JUNIOR_CENTRE . ' a');
			$this->db->join(TABLE_CENTRE.' b' , 'a.centre_id = b.id' , 'left');

			//For checking soft deleted record
			$this->db->where('a.delete_flag' , 0);

			//For searching
			if($search_string != '')
				$this->db->where("(b.nome_centri LIKE '%".$search_string."%')");

			//For Ordering
			if($order_column != '' && $order_dir != '')
				$this->db->order_by($colomnArr[$order_column] , $order_dir);

			//For limit
			if($start != '' && $length != '')
				$this->db->limit($length , $start);

			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $value)
				{
					$actionStr ="<div class='btn-group custom-btn-group' style='width:300px;'>";
					$actionStr .= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().'index.php/frontweb/junior_centre/add_edit/'.$value['junior_centre_id'].'" data-toggle="tooltip" data-original-title="Edit Junior Centre"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a class="btn btn-xs btn-danger btn-wd-24" href="'.base_url().'index.php/frontweb/junior_centre/delete/'.$value['junior_centre_id'].'" onclick="return confirm_delete()" data-toggle="tooltip" data-original-title="Delete Junior Centre"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>';
					$statusClass = ($value['junior_centre_status'] == 1) ? 'fa-check-square-o' : 'fa-square-o';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Add On" class="btn btn-xs btn-warning btn-wd-24 pdf-management-class" data-junior_centre_id = '.$value['junior_centre_id'].' data-type="addon"><span><i class="fa fa-plus" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Fact Sheet" class="btn btn-xs btn-primary btn-wd-24 pdf-management-class" data-junior_centre_id = '.$value['junior_centre_id'].' data-type="factsheet"><span><i class="fa fa-bars" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Activity Program" class="btn btn-xs btn-success btn-wd-24 pdf-management-class" data-junior_centre_id = '.$value['junior_centre_id'].' data-type="activity_program"><span><i class="fa fa-history" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Menu" class="btn btn-xs btn-info btn-wd-24 pdf-management-class" data-junior_centre_id = '.$value['junior_centre_id'].' data-type="menu"><span><i class="fa fa-credit-card" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Walking Tour" class="btn btn-xs btn-warning btn-wd-24 pdf-management-class" data-junior_centre_id = '.$value['junior_centre_id'].' data-type="walking_tour"><span><i class="fa fa-map-marker" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Dates" class="btn btn-xs btn-default btn-wd-24 dates-management-class" data-junior_centre_id = '.$value['junior_centre_id'].'><span><i class="fa fa-calendar" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a href="'.base_url().'index.php/frontweb/junior_centre/photo_gallery/'.$value['junior_centre_id'].'" data-toggle="tooltip" data-original-title="Manage Photo Gallery" class="btn btn-xs btn-primary btn-wd-24" target="_blank"><span><i class="fa fa-picture-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Video gallery" class="btn btn-xs btn-success btn-wd-24 video-management-class" data-junior_centre_id = '.$value['junior_centre_id'].'><span><i class="fa fa-file-video-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage International Mix" class="btn btn-xs btn-warning btn-wd-24 international-mix-management-class" data-junior_centre_id = '.$value['junior_centre_id'].'><span><i class="fa fa-globe" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Extra Section" class="btn btn-xs btn-primary btn-wd-24 extraSectionClass" data-junior_centre_id = '.$value['junior_centre_id'].'><span><i class="fa fa-th-large" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Change Status for Junior Centre" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon"><span><i class="fa '.$statusClass.'" aria-hidden="true" data-toggle="modal" data-target="#juniorCentreStatus" data-status_type = '.$value['junior_centre_status'].' data-junior_centre_id = '.$value['junior_centre_id'].' ></i></span></a>';
					$actionStr .="</div>";
					$resultData[] = array(
						0 => $siNo++,
						1 => "<img src = '".base_url().JUNIOR_CENTRE_IMAGE_PATH.getThumbnailName($value['centre_banner'])."' width = 180 height = 50 />",
						2 => $value['centre_name'],
						3 => $actionStr
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_JUNIOR_CENTRE)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//This function is used to get data from DB to show in edit page
		function getEditJuniorCentreData($id = NULL)
		{
			$result = $this->db->select('junior_centre_id , centre_id , centre_banner , accommodation , course')
							->where('junior_centre_id' , $id)
							->get(TABLE_JUNIOR_CENTRE)->row_array();
			$result['centre_program'] = $this->db->select('program_id , program_details , program_course_name')
											->join(TABLE_PROGRAM_COURSE , 'program_course_id = program_id' , 'left')
											->where('junior_centre_id' , $id)
											->get(TABLE_JUNIOR_CENTRE_PROGRAM)->result_array();
			$result['programDetails'] = $result['centre_program'];
			foreach($result['centre_program'] as $value)
				$centreProgram[] = $value['program_id'];
			$result['centre_program'] = $centreProgram;
			return $result;
		}

		//This function is used to add pdf managemnet in DB tables and return last added record details to show in the table
		function updatePdfManagement($fileName = NULL)
		{
			if($this->input->post('uploadPdfModalType') == 'addon')
				$tableName = TABLE_JUNIOR_CENTRE_ADDON;
			elseif($this->input->post('uploadPdfModalType') == 'factsheet')
				$tableName = TABLE_JUNIOR_CENTRE_FACTSHEET;
			elseif($this->input->post('uploadPdfModalType') == 'activity_program')
				$tableName = TABLE_JUNIOR_CENTRE_ACTIVITY_PROGRAM;
			elseif($this->input->post('uploadPdfModalType') == 'menu')
				$tableName = TABLE_JUNIOR_CENTRE_MENU;
			elseif($this->input->post('uploadPdfModalType') == 'walking_tour')
				$tableName = TABLE_JUNIOR_CENTRE_WALKING_TOUR;
			elseif($this->input->post('uploadPdfModalType') == 'brochure')
				$tableName = TABLE_ADULT_COURSE_BROCHURE;

			$insertData = array(
				'file_name' => $fileName,
				'file_description' => $this->input->post('file_description')
			);
			if($this->input->post('uploadPdfModalType') == 'brochure')
				$insertData['course_id'] = $this->input->post('juniorCentreId');
			else
				$insertData['junior_centre_id'] = $this->input->post('juniorCentreId');
			$this->db->insert($tableName , $insertData);
		}

		//This function is used to get the details from DB about pdf management
		function getPdfManagement($id = NULL , $type = NULL)
		{
			$foreignKey = 'junior_centre_id';
			if($type == 'addon')
			{
				$tableName = TABLE_JUNIOR_CENTRE_ADDON;
				$uploadPath = ADD_ON_FILE_PATH;
			}
			elseif($type == 'factsheet')
			{
				$tableName = TABLE_JUNIOR_CENTRE_FACTSHEET;
				$uploadPath = FACTSHEET_FILE_PATH;
			}
			elseif($type == 'activity_program')
			{
				$tableName = TABLE_JUNIOR_CENTRE_ACTIVITY_PROGRAM;
				$uploadPath = ACTIVITY_PROGRAM_FILE_PATH;
			}
			elseif($type == 'menu')
			{
				$tableName = TABLE_JUNIOR_CENTRE_MENU;
				$uploadPath = MENU_FILE_PATH;
			}
			elseif($type == 'walking_tour')
			{
				$tableName = TABLE_JUNIOR_CENTRE_WALKING_TOUR;
				$uploadPath = WALKING_TOUR_FILE_PATH;
			}
			elseif($type == 'brochure')
			{
				$tableName = TABLE_ADULT_COURSE_BROCHURE;
				$uploadPath = ADULT_COURSE_BROCHURE;
				$foreignKey = 'course_id';
			}

			$result = $this->db->select('id , file_name , file_description')
							->where($foreignKey , $id)
							->get($tableName)->result_array();
			$str = '<table id="uploadPdfModalTable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>SI no.</th>
								<th>File</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					$str.= '<tr>
								<td>'.($key + 1).'</td>
								<td><a target="_blank" href="'.base_url().$uploadPath.$value['file_name'].'">'.$value['file_name'].'</a></td>
								<td>'.$value['file_description'].'</td>
								<td><div class="btn-group"><span><a data-juniorCentreId = '.$id.' data-uploadPdfModalType = '.$type.' data-refId = '.$value['id'].' data-toggle="tooltip" class="deletePdf btn btn-xs btn-danger min-wd-24" data-original-title="Delete PDF"><i class="fa fa-trash-o"></i></a></span></div></td>
							</tr>';
				}
			}
			$str.= '</tbody></table>';
			return $str;
		}

		//this function is used to delete record from DB for pdf management
		function deletePdfManagement()
		{
			if($this->input->post('uploadpdfmodaltype') == 'addon')
			{
				$tableName = TABLE_JUNIOR_CENTRE_ADDON;
				$uploadPath = ADD_ON_FILE_PATH;
			}
			elseif($this->input->post('uploadpdfmodaltype') == 'factsheet')
			{
				$tableName = TABLE_JUNIOR_CENTRE_FACTSHEET;
				$uploadPath = FACTSHEET_FILE_PATH;
			}
			elseif($this->input->post('uploadpdfmodaltype') == 'activity_program')
			{
				$tableName = TABLE_JUNIOR_CENTRE_ACTIVITY_PROGRAM;
				$uploadPath = ACTIVITY_PROGRAM_FILE_PATH;
			}
			elseif($this->input->post('uploadpdfmodaltype') == 'menu')
			{
				$tableName = TABLE_JUNIOR_CENTRE_MENU;
				$uploadPath = MENU_FILE_PATH;
			}
			elseif($this->input->post('uploadpdfmodaltype') == 'walking_tour')
			{
				$tableName = TABLE_JUNIOR_CENTRE_WALKING_TOUR;
				$uploadPath = WALKING_TOUR_FILE_PATH;
			}
			elseif($this->input->post('uploadpdfmodaltype') == 'brochure')
			{
				$tableName = TABLE_ADULT_COURSE_BROCHURE;
				$uploadPath = ADULT_COURSE_BROCHURE;
			}

			$result = $this->db->select('file_name')
							->where('id' , $this->input->post('id'))
							->get($tableName)->row_array();
			//Delete the pdf file from folder
			if($result['file_name'] != '')
			{
				if(file_exists('./'.$uploadPath.$result['file_name']))
					unlink('./'.$uploadPath.$result['file_name']);
			}
			$this->db->where('id' , $this->input->post('id'))
					->delete($tableName);
		}

		//This is a common function to get the data from database
		function commonGetData($select = NULL , $whereCondition = NULL , $tableName = NULL , $getFlag = 1 , $orderByField = NULL , $orderByType = 'asc')
		{
			if($select != '')
				$this->db->select($select);
			if($whereCondition != '')
				$this->db->where($whereCondition);
			if($orderByField != '')
				$this->db->order_by($orderByField , $orderByType);
			if($getFlag == 1)
				return $this->db->get($tableName)->row_array();
			else
				return $this->db->get($tableName)->result_array();
		}

		//this is a common function to add record in database
		function commonAdd($tableName = NULL , $data = array())
		{
			if($tableName != '')
				$this->db->insert($tableName , $data);
			return $this->db->insert_id();
		}

		//This is a common function to delete record from database
		function commonDelete($tableName = NULL , $whreCondition = NULL)
		{
			if($tableName != '')
			{
				$this->db->where($whreCondition)
						->delete($tableName);
			}
		}

		//This is a common function to update record to database
		function commonUpdate($tableName = NULL , $whreCondition = NULL , $data = NULL)
		{
			if($tableName != '')
			{
				$this->db->where($whreCondition)
						->update($tableName , $data);
			}
		}

		//This function is used to get the details from DB about date management
		function getdateManagement($id = NULL , $type = NULL)
		{
			if($type == 'junior_centre')
			{
				$result = $this->db->select("a.junior_centre_dates_id as id , a.date , a.overnight ,
											(select GROUP_CONCAT(b.week order by b.week) from ".TABLE_JUNIOR_CENTRE_DATES_WEEK." b
											where a.junior_centre_dates_id=b.junior_centre_dates_id) as week , (select
											group_concat(d.program_course_name) from ".TABLE_JUNIOR_CENTRE_DATES_PROGRAM."
											c join ".TABLE_PROGRAM_COURSE." d on c.program_id=d.program_course_id where
											a.junior_centre_dates_id=c.junior_centre_dates_id) as program")
								->from(TABLE_JUNIOR_CENTRE_DATES.' a')
								->order_by('a.date' , 'asc')
								->where('a.junior_centre_id' , $id)
								->get()->result_array();
			}
			elseif($type == 'junior_ministay')
			{
				$result = $this->db->select("a.junior_ministay_dates_id as id , a.date , a.overnight ,
											(select GROUP_CONCAT(b.week order by b.week) from ".TABLE_JUNIOR_MINISTAY_DATES_WEEK." b
											where a.junior_ministay_dates_id=b.junior_ministay_dates_id) as week , (select
											group_concat(d.program_course_name) from ".TABLE_JUNIOR_MINISTAY_DATES_PROGRAM."
											c join ".TABLE_PROGRAM_COURSE." d on c.program_id=d.program_course_id where
											a.junior_ministay_dates_id=c.junior_ministay_dates_id) as program")
								->from(TABLE_JUNIOR_MINISTAY_DATES.' a')
								->order_by('a.date' , 'asc')
								->where('a.junior_ministay_id' , $id)
								->get()->result_array();
			}
			$str = '<table id="dateModalTable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>SI no.</th>
								<th>Arrival dates</th>
								<th>Weeks</th>
								<th>Programmes</th>
								<th>Overnight</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					$str.= '<tr>
								<td>'.($key + 1).'</td>
								<td>'.date('d-m-Y' , strtotime($value['date'])).'</td>
								<td>'.str_replace(',' , '/' , $value['week']).' weeks</td>
								<td>'.str_replace(',' , ' ; ' , $value['program']).'</td>
								<td>'.$value['overnight'].'</td>
								<td>
									<div class="btn-group">
										<span><a data-id = '.$id.' data-dates_id = '.$value['id'].' data-toggle="tooltip" class="editDates btn btn-xs btn-info min-wd-24" data-original-title="Edit Date"><i class="fa fa-pencil-square-o"></i></a></span>
										<span><a data-juniorCentreId = '.$id.' data-refId = '.$value['id'].' data-toggle="tooltip" class="deletedates btn btn-xs btn-danger min-wd-24" data-original-title="Delete Date"><i class="fa fa-trash-o"></i></a></span>
									</div>
								</td>
							</tr>';
				}
			}
			$str.= '</tbody></table>';
			return $str;
		}

		//This function is used to add value in DB for dates management
		function addDatesManagement()
		{
			$insertData = array(
				'date' => $this->input->post('date'),
				'overnight' => $this->input->post('overnight'),
				'junior_centre_id' => $this->input->post('dateJuniorCentreId')
			);
			$this->db->insert(TABLE_JUNIOR_CENTRE_DATES , $insertData);
			$id = $this->db->insert_id();

			$weekData = $this->input->post('week');
			if(!empty($weekData))
			{
				foreach($weekData as $value)
				{
					$insertData = array(
						'week' => $value,
						'junior_centre_dates_id' => $id
					);
					$this->db->insert(TABLE_JUNIOR_CENTRE_DATES_WEEK , $insertData);
				}
			}

			$programData = $this->input->post('program_id');
			if(!empty($programData))
			{
				foreach($programData as $value)
				{
					$insertData = array(
						'program_id' => $value,
						'junior_centre_dates_id' => $id
					);
					$this->db->insert(TABLE_JUNIOR_CENTRE_DATES_PROGRAM , $insertData);
				}
			}
		}

		//This function is used to delete record from database related to dates management
		function deleteDatesManagement()
		{
			$this->db->where('junior_centre_dates_id' , $this->input->post('id'))
					->delete(TABLE_JUNIOR_CENTRE_DATES);
			$this->db->where('junior_centre_dates_id' , $this->input->post('id'))
					->delete(TABLE_JUNIOR_CENTRE_DATES_WEEK);
			$this->db->where('junior_centre_dates_id' , $this->input->post('id'))
					->delete(TABLE_JUNIOR_CENTRE_DATES_PROGRAM);
		}

		//Function is used to get photo gallery details from DB and show in the table
		function getPhotoGalleryDetails($id = NULL , $type = NULL)
		{
			if($type == 'junior_centre')
			{
				$tableName = TABLE_JUNIOR_CENTRE_PHOTO_GALLERY;
				$imagePath = PHOTO_GALLERY_IMAGE_PATH;
				$primaryKey = 'junior_centre_photo_gallery_id';
				$foreignKey = 'junior_centre_id';
			}
			elseif($type == 'junior_ministay')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_PHOTOGALLERY;
				$imagePath = MINISTAY_PHOTO_GALLERY_IMAGE_PATH;
				$primaryKey = 'junior_ministay_photo_gallery_id';
				$foreignKey = 'junior_ministay_id';
			}
			$returnData = array();
			$result = $this->db->select($primaryKey.' as id , short_description , description , photo , sequence')
								->where($foreignKey , $id)
								->order_by('sequence' , 'asc')
								->get($tableName)->result_array();
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					$returnData[] = array(
						'si_no' => ($key + 1),
						'photo' => '<img src = "'.base_url().$imagePath.getThumbnailName($value['photo']).'" width = 150 height = 112 />',
						'short_description' => $value['short_description'],
						'description' => $value['description'],
						'sequence' => '<input value="'.$value['sequence'].'" class="form-control changeSequence" data-ref_id="'.$value['id'].'" type="text">',
						'action' => '<div class="btn-group custom-btn-group"><a class="btn btn-xs btn-danger btn-wd-24" href="'.base_url().'index.php/frontweb/'.$type.'/delete_photo_gallery/'.$value['id'].'/'.$id.'" onclick="return confirm_delete()" data-toggle="tooltip" data-original-title="Delete photo"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div>'
					);
				}
			}
			return $returnData;
		}

		//This function is used to get the details from DB about video gallery management
		function getVideoGalleryManagement($id = NULL , $type = NULL)
		{
			if($type == 'junior_centre')
			{
				$tableName = TABLE_JUNIOR_CENTRE_VIDEO_GALLERY;
				$imagePath = VIDEO_GALLERY_IMAGE_PATH;
				$primaryKey = 'junior_centre_video_gallery_id';
				$foreignKey = 'junior_centre_id';
			}
			elseif($type == 'junior_ministay')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_VIDEO_GALLERY;
				$imagePath = MINISTAY_VIDEO_GALLERY_IMAGE_PATH;
				$primaryKey = 'junior_ministay_video_gallery_id';
				$foreignKey = 'junior_ministay_id';
			}
			$result = $this->db->select($primaryKey." as id , video_url , description , video_image , sequence")
							->where($foreignKey , $id)
							->order_by('sequence' , 'asc')
							->get($tableName)->result_array();
			$str = '<table id="videoModalTable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>SI no.</th>
								<th>Video url</th>
								<th>Description</th>
								<th>Video image</th>
								<th>Sequence</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					$str.= '<tr>
								<td>'.($key + 1).'</td>
								<td><a href="'.$value['video_url'].'" target="_blank">'.$value['video_url'].'</a></td>
								<td>'.$value['description'].'</td>
								<td><img src = "'.base_url().$imagePath.getThumbnailName($value['video_image']).'" width = 200 height = 112 /></td>
								<td><input value="'.$value['sequence'].'" class="form-control changeSequence" data-ref_id="'.$value['id'].'" type="text"></td>
								<td><div class="btn-group"><span><a data-juniorCentreId = '.$id.' data-refId = '.$value['id'].' data-toggle="tooltip" class="deletevideo btn btn-xs btn-danger min-wd-24" data-original-title="Delete Video"><i class="fa fa-trash-o"></i></a></span></div></td>
							</tr>';
				}
			}
			$str.= '</tbody></table>';
			return $str;
		}

		//This function is used to get the details from DB about International Mix management
		function getInternationalMixManagement($id = NULL , $type = NULL)
		{
			if($type == 'junior_centre')
			{
				$tableName = TABLE_JUNIOR_CENTRE_INTERNATIONAL_MIX;
				$primaryKey = 'junior_centre_international_mix_id';
				$foreignKey = 'junior_centre_id';
			}
			if($type == 'junior_ministay')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_INTERNATIONAL_MIX;
				$primaryKey = 'junior_ministay_international_mix_id';
				$foreignKey = 'junior_ministay_id';
			}
			$result = $this->db->select($primaryKey." as id , country_name , percentage , color_code")
							->where($foreignKey , $id)
							->get($tableName)->result_array();
			$str = '<table id="internationalMixModalTable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Si no.</th>
								<th>Country name</th>
								<th>Percentage</th>
								<th>Color</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					$arr = explode('-' , $value['country_name']);
					$str.= '<tr>
								<td>'.($key + 1).'</td>
								<td>'.$arr[0].'</td>
								<td>'.$value['percentage'].'</td>
								<td><div style="height: 20px;width: 80px;border: 1px solid '.$value['color_code'].';background-color: '.$value['color_code'].';"></div></td>
								<td><div class="btn-group"><span><a data-juniorCentreId = '.$id.' data-refId = '.$value['id'].' data-toggle="tooltip" class="deleteInternationalMix btn btn-xs btn-danger min-wd-24" data-original-title="Delete International Mix"><i class="fa fa-trash-o"></i></a></span></div></td>
							</tr>';
				}
			}
			$str.= '</tbody></table>';
			return $str;
		}

		//This function is used to get the data from database for junior mini stay program and show in the datatable
		function getjuniorMiniStayDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL)
		{
			$resultData = array();
			$colomnArr = array('a.junior_ministay_id' , 'b.nome_centri as centre_name' , 'a.centre_banner' , 'a.junior_ministay_status');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_JUNIOR_MINISTAY . ' a');
			$this->db->join(TABLE_CENTRE.' b' , 'a.centre_id = b.id' , 'left');

			//For checking soft deleted record
			$this->db->where('a.delete_flag' , 0);

			//For searching
			if($search_string != '')
				$this->db->where("(b.nome_centri LIKE '%".$search_string."%')");

			//For Ordering
			if($order_column != '' && $order_dir != '')
				$this->db->order_by($colomnArr[$order_column] , $order_dir);

			//For limit
			if($start != '' && $length != '')
				$this->db->limit($length , $start);

			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $value)
				{
					$actionStr ="<div class='btn-group custom-btn-group' style='width:300px;'>";
					$actionStr .= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().'index.php/frontweb/junior_ministay/add_edit/'.$value['junior_ministay_id'].'" data-toggle="tooltip" data-original-title="Edit Junior Mini Stay"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a class="btn btn-xs btn-danger btn-wd-24" href="'.base_url().'index.php/frontweb/junior_ministay/delete/'.$value['junior_ministay_id'].'" onclick="return confirm_delete()" data-toggle="tooltip" data-original-title="Delete Junior Mini Stay"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Add On" class="btn btn-xs btn-warning btn-wd-24 pdf-management-class" data-junior_ministay_id = '.$value['junior_ministay_id'].' data-type="addon"><span><i class="fa fa-plus" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Fact Sheet" class="btn btn-xs btn-primary btn-wd-24 pdf-management-class" data-junior_ministay_id = '.$value['junior_ministay_id'].' data-type="factsheet"><span><i class="fa fa-bars" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Activity Program" class="btn btn-xs btn-success btn-wd-24 pdf-management-class" data-junior_ministay_id = '.$value['junior_ministay_id'].' data-type="activity_program"><span><i class="fa fa-history" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Menu" class="btn btn-xs btn-info btn-wd-24 pdf-management-class" data-junior_ministay_id = '.$value['junior_ministay_id'].' data-type="menu"><span><i class="fa fa-credit-card" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Walking Tour" class="btn btn-xs btn-warning btn-wd-24 pdf-management-class" data-junior_ministay_id = '.$value['junior_ministay_id'].' data-type="walking_tour"><span><i class="fa fa-map-marker" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Dates" class="btn btn-xs btn-default btn-wd-24 dates-management-class" data-junior_ministay_id = '.$value['junior_ministay_id'].'><span><i class="fa fa-calendar" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a href="'.base_url().'index.php/frontweb/junior_ministay/photo_gallery/'.$value['junior_ministay_id'].'" data-toggle="tooltip" data-original-title="Manage Photo Gallery" class="btn btn-xs btn-primary btn-wd-24" target="_blank"><span><i class="fa fa-picture-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Video gallery" class="btn btn-xs btn-success btn-wd-24 video-management-class" data-junior_ministay_id = '.$value['junior_ministay_id'].'><span><i class="fa fa-file-video-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage International Mix" class="btn btn-xs btn-warning btn-wd-24 international-mix-management-class" data-junior_ministay_id = '.$value['junior_ministay_id'].'><span><i class="fa fa-globe" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Manage Extra Section" class="btn btn-xs btn-primary btn-wd-24 extraSectionClass" data-junior_ministay_id = '.$value['junior_ministay_id'].'><span><i class="fa fa-th-large" aria-hidden="true"></i></span></a>';
					$statusClass = ($value['junior_ministay_status'] == 1) ? 'fa-check-square-o' : 'fa-square-o';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Change Status for Junior Mini Stay" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon"><span><i class="fa '.$statusClass.'" aria-hidden="true" data-status_type = '.$value['junior_ministay_status'].' data-junior_ministay_id = '.$value['junior_ministay_id'].' ></i></span></a>';
					$actionStr .="</div>";
					$resultData[] = array(
						0 => $siNo++,
						1 => "<img src = '".base_url().JUNIOR_MINISTAY_IMAGE_PATH.getThumbnailName($value['centre_banner'])."' width = 180 height = 50 />",
						2 => $value['centre_name'],
						3 => $actionStr
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_JUNIOR_MINISTAY)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//This function is used to get the details from DB about pdf management for junior ministay course
		function getMiniStayPdfManagement($id = NULL , $type = NULL)
		{
			if($type == 'addon')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_ADDON;
				$uploadPath = MINISTAY_ADDON_FILE_PATH;
			}
			elseif($type == 'factsheet')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_FACT_SHEET;
				$uploadPath = MINISTAY_FACTSHEET_FILE_PATH;
			}
			elseif($type == 'activity_program')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_ACTIVITY_PROGRAM;
				$uploadPath = MINISTAY_ACTIVITY_PROGRAM_FILE_PATH;
			}
			elseif($type == 'menu')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_MENU;
				$uploadPath = MINISTAY_MENU_FILE_PATH;
			}
			elseif($type == 'walking_tour')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_WALKING_TOUR;
				$uploadPath = MINISTAY_WALKING_TOUR_FILE_PATH;
			}

			$result = $this->db->select('id , file_name , file_description')
							->where('junior_ministay_id' , $id)
							->get($tableName)->result_array();
			$str = '<table id="uploadPdfModalTable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>SI no.</th>
								<th>File</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					$str.= '<tr>
								<td>'.($key + 1).'</td>
								<td><a target="_blank" href="'.base_url().$uploadPath.$value['file_name'].'">'.$value['file_name'].'</a></td>
								<td>'.$value['file_description'].'</td>
								<td><div class="btn-group"><span><a data-junior_ministay_id = '.$id.' data-uploadPdfModalType = '.$type.' data-refId = '.$value['id'].' data-toggle="tooltip" class="deletePdf btn btn-xs btn-danger min-wd-24" data-original-title="Delete PDF"><i class="fa fa-trash-o"></i></a></span></div></td>
							</tr>';
				}
			}
			$str.= '</tbody></table>';
			return $str;
		}

		//This function is used to add pdf managemnet in DB tables for junior mini stay courses
		function addJuniorMiniStayPdfManagement($fileName = NULL)
		{
			if($this->input->post('uploadPdfModalType') == 'addon')
				$tableName = TABLE_JUNIOR_MINISTAY_ADDON;
			elseif($this->input->post('uploadPdfModalType') == 'factsheet')
				$tableName = TABLE_JUNIOR_MINISTAY_FACT_SHEET;
			elseif($this->input->post('uploadPdfModalType') == 'activity_program')
				$tableName = TABLE_JUNIOR_MINISTAY_ACTIVITY_PROGRAM;
			elseif($this->input->post('uploadPdfModalType') == 'menu')
				$tableName = TABLE_JUNIOR_MINISTAY_MENU;
			elseif($this->input->post('uploadPdfModalType') == 'walking_tour')
				$tableName = TABLE_JUNIOR_MINISTAY_WALKING_TOUR;

			$insertData = array(
				'file_name' => $fileName,
				'file_description' => $this->input->post('file_description'),
				'junior_ministay_id' => $this->input->post('juniorMiniStayId')
			);
			$this->db->insert($tableName , $insertData);
		}

		//this function is used to delete record from DB for pdf management for junior mini stay courses
		function deleteMiniStayPdfManagement()
		{
			if($this->input->post('uploadpdfmodaltype') == 'addon')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_ADDON;
				$uploadPath = MINISTAY_ADDON_FILE_PATH;
			}
			elseif($this->input->post('uploadpdfmodaltype') == 'factsheet')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_FACT_SHEET;
				$uploadPath = MINISTAY_FACTSHEET_FILE_PATH;
			}
			elseif($this->input->post('uploadpdfmodaltype') == 'activity_program')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_ACTIVITY_PROGRAM;
				$uploadPath = MINISTAY_ACTIVITY_PROGRAM_FILE_PATH;
			}
			elseif($this->input->post('uploadpdfmodaltype') == 'menu')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_MENU;
				$uploadPath = MINISTAY_MENU_FILE_PATH;
			}
			elseif($this->input->post('uploadpdfmodaltype') == 'walking_tour')
			{
				$tableName = TABLE_JUNIOR_MINISTAY_WALKING_TOUR;
				$uploadPath = MINISTAY_WALKING_TOUR_FILE_PATH;
			}

			$result = $this->db->select('file_name')
							->where('id' , $this->input->post('id'))
							->get($tableName)->row_array();
			//Delete the pdf file from folder
			if($result['file_name'] != '')
			{
				if(file_exists('./'.$uploadPath.$result['file_name']))
					unlink('./'.$uploadPath.$result['file_name']);
			}
			$this->db->where('id' , $this->input->post('id'))
					->delete($tableName);
		}

		//This function is used to get enquiry form details from DB and show through datatable
		function getFormDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL , $languageId = 1)
		{
			$resultData = array();
			$colomnArr = array('distinct(user) as user' , 'added_date');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_APPLICATION_FORM_DATA);

			//For searching
			if($search_string != '')
				$this->db->where("(".$colomnArr[1]." LIKE '%".$search_string."%')");

			//For Ordering
			if($order_column != '' && $order_dir != '')
				$this->db->order_by('user' , $order_dir);

			//For limit
			if($start != '' && $length != '')
				$this->db->limit($length , $start);

			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $value)
				{
					$actionStr ="<div class='btn-group custom-btn-group'>";
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Show details" class="btn btn-xs btn-success btn-wd-24 showDetails" data-user = '.$value['user'].'><span><i class="fa fa-bookmark-o" aria-hidden="true"></i></span></a>';
					$actionStr .="</div>";

					$resultData[] = array(
						0 => $siNo++,
						1 => date('d-m-Y H:i:s' , strtotime($value['added_date'])),
						2 => $actionStr
					);
				}
			}
			return array(
				'count_all' => count($result),
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//This function is used to get the details of plus video credential details to show in the listing page
		function getVideoCredentialDetails()
		{
			return $this->db->select('plus_video_id , nome_centri , password , manager_password')
					->join(TABLE_CENTRE , 'centre = id' , 'left')
					->order_by('nome_centri' , 'asc')
					->get(TABLE_PLUS_VIDEO)->result_array();
		}

		//This function is used to get walking tour details from DB and show through datatable
		function getWalkingTourDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL , $languageId = 1)
		{
			$resultData = array();
			$colomnArr = array('a.plus_walking_tour_id' , 'b.nome_centri' , 'a.video' , 'a.description');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_PLUS_WALKING_TOUR . ' a');
			$this->db->join(TABLE_CENTRE . ' b' , 'a.centre_id = b.id' , 'left');

			//For searching
			if($search_string != '')
				$this->db->where("(".$colomnArr[1]." LIKE '%".$search_string."%')");

			//For Ordering
			if($order_column != '' && $order_dir != '')
				$this->db->order_by($colomnArr[$order_column] , $order_dir);

			//For limit
			if($start != '' && $length != '')
				$this->db->limit($length , $start);

			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $value)
				{
					$actionStr ="<div class='btn-group custom-btn-group'>";
					$actionStr .= '<a class="btn btn-xs btn-info btn-wd-24 editDescription" data-id="'.$value['plus_walking_tour_id'].'" data-toggle="tooltip" data-original-title="Edit Description"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					$actionStr .= "</div>";

					$resultData[] = array(
						0 => $siNo++,
						1 => $value['nome_centri'],
						2 => "<video width='300' height='200' controls><source src='".base_url().PLUS_WALKING_TOUR.$value['video']."'></video>",
						3 => $value['description'],
						4 => $actionStr
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_PLUS_WALKING_TOUR)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//This function is used to get section setting details from DB and show through datatable
		function getSectionSettingDetails($start = NULL , $length = NULL , $search_string = NULL , $type = 1)
		{
			$resultData = array();
			$colomnArr = array('a.id' , 'a.name' , 'a.slug' , 'a.sequence');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_PLUS_SECTION_SETTING . ' a');

			$this->db->where('a.type' , $type);

			//For searching
			if($search_string != '')
				$this->db->where("(".$colomnArr[1]." LIKE '%".$search_string."%' OR ".$colomnArr[2]." LIKE '%".$search_string."%')");

			//For Ordering
			$this->db->order_by('a.sequence' , 'asc');

			//For limit
			if($start != '' && $length != '')
				$this->db->limit($length , $start);

			$result = $this->db->get()->result_array();

			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $key => $value)
				{
					$actionStr ="<div class='btn-group custom-btn-group'>";
					$actionStr .= '<a class="btn btn-xs btn-info btn-wd-24 editBtn" data-id="'.$value['id'].'" data-toggle="tooltip" data-original-title="Edit Section Name"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					$actionStr .="</div>";
					$styleStr = '';
					$sequenceStr = '<input type="hidden" value="'.$value['id'].'" class="currentSectionId">
					<input type="hidden" value="'.$value['sequence'].'" class="currentSectionSequence">';

					if($key < (count($result)-1))
						$sequenceStr.= '<a data-toggle="tooltip" data-original-title="Move down" data-sequence="down" style="cursor:pointer;margin-right: 15px;" class="changeSequence"><i class="fa fa-arrow-circle-down fa-2x"></i></a>';
					else
						$styleStr = "margin-left: 40px;";
					if($key != 0)
						$sequenceStr.= '<a data-toggle="tooltip" data-original-title="Move up" data-sequence="up" style="cursor:pointer;'.$styleStr.'" class="changeSequence"><i class="fa  fa-arrow-circle-up fa-2x"></i></a>';

					$resultData[] = array(
						0 => $siNo++,
						1 => $value['name'],
						2 => $value['slug'],
						3 => $sequenceStr,
						4 => $actionStr
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_PLUS_SECTION_SETTING)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}

		//This function is used to insert the slug into sequence setting after adding new program
		function insertSlug($name = NULL , $slugName = NULL , $type = NULL)
		{
			$result = $this->db->query('select type,(case when type=1 then (select sequence from
						frontweb_section_setting where type=1 order by sequence desc limit 0,1)
						else (select sequence from frontweb_section_setting where type=2 order by
						 sequence desc limit 0,1) end) as max_sequence from frontweb_section_setting
						  group by type')->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
				{
					$data = array(
						'name' => $name,
						'slug' => $slugName,
						'sequence' => ($value['max_sequence'] + 1),
						'type' => $value['type']
					);
					if($type != '')
					{
						if($value['type'] == $type)
							$this->db->insert(TABLE_PLUS_SECTION_SETTING , $data);
					}
					else
						$this->db->insert(TABLE_PLUS_SECTION_SETTING , $data);
				}
			}
			return TRUE;
		}

		//This function is used to get the details from DB about extra section content
		function getExtraSectionContent($id = NULL , $type = NULL)
		{
			$result = $this->db->select('a.extra_section_content_id as id , b.name , a.description , a.file_name')
							->join(TABLE_PLUS_EXTRA_SECTION.' b' , 'a.extra_section_id = b.extra_section_id' , 'left')
							->where('b.course_id' , $type)
							->where('a.centre_id' , $id)
							->get(TABLE_PLUS_EXTRA_SECTION_CONTENT.' a')->result_array();
			$str = '<table id="extraSectionTable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>SI no.</th>
								<th>Section name</th>
								<th>Description</th>
								<th>File Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
			if(!empty($result))
			{
				foreach($result as $key => $value)
				{
					$str.= '<tr>
								<td>'.($key + 1).'</td>
								<td>'.$value['name'].'</td>
								<td>'.$value['description'].'</td>
								<td><a target="_blank" href="'.base_url().EXTRA_SECTION_FILE_PATH.$value['file_name'].'">'.$value['file_name'].'</a></td>
								<td><div class="btn-group"><span><a data-juniorCentreId = '.$id.' data-refId = '.$value['id'].' data-toggle="tooltip" class="deleteSectionPdf btn btn-xs btn-danger min-wd-24" data-original-title="Delete PDF"><i class="fa fa-trash-o"></i></a></span></div></td>
							</tr>';
				}
			}
			$str.= '</tbody></table>';
			return $str;
		}

		//This function is used to get ministay program details from DB and show through datatable
		function getMinistayProgramDetails($start = NULL , $length = NULL , $search_string = NULL , $order_column = NULL , $order_dir = NULL)
		{
			$resultData = array();
			$colomnArr = array('a.junior_ministay_static_program_id' , 'a.program_name' , 'a.description' , 'a.logo' , 'a.status');
			$this->db->select(implode(',' , $colomnArr));
			$this->db->from(TABLE_JUNIOR_MINISTAY_STATIC_PROGRAM . ' a');

			//For checking soft deleted record
			$this->db->where('a.delete_flag' , 0);

			//For searching
			if($search_string != '')
				$this->db->where("(".$colomnArr[1]." LIKE '%".$search_string."%')");

			//For Ordering
			if($order_column != '' && $order_dir != '')
				$this->db->order_by($colomnArr[$order_column] , $order_dir);

			//For limit
			if($start != '' && $length != '')
				$this->db->limit($length , $start);

			$result = $this->db->get()->result_array();
			if(!empty($result))
			{
				$siNo = $this->input->post('start') + 1;
				foreach($result as $value)
				{
					$actionStr ="<div class='btn-group custom-btn-group'>";
					$actionStr .= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().'index.php/frontweb/ministay_program/add_edit/'.$value['junior_ministay_static_program_id'].'" data-toggle="tooltip" data-original-title="Edit Ministay Program"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					$actionStr .= '<a class="btn btn-xs btn-danger btn-wd-24" href="ministay_program/delete/'.$value['junior_ministay_static_program_id'].'" onclick="return confirm_delete()" data-toggle="tooltip" data-original-title="Delete Ministay Program"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>';
					$statusClass = ($value['status'] == 1) ? 'fa-check-square-o' : 'fa-square-o';
					$actionStr .= '<a data-toggle="tooltip" data-original-title="Change Status for Ministay Program" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon"><span><i class="fa '.$statusClass.'" aria-hidden="true" data-toggle="modal" data-status_type = '.$value['status'].' data-program_id = '.$value['junior_ministay_static_program_id'].' ></i></span></a>';
					$actionStr .="</div>";

					$resultData[] = array(
						0 => $siNo++,
						1 => "<img src = '".base_url().MINISTAY_PROGRAM_IMAGE_PATH.getThumbnailName($value['logo'])."' width = 90 height = 87 />",
						2 => $value['program_name'],
						3 => $actionStr
					);
				}
			}

			$count_all = $this->db->select('count(*) as total')->get(TABLE_JUNIOR_MINISTAY_STATIC_PROGRAM)->row_array();
			return array(
				'count_all' => $count_all['total'],
				'count_filtered' => count($result),
				'data' => $resultData
			);
		}
	}
?>
