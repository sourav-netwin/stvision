<?php

   class centre_admin  extends Controller {
		
		function centre_admin(){
			
			parent::Controller();
			$this->load->helper(array('form', 'url', 'email', 'security'));
			$this->load->model('m_campusadmin');	
			$this->load->library(array('session','email'));
			session_start();
				
		}


		function index()
		{
			

			$data['title']="Login";
			$data['heading'] ="Campus  Admin";
			
			$data['info'] = "Insert Your credentials";
			
			// SE L'UTENTE E' GIA LOGGATO
		if($this->session->userdata('administrator'))
		{	
			$campus=$this->session->userdata('password');
			$data['heading'] ="Campus  Admin:" . $campus;
			$data['getjob'] = $this->m_campusadmin->getAllJob($campus);
			$this->load->view('centre_admin_view', $data);
		}
		else
		{
			// Login
			$user=$this->input->post('user');
			$password=$this->input->post('password');
	
			if($this->input->post('user') && $this->input->post('password') ){
				if($user == "administrator" && $password == "bath"){
				$newdata = array(
                   'username'=>$user,
                   'password'=>$password,
                   'logged_in' => TRUE
               );
					$campus=$this->session->userdata('password');
					$data['getjob'] = $this->m_campusadmin->getAllJob($campus);
					$this->session->set_userdata($newdata);		

					$data['heading'] ="Campus  Admin:" . $campus;
					$this->load->view('centre_admin_view', $data);
				}else{
					$data['info'] = "Password wrong";
					$this->load->view('campus_login_view', $data);
				}
	
			}
			else
			{
			$data['info'] = "Insert User and Password";
			$this->load->view('campus_login_view', $data);
		}

	}

}

function edit_jobprofile(){
			$data['title']="Employee Admin";
			$data['heading'] ="Employee Admin";
			$data['getcandidate'] = $this->m_campusadmin->getCandidate($this->uri->segment(3));
			/*
			echo "<pre>";
			print_r($data['getcandidate']);
			echo "</pre>";
			*/
			$this->load->view('edit_jobprofile', $data);

	
}
function update_candidate(){
			$data['title']="Update Candidate";
			//Update del candidato
			$this->m_campusadmin->update_candidate($this->uri->segment(3));
			// Rilettura del pannello centrale
			$campus=$this->session->userdata('password');
			$data['heading'] ="Campus  Admin:" . $campus;
			$data['getjob'] = $this->m_campusadmin->getAllJob($campus);
			$this->load->view('centre_admin_view', $data);
		}
		
		
		
}
?>