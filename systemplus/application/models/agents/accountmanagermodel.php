<?php
/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 16 Jan 2018
 * @Modified    : 
 * @Description : Accountmanager model
 */
Class Accountmanagermodel extends Model {

    var $table_name = "`plused_account-manager`";
    
    function __construct() {
        parent::__construct();
    }

    /**
     * getData
     * Get records form accountmanager table
     * @param int $id default 0
     * @return mixed|int
     * @throws Exception 
     */
    function getData($id = 0,$isActive = 0) {
        $result = null;
        try {
            if ($id > 0) {
                $this->db->where('id', $id);
            }
            $this->db->where('is_deleted',0);
            if($isActive)
                $this->db->where('is_active',1);
            $this->db->select('id,firstname,familyname,email,position,pwd,is_active');
            $this->db->order_by('id','DESC');
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
                    $this->db->where('id', $edit_id);
                    $this->db->update($this->table_name, $data);
                    $result = $edit_id;
                    break;
                case 'delete':
                    $updateArr = array(
                        'is_deleted' => 1
                    );
                    $this->db->where('id', $edit_id);
                    $this->db->update($this->table_name, $updateArr);
                    $result = $edit_id;
                    break;
                case 'changestatus':
                    $this->db->where('id', $edit_id);
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
    
   

}

//End login model
?>