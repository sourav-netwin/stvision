<?php

		class pannello extends Controller {
		
		function pannello(){
		
			parent::Controller();
			$this->load->helper('url');
			$this->load->database();
			$this->load->helper(array('form', 'url'));
			$this->load->library('validation');
			
					
					
		}


		function index()
		{
			
			//$query = $this->db->query('SELECT id, destinazioni, menu FROM destinazioni_junior');
			
			$data['title']="Annulla pratica";
			$data['heading'] ="Pannello di gestione annullamento pratiche";
			$data['query'] = $this->db->get('fly');
			//$query = $this->db->query("SELECT id, destinazioni, menu FROM destinazioni_junior WHERE menu='EU'");
								 
		    $this->load->view('pannello_view', $data);

			}
		function insert(){
		
			
			
		
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

							
					
						$this->load->view('myinsert');
					
		
		}
		
		
		function putdb(){
					
					$sql = "INSERT INTO fly (nome, pratica, data_pratica) VALUES (".$this->db->escape($_POST['username']).", ".$this->db->escape($_POST['npratica']).", ".$this->db->escape($_POST['data_pratica']).")";
					
					$this->db->query($sql);
					
					echo "Dati inseriti<br/>";
					echo "Nome: " . $_POST['username'] . "<br/><br/>";
					echo "Numero Pratica: " . $_POST['npratica'] . "<br/><br/>";
					echo "Data: " . $_POST['data_pratica'] . "<br/><br/>";
					
					echo anchor('pannello', 'Ritorna');
		
		
		}
		
		function deldb(){
					
					$this->db->delete('fly', array($_POST['id'] => $id)); 
					
					echo anchor('pannello', 'Ritorna');
		
		
		}

		

			
	
}
?>