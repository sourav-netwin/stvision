<?php
/*
* Programmer Name:SK
* Purpose:content Controller
* Date:08 Dec 2017
* Dependency: cmsmenumodel.php
*/
class Cmsmenu extends Controller
{
        /*
        * Purpose: Constructor.
        * Date: 08 Dec 2017
        * Input Parameter: None
        *  Output Parameter: None
        */
	function __construct()
        {
            parent::__construct();
            $this->load->library("form_validation");
            $this->load->model('frontweb/cmsmenumodel','cmsmenumodel',TRUE);

        }

        /*
        * Purpose: To Load content
        * Date: 08 Dec 2017
        * Input Parameter: None
        * Output Parameter: None
        */
	public function index()
	{
            if ($this->session->userdata('role'))
            {
                $data['contentMenuData'] = $this->cmsmenumodel->getData();
                $data['contentFooterMenuData'] = $this->cmsmenumodel->getData(0,'Footer');
                $data['contentOtherMenuData'] = $this->cmsmenumodel->getData(0,'Other');
                $data['parentMenu'] = $this->cmsmenumodel->getDropdownData();
                $data['title'] = "plus-ed.com | CMS pages";
                $data['breadcrumb1'] = 'Website management';
                $data['breadcrumb2'] = 'CMS pages';
                $data['pageHeader'] = "CMS pages";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/frontweb/cmsmenu',$data);
            }
            else
            {
                redirect('backoffice', 'refresh');
            }
	}

       public function getMenuHtml($mnuArr,$first = '',$last = '')
       {
       		// if($mnuArr['mnu_menu_name'] == 'Test'){
       	// echo "<pre>";print_r($mnuArr);die('pop = '.isset($mnuArr['child']));}
           ?>
                <li class="list-group-item level_<?php echo $mnuArr['mnu_level'];?> <?php echo $first;?>">
                    <?php echo $mnuArr['mnu_menu_name'];?>
                    <?php $delete = 0; if($mnuArr['mnu_parent_menu_id'] || !isset($mnuArr['child'])){ $delete = 1;?>
                    <div style="float: right; padding: 0 20px;">
                    <a class="delete_button pull-right" title="Delete" data-id="<?php echo $mnuArr['mnu_menuid'];?>" data-toggle="modal" role="button" id="dl_<?php echo $mnuArr['mnu_menuid'];?>" href="#myModal">
                        <i class="fa fa-times-circle-o fa-2x"></i>
                    </a>
                    </div>
                    <?php }?>
                    <div style="float: right; padding: 0 20px;">
                    <a class="pull-right editmenu" style="<?php echo ($delete == 1 ? 'margin-right:0px;' : 'margin-right:59px;' );?>" data-type="<?php echo $mnuArr['mnu_type'];?>" data-level="<?php echo $mnuArr['mnu_level'];?>" data-text="<?php echo $mnuArr['mnu_menu_name'];?>" data-mnuid="<?php echo $mnuArr['mnu_menuid'];?>" data-mnu_pid="<?php echo $mnuArr['mnu_parent_menu_id'];?>" title="Edit Menu" href="javascript:void(0);">
                        <i class="fa fa-pencil-square-o fa-2x"></i>
                    </a>
                    </div>
                    <div style="float: right; padding: 0 20px;">
                    <a data-id="<?php echo $mnuArr['mnu_menuid'];?>" style="margin-right:0px;" title="Change Status"  data-status="<?php echo $mnuArr['mnu_status'];?>" class="status pull-right" id="st_<?php echo $mnuArr['mnu_menuid'];?>" data-toggle="modal" role="button" href="#myStatus">
                        <i class="<?php echo ($mnuArr['mnu_status'] == '1' ? 'fa fa-check fa-2x' : 'fa fa-2x fa-ban');?>"></i>
                    </a>
                    </div>
                    <div style="float: right; padding: 0 20px;">
                        <a data-id="<?php echo $mnuArr['mnu_menuid'];?>" style="margin-right:0px;" title="Add/edit content" class="contentpage pull-right" id="cn_<?php echo $mnuArr['mnu_menuid'];?>" href="<?php if(!array_key_exists('child', $mnuArr)){ echo base_url().'index.php/frontweb/cmsmenu/content/'.$mnuArr['mnu_menuid'];}else {echo "javascript:void(0);";}?>">
                            <i class="fa fa-file-text<?php if(array_key_exists('child', $mnuArr)){ echo '-o';}?> fa-2x"></i>
                        </a>
                    </div>
                    <div style="float: right; padding: 0 20px;">
                        <div style="float: left; width: 25px;">
                            <a data-id="<?php echo $mnuArr['mnu_menuid'];?>" style="margin-right:0px;" title="Move up" class="moveup pull-right" id="mp_<?php echo $mnuArr['mnu_menuid'];?>" href="<?php echo base_url().'index.php/frontweb/cmsmenu/change_sequence/up/'.$mnuArr['mnu_menuid'];?>">
                                <i class="fa  fa-arrow-circle-up fa-2x"></i>
                            </a>
                        </div>
                        <div style="float: right; width: 25px;">
                            <a data-id="<?php echo $mnuArr['mnu_menuid'];?>" style="margin-right:0px;" title="Move down" class="movedown pull-right" id="mp_<?php echo $mnuArr['mnu_menuid'];?>" href="<?php echo base_url().'index.php/frontweb/cmsmenu/change_sequence/down/'.$mnuArr['mnu_menuid'];?>">
                                <i class="fa  fa-arrow-circle-down fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </li>

           <?php
           if(array_key_exists('child', $mnuArr))
           {
                //echo "<ul>";
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
               // echo "</ul>";
           }

           //$this->getMenuHtml($mnu['mnu_menu_name'],$mnu['child']);
       }

