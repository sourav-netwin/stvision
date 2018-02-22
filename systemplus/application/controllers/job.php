<?php

class Job extends Controller {

	public function __construct(){
	
		parent::Controller();
		$this->load->helper(array('form', 'url'));
	}


function index()
		{
			
			
			$this->load->model('mcms');		
			
			$data['title']="PLUS EDUCATIONAL | CURRENT OPPORTUNITIES";
			$data['heading'] ="CURRENT OPPORTUNITIES";
			//$data['joblist'] = array('SUMMER CAMPS','TEACHING','OPERATION','SALES','MARKETING','FINANCE');
			$data['testomiddle'] = "Since";	
			
		    $data['navlist'] = $this->MCatsjob->navcategorie();
                    
                   
			
			$this->load->view('job_view', $data);
			

		}
		
function cat(){
			$data['mainf'] = $this->MCatsjob->getCategory($this->uri->segment(3));
			if (!count($data)){
				redirect('welcome/index','refresh');
			}
			
			$data_cat = array(
               '1' => 'Teaching',
               '2' => 'Marketing',
               '3' => 'Summerjob',
			   '4' => 'operation',
			   '5' => 'Finance',
			   '7' => 'Sales'
			);
		
			$data['title'] = "Summer Job  Category | " ;
			$data['heading'] ="Summer Jobs";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			$data['categ'] = $data_cat[$this->uri->segment(3)];
			if($this->uri->segment(4) == null){
			$data['testomiddle'] = "<h2>Our Company</h2> " .
									"<strong> Professional Linguistic & Upper Studies</strong> started operating in the EFL market in 1972. Today, our group with 36 centres (colleges and universities) in America, Malta, Canada, Ireland,  Italy, UK  and its offices in <strong>London, Dublin, New York , Malta, </strong> and <strong>Milan</strong> represents one of the world's largest and finest organisations in language teaching. </br> </br> </br>" .
									"<h2>Our Courses</h2> " . 
									"Last year more than 26000 students from all part of the world, aged between 10 and 18, enrolled on our EFL courses. Our study courses are structured on five different levels:  Elementary, Pre-Intermediate, Intermediate, Upper-Intermediate and Advanced, and planned on functional and communicative language studies with specific focus on vocabulary and pronunciation skills. We use specially-designed text books specifically written for teenage students on short summer courses and a wide range of supplementary materials, resource books and EFL course books are made available to the teachers who are strongly encouraged to being creative and trying new ideas. Courses usually last for two or three weeks and also include a full leisure and excursion programme.";
			}
			if($this->uri->segment(4)=="teacher"){
				$data['testomiddle'] = "<h1>SUMMER   TEACHERS  POST SPECIFICATION</h1>" . 
										"<strong>If you hold </strong> a recognised TEFL qualification such as</strong></br>" .
										"<ul><li>RSA/UCLES certificate in English language teaching to adults (CELTA) </li><li>Trinity College certificate in teaching English to speakers of other languages (TESOL) </li><li>RSA/UCLES diploma in English language teaching to Adults (DELTA) </li><li>Trinity College licentiate diploma in TESOL</li><li>PGCE with TEFL as a major component</li>MA/MSc in applied linguistics or TEFL with proof of at least 10 hours observed teaching</li> </br>Other equivalent qualifications may also be acceptable</ul> </br></br>" .
										"<strong>If you can</strong> </br><ul><li>plan lessons effectively, appropriate to both the course objectives and the needs of students</li><li>implement teaching techniques appropriate for the objective and level of the course and for the needs of students</li><li>manage learning resources appropriately and effectively </li><li>appropriate feedback and correction techniques</li><li>are able to create a positive learning atmosphere within the classroom</li></ul></br></br>then  you can apply  to become a <strong>PLUS teacher </strong> at  one  of our 22 summer centres all over the UK, Scotland and Ireland.</br></br>You will  work  a total of  9 sessions per week  (one session = 4 x 45 minute language class plus 4 activity sessions - one  full day excursion =  2 sessions) </br></br>You will  receive a weekly salary  between �  230,00  and  �  270,00   <strong>PLUS</strong>  full board accommodation  (residential teachers only) <strong>PLUS a 2 week Holiday  Voucher for 2 people</strong> if you  accomplish your job to an excellent standard.</br></br><strong>Job description  outlines </strong></br>Teachers  are required to teach in  the morning and/or afternoon following the school requirements and to assist students during their  free time activities and/or  visits and excursions (sessions). These may take place in the afternoon, on week ends and/or  in the evening (residential teachers only). Teachers may also participate in weekly training sessions, organised to further enhance their lesson planning and delivery.  </br></br>If  your application is successful  you will be requested to  sign a declaration that you are not unfit to be working with children under 16.Please note that prior to commencing employment  your references from previous employers will be followed up, and that PLUS may require you to undergo an Enhanced  CRB disclosure. Please note also that any gaps in CVs must be explained satisfactorily.";
			}
			if($this->uri->segment(4)=="course"){
					$data['testomiddle'] = "<h1>COURSE   DIRECTOR POST SPECIFICATION </h1> </br></br><strong>If you hold </strong> a recognised higher qualification in TEFL (for all UK centres), for example:<ul><li>RSA/UCLES diploma in TEFL (Cambridge DELTA) </li>	<li>Trinity College licentiate diploma in TESOL</li><li>PGCE with TEFL as a major component</li><li>MA /MSc in TEFL or applied linguistics with proof of 10 hours observed teaching</li></ul></br></br>Or  <strong>if you have </strong> </br><ul><li>Qualified teacher status for the secondary school age group, combined with considerable TEFL experience </li><li>Approximately five years ELT teaching experience, particularly with PLUS, and some experience of leading other teachers</li></ul></br></br><strong>If you are </strong></br><ul><li>committed to building a hard-working team of teachers, motivate and inspire them to attain the high standards expected</li><li>determined to make the summer course a success for all concerned through your good organisational, administrative and computing skills</li></ul></br>You can apply  to become a <strong>PLUS Course Director</strong> at one of our 22  beautiful centres all over the UK, Scotland and Ireland. </br></br>You will receive a weekly salary between � 400,00   and  �  520,00   <strong>PLUS</strong> full board accommodation * <strong>PLUS</strong>  a <strong>2 week Holiday  Voucher for 2 people</strong>   if you  accomplish your job to an excellent standard. </br></br><strong>Job description  outlines </strong></br>CDs are responsible for delivering the academic programme in the centre. The role is challenging, often pressured, but rewarding and never dull. The responsibilities are many and varied but include: building and leading a team of teachers to deliver high quality language classes, lesson planning support, observing teachers, liaising with clients, organising placement tests and timetables on a regular basis. CDs will have excellent interpersonal and communication skills, and be able to adapt to changing circumstances, often at short notice. The CD role also requires a considerable amount of organisation, commitment and hard work. Depending on the number of students at the centre, CDs are often assisted by an Assistant Course Director</br></br>If  your application is successful  you will be requested to  sign a declaration that you are not unfit to be working with children under 16.  Please note that prior to commencing employment  your references from previous employers will be followed up, and that PLUS may require you to undergo an Enhanced  CRB disclosure. Please note also that any gaps in CVs must be explained satisfactorily.</br></br>*   Conditions apply";
			}
			if($this->uri->segment(4)=="assistant"){
					$data['testomiddle'] = "<h1>ASSISTANT COURSE DIRECTOR POST SPECIFICATION </h1> </br></br><strong>If you hold</strong></br>a recognised TEFL qualification and/or qualified teacher status for the secondary school age group with some EFL teaching experience; for example:<lu><li>RSA/UCLES certificate in English language teaching to adults (CELTA) </li><li>Trinity College certificate in teaching English to speakers of other languages (TESOL) </li><li>RSA/UCLES diploma in English language teaching to Adults (DELTA) </li><li>Trinity College licentiate diploma in TESOL</li><li>PGCE with TEFL as a major component</li><li>MA/MSc in applied linguistics or TEFL with proof of at least 10 hours observed teaching</li></lu>Other equivalent qualifications may also be acceptable - these should consist of a minimum of four weeks full- time training plus observed teaching practice</br></br><strong>If you are</strong><lu><li>Full of energy, enthusiasm, team spirit, flexibility,  and able to work with and motivate young people</li><li>committed to making the summer course a success </li></lu></br>You can apply to become a<strong> PLUS Assistant Course Director</strong> at one of our 22 beautiful centres all over the UK, Scotland and Ireland.</br></br>You are expected to work mornings (usually teaching) and afternoons (usually administrative duties) for 5 days a week. </br></br>You will receive a weekly salary between �  320,00   and � 370,00  <strong>PLUS</strong> full board accommodation *<strong>PLUS</strong>    a <strong>2 week Holiday  Voucher for 2 people</strong>  if you  accomplish your job to an excellent standard. </br></br><strong>Job description  outlines </strong></br>Assistant Course Directors carry out the duties of a teacher, but in addition assist with the academic administration of the course, usually  by planning, observing teachers, liaising with clients, organising placement tests and timetables on a regular basis,  and by acting as a Teacher Mentor for the less-experienced members of the team, He/she will also help out with paperwork, quality  and visa student control. For many experienced and suitably qualified teachers it can be a great first move into management. </br></br>If your application is successful you will be requested to sign a declaration that you are not unfit to be working with children under 16.Please note that prior to commencing employment your references from previous employers will be followed up, and that PLUS may require you to undergo an Enhanced CRB disclosure. Please note also that any gaps in CVs must be explained satisfactorily. </br></br>*   Conditions apply";
			}
			if($this->uri->segment(4)=="leader"){
					$data['testomiddle'] = "<h1>RESIDENTIAL ACTIVITY LEADERS POST SPECIFICATION</h1></br></br><strong>If you can</strong><ul><li>plan, establish, organise and promote leisure activities effectively</li><li>encourage and motivate students to participate to the leisure programme</li><li>address large groups of young people</li><li>manage the provided equipment appropriately and effectively</li><li>create a positive entertaining atmosphere on campus</li></ul></br><strong>If you are </strong><ul><li>competent sports/games person with knowledge of the rules and organisation of one or more sports/games</li><li>full of energy, enthusiasm, team spirit, flexibility,  and able to work with and motivate young people</li><li>committed to making the summer camp a success for all concerned </li></ul></br>then, You can apply to become a <strong>PLUS Residential Activity Leader</strong>  at one of our 22  beautiful centres all over the UK, Scotland and Ireland. </br></br>You will receive a weekly salary between �  180,00   and  �  200,00   <strong>PLUS</strong>  full board accommodation, <strong>PLUS </strong> a <strong>2 week Holiday  Voucher for 2 people </strong>  if you  accomplish your job to an excellent standard. </br></br><strong>Job description  outlines </strong></br></br>Activity Leaders are responsible for promoting, organising and running all activities and events, as well as encouraging and motivating students to participate in the leisure programme. Activity Leaders are also expected to help students to practise their English by socialising with them and talking to them during their lesson - breaks and meals. Furthermore Activity Leaders are also required to assist with student arrival and departure organisation and to work 6 days out of 7, usually with one day off during the weekend. The positions are residential and therefore Activity Leaders are required to live on campus along with our students for the entire duration of their contracts.</br></br>If your application is successful you will be requested to sign a declaration that you are not unfit to be working with children under 16.Please note that prior to commencing employment your references from previous employers will be followed up, and that PLUS may require you to undergo an Enhanced CRB disclosure. Please note also that any gaps in CVs must be explained satisfactorily.";			
			}
			if($this->uri->segment(4)=="centre"){
					$data['testomiddle'] = "<h1>RESIDENTIAL  CHOREOGRAPHER  POST  SPECIFICATION</h1><strong>If you can</strong><ul><li>plan, establish, organise and promote dance sessions effectively</li><li>choreograph dances suitable for various levels of ability</li><li>encourage and motivate students to participate to the performing arts activities</li><li>address large groups of young people</li><li>manage the provided equipment appropriately and effectively</li><li>create a positive entertaining atmosphere on campus</li></ul></br><strong>If you are </strong><ul><li>a professional /training/ highly experienced dancer with good knowledge of dance technique and health & safety</li><li>passionate about encouraging children to participate in performing arts</li><li>full of energy, enthusiasm, team spirit, flexibility,  and able to work with and motivate young people</li><li>committed to making the summer camp a success for all concerned</li></ul></br>then, You can apply to become a <strong>PLUS Residential Choreographer</strong>  at one of our 22  beautiful centres all over the UK, Scotland and Ireland. </br></br>You will receive a weekly salary  between � 200,00   and  �  220,00    <strong>PLUS</strong>  full board accommodation, <strong>PLUS </strong> a <strong>2 week Holiday  Voucher for 2 people </strong>  if you  accomplish your job to an excellent standard. </br></br><strong>Job description  outlines </strong>Choreographers are solely responsible for planning and leading dance sessions and performing arts activities. They are expected to work 6 days out of 7 (usually with one day off during the weekend)  to run  afternoon and evening activities along with the Activity Leaders, and to train them to perform routines and plays.  The positions are residential and  therefore Choreographers  are required to live on campus along with our students for the entire duration of their contracts. </br></br>If  your application is successful  you will be requested to  sign a declaration that you are not unfit to be working with children under 16. Please note that prior to commencing employment  your references from previous employers will be followed up, and that PLUS may require you to undergo an Enhanced  CRB disclosure. Please note also that any gaps in CVs must be explained satisfactorily.
";			
			}
			//Abilito solo Summer Job
			if($this->uri->segment(3)=="3"){
				$this->load->view('job_summer_view', $data);
			}else{
				//Ridirigo a coming
			
			$data['title']="PLUS EDUCATIONAL | CURRENT OPPORTUNITIES | NO CURRENT OPPORTUNITY ";
			$data['testomiddle'] = "Since";	
			
		    $data['navlist'] = $this->MCatsjob->navcategorie();
			$this->load->view('job_coming_view', $data);

			}
			
			
		}

function desc(){

			$data['mainf'] = $this->MCatsjob->getDescription($this->uri->segment(3));
			if (!count($data)){
				redirect('welcome/index','refresh');
			}
			$data['title'] = "Summer Job  Description | " ;
			$data['heading'] ="Summer Job";
			$data['joblist'] = array('SUMMER CAMPS','TEACHING','OPERATION','SALES','MARKETING','FINANCE');
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			
			$this->load->view('job_desc', $data);
		}
function testimonial(){
			

			$data['title'] = "Summer Job  Description | " ;
			$data['heading'] ="TESTIMONIALS";
			$data['joblist'] = array('SUMMER CAMPS','TEACHING','OPERATION','SALES','MARKETING','FINANCE');
			$data['navlist'] = $this->MCatsjob->navcategorie();
			$data['testomiddle'] = "<h1 style=\" margin:30px 0 0 0;\">TESTIMONIAL LETTER</h1>".
				"Hi Sarah,<br/>Sorry for the late reply. My wife and I just returned from a 7 week European trip and we booked 2 weeks in Sicily (through your office) in the middle of our vacation.<br/>I must say we were a little nervous that we were going to stay somewhere almost for free, as we thought we may not get treated very well! However that couldnt be further from what happened!To begin with, Tiziano from the office replied to us via email within a week of us putting in our request for our holiday, and was extremely helpful and flexible with the dates which was much appreciated.We stayed at Residence \"Nettuno\" at Capo 'd Orlando, Sicily.<br/>As soon as we got there we were welcomed by Alessandro, who runs the resort, and Eliza who was in reception, and we have never felt more comfortable and relaxed as we did there! They both made us feel very welcome and at home.<br/>Alessandro escorted us to our apartment which was with an amazing beach/ocean view, and he explained everything to us, from the supermarket to all the sites we must see and how to get there.<br/>They were there to help us if needed but left us alone to relax and enjoy ourselves.<br/>We will definately go back and stay there, and will recommend it to all our family and friends.<br/>Alessandro runs an amazing business there and is very good at his job, we would recommend it to any of the Plus teachers who are yet to take their holiday.<br/>Thankyou so much to Plus for that great incentive and bonus, we really appreciated every second!<br/>Thanks again,<br/>Johnny and Emilie Katsivelis." .
				"<h1 style=\" margin:30px 0 0 0;\">SOME OF OUR CENTERS</h1><br>" . 
				"<a href=\"../../images/village.pdf\">General Guideline</a><br><br>";	
				$this->load->view('job_summer_testimonial', $data);
}
function bonus(){
			

			$data['title'] = "Summer Job  Description | " ;
			$data['heading'] ="HOLIDAY BONUS REGULATIONS";
			$data['joblist'] = array('SUMMER CAMPS','TEACHING','OPERATION','SALES','MARKETING','FINANCE');
			$data['navlist'] = $this->MCatsjob->navcategorie();
			$data['testomiddle'] = "<br>1. PLUS Staff Member who has been employed at one or more PLUS summer centres, and has accomplished his/her job to an excellent standard and the company�s satisfaction, may be presented with a holiday bonus.".
				"<br>The company�s satisfaction is determined solely by PLUS management on the basis of the clients�, group leaders� and Centre Manager�s reports. As such it is discretionary and cannot be disputed.<br>2. The  voucher  (the retail guide price for these holidays  is between  �700 and �900)  entitles its bearer to spend a maximum of  two-weeks  summer holiday with his/her companion or friend in a residence at one of the most celebrated Italian sea or mountain resorts. The holiday summer period generally extends from the mid-end of May to the mid-end of October and the voucher is valid between September of the year the teacher worked at one PLUS summer centre and the last Saturday of the June of the following year (within the periods specified). The voucher does not cover transportation or meals although most residences enjoy self-catering cooking facilities.<br>3. Booking procedure. On accomplishment of their contract, eligible PLUS Staff Members will be presented with their PLUS Premium Voucher along with a CD-ROM which shows aprox. 70 holiday summer resorts, and explains the relevant booking procedure<br>4.The  holiday voucher is complimentary and as such cannot be sold, reimbursed or extended if not used within its validity for personal reasons or circumstances beyond PLUS� control i.e. force majeure, epidemics, liquidation of the Tour Operator organizing the summer holidays, unavailability of places,  and so on.". 
				"<h1 style=\"text-align:center; margin:10px 0 0 0;\">LAST SUMMER MORE THAN 210 STAFF RECEIVED<br>A PLUS HOLIDAY BONUS</h1>";	
				$this->load->view('job_summer_testimonial', $data);
}

function insertinfo(){
			
			$data['title'] = "Summer Job  Form | " ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			$this->load->helper(array('form', 'url', 'email'));
			$this->load->library('form_validation');
			$this->load->library('validation');
			
			$rules['nome'] = "required";
			$rules['cognome'] = "required";
			$rules['indirizzo'] = "required";
			$rules['myemail'] = "required|valid_email";
		
			$this->validation->set_rules($rules);
		
			$fields['nome'] = 'Name';
			$fields['cognome'] = 'Surname';
			$fields['indirizzo'] = 'Address';
			$fields['email'] = 'email';
			
			$this->validation->set_error_delimiters('<div class="error">', '</div>');
			$this->validation->set_fields($fields);

			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'pdf';
			$config['max_size']	= '1000';
			//$config['max_width']  = '1024';
			//$config['max_height']  = '768';
		
			$this->load->library('upload', $config);

				
		if ($this->validation->run() == FALSE)
		{
			$this->load->view('booking', $data);
		}else
		{
			$this->upload->do_upload('cvfile');
			$data = array('upload_data' => $this->upload->data());
			$filepdf=$data['upload_data']['raw_name'];
			
			$this->upload->do_upload('userfile');
			$data1 = array('upload_data1' => $this->upload->data());
			$filepdf1=$data1['upload_data1']['raw_name'];
			
			$this->MCatsjob->addUser($filepdf, $filepdf1);
			
			$data['title'] = "Summer Job  Form | Form Success" ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			$this->load->view('uploadsuccess', $data);
			
		}
		
	}	
			
