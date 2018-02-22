<?php
class Agent_roster_model extends Model {

	function agent_roster_model()
	{
		parent::Model();
	}

	function checkPaxLock( $enroll_id, $year )
	{
		$this->db->select('count(*) as count');
		$this->db->from('agnt_enrol_bookings');
		$this->db->where('enroll_id', $enroll_id);
		$this->db->where('YEAR(enrol_created_on)', $year);
		$this->db->where('enrol_lock_pax', 1);
		$this->db->limit(1);
		$query = $this->db->get();
		if( $query->num_rows() > 0 )
			return ( $query->row()->count > 0 ) ? TRUE : FALSE;
		else
			return FALSE;
	}

	function checkAgentOrder( $agent, $enroll_id )
	{
		$this->db->select('enroll_id');
		$this->db->from('agnt_enrol_bookings');
		$this->db->where('enroll_id', $enroll_id);
		$this->db->where('enrol_created_by', $agent);
		$this->db->limit(1);
		$query = $this->db->get();
		return ( $query->num_rows() > 0 ) ? TRUE : FALSE;
	}

	function getBookedPaxDetails( $enroll_id, $locked_check = 0 )
	{
		$this->db->select('b.*, a.accom_name as gl_accom_name, c.pcomp_week, ct.courses_type_id, ct.courses_type, acc.accom_name, act.act_id, act.act_activity_name, n.nat_id');
		$this->db->from('agnt_booked_pax b');
		$this->db->join('agnt_enrol_bookings ab', 'ab.enroll_id = b.booked_enroll_id');
		$this->db->join('agnt_package_compositions c', 'c.pcomp_id = b.booked_package_composition', 'left');
		$this->db->join('agnt_accommodation a', 'a.accom_id = b.booked_package_accomodation', 'left');
		$this->db->join('agnt_courses_type ct', 'ct.courses_type_id = c.pcomp_course_type_id', 'left');
		$this->db->join('agnt_accommodation acc', 'acc.accom_id = c.pcomp_accom_id', 'left');
		$this->db->join('agnt_activities act', 'act.act_id = c.pcomp_activity_id', 'left');
		$this->db->join('plused_nationality as n', 'n.nationality=b.booked_pax_nationality', 'left');
		$this->db->where('b.booked_enroll_id', $enroll_id);
		if( $locked_check == 1 )
		{
			$where_cond = "( booked_lock_pax = '1' OR ab.enrol_lock_pax = '1' )";
			$this->db->where($where_cond);
		}

		$query = $this->db->get();
		return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
	}

	function getCourses()
	{
		$this->db->select('*');
		$this->db->from('agnt_courses_type');
		$query = $this->db->get();
		return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
	}

	function getActivities()
	{
		$this->db->select('*');
		$this->db->from('agnt_activities');
		$query = $this->db->get();
		return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
	}

	function getLockPaxByBookId( $id )
	{
		$this->db->select('enrol_lock_pax');
		$this->db->from('agnt_enrol_bookings');
		$this->db->where('enroll_id', $id);
		$query = $this->db->get();
		return ( $query->num_rows() > 0 ) ? $query->row()->enrol_lock_pax : 0;
	}

