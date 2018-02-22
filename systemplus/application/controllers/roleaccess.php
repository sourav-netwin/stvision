<?php

class Roleaccess extends Controller {

    public function __construct() {

        parent::Controller();
        // check user session and menus with their access.
        authSessionMenu($this);
        
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('ltelayout');
        $this->load->model('role/accessmodel','accessmodel');
    }

    function index() 
    {
        $data = array();
        $data['title'] = "plus-ed.com | Menu access";
        $data['pageHeader'] = "Menu access";
        $data['breadcrumb1'] = "Role management";
        $data['breadcrumb2'] = "Menu access";
        $data['optionalDescription'] = "Roles with their menu(s) access...";
        
        $data['roleData'] = $this->accessmodel->getRoles();
        $data['roleMenuData'] = $this->accessmodel->getData();
        $this->ltelayout->view('role/accessmenu', $data);
    }
    
    public function getMenuHtml($mnuArr,$first = '',$last = '')
    {
        $isItParent = false;
        if(array_key_exists('child', $mnuArr))
            $isItParent = true;
        ?>
            <li class="list-group-item level_<?php echo $mnuArr['mnu_level'];?> <?php echo $first;?>">
                <?php echo $mnuArr['mnu_menu_name'];
                echo (!empty($mnuArr['mnu_caption']) ? " [".$mnuArr['mnu_caption']."]" : '');
                
                if(!$isItParent){
                ?>
                <div style="float: right; padding: 0 20px;">
                    <a data-id="<?php echo $mnuArr['mnu_menuid'];?>" data-pid="<?php echo $mnuArr['mnu_parent_menu_id'];?>" style="margin-right:0px;" title="Change access"  data-access="<?php echo 0;?>" class="access pull-right" id="st_<?php echo $mnuArr['mnu_menuid'];?>" role="button" href="javascript:void(0);">
                        <i class="fa fa-2x <?php echo (0 ? 'fa-check' : 'fa-ban');?>"></i>
                    </a>
                </div>
                <?php }else{//if(!$isItParent){
                    ?>
                <div style="float: right; padding: 0 21px;cursor: pointer;">
                    <label for="chk_<?php echo $mnuArr['mnu_menuid'];?>">Select all</label>&nbsp;
                    <input class="chkSelectAll" type="checkbox" id="chk_<?php echo $mnuArr['mnu_menuid'];?>" data-id="<?php echo $mnuArr['mnu_menuid'];?>" />
                </div>
                    <?php 
                }
                /*
                <div style="float: right; padding: 0 20px;">
                <a data-id="<?php echo $mnuArr['mnu_menuid'];?>" style="margin-right:0px;" title="Change Status"  data-status="<?php echo $mnuArr['mnu_status'];?>" class="status pull-right" id="st_<?php echo $mnuArr['mnu_menuid'];?>" data-toggle="modal" role="button" href="#myStatus">
                    <i class="<?php echo ($mnuArr['mnu_status'] == '1' ? 'fa fa-check fa-2x' : 'fa fa-2x fa-ban');?>"></i>
                </a>
                </div>
                 <div style="float: right; padding: 0 20px;">
                    <div style="float: left; width: 25px;">
                        <a data-id="<?php echo $mnuArr['mnu_menuid'];?>" style="margin-right:0px;" title="Move up" class="moveup pull-right" id="mp_<?php echo $mnuArr['mnu_menuid'];?>" href="<?php echo base_url().'cmsmenu/change_sequence/up/'.$mnuArr['mnu_menuid'];?>">
                            <i class="fa  fa-arrow-circle-up fa-2x"></i>
                        </a>
                    </div>
                    <div style="float: right; width: 25px;">
                        <a data-id="<?php echo $mnuArr['mnu_menuid'];?>" style="margin-right:0px;" title="Move down" class="movedown pull-right" id="mp_<?php echo $mnuArr['mnu_menuid'];?>" href="<?php echo base_url().'cmsmenu/change_sequence/down/'.$mnuArr['mnu_menuid'];?>">
                            <i class="fa  fa-arrow-circle-down fa-2x"></i>
                        </a>
                    </div>
                </div>
                 */
                ?>
            </li>
                <?php
                if(array_key_exists('child', $mnuArr))
                {
                    $first = 'first';   
                    $count = 0;
                    $last = ''; 
                    foreach($mnuArr['child'] as $mnu){
                        $count++;
                        if(count($mnuArr['child']) == $count)
                        {
                            if($first != 'first')
                                $first = 'last';
                            else
                                $first = 'single';
                        }
                        $this->getMenuHtml($mnu,$first);
                        $first = '';
                    }
                }
    }
    
    function loadaccess(){
        $role_id = $this->input->post('role');
        $roleMenus = $this->accessmodel->getRoleMenus($role_id);
        if($roleMenus){
            echo json_encode(array("result"=>1,"menus" => $roleMenus));
        }
        else
            echo json_encode(array("result"=>0));
    }
    
    function changemenu(){
        $role_id = $this->input->post('role');
        $access = $this->input->post('access');
        $menu_id = $this->input->post('menu_id');
        $parent_menu_id = $this->input->post('p_menu_id');
        $result = $this->accessmodel->menuRoleAccess($role_id, $menu_id, $access, $parent_menu_id);
        echo json_encode(array('result'=>$result));
    }
    
    function changechildmenu(){
        $role_id = $this->input->post('role');
        $menu_id = $this->input->post('menu_id');
        $checked = $this->input->post('checked');
        $result = $this->accessmodel->childMenuRoleAccess($role_id, $menu_id,$checked);
        if($result['result'])
            echo json_encode(array('result'=>1,'childmenus'=>$result['mnus']));
        else
            echo json_encode(array('result'=>0,'childmenus'=>$result['mnus']));
    }    
    
    
}
/* End of file roleaccess.php */