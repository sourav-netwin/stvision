<?php
	class Extra_activity_model extends Model
	{
		//This is the construct
		public function __construct()
		{
			parent::__construct();
		}

		/**
		*This function is used to get the master activity details to copy the same to
		*the extra activity table
		*
		*@param NONE
		*@return Array
		*/
		public function getMaterActivityDetails()
		{
			$returnArr = array();
			$dateRange = $this->db->select('arrival_date , departure_date')
								->where('id_book' , $this->input->post('group_reference_id'))
								->get(TABLE_PLUS_BOOK)->row_array();

			$result = $this->db->select('b.date , c.program_name , c.location , c.activity , c.from_time , c.to_time , c.managed_by')
							->from(TABLE_MASTER_ACTIVITY.' a')
							->join(TABLE_FIXED_DAY_ACTIVITY.' b' , 'a.master_activity_id = b.master_activity_id' , 'left')
							->join(TABLE_FIXED_DAY_ACTIVITY_DETAILS.' c' , 'b.fixed_day_activity_id = c.fixed_day_activity_id' , 'left')
							->where("cast(b.date as DATE) between '".$dateRange['arrival_date']."' AND '".$dateRange['departure_date']."'")
							->where('a.centre_id' , $this->input->post('centre_id'))
							->where('a.student_group' , $this->input->post('student_group'))
							->order_by('cast(b.date as DATE)' , 'asc')
							->get()->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr[$value['date']][] = array(
						'program_name' => $value['program_name'],
						'location' => $value['location'],
						'activity' => $value['activity'],
						'from_time' => $value['from_time'],
						'to_time' => $value['to_time'],
						'managed_by' => $value['managed_by']
					);
			}
			return $returnArr;
		}

		/**
		*This function is used to get the extra activity details to show in the management table
		*
		*@param NONE
		*@return Array
		*/
		public function getExtraActivityDetails($id = NULL)
		{
			$post['datesArr'] = $this->db->select("extra_day_activity_id as id , date_format(date , '%d-%m-%Y') as date" , FALSE)
										->where('extra_master_activity_id' , $id)
										->order_by('cast(date as DATE)' , 'asc')
										->get(TABLE_EXTRA_DAY_ACTIVITY)->result_array();
			$post['details'] = $this->getActivityDetails($post['datesArr']);
			return $post;
		}

		/**
		*This function is used to get the activity details - date and time slot wise
		*
		*@param Array $datesArr : dates array
		*@return Array
		*/
		private function getActivityDetails($datesArr = array())
		{
			$returnArr = array();
			foreach($datesArr as $idValue)
				$idArr[] = $idValue['id'];
			$result = $this->db->select('*')
							->where_in('extra_day_activity_id' , $idArr)
							->order_by('from_time' , 'asc')
							->get(TABLE_EXTRA_DAY_ACTIVITY_DETAILS)->result_array();
			if(!empty($result))
			{
				foreach($result as $value)
					$returnArr[date('H:i' , strtotime($value['from_time'])).'-'.date('H:i' , strtotime($value['to_time']))][$value['extra_day_activity_id']] = $value;
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
			$this->db->where_in('extra_day_activity_details_id' , $this->input->post('activityIdArr'))
					->update(TABLE_EXTRA_DAY_ACTIVITY_DETAILS , $data);
		}
	}