		function coming()
		{
			
			
			$this->load->model('mcms');		
			
			$data['title']="PLUS EDUCATIONAL | CURRENT OPPORTUNITIES | NO CURRENT OPPORTUNITY ";
			$data['heading'] ="CURRENT OPPORTUNITIES";
			//$data['joblist'] = array('SUMMER CAMPS','TEACHING','OPERATION','SALES','MARKETING','FINANCE');
			$data['testomiddle'] = "Since";	
			
		    $data['navlist'] = $this->MCatsjob->navcategorie();
			
			$this->load->view('job_coming_view', $data);
			

		}		

function contract(){
			
			$this->load->model('mcms');		
		
			$data['title']="View Contract";
			$data['heading'] ="Reserved Document";
			
			$data['getcandidate'] = $this->mcms->Contract($this->uri->segment(3));
			
			if($data['getcandidate'][0]['surname'] == $this->uri->segment(4)){
			$this->load->view('cmscontract_user', $data);
			}else{
				echo "Link Error";
			}

		}

function insertinfo_one(){
			
			$data['title'] = "Summer Job  Form | " ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			$this->load->helper(array('form', 'url', 'email'));
			$this->load->library('form_validation');
			$this->load->library('validation');
			
			$rules['nome'] = "required";
			$rules['cognome'] = "required";
			$rules['indirizzo'] = "required";
			$rules['myemail'] = "required|valid_email";
		
			$this->validation->set_rules($rules);
		
			$fields['nome'] = 'Name';
			$fields['cognome'] = 'Surname';
			$fields['indirizzo'] = 'Address';
			$fields['email'] = 'email';
			
			$this->validation->set_error_delimiters('<div class="error">', '</div>');
			$this->validation->set_fields($fields);

			

				
			$this->load->view('bookingnew', $data);

		
	}	

function insertinfo_two(){
			
			$data['title'] = "Summer Job  Form | " ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			$this->load->helper(array('form', 'url', 'email'));
			$this->load->library('form_validation');
			$this->load->library('validation');
			
			$rules['nome'] = "required";
			$rules['cognome'] = "required";
			$rules['indirizzo'] = "required";
			$rules['myemail'] = "required|valid_email";
		
			$this->validation->set_rules($rules);
		
			$fields['nome'] = 'Name';
			$fields['cognome'] = 'Surname';
			$fields['indirizzo'] = 'Address';
			$fields['email'] = 'email';
			
			$this->validation->set_error_delimiters('<div class="error">', '</div>');
			$this->validation->set_fields($fields);

			

				
			$this->load->view('bookingnew1', $data);

		
	}
function insertinfo_three(){
			
			$data['title'] = "Summer Job  Form | " ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			$this->load->helper(array('form', 'url', 'email'));
			$this->load->library('form_validation');
			$this->load->library('validation');
			
			$rules['nome'] = "required";
			$rules['cognome'] = "required";
			$rules['indirizzo'] = "required";
			$rules['myemail'] = "required|valid_email";
		
			$this->validation->set_rules($rules);
		
			$fields['nome'] = 'Name';
			$fields['cognome'] = 'Surname';
			$fields['indirizzo'] = 'Address';
			$fields['email'] = 'email';
			
			$this->validation->set_error_delimiters('<div class="error">', '</div>');
			$this->validation->set_fields($fields);

			

				
			$this->load->view('bookingnew2', $data);

		
	}
function insertinfo_four(){
			
			$data['title'] = "Summer Job  Form | " ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			$this->load->helper(array('form', 'url', 'email'));
			$this->load->library('form_validation');
			$this->load->library('validation');
			
			$rules['nome'] = "required";
			$rules['cognome'] = "required";
			$rules['indirizzo'] = "required";
			$rules['myemail'] = "required|valid_email";
		
			$this->validation->set_rules($rules);
		
			$fields['nome'] = 'Name';
			$fields['cognome'] = 'Surname';
			$fields['indirizzo'] = 'Address';
			$fields['email'] = 'email';
			
			$this->validation->set_error_delimiters('<div class="error">', '</div>');
			$this->validation->set_fields($fields);

			

				
			$this->load->view('bookingnew3', $data);

		
	}
function insertinfo_five(){
			
			$data['title'] = "Summer Job  Form | " ;
			$data['heading'] ="Booking Form";
			$data['navlist'] = $this->MCatsjob->navcategorie();
			
			$this->load->helper(array('form', 'url', 'email'));
			$this->load->library('form_validation');
			$this->load->library('validation');
			
			$rules['nome'] = "required";
			$rules['cognome'] = "required";
			$rules['indirizzo'] = "required";
			$rules['myemail'] = "required|valid_email";
		
			$this->validation->set_rules($rules);
		
			$fields['nome'] = 'Name';
			$fields['cognome'] = 'Surname';
			$fields['indirizzo'] = 'Address';
			$fields['email'] = 'email';
			
			$this->validation->set_error_delimiters('<div class="error">', '</div>');
			$this->validation->set_fields($fields);
				
			$this->load->view('bookingnew4', $data);	
	}
}
?>