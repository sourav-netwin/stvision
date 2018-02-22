<?php

class Manageagents extends Controller {

    public function __construct() {
        parent::Controller();

        $this->load->helper(array('form', 'url'));
        $this->load->helper('csv');
        $this->load->model('mbackoffice');
        $this->load->model('magenti');
        $this->load->library(array('session', 'email', 'ltelayout'));
    }

    public function index() {
        if ($this->session->userdata('role') == 100) {
            $data['title'] = 'plus-ed.com | Agent list';
            $data['breadcrumb1'] = 'Agent management';
            $data['breadcrumb2'] = 'Agents list';
            $data['pageHeader'] = "Agents list";

            $data['countries'] = $this->magenti->getAgentCountryList();
            $data['agentName'] = '';
            $data['accountmanagername'] = '';
            $data['selCountry'] = array();
            $this->ltelayout->view('lte/backoffice/agents/agent_list', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    public function getAgents() {
        $request = $_REQUEST;
        $searchData = array(
            'agentName' => $request['agentname'],
            'accountManager' => $request['accountmanagername'],
            'selCountry' => $request['selCountry'],
            'search' => $request['search']['value'],
        );
        $param = datatable_param($request, 'agentname', 'asc');
        $reportData = $this->magenti->paginateAgentData($searchData, $param);
        $reportCount = $this->magenti->getAgentCount($searchData);
        if (empty($reportData)) {
            $reportData = array();
        } else {
            $reportData = $this->makeData($reportData);
        }
        echo datatable_json($request['draw'], $reportCount, $reportData);
        exit(0);
    }

    private function makeData($agentData) {
        if (empty($agentData)) {
            return array();
        }
        foreach ($agentData as $key => $agent) {
            $agentData[$key]['action'] = '<a href="javascript:void(0);" data-id="' . $agent['id'] . '" class="min-wd-24 dialogbtn btn btn-xs btn-primary view_agent" ><span data-original-title="View" data-container="body" data-toggle="tooltip"><i class="fa fa-eye"></i></span></a>
                                        <a href="' . base_url() . 'index.php/manageagents/addeditAgents/' . $agent['id'] . '" class="min-wd-24 dialogbtn btn btn-xs btn-info" ><span data-original-title="Edit" data-container="body" data-toggle="tooltip"><i class="fa fa-edit"></i></span></a>';
        }
        return $agentData;
    }

    public function getAgent() {
        $agentId = $this->input->post('id');
        if (empty($agentId)) {
            echo json_encode(array('error' => true, 'message' => 'Invalid Request'));
            exit(0);
        }
        $agent = $this->magenti->getAgentInfo($agentId);
        echo json_encode(array('success' => true, 'agent' => $agent));
        exit(0);
    }

    function getAgentNameAutoComplete() {
        if ($this->session->userdata('role') == 100) {
            $name = $this->input->post('name');
            $agentNames = $this->magenti->getAgentNameAutoComplete($name);
            echo $agentNames;
        } else {
            die("ERROR");
        }
    }

    function getAccountManagerNameAutoComplete() {
        if ($this->session->userdata('role') == 100) {
            $name = $this->input->post('name');
            $accuntManagerNames = $this->magenti->getAccountManagerNameAutoComplete($name);
            echo $accuntManagerNames;
        } else {
            die("ERROR");
        }
    }

    public function addeditAgents($edit_id = 0) {
        $data = array();
        $data['edit_id'] = $edit_id;
        $data['title'] = 'plus-ed.com | Agent Add';
        $data['breadcrumb1'] = 'Agent management';
        $data['breadcrumb2'] = 'Add';
        $data['pageHeader'] = "Add Agent";
        $formData = array(
            'txt_mainfirstname' => '',
            'txt_mainfamilyname' => '',
            'txt_agentemail' => '',
            'txt_businessname' => '',
            'txt_businessaddress' => '',
            'txt_businesscity' => '',
            'txt_businesspostalcode' => '',
            'txt_businesscountry' => '',
            'txt_businesstelephone' => '',
            'txt_accountmanagerfirstname' => '',
            'txt_accountmanagerfamilyname' => '',
            'txt_accountmanagerposition' => ''
        );

        if (empty($_POST)) {
            if ($edit_id) {
                $editData = $this->magenti->getAgentDetails($edit_id);
                if ($editData) {
                    $data['title'] = 'plus-ed.com | Agent Edit';
                    $data['breadcrumb1'] = 'Agent management';
                    $data['breadcrumb2'] = 'Edit';
                    $data['pageHeader'] = "Edit Agent";
                    $formData = array(
                        'txt_mainfirstname' => $editData[0]['mainfirstname'],
                        'txt_mainfamilyname' => $editData[0]['mainfamilyname'],
                        'txt_agentemail' => $editData[0]['agentemail'],
                        'txt_businessname' => $editData[0]['businessname'],
                        'txt_businessaddress' => $editData[0]['businessaddress'],
                        'txt_businesscity' => $editData[0]['businesscity'],
                        'txt_businesspostalcode' => $editData[0]['businesspostalcode'],
                        'txt_businesscountry' => $editData[0]['businesscountry'],
                        'txt_businesstelephone' => $editData[0]['businesstelephone'],
                        'txt_accountmanagerfirstname' => $editData[0]['firstname'],
                        'txt_accountmanagerfamilyname' => $editData[0]['familyname'],
                        'txt_accountmanagerposition' => $editData[0]['position']
                    );
                }
            }
            $data['formData'] = $formData;
            $data['countries'] = $this->magenti->getCountryList();  //print_r($data['countries']);die;
            $this->ltelayout->view('lte/backoffice/agents/addeditagent', $data); //$this -> ltelayout -> view('lte/backoffice/excursion/addedit', $data);
        } else {
            $edit_id = $this->input->post('edit_id');
            if ($edit_id) {
                $update_data = array(
                    'mainfirstname' => trim($this->input->post('txt_mainfirstname')),
                    'mainfamilyname' => trim($this->input->post('txt_mainfamilyname')),
                    'businessname' => trim($this->input->post('txt_businessname')),
                    'businessaddress' => trim($this->input->post('txt_businessaddress')),
                    'businesscity' => trim($this->input->post('txt_businesscity')),
                    'businesscountry' => trim($this->input->post('txt_businesscountry')),
                    'businesspostalcode' => trim($this->input->post('txt_businesspostalcode')),
                    'businesstelephone' => trim($this->input->post('txt_businesstelephone')),
                );

                $result = $this->magenti->Agentaction('update', $update_data, $edit_id);
                if ($result) {
                    $this->session->set_flashdata('success_message', 'Record updated successfully.');
                    redirect('manageagents');
                } else {
                    $this->session->set_flashdata('error_message', 'Unable to update record.');
                }
            } else {
                $insert_data = array(
                    'mainfirstname' => trim($this->input->post('txt_mainfirstname')),
                    'mainfamilyname' => trim($this->input->post('txt_mainfamilyname')),
                    'businessname' => trim($this->input->post('txt_businessname')),
                    'businessaddress' => trim($this->input->post('txt_businessaddress')),
                    'businesscity' => trim($this->input->post('txt_businesscity')),
                    'businesscountry' => trim($this->input->post('txt_businesscountry')),
                    'businesspostalcode' => trim($this->input->post('txt_businesspostalcode')),
                    'businesstelephone' => trim($this->input->post('txt_businesstelephone')),
                );
                //$result = $this->magenti->Agentaction('insert',$insert_data);
                //if($result){
                redirect('manageagents');
                //}
                //else{
                //}
            }
        }
    }

}
