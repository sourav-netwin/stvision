<?php

/*
 * this class(model) handles summary operations from database.
 */

class Booking_invoice extends Model {

    function Booking_invoice() {
        parent::Model();
    }

    /*
     * this function begins the query for summary
     */

    private function beginQuery() {
        $this->sql = 'SELECT sum(inv_total_cost) as total_cost,id,businessname,email,businesstelephone,'
                . 'IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where find_in_set(plused_fincon_payments.pfp_bk_id,GROUP_CONCAT(derived_booking_invoice.inv_booking_id)) AND plused_fincon_payments.pfp_dare_avere ="avere" ),0) as pfp_import,'
                . 'ROUND((sum(inv_total_cost) - IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where find_in_set(plused_fincon_payments.pfp_bk_id,GROUP_CONCAT(derived_booking_invoice.inv_booking_id)) AND plused_fincon_payments.pfp_dare_avere ="avere" ),0)), 2) as overdue '
                . 'FROM (SELECT t.* FROM agnt_booking_invoice t INNER JOIN (SELECT inv_total_cost,MAX(inv_invoice_id) AS latest,inv_booking_id FROM agnt_booking_invoice GROUP BY inv_booking_id) t1 ON t1.inv_booking_id=t.inv_booking_id AND t1.latest=t.inv_invoice_id) AS derived_booking_invoice '
                . 'LEFT JOIN agenti ON agenti.id=derived_booking_invoice.inv_agent_id WHERE agenti.status="active" ';
    }

    /*
     * this function adds condition for agents and campuses for summary, total and export
     */

    private function addConditionToQuery($sqlPart) {
        if (empty($sqlPart)) {
            return;
        }
        $this->sql .= $sqlPart;
    }

    /*
     * this function adds the group by clause for summary, total and export
     */

    private function groupBy() {
        $this->sql .= 'GROUP BY inv_agent_id ';
    }

    /*
     * this function adds the sorts the column clause for summary, total and export
     */

    private function orderBy($param) {
        if (isset($param['column']) && isset($param['type'])) {
            $this->sql .= 'ORDER BY ' . $param['column'] . ' ' . $param['type'] . ' ';
        }
    }

    /*
     * this function adds the limit clause for summary, total and export
     */

    private function take($param) {
        if (isset($param['start']) && isset($param['offset'])) {
            $this->sql .= 'LIMIT ' . $param['start'] . ', ' . $param['offset'];
        }
    }

    /*
     * this function executes the query for summary, total and export
     */

    private function execute() {
        $query = $this->db->query($this->sql);
        return $query->result();
    }

    /*
     * this function returns the data for summary, total and export
     */

    public function getSummaryData($sqlPart, $param = array()) {
        $this->beginQuery();
        $this->addConditionToQuery($sqlPart);
        $this->groupBy();
        $this->orderBy($param);
        $this->take($param);
        return $this->execute();
    }

    /*
     * this function adds returns the count for summary for pagination
     */

    public function getSummaryCount($sqlPart) {
        $query = 'SELECT count(DISTINCT(inv_agent_id)) AS count
                   FROM (SELECT t.* FROM agnt_booking_invoice t INNER JOIN (SELECT inv_total_cost,MAX(inv_invoice_id) AS latest,inv_booking_id FROM agnt_booking_invoice GROUP BY inv_booking_id) t1 ON t1.inv_booking_id=t.inv_booking_id AND t1.latest=t.inv_invoice_id
                   ) AS derived_booking_invoice  
                   LEFT JOIN agenti ON agenti.id=derived_booking_invoice.inv_agent_id 
                   WHERE 1=1 AND agenti.status = "active" '
                . $sqlPart;
        $query = $this->db->query($query);
        return $query->row();
    }

