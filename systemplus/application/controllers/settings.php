<?php

/**
 * @Programmer  : Arunsankar
 * @Maintainer  : Arunsankar
 * @Created     : 06-Jul-2017
 * @Modified    : 
 * @Description : Settings for backoffice operator
 */
class Settings extends Controller {

    public function __construct() {

        parent::Controller();

        authSessionMenu($this);
        $this->load->helper(array('url'));
        $this->load->model('settings_model', 'setting');
        $this->load->library(array('session', 'email', 'ltelayout'));
    }

    /*
     * function for manage CM page
     */

    function manage_cm() {
        $data['title'] = 'plus-ed.com | Manage Campus Manager email';
        $data['breadcrumb1'] = 'Manage CM/CD emails';
        $data['breadcrumb2'] = 'Manage CM emails';
        $data['pageHeader'] = $data['breadcrumb2'];
        $data['optionalDescription'] = "";
        $this->ltelayout->view('lte/backoffice/settings/manage_cm', $data);
    }

    public function getUsers() {
        $request = $_REQUEST;
        $search = $request['search']['value'];
        $role = $request['role'];
        $param = datatable_param($request, 'nome_centri', 'asc');
        $cmData = $this->setting->getUsers($search, $param, $role);
        $cmCount = $this->setting->getUsersCount($search, $role);
        if (empty($cmData)) {
            $cmData = array();
        } else {
            $cmData = $this->makeData($cmData);
        }
        echo datatable_json($request['draw'], $cmCount, $cmData);
        exit(0);
    }

    function makeData($data) {
        if (empty($data)) {
            return array();
        }
        foreach ($data as $key => $d) {
            $data[$key]['first_name'] = ucfirst($d['first_name'] . ' ' . $d['last_name']);
            $data[$key]['action'] = '<a href="javascript:void(0);" class="btn btn-primary btn-xs open-modal" data-id="' . $d['id'] . '" data-toggle="tooltip" title="Edit details"><i class="fa fa-edit"></i></a>';
        }
        return $data;
    }

    /*
     * function for handling the update functionality for email.
     */

    public function updateUser() {
        parse_str($this->input->post('formData'), $formData);
        $email = $formData['email'];
        $firstName = $formData['first_name'];
        $lastName = $formData['last_name'];
        $id = $formData['user_id'];
        $origEmail = $formData['orig_email'];
        if (empty($email) || empty($id) || empty($firstName) || empty($lastName)) {
            echo json_encode(array('error' => true, 'message' => 'Invalid Request'));
            exit(0);
        }
        if ($origEmail != $email) {
            $emailExists = $this->setting->isEmailExists($email);
            if ($emailExists) {
                echo json_encode(array('error' => true, 'message' => 'This email is already taken.'));
                exit(0);
            }
        }
        unset($formData['user_id']);
        unset($formData['orig_email']);
        $this->setting->update('members', $formData, array('id' => $id));
        echo json_encode(array('success' => true, 'message' => 'Saved.'));
        exit(0);
    }

    /*
     * function for managing course director list
     */

    function manage_cd() {
        $data['title'] = 'plus-ed.com | Manage Course Director email';
        $data['breadcrumb1'] = 'Manage CM/CD emails';
        $data['breadcrumb2'] = 'Manage CD emails';
        $data['pageHeader'] = $data['breadcrumb2'];
        $data['optionalDescription'] = "";
        $this->ltelayout->view('lte/backoffice/settings/manage_cd', $data);
    }

    public function getUser() {
        $id = $this->input->post('id');
        if (empty($id)) {
            json_encode(array('error' => true, 'message' => 'Invalid request'));
            exit(0);
        }
        $user = $this->setting->getUser($id);
        echo json_encode(array('success' => true, 'user' => $user));
        exit(0);
    }

}

//End : additions by Arunsankar S
/* End of file backoffice.php */
