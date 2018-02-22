<?php

/**
 * Model for survey
 * @author SK
 * @since 09-May-2016
 */
class Surveymodel extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * verifyGLUser
     * this function is uses to verify teachers application user to authenticate for personal login.
     * @param string $userFirstName
     * @param string $userSurname
     * @param string $userDOB
     * @return mixed 
     */
    public function verifyGLUser($userFirstName, $userSurname, $userDOB, $bookingId = '') {
        $this->db->where('cognome', $userSurname);
        $this->db->where('nome', $userFirstName);
        $this->db->where('date(pax_dob)', $userDOB);
        $this->db->where('id_book', $bookingId);
        $this->db->where('tipo_pax', 'GL');
        $this->db->order_by('id_prenotazione', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get("plused_rows");
        if ($result->num_rows()) {
            return $result->row();
        } else
            return 0;
    }

    function getServeyQuestions($reportType = "", $surveyUserId = 0) {
        if (!empty($reportType)) {
            $this->db->where('que_report', $reportType);
            $this->db->order_by('que_section_sequence,que_number', 'asc');
            $this->db->join('plused_survey_answers', 'plused_survey_questions.que_id = ans_que_id AND plused_survey_answers.ans_su_id = ' . $surveyUserId, 'left');
            $result = $this->db->get('plused_survey_questions');
            if ($result->num_rows())
                return $result->result_array();
        }
        return 0;
    }

    public function getUserdata($id) {
        $this->db->where('tipo_pax', 'GL');
        $this->db->where('uuid', $id); //changed the refference to pax uuid
        $this->db->select('id_prenotazione,uuid,cognome,nome,tipo_pax,pax_dob,data_arrivo_campus,data_partenza_campus,id_centro,nome_centri');
        $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book', 'left');
        $this->db->join('centri', 'plused_book.id_centro = centri.id', 'left');
        $result = $this->db->get("plused_rows");
        if ($result->num_rows()) {
            return $result->row();
        } else
            return 0;
    }

    public function startSurvey($insertArray = array()) {
        $result = 0;
        if (!empty($insertArray)) {
            $this->db->insert('plused_survey_users', $insertArray);
            $result = $this->db->insert_id();
        }
        return $result;
    }

    public function getSurveyUserdata($userId = '', $reportType = '') {
        if (!empty($userId) && !empty($reportType)) {
            $this->db->where('su_group_leader_uuid', $userId); //changed the refference to pax uuid
            $this->db->where('su_report', $reportType);
            $result = $this->db->get('plused_survey_users');
            if ($result->num_rows()) {
                return $result->row();
            }
            return 0;
        }
    }

    /**
     * This function is used to store answers
     * @param string $type
     * @param int $suId
     * @param int $quesId
     * @param string $myVal
     * @return int 
     */
    public function logSurveyAnswer($type, $suId, $quesId, $myVal) {
        $insertArray = array();
        if ($type == 'comment' || $type == 'text') {
            $insertArray = array(
                'ans_su_id' => $suId,
                'ans_que_id' => $quesId,
                'ans_yes_no' => '',
                'ans_comment' => $myVal
            );
        } elseif ($type == 'yesno') {
            if (empty($myVal))
                $myVal = 0;
            $insertArray = array(
                'ans_su_id' => $suId,
                'ans_que_id' => $quesId,
                'ans_yes_no' => $myVal,
                'ans_comment' => ''
            );
        }
        $lastId = 0;
        if (!empty($insertArray)) {
            $whereArr = array(
                'ans_su_id' => $suId,
                'ans_que_id' => $quesId
            );
            $this->db->where($whereArr);
            $this->db->select('ans_id');
            $result = $this->db->get('plused_survey_answers'); // CHECK FOR UPDATE
            if ($result->num_rows()) {
                $ansId = $result->row()->ans_id;
                $this->db->flush_cache();
                $this->db->where('ans_id', $ansId);
                $this->db->update('plused_survey_answers', $insertArray); // UDPATE EXISTING 
                $lastId = $ansId;
            } else {
                $this->db->flush_cache();
                $this->db->insert('plused_survey_answers', $insertArray); // INSERT NEW RECORD
                $lastId = $this->db->insert_id();
            }
        }
        return $lastId;
    }

    function markSurveyAsCompleted($surveyUserId = 0) {
        if ($surveyUserId) {
            $this->db->where('su_id', $surveyUserId);
            $updateArray = array(
                'su_survey_date' => date("Y-m-d H:i:s"),
                'su_survey_status' => 'Completed'
            );
            $this->db->update('plused_survey_users', $updateArray);
            return $surveyUserId;
        }
        return 0;
    }

    function getQuestionsReport($selAgent, $campusId, $selSurvey, $txtCalFromDate, $txtCalToDate) {
        $this->db->from('plused_survey_questions sq');
        //$this->db->select('que_id,que_report,que_section_sequence,que_section,que_number,que_question,que_isyesno,que_iscomment,que_is_header,que_parent_que_id,ans_id,ans_su_id,ans_que_id,ans_yes_no,ans_comment,su_name,su_email,su_campus_id,su_survey_date,su_survey_status');
        //$this->db->join('plused_survey_answers sa','sq.que_id = sa.ans_que_id','left');
        //$this->db->join('plused_survey_users su',"sa.ans_su_id = su.su_id",'left');
        // $this->db->where("((su_survey_date >= '".$txtCalFromDate."' AND su_survey_date <= '".$txtCalToDate."'))");
        //if(is_array($campusesIds)){
        //$this->db->where_in('su_campus_id',$campusesIds);
        //}
        $this->db->group_by('que_id');
        $this->db->where('que_report', $selSurvey);

        $this->db->order_by('que_section_sequence,que_number', 'asc');
        $result = $this->db->get();
        $returnArr = array();
        if ($result->num_rows()) {
            foreach ($result->result_array() as $row) {
                $resultArr = $this->getAnswerInPercent($row['que_id'], $selAgent, $campusId, $txtCalFromDate, $txtCalToDate);
                $row['yes_count'] = $resultArr[0]['yes_count'];
                $row['no_count'] = $resultArr[0]['no_count'];
                $row['comment_count'] = $resultArr[0]['comment_count'];
                array_push($returnArr, $row);
            }
        }
        return $returnArr;
    }

    function getAnswerInPercent($questionId, $selAgent, $campusId, $txtCalFromDate, $txtCalToDate) {
        if (!empty($selAgent) && !empty($campusId) && !empty($questionId)) {//&& !empty($txtCalFromDate) && !empty($txtCalToDate)//id_agente
            $agentQuery = '';
            if ($selAgent != 'all') {
                $agentQuery = "AND `pb`.`id_agente` = " . $selAgent;
            }
            $strSQL = "SELECT COUNT(yes) as yes_count, count(no) as no_count, count(comment_count) as comment_count from 
                        (	
                        SELECT 
                                CASE WHEN `ans_yes_no` = 1 THEN '1' END AS yes, 
                                CASE WHEN `ans_yes_no` = 0 THEN '1' END AS no,
								CASE WHEN `ans_comment` IS NOT NULL AND `ans_comment` != '' THEN 1 ELSE 0 END AS comment_count
                                FROM (`plused_survey_answers` sa) 
                                JOIN `plused_survey_users` su ON `sa`.`ans_su_id` = `su`.`su_id` 
                                JOIN `plused_rows` pr ON `su`.`su_group_leader_uuid` = `pr`.`uuid` 
                                JOIN `plused_book` pb ON `pb`.`id_book` = `pr`.`id_book` 
                                WHERE ((data_arrivo_campus >= '" . $txtCalFromDate . "' AND data_arrivo_campus <= '" . $txtCalToDate . "') OR (data_partenza_campus >= '" . $txtCalFromDate . "' AND data_partenza_campus <= '" . $txtCalToDate . "'))
                                AND `ans_que_id` = " . $questionId . " " . $agentQuery . " 
                                AND `su_survey_status` = 'Completed' 
                                AND `su_campus_id` = " . $campusId . "  
                        ) as Tcount";
            //((su_survey_date >= '".$txtCalFromDate."' AND su_survey_date <= '".$txtCalToDate."')) 
            //                   AND
            //echo $strSQL;die;
            $result = $this->db->query($strSQL);
            if ($result->num_rows())
                return $result->result_array();
            else
                return array(array('yes_count' => 0, 'no_count' => 0));
        } else
            return array(array('yes_count' => 0, 'no_count' => 0));
    }

    function getSurveyUsers($queId, $yesnoType, $fd, $td, $campusId, $agentId) {
        if ($agentId != 'all') {
            $this->db->where('plused_book.id_agente', $agentId);
        }
        $this->db->where('ans_que_id', $queId);
        $this->db->where('ans_yes_no', $yesnoType);
        $this->db->where('plused_book.id_centro', $campusId);
        $this->db->where('su_survey_status', 'Completed');
        $this->db->where("((data_arrivo_campus >= '" . $fd . "' AND data_arrivo_campus <= '" . $td . "') OR (data_partenza_campus >= '" . $fd . "' AND data_partenza_campus <= '" . $td . "'))"); //data_partenza_campus
        $this->db->select('su_id,su_group_leader_uuid,su_report,su_name,su_email,su_campus_id,su_survey_date,su_survey_status');
        $this->db->join('plused_survey_users', 'plused_survey_users.su_id = plused_survey_answers.ans_su_id');
        $this->db->join('plused_rows', "plused_rows.uuid = plused_survey_users.su_group_leader_uuid"); //changed the refference to pax uuid
        $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book');
        $result = $this->db->get('plused_survey_answers');
        //echo $this -> db -> last_query();die;
        if ($result->num_rows()) {
            return $result->result_array();
        } else
            return 0;
    }

    function getSurveyCommentText($queId, $fd, $td, $campusId, $agentId, $reportType, $suId, $section) {
        if ($agentId != 'all') {
            $this->db->where('plused_book.id_agente', $agentId);
        }
        $this->db->where('que_iscomment', 1);
        $this->db->where('que_section', $section);
        $this->db->where('que_report', $reportType);
        $this->db->where('plused_book.id_centro', $campusId);
        $this->db->where('plused_survey_users.su_id', $suId);
        $this->db->where('su_survey_status', 'Completed');
        $this->db->group_by('plused_survey_users.su_id');
        $this->db->where("((data_arrivo_campus >= '" . $fd . "' AND data_arrivo_campus <= '" . $td . "') OR (data_partenza_campus >= '" . $fd . "' AND data_partenza_campus <= '" . $td . "'))"); //data_partenza_campus
        $this->db->select('ans_comment');
        $this->db->join('plused_survey_users', 'plused_survey_users.su_id = plused_survey_answers.ans_su_id');
        $this->db->join('plused_rows', "plused_rows.uuid = plused_survey_users.su_group_leader_uuid"); //changed the refference to pax uuid
        $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book');
        $this->db->join('plused_survey_questions', 'plused_survey_questions.que_id = plused_survey_answers.ans_que_id');
        $result = $this->db->get('plused_survey_answers');
//		echo $this -> db -> last_query();die;
        if ($result->num_rows()) {
            $resulArray = $result->result_array();
            return $resulArray[0]['ans_comment'];
        } else
            return 0;
    }

    function getSurveyAnsText($queId, $fd, $td, $campusId, $agentId, $reportType, $suId, $section) {
        if ($agentId != 'all') {
            $this->db->where('plused_book.id_agente', $agentId);
        }
        $this->db->where('que_iscomment', 0);
        $this->db->where('que_isyesno', 0);
        $this->db->where('que_is_header', 0);
        $this->db->where('que_section', $section);
        $this->db->where('que_report', $reportType);
        $this->db->where('plused_book.id_centro', $campusId);
        $this->db->where('plused_survey_users.su_id', $suId);
        $this->db->where('su_survey_status', 'Completed');
        $this->db->group_by('plused_survey_users.su_id');
        $this->db->where("((data_arrivo_campus >= '" . $fd . "' AND data_arrivo_campus <= '" . $td . "') OR (data_partenza_campus >= '" . $fd . "' AND data_partenza_campus <= '" . $td . "'))"); //data_partenza_campus
        $this->db->select('ans_comment');
        $this->db->join('plused_survey_users', 'plused_survey_users.su_id = plused_survey_answers.ans_su_id');
        $this->db->join('plused_rows', "plused_rows.uuid = plused_survey_users.su_group_leader_uuid"); //changed the refference to pax uuid
        $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book');
        $this->db->join('plused_survey_questions', 'plused_survey_questions.que_id = plused_survey_answers.ans_que_id');
        $result = $this->db->get('plused_survey_answers');
//		echo $this -> db -> last_query();die;
        if ($result->num_rows()) {
            $resulArray = $result->result_array();
            return $resulArray[0]['ans_comment'];
        } else
            return 0;
    }

    function getReportType($queId) {
        $this->db->select('que_report')
                ->from('plused_survey_questions')
                ->where('que_id', $queId);
        $result = $this->db->get();
        if ($result->num_rows()) {
            return $result->result_array();
        } else
            return 0;
    }

    function getCommentList($suId, $reportType) {
        $this->db->select('que_section, ans_comment')
                ->from('plused_survey_answers')
                ->join('plused_survey_questions', 'plused_survey_questions.que_id = plused_survey_answers.ans_que_id')
                ->where('que_report', $reportType)
                ->where('plused_survey_answers.ans_su_id', $suId)
                ->where('que_iscomment', 1);
        $result = $this->db->get();
        if ($result->num_rows()) {
            return $result->result_array();
        } else
            return 0;
    }

    function getAgents($campusId, $fd, $td) {
        $this->db->where('tipo_pax', 'GL');
        $this->db->where('plused_book.id_centro', $campusId);
        $this->db->where("((data_arrivo_campus >= '" . $fd . "' AND data_arrivo_campus <= '" . $td . "') OR (data_partenza_campus >= '" . $fd . "' AND data_partenza_campus <= '" . $td . "'))"); //data_partenza_campus
        $this->db->select('data_arrivo_campus,data_partenza_campus,plused_book.id_centro,agenti.id as agent_id,businessname as agent_businessname');
        $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book');
        $this->db->join('agenti', 'plused_book.id_agente = agenti.id');
        //su_survey_status
        //$this->db->join('plused_survey_users','plused_rows.id_prenotazione = plused_survey_users.su_group_leader_id','left');
        $this->db->group_by('agenti.id');
        $result = $this->db->get("plused_rows");
        if ($result->num_rows()) {
            return $result->result_array();
        } else
            return 0;
    }

    function getAgentsSurvey($agentId, $selSurvey, $campusId, $fd, $td) {
        if ($agentId != 'all') {
            $this->db->where('agenti.id', $agentId);
        }
        $this->db->where('tipo_pax', 'GL');
        $this->db->where('plused_book.id_centro', $campusId);

        $this->db->where("((data_arrivo_campus >= '" . $fd . "' AND data_arrivo_campus <= '" . $td . "') OR (data_partenza_campus >= '" . $fd . "' AND data_partenza_campus <= '" . $td . "'))"); //data_partenza_campus
        $this->db->select('agenti.id as agent_id,businessname as agent_businessname,su_survey_status');
        $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book');
        $this->db->join('agenti', 'plused_book.id_agente = agenti.id');
        //su_survey_status
        $this->db->join('plused_survey_users', "plused_rows.uuid = plused_survey_users.su_group_leader_uuid AND su_report = '" . $selSurvey . "'", 'left'); //changed the refference to pax uuid
        $result = $this->db->get("plused_rows");
        if ($result->num_rows()) {
            return $result->result_array();
        } else
            return 0;
    }

    /* Start: Functions by Arunsankar */

    function getStudentAgents($campusId, $fd, $td) {
        $this->db->where('tipo_pax', 'STD');
        $this->db->where('plused_book.id_centro', $campusId);
        $this->db->where("((data_arrivo_campus >= '" . $fd . "' AND data_arrivo_campus <= '" . $td . "') OR (data_partenza_campus >= '" . $fd . "' AND data_partenza_campus <= '" . $td . "'))"); //data_partenza_campus
        $this->db->select('data_arrivo_campus,data_partenza_campus,plused_book.id_centro,agenti.id as agent_id,businessname as agent_businessname');
        $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book');
        $this->db->join('agenti', 'plused_book.id_agente = agenti.id');
        //su_survey_status
        //$this->db->join('plused_survey_users','plused_rows.id_prenotazione = plused_survey_users.su_group_leader_id','left');
        $this->db->group_by('agenti.id');
        $result = $this->db->get("plused_rows");
        if ($result->num_rows()) {
            return $result->result_array();
        } else
            return 0;
    }

    function getSurveyList() {
        $this->db->select('*')
                ->from('plused_test_student')
                ->where('test_type', 'Survey');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    function getStudentSurvey($agentId, $selSurvey, $campusId, $fd, $td) {
        $this->db->where('tipo_pax', 'GL');
        $this->db->where('plused_book.id_centro', $campusId);
        $this->db->where('agenti.id', $agentId);
        $this->db->where("((data_arrivo_campus >= '" . $fd . "' AND data_arrivo_campus <= '" . $td . "') OR (data_partenza_campus >= '" . $fd . "' AND data_partenza_campus <= '" . $td . "'))"); //data_partenza_campus
        $this->db->select('agenti.id as agent_id,businessname as agent_businessname,su_survey_status');
        $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book');
        $this->db->join('agenti', 'plused_book.id_agente = agenti.id');
        //su_survey_status
        $this->db->join('plused_survey_users', "plused_rows.uuid = plused_survey_users.su_group_leader_uuid AND su_report = '" . $selSurvey . "'", 'left'); //changed the refference to pax uuid
        $result = $this->db->get("plused_rows");
        //echo $this -> db -> last_query();die;
        if ($result->num_rows()) {
            return $result->result_array();
        } else
            return 0;
    }

    function getSurveyQuestion($testId) {
        $this->db->flush_cache();
        $this->db->select('b.tque_section,b.tque_id ,b.tque_question')
                ->from('plused_test_student as a')
                ->join('plused_test_question as b', 'b.tque_test_id = a.test_id')
                ->join('plused_test_options as c', 'c.opt_que_id = b.tque_id')
                ->where('a.test_id', $testId);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    function getSurveyPercentage($testId, $completedSurveys) {
        if ($completedSurveys) {
            $this->db->select('c.tque_id,b.opt_text, count(b.opt_text) as total, sum(case when a.trans_survey_value = 1 then 1 else 0 end) as poor, sum(case when a.trans_survey_value = 2 then 1 else 0 end) as satisfactory, sum(case when a.trans_survey_value = 3 then 1 else 0 end) as good, sum(case when a.trans_survey_value = 4 then 1 else 0 end) as excellent', false)
                ->from('plused_test_answers as a')
                ->join('plused_test_options as b', 'b.opt_id = a.tans_opt_id')
                ->join('plused_test_question as c', 'c.tque_id = b.opt_que_id')
                ->group_by('c.tque_id')
                ->order_by('c.tque_id');
            $where = '(';
            $count = 1;
            foreach ($completedSurveys as $complete) {
                if ($count == 1) {
                    $where .= "(a.tans_uuid = '" . $complete['ts_uuid'] . "' AND a.tans_week = '" . $complete['ts_week'] . "') ";
                } else if (sizeof($completedSurveys) == $count) {
                    $where .= " OR (a.tans_uuid = '" . $complete['ts_uuid'] . "' AND a.tans_week = '" . $complete['ts_week'] . "') ";
                } else {
                    $where .= " OR (a.tans_uuid = '" . $complete['ts_uuid'] . "' AND a.tans_week = '" . $complete['ts_week'] . "')";
                }
                $count++;
            }
            $where .= ')';
            $this->db->where($where);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                return $result->result_array();
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function getSurveycompletedSurveys($testId, $campusId, $agent, $fd, $td) {
        $this->db->flush_cache();
        if ($agent != 'all') {
            $this->db->where('e.id', $agent);
        }
        $this->db->select('ts_uuid, ts_week')
                ->from('plused_test_submited as a')
                ->join('plused_rows as b', 'b.uuid = a.ts_uuid')
                ->join('plused_book as c', 'c.id_book = b.id_book')
                ->join('centri as d', 'd.id = c.id_centro')
                ->join('agenti as e', 'e.id = c.id_agente')
                //-> where('e.id', $agent)
                ->where('d.id', $campusId)
                ->where('a.ts_test_id', $testId)
                //-> where("a.ts_submitted_on BETWEEN '".$fd."' AND '".$td."'")
                ->where("(SUBSTRING_INDEX(SUBSTRING_INDEX(`ts_week`, '_', 2), '_', -1) BETWEEN '" . $fd . "' AND '" . $td . "')")
                ->group_by('ts_uuid, ts_week');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    function getStudentSurveyUsers($queId, $surType, $fd, $td, $campusId, $agentId) {
        if ($agentId != 'all') {
            $this->db->where('c.id', $agentId);
        }
        $this->db->select("distinct(concat(d.nome,' ', d.cognome)) as name,a.nome_centri, DATE(e.ts_submitted_on) as submitted_date, SUBSTRING_INDEX(SUBSTRING_INDEX(`ts_week`, '_', 1), '_', -1) as week_no, SUBSTRING_INDEX(SUBSTRING_INDEX(`ts_week`, '_', 2), '_', -1) as week_start", false)
                ->from('centri as a')
                ->join('plused_book as b', 'b.id_centro = a.id')
                ->join('agenti as c', 'c.id = b.id_agente')
                ->join('plused_rows as d', 'd.id_book = b.id_book and d.id_year = b.id_year')
                ->join('plused_test_submited as e', 'e.ts_uuid = d.uuid')
                ->join('plused_test_student as f', 'f.test_id = e.ts_test_id')
                ->join('plused_test_question as g', 'g.tque_test_id = f.test_id')
                ->join('plused_test_options as h', 'h.opt_que_id = g.tque_id')
                ->join('plused_test_answers as i', 'i.tans_opt_id = h.opt_id')
                ->where('a.id', $campusId)
                ->where('i.trans_survey_value', $surType)
                ->where('g.tque_id', $queId)
                //-> where('c.id', $agentId)
                ->where('d.tipo_pax', 'STD')
                ->where('e.ts_uuid = i.tans_uuid')
                ->where('i.tans_week = e.ts_week')
                ->where("(SUBSTRING_INDEX(SUBSTRING_INDEX(`ts_week`, '_', 2), '_', -1) BETWEEN '" . $fd . "' AND '" . $td . "')");
        $result = $this->db->get();
//		echo $this -> db -> last_query();die;
        if ($result->num_rows()) {
            return $result->result_array();
        } else
            return 0;
    }

    function getAgentName($agentId) {
        $this->db->select('businessname')
                ->from('agenti')
                ->where('id', $agentId);
        $result = $this->db->get();
        if ($result->num_rows()) {
            $resultArray = $result->result_array();
            return $resultArray[0]['businessname'];
        } else
            return 0;
    }

    public function getBookingsForLogin($userFirstName, $userSurname, $userDOB) {
        $arrivalYear = '2017';
        $this->db->select('CONCAT(plused_rows.id_year,"_",plused_rows.id_book," - ",nome_centri) as booking_id, plused_rows.id_book', false);
        $this->db->join('plused_book', 'plused_book.id_book = plused_rows.id_book');
        $this->db->join('centri', 'centri.id = plused_book.id_centro');
        $this->db->where('cognome', $userSurname);
        $this->db->where('nome', $userFirstName);
        $this->db->where('date(pax_dob)', $userDOB);
        $this->db->where('tipo_pax', 'GL');
        $this->db->where('YEAR(data_partenza_campus)', $arrivalYear);
        $this->db->order_by('id_prenotazione', 'DESC');
        $result = $this->db->get("plused_rows");
        if ($result->num_rows()) {
            return $result->result();
        } else
            return 0;
    }
    
    public function getGroupLeader($campusId,$survey,$agentId, $fd, $td){
        //$this->db->where('tipo_pax', 'GL');
        if(!empty($agentId) && $agentId != "all")
            $this->db->where('plused_book.id_agente', $agentId);
        $this->db->where('plused_book.id_centro', $campusId);
        $this->db->where('plused_book.status', "confirmed");
        $this->db->where("concat(plused_rows.nome,' ',plused_rows.cognome) != ' '");
        $this->db->where("plused_rows.tipo_pax","GL");
        $this->db->where("((data_arrivo_campus >= '" . $fd . "' AND data_arrivo_campus <= '" . $td . "') OR (data_partenza_campus >= '" . $fd . "' AND data_partenza_campus <= '" . $td . "'))"); //data_partenza_campus
        $this->db->select('plused_rows.cognome,plused_rows.nome,plused_rows.uuid');
        $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book');
        $this->db->join('agenti', 'plused_book.id_agente = agenti.id');
        $this->db->order_by('plused_rows.cognome');
        //su_survey_status
       // $this->db->join('plused_survey_users','plused_rows.uuid = plused_survey_users.su_group_leader_uuid');
        $result = $this->db->get("plused_rows");
        if ($result->num_rows()) {
            return $result->result_array();
        } else
            return 0;
    }
    
    function getStudentSurveyDetails($hidd_GlId,$selGroupLeaderName,$hidd_survey, $fd, $td, $campusId, $agentId) {
        if ($agentId != 'all') {
            $this->db->where('c.id', $agentId);
        }
        $this->db->select("distinct(concat(d.cognome,' ', d.nome)) as name,
                    b.id_book,
                    b.id_year,
                    d.uuid,
                    d.id_prenotazione,
                    a.nome_centri, DATE(e.ts_submitted_on) as submitted_date, 
                    SUBSTRING_INDEX(SUBSTRING_INDEX(`ts_week`, '_', 1), '_', -1) as week_no, 
                    SUBSTRING_INDEX(SUBSTRING_INDEX(`ts_week`, '_', 2), '_', -1) as week_start", false)
                ->from('centri as a')
                ->join('plused_book as b', 'b.id_centro = a.id')
                ->join('agenti as c', 'c.id = b.id_agente')
                ->join('plused_rows as d', 'd.id_book = b.id_book and d.id_year = b.id_year')
                ->join('plused_test_submited as e', 'e.ts_uuid = d.uuid')
                /*->join('plused_test_student as f', 'f.test_id = e.ts_test_id')
                ->join('plused_test_question as g', 'g.tque_test_id = f.test_id')
                ->join('plused_test_options as h', 'h.opt_que_id = g.tque_id')
                ->join('plused_test_answers as i', 'i.tans_opt_id = h.opt_id')*/
                ->where('a.id', $campusId)
                ->where('e.ts_test_id', $hidd_survey)
                ->where('LOWER(TRIM(d.gl_rif))', strtolower(trim($selGroupLeaderName)))
                //->where('i.trans_survey_value', $surType)
                //->where('g.tque_id', $queId)
                //-> where('c.id', $agentId)
                ->where('d.tipo_pax', 'STD')
                //->where('e.ts_uuid = i.tans_uuid')
                //->where('i.tans_week = e.ts_week')
                ->where("(SUBSTRING_INDEX(SUBSTRING_INDEX(`ts_week`, '_', 2), '_', -1) BETWEEN '" . $fd . "' AND '" . $td . "')");
        $result = $this->db->get();
//		echo $this -> db -> last_query();die;
        if ($result->num_rows()) {
            return $result->result_array();
        } else
            return 0;
    }

    /* End: Functions by Arunsankar */
}
