<?php
class Accountmanager extends Controller {

    public function __construct() {

    parent::Controller();
        // check user session and menus with their access.
        authSessionMenu($this);
        $this->load->helper(array('form', 'url'));
        $this->load->library('session', 'email', 'excel');
        $this->load->model("agents/accountmanagermodel", "accountmanagermodel");
    }

    /**
    * index
    * This is default function to load Accountmanager 
    * @author SK
    * @since 15-Dec-2015
    */
    function index() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data["all_accountmanager"] = $this->accountmanagermodel->getData(0);
            $data['title'] = "plus-ed.com | Account manager";
            $data['breadcrumb1'] = 'Account manager';
            $data['breadcrumb2'] = 'Manage account manager';
            
            $data['pageHeader'] = "Manage account manager";
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/agents/account_manager/manage_accountmanager', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    /**
    * addedit
    * This function is used to show add / edit view for Accountmanager.
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
                    'txtPosition' => ''
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
                            'field' => 'txtPosition',
                            'label' => 'Position',
                            'rules' => 'required'
                        )
                    );
                    if(!$edit_id){
                        $childRule = array(
                            'field' => 'txtPassword',
                            'label' => 'Password',
                            'rules' => 'required'
                        );
                        array_push($formVal, $childRule);
                    }
                    $this->form_validation->set_rules($formVal); 
                    if ($this->form_validation->run() == TRUE)
                    {
                        $edit_id = $this->input->post('edit_id');
                        if($edit_id){
                            $update_data = array(
                                'firstname'=> trim($this->input->post('txtFirstname')),
                                'familyname'=> trim($this->input->post('txtLastname')),
                                'email'=> trim($this->input->post('txtEmail')),
                                'position'=> trim($this->input->post('txtPosition'))
                            );
                            $pwd = $this->input->post('txtPassword');
                            if(!empty($pwd))
                                $update_data['pwd'] = $pwd;
                            $result = $this->accountmanagermodel->operations('update',$update_data,$edit_id);
                            if($result){
                                $this->session->set_flashdata('success_message','Record updated successfully.');
                                redirect('accountmanager');
                            }
                            else{
                                $this->session->set_flashdata('error_message','Unable to add record.');
                            }
                        }
                        else{
                            $insert_data = array(
                                'firstname'=> trim($this->input->post('txtFirstname')),
                                'familyname'=> trim($this->input->post('txtLastname')),
                                'email'=> trim($this->input->post('txtEmail')),
                                'position'=> trim($this->input->post('txtPosition')),
                                'pwd'=> trim($this->input->post('txtPassword')),
                                'is_active'=> 1,
                                'is_deleted'=> 0
                            );

                            $result = $this->accountmanagermodel->operations('insert',$insert_data);
                            if($result){
                                $this->session->set_flashdata('success_message','Record added successfully.');
                                redirect('accountmanager');
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
                            'txtPosition' => trim($this->input->post('txtPosition'))
                        );
                    }
                }
                else
                {
                    if($edit_id){
                        // get accdetails for edit purpose
                        $accDetails = $this->accountmanagermodel->getData($edit_id);

                        if($accDetails){
                            $accDetails = $accDetails[0];
                            $formData = array(
                                'txtFirstname' => $accDetails['firstname'],
                                'txtLastname' => $accDetails['familyname'],
                                'txtEmail' => $accDetails['email'],
                                'txtPosition' => $accDetails['position']
                            );
                        }
                    }
                }
                $agentId = $this->session->userdata('id'); // GET THE CAMPUS ID IF AVAILABLE.
                $data['agent_id'] = $agentId;
                $data['title']="plus-ed.com | Account manager";
                $data['breadcrumb1'] = 'Account manager';
                if($edit_id)
                    $data['breadcrumb2']='Edit account manager';
                else
                    $data['breadcrumb2']='Add new account manager';
                $data['formData']= $formData;
                
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/account_manager/accountmanager_add', $data);

            }else{
                $this->session->sess_destroy();	
                redirect('backoffice','refresh'); 
            }

    }


    /**
    * acc_change_status
    * This function is used to toggle acc active status.
    * @author SK
    * @since 16-Dec-2015
    */
    function acc_change_status(){
        $accId = $this->input->post('id');
        $accStatus = $this->input->post('status');
        if($accStatus == 1) // change status to update..
            $accStatus = 0;
        else
            $accStatus = 1;
        $udpateData = array(
            'is_active' => $accStatus
        );
        $result = $this->accountmanagermodel->operations('changestatus',$udpateData,$accId);
        if($result){
            echo json_encode(array('result'=>1,'message'=>'Status changed successfully.','status'=>$accStatus));
        }
        else
            echo json_encode(array('result'=>0,'message'=>'Unable to change status.'));

    }
    
    function get_detail(){
        $accId = $this->input->post('edit_id');
        $accDetails = $this->accountmanagermodel->getData($accId);
        $formData = array();
        if($accDetails){
            $accDetails = $accDetails[0];
            $formData = array(
                'txtFirstname' => $accDetails['firstname'],
                'txtLastname' => $accDetails['familyname'],
                'txtEmail' => $accDetails['email'],
                'txtPosition' => $accDetails['position']
            );
        }
        echo json_encode($formData);
    }

    /**
    * deleteacc
    * This function is used to remove acc form system
    * @author SK
    * @since 16-Dec-2015
    */
    function deleteacc($accId = 0){
        $result = $this->accountmanagermodel->operations('delete',null,$accId);
        if($result){
            $this->session->set_flashdata('success_message','Record deleted successfully.');
            redirect('accountmanager');
        }
        else
            $this->session->set_flashdata('error_message','Unable to delete record.');
            redirect('accountmanager');

    }
    
    function stripJunk($string){
        $string = str_replace(" ", "", trim($string));
        $string = preg_replace("/[^a-zA-Z0-9.]/", "", $string);
        $string = strtolower($string);
        return $string;
    }
}

/* End of file accountmanager.php */