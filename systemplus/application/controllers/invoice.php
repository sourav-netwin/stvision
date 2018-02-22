<?php

/*
 * This class handles the invoice report functionality
 * @author: Arunsankar
 * @date: 06-June-2017
 */

class Invoice extends Controller {

    public function __construct() {

        parent::Controller();
        
        $this->load->model('booking_invoice', 'invoice');
        $this->load->model('mbackoffice');
    }

    /*
     * this function handles summary loads the view for summary page
     */

    public function summary() {
        if ($this->session->userdata('role') == 100) {
            $data["centri"] = $this->mbackoffice->getAllCampus(1);
            $data["agents"] = $this->mbackoffice->getAllAgencies();
            $data['title'] = 'plus-ed.com | Invoice summary debtor report';
            $data['breadcrumb1'] = 'Invoice summary';
            $data['breadcrumb2'] = 'Invoice summary debtor report';
            $data['pageHeader'] = "Invoice summary debtor report";
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/invoice/summary', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /*
     * this function handles summaryreport for jquery datatable.
     */

    public function getSummary() {
        if ($this->session->userdata('role') == 100) {
            $request = $_REQUEST;
            $param = datatable_param($request, 'businessname', 'asc');
            $campuses = @$request['campuses'];
            $agents = @$request['agents'];
            $sqlPart = $this->sqlPart($campuses, $agents);
            if (empty($sqlPart)) {
                echo datatable_json($request['draw'], 0, array());
                exit(0);
            } else {
                $reportData = $this->invoice->getSummaryData($sqlPart, $param);
                $reportCount = $this->invoice->getSummaryCount($sqlPart);
                $reportCount = isset($reportCount->count) ? $reportCount->count : 0;
                echo datatable_json($request['draw'], $reportCount, $reportData);
                exit(0);
            }
        }
    }

    /*
     * this function returns the query part for campuses and agents condition.
     */

    private function sqlPart($campuses, $agents) {
        $sqlPart = '';
        if (!empty($agents) && !empty($campuses)) {
            $agents = "'" . implode("','", $agents) . "'";
            $campuses = "'" . implode("','", $campuses) . "'";
            $sqlPart = 'AND inv_agent_id IN(' . $agents . ') AND inv_campus_id IN(' . $campuses . ')';
        } elseif (!empty($agents)) {
            $agents = "'" . implode("','", $agents) . "'";
            $sqlPart = 'AND inv_agent_id IN(' . $agents . ')';
        } elseif (!empty($campuses)) {
            $campuses = "'" . implode("','", $campuses) . "'";
            $sqlPart = 'AND inv_campus_id IN(' . $campuses . ')';
        }
        return $sqlPart;
    }

    /*
     * this function returns the default total from database.
     */

    public function getTotals($isAjax = true) {
        if ($this->session->userdata('role') == 100) {
            $request = $_REQUEST;
            $campuses = @$request['campuses'];
            $agents = @$request['agents'];
            $sqlPart = $this->sqlPart($campuses, $agents);
            $totals = $this->invoice->getSummaryData($sqlPart);
            $totalsArray = $this->getDefaultTotals($totals);
            if ($isAjax) {
                echo json_encode(array('success' => true, 'total' => $totalsArray));
            } else {
                return $totalsArray;
            }
            exit(0);
        }
    }

    /*
     * this function return the default total array for the bottom of table.
     */

    private function getDefaultTotals($totals) {
        if (empty($totals)) {
            return array();
        }
        $totalArray = array();
        $balanceTotal = 0;
        $dueTotal = 0;
        $overdueTotal = 0;
        foreach ($totals as $total) {
            $balanceTotal += $total->total_cost;
            $dueTotal += $total->pfp_import;
            $overdueTotal += $total->overdue;
        }
        $totalArray['balanceTotal'] = $balanceTotal;
        $totalArray['dueTotal'] = $dueTotal;
        $totalArray['overdueTotal'] = $overdueTotal;
        return $totalArray;
    }

    /**
     * This function loads customers detailed debtors report page 
     */
    function customerdetails() {
        if ($this->session->userdata('role') == 100) {
            $data["centri"] = $this->mbackoffice->getAllCampus(1);
            $data["agents"] = $this->mbackoffice->getAllAgencies();
            $data['title'] = 'plus-ed.com | Agent detailed debtors report';
            $data['breadcrumb1'] = 'Invoice summary';
            $data['breadcrumb2'] = 'Agent detailed debtors report';
            $data['pageHeader'] = "Agent detailed debtors report";
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/invoice/agents_detailed_report', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * This funcion returns data to the detailed report page datatable in json format 
     */
    public function getDetailedReport() {
        if ($this->session->userdata('role') == 100) {
            $request = $_REQUEST;
            $param = datatable_param($request, 'agenti.businessname');
            $campuses = @$request['campuses'];
            $agents = @$request['agents'];
            $sqlPart = $this->sqlPart($campuses, $agents);
            if (empty($sqlPart)) {
                echo datatable_json($request['draw'], 0, array());
                exit(0);
            } else {
                $reportData = $this->invoice->paginateDetailedReportData($sqlPart, $param);
                $reportCount = $this->invoice->getDetailedReportCount($sqlPart);
                $reportCount = isset($reportCount->count) ? $reportCount->count : 0;
                echo datatable_json($request['draw'], $reportCount, $reportData);
                exit(0);
            }
        }
    }

    public function exportDetailedReport() {
        if ($this->session->userdata('role') == 100) {
            $campuses = $this->input->post('centri');
            $agents = $this->input->post('agent_id');
            $sqlPart = $this->sqlPart($campuses, $agents);
            $reportData = $this->invoice->paginateDetailedReportData($sqlPart);
            $this->load->library('excel_180');
            $objPHPExcel = new PHPExcel();

            $rowCount = 4;
            $this->setColumnAutoWidth($objPHPExcel, "B", "O");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Agent detailed debtors report');
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', date('d/m/Y'));
            $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Customer');
            $objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Customer Email');
            $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Customer Telephone');
            $objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Group Ref');
            $objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Inv No');
            $objPHPExcel->getActiveSheet()->SetCellValue('G3', 'Campus');
            $objPHPExcel->getActiveSheet()->SetCellValue('H3', 'Inv Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('I3', 'Due Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('J3', 'Arrival Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('K3', 'Departure Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('L3', 'Inv Value');
            $objPHPExcel->getActiveSheet()->SetCellValue('M3', 'Not Yet due');
            $objPHPExcel->getActiveSheet()->SetCellValue('N3', 'Overdue');
            $objPHPExcel->getActiveSheet()->SetCellValue('O3', 'Status');

            $styleArray = array(
                'font' => array(
                    'bold' => true,
                )
            );
            $styleArrayWithUnderline = array(
                'font' => array(
                    'bold' => true,
                    'underline' => PHPExcel_Style_Font::UNDERLINE_DOUBLE
                )
            );

            $currentCustomer = "";
            $balanceTotal = 0;
            $paidAmount = 0;
            $overdueTotal = 0;

            $sumBalanceTotal = 0;
            $sumPaidAmount = 0;
            $sumOverdueTotal = 0;

            $rowsCount = count($reportData);
            foreach ($reportData as $data) {
                $rowsCount--;
                if ($currentCustomer != $data->businessname) {
                    if ($rowCount != 4) {
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $currentCustomer);
                        $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $balanceTotal);
                        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $paidAmount);
                        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $overdueTotal);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArray);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->applyFromArray($styleArray);
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->applyFromArray($styleArray);
                        $objPHPExcel->getActiveSheet()->getStyle('L' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $objPHPExcel->getActiveSheet()->getStyle('N' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $rowCount++;
                        $rowCount++;
                        $balanceTotal = 0;
                        $paidAmount = 0;
                        $overdueTotal = 0;
                    }
                    $currentCustomer = $data->businessname;
                }
                $balanceTotal += $data->inv_total_cost;
                $paidAmount += $data->pfp_import;
                $overdueTotal += $data->overdue;

                $sumBalanceTotal += $data->inv_total_cost;
                $sumPaidAmount += $data->pfp_import;
                $sumOverdueTotal += $data->overdue;

                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $data->businessname);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $data->email);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $data->businesstelephone);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $data->inv_booking_id);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $data->inv_number);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $data->nome_centri);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $data->inv_date);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $data->due_date);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $data->arrival_date);
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $data->departure_date);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $data->inv_total_cost);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $data->pfp_import);
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $data->overdue);
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $data->status);
                $rowCount++;

                if ($rowsCount == 0) {
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $currentCustomer);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $balanceTotal);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $paidAmount);
                    $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $overdueTotal);
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('L' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('N' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $rowCount++;
                }
            }

            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $sumBalanceTotal);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $sumPaidAmount);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $sumOverdueTotal);

            $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('I3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('J3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('K3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('L3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('M3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('N3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('O3')->applyFromArray($styleArray);

            $objPHPExcel->getActiveSheet()->getStyle('L' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('N' . $rowCount)->applyFromArray($styleArrayWithUnderline);

            header('Content-Type: application/vnd.openxmlformats-   officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Agent_detailed_debtors_report.xlsx"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        }
    }

    /**
     * This function is used to set auto width for excel cell
     * @param type $objPHPExcel
     * @param type $rangeColFrom
     * @param type $rangeColTo 
     * @author SK
     * @since 16 June 2017
     */
    function setColumnAutoWidth($objPHPExcel, $rangeColFrom, $rangeColTo) {
        for ($col = $rangeColFrom; $col !== $rangeColTo; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }
    }

    /*
     * this function handles summary export to excel.
     */
    public function exportSummary() {
        if ($this->session->userdata('role') == 100) {
            $campuses = $this->input->post('campuses');
            $agents = $this->input->post('agents');
            $sqlPart = $this->sqlPart($campuses, $agents);
            $reportData = $this->invoice->getSummaryData($sqlPart);
            $this->load->library('excel_180');
            $objPHPExcel = new PHPExcel();

            $rowCount = 4;
            $this->setColumnAutoWidth($objPHPExcel, "B", "G");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice summary debtor report');
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', date('d/m/Y'));
            $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Customer');
            $objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Customer Email');
            $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Customer Telephone');
            $objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Total Balance');
            $objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Not Yet Due');
            $objPHPExcel->getActiveSheet()->SetCellValue('G3', 'Overdue');
            foreach ($reportData as $data) {
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $data->businessname);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $data->email);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $data->businesstelephone);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $data->total_cost);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $data->pfp_import);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $data->overdue);
                $rowCount++;
            }
            $totals = $this->getDefaultTotals($reportData);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, @$totals['balanceTotal']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, @$totals['dueTotal']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, @$totals['overdueTotal']);

            $styleArray = array(
                'font' => array(
                    'bold' => true,
            ));

            $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($styleArray);

            $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount)->applyFromArray($styleArray);

            ob_start();
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();

            $response = array(
                'file_name' => 'invoice_summary',
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
            );
            echo json_encode($response);
            exit(0);
        }
    }
    
    /**
     * This function is used to generate invoice
     * debt statistics
     * @author SK
     * @since 16 Jun 2017 
     */
    function debtorsstatistics(){
        if ($this->session->userdata('role') == 100) {
            $data["contaCentri"] = $this->mbackoffice->getAllCampus(1);
            $data["agents"] = $this->mbackoffice->getAllAgencies();
            $data['title'] = 'plus-ed.com | Daily debtors statistics';
            $data['breadcrumb1'] = 'Invoice summary';
            $data['breadcrumb2'] = 'Daily debtors statistics';
            $data['pageHeader'] = "Daily debtors statistics";
            $data['optionalDescription'] = "";
            $data['campusId'] = 0;
            $data['calFromDate'] = date("d/m/Y");
            $calFromDate = date("Y-m-d");
            $data['calToDate'] = date('d/m/Y', strtotime($calFromDate . ' + 15 days'));
            $reportData = array();
            if(!empty($_POST)){
                $campusId = $this->input->post('selCampus');
                $calFromDate = $this->input->post('txtCalFromDate');
                $calToDate = $this->input->post('txtCalToDate');
                $data['calFromDate'] = $calFromDate;
                $data['calToDate'] = $calToDate;
                $data['campusId'] = $campusId;
                if (!empty($calFromDate) && !empty($calToDate)) {
                    $calFromDate = explode('/', $calFromDate);
                    $calToDate = explode('/', $calToDate);
                    if (array_key_exists(2, $calFromDate))
                        $calFromDate = $calFromDate[2] . '-' . $calFromDate[1] . '-' . $calFromDate[0];
                    if (array_key_exists(2, $calToDate))
                        $calToDate = $calToDate[2] . '-' . $calToDate[1] . '-' . $calToDate[0];
                }
                
                $begin = new DateTime( date("Y-m-d",  strtotime($calFromDate)) );
                $end = new DateTime( date("Y-m-d",  strtotime($calToDate)) );
                
                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($begin, $interval, $end);
                foreach ( $period as $dt )
                {
                    $todaysDate = $dt->format( "Y-m-d" );
                    $result = $this->invoice->getDataDailyDebtors($campusId, $todaysDate);
                    if(count($result))
                    {
                        if($result[0]['total_cost'] != null)
                            array_push($reportData, $result[0]);
                    }
                }
            }
            $data['reportData'] = $reportData;
            $this->ltelayout->view('lte/backoffice/invoice/daily_debtors_statistics', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }
    
    /**
     * This function is used to generated due report view
     * @author SK
     * @since 20 Jun 2017   
     */
    function duereport(){
        if ($this->session->userdata('role') == 100) {
            $data['title'] = 'plus-ed.com | Invoice due report';
            $data['breadcrumb1'] = 'Invoice summary';
            $data['breadcrumb2'] = 'Invoice due report';
            $data['pageHeader'] = "Invoice due report";
            $data['optionalDescription'] = "";
            $calFromDate = date("Y-m-d");
            $calToDate = date('Y-m-d', strtotime($calFromDate . ' + 30 days'));
            $data['calToDate'] = $calToDate;
            $data['calFromDate'] = $calFromDate;
            $data['reportType'] = "Due";
            $data['reportData'] = $this->invoice->getDueReport($calFromDate,$calToDate);
            $this->ltelayout->view('lte/backoffice/invoice/invoice_due_report', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }
    
    
    /**
     * This function is used to generated overdue report view
     * @author SK
     * @since 20 Jun 2017   
     */
    function overduereport(){
        if ($this->session->userdata('role') == 100) {
            $data['title'] = 'plus-ed.com | Invoice overdue report';
            $data['breadcrumb1'] = 'Invoice summary';
            $data['breadcrumb2'] = 'Invoice overdue report';
            $data['pageHeader'] = "Invoice overdue report";
            $data['optionalDescription'] = "";
            $calToDate = date('Y-m-d');
            $calFromDate = date("Y-m-d",strtotime("2017-06-01"));
            $data['calToDate'] = $calToDate;
            $data['calFromDate'] = $calFromDate;
            $data['reportType'] = "Overdue";
            $data['reportData'] = $this->invoice->getDueReport($calFromDate,$calToDate);
            $this->ltelayout->view('lte/backoffice/invoice/invoice_due_report', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }
    
    /**
     * This is used to export both the report to excelfile
     * Due report 
     * and 
     * Overdue report
     * @author SK
     * @since 20 Jun 2017 
     */
    function dueoverdueexport(){
        if ($this->session->userdata('role') == 100) {
            $reportType = $this->input->post("hiddReportType");
            $calFromDate = date("Y-m-d");
            $calToDate = date('Y-m-d', strtotime($calFromDate . ' + 30 days'));
            if($reportType == "Due")
            {
                $calFromDate = date("Y-m-d");
                $calToDate = date('Y-m-d', strtotime($calFromDate . ' + 30 days'));
            }
            elseif($reportType == "Overdue"){
                $calToDate = date('Y-m-d');
                $calFromDate = date("Y-m-d",strtotime("2017-06-01"));
            }
            
            $reportData = $this->invoice->getDueReport($calFromDate,$calToDate);
            $this->load->library('excel_180');
            $objPHPExcel = new PHPExcel();

            $rowCount = 4;
            $this->setColumnAutoWidth($objPHPExcel, "B", "O");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice '.  strtolower($reportType).' report for date: '.date('d/m/Y',strtotime($calFromDate)).' - '.date('d/m/Y',strtotime($calToDate)));
            $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Arrival date');
            $objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Invoices total');
            $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Cashed total');
            $objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Overdue total');
            $objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Day\'s');
            
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                )
            );
            $styleArrayWithUnderline = array(
                'font' => array(
                    'bold' => true,
                    'underline' => PHPExcel_Style_Font::UNDERLINE_DOUBLE
                )
            );

            $areaCode = "";
            $balanceTotal = 0;
            $paidAmount = 0;
            $overdueTotal = 0;

            $sumBalanceTotal = 0;
            $sumPaidAmount = 0;
            $sumOverdueTotal = 0;

            $rowsCount = count($reportData);
            $objPHPExcel->getActiveSheet()->mergeCells('B1:F1');
            foreach ($reportData as $data) {
                if ($areaCode != $data['valuta_fattura']) {
                    if ($rowCount != 4) {
                        // AREA CODE TOTAL
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Area ".getCurrencyArea($areaCode));
                        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, customNumFormat($balanceTotal));
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, customNumFormat($paidAmount));
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($overdueTotal));
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $rowCount++;
                        $rowCount++;
                        $balanceTotal = 0;
                        $paidAmount = 0;
                        $overdueTotal = 0;
                    }
                    $areaCode = $data['valuta_fattura'];
                    $objPHPExcel->getActiveSheet()->mergeCells('B'.$rowCount.':F'.$rowCount);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Area ".getCurrencyArea($areaCode));
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $rowCount++;
                }
                $balanceTotal += $data['total_cost'];
                $paidAmount += $data['pfp_import'];
                $overdueTotal += $data['overdue'];

                $sumBalanceTotal += $data['total_cost'];
                $sumPaidAmount += $data['pfp_import'];
                $sumOverdueTotal += $data['overdue'];
                // ROWS
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, date("d/m/Y",strtotime($data['arrival_date'])));
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, customNumFormat($data['total_cost']));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, customNumFormat($data['pfp_import']));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($data['overdue']));
                $dateFrom = date_create($data['arrival_date']);
                $dateTo = date_create(date("Y-m-d"));
                $diff = date_diff($dateFrom,$dateTo);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $diff->days);
                $rowCount++;

                if ($rowsCount == 0) {
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $rowCount++;
                }
            }
            // AREA CODE TOTAL
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Area ".getCurrencyArea($areaCode));
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, customNumFormat($balanceTotal));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, customNumFormat($paidAmount));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($overdueTotal));
            $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            
            // GROSS TOTAL
            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Total");
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, customNumFormat($sumBalanceTotal));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, customNumFormat($sumPaidAmount));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($sumOverdueTotal));

            $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($styleArray);

            $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);

            header('Content-Type: application/vnd.openxmlformats-   officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Duerepport_export.xlsx"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            redirect('backoffice', 'refresh');
        }
    }
    
    
    /**
     * This function is used to generated invoice debt for modal box
     * getting all records for specific date
     * @author SK
     * @since 20 Jun 2017   
     */
    function get_booking_report(){
        $bookingIds = $this->input->post('bookingIds');
        $data['reportData'] = $this->invoice->getBookingDebtReport($bookingIds);
        $this->load->view('lte/backoffice/invoice/booking_debt', $data);
    }
    
    /**
     * This function is used to generated invoice debt for modal box 
     * getting all records for specific agent
     * @author SK
     * @since 20 Jun 2017   
     */
    function get_agentwise_report(){
        $agentId = $this->input->post('agentId');
        $data['reportData'] = $this->invoice->getAgentDebtReport($agentId);
        $this->load->view('lte/backoffice/invoice/agent_debt', $data);
    }
    
    /**
     * This function is used to export date wise data in excel
     * getting all records for specific date
     * @author SK
     * @since 20 Jun 2017   
     */
    function datewiseexport()
    {
        $bookingIds = $this->input->post('hiddBookingIds');
        $reportDate = $this->input->post('hiddDate');
        $reportData = $this->invoice->getBookingDebtReport($bookingIds);
        if($reportData)
        {
            $this->load->library('excel_180');
            $objPHPExcel = new PHPExcel();

            $rowCount = 4;
            $this->setColumnAutoWidth($objPHPExcel, "B", "O");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice debt report for booking(s) on: '.date('d/m/Y',strtotime($reportDate)));
            $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Booking ID');
            $objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Agent');
            $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Invoices total');
            $objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Cashed total');
            $objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Overdue total');
            $objPHPExcel->getActiveSheet()->SetCellValue('G3', 'Day\'s');
            
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                )
            );
            $styleArrayWithUnderline = array(
                'font' => array(
                    'bold' => true,
                    'underline' => PHPExcel_Style_Font::UNDERLINE_DOUBLE
                )
            );

            $areaCode = "";
            $balanceTotal = 0;
            $paidAmount = 0;
            $overdueTotal = 0;

            $sumBalanceTotal = 0;
            $sumPaidAmount = 0;
            $sumOverdueTotal = 0;

            $rowsCount = count($reportData);
            $objPHPExcel->getActiveSheet()->mergeCells('B1:G1');
            foreach ($reportData as $data) {
                if ($areaCode != $data['valuta_fattura']) {
                    if ($rowCount != 4) {
                        // AREA CODE TOTAL
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Area ".getCurrencyArea($areaCode));
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, customNumFormat($balanceTotal));
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($paidAmount));
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, customNumFormat($overdueTotal));
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $rowCount++;
                        $rowCount++;
                        $balanceTotal = 0;
                        $paidAmount = 0;
                        $overdueTotal = 0;
                    }
                    $areaCode = $data['valuta_fattura'];
                    $objPHPExcel->getActiveSheet()->mergeCells('B'.$rowCount.':F'.$rowCount);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Area ".getCurrencyArea($areaCode));
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $rowCount++;
                }
                $balanceTotal += $data['total_cost'];
                $paidAmount += $data['pfp_import'];
                $overdueTotal += $data['overdue'];

                $sumBalanceTotal += $data['total_cost'];
                $sumPaidAmount += $data['pfp_import'];
                $sumOverdueTotal += $data['overdue'];
                // ROWS
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $data['id_book']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, htmlentities(ucwords($data['agent_name'])));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, customNumFormat($data['total_cost']));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($data['pfp_import']));
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, customNumFormat($data['overdue']));
                $dateFrom = date_create($data['arrival_date']);
                $dateTo = date_create(date("Y-m-d"));
                $diff = date_diff($dateFrom,$dateTo);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $diff->days);
                $rowCount++;

                if ($rowsCount == 0) {
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $rowCount++;
                }
            }
            // AREA CODE TOTAL
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Area ".getCurrencyArea($areaCode));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, customNumFormat($balanceTotal));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($paidAmount));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, customNumFormat($overdueTotal));
            $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            
            // GROSS TOTAL
            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Total");
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, customNumFormat($sumBalanceTotal));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($sumPaidAmount));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, customNumFormat($sumOverdueTotal));

            $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($styleArray);

            $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->applyFromArray($styleArrayWithUnderline);

            header('Content-Type: application/vnd.openxmlformats-   officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="datewiserepport_export.xlsx"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        }
        else{
            redirect("invoice/duereport");
        }
    }
    
    /**
     * This function is used to export agent wise data in excel
     * getting all records for specific agent
     * @author SK
     * @since 20 Jun 2017   
     */
    function agentwiseexport()
    {
        $agentId = $this->input->post('hiddAgentId');
        $agentName = $this->input->post('hiddAgentName');
        $reportData = $this->invoice->getAgentDebtReport($agentId);
        if($reportData)
        {
            $this->load->library('excel_180');
            $objPHPExcel = new PHPExcel();

            $rowCount = 4;
            $this->setColumnAutoWidth($objPHPExcel, "B", "O");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice debt report for agent: '.htmlentities(ucwords($agentName)));
            $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Booking ID');
            $objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Arrival date');
            $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Campus');
            $objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Invoices total');
            $objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Cashed total');
            $objPHPExcel->getActiveSheet()->SetCellValue('G3', 'Overdue total');
            $objPHPExcel->getActiveSheet()->SetCellValue('H3', 'Day\'s');
            
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                )
            );
            $styleArrayWithUnderline = array(
                'font' => array(
                    'bold' => true,
                    'underline' => PHPExcel_Style_Font::UNDERLINE_DOUBLE
                )
            );

            $areaCode = "";
            $balanceTotal = 0;
            $paidAmount = 0;
            $overdueTotal = 0;

            $sumBalanceTotal = 0;
            $sumPaidAmount = 0;
            $sumOverdueTotal = 0;

            $rowsCount = count($reportData);
            $objPHPExcel->getActiveSheet()->mergeCells('B1:H1');
            foreach ($reportData as $data) {
                if ($areaCode != $data['valuta_fattura']) {
                    if ($rowCount != 4) {
                        // AREA CODE TOTAL
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Area ".getCurrencyArea($areaCode));
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($balanceTotal));
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, customNumFormat($paidAmount));
                        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, customNumFormat($overdueTotal));
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                        $rowCount++;
                        $rowCount++;
                        $balanceTotal = 0;
                        $paidAmount = 0;
                        $overdueTotal = 0;
                    }
                    $areaCode = $data['valuta_fattura'];
                    $objPHPExcel->getActiveSheet()->mergeCells('B'.$rowCount.':H'.$rowCount);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Area ".getCurrencyArea($areaCode));
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $rowCount++;
                }
                $balanceTotal += $data['total_cost'];
                $paidAmount += $data['pfp_import'];
                $overdueTotal += $data['overdue'];

                $sumBalanceTotal += $data['total_cost'];
                $sumPaidAmount += $data['pfp_import'];
                $sumOverdueTotal += $data['overdue'];
                // ROWS
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $data['id_book']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, date("d/m/Y",strtotime($data['arrival_date'])));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, htmlentities($data['nome_centri']));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($data['total_cost']));
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, customNumFormat($data['pfp_import']));
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, customNumFormat($data['overdue']));
                $dateFrom = date_create($data['arrival_date']);
                $dateTo = date_create(date("Y-m-d"));
                $diff = date_diff($dateFrom,$dateTo);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $diff->days);
                $rowCount++;

                if ($rowsCount == 0) {
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount)->applyFromArray($styleArrayWithUnderline);
                    $rowCount++;
                }
            }
            // AREA CODE TOTAL
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Area ".getCurrencyArea($areaCode));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($balanceTotal));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, customNumFormat($paidAmount));
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, customNumFormat($overdueTotal));
            $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            
            // GROSS TOTAL
            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Total");
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, customNumFormat($sumBalanceTotal));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, customNumFormat($sumPaidAmount));
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, customNumFormat($sumOverdueTotal));

            $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($styleArray);

            $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            
            $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->applyFromArray($styleArrayWithUnderline);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount)->applyFromArray($styleArrayWithUnderline);

            header('Content-Type: application/vnd.openxmlformats-   officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="agentwise_export.xlsx"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        }
        else{
            redirect("invoice/duereport");
        }
    }

}

/* End of file invoice.php */
