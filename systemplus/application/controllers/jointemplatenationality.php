<?php

/**
 * Class to manage join between templates and nationalities
 * @author Arunsankar
 */
class Jointemplatenationality extends Controller {

	/**
	 * Constructor loads model and url helper
	 * @author Arunsankar
	 */
	public function __construct() {
		parent::Controller();
		authSessionMenu($this);
		$this -> load -> helper(array('url'));
		$this -> load -> model("tuition/jointemplatenationalitymodel", "jointemplatenationalitymodel");
	}

	/**
	 * Function to display the mapping page
	 * @author Arunsankar
	 */
	function index() {
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
			$data['title'] = "plus-ed.com | Join Template and Nationality";
			$data['breadcrumb1'] = 'Nationality management';
			$data['breadcrumb2'] = 'Join template and nationality';
			$data["nationalities"] = $this -> jointemplatenationalitymodel -> getNationalityData();
			$data["mappedNationalities"] = $this -> jointemplatenationalitymodel -> getMappedData();
			$data['campTemp'] = $this -> jointemplatenationalitymodel -> getCampusTemplate();
			$data['tempNoNationality'] = '';
			if ($data['campTemp']) {
				$data['tempNoNationality'] = $this -> jointemplatenationalitymodel -> getNoMapCampusNat($data['campTemp']);
			}
			$data['mapStatus'] = $this -> jointemplatenationalitymodel -> getMapStatus();
			$data['continents'] = $this -> jointemplatenationalitymodel -> getContinents();
			if(APP_THEME == 'OLD'){
				$this -> load -> view('tuition/visa_join_template_nationality', $data);
			}
			else{
				$data['pageHeader'] = "Join template and nationality";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/nationality/join_template_nationality', $data);
			}
		}
		else {
			$this -> session -> sess_destroy();
			redirect('backoffice', 'refresh');
		}
	}

	/**
	 * Function to display nationalities which are not mapped with campuses
	 * @author Arunsankar
	 */
	function nationalityNoMapCampus() {
		if ($this -> session -> userdata('role') == 100) {
			$data['campTemp'] = $this -> jointemplatenationalitymodel -> getCampusTemplate();
			$data['tempNoNationality'] = '';
			if ($data['campTemp']) {
				$data['tempNoNationality'] = $this -> jointemplatenationalitymodel -> getNoMapCampusNat($data['campTemp']);
			}
			if(APP_THEME == 'OLD'){
				$this -> load -> view('tuition/view_nationality_nomap', $data);
			}
			else{
				$this->load->view('lte/backoffice/nationality/nomap', $data);
			}
			
		}
		else {
			redirect('backoffice', 'refresh');
		}
	}
	
	function getJoinCount(){
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
			$selTemplate = $this -> input -> post('selTemplate');
			$rowCount = $this -> jointemplatenationalitymodel -> getRowCount($selTemplate);
			if($rowCount){
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
	 * Function to map tamplate with nationalities
	 * @author Arunsankar
	 */
	function joinTempNat() {
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
			if (!empty($_POST['btnMap'])) {//if clicked on button for mapping
				$selTemplate = $this -> input -> post('selTemplate');
				$nationalities = $this -> input -> post('nationalities');
				if ($selTemplate) {
					$rowCount = $this -> jointemplatenationalitymodel -> getRowCount($selTemplate);
					if (!empty($nationalities)) {
						$isMap = $this -> jointemplatenationalitymodel -> mapTemplateNationality($selTemplate, $nationalities);
					}
					else {
						$isMap = $this -> jointemplatenationalitymodel -> deleteMapingFromTemplate($selTemplate);
						if ($rowCount == '0') {
							$this -> session -> set_flashdata('error_message', 'No mapping found to un-map');
							redirect('jointemplatenationality');
							exit(0);
						}
					}
					if ($isMap) {
						if ($rowCount <= '0') {
							$this -> session -> set_flashdata('success_message', 'Mapped successfully');
							redirect('jointemplatenationality');
							exit(0);
						}
						else {
							$this -> session -> set_flashdata('success_message', 'Mapping updated successfully');
							redirect('jointemplatenationality');
							exit(0);
						}
					}
					else {
						$this -> session -> set_flashdata('error_message', 'Failed to map');
						redirect('jointemplatenationality');
						exit(0);
					}
				}
				else {
					$this -> session -> set_flashdata('error_message', 'Failed to map');
					redirect('jointemplatenationality');
					exit(0);
				}
			}
			elseif (!empty($_POST['btnCancelMap'])) {//if clicked on button for cancel mapping
				$selTemplate = $this -> input -> post('selTemplate');
				$rowCount = $this -> jointemplatenationalitymodel -> getRowCount($selTemplate);
				if ($rowCount == '0') {
					$this -> session -> set_flashdata('error_message', 'No mapping found to un-map');
					APP_THEME == 'OLD' ? redirect('jointemplatenationality') : '';
					exit(0);
				}
				else {
					$isMap = $this -> jointemplatenationalitymodel -> deleteMapingFromTemplate($selTemplate);
					if ($isMap) {
						$this -> session -> set_flashdata('success_message', 'Mapping cancelled successfully');
						APP_THEME == 'OLD' ? redirect('jointemplatenationality') : '';
						exit(0);
					}
					else {
						$this -> session -> set_flashdata('error_message', 'Failed to cancel mapping');
						APP_THEME == 'OLD' ? redirect('jointemplatenationality') : '';
						exit(0);
					}
				}
			}
			else {
				$this -> session -> set_flashdata('error_message', 'Failed to map');
				APP_THEME == 'OLD' ? redirect('jointemplatenationality') : '';
				exit(0);
			}
		}
		else {
			$this -> session -> sess_destroy();
			redirect('backoffice', 'refresh');
		}
	}

	/**
	 * Function to get the list of mapped nationalities
	 * @author Arunsankar
	 */
	function getNationalities() {
		if ($this -> session -> userdata('username') && $this -> session -> userdata('role') != 200) {
			$id = $this -> input -> post('id');
			$mappedNationalities = array();
			if (!empty($id)) {
				$mappedNationalitysArray = $this -> jointemplatenationalitymodel -> getMappedNationalities($id);
				if (!empty($mappedNationalitysArray)) {
					foreach ($mappedNationalitysArray as $mapped) {
						$mappedNationalities[] = $mapped['nat_id'];
					}
				}
				echo json_encode(array(
					'result' => $mappedNationalities
				));
			}
		}
		else {
			$this -> session -> sess_destroy();
			redirect('backoffice', 'refresh');
		}
	}

	/**
	 * Function to generate a common list of nationalities which are not  mapped for the nationality
	 * @author Arunsankar
	 */
	function common($str1, $str2, $str3 = '', $case_sensitive = false) {
		$ary1 = explode(' ', $str1);
		$ary2 = explode(' ', $str2);
		if ($str3) {
			$ary3 = explode(' ', $str3);
		}

		if ($case_sensitive) {
			$ary1 = array_map('strtolower', $ary1);
			$ary2 = array_map('strtolower', $ary2);
			if ($str3) {
				$ary3 = array_map('strtolower', $ary3);
			}
		}
		if ($str3) {
			return implode(' ', array_intersect($ary1, $ary2, $ary3));
		}
		return implode(' ', array_intersect($ary1, $ary2));
	}
}