<?php

/**
 * @Programmer  : Arunsankar
 * @Maintainer  : Arunsankar
 * @Created     : 06-Jul-2017
 * @Modified    : 
 * @Description : Settings model for backoffice operator
 */
class Settings_model extends Model {

    function Settings_model() {
        parent::Model();
    }

    /*
     * function for fetching data for all campus managers
     */

    public function getUsers($search, $param, $role) {
        $this->db->select('nome_centri,members.id,members.email,first_name, last_name');
        $this->db->from('members');
        $this->db->join('centri', 'centri.id=members.campusid_ref');
        $this->db->where('role', $role);
        if (!empty($search)) {
            $this->setSearchParams($search);
        }
        $this->db->limit($param['offset'], $param['start']);
        $this->db->order_by($param['column'], $param['type']);
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->result_array() : array();
    }

    public function getUsersCount($search, $role) {
        $this->db->from('members');
        $this->db->join('centri', 'centri.id=members.campusid_ref', 'left');
        $this->db->where('role', $role);
        if (!empty($search)) {
            $this->setSearchParams($search);
        }
        return $this->db->count_all_results();
    }

    /*
     * function for checking users email wheather exists or not.
     */

    public function isEmailExists($email) {
        $this->db->from('members');
        $this->db->where('email', $email);
        return $this->db->count_all_results();
    }

    public function update($table, $data, $where) {
        return $this->db->update($table, $data, $where);
    }

    public function getUser($id) {
        $this->db->select('first_name,last_name,email');
        $this->db->from('members');
        $this->db->where('id', $id);
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->row_array() : array();
    }

    function setSearchParams($search) {
        return $this->db->where('(first_name LIKE "%' . mysql_real_escape_string($search) . '%" OR '
                        . 'last_name LIKE "%' . mysql_real_escape_string($search) . '%" OR '
                        . 'email LIKE "%' . mysql_real_escape_string($search) . '%" OR '
                        . 'nome_centri LIKE "%' . mysql_real_escape_string($search) . '%")');
    }

}
