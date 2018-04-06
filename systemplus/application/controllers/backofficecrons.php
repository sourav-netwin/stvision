<?php
/**
 * This controller is created to set cron jobs
 * a command to an operating system or server for a job that is to be executed at a specified time.
   "a cron job"
 * @author Sandip Kalbhile
 * @since 28-Feb-2017
 */
class Backofficecrons extends Controller {

    public function __construct() {

        parent::Controller();

        $this -> load -> helper('csv');
        $this->load->model('magenti');
        $this -> load -> model('mbackoffice');
        $this -> load -> library(array('session', 'email'));
    }

    /**
     * Marks all expired bookings status to "elapsed"
     * Sends email alert to AGENT / CAMPUS MANAGER
     * @author Sandip Kalbhile
     * @since 28-Feb-2017
     */
    function agentEmailOnBookingElapsed(){
        //log_message('error', 'Start: Running cron to send booking elapsed alert to agents');
        $this -> mbackoffice -> elapsedBookingsToElapse();
        //log_message('error', 'Finish: Running cron to send booking elapsed alert to agents');
    }

    /**
     * Weekly availability report
     * Sends weekly booking availability report to some emails
     * @author Arunsankar S
     * @since 15-Mar-2017
     */
    function weeklyBookingAvailabilityReport(){
        //log_message('error', 'Start: Running cron to send weekly booking availability report');

        $this -> load -> model('gestione_centri_model');

        $todaydate = date('Y-m-d');
		$datein = "2017-06-01";
		$dateout = "2017-09-01";

        if (!file_exists(WEEKLY_AVAILABILITY_DWNLD)) {
            mkdir(WEEKLY_AVAILABILITY_DWNLD, 0777, true);
        }

        $myFile = WEEKLY_AVAILABILITY_DWNLD.'/weekly-report-'.$todaydate.'.csv';
		$fh = fopen($myFile, 'w+') or die("can't open file");

        $centri = $this -> mbackoffice -> getAllCampus(1);
        foreach ($centri as $cmp)
            $campusArray[] = array( 'id' => $cmp["id"], 'campus_name' => $cmp["nome_centri"] );

        $statusArray = array("confirmed", "active");

        foreach ( $campusArray as $campus )
        {
            $simbooking = array();
            $accomoArray = array();

            $accos = $this -> gestione_centri_model -> findAccoByCenter( $campus['id'] );
            foreach( $accos as $key => $value )
            {
                $accomoArray[] = $accos[$key]["sistemazione"];
                $simbooking[] = $this -> mbackoffice -> NA_getSimBooking_backoffice($campus['id'], $accomoArray[$key], $datein, $dateout, $statusArray);
            }

            if( !empty( $simbooking ) )
            {
                foreach ( $simbooking as $key => $sb )
                {
                    $contaBooked = array();
                    $simcalendar = array();

                    $testata = "Campus;Booking;Status;Accomodation;";

                    $current = strtotime( $datein );
                    $last = strtotime( $dateout );
                    $date = $datein;

                    while( $current <= $last )
                    {
                        $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

                        $testata .= date("d/m", $current) . ";";
                        $current = strtotime("+1 day", $current);
                        $contaBooked[] = 0;

                        $simcalendar[] = $this -> mbackoffice -> get_total_available( $campus['id'], $accomoArray[$key], $date);
                    }

                    $testata .= PHP_EOL;
                    fwrite($fh, $testata);

                    if( !empty( $sb ) )
                    {
                        foreach ( $sb as $book )
                        {
                            $rigaBk = $campus['campus_name'] . ";". $book["id_year"] . "_" . $book["id_book"] . ";" . $book["status"] . ";" . ucfirst($accomoArray[$key]) . ";";

                            $datecycle = date("Y-m-d", strtotime("+0 day", strtotime($datein)));
                            $contadays = 0;
                            while (strtotime($datecycle) <= strtotime($dateout))
                            {
                                $datecycle = $datecycle . " 00:00:00";
                                $numAttuale = $contaBooked[$contadays];
                                if ($datecycle >= $book["arrival_date"] and $datecycle < $book["departure_date"])
                                {
                                    $rigaBk .= $book["num_in"] . ";";
                                    $contaBooked[$contadays] = $numAttuale * 1 + $book["num_in"] * 1;
                                }
                                else
                                {
                                    $rigaBk .= "0;";
                                    $contaBooked[$contadays] = $numAttuale * 1;
                                }
                                $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                $contadays++;
                            }
                            $rigaBk .= PHP_EOL;
                            fwrite($fh, $rigaBk);
                        }
                    }
                    else
                    {
                        $rigaBk = $campus['campus_name'] . ";". ";".";". ";";

                        $datecycle = date("Y-m-d", strtotime("+0 day", strtotime($datein)));
                        while (strtotime($datecycle) <= strtotime($dateout))
                        {
                            $rigaBk .= "0;";
                            $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                        }
                        $rigaBk .= PHP_EOL;
                        fwrite($fh, $rigaBk);
                    }

                    $rigaAva = "Allotment;;;;";
                    foreach ($simcalendar as $cAva) {
                        $rigaAva.=$cAva["totale"] . ";";
                    }
                    $rigaAva.=PHP_EOL;
                    fwrite($fh, $rigaAva);

                    $rigaBoo = "Booked;;;;";
                    foreach ($contaBooked as $cBoo) {
                        $rigaBoo.=$cBoo . ";";
                    }
                    $rigaBoo.=PHP_EOL;
                    fwrite($fh, $rigaBoo);

                    $rigaTot = "Availability;;;;";
                    $gira = 0;
                    foreach ($simcalendar as $cAva) {
                        $rigaTot.= ($cAva["totale"] * 1 - $contaBooked[$gira] * 1) . ";";
                        $gira++;
                    }
                    $rigaTot.=PHP_EOL;
                    fwrite($fh, $rigaTot);
                }
            }
        }
        fclose($fh);
        $this -> load -> library('excel');
        $inputFileType = 'CSV';
        $inputFileName = $myFile;
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader -> setDelimiter(";");
        $objReader -> setInputEncoding('UTF-8');
        $objPHPExcel = $objReader -> load($inputFileName);

        $excel_file = WEEKLY_AVAILABILITY_DWNLD.'/weekly-report-'.$todaydate.'.xls';
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter -> save($excel_file);
        unlink($myFile);

        // Send email
		ob_start(); // start output buffer
		$data['excel_file'] = 'weekly-report-'.$todaydate.'.xls';
		$this->load->view('tuition/email/booking_availability_report_weekly', $data);
		$messageBody = ob_get_contents(); // get contents of buffer	
		ob_end_clean();
		
		
        $this->load->library('email');
        $from_email = "booking@plus-ed.com";
		$to_email = "smarra@plus-ed.com,m.marra@studytours.it,l.pombo@plus-ed.com";
		$bcc_mail = "a.sudetti@gmail.com";
		
        $this->email->set_newline("\r\n");
        $this->email->from($from_email, 'plus-ed.com');
        $this->email->to($to_email);
		$this->email->bcc($bcc_mail);
        $this->email->subject('Plus Sales Office - Booking availability report');
        $this->email->message( $messageBody );

        $sendRes = $this->email->send();

        $this->email->clear();

        //log_message('error', 'Finish: Running cron to send weekly booking availability report');
    }
	
