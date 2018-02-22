<?php

class Tuitions extends Controller {

    function __construct() {

        parent::Controller();
        // check user session and menus with their access.
        authSessionMenu($this);
        $this->load->helper(array('form', 'url', 'mpdf6'));
        $this->load->library('session', 'email', 'excel');
        $this->load->model("tuition/campuscoursemodel", "campuscoursemodel");
        $this->load->model("tuition/tuitionsmodel", "tuitionsmodel");
    }

    /**
     * index
     * This is default function to load teachers
     * @author SK
     * @since 16-Dec-2015
     */
    function index($fd = "", $td = "") {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Tuitions";
            $data['breadcrumb1'] = 'Tuition';
            $data['breadcrumb2'] = 'Tuitions schedule';
            $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
            $data["campusList"] = $this->campuscoursemodel->getCampusList(1, $campusId); // $this->session->userdata('id')
            //$classesList = $this->tuitionsmodel->getCampusClasses(2,'2015-12-02'); 
            //$data['all_classes'] = $classesList;
            $data['calFromDate'] = date("d-m-Y");
            $data['calToDate'] = date('d-m-Y', strtotime($data['calFromDate'] . ' + 15 days'));

            if (!empty($fd) && !empty($td)) {
                if ($this->_validateDate($fd) && $this->_validateDate($td)) {
                    $data['calFromDate'] = $fd;
                    $data['calToDate'] = $td;
                }
            }
            if ($this->session->userdata('role') == 400) {
                $fromDate = $data['calFromDate'];
                $toDate = $data['calToDate'];
                $fromDate = date("Y-m-d", strtotime($fromDate));
                $toDate = date("Y-m-d", strtotime($toDate));

                if (APP_THEME == "OLD")
                    $this->load->view('tuition/plused_tuitions_course_director', $data);
                else { // if(APP_THEME == "LTE")
                    $campusList = $data["campusList"];
                    if ($campusList && is_array($campusList)) {
                        $campus = $campusList[0];
                        $data['breadcrumb2'] .= " - " . $campus['nome_centri'];
                    }
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/tuition/coursedirector/schedule', $data);
                }
            } else {

                if (APP_THEME == "OLD")
                    $this->load->view('tuition/plused_tuitions', $data);
                else { // if(APP_THEME == "LTE")
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/tuition/schedule', $data);
                }
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * plan
     * This is default function to load teachers
     * @author SK
     * @since 16-Dec-2015
     */
    function plan($fd = "", $td = "") {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Class timetable";
            $data['breadcrumb1'] = 'Tuition';
            $data['breadcrumb2'] = 'Class timetable';
            $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
            $data["campusList"] = $this->campuscoursemodel->getCampusList(1, $campusId); // $this->session->userdata('id')
            //$classesList = $this->tuitionsmodel->getCampusClasses(2,'2015-12-02'); 
            //$data['all_classes'] = $classesList;
            $data['calFromDate'] = date("d-m-Y");
            $data['calToDate'] = date('d-m-Y', strtotime($data['calFromDate'] . ' + 15 days'));

            if (!empty($fd) && !empty($td)) {
                if ($this->_validateDate($fd) && $this->_validateDate($td)) {
                    $data['calFromDate'] = $fd;
                    $data['calToDate'] = $td;
                }
            }

            $fromDate = $data['calFromDate'];
            $toDate = $data['calToDate'];
            $fromDate = date("Y-m-d", strtotime($fromDate));
            $toDate = date("Y-m-d", strtotime($toDate));
            $data['campusId'] = $campusId;
            if ($this->session->userdata('role') == 400) {
                $classTeachers = $this->tuitionsmodel->getClassTeachersForDuration($fromDate, $toDate, $campusId);
                $data['classTeachers'] = json_encode($classTeachers);
                if (APP_THEME == "OLD") {
                    $this->load->view('tuition/plused_tuitions_plan', $data);
                } else {
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/tuition/class_timetable', $data);
                }
            } else {
                $classTeachers = $this->tuitionsmodel->getClassTeachersForDuration($fromDate, $toDate);
                $data['classTeachers'] = json_encode($classTeachers);
                if (APP_THEME == "OLD") {
                    $this->load->view('tuition/plused_tuitions_plan', $data);
                } else {
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/tuition/class_timetable', $data);
                }
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function _validateDate($date) {
        $d = DateTime::createFromFormat('d-m-Y', $date);
        return $d && $d->format('d-m-Y') == $date;
    }
    
    function checkTodaysClass($date, $campusId = 0) {
        $todaysClasses = $this->tuitionsmodel->checkTodaysClass($campusId, $date);
        return $todaysClasses;
    }

    function getTodaysBookings($date, $campusId = 0) {
        $bookingsForDay = $this->tuitionsmodel->getCampusBookingsStudentsCount($campusId, $date);
        $bookingsAssigned = $this->tuitionsmodel->getBookingsAssignedCount($campusId, $date);
        //$studentsWithCompletedCourseHours = $this->tuitionsmodel->checkStudentsCourseCompleted($campusId,$date);
        if ($bookingsAssigned || $bookingsForDay)
            echo "<span class='abook'>" . $bookingsAssigned . "</span>/<span class='pbook'>" . $bookingsForDay . "</span>";
        else
            echo "<span>-</span>";
    }

    function getTodaysBookingsAjax() {
        $campusId = $this->input->post('campusId');
        $dateS = $this->input->post('dateS');
        $bookingsForDay = $this->tuitionsmodel->getCampusBookingsStudentsCount($campusId, $dateS);
        $bookingsAssigned = $this->tuitionsmodel->getBookingsAssignedCount($campusId, $dateS);
        echo json_encode(array('bookingAssigned' => $bookingsAssigned, 'bookingForDay' => $bookingsForDay));
    }

    function getCourses() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $courseId = $this->input->post('campusId');
            $courseList = $this->campuscoursemodel->getCampusCourses($courseId);
            if ($courseList) {
                ?>
                <select class="required" id="selCourse" name="selCourse"  >
                    <option value="">Select course</option>
                    <?php
                    if ($courseList) {
                        foreach ($courseList as $course) {
                            ?><option value="<?php echo $course['cc_id']; ?>"><?php echo $course['cc_course_name']; ?></option><?php
                        }
                    }
                    ?>
                </select>
                <?php
            } else {
                ?>
                <select class="required" id="selCourse" name="selCourse"  >
                    <option value="">Select course</option>
                </select>
                <?php
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function getCampusTeachers() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $campusId = $this->input->post('campusId');
            $durationDate = $this->input->post('durationDate');
            $teacherList = $this->tuitionsmodel->getCampusTeachers($campusId, $durationDate);
            if ($teacherList) {
                ?>
                <select class="required" id="selTeacher" name="selTeacher"  >
                    <option value="">Select teacher</option>
                    <?php
                    if ($teacherList) {
                        foreach ($teacherList as $teacher) {
                            ?><option value="<?php echo $teacher['teach_id']; ?>"><?php echo $teacher['teach_fullname'] . "  [Priority: " . $teacher['joc_staff_priority'] . "]"; ?></option><?php
                        }
                    }
                    ?>
                </select>
                <?php
            } else {
                ?>
                <select class="required" id="selTeacher" name="selTeacher"  >
                    <option value="">Select teacher</option>
                </select>
                <?php
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function teachers() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
            $this->load->model("tuition/contractmodel", "contractmodel");
            $data['teachersData'] = $this->contractmodel->getTeachersDataForCD($campusId);
            $data['title'] = "plus-ed.com | Teachers details";
            $data['breadcrumb1'] = 'Tuition';
            $data['breadcrumb2'] = 'Teachers details';

            if (APP_THEME == "OLD") {
                $this->load->view('tuition/plused_teachers_employed', $data);
            } else {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/tuition/coursedirector/teachers_employed', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function filterCDTeachers() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
            $this->load->model("tuition/contractmodel", "contractmodel");

            $keyword = $this->input->post('keyword');
            $txtCalFromDate = $this->input->post('fromDate');
            $txtCalToDate = $this->input->post('toDate');

            if (!empty($txtCalFromDate) && !empty($txtCalToDate)) {
                $txtCalFromDate = explode('/', $txtCalFromDate);
                $txtCalToDate = explode('/', $txtCalToDate);
                if (array_key_exists(2, $txtCalFromDate))
                    $txtCalFromDate = $txtCalFromDate[2] . '-' . $txtCalFromDate[1] . '-' . $txtCalFromDate[0];
                if (array_key_exists(2, $txtCalToDate))
                    $txtCalToDate = $txtCalToDate[2] . '-' . $txtCalToDate[1] . '-' . $txtCalToDate[0];
            }

            $teachersData = $this->contractmodel->getTeachersDataForCD($campusId, $keyword, $txtCalFromDate, $txtCalToDate);
            if ($teachersData) {
                if (APP_THEME == "OLD") {
                    ?>
                    <table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"bRetrieve": true, "bDestroy": true, "bFilter":false, "aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
                        <thead>
                            <tr>
                                <th>Teacher</th>
                                <th>Date of birth</th>
                                <th>From Date</th>								
                                <th>To date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($teachersData)) {
                                foreach ($teachersData as $contract) {
                                    ?>
                                <div style="display: none;" id="dialog_modal_<?php echo $contract["joc_id"] ?>" title="Teacher detail - <?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?>" class="windia"> 
                                    <div class="box">
                                        <div class="header">
                                            <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Teacher details as per contract</span></h2>
                                        </div>
                                        <div class="content">
                                            <div class="detailContainer">
                                                <div class="clr">
                                                    <div class="grid_3"><strong>Name:</strong></div>
                                                    <div class="grid_3"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></div>

                                                    <div class="grid_3"><strong>Email:</strong></div>
                                                    <div class="grid_3"><?php echo $contract["joc_email"]; ?></div>
                                                </div>
                                                <div class="clr">
                                                    <div class="grid_3"><strong>Campus:</strong></div>
                                                    <div class="grid_3"><?php echo $contract["nome_centri"]; ?></div>

                                                    <div class="grid_3"><strong>Position:</strong></div>
                                                    <div class="grid_3"><?php echo $contract["pos_position"]; ?></div>
                                                </div>
                                                <div class="clr">
                                                    <div class="grid_3"><strong>From date:</strong></div>
                                                    <div class="grid_3"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></div>

                                                    <div class="grid_3"><strong>To date:</strong></div>
                                                    <div class="grid_3"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></div>
                                                </div>
                                                <div class="clr">
                                                    <div class="grid_3"><strong>Hours per week:</strong></div>
                                                    <div class="grid_3"><?php echo $contract["joc_hourperweek_range"]; ?></div>

                                                    <div class="grid_3"><strong>Date of birth:</strong></div>
                                                    <div class="grid_3"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <div class="header">
                                            <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Interview details</span></h2>
                                        </div>
                                        <div class="content">
                                            <div class="detailContainer">
                                                <div class="clr">
                                                    <div class="grid_3"><strong>Interview notes:</strong></div>
                                                    <div class="grid_9"><?php echo htmlentities($contract['ta_interview_notes']); ?></div>
                                                </div>
                                                <div class="clr">
                                                    <div class="grid_3"><strong>Interview strong:</strong></div>
                                                    <div class="grid_9"><?php echo htmlentities($contract['ta_interview_strong']); ?></div>
                                                </div>
                                                <div class="clr">
                                                    <div class="grid_3"><strong>Interview weak:</strong></div>
                                                    <div class="grid_9"><?php echo htmlentities($contract['ta_interview_weak']); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <tr>
                                    <td class="center"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></td>
                                    <td class="center"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></td>
                                    <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></td>
                                    <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></td>
                                    <td class="center operation">
                                        <a title="View" href="javascript:void(0);" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" data-id="dialog_modal_btn_<?php echo $contract["joc_id"]; ?>" class="dialogbtn">
                                            <span class="icon-eye-open"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    </table>
                    <?php
                } else {
                    ?>
                    <table class="datatable table table-bordered table-striped vertical-middle" style="width:99.98%;" >
                        <thead>
                            <tr>
                                <th>Teacher</th>
                                <th>Date of birth</th>
                                <th>From Date</th>								
                                <th>To date</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($teachersData)) {
                                foreach ($teachersData as $contract) {
                                    ?>
                                <div style="display: none;" id="dialog_modal_<?php echo $contract["joc_id"] ?>" title="<?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?>" > 
                                    <div class="modal-header">
                                        <h4><span class="modalTitle" >Teacher details as per contract</span>
                                            <button aria-label="Close" onclick="$('#dialog_modal_teacher').modal('hide');" class="close" type="button">
                                                <span aria-hidden="true">×</span></button>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-3"><strong>Name:</strong></div>
                                            <div class="col-sm-3"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></div>

                                            <div class="col-sm-3"><strong>Email:</strong></div>
                                            <div class="col-sm-3"><?php echo $contract["joc_email"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"><strong>Campus:</strong></div>
                                            <div class="col-sm-3"><?php echo $contract["nome_centri"]; ?></div>

                                            <div class="col-sm-3"><strong>Position:</strong></div>
                                            <div class="col-sm-3"><?php echo $contract["pos_position"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"><strong>From date:</strong></div>
                                            <div class="col-sm-3"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></div>

                                            <div class="col-sm-3"><strong>To date:</strong></div>
                                            <div class="col-sm-3"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"><strong>Hours per week:</strong></div>
                                            <div class="col-sm-3"><?php echo $contract["joc_hourperweek_range"]; ?></div>

                                            <div class="col-sm-3"><strong>Date of birth:</strong></div>
                                            <div class="col-sm-3"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></div>
                                        </div>
                                    </div>

                                    <div class="modal-header">
                                        <h4 class="modal-title"><span>Interview details</span></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-3"><strong>Interview notes:</strong></div>
                                            <div class="col-sm-9"><?php echo htmlentities($contract['ta_interview_notes']); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"><strong>Interview strong:</strong></div>
                                            <div class="col-sm-9"><?php echo htmlentities($contract['ta_interview_strong']); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"><strong>Interview weak:</strong></div>
                                            <div class="col-sm-9"><?php echo htmlentities($contract['ta_interview_weak']); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <tr>
                                    <td class="center"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></td>
                                    <td class="center"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></td>
                                    <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></td>
                                    <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></td>
                                    <td class="center operation">
                                        <a title="View" href="#" data-toggle="modal" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" data-id="dialog_modal_btn_<?php echo $contract["joc_id"]; ?>"  class="min-wd-24 dialogbtn btn btn-xs btn-primary" >
                                            <span data-original-title="View" data-container="body" data-toggle="tooltip">
                                                <i class="fa fa-eye"></i></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    </table>
                    <?php
                }
            } else {
                ?>
                <p>
                    Record(s) not found.
                </p>
                <?php
            }
        } else {
            $this->session->sess_destroy();
            echo "User session expired.";
        }
    }

    function getCampusStudents() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $class_edit_id = $this->input->post('class_edit_id');
            $campusId = $this->input->post('campusId');
            $courseId = $this->input->post('courseId');
            $classType = $this->input->post('classType');
            $dateOfClass = $this->input->post('dateOfClass');
            $classId = $this->input->post('classId');
            $toview = $this->input->post('toview');
            if (empty($classId))
                $classId = 0;
            $studentsList = $this->tuitionsmodel->getCampusStudents($campusId, $dateOfClass, $classId, $courseId);
            $campusCourseData = $this->campuscoursemodel->getData($courseId);
            $courseHours = 0;
            if ($campusCourseData)
            {
                $courseHours = $campusCourseData[0]['cc_total_hours'];
            }
            if ($studentsList) {
                $dataTime = time();
                ?>
                <input id="hidd_datatable" type="hidden" value="<?php echo $dataTime; ?>" />
                <?php if (APP_THEME == 'OLD') { ?>
                    <table id="<?php echo $dataTime; ?>" class="stdtable styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[2,"desc"]],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true}]}'>
                    <?php } else { ?>
                        <table style="width:100%;" id="<?php echo $dataTime; ?>" class="stdtable datatable table table-bordered table-striped" >
                        <?php } ?>
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Student name</th>
                                <th>Hours assigned</th>
                                <th>Language knowledge</th>
                                <th>Age</th>
                                <th>Nationality</th>
                                <th>Booking Id</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($studentsList as $student) {
                                $alreadyAssigned = $student['already_assigned'];
                                $studentsDateOfBirth = $student['pax_dob'];
                                $courseHoursForWeeks = $student['weeks'] * $courseHours;
                                $stdAge = "--";
                                if ($studentsDateOfBirth != "00-00-00 00:00:00" && $studentsDateOfBirth != '')
                                    $stdAge = date_diff(date_create($studentsDateOfBirth), date_create('today'))->y;
                                ?>
                                <tr >
                                    <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php
                                        if (!$alreadyAssigned) {
                                            if ($student['assigned_course_hours'] >= $courseHoursForWeeks) {
                                                if ($class_edit_id) {
                                                    ?>
                                                    <input id="chk_<?php echo $student['uuid']; ?>" type="checkbox" class="chkStudents" data-std-id="<?php echo $student['uuid']; ?>" />
                                                <?php } ?>
                                                <span class="flag-red label label-danger">Hours completed</span><?php
                                            } else if ($toview == 'toview') {
                                                ?><span class="flag-red label label-danger">Not assigned</span><?php
                                            } else {
                                                ?>
                                                    <input id="chk_<?php echo $student['uuid']; ?>" type="checkbox" class="chkStudents" data-std-id="<?php echo $student['uuid']; ?>" />
                                                <?php
                                            }
                                        } else 
                                        {
                                            if($classType == "Supplement")
                                            {
                                            ?>
                                                <input id="chk_<?php echo $student['uuid']; ?>" type="checkbox" class="chkStudents" data-std-id="<?php echo $student['uuid']; ?>" />
                                            <?php 
                                            }else{ 
                                            ?>
                                            <span class="flag-green label label-success"><?php echo htmlspecialchars($student['class_name'] . ' #' . $student["class_id"]); ?></span>
                                        <?php 
                                            }
                                        } 
                                        // ADD SUPPLEMENT CLASSES IF ANY
                                        // INFOMARMATION
                                        if(!empty($student['supplement_classes'])){
                                            $supCount = count($student['supplement_classes']);
                                            $supToolTip = implode(', ', $student['supplement_classes']);
                                        ?>
                                            <span title="<?php echo $supToolTip;?>" data-toggle="tooltip" class="label label-warning">S / <?php echo $supCount;?></span>
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                    <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo $student['nome'] . ' ' . $student['cognome']; ?></td>
                                    <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo round($student['assigned_course_hours']) . '/' . round($courseHoursForWeeks); ?></td>
                                    <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo $student['lk_lang_knowledge']; ?></td>
                                    <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo $stdAge; ?></td>
                                    <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo ucwords($student['nazionalita']); ?></td>
                                    <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo $student['id_year'] . '_' . $student['id_book']; ?></td>
                                </tr>
                                <?php
                            }
                            ?></tbody></table>
                    <?php
                } else {
                    ?>
                    <span>No students available for selected date.</span>
                    <?php
                }
            } else {
                $this->session->sess_destroy();
                redirect('backoffice', 'refresh');
            }
        }

        function getCampusStudentsForPrint() {
            if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                $campusId = $this->input->post('campusId');
                $courseId = $this->input->post('courseId');
                $dateOfClass = $this->input->post('dateOfClass');
                $classId = $this->input->post('classId');
                $classRow = $this->tuitionsmodel->getSingleClass($classId);
                $classRow = $classRow[0];
                $studentsList = $this->tuitionsmodel->getCampusStudentsPrint($campusId, $dateOfClass, $classId, $courseId); // $printData = TRUE
                $campusCourseData = $this->campuscoursemodel->getData($courseId);
                $courseHours = 0;
                if ($campusCourseData)
                    $courseHours = $campusCourseData[0]['cc_total_hours'];
                if ($studentsList) {
                    ?>
                    <style>
                        #print-head label{
                            padding: 4px;
                        }
                        #print-head{
                            margin-bottom: 20px;
                        }
                    </style>
                    <input type="hidden" id="hidd-print-title" value="<?php echo $classRow['class_name'] . ' #' . $classRow["class_id"] . '-' . date('d/m/Y', strtotime($classRow["class_date"])); ?>" />
                    <table id="print-head" style="width:100%;text-align: left;">
                        <thead>
                            <tr>
                                <th>Class level:<label><?php echo $classRow['class_name'] . ' #' . $classRow['class_id']; ?></label>
                                <span class="label label-<?php echo ($classRow["class_type"] == "Regular" ? 'success' : 'warning');?>">
                                    <?php echo htmlspecialchars($classRow["class_type"]); ?>
                                </span>
                                </th>
                                <th>Room Id:<label><?php echo $classRow['class_room_number']; ?></label></th>
                            </tr>
                            <tr>
                                <th>Course:<label><?php echo $classRow['cc_course_name']; ?></label></th>
                                <th>#Students:<label><?php echo $classRow['numberofbookings']; ?></label></th>
                            </tr>
                            <tr>
                                <th>Campus:<label><?php echo $classRow['nome_centri']; ?></label></th>
                                <th>Date:<label><?php echo date('d/m/Y', strtotime($classRow["class_date"])); ?></label></th>
                            </tr>
                        </thead>
                    </table>
                    <table style="width:100%;text-align: left;">
                        <thead>
                            <tr>
                                <th>Student name</th>
                                <th>Hours assigned</th>
                                <th>Language knowledge</th>
                                <th>Nationality</th>
                                <th>Booking Id</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($studentsList as $student) {
                                $alreadyAssigned = $student['already_assigned'];
                                $courseHoursForWeeks = $student['weeks'] * $courseHours;
                                ?>
                                <tr>
                                    <td><?php echo $student['nome'] . ' ' . $student['cognome']; ?></td>
                                    <td><?php echo round($student['assigned_course_hours']) . '/' . round($courseHoursForWeeks); ?></td>
                                    <td><?php echo $student['lk_lang_knowledge']; ?></td>
                                    <td><?php echo ucwords($student['nazionalita']); ?></td>
                                    <td><?php echo $student['id_year'] . '_' . $student['id_book']; ?></td>
                                </tr>
                                <?php
                            }
                            ?></tbody></table><?php
                } else {
                    ?>
                    <span>No students available for selected date.</span>
                    <?php
                }
            } else {
                $this->session->sess_destroy();
                redirect('backoffice', 'refresh');
            }
        }

        function getCampusStudentsForExport() {
            if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                $campusId = $this->input->post('campusId');
                $courseId = $this->input->post('courseId');
                $dateOfClass = $this->input->post('dateOfClass');
                $classId = $this->input->post('classId');
                $classRow = $this->tuitionsmodel->getSingleClass($classId);
                $classRow = $classRow[0];
                $studentsList = $this->tuitionsmodel->getCampusStudentsPrint($campusId, $dateOfClass, $classId, $courseId); // $printData = TRUE
                $campusCourseData = $this->campuscoursemodel->getData($courseId);
                $this->load->library('excel_180');
                $objPHPExcel = new PHPExcel();
                $courseHours = 0;
                if ($campusCourseData)
                    $courseHours = $campusCourseData[0]['cc_total_hours'];
                
                $styleArray = array(
                    'font' => array(
                        'bold' => true,
                ));
                if ($studentsList) {
                    setColumnAutoWidth($objPHPExcel, "A", "H");

                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Class Level');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', $classRow['class_name'] . ' #' . $classRow['class_id']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Room ID');
                    $objPHPExcel->getActiveSheet()->SetCellValue('E1', $classRow['class_room_number']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Course');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B2', $classRow['cc_course_name']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D2', '#Students');
                    $objPHPExcel->getActiveSheet()->SetCellValue('E2', $classRow['numberofbookings']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Campus');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B3', $classRow['nome_centri']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Date');
                    $objPHPExcel->getActiveSheet()->SetCellValue('E3', date('d/m/Y', strtotime($classRow["class_date"])));

                    $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Student name');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Hours assigned');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Language knowledge');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Nationality');
                    $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Booking Id');

                    $rowCount = 6;

                    foreach ($studentsList as $student) {
                        $courseHoursForWeeks = $student['weeks'] * $courseHours;
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $student['nome'] . ' ' . $student['cognome']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, round($student['assigned_course_hours']) . '/' . round($courseHoursForWeeks));
                        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $student['lk_lang_knowledge']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ucwords($student['nazionalita']));
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $student['id_year'] . '_' . $student['id_book']);
                        $rowCount++;
                    }

                    

                    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('D5')->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('E5')->applyFromArray($styleArray);
                } else {
                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'No students available for selected date');
                    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
                }
                ob_start();
                $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();

                $response = array(
                    'file_name' => 'students',
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                );
                echo json_encode($response);
                exit(0);
            } else {
                $this->session->sess_destroy();
                redirect('backoffice', 'refresh');
            }
        }

