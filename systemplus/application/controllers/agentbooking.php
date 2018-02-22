<?php

class Agentbooking extends Controller {

    public function __construct() {
        parent::Controller();

        $this->load->helper(array('form', 'url'));
        $this->load->library('session', 'email');
        $this->load->model('agent_booking_model');
        $this->load->model('agent_roster_model');
    }

    public function enrol($enroll_id = '') {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            if ($enroll_id != '') {
                $data['title'] = 'plus-ed.com | Edit group';
                $data['breadcrumb1'] = 'Enrol';
                $data['breadcrumb2'] = 'Edit group';
            } else {
                $data['title'] = 'plus-ed.com | Enrol new group';
                $data['breadcrumb1'] = 'Enrol';
                $data['breadcrumb2'] = 'Enrol new group';
            }

            $data['centri'] = $this->agent_booking_model->buildCampusByProgramId(1, 1);
            $data['accomodations'] = $this->agent_booking_model->getAccomodations();

            $data['accomodation_name_arr'] = array();
            foreach ($data['accomodations'] as $acc) {
                $data['accomodation_name_arr'][] = "st_" . strtolower($acc['accom_name']);
                $data['accomodation_name_arr'][] = "gl_" . strtolower($acc['accom_name']);
            }

            $data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";

            $data['enroll_details'] = $data['enrolled_packages'] = array();
            $data['enroll_id'] = "";
            if ($enroll_id != "") {
                $data['enroll_id'] = $enroll_id;
                $data['enroll_details'] = $this->agent_booking_model->getBookingsDetails($enroll_id);
                $data['packages'] = $this->agent_booking_model->getPackages($data['enroll_details']['centri_id'], $this->session->userdata('id'));
            }

            $this->ltelayout->view('lte/agents_new/booking/enrol', $data);
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

// Function to get packages related to the center
    public function getPackages() {
        $result = "<option value=''>Select package</option>";
        $center = $this->input->post("idcentro") ? $this->input->post("idcentro") : "";
        if ($center > 0) {
            $user_id = $this->session->userdata('id');
            $packages = $this->agent_booking_model->getPackages($center, $user_id);
            if (!empty($packages)) {
                foreach ($packages as $package) {
                    $result .= "<option value='" . $package['pack_package_id'] . "'>" . $package['pack_package'] . "</option>";
                }
                echo $result;
            } else
                echo $result;
        } else
            echo $result;
    }

// Function to get accomodations related to the package
    public function findAccomodationPrice() {
        $result = array();
        $package = $this->input->post("package_id") ? $this->input->post("package_id") : "";
        $week = $this->input->post("weeks") ? $this->input->post("weeks") : "";

        if ($package > 0 && $week > 0) {
            $data['price_result'] = $this->agent_booking_model->findPackagePrice($package, $week);
            if ($data['price_result']) {
                $price_html = $this->load->view("lte/agents_new/booking/enrol_price_composition_table", $data, TRUE);
                $result = array('price' => $price_html);
            }
        }

        echo json_encode($result);
    }

    function insertGroup($enroll_id = '') {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $user_id = $this->session->userdata('id');
            $param_enroll_id = $enroll_id;
            $insert_data['enrol_agent_id'] = $user_id;
            $insert_data['enrol_campus_id'] = $this->input->post('center_select');
            $insert_data['enrol_product_id'] = $this->input->post('prod_select', TRUE);
            $insert_data['enrol_package_id'] = $this->input->post('package_select', TRUE);
            $insert_data['enrol_booked_students'] = $this->input->post('sum_stud', TRUE);
            $insert_data['enrol_booked_gl'] = $this->input->post('sum_gl', TRUE);
            $insert_data['enrol_number_of_week'] = $this->input->post('n_weeks', TRUE);

            $arr = explode("/", $this->input->post('arrival_date'));
            $insert_data['enrol_arrival_date'] = $arr[2] . "-" . $arr[1] . "-" . $arr[0] . " 00:00:00";
            $arr2 = explode("/", $this->input->post('departure_date'));
            $insert_data['enrol_departure_date'] = $arr2[2] . "-" . $arr2[1] . "-" . $arr2[0] . " 00:00:00";

            $insert_data['total_price'] = $this->input->post('total_price', TRUE);
            $insert_data['free_gl_count'] = $this->input->post('free_gl_count', TRUE);
            $insert_data['enrol_created_on'] = date('Y-m-d H:i:s');
            $insert_data['enrol_created_by'] = $user_id;

            if ($enroll_id != '') {
// Delete data for that enroll_id from agnt_enrol_bookings and agnt_booked_pax table
                $this->agent_booking_model->delete_booking($enroll_id);
                $this->agent_booking_model->update_enrol_agent_booking($enroll_id, $insert_data);
            } else {
                $enroll_id = $this->agent_booking_model->enrol_agent_booking($insert_data);
            }

            $this->agent_booking_model->booked_pax($enroll_id, $insert_data['enrol_package_id'], $user_id, $insert_data['enrol_arrival_date'], $insert_data['enrol_departure_date']);

            if ($param_enroll_id == "") {
                $booking_details = $this->agent_booking_model->getBookingsDetails($enroll_id);
                $booking_composition = $this->agent_booking_model->getBookingComposition($enroll_id);
                $booking_accomodation = $this->agent_booking_model->getBookingAccomodation($enroll_id);
                $package_details = $this->agent_booking_model->getPackageDetails($insert_data['enrol_package_id']);

                if (!empty($package_details)) {
                    $free_pax_cnt = $package_details['pack_free_gl_per_pax'];
                    $extra_gl_price = $package_details['pack_extra_gl_price'];
                } else {
                    $free_pax_cnt = 0;
                    $extra_gl_price = 0;
                }

// Send email
                $this->load->library('email');

                $to_email = 'a.sudetti@gmail.com'; //$this->agent_booking_model->getAccountMail( $user_id );
                $from_email = "booking@plus-ed.com";

                $data['enroll_id'] = $enroll_id;
                $data['message'] = "A new booking (id: " . date('Y') . "_" . $enroll_id . ") has been submitted by <strong>" . $this->session->userdata('businessname') . "</strong>";
                $data['username'] = "Hello";
                $data["booking_details"] = $booking_details;
                $data["booking_composition"] = $booking_composition;
                $data["booking_accomodation"] = $booking_accomodation;
                $data["free_pax_cnt"] = $free_pax_cnt;
                $data["extra_gl_price"] = $extra_gl_price;
                $mymessage = $this->load->view('lte/agents_new/booking/enrol_booking_email_template', $data, TRUE);

                $this->email->set_newline("\r\n");
                $this->email->from($from_email, 'plus-ed.com');
                $this->email->to($to_email);
// $this->email->cc('smarra@plus-ed.com');
// $this->email->bcc('a.sudetti@gmail.com');
                $this->email->subject('Plus Sales Office - New booking submitted');
                $this->email->message($mymessage);

                $sendRes1 = $this->email->send();

                $this->email->clear();

                $data['message'] = "Your booking (id: " . date('Y') . "_" . $enroll_id . ") has been successfully transmitted.<br/><br/>";
                $data['username'] = "Dear " . $this->session->userdata('businessname');
                $mymessage2 = $this->load->view('lte/agents_new/booking/enrol_booking_email_template', $data, TRUE);

                $this->email->from($from_email, 'plus-ed.com');
                $this->email->to($to_email);
// $this->email->cc('a.kavak@plus-ed.com');
                $this->email->subject('Plus Sales Office - Your booking has been transmitted');
                $this->email->message($mymessage2);

                $sendRes2 = $this->email->send();
            }

            redirect('agentbooking/enrolledBookings', 'refresh');
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    function enrolledBookings($bookId = NULL, $year = NULL) {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = 'plus-ed.com | Inserted bookings';
            $data['breadcrumb1'] = 'Bookings review';
            $data['breadcrumb2'] = 'Inserted bookings';

            $data["all_books"] = $this->agent_booking_model->getBookingsByAgent($this->session->userdata('id'));

            $data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";

            $this->ltelayout->view('lte/agents_new/booking/enrol_booking_list', $data);
        } else {
            $this->session->sess_destroy();
            redirect('agents', 'refresh');
        }
    }

    function getBookings() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $request = $_REQUEST;
            $param = datatable_param($request, 'id_book', 'desc');
            $search = $request['search']['value'];
            $reportData = $this->agent_booking_model->paginateBookingData($this->session->userdata('id'), $param, $search);
            $reportCount = $this->agent_booking_model->getBookingCount($this->session->userdata('id'), $search);
            $reportData = $this->makeBookingsData($reportData);
            echo datatable_json($request['draw'], $reportCount, $reportData);
            exit(0);
        }
    }

    function makeBookingsData($reportData) {
        $data = array();
        if (!empty($reportData)) {
            foreach ($reportData as $key => $report) {
                $data[$key]['id_book'] = date('Y', strtotime($report['enrol_created_on'])) . '_' . $report['enroll_id'];
                $data[$key]['date_in'] = date('d/m/Y', strtotime($report['enrol_arrival_date']));
                $data[$key]['date_out'] = date('d/m/Y', strtotime($report['enrol_departure_date']));
                $data[$key]['weeks'] = $report['enrol_number_of_week'];
                $data[$key]['nome_centri'] = $report['nome_centri'];
                $data[$key]['package'] = $report['pack_package'];
                $data[$key]['pax'] = $report['pax'];
                $data[$key]['free_gl'] = $report['free_gl_count'];
                $data[$key]['total_price'] = $report['total_price'];
                $data[$key]['status'] = $this->bookingStatus($report['status']);
                $data[$key]['actions'] = $this->load->view('lte/agents_new/booking/enrol_booking_actions', $report, true);
            }
        }
        return $data;
    }

    function bookingStatus($status) {
        switch ($status) {
            case '1':
                return '<span data-class="n_tbc">To be confirmed</span>';
                break;

            case '2':
                return '<span data-class="n_active">Active</span>';
                break;

            case '3':
                return '<span data-class="n_confirmed">Confirmed</span>';
                break;

            case '4':
                return '<span data-class="n_rejected">Rejected</span>';
                break;

            case '5':
                return '<span data-class="n_elapsed">Elapsed</span>';
                break;
        }
    }

    public function getSingleBooking() {
        $enroll_id = $this->input->post('booking_id');
        $data['booking_composition'] = $this->agent_booking_model->getBookingComposition($enroll_id);
        $data['booking_accomodation'] = $this->agent_booking_model->getBookingAccomodation($enroll_id);
        $data['book'] = $this->agent_booking_model->getBookingsDetails($enroll_id);
        $package_details = $this->agent_booking_model->getPackageDetails($data['book']['pack_package_id']);

        if (!empty($package_details)) {
            $data['free_pax_cnt'] = $package_details['pack_free_gl_per_pax'];
            $data['extra_gl_price'] = $package_details['pack_extra_gl_price'];
        } else {
            $data['free_pax_cnt'] = 0;
            $data['extra_gl_price'] = 0;
        }
        $this->load->view('lte/agents_new/booking/enrol_booking_view', $data);
    }

