<?php

class Studentsurveymodel extends Model {

	function __construct() {
		parent::__construct();
	}

	/**
	 * Function to get the user data from the given id
	 * @author Arunsankar
	 * @since 18-07-2016
	 * @param int $id
	 * @return array
	 */
	public function getUserdata($id) {
		$this -> db -> select('a.id_prenotazione,a.uuid,a.cognome,a.nome,a.tipo_pax,a.pax_dob,a.data_arrivo_campus,a.data_partenza_campus,b.id_centro,c.nome_centri,b.weeks, d.businessname')
				-> from('plused_rows as a')
				-> join('plused_book as b', 'a.id_book = b.id_book', 'left')
				-> join('centri as c', 'b.id_centro = c.id', 'left')
				-> join('agenti as d', 'b.id_agente = d.id')
				-> where('a.tipo_pax', 'STD')
				-> where('a.id_prenotazione', $id);
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			$resulArray = $result -> result_array();
			return $resulArray[0];
		}
		else
			return 0;
	}

	/**
	 * Function to get the Group leader from the student id
	 * @author Arunsankar
	 * @since 18-07-2016
	 * @param type $id
	 * @return boolean
	 */
	function getGLName($id) {
                $this -> db -> select('gl_rif')
                                -> from('plused_rows')
                                -> where('id_prenotazione', $id);
                $result = $this -> db -> get();
                if ($result -> num_rows() > 0) {
                        $resultArray = $result -> result_array();
                        return $resultArray[0]['gl_rif'];
                }
                return FALSE;
	}

	/**
	 * Function to get the question and options
	 * @author Arunsankar
	 * @since 18-07-2016
	 * @param string $type
	 * @param string $uuid
	 * @param string $week
	 * @return array
	 */
	function getQuestions($type, $uuid, $week) {
		$this -> db -> select('b.tque_section, b.tque_question, d.opt_text, d.opt_id, e.trans_survey_value')
				-> from('plused_test_student as a')
				-> join('plused_test_question as b', 'b.tque_test_id = a.test_id')
				-> join('plused_test_student as c', 'c.test_id=b.tque_test_id')
				-> join('plused_test_options as d', 'd.opt_que_id=b.tque_id')
				-> join('plused_test_answers as e', "e.tans_opt_id=d.opt_id AND e.tans_uuid='" . $uuid . "' AND e.tans_week = '" . $week . "'", 'left')
				-> where('c.test_type', $type);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			return $result -> result_array();
		}
		return FALSE;
	}

	/**
	 * Function to finally submit the survey details
	 * @author Arunsankar
	 * @since 18-07-2016
	 * @param array $data
	 * @return array
	 */
	function insertSurvey($data) {
		$this -> db -> select('tans_opt_id')
				-> from('plused_test_answers')
				-> where('tans_uuid', $data['ts_uuid'])
				-> where('tans_week', $data['ts_week']);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			$notIn = array();
			foreach ($resultArray as $value) {
				$notIn[] = $value['tans_opt_id'];
			}
			$this -> db -> select('tque_id')
					-> from('plused_test_question as a')
					-> join('plused_test_options as b', 'b.opt_que_id=a.tque_id')
					-> where_not_in('b.opt_id', $notIn)
					-> where('a.tque_test_id', $data['ts_test_id']);
			$result = $this -> db -> get();
			if ($result -> num_rows() > 0) {
				$resultArray = $result -> result_array();
				
				foreach ($resultArray as $val) {
					$insData = array(
						'tans_opt_id' => $val['tque_id'],
						'tans_uuid' => $data['ts_uuid'],
						'tans_week' => $data['ts_week'],
						'trans_survey_value' => 0
					);
					$this -> db -> insert('plused_test_answers', $insData);
				}
			}
		}
		else{
			$this -> db -> select('tque_id')
					-> from('plused_test_question as a')
					-> join('plused_test_options as b', 'b.opt_que_id=a.tque_id')
					-> where('a.tque_test_id', $data['ts_test_id']);
			$result = $this -> db -> get();
			if ($result -> num_rows() > 0) {
				$resultArray = $result -> result_array();
				
				foreach ($resultArray as $val) {
					$insData = array(
						'tans_opt_id' => $val['tque_id'],
						'tans_uuid' => $data['ts_uuid'],
						'tans_week' => $data['ts_week'],
						'trans_survey_value' => 0
					);
					$this -> db -> insert('plused_test_answers', $insData);
				}
			}
		}
		if ($this -> db -> insert('plused_test_submited', $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Get the submitted week list by the student
	 * @author Arunsankar
	 * @since 18-07-2016
	 * @param string $uuid
	 * @param string $test
	 * @return array
	 */
	function getSTDFilledWeeks($uuid, $test) {
		$this -> db -> select('ts_week')
				-> from('plused_test_submited')
				-> where('ts_uuid', $uuid)
				-> where('ts_test_id', $test);
		$result = $this -> db -> get();
		//echo $this -> db -> last_query();die;
		if ($result -> num_rows() > 0) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Function to get the status of each survey
	 * @author Arunsankar
	 * @since 18-07-2016
	 * @param string $uuid
	 * @param date $weekStart
	 * @return int
	 */
	function getSurveyStatus($uuid, $weekStart) {
		$returnArray = array();
		foreach ($weekStart as $week) {
			$this -> db -> select('count(*) as count ')
					-> from('plused_test_answers')
					-> where('tans_uuid', $uuid)
					-> where('SUBSTRING_INDEX(SUBSTRING_INDEX(`tans_week`, \'_\', 2), \'_\', -1) = \'' . $week . '\'');
			$result = $this -> db -> get();
			if ($result -> num_rows() > 0) {
				$resultArray = $result -> result_array();
				$returnArray[$week] = $resultArray[0]['count'];
			}
		}
		return $returnArray;
	}

	/**
	 * Function to store temporarily the survey details
	 * @author Arunsankar
	 * @since 20-07-2016
	 * @param array $data
	 * @return boolean
	 */
	function storeStudentSurvey($data) {
		$this -> db -> select('count(*) as count, tans_id')
				-> from('plused_test_answers')
				-> where('tans_uuid', $data['tans_uuid'])
				-> where('tans_week', $data['tans_week'])
				-> where('tans_opt_id', $data['tans_opt_id'])
				-> limit(1);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			if (!$resultArray[0]['tans_id']) {
				if ($this -> db -> insert('plused_test_answers', $data)) {
					return TRUE;
				}
				else {
					return FALSE;
				}
			}
			else {
				$this -> db -> where('tans_id', $resultArray[0]['tans_id']);
				$updateData = array(
					'trans_survey_value' => $data['trans_survey_value']
				);
				if ($this -> db -> update('plused_test_answers', $updateData)) {
					return TRUE;
				}
				else {
					return FALSE;
				}
			}
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Function to get the details of the test from its name
	 * @author Arunsankar
	 * @since 20-07-2016
	 * @param string $tesType
	 * @return array
	 */
	function getTestDetails($tesType) {
		$this -> db -> select('*')
				-> from('plused_test_student')
				-> where('test_type', $tesType);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			return $resultArray[0];
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Function to test whether the given survey is completed or not
	 * @author Arunsankar
	 * @since 20-07-2016
	 * @param string $uuid
	 * @param int $testId
	 * @param string $week
	 * @return boolean
	 */
	function getSurveyCompleted($uuid, $testId, $week) {
		$this -> db -> select('count(*) as count')
				-> from('plused_test_submited')
				-> where('ts_uuid', $uuid)
				-> where('ts_test_id', $testId)
				-> where('ts_week', $week);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			if ($resultArray[0]['count'] > 0) {
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
		else {
			return FALSE;
		}
	}
}