    public function getDefaultTotals($sqlPart = '') {
        $query = 'SELECT sum(inv_total_cost) as total_cost,id,businessname,email,businesstelephone,
                    IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where find_in_set(plused_fincon_payments.pfp_bk_id,GROUP_CONCAT(derived_booking_invoice.inv_booking_id)) AND plused_fincon_payments.pfp_dare_avere ="avere" ),0) as pfp_import,
                    (sum(inv_total_cost) - IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where find_in_set(plused_fincon_payments.pfp_bk_id,GROUP_CONCAT(derived_booking_invoice.inv_booking_id)) AND plused_fincon_payments.pfp_dare_avere ="avere" ),0)) as overdue
                   FROM (SELECT t.* FROM agnt_booking_invoice t INNER JOIN (SELECT inv_total_cost,MAX(inv_invoice_id) AS latest,inv_booking_id FROM agnt_booking_invoice GROUP BY inv_booking_id) t1 ON t1.inv_booking_id=t.inv_booking_id AND t1.latest=t.inv_invoice_id
                   ) AS derived_booking_invoice 
                   LEFT JOIN agenti ON agenti.id=derived_booking_invoice.inv_agent_id 
                   WHERE 1=1 ';
        if (!empty($sqlPart)) {
            $query .= $sqlPart;
        }
        $query .= 'GROUP BY inv_agent_id ';
        $query = $this->db->query($query);
        return $query->result_array();
    }

    public function paginateDetailedReportData($sqlPart, $param = array()) {
        $query = 'SELECT agenti.id,agenti.businessname,agenti.email,agenti.businesstelephone,
                    inv_booking_id,"" as inv_number,centri.nome_centri,DATE_FORMAT(inv_date,"%d/%m/%Y") as inv_date,DATE_FORMAT(plused_book.arrival_date,"%d/%m/%Y") as arrival_date,
                    DATE_FORMAT(plused_book.departure_date,"%d/%m/%Y") as departure_date,DATE_FORMAT(DATE_ADD(plused_book.arrival_date,INTERVAL -1 MONTH),"%d/%m/%Y") as due_date,inv_total_cost,
                    IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where plused_fincon_payments.pfp_bk_id = derived_booking_invoice.inv_booking_id AND plused_fincon_payments.pfp_dare_avere ="avere" ),0) as pfp_import,
                    (inv_total_cost - IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where plused_fincon_payments.pfp_bk_id = derived_booking_invoice.inv_booking_id AND plused_fincon_payments.pfp_dare_avere ="avere" ),0)) as overdue,
                    IF((inv_total_cost - IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where plused_fincon_payments.pfp_bk_id = derived_booking_invoice.inv_booking_id AND plused_fincon_payments.pfp_dare_avere ="avere" ),0)) > 0,"Overdue","Not yet due") as status
                   FROM (SELECT t.* FROM agnt_booking_invoice t INNER JOIN (SELECT inv_total_cost,MAX(inv_invoice_id) AS latest,inv_booking_id FROM agnt_booking_invoice GROUP BY inv_booking_id) t1 ON t1.inv_booking_id=t.inv_booking_id AND t1.latest=t.inv_invoice_id
                   ) AS derived_booking_invoice 
                   LEFT JOIN agenti ON agenti.id = derived_booking_invoice.inv_agent_id 
                   LEFT JOIN centri ON derived_booking_invoice.inv_campus_id = centri.id
                   LEFT JOIN plused_book ON derived_booking_invoice.inv_booking_id = plused_book.id_book
                   WHERE 1=1 AND agenti.status = "active" '
                . $sqlPart;
        if(!empty($param))
        {
            $query .= ' ORDER BY ' . $param['column'] . ' ' . $param['type'] . ' LIMIT ' . $param['start'] . ', ' . $param['offset'];
        }else{
            $query .= ' ORDER BY businessname ';
        }
        $query = $this->db->query($query);
        return $query->result();
    }

    public function getDetailedReportCount($sqlPart) {
        $query = 'SELECT count(t.inv_booking_id) as count FROM agnt_booking_invoice t 
                    INNER JOIN (SELECT inv_total_cost,MAX(inv_invoice_id) AS latest,
                    inv_booking_id FROM agnt_booking_invoice GROUP BY inv_booking_id) 
                    t1 ON t1.inv_booking_id=t.inv_booking_id AND t1.latest=t.inv_invoice_id 
                    LEFT JOIN agenti ON inv_agent_id = agenti.id
                   WHERE 1=1 AND agenti.status = "active" ' . $sqlPart;
        $query = $this->db->query($query);
        return $query->row();
    }
    
    public function getDataDailyDebtors($campusId,$todaysDate){
        $this->db->flush_cache();
        $query = 'SELECT GROUP_CONCAT(plused_book.id_book) as gr_bookings, "'.$todaysDate.'" as today_date, sum(inv_total_cost) as total_cost,
                    IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where find_in_set(plused_fincon_payments.pfp_bk_id,GROUP_CONCAT(derived_booking_invoice.inv_booking_id)) AND plused_fincon_payments.pfp_dare_avere ="avere" ),0) as pfp_import,
                    (sum(inv_total_cost) - IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where find_in_set(plused_fincon_payments.pfp_bk_id,GROUP_CONCAT(derived_booking_invoice.inv_booking_id)) AND plused_fincon_payments.pfp_dare_avere ="avere" ),0)) as overdue
                   FROM (SELECT t.* FROM agnt_booking_invoice t INNER JOIN 
                                (SELECT inv_total_cost,MAX(inv_invoice_id) AS latest,inv_booking_id 
                                FROM agnt_booking_invoice 
                                GROUP BY inv_booking_id) 
                   t1 ON t1.inv_booking_id=t.inv_booking_id AND t1.latest=t.inv_invoice_id
                   ) AS derived_booking_invoice 
                   JOIN plused_book ON derived_booking_invoice.inv_booking_id = plused_book.id_book
                   WHERE date(plused_book.arrival_date) = "'.$todaysDate.'"';
                   if($campusId > 0)
                       $query .=' AND derived_booking_invoice.inv_campus_id = '.$campusId;
        
        $query = $this->db->query($query);
        return $query->result_array();
        
        /*
         * 
         SELECT `book`.`arrival_date`,`book`.`id_book`, `inv`.`inv_booking_id`, `inv`.`inv_invoice_id` , MAX(inv.inv_invoice_id),
            inv_total_cost,
            IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where find_in_set(plused_fincon_payments.pfp_bk_id,GROUP_CONCAT(inv.inv_booking_id)) AND plused_fincon_payments.pfp_dare_avere ="avere" ),0) as pfp_import,
            ((inv_total_cost) - IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where find_in_set(plused_fincon_payments.pfp_bk_id,GROUP_CONCAT(inv.inv_booking_id)) AND plused_fincon_payments.pfp_dare_avere ="avere" ),0)) as due_amount
            FROM (`plused_book` book) 
            JOIN `agnt_booking_invoice` inv ON (`book`.`id_book` = `inv`.`inv_booking_id`)
            GROUP BY inv.inv_booking_id
         */
    }
    
     public function getDueReport($calFromDate,$calToDate){
        $this->db->flush_cache();
        $query = 'SELECT centri.valuta_fattura, GROUP_CONCAT(plused_book.id_book) as gr_bookings, plused_book.arrival_date as arrival_date, sum(inv_total_cost) as total_cost,
                    IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where find_in_set(plused_fincon_payments.pfp_bk_id,GROUP_CONCAT(derived_booking_invoice.inv_booking_id)) AND plused_fincon_payments.pfp_dare_avere ="avere" ),0) as pfp_import,
                    (sum(inv_total_cost) - IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where find_in_set(plused_fincon_payments.pfp_bk_id,GROUP_CONCAT(derived_booking_invoice.inv_booking_id)) AND plused_fincon_payments.pfp_dare_avere ="avere" ),0)) as overdue
                   FROM (SELECT t.* FROM agnt_booking_invoice t INNER JOIN 
                                (SELECT inv_total_cost,MAX(inv_invoice_id) AS latest,inv_booking_id 
                                FROM agnt_booking_invoice 
                                GROUP BY inv_booking_id) 
                   t1 ON t1.inv_booking_id=t.inv_booking_id AND t1.latest=t.inv_invoice_id
                   ) AS derived_booking_invoice 
                   JOIN plused_book ON derived_booking_invoice.inv_booking_id = plused_book.id_book
                   LEFT JOIN centri ON plused_book.id_centro = centri.id
                   WHERE (date(plused_book.arrival_date) >= "'.$calFromDate.'" AND date(plused_book.arrival_date) <= "'.$calToDate.'")   
                   GROUP BY centri.valuta_fattura,plused_book.arrival_date';
        $query = $this->db->query($query);
        return $query->result_array();
     }
     
     function getBookingDebtReport($bookingIds) {
        $this->db->flush_cache();
        $query = 'SELECT centri.valuta_fattura,agenti.businessname as agent_name,agenti.id as agent_id,agenti.email as agent_email,agenti.businesstelephone as agent_phone, plused_book.id_book, plused_book.arrival_date as arrival_date, inv_total_cost as total_cost,
                IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where plused_fincon_payments.pfp_bk_id = derived_booking_invoice.inv_booking_id AND plused_fincon_payments.pfp_dare_avere ="avere" ),0) as pfp_import,
                ((inv_total_cost) - IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where plused_fincon_payments.pfp_bk_id = derived_booking_invoice.inv_booking_id AND plused_fincon_payments.pfp_dare_avere ="avere" ),0)) as overdue
            FROM (SELECT t.* FROM agnt_booking_invoice t INNER JOIN 
                            (SELECT inv_total_cost,MAX(inv_invoice_id) AS latest,inv_booking_id 
                            FROM agnt_booking_invoice 
                            GROUP BY inv_booking_id) 
            t1 ON t1.inv_booking_id=t.inv_booking_id AND t1.latest=t.inv_invoice_id
            ) AS derived_booking_invoice 
            JOIN plused_book ON derived_booking_invoice.inv_booking_id = plused_book.id_book
            LEFT JOIN centri ON plused_book.id_centro = centri.id
            LEFT JOIN agenti ON agenti.id = derived_booking_invoice.inv_agent_id 
            WHERE find_in_set(plused_book.id_book,"'.$bookingIds.'")    
            GROUP BY centri.valuta_fattura,plused_book.id_book';
        $query = $this->db->query($query);
        return $query->result_array();
    }
    
    function getAgentDebtReport($agentId) {
        $this->db->flush_cache();
        $query = 'SELECT centri.nome_centri, centri.valuta_fattura,agenti.businessname as agent_name,agenti.id as agent_id, 
                    plused_book.id_book, 
                    plused_book.arrival_date as arrival_date, 
                    inv_total_cost as total_cost,
                    IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where plused_fincon_payments.pfp_bk_id = derived_booking_invoice.inv_booking_id AND plused_fincon_payments.pfp_dare_avere ="avere" ),0) as pfp_import,
                    ((inv_total_cost) - IFNULL((SELECT SUM(pfp_importo) as pfp_importo FROM plused_fincon_payments where plused_fincon_payments.pfp_bk_id = derived_booking_invoice.inv_booking_id AND plused_fincon_payments.pfp_dare_avere ="avere" ),0)) as overdue
                   FROM (SELECT t.* FROM agnt_booking_invoice t INNER JOIN 
                                (SELECT inv_total_cost,MAX(inv_invoice_id) AS latest,inv_booking_id 
                                FROM agnt_booking_invoice 
                                GROUP BY inv_booking_id) 
                   t1 ON t1.inv_booking_id=t.inv_booking_id AND t1.latest=t.inv_invoice_id
                   ) AS derived_booking_invoice 
            JOIN plused_book ON derived_booking_invoice.inv_booking_id = plused_book.id_book
            LEFT JOIN centri ON plused_book.id_centro = centri.id
            LEFT JOIN agenti ON agenti.id = derived_booking_invoice.inv_agent_id 
            WHERE derived_booking_invoice.inv_agent_id  = '.$agentId.'    
            GROUP BY centri.valuta_fattura,derived_booking_invoice.inv_booking_id';
        $query = $this->db->query($query);
        return $query->result_array();
    }
    

}

?>
