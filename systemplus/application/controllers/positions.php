<?php
/**
 * This controller is made to handle applications post 
 * requests from external website apply form for available prositions.
 */
class Positions extends Controller {

    public function __construct() {

        parent::Controller();

        $this->load->helper(array('form', 'url'));
        $this->load->library('session', 'email', 'excel');
        $this->load->model("tuition/teachersmodel", "teachersmodel");
        $this->load->model("tuition/teachersappmodel", "teachersappmodel");
    }

    /**
     * apply
     * Please use this function to set form action in 
     * external website apply form for available prositions.
     */
    function apply() {
        $this->load->library('form_validation');
        $formData = array(
            'ta_firstname' => "",
            'ta_lastname' => "",
            'ta_date_of_birth' => "",
            'ta_nationality' => "",
            'ta_sex' => "",
            'ta_email' => "",
            'ta_telephone' => "",
            'ta_address' => "",
            'ta_city' => "",
            'ta_postcode' => "",
            'ta_teach_years' => "",
            'ta_country' => "",
            'ta_ablility_from' => "",
            'ta_ablility_to' => "",
            'ta_celta' => 0,
            'ta_trinity_tesol' => 0,
            'ta_delta' => 0,
            'ta_dip_tesol' => 0,
            'ta_b_ed' => 0,
            'ta_pgce' => 0,
            'ta_ma_elt_tesol' => 0,
            'ta_other_diploma' => "",
            'ta_cv' => "",
            'ta_other_document' => ""
        );
        $formData['cv_file_error'] = "";
        $formData['other_file_error'] = "";
        if (!empty($_POST)) {
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
            if ($this->form_validation->run() == TRUE) {
                $this->load->library('upload');
                $otherFile = "";
                $cvFile = "";
                $fileError = array();
                $otherFileError = array();
                //--- SET CONFIGRATION ---//
                $CV_FILE_PATH = '/var/www/html/www.plus-ed.com/teacherApplications/cv/';
                $OTHER_FILE_PATH = '/var/www/html/www.plus-ed.com/teacherApplications/other/';

                if (!empty($_FILES['cvFile']['name'])) {
                    if (!file_exists($CV_FILE_PATH)) {
                        mkdir($CV_FILE_PATH, 0755, true);
                    }
                    $file_name = time() . '_' . $this->stripJunk($_FILES['cvFile']['name']);
                    $config['upload_path'] = $CV_FILE_PATH;
                    $config['allowed_types'] = 'doc|docx|ods|pdf';
                    $config['max_size'] = '1000';
                    $config['file_name'] = $file_name;
                    $this->upload->initialize($config);
                    //---- UPLOAD IMAGE ----//
                    if ($this->upload->do_upload("cvFile")) {
                        $aUploadData = $this->upload->data();
                        $cvFile = $aUploadData['file_name'];
                    } else {
                        $fileError = array('error' => $this->upload->display_errors());
                    }
                }

                if (!empty($_FILES['otherFile']['name'])) {
                    if (!file_exists($OTHER_FILE_PATH)) {
                        mkdir($OTHER_FILE_PATH, 0755, true);
                    }
                    $file_name = time() . '_' . $this->stripJunk($_FILES['otherFile']['name']);
                    $config['upload_path'] = $OTHER_FILE_PATH;
                    $config['allowed_types'] = 'doc|docx|ods|pdf';
                    $config['max_size'] = '1000';
                    $config['file_name'] = $file_name;
                    $this->upload->initialize($config);
                    //---- UPLOAD IMAGE ----//
                    if ($this->upload->do_upload("otherFile")) {
                        $aUploadData = $this->upload->data();
                        $otherFile = $aUploadData['file_name'];
                    } else {
                        $otherFileError = array('error' => $this->upload->display_errors());
                    }
                }

                if (array_key_exists('error', $fileError) || array_key_exists('error', $otherFileError)) {
                    if (array_key_exists('error', $fileError))
                        $formData['cv_file_error'] = $fileError['error'];
                    if (array_key_exists('error', $otherFileError))
                        $formData['other_file_error'] = $otherFileError['error'];
                    if (!empty($cvFile))
                        @unlink($CV_FILE_PATH . $cvFile);
                    if (!empty($otherFile))
                        @unlink($OTHER_FILE_PATH . $otherFile);
                }
                else {
                    $fromDate = $this->input->post('txtAblilityFrom');
                    $toDate = $this->input->post('txtAblilityTo');
                    $birthDate = $this->input->post('txtDateofBirth');
                    $fromDate = explode('/', $fromDate);
                    $toDate = explode('/', $toDate);
                    $birthDate = explode('/', $birthDate);
                    if (array_key_exists(2, $fromDate))
                        $fromDate = $fromDate[2] . '-' . $fromDate[1] . '-' . $fromDate[0];
                    if (array_key_exists(2, $toDate))
                        $toDate = $toDate[2] . '-' . $toDate[1] . '-' . $toDate[0];
                    if (array_key_exists(2, $birthDate))
                        $birthDate = $birthDate[2] . '-' . $birthDate[1] . '-' . $birthDate[0];

                    $insert_data = array(
                        'ta_firstname' => trim($this->input->post('txtFirstName')),
                        'ta_lastname' => trim($this->input->post('txtLastName')),
                        'ta_date_of_birth' => $birthDate,
                        'ta_nationality' => trim($this->input->post('selNationality')),
                        'ta_sex' => trim($this->input->post('selSex')),
                        'ta_email' => trim($this->input->post('txtEmail')),
                        'ta_telephone' => trim($this->input->post('txtTelephone')),
                        'ta_address' => trim($this->input->post('txtAddress')),
                        'ta_city' => trim($this->input->post('txtCity')),
                        'ta_postcode' => trim($this->input->post('txtPostCode')),
                        'ta_teach_years' => $this->input->post('txtYoT'),
                        'ta_country' => trim($this->input->post('selCountry')),
                        'ta_ablility_from' => $fromDate,
                        'ta_ablility_to' => $toDate,
                        'ta_celta' => ($this->input->post('chkCelta') == "" ? 0 : 1),
                        'ta_trinity_tesol' => ($this->input->post('chkTrinityTesol') == "" ? 0 : 1),
                        'ta_delta' => ($this->input->post('chkDelta') == "" ? 0 : 1),
                        'ta_dip_tesol' => ($this->input->post('chkDipTesol') == "" ? 0 : 1),
                        'ta_b_ed' => ($this->input->post('chkBEd') == "" ? 0 : 1),
                        'ta_pgce' => ($this->input->post('chkPgce') == "" ? 0 : 1),
                        'ta_ma_elt_tesol' => ($this->input->post('chkMaEltTesol') == "" ? 0 : 1),
                        'ta_other_diploma' => trim($this->input->post('txtOtherDiploma')),
                        'ta_cv' => $cvFile,
                        'ta_other_document' => $otherFile,
                        'ta_created_on' => date("Y-m-d H:i:s"),
                        'ta_is_deleted' => 0
                    );
                    $result = $this->teachersmodel->insertApplication($insert_data);
                    if ($result) {
                        header("location: http://www.plus-ed.com/apps/index.php/courses/job/ok");
                        exit;
                    } else {
                        header("location: http://www.plus-ed.com/apps/index.php/courses/job/ko1");
                        exit;
                    }
                }
            } else {
                header("location: http://www.plus-ed.com/apps/index.php/courses/job/ko2");
                exit;
            }
        }
    }
    
