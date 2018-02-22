<?php

/**
 * Description of Vauth
 * This is the controller which will handle the general requests of login/logout/forgot password
 * @author Sandip.Kalbhile
 * @since 05-Aug-2016
 */
class Vauth extends Controller {

    public function __construct() {
        parent::Controller();
        $this->load->helper(array('form', 'url', 'mpdf6'));
        $this->load->library('session', 'email', 'excel');
    }

    function index() {
        $this->students();
    }

    function profile() {
        $userRole = $this->session->userdata('role');

        switch ($userRole) {
            case 501: // Group leaders
                redirect('survey/profile', 'refresh');
                break;
            case 502: // Students test
                redirect('students/profile', 'refresh');
                break;
            case 500: // Students test
                redirect('users/profile', 'refresh');
                break;
            case 99: // Agent
            case 98: // 
            case 97: // 
                redirect('agents/changeCredential', 'refresh');
                break;
            default: // Backoffice operator
                redirect('backoffice/profile', 'refresh');
                break;
        }
    }

    /**
     * logout 
     * this function is used to destroy students session. 
     */
    function logout() {
        $userRole = $this->session->userdata('role');
        $this->session->sess_destroy();
        handleRoleRedirection($userRole);
    }

    /**
     * This is backoffice operator area to load login/dashboard for backoffice operator.  
     */
    function backoffice() {
        if (!$this->session->userdata('role')) {
            $data = array();
            $data['title'] = "plus-ed.com | Log in";
            $data['pageHeader'] = "Log in";
            $this->load->view('login/backoffice', $data);
        } else {
            redirect('backoffice/dashboard', 'refresh');
        }
    }

    /**
     * This is students area to load login/dashboard for students.  
     */
    function students() {
        //echo $this->session->userdata('role');die;
        if ($this->session->userdata('role') == 502) {
            redirect('students/dashboard', 'refresh');
        } else {
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            $data = array();
            $data['title'] = "plus-ed.com | Log in";
            $data['pageHeader'] = "Log in";
            $data['page_action'] = "studentspost";
            $this->load->view('login/students', $data);
        }
    }

    /**
     * This is students area to load login/dashboard for students.  
     */
    function users() {
        if ($this->session->userdata('role') == 500) {
            redirect('users/dashboard', 'refresh');
        } else {
            $this->load->helper('string');
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            $data['title'] = "plus-ed.com | Login";
            $this->load->view('login/users', $data);
        }
    }

