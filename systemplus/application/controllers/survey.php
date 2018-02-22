<?php

/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 04-May-2016
 * @Modified    : 
 * @Description : survey used to authenticate pulsed_row user pax with type GL
 */
class Survey extends Controller {

	public function __construct() {

		parent::Controller();
		authSessionMenu($this);
		$this -> load -> helper(array('form', 'url', 'mpdf6'));
		$this -> load -> library('session', 'email');
		$this -> load -> library('ltelayout');
		$this -> load -> model('tuition/surveymodel', 'surveymodel');
		$this -> load -> model('tuition/campuscoursemodel', 'campuscoursemodel');
	}

	function index() {

		if ($this -> session -> userdata('role') == 501) {
			redirect('survey/dashboard', 'refresh');
		}
		else {
			redirect('vauth/gl'); // GO TO AUTH controller - NEW LOGIN...
			exit(0);
			$this -> load -> helper('string');
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			$data['title'] = "plus-ed.com | Login";
			$this -> load -> view('tuition/plused_survey_login', $data);
		}
	}

	/**
	 * login 
	 * this function uses email address and survey password to check/authenticate user 
	 * if user is authenticated basic information is save into the session and user gets loggedin. 
	 */
	function login() {
		if (!empty($_POST)) {
			if ($this -> session -> userdata('role') != 501) {
				@session_start();
				$userFirstName = $this -> input -> post('login_name');
				$userSurname = $this -> input -> post('login_surname');
				$dobDay = $this -> input -> post('selDay');
				$dobMonth = $this -> input -> post('selMonth');
				$dobYear = $this -> input -> post('selYear');
				$userDOB = $dobDay . '/' . $dobMonth . '/' . $dobYear;
				if (isItValidDate($userDOB)) {
					$userDOB = explode('/', $userDOB);
					if (array_key_exists(2, $userDOB)) {
						$userDOB = $userDOB[2] . '-' . $userDOB[1] . '-' . $userDOB[0];
					}
					$userData = $this -> surveymodel -> verifyGLUser($userFirstName, $userSurname, $userDOB);
					if ($userData) {
						$newdata = array(
							'username' => "--",
							'uuid' => $userData -> uuid,
							'pax_dob' => $userData -> pax_dob,
							'mainfirstname' => $userData -> nome,
							'mainfamilyname' => $userData -> cognome,
							'businessname' => $userData -> nome,
							'id' => $userData -> id_prenotazione,
							'email' => '',
							'country' => '',
							'role' => 501, //501 = Pax users GL(Group Leader)
							'ruolo' => "Group Leader",
							'logged_in' => TRUE
						);
						$this -> session -> set_userdata($newdata);
						redirect('survey/dashboard', 'refresh');
					}
					else {
						$this -> session -> set_flashdata('login_failed', 1);
						redirect('survey', 'refresh');
					}
				}
				else {
					$this -> session -> set_flashdata('login_failed', 1);
					redirect('survey', 'refresh');
				}
			}
			else
				redirect('survey', 'refresh');
		}
		else
			redirect('survey', 'refresh');
	}

	/**
	 * dashboard
	 * this function loads survey dashboard. 
	 */
	function dashboard() {
		if ($this -> session -> userdata('role') == 501) {
			$data['title'] = "plus-ed.com | Dashboard";
			$data['breadcrumb1'] = 'Dashboard';
			$data['breadcrumb2'] = '';
			if (APP_THEME == "OLD")
				$this -> load -> view('tuition/plused_survey_dashboard', $data);
			else { // if(APP_THEME == "LTE")
				$data['pageHeader'] = "Plus Vision Dashboard";
				$data['optionalDescription'] = "";
				$this -> ltelayout -> view('lte/gl/dashboard', $data);
			}
		}
		else {
			redirect('survey', 'refresh');
		}
	}

	/**
	 * logout 
	 * this function is used to destroy survey session. 
	 */
	function logout() {
		$this -> session -> sess_destroy();
		redirect('survey', 'refresh');
	}

	/**
	 * profile
	 * this function is used to show users self profile details.
	 */
	function profile() {
		if ($this -> session -> userdata('role') == 501) {
			$data['title'] = "plus-ed.com | Profile";
			$data['breadcrumb1'] = 'Profile';
			$data['breadcrumb2'] = '';
			$userId = $this -> session -> userdata('id');
			$data['userId'] = $userId;

			if (APP_THEME == "OLD")
				$this -> load -> view('tuition/plused_survey_profile', $data);
			else { // if(APP_THEME == "LTE")
				$data['pageHeader'] = "Profile";
				$data['optionalDescription'] = "";
				$this -> ltelayout -> view('lte/gl/profile', $data);
			}
		}
		else {
			redirect('users', 'refresh');
		}
	}

