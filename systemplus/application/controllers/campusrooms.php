<?php
class Campusrooms extends Controller {

    public function __construct() {

    parent::Controller();
        // check user session and menus with their access.
        authSessionMenu($this);
        $this->load->helper(array('form', 'url'));
        $this->load->library('session', 'email', 'excel');
        $this->load->model("tuition/campusroomsmodel", "campusroomsmodel");
    }

    /**
    * index
    * This is default function to load campus rooms 
    * @author SK
    * @since 15-Dec-2015
    */
    function index() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
            $data["all_rooms"] = $this->campusroomsmodel->getData(0,$campusId); // $this->session->userdata('id')
            $data['title'] = "plus-ed.com | Campus rooms";
            $data['breadcrumb1'] = 'Tuition';
            $data['breadcrumb2'] = 'Campus rooms';
            
            if(APP_THEME == "OLD")
                $this->load->view('tuition/plused_campus_rooms', $data);
            else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = "Campus rooms";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/tuition/campus_rooms', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    /**
    * addedit
    * This function is used to show add / edit view for campus rooms.
    * @param int $edit_id
    * @author SK
    * @since 15-Dec-2015
    */
    function addedit($edit_id = 0){
            $this->load->library('form_validation');
            if($this->session->userdata('username') && $this->session->userdata('role')!=200 && $this->session->userdata('role')!=400){
                $formData = array(
                    'selCampus' => '',
                    'txtNumberOfRooms' => '',
                    'txtNumberOfStudents' => '',
                    'txtAllotmentFromDate' => date('Y-m-d'),
                    'txtAllotmentToDate' => date('Y-m-d')
                );
                $data['edit_id'] = $edit_id;

                if(!empty($_POST['btnSave'])){

                    $formVal = array(
                        array(
                            'field' => 'txtNumberOfRooms',
                            'label' => 'Number of rooms',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'selCampus',
                            'label' => 'Campus',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtNumberOfStudents',
                            'label' => 'Number of students / room',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtAllotmentFromDate',
                            'label' => 'From date',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtAllotmentToDate',
                            'label' => 'To date',
                            'rules' => 'required'
                        )
                    );
                    $this->form_validation->set_rules($formVal); 
                    if ($this->form_validation->run() == TRUE)
                    {
                        $edit_id = $this->input->post('edit_id');
                        $allotmentFromDate = $this->input->post('txtAllotmentFromDate');
                        $allotmentFromDate = explode('/', $allotmentFromDate);
                        if(array_key_exists(2, $allotmentFromDate));
                        $allotmentFromDate = $allotmentFromDate[2].'-'.$allotmentFromDate[1].'-'.$allotmentFromDate[0];
                        
                        $allotmentToDate = $this->input->post('txtAllotmentToDate');
                        $allotmentToDate = explode('/', $allotmentToDate);
                        if(array_key_exists(2, $allotmentToDate));
                        $allotmentToDate = $allotmentToDate[2].'-'.$allotmentToDate[1].'-'.$allotmentToDate[0];
                        
                            if($edit_id){
                                $update_data = array(
                                    'cr_number_of_rooms'=> trim($this->input->post('txtNumberOfRooms')),
                                    'cr_campus_id'=> trim($this->input->post('selCampus')),
                                    'cr_students_per_room'=> trim($this->input->post('txtNumberOfStudents')),
                                    'cr_allotment_from_date'=> $allotmentFromDate,
                                    'cr_allotment_to_date'=> $allotmentToDate
                                );
                                $result = $this->campusroomsmodel->operations('update',$update_data,$edit_id);
                                if($result){
                                    $this->session->set_flashdata('success_message','Record updated successfully.');
                                    redirect('campusrooms');
                                }
                                else{
                                    $this->session->set_flashdata('error_message','Unable to add record.');
                                }
                            }
                            else{
                                $insert_data = array(
                                    'cr_number_of_rooms'=> trim($this->input->post('txtNumberOfRooms')),
                                    'cr_campus_id'=> trim($this->input->post('selCampus')),
                                    'cr_students_per_room'=> trim($this->input->post('txtNumberOfStudents')),
                                    'cr_allotment_from_date'=> $allotmentFromDate,
                                    'cr_allotment_to_date'=> $allotmentToDate,
                                    'cr_created_by'=> $this->session->userdata('id'),
                                    'cr_is_active'=> 1,
                                    'cr_is_deleted'=> 0
                                );

                                $result = $this->campusroomsmodel->operations('insert',$insert_data);
                                if($result){
                                    $this->session->set_flashdata('success_message','Record added successfully.');
                                    redirect('campusrooms');
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
                            'txtNumberOfRooms' => trim($this->input->post('txtNumberOfRooms')),
                            'txtNumberOfStudents' => trim($this->input->post('txtNumberOfStudents')),
                            'txtAllotmentFromDate' => trim($this->input->post('txtAllotmentFromDate')),
                            'txtAllotmentToDate' => trim($this->input->post('txtAllotmentToDate'))
                        );
                    }
                }
                else
                {
                    if($edit_id){
                        // get roomsdetails for edit purpose
                        $roomDetails = $this->campusroomsmodel->getData($edit_id); // $this->session->userdata('id')

                        if($roomDetails){
                            $roomDetails = $roomDetails[0];
                            $formData = array(
                                'selCampus' => $roomDetails['cr_campus_id'],
                                'txtNumberOfRooms' => $roomDetails['cr_number_of_rooms'],
                                'txtNumberOfStudents' => $roomDetails['cr_students_per_room'],
                                'txtAllotmentFromDate' => $roomDetails['cr_allotment_from_date'],
                                'txtAllotmentToDate' => $roomDetails['cr_allotment_to_date']
                            );
                        }
                    }
                }
                $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
                $data["campusList"] = $this->campusroomsmodel->getCampusList(1,$campusId); // $this->session->userdata('id')
                $data['title']="plus-ed.com | Campus rooms";
                $data['breadcrumb1'] = 'Tuition';
                if($edit_id)
                    $data['breadcrumb2']='Edit rooms';
                else
                    $data['breadcrumb2']='Add new rooms';
                $data['formData']= $formData;
                
                if(APP_THEME == "OLD")
                    $this->load->view('tuition/plused_add_campus_rooms',$data); 
                else // if(APP_THEME == "LTE")
                {
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/tuition/campus_rooms_add', $data);
                }

            }else{
                $this->session->sess_destroy();	
                redirect('backoffice','refresh'); 
            }

    }


    /**
    * rooms_change_status
    * This function is used to toggle rooms active status.
    * @author SK
    * @since 16-Dec-2015
    */
    function rooms_change_status(){
        $roomId = $this->input->post('id');
        $roomStatus = $this->input->post('status');
        if($roomStatus == 1) // change status to update..
            $roomStatus = 0;
        else
            $roomStatus = 1;
        $udpateData = array(
            'cr_is_active' => $roomStatus
        );
        $result = $this->campusroomsmodel->operations('changestatus',$udpateData,$roomId);
        if($result){
            echo json_encode(array('result'=>1,'message'=>'Rooms status changed successfully.','status'=>$roomStatus));
        }
        else
            echo json_encode(array('result'=>0,'message'=>'Unable to change rooms status.'));

    }

    /**
    * deleteroom
    * This function is used to remove rooms form system
    * @author SK
    * @since 16-Dec-2015
    */
    function deleterooms($roomId = 0){
        $result = $this->campusroomsmodel->operations('delete',null,$roomId);
        if($result){
            $this->session->set_flashdata('success_message','Rooms deleted successfully.');
            redirect('campusrooms');
        }
        else
            $this->session->set_flashdata('error_message','Unable to delete rooms.');
            redirect('campusrooms');

    }
    
    
    function getAllCampus(){
        $result = $this->campusroomsmodel->getCampusList(0,0);
        if($result)
        {
            echo "<pre>";
            foreach($result as $row){
                $string = $this->stripJunk($row['nome_centri']);
                //$string = str_replace('-', '', strtolower($string));
                $insertArray = array(
                    'first_name' => ucwords($row['nome_centri']),
                    'last_name' => 'CD',
                    'username' => 'cd'.  $string,
                    'password' => random_string('alnum', 8),
                    'email' => 'info@studytours.it',
                    'role' => 'course_director',
                    'campusid_ref' => $row['id'],
                );
                //print_r($insertArray);
                //$this->db->insert('members',$insertArray);
            }
        }
    }
    
     function stripJunk($string){
        $string = str_replace(" ", "", trim($string));
        $string = preg_replace("/[^a-zA-Z0-9.]/", "", $string);
        $string = strtolower($string);
        return $string;
    }
    
}

/* End of file campusrooms.php */