	function postPax( $id )
	{
		if( $id == "" )
		{
			echo "NO ID";
			die();
		}
		if( $_POST["noChanges"] == "SEND" )
		{
			$this->db->where('enroll_id', $id);
			$this->db->update('agnt_enrol_bookings', array( 'enrol_lock_pax' => 1 ));
		}
		$data = array(
							'booked_pax_transfer_in' => 0,
							'booked_pax_transfer_out' => 0,
							'booked_pax_visa' => 0
						);
		$this->db->where('booked_enroll_id', $id);
		$this->db->update('agnt_booked_pax', $data);

		foreach ( $_POST as $key => $value )
		{
			if( $key != "noChanges" )
			{
				if( $value )
				{
					$booked_pax_details = explode("__",$key);
					$booked_pax_id = $booked_pax_details[1];
					$field = $booked_pax_details[0];
					$okValue = $value;

					if( $field == "booked_pax_campus_arrival_date" || $field == "booked_pax_campus_departure_date" || $field == "booked_pax_dob" )
					{
						$expData = explode("/",$value);
						$okValue = $expData[2]."-".$expData[1]."-".$expData[0];
					}
					if( $field == "booked_pax_arrival_flight_date" || $field == "booked_pax_departure_flight_date" )
					{
						$expDataT = explode(" ",$value);
						$expData = explode("/",$expDataT[0]);
						$okValue = $expData[2]."-".$expData[1]."-".$expData[0];
						$campoOra = ( $field == "booked_pax_arrival_flight_date" ) ? "ora_arrivo_volo__".$booked_pax_id : "ora_partenza_volo__".$booked_pax_id;
						$okValue .= " ".$_POST[$campoOra];
					}
					if( $field == "booked_pax_transfer_in" || $field == "booked_pax_transfer_out" || $field == "booked_pax_visa" )
					{
						$okValue = 1;
					}
					if( $field != "ora_arrivo_volo" && $field != "ora_partenza_volo" && $field != "suppl" )
					{
						$this->db->where('booked_pax_id', $booked_pax_id);
						$this->db->where('booked_enroll_id', $id);
						$this->db->update('agnt_booked_pax', array( $field => $okValue ));
					}
				}
			}
		}
	}

	function checkPaxIsValid( $pax_id, $enroll_id )
	{
		$this->db->select('booked_pax_id');
		$this->db->from('agnt_booked_pax');
		$this->db->where('booked_pax_id', $pax_id);
		$this->db->where('booked_enroll_id', $enroll_id);
		$query = $this->db->get();

		return ( $query->num_rows() > 0 ) ? TRUE : FALSE;
	}

	function checkPaxIsLocked( $pax_id )
	{
		$this->db->select('booked_pax_id');
		$this->db->from('agnt_booked_pax');
		$this->db->where('booked_pax_id', $pax_id);
		$this->db->where('booked_lock_pax', 1);
		$this->db->limit(1);
		$query = $this->db->get();

		return ( $query->num_rows() > 0 ) ? FALSE : TRUE;
	}

	function getImportPaxCount($pax_id)
	{
		$this->db->select('booked_pax_id');
		$this->db->from('agnt_booked_pax');
		$this->db->where('booked_pax_id', $pax_id);
		$query = $this->db->get();

		return ( $query->num_rows() > 0 ) ? TRUE : FALSE;
	}

	function updatePaxImport( $sheetVal )
	{
		$data = array(
			'booked_pax_surname' => $sheetVal[1],
			'booked_pax_name' => $sheetVal[2],
			'booked_pax_gender' => $sheetVal[3],
			'booked_pax_dob' => $sheetVal[4],
			'booked_pax_nationality' => $sheetVal[7],
			'booked_pax_passport_no' => $sheetVal[9],
			'booked_pax_salute' => $sheetVal[10],
			'booked_pax_share_room' => $sheetVal[11],
			'booked_pax_gl_rif' => $sheetVal[12]
		);
		$this->db->where('booked_pax_id', $sheetVal[13]);
		$isUpdate = $this->db->update('agnt_booked_pax', $data);
		return ( $isUpdate ) ? TRUE : FALSE;
	}

	function getBookingAgentDetails( $enroll_id )
	{
		$this->db->select("a.businesstelephone, a.businesscountry, a.businessname, a.businessaddress, a.businesscity, a.businesscountry, a.mainfirstname, a.mainfamilyname, a.email");
		$this->db->from("agenti a");
		$this->db->join("agnt_enrol_bookings b","b.enrol_created_by = a.id");
		$this->db->where("b.enroll_id",$enroll_id);
		$this->db->limit(1);
		$query = $this->db->get();

		return ( $query->num_rows() > 0 ) ? $query->row_array() : array();
	}

	function getBookingId( $pax_id )
	{
		$this->db->select('booked_enroll_id');
		$this->db->from('agnt_booked_pax');
		$this->db->where('booked_pax_id', $pax_id);
		$this->db->limit(1);
		$query = $this->db->get();

		return ( $query->num_rows() > 0 ) ? $query->row()->booked_enroll_id : FALSE;
	}

