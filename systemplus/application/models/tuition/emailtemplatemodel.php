<?php
Class EmailTemplateModel extends Model {
    
    function __construct()
    {
         parent::__construct();         
    }

    function getData($edit_id = 0) {
        
        //--- SELECT FIELDS FROM CHEF TABLE ---//
        $this->db->select('*',FALSE);
        if($edit_id) $this->db->where('emt_id',$edit_id);
        
        $this->db->where(array('emt_delete' => 0,'emt_active' => 1)); // ,'emt_active' => 1
        $this->db->order_by("emt_id","DESC");
        $result = $this->db->get('agnt_email_template');
        if($result->num_rows()){
            return $result->result_array();
        }
        else
            return 0;
    }//End index function
    
   public function action($action,$arrData = array(),$edit_id =0)
    {
        switch($action){
            case 'insert':
                $this->db->insert('agnt_email_template',$arrData);
                return $this->db->insert_id();
                break;
            case 'update':
                $this->db->where('emt_id',$edit_id);
                $this->db->update('agnt_email_template',$arrData);
                return $edit_id;
                break;
            case 'delete':
                break;
        }
    }
    
    
    public function getOpenCloseTime($iUserID = 0)
    {
        $this->db->select('*',FALSE);
        //$this->db->from('open_close_time');
        $this->db->where('emt_id',$iUserID);
        $result = $this->db->get();
        
        if($result->num_rows()){
           return $result->result_array();
        }else return 0;
    }
    
    public function UpdateDetail($iUserID = 0,$aPostData)
    {
        //--- UDPATE USER TABLE ---//
        $this->db->where('emt_id', $iUserID);
        $this->db->update('agnt_email_template', $aPostData);         
         #print_r($aOpenDaysID);exit;
        $this->session->set_userdata('toast_message','Record updated successfully');
        return true;
    }
    
    
    public function AddDetail($aPostData)
    {
        $sTableName = "agnt_email_template";       
        $aPostData['emt_active'] = 1;
        
        //---- INSERT USER IN DATABASE ----//
        $this->db->insert($sTableName, $aPostData); 

        //---- RETURN LAST INSERT ID ----//
        $iLastInsertID = $this->db->insert_id();

        //---- LAST INSERT ID ----//
        if($iLastInsertID > 0){
            return true;
        }//End last insert id if condition            
        return false;
    }
}
