<?php

   class personalpage  extends Controller {
		
function personalpage(){
		
			parent::Controller();
			
			$this->load->model('mpersonal');
			$this->load->helper(array('form', 'url', 'email', 'security'));
			//$this->load->model('mcms');	
			$this->load->library(array('session','email'));
			$this->load->library('form_validation');
			$this->load->library('validation');
			
					
}

function index(){
		
		$data['title']="Plus Educaional | Personal Page";
		$data['heading'] ="Teacher DashBoard";	
		$this->load->view('ppage_login_view', $data);
		$this->load->library('session');
			
}
		


function admin(){

		$data['title']="Check Mail";
		$data['heading'] ="inserisci la tua mail</strong>";
		$email=$_POST['email'];
		
		$checkmail = $this->mpersonal->checkmail($email);
			//$this->load->view('ppage_login_view', $data);
		if(!$checkmail){
			$data['heading'] ="mail ko";
			$this->load->view('ppage_login_view', $data);
			
			
		}else{
				/*
				$data['heading'] ="Insert Your Credentials";
				$data['hideid']=$checkmail[0]['id'];
				$data['title']=$checkmail[0]['title'];
				$data['nome']=$checkmail[0]['nome'];
				$data['cognome']=$checkmail[0]['cognome'];
				$this->load->view('ppage_admin_view', $data);
				*/
				$newdata = array(
								   'email'=>$email,
								   'logged_in' => TRUE
							   );
								
								$this->session->set_userdata($newdata);

								$logmail=$this->session->userdata('email');
								
								redirect('personalpage/contract','refresh');
								
				}
}


function checkuserok()
{
		
		$config['upload_path'] = './uploadpdf/';
		$config['allowed_types'] = 'pdf|doc';
		$config['max_size']	= '1000';
		
		$this->load->library('upload', $config);

		
		$id=$_POST['id'];
		$sortcode=$_POST['sortcode'];
		$accountnumber=$_POST['accountnumber'];
		$accountname=$_POST['accountname'];
		$insurance=$_POST['insurance'];
		
		if(!$sortcode || !$accountnumber || !$accountname || !$insurance){
		
		
		redirect('personalpage/credential','refresh');	
		
		}
		// update nel db user status data id number
		
		if (! $this->upload->do_upload('cvfile'))
		{
			$error = array('error' => $this->upload->display_errors());
			$filepdf="nodisplay";
		}else
		{
			
			$data = array('upload_data' => $this->upload->data('cvfile'));
			$filepdf=$data['upload_data']['raw_name'];
			
			if($this->upload->do_upload('userfile'))
			{
				//$this->upload->do_upload('userfile');
				$data1 = array('upload_data1' => $this->upload->data('userfile'));
				$filepdf1=$data1['upload_data1']['raw_name'];
				$this->mpersonal->addPdf($id, $filepdf, $filepdf1);
	
			}
			else
			{
				$filepdf1="nodisplay";
			}
		}
			$this->mpersonal->update_status($id,$sortcode,$accountnumber,$accountname,$insurance);
			$detail=$this->mpersonal->activecontract($id);
		
		$data['title']="Resume Contract";
		$data['heading'] ="Procedure right";
		$data['nome']=$detail[0]['nome'];
		$data['cognome']=$detail[0]['cognome'];
		$data['type_contract']=$detail[0]['type_contract'];
		$data['center_def']=$detail[0]['center_def']; 
		$data['salary']=$detail[0]['salary'];
		$data['date_start']=$detail[0]['date_start'];
		$data['date_end']=$detail[0]['date_end'];
		$data['id']=$id;


		$this->load->view('ppage_admin_success', $data);
		
}

function contract(){
			
			$data['title']="Document";
			$data['heading'] ="Generate Document";
			$logmail=$this->session->userdata('email');
			$data['getcandidate'] = $this->mpersonal->Contract($logmail);
			$id=$data['getcandidate'][0]['id'];
			$data['multiplo'] = $this->mpersonal->Multiplo($id);
			if(!$data['multiplo']){
				$data['multiplo']="";
			}
			
			$this->load->view('cmscontract_user', $data);
//			$this->mpersonal->update_status($logmail);
		}

function printcontract(){
			$id=$_POST['id'];
			$data['title']="Document";
			$data['heading'] ="Generate Document";
			
			$data['getcandidate'] = $this->mpersonal->printcontract($id);
			
			/* Send a mail to contact
			
					$this->email->from('plus@plus-ed.com');
					$this->email->to($data['getcandidate'][0]['email']);
					$this->email->subject('CONTRACT OF EMPLOYMENT');
					$this->email->message('I am pleased to confirm your employment<br/>To view term and condition paste this link:<br/> ' . base_url() . 'index.php/job/contract/'.$data['getcandidate'][0]['id']);
					$this->email->send();
			*/
			
			$this->load->view('cmscontract', $data);
			//$this->mcms->update_status($this->uri->segment(3));
}

function credential(){

		$data['title']="Check Mail";
		$data['heading'] ="inserisci la tua mail</strong>";
//		$email=$_POST['email'];
		
		$email=$this->session->userdata('email');
		
		$checkmail = $this->mpersonal->checkmail($email);
			//$this->load->view('ppage_login_view', $data);
		if(!$checkmail){
			
			redirect('personalpage/','refresh');
			
			
		}else{

				$data['heading'] ="Insert Your Credentials";
				$data['hideid']=$checkmail[0]['id'];
				$data['title']=$checkmail[0]['title'];
				$data['nome']=$checkmail[0]['nome'];
				$data['cognome']=$checkmail[0]['cognome'];

		
				$this->load->view('ppage_admin_view', $data);
		
		}
}

}
?>