    function weeklybookingreportdownload($filename = 0){
        if(!empty($filename))
        {
                        $this->load->helper('download');
                        $attachFile = WEEKLY_AVAILABILITY_DWNLD ."/". $filename;
                        $data = file_get_contents($attachFile); // Read the file's contents
                        force_download($filename, $data);
        }
    }
    
    /**
     * This function written to collect all booking records 
     * and prepare excel sheet to send as an attachment in email to 
     * Stefano, Account manager
     * Weekly booking to be elapsed 
     * Email Template used id:1
     */
    function bookingToBeElapsedReport()
    {
            $data["centri"] = $this->mbackoffice->getAllCampus();
            //$data["tutte_agenzie"] = $this->mbackoffice->getAllAgencies();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : 'all';
            $status = isset($_POST['stato_in']) ? $_POST['stato_in'] : 'all';
            $agent = isset($_POST['agenzia_in']) ? $_POST['agenzia_in'] : 'all';
            
            $data["campus"] = $campus;
            $data["agenziefrom"] = $agent;
            $data["statusfrom"] = $status;
            $bookingElapsingWeekStart = date("Y-m-d");
            $bookingElapsingWeekEnd = date("Y-m-d",  strtotime("+1 week"));
            $emailSubject = " Date ".$bookingElapsingWeekStart." to ".$bookingElapsingWeekEnd;
            
            $whereCls = "
                        status != 'confirmed' 
                        AND status != 'rejected' 
                        AND data_scadenza >= CAST('".$bookingElapsingWeekStart."' AS DATE) 
                        AND data_scadenza <= CAST('".$bookingElapsingWeekEnd."' AS DATE)
                        ";
            
            $data["all_books"] = $this->mbackoffice->exportCSVBookingsToBeElapsedReport($campus, $agent, $status, $whereCls);
        
            $myFile = "./downloads/export_csv/allCSVBookingsTobeElapsed.csv";
            $fh = fopen($myFile, 'w+') or die("can't open file");
            $intestData = '"Centro";"Booking number";"Agency";"Agency email";"Agency phone";"Arrival date";"Departure date";"Weeks";"Pax type";"Accomodation";"Pax number";"Status";"Elapsing date";"Booking date and time";"Deposit invoice";"Full invoice";"Currency"' . PHP_EOL;
            fwrite($fh, $intestData);
            foreach ($data["all_books"] as $singbk) {
                //echo "<br />".$singbk["centro"].'";"'.$singbk["id_book"]."_".$singbk["id_year"].$singbk["agency"][0]["businessname"].'";"'.$singbk["arrival_date"].'";"'.$singbk["departure_date"].'";"'.$singbk["weeks"].'";"'.$singbk["status"].'";"'.$singbk["data_scadenza"].'";"'.$singbk["data_insert"].'";'.str_replace(".",",",$singbk["acconto_versato"]).';'.str_replace(".",",",$singbk["saldo_versato"]).';"'.$singbk["valuta"]."<br />";
                if (count($singbk["all_acco"])) {
                    foreach ($singbk["all_acco"] as $singacco) {
                        $agencyBusinessName = "";
                        if(isset($singbk["agency"][0]["businessname"]))
                            $agencyBusinessName = $singbk["agency"][0]["businessname"];
                        $agencyBusinessEmail = "";
                        if(isset($singbk["agency"][0]["email"]))
                            $agencyBusinessEmail = $singbk["agency"][0]["email"];
                        $agencyBusinessPhone = "";
                        if(isset($singbk["agency"][0]["businesstelephone"]))
                            $agencyBusinessPhone = $singbk["agency"][0]["businesstelephone"];
                        $rigaData = '"' . $singbk["centro"] . '";"' . $singbk["id_year"] . "_" . $singbk["id_book"] . '";"' . $agencyBusinessName . '";"' . $agencyBusinessEmail . '";"' . $agencyBusinessPhone . '";"' . $singacco->data_arrivo_campus /*$singbk["arrival_date"]*/ . '";"' . $singacco->data_partenza_campus /*$singbk["departure_date"]*/ . '";"' . $singbk["weeks"] . '";"' . $singacco->tipo_pax . '";"' . $singacco->accomodation . '";"' . $singacco->contot . '";"' . $singbk["status"] . '";"' . $singbk["data_scadenza"] . '";"' . $singbk["data_insert"] . '";' . str_replace(".", ",", $singbk["acconto_versato"]) . ';' . str_replace(".", ",", $singbk["saldo_versato"]) . ';"' . $singbk["valuta"] . '"' . PHP_EOL;
                        //echo "<br />".$rigaData."<br />";
                        fwrite($fh, $rigaData);
                    }
                }
            }
            fclose($fh);

            $this->load->library('excel');

            $inputFileType = 'CSV';
            $inputFileName = $myFile;
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setDelimiter(";");
            $objReader->setInputEncoding('UTF-8');
            
            $objPHPExcel = $objReader->load($inputFileName);
            $attachmentName = time()."_allCSVBookingsTobeElapsed.csv";
            $excel_file = WEEKLY_ELAPSED_BOOKING. $attachmentName;
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter -> save($excel_file);
            
            // send email
            $this->load->library('email');

            $emailTemplate = getEmailTemplate(1);
            $this->email->set_newline("\r\n");
            $this->email->from($emailTemplate->emt_from_email, "Plus-ed.com");
            $this->email->to($emailTemplate->emt_to_email);
            $this->email->subject($emailTemplate->emt_title . $emailSubject);
            $strParam = array(
                '{EXCEL_FILE}' => $attachmentName
            );
            $txtMessageStr = mergeContent($strParam,$emailTemplate->emt_text);
            $this->email->message($txtMessageStr);
            $attachFile = FCPATH . $excel_file;
            $this->email->attach($attachFile);
            $this->email->send();
            die();
    }
    
