<?php

class EmailTemplate extends Controller {

    function __construct() {
        parent::__construct();
        // check user session and menus with their access.
        authSessionMenu($this);
        $this->load->model('tuition/emailtemplatemodel', '', TRUE);
        $this->load->library('form_validation');
    }

    public function index() {
        if ($this->session->userdata('username')) {
            $data['title'] = "plus-ed.com | Email template";
            $data['breadcrumb1'] = 'Templates';
            $data['breadcrumb2'] = 'Email template';
            $data['pageHeader'] = "Email template";
            $data['optionalDescription'] = "";
            $data['allEmailTemplate'] = $this->emailtemplatemodel->getData();
            $this->ltelayout->view('lte/backoffice/tuition/email_template_view', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    public function addedit($editId = 0) {
        if ($this->session->userdata('username')) {
            $aData['editId'] = $editId;
            //---- CHECK FORM POST OR NOT ----//
            if (empty($_POST)) {
                if ($editId > 0) {
                    ############ EDIT DETAIL ##########
                    $aEMTDetail = $this->emailtemplatemodel->getData($editId);
                    if (!empty($aEMTDetail)) {
                        $aData['editId'] = $editId;
                        $aData['aFormData'] = $aEMTDetail[0];
                        $aData['title'] = "Edit email template";
                        $aData['sButtonValue'] = "Update";
                        $aData['breadcrumb1'] = 'Templates';
                        $aData['breadcrumb2'] = 'Edit email template';
                        $aData['pageHeader'] = $aData['breadcrumb2'];
                        $aData['optionalDescription'] = "";
                    } else {
                        $this->session->set_userdata('error_message', 'Unable to find email template');
                        redirect('emailtemplate');
                    }
                } else {
                    $this->session->set_userdata('error_message', 'Unable to find email template');
                    redirect('emailtemplate');
                }
            } else {
                //***** PROCESS FORM DATA ****//
                $editId = $this->input->post('hidEmtID');
                $aData['editId'] = $editId;
                if ($editId > 0) {
                    $aUpdateData = array(
                        'emt_from_email' => trim($this->input->post('emt_from_email')),
                        'emt_to_email' => trim($this->input->post('emt_to_email')),
                        'emt_title' => trim($this->input->post('emt_title')),
                        'emt_text' => trim($this->input->post('emt_text'))
                    );
                    $this->emailtemplatemodel->UpdateDetail($editId, $aUpdateData);
                    $this->session->set_userdata('success_message', 'Email template updated successfully.');
                    redirect('emailtemplate');
                } else {
                    $this->session->set_userdata('error_message', 'Create new template not allowed.');
                    redirect('emailtemplate');
                }
            }
        } else {
            redirect('emailtemplate');
        }//End user id session if condition.
        $this->ltelayout->view('lte/backoffice/tuition/email_template_add', $aData);
    }
    
    public function genratepreview(){
        $emtId = $this->input->post('emt_id');
        if($emtId)
        {
            $emailTemplate = getEmailTemplate($emtId);
            $paramArr = array();
            $txtMessageStr = mergeContent($paramArr,$emailTemplate->emt_text);
            echo $txtMessageStr;
            exit();
        }
        echo "Template not found.";
    }


    public function _delete_emt($editId = 0) {
        $update_array = array('emt_delete' => 1);
        $this->emailtemplatemodel->action('update', $update_array, $editId);
        $this->session->set_userdata('success_message', 'Record deleted successfully');
        redirect('emailtemplate');
    }
}
