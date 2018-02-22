<?php

/**
 * Class for excursion management(Model)
 * @author Sandip
 * @since 28-Nov-2016
 */
class Excursions_model extends Model {
    
    function __construct() {
        parent::__construct();
    }
    
    var $table_name = "agnt_excursions";
    
    /**
     * getData
     * This function 
     * @param type $exc_id
     * @param type $exc_type
     * @return int
     * @throws Exception 
     */
    function getData($exc_id = 0,$exc_type = '') {
        $result = null;
        try {
            if ($exc_id > 0) {
                $this->db->where('exc_id', $exc_id);
            }
            if($exc_type == "transfer")
                $this->db->where('exc_type', 'transfer');
            else
                $this->db->where('exc_type !=', 'transfer');
            
            $this->db->where('exc_is_deleted',0);
            $this->db->select('exc_id,exc_excursion_name,exc_brief_description,exc_old_exc_id,exc_type,exc_days,exc_weeks,
                            exc_airport,exc_day_type,exc_image,exc_created_on,exc_created_by,exc_is_active,
                            group_concat(c.nome_centri) as campus_name');
            $this->db->order_by('exc_id','DESC');
            $this->db->group_by('exc_id');
            
            $this->db->from("agnt_excursions e");
            $this->db->join("agnt_campus_excursion ce","e.exc_id = ce.excm_exc_id");
            $this->db->join("centri c","ce.excm_campus_id = c.id");
                    
            $result = $this->db->get();
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
     * This function handles insert and update funtionality for the excursions / transfer
     * @param mixed $action
     * @param array $data
     * @param int $edit_id
     * @return int boolean
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
                    $this->db->where('exc_id', $edit_id);
                    $this->db->update($this->table_name, $data);
                    $result = $edit_id;
                    break;
                case 'delete':
                    $updateArr = array(
                        'exc_is_deleted' => 1
                    );
                    $this->db->where('exc_id', $edit_id);
                    $this->db->update($this->table_name, $updateArr);
                    $result = $edit_id;
                    break;
                case 'changestatus':
                    $this->db->where('exc_id', $edit_id);
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
    
    function mapCampus($campusIds,$excursionId){
        $oldMappedCampus = $this->getExcursionCampusId($excursionId);
        $oldCampusIds = array();
        if($oldMappedCampus){
            foreach($oldMappedCampus as $dbCampusId){
                $oldCampusIds[] = $dbCampusId['excm_campus_id'];
            }
        }
        $oldMappedCampus = $oldCampusIds;
        
        $deleteArray = array();
        $insertArray = array();
        if($oldMappedCampus != 0 && is_array($oldMappedCampus) && is_array($campusIds)){
            $deleteArray = array_diff($oldMappedCampus, $campusIds);
            $insertArray = array_diff($campusIds, $oldMappedCampus);
        }
        if($oldMappedCampus == 0){
            $insertArray = $campusIds;
        }
        if(count($deleteArray)){
             $this->db->where_in('excm_campus_id',$deleteArray);
             $this->db->where('excm_exc_id',$excursionId);
             $this->db->delete("agnt_campus_excursion");
        }

        if(count($insertArray)){
            foreach($insertArray as $campusMap){
                $this->insertMapRec($campusMap,$excursionId);
            }
        }
        return 1;
    }
    
    function getExcursionCampusId($excursionId){
        $this->db->where('excm_exc_id',$excursionId);
        $this->db->select('excm_campus_id');
        $excRec = $this->db->get("agnt_campus_excursion");
        if($excRec->num_rows()){
            return $excRec->result_array();
        }
        return 0;
    }
    
    function checkMapExcursion($campusId,$excursionId){
        $this->db->where('excm_exc_id',$excursionId);
        $this->db->where('excm_campus_id',$campusId);
        $excRec = $this->db->get("agnt_campus_excursion");
        if($excRec->num_rows()){
            return $excRec->row();
        }
        else
            return 0;
    }
    
    function insertMapRec($campusId,$excMap){
        $insertMap = array(
            'excm_campus_id' => $campusId,
            'excm_exc_id' => $excMap
        );
        $this->db->insert('agnt_campus_excursion',$insertMap);
    }
    
    /**
     * insertUpdate
     * This function is used to update the excursion against campuses.
     * if there are already mapped excursions against campus it will 
     * skip those excursion and update only new excursions.
     * also delete the removed excurions for the campus.
     * @param int $campusId
     * @param array $excTraIds
     * @param string $excType
     * @return int 
     */
    function insertUpdate($campusId, $excTraIds, $excType){
        $oldMappedExc = $this->getMappedExcursions($excType,$campusId);
        if($oldMappedExc)
        {
            $oldMappedExc = explode(',', $oldMappedExc[0]['excm_exc_id']);
        }
        
        $deleteArray = array();
        $insertArray = array();
        if($oldMappedExc != 0 && is_array($oldMappedExc) && is_array($excTraIds)){
            $deleteArray = array_diff($oldMappedExc, $excTraIds);
            $insertArray = array_diff($excTraIds, $oldMappedExc);
        }
        if($oldMappedExc == 0){
            $insertArray = $excTraIds;
        }
       
        if(count($deleteArray)){
             $this->db->where_in('excm_exc_id',$deleteArray);
             $this->db->where('excm_campus_id',$campusId);
             $this->db->delete("agnt_campus_excursion");
        }

        if(count($insertArray)){
            foreach($insertArray as $excMap){
                $insertMap = array(
                    'excm_campus_id' => $campusId,
                    'excm_exc_id' => $excMap
                );
                $this->db->insert('agnt_campus_excursion',$insertMap);
            }
        }
        return 1;
    }


    /**
     * getDataCampuses
     * Get the data for the campuses.
     * @param type $excType
     * @return int 
     */
    function getDataCampuses($excType){
        $this->db->from("agnt_campus_excursion ce");
        $this->db->join("agnt_excursions e","ce.excm_exc_id = e.exc_id and exc_is_deleted = 0 and exc_type = '".$excType."'");
        $this->db->join("centri c","ce.excm_campus_id = c.id");
        $this->db->select("c.nome_centri,c.id as campus_id,group_concat(exc_excursion_name) as exc_excursion_name,exc_type,exc_brief_description,exc_days,exc_airport");
        $this->db->group_by('c.id');
        $result = $this->db->get();
        if ($result->num_rows()) {
            return $result->result_array();
        }
        else
            return 0;
    }
    
    /**
     * getMappedExcursions
     * get data for the mapped excursion/transfer for the campus.
     * @param type $excType
     * @param type $campusId
     * @return int 
     */
    function getMappedExcursions($excType,$campusId){
        $this->db->from("agnt_campus_excursion ce");
        $this->db->join("agnt_excursions e","ce.excm_exc_id = e.exc_id and exc_is_deleted = 0 and exc_type = '".$excType."'");
        $this->db->join("centri c","ce.excm_campus_id = c.id");
        $this->db->select("group_concat(excm_exc_id) as excm_exc_id");
        $this->db->where("ce.excm_campus_id",$campusId);
        $this->db->group_by('c.id');
        $result = $this->db->get();
        if ($result->num_rows()) {
            return $result->result_array();
        }
        else
            return 0;
    }
    
    /**
    * function for get campus record
    * @author SK
    * @since 08-09-2017
    * @return int array
    */
    function getCampusData() {
            $this -> db -> select('id, nome_centri,located_in')
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
     * getAllExcursion
     * get all excursion as per type 
     * excursion or transfer
     * @param type $exc_type
     * @return int
     * @throws Exception 
     */
    function getAllExcursion($exc_type = '') {
        $result = null;
        try {
            if($exc_type == "transfer")
                $this->db->where('exc_type', 'transfer');
            else
                $this->db->where('exc_type !=', 'transfer');
            
            $this->db->where('exc_is_deleted',0);
            $this->db->where('exc_is_active',1);
            $this->db->select('exc_id,exc_excursion_name,exc_brief_description,exc_old_exc_id,exc_type,exc_days,exc_weeks,exc_airport,exc_created_on,exc_created_by,exc_is_active');
            $this->db->order_by('exc_id','DESC');
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
}

/*End of file excursionmodel.php*/
