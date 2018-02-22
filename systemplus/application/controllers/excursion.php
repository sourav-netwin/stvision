<?php
/**
 * Class to manage new excursions
 * @author SK
 * @since 06-Sept-2017
 */
class Excursion extends Controller{

    public function __construct() {
        parent::Controller();
        // check user session and menus with their access.
        //authSessionMenu($this);
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'email', 'ltelayout', 'form_validation'));
        $this->load->model("agents/excursions_model", "excursions_model");
        $this->load->model("tuition/campuscoursemodel", "campuscoursemodel");
    }
    
    function index(){ 
//        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $exc_type = "excursion";
            $data["all_excursions"] = $this->excursions_model->getData(0,$exc_type);
            $data['title'] = "plus-ed.com | Manage excursion";
            $data['breadcrumb1'] = 'Manage excursion';
            $data['breadcrumb2'] = 'Excursion';
            $data['pageHeader'] = "Excursion";
            $data['optionalDescription'] = "";
            $data['exc_type'] = $exc_type;
            $this->ltelayout->view('lte/agents_new/excursion/excursions', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    function transfer(){
//        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $exc_type = "transfer";
            $data["all_excursions"] = $this->excursions_model->getData(0,$exc_type);
            $data['title'] = "plus-ed.com | Manage excursion";
            $data['breadcrumb1'] = 'Manage excursion';
            $data['breadcrumb2'] = 'Transfer';
            $data['pageHeader'] = "Transfer";
            $data['optionalDescription'] = "";
            $data['exc_type'] = $exc_type;
            $this->ltelayout->view('lte/agents_new/excursion/excursions', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
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
    function stripJunk($string) {
        $string = str_replace(" ", "-", trim($string));
        $string = preg_replace("/[^a-zA-Z0-9-.]/", "", $string);
        $string = strtolower($string);
        return $string;
    }
    
    /**
    * addedit
    * This function is used to show add / edit view for excursion.
    * @param int $edit_id
    * @author SK
    * @since 15-Dec-2015
    */
    function addedit($exc_type = 'excursion', $edit_id = 0){
            $this->load->library('form_validation');
//            if($this->session->userdata('username') && $this->session->userdata('role')!=200 && $this->session->userdata('role')!=400){
            if ($this->session->userdata('role')) {
            authSessionMenu($this); 
                $formData = array(
                    'txtExcursion' => '',
                    'txtDescription' => '',
                    'txtDays' => '',
                    'txtAirport' => '',
                    'txtDayType' => '',
                    'selCampus' => array(),
                    'imageFile' => ''
                );
                $data['edit_id'] = $edit_id;
                $data['oldCampusId'] = 0;

                if(!empty($_POST['btnSave'])){

                    $formVal = array(
                        array(
                            'field' => 'txtExcursion',
                            'label' => 'Excursion name',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtDescription',
                            'label' => 'Brief description',
                            'rules' => 'required'
                        )/*,
                        array(
                            'field' => 'txtDays',
                            'label' => 'Number of days',
                            'rules' => 'required'
                        ),
                        array(
                            'field' => 'txtAirport',
                            'label' => 'Airport',
                            'rules' => 'required'
                        )*/
                    );
                    $this->form_validation->set_rules($formVal); 
                    if ($this->form_validation->run() == TRUE)
                    {
                        $this->load->library('upload');
                        $edit_id = $this->input->post('edit_id');
                        $campus_id = $this->input->post('selCampus');
                        $exc_type = $this->input->post('exc_type');
                        
                        $excursion = $this->input->post('txtExcursion');
                        $description = $this->input->post('txtDescription');
                        $numberOfDays = $this->input->post('txtDays');
                        $airport = $this->input->post('txtAirport');
                        $dayType = $this->input->post('txtDayType');
                        
                        if (!file_exists(EXCURSION_IMAGE_PATH)) {
                            mkdir(EXCURSION_IMAGE_PATH, 0755, true);
                        }

                        $fileName = "";
                        $uploadFileError = array();
                            if ($_FILES['fileImage']['name']) {
                                $file_name = time() . '_' . $this->stripJunk($_FILES['fileImage']['name']);
                                $config['upload_path'] = EXCURSION_IMAGE_PATH;
                                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                                $config['file_name'] = $file_name;
                                $this->upload->initialize($config);

                                //---- UPLOAD IMAGE ----//
                                if ($this->upload->do_upload("fileImage")) {
                                    $aUploadData = $this->upload->data();
                                    $fileName = $aUploadData['file_name'];
                                } else {
                                    $uploadFileError = array('error' => $this->upload->display_errors());
                                }
                            }
                        if(!array_key_exists("error", $uploadFileError)){
                            if($edit_id){
                                $update_data = array(
                                    'exc_excursion_name'=> $excursion,
                                    'exc_brief_description'=> $description,
                                    'exc_day_type'=> $dayType
                                );
                                
                                if($exc_type == 'transfer')
                                {
                                    $update_data['exc_days'] = $numberOfDays;
                                    $update_data['exc_airport'] = $airport;
                                }
                                if(!empty($fileName))
                                    $update_data['exc_image'] = $fileName;
                                
                                $result = $this->excursions_model->operations('update',$update_data,$edit_id);
                                if($result){
                                    // update the mapping record in agnt_campus_excursion
                                    $campusMap = $this->excursions_model->mapCampus($campus_id,$result);
                                    $this->session->set_flashdata('success_message','Record updated successfully.');
                                    if($exc_type == 'transfer')
                                        redirect('excursion/'.$exc_type);
                                    else
                                        redirect('excursion');
                                }
                                else{
                                    $this->session->set_flashdata('error_message','Unable to add record.');
                                }
                            }
                            else{
                                $insert_data = array(
                                    'exc_excursion_name'=> $excursion,
                                    'exc_brief_description'=> $description,
                                    'exc_type'=> $exc_type,
                                    'exc_day_type'=> $dayType,
                                    'exc_created_by'=> $this->session->userdata('id'),
                                    'exc_is_active'=> 1,
                                    'exc_is_deleted'=> 0
                                );
                                if($exc_type == 'transfer')
                                {
                                    $update_data['exc_days'] = $numberOfDays;
                                    $update_data['exc_airport'] = $airport;
                                }
                                if(!empty($fileName))
                                    $update_data['exc_image'] = $fileName;

                                $result = $this->excursions_model->operations('insert',$insert_data);
                                if($result){
                                    // update the mapping record in agnt_campus_excursion
                                    $campusMap = $this->excursions_model->mapCampus($campus_id,$result);
                                    $this->session->set_flashdata('success_message','Record added successfully.');
                                    if($exc_type == 'transfer')
                                        redirect('excursion/'.$exc_type);
                                    else
                                        redirect('excursion');
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
                                'txtExcursion' => trim($this->input->post('txtExcursion')),
                                'txtDescription' => trim($this->input->post('txtDescription')),
                                'txtDays' => trim($this->input->post('txtDays')),
                                'txtDayType' => trim($this->input->post('txtDayType')),
                                'txtAirport' => trim($this->input->post('txtAirport')),
                                'error_message' => $uploadFileError['error']
                            );
                        }
                        
                    }
                    else
                    {
                        $formData = array(
                            'selCampus' => trim($this->input->post('selCampus')),
                            'txtExcursion' => trim($this->input->post('txtExcursion')),
                            'txtDescription' => trim($this->input->post('txtDescription')),
                            'txtDays' => trim($this->input->post('txtDays')),
                            'txtDayType' => trim($this->input->post('txtDayType')),
                            'txtAirport' => trim($this->input->post('txtAirport'))
                        );
                    }
                }
                else
                {
                    if($edit_id){
                        // get excursionsdetails for edit purpose
                        $excursionDetails = $this->excursions_model->getData($edit_id,$exc_type);
                        $existingCampusIds = $this->excursions_model->getExcursionCampusId($edit_id);
                        $selCampusIds = array();
                        if($existingCampusIds){
                            foreach($existingCampusIds as $dbCampusId){
                                $selCampusIds[] = $dbCampusId['excm_campus_id'];
                            }
                        }
                        if($excursionDetails){
                            $excursionDetails = $excursionDetails[0];
                            $formData = array(
                                'selCampus' => $selCampusIds,
                                'txtExcursion' => $excursionDetails['exc_excursion_name'],
                                'txtDescription' => $excursionDetails['exc_brief_description'],
                                'txtDays' => $excursionDetails['exc_days'],
                                'txtAirport' => $excursionDetails['exc_airport'],
                                'exc_type' => $excursionDetails['exc_type'],
                                'txtDayType' => $excursionDetails['exc_day_type'],
                                'imageFile' => $excursionDetails['exc_image'],
                            );
                        }
                    }
                }
                
                if($exc_type == 'transfer'){
                    $data['title']="plus-ed.com | Manage excursion";
                    $data['breadcrumb1'] = 'Manage excursion';
                    if($edit_id)
                        $data['breadcrumb2']='Edit transfer';
                    else
                        $data['breadcrumb2']='Add new transfer';
                    $data['formData']= $formData;

                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                }
                else
                {
                    $data['title']="plus-ed.com | Manage excursion";
                    $data['breadcrumb1'] = 'Manage excursion';
                    if($edit_id)
                        $data['breadcrumb2']='Edit excursion';
                    else
                        $data['breadcrumb2']='Add new excursion';
                    $data['formData']= $formData;

                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                }
                //$data[''] = ;
                $data['exc_type'] = $exc_type;
                $data["campusList"] = $this->campuscoursemodel->getCampusList(1);
                $this->ltelayout->view('lte/agents_new/excursion/add_edit_excursion', $data);
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
    function change_status(){
        $excursionId = $this->input->post('id');
        $excursionStatus = $this->input->post('status');
        if($excursionStatus == 1) // change status to update..
            $excursionStatus = 0;
        else
            $excursionStatus = 1;
        $udpateData = array(
            'exc_is_active' => $excursionStatus
        );
        $result = $this->excursions_model->operations('changestatus',$udpateData,$excursionId);
        if($result){
            echo json_encode(array('result'=>1,'message'=>'Excursion status changed successfully.','status'=>$excursionStatus));
        }
        else
            echo json_encode(array('result'=>0,'message'=>'Unable to change excursion status.'));

    }

    /**
    * deleteexcursion
    * This function is used to remove excursions form system
    * @author SK
    * @since 16-Dec-2015
    */
    function deleteexcursions($excursionId = 0,$exc_type){
        $result = $this->excursions_model->operations('delete',null,$excursionId);
        if($result){
            $this->session->set_flashdata('success_message','Rooms deleted successfully.');
        }
        else
            $this->session->set_flashdata('error_message','Unable to delete excursions.');
        if($exc_type == 'transfer')
                redirect('excursion/'.$exc_type);
            else
                redirect('excursion');

    }
    
    /**
     * mapcampus
     * this function is used to load campus mapping form
     * here user can map campuses and excursions/transfers 
     * @param type $excType
     * @param type $campusId 
     */
    function mapcampus($excType = 'exc', $campusId = 0){
//        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) 
//        {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data = array();
            $excursionType = "excursion";
            if($excType == "tra")
                $excursionType = "transfer";
            
            $formData = array(
                    'selCampus' => '',
                    'selExcursion' => array()
            );
            if (isset($_POST['btnMap'])) {
                    $formVal = array(
                            array(
                                    'field' => 'selCampus',
                                    'label' => 'Campus',
                                    'rules' => 'numeric|required'
                            ),
                            array(
                                    'field' => 'selExcursion',
                                    'label' => ucfirst($excursionType),
                                    'rules' => 'required'
                            )
                    );
                    $this -> form_validation -> set_rules($formVal);
                    if ($this -> form_validation -> run() == TRUE) {
                            $campusId = $this -> input -> post('selCampus');
                            $excTraIds = $this -> input -> post('selExcursion');
                            $isInsertUpdate = $this -> excursions_model -> insertUpdate($campusId, $excTraIds,$excursionType);
                            if ($isInsertUpdate) {
                                    $this -> session -> set_flashdata('success_message', 'Mapped successfully');
                                    redirect('excursion/mapcampus/'.$excType);
                                    exit(0);
                            }
                            else {
                                    $this -> session -> set_flashdata('error_message', 'Failed to map');
                                    redirect('excursion/mapcampus/'.$excType);
                                    exit(0);
                            }
                    }
            }
            
            $data["all_campuses"] = $this->excursions_model->getDataCampuses($excursionType);
            $data["all_exc_or_transfer"] = $this->excursions_model->getAllExcursion($excursionType);
            $data['title'] = "plus-ed.com | Manage excursion";
            $data['breadcrumb1'] = 'Manage excursion';
            $data['breadcrumb2'] = 'Map campus';
            $data['pageHeader'] = "Map campus";
            $data['optionalDescription'] = "";
            $data['campuses'] = $this -> excursions_model -> getCampusData();
            $mapExcursions = $this->excursions_model->getMappedExcursions($excursionType,$campusId);
            $mapExcursionsIds = array();
            if($mapExcursions){
                $mapExcursionsIds = $mapExcursions[0]['excm_exc_id'];
                if(strlen($mapExcursionsIds))
                    $mapExcursionsIds = explode (',', $mapExcursionsIds);
            }
            $data['mapExcursionsIds'] = $mapExcursionsIds;
            $data['edit_id'] = 0;
            $formData['selCampus'] = $campusId; 
            $data['formData'] = $formData; 
            $data['excType'] = $excType; 
            $this->ltelayout->view('lte/agents_new/excursion/mapcampus', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

}
/* End of file Excursion.php */