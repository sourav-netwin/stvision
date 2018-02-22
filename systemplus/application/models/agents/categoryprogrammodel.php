<?php
/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 10 Nov 2017
 * @Modified    : 
 * @Description : Category program model
 */
Class Categoryprogrammodel extends Model {

    var $table_name = "agnt_program_categories";
    
    function __construct() {
        parent::__construct();
    }

    /**
     * getData
     * Get records form rooms table
     * @param int $procat_id default 0
     * @return mixed|int
     * @throws Exception 
     */
    function getData($procat_id = 0) {
        $result = null;
        try {

            if ($procat_id > 0) {
                $this->db->where('procat_id', $procat_id);
            }
            $this->db->where('procat_is_deleted',0);
            
            $this->db->select('procat_id,procat_name,procat_brief_description,
                procat_extended_description,procat_main_image,procat_is_active,
                procat_is_deleted');
            $this->db->order_by('procat_id','DESC');
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
                    $this->db->where('procat_id', $edit_id);
                    $this->db->update($this->table_name, $data);
                    $result = $edit_id;
                    break;
                case 'delete':
                    $updateArr = array(
                        'procat_is_deleted' => 1
                    );
                    $this->db->where('procat_id', $edit_id);
                    $this->db->update($this->table_name, $updateArr);
                    $result = $edit_id;
                    break;
                case 'changestatus':
                    $this->db->where('procat_id', $edit_id);
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
    
}//End login model