// Function to get package start and end date
    public function packageDate() {
        $result = array();
        $package = $this->input->post("package_id") ? $this->input->post("package_id") : "";

        if ($package > 0)
            $result = $this->agent_booking_model->getPackageDate($package);

        echo json_encode($result);
    }

    public function findDatesByCenter() {
        $center = $this->input->post("idcentro") ? $this->input->post("idcentro") : "";

        $date_result = $this->agent_booking_model->findDatesByCenter($center);

        $date = "";
        foreach ($date_result as $dt) {
            $date .= ' <span class="datearrivo">' . $dt['st_date'] . '</span>';
        }
        echo $date;
    }

// Function to get package composition price for pax count
    public function packageCompositionPrice() {
        $result = array();
        $pack_comp_id = $this->input->post("pack_comp_id") ? $this->input->post("pack_comp_id") : "";
        $pax_count = $this->input->post("pax_count") ? $this->input->post("pax_count") : "";

        if ($pack_comp_id > 0)
            $result = $this->agent_booking_model->getPackageCompositionDetails($pack_comp_id);

        $price = 0;
        if ($result) {
            if ($pax_count >= 10 && $pax_count <= 19) {
                $display_price = $result['valuta'] . number_format($pax_count * $result['pcomp_price_a'], 2, ',', '');
                $price = $pax_count * $result['pcomp_price_a'];
            } else if ($pax_count >= 20 && $pax_count <= 39) {
                $display_price = $result['valuta'] . number_format($pax_count * $result['pcomp_price_b'], 2, ',', '');
                $price = $pax_count * $result['pcomp_price_b'];
            } else if ($pax_count >= 40) {
                $display_price = $result['valuta'] . number_format($pax_count * $result['pcomp_price_c'], 2, ',', '');
                $price = $pax_count * $result['pcomp_price_c'];
            } else {
                $display_price = $result['valuta'] . number_format($pax_count * $result['pcomp_full_price'], 2, ',', '');
                $price = $pax_count * $result['pcomp_full_price'];
            }
        }
        echo json_encode(array('display_price' => $display_price, 'price' => $price, 'currency' => $result['valuta']));
    }

