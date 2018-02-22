<?php

class Formcheck extends Controller {
	
	function index(){
	
	
	$this->load->library('email');
	$this->email->from('galasso@italiainfiera.it', 'Stefano Galasso');
	$this->email->to('info@startuponline.it');
	//$this->email->cc('another@another-example.com');
	//$this->email->bcc('them@their-example.com');

	$this->email->subject('Email Test');
	$this->email->message('Testing the email class.');

	$this->email->send();
	
	echo $this->email->print_debugger();
}

}
?>