    /**
     * login 
     * this function uses email address and students password to check/authenticate user 
     * if user is authenticated basic information is save into the session and user gets loggedin. 
     */
    function studentspost() {
        if (!empty($_POST)) {
            $this->load->model('tuition/studentsmodel', 'studentsmodel');
            if ($this->session->userdata('role') != 502) {
                @session_start();
                $userFirstName = $this->input->post('login_name');
                $userSurname = $this->input->post('login_surname');
                $dobDay = $this->input->post('selDay');
                $dobMonth = $this->input->post('selMonth');
                $dobYear = $this->input->post('selYear');
                $userDOB = $dobDay . '/' . $dobMonth . '/' . $dobYear;
                if (isItValidDate($userDOB, 'd/m/Y')) {
                    $userDOB = explode('/', $userDOB);
                    if (array_key_exists(2, $userDOB)) {
                        $userDOB = $userDOB[2] . '-' . $userDOB[1] . '-' . $userDOB[0];
                    }
                    $userData = $this->studentsmodel->verifySTDUser($userFirstName, $userSurname, $userDOB);
                    if ($userData) {
                        $newdata = array(
                            'username' => "--",
                            'uuid' => $userData->uuid,
                            'pax_dob' => $userData->pax_dob,
                            'mainfirstname' => $userData->nome,
                            'mainfamilyname' => $userData->cognome,
                            'businessname' => $userData->nome,
                            'id' => $userData->id_prenotazione,
                            'email' => '',
                            'country' => '',
                            'role' => 502, //502 = Pax users STD(STUDENTS FOR TEST/SURVEY)
                            'ruolo' => "Student",
                            'logged_in' => TRUE
                        );
                        $this->session->set_userdata($newdata);
                        redirect('students/dashboard', 'refresh');
                    } else {
                        $this->session->set_flashdata('error_message', '<strong>Error!</strong> Invalid credentials.');
                        redirect('vauth/students', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error_message', '<strong>Error!</strong> Invalid credentials.');
                    redirect('vauth/students', 'refresh');
                }
            } else
                redirect('vauth/students', 'refresh');
        } else
            redirect('vauth/students', 'refresh');
    }

    /**
     * This is group leader area to load login/dashboard for group leader.  
     */
    function gl() {
        if ($this->session->userdata('role') == 501) {
            redirect('survey/dashboard', 'refresh');
        } else {
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            $data = array();
            $data['title'] = "plus-ed.com | Log in";
            $data['pageHeader'] = "Log in";
            $data['page_action'] = "glpost";
            $this->load->view('login/students', $data);
        }
    }

    /**
     * glpost 
     * this function uses email address and survey password to check/authenticate user 
     * if user is authenticated basic information is save into the session and user gets loggedin. 
     */
    function glpost() {
        if (!empty($_POST)) {
            $this->load->model('tuition/surveymodel', 'surveymodel');
            if ($this->session->userdata('role') != 501) {
                @session_start();
                $userFirstName = $this->input->post('login_name');
                $userSurname = $this->input->post('login_surname');
                $bookingId = $this->input->post('booking_id');
                $dobDay = $this->input->post('selDay');
                $dobMonth = $this->input->post('selMonth');
                $dobYear = $this->input->post('selYear');
                $userDOB = $dobDay . '/' . $dobMonth . '/' . $dobYear;
                if (isItValidDate($userDOB, 'd/m/Y')) {
                    $userDOB = explode('/', $userDOB);
                    if (array_key_exists(2, $userDOB)) {
                        $userDOB = $userDOB[2] . '-' . $userDOB[1] . '-' . $userDOB[0];
                    }
                    $userData = $this->surveymodel->verifyGLUser($userFirstName, $userSurname, $userDOB, $bookingId);
                    if ($userData) {
                        $newdata = array(
                            'username' => "--",
                            'uuid' => $userData->uuid,
                            'pax_dob' => $userData->pax_dob,
                            'mainfirstname' => $userData->nome,
                            'mainfamilyname' => $userData->cognome,
                            'businessname' => $userData->nome,
                            'id' => $userData->id_prenotazione,
                            'email' => '',
                            'country' => '',
                            'role' => 501, //501 = Pax users GL(Group Leader)
                            'ruolo' => "Group Leader",
                            'logged_in' => TRUE
                        );
                        $this->session->set_userdata($newdata);
                        redirect('survey/dashboard', 'refresh');
                    } else {
                        $this->session->set_flashdata('error_message', '<strong>Error!</strong> Invalid credentials.');
                        redirect('vauth/gl', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error_message', '<strong>Error!</strong> Invalid credentials.');
                    redirect('vauth/gl', 'refresh');
                }
            } else
                redirect('vauth/gl', 'refresh');
        } else
            redirect('vauth/gl', 'refresh');
    }

    /* Start: Functions by Arunsankar */

    /**
     * Function for backoffice login
     * @author Arunsanakr
     * @since 18-Aug-2016
     */
    function backofficepost() {
        $this->load->model('mbackoffice');
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
            $roleDescription = $data['results'][0]['role'];
            $role = $isAdmin = 0;
            $roleFound = FALSE;
            switch ($roleDescription) {
                case 'college_adm':
                    $role = 200; //campus manager
                    break;
                case 'utente_cms':
                    $role = 300; //utente cms
                    break;
                case 'course_director':
                    $role = 400; //course director
                    break;
                case 'webservice_user':
                    $role = 550; //webservice user
                    break;
                case 'reimbursement':
                    $role = 551; //webservice user
                    break;
                case 'superuser':
                case 'contabile':
                    $role = 100; //superuser
                    break;
                case 'operatore':
                    $role = 100; //backoffice operator
                    break;
                case 'sales_back_office': // NEW ROLES: 2017-10-23
                    $role = 911;
                    break;
                case 'operation_back_office':
                    $role = 912;
                    break;
                case 'tuition_back_office':
                    $role = 913;
                    break;
                case 'accounts_back_office': 
                    $role = 914;
                    break;
                case 'campus_back_office':
                    $role = 915;
                    break;
                case 'sales_manager':
                    $role = 901;
                    break;
                case 'operation_manager':
                    $role = 902;
                    break;
                case 'tuition_manager':
                    $role = 903;
                    break;
                case 'accounts_manager':
                    $role = 904;
                    break;
                case 'campus_life_manager':
                    $role = 905; //backoffice operator
                    break;
                case 'bursars':
                    $role = 553; //campus manager
                    break;
               /* case 'sales_back_office':
                    $role = 553; //campus manager
                    break;*/
                default:
                    $role = 0;
            }
            /*$roleManager = array(
                'college_adm' => '200',
                'utente_cms' => '300',
                'course_director' => '400',
                'webservice_user' => '550',
                'reimbursement' => '551',
                'superuser' => '100',
                'contabile' => '100',
                'operatore' => '100',
                'sales_back_office' => '911',
                'operation_back_office' => '912',
                'tuition_back_office' => '913',
                'accounts_back_office' => '914',
                'campus_back_office' => '915',
                'sales_manager' => '901',
                'operation_manager' => '902',
                'tuition_manager' => '903',
                'accounts_manager' => '904',
                'campus_life_manager' => '905',
                'bursars' => '553'
            );
            if(isset($roleManager[$roleDescription]))
                $role = $roleManager[$roleDescription];
            else
                $role = 0;*/
            
            if ($role) {
                $newdata = array(
                    'username' => $data['results'][0]['username'],
                    'mainfirstname' => $data['results'][0]['first_name'],
                    'mainfamilyname' => $data['results'][0]['last_name'],
                    'businessname' => $data['results'][0]['first_name'],
                    'id' => $data['results'][0]['id'],
                    'email' => $data['results'][0]['email'],
                    'country' => "-",
                    'role' => $role,
                    'ruolo' => $roleDescription,
                    'sess_campus_id' => $data['results'][0]['campusid_ref'],
                    'logged_in' => TRUE
                );
                if ($data['results'][0]['role'] == "superuser") {
                    $isAdmin = 1;
                }
                $newdata['is_admin'] = $isAdmin;
                $this->session->set_userdata($newdata);
                $this->load->vars($data);


                // If user role is webservice_user, redirect it to separate controller
                if ($data['results'][0]['role'] == "webservice_user") {
                    redirect('webservice/index', 'refresh');
                } elseif ($data['results'][0]['role'] == "reimbursement") {
                    redirect('webservice/index', 'refresh');
                }
                if ($isAdmin == 1) {
                    // REMOVED AS ADDED CRON FOR ELAPESED BOOKING
                    //redirect('backoffice/elapsedBookingsToElapse', 'refresh');
                    redirect('backoffice/dashboard', 'refresh');
                } else {
                    redirect('backoffice/dashboard', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', 'Invalid credentials.');
                redirect('vauth/backoffice', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error_message', 'Invalid credentials.');
            redirect('vauth/backoffice', 'refresh');
        }
    }

    /**
     * forgotpassword
     * used to generated password and send it to the relative user.
     */
    public function forgotpassword($called_from = "") {
        $this->load->model('mbackoffice');
        header('Expires: 0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        if (!$this->session->userdata('role')) {
            if (!empty($_POST)) {
                $userName = $this->input->post('txtUsername');
                if (!empty($userName)) {
                    if ($called_from == "agents") {
                        $this->load->model('magenti');
                        $applicantData = $this->magenti->getAgentForMatch($userName);
                    } else {
                        $matchData = array('username' => $userName);
                        $applicantData = $this->mbackoffice->getMemberForMatch($matchData);
                    }
                    if ($applicantData) {
                        $senderEmail = PLUS_SENDER_EMAIL_ADDRESS;

                        $messageBody = "";

                        if ($called_from == "agents") {
                            if ($applicantData[0]['ruolo'] == 'agente') {
                                $data['operatorName'] = $applicantData[0]['mainfirstname'] . " " . $applicantData[0]['mainfamilyname'];
                                $data['operatorEmail'] = $receiverEmail = $applicantData[0]['email'];
                            } else {
                                $data['operatorName'] = $applicantData[0]['firstname'] . " " . $applicantData[0]['familyname'];
                                $data['operatorEmail'] = $receiverEmail = $applicantData[0]['email'];
                            }
                        } else {
                            $data['operatorName'] = $applicantData->first_name . " " . $applicantData->last_name;
                            $data['operatorEmail'] = $applicantData->email;
                            $receiverEmail = $applicantData->email;
                        }

                        $data['called_from'] = $called_from;
                        $data['operatorUsername'] = $userName;
                        $randomPassword = random_string();
                        $data['randomPassword'] = $randomPassword;
                        ob_start(); // start output buffer
                        //$this -> load -> view('tuition/email/forgot_password_backoffice_user_template', $data);
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
                        //$sendRes = true;
                        if ($sendRes) {
                            // store users password in application table
                            $updateArr = array(
                                'password' => ($randomPassword)
                            );
                            if ($called_from == "agents")
                                $this->magenti->updateAgentData($randomPassword, $applicantData[0]['id'], $applicantData[0]['ruolo']);
                            else
                                $this->mbackoffice->updateMemberData($updateArr, $applicantData->id);
                            // end of update
                            $this->session->set_flashdata('success_message', 'New password sent to email. Please check');

                            if ($called_from == "agents")
                                redirect('vauth/forgotpassword/agents', 'refresh');
                            else
                                redirect('vauth/forgotpassword', 'refresh');
                        }
                    }
                    else {
                        $this->session->set_flashdata('error_message', 'The username does not exist!');
                        if ($called_from == "agents")
                            redirect('vauth/forgotpassword/agents', 'refresh');
                        else
                            redirect('vauth/forgotpassword', 'refresh');
                    }
                }
            }

            $data['called_from'] = $called_from;
            $data['title'] = "plus-ed.com | Forgot password";
            $this->load->view('login/forgot_password', $data);
        }
        else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * forgotpassword
     * used to generated password and send it to the relative user.
     */
    public function userforgotpassword() {
        $this->load->model('tuition/usersmodel', 'usersmodel');
        $this->load->model('tuition/teachersappmodel', 'teachersappmodel');
        if (!$this->session->userdata('role')) {

            if (!empty($_POST)) {
                $emailAddress = $this->input->post('txtEmailAddress');
                if (!empty($emailAddress)) {
                    $matchData = array('ta_email' => $emailAddress);
                    $applicantData = $this->usersmodel->getUsersForMatch($matchData);
                    if ($applicantData) {
                        $senderEmail = PLUS_SENDER_EMAIL_ADDRESS;
                        $receiverEmail = $emailAddress;
                        $messageBody = "";
                        $data['teacherName'] = $applicantData->ta_firstname . " " . $applicantData->ta_lastname;
                        $data['teacherEmail'] = $emailAddress;
                        $randomPassword = random_string();
                        $data['randomPassword'] = $randomPassword;
                        ob_start(); // start output buffer
                        $this->load->view('tuition/email/forgot_password_email_template', $data);
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
                                'ta_password' => md5($randomPassword)
                            );
                            $this->teachersappmodel->operations('update', $updateArr, $applicantData->ta_id);
                            // end of update
                            $this->session->set_flashdata('forgot_pass_msg', 'success');

                            redirect('vauth/userforgotpassword', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('forgot_pass_msg', 'notexist');
                        redirect('vauth/userforgotpassword', 'refresh');
                    }
                }
            }
            $data['title'] = "plus-ed.com | Forgot password";
            $this->load->view('login/user_forgot_password', $data);
        } else {
            redirect('users', 'refresh');
        }
    }

    function userpost() {
        $this->load->model('tuition/usersmodel', 'usersmodel');
        if (!empty($_POST)) {
            if ($this->session->userdata('role') != 500) {
                @session_start();
                $emailAddress = $this->input->post('login_name');
                $pwd = $this->input->post('login_pw');
                $userData = $this->usersmodel->verifyUser($emailAddress, $pwd);
                if ($userData) {
                    $newdata = array(
                        'username' => "--",
                        'mainfirstname' => $userData->ta_firstname,
                        'mainfamilyname' => $userData->ta_lastname,
                        'businessname' => $userData->ta_firstname,
                        'id' => $userData->ta_id,
                        'email' => $userData->ta_email,
                        'country' => $userData->ta_country,
                        'role' => 500, //500 = Teacher
                        'ruolo' => "Teacher",
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($newdata);
                    redirect('users/dashboard', 'refresh');
                } else {
                    $this->session->set_flashdata('login_failed', 1);
                    redirect('vauth/users', 'refresh');
                }
            } else {
                redirect('vauth/users', 'refresh');
            }
        } else {
            redirect('vauth/users', 'refresh');
        }
    }

    /* End: Functions by Arunsankar */

    /**
     * This is agents login area to load login/dashboard for agents.  
     */
    function agents() {
        if (!$this->session->userdata('role')) {
            $data = array();
            $data['title'] = "plus-ed.com | Log in";
            $data['pageHeader'] = "Log in";
            $this->load->view('login/agents', $data);
        } else {
            redirect('agents/dashboard', 'refresh');
        }
    }

    function agentspost() {
        session_start();
        $this->load->model('magenti');
        $data['heading'] = "Check login...";
        $user = $this->input->post('login_name');
        $pwd = $this->input->post('login_pw');
        $data['results'] = $this->magenti->verifyuser($user, $pwd);
        if ($data['results']) {
            $data['attivi'] = false;
            $data['title'] = "plus-ed.com | Dashboard";
            if ($data['results'][0]['ruolo'] == 'agente') {
                $newdata = array(
                    'username' => $data['results'][0]['login'],
                    'mainfirstname' => $data['results'][0]['mainfirstname'],
                    'mainfamilyname' => $data['results'][0]['mainfamilyname'],
                    'businessname' => $data['results'][0]['businessname'],
                    'id' => $data['results'][0]['id'],
                    'email' => $data['results'][0]['email'],
                    'country' => $data['results'][0]['businesscountry'],
                    'role' => 99, //99 = agente, 98 = account manager
                    'ruolo' => "Agent",
                    'logged_in' => TRUE
                );
            } else {
                if ($data['results'][0]['ruolo'] == 'mediaViewer') {
                    $newdata = array(
                        'username' => $data['results'][0]['email'],
                        'mainfirstname' => $data['results'][0]['firstname'],
                        'mainfamilyname' => $data['results'][0]['familyname'],
                        'businessname' => $data['results'][0]['familyname'] . " " . $data['results'][0]['firstname'],
                        'id' => $data['results'][0]['id'],
                        'email' => $data['results'][0]['email'],
                        'country' => "",
                        'role' => 97, //97=mediaViewer, 99 = agente, 98 = account manager
                        'ruolo' => "Media viewer",
                        'logged_in' => TRUE
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
                        'ruolo' => "Account manager",
                        'logged_in' => TRUE
                    );
                }
            }
            $this->session->set_userdata($newdata);
            $this->load->vars($data);
            if ($data['results'][0]['ruolo'] == 'mediaViewer') {
                redirect('agents/imageGallery', 'refresh');
            } else {
                redirect('agents/dashboard', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error_message', 'Invalid username or password.');
            redirect('vauth/agents', 'refresh');
        }
    }

    public function login() {
        $data['title'] = 'plus-ed.com | Students and Group leaders';
        $this->load->view('lte/students/landing', $data);
    }

    public function getBookingForGl() {
        $this->load->model('tuition/surveymodel', 'surveymodel');
        $name = $this->input->post('name');
        $surname = $this->input->post('surname');
        $dobDay = $this->input->post('day');
        $dobMonth = $this->input->post('month');
        $dobYear = $this->input->post('year');
        $userDOB = $dobDay . '/' . $dobMonth . '/' . $dobYear;
        if (isItValidDate($userDOB, 'd/m/Y')) {
            $userDOB = explode('/', $userDOB);
            if (array_key_exists(2, $userDOB)) {
                $userDOB = $userDOB[2] . '-' . $userDOB[1] . '-' . $userDOB[0];
            }
            $bookings = $this->surveymodel->getBookingsForLogin($name, $surname, $userDOB);
            echo json_encode(array('success' => true, 'bookings' => $bookings));
            exit(0);
        }
        echo json_encode(array('error' => true, 'message' => 'Booking not available'));
        exit(0);
    }

}
