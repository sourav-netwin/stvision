<?php

/**
 * Class for mapping of booking with packages model
 * @author Sandip
 * @since 02-Mar-2016
 */
class Mapbookmodel extends Model {

    function getBookingsByAgent($campusId = 0, $status = 'all', $sort = "id_book", $sorttype = "desc") {
        $data = array();
        $this->db->where('id_centro', $campusId);
        $this->db->where('YEAR(arrival_date)', 2017);
        if ($status != "all") {
            $this->db->where('status', $status);
        }
        //$this->db->order_by($sort, $sorttype);
        $this->db->select('plused_book.*,agnt_map_packbooking.*,agnt_packages.pack_package');
        $this->db->order_by('id_book', 'desc');
        $this->db->join('agnt_map_packbooking','plused_book.id_book = agnt_map_packbooking.pbmap_book_id','left');
        $this->db->join('agnt_packages','agnt_map_packbooking.pbmap_package_id = agnt_packages.pack_package_id','left');
        $Q = $this->db->get('plused_book');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $row['centro'] = $this->centerNameById($row["id_centro"]);
                $row['all_acco'] = $this->getBookAccomodations($row["id_book"]);
                $row['inv_invoice_file'] = $this->getLatestInvoice($row["id_book"]);
                $data[] = $row;
            }
        }
        $Q->free_result();
        
        return $data;
    }
    
    function getLatestInvoice($bookingId){
        $this->db->select('inv_invoice_file');
        $this->db->order_by('inv_invoice_id','desc');
        $this->db->limit(1);
        $this->db->where('inv_booking_id',$bookingId);
        $result = $this->db->get('agnt_booking_invoice');
        if($result->num_rows())
            return $result->row()->inv_invoice_file;
        else
            return '';
    }

    function getBookAccomodations($idb) {
        $sqlid = "SELECT tipo_pax, accomodation, COUNT(*) as contot FROM plused_rows where id_book = $idb GROUP BY tipo_pax, accomodation ORDER BY tipo_pax, accomodation";
        $query = $this->db->query($sqlid);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rowq) {
                $data[] = $rowq;
            }
            return $data;
        }
    }

    function centerNameById($idcentro) {
        $data = array();
        $this->db->where('id', $idcentro);
        $Q = $this->db->get('centri');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        if (isset($data[0]["nome_centri"]))
            return $data[0]["nome_centri"];
        else
            return " - ";
    }

    /**
     * getCampusList
     * This function returns list of campuses
     * @return array
     * @throws Exception 
     */
    public function getCampusList($attivi = 1) 
    {
        $result = null;
        $this->db->select('id,nome_centri,valuta_fattura,count(id_book) as bookings_count');
        $this->db->order_by('nome_centri');
        $this->db->group_by('id_centro');
        if ($attivi == 1) {
            $this->db->where('attivo', $attivi);
        }
        $this->db->where('YEAR(plused_book.arrival_date)', date("Y"));
        $this->db->join('plused_book','centri.id = plused_book.id_centro');
        $res = $this->db->get('centri');
        if ($res->num_rows()) {
            $result = $res->result_array();
        }
        $res->free_result();
        return $result;
    }
    
    public function addPackage($packageId,$bookId,$mapId = 0){
        if($mapId == 0)
        {
            if(is_array($bookId))
            {
                foreach ($bookId as $book_id){ // get single id
                    $this->db->flush_cache();
                    $this->db->where('pbmap_book_id',$book_id);
                    $result = $this->db->get('agnt_map_packbooking');
                    if($result->num_rows()){
                        $mapId = $result->row()->pbmap_id;
                        $this->addPackage($packageId, $book_id,$mapId);
                    }
                    else{
                        $this->addPackage($packageId, $book_id);
                    }
                }
            }
            else
            {
                $insertData= array(
                    'pbmap_package_id' => $packageId,
                    'pbmap_book_id' => $bookId
                );
                $this->db->insert("agnt_map_packbooking",$insertData);
            }
        }
        elseif(is_numeric($mapId)){
            $updateData= array(
                'pbmap_package_id' => $packageId,
                'pbmap_book_id' => $bookId
            );
            $this->db->where('pbmap_id',$mapId);
            $this->db->update("agnt_map_packbooking",$updateData);
        }
        return 1;
    }
    
    function getPackages($center, $user_id, $week = "") {
        $strWeek = "";
        if($week == 1){
            $strWeek = " AND (p.pack_week_1 = 1 OR p.pack_week_2 = 1 OR p.pack_week_3 = 1)";
        }
        elseif($week == 2){
            $strWeek = " AND (p.pack_week_2 = 1 OR p.pack_week_3 = 1)";
        }
        elseif($week == 3){
            $strWeek = " AND (p.pack_week_3 = 1)";
        }
        
        $sql = "SELECT *
                FROM
                (
                        SELECT p.pack_package_id, p.pack_package
                        FROM agnt_packages p
                        WHERE p.pack_campus_id = ? 
                        $strWeek 
                        AND p.pack_for_location = 0

                        UNION

                        SELECT p.pack_package_id, p.pack_package
                        FROM agnt_packages p
                        JOIN agnt_package_agents a ON a.pagnt_package_id = p.pack_package_id AND a.pagnt_agent_id = ?
                        WHERE p.pack_campus_id = ? 
                        $strWeek 
                        AND p.pack_for_location = 1
                ) a
                ORDER BY a.pack_package";
        $query = $this->db->query($sql, array($center, $user_id, $center));
        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }
    
    function getBookingsDetails( $enroll_id )
    {
        $this->db->select("a.*, map.*, p.*, c.nome_centri,c.valuta,c.valuta_fattura,c.school_name,c.id as centri_id, c.address, c.located_in, c.post_code,
                0 as  free_gl_count,
                (SELECT count( tipo_pax ) AS STD 
                FROM plused_rows 
                WHERE id_book = ".$enroll_id." 
                AND tipo_pax = 'STD') as students_count, 
                (SELECT count( tipo_pax ) AS STD 
                FROM plused_rows 
                WHERE id_book = ".$enroll_id." 
                AND tipo_pax = 'GL') as gl_count 
                ",FALSE);
        
        $this->db->from("plused_book a");
        $this->db->join("agnt_map_packbooking map","a.id_book = map.pbmap_book_id");
        $this->db->join("agnt_packages p","map.pbmap_package_id = p.pack_package_id");
        $this->db->join("centri c","a.id_centro = c.id");
        $this->db->where('id_book',$enroll_id);
        $this->db->limit(1);
        $query = $this->db->get();
        return ( $query->num_rows() > 0 ) ? $query->row_array() : array();
    }
    
    function getBookingComposition( $enroll_id )
    {
            $this->db->select("COUNT(rw.uuid) AS cnt, rw.tipo_pax,b.tot_pax,p.pack_free_gl_per_pax,p.pack_extra_gl_price, accM.accom_name, '' as courses_type, '' as act_activity_name, c.pcomp_week, c.pcomp_full_price, c.pcomp_price_a, c.pcomp_price_b, c.pcomp_price_c, cent.valuta ",false);
            $this->db->from("plused_rows rw");
            $this->db->join("plused_book b","rw.id_book = b.id_book");
            $this->db->join("agnt_map_packbooking map","b.id_book = map.pbmap_book_id");
            $this->db->join("agnt_packages p","map.pbmap_package_id = p.pack_package_id");

            $this->db->join("agnt_accommodation accM","rw.accomodation = accM.accom_name","left");
            $this->db->join("agnt_package_compositions c", "b.weeks = c.pcomp_week AND accM.accom_id = c.pcomp_accom_id AND pcomp_package_id = map.pbmap_package_id");
//		$this->db->join("agnt_accommodation a", "a.accom_id = c.pcomp_accom_id", "left");
//		$this->db->join("agnt_courses_type ct", "ct.courses_type_id = c.pcomp_course_type_id", "left");
//		$this->db->join("agnt_activities act", "act.act_id = c.pcomp_activity_id", "left");
            $this->db->join("centri cent", "p.pack_campus_id = cent.id");
            $this->db->where('b.id_book',$enroll_id);
            $this->db->group_by('c.pcomp_id, rw.tipo_pax');
            $this->db->order_by('rw.tipo_pax');
            $query = $this->db->get();
            return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }


    function getBookingAccomodation( $enroll_id )
    {
            $this->db->select("COUNT(rw.uuid) AS cnt, rw.tipo_pax,b.tot_pax, accM.accom_name, s.serv_cost, c.valuta, 0 AS free_gl", FALSE);
            $this->db->from("plused_rows rw");
            $this->db->join("agnt_accommodation accM","rw.accomodation = accM.accom_name","left");
            $this->db->join("plused_book b","rw.id_book = b.id_book");
            $this->db->join("agnt_map_packbooking map","b.id_book = map.pbmap_book_id");
            $this->db->join("agnt_packages p","map.pbmap_package_id = p.pack_package_id");

            $this->db->join("centri c", "b.id_centro = c.id");
            $this->db->join("agnt_package_services s", "s.serv_service_id = accM.accom_id AND s.serv_package_id = p.pack_package_id AND serv_service_type = 'Accommodation'");
            $this->db->where('b.id_book', $enroll_id);
            $this->db->group_by('accM.accom_name');
            $this->db->order_by('s.serv_cost');
            $query = $this->db->get();

            return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }
    
    function getFreeGLsIds($bookingId,$freeGL){
        $this->db->where('id_book',$bookingId);
        $this->db->where('tipo_pax','GL');
        $this->db->limit($freeGL);//$freeGL
        $this->db->select('id_prenotazione');
        $result = $this->db->get('plused_rows');
        if($result->num_rows())
        {
            $glStrIds = "";
            foreach($result->result_array() as $row)
            {
                $glStrIds = $glStrIds . "," . $row['id_prenotazione'];
            }
            return trim($glStrIds,",");
        }
        else
            return 0;
    }
    
    function getExtraNightCharges($enroll_id,$bookingWeeks,$freeGLsIds){
        $bookingDays = 0;
        if($bookingWeeks > 0)
            $bookingDays = $bookingWeeks * 7;
        //rw.uuid, rw.tipo_pax, accM.accom_name, s.serv_cost, s.serv_extra_night,rw.data_arrivo_campus,rw.data_partenza_campus
        //datediff(rw.data_partenza_campus,rw.data_arrivo_campus) as stay_days,
        //(datediff(rw.data_partenza_campus,rw.data_arrivo_campus) - ".$bookingDays.") as extra_night_days,
        //$this->db->select("sum((datediff(rw.data_partenza_campus,rw.data_arrivo_campus) - ".$bookingDays.") * s.serv_extra_night) as extra_night_charges", FALSE);
        //rw.tipo_pax = 'STD'
        $this->db->select("sum(IF((datediff(rw.data_partenza_campus, rw.data_arrivo_campus) - ".$bookingDays.") > 0 && rw.id_prenotazione not in (".$freeGLsIds."),(datediff(rw.data_partenza_campus, rw.data_arrivo_campus) - ".$bookingDays.") * s.serv_extra_night,0)) as extra_night_charges,
                        sum(IF((datediff(rw.data_partenza_campus, rw.data_arrivo_campus) - ".$bookingDays.") > 0 && rw.id_prenotazione not in (".$freeGLsIds."),(datediff(rw.data_partenza_campus, rw.data_arrivo_campus) - ".$bookingDays."),0)) as extra_night,
                        sum(IF(rw.tipo_pax = 'STD' , ((getWorkingday(rw.data_arrivo_campus,rw.data_partenza_campus,'work_days') - 1 - (".$bookingWeeks." * 5)) * sct.serv_extra_tuition) , 0)) as extra_tuition_charges,
                        sum(IF(rw.tipo_pax = 'STD' , ((getWorkingday(rw.data_arrivo_campus,rw.data_partenza_campus,'work_days') - 1 - (".$bookingWeeks." * 5))) , 0)) as extra_tuition_day,
                        s.serv_extra_night as per_extra_night,
                        sct.serv_extra_tuition as per_extra_tuition_day
                            
        ", FALSE);
        /*
         * IF TUITION CHARGES IS FOR GL & STD
         * sum(((datediff(rw.data_partenza_campus, rw.data_arrivo_campus) - (".$bookingWeeks." * 5)) - (".$bookingWeeks." * 2)) * pack_extra_tuition_price) as extra_tuition_charges
         *  FOR STD:
         * sum(IF(rw.tipo_pax = 'STD' , (((datediff(rw.data_partenza_campus, rw.data_arrivo_campus) - (".$bookingWeeks." * 5)) - (".$bookingWeeks." * 2)) * pack_extra_tuition_price) , 0)) as extra_tuition_charges
         */
        $this->db->from("plused_rows rw");
        $this->db->join("agnt_accommodation accM","rw.accomodation = accM.accom_name","left");
        $this->db->join("plused_book b","rw.id_book = b.id_book");
        $this->db->join("agnt_map_packbooking map","b.id_book = map.pbmap_book_id");
        $this->db->join("agnt_packages p","map.pbmap_package_id = p.pack_package_id");

        $this->db->join("centri c", "b.id_centro = c.id");
        $this->db->join("agnt_package_services s", "s.serv_service_id = accM.accom_id AND s.serv_package_id = p.pack_package_id AND s.serv_service_type = 'Accommodation'","",FALSE);
        $this->db->join("agnt_package_services sct", "sct.serv_package_id = p.pack_package_id AND sct.serv_service_type = 'Course Type'","LEFT",FALSE);
        $this->db->where('b.id_book', $enroll_id);
        //$this->db->group_by('rw.uuid');// THIS IS B'COS WE SHOULD HAVE ONLY ONE TYPE OF COURSE TYPE
        $this->db->order_by('s.serv_cost');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if($query->num_rows()){
            return array(
                "extra_night_charges" => $query->row()->extra_night_charges,
                "extra_night" => $query->row()->extra_night,
                "extra_tuition_charges" => ($query->row()->extra_tuition_charges > 0 ? $query->row()->extra_tuition_charges : 0),
                "extra_tuition_day" => ($query->row()->extra_tuition_day > 0 ? $query->row()->extra_tuition_day : 0),
                "per_extra_night" => ($query->row()->per_extra_night > 0 ? $query->row()->per_extra_night : 0),
                "per_extra_tuition_day" => ($query->row()->per_extra_tuition_day > 0 ? $query->row()->per_extra_tuition_day : 0)
            );
        }
        return array(
            "extra_night_charges" => 0,
            "extra_night" => 0,
            "extra_tuition_charges" => 0,
            "extra_tuition_day" => 0,
            "per_extra_night" => 0,
            "per_extra_tuition_day" => 0
        );
    }
    
    function getBookingDiscount($enrollId){
        $this->db->select("sum(pfp_importo) as discountAdded");
        $this->db->where("pfp_bk_id",$enrollId);
        $this->db->where("pfp_tipo_servizio","Invoice Discount");
        $result = $this->db->get('plused_fincon_payments');
        if($result->num_rows())
        {
            return $result->row()->discountAdded;
        }
        return 0;            
    }
    
    
    
    /**
     * This function is written to create excursions entries
     * in new table 'agnt_pack_exc_bookings' 
     * this new table will be used to book buses and coaches later.
     */
    function moveConfirmedExcursion()
    {
        $numRowsCreated = 0;
        $this->db->from('agnt_enrol_bookings');
        $this->db->where('status', BookingStatus::$CONFIRMED);
        $this->db->where("enroll_id NOT IN (SELECT DISTINCT exb_id_book FROM agnt_pack_exc_bookings)",NULL, FALSE);
        $this->db->select("exc_id,exc_excursion_name,exc_type,exc_days,exc_weeks,exc_airport,
            enroll_id,enrol_campus_id,enrol_agent_id,enrol_package_id,enrol_booked_students,
            enrol_booked_gl,enrol_number_of_week,enrol_arrival_date,
            enrol_departure_date,status");
        $this->db->join("agnt_package_services","enrol_package_id = serv_package_id AND serv_service_type = 'Excursion'");
        $this->db->join('agnt_excursions','serv_service_id = exc_id');
        $bookedExcursions = $this->db->get();
        if($bookedExcursions->num_rows()){
            foreach($bookedExcursions->result_array() as $excursion){
                $insertArr = array(
                    'exb_id_book' => $excursion['enroll_id'],
                    'exb_id_excursion' => $excursion['exc_id'],
                    'exb_campus_id' => $excursion['enrol_campus_id'],
                    'exb_tot_pax' => $excursion['enrol_booked_students'] + $excursion['enrol_booked_gl'],
                    'exb_type' => $excursion['exc_type']
                );
                $this->db->insert('agnt_pack_exc_bookings',$insertArr);
                $numRowsCreated++;
            }
        }
        return $numRowsCreated;
    }

}

/*End of file rolemanagementmodel.php*/