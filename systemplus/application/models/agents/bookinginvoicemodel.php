<?php

/**
 * Class for invoice history
 * @author Sandip
 * @since 23-May-2016
 */
class Bookinginvoicemodel extends Model {
    
    function invoicesData($start, $offset, $order, $campus = 0,$bookingId = 0,$agentName = "")
    {
        $this->db->select("inv_invoice_id,inv_booking_id,inv_old_booking,inv_agent_id,businessname as agentname,inv_campus_id,inv_package_id,
                     	nome_centri,valuta_fattura,pack_package,inv_number_of_gl,inv_number_of_pax,inv_number_of_week,inv_date,inv_total_cost,inv_invoice_file",FALSE);
        
        $this->db->join('agnt_packages','inv_package_id = pack_package_id','left');
        $this->db->join('centri','inv_campus_id = centri.id','left');
        $this->db->join('agenti','inv_agent_id = agenti.id','left');
        
        if($campus > 0)
        {
            $this->db->where("inv_campus_id",$campus);
        }
        if($bookingId > 0)
        {
            $this->db->where("inv_booking_id",$bookingId);
        }
        if(!empty($agentName))
        {
            $this->db->where("businessname LIKE '%".$agentName."%'");
        }
        
        $this->db->limit($offset, $start);
        $this->db->order_by($order['column'], $order['type']);
        
        $result = $this->db->get("agnt_booking_invoice");
        if($result->num_rows())
            return $result->result_array();
        else
            return 0;
    }
    function invoicesDataCount($campus = 0,$bookingId = 0,$agentName = "")
    {
        $this->db->select("inv_invoice_id",FALSE);
        $this->db->order_by('inv_invoice_id','DESC');
        $this->db->join('agnt_packages','inv_package_id = pack_package_id','left');
        $this->db->join('centri','inv_campus_id = centri.id','left');
        $this->db->join('agenti','inv_agent_id = agenti.id','left');
        
        if($campus > 0)
        {
            $this->db->where("inv_campus_id",$campus);
        }
        if($bookingId > 0)
        {
            $this->db->where("inv_booking_id",$bookingId);
        }
        if(!empty($agentName))
        {
            $this->db->where("businessname LIKE '%".$agentName."%'");
        }
        $result = $this->db->get("agnt_booking_invoice");
        return $result->num_rows();
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
        $this->db->select('id,nome_centri,valuta_fattura');
        $this->db->order_by('nome_centri');
        if ($attivi == 1) {
            $this->db->where('attivo', $attivi);
        }
        $res = $this->db->get('centri');
        if ($res->num_rows()) {
            $result = $res->result_array();
        }
        $res->free_result();
        return $result;
    }
    
   

}

/*End of file rolemanagementmodel.php*/