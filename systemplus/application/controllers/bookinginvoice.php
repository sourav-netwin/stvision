<?php
class Bookinginvoice extends Controller {

    public function __construct() 
    {
        parent::Controller();
        if ($this->session->userdata('username') && $this->session->userdata('role') == 100) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('session', 'email', 'excel');
            $this->load->model('agents/bookinginvoicemodel');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function index(){
        redirect('bookinginvoice/grid');
    }
    /**
     * Landing page for booking invoices
     * @param type $campusId 
     */
    function grid() {
        $campusId = 0;
        $bookingId = 0;
        $agentName = "";
        $data['title'] = 'plus-ed.com | Invoice history';
        $data['breadcrumb1'] = 'Bookings review';
        $data['breadcrumb2'] = 'Invoice history';
        $data['pageHeader'] = $data['breadcrumb2'];
        $data['optionalDescription'] = "";
        $data['campusId'] = $campusId;
        $data['bookingId'] = $bookingId;
        $data['agentName'] = $agentName;
        $data['campusList'] = $this->bookinginvoicemodel->getCampusList(1);
        //$data['invoiceData'] = $this->bookinginvoicemodel->invoicesData();
        $this->ltelayout->view('lte/agents_new/invoice_history', $data);
    }
    
    function invoice_ajax(){
        $request = $_REQUEST;
        $campus = $request['campus'];
        $bookingId = $request['bookingId'];
        $agentName = $request['agentName'];
        $start = $request['start'];
        $offset = $request['length'];
        $orderBy = $request['order'];
        $order = array();
        if ((isset($orderBy[0]['column'])) && $request['draw'] > 1) {
            $orderColIndex = $request['order']['0']['column'];
            $order['column'] = $request['columns'][$orderColIndex]['name'];
            $order['type'] = $request['order']['0']['dir'];
        } else {
            $order['column'] = 'inv_date';
            $order['type'] = 'desc';
        }
        $resultData = $this->bookinginvoicemodel->invoicesData($start, $offset, $order, $campus, $bookingId, $agentName);
        $reportCount = $this->bookinginvoicemodel->invoicesDataCount($campus, $bookingId, $agentName);
        $resultArray = array();
            if(!empty($resultData)){
                foreach($resultData as $invoice){
                    $currencySymbol = "";
                    if($invoice['valuta_fattura'] == "EUR")
                        $currencySymbol = "&euro;";
                    else if($invoice['valuta_fattura'] == "GBP")
                        $currencySymbol = "&pound;";
                    else if($invoice['valuta_fattura'] == "USD")
                        $currencySymbol = "$";
                    
                    $invoiceFile = "<a href=".base_url()."index.php/bookinginvoice/pdf/".$invoice['inv_invoice_file']." class='btn btn-xs btn-primary min-wd-20 booking_modal'><i class='fa fa-file-pdf-o'></i></a>";
                    $row = array(
                        'nome_centri' => $invoice['nome_centri'],
                        'inv_booking_id' => $invoice['inv_booking_id'],
                        'agentname' => $invoice["agentname"],
                        'inv_date' => date('d/m/Y', strtotime($invoice['inv_date'])),
                        'inv_number_of_week' => $invoice["inv_number_of_week"],
                        'pack_package' => $invoice["pack_package"],
                        'inv_number_of_pax' => $invoice["inv_number_of_pax"],
                        'inv_total_cost' => $currencySymbol . $invoice["inv_total_cost"],
                        'inv_pdf_file' => $invoiceFile
                    );
                    array_push($resultArray, $row);
                }   
            }
            $data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => intval($reportCount),
                "recordsFiltered" => intval($reportCount),
                "data" => $resultArray, // total data array
            );
            echo json_encode($data);
        //echo json_encode($resultArray);
    }
    
    /**
     * allow user to download file  
     */
    function pdf($fileName = ""){
        if(!empty($fileName))
        {
            $this->load->helper('download');
            $attachFile = BOOKING_INVOICE_FILE . $fileName;
            $data = file_get_contents($attachFile); // Read the file's contents
            force_download($fileName, $data); 
        }
    }
    

}
/* End of file Bookinginvoice.php */
