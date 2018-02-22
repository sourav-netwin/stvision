<?php

class Backofficeajax_model extends Model {

    function Backofficeajax_model() {
        parent::Model();
    }

    public function updateWeek($week, $bookingId) {
        $this->db->where('id_book', $bookingId);
        return $this->db->update('plused_book', array('weeks' => $week));
    }

    public function weekAvailableInPackage($week, $bookingId) {
        $this->db->select('agnt_packages.pack_week_' . $week);
        $this->db->from('agnt_packages');
        $this->db->join('agnt_map_packbooking', 'agnt_map_packbooking.pbmap_package_id=agnt_packages.pack_package_id', 'left');
        $this->db->where('agnt_map_packbooking.pbmap_book_id', $bookingId);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            $resultArr = $result->result_array();
            $weekIsPresent = $resultArr[0]['pack_week_' . $week];
            if($weekIsPresent == 1)
                return 1;
            else
                return 0;
        }
        else{
            return 1;
        }
    }

}

?>
