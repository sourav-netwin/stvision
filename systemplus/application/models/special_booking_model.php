<?php

class Special_booking_model extends Model {

	function special_booking_model()
	{
		parent::Model();
	}

	function getAllAccomodation() {
		$data = array();
		$this -> db -> order_by('accom_name');
		$Q = $this -> db -> get('agnt_accommodation');
		if ($Q -> num_rows() > 0) {
			return $Q -> result_array();
		}
		return FALSE;
	}

	function enrol_special_booking( $insert_data )
  	{
    	$this->db->insert('plused_special_bookings', $insert_data);
		return $this->db->insert_id();
	}

	function booked_pax( $enroll_id, $number_of_staff )
	{
		for ( $i = 0; $i < $number_of_staff; $i++ )
		{
			$data = array(
				'sb_id' => $enroll_id
			);
			$this->db->insert('plused_special_booking_pax', $data);
		}
	}

	function getSpecialBookings()
	{
		$this->db->select("b.*, a.accom_name, c.nome_centri");
		$this->db->from("plused_special_bookings b");
		$this->db->join("centri c","c.id = b.sb_center_id");
		$this->db->join("agnt_accommodation a","a.accom_id = b.sb_accomodation_id");
		$this->db->order_by('sb_id','desc');
		$query = $this->db->get();

		return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
	}

	function getBookingsDetails( $enroll_id )
	{
		$this->db->select("b.*, a.accom_name, c.nome_centri");
		$this->db->from("plused_special_bookings b");
		$this->db->join("centri c","c.id = b.sb_center_id");
		$this->db->join("agnt_accommodation a","a.accom_id = b.sb_accomodation_id");
		$this->db->where('sb_id',$enroll_id);
		$this->db->limit(1);
		$query = $this->db->get();

		return ( $query->num_rows() > 0 ) ? $query->row_array() : array();
	}

	function delete_booking( $enroll_id, $staff_person )
	{
		$this->db->where('sb_id', $enroll_id);
		$this->db->delete('plused_special_bookings');

		$this->db->where('sb_id', $enroll_id);
		$this->db->delete('plused_special_booking_pax');
	}

	function getBookedPaxDetails( $enroll_id )
	{
		$this->db->select("b.*, p.*, a.accom_name, c.nome_centri");
		$this->db->from("plused_special_bookings b");
		$this->db->join("plused_special_booking_pax p","p.sb_id = b.sb_id");
		$this->db->join("centri c","c.id = b.sb_center_id");
		$this->db->join("agnt_accommodation a","a.accom_id = b.sb_accomodation_id");
		$this->db->where('b.sb_id', $enroll_id);
		$this->db->order_by('b.sb_id','desc');
		$query = $this->db->get();

		return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
	}

	function postPax( $id )
	{
		if( $id == "" )
		{
			echo "NO ID";
			die();
		}
		foreach ( $_POST as $key => $value )
		{
			$booked_pax_details = explode("__",$key);
			$booked_pax_id = $booked_pax_details[1];
			$field = $booked_pax_details[0];
			$okValue = $value;

			if( $field == "sb_pax_dob" )
			{
				if( $value )
				{
					$expData = explode("/",$value);
					$okValue = $expData[2]."-".$expData[1]."-".$expData[0];
				}
				else
				{
					$okValue = NULL;
				}

			}
			$this->db->where('sb_pax_id', $booked_pax_id);
			$this->db->where('sb_id', $id);
			$this->db->update('plused_special_booking_pax', array( $field => $okValue ));
		}
	}
}