	function lockSingleRoster($pax_id)
	{
		$this->db->select('count(*) as count');
		$this->db->from('agnt_booked_pax');
		$this->db->where('(booked_pax_id IS NOT NULL AND booked_pax_id != \'\')');
		$this->db->where('(	booked_enroll_id IS NOT NULL AND 	booked_enroll_id != \'\')');
		$this->db->where('(booked_pax_surname IS NOT NULL AND booked_pax_surname != \'\')');
		$this->db->where('(booked_pax_name IS NOT NULL AND booked_pax_name != \'\')');
		$this->db->where('(booked_pax_gender IS NOT NULL AND booked_pax_gender != \'\')');
		$this->db->where('(booked_pax_passport_no IS NOT NULL AND booked_pax_passport_no != \'\')');
		$this->db->where('(booked_tipo_pax IS NOT NULL AND booked_tipo_pax != \'\')');
		$this->db->where('(booked_pax_dob IS NOT NULL AND booked_pax_dob != \'\')');
		$this->db->where('(booked_pax_arrival_flight_date IS NOT NULL AND booked_pax_arrival_flight_date != \'\')');
		$this->db->where('(booked_pax_departure_arrival_airport IS NOT NULL AND booked_pax_departure_arrival_airport != \'\')');
		$this->db->where('(booked_pax_arrival_airport IS NOT NULL AND booked_pax_arrival_airport != \'\')');
		$this->db->where('(booked_pax_arrival_flight_number IS NOT NULL AND booked_pax_arrival_flight_number != \'\')');
		$this->db->where('(booked_pax_departure_flight_date IS NOT NULL AND booked_pax_departure_flight_date != \'\')');
		$this->db->where('(booked_pax_departure_airport IS NOT NULL AND booked_pax_departure_airport != \'\')');
		$this->db->where('(booked_pax_arrival_departure_airport IS NOT NULL AND booked_pax_arrival_departure_airport != \'\')');
		$this->db->where('(booked_pax_departure_flight_number IS NOT NULL AND booked_pax_departure_flight_number != \'\')');
		$this->db->where('(booked_pax_campus_arrival_date IS NOT NULL AND booked_pax_campus_arrival_date != \'\')');
		$this->db->where('(booked_pax_campus_departure_date IS NOT NULL AND booked_pax_campus_departure_date != \'\')');
		$this->db->where('booked_pax_id', $pax_id);
		$result = $this->db->get();

		if ($result->num_rows() > 0)
		{
			$resultArray = $result->result_array();
			if ($resultArray[0]['count'] > 0)
			{
				$data = array( 'booked_lock_pax' => 1 );
				$this->db->where('booked_pax_id', $pax_id);
				if ($this->db->update('agnt_booked_pax', $data))
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return '2';
			}
		}
		else
		{
			return '2';
		}
	}

	function getCompletePaxCount($enroll_id)
	{
		$this->db->select('booked_pax_id');
		$this->db->from('agnt_booked_pax');
		$this->db->where('(booked_pax_id IS NOT NULL AND booked_pax_id != \'\')');
		$this->db->where('(	booked_enroll_id IS NOT NULL AND 	booked_enroll_id != \'\')');
		$this->db->where('(booked_pax_surname IS NOT NULL AND booked_pax_surname != \'\')');
		$this->db->where('(booked_pax_name IS NOT NULL AND booked_pax_name != \'\')');
		$this->db->where('(booked_pax_gender IS NOT NULL AND booked_pax_gender != \'\')');
		$this->db->where('(booked_pax_passport_no IS NOT NULL AND booked_pax_passport_no != \'\')');
		$this->db->where('(booked_tipo_pax IS NOT NULL AND booked_tipo_pax != \'\')');
		$this->db->where('(booked_pax_dob IS NOT NULL AND booked_pax_dob != \'\')');
		$this->db->where('(booked_pax_arrival_flight_date IS NOT NULL AND booked_pax_arrival_flight_date != \'\')');
		$this->db->where('(booked_pax_departure_arrival_airport IS NOT NULL AND booked_pax_departure_arrival_airport != \'\')');
		$this->db->where('(booked_pax_arrival_airport IS NOT NULL AND booked_pax_arrival_airport != \'\')');
		$this->db->where('(booked_pax_arrival_flight_number IS NOT NULL AND booked_pax_arrival_flight_number != \'\')');
		$this->db->where('(booked_pax_departure_flight_date IS NOT NULL AND booked_pax_departure_flight_date != \'\')');
		$this->db->where('(booked_pax_departure_airport IS NOT NULL AND booked_pax_departure_airport != \'\')');
		$this->db->where('(booked_pax_arrival_departure_airport IS NOT NULL AND booked_pax_arrival_departure_airport != \'\')');
		$this->db->where('(booked_pax_departure_flight_number IS NOT NULL AND booked_pax_departure_flight_number != \'\')');
		$this->db->where('(booked_pax_campus_arrival_date IS NOT NULL AND booked_pax_campus_arrival_date != \'\')');
		$this->db->where('(booked_pax_campus_departure_date IS NOT NULL AND booked_pax_campus_departure_date != \'\')');
		$this->db->where('booked_enroll_id', $enroll_id);
		$query = $this->db->get();

		return $query->num_rows();
	}

