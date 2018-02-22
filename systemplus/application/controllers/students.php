<?php

/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 18-July-2016
 * @Modified    : 
 * @Description : sudents used to authenticate pulsed_row user pax with type STD
 */
class Students extends Controller {

    public function __construct() {

        parent::Controller();
        // check user session and menus with their access.
        authSessionMenu($this);
        $this->load->helper(array('form', 'url', 'mpdf6'));
        $this->load->library(array('session', 'email', 'ltelayout'));
        $this->load->model('tuition/studentsmodel', 'studentsmodel');
        $this->load->model('tuition/campuscoursemodel', 'campuscoursemodel');
    }

    /**
     * students section landing page dashboard/login 
     */
    function index() {
        if ($this->session->userdata('role') == 502) {
            redirect('students/dashboard', 'refresh');
        } else {
            redirect('vauth/students'); // GO TO AUTH controller - NEW LOGIN...
            exit(0);
            $this->load->helper('string');
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            $data['title'] = "plus-ed.com | Login";
            $this->load->view('tuition/plused_students_login', $data);
        }
    }

    /**
     * login 
     * this function uses email address and students password to check/authenticate user 
     * if user is authenticated basic information is save into the session and user gets loggedin. 
     */
    function login() {
        if (!empty($_POST)) {
            if ($this->session->userdata('role') != 502) {
                @session_start();
                $userFirstName = $this->input->post('login_name');
                $userSurname = $this->input->post('login_surname');
                $dobDay = $this->input->post('selDay');
                $dobMonth = $this->input->post('selMonth');
                $dobYear = $this->input->post('selYear');
                $userDOB = $dobDay . '/' . $dobMonth . '/' . $dobYear;
                if (isItValidDate($userDOB)) {
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
                            'ruolo' => "Students",
                            'logged_in' => TRUE
                        );
                        $this->session->set_userdata($newdata);
                        redirect('students/dashboard', 'refresh');
                    } else {
                        $this->session->set_flashdata('login_failed', 1);
                        redirect('students', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('login_failed', 1);
                    redirect('students', 'refresh');
                }
            } else
                redirect('students', 'refresh');
        } else
            redirect('students', 'refresh');
    }

    /**
     * dashboard
     * this function loads students dashboard. 
     */
    function dashboard() {
        if ($this->session->userdata('role') == 502) {
            $data['title'] = "plus-ed.com | Dashboard";
            $data['breadcrumb1'] = 'Dashboard';
            $data['breadcrumb2'] = '';
            if (APP_THEME == "OLD")
                $this->load->view('tuition/plused_students_dashboard', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = "Plus Vision Dashboard";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/students/dashboard', $data);
            }
        } else {
            redirect('students', 'refresh');
        }
    }

    /**
     * logout 
     * this function is used to destroy students session. 
     */
    function logout() {
        $this->session->sess_destroy();
        redirect('students', 'refresh');
    }

    /**
     * profile
     * this function is used to show users self profile details.
     */
    function profile() {
        if ($this->session->userdata('role') == 502) {
            $data['title'] = "plus-ed.com | Profile";
            $data['breadcrumb1'] = 'Profile';
            $data['breadcrumb2'] = '';
            $userId = $this->session->userdata('id');
            $data['userId'] = $userId;

            if (APP_THEME == "OLD")
                $this->load->view('tuition/plused_students_profile', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = "Profile";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/students/profile', $data);
            }
        } else {
            redirect('users', 'refresh');
        }
    }

    /**
     * This functions load students english test 
     */
    function englishtest() {
        if ($this->session->userdata('role') == 502) {
            $data['title'] = "plus-ed.com | Test: Grammar and vocabulary";
            $data['breadcrumb1'] = 'Test / Survey';
            $data['breadcrumb2'] = 'Grammar and vocabulary';
            $data['testName'] = "";
            $data['testId'] = "";
            $id = $this->session->userdata('id');
            $userData = $this->studentsmodel->getUserdata($id);
            $userUUID = $this->session->userdata('uuid');
            if ($userData) {
                $data['userData'] = $userData;
                $data['userId'] = $id;
                $testId = 2; // THIS IS STATIC ID FOR : ENGLISH GRAMMAR TEST
                $checkAlreadySubmitted = $this->studentsmodel->checkAlreadySubmited($testId, $userUUID);
                $checkCDUserMarks = $this->studentsmodel->checkCDUserEnteredMarks($userUUID);
                $data['testAlreadySubmitted'] = $checkAlreadySubmitted;
                $data['checkCDUserMarks'] = $checkCDUserMarks;
                $testQuestionData = $this->studentsmodel->getTestQuestions($testId, $userUUID);
                $data['testQuestionData'] = $testQuestionData;
                if ($data['testQuestionData']) {
                    $data['testName'] = $data['testQuestionData'][0]['test_title'];
                    $data['testId'] = $data['testQuestionData'][0]['test_id'];
                }

                if (APP_THEME == "OLD")
                    $this->load->view('tuition/plused_students_test', $data);
                else { // if(APP_THEME == "LTE")
                    $data['pageHeader'] = "Grammar and vocabulary";
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/students/english_test', $data);
                }
            } else
                redirect('students', 'refresh');
        } else {
            redirect('students', 'refresh');
        }
    }

