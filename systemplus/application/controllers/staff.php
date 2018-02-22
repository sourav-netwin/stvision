<?php
/**
 * Description of staff
 *
 * @author Sandip.Kalbhile
 */
class Staff extends Controller {

    public function __construct() {
        parent::Controller();
        // check user session and menus with their access.
        authSessionMenu($this);
        $this->load->helper(array('form', 'url','mpdf6'));
        $this->load->library('session', 'email', 'excel');
        $this->load->model("tuition/contractmodel", "contractmodel");
        $this->load->model("tuition/teachersmodel", "teachersmodel");
    }
    
    function index(){
        redirect('staff/priority');
    }
    
    function priority(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Staff priority";
            $data['breadcrumb1'] = 'Tuition';
            $data['breadcrumb2'] = 'Staff priority';
            $data['fromDate'] = date("d/m/Y",strtotime('first day of this month'));
            $data['toDate'] = date("d/m/Y",strtotime('last day of this month'));
            $fromDate = $data['fromDate'];
            $toDate = $data['toDate'];
            if(!empty($fromDate) & !empty($toDate))
            {
                $fromDate = explode('/', $fromDate);
                $toDate = explode('/', $toDate);
                if(array_key_exists(2, $fromDate));
                $fromDate = $fromDate[2].'-'.$fromDate[1].'-'.$fromDate[0];
                if(array_key_exists(2, $toDate));
                $toDate = $toDate[2].'-'.$toDate[1].'-'.$toDate[0];
            }
            $data['contractdata'] = $this->contractmodel->getContractDataForPriority(0,0,$fromDate,$toDate);
            $data['positions'] = $this->contractmodel->getPositionData();
            $data['campuses'] = $this->contractmodel->getCampusData();
            
            if(APP_THEME == "OLD")
                $this->load->view('tuition/plused_staff_priority', $data);
            else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/tuition/staff_priority', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    function changepriority(){
        $result = 0;
        $cont_id = $this->input->post('con_id');
        $priority = $this->input->post('priority');
        if(is_numeric($priority) && $cont_id > 0)
        {
            $updateArray = array(
                'joc_staff_priority' => $priority
            );
            $result = $this->contractmodel->operations('update',$updateArray,$cont_id);
        }
        if($result){
            echo json_encode(array('result'=>1,'priority updated successfully'));
        }
        else {
            echo json_encode(array('result'=>0,'unable to update priority'));
        }
    }
    
    function contract_ajax(){
        $campusId = $this->input->post('campus');
        $positionId = $this->input->post('position');
        $fromDate = $this->input->post('fromDate');
        $toDate = $this->input->post('toDate');
        if(!empty($fromDate) & !empty($toDate))
        {
            $fromDate = explode('/', $fromDate);
            $toDate = explode('/', $toDate);
            if(array_key_exists(2, $fromDate));
            $fromDate = $fromDate[2].'-'.$fromDate[1].'-'.$fromDate[0];
            if(array_key_exists(2, $toDate));
            $toDate = $toDate[2].'-'.$toDate[1].'-'.$toDate[0];
        }
        $contractdata = $this->contractmodel->getContractDataForPriority($campusId,$positionId,$fromDate,$toDate);
        $resultArray = array();
        if(!empty($contractdata)){
            foreach($contractdata as $contract){
                $row = array(
                    $contract['nome_centri'],
                    $contract['pos_position'],
                    $contract['ta_firstname'] . ' ' . $contract['ta_lastname'],
                    $contract["joc_email"],
                    date('d/m/Y', strtotime($contract["joc_from_date"])),
                    date('d/m/Y', strtotime($contract["joc_to_date"])),
                    "<td class='center operation'>
                        <input type='text' data-id='".$contract["joc_id"]."' autocomplete='off' onkeypress='return keyRestrict(event,\"1234567890\");' class='priorityText form-control' value='". $contract['joc_staff_priority']."' maxleght='5' />
                    </td>"
                );
                array_push($resultArray, $row);
            }
        }
        echo json_encode($resultArray);
    }
    
}