       public function addDash($no_of_dash = 0)
       {
           $str = "";
           for($i=1;$i<$no_of_dash;$i++){
               $str .= "--";
           }
           return $str;
       }
       public function getSelectOption($mnu_row)
       {
           ?>
           <option value="<?php echo $mnu_row['mnu_menuid'];?>"><?php echo $this->addDash($mnu_row['mnu_level']).$mnu_row['mnu_menu_name'];?></option>
           <?php
           if(array_key_exists('child', $mnu_row))
           {
                foreach ($mnu_row['child'] as $mnu) {
                    $this->getSelectOption($mnu);
                }
           }

       }

       private $allChildStr = "";
       public function getAllChildId()
       {
           $mnu_id = $this->input->post('mnu_id');
           $this->allChildStr = "";
           $allChild = $this->cmsmenumodel->getData($mnu_id);
           $resultData = $this->getChildId($allChild);
           $returnArr = explode('-', $this->allChildStr);
           echo json_encode($returnArr);
       }

       public function getChildId($allChild)
       {
           foreach($allChild as $mnu){
               $mnu_id = $mnu['mnu_menuid'];
               $this->allChildStr .= $mnu_id.'-';
               if(is_array($mnu))
               if(array_key_exists('child', $mnu))
                {
                    $this->getChildId($mnu['child']);
                }
           }
       }

