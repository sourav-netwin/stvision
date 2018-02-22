<?php

/**
 * Class to control Join Camppus and company page
 * @since 22-MAR-2016
 * @author Arunsankar
 * @modified 12-APR-2016
 * @modified_by Arunsankar
 */
class Joincampuscompany extends Controller {

    public function __construct() {

        parent::Controller();
        if (!$this->session->userdata('role')) {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
        authSessionMenu($this);
        $this->load->helper(array('url'));
        $this->load->library('session');
        $this->load->model("tuition/joincampuscompanymodel", "joincampuscompanymodel");
    }

    /**
     * Function for view the main page
     * @author Arunsankar
     * @since 22-Mar-2016
     */
    public function index() {
//		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
        $this->load->library('form_validation');
        $formData = array(
            'selCampus' => '',
            'selCompanies' => array()
        );
        if (isset($_POST['btnMap'])) {
            $formVal = array(
                array(
                    'field' => 'selCampus',
                    'label' => 'Campus',
                    'rules' => 'numeric|required'
                ),
                array(
                    'field' => 'selCompanies',
                    'label' => 'Companies',
                    'rules' => 'required'
                )
            );
            $this->form_validation->set_rules($formVal);
            if ($this->form_validation->run() == TRUE) {
                $campusId = $this->input->post('selCampus');
                $companiesIds = $this->input->post('selCompanies');
                $isInsertUpdate = $this->joincampuscompanymodel->insertUpdate($campusId, $companiesIds);
                if ($isInsertUpdate) {
                    $this->session->set_flashdata('success_message', 'Mapped successfully');
                    redirect('joincampuscompany');
                    exit(0);
                } else {
                    $this->session->set_flashdata('error_message', 'Failed to map');
                    redirect('joincampuscompany');
                    exit(0);
                }
            }
        }
        $data['title'] = "plus-ed.com | Join Campus and Company";
        $data['breadcrumb1'] = 'Excursion management';
        $data['breadcrumb2'] = 'Join campus and companies';
        $data['campuses'] = $this->joincampuscompanymodel->getCampusData();
        $data['companies'] = $this->joincampuscompanymodel->getCompanyData();
        $data['formData'] = $formData;
        $data['mappeddata'] = $this->joincampuscompanymodel->getMappedData();
        if (APP_THEME == 'OLD') {
            $this->load->view('tuition/excu_join_campus_company', $data);
        } else {
            $data['pageHeader'] = "Join campus and companies";
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/excursion/join_campus_company', $data);
        }
    }

    function getCompanies() {
//        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $id = $this->input->post('id');
            $mappedCompanies = array();
            if (!empty($id) && is_numeric($id)) {
                $mappedCompaniesArray = $this->joincampuscompanymodel->getMappedCompanies($id);
                if (!empty($mappedCompaniesArray)) {
                    foreach ($mappedCompaniesArray as $mapped) {
                        $mappedCompanies[] = $mapped['tra_cp_id'];
                    }
                }
                echo json_encode(array(
                    'result' => $mappedCompanies
                ));
            }
//        } else {
//            $this->session->sess_destroy();
//            redirect('backoffice', 'refresh');
//        }
    }

}
