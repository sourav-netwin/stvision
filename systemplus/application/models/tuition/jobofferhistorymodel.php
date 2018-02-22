<?php
class Jobofferhistorymodel extends Model {

    /**
     * Function for showing job history table
     * @return array
     */
    function getJobHistoryData($filterYear = "") {
        $this->db->select('a.jof_id, a.jof_teacher_app_id,a.jof_teacher_app_id,a.jof_teacher_type, a.jof_currency, a.jof_rates, a.jof_wages, a.job_offer_file, DATE(a.jof_created_on) as jof_created_on, b.ta_firstname, b.ta_lastname, c.pos_position')
                ->from('pulsed_job_offer_letters as a')
                ->join('plused_teacher_application as b', 'a.jof_teacher_app_id=b.ta_id')
                ->join('plused_job_positions as c', 'a.jof_position_id=c.pos_id');
        
        if(!empty($filterYear))
            $this->db->where('year(jof_created_on)',$filterYear);
        
        $result = $this->db->get();
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return 0;
        }
    }

    /**
     * function for get position record
     * @return int
     */
    function getPositionData() {
        $this->db->select('pos_id, pos_position')
                ->from('plused_job_positions');
        $result = $this->db->get();
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return 0;
        }
    }

    /**
     * Function for get data from job history search
     * @param string $txtName
     * @param int $position
     * @param string $sex
     * @param string $currency
     * @param string $type
     * @param int $rate
     * @param date $txtCalFromDate
     * @param date $txtCalToDate
     */
    function getJobofferHistoryData($txtName, $position, $sex, $currency, $type, $rate, $txtCalFromDate, $txtCalToDate) {
        $result = null;
        try {
            if ($txtName) {
                $this->db->where("(
                    concat_ws(' ',b.ta_firstname,b.ta_lastname) like '%" . $txtName . "%' OR
                    b.ta_firstname like '%" . $txtName . "%' OR
                    b.ta_lastname like '%" . $txtName . "%'
                )");
            }
            if ($position) {
                $this->db->where('a.jof_position_id', $position);
            }
            if ($sex) {
                $this->db->where('b.ta_sex', $sex);
            }
            if ($currency) {
                $this->db->where('a.jof_currency', $currency);
            }
            if ($type) {
                $this->db->where('a.jof_teacher_type', $type);
            }
            if ($rate) {
                $this->db->where('a.jof_rates', $rate);
            }
            if ($txtCalFromDate && $txtCalToDate) {
                $this->db->where('DATE(a.jof_created_on) <=', $txtCalToDate);
                $this->db->where('DATE(a.jof_created_on) >=', $txtCalFromDate);
            }
            $this->db->select('a.jof_id, a.jof_teacher_app_id,a.jof_teacher_type, a.jof_residential, a.jof_currency, a.jof_rates, a.jof_wages, a.job_offer_file, DATE(a.jof_created_on) as jof_created_on, b.ta_firstname, b.ta_lastname, c.pos_position')
                    ->from('pulsed_job_offer_letters as a')
                    ->join('plused_teacher_application as b', 'a.jof_teacher_app_id=b.ta_id')
                    ->join('plused_job_positions as c', 'a.jof_position_id=c.pos_id');
            $result = $this->db->get();
            //echo $this -> db -> last_query();
            if ($result->num_rows()) {
                return $result->result_array();
            } else {
                return 0;
            }
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
}