    /**
     * bookingToBeElapsedAlertToAgents
     * This function reads all booking which are going to elapsed 
     * in on 7th day of the execution, means after a week.
     * And sends an email to the agencies/agents regarding booking elapsing alert.
     * Email Template used id:5.
     */
    function bookingToBeElapsedAlertToAgents()
    {
            $bookingElapsingDate = date("Y-m-d",  strtotime("+1 week"));
            $emailSubject = " Expiry due date:".date("d-m-Y",  strtotime("+1 week"));
            $whereCls = "
                        b.status != 'confirmed' 
                        AND b.status != 'rejected' 
                        AND b.status != 'elapsed' 
                        AND b.data_scadenza = CAST('".$bookingElapsingDate."' AS DATE)
                        ";
            $bookingsTobeElapsed = $this->mbackoffice->exportCSVBookingsToBeElapsedAlert($whereCls);
            if($bookingsTobeElapsed)
            {
                $this->load->library('email');
                foreach ($bookingsTobeElapsed as $singbk) {
                    
                    $elapsedDate = $bookingElapsingDate;
                    $agencyBusinessName = ucwords($singbk['businessname']);
                    $bookId = $singbk['id_book'];
                    $campusName = $singbk['nome_centri'];
                    $dateIn = $singbk['arrival_date'];
                    $dateOut = $singbk['departure_date'];
                    if(validateDate($dateIn, 'Y-m-d'))
                        $dateIn = date("d-m-Y",  strtotime ($dateIn));
                    if(validateDate($dateOut, 'Y-m-d'))
                        $dateOut = date("d-m-Y",  strtotime ($dateOut));
                    if(validateDate($elapsedDate, 'Y-m-d'))
                        $elapsedDate = date("d-m-Y",  strtotime ($elapsedDate));
                   
                    $numberOfWeeks = $singbk['weeks'];
                    $stdCount = $singbk['std_count'];
                    $glCount = $singbk['gl_count'];
                    $accountManagerName = ucwords($singbk['account_manager_firstname'] . " " .$singbk['account_manager_familyname']);
                    $accountManagerEmail = $singbk['account_manager_email'];
                    $agentEmail = $singbk['agent_email'];
                    // send email
                        $this->email->clear();
                        $emailTemplate = getEmailTemplate(5);
                        $this->email->set_newline("\r\n");
                        $this->email->from($emailTemplate->emt_from_email, "Plus-ed.com");
                        $this->email->to($agentEmail);
                        $this->email->cc($accountManagerEmail.",smarra@plus-ed.com");
                        $this->email->subject($emailTemplate->emt_title . $emailSubject);
                        $strParam = array(
                            '{AGENCY_NAME}' => $agencyBusinessName,
                            '{ELAPSED_DATE}' => $elapsedDate,
                            '{GROUP_ID}' => $bookId,
                            '{CAMPUS}' => $campusName,
                            '{DATE_IN}' => $dateIn,
                            '{DATE_OUT}' => $dateOut,
                            '{NO_OF_WEEKS}' => $numberOfWeeks,
                            '{STD_COUNT}' => $stdCount,
                            '{GL_COUNT}' => $glCount,
                            '{ACCOUNT_MANAGER_NAME}' => $accountManagerName,
                            '{ACCOUNT_MANAGER_EMAIL}' => $accountManagerEmail
                        );
                        $txtMessageStr = mergeContent($strParam,$emailTemplate->emt_text);
                        $this->email->message($txtMessageStr);
                        //echo $txtMessageStr;
                        if ($_SERVER['HTTP_HOST'] != "localhost" && $_SERVER['HTTP_HOST'] != "192.168.43.47") {
                            $this->email->send();
                        }
                }
            }
            die();
    }
    
