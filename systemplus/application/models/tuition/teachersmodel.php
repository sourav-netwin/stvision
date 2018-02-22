<?php

/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 16 DEC 2015
 * @Modified    : 
 * @Description : Teachers model
 */
Class Teachersmodel extends Model {

    var $table_name = "plused_teachers";
    
    function __construct() {
        parent::__construct();
    }

    /**
     * getData
     * Get records form rooms table
     * @param int $teach_id default 0
     * @return mixed|int
     * @throws Exception 
     */
    function getData($teach_id = 0,$campusId = 0) {
        $result = null;
        try {

            if ($teach_id > 0) {
                $this->db->where('teach_id', $teach_id);
            }
            if (!empty($campusId)) {
                $this->db->where('teach_campus_id', $campusId);
            }
            $this->db->where('teach_is_deleted',0);
            
            $this->db->join('centri','plused_teachers.teach_campus_id = centri.id','left');
            
            $this->db->select("teach_id,teach_campus_id,concat_ws(' ',teach_first_name,teach_last_name) as teacher_full_name,teach_first_name,teach_last_name,teach_from_date,teach_to_date,teach_hours_per_day,nome_centri,teach_is_active",false);
            $this->db->order_by('teach_id','DESC');
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
                    $this->db->where('teach_id', $edit_id);
                    $this->db->update($this->table_name, $data);
                    $result = $edit_id;
                    break;
                case 'delete':
                    $updateArr = array(
                        'teach_is_deleted' => 1
                    );
                    $this->db->where('teach_id', $edit_id);
                    $this->db->update($this->table_name, $updateArr);
                    $result = $edit_id;
                    break;
                case 'changestatus':
                    $this->db->where('teach_id', $edit_id);
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
    public function getCampusList($attivi=1,$campusId = 0) {
        $result = null;
        try {
            if(!empty($campusId))
                $this->db->where('id',$campusId);
            $this->db->select('id,nome_centri');
            $this->db->order_by('nome_centri');
            if($attivi==1){
                $this->db->where('attivo',$attivi);
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
    
    function insertApplication($insertData = array()){
         $this->db->insert('plused_teacher_application', $insertData);
         return $this->db->insert_id();
    }
    
    function updateApplication($updateData = array(),$edit_id = 0){
         $this->db->where('ta_id',$edit_id);
         $this->db->update('plused_teacher_application', $updateData);
         return 1;//$this->db->affected_rows();
    }

}

//End login model
?>