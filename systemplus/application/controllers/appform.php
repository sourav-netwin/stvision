<?php

class Appform extends Controller {

	public function __construct(){
		
		parent::Controller();
		
		$this->load->helper(array('form', 'url', 'email'));
		$this->load->library(array('form_validation','validation','email','session'));
		$this->load->model('magenti');


	}
	
	function index()
	{
		
		//redirect('/agenti/' , 'refresh');
		$data['title'] = "Summer Job  Form | " ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			$rules['nome'] = "required";
			$rules['cognome'] = "required";
			$rules['email'] = "required|valid_email";
		
			$this->validation->set_rules($rules);
		
			$fields['nome'] = 'Name';
			$fields['cognome'] = 'Surname';
			$fields['email'] = 'email';
			
			$this->validation->set_error_delimiters('<div class="error">', '</div>');
			$this->validation->set_fields($fields);

			

			if ($this->validation->run() == TRUE)
			{	
				
				
				//Prendo i campi del form da passare al model
				
				$title=$this->input->post('title');
				$nome=$this->input->post('nome');
				$cognome=$this->input->post('cognome');
				$malefemale=$this->input->post('malefemale');
				$nationality=$this->input->post('nationality');
				$email=$this->input->post('email');			
				$data = $this->Magenti->insert_one($title, $nome, $cognome, $malefemale, $nationality, $email);
				
				$data = $this->Magenti->recuperaIDbooking($email);
				$myidsegment=$data[0]['id'];
				
				redirect('appform/insertinfo_two/' . $myidsegment, 'refresh');
			}else{
				$this->load->view('bookingnew', $data);
			
			}


		

	}

function insertinfo_two(){
			
			
			$data['navlist'] = $this->MCatsjob->navcategorie();
		
			
			$rules['address'] = "required";
			$rules['towncity'] = "required";
			$rules['postcode'] = "required";
			$rules['telephone'] = "required";
			$rules['criminal'] = "required";
		
			$this->validation->set_rules($rules);
		
			$fields['address'] = 'address';
			$fields['towncity'] = 'towncity';
			$fields['postcode'] = 'postcode';
			$fields['telephone'] = 'telephone';
			$fields['criminal'] = 'criminal';
			
			$this->validation->set_error_delimiters('<div class="error">', '</div>');
			$this->validation->set_fields($fields);

			
			if ($this->validation->run() == TRUE)
			{	
				
				
				//Prendo i campi del form da passare al model
				
				$dayaddress=$this->input->post('dayaddress');
				$monthaddress=$this->input->post('monthaddress');
				$address=$this->input->post('address');
				$towncity=$this->input->post('towncity');
				$county=$this->input->post('county');
				$country=$this->input->post('country');			
				$telephone=$this->input->post('telephone');
				$mobile=$this->input->post('mobile');
				$fax=$this->input->post('fax');
				$dayworkfrom=$this->input->post('dayworkfrom');
				$monthworkfrom=$this->input->post('monthworkfrom');
				$dayworkuntil=$this->input->post('dayworkuntil');
				$monthworkuntil=$this->input->post('monthworkuntil');
				$othertime=$this->input->post('othertime');
				$dayothertime=$this->input->post('dayothertime');
				$monthothertime=$this->input->post('monthothertime');
				$dayothertimeuntil=$this->input->post('dayothertimeuntil');
				$monthothertimeuntil=$this->input->post('monthothertimeuntil');
				$workplusbefore=$this->input->post('workplusbefore');
				$commentsworkplus=$this->input->post('commentsworkplus');
				$restriction=$this->input->post('restriction');
				$criminal=$this->input->post('criminal');
				$criminalinfo=$this->input->post('criminalinfo');
				$postcode=$this->input->post('postcode');



				$data = $this->Magenti->insert_two($this->uri->segment(3),$dayaddress, $monthaddress, $address, $towncity, $county, $telephone, $mobile ,$fax ,$dayworkfrom ,$monthworkfrom ,$dayworkuntil ,$monthworkuntil ,$othertime ,$dayothertime ,$monthothertime ,$dayothertimeuntil ,$monthothertimeuntil ,$workplusbefore ,$commentsworkplus,$country,$postcode,$criminal,$criminalinfo,$restriction);
				
				redirect('/appform/insertinfo_three/' . $this->uri->segment(3), 'refresh');
			}else{
				
				$this->load->view('bookingnew1', $data);
			
			}
		
		
	}
function insertinfo_three(){
			
			$data['title'] = "Summer Job  Form | " ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			
			$rules['accomodationcentre'] = "required";
			$this->validation->set_rules($rules);	
			$fields['accomodationcentre'] = 'Accomodation';			
			$this->validation->set_error_delimiters('<div class="error">', '</div>');
			$this->validation->set_fields($fields);

			if ($this->validation->run() == TRUE)
			{
					//Prendo i campi del form precedente da passare al model
				
					$preferredposition=$this->input->post('preferredposition');
					$preferredcentre=$this->input->post('preferredcentre');
					$accomodationcentre=$this->input->post('accomodationcentre');
					$jobheld=$this->input->post('jobheld');
					$efl=$this->input->post('efl');
					$qualification=$this->input->post('qualification');			
					$teflnumber=$this->input->post('teflnumber');
					$teflprovider=$this->input->post('teflprovider');
					$hourselttesol=$this->input->post('hourselttesol');
					$hourspractice=$this->input->post('hourspractice');
					$teachinguk=$this->input->post('teachinguk');
					$teachingukdesc=$this->input->post('teachingukdesc');
					$coaching=$this->input->post('coaching');
					$coachingdesc=$this->input->post('coachingdesc');
						


					$data = $this->Magenti->insert_three($this->uri->segment(3),$preferredposition, $preferredcentre, $accomodationcentre, $jobheld, $efl, $qualification, $teflnumber ,$teflprovider ,$hourselttesol ,$hourspractice ,$teachinguk ,$teachingukdesc , $coaching, $coachingdesc);

					redirect('/appform/insertinfo_four/' . $this->uri->segment(3), 'refresh');
			}
			else
			{
				$this->load->view('bookingnew2', $data);
			}	
				
				
		
}
function insertinfo_four(){
			
			

			$data['title'] = "Summer Job  Form | " ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			$rules['firstaid'] = "required";
			$this->validation->set_rules($rules);	
			$fields['firstaid'] = 'First Aid';			
			$this->validation->set_error_delimiters('<div class="error">', '</div>');
			$this->validation->set_fields($fields);
			
			if ($this->validation->run() == TRUE)
			{
					$firstaid=$this->input->post('firstaid');
					$monthaidfrom=$this->input->post('monthaidfrom');
					$yearaidfrom=$this->input->post('yearaidfrom');
					$monthaiduntil=$this->input->post('monthaiduntil');
					$yearaiduntil=$this->input->post('yearaiduntil');
					$institute=$this->input->post('institute');			
					$recentemployer=$this->input->post('recentemployer');
					$sportcoreographer=$this->input->post('sportcoreographer');
					$sport=$this->input->post('sport');
					$interview=$this->input->post('interview');
					$personality=$this->input->post('personality');

					$data = $this->Magenti->insert_four($this->uri->segment(3),$firstaid, $monthaidfrom, $yearaidfrom, $monthaiduntil, $yearaiduntil, $institute, $recentemployer ,$sportcoreographer ,$sport ,$interview ,$personality);

					redirect('/appform/insertinfo_five/' . $this->uri->segment(3), 'refresh');
			

			}
			else
			{	
					$this->load->view('bookingnew3', $data);
			}
		
	}

function insertinfo_five(){
			

			$data['title'] = "Summer Job  Form | " ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			$this->load->helper(array('form', 'url', 'email'));
			$this->load->library('form_validation');
			$this->load->library('validation');
			
			$rules['refaddress'] = "required";
			$rules['refemail'] = "required|valid_email";
		
			$this->validation->set_rules($rules);
		
			$fields['refaddress'] = 'Address';
			$fields['refemail'] = 'email';
			
			$this->validation->set_error_delimiters('<div class="error">', '</div>');
			$this->validation->set_fields($fields);
			
			if ($this->validation->run() == TRUE)
			{	
				$refemail=$this->input->post('refemail');
				$refaddress=$this->input->post('refaddress');
				$reftown=$this->input->post('reftown');
				$refcounty=$this->input->post('refcounty');
				$refpostcode=$this->input->post('refpostcode');
				$refcountry=$this->input->post('refcountry');			
				$refphonenumber=$this->input->post('refphonenumber');
				$reffax=$this->input->post('reffax');
				
				$data= $this->Magenti->recuperaMailbooking($this->uri->segment(3));

				$emailuser = $data[0]['email'];

				$data = $this->Magenti->insert_five($this->uri->segment(3),$refemail, $refaddress, $reftown, $refcounty, $refpostcode, $refcountry, $refphonenumber ,$reffax);

				$this->load->view('successbookingnew', $data);

				//MANDO LA MAIL
				
					$mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
					$mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
					$mymessage .= "<title>Plus Educational</title></head>";
					$mymessage .= "<body>";
					$mymessage .= "<div style=\"font-family: Lucida Grande, Verdana, Sans-serif; font-size: 12px; color: #333; padding:10px\">";
					$mymessage .= "<br/><div style=\"font-family: Lucida Grande, Verdana, Sans-serif; font-size: 14px; color: #0066a8;\"><strong>Thank you for your application and interest in PLUS</strong><br/><br/></div>";
					$mymessage .=  "We have now commenced our recruitment campaign. <br/>If your application has been successful, you will be contacted to arrange a mutually convenient date and time to have a telephone interview. <br/>Successful applicants will be contacted within a week  of receipt of application. <br/>Should you wish to discuss your application further, please contact the recruitment department on +44 207 2294435. <br/>We will happy  to be of assistance. We look forward to speaking to you in the very near future.<br/> <br><br/>Welcome to Plus";
					$mymessage .= "</body></html>";
					/* Spedisco la mail */
					$this->email->from('info@plus-ed.com');
					$this->email->to($emailuser);
					$this->email->subject(' Thank you for your application and interest in PLUS');
					$this->email->message($mymessage);
					$this->email->send();


			}
			else
			{
				$this->load->view('bookingnew4', $data);
			}
			

				
			

		
	}



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */