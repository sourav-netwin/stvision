<?php
class Contacts extends Controller {

    public function __construct() {

    parent::Controller();
        // check user session and menus with their access.
        authSessionMenu($this);
        $this->load->helper(array('form', 'url'));
        $this->load->library('session', 'email', 'excel');
        $this->load->model("agents/contactsmodel", "contactsmodel");
    }

    /**
    * index
    * This is default function to load Contacts 
    * @author SK
    * @since 15-Dec-2015
    */
    function index() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $agentId = $this->session->userdata('id'); 
            $data["all_contacts"] = $this->contactsmodel->getData(0,$agentId);
            $data['title'] = "plus-ed.com | Contacts";
            $data['breadcrumb1'] = 'Contacts';
            $data['breadcrumb2'] = 'Manage contacts';
            
            $data['pageHeader'] = "Manage contacts";
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/agents/contacts/manage_contacts', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    /**
    * addedit
    * This function is used to show add / edit view for Contacts.
    * @param int $edit_id
    * @author SK
    * @since 15-Dec-2015
    */
    function addedit($edit_id = 0){
            $this->load->library('form_validation');
            if($this->session->userdata('username')){
                $formData = array(
                    'txtFirstname' => '',
                    'txtLastname' => '',
                    'txtEmail' => '',
                    'txtPhoneNumber' => '',
                    'txtRole' => '',
                    'selCategory' => ''
                );
                $data['edit_id'] = $edit_id;

                if(!empty($_POST['btnSave'])){

                    $formVal = array(
                        array(
                            'field' => 'txtFirstname',
                            'label' => 'First name',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtLastname',
                            'label' => 'Last name',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtEmail',
                            'label' => 'Email',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtPhoneNumber',
                            'label' => 'Phone number',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtRole',
                            'label' => 'From date',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'selCategory',
                            'label' => 'To date',
                            'rules' => 'required'
                        )
                    );
                    $this->form_validation->set_rules($formVal); 
                    if ($this->form_validation->run() == TRUE)
                    {
                        $edit_id = $this->input->post('edit_id');
                        if($edit_id){
                            $update_data = array(
                                'cont_name'=> trim($this->input->post('txtFirstname')),
                                'cont_surname'=> trim($this->input->post('txtLastname')),
                                'cont_email'=> trim($this->input->post('txtEmail')),
                                'cont_phone_number'=> trim($this->input->post('txtPhoneNumber')),
                                'cont_role'=> trim($this->input->post('txtRole')),
                                'cont_category'=> trim($this->input->post('selCategory')),
                            );
                            $result = $this->contactsmodel->operations('update',$update_data,$edit_id);
                            if($result){
                                $this->session->set_flashdata('success_message','Record updated successfully.');
                                redirect('contacts');
                            }
                            else{
                                $this->session->set_flashdata('error_message','Unable to add record.');
                            }
                        }
                        else{
                            $insert_data = array(
                                'cont_name'=> trim($this->input->post('txtFirstname')),
                                'cont_agent_id'=> trim($this->input->post('agent_id')),
                                'cont_surname'=> trim($this->input->post('txtLastname')),
                                'cont_email'=> trim($this->input->post('txtEmail')),
                                'cont_phone_number'=> trim($this->input->post('txtPhoneNumber')),
                                'cont_role'=> trim($this->input->post('txtRole')),
                                'cont_category'=> trim($this->input->post('selCategory')),
                                'cont_is_active'=> 1,
                                'cont_is_deleted'=> 0
                            );

                            $result = $this->contactsmodel->operations('insert',$insert_data);
                            if($result){
                                $this->session->set_flashdata('success_message','Record added successfully.');
                                redirect('contacts');
                            }
                            else{
                                $this->session->set_flashdata('error_message','Unable to add record.');
                            }
                        }
                    }
                    else
                    {
                        $formData = array(
                            'txtFirstname' => trim($this->input->post('txtFirstname')),
                            'txtLastname' => trim($this->input->post('txtLastname')),
                            'txtEmail' => trim($this->input->post('txtEmail')),
                            'txtPhoneNumber' => trim($this->input->post('txtPhoneNumber')),
                            'txtRole' => trim($this->input->post('txtRole')),
                            'selCategory' => trim($this->input->post('selCategory'))
                        );
                    }
                }
                else
                {
                    if($edit_id){
                        // get contactdetails for edit purpose
                        $contactDetails = $this->contactsmodel->getData($edit_id);

                        if($contactDetails){
                            $contactDetails = $contactDetails[0];
                            $formData = array(
                                'txtFirstname' => $contactDetails['cont_name'],
                                'txtLastname' => $contactDetails['cont_surname'],
                                'txtEmail' => $contactDetails['cont_email'],
                                'txtPhoneNumber' => $contactDetails['cont_phone_number'],
                                'txtRole' => $contactDetails['cont_role'],
                                'selCategory' => $contactDetails['cont_category']
                            );
                        }
                    }
                }
                $agentId = $this->session->userdata('id'); // GET THE CAMPUS ID IF AVAILABLE.
                $data['agent_id'] = $agentId;
                $data['title']="plus-ed.com | Contacts";
                $data['breadcrumb1'] = 'Contacts';
                if($edit_id)
                    $data['breadcrumb2']='Edit contact';
                else
                    $data['breadcrumb2']='Add new contact';
                $data['formData']= $formData;
                
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/contacts/contacts_add', $data);

            }else{
                $this->session->sess_destroy();	
                redirect('backoffice','refresh'); 
            }

    }


