<?php

/**
 * Model for contract
 * @author SK
 * @since 14-Mar-2016
 */
class Contractmodel extends Model {

	var $table_name = "pulsed_job_contract";

	function __construct() {
		parent::__construct();
	}

	/**
	 * Function to get applicant details
         * It will retrive only those application records which has already recieved offer letters.
	 * @author SK
	 * @since 14-Mar-2016
	 */
	function getApplicantDetails($applicantId = 0) {
		$this -> db -> select('ta_id, ta_firstname, ta_lastname, ta_email,ta_postcode,ta_address,ta_city,ta_country',false)
				-> from('plused_teacher_application');
                if($applicantId)
                    $this->db->where('ta_id',$applicantId);
                
                $this->db->join('pulsed_job_offer_letters','plused_teacher_application.ta_id = pulsed_job_offer_letters.jof_teacher_app_id');
                $this->db->group_by('plused_teacher_application.ta_id');
                $this->db->order_by("concat(ta_firstname,' ',ta_lastname)","Asc");
		$result = $this -> db -> get();
                if ($result -> num_rows() && $applicantId) {
			return $result -> row();
		}
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	/**
	 * function for get position record
	 * @author SK
	 * @since 14-Mar-2016
	 * @return int
	 */
	function getPositionData() {
		$this -> db -> select('pos_id, pos_position')
				-> from('plused_job_positions')
                                -> order_by('pos_position','asc');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return 0;
		}
	}

