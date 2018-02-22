<?php

class Lte extends Controller {

    public function __construct() {

        parent::Controller();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('ltelayout');
    }

    function index() 
    {
        $data = array();
        $data['title'] = "plus-ed.com | Test page";
        $data['pageHeader'] = "Test page";
        $data['optionalDescription'] = "this is testing of lte layout";
        $this->ltelayout->view('ltelayout/mypage', $data);
    }
}

/* End of file lte.php */