// Function to get accomodations related to the package
    public function findAccomodation() {
        $result = array();
        $package = $this->input->post("package_id") ? $this->input->post("package_id") : "";

        if ($package > 0) {
            $accomodation = $this->agent_booking_model->findPackageAccomodation($package);

            $result = array('accomodation' => $accomodation);
        }

        echo json_encode($result);
    }

// Function to get accomodation price for pax count
    public function packageAccomodationPrice() {
        $result = array();

        $package = $this->input->post("package") ? $this->input->post("package") : 0;
        $weeks = $this->input->post("weeks") ? $this->input->post("weeks") : 0;
        $stud_tot = $this->input->post("stud_tot") ? $this->input->post("stud_tot") : 0;
        $gl_tot = $this->input->post("gl_tot") ? $this->input->post("gl_tot") : 0;
        $gl_pax_data = $this->input->post("gl_pax_data") ? $this->input->post("gl_pax_data") : "";

        $price_array = $price_details_array = $price = array();

// Get Package details
        $package_details = $this->agent_booking_model->getPackageDetails($package);

        if (!empty($package_details)) {
            $free_pax_cnt = $package_details['pack_free_gl_per_pax'];
            $extra_gl_price = $package_details['pack_extra_gl_price'];
        } else {
            $free_pax_cnt = 0;
            $extra_gl_price = 0;
        }

        if (!empty($gl_pax_data)) {
            foreach ($gl_pax_data as $data) {
                $accom_price_result = $this->agent_booking_model->getPackageAccomodationPrice($data[0], $package);
                if ($accom_price_result) {
                    $price_details_array[] = array('accommodation' => $data[0], 'pax_count' => $data[1], 'currency' => $accom_price_result['valuta'], 'serv_cost' => $accom_price_result['serv_cost']);
                }
            }
            foreach ($price_details_array as $key => $row) {
                $price[$key] = $row['serv_cost'];
            }
            array_multisort($price, SORT_ASC, $price_details_array);
        }

        if ($free_pax_cnt > 0) { // free GL present
            if ($stud_tot >= $free_pax_cnt) {
                $free_gl_cnt = floor($stud_tot / $free_pax_cnt);

                if (!empty($price_details_array)) {
                    $cnt = 0;
                    foreach ($price_details_array as $pda) {
                        if ($cnt < $free_gl_cnt) {
                            if ($pda['pax_count'] < ( $free_gl_cnt - $cnt )) {
                                $cnt = $cnt + $pda['pax_count'];
                                $free_pax = $pda['pax_count'];

                                $price = 0;
                                $display_price = $pda['currency'] . number_format($price, 2, ',', '');

                                $price_array[] = array('accommodation' => $pda['accommodation'], 'display_price' => $display_price, 'price' => $price, 'currency' => $pda['currency'], 'free_pax' => $free_pax);
                            } else if ($pda['pax_count'] >= ( $free_gl_cnt - $cnt )) {
                                $paid_pax = $pda['pax_count'] - ( $free_gl_cnt - $cnt );
                                $free_pax = $pda['pax_count'] - $paid_pax; //1
                                $cnt = $cnt + $free_pax; //2
                                $price = $paid_pax * ( $extra_gl_price * ( $weeks * 7 ) );
                                $display_price = $pda['currency'] . number_format($price, 2, ',', '');

                                $price_array[] = array('accommodation' => $pda['accommodation'], 'display_price' => $display_price, 'price' => $price, 'currency' => $pda['currency'], 'free_pax' => $free_pax);
                            }
                        } else {
                            $price = $pda['pax_count'] * ( $extra_gl_price * ( $weeks * 7 ) );
                            $display_price = $pda['currency'] . number_format($price, 2, ',', '');

                            $price_array[] = array('accommodation' => $pda['accommodation'], 'display_price' => $display_price, 'price' => $price, 'currency' => $pda['currency'], 'free_pax' => 0);
                        }
                    }
                }
            } else {
                if (!empty($price_details_array)) {
                    $cnt = 0;
                    foreach ($price_details_array as $pda) {
                        if ($cnt == 0) {
                            $first_gl_price = $remaining_gl_price = 0;
                            $remaining_gl = $pda['pax_count'] - 1;

// Discount for first GL
                            if ($pda['pax_count'] > 0) {
                                $first_gl_price = ( ( $stud_tot * $pda['serv_cost'] ) / $free_pax_cnt) * ( $weeks * 7 );
                                $cnt++;
                            }

                            if ($remaining_gl > 0)
                                $remaining_gl_price = $remaining_gl * ( $pda['serv_cost'] * ( $weeks * 7 ) );

                            $price = $first_gl_price + $remaining_gl_price;
                            $display_price = $pda['currency'] . number_format($price, 2, ',', '');
                        }
                        else {
                            $price = $pda['pax_count'] * ( $pda['serv_cost'] * ( $weeks * 7 ) );
                            $display_price = $pda['currency'] . number_format($price, 2, ',', '');
                        }

                        $price_array[] = array('accommodation' => $pda['accommodation'], 'display_price' => $display_price, 'price' => $price, 'currency' => $pda['currency'], 'free_pax' => 0);
                    }
                }
            }
        } else { // No free GL present
            if (!empty($price_details_array)) {
                foreach ($price_details_array as $pda) {
                    $price = $pda['pax_count'] * ( $pda['serv_cost'] * ( $weeks * 7 ) );
                    $display_price = $pda['currency'] . number_format($price, 2, ',', '');

                    $price_array[] = array('accommodation' => $pda['accommodation'], 'display_price' => $display_price, 'price' => $price, 'currency' => $pda['currency'], 'free_pax' => 0);
                }
            }
        }

        echo json_encode($price_array);
    }

    function getBookingDetails() {
        $enroll_id = $this->input->post('enrol_id') ? $this->input->post('enrol_id') : 0;
        $enroll_details = array();
        if ($enroll_id > 0) {
            $enroll_details = $this->agent_booking_model->getBookingsDetails($enroll_id);
            $enroll_student_details = $this->agent_booking_model->getBookingsDetailsByTipo($enroll_id, 'STD');
            $enroll_gl_details = $this->agent_booking_model->getBookingsDetailsByTipo($enroll_id, 'GL');
        }

        echo json_encode(array('enroll_details' => $enroll_details, 'enroll_student_details' => $enroll_student_details, 'enroll_gl_details' => $enroll_gl_details));
    }
        
}
