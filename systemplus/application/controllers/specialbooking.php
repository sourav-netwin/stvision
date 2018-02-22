<?php

/**
 * Class to control backoffice special booking
 * @since 08-March-2017
 * @author Arunsankar
 */
class Specialbooking extends Controller {

	public function __construct() {

		parent::Controller();
		$this -> load -> helper(array('url'));
		$this -> load -> model("special_booking_model");
		$this -> load -> model('mbackoffice');
	}

	/**
	 * Show special booking management UI
	 * @author Arunsankar
	 * @since 08-March-2017
	 */
	function index( $enroll_id = '' )
	{
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') == 100)
		{
			$data['title'] = "plus-ed.com | Special Booking";
			$data['breadcrumb1'] = 'Special Booking';
			$data['enroll_id'] = $enroll_id;

			if( $enroll_id != '' )
			{
				$data['breadcrumb2'] = 'Edit booking';
      			$data['enroll_details'] = $this->special_booking_model->getBookingsDetails( $enroll_id );
			}
			else
				$data['breadcrumb2'] = 'Enrol booking';

			$data["centri"] = $this -> mbackoffice -> getAllCampus(1);
			$data["accomodation"] = $this -> special_booking_model -> getAllAccomodation();

			$data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/special_booking/create_booking', $data);
		}
		else
		{
			$this -> session -> sess_destroy();
			redirect('backoffice', 'refresh');
		}
	}

	/**
	 * Enrol new special booking
	 * @author Arunsankar
	 * @since 09-March-2017
	 */
	function insertGroup( $enroll_id = '' )
	{
		if( $this->session->userdata('username') && $this->session->userdata('role') == 100 )
	    {
	    	$param_enroll_id = $enroll_id;
    		$insert_data['sb_center_id'] = $this->input->post('center_select', TRUE);
	    	$insert_data['sb_accomodation_id'] = $this->input->post('accomodation_select', TRUE);
	    	$insert_data['sb_number_of_week'] = $this->input->post('n_weeks', TRUE);
	    	$insert_data['sb_number_of_staff'] = $this->input->post('n_staff', TRUE);

    		$arr = explode("/", $this->input->post('arrival_date'));
    		$insert_data['sb_arrival_date'] = $arr[2]."-".$arr[1]."-".$arr[0] . " 00:00:00";
			$arr2 = explode("/", $this->input->post('departure_date'));
			$insert_data['sb_departure_date'] = $arr2[2]."-".$arr2[1]."-".$arr2[0] . " 00:00:00";

			$insert_data['sb_created_on'] = date('Y-m-d H:i:s');

			if( $enroll_id != '' )
	    	{
	    		// Delete data for that enroll_id from plused_special_bookings and plused_special_booking_pax table
	    		$this->special_booking_model->delete_booking( $enroll_id, $insert_data['sb_number_of_staff'] );
	    	}
	    	$enroll_id = $this->special_booking_model->enrol_special_booking( $insert_data );
			$this->special_booking_model->booked_pax( $enroll_id, $insert_data['sb_number_of_staff'] );

			if( $param_enroll_id != '' )
				$this -> session -> set_flashdata('success_message', "Special booking updated successfully");
			else
				$this -> session -> set_flashdata('success_message', "Special booking added successfully");

			redirect('specialbooking/enrolledBookings','refresh');
    	}
	    else
	    {
	      	$this->session->sess_destroy();
	      	redirect('backoffice', 'refresh');
	    }
	}

	/**
	 * List special booking
	 * @author Arunsankar
	 * @since 09-March-2017
	 */
	function enrolledBookings()
	{
		if( $this->session->userdata('username') && $this->session->userdata('role') == 100 )
		{
			$data['title']='plus-ed.com | Inserted bookings';
			$data['breadcrumb1']='Special booking';
			$data['breadcrumb2']='Inserted bookings';

			$data["all_books"] = $this->special_booking_model->getSpecialBookings();

			$data['pageHeader'] 	= $data['breadcrumb2'];
      		$data['optionalDescription'] = "";

      		$this->ltelayout->view('lte/backoffice/special_booking/enrol_booking_list', $data);
		}
		else
	    {
	      $this->session->sess_destroy();
	      redirect('backoffice','refresh');
	    }
	}

	/**
	 * List of pax for special booking
	 * @author Arunsankar
	 * @since 09-March-2017
	 */
	public function editPaxList( $id, $year )
	{
		if( $this->session->userdata('username') && $this->session->userdata('role') == 100 )
		{
			$data['title'] = 'plus-ed.com | Edit pax list';
			$data['breadcrumb1'] = 'Special booking';
			$data['booking_detail'] = $this->special_booking_model->getBookingsDetails( $id );
			$data['breadcrumb2'] = 'Pax list for Booking '.$year."_".$id;

			$data['booked_pax'] = $this->special_booking_model->getBookedPaxDetails( $data['booking_detail']['sb_id'] );

  			$this->load->view('lte/backoffice/special_booking/ajax_edit_pax',$data);
		}
		else
		{
   			redirect('backoffice','refresh');
 		}
	}

	/**
	 * Save pax details for special booking
	 * @author Arunsankar
	 * @since 09-March-2017
	 */
	public function postPax( $id )
	{
		if( $this->session->userdata('username') && $this->session->userdata('role') == 100 )
		{
			$updatePAX = $this->special_booking_model->postPax($id);
			redirect('specialbooking/enrolledBookings','refresh');
		}
		else
		{
			$this->session->sess_destroy();
   			redirect('backoffice','refresh');
 		}
	}
}