       public function addmenu()
       {
           if ($this->session->userdata('role'))
            {
               // get menu level if parent set else it is default 1
               $mnu_level = 1;
               $mnu_parent_id = mysql_real_escape_string($this->input->post('selParentMenu'));
               if(!empty($mnu_parent_id)){

                   $mnu_level = $this->cmsmenumodel->getMenuLevel($mnu_parent_id);
               }
               $result = 0;
               $edit_id = $this->input->post('edit_id');
               $my_current_level = $this->input->post('my_current_level');
               $all_child_ids = $this->input->post('all_child_ids');

                if($edit_id){
                    $update_data = array(
                        'mnu_parent_menu_id'=> $mnu_parent_id,
                        'mnu_menu_name'=> mysql_real_escape_string($this->input->post('txtMenuTitle')),
                        'mnu_is_content'=> 1,
                        'mnu_status'=> 1,
                        'mnu_level'=> $mnu_level,
                        'mnu_type'=> mysql_real_escape_string($this->input->post('selMenuType')),
                        'mnu_modified_on'=> date('Y-m-d H:i:s'),
                        'mnu_modified_by'=> $this->session->userdata('user_id'),
                        'is_deleted'=> 0,
                    );
                    $diff_in_level = 0;

                    $result = $this->cmsmenumodel->action('update',$update_data,$edit_id);

                    if($result){
                        if($my_current_level != $mnu_level){
                            $diff_in_level = $mnu_level - $my_current_level;
                        }
                        if($diff_in_level != 0){
                            if(strlen($all_child_ids)){
                                $all_child_ids = trim($all_child_ids, ",");
                                $this->cmsmenumodel->update_level($diff_in_level,$all_child_ids);
                            }

                        }
                    }
                }
                else{
                    $mnu_type = mysql_real_escape_string($this->input->post('selMenuType'));
                    $sequence = $this->cmsmenumodel->getNewSequence($mnu_parent_id,$mnu_type);
                    $insert_data = array(
                        'mnu_parent_menu_id'=> $mnu_parent_id,
                        'mnu_menu_name'=> mysql_real_escape_string($this->input->post('txtMenuTitle')),
                        'mnu_is_content'=> 1,
                        'mnu_status'=> 1,
                        'mnu_level'=> $mnu_level,
                        'mnu_type'=> $mnu_type,
                        'mnu_sequence'=> $sequence,
                        'mnu_created_on'=> date('Y-m-d H:i:s'),
                        'mnu_created_by'=> $this->session->userdata('user_id'),
                        'is_deleted'=> 0,
                    );
                    $result = $this->cmsmenumodel->action('insert',$insert_data);
                }

                if($result){
                    if($edit_id)
                        $this->session->set_userdata('toast_message','Record updated successfully');
                    else
                        $this->session->set_userdata('toast_message','Record added successfully');
                    redirect('frontweb/cmsmenu');
                }
                else
                    redirect('frontweb/cmsmenu', 'refresh');
            }
            else
            {
                redirect('backoffice', 'refresh');
            }
       }


        public function change_sequence($move='up',$mnu_id = 0)
        {
            $this->cmsmenumodel->change_sequence($mnu_id,$move);
            redirect('frontweb/cmsmenu');
        }
        public function delete_mnu()
        {
            $mnu_id = $this->input->post('mnu_id');
            $update_array = array(
                'is_deleted'=>1
            );
            $this->cmsmenumodel->action('update',$update_array,$mnu_id);
            $this->session->set_userdata('toast_message','Record deleted successfully');
            echo 1;
        }


        public function update_mnu_status()
        {
                $mnu_menuid = $this->input->post('mnu_id');
                $changeStatus = $this->input->post('ele_status');
                $ele_all_child = $this->input->post('ele_all_child');
                if($changeStatus)
                    $changeStatus = 0;
                else
                    $changeStatus = 1;
                $update_array = array(
                    'mnu_status'=>$changeStatus
                );
                $ele_all_child = trim($ele_all_child,',');
                if(strlen($ele_all_child) > 0)
                {
                    $ele_all_child = $ele_all_child.','.$mnu_menuid;
                }else
                    $ele_all_child = $mnu_menuid;
                $this->cmsmenumodel->update_menu_status($update_array,$ele_all_child);
                $this->session->set_userdata('toast_message','Status updated successfully');
                echo 1;
        }


