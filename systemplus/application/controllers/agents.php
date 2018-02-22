<?php

class Agents extends Controller {

    public function __construct() {

        parent::Controller();

        $this->load->helper(array('form', 'url'));
        $this->load->model('magenti');
        $this->load->model('mbackoffice');
        $this->load->model('gestione_centri_model');
        $this->load->library(array('session', 'email'));
    }

    public function index() {
        $sess_username = $this->session->userdata('username');
        if (empty($sess_username)) {
            if (APP_THEME == 'OLD') 
            {
                $this->load->helper('string');
                $data['title'] = "plus-ed.com | Login";
                $this->load->view('plused_login', $data);
            } else {
                $sessFlash =  $this->session->flashdata("come_from_reg");
                $this->session->set_flashdata('come_from_reg',$sessFlash);
                redirect('vauth/agents', 'refresh');
            }
        } else {
            redirect('agents/dashboard');
        }
    }

    public function login() {
        session_start();
        $data['heading'] = "Check login...";
        $user = $this->input->post('login_name');
        $pwd = $this->input->post('login_pw');
        $data['results'] = $this->magenti->verifyuser($user, $pwd);
        if ($data['results']) {
            $data['attivi'] = false;
            $data['title'] = "plus-ed.com | Dashboard";

            if ('agente' == $data['results'][0]['ruolo']) {
                $newdata = array(
                    'username' => $data['results'][0]['login'],
                    'mainfirstname' => $data['results'][0]['mainfirstname'],
                    'mainfamilyname' => $data['results'][0]['mainfamilyname'],
                    'businessname' => $data['results'][0]['businessname'],
                    'id' => $data['results'][0]['id'],
                    'email' => $data['results'][0]['email'],
                    'country' => $data['results'][0]['businesscountry'],
                    'role' => 99, //99 = agente, 98 = account manager
                    'logged_in' => true,
                );
            } else {
                if ('mediaViewer' == $data['results'][0]['ruolo']) {
                    $newdata = array(
                        'username' => $data['results'][0]['email'],
                        'mainfirstname' => $data['results'][0]['firstname'],
                        'mainfamilyname' => $data['results'][0]['familyname'],
                        'businessname' => $data['results'][0]['familyname'] . " " . $data['results'][0]['firstname'],
                        'id' => $data['results'][0]['id'],
                        'email' => $data['results'][0]['email'],
                        'country' => "",
                        'role' => 97, //97=mediaViewer, 99 = agente, 98 = account manager
                        'logged_in' => true,
                    );
                } else {
                    $newdata = array(
                        'username' => $data['results'][0]['email'],
                        'mainfirstname' => $data['results'][0]['firstname'],
                        'mainfamilyname' => $data['results'][0]['familyname'],
                        'businessname' => $data['results'][0]['familyname'] . " " . $data['results'][0]['firstname'],
                        'id' => $data['results'][0]['id'],
                        'email' => $data['results'][0]['email'],
                        'country' => "",
                        'role' => 98, //99 = agente, 98 = account manager
                        'logged_in' => true,
                    );
                }
            }
            $this->session->set_userdata($newdata);
            $this->load->vars($data);
            if ('mediaViewer' == $data['results'][0]['ruolo']) {
                redirect('agents/imageGallery', 'refresh');
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    public function logged() {
        $data['title'] = "plus-ed.com | Dashboard";
        $this->load->view('plused_dashboard', $data);
    }

    public function dashboard() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Dashboard";
            $data['breadcrumb1'] = 'Dashboard';
            $data['breadcrumb2'] = '';
            if ($this->session->userdata('role') == 98) {
                $data['remindme'] = $this->magenti->getRemindersByAM($this->session->userdata('id'));
            }
            if (APP_THEME == "OLD") {
                $this->load->view('plused_dashboard', $data);
            } else {
                // if(APP_THEME == "LTE")
                $data['pageHeader'] = "Dashboard";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/dashboard', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

/**
 * allow user to download file
 */
    public function downloadform() {
        $this->load->helper('download');
        $attachFile = EXTRA_EXCURSIONS_AND_ATTRACTIONS_ZIP_FILE;
        $data = file_get_contents($attachFile); // Read the file's contents
        $name = 'extra_excursions_and_attraction_zip_file.zip';
        force_download($name, $data);
    }

    public function changeCredential() {
        $bOArray = array(200, 300, 400, 100); // BACKOFFICE USERS ROLE IDS
        if ($this->session->userdata('username') && in_array($this->session->userdata('role'), $bOArray)) {
            redirect('backoffice/profile', 'refresh');
        } else if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Profile";
            $data['breadcrumb1'] = 'Profile';
            $data['breadcrumb2'] = '';
            $data["n_books"] = count($this->magenti->getBookingsByAgent($this->session->userdata('id')));
            $data["ag_details"] = $this->magenti->plused_get_ag_details($this->session->userdata('id'));
            //$this->load->view('plused_profile', $data);
            if (APP_THEME == 'OLD') {
                $this->load->view('plused_profile', $data);
            } else {
                $this->ltelayout->view('lte/agents/profile', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function ajaxChangePass() {
        $bOArray = array(99, 97, 98); // AGENTS USERS ROLE IDS
        $roleId = $this->session->userdata('role');
        if (in_array($this->session->userdata('role'), $bOArray)) {
            $memberId = $this->session->userdata('id');
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            $result = $this->magenti->changePassword($memberId, $roleId, $oldPassword, $newPassword);
            if (1 == $result) {
                echo json_encode(array('result' => 1, 'message' => 'Password changed successfully.'));
            } elseif (-1 == $result) {
                echo json_encode(array('result' => 0, 'message' => 'Invalid old password.'));
            } else {
                echo json_encode(array('result' => 0, 'message' => 'User no longer available in the system.'));
            }
        } else {
            echo json_encode(array('result' => 0, 'message' => 'User session expired.'));
        }
    }

    public function manageAgent($idagent) {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $ismine = $this->magenti->checkAgentAccount($idagent, $this->session->userdata('id'));
            if (1 == $ismine) {
                $data['title'] = "plus-ed.com | Edit agent";
                $data['breadcrumb1'] = 'Manage agents';
                $data['breadcrumb2'] = 'Edit agent';
                $data["n_books"] = count($this->magenti->getBookingsByAgent($idagent));
                $data["ag_details"] = $this->magenti->plused_get_ag_details($idagent);
                $data["all_prodotti"] = $this->magenti->plused_getProducts($idagent);
                $data["doi_agent"] = $this->magenti->getDOIAgents($idagent);
                foreach ($data["all_prodotti"] as $prodottonum) {
                    $data["doi"][$prodottonum["prd_id"]] = $this->magenti->plused_getAllDOI($prodottonum["prd_id"]);
                }
                if (APP_THEME == 'OLD') {
                    $this->load->view('plused_manage_agent', $data);
                } else {
                    $this->ltelayout->view('lte/agents/account_manager/manage_agent', $data);
                }
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function insertAgent() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Insert agent/prospect";
            $data['breadcrumb1'] = 'Manage agents';
            $data['breadcrumb2'] = 'Insert agent/prospect';
            $data["all_prodotti"] = $this->magenti->plused_getAllProducts();
            foreach ($data["all_prodotti"] as $prodottonum) {
                $data["doi"][$prodottonum["prd_id"]] = $this->magenti->plused_getAllDOI($prodottonum["prd_id"]);
            }
            if (APP_THEME == 'OLD') {
                $this->load->view('plused_insert_agent', $data);
            } else {
                $this->ltelayout->view('lte/agents/account_manager/insert_agent', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function register() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Dashboard";
            $data['breadcrumb1'] = 'Dashboard';
            $data['breadcrumb2'] = '';
            $this->load->view('plused_dashboard', $data);
        } else {
            $data['title'] = "plus-ed.com | Register";
            if(APP_THEME == "OLD")
            {
                $data['breadcrumb1'] = 'Register';
                $data['breadcrumb2'] = '';
                $data['pref_dest'] = $this->gestione_centri_model->getPrefDest();
                $this->load->view('plused_register', $data);
            }
            else{
                $data = array();
                $data['title'] = "plus-ed.com | Register";
                $data['pageHeader'] = "Register";
                $data['pref_dest'] = $this->gestione_centri_model->getPrefDest();
                $this->load->view('login/agent_register', $data);
            }
        }
    }

    public function mkt_material_pj_old() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Marketing materials";
            $data['breadcrumb1'] = 'Marketing materials';
            $data['breadcrumb2'] = 'Plus junior summer';
            $data['fsUK'] = $this->gestione_centri_model->getCampusByLocation("United Kingdom", 1);
            $data['fsUSA'] = $this->gestione_centri_model->getCampusByLocation("USA", 1);
            $data['fsIR'] = $this->gestione_centri_model->getCampusByLocation("Ireland", 1);
            $data['fsMA'] = $this->gestione_centri_model->getCampusByLocation("Malta", 1);
            $data['campusDetails'] = $this->gestione_centri_model->getCampusWithVideos();

            if (APP_THEME == "OLD") {
                $this->load->view('plused_mkt_material_pj', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/mkt_material_pj', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }
    
    public function mkt_material_pj() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Marketing materials";
            $data['breadcrumb1'] = 'Marketing materials';
            $data['breadcrumb2'] = 'Plus junior summer';
            $data['fsUK'] = $this->gestione_centri_model->getCampusByLocation("United Kingdom", 1);
            $data['fsUSA'] = $this->gestione_centri_model->getCampusByLocation("USA", 1);
            $data['fsIR'] = $this->gestione_centri_model->getCampusByLocation("Ireland", 1);
            $data['fsMA'] = $this->gestione_centri_model->getCampusByLocation("Malta", 1);
            $data['campusDetails'] = $this->gestione_centri_model->getCampusWithVideos();
            
            $this->load->model('agents/pricelistpdfmodel','pricelistpdfmodel');
            $data['campusPriceList'] = $this->pricelistpdfmodel->getData("campus");
            $data['transferPriceList'] = $this->pricelistpdfmodel->getData("transfer");
            if (APP_THEME == "OLD") {
                $this->load->view('plused_mkt_material_pj', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/mkt_material_pj_new', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }
    
    public function _getCampusUploadedPdfs($campusId){
        $campusPdfs = $this->magenti->getCampusPdfForAgent($campusId);
        return $campusPdfs;
    }

    public function mkt_material_pjw() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Marketing materials";
            $data['breadcrumb1'] = 'Marketing materials';
            $data['breadcrumb2'] = 'Plus junior winter';
            $data['fsUK'] = $this->gestione_centri_model->getCampusByLocationProgram("United Kingdom", 2, 1);
            $data['fsUSA'] = $this->gestione_centri_model->getCampusByLocationProgram("USA", 1, 2, 1);

            if (APP_THEME == "OLD") {
                $this->load->view('plused_mkt_material_pjw', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/mkt_material_pjw', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function imageGallery($type) {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            if ('college' == $type) {
                $title = 'College images';
            } else if ('city' == $type) {
                $title = 'Cities images';
            } else {
                $title = 'Students images';
            }

            $data['title'] = "plus-ed.com | $title";
            $data['breadcrumb1'] = 'Media gallery';
            $data['breadcrumb2'] = $title;
            $data['fsUK'] = $this->gestione_centri_model->getCampusByLocation("United Kingdom");
            $data['fsUSA'] = $this->gestione_centri_model->getCampusByLocation("USA");
            $data['fsIR'] = $this->gestione_centri_model->getCampusByLocation("Ireland");
            $data['fsMA'] = $this->gestione_centri_model->getCampusByLocation("Malta");
            $data['campusImages'] = $this->gestione_centri_model->getCampusWithImages($type);
            if (APP_THEME == "OLD") {
                $this->load->view('plused_media_image', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/media_image', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function logout() {
        {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function enrol() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            //$data['centri'] = $this->gestione_centri_model->building();
            $data['centri'] = $this->gestione_centri_model->buildCampusByProgramId(1, 1);
            $data['agenzie'] = $this->gestione_centri_model->agency_building();
            $data['aereo_in'] = $this->gestione_centri_model->airport();
            $data['aereo_out'] = $this->gestione_centri_model->airport_back();
            $data['user'] = $this->session->userdata('username');
            $data['id'] = $this->session->userdata('id');
            $data['name'] = $this->session->userdata('mainfirstname');
            $data['surname'] = $this->session->userdata('mainfamilyname');
            $data['business'] = $this->session->userdata('businessname');
            $login = $data['user'];
            $id = $data['id'];
            $data['title'] = 'plus-ed.com | Enrol new group';
            $data['breadcrumb1'] = 'Enrol';
            $data['breadcrumb2'] = 'Enrol new group';
            if ($this->session->flashdata('form')) {
                $data['form'] = $this->session->flashdata('form');
            }

            if (APP_THEME == "OLD") {
                $this->load->view('plused_enrol', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/enrol', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

//NEW ENROL FUNCTION
    public function plusedNewEnrol() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            //$data['centri'] = $this->gestione_centri_model->building();
            $data['centri'] = $this->gestione_centri_model->buildCampusByProgramId(1, 1);
            $data['aereo_in'] = $this->gestione_centri_model->airport();
            $data['aereo_out'] = $this->gestione_centri_model->airport_back();
            $data['user'] = $this->session->userdata('username');
            $data['id'] = $this->session->userdata('id');
            $data['name'] = $this->session->userdata('mainfirstname');
            $data['surname'] = $this->session->userdata('mainfamilyname');
            $data['business'] = $this->session->userdata('businessname');
            $this->load->view('plused_enrolNew', $data);
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function insertGroup() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            if (!$this->validateEnrolBooking()) {
                redirect('agents/enrol');
            }
            $data['user'] = $this->session->userdata('username');
            $data['mail'] = $this->session->userdata('email');
            $data['id'] = $this->session->userdata('id');
            $data['name'] = $this->session->userdata('mainfirstname');
            $data['surname'] = $this->session->userdata('mainfamilyname');
            $data['business'] = $this->session->userdata('businessname');
            $login = $data['user'];
            $email = $data['mail'];
            $last_book = $this->gestione_centri_model->insertBook();
            $data['all_rows'] = $this->gestione_centri_model->insertRows($last_book, date("Y"), $data['id']);
            //$myidCenter = $this->input->xss_clean($this->input->post('center_select'));
            //$insert_excursion = $this->magenti->insertExcursion($myidCenter,$last_book,date("Y"));
            $data['mail_account'] = $this->magenti->getAccountMail($this->session->userdata('id'));
            $mail_account = $data['mail_account'][0]['email'];
            $this->load->library('email');
            $mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
            $mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
            $mymessage .= "A new booking (id: " . date('Y') . "_" . $last_book . ") has been submitted by <strong>" . $this->session->userdata('businessname') . "</strong>" . "<br/><br/>";
            $mymessage .= "</body></html>";
            $this->email->from("booking@plus-ed.com");
            $this->email->to($mail_account);
            $this->email->cc('smarra@plus-ed.com');
            $this->email->bcc('a.sudetti@gmail.com');
            $this->email->subject('Plus Sales Office - New booking submitted');
            $this->email->message($mymessage);
            $this->email->send();
            $this->email->clear();
            $mymessage2 = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
            $mymessage2 .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
            $mymessage2 .= "<strong>  Dear Sir/Madam </strong><br/><br/>";
            $mymessage2 .= "Your booking (id: " . date('Y') . "_" . $last_book . ") has been successfully transmitted.<br/><br/>";
            $mymessage2 .= "<strong>Plus Sales Office</strong>" . "<br/><br/>";
            $mymessage2 .= "</body></html>";
            $this->email->from("booking@plus-ed.com");
            $this->email->to($email);
            $this->email->cc('a.kavak@plus-ed.com');
            $this->email->subject('Plus Sales Office - Your booking has been transmitted');
            $this->email->message($mymessage2);
            $this->email->send();
            redirect('agents/insertedBookings', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function insertedBookings($bookId = null, $year = null) {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $sessUserId = $this->session->userdata('id');
            $data["all_books"] = $this->magenti->getBookingsByAgent($sessUserId);
            $data['title'] = 'plus-ed.com | Inserted bookings';
            $data['breadcrumb1'] = 'Bookings review';
            $data['breadcrumb2'] = 'Inserted bookings';
            $data['bookId'] = $bookId;
            $data['year'] = $year;

            if (APP_THEME == "OLD") {
                $this->load->view('plused_view_bookings', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/view_bookings', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    private function validateEnrolBooking() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('prod_select', 'Product', 'required');
        $this->form_validation->set_rules('center_select', 'Center', 'required');
        $this->form_validation->set_rules('n_weeks', 'Weeks', 'required');
        $this->form_validation->set_rules('sum_stud', 'Students', 'required');
        $this->form_validation->set_rules('sum_gl', 'Group Leaders', 'required');
        $this->form_validation->set_rules('arrival_date', 'Arrival Date', 'required|callback_dateValid');
        $this->form_validation->set_rules('departure_date', 'Departure Date', 'required|callback_dateValid');
        $this->form_validation->set_rules('declaration_check', 'Declaration', 'required');
        $aDate = $this->input->post('arrival_date');
        $dDate = $this->input->post('departure_date');
        if ($this->form_validation->run() == FALSE) {
            $form = array(
                'data' => $_POST,
                'error' => $this->form_validation->_error_array,
            );
            
            if (!empty($aDate) && !empty($dDate)) {
                if (!$this->checkValidBookingDates($aDate, $dDate)) {
                    $form['error']['invertBookingDate'] = true;
                }
            }

            if (!empty($aDate)) {
                $form['data']['arrival_date'] = $this->setValidBookingDates($aDate);
                $form['data']['hid_arrival_date'] = $aDate;
            }
            if (!empty($dDate)) {
                $form['data']['departure_date'] = $this->setValidBookingDates($dDate);
                $form['data']['hid_departure_date'] = $dDate;
            }

            $this->session->set_flashdata('form', $form);
            return false;
        }
        if (!$this->checkValidBookingDates($aDate, $dDate)) {
            $form = array(
                'data' => $_POST,
            );
            $form['error']['invertBookingDate'] = true;
            $form['data']['arrival_date'] = $this->setValidBookingDates($aDate);
            $form['data']['hid_arrival_date'] = $aDate;
            $form['data']['departure_date'] = $this->setValidBookingDates($dDate);
            $form['data']['hid_departure_date'] = $dDate;
            $this->session->set_flashdata('form', $form);
            return false;
        }
        return true;
    }

    private function setValidBookingDates($date) {
        $arr2 = explode("/", $date);
        return $arr2[1] . "/" . $arr2[0] . "/" . $arr2[2];
    }

    public function checkValidBookingDates($arrivalDate, $departureDate) {
        $date1 = date('Y-m-d', strtotime($arrivalDate));
        $date2 = date('Y-m-d', strtotime($departureDate));
        return $date1 < $date2;
    }

    public function dateValid($date) {
        $month = (int) substr($date, 0, 2);
        $day = (int) substr($date, 3, 2);
        $year = (int) substr($date, 6, 4);
        return checkdate($month, $day, $year);
    }

    public function bookExtraExcursions($status, $sort, $sorttype) {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data["all_books"] = $this->magenti->getBookingsByAgent($this->session->userdata('id'), $status, $sort, $sorttype);
            foreach ($data["all_books"] as $key => $lilbook) {
                $data["all_books"][$key]["conta_ex"] = $this->magenti->countAllExcursionsByBookingID($lilbook["id_year"] . "_" . $lilbook["id_book"]);
            }
            $data['title'] = 'plus-ed.com | Book extra excursions';
            $data['breadcrumb1'] = 'Extra excursions';
            $data['breadcrumb2'] = 'Book extra excursions';

            if (APP_THEME == "OLD") {
                $this->load->view('plused_book_extra_excursions', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/book_extra_excursions', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function viewExtraExcursions($status, $sort, $sorttype) {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data["all_books"] = $this->magenti->getBookingsByAgent($this->session->userdata('id'), $status, $sort, $sorttype);
            foreach ($data["all_books"] as $key => $lilbook) {
                $data["all_books"][$key]["conta_ex"] = $this->magenti->countAllExcursionsByBookingID($lilbook["id_year"] . "_" . $lilbook["id_book"]);
            }
            $data['title'] = 'plus-ed.com | View extra excursions';
            $data['breadcrumb1'] = 'Extra excursions';
            $data['breadcrumb2'] = 'View extra excursions';

            if (APP_THEME == "OLD") {
                $this->load->view('plused_view_extra_excursions', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/view_extra_excursions', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function listAgents() {
        if ($this->session->userdata('role') == 98) {
            $data["all_agents"] = $this->magenti->getMyAgents($this->session->userdata('id'));
            $data['title'] = 'plus-ed.com | View agents';
            $data['breadcrumb1'] = 'Manage agents';
            $data['breadcrumb2'] = 'View agents';
            if (APP_THEME == "OLD") {
                $this->load->view('plused_list_agents', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/account_manager/list_agents', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents/dashboard', 'refresh');
        }
    }

    public function viewChatHistory($agent, $tipo = "sales") {
        if ($this->session->userdata('role') == 98) {
            $ismine = $this->magenti->checkAgentAccount($agent, $this->session->userdata('id'));
            if ($ismine) {
                $data["all_chats"] = $this->magenti->getChatsByAgent($agent, $this->session->userdata('id'), $tipo);
                $data["ag_details"] = $this->magenti->plused_get_ag_details($agent);
                $data['categoria'] = $tipo;
                $data['title'] = 'plus-ed.com | Conversation history | ' . strtoupper($tipo);
                $data['breadcrumb1'] = 'Manage agents';
                $data['breadcrumb2'] = 'View conversation history | ' . strtoupper($tipo);

                if (APP_THEME == "OLD") {
                    $this->load->view('plused_chat_history', $data);
                } else // if(APP_THEME == "LTE")
                {
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/agents/account_manager/chat_history', $data);
                }
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents/dashboard', 'refresh');
        }
    }

    public function findDatesByCenter() {
        //$data['idback']=$this->gestione_centri_model->findIDBack($_POST['idcentro']);
        //$data['arDATE']=$this->gestione_centri_model->findDatesByCenter($data['idback'][0]['idback']);
        $data['arDATE'] = $this->gestione_centri_model->findDatesByCenter($_POST['idcentro']);
        $nomecentro = $this->gestione_centri_model->centerNameById($_POST['idcentro']);
        $alldates = $data['arDATE'];
        echo "ARRIVAL DATES @ " . $nomecentro . ": ";
        foreach ($alldates as $dataA) {
            $dataGirata = explode("-", $dataA["start_date"]);
            ?>
				<span class="datearrivo"><?php echo $dataGirata[2] ?>/<?php echo $dataGirata[1] ?>/<?php echo $dataGirata[0] ?></span>
		<?php
}
    }

    public function findAccoByCenter() {
        $data['arACCO'] = $this->gestione_centri_model->findAccoByCenter($_POST['idcentro']);
        $allACCO = $data['arACCO'];
        foreach ($allACCO as $accoA) {
            ?>
				<span class="accocentro"><?php echo $accoA["sistemazione"] ?></span>
				<script>
				$(".accocentro").each(function(index) {
					if($(this).text()=="Ensuite"){
						$("#row_st_en").show();
						$("#row_gl_en").show();
					}
					if($(this).text()=="Standard"){
						$("#row_st_st").show();
						$("#row_gl_st").show();
					}
					if($(this).text()=="Homestay"){
						$("#row_st_ho").show();
						$("#row_gl_ho").show();
					}
					if($(this).text()=="Twin"){
						$("#row_st_tw").show();
						$("#row_gl_tw").show();
					}
				});
				</script>
		<?php
}
    }

    public function updateStatusAgent($agent) {
        if ($this->session->userdata('role') == 98) {
            $ismine = $this->magenti->checkAgentAccount($agent, $this->session->userdata('id'));
            if ($ismine) {
                $this->magenti->clearCommissionAgents($agent);
                foreach ($_POST as $key => $value) {
                    if ('price_category' == $key) {
                        $this->magenti->setPriceCategory($agent, $value);
                    } else if (intval(strpos($key, "pinner_")) > 0) {
                        $setsconto = explode("_", $key);
                        $idprodotto = $setsconto[1];
                        $scontoprodotto = $value;
                        $this->magenti->setCommissionAgents($agent, $idprodotto, $scontoprodotto);
                    } else {
                        if (intval(strpos($key, "tatus_")) > 0) {
                            $this->magenti->setStatusAgents($agent, $value);
                        } else {
                            $this->magenti->setRankingAgents($agent, $value);
                        }
                    }
                }
                redirect('agents/manageAgent/' . $agent, 'refresh');
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents/dashboard', 'refresh');
        }
    }

    public function updateProfileAgent($agent) {
        if ($this->session->userdata('role') == 98) {
            $ismine = $this->magenti->checkAgentAccount($agent, $this->session->userdata('id'));
            if ($ismine) {
                foreach ($_POST as $key => $value) {
                    if ("modprofile" != $key) {
                        $this->magenti->updateAgentField($agent, $key, $value);
                    }
                }
                redirect('agents/manageAgent/' . $agent, 'refresh');
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents/dashboard', 'refresh');
        }
    }

    public function send_agent_credentials($agent) {
        if ($this->session->userdata('role') == 98) {
            $ismine = $this->magenti->checkAgentAccount($agent, $this->session->userdata('id'));
            if ($ismine) {
                $dettaglioagente = $this->magenti->plused_get_ag_details($agent);
                $a_email = $dettaglioagente[0]["email"];
                $a_login = $dettaglioagente[0]["login"];
                $a_pwd = $dettaglioagente[0]["password"];
                //send emails
                //@user
                $this->load->library('email');
                $mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
                $mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
                $mymessage .= "<strong>  Dear Sir/Madam </strong><br/><br/>";
                $mymessage .= "Thank you for submitting your registration.<br />Please find your password and username to access your account.<br /><br />Your account will allow you to review your booking , access marketing material ,enroll to our courses.<br />Please remember that your Account Manager is available to you for any further assistance and the helpdesk is there for any technical help.<br /><br /><strong>Username: $a_login<br />Password: $a_pwd<br />";
                $mymessage .= "<strong>Plus Sales Office</strong>" . "<br/><br/>";
                $mymessage .= "</body></html>";

                $this->email->from('info@plus-ed.com', 'Plus Sales Office');
                $this->email->to($a_email);
                $this->email->cc($this->session->userdata('email'));
                $this->email->bcc('a.kavak@plus-ed.com, smarra@plus-ed.com');
                $this->email->subject('Plus Sales Office - Your account has been succesfully activated.');
                $this->email->message($mymessage);
                $this->email->send();
            } else {
                echo "Error! Please contact us @plus-ed.com";
            }
        } else {
            echo "Error!";
        }
    }

    public function confirm_registration() {
        $data['title'] = "plus-ed.com | Registration confirmed";
        $data['breadcrumb1'] = 'Registration confirmed';
        $data['breadcrumb2'] = '';
        $this->load->library('form_validation');
        $validationRule = array(
                    array(
                        'field' => 'business_name',
                        'label' => 'Business name',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'address',
                        'label' => 'Address',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'postal_code',
                        'label' => 'Postal code',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'city',
                        'label' => 'City',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'country',
                        'label' => 'Country',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'phone',
                        'label' => 'Telephone',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'firstname',
                        'label' => 'First name',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'familyname',
                        'label' => 'Family name',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'destinations',
                        'label' => 'Popular destination',
                        'rules' => 'required'
                    )

                );
        $this->form_validation->set_rules($validationRule);
        if ($this->form_validation->run() == TRUE) 
        {
            $business_name = $this->input->post('business_name');
            $address = $this->input->post('address');
            $postal_code = $this->input->post('postal_code');
            $city = $this->input->post('city');
            $country = $this->input->post('country');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $firstname = $this->input->post('firstname');
            $familyname = $this->input->post('familyname');
            $hmstudents = $this->input->post('hmstudents');
            $portionjs = $this->input->post('portionjs');
            $portionll = $this->input->post('portionll');
            $portionup = $this->input->post('portionup');
            $destinations = $this->input->post('destinations');
            if ($this->Magenti->plused_verify_mail($email)) {
                //Insert user and related procedures
                $data["insert_agente"] = $this->magenti->plused_insert_agente($business_name, $address, $postal_code, $city, $country, $email, $phone, $firstname, $familyname, $hmstudents, $portionjs, $portionll, $portionup, $destinations);
                //send emails
                //@user
                $this->load->library('email');
                $mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
                $mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
                $mymessage .= "<strong>  Dear Sir/Madam </strong><br/><br/>";
                $mymessage .= "Your form has successfully been submitted.<br />Within the next 24 hours you will receive an email message with your username and password and your Account Manager will contact you to see if any further assistance is required.<br /><br /><br />";
                $mymessage .= "<strong>Plus Sales Office</strong>" . "<br/><br/>";
                $mymessage .= "</body></html>";

                $this->email->from('info@plus-ed.com', 'Plus Sales Office');
                $this->email->to($email);
                $this->email->subject('Plus Sales Office - Your form has successfully been submitted.');
                $this->email->message($mymessage);
                $this->email->send();
                $this->email->clear();
                //@plused
                $emailplus = "info@plus-ed.com";
                $mymessage2 = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
                $mymessage2 .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
                $mymessage2 .= "<strong>  $business_name has registered @vision </strong><br/><br/>";
                $mymessage2 .= "<ul>";
                $mymessage2 .= "<li><strong>Business name: </strong>$business_name</li>";
                $mymessage2 .= "<li><strong>Address: </strong>$address - $postal_code $city</li>";
                $mymessage2 .= "<li><strong>Country: </strong>$country</li>";
                $mymessage2 .= "<li><strong>Name: </strong>$firstname $familyname</li>";
                $mymessage2 .= "<li><strong>Email: </strong>$email</li>";
                $mymessage2 .= "<li><strong>Phone: </strong>$phone</li>";
                $mymessage2 .= "</ul><br /><br /><br />";
                $mymessage2 .= "<strong>Remember to assign the user to an account manager</strong>" . "<br/><br/>";
                $mymessage2 .= "</body></html>";

                $this->email->from('info@plus-ed.com', 'Plus Sales Office');
                $this->email->to($emailplus);
                $this->email->bcc('a.kavak@plus-ed.com, smarra@plus-ed.com');
                $this->email->subject('Plus Sales Office - New user registration @vision.');
                $this->email->message($mymessage2);
                $this->email->send();
                $this->session->set_flashdata('come_from_reg', 'mailok');
                redirect('agents', 'refresh');
            } else {
                //Duplicated email
                $this->session->set_flashdata('come_from_reg', 'mailko');
                redirect('agents', 'refresh');
            }
        }
        else{
            $data = array();
            $data['title'] = "plus-ed.com | Register";
            $data['pageHeader'] = "Register";
            $data['pref_dest'] = $this->gestione_centri_model->getPrefDest();
            $data['validation_errors'] = validation_errors();
            $this->load->view('login/agent_register', $data);
        }
    }

    public function viewAgentBookings($agent) {
        if ($this->session->userdata('role') == 98) {
            $ismine = $this->magenti->checkAgentAccount($agent, $this->session->userdata('id'));
            if ($ismine) {
                $data["all_books"] = $this->magenti->getBookingsByAgent($agent);
                $data["agente"] = $this->magenti->plused_get_ag_details($agent);
                $data['title'] = 'plus-ed.com | Manage Agents';
                $data['breadcrumb1'] = 'Manage Agents';
                $data['breadcrumb2'] = 'View agent bookings';
                if (APP_THEME == "OLD") {
                    $this->load->view('plused_view_agentbookings', $data);
                } else // if(APP_THEME == "LTE")
                {
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/agents/account_manager/view_agent_bookings', $data);
                }
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents/dashboard', 'refresh');
        }
    }

    public function invoice_pdf($id) {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $id);
            if ($ismine) {
                $data['booking_detail'] = $this->mbackoffice->get_booking_detail($id);
                $data['booking_acc'] = $this->mbackoffice->getBookAccomodations($id);
                $idagenzia = $data['booking_detail'][0]['id_agente'];
                $data['agency'] = $this->mbackoffice->agent_detail($idagenzia);
                $this->load->plugin('to_pdf');
                $html = $this->load->view('PDF_deposit_invoice', $data, true);
                pdf_create($html, 'deposit_invoice_' . $data['booking_detail'][0]['id_year'] . '_' . $data['booking_detail'][0]['id_book']);
            } else {
                redirect('agents', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function invoice_pdf_no_acconto($id) {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $id);
            if ($ismine) {
                $this->mbackoffice->set_first_print($id);
                $data['booking_detail'] = $this->mbackoffice->get_booking_detail($id);
                $data['booking_acc'] = $this->mbackoffice->getBookAccomodations($id);
                $idagenzia = $data['booking_detail'][0]['id_agente'];
                $data['agency'] = $this->mbackoffice->agent_detail($idagenzia);
                $this->load->plugin('to_pdf');
                $html = $this->load->view('PDF_deposit_invoice_no_acconto', $data, true);
                pdf_create($html, 'deposit_invoice_' . $data['booking_detail'][0]['id_year'] . '_' . $data['booking_detail'][0]['id_book']);
            } else {
                redirect('agents', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function invoice_pdf_no_saldo($id) {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $this->mbackoffice->set_second_print($id);
            $data['booking_detail'] = $this->mbackoffice->get_booking_detail($id);
            $centro = $data['booking_detail'][0]["id_centro"];
            $settimane = $data['booking_detail'][0]["weeks"];
            $data['escursioni'] = $this->mbackoffice->get_excursions($centro, $settimane);
            $idagenzia = $data['booking_detail'][0]['id_agency'];
            $data['agency'] = $this->mbackoffice->agent_detail($idagenzia);
            $this->load->plugin('to_pdf');
            $html = $this->load->view('PDF_deposit_invoice_no_saldo', $data, true);
            pdf_create($html, 'final_invoice_' . $data['booking_detail'][0]['rand']);
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function sendmypwd() {
        $agentmail = $_POST['data'];
        $exists = $this->magenti->checkAgentExists($agentmail);
        if ($exists) {
            $dettaglioagente = $this->magenti->plused_get_ag_details($exists);
            $a_email = $dettaglioagente[0]["email"];
            $a_login = $dettaglioagente[0]["login"];
            $a_pwd = $dettaglioagente[0]["password"];
            //send emails
            //@user
            $this->load->library('email');
            $mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
            $mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
            $mymessage .= "<strong>  Dear Sir/Madam </strong><br/><br/>";
            $mymessage .= "We have received your request.<br />Please find your password and username to access your account.<br /><br />Please remember that your Account Manager is available to you for any further assistance and the helpdesk is there for any technical help.<br /><br /><strong>Username: $a_login<br />Password: $a_pwd<br />";
            $mymessage .= "<strong>Plus Sales Office</strong>" . "<br/><br/>";
            $mymessage .= "</body></html>";

            $this->email->from('info@plus-ed.com', 'Plus Sales Office');
            $this->email->to($a_email);
            $this->email->bcc('smarra@plus-ed.com, a.kavak@plus-ed.com');
            $this->email->subject('Plus Sales Office - Password request.');
            $this->email->message($mymessage);
            $this->email->send();
            echo "Your request has been processed, you will receive your password as soon as possible!";
        } else {
            echo "Error! Please contact us @plus-ed.com";
        }
    }

    public function updateProductsAgent($agent) {
        if ($this->session->userdata('role') == 98) {
            $ismine = $this->magenti->checkAgentAccount($agent, $this->session->userdata('id'));
            if ($ismine) {
                $this->magenti->clearDOIAgents($agent);
                foreach ($_POST as $key => $value) {
                    if (intval(strpos($key, "oi_")) > 0) {
                        $campi = explode("_", $key);
                        $idcampus = $campi[2];
                        $this->magenti->setDOIAgents($agent, $idcampus);
                    }
                }
                redirect('agents/manageAgent/' . $agent, 'refresh');
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents/dashboard', 'refresh');
        }
    }

    public function insertProfileAgent() {
        $data['title'] = "plus-ed.com | Registration confirmed";
        $data['breadcrumb1'] = 'Registration confirmed';
        $data['breadcrumb2'] = '';
        $business_name = $this->input->post('business_name');
        $address = $this->input->post('businessaddress');
        $postal_code = $this->input->post('businesspostalcode');
        $city = $this->input->post('businesscity');
        $country = $this->input->post('country');
        $email = $this->input->post('email');
        $phone = $this->input->post('businesstelephone');
        $firstname = $this->input->post('mainfirstname');
        $familyname = $this->input->post('mainfamilyname');
        $mobilephone = $this->input->post('mobilephone');
        $skypename = $this->input->post('skypename');
        $origin = $this->input->post('origin');
        $statuscrm = $this->input->post('statuscrm');
        $accountm = $this->session->userdata('id');
        if ($this->Magenti->plused_verify_mail($email)) {
            //Insert user and related procedures
            $idAgente = $this->magenti->plused_insertProspect($business_name, $address, $postal_code, $city, $country, $email, $phone, $firstname, $familyname, $mobilephone, $skypename, $origin, $statuscrm, $accountm);
            //send emails
            //@user
            $this->load->library('email');
            //@plused
            $emailplus = "info@plus-ed.com";
            $mymessage2 = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
            $mymessage2 .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
            $mymessage2 .= "<strong>  $business_name has been registered @vision by an account manager</strong><br/><br/>";
            $mymessage2 .= "<ul>";
            $mymessage2 .= "<li><strong>Business name: </strong>$business_name</li>";
            $mymessage2 .= "<li><strong>Address: </strong>$address - $postal_code $city</li>";
            $mymessage2 .= "<li><strong>Country: </strong>$country</li>";
            $mymessage2 .= "<li><strong>Name: </strong>$firstname $familyname</li>";
            $mymessage2 .= "<li><strong>Email: </strong>$email</li>";
            $mymessage2 .= "<li><strong>Phone: </strong>$phone</li>";
            $mymessage2 .= "</ul><br /><br /><br />";
            $mymessage2 .= "</body></html>";

            $this->email->from('info@plus-ed.com', 'Plus Sales Office');
            $this->email->to($emailplus);
            $this->email->subject('Plus Sales Office - New prospect registration @vision.');
            $this->email->message($mymessage2);
            $this->email->send();
            redirect('agents/manageAgent/' . $idAgente, 'refresh');
        } else {
            //Duplicated email
            $this->session->set_flashdata('come_from_insert_pro', 'mailko');
            redirect('agents/insertAgent', 'refresh');
        }
    }

    public function insertChat($agent) {
        if ($this->session->userdata('role') == 98) {
            $ismine = $this->magenti->checkAgentAccount($agent, $this->session->userdata('id'));
            if ($ismine) {
                $ch_messagetext = $this->input->post('ch_messagetext');
                $ch_datetime = $this->input->post('ch_datetime');
                $ch_type = $this->input->post('ch_type');
                $ch_from_am = $this->input->post('ch_from_am');
                $ch_category = $this->input->post('ch_category');
                $this->magenti->plused_insertChat($agent, $this->session->userdata('id'), $ch_messagetext, $ch_datetime, $ch_type, $ch_from_am, $ch_category);
                redirect('agents/viewChatHistory/' . $agent . '/' . $ch_category, 'refresh');
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents/dashboard', 'refresh');
        }
    }

    public function insertReminder($agent) {
        if ($this->session->userdata('role') == 98) {
            $ismine = $this->magenti->checkAgentAccount($agent, $this->session->userdata('id'));
            if ($ismine) {
                $rem_messagetext = $this->input->post('rem_messagetext');
                $rem_datetime = $this->input->post('rem_datetime');
                $rem_type = $this->input->post('rem_type');
                $this->magenti->plused_insertReminder($agent, $this->session->userdata('id'), $rem_messagetext, $rem_datetime, $rem_type);
                redirect('agents/listAgents', 'refresh');
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents/dashboard', 'refresh');
        }
    }

    public function completeReminder() {
        if ($this->session->userdata('role') == 98) {
            $ismine = $this->magenti->completeReminder($this->session->userdata('id'), $this->input->post('idremi'));
        }
    }

    public function viewOrganizer($anno) {
        if ($this->session->userdata('role') == 98) {
            $data['title'] = 'plus-ed.com | View organizer';
            $data['breadcrumb1'] = 'CRM module';
            $data['breadcrumb2'] = 'View organizer';
            $data['annoAttuale'] = $anno;
            for ($mese = 1; $mese <= 12; $mese++) {
                $data['remindme'][$mese] = $this->magenti->getAllYearRemindersByAM($this->session->userdata('id'), $mese, $anno);
            }

            if (APP_THEME == "OLD") {
                $this->load->view('plused_view_organizer', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/account_manager/view_organizer', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents/dashboard', 'refresh');
        }
    }

    public function editPaxList($anno, $id) {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $id);
            if ($ismine) {
                $data['title'] = 'plus-ed.com | Edit pax list';
                $data['breadcrumb1'] = 'Bookings review';
                $data['booking_detail'] = $this->mbackoffice->get_booking_detail($id);
                $data['breadcrumb2'] = 'Pax list for Booking ' . $data['booking_detail'][0]["id_year"] . "_" . $data['booking_detail'][0]["id_book"];
                $statoO = $data['booking_detail'][0]['status'];
                if ("confirmed" == $statoO) {
                    $data['booking_acc'] = $this->mbackoffice->getBookAccomodations($id);
                    $idagenzia = $data['booking_detail'][0]['id_agente'];
                    $data['agency'] = $this->mbackoffice->agent_detail($idagenzia);
                    $data['paxs'] = $this->magenti->getRowsByBookId($id);
                    $data['anno'] = $anno;
                    $data['bookId'] = $id;
                    $centriArr = $this->magenti->getCampusByBookId($id);
                    $data['courseDetails'] = $this->magenti->getCourseList($centriArr[0]['id_centro']);

                    if (APP_THEME == "OLD") {
                        $this->load->view('plused_edit_pax', $data);
                    } else {
                        $this->load->view('lte/agents/ajax_edit_pax', $data);
                    }
                } else {
                    redirect('agents/dashboard', 'refresh');
                }
            } else {
                $this->session->sess_destroy();
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    public function searchAP() {
        if ($this->session->userdata('role') == 99) {
            $this->magenti->searchAP();
        }
    }

    public function postaPax($id) {

//    ini_set('max_input_vars', '3000');
        //    ini_set('suhosin.post.max_vars', '3000');
        //    ini_set('suhosin.request.max_vars', '3000');

        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $id);
            $isLocked = $this->magenti->getLockPaxByBookId($id);
            if ($ismine and 0 == $isLocked) {
                $updatePAX = $this->magenti->postaPax($id);
                if ("SEND" == $_POST["noChanges"]) {
                    $year = $this->mbackoffice->yearIdByBookingId($id);
                    $this->load->library('email');
                    $a_email = "campus@plus-ed.com";
                    $cc_email = "operations@plus-ed.com, a.kavak@plus-ed.com, michael.hollinshead@plus-ed.com";
                    $bcc_email = "a.sudetti@gmail.com";
                    $mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
                    $mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
                    $mymessage .= "<strong>  Please pay your attention to the booking " . $year . "_" . $id . "</strong><br />The roster has been locked by the agent.<br/><br/>";
                    $mymessage .= "<strong>Plus Sales Office</strong>" . "<br/><br/>";
                    $mymessage .= "</body></html>";

                    $this->email->from('info@plus-ed.com', 'Plus Sales Office');
                    $this->email->to($a_email);
                    $this->email->cc($cc_email);
                    $this->email->bcc($bcc_email);
                    $this->email->subject('Plus Sales Office - Roster locked for booking ' . $year . "_" . $id);
                    $this->email->message($mymessage);
                    $this->email->send();
                }

                redirect('agents/insertedBookings', 'refresh');
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function bookExtraNow($id, $campusId, $year) {
        if ($this->session->userdata('username')) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $id);
            if ($ismine) {
                $data["glNum"] = $this->magenti->getRowsNumByBookId($id, "GL");
                $data["stdNum"] = $this->magenti->getRowsNumByBookId($id, "STD");
                $data["allNum"] = $data["glNum"] * 1 + $data["stdNum"] * 1;
                $data["groupleaders"] = $this->magenti->getGlByBookingId($id);
                $data["excursions"] = $this->magenti->getExtraExcbyCampusId($campusId);
                $data["bookId"] = $id;
                $data["agentId"] = $this->session->userdata('id');
                $data["bookYear"] = $year;
                $data["campusId"] = $campusId;
                $data["campusName"] = $this->magenti->centerNameById($campusId);
                $data["excursionsBooked"] = $this->magenti->getBookedExcursionsByBkId($year . "_" . $id, "extra");
                $data['title'] = 'plus-ed.com | Book extra excursion';
                $data['breadcrumb1'] = 'Extra excursions';
                $data['breadcrumb2'] = 'Book extra excursions';

                if (APP_THEME == "OLD") {
                    $this->load->view('plused_book_extra_now', $data);
                } else // if(APP_THEME == "LTE")
                {
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/agents/book_extra_now', $data);
                }
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function viewExtraNow($id, $campusId, $year) {
        if ($this->session->userdata('username')) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $id);
            if ($ismine) {
                $data["glNum"] = $this->magenti->getRowsNumByBookId($id, "GL");
                $data["stdNum"] = $this->magenti->getRowsNumByBookId($id, "STD");
                $data["allNum"] = $data["glNum"] * 1 + $data["stdNum"] * 1;
                $data["groupleaders"] = $this->magenti->getGlByBookingId($id);
                $data["excursions"] = $this->magenti->getExtraExcbyCampusId($campusId);
                $data["bookId"] = $id;
                $data["bookYear"] = $year;
                $data["campusId"] = $campusId;
                $data["campusName"] = $this->magenti->centerNameById($campusId);
                $data["excursionsBooked"] = $this->magenti->getBookedExcursionsByBkId($year . "_" . $id, "extra");
                $data['title'] = 'plus-ed.com | View extra excursion';
                $data['breadcrumb1'] = 'Extra excursions';
                $data['breadcrumb2'] = 'View extra excursions';

                if (APP_THEME == "OLD") {
                    $this->load->view('plused_view_extra_now', $data);
                } else // if(APP_THEME == "LTE")
                {
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/agents/view_extra_now', $data);
                }
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function retrieveStudentsByGl($id) {
        if ($this->session->userdata('role') == 99) {
            $this->magenti->retrieveStudentsByGl($id);
        }
    }

    public function bestBusPriceForExcursion($idExc, $minPax, $stdPax) {
        if ($this->session->userdata('role') == 99 || $this->session->userdata('role') == 200 || $this->session->userdata('role') == 553) {
            //$busPrice = explode("___",$this->magenti->bestBusPriceForExcursion($idExc,$minPax,$stdPax));
            //echo "<p><b>Price per pax (only Students): <font style='color:#f00;'>$busPrice[1] $busPrice[2]</font></b></p>";
            echo $this->magenti->bestBusPriceForExcursion($idExc, $minPax, $stdPax);
        }
    }

    public function insertTestataExcursion($id) {
        if ($this->session->userdata('role') == 99) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $id);
            if ($ismine) {
                $book_id = $this->input->post('passBKID');
                $campus_id = $this->input->post('passCAMPUS');
                $exc_id = $this->input->post('passEE');
                $exc_type = $this->input->post('passTYPE');
                $num_pax = count($this->input->post('uuidpax'));
                $price = $this->input->post('passPRICESTD');
                $num_std = $this->input->post('passNUMSTD');
                $currency = $this->input->post('passCURRENCY');
                $this->magenti->insertTestataExcursion($exc_type, $campus_id, $exc_id, $book_id, $num_pax, $price, $num_std, $currency);
                $lastTestataid = $this->db->insert_id();
                foreach ($this->input->post('uuidpax') as $uniid) {
                    $this->magenti->insertRigaExcursion($uniid, $lastTestataid, $exc_type);
                }
                $splittaBook = explode("_", $book_id);
                redirect('agents/bookExtraNow/' . $splittaBook[1] . '/' . $campus_id . '/' . $splittaBook[0], 'refresh');
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents/dashboard', 'refresh');
        }
    }

    public function removeAllExcursions($id_exc, $id_book, $id_campus, $id_year) {
        if ($this->session->userdata('role') == 99) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $id_book);
            if ($ismine) {
                $isExcOf = $this->magenti->checkExcInBk($id_exc, $id_year . "_" . $id_book);
                if ($isExcOf) {
                    $removeAllExcursions = $this->magenti->removeAllExcursions($id_exc);
                    redirect('agents/bookExtraNow/' . $id_book . '/' . $id_campus . '/' . $id_year, 'refresh');
                } else {
                    redirect('agents/dashboard', 'refresh');
                }
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function getAllExcursionsPaxFromExcID($id_exc, $id_book, $id_campus, $id_year) {
        if ($this->session->userdata('role') == 99) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $id_book);
            if ($ismine) {
                $isExcOf = $this->magenti->checkExcInBk($id_exc, $id_year . "_" . $id_book);
                if ($isExcOf) {
                    $data["all_all"] = $this->magenti->getAllExcursionsPaxFromExcID($id_exc);
                    if (APP_THEME == 'OLD') {
                        $this->load->view('plused_detAllExc', $data);
                    } else {
                        $this->load->view('lte/agents/ajax_det_all_excursion', $data);
                    }
                } else {
                    redirect('agents/dashboard', 'refresh');
                }
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function viewAttractions() {
        //if ($this->session->userdata('role') == 99) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["campus"] = $this->mbackoffice->getAllAttractions();
            $data['title'] = 'plus-ed.com | View attractions';
            $data['breadcrumb1'] = 'Attractions and entrances';
            $data['breadcrumb2'] = 'View attractions';

            if (APP_THEME == "OLD") {
                $this->load->view('plused_viewAttractions', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/view_attractions', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function viewBookedAttractions() {
        //if ($this->session->userdata('role') == 99) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["allAtt"] = $this->magenti->getAllAgentAttractions($this->session->userdata('id'));
            $data['title'] = 'plus-ed.com | View attractions';
            $data['breadcrumb1'] = 'Attractions and entrances';
            $data['breadcrumb2'] = 'View booked attractions';

            if (APP_THEME == "OLD") {
                $this->load->view('plused_viewBookedAttractions', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/view_booked_attractions', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function viewAttractionDetail($idA) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["attraction"] = $this->magenti->agentAttractionById($idA);
            $data['title'] = 'plus-ed.com | View attraction detail';
            $data['breadcrumb1'] = 'Attractions and entrances';
            $data['breadcrumb2'] = 'View attractions detail';
            $data['viewBook'] = 0;
            $data['idA'] = $idA;
            //if($this->session->userdata('email')=="a.sudetti@gmail.com"){
            $data['viewBook'] = 1;
            //}
            $data["all_books"] = $this->magenti->getBookingsByAgent($this->session->userdata('id'), 'confirmed');

            if (APP_THEME == "OLD") {
                $this->load->view('plused_viewAttractionDetail', $data);
            } else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/view_attraction_detail', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function bookAttractionNow() {
        if ($this->session->userdata('username')) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $this->input->post('hidIdBook'));
            if ($ismine) {
                $id_year = $this->input->post('hidIdYear');
                $id_book = $this->input->post('hidIdBook');
                $id_attr = $this->input->post('hidIdAtt');
                $id_campus = $this->input->post('hidIdCampus');
                $glNum = $this->magenti->getRowsNumByBookId($id_book, "GL");
                $stdNum = $this->magenti->getRowsNumByBookId($id_book, "STD");
                $allNum = $glNum * 1 + $stdNum * 1;
                $attraction = $this->magenti->agentAttractionById($id_attr);
                $attOk = $attraction[0];
                $cur_id = $attOk["pat_currency_id"];
                $GLprice = str_replace(",", ".", $attOk["pat_adult_price"]) * 1;
                $STDprice = str_replace(",", ".", $attOk["pat_student_price"]) * 1 * $allNum;
                $this->magenti->bookAttractionNow($id_book, $id_year, $id_attr, $id_campus, $allNum, $STDprice, $cur_id);
                redirect('agents/viewBookedAttractions', 'refresh');
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function remBookAttraction($atbId, $bookId) {
        if ($this->session->userdata('role') == 99) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $bookId);
            if ($ismine) {
                $cmsDelBusExc = $this->magenti->remBookAttraction($atbId, $bookId);
                $this->session->set_flashdata('success_message', 'Attraction removed successfully.');
                redirect('agents/viewBookedAttractions', 'refresh');
            } else {
                echo "ERROR!";
                die();
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function PDF_BookAttraction($idAtb, $idBook) {
        if ($this->session->userdata('role') == 99) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $idBook);
            if ($ismine) {
                $data['detAtt'] = $this->magenti->getAttractionDetailById($idAtb);
                $data['agency'] = $this->mbackoffice->agent_detail($this->session->userdata('id'));
                $data['booking_detail'] = $this->mbackoffice->get_booking_detail($idBook);
                $this->load->plugin('to_pdf');
                $html = $this->load->view('PDF_attraction_invoice', $data, true);
                pdf_create($html, 'pdf_attraction_invoice_' . $idAtb . '_' . $idBook);
            } else {
                echo "ERROR2!";
                die();
            }
        } else {
            echo "ERROR3!";
            die();
        }
    }

    public function printProFormaById($idTraExc, $idBook, $idCampus, $year) {
        if ($this->session->userdata('role') == 99) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $idBook);
            if ($ismine) {
                $data['detExc'] = $this->magenti->getExtraExcDetailById($idTraExc);
                //print_r($data['detExc']);
                //die();
                $arrbkid = explode("_", $data["detExc"][0]["pte_book_id"]);
                $myBkId = $arrbkid[1];
                if ($myBkId == $idBook) {
                    $data['booking_detail'] = $this->mbackoffice->get_booking_detail($idBook);
                    $idagenzia = $data['booking_detail'][0]['id_agente'];
                    $data['agency'] = $this->mbackoffice->agent_detail($idagenzia);
                    //print_r($data['booking_detail']);
                    //die();
                    $this->load->plugin('to_pdf');
                    $html = $this->load->view('PDF_extra_excursion_invoice', $data, true);
                    pdf_create($html, 'pdf_extra_excursion_invoice_' . $idTraExc . '_' . $book . '_' . $year);
                } else {
                    echo "ERROR1!";
                    die();
                }
            } else {
                echo "ERROR2!";
                die();
            }
        } else {
            echo "ERROR3!";
            die();
        }
    }

    public function pdf_visas($id) {
        if ($this->session->userdata('role') == 99) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $id);
            $dwnVisa = $this->magenti->getDwnVisaByBookId($id);
            if (0 == $dwnVisa) {
                echo "ERROR - VISA NOT AVAILABLE";
                die();
            }
            if ($ismine) {
                $data['booking_detail'] = $this->mbackoffice->get_booking_detail($id);
                $idagenzia = $data['booking_detail'][0]['id_agente'];
                $located = $data['booking_detail'][0]['valuta_fattura'];
                $year = $data['booking_detail'][0]['id_year'];
                $data['agency'] = $this->mbackoffice->agent_detail($this->session->userdata('id'));
                $data['detSTD'] = $this->mbackoffice->listPax($id, "STD");
                $data['detGL'] = $this->mbackoffice->listPax($id, "GL");
                $this->load->plugin('to_pdf');
                if ("USA" == $located) {
                    $html = $this->load->view('PDF_visas_USA', $data, true);
                } else {
                    $html = $this->load->view('PDF_visas_GBP', $data, true);
                }
                pdf_create($html, 'PDF_VISAS_' . $data['booking_detail'][0]['id_year'] . '_' . $data['booking_detail'][0]['id_book'] . '__' . date("U"));
            } else {
                redirect('agents', 'refresh');
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

/**
 * Start: functions by Arunsankar S
 * @since 13 Apr 2016
 * @modified 14-Apr-2016
 * @modified_by Arunsankar
 */
    public function bookingExists() {
        if ($this->session->userdata('role') == 99) {
            $id_book = isset($_POST['bookId']) ? $_POST['bookId'] : '';
            $bkgExists = 0;
            $bkgExists = $this->magenti->bookingExists($id_book);
            echo $bkgExists;
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function for show popup of visa details
     */
    public function getVisaPopupDetails($idBook = '', $pill = "a") {
        if (($this->session->userdata('role') == 99) && !empty($idBook) && is_numeric($idBook)) {
            $data["title"] = "New availability";
            $NA_bookDet = $this->magenti->getBookDet($idBook);
            $campus = $NA_bookDet[0]->id_centro;
            $datein = $NA_bookDet[0]->mindatein;
            $dateout = $NA_bookDet[0]->maxdateout;
            $dateInterval = (strtotime($dateout) - strtotime($datein)) / 60 / 60 / 24;
            $addedDays = 30 - $dateInterval;
            $startingDays = floor($addedDays / 2);
            $endingDays = $addedDays - $startingDays;
            $datecycleIn = date("Y-m-d", strtotime("-" . $startingDays . " day", strtotime($datein)));
            $datecycleOut = date("Y-m-d", strtotime("+" . $endingDays . " day", strtotime($dateout)));
            $data["datein"] = $datecycleIn;
            $data["dateout"] = $datecycleOut;

            $idAg = $this->magenti->agentIdByBkId($idBook);
            $data['agente'] = $this->magenti->agent_detail($idAg);
            $data['book'] = $this->magenti->overviewSingleBooking($idBook);
            $data['templates'] = $this->magenti->getTemplateListNatMapped($data['book'][0]['id_centro']);
            if (795 == $data['book'][0]["id_agente"]) {
                $data["bkStudyOvernight"] = $this->magenti->getUnjoinedSTBookings($data['book'][0]["arrival_date"]);
            }
            $data['detMyPax'] = $this->magenti->detMyPaxForRosterBackoffice($data['book'][0]["id_year"], $idBook);
            $data['payments'] = $this->magenti->paymentsById($idBook);
            $data['payTypes'] = $this->magenti->getAllPaymentTypes();
            $data['payServices'] = $this->magenti->getAllPaymentServices();
            $data['hasRoster'] = $this->magenti->count_pax_uploaded($idBook);
            $data['pill'] = $pill;
            $data['insertNote'] = $this->magenti->readBookingNotes($idBook, 0);

            if (APP_THEME == "OLD") {
                $this->load->view('visa/overview_visa_details', $data);
            } else {
                $this->load->view('lte/agents/visa/overview_visa_details', $data);
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function for lock roster
     * @author Arunsankar
     * @since 13/04/2016
     * @modified 14/04/2016
     * @modified_by Arunsankar
     */
    public function lockSingleRoster() {
        if ($this->session->userdata('role') == 99) {
            $status = '0';
            $html = '';
            $res = array();
            $rowId = $this->input->post('rowId');
            $centroId = $this->input->post('centroId');
            if (!empty($rowId) && is_numeric($rowId)) {
                $bookId = $this->magenti->getBookId($rowId);
                $isLock = $this->magenti->lockSingleRoster($rowId);
                $data['templates'] = $this->magenti->getTemplateList($centroId);
                if ('2' === $isLock) {
                    $status = '2';
                } elseif ($isLock) {
                    $status = '1';
                    $mapError = 0;
                    $html .= '<select style="width: 77px" class="tempSel" id="selTemp_' . $rowId . '" ><option value="">Select</option>';
                    if ($data['templates']) {
                        foreach ($data['templates'] as $template) {
                            $tempTitle = '';
                            if ('UKIR' == $template['template']) {
                                $tempTitle = 'UK/Ireland';
                            }
                            if ('USA' == $template['template']) {
                                $tempTitle = 'USA';
                            }
                            if ('MAL' == $template['template']) {
                                $tempTitle = 'Malta';
                            }
                            if ('UKIRGLSTD' == $template['template']) {
                                $tempTitle = 'UK/Ireland - GL Standard';
                            }
                            if ('UKIRSTDSTD' == $template['template']) {
                                $tempTitle = 'UK/Ireland - STD Standard';
                            }
                            if ('UKIRSTDST' == $template['template']) {
                                $tempTitle = 'UK/Ireland - STD Short Term';
                            }
                            $isNationality = $this->magenti->checkNationality($bookId, $template['template'], $rowId);
                            if ($isNationality) {
                                $html .= '<option value="' . $template['template'] . '">' . $tempTitle . '</option>';
                                $mapError += 1;
                            }
                        }
                        $html .= '</select>';
                        if (0 == $mapError) {
                            $html = '<select  style="width: 77px"><option value="">NA</option></select>';
                        }
                    } else {
                        $status = '3';
                        $html = '<select style="width: 77px"><option value="">NA</option></select>';
                    }
                } else {
                    $status = '0';
                }
            } else {
                $status = '0';
            }
            echo json_encode(array(
                'status' => $status,
                'result' => $html,
            ));
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function for lock whole roster
     * @author Arunsankar
     * @since 13/04/2016
     * @modified 14/04/2016
     * @modified_by Arunsankar
     */
    public function lockWholeRoster() {
        $status = 0;
        $result = array();
        $templ = array();
        if ($this->session->userdata('role') == 99) {
            $bookId = $this->input->post('bookId');
            $yearId = $this->input->post('yearId');
            $centroId = $this->input->post('centroId');
            if (!empty($bookId) && is_numeric($bookId)) {
                $isLock = $this->magenti->lockWholeRoster($bookId, $yearId);
                $templ = $this->magenti->getTemplateList($centroId);
                if ('2' === $isLock['status']) {
                    $status = '2';
                } elseif ('1' === $isLock['status']) {
                    $status = '1';
                    $result = $isLock['result'];
                } else {
                    $status = '0';
                }
            } else {
                $status = '0';
            }
        } else {
            redirect('agents', 'refresh');
        }
        echo json_encode(array(
            'status' => $status,
            'result' => $result,
            'templ' => $templ,
        ));
    }

    /**
     * function to print visas for all locked pax
     * @param int $id
     * @author Arunsankar
     * @since 14-Apr-2016
     * @modified 19-May-2016
     * @modified_by Arunsankar
     */
    public function pdfLockedVisas($id = '') {
        set_time_limit(300);
        if ($this->session->userdata('role') == 99) {
            $uri = func_get_args();
            $uriNew = array();
            $data['locked'] = $this->magenti->checkBookLocked($id);
            $bookArr = array();
            if ('locked' == $data['locked']) {
                $bookArr = explode('-', $uri[0]);
            }
            $isBookTemplate = true;
            if (!empty($bookArr)) {
                if (isset($bookArr[0]) && isset($bookArr[1])) {
                    $isBookTemplate = $this->magenti->checkBookTemplate($bookArr[0], $bookArr[1]);
                }
            }
            if (!$isBookTemplate) {
                echo "ERROR - VISA NOT AVAILABLE";
                die();
            }
            $data['uriArray'] = array();
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $id);
            $dwnVisa = $this->magenti->getDwnVisaByLock($id);
            if (!$dwnVisa || !$id) {
                echo "ERROR - VISA NOT AVAILABLE";
                die();
            }
            $uriCnt = 0;
            if (isset($uri[1])) {
                foreach ($uri as $k => $v) {
                    $splVal = explode('-', $v);
                    if ($uriCnt > 0) {
                        $data['uriArray'][$splVal[0]] = $splVal[1];
                    }
                    $uriCnt += 1;
                }
            }
            if ($ismine) {
                $data['booking_detail'] = $this->magenti->get_booking_detail($id);
                $bookId = '';
                if (!empty($data['booking_detail'])) {
                    $bookId = $data['booking_detail'][0]['id_book'];
                }
                foreach ($data['uriArray'] as $key => $uriEach) {
                    $isNationality = $this->magenti->checkNationality($bookId, $uriEach, $key);
                    if (!$isNationality) {
                        echo "ERROR - VISA NOT AVAILABLE";
                        die();
                    }
                    $this->magenti->lockTemplate($key, $uriEach);
                    $checkLockTemplate = $this->magenti->checkLockTemplate($uriEach, $key, $bookId);
                    if (!$checkLockTemplate) {
                        echo "ERROR - VISA NOT AVAILABLE";
                        die();
                    }
                }
                $data['initTemp'] = isset($bookArr[1]) ? $bookArr[1] : '';
                $data['locked'] = $this->magenti->checkBookLocked($id);
                $idagenzia = $data['booking_detail'][0]['id_agente'];
                $located = $data['booking_detail'][0]['valuta_fattura'];
                $year = $data['booking_detail'][0]['id_year'];
                $isWholeLock = 1 == $data['booking_detail'][0]['lockPax'] ? null : 1;
                $data['agency'] = $this->magenti->agent_detail($this->session->userdata('id'));
                $data['detSTD'] = $this->magenti->listPax($id, "STD", $isWholeLock);
                $data['detGL'] = $this->magenti->listPax($id, "GL", $isWholeLock);
                $this->load->plugin('to_pdf');
                if (isset($uri[1])) {
                    $html = $this->load->view('visa/PDF_visas_lock', $data, true);
                } else {
                    redirect('agents', 'refresh');
                }
                pdf_create($html, 'PDF_VISAS_' . $data['booking_detail'][0]['id_year'] . '_' . $data['booking_detail'][0]['id_book'] . '__' . date("U"));
            } else {
                redirect('agents', 'refresh');
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * function to print single locked visa
     * @param int $id
     * @param int $book
     * @author Arunsankar
     * @since 14-Apr-2016
     * @modified 19-May-2016
     * @modified_by Arunsankar
     */
    public function pdfSingleVisa($id, $book, $template = null) {
        if ($this->session->userdata('role') == 99) {
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $book);
            $dwnVisa = $this->magenti->getSngVisaByLock($id, $book);
            $checkNationality = $this->magenti->checkNationality($book, $template, $id);
            $checkLockTemplate = $this->magenti->checkLockTemplate($template, $id, $book);
            if (!$dwnVisa || !$template || ('UKIR' != $template && 'USA' != $template && 'MAL' != $template && 'UKIRGLSTD' != $template && 'UKIRSTDSTD' != $template && 'UKIRSTDST' != $template)) {
                echo "ERROR - VISA NOT AVAILABLE";
                die();
            }
            if ($template) {
                $isValidTemplate = $this->magenti->checkValidTemplate($template, $book);
                if (!$isValidTemplate) {
                    echo "ERROR - VISA NOT AVAILABLE";
                    die();
                }
            }
            if (!$checkNationality) {
                echo "ERROR - VISA NOT AVAILABLE";
                die();
            }
            if (!$checkLockTemplate) {
                echo "ERROR - VISA NOT AVAILABLE";
                die();
            }
            if ($ismine) {
                $data['booking_detail'] = $this->magenti->get_booking_detail($book);
                $idagenzia = $data['booking_detail'][0]['id_agente'];
                $located = $data['booking_detail'][0]['valuta_fattura'];
                $year = $data['booking_detail'][0]['id_year'];
                $data['agency'] = $this->magenti->agent_detail($this->session->userdata('id'));
                $data['det'] = $this->magenti->listSinglePax($id);
                $this->load->plugin('to_pdf');
                if ('MAL' == $template) {
                    $data['detSTD'] = $data['det'];
                    $html = $this->load->view('visa/PDF_visas_' . $template, $data, true);
                } else {
                    $html = $this->load->view('visa/PDF_single_' . $template, $data, true);
                }
                pdf_create($html, 'PDF_VISAS_' . $data['booking_detail'][0]['id_year'] . '_' . $data['booking_detail'][0]['id_book'] . '__' . date("U"));
            } else {
                redirect('agents', 'refresh');
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function to check the booking is locked
     * @author Arunsankar
     */
    public function checkPaxLock() {
        if ($this->session->userdata('role') == 99) {
            $bookId = $this->input->post('bookId');
            $yearId = $this->input->post('yearId');
            $isLocked = $this->magenti->checkPaxLock($yearId, $bookId);
            if (!$isLocked) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function to check if any of the pax from the booking is locked
     * @author Arunsankar
     */
    public function checkAnyPaxLocked() {
        if ($this->session->userdata('role') == 99) {
            $bookId = $this->input->post('bookId');
            $isLocked = $this->magenti->checkAnyPaxLocked($bookId);
            if ($isLocked) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function to check template is mapped with selected pax
     * @author Arunsankar
     */
    public function checkMappedTemplate() {
        if ($this->session->userdata('role') == 99) {
            $bookId = $this->input->post('bookId');
            $rowIds = explode('/', $this->input->post('rowIds'));
            $error = 0;
            if ($rowIds) {
                foreach ($rowIds as $rowId) {
                    $rowIdArr = explode('-', $rowId);
                    $id = $rowIdArr[0];
                    $template = isset($rowIdArr[1]) ? $rowIdArr[1] : '';
                    if ($template) {
                        $isNationalityMatch = $this->magenti->checkNationality($bookId, $template, $id);
                        if (!$isNationalityMatch) {
                            $error += 1;
                        }
                    }
                }
            } else {
                $error += 1;
            }
            if (0 == $error) {
                foreach ($rowIds as $rowId) {
                    $rowIdArr = explode('-', $rowId);
                    $id = $rowIdArr[0];
                    $template = isset($rowIdArr[1]) ? $rowIdArr[1] : '';
                }
                $isMapped = $this->magenti->checkMappedTemplate($bookId);
                if ($isMapped) {
                    echo '1';
                } else {
                    echo '0';
                }
            } else {
                echo '2';
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function to show the popup for print visa for locked pax
     * @author Arunsankar
     */
    public function visaLockedTemplate($bookId) {
        if ($this->session->userdata('role') == 99) {
            $centriId = $this->magenti->getCentriId($bookId);
            $rowIdsNoSel = func_get_args();
            $data['bookId'] = $bookId;
            $data['locked'] = $this->magenti->checkBookLocked($bookId);
            $data['book'] = $this->magenti->overviewSingleBooking($bookId);
            $data['detMyPax'] = $this->magenti->detMyPaxForRosterBackofficeLock($data['book'][0]["id_year"], $bookId, $rowIdsNoSel);
            $data['detMyPaxFir'] = $this->magenti->detMyPaxForRosterBackoffice($data['book'][0]["id_year"], $bookId);
            $data['templates'] = '';
            $data['lockedPaxes'] = '';
            if ($centriId) {
                $data['templates'] = $this->magenti->getTemplateListNatMapped($centriId);
                $data['lockedPaxes'] = '';
            }
            $this->load->view('visa/view_packed_template', $data);
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function to lock the selected template
     * @author Arunsankar
     */
    public function lockTemplate($rowId = null, $selValue = null) {
        if ($this->session->userdata('role') == 99) {
            $post = 0;
            if (null == $rowId || null == $selValue) {
                $rowId = $this->input->post('rowId');
                $selValue = $this->input->post('selValue');
                $post = 1;
            }
            $idBook = $this->magenti->getBookId($rowId);
            $isNationalty = $this->magenti->checkNationality($idBook, $selValue, $rowId);
            if ($isNationalty) {
                $isLocked = $this->magenti->lockTemplate($rowId, $selValue);
                if ($isLocked) {
                    if (1 == $post) {
                        echo '1';
                    } else {
                        return true;
                    }
                } else {
                    if (1 == $post) {
                        echo '0';
                    } else {
                        return false;
                    }
                }
            } else {
                if (1 == $post) {
                    echo '2';
                } else {
                    return false;
                }
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function to lock all the selected template
     * @author Arunsankar
     */
    public function lockAllTmpl() {
        if ($this->session->userdata('role') == 99) {
            $rowArr = json_decode($this->input->post('rowArr'));
            $iniTmpl = $this->input->post('iniTmpl');
            $bookId = $this->input->post('bookId');
            $error = 0;
            foreach ($rowArr as $row) {
                $rowVal = explode('-', $row);
                if (!empty($rowVal[1])) {
                    $isNationalty = $this->magenti->checkNationality($bookId, $rowVal[1], $rowVal[0]);
                    if (!$isNationalty) {
                        $error += 1;
                    }
                }
            }
            if (0 == $error) {
                $isLocked = $this->magenti->lockTemplates($bookId, $rowArr, $iniTmpl);
                if ($isLocked) {
                    echo '1';
                } else {
                    echo '0';
                }
            } else {
                echo '2';
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function to check if the given booking is locked or not
     * @author Arunsankar
     */
    public function checkBookLocked() {
        if ($this->session->userdata('role') == 99) {
            $bookId = $this->input->post('bookId');
            $isLocked = $this->magenti->checkBookLocked($bookId);
            if ('locked' == $isLocked) {
                echo '1';
            } else {
                echo '2';
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function to display the preview of pdf after select any template
     * @author Arunsankar
     */
    public function visaPDFDemo($templ = '') {
        set_time_limit(300);
        if ($this->session->userdata('role') == 99) {
            if ($templ && ('USA' == $templ || 'UKIR' == $templ || 'MAL' == $templ || 'UKIRGLSTD' == $templ || 'UKIRSTDSTD' == $templ || 'UKIRSTDST' == $templ)) {
                $data['template'] = $templ;
                $this->load->plugin('to_pdf');
                $html = $this->load->view('visa/PDF_visas_demo', $data, true);
                pdf_create($html, 'PDF_VISAS_DEMO_' . $templ);
            } else {
                redirect('agents', 'refresh');
            }
        }
    }

    /**
     * Function to check the nationalities typed in the field is valid or not
     * @author Arunsankar
     */
    public function checkTypedNationality() {
        if ($this->session->userdata('role') == 99) {
            $nationality = $this->input->post('nationality');
            $isNationalityAvailable = $this->magenti->checkTypedNationality($nationality);
            if ($isNationalityAvailable) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            redirect('agents', 'refresh');
        }
    }

    /**
     * Function for search nationality
     * @author Arunsankar
     */
    public function searchNat() {
        if ($this->session->userdata('role') == 99) {
            $this->magenti->searchNat();
        }
    }

    /**
     * Function to export pax list in agent side for offline editing
     * @author Arunsankar
     * @since 18-May-2016
     * @modified_by Arunsankar
     * @modified_on 24-June-2016
     */
    public function exportPaxForOffline($idBook) {
        if ($this->session->userdata('role') == 99) {
            set_time_limit(EXPORT_TIME_LIMIT);
            ini_set('memory_limit', EXPORT_MEM_LIMIT);
            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $idBook);
            if ($ismine) {
                $nationality = $this->magenti->getNationality();
                $data['booking_detail'] = $this->mbackoffice->get_booking_detail($idBook);
                $statoO = $data['booking_detail'][0]['status'];
                if ("confirmed" == $statoO) {
                    $this->load->library('Excel_180');
                    $data['booking_acc'] = $this->mbackoffice->getBookAccomodations($idBook);
                    $idagenzia = $data['booking_detail'][0]['id_agente'];
                    $data['agency'] = $this->mbackoffice->agent_detail($idagenzia);
                    $data['paxs'] = $this->magenti->getRowsByBookId($idBook);
                    $centriArr = $this->magenti->getCampusByBookId($idBook);
                    $data['courseDetails'] = $this->magenti->getCourseList($centriArr[0]['id_centro']);
                    $dataBook = $this->magenti->overviewSingleBooking($idBook);
                    $detMyPax = $this->magenti->detMyPaxForRosterBackoffice($dataBook[0]["id_year"], $idBook);
                    $dataArray[] = array('Type', 'Surname', 'Name', 'Sex', 'DOB Date', 'DOB Month', 'DOB Year', 'Citizenship', 'Accomodation', 'Passport no.', 'Health Info', 'Share room with', 'GL ref', '', '');
                    $counter = 1;
                    $lockRow = array();
                    foreach ($data['paxs'] as $pax) {
                        if (empty($pax["pax_dob"]) or "0000-00-00" == $pax["pax_dob"]) {
                            $pax["pax_dob"] = "1970-01-01";
                        }
                        $dataArray[] = array(
                            trim($pax["tipo_pax"], '='),
                            trim($pax["cognome"], '='),
                            trim($pax["nome"], '='),
                            trim($pax["sesso"], '='),
                            trim(date("d", strtotime($pax["pax_dob"])), '='),
                            trim(date("m", strtotime($pax["pax_dob"])), '='),
                            trim(date("Y", strtotime($pax["pax_dob"])), '='),
                            trim($pax["nazionalita"], '='),
                            trim($pax["accomodation"], '='),
                            trim($pax["numero_documento"], '='),
                            trim($pax["salute"], '='),
                            trim($pax["share_room"], '='),
                            trim($pax["gl_rif"], '='),
                            trim($pax["id_prenotazione"], '='),
                        );
                        if (1 == $pax["lockPax"]) {
                            $lockRow[] = $counter + 1;
                        }
                        $counter += 1;
                    }
                    $sheetname = $this->excel_180->getSheetByName('Worksheet') ? 'Worksheet' : 'Sheet';
                    if (is_array($dataArray) && !empty($dataArray)) {
                        $sheet = $this->excel_180->getActiveSheet();
                        $fileName = 'export_pax_' . $data['paxs'][0]["id_year"] . '_' . $idBook . '_' . time();
                        $sheet->fromArray($dataArray, null, 'A1');
                        $sheet->setCellValueByColumnAndRow('14', '1', $idBook);
                        $rowCnt = 2;
                        foreach ($nationality as $row) {
                            $sheet->setCellValueByColumnAndRow('14', $rowCnt, $row['nationality']);
                            $rowCnt += 1;
                        }
                        $nationalityCount = $rowCnt - 1;
                        for ($col = 'A'; $col <= 'K'; $col++) {
                            $sheet->getColumnDimension($col)->setAutoSize(true);
                        }
                        $sheet->getProtection()->setPassword('G8#!H#t@2ZTVEW@');
                        $sheet->getProtection()->setSheet(true);
                        for ($i = 2; $i <= $counter; $i++) {
                            if (!in_array($i, $lockRow)) {
                                $sheet->getStyle('B' . $i . ':H' . $i)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                                $sheet->getStyle('J' . $i . ':M' . $i)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                            } else {
                                //setting red color for locked cells
                                $sheet->getStyle('A' . $i . ':M' . $i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F19E9E'))));
                            }
                            $objValidation = $sheet->getCell('D' . $i)->getDataValidation();
                            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                            $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                            $objValidation->setAllowBlank(true);
                            $objValidation->setShowInputMessage(true);
                            $objValidation->setShowErrorMessage(true);
                            $objValidation->setShowDropDown(true);
                            $objValidation->setErrorTitle('Input error');
                            $objValidation->setError('Value is not in list.');
                            $objValidation->setPromptTitle('Pick from list');
                            $objValidation->setPrompt('Please pick a value from the drop-down list.');
                            $objValidation->setFormula1('"M,F"');

                            $objValidation1 = $sheet->getCell('H' . $i)->getDataValidation();
                            $objValidation1->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                            $objValidation1->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                            $objValidation1->setAllowBlank(true);
                            $objValidation1->setShowInputMessage(true);
                            $objValidation1->setShowErrorMessage(true);
                            $objValidation1->setShowDropDown(true);
                            $objValidation1->setErrorTitle('Invalid nationality');
                            $objValidation1->setError('Select nationality from the list.');
                            $objValidation1->setPromptTitle('Select Nationality');
                            $objValidation1->setPrompt('Please pick a nationality from the drop-down list.');
                            $objValidation1->setFormula1($sheetname . '!$O$2:$O$' . $nationalityCount);

                            $objValidation2 = $sheet->getCell('E' . $i)->getDataValidation();
                            $objValidation2->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                            $objValidation2->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                            $objValidation2->setAllowBlank(true);
                            $objValidation2->setShowInputMessage(true);
                            $objValidation2->setShowErrorMessage(true);
                            $objValidation2->setShowDropDown(true);
                            $objValidation2->setErrorTitle('Invalid date');
                            $objValidation2->setError('Date is not in list.');
                            $objValidation2->setPromptTitle('Select DOB date');
                            $objValidation2->setPrompt('Please pick a date from the drop-down list.');
                            $objValidation2->setFormula1('"01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31"');

                            $objValidation3 = $sheet->getCell('F' . $i)->getDataValidation();
                            $objValidation3->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                            $objValidation3->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                            $objValidation3->setAllowBlank(true);
                            $objValidation3->setShowInputMessage(true);
                            $objValidation3->setShowErrorMessage(true);
                            $objValidation3->setShowDropDown(true);
                            $objValidation3->setErrorTitle('Invalid month');
                            $objValidation3->setError('Month is not in list.');
                            $objValidation3->setPromptTitle('Select DOB month');
                            $objValidation3->setPrompt('Please pick a month from the drop-down list.');
                            $objValidation3->setFormula1('"01,02,03,04,05,06,07,08,09,10,11,12"');
                        }
                        $sheet->getColumnDimension('N')->setVisible(false);
                        $sheet->getColumnDimension('O')->setVisible(false);
                        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
                        header("Content-Type: application/vnd.ms-excel");
                        header("Content-Disposition: attachment; filename=\"" . $fileName . ".xls\"");
                        header("Cache-Control: max-age=0");
                        $writeObj = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
                        $writeObj->save("php://output");
                    } else {
                        $this->session->set_flashdata('error_message', 'No records found to export.');
                        redirect('agents/insertedBookings');
                    }
                } else {
                    $this->session->set_flashdata('error_message', 'Error occured.');
                    redirect('agents/insertedBookings');
                }
            } else {
                $this->session->set_flashdata('error_message', 'Error occured.');
                redirect('agents/insertedBookings');
            }
        }
    }

    /**
     * Function to import pax list
     * @author Arunsankar
     * @since 18-May-2016
     * @modified_by Arunsankar
     * @modified_on 07-June-2016
     */
    public function importPax() {
        if ($this->session->userdata('role') == 99) {
            $this->load->library('excel_180');
            $errorCount = 0;
            $importCount = 0;
            $invalidExcel = 0;
            if (!empty($_FILES['importPaxFile']['name'])) {
//if file is not empty
                $mimes = array('application/vnd.ms-excel', 'application/vnd.ms.excel', 'application/octet-stream', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //setting the file mime type(.xls, .xlsx)

                if (in_array($_FILES['importPaxFile']['type'], $mimes)) {
                    $fileName = $_FILES['importPaxFile']['tmp_name'];
                    try {
                        $fileType = PHPExcel_IOFactory::identify($fileName);
                        $objReader = PHPExcel_IOFactory::createReader($fileType);
                        $objPHPExcel = $objReader->load($fileName);
                        $sheets = array();
                        /* Code for validate the password added at the time of file generation for additional security
                        $password = 'G8#!H#t@2ZTVEW@';
                        $hash = $objPHPExcel -> getActiveSheet() -> getProtection() -> getPassword(); // returns a hash
                        $isValid = ($hash === PHPExcel_Shared_PasswordHasher::hashPassword($password));*/
                        $this->db->trans_start(); //begin transaction
                        $sheetcount = 1;
                        foreach ($objPHPExcel->getAllSheets() as $sheet) {
                            if (1 == $sheetcount) {
                                $sheetsarray = $sheet->toArray();
                                $bookId = isset($sheetsarray[0][14]) ? $sheetsarray[0][14] : '0';
                                unset($sheetsarray[0]);
                                foreach ($sheetsarray as $sheetVal) {
                                    if (!empty($sheetVal[0])) {
                                        if ("GL" == $sheetVal[0] || "STD" == $sheetVal[0]) {
                                            $isGender = false;
                                            $isDate = false;
                                            $isNationality = !empty($sheetVal[7]) ? $this->magenti->checkTypedNationality($sheetVal[7]) : true;
                                            $isRowValid = $this->magenti->checkPaxIsValid($sheetVal[13], $bookId);
                                            $ismine = $this->magenti->checkAgentOrder($this->session->userdata('id'), $bookId);
                                            if (sizeof($sheetVal) != 15) {
                                                $invalidExcel += 1;
                                            }
                                            if (empty($sheetVal[3]) || "M" == $sheetVal[3] || "F" == $sheetVal[3]) {
                                                $isGender = true;
                                            }
                                            if (!empty($sheetVal[4]) && !empty($sheetVal[5]) && !empty($sheetVal[6])) {
                                                if (checkdate(str_pad($sheetVal[5], 2, '0', STR_PAD_LEFT), str_pad($sheetVal[4], 2, '0', STR_PAD_LEFT), $sheetVal[6])) {
                                                    $isDate = true;
                                                    $sheetVal[4] = $sheetVal[6] . '-' . str_pad($sheetVal[5], 2, '0', STR_PAD_LEFT) . '-' . str_pad($sheetVal[4], 2, '0', STR_PAD_LEFT);
                                                }
                                            } else {
                                                $isDate = true;
                                            }
                                            if ($isGender && $isDate && $isNationality && $isRowValid && $ismine) {
//validating gender, date, nationality and row
                                                $isCount = $this->magenti->getImportPaxCount($sheetVal[13]);
                                                $isNotLocked = $this->magenti->checkPaxIsLocked($sheetVal[13]);
                                                if ($isCount && $isNotLocked) {
                                                    $isUpdate = $this->magenti->updatePaxImport($sheetVal);
                                                    if (!$isUpdate) {
                                                        @log_message('error', $sheetVal[13] . '-' . $sheetVal[0] . '-Update failed in database.');
                                                        $errorCount += 1;
                                                    } else {
                                                        $importCount += 1;
                                                    }
                                                } else {
                                                    @log_message('error', $sheetVal[13] . '-' . $sheetVal[0] . '-Record is new/locked. Failed to add.');
                                                }
                                            } else {
                                                @log_message('error', $sheetVal[13] . '-' . $sheetVal[0] . '-Gender/Date/Nationality/Row id with booking is invalid.');
                                                $errorCount += 1;
                                            }
                                        } else {
                                            @log_message('error', $sheetVal[0] . '-Type field value is invalid.');
                                            $errorCount += 1;
                                        }
                                    }
                                }
                                $sheetcount += 1;
                            }
                        }
                        if ($invalidExcel > 0) {
                            @log_message('error', 'Invalid file found.');
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('error_message', 'Invalid excel file.');
                            redirect('agents/insertedBookings');
                        } elseif ($errorCount > 0) {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('error_message', 'Failed to import.');
                            redirect('agents/insertedBookings');
                        } elseif (0 == $importCount) {
                            $this->db->trans_commit();
                            $this->session->set_flashdata('success_message', 'No changes has been made.');
                            redirect('agents/insertedBookings');
                        } else {
                            $this->db->trans_commit();
                            $this->session->set_flashdata('success_message', 'Import successful.');
                            redirect('agents/insertedBookings');
                        }
                    } catch (Exception $e) {
                        @log_message('error', 'Error occured in import.');
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('error_message', 'Failed to import.');
                        redirect('agents/insertedBookings');
                    }
                } else {
                    @log_message('error', 'Invalid file type.');
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error_message', 'Invalid file type');
                    redirect('agents/insertedBookings');
                }
            } else {
                @log_message('error', 'No file selected.');
                $this->db->trans_rollback();
                $this->session->set_flashdata('error_message', 'No file selected.');
                redirect('agents/insertedBookings');
            }
        }
    }

    public function updateBusinessName() {
        if ($this->session->userdata('role') == 98) {
            $agent = $this->input->post('agent');
            $business_name = $this->input->post('business_name');
            $this->magenti->setBusinessName($agent, $business_name);
            echo 1;
        } else {
            $this->session->sess_destroy();
            redirect('agents/dashboard', 'refresh');
        }
    }

//End: functions by Arunsankar S
    public function updateEmailAddress() {
        if ($this->session->userdata('role') == 98) {
            $agent = $this->input->post('agent');
            $email_address = $this->input->post('email_address');
            $result = $this->magenti->setEmailAddress($agent, $email_address);
            if ($result) {
                echo json_encode(array("result" => 1, "message" => "Email successfully updated"));
            } else {
                echo json_encode(array("result" => 0, "message" => "Email address already exists"));
            }
        } else {
            echo json_encode(array("result" => 0, "message" => "Session is expired"));
        }
    }

    /*Author : Arunsankar
     * Purpose: To change the transfer status for particular booking for all pax
     */
    public function updateTransferStatus() {
        if ($this->session->userdata('role') == 99) {
            $bookId = $this->input->post('bookId');
            $status = $this->input->post('status');
            $this->magenti->updateTransferStatus($bookId, $status);
            echo '1';
        } else {
            redirect('agents', 'refresh');
        }
    }
}

/* End of file agents.php */
