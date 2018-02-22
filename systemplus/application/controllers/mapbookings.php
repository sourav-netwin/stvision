<?php
/**
 * This controller is made to handle applications post 
 * requests from external website apply form for available prositions.
 */
class Mapbookings extends Controller {

    public function __construct() {

        parent::Controller();
        if ($this->session->userdata('username') && $this->session->userdata('role')) { // 100 role
            $this->load->helper(array('form', 'url'));
            $this->load->library('session', 'email', 'excel');
            $this->load->model('agents/mapbookmodel');
            $this->load->model('agents/packagesmodel');
            $this->load->model('gestione_centri_model');
            $this->load->model('tuition/campuscoursemodel');
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    /**
     * Landing page for booking mapping
     * @param type $campusId 
     */
    function index($campusId = 0)
    {
        $data["all_books"] = $this->mapbookmodel->getBookingsByAgent($campusId);
        $data["campusList"] = $this->mapbookmodel->getCampusList(1); // $this->session->userdata('id')
        $data['campusId']= $campusId;
        $data['campusName']= $this->mapbookmodel->centerNameById($campusId);
        $data['title']='plus-ed.com | Map bookings & packages';
        $data['breadcrumb1']='Bookings review';
        $data['breadcrumb2']='Map bookings & packages';
        $data['pageHeader'] = $data['breadcrumb2'];
        $data['optionalDescription'] = "";
        $this->ltelayout->view('lte/agents/map_bookings', $data);
    }
    
    /**
     * Get all packages for the booking for mapping 
     */
    public function getPackages() {
        $result = "<option value=''>Select package</option>";
        $center = $this->input->post("idcentro") ? $this->input->post("idcentro") : "";
        $week = $this->input->post("week") ? $this->input->post("week") : "";
        if ($center > 0) {
            $agentId = $this->input->post("aId") ? $this->input->post("aId") : 0;
            $packages = $this->mapbookmodel->getPackages($center, $agentId, $week);
            if (!empty($packages)) {
                foreach ($packages as $package) {
                    $result .= "<option value='" . $package['pack_package_id'] . "'>" . $package['pack_package'] . "</option>";
                }
                echo $result;
            }
            else
                echo $result;
        }
        else
            echo $result;
    }
    
    /**
     * Add package with the booking id 
     */
    public function addPackage(){
        $packageId = $this->input->post('packageId');
        $bookId = $this->input->post('bookId');
        $mapId = $this->input->post('mapId');
        if(is_numeric($bookId) && is_numeric($bookId)){
            if(!is_numeric($mapId)) $mapId = 0; 
            $result = $this->mapbookmodel->addPackage($packageId,$bookId,$mapId);
            if($result){
                echo "Package mapped with the booking successfully";
            }
            else {
                echo "Unable to map package with booking";
            }
        }
        else{
            echo "Please select proper package and try again";
        }
    }
    
    /**
     * Map single package with the multiple bookings 
     */
    public function addPackageMultipleBook(){
        $packageId = $this->input->post('packageId');
        $bookIds = $this->input->post('bookIds');
        if(is_array($bookIds) && is_numeric($packageId)){
            $mapId = 0; 
            $result = $this->mapbookmodel->addPackage($packageId,$bookIds,$mapId);
            if($result){
                echo "Package mapped with the booking successfully";
            }
            else {
                echo "Unable to map package with booking";
            }
        }
        else{
            echo "Please select proper package and try again";
        }
    }
    
    /**
     * Print the booking invoice pdf
     * @param type $enrollId 
     */
    function generateinvoice($enrollId = 0,$response = "") {
        $this->load->helper(array('mpdf6'));
        $this->load->model('agent_booking_model');
        $fileName = '';
        $resultData = array();
        $resultData['result'] = 0;
        $resultData['message'] = "";
        $booking = $this->mapbookmodel->getBookingsDetails($enrollId);
        if ($booking) {
            $fileName = 'invoice_' .$booking['id_book'] ."_". time().'.pdf';
            $booking_composition = $this->mapbookmodel->getBookingComposition($enrollId);
            //$booking_accomodation = $this->mapbookmodel->getBookingAccomodation($enrollId);
            $bookingWeeks = $booking['weeks'];
            
            // get free gl
            $freeGL = 0;
            if($booking_composition)
            {
                $freeGlPerPax = $booking_composition[0]['pack_free_gl_per_pax'];
                $freeGL = (int)($booking['students_count'] / $freeGlPerPax);
            }
            
            $freeGLsIds = 0;
            if($freeGL)
                $freeGLsIds = $this->mapbookmodel->getFreeGLsIds($enrollId,$freeGL);
                        
            $bookingExtraCharges = $this->mapbookmodel->getExtraNightCharges($enrollId,$bookingWeeks,$freeGLsIds);
            $bookingDiscount = $this->mapbookmodel->getBookingDiscount($enrollId);
            
            $templateData = array(
                'book' => $booking,
                'booking_composition' => $booking_composition,
                'bookingExtraNightCharges' => $bookingExtraCharges['extra_night_charges'],//,
                'bookingExtraNight' => $bookingExtraCharges['extra_night'],//,
                'bookingExtraTuitionCharges' => $bookingExtraCharges['extra_tuition_charges'],
                'bookingExtraTuitionDay' => $bookingExtraCharges['extra_tuition_day'],
                "perExtraNight" => $bookingExtraCharges['per_extra_night'],
                "perExtraTuitionDay" => $bookingExtraCharges['per_extra_tuition_day'],
                "bookingDiscount" => $bookingDiscount
                //'booking_accomodation' => $booking_accomodation
            );
            //$templateData['invoiceFileName'] = $fileName;
            //$this->load->view('lte/agents_new/pdf_existing_booking_new_format_invoice', $templateData);
            //$this->load->view('lte/agents_new/pdf_existing_booking_invoice', $templateData);
            if (1) {
                $templateData['invoiceFileName'] = $fileName;
                $templateBody = $this->load->view('lte/agents_new/pdf_existing_booking_new_format_invoice', $templateData,true);
                if (!file_exists(BOOKING_INVOICE_FILE)) {
                    mkdir(BOOKING_INVOICE_FILE, 0755, true);
                }
                include_once("mpdf60/mpdf.php"); // load mpdf
                $mpdf= new mPDF('utf-8', 'A4',10,0,0,0,2,15,2,0,'P');
                $htmlHeader = '';
                $htmlfooter = '
                    <div class="pdf-footer" style="text-align: center; color: #005dc7; font-weight: bold: padding: 10px;font-size:12px;margin-top:3px;">
                            <p class="page" style="padding: 5px;">Professional Linguistic & Upper Studies Limited t/a PLUS - P: + 44 (0)20 7730 2223 - E: info@plus-ed.com</p>
                            <p style="background-color: #005dc7; color: #fff !important;padding: 5px;">
                                    Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
                            </p>
                    </div>
                ';
                $mpdf->setAutoTopMargin = "stretch";
                $mpdf->SetHTMLHeader($htmlHeader);
                $mpdf->SetHTMLFooter ($htmlfooter);
                $mpdf->SetDisplayMode('fullwidth');
                $mpdf->WriteHTML($templateBody);
                $mpdf->Output( BOOKING_INVOICE_FILE . $fileName,'F' );// write to pdf file, see pdf/ dir at root
                $resultData['result'] = 1;
                $resultData['filname'] = $fileName;
                $resultData['message'] = "Booking invoice generated successfully.";
            }
        } else {
            $resultData['result'] = 0;
            $resultData['message'] = "Booking is not mapped with any package.\n So the invoice is not generated.";
        }
        if($response == "json")
            echo json_encode ($resultData);
        else
            return $resultData;
        exit();
    }
    
}/* End of file positions.php */