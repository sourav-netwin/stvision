<?php
class Teachers extends Controller {

    public function __construct() {

    parent::Controller();

        // check user session and menus with their access.
        authSessionMenu($this);
        $this->load->helper(array('form', 'url','mpdf6'));
        $this->load->library('session', 'email', 'excel');
        $this->load->model("tuition/teachersmodel", "teachersmodel");
        $this->load->model("tuition/teachersappmodel", "teachersappmodel");
    }

    /**
    * index
    * This is default function to load teachers
    * @author SK
    * @since 16-Dec-2015
    */
    function index() { 
        redirect('teachers/review');
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
            $data["all_teachers"] = $this->teachersmodel->getData(0,$campusId); // $this->session->userdata('id')
            $data['title'] = "plus-ed.com | Teachers";
            $data['breadcrumb1'] = 'Job & Conracts';
            $data['breadcrumb2'] = 'Teachers';
            $this->load->view('tuition/plused_teachers', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    /**
     * getsingelrec
     * this function returns single record from tuition sheduled teachers table.
     */
    function getsingelrec(){
        $returnData = array('result'=>0,'record'=>'Unable to fetch data.');
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $teacher_id = $this->input->post('teach_id');
            $teacherData = $this->teachersmodel->getData($teacher_id);
            $returnData = array('result'=>1,'record'=>$teacherData);
        } else {
            $this->session->sess_destroy();
        }
        echo json_encode($returnData);
    }
    
    /**
    * addedit
    * This function is used to show add / edit view for teachers.
    * @param int $edit_id
    * @author SK
    * @since 16-Dec-2015
    */
    function addedit($edit_id = 0){
            $this->load->library('form_validation');
            if($this->session->userdata('username') && $this->session->userdata('role')!=200){
                $formData = array(
                    'selCampus' => '',
                    'txtFirstName' => '',
                    'txtLastName' => '',
                    'txtHoursPerDay' => '',
                    'txtFromDate' => date('Y-m-d'),
                    'txtToDate' => date('Y-m-d')
                );
                $data['edit_id'] = $edit_id;

                if(!empty($_POST['btnSave'])){

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
                            'field' => 'selCampus',
                            'label' => 'Campus',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtHoursPerDay',
                            'label' => 'Hours per day',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtFromDate',
                            'label' => 'From date',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtToDate',
                            'label' => 'To date',
                            'rules' => 'required'
                        )
                    );
                    $this->form_validation->set_rules($formVal); 
                    if ($this->form_validation->run() == TRUE)
                    {
                        $edit_id = $this->input->post('edit_id');
                        $fromDate = $this->input->post('txtFromDate');
                        $toDate = $this->input->post('txtToDate');
                        $fromDate = explode('/', $fromDate);
                        $toDate = explode('/', $toDate);
                        if(array_key_exists(2, $fromDate));
                        $fromDate = $fromDate[2].'-'.$fromDate[1].'-'.$fromDate[0];
                        if(array_key_exists(2, $toDate));
                        $toDate = $toDate[2].'-'.$toDate[1].'-'.$toDate[0];
                            if($edit_id){
                                $update_data = array(
                                    'teach_first_name'=> trim($this->input->post('txtFirstName')),
                                    'teach_last_name'=> trim($this->input->post('txtLastName')),
                                    'teach_campus_id'=> trim($this->input->post('selCampus')),
                                    'teach_hours_per_day'=> trim($this->input->post('txtHoursPerDay')),
                                    'teach_from_date'=> $fromDate,
                                    'teach_to_date'=> $toDate
                                );
                                $result = $this->teachersmodel->operations('update',$update_data,$edit_id);
                                if($result){
                                    $this->session->set_flashdata('success_message','Record updated successfully.');
                                    redirect('teachers');
                                }
                                else{
                                    $this->session->set_flashdata('error_message','Unable to add record.');
                                }
                            }
                            else{
                                $insert_data = array(
                                    'teach_first_name'=> trim($this->input->post('txtFirstName')),
                                    'teach_last_name'=> trim($this->input->post('txtLastName')),
                                    'teach_campus_id'=> trim($this->input->post('selCampus')),
                                    'teach_hours_per_day'=> trim($this->input->post('txtHoursPerDay')),
                                    'teach_from_date'=> $fromDate,
                                    'teach_to_date'=> $toDate,
                                    'teach_is_active'=> 1,
                                    'teach_is_deleted'=> 0
                                );

                                $result = $this->teachersmodel->operations('insert',$insert_data);
                                if($result){
                                    $this->session->set_flashdata('success_message','Record added successfully.');
                                    redirect('teachers');
                                }
                                else{
                                    $this->session->set_flashdata('error_message','Unable to add record.');
                                }
                            }
                    }
                    else
                    {
                        $formData = array(
                            'selCampus' => trim($this->input->post('selCampus')),
                            'txtFirstName' => trim($this->input->post('txtFirstName')),
                            'txtLastName' => trim($this->input->post('txtLastName')),
                            'txtHoursPerDay' => trim($this->input->post('txtHoursPerDay')),
                            'txtFromDate' => trim($this->input->post('txtFromDate')),
                            'txtToDate' => trim($this->input->post('txtToDate'))
                        );
                    }
                }
                else
                {
                    if($edit_id){
                        // get teachersdetails for edit purpose
                        $teachersDetails = $this->teachersmodel->getData($edit_id); // $this->session->userdata('id')

                        if($teachersDetails){
                            $teachersDetails = $teachersDetails[0];
                            $formData = array(
                                'selCampus' => $teachersDetails['teach_campus_id'],
                                'txtFirstName' => $teachersDetails['teach_first_name'],
                                'txtLastName' => $teachersDetails['teach_last_name'],
                                'txtHoursPerDay' => $teachersDetails['teach_hours_per_day'],
                                'txtFromDate' => $teachersDetails['teach_from_date'],
                                'txtToDate' => $teachersDetails['teach_to_date']
                            );
                        }
                    }
                }
                $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
                $data["campusList"] = $this->teachersmodel->getCampusList(1,$campusId); // $this->session->userdata('id')
                $data['title']="plus-ed.com | Teachers";
                $data['breadcrumb1']='Teachers';
                if($edit_id)
                    $data['breadcrumb2']='Edit teacher';
                else
                    $data['breadcrumb2']='Add new teacher';
                $data['formData']= $formData;
                $this->load->view('tuition/plused_add_teacher',$data); 

            }else{
                $this->session->sess_destroy();	
                redirect('backoffice','refresh'); 
            }

    }


    /**
    * teacher_change_status
    * This function is used to toggle teachers active status.
    * @author SK
    * @since 16-Dec-2015
    */
    function teachers_change_status(){
        $teacherId = $this->input->post('id');
        $teacherStatus = $this->input->post('status');
        if($teacherStatus == 1) // change status to update..
            $teacherStatus = 0;
        else
            $teacherStatus = 1;
        $udpateData = array(
            'teach_is_active' => $teacherStatus
        );
        $result = $this->teachersmodel->operations('changestatus',$udpateData,$teacherId);
        if($result){
            echo json_encode(array('result'=>1,'message'=>'Teacher status changed successfully.','status'=>$teacherStatus));
        }
        else
            echo json_encode(array('result'=>0,'message'=>'Unable to change teachers status.'));

    }

    /**
    * deleteteacher
    * This function is used to remove teachers form system
    * @author SK
    * @since 16-Dec-2015
    */
    function deleteteachers($teacherId = 0){
        $result = $this->teachersmodel->operations('delete',null,$teacherId);
        if($result){
            $this->session->set_flashdata('success_message','Teacher deleted succefully.');
            redirect('teachers');
        }
        else
            $this->session->set_flashdata('error_message','Unable to delete teachers.');
        redirect('teachers');

    }
    
    
    function apply()
    {
            $this->load->library('form_validation');
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
                    'ta_other_document'=>""
                );
                $formData['cv_file_error'] = "";
                $formData['other_file_error'] = "";
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
                    );
                    $this->form_validation->set_rules($formVal); 
                    if ($this->form_validation->run() == TRUE)
                    {
                        $this->load->library('upload');
                        $otherFile = "";
                        $cvFile = "";
                        $fileError = array();
                        $otherFileError = array();
                        //--- SET CONFIGRATION ---//
                        $CV_FILE_PATH = '/var/www/html/www.plus-ed.com/teacherApplications/cv/';
                        $OTHER_FILE_PATH = '/var/www/html/www.plus-ed.com/teacherApplications/other/';
                        
                        if(!empty($_FILES['cvFile']['name'])){
                            if (!file_exists($CV_FILE_PATH)) {
                                mkdir($CV_FILE_PATH, 0755,true);
                            }
                            $file_name= time().'_'.$this->stripJunk($_FILES['cvFile']['name']);
                            $config['upload_path'] = $CV_FILE_PATH;
                            $config['allowed_types'] = 'doc|docx|ods|pdf';
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
                            $config['allowed_types'] = 'doc|docx|ods|pdf';
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
                        
                    if(array_key_exists('error', $fileError) || array_key_exists('error', $otherFileError)){
                        if(array_key_exists('error', $fileError))
                            $formData['cv_file_error'] = $fileError['error'];
                        if(array_key_exists('error', $otherFileError))
                            $formData['other_file_error'] = $otherFileError['error'];
                        if(!empty($cvFile))
                            @unlink($CV_FILE_PATH . $cvFile);
                        if(!empty($otherFile))
                            @unlink($OTHER_FILE_PATH . $otherFile);
                    }
                    else{				
                        $fromDate = $this->input->post('txtAblilityFrom');
                        $toDate = $this->input->post('txtAblilityTo');
                        $birthDate = $this->input->post('txtDateofBirth');
                        $fromDate = explode('/', $fromDate);
                        $toDate = explode('/', $toDate);
                        $birthDate = explode('/', $birthDate);
                        if(array_key_exists(2, $fromDate));
                        $fromDate = $fromDate[2].'-'.$fromDate[1].'-'.$fromDate[0];
                        if(array_key_exists(2, $toDate));
                        $toDate = $toDate[2].'-'.$toDate[1].'-'.$toDate[0];
                        if(array_key_exists(2, $birthDate));
                        $birthDate = $birthDate[2].'-'.$birthDate[1].'-'.$birthDate[0];
                        
                            $insert_data = array(
                                'ta_firstname'=> trim($this->input->post('txtFirstName')),
                                'ta_lastname'=> trim($this->input->post('txtLastName')),
                                'ta_date_of_birth'=> $birthDate,
                                'ta_nationality'=> trim($this->input->post('selNationality')),
                                'ta_sex'=> trim($this->input->post('selSex')),
                                'ta_email'=> trim($this->input->post('txtEmail')),
                                'ta_telephone'=> trim($this->input->post('txtTelephone')),
                                'ta_address'=> trim($this->input->post('txtAddress')),
                                'ta_city'=> trim($this->input->post('txtCity')),
                                'ta_postcode'=> trim($this->input->post('txtPostCode')),
                                'ta_teach_years'=> $this->input->post('txtYoT'),
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
                                'ta_cv'=> $cvFile,
                                'ta_other_document'=> $otherFile,
                                'ta_created_on'=> date("Y-m-d H:i:s"),
                                'ta_is_deleted'=> 0
                            );
                            $result = $this->teachersmodel->insertApplication($insert_data);
                            if($result){
                                    header("location: http://www.plus-ed.com/apps/index.php/courses/job/ok");
                                    exit; 
                            }
                            else{
                                    header("location: http://www.plus-ed.com/apps/index.php/courses/job/ko1");
                                    exit; 
                            }
                        }
                    }else{
                            header("location: http://www.plus-ed.com/apps/index.php/courses/job/ko2");
                            exit; 						
                    }
                    
                }
    }
    
    function editapp($edit_id = 0){
        $this->load->library('form_validation');
        $other_file_error = "";
        $cv_file_error = "";
        $passport_or_idcard_error = "";
        if($this->session->userdata('username') && $this->session->userdata('role')!=200){
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
                'ta_job_adv_sent'=>0
            );
            
            if(!empty($_POST))
            {
                $edit_id = $this->input->post('edit_id');
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
                    );
                    $this->form_validation->set_rules($formVal); 
                    if ($this->form_validation->run() == TRUE)
                    {
                        
                        $this->load->library('upload');
                        $otherFile = "";
                        $cvFile = "";
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
                                $this->session->set_flashdata('success_message','Application updated successfully');
                                $hidd_tajobadvsent = $this->input->post('hidd_tajobadvsent');
                                if($hidd_tajobadvsent)
                                    redirect('teachers/profilereview');
                                else
                                    redirect('teachers/review');
                            }
                            else{
                                $this->session->set_flashdata('error_message','Unable to update application');
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
                        'ta_job_adv_sent'=>$teacher->ta_job_adv_sent
                    );
                    
                    $formData['ta_date_of_birth'] = printDate($teacher->ta_date_of_birth,'d/m/Y');//date('d/m/Y',strtotime($teacher->ta_date_of_birth));
                    $formData['ta_ablility_from'] = date('d/m/Y',strtotime($teacher->ta_ablility_from));
                    $formData['ta_ablility_to'] = date('d/m/Y',strtotime($teacher->ta_ablility_to));
                    
                }
            }
            $formData['cv_file_error'] = $cv_file_error;
            $formData['other_file_error'] = $other_file_error;
            $formData['passport_or_idcard_error'] = $passport_or_idcard_error;
            $data["appOtherFiles"] = $this->teachersappmodel->getApplicationOtherFiles($edit_id); 
            $data["postcodeData"] = $this->teachersappmodel->getPostcodeData(); 
            $data['title']="plus-ed.com | Teachers";
            $data['breadcrumb1']='Teachers CV review';
            $data['breadcrumb2']='Edit teacher application';
            $data['formData']= $formData;
            $data['edit_id']= $edit_id;
            
            if(APP_THEME == "OLD")
                $this->load->view('tuition/plused_teacher_application',$data); 
            else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/contract/teacher_application', $data);
            }
        }else{
            $this->session->sess_destroy();	
            redirect('backoffice','refresh'); 
        }
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
    
    function ajaxfileupload($type = ""){
        
        $data = array();
        if($type == "files")
        {
            $this->load->library('upload');
            $otherFile = array();
            $otherFileError = array();
            //var_dump($_FILES[0]['name']);die;
            $OTHER_FILE_PATH = OFFICE_OTHER_FILE_PATH;
            
            if(!empty($_FILES[0]['name'])){
                if (!file_exists($OTHER_FILE_PATH)) {
                    mkdir($OTHER_FILE_PATH, 0755,true);
                }
                $file_name= time().'_'.$this->stripJunk($_FILES[0]['name']);
                $config['upload_path'] = $OTHER_FILE_PATH;
                $config['allowed_types'] = 'odt|doc|docx|ods|pdf';
                $config['max_size']	= '1000';
                $config['file_name'] = $file_name;
                $this->upload->initialize($config);
                //---- UPLOAD IMAGE ----//
                if ($this->upload->do_upload(0)){
                    $aUploadData =$this->upload->data();
                    array_push($otherFile, $aUploadData['file_name']);
                }
                else{
                    $otherFileError = array('error' => $this->upload->display_errors());
                }
            }
            $data = ($otherFileError) ? array('error' => $otherFileError['error']) : array('files' => $otherFile);
        }
        else
        {
            $filenameArr = $this->input->post('filenames');
            $title = $this->input->post('title');
            $edit_id = $this->input->post('edit_id');
            $oldfilename = $this->input->post('oldfilename');
            $file_name = "";
            if(is_array($filenameArr))
            if(array_key_exists('0', $filenameArr))
                $file_name = $filenameArr[0];
            if($file_name != "" && $edit_id > 0)
            {
                $insertData = array(
                    'tof_teacher_appplication_id' => $edit_id,
                    'tof_title' => $title,
                    'tof_filename' => $file_name,
                    'tof_created_on' => date("Y-m-d H:i:s")
                );
                $fileRecId = $this->teachersappmodel->storeApplicationOtherFile($insertData);
                if($fileRecId)
                {
                    // delete old record
                    $deleteMatched = array(
                        'tof_teacher_appplication_id' => $edit_id,
                        'tof_filename' => $oldfilename
                    );
                    $this->teachersappmodel->deleteApplicationOtherFile($deleteMatched);
                    //$oldfilename
                    $OTHER_FILE_PATH = OFFICE_OTHER_FILE_PATH;
                    @unlink($OTHER_FILE_PATH . $oldfilename);
                }
                $data['record_id'] = $fileRecId;
                $data['file_title'] = $title;
                $data['file_name'] = $file_name;
            }
        }
        echo json_encode($data);
    }
    
    function deletefile(){
        $returnData = array('result'=>0,'message'=>'Unable to remove uploaded file.');
        $edit_id = $this->input->post('edit_id');
        $oldfilename = $this->input->post('oldFileName');
        if($edit_id > 0 && !empty($oldfilename)){
            $deleteMatched = array(
                'tof_teacher_appplication_id' => $edit_id,
                'tof_filename' => $oldfilename
            );
            $this->teachersappmodel->deleteApplicationOtherFile($deleteMatched);
            //$oldfilename
            $OTHER_FILE_PATH = OFFICE_OTHER_FILE_PATH;//'./upload/teachers/office_other/';
            @unlink($OTHER_FILE_PATH . $oldfilename);
            $returnData = array('result'=>1,'message'=>'File removed from server successfully.');
        }
        echo json_encode($returnData);
    }
    
    function updatefiletitle(){
        $returnData = array('result'=>0,'message'=>'Unable to update file title.');
        $edit_id = $this->input->post('edit_id');
        $oldfilename = $this->input->post('oldFileName');
        $fileTitle = $this->input->post('fileTitle');
        if($edit_id > 0 && !empty($oldfilename)){
            $whereMatched = array(
                'tof_teacher_appplication_id' => $edit_id,
                'tof_filename' => $oldfilename
            );
            $udpateData = array(
                'tof_title'=>$fileTitle
            );
            $this->teachersappmodel->updateApplicationOtherFile($udpateData,$whereMatched);
            $returnData = array('result'=>1,'message'=>'File title updated successfully.');
        }
        echo json_encode($returnData);
    }
    
    /**
    * review
    * review teachers function to load teachers
    * @author SK
    * @since 16-Dec-2015
    */
    function review() { 
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data["teachers_app"] = $this->teachersappmodel->getTeachersApplicationsData(); // $this->session->userdata('id')
            $data["campusList"] = $this->teachersmodel->getCampusList();
            $data["postcodeData"] = $this->teachersappmodel->getPostcodeData(); 
            $data['title'] = "plus-ed.com | Teachers CV review";
            $data['breadcrumb1'] = 'Job & Conracts';
            $data['breadcrumb2'] = 'Teachers CV review';
            
            if(APP_THEME == "OLD")
                $this->load->view('tuition/plused_teachers_review', $data);
            else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/contract/teachers_review', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    function review_ajax(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $nationality = $this->input->post('nationality');
            $sex = $this->input->post('sex');
            $dbfrom = $this->input->post('dbfrom');
            $dbto = $this->input->post('dbto');
            $diplomas = $this->input->post('diplomas');
            $txtCalFromDate = $this->input->post('txtCalFromDate');
            $txtCalToDate = $this->input->post('txtCalToDate');
            $txtName = $this->input->post('txtName');
            $selPostcode = $this->input->post('selPostcode');
            $selTeachYears = $this->input->post('selTeachYears');
            
            $selRegVerified = $this->input->post('selRegVerified');
            $selIntLevel = $this->input->post('selIntLevel');
            
            $pageType = $this->input->post('pageType');
            
            
            if($diplomas == 'null')
                $diplomas = 0;
            
            $fromBirtDate = "";
            $toBirtDate = "";
            if(!empty($dbfrom) && !empty($dbto))
            {
                $fromBirtDate = date('Y-m-d', strtotime('-'.$dbto.' years'));
                $toBirtDate = date('Y-m-d', strtotime('-'.$dbfrom.' years'));
            }
            elseif(!empty($dbto))
                $fromBirtDate = date('Y-m-d', strtotime('-'.$dbto.' years'));
            elseif(!empty($dbfrom))
                $toBirtDate = date('Y-m-d', strtotime('-'.$dbfrom.' years'));
            
            
            
            if(!empty($txtCalFromDate) && !empty($txtCalToDate))
            {
                $txtCalFromDate = explode('/', $txtCalFromDate);
                $txtCalToDate = explode('/', $txtCalToDate);

                if(array_key_exists(2, $txtCalFromDate));
                    $txtCalFromDate = $txtCalFromDate[2].'-'.$txtCalFromDate[1].'-'.$txtCalFromDate[0];

                if(array_key_exists(2, $txtCalToDate));
                    $txtCalToDate = $txtCalToDate[2].'-'.$txtCalToDate[1].'-'.$txtCalToDate[0];
            }
           
            
            $teachers_app = $this->teachersappmodel->getTeachersApplicationsData($pageType,$txtName,$nationality,$sex,$fromBirtDate,$toBirtDate,$diplomas,$txtCalFromDate,$txtCalToDate,$selPostcode,$selTeachYears,$selRegVerified,$selIntLevel);
            $returnData = array();
            if($teachers_app)
            {
                foreach($teachers_app as $teacher){
                    
                    $reviewActions = "";
                    if(APP_THEME == "OLD")
                        {
                        if($pageType == 'profilereview')
                        {
                            $reviewActions = '
                                <a title="Interview Info" href="javascript:void(0);" data-id="'.$teacher["ta_id"].'" class="dialog-interview" >
                                    <span class="icon-user"> Interview</span>
                                    </a> |
                                <a title="Send job offer letter" href="javascript:void(0);" data-id="'.$teacher["ta_id"].'" data-name="'.$teacher["teacher_full_name"].'" class="sendjoboffer_link" >
                                    <span class="icon-file"> Send job offer letter</span>
                                    </a> |
                                <a title="View" href="javascript:void(0);" data-id="'.$teacher["ta_id"].'" data-read="'.$teacher['ta_read_cv'].'" class="dialogbtn read'.$teacher['ta_read_cv'].'" >
                                    <span class="icon-eye-open"></span>
                                    </a>
                                <a title="Edit" href="'.base_url().'index.php/teachers/editapp/'.$teacher["ta_id"].'" class="edit-application" >
                                    <span class="icon-edit"></span>
                                    </a>  
                                ';
                        }
                        else
                        {
                            $reviewActions = '<a title="View" href="javascript:void(0);" data-read="'.$teacher['ta_read_cv'].'" data-id="'.$teacher["ta_id"].'" class="dialogbtn read'.$teacher['ta_read_cv'].'" >
                                <span class="icon-eye-open"></span>
                                </a>
                            <a title="Edit" href="'.base_url().'index.php/teachers/editapp/'.$teacher["ta_id"].'" class="edit-application" >
                                <span class="icon-edit"></span>
                                </a>    
                            ';
                        }
                    }
                    else{
                        if($pageType == 'profilereview')
                            {
                                $reviewActions = '
                                    <div class="btn-group">
                                        <a title="Interview Info" href="javascript:void(0);" data-toggle="tooltip" data-id="'.$teacher["ta_id"].'" class="dialog-interview btn btn-xs btn-info" ><i class="fa fa-user"></i> Interview</a>    
                                    </div>
                                    <div class="btn-group">
                                        <a title="Send job offer letter" href="javascript:void(0);" data-toggle="tooltip" data-id="'.$teacher["ta_id"].'" data-name="'.$teacher["teacher_full_name"].'" class="sendjoboffer_link btn btn-xs btn-danger" ><i class="fa fa-file"></i> Send job offer letter</a>        
                                    </div>
                                    <div class="btn-group">
                                        <a title="View" data-toggle="tooltip" data-id="'.$teacher["ta_id"].'" data-read="'.$teacher['ta_read_cv'].'" href="javascript:void(0);" class="min-wd-24 dialogbtn btn btn-xs btn-primary read'.$teacher['ta_read_cv'].'" ><i class="fa fa-eye"></i></a>        
                                        <a title="Edit" data-toggle="tooltip" href="'.base_url().'index.php/teachers/editapp/'.$teacher["ta_id"].'" class="min-wd-24 edit-application btn btn-xs btn-warning" ><i class="fa fa-edit"></i></a>        
                                    </div>
                                    <div class="btn-group"> 
                                        <a title="Send available positions" href="javascript:void(0);" data-toggle="tooltip" data-id="'.$teacher["ta_id"].'" data-name="'.$teacher["teacher_full_name"].'" class="btnSendAdvOfferFromInterview btn btn-xs btn-danger" ><i class="fa fa-file"> Send positions</i></a>        
                                    </div>';
                            }
                            else
                            {
                                $reviewActions = '
                                <div class="btn-group">
                                    <a title="View" data-toggle="tooltip" data-id="'.$teacher["ta_id"].'" data-read="'.$teacher['ta_read_cv'].'" href="javascript:void(0);" class="min-wd-24 dialogbtn btn btn-xs btn-primary read'.$teacher['ta_read_cv'].'" ><i class="fa fa-eye"></i></a>
                                    <a title="Edit" data-toggle="tooltip" href="'.base_url().'index.php/teachers/editapp/'.$teacher["ta_id"].'" class="min-wd-24 edit-application btn btn-xs btn-warning" ><i class="fa fa-edit"></i></a>    
                                </div>
                                ';
                            }
                    }
                    
                    if($pageType == 'profilereview')
                    {
                        array_push($returnData, array(
                            $teacher['ta_id'],
                            html_entity_decode($teacher["teacher_full_name"]),
                            $teacher["ta_sex"],
                            $teacher["ta_email"],
                            printDate($teacher["ta_date_of_birth"],"d/m/Y"),
                            date('d/m/Y',strtotime($teacher["ta_ablility_from"])),
                            date('d/m/Y',strtotime($teacher["ta_ablility_to"])),
                            ucwords($teacher["ta_nationality"]),
                            $teacher["offers_sent"],
                            $reviewActions
                        ));
                    }
                    else{
                        array_push($returnData, array(
                            $teacher['ta_id'],
                            html_entity_decode($teacher["teacher_full_name"]),
                            $teacher["ta_sex"],
                            $teacher["ta_email"],
                            printDate($teacher["ta_date_of_birth"],"d/m/Y"),
                            date('d/m/Y',strtotime($teacher["ta_ablility_from"])),
                            date('d/m/Y',strtotime($teacher["ta_ablility_to"])),
                            ucwords($teacher["ta_nationality"]),
                            $reviewActions
                        ));
                    }
                }
            }
            echo json_encode($returnData);
        }
        else
            echo "User session expired.";
    }
    
    function exportreview(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $nationality = $this->input->post('selNationality');
            $sex = $this->input->post('selSex');
            $dbfrom = $this->input->post('selAgeRangeFrom');
            $dbto = $this->input->post('selAgeRangeTo');
            $diplomas = $this->input->post('selDiplomas');
            $txtCalFromDate = $this->input->post('txtCalFromDate');
            $txtCalToDate = $this->input->post('txtCalToDate');
            $txtName = $this->input->post('txtName');
            $selPostcode = $this->input->post('selPostCode');
            $selTeachYears = $this->input->post('selTeachYears');
            $pageType = $this->input->post('hiddPageType');
            $selRegVerified = '';
            $selIntLevel = '';
            if($pageType)
            {
                $selRegVerified = $this->input->post('selRegVerified');
                $selIntLevel = $this->input->post('selIntLevel');
            }
            
            if($diplomas == 'null')
                $diplomas = 0;
            
            $fromBirtDate = "";
            $toBirtDate = "";
            if(!empty($dbfrom) && !empty($dbto))
            {
                $fromBirtDate = date('Y-m-d', strtotime('-'.$dbto.' years'));
                $toBirtDate = date('Y-m-d', strtotime('-'.$dbfrom.' years'));
            }
            elseif(!empty($dbto))
                $fromBirtDate = date('Y-m-d', strtotime('-'.$dbto.' years'));
            elseif(!empty($dbfrom))
                $toBirtDate = date('Y-m-d', strtotime('-'.$dbfrom.' years'));
            
            
            
            if(!empty($txtCalFromDate) && !empty($txtCalToDate))
            {
                $txtCalFromDate = explode('/', $txtCalFromDate);
                $txtCalToDate = explode('/', $txtCalToDate);

                if(array_key_exists(2, $txtCalFromDate));
                    $txtCalFromDate = $txtCalFromDate[2].'-'.$txtCalFromDate[1].'-'.$txtCalFromDate[0];

                if(array_key_exists(2, $txtCalToDate));
                    $txtCalToDate = $txtCalToDate[2].'-'.$txtCalToDate[1].'-'.$txtCalToDate[0];
            }
            
            
            $teachers_app = $this->teachersappmodel->getTeachersApplicationsData($pageType,$txtName,$nationality,$sex,$fromBirtDate,$toBirtDate,$diplomas,$txtCalFromDate,$txtCalToDate,$selPostcode,$selTeachYears,$selRegVerified,$selIntLevel);
            $exportData = array();
            if($teachers_app)
            {
                foreach($teachers_app as $record){
                    $exportRecord = array(
                        'First name' => $record['ta_firstname'],
                        'Last name' => $record['ta_lastname'],
                        'Date of birth' => date("d/m/Y",strtotime($record["ta_date_of_birth"])),
                        'Ability from' => date("d/m/Y",strtotime($record["ta_ablility_from"])),
                        'Teach years' => $record['ta_teach_years'],
                        'Ability to' => date("d/m/Y",strtotime($record["ta_ablility_to"])),
                        'Gender' => $record['ta_sex'],
                        'Nationality' => ucwords($record['ta_nationality']),
                        'Email Address' => $record['ta_email'],
                        'Teliphone' => $record['ta_telephone'],
                        'Address' => $record['ta_address'],
                        'City' => $record['ta_city'],
                        'Country' => $record['ta_country'],
                        'Postcode' => $record['ta_postcode']
                    );
                    array_push($exportData, $exportRecord);
                }
                //$this->load->helper('csv');
                //array_to_csv_export($exportData,'teacher_summary_report.csv');//die;
                $this->load->library('export');
                $this->export->to_excel($exportData, 'teacher_application_review'); 
            } else {
                $this->session->set_flashdata('success_message','No records to export.');
                redirect('teachers/review', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    function applicationdetail(){
        
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) 
        {
            $CV_FILE_PATH = CV_FILE_PATH;
            $OTHER_FILE_PATH = OTHER_FILE_PATH;
            $OFFICE_OTHER_FILE_PATH = OFFICE_OTHER_FILE_PATH;
            $ta_id = $this->input->post('id');
            $isread = $this->input->post('isread');
            if($isread == '0')
            {
                $isread = 1;
                $readStatus = array('ta_read_cv' => $isread);
                $this->teachersappmodel->operations('update', $readStatus, $ta_id);
            }
            $teacher = $this->teachersappmodel->getTeachersApplicationsSingle($ta_id);
            //$teacherHistory = $this->teachersappmodel->getTeacherHistory($ta_id);
            $appOtherFiles = $this->teachersappmodel->getApplicationOtherFiles($ta_id); 
            if($teacher)
            {
            if(APP_THEME == "OLD"){
                ?>
                    <div class="clr">
                        <div class="grid_3"><strong>Name:</strong></div>
                        <div class="grid_6">
                            <input type="hidden" id="hiddTeacherAppId" value="<?php echo $teacher->ta_id;?>" />
                            <input type="hidden" id="hiddFirstName" value="<?php echo $teacher->ta_firstname;?>" />
                            <input type="hidden" id="hiddLastName" value="<?php echo $teacher->ta_lastname;?>" />
                            <input type="hidden" id="hiddAbilityFromDate" value="<?php echo date('d/m/Y',strtotime($teacher->ta_ablility_from));?>" />
                            <input type="hidden" id="hiddAbilityToDate" value="<?php echo date('d/m/Y',strtotime($teacher->ta_ablility_to));?>" />
                            <?php echo html_entity_decode($teacher->teacher_full_name);?></div>
                    </div>
                    <div class="clr">
                        <div class="grid_3"><strong>Date of birth:</strong></div>
                        <div class="grid_3"><?php echo printDate($teacher->ta_date_of_birth,"d/m/Y");?>&nbsp;</div>
                    
                        <div class="grid_3"><strong>Nationality:</strong></div>
                        <div class="grid_3"><?php echo ucwords(empty($teacher->ta_nationality) ? '-' : $teacher->ta_nationality);?></div>
                    </div>
                    <div class="clr">
                        <div class="grid_3"><strong>Gender:</strong></div>
                        <div class="grid_3"><?php echo (empty($teacher->ta_sex) ? '-' : $teacher->ta_sex);?></div>
                   
                        <div class="grid_3"><strong>Email:</strong></div>
                        <div class="grid_3"><?php echo ($teacher->ta_email == "" ? "-" : $teacher->ta_email);?></div>
                    </div>
                    <div class="clr">
                        <div class="grid_3"><strong>Telephone:</strong></div>
                        <div class="grid_3"><?php echo ($teacher->ta_telephone == '' ? '-' : $teacher->ta_telephone);?></div>
                    
                        <div class="grid_3"><strong>Teach years:</strong></div>
                        <div class="grid_3"><?php echo ($teacher->ta_teach_years == '' ? '-' : $teacher->ta_teach_years);?></div>
                    </div>
                    <div class="clr">
                        <div class="grid_3"><strong>Available from:</strong></div>
                        <div class="grid_3"><?php echo date('d/m/Y',strtotime($teacher->ta_ablility_from));?></div>
                        
                        <div class="grid_3"><strong>Available to:</strong></div>
                        <div class="grid_3"><?php echo date('d/m/Y',strtotime($teacher->ta_ablility_to));?></div>
                    </div>
                    <div class="clr">
                        <div class="grid_3"><strong>Address:</strong></div>
                        <div class="grid_3"><?php echo ($teacher->ta_address == '' ? '-' : $teacher->ta_address);?></div>
                        
                        <div class="grid_3"><strong>City:</strong></div>
                        <div class="grid_3"><?php echo ($teacher->ta_city == '' ? '-' : $teacher->ta_city);?></div>
                    </div>
                    <div class="clr">
                        <div class="grid_3"><strong>Country:</strong></div>
                        <div class="grid_3"><?php echo ($teacher->ta_country == '' ? '-' : $teacher->ta_country);?></div>
                        
                        <div class="grid_3"><strong>Postcode:</strong></div>
                        <div class="grid_3"><?php echo ($teacher->postcode_area == '' ? '-' : $teacher->ta_postcode. ' ' .$teacher->postcode_area);?></div>
                    </div>
                    <div class="clr">
                        <div class="grid_3"><strong>Diplomas:</strong></div>
                        <div class="grid_9"><?php 
                            if($teacher->ta_celta)
                                echo "<span>CELTA</span>";
                            if($teacher->ta_trinity_tesol)
                                echo "<span>Trinity TESOL</span>";
                            if($teacher->ta_delta)
                                echo "<span>DELTA</span>";
                            if($teacher->ta_dip_tesol)
                                echo "<span>Dip. TESOL</span>";
                            if($teacher->ta_b_ed)
                                echo "<span>B.Ed.</span>";
                            if($teacher->ta_pgce)
                                echo "<span>PGCE (Primary, English or MFL)</span>";
                            if($teacher->ta_ma_elt_tesol)
                                echo "<span>MA in ELT//TESOL</span>";
                            if(!empty($teacher->ta_other_diploma))
                                echo "<span>".$teacher->ta_other_diploma."</span>";
                        ?>
                        </div>
                    </div>
                    <div class="clr">
                        <div class="grid_3"><strong>CV File:</strong></div>
                        <div class="grid_6 hlt-link"><a target="_blank" href="<?php echo base_url(). $CV_FILE_PATH . $teacher->ta_cv;?>"><?php echo $teacher->ta_cv;?></a></div>
                    </div>
                    <div class="clr">
                        <div class="grid_3"><strong>Other document:</strong></div>
                        <div class="grid_6 hlt-link"><a target="_blank" href="<?php echo base_url(). $OTHER_FILE_PATH . $teacher->ta_other_document;?>"><?php echo $teacher->ta_other_document;?></a></div>
                    </div>
                    <div class="clr">
                        <div class="grid_3"><strong>Passport or id card:</strong></div>
                        <div class="grid_6 hlt-link"><a target="_blank" href="<?php echo base_url(). PASSPORT_ID_CARD_FILE . $teacher->ta_passport_or_id_card;?>"><?php echo $teacher->ta_passport_or_id_card;?></a></div>
                    </div>
                    <div class="clr">
                        <span><strong>Other files uploaded for office use</strong></span>
                    </div>
<?php
				}
				else{
                ?>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Name:</strong></div>
                        <div class="col-sm-6 col-md-6 break-word mr-bt-tp-3">
                            <input type="hidden" id="hiddTeacherAppId" value="<?php echo $teacher->ta_id;?>" />
                            <input type="hidden" id="hiddFirstName" value="<?php echo $teacher->ta_firstname;?>" />
                            <input type="hidden" id="hiddLastName" value="<?php echo $teacher->ta_lastname;?>" />
                            <input type="hidden" id="hiddAbilityFromDate" value="<?php echo date('d/m/Y',strtotime($teacher->ta_ablility_from));?>" />
                            <input type="hidden" id="hiddAbilityToDate" value="<?php echo date('d/m/Y',strtotime($teacher->ta_ablility_to));?>" />
                            <?php echo html_entity_decode($teacher->teacher_full_name);?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Date of birth:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo printDate($teacher->ta_date_of_birth,"d/m/Y");?>&nbsp;</div>
                    
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Nationality:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ucwords(empty($teacher->ta_nationality) ? '-' : $teacher->ta_nationality);?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Gender:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo (empty($teacher->ta_sex) ? '-' : $teacher->ta_sex);?></div>
                   
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Email:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($teacher->ta_email == "" ? "-" : $teacher->ta_email);?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Telephone:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($teacher->ta_telephone == '' ? '-' : $teacher->ta_telephone);?></div>
                    
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Teach years:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($teacher->ta_teach_years == '' ? '-' : $teacher->ta_teach_years);?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Available from:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo date('d/m/Y',strtotime($teacher->ta_ablility_from));?></div>
                        
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Available to:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo date('d/m/Y',strtotime($teacher->ta_ablility_to));?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Address:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($teacher->ta_address == '' ? '-' : $teacher->ta_address);?></div>
                        
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>City:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($teacher->ta_city == '' ? '-' : $teacher->ta_city);?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Country:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($teacher->ta_country == '' ? '-' : $teacher->ta_country);?></div>
                        
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Postcode:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($teacher->postcode_area == '' ? '-' : $teacher->ta_postcode. ' ' .$teacher->postcode_area);?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Diplomas:</strong></div>
                        <div class="col-sm-9 col-md-9 break-word mr-bt-tp-3"><?php 
                            if($teacher->ta_celta)
                                echo "<span class='light-bg'>CELTA</span>";
                            if($teacher->ta_trinity_tesol)
                                echo "<span class='light-bg'>Trinity TESOL</span>";
                            if($teacher->ta_delta)
                                echo "<span class='light-bg'>DELTA</span>";
                            if($teacher->ta_dip_tesol)
                                echo "<span class='light-bg'>Dip. TESOL</span>";
                            if($teacher->ta_b_ed)
                                echo "<span class='light-bg'>B.Ed.</span>";
                            if($teacher->ta_pgce)
                                echo "<span class='light-bg'>PGCE (Primary, English or MFL)</span>";
                            if($teacher->ta_ma_elt_tesol)
                                echo "<span class='light-bg'>MA in ELT//TESOL</span>";
                            if(!empty($teacher->ta_other_diploma))
                                echo "<span class='light-bg'>".$teacher->ta_other_diploma."</span>";
                        ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>CV File:</strong></div>
                        <div class="col-sm-6 col-md-6 break-word mr-bt-tp-3 hlt-link"><a target="_blank" href="<?php echo base_url(). $CV_FILE_PATH . $teacher->ta_cv;?>"><?php echo $teacher->ta_cv;?></a></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Other document:</strong></div>
                        <div class="col-sm-6 col-md-6 break-word mr-bt-tp-3 hlt-link"><a target="_blank" href="<?php echo base_url(). $OTHER_FILE_PATH . $teacher->ta_other_document;?>"><?php echo $teacher->ta_other_document;?></a></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Passport or id card:</strong></div>
                        <div class="col-sm-6 col-md-6 break-word mr-bt-tp-3 hlt-link"><a target="_blank" href="<?php echo base_url(). PASSPORT_ID_CARD_FILE . $teacher->ta_passport_or_id_card;?>"><?php echo $teacher->ta_passport_or_id_card;?></a></div>
                    </div>
                <hr />
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Bank account detail</strong></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Currency type:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $teacher->tbd_currency_type;?></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Bank account name:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3 hlt-link"><?php echo (empty($teacher->tbd_account_name) ? "--" : $teacher->tbd_account_name);?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Bank account number:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo (empty($teacher->tbd_account_number) ? "--" : $teacher->tbd_account_number);?></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Sort code:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo (empty($teacher->tbd_sort_code) ? "--" : $teacher->tbd_sort_code);?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>IBAN:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo (empty($teacher->tbd_iban) ? "--" : $teacher->tbd_iban);?></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>SWIFT / BIC:</strong></div>
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo (empty($teacher->tbd_swift_bic) ? "--" : $teacher->tbd_swift_bic);?></div>
                    </div>
                <hr />
                    <div class="row">
                        <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Other files uploaded for office use</strong></div>
                    </div>
                <hr />
                <?php 
				}
				if($appOtherFiles){
                    foreach($appOtherFiles as $otherAppFile){
						if(APP_THEME == 'OLD'){
							?>
				<div class="clr">
                                <div class="grid_3"><strong><?php echo $otherAppFile['tof_title'];?>:</strong></div>
                                <div class="grid_6 hlt-link"><a target="_blank" href="<?php echo base_url(). $OFFICE_OTHER_FILE_PATH . $otherAppFile['tof_filename'];?>"><?php echo $otherAppFile['tof_filename'];?></a></div>
                            </div>
				<?php
						}
						else{
                        ?>
                            <div class="row">
                                <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong><?php echo $otherAppFile['tof_title'];?>:</strong></div>
                                <div class="col-sm-6 col-md-6 break-word mr-bt-tp-3 hlt-link"><a target="_blank" href="<?php echo base_url(). $OFFICE_OTHER_FILE_PATH . $otherAppFile['tof_filename'];?>"><?php echo $otherAppFile['tof_filename'];?></a></div>
                            </div>
                        <?php 
						}
                        }
                    }
                ?>
                    
                <?php /*
                 *  THIS WAS USED TO SHOW TEACHERS ASSIGNED HISTORY TO TUITION SCHEDULE
                 * ?>
                <div id="historyTable">
                    <br />
                    <span><strong>Teacher tuition schedule added history</strong></span>
                    <hr />
                    <table class="dynamic styled" data-filter-bar='false' data-max-items-per-page='5' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
                    <thead>
                            <tr>
                                <th>Teacher</th>
                                <th>Campus</th>
                                <th>From date</th>								
                                <th>To date</th>
                                <th>Hour per day</th>
                                <th>Action</th>
                            </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if($teacherHistory)
                    foreach($teacherHistory as $teacher){
                    ?>
                            <tr>
                                    <td class="center">
                                        <?php echo html_entity_decode($teacher["teacher_full_name"]);?>
                                    </td>
                                    <td class="center"><?php echo $teacher["nome_centri"];?></td>
                                    <td class="center"><?php echo date('d/m/Y',strtotime($teacher["teach_from_date"]));?></td>
                                    <td class="center"><?php echo date('d/m/Y',strtotime($teacher["teach_to_date"]));?></td>
                                    <td class="center"><?php echo $teacher["teach_hours_per_day"];?></td>
                                    <td class="center operation">
                                        <a title="Edit" data-teach-id="<?php echo $teacher["teach_id"];?>" class="edit-add-teacher" href="javascript:void(0);">
                                            <span class="icon-edit"></span>
                                        </a>
                                    </td>
                            </tr>
                    <?php
                            }
                    ?>
                    </tbody>
                    </table>
                </div>
                <?php */
            }
            else{
                echo "<div>Unable to find teacher record.</div>";
            }
        }
    }
    
    function confirmapplication()
    {
        $returnArr = array();
        $returnArr['status'] = 0;
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) 
        {
            $tea_id = $this->input->post('tea_id');
            $editTeacher = $this->input->post('editTeacher');
            $fromDate = $this->input->post('fromdate');
            $toDate = $this->input->post('todate');
            $fromDate = explode('/', $fromDate);
            $toDate = explode('/', $toDate);
            if(array_key_exists(2, $fromDate));
            $fromDate = $fromDate[2].'-'.$fromDate[1].'-'.$fromDate[0];
            if(array_key_exists(2, $toDate));
            $toDate = $toDate[2].'-'.$toDate[1].'-'.$toDate[0];

            if($tea_id)
            {
                if($editTeacher)
                {
                    $update_data = array(
                        'teach_first_name'=> trim($this->input->post('firstname')),
                        'teach_last_name'=> trim($this->input->post('lastname')),
                        'teach_campus_id'=> trim($this->input->post('campusId')),
                        'teach_hours_per_day'=> trim($this->input->post('hoursperday')),
                        'teach_application_id'=> $tea_id,
                        'teach_from_date'=> $fromDate,
                        'teach_to_date'=> $toDate
                    );

                    $result = $this->teachersmodel->operations('update',$update_data,$editTeacher);
                    if($result){
                        $returnArr['message'] = 'Teacher record updated in tuition schedule successfully';
                        $returnArr['status'] = 1;
                    }
                    else{
                        $returnArr['message'] = 'Unable to update teacher record';
                    }
                }
                else
                {
                    $insert_data = array(
                        'teach_first_name'=> trim($this->input->post('firstname')),
                        'teach_last_name'=> trim($this->input->post('lastname')),
                        'teach_campus_id'=> trim($this->input->post('campusId')),
                        'teach_hours_per_day'=> trim($this->input->post('hoursperday')),
                        'teach_application_id'=> $tea_id,
                        'teach_from_date'=> $fromDate,
                        'teach_to_date'=> $toDate,
                        'teach_is_active'=> 1,
                        'teach_is_deleted'=> 0
                    );

                    $result = $this->teachersmodel->operations('insert',$insert_data);
                    if($result){
                        $returnArr['message'] = 'Teacher added in tuition schedule successfully';
                        $returnArr['status'] = 1;
                    }
                    else{
                        $returnArr['message'] = 'Unable to add teacher record';
                    }
                }
            }
            else
                $returnArr['message'] = 'Unable to add teacher record';
        }
        echo json_encode($returnArr);
    }
    
    
    
    /* FUNCTIONS FOR: TEACHER APPLICATION STEP-2 */
    
    function sendadvjoboffer(){
        $returnData = array(
            'result' => 0,
            'message' => 'Unable to send available positions email.'
        );
        
        $teacherAppId = $this->input->post('teach_id');
        $teacher = $this->teachersappmodel->getTeachersApplicationsSingle($teacherAppId);
        if($teacher){
            if(!empty($teacher->ta_email))
            {
                $senderEmail = PLUS_SENDER_EMAIL_ADDRESS;
                $receiverEmail = $teacher->ta_email;

                ob_start(); // start output buffer
                $messageBody = "";
                $data['content'] = $messageBody;
                $this->load->view('tuition/email/job_offer_template', $data);
                $messageBody = ob_get_contents(); // get contents of buffer
                ob_end_clean();
                
                $this->load->library('email');

//                $config['protocol'] = 'sendmail';
//                //$config['mailpath'] = '/usr/sbin/sendmail';
//                $config['charset'] = 'iso-8859-1';
//                $config['wordwrap'] = TRUE;
//                $config['mailtype'] = 'html';
//                $this->email->initialize($config);
                
                $this->email->set_newline("\r\n");
                $this->email->from($senderEmail, 'plus-ed.com');
                $this->email->to($receiverEmail);
                $this->email->subject("plus-ed.com | Plus Junior Summer Programs 2017");
                $this->email->message($messageBody);
                $attachFile = SENT_JOB_OFFER_PATH . 'job_adv_offer.pdf';

                $this->email->attach($attachFile);

                if($this->email->send())
                {
                    // update flag in database ta_job_adv_sent
                    $updateArray = array(
                        'ta_job_adv_sent' => 1
                    );
                    $this->teachersappmodel->operations('update', $updateArray, $teacherAppId);
                    $returnData = array(
                        'result' => 1,
                        'message' => 'Available positions are sent successfully.'
                    );
                    
                }
                else
                {
                    $returnData = array(
                        'result' => 0,
                        'message' => 'Unable to send available positions email.'
                    );
                }
            }
            else
            {
                $returnData = array(
                    'result' => 0,
                    'message' => 'Email address not present for selected teacher.'
                );
            }

        }
        echo json_encode($returnData);
       
    }
    
    /**
    * profilereview
    * review teachers profile who has received job offer
    * @author SK
    * @since 18-Feb-2016
    */
    function profilereview() { 
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data["teachers_app"] = $this->teachersappmodel->getTeachersApplicationsData('profilereview'); // $this->session->userdata('id')
            //$data["campusList"] = $this->teachersmodel->getCampusList();
            $data["positionData"] = $this->teachersappmodel->getPositions();
            $data["postcodeData"] = $this->teachersappmodel->getPostcodeData(); 
            $data['title'] = "plus-ed.com | Teachers review";
            $data['breadcrumb1'] = 'Job & Conracts';
            $data['breadcrumb2'] = 'Teachers interviews';
            
            if(APP_THEME == "OLD")
                $this->load->view('tuition/plused_teachers_review', $data);
            else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/contract/teachers_review', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    /**
     * updateinterviewdetail
     * this functiona is used to save interview details in database.
     * @author SK
     * @since 18 Feb 2016
     */
    function updateinterviewdetail(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $teach_app_id = $this->input->post('teach_app_id');
            $txtSkypename = $this->input->post('txtSkypename');
            $txtInterviewNotes = $this->input->post('txtInterviewNotes');
            $txtStrong = $this->input->post('txtStrong');
            $txtWeek = $this->input->post('txtWeek');
            $selInterviewLevel = $this->input->post('selInterviewLevel');
            $chkCheckReferences = $this->input->post('chkCheckReferences');
            $chkReturnee = $this->input->post('chkReturnee');

            $updateArray = array(
                'ta_skype' => $txtSkypename,
                'ta_interview_notes' => $txtInterviewNotes,
                'ta_interview_strong' => $txtStrong,
                'ta_interview_weak' => $txtWeek,
                'ta_interview_level' => $selInterviewLevel,
                'ta_check_ref' => $chkCheckReferences,
                'ta_check_returnee' => $chkReturnee
            );
            
            $result = $this->teachersappmodel->operations('update', $updateArray, $teach_app_id);
            if($result)
            {
                echo json_encode(array('result'=>1,'message'=>'Interview detail updated successfully.'));
            }
            else
                echo json_encode(array('result'=>0,'message'=>'Unable to update interview detail.'));
            
        } else {
            echo json_encode(array('result'=>0,'message'=>'User session expired.'));
        }
    }
    
    /**
     * getinterviewdetail
     * used to show interview details for teachers
     */
    function getinterviewdetail(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $teacherAppId = $this->input->post('teach_app_id');
            $teacher = $this->teachersappmodel->getTeachersApplicationsSingle($teacherAppId);
            $resultSet = array();
            if($teacher){
                $resultSet = array(
                    'id' => $teacher->ta_id,
                    'skype' => $teacher->ta_skype,
                    'interview_notes' => $teacher->ta_interview_notes,
                    'interview_strong' => $teacher->ta_interview_strong,
                    'interview_weak' => $teacher->ta_interview_weak,
                    'interview_level' => $teacher->ta_interview_level,
                    'check_returnee' => $teacher->ta_check_returnee,
                    'check_ref' => $teacher->ta_check_ref
                );
                echo json_encode(array('result'=>1,'resultSet'=>$resultSet));
            }
            else
                echo json_encode(array('result'=>0,'message'=>''));
        } else {
            echo json_encode(array('result'=>0,'message'=>'User session expired.'));
        }
    }
    
    /**
     * sendjobofferletter
     * this function is used to send job offer letters to the teachers(Applicant)
     * as per position selected job offer letter pdf will be sent to the teacher.
     * 
     */
    function sendjobofferletter(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $teaAppId = $this->input->post('teaId');
            $position = $this->input->post('position');
            $positionId = $this->input->post('positionId');
            $selType = $this->input->post('selType');
            $selWages = $this->input->post('selWages');
            $selRate = $this->input->post('selRate');
            $dramaSession = $this->input->post('dramaSession');
            $res_non_res = $this->input->post('res_non_res');
            $currency_code = $this->input->post('currency');
            $currency = "";
            $messageBody = "";
            $insertArr = array();
            if($teaAppId > 0 && !empty($position))
            {
                $teacher = $this->teachersappmodel->getTeachersApplicationsSingle($teaAppId);
                $fpdFileName = "";
                $email_template_file = "";
                if($teacher)
                {
                    $data['letterDate'] = date('d/m/Y');
                    $data['recipientName'] = $teacher->teacher_full_name;
                    if($currency_code == "EUR")
                        $currency = "&euro;";
                    else if($currency_code == "GBP")
                        $currency = "&pound;";
                    else if($currency_code == "USD")
                        $currency = "$";
                    $data['currencySymbol'] = $currency;
                    switch ($position)
                    {
                        case 'Teacher': // Genrate pdf for Teacher
                            $data['specificaitonFile'] = "teacher.pdf";
                            if($selType == "Academy") /* TEACHER ACADEMY */
                            {
                                $data['wagesType'] = $selWages;
                                $data['ratePerHour'] = $selRate;
                                $email_template_file = "tuition/email/pdf_job_offer_teacher_academy";
                                $fpdFileName = "Teacher_Res_Academy";
                                
                                if($selWages == 'Weekly')
                                    $selRate = 0;
                                $insertArr = array(
                                    'jof_teacher_app_id' => $teaAppId,
                                    'jof_position_id' => $positionId,
                                    'jof_currency' => $currency_code,
                                    'jof_teacher_type' => $selType,
                                    'jof_rates' => $selRate,
                                    'jof_wages' => $selWages,
                                    'jof_created_on' => date("Y-m-d H:i:s")
                                );
                                
                            }
                            else if($selType == "Dublin") /*  TEACHER Dublin */
                            {
                                $data['ratePerHour'] = $selRate;
                                $email_template_file = "tuition/email/pdf_job_offer_teacher_dublin";
                                $fpdFileName = "Dublin_Teacher";
                                $insertArr = array(
                                    'jof_teacher_app_id' => $teaAppId,
                                    'jof_position_id' => $positionId,
                                    'jof_currency' => $currency_code,
                                    'jof_teacher_type' => $selType,
                                    'jof_rates' => $selRate,
                                    'jof_created_on' => date("Y-m-d H:i:s")
                                );
                            }
                            else if($selType == "Non-res horizontal zig zag") /*  TEACHER Non-res horizontal zig zag */
                            {
                                $data['ratePerHour'] = $selRate;
                                $data['wagesType'] = $selWages;
                                $email_template_file = "tuition/email/pdf_job_offer_teacher_non_res_horizontal_zig_zag";
                                $fpdFileName = "Teacher_Non_res_horizontal_zig_zag";
                                if($selWages == 'Weekly')
                                    $selRate = 0;
                                $insertArr = array(
                                    'jof_teacher_app_id' => $teaAppId,
                                    'jof_position_id' => $positionId,
                                    'jof_currency' => $currency_code,
                                    'jof_teacher_type' => $selType,
                                    'jof_rates' => $selRate,
                                    'jof_wages' => $selWages,
                                    'jof_created_on' => date("Y-m-d H:i:s")
                                );
                            }
                            else if($selType == "London")
                            {
                                $data['ratePerHour'] = $selRate;
                                $email_template_file = "tuition/email/pdf_job_offer_teacher_london";
                                $fpdFileName = "London_Teacher";
                                $insertArr = array(
                                    'jof_teacher_app_id' => $teaAppId,
                                    'jof_position_id' => $positionId,
                                    'jof_currency' => $currency_code,
                                    'jof_teacher_type' => $selType,
                                    'jof_rates' => $selRate,
                                    'jof_created_on' => date("Y-m-d H:i:s")
                                );
                            }
                            else if($selType == "Non London")
                            {
                                $data['dramaSession'] = $dramaSession;
                                if($res_non_res == "Residential")
                                {
                                    $data['ratePerHour'] = $selRate;
                                    $email_template_file = "tuition/email/pdf_job_offer_teacher_res_non_london";
                                    $fpdFileName = "Teacher_Res_NonLondon";
                                }
                                else if($res_non_res == "Non-residential")
                                {
                                    $data['ratePerHour'] = $selRate;
                                    $email_template_file = "tuition/email/pdf_job_offer_teacher_non_res_non_london";
                                    $fpdFileName = "Teacher_NonRes_NonLondon";
                                }
                                $insertArr = array(
                                    'jof_teacher_app_id' => $teaAppId,
                                    'jof_position_id' => $positionId,
                                    'jof_currency' => $currency_code,
                                    'jof_teacher_type' => $selType,
                                    'jof_rates' => $selRate,
                                    'jof_residential' => $res_non_res,
                                    'jof_created_on' => date("Y-m-d H:i:s")
                                );
                            }
                            break;
                        case 'Course Director': // Genrate pdf for Course Director
                            $data['specificaitonFile'] = "course_director.pdf";
                            $email_template_file = "tuition/email/pdf_job_offer_course_director";
                            $fpdFileName = "Course_Director";
                            $insertArr = array(
                                'jof_teacher_app_id' => $teaAppId,
                                'jof_position_id' => $positionId,
                                'jof_currency' => $currency_code,
                                'jof_created_on' => date("Y-m-d H:i:s")
                            );
                            break;
                        case 'Assistant Course Director': //Genrate pdf for Assistant Course Director
                            $data['specificaitonFile'] = "assistant_course_director.pdf";
                            $email_template_file = "tuition/email/pdf_job_offer_assistant_course_director";
                            $fpdFileName = "Assistant_Course_Director";
                            $insertArr = array(
                                'jof_teacher_app_id' => $teaAppId,
                                'jof_position_id' => $positionId,
                                'jof_currency' => $currency_code,
                                'jof_created_on' => date("Y-m-d H:i:s")
                            );
                            break;
                        case 'Activity Leader': //Genrate pdf for Activity Leader
                            $email_template_file = "tuition/email/pdf_job_offer_activity_leader";
                            $fpdFileName = "Activity_Leader";
                            $insertArr = array(
                                'jof_teacher_app_id' => $teaAppId,
                                'jof_position_id' => $positionId,
                                'jof_currency' => $currency_code,
                                'jof_created_on' => date("Y-m-d H:i:s")
                            );
                            break;
                        case 'Choreographer': //Genrate pdf for Choreographer
                            $email_template_file = "tuition/email/pdf_job_offer_choreographer";
                            $fpdFileName = "Choreographer";
                            $insertArr = array(
                                'jof_teacher_app_id' => $teaAppId,
                                'jof_position_id' => $positionId,
                                'jof_currency' => $currency_code,
                                'jof_created_on' => date("Y-m-d H:i:s")
                            );
                            break;
                        case 'Excursion Guide': //Genrate pdf for Excursion Guide
                            $email_template_file = "tuition/email/pdf_job_offer_excursion_guide";
                            $fpdFileName = "Excursion_Guide";
                            $insertArr = array(
                                'jof_teacher_app_id' => $teaAppId,
                                'jof_position_id' => $positionId,
                                'jof_currency' => $currency_code,
                                'jof_created_on' => date("Y-m-d H:i:s")
                            );
                            break;
                    }
                    
                    if(!empty($fpdFileName))
                    {
                        // LOAD PDF FILE TEMPLATE AND GENRATE .PDF FILE
                        ob_start(); // start output buffer
                        $this->load->view($email_template_file, $data);
                        $messageBody = ob_get_contents(); // get contents of buffer
                        ob_end_clean();
                        $fpdFileName = $fpdFileName . '_' . time();
                        define("PDF_CONTENT_HIGHLIGHT_STYLE","color: #558877");
                        writeHtmlPdfAndSave($messageBody,$fpdFileName,SENT_JOB_OFFER_PATH,true);
                        $fpdFileName = $fpdFileName.".pdf";
                        // END OF FILE(ATTACHMENT)
                        // add record in history
                        $insertArr['job_offer_file'] = $fpdFileName;
                        $jobOfferId = $this->teachersappmodel->jobOfferOperations('insert',$insertArr);
                        $data['jobOfferId'] = $jobOfferId;
                        // send offer letter email
                        $senderEmail = PLUS_SENDER_EMAIL_ADDRESS;
                        $receiverEmail = $teacher->ta_email;

                        ob_start(); // start output buffer
                        $this->load->view('tuition/email/job_offer_letter_pdf', $data);
                        $messageBody = ob_get_contents(); // get contents of buffer
                        ob_end_clean();

                        $this->load->library('email');

                        $this->email->set_newline("\r\n");
                        $this->email->from($senderEmail, 'plus-ed.com');
                        $this->email->to($receiverEmail);
                        $this->email->subject("plus-ed.com | Job offer letter");
                        $this->email->message($messageBody);
                        $attachFile = SENT_JOB_OFFER_PATH.$fpdFileName;

                        $this->email->attach($attachFile);
                        $emaiResult = @$this->email->send();
                        if($emaiResult)
                        {
                            echo json_encode(array('result'=>1,'message'=>"Job offer letter email sent successfully."));
                        }
                        else
                            echo json_encode(array('result'=>0,'message'=>"Unable to send job offer letter email."));
                    }
                    else
                        echo json_encode(array('result'=>0,'message'=>"Unable to send job offer letter email."));
                }
                else
                {
                    echo json_encode(array('result'=>0,'message'=>"Unable to load teacher detail."));
                }
            }
            else
            {
                echo json_encode(array('result'=>0,'message'=>"All <span class='star-red'>*</span> fields are mandatory."));
            }
        } else {
            echo json_encode(array('result'=>0,'message'=>'User session expired.'));
        }
    }
    
    /**
     * getSendJobHistory
     * this function is used to show job offer history
     */
    function getSendJobHistory(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $teacherAppId = $this->input->post('teacher_appid');
            $jobOfferHistory = $this->teachersappmodel->getSendJobOfferHistory($teacherAppId);
            $data['jobOfferHistory'] = $jobOfferHistory;
            
            if(APP_THEME == "OLD")
                $this->load->view('tuition/plused_send_job_offer_history', $data);
            else // if(APP_THEME == "LTE")
            {
                $this->load->view('lte/backoffice/contract/ajax_send_job_offer_history', $data);
            }
        }
    }
    
    
    function uploadposition(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $fileError = array();
            if(!empty($_POST)){
                $this->load->library('upload');
                //--- SET CONFIGRATION ---//
                //SENT_JOB_OFFER_PATH . 'job_adv_offer.pdf';
                if(!empty($_FILES['fileNewPosition']['name'])){
                    if (!file_exists(SENT_JOB_OFFER_PATH)) {
                        mkdir(SENT_JOB_OFFER_PATH, 0755,true);
                    }
                    $config['upload_path'] = SENT_JOB_OFFER_PATH;
                    $config['allowed_types'] = 'pdf';
                    $config['max_size']	= '10240';
                    $config['overwrite']= TRUE;
                    $config['file_name'] = "job_adv_offer.pdf";
                    $this->upload->initialize($config);
                    //---- UPLOAD FILE ----//
                    if (!$this->upload->do_upload("fileNewPosition")){
                        $fileError = $this->upload->display_errors();
                    }
                    else{
                        $this->session->set_flashdata('success_message','New positions file uploaded successfully.');
                        redirect('teachers/uploadposition');
                        exit();
                    }
                }
            }
            $data['fileError'] = $fileError;
            $data['title'] = "plus-ed.com | Upload new positions";
            $data['breadcrumb1'] = 'Job and contracts';
            $data['breadcrumb2'] = 'Upload new positions';
            $data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/contract/upload_positions', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    // BELOW TWO FUNCTIONS ARE MOVED TO POSITIONS CONTROLLER.
    /*function advjobofferfile(){
        $this->load->helper('download');
        $attachFile = SENT_JOB_OFFER_PATH . 'job_adv_offer.pdf';
        $data = file_get_contents($attachFile); // Read the file's contents
        $name = 'job_adv_offer.pdf';
        force_download($name, $data); 
    }
    
    function jobofferdownload($jobOfferId = 0){
        if(!empty($jobOfferId))
        {
            $jobOfferId = base64_decode($jobOfferId);
            if(is_numeric($jobOfferId)){
                $this->load->helper('download');
                $result = $this->teachersappmodel->getJobOfferLetter($jobOfferId);
                if($result)
                {
                    $fileName = $result->job_offer_file;
                    $attachFile = SENT_JOB_OFFER_PATH . $fileName;
                    $data = file_get_contents($attachFile); // Read the file's contents
                    force_download($fileName, $data);
                }
            }
        }
    }*/
    
    
}/* End of file teachers.php */