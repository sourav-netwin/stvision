<?php

/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 12-Jan-2016
 * @Modified    : 
 * @Description : Tuitions reports model
 */
Class Tuitionreportsmodel extends Model {

    function __construct() {
        parent::__construct();
    }
    
    function bookingExists($id) {
        $this->db->where('id_book', $id);
        $Q = $this->db->from('plused_book');
        return $this->db->count_all_results();
    }

    
    function getTuitionReport($fd,$td,$campusIds,$teacherIds,$courseIds){
        $result = array();
        try {
            if(!empty($campusIds)){
                
                $this->db->join('plused_campus_courses','plused_classes.class_campus_course_id = plused_campus_courses.cc_id','left');
                $this->db->join('centri','plused_campus_courses.cc_campus_id = centri.id','left');
                $this->db->join('plused_class_students','plused_classes.class_id = plused_class_students.cs_class_id','left');
                $this->db->join('plused_rows','plused_class_students.cs_booking_id = plused_rows.uuid','left');
                $this->db->select('class_campus_course_id,cc_course_name,cc_course_type,cc_total_hours,
                                    cc_campus_id,nome_centri,
                                    class_id,class_name,class_room_number,class_date,
                                    cs_booking_id,plused_rows.id_book,plused_rows.id_year,plused_rows.nome,plused_rows.cognome,nazionalita,
                                    ');
                
                $this->db->where_in('cc_campus_id',$campusIds);
                $this->db->where_in('class_campus_course_id',$courseIds);
                
                $this->db->where('date(class_date) >=',$fd);
                $this->db->where('date(class_date) <=',$td);
                
                $this->db->where('class_is_deleted',0);
                
                $res = $this->db->get('plused_classes');

                if ($res->num_rows()) {
                    $result = $res->result_array();
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }
    
   function getTuitionReportForBooking($bookingId){
       $result = array();
        try {
            if(!empty($bookingId)){
                
                $this->db->join('plused_campus_courses','plused_classes.class_campus_course_id = plused_campus_courses.cc_id','left');
                $this->db->join('centri','plused_campus_courses.cc_campus_id = centri.id','left');
                $this->db->join('plused_class_students','plused_classes.class_id = plused_class_students.cs_class_id','left');
                $this->db->join('plused_rows','plused_class_students.cs_booking_id = plused_rows.uuid','left');
                $this->db->select('class_campus_course_id,cc_course_name,cc_course_type,cc_total_hours,
                                    cc_campus_id,nome_centri,
                                    class_id,class_name,class_room_number,class_date,
                                    cs_booking_id,plused_rows.id_book,plused_rows.id_year,plused_rows.nome,plused_rows.cognome,nazionalita,
                                    ');
                
                $this->db->where('id_book',$bookingId);
                
                $this->db->where('class_is_deleted',0);
                
                $res = $this->db->get('plused_classes');
                
                if ($res->num_rows()) {
                    $result = $res->result_array();
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
   }
    
    /**
     * getCampusCourses
     * This function returns list of campuses course
     * @return array
     * @throws Exception 
     */
    public function getCampusTeachers($campusIds = array()) {
        $result = array();
        try {
            if(!empty($campusIds)){
                
                $this->db->join('pulsed_class_lessons','plused_classes.class_id = pulsed_class_lessons.cl_class_id');
                //$this->db->join('plused_teachers','pulsed_class_lessons.cl_teacher_id = plused_teachers.teach_id');
                $this->db->join('pulsed_job_contract','pulsed_class_lessons.cl_teacher_id = pulsed_job_contract.joc_id');    // here contract id is refer as teachers id 
                $this->db->join('plused_teacher_application','pulsed_job_contract.joc_application_id = plused_teacher_application.ta_id');   // here joc_id is mapped with teachers application table.
                
                $this->db->join('centri','plused_teachers.teach_campus_id = centri.id');
                $this->db->select('ta_id as teach_id,ta_firstname as teach_first_name,ta_lastname as teach_last_name');
                
                $this->db->where_in('joc_campus_id',$campusIds);
                
                $this->db->where('class_is_deleted',0);
                $this->db->group_by('pulsed_class_lessons.cl_teacher_id');
                $res = $this->db->get('plused_classes');
                if ($res->num_rows()) {
                    $result = $res->result_array();
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }
    
    /**
     * getClassReport
     * This function returns class full details for reporting
     * @return array
     * @throws Exception 
     */
    public function getClassReport($courseId,$classDate){
        $result = array();
        try {
            if(!empty($courseId) && !empty($classDate)){
                
                $this->db->join('plused_campus_courses','plused_classes.class_campus_course_id = plused_campus_courses.cc_id','left');
                $this->db->join('centri','plused_campus_courses.cc_campus_id = centri.id','left');
                $this->db->join('plused_class_students','plused_classes.class_id = plused_class_students.cs_class_id','left');
                $this->db->join('plused_rows','plused_class_students.cs_booking_id = plused_rows.uuid','left');
                $this->db->select('nome_centri,cc_course_name,cc_campus_id,cc_course_type,cc_total_hours,class_id,class_campus_course_id,class_date,class_name,class_room_number,id_book,id_year,nome,cognome,nazionalita');
                $this->db->where('cc_id',$courseId);
                $this->db->where('date(class_date)',$classDate);
                $this->db->where('class_is_deleted',0);
                
                $res = $this->db->get('plused_classes');
                
                if ($res->num_rows()) {
                    $result = $res->result_array();
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }
    
    function getTeacherReport($campusId,$teacherId,$fd,$td){
        $result = array();
        try {
            if(!empty($campusId)){
                
                //$this->db->join('plused_teachers','pulsed_class_lessons.cl_teacher_id = plused_teachers.teach_id');
                
                $this->db->join('pulsed_job_contract','pulsed_class_lessons.cl_teacher_id = pulsed_job_contract.joc_id','left');    // here contract id is refer as teachers id 
                $this->db->join('plused_teacher_application','pulsed_job_contract.joc_application_id = plused_teacher_application.ta_id','left');   // here joc_id is mapped with teachers application table.
                
                $this->db->join('plused_classes','pulsed_class_lessons.cl_class_id = plused_classes.class_id');
                $this->db->join('plused_campus_courses','plused_classes.class_campus_course_id = plused_campus_courses.cc_id');
                $this->db->join('centri','plused_campus_courses.cc_campus_id = centri.id');
                $this->db->select('cl_id,cl_class_id,cl_teacher_id,cl_from_time,cl_to_time,TIMEDIFF(cl_to_time,cl_from_time) AS worktime,cl_presence_of_teacher,
                                    class_campus_course_id,class_date,class_name,class_room_number,
                                    ta_firstname as teach_first_name,ta_lastname as teach_last_name,joc_from_date as teach_from_date,joc_to_date as teach_to_date,joc_hourperweek_range,
                                    cc_course_name,cc_campus_id,cc_course_type,cc_total_hours,
                                    nome_centri',false);
                if($campusId)
                    $this->db->where('cc_campus_id',$campusId);
                
                $this->db->where('cl_teacher_id',$teacherId);
                
                $this->db->where('date(class_date) >=',$fd);
                $this->db->where('date(class_date) <=',$td);
                
                $this->db->where('class_is_deleted',0);
                $this->db->where('cl_is_deleted',0);
                
                $res = $this->db->get('pulsed_class_lessons');

                if ($res->num_rows()) {
                    $result = $res->result_array();
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }
    
    public function getTeacherSummaryReport($campusId,$fd,$td){
        $result = array();
        try {
            if(!empty($campusId)){
                
                //$this->db->join('plused_teachers','pulsed_class_lessons.cl_teacher_id = plused_teachers.teach_id');
                $this->db->join('pulsed_job_contract','pulsed_class_lessons.cl_teacher_id = pulsed_job_contract.joc_id','left');    // here contract id is refer as teachers id 
                $this->db->join('plused_teacher_application','pulsed_job_contract.joc_application_id = plused_teacher_application.ta_id','left');   // here joc_id is mapped with teachers application table.
                
                $this->db->join('plused_classes','pulsed_class_lessons.cl_class_id = plused_classes.class_id');
                $this->db->join('plused_campus_courses','plused_classes.class_campus_course_id = plused_campus_courses.cc_id');
                $this->db->join('centri','plused_campus_courses.cc_campus_id = centri.id');
                $this->db->join('pulsed_teachers_bank_detail','plused_teacher_application.ta_id = pulsed_teachers_bank_detail.tbd_user_id','LEFT');
                $this->db->select('cl_id,cl_class_id,cl_teacher_id,class_date,CASE WHEN cl_presence_of_teacher = 1 THEN count(distinct date(class_date)) ELSE 0 END as actual_work_days,SUM(TIME_TO_SEC(TIMEDIFF(cl_to_time,cl_from_time))/3600) as duration,SUM(CASE WHEN cl_presence_of_teacher = 1 THEN (TIME_TO_SEC(TIMEDIFF(cl_to_time, cl_from_time))/3600) ELSE 0 END) AS actual_worked_hours, count(cl_id) as number_of_lesson,
                                    ta_firstname as teach_first_name,ta_lastname as teach_last_name,joc_from_date as teach_from_date,joc_to_date as teach_to_date,joc_hourperweek_range,joc_wages,joc_salary,joc_currency,
                                    nome_centri,
                                    ta_date_of_birth,ta_nationality,ta_sex,ta_email,ta_telephone,ta_address,ta_city,ta_postcode,ta_country,ta_teach_years,ta_ablility_from,ta_ablility_to,ta_skype,
                                    ta_ni_number,ta_right_to_work_uk,ta_ni_category,ta_making_slr,ta_slr_plan,ta_p45_status,ta_p45_starter_declaration,
                                    tbd_currency_type,tbd_account_name,tbd_sort_code,tbd_account_number,tbd_iban,tbd_swift_bic
                                    ',false);
                //SUM(TIME_TO_SEC(TIMEDIFF(cl_to_time,cl_from_time))/3600) as duration
                if($campusId)
                    $this->db->where_in('cc_campus_id',$campusId);
                
                $this->db->where('date(class_date) >=',$fd);
                $this->db->where('date(class_date) <=',$td);
                
                $this->db->where('class_is_deleted',0);
                $this->db->where('cl_is_deleted',0);
                $this->db->group_by('cl_id');
                $this->db->from('pulsed_class_lessons');
                $preparedQuery =$this->db->_compile_select();
                $this->db->flush_cache();
                $this->db->_reset_select();
                $res = $this->db->query("SELECT cl_id,cl_class_id,cl_teacher_id,count(distinct date(class_date)) as total_work_days,sum(actual_work_days) as actual_work_days,sum(duration) as duration,sum(actual_worked_hours) as actual_worked_hours,sum(number_of_lesson) as number_of_lesson,
                                    teach_first_name,teach_last_name,teach_from_date,teach_to_date,joc_hourperweek_range,joc_wages,joc_salary,joc_currency,
                                    ta_date_of_birth,ta_nationality,ta_sex,ta_email,ta_telephone,ta_address,ta_city,ta_postcode,ta_country,ta_teach_years,ta_ablility_from,ta_ablility_to,ta_skype,
                                    ta_ni_number,ta_right_to_work_uk,ta_ni_category,ta_making_slr,ta_slr_plan,ta_p45_status,ta_p45_starter_declaration,
                                    nome_centri,tbd_currency_type,tbd_account_name,tbd_sort_code,tbd_account_number,tbd_iban,tbd_swift_bic from (".$preparedQuery.") as tableView group by cl_teacher_id");
                
                //echo $preparedQuery;die;
                //$res = $this->db->get();
                //echo $this->db->last_query();die;
                if ($res->num_rows()) {
                    $result = $res->result_array();
                }
                $res->free_result();
                $this->db->flush_cache();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }
    
    function getTuitionStudentsReport($fd,$td,$campusIds,$courseIds){
        $result = array();
        $resultData = array();
        try {
            if(!empty($campusIds)){
                
                $this->db->join('plused_campus_courses','plused_classes.class_campus_course_id = plused_campus_courses.cc_id','left');
                $this->db->join('centri','plused_campus_courses.cc_campus_id = centri.id','left');
                $this->db->join('plused_class_students','plused_classes.class_id = plused_class_students.cs_class_id','left');
                $this->db->join('plused_rows','plused_class_students.cs_booking_id = plused_rows.uuid','left');
                $this->db->select('class_campus_course_id,cc_course_name,cc_course_type,cc_total_hours,
                                    cc_campus_id,nome_centri,
                                    class_id,class_name,class_room_number,class_date,
                                    cs_booking_id,plused_rows.id_book,plused_rows.id_year,plused_rows.nome,plused_rows.cognome,nazionalita,
                                    ');
                
                $this->db->where_in('cc_campus_id',$campusIds);
                $this->db->where_in('class_campus_course_id',$courseIds);
                
                $this->db->where('date(class_date) >=',$fd);
                $this->db->where('date(class_date) <=',$td);
                $this->db->group_by('plused_classes.class_campus_course_id,plused_class_students.cs_booking_id');
                $this->db->where('class_is_deleted',0);
                
                $res = $this->db->get('plused_classes');

                if ($res->num_rows()) {
                    $result = $res->result_array();
                    foreach($result as $record){
                        $courseId = $record['class_campus_course_id'];
                        $studentsId = $record['cs_booking_id'];
                        $studentCourseHours = $this->getStudentsCourseHours($courseId, $studentsId);
                        $record['studentCourseHours'] = $studentCourseHours;
                        array_push($resultData,$record);
                    }
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $resultData;
    }
    
    function getStudentsCourseHours($courseId, $studentsId = 0){
        $result = 0;
        try {
            if(!empty($courseId)){
                
                $this->db->join('plused_classes','pulsed_class_lessons.cl_class_id = plused_classes.class_id');
                $this->db->join('plused_class_students','plused_classes.class_id = plused_class_students.cs_class_id');
                $this->db->select("SUM(TIME_TO_SEC(TIMEDIFF(cl_to_time,cl_from_time))/3600) as duration",false);
                $this->db->where('class_campus_course_id',$courseId);
                $this->db->where('cs_booking_id',$studentsId);
                $this->db->where('cl_is_deleted',0);
                $this->db->where('cs_is_deleted',0);
                $this->db->where('class_is_deleted',0);
                
                $res = $this->db->get('pulsed_class_lessons');
                if ($res->num_rows()) {
                    $result = $res->row()->duration;
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }
}

//End tuitions model
?>