<?php

class Agenticms extends Controller {

	public function __construct(){
		
		parent::Controller();
		
		$this->load->helper(array('form', 'url'));
		//$this->load->library('email');
		//$this->load->library('form_validation');
		//$this->load->library('session');
		//$this->load->library('validation');
		//session_start();
		$this->load->model('magenti');
	}
	
	function index()
	{
		//$this->load->helper('string');
		$data['title']="Agent's Area | Registrati";

		$this->load->view('agenti_login', $data);

	}


function do_upload(){
		$data['title']="Agent's Area | Registrati";
		
		//CONFIG UPLOAD
		$config['upload_path'] = './images/gallery';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
		
		$this->load->library('upload', $config);
		

		if(!$this->upload->do_upload('imgbig'))
		{
			$data = array('error' => $this->upload->display_errors());
			
			$this->load->view('agenticms_insertimg', $data);

		}
		else
		{
			//Upload File
			$this->upload->do_upload('imgbig');
			$data = array('upload_data' => $this->upload->data());
			$imgbig=$data['upload_data']['raw_name'];
			
			$this->upload->do_upload('imgsmall');
			$data1 = array('upload_data1' => $this->upload->data());
			$imgsmall=$data1['upload_data1']['raw_name'];
			
			$tipo=$this->input->get_post('tipo', TRUE);
			$notes=$this->input->get_post('notes', TRUE);
			
				
			// Chiamo il modello per inserire i dati nel db e upload img
			$this->Magenti->addImg($imgbig, $imgsmall, $tipo, $notes);
			$this->load->view('agenticms_insertimg', $data);
		}
		
}


}

/* End of file welcome.php */
/* Location: ./systm/application/controllers/welcome.php */