	function lockWholeRoster( $enroll_id )
	{
		$this->db->where('enroll_id', $enroll_id);
		$this->db->update('agnt_enrol_bookings', array( 'enrol_lock_pax' => 1, 'enrol_download_visa' => 1 ));
	}

	function getPaxDetails( $pax_id )
	{
		$this->db->select('*');
		$this->db->from('agnt_booked_pax');
		$this->db->where('booked_pax_id', $pax_id);
		$this->db->limit(1);
		$query = $this->db->get();

		return ( $query->num_rows() > 0 ) ? $query->row_array() : array();
	}

	function get_template( $booking_id, $pax_id )
	{
		$this->db->select('c.template');
 		$this->db->from("agnt_enrol_bookings a");
 		$this->db->join("agnt_booked_pax b","b.booked_enroll_id = a.enroll_id");
 		$this->db->join("agnt_packages p","p.pack_package_id = a.enrol_package_id");
 		$this->db->join("plused_temp_campus c","c.centri_id = p.pack_campus_id");
 		$this->db->join("plused_temp_nationality tn", "tn.template = c.template");
 		$this->db->join("plused_nationality n","n.nat_id = tn.nat_id");
		$this->db->where("a.enroll_id",$booking_id);
		$this->db->where("b.booked_pax_id",$pax_id);
		$this->db->where("b.booked_pax_nationality = n.nationality");

		$this->db->limit(1);
		$query = $this->db->get();

		return ( $query->num_rows() > 0 ) ? $query->row()->template : '';
	}

	function lockTemplate($pax_id, $template_value)
	{
		$data = array(
			'booked_template' => $template_value,
			'booked_template_date' => date('Y-m-d H:i:s')
		);
		$where = array(
			'booked_pax_id' => $pax_id,
			'booked_template' => NULL
		);
		$this->db->where($where);
		$isUpdate = $this->db->update('agnt_booked_pax', $data);
		return ( $isUpdate ) ? TRUE : FALSE;
	}

