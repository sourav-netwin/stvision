<?php
/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 03-08-2016
 * @Modified    : 
 * @Description : Vauth model used to allocate/manage menus for the selected role
 */
Class Vauthmodel extends Model {

    var $table_name = "plused_role_access";
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     * This function retrive all assigned menus for specific role.
     * @param int $role_id
     * @return array | false
     */
    function getRoleMenus($role_id,$menuType = "Left"){
        $menuList = array();
        $this->db->select("
            prm.mnu_menu_name as parent_menu_name,prm.mnu_sequence as parent_mnu_sequence,
            rm.mnu_menuid,rm.mnu_menu_name,rm.mnu_parent_menu_id,rm.mnu_level,rm.mnu_type,
            rm.mnu_sequence,rm.mnu_url,rm.mnu_status,rm.is_deleted
            ",FALSE);
        $this->db->where(
                    array(
                        'rm.is_deleted' => 0,
                        'rm.mnu_type' => $menuType,
                        'ra.acc_role_id' => $role_id
                    ));
        $this->db->order_by('prm.mnu_sequence,rm.mnu_sequence','asc');
        $this->db->join('plused_role_menu rm','ra.acc_menu_id = rm.mnu_menuid');
        $this->db->join('plused_role_menu prm','rm.mnu_parent_menu_id = prm.mnu_menuid');
        $result = $this->db->get('plused_role_access ra');
        if($result->num_rows())
        {
            $resultRows = $result->result_array();
            $menuList = $resultRows;
        }
        $this->db->flush_cache();
        return $menuList;        
    }
    
    /**
     * Returns menus for left side bar accordinging to the role
     * @param type $roleId
     * @return type 
     */
    public function getLeftSideMenus($roleId = 0)
    {
        $this->db->flush_cache();
        $resultArr = array();
        $this->db->where('ra.acc_role_id',$roleId);
        $this->db->where('rm.mnu_parent_menu_id',0);
        $this->db->where('rm.mnu_type','Left');
        $this->db->join('plused_role_menu rm','ra.acc_menu_id = rm.mnu_menuid');
        $this->db->select('group_concat(rm.mnu_menuid) as pmenu_id');
        $result = $this->db->get('plused_role_access ra');
        
        $pmenu_id = 0;
        if($result->num_rows()){
            $pmenu_id = $result->row()->pmenu_id;
        }
        
        if(!empty($pmenu_id)){
            $pmenu_id = explode(',', $pmenu_id);
            $resultArr = $this->getFetchMenus($pmenu_id,$roleId, 'Left');
        }
        
        $this->db->flush_cache();
        return $resultArr;
    }
    
    public function getFetchMenus($parent_id = 0,$roleId = 0, $menuType = 'Left')
    {
        $this->db->flush_cache();
        $menuList = array();
        $this->db->select("mnu_menuid,mnu_menu_name,mnu_parent_menu_id,mnu_level,mnu_type,mnu_sequence,mnu_url,mnu_icon_class,mnu_status,is_deleted",FALSE);

        if(is_array($parent_id))
        {
            $this->db->where(
                    array(
                        'is_deleted' => 0,
                        'mnu_type' => $menuType
                    ));
            $this->db->where_in('mnu_menuid',$parent_id);
        }
        else{
            $this->db->where(
                    array(
                        'is_deleted' => 0,
                        'mnu_parent_menu_id' => $parent_id,
                        'mnu_type' => $menuType,
                        'ra.acc_role_id' => $roleId
                    ));
            $this->db->join('plused_role_access ra','mnu_menuid = ra.acc_menu_id');
        }
        $this->db->order_by('mnu_sequence','asc');
        $result = $this->db->get('plused_role_menu');
        if($result->num_rows()){
            $resultMenu = $result->result_array();
            foreach($resultMenu as $ele){
                $child_parent_id = $ele['mnu_menuid'];
                if($child_parent_id)
                {
                    $childArr = $this->getFetchMenus($child_parent_id,$roleId,$menuType);
                    if($childArr){
                        $ele['child'] = $childArr;
                    }
                    array_push($menuList,$ele);
                }
            }
        }
        $this->db->flush_cache();
        return $menuList;
    }
    
    /**
     * This function checks for the users access to the given url
     * as per provided user role, controller and method name
     * it checks in menu access table and return true/false
     * @param string $controllerName
     * @param string $methodName
     * @param string $userRoleId
     * @param int $isAjaxRequest
     * @return int 
     */
    function checkRoleMenusAuthentication($controllerName,$methodName,$userRoleId,$isAjaxRequest = 0){
        $this->db->flush_cache();
        $this->db->select("rm.mnu_menuid");
        $controllerName = trim($controllerName, '/');
        $methodName = trim($methodName, '/');
        $this->db->where(
            array(
                'rm.is_deleted' => 0,
                'ra.acc_role_id' => $userRoleId
            ));
        if(!$this->check_is_ajax()){ //$this->check_is_ajax()
//            null;//$this->db->like('rm.mnu_url',$controllerName);
//        else
//        {
            if($methodName == "" || $methodName == "index")
                $this->db->like('rm.mnu_url',$controllerName);
            else
                $this->db->like('rm.mnu_url',$controllerName . '/' .$methodName);
        }
        $this->db->join('plused_role_menu rm','ra.acc_menu_id = rm.mnu_menuid');
        $result = $this->db->get('plused_role_access ra');
        //echo $this->db->last_query();die;
        $this->db->flush_cache();
        if($result->num_rows()){ 
            return 1;
        }
        else{ 
            return 0;
        }
    }
    
    /**
    * Check if request is an AJAX call
    *
    */
    function check_is_ajax() {
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        return $isAjax;
    }
   
}
//End Access model