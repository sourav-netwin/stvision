<?php
/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 03-08-2016
 * @Modified    : 
 * @Description : Access model used to allocate/manage menus for the selected role
 */
Class Accessmodel extends Model {

    var $table_name = "plused_role_access";
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     * This function will return list of active roles.
     * @return int 
     */
    function getRoles(){
        $this->db->where('role_is_active',1);
        $this->db->where('role_is_deleted',0);
        $this->db->select("plused_role.*, group_concat(plused_role_menu.mnu_menu_name order by mnu_parent_menu_id, mnu_sequence asc SEPARATOR '&#44; ') as menu_name");
        $this->db->join('plused_role_access','plused_role.role_id = plused_role_access.acc_role_id','left');
        $this->db->join('plused_role_menu','plused_role_access.acc_menu_id = plused_role_menu.mnu_menuid','left');
        $this->db->group_by('role_id');
        $this->db->order_by('role_id','desc');
        $result = $this->db->get('plused_role');
        if($result->num_rows()){
            return $result->result_array();
        }
        else
            return 0;
    }
    
    /**
     * this function returns all menus to list on role menu access management
     * @param int $parent_id
     * @param string $menuType
     * @return array 
     */
    public function getData($parent_id = 0,$menuType = 'Left')
    {
        $menuList = array();
        $this->db->select("mnu_menuid,mnu_menu_name,mnu_caption,mnu_parent_menu_id,mnu_level,mnu_type,mnu_sequence,mnu_url,mnu_status,is_deleted",FALSE);

        $this->db->where(
                    array(
                        'is_deleted' => 0,
                        'mnu_parent_menu_id' => $parent_id,
                        'mnu_type' => $menuType
                    ));
        $this->db->order_by('mnu_sequence','asc');
        $result = $this->db->get('plused_role_menu');
        if($result->num_rows()){
            $resultMenu = $result->result_array();
            foreach($resultMenu as $ele){
                $child_parent_id = $ele['mnu_menuid'];
                if($child_parent_id)
                {
                    $childArr = $this->getData($child_parent_id);
                    if($childArr){
                        $ele['child'] = $childArr;
                    }
                    array_push($menuList,$ele);
                }
            }
        }
        return $menuList;
    }
    
    /**
     * This function toggle the access to the specific menu and role
     * @param int $role_id
     * @param int $menu_id
     * @param int $access
     * @param int $parent_menu_id
     * @return int 
     */
    function menuRoleAccess($role_id, $menu_id, $access = "", $parent_menu_id = 0){
        $whereArr = array(
            'acc_role_id' => $role_id,
            'acc_menu_id' => $menu_id
        );
        $this->db->where($whereArr);
        $result = $this->db->get('plused_role_access');
        if($result->num_rows()){
            $this->removeMenuAccess($role_id,$menu_id);
            // check parent menu is added or not
            if($parent_menu_id){
                $this->checkParentMenuAndRemove($parent_menu_id,$role_id);
            }
        }
        else{
            $this->addMenuAccess($role_id,$menu_id);
            // check parent menu is added or not
            if($parent_menu_id){
                $this->checkParentMenuAndInsert($parent_menu_id,$role_id);
            }
            return 1;
        }
        return 0;
    }
    
    /**
     * Add access to menu and role
     * @param int $role_id
     * @param int $menu_id 
     */
    function addMenuAccess($role_id,$menu_id){
        $whereArr = array(
                        'acc_role_id' => $role_id,
                        'acc_menu_id' => $menu_id
                    );
        $this->db->where($whereArr);
        $this->db->limit(1);
        $result = $this->db->get('plused_role_access');
        if(!$result->num_rows()){
            $insertArr = array(
                'acc_role_id' => $role_id,
                'acc_menu_id' => $menu_id
            );
            $this->db->insert('plused_role_access',$insertArr);
        }
    }
    
    /**
     * This function remove access for menu and role.
     * @param int $role_id
     * @param int $menu_id 
     */
    function removeMenuAccess($role_id,$menu_id){
        $this->db->flush_cache();
        $whereArr = array(
            'acc_role_id' => $role_id,
            'acc_menu_id' => $menu_id
        );
        $this->db->where($whereArr);
        $this->db->delete('plused_role_access');
    }
    
    /**
     * check parent menu is added or not 
     */
    function checkParentMenuAndInsert($parent_menu_id,$role_id)
    {
            $this->db->flush_cache();
            $whereArr = array(
                'acc_role_id' => $role_id,
                'acc_menu_id' => $parent_menu_id
            );
            $this->db->where($whereArr);
            $p_result = $this->db->get('plused_role_access');
            if($p_result->num_rows() == 0){
                $this->addMenuAccess($role_id,$parent_menu_id);
            }
    }
    
    /**
     * check parent menu is added or not 
     */
    function checkParentMenuAndRemove($parent_menu_id,$role_id)
    {
        $this->db->flush_cache();
        $whereArr = array(
            'acc_role_id' => $role_id,
            'mnu_parent_menu_id' => $parent_menu_id
        );
        $this->db->where($whereArr);
        $this->db->join('plused_role_menu','plused_role_access.acc_menu_id = plused_role_menu.mnu_menuid');
        $this->db->limit(1);
        $p_result = $this->db->get('plused_role_access');
        if($p_result->num_rows() == 0){
            $this->removeMenuAccess($role_id,$parent_menu_id);
        }
    }
    
    /**
     * This function returns all menus for the given role
     * @param type $role_id
     * @return int 
     */
    function getRoleMenus($role_id){
        $whereArr = array(
            'acc_role_id' => $role_id
        );
        $this->db->where($whereArr);
        $this->db->select('acc_menu_id as id');
        $result = $this->db->get('plused_role_access');
        if($result->num_rows())
        {
            return $result->result_array();
        }
        return 0;
        
    }
    
    /**
     * This function toggle the access to the menu for specific menu with its all child menus
     * @param int $role_id
     * @param int $menu_id
     * @param boolean $checked
     * @return array 
     */
    function childMenuRoleAccess($role_id, $menu_id,$checked){
        $this->db->where('mnu_parent_menu_id',$menu_id);
        $this->db->where('is_deleted',0);
        $this->db->select('mnu_menuid');
        $result = $this->db->get('plused_role_menu');
        $childMenuArr = array($menu_id);
        //add/remove parent menu access
        if($checked){
            $this->addMenuAccess($role_id,$menu_id);
        }
        else{
            $this->removeMenuAccess($role_id,$menu_id);
        }
        
        if($result->num_rows())
        {
            foreach($result->result_array() as $mnuRow){
                $child_menu_id = $mnuRow['mnu_menuid'];
                array_push($childMenuArr, $child_menu_id);
                if($checked)
                {
                    $this->db->flush_cache();
                    $whereArr = array(
                        'acc_role_id' => $role_id,
                        'acc_menu_id' => $child_menu_id
                    );
                    $this->db->where($whereArr);
                    $result = $this->db->get('plused_role_access');
                    if(!$result->num_rows()){
                        $this->addMenuAccess($role_id,$child_menu_id);
                    }
                }
                else
                {
                    $this->removeMenuAccess($role_id,$child_menu_id);
                }
                $childParentResult = $this->childMenuRoleAccess($role_id, $child_menu_id,$checked);
                if($childParentResult['result']){
                    if(count($childParentResult['mnus'])){
                        $childMenuArr = array_merge($childMenuArr, $childParentResult['mnus']);
                    }
                }
            }
            return array('result'=>1,'mnus'=>$childMenuArr);
        }
        return array('result'=>0,'mnus'=>$childMenuArr);
    }
}
//End Access model
?>