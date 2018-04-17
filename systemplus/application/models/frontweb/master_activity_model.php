<?php
	class master_activity_model extends Model
	{
		//This is the construuctor
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the master activity details to show in the activity report(Both Report and filter Dropdown)
		*
		*@param Integer $centreId : Centre id
		*@param Date $arrivalDate : The arrival date
		*@param Date $departureDate : The departure date
		*@param String $whereCondition : Where condition(for filter search)
		*@param String $fieldName : To select the unique field
		*@param Integer $filterDropdownFlag : To get the dropdown array or not
		*@return Array
		*/
		public function getActivityReport($centreId = NULL , $arrivalDate = NULL , $departureDate = NULL , $whereCondition = NULL , $fieldName = NULL , $filterDropdownFlag = NULL)
		{
			//To Create the view first
			$this->createView();

			if($fieldName != '')
				$this->db->select('distinct '.$fieldName.' as '.$fieldName , FALSE);
			$this->db->where('centre_id' , $centreId);
			$this->db->where("cast(date as DATE) between '".date('Y-m-d' , strtotime($arrivalDate))."' and '".date('Y-m-d' , strtotime($departureDate))."' ");
			if($whereCondition != '')
				$this->db->where($whereCondition);
			if($fieldName != '')
				$this->db->order_by($fieldName);
			else
				$this->db->order_by('date asc , from_time asc');
			$result = $this->db->get(ACTIVITY_REPORT_PROGRAM)->result_array();
			if($fieldName != '')
				return $result;
			$returnArr = array();
			$returnArr['details'] = $result;

			//Prepare filter dropdown through recursion
			if($filterDropdownFlag == 1)
			{
				$returnArr['dropdownArr']['groupNameValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'group_name' , $filterDropdownFlag);
				$returnArr['dropdownArr']['groupReferenceValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'group_reference' , $filterDropdownFlag);
				$returnArr['dropdownArr']['dateValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'date' , $filterDropdownFlag);
				$returnArr['dropdownArr']['programNameValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'program_name' , $filterDropdownFlag);
				$returnArr['dropdownArr']['locationValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'location' , $filterDropdownFlag);
				$returnArr['dropdownArr']['activityValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'activity' , $filterDropdownFlag);
				$returnArr['dropdownArr']['fromTimeValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'from_time' , $filterDropdownFlag);
				$returnArr['dropdownArr']['toTimeValue'] = $this->getActivityReport($centreId , $arrivalDate , $departureDate , $whereCondition , 'to_time' , $filterDropdownFlag);
				$returnArr['dropdownArr']['managedByValue'] = getContractPersonDropdown();
			}
			return $returnArr;
		}

		/**
		*This function is used to get the activity details - date and time slot wise
		*
		*@param Array $idArr : fixed activity id array
		*@return Array
		*/
		public function getActivityDetails($idArr = array())
		{
			$returnArr = array();
			$result = $this->db->select('fixed_day_activity_details_id as id , activity as name , from_time , to_time , fixed_day_activity_id')
							->where_in('fixed_day_activity_id' , $idArr)
							->order_by('from_time' , 'asc')
							->get(TABLE_FIXED_DAY_ACTIVITY_DETAILS)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr[date('H:i' , strtotime($value['from_time'])).'-'.date('H:i' , strtotime($value['to_time']))][$value['fixed_day_activity_id']][] = $value;
			}
			return $returnArr;
		}

		/**
		*This function is used to update timing for activity details
		*
		*@param NONE
		*@return NONE
		*/
		public function updateActivityTiming()
		{
			$data[$this->input->post('fieldName')] = $this->input->post('time');
			$this->db->where_in('fixed_day_activity_details_id' , $this->input->post('activityIdArr'))
					->update(TABLE_FIXED_DAY_ACTIVITY_DETAILS , $data);
		}

		/**
		*This function is used to get the student group dropdown details to show in the cop activity modal popup form
		*
		*@param NONE
		*@return NONE
		*/
		public function getCopyStudentGroup()
		{
			$masterResult = $this->db->select('centre_id , activity_name , arrival_date , departure_date')
									->where('master_activity_id' , $this->input->post('id'))
									->get(TABLE_MASTER_ACTIVITY)->row_array();
			$groupResult = $this->db->select('student_group_id , group_name')
									->where("student_group_id not in(select student_group from ".TABLE_MASTER_ACTIVITY." where centre_id='".$masterResult['centre_id']."'
											and activity_name='".$masterResult['activity_name']."' and arrival_date='".$masterResult['arrival_date']."' and departure_date =
											'".$masterResult['departure_date']."') and centre_id='".$masterResult['centre_id']."'")
									->where('delete_flag' , 0)
									->get(TABLE_STUDENT_GROUP)->result_array();
			return $groupResult;
		}

		/**
		*This function is used to create the view for activity program report
		*
		*@param NONE
		*@return NONE
		*/
		private function createView()
		{
			$sqlQuery = "CREATE OR REPLACE VIEW activity_report_program AS
						(select a.centre_id , e.group_name , NULL as group_reference , b.date , c.program_name , c.location , c.activity , c.from_time , c.to_time , d.managed_by_name
						from frontweb_master_activity a
						left join frontweb_fixed_day_activity b on a.master_activity_id=b.master_activity_id
						left join frontweb_fixed_day_activity_details c on b.fixed_day_activity_id=c.fixed_day_activity_id
						left join frontweb_fixed_day_managed_by d on c.fixed_day_activity_details_id=d.fixed_day_activity_details_id
						left join frontweb_student_group e on e.student_group_id=a.student_group
						)
						UNION
						(select a.centre_id , e.group_name , concat(id_year , '_' , id_book) as group_reference , b.date , c.program_name , c.location , c.activity , c.from_time , c.to_time , d.managed_by_name
						from frontweb_extra_master_activity a
						left join frontweb_extra_day_activity b on a.extra_master_activity_id=b.extra_master_activity_id
						left join frontweb_extra_day_activity_details c on b.extra_day_activity_id=c.extra_day_activity_id
						left join frontweb_extra_day_managed_by d on c.extra_day_activity_details_id=d.extra_day_activity_details_id
						left join frontweb_student_group e on e.student_group_id=a.student_group
						left join plused_book f on f.id_book=a.group_reference_id
						)";
			$this->db->query($sqlQuery);
		}
	}
?>