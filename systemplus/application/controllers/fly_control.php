<?php

		class fly_control extends Controller {
	
		function index()
		{
			$this->load->database();
			//$query = $this->db->query('SELECT id, destinazioni, menu FROM destinazioni_junior');
			
			$data['title']="Prova di data title";
			$data['heading']="Destinations";
			
			
			$query = $this->db->query("SELECT id, nome, pratica, data_pratica FROM fly");

					foreach ($query->result() as $row)
					{
						
							
							$data['todo'] = array($row->id,$row->nome,$row->pratica,$row->data_pratica);
							$this->load->view('pannello_view', $data);

						
					}
					


				
				
			}
			
	
}
?>