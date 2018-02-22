<?php

/**
 * @Programmer  : Arunsankar
 * @Maintainer  : Arunsankar
 * @Created     : 18-July-2016
 * @Modified    : 27-July-2016
 * @Description : survey used to authenticate pulsed_row user pax with type STD
 */
class Student_survey extends Controller {

	public function __construct() {

		parent::Controller();
                authSessionMenu($this);
		$this -> load -> helper(array('form', 'url'));
                $this->load->library(array('session', 'email'));
		$this -> load -> model('tuition/studentsurveymodel', 'studentsmodel');
	}

	/**
	 * Function to redirect to the view by default
	 * @author Arunsankar
	 * @since 18-07-2016
	 */
	function index() {
		$this -> view();
	}

	/**
	 * Function to view the survey page
	 * @author Arunsankar
	 * @since 18-07-2016
	 * @param date $date
	 */
	function view($date = '') {
		if ($this -> session -> userdata('role') == 502) {
			$data['title'] = "plus-ed.com | Take student survey";
			$data['breadcrumb1'] = 'Test / Survey';
			$data['breadcrumb2'] = 'Take student survey';
			$data['userId'] = $this -> session -> userdata('id');
			$data['userDetails'] = $this -> studentsmodel -> getUserdata($data['userId']);
			$data['GLName'] = $this -> studentsmodel -> getGLName($data['userId']);
			$testDetails = $this -> studentsmodel -> getTestDetails('Survey');
			$data['filledWeeks'] = $this -> studentsmodel -> getSTDFilledWeeks($data['userDetails']['uuid'], $testDetails['test_id']); //The list of survey submitted weeks
			$data['testTitle'] = $testDetails['test_title'];
			$data['testType'] = $testDetails['test_type'];
			$data['testId'] = $testDetails['test_id'];
			$data['week'] = $data['userDetails']['weeks'];
			$weekNo = $this -> diffInWeeks($data['userDetails']['data_arrivo_campus'], date('Y-m-d', strtotime($data['userDetails']['data_partenza_campus'] . ' -1 day')));
			$data['weekStart'] = array();
			$weekDay = 7;
			$currDate = date("Y-m-d");

			//Split the weeks from the date range and save in an array
			for ($i = 1; $i <= $weekNo; $i++) {
				if ($i == 1) {
					$data['weekStart'][$i] = date('Y-m-d', strtotime($data['userDetails']['data_arrivo_campus']));
				}
				else {
					if (date('Y-m-d', strtotime($data['weekStart'][$i - 1] . ' +7 days')) > $data['userDetails']['data_partenza_campus']) {
						$data['weekStart'][$i] = $data['userDetails']['data_partenza_campus'];
					}
					else {
						$data['weekStart'][$i] = date('Y-m-d', strtotime($data['weekStart'][$i - 1] . ' +7 days'));
					}
				}
			}
			if (!empty($date) && !in_array($date, $data['weekStart'])) {
				redirect('student_survey', 'refresh');
				exit(0);
			}
			$data['isFilledAll'] = FALSE; //flag to know if all the surveys are filled
			$isFillError = 0;
			//fetch the dates from the week date string and store in array
			$filledDates = array();
			if (!empty($data['filledWeeks'])) {
				foreach ($data['filledWeeks'] as $dates) {
					$dateArr = explode('_', $dates['ts_week']);
					$filledDates[] = $dateArr[1];
				}
			}

			//checking if there is any unfilled weeks available
			foreach ($data['weekStart'] as $key => $val) {
				if (!in_array($val, $filledDates)) {
					$isFillError += 1;
				}
			}
			$data['weekSend'] = '1_' . $data['weekStart'][1]; //setting current week and date
			$data['isDateMatch'] = 0; //if date provided, falg to check the date is valid or not
			$data['selDate'] = $date;
			$data['filledDates'] = $filledDates;

			$data['fromDate'] = $data['userDetails']['data_arrivo_campus']; //from date to show in the questionnaire
			$data['toDate'] = $data['userDetails']['data_partenza_campus']; //to date to show in the questionnaire
			if (!empty($date)) {//if date is provided in the url(have to show the survey for that specific date)
				if ((in_array($date, $data['weekStart'])) && (date('Y-m-d', strtotime($date)) <= $currDate)) {
					$data['isDateMatch'] = 1;
					$data['week'] = array_search($date, $data['weekStart']);
					$data['weekSend'] = $data['week'] . '_' . $data['weekStart'][$data['week']];
					$data['fromDate'] = $date;
					$data['toDate'] = date('Y-m-d', strtotime($date . ' +6 days'));
				} 
			}//If no date is provided, then show the links for previous survey or the current survey
			else if (($data['fromDate'] <= $currDate) || $data['isDateMatch']) {
				if ($currDate >= date('Y-m-d', strtotime($data['fromDate'] . ' +5 days')) && $currDate <= date('Y-m-d', strtotime($data['toDate']))) {
					//$data['isDateMatch'] = 1;
					$data['toDate'] = date('Y-m-d', strtotime($data['fromDate'] . ' +6 days'));
				}
				else {
					foreach ($data['weekStart'] as $wDate) {
						if (!in_array($wDate, $filledDates)) {
							$data['fromDate'] = $wDate;
							$data['toDate'] = date('Y-m-d', strtotime($wDate . ' +6 days'));
							if ($data['toDate'] > $data['userDetails']['data_partenza_campus']) {
								$data['toDate'] = $data['userDetails']['data_partenza_campus'];
							}
							$data['week'] = array_search($wDate, $data['weekStart']); //get the week number of the selected week
							$data['weekSend'] = $data['week'] . '_' . $data['weekStart'][$data['week']];
							break;
						}
					}
				}
			}
			$data['surveyStatus'] = array();
			if ($isFillError == 0) {
				$data['isFilledAll'] = TRUE;
			}
			else {
				$data['surveyStatus'] = $this -> studentsmodel -> getSurveyStatus($data['userDetails']['uuid'], $data['weekStart']);
			}
			foreach ($data['weekStart'] as $wStart) { 
				if ((date('Y-m-d') > $wStart) && (date('Y-m-d', strtotime($wStart . ' +5 days')) <= date('Y-m-d'))) {
					if (!$date) { 
						$toDate = date('Y-m-d', strtotime($wStart . ' +6 days'));
						$fromDate = $wStart;
						$week = array_search($wStart, $data['weekStart']);
						$data['weekSend'] = $week . '_' . $fromDate;
					}
				}
			}

			$data['isSurveyCompleted'] = $this -> studentsmodel -> getSurveyCompleted($data['userDetails']['uuid'], $data['testId'], $data['weekSend']); //flag to know if the selected survey is completed
			$questions = $this -> studentsmodel -> getQuestions('Survey', $data['userDetails']['uuid'], $data['weekSend']); //get the list of questions
			$questionArray = array();
			//prepare the question and smiley array
			if (!empty($questions)) {
				foreach ($questions as $question) {
					$questionArray[$question['tque_section']][] = array(
						'id' => $question['opt_id'],
						'question' => $question['tque_question'],
						'starNo' => $question['opt_text'],
						'filled' => $question['trans_survey_value']
					);
				}
			}
			$data['questionArray'] = $questionArray;

                        if(APP_THEME == "OLD")
                            $this -> load -> view('tuition/plused_student_survey', $data);
                        else // if(APP_THEME == "LTE")
                        { 
                            $data['pageHeader'] = "Take student survey";
                            $data['optionalDescription'] = "";
                            $this->ltelayout->view('lte/students/survey', $data);
                        }
		}
		else {

			redirect('students', 'refresh');
		}
	}
        
