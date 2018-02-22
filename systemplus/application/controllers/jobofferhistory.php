<?php
/**
 * Class to control Job offer history page
 * @since 10-MAR-2016
 * @author SK
 * 
 */
class Jobofferhistory extends Controller {

    public function __construct() {
        
        parent::Controller();
        // check user session and menus with their access.
        authSessionMenu($this);
        $this->load->helper(array('url'));
        $this->load->library('session');
        $this->load->model("tuition/jobofferhistorymodel", "jobofferhistorymodel");
    }

    /**
     * function to show job history of teachers
     * @author SK
     * @since 10-Mar-2016
     */
    function index() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Job offer history";
            $data['breadcrumb1'] = 'Job & Conracts';
            $data['breadcrumb2'] = 'Job offer history';
            $data['historydetails'] = $this->jobofferhistorymodel->getJobHistoryData(date('Y'));
            $data['positiondetails'] = $this->jobofferhistorymodel->getPositionData();
            
            if(APP_THEME == "OLD")
                $this->load->view('tuition/plused_job_offer_history', $data);
            else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/contract/job_offer_history', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * function for advanced search in Job offer history
     * @author SK
     * @since 10-Mar-2016
     */
    function searchAjax() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $txtName = $this->input->post('txtName');
            $position = $this->input->post('position');
            $sex = $this->input->post('sex');
            $currency = $this->input->post('currency');
            $type = $this->input->post('type');
            $rate = $this->input->post('rate');
            $txtCalFromDate = $this->input->post('txtCalFromDate');
            $txtCalToDate = $this->input->post('txtCalToDate');

            if (!empty($txtCalFromDate) && !empty($txtCalToDate)) {
                $txtCalFromDate = explode('/', $txtCalFromDate);
                $txtCalToDate = explode('/', $txtCalToDate);

                if (array_key_exists(2, $txtCalFromDate)) {
                    $txtCalFromDate = $txtCalFromDate[2] . '-' . $txtCalFromDate[1] . '-' . $txtCalFromDate[0];
                }
                if (array_key_exists(2, $txtCalToDate)) {
                    $txtCalToDate = $txtCalToDate[2] . '-' . $txtCalToDate[1] . '-' . $txtCalToDate[0];
                }
            }
            $history_app = $this->jobofferhistorymodel->getJobofferHistoryData($txtName, $position, $sex, $currency, $type, $rate, $txtCalFromDate, $txtCalToDate);
            $returnData = array();
            if ($history_app) {
                $reviewActions = "";
                foreach ($history_app as $history) {
                    $reviewActions = '<a title="View" href="javascript:void(0);" data-id="dialog_modal_btn_' . $history['jof_id'] . '" class="dialogbtn">
                                           <span class="icon-eye-open"></span>
                                     </a>
                                     <a title="Add to contract" href="'.base_url().'index.php/contract/addedit/contract/'.$history["jof_teacher_app_id"].' data-id="'.$history['jof_teacher_app_id'].'" >
                                           <span class="icon-copy"> Contract</span>
                                     </a>';
                    $reviewActions = "<a title='' data-toggle='tooltip' href='javascript:void(0);' data-ta-id='".$history["jof_teacher_app_id"]."' data-track-id='".$history['jof_id']."' data-id='dialog_modal_btn_".$history['jof_id']."' class='getappdetail dialogbtn btn btn-xs btn-primary' data-original-title='View' data-container='body'>
                                        <i class='fa fa-eye'></i>
                                    </a>
                                    <a title='' data-toggle='tooltip' href='".base_url()."index.php/contract/addedit/contract/".$history["jof_teacher_app_id"]."' data-id='".$history["jof_teacher_app_id"]."' class='btn btn-xs btn-warning' data-original-title='Add to contract'>
                                        <i class='fa fa-copy'> Contract</i>
                                    </a>
                                ";
                    $modalData = array(
                        'value' => $history
                    );
                    $modalHtml = $this->load->view("lte/backoffice/contract/ajax_job_offer_view_modal",$modalData,true);
                    array_push($returnData, array(
                        html_entity_decode($history["ta_firstname"] . ' ' . $history["ta_lastname"]) . $modalHtml,
                        $history["pos_position"],
                        $history["jof_teacher_type"],
                        $history['job_offer_file'] ? '<span class="hlt-link"><a target="_blank" href="' . base_url() . SENT_JOB_OFFER_PATH . $history['job_offer_file'] . '">' . $history['job_offer_file'] . '</a><span>' : '',
                        date('d/m/Y', strtotime($history["jof_created_on"])),
                        $reviewActions
                    ));
                }
            }
            echo json_encode($returnData);
        }

        else
            echo "User session expired.";
    }
    
    function exporthistory() 
    {
        if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
                $txtName = $this -> input -> post('txtName');
                $position = $this -> input -> post('selPosition');
                $sex = $this -> input -> post('selSex');
                $currency = $this -> input -> post('selCurrency');
                $type = $this -> input -> post('selType');
                $rate = $this -> input -> post('selRate');
                $txtCalFromDate = $this -> input -> post('fd');
                $txtCalToDate = $this -> input -> post('td');
                if (!empty($txtCalFromDate) && !empty($txtCalToDate)) {
                        $txtCalFromDate = explode('/', $txtCalFromDate);
                        $txtCalToDate = explode('/', $txtCalToDate);

                        if (array_key_exists(2, $txtCalFromDate)) {
                                $txtCalFromDate = $txtCalFromDate[2] . '-' . $txtCalFromDate[1] . '-' . $txtCalFromDate[0];
                        }
                        if (array_key_exists(2, $txtCalToDate)) {
                                $txtCalToDate = $txtCalToDate[2] . '-' . $txtCalToDate[1] . '-' . $txtCalToDate[0];
                        }
                }
                $history_app = $this -> jobofferhistorymodel -> getJobofferHistoryData($txtName, $position, $sex, $currency, $type, $rate, $txtCalFromDate, $txtCalToDate);
                $exportData = array();
                if ($history_app) {
                        foreach ($history_app as $history) {
                                $exportRecord = array(
                                        'First name' => $history['ta_firstname'],
                                        'Last name' => $history['ta_lastname'],
                                        'Position' => $history['pos_position'],
                                        'Residential' => $history['jof_residential'],
                                        'Type' => $history['jof_teacher_type'],
                                        'Currency' => $history['jof_currency'],
                                        'Rate' => $history['jof_rates'],
                                        'Wage' => $history['jof_wages'],
                                        'Offer Date' => date('d/m/Y', strtotime($history["jof_created_on"]))
                                );
                                array_push($exportData, $exportRecord);
                        }
                        $this -> load -> library('export');
                        $this -> export -> to_excel($exportData, 'teacher_job_history');
                }
                else {
                        $this -> session -> set_flashdata('success_message', 'No records to export.');
                        redirect('jobofferhistory', 'refresh');
                }
        }
        else {
                $this -> session -> sess_destroy();
                redirect('backoffice', 'refresh');
        }
    }

}