	function checkAnyPaxLocked( $enroll_id )
	{
		$this->db->select('count(*) as count');
		$this->db->from('agnt_enrol_bookings');
		$this->db->where('enroll_id', $enroll_id);
		$this->db->where('enrol_lock_pax', '1');
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			$resultArray = $result->result_array();
			if($resultArray[0]['count'] > 0)
			{
				return TRUE;
			}
			else
			{
				$this->db->select('count(*) as count');
				$this->db->from('agnt_booked_pax');
				$this->db->where('booked_enroll_id', $enroll_id);
				$this->db->where('booked_lock_pax', '1');
				$result = $this->db->get();
				if($result->num_rows() > 0)
				{
					$resultArray = $result->result_array();
					if($resultArray[0]['count'] > 0)
					{
						return TRUE;
					}
					else
					{
						return FALSE;
					}
				}
				else
				{
					return FALSE;
				}
			}
		}
		else
		{
			return FALSE;
		}
	}

	function lockTemplates( $enroll_id, $rowArr, $iniTmpl = NULL)
	{
		foreach($rowArr as $row)
		{
			$rowVal = explode('-', $row);
			if($rowVal[1])
			{
				$data = array(
					'booked_template' => $rowVal[1],
					'booked_template_date' => date('Y-m-d H:i:s')
				);
				$where = array(
					'booked_pax_id' => $rowVal[0]
				);
				$this->db->where($where);
				$isUpdate = $this->db->update('agnt_booked_pax', $data);
			}
		}
		if($iniTmpl != '')
		{
			$data = array(
				'enrol_template' => $iniTmpl,
				'enrol_template_date' => date('Y-m-d H:i:s')
			);
			$where = array(
				'enroll_id' => $enroll_id
			);
			$isUpdate = $this->db->update('agnt_enrol_bookings', $data);
		}
		if ($isUpdate) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function checkBookTemplate($enroll_id, $template)
	{
		$this->db->select('enroll_id');
		$this->db->from('agnt_enrol_bookings');
		$this->db->where('enroll_id', $enroll_id);
		$this->db->where('enrol_template', $template);
		$this->db->where('enrol_lock_pax', 1);
		$query = $this->db->get();

		return ( $query->num_rows() > 0 ) ? TRUE : FALSE;
	}

	function listPax ( $enroll_id, $type = "GL", $locked = NULL )
	{
		$data = array();
		$locked == 1 ? $this->db->where('booked_lock_pax', 1) : '';
		$this->db->select('booked_pax_id, booked_pax_name, booked_pax_surname, booked_pax_gender, booked_pax_dob, booked_pax_passport_no, booked_template, booked_template_date');
		$this->db->from('agnt_booked_pax');
		$this->db->where('booked_enroll_id', $enroll_id);
		$this->db->where('booked_tipo_pax', $type);
		$this->db->order_by("booked_pax_gl_rif", "asc");
		$this->db->order_by("booked_tipo_pax", "asc");
		$this->db->order_by("booked_pax_surname", "asc");
		$query = $this->db->get();
		return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
	}

	/**
	 * Fucntion to cross check the nationality, campus and pax
	 * @author Arunsankar
	 * @param type $bookId
	 * @param type $template
	 * @param type $id
	 * @return boolean
	 */
	function checkNationality($bookId, $template, $id){
		$nationality = '';
		$natId = '';
		$this -> db -> select('booked_pax_nationality')
				-> from('agnt_booked_pax')
				-> where('booked_pax_id', $id);
		$result = $this -> db -> get();
		if($result -> num_rows() > 0){
			$resultArray = $result -> result_array();
			$nationality = $resultArray[0]['booked_pax_nationality'];
		}
		if($nationality){
			$this -> db -> select('nat_id')
					-> from('plused_nationality')
					-> where('nationality', $nationality);
			$result = $this -> db -> get();
			if($result -> num_rows() > 0){
				$resultArray = $result -> result_array();
				$natId = $resultArray[0]['nat_id'];
			}
		}
		$this -> db -> select('p.pack_campus_id')
				-> from('agnt_enrol_bookings a')
				-> join('agnt_packages p','p.pack_package_id = a.enrol_package_id')
				-> where('enroll_id', $bookId);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			$this -> db -> select('template')
					-> from('plused_temp_campus')
					-> where('centri_id', $resultArray[0]['pack_campus_id'])
					-> where('template', $template);
			$result = $this -> db -> get();
			if ($result -> num_rows() > 0) {
				$resultArray = $result -> result_array();
				$this -> db -> select('count(*) as count')
						-> from('plused_temp_nationality')
						-> where('nat_id', $natId)
						-> where('template', $resultArray[0]['template']);
				$result = $this -> db -> get();
				if ($result -> num_rows() > 0) {
					$resultArray = $result -> result_array();
					if ($resultArray[0]['count'] > 0) {
						return TRUE;
					}
					else {
						return FALSE;
					}
				}
				else {
					return FALSE;
				}
			}
			else {
				return FALSE;
			}
		}
		else {
			return FALSE;
		}
	}
}