	/**
	 * stripJunk
	 * this function can be used to strip unwanted characters from file name.
	 * @param $string input filename
	 * @return string
	 * @author SK
	 * @since Feb 01 16
	 */
	function stripJunk($string) {
		$string = str_replace(" ", "-", trim($string));
		$string = preg_replace("/[^a-zA-Z0-9-.]/", "", $string);
		$string = strtolower($string);
		return $string;
	}

	function view($report = "") {
		if ($this -> session -> userdata('role') == 501) {
			$data['title'] = "plus-ed.com | Survey";
			$data['breadcrumb1'] = 'Take the survey';

			$data['breadcrumb2'] = 'Take survey 1';
			$id = $this -> session -> userdata('uuid');

			$userData = $this -> surveymodel -> getUserdata($id);
			if ($userData) {
				$data['userData'] = $userData;
				$data['userId'] = $id;
				if ($report == "report1" || $report == "report2") {
					// CHECK USER ARRIVAL AND DEPARTURE DATES
					$currDate = date("Y-m-d");
					$arrivalDate = date("Y-m-d", strtotime($userData -> data_arrivo_campus));
					$departureDate = date("Y-m-d", strtotime($userData -> data_partenza_campus));
					$survey2Date = date("Y-m-d", strtotime('-6 days', strtotime($departureDate)));
					$allowSurvey = FALSE;
					$surveyMessage = "You will have access to this survey starting from ";
					$data['reportType'] = "";
					$data['report1UserEmail'] = "";
					if ($report == "report1") {
						$data['reportType'] = 'Report 1';
						$data['pageHeader'] = "Group Leader Report 1";
						if ($arrivalDate <= $currDate) {
							$allowSurvey = TRUE;
						}
						else
							$surveyMessage = "You will have access to this survey starting from " . date("d/m/Y", strtotime($arrivalDate));
					}
					elseif ($report == "report2") {
						$data['reportType'] = 'Report 2';
						$data['pageHeader'] = "Group Leader Report 2";
						$data['breadcrumb1'] = 'Take the survey';
						$data['breadcrumb2'] = 'Take survey 2';
						if ($survey2Date <= $currDate) {
							$allowSurvey = TRUE;
							$report1SurveryUser = $this -> surveymodel -> getSurveyUserdata($id, 'Report 1');
							if ($report1SurveryUser) {
								$data['report1UserEmail'] = $report1SurveryUser -> su_email;
							}
						}
						else
							$surveyMessage = "You will have access to this survey starting from " . date("d/m/Y", strtotime($survey2Date));
					}

					if ($allowSurvey) {
						$data['surveyUserData'] = $this -> surveymodel -> getSurveyUserdata($id, $data['reportType']);
						$surveyUserId = 0;
						if ($data['surveyUserData']) {
							$surveyUserData = $data['surveyUserData'];
							$surveyUserId = $surveyUserData -> su_id;
						}
						$report1SurveyQues = $this -> surveymodel -> getServeyQuestions($data['reportType'], $surveyUserId);
						$data['report1SurveyQues'] = $report1SurveyQues;


						if (APP_THEME == "OLD")
							$this -> load -> view('tuition/plused_survey_report1', $data);
						else { // if(APP_THEME == "LTE")
							$data['optionalDescription'] = "";
							$this -> ltelayout -> view('lte/gl/survey_report1', $data);
						}
					}
					else {
						$data['surveyMessage'] = $surveyMessage;
						$this -> load -> view('tuition/plused_survey_report_not_allowed', $data);
					}
				}
				else
					redirect('survey', 'refresh');
			}
			else
				redirect('survey', 'refresh');
		} else {
			redirect('survey', 'refresh');
		}
	}

