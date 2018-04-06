<?php
/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 10 Jan 2018
 * @Modified    : 
 * @Description : Contacts model
 */
Class Contactsmodel extends Model {

    var $table_name = "agnt_contacts";
    
    function __construct() {
        parent::__construct();
    }

    /**
     * getData
     * Get records form rooms table
     * @param int $cont_id default 0
     * @return mixed|int
     * @throws Exception 
     */
    function getData($cont_id = 0, $agentId = 0) {
        $result = null;
        try {

            if ($cont_id > 0) {
                $this->db->where('cont_id', $cont_id);
            }
            else
                $this->db->where('cont_agent_id', $agentId);
            
            $this->db->where('cont_is_deleted',0);
            
            $this->db->join('agenti','id = cont_agent_id');
            
            $this->db->select('cont_id,cont_agent_id,cont_name,cont_surname,cont_email,cont_role,cont_phone_number,cont_category,cont_is_active');
            $this->db->order_by('cont_id','DESC');
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
    
    function getAgentsIds($account) {
        $dataend = "";
        $this->db->select('group_concat(id) as agents_ids');
        $this->db->where('account',$account);
        $Q = $this->db->get('agenti');
        if($Q->num_rows()){
            $dataend = $Q->row()->agents_ids;
        }
        $Q->free_result();
        return $dataend;
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
                    $this->db->where('cont_id', $edit_id);
                    $this->db->update($this->table_name, $data);
                    $result = $edit_id;
                    break;
                case 'delete':
                    $updateArr = array(
                        'cont_is_deleted' => 1
                    );
                    $this->db->where('cont_id', $edit_id);
                    $this->db->update($this->table_name, $updateArr);
                    $result = $edit_id;
                    break;
                case 'changestatus':
                    $this->db->where('cont_id', $edit_id);
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