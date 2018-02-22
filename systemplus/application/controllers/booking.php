<?php

class booking extends Controller {
	
	function index()
	{
		
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('validation');
		
		

		$rules['username'] = "required|min_length[2]|max_length[30]";
		$rules['destination'] = "required";
		$rules['arrival'] = "required";
		$rules['departure'] = "required";
		$rules['students'] = "required";
		$rules['leaders'] = "required";
		$rules['inbound'] = "required";
		$rules['outbound'] = "required";
		$rules['nationality'] = "required";
		$rules['phone'] = "required";
		
	
		$rules['myemail'] = "required|valid_email";
		
		$this->validation->set_rules($rules);
		
		$fields['username'] = 'Username';
		$fields['destination'] = 'Destination';
		$fields['accomodation'] = 'Accomodation';
		$fields['arrival'] = 'Arrival';
		$fields['departure'] = 'Departure';
		$fields['students'] = 'Arrival';
		$fields['leaders'] = 'Departure';
		$fields['inbound'] = 'Inbound';
		$fields['outbound'] = 'Outbound';
		$fields['nationality'] = 'Nationality';
		$fields['phone'] = 'Phone Number';
		

		//$fields['passconf'] = 'Password Confirmation';
		$fields['email'] = 'Email Address';
		
		$this->validation->set_error_delimiters('<div class="error">', '</div>');

		
		$this->validation->set_fields($fields);

				
		if ($this->validation->run() == FALSE)
		{
			$this->load->view('booking_view');
		}else
		{
			
			$this->load->library('email');
			$this->email->from('plus@plus-ed.com');
			$this->email->to('stefano.galasso@hotmail.it,avni@plus-ed.com');
			$this->email->cc('s.marra@plus-ed.com');
			$this->email->subject('Booking Request');
			$this->email->message('Agent: ' . $_POST['username'] . '<br>Phone Number: ' . $_POST['phone'] . '<br>Destination ' . $_POST['destination'] . '<br>Accomodation: ' . $_POST['accomodation'] . '<br>Arrival: ' . $_POST['arrival'] . ' - Departure: ' . $_POST['departure'] . '<br>Student: ' . $_POST['students'] . '<br>Leaders: ' . $_POST['leaders'] . '<br>Nationality: ' . $_POST['nationality'] . '<br>Inbound Transfer required: ' . $_POST['inbound'] . '<br>Outbound Transfer required: ' . $_POST['outbound'] . '<br>email: ' . $_POST['myemail'] );
			$this->email->send();

			//echo $this->email->print_debugger();
			$this->load->view('successbooking');	
			
		}
		
	}	
}
?>