    /**
     * used to log the students answer given agains test question 
     */
    function logquesanswer() {
        $questionId = $this->input->post('quesId');
        $optionId = $this->input->post('myVal');
        $userUUID = $this->session->userdata('uuid');
        if (!empty($userUUID)) {
            if (!empty($questionId) && !empty($optionId)) {
                $result = $this->studentsmodel->updateQuestionAnswer($questionId, $optionId, $userUUID);
                if ($result) {
                    echo json_encode(array('result' => 1, "message" => ""));
                } else {
                    echo json_encode(array('result' => 0, "message" => "Unable to save answer."));
                }
            }
        } else {
            echo json_encode(array('result' => 0, "message" => "User session expired."));
        }
    }

    /**
     * used to submit students test 
     */
    function submittest() {
        $testId = $this->input->post('testId');
        $testSubmittedDate = date("Y-m-d H:i:s");
        $userUUID = $this->session->userdata('uuid');
        if (!empty($userUUID)) {
            if (!empty($testId)) {
                $result = $this->studentsmodel->submitTest($testId, $userUUID, $testSubmittedDate);
                if ($result > 0) {
                    // Add total test score in course director language knowledge section.
                    $this->studentsmodel->addTestScore($testId, $userUUID);
                    echo json_encode(array('result' => 1, "message" => "Test has been submitted successfully."));
                } elseif ($result == -1) {
                    echo json_encode(array('result' => 0, "message" => "You have already submitted this test."));
                } else {
                    echo json_encode(array('result' => 0, "message" => "Unable to submit test."));
                }
            } else
                echo json_encode(array('result' => 0, "message" => "Unable to submit test."));
        } else {
            echo json_encode(array('result' => 0, "message" => "User session expired."));
        }
    }

    /**
     * This function can be used to insert test question and option 
     * into the database 
     * it will provoid a raw form to enter one question at time
     *  'tque_test_id' => 2, please change test id here in below code.
     */
    function _temp() {
        $this->load->helper('form');
        echo form_open('students/temp');
        echo "<style>input{ width:450px;display:block;}</style>";
        echo "<input type='text' name='question' value='' />";
        echo "<input type='text' name='option1' value='' />";
        echo "<input type='text' name='option2' value='' />";
        echo "<input type='text' name='option3' value='' />";
        echo "<input type='text' name='option4' value='' />";
        echo "<input type='submit' name='submit' value='Submit' />";
        echo form_close();

        if (!empty($_POST)) {
            $question = $this->input->post('question');
            $option1 = $this->input->post('option1');
            $option2 = $this->input->post('option2');
            $option3 = $this->input->post('option3');
            $option4 = $this->input->post('option4');
            $insertQues = array(
                'tque_test_id' => 2,
                'tque_question' => $question
            );
            $this->db->insert('plused_test_question', $insertQues);
            $questId = $this->db->insert_id();
            if ($questId) {
                $insertOpt = array(
                    'opt_que_id' => $questId,
                    'opt_text' => $option1
                );
                $this->db->insert('plused_test_options', $insertOpt);
                $insertOpt = array(
                    'opt_que_id' => $questId,
                    'opt_text' => $option2
                );
                $this->db->insert('plused_test_options', $insertOpt);
                $insertOpt = array(
                    'opt_que_id' => $questId,
                    'opt_text' => $option3
                );
                $this->db->insert('plused_test_options', $insertOpt);
                $insertOpt = array(
                    'opt_que_id' => $questId,
                    'opt_text' => $option4
                );
                $this->db->insert('plused_test_options', $insertOpt);
            }
            redirect('students/temp');
        }
    }

}

/* End of file survey.php */