        function getBookings() {
            if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                $campusId = $this->input->post('campusId');
                $dateOfClass = $this->input->post('dateOfClass');
                $bookingList = $this->tuitionsmodel->getCampusBookings($campusId, $dateOfClass);
                if ($bookingList) {
                    ?>
                    <select class="required" multiple="" id="selBookings" name="selBookings"  >
                        <?php
                        if ($bookingList) {
                            foreach ($bookingList as $booking) {
                                ?><option value="<?php echo $booking['id_book']; ?>"><?php echo $booking['id_year'] . "_" . $booking['id_book']; ?></option><?php
                            }
                        }
                        ?>
                    </select>
                    <?php
                } else {
                    ?>
                    <select class="required" multiple="" id="selBookings" name="selBookings"  >
                    </select>
                    <?php
                }
            } else {
                $this->session->sess_destroy();
                redirect('backoffice', 'refresh');
            }
        }

        /**
         * create class here 
         */
        function createclass() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    if (!empty($_POST)) {
                        $classId = $this->input->post('classId');
                        $classDate = $this->input->post('classDate');
                        $campusId = $this->input->post('campusId');
                        $courseId = $this->input->post('courseId');
                        $classname = $this->input->post('classname');
                        $roomNumber = $this->input->post('roomNumber');
                        $classType = $this->input->post('classType');
                        $bookings = $this->input->post('bookings');
                        if (!empty($classDate) &&
                                !empty($campusId) &&
                                !empty($courseId) &&
                                !empty($classname) &&
                                !empty($roomNumber) &&
                                !empty($classType) &&
                                !empty($bookings) &&
                                is_array($bookings)) {
                            if (noSpecialChars($classname) && noSpecialChars($roomNumber)) {
                                $classDate = date("Y-m-d", strtotime(str_replace('/', '-', $classDate)));

                                //  check if already exist
                                $checkClass = array(
                                    'class_name' => $classname,
                                    'class_date' => $classDate,
                                    'class_campus_course_id' => $courseId
                                );
//                            $alreadyExist = $this->tuitionsmodel->checkClass($checkClass,$classId);
//                            if(!$alreadyExist)
//                            {
                                if ($classId) {
                                    $updateClass = array(
                                        'class_name' => $classname,
                                        'class_room_number' => $roomNumber,
                                        'class_type' => $classType,
                                        'class_campus_course_id' => $courseId
                                    );
                                    $classId = $this->tuitionsmodel->updateClass($updateClass, $classId);
                                    if ($classId) {
                                        // delete old entries
                                        $this->tuitionsmodel->deleteStudentBookings($classId);
                                        // insert booking for class
                                        foreach ($bookings as $book) {
                                            $insertBooking = array(
                                                'cs_booking_id' => $book,
                                                'cs_class_id' => $classId,
                                                'cs_created_on' => date("Y-m-d H:i:s"),
                                                'cs_created_by' => $this->session->userdata('id'),
                                                'cs_is_deleted' => 0
                                            );
                                            $this->tuitionsmodel->addStudentBookings($insertBooking);
                                        }
                                        echo json_encode(array("result" => 1, "message" => "Class is updated successfully."));
                                    } else
                                        echo json_encode(array("result" => 0, "message" => "Unable to update class."));
                                }
                                else {
                                    //$roomsStillAvaliable = $this->tuitionsmodel->checkRoomsAvailable($campusId,$classDate);
//                                    if($roomsStillAvaliable > 0)
//                                    {
                                    $insertClass = array(
                                        'class_name' => $classname,
                                        'class_room_number' => $roomNumber,
                                        'class_type' => $classType,
                                        'class_date' => $classDate,
                                        'class_campus_course_id' => $courseId,
                                        'class_created_on' => date("Y-m-d H:i:s"),
                                        'class_is_deleted' => 0,
                                        'class_created_by' => $this->session->userdata('id')
                                    );
                                    $classId = $this->tuitionsmodel->createClass($insertClass);
                                    if ($classId) {
                                        // insert booking for class
                                        foreach ($bookings as $book) {
                                            $insertBooking = array(
                                                'cs_booking_id' => $book,
                                                'cs_class_id' => $classId,
                                                'cs_created_on' => date("Y-m-d H:i:s"),
                                                'cs_created_by' => $this->session->userdata('id'),
                                                'cs_is_deleted' => 0
                                            );
                                            $this->tuitionsmodel->addStudentBookings($insertBooking);
                                        }
                                        echo json_encode(array("result" => 1, "message" => "Class is created successfully."));
                                    } else
                                        echo json_encode(array("result" => 0, "message" => "Unable to create class."));
//                                    }
//                                    else
//                                        echo json_encode (array("result" => 0 , "message"=>"Rooms are not available for the date and campus."));
                                }
//                            }
//                            else
//                                echo json_encode (array("result" => 0 , "message"=>"Class already exist with the same course and class level."));
                            } else
                                echo json_encode(array("result" => 0, "message" => "Special characters not allowed."));
                        } else
                            echo json_encode(array("result" => 0, "message" => "All fields are mandatory."));
                    } else
                        echo json_encode(array("result" => 0, "message" => "All fields are mandatory."));
                } else
                    echo json_encode(array("result" => 0, "message" => "User session is expired."));
            } catch (Exception $exc) {
                echo json_encode(array("result" => 0, "message" => $exc->getMessage()));
            }
        }

        function getClassListing() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $classDate = $this->input->post('classDate');
                    $campusId = $this->input->post('campusId');
                    $classesList = $this->tuitionsmodel->getCampusClassesWithNatFlags($campusId, $classDate);
                    $totalBookingForDay = $this->tuitionsmodel->getCampusBookingsStudentsCount($campusId, $classDate);
                    $bookingsAssigned = $this->tuitionsmodel->getBookingsAssignedCount($campusId, $classDate);
                    $campusTeachers = $this->tuitionsmodel->getCampusTeachers($campusId, $classDate);
                    $availableTeachers = 0;
                    if (is_array($campusTeachers))
                        $availableTeachers = count($campusTeachers);

                    $data['all_classes'] = $classesList;

                    $data['availableTeachers'] = $availableTeachers;
                    $data['totalBookingForDay'] = $totalBookingForDay;
                    $data['bookingsAssigned'] = $bookingsAssigned;

                    if (APP_THEME == "OLD")
                        $this->load->view('tuition/plused_classes', $data);
                    else
                        $this->load->view('lte/backoffice/tuition/schedule_ajax/modal_classes', $data);
                }
            } catch (Exception $ex) {
                
            }
        }

        /**
         *  
         * getClassListingForReplication
         * this is function used for replication process.
         */
        function getClassListingForReplication() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $classDate = $this->input->post('classDate');
                    $campusId = $this->input->post('campusId');
                    $classesList = $this->tuitionsmodel->getCampusClassesWithNatFlags($campusId, $classDate);
                    $data['all_classes'] = $classesList;
                    $data['rep_class_date'] = $classDate;
                    $data['rep_campus_id'] = $campusId;
                    $this->load->view('lte/backoffice/tuition/schedule_ajax/modal_classes_replication', $data);
                }
            } catch (Exception $ex) {
                
            }
        }

        /**
         * getClassListingForMarkPresence
         * this is function used for mark teachers presence process.
         */
        function getClassListingForMarkPresence() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $classDate = $this->input->post('classDate');
                    $campusId = $this->input->post('campusId');
                    $classesList = $this->tuitionsmodel->getCampusClassesWithNatFlags($campusId, $classDate);
                    $data['all_classes'] = $classesList;
                    $data['mtpClassDate'] = $classDate;
                    $data['mtpCampusId'] = $campusId;
                    $this->load->view('lte/backoffice/tuition/schedule_ajax/modal_classes_markteacherspresence', $data);
                }
            } catch (Exception $ex) {
                
            }
        }

        /**
         *  getTeacherListingForMarkPresence
         */
        function getTeacherListingForMarkPresence($classId) {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $teachersList = $this->tuitionsmodel->getClassTeachers($classId);
                    $data['classId'] = $classId;
                    $data['all_teachers'] = $teachersList;
                    $this->load->view('lte/backoffice/tuition/schedule_ajax/modal_class_teachers_for_mark_presence', $data);
                }
            } catch (Exception $ex) {
                
            }
        }

        function submitMarkTeachersPresence() {
            $mtpClassId = $this->input->post('mtpClassId');
            $lessonId = $this->input->post('lessonId');
            $resultMarkedLessons = array();
            if ($mtpClassId) {
                foreach ($mtpClassId as $classId) {
                    if (isset($lessonId[$classId])) {
                        foreach ($lessonId[$classId] as $lsId => $lessonData) {
                            $presence = 0;
                            $prensenceNotes = "";
                            if (isset($lessonData['chkMarkPresence'])) {
                                if ($lessonData['chkMarkPresence'] == 1) {
                                    $presence = 1;
                                }
                            }
                            if (isset($lessonData['selCdComment'])) {
                                $prensenceNotes = $lessonData['selCdComment'];
                            }
                            $updateData = array(
                                'cl_presence_of_teacher' => $presence,
                                'cl_lesson_note' => $prensenceNotes
                            );
                            if ($this->session->userdata('role') == 400) {//cl_course_director_marked
                                $updateData['cl_course_director_marked'] = 1;
                            }
                            $resultClId = $this->tuitionsmodel->updateMarkAsPrensent($updateData, $lsId);
                            if ($resultClId) {
                                $resultMarkedLessons[] = $lsId;
                            }
                        }
                    }
                }
            }
            echo json_encode(
                    array(
                        "result" => 1,
                        "message" => "All record(s) are marked for teachers presence",
                        "markedLessons" => $resultMarkedLessons
            ));
        }

        /**
         * submitReplicationWithEdit
         * create classes for new dates in replication process.
         */
        function submitReplicationWithEdit() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $orgDate = $this->input->post('org_class_date');
                    $orgCampusId = $this->input->post('rep_campus_id');

                    $repClassId = $this->input->post("repClassId");
                    $repClassDate = $this->input->post("repClassDate");
                    if(is_array($repClassDate))
                        $repClassDate = array_values(array_filter($repClassDate));
                    $lessonId = $this->input->post("lessonId");
                    
                    $resultFlag = 0;
                    $returnArray = array();
                    $messageArray = array();
                    // check there is already classes started or not on next day.
                    if (!empty($repClassId) && is_array($repClassDate)) {

                        foreach ($repClassId as $key => $classId) {
                            /**
                             * previous class id 
                             */
                            $orgClass = (array) $this->tuitionsmodel->getClassData($classId);

                            $org_class_id = $classId;
                           
                            $nextDate = explode('/', $repClassDate[$key]);

                            if (array_key_exists(2, $nextDate))
                                $nextDate = $nextDate[2] . '-' . $nextDate[1] . '-' . $nextDate[0];

                            $class_name = $orgClass['class_name'];
                            $class_type = $orgClass['class_type'];
                            $class_room_number = $orgClass['class_room_number'];
                            $class_campus_course_id = $orgClass['class_campus_course_id'];

                            // get class students for next day class...
                            $studentsBookingIds = $this->tuitionsmodel->getStudentsForClass($orgCampusId, $org_class_id, $nextDate,$class_campus_course_id);
                            $returnArray['cellIds'][] = strtotime($nextDate);
                            $insertClass = array(
                                'class_name' => $class_name,
                                'class_room_number' => $class_room_number,
                                'class_type' => $class_type,
                                'class_date' => $nextDate,
                                'class_campus_course_id' => $class_campus_course_id,
                                'class_created_on' => date("Y-m-d H:i:s"),
                                'class_is_deleted' => 0,
                                'class_replicated' => 1,
                                'class_created_by' => $this->session->userdata('id')
                            );

                            $newClassId = $this->tuitionsmodel->createClass($insertClass);

                            if ($newClassId) {
                                if ($studentsBookingIds) {
                                    // insert booking for class
                                    foreach ($studentsBookingIds as $book) {
                                        $insertBooking = array(
                                            'cs_booking_id' => $book,
                                            'cs_class_id' => $newClassId,
                                            'cs_created_on' => date("Y-m-d H:i:s"),
                                            'cs_created_by' => $this->session->userdata('id'),
                                            'cs_is_replicated' => 1,
                                            'cs_is_deleted' => 0
                                        );
                                        $this->tuitionsmodel->addStudentBookings($insertBooking);
                                    }
                                } else
                                    array_push($messageArray, "No students available in the campus for class " . $class_name . " #" . $classId . ".");
                                if (isset($lessonId[$classId])) {
                                    foreach ($lessonId[$classId] as $lsId => $lessonData) {
                                        $teachersAssigned[] = array(
                                            'cl_teacher_id' => $lessonData['teacherId'],
                                            'duration' => 1
                                        );
                                        $teachersAvailable = $this->tuitionsmodel->checkTeachersAvailableForNextDate($teachersAssigned, $nextDate);
                                        // teachers are available for next day in campus
                                        if ($teachersAvailable['allowed'] == 1) {
                                            $contractTeacherNotAvailable = $teachersAvailable['contractTeacherNotAvailable'];
                                            if (empty($contractTeacherNotAvailable)) {
                                                $insertTeacher = array(
                                                    'cl_teacher_id' => $lessonData['teacherId'],
                                                    'cl_class_id' => $newClassId,
                                                    'cl_from_time' => $lessonData['newFromTime'],
                                                    'cl_to_time' => $lessonData['newToTime'],
                                                    'cl_created_on' => date("Y-m-d H:i:s"),
                                                    'cl_is_deleted' => 0,
                                                    'cl_is_replicated' => 1,
                                                    'cl_created_by' => $this->session->userdata('id')
                                                );
                                                $this->tuitionsmodel->addTeacherToClass($insertTeacher);
                                            } else
                                                array_push($messageArray, "\nSkipped! Teacher or per day teaching hours not available to create lesson for class " . $class_name . " #" . $classId . ".");
                                        }
                                    }
                                }
                            }
                        }
                        array_push($messageArray, "\nAll data is replicated to selected dates successfully.");
                        $resultFlag = 1;
                    }
                    $strMessage = "";
                    foreach ($messageArray as $message) {
                        $strMessage .= $message . "\n";
                    }
                    $returnArray['message'] = $strMessage;
                    $returnArray['status'] = $resultFlag;
                    echo json_encode($returnArray);
                }
            } catch (Exception $ex) {
                
            }
        }

        function validateTeacherTiming() {

            $lessonId = $this->input->post('lessonId');
            $rm_repClassId = $this->input->post('rm_repClassId');
            $repClassDate = $this->input->post('repClassDate');
            $resultData = array();
            $result = 1;
            $idx = 0;
            // remove the classes data which is not selected.
            if(is_array($rm_repClassId)){
                if(count($rm_repClassId)){
                    foreach ($rm_repClassId as $removedClassId){
                        unset($lessonId[$removedClassId]);
                    }
                }
            }

            if ($lessonId)
                foreach ($lessonId as $classId => $lessonIds) {
                    $classDate = $repClassDate[$idx];
                    $idx++;
                    foreach ($lessonIds as $clId => $lessonDetail) {
                        $fromTime = $lessonDetail['newFromTime'];
                        $toTime = $lessonDetail['newToTime'];
                        $teacherId = $lessonDetail['teacherId'];
                        if ($fromTime != "" && $toTime != "") {
                            $checkForTime = $this->tuitionsmodel->checkTeachersTiming($fromTime, $toTime, $classId, $clId, $teacherId, $classDate);
                            if ($checkForTime) {
                                $result = 0;
                                $resultData[] = $clId;
                            }
                        } else {
                            $result = 0;
                            $resultData[] = $clId;
                        }
                    }
                }
            if ($result) {
                echo json_encode(array("result" => 1, "resultData" => $resultData));
            } else
                echo json_encode(array("result" => 0, "resultData" => $resultData));
        }

        /**
         *  getTeacherListingForReplication
         */
        function getTeacherListingForReplication($classId) {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $teachersList = $this->tuitionsmodel->getClassTeachers($classId);
                    $data['classId'] = $classId;
                    $data['all_teachers'] = $teachersList;
                    $this->load->view('lte/backoffice/tuition/schedule_ajax/modal_class_teachers_replication', $data);
                }
            } catch (Exception $ex) {
                
            }
        }

        function getTeachersForClass($classId = 0) {

            $classTeachers = $this->tuitionsmodel->getClassTeachersCount($classId);
            $classTeachers = $classTeachers[0];
            if ($classTeachers['teacher_assigned']) {

                $strMinMaxTime = $classTeachers['min_time'] . '-' . $classTeachers['max_time'];
                $cssColor = 'green';
                $strCellValue = "<a class='tipsy-class' style='color:" . $cssColor . "' title='" . $classTeachers['teacher_name'] . "' href='javascript:void(0);'>" . $classTeachers['teacher_assigned'] . "</a><br /><span class='agerange'>" . $strMinMaxTime . "</span>";
                return array('cellValue' => $strCellValue, 'teacher_assigned' => $classTeachers['teacher_assigned']);
            } else {
                $cssColor = 'red';
                $strCellValue = "<a class='tipsy-class' style='color:" . $cssColor . "' title='Teachers not assigned yet.' href='javascript:void(0);'>" . $classTeachers['teacher_assigned'] . "</a><br /><span class='agerange'></span>";
                return array('cellValue' => $strCellValue, 'teacher_assigned' => 0);
            }
            /* $classTeachers = $this->tuitionsmodel->getClassTeachers($classId);
              // cl_from_time, cl_to_time
              $teachersArr = array();
              $countTeacher = 0;
              $cssColor = 'green';
              $minTime = '00:00:00';
              $maxTime = '00:00:00';
              $strMinMaxTime = "";
              if($classTeachers){
              $strTeachersNames = "";
              foreach($classTeachers as $teacher){
              array_push($teachersArr, $teacher['cl_teacher_id']);

              $countTeacher++;
              $strTeachersNames .= $teacher['teacher_name'] . ", ";
              $fromTime = $teacher['cl_from_time'];
              if(!empty($fromTime)){
              if($minTime == '00:00:00')
              $minTime = $fromTime;
              elseif(strtotime($fromTime) < strtotime($minTime)){
              $minTime = $fromTime;
              }
              }
              $toTime = $teacher['cl_to_time'];
              if(!empty($toTime)){
              if($maxTime == '00:00:00')
              $maxTime = $toTime;
              elseif(strtotime($toTime) > strtotime($maxTime)){
              $maxTime = $toTime;
              }
              }
              }
              $strTeachersNames = trim($strTeachersNames,', ');
              }

              if(empty($countTeacher))
              {
              $strTeachersNames = "Teachers not assigned yet.";
              $cssColor = "red";
              }
              else
              $strMinMaxTime = substr($minTime, 0, 5) .'-'. substr($maxTime, 0, 5);

              $strCellValue = "<a class='tipsy-class' style='color:".$cssColor."' title='".$strTeachersNames."' href='javascript:void(0);'>".$countTeacher."</a><br /><span class='agerange'>".$strMinMaxTime."</span>";
              return array('cellValue' => $strCellValue, 'teachersArr' => $teachersArr);
             * 
             */
        }
        
        function _getClassTeachersCountForTheDay($classIdsArr) {
            $teacherCount = $this->tuitionsmodel->getClassTeachersCountForTheDay($classIdsArr);
            return $teacherCount;
        }

        function getNationalityFlags($class_id = 0) {
            $nationalityArr = array();
            $outputString = "";
            if ($class_id) {
                $outputString = $this->tuitionsmodel->getStudentsInClassNationality($class_id);
//            print_r($classStudents);die;
//            if($classStudents){
//                foreach ($classStudents as $student){
//                    $strNationality = $student['nat_flag'];
//                    $strNationalityTitle = $student['nazionalita'];
//                    if(!empty($strNationality))
//                    if(!in_array($strNationality, $nationalityArr)){
//                        $nationalityArr[$strNationalityTitle] = $strNationality;
//                    }
//                }
//            }
            }
//        foreach($nationalityArr as $key => $natImageName){
//            $outputString .= "<img class='nationality-flags' title='".ucwords($key)."' src='". base_url() . NATIONALITY_FILES_PATH . $natImageName ."' />";
//        }
            return $outputString;
        }

        function getStudentsKnowledgeLanguage($class_id = 0) {
            $lkRange = "";
            if ($class_id) {
                $lkRange = $this->tuitionsmodel->getClassStudentsKwnowledgeLanguage($class_id);
//            if($classStudents){
//                $lkRange = (empty($classStudents->min_lk) ? "0" : $classStudents->min_lk) ." - ". (empty($classStudents->max_lk) ? "0" : $classStudents->max_lk);
//            }
            }
            return $lkRange;
        }

        function getAvailableRoomsStudents() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $classDate = $this->input->post('classDate');
                    $campusId = $this->input->post('campusId');
                    $result = $this->tuitionsmodel->getAvailableRoomsStudents($campusId, $classDate);
                    if ($result) {
                        $data['result'] = 1;
                        $data['numberOfRooms'] = $result->cr_number_of_rooms;
                        $data['studentsPerRoom'] = $result->cr_students_per_room;
                    } else {
                        $data['result'] = 0;
                        $data['message'] = "No rooms allotted for campus on date: " . date('d/m/Y', strtotime($classDate));
                    }
                    echo json_encode($data);
                }
            } catch (Exception $ex) {
                
            }
        }

        function getSingleClass() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $classId = $this->input->post('classId');
                    $classRow = $this->tuitionsmodel->getSingleClass($classId);
                    if ($classRow) {
                        $data['classDetail'] = $classRow;
                        $data['result'] = 1;
                    } else {
                        $data['message'] = "Unable to fetch class detail.";
                        $data['result'] = 0;
                    }
                    echo json_encode($data);
                }
            } catch (Exception $ex) {
                
            }
        }

        function deleteClass() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $classId = $this->input->post('classId');

                    //CHECK IF THERE IS ANY TEACHER MARKED AS PRESENT
                    $checkTeacher = 1; // ALLOWED BACKOFFICE OPERATOR TO DELETE
                    if ($this->session->userdata('role') != 100) {
                        $checkTeacher = $this->tuitionsmodel->checkTeacherForClass($classId);
                    }
                    if ($checkTeacher) {
                        $classRow = $this->tuitionsmodel->deleteClass($classId);
                        if ($classRow) {
                            $data['message'] = "Class has been deleted successfully.";
                            $data['result'] = 1;
                        } else {
                            $data['message'] = "Unable to delete class detail.";
                            $data['result'] = 0;
                        }
                    } else {
                        $data['message'] = "You can not delete the class when there is a teacher marked as present.";
                        $data['result'] = 0;
                    }
                    echo json_encode($data);
                }
            } catch (Exception $ex) {
                
            }
        }

        /* TEACHERS */

        function addteacher() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    if (!empty($_POST)) {
                        $clId = $this->input->post('clId');
                        $classId = $this->input->post('classId');
                        $courseId = $this->input->post('courseId');
                        $teacherId = $this->input->post('teacherId');
                        $fromTime = $this->input->post('txtFromTime');
                        $toTime = $this->input->post('txtToTime');
                        $classDate = $this->input->post('classDate');
                        if (!empty($classId) &&
                                !empty($teacherId) &&
                                !empty($fromTime) &&
                                !empty($toTime)) {
                            if (strtotime($fromTime) < strtotime($toTime)) {
                                //  check still there are course hours available to assign or not..?
//                            $checkCourseHours = $this->tuitionsmodel->checkCourseHours($fromTime,$toTime,$courseId,$clId);
//                            if($checkCourseHours)
//                            {
                                //  check if already exist
                                $checkForTime = $this->tuitionsmodel->checkTeachersTiming($fromTime, $toTime, $classId, $clId, $teacherId, $classDate);
                                if (!$checkForTime) {
                                    if ($clId) {
                                        $updateTeacher = array(
                                            'cl_teacher_id' => $teacherId,
                                            'cl_class_id' => $classId,
                                            'cl_from_time' => $fromTime,
                                            'cl_to_time' => $toTime
                                        );
                                        $clId = $this->tuitionsmodel->updateTeacher($updateTeacher, $clId);
                                        if ($clId == -2) {
                                            echo json_encode(array("result" => 0, "message" => "You can not modify teacher once it is marked as present."));
                                        } elseif ($clId) {
                                            echo json_encode(array("result" => 1, "message" => "Teacher is updated successfully."));
                                        } else
                                            echo json_encode(array("result" => 0, "message" => "Unable to update class."));
                                    }
                                    else {
                                        $insertTeacher = array(
                                            'cl_teacher_id' => $teacherId,
                                            'cl_class_id' => $classId,
                                            'cl_from_time' => $fromTime,
                                            'cl_to_time' => $toTime,
                                            'cl_created_on' => date("Y-m-d H:i:s"),
                                            'cl_is_deleted' => 0,
                                            'cl_created_by' => $this->session->userdata('id')
                                        );
                                        $clId = $this->tuitionsmodel->addTeacherToClass($insertTeacher);
                                        if ($clId) {
                                            echo json_encode(array("result" => 1, "message" => "Teacher is added successfully."));
                                        } else
                                            echo json_encode(array("result" => 0, "message" => "Unable to add teacher."));
                                    }
                                } else
                                    echo json_encode(array("result" => 0, "message" => "There is already teacher assigned for this time period."));
//                            }
//                            else
//                                echo json_encode (array("result" => 0 , "message"=>"There is no extra course hours remaining to assign."));
                            } else
                                echo json_encode(array("result" => 0, "message" => "From time should be less than to time."));
                        } else
                            echo json_encode(array("result" => 0, "message" => "All fields are mandatory."));
                    } else
                        echo json_encode(array("result" => 0, "message" => "All fields are mandatory."));
                } else
                    echo json_encode(array("result" => 0, "message" => "User session is expired."));
            } catch (Exception $exc) {
                echo json_encode(array("result" => 0, "message" => $exc->getMessage()));
            }
        }

        function getAvailableHours($courseId = 0) {
            $courseId = $this->input->post('courseId');
            $resultData = $this->tuitionsmodel->getAvailableHours($courseId);
            echo json_encode($resultData);
        }

        function getTeacherListing() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $classId = $this->input->post('classId');
                    $teachersList = $this->tuitionsmodel->getClassTeachers($classId);
                    $data['all_teachers'] = $teachersList;
                    if (APP_THEME == "OLD") {
                        $this->load->view('tuition/plused_class_teachers', $data);
                    } else {
                        $this->load->view('lte/backoffice/tuition/schedule_ajax/modal_class_teachers', $data);
                    }
                }
            } catch (Exception $ex) {
                
            }
        }

        function deleteTeacher() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $clId = $this->input->post('clId');
                    $teacherRow = $this->tuitionsmodel->deleteTeacher($clId);
                    if ($teacherRow == 2) {
                        $data['message'] = "You can not delete this record as it is marked as present.";
                        $data['result'] = 0;
                    } else if ($teacherRow) {
                        $data['message'] = "Teacher has been removed successfully.";
                        $data['result'] = 1;
                    } else {
                        $data['message'] = "Unable to remove teacher detail.";
                        $data['result'] = 0;
                    }
                    echo json_encode($data);
                }
            } catch (Exception $ex) {
                
            }
        }

        function getTeacherDetail() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $clId = $this->input->post('clId');
                    $teacherRow = $this->tuitionsmodel->getTeacher($clId);
                    if ($teacherRow) {
                        $data['message'] = "";
                        $data['result'] = 1;
                        $data['teacherRow'] = $teacherRow;
                    } else {
                        $data['message'] = "Unable to fetch teacher detail.";
                        $data['result'] = 0;
                    }
                    echo json_encode($data);
                }
            } catch (Exception $ex) {
                
            }
        }

        /**
         * updateLesson
         * this is is used to update prsence of teacher and notes for the lesson
         * return json array
         */
        function updateLesson() {
            try {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $data = array();
                    $clId = $this->input->post('clId');
                    $presence = $this->input->post('presence');
                    $prensenceNotes = $this->input->post('prensenceNotes');
//                if(!empty($prensenceNotes) && $presence == 1)
//                {
                    $updateData = array(
                        'cl_presence_of_teacher' => $presence,
                        'cl_lesson_note' => $prensenceNotes
                    );
                    if ($this->session->userdata('role') == 400) {//cl_course_director_marked
                        $updateData['cl_course_director_marked'] = 1;
                    }
                    $teacherRow = $this->tuitionsmodel->updateMarkAsPrensent($updateData, $clId);

                    if ($teacherRow) {
                        $data['message'] = "Teacher data has been updated successfully.";
                        $data['result'] = 1;
                    } else {
                        $data['message'] = "Unable to update teacher data.";
                        $data['result'] = 0;
                    }
//                }
//                else
//                {
//                    $data['message'] = "Please add notes for the lesson.";
//                    $data['result'] = 0;
//                }
                    echo json_encode($data);
                }
            } catch (Exception $ex) {
                
            }
        }

        function checkTeachersForReplication() {
            $orgCampusId = $this->input->post('campusId');
            $orgDate = $this->input->post('classDate');
            $selectedNextDay = $this->input->post('nextDay');
            $nextDate = date('Y-m-d', strtotime($orgDate . ' + 1 days'));
            $nextDay = date('l', strtotime($nextDate));
            $allowed = 1;
            
            if($nextDay == "Saturday")
            {
                if($selectedNextDay == "Monday"){
                    $nextDate = date('Y-m-d', strtotime($nextDate . ' + 2 days'));
                }
            }
            if($nextDay == "Sunday")
                $nextDate = date('Y-m-d', strtotime($nextDate . ' + 1 days'));
            

            $teachersAssigned = $this->tuitionsmodel->getTeachersAssigned($orgCampusId, $orgDate);
            if ($teachersAssigned) {
                $teachersAvailable = $this->tuitionsmodel->checkTeachersAvailableForNextDate($teachersAssigned, $nextDate);
                if ($teachersAvailable) {
                    $contractTeacherNotAvailable = $teachersAvailable['contractTeacherNotAvailable'];
                    if (!empty($contractTeacherNotAvailable))
                        $allowed = 0;
                }
            }
            echo json_encode(array('allowed' => $allowed));
        }

        function replicate() {
            $resultFlag = 0;
            $returnArray = array();
            $messageArray = array();
            $teachersAvailable = array();
            $overwrite = $this->input->post('overwrite');
            $orgDate = $this->input->post('classDate');
            $selectedNextDay = $this->input->post('nextDay');
            $nextDate = date('Y-m-d', strtotime($orgDate . ' + 1 days'));
            $nextDay = date('l', strtotime($nextDate));
            
            /*if ($nextDay == "Saturday")
                $nextDate = date('Y-m-d', strtotime($nextDate . ' + 2 days'));
            if ($nextDay == "Sunday")
                $nextDate = date('Y-m-d', strtotime($nextDate . ' + 1 days'));*/
            if($nextDay == "Saturday")
            {
                if($selectedNextDay == "Monday"){
                    $nextDate = date('Y-m-d', strtotime($nextDate . ' + 2 days'));
                }
            }
            if($nextDay == "Sunday")
                $nextDate = date('Y-m-d', strtotime($nextDate . ' + 1 days'));


            $orgCampusId = $this->input->post('campusId');
            $numberOfClasses = 0;
            $roomsAvailable = 0;

            // check there is already classes started or not on next day.
            $nextDayClasses = $this->tuitionsmodel->getCampusClasses($orgCampusId, $nextDate);
            if (empty($nextDayClasses) || $overwrite) {
                if ($overwrite && !empty($nextDayClasses)) {
                    // remove all existing data for next date
                    $this->tuitionsmodel->removeAllExistingData($nextDayClasses);
                }
                // check number of classes to be created
                $orgClasses = $this->tuitionsmodel->getCampusClasses($orgCampusId, $orgDate);
                if (!empty($orgClasses)) {
                    $numberOfClasses = count($orgClasses);
                    // check number of rooms available for classes
                    //            $roomsAvailable = $this->tuitionsmodel->checkRoomsAvailable($orgCampusId,$nextDate);
                    //            if($numberOfClasses <= $roomsAvailable){
                    // get total teachers assigned and there hours for classes.
                    $teachersAssigned = $this->tuitionsmodel->getTeachersAssigned($orgCampusId, $orgDate);
                    if ($teachersAssigned) {
                        $teachersAvailable = $this->tuitionsmodel->checkTeachersAvailableForNextDate($teachersAssigned, $nextDate);
//                        echo "<pre>";
//                        print_r($teachersAvailable);die;
                        // teachers are available for next day in campus
                        if ($teachersAvailable['allowed'] == 1) {
                            $contractTeacherNotAvailable = $teachersAvailable['contractTeacherNotAvailable'];
                            foreach ($orgClasses as $orgClass) {
                                /**
                                 * previous class id 
                                 */
                                $org_class_id = $orgClass['class_id'];
                                $class_date = $nextDate;
                                $class_name = $orgClass['class_name'];
                                $class_type = $orgClass['class_type'];
                                $class_room_number = $orgClass['class_room_number'];
                                $class_campus_course_id = $orgClass['class_campus_course_id'];

                                // get class students for next day class...
                                $studentsBookingIds = $this->tuitionsmodel->getStudentsForClass($orgCampusId, $org_class_id, $nextDate);
                                $insertClass = array(
                                    'class_name' => $class_name,
                                    'class_type' => $class_type,
                                    'class_room_number' => $class_room_number,
                                    'class_date' => $class_date,
                                    'class_campus_course_id' => $class_campus_course_id,
                                    'class_created_on' => date("Y-m-d H:i:s"),
                                    'class_is_deleted' => 0,
                                    'class_replicated' => 1,
                                    'class_created_by' => $this->session->userdata('id')
                                );
                                $classId = $this->tuitionsmodel->createClass($insertClass);
                                if ($classId) {
                                    if ($studentsBookingIds) {
                                        // insert booking for class
                                        foreach ($studentsBookingIds as $book) {
                                            $insertBooking = array(
                                                'cs_booking_id' => $book,
                                                'cs_class_id' => $classId,
                                                'cs_created_on' => date("Y-m-d H:i:s"),
                                                'cs_created_by' => $this->session->userdata('id'),
                                                'cs_is_replicated' => 1,
                                                'cs_is_deleted' => 0
                                            );
                                            $this->tuitionsmodel->addStudentBookings($insertBooking);
                                        }
                                    } else
                                        array_push($messageArray, "No students available in the campus for class " . $class_name . ".");
                                    // assigned teachers for class
                                    $classTeachers = $this->tuitionsmodel->getClassTeachers($org_class_id, $contractTeacherNotAvailable);
                                    if ($classTeachers) {
                                        foreach ($classTeachers as $teacher) {
                                            $insertTeacher = array(
                                                'cl_teacher_id' => $teacher['cl_teacher_id'],
                                                'cl_class_id' => $classId,
                                                'cl_from_time' => $teacher['cl_from_time'],
                                                'cl_to_time' => $teacher['cl_to_time'],
                                                'cl_created_on' => date("Y-m-d H:i:s"),
                                                'cl_is_deleted' => 0,
                                                'cl_is_replicated' => 1,
                                                'cl_created_by' => $this->session->userdata('id')
                                            );
                                            $this->tuitionsmodel->addTeacherToClass($insertTeacher);
                                        }
                                    }
                                }
                            }
                            array_push($messageArray, "All data is replicated to next day successfully.");
                            $resultFlag = 1;
                        } else {
                            array_push($messageArray, "Not allowed, Insufficient teachers or per day teaching hours.");
                        }
                    } else {
                        array_push($messageArray, "Not allowed, Teachers not assigned for today's activities.");
                    }
                    //            }
                    //            else{
                    //                array_push($messageArray,"Rooms are not available for the next day.");
                    //            }
                } else {
                    array_push($messageArray, "There is no class to replicate.");
                }
            } else {
                $numberOfNextDayClasses = count($nextDayClasses);
                if ($numberOfNextDayClasses > 1)
                    array_push($messageArray, "Already there are " . $numberOfNextDayClasses . " classes existing on date " . date("d/m/Y", strtotime($nextDate)) . ".");
                else
                    array_push($messageArray, "Already there is a class exist on date " . date("d/m/Y", strtotime($nextDate)) . ".");
                $resultFlag = 2;
            }

            $strMessage = "";
            foreach ($messageArray as $message) {
                $strMessage .= $message . "\n";
            }

            $returnArray['message'] = $strMessage;
            $returnArray['cellId'] = strtotime($nextDate);
            $returnArray['status'] = $resultFlag;

            echo json_encode($returnArray);
        }

        /**
         * update language knowledge for students. 
         */
        function updatelang() {
            if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                if (empty($_POST)) {
                    $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
                    $studentsList = $this->tuitionsmodel->getAllStudents($campusId);
                    $data['studentsList'] = $studentsList;
                    $data['title'] = "plus-ed.com | Language knowledge";
                    $data['breadcrumb1'] = 'Tuition';
                    $data['breadcrumb2'] = 'Language knowledge';
                    if (APP_THEME == "OLD")
                        $this->load->view('tuition/plused_language_knowledge', $data);
                    else { // if(APP_THEME == "LTE")
                        $data['pageHeader'] = $data['breadcrumb2'];
                        $data['optionalDescription'] = "";
                        $this->ltelayout->view('lte/backoffice/tuition/coursedirector/language_knowledge', $data);
                    }
                } else {
                    $uuid = $this->input->post('uuid');
                    $action = $this->input->post('action');
                    $knowledgeLang = $this->input->post('knowledge_lang');
                    $result = $this->tuitionsmodel->updateLanguageKnowledge($action, $uuid, $knowledgeLang);
                    echo json_encode(array('result' => $result, 'message' => ''));
                    exit();
                }
            } else {
                $this->session->sess_destroy();
                redirect('backoffice', 'refresh');
            }
        }

        /**
         * search listing of language knowledge for course director 
         */
        function searchlangknowledgeajax() {
            $keyword = $this->input->post('keyword');
            $txtCalFromDate = $this->input->post('campfrom');
            $txtCalToDate = $this->input->post('campto');

            if (!empty($txtCalFromDate) && !empty($txtCalToDate)) {
                $txtCalFromDate = explode('/', $txtCalFromDate);
                $txtCalToDate = explode('/', $txtCalToDate);

                if (array_key_exists(2, $txtCalFromDate))
                    ;
                $txtCalFromDate = $txtCalFromDate[2] . '-' . $txtCalFromDate[1] . '-' . $txtCalFromDate[0];

                if (array_key_exists(2, $txtCalToDate))
                    ;
                $txtCalToDate = $txtCalToDate[2] . '-' . $txtCalToDate[1] . '-' . $txtCalToDate[0];
            }

            $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
            $studentsList = $this->tuitionsmodel->getAllStudents($campusId, $keyword, $txtCalFromDate, $txtCalToDate);
            if ($studentsList) {
                if (APP_THEME == 'OLD') {
                    ?><table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"bFilter":false,"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>								
                                <th>Nationality</th>								
                                <th>Booking Id</th>
                                <th>Campus arrival</th>
                                <th>Campus departure</th>
                                <th id="sortLK" style="border-right:none;">Language knowledge</th>
                                <th style="display: none;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($studentsList as $student) {
                                ?>
                                <tr>
                                    <td class="center">
                                        <?php
                                        if (empty($student["nome"]) && empty($student["cognome"]))
                                            echo '-';
                                        else
                                            echo html_entity_decode($student["nome"] . ' ' . $student["cognome"]);
                                        ?>
                                    </td>
                                    <td class="center"><?php echo date_diff(date_create($student["pax_dob"]), date_create('today'))->y; ?></td>
                                    <td class="center"><?php echo (empty($student["nazionalita"]) ? '-' : $student["nazionalita"]); ?></td>
                                    <td class="center"><?php echo $student["id_book"] . '_' . $student["id_year"]; ?></td>
                                    <td class="center"><?php echo date('d/m/Y', strtotime($student["data_arrivo_campus"])); ?></td>
                                    <td class="center"><?php echo date('d/m/Y', strtotime($student["data_partenza_campus"])); ?></td>

                                    <td class="center" id="td_<?php echo $student["uuid"]; ?>" style="text-align:right;border-right:none;display: none;"><?php echo (!empty($student["lk_lang_knowledge"]) ? $student["lk_lang_knowledge"] : 0); ?></td>
                                    <td class="center operation" >
                                        <input style="width:40px;text-align: center;" type="text" class="updatelang form-control" data-type="lang_knowledge" data-uuid="<?php echo $student["uuid"]; ?>" id="txt_lang_knowledge<?php echo $student["uuid"]; ?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo (!empty($student["lk_lang_knowledge"]) ? $student["lk_lang_knowledge"] : 0); ?>" />
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }
                else {
                    ?>
                    <table class="datatable table table-bordered table-striped vertical-middle" style="width:99.98%;" >
                        <thead>
                            <tr>
                                <th >Name</th>
                                <th>Age</th>								
                                <th>Nationality</th>								
                                <th>Booking Id</th>
                                <th>Campus arrival</th>
                                <th>Campus departure</th>
                                <th class="col-text-numeric">Listening &<br/> comprehension</th>
                                <th class="col-text-numeric">Oral test</th>
                                <th class="col-text-numeric">Student <br />test score</th>
                                <th class="col-text-numeric">Language knowledge</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($studentsList)
                                foreach ($studentsList as $student) {
                                    ?>
                                    <tr>
                                        <td  >
                                            <?php
                                            if (empty($student["nome"]) && empty($student["cognome"]))
                                                echo '-';
                                            else
                                                echo html_entity_decode($student["nome"] . ' ' . $student["cognome"]);
                                            ?>
                                        </td>
                                        <td  ><?php echo date_diff(date_create($student["pax_dob"]), date_create('today'))->y; ?></td>
                                        <td  ><?php echo (empty($student["nazionalita"]) ? '-' : $student["nazionalita"]); ?></td>
                                        <td  ><?php echo $student["id_book"] . '_' . $student["id_year"]; ?></td>
                                        <td  ><?php echo date('d/m/Y', strtotime($student["data_arrivo_campus"])); ?></td>
                                        <td  ><?php echo date('d/m/Y', strtotime($student["data_partenza_campus"])); ?></td>
                                        <td class="text-center">
                                            <input style="width:40px;text-align: center;" type="text" class="updatelang form-control" data-type="listening_comprehension" data-uuid="<?php echo $student["uuid"]; ?>" id="txt_listening_comprehension<?php echo $student["uuid"]; ?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo (!empty($student["lk_listening_comprehension"]) ? $student["lk_listening_comprehension"] : 0); ?>" />
                                        </td>
                                        <td class="text-center">
                                            <input style="width:40px;text-align: center;" type="text" class="updatelang form-control" data-type="oral_test" data-uuid="<?php echo $student["uuid"]; ?>" id="txt_oral_test<?php echo $student["uuid"]; ?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo (!empty($student["lk_oral_test"]) ? $student["lk_oral_test"] : 0); ?>" />
                                        </td>
                                        <td class="text-center">
                                            <?php if (isset($student['ts_id']) && !empty($student['ts_id'])) { ?>
                                                <input style="width:40px;text-align: center;" disabled="disabled" type="text" class="form-control" id="txt_english_test_score<?php echo $student["uuid"]; ?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo (!empty($student["lk_english_test_score"]) ? $student["lk_english_test_score"] : 0); ?>" />
                                            <?php } else { ?>
                                                <input style="width:40px;text-align: center;" type="text" class="form-control updateTestMarks" id="txt_english_test_score<?php echo $student["uuid"]; ?>" data-id="<?php echo $student["uuid"]; ?>" autocomplete="off" maxlength="2" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo (!empty($student["lk_english_test_score"]) ? $student["lk_english_test_score"] : 0); ?>" />
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <input style="width:50px;text-align: center;"  disabled="disabled" type="text" class="form-control" id="txt_lang_knowledge<?php echo $student["uuid"]; ?>" autocomplete="off" maxlength="3" onkeypress="return keyRestrict(event, '1234567890');" value="<?php echo (!empty($student["lk_lang_knowledge"]) ? $student["lk_lang_knowledge"] : 0); ?>" />
                                        </td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }
            } else {
                if (APP_THEME == 'OLD') {
                    ?><p style="padding-left:8px;">No record(s) found.</p><?php
                } else {
                    ?><p >No record(s) found.</p><?php
                }
            }
        }

        function getTestedStudentsCount($date, $campusId) {
            return $this->tuitionsmodel->getStudentsLangKnowledgeCount($date, $campusId);
        }

        function getTobeTestedStudentsCount($date, $campusId) {
            return $this->tuitionsmodel->getStudentsLangKnowledgeCount($date, $campusId, FALSE);
        }

        function getLeavingTomorrowStudentsCount($date, $campusId) {
            return $this->tuitionsmodel->getStudentsLangKnowledgeCount($date, $campusId, FALSE, TRUE);
        }

        /**
         * getStudentsStats
         * this function is used to fetch 
         * TESTED STUDENTS COUNT
         * STUDENTS TO BE TESTED
         * STUDENTS LEAVING TOMORROW
         * @param date $date
         * @param int $campusId
         * @return row 
         */
        function getStudentsStats($date, $campusId) {
            return $this->tuitionsmodel->getStudentsStats($date, $campusId);
        }

        function getStatsStudentsList() {
            if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                $uuids = $this->input->post('uuidsStr');
                $classDate = $this->input->post('classDate');
                $campusId = $this->input->post('campusId');

                $studentsList = $this->tuitionsmodel->getStudentsByUuids($uuids, $classDate, $campusId);
                $courseHours = 0;
                if ($studentsList) {
                    $dataTime = time();
                    if (APP_THEME == "OLD") {
                        ?>
                        <table class="statsStdTable styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[2,"desc"]],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true}]}'>
                        <?php } else { ?>
                            <table id="statsStdTable" class="table table-bordered table-striped vertical-middle" style="width:99.98%;">
                            <?php } ?>
                            <thead>
                                <tr>
                                    <th>Student name</th>
                                    <th>Course</th>
                                    <th>Class level</th>
                                    <th>Room id</th>
                                    <th>Language knowledge</th>
                                    <th>Age</th>
                                    <th>Nationality</th>
                                    <th>Booking Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($studentsList as $student) {
                                    $courseHours = $student['course_hours'];
                                    $studentsDateOfBirth = $student['pax_dob'];
                                    $stdAge = "--";
                                    if ($studentsDateOfBirth != "00-00-00 00:00:00" && $studentsDateOfBirth != '')
                                        $stdAge = date_diff(date_create($studentsDateOfBirth), date_create('today'))->y;
                                    ?>
                                    <tr >
                                        <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo $student['nome'] . ' ' . $student['cognome']; ?></td>
                                        <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo $student['cc_course_name']; ?></td>
                                        <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo empty($student['class_name']) ? '' : $student['class_name'] . ' #' . $student['class_id']; ?></td>
                                        <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo $student['class_room_number'] ?></td>
                                        <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo $student['lk_lang_knowledge']; ?></td>
                                        <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo $stdAge; ?></td>
                                        <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo ucwords($student['nazionalita']); ?></td>
                                        <td style="background-color: <?php echo getStudentListColor($student['lk_lang_knowledge']); ?>"><?php echo $student['id_year'] . '_' . $student['id_book']; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?></tbody></table>
                        <?php
                    }
                    else {
                        ?>
                        <span>No students available for selected date.</span>
                        <?php
                    }
                } else {
                    $this->session->sess_destroy();
                    redirect('backoffice', 'refresh');
                }
            }

            function _updatenationalityflags() {
                $resultData = $this->db->get('plused_nationality');
                if ($resultData) {
                    $dir = './img/flags/16/';
                    $NATIONALITY_FILES_PATH = "./img/flags/nationality/";
                    if (!file_exists($NATIONALITY_FILES_PATH)) {
                        mkdir($NATIONALITY_FILES_PATH, 0755, true);
                    }
                    $files = scandir($dir);
                    $stop = 0;
                    //echo "<pre>"; print_r($files);die;
                    foreach ($resultData->result_array() as $nationality) {
                        $nationalityText = $nationality['nationality'];
                        $possibleNationalityName = substr($nationalityText, 0, 4);
                        foreach ($files as $key => $value) {
                            $possibleFileName = substr($value, 0, 4);
                            if ($possibleNationalityName == $possibleFileName) {
                                //echo $nationalityText .":".$value."<br />";
                                $destinationFile = str_replace(' ', '_', strtolower($value));
                                copy($dir . $value, $NATIONALITY_FILES_PATH . $destinationFile);
                                $this->db->flush_cache();
                                $this->db->where('nat_id', $nationality['nat_id']);
                                $updateArr = array(
                                    'nat_flag' => $destinationFile
                                );
                                $this->db->update('plused_nationality', $updateArr);
                            }
                        }
//                if($stop > 10)
//                    exit();
//                $stop++;
                    }
                    echo "coppied!";
                }
            }

            function teachersreview() {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) 
                {
                    $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
                    $this->load->model("tuition/contractmodel", "contractmodel");
                    $data['teachersData'] = $this->contractmodel->getTeachersDataForCD($campusId);
                    $data['title'] = "plus-ed.com | Teachers review";
                    $data['breadcrumb1'] = 'Tuition';
                    $data['breadcrumb2'] = 'Teachers review';

                    if (APP_THEME == "OLD")
                        $this->load->view('tuition/plused_cd_teachers_review', $data);
                    else { // if(APP_THEME == "LTE")
                        $data['pageHeader'] = $data['breadcrumb2'];
                        $data['optionalDescription'] = "";
                        $this->ltelayout->view('lte/backoffice/tuition/coursedirector/teachers_review', $data);
                    }
                } else {
                    $this->session->sess_destroy();
                    redirect('backoffice', 'refresh');
                }
            }

            function teacherrating() {
                $this->load->model("tuition/contractmodel", "contractmodel");
                $contractId = $this->input->post('cont_id');
                $teacherApplicationId = $this->input->post('teach_id');
                $stars = $this->input->post('r_stars');
                $review = $this->input->post('review');
                if (!empty($contractId) && !empty($teacherApplicationId) && !empty($review)) {
                    $result = $this->contractmodel->addContractReview($contractId, $teacherApplicationId, $stars, $review);
                    if ($result)
                        echo json_encode(array("result" => 1, "message" => "Review added successfully."));
                    else
                        echo json_encode(array("result" => 0, "message" => "Unable to add review."));
                }
                else {
                    echo json_encode(array("result" => 0, "message" => "Please enter review text."));
                }
            }

            function getteacherreview() {
                $this->load->model("tuition/contractmodel", "contractmodel");
                $contractId = $this->input->post('cont_id');
                $teacherApplicationId = $this->input->post('teach_id');
                if (!empty($contractId) && !empty($teacherApplicationId)) {
                    $result = $this->contractmodel->getTeacherReview($contractId, $teacherApplicationId);
                    if ($result)
                        echo json_encode(array("result" => 1, "dataset" => $result));
                    else
                        echo json_encode(array("result" => 0, "message" => ""));
                }
                else {
                    echo json_encode(array("result" => 0, "message" => ""));
                }
            }

            function ajaxFilterCDTeachersReview() {
                if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                    $campusId = $this->session->userdata('sess_campus_id'); // GET THE CAMPUS ID IF AVAILABLE.
                    $this->load->model("tuition/contractmodel", "contractmodel");

                    $keyword = $this->input->post('keyword');
                    $txtCalFromDate = $this->input->post('fromDate');
                    $txtCalToDate = $this->input->post('toDate');

                    if (!empty($txtCalFromDate) && !empty($txtCalToDate)) {
                        $txtCalFromDate = explode('/', $txtCalFromDate);
                        $txtCalToDate = explode('/', $txtCalToDate);
                        if (array_key_exists(2, $txtCalFromDate))
                            ;
                        $txtCalFromDate = $txtCalFromDate[2] . '-' . $txtCalFromDate[1] . '-' . $txtCalFromDate[0];
                        if (array_key_exists(2, $txtCalToDate))
                            ;
                        $txtCalToDate = $txtCalToDate[2] . '-' . $txtCalToDate[1] . '-' . $txtCalToDate[0];
                    }

                    $teachersData = $this->contractmodel->getTeachersDataForCD($campusId, $keyword, $txtCalFromDate, $txtCalToDate);
                    if ($teachersData) {
                        if (APP_THEME == "OLD") {
                            ?>
                            <table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"bRetrieve": true, "bDestroy": true, "bFilter":false, "aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
                                <thead>
                                    <tr>
                                        <th>Teacher</th>
                                        <th>Date of birth</th>
                                        <th>From Date</th>								
                                        <th>To date</th>
                                        <th>Review & rating</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($teachersData)) {
                                        foreach ($teachersData as $contract) {
                                            ?>
                                        <div style="display: none;" id="dialog_modal_<?php echo $contract["joc_id"] ?>" title="Teacher detail - <?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?>" class="windia"> 
                                            <div class="box">
                                                <div class="header">
                                                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Teacher details as per contract</span></h2>
                                                </div>
                                                <div class="content">
                                                    <div class="detailContainer">
                                                        <div class="clr">
                                                            <div class="grid_3"><strong>Name:</strong></div>
                                                            <div class="grid_3"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></div>

                                                            <div class="grid_3"><strong>Email:</strong></div>
                                                            <div class="grid_3"><?php echo $contract["joc_email"]; ?></div>
                                                        </div>
                                                        <div class="clr">
                                                            <div class="grid_3"><strong>Campus:</strong></div>
                                                            <div class="grid_3"><?php echo $contract["nome_centri"]; ?></div>

                                                            <div class="grid_3"><strong>Position:</strong></div>
                                                            <div class="grid_3"><?php echo $contract["pos_position"]; ?></div>
                                                        </div>
                                                        <div class="clr">
                                                            <div class="grid_3"><strong>From date:</strong></div>
                                                            <div class="grid_3"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></div>

                                                            <div class="grid_3"><strong>To date:</strong></div>
                                                            <div class="grid_3"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></div>
                                                        </div>
                                                        <div class="clr">
                                                            <div class="grid_3"><strong>Hours per week:</strong></div>
                                                            <div class="grid_3"><?php echo $contract["joc_hourperweek_range"]; ?></div>

                                                            <div class="grid_3"><strong>Date of birth:</strong></div>
                                                            <div class="grid_3"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box">
                                                <div class="header">
                                                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Interview details</span></h2>
                                                </div>
                                                <div class="content">
                                                    <div class="detailContainer">
                                                        <div class="clr">
                                                            <div class="grid_3"><strong>Interview notes:</strong></div>
                                                            <div class="grid_9"><?php echo htmlentities($contract['ta_interview_notes']); ?></div>
                                                        </div>
                                                        <div class="clr">
                                                            <div class="grid_3"><strong>Interview strong:</strong></div>
                                                            <div class="grid_9"><?php echo htmlentities($contract['ta_interview_strong']); ?></div>
                                                        </div>
                                                        <div class="clr">
                                                            <div class="grid_3"><strong>Interview weak:</strong></div>
                                                            <div class="grid_9"><?php echo htmlentities($contract['ta_interview_weak']); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <tr>
                                            <td class="center"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></td>
                                            <td class="center"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></td>
                                            <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></td>
                                            <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></td>
                                            <td class="center"><div class="viewStar" id="viewfor_<?php echo $contract['joc_id']; ?>" data-star="<?php echo $contract['rat_stars']; ?>"></div></td>
                                            <td class="center operation">
                                                <a title="View" href="javascript:void(0);" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" data-id="dialog_modal_btn_<?php echo $contract["joc_id"]; ?>" class="dialogbtn">
                                                    <span class="icon-eye-open"></span>
                                                </a>
                                                <a title="Review & rating" href="javascript:void(0);" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" class="dialogstar">
                                                    <span class="icon-star-empty"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <table class="datatable table table-bordered table-striped vertical-middle" style="width:99.98%;" >
                                <thead>
                                    <tr>
                                        <th>Teacher</th>
                                        <th>Date of birth</th>
                                        <th>From Date</th>								
                                        <th>To date</th>
                                        <th>Review & rating</th>
                                        <th class="no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($teachersData)) {
                                        foreach ($teachersData as $contract) {
                                            ?>
                                        <div style="display: none;" id="dialog_modal_<?php echo $contract["joc_id"] ?>" title="<?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?>" > 
                                            <div class="modal-header">
                                                <h4><span class="modalTitle" >Teacher details as per contract</span>
                                                    <button aria-label="Close" onclick="$('#dialog_modal_teacher').modal('hide');" class="close" type="button">
                                                        <span aria-hidden="true">×</span></button>
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-3"><strong>Name:</strong></div>
                                                    <div class="col-sm-3"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></div>

                                                    <div class="col-sm-3"><strong>Email:</strong></div>
                                                    <div class="col-sm-3"><?php echo $contract["joc_email"]; ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3"><strong>Campus:</strong></div>
                                                    <div class="col-sm-3"><?php echo $contract["nome_centri"]; ?></div>

                                                    <div class="col-sm-3"><strong>Position:</strong></div>
                                                    <div class="col-sm-3"><?php echo $contract["pos_position"]; ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3"><strong>From date:</strong></div>
                                                    <div class="col-sm-3"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></div>

                                                    <div class="col-sm-3"><strong>To date:</strong></div>
                                                    <div class="col-sm-3"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3"><strong>Hours per week:</strong></div>
                                                    <div class="col-sm-3"><?php echo $contract["joc_hourperweek_range"]; ?></div>

                                                    <div class="col-sm-3"><strong>Date of birth:</strong></div>
                                                    <div class="col-sm-3"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></div>
                                                </div>
                                            </div>

                                            <div class="modal-header">
                                                <h4 class="modal-title"><span>Interview details</span></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-3"><strong>Interview notes:</strong></div>
                                                    <div class="col-sm-9"><?php echo htmlentities($contract['ta_interview_notes']); ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3"><strong>Interview strong:</strong></div>
                                                    <div class="col-sm-9"><?php echo htmlentities($contract['ta_interview_strong']); ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3"><strong>Interview weak:</strong></div>
                                                    <div class="col-sm-9"><?php echo htmlentities($contract['ta_interview_weak']); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <tr>
                                            <td class="center"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></td>
                                            <td class="center"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></td>
                                            <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></td>
                                            <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></td>
                                            <td class="center"><div class="viewStar" id="viewfor_<?php echo $contract['joc_id']; ?>" data-star="<?php echo $contract['rat_stars']; ?>"></div></td>
                                            <td class="center operation">
                                                <a title="View" href="javascript:void(0);" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" data-id="dialog_modal_btn_<?php echo $contract["joc_id"]; ?>" class="min-wd-24 dialogbtn btn btn-xs btn-primary">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a title="Review & rating" href="javascript:void(0);" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" class="dialogstar min-wd-24 btn btn-xs btn-primary">
                                                    <i class="fa fa-star-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <?php
                        }
                    } else {
                        ?>
                        <p>
                            Record(s) not found.
                        </p>
                        <?php
                    }
                } else {
                    $this->session->sess_destroy();
                    echo "User session expired.";
                }
            }

        }

        /* End of file tuitions.php */