<?php

/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 10 DEC 2015
 * @Modified    : 
 * @Description : Campus course model
 */

Class Campuscoursemodel extends Model {

    var $table_name = "plused_campus_courses";
    
    function __construct() {
        parent::__construct();
    }

    /**
     * getData
     * Get records form courses table
     * @param int $cc_id default 0
     * @return mixed|int
     * @throws Exception 
     */
    function getData($cc_id = 0,$campusId = 0) {
        $result = null;
        try {

            if ($cc_id > 0) {
                $this->db->where('cc_id', $cc_id);
            }
            
            if ($campusId > 0) {
                $this->db->where('cc_campus_id', $campusId);
            }
            
            $this->db->where('cc_is_deleted',0);
            
            $this->db->join('centri','plused_campus_courses.cc_campus_id = centri.id','left');
            
            $this->db->select('cc_id,cc_course_name,cc_campus_id,cc_course_type,cc_total_hours,nome_centri,cc_is_active');
            $this->db->order_by('cc_id','DESC');
            $result = $this->db->get($this->table_name);
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
     * operations
     * This function can be use for below operations
     * insert | update | delete | changestatus
     * @param string $action
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
                    $this->db->where('cc_id', $edit_id);
                    $this->db->update($this->table_name, $data);
                    $result = $edit_id;
                    break;
                case 'check_classes':
                    $this->db->where('class_campus_course_id',$edit_id);
                    $this->db->where('class_is_deleted',0);
                    $resutData = $this->db->get('plused_classes');
                    if($resutData->num_rows())
                        return 1;
                    else
                        return 0;
                    break;
                case 'delete':
                    $updateArr = array(
                        'cc_is_deleted' => 1
                    );
                    $this->db->where('cc_id', $edit_id);
                    $this->db->update($this->table_name, $updateArr);
                    $result = $edit_id;
                    break;
                case 'changestatus':
                    $this->db->where('cc_id', $edit_id);
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
     * getCampusList
     * This function returns list of campuses
     * @return array
     * @throws Exception 
     */
    public function getCampusList($attivi = 1, $campusId = 0) {
        $result = null;
        try {
            if ($campusId)
                $this->db->where('id', $campusId);
            $this->db->select('id,nome_centri,valuta_fattura');
            $this->db->order_by('nome_centri');
            if ($attivi == 1) {
                $this->db->where('attivo', $attivi);
            }
            $res = $this->db->get('centri');
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
     * getCampusCourses
     * This function returns list of campus courses
     * @return array
     * @throws Exception 
     */
    public function getCampusCourses($campusId = 0) {
        $result = 0;
        try {
            if(!empty($campusId))
            {
                $this->db->select("cc_id, concat_ws( ' - ', cc_course_name, cc_course_type ) AS cc_course_name");
                $this->db->where('cc_campus_id',$campusId);
                $this->db->where('cc_is_active',1);
                $this->db->where('cc_is_deleted',0);
                $res = $this->db->get('plused_campus_courses');
                if ($res->num_rows()) {
                    $result = $res->result_array();
                }
                $res->free_result();
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

}

//End login model
?>