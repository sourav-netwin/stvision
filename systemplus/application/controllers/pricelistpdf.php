<?php
/**
 * This controller is responsible for price list pdf uploads for backoffice user 
 * and CMS
 * @author Sandip Kalbhile
 * @since 16-11-2017
 */
class Pricelistpdf extends Controller {

    public function __construct() {

        parent::Controller();

        $this->load->model('agents/pricelistpdfmodel','pricelistpdfmodel');
        $this->load->library(array('session', 'email'));
    }
    
    function pricelist($type = "campus"){
        authSessionMenu($this);
        if ($this->session->userdata('role')) {
            $data = array();
            $errorMessage = "";
            if(!empty($_POST))
            {
                $this->load->library('upload');
                $title = $this->input->post('campus_pdf_file_title');
                $type = $this->input->post('hiddPriceType');
                if (!file_exists(CAMPUS_PRICELIST_PDF_PATH)) {
                    mkdir(CAMPUS_PRICELIST_PDF_PATH, 0755, true);
                }
                $file_name = time() . '_' . $this->stripJunk($_FILES['campus_pdf_file']['name']);
                $config['upload_path'] = CAMPUS_PRICELIST_PDF_PATH;
                $config['allowed_types'] = 'pdf';
                $config['file_name'] = $file_name;
                $this->upload->initialize($config);
                //---- UPLOAD IMAGE ----//
                if ($this->upload->do_upload("campus_pdf_file")) {
                    $aUploadData = $this->upload->data();
                    $file_name = $aUploadData['file_name'];
                    // Insert in database
                    $uploadPdf = $this->pricelistpdfmodel->uploadPdf($title, $file_name, $type);
                    $this->session->set_flashdata('success_message', 'File uploaded successfully');
                    redirect('pricelistpdf/pricelist/'.$type);
                    exit();
                } else {
                    $errorMessage = $this->upload->display_errors();
                }
            }
            $data['errorMessage'] = $errorMessage;
            $data['pricetype'] = $type;
            $data['pricelistData'] = $this->pricelistpdfmodel->getData($type);
            $data['title'] = "plus-ed.com | Campus and excursion";
            $data['breadcrumb1'] = 'Campus and excursion';
            $data['breadcrumb2'] = 'Add price list pdf';
            $data['pageHeader'] = "Add price list pdf";
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/cms_user/pricelistpdf', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    function deletepdf($type, $pdf_id) {
        if ($this->session->userdata('role')) {
            if(is_numeric($pdf_id))
            {
                // Unlink file
                $file_path = $this->pricelistpdfmodel->getData($pdf_id);
                @unlink(CAMPUS_PRICELIST_PDF_PATH . $file_path);
                // Delete record from database
                $this->pricelistpdfmodel->deleteRecord($pdf_id);
                $this->session->set_flashdata('success_message', 'PDF deleted successfully');
                redirect('pricelistpdf/pricelist/'.$type);
            }
            else
                redirect('pricelistpdf/pricelist/'.$type);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    /**
     * stripJunk
     * this function can be used to strip unwanted characters from file name.
     * @param $string input filename
     * @return string
     * @author SK
     * @since Feb 01 16
     */
    function stripJunk($string) {
        $string = str_replace(" ", "-", trim($string));
        $string = preg_replace("/[^a-zA-Z0-9-.]/", "", $string);
        $string = strtolower($string);
        return $string;
    }
    

}/* End of file Backofficemigrate.php */