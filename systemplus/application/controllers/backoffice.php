<?php

class Backoffice extends Controller {

    public function __construct() {
        parent::Controller();

        $this->load->helper(array('form', 'url'));
        $this->load->helper('csv');
        $this->load->model('mbackoffice');
        $this->load->model('magenti');
        $this->load->model('gestione_centri_model');
        //$this->load->library('session','email','excel');
        $this->load->library(array('session', 'email', 'ltelayout'));
    }

    function index() {
        header('Expires: 0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        if (!$this->session->userdata('role')) {
            $this->load->helper('string');
            $data['title'] = "plus-ed.com | Login";
            if (APP_THEME == 'OLD') {
                $this->load->view('plused_login_backoffice', $data);
            } else {
                redirect('vauth/backoffice', 'refresh');
            }
        } else {
            redirect('backoffice/dashboard', 'refresh');
        }
    }

    /* function gimmeInfo(){
      phpinfo();
      } */

    function login() {
        header('Expires: 0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        session_start();
        $data['heading'] = "Check login...";
        $user = $this->input->post('login_name');
        $pwd = $this->input->post('login_pw');
        $data['results'] = $this->mbackoffice->verifyuser($user, $pwd);

        $isAdmin = 0;
        $ruoloAdmin = "";
        if ($data['results']) {
            $data['attivi'] = false;
            $data['title'] = "plus-ed.com | Dashboard";
            if ($data['results'][0]['role'] == "college_adm") {
                $newdata = array(
                    'username' => $data['results'][0]['username'],
                    'mainfirstname' => $data['results'][0]['first_name'],
                    'mainfamilyname' => $data['results'][0]['last_name'],
                    'businessname' => $data['results'][0]['first_name'],
                    'id' => $data['results'][0]['id'],
                    'email' => $data['results'][0]['email'],
                    'country' => "-",
                    'role' => 200, //100 = backoffice operator, 99 = agente, 98 = account manager, 200 = campus manager, 300 = utente cms
                    'ruolo' => $data['results'][0]['role'],
                    'logged_in' => TRUE
                );
            } elseif ($data['results'][0]['role'] == "utente_cms") {
                $newdata = array(
                    'username' => $data['results'][0]['username'],
                    'mainfirstname' => $data['results'][0]['first_name'],
                    'mainfamilyname' => $data['results'][0]['last_name'],
                    'businessname' => "Plus-Ed",
                    'id' => $data['results'][0]['id'],
                    'email' => $data['results'][0]['email'],
                    'country' => "-",
                    'role' => 300, //100 = backoffice operator, 99 = agente, 98 = account manager, 200 = campus manager, 300 = utente cms
                    'ruolo' => $data['results'][0]['role'],
                    'logged_in' => TRUE
                );
            } elseif ($data['results'][0]['role'] == "course_director") { //course_director
                $newdata = array(
                    'username' => $data['results'][0]['username'],
                    'mainfirstname' => $data['results'][0]['first_name'],
                    'mainfamilyname' => $data['results'][0]['last_name'],
                    'businessname' => "Plus-Ed",
                    'id' => $data['results'][0]['id'],
                    'email' => $data['results'][0]['email'],
                    'country' => "-",
                    'role' => 400, //400 = course director, 100 = backoffice operator, 99 = agente, 98 = account manager, 200 = campus manager, 300 = utente cms
                    'ruolo' => $data['results'][0]['role'],
                    'sess_campus_id' => $data['results'][0]['campusid_ref'],
                    'logged_in' => TRUE
                );
            } elseif ($data['results'][0]['role'] == "webservice_user") { //webservice_user
                $newdata = array(
                    'username' => $data['results'][0]['username'],
                    'mainfirstname' => $data['results'][0]['first_name'],
                    'mainfamilyname' => $data['results'][0]['last_name'],
                    'businessname' => "Plus-Ed",
                    'id' => $data['results'][0]['id'],
                    'email' => $data['results'][0]['email'],
                    'country' => "-",
                    'role' => 550, //550 = webservice_user, 400 = course director, 100 = backoffice operator, 99 = agente, 98 = account manager, 200 = campus manager, 300 = utente cms
                    'ruolo' => $data['results'][0]['role'],
                    'logged_in' => TRUE
                );
            } elseif ($data['results'][0]['role'] == "reimbursement") { //Reimbursement user
                $newdata = array(
                    'username' => $data['results'][0]['username'],
                    'mainfirstname' => $data['results'][0]['first_name'],
                    'mainfamilyname' => $data['results'][0]['last_name'],
                    'businessname' => "Plus-Ed",
                    'id' => $data['results'][0]['id'],
                    'email' => $data['results'][0]['email'],
                    'country' => "-",
                    'role' => 551, //551 = reimbursement, 550 = webservice_user, 400 = course director, 100 = backoffice operator, 99 = agente, 98 = account manager, 200 = campus manager, 300 = utente cms
                    'ruolo' => $data['results'][0]['role'],
                    'logged_in' => TRUE
                );
            } else {
                $newdata = array(
                    'username' => $data['results'][0]['username'],
                    'mainfirstname' => $data['results'][0]['first_name'],
                    'mainfamilyname' => $data['results'][0]['last_name'],
                    'businessname' => "Plus-Ed",
                    'id' => $data['results'][0]['id'],
                    'email' => $data['results'][0]['email'],
                    'country' => "-",
                    'role' => 100, //100 = backoffice operator, 99 = agente, 98 = account manager, 200 = campus manager
                    'ruolo' => $data['results'][0]['role'],
                    'logged_in' => TRUE
                );
                if ($data['results'][0]['role'] == "superuser")
                    $isAdmin = 1;
            }
            $this->session->set_userdata($newdata);
            $this->load->vars($data);

            // If user role is webservice_user, redirect it to separate controller
            if ($data['results'][0]['role'] == "webservice_user")
                redirect('webservice', 'refresh');

            if ($isAdmin == 1)
                redirect('backoffice/elapsedBookingsToElapse', 'refresh');
            else
                redirect('backoffice/dashboard', 'refresh');
        }else {
            $this->session->set_flashdata('back_office_login_msg', 'Invalid credentials.');
            redirect('backoffice', 'refresh');
        }
    }

    function logged() {
        $data['title'] = "plus-ed.com | Dashboard";
        $this->load->view('plused_dashboard', $data);
    }

    function logout() { {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function profile() {
        //$bOArray = array(1, 200, 300, 400, 100, 550, 551, 553); // BACKOFFICE USERS ROLE IDS
        //if ($this->session->userdata('username') && in_array($this->session->userdata('role'), $bOArray)) {
        if($this->session->userdata('role'))
        {
            $data['title'] = "plus-ed.com | Profile";
            $data['breadcrumb1'] = 'Profile';
            $data['breadcrumb2'] = '';
            $matchedArr = array(
                'id' => $this->session->userdata('id')
            );
            $data["backofficeUser"] = $this->mbackoffice->getMemberForMatch($matchedArr);
            if (APP_THEME == 'OLD') {
                $this->load->view('plused_backoffice_profile', $data);
            } else {
                $this->ltelayout->view('lte/backoffice/profile', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function changeCredentials() {
        //$bOArray = array(1, 200, 300, 400, 100, 550, 551, 553); // BACKOFFICE USERS ROLE IDS
        //if (in_array($this->session->userdata('role'), $bOArray)) {
        if($this->session->userdata('role'))
        {
            $memberId = $this->session->userdata('id');
            $matchedArr = array(
                'id' => $memberId
            );
            $userData = $this->mbackoffice->getMemberForMatch($matchedArr);
            $oldPassword = $this->input->post('oldPassword');
            $userPassword = $this->input->post('newPassword');
            if ($userData) {
                if ($userData->password == $oldPassword) {
                    $updateArr = array(
                        'password' => $userPassword
                    );
                    $this->mbackoffice->updateMemberData($updateArr, $memberId);
                    echo json_encode(array('result' => 1, 'message' => 'Password changed successfully.'));
                } else
                    echo json_encode(array('result' => 0, 'message' => 'Invalid old password.'));
            } else
                echo json_encode(array('result' => 0, 'message' => 'User no longer available in the system.'));
        } else {
            echo json_encode(array('result' => 0, 'message' => 'User session expired.'));
        }
    }

    /**
     * forgotpassword
     * used to generated password and send it to the relative user.
     */
    public function forgotpassword() {
        header('Expires: 0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        if (!$this->session->userdata('role')) {
            if (!empty($_POST)) {
                $userName = $this->input->post('txtUsername');
                if (!empty($userName)) {
                    $matchData = array('username' => $userName);
                    $applicantData = $this->mbackoffice->getMemberForMatch($matchData);
                    if ($applicantData) {
                        $senderEmail = PLUS_SENDER_EMAIL_ADDRESS;

                        $messageBody = "";
                        $data['operatorName'] = $applicantData->first_name . " " . $applicantData->last_name;
                        $data['operatorEmail'] = $applicantData->email;
                        $receiverEmail = $applicantData->email;
                        $data['operatorUsername'] = $userName;
                        $randomPassword = random_string();
                        $data['randomPassword'] = $randomPassword;
                        ob_start(); // start output buffer
                        $this->load->view('tuition/email/forgot_password_backoffice_user_template', $data);
                        $messageBody = ob_get_contents(); // get contents of buffer
                        ob_end_clean();
                        $this->load->library('email');
                        $this->email->set_newline("\r\n");
                        $this->email->from($senderEmail, 'plus-ed.com');
                        $this->email->to($receiverEmail);
                        $this->email->subject("plus-ed.com | Password changed");
                        $this->email->message($messageBody);

                        $sendRes = $this->email->send();
                        if ($sendRes) {
                            // store users password in application table
                            $updateArr = array(
                                'password' => ($randomPassword)
                            );
                            $this->mbackoffice->updateMemberData($updateArr, $applicantData->id);
                            // end of update
                            $this->session->set_flashdata('forgot_pass_msg', 'success');

                            redirect('backoffice/forgotpassword', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('forgot_pass_msg', 'notexist');
                        redirect('backoffice/forgotpassword', 'refresh');
                    }
                }
            }

            $data['title'] = "plus-ed.com | Forgot password";
            $this->load->view('plused_backoffice_forgot_password', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function dashboard() {
        //if ($this->session->userdata('role') == 1 or $this->session->userdata('role') == 100 or $this->session->userdata('role') == 200 or $this->session->userdata('role') == 300 or $this->session->userdata('role') == 553) {
        if ($this->session->userdata('role') == 400) {
            $data['title'] = "plus-ed.com | Dashboard";
            $data['breadcrumb1'] = 'Dashboard';
            $data['breadcrumb2'] = '';
            //$this->load->view('tuition/plused_users_dashboard', $data);
            if (APP_THEME == "OLD")
                $this->load->view('tuition/plused_course_director_dashboard', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = "Plus Vision Dashboard";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/course_director_dashboard', $data);
            }
        } else if ($this->session->userdata('role') == 501) {
            redirect('survey', 'refresh');
        } else if ($this->session->userdata('role') == 502) {
            redirect('students', 'refresh');
        }
        else if($this->session->userdata('role')){
            authSessionMenu($this);
            $data['title'] = "plus-ed.com | Dashboard";
            $data['breadcrumb1'] = 'Dashboard';
            $data['breadcrumb2'] = '';
            $season = $this->mbackoffice->getLastBookingYear();
            $agent = '';
            $campus = 'all';
            $data["tbc_bk"] = $this->mbackoffice->overviewBookingsNew($campus, $agent, 'tbc', 2, $season);
            $data["confirmed_bk"] = $this->mbackoffice->overviewBookingsNew($campus, $agent, 'confirmed', 2, $season);
            $data["elapsed_bk"] = $this->mbackoffice->overviewBookingsNew($campus, $agent, 'elapsed', 2, $season);
            $data["active_bk"] = $this->mbackoffice->overviewBookingsNew($campus, $agent, 'active', 2, $season);
            $data["openCount"] = $this->mbackoffice->getOpenTicketCount();
            $data["open_tickets"] = $this->mbackoffice->getOpenTicketDetails();
            if (APP_THEME == 'OLD') {
                $this->load->view('plused_dashboard', $data);
            } else {
                $this->ltelayout->view('lte/backoffice/dashboard', $data);
            }
        }
        else {
            redirect('backoffice', 'refresh');
        }
    }

//DA RIMUOVERE QUANDO LA NEW VA IN PRODUZIONE DEFINITIVA
    function overviewBookings() {
        if ($this->session->userdata('role') == 100) {
            $lastYear = $this->mbackoffice->getLastBookingYear();
            $data["centri"] = $this->mbackoffice->getAllCampus(1);
            $data["tutte_agenzie"] = $this->mbackoffice->getAllAgencies();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 'all';
            $status = isset($_POST['stato_in']) ? $_POST['stato_in'] : 'tbc';
            $season = isset($_POST['season']) ? $_POST['season'] : $lastYear;
            $agent = isset($_POST['agenzia_in']) ? $_POST['agenzia_in'] : 'all';
            $datein = isset($_POST['date_in']) ? $_POST['date_in'] : 'all';
            $dateout = isset($_POST['date_out']) ? $_POST['date_out'] : 'all';
            $data["campus"] = $campus;
            $data["agenziefrom"] = $agent;
            $data["statusfrom"] = $status;
            $data["datafrom"] = $datein;
            $data["datato"] = $dateout;
            $data["season"] = $season;
            $data["all_books"] = $this->mbackoffice->overviewBookings($campus, $agent, $status, $datein, $dateout, 2, $season);
            $data['title'] = 'plus-ed.com | Overview campus bookings';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Overview campus bookings';
            $this->load->view('overview_campus_bookings', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function overviewBookingsNew($status = "") {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $lastYear = $this->mbackoffice->getLastBookingYear();
            $data["season"] = isset($_POST['season']) ? $_POST['season'] : $lastYear;
            $data["centri"] = $this->mbackoffice->getAllCampus(1);
            $data["tutte_agenzie"] = $this->mbackoffice->getAllAgencies();
            $data["pStatus"] = $status;
            $data['title'] = 'plus-ed.com | Overview campus bookings';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Overview campus bookings';

            if (APP_THEME == "OLD")
                $this->load->view('plused_overviewBookingsNew.php', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = "Overview bookings";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/bookings/overview_bookings_new', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function getAgenciesForAutoComplete($term) {
        if ($this->session->userdata('role') == 100) {
            $acAgencies = $this->mbackoffice->getAgenciesForAutoComplete($term);
            echo $acAgencies;
        } else {
            die("ERROR");
        }
    }

    function overviewBookingsDetailNew() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $campusArray = $_REQUEST["centri"];
            $data["statusArray"] = $_REQUEST["status"];
            $lm = 0;
            $cfd = 0;
            $lock = 0;

            if (isset($_REQUEST['flag'])) {
                foreach ($_REQUEST['flag'] as $flag) {
                    switch ($flag) {
                        case 'lm':
                            $lm = 1;
                            break;
                        case 'cfd':
                            $cfd = 1;
                            break;
                        case 'rlock':
                            $lock = 1;
                            break;
                    }
                }
            }
            //print_r($data["statusArray"]);
            $data["campusArray"] = $campusArray;
            $lastYear = $this->mbackoffice->getLastBookingYear();
            $season = isset($_REQUEST['season']) ? $_REQUEST['season'] : $lastYear;
            $agent = isset($_REQUEST['agenzia_in']) ? $_REQUEST['agenzia_in'] : 'all';
            $indiceCampus = 0;
            foreach ($_REQUEST["centri"] as $campus) {
                $data["allCampus"][$indiceCampus]["campusName"] = $this->mbackoffice->centerNameById($campus);
                foreach ($data["statusArray"] as $status) {
                    $data["allCampus"][$indiceCampus]["all_books"][] = $this->mbackoffice->overviewBookingsNew($campus, $agent, $status, 2, $season, $lm, $cfd, $lock);
                }
                $indiceCampus++;
            }

            //echo "<pre>";
            //print_r($data['allCampus']);
            //echo "</pre>";
            $data['title'] = 'plus-ed.com | Overview campus bookings';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Overview campus bookings';
            if (APP_THEME == "OLD")
                $this->load->view('plused_overviewBookingsListNew', $data);
            else {
                $this->load->view('lte/backoffice/bookings/overview_bookings_list_new', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function overviewSingleBooking($idBook) {
        if ($this->session->userdata('role') == 100) {
            $data["all_books"] = $this->mbackoffice->overviewSingleBooking($idBook);
            $data['title'] = 'plus-ed.com | Overview campus bookings';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Overview campus bookings';
            $this->load->view('overview_campus_single_booking', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function newAvail($idBook, $pill = "a") {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["title"] = "New availability";
            $data['all_glstd_count'] = $this->mbackoffice->getGlSTDCount($idBook);
            $data['all_acco'] = $this->mbackoffice->NA_getCalendarTable1($idBook);
            $data['all_acco2'] = $this->mbackoffice->NA_getCalendarTable2($idBook);
            $NA_bookDet = $this->mbackoffice->NA_getBookDet($idBook);
            $campus = $NA_bookDet[0]->id_centro;
            $datein = $NA_bookDet[0]->mindatein;
            $dateout = $NA_bookDet[0]->maxdateout;
            $dateInterval = (strtotime($dateout) - strtotime($datein)) / 60 / 60 / 24;
            $addedDays = 30 - $dateInterval;
            $startingDays = floor($addedDays / 2);
            $endingDays = $addedDays - $startingDays;
            $datecycleIn = date("Y-m-d", strtotime("-" . $startingDays . " day", strtotime($datein)));
            $datecycleOut = date("Y-m-d", strtotime("+" . $endingDays . " day", strtotime($dateout)));
            //echo $datein."-".$dateout."-".$dateInterval."-".$addedDays."-".$startingDays."-".$endingDays."-".$datecycleIn."-".$datecycleOut;
            $data["datein"] = $datecycleIn;
            $data["dateout"] = $datecycleOut;
            if ($data["all_acco2"])
                foreach ($data["all_acco2"] as $accoOne) {
                    $accom = $accoOne->accomodation;
                    $data["arrayAcco"][] = $accom;
                    $data['simcalendar'][] = $this->mbackoffice->NA_getSimCalendar($campus, $accom, $datecycleIn, $datecycleOut);
                    //print_r($data['simcalendar']);
                    $data['simbooking'][] = $this->mbackoffice->NA_getSimBooking($accom, $datecycleIn, $datecycleOut, $idBook);
                }
            //echo count( $data['simbooking']);
            $idAg = $this->mbackoffice->agentIdByBkId($idBook);
            $data['agente'] = $this->mbackoffice->agent_detail($idAg);
            $data['book'] = $this->mbackoffice->overviewSingleBooking($idBook);
            //if($data['book'][0]["id_agente"]==795){
            //    $data["bkStudyOvernight"]=$this->mbackoffice->getUnjoinedSTBookings($data['book'][0]["arrival_date"]);
            //}
            if ($data['book']) {
                $data['detMyPax'] = $this->mbackoffice->detMyPaxForRosterBackoffice($data['book'][0]["id_year"], $idBook);
            }

            $data['payments'] = $this->mbackoffice->paymentsById($idBook);
            $data['payTypes'] = $this->mbackoffice->getAllPaymentTypes();
            $data['payServices'] = $this->mbackoffice->getAllPaymentServices();
            $data['hasRoster'] = $this->mbackoffice->count_pax_uploaded($idBook);
            $data['pill'] = $pill;
            $data['insertNote'] = $this->mbackoffice->readBookingNotes($idBook, 0);
            $data["centri"] = $this->mbackoffice->getAllCampus();
            if (APP_THEME == 'OLD') {
                $this->load->view('overview_new_availability', $data);
            } else {
                $isFlocked = 0;
                if ($data['book']) {
                    $da = explode("-", $data['book'][0]["arrival_date"]);
                    $dd = explode("-", $data['book'][0]["departure_date"]);
                    $maxNoLmDate = date("d/m/Y", strtotime($data['book'][0]["arrival_date"]) - (24 * 3600 * 30));
                    $maxLmDate = date("d/m/Y", strtotime($data['book'][0]["arrival_date"]) - (24 * 3600 * 1));
                    //echo $maxNoLmDate;
                    $storeId = $data['book'][0]["id_book"];
                    $yearId = $data['book'][0]["id_year"];
                    $accos = $data['book'][0]["all_acco"];
                    $now = time();
                    $your_date = strtotime($data['book'][0]["arrival_date"]);
                    $dayToArrive = round(($now - $your_date) / 86400 * -1);
                    $valutaCampo = $data['book'][0]["valuta"];
                    $valoreAcconto = $data['book'][0]["tot_pax"] * 1 * $data['book'][0]["valore_acconto"] * 1;
                    $this->load->view('lte/backoffice/backoffice_details', $data);
                }
//				echo json_encode(array(
//					'result' => 1,
//					'message' => $html
//				));
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function exportCSVBookings($campus, $agent, $status, $year) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $data["tutte_agenzie"] = $this->mbackoffice->getAllAgencies();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 'all';
            $status = isset($_POST['stato_in']) ? $_POST['stato_in'] : 'all';
            $agent = isset($_POST['agenzia_in']) ? $_POST['agenzia_in'] : 'all';
            $data["campus"] = $campus;
            $data["agenziefrom"] = $agent;
            $data["statusfrom"] = $status;
            $data["all_books"] = $this->mbackoffice->exportCSVBookings($campus, $agent, $status, $year);
            //echo "<pre>";
            //print_r($data["all_books"]);
            //echo "</pre>";
            $myFile = "/var/www/html/www.plus-ed.com/vision_ag/downloads/export_csv/allCSVBookings.csv";
            //$myFile = "./downloads/export_csv/allCSVBookings.csv";
            $fh = fopen($myFile, 'w+') or die("can't open file");
            $intestData = '"Centro";"Booking number";"Agency";"Arrival date";"Departure date";"Weeks";"Pax type";"Accomodation";"Pax number";"Status";"Elapsing date";"Booking date and time";"Deposit invoice";"Full invoice";"Currency"' . PHP_EOL;
            fwrite($fh, $intestData);
            foreach ($data["all_books"] as $singbk) {
                //echo "<br />".$singbk["centro"].'";"'.$singbk["id_book"]."_".$singbk["id_year"].$singbk["agency"][0]["businessname"].'";"'.$singbk["arrival_date"].'";"'.$singbk["departure_date"].'";"'.$singbk["weeks"].'";"'.$singbk["status"].'";"'.$singbk["data_scadenza"].'";"'.$singbk["data_insert"].'";'.str_replace(".",",",$singbk["acconto_versato"]).';'.str_replace(".",",",$singbk["saldo_versato"]).';"'.$singbk["valuta"]."<br />";
                if (count($singbk["all_acco"])) {
                    foreach ($singbk["all_acco"] as $singacco) {
                        $agencyBusinessName = "";
                        if(isset($singbk["agency"][0]["businessname"]))
                            $agencyBusinessName = $singbk["agency"][0]["businessname"];
                        $rigaData = '"' . $singbk["centro"] . '";"' . $singbk["id_year"] . "_" . $singbk["id_book"] . '";"' . $agencyBusinessName . '";"' . $singacco->data_arrivo_campus /*$singbk["arrival_date"]*/ . '";"' . $singacco->data_partenza_campus /*$singbk["departure_date"]*/ . '";"' . $singbk["weeks"] . '";"' . $singacco->tipo_pax . '";"' . $singacco->accomodation . '";"' . $singacco->contot . '";"' . $singbk["status"] . '";"' . $singbk["data_scadenza"] . '";"' . $singbk["data_insert"] . '";' . str_replace(".", ",", $singbk["acconto_versato"]) . ';' . str_replace(".", ",", $singbk["saldo_versato"]) . ';"' . $singbk["valuta"] . '"' . PHP_EOL;
                        //echo "<br />".$rigaData."<br />";
                        fwrite($fh, $rigaData);
                    }
                }
            }
            fclose($fh);

            $this->load->library('excel');


            $inputFileType = 'CSV';
            $inputFileName = $myFile;
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setDelimiter(";");
            $objReader->setInputEncoding('UTF-8');

            $objPHPExcel = $objReader->load($inputFileName);



            $filename = 'export.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');

            die();
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function clearedBookingsToConfirm() {
        if ($this->session->userdata('role') == 100) {
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $data["tutte_agenzie"] = $this->mbackoffice->getAllAgencies();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 'all';
            $status = 'active';
            $agent = isset($_POST['agenzia_in']) ? $_POST['agenzia_in'] : 'all';
            $datein = isset($_POST['date_in']) ? $_POST['date_in'] : 'all';
            $dateout = isset($_POST['date_out']) ? $_POST['date_out'] : 'all';
            $data["campus"] = $campus;
            $data["agenziefrom"] = $agent;
            $data["statusfrom"] = $status;
            $data["datafrom"] = $datein;
            $data["datato"] = $dateout;
            $data["all_books"] = $this->mbackoffice->overviewBookings($campus, $agent, $status, $datein, $dateout, 1);
            $data['title'] = 'plus-ed.com | Confirm cleared bookings';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Confirm cleared bookings';
            $this->load->view('cleared_bookings_to_confirm', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function exportAllBookings() {
        if ($this->session->userdata('role') == 100) {
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $data["tutte_agenzie"] = $this->mbackoffice->getAllAgencies();
            $campus = 'all';
            $status = 'all';
            $agent = 'all';
            $datein = 'all';
            $dateout = 'all';
            $data["all_books"] = $this->mbackoffice->overviewBookings($campus, $agent, $status, $datein, $dateout, 0);
            $myFile = "/var/www/html/www.plus-ed.com/vision_ag/downloads/export_csv/testFile.csv";
            $fh = fopen($myFile, 'w+') or die("can't open file");
            foreach ($data["all_books"] as $sb) {
                ?>
                <pre>
                    <?php
                    $stringData = "\"" . $sb["id_year"] . "_" . $sb["id_book"] . "\";\"" . $sb["centro"] . "\";\"" . $sb["agency"][0]["businessname"] . "\";\"" . $sb["agency"][0]["businesscity"] . "\";\"" . $sb["agency"][0]["businesscountry"] . "\";\"" . $sb["arrival_date"] . "\";\"" . $sb["departure_date"] . "\";\"" . $sb["status"] . "\";\"" . $sb["data_insert"] . "\"" . PHP_EOL;
                    fwrite($fh, $stringData);
                    //print_r($sb);
                    ?>
                </pre>
                <?php
            }
            fclose($fh);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function searchAP() {
        if ($this->session->userdata('role') == 100) {
            $this->magenti->searchAP();
        }
    }

    function ____insertFullForAll() {
        if ($this->session->userdata('role') == 100) {
            $idbks = $this->mbackoffice->getBKIDforInsert();
            foreach ($idbks as $idbk) {
                $getFullInvoiceAr = explode("___", $this->mbackoffice->getFullInvoiceNew($idbk["id_book"]));
                $cifraFull = $getFullInvoiceAr[0];
                $valutaFull = $getFullInvoiceAr[1];
                //echo "<br />".$idbk["id_book"]."------>".$cifraFull."--->".$valutaFull;
                $this->mbackoffice->insertPayment($idbk["id_book"], $cifraFull, NULL, $valutaFull, NULL, "acq", "Full Invoice", "");
            }
            die();
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function insertSinglePayment() {
        if ($this->session->userdata('role') == 100) {
            $pfp_bk_id = $_REQUEST["mybkid"];
            $pfp_importo = $_REQUEST["P_amount"];
            $pfp_valuta = $_REQUEST["P_currency"];
            $pfp_dare_avere = $_REQUEST["P_typePay"];
            $pfp_tipo_servizio = $_REQUEST["P_operation"];

            if ($pfp_dare_avere == "acq") {
                $pfp_data_valuta = NULL;
                $pfp_metodo_pagamento = NULL;
            } else {
                $pfp_data_valutaAr = explode("/", $_REQUEST["P_curDate"]);
                $pfp_data_valuta = $pfp_data_valutaAr[2] . "-" . $pfp_data_valutaAr[1] . "-" . $pfp_data_valutaAr[0];
                $pfp_metodo_pagamento = $_REQUEST["P_method"];
            }

            $this->mbackoffice->insertPayment($pfp_bk_id, $pfp_importo, $pfp_metodo_pagamento, $pfp_valuta, $pfp_data_valuta, $pfp_dare_avere, $pfp_tipo_servizio, "");
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function deleteSinglePayment($idPayment) {
        if ($this->session->userdata('role') == 100) {
            $deleteSP = $this->mbackoffice->deleteSinglePayment($idPayment);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function change_booking_status($id, $stato, $datanuova = 0, $lm = 0) {
         if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $dataok = 0;
            if ($datanuova) {
                $dataok = date('Y-m-d', strtotime($datanuova));
            }
            $getFullInvoiceAr = explode("___", $this->mbackoffice->getFullInvoiceNew($id));
            $cifraFull = $getFullInvoiceAr[0];
            $valutaFull = $getFullInvoiceAr[1];
            //echo $cifraFull."--->".$valutaFull;
            //$this->mbackoffice->insertPayment($id,$cifraFull,NULL,$valutaFull,NULL,"acq","Full Invoice","");
            //die();
            $a_email = $this->mbackoffice->change_booking_status($id, $stato, $dataok, $lm);
            if ($stato == "active") {
                //Inserire riga full invoice in bilancino qui!
                $fullInvoiceNum = $this->mbackoffice->fullInvoiceInserted($id);
                if ($fullInvoiceNum <= 0) {
                    $this->mbackoffice->insertPayment($id, $cifraFull, NULL, $valutaFull, NULL, "acq", "Full Invoice", "");
                }
                //invio mail all'agente
                $this->load->library('email');
                $mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
                $mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
                $mymessage .= "<strong>  Dear Sir/Madam </strong><br/><br/>";
                $mymessage .= "Your booking " . date('Y') . "_" . $id . " is now active and will expire on " . $datanuova . "<br /><br />You can now log in your personal page on PLUS Vision system to review your booking and to download your invoice.<br />";
                $mymessage .= "<strong>Plus Sales Office</strong>" . "<br/><br/>";
                $mymessage .= "</body></html>";

                $this->email->from('info@plus-ed.com', 'Plus Sales Office');
                $this->email->to($a_email);
                $this->email->cc("smarra@plus-ed.com");
                $this->email->bcc($this->session->userdata('email'));
                $this->email->subject('Plus Sales Office - Your booking has been activated.');
                $this->email->message($mymessage);
                $this->email->send();
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function changeDownloadVisa($id, $canDwn) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $okDwn = $this->mbackoffice->changeDownloadVisa($id, $canDwn);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function add_flag_payment($id) {
        if ($this->session->userdata('role') == 100) {
            $okPay = $this->mbackoffice->add_flag_payment($id);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function add_flag_checkPay($id) {
        if ($this->session->userdata('role') == 100) {
            $okPay = $this->mbackoffice->add_flag_checkPay($id);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function add_flag_cfd($id) {
        if ($this->session->userdata('role') == 100) {
            $okPay = $this->mbackoffice->add_flag_cfd($id);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function unlockRoster($idBook) {
        if ($this->session->userdata('role') == 100) {
            $unlockRoster = $this->mbackoffice->unlockRoster($idBook);
            echo "Success";
            //redirect('backoffice/take/' . $idBook, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function invoice_pdf($id) {
        if ($this->session->userdata('role') == 100) {
            $data['booking_detail'] = $this->mbackoffice->get_booking_detail($id);
            $data['booking_acc'] = $this->mbackoffice->getBookAccomodations($id);
            $idagenzia = $data['booking_detail'][0]['id_agente'];
            $data['agency'] = $this->mbackoffice->agent_detail($idagenzia);
            $this->load->plugin('to_pdf');
            $html = $this->load->view('PDF_deposit_invoice', $data, true);
            pdf_create($html, 'deposit_invoice_' . $data['booking_detail'][0]['rand']);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function invoice_pdf_no_acconto($id) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $this->mbackoffice->set_first_print($id);
            $data['booking_detail'] = $this->mbackoffice->get_booking_detail($id);
            $data['booking_acc'] = $this->mbackoffice->getBookAccomodations($id);
            $idagenzia = $data['booking_detail'][0]['id_agente'];
            $data['agency'] = $this->mbackoffice->agent_detail($idagenzia);
            $this->load->plugin('to_pdf');
            $html = $this->load->view('PDF_deposit_invoice_no_acconto', $data, true);
            pdf_create($html, 'deposit_invoice_' . $data['booking_detail'][0]['id_year'] . '_' . $data['booking_detail'][0]['id_book']);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function invoice_pdf_no_saldo($id) {
        if ($this->session->userdata('role') == 100) {
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
            redirect('backoffice', 'refresh');
        }
    }

    function pdf_visas($id, $tmpl = NULL) {
        if ($this->session->userdata('role') == 100) {
            $this->load->helper('mpdf6_helper');

            if ($tmpl != '') {
                $uri = func_get_args();
                $data['locked'] = $this->magenti->checkBookLocked($id);

                if ($data['locked'] == 'locked') {
                    $data['allDetSTD'] = $this->magenti->listPax($id, "STD", NULL);
                    $data['allDetGL'] = $this->magenti->listPax($id, "GL", NULL);
                }

                $totalLockedPax = $this->magenti->checkBookLockedPax($id);
                if (!$totalLockedPax) {
                    echo "ERROR - VISA NOT AVAILABLE";
                    die();
                }

                $data['booking_detail'] = $this->magenti->get_booking_detail($id);
                $data['initTemp'] = $tmpl;
                $idagenzia = $data['booking_detail'][0]['id_agente'];
                $located = $data['booking_detail'][0]['valuta_fattura'];
                $year = $data['booking_detail'][0]['id_year'];
                $data['agency'] = $this->magenti->agent_detail($idagenzia);
                $data['detSTD'] = $this->magenti->listPax($id, "STD", 1);
                $data['detGL'] = $this->magenti->listPax($id, "GL", 1);
                $this->load->plugin('to_pdf');
                $html = $this->load->view('visa/PDF_visas_multiple', $data, true);
                $filename = 'PDF_VISAS_' . $data['booking_detail'][0]['id_year'] . '_' . $data['booking_detail'][0]['id_book'] . '__' . date("U");
                writeHtmlPdfAndSaveSingleVisas($html, $filename, true, $tmpl);
            } else {
                redirect('backoffice', 'refresh');
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function take($idbook) {
        if ($this->session->userdata('ruolo') == "superuser") {
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $data['title'] = 'plus-ed.com | Edit reservation';
            $data['booking_detail'] = $this->mbackoffice->get_booking_detail($idbook);
            $data['pax_uploaded'] = $this->mbackoffice->count_pax_uploaded($idbook);
            $glsta = $this->mbackoffice->getSingleBookAccomodations($idbook, 'GL', 'standard');
            $glens = $this->mbackoffice->getSingleBookAccomodations($idbook, 'GL', 'ensuite');
            $glhom = $this->mbackoffice->getSingleBookAccomodations($idbook, 'GL', 'homestay');
            $gltwi = $this->mbackoffice->getSingleBookAccomodations($idbook, 'GL', 'twin');
            $ststa = $this->mbackoffice->getSingleBookAccomodations($idbook, 'STD', 'standard');
            $stens = $this->mbackoffice->getSingleBookAccomodations($idbook, 'STD', 'ensuite');
            $sthom = $this->mbackoffice->getSingleBookAccomodations($idbook, 'STD', 'homestay');
            $sttwi = $this->mbackoffice->getSingleBookAccomodations($idbook, 'STD', 'twin');
            $agent_detail = $this->mbackoffice->agent_detail($data["booking_detail"][0]["id_agente"]);
            $data['booking_detail'][0]['stens'] = $stens[0]["conto"];
            $data['booking_detail'][0]['ststa'] = $ststa[0]["conto"];
            $data['booking_detail'][0]['sthom'] = $sthom[0]["conto"];
            $data['booking_detail'][0]['sttwi'] = $sttwi[0]["conto"];
            $data['booking_detail'][0]['glens'] = $glens[0]["conto"];
            $data['booking_detail'][0]['glsta'] = $glsta[0]["conto"];
            $data['booking_detail'][0]['glhom'] = $glhom[0]["conto"];
            $data['booking_detail'][0]['gltwi'] = $gltwi[0]["conto"];
            $data['booking_detail'][0]['agente_name'] = $agent_detail[0]["businessname"];
            $data['breadcrumb1'] = 'Overview campus booking';
            $data['breadcrumb2'] = 'Edit reservation';
            $this->load->view('plused_edit_reservation', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function editGroup($id_book, $anno) {
        if ($this->session->userdata('role') == 100) {
            $data['user'] = $this->session->userdata('username');
            $data['mail'] = $this->session->userdata('email');
            $data['id'] = $this->session->userdata('id');
            $data['name'] = $this->session->userdata('mainfirstname');
            $data['surname'] = $this->session->userdata('mainfamilyname');
            $data['business'] = $this->session->userdata('businessname');
            $login = $data['user'];
            $email = $data['mail'];
            $this->mbackoffice->editBook($id_book);
            $this->mbackoffice->RE_insertRows($id_book, $anno);
            redirect('backoffice/take/' . $id_book, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function campusAvailability() {
        if ($this->session->userdata('role') == 100) {
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $data['title'] = 'plus-ed.com | Edit campus availability';
            $data['breadcrumb1'] = 'Campus management';
            $data['breadcrumb2'] = 'Edit campus availability';
            $this->load->view('plused_edit_campus_availability', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function insertCampusAvailability() {
        if ($this->session->userdata('role') == 100) {
            $insertAv = $this->mbackoffice->insertCampusAvailability();
            redirect('backoffice/campusAvailability', 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function reviewday2day() {
        if ($this->session->userdata('role') == 100) {
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 33;
            $accom = isset($_POST['accomodation_in']) ? $_POST['accomodation_in'] : 1;
            $accomodation = $this->mbackoffice->getLowerSisById($accom);
            /*
              switch ($accom) {
              case 1:
              $accomodation = 'standard';
              break;
              case 2:
              $accomodation = 'ensuite';
              break;
              case 3:
              $accomodation = 'homestay';
              break;
              }
             */
            $month = isset($_POST['month_in']) ? $_POST['month_in'] : date("n");
            $year = isset($_POST['year_in']) ? $_POST['year_in'] : date("Y");
            $data['bkgmese'] = $this->mbackoffice->getBkCalendar($campus, $accomodation, $month, $year);
            $data['title'] = 'plus-ed.com | Review campus day 2 day';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Review campus day 2 day';
            $data['json_name'] = $campus . "_" . $accomodation . "_d2d.json";
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $data['campusname'] = $this->mbackoffice->centerNameById($campus);
            $data['campus'] = $campus;
            $data['accomodationname'] = $accomodation;
            $data['accomodation'] = $accom;
            $data['month'] = $month;
            $data['year'] = $year;
            $this->load->view('plused_reviewday2day', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function infoday2day($campus, $accomodation, $date, $status = "") {
        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200 or $this->session->userdata('role') == 553) {
            switch ($accomodation) {
                case 1:
                    $accomodation = 'standard';
                    break;
                case 2:
                    $accomodation = 'ensuite';
                    break;
                case 3:
                    $accomodation = 'homestay';
                    break;
                default:
                    $accomodation = 'all';
                    break;
            }
            $data['title'] = 'plus-ed.com | View day details';
            $data['breadcrumb1'] = 'Review campus day to day';
            $data['breadcrumb2'] = 'View day details';
            if ($this->session->userdata('role') == 100) {
                $data['bkgd2d'] = $this->mbackoffice->getD2DBk($campus, $accomodation, $date, $status);
            } else {
                $data['bkgd2d'] = $this->mbackoffice->getD2DBk($this->mbackoffice->centerIdByName($this->session->userdata('businessname')), $accomodation, $date, $status);
            }
            //echo "<pre>";
            //print_r($data['bkgd2d']);
            //echo "</pre>";
            if (APP_THEME == 'OLD')
                $this->load->view('plused_view_campusd2d_detail', $data);
            else
                $this->load->view('lte/backoffice/bookings/view_campusd2d_detail', $data);
        }
        else {
            redirect('backoffice', 'refresh');
        }
    }

    function simulatorday2day($campus, $accom, $datein, $dateout) {
        if ($this->session->userdata('role') == 100) {
            $data['simcalendar'] = $this->mbackoffice->getSimCalendar($campus, $accom, $datein, $dateout);
            $data['simbooking'] = $this->mbackoffice->getSimBooking($campus, $accom, $datein, $dateout);
            $data['title'] = 'plus-ed.com | Simulator day 2 day';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Simulator day 2 day';
            $data['campusname'] = $this->mbackoffice->centerNameById($campus);
            $data['campus'] = $campus;
            $data['accomodationname'] = $accom;
            $data['accomodation'] = $accom;
            $data['datein'] = $datein;
            $data['dateout'] = $dateout;
            /*
              echo "<pre>";
              print_r($data['simcalendar']);
              echo "</pre>";

              echo "<pre>";
              print_r($data['simbooking']);
              echo "</pre>";
             */
            $this->load->view('plused_simulatorday2day', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function elapsedBookingsToElapse() {
        redirect('backoffice', 'refresh');
        exit();
        // REMOVED AS ADDED CRON FOR ELAPESED BOOKING
        /*
          if ($this -> session -> userdata('ruolo') == "superuser")
          {
          $data['title'] = 'plus-ed.com | Reset elapsed bookings';
          $data['breadcrumb1'] = 'Booking';
          $data['breadcrumb2'] = 'Reset elapsed bookings';
          $data['bkg_elapsed'] = $this -> mbackoffice -> elapsedBookingsToElapse();
          redirect('backoffice/dashboard', 'refresh');
          }
          else {
          redirect('backoffice', 'refresh');
          }
         * */
    }

    function bookingExists() {
        if ($this->session->userdata('ruolo') == "superuser" or $this->session->userdata('role') == 100) {
            $id_book = isset($_POST['idsearch']) ? $_POST['idsearch'] : '';
            $bkgExists = 0;
            $bkgExists = $this->mbackoffice->bookingExists($id_book);
            echo $bkgExists;
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function insertBkNote($idbk) {
        if ($this->session->userdata('ruolo') == "superuser") {
            $insertNote = $this->mbackoffice->insertBkNote($idbk);
            if ($insertNote) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function readBookingNotes($idbk, $public = 0) {
        if ($this->session->userdata('role') == 100 or ( $this->session->userdata('role') == 200 && $public == 1) or ( $this->session->userdata('role') == 553 && $public == 1)) {
            $insertNote = $this->mbackoffice->readBookingNotes($idbk, $public);
            foreach ($insertNote as $nota) {
                echo date("d/m/Y H:i", strtotime($nota["n_datetime"])) . " - User: " . $nota["n_userid"];
                if ($nota["n_public"] == 1) {
                    echo " | Public note";
                }
                echo "\n" . $nota["n_testo"];
                echo "\n----------------------------------------------\n\n";
            }
        } else {
            echo "ERROR!";
            die();
        }
    }

    function setUnplannedExcursions() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->mbackoffice->getAllCampusForDropdown();
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
            $data["all_excursions"] = $this->mbackoffice->setUnplannedExcursions($campus, $tipo, $to, $from);
            $data['title'] = 'plus-ed.com | Book included excursions';
            $data['breadcrumb1'] = 'Included excursions';
            $data['breadcrumb2'] = 'Book included excursions';
            if (APP_THEME == "OLD")
                $this->load->view('plused_set_unplanned_excursions', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/set_unplanned_excursions', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function viewPlannedExcursions() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->mbackoffice->getAllCampusForDropdown();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : '';
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'planned';
            $from = isset($_POST['from']) ? $_POST['from'] : date("d/m/Y");
            $fromA = explode("/", $from);
            $fromGirato = $fromA[2] . "-" . $fromA[1] . "-" . $fromA[0];
            $to = isset($_POST['to']) ? $_POST['to'] : date("d/m/Y", strtotime($fromGirato . "+ 7 days"));
            $status = isset($_POST['status']) ? $_POST['status'] : 'all';
            $data["campus"] = $campus;
            $data["tipo"] = $tipo;
            $data["to"] = $to;
            $data["from"] = $from;
            $data["status"] = $status;
            $data["all_excursions"] = $this->mbackoffice->viewPlannedExcursions($campus, $tipo, $to, $from, $status);
            $data['title'] = 'plus-ed.com | Review included excursions';
            $data['breadcrumb1'] = 'Included excursions';
            $data['breadcrumb2'] = 'Review included excursions';
            if (APP_THEME == "OLD")
                $this->load->view('plused_view_planned_excursions', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/view_planned_excursions', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /* NON SERVE - SOLO PER TEST
      function retrieveTraOk($traDate, $flightN, $nPax){
      if($this->session->userdata('role')==100){
      $postiOk =  $this->mbackoffice->retrieveTraOk($traDate, $flightN, $nPax);
      }else{
      redirect('backoffice','refresh');
      }
      } */

    function addPaxToExistingTransfer($busCode, $idBook, $idYear, $totPax) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $addPaxToExistingTransfer = $this->mbackoffice->addPaxToExistingTransfer($busCode, $idBook, $idYear, $totPax);
            redirect('backoffice/busTraDetail/code_' . $busCode, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function viewPlannedAllExcursions() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->mbackoffice->getAllCampusForDropdown();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : '';
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'extra';
            $from = isset($_POST['from']) ? $_POST['from'] : date("d/m/Y");
            $fromA = explode("/", $from);
            $fromGirato = $fromA[2] . "-" . $fromA[1] . "-" . $fromA[0];
            $to = isset($_POST['to']) ? $_POST['to'] : date("d/m/Y", strtotime($fromGirato . "+ 7 days"));
            $status = isset($_POST['status']) ? $_POST['status'] : 'all';
            $data["campus"] = $campus;
            $data["tipo"] = $tipo;
            $data["to"] = $to;
            $data["from"] = $from;
            $data["status"] = $status;
            $data["all_excursions"] = $this->mbackoffice->viewPlannedAllExcursions($campus, $tipo, $to, $from, $status);
            $data['title'] = 'plus-ed.com | Review extra excursions';
            $data['breadcrumb1'] = 'Extra excursions';
            $data['breadcrumb2'] = 'Review extra excursions';

            if (APP_THEME == "OLD")
                $this->load->view('plused_view_planned_all_excursions', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/view_planned_all_excursions', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function viewBookedTransfers() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : '';
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'all';
            $from = isset($_POST['from']) ? $_POST['from'] : date("d/m/Y");
            $fromA = explode("/", $from);
            $fromGirato = $fromA[2] . "-" . $fromA[1] . "-" . $fromA[0];
            $to = isset($_POST['to']) ? $_POST['to'] : date("d/m/Y", strtotime($fromGirato . "+ 7 days"));
            $status = isset($_POST['status']) ? $_POST['status'] : 'all';
            $data["campus"] = $campus;
            $data["tipo"] = $tipo;
            $data["to"] = $to;
            $data["from"] = $from;
            $data["status"] = $status;
            $data["all_transfers"] = $this->mbackoffice->viewBookedTransfers($campus, $tipo, $to, $from, $status);
            $data['title'] = 'plus-ed.com | View booked transfers';
            $data['breadcrumb1'] = 'Transfers';
            $data['breadcrumb2'] = 'View booked transfers';

            if (APP_THEME == "OLD")
                $this->load->view('plused_view_booked_transfers', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/view_booked_transfers', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function resetLostTransfers() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["losttransfers"] = $this->mbackoffice->viewLostTransfers();
            $data['title'] = 'plus-ed.com | Lost and found transfers';
            $data['breadcrumb1'] = 'Transfers';
            $data['breadcrumb2'] = 'Lost and found transfers';

            if (APP_THEME == "OLD")
                $this->load->view('plused_reset_transfers', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/reset_transfers', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function actionResetLostTrasfers() {
        if ($this->session->userdata('role') == 100) {
            $this->mbackoffice->actionResetLostTransfers();
            redirect('backoffice/resetLostTransfers', 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function ca_viewBookedTransfers() {
        authSessionMenu($this);
        $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
        $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'inbound';
        $to = isset($_POST['to']) ? $_POST['to'] : date("d/m/Y");
        $from = isset($_POST['from']) ? $_POST['from'] : date("d/m/Y");
        $status = 'YES';
        $data["campus"] = $campus;
        $data["tipo"] = $tipo;
        $data["to"] = $to;
        $data["from"] = $from;
        $data["status"] = $status;
        $data["all_transfers"] = $this->mbackoffice->viewBookedTransfers($campus, $tipo, $to, $from, $status);
        $data["flgDetails"] = array();
        if (!empty($data["all_transfers"])) {
            foreach ($data["all_transfers"] as $buscode) {
                if ($buscode['ptt_buscompany_code']) {
                    $arrayescursioni = $this->mbackoffice->getTraIdsFromBusCode($buscode['ptt_buscompany_code']);
                    $data["flgDetails"][$buscode['ptt_buscompany_code']] = $this->mbackoffice->bkgDetailsForTransfer($arrayescursioni);
                }
            }
        }
        $data['title'] = 'plus-ed.com | View booked transfers';
        $data['breadcrumb1'] = 'Transportation';
        $data['breadcrumb2'] = 'View booked transfers';

        if (APP_THEME == "OLD")
            $this->load->view('plused_ca_view_booked_transfers', $data);
        else { // if(APP_THEME == "LTE")
            $data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/campus_manager/view_booked_transfers', $data);
        }
    }

    function ca_viewAllBookings() {
        authSessionMenu($this);
        $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
        $data['title'] = 'plus-ed.com | Bookings review';
        $data['breadcrumb1'] = 'Bookings review';
        $data['breadcrumb2'] = 'Bookings and excursions';
        $data["all_books"] = $this->mbackoffice->overviewBookings($campus, "all", "confirmed", "", "", 2);
        if (APP_THEME == "OLD")
            $this->load->view('plused_ca_view_all_bookings', $data);
        else { // if(APP_THEME == "LTE")
            $data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/campus_manager/view_all_bookings', $data);
        }
    }

    function ca_viewBookXx($idYear, $idBook, $idAgent) {
        if ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 553) {
            $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $data['title'] = 'plus-ed.com | Book extra excursions';
            $data['breadcrumb1'] = 'Bookings review';
            $data['breadcrumb2'] = 'Book extra excursions';
            $data["excursions"] = $this->magenti->getExtraExcbyCampusId($campus);
            $data["bookTitle"] = $idYear . "_" . $idBook;
            $data["bookId"] = $idBook;
            $data["numGL"] = count($this->mbackoffice->listPax($idBook, "GL"));
            $data["numSTD"] = count($this->mbackoffice->listPax($idBook, "STD"));
            $data["numALL"] = count($this->mbackoffice->listPax($idBook, "STD")) * 1 + count($this->mbackoffice->listPax($idBook, "GL")) * 1;
            $data["agencyName"] = $this->mbackoffice->agentNameById($idAgent);

            if (APP_THEME == "OLD")
                $this->load->view('plused_ca_viewBookXx', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/campus_manager/viewBookXx', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function ca_viewBookAtt($idYear, $idBook, $idAgent) {
        if ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 553) {
            $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $data['title'] = 'plus-ed.com | Book extra excursions';
            $data['breadcrumb1'] = 'Bookings review';
            $data['breadcrumb2'] = 'Book attractions';
            $data["excursions"] = $this->mbackoffice->getAllAttractions($campus);
            $data["idCampus"] = $campus;
            $data["bookTitle"] = $idYear . "_" . $idBook;
            $data["bookId"] = $idBook;
            $data["yearId"] = $idYear;
            $data["numGL"] = count($this->mbackoffice->listPax($idBook, "GL"));
            $data["numSTD"] = count($this->mbackoffice->listPax($idBook, "STD"));
            $data["numALL"] = count($this->mbackoffice->listPax($idBook, "STD")) * 1 + count($this->mbackoffice->listPax($idBook, "GL")) * 1;
            $data["agencyName"] = $this->mbackoffice->agentNameById($idAgent);

            if (APP_THEME == "OLD")
                $this->load->view('plused_ca_viewBookAtt', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/campus_manager/viewBookAtt', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function reviewOpTransfers() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $data["companies"] = $this->mbackoffice->getAllCompanies();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : '';
            $company = isset($_POST['companies']) ? $_POST['companies'] : '';
            $data["campus"] = $campus;
            $data["company"] = $company;
            $data["all_transfers"] = $this->mbackoffice->viewCmConfirmedTransfers($campus, $company);
            $data['title'] = 'plus-ed.com | Review transfers';
            $data['breadcrumb1'] = 'Transfers';
            $data['breadcrumb2'] = 'Review transfers';

            if (APP_THEME == "OLD")
                $this->load->view('plused_review_op_transfers', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/review_op_transfers', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function servicesReview() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : '';
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'planned';
            $from = isset($_POST['from']) ? $_POST['from'] : date("d/m/Y");
            $fromA = explode("/", $from);
            $fromGirato = $fromA[2] . "-" . $fromA[1] . "-" . $fromA[0];
            $to = isset($_POST['to']) ? $_POST['to'] : date("d/m/Y", strtotime($fromGirato . "+ 7 days"));
            $toA = explode("/", $to);
            $toGirato = $toA[2] . "-" . $toA[1] . "-" . $toA[0];
            $status = isset($_POST['status']) ? $_POST['status'] : 'all';
            $data["all_services"] = $this->mbackoffice->getAllServices("", $campus, $fromGirato, $toGirato, $tipo, $status);
            $data["campus"] = $campus;
            $data["tipo"] = $tipo;
            $data["to"] = $to;
            $data["from"] = $from;
            $data["status"] = $status;


            $data['title'] = 'plus-ed.com | Services review';
            $data['breadcrumb1'] = 'Transportation';
            $data['breadcrumb2'] = 'Services review by company';

            if (APP_THEME == "OLD")
                $this->load->view('plused_services_review', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/services_review', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function canceledBusReview() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["all_canceled"] = $this->mbackoffice->getAllCanceledBus();
            $data['title'] = 'plus-ed.com | Canceled Bus review';
            $data['breadcrumb1'] = 'Transportation';
            $data['breadcrumb2'] = 'Review canceled bus';

            if (APP_THEME == "OLD")
                $this->load->view('plused_canceled_review', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/canceled_review', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

// RIMUOVERE CON LA NUOVA VIEW PRONTA
    function ca_reviewByMonth($month = 6) {
        if ($this->session->userdata('role') == 200) {
            $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $data['allsis'] = $this->mbackoffice->sisByCenterId($campus);
            $accom = isset($_POST['accomo']) ? $_POST['accomo'] : '';
            $month = isset($_POST['month']) ? $_POST['month'] : 6;
            $datein = date("Y") . "-" . $month . "-01";
            $dateout = date("Y") . "-" . $month . "-30";
            if ($accom == "")
                $accom = strtolower($data['allsis'][0]["sistemazione"]);
            $data['simcalendar'] = $this->mbackoffice->getSimCalendar($campus, $accom, $datein, $dateout);
            $data['simbooking'] = $this->mbackoffice->getSimBooking($campus, $accom, $datein, $dateout);
            $data['title'] = 'plus-ed.com | Review campus by month - ' . $this->session->userdata('businessname') . ' - June ' . date("Y");
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Review campus by month';
            $data['campusname'] = $this->mbackoffice->centerNameById($campus);
            $data['campus'] = $campus;
            $data['accomodationname'] = $accom;
            $data['accomodation'] = $accom;
            $data['datein'] = $datein;
            $data['dateout'] = $dateout;
            $data['mese'] = $month;
            /*
              echo "<pre>";
              print_r($data['simcalendar']);
              echo "</pre>";

              echo "<pre>";
              print_r($data['simbooking']);
              echo "</pre>";
             */
            $this->load->view('plused_ca_reviewday2day', $data);
        }else {
            redirect('backoffice', 'refresh');
        }
    }

// FINE RIMOZIONE
//NUOVA VIEW CAMPUS MANAGER


    function ca_reviewday2day_pax() {
        if ($this->session->userdata('role') == 200) {
            $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $accom = isset($_POST['accomodation_in']) ? $_POST['accomodation_in'] : 1;
            $accomodation = $this->mbackoffice->getLowerSisById($accom);
            /*
              switch ($accom) {
              case 1:
              $accomodation = 'standard';
              break;
              case 2:
              $accomodation = 'ensuite';
              break;
              case 3:
              $accomodation = 'homestay';
              break;
              }
             */
            $month = isset($_POST['month_in']) ? $_POST['month_in'] : date("n");
            $year = isset($_POST['year_in']) ? $_POST['year_in'] : date("Y");
            $data['num_transfers'] = $this->mbackoffice->ca_getTransfersNum($campus, $month, $year);
            $data['num_excursions'] = $this->mbackoffice->ca_getExcursionsNum($campus, $month, $year);
            //print_r($data['num_transfers']);
            $data['bkgmesestandard'] = $this->mbackoffice->ca_getBkCalendar_pax($campus, 'standard', $month, $year);
            $data['bkgmeseensuite'] = $this->mbackoffice->ca_getBkCalendar_pax($campus, 'ensuite', $month, $year);
            $data['bkgmesehomestay'] = $this->mbackoffice->ca_getBkCalendar_pax($campus, 'homestay', $month, $year);
            $data['title'] = 'plus-ed.com | Review campus day 2 day';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Review campus day 2 day';
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $data['campusname'] = $this->mbackoffice->centerNameById($campus);
            $data['campus'] = $campus;
            $data['accomodationname'] = $accomodation;
            $data['accomodation'] = $accom;
            $data['month'] = $month;
            $data['year'] = $year;
            $this->load->view('plused_ca_reviewday2day_pax', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function ca_reviewday2day_pax_new() {
        if ($this->session->userdata('role') == 200) {
            $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $accom = isset($_POST['accomodation_in']) ? $_POST['accomodation_in'] : 1;
            $accomodation = $this->mbackoffice->getLowerSisById($accom);
            /*
              switch ($accom) {
              case 1:
              $accomodation = 'standard';
              break;
              case 2:
              $accomodation = 'ensuite';
              break;
              case 3:
              $accomodation = 'homestay';
              break;
              }
             */
            $month = isset($_POST['month_in']) ? $_POST['month_in'] : date("n");
            $year = isset($_POST['year_in']) ? $_POST['year_in'] : date("Y");
            $data['num_transfers'] = $this->mbackoffice->ca_getTransfersNum($campus, $month, $year);
            $data['num_excursions'] = $this->mbackoffice->ca_getExcursionsNum($campus, $month, $year);
            $data['num_extra_excursions'] = $this->mbackoffice->ca_getExtraExcursionsNum($campus, $month, $year);
            //print_r($data['num_transfers']);
            $data['bkgmesestandard'] = $this->mbackoffice->ca_getBkCalendar_pax($campus, 'standard', $month, $year);
            /* echo '<pre>';
              print_r($data['bkgmesestandard']);
              echo '</pre>';die; */
            $data['bkgmeseensuite'] = $this->mbackoffice->ca_getBkCalendar_pax($campus, 'ensuite', $month, $year);
            $data['bkgmesehomestay'] = $this->mbackoffice->ca_getBkCalendar_pax($campus, 'homestay', $month, $year);
            $data['bkgmesetwin'] = $this->mbackoffice->ca_getBkCalendar_pax($campus, 'twin', $month, $year);
            $data['title'] = 'plus-ed.com | Review campus day 2 day';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Review campus day 2 day';
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $data['campusname'] = $this->mbackoffice->centerNameById($campus);
            $data['campus'] = $campus;
            $data['accomodationname'] = $accomodation;
            $data['accomodation'] = $accom;
            $data['month'] = $month;
            $data['year'] = $year;
            $this->load->view('plused_ca_reviewday2day_pax_new', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

//FINE NUOVA VIEW CAMPUS MANAGER
//INIZIO NUOVA REVIEW BACKOFFICE DAY2DAY 18/06/2014

    function new_reviewday2day_pax_new() {
        if ($this->session->userdata('role') == 100) {
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 4;
            $month = isset($_POST['month_in']) ? $_POST['month_in'] : date("n");
            $year = isset($_POST['year_in']) ? $_POST['year_in'] : date("Y");
            $data['num_transfers'] = $this->mbackoffice->ca_getTransfersNum($campus, $month, $year);
            $data['num_excursions'] = $this->mbackoffice->ca_getExcursionsNum($campus, $month, $year);
            $data['num_extra_excursions'] = $this->mbackoffice->ca_getExtraExcursionsNum($campus, $month, $year);
            //print_r($data['num_extra_excursions']);
            $data['bkgmesestandard'] = $this->mbackoffice->ca_getBkCalendar_pax($campus, 'standard', $month, $year);
            $data['bkgmeseensuite'] = $this->mbackoffice->ca_getBkCalendar_pax($campus, 'ensuite', $month, $year);
            $data['bkgmesehomestay'] = $this->mbackoffice->ca_getBkCalendar_pax($campus, 'homestay', $month, $year);
            $data['title'] = 'plus-ed.com | Campus trips & participants';
            $data['breadcrumb1'] = 'Campus management';
            $data['breadcrumb2'] = 'Campus trips & participants';
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $data['campusname'] = $this->mbackoffice->centerNameById($campus);
            $data['campus'] = $campus;
            $data['month'] = $month;
            $data['year'] = $year;

            if (APP_THEME == "OLD")
                $this->load->view('plused_new_reviewday2day_pax_new', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/bookings/review_day_2_day_pax_new', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

//FINE NUOVA REVIEW BACKOFFICE DAY2DAY






    function setExcursionTransport() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $arr_key = array();
            $tot_pax = 0;
            foreach ($_POST as $key => $value) {
                if (strpos($key, "excur_") !== false) {
                    $t_key = explode("_", $key);
                    $arr_key[] = $t_key[1];
                    $v_key = explode("_", $value);
                    $t_exc_id = $v_key[2];
                    $tot_pax += $v_key[3];
                }
            }
            //print_r($arr_key);
            //echo "id escursione per recuperare i bus da jn_id_exc in tabella plused_exc_join---->".$t_exc_id;
            //echo "tot pax---->".$tot_pax;
            //echo "---->".$_POST['id_centro'];
            $campus = isset($_POST['id_centro']) ? $_POST['id_centro'] : '';
            $to = isset($_POST['to']) ? $_POST['to'] : '';
            $from = isset($_POST['from']) ? $_POST['from'] : '';
            $data["campusID"] = $campus;
            $data["campus"] = $this->mbackoffice->centerNameById($campus);
            $data["pickupPlace"] = $this->mbackoffice->centerPickupById($campus);
            $data["to"] = $to;
            $data["from"] = $from;
            //$data["arr_key"] = $arr_key;
            $data["tot_pax"] = $tot_pax;
            $data["escursione"] = $this->mbackoffice->excursionById($t_exc_id);
            $data["bookings"] = $this->mbackoffice->bkgDetailsForExcursion($arr_key);
            //print_r($data["bookings"]);
            $arrT = array();
            $arrF = array();
            foreach ($data["bookings"] as $bkU) {
                $arrT[] = $bkU["departure_date"];
                $arrF[] = $bkU["arrival_date"];
            }
            //print_r($arrT);
            //print_r($arrF);
            $minV = array_search(max($arrF), $arrF);
            $maxV = array_search(min($arrT), $arrT);
            $fromOk = date("Y-m-d", strtotime($arrF[$minV] . ' + 1 day'));
            $toOk = date("Y-m-d", strtotime($arrT[$maxV] . ' - 1 day'));
            $data["otherExc"] = $this->mbackoffice->getOtherExcursions($t_exc_id, $campus, $fromOk, $toOk);
            //print_r($data["otherExc"]);
            $data["bus"] = $this->mbackoffice->busListForExcursion($t_exc_id);
            //print_r($data["escursione"]);
            //print_r($data["bookings"]);
            //echo "<pre>";
            //print_r($data["bus"]);
            //echo "</pre>";
            $data['title'] = 'plus-ed.com | Book excursion bus';
            $data['breadcrumb1'] = 'Included excursions';
            $data['breadcrumb2'] = 'Book excursion bus';
            $this->load->view('plused_set_excursion_transport', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function reviewBusForPlan($busCode) {
        if ($this->session->userdata('role') == 100) {

            $data['title'] = 'plus-ed.com | Bus review for excursion plan detail - Code ' . $busCode;
            $data['breadcrumb1'] = 'Included excursions';
            $data['breadcrumb2'] = 'Bus review for included excursion plan detail - Code ' . $busCode;
            $data["bus_detail"] = $this->mbackoffice->busDetailForExcursion($busCode);
            $data["plan_detail"] = $this->mbackoffice->excDetail($busCode);
            //print_r($data["plan_detail"]);
            $arrayescursioni = $this->mbackoffice->getExcIdsFromBusCode($busCode);
            $data["bkg_detail"] = $this->mbackoffice->bkgDetailsForExcursion($arrayescursioni);
            $arrayPrenotazioni = array();
            foreach ($data["bkg_detail"] as $sbooking) {
                array_push($arrayPrenotazioni, $sbooking["exb_id_book"]);
            }
            $data["bus_code"] = $busCode;
            $data["allpax"] = $this->mbackoffice->getExcPaxForBusCode($busCode);
            $data["status_ex"] = $this->mbackoffice->getExcStatusByBusCode($busCode);
            $data["bus"] = $this->mbackoffice->busListForExcursion($data["plan_detail"][0]["pbe_jnidexc"]);
            if (count($data["status_ex"]) != 1) {
                echo "ERROR!";
                die();
            }

            $this->load->view('plused_review_bus_for_plan', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function plusedConfirmBuses() {
        if ($this->session->userdata('role') == 100) {
            $exc_numb = isset($_POST['exc_numb']) ? $_POST['exc_numb'] : '';
            if ($exc_numb == '') {
                echo "ERROR! No Bookings involved!";
                die();
            } else {
                $s_exc_date = isset($_POST['s_exc_date']) ? $_POST['s_exc_date'] : '';
                if ($s_exc_date == '') {
                    echo "ERROR! No Excursion Date!";
                    die();
                } else {
                    $exc_date_arr = explode("/", $s_exc_date);
                    $exc_date = $exc_date_arr[2] . "-" . $exc_date_arr[1] . "-" . $exc_date_arr[0];
                    $busCode = $this->mbackoffice->busCode();
                    foreach ($exc_numb as $knum => $vnum) {
                        $this->mbackoffice->standbyCodeExcursion($busCode, $vnum, $exc_date);
                    }
                }
            }
            foreach ($_POST as $key => $value) {
                $pos = strpos($key, "bus_");
                if ($pos !== false) {
                    if ($value > 0) {
                        $arrnumbus = explode("_", $key);
                        $numIdBus = $arrnumbus[1];
                        $addBusTab = $this->mbackoffice->addBusTab($numIdBus, $value, $exc_date, $busCode);
                        //echo "||$addBusTab|| <br>--->$key --> id bus = $numIdBus | qty bus = $value | id exc = ".$_POST['id_exc_join']." | costo singolo bus = ".$_POST[$strCostoBus]." | data escursione = ".$exc_date." | hpickup = ".$_POST['pickup_time']." | hreturn = ".$_POST['return_hour']." | place pickup = ".$_POST['pickup_place']." | currency = ".$_POST[$strCurrencyBus];
                    }
                }
            }
            //REDIRECT AL DETTAGLIO PASSANDO IN GET $busCode
            redirect('backoffice/busExcDetail/code_' . $busCode, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function plusedConfirmTransfersBuses() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            //foreach($_POST as $key => $value){
            //	echo "<br> $key ---> $value";
            //}
            //die();
            $exc_numb = isset($_POST['exc_numb']) ? $_POST['exc_numb'] : '';
            if ($exc_numb == '') {
                echo "ERROR! No Bookings involved!";
                die();
            } else {
                $quando_tra = isset($_POST['quando_tra']) ? $_POST['quando_tra'] : '';
                if ($quando_tra == '') {
                    echo "ERROR! No Transfer Date!";
                    die();
                } else {
                    $exc_date = $quando_tra;
                    $busCode = $this->mbackoffice->busCode();
                    //print_r($exc_numb);
                    //die();
                    foreach ($exc_numb as $knum => $vnum) {
                        $this->mbackoffice->standbyTransferExcursion($busCode, $vnum, $exc_date);
                    }
                }
            }
            foreach ($_POST as $key => $value) {
                $pos = strpos($key, "bus_");
                if ($pos !== false) {
                    if ($value > 0) {
                        $arrnumbus = explode("_", $key);
                        $numIdBus = $arrnumbus[1];
                        $addBusTab = $this->mbackoffice->addBusTab($numIdBus, $value, $exc_date, $busCode);
                        //echo "||$addBusTab|| <br>--->$key --> id bus = $numIdBus | qty bus = $value | id exc = ".$_POST['id_exc_join']." | costo singolo bus = ".$_POST[$strCostoBus]." | data escursione = ".$exc_date." | hpickup = ".$_POST['pickup_time']." | hreturn = ".$_POST['return_hour']." | place pickup = ".$_POST['pickup_place']." | currency = ".$_POST[$strCurrencyBus];
                    }
                }
            }
            //REDIRECT AL DETTAGLIO PASSANDO IN GET $busCode
            redirect('backoffice/busTraDetail/code_' . $busCode, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function plusedConfirmReviewBuses($busCode) {
        if ($this->session->userdata('role') == 100) {
            $remBusTab = $this->mbackoffice->remBusTab($busCode);
            //echo "||remBusTab|| ---> $busCode ";
            $s_exc_date = isset($_POST['s_exc_date']) ? $_POST['s_exc_date'] : '';
            //$exc_date_arr = explode("/",$s_exc_date);
            //$exc_date = $exc_date_arr[2]."-".$exc_date_arr[1]."-".$exc_date_arr[0];
            foreach ($_POST as $key => $value) {
                $pos = strpos($key, "bus_");
                if ($pos !== false) {
                    if ($value > 0) {
                        $arrnumbus = explode("_", $key);
                        $numIdBus = $arrnumbus[1];
                        $addBusTab = $this->mbackoffice->addBusTab($numIdBus, $value, $s_exc_date, $busCode);
                        //echo "||addBusTab|| <br>--->$key --> id bus = $numIdBus | qty bus = $value | id exc = ".$_POST['id_exc_join']." | costo singolo bus = ".$_POST[$strCostoBus]." | data escursione = ".$exc_date." | hpickup = ".$_POST['pickup_time']." | hreturn = ".$_POST['return_hour']." | place pickup = ".$_POST['pickup_place']." | currency = ".$_POST[$strCurrencyBus];
                    }
                }
            }
            //die();
            //REDIRECT AL DETTAGLIO PASSANDO IN GET $busCode
            redirect('backoffice/busExcDetail/code_' . $busCode, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function busExcDetail($codeBus, $called_from = "") {
//        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $codeBusArr = explode("_", $codeBus);
            $data['title'] = 'plus-ed.com | Included excursion plan detail - Code ' . $codeBusArr[1];
            $data['breadcrumb1'] = 'Included excursions';
            $data['breadcrumb2'] = 'Included excursion plan detail - Code ' . $codeBusArr[1];
            $data["bus_detail"] = $this->mbackoffice->busDetailForExcursion($codeBusArr[1]);
            $data["plan_detail"] = $this->mbackoffice->excDetail($codeBusArr[1]);
            //print_r($data["plan_detail"]);die;
            $arrayescursioni = $this->mbackoffice->getExcIdsFromBusCode($codeBusArr[1]);
            $data["bkg_detail"] = $this->mbackoffice->bkgDetailsForExcursion($arrayescursioni);
            $arrayPrenotazioni = array();
            foreach ($data["bkg_detail"] as $sbooking) {
                array_push($arrayPrenotazioni, $sbooking["exb_id_book"]);
            }
            $data["bus_code"] = $codeBusArr[1];
            $data["allpax"] = $this->mbackoffice->getExcPaxForBusCode($codeBusArr[1]);
            $data["status_ex"] = $this->mbackoffice->getExcStatusByBusCode($codeBusArr[1]);
            $data["others"] = array();
            if(count($data["plan_detail"]))
                $data["others"] = $this->mbackoffice->otherGroupsForExc($data["plan_detail"][0]["pbe_jnidexc"], $data["plan_detail"][0]["pbe_excdate"], $arrayPrenotazioni);


            if (count($data["status_ex"]) != 1) {
                echo "ERROR!";
                die();
            }

            if (APP_THEME == "OLD")
                $this->load->view('plused_excursion_plan_detail', $data);
            else { // if(APP_THEME == "LTE")
                if ($called_from == "transportation")
                    $data['breadcrumb1'] = "Transportation";

                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/excursion_plan_detail', $data);
            }
        }
        else {
            redirect('backoffice', 'refresh');
        }
    }

    function busAllExcDetail($codeBus) {
//        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $codeBusArr = explode("_", $codeBus);
            $data['title'] = 'plus-ed.com | Extra excursion plan detail - Code ' . $codeBusArr[1];
            $data['breadcrumb1'] = 'Extra excursions';
            $data['breadcrumb2'] = 'Extra excursion plan detail - Code ' . $codeBusArr[1];
            $data["bus_detail"] = $this->mbackoffice->busDetailForExcursion($codeBusArr[1]);
            $data["plan_detail"] = $this->mbackoffice->excDetail($codeBusArr[1]);
            //print_r($data["plan_detail"]);
            $arrayescursioni = $this->mbackoffice->getAllExcIdsFromBusCode($codeBusArr[1]);
            $data["bkg_detail"] = $this->mbackoffice->bkgDetailsForAllExcursions($arrayescursioni);
            //print_r($data["bkg_detail"]);
            $arrayPrenotazioni = array();
            foreach ($data["bkg_detail"] as $sbooking) {
                $onlyBookA = explode("_", $sbooking["pte_book_id"]);
                $onlyBook = $onlyBookA[1];
                array_push($arrayPrenotazioni, $onlyBook);
            }
            $data["bus_code"] = $codeBusArr[1];
            $data["allpax"] = $this->mbackoffice->getAllExcPaxForBusCode($codeBusArr[1]);
            $data["effettivi"] = $this->mbackoffice->getAllExcRealPaxForBusCode($codeBusArr[1]);
            $data["status_ex"] = $this->mbackoffice->getAllExcStatusByBusCode($codeBusArr[1]);
            $data["tipo_ex"] = $this->mbackoffice->getAllExcTypeByBusCode($codeBusArr[1]);
            $data["others"] = $this->mbackoffice->otherGroupsForAllExc($data["plan_detail"][0]["exc_id_centro"], $data["plan_detail"][0]["pbe_jnidexc"], $data["plan_detail"][0]["pbe_excdate"], $arrayPrenotazioni);
            $data["ruolo"] = $this->session->userdata('role');

            if (APP_THEME == "OLD")
                $this->load->view('plused_all_excursion_plan_detail', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/all_excursion_plan_detail', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function bookExtraExcursionForGroup($tripleIds) {
        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200) {
            $idsA = explode("_", $tripleIds);
            $excId = $idsA[1];
            $bookId = $idsA[2];
            $busCode = $idsA[3];
            $bookExtraExcursionForGroup = $this->mbackoffice->bookExtraExcursionForGroup($excId, $bookId, $busCode, 0, 0);
            redirect('backoffice/busAllExcDetail/code_' . $busCode, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function bookCA_ExtraExcursionForGroup($tripleIds) {
        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200) {
            $idsA = explode("_", $tripleIds);
            $excId = $idsA[1];
            $bookId = $idsA[2];
            $busCode = $idsA[3];
            $amountR = $idsA[4];
            $centerID = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $centerIDBkg = $this->mbackoffice->campusIdByBookingId($bookId);
            if ($centerIDBkg == $centerID) {
                $bookExtraExcursionForGroup = $this->mbackoffice->bookExtraExcursionForGroup($excId, $bookId, $busCode, 1, $amountR);
                redirect('backoffice/ca_viewAllBookings', 'refresh');
            } else {
                echo "ERROR!";
                die();
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function bookCA_AttractionForGroup($tripleIds) {
        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200) {
            $idsA = explode("_", $tripleIds);
            $id_book = $idsA[1];
            $id_year = $idsA[2];
            $id_attr = $idsA[3];
            $id_campus = $idsA[4];
            $allNum = $idsA[5];
            $STDprice = $idsA[6];
            $currencyName = $idsA[7];
            $CMprice = $idsA[8];
            $cur_id = $this->mbackoffice->currencyIdByCode($currencyName);
            $bookExtraExcursionForGroup = $this->mbackoffice->ca_bookAttractionNow($id_book, $id_year, $id_attr, $id_campus, $allNum, $STDprice, $cur_id, $CMprice);
            redirect('backoffice/ca_viewAllBookings', 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function setExcReview($busCode) {
        if ($this->session->userdata('role') == 200) {
            $setExcReview = $this->mbackoffice->setExcReview($busCode);
            redirect('backoffice/busExcDetail/code_' . $busCode, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function ca_getPriceForAttraction($idAtt, $numGL, $numSTD) {
        if ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 553) {
            echo $this->mbackoffice->ca_getPriceForAttraction($idAtt, $numGL, $numSTD);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function busTraDetail($codeBus) {
//tutti i riferimenti commentati a plused_exc_bookings devono essere girati a plused_tra_transfers
//        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200 or $this->session->userdata('role') == 553) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $codeBusArr = explode("_", $codeBus);
            $data['title'] = 'plus-ed.com | Transfer plan detail - Code ' . $codeBusArr[1];
            $data['breadcrumb1'] = 'Transportation';
            $data['breadcrumb2'] = 'Transfer plan detail - Code ' . $codeBusArr[1];
            $data["bus_detail"] = $this->mbackoffice->busDetailForExcursion($codeBusArr[1]);
            $data["plan_detail"] = $this->mbackoffice->excDetail($codeBusArr[1]);
            $arrayescursioni = $this->mbackoffice->getTraIdsFromBusCode($codeBusArr[1]);
            $data["bkg_detail"] = $this->mbackoffice->bkgDetailsForTransfer($arrayescursioni);
            $data["bus_code"] = $codeBusArr[1];
            $data["allpax"] = $this->mbackoffice->getTraPaxForBusCode($codeBusArr[1]);
            $data["effettivi"] = $this->mbackoffice->getTraRealPaxForBusCode($codeBusArr[1]);
            $data["status_ex"] = $this->mbackoffice->getTraStatusByBusCode($codeBusArr[1]);
            $data["tipo_ex"] = $this->mbackoffice->getTraTypeByBusCode($codeBusArr[1]);
            $arrayPrenotazioni = array();
            foreach ($data["bkg_detail"] as $sbooking) {
                $onlyBookA = explode("_", $sbooking["ptt_book_id"]);
                $onlyBook = $onlyBookA[1];
                array_push($arrayPrenotazioni, $onlyBook);
            }
            //$data["others"] = $this->mbackoffice->otherGroupsForTransfers("inbound",$data["plan_detail"][0]["exc_id_centro"],$data["plan_detail"][0]["pbe_jnidexc"],$data["plan_detail"][0]["pbe_excdate"],$arrayPrenotazioni);
            $data["ruolo"] = $this->session->userdata('role');
            //if(count($data["status_ex"]) != 1){
            //	echo "ERROR!";
            //	die();
            //}

            if (APP_THEME == "OLD")
                $this->load->view('plused_transfer_plan_detail', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/campus_manager/transfer_plan_detail', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function busExcReset($codeBus) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $this->mbackoffice->busExcReset($codeBus);
            redirect('backoffice/viewPlannedExcursions', 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function addGroupToBusCode($codeBus, $exbId, $excDate) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $this->mbackoffice->addGroupToBusCode($codeBus, $exbId, $excDate);
            redirect('backoffice/busExcDetail/code_' . $codeBus, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function busExcConfirm($codeBus) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $this->mbackoffice->busExcConfirm($codeBus);
            redirect('backoffice/viewPlannedExcursions', 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function busTraReset($codeBus) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $this->mbackoffice->busTraReset($codeBus);
            redirect('backoffice/viewBookedTransfers', 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function busTraConfirm($codeBus) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $this->mbackoffice->busTraConfirm($codeBus);
            redirect('backoffice/viewBookedTransfers', 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function busAllExcReset($codeBus, $tipoe) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $referMe = "viewPlannedExcursions";
            if ($tipoe == "extra") {
                $referMe = "viewPlannedAllExcursions";
            }
            $this->mbackoffice->busAllExcReset($codeBus);
            redirect('backoffice/' . $referMe, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function busAllExcConfirm($codeBus) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $this->mbackoffice->busAllExcConfirm($codeBus);
            redirect('backoffice/viewPlannedAllExcursions', 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function printPDFExc($busCode) {
        if ($this->session->userdata('role') == 100) {
            $data["bus_detail"] = $this->mbackoffice->busDetailForExcursion($busCode);
            $companyID = $data["bus_detail"][0]["tra_cp_id"];
            $data["first_company_detail"] = $this->mbackoffice->companyById($companyID);
            $data["plan_detail"] = $this->mbackoffice->excDetail($busCode);
            $arrayescursioni = $this->mbackoffice->getExcIdsFromBusCode($busCode);
            $data["bkg_detail"] = $this->mbackoffice->bkgDetailsForExcursion($arrayescursioni);
            $data["bus_code"] = $busCode;
            $data["allpax"] = $this->mbackoffice->getExcPaxForBusCode($busCode);
            $data["isModified"] = $this->mbackoffice->getIsModifiedForBusCode($busCode);
            $this->load->plugin('to_pdf');
            $html = $this->load->view('PDF_excursion_plan', $data, true);
            if ($data["isModified"] == 1) {
                pdf_create($html, 'pdf_excursion_plan_' . $busCode . '_MODIFIED');
            } else {
                pdf_create($html, 'pdf_excursion_plan_' . $busCode);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function printPDFTra($busCode) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["bus_detail"] = $this->mbackoffice->busDetailForExcursion($busCode);
            $companyID = $data["bus_detail"][0]["tra_cp_id"];
            $data["first_company_detail"] = $this->mbackoffice->companyById($companyID);
            $data["plan_detail"] = $this->mbackoffice->excDetail($busCode);
            $arrayescursioni = $this->mbackoffice->getTraIdsFromBusCode($busCode);
            $data["bkg_detail"] = $this->mbackoffice->bkgDetailsForTransfer($arrayescursioni);
            $data["tipotransfer"] = $data["bkg_detail"][0]["ptt_type"];
            $data["bus_code"] = $busCode;
            $data["allpax"] = $this->mbackoffice->getTraPaxForBusCode($busCode);
            $this->load->plugin('to_pdf');
            $html = $this->load->view('PDF_transfer_plan', $data, true);
            pdf_create($html, 'pdf_transfer_plan_' . $busCode);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function printPDFAllExc($busCode) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["bus_detail"] = $this->mbackoffice->busDetailForExcursion($busCode);
            $companyID = $data["bus_detail"][0]["tra_cp_id"];
            $data["first_company_detail"] = $this->mbackoffice->companyById($companyID);
            $data["plan_detail"] = $this->mbackoffice->excDetail($busCode);
            $arrayescursioni = $this->mbackoffice->getAllExcIdsFromBusCode($busCode);
            $data["bkg_detail"] = $this->mbackoffice->bkgDetailsForAllExcursion($arrayescursioni);
            $data["bus_code"] = $busCode;
            $data["allpax"] = $this->mbackoffice->getAllExcPaxForBusCode($busCode);
            $this->load->plugin('to_pdf');
            $html = $this->load->view('PDF_all_excursion_plan', $data, true);
            pdf_create($html, 'pdf_all_excursion_plan_' . $busCode);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function printPDFAllGlByBkId($bkId) {
        if ($this->session->userdata('role')) {
            $data["glDetails"] = $this->mbackoffice->getGlDetailsByBkId($bkId);
            $data['agency'] = $this->mbackoffice->agent_detail($data["glDetails"][0]["id_agente"]);
            $this->load->plugin('to_pdf');
            $html = $this->load->view('PDF_gl_details', $data, true);
            pdf_create($html, 'pdf_all_gl_details_' . $bkId);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function companiesDetails() {
        //if ($this->session->userdata('role') == 100 || $this->session->userdata('role') == 200 || $this->session->userdata('role') == 553) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["companies"] = $this->mbackoffice->getAllCompanies();
            $data['title'] = 'plus-ed.com | Companies details';
            $data['breadcrumb1'] = 'Transportation';
            $data['breadcrumb2'] = 'Companies details';

            if (APP_THEME == "OLD")
                $this->load->view('plused_companies_details', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/campus_manager/companies_details', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function traExcursionExists() {
        if ($this->session->userdata('ruolo') == "superuser") {
            $id_book = isset($_POST['codesearch']) ? $_POST['codesearch'] : '';
            $bkgExists = 0;
            $bkgExists = $this->mbackoffice->traExcursionExists($id_book);
            if ($bkgExists != 0) {
                echo "exc_" . $bkgExists;
            } else {
                $bkgExists = $this->mbackoffice->traTransferExists($id_book);
                if ($bkgExists != 0) {
                    echo "tra_" . $bkgExists;
                } else {
                    $bkgExists = $this->mbackoffice->traExtraExists($id_book);
                    echo "ext_" . $bkgExists;
                }
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function insertAllExc($year = "") {
        if ($this->session->userdata('role') == 100) {
            if ($year == "")
                $year = date("Y");
            $data['insertAllExc'] = $this->mbackoffice->insertAllExc($year);
        }else {
            echo "ERROR!";
            die();
        }
    }

    function scheduledInsertAllExc__($year = "") {
        if ($year == "")
            $year = date("Y");
        $data['insertAllExc'] = $this->mbackoffice->insertAllExc($year);
        echo "done";
    }

    function moveConfirmedExcursion(){
        $this->load->model('agents/mapbookmodel');
        $numRows = $this->mapbookmodel->moveConfirmedExcursion();
        echo "Total rows inserted: ".$numRows;
    }

    function _importStudyCSV() {
        if ($this->session->userdata('role') == 100) {
            $data['importStudyCSV'] = $this->mbackoffice->importStudyCSV();
            ?>
            <a href="<?php echo base_url(); ?>index.php/backoffice/syncStudyPax" title="Sync Studytours Pax">Continue to Sync Studytours Pax</a>
            <?php
        } else {
            echo "ERROR!";
            die();
        }
    }

    function _syncStudyPax() {
        if ($this->session->userdata('role') == 100) {
            $data['syncStudyPax'] = $this->mbackoffice->syncStudyPax();
            ?>
            <a target="_blank" href="<?php echo base_url(); ?>index.php/backoffice/checkTransfersStudy/inbound" title="Check Pax on inbound transfers">Continue to Check Pax on inbound transfers</a><br />
            <a target="_blank" href="<?php echo base_url(); ?>index.php/backoffice/checkTransfersStudy/outbound" title="Check Pax on outbound transfers">Continue to Check Pax on outbound transfers</a>
            <?php
        } else {
            echo "ERROR!";
            die();
        }
    }

//passare idbookyear in formato 2013_250 che deve corrispondere al nome file .csv
    function importAgentsCSV($idyearbook) {
        if ($this->session->userdata('role') == 100) {
            $data['importAgentsCSV'] = $this->mbackoffice->importAgentsCSV($idyearbook);
        } else {
            echo "ERROR!";
            die();
        }
    }

    function detMyPax($year, $book) {
        if ($this->session->userdata('role') == 100) {
            $data['detMyPax'] = $this->mbackoffice->detMyPax($year, $book);
            $this->load->view('plused_micro_detMyPax', $data);
        } else {
            echo "ERROR!";
            die();
        }
    }

    function detCaMyPax($year, $book) {
        if ($this->session->userdata('role') == 200) {
            $centerID = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $centerIDBkg = $this->mbackoffice->centerIdByBkgId($year, $book);
            if ($centerIDBkg == $centerID) {
                $data['detMyPax'] = $this->mbackoffice->detMyPax($year, $book);
                $this->load->view('plused_micro_detMyPax', $data);
            } else {
                echo "ERROR!";
                die();
            }
        } else {
            echo "ERROR!";
            die();
        }
    }

    function csvCaMyPax($year, $book) {
        if ($this->session->userdata('role') == 200) {
            $centerID = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $centerIDBkg = $this->mbackoffice->centerIdByBkgId($year, $book);
            if ($centerIDBkg == $centerID) {
                $data['detMyPax'] = $this->mbackoffice->detMyPax($year, $book);
                $testariga[0] = array(
                    "accomodation" => "Accomodation",
                    "cognome" => "Surname",
                    "nome" => "Name",
                    "sesso" => "Sex",
                    "salute" => "Allergies/Cautions",
                    "numero_documento" => "Document Number",
                    "tipo_pax" => "Type",
                    "gl_rif" => "GL Reference",
                    "share_room" => "Share Room With",
                    "pax_dob" => "Date of Birth",
                    "andata_data_arrivo" => "Date/Time of Arrival",
                    "andata_apt_partenza" => "Arrival Origin Airport",
                    "andata_apt_arrivo" => "Arrival Destination Airport",
                    "andata_volo" => "Arrival Flight",
                    "ritorno_data_partenza" => "Date/Time of Departure",
                    "ritorno_apt_partenza" => "Departure Origin Airport",
                    "ritorno_apt_arrivo" => "Departure Arrival Airport",
                    "ritorno_volo" => "Departure Flight",
                    "bookid" => "Book ID",
                    "businessname" => "Agency"
                );
                array_unshift($data['detMyPax'], $testariga[0]);

                $fileCSVName = array_to_csv($data['detMyPax'], 'pax_list.csv');

                $this->load->library('excel');
                $inputFileType = 'CSV';
                $inputFileName = $fileCSVName;
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setDelimiter(";");
                $objReader->setInputEncoding('UTF-8');

                $objPHPExcel = $objReader->load($inputFileName);



                $filename = 'export_' . $this->session->userdata('businessname') . '_' . $year . '_' . $book . '.xls';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');







                die();
            } else {
                echo "ERROR!";
                die();
            }
        } else {
            echo "ERROR!";
            die();
        }
    }

    function printDetCaMyPax($year, $book) {
        if ($this->session->userdata('role') == 200) {
            $centerID = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $centerIDBkg = $this->mbackoffice->centerIdByBkgId($year, $book);
            if ($centerIDBkg == $centerID) {
                $data['detMyPax'] = $this->mbackoffice->detMyPax($year, $book);
                $this->load->plugin('to_pdf');
                $html = $this->load->view('PDF_plused_micro_detMyPax', $data, true);
                pdf_create($html, 'pdf_pax_detail_' . $year . '_' . $book);
            } else {
                echo "ERROR!";
                die();
            }
        } else {
            echo "ERROR!";
            die();
        }
    }

    function infoday2dayArrivalPax($campus, $accomodation, $date, $status = "", $tipo = "") {
        if ($this->session->userdata('role') == 100) {
            switch ($accomodation) {
                case 1:
                    $accomodation = 'standard';
                    break;
                case 2:
                    $accomodation = 'ensuite';
                    break;
                case 3:
                    $accomodation = 'homestay';
                    break;
            }
            $data['detMyPax'] = $this->mbackoffice->getD2DBkArrivalPax($campus, $accomodation, $date, $status, $tipo);
            $this->load->view('plused_micro_detMyPax', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function csvArrivalPax($campus, $accomodation, $date, $status = "", $tipo = "") {
        if ($this->session->userdata('role') == 100) {
            switch ($accomodation) {
                case 1:
                    $accomodation = 'standard';
                    break;
                case 2:
                    $accomodation = 'ensuite';
                    break;
                case 3:
                    $accomodation = 'homestay';
                    break;
            }
            $data['detMyPax'] = $this->mbackoffice->getD2DBkArrivalPax($campus, $accomodation, $date, $status, $tipo);
            //echo "<pre>";
            //print_r($data['detMyPax']);
            //echo "</pre>";
            $testariga[0] = array(
                "bookid" => "Book ID",
                "centro" => "Campus",
                "businessname" => "Agency",
                "status" => "Status",
                "tipo_pax" => "Type",
                "accomodation" => "Accomodation",
                "cognome" => "Surname",
                "nome" => "Name",
                "sesso" => "Sex",
                "pax_dob" => "Date of Birth",
                "salute" => "Allergies/Cautions",
                "numero_documento" => "Document Number",
                "gl_rif" => "GL Reference",
                "share_room" => "Share Room With",
                "andata_data_arrivo" => "Date/Time of Arrival",
                "andata_volo" => "Arrival Flight",
                "andata_apt_arrivo" => "Arrival Destination Airport",
                "andata_apt_partenza" => "Arrival Origin Airport",
                "ritorno_data_partenza" => "Date/Time of Departure",
                "ritorno_volo" => "Departure Flight",
                "ritorno_apt_partenza" => "Departure Origin Airport",
                "ritorno_apt_arrivo" => "Departure Arrival Airport"
            );
            //echo "<pre>";
            //print_r($testariga);
            //echo "</pre>";
            array_unshift($data['detMyPax'], $testariga[0]);
            //$csvMyPax = array_merge($testariga + $data['detMyPax']);
            //echo "<pre>";
            //print_r($data['detMyPax']);
            //echo "</pre>";
            //die();
            array_to_csv($data['detMyPax'], 'pax_list.csv');
            die();
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function setTransfers($in_out) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : "";
            $when = isset($_POST['when']) ? $_POST['when'] : date("d/m/Y");
            $data["campus"] = $campus;
            $data["when"] = $when;
            $data["in_out"] = $in_out;
            if ($in_out == "inbound")
                $data["all_transfers"] = $this->mbackoffice->setTransfers($campus, $when);
            else
                $data["all_transfers"] = $this->mbackoffice->setTransfersOut($campus, $when);
            $data['title'] = 'plus-ed.com | Book ' . $in_out . ' transfers';
            $data['breadcrumb1'] = 'Transfers';
            $data['breadcrumb2'] = 'Book ' . $in_out . ' transfers';
            if ($in_out == "inbound") {
                if (APP_THEME == "OLD")
                    $this->load->view('plused_set_transfers', $data);
                else { // if(APP_THEME == "LTE")
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/super_user/set_transfers', $data);
                }
            } else {
                if (APP_THEME == "OLD")
                    $this->load->view('plused_set_transfers_out', $data);
                else { // if(APP_THEME == "LTE")
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/super_user/set_transfers_out', $data);
                }
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function setTransfersTransport($type, $campus, $quando) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            if(!empty($_POST))
            {
                $tuttiPax = 0;
                $insertTransfers = $this->mbackoffice->setTransfersTransport($type, $quando);
                $allTransfers = $this->mbackoffice->getTransfersById($insertTransfers);
                foreach ($allTransfers as $uT) {
                    $tuttiPax+=$uT["tot_pax"];
                    if ($type == "inbound") {
                        $airport = $uT["ptt_airport_to"];
                    } else {
                        $airport = $uT["ptt_airport_from"];
                    }
                }
                if ($tuttiPax <= 0) {
                    echo "ERROR";
                    die();
                }
                $data["tot_pax"] = $tuttiPax;
                $data["bus"] = $this->mbackoffice->busListForTransfers($campus, $airport, $type);
                $data["pickupPlace"] = $this->mbackoffice->centerPickupById($campus);
                $data["excursion_id"] = 0;
                $data["airport"] = "";
                if ($data["bus"]) {
                    $data["excursion_id"] = $data["bus"][0]["exc_id"];
                    $data["airport"] = $data["bus"][0]["exc_excursion"];
                }
                //print_r($allTransfers);
                //print_r($data["bus"]);
                $data["in_out"] = $type;
                $data["quando"] = $quando;
                $data["allTransfers"] = $allTransfers;
                $data['title'] = 'plus-ed.com | Book bus for' . $type . ' transfers';
                $data['breadcrumb1'] = 'Transfers';
                $data['breadcrumb2'] = 'Book bus for ' . $type . ' transfers';

                if (APP_THEME == "OLD")
                    $this->load->view('plused_set_transfers_transports', $data);
                else { // if(APP_THEME == "LTE")
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/super_user/set_transfers_transports', $data);
                }
            }else{
                redirect('backoffice/setTransfers/'.$type, 'refresh');
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function generateUUID() {
        do {
            $newpwd = $this->mbackoffice->generateUUID();
            $i = $this->mbackoffice->checkUUID($newpwd);
        } while ($i > 0);
        return $newpwd;
    }

    function insertUUIDRows() {
        if ($this->session->userdata('role') == 100) {
            $insertUUIDRows = $this->mbackoffice->insertUUIDRows();
        }
    }

    function _checkTransfersStudy($tipo) {
        if ($this->session->userdata('role') == 100) {
            $checkTransfersStudy = $this->mbackoffice->checkTransfersStudy($tipo);
            if ($checkTransfersStudy) {
                //echo $checkTransfersStudy;
                $a_email = "smarra@plus-ed.com";
                $cc_email = "operations@plus-ed.com";
                $bcc_email = "a.sudetti@gmail.com, l.pombo@plus-ed.com, e.bettoni@plus-ed.com, michael.hollinshead@plus-ed.com";
                $this->load->library('email');
                $mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
                $mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
                $mymessage .= "<strong>  Please pay your attention to the following list of passengers removed from " . $tipo . " transfers: </strong><br/><br/>";
                $mymessage .= $checkTransfersStudy . "<br />";
                $mymessage .= "<strong>Plus Sales Office</strong>" . "<br/><br/>";
                $mymessage .= "</body></html>";

                $this->email->from('info@plus-ed.com', 'Plus Sales Office');
                $this->email->to($a_email);
                $this->email->cc($cc_email);
                $this->email->bcc($bcc_email);
                $this->email->subject('Plus Sales Office - ' . ucfirst($tipo) . ' transfers review.');
                $this->email->message($mymessage);
                $this->email->send();
            } else {
                echo "no changes";
            }
        }
    }

    function uploadFormPax($year, $book, $idcampus) {
        //echo "$year, $book, $idcampus";
        if ($this->session->userdata('role') == 100) {
            $config['upload_path'] = '../import_agents_pax/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';
            $config['overwrite'] = TRUE;
            $config['file_name'] = $year . "_" . $book . ".csv";

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $data["error"] = $this->upload->display_errors();
                $data["year"] = $year;
                $data["book"] = $book;
                $data["idcampus"] = $idcampus;
                $this->load->view('plused_upload_pax', $data);
            } else {
                $idyearbook = $year . "_" . $book;
                $data ["upload_data"] = $this->upload->data();
                $importAgentsCSV = $this->mbackoffice->importAgentsCSV($idyearbook);
                if ($importAgentsCSV == "OK") {
                    //INVIO MAIL
                    $nomeCampus = $this->mbackoffice->centerNameById($idcampus);
                    $mailto = $this->mbackoffice->getCmMailFromCampusId($idcampus);
                    $locateCampus = $this->mbackoffice->getLocationByCampusId($idcampus);
                    switch ($locateCampus) {
                        case 'United Kingdom':
                            $mailccarray = array('smarra@plus-ed.com', 'operations@plus-ed.com');
                            break;
                        case 'Ireland':
                            $mailccarray = array('smarra@plus-ed.com', 'operations@plus-ed.com');
                            break;
                        case 'Malta':
                            $mailccarray = array('smarra@plus-ed.com', 'operations@plus-ed.com');
                            break;
                        case 'USA':
                            $mailccarray = array('v.verta@studytours.it', 'lrandolph@rider.edu');
                            break;
                    }
                    $this->load->library('email');
                    $mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
                    $mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
                    $mymessage .= "<strong>Booking " . $idyearbook . " </strong><br/><br/>";
                    $mymessage .= "Roster for booking " . $idyearbook . " has been uploaded @" . $nomeCampus . ".<br />";
                    $mymessage .= "<strong>Plus Sales Office</strong>" . "<br/><br/>";
                    $mymessage .= "</body></html>";

                    $this->email->from('info@plus-ed.com', 'Plus Sales Office');
                    $this->email->to($mailto);
                    $this->email->cc($mailccarray);
                    $this->email->bcc('a.sudetti@gmail.com');
                    $this->email->subject('Plus Sales Office - Roster uploaded for booking ' . $idyearbook . ' @' . $nomeCampus);
                    $this->email->message($mymessage);
                    $this->email->send();
                    $this->load->view('plused_upload_success', $data);
                } else {
                    echo "ERROR IMPORTING!<br /> Please checkout that number/type/accomodation of pax in the roster are specified accordingly to the Vision booking!<br />Close this windows, check the .csv file and try again.<br />Thank you.";
                    die();
                }
            }
        } else {
            echo "ERROR UPLOADING!";
            die();
        }
    }

    function ca_getTransfersBusCodesForDay($date, $campusPassed = "") {
        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200) {
            if ($campusPassed == "")
                $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            else
                $campus = $campusPassed;
            $data['detBusCodes'] = $this->mbackoffice->ca_getTransfersBusCodesForDay($date, $campus);
            $data["flgDetails"] = array();
            if (!empty($data['detBusCodes'])) {
                foreach ($data['detBusCodes'] as $buscode) {
                    if ($buscode['ptt_buscompany_code']) {
                        $arrayescursioni = $this->mbackoffice->getTraIdsFromBusCode($buscode['ptt_buscompany_code']);
                        $data["flgDetails"][$buscode['ptt_buscompany_code']] = $this->mbackoffice->bkgDetailsForTransfer($arrayescursioni);
                    }
                }
            }
            if (APP_THEME == "OLD")
                $this->load->view('plused_ca_detBusCodes', $data);
            else
                $this->load->view('lte/backoffice/bookings/ca_det_bus_codes', $data);
        }
        else {
            redirect('backoffice', 'refresh');
        }
    }

    function ca_getTransfersPaxFromBusCode($busCode, $tipo) {
//        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200 or $this->session->userdata('role') == 553) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data['allPaxOnBus'] = $this->mbackoffice->ca_getTransfersPaxFromBusCode($busCode);
            $data['codebus'] = $busCode;
            $data['tipo'] = $tipo;
            $this->load->view('plused_micro_detMyPaxOnBus', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function ca_getExcursionsBusCodesForDay($date, $campusPassed = "") {
        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200) {
            if ($campusPassed == "")
                $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            else
                $campus = $campusPassed;
            $data['detBusCodes'] = $this->mbackoffice->ca_getExcursionsBusCodesForDay($date, $campus);
            //print_r($data['detBusCodes']);
            if (APP_THEME == "OLD")
                $this->load->view('plused_ca_detBusExcCodes', $data);
            else
                $this->load->view('lte/backoffice/bookings/ca_det_bus_exc_codes', $data);
        }else {
            redirect('backoffice', 'refresh');
        }
    }

    function ca_getExtraExcursionsBusCodesForDay($date, $campusPassed = "") {
        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200) {
            if ($campusPassed == "")
                $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            else
                $campus = $campusPassed;
            $data['detBusCodes'] = $this->mbackoffice->ca_getExtraExcursionsBusCodesForDay($date, $campus);
            //print_r($data['detBusCodes']);
            if (APP_THEME == 'OLD')
                $this->load->view('plused_ca_detBusExtraExcCodes', $data);
            else
                $this->load->view('lte/backoffice/bookings/ca_det_bus_extra_exc_codes', $data);
        }else {
            redirect('backoffice', 'refresh');
        }
    }

//NEW FUNCTIONS PER REVIEWDAY2DAY - TERMINATI I TEST RIMUOVERE TUTTE LE FUNCTIONS SENZA SUFFISSO _pax, IDEM DAL MODEL E IDEM PER LE VIEW


    function reviewday2day_pax() {
        if ($this->session->userdata('role') == 100) {
            $arraySis = $this->mbackoffice->getAllSis();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 33;
            $accoS = $this->mbackoffice->getAccomodationsByCampusId($campus);
            $accom = isset($_POST['accomodation_in']) ? $_POST['accomodation_in'] : 1;
            $accomodation = $this->mbackoffice->getLowerSisById($accom);
            /*
              switch ($accom) {
              case 1:
              $accomodation = 'standard';
              break;
              case 2:
              $accomodation = 'ensuite';
              break;
              case 3:
              $accomodation = 'homestay';
              break;
              }
             */
            $month = isset($_POST['month_in']) ? $_POST['month_in'] : date("n");
            $year = isset($_POST['year_in']) ? $_POST['year_in'] : date("Y");
            $data['bkgmese'] = $this->mbackoffice->getBkCalendar_pax($campus, $accomodation, $month, $year);
            $data['title'] = 'plus-ed.com | Review campus day 2 day';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Review campus day 2 day';
            $data['json_name'] = $campus . "_" . $accomodation . "_d2d.json";
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $data['campusname'] = $this->mbackoffice->centerNameById($campus);
            $data['campus'] = $campus;
            $data['accomodationname'] = $accomodation;
            $data['accomodation'] = $accom;
            $data['month'] = $month;
            $data['year'] = $year;
            $data['accomodations'] = $arraySis;
            $this->load->view('plused_reviewday2day_pax', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function infoday2dayArrivalPax_pax($campus, $accomodation, $date, $status = "", $tipo = "") {
        if ($this->session->userdata('role') == 100) {
            switch ($accomodation) {
                case 1:
                    $accomodation = 'standard';
                    break;
                case 2:
                    $accomodation = 'ensuite';
                    break;
                case 3:
                    $accomodation = 'homestay';
                    break;
            }
            $data['detMyPax'] = $this->mbackoffice->getD2DBkArrivalPax_pax($campus, $accomodation, $date, $status, $tipo);
            $this->load->view('plused_micro_detMyPax', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function ca_infoday2dayArrivalPax_pax($accomodation, $date, $status = "", $tipo = "", $campus = "", $supl = "") {
        if ($this->session->userdata('role') == 100 or $this->session->userdata('role') == 200 or $this->session->userdata('role') == 553) {
            if ($tipo == "all" || $tipo == 'null') {
                $tipo = "";
            }
            if ($campus == 'null') {
                $campus = "";
            }
            $data['supl'] = $supl;
            $supl == 'all_list' ? $suplDat = 'all' : $suplDat = '';
            $data['detMyPax'] = $this->mbackoffice->ca_getD2DBkArrivalPax_pax($accomodation, $date, $status, $tipo, $campus, $suplDat);
            if (APP_THEME == "OLD")
                $this->load->view('plused_micro_detMyPax', $data);
            else {
                $this->load->view('lte/backoffice/bookings/micro_det_my_pax', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function csvArrivalPax_pax($campus, $accomodation, $date, $status = "", $tipo = "", $forChild = "", $forBook = "") {
        $date = substr($date, 0, 4) . '-' . substr($date, 4, 2) . '-' . substr($date, 6, 2);
        $tipo == 'null' ? $tipo = "" : '';
        $status == 'null' ? $status = "" : '';
        $forChild == 'null' ? $forChild = "" : '';
        if ($this->session->userdata('role') == 100 or ( $this->session->userdata('role') == 200 AND $campus == $this->mbackoffice->centerIdByName($this->session->userdata('businessname'))) or ( $this->session->userdata('role') == 553 AND $campus == $this->mbackoffice->centerIdByName($this->session->userdata('businessname')))) {
            switch ($accomodation) {
                case 1:
                    $accomodation = 'standard';
                    break;
                case 2:
                    $accomodation = 'ensuite';
                    break;
                case 3:
                    $accomodation = 'homestay';
                    break;
                case 4:
                    $accomodation = 'twin';
                    break;
            }
            if ($this->session->userdata('role') == 100) {
                $data['detMyPax'] = $this->mbackoffice->ca_getD2DBkArrivalPax_pax($accomodation, $date, $status, $tipo, $campus, $forChild);
            } else {
                $data['detMyPax'] = $this->mbackoffice->ca_getD2DBkArrivalPax_pax($accomodation, $date, $status, $tipo, "", $forChild);
            }
            if ($forBook == 'all') {
                $data['detMyPax'] = $this->mbackoffice->getD2DBkDate($campus, $accomodation, $date, $status);
            }
            $testariga[0] = array(
                "bookid" => "Book ID",
                "centro" => "Campus",
                //"businessname" => "Agency",
                "status" => "Status",
                "tipo_pax" => "Type",
                "accomodation" => "Accomodation",
                "cognome" => "Surname",
                "nome" => "Name",
                "sesso" => "Sex",
                "pax_dob" => "Date of Birth",
                "salute" => "Allergies/Cautions",
                "numero_documento" => "Document Number",
                "gl_rif" => "GL Reference",
                "share_room" => "Share Room With",
                "andata_data_arrivo" => "Date/Time of Arrival",
                "andata_volo" => "Arrival Flight",
                "andata_apt_arrivo" => "Arrival Destination Airport",
                "andata_apt_partenza" => "Arrival Origin Airport",
                "ritorno_data_partenza" => "Date/Time of Departure",
                "ritorno_volo" => "Departure Flight",
                "ritorno_apt_partenza" => "Departure Origin Airport",
                "ritorno_apt_arrivo" => "Departure Arrival Airport",
                "data_arrivo_campus" => "Campus Arrival Date",
                "data_partenza_campus" => "Campus Departure Date"
            );
            if ($forChild == 'all') {
                $testariga[0]['description'] = "Supplement Bought by the pax";
            }
            if ($forBook == 'all') {
                $testariga[0] = array();
                $testariga[0] = array(
                    "bookid" => "Booking ID",
                    "arrival_date" => "Date In",
                    "departure_date" => "Date Out",
                    "centro" => "Campus",
                    "pax_totali" => "Pax"
                );
            }
            array_unshift($data['detMyPax'], $testariga[0]);
            $fileCSVName = array_to_csv($data['detMyPax'], 'pax_list.csv');

            $xlsArray = array();
            foreach ($data['detMyPax'] as $det) {
                $xlsArray[] = $det;
            }

            $c = 0;
            foreach ($xlsArray as $val) {
                foreach ($val as $k => $v) {
                    $xlsArray[$c][$k] = trim($v, "=");
                }
                $c += 1;
            }


//			echo '<pre>';
//			print_r($xlsArray);die;

            $this->load->library('excel_180');
            $this->excel_180->getActiveSheet()->fromArray($xlsArray, NULL, 'A1');
            $this->excel_180->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
            /* $inputFileType = 'CSV';
              $inputFileName = $fileCSVName;
              $objReader = PHPExcel_IOFactory::createReader($inputFileType);
              $objReader -> setDelimiter(";");
              $objReader -> setInputEncoding('UTF-8');

              $objPHPExcel = $objReader -> load($inputFileName); */
            $filename = 'export_' . $campus . '_' . $accomodation . '_' . $date . '_' . $tipo . '.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
            $objWriter->save('php://output');

            die();
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function setUnplannedAllExcursions() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->mbackoffice->getAllCampusForDropdown();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 4;
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'extra';
            $to = isset($_POST['to']) ? $_POST['to'] : date("d/m/Y");
            $from = isset($_POST['from']) ? $_POST['from'] : date("d/m/Y");
            $data["campus"] = $campus;
            $data["tipo"] = $tipo;
            $data["to"] = $to;
            $data["from"] = $from;
            $data["all_excursions"] = $this->mbackoffice->setUnplannedAllExcursions($campus, $tipo, $to, $from);
            $data['title'] = 'plus-ed.com | Book excursions';
            $data['breadcrumb1'] = 'Extra excursions';
            $data['breadcrumb2'] = 'Book excursions';

            if (APP_THEME == "OLD")
                $this->load->view('plused_set_unplanned_all_excursions', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/set_unplanned_all_excursions', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function setAllExcursionTransport() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $arr_key = array();
            $tot_pax = 0;
            foreach ($_POST as $key => $value) {
                if (strpos($key, "excur_") !== false) {
                    $t_key = explode("_", $key);
                    $arr_key[] = $t_key[1];
                    $v_key = explode("_", $value);
                    $t_exc_id = $v_key[2];
                    $tot_pax += $v_key[3];
                }
            }
            $campus = isset($_POST['id_centro']) ? $_POST['id_centro'] : '';
            $data["campusID"] = $campus;
            $data["campus"] = $this->mbackoffice->centerNameById($campus);
            $data["pickupPlace"] = $this->mbackoffice->centerPickupById($campus);
            $data["tot_pax"] = $tot_pax;
            $data["escursione"] = $this->mbackoffice->excursionById($t_exc_id);
            $data["bookings"] = $this->mbackoffice->bkgDetailsForAllExcursion($arr_key);
            $data["bus"] = $this->mbackoffice->busListForExcursion($t_exc_id);
            $data['title'] = 'plus-ed.com | Set excursion bus';
            $data['breadcrumb1'] = 'Transportation';
            $data['breadcrumb2'] = 'Set excursion bus';

            if (APP_THEME == "OLD")
                $this->load->view('plused_set_all_excursion_transport', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/set_all_excursion_transport', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function plusedConfirmBusesAllExcursions() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $exc_numb = isset($_POST['exc_numb']) ? $_POST['exc_numb'] : '';
            if ($exc_numb == '') {
                echo "ERROR! No Bookings involved!";
                die();
            } else {
                $s_exc_date = isset($_POST['s_exc_date']) ? $_POST['s_exc_date'] : '';
                if ($s_exc_date == '') {
                    echo "ERROR! No Excursion Date!";
                    die();
                } else {
                    $exc_date_arr = explode("/", $s_exc_date);
                    $exc_date = $exc_date_arr[2] . "-" . $exc_date_arr[1] . "-" . $exc_date_arr[0];
                    $busCode = $this->mbackoffice->busCode();
                    foreach ($exc_numb as $knum => $vnum) {
                        $this->mbackoffice->standbyCodeAllExcursions($busCode, $vnum, $exc_date);
                    }
                }
            }
            foreach ($_POST as $key => $value) {
                $pos = strpos($key, "bus_");
                if ($pos !== false) {
                    if ($value > 0) {
                        $arrnumbus = explode("_", $key);
                        $numIdBus = $arrnumbus[1];
                        $addBusTab = $this->mbackoffice->addBusTab($numIdBus, $value, $exc_date, $busCode);
                        //echo "||$addBusTab|| <br>--->$key --> id bus = $numIdBus | qty bus = $value | id exc = ".$_POST['id_exc_join']." | costo singolo bus = ".$_POST[$strCostoBus]." | data escursione = ".$exc_date." | hpickup = ".$_POST['pickup_time']." | hreturn = ".$_POST['return_hour']." | place pickup = ".$_POST['pickup_place']." | currency = ".$_POST[$strCurrencyBus];
                    }
                }
            }
            //REDIRECT AL DETTAGLIO PASSANDO IN GET $busCode
            redirect('backoffice/busAllExcDetail/code_' . $busCode, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function getAllExcursionsPaxFromExcID($id_exc) {
        if ($this->session->userdata('role') == 100) {
            $data["all_all"] = $this->magenti->getAllExcursionsPaxFromExcID($id_exc);
            $this->load->view('plused_detAllExc', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function busDetailForExcursion($buscode) {
        $data["coaches"] = $this->mbackoffice->busDetailForExcursion($buscode);

        if (APP_THEME == "OLD")
            $this->load->view('plused_detCoaches', $data);
        else { // if(APP_THEME == "LTE")
            $this->load->view('lte/backoffice/super_user/det_coaches', $data);
        }
    }

    function cmsManageCoaches() {
        if ($this->session->userdata('role') == 300) {
            $data["companies"] = $this->mbackoffice->getAllCompanies();
            $data['title'] = 'plus-ed.com | Manage coach companies';
            $data['breadcrumb1'] = 'Coach companies and bus';
            $data['breadcrumb2'] = 'Manage coach companies';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsManageCoaches', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cmsuser/cms_manage_coaches', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsEditCoach($idC) {
        if ($this->session->userdata('role') == 300) {
            $data["company"] = $this->mbackoffice->companyById($idC);
            $data['title'] = 'plus-ed.com | Edit coach company';
            $data['breadcrumb1'] = 'Coach companies and bus';
            $data['breadcrumb2'] = 'Edit coach company';
            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsEditCoach', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cmsuser/cms_edit_coach', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsUpdateCoach($idC) {
        if ($this->session->userdata('role') == 300) {
            $cmsUpdateCoach = $this->mbackoffice->cmsUpdateCoach($idC);
            redirect('backoffice/cmsManageCoaches', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsAddCoach() {
        if ($this->session->userdata('role') == 300) {
            $data['title'] = 'plus-ed.com | Add coach company';
            $data['breadcrumb1'] = 'Coach companies and bus';
            $data['breadcrumb2'] = 'Add coach company';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsAddCoach', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cmsuser/cms_add_coach', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsInsertCoach() {
        if ($this->session->userdata('role') == 300) {
            $cmsInsertCoach = $this->mbackoffice->cmsInsertCoach();
            redirect('backoffice/cmsManageCoaches', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsManageBusCoaches($idC) {
        if ($this->session->userdata('role') == 300) {
            $data["company"] = $this->mbackoffice->companyById($idC);
            $data["bus"] = $this->mbackoffice->busByCompanyId($idC);
            $data["idC"] = $idC;
            $data['title'] = 'plus-ed.com | Manage coach company bus';
            $data['breadcrumb1'] = 'Coach companies and bus';
            $data['breadcrumb2'] = 'Manage coach company bus';
            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsManageBusCoaches', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cmsuser/cms_manage_bus_coaches', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsAddBusForCoach($idC) {
        if ($this->session->userdata('role') == 300) {
            $data["company"] = $this->mbackoffice->companyById($idC);
            $data["idC"] = $idC;
            $data['title'] = 'plus-ed.com | Add bus for coach company';
            $data['breadcrumb1'] = 'Coach companies and bus';
            $data['breadcrumb2'] = 'Add bus for coach company';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsAddBusForCoach', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cmsuser/cms_add_bus_for_coach', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsInsertBusForCoach($idC) {
        if ($this->session->userdata('role') == 300) {
            $cmsInsertBusForCoach = $this->mbackoffice->cmsInsertBusForCoach($idC);
            redirect('backoffice/cmsManageBusCoaches/' . $idC, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsEditBusForCoach($idC, $idB) {
        if ($this->session->userdata('role') == 300) {
            $data["company"] = $this->mbackoffice->companyById($idC);
            $data["bus"] = $this->mbackoffice->busById($idB);
            $data["idC"] = $idC;
            $data["idB"] = $idB;
            $data['title'] = 'plus-ed.com | Edit bus for coach company';
            $data['breadcrumb1'] = 'Coach companies and bus';
            $data['breadcrumb2'] = 'Edit bus for coach company';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsEditBusForCoach', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cmsuser/cms_edit_bus_for_coach', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsUpdateBusForCoach($idC, $idB) {
        if ($this->session->userdata('role') == 300) {
            $cmsUpdateBusForCoach = $this->mbackoffice->cmsUpdateBusForCoach($idB);
            redirect('backoffice/cmsManageBusCoaches/' . $idC, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsDeleteBus($idBus, $idCompany) {
        if ($this->session->userdata('role') == 300) {
            $cmsDelBusExc = $this->mbackoffice->cmsDeleteBus($idBus);
            redirect('backoffice/cmsManageBusCoaches/' . $idCompany, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsManageCampus() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["campus"] = $this->mbackoffice->getAllCampus();
            $data['title'] = 'plus-ed.com | Manage campus';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Manage campus';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsManageCampus', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/manage_campus', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function campus_change_status(){
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $id = $this->input->post('id');
            $actStatus = $this->input->post('status');
            if ($actStatus) {
                $actStatus = 0;
            } else {
                $actStatus = 1;
            }
            $result = $this->mbackoffice->updateCampusStatus($id, $actStatus);
            if ($result) {
                echo json_encode(array("result" => 1, "status" => $actStatus));
            }
            else
                echo json_encode(array("result" => 0, "status" => $actStatus));
        }
    }

//Verificare se serve ancora
    function cmsManageExcTraCampus($campusId, $tipo) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $tipook = array("planned", "extra");
            if ($tipo == "transfer")
                $tipook = array("transfer");
            $data["exctra"] = $this->mbackoffice->getAllExcTraCampus($campusId, $tipook);
            $data['title'] = 'plus-ed.com | Manage campus ' . $tipo;
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Manage campus ' . $tipo;
            //print_r($data["exctra"]);
            if (APP_THEME == "OLD") {
                if ($tipo == "transfer")
                    $this->load->view('plused_cmsManageTransfersCampus', $data);
                else
                    $this->load->view('plused_cmsManageExcursionsCampus', $data);
            }
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";

                if ($tipo == "transfer")
                    $this->ltelayout->view('lte/backoffice/cms_user/manage_transfer_campus', $data);
                else
                    $this->ltelayout->view('lte/backoffice/cms_user/manage_excursions_campus', $data);
            }
        }else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsEditCampus($idC) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["campus"] = $this->mbackoffice->campusById($idC);
            $data["campusSis"] = $this->mbackoffice->sisByCenterId($idC);
            $data["allSis"] = $this->mbackoffice->getAllSis();
            $data['title'] = 'plus-ed.com | Edit campus';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Edit campus';
            $data['psg'] = $this->mbackoffice->getAllServizi();
            $data['pso'] = $this->mbackoffice->getAllServizi("opzionali");
            $data['campus_psg'] = $this->mbackoffice->getAllCampusServizi($idC);
            //print_r($data['campus_psg']);
            $data['campus_pso'] = $this->mbackoffice->getAllCampusServizi($idC, "opzionali");

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsEditCampus', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/cms_campus_edit', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsAddCampus($idC = 0) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["allSis"] = $this->mbackoffice->getAllSis();
            $data['title'] = 'plus-ed.com | Add campus';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Add campus';
            $data['psg'] = $this->mbackoffice->getAllServizi();
            $data['pso'] = $this->mbackoffice->getAllServizi("opzionali");

            $formData = array(
                'nome_centri' => '',
                'school_name' => '',
                'city' => '',
                'address' => '',
                'post_code' => '',
                'located_in' => '',
                'page_1' => '',
                'page_3' => '',
                'plus_contact' => '',
                'plus_contact_number' => '',
                'cm_mail' => ''
            );
            $data['formData'] = $formData;

            if(!empty($_POST)){
                $cmsUpdateCampus = $this->mbackoffice->cmsAddCampus();
                $this->session->set_flashdata('success_message','Record added successfully.');
                redirect('backoffice/cmsManageCampus', 'refresh');
                exit();
            }

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsEditCampus', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/cms_campus_add', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsUpdateCampus($idC) {
        if ($this->session->userdata('role')) {
            $cmsUpdateCampus = $this->mbackoffice->cmsUpdateCampus($idC);
            $this->session->set_flashdata('success_message','Record updated successfully.');
            redirect('backoffice/cmsManageCampus', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsManageDatesCampus($campusId) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["dates"] = $this->gestione_centri_model->findDatesByCenter($campusId);
            $data["campus"] = $this->mbackoffice->campusById($campusId);
            //print_r($data["dates"]);
            //print_r($data["campus"]);
            $data['title'] = 'plus-ed.com | Manage campus arrival dates';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Manage campus arrival dates';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsManageDatesCampus', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/manage_dates_campus', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsManageCampusAvailability($campusId) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["dates"] = $this->mbackoffice->cms_getAvaByCampusId($campusId);
            $data["campus"] = $this->mbackoffice->campusById($campusId);
            $data["campusSis"] = $this->mbackoffice->sisByCenterId($campusId);
            //print_r($data["dates"]);
            //print_r($data["campus"]);
            $data['title'] = 'plus-ed.com | Manage campus availability';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Manage campus availability';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsManageCampusAvailability', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/manage_campus_availability', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsDelDateCampus($idData, $idCampus) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $cmsDelDateCampus = $this->mbackoffice->cmsDelDateCampus($idData);
            redirect('backoffice/cmsManageDatesCampus/' . $idCampus, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsDelCampusAvailability($idData, $idCampus) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $cmsDelCampusAvailability = $this->mbackoffice->cmsDelCampusAvailability($idData);
            redirect('backoffice/cmsManageCampusAvailability/' . $idCampus, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsAddDateCampus($data, $idCampus) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $cmsAddDateCampus = $this->mbackoffice->cmsAddDateCampus($data, $idCampus);
            redirect('backoffice/cmsManageDatesCampus/' . $idCampus, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsAddCampusAvailability($idCampus) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $cmsAddDateCampus = $this->mbackoffice->cmsAddCampusAvailability($idCampus);
            redirect('backoffice/cmsManageCampusAvailability/' . $idCampus, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsManageAttractions() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["campus"] = $this->mbackoffice->getAllAttractions();
            $data['title'] = 'plus-ed.com | Manage attractions';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Manage attractions';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsManageAttractions', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/manage_attractions', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsEditAttraction($idA) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["attraction"] = $this->mbackoffice->attractionById($idA);
            $data["types"] = $this->mbackoffice->getAllAttractionTypes();
            $data["curs"] = $this->mbackoffice->getAllCurrencies();
            $data["regs"] = $this->mbackoffice->getAllRegions();
            $data["cous"] = $this->mbackoffice->getAllCountries();
            $data["cits"] = $this->mbackoffice->getAllCities();
            $data['title'] = 'plus-ed.com | Edit attraction';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Edit attraction';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsEditAttraction', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/edit_attractions', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsUpdateAttraction($idA) {
        if ($this->session->userdata('role')) {
            $cmsUpdateAttraction = $this->mbackoffice->cmsUpdateAttraction($idA);
            redirect('backoffice/cmsManageAttractions', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsAddAttraction() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["types"] = $this->mbackoffice->getAllAttractionTypes();
            $data["curs"] = $this->mbackoffice->getAllCurrencies();
            $data["regs"] = $this->mbackoffice->getAllRegions();
            $data["cous"] = $this->mbackoffice->getAllCountries();
            $data["cits"] = $this->mbackoffice->getAllCities();
            $data['title'] = 'plus-ed.com | Add attraction';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Add attraction';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsAddAttraction', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/add_attractions', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsInsertAttraction() {
        if ($this->session->userdata('role')) {
            $cmsInsertAttraction = $this->mbackoffice->cmsInsertAttraction();
            redirect('backoffice/cmsManageAttractions', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsManageExcursions($type, $idCampus = "") {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["excursions"] = $this->mbackoffice->getAllExcursions($type, $idCampus);
            $data['title'] = 'plus-ed.com | Manage excursions';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = "Manage $type excursions";
            $data['tipoE'] = $type;

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsManageExcursions', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/manage_excursions', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsEditExcursion($idE) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["campus"] = $this->mbackoffice->getAllCampus();
            $data["excursion"] = $this->mbackoffice->excursionById($idE);
            $data['title'] = 'plus-ed.com | Edit excursion';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Edit excursion';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsEditExcursion', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/edit_excursions', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsUpdateExcursion($idE) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $cmsUpdateExcursion = $this->mbackoffice->cmsUpdateExcursion($idE);
            redirect('backoffice/cmsManageExcursions/' . $cmsUpdateExcursion, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsAddExcursion() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["campus"] = $this->mbackoffice->getAllCampus();
            $data['title'] = 'plus-ed.com | Add excursion';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Add excursion';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsAddExcursion', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/add_excursions', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsInsertExcursion() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $cmsInsertExcursion = $this->mbackoffice->cmsInsertExcursion();
            redirect('backoffice/cmsManageExcursions/' . $cmsInsertExcursion, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsRemoveExcursion($idE, $tipo) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $cmsRemoveExcursion = $this->mbackoffice->cmsRemoveExcursion($idE);
            redirect('backoffice/cmsManageExcursions/' . $tipo, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsJoinAttrExc($idE) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["excursion"] = $this->mbackoffice->excursionById($idE);
            $data["attrs"] = $this->mbackoffice->attrByExcId($idE);
            $data["attractions"] = $this->mbackoffice->getAllAttractions();
            $data['title'] = 'plus-ed.com | Update excursion to attraction';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Update excursion to attraction';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsJoinAttrExc', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/join_attr_exc', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsDelAttrExc($idRiga, $idExcursion) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $cmsDelAttrExc = $this->mbackoffice->cmsDelAttrExc($idRiga);
            redirect('backoffice/cmsJoinAttrExc/' . $idExcursion, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsAddAttractionToExc($idExc) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $idAttr = $_POST["add_attra"];
            $cmsAddAttractionToExc = $this->mbackoffice->cmsAddAttractionToExc($idAttr, $idExc);
            redirect('backoffice/cmsJoinAttrExc/' . $idExc, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsJoinBusExc($idE) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["excursion"] = $this->mbackoffice->excursionById($idE);
            $data["allBus"] = $this->mbackoffice->busListForExcursion($idE);
            $data["totalBus"] = $this->mbackoffice->totalBusList();
            $data["curs"] = $this->mbackoffice->getAllCurrencies();
            $data['title'] = 'plus-ed.com | Manage bus for excursion';
            $data['breadcrumb1'] = 'Campus and excursions';
            $data['breadcrumb2'] = 'Manage bus for excursion';

            if (APP_THEME == "OLD")
                $this->load->view('plused_cmsJoinBusExc', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/cms_user/join_bus_exc', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsDelBusExc($idRiga, $idExcursion) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $cmsDelBusExc = $this->mbackoffice->cmsDelBusExc($idRiga);
            redirect('backoffice/cmsJoinBusExc/' . $idExcursion, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsUpdateBusExcPrice($idRiga, $idExc, $intero, $decimale) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $cmsUpdateBusExcPrice = $this->mbackoffice->cmsUpdateBusExcPrice($idRiga, $intero, $decimale);
            redirect('backoffice/cmsJoinBusExc/' . $idExc, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function cmsAddBusToExc($idExc, $idCampus) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $idBus = $_POST["add_buse"];
            $prezzoAdd = str_replace(",", ".", $_POST["prezzoAdd"]);
            $idCur = $_POST["add_curr"];
            $cmsAddBusToExc = $this->mbackoffice->cmsAddBusToExc($idExc, $idCampus, $idBus, $prezzoAdd, $idCur);
            redirect('backoffice/cmsJoinBusExc/' . $idExc, 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function reviewBookedAttractions() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 4;
            $data["campus"] = $campus;
            $data["all_excursions"] = $this->mbackoffice->getAllBookedAttractions($campus, "STANDBY");
            $data['title'] = 'plus-ed.com | Confirm booked attractions';
            $data['breadcrumb1'] = 'Attractions';
            $data['breadcrumb2'] = 'Confirm booked attractions';

            if (APP_THEME == "OLD")
                $this->load->view('plused_confirm_booked_attractions', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $this->ltelayout->view('lte/backoffice/super_user/confirm_booked_attractions', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function confirmBookAttraction($idAtb, $inte, $deci) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $costTotal = $inte . "." . $deci;
            if (is_numeric($costTotal)) {
                $confirmBookAttraction = $this->mbackoffice->confirmBookAttraction($idAtb, $inte, $deci);
                echo "UPDATED";
                die();
            } else {
                echo "INVALID COST FORMAT!";
                die();
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function reviewConfirmedAttractions() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->mbackoffice->getAllCampus();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 4;
            $data["campus"] = $campus;
            $data["all_excursions"] = $this->mbackoffice->getAllBookedAttractions($campus, "YES");
            $data['title'] = 'plus-ed.com | Review confirmed attractions';
            $data['breadcrumb1'] = 'Attractions';
            $data['breadcrumb2'] = 'View confirmed attractions';

            if (APP_THEME == "OLD")
                $this->load->view('plused_review_confirmed_attractions', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/super_user/review_confirmed_attractions', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

//AMENDMENT Booking

    function amendmentBooking($anno, $id) {
        if ($this->session->userdata('username') && $this->session->userdata('role') == 100) {
            $data['title'] = 'plus-ed.com | Edit pax list';
            $data['breadcrumb1'] = 'Bookings review';
            $data['booking_detail'] = $this->mbackoffice->get_booking_detail($id);
            $data['breadcrumb2'] = 'Pax list for Booking ' . $data['booking_detail'][0]["id_year"] . "_" . $data['booking_detail'][0]["id_book"];
            $statoO = $data['booking_detail'][0]['status'];
            if ($statoO == "confirmed") {
                $data['booking_acc'] = $this->mbackoffice->getBookAccomodations($id);
                $idagenzia = $data['booking_detail'][0]['id_agente'];
                $data['agency'] = $this->mbackoffice->agent_detail($idagenzia);
                $data['paxs'] = $this->magenti->getRowsByBookId($id);
                //print_r($data['paxs']);
                $this->load->view('plused_amendment_booking', $data);
            } else {
                redirect('backoffice/dashboard', 'refresh');
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

// NUOVA AVAILABILITY BACKOFFICE


    function availabilityNew() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $arraySis = $this->mbackoffice->getAllSis();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 33;
            $accoS = $this->mbackoffice->getAccomodationsByCampusId($campus);
            $accom = isset($_POST['accomodation_in']) ? $_POST['accomodation_in'] : 1;
            $accomodation = $this->mbackoffice->getLowerSisById($accom);
            $data['title'] = 'plus-ed.com | Campus availability';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Campus availability';
            $data["centri"] = $this->mbackoffice->getAllCampus(1);
            $data['campus'] = $campus;
            $data['accomodation'] = $accom;
            $data['campusAcco'] = $accoS;
            $data['accomodations'] = $arraySis;

            if (APP_THEME == "OLD")
                $this->load->view('plused_availabilityNew', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/bookings/availability_new', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function availabilityDetailNew() {
        set_time_limit(300);
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $campusArray = $_REQUEST["centri"];
            $data["statusArray"] = $_REQUEST["status"];
            $datein = $_REQUEST["dateStart"];
            $dateinArr = explode("/", $_REQUEST["dateStart"]);
            $dateinA = $dateinArr[1] . "/" . $dateinArr[0] . "/" . $dateinArr[2];
            $datech = date('Y-m-d', strtotime($dateinA));
            $datein = date('Y-m-d', strtotime($dateinA . "-15 days"));
            $dateout = date('Y-m-d', strtotime($dateinA . "+15 days"));
            if (count($campusArray) == 1) {
                $campus = $campusArray[0];
                foreach ($_REQUEST["accomodation"] as $accomodat) {
                    $data['simcalendar'][] = $this->mbackoffice->getSimCalendar($campus, $accomodat, $datein, $dateout);
                    $data['simbooking'][] = $this->mbackoffice->NA_getSimBooking_backoffice($campus, $accomodat, $datein, $dateout, $_REQUEST["status"]);
                }
                $data['dates'] = $this->gestione_centri_model->findDatesByCenter($campus);
                $data['campusname'] = $this->mbackoffice->centerNameById($campus);
                $data['campus'] = $campus;
            } else {
                $data["campusArray"] = $campusArray;
                foreach ($_REQUEST["centri"] as $campus) {
                    $data["campusName"][] = $this->mbackoffice->centerNameById($campus);
                    $data['dates'][] = $this->gestione_centri_model->findDatesByCenter($campus);
                    $data['simcalendar'][] = $this->mbackoffice->getSimCalendarAllAccos($campus, $datein, $dateout, $_REQUEST["status"]);
                }
            }

            $data['title'] = 'plus-ed.com | Simulator day 2 day';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Simulator day 2 day';
            $data['datechoose'] = $datech;
            $data['datein'] = $datein;
            $data['dateout'] = $dateout;
            if (APP_THEME == 'OLD') {
                if (count($campusArray) == 1)
                    $this->load->view('plused_availabilityDetailNew', $data);
                else
                    $this->load->view('plused_availabilityTotalDetailNew', $data);
            }
            else {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                if (count($campusArray) == 1)
                    $this->load->view('lte/backoffice/bookings/availability_detail_new', $data);
                else
                    $this->load->view('lte/backoffice/bookings/availability_total_detail_new', $data);
            }
        }else {
            redirect('backoffice', 'refresh');
        }
    }

//New availability detail with overnights
    function availabilityDetailNew2() {
        set_time_limit(300);
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $campusArray = $_REQUEST["centri"];
            $data["statusArray"] = $_REQUEST["status"];
            $datein = $_REQUEST["dateStart"];
            $dateinArr = explode("/", $_REQUEST["dateStart"]);
            $dateinA = $dateinArr[1] . "/" . $dateinArr[0] . "/" . $dateinArr[2];
            $datech = date('Y-m-d', strtotime($dateinA));
            $datein = date('Y-m-d', strtotime($dateinA . "-15 days"));
            $dateout = date('Y-m-d', strtotime($dateinA . "+15 days"));
            if (count($campusArray) == 1) {
                $campus = $campusArray[0];
                foreach ($_REQUEST["accomodation"] as $accomodat) {
                    $data['simcalendar'][] = $this->mbackoffice->getSimCalendar($campus, $accomodat, $datein, $dateout);
                    $data['simbooking'][] = $this->mbackoffice->NA_getSimBooking_backoffice($campus, $accomodat, $datein, $dateout, $_REQUEST["status"]);
                    $data['simbookingOvernights'][] = $this->mbackoffice->NA_getSimBooking_overnight_backoffice($campus, $accomodat, $datein, $dateout, $_REQUEST["status"]);
                }
                $data['dates'] = $this->gestione_centri_model->findDatesByCenter($campus);
                $data['campusname'] = $this->mbackoffice->centerNameById($campus);
                $data['campus'] = $campus;
            } else {
                $data["campusArray"] = $campusArray;
                foreach ($_REQUEST["centri"] as $campus) {
                    $data["campusName"][] = $this->mbackoffice->centerNameById($campus);
                    $data['dates'][] = $this->gestione_centri_model->findDatesByCenter($campus);
                    $data['simcalendar'][] = $this->mbackoffice->getSimCalendarAllAccos($campus, $datein, $dateout, $_REQUEST["status"]);
                }
            }

            $data['title'] = 'plus-ed.com | Simulator day 2 day';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Simulator day 2 day';
            $data['datechoose'] = $datech;
            $data['datein'] = $datein;
            $data['dateout'] = $dateout;
            if (APP_THEME == 'OLD') {
                if (count($campusArray) == 1)
                    $this->load->view('plused_availabilityDetailNew2', $data);
                else
                    $this->load->view('plused_availabilityTotalDetailNew', $data);
            }
            else {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                if (count($campusArray) == 1)
                    $this->load->view('lte/backoffice/bookings/availability_detail_new2', $data);
                else
                    $this->load->view('lte/backoffice/bookings/availability_total_detail_new', $data);
            }
        }else {
            redirect('backoffice', 'refresh');
        }
    }

    function exportAvailabilityDetailNewCopy() {
        if ($this->session->userdata('role') == 100) {
            $centri = $this->mbackoffice->getAllCampus(1);
            foreach ($centri as $cmp)
                $campusArray[] = $cmp["id"];
            //$myFile = "/var/www/html/www.plus-ed.com/vision_ag/downloads/export_csv/allCSVAvailability.csv";
            $myFile = AVAILABILITY_DWNLD;
            $fh = fopen($myFile, 'w+') or die("can't open file");
            //$campusArray = array("3");
            $statusArray = array("confirmed", "active");
            $datein = "2016-06-01";
            $dateout = "2016-09-01";
            //$campus = $campusArray[0];


            foreach ($campusArray as $campus) {
                $simcalendar = array();
                $simbooking = array();
                $accomoArray = array();
                $accos = $this->gestione_centri_model->findAccoByCenter($campus);
                foreach ($accos as $key => $value) {
                    $accomoArray[] = $accos[$key]["sistemazione"];
                }
                //print_r($accomoArray);
                foreach ($accomoArray as $accomodat) {
                    //echo "$accomodat";
                    $simcalendar[] = $this->mbackoffice->getSimCalendar($campus, $accomodat, $datein, $dateout);
                    $simbooking[] = $this->mbackoffice->NA_getSimBooking_backoffice($campus, $accomodat, $datein, $dateout, $statusArray);
                }
                /*
                  echo "<pre>";
                  print_r($simbooking);
                  echo "</pre>"; */
                $dates = $this->gestione_centri_model->findDatesByCenter($campus);
                $campusname = $this->mbackoffice->centerNameById($campus);
                $campus = $campus;
                //inizio ciclo
                $dateArr = array();
                foreach ($dates as $dataArr) {
                    $dateArr[] = strtotime($dataArr["start_date"]);
                }
                for ($a = 0; $a < count($simbooking); $a++) {
                    $contaBooked = array();
                    $contarighe = 1;
                    $testata = "Campus;Booking;Status;Accomodation;";
                    $datecycle = $datein;
                    while (strtotime($datecycle) <= strtotime($dateout)) {
                        $testata.=date("d/m", strtotime($datecycle)) . ";";
                        $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                        $contaBooked[] = 0;
                    }
                    $testata.=PHP_EOL;
                    fwrite($fh, $testata);
                    foreach ($simbooking[$a] as $book) {
                        $rigaBk = $campusname . ";";
                        $da = explode("-", $book["arrival_date"]);
                        $dd = explode("-", $book["departure_date"]);
                        $rigaBk.=$book["id_year"] . "_" . $book["id_book"] . ";" . $book["status"] . ";" . ucfirst($accomoArray[$a]) . ";";
                        $datecycle = date("Y-m-d", strtotime("+0 day", strtotime($datein)));
                        $contadays = 0;
                        while (strtotime($datecycle) <= strtotime($dateout)) {
                            $datecycle = $datecycle . " 00:00:00";
                            $numAttuale = $contaBooked[$contadays];
                            if ($datecycle >= $book["arrival_date"] and $datecycle < $book["departure_date"]) {
                                $rigaBk.=$book["num_in"] . ";";
                                $contaBooked[$contadays] = $numAttuale * 1 + $book["num_in"] * 1;
                            } else {
                                $rigaBk.="0;";
                                $contaBooked[$contadays] = $numAttuale * 1;
                            }
                            $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                            $contadays++;
                        }
                        $contarighe++;
                        $rigaBk.=PHP_EOL;
                        fwrite($fh, $rigaBk);
                        //echo "<pre>";
                        //print_r($contaBooked);
                        //echo "</pre>";
                    }
                    //die();
                    $rigaAva = "Allotment;;;;";
                    foreach ($simcalendar[$a] as $cAva) {
                        $rigaAva.=$cAva["totale"] . ";";
                    }
                    $rigaAva.=PHP_EOL;
                    fwrite($fh, $rigaAva);

                    $rigaBoo = "Booked;;;;";
                    foreach ($contaBooked as $cBoo) {
                        $rigaBoo.=$cBoo . ";";
                    }
                    $rigaBoo.=PHP_EOL;
                    fwrite($fh, $rigaBoo);

                    $rigaTot = "Availability;;;;";
                    $gira = 0;
                    foreach ($simcalendar[$a] as $cAva) {
                        //echo $gira."---".$contaBooked[$gira]*1 ."<br />";
                        $rigaTot.= ($cAva["totale"] * 1 - $contaBooked[$gira] * 1) . ";";
                        $gira++;
                    }
                    $rigaTot.=PHP_EOL;
                    fwrite($fh, $rigaTot);
                    //print_r($contaBooked);
                }
            }
            //die();
            /*
              echo "<pre>";
              print_r($contaBooked);
              echo "</pre>";
              die(); */
            $this->load->library('excel');
            $inputFileType = 'CSV';
            $inputFileName = $myFile;
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setDelimiter(";");
            $objReader->setInputEncoding('UTF-8');
            $objPHPExcel = $objReader->load($inputFileName);
            $filename = 'exportAvailability.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            die();
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function exportAvailabilityDetailNew() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $myFile = AVAILABILITY_DWNLD;
            $fh = fopen($myFile, 'w+') or die("can't open file");

            $centri = $this->mbackoffice->getAllCampus(1);
            foreach ($centri as $cmp)
                $campusArray[] = array('id' => $cmp["id"], 'campus_name' => $cmp["nome_centri"]);

            $statusArray = array("confirmed", "active");
            $datein = "2017-06-01";
            $dateout = "2017-09-01";

            foreach ($campusArray as $campus) {
                $simbooking = array();
                $accomoArray = array();

                $accos = $this->gestione_centri_model->findAccoByCenter($campus['id']);
                foreach ($accos as $key => $value) {
                    $accomoArray[] = $accos[$key]["sistemazione"];
                    $simbooking[] = $this->mbackoffice->NA_getSimBooking_backoffice($campus['id'], $accomoArray[$key], $datein, $dateout, $statusArray);
                }

                if (!empty($simbooking)) {
                    foreach ($simbooking as $key => $sb) {
                        $contaBooked = array();
                        $simcalendar = array();

                        $testata = "Campus;Booking;Status;Accomodation;";

                        $current = strtotime($datein);
                        $last = strtotime($dateout);
                        $date = $datein;

                        while ($current <= $last) {
                            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));

                            $testata .= date("d/m", $current) . ";";
                            $current = strtotime("+1 day", $current);
                            $contaBooked[] = 0;

                            $simcalendar[] = $this->mbackoffice->get_total_available($campus['id'], $accomoArray[$key], $date);
                        }

                        $testata .= PHP_EOL;
                        fwrite($fh, $testata);

                        foreach ($sb as $book) {
                            $rigaBk = $campus['campus_name'] . ";" . $book["id_year"] . "_" . $book["id_book"] . ";" . $book["status"] . ";" . ucfirst($accomoArray[$key]) . ";";

                            $datecycle = date("Y-m-d", strtotime("+0 day", strtotime($datein)));
                            $contadays = 0;
                            while (strtotime($datecycle) <= strtotime($dateout)) {
                                $datecycle = $datecycle . " 00:00:00";
                                $numAttuale = $contaBooked[$contadays];
                                if ($datecycle >= $book["arrival_date"] and $datecycle < $book["departure_date"]) {
                                    $rigaBk .= $book["num_in"] . ";";
                                    $contaBooked[$contadays] = $numAttuale * 1 + $book["num_in"] * 1;
                                } else {
                                    $rigaBk .= "0;";
                                    $contaBooked[$contadays] = $numAttuale * 1;
                                }
                                $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                $contadays++;
                            }
                            $rigaBk .= PHP_EOL;
                            fwrite($fh, $rigaBk);
                        }

                        $rigaAva = "Allotment;;;;";
                        foreach ($simcalendar as $cAva) {
                            $rigaAva.=$cAva["totale"] . ";";
                        }
                        $rigaAva.=PHP_EOL;
                        fwrite($fh, $rigaAva);

                        $rigaBoo = "Booked;;;;";
                        foreach ($contaBooked as $cBoo) {
                            $rigaBoo.=$cBoo . ";";
                        }
                        $rigaBoo.=PHP_EOL;
                        fwrite($fh, $rigaBoo);

                        $rigaTot = "Availability;;;;";
                        $gira = 0;
                        foreach ($simcalendar as $cAva) {
                            $rigaTot.= ($cAva["totale"] * 1 - $contaBooked[$gira] * 1) . ";";
                            $gira++;
                        }
                        $rigaTot.=PHP_EOL;
                        fwrite($fh, $rigaTot);
                    }
                }
            }
            $this->load->library('excel');
            $inputFileType = 'CSV';
            $inputFileName = $myFile;
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setDelimiter(";");
            $objReader->setInputEncoding('UTF-8');
            $objPHPExcel = $objReader->load($inputFileName);
            $filename = 'exportAvailability.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            die();
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function getAccoByCampus($idCampus) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $stringaR = "";
            $accos = $this->gestione_centri_model->findAccoByCenter($idCampus);
            foreach ($accos as $key => $value) {
                $stringaR .= $accos[$key]["sistemazione"] . ";";
            }
            echo $stringaR;
            die();
        } else {
            die("Error!");
        }
    }

    /* SALES CONTROL FUNCTIONS */

    function salesNew($date = "") {
        if ($this->session->userdata('role') == 100) {
            $arraySis = $this->mbackoffice->getAllSis();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 33;
            $accoS = $this->mbackoffice->getAccomodationsByCampusId($campus);
            $accom = isset($_POST['accomodation_in']) ? $_POST['accomodation_in'] : 1;
            $accomodation = $this->mbackoffice->getLowerSisById($accom);
            $data['title'] = 'plus-ed.com | Sales';
            $data['breadcrumb1'] = 'Sales and risks';
            $data['breadcrumb2'] = 'Sales';
            $data['campus'] = $campus;
            $data['accomodation'] = $accom;
            $data['campusAcco'] = $accoS;
            $data['accomodations'] = $arraySis;
            $data['byDate'] = $date;
            if ($date == "") {
                $data['centri'] = $this->mbackoffice->getAllCampus(1);

                if (APP_THEME == "OLD")
                    $this->load->view('plused_salesNew', $data);
                else { // if(APP_THEME == "LTE")
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/sales/salesnew', $data);
                }
            } else {
                $data['centriDate'] = $this->mbackoffice->findCenterOpeningByDate($date);
                foreach ($data['centriDate'] as $centroData) {
                    $centroAttuale = $this->mbackoffice->campusById($centroData["codice"]);
                    $centroAttuale[0]["openingDate"] = $centroData["start_date"];
                    $data["centri"][] = $centroAttuale[0];
                }

                if (APP_THEME == "OLD")
                    $this->load->view('plused_salesNewDate', $data);
                else { // if(APP_THEME == "LTE")
                    $data['pageHeader'] = "Sales by date: " . $data['byDate'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/sales/salesnew_date', $data);
                }
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function salesDetailNew() {
        if ($this->session->userdata('role') == 100) {
            $campusArray = $_REQUEST["centri"];
            $data["statusArray"] = array("confirmed", "active", "elapsed", "tbc");
            $datein = $_REQUEST["dateStart"];
            $dateout = $_REQUEST["dateEnd"];
            $dateinArr = explode("/", $_REQUEST["dateStart"]);
            $dateinA = $dateinArr[1] . "/" . $dateinArr[0] . "/" . $dateinArr[2];
            $dateoutArr = explode("/", $_REQUEST["dateEnd"]);
            $dateoutA = $dateoutArr[1] . "/" . $dateoutArr[0] . "/" . $dateoutArr[2];
            //$datein = date('Y-m-d',strtotime($dateinA. "-15 days"));
            //$dateout = date('Y-m-d',strtotime($dateinA . "+15 days"));
            $datein = date('Y-m-d', strtotime($dateinA));
            $dateout = date('Y-m-d', strtotime($dateoutA));
            $data["campusArray"] = $campusArray;
            foreach ($_REQUEST["centri"] as $campus) {
                $data["campusName"][] = $this->mbackoffice->centerNameById($campus);
                $data['simcalendar'][] = $this->mbackoffice->getSimCalendarAllAccos($campus, $datein, $dateout, $data["statusArray"]);
            }
            $simArrayCampus = array();
            foreach ($data['simcalendar'] as $simcampus) {
                $simConfirmed = 0;
                $simActive = 0;
                $simElapsed = 0;
                $simTbc = 0;
                $simCommit = 0;
                foreach ($simcampus as $simC) {
                    //print_r($simC);
                    //echo "<br /><br /><br /><br />";
                    $simConfirmed += $simC["n_confirmed"];
                    $simActive += $simC["n_active"];
                    $simElapsed += $simC["n_elapsed"];
                    $simTbc += $simC["n_tbc"];
                    $simCommit += $simC["totale"];
                }
                $simPercent = $simConfirmed + $simActive;
                $data["totCampus"][] = array($simConfirmed, $simActive, $simElapsed, $simTbc, $simCommit, $simPercent);
            }
            //print_r($data["totCampus"]);
            $data['title'] = 'plus-ed.com | Simulator day 2 day';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Simulator day 2 day';
            $data['datein'] = $datein;
            $data['dateout'] = $dateout;
            //$this->load->view('plused_salesTotalDetailNewPerc',$data);
            $this->load->view('plused_salesTotalDetailNew', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function salesDetailNewPerc() {
        if ($this->session->userdata('role') == 100) {
            $campusArray = $_REQUEST["centri"];
            $data["statusArray"] = array("confirmed", "active", "elapsed", "tbc");
            $datein = $_REQUEST["dateStart"];
            $dateout = $_REQUEST["dateEnd"];
            $dateinArr = explode("/", $_REQUEST["dateStart"]);
            $dateinA = $dateinArr[1] . "/" . $dateinArr[0] . "/" . $dateinArr[2];
            $dateoutArr = explode("/", $_REQUEST["dateEnd"]);
            $dateoutA = $dateoutArr[1] . "/" . $dateoutArr[0] . "/" . $dateoutArr[2];
            //$datein = date('Y-m-d',strtotime($dateinA. "-15 days"));
            //$dateout = date('Y-m-d',strtotime($dateinA . "+15 days"));
            $datein = date('Y-m-d', strtotime($dateinA));
            $dateout = date('Y-m-d', strtotime($dateoutA));
            $data["campusArray"] = $campusArray;
            foreach ($_REQUEST["centri"] as $campus) {
                $data["campusName"][] = $this->mbackoffice->centerNameById($campus);
                $data['simcalendar'][] = $this->mbackoffice->getSimCalendarAllAccos($campus, $datein, $dateout, $data["statusArray"]);
            }
            $simArrayCampus = array();
            foreach ($data['simcalendar'] as $simcampus) {
                $simConfirmed = 0;
                $simActive = 0;
                $simElapsed = 0;
                $simTbc = 0;
                $simAllot = 0;
                foreach ($simcampus as $simC) {
                    //print_r($simC);
                    //echo "<br /><br /><br /><br />";
                    $simConfirmed += $simC["n_confirmed"];
                    $simActive += $simC["n_active"];
                    $simElapsed += $simC["n_elapsed"];
                    $simTbc += $simC["n_tbc"];
                    $simAllot += $simC["totale"];
                }
                $simPercent = $simConfirmed + $simActive;
                $data["totCampus"][] = array($simConfirmed, $simActive, $simElapsed, $simTbc, $simAllot, $simPercent);
            }
            //print_r($data["totCampus"]);
            $data['title'] = 'plus-ed.com | Simulator day 2 day';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Simulator day 2 day';
            $data['datein'] = $datein;
            $data['dateout'] = $dateout;
            $this->load->view('plused_salesTotalDetailNewPerc', $data);
            //$this->load->view('plused_salesTotalDetailNew',$data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function salesControl() {
        if ($this->session->userdata('role') == 100) {
            $data['title'] = 'plus-ed.com | SalesControl';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'SalesControl';
            $this->load->view('plused_salesControl', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function salesControl2() {
        if ($this->session->userdata('role') == 100) {
            $data['title'] = 'plus-ed.com | SalesControl2';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'SalesControl2';
            $this->load->view('plused_salesControl2', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function tuitionNew() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $arraySis = $this->mbackoffice->getAllSis();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 33;
            $accoS = $this->mbackoffice->getAccomodationsByCampusId($campus);
            $accom = isset($_POST['accomodation_in']) ? $_POST['accomodation_in'] : 1;
            $accomodation = $this->mbackoffice->getLowerSisById($accom);
            $data['title'] = 'plus-ed.com | Review tuition';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Review tuition';
            $data["centri"] = $this->mbackoffice->getAllCampus(1);
            $data['campus'] = $campus;
            $data['accomodation'] = $accom;
            $data['campusAcco'] = $accoS;
            $data['accomodations'] = $arraySis;

            if (APP_THEME == "OLD")
                $this->load->view('plused_tuitionNew', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/bookings/tuition_new', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function tuitionDetailNew() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $reportType = $_REQUEST["rt"];
            $campusArray = $_REQUEST["centri"];
            $data["statusArray"] = $_REQUEST["status"];
            $datein = $_REQUEST["dateStart"];
            $dateinArr = explode("/", $_REQUEST["dateStart"]);
            $dateinA = $dateinArr[1] . "/" . $dateinArr[0] . "/" . $dateinArr[2];
            $datech = date('Y-m-d', strtotime($dateinA));
            $datein = date('Y-m-d', strtotime($dateinA . "-15 days"));
            $dateout = date('Y-m-d', strtotime($dateinA . "+15 days"));
            $data["campusArray"] = $campusArray;
            foreach ($_REQUEST["centri"] as $campus) {
                $data["campusName"][] = $this->mbackoffice->centerNameById($campus);
                $data['dates'][] = $this->gestione_centri_model->findDatesByCenter($campus);
                if($reportType == "Book")
                {
                    $data['simcalendar'][] = $this->mbackoffice->getSimCalendarAllAccos($campus, $datein, $dateout, $_REQUEST["status"], 0);
                    $data['simbooking'][] = $this->mbackoffice->NA_getSimBookingAllAccos_backoffice($campus, $datein, $dateout, $_REQUEST["status"], 0);
                }
                else{
                    $data['simcalendar'][] = $this->mbackoffice->getSimCalendarAllAccos_EachDayCount($campus, $datein, $dateout, $_REQUEST["status"], 0);
                    $data['simbooking'][] = $this->mbackoffice->NA_getSimBookingAllAccos_backoffice_EachDayCount($campus, $datein, $dateout, $_REQUEST["status"], 0);
                }
            }

            /*
              echo "<pre>";
              print_r($data['simcalendar']);
              echo "</pre>";
              echo "<pre>";
              print_r($data['simbooking']);
              echo "</pre>"; */
            $data['title'] = 'plus-ed.com | Simulator day 2 day';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Simulator day 2 day';
            $data['datechoose'] = $datech;
            $data['datein'] = $datein;
            $data['dateout'] = $dateout;

            if (APP_THEME == "OLD")
                $this->load->view('plused_tuitionTotalDetailNew', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                if($reportType == "Book")
                    $this->load->view('lte/backoffice/bookings/tuition_total_detail_new', $data);
                else
                    $this->load->view('lte/backoffice/bookings/tuition_total_detail_new_each_day_count', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

// funzioni importazione ws da dev

    function getWsDev() {
        if ($this->session->userdata('role') == 100) {
            $wsdl_url = 'http://devtours.studytours.it/ws/vision.asmx?wsdl';
            $client = new SoapClient($wsdl_url, array('soap_version' => SOAP_1_1));
            $params = array(
                '_UserId' => 'visioN@0315',
                '_Psw' => 'j%asbwY3'
            );
            $result = $client->getPrenotazioni($params);
            $jsonR = $result->getPrenotazioniResult;
            $task_array = json_decode($jsonR, true);
            echo count($task_array);
            echo "<pre>";
            print_r($task_array[700]);
            echo "</pre>";
        } else {
            die("Error!");
        }
    }

    function importStudyJSON() {
        if ($this->session->userdata('role') == 100) {
            $data['importStudyCSV'] = $this->mbackoffice->importStudyJSON();
            echo "<br />Import done<br />";
            //die();
            //$data['duplicatingOvernights'] = $this->mbackoffice->duplicatingOvernights();
            //echo "<br />Overnights duplication done<br />";
            //die();
            $data['syncStudyPax'] = $this->mbackoffice->syncStudyPax();
            echo "Sync done<br />";
            echo "Checking inbound<br />";
            $inb = $this->_checkTransfersStudy("inbound");
            echo "<br />Checking outbound<br />";
            $oub = $this->_checkTransfersStudy("outbound");
            /*
             *
              ?>
              <a target="_blank" href="<?php echo base_url(); ?>index.php/backoffice/_checkTransfersStudy/inbound" title="Check Pax on inbound transfers">Continue to Check Pax on inbound transfers</a><br />
              <a target="_blank" href="<?php echo base_url(); ?>index.php/backoffice/_checkTransfersStudy/outbound" title="Check Pax on outbound transfers">Continue to Check Pax on outbound transfers</a>
              <?php
             */
        } else {
            echo "ERROR!";
            die();
        }
    }

    function TEST_importStudyJSON() {
        ini_set('memory_limit', '512M');
        if ($this->session->userdata('role') == 100) {
            $data['importStudyCSV'] = $this->mbackoffice->TEST_importStudyJSON();
            echo "<br />Import done<br />";
            //die();
            $data['syncStudyPax'] = $this->mbackoffice->syncStudyPax();
            echo "Sync done<br />";
            echo "Checking inbound<br />";
            $inb = $this->_checkTransfersStudy("inbound");
            echo "<br />Checking outbound<br />";
            $oub = $this->_checkTransfersStudy("outbound");
        } else {
            echo "ERROR!";
            die();
        }
    }

    function importStudyNotesJSON__() {
        //if($this->session->userdata('role')==100){
        $importNotes = $this->mbackoffice->importStudyNotesJSON();
        //echo "<br />Notes import done<br />";
        //}else{
        //	echo "ERROR!";
        //	die();
        //}
    }

    function getWsRimborsi() {
        if ($this->session->userdata('role') == 100) {
            $wsdl_url = 'http://devtours.studytours.it/ws/vision.asmx?wsdl';
            $client = new SoapClient($wsdl_url, array('soap_version' => SOAP_1_1));
            $params = array(
                '_UserId' => 'visioN@0315',
                '_Psw' => 'j%asbwY3'
            );
            $result = $client->getPrenotazioniRimborsi($params);
            $jsonR = $result->getPrenotazioniRimborsiResult;
            print_r($jsonR);
            die();
            $task_array = json_decode($jsonR, true);
            //echo count($task_array);
            echo "<pre>";
            print_r($task_array);
            echo "</pre>";
        } else {
            die("Error!");
        }
    }

    function getWsSupplementi() {
        if ($this->session->userdata('role') == 100) {
            $wsdl_url = 'http://devtours.studytours.it/ws/vision.asmx?wsdl';
            $client = new SoapClient($wsdl_url, array('soap_version' => SOAP_1_1));
            $params = array(
                '_UserId' => 'visioN@0315',
                '_Psw' => 'j%asbwY3'
            );
            $result = $client->getPrenotazioniSupplementi($params);
            $jsonR = $result->getPrenotazioniSupplementiResult;
            print_r($jsonR);
            die();
            $task_array = json_decode($jsonR, true);
            //echo count($task_array);
            echo "<pre>";
            print_r($task_array);
            echo "</pre>";
        } else {
            die("Error!");
        }
    }

//inizio funzioni view per roster in backoffice

    function delRosterPax($idPax, $idBook) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $remMap = $this->mbackoffice->remUuidByPaxId($idPax);
            $accoType = $this->mbackoffice->getAccoByPaxId($idPax);
            $koPax = $this->gestione_centri_model->delPaxFromRoster($idPax, $idBook);

            $costoNewAr = explode("___", $this->mbackoffice->getSingleAccoPrice($accoType, $idBook));
            $costoNew = $costoNewAr[0];
            $valutaNew = $costoNewAr[1];
            $insertNew = $this->mbackoffice->insertPayment($idBook, $costoNew * -1, NULL, $valutaNew, NULL, "acq", "Pax deleted", "");
            $sendMail = $this->mbackoffice->sendRosterMail('deleted', $idBook);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function addRosterPax($idBook) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $accoAdded = $this->gestione_centri_model->addPaxToRoster($idBook);
            $costoNewAr = explode("___", $this->mbackoffice->getSingleAccoPrice($accoAdded, $idBook));
            $costoNew = $costoNewAr[0];
            $valutaNew = $costoNewAr[1];
            $insertNew = $this->mbackoffice->insertPayment($idBook, $costoNew, NULL, $valutaNew, NULL, "acq", "Pax added", "");
            $sendMail = $this->mbackoffice->sendRosterMail('added', $idBook);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function modRosterPax($idPax, $idBook) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data['idPax'] = $idPax;
            $data['idBook'] = $idBook;
            $data['paxs'] = $this->mbackoffice->detSinglePax($idPax);
            $centerIDBkg = $this->mbackoffice->campusIdByBookingId($idBook);
            $data['accoS'] = $this->mbackoffice->getAccomodationsByCampusId($centerIDBkg);
            $centriArr = $this->mbackoffice->getCampusByBookId($idBook);
            $data['courseDetails'] = $this->mbackoffice->getCourseList($centriArr[0]['id_centro']);
            if (APP_THEME == 'OLD') {
                $this->load->view('plused_editRosterRow', $data);
            } else {
                $this->load->view('lte/backoffice/edit_roster_row', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function confModRosterPax($idPax, $idBook) {
        if ($this->session->userdata('role')) {
            //print_r($_POST);
            $modThis = $this->mbackoffice->updateSinglePax($idPax, $idBook);
            if ($modThis) {
                echo '1';
            } else {
                echo '0';
            }
            //redirect('backoffice/newAvail/' . $idBook, 'refresh');
            /*
              $data['idPax'] = $idPax;
              $data['paxs'] = $this->mbackoffice->detSinglePax($idPax);
              $this->load->view('plused_editRosterRow',$data); */
        } else {
            redirect('backoffice', 'refresh');
        }
    }

//fine funzioni view per roster in backoffice
//inizio funzioni transportation

    function overviewTransfersNew($status = "") {
        if ($this->session->userdata('role') == 100) {
            $data["transferType"] = isset($_POST['transferType']) ? $_POST['transferType'] : "inbound";
            $data["centri"] = $this->mbackoffice->getAllCampus(1);
            $data['title'] = 'plus-ed.com | Overview transfers';
            $data['breadcrumb1'] = 'Transfers';
            $data['breadcrumb2'] = 'Overview transfers';
            $this->load->view('plused_overviewTransfersNew.php', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function transferCalendar() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $campusArray = $_REQUEST["centri"];
            $transferType = $_REQUEST["transferType"];
            $data["statusArray"] = array("confirmed");
            $dateinArr = explode("/", $_REQUEST["dateStart"]);
            $dateinA = $dateinArr[1] . "/" . $dateinArr[0] . "/" . $dateinArr[2];
            $datech = date('Y-m-d', strtotime($dateinA));
            $datein = date('Y-m-d', strtotime($dateinA . "-15 days"));
            $dateout = date('Y-m-d', strtotime($dateinA . "+15 days"));
            $data["campusArray"] = $campusArray;
            foreach ($campusArray as $campus) {
                $data["campusName"][] = $this->mbackoffice->centerNameById($campus);
                $data['dates'][] = $this->gestione_centri_model->findDatesByCenter($campus);
                $data['simcalendar'][] = $this->mbackoffice->getSimCalendarAllAccos($campus, $datein, $dateout, $data["statusArray"]);
                $data['simTransfersIn'][] = $this->mbackoffice->getSimCalendarAllTransfers($campus, $datein, $dateout, $transferType);
            }
            /*
              echo "<pre>";
              print_r($data['simTransfersIn']);
              echo "</pre>";
              echo "<pre>";
              print_r($data['simcalendar']);
              echo "</pre>"; */
            $data['title'] = 'plus-ed.com | Simulator day 2 day';
            $data['breadcrumb1'] = 'Booking';
            $data['breadcrumb2'] = 'Simulator day 2 day';
            $data['datechoose'] = $datech;
            $data['datein'] = $datein;
            $data['dateout'] = $dateout;
            /* if(count($campusArray)==1)
              $this->load->view('plused_availabilityDetailNew',$data);
              else */
            $this->load->view('plused_transferTotalDetailNew', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

//fine funzioni transportation
//new overnight functions

    function newDuplicateOvernight() {
        if ($this->session->userdata('role') == 100) {
            $duplication = $this->mbackoffice->newDuplicateOvernight();
            //calcola date corrette overnight e inserisci in plused_book_overnight

            echo "ok";
        } else {
            redirect('backoffice', 'refresh');
        }
    }

//fine new overnight functions
//start new tuition functions

    /**
     * campusCourses
     * View list of all available campus courses.
     * @author SK
     * @since Dec-14-2015
     */
    function campusCourses() {
        $this->load->model("tuition/campuscoursemodel", "campuscoursemodel");
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200 && $this->session->userdata('role') != 400) {
            $campusId = $this->session->userdata('sess_campus_id');
            $data["all_courses"] = $this->campuscoursemodel->getData(0, $campusId); // $this->session->userdata('id')
            $data['title'] = "plus-ed.com | Campus courses";
            $data['breadcrumb1'] = 'Tuition';
            $data['breadcrumb2'] = 'Campus courses';

            if (APP_THEME == "OLD")
                $this->load->view('tuition/plused_campus_course', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = "Campus courses";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/tuition/campus_course', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * addcourse
     * This function is used to show add / edit view for campus courses.
     * @param int $edit_id
     * @author SK
     * @since 14-Dec-2015
     */
    function addcourse($edit_id = 0) {
        $this->load->library('form_validation');
        $this->load->model("tuition/campuscoursemodel", "campuscoursemodel");
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200 && $this->session->userdata('role') != 400) {
            $formData = array(
                'selCampus' => '',
                'txtCourseName' => '',
                'radCourseType' => '',
                'txtTotalHours' => ''
            );
            $data['edit_id'] = $edit_id;

            if (!empty($_POST['btnSave'])) {

                $formVal = array(
                    array(
                        'field' => 'txtCourseName',
                        'label' => 'Course',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'selCampus',
                        'label' => 'Campus',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'radCourseType',
                        'label' => 'Type',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'txtTotalHours',
                        'label' => 'Total hours',
                        'rules' => 'required'
                    )
                );
                $this->form_validation->set_rules($formVal);
                if ($this->form_validation->run() == TRUE) {
                    $edit_id = $this->input->post('edit_id');
                    if ($edit_id) {


                        $update_data = array(
                            'cc_course_name' => trim($this->input->post('txtCourseName')),
                            'cc_campus_id' => trim($this->input->post('selCampus')),
                            'cc_course_type' => trim($this->input->post('radCourseType')),
                            'cc_total_hours' => trim($this->input->post('txtTotalHours'))
                        );
                        // CHECK THERE ARE SOME CLASSES CREATED FOR THIS COURSE
                        $classAvailable = $this->campuscoursemodel->operations('check_classes', $update_data, $edit_id);
                        // END OF CHECK
                        if ($classAvailable) {
                            $this->session->set_flashdata('error_message', 'You can not update this campus course, it has already running classes.');
                            redirect('backoffice/addcourse/' . $edit_id);
                        } else {
                            $result = $this->campuscoursemodel->operations('update', $update_data, $edit_id);
                            if ($result) {
                                $this->session->set_flashdata('success_message', 'Record updated successfully.');
                                redirect('backoffice/campusCourses');
                            } else {
                                $this->session->set_flashdata('error_message', 'Unable to add record.');
                            }
                        }
                    } else {
                        $insert_data = array(
                            'cc_course_name' => trim($this->input->post('txtCourseName')),
                            'cc_campus_id' => trim($this->input->post('selCampus')),
                            'cc_course_type' => trim($this->input->post('radCourseType')),
                            'cc_total_hours' => trim($this->input->post('txtTotalHours')),
                            'cc_created_by' => $this->session->userdata('id'),
                            'cc_is_active' => 1,
                            'cc_created_on' => date("Y-m-d H:i:s"),
                            'cc_is_deleted' => 0
                        );

                        $result = $this->campuscoursemodel->operations('insert', $insert_data);
                        if ($result) {
                            $this->session->set_flashdata('success_message', 'Record added successfully.');
                            redirect('backoffice/campusCourses');
                        } else {
                            $this->session->set_flashdata('error_message', 'Unable to add record.');
                        }
                    }
                } else {
                    $formData = array(
                        'selCampus' => trim($this->input->post('selCampus')),
                        'txtCourseName' => trim($this->input->post('txtCourseName')),
                        'radCourseType' => trim($this->input->post('radCourseType')),
                        'txtTotalHours' => trim($this->input->post('txtTotalHours'))
                    );
                }
            } else {
                if ($edit_id) {
                    // get coursedetails for edit purpose
                    $courseDetails = $this->campuscoursemodel->getData($edit_id); // $this->session->userdata('id')

                    if ($courseDetails) {
                        $courseDetails = $courseDetails[0];
                        $formData = array(
                            'selCampus' => $courseDetails['cc_campus_id'],
                            'txtCourseName' => $courseDetails['cc_course_name'],
                            'radCourseType' => $courseDetails['cc_course_type'],
                            'txtTotalHours' => $courseDetails['cc_total_hours']
                        );
                    }
                }
            }
            $campusId = $this->session->userdata('sess_campus_id');
            $data["campusList"] = $this->campuscoursemodel->getCampusList(1, $campusId); // $attivi = 1
            $data['title'] = "plus-ed.com | Campus courses";
            $data['breadcrumb1'] = 'Tuition';
            if ($edit_id)
                $data['breadcrumb2'] = 'Edit course';
            else
                $data['breadcrumb2'] = 'Add new course';
            $data['formData'] = $formData;

            if (APP_THEME == "OLD")
                $this->load->view('tuition/plused_add_campus_course', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/tuition/campus_course_add', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * course_change_status
     * This function is used to toggle course active status.
     * @author SK
     * @since 15-Dec-2015
     */
    function course_change_status() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200 && $this->session->userdata('role') != 400) {
            $this->load->model("tuition/campuscoursemodel", "campuscoursemodel");
            $courseId = $this->input->post('id');
            $courseStatus = $this->input->post('status');
            if ($courseStatus == 1) // change status to update..
                $courseStatus = 0;
            else
                $courseStatus = 1;
            $udpateData = array(
                'cc_is_active' => $courseStatus
            );


            // CHECK THERE ARE SOME CLASSES CREATED FOR THIS COURSE
            $classAvailable = $this->campuscoursemodel->operations('check_classes', array(), $courseId);
            // END OF CHECK
            if ($classAvailable && $courseStatus != 1) {
                echo json_encode(array('result' => 0, 'message' => 'You can not change active status of campus course, it has already running classes.'));
            } else {
                $result = $this->campuscoursemodel->operations('changestatus', $udpateData, $courseId);
                if ($result) {
                    echo json_encode(array('result' => 1, 'message' => 'Course status changed successfully.', 'status' => $courseStatus));
                } else
                    echo json_encode(array('result' => 0, 'message' => 'Unable to change course status.'));
            }
        } else
            echo json_encode(array('result' => 0, 'message' => 'User session is expired.'));
    }

    /**
     * deletecourse
     * This function is used to remove course form system
     * @author SK
     * @since 15-Dec-2015
     */
    function deletecourse($courseId = 0) {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200 && $this->session->userdata('role') != 400) {
            $this->load->model("tuition/campuscoursemodel", "campuscoursemodel");
            // CHECK THERE ARE SOME CLASSES CREATED FOR THIS COURSE
            $classAvailable = $this->campuscoursemodel->operations('check_classes', null, $courseId);
            // END OF CHECK
            if ($classAvailable) {
                $this->session->set_flashdata('error_message', 'You can not delete this campus course, it has already running classes.');
                redirect('backoffice/campusCourses');
            } else {
                $result = $this->campuscoursemodel->operations('delete', null, $courseId);
                if ($result) {
                    $this->session->set_flashdata('success_message', 'Record deleted successfully.');
                    redirect('backoffice/campusCourses');
                } else
                    $this->session->set_flashdata('error_message', 'Unable to delete record.');
                redirect('backoffice/campusCourses');
            }
        }
        else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

//end new tuition functions
//Start : additions by Arunsankar S since 06-Apr-2016

    /**
     * Function to import roster data as xls
     * @author Arunsankar S
     * @since 06-Apr-2016
     * @param int $idBook Booking ID
     * @return file Will download excel file
     */
    function exportRoster($idBook) {
        ini_set('date.timezone', 'UTC');
        $this->load->library('Excel_180');
        $dataBook = $this->mbackoffice->overviewSingleBooking($idBook);
        $detMyPax = $this->mbackoffice->detMyPaxForRosterBackoffice($dataBook[0]["id_year"], $idBook);
        $dataArray[] = array('ID Number', 'Name', 'Surname', 'DOB', 'DOC', 'Citizenship', 'Type of pax (GL/STD)', 'Sex (M/F)', 'Accommodation type', 'Group leader', 'Info', 'Share room', 'Campus Arrival Date', 'Campus Departure Date', 'Arrival Flight number', 'Arrival Flight date and time', 'Arrival airport', 'Departure airport for the arrival flight', 'Departure Flight number', 'Departure Flight date and time', 'Departure airport', 'Arrival airport for the departure flight');
        $counter = 1;
        foreach ($detMyPax as $det) {
            $dataArray[] = array(
                $counter,
                trim($det["nome"], '='),
                trim($det['cognome'], '='),
                PHPExcel_Shared_Date::PHPToExcel(strtotime($det["pax_dob"])),
                trim($det["numero_documento"], '='),
                trim($det["nazionalita"], '='),
                trim($det["tipo_pax"], '='),
                trim($det["sesso"], '='),
                trim(ucfirst($det["accomodation"]), '='),
                trim($det["gl_rif"], '='),
                trim($det["salute"], '='),
                trim($det["share_room"], '='),
                PHPExcel_Shared_Date::PHPToExcel(strtotime($det["data_arrivo_campus"])),
                PHPExcel_Shared_Date::PHPToExcel(strtotime($det["data_partenza_campus"])),
                trim($det["andata_volo"], '='),
                PHPExcel_Shared_Date::PHPToExcel(strtotime($det["andata_data_arrivo"])),
                trim($det["andata_apt_arrivo"], '='),
                trim($det["andata_apt_partenza"], '='),
                trim($det["ritorno_volo"], '='),
                PHPExcel_Shared_Date::PHPToExcel(strtotime($det["ritorno_data_partenza"])),
                trim($det["ritorno_apt_partenza"], '='),
                trim($det["ritorno_apt_arrivo"], '=')
            );
            $counter += 1;
        }
        $sheet = $this->excel_180->getActiveSheet();
        if (is_array($dataArray) && !empty($dataArray)) {
            $fileName = 'booking_roster_' . $dataBook[0]["id_year"] . '_' . $idBook;
            $this->excel_180->getActiveSheet()->fromArray($dataArray, NULL, 'A1');
            for ($col = 'A'; $col <= 'U'; $col++) {
                $sheet->getColumnDimension($col)->setAutoSize(TRUE);
            }
            $sheet->getStyle('D2:D' . $sheet->getHighestDataRow())->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY2);
            $sheet->getStyle('L2:M' . $sheet->getHighestDataRow())->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY2);
            $sheet->getStyle('O2:O' . $sheet->getHighestDataRow())->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIME2);
            $sheet->getStyle('S2:S' . $sheet->getHighestDataRow())->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIME2);
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"" . $fileName . ".xls\"");
            header("Cache-Control: max-age=0");
            $writeObj = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
            $writeObj->save("php://output");
        } else {
            $this->session->set_flashdata('error_message', 'No records found to export.');
            redirect('backoffice/overviewBookingsNew');
        }
    }

    /**
     * Function for unlock roster
     * @author Arunsankar
     * @since 19/04/2016
     */
    function unlockSingleRoster() {
        if ($this->session->userdata('role') == 100) {
            $rowId = $this->input->post('rowId');
            if (!empty($rowId) && is_numeric($rowId)) {
                $isLock = $this->mbackoffice->unlockSingleRoster($rowId);
                if ($isLock) {
                    echo '1';
                } else {
                    echo '0';
                }
            } else {
                echo '0';
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to get template list on backoffice
     * @author Arunsankar
     * @param type $bookId
     */
    function visaTemplates($bookId) {
        if ($this->session->userdata('role') == 100) {
            $data['bookId'] = $bookId;
            $data['book'] = $this->magenti->overviewSingleBooking($bookId);
            $data['templates'] = $this->magenti->getTemplateListWithoutNatMapped($data['book'][0]['id_centro']);
            $data['detMyPax'] = $this->magenti->detMyPaxForRosterBackoffice($data['book'][0]["id_year"], $bookId);
            if (APP_THEME == 'OLD') {
                $this->load->view('visa/view_backoffice_template', $data);
            } else {
                $this->load->view('lte/backoffice/visa_templates', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to check pax is locked or not for particular booking
     * @author Arunsankar
     * @param type $bookId
     */
    function checkLockPax($bookId) {
        if ($this->session->userdata('role') == 100) {

            $data['detSTD'] = $this->magenti->listPax($bookId, "STD", 1);
            $data['detGL'] = $this->magenti->listPax($bookId, "GL", 1);

            if (!empty($data['detSTD']) || !empty($data['detGL'])) {
                echo json_encode(array('status' => 1));
            } else {
                echo json_encode(array('status' => 0));
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to display the preview of pdf after select any template
     * @author Arunsankar
     */
    function visaPDFDemo($templ) {
        if ($this->session->userdata('role') == 100) {
            if ($templ && ($templ == 'USA' || $templ == 'UKIR' || $templ == 'MAL' || $templ == 'UKIRGLSTD' || $templ == 'UKIRSTDSTD' || $templ == 'UKIRSTDST' )) {
                $data['template'] = $templ;
                $this->load->plugin('to_pdf');
                $html = $this->load->view('visa/PDF_visas_demo', $data, true);
                pdf_create($html, 'PDF_VISAS_DEMO_' . $templ);
            } else {
                redirect('backoffice', 'refresh');
            }
        }
    }

    /**
     * Function for search nationality
     * @author Arunsankar
     */
    function searchNat() {
        if ($this->session->userdata('role')) {
            $this->mbackoffice->searchNat();
        }
    }

    /**
     * Function to check the nationalities typed in the field is valid or not
     * @author Arunsankar
     */
    function checkTypedNationality() {
        if ($this->session->userdata('role')) {
            $nationality = $this->input->post('nationality');
            $isNationalityAvailable = $this->mbackoffice->checkTypedNationality($nationality);
            if ($isNationalityAvailable) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function ca_reviewbydate_pax_new() {
        authSessionMenu($this);
        $data['title'] = 'plus-ed.com | View booked transfers';
        $data['breadcrumb1'] = 'Campus review';
        $data['breadcrumb2'] = 'Review campus by date';
        $data['campus'] = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));

        if (APP_THEME == "OLD")
            $this->load->view('tuition/plused_ca_reviewdaybydate_pax_new', $data);
        else { // if(APP_THEME == "LTE")
            $data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/campus_manager/reviewdaybydate_pax_new', $data);
        }
    }

    function reviewByDate($date = '') {
        if (APP_THEME == "LTE")
            $date = $this->input->post('date') ? $this->input->post('date') : '';
        if ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 553) {
            if ($date) {
                $date = str_replace('-', '/', $date);
                $dateArr = explode('/', $date);
                $isDate = FALSE;
                $data['date'] = '';
                if (isset($dateArr[0]) && isset($dateArr[1]) && isset($dateArr[2])) {
                    if (checkdate(str_pad($dateArr[1], 2, '0', STR_PAD_LEFT), str_pad($dateArr[0], 2, '0', STR_PAD_LEFT), $dateArr[2])) {
                        $isDate = TRUE;
                        $data['date'] = $date;
                    }
                }
                if ($isDate) {
                    $data['title'] = 'plus-ed.com | View booked transfers';
                    $data['breadcrumb1'] = 'Campus Review';
                    $data['breadcrumb2'] = 'Review campus by date';
                    $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
                    $dateSel = $dateArr[0];
                    $monthSel = $dateArr[1];
                    $yearSel = $dateArr[2];
                    $data['num_transfers'] = $this->mbackoffice->ca_getTransfersNumSingle($campus, $dateSel, $monthSel, $yearSel);
                    $data['num_excursions'] = $this->mbackoffice->ca_getExcursionsNumSingle($campus, $dateSel, $monthSel, $yearSel);
                    $data['num_extra_excursions'] = $this->mbackoffice->ca_getExtraExcursionsNumSingle($campus, $dateSel, $monthSel, $yearSel);
                    $data['books'] = $this->mbackoffice->ca_getBkCalendar_paxSingle($campus, 'standard', $dateSel, $monthSel, $yearSel);
                    if ($this->session->userdata('role') == 553) {
                        $data['bursarLogin'] = true;
                        $data['activeBookings'] = $this->mbackoffice->br_getBookingsCountForBursarReview($campus, 'active', $dateSel, $monthSel, $yearSel);
                    }
                    $data['campusname'] = $this->mbackoffice->centerNameById($campus);
                    $data['campus'] = $campus;
                    $dateinA = $monthSel . "/" . $dateSel . "/" . $yearSel;
                    $datech = date('Y-m-d', strtotime($dateinA));
                    $datein = date('Y-m-d', strtotime($dateinA . "-15 days"));
                    $dateout = date('Y-m-d', strtotime($dateinA . "+15 days"));
                    $data['simbookingOvernights'][] = $this->mbackoffice->NA_getSimBooking_overnight_backoffice($campus, 'standard', $datein, $dateout, array("confirmed"));
                    $data['datechoose'] = $datech;
                    $data['datein'] = $datein;
                    $data['dateout'] = $dateout;
                    $data['dates'] = $this->gestione_centri_model->findDatesByCenter($campus);
                    if (APP_THEME == "OLD")
                        $this->load->view('tuition/plused_ca_reviewdaybydate_popup', $data);
                    else
                        $this->load->view('tuition/plused_ca_reviewdaybydate_popup_new', $data);
                }
                else {
                    redirect('backoffice/ca_reviewbydate_pax_new', 'refresh');
                }
            } else {
                redirect('backoffice/ca_reviewbydate_pax_new', 'refresh');
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    public function getActiveBookingForDate() {
        if ($this->session->userdata('role') == 553) {
            $date = $this->input->post('date');
            $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $data['bookings'] = $this->mbackoffice->getActiveBookingsForBursars($campus, $date);
            if (APP_THEME == 'OLD')
                $this->load->view('plused_view_campusd2d_detail', $data);
            else
                $this->load->view('lte/backoffice/bookings/view_active_bookings', $data);
        }
        else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to open page for open a ticket
     * @author Arunsankar
     * @since 08-June-2016
     */
    function openTicket() {
        if ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 400) {
            $data['title'] = 'plus-ed.com | Open Ticket';
            $data['breadcrumb1'] = 'Manage ticket';
            $data['breadcrumb2'] = 'Open ticket';
            $campus = $this->session->userdata('sess_campus_id');
            $data['bookings'] = $this->mbackoffice->getBookingRefFromCentro($campus);
            $data['priority'] = '';
            $data['category'] = '';
            $data['tktTitle'] = '';
            $data['content'] = '';
            $data['refBook'] = '';
            if (isset($_POST['btnSave'])) {
                $errorNo = 0;
                $priority = $_POST['priority'];
                $selCategory = $_POST['selCategory'];
                $tktTitle = $_POST['tktTitle'];
                $tktContent = $_POST['tktContent'];
                $selRefBooking = $_POST['selRefBooking'];
                $data['priority'] = $priority;
                $data['category'] = $selCategory;
                $data['tktTitle'] = $tktTitle;
                $data['content'] = $tktContent;
                $data['refBook'] = $selRefBooking;
                if ($priority != 'low' && $priority != 'medium' && $priority != 'high') {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Invalid priority');
                }
                if (empty($selCategory)) {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Please select category');
                }
                if (empty($tktTitle)) {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Please enter title');
                }
                if (empty($tktContent)) {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Please enter text');
                }
                if (empty($selRefBooking)) {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Please select Reference booking');
                }
                if ($errorNo == 0) {
                    $fileError = 0;
                    $fileName = '';
                    if (isset($_FILES['fileAttachment']['name'])) {
                        if (!empty($_FILES['fileAttachment']['name'])) {
                            $config['upload_path'] = TICKET_CM_PATH;
                            $config['allowed_types'] = '*';
                            $config['max_size'] = '2048';
                            $config['encrypt_name'] = TRUE;

                            $this->load->library('upload', $config);

                            if (!$this->upload->do_upload('fileAttachment')) {
                                $fileError += 1;
                                $this->session->set_flashdata('error_message', 'Failed to upload file (files greater than 2 MB is not allowed)');
                            } else {
                                $uploadData = $this->upload->data();
                                $fileName = $uploadData['file_name'];
                            }
                        }
                    }
                    if ($fileError == 0) {
                        $insertData = array(
                            'campus_id' => $campus,
                            'ptc_priority' => $priority,
                            'ptc_category' => $selCategory,
                            'ptc_title' => $tktTitle,
                            'ptc_content' => $tktContent,
                            'ptc_attachment' => $fileName,
                            'ptc_ref_booking' => $selRefBooking,
                            'ptc_sender_type' => ( $this->session->userdata('role') == 400 ) ? 'Course Director' : 'Campus Manager'
                        );
                        $isInsert = $this->mbackoffice->insertTicket($insertData);
                        $openDate = date('d-F-Y H:i:s');
                        if ($isInsert) {
                            $campusName = $this->mbackoffice->getCampusNameFromId($campus);
                            $this->load->library('email');
                            $this->email->set_newline("\r\n");
                            $mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
                            $mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
                            $mymessage .= "Campus " . $campusName . ": ticket opened on " . $openDate . "<br />Category: " . $selCategory . "<br />";
                            $mymessage .= "<strong>Plus Vision</strong>" . "<br/><br/>";
                            $mymessage .= "</body></html>";
                            $this->email->from('info@plus-ed.com', 'Plus Vision');
                            if ($this->session->userdata('role') == 200)
                                $this->email->to('r.russo@plus-ed.com');
                            else
                                $this->email->to('a.rew@plus-ed.com,k.klosinska@plus-ed.com');
                            $this->email->subject('New ticket opened - ' . $campusName);
                            $this->email->message($mymessage);
                            $this->email->send();
                            $this->session->set_flashdata('success_message', 'Ticket added successfully');
                            redirect('backoffice/openTicket', 'refresh');
                        }
                        else {
                            $this->session->set_flashdata('error_message', 'Failed to add ticket');
                            redirect('backoffice/openTicket');
                        }
                    } else {
                        redirect('backoffice/openTicket');
                    }
                } else {
                    redirect('backoffice/openTicket');
                }
            }

            if (APP_THEME == "OLD")
                $this->load->view('tuition/plused_open_ticket', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/campus_manager/open_ticket', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to open the ticket recap page
     * @author Arunsankar
     * @since 08-06-2016
     */
    function recapTicket() {
        if ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 400) {
            $data['title'] = 'plus-ed.com | Recap Ticket';
            $data['breadcrumb1'] = 'Manage ticket';
            $data['breadcrumb2'] = 'Recap';
            $campus = $this->session->userdata('sess_campus_id');
            $type = ( $this->session->userdata('role') == 400 ) ? 'Course Director' : 'Campus Manager';
            $data['rowDetails'] = $this->mbackoffice->getTicketDetails('', $campus, $type);
            $data['rowInboxDetails'] = $this->mbackoffice->getTicketDetails('', $campus, $type, 0);

            if (APP_THEME == "OLD")
                $this->load->view('tuition/plused_recap_ticket', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/campus_manager/recap_ticket', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to delete a ticket
     * @author Arunsankar
     * @since 09-06-2016
     */
    function deleteTicket() {
        if ($this->session->userdata('role') == 200) {
            $selId = $this->input->post('selId');
            if ($selId && is_numeric($selId)) {
                $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
                $ticketDetails = $this->mbackoffice->getTicketDetails($selId, $campus);
                $isDelete = $this->mbackoffice->deleteTicket($selId);
                if ($isDelete) {
                    $ticketDetails[0]['ptc_attachment'] ? @unlink(TICKET_CM_PATH . $ticketDetails[0]['ptc_attachment']) : '';
                    echo '1';
                } else {
                    echo '0';
                }
            } else {
                $this->session->set_flashdata('error_message', 'Invalid ticket');
                redirect('backoffice/recapTicket', 'refresh');
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to open the modal for edit ticket
     * @author Arunsankar
     * @since 08-06-2016
     */
    function openTicketEdit($ptcId) {
        if ($this->session->userdata('role') == 200) {
            $data['title'] = 'plus-ed.com | Edit Ticket';
            $data['breadcrumb1'] = 'Ticket Management';
            $data['breadcrumb2'] = 'Edit Ticket';
            $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $data['bookings'] = $this->mbackoffice->getBookingRefFromCentro($campus);
            $ticketDetails = $this->mbackoffice->getTicketDetails($ptcId, $campus);
            $data['ticket'] = $ticketDetails[0];
            $this->load->view('tuition/plused_editTicketRow', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to check the status of ticket
     * @author Arunsankar
     * @since 08-06-2016
     */
    function checkTicketStatus() {
        if ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 400) {
            $selId = $this->input->post('selId');
            $isTicketAvailable = $this->mbackoffice->checkTicketStatus($selId);
            if ($isTicketAvailable) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to update a ticket
     * @author Arunsankar
     * @since 08-06-2016
     */
    function updateTicket($selId) {
        if ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 400) {
            $errorNo = 0;
            $priority = $_POST['priority'];
            $selCategory = $_POST['selCategory'];
            $tktTitle = $_POST['tktTitle'];
            $tktContent = $_POST['tktContent'];
            $selRefBooking = $_POST['selRefBooking'];
            $error = '';
            if (empty($selId) || !is_numeric($selId)) {
                $errorNo += 1;
                $error = 'Invalid data';
            }
            if ($priority != 'low' && $priority != 'medium' && $priority != 'high') {
                $errorNo += 1;
                $error = 'Invalid priority';
            }
            if (empty($selCategory)) {
                $errorNo += 1;
                $error = 'Please select category';
            }
            if (empty($tktTitle)) {
                $errorNo += 1;
                $error = 'Please enter title';
            }
            if (empty($tktContent)) {
                $errorNo += 1;
                $error = 'Please enter text';
            }
            if (empty($selRefBooking)) {
                $errorNo += 1;
                $error = 'Please select Reference booking';
            }

            if ($errorNo == 0) {
                $fileError = 0;
                $fileName = '';
                if (isset($_FILES['fileAttachment']['name'])) {
                    if (!empty($_FILES['fileAttachment']['name'])) {
                        $config['upload_path'] = TICKET_CM_PATH;
                        $config['allowed_types'] = '*';
                        $config['max_size'] = '2048';
                        $config['encrypt_name'] = TRUE;
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('fileAttachment')) {
                            $fileError += 1;
                            $this->session->set_flashdata('error_message', 'Failed to upload file (files greater than 2 MB is not allowed)');
                            $error = 'Failed to upload file (files greater than 2 MB is not allowed)';
                        } else {
                            $uploadData = $this->upload->data();
                            $fileName = $uploadData['file_name'];
                        }
                    }
                }
                if ($fileError == 0) {
                    $updateData = array(
                        'ptc_priority' => $priority,
                        'ptc_category' => $selCategory,
                        'ptc_title' => $tktTitle,
                        'ptc_content' => $tktContent,
                        'ptc_ref_booking' => $selRefBooking
                    );
                    if ($fileName) {
                        $updateData['ptc_attachment'] = $fileName;
                    }
                    $where = array(
                        'ptc_id' => $selId
                    );
                    $isUpdate = $this->mbackoffice->updateTicket($updateData, $where);
                    if ($isUpdate) {
                        $this->session->set_flashdata('success_message', 'Ticket successfully updated');
                        echo '1';
                    } else {
                        echo 'Failed to update ticket';
                    }
                } else {
                    echo $error;
                }
            } else {
                echo $error;
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to remove the attachment in a ticket
     * @author Arunsankar
     * @since 09-06-2016
     */
    function removeAttachment() {
        if ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 400) {
            $selId = $this->input->post('selId');
            $isRemove = $this->mbackoffice->removeAttachment($selId);
            if ($isRemove) {
                $this->session->set_flashdata('success_message', 'Attachment removed successfully');
                echo '1';
            } else {
                echo '0';
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to make the reply read by CM
     * @author Arunsankar
     * @since 14-June-2016
     */
    function readByCm() {
        if ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 400) {
            $selId = $this->input->post('selId');
            $data = array(
                'ptc_cm_read' => 1
            );
            $where = array(
                'ptc_id' => $selId
            );
            $isUpdate = $this->mbackoffice->updateTicket($data, $where);
            if ($isUpdate) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    /**
     * Function to make the reply read by CM
     * @author Arunsankar
     * @since 17-Feb-2017
     */
    function readByBo() {
        if ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 400) {
            $selId = $this->input->post('selId');
            $data = array(
                'ptc_bo_read' => 1
            );
            $where = array(
                'ptc_id' => $selId
            );
            $isUpdate = $this->mbackoffice->updateTicket($data, $where);
            if ($isUpdate) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    /**
     * Fuction to get the GL credentials
     * @author Arunsankar
     * @since 21-June-2016
     */
    function glCredentials() {
        if ($this->session->userdata('username') && ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 553)) {
            $data['title'] = "plus-ed.com | GL and students list";
            $data['breadcrumb1'] = 'GL and students credentials';
            $data['breadcrumb2'] = 'GL and students list';
            $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $data['gldetails'] = $this->mbackoffice->getGlDetails($campus);
            $data['campus'] = $campus;

            if (APP_THEME == "OLD")
                $this->load->view('tuition/plused_gl_list', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/campus_manager/gl_list', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to export as excel of all GL credentials
     * @author Arunsankar
     * @since 21-June-2016
     */
    function exportGldetails() {
        ini_set('date.timezone', 'UTC');
        if ($this->session->userdata('username') && ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 553)) {
            $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $data['gldetails'] = $this->mbackoffice->getGlDetails($campus);
            $this->load->library('excel_180');
            $cnt = 3;
            $sheet = $this->excel_180->getActiveSheet();
            foreach ($data['gldetails'] as $gld) {
                if ($gld) {
                    $gluuidArr = explode(',', $gld['gluuid']);
                    if (!empty($gluuidArr)) {
                        foreach ($gluuidArr as $uuid) {
                            $uuidArr = explode(':', $uuid);
                            $aVal = isset($uuidArr[2]) ? $uuidArr[2] : '';
                            $bVal = isset($uuidArr[3]) ? $uuidArr[3] : '';
                            $cVal = $gld['book_id'];
                            $dVal = isset($uuidArr[0]) ? $uuidArr[0] : '';
                            $eVal = '';
                            if (isset($uuidArr[1])) {
                                $eVal = $uuidArr[1] ? PHPExcel_Shared_Date::PHPToExcel(strtotime($uuidArr[1])) : '';
                            }
                            $sheet->setCellValue('A' . $cnt, trim($aVal, '='));
                            $sheet->setCellValue('B' . $cnt, trim($bVal, '='));
                            $sheet->setCellValue('E' . $cnt, trim($cVal, '='));
                            $sheet->setCellValue('D' . $cnt, trim($dVal, '='));
                            $sheet->getStyle('D' . $cnt)->getNumberFormat()->setFormatCode('000000000000');
                            $sheet->setCellValue('C' . $cnt, trim($eVal, '='));
                            $sheet->getStyle('C' . $cnt)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY2);
                            $cnt += 1;
                        }
                    }
                }
            }
            $sheet->getStyle('A1:E2')->getFont()->setBold(true);
            $sheet->mergeCells("A1:E1");
            $sheet->setCellValue('A1', 'Survey URL: http://plus-ed.com/vision_ag/index.php/survey');
            $sheet->getCell('A1')->getHyperlink()->setUrl('http://plus-ed.com/vision_ag/index.php/survey');
            $link_style_array = array(
                'font' => array(
                    'color' => array('rgb' => '0000FF'),
                    'underline' => 'single'
                )
            );
            $sheet->getStyle("A1")->applyFromArray($link_style_array);
            $sheet->setCellValue('A2', 'Name');
            $sheet->setCellValue('B2', 'Surname');
            $sheet->setCellValue('C2', 'Date of birth');
            $sheet->setCellValue('D2', 'Pax Type');
            $sheet->setCellValue('E2', 'Booking ID');
            $sheet->getColumnDimension('A')->setAutoSize(TRUE);
            $sheet->getColumnDimension('B')->setAutoSize(TRUE);
            $sheet->getColumnDimension('C')->setAutoSize(TRUE);
            $sheet->getColumnDimension('D')->setAutoSize(TRUE);
            $sheet->getColumnDimension('E')->setAutoSize(TRUE);
            $filename = 'export_gl_credentials.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
            $objWriter->save('php://output');
            die();
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to export each GL row as excel
     * @author Arunsankar
     * @since 22-June-2016
     */
    function exportGldetailsRow($bookId) {
        ini_set('date.timezone', 'UTC');
        if ($this->session->userdata('username') && ($this->session->userdata('role') == 200 || $this->session->userdata('role') == 553) && !empty($bookId)) {
            $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $bookArr = explode('_', $bookId);
            $year = $bookArr[0];
            $id = $bookArr[1];
            $data['gldetails'] = $this->mbackoffice->getGlDetailsRow($campus, $year, $id);
            $this->load->library('excel_180');
            $cnt = 3;
            $sheet = $this->excel_180->getActiveSheet();
            foreach ($data['gldetails'] as $gld) {
                if ($gld) {
                    $gluuidArr = explode(',', $gld['gluuid']);
                    if (!empty($gluuidArr)) {
                        foreach ($gluuidArr as $uuid) {
                            $uuidArr = explode(':', $uuid);
                            $aVal = isset($uuidArr[2]) ? $uuidArr[2] : '';
                            $bVal = isset($uuidArr[3]) ? $uuidArr[3] : '';
                            $cVal = $gld['book_id'];
                            $dVal = isset($uuidArr[0]) ? $uuidArr[0] : '';
                            $eVal = '';
                            if (isset($uuidArr[1])) {
                                $eVal = $uuidArr[1] ? PHPExcel_Shared_Date::PHPToExcel(strtotime($uuidArr[1])) : '';
                            }
                            $sheet->setCellValue('A' . $cnt, trim($aVal, '='));
                            $sheet->setCellValue('B' . $cnt, trim($bVal, '='));
                            $sheet->setCellValue('E' . $cnt, trim($cVal, '='));
                            $sheet->setCellValue('D' . $cnt, trim($dVal, '='));
                            $sheet->getStyle('D' . $cnt)->getNumberFormat()->setFormatCode('000000000000');
                            $sheet->setCellValue('C' . $cnt, trim($eVal, '='));
                            $sheet->getStyle('C' . $cnt)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY2);
                            $cnt += 1;
                        }
                    }
                }
            }
            $sheet->getStyle('A1:E2')->getFont()->setBold(true);
            $sheet->mergeCells("A1:E1");
            $sheet->setCellValue('A1', 'Survey URL: http://plus-ed.com/vision_ag/index.php/survey');
            $sheet->getCell('A1')->getHyperlink()->setUrl('http://plus-ed.com/vision_ag/index.php/survey');
            $link_style_array = array(
                'font' => array(
                    'color' => array('rgb' => '0000FF'),
                    'underline' => 'single'
                )
            );
            $sheet->getStyle("A1")->applyFromArray($link_style_array);
            $sheet->setCellValue('A2', 'Name');
            $sheet->setCellValue('B2', 'Surname');
            $sheet->setCellValue('C2', 'Date of birth');
            $sheet->setCellValue('D2', 'Pax Type');
            $sheet->setCellValue('E2', 'Booking ID');
            $sheet->getColumnDimension('A')->setAutoSize(TRUE);
            $sheet->getColumnDimension('B')->setAutoSize(TRUE);
            $sheet->getColumnDimension('C')->setAutoSize(TRUE);
            $sheet->getColumnDimension('D')->setAutoSize(TRUE);
            $sheet->getColumnDimension('E')->setAutoSize(TRUE);
            $filename = 'export_gl_credentials_' . $bookId . '.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
            $objWriter->save('php://output');
            die();
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to export transfer details
     * @author Arunsankar
     * @since 22-June-2016
     */
    function csvTrasferBus_pax($campus = "", $date = "") {
        ini_set('date.timezone', 'UTC'); //setting timezone for proper time calculation
        if ($this->session->userdata('username') && $this->session->userdata('role') == 200) {
            if (!empty($campus) && !empty($date)) {
                $detBusCodes = $this->mbackoffice->ca_getTransfersBusCodesForDay($date, $campus);
                $flgDetails = array();
                $flightDetails = '';
                $this->load->library('excel_180');
                //Add the headings
                $sheet = $this->excel_180->getActiveSheet();
                $sheet->setCellValue('A1', 'Bus Code');
                $sheet->setCellValue('B1', 'Transfer Date');
                $sheet->setCellValue('C1', 'Transfer Type');
                $sheet->setCellValue('D1', 'Pax');
                $sheet->setCellValue('E1', 'Flight Details');
                $sheet->setCellValue('E2', 'Booking ID');
                $sheet->setCellValue('F2', 'Flight No');
                $sheet->setCellValue('G2', 'Time');
                $sheet->setCellValue('H2', 'From Airport');
                $sheet->setCellValue('I2', 'To Airport');
                $sheet->mergeCells("A1:A2");
                $sheet->mergeCells("B1:B2");
                $sheet->mergeCells("C1:C2");
                $sheet->mergeCells("D1:D2");
                $sheet->mergeCells("E1:I1");
                //Decalre border style
                $BStyle = array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $sheet->getStyle('A1:I2')->applyFromArray($BStyle);
                //Setting the position to horizontally center
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    )
                );
                $sheet->getStyle("E1:I1")->applyFromArray($style);
                if (!empty($detBusCodes)) {
                    $startRow = 3;
                    $endRow = 2;
                    foreach ($detBusCodes as $buscode) {
                        if ($buscode['ptt_buscompany_code']) {
                            $arrayescursioni = $this->mbackoffice->getTraIdsFromBusCode($buscode['ptt_buscompany_code']);
                            $flgDetails[$buscode['ptt_buscompany_code']] = $this->mbackoffice->bkgDetailsForTransfer($arrayescursioni);
                            $flightCount = 0;
                            $totalRowNo = 1;
                            $sheet->setCellValue('A' . ($endRow + 1), $buscode['ptt_buscompany_code']);
                            $sheet->setCellValue('B' . ($endRow + 1), PHPExcel_Shared_Date::PHPToExcel(strtotime($buscode['ptt_dataora'])));
                            $sheet->getStyle('B' . ($endRow + 1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY2); //setting the date format dd/mm/yyyy
                            $sheet->setCellValue('C' . ($endRow + 1), ucfirst($buscode['ptt_type']));
                            $sheet->setCellValue('D' . ($endRow + 1), $buscode['tuttipax']);
                            $sheet->getStyle('A' . ($endRow + 1) . ':D' . ($endRow + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); //setting vertical center position
                            if (isset($flgDetails[$buscode["ptt_buscompany_code"]])) {
                                if (!empty($flgDetails[$buscode['ptt_buscompany_code']])) {
                                    foreach ($flgDetails[$buscode["ptt_buscompany_code"]] as $flight) {
                                        $flightCount += 1;
                                        $totalRowNo += 1;
                                        $endRow += 1;
                                        $sheet->setCellValue('E' . $endRow, $flight['ptt_book_id']);
                                        $sheet->setCellValue('F' . $endRow, $flight["ptt_flight"]);
                                        $sheet->setCellValue('G' . $endRow, PHPExcel_Shared_Date::PHPToExcel(strtotime($flight['ptt_dataora'])));
                                        $sheet->getStyle('G' . $endRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3); //Setting time format h:mm
                                        $sheet->setCellValue('H' . $endRow, $flight["ptt_airport_from"]);
                                        $sheet->setCellValue('I' . $endRow, $flight["ptt_airport_to"]);
                                    }
                                    $sheet->getStyle('A' . $startRow . ':I' . $endRow)->applyFromArray($BStyle);
                                    if ($flightCount > 1) {
                                        $sheet->mergeCells("A" . $startRow . ":A" . $endRow);
                                        $sheet->mergeCells("B" . $startRow . ":B" . $endRow);
                                        $sheet->mergeCells("C" . $startRow . ":C" . $endRow);
                                        $sheet->mergeCells("D" . $startRow . ":D" . $endRow);
                                    }
                                    $startRow = $endRow + 1;
                                }
                            }
                        }
                    }
                }
                $sheet->getStyle('A1:I2')->getFont()->setBold(true); //set heading bold
                //setting width of each column
                $sheet->getColumnDimension('A')->setWidth(15);
                $sheet->getColumnDimension('B')->setWidth(15);
                $sheet->getColumnDimension('C')->setWidth(15);
                $sheet->getColumnDimension('D')->setWidth(4);
                $sheet->getColumnDimension('E')->setAutoSize(TRUE);
                $sheet->getColumnDimension('F')->setAutoSize(TRUE);
                $sheet->getColumnDimension('G')->setAutoSize(TRUE);
                $sheet->getColumnDimension('H')->setAutoSize(TRUE);
                $sheet->getColumnDimension('I')->setAutoSize(TRUE);
                $filename = 'Transfers_export_' . $date . '.xls';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
                $objWriter->save('php://output');
            } else {
                redirect('backoffice', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to show cm payment page
     * @author Arunsankar
     * @since 28-June-2016
     */
    function bsPayments() {
        authSessionMenu($this);
        $data['title'] = 'plus-ed.com | Payments';
        $data['breadcrumb1'] = 'Petty cash';
        $data['breadcrumb2'] = 'Payments';
        $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
        $data['payments'] = $this->mbackoffice->getCmPayments($campus);
        $data['payTypes'] = $this->mbackoffice->getAllPaymentTypes();
        $data['payServices'] = $this->mbackoffice->getAllCMPaymentServices();
        $data['payBookings'] = $this->mbackoffice->getBookingRefFromCentro($campus);

        if (APP_THEME == "OLD")
            $this->load->view('tuition/plused_cm_payments', $data);
        else { // if(APP_THEME == "LTE")
            $data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/campus_manager/payments', $data);
        }
    }

    /**
     * Fuction to insert cm payment
     * @author Arunsankar
     * @since 28-June-2016
     */
    function insertCMSinglePayment() {
        if ($this->session->userdata('username') && $this->session->userdata('role') == 200) {
            $this->load->library('form_validation');
            $formVal = array(
                array(
                    'field' => 'P_typePay',
                    'label' => 'Type',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'P_curDate',
                    'label' => 'Payment Date',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'P_amount',
                    'label' => 'Amount/Due',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'P_currency',
                    'label' => 'Currency',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'P_operation',
                    'label' => 'Service',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'P_method',
                    'label' => 'Method',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'P_bookList',
                    'label' => 'Booking ID',
                    'rules' => 'required'
                )
            );
            $this->form_validation->set_rules($formVal);
            if ($this->form_validation->run() == TRUE) {
                $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
                $fileName = '';
                $fileError = 0;
                if (isset($_FILES['CmPicFile']['name'])) {
                    if (!empty($_FILES['CmPicFile']['name'])) {
                        $config['upload_path'] = PAYMENT_CM_PATH;
                        $config['allowed_types'] = 'jpg|png|jpeg|gif|pdf';
                        $config['max_size'] = '2048';
                        $config['encrypt_name'] = TRUE;
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('CmPicFile')) {
                            $fileError += 1;
                            $this->session->set_flashdata('error_message', 'Failed to upload file (Images and PDF are only allowed with maximum size of 2 MB)');
                        } else {
                            $uploadData = $this->upload->data();
                            $fileName = $uploadData['file_name'];
                        }
                    }
                }
                if ($fileError == 0) {
                    $insert_data = array(
                        'campus_id' => $campus,
                        'pcp_book_id' => trim($this->input->post('P_bookList')),
                        'pcp_ref_book' => trim($this->input->post('P_refBook')),
                        'pcp_amount' => trim($this->input->post('P_amount')),
                        'pcp_currency' => trim($this->input->post('P_currency')),
                        'pcp_pay_date' => trim(date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('P_curDate'))))),
                        'pcp_pay_type' => trim($this->input->post('P_typePay')),
                        'pcp_service' => trim($this->input->post('P_operation')),
                        'pcp_method' => trim($this->input->post('P_method')),
                        'pcp_document' => $fileName
                    );
                    $isInsert = $this->mbackoffice->insertCmPayment($insert_data);
                    if ($isInsert) {
                        $this->session->set_flashdata('success_message', 'Payment added successfully');
                        redirect('backoffice/bsPayments');
                    } else {
                        $this->session->set_flashdata('error_message', 'Unable to add payment.');
                        redirect('backoffice/bsPayments');
                    }
                } else {
                    redirect('backoffice/bsPayments');
                }
            } else {
                $this->session->set_flashdata('error_message', 'Please fill missing fields');
                redirect('backoffice/bsPayments', 'refresh');
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to delete cm payment
     * @author Arunsankar
     * @since 29-June-2016
     */
    function deleteCmPayment() {
        if ($this->session->userdata('username') && $this->session->userdata('role') == 200) {
            $selPay = $this->input->post('selPay');
            if (!empty($selPay)) {
                $isDeleted = $this->mbackoffice->deleteCmPayment($selPay);
                if ($isDeleted) {
                    $this->session->set_flashdata('success_message', 'Payment deleted successfully');
                    echo '1';
                } else {
                    $this->session->set_flashdata('error_message', 'Failed to delete payment');
                    echo '0';
                }
            } else {
                echo '0';
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to check whether the entered ref booking is available
     * @author Arunsankar
     * @since 30-June-2016
     */
    function checkRefBooking() {
        if ($this->session->userdata('username') && $this->session->userdata('role') == 200) {
            $bookRef = $this->input->post('refBook');
            $isValidBooking = $this->mbackoffice->checkRefBooking($bookRef);
            if ($isValidBooking) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to upload pdf file
     * @author Arunsankar
     * @since 27-Oct-2016
     */
    function cmsUploadPdf() {
        if ($this->session->userdata('role') == 300) {
            $this->load->library('upload');

            $campusFileError1 = $campusFileError2 = $campusFileError3 = '';
            $pdf_file_title_1 = $pdf_file_title_2 = $pdf_file_title_3 = '';
            $file_name_1 = $file_name_2 = $file_name_3 = '';

            $campus_id = $this->input->post('pdf_campus_id');

            $pdf_file_title_1 = $this->input->post('pdf_file_title_1');
            $pdf_file_title_2 = $this->input->post('pdf_file_title_2');
            $pdf_file_title_3 = $this->input->post('pdf_file_title_3');

            if (!file_exists(CAMPUS_PDF_PATH)) {
                mkdir(CAMPUS_PDF_PATH, 0755, true);
            }

            if ($_FILES['pdf_file_1']['name']) {
                $file_name = time() . '_' . $this->stripJunk($_FILES['pdf_file_1']['name']);
                $config['upload_path'] = CAMPUS_PDF_PATH;
                $config['allowed_types'] = 'pdf';
                $config['file_name'] = $file_name;
                $this->upload->initialize($config);

                //---- UPLOAD IMAGE ----//
                if ($this->upload->do_upload("pdf_file_1")) {
                    $aUploadData = $this->upload->data();
                    $file_name_1 = $aUploadData['file_name'];
                } else {
                    $campusFileError1 = array('error' => $this->upload->display_errors());
                }
            }

            if ($_FILES['pdf_file_2']['name']) {
                $file_name = time() . '_' . $this->stripJunk($_FILES['pdf_file_2']['name']);
                $config['upload_path'] = CAMPUS_PDF_PATH;
                $config['allowed_types'] = 'pdf';
                $config['file_name'] = $file_name;
                $this->upload->initialize($config);

                //---- UPLOAD IMAGE ----//
                if ($this->upload->do_upload("pdf_file_2")) {
                    $aUploadData = $this->upload->data();
                    $file_name_2 = $aUploadData['file_name'];
                } else {
                    $campusFileError2 = array('error' => $this->upload->display_errors());
                }
            }

            if ($_FILES['pdf_file_3']['name']) {
                $file_name = time() . '_' . $this->stripJunk($_FILES['pdf_file_3']['name']);
                $config['upload_path'] = CAMPUS_PDF_PATH;
                $config['allowed_types'] = 'pdf';
                $config['file_name'] = $file_name;
                $this->upload->initialize($config);

                //---- UPLOAD IMAGE ----//
                if ($this->upload->do_upload("pdf_file_3")) {
                    $aUploadData = $this->upload->data();
                    $file_name_3 = $aUploadData['file_name'];
                } else {
                    $campusFileError3 = array('error' => $this->upload->display_errors());
                }
            }

            if ($campusFileError1 != '')
                $this->session->set_flashdata('error_message', $campusFileError1['error']);
            else if ($campusFileError2 != '')
                $this->session->set_flashdata('error_message', $campusFileError2['error']);
            else if ($campusFileError3 != '')
                $this->session->set_flashdata('error_message', $campusFileError3['error']);
            else {
                // Insert in database
                $insert_data = array(
                    'pdf_title_1' => $pdf_file_title_1,
                    'pdf_path_1' => $file_name_1,
                    'pdf_title_2' => $pdf_file_title_2,
                    'pdf_path_2' => $file_name_2,
                    'pdf_title_3' => $pdf_file_title_3,
                    'pdf_path_3' => $file_name_3
                );
                $cmsInsertCampusPdf = $this->mbackoffice->cmsInsertCampusPdf($campus_id, $insert_data);
                $this->session->set_flashdata('success_message', 'File uploaded successfully');
            }
            redirect('backoffice/cmsManageCampus', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to upload image file
     * @author Arunsankar
     * @since 27-Oct-2016
     */
    function cmsUploadImage() {

        if ($this->session->userdata('role')) {
            authSessionMenu($this);

            $this->load->library('upload');

            $campus_id = $this->input->post('campus_id');
            $title = $this->input->post('campus_image_file_title');
            $category = $this->input->post('campus_image_category');

            if (!file_exists(CAMPUS_IMAGE_PATH)) {
                mkdir(CAMPUS_IMAGE_PATH, 0755, true);
            }
            $file_name = time() . '_' . $this->stripJunk($_FILES['campus_image_file']['name']);
            $config['upload_path'] = CAMPUS_IMAGE_PATH;
            $config['allowed_types'] = 'jpeg|jpg';
            $config['max_size'] = '1000';
            $config['file_name'] = $file_name;
            $this->upload->initialize($config);

            //---- UPLOAD IMAGE ----//
            if ($this->upload->do_upload("campus_image_file")) {
                $aUploadData = $this->upload->data();
                $file_name = $aUploadData['file_name'];
                // Insert in database
                $cmsInsertCampusImage = $this->mbackoffice->cmsInsertCampusImage($campus_id, $title, $category, $file_name);
                $this->session->set_flashdata('success_message', 'File uploaded successfully');
            } else {
                $campusFileError = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error_message', $this->upload->display_errors());
            }
            redirect('backoffice/cmsManageCampus', 'refresh');
        } else {
            echo "in else";die;
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

    function getCampusPdf() {
        if ($this->session->userdata('role') == 300) {
            $campus_id = $this->input->post('campus_id');
            $campus_pdf = $this->mbackoffice->getCampusPdf($campus_id);
            echo json_encode(array('campus_pdf' => $campus_pdf));
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * This function is simillar to other pdf upload but this is added for
     * Agents section
     * Here uploaded files will be listed in Agents login section under marketing material.
     * @author Sandip Kalbhile
     * @since 2017-10-16
     */
    function cmsUploadSinglePdfs() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);

            $this->load->library('upload');

            $campus_id = $this->input->post('single_pdfs_campus_id');
            $title = $this->input->post('campus_pdfs_file_title');

            if (!file_exists(CAMPUS_AGENTS_SINGLE_PDF_PATH)) {
                mkdir(CAMPUS_AGENTS_SINGLE_PDF_PATH, 0755, true);
            }
            $file_name = time() . '_' . $this->stripJunk($_FILES['campus_pdfs_file']['name']);
            $config['upload_path'] = CAMPUS_AGENTS_SINGLE_PDF_PATH;
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = $file_name;
            $this->upload->initialize($config);

            //---- UPLOAD IMAGE ----//
            if ($this->upload->do_upload("campus_pdfs_file")) {
                $aUploadData = $this->upload->data();
                $file_name = $aUploadData['file_name'];
                // Insert in database
                $cmsInsertCampusImage = $this->mbackoffice->cmsInsertCampusSinglePdfs($campus_id, $title, $file_name);
                $this->session->set_flashdata('success_message', 'File uploaded successfully');
            } else {
                $campusFileError = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error_message', $this->upload->display_errors());
            }
            redirect('backoffice/cmsManageCampus', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function getCampusSinglePdfsForAgent() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);

            $campus_id = $this->input->post('campus_id', TRUE);
            $data["campus"] = $this->mbackoffice->getCampusSinglePdfsForAgent($campus_id);
            $view = $this->load->view('lte/backoffice/cmsuser/cms_campus_single_pdfs_for_agent', $data, TRUE);
            echo json_encode(array('campus_single_pdfs_table' => $view));
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function updatepdfsequence($type = 'sequence'){
        $pdf_id = $this->input->post('pdfId');
        $sequence = $this->input->post('sequence');
        $fileTitle = $this->input->post('fileTitle');
        $campus_id = $this->input->post('campus_id');
        if($type == "sequence")
        {
            if(is_numeric($pdf_id) && is_numeric($sequence) && is_numeric($campus_id))
            {
                $updateArr = array(
                    'sequence' => $sequence
                );
                $this->mbackoffice->updatePdfsForAgentSequence($pdf_id,$updateArr,$campus_id);
            }
            else
                $sequence = 0;
        }
        else if($type == "title"){
            if(is_numeric($pdf_id) && !empty($fileTitle))
            {
                $updateArr = array(
                    'title' => $fileTitle
                );
                $this->mbackoffice->updatePdfsForAgentSequence($pdf_id,$updateArr,$campus_id);
                $sequence = 1;
            }
            else
                $sequence = 0;
        }

        echo json_encode(array('result'=>$sequence));
    }

    /**
     * Fuction to delete pdfs of campus
     * @author Arunsankar
     * @since 2-Nov-2016
     */
    function deleteCampusPdfForAgent($campus_pdf_id) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);

            // Unlink file
            $file_path = $this->mbackoffice->getCampusSinglePdfForAgent($campus_pdf_id);
            unlink(CAMPUS_AGENTS_SINGLE_PDF_PATH . $file_path);

            // Delete record from database
            $delete_data = array('campus_single_pdf_id' => $campus_pdf_id);
            $this->mbackoffice->deleteCampusRecord($delete_data, "plused_campus_single_pdf_for_agents");
            $this->session->set_flashdata('success_message', 'PDF deleted successfully');
            redirect('backoffice/cmsManageCampus', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to upload multiple pdf file, but one at a time
     * @author Arunsankar
     * @since 28-Oct-2016
     */
    function cmsUploadSinglePdf() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);

            $this->load->library('upload');

            $campus_id = $this->input->post('single_pdf_campus_id');
            $title = $this->input->post('campus_pdf_file_title');

            if (!file_exists(CAMPUS_SINGLE_PDF_PATH)) {
                mkdir(CAMPUS_SINGLE_PDF_PATH, 0755, true);
            }
            $file_name = time() . '_' . $this->stripJunk($_FILES['campus_pdf_file']['name']);
            $config['upload_path'] = CAMPUS_SINGLE_PDF_PATH;
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = $file_name;
            $this->upload->initialize($config);

            //---- UPLOAD IMAGE ----//
            if ($this->upload->do_upload("campus_pdf_file")) {
                $aUploadData = $this->upload->data();
                $file_name = $aUploadData['file_name'];
                // Insert in database
                $cmsInsertCampusImage = $this->mbackoffice->cmsInsertCampusSinglePdf($campus_id, $title, $file_name);
                $this->session->set_flashdata('success_message', 'File uploaded successfully');
            } else {
                $campusFileError = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error_message', $this->upload->display_errors());
            }
            redirect('backoffice/cmsManageCampus', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to get images of campus
     * @author Arunsankar
     * @since 2-Nov-2016
     */
    function getCampusImage() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);

            $campus_id = $this->input->post('campus_id', TRUE);
            $data["campus"] = $this->mbackoffice->getCampusImages($campus_id);
            $view = $this->load->view('lte/backoffice/cmsuser/cms_campus_images', $data, TRUE);
            echo json_encode(array('campus_image_table' => $view));
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to delete image of campus
     * @author Arunsankar
     * @since 2-Nov-2016
     */
    function deleteCampusImage($campus_image_id) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);

            // Unlink file
            $file_path = $this->mbackoffice->getCampusImage($campus_image_id);
            unlink(CAMPUS_IMAGE_PATH . $file_path);

            // Delete record from database
            $delete_data = array('campus_image_id' => $campus_image_id);
            $this->mbackoffice->deleteCampusRecord($delete_data, "plused_campus_image");
            $this->session->set_flashdata('success_message', 'Image deleted successfully');
            redirect('backoffice/cmsManageCampus', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to get single PDF's of campus
     * @author Arunsankar
     * @since 2-Nov-2016
     */
    function getCampusSinglePdf() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);

            $campus_id = $this->input->post('campus_id', TRUE);
            $data["campus"] = $this->mbackoffice->getCampusSinglePdfs($campus_id);
            $view = $this->load->view('lte/backoffice/cmsuser/cms_campus_single_pdfs', $data, TRUE);
            echo json_encode(array('campus_single_pdf_table' => $view));
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to delete pdfs of campus
     * @author Arunsankar
     * @since 2-Nov-2016
     */
    function deleteCampusPdf($campus_pdf_id) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);

            // Unlink file
            $file_path = $this->mbackoffice->getCampusSinglePdf($campus_pdf_id);
            unlink(CAMPUS_SINGLE_PDF_PATH . $file_path);

            // Delete record from database
            $delete_data = array('campus_single_pdf_id' => $campus_pdf_id);
            $this->mbackoffice->deleteCampusRecord($delete_data, "plused_campus_single_pdf");
            $this->session->set_flashdata('success_message', 'PDF deleted successfully');
            redirect('backoffice/cmsManageCampus', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function getCampusVideo() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $campus_id = $this->input->post('campus_id');
            $campus_video = $this->mbackoffice->getCampusVideo($campus_id);
            echo json_encode(array('campus_video' => $campus_video));
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Fuction to add video url
     * @author Arunsankar
     * @since 13-Jan-2017
     */
    function cmsUploadVideo() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $campus_id = $this->input->post('video_campus_id');
            $campus_video_1 = $this->input->post('campus_video_1');
            $campus_video_2 = $this->input->post('campus_video_2');
            $campus_video_3 = $this->input->post('campus_video_3');
            $campus_video_4 = $this->input->post('campus_video_4');

            // Insert in database
            $insert_data = array(
                'campus_video_1' => $campus_video_1,
                'campus_video_2' => $campus_video_2,
                'campus_video_3' => $campus_video_3,
                'campus_video_4' => $campus_video_4
            );
            $cmsInsertCampusVideo = $this->mbackoffice->cmsInsertCampusVideo($campus_id, $insert_data);

            if ($cmsInsertCampusVideo == "0")
                $this->session->set_flashdata('success_message', 'Video URLs added successfully');
            else if ($cmsInsertCampusVideo > 0)
                $this->session->set_flashdata('success_message', 'Video URLs updated successfully');
            redirect('backoffice/cmsManageCampus', 'refresh');
        }
        else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    function uploadCampusWebImage(){
        if($this->session->userdata('username')){
            if(!empty($_POST['webimage_campus_id'])){
                $campus_id = $this->input->post('webimage_campus_id',true);
                if (!file_exists(CAMPUS_WEBSITE_IMAGE)) {
                    mkdir(CAMPUS_WEBSITE_IMAGE, 0755, true);
                }
                $fileName = "";
                $uploadFileError = array();
                    if ($_FILES['webImage']['name']) {
                        $this->load->library("upload");
                        $file_name = time() . '_' . $this->stripJunk($_FILES['webImage']['name']);
                        $config['upload_path'] = CAMPUS_WEBSITE_IMAGE;
                        $config['allowed_types'] = 'jpg|jpeg';
                        $config['file_name'] = $file_name;
                        $this->upload->initialize($config);
                        //---- UPLOAD IMAGE ----//
                        if ($this->upload->do_upload("webImage")) {
                            $aUploadData = $this->upload->data();
                            $fileName = $aUploadData['file_name'];
                        } else {
                            $uploadFileError = array('error' => $this->upload->display_errors());
                        }
                    }
                    if(!array_key_exists('error', $uploadFileError)){
                        if($campus_id && !empty($fileName)){
                            $result = $this->mbackoffice->updateCampusImage($campus_id,$fileName);
                            if($result){
                                $oldImage = $this->input->post("webimage_old_file");
                                if(!empty($oldImage))
                                {
                                    @unlink(CAMPUS_WEBSITE_IMAGE . $oldImage);
                                    $thumbnailImage = getThumbnailName($oldImage);
                                    if(!empty($thumbnailImage))
                                        @unlink(CAMPUS_WEBSITE_IMAGE . $thumbnailImage);
                                }
                                
                                $this->session->set_flashdata('success_message','Image uploaded successfully.');
                                if(!empty($fileName))
                                {
                                    $this->webCropInit($fileName);
                                    $this->cropping->image();
                                }
                                else
                                    redirect('backoffice/cmsManageCampus');
                            }
                            else{
                                $this->session->set_flashdata('error_message','Unable to upload image.');
                            }
                        }
                    }
            }
        }
    }
    
    /**
     * Process
     * This function is required to hold cropping form action
     * @param type $action 
     */
    public function webprocess($action = "") 
    {
        $this->webCropInit();
        $this->cropping->process($action);
    }

    /**
     * cropInit
     * This function initialise the cropping library with 
     * configuration parameters
     * @param type $file_name 
     */
    public function webCropInit($file_name = "")
    {
        $param = array();
        if(empty($file_name))
        {
            $param = $this->session->userdata("cropData");
        }
        else{
            $param = array(
                'imageAbsPath' =>  FCPATH . CAMPUS_WEBSITE_IMAGE,
                'imageDestPath' =>  FCPATH . CAMPUS_WEBSITE_IMAGE,
                'imageName' => $file_name,
                'imageNewName' => $file_name,
                'imagePath' =>  base_url() . CAMPUS_WEBSITE_IMAGE,
                'imageWidth' => CAMPUS_WEBSITE_WIDTH,
                'imageHeight' => CAMPUS_WEBSITE_HEIGHT,
                'thumbWidth' => CAMPUS_WEBSITE_THUMB_WIDTH,
                'thumbHeight' => CAMPUS_WEBSITE_THUMB_HEIGHT,
                'redirectTo' => 'backoffice/cmsManageCampus',
                'formCallbackAction' => 'backoffice/webprocess'
            );
            $this->session->set_userdata("cropData",$param);
        }
        $this->load->library("cropping", $param);
    }

    /**
     * Fuction to update booking date
     * @author Arunsankar
     * @since 22-Feb-2017
     */
    function editBookingDate() {
        if ($this->session->userdata('role') == 100) {
            $date_in = $this->input->post('date_in');
            $date_out = $this->input->post('date_out');
            $booking_id = $this->input->post('booking_id');

            $updateResult = $this->mbackoffice->editBookingDate($date_in, $date_out, $booking_id);
            echo '1';
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function csvActiveBookingDate($date) {
        if (empty($date)) {
            exit('<h3>Please provide date</h3>');
        }
        if ($this->session->userdata('role') == 553) {
            $campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
            $bookings = $this->mbackoffice->getActiveBookingsForBursars($campus, $date);
            if (empty($bookings)) {
                exit('<h3>No Bookings Available</h3>');
            }
            $testariga[0] = array();
            $testariga[0] = array(
                "bookid" => "Booking ID",
                "arrival_date" => "Date In",
                "departure_date" => "Date Out",
                "centro" => "Campus",
                "pax_totali" => "Pax"
            );

            $xlsArray = array();
            foreach ($bookings as $key => $book) {
                $xlsArray[$key]['booking_id'] = $book['id_year'] . '_' . $book['id_book'];
                $xlsArray[$key]['date_in'] = $book['arrival_date'];
                $xlsArray[$key]['date_out'] = $book['departure_date'];
                $xlsArray[$key]['date_out'] = $book['departure_date'];
                $xlsArray[$key]['centro'] = $book['centro'];
                $xlsArray[$key]['pax_total'] = $book['pax_totali'];
            }
            array_unshift($xlsArray, $testariga[0]);
            $this->load->library('excel_180');
            $this->excel_180->getActiveSheet()->fromArray($xlsArray, NULL, 'A1');
            $this->excel_180->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
            $filename = 'export_' . $date . '.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
            $objWriter->save('php://output');

            die();
        } else {
            redirect('backoffice', 'refresh');
        }
    }

}

//End : additions by Arunsankar S
/* End of file backoffice.php */
