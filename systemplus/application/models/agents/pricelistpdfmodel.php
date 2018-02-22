<?php

/**
 * Class for Price list pdf
 * @author Sandip
 * @since 16-Nov-2017
 */
class Pricelistpdfmodel extends Model {

    private $table = 'agnt_packages';
    
    function getData($pricelist_type = "campus",$pdf_id = 0){
        $this->db->select("*");
        $this->db->from("plused_campus_pricelist_pdf");
        if(!empty($pdf_id))
            $this->db->where("pricelist_pdf_id", $pdf_id);
        else
            $this->db->where("pricelist_type", $pricelist_type);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function uploadPdf($title, $filename, $type) {
        $data = array(
            'pricelist_type' => $type,
            'pricelist_title' => $title,
            'pricelist_pdf_path' => $filename
        );
        $this->db->insert('plused_campus_pricelist_pdf', $data);
        return $this->db->insert_id();
    }
    
    function deleteRecord($pdf_id){
        $this->db->where('pricelist_pdf_id',$pdf_id);
        $this->db->delete("plused_campus_pricelist_pdf");
    }
    
}

/*End of file rolemanagementmodel.php*/
