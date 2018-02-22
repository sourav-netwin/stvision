<?php
	
class Blog extends Controller {
	
	function Blog(){
		
		parent::Controller();
	}
	
	
	function index()
	{
		$data['title']="Prova di data title";
		$data['heading']="Prova di heading dinamico";
		$data['todo'] = array('cane','gatto','topo');
		$this->load->view('blog_view', $data);
	}
}
?>