        function ajax_view_survey($date,$userId,$ispdf = 0){
            $data['userId'] = $userId;
            $data['userDetails'] = $this -> studentsmodel -> getUserdata($data['userId']);
            $data['GLName'] = $this -> studentsmodel -> getGLName($data['userId']);
            $testDetails = $this -> studentsmodel -> getTestDetails('Survey');
            $data['filledWeeks'] = $this -> studentsmodel -> getSTDFilledWeeks($data['userDetails']['uuid'], $testDetails['test_id']); //The list of survey submitted weeks
            $data['testTitle'] = $testDetails['test_title'];
            $data['testType'] = $testDetails['test_type'];
            $data['testId'] = $testDetails['test_id'];
            $data['week'] = $data['userDetails']['weeks'];
            $weekNo = $this -> diffInWeeks($data['userDetails']['data_arrivo_campus'], date('Y-m-d', strtotime($data['userDetails']['data_partenza_campus'] . ' -1 day')));
            $data['weekStart'] = array();
            $weekDay = 7;
            $currDate = date("Y-m-d");

            //Split the weeks from the date range and save in an array
            for ($i = 1; $i <= $weekNo; $i++) {
                    if ($i == 1) {
                            $data['weekStart'][$i] = date('Y-m-d', strtotime($data['userDetails']['data_arrivo_campus']));
                    }
                    else {
                            if (date('Y-m-d', strtotime($data['weekStart'][$i - 1] . ' +7 days')) > $data['userDetails']['data_partenza_campus']) {
                                    $data['weekStart'][$i] = $data['userDetails']['data_partenza_campus'];
                            }
                            else {
                                    $data['weekStart'][$i] = date('Y-m-d', strtotime($data['weekStart'][$i - 1] . ' +7 days'));
                            }
                    }
            }
            
            if (!empty($date) && !in_array($date, $data['weekStart'])) {
                    echo "This page is empty.";
                    exit(0);
            }
            $data['isFilledAll'] = FALSE; //flag to know if all the surveys are filled
            $isFillError = 0;
            //fetch the dates from the week date string and store in array
            $filledDates = array();
            if (!empty($data['filledWeeks'])) {
                    foreach ($data['filledWeeks'] as $dates) {
                            $dateArr = explode('_', $dates['ts_week']);
                            $filledDates[] = $dateArr[1];
                    }
            }

            //checking if there is any unfilled weeks available
            foreach ($data['weekStart'] as $key => $val) {
                    if (!in_array($val, $filledDates)) {
                            $isFillError += 1;
                    }
            }
            $data['weekSend'] = '1_' . $data['weekStart'][1]; //setting current week and date
            $data['isDateMatch'] = 0; //if date provided, falg to check the date is valid or not
            $data['selDate'] = $date;
            $data['filledDates'] = $filledDates;

            $data['fromDate'] = $data['userDetails']['data_arrivo_campus']; //from date to show in the questionnaire
            $data['toDate'] = $data['userDetails']['data_partenza_campus']; //to date to show in the questionnaire
            if (!empty($date)) {//if date is provided in the url(have to show the survey for that specific date)
                    if ((in_array($date, $data['weekStart'])) && (date('Y-m-d', strtotime($date)) <= $currDate)) {
                            $data['isDateMatch'] = 1;
                            $data['week'] = array_search($date, $data['weekStart']);
                            $data['weekSend'] = $data['week'] . '_' . $data['weekStart'][$data['week']];
                            $data['fromDate'] = $date;
                            $data['toDate'] = date('Y-m-d', strtotime($date . ' +6 days'));
                    } 
            }//If no date is provided, then show the links for previous survey or the current survey
            else if (($data['fromDate'] <= $currDate) || $data['isDateMatch']) {
                    if ($currDate >= date('Y-m-d', strtotime($data['fromDate'] . ' +5 days')) && $currDate <= date('Y-m-d', strtotime($data['toDate']))) {
                            //$data['isDateMatch'] = 1;
                            $data['toDate'] = date('Y-m-d', strtotime($data['fromDate'] . ' +6 days'));
                    }
                    else {
                            foreach ($data['weekStart'] as $wDate) {
                                    if (!in_array($wDate, $filledDates)) {
                                            $data['fromDate'] = $wDate;
                                            $data['toDate'] = date('Y-m-d', strtotime($wDate . ' +6 days'));
                                            if ($data['toDate'] > $data['userDetails']['data_partenza_campus']) {
                                                    $data['toDate'] = $data['userDetails']['data_partenza_campus'];
                                            }
                                            $data['week'] = array_search($wDate, $data['weekStart']); //get the week number of the selected week
                                            $data['weekSend'] = $data['week'] . '_' . $data['weekStart'][$data['week']];
                                            break;
                                    }
                            }
                    }
            }
            $data['surveyStatus'] = array();
            if ($isFillError == 0) {
                    $data['isFilledAll'] = TRUE;
            }
            else {
                    $data['surveyStatus'] = $this -> studentsmodel -> getSurveyStatus($data['userDetails']['uuid'], $data['weekStart']);
            }
            foreach ($data['weekStart'] as $wStart) { 
                    if ((date('Y-m-d') > $wStart) && (date('Y-m-d', strtotime($wStart . ' +5 days')) <= date('Y-m-d'))) {
                            if (!$date) { 
                                    $toDate = date('Y-m-d', strtotime($wStart . ' +6 days'));
                                    $fromDate = $wStart;
                                    $week = array_search($wStart, $data['weekStart']);
                                    $data['weekSend'] = $week . '_' . $fromDate;
                            }
                    }
            }

            $data['isSurveyCompleted'] = $this -> studentsmodel -> getSurveyCompleted($data['userDetails']['uuid'], $data['testId'], $data['weekSend']); //flag to know if the selected survey is completed
            $questions = $this -> studentsmodel -> getQuestions('Survey', $data['userDetails']['uuid'], $data['weekSend']); //get the list of questions
            $questionArray = array();
            //prepare the question and smiley array
            if (!empty($questions)) {
                    foreach ($questions as $question) {
                            $questionArray[$question['tque_section']][] = array(
                                    'id' => $question['opt_id'],
                                    'question' => $question['tque_question'],
                                    'starNo' => $question['opt_text'],
                                    'filled' => $question['trans_survey_value']
                            );
                    }
            }
            $data['questionArray'] = $questionArray;
            if($ispdf)
            {
                $this->load->view('lte/students/survey_detail_pdf', $data);
            }
            else
                $this->load->view('lte/students/survey_detail_modal_view', $data);
        }
        function print_pdf_survey_details($date,$userId){
            
            $this->load->helper("mpdf6");
            // LOAD PDF FILE TEMPLATE AND GENRATE .PDF FILE
            ob_start(); // start output buffer
            $this->ajax_view_survey($date, $userId,1);
            $messageBody = ob_get_contents(); // get contents of buffer
            ob_end_clean();
            $fpdFileName = "Survey-details";
            $fpdFileName = $fpdFileName . '_' . time();
            downloadhtmltopdf($messageBody,$fpdFileName);
        }