	function startsurvey() {
		if ($this -> session -> userdata('role') == 501) {
			$txtUserId = $this -> input -> post('txtUserId');
			$txtEmail = $this -> input -> post('txtEmail');
			$txtName = $this -> input -> post('txtName');
			$txtReportType = $this -> input -> post('txtReportType');
			$selCampus = $this -> input -> post('selCampus');
			$insertArr = array(
				'su_group_leader_uuid' => $txtUserId, //changed the refference to pax uuid
				'su_report' => $txtReportType,
				'su_name' => $txtName,
				'su_email' => $txtEmail,
				'su_campus_id' => $selCampus,
				'su_survey_status' => 'Inprogress'
			);
			$returnId = $this -> surveymodel -> startSurvey($insertArr);
			if ($returnId) {
				echo json_encode(array('result' => '1', 'surveyId' => $returnId));
			}
			else {
				echo json_encode(array('result' => '0', 'surveyId' => $returnId));
			}
		}
		else {
			echo json_encode(array('result' => '0', 'surveyId' => 0));
		}
	}

	function loganswer() {
		if ($this -> session -> userdata('role') == 501) {
			$type = $this -> input -> post('type');
			$suId = $this -> input -> post('suId');
			$quesId = $this -> input -> post('quesId');
			$myVal = $this -> input -> post('myVal');
			if (!empty($suId)) {
				$returnId = $this -> surveymodel -> logSurveyAnswer($type, $suId, $quesId, $myVal);
				if ($returnId) {
					echo json_encode(array('result' => '1', 'message' => 'success'));
				}
				else {
					echo json_encode(array('result' => '0', 'message' => 'Unable to save your answer.'));
				}
			}
			else
				echo json_encode(array('result' => '0', 'message' => 'You will have to fill your information above and click on start survey button.'));
		} else {
			echo json_encode(array('result' => '0', 'message' => 'session expired'));
		}
	}

	function markascompleted() {
		if ($this -> session -> userdata('role') == 501) {
			$suId = $this -> input -> post('suId');
			if (!empty($suId)) {
				$returnId = $this -> surveymodel -> markSurveyAsCompleted($suId);
				if ($returnId) {
					echo json_encode(array('result' => '1', 'message' => 'Thanks! your survey report has been successfully submitted.'));
				}
				else {
					echo json_encode(array('result' => '0', 'message' => 'Unable to save your answer.'));
				}
			}
			else
				echo json_encode(array('result' => '0', 'message' => 'Unable to mark survey as completed.'));
		} else {
			echo json_encode(array('result' => '0', 'message' => 'session expired'));
		}
	}

