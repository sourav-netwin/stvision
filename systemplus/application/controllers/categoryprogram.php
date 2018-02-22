<?php
class Categoryprogram extends Controller {

    public function __construct() {
        parent::Controller();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session', 'email', 'excel');
        $this->load->model("agents/categoryprogrammodel", "categoryprogrammodel");
    }

    /**
    * index
    * This is default function to load Category program 
    * @author SK
    * @since 15-Dec-2015
    */
    function index() {
        // check user session and menus with their access.
        authSessionMenu($this);
        if ($this->session->userdata('username')) {
            $data["all_categoryprogram"] = $this->categoryprogrammodel->getData();
            $data['title'] = "plus-ed.com | Category program";
            $data['breadcrumb1'] = 'Packages';
            $data['breadcrumb2'] = 'Category program';
            
            $data['pageHeader'] = "Category program";
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/agents_new/category_program', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    /**
    * addedit
    * This function is used to show add / edit view for Category program.
    * @param int $edit_id
    * @author SK
    * @since 10-Nov-2017
    */
    function addedit($edit_id = 0){
        // check user session and menus with their access.
        authSessionMenu($this);
            $this->load->library('form_validation');
            $errorMessage = "";
            if($this->session->userdata('username')){
                $formData = array(
                    'txtName' => '',
                    'txtBriefDescription' => '',
                    'txtExtDescription' => '',
                    'imageFile' => ''
                );
                $data['edit_id'] = $edit_id;

                if(!empty($_POST['btnSave'])){

                    $formVal = array(
                        array(
                            'field' => 'txtBriefDescription',
                            'label' => 'Brief description',
                            'rules' => 'required|trim|xss_clean'
                        ),
                        array(
                            'field' => 'txtName',
                            'label' => 'Campus',
                            'rules' => 'required|trim|xss_clean'
                        ),
                        array(
                            'field' => 'txtExtDescription',
                            'label' => 'Extended description',
                            'rules' => 'required|trim|xss_clean'
                        )
                    );
                    $this->form_validation->set_rules($formVal); 
                    if ($this->form_validation->run() == TRUE)
                    {
                        $edit_id = $this->input->post('edit_id',true);
                        
                        if (!file_exists(CATEGORY_PROGRAM_IMAGE_PATH)) {
                            mkdir(CATEGORY_PROGRAM_IMAGE_PATH, 0755, true);
                        }
                        $fileName = "";
                        $uploadFileError = array();
                            if ($_FILES['imageFile']['name']) {
                                $this->load->library("upload");
                                $file_name = time() . '_' . $this->stripJunk($_FILES['imageFile']['name']);
                                $config['upload_path'] = CATEGORY_PROGRAM_IMAGE_PATH;
                                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                                $config['file_name'] = $file_name;
                                $this->upload->initialize($config);

                                //---- UPLOAD IMAGE ----//
                                if ($this->upload->do_upload("imageFile")) {
                                    $aUploadData = $this->upload->data();
                                    $fileName = $aUploadData['file_name'];
                                } else {
                                    $uploadFileError = array('error' => $this->upload->display_errors());
                                }
                            }
                            if(!array_key_exists('error', $uploadFileError)){
                                if($edit_id){
                                    $update_data = array(
                                        'procat_name'=> trim($this->input->post('txtName')),
                                        'procat_brief_description'=> trim($this->input->post('txtBriefDescription')),
                                        'procat_extended_description'=> trim($this->input->post('txtExtDescription'))
                                    );
                                    if(!empty($fileName))
                                        $update_data['procat_main_image'] = $fileName;

                                    $result = $this->categoryprogrammodel->operations('update',$update_data,$edit_id);
                                    if($result){
                                        $this->session->set_flashdata('success_message','Record updated successfully.');
                                        if(!empty($fileName))
                                        {
                                            $this->_handleCropping($fileName);
                                        }   
                                        else
                                            redirect('categoryprogram');
                                    }
                                    else{
                                        $this->session->set_flashdata('error_message','Unable to add record.');
                                    }
                                }
                                else{
                                    $insert_data = array(
                                        'procat_name'=> trim($this->input->post('txtName')),
                                        'procat_brief_description'=> trim($this->input->post('txtBriefDescription')),
                                        'procat_extended_description'=> trim($this->input->post('txtExtDescription')),
                                        'procat_is_active'=> 1,
                                        'procat_is_deleted'=> 0
                                    );
                                    if(!empty($fileName))
                                        $insert_data['procat_main_image'] = $fileName;

                                    $result = $this->categoryprogrammodel->operations('insert',$insert_data);
                                    if($result){
                                        $this->session->set_flashdata('success_message','Record added successfully.');
                                        if(!empty($fileName))
                                        {
                                            $this->_handleCropping($fileName);
                                        }   
                                        else
                                            redirect('categoryprogram');
                                    }
                                    else{
                                        $this->session->set_flashdata('error_message','Unable to add record.');
                                    }
                                }
                            }
                            else
                            {
                                $errorMessage = $uploadFileError['error'];
                            }
                            
                    }
                    else
                    {
                        $formData = array(
                            'txtName' => trim($this->input->post('txtName')),
                            'txtBriefDescription' => trim($this->input->post('txtBriefDescription')),
                            'txtExtDescription' => trim($this->input->post('txtExtDescription')),
                        );
                    }
                }
                else
                {
                    if($edit_id){
                        // get detail for edit purpose
                        $categoryProgramDetails = $this->categoryprogrammodel->getData($edit_id); // $this->session->userdata('id')

                        if($categoryProgramDetails){
                            $categoryProDetails = $categoryProgramDetails[0];
                            $formData = array(
                                'txtName' => $categoryProDetails['procat_name'],
                                'txtBriefDescription' => $categoryProDetails['procat_brief_description'],
                                'txtExtDescription' => $categoryProDetails['procat_extended_description'],
                                'imageFile' => $categoryProDetails['procat_main_image'],
                            );
                        }
                    }
                }
                $data['title']="plus-ed.com | Category program";
                $data['breadcrumb1'] = 'Packages';
                if($edit_id)
                    $data['breadcrumb2']='Edit category program';
                else
                    $data['breadcrumb2']='Add new category program';
                $data['formData']= $formData;
                $data['errorMessage'] = $errorMessage;
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents_new/category_program_add', $data);

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
    function stripJunk($string) {
        $string = str_replace(" ", "-", trim($string));
        $string = preg_replace("/[^a-zA-Z0-9-.]/", "", $string);
        $string = strtolower($string);
        return $string;
    }
    
    /**
     * This funtion handles the cropping request for the image.
     * @param type $fileName 
     */
    public function _handleCropping($fileName){
        $oldImage = $this->input->post("oldImage");
        if(!empty($oldImage))
        {
            @unlink(CATEGORY_PROGRAM_IMAGE_PATH . $oldImage);
            $thumbnailImage = getThumbnailName($oldImage);
            if(!empty($thumbnailImage))
                @unlink(CATEGORY_PROGRAM_IMAGE_PATH . $thumbnailImage);
        }
        $this->cropInit($fileName);
        $this->cropping->image();
        exit();
    }
    
    /**
     * Process
     * This function is required to hold cropping form action
     * @param type $action 
     */
    public function process($action = "") 
    {
        $this->cropInit();
        $this->cropping->process($action);
    }

    /**
     * cropInit
     * This function initialise the cropping library with 
     * configuration parameters
     * @param type $file_name 
     */
    public function cropInit($file_name = "")
    {
        $param = array();
        if(empty($file_name))
        {
            $param = $this->session->userdata("cropData");
        }
        else{
            $param = array(
                'imageAbsPath' =>  FCPATH . CATEGORY_PROGRAM_IMAGE_PATH,
                'imageDestPath' =>  FCPATH . CATEGORY_PROGRAM_IMAGE_PATH,
                'imageName' => $file_name,
                'imageNewName' => $file_name,
                'imagePath' =>  base_url() . CATEGORY_PROGRAM_IMAGE_PATH,
                'imageWidth' => CATEGORY_PROGRAM_WIDTH,
                'imageHeight' => CATEGORY_PROGRAM_HEIGHT,
                'thumbWidth' => CATEGORY_PROGRAM_THUMB_WIDTH,
                'thumbHeight' => CATEGORY_PROGRAM_THUMB_HEIGHT,
                'redirectTo' => 'categoryprogram',
                'formCallbackAction' => 'categoryprogram/process'
            );
            $this->session->set_userdata("cropData",$param);
        }
        $this->load->library("cropping", $param);
    }


    /**
    * categoryprogram_change_status
    * This function is used to toggle categoryprogram active status.
    * @author SK
    * @since 11-Nov-2017
    */
    function catpro_change_status(){
        $catProId = $this->input->post('id');
        $catProStatus = $this->input->post('status');
        if($catProStatus == 1) // change status to update..
            $catProStatus = 0;
        else
            $catProStatus = 1;
        $udpateData = array(
            'procat_is_active' => $catProStatus
        );
        $result = $this->categoryprogrammodel->operations('changestatus',$udpateData,$catProId);
        if($result){
            echo json_encode(array('result'=>1,'message'=>'Category program status changed successfully.','status'=>$catProStatus));
        }
        else
            echo json_encode(array('result'=>0,'message'=>'Unable to change category program status.'));

    }

    /**
    * deleteroom
    * This function is used to remove categoryprogram form system
    * @author SK
    * @since 11-Nov-2017
    */
    function deleteaction($roomId = 0){
        if($this->session->userdata('username')){
            $result = $this->categoryprogrammodel->operations('delete',null,$roomId);
            if($result){
                $this->session->set_flashdata('success_message','Category program deleted successfully.');
                redirect('categoryprogram');
            }
            else
                $this->session->set_flashdata('error_message','Unable to delete category program.');
                redirect('categoryprogram');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
}

/* End of file categoryprogram.php */
