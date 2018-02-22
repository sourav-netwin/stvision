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

}/* End of file Backofficecrons.php */