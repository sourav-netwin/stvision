<?php

class Enrol extends Controller {

    public function __construct() {

        parent::Controller();

        $this->load->helper(array('form', 'url'));
        $this->load->model('magenti');
        $this->load->model('gestione_centri_model');
        $this->load->model('enrol_model');
        $this->load->library('session', 'email');
    }

    public function booking() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200 && $this->session->userdata('username') == 'a.sudetti@gmail.com') {
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
            } else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/agents/enrol_new', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    public function insertGroup() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200 && $this->session->userdata('username') == 'a.sudetti@gmail.com') {
            if (!$this->validateEnrolBooking()) {
                redirect('enrol/booking');
            } 
            $aDate = $this->input->post('arrival_date');
            $dDate = $this->input->post('departure_date');
            $weeks = $this->getBookingWeeks($aDate, $dDate);
            $data['user'] = $this->session->userdata('username');
            $data['mail'] = $this->session->userdata('email');
            $data['id'] = $this->session->userdata('id');
            $data['name'] = $this->session->userdata('mainfirstname');
            $data['surname'] = $this->session->userdata('mainfamilyname');
            $data['business'] = $this->session->userdata('businessname');
            $login = $data['user'];
            $email = $data['mail'];
            $last_book = $this->enrol_model->insertBook($weeks);
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
            $this->session->set_flashdata('success_message', 'Booking enrollment success');
            redirect('enrol/booking', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    private function validateEnrolBooking() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('prod_select', 'Product', 'required');
        $this->form_validation->set_rules('center_select', 'Center', 'required');
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
                if (!$this->isValidBookingDates($aDate, $dDate)) {
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
        if (!$this->isValidBookingDates($aDate, $dDate)) {
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

    private function getBookingWeeks($arrivalDate, $departureDate) {
        $nights = $this->getTotalBookingNights($arrivalDate, $departureDate);
        if ($nights >= 7 && $nights <= 11) {
            return 1;
        } elseif ($nights >= 12 && $nights <= 18) {
            return 2;
        } elseif ($nights >= 19 && $nights <= 25) {
            return 3;
        }
    }

    private function getTotalBookingNights($arrivalDate, $departureDate) {
        $date1 = strtotime($arrivalDate);
        $date2 = strtotime($departureDate);
        $datediff = $date2 - $date1;
        return floor($datediff / (60 * 60 * 24));
    }

    private function setValidBookingDates($date) {
        $arr2 = explode("/", $date);
        return $arr2[1] . "/" . $arr2[0] . "/" . $arr2[2];
    }

    public function isValidBookingDates($arrivalDate, $departureDate) {
        $nights = $this->getTotalBookingNights($arrivalDate, $departureDate);
        return ($nights >= 7 && $nights <= 25);
    }

    public function dateValid($date) {
        $month = (int) substr($date, 0, 2);
        $day = (int) substr($date, 3, 2);
        $year = (int) substr($date, 6, 4);
        return checkdate($month, $day, $year);
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
                $(".accocentro").each(function (index) {
                    if ($(this).text() == "Ensuite") {
                        $("#row_st_en").show();
                        $("#row_gl_en").show();
                    }
                    if ($(this).text() == "Standard") {
                        $("#row_st_st").show();
                        $("#row_gl_st").show();
                    }
                    if ($(this).text() == "Homestay") {
                        $("#row_st_ho").show();
                        $("#row_gl_ho").show();
                    }
                    if ($(this).text() == "Twin") {
                        $("#row_st_tw").show();
                        $("#row_gl_tw").show();
                    }
                });
            </script>
            <?php
        }
    }

}

/* End of file enrol.php */