    /**
     * This is used to force csv file to browser to download.
     * @param string $filename 
     */
    function downloadcsv($filename = ""){
        if(!empty($filename))
        {
            $attachFile = WEEKLY_ELAPSED_BOOKING. $filename;
            $this->load->helper('download');
            $data = file_get_contents($attachFile); // Read the file's contents
            force_download($filename, $data);
        }
    }
    
    function updateOldExcType(){
        $fetchCount = 0;
        $updateCount = 0;
        $strQuery = "SELECT * FROM plused_exc_all";
        $excRows = $this->db->query($strQuery);
        if($excRows->num_rows()){
            $fetchCount = $excRows->num_rows();
            $excRowsData = $excRows->result_array();
            $this->db->flush_cache();
            foreach($excRowsData as $row){
                $oldExcId = $row['exc_id'];
                $oldExcType = $row['exc_type'];
                $oldTransType = $row['exc_transfer_type'];
                $this->db->where('exc_old_exc_id',$oldExcId);
                $updateArray = array(
                    'exc_old_type' => $oldExcType,
                    'exc_transfer_type' => $oldTransType
                );
                $this->db->update('agnt_excursions',$updateArray);
                $updateCount++;
                $this->db->flush_cache();
            }
        }
        echo "<br />Total number of old excursions:".$fetchCount;
        echo "<br />Total number of updated new excursions:".$updateCount;
    }

}/* End of file Backofficecrons.php */