        /**
	 * Function to finally save the survey
	 * @author Arunsankar
	 * @since 18-07-2016
	 */
	function submitSurvey() {
		if ($this -> session -> userdata('role') == 502) {
			$uuid = $this -> input -> post('uuid');
			$week = $this -> input -> post('week');
			$test = $this -> input -> post('test');
			$insertData = array(
				'ts_uuid' => $uuid,
				'ts_test_id' => $test,
				'ts_week' => $week,
				'ts_submitted_on' => date('Y-m-d H:i:s')
			);
			$isSurveyInsert = $this -> studentsmodel -> insertSurvey($insertData);
			if ($isSurveyInsert) {
				echo '1';
			}
			else {
				echo '0';
			}
		}
		else {

			redirect('students', 'refresh');
		}
	}

	/**
	 * Function to save the clicked survey values
	 * @author Arunsankar
	 * @since 20-07-2016
	 */
	function store_survey() {
		if ($this -> session -> userdata('role') == 502) {
			$value = $this -> input -> post('value');
			$option = $this -> input -> post('option');
			$uuid = $this -> input -> post('uuid');
			$week = $this -> input -> post('week');
			if (!empty($option) && !empty($uuid) && !empty($week)) {
				$insertData = array(
					'tans_opt_id' => $option,
					'tans_uuid' => $uuid,
					'tans_week' => $week,
					'trans_survey_value' => $value
				);
				$isInserted = $this -> studentsmodel -> storeStudentSurvey($insertData);
				if ($isInserted) {
					echo '1';
				}
				else {
					echo '0';
				}
			}
			else {
				echo '0';
			}
		}
		else {
			redirect('students', 'refresh');
		}
	}

	/**
	 * Function to get the week number from the from and to dates
	 * @author Arunsankar
	 * @since 20-07-2016
	 * @param date $from
	 * @param date $to
	 * @return int
	 */
	function diffInWeeks($from, $to) {
		$day = 24 * 3600;
		$from = strtotime($from);
		$to = strtotime($to) + $day;
		$diff = abs($to - $from);
		$weeks = ceil($diff / $day / 7);
		$days = $diff / $day - $weeks * 7;
		$out = array();
		/* if ($weeks)
		  $out[] = $weeks;
		  if ($days)
		  $out[] = "$days Day" . ($days > 1 ? 's' : ''); */
		return $weeks;
	}

	

	function logout() { {
			$this -> session -> sess_destroy();
			redirect('students', 'refresh');
		}
	}
}

/* End of file survey.php */
