<?php
/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 15 DEC 2015
 * @Modified    : 
 * @Description : Campus rooms model
 */
Class Campusroomsmodel extends Model {

    var $table_name = "plused_campus_rooms";
    
    function __construct() {
        parent::__construct();
    }

    /**
     * getData
     * Get records form rooms table
     * @param int $cr_id default 0
     * @return mixed|int
     * @throws Exception 
     */
    function getData($cr_id = 0, $campusId = 0) {
        $result = null;
        try {

            if ($cr_id > 0) {
                $this->db->where('cr_id', $cr_id);
            }
            if (!empty($campusId)) {
                $this->db->where('cr_campus_id', $campusId);
                $this->db->where('cr_is_active', 1);
            }
            $this->db->where('cr_is_deleted',0);
            
            $this->db->join('centri','plused_campus_rooms.cr_campus_id = centri.id','left');
            
            $this->db->select('cr_id,cr_campus_id,cr_number_of_rooms,cr_students_per_room,cr_allotment_from_date,cr_allotment_to_date,nome_centri,cr_is_active');
            $this->db->order_by('cr_id','DESC');
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
                    $this->db->where('cr_id', $edit_id);
                    $this->db->update($this->table_name, $data);
                    $result = $edit_id;
                    break;
                case 'delete':
                    $updateArr = array(
                        'cr_is_deleted' => 1
                    );
                    $this->db->where('cr_id', $edit_id);
                    $this->db->update($this->table_name, $updateArr);
                    $result = $edit_id;
                    break;
                case 'changestatus':
                    $this->db->where('cr_id', $edit_id);
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
            $this->db->select('id,nome_centri,valuta_fattura');
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

}

//End login model
?>