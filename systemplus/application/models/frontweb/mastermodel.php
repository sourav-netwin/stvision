<?php
	/*
	This model is used to perform all the database related operations for all the master modules.
	Developed by : S.D
	Date : 14th February , 2018
	*/
	class Mastermodel extends model
	{
		//This is the constructor
		public function __construct()
		{
			parent::__construct();
		}

		//This function is used to get the module wise language array details from master_lang.php
		public function getModule($moduleName = NULL)
		{
			$moduleArr = array();
			if($moduleName != '')
				$moduleArr = lang($moduleName);
			return $moduleArr;
		}

		//This function is used to get the module details from database and perpare proper data to show in the datatable
		public function getDatatable($moduleName = NULL , $start = NULL , $length = NULL , $searchString = NULL , $orderColumn = NULL , $orderDir = NULL)
		{
			$resultData = array();
			$moduleArr = $this->getModule($moduleName);
			$this->db->select($this->getSelectColumn($moduleArr , 'list'));
			$this->db->from($moduleArr['dbName']);
			$this->db->where($moduleArr['listWhere']);

			//For searching
			if($searchString != '')
			{
				foreach($moduleArr['list'] as $key => $value)
				{
					if($key != 'actionColumn' && $value['type'] == 'text')
						$this->db->where("(".$key." LIKE '%".$searchString."%')");
				}
			}

			//For Ordering
			if($orderColumn != '' && $orderDir != '')
			{
				foreach($moduleArr['list'] as $key => $value)
				{
					if($value['columnNo'] == $orderColumn)
						$this->db->order_by($key , $orderDir);
				}
			}

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
					if(in_array('edit' , $moduleArr['list']['actionColumn']['actionType']))
						$actionStr.= '<a class="btn btn-xs btn-info btn-wd-24" href="'.base_url().'index.php/frontweb/master/add_edit/'.$moduleName.'/'.$value[$moduleArr['key']].'" data-toggle="tooltip" data-original-title="Edit '.$moduleArr['title'].'"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>';
					if(in_array('delete' , $moduleArr['list']['actionColumn']['actionType']))
						$actionStr.= '<a class="btn btn-xs btn-danger btn-wd-24" href="'.base_url().'index.php/frontweb/master/delete/'.$moduleName.'/'.$value[$moduleArr['key']].'" onclick="return confirm_delete(\''.$moduleArr['title'].'\')" data-toggle="tooltip" data-original-title="Delete '.$moduleArr['title'].'"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>';
					if(in_array('status' , $moduleArr['list']['actionColumn']['actionType']))
					{
						$statusClass = ($value[$moduleArr['statusField']] == 1) ? 'fa-check-square-o' : 'fa-square-o';
						$actionStr.= '<a data-module="'.$moduleName.'" data-module_title="'.$moduleArr['title'].'" data-status="'.$value[$moduleArr['statusField']].'" data-id="'.$value[$moduleArr['key']].'" data-toggle="tooltip" data-original-title="Change Status for '.$moduleArr['title'].'" class="btn btn-xs btn-danger btn-wd-24 global-list-status-icon statusIcon"><span><i class="fa '.$statusClass.'" aria-hidden="true"></i></span></a>';
					}
					$actionStr.= "</div>";

					$resultData[$key][0] = $siNo++;
					foreach($moduleArr['list'] as $fieldKey => $fieldValue)
					{
						if($fieldKey == 'actionColumn')
							$resultData[$key][$fieldValue['columnNo']] = $actionStr;
						elseif($fieldValue['type'] == 'text')
							$resultData[$key][$fieldValue['columnNo']] = $value[$fieldKey];
						elseif($fieldValue['type'] == 'image')
							$resultData[$key][$fieldValue['columnNo']] = "<img src = '".base_url().$fieldValue['uploadPath'].getThumbnailName($value[$fieldKey])."' width = 180 height = 50 />";
					}
				}
			}

			$count_all = $this->db->select('count(*) as total')->get($moduleArr['dbName'])->row_array();
			return array(
				'count_all' => $count_all['total'],
				'data' => $resultData
			);
		}

		//This function is used to get the form data to show in the edit page
		function getFormData($moduleName = NULL , $id = NULL)
		{
			$moduleArr = $this->getModule($moduleName);
			return $this->db->select($this->getSelectColumn($moduleArr , 'edit'))
							->where($moduleArr['key'] , $id)
							->get($moduleArr['dbName'])->row_array();

		}

		//This function is used to return the select columns for any module (listing/add_edit page)
		private function getSelectColumn($moduleArr = NUll , $type = NULL)
		{
			$selectStr = $moduleArr['key'];
			if(isset($moduleArr['statusField']))
				$selectStr.= ','.$moduleArr['statusField'];
			if($type == 'list')
			{
				if(array_key_exists('actionColumn' , $moduleArr['list']))
					unset($moduleArr['list']['actionColumn']);
				$selectStr.= ','.implode(',' , array_keys($moduleArr['list']));
			}
			if($type == 'edit')
				$selectStr.= ','.implode(',' , array_keys($moduleArr['field']));
			return $selectStr;
		}

		//This function is used to create the form field for master modules(add/edit page)
		public function setFormField($fieldKey = NULL , $fieldValue = array() , $post = array() , $fileUploadError = array())
		{
			$fieldStr = '';
			if(!empty($fieldValue))
			{
				if($fieldValue['type'] == 'text')
				{
					$data = array(
						'name' => $fieldKey,
						'id' => $fieldKey,
						'placeholder' => isset($fieldValue['placeholder']) ? $fieldValue['placeholder'] : '',
						'class' => 'form-control',
						'value' => isset($post[$fieldKey]) ? $post[$fieldKey] : ''
					);
					$fieldStr.= form_input($data).form_error($fieldKey);
				}
				elseif($fieldValue['type'] == 'textarea')
				{
					$data = array(
						'name' => $fieldKey,
						'id' => $fieldKey,
						'class' => (isset($fieldValue['summernote']) && $fieldValue['summernote'] == 1) ? 'form-control summernote' : 'form-control',
						'value' => isset($post[$fieldKey]) ? $post[$fieldKey] : '',
						'rows' => $fieldValue['rows']
					);
					$fieldStr.= form_textarea($data).form_error($fieldKey);
					if(isset($fieldValue['summernote']) && $fieldValue['summernote'] == 1)
						$fieldStr.= '<span id="'.$fieldKey.'_descriptionErrorMessage" style="color:#ff0000"></span>';
				}
				elseif($fieldValue['type'] == 'file' && $fieldValue['fileType'] == 'image')
				{
					$fieldStr.= '<input type="hidden" name="'.$fieldKey.'_changeFlag" id="'.$fieldKey.'_changeFlag" value="1" />';
					$fieldStr.= '<input type="hidden" id="'.$fieldKey.'_widthErrorFlag" value="1" />';
					$oldImageName = isset($post[$fieldKey]) ? $post[$fieldKey] : '';
					$fieldStr.= '<input type="hidden" name="'.$fieldKey.'_oldImg" id="'.$fieldKey.'_oldImg" value="'.$oldImageName.'" />';
					$fieldStr.= '<label for="'.$fieldKey.'">';
					$imagePath = isset($post[$fieldKey]) ? base_url().$fieldValue['uploadPath'].getThumbnailName($post[$fieldKey]) : LTE.'frontweb/no_flag.jpg';
					$fieldStr.= '<img height="50" width="180" class="uploadImageProgramClass" id="'.$fieldKey.'_onChangeImage" src="'.$imagePath.'"/>';
					$fieldStr.= '</label>';
					$data = array(
						'name' => $fieldKey,
						'id' => $fieldKey,
						'type' => 'file',
						'style' => 'visibility: hidden;'
					);
					$fieldStr.= form_input($data);
					$fieldStr.= '<small style="display:block">';
					$fieldStr.= '( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to '.$fieldValue['width'].' X '.$fieldValue['height'].' pixel )';
					$errorMessage = (!empty($fileUploadError)) ? implode("<br>" , $fileUploadError) : '';
					$fieldStr.= '</small><span id="'.$fieldKey.'_customErrorMessage" style="color:#ff0000">'.$errorMessage.'</span>';
				}
			}
			return $fieldStr;
		}
	}
