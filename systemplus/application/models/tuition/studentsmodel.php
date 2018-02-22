<?php

/**
 * Model for students
 * @author SK
 * @since 18-july-2016
 */
class Studentsmodel extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * verifySTDUser
     * this function is uses to verify teachers application user to authenticate for personal login.
     * @param string $userFirstName
     * @param string $userSurname
     * @param string $userDOB
     * @return mixed 
     */
    public function verifySTDUser($userFirstName, $userSurname, $userDOB) {
        $this->db->where('cognome', $userSurname);
        $this->db->where('nome', $userFirstName);
        $this->db->where('date(pax_dob)', $userDOB);
        $this->db->where('tipo_pax', 'STD');
        $this->db->order_by('id_prenotazione', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get("plused_rows");
        if ($result->num_rows()) {
            return $result->row();
        } else
            return 0;
    }

    /**
     * getUserdata
     * @param INT $id
     * @return int 
     */
    public function getUserdata($id) {
        $this->db->where('tipo_pax', 'STD');
        $this->db->where('id_prenotazione', $id);
        $this->db->select('id_prenotazione,uuid,cognome,nome,tipo_pax,pax_dob,data_arrivo_campus,data_partenza_campus,id_centro,nome_centri');
        $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book', 'left');
        $this->db->join('centri', 'plused_book.id_centro = centri.id', 'left');
        $result = $this->db->get("plused_rows");
        if ($result->num_rows()) {
            return $result->row();
        } else
            return 0;
    }

    /**
     * getTestQuestions
     * This functon list the all question available for test and answer given by student if any
     * @param int $testId
     * @param string $userUUID
     * @return mixed 
     */
    public function getTestQuestions($testId = 0, $userUUID = "") {
        if (!empty($testId)) {
            $this->db->where('test_id', $testId);
            $this->db->where('test_type', 'Test');

            $this->db->select("test_id,test_title,tque_id,tque_test_id,tque_question,tque_section,group_concat(opt_id,'#',opt_text ORDER BY opt_id SEPARATOR '||') as que_options,
                tans_opt_id as std_marked_option", false);

            $this->db->join('plused_test_question', 'test_id = tque_test_id');
            $this->db->join('plused_test_options', 'tque_id = opt_que_id');
            $this->db->join('plused_test_answers', "tque_id = tans_ques_id AND tans_uuid = '" . $userUUID . "'", 'LEFT');
            $this->db->group_by('tque_id');
            // $this->db->order_by('tque_id,opt_id','DESC');
            $result = $this->db->get('plused_test_student');
            if ($result->num_rows()) {
                return $result->result_array();
            }
        } else
            return 0;
    }

    /**
     * updateQuestionAnswer
     * This function used to update answer agains students uuid and test question
     * @param int $questionId
     * @param int $optionId
     * @param string $userUUID
     * @return int 
     */
    public function updateQuestionAnswer($questionId, $optionId, $userUUID) {
        $whereData = array(
            'tans_uuid' => $userUUID,
            'tans_ques_id' => $questionId
        );
        $this->db->where($whereData);
        $result = $this->db->get('plused_test_answers');
        if ($result->num_rows()) {
            // udpate the answer
            $updateData = array(
                'tans_opt_id' => $optionId,
                'tans_uuid' => $userUUID,
                'tans_ques_id' => $questionId
            );
            $this->db->where($whereData);
            $this->db->update('plused_test_answers', $updateData);
            return 1;
        } else {
            // add new record
            $insertData = array(
                'tans_opt_id' => $optionId,
                'tans_uuid' => $userUUID,
                'tans_ques_id' => $questionId
            );
            $this->db->insert('plused_test_answers', $insertData);
            return 1;
        }
    }

    /**
     * submitTest
     * Used to submit students test finally.
     * @param int $testId
     * @param string $userUUID
     * @param string $testSubmittedDate
     * @return int 
     */
    public function submitTest($testId, $userUUID, $testSubmittedDate) {
        if (!empty($testId) && !empty($userUUID) && !empty($testSubmittedDate)) {
            $insertData = array(
                'ts_uuid' => $userUUID,
                'ts_test_id' => $testId,
                'ts_submitted_on' => $testSubmittedDate,
            );

            $whereArr = array(
                'ts_uuid' => $userUUID,
                'ts_test_id' => $testId
            );
            $this->db->where($whereArr);
            $result = $this->db->get('plused_test_submited');
            if ($result->num_rows()) {
                return -1;
            } else {
                $this->db->insert('plused_test_submited', $insertData);
                return $this->db->insert_id();
            }
        } else
            return 0;
    }

    /**
     * checkAlreadySubmited
     * Check student has already submitted the same test or not?
     * @param int $testId
     * @param string $userUUID
     * @return int 
     */
    public function checkAlreadySubmited($testId, $userUUID) {
        if (!empty($testId) && !empty($userUUID)) {
            $this->db->where('ts_uuid', $userUUID);
            $this->db->where('ts_test_id', $testId);
            $result = $this->db->get('plused_test_submited');
            if ($result->num_rows())
                return 1;
            else
                return 0;
        }
        else {
            return 0;
        }
    }

    /**
     * getStudentTestData
     * this funtion return array of students result agains test
     * it calculates number of question asked in test and 
     * number of correct answer given by students
     * @param int $testId
     * @param string $keyword
     * @return int 
     */
    public function getStudentTestData($testId = 0, $keyword = "", $params = array()) {
        $this->db->select("ts_submitted_on,test_title,
            COUNT(tque_id) AS total_questions,SUM(CASE WHEN opt_correct_answer = 1 AND opt_id = tans_opt_id THEN 1 ELSE 0 END) AS correct_answers,
            cognome,nome,plused_rows.id_book,plused_rows.id_year,nome_centri", false);
        $this->db->join('plused_test_student', 'ts_test_id = test_id');
        $this->db->join('plused_test_question', 'test_id = tque_test_id');
        $this->db->join('plused_test_options', 'tque_id = opt_que_id');
        $this->db->join('plused_test_answers', 'tque_id = tans_ques_id AND ts_uuid = tans_uuid', 'LEFT');
        $this->db->join('plused_rows', 'ts_uuid = uuid', 'LEFT');
        $this->db->join('plused_book', 'plused_rows.id_book = plused_book.id_book', 'LEFT');
        $this->db->join('centri', 'centri.id = plused_book.id_centro', 'LEFT');
        $this->db->group_by('test_id,uuid');
        $this->db->where('test_type', 'Test');
        $this->db->where('opt_correct_answer', 1);

        if (!empty($testId))
            $this->db->where('test_id', $testId);

        if (!empty($keyword)) {
            $keyword = mysql_real_escape_string($keyword);
            $this->db->where("(
                        nome like '%" . $keyword . "%' OR
                        cognome like '%" . $keyword . "%' OR
                        concat(cognome,' ',nome) like '%" . $keyword . "%')
                    ");
        } else {
            $this->db->where("nome !=",'');
        }
        if (!empty($params)) {
            $this->db->limit($params['offset'], $params['start']);
            $this->db->order_by($params['column'], $params['type']);
        }

        $result = $this->db->get('plused_test_submited');

        if ($result->num_rows()) { 
            return $result->result_array();
        }
        return 0;
    }

    public function getStudentTestCount($testId = 0, $keyword = "", $param = array()) {
        $this->db->select("count(DISTINCT(test_id)) as count");
        $this->db->from('plused_test_submited');
        $this->db->join('plused_test_student', 'ts_test_id = test_id');
        $this->db->join('plused_test_question', 'test_id = tque_test_id');
        $this->db->join('plused_test_options', 'tque_id = opt_que_id');
        $this->db->join('plused_test_answers', 'tque_id = tans_ques_id AND ts_uuid = tans_uuid', 'LEFT');
        $this->db->join('plused_rows', 'ts_uuid = uuid', 'LEFT');
        $this->db->group_by('test_id,uuid');
        $this->db->where('test_type', 'Test');
        $this->db->where('opt_correct_answer', 1);

        if (!empty($testId))
            $this->db->where('test_id', $testId);

        if (!empty($keyword)) {
            $keyword = mysql_real_escape_string($keyword);
            $this->db->where("(
                        nome like '%" . $keyword . "%' OR
                        cognome like '%" . $keyword . "%' OR
                        concat(cognome,' ',nome) like '%" . $keyword . "%')
                    ");
        } else {
            $this->db->where("(nome like '%%')");
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * getStudentTest
     * list students test for select dropdown
     * @return mixed
     */
    public function getStudentTest() {
        $this->db->where('test_type', 'Test');
        $result = $this->db->get('plused_test_student');
        if ($result->num_rows()) {
            return $result->result_array();
        }
        return 0;
    }

    /**
     * Retrive students test score
     * @param int $testId
     * @param string $userUUID
     * @return int 
     */
    public function getStudentTestScore($testId = 0, $userUUID = "") {
        $this->db->select("COUNT(tque_id) AS total_questions,
            SUM(CASE WHEN opt_correct_answer = 1 AND opt_id = tans_opt_id THEN 1 ELSE 0 END) AS correct_answers", false);
        $this->db->join('plused_test_student', 'ts_test_id = test_id');
        $this->db->join('plused_test_question', 'test_id = tque_test_id');
        $this->db->join('plused_test_options', 'tque_id = opt_que_id');
        $this->db->join('plused_test_answers', 'tque_id = tans_ques_id AND ts_uuid = tans_uuid', 'LEFT');
        //$this->db->group_by('test_id,ts_uuid');
        $this->db->where('test_type', 'Test');
        $this->db->where('opt_correct_answer', 1);

        $this->db->where('test_id', $testId);
        $this->db->where('ts_uuid', $userUUID);
        $result = $this->db->get('plused_test_submited');
        if ($result->num_rows()) {
            return $result->row();
        }
        return 0;
    }

    /**
     * addTestScore
     * This function will save test score for language knowledge
     * @param int $testId
     * @param string $userUUID
     * @return int 
     */
    public function addTestScore($testId, $userUUID) {
        $result = $this->getStudentTestScore($testId, $userUUID);
        if ($result) {
            $totalQuestion = $result->total_questions;
            $correctAnswer = $result->correct_answers;
            // check old record
            $this->db->where('lk_uuid', $userUUID);
            $resultData = $this->db->get('plused_language_knowledge');
            $updateRow = array(
                'lk_lang_knowledge' => $correctAnswer,
                'lk_english_test_score' => $correctAnswer,
                'lk_uuid' => $userUUID
            );
            if ($resultData->num_rows()) {
                // update data
                $row = $resultData->row();
                $lk_id = $row->lk_id;
                if ($lk_id) {
                    $this->db->flush_cache();
                    $updateRow = array(
                        'lk_lang_knowledge' => $row->lk_oral_test + $row->lk_listening_comprehension + $correctAnswer,
                        'lk_english_test_score' => $correctAnswer,
                        'lk_uuid' => $userUUID
                    );
                    $this->db->where('lk_id', $lk_id);
                    $this->db->update('plused_language_knowledge', $updateRow);
                    $result = 1;
                } else {
                    $this->db->flush_cache();
                    $this->db->insert('plused_language_knowledge', $updateRow);
                    $result = 1;
                }
            } else {
                $this->db->flush_cache();
                $this->db->insert('plused_language_knowledge', $updateRow);
                $result = 1;
            }
        } else
            $result = 0;
        return $result;
    }

    public function checkCDUserEnteredMarks($uuid) {
        if (!empty($uuid)) {
            $this->db->where('lk_uuid', $uuid);
            $this->db->where('lk_english_test_score > ', 0);
            $this->db->where('is_opted_offline', 1);
            $result = $this->db->get('plused_language_knowledge');
            if ($result->num_rows())
                return 1;
            else
                return 0;
        }
        else {
            return 0;
        }
    }

}