    /**
    * contact_change_status
    * This function is used to toggle contact active status.
    * @author SK
    * @since 16-Dec-2015
    */
    function contact_change_status(){
        $contactId = $this->input->post('id');
        $contactStatus = $this->input->post('status');
        if($contactStatus == 1) // change status to update..
            $contactStatus = 0;
        else
            $contactStatus = 1;
        $udpateData = array(
            'cont_is_active' => $contactStatus
        );
        $result = $this->contactsmodel->operations('changestatus',$udpateData,$contactId);
        if($result){
            echo json_encode(array('result'=>1,'message'=>'Contact status changed successfully.','status'=>$contactStatus));
        }
        else
            echo json_encode(array('result'=>0,'message'=>'Unable to change contact status.'));

    }
    
    function get_detail(){
        $contactId = $this->input->post('edit_id');
        $contactDetails = $this->contactsmodel->getData($contactId);
        $formData = array();
        if($contactDetails){
            $contactDetails = $contactDetails[0];
            $formData = array(
                'txtFirstname' => $contactDetails['cont_name'],
                'txtLastname' => $contactDetails['cont_surname'],
                'txtEmail' => $contactDetails['cont_email'],
                'txtPhoneNumber' => $contactDetails['cont_phone_number'],
                'txtRole' => $contactDetails['cont_role'],
                'selCategory' => $contactDetails['cont_category']
            );
        }
        echo json_encode($formData);
    }

    /**
    * deletecontact
    * This function is used to remove contact form system
    * @author SK
    * @since 16-Dec-2015
    */
    function deletecontact($contactId = 0){
        $result = $this->contactsmodel->operations('delete',null,$contactId);
        if($result){
            $this->session->set_flashdata('success_message','Contact deleted successfully.');
            redirect('contacts');
        }
        else
            $this->session->set_flashdata('error_message','Unable to delete contact.');
            redirect('contacts');

    }
    
    /**
    * deletecontact
    * This function is used to remove contact form system
    * @author SK
    * @since 16-Dec-2015
    */
    function deleteAjaxContact(){
        $contactId = $this->input->post('cont_id');
        $result = $this->contactsmodel->operations('delete',null,$contactId);
        if($result){
            echo json_encode(array('result'=>1,'message'=>'Contact deleted successfully.'));
        }
        else{
            echo json_encode(array('result'=>0,'message'=>'Unable to delete contact.'));
        }

    }
    
    function stripJunk($string){
        $string = str_replace(" ", "", trim($string));
        $string = preg_replace("/[^a-zA-Z0-9.]/", "", $string);
        $string = strtolower($string);
        return $string;
    }
    
    function ajaxmanagecontacts() {
        if ($this->session->userdata('username')) {
            
            $agentId = $this->input->post('agent_id');
            $data["all_contacts"] = $this->contactsmodel->getData(0,$agentId);
            $this->load->view('lte/agents/contacts/account_manager_contacts', $data);
        } else {
            echo "Session is expired.";
        }
    }
    
    function ajaxupdate(){
        $edit_id = $this->input->post('edit_id');
        $firstName = trim($this->input->post('txtFirstname'));
        $agentId = trim($this->input->post('agent_id'));
        $lastName = trim($this->input->post('txtLastname'));
        $email = trim($this->input->post('txtEmail'));
        $phoneNumber = trim($this->input->post('txtPhoneNumber'));
        $role = trim($this->input->post('txtRole'));
        $category = trim($this->input->post('selCategory'));
        if($edit_id){
            $update_data = array(
                'cont_name'=> $firstName,
                'cont_surname'=> $lastName,
                'cont_email'=> $email,
                'cont_phone_number'=> $phoneNumber,
                'cont_role'=> $role,
                'cont_category'=> $category
            );
            $result = $this->contactsmodel->operations('update',$update_data,$edit_id);
            if($result){
                echo json_encode(array('result'=>1,'message'=>'Contact updated successfully.'));
            }
            else{
                echo json_encode(array('result'=>0,'message'=>'Unable to update contact.'));
            }
        }
        else{
            $insert_data = array(
                'cont_name'=> $firstName,
                'cont_agent_id'=> $agentId,
                'cont_surname'=> $lastName,
                'cont_email'=> $email,
                'cont_phone_number'=> $phoneNumber,
                'cont_role'=> $role,
                'cont_category'=> $category,
                'cont_is_active'=> 1,
                'cont_is_deleted'=> 0
            );
            $result = $this->contactsmodel->operations('insert',$insert_data);
            if($result){
                echo json_encode(array('result'=>1,'message'=>'Contact added successfully.'));
            }
            else{
                echo json_encode(array('result'=>0,'message'=>'Unable to add contact.'));
            }
        }
    }
}

/* End of file contacts.php */
