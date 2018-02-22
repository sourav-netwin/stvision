<?php

/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 01 FEB 2016
 * @Modified    :
 * @Description : Teachersapp model
 */
Class Teachersappmodel extends Model {

    var $table_name = "plused_teacher_application";

    function __construct() {
        parent::__construct();
    }

    /**
     * getTeachersApplicationsData
     * Get records form rooms table
     * @param string $txtName
     * @param string $nationality
     * @param string $sex
     * @param string $fromBirth
     * @param string $toBirth
     * @param string $diplomas
     * @param string $txtCalFromDate
     * @param string $txtCalToDate
     * @return int
     * @throws Exception
     */
    function getTeachersApplicationsData($pageType = "cvreview", $txtName = "", $nationality = "", $sex = "", $fromBirth = "", $toBirth = "", $diplomas = array(), $txtCalFromDate = "", $txtCalToDate = "", $selPostcode = "", $selTeachYears = "", $selRegVerified = '', $selIntLevel = '') {
        $result = null;
        try {
            if ($pageType == 'cvreview')
                $this->db->where('ta_job_adv_sent', 0);
            else
                $this->db->where('ta_job_adv_sent', 1);

            if ($selRegVerified != '')
                $this->db->where('ta_check_ref', $selRegVerified);
            if ($selIntLevel != '')
                $this->db->where('ta_interview_level', $selIntLevel);

            if (!empty($txtName)) {
                $this->db->where("(
                    concat_ws(' ',ta_firstname,ta_lastname) like '%" . $txtName . "%' OR
                    ta_firstname like '%" . $txtName . "%' OR
                    ta_lastname like '%" . $txtName . "%'
                )");
            }
            if (!empty($selPostcode)) {
                $this->db->where('ta_postcode', $selPostcode);
            }
            if (!empty($selTeachYears)) {
                $this->db->where('ta_teach_years', $selTeachYears);
            }
            if (!empty($nationality)) {
                $this->db->where('ta_nationality', $nationality);
            }
            if (!empty($sex))
                $this->db->where('ta_sex', $sex);

            if (!empty($fromBirth) && !empty($toBirth)) {
                $this->db->where('ta_date_of_birth >= ', $fromBirth);
                $this->db->where('ta_date_of_birth <= ', $toBirth);
            } elseif (!empty($fromBirth)) {
                $this->db->where('ta_date_of_birth >= ', $fromBirth);
            } elseif (!empty($toBirth)) {
                $this->db->where('ta_date_of_birth <= ', $toBirth);
            }

            $diplomasWhere = "";

            if (!empty($diplomas)) {
                foreach ($diplomas as $dip) {
                    $diplomasWhere .= "ta_" . $dip . " = 1 AND ";
                }
            }
            if (!empty($diplomasWhere)) {
                $diplomasWhere = rtrim($diplomasWhere, 'AND ');
                $this->db->where("(" . $diplomasWhere . ")");
            }

            $availableWhere = "";
            if (!empty($txtCalFromDate) && !empty($txtCalToDate)) {
                $availableWhere = "((ta_ablility_from <= '" . $txtCalFromDate . "' AND ta_ablility_to >= '" . $txtCalFromDate . "') OR
                                    (ta_ablility_from <= '" . $txtCalToDate . "' AND ta_ablility_to >= '" . $txtCalToDate . "'))";
                $this->db->where($availableWhere);
            }

            $this->db->where('ta_is_deleted', 0);

            $this->db->select("ta_id,concat_ws(' ',ta_firstname,ta_lastname) as teacher_full_name,ta_firstname,ta_lastname,ta_date_of_birth,ta_nationality,ta_sex,ta_email,
                            ta_telephone,ta_address,ta_city,ta_postcode,ta_teach_years,ta_country,ta_ablility_from,
                            ta_ablility_to,ta_celta,ta_trinity_tesol,ta_delta,ta_dip_tesol,ta_b_ed,ta_pgce,
                            ta_ma_elt_tesol,ta_other_diploma,ta_cv,ta_other_document,ta_read_cv,ta_created_on,ta_created_by,
                            ta_is_deleted,
                            count(jof.jof_id) as offers_sent
                            ", false);

            $this->db->order_by('ta_id', 'DESC');
            $this->db->group_by('ta_id');
            $this->db->join('pulsed_job_offer_letters jof',"plused_teacher_application.ta_id = jof.jof_teacher_app_id","LEFT");
            $result = $this->db->get($this->table_name);
            //echo $this->db->last_query();die;
            if ($result->num_rows()) {
                return $result->result_array();
            }
            else
                return 0;
        } catch (Exception $exc) {
            throw $exc;
        }
        return $result;
    }

    /**
     * getTeachersApplicationsSingle
     * return single record of applicatin data
     * @param int $ta_id
     * @return int|mixed
     * @throws Exception
     */
    function getTeachersApplicationsSingle($ta_id = 0) {
        $result = null;
        try {
            $this->db->where('ta_id', $ta_id);
            $this->db->where('ta_is_deleted', 0);
            $this->db->select("ta_id,concat_ws(' ',ta_firstname,ta_lastname)as teacher_full_name,ta_firstname,ta_lastname,ta_date_of_birth,ta_nationality,ta_sex,ta_email,ta_password,
                            ta_telephone,ta_address,ta_city,ta_postcode,ta_teach_years,ta_country,ta_ablility_from,
                            ta_ablility_to,ta_celta,ta_trinity_tesol,ta_delta,ta_dip_tesol,ta_b_ed,ta_pgce,
                            ta_ma_elt_tesol,ta_other_diploma,ta_cv,ta_other_document,ta_passport_or_id_card,ta_created_on,ta_created_by,
                            ta_is_deleted,plused_uk_postcodes.area as postcode_area,
                            ta_job_adv_sent,ta_skype,ta_interview_notes,ta_interview_strong,ta_interview_weak,ta_interview_level,ta_check_ref,ta_check_returnee,ta_offer_sent,ta_signed_offer_received,
                            ta_ni_number,ta_right_to_work_uk,ta_ni_category,ta_making_slr,ta_slr_plan,ta_p45_status,ta_p45_starter_declaration,
                            tbd_id,tbd_currency_type,tbd_account_name,tbd_sort_code,tbd_account_number,tbd_iban,tbd_swift_bic
                            ", false);
            $this->db->join('plused_uk_postcodes', $this->table_name . '.ta_postcode = plused_uk_postcodes.code', 'left');
            $this->db->join('pulsed_teachers_bank_detail', $this->table_name . '.ta_id = pulsed_teachers_bank_detail.tbd_user_id', 'left');
            $result = $this->db->get($this->table_name);
            if ($result->num_rows()) {
                return $result->row();
            }
            else
                return 0;
        } catch (Exception $exc) {
            throw $exc;
        }
        return $result;
    }

    /**
     * getPostcodeData
     */
    function getPostcodeData() {
        $this->db->select("code,concat_ws(' ',code,area) as area", false);
        $this->db->order_by('area', 'asc');
        $result = $this->db->get('plused_uk_postcodes');
        if ($result->num_rows()) {
            return $result->result_array();
        }
        else
            return 0;
    }

    /**
     * operations
     * This function can be use for below operations
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
                    $this->db->insert($this->table_name, $data);
                    $result = $this->db->insert_id();
                    break;
                case 'update':
                    $this->db->where('ta_id', $edit_id);
                    $this->db->update($this->table_name, $data);
                    $result = $edit_id;
                    break;
                case 'delete':
                    $updateArr = array(
                        'ta_is_deleted' => 1
                    );
                    $this->db->where('ta_id', $edit_id);
                    $this->db->update($this->table_name, $updateArr);
                    $result = $edit_id;
                    break;
                case 'changestatus':
                    $this->db->where('ta_id', $edit_id);
                    $this->db->update($this->table_name, $data);
                    $result = $edit_id;
                    break;
                default:
                    break;
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * getTeacherHistory
     * this function returns records from teachers assigment to tuition schedule.
     * @param int $application_id
     * @return int
     * @throws Exception 
     */
    public function getTeacherHistory($application_id = 0) {
        $result = null;
        try {

            $this->db->where('teach_application_id', $application_id);
            $this->db->where('teach_is_deleted', 0);
            $this->db->join('centri', 'plused_teachers.teach_campus_id = centri.id', 'left');
            $this->db->select("teach_id,teach_campus_id,concat_ws(' ',teach_first_name,teach_last_name) as teacher_full_name,teach_first_name,teach_last_name,teach_from_date,teach_to_date,teach_hours_per_day,teach_application_id,nome_centri,teach_is_active", false);
            $this->db->order_by('teach_id', 'DESC');
            $result = $this->db->get('plused_teachers');

            if ($result->num_rows()) {
                return $result->result_array();
            }
            else
                return 0;
        } catch (Exception $exc) {
            throw $exc;
        }
        return $result;
    }

    /**
     * storeApplicationOtherFile
     * this function store records for appliation files
     * @param array $insertData
     * @return int 
     */
    function storeApplicationOtherFile($insertData = array()) {
        if (!empty($insertData)) {
            $this->db->insert('pulsed_teachers_other_files', $insertData);
            return $this->db->insert_id();
        }
        else
            return 0;
    }

    /**
     * updateApplicationOtherFile
     * this function updates records for application files
     * @param type $updateData
     * @param type $whereMatch
     * @return int 
     */
    function updateApplicationOtherFile($updateData = array(), $whereMatch = array()) {
        if (!empty($updateData)) {
            $this->db->where($whereMatch);
            $this->db->update('pulsed_teachers_other_files', $updateData);
            return 1;
        }
        else
            return 0;
    }

    /**
     * deleteApplicationOtherFile
     * this function deletes records from application files
     * @param array $deleteMatched
     * @return int 
     */
    function deleteApplicationOtherFile($deleteMatched = array()) {
        if (!empty($deleteMatched)) {
            $this->db->delete('pulsed_teachers_other_files', $deleteMatched);
            return 1;
        }
        else
            return 0;
    }

    /**
     * getApplicationOtherFiles
     * this function returns file records for teachers application
     * @param int $edit_id
     * @return int 
     */
    function getApplicationOtherFiles($edit_id = 0) {
        if ($edit_id) {
            $this->db->where('tof_teacher_appplication_id', $edit_id);
            $result = $this->db->get('pulsed_teachers_other_files');
            if ($result->num_rows()) {
                return $result->result_array();
            }
            else
                return 0;
        }
        else
            return 0;
    }
    
    /**
     * getPositions
     * this function returns all records from position table
     */
    function getPositions(){
        $result = $this->db->get('plused_job_positions');
        if($result->num_rows())
        {
            return $result->result_array();
        }
        else
            return 0;
    }
    
    /**
     * jobOfferOperations
     * this function can be used to make CRUD operations.
     * @param string $action purpos of action
     * @param array $data array of data
     * @param int $edit_id pk id for update or record selection
     * @return int 
     */
    function jobOfferOperations($action = 'insert',$data = array(),$edit_id = 0){
        $result = null;
        switch ($action)
        {
            case 'insert':
                    $this->db->insert('pulsed_job_offer_letters',$data);
                    $result = $this->db->insert_id();
                break;
            case 'update':
                    $this->db->where('jof_id', $edit_id);
                    $this->db->update('pulsed_job_offer_letters', $data);
                    $result = $edit_id;
                break;
            case 'delete':
                    // 
                break;
            default :
                break;
        }
        return $result;
    }
    
    /**
     * getSendJobOfferHistory
     * get the send job offers history for applicants.
     * @param int $teacherAppId
     * @return mixed 
     */
    function getSendJobOfferHistory($teacherAppId){
        $this->db->select("jof_id,jof_teacher_app_id,jof_position_id,jof_currency,jof_teacher_type,jof_rates,
            jof_wages,jof_residential,job_offer_file,concat_ws(' ',ta_firstname,ta_lastname) as applicant_name,
            pos_position,jof_created_on",FALSE);
        $this->db->where('jof_teacher_app_id',$teacherAppId);
        $this->db->join('plused_teacher_application ta','jof.jof_teacher_app_id = ta.ta_id','left');
        $this->db->join('plused_job_positions p','jof.jof_position_id = p.pos_id','left');
        $this->db->order_by('jof_id','DESC');
        $result = $this->db->get('pulsed_job_offer_letters jof');
        if($result->num_rows())
        {
            return $result->result_array();
        }
        else
        {
            return 0;
        }
    }
    
    /**
     * Function job offer letter
     * @return array
     */
    function getJobOfferLetter($jobOfferId = 0) {
        if($jobOfferId)
        {
            $this->db->select('job_offer_file')
                    ->from('pulsed_job_offer_letters');
            $this->db->where('jof_id',$jobOfferId);
            $result = $this->db->get();
            if ($result->num_rows()) {
                return $result->row();
            } else {
                return 0;
            }
        }
    }

}
//End login model
?>