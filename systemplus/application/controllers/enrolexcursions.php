<?php

/**
 * Class to manage new enrollments planned excursions
 * @author SK
 * @since 25-Aug-2017
 */
class Enrolexcursions extends Controller {

    public function __construct() {

        parent::Controller();
        // check user session and menus with their access.
        if (!$this->session->userdata('role')) {
            redirect('backoffice', 'refresh');
        }
        authSessionMenu($this);
        $this->load->model('mbackoffice');
        $this->load->model('enroll_excursion_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'email', 'ltelayout', 'form_validation'));
    }

    function planned() {
//            if ($this->session->userdata('role') == 100) {
        $campus = isset($_POST['centri']) ? $_POST['centri'] : 4;
        $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'planned';
        $from = "";
        $to = "";
        if (isset($_POST['from']))
            $from = (!empty($_POST['from']) ? $_POST['from'] : date("d/m/Y"));
        else
            $from = date("d/m/Y");
        $fromA = explode("/", $from);
        $fromGirato = $fromA[2] . "-" . $fromA[1] . "-" . $fromA[0];
        if (isset($_POST['to']))
            $to = (!empty($_POST['to']) ? $_POST['to'] : date("d/m/Y", strtotime($fromGirato . "+ 7 days")));
        else
            $to = date("d/m/Y", strtotime($fromGirato . "+ 7 days"));
        $data["campus"] = $campus;
        $data["tipo"] = $tipo;
        $data["to"] = $to;
        $data["from"] = $from;
        $data["centri"] = $this->mbackoffice->getAllCampusForDropdown();
        $data["all_excursions"] = $this->enroll_excursion_model->listAllExcursions($campus, $tipo, $to, $from);
        $data['title'] = 'plus-ed.com | Review enrolled excursions';
        $data['breadcrumb1'] = 'Included excursions ';
        $data['breadcrumb2'] = 'Review enrolled excursions';
        $data['pageHeader'] = $data['breadcrumb2'];
        $data['optionalDescription'] = "";
        $this->ltelayout->view('lte/backoffice/super_user/enrolled_excursions', $data);
//            } else {
//                redirect('backoffice', 'refresh');
//            }
    }

}

/* End of file roles.php */