	function report() {
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
			$data['calFromDate'] = date('d-m-Y', strtotime(' - 15 days'));
			$data['calToDate'] = date("d-m-Y");
			$data["centri"] = $this -> campuscoursemodel -> getCampusList();
			$data['title'] = 'plus-ed.com | Report';
			$data['breadcrumb1'] = 'Survey';
			$data['breadcrumb2'] = 'GL Report';
			if (APP_THEME == 'OLD') {
				$this -> load -> view('tuition/plused_survey_reports', $data);
			}
			else {
				$data['pageHeader'] = "Group leader survey";
				$data['optionalDescription'] = "";
				$this -> ltelayout -> view('lte/backoffice/survey/gl_report', $data);
			}
		}
		else {
			redirect('survey', 'refresh');
		}
	}

	function questionsreport() {
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
			if (empty($_POST)) {
				redirect('survey/report', 'refresh');
				exit(0);
			}
			$campusId = $this -> input -> post('selCampus');
			$selSurvey = $this -> input -> post('selSurvey');
			$selAgent = $this -> input -> post('selAgent');
			$fd = $this -> input -> post('fd');
			if (!empty($fd)) {
				$fd = str_replace('/', '-', $fd);
				$fd = date("Y-m-d", strtotime($fd));
			}

			$td = $this -> input -> post('td');
			if (!empty($td)) {
				$td = str_replace('/', '-', $td);
				$td = date("Y-m-d", strtotime($td));
			}
			$resultData = $this -> surveymodel -> getQuestionsReport($selAgent, $campusId, $selSurvey, $fd, $td);
			$data['reportData'] = $resultData;
			$data['campusId'] = $campusId;
			$data['surveyType'] = $selSurvey;
			$data['agentId'] = $selAgent;
			$data['fd'] = $fd;
			$data['td'] = $td;

			$agentName = $this -> surveymodel -> getAgentName($selAgent);


			$data['title'] = 'plus-ed.com | Survey reports';
			$data['breadcrumb1'] = 'GL report';
			$data['breadcrumb2'] = 'Survey 1 report';
			if ($selSurvey == "Report 2")
				$data['breadcrumb2'] = 'Survey 2 report';

			$data['headingSurvey'] = $data['breadcrumb2'] . ' - From ' . date("d/m/Y", strtotime($fd)) . ' to ' . date("d/m/Y", strtotime($td)) . ($agentName ? ' - ' . $agentName : '');
			if (APP_THEME == 'OLD') {
				$this -> load -> view('tuition/plused_survey_quesreport', $data);
			}
			else {
				$this -> ltelayout -> view('lte/backoffice/survey/gl_report_result', $data);
			}
		}
		else {
			redirect('survey', 'refresh');
		}
	}

	function getSurveyUsers() {
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
			$queId = $this -> input -> post('data_id');
			$yesnoType = $this -> input -> post('data_type');

			$hidd_campus = $this -> input -> post('hidd_campus');
			$hidd_agent = $this -> input -> post('hidd_agent');
			$hidd_fd = $this -> input -> post('hidd_fd');
			$hidd_td = $this -> input -> post('hidd_td');
			$data_sect = $this -> input -> post('data_sect');

			if ($yesnoType == "Yes")
				$yesnoType = 1;
			else
				$yesnoType = 0;
			$reportType = $this -> surveymodel -> getReportType($queId);
			$userData = $this -> surveymodel -> getSurveyUsers($queId, $yesnoType, $hidd_fd, $hidd_td, $hidd_campus, $hidd_agent);
			if ($userData) {
				if (APP_THEME == 'OLD') {
					?>
					<table class="stdGLUser styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"oSearch":{"bSmart": false},"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true}]}'>
						<?php
					}
					else {
						?>
						<table id="stdGlUserDataTable" class="datatable table table-bordered table-hover vertical-middle">
							<?php
						}
						//"aaSorting":[[2,"desc"]],
						?>
						<thead>
							<tr>
								<th>Group leader</th>
								<th>Report</th>
								<th>Email</th>
								<th>Survey date</th>
								<th>Comments</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($userData as $glUser) {
								$commentText = $this -> surveymodel -> getSurveyCommentText($queId, $hidd_fd, $hidd_td, $hidd_campus, $hidd_agent, $reportType[0]['que_report'], $glUser['su_id'], $data_sect);
								?>
								<tr>
									<td><?php echo $glUser['su_name']; ?></td>
									<td><?php echo $glUser['su_report']; ?></td>
									<td><?php echo $glUser['su_email']; ?></td>
									<td><?php echo (!empty($glUser['su_survey_date']) ? date('d/m/Y', strtotime($glUser['su_survey_date'])) : ''); ?></td>
									<td><div class="max-height-100"><?php echo empty($commentText) ? '--' : $commentText; ?></div></td>
								</tr>

								<?php
							}
							?></tbody></table><?php
			}
			else {
							?>
					<span>No record(s) found.</span>
					<?php
				}
			}
		}

		function getSurveyUsersComment() {
			if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
				$queId = $this -> input -> post('data_id');
				$yesnoType = $this -> input -> post('data_type');

				$hidd_campus = $this -> input -> post('hidd_campus');
				$hidd_agent = $this -> input -> post('hidd_agent');
				$hidd_fd = $this -> input -> post('hidd_fd');
				$hidd_td = $this -> input -> post('hidd_td');
				$data_sect = $this -> input -> post('data_sect');

				if ($yesnoType == "Yes")
					$yesnoType = 1;
				else
					$yesnoType = 0;
				$reportType = $this -> surveymodel -> getReportType($queId);
				$userData = $this -> surveymodel -> getSurveyUsers($queId, $yesnoType, $hidd_fd, $hidd_td, $hidd_campus, $hidd_agent);
				if ($userData) {
					if (APP_THEME == 'OLD') {
						?>
						<table class="stdGLUser styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"oSearch":{"bSmart": false},"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": false}]}'>
							<?php
						}
						else {
							?>
							<table id="stdGlUserCommentsDataTable" class="datatable table table-bordered table-hover vertical-middle">
								<?php
							}
							?>
							<thead>
								<tr>
									<th>Group Leader</th>
									<th>Report</th>
									<th>Email</th>
									<th>Survey date</th>
									<th>Comments</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($userData as $glUser) {
									$commentText = $this -> surveymodel -> getSurveyCommentText($queId, $hidd_fd, $hidd_td, $hidd_campus, $hidd_agent, $reportType[0]['que_report'], $glUser['su_id'], $data_sect);
									?>
									<tr>
										<td><?php echo $glUser['su_name']; ?></td>
										<td><?php echo $glUser['su_report']; ?></td>
										<td><?php echo $glUser['su_email']; ?></td>
										<td><?php echo (!empty($glUser['su_survey_date']) ? date('d/m/Y', strtotime($glUser['su_survey_date'])) : ''); ?></td>
										<td><div class="max-height-100"><?php echo empty($commentText) ? '--' : $commentText; ?></div></td>
									</tr>
									<?php
								}
								?></tbody></table><?php
			}
			else {
								?>
						<span>No record(s) found.</span>
						<?php
					}
				}
			}

			function getSurveyUsersAns() {
				if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
					$queId = $this -> input -> post('data_id');
					$yesnoType = $this -> input -> post('data_type');

					$hidd_campus = $this -> input -> post('hidd_campus');
					$hidd_agent = $this -> input -> post('hidd_agent');
					$hidd_fd = $this -> input -> post('hidd_fd');
					$hidd_td = $this -> input -> post('hidd_td');
					$data_sect = $this -> input -> post('data_sect');

					if ($yesnoType == "Yes")
						$yesnoType = 1;
					else
						$yesnoType = 0;
					$reportType = $this -> surveymodel -> getReportType($queId);
					$userData = $this -> surveymodel -> getSurveyUsers($queId, $yesnoType, $hidd_fd, $hidd_td, $hidd_campus, $hidd_agent);
					if ($userData) {
						if (APP_THEME == 'OLD') {
							?>
							<table class="stdGLUser styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"oSearch":{"bSmart": false},"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": false}]}'>
								<?php
							}
							else {
								?>
								<table id="stdGlUserAnswerDataTable" class="datatable table table-bordered table-hover vertical-middle">
									<?php
								}
								?>
								<thead>
									<tr>
										<th>Group Leader</th>
										<th>Report</th>
										<th>Email</th>
										<th>Survey date</th>
										<th>Answer</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($userData as $glUser) {
										$commentText = $this -> surveymodel -> getSurveyAnsText($queId, $hidd_fd, $hidd_td, $hidd_campus, $hidd_agent, $reportType[0]['que_report'], $glUser['su_id'], $data_sect);
										?>
										<tr>
											<td><?php echo $glUser['su_name']; ?></td>
											<td><?php echo $glUser['su_report']; ?></td>
											<td><?php echo $glUser['su_email']; ?></td>
											<td><?php echo (!empty($glUser['su_survey_date']) ? date('d/m/Y', strtotime($glUser['su_survey_date'])) : ''); ?></td>
											<td><?php echo $commentText; ?></td>
										</tr>
										<?php
									}
									?></tbody></table><?php
				}
				else {
									?>
							<span>No record(s) found.</span>
							<?php
						}
					}
				}

				function getagents() {
					if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
						$campusId = $this -> input -> post('campusId');
						$survey = $this -> input -> post('survey');
						$fd = $this -> input -> post('fd');
						if (!empty($fd)) {
							$fd = str_replace('/', '-', $fd);
							$fd = date("Y-m-d", strtotime($fd));
						}
						$td = $this -> input -> post('td');
						if (!empty($td)) {
							$td = str_replace('/', '-', $td);
							$td = date("Y-m-d", strtotime($td));
						}
						$resultAgents = $this -> surveymodel -> getAgents($campusId, $fd, $td);
						if ($resultAgents) {
							?>
							<option value="all">All</option>
							<?php
							foreach ($resultAgents as $agents) {
								?>
								<option value="<?php echo $agents['agent_id']; ?>"><?php echo $agents['agent_businessname']; ?></option>
								<?php
							}
						}
						else {
							?>
							<option value="">Select agent</option>
							<?php
						}
					}
				}

				function getagentssurvey() {
					if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
						$agentId = $this -> input -> post('agentId');
						$campusId = $this -> input -> post('campusId');
						$selSurvey = $this -> input -> post('survey');
						$fd = $this -> input -> post('fd');
						if (!empty($fd)) {
							$fd = str_replace('/', '-', $fd);
							$fd = date("Y-m-d", strtotime($fd));
						}
						$td = $this -> input -> post('td');
						if (!empty($td)) {
							$td = str_replace('/', '-', $td);
							$td = date("Y-m-d", strtotime($td));
						}
						$surveyCount = $this -> surveymodel -> getAgentsSurvey($agentId, $selSurvey, $campusId, $fd, $td);
						$completedSurvey = 0;
						$pendingSurvey = 0;
						$totalSurvey = 0;
						if ($surveyCount) {
							foreach ($surveyCount as $survey) {
								$totalSurvey++;
								if ($survey['su_survey_status'] == 'Completed') {
									$completedSurvey++;
								}
								else
									$pendingSurvey++;
							}
						}
						echo $completedSurvey . "/" . $totalSurvey;
					}
				}
				/**
				 * Start: Student report
				 * @author Arunsankar
				 * @since 29-July-2016
				 */

				/**
				 * Function to show the student report page
				 * @author Arunsankar
				 * @since 29-07-2016
				 */
				function studentsreport() {
					if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
						$data['calFromDate'] = date('d-m-Y', strtotime(' - 15 days'));
						$data['calToDate'] = date("d-m-Y");
						$data["centri"] = $this -> campuscoursemodel -> getCampusList();
						$data["surveys"] = $this -> surveymodel -> getSurveyList();
						$data['title'] = 'plus-ed.com | Students report';
						$data['breadcrumb1'] = 'Survey';
						$data['breadcrumb2'] = 'Students report';
						if (APP_THEME == 'OLD') {
							$this -> load -> view('tuition/plused_student_survey_reports', $data);
						}
						else {
							$data['pageHeader'] = "Students survey";
							$data['optionalDescription'] = "";
							$this -> ltelayout -> view('lte/backoffice/survey/students_report', $data);
						}
					}
					else {
						redirect('survey', 'refresh');
					}
				}

				/**
				 * Function to get the agent list
				 * @author Arunsankar
				 * @since 29-07-2016
				 */
				function getstudentagents() {
					if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
						$campusId = $this -> input -> post('campusId');
						$survey = $this -> input -> post('survey');
						$fd = $this -> input -> post('fd');
						if (!empty($fd)) {
							$fd = str_replace('/', '-', $fd);
							$fd = date("Y-m-d", strtotime($fd));
						}
						$td = $this -> input -> post('td');
						if (!empty($td)) {
							$td = str_replace('/', '-', $td);
							$td = date("Y-m-d", strtotime($td));
						}
						$resultAgents = $this -> surveymodel -> getStudentAgents($campusId, $fd, $td);
						if ($resultAgents) {
							?>
							<option value="all">All</option>
							<?php
							foreach ($resultAgents as $agents) {
								?>
								<option value="<?php echo $agents['agent_id']; ?>"><?php echo $agents['agent_businessname']; ?></option>
								<?php
							}
						}
						else {
							?>
							<option value="">Select agent</option>
							<?php
						}
					}
				}
                                
                                function getgroupleaders(){
                                    if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
                                        $campusId = $this -> input -> post('campusId');
                                        $agentId = $this -> input -> post('agentId');
                                        $survey = $this -> input -> post('survey');
                                        $fd = $this -> input -> post('fd');
                                        if (!empty($fd)) {
                                            $fd = str_replace('/', '-', $fd);
                                            $fd = date("Y-m-d", strtotime($fd));
                                        }
                                        $td = $this -> input -> post('td');
                                        if (!empty($td)) {
                                            $td = str_replace('/', '-', $td);
                                            $td = date("Y-m-d", strtotime($td));
                                        }
                                        $resultGL = $this -> surveymodel -> getGroupLeader($campusId,$survey,$agentId, $fd, $td);
                                        if ($resultGL) {
                                            ?>
                                            <option value="all">All</option>
                                            <?php
                                            foreach ($resultGL as $gl) {
                                                    ?>
                                            <option value="<?php echo $gl['uuid']; ?>"><?php echo ucwords($gl['cognome']. " " .$gl['nome']); ?></option>
                                                    <?php
                                            }
                                        }
                                        else {
                                                ?>
                                                <option value="">Select group leader</option>
                                                <?php
                                        }
                                }
                                }

				/**
				 * Function to get the survey count(Not using)
				 */
				function getstudentsurvey() {
					if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
						$agentId = $this -> input -> post('agentId');
						$campusId = $this -> input -> post('campusId');
						$selSurvey = $this -> input -> post('survey');
						$fd = $this -> input -> post('fd');
						if (!empty($fd)) {
							$fd = str_replace('/', '-', $fd);
							$fd = date("Y-m-d", strtotime($fd));
						}
						$td = $this -> input -> post('td');
						if (!empty($td)) {
							$td = str_replace('/', '-', $td);
							$td = date("Y-m-d", strtotime($td));
						}
						$surveyCount = $this -> surveymodel -> getStudentSurvey($agentId, $selSurvey, $campusId, $fd, $td);
						$completedSurvey = 0;
						$pendingSurvey = 0;
						$totalSurvey = 0;
						if ($surveyCount) {
							foreach ($surveyCount as $survey) {
								$totalSurvey++;
								if ($survey['su_survey_status'] == 'Completed') {
									$completedSurvey++;
								}
								else
									$pendingSurvey++;
							}
						}
						echo $completedSurvey . "/" . $totalSurvey;
					}
				}

				/**
				 * Function to get the questions in student survey
				 * @author Arunsankar
				 * @since 29-07-2016
				 */
				function questionsstudentreport() {
					if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
						if (empty($_POST)) {
							redirect('survey/studentsreport', 'refresh');
							exit(0);
						}
						$campusId = $this -> input -> post('selCampus');
						$selSurvey = $this -> input -> post('selSurvey');
						$selAgent = $this -> input -> post('selAgent');
                                                $selGLId = $this -> input -> post('selGL');
                                                $selGroupLeader = $this -> input -> post('hidd_GroupLeader');
						$fd = $this -> input -> post('fd');
						if (!empty($fd)) {
							$fd = str_replace('/', '-', $fd);
							$fd = date("Y-m-d", strtotime($fd));
						}

						$td = $this -> input -> post('td');
						if (!empty($td)) {
							$td = str_replace('/', '-', $td);
							$td = date("Y-m-d", strtotime($td));
						}

						$questionList = $this -> surveymodel -> getSurveyQuestion($selSurvey);
						$orderedArray = array();
						if (!empty($questionList)) {
							foreach ($questionList as $question) {
								$orderedArray[$question['tque_section']][$question['tque_id']] = $question['tque_question'];
							}
						}
						$data['orderedArray'] = $orderedArray;
						$completedSurveys = $this -> surveymodel -> getSurveycompletedSurveys($selSurvey, $campusId, $selAgent, $fd, $td);
						$percentages = $this -> surveymodel -> getSurveyPercentage($selSurvey, $completedSurveys);

						$data['percentages'] = array();
						if ($percentages) {
							foreach ($percentages as $percentage) {
								$data['percentages'][$percentage['tque_id']]['opt_text'] = $percentage['opt_text'];
								$data['percentages'][$percentage['tque_id']]['total'] = $percentage['total'];
								$data['percentages'][$percentage['tque_id']]['poor'] = $percentage['poor'];
								$data['percentages'][$percentage['tque_id']]['satisfactory'] = $percentage['satisfactory'];
								$data['percentages'][$percentage['tque_id']]['good'] = $percentage['good'];
								$data['percentages'][$percentage['tque_id']]['excellent'] = $percentage['excellent'];
							}
						}

						$data['campusId'] = $campusId;
						$data['surveyType'] = $selSurvey;
						$data['agentId'] = $selAgent;
						$data['selGroupLeader'] = $selGLId;
						$data['selGroupLeaderName'] = $selGroupLeader;
						$data['fd'] = $fd;
						$data['td'] = $td;

						$data['title'] = 'plus-ed.com | Survey reports';
						$data['breadcrumb1'] = 'Students report';
						$data['breadcrumb2'] = 'Survey report';
						if ($selSurvey == "Report 2")
                                                    $data['breadcrumb2'] = 'Survey 2 report';
						if (APP_THEME == 'OLD') {
                                                    $this -> load -> view('tuition/plused_student_survey_quesreport', $data);
						}
						else {
                                                    $this -> ltelayout -> view('lte/backoffice/survey/students_report_result', $data);
						}
					}
					else {
						redirect('survey', 'refresh');
					}
				}

				/**
				 * Function to get the list of students in each rating
				 * @author Arunsankar
				 * @since 01-08-2016
				 */
				function getStudentSurveyUsers() {
					if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
						$queId = $this -> input -> post('data_id');
						$surType = $this -> input -> post('data_type');
						$surTypeId = $this -> input -> post('data_typeId');

						$hidd_campus = $this -> input -> post('hidd_campus');
						$hidd_agent = $this -> input -> post('hidd_agent');
						$hidd_fd = $this -> input -> post('hidd_fd');
						$hidd_td = $this -> input -> post('hidd_td');

						if ($surType == "Poor") {
							$surType = 1;
						}
						else if ($surType == "Satisfactory") {
							$surType = 2;
						}
						else if ($surType == "Good") {
							$surType = 3;
						}
						else if ($surType == "Excellent") {
							$surType = 4;
						}
						else if ($surType == "Satisfactory") {
							$surType = 2;
						}
						else if ($surType == "Unsatisfactory") {
							$surType = 1;
						}

						$userData = $this -> surveymodel -> getStudentSurveyUsers($queId, $surType, $hidd_fd, $hidd_td, $hidd_campus, $hidd_agent);
						if ($userData) {
							if (APP_THEME == 'OLD') {
								?>
								<table class="stdGLUser styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"oSearch":{"bSmart": false},"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true}]}'>
									<?php
								}
								else {
									?>
									<table id="stdSTDUserDataTable" class="datatable table table-bordered table-hover vertical-middle">
									<?php
								}
								?>
								<thead>
									<tr>
										<th>Student name</th>
										<th>Campus</th>
										<th>Week</th>
										<th>Week start date</th>
										<th>Survey date</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($userData as $stdUser) {
										?>
										<tr>
											<td><?php echo $stdUser['name']; ?></td>
											<td><?php echo $stdUser['nome_centri']; ?></td>
											<td><?php echo $stdUser['week_no']; ?></td>
											<td><?php echo date('d/m/Y', strtotime($stdUser['week_start'])); ?></td>
											<td><?php echo (!empty($stdUser['submitted_date']) ? date('d/m/Y', strtotime($stdUser['submitted_date'])) : ''); ?></td>
										</tr>
										<?php
									}
									?></tbody></table><?php
				}
				else {
									?>
							<span>No record(s) found.</span>
							<?php
						}
					}
				}
				/* End: Student report Arunsankar */
                                
                                
    function getGLStudentsDetail() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            
            $hidd_campus = $this->input->post('hidd_campus');
            $hidd_survey = $this->input->post('hidd_survey');
            $hidd_agent = $this->input->post('hidd_agent');
            $hidd_fd = $this->input->post('hidd_fd');
            $hidd_td = $this->input->post('hidd_td');
            $hidd_GlId = $this->input->post('hidd_selGroupLeader');
            $selGroupLeaderName = $this->input->post('selGroupLeaderName');

            $userData = $this->surveymodel->getStudentSurveyDetails($hidd_GlId,$selGroupLeaderName,$hidd_survey,$hidd_fd, $hidd_td, $hidd_campus, $hidd_agent);
            if ($userData) {
                if (APP_THEME == 'OLD') {
                    ?>
                <table class="stdGLPaxUser styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"oSearch":{"bSmart": false},"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true}]}'>
                    <?php
                } else {
                    ?>
                <table id="surveyStudentDetailTable" class="datatable table table-bordered table-hover vertical-middle">
                    <?php
                }
                ?>
                    <thead>
                        <tr>
                            <th>Student name</th>
                            <th>Booking id</th>
                            <th>Campus</th>
                            <th>Week</th>
                            <th>Week start date</th>
                            <th>Survey date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                <tbody>
                <?php
                foreach ($userData as $stdUser) {
                    ?>
                        <tr>
                            <td><?php echo $stdUser['name']; ?></td>
                            <td><?php echo $stdUser['id_book']."_".$stdUser['id_year']; ?></td>
                            <td><?php echo $stdUser['nome_centri']; ?></td>
                            <td><?php echo $stdUser['week_no']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($stdUser['week_start'])); ?></td>
                            <td><?php echo (!empty($stdUser['submitted_date']) ? date('d/m/Y', strtotime($stdUser['submitted_date'])) : ''); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="javascript:void(0);" data-id="<?php echo $stdUser['id_prenotazione'];?>" data-modal="<?php echo $stdUser['uuid'].$stdUser['week_no']?>" data-date="<?php echo $stdUser['week_start'];?>" class="showSurveyDetails min-wd-24 btn btn-xs btn-primary" >
                                        <span data-original-title="View" data-container="body" data-toggle="tooltip">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </a>
                                    <a href="<?php echo base_url();?>index.php/student_survey/print_pdf_survey_details/<?php echo $stdUser['week_start'];?>/<?php echo $stdUser['id_prenotazione'];?>" data-id="<?php echo $stdUser['id_prenotazione'];?>" data-modal="<?php echo $stdUser['uuid'].$stdUser['week_no']?>" data-date="<?php echo $stdUser['week_start'];?>" class="showSurveyDetailsPdf min-wd-24 btn btn-xs btn-danger" >
                                        <span data-original-title="View" data-container="body" data-toggle="tooltip">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                }
                ?></tbody></table><?php
            } else {
                ?>
                <span>No record(s) found.</span>
                <?php
            }
        }
    }
    
}
/* End of file survey.php */