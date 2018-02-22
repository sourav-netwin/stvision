<?php

/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 16 DEC 2015
 * @Modified    : 
 * @Description : Tuitions model
 */
Class Tuitionsmodel extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * getCampusBookings
     * This function returns list of campuses bookings
     * @return array
     * @throws Exception 
     */
    public function getCampusBookings($campusId = 0, $classDate = "") {
        $result = null;
        try {
            if (!empty($campusId) && !empty($classDate)) {
                $this->db->select('id_book,id_year');
                $this->db->where('id_centro', $campusId);
                $this->db->where('arrival_date <= ', $classDate);
                $this->db->where('departure_date >= ', $classDate);
                $this->db->where('status', 'confirmed');
                $res = $this->db->get('plused_book');
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
     * This will return all students assinged in perticular class
     * @param int $classId
     * @return array
     * @throws Exception 
     */
    public function getStudentsInClass($classId = 0) {
        $result = array();
        try {
            if (!empty($classId)) {
                $this->db->select("plused_rows.id_book,cs_id,class_name,plused_rows.id_year,plused_rows.uuid,plused_rows.nome,plused_rows.cognome,plused_rows.nazionalita,nat_flag,lk_lang_knowledge", false);
                $this->db->where('class_id', $classId);
                $this->db->where('plused_class_students.cs_is_deleted', 0);
                $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id');
                $this->db->join('plused_rows', 'plused_class_students.cs_booking_id = plused_rows.uuid');
                $this->db->join('plused_nationality', 'plused_rows.nazionalita = plused_nationality.nationality', 'left');
                $this->db->join('plused_language_knowledge', 'plused_rows.uuid = plused_language_knowledge.lk_uuid', 'left');
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

    public function getStudentsInClassNationality($classId = 0) {
        $result = array();
        try {
            if (!empty($classId)) {
                $this->db->select("GROUP_CONCAT('<img class=\"nationality-flags\" title=\"',nazionalita,'\" ','src=\"" . base_url() . NATIONALITY_FILES_PATH . "',nat_flag,'\" />' SEPARATOR ' ') as htmlImg", false);
                $this->db->where('class_id', $classId);
                $this->db->where('plused_class_students.cs_is_deleted', 0);
                $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id');
                $this->db->join('plused_rows', 'plused_class_students.cs_booking_id = plused_rows.uuid');
                $this->db->join('plused_nationality', 'plused_rows.nazionalita = plused_nationality.nationality', 'left');
                $res = $this->db->get('plused_classes');
                if ($res->num_rows()) {
                    $result = $res->row()->htmlImg;
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * getCampusStudents
     * This function returns list of campus students
     * @return array
     * @throws Exception 
     */
    public function getCampusStudents($campusId = 0, $classDate = "", $classId = 0, $courseId = 0) {
        $result = array();
        $resultData = array();
        try {
            if (!empty($campusId) && !empty($classDate)) {
                $this->db->select("plused_book.weeks,plused_rows.id_book,'' as class_name,'' as already_assigned,plused_rows.id_year,plused_rows.uuid,plused_rows.nome,plused_rows.cognome,plused_rows.pax_dob,plused_rows.nazionalita,lk_lang_knowledge", false);
                $this->db->where('id_centro', $campusId);
                $this->db->where('data_arrivo_campus <= ', $classDate);
                $this->db->where('data_partenza_campus >= ', $classDate);
                $this->db->where('status', 'confirmed');
                $this->db->where('tipo_pax', 'STD');
                $this->db->join('plused_rows', 'plused_book.id_book = plused_rows.id_book');
                $this->db->join('plused_language_knowledge', 'plused_rows.uuid = plused_language_knowledge.lk_uuid', 'left');
                $res = $this->db->get('plused_book');
                if ($res->num_rows()) {
                    $result = $res->result_array();
                }
                $res->free_result();

                // check student is already places?
                foreach ($result as $rec) {
                    $uuid = $rec['uuid'];
                    $this->db->flush_cache();
                    $cs_id = 0;
                    $className = '';
                    $classType = '';
                    $classIdToPass = 0;
                    $this->db->select('cs_id,class_name,class_id,class_type');
                    $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id');
                    $this->db->where('plused_class_students.cs_booking_id', $uuid);
                    $this->db->where('plused_classes.class_id !=', $classId);
                    $this->db->where('plused_classes.class_date', $classDate);
                    $this->db->where('plused_class_students.cs_is_deleted', 0);
                    $presentRow = $this->db->get('plused_classes');
                    $rec['already_assigned'] = 0;
                    $supplementClasses = array();
                    if ($presentRow->num_rows()) {
                        foreach($presentRow->result_array() as $uuidClass){
                            $row = (object)$uuidClass;
                            $classType = $row->class_type;
                            if($classType == "Regular")
                            {
                                $cs_id = $row->cs_id;
                                $className = $row->class_name;
                                $classIdToPass = $row->class_id;
                            }
                            else{
                                // Add all classes for into a array for supplement classes 
                                array_push($supplementClasses, $row->class_name . ' #'.$row->class_id);
                            }
                        }
                    }
                    $rec['already_assigned'] = $cs_id;
                    $rec['class_name'] = $className;
                    $rec['class_id'] = $classIdToPass;
                    $rec['assigned_course_hours'] = $this->getStudentsCourseHours($courseId, $uuid);
                    $rec['supplement_classes'] = $supplementClasses;
                    array_push($resultData, $rec);
                }
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $resultData;
    }

    public function getCampusStudentsPrint($campusId = 0, $classDate = "", $classId = 0, $courseId = 0) {
        $result = array();
        $resultData = array();
        try {
            if (!empty($campusId) && !empty($classId)) {
                $this->db->select("plused_book.weeks,plused_rows.id_book,cs_id,class_name,'' as already_assigned,plused_rows.id_year,plused_rows.uuid,plused_rows.nome,plused_rows.cognome,plused_rows.nazionalita,lk_lang_knowledge", false);
                $this->db->where('class_id', $classId);
                $this->db->where('plused_class_students.cs_is_deleted', 0);
                $this->db->where("(plused_book.status = 'confirmed' OR plused_book.status is null)");
                $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id');
                $this->db->join('plused_rows', 'plused_class_students.cs_booking_id = plused_rows.uuid');
                $this->db->join('plused_language_knowledge', 'plused_rows.uuid = plused_language_knowledge.lk_uuid', 'left');
                $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book');
                $res = $this->db->get('plused_classes');
                if ($res->num_rows()) {
                    $result = $res->result_array();
                }
                $res->free_result();

                // check student is already places?
                foreach ($result as $rec) {
                    $uuid = $rec['uuid'];
                    $rec['assigned_course_hours'] = $this->getStudentsCourseHours($courseId, $uuid);
                    array_push($resultData, $rec);
                }
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $resultData;
    }

    public function getStudentsByUuids($uuids = "", $classDate = "", $campusId = 0) {
        $result = array();
        $resultData = array();
        try {
            if (!empty($uuids) && !empty($classDate) && !empty($campusId)) {
                $uuids = explode(',', $uuids);
                $this->db->select("plused_rows.id_book,plused_rows.id_year,plused_rows.uuid,plused_rows.nome,plused_rows.cognome,plused_rows.pax_dob,plused_rows.nazionalita,lk_lang_knowledge", false);
                $this->db->where_in('plused_rows.uuid', $uuids);
                $this->db->where('plused_book.id_centro', $campusId);
                $this->db->where("(plused_book.status = 'confirmed' OR plused_book.status is null)");
                $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book');
                $this->db->join('plused_language_knowledge', 'plused_rows.uuid = plused_language_knowledge.lk_uuid', 'left');
                $res = $this->db->get('plused_rows');

                if ($res->num_rows()) {
                    $result = $res->result_array();
                }
                $res->free_result();

                // check student is already places?
                foreach ($result as $rec) {
                    $uuid = $rec['uuid'];
                    $rec['class_name'] = "";
                    $rec['class_id'] = "";
                    $rec['cc_course_name'] = "";
                    $rec['assigned_course_hours'] = "";
                    $rec['class_room_number'] = "";
                    $rec['course_hours'] = 0;
                    $this->db->flush_cache();
                    $this->db->select('class_id,class_name,class_room_number,class_campus_course_id,cc_total_hours,cc_course_name');
                    $this->db->where('plused_classes.class_date', $classDate);
                    $this->db->where('plused_class_students.cs_booking_id', $uuid);
                    $this->db->where('plused_class_students.cs_is_deleted', 0);
                    $this->db->where('plused_classes.class_is_deleted', 0);
                    $this->db->where('plused_campus_courses.cc_is_deleted', 0);
                    $this->db->join('plused_classes', 'plused_class_students.cs_class_id = plused_classes.class_id');
                    $this->db->join('plused_campus_courses', 'plused_classes.class_campus_course_id = plused_campus_courses.cc_id');
                    $clasData = $this->db->get('plused_class_students');
                    if ($clasData->num_rows()) {
                        $rec['class_id'] = $clasData->row()->class_id;
                        $rec['class_name'] = $clasData->row()->class_name;
                        $courseId = $clasData->row()->class_campus_course_id;
                        $rec['assigned_course_hours'] = $this->getStudentsCourseHours($courseId, $uuid);
                        $rec['cc_course_name'] = $clasData->row()->cc_course_name;
                        $rec['class_room_number'] = $clasData->row()->class_room_number;
                        $rec['course_hours'] = $clasData->row()->cc_total_hours;
                    }
                    array_push($resultData, $rec);
                }
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $resultData;
    }

    function getStudentsCourseHours($courseId, $uuid = 0) {
        $result = 0;
        try {
            if (!empty($courseId)) {

                $this->db->join('plused_classes', 'pulsed_class_lessons.cl_class_id = plused_classes.class_id');
                $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id');
                $this->db->select("SUM(TIME_TO_SEC(TIMEDIFF(cl_to_time,cl_from_time))/3600) as duration", false);
                $this->db->where('class_campus_course_id', $courseId);
                $this->db->where('cs_booking_id', $uuid);
                $this->db->where('cl_is_deleted', 0);
                $this->db->where('cs_is_deleted', 0);

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

    /**
     * getCampusBookingsStudentsCount
     * This function returns count of campuses bookings students
     * @return array
     * @throws Exception 
     */
    public function getCampusBookingsStudentsCount($campusId = 0, $classDate = "") {
        $result = 0;
        try {
            if (!empty($campusId) && !empty($classDate)) {
                $this->db->select('plused_rows.uuid');
                $this->db->where('id_centro', $campusId);
                $this->db->where('data_arrivo_campus <= ', $classDate);
                $this->db->where('data_partenza_campus >= ', $classDate);
                $this->db->where('status', 'confirmed');
                $this->db->where('tipo_pax', 'STD');
                $this->db->join('plused_rows', 'plused_book.id_book = plused_rows.id_book');
                $res = $this->db->get('plused_book');
                //echo $this->db->last_query();die;
                $result = $res->num_rows();
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    function checkStudentsCourseCompleted($campusId = 0, $classDate = "") {
        $result = 0;
        try {
            if (!empty($campusId) && !empty($classDate)) {
                //$this->db->get('')
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * getBookingsAssignedCount
     * This function returns count of campuses bookings placed
     * @return array
     * @throws Exception 
     */
    public function getBookingsAssignedCount($campusId = 0, $classDate = "") {
        $result = 0;
        try {
            if (!empty($campusId) && !empty($classDate)) {
                $this->db->select('cs_id');
                $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id');
                $this->db->join('plused_campus_courses', 'plused_classes.class_campus_course_id = plused_campus_courses.cc_id');
                $this->db->where('cc_campus_id', $campusId);
                $this->db->where('date(class_date)', $classDate);
                $this->db->where('class_is_deleted', 0);
                $this->db->where('cs_is_deleted', 0);
                // CLASS TYPE ADDED: 2017-07-04
                $this->db->where('class_type', 'Regular');
                $res = $this->db->get('plused_classes');
                $result = $res->num_rows();
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * checkClass
     * This function is used to check class is already exist for the day or not.
     * @return class id
     * @throws Exception 
     */
    public function checkClass($checkData = array(), $classId = 0) {
        $result = 0;
        try {
            if (!empty($checkData)) {
                $this->db->where($checkData);
                $this->db->where('class_is_deleted', 0);
                if ($classId)
                    $this->db->where('class_id != ', $classId);
                $class = $this->db->get('plused_classes');
                if ($class->num_rows())
                    return 1;
                else
                    return 0;
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * checkRoomsAvailable
     * Check rooms are allotted or not | check rooms still available.
     * @return bool status
     * @throws Exception 
     */
    public function checkRoomsAvailable($campusId, $classDate) {
        $roomsStillAvaliable = 0;
        try {
            if (!empty($campusId) && !empty($classDate)) {
                // Get the number of classes already created.
                $this->db->where('class_date', $classDate);
                $this->db->where('cc_campus_id', $campusId);
                $this->db->where('class_is_deleted', 0);
                $this->db->join('plused_campus_courses', 'plused_classes.class_campus_course_id = plused_campus_courses.cc_id');
                $class = $this->db->get('plused_classes');
                $numberOfClasses = $class->num_rows();

                $class->free_result();
                // Get the rooms alloted for campus on day
                $roomsAvailable = 0;
                $this->db->flush_cache();
                $this->db->where('cr_campus_id', $campusId);

                $this->db->where('date(cr_allotment_from_date) <= ', $classDate);
                $this->db->where('date(cr_allotment_to_date) >= ', $classDate);

                $this->db->where('cr_is_active', 1);
                $this->db->where('cr_is_deleted', 0);
                $this->db->limit(1);
                $res = $this->db->get('plused_campus_rooms');
                if ($res->num_rows()) {
                    $roomsAvailable = $res->row()->cr_number_of_rooms;
                }
                $res->free_result();

                $roomsStillAvaliable = $roomsAvailable - $numberOfClasses;
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $roomsStillAvaliable;
    }

    /**
     * createClass
     * This function is created to insert new record in class table.
     * @return class id
     * @throws Exception 
     */
    public function createClass($insertData = array()) {
        $result = 0;
        try {
            if (!empty($insertData)) {
                $this->db->insert('plused_classes', $insertData);
                $result = $this->db->insert_id();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * updateClass
     * This function is created to insert new record in class table.
     * @return class id
     * @throws Exception 
     */
    public function updateClass($updateData = array(), $classId) {
        $result = 0;
        try {
            if (!empty($updateData)) {
                // check class is deleted or not
                $this->db->where('class_id', $classId);
                $this->db->where('class_is_deleted', 0);
                $isDeleted = $this->db->get('plused_classes');
                if ($isDeleted->num_rows()) {
                    $this->db->flush_cache();
                    $this->db->where('class_id', $classId);
                    $this->db->update('plused_classes', $updateData);
                    return $classId;
                }
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * deleteStudentBookings
     * This function removes bookings against class.
     * @return class id
     * @throws Exception 
     */
    public function deleteStudentBookings($classId, $isSoftDelete = FALSE) {
        $result = 0;
        try {
            if (!empty($classId)) {

                if (is_array($classId))
                    $this->db->where_in('cs_class_id', $classId);
                else
                    $this->db->where('cs_class_id', $classId);
                if ($isSoftDelete) {
                    $updateArray = array(
                        'cs_is_deleted' => 1
                    );
                    $this->db->update('plused_class_students', $updateArray);
                } else {
                    $this->db->delete('plused_class_students');
                }
                $result = 1;
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * addStudentBookings
     * This function add bookings against class.
     * @return class id
     * @throws Exception 
     */
    public function addStudentBookings($insertData = array()) {
        $result = 0;
        try {
            if (!empty($insertData)) {
                $this->db->insert('plused_class_students', $insertData);
                $result = 1;
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * getCampusClasses
     * This function returns list of campuses classes
     * @return array
     * @throws Exception 
     */
    public function getCampusClasses($campusId = 0, $classDate = "") {
        $result = null;
        try {
            if (!empty($campusId) && !empty($classDate)) {

                $this->db->join('plused_campus_courses', 'plused_classes.class_campus_course_id = plused_campus_courses.cc_id', 'left');
                $this->db->join('centri', 'plused_campus_courses.cc_campus_id = centri.id', 'left');
                $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id', 'left');
                $this->db->join('plused_rows', 'plused_class_students.cs_booking_id = plused_rows.uuid', 'left');
                $this->db->select('class_id,count(cs_id) as numberofbookings,MIN(TIMESTAMPDIFF(YEAR,pax_dob,CURDATE())) AS min_age,MAX(TIMESTAMPDIFF(YEAR,pax_dob,CURDATE())) AS max_age, class_campus_course_id,class_date,class_name,class_room_number,class_type,cc_course_name,cc_campus_id,cc_course_type,cc_total_hours,nome_centri');
                $this->db->where('cc_campus_id', $campusId);
                $this->db->where('date(class_date)', $classDate);
                $this->db->where('class_is_deleted', 0);
                $this->db->group_by('class_id');
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
     * getCampusClassesWithNatFlags
     * This function returns campus classes with students nationality flags
     * @param int $campusId
     * @param date $classDate
     * @return mix
     * @throws Exception 
     */
    public function getCampusClassesWithNatFlags($campusId = 0, $classDate = "") {
        $result = null;
        try {
            if (!empty($campusId) && !empty($classDate)) {

                $this->db->join('plused_campus_courses', 'plused_classes.class_campus_course_id = plused_campus_courses.cc_id', 'left');
                $this->db->join('centri', 'plused_campus_courses.cc_campus_id = centri.id', 'left');
                $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id', 'left');
                $this->db->join('plused_rows', 'plused_class_students.cs_booking_id = plused_rows.uuid', 'left');
                $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book', 'left');
                $this->db->join('plused_nationality', 'plused_rows.nazionalita = plused_nationality.nationality', 'left');
                $this->db->join('plused_language_knowledge', 'plused_rows.uuid = plused_language_knowledge.lk_uuid', 'left');
                $this->db->select("class_id,count(cs_id) as numberofbookings,MIN(TIMESTAMPDIFF(YEAR,pax_dob,CURDATE())) AS min_age,MAX(TIMESTAMPDIFF(YEAR,pax_dob,CURDATE())) AS max_age, class_campus_course_id,class_date,class_name,class_room_number,class_type,cc_course_name,cc_campus_id,cc_course_type,cc_total_hours,nome_centri,
                GROUP_CONCAT(DISTINCT(CONCAT('<img class=\"nationality-flags\" data-toggle=\"tooltip\" title=\"',nazionalita,'\" ','src=\"" . base_url() . NATIONALITY_FILES_PATH . "',nat_flag,'\" />')) SEPARATOR ' ') as htmlImg,
                CONCAT(min(lk_lang_knowledge),' - ',max(lk_lang_knowledge)) AS lang_min_max
                ", false);
                $this->db->where('cc_campus_id', $campusId);
                $this->db->where('date(class_date)', $classDate);
                $this->db->where('class_is_deleted', 0);
                $this->db->where("(status = 'confirmed' OR status is null)");
                $this->db->group_by('class_id');
                $res = $this->db->get('plused_classes');
                //echo $this->db->last_query();die;
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
     * getClassTeachersCount
     * return teachers count for the classes listing
     * @param int $classId
     * @return mixed
     * @throws Exception 
     */
    public function getClassTeachersCount($classId = 0) {
        $result = null;
        try {
            if (!empty($classId)) {

                $strSql = "SELECT count(cl_teacher_id) as teacher_assigned,GROUP_CONCAT(teacher_name SEPARATOR ', ') as teacher_name,min(DATE_FORMAT(min_time, '%H:%i')) as min_time, max(DATE_FORMAT(max_time, '%H:%i')) as max_time FROM (
                    SELECT distinct(cl_teacher_id) as cl_teacher_id,CONCAT_WS(' ',ta_firstname,ta_lastname) as teacher_name, min(cl_from_time) as min_time, max(cl_to_time) as max_time 
                    FROM (pulsed_class_lessons) 
                    LEFT JOIN pulsed_job_contract ON pulsed_class_lessons.cl_teacher_id = pulsed_job_contract.joc_id 
                    LEFT JOIN plused_teacher_application ON pulsed_job_contract.joc_application_id = plused_teacher_application.ta_id 
                    WHERE `cl_class_id` = '" . $classId . "' AND `cl_is_deleted` = 0 GROUP BY cl_teacher_id ) AS T
                ";
                $res = $this->db->query($strSql);
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
     * getClassTeachersCountForTheDay
     * This function is used to get total number of teachers assigned for group of classses
     * basically these are the classes of the day.
     * @param type $classIdsArr
     * @return type
     * @throws Exception 
     */
    public function getClassTeachersCountForTheDay($classIdsArr){
        $result = null;
        try {
            if (!empty($classIdsArr)) {
                $this->db->select('count(distinct(cl_teacher_id)) as teacher_assigned');
                $this->db->from("pulsed_class_lessons");
                $this->db->where("cl_is_deleted",0);
                $this->db->where_in("cl_class_id",$classIdsArr);
                $res = $this->db->get();
                if ($res->num_rows()) {
                    $result = $res->row()->teacher_assigned;
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * getCampusClasses
     * This function returns list of campuses classes
     * @return array
     * @throws Exception 
     */
    public function getClassStudentsKwnowledgeLanguage($classId = 0) {
        $result = array();
        try {
            if (!empty($classId)) {
                $this->db->select("CONCAT(min(lk_lang_knowledge),' - ',max(lk_lang_knowledge)) AS str", false);
                $this->db->where('class_id', $classId);
                $this->db->where('plused_class_students.cs_is_deleted', 0);
                $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id');
                $this->db->join('plused_rows', 'plused_class_students.cs_booking_id = plused_rows.uuid');
                $this->db->join('plused_language_knowledge', 'plused_rows.uuid = plused_language_knowledge.lk_uuid', 'left');
                $this->db->group_by('class_id');
                $res = $this->db->get('plused_classes');
                //echo $this->db->last_query();
                if ($res->num_rows()) {
                    $result = $res->row()->str;
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * getStudentsLangKnowledgeCount
     * this is used to fetch students count for CD tuition schedule 
     * COUNT FOR : TESTED - TO BE TESTED, LEAVING TOMORROW
     * @param string $dayDate
     * @param int $campusId
     * @param boolean $countTested
     * @param boolean $leavingTomorrow
     * @return array
     * @throws Exception 
     */
    function getStudentsLangKnowledgeCount($dayDate, $campusId, $countTested = TRUE, $leavingTomorrow = FALSE) {
        $result = array();
        try {
            if (!empty($campusId)) {
                $this->db->select("count(plused_language_knowledge.lk_uuid) as students_count,group_concat(plused_language_knowledge.lk_uuid) as std_uuids", false);
                $this->db->where('id_centro', $campusId);
//                $this->db->where('data_arrivo_campus <= ',$dayDate);
//                $this->db->where('data_partenza_campus >= ',$dayDate);

                if ($leavingTomorrow) {
                    $this->db->where('data_partenza_campus = ', date('Y-m-d', strtotime($dayDate . ' +1 day')));
                } else if ($countTested) {
                    $this->db->where('data_arrivo_campus <= ', $dayDate);
                    $this->db->where('data_partenza_campus >= ', $dayDate);
                    $this->db->where('plused_language_knowledge.lk_lang_knowledge >', 0);
                } else {
                    $this->db->where('data_arrivo_campus <= ', $dayDate);
                    $this->db->where('data_partenza_campus >= ', $dayDate);
                    $this->db->where("(plused_language_knowledge.lk_lang_knowledge < 0 OR plused_language_knowledge.lk_lang_knowledge = 0 OR plused_language_knowledge.lk_lang_knowledge = '')");
                }
                $this->db->join('plused_language_knowledge', 'plused_rows.uuid = plused_language_knowledge.lk_uuid', 'left');
                $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book');
                $this->db->where('tipo_pax', 'STD');
                $res = $this->db->get('plused_rows');

                if ($res->num_rows()) {
                    $result['students_count'] = $res->row()->students_count;
                    $result['std_uuids'] = $res->row()->std_uuids;
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * Optimised query for students count at tuition schedule CD
     * TESTED STUDENTS COUNT
     * STUDENTS TO BE TESTED
     * STUDENTS LEAVING
     * @param type $dayDate
     * @param type $campusId
     * @return int 
     */
    function getStudentsStats($dayDate, $campusId) {
        $strQuery = "SELECT COUNT(CASE WHEN (lk_lang_knowledge > 0 AND data_arrivo_campus <=  '" . $dayDate . "' AND data_partenza_campus >=  '" . $dayDate . "') THEN (plused_language_knowledge.lk_uuid) END) AS students_count,
                        GROUP_CONCAT(CASE WHEN (lk_lang_knowledge > 0 AND data_arrivo_campus <=  '" . $dayDate . "' AND data_partenza_campus >=  '" . $dayDate . "') THEN (plused_language_knowledge.lk_uuid) END) AS std_uuids,
                        COUNT(CASE WHEN ((lk_lang_knowledge < 0 
                        OR lk_lang_knowledge = 0 
                        OR lk_lang_knowledge = '' OR lk_lang_knowledge IS NULL) AND data_arrivo_campus <=  '" . $dayDate . "' AND data_partenza_campus >=  '" . $dayDate . "') THEN plused_rows.uuid END) AS untested_students_count,
                        group_concat(CASE WHEN ((lk_lang_knowledge < 0 
                        OR lk_lang_knowledge = 0 
                        OR lk_lang_knowledge = '' OR lk_lang_knowledge IS NULL) AND data_arrivo_campus <=  '" . $dayDate . "' AND data_partenza_campus >=  '" . $dayDate . "') THEN plused_rows.uuid END) AS untested_std_uuids,
                        count(CASE WHEN (data_partenza_campus = '" . date('Y-m-d', strtotime($dayDate . ' +1 day')) . "') THEN plused_rows.uuid END) AS leavingto_students_count,
                        group_concat(CASE WHEN (data_partenza_campus = '" . date('Y-m-d', strtotime($dayDate . ' +1 day')) . "') THEN plused_rows.uuid END) AS leavingto_std_uuids
                        FROM (plused_rows) LEFT JOIN plused_language_knowledge 
                        ON plused_rows.uuid = plused_language_knowledge.lk_uuid 
                        JOIN plused_book ON plused_rows.id_book = plused_book.id_book 
                        WHERE id_centro = '" . $campusId . "' AND tipo_pax = 'STD' AND plused_book.status = 'confirmed';";
        $qResult = $this->db->query($strQuery);
        //echo $this->db->last_query();die;
        if ($qResult->num_rows()) {
            return $qResult->result_array();
        } else
            return 0;
    }

    /**
     * getCourseAssignedHours
     * this function returns assigned hours against course.
     * @param int $courseId
     * @param int $clId
     * @return double
     * @throws Exception 
     */
    function getCourseAssignedHours($courseId, $clId = 0) {
        $result = 0;
        try {
            if (!empty($courseId)) {

                $this->db->join('plused_classes', 'pulsed_class_lessons.cl_class_id = plused_classes.class_id');
                $this->db->select("SUM(TIME_TO_SEC(TIMEDIFF(cl_to_time,cl_from_time))/3600) as duration", false);
                $this->db->where('class_campus_course_id', $courseId);
                $this->db->where('cl_is_deleted', 0);
                $this->db->where('plused_classes.class_is_deleted', 0);
                if ($clId)
                    $this->db->where('cl_id !=', $clId);
                $res = $this->db->get('pulsed_class_lessons');
                //echo $this->db->last_query();die;
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

    /**
     * checkCourseHours
     * this function checks total course available, assinged course hours. 
     * @param string time $fromTime
     * @param string time $toTime
     * @param int $courseId
     * @param int $clId
     * @return boolean true if still there are hours remaining else false.
     */
    function checkCourseHours($fromTime, $toTime, $courseId, $clId = 0) {
        $courseAssignedHours = $this->getCourseAssignedHours($courseId, $clId);
        $courseTotalHours = 0;
        $currentHours = 0;
        // get course total hourse
        $this->db->flush_cache();
        $this->db->where('cc_id', $courseId);
        $this->db->select("cc_total_hours,(TIME_TO_SEC(TIMEDIFF('" . $toTime . "','" . $fromTime . "'))/3600) as duration", false);
        $result = $this->db->get('plused_campus_courses');
        if ($result->num_rows()) {
            $courseTotalHours = $result->row()->cc_total_hours;
            $currentHours = $result->row()->duration;
        }
        if ($currentHours <= ($courseTotalHours - $courseAssignedHours))
            return true;
        else
            return false;
    }

    /**
     * getAvailableHours
     * @param int $courseId
     * @return array 
     */
    function getAvailableHours($courseId) {
        $courseAssignedHours = $this->getCourseAssignedHours($courseId);
        $courseTotalHours = 0;
        // get course total hourse
        $this->db->flush_cache();
        $this->db->where('cc_id', $courseId);
        $this->db->select("cc_total_hours", false);
        $result = $this->db->get('plused_campus_courses');
        if ($result->num_rows()) {
            $courseTotalHours = $result->row()->cc_total_hours;
        }
        $courseAssignedHours = round($courseAssignedHours, 2);
        $courseTotalHours = round($courseTotalHours, 2);
        return array('courseAssignedHours' => $courseAssignedHours, 'courseTotalHours' => $courseTotalHours);
    }

    /**
     * getSingleClass
     * This function can be use to fetch single record of class with all its bookings.
     * @param type $classId
     * @return type
     * @throws Exception 
     */
    public function getSingleClass($classId = 0) {
        $result = null;
        try {
            if (!empty($classId)) {

                $this->db->join('plused_campus_courses', 'plused_classes.class_campus_course_id = plused_campus_courses.cc_id', 'left');
                $this->db->join('centri', 'plused_campus_courses.cc_campus_id = centri.id', 'left');
                $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id', 'left');
                $this->db->select('class_id,count(cs_id) as numberofbookings,group_concat(cs_booking_id) as booking_ids,class_campus_course_id,class_date,class_name,class_room_number,class_type,cc_course_name,cc_campus_id,cc_course_type,nome_centri');
                $this->db->where('class_id', $classId);
                $this->db->where('class_is_deleted', 0);
                $this->db->group_by('class_id');
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
     * getAvailableRoomsStudents
     * this function return available rooms for class students
     * @param int $campusId
     * @param int $classDate
     * @return mixed
     * @throws Exception 
     */
    public function getAvailableRoomsStudents($campusId, $classDate) {
        $result = null;
        try {
            if (!empty($campusId) && !empty($classDate)) {
                $this->db->where('cr_campus_id', $campusId);
                $this->db->where('date(cr_allotment_from_date) <= ', $classDate);
                $this->db->where('date(cr_allotment_to_date) >= ', $classDate);
                $this->db->where('cr_is_active', 1);
                $this->db->where('cr_is_deleted', 0);
                $this->db->limit(1);
                $res = $this->db->get('plused_campus_rooms');
                if ($res->num_rows()) {
                    $result = $res->row();
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    public function checkTeacherForClass($classId = 0) {
        if ($classId) {
            $this->db->select('cl_id');
            $this->db->where('cl_class_id', $classId);
            $this->db->where('cl_presence_of_teacher', 1);
            $this->db->where('cl_is_deleted', 0);
            $result = $this->db->get('pulsed_class_lessons');
            if ($result->num_rows()) {
                return 0;
            } else {
                return 1;
            }
        }
        return 0;
    }

    /**
     * deleteClass 
     * this function delete class and all its bookings.
     * @param type $classId
     * @return int
     * @throws Exception 
     */
    public function deleteClass($classId) {
        $result = 0;
        try {
            if (!empty($classId)) {
                if (is_array($classId))
                    $this->db->where_in('class_id', $classId);
                else
                    $this->db->where('class_id', $classId);
                $updateArr = array(
                    'class_is_deleted' => 1
                );
                $this->db->update('plused_classes', $updateArr); // SOFT DELETE CLASS
                $this->deleteStudentBookings($classId, TRUE); // SOFT DELETE CLASS BOOKINGS
                $result = 1;
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * getCampusTeachers
     * This function returns list of campus teachers
     * @return array
     * @throws Exception 
     */
    public function getCampusTeachers($campusId = 0, $durationDate) {
        $result = 0;
        try {
            if (!empty($campusId)) {
                $this->db->from('pulsed_job_contract jc');
                $this->db->join('plused_teacher_application ta', 'jc.joc_application_id = ta.ta_id AND jc.joc_contract_signed = 1');
                $this->db->join('plused_job_positions jp', 'jc.joc_position_id = jp.pos_id');
                $this->db->select("joc_id as teach_id,concat_ws(' ',ta_firstname,ta_lastname) as teach_fullname,joc_staff_priority", false);
                $this->db->where('jp.pos_position', 'Teacher');
                $this->db->where('joc_campus_id', $campusId);
                $this->db->where('joc_is_deleted', 0);
                $this->db->where('joc_is_active', 1);
                $this->db->where('date(joc_from_date) <= ', $durationDate);
                $this->db->where('date(joc_to_date) >= ', $durationDate);
                $this->db->order_by('joc_staff_priority', 'desc');
                $res = $this->db->get();
                //echo $this->db->last_query();die;
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
     * getCampusTeachersFroDuration
     * This function returns list of campus teachers
     * @return array
     * @throws Exception 
     */
    public function getCampusTeachersFromId($campusId = 0) {
        $result = 0;
        try {
            if (!empty($campusId)) {
                $this->db->from('pulsed_job_contract jc');
                $this->db->join('plused_teacher_application ta', 'jc.joc_application_id = ta.ta_id AND jc.joc_contract_signed = 1');
                $this->db->select("joc_id as teach_id,concat_ws(' ',ta_firstname,ta_lastname) as teach_fullname", false);
                $this->db->where('joc_campus_id', $campusId);
                $res = $this->db->get();

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
     * addTeacherToClass
     * This function is created to insert new record in lesson table.
     * @return lesson id
     * @throws Exception 
     */
    public function addTeacherToClass($insertData = array()) {
        $result = 0;
        try {
            if (!empty($insertData)) {
                $this->db->insert('pulsed_class_lessons', $insertData);
                $result = $this->db->insert_id();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * updateTeacher
     * This function is created to insert new record in lesson table.
     * @return lesson id
     * @throws Exception 
     */
    public function updateTeacher($updateData = array(), $clId) {
        $result = 0;
        try {
            if (!empty($updateData)) {

                // ALLOWED BACKOFFICE OPERATOR TO UPDATE
                if ($this->session->userdata('role') != 100) {
                    // check teacher mark as present
                    $this->db->flush_cache();
                    $this->db->select('cl_presence_of_teacher');
                    $this->db->where('cl_id', $clId);
                    $presentData = $this->db->get('pulsed_class_lessons');
                    if ($presentData) {
                        $cl_presence_of_teacher = $presentData->row()->cl_presence_of_teacher;
                        if ($cl_presence_of_teacher)
                            return -2; // NOT ALLOWED TO UPDATE
                        else {
                            $this->db->flush_cache();
                            $this->db->where('cl_id', $clId);
                            $this->db->update('pulsed_class_lessons', $updateData);
                            return $clId;
                        }
                    }
                } else {
                    $this->db->flush_cache();
                    $this->db->where('cl_id', $clId);
                    $this->db->update('pulsed_class_lessons', $updateData);
                    return $clId;
                }
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    function updateMarkAsPrensent($updateData = array(), $clId) {
        $this->db->flush_cache();
        $this->db->where('cl_id', $clId);
        $this->db->update('pulsed_class_lessons', $updateData);
        return $clId;
    }

    /**
     * getClassTeachers
     * This function returns list of techers for class
     * @return array
     * @throws Exception 
     */
    public function getClassTeachers($classId = 0, $contractTeacherNotAvailable = array()) {
        $result = null;
        try {
            if (!empty($classId)) {

                $this->db->join('plused_classes', 'pulsed_class_lessons.cl_class_id = plused_classes.class_id', 'left');
                $this->db->join('pulsed_job_contract', 'pulsed_class_lessons.cl_teacher_id = pulsed_job_contract.joc_id', 'left'); // here contract id is refer as teachers id 
                $this->db->join('plused_teacher_application', 'pulsed_job_contract.joc_application_id = plused_teacher_application.ta_id', 'left'); // here joc_id is mapped with teachers application table.
                //$this->db->join('plused_teachers','pulsed_class_lessons.cl_teacher_id = plused_teachers.teach_id','left');
                $this->db->select("cl_id,class_name,class_date,concat_ws(' ',ta_firstname,ta_lastname) as teacher_name,ta_firstname as teach_first_name,ta_lastname as teach_last_name,cl_class_id,cl_teacher_id,cl_from_time,cl_to_time,cl_presence_of_teacher,cl_lesson_note,cl_course_director_marked,cl_created_on,cl_created_by,cl_is_deleted", false);
                $this->db->where('cl_class_id', $classId);
                $this->db->where('cl_is_deleted', 0);
                if (is_array($contractTeacherNotAvailable))
                    if (count($contractTeacherNotAvailable)) {
                        $this->db->where_not_in('pulsed_class_lessons.cl_teacher_id', $contractTeacherNotAvailable);
                    }
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

    /**
     * getClassTeachers
     * This function returns list of techers for class
     * @return array
     * @throws Exception 
     */
    public function getClassTeachersForDuration($fromDate, $toDate, $campusId = 0) {
        $result = null;
        try {
            if (!empty($fromDate) && !empty($toDate)) {
                $this->db->join('plused_classes', 'pulsed_class_lessons.cl_class_id = plused_classes.class_id', 'left');
                $this->db->join('pulsed_job_contract', 'pulsed_class_lessons.cl_teacher_id = pulsed_job_contract.joc_id', 'left'); // here contract id is refer as teachers id 
                $this->db->join('plused_teacher_application', 'pulsed_job_contract.joc_application_id = plused_teacher_application.ta_id', 'left'); // here joc_id is mapped with teachers application table.
                $this->db->join('plused_campus_courses', 'plused_classes.class_campus_course_id = plused_campus_courses.cc_id'); // here joc_id is mapped with teachers application table.

                $this->db->select("cl_id,class_name,date(class_date) as class_date,cl_class_id,cl_teacher_id,min(cl_from_time) as cl_from_time,max(cl_to_time) as cl_to_time", false);
                $this->db->where('class_date >=', $fromDate);
                $this->db->where('class_date <=', $toDate);
                $this->db->where('cl_is_deleted', 0);
                $this->db->where('class_is_deleted', 0);
                $this->db->group_by('cl_class_id');
                if ($campusId) {
                    $this->db->where('plused_campus_courses.cc_campus_id', $campusId);
                }
                $res = $this->db->get('pulsed_class_lessons');
                //echo $this->db->last_query();die;
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
     * This function is used to check teachers time availability
     * @param string $fromTime
     * @param string $toTime
     * @param int $classId
     * @param int $clId
     * @param int $teacherId
     * @param string $classDate
     * @return int
     * @throws Exception 
     */
    public function checkTeachersTiming($fromTime, $toTime, $classId, $clId, $teacherId = 0, $classDate = "") {
        $result = 0;
        $org_fromTime = $fromTime;
        $org_toTime = $toTime;
        try {
//            if($clId)
//            {
            $fromTime = strtotime("+1 minutes", strtotime($fromTime));
            $fromTime = date('H:i:s', $fromTime);
            $toTime = strtotime("-1 minutes", strtotime($toTime));
            $toTime = date('H:i:s', $toTime);
//            }
            $classDate = str_replace('/', '-', $classDate);
            $classDate = date("Y-m-d", strtotime($classDate));

            $this->db->select('cl_id');
            $strSql = "SELECT * 
                        FROM (`pulsed_class_lessons`)
                        JOIN plused_classes ON (pulsed_class_lessons.cl_class_id = plused_classes.class_id) 
                        WHERE (
                        (((`cl_to_time` BETWEEN '" . $fromTime . "' AND '" . $toTime . "')
                        OR (`cl_from_time` BETWEEN '" . $fromTime . "' AND '" . $toTime . "') 
                        OR (`cl_from_time` = '" . $org_fromTime . "' AND `cl_to_time` = '" . $org_toTime . "')
                        OR ('" . $toTime . "' BETWEEN `cl_from_time` AND `cl_to_time`)
                        OR ('" . $fromTime . "' BETWEEN `cl_from_time` AND `cl_to_time`))
                        AND `cl_class_id` = '" . $classId . "' AND cl_teacher_id = " . $teacherId . ")
                            OR
                        (((`cl_to_time` BETWEEN '" . $fromTime . "' AND '" . $toTime . "')
                        OR (`cl_from_time` BETWEEN '" . $fromTime . "' AND '" . $toTime . "') 
                        OR (`cl_from_time` = '" . $org_fromTime . "' AND `cl_to_time` = '" . $org_toTime . "')
                        OR ('" . $toTime . "' BETWEEN `cl_from_time` AND `cl_to_time`)
                        OR ('" . $fromTime . "' BETWEEN `cl_from_time` AND `cl_to_time`))
                        AND `cl_class_id` != '" . $classId . "' AND cl_teacher_id = " . $teacherId . ")
                            OR
                        (((`cl_to_time` BETWEEN '" . $fromTime . "' AND '" . $toTime . "')
                        OR (`cl_from_time` BETWEEN '" . $fromTime . "' AND '" . $toTime . "') 
                        OR (`cl_from_time` = '" . $org_fromTime . "' AND `cl_to_time` = '" . $org_toTime . "')
                        OR ('" . $toTime . "' BETWEEN `cl_from_time` AND `cl_to_time`)
                        OR ('" . $fromTime . "' BETWEEN `cl_from_time` AND `cl_to_time`))
                        AND `cl_class_id` = '" . $classId . "' AND cl_teacher_id != " . $teacherId . ")    
                        )
                        AND cl_is_deleted = 0 AND date(class_date) = '" . $classDate . "' AND plused_classes.class_is_deleted = 0 AND cl_id != $clId limit 1"; //`cl_class_id` = '".$classId."' AND 
            // AND cl_teacher_id = ".$teacherId."
            $res = $this->db->query($strSql);
            //echo $this->db->last_query();die;
            $result = $res->num_rows();
            $res->free_result();
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * deleteTeacher 
     * this function delete teacher.
     * @param type $cl_id
     * @return int
     * @throws Exception 
     */
    public function deleteTeacher($cl_id) {
        $result = 0;
        try {
            if (!empty($cl_id)) {
                // ALLOWED BACKOFFICE OPERATOR TO UPDATE
                if ($this->session->userdata('role') != 100) {
                    // check teacher mark as present
                    $this->db->where('cl_id', $cl_id);
                    $this->db->limit(1);
                    $presentData = $this->db->get('pulsed_class_lessons');
                    if ($presentData) {
                        $cl_presence_of_teacher = $presentData->row()->cl_presence_of_teacher;
                        if ($cl_presence_of_teacher)
                            return 2; // NOT ALLOWED TO DELETE
                        else {
                            $this->db->flush_cache();
                            $this->db->where('cl_id', $cl_id);
                            $updateArr = array(
                                'cl_is_deleted' => 1
                            );
                            $this->db->update('pulsed_class_lessons', $updateArr); // SOFT DELETE LESSION
                            $result = 1;
                        }
                    }
                } else {
                    $this->db->flush_cache();
                    $this->db->where('cl_id', $cl_id);
                    $updateArr = array(
                        'cl_is_deleted' => 1
                    );
                    $this->db->update('pulsed_class_lessons', $updateArr); // SOFT DELETE LESSION
                    $result = 1;
                }
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * getTeacher
     * This function returns single record for teacher which is assigned for lession
     * @return array
     * @throws Exception 
     */
    public function getTeacher($clId = 0) {
        $result = null;
        try {
            if (!empty($clId)) {

                $this->db->join('plused_classes', 'pulsed_class_lessons.cl_class_id = plused_classes.class_id', 'left');
                $this->db->join('pulsed_job_contract', 'pulsed_class_lessons.cl_teacher_id = pulsed_job_contract.joc_id', 'left'); // here contract id is refer as teachers id 
                $this->db->join('plused_teacher_application', 'pulsed_job_contract.joc_application_id = plused_teacher_application.ta_id', 'left'); // here joc_id is mapped with teachers application table.
                //$this->db->join('plused_teachers','pulsed_class_lessons.cl_teacher_id = plused_teachers.teach_id','left');
                $this->db->select("cl_id,class_name,class_date,concat_ws(' ',ta_firstname,ta_lastname) as teacher_name,ta_firstname as teach_first_name,ta_lastname as teach_last_name,cl_class_id,cl_teacher_id,cl_from_time,cl_to_time,cl_presence_of_teacher as presence_of_teacher,cl_course_director_marked,cl_lesson_note as notes,cl_created_on,cl_created_by,cl_is_deleted", false);
                $this->db->where('cl_id', $clId);
                $this->db->where('cl_is_deleted', 0);
                $res = $this->db->get('pulsed_class_lessons');
                if ($res->num_rows()) {
                    $result = $res->row();
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * getTeachersAssigned
     * this function returns assigned teachers for classes in campus
     * @param int $campusId
     * @param string $date
     * @return row
     * @throws Exception 
     */
    function getTeachersAssigned($campusId, $classDate = "") {
        $result = 0;
        try {
            if (!empty($campusId)) {

                $this->db->join('plused_classes', 'pulsed_class_lessons.cl_class_id = plused_classes.class_id');
                $this->db->join('plused_campus_courses', 'plused_classes.class_campus_course_id = plused_campus_courses.cc_id');
                $this->db->select("cl_teacher_id,SUM(TIME_TO_SEC(TIMEDIFF(cl_to_time,cl_from_time))/3600) as duration", false);
                $this->db->where('class_date', $classDate);
                $this->db->where('cc_campus_id', $campusId);
                $this->db->where('cl_is_deleted', 0);
                $this->db->group_by('cl_teacher_id');

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

    /**
     * checkTeachersAvailableForNextDate
     * this function check teachers are available or not for next day in campus
     * @param rows $teachersAssigned
     * @param string $orgDate
     * @return int
     * @throws Exception
     */
    function checkTeachersAvailableForNextDate($teachersAssigned, $nextDate) {
        $result = array();
        $allowed = 1;

        $teachersNotAvailableContractIds = array();
        try {
            if (!empty($teachersAssigned)) {

                foreach ($teachersAssigned as $teacher) {
                    $teacherId = $teacher['cl_teacher_id'];
                    $duration = $teacher['duration']; // hours
                    // here contract id is refered as teachers id
                    $this->db->select("joc_id,joc_hourperweek_range", false);
                    $this->db->where('joc_id', $teacherId);
                    $this->db->where('date(joc_from_date) <= ', $nextDate);
                    $this->db->where('date(joc_to_date) >= ', $nextDate);
                    $this->db->where('joc_is_active', 1);
                    $this->db->where('joc_is_deleted', 0);
                    $resData = $this->db->get('pulsed_job_contract');
                    if ($resData->num_rows()) {
                        $rowT = $resData->row();
                        if ($rowT->joc_hourperweek_range >= $duration) {
                            array_push($result, array(
                                'result' => 1,
                                'joc_id' => $rowT->joc_id,
                                'joc_hourperweek_range' => $rowT->joc_hourperweek_range,
                                'required_hours' => $duration
                            ));
                        } else {
                            array_push($result, array('result' => 0, array(
                                    'result' => 1,
                                    'joc_id' => $rowT->joc_id,
                                    'joc_hourperweek_range' => $rowT->joc_hourperweek_range,
                                    'required_hours' => $duration
                            )));
                            array_push($teachersNotAvailableContractIds, $teacherId);
                            $allowed = 1;
                        }
                    } else {
                        array_push($teachersNotAvailableContractIds, $teacherId);
                        array_push($result, array('result' => 0, array('joc_id' => 0)));
                        $allowed = 1;
                    }
                }
            }
            $result['allowed'] = $allowed;
            $result['contractTeacherNotAvailable'] = $teachersNotAvailableContractIds;
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * getStudentsForClass
     * this function returns available students ids for next day class.
     * @param int $classId
     * @param string $nextDate
     * @return int
     * @throws Exception 
     */
    function getStudentsForClass($campusId, $classId, $nextDate,$class_campus_course_id = 0) {

        $result = 0;
        try {
            $this->db->select('group_concat(cs_booking_id) as cs_booking_ids');
            $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id');
            $this->db->where('class_id', $classId);
            $res = $this->db->get('plused_classes');
            
            //NEXT DAY STUDENTSL
            $this->db->flush_cache();
            $studentsNextDayArr = array();
            $studentsArr = array();
            $this->db->select('group_concat(cs_booking_id) as cs_booking_ids');
            $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id');
            $this->db->where('class_date', $nextDate);
            //$this->db->where('class_campus_course_id', $class_campus_course_id);
            $this->db->where('class_is_deleted', 0);
            $this->db->where('cs_is_deleted', 0);
            $this->db->where('class_type', "Regular");
            $resNextDay = $this->db->get('plused_classes');
            if ($resNextDay->num_rows()) {
                $studentsNextDay = $resNextDay->row()->cs_booking_ids;
                $studentsNextDayArr = explode(',', $studentsNextDay);
            }
            if ($res->num_rows()) {
                $students = $res->row()->cs_booking_ids;
                $studentsArr = explode(',', $students);
                
                //remove already placed students
                $studentsArr = array_values(array_diff($studentsArr,$studentsNextDayArr));
                if(count($studentsArr))
                {
                    $this->db->flush_cache();
                    $this->db->select('group_concat(uuid) as student_ids');
                    $this->db->where('id_centro', $campusId);
                    $this->db->where('data_arrivo_campus <= ', $nextDate);
                    $this->db->where('data_partenza_campus >= ', $nextDate);
                    $this->db->where('status', 'confirmed');
                    $this->db->where('tipo_pax', 'STD');
                    $this->db->where_in('uuid', $studentsArr);
                    $this->db->join('plused_rows', 'plused_book.id_book = plused_rows.id_book');
                    $stdResult = $this->db->get('plused_book');
                    //echo $this->db->last_query();die;
                    if ($stdResult->num_rows()) {
                        $stdIds = $stdResult->row()->student_ids;
                        if (!empty($stdIds))
                            $result = explode(',', $stdIds);
                    }
                }
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * removeAllExistingData
     * this function removes all existing data for next day
     * @param array $nextDayClasses 
     */
    public function removeAllExistingData($nextDayClasses) {
        $classIds = array();
        foreach ($nextDayClasses as $class) {
            array_push($classIds, $class['class_id']);
        }
        if (!empty($class)) {
            // Soft delete classes
            $this->deleteClass($classIds); // SOFT DELETE CLASSES AND THEIR STUDENTS.
            // Soft delete teachers
            $this->db->where_in('cl_class_id', $classIds);
            $updateArr = array(
                'cl_is_deleted' => 1
            );
            $this->db->update('pulsed_class_lessons', $updateArr); // SOFT DELETE LESSION
        }
    }

    /**
     * getCampusCourses
     * This function returns list of campuses course
     * @return array
     * @throws Exception 
     */
    public function getCampusCourses($campusIds = array()) {
        $result = array();
        try {
            if (!empty($campusIds)) {

                $this->db->join('plused_campus_courses', 'plused_classes.class_campus_course_id = plused_campus_courses.cc_id');
                $this->db->join('centri', 'plused_campus_courses.cc_campus_id = centri.id');
                $this->db->join('plused_class_students', 'plused_classes.class_id = plused_class_students.cs_class_id', 'left');
                $this->db->select('count(class_id) as numberofclasses,count(cs_id) as numberofbookings,class_campus_course_id,cc_course_name,cc_campus_id,cc_course_type,cc_total_hours,nome_centri');

                $this->db->where_in('cc_campus_id', $campusIds);

                $this->db->where('class_is_deleted', 0);
                $this->db->group_by('class_campus_course_id');
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
     * getAllStudents
     * This is used to list all students as per campus and their arrival and departure date
     * @param int $campusId
     * @param string $keyword
     * @param date $txtCalFromDate
     * @param date $txtCalToDate
     * @return mixed
     * @throws Exception 
     */
    public function getAllStudents($campusId = 0, $keyword = "", $txtCalFromDate = "", $txtCalToDate = "") {
        $result = array();
        try {
            if (!empty($campusId)) {
                $this->db->select("plused_rows.uuid,plused_rows.id_book,plused_rows.id_year,plused_rows.pax_dob,plused_rows.uuid,plused_rows.nome,plused_rows.cognome,plused_rows.nazionalita,plused_rows.data_arrivo_campus,plused_rows.data_partenza_campus,lk_lang_knowledge,lk_listening_comprehension,lk_oral_test,lk_english_test_score,ts_id", false);
                $this->db->where('id_centro', $campusId);
                $this->db->where('status', 'confirmed');
                $this->db->where('tipo_pax', 'STD');
                $this->db->join('plused_rows', 'plused_book.id_book = plused_rows.id_book');
                $this->db->join('plused_language_knowledge', 'plused_rows.uuid = plused_language_knowledge.lk_uuid', 'left');
                $this->db->join('plused_test_submited', 'plused_rows.uuid = plused_test_submited.ts_uuid', 'left');
                $this->db->join('plused_test_student', 'plused_test_student.test_id=plused_test_submited.ts_test_id  AND plused_test_student.test_type= "Test"', 'left');

                if (!empty($keyword)) {
                    $this->db->where("(
                        plused_rows.nome like '%" . $keyword . "%' OR
                        plused_rows.cognome like '%" . $keyword . "%' OR
                        concat(plused_rows.nome,' ',plused_rows.cognome) like '%" . $keyword . "%' OR
                        plused_rows.nazionalita like '%" . $keyword . "%')
                    ");
                }

                $availableWhere = "";
                if (!empty($txtCalFromDate) && !empty($txtCalToDate)) {
                    $availableWhere = "((data_arrivo_campus <= '" . $txtCalFromDate . "' AND data_partenza_campus >= '" . $txtCalFromDate . "') OR
                                        (data_arrivo_campus <= '" . $txtCalToDate . "' AND data_partenza_campus >= '" . $txtCalToDate . "'))";
                    $this->db->where($availableWhere);
                }

                $res = $this->db->get('plused_book');
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
     * updateLanguageKnowledge
     * This function can used to update the language knowledge against students uuid
     * @param type $uuid
     * @param type $knowledgeLang
     * @return int 
     */
    public function updateLanguageKnowledge($action, $uuid, $knowledgeLang) {
        $result = null;
        if (!empty($uuid)) {
            $updateRow = array(
                'lk_lang_knowledge' => 0,
                'lk_uuid' => $uuid
            );
            if ($action == "oral_test") {
                $updateRow['lk_oral_test'] = $knowledgeLang;
                $updateRow['lk_lang_knowledge'] = $knowledgeLang;
            } elseif ($action == "listening_comprehension") {
                $updateRow['lk_listening_comprehension'] = $knowledgeLang;
                $updateRow['lk_lang_knowledge'] = $knowledgeLang;
            } elseif ($action == "english_test_score") {
                $updateRow['lk_english_test_score'] = $knowledgeLang;
                $updateRow['lk_lang_knowledge'] = $knowledgeLang;
                if ($knowledgeLang > 0) {
                    $updateRow['is_opted_offline'] = 1;
                } else {
                    $updateRow['is_opted_offline'] = 0;
                }
            } else {
                return 0;
            }

            // check old record
            $this->db->where('lk_uuid', $uuid);
            $this->db->select('lk_id,lk_uuid,lk_oral_test,lk_listening_comprehension,lk_english_test_score,lk_lang_knowledge');
            $resultData = $this->db->get('plused_language_knowledge');
            if ($resultData->num_rows()) {
                // update data
                $row = $resultData->row();
                $lk_id = $row->lk_id;
                if ($lk_id) {
                    if ($action == "oral_test") {
                        $updateRow['lk_oral_test'] = $knowledgeLang;
                        $updateRow['lk_lang_knowledge'] = $knowledgeLang + $row->lk_listening_comprehension + $row->lk_english_test_score;
                    } elseif ($action == "listening_comprehension") {
                        $updateRow['lk_listening_comprehension'] = $knowledgeLang;
                        $updateRow['lk_lang_knowledge'] = $row->lk_oral_test + $knowledgeLang + $row->lk_english_test_score;
                    } elseif ($action == "english_test_score") {
                        $updateRow['lk_english_test_score'] = $knowledgeLang;
                        $updateRow['lk_lang_knowledge'] = $row->lk_oral_test + $knowledgeLang + $row->lk_listening_comprehension;
                        if ($knowledgeLang > 0) {
                            $updateRow['is_opted_offline'] = 1;
                        } else {
                            $updateRow['is_opted_offline'] = 0;
                        }
                    }
                    $this->db->flush_cache();
                    $this->db->where('lk_id', $lk_id);
                    $this->db->update('plused_language_knowledge', $updateRow);
                    $result = $updateRow['lk_lang_knowledge'];
                } else {
                    $this->db->flush_cache();
                    $this->db->insert('plused_language_knowledge', $updateRow);
                    $result = $updateRow['lk_lang_knowledge'];
                }
            } else {
                $this->db->flush_cache();
                $this->db->insert('plused_language_knowledge', $updateRow);
                $result = $updateRow['lk_lang_knowledge'];
            }
        }
        return $result;
    }

    // for replication process fetch class
    function getClassData($classId) {
        $this->db->where('class_id', $classId);
        $this->db->select('class_id,class_name,class_campus_course_id,class_date,class_date,class_room_number,class_type,class_created_on,class_created_by,class_is_deleted,class_replicated');
        $result = $this->db->get('plused_classes');
        return $result->row();
    }
    
    function checkTodaysClass($campusId, $date){
        $this->db->where('class_is_deleted', 0);
        $this->db->where('class_date', $date);
        $this->db->where('plused_campus_courses.cc_campus_id', $campusId);
        $this->db->select('class_id');
        $this->db->join('plused_campus_courses', 'plused_classes.class_campus_course_id = plused_campus_courses.cc_id');
        $result = $this->db->get('plused_classes');
        return $result->num_rows();
    }

}

//End tuitions model
?>