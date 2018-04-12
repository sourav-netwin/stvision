<?php
/**
 * Backofficeextn
 * This controller is created to extend the functionality of backoffice.
 */
class Backofficeextn extends Controller {

    public function __construct() {
        parent::Controller();

        $this->load->helper(array('form', 'url'));
        $this->load->helper('csv');
        $this->load->model('mbackoffice');
        $this->load->model('magenti');
        $this->load->model('gestione_centri_model');
        //$this->load->library('session','email','excel');
        $this->load->library(array('session', 'email', 'ltelayout'));
    }
    
    /**
     * This function is used to generate the students 
     * details list with login credentials.
     * This will be emailed to the agents 
     */
    function getPaxListPrintLogin(){
        $data = array();
        $year = $this->input->post('year');
        $bookId = $this->input->post('bookId');
        $isRosterLock = $this->input->post('isRosterLock');
        if($isRosterLock != 1)
            $isRosterLock = 0;
        $data['detMyPax'] = $this->mbackoffice->listPaxForLogin($bookId,$year);
        $data['isFlocked'] = $isRosterLock;
        $this->load->view('lte/backoffice/print_students_login',$data);
    }
    
    /**
     * Send an email to agents regarding 
     * students login details. 
     */
    function sendStdLoginDetails(){
        $emailBody = $this->input->post('emailBody');
        $emailIds = $this->input->post('emailIds');
        $this->load->library('email');
        $emailTemplate = getEmailTemplate(EmailTemplateIds::$STUDENTS_LOGIN_DETAIL); // STUDENTS LOGIN DETAILS
        $this->email->set_newline("\r\n");
        $this->email->from($emailTemplate->emt_from_email, "Plus-ed.com");
        $this->email->to($emailIds);
        $this->email->subject($emailTemplate->emt_title);
        $loginUrl = base_url()."index.php/vauth/students";
        $strParam = array(
            '{LOGIN_URL}' => $loginUrl,
            '{STUDENTS_LIST}' => $emailBody
        );
        $txtMessageStr = mergeContent($strParam,$emailTemplate->emt_text);
        $this->email->message($txtMessageStr);
        $result = $this->email->send();
        if($result){
            echo json_encode(array('result'=>1));
        }
        else
            echo json_encode(array('result'=>0));
    }
}
/* End of file backofficeextn.php */
