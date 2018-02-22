<?php
class Tuitionsreports extends Controller {

    public function __construct() {

        parent::Controller();
        // check user session and menus with their access.
        authSessionMenu($this,true); // second param is true only checks for controller access not methods
        $this->load->helper(array('form', 'url'));
        $this->load->library('session', 'email', 'excel');
        $this->load->model('mbackoffice');
        $this->load->model("tuition/campuscoursemodel", "campuscoursemodel");
        $this->load->model("tuition/tuitionsmodel", "tuitionsmodel");
        $this->load->model("tuition/tuitionreportsmodel", "tuitionreportsmodel");
    }

    /**
    * index
    * This is default function to load tuition reports
    * @author SK
    * @since 16-Dec-2015
    */
    function index($fd = "",$td = "") {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {

            $data['calFromDate'] = date("d-m-Y");
            $data['calToDate'] =  date('d-m-Y', strtotime($data['calFromDate']. ' + 15 days'));
            if(!empty($fd) && !empty($td)){
                if($this->_validateDate($fd) && $this->_validateDate($td))
                {
                    $data['calFromDate'] = $fd;
                    $data['calToDate'] =  $td;
                }
            }
            $data["centri"] = $this->campuscoursemodel->getCampusList();
            $data['title']='plus-ed.com | Tuition reports';
            $data['breadcrumb1'] = 'Tuition';
            $data['breadcrumb2']='Tuition reports';
            if(APP_THEME == "OLD")
                $this->load->view('tuition/plused_tuitionsreports',$data);
            else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = "Overview tuitions schedule";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/tuition/reports', $data);
            }
            
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function getCampusTeachersCheckList() {
        $campusTeachers = array();
        try {
            if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                $campusIds = $this->input->post('campuses');
                $campusTeachers = $this->tuitionreportsmodel->getCampusTeachers($campusIds);

                if($campusTeachers){
                    foreach($campusTeachers as $teacher)
                    {
                ?>
                    <input class="chCourse" checked="checked" type="checkbox" name="teachers[]" id="chkTeacher_<?php echo $teacher['teach_id'];?>" value="<?php echo $teacher['teach_id'];?>">
                    <span><?php echo $teacher['teach_first_name']." ".$teacher['teach_last_name'];?></span><br />
                <?php
                    }
                }
            }
            else
                echo "User session is expired.";
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * getCampusCourses
     * this function is used to list campus courses
     */
    function getCampusCourses() {
        $campusCourses = array();
        try {
            if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                $campusIds = $this->input->post('campuses');
                $campusCourses = $this->tuitionsmodel->getCampusCourses($campusIds);
                if($campusCourses){
                    foreach($campusCourses as $course)
                    {
                ?>
                    <div class="grid_3">
                    <input class="chCourse" autocomplete="off" checked="checked" type="checkbox" name="courses[]" id="chkClass_<?php echo $course['class_campus_course_id'];?>" value="<?php echo $course['class_campus_course_id'];?>">
                    <label for ="chkClass_<?php echo $course['class_campus_course_id'];?>" class="normal"><?php echo $course['cc_course_name'];?></label>
                    </div>
                <?php
                    }
                }
            }
            else
                echo "User session is expired.";
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    function bookingExists(){
	if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $id_book = $this->input->post('idSearch');
            $bkgExists = 0;
            $bkgExists = $this->tuitionreportsmodel->bookingExists($id_book);
            echo $bkgExists;
	}else{
            redirect('backoffice','refresh');
	}
    }

    function view()
    {
        try {
            if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                if(!empty($_POST))
                {
                    $fd = $this->input->post('fd');
                    if(!empty($fd))
                    {
                        $fd = str_replace('/', '-', $fd);
                        $fd = date("Y-m-d",strtotime($fd));
                    }

                    $td = $this->input->post('td');
                    if(!empty($td))
                    {
                        $td = str_replace('/', '-', $td);
                        $td = date("Y-m-d",strtotime($td));
                    }
                    $campusIds = $this->input->post('campuses');
                    $teacherIds = $this->input->post('teachers');
                    $courseIds = $this->input->post('courses');
                    $reportParam = array("reportParam"=>array(
                        'fd' => $fd,
                        'td' => $td,
                        'campusIds' => $campusIds,
                        'teacherIds' => $teacherIds,
                        'courseIds' => $courseIds)
                    );

                    $this->session->set_userdata($reportParam);
                    $resultData = $this->tuitionreportsmodel->getTuitionReport($fd,$td,$campusIds,$teacherIds,$courseIds);
                    //$resultGraphData = $this->tuitionreportsmodel->getTuitionReportGraphStat($fd,$td,$campusIds,$teacherIds,$courseIds);
                    $data = array();
                    $data['fd'] = $this->input->post('fd');
                    $data['td'] = $this->input->post('td');

                    $data['resultData'] = $resultData;
                    $data['title']='plus-ed.com | Tuition reports';
                    $data['breadcrumb1'] = 'Tuition';
                    $data['breadcrumb2']='Tuition reports';

                    if(APP_THEME == "OLD")
                        $this->load->view('tuition/plused_view_report',$data);
                    else // if(APP_THEME == "LTE")
                    {
                        $data['pageHeader'] = "Tuition reports";
                        $data['optionalDescription'] = "";
                        $this->ltelayout->view('lte/backoffice/tuition/view_report', $data);
                    }
                }
                else
                    redirect('tuitionsreports');
            }
            else
                    redirect('tuitionsreports');

        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    function searchbooking($bookingId = 0){
        try {
            if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {

                $this->session->set_userdata('searchBookingId',$bookingId);
                $resultData = $this->tuitionreportsmodel->getTuitionReportForBooking($bookingId);

                $data = array();
                $data['fd'] = "";
                $data['td'] = "";
                $data['bookingId'] = $bookingId;

                $data['resultData'] = $resultData;
                $data['title']='plus-ed.com | Tuition reports';
                $data['breadcrumb1'] = 'Tuition';
                $data['breadcrumb2']='Tuition reports';

                //$this->load->view('tuition/plused_view_report',$data);
                if(APP_THEME == "OLD")
                    $this->load->view('tuition/plused_view_report',$data);
                else // if(APP_THEME == "LTE")
                {
                    $data['pageHeader'] = "Tuition reports";
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/tuition/view_report', $data);
                }
            }
            else
                    redirect('tuitionsreports');

        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    function countCampusCourses($dataArray,$campusId){
        $courseArrayForGraph = array();
        $classArrayForGraph = array();
        $countCampusStudents = 0;
        $countClassStudents = 0;
        $campusName = "";
        if(count($dataArray)){
            foreach($dataArray as $record){
                if($record['cc_campus_id'] == $campusId){
                    $campusName = $record['nome_centri'];
                    // courses
                    if(!array_key_exists($record['class_campus_course_id'], $courseArrayForGraph)){
                        $countCourseStudents = 0;
                        $countCourseStudents++;
                        $courseArrayForGraph[$record['class_campus_course_id']] = $countCampusStudents;
                    }
                    else
                    {
                        $countCourseStudents = $courseArrayForGraph[$record['class_campus_course_id']];
                        $countCourseStudents++;
                        $courseArrayForGraph[$record['class_campus_course_id']] = $countCourseStudents;
                    }
                    // class

                    if(!array_key_exists($record['class_id'], $classArrayForGraph)){
                        $countClassStudents = 0;
                        $countClassStudents++;
                        $classArrayForGraph[$record['class_id']] = $countClassStudents;

                    }
                    else
                    {
                        $countClassStudents = $classArrayForGraph[$record['class_id']];
                        $countClassStudents++;
                        $classArrayForGraph[$record['class_id']] = $countClassStudents;
                    }
                }
            }
        }

       return array(
            'campus'=>$campusName,
            'courses' => count($courseArrayForGraph),
            'classes' => count($classArrayForGraph),
            'students' => array_sum($classArrayForGraph)
       );
    }

    function toexcel($isBooking = ""){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $resultData = 0;
            if(empty($isBooking))
            {
                $reportParam = $this->session->userdata('reportParam');
                $fd = $reportParam['fd'];
                $td = $reportParam['td'];
                $campusIds = $reportParam['campusIds'];
                $teacherIds = $reportParam['teacherIds'];
                $courseIds = $reportParam['courseIds'];
                $resultData = $this->tuitionreportsmodel->getTuitionReport($fd,$td,$campusIds,$teacherIds,$courseIds);
            }
            else{
                $searchBookingId = $this->session->userdata('searchBookingId');
                $resultData = $this->tuitionreportsmodel->getTuitionReportForBooking($searchBookingId);
            }

            if($resultData)
            {
                $exportData = array();
                foreach($resultData as $record){
                    $exportRecord = array(
                        'Campus' => $record['nome_centri'],
                        'Course Name' => $record['cc_course_name'],
                        'Course Type' => $record['cc_course_type'],
                        'Class Name' => $record['class_name'],
                        'Class Room Number' => $record['class_room_number'],
                        'Class Date' => $record['class_date'],
                        'Booking Id' => $record['id_year']."_".$record['id_book'],
                        'Student' => $record['nome']." ".$record['cognome'],
                        'Nationality' => $record['nazionalita']
                    );
                    array_push($exportData, $exportRecord);
                }
                $this->load->library('export');
                $this->export->to_excel($exportData, 'tuition_schedule');
            }
            else
                redirect('tuitionsreports');
        }
        else
                redirect('tuitionsreports');
    }

    function classreport(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $campusId = $this->input->post('selCampus');
            $courseId = $this->input->post('selCourse');
            $classDate = $this->input->post('txtClassDate');

            $exportClass = array(
                'selCampus' => $campusId,
                'selCourse' => $courseId,
                'txtClassDate' => $classDate
                );

            $this->session->set_userdata(array('exportClass'=>$exportClass));

            $classDate = str_replace('/', '-', $classDate);
            $classDate = date("Y-m-d",strtotime($classDate));
            $resultData = $this->tuitionreportsmodel->getClassReport($courseId,$classDate);

            $data = array();
            $data['campusId'] = $campusId;
            $data['courseId'] = $courseId;
            $data['classDate'] = $this->input->post('txtClassDate');

            $data['resultData'] = $resultData;
            $data['title']='plus-ed.com | Class report';
            $data['breadcrumb1'] = 'Tuition';
            $data['breadcrumb2']='Class report';

            //$this->load->view('tuition/plused_class_report',$data);
            if(APP_THEME == "OLD")
                $this->load->view('tuition/plused_class_report',$data);
            else // if(APP_THEME == "LTE")
            {
                $data['pageHeader'] = "Class report";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/tuition/class_report', $data);
            }
        }
        else
                redirect('tuitionsreports');

    }

    function classreporttoexcel(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $exportClass = $this->session->userdata('exportClass');
            if(!empty($exportClass))
            {
                $campusId = $exportClass['selCampus'];
                $courseId = $exportClass['selCourse'];
                $classDate = $exportClass['txtClassDate'];
                $classDate = str_replace('/', '-', $classDate);
                $classDate = date("Y-m-d",strtotime($classDate));
                $resultData = $this->tuitionreportsmodel->getClassReport($courseId,$classDate);
                if($resultData)
                {
                    $exportData = array();
                    foreach($resultData as $record){
                        $exportRecord = array(
                            'Campus' => $record['nome_centri'],
                            'Course Name' => $record['cc_course_name'],
                            'Course Type' => $record['cc_course_type'],
                            'Class Name' => $record['class_name'],
                            'Class Room Number' => $record['class_room_number'],
                            'Class Date' => $record['class_date'],
                            'Booking Id' => $record['id_year']."_".$record['id_book'],
                            'Student' => $record['nome']." ".$record['cognome'],
                            'Nationality' => $record['nazionalita']
                        );
                        array_push($exportData, $exportRecord);
                    }
                    $this->load->library('export');
                    $this->export->to_excel($exportData, 'classreport');
                }
                else
                    redirect('tuitionsreports');
            }
        }
        else
            redirect('tuitionsreports');
    }

    /**
    * index
    * This is default function to load teachers reprots
    * @author SK
    * @since 20-Jan-2016
    */
    function teachers() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
           if(!empty($_POST))
            {
               if(isset($_POST['type'])){
                    $campusId = $this->input->post('campusId');
                    $teacherId = $this->input->post('teacherId');
                    $fd = $this->input->post('fd');
                    $fd = str_replace('/', '-', $fd);
                    $fd = date("Y-m-d",strtotime($fd));
                    $td = $this->input->post('td');
                    $td = str_replace('/', '-', $td);
                    $td = date("Y-m-d",strtotime($td));
                    $resultData = $this->tuitionreportsmodel->getTeacherReport($campusId,$teacherId,$fd,$td);
                    
                    if($resultData)
                    {
                        $exportData = array();
                        foreach($resultData as $record){
                            $exportRecord = array(
                                'Teacher' => $record['teach_first_name']." ".$record['teach_last_name'],
                                'Class Name' => $record['class_name'],
                                'Class Date' => $record['class_date'],
                                'From Time' => $record['cl_from_time'],
                                'To Time' => $record['cl_to_time'],
                                'Worked Time' => $record['worktime'],
                                'Course' => $record['cc_course_name'],
                                'Campus' => $record['nome_centri'],
                            );
                            array_push($exportData, $exportRecord);
                        }
                        //$this->load->helper('csv');
                        //array_to_csv_export($exportData,'teacher.csv');//die;
                        $this->load->library('export');
                        $this->export->to_excel($exportData, 'teacherreport');
                    }
                    else
                        redirect('tuitionsreports/teachers');
               }
               else
               {
                $campusId = $this->input->post('selCampus');
                $teacherId = $this->input->post('selTeacher');
                $fd = $this->input->post('fd');
                $fd = str_replace('/', '-', $fd);
                $fd = date("Y-m-d",strtotime($fd));
                $td = $this->input->post('td');
                $td = str_replace('/', '-', $td);
                $td = date("Y-m-d",strtotime($td));
                $resultData = $this->tuitionreportsmodel->getTeacherReport($campusId,$teacherId,$fd,$td);
                    $data = array();
                    $data['campusId'] = $campusId;
                    $data['teacherId'] = $teacherId;
                    $data['fd'] = $this->input->post('fd');
                    $data['td'] = $this->input->post('td');

                    $data['resultData'] = $resultData;
                    $data['title']='plus-ed.com | Teacher work report';
                    $data['breadcrumb1'] = 'Tuition';
                    $data['breadcrumb2']='Teacher work report';

                    if(APP_THEME == "OLD")
                        $this->load->view('tuition/plused_teacher_report',$data);
                    else // if(APP_THEME == "LTE")
                    {
                        $data['pageHeader'] = "Teacher work report";
                        $data['optionalDescription'] = "";
                        $this->ltelayout->view('lte/backoffice/tuition/teacher_report', $data);
                    }
               }
            }
            else
            {
                $data['calToDate'] =  date('d-m-Y');
                $data['calFromDate'] = date("d-m-Y",strtotime($data['calToDate']. ' - 15 days'));


                $data["centri"] = $this->campuscoursemodel->getCampusList();
                $data['title']='plus-ed.com | Teacher work report';
                $data['breadcrumb1'] = 'Tuition';
                $data['breadcrumb2']='Teacher work report';
                
                if(APP_THEME == "OLD")
                    $this->load->view('tuition/plused_teacherworkreports',$data);
                else // if(APP_THEME == "LTE")
                {
                    $data['pageHeader'] = "Overview teacher work";
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/tuition/teacherworkreports', $data);
                }
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function getCampusTeachers(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $campusId = $this->input->post('campusId');
            $teacherList = $this->tuitionsmodel->getCampusTeachersFromId($campusId);
            if($teacherList){
            ?>
                <select class="required" id="selTeacher" name="selTeacher"  >
                    <option value="">Select Teacher</option>
                    <?php if($teacherList){
                            foreach ($teacherList as $teacher){
                                ?><option value="<?php echo $teacher['teach_id'];?>"><?php echo $teacher['teach_fullname'];?></option><?php
                            }
                    }
                    ?>
                </select>
            <?php
            }
            else
            {
            ?>
                <select class="required" id="selTeacher" name="selTeacher"  >
                    <option value="">Select Teacher</option>
                </select>
            <?php
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    public function summary(){
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
           if(!empty($_POST))
            {
               if(isset($_POST['type'])){
                    $campusIds = $this->input->post('campuses');
                    $campusIds = explode(',', $campusIds);
                    $fd = $this->input->post('fd');
                    $fd = str_replace('/', '-', $fd);
                    $fd = date("Y-m-d",strtotime($fd));
                    $td = $this->input->post('td');
                    $td = str_replace('/', '-', $td);
                    $td = date("Y-m-d",strtotime($td));
                    $resultData = $this->tuitionreportsmodel->getTeacherSummaryReport($campusIds,$fd,$td);
                   // echo $this->db->last_query();die;
                    if($resultData)
                    {
                        $exportData = array();
                        foreach($resultData as $record){
                            
                            $salaryType = $record['joc_wages'];
                            $totalSalary = 0;
                            $totalGrossSalary = 0;
                            $totalWorkDays = 0;
                            $actualSalary = 0;
                            $actualSalaryDifference = 0;
                            if($salaryType == 'Hourly')
                            {
                                $totalSalary = $record['joc_salary'] * round($record['duration'],2);
                                $actualSalary = $record['joc_salary'] * round($record['actual_worked_hours'],2);
                                $totalGrossSalary = round(($actualSalary * 100)/112.07,2);
                                $actualSalaryDifference = $actualSalary - $totalGrossSalary;
                            }
                            elseif($salaryType == 'Weekly'){
                                $totalSalary = $record['joc_salary'];
                                $totalWorkDays = $record['actual_work_days'];
                                $dailySalary = $totalSalary / 5; // FIVE IS A WORKING DAYS IN WEEK.
                                $actualSalary = $dailySalary * $totalWorkDays;
                                $totalGrossSalary = round(($actualSalary * 100)/112.07,2);
                                $actualSalaryDifference = $actualSalary - $totalGrossSalary;
                            }
                            
                            $currency = $record['joc_currency'];
                            $currencySymbol = "";
                            if($currency == "EUR")
                                $currencySymbol = "€";
                            else if($currency == "GBP")
                                $currencySymbol = "£";
                            else if($currency == "USD")
                                $currencySymbol = "$";

                            $teacherDateOfBirth = "";
                            if(!empty($record['ta_date_of_birth']) && $record['ta_date_of_birth'] != '0000-00-00 00:00:00' )
                                $teacherDateOfBirth = date("d/m/Y", strtotime($record['ta_date_of_birth']));
                            if(!empty($record['ta_ablility_from']) && $record['ta_ablility_from'] != '0000-00-00 00:00:00' )
                                $abilityFrom = date("d/m/Y", strtotime($record['ta_ablility_from']));
                            if(!empty($record['ta_ablility_to']) && $record['ta_ablility_to'] != '0000-00-00 00:00:00' )
                                $abilityTo = date("d/m/Y", strtotime($record['ta_ablility_to']));
                            
                            $exportRecord = array(
                                'Campus' => $record['nome_centri'],
                                'Teacher' => $record['teach_first_name']." ".$record['teach_last_name'],
                                'Contract<br />Start Date' => $record["teach_from_date"],//date("d/m/Y",strtotime($record["teach_from_date"])),
                                'Contract<br />End Date' => $record["teach_to_date"],//date("d/m/Y",strtotime($record["teach_to_date"])),
                                'Contract<br />Hours per week' => $record['joc_hourperweek_range'],
                                'Total worked<br />Hours' => round($record['duration'],2),
                                'Actual worked<br />Hours(Present marked)' => round($record['actual_worked_hours'],2),
                                'Total worked<br />Days' => $record['total_work_days'],
                                'Actual worked<br />Days(Present marked)' => $record['actual_work_days'],
                                'Salary type' => $salaryType,
                                'Currency' => $currency,
                                'Salary rate' => $currencySymbol . $record['joc_salary'],
                                'Total salary' => $currencySymbol . $totalSalary,
                                'Actual salary<br />(As per rate)' => $currencySymbol . $actualSalary,
                                'Gross salary' => $currencySymbol . $totalGrossSalary,
                                'Holiday salary' => $currencySymbol . $actualSalaryDifference,
                                'Number of lesson' => $record['number_of_lesson'],
                                /*BANKS DETAILS
                                 * tbd_currency_type,tbd_account_name,tbd_sort_code,tbd_account_number,tbd_iban,tbd_swift_bic
                                 */
                                'Bank currency type' => $record['tbd_currency_type'],
                                'Account name' => $record['tbd_account_name'],
                                'Sort code' => $record['tbd_sort_code'],
                                'Account number' => $record['tbd_account_number'],
                                'IBAN' => $record['tbd_iban'],
                                'SWIFT/BIC' => $record['tbd_swift_bic'],
                                /*
                                 * TEACHER PERSONAL DETAILS
                                 * ta_date_of_birth,ta_nationality,ta_sex,ta_email,ta_telephone,
                                 * ta_address,ta_city,ta_postcode,ta_country,ta_teach_years,
                                 * ta_ablility_from,ta_ablility_to,ta_skype
                                 * ta_ni_number,ta_right_to_work_uk,ta_ni_category,ta_making_slr,
                                 * ta_slr_plan,ta_p45_status,ta_p45_starter_declaration,
                                 */
                                'Date of birth' => $teacherDateOfBirth,
                                'Nationality' => ucwords($record['ta_nationality']),
                                'Gender' => $record['ta_sex'],
                                'Email' => $record['ta_email'],
                                'Telephone' => $record['ta_telephone'],
                                'Address' => $record['ta_address'],
                                'City' => $record['ta_city'],
                                'Postcode' => $record['ta_postcode'],
                                'Country' => $record['ta_country'],
                                'Teach Years' => $record['ta_teach_years'],
                                'Ability from' => $abilityFrom,
                                'Ability to' => $abilityTo,
                                'Skype name' => $record['ta_skype'],
                                'Ni Number' => $record['ta_ni_number'],
                                'Right to work in UK' => ($record['ta_right_to_work_uk'] ? 'Yes' : 'No'),
                                'NI Category' => $record['ta_ni_category'],
                                'Student Loan Repayments' => ($record['ta_making_slr'] ? 'Yes' : 'No'),
                                'SLR Plan' => $record['ta_slr_plan'],
                                'Provide a P45' => ($record['ta_p45_status'] ? 'Yes' : 'No'),
                                'Starter Declaration(no P45 A/B/C)' => $record['ta_p45_starter_declaration'],
                            );
                            array_push($exportData, $exportRecord);
                        }
                        //$this->load->helper('csv');
                        //array_to_csv_export($exportData,'teacher_summary_report.csv');//die;
                        $this->load->library('export');
                        //$this->export->to_excel($exportData, 'teacher_summary_report');
                        $dateCols = array("Contract<br />Start Date","Contract<br />End Date");
                        $this->export->exportUsingPhpExcel($exportData, 'teacher_summary_report',$dateCols);
                    }
                    else
                        redirect('tuitionsreports/summary');
               }
               else
               {
                    $campusIds = $this->input->post('campuses');
                    $fd = $this->input->post('fd');
                    $fd = str_replace('/', '-', $fd);
                    $fd = date("Y-m-d",strtotime($fd));
                    $td = $this->input->post('td');
                    $td = str_replace('/', '-', $td);
                    $td = date("Y-m-d",strtotime($td));
                    $resultData = $this->tuitionreportsmodel->getTeacherSummaryReport($campusIds,$fd,$td);
                    
                    $data = array();
                    $data['campusIds'] = $campusIds;
                    $data['fd'] = $this->input->post('fd');
                    $data['td'] = $this->input->post('td');

                    $data['resultData'] = $resultData;
                    $data['title']='plus-ed.com | Teacher work summary report';
                    $data['breadcrumb1'] = 'Tuition';
                    $data['breadcrumb2']='Teacher work summary report';

                    if(APP_THEME == "OLD")
                        $this->load->view('tuition/plused_teacher_summary_report',$data);
                    else // if(APP_THEME == "LTE")
                    {
                        $data['pageHeader'] = "Teacher work summary report";
                        $data['optionalDescription'] = "";
                        $this->ltelayout->view('lte/backoffice/tuition/teacher_summary_report', $data);
                    }
               }
            }
            else
            {
                redirect('tuitionsreports/teachers');
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function students()
    {
        try {
            if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
                if(!empty($_POST))
                {
                    $fd = $this->input->post('fd');
                    if(!empty($fd))
                    {
                        $fd = str_replace('/', '-', $fd);
                        $fd = date("Y-m-d",strtotime($fd));
                    }

                    $td = $this->input->post('td');
                    if(!empty($td))
                    {
                        $td = str_replace('/', '-', $td);
                        $td = date("Y-m-d",strtotime($td));
                    }
                    $campusIds = $this->input->post('campuses');
                    if(!empty($campusIds))
                        $campusIds = explode (',', $campusIds);
                    $courseIds = $this->input->post('courses');
                    if(!empty($courseIds))
                        $courseIds = explode (',', $courseIds);
                    $resultData = $this->tuitionreportsmodel->getTuitionStudentsReport($fd,$td,$campusIds,$courseIds);
                    if(isset($_POST['type'])){
                            if($resultData)
                            {
                                $exportData = array();
                                foreach($resultData as $record){
                                    $exportRecord = array(
                                        'Campus' => $record["nome_centri"],
                                        'Course' => $record["cc_course_name"],
                                        'Student' => $record['nome']." ".$record['cognome'],
                                        'Student course hours<br />conducted' => round($record["studentCourseHours"],2),
                                        'Booking Id' => $record['id_year']."_".$record['id_book'],
                                        'Nationality' => ucwords($record['nazionalita'])
                                    );
                                    array_push($exportData, $exportRecord);
                                }
                                //$this->load->helper('csv');
                                //array_to_csv_export($exportData,'teacher_summary_report.csv');//die;
                                $this->load->library('export');
                                $this->export->to_excel($exportData, 'student_summary_report');
                            }
                            else
                            {
                                $data = array();
                                $data['campuses'] = $this->input->post('campuses');
                                $data['courses'] = $this->input->post('courses');
                                $data['fd'] = $this->input->post('fd');
                                $data['td'] = $this->input->post('td');

                                $data['resultData'] = $resultData;
                                $data['title'] = 'plus-ed.com | Tuition student summary report';
                                $data['breadcrumb1'] = 'Tuition';
                                $data['breadcrumb2'] = 'Tuition student summary report';
                                $data['error_message'] = 'No records to export.';
                                $data['success_message'] = '';
                         //       $this->load->view('tuition/plused_student_summary_report',$data);
                                if(APP_THEME == "OLD")
                                    $this->load->view('tuition/plused_student_summary_report',$data);
                                else // if(APP_THEME == "LTE")
                                {
                                    $data['pageHeader'] = "Tuition student summary report";
                                    $data['optionalDescription'] = "";
                                    $this->ltelayout->view('lte/backoffice/tuition/student_summary_report', $data);
                                }
                            }
                    }
                    else
                    {
                        $data = array();
                        $data['campuses'] = $this->input->post('campuses');
                        $data['courses'] = $this->input->post('courses');
                        $data['fd'] = $this->input->post('fd');
                        $data['td'] = $this->input->post('td');

                        $data['resultData'] = $resultData;
                        $data['title'] = 'plus-ed.com | Tuition student summary report';
                        $data['breadcrumb1'] = 'Tuition';
                        $data['breadcrumb2'] = 'Tuition student summary report';

                        if(APP_THEME == "OLD")
                            $this->load->view('tuition/plused_student_summary_report',$data);
                        else // if(APP_THEME == "LTE")
                        {
                            $data['pageHeader'] = "Tuition student summary report";
                            $data['optionalDescription'] = "";
                            $this->ltelayout->view('lte/backoffice/tuition/student_summary_report', $data);
                        }
                    }
                }
                else
                    redirect('tuitionsreports');
            }
            else
                    redirect('tuitionsreports');

        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
}

/* End of file tuitions_reports.php */