	/**
	 * function for get position record
	 * @author SK
	 * @since 14-Mar-2016
	 * @return int
	 */
	function getCampusData() {
		$this -> db -> select('id, nome_centri')
				-> from('centri')
				-> where('attivo', 1)
				-> order_by('nome_centri');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return 0;
		}
	}

	/**
	 * operations
	 * This function can be use for below operations
	 * @author SK
	 * @since 14-Mar-2016
	 * insert | update | delete | changestatus
	 * @param string $action insert | update | delete | changestatus
	 * @param array $data
	 * @param int $edit_id
	 * @return int
	 * @throws Exception 
	 */
	public function operations($action, $data = array(), $edit_id = 0) {
		$result = null;
		try {
			switch ($action) {
				case 'insert':
					$this -> db -> insert($this -> table_name, $data);
					$result = $this -> db -> insert_id();
					break;
				case 'update':
					$this -> db -> where('joc_id', $edit_id);
					$this -> db -> update($this -> table_name, $data);
					$result = $edit_id;
					break;
				case 'delete':
					$updateArr = array(
						'joc_is_deleted' => 1
					);
					$this -> db -> where('joc_id', $edit_id);
					$this -> db -> update($this -> table_name, $updateArr);
					$result = $edit_id;
					break;
				case 'changestatus':
					$this -> db -> where('joc_id', $edit_id);
					$this -> db -> update($this -> table_name, $data);
					$result = $edit_id;
					break;
				default:
					break;
			}
		}
		catch (Exception $exp) {
			throw $exp;
		}
		return $result;
	}
        
        /**
	 * Function to get all contract datails for priority
	 * @author SK
	 * @since 02-May-2016
	 */
	function getContractDataForPriority($campusId = 0,$positionId = 0, $txtCalFromDate = "",  $txtCalToDate = "") {
		$this -> db -> select('a.joc_is_active,a.joc_id,a.joc_application_id, a.joc_from_date, a.joc_to_date, a.joc_salary, a.joc_currency, a.joc_res_non_res, a.joc_hourperweek_range, a.joc_extra_activities, a.joc_returnee,a.joc_contract_signed,a.joc_contract_file,a.joc_staff_priority,
                    a.joc_email,a.joc_address,a.joc_city,a.joc_postcode,a.joc_country,a.joc_wages,b.ta_firstname, b.ta_lastname, c.pos_position, d.nome_centri')
				-> from('pulsed_job_contract as a')
				-> join('plused_teacher_application as b', 'a.joc_application_id=b.ta_id')
				-> join('plused_job_positions as c', 'a.joc_position_id=c.pos_id')
				-> join('centri as d', 'a.joc_campus_id=d.id')
				-> where('a.joc_is_deleted', '0');
                
                $availableWhere = "";
                if (!empty($txtCalFromDate) && !empty($txtCalToDate)) {
                    $availableWhere = "((joc_from_date <= '" . $txtCalFromDate . "' AND joc_to_date >= '" . $txtCalFromDate . "') OR
                                        (joc_from_date <= '" . $txtCalToDate . "' AND joc_to_date >= '" . $txtCalToDate . "')
                                       OR (joc_from_date >= '" . $txtCalFromDate . "' AND joc_to_date <= '" . $txtCalToDate . "'))";
                    $this->db->where($availableWhere);
                }
                
                if($campusId)
                    $this->db->where('a.joc_campus_id',$campusId);
                if($positionId)
                    $this->db->where('a.joc_position_id',$positionId);
                $this->db->where('a.joc_contract_signed',1);
                $this->db->order_by('a.joc_staff_priority','desc');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Function to get all contract datails
	 * @author SK
	 * @since 15-Mar-2016
	 */
	function getContractData($teacherAppId = 0) {
		$this -> db -> select('a.joc_is_active,a.joc_id,a.joc_application_id, a.joc_from_date, a.joc_to_date, a.joc_salary, a.joc_currency, a.joc_res_non_res, a.joc_hourperweek_range, a.joc_extra_activities,a.job_board_as, a.joc_returnee,a.joc_contract_signed,a.joc_contract_file,a.joc_staff_priority,
                    a.joc_email,a.joc_address,a.joc_city,a.joc_postcode,a.joc_country,a.joc_wages,b.ta_firstname, b.ta_lastname, c.pos_position, d.nome_centri,
                    a.joc_created_on
                    ',FALSE)
				-> from('pulsed_job_contract as a')
				-> join('plused_teacher_application as b', 'a.joc_application_id=b.ta_id')
				-> join('plused_job_positions as c', 'a.joc_position_id=c.pos_id')
				-> join('centri as d', 'a.joc_campus_id=d.id')
				-> where('a.joc_is_deleted', '0');
                if($teacherAppId)
                    $this->db->where('a.joc_application_id',$teacherAppId);
                $this->db->order_by('a.joc_id','desc');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}
        
        /**
	 * Function to get all contract datails for campus
	 * @author SK
	 * @since 20-jun-2016
	 */
	function getTeachersDataForCD($campusId = 0, $keyword = '', $txtCalFromDate = '', $txtCalToDate = '') {
		$this -> db -> select('a.joc_is_active,a.joc_id,a.joc_application_id, a.joc_from_date, a.joc_to_date, a.joc_salary, a.joc_currency, a.joc_res_non_res, a.joc_hourperweek_range, a.joc_extra_activities, a.joc_returnee,a.joc_contract_signed,a.joc_contract_file,a.joc_staff_priority,
                    a.joc_email,a.joc_address,a.joc_city,a.joc_postcode,a.joc_country,a.joc_wages,
                    b.ta_firstname, b.ta_lastname,b.ta_date_of_birth,b.ta_interview_notes,b.ta_interview_strong,b.ta_interview_weak, c.pos_position, d.nome_centri,
                    rat.rat_stars')
				-> from('pulsed_job_contract as a')
				-> join('plused_teacher_application as b', 'a.joc_application_id=b.ta_id')
				-> join('plused_job_positions as c', 'a.joc_position_id=c.pos_id')
				-> join('plused_job_contract_rating as rat', 'a.joc_id = rat.rat_contract_id','left')
				-> join('centri as d', 'a.joc_campus_id=d.id')
				-> where('a.joc_is_deleted', '0');
                $this->db->where('a.joc_campus_id',$campusId);
                $this->db->where('a.joc_contract_signed',1);
                $this->db->where('c.pos_position','Teacher');
                
                if(!empty($keyword)){
                    $this->db->where(
                            "(b.ta_firstname LIKE '%".$keyword."%' 
                                OR b.ta_lastname LIKE '%".$keyword."%'
                                OR concat(b.ta_firstname,' ', b.ta_lastname) LIKE '%".$keyword."%'
                                OR b.ta_date_of_birth LIKE '%".$keyword."%'
                            )"
                            );
                }
                $availableWhere = "";
                if (!empty($txtCalFromDate) && !empty($txtCalToDate)) {
                    $availableWhere = "((joc_from_date <= '" . $txtCalFromDate . "' AND joc_to_date >= '" . $txtCalFromDate . "') OR
                                        (joc_from_date <= '" . $txtCalToDate . "' AND joc_to_date >= '" . $txtCalToDate . "')
                                       OR (joc_from_date >= '" . $txtCalFromDate . "' AND joc_to_date <= '" . $txtCalToDate . "'))";
                    $this->db->where($availableWhere);
                }
                
                
                $this->db->order_by('a.joc_id','desc');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Get records form contract table
	 * @author SK
	 * @since 15-Mar-2016
	 * @param int $contract_id default 0
	 * @return mixed|int
	 * @throws Exception 
	 */
	function getData($contract_id = 0) {
		$result = null;
		try {

			if ($contract_id > 0) {
				$this -> db -> where('joc_id', $contract_id);
			}
			$this -> db -> select('a.joc_id, a.joc_from_date, a.joc_to_date,a.joc_salary, a.joc_currency, a.joc_res_non_res, a.joc_hourperweek_range, a.joc_extra_activities,a.job_board_as, a.joc_returnee,a.joc_contract_signed,a.joc_contract_file,
                                            a.joc_email,a.joc_address,a.joc_city,a.joc_postcode,a.joc_country,a.joc_wages,b.ta_id, b.ta_firstname, b.ta_lastname, c.pos_id, c.pos_position, d.id, d.nome_centri')
					-> from('pulsed_job_contract as a')
					-> join('plused_teacher_application as b', 'a.joc_application_id=b.ta_id')
					-> join('plused_job_positions as c', 'a.joc_position_id=c.pos_id')
					-> join('centri as d', 'a.joc_campus_id=d.id');
			$result = $this -> db -> get();

			if ($result -> num_rows()) {
				return $result -> result_array();
			}
			else
				return 0;
		}
		catch (Exception $exc) {
			throw $exc;
		}
		return $result;
	}

	/**
	 * Function to check whether date range already in details
	 * @author SK
	 * @since 15-Mar-2016
	 * @param date $fromDate
	 * @param date $toDate
	 * @param int $applicantid
	 * @return boolean
	 */
	function checkDateRange($fromDate, $toDate, $applicantid) {
		$this -> db -> select('count(*) as count')
				-> from('pulsed_job_contract')
				-> where("('" . $fromDate . "' between joc_from_date and joc_to_date OR '" . $toDate . "' between  joc_from_date and joc_to_date)")
				-> where('joc_application_id', $applicantid)
				-> where('joc_is_deleted', 0);
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			$resultvalue = $result -> result_array();
			$resultcount = $resultvalue[0]['count'];
			if ($resultcount > 0) {
				return FALSE;
			}
			else {
				return TRUE;
			}
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Function to check whether date range already in details on edit
	 * @author SK
	 * @since 15-Mar-2016
	 * @param date $fromDate
	 * @param date $toDate
	 * @param int $applicantid
	 * @return boolean
	 */
	function checkDateRangeEdit($fromDate, $toDate, $applicantid, $editid) {
		
                $sqlSTR = "SELECT count(*) as count FROM (pulsed_job_contract) 
                            WHERE                            
                            ((joc_from_date <= '" . $fromDate . "' AND joc_to_date >= '" . $fromDate . "') OR
                            (joc_from_date <= '" . $toDate . "' AND joc_to_date >= '" . $toDate . "')
                            OR (joc_from_date >= '" . $fromDate . "' AND joc_to_date <= '" . $toDate . "'))
                          
                            AND joc_is_deleted = 0 
                            AND joc_application_id = ".$applicantid;
                
                if($editid)
                    $sqlSTR .= " AND joc_id != ".$editid;
                
                $result = $this->db->query($sqlSTR);
                //echo $this->db->last_query();die;
		if ($result->row()->count > 0) {
                    return FALSE;
		}
		return TRUE;
	}
        
        /* joc_from_date = '".$fromDate."' AND joc_to_date = '".$toDate."'
                            AND ((joc_from_date < '".$fromDate."' AND joc_to_date > '".$toDate."')
                            OR (joc_from_date BETWEEN '".$fromDate."' AND '".$toDate."')
                            OR (joc_to_date BETWEEN '".$fromDate."' AND '".$toDate."'))*/
       
    /**
     * This function can be use to retrive position name
     * @param int $positionId
     * @return string 
     */
    function getPositionsName($positionId = 0){
        if($positionId)
        {
            $this->db->where('pos_id',$positionId);
            $result = $this->db->get('plused_job_positions');
            if($result->num_rows())
            {
                return $result->row()->pos_position;
            }
        }
        else
            return '';
    }
    
    /**
     * This function retrives campus name
     * @param int $campusId
     * @return string 
     */
    function getCampusName($campusId = 0){
        if($campusId)
        {
            $this->db->where('id',$campusId);
            $result = $this->db->get('centri');
            if($result->num_rows())
            {
                return $result->row()->nome_centri;
            }
        }
        else
            return '';
    }
    
    /**
     * This function retrives contract signed staffs data for payroll
     * @return type
     * @throws Exception 
     */
    public function getContractPayrolls($selectedYear = ""){
        $result = array();
        try {
            $this->db->from('pulsed_job_contract');
            $this->db->join('plused_teacher_application','pulsed_job_contract.joc_application_id = plused_teacher_application.ta_id','left');   // here joc_id is mapped with teachers application table.
            $this->db->join('centri','pulsed_job_contract.joc_campus_id = centri.id');
            $this->db->join('pulsed_teachers_bank_detail','plused_teacher_application.ta_id = pulsed_teachers_bank_detail.tbd_user_id','LEFT');
            $this->db->join('plused_job_positions','pulsed_job_contract.joc_position_id = plused_job_positions.pos_id','LEFT');
            $this->db->select('joc_email,joc_from_date,joc_to_date,joc_position_id,joc_wages,joc_salary,joc_currency,pos_position,
                                nome_centri,
                                ta_firstname,ta_lastname,ta_passport_or_id_card,ta_date_of_birth,ta_nationality,ta_sex,ta_address,ta_city,ta_postcode,ta_country,
                                ta_ni_number,ta_ni_category,ta_making_slr,ta_slr_plan,ta_p45_status,ta_p45_starter_declaration,
                                tbd_currency_type,tbd_account_name,tbd_sort_code,tbd_account_number,tbd_iban,tbd_swift_bic
                                ',false);
            $this->db->where('joc_is_deleted',0);
            $this->db->where('joc_contract_signed',1);
            if(!empty($selectedYear))
            {
                if(is_numeric($selectedYear)){
                    $this->db->where("(year(joc_from_date) = ".$selectedYear." OR year(joc_to_date) = ".$selectedYear.")");
                }
            }
            $res = $this->db->get();
            //echo $this->db->last_query();die;
            if ($res->num_rows()) {
                $result = $res->result_array();
            }
            $res->free_result();
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }
        
    /**
     * This function will add review about the teachers application and contract 
     * Also it checks for review is already added or not?
     * If review is already added then it will updated(override) by new review
     * @param int $contractId
     * @param int $teacherApplicationId
     * @param int $stars
     * @param string $review
     * @return int 
     */
    function addContractReview($contractId, $teacherApplicationId, $stars, $review) {
        $whereArr = array(
            'rat_contract_id' => $contractId,
            'rat_application_id' => $teacherApplicationId,
        );
        $this->db->where($whereArr);
        $resultSet = $this->db->get('plused_job_contract_rating');
        if ($resultSet->num_rows()) {
            $arrayUpdate = array(
                'rat_stars' => $stars,
                'rat_review_text' => $review
            );
            $this->db->update('plused_job_contract_rating', $arrayUpdate, $whereArr);
        } else {
            $arrayInsert = array(
                'rat_contract_id' => $contractId,
                'rat_application_id' => $teacherApplicationId,
                'rat_stars' => $stars,
                'rat_review_text' => $review
            );
            $this->db->insert('plused_job_contract_rating', $arrayInsert);
        }
        return 1;
    }
    
    function getTeacherReview($contractId, $teacherApplicationId){
        $whereArr = array(
            'rat_contract_id' => $contractId,
            'rat_application_id' => $teacherApplicationId,
        );
        $this->db->where($whereArr);
        $resultSet = $this->db->get('plused_job_contract_rating');
        if ($resultSet->num_rows()) {
            return $resultSet->row();
        }
        else{
            return 0;
        }
    }
}