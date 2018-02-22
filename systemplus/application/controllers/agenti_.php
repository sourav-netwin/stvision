<?php

class Agenti extends Controller {

	public function __construct(){
		
		parent::Controller();
		
		$this->load->helper(array('form', 'url'));
		//$this->load->library('email');
		//$this->load->library('form_validation');
		//$this->load->library('session');
		//$this->load->library('validation');
		//session_start();
		$this->load->model('magenti');
		$this->load->library('session');

	}
	
	function index()
	{
		

		$this->load->helper('string');
		$data['title']="Agent's Area | Registrati";
		$this->load->view('agenti_login', $data);

	}
        
function login(){
	
	session_start();

	$data['heading']="pannelo di controlllo";
	$user=$this->input->post('username');
	$pwd=$this->input->post('password');
	
//echo $user;

        
	if($this->input->post('username') || $this->input->post('password') ){

		$data['results'] = $this->magenti->verifyuser($user, $pwd);
                if(($data['results'][0]['login']=='Ste')||($data['results'][0]['login']=='ricki')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
	
	}else{
		

		redirect('agenti','refresh');
	}
		
		$data['title'] = "Login | Lobby";
		

		/**** Se l'utente viene riconosciuto va a lobby altrimenti torna  ****/

		if($data['results']){
                $newdata = array(
                   'username'       => $data['results'][0]['login'],
                   'mainfirstname'  => $data['results'][0]['mainfirstname'],
                   'mainfamilyname' => $data['results'][0]['mainfamilyname'], 
                   'businessname'   => $data['results'][0]['businessname'],
                   'id'             => $data['results'][0]['id'],
                   
                   'logged_in' => TRUE
               ); 
                
                $this->session->set_userdata($newdata);
                
			$this->load->vars($data);
                        $data['title']="Login | Lobby";
			$this->load->view('agenti_home');
		}else{

			redirect('agenti','refresh');
		}

		
	}


function logged(){
		$data['title']="Agent's Area | Registrati";

		$this->load->view('agenti_home', $data);

}

function logout() { {
        $this->session->sess_destroy();
            redirect('agenti','refresh');
    }
}

function marketing(){
                 if($this->session->userdata('username') ){
		$data['title']="Agent's Area | Registrati";
		$this->load->view('agenti_marketing', $data);
                 }else{
                      redirect('agenti','refresh');
                 }
}

function forgot_pass(){
    $data['title']="Password Recovery";
    $this->load->view('forgot_password', $data);
}

function send_password(){
    
    $this->load->model('gestione_centri_model');
    $email=$_POST['user'];
    $data['recupera_password'] = $this->gestione_centri_model->reupera_password($email);

    if($data['recupera_password']!= null){
        
        $email=$data['recupera_password'][0]['email'];
        $password=$data['recupera_password'][0]['password'];
        $login=$data['recupera_password'][0]['login'];
        $data['title']="User correct";
        $this->load->library('email');
        $mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
        $mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
        $mymessage .=   "<strong> Dear Sirs </strong>" ."<br/><br/>"; 
        $mymessage .=   "<strong> Please attach copy of your new login e password </strong>" ."<br/><br/>"; 
        $mymessage .=   "<strong> Login: " .$login." </strong>" ."<br/><br/>";        
        $mymessage .=   "<strong> Password: " .$password." </strong>" ."<br/><br/>";
        $mymessage .=   "<strong> Web site: http://www.plus-ed.com/apps/index.php/agenti </strong>" ."<br/><br/>";
        $mymessage .=   "</body></html>";
    
        $this->email->from('ciccopeppe@gmail.com', 'study tours administrator');
        $this->email->to($email);
        $this->email->subject('Request password');
        $this->email->message($mymessage);
        $this->email->send();
        
        $this->load->view('forgot_password_ok', $data);
        
        
    }else{
        $data['title']="User incorrect";
        $this->load->view('forgot_password_wrong', $data);
    }

}

function gallery(){
		
		$data['title']="Agent's Area | Gallery";		

		$this->load->library('pagination');
		$config['base_url'] = 'http://www.plus-ed.com/apps/index.php/agenti/gallery';
		$config['per_page'] = '15';
		$data['th'] = $this->Magenti->thumbs($config['per_page'],$this->uri->segment(3));
		$config['total_rows'] =  $this->db->count_all('agenti_gallery');
		$this->pagination->initialize($config); 	
		$this->load->vars($data);
		$this->load->view('agenti_galleryhome', $data);
		
		

}
function gallery_search(){
		
		$data['title']="Agent's Area | Gallery";		
		
		$data['th'] = $this->Magenti->thumbs_search($this->uri->segment(3));
		$this->load->vars($data);
		$this->load->view('agenti_galleryhome_search', $data);
		
		

}
function myimage(){


		$data['title']="Agent's Area | Gallery";
				
		//$this->load->model('magenti');
		$data['immagine'] = $this->Magenti->single($this->uri->segment(3));
		$data['imgbig'] = $data['immagine'][0]['imgname'];
		$this->load->view('agenti_gallery_single', $data);


}

function higres(){

		// Helper download
		$this->load->helper('download');

		$data['title']="Agent's Area | Gallery";
				
		$this->load->model('magenti');
		$data['immagine'] = $this->Magenti->single($this->uri->segment(3));
		$name = 'gallery.jpg';
		$data['imgbig']  =  file_get_contents( base_url() . "images/gallery/" . $data['immagine'][0]['imgname'] . ".jpg"); // Read the file's contents
		
		force_download($name, $data['imgbig']);

		
		$this->load->view('agenti_gallery_single', $data);


}

function marketingsummer(){
    
    
                 if($this->session->userdata('id') ){
		$data['title']="Agent's Area | Marketing Plus Summer";
		$this->load->view('agenti_marketing_summer', $data);
                 }else{
                     redirect('agenti','refresh');
                 }

}


function registrazioneFirst(){
		
		$data['title']="Agent's Area | Plus Step 1";
	  	$data['heading']="Welcome in Agent's Area";
		
		//Leggo model e library dopo li metter� in autoload $this->load->helper('security');
		//$this->load->model('model_user');
		$this->load->helper(array('form', 'url', 'email', 'security'));
		$this->load->library(array('validation','session','email'));
		
		
		//Routine di validazione dei campi form
		$rules['bname'] = "required";
		$rules['baddress'] = "required";
		$rules['bcity'] = "required";
		$rules['bpostalcode'] =  "required";
		$rules['bcountry'] =  "required";
		$rules['btelephone'] =  "required";
		$rules['bfax'] =  "required";
		$rules['myemail'] =  "required|valid_email";
		
		$this->validation->set_rules($rules);
		
		$fields['bname'] = 'Company Name';
		$fields['baddress'] = 'Company Address';
		$fields['bcity'] = 'Company City';
		$fields['bpostalcode'] ='Company Postal Code';
		$fields['bcountry'] ='Company Country';
		$fields['btelephone'] ='Company Telephone';
		$fields['bfax'] ='Company Fax';
		$fields['myemail'] ='email';
			

		$this->validation->set_error_delimiters('<div class="error"> ** ', ' ** </div>');

		$this->validation->set_fields($fields);
		
		//Se la validazione � TRUE chiamo il modello insert_user e gli passo i parametri per la scrittura nel db users

			if ($this->validation->run() == FALSE)
			{

				$this->load->view('registrati_view_first', $data);
				
			}
				else
			{
				
				
				$data['title']="Agents Area | Home";
				$data['heading']="Benvenuti nell'area agenti";
				
				//Prendo i campi del form da passare al model
				$bname=$this->input->post('bname');
				$baddress=$this->input->post('baddress');
				$bcity=$this->input->post('bcity');
				$bpostalcode=$this->input->post('bpostalcode');
				$bcountry=$this->input->post('bcountry');
				$btelephone=$this->input->post('btelephone');
				$bfax=$this->input->post('bfax');
				$bweb=$this->input->post('bweb');
				$email=$this->input->post('myemail');

							
					/* SCRIVI SESSIONE nel db */
					
					$data = $this->Magenti->insert_first($bname, $baddress, $bcity, $bpostalcode, $bcountry, $btelephone, $bfax, $bweb,$email);
					$data = $this->Magenti->recuperaID($bname);
					$myidsegment=$data[0]['id'];
					$data['title']="Agent's Area | Right Procedure";
					$data['message']="Registration end<br/>Check your mail!!!<br/>";					
					redirect('/agenti/registrazioneSecond/' . $myidsegment, 'refresh');

			}

		}
function registrazioneSecond(){
		
		$data['title']="Agent's Area | Plus Step 2";
	  	$data['heading']="Welcome in Agent's Area";
		
		//Leggo model e library dopo li metter� in autoload $this->load->helper('security');
		//$this->load->model('model_user');
		$this->load->helper(array('form', 'url', 'email', 'security'));
		$this->load->library(array('validation','session','email'));
		
		
		//Routine di validazione dei campi form
 		$rules['maintitle'] = "required";
		$rules['mainfirst'] = "required";
		$rules['mainfamilyname'] = "required";
		$rules['mainposition'] =  "required";
		$rules['maintelephone'] =  "required";
		
		$this->validation->set_rules($rules);
		
 		$fields['maintitle'] = 'Title';
		$fields['mainfirst'] = 'First Name';
		$fields['mainfamilyname'] = 'Family Name';
		$fields['mainposition'] = 'Main Position';
		$fields['maintelephone'] ='Telephone';
			

		$this->validation->set_error_delimiters('<div class="error"> ** ', ' ** </div>');

		$this->validation->set_fields($fields);
		
		//Se la validazione � TRUE chiamo il modello insert_user e gli passo i parametri per la scrittura nel db users

			if ($this->validation->run() == FALSE)
			{

				$this->load->view('registrati_view_second', $data);
				
			}
				else
			{
				
				
				$data['title']="Agents Area | Home";
				$data['heading']="Benvenuti nell'area agenti";
				
				//Prendo i campi del form da passare al model
				$maintitle=$this->input->post('maintitle');
				$mainfirst=$this->input->post('mainfirst');
				$mainfamilyname=$this->input->post('mainfamilyname');
				$mainposition=$this->input->post('mainposition');
				$maintelephone=$this->input->post('maintelephone');
				

							
					/* SCRIVI SESSIONE nel db */
					
					$data = $this->Magenti->insert_second($this->uri->segment(3), $maintitle, $mainfirst, $mainfamilyname, $mainposition, $maintelephone);

					redirect('/agenti/registrazioneThird/' . $this->uri->segment(3), 'refresh');
			}
}

function registrazioneThird(){
		
		$data['title']="Agent's Area | Plus Step 2";
	  	$data['heading']="Welcome in Agent's Area";
		
		//Leggo model e library dopo li metter� in autoload $this->load->helper('security');
		//$this->load->model('model_user');
		$this->load->helper(array('form', 'url', 'email', 'security'));
		$this->load->library(array('validation','session','email'));
		
		
		//Routine di validazione dei campi form
		
		$rules['companyemployed'] = "required";
		$rules['companystudent'] = "required";
		$rules['companylicensed'] =  "required";
		$rules['companyhear'] =  "required";
		$rules['companystart'] =  "required";

		$this->validation->set_rules($rules);
		
		
		$fields['companyemployed'] = 'Employed';
		$fields['companystudent'] = 'Students';
		$fields['companylicensed'] ='Licensed';
		$fields['companyhear'] ='Hear';			
		$fields['companystart'] ='Start';			


		$this->validation->set_error_delimiters('<div class="error"> ** ', ' ** </div>');

		$this->validation->set_fields($fields);
		
		//Se la validazione � TRUE chiamo il modello insert_user e gli passo i parametri per la scrittura nel db users

			if ($this->validation->run() == FALSE)
			{

				$this->load->view('registrati_view_third', $data);
				
			}
				else
			{
				
				
				$data['title']="Agents Area | Home";
				$data['heading']="Benvenuti nell'area agenti";
				
	//Prendo i campi del form da passare al model
				
				$companyemployed=$this->input->post('companyemployed');
				$companystudent=$this->input->post('companystudent');
				$companydestinations=$this->input->post('companydestinations');
				$companylicensed=$this->input->post('companylicensed');
				$companyhear=$this->input->post('companyhear');
				$companystart=$this->input->post('companystart');
				$companybrochure=$this->input->post('companybrochure');
				$companystart=$this->input->post('companystart');
				$companyjunior=$this->input->post('junior');
				$companylang=$this->input->post('languagelearning');
				$companyuniversity=$this->input->post('university');
				$companydest1=$this->input->post('destination1');
				$companydest2=$this->input->post('destination2');
				$companydest3=$this->input->post('destination3');
	/* SCRIVI SESSIONE nel db */
					
					$data = $this->Magenti->insert_third($this->uri->segment(3),  $companyemployed, $companystudent, $companydestinations, $companylicensed, $companyhear, $companystart, $companybrochure,$companystart,$companyjunior,$companylang,$companyuniversity,$companydest1,$companydest2,$companydest3);

					redirect('/agenti/registrazioneEnd/' . $this->uri->segment(3), 'refresh');
			}
}


function changeCredential(){
		
		$data['title']="Agent's Area | End";
	  	$data['heading']="Welcome in Agent's Area";
		
		//Leggo model e library dopo li metter� in autoload $this->load->helper('security');
		//$this->load->model('model_user');
		$this->load->helper(array('form', 'url', 'email', 'security'));
		$this->load->library(array('validation','session','email'));
		
		
		//Routine di validazione dei campi form
		$rules['username'] = "required|min_length[5]|max_length[30]";
		$rules['password'] = "required|matches[passconf]|min_length[5]|max_length[30]";
		$rules['passconf'] = "required";
		$rules['myemail'] =  "required|valid_email";
		
		$this->validation->set_rules($rules);
		
		$fields['username'] = 'Username';
		$fields['password'] = 'Password';
		$fields['passconf'] = 'Password Confirmation';
		$fields['email'] =	  'Email Address';
				
		

		$this->validation->set_error_delimiters('<div class="error"> ** ', ' ** </div>');

		$this->validation->set_fields($fields);
		
		//Se la validazione � TRUE chiamo il modello insert_user e gli passo i parametri per la scrittura nel db users

			if ($this->validation->run() == FALSE)// || strcasecmp($_SESSION['captchaWord'], $_POST['confirmCaptcha']) <> 0)
			{

				/* Captcha
				$this->load->model('captcha_model');
				$captcha = $this->captcha_model->generateCaptcha();
				$_SESSION['captchaWord'] = $captcha['word'];
				$data['captcha'] = $captcha;
				*/
				$this->load->view('registrati_view', $data);
				
			}
				else
			{
				
				
				$data['title']="Agents Area | Home";
				$data['heading']="Benvenuti nell'area agenti";
				
				//Prendo i campi del form da passare al model
				$login=$this->input->post('username');
				$password=$this->input->post('password');
				//$email=$this->input->post('myemail');
				
				// Verifico che la mail non sia gi� presente in archivio
				$data = $this->Magenti->verify_mail($email, $login);
				
				if($data != null){
					$data['title']="Agents Area | Mail Error";
					$data['message']="Duplicate Mail Or Duplicate Username";
					//echo "mail or username esistente";
					$this->load->view('agenti_active_view', $data);
				}				
				else{
					
					//SCRIVI SESSIONE nel db
					$session_id = $this->session->userdata('session_id');
					$data = $this->Magenti->insert_user($this->uri->segment(3), $login, $password, $email, $session_id);
					$data['title']="Agent's Area | Right Procedure";
					$data['message']="Registration end<br/>Check your mail!!!<br/>";
					$this->load->view('agenti_active_view', $data);
					
					
					/* Spedisco la mail */
					$this->email->from('info@startuponline.it');
					$this->email->to($email);
					$this->email->subject('Iscrizione a Agenti');
					$this->email->message('Paste this link to confirm your activation:<br/> ' . base_url() . 'index.php/agenti/activate/'.$session_id . '<br><br/>Welcome in Plus');
					$this->email->send();
					//echo $this->email->print_debugger();
					//$this->load->view('successbooking');	
					
				}

			}
		}
function RegistrazioneEnd(){
		
		$data['title']="Agent's Area | End";
	  	$data['heading']="Welcome in Agent's Area";
		
		//Leggo model e library dopo li metter� in autoload $this->load->helper('security');
		//$this->load->model('model_user');
		$this->load->helper(array('form', 'url', 'email', 'security'));
		$this->load->library(array('validation','session','email'));				
				
				
				$data['title']="Agents Area | Home";
				$data['heading']="Benvenuti nell'area agenti";
								
				$id=$this->uri->segment(3);
				//Recupero tutti i dati
				$dataend =	$this->Magenti->recuperaMail($id);
				
				$business_user= $rest = substr($dataend[0]['businessname'], 0, 3);  // returns "abcde" 

					$data = $this->Magenti->genera_credenziali($id,$business_user);	
					
					//SCRIVI SESSIONE nel db
					$session_id = $this->session->userdata('session_id');
					$data = $this->Magenti->insert_user($this->uri->segment(3), $session_id);
					
					//Recupero tutti i dati
					$dataend =	$this->Magenti->recuperaMail($id);
					
					/* Spedisco la mail  */
					$this->email->from('info@plus-ed.com.com');
					$this->email->to($dataend[0]['email']);
					$this->email->subject('Welcome in Plus Patner Zone');
					///
					$mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
					$mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
					$mymessage .= "<title>Plus Educational</title></head>";
					$mymessage .= "<body>";
					$mymessage .= "<div style=\"font-family: Lucida Grande, Verdana, Sans-serif; font-size: 12px; color: #333; padding:10px\">";
					$mymessage .= "<br/><div style=\"font-family: Lucida Grande, Verdana, Sans-serif; font-size: 14px; color: #0066a8;\"><strong>Thank you for your application and interest in PLUS</strong><br/><br/></div>";
					
					$mymessage .= "<br><br/>Your Username is <strong>" . $dataend[0]['login'] . "</strong><br>Your Password is <strong>" . $dataend[0]['password'];
					$mymessage .= "</strong><br><br>Paste this link to confirm your activation:<br/> " . base_url() . "index.php/agenti/activate/" . $session_id . "<br><br/>Welcome in Plus<br/></body></html>"; 
					
					$this->email->message($mymessage);
					$this->email->send();
					
					$data['title']="Agent's Area | Right Procedure";
					$data['message']="Registration end<br/>Check your mail!!!<br/>";
					
					$this->load->view('agenti_active_view', $data);
			
		}

function activate(){
				
	//Prendo in get la url 
	//chiamo il model cerco la stringa la svuoto e metto l'utente in active!!!!!
		$data['title']="Attivazione Utente";
		$data['heading'] ="Richiesta attivazione utente Genio";
		$mydata = $this->Magenti->pending_user();
	
	if($mydata == true){
				$data['message']="User Right";
				$this->load->view('agenti_active_view', $data);
	}
	else{	
				$data['message']="Error Code";
				$this->load->view('agenti_active_view', $data);
	}

}

// View Statiche
function ourteam(){

		$data['title']="Agent's Area | Marketing Plus Summer";
		$this->load->view('agenti_marketing_ourteam', $data);
}
function oncampus(){

		$data['title']="Agent's Area | Marketing Plus Summer";
		$this->load->view('agenti_marketing_oncampus', $data);
}
function ourcourses(){

		$data['title']="Agent's Area | Marketing Plus Summer";
		$this->load->view('agenti_marketing_ourcourses', $data);
}
function accomodation(){

		$data['title']="Agent's Area | Marketing Plus Summer";
		$this->load->view('agenti_marketing_accomodation', $data);
}

function activities(){

		$data['title']="Agent's Area | Marketing Plus Summer";
		$this->load->view('agenti_marketing_activities', $data);
}

function experience(){

		$data['title']="Agent's Area | Marketing Plus Summer";
		$this->load->view('agenti_marketing_experience', $data);
}

function package(){

		$data['title']="Agent's Area | Marketing Plus Summer";
		$this->load->view('agenti_marketing_package', $data);
}



function enrol(){    
    
    //Booking form
    
    //Recupero il valore dell'utente loggato
 if($this->session->userdata('username')){
                
    $this->load->model('gestione_centri_model'); 
    $this->load->helper(array('form', 'url'));
    $this->load->library('validation');

    $rules['group'] = "required";
    $rules['agency'] = "required";
    
    $this->validation->set_rules($rules);
    
    
     //Routine di validazione dei campi form
    $rules['date_start'] = "required";
    $rules['date_end'] = "required";
    $rules['totpax'] = "required";

    // Select
        
    $rules['scuole'] = "required";
    $rules['agency'] = "required";
    $rules['n_group'] = "required";
    $rules['group'] = "required";
   
    $this->validation->set_rules($rules);

    //Booking IN validation//

    $fields['date_start'] = 'Data inizio';
    $fields['accomodation'] = 'Accomodation';
    
    //Booking OUT validation//

    $fields['date_end'] = 'Data fine';

    $fields['totpax'] = 'Totale passeggeri';
    $fields['agency'] = 'Agenzie';
    $fields['n_group'] = 'Numero Group Leader';
    $fields['name_group'] = 'Nome del gruppo';
    
    $this->validation->set_error_delimiters('<div class="error"> ** ', ' ** </div>');

    $this->validation->set_fields($fields);
    
    if ($this->validation->run() == FALSE) {
        
          $data['centri'] = $this->gestione_centri_model->building();
          $data['agenzie'] = $this->gestione_centri_model->agency_building();
          $data['aereo_in'] = $this->gestione_centri_model->airport();
          $data['aereo_out'] = $this->gestione_centri_model->airport_back();
          $data['user']  = $this->session->userdata('username');
          $data['id']  = $this->session->userdata('id');
          $data['name']  = $this->session->userdata('mainfirstname'); 
          $data['surname']  = $this->session->userdata('mainfamilyname');
          $data['business']  = $this->session->userdata('businessname');
          
        $login=$data['user'];
        $id=$data['id'];
        $data['title']='Add group Leader';
        $this->load->view('agenti_previsional',$data); 
    } else {

        $data['user']  = $this->session->userdata('username'); 
        $data['mail']  = $this->session->userdata('email');
        $data['id']  = $this->session->userdata('id');
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
        $data['business']  = $this->session->userdata('businessname');

        $login=$data['user'];
        
        $email=$data['mail'];
        
        $data['insert_gruppo'] = $this->gestione_centri_model->insert_gruppo();
        
        $id_name=$_POST['group'];
        
        $data['id_nome_agente'] = $this->gestione_centri_model->nome_gruppo($id_name); 
        
        
        $id_group= $data['id_nome_agente'][0]['id'];

   
        
        $data['ultimo_id']=$this->gestione_centri_model->ultimo_id();
        
        $id=$data['ultimo_id'][0]['id'];

        $stringa=$_POST['scuole'];
        $stringa_id= substr($stringa, 0, 4)."_".$id;

        //Inserimento nel booking dell agente
        
             $data['insert_gruppo_all'] = $this->gestione_centri_model->insert($id_group,$stringa_id,$login);
        
       // prendo l'ultimo valore inserito nel booking
             
             $data['last_id']= $this->gestione_centri_model->ultimo_rand();
             $last_rand=$data['last_id'][0]['rand'];

        // inserimento excursion  plan
 
           $d1=$_POST['date_start'];
           $d2=$_POST['date_end'];
        
        //funziona conta giorni tra due date//            
                $diff= round(abs(strtotime($d2) - strtotime($d1))/86400);     
        //fine//      

                $agente=$_POST['agent'];
                
                $group_leader=$_POST['group'];
                
        if($diff <= 7){
            
               $data['excursion_plan']=$this->gestione_centri_model->excursion_selected_7($last_rand,$diff);
               

                 for($i=0; $i<count($data['excursion_plan']); $i++){
                        
        
                        $centro=$data['excursion_plan'][$i]['id_centro'];
                        $rand=$data['excursion_plan'][$i]['rand'];

                        $date_in=$data['excursion_plan'][$i]['data_inizio'];
                        $date_out=$data['excursion_plan'][$i]['data_fine'];

                        $type=$data['excursion_plan'][$i]['type'];
                        $excursion=$data['excursion_plan'][$i]['excursion'];
                        $durata=$data['excursion_plan'][$i]['durata'];
                        $user=$data['excursion_plan'][$i]['user'];
                        $tot_pax=$data['excursion_plan'][$i]['tot_pax'];
                        $n_gruppo=$data['excursion_plan'][$i]['n_gruppo'];
                        //$gl=$data['excursion_plan'][$i]['id_nome_gruppo'];
                        // $agents=$data['excursion_plan'][$i]['id_agency'];
                        

                        
                    $data['insert_plan']= $this->gestione_centri_model->insert_plan($centro,$rand,$date_in,$date_out,$date_in,$type,$excursion,$durata,$user,$tot_pax,$group_leader,$agente,$n_gruppo);
                } 
        }
        
        if($diff >7 && $diff<= 14){
            $data['excursion_plan']=$this->gestione_centri_model->excursion_selected_14($last_rand,$diff);
        
                 for($i=0; $i<count($data['excursion_plan']); $i++){

                    $centro=$data['excursion_plan'][$i]['id_centro'];
                    $rand=$data['excursion_plan'][$i]['rand'];

                    $date_in=$data['excursion_plan'][$i]['data_inizio'];
                    $date_out=$data['excursion_plan'][$i]['data_fine'];

                        $type=$data['excursion_plan'][$i]['type'];
                        $excursion=$data['excursion_plan'][$i]['excursion'];
                        $durata=$data['excursion_plan'][$i]['durata'];                       
                        $user=$data['excursion_plan'][$i]['user'];
                        $tot_pax=$data['excursion_plan'][$i]['tot_pax'];
                        $n_gruppo=$data['excursion_plan'][$i]['n_gruppo'];
                        $gl=$data['excursion_plan'][$i]['id_nome_gruppo'];
                        $agents=$data['excursion_plan'][$i]['id_agency'];

                    $data['insert_plan']= $this->gestione_centri_model->insert_plan($centro,$rand,$date_in,$date_out,$date_in,$type,$excursion,$durata,$user,$tot_pax,$group_leader,$agente,$n_gruppo);
                } 
        }
              
        if($diff >14){
            $data['excursion_plan']=$this->gestione_centri_model->excursion_selected_extra_14($last_rand,$diff);
        
                 for($i=0; $i<count($data['excursion_plan']); $i++){

                    $centro=$data['excursion_plan'][$i]['id_centro'];
                    $rand=$data['excursion_plan'][$i]['rand'];

                    $date_in=$data['excursion_plan'][$i]['data_inizio'];
                    $date_out=$data['excursion_plan'][$i]['data_fine'];

                        $type=$data['excursion_plan'][$i]['type'];
                        $excursion=$data['excursion_plan'][$i]['excursion'];
                        $durata=$data['excursion_plan'][$i]['durata'];
                        $user=$data['excursion_plan'][$i]['user'];
                        $tot_pax=$data['excursion_plan'][$i]['tot_pax'];
                        $n_gruppo=$data['excursion_plan'][$i]['n_gruppo'];
                        $gl=$data['excursion_plan'][$i]['id_nome_gruppo'];
                        $agents=$data['excursion_plan'][$i]['id_agency'];
                        
                    $data['insert_plan']= $this->gestione_centri_model->insert_plan($centro,$rand,$date_in,$date_out,$date_in,$type,$excursion,$durata,$user,$tot_pax,$group_leader,$agente,$n_gruppo);
                }           
                
        }
 
        $id=$data['id'];
        $data['title'] = 'Insert confirm';
        $this->load->view('agenti_bookingform_validation',$data);
        
               $this->load->library('email');
        $mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
         $mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
                    $mymessage .=   "<strong> l'utente " .$login. " ha appena effettuato una prenotazione... </strong>" ."<br/><br/>";
                    $mymessage .=   "<strong> id pratica: " .$stringa_id. "</strong>";
                    $mymessage .=   "</body></html>";
    
        $this->email->from($email,$login);
        $this->email->to($email);
        $this->email->cc('a.larotella@plus-ed.com');
        $this->email->subject('Insert booking');
        $this->email->message($mymessage);
        $this->email->send(); 
    }

 }else{
     redirect('agenti','refresh'); 
 }
}
function presearch_available_rooms(){
    
    //Recupero il valore dell'utente loggato
    if($this->session->userdata('username') ){
    
        // Fine controllo
        $this->load->model('gestione_centri_model');
        //$data['centri'] = $this->gestione_centri_model->building();
        $data['user']  = $this->session->userdata('username');
        $data['id']  = $this->session->userdata('id');
        
        $login=$data['user'];
        $id=$data['id'];
        $data['title']='Agent research';
        
        $data['agency'] = $this->gestione_centri_model->agency_building();
        $data['centri'] = $this->gestione_centri_model->building();
        $this->load->view('agenti_presearch_rooms', $data);
  }else{
     redirect('agenti','refresh'); 
 }  
}

function search_by_agency() {
    
    $centri=array();
    //Controllo le informazioni riguaro a quell'id

       $data['user']  = $this->session->userdata('username');
            $this->load->model('gestione_centri_model');
            $this->load->library('pagination');
            
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
                
    $data['id']  = $this->session->userdata('id');
    $login=$data['user'];
    $id=$data['id'];
    if($login=='admin'){
        $data['agency'] = $this->gestione_centri_model->search_agency_admin();
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
    }else{
        $data['agency'] = $this->gestione_centri_model->search_agency($login);
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
        $data['business']  = $this->session->userdata('businessname');
        $gl=$data['agency'];
            for($i=0; $i<=count($gl); $i++){
        
                @ $nome_gl= $data['agency'][$i]['id_nome_gruppo'];
                 $data['gl'][$i]=$this->gestione_centri_model->information_name_gl($nome_gl);                  
            } 
        }
    $data['title']='Your booking';

    $this->load->view('agenti_risult_search_agents', $data);
}
function booking_confermation(){
    
    $centri=array();
    //Controllo le informazioni riguaro a quell'id

       $data['user']  = $this->session->userdata('username');
            $this->load->model('gestione_centri_model');
            $this->load->library('pagination');

                
    $data['id']  = $this->session->userdata('id');
    $login=$data['user'];
    $id=$data['id'];
    if($login=='admin'){
        $data['agency'] = $this->gestione_centri_model->search_agency_admin();
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
    }else{
        $data['agency'] = $this->gestione_centri_model->search_agency_confermation($login);
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
        $data['business']  = $this->session->userdata('businessname');
        $gl=$data['agency'];
            for($i=0; $i<=count($gl); $i++){
        
                @ $nome_gl= $data['agency'][$i]['id_nome_gruppo'];
                 $data['gl'][$i]=$this->gestione_centri_model->information_name_gl($nome_gl);                  
            } 
        }
    $data['title']='Confermation Booking';

    $this->load->view('agenti_risult_search_agents_confermation', $data);   
    
}
function price_transfer(){
        if($this->session->userdata('username') ){
           $this->load->model('gestione_centri_model');   
           $data['user']  = $this->session->userdata('username');
           $data['id_user']  = $this->session->userdata('id');  
           $data['business']  = $this->session->userdata('businessname');
           $login=$data['user'];
            
           $data['center']=$this->uri->segment(4);
           $centro = $this->uri->segment(4);
            
           $id_periodi = $this->uri->segment(3); 
           $data['id_periodi']=$id_periodi;

           $data['elenco']= $this->gestione_centri_model->elenco_id_yourbooking($centro,$id_periodi);           
           
           $gl=$data['elenco'];
                @ $nome_gl= $data['elenco'][0]['id_nome_gruppo'];
                  $data['gl']=$this->gestione_centri_model->information_name_gl($nome_gl);
           
            $data['name']  = $this->session->userdata('mainfirstname'); 
            $data['surname']  = $this->session->userdata('mainfamilyname');

            $data['title']='Excursion';
            
          if(!isset ($_POST['gender'])){
             $this->load->view('agenti_excursion', $data);
         }else{
            
            if($this->session->userdata('username') ){
                
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */

                 $this->load->model('gestione_centri_model');   
                    $data['user']  = $this->session->userdata('username');
                    $data['id_user']  = $this->session->userdata('id');  
                    $login=$data['user'];
                    $data['name']  = $this->session->userdata('mainfirstname'); 
                    $data['surname']  = $this->session->userdata('mainfamilyname');

                    $centro = $_POST['centro'];
                    $id_periodi= $_POST['id'];


                    $data['elenco']= $this->gestione_centri_model->elenco_id_yourbooking($centro,$id_periodi);  

                    $gl=$data['elenco'];
                        @ $nome_gl= $data['elenco'][0]['id_nome_gruppo'];
                          $data['gl']=$this->gestione_centri_model->information_name_gl($nome_gl);

                    $centro=$_POST['centro'];
                    $id=$_POST['id'];
                    $gender=$_POST['gender'];

                    $data['lista_destination']= $this->gestione_centri_model->elenco_destinations($centro,$gender);

                    $data['title']='Excursion step 3';

                    $this->load->view('agenti_status_excursion', $data);

                    }else{
                  redirect('agenti','refresh');   
                }
                 }
        }else{
          redirect('agenti','refresh');   
        }
 }

 function scheda_escursione(){
     if($this->session->userdata('username') ){
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
         
        $this->load->model('gestione_centri_model');
        $data['user']  = $this->session->userdata('username');
        $data['id_user']  = $this->session->userdata('id'); 
        $login=$data['user'];
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
        $data['business']  = $this->session->userdata('businessname');        
        $centro=$_POST['centro'];
        $id_periodi=$_POST['id'];
       
        $data['elenco']= $this->gestione_centri_model->elenco_id_yourbooking($centro,$id_periodi);  
           
            $gl=$data['elenco'];
                @ $nome_gl= $data['elenco'][0]['id_nome_gruppo'];
                  $data['gl']=$this->gestione_centri_model->information_name_gl($nome_gl);

        $to=$_POST['excursion']; 
        $gender=$_POST['gender'];

        
        $data['prenotazione'] = $this->gestione_centri_model->prenotazione_escursione($to,$centro,$gender);
        $data['title']='Excursion step finish';
        
        $this->load->view('agenti_totspese_escursioni', $data);

     }else{
         redirect('agenti','refresh');   
        }
    
 }
 
 function insert_excursions(){
      if($this->session->userdata('username') ){
          
          
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
          
        $this->load->model('gestione_centri_model');
        $data['user']  = $this->session->userdata('username');
        $data['id_user']  = $this->session->userdata('id'); 
        $login=$data['user'];
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
        $data['business']  = $this->session->userdata('businessname');
    
        
        $ex=$_POST['excursion'];

        $rand=$_POST['rand'];
        

        $data['insert_excursions'] = $this->gestione_centri_model->insert_excursions($login);
        
        $data['confirmed_excursions'] = $this->gestione_centri_model->confirme_excursions($rand);
        
        $data['extra_excursion']= $this->gestione_centri_model->extra_excursions($ex);
        
        
        $data['title']='Excursion confirmed';
        
        $this->load->view('agenti_insert_escursioni', $data);
         
      }else{
          redirect('agenti','refresh');
      }
 }
 
function extra_excursions (){
     if($this->session->userdata('username') ){
         
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
         
       $this->load->model('gestione_centri_model');
       $data['user']  = $this->session->userdata('username');
       $data['id_user']  = $this->session->userdata('id'); 
       $login=$data['user'];
       $data['name']  = $this->session->userdata('mainfirstname'); 
       $data['surname']  = $this->session->userdata('mainfamilyname');
       $data['business']  = $this->session->userdata('businessname');   
       $rand=$_POST['rand'];
       $data['confirmed_excursions'] = $this->gestione_centri_model->confirme_excursions($rand);
       $extra_ex=$_POST['extra_ex'];
       $ex=$_POST['excursion'];
       
       $data['extra_excursions'] = $this->gestione_centri_model->extra_excursion_details($extra_ex,$ex);
       
       $data['title']='Extra excursion';
       
       $this->load->view('agenti_extra_excursion', $data);
       }else{
          redirect('agenti','refresh');
      }
}
 

function confirm_extra_excursions(){
    if($this->session->userdata('username') ){
        
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
        
       $this->load->model('gestione_centri_model');
       $data['user']  = $this->session->userdata('username');
       $data['id_user']  = $this->session->userdata('id'); 
       $login=$data['user'];
       $data['name']  = $this->session->userdata('mainfirstname'); 
       $data['surname']  = $this->session->userdata('mainfamilyname');
       $data['business']  = $this->session->userdata('businessname');

       
       //$id_extra=$_POST['id_extra'];
       $rand= $_POST['rand'];
       $excursion= $_POST['excursion'];
       $extra_ex= $_POST['extra_ex'];
       $opzione=$_POST['opzione'];
       $prezzo= $_POST['price_plus_agent'];
       $indirizzo= $_POST['indirizzo'];
       
       $data['confirmed_excursions'] = $this->gestione_centri_model->confirme_excursions($rand);
       
       
       $data['insert_extra_excursions'] = $this->gestione_centri_model->insert_extra_excursions($rand,$excursion,$extra_ex,$prezzo,$indirizzo,$opzione,$login);
       
       
       $data['title']='Review prenotation';
       
       $this->load->view('agenti_confirm_extra_excursion', $data);
        
    }else{
       redirect('agenti','refresh'); 
    }
}

function search_center(){
    if($this->session->userdata('username') ){
        
        $data['user']  = $this->session->userdata('username'); 
        $login=$data['user'];
        $data['id']  = $this->session->userdata('id');
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
        $data['business']  = $this->session->userdata('businessname');
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
       $this->load->model('gestione_centri_model');
      
        $center=$_POST['search'];
        $tipo=$_POST['select_search'];

        //Ricerca per centro
        
        if($tipo=='center'){
            
            $data['info']= $this->gestione_centri_model->search_by_center($center,$login);
           
            if($data['info']!= null){
                $data['info']= $this->gestione_centri_model->search_by_center($center,$login);
                $data['title']= 'Risult search center: '.$_POST['search'];
                
                
                $agency=$data['info']; 
                for($i=0; $i<=count($agency); $i++){
        
                    @ $nome_agency= $data['info'][$i]['id_agency'];
                     $data['name_agency'][$i]=$this->gestione_centri_model->information_agency_nagency($nome_agency);
                }

                    //Nome gl //
                $gl=$data['info'];


                    for($i=0; $i<=count($gl); $i++){

                    @ $nome_gl= $data['info'][$i]['id_nome_gruppo'];
                     $data['gl'][$i]=$this->gestione_centri_model->information_name_gl($nome_gl);

                }

                
                $this->load->view('agenti_risult_search_agents_ok', $data);
            }else{

                $data['title']= 'Risult search arrival date: '.$_POST['search'];
                
               $this->load->view('agenti_risult_search_agents_ko', $data);
            }
            
          //Ricerca per data arrivo  
        }elseif($tipo=='date_in'){
            
            $data_inizio=date('Y-m-d',strtotime($_POST['search_by_center']));
            
            $data['info']= $this->gestione_centri_model->search_by_date($data_inizio,$login);
            
            
            if($data['info']!= null){
                        
                $data_inizio=$_POST['search_by_center'];
                
                
                $data['info']= $this->gestione_centri_model->search_by_date($data_inizio,$login);

                $data['title']= 'Risult search arrival date: '.$_POST['search'];
                
                
                $agency=$data['info']; 
                for($i=0; $i<=count($agency); $i++){
        
                    @ $nome_agency= $data['info'][$i]['id_agency'];
                     $data['name_agency'][$i]=$this->gestione_centri_model->information_agency_nagency($nome_agency);
                }

                    //Nome gl //
                $gl=$data['info'];


                    for($i=0; $i<=count($gl); $i++){

                    @ $nome_gl= $data['info'][$i]['id_nome_gruppo'];
                     $data['gl'][$i]=$this->gestione_centri_model->information_name_gl($nome_gl);

                }

                
                $this->load->view('agenti_risult_search_agents_ok', $data);
            }else{
               
                
                $data['title']= 'Risult search arrival date: '.$_POST['search'];
                
               $this->load->view('agenti_risult_search_agents_ko', $data);
            }
            
         //Ricerca per data partenza
            
        }elseif($tipo=='date_dep'){
            
            $data_fine=$_POST['search_by_center'];
            $data['info']= $this->gestione_centri_model->search_by_date_dep($data_fine,$login);
            
            if($data['info']!= null){
                $data_fine=date('Y-m-d',strtotime($_POST['search_by_center']));
                $data['info']= $this->gestione_centri_model->search_by_date_dep($data_fine,$login);
                $data['title']= 'Risult search departure date: '.$_POST['search'];
                
                
                        $agency=$data['info']; 
                        for($i=0; $i<=count($agency); $i++){

                            @ $nome_agency= $data['info'][$i]['id_agency'];
                             $data['name_agency'][$i]=$this->gestione_centri_model->information_agency_nagency($nome_agency);
                        }

                            //Nome gl //
                        $gl=$data['info'];


                            for($i=0; $i<=count($gl); $i++){

                            @ $nome_gl= $data['info'][$i]['id_nome_gruppo'];
                             $data['gl'][$i]=$this->gestione_centri_model->information_name_gl($nome_gl);

                        }
                 $this->load->view('agenti_risult_search_agents_ok', $data);
            }else{
                
                
                $data['title']= 'Risult search departure date: '.$_POST['search'];
                
               $this->load->view('agenti_risult_search_agents_ko', $data);
            }
        }elseif($tipo==''){
                       
           $data['title']= 'Risult search select nothing';
           
           $this->load->view('agenti_risult_search_agents_ko', $data);         
        }
    }else{
        redirect('agenti','refresh');
    }
}

function info_agency(){
    $this->load->model('gestione_centri_model');
        $data['user']  = $this->session->userdata('username');
        
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
        
        $data['id']  = $this->session->userdata('id');
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
        $data['business']  = $this->session->userdata('businessname');
        
        $login=$data['user'];
        $id=$data['id'];
        
        $data['agency'] = $this->gestione_centri_model->agency_building();
        $data['user_log']=$this->gestione_centri_model->groupleader_log($id);
        $id_pratica = $this->uri->segment(3);
        
        
        $data['title']='Details agent';
        
        $data['group'] = $this->gestione_centri_model->information_agency($id_pratica);

        $data_inizio = $data['group'][0]['data_inizio'];
        $data_fine = $data['group'][0]['data_fine'];
        $diff= round(abs(strtotime($data_fine) - strtotime($data_inizio))/86400); 
        
        
        
        
        $centro= $data['group'][0]['id_centro'];
        
        $data['excursion_pack']= $this->gestione_centri_model->excursion_pack($centro);
        
        if ($diff <=7) {
            $data['excursion_pack_half']= $this->gestione_centri_model->excursion_pack_half_7($centro);
            $data['excursion_pack_full']= $this->gestione_centri_model->excursion_pack_full_7($centro);
        }
        if($diff >7 && $diff<= 14) {
            $data['excursion_pack_half']= $this->gestione_centri_model->excursion_pack_half_14($centro);
            $data['excursion_pack_full']= $this->gestione_centri_model->excursion_pack_full_14($centro); 
        }
        if($diff >14){
            $data['excursion_pack_half']= $this->gestione_centri_model->excursion_pack_half_21($centro);
            $data['excursion_pack_full']= $this->gestione_centri_model->excursion_pack_full_21($centro);             
        }
        
        $data['excursion'] = $this->gestione_centri_model->list_excursion_scheda($id_pratica);
        
        $data['excursion_half'] = $this->gestione_centri_model->list_excursion_scheda_half($id_pratica);

        $data['extra_excursion'] = $this->gestione_centri_model->list_extra_excursion_scheda($id_pratica);

        $data['transfer'] = $this->gestione_centri_model->list_transfer($id_pratica);
        
        $agency=$data['group']; 
        for($i=0; $i<=count($agency); $i++){
        
        @ $nome_agency= $data['group'][$i]['id_agency'];
         $data['name_agency'][$i]=$this->gestione_centri_model->information_agency_nagency($nome_agency);
    }

        //Nome gl //
    $gl=$data['group'];
    
    
        for($i=0; $i<=count($gl); $i++){
        
        @ $nome_gl= $data['group'][$i]['id_nome_gruppo'];
         $data['gl'][$i]=$this->gestione_centri_model->information_name_gl($nome_gl);
         
    }
    $this->load->view('agenti_info_details', $data);
}

function delete_excursion(){
    if($this->session->userdata('username') ){
       $this->load->model('gestione_centri_model');
       
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
       $data['name']  = $this->session->userdata('mainfirstname'); 
       $data['surname']  = $this->session->userdata('mainfamilyname'); 
       $data['business']  = $this->session->userdata('businessname');
       
       $id = $this->uri->segment(3);
       $data['delete_excursion']= $this->gestione_centri_model->delete_excursion($id);
       
            $data['user']  = $this->session->userdata('username');
            $data['id']  = $this->session->userdata('id');
            $login=$data['user'];
            $id=$data['id'];
  
        $data['agency'] = $this->gestione_centri_model->search_agency($id);
        
        $gl=$data['agency'];
            for($i=0; $i<=count($gl); $i++){
        
                @ $nome_gl= $data['agency'][$i]['id_nome_gruppo'];
                 $data['gl'][$i]=$this->gestione_centri_model->information_name_gl($nome_gl);                  
            }

    $data['title']='Risult search by agent';

    
        redirect('agenti/search_by_agency');

    }else{
       redirect('agenti','refresh');  
    }
}

function delete_extra_excursion(){
     if($this->session->userdata('username') ){
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
       $this->load->model('gestione_centri_model');
       $data['name']  = $this->session->userdata('mainfirstname'); 
       $data['surname']  = $this->session->userdata('mainfamilyname'); 
       $id = $this->uri->segment(3);
       $data['delete_excursion']= $this->gestione_centri_model->delete_extra_excursion($id);
       
    $data['user']  = $this->session->userdata('username');
    $data['id']  = $this->session->userdata('id');
    $login=$data['user'];
    $id=$data['id'];
  
        $data['agency'] = $this->gestione_centri_model->search_agency($id);
        
        $gl=$data['agency'];
            for($i=0; $i<=count($gl); $i++){
        
                @ $nome_gl= $data['agency'][$i]['id_nome_gruppo'];
                 $data['gl'][$i]=$this->gestione_centri_model->information_name_gl($nome_gl);                  
            }

    $data['title']='Risult search by agent';

    
    $this->load->view('agenti_risult_search_agents', $data);

    }else{
       redirect('agenti','refresh');  
    }   
}

function confirm_datain(){
            $this->load->model('gestione_centri_model');
                        $data['user']  = $this->session->userdata('username');
        $data['id']  = $this->session->userdata('id');
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
        $login=$data['user'];
        $id=$data['id'];
        
        $data['agency'] = $this->gestione_centri_model->agency_building();
        $data['user_log']=$this->gestione_centri_model->groupleader_log($id);
            $id = $this->uri->segment(3);
            $data['ok'] = $this->gestione_centri_model->ok_in($id);
            
           $this->load->view('agenti_confirm_ok', $data);
        }
  
function confirm_dataout(){
            $this->load->model('gestione_centri_model');
                        $data['user']  = $this->session->userdata('username');
        $data['id']  = $this->session->userdata('id');
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
        $login=$data['user'];
        $id=$data['id'];
        
        $data['agency'] = $this->gestione_centri_model->agency_building();
        $data['user_log']=$this->gestione_centri_model->groupleader_log($id);
            $id = $this->uri->segment(3);
            $data['ok'] = $this->gestione_centri_model->ok_out($id);
            $this->load->view('agenti_confirm_ok', $data);

        } 
        
function take(){
//Recupero il valore dell'utente loggato
    if($this->session->userdata('username') ){ 

        
            /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                            $data['attivi']=true;
                        }else{
                            $data['attivi']=false;
                        }
            */
        
        $this->load->helper(array('form', 'url'));
        $this->load->library('validation');
        $this->validation->set_error_delimiters('<div class="error"> ** ', ' ** </div>');
        $this->load->model('gestione_centri_model');
        $data['agency'] = $this->gestione_centri_model->agency_building();  
        $data['centri'] = $this->gestione_centri_model->building();
        $data['aereo_in'] = $this->gestione_centri_model->airport();
        $data['aereo_out'] = $this->gestione_centri_model->airport_back();
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
        $data['business']  = $this->session->userdata('businessname');        
        $data['user']  = $this->session->userdata('username');
        $data['id']  = $this->session->userdata('id');
        $login=$data['user'];
        $id=$data['id'];
        $data['title']='Update - Previsional';
        $id_p = $this->uri->segment(3);
        
        $data['up'] = $this->gestione_centri_model->take($id_p); 

        $data['id_pratica']=$data['up'][0]['rand'];
        
        
        $glss=$data['up'];          
                @ $nome_gl= $data['up'][0]['id_nome_gruppo'];
                $data['glss']=$this->gestione_centri_model->information_name_gl($nome_gl);           
                
                
                
                $this->load->view('agenti_previsional_update', $data);
    }else{
        redirect('agenti','refresh'); 
    }
}

function take_gl(){
    if($this->session->userdata('username') ){
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
        
        $this->load->helper(array('form', 'url'));
        $this->load->model('gestione_centri_model');
        $data['name']  = $this->session->userdata('mainfirstname'); 
        $data['surname']  = $this->session->userdata('mainfamilyname');
        $data['business']  = $this->session->userdata('businessname');
        
        $data['user']  = $this->session->userdata('username');
        $data['id']  = $this->session->userdata('id');
        $login=$data['user'];
        $id=$data['id'];
        $data['title']='Update-group leader';
        $data['doc']=$this->uri->segment(3);
        $id_p = $this->uri->segment(3);
        
        $data['up'] = $this->gestione_centri_model->take($id_p);        
        $data['id_pratica']=$data['up'][0]['rand']; 
        
        $glss=$data['up'];          
                @ $nome_gl= $data['up'][0]['id_nome_gruppo'];
                $data['glss']=$this->gestione_centri_model->information_name_gl($nome_gl);           
                
                $this->load->view('agenti_previsional_take_gl', $data);
    }else{
       redirect('agenti','refresh');  
    }   
    
}

function update_gl(){
             $this->load->model('gestione_centri_model');
            $data['user']  = $this->session->userdata('username');
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
            
            $data['id']  = $this->session->userdata('id');
            $data['name']  = $this->session->userdata('mainfirstname'); 
            $data['surname']  = $this->session->userdata('mainfamilyname');
            $data['business']  = $this->session->userdata('businessname');   
            $doc=$_POST['doc'];
            $id_gl=$_POST['agent'];
            $gl=$_POST['agents'];
            $data['update'] = $this->gestione_centri_model->update_gl($id_gl,$gl);
            
            redirect('agenti/take/'.$doc,'refresh');
 
}

function update(){
            $this->load->model('gestione_centri_model');
            $data['user']  = $this->session->userdata('username');
    /* if(($this->session->userdata('username')=='Ste')||($this->session->userdata('username')=='ricki')||($this->session->userdata('username')=='IBM_EBhDA')){
                    $data['attivi']=true;
                }else{
                    $data['attivi']=false;
                }
    */
            
            $data['id']  = $this->session->userdata('id');
            $data['name']  = $this->session->userdata('mainfirstname'); 
            $data['surname']  = $this->session->userdata('mainfamilyname');
            $data['business']  = $this->session->userdata('businessname');
            $login=$data['user'];
            $id=$data['id'];
        
            $data['agency'] = $this->gestione_centri_model->agency_building();
            $data['user_log']=$this->gestione_centri_model->groupleader_log($id);
            $id = $this->uri->segment(3);
            
            $data['update'] = $this->gestione_centri_model->update($id,$login);
            
            $last_rand=$_POST['rand'];
            $data['delete_ex_plan']= $this->gestione_centri_model->delete_ex_plan($last_rand);
            
            // inserimento excursion  plan
 
           $d1=$_POST['date_start'];          
           $d2=$_POST['date_end'];
        
        //funziona conta giorni tra due date//            
                $diff= round(abs(strtotime($d2) - strtotime($d1))/86400);     
        //fine//      
   
                $agente=$_POST['agents'];
                
                $group_leader=$_POST['agenti'];
        if($diff <= 7){
            
               $data['excursion_plan']=$this->gestione_centri_model->excursion_selected_7($last_rand,$diff);
               
                 for($i=0; $i<count($data['excursion_plan']); $i++){

                        $centro=$data['excursion_plan'][$i]['id_centro'];
                        $rand=$data['excursion_plan'][$i]['rand'];

                        $date_in=$data['excursion_plan'][$i]['data_inizio'];
                        $date_out=$data['excursion_plan'][$i]['data_fine'];

                        $type=$data['excursion_plan'][$i]['type'];
                        $excursion=$data['excursion_plan'][$i]['excursion'];
                        $durata=$data['excursion_plan'][$i]['durata'];
                        $user=$data['excursion_plan'][$i]['user'];
                        $tot_pax=$data['excursion_plan'][$i]['tot_pax'];
                        $n_gruppo=$data['excursion_plan'][$i]['n_gruppo'];
                        //$gl=$data['excursion_plan'][$i]['id_nome_gruppo'];
                       // $agents=$data['excursion_plan'][$i]['id_agency'];
                    
                    $data['insert_plan']= $this->gestione_centri_model->insert_plan($centro,$rand,$date_in,$date_out,$date_in,$type,$excursion,$durata,$user,$tot_pax,$group_leader,$agente,$n_gruppo);
                } 
        }
        
        if($diff >7 && $diff<= 14){
            $data['excursion_plan']=$this->gestione_centri_model->excursion_selected_14($last_rand,$diff);
        
                 for($i=0; $i<count($data['excursion_plan']); $i++){

                    $centro=$data['excursion_plan'][$i]['id_centro'];
                    $rand=$data['excursion_plan'][$i]['rand'];

                    $date_in=$data['excursion_plan'][$i]['data_inizio'];
                    $date_out=$data['excursion_plan'][$i]['data_fine'];

                        $type=$data['excursion_plan'][$i]['type'];
                        $excursion=$data['excursion_plan'][$i]['excursion'];
                        $durata=$data['excursion_plan'][$i]['durata'];                       
                        $user=$data['excursion_plan'][$i]['user'];
                        $tot_pax=$data['excursion_plan'][$i]['tot_pax'];
                        $n_gruppo=$data['excursion_plan'][$i]['n_gruppo'];
                      //  $gl=$data['excursion_plan'][$i]['id_nome_gruppo'];
                      //  $agents=$data['excursion_plan'][$i]['id_agency'];

                    $data['insert_plan']= $this->gestione_centri_model->insert_plan($centro,$rand,$date_in,$date_out,$date_in,$type,$excursion,$durata,$user,$tot_pax,$group_leader,$agente,$n_gruppo);
                } 
        }
              
        if($diff >14){
            $data['excursion_plan']=$this->gestione_centri_model->excursion_selected_extra_14($last_rand,$diff);
        
                 for($i=0; $i<count($data['excursion_plan']); $i++){

                    $centro=$data['excursion_plan'][$i]['id_centro'];
                    $rand=$data['excursion_plan'][$i]['rand'];

                    $date_in=$data['excursion_plan'][$i]['data_inizio'];
                    $date_out=$data['excursion_plan'][$i]['data_fine'];

                        $type=$data['excursion_plan'][$i]['type'];
                        $excursion=$data['excursion_plan'][$i]['excursion'];
                        $durata=$data['excursion_plan'][$i]['durata'];
                        $user=$data['excursion_plan'][$i]['user'];
                        $tot_pax=$data['excursion_plan'][$i]['tot_pax'];
                        $n_gruppo=$data['excursion_plan'][$i]['n_gruppo'];
                       // $gl=$data['excursion_plan'][$i]['id_nome_gruppo'];
                      //  $agents=$data['excursion_plan'][$i]['id_agency'];
                        
                    $data['insert_plan']= $this->gestione_centri_model->insert_plan($centro,$rand,$date_in,$date_out,$date_in,$type,$excursion,$durata,$user,$tot_pax,$group_leader,$agente,$n_gruppo);
                }           

        }    
          //  $data['update_option_excursion']=$this->gestione_centri_model->update_option_excursion($last_rand);
 
           
           $tot_pax=($_POST['totpax']+$_POST['n_group']);
           $rand=($_POST['rand']);
           
           //Elenco escursioni confermate per quell id pratica
          
           $data['excursion_plan']= $this->gestione_centri_model->excursion_plan($rand);

           
        if($data['excursion_plan']!=null){  
            
          // conto il numero delle escursioni
          $excursion=count($data['excursion_plan']);

          
           for($i=0;$i<$excursion;$i++){
               //$data['excursion_plan']= $this->gestione_centri_model->excursion_plan($rand);

               
                   $to=$data['excursion_plan'][$i]['excursion'];
                   $centro=$data['excursion_plan'][$i]['centro'];
                   $gender=$data['excursion_plan'][$i]['type'];
                  /* 
                   echo "<ul>";
                   echo "<li>".$to."</li>";
                   echo "<li>".$centro."</li>";
                   echo "<li>".$gender."</li>";
                   echo "</ul>";
                   
                   * 
                   */
                $data['prenotazione'] = $this->gestione_centri_model->prenotazione_escursione($to,$centro,$gender);   
                    
                    
                     if(@$data['prenotazione'][$i]['fleet_14']>=$tot_pax){
                        
                                     $price_14=ceil($data['prenotazione'][$i]['price_14']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;
                                  $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);  
                                } elseif(@$data['prenotazione'][$i]['fleet_16']>=$tot_pax){
                                     echo "16";
                                     $price_16=ceil($data['prenotazione'][$i]['price_16']*(1+16.5/100));
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                    
                                  $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);                                  }elseif($data['prenotazione'][0]['fleet_24']>=$tot_pax){
                                  }elseif(@$data['prenotazione'][$i]['fleet_24']>=$tot_pax) {
                                      echo "24";
                                     $price_24=ceil($data['prenotazione'][$i]['price_24']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                     $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);  
                                 }elseif(@$data['prenotazione'][$i]['fleet_25']>=$tot_pax){
                                     $price_25=ceil($data['prenotazione'][$i]['price_25']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                     $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_28']>=$tot_pax){
                                     $price_28=ceil($data['prenotazione'][$i]['price_28']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                    $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_29']>=$tot_pax){
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                     $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_33']>=$tot_pax){
                                     $price_33=ceil($data['prenotazione'][$i]['price_33']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                     $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_35']>=$tot_pax){
                                     $price_35=ceil($data['prenotazione'][$i]['price_35']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                    $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_38']>=$tot_pax){
                                     $price_38=ceil($data['prenotazione'][$i]['price_38']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                     $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_41']>=$tot_pax){
                                     echo "41";
                                     $price_41=ceil($data['prenotazione'][$i]['price_41']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                    $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_45']>=$tot_pax){                     
                                     $price_45=ceil($data['prenotazione'][$i]['price_45']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                     $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_49']>=$tot_pax){
                                     echo "49";
                                     $price_49=ceil($data['prenotazione'][$i]['price_49']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                     $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_50']>=$tot_pax){
                                     $price_50=ceil($data['prenotazione'][$i]['price_50']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                    $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_51']>=$tot_pax){
                                     $price_51=ceil($data['prenotazione'][$i]['price_51']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                    $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_53']>=$tot_pax){
                                     $price_53=ceil($data['prenotazione'][$i]['price_53']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                     $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_55']>=$tot_pax){
                                     $price_55=ceil($data['prenotazione'][$i]['price_55']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                    $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_57']>=$tot_pax){
                                     $price_57=ceil($data['prenotazione'][$i]['price_57']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                     $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_57,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_70']>=$tot_pax){
                                     $price_70=ceil($data['prenotazione'][$i]['price_70']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;
                                     $price_75=$data['prenotazione'][$i]['price_75']*0;                                     
                                    $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }elseif(@$data['prenotazione'][$i]['fleet_75']>=$tot_pax){
                                     $price_75=ceil($data['prenotazione'][$i]['price_75']*(1+16.5/100));
                                     $price_16=$data['prenotazione'][$i]['price_16']*0;
                                     $price_24=$data['prenotazione'][$i]['price_24']*0;
                                     $price_25=$data['prenotazione'][$i]['price_25']*0;
                                     $price_28=$data['prenotazione'][$i]['price_28']*0;
                                     $price_29=$data['prenotazione'][$i]['price_29']*0;
                                     $price_33=$data['prenotazione'][$i]['price_33']*0;
                                     $price_35=$data['prenotazione'][$i]['price_35']*0;
                                     $price_38=$data['prenotazione'][$i]['price_38']*0;
                                     $price_41=$data['prenotazione'][$i]['price_41']*0;
                                     $price_45=$data['prenotazione'][$i]['price_45']*0;
                                     $price_49=$data['prenotazione'][$i]['price_49']*0;
                                     $price_50=$data['prenotazione'][$i]['price_50']*0;
                                     $price_51=$data['prenotazione'][$i]['price_51']*0;
                                     $price_53=$data['prenotazione'][$i]['price_53']*0;
                                     $price_55=$data['prenotazione'][$i]['price_55']*0;
                                     $price_57=$data['prenotazione'][$i]['price_57']*0;
                                     $price_70=$data['prenotazione'][$i]['price_70']*0;
                                     $price_14=$data['prenotazione'][$i]['price_14']*0;                                     
                                    $this->gestione_centri_model->update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand);
                                 }

                    }
                
 
           }
          
               

            $gl_name=$_POST['agent'];
  
          //  $data['update_group'] = $this->gestione_centri_model->update_group($gl,$gl_name);
            
            $data['title'] = "Update booking";
            $this->load->view('agenti_update_validation', $data);
        }        

function delete_check(){
        $this->load->model('gestione_centri_model');
            $data['user']  = $this->session->userdata('username'); 
            $data['id']  = $this->session->userdata('id');
            $data['name']  = $this->session->userdata('mainfirstname'); 
            $data['surname']  = $this->session->userdata('mainfamilyname');
            $data['business']  = $this->session->userdata('businessname'); 
            $rand = $this->uri->segment(3);
            
            $this->gestione_centri_model->delete_ex_conf($rand);
            $this->gestione_centri_model->delete_ex_ex_conf($rand);
            $this->gestione_centri_model->delete_ex_plan_conf($rand);
            $this->gestione_centri_model->delete_join_trasp($rand);
            $this->gestione_centri_model->delete_periodi($rand);
            
           // $this->load->view('agenti_risult_search_agents', $data);
            
            redirect('agenti/search_by_agency','refresh');
}        
        
function retrieve_accomodation(){
    
    $this->load->model('gestione_centri_model');
    
    $data['accomod'] = $this->gestione_centri_model->accomodation($_POST['data']);
        echo "<label>Accomodation</label>";
    if($data['accomod'][0]['ensuite']!=''){
        echo"<br>";
        echo "<h3>college</h3>";
        echo"<br>";
        echo "<div align=\"left\"><input type=\"radio\" name=\"choose\" id=\"accomodation_ensuite\" value=\"College En suite\" />EN SUITE<br /></div>";
        echo"<br>";
    }
    if($data['accomod'][0]['standard']!=''){
        echo "<h3>college</h3>";
        echo"<br>";
        echo "<div align=\"left\"><input type=\"radio\" name=\"choose\" id=\"accomodation_standard\" value=\"College Standard\" />STANDARD<br /></div>";
        echo"<br>";
    }
    if($data['accomod'][0]['homestay']){
        echo "<h3>Home stay</h3>";
        echo"<br>";
        echo "<div align=\"left\"><input type=\"radio\" name=\"choose\" id=\"accomodation_homestay\" value=\"Home stay\" />HOME STAY<br /></div>";
        echo "<br>";
     }
}        
        
function retrieve (){	
	 $this->load->model('gestione_centri_model');
    //ARRAY PER LO SCRIPT

		$expectedValues=array();
		$selectionArr=array();
		
		// ARRAY TEMPORANEI PER GENERARE I PRECEDENTI ARRAY expectedValues selectionArr
		$temp_prov=array();
		$selprovincia=array();
		$nomiprovince=array();
		
		// CHIAMO LA LISTA DELLE AGENCY E METTO IN ARRAY
		$data['agency'] = $this->gestione_centri_model->agency_building(); 


		/* CICLO IN AGENCY */
		 foreach ($data['agency'] as $selregione){
		// PER OGNI AGENCY CHIEDO QUALI GRUPPI		
				$temp_prov = $this->gestione_centri_model->groupleader($selregione['id']);
                                
       
		//CICLO NELLE GRUPPI PER CREARE L'ASSOCIAZIONE A AGENZIE		
				foreach ($temp_prov as $selprovincia){
						
						array_push($nomiprovince,array($selprovincia['name_group'],$selprovincia['id']));

				}
 

				
		//SALVO LE DUE VARIABILI DA PASSARE ALLO SCRIPT				
				$selectionArr[$selregione['id']]= $nomiprovince;
				array_push($expectedValues, $selregione['id']);
                                print_r ($nomiprovince);
				$nomiprovince=array();
		 }
						
					
		
		
		if (isset($_POST['data']) and in_array($_POST['data'], $expectedValues)){
			$selectedArr = $selectionArr[$_POST['data']];
			foreach($selectedArr as $optionValue){
                            
				echo "<option value=\"".$optionValue[1]."\">" . $optionValue[0] . "</option>";
			}
		}	
                
}
}


/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */