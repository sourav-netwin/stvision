<?php

/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 24-Mar-2016
 * @Modified    : 
 * @Description : Users model used to authenticate teachers and other staffs.
 */
Class Usersmodel extends Model {

    var $table_name = "plused_teacher_application";
    
    function __construct() {
        parent::__construct();
    }

    /**
     * verifyUser
     * this function is uses to verify teachers application user to authenticate for personal login.
     * @param string $email
     * @param string $password
     * @return int|mixed row 
     */
    public function verifyUser($email,$password){
        $this->db->where('ta_email',$email);
        $this->db->where('ta_password',md5($password));
        $this->db->where('ta_is_deleted',0);
        $this->db->limit(1);
        $result = $this->db->get($this->table_name);
        if($result->num_rows())
        {
            return $result->row();
        }
        else
            return 0;
    }
    
    /**
     * getUsersForMatch
     * this function can be use to select user record using matched crieteria
     * @param array $matchedArr
     * @return int|mixed row 
     */
    public function getUsersForMatch($matchedArr = array()){
        if(is_array($matchedArr)){
            if(!empty($matchedArr)){
                $this->db->where($matchedArr);
                $this->db->where('ta_is_deleted',0);
                $this->db->limit(1);
                $result = $this->db->get($this->table_name);
                if($result->num_rows())
                {
                    return $result->row();
                }
            }
        }
        return 0;
    }
    
    /**
     * savebankdetails
     * this is check bank details available or not for user give
     * and update record if bank details found else insert new 
     * record to database.
     * @param array $updateArray
     * @param int $teacher_app_id
     * @return int 
     */
    public function savebankdetails($updateArray = array(),$teacher_app_id = 0)
    {
        if($teacher_app_id){
            $bankDetailsId = 0;
            $this->db->where('tbd_user_id',$teacher_app_id);
            $this->db->limit(1);
            $result = $this->db->get('pulsed_teachers_bank_detail');
            if($result->num_rows()){
                $bankDetailsId = $result->row()->tbd_id;
            }
            $this->db->flush_cache();
            if(!$bankDetailsId)
            {
                $this->db->insert('pulsed_teachers_bank_detail',$updateArray);
                return 1;
            }
            else{
                $this->db->where('tbd_id',$bankDetailsId);
                $this->db->update('pulsed_teachers_bank_detail',$updateArray);
                return 1;
            }

        }
        return 0;
    }
   
}

//End login model
?>