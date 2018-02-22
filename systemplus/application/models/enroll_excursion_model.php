<?php
class Enroll_excursion_model extends Model {
    
    
    function listAllExcursions($campus, $tipo, $to, $from) {
        $data = array();
        if ($campus) {
            $fromarray = explode("/", $from);
            $toarray = explode("/", $to);
            $frommysql = $fromarray[2] . "-" . $fromarray[1] . "-" . $fromarray[0];
            $tomysql = $toarray[2] . "-" . $toarray[1] . "-" . $toarray[0];
            /*$queryt = "SELECT 'noyear' as id_year, enroll_id, exb_id, exc_excursion, businessname, 
                businesscountry, nome_centri, exb_tot_pax, exc_weeks, 
                book.status as statopre, 
                enrol_arrival_date, enrol_departure_date, exc_id, 
                exc_length 
                FROM 
                    agnt_pack_exc_bookings, 
                    plused_exc_all, 
                    agnt_enrol_bookings book, 
                    agenti, 
                    centri 
                WHERE 
                    (book.status = '".BookingStatus::$CONFIRMED."' 
                     OR book.status = '".BookingStatus::$ACTIVE."') 
                    AND exc_id = exb_id_excursion 
                    and centri.id = exb_campus_id 
                    and agenti.id = enrol_agent_id 
                    and exb_id_book = enroll_id 
                    and exc_type = '" . $tipo . "' 
                    and centri.id = $campus 
                    AND exb_confirmed = 'NO' 
                    AND (book.enrol_arrival_date <= '$tomysql' 
                    AND book.enrol_departure_date >= '$frommysql') 
                    ORDER BY exb_id_excursion, exc_weeks, enrol_arrival_date, enrol_departure_date";
            $Q = $this->db->query($queryt);
            echo $this->db->last_query();
            */
            
            $this->db->from("agnt_pack_exc_bookings pack_exc");
            $this->db->join("agnt_enrol_bookings book","enroll_id = exb_id_book");
            $this->db->join("agenti","enrol_agent_id = agenti.id","left");
            $this->db->join("centri","exb_campus_id = centri.id","left");
            $this->db->join("agnt_excursions","exb_id_excursion = exc_id","left");
            
            $this->db->select("YEAR(enrol_created_on) as id_year, enroll_id, exb_id, exc_excursion_name, businessname, 
                businesscountry, nome_centri, exb_tot_pax, exc_weeks, 
                book.status as statopre, 
                enrol_arrival_date, enrol_departure_date, exc_id",FALSE);
            $this->db->where('exc_type',$tipo);
            $this->db->where("(book.status = '".BookingStatus::$CONFIRMED."' 
                     OR book.status = '".BookingStatus::$ACTIVE."')");
            $this->db->where("(book.enrol_arrival_date <= '$tomysql' 
                    AND book.enrol_departure_date >= '$frommysql')");
            $Q = $this->db->get();
            //echo $this->db->last_query();die;
            if ($Q->num_rows() > 0) {
                foreach ($Q->result_array() as $row) {
                    $data[] = $row;
                }
            }
            $Q->free_result();
            //print_r($data);
            return $data;
        } else {
            return false;
        }
    }
}
