<?php

   class gestione  extends Controller {
		
		function gestione(){
			
			parent::Controller();
			$this->load->helper(array('form', 'url', 'email', 'security', 'date'));
			$this->load->model('m_gestione');	
			$this->load->library(array('session','email'));
			session_start();
				
		}


		function index()
		{
		
			$data['title']="Login";
			$data['heading'] ="Job Administrator";
			
			$data['info'] = "Insert Your credentials";
			
			//$data['getcv'] = $this->mcms->getAllCv();
			
			
			// SE L'UTENTE E' GIA LOGGATO
		if($this->session->userdata('username'))
		{
			redirect('gestione/panelfilter','refresh');
		}
		else
		{
			

			// Login
			$user=$this->input->post('user');
			$password=$this->input->post('password');
	
			if($this->input->post('user') && $this->input->post('password') ){
				if($user == "admin" && $password == "smarra" || $user == "editor" && $password == "editor" ){
				$newdata = array(
                   'username'=>$user,
                   'password'=>$password,
                   'logged_in' => TRUE
               );
				
						$this->session->set_userdata($newdata);
					
						redirect('gestione/panelfilter','refresh');
				}else{
					$data['info'] = "User or Password wrong";
					$this->load->view('gestione_login_view', $data);
				}
	
			}
			else
			{
			$data['info'] = "Insert User and Password";
			$this->load->view('gestione_login_view', $data);
		}

	}

}

function panelfilter(){
				$data['title']="Find Candidate for filter";
				$data['heading'] = "Administrator Panel";
				$data['info'] = "Search by status";

				$this->load->view('gestione_find_agenti', $data);
				 

}
function filter(){		
			
		

			if($this->session->userdata('username')){
				$data['title']="Find Candidate for filter";
				$data['heading'] ="Administrator Panel";
				
				//Prendo i campi del form da passare al model
				/*
				$fstatus=$this->input->post('status');
				$fcentre=$this->input->post('preferredcentre');
				$fposition=$this->input->post('preferredposition');
				$fmonthfrom=$this->input->post('monthworkfrom');
				$accomodationcentre=$this->input->post('accomodationcentre');
				$workplusbefore=$this->input->post('workplusbefore');
				$towncity=$this->input->post('towncity');
				*/
				$businessname=$this->input->post('businessname');
				//$datainsert=$this->input->post('datainsert');

				//echo $fstatus ." - " . $fcentre ." - ". $fposition;
				$data['getagente'] = $this->m_gestione->getby($businessname);
				$this->load->view('gestione_admin_view', $data);
			}
}
		
function findcandidate(){

			
			if($this->session->userdata('username')){
			$data['title']="Find Candidate";
			$data['heading'] ="Administrator Panel";
			
			$data['getcandidate'] = $this->mcms->getCandidate($this->uri->segment(3));
			$this->load->view('candidate_view', $data);
			}else{
			
				redirect('cms','refresh');
			}
		}
function Deletjob(){
			$data['title']="DeleteJob";
			$data['heading'] ="Delete Job";
			
			$data['getcandidate'] = $this->mcms->Deljob($this->uri->segment(3));
			$this->load->view('cmssuccess', $data);
		}

function ViewProfile(){
			if($this->session->userdata('username')){
			$data['title']="View Profiles";
			$data['heading'] ="View Profile";
			
			$data['getcandidate'] = $this->mcms->ViewProfile($this->uri->segment(3));
				if($this->session->userdata('username')=="editor"){
					$this->load->view('profile_view_editor', $data);
				}else{
					//Contratti multipli 
					if($data['getcandidate'][0]['multiplo']==1){
						$data['multiplo'] = $this->mcms->Multiplo($this->uri->segment(3));
					}else{
						$data['multiplo'] ="";
					}
					$this->load->view('profile_view_new', $data);
				}
			}
			else
			{
			redirect('cms','refresh');
			}
}
function EditMultiple(){
			if($this->session->userdata('username')){
			$data['title']="View Profiles";
			$data['heading'] ="View Profile";
			
			$data['getcandidate_multiplo'] = $this->mcms->MultiploEdit($this->uri->segment(3));
				if($this->session->userdata('username')=="editor"){
					$this->load->view('profile_view_editor', $data);
				}else{
					//Contratti multipli editing
					
					$this->load->view('profile_multiple_edit', $data);
				}
			}
			else
			{
			redirect('cms','refresh');
			}
}

function CreateMultiple(){
			if($this->session->userdata('username')){
			$data['title']="View Profiles";
			$data['heading'] ="View Profile";
			
			$data['getcandidate_multiplo'] = array(0 => array("id_personal"=>$this->uri->segment(3),"date_start"=>"0000-00-00","date_end"=>"0000-00-00","center_def"=>"","salary"=>"0"));
			
				if($this->session->userdata('username')=="editor"){
					$this->load->view('profile_view_editor', $data);
				}else{
					//Contratti multipli editing
					
					$this->load->view('profile_multiple_create', $data);
				}
			}
			else
			{
			redirect('cms','refresh');
			}
}
function create_mcontract(){
			$data['title']="Update Candidate";
			$data['heading'] ="Update";
			$data['status'] ="OK SUCCESSFULLY TRASMITTED!";
			$this->mcms->create_mcontract($this->uri->segment(3));
			$data['id']=$this->uri->segment(3);
			$this->load->view('cmssuccess_mcontract', $data);
}
function update_candidate(){
			$data['title']="Update Candidate";
			$data['heading'] ="Update";
			$data['status'] ="OK SUCCESSFULLY TRASMITTED!";
			$this->mcms->update_candidate($this->uri->segment(3));
			$data['id']=$this->uri->segment(3);
			$this->load->view('cmssuccess_mcontract', $data);
		}
function update_mcontract(){
			$data['title']="Update Candidate";
			$data['heading'] ="Update";
			$data['status'] ="OK SUCCESSFULLY TRASMITTED!";
			$this->mcms->update_mcontract($this->uri->segment(3));
			$torna=$_POST['id_agent']; 
			$data['id']=$this->uri->segment(3);
			redirect('cms/viewprofile/'.$torna,'refresh');
			//$this->load->view('cmssuccess_mcontract', $data);
		}
function del_mcontract(){
			
			$this->mcms->Delmcontract($this->uri->segment(3));
			redirect('cms/viewprofile/'.$this->uri->segment(4),'refresh');
}

function delete_candidate(){
			
			$this->mcms->DelProfile($this->uri->segment(3));
			redirect('cms','refresh');
		}

function panel_candidate(){
			$data['title']="Admin Candidate";
			$data['heading'] ="Update";
			$data['status'] ="Admin Your Candidate";
//			$this->mcms->update_candidate($this->uri->segment(3));
			$data['id']=$this->uri->segment(3);
			$this->load->view('cmssuccess', $data);
		}
function contract(){
			
			$data['title']="Document";
			$data['heading'] ="Generate Document";
			
			$data['getcandidate'] = $this->mcms->Contract($this->uri->segment(3));
			//$data['getcandidate_multiplo'] = $this->mcms->Multiplo($this->uri->segment(3));
			//print_r($data['getcandidate_multiplo']);
			/*
				$data['getcandidate'] = $this->mcms->Contract($this->uri->segment(3));
					
					echo "<pre>";
					print_r($data['getcandidate']);
					echo "</pre>";
					*/

					$mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
					$mymessage .= "<html><html><head>";
					$mymessage .= "<title>Plus educational Summer Job</title></head>";
					$mymessage .= "<body><img src=\"http://www.plus-ed.com/apps/images/up_contract.jpg\">";
					$mymessage .= "<div style=\"font-family: Lucida Grande, Verdana, Sans-serif; font-size: 11px; color: #4F5155; padding:10px\">";
					$mymessage .= "<br/> Dear ".$data['getcandidate'][0]['nome']. "&nbsp;" . $data['getcandidate'][0]['cognome'] . ", <br/>";
					$mymessage .= "1). Please prepare your sort code and account number and your national insurance number.<br/> 2). Log in by clicking <a href=\"http://www.plus-ed.com/apps/index.php/personalpage\">www.plus-ed.com/apps/index.php/personalpage.</a> and inserting the email address you put on the application form.<br/>3). Please read the terms and conditions and the contract.<br>";
					$mymessage .= "4). If you accept the contract please print it and return a signed copy by email, fax or post to the following address.";
					$mymessage.= "For Teachers - Assistant Course Directors - Course Directors:<br>";
					$mymessage.= "<strong>Email</strong>:dos@plus-ed.com<br><strong> Fax:</strong>44 (0)20 7792 8717 <br><strong>Postal Address:</strong> PLUS Ltd Operations Dept, 8 Celbridge Mews, London W2 6EU<br><br>";
					$mymessage.= "The contract will become void if not returned within 4 working days.<br/>";
					$mymessage.= "5). In order to allow us to pay you in a fast and safe way please click the link at the bottom to go to the next page and insert your bank and National Insurance Number details.  This process is strictly confidential and secure.<br>";
					$mymessage.= "6).Please upload the requested files.<br/>";
					$mymessage.= "7). Save all your details  by pressing send button. <br/>";
					$mymessage.= "We look forward to working with you this summer.<br>";
					$mymessage.= "<br><br>Yours,<br><br>PLUS Ltd";
					$mymessage .= "</body></html>";

					
					$this->email->from('plus@plus-ed.com');
					$this->email->to($data['getcandidate'][0]['email']);
					$this->email->subject('CONTRACT OF EMPLOYMENT');
					$this->email->message($mymessage);

					//echo $mymessage;
					$this->email->send();
					//echo $this->email->print_debugger();


			/* Send a mail to contact/
			
					$this->email->from('plus@plus-ed.com');
					$this->email->to($data['getcandidate'][0]['email']);
					$this->email->subject('CONTRACT OF EMPLOYMENT');
					
					$mymessage = "I am pleased to confirm your employment";
					$mymessage .="To view term and condition paste this link: ";
					$mymessage .= base_url() . 'index.php/personalpage/';
					
					$this->email->send($mymessage);
					//echo $this->email->print_debugger();
			
			 */

			$this->load->view('cmscontract', $data);
			$this->mcms->update_status($this->uri->segment(3));
		}
	
function insertjob(){
		$data['title']="Insert Job";
		$data['heading'] ="Administrator Panel";
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('validation');
		
		

		$rules['typeofjob'] = "required";
		$rules['ncandidate'] = "required";
		$rules['nation'] = "required";
		

		
		$this->validation->set_rules($rules);
		
		$fields['typeofjob'] = 'Username';
		$fields['ncandidate'] = 'Password';
		$fields['nation'] = 'Password Confirmation';
		$fields['location'] = 'Location';
		
		$this->validation->set_error_delimiters('<div class="error">', '</div>');

		
		$this->validation->set_fields($fields);

				
		if ($this->validation->run() == FALSE)
		{
				$this->load->view('insert_job_view', $data);
		}else
		{

			//Prendo il valore di parentid per assegnare il nome della categories
			$data = array(
               '1' => 'Teaching',
               '2' => 'Marketing',
               '3' => 'Summerjob',
			   '4' => 'operation',
			   '5' => 'Finance',
			   '7' => 'Sales'
			);
			
			$mtcategories=$data[$_POST['categories']];
			
			$this->mcms->addJob($mtcategories);
			$this->load->view('cmssuccess', $data);
			
		}
		
	}

function sendcontract(){

		/* Send a mail to contact */
					$data['getcandidate'] = $this->mcms->Contract($this->uri->segment(3));
					/*
					echo "<pre>";
					print_r($data);
					echo "</pre>";
					*/
					$mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
					$mymessage .= "<html><html><head>";
					$mymessage .= "<title>Plus educational Summer Job</title></head>";
					$mymessage .= "<body><img src=\"http://www.plus-ed.com/apps/images/up_contract.jpg\">";
					$mymessage .= "<div style=\"font-family: Lucida Grande, Verdana, Sans-serif; font-size: 11px; color: #4F5155; padding:10px\">";
					$mymessage .= "<br/> Dear ".$data['getcandidate'][0]['nome']. "&nbsp;" . $data['getcandidate'][0]['cognome'] . ", <br/>Please find attached a copy of your contract and terms and conditions for your employment with PLUS this summer available by clicking the link http://www.plus-ed.com/apps/Personal Page. <br>But before you click the link please read and follow the steps below: <br/>";
					$mymessage .= "1). Please prepare your sort code and account number and your national insurance number.<br/> 2). Log in by clicking http://www.plus-ed.com/apps/Personal Page and inserting the email address you put on the application form.<br/>3). Please read the terms and conditions and the contract.<br>";
					$mymessage .= "4). If you accept the contract please print it and return a signed copy by email, fax or post to the following address.";
					$mymessage.= "For Teachers - Assistant Course Directors - Course Directors:<br>";
					$mymessage.= "<strong>Email</strong>:dos@plus-ed.com<br><strong> Fax:</strong>44 (0)20 7792 8717 <br><strong>Postal Address:</strong> PLUS Ltd Operations Dept, 8 Celbridge Mews, London W2 6EU<br><br>";
					$mymessage.= "The contract will become void if not returned within 4 working days.<br/>";
					$mymessage.= "5). In order to allow us to pay you in a fast and safe way please click the link at the bottom to go to the next page and insert your bank and National Insurance Number details.  This process is strictly confidential and secure.<br>";
					$mymessage.= "6).Please upload the requested files.<br/>";
					$mymessage.= "7). Save all your details  by pressing send button. <br/>";
					$mymessage.= "We look forward to working with you this summer.<br>";
					$mymessage.= "<br><br>Yours,<br><br>PLUS Ltd";
					$mymessage .= "</body></html>";

					echo "- " . $data['getcandidate'][0]['email'];
					
					$this->email->from('plus@plus-ed.com');
					$this->email->to($data['getcandidate'][0]['email']);
					$this->email->subject('CONTRACT OF EMPLOYMENT');
					$this->email->message($mymessage);
					$this->email->send();

					
				//echo $this->email->print_debugger();
				
				$this->load->view('cmssuccess');
			
	
}

function billing(){

			
			if($this->session->userdata('username')){
			$data['title']="Billing Candidate";
			$data['heading'] ="Administrator Panel";
			
			$data['getcandidate'] = $this->mcms->ViewProfile($this->uri->segment(3));
			$dpay = $data['getcandidate'][0]['cost01']/5;
			$dwork = $data['getcandidate'][0]['day_work'];
			$somma=$dwork * $dpay;
			$data['somma']=$somma;
			$data['dwork']=$dwork;
			$this->load->view('billing_view', $data);
			}else{
			
				redirect('cms','refresh');
			}
		}
function updatepdf(){
			
			$data['title'] = "Summer Job  Form | " ;
			$data['heading'] ="Booking Form";
			
			$this->load->helper(array('form', 'url', 'email'));
			$this->load->library('form_validation');
			$this->load->library('validation');
			

			$config['upload_path'] = './uploadpdf/';
			$config['allowed_types'] = 'pdf|doc';
			$config['max_size']	= '1000';
			//$config['max_width']  = '1024';
			//$config['max_height']  = '768';
		
			$this->load->library('upload', $config);

				
		if (! $this->upload->do_upload('cvfile'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('pdfupdate_view', $data);
		}else
		{
			

			//$this->upload->do_upload('cvfile');
			
			$data = array('upload_data' => $this->upload->data('cvfile'));
			$filepdf=$data['upload_data']['raw_name'];
			
			if($this->upload->do_upload('userfile'))
			{
				//$this->upload->do_upload('userfile');
				$data1 = array('upload_data1' => $this->upload->data('userfile'));
				$filepdf1=$data1['upload_data1']['raw_name'];
			}
			else
			{
				$filepdf1="nodisplay";
			}

			$id=$this->uri->segment(3);
			$this->mcms->addPdf($id, $filepdf, $filepdf1);

			
			$data['title'] = "Summer Job  Form | Form Success" ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			$this->load->view('cmssuccess', $data);
			
		}
		
	}	
			
}
?>