    /**
     * stripJunk
     * this function can be used to strip unwanted characters from file name.
     * @param $string input filename
     * @return string
     * @author SK
     * @since Mar 03 17
     */
    function stripJunk($string){
        $string = str_replace(" ", "-", trim($string));
        $string = preg_replace("/[^a-zA-Z0-9-.]/", "", $string);
        $string = strtolower($string);
        return $string;
    }
    
    /**
     * allow user to download file  
     */
    function advjobofferfile(){
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
    }
    
    function specification($fileName = ""){
        if(!empty($fileName))
        {
            $this->load->helper('download');
            if(!file_exists($fileName))
            {
                $attachFile = JOB_OFFER_TERM_SPECIFICATION_PATH . $fileName;
                $data = file_get_contents($attachFile); // Read the file's contents
                force_download($fileName, $data);
            }
        }
    }
    
    function loadtemplate(){
        $data = array(
            'specificaitonFile' => "assistant_course_director.pdf",
            'recipientName' => "recipientName",
            'jobOfferId' => "000",
            'currencySymbol' => "$",
            'ratePerHour' => "10",
            'wagesType' => "Hourly",
            'dramaSession' => 1
        );
        $this->load->view('tuition/email/pdf_job_offer_teacher_res_non_london', $data);
    }
    
}/* End of file positions.php */