        // CONTENT CMS PAGES
        public function content($edit_menu_id = 0)
	{
            if ($this->session->userdata('username'))
            {
                $data = array();
                if(!empty($_POST)){
                    $contentType = $this->input->post('content_radio');
                    $menuType = $this->input->post("hidd_menu_type");
                    $edit_menu_id = $this->input->post('hidd_edit_menu_id');
                    $validationRules = array(
                        array(
                            'field' => 'en_txtbrowsertitle',
                            'label' => 'Browser Title',
                            'rules' => 'required'
                        ),
                        array(
                                'field' => 'en_txtpagetitle',
                                'label' => 'Page Title',
                                'rules' => 'required'
                        ),
                        array(
                                'field' => 'en_txtpageurl',
                                'label' => 'Page URL',
                                'rules' => 'required'
                        ),
                        array(
                                'field' => 'en_txtContent',
                                'label' => 'Content',
                                'rules' => 'required'
                        )
                    );
                    if($contentType == "Url")
                    {
                        $validationRules = array(
                            array(
                                'field' => 'txtwebpageurl',
                                'label' => 'Web page url',
                                'rules' => 'required'
                            )
                        );
                    }

                    if($menuType == "Other")
                    {
                        $validationRules = array(
                            array(
                                'field' => 'en_txtContent',
                                'label' => 'Content',
                                'rules' => 'required'
                            )
                        );
                    }
                    $this->form_validation->set_rules($validationRules);
                    if($this->form_validation->run() || $contentType == 'pdf')
                    {
                        $link = str_replace(" ","-",$this->input->post('en_txtpageurl'));
                        $insert_data = array();
                        $pdf_file = "";
                        switch ($contentType){
                            case 'content':
                                $insert_data = array(
                                    'cont_menuid' => $edit_menu_id,
                                    'cont_browser_title' => $this->input->post('en_txtbrowsertitle'),
                                    'cont_page_title' => $this->input->post('en_txtpagetitle'),
                                    'cont_url_name' => seoUrl($link),
                                    'cont_meta_description' => $this->input->post('en_txtmetadescription'),
                                    'cont_keywords' => $this->input->post('en_txtkeywords'),
                                    'cont_content' => $this->input->post('en_txtContent'),
                                    'cont_content_type'=>1,
                                    'cont_created_on' => date('Y-m-d H:i:s'),
                                    'cont_created_by' => $this->session->userdata('user_id'),
                                    'cont_modified_on' => date('Y-m-d H:i:s'),
                                    'cont_modified_by' => $this->session->userdata('user_id')
                                );
                                break;
                            case 'pdf':
                                if(!empty($_FILES['pdffile']['name']))
                                {
                                    $upload_data = $this->upload_pdf();
                                    $pdf_file = $upload_data['file_name'];
                                    $insert_data = array(
                                        'cont_menuid' => $edit_menu_id,
                                        'cont_pdf_file' => $pdf_file,
                                        'cont_content_type'=>2
                                    );
                                }
                                else
                                {
                                    $insert_data = array(
                                        'cont_menuid' => $edit_menu_id,
                                        'cont_content_type'=>2
                                    );
                                }

                                break;
                            case 'url':
                                $insert_data = array(
                                    'cont_menuid' => $edit_menu_id,
                                    'cont_content_type'=>3,
                                    'cont_external_url' => $this->input->post('txtwebpageurl')
                                );
                                break;
                        }
                        if(!empty($insert_data))
                            $result = $this->cmsmenumodel->action('insert_update_content',$insert_data);
                        $this->session->set_userdata('toast_message','Record updated successfully');
                        redirect('frontweb/cmsmenu','refresh');
                    }
                    else
                    {
                        //$data['record'] = $this->cmsmenumodel->fetch_content_master($menu_id);
                        $data['edit_menu_id'] = $edit_menu_id;
                        $data['content'] = $this->cmsmenumodel->getContentData($edit_menu_id);

                        $data['title'] = "plus-ed.com | CMS pages";
                        $data['breadcrumb1'] = 'Website management';
                        $data['breadcrumb2'] = 'Add/edit content';
                        $data['pageHeader'] = "CMS pages";
                        $data['optionalDescription'] = "";
                        $this->ltelayout->view('lte/frontweb/content',$data);
                    }
                }
                else
                {
                    $data['edit_menu_id'] = $edit_menu_id;
                    $data['content'] = $this->cmsmenumodel->getContentData($edit_menu_id);
                    $data['title'] = "plus-ed.com | CMS pages";
                    $data['breadcrumb1'] = 'Website management';
                    $data['breadcrumb2'] = 'Add/edit content';
                    $data['pageHeader'] = "CMS pages";
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/frontweb/content',$data);
                }
            }
            else
            {
                    redirect('dashboard', 'refresh');
            }
        }

