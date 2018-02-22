<?php
/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 24-Mar-2016
 * @Modified    : 
 * @Description : Users used to authenticate teachers and other staffs.
 */
class Users extends Controller {

    public function __construct() {

        parent::Controller();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session', 'email');
        $this->load->model('tuition/usersmodel', 'usersmodel');
        $this->load->model('tuition/teachersappmodel', 'teachersappmodel');
        
        $this->load->model("tuition/teachersmodel", "teachersmodel");
    }

    function index() {

        if ($this->session->userdata('role') == 500) {
            redirect('users/dashboard', 'refresh');
        } else {
            $this->load->helper('string');
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            $data['title'] = "plus-ed.com | Login";
			if(APP_THEME == 'OLD'){
				$this->load->view('tuition/plused_users_login', $data);
			}
            else{
				redirect('vauth/users', 'refresh');
			}
        }
    }

    /**
     * login 
     * this function uses email address and users password to check/authenticate user 
     * if user is authenticated basic information is save into the session and user gets loggedin. 
     */
    function login() {
        if(!empty($_POST))
        {
            if ($this->session->userdata('role') != 500) {
                @session_start();
                $emailAddress = $this->input->post('login_name');
                $pwd = $this->input->post('login_pw');
                $userData = $this->usersmodel->verifyUser($emailAddress, $pwd);
                if ($userData) {
                    $newdata = array(
                        'username' => "--",
                        'mainfirstname' => $userData->ta_firstname,
                        'mainfamilyname' => $userData->ta_lastname,
                        'businessname' => $userData->ta_firstname,
                        'id' => $userData->ta_id,
                        'email' => $userData->ta_email,
                        'country' => $userData->ta_country,
                        'role' => 500, //500 = Teacher
                        'ruolo' => "Teacher",
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($newdata);
                    redirect('users/dashboard', 'refresh');
                } else {
                    $this->session->set_flashdata('login_failed',1);
                    redirect('users', 'refresh');
                }
            }
            else
                redirect('users', 'refresh');
        }
        else
            redirect('users', 'refresh');
    }

    /**
     * dashboard
     * this function loads users dashboard. 
     */
    function dashboard() {
		authSessionMenu($this);
        if ($this->session->userdata('role') == 500) {
            $data['title'] = "plus-ed.com | Dashboard";
            $data['breadcrumb1'] = 'Dashboard';
            $data['breadcrumb2'] = '';
			if(APP_THEME == 'OLD'){
				$this->load->view('tuition/plused_users_dashboard', $data);
			}
            else{
				$data['pageHeader'] = 'Plus vision dashboard';
				$this -> ltelayout -> view('lte/users/dashboard', $data);
			}
        } else {
            redirect('users', 'refresh');
        }
    }

    /**
     * logout 
     * this function is used to destroy users session. 
     */
    function logout() {
        $this->session->sess_destroy();
        redirect('users', 'refresh');
    }

    /**
     * profile
     * this function is used to show users self profile details.
     */
    function profile() {
		authSessionMenu($this);
        if ($this->session->userdata('role') == 500) {
            $data['title'] = "plus-ed.com | Profile";
            $data['breadcrumb1'] = 'Profile';
            $data['breadcrumb2'] = '';
            $userId = $this->session->userdata('id');
            $data['userId'] = $userId;
            $data['usersData'] = $this->teachersappmodel->getTeachersApplicationsSingle($userId);
			if(APP_THEME == 'OLD'){
				$this->load->view('tuition/plused_users_profile', $data);
			}
			else{
				$this -> ltelayout -> view('lte/users/profile', $data);
			}
            
        } else {
            redirect('users', 'refresh');
        }
    }
    
    function changeCredentials(){
        if ($this->session->userdata('role') == 500) {
            $userId = $this->session->userdata('id');
            $userData = $this->teachersappmodel->getTeachersApplicationsSingle($userId);
            $oldPassword = $this->input->post('oldPassword');
            $userPassword = $this->input->post('newPassword');
            if($userData)
            {
                if($userData->ta_password == md5($oldPassword))
                {
                    $updateArr = array(
                        'ta_password' => md5($userPassword)
                    );
                    $this->teachersappmodel->operations('update',$updateArr,$userId);
                    echo json_encode (array('result'=>1,'message'=>'Password changed successfully.'));
                }
                else
                    echo json_encode (array('result'=>0,'message'=>'Invalid old password.'));
            }
            else
                echo json_encode (array('result'=>0,'message'=>'User no longer available in the system.'));
            
        } else {
            echo json_encode (array('result'=>0,'message'=>'User session expired.'));
        }
    }
    
    /**
     * forgotpassword
     * used to generated password and send it to the relative user.
     */
    public function forgotpassword(){
        if (!$this->session->userdata('role')) {
            
            if(!empty($_POST)){
                $emailAddress = $this->input->post('txtEmailAddress');
                if (!empty($emailAddress)) {
                    $matchData = array('ta_email'=>$emailAddress);
                    $applicantData = $this->usersmodel->getUsersForMatch($matchData);
                    if($applicantData)
                    {
                        $senderEmail = PLUS_SENDER_EMAIL_ADDRESS;
                        $receiverEmail = $emailAddress;
                        $messageBody = "";
                        $data['teacherName'] = $applicantData->ta_firstname ." ". $applicantData->ta_lastname;
                        $data['teacherEmail'] = $emailAddress;
                        $randomPassword = random_string();
                        $data['randomPassword'] = $randomPassword;
                        ob_start(); // start output buffer
                        $this->load->view('tuition/email/forgot_password_email_template', $data);
                        $messageBody = ob_get_contents(); // get contents of buffer
                        ob_end_clean();
                        $this->load->library('email');
                        $this->email->set_newline("\r\n");
                        $this->email->from($senderEmail, 'plus-ed.com');
                        $this->email->to($receiverEmail);
                        $this->email->subject("plus-ed.com | Password changed");
                        $this->email->message($messageBody);
                        
                        $sendRes = $this->email->send();
                        if($sendRes)
                        {
                            // store users password in application table
                            $updateArr = array(
                                'ta_password' => md5($randomPassword)
                            );
                            $this->teachersappmodel->operations('update',$updateArr,$applicantData->ta_id);
                            // end of update
                            $this->session->set_flashdata('forgot_pass_msg','success');
                            
                            redirect('users/forgotpassword', 'refresh');
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('forgot_pass_msg','notexist');
                        redirect('users/forgotpassword', 'refresh');
                    }
                }
            }
            $data['title'] = "plus-ed.com | Forgot password";
            $this->load->view('tuition/plused_users_forgot_password', $data);
        } else {
            redirect('users', 'refresh');
        }
    }
    
    
    function documents(){
		authSessionMenu($this);
       if ($this->session->userdata('role') == 500) {
            $data['title'] = "plus-ed.com | Personal information";
            $data['breadcrumb1'] = 'My account';
            $data['breadcrumb2'] = 'Personal information';
            $userId = $this->session->userdata('id');
            $data['userId'] = $userId;
            $data['usersData'] = $this->teachersappmodel->getTeachersApplicationsSingle($userId);
            $data['appOtherFiles'] = $this->teachersappmodel->getApplicationOtherFiles($userId);
			if(APP_THEME == 'OLD'){
				$this->load->view('tuition/plused_users_documents', $data);
			}
			else{
				$data['pageHeader'] = 'Personal information';
				$this -> ltelayout -> view('lte/users/users_documents', $data);
			}
            
        } else {
            redirect('users', 'refresh');
        }
    }
    
    function contracts(){
		authSessionMenu($this);
       if ($this->session->userdata('role') == 500) {
            $this->load->model("tuition/contractmodel", "contractmodel");
            $data['title'] = "plus-ed.com | Contracts";
            $data['breadcrumb1'] = 'My account';
            $data['breadcrumb2'] = 'Contracts';
            
            $userId = $this->session->userdata('id');
            $data['contractdata'] = $this->contractmodel->getContractData($userId);
			if(APP_THEME == 'OLD'){
				$this->load->view('tuition/plused_users_contracts', $data);
			}
            else{
				$data['pageHeader'] = 'Contracts';
				$this -> ltelayout -> view('lte/users/contracts', $data);
			}
        } else {
            redirect('users', 'refresh');
        }
    }
    
    /**
     * allow user to download file  
     */
    function contractEmployment(){
        $this->load->helper('download');
        $attachFile = CONTRACT_EMPLOYMENT_SUMMER_STAFF;
        $data = file_get_contents($attachFile); // Read the file's contents
        $name = 'ContractofEmploymentSummerStaff.pdf';
        force_download($name, $data); 
    }
    
    /**
     * stripJunk
     * this function can be used to strip unwanted characters from file name.
     * @param $string input filename
     * @return string
     * @author SK
     * @since Feb 01 16
     */
    function stripJunk($string){
        $string = str_replace(" ", "-", trim($string));
        $string = preg_replace("/[^a-zA-Z0-9-.]/", "", $string);
        $string = strtolower($string);
        return $string;
    }
    
    function editprofile(){
		authSessionMenu($this);
       if ($this->session->userdata('role') == 500) {
            $edit_id = $this->session->userdata('id');
            $this->load->library('form_validation');
            $other_file_error = "";
            $cv_file_error = "";
            $passport_or_idcard_error = "";
            $formData = array(
                'ta_firstname'=>"",
                'ta_lastname'=>"",
                'ta_date_of_birth'=>"",
                'ta_nationality'=>"",
                'ta_sex'=>"",
                'ta_email'=>"",
                'ta_telephone'=>"",
                'ta_address'=>"",
                'ta_city'=>"",
                'ta_postcode'=>"",
                'ta_teach_years'=>"",
                'ta_country'=>"",
                'ta_ablility_from'=>"",
                'ta_ablility_to'=>"",
                'ta_celta'=>0,
                'ta_trinity_tesol'=>0,
                'ta_delta'=>0,
                'ta_dip_tesol'=>0,
                'ta_b_ed'=>0,
                'ta_pgce'=>0,
                'ta_ma_elt_tesol'=>0,
                'ta_other_diploma'=>"",
                'ta_cv'=>"",
                'ta_other_document'=>"",
                'ta_passport_or_id_card'=>"",
                'ta_job_adv_sent'=>0,
                
                'ta_ni_number'=>'',
                'ta_right_to_work_uk'=>0,
                'ta_ni_category'=>'',
                'ta_making_slr'=>0,
                'ta_slr_plan'=>'',
                'ta_p45_status'=>0,
                'ta_p45_starter_declaration'=>'',
                
            );
            
            if(!empty($_POST))
            {
                    $formVal = array(
                        array(
                            'field' => 'txtFirstName',
                            'label' => 'First name',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtLastName',
                            'label' => 'Last name',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtDateofBirth',
                            'label' => 'Date of birth',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'selNationality',
                            'label' => 'Nationality',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'selSex',
                            'label' => 'Sex',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtEmail',
                            'label' => 'Email',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtAblilityFrom',
                            'label' => 'Availability from',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtAblilityTo',
                            'label' => 'Availability to',
                            'rules' => 'required'
                        )
                        
                        ,
                        array(
                            'field' => 'txtNiNumber',
                            'label' => 'NI number',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtNiCategory',
                            'label' => 'NI category',
                            'rules' => 'required'
                        )
                    );
                    $this->form_validation->set_rules($formVal); 
                    if ($this->form_validation->run() == TRUE)
                    {
                        
                        $this->load->library('upload');
                        $otherFile = "";
                        $cvFile = "";
                        $passportFile = "";
                        $fileError = array();
                        $otherFileError = array();
                        $passportFileError = array();
                        //--- SET CONFIGRATION ---//
                        $CV_FILE_PATH = CV_FILE_PATH; //'./upload/teachers/cv/';
                        $OTHER_FILE_PATH = OTHER_FILE_PATH; //'./upload/teachers/other/';
                        
                        if(!empty($_FILES['cvFile']['name'])){
                            if (!file_exists($CV_FILE_PATH)) {
                                mkdir($CV_FILE_PATH, 0755,true);
                            }
                            $file_name= time().'_'.$this->stripJunk($_FILES['cvFile']['name']);
                            $config['upload_path'] = $CV_FILE_PATH;
                            $config['allowed_types'] = 'dot|doc|docx|ods|pdf';
                            $config['max_size']	= '1000';
                            $config['file_name'] = $file_name;
                            $this->upload->initialize($config);
                            //---- UPLOAD IMAGE ----//
                            if ($this->upload->do_upload("cvFile")){
                                $aUploadData =$this->upload->data();
                                $cvFile = $aUploadData['file_name'];
                            }
                            else{
                                $fileError = array('error' => $this->upload->display_errors());
                            }
                        }
                        
                        if(!empty($_FILES['otherFile']['name'])){
                            if (!file_exists($OTHER_FILE_PATH)) {
                                mkdir($OTHER_FILE_PATH, 0755,true);
                            }
                            $file_name= time().'_'.$this->stripJunk($_FILES['otherFile']['name']);
                            $config['upload_path'] = $OTHER_FILE_PATH;
                            $config['allowed_types'] = 'dot|doc|docx|ods|pdf';
                            $config['max_size']	= '1000';
                            $config['file_name'] = $file_name;
                            $this->upload->initialize($config);
                            //---- UPLOAD IMAGE ----//
                            if ($this->upload->do_upload("otherFile")){
                                $aUploadData =$this->upload->data();
                                $otherFile = $aUploadData['file_name'];
                            }
                            else{
                                $otherFileError = array('error' => $this->upload->display_errors());
                            }
                        }
                        
                        if(!empty($_FILES['passportOrIdCard']['name'])){
                            if (!file_exists(PASSPORT_ID_CARD_FILE)) {
                                mkdir(PASSPORT_ID_CARD_FILE, 0755,true);
                            }
                            $file_name= time().'_'.$this->stripJunk($_FILES['passportOrIdCard']['name']);
                            $config['upload_path'] = PASSPORT_ID_CARD_FILE;
                            $config['allowed_types'] = 'jpeg|jpg|png|gif|dot|doc|docx|ods|pdf';
                            $config['max_size']	= '1000';
                            $config['file_name'] = $file_name;
                            $this->upload->initialize($config);
                            //---- UPLOAD IMAGE ----//
                            if ($this->upload->do_upload("passportOrIdCard")){
                                $aUploadData =$this->upload->data();
                                $passportFile = $aUploadData['file_name'];
                            }
                            else{
                                $passportFileError = array('error' => $this->upload->display_errors());
                            }
                        }
                        
                    if(array_key_exists('error', $fileError) || array_key_exists('error', $otherFileError) || array_key_exists('error', $passportFileError)){
                        
                        if(array_key_exists('error', $fileError))
                            $cv_file_error = $fileError['error'];
                        if(array_key_exists('error', $otherFileError))
                            $other_file_error = $otherFileError['error'];
                        if(array_key_exists('error', $passportFileError))
                            $passport_or_idcard_error = $passportFileError['error'];
                        if(!empty($cvFile))
                            @unlink($CV_FILE_PATH . $cvFile);
                        if(!empty($otherFile))
                            @unlink($OTHER_FILE_PATH . $otherFile);
                        if(!empty($passportFile))
                            @unlink(PASSPORT_ID_CARD_FILE . $passportFile);
                    }
                    else{
                        
                        $fromDate = $this->input->post('txtAblilityFrom');
                        $toDate = $this->input->post('txtAblilityTo');
                        $birthDate = $this->input->post('txtDateofBirth');
                        $fromDate = explode('/', $fromDate);
                        $toDate = explode('/', $toDate);
                        $birthDate = explode('/', $birthDate);
                        if(array_key_exists(2, $fromDate))
                        $fromDate = $fromDate[2].'-'.$fromDate[1].'-'.$fromDate[0];
                        if(array_key_exists(2, $toDate))
                        $toDate = $toDate[2].'-'.$toDate[1].'-'.$toDate[0];
                        if(array_key_exists(2, $birthDate))
                        $birthDate = $birthDate[2].'-'.$birthDate[1].'-'.$birthDate[0];
                        
                            $update_data = array(
                                'ta_firstname'=> trim($this->input->post('txtFirstName')),
                                'ta_lastname'=> trim($this->input->post('txtLastName')),
                                'ta_date_of_birth'=> $birthDate,
                                'ta_nationality'=> trim($this->input->post('selNationality')),
                                'ta_sex'=> trim($this->input->post('selSex')),
                                'ta_email'=> trim($this->input->post('txtEmail')),
                                'ta_telephone'=> trim($this->input->post('txtTelephone')),
                                'ta_address'=> trim($this->input->post('txtAddress')),
                                'ta_city'=> trim($this->input->post('txtCity')),
                                'ta_postcode'=> trim($this->input->post('selPostCode')),
                                'ta_teach_years'=> trim($this->input->post('selTeachYears')),
                                'ta_country'=> trim($this->input->post('selCountry')),
                                'ta_ablility_from'=> $fromDate,
                                'ta_ablility_to'=> $toDate,
                                'ta_celta'=> ($this->input->post('chkCelta') == "" ? 0 : 1),
                                'ta_trinity_tesol'=> ($this->input->post('chkTrinityTesol') == "" ? 0 : 1),
                                'ta_delta'=> ($this->input->post('chkDelta') == "" ? 0 : 1),
                                'ta_dip_tesol'=> ($this->input->post('chkDipTesol') == "" ? 0 : 1),
                                'ta_b_ed'=> ($this->input->post('chkBEd') == "" ? 0 : 1),
                                'ta_pgce'=> ($this->input->post('chkPgce') == "" ? 0 : 1),
                                'ta_ma_elt_tesol'=> ($this->input->post('chkMaEltTesol') == "" ? 0 : 1),
                                'ta_other_diploma'=> trim($this->input->post('txtOtherDiploma')),
                                
                                // Extra information....
                                'ta_ni_number'=> trim($this->input->post('txtNiNumber')),
                                'ta_right_to_work_uk'=> trim($this->input->post('radRtwinuk')),
                                'ta_ni_category'=> trim($this->input->post('txtNiCategory')),
                                'ta_making_slr'=> trim($this->input->post('radSLR')),
                                'ta_slr_plan'=> trim($this->input->post('radSLRPlan')),
                                'ta_p45_status'=> trim($this->input->post('radP45')),
                                'ta_p45_starter_declaration'=> trim($this->input->post('radStarterDeclaration')),
                                
                                'ta_created_on'=> date("Y-m-d H:i:s"),
                                'ta_is_deleted'=> 0
                            );
                            if(!empty($cvFile))
                                $update_data['ta_cv'] = $cvFile;
                            
                            if(!empty($otherFile))
                                $update_data['ta_other_document'] = $otherFile;
                            
                            if(!empty($passportFile))
                                $update_data['ta_passport_or_id_card'] = $passportFile;
                            
                            $result = $this->teachersmodel->updateApplication($update_data,$edit_id);
                            if($result){
                                $this->session->set_flashdata('success_message','Profile information updated successfully');
                                redirect('users/documents');
                            }
                            else{
                                $this->session->set_flashdata('error_message','Unable to update profile information');
                            }
                        }
                    }
                    
                }
            
            if($edit_id){
                
                $teacher = $this->teachersappmodel->getTeachersApplicationsSingle($edit_id);
                if($teacher)
                {
                    $formData = array(
                        'ta_firstname'=>$teacher->ta_firstname,
                        'ta_lastname'=>$teacher->ta_lastname,
                        'ta_date_of_birth'=>$teacher->ta_date_of_birth,
                        'ta_nationality'=>$teacher->ta_nationality,
                        'ta_sex'=>$teacher->ta_sex,
                        'ta_email'=>$teacher->ta_email,
                        'ta_telephone'=>$teacher->ta_telephone,
                        'ta_address'=>$teacher->ta_address,
                        'ta_city'=>$teacher->ta_city,
                        'ta_postcode'=>$teacher->ta_postcode,
                        'ta_teach_years'=>$teacher->ta_teach_years,
                        'ta_country'=>$teacher->ta_country,
                        'ta_ablility_from'=>$teacher->ta_ablility_from,
                        'ta_ablility_to'=>$teacher->ta_ablility_to,
                        'ta_celta'=>$teacher->ta_celta,
                        'ta_trinity_tesol'=>$teacher->ta_trinity_tesol,
                        'ta_delta'=>$teacher->ta_delta,
                        'ta_dip_tesol'=>$teacher->ta_dip_tesol,
                        'ta_b_ed'=>$teacher->ta_b_ed,
                        'ta_pgce'=>$teacher->ta_pgce,
                        'ta_ma_elt_tesol'=>$teacher->ta_ma_elt_tesol,
                        'ta_other_diploma'=>$teacher->ta_other_diploma,
                        'ta_cv'=>$teacher->ta_cv,
                        'ta_other_document'=>$teacher->ta_other_document,
                        'ta_passport_or_id_card'=>$teacher->ta_passport_or_id_card,
                        'ta_job_adv_sent'=>$teacher->ta_job_adv_sent,
                        
                        'ta_ni_number'=>$teacher->ta_ni_number,
                        'ta_right_to_work_uk'=>$teacher->ta_right_to_work_uk,
                        'ta_ni_category'=>$teacher->ta_ni_category,
                        'ta_making_slr'=>$teacher->ta_making_slr,
                        'ta_slr_plan'=>$teacher->ta_slr_plan,
                        'ta_p45_status'=>$teacher->ta_p45_status,
                        'ta_p45_starter_declaration'=>$teacher->ta_p45_starter_declaration
                        
                    );
                    
                    $formData['ta_date_of_birth'] = date('d/m/Y',strtotime($teacher->ta_date_of_birth));
                    $formData['ta_ablility_from'] = date('d/m/Y',strtotime($teacher->ta_ablility_from));
                    $formData['ta_ablility_to'] = date('d/m/Y',strtotime($teacher->ta_ablility_to));
                    
                }
            }
            $formData['cv_file_error'] = $cv_file_error;
            $formData['other_file_error'] = $other_file_error;
            $formData['passport_or_idcard_error'] = $passport_or_idcard_error;
            $data["appOtherFiles"] = null;//$this->teachersappmodel->getApplicationOtherFiles($edit_id); 
            $data["postcodeData"] = $this->teachersappmodel->getPostcodeData(); 
            
            $data['title'] = "plus-ed.com | Edit profile";
            $data['breadcrumb1'] = 'My account';
            $data['breadcrumb2'] = 'Edit profile';
            
            $data['formData']= $formData;
            $data['edit_id']= $edit_id;
			if(APP_THEME == 'OLD'){
				$this->load->view('tuition/plused_users_edit_profile',$data); 
			}
            else{
				$this -> ltelayout -> view('lte/users/edit_profile', $data);
			}
        }else{
            $this->session->sess_destroy();	
            redirect('users','refresh'); 
        }
    }
    
    public function updatebankdetails(){
        $selCurrencyType = $this->input->post('selCurrencyType');
        $txtAccountName = $this->input->post('txtAccountName');
        $txtSortCode = $this->input->post('txtSortCode');
        $txtAccountNumber = $this->input->post('txtAccountNumber');
        $txtIBAN = $this->input->post('txtIBAN');
        $txtSwiftBIC = $this->input->post('txtSwiftBIC');
        $updateArray = array();
        $user_id = $this->session->userdata('id');
        $result = 0;
        if(!empty($selCurrencyType)){
            if($selCurrencyType == 'GBP')
                $updateArray = array(
                    'tbd_user_id' =>$user_id,
                    'tbd_currency_type' =>$selCurrencyType,
                    'tbd_account_name' =>$txtAccountName,
                    'tbd_sort_code' =>$txtSortCode,
                    'tbd_account_number' =>$txtAccountNumber,
                    'tbd_iban' =>'',
                    'tbd_swift_bic' =>''
                );
            else
                $updateArray = array(
                    'tbd_user_id' =>$user_id,
                    'tbd_currency_type' =>$selCurrencyType,
                    'tbd_account_name' =>$txtAccountName,
                    'tbd_sort_code' => '',
                    'tbd_account_number' => '',
                    'tbd_iban' =>$txtIBAN,
                    'tbd_swift_bic' =>$txtSwiftBIC
                );
            $result = $this->usersmodel->savebankdetails($updateArray,$user_id);
        }
        
        if($result){
            echo json_encode(array('result'=>1,'message'=>'Bank details updated successfully.'));
        }
        else{
            echo json_encode(array('result'=>0,'message'=>'Unable to update bank detail.'));
        }
    }
    
}

/* End of file users.php */
