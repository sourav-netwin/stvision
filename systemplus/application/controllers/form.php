<?php

class Form extends Controller {
	
	function index()
	{
		
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('validation');
		
		

		$rules['username'] = "required|min_length[5]|max_length[30]";
		$rules['password'] = "required|matches[passconf]";
		$rules['passconf'] = "required";
		$rules['myemail'] = "required|valid_email";
		
		$this->validation->set_rules($rules);
		
		$fields['username'] = 'Username';
		$fields['password'] = 'Password';
		$fields['passconf'] = 'Password Confirmation';
		$fields['email'] = 'Email Address';
		
		$this->validation->set_error_delimiters('<div class="error">', '</div>');

		
		$this->validation->set_fields($fields);

				
		if ($this->validation->run() == FALSE)
		{
			$this->load->view('myform');
		}else
		{
			
			$this->load->library('email');
			$this->email->from('galasso@italiainfiera.it', 'Stefano Galasso');
			$this-> email-> to($_POST['myemail']);
			$this->email->subject('Annnulamento pratica - ' . $_POST['username']);
			$this->email->message('SI prega di confermare annullamento della pratica' . $_POST['username'] );
			$this->email->send();
			//echo $this->email->print_debugger();
			$this->load->view('formsuccess');	
			
		}
		
	}	
}
?>