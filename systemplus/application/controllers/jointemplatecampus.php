<?php

/**
 * Class to control VISA section
 * @since 25-Apr-2016
 * @author Arunsankar
 */
class Jointemplatecampus extends Controller {

	public function __construct() {

		parent::Controller();
		authSessionMenu($this);
		$this -> load -> helper(array('url'));
		$this -> load -> model("tuition/jointemplatecampusmodel", "jointemplatecampusmodel");
	}

	/**
	 * Show Join template campus UI
	 * @author Arunsankar
	 * @since 25-Apr-2016
	 */
	function index() {
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
			$data['title'] = "plus-ed.com | Join Template and Campus";
			$data['breadcrumb1'] = 'VISA management';
			$data['breadcrumb2'] = 'Join template and campus';
			$data["centri"] = $this -> jointemplatecampusmodel -> getCampusData();
			$data["mappedCentri"] = $this -> jointemplatecampusmodel -> getMappedData();
			$data['unmappedList'] = $this -> jointemplatecampusmodel -> getUnmappedList();
			if(APP_THEME == 'OLD'){
				$this -> load -> view('tuition/visa_join_template_campus', $data);
			}
			else{
				$data['pageHeader'] = "Join template and campus";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/visa/join_template_campus', $data);
			}
		}
		else {
			$this -> session -> sess_destroy();
			redirect('backoffice', 'refresh');
		}
	}
	
	function checkMapCount(){
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
			$selTemplate = $this -> input -> post('selTemplate');
			$rowCount = $this -> jointemplatecampusmodel -> getRowCount($selTemplate);
			if (!empty($campuses)) {
				echo '1';
			}
			else{
				echo '0';
			}
		}
		else {
			$this -> session -> sess_destroy();
			redirect('backoffice', 'refresh');
		}
	}

	/**
	 * Function to join templates with campuses
	 * @author Arunsankar
	 */
	function joinTempCamp() {
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
			if (!empty($_POST['btnMap'])) {//if clicked on button for mapping
				$selTemplate = $this -> input -> post('selTemplate');
				$campuses = $this -> input -> post('campuses');
				if ($selTemplate) {
					$rowCount = $this -> jointemplatecampusmodel -> getRowCount($selTemplate);
					if (!empty($campuses)) {
						$isMap = $this -> jointemplatecampusmodel -> mapTemplateCampus($selTemplate, $campuses);
					}
					else {
						$isMap = $this -> jointemplatecampusmodel -> deleteMapingFromTemplate($selTemplate);
						if ($rowCount == '0') {
							$this -> session -> set_flashdata('error_message', 'No mapping found to un-map');
							redirect('jointemplatecampus');
							exit(0);
						}
					}
					if ($isMap) {
						if($rowCount <= '0'){
							$this -> session -> set_flashdata('success_message', 'Mapped successfully');
							redirect('jointemplatecampus');
							exit(0);
						}
						else{
							$this -> session -> set_flashdata('success_message', 'Mapping updated successfully');
							redirect('jointemplatecampus');
							exit(0);
						}
					}
					else {
						$this -> session -> set_flashdata('error_message', 'Failed to map');
						redirect('jointemplatecampus');
						exit(0);
					}
				}
				else {
					$this -> session -> set_flashdata('error_message', 'Failed to map');
					redirect('jointemplatecampus');
					exit(0);
				}
			}
			elseif(!empty($_POST['btnCancelMap'])){//if clicked on button for cancel mapping
				$selTemplate = $this -> input -> post('selTemplate');
				$rowCount = $this -> jointemplatecampusmodel -> getRowCount($selTemplate);
				if ($rowCount == '0') {
					$this -> session -> set_flashdata('error_message', 'No mapping found to cancel');
					APP_THEME == 'OLD' ? redirect('jointemplatecampus') : '';
					exit(0);
				}
				else{
					$isMap = $this -> jointemplatecampusmodel -> deleteMapingFromTemplate($selTemplate);
					if($isMap){
						$this -> session -> set_flashdata('success_message', 'Mapping cancelled successfully');
						APP_THEME == 'OLD' ? redirect('jointemplatecampus') : '';
						exit(0);
					}
					else{
						$this -> session -> set_flashdata('error_message', 'Failed to cancel mapping');
						APP_THEME == 'OLD' ? redirect('jointemplatecampus') : '';
						exit(0);
					}
				}
			}
			else {
				$this -> session -> set_flashdata('error_message', 'Failed to map');
				APP_THEME == 'OLD' ? redirect('jointemplatecampus') : '';
				exit(0);
			}
		}
		else {
			$this -> session -> sess_destroy();
			redirect('backoffice', 'refresh');
		}
	}

	/**
	 * Function to get the list of mapped campuses
	 * @author Arunsankar
	 */
	function getCampuses() {
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
			$id = $this -> input -> post('id');
			$mappedCampuses = array();
			if (!empty($id)) {
				$mappedCampusesArray = $this -> jointemplatecampusmodel -> getMappedCampuses($id);
				if (!empty($mappedCampusesArray)) {
					foreach ($mappedCampusesArray as $mapped) {
						$mappedCampuses[] = $mapped['centri_id'];
					}
				}
				echo json_encode(array(
					'result' => $mappedCampuses
				));
			}
		}
		else {
			$this -> session -> sess_destroy();
			redirect('backoffice', 'refresh');
		}
	}
}