        public function upload_pdf()
	{
            if (!file_exists(CAMPUS_CONTENT_PDF_FILE)) {
                mkdir(CAMPUS_CONTENT_PDF_FILE, 0700,true);
            }
            $file_name = $_FILES['pdffile']['name'];

			//Updated on 28th February , 2018
			$extension = pathinfo($file_name , PATHINFO_EXTENSION);
			$file_name = basename($file_name , '.'.$extension);
			$file_name = preg_replace('/[^a-zA-Z0-9_]/s' , '' , $file_name);
			$file_name = time()."_".$file_name;
			$file_name = $file_name.'.'.$extension;

		$config =  array(
                        'upload_path'     => CAMPUS_CONTENT_PDF_FILE,
                        'allowed_types'   => "pdf",
                        'overwrite'       => FALSE,
                        'file_name'	    => $file_name
                    );
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload('pdffile'))
                    {
                            $upload_data = $this->upload->data();
                            $data = array('file_name' => $file_name);
                        return $data;
                    }
                    else
                    {
                        $error = array('error' => $this->upload->display_errors());
                        return $error;
                    }
	}

        public function check_url_exists($id = FALSE)
        {
                if($id === FALSE)
                {
                        $link = $this->input->post('link');
                        if($link!='')
                        {
                                $url_exists = $this->cmsmenumodel->check_url_exists($link);
                                if($url_exists && (strcmp($url_exists,$link)!=0))
                                        echo json_encode(TRUE);
                                else
                                        echo json_encode(FALSE);
                        }
                        else
                                echo json_encode(TRUE);
                }
                else
                {
                        $link = $this->input->post('link');
                        if($link!='')
                        {
                                $url_exists = $this->cmsmenumodel->check_url_exists($link,$id);
                                if($url_exists && (strcmp($url_exists,$link)!=0))
                                        echo json_encode(TRUE);
                                else
                                        echo json_encode(FALSE);
                        }
                        else
                                echo json_encode(TRUE);
                }
        }
        // END OF CMS PAGES\

		//This function is used to get the details of parent menu dropdown as per menu type through ajax call
		function getParentMenuDropdown()
		{
			if($this->input->post('menuType'))
			{
				$dropdownArr = $this->cmsmenumodel->getDropdownData(0 , $this->input->post('menuType'));
				$str = '<option value="0">Select parent menu</option>';
				if(!empty($dropdownArr))
				{
					foreach($dropdownArr as $value)
						$str.= $this->getDynamicOption($value);
				}
				echo json_encode(array('optionStr' => $str));
			}
		}

		//Function is used to get the dynamic dropdown options for parent menu dropdown
		function getDynamicOption($data = array() , $optionStr = '')
		{
			$optionStr.= '<option value="'.$data['mnu_menuid'].'">'.$this->addDash($data['mnu_level']).$data['mnu_menu_name'].'</option>';
			if(array_key_exists('child' , $data))
			{
				foreach($data['child'] as $childValue)
					$optionStr = $this->getDynamicOption($childValue , $optionStr);
			}
			return $optionStr;
		}

}
?>