<?php
	
class Payroll extends Controller {
	
	function Payroll(){
		
		parent::Controller();
		$this->load->helper(array('form', 'url', 'string'));
		$this->load->model('pr_presenze');
		$this->load->library(array('session','email'));
		session_start();
	}
	
	
function index()
	{
		$this->load->model('pr_presenze');
		$data['heading']="Home page";

		$newdata=array();
		if($this->session->userdata('logged_in'))
		{
			$data['teachers']=$this->pr_presenze->getTeachers($this->session->userdata('centre'));
			
			$data['center']=$this->session->userdata('centre');
			$this->load->view('pr_home_view', $data);
		}
		else
		{
			
			// Login
			$user=$this->input->post('user');
			$password=$this->input->post('password');
	
			if($this->input->post('user') && $this->input->post('password') ){
				// Cerco nel db i dati - se corretti setto la sessione
				$utente=$this->pr_presenze->usercenter($user,$password);

				if($utente){
						$newdata = array(
					   'username'=>$utente[0]['user'],
					   'password'=>$utente[0]['password'],
					   'centre'=>$utente[0]['center'],
					   'logged_in' => TRUE
               );
			
				   
						$this->session->set_userdata($newdata);				
						
						$data['teachers']=$this->pr_presenze->getTeachers($newdata['centre']);
						$data['center']=$this->session->userdata('centre');
						$this->load->view('pr_home_view', $data);
				}
				else
				{
						$data['info'] = "User or Password wrong";
						$this->load->view('pr_ad_login', $data);
				}
	
			}
			else
			{
			$data['info'] = "Insert User and Password";
			$this->load->view('pr_ad_login', $data);
		}

	}





		
	}

function singlecheck()
	{
		if($this->session->userdata('logged_in')==TRUE){
			$id=$this->uri->segment(3);
			$this->load->model('pr_presenze');
			$center=$this->session->userdata('centre');
			$data['heading']="Attendants Register";		
			$data['teachers_check']=$this->pr_presenze->getTeacherExist($id);
			
			//print_r($data['teachers_check']);
			echo "<hr/>";
			$data['center']=$center;

			$data['teachers']=$this->pr_presenze->getTeacher($id,$center);
			//echo "<pre>";
			//print_r($data['teachers_check']);
			//echo "</pre>";
			//print_r($data['teachers']);
			$this->load->view('pr_singleteacher_view', $data);
		}else{
			 redirect('/payroll', 'refresh');
		}
	}
function singleupdate()
	{
		$id=$this->uri->segment(3);
		$this->load->model('pr_presenze');
	
		foreach($_POST as $key=>$item):
				$this->pr_presenze->updatehour($key,$item);
		endforeach;
	

		redirect('/payroll', 'refresh');
	}

function singlewrite()
	{
		$id=$this->uri->segment(3);
		$this->load->model('pr_presenze');
		$center=$this->session->userdata('centre');
		$motivi="";
		// CICLO NEL POST
		
		foreach($_POST as $key=>$item):
				
				$this->pr_presenze->writehour($id,$key,$item,$center);
		
		endforeach;
		 redirect('/payroll', 'refresh');
		
		

	}
function details()
	{
		
		if($this->session->userdata('username')){
				
				$this->load->library('validation');
				$this->load->model('pr_presenze');
				
				$data['heading']="Details";
				
				// VERIFICO LA PRESENZA DELLO USER
				$id=$this->uri->segment(3);
				
				$data['details']=$this->pr_presenze->DetailExist($id);

				if($data['details']){
						$this->load->view('pr_detailsupdate_view',$data);
				}else{
				
						$rules['p'] = "trim|required";
						$this->validation->set_rules($rules);
						$fields['p'] = 'pay sleap type';

						$this->validation->set_error_delimiters('<div class="error">', '</div>');
						
						$this->validation->set_fields($fields);
						

						//$this->load->view('pr_details_view', $data);
						if ($this->validation->run() == FALSE)
						{
							$this->load->view('pr_details_view', $data);
									
						}else
						{
							
							$p=$_POST['p'];
							echo $p;
							$weekact01=$_POST['weekact01'];
							$weekact02=$_POST['weekact02'];
							$residential=$_POST['residential'];
							$bonus=$_POST['bonus'];
							$evaluation=$_POST['evaluation'];
							$this->pr_presenze->details($id,$p,$weekact01,$weekact02,$residential,$bonus,$evaluation);
							
							redirect('/payroll', 'refresh');	

						}

				}
		}
	}

function detailsupdate()
	{
	
		$data['heading']="Details Update";
		$this->load->model('pr_presenze');
		
					$id=$this->uri->segment(3);

					$p=$_POST['p'];
					$weekact01=$_POST['weekact01'];
					$weekact02=$_POST['weekact02'];
					$residential=$_POST['residential'];
					$bonus=$_POST['bonus'];
					$evaluation=$_POST['evaluation'];
					$this->pr_presenze->detailsupdate($id,$p,$weekact01,$weekact02,$residential,$bonus,$evaluation);
					
					redirect('/payroll', 'refresh');	

	}

function admin_center()
{
	if($this->session->userdata('username')=="admin"){
		$center=$this->uri->segment(3);
		if ($center == null)
		{
				$center="BEDFORD";
		}
		$this->load->model('pr_presenze');
		$data['center_menu']=$this->pr_presenze->getCenterMenu();
		$data['teachers']=$this->pr_presenze->getTeachers($center);

		$data['heading']="Home page";
		$this->load->view('pr_ad_home', $data);
	}else{
		redirect('/payroll/login_admin_centers', 'refresh');
	}

}
function login_admin_centers(){
					//$this->session->sess_destroy();
					$data['heading']="Effettua il login";
					$this->load->view('news_login_view', $data);
					$user=$this->input->post('user');
					$password=$this->input->post('password');

					if($this->input->post('user') && $this->input->post('password')){
							// Tutto Ok campi pieni e corretti Leggo la  dashboard
							if($user == "admin" && $password == "anna")
							{
								$newdata = array(
								   'username'=>$user,
								   'password'=>$password,
								   'logged_in' => TRUE
							   );

								$this->session->set_userdata($newdata);				
								redirect('/payroll/admin_center/BEDFORD', 'refresh');
								
							}else{
									echo "<code>User o Password Errati!</code>";			
							}
					
					}
}

function ad_teacher(){
		
		$id=$this->uri->segment(4);
		$tot=0;
		$budget=0;
		$hourday=0;
	
		$this->load->model('pr_presenze');
		
		//Calcolo le ore lavorative
		$data['center_menu']=$this->pr_presenze->getCenterMenu();
		$data['teachers']=$this->pr_presenze->TeachersHours($id);
		
		//echo count($data['teachers']);

		$data['pay']=$this->pr_presenze->TeachersPay($id);
		
		$data['checkpay']=$data['pay'][0]['checkpay'];
		//echo "---->" . count($data['teachers']);
		$data['hourweek']=count($data['teachers'])*3; // Ore complessive
		$data['details']=$this->pr_presenze->TeachersDetails($id);
		$data['salary_hours']=number_format($data['pay'][0]['salary'] / 15,2);
		$data['costo_previsto']=number_format($data['salary_hours'] * $data['hourweek'],2);
		$data['costo_settimana']=number_format($data['pay'][0]['salary'],2);
		$data['time_pay']=array(9,19,29);
		

		$data['heading']="Teachers Details&nbsp;";
		$this->load->view('pr_ad_payteacher', $data);
}

function autorizza(){
		$center=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		$yesorno=$_POST['autorizza'];
	    $this->pr_presenze->autorizza($id,$yesorno,$center);

		redirect('/payroll/admin_center/'.$center, 'refresh');
}
function logout(){
	$this->session->sess_destroy();
	redirect('/payroll', 'refresh');	
}

}
?>