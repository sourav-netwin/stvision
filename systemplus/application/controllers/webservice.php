<?php

/**
 * Class to control import data from webservice section
 * @since 21-June-2016
 * @author Preeti M
 *
 */
class Webservice extends Controller {

    public function __construct() {

        parent::Controller();

        $this->load->helper(array('form', 'url', 'mpdf6'));
        $this->load->library('session', 'email');
        $this->load->model('webservicemodel');
    }

    /**
     * function to display dashboard
     * @author Preeti M
     * @since 21-June-2016
     */
    function index() {
        if ($this->session->userdata('role') == 550) { // webservice_user
            $this->load->helper('string');
            $data['title'] = "plus-ed.com | Webservice";
            $data['breadcrumb1'] = 'Dashboard - ST history data reports';
            $data['breadcrumb2'] = '';

            if (APP_THEME == "OLD")
                $this->load->view('plused_webservice', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = "Dashboard - ST history data reports";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/wsimports/dashboard', $data);
            }
        } elseif ($this->session->userdata('role') == 551) { //reimbursement
            $this->load->helper('string');
            $data['title'] = "plus-ed.com | Webservice";
            $data['breadcrumb1'] = 'Dashboard - reimbursement';
            $data['breadcrumb2'] = '';

            if (APP_THEME == "OLD")
                $this->load->view('plused_webservice', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = "Dashboard - reimbursement";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/reimbursement/dashboard', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * function to import data returned from webservice
     * @author Preeti M
     * @since 21-June-2016
     */
    function import() {
        if ($this->session->userdata('role') == 550 || $this->session->userdata('role') == 551) {
            $data['title'] = "plus-ed.com | Import file";
            $data['breadcrumb1'] = 'Webservice management';
            $data['breadcrumb2'] = 'Import file';

            if (!empty($_POST)) {
                // Code added for testing, i.e. static JSON response to be saved to DB
                // $file = '../teacherApplications/getWsRimborsi.json';
                // $json_data = json_decode(file_get_contents($file));
                // $result = $this->importJsonContent( $json_data );
                // Webservice call that returns JSON data
                $wsdl_url = 'http://devtours.studytours.it/ws/vision.asmx?wsdl';
                $client = new SoapClient($wsdl_url, array('soap_version' => SOAP_1_1));
                $params = array(
                    '_UserId' => 'visioN@0315',
                    '_Psw' => 'j%asbwY3'
                );
                $wsresult = $client->getPrenotazioniRimborsi($params);
                $jsonR = $wsresult->getPrenotazioniRimborsiResult;
                $json_data = json_decode($jsonR, true);
                $result = $this->importJsonContent($json_data);

                if ($result['failed'] == 0) {
                    $this->session->set_flashdata("success_message", $result['success'] . " of " . $result['total'] . " records imported successfully.");
                    redirect('webservice/index');
                } else {
                    $this->session->set_flashdata("error_message", $result['failed'] . " of " . $result['total'] . " records failed to import successfully.");
                    redirect('webservice/index');
                }
            }

            if (APP_THEME == "OLD")
                $this->load->view('plused_webservice_import', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/reimbursement/webservice_import', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * function to import JSON data to DB
     * @author Preeti M
     * @since 21-June-2016
     */
    private function importJsonContent($json_data) {
        $this->db->truncate('webservice_book');

        $total_records = count($json_data);
        $insert_array = array();
        //print_r($json_data[0]);
        for ($i = 0; $i < $total_records; $i++) {
            $insert_data['id_prenotazione'] = $json_data[$i]["IdPrenotazione"];
            $insert_data['id_passeggero'] = $json_data[$i]["IdPasseggero"];
            $insert_data['passeggero'] = $json_data[$i]["Passeggero"];
            $insert_data['tipologia_passeggero'] = $json_data[$i]["TipologiaPasseggero"];
            $insert_data['glf'] = $json_data[$i]["GLF"];
            $insert_data['glf_id_genitore'] = $json_data[$i]["GLFIdGenitore"];
            $insert_data['glf_genitore_nominativo'] = $json_data[$i]["glfGenitoreNominativo"];
            $insert_data['id_accompagnatore'] = $json_data[$i]["IdAccompagnatore"];
            $insert_data['accompagnatore'] = $json_data[$i]["Accompagnatore"];
            $insert_data['id_collaboratore'] = $json_data[$i]["IdCollaboratore"];
            $insert_data['collaboratore'] = $json_data[$i]["Collaboratore"];
            $insert_data['codice_prodotto'] = $json_data[$i]["CodiceProdotto"];
            $insert_data['prodotto'] = $json_data[$i]["Prodotto"];
            $insert_data['codice_destinazione'] = $json_data[$i]["CodiceDestinazione"];
            $insert_data['destinazione'] = $json_data[$i]["Destinazione"];
            $insert_data['data_iniziale'] = getDateFromJSONString($json_data[$i]["DataIniziale"]);
            $insert_data['data_finale'] = getDateFromJSONString($json_data[$i]["DataFinale"]);
            $insert_data['sistemazione'] = $json_data[$i]["Sistemazione"];
            $insert_data['costo_base'] = $json_data[$i]["CostoBase"];
            $insert_data['importo_tasse_volo'] = $json_data[$i]["importoTasseVolo"];
            $insert_data['importo_aeroporto_aggiuntivo'] = $json_data[$i]["importoAeroportoAggiuntivo"];
            $insert_data['supplementi'] = $json_data[$i]["Supplementi"];
            $insert_data['trinity'] = $json_data[$i]["Trinity"];
            $insert_data['magic_eu'] = $json_data[$i]["MagicEu"];
            $insert_data['sup_magic_eu'] = $json_data[$i]["SupMagicEu"];
            $insert_data['magic_usa'] = $json_data[$i]["MagicUsa"];
            $insert_data['sup_magic_usa'] = $json_data[$i]["SupMagicUsa"];
            $insert_data['pagamenti'] = $json_data[$i]["Pagamenti"];

            $insert_id = $this->webservicemodel->operations('insert', $insert_data);
            array_push($insert_array, $insert_id);
        }

        $successfull_import = $failed_import = 0;
        for ($i = 0; $i < $total_records; $i++) {
            if ($insert_array[$i] <= 0)
                $failed_import++;
            else
                $successfull_import++;
        }

        return array('success' => $successfull_import, 'failed' => $failed_import, 'total' => $total_records);
    }

    /**
     * function to display search filter and data for reports
     * @author Preeti M
     * @since 22-June-2016
     */
    function report() {
        if ($this->session->userdata('role') == 550 || $this->session->userdata('role') == 551) {
            if (!empty($_POST)) {
                if (isset($_POST['type'])) {
                    $data['accompagnatore'] = $this->input->post('txtAccompagnatore');
                    $data['collaboratore'] = $this->input->post('txtCollaboratore');
                    $data['prodotto'] = $this->input->post('txtProdotto');
                    $data['codice_prodotto'] = $this->input->post('txtCodiceProdotto');
                    $data['passeggero'] = $this->input->post('txtPasseggero');
                    $data['tipologia_passeggero'] = $this->input->post('selTipologiaPasseggero');
                    $data['glf'] = $this->input->post('selGlf');

                    $getData = array('accompagnatore' => $data['accompagnatore'], 'collaboratore' => $data['collaboratore'], 'prodotto' => $data['prodotto'], 'codice_prodotto' => $data['codice_prodotto'], 'passeggero' => $data['passeggero'], 'tipologia_passeggero' => $data['tipologia_passeggero'], 'glf' => $data['glf']);

                    $resultData = $this->webservicemodel->getReportData($getData);
                    if ($resultData) {
                        $exportData = array();
                        foreach ($resultData as $record) {
                            $total_due = $record["costo_base"] + $record["importo_tasse_volo"] + $record["importo_aeroporto_aggiuntivo"] + $record["supplementi"];
                            $balance = round(( $total_due - $record["pagamenti"]), 2);

                            $exportRecord = array(
                                'Accompagnatore' => $record['accompagnatore'],
                                'Collaboratore' => $record['collaboratore'],
                                'Prodotto' => $record['prodotto'],
                                'Codice Prodotto' => $record['codice_prodotto'],
                                'Passeggero' => $record['passeggero'],
                                'Tipologia Passeggero' => $record['tipologia_passeggero'],
                                'Total Due' => $total_due,
                                'Balance' => $balance
                            );
                            array_push($exportData, $exportRecord);
                        }
                        $this->load->library('export');
                        $this->export->to_excel($exportData, 'webservicereport');
                    } else
                        redirect('webservice');
                }
                else {
                    $data['title'] = 'plus-ed.com | Webservice data report';
                    $data['breadcrumb1'] = 'Webservice management';
                    $data['breadcrumb2'] = 'Webservice data report';
                    $data['accompagnatore'] = $this->input->post('txtAccompagnatore');
                    $data['collaboratore'] = $this->input->post('txtCollaboratore');
                    $data['prodotto'] = $this->input->post('txtProdotto');
                    $data['codice_prodotto'] = $this->input->post('txtCodiceProdotto');
                    $data['passeggero'] = $this->input->post('txtPasseggero');
                    $data['tipologia_passeggero'] = $this->input->post('selTipologiaPasseggero');
                    $data['glf'] = $this->input->post('selGlf');

                    $getData = array('accompagnatore' => $data['accompagnatore'], 'collaboratore' => $data['collaboratore'], 'prodotto' => $data['prodotto'], 'codice_prodotto' => $data['codice_prodotto'], 'passeggero' => $data['passeggero'], 'tipologia_passeggero' => $data['tipologia_passeggero'], 'glf' => $data['glf']);

//                    $data['report_data'] = $this->webservicemodel->getReportData($getData);

                    if (APP_THEME == "OLD")
                        $this->load->view('plused_webservice_report_data', $data);
                    else { // if(APP_THEME == "LTE")
                        $data['pageHeader'] = $data['breadcrumb2'];
                        $data['optionalDescription'] = "";
                        $this->ltelayout->view('lte/reimbursement/webservice_report_data', $data);
                    }
                }
            } else {
                $data['title'] = 'plus-ed.com | Webservice data report';
                $data['breadcrumb1'] = 'Webservice management';
                $data['breadcrumb2'] = 'Webservice data report';

                $data['tipologia_passeggero'] = $this->webservicemodel->getDistinctDataByField('tipologia_passeggero');
                $data['glf'] = $this->webservicemodel->getDistinctDataByField('glf');
                $data['accompagnatore'] = $this->webservicemodel->getDistinctDataByField('accompagnatore');
                $data['collaboratore'] = $this->webservicemodel->getDistinctDataByField('collaboratore');
                $data['codice_prodotto'] = $this->webservicemodel->getDistinctDataByField('codice_prodotto');

                if (APP_THEME == "OLD")
                    $this->load->view('plused_webservice_report', $data);
                else { // if(APP_THEME == "LTE")
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/reimbursement/webservice_report', $data);
                }
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    public function getReport() {
        if ($this->session->userdata('role') == 550 || $this->session->userdata('role') == 551) {
            $request = $_REQUEST;
            $searchData = array(
                'accompagnatore' => $request['txtAccompagnatore'],
                'collaboratore' => $request['txtCollaboratore'],
                'prodotto' => $request['txtProdotto'],
                'codice_prodotto' => $request['txtCodiceProdotto'],
                'passeggero' => $request['txtPasseggero'],
                'tipologia_passeggero' => $request['selTipologiaPasseggero'],
                'glf' => $request['selGlf']
            );
            $param = datatable_param($request, 'accompagnatore', 'asc');
            $reportData = $this->webservicemodel->paginateReportData($searchData, $param);
            $reportCount = $this->webservicemodel->getReportCount($searchData);
            if (empty($reportData)) {
                $reportData = array();
            } else {
                $reportData = $this->makeData($reportData);
            }
            echo datatable_json($request['draw'], $reportCount, $reportData);
            exit(0);
        }
    }

    /**
     * function to format total due and balance for the report data
     * @author Arunsankar
     * @since 25-May-2017
     */
    private function makeData($reportData) {
        if (!empty($reportData)) {
            foreach ($reportData as $key => $report) {
                $reportData[$key]['total_due'] = round($report["total_due"], 2);
                $reportData[$key]['balance'] = round($report["balance"], 2);
            }
            return $reportData;
        }
    }

    /**
     * function to display search filter and data for GL reports
     * @author Preeti M
     * @since 29-June-2016
     */
    function glReport() {
        if ($this->session->userdata('role') == 550 || $this->session->userdata('role') == 551) {
            if (!empty($_POST)) {
                if (isset($_POST['type'])) {
                    if ($_POST['type'] == "pdf") {
                        $collaboratore = $this->input->post('txtCollaboratore');
                        $accompagnatore = $this->input->post('txtAccompagnatore');

                        $glExportReportData = $this->_getGlReportData($collaboratore, $accompagnatore);
                        $data['report_table_data'] = $glExportReportData['report_table_data'];

                        $pdfFileName = "Webservice_Report";
                        $reportHTML = $this->load->view("webservice_report_view", $data, TRUE);
                        downloadhtmltopdf($reportHTML, $pdfFileName);
                    } else {
                        $collaboratore = $this->input->post('txtCollaboratore');
                        $accompagnatore = $this->input->post('txtAccompagnatore');

                        $glExportReportData = $this->_getGlReportData($collaboratore, $accompagnatore);
                        $report_data = $glExportReportData['report_table_data'];
                        $grand_total = $passeggero_start = $passeggero_si_start = 0;
                        $exportData = array();
                        $prev_codice_prodotto = '';
                        foreach ($report_data as $rdata) {
                            $passeggero_start = ( $prev_codice_prodotto != $rdata['codice_prodotto'] ) ? 0 : $passeggero_start;
                            $passeggero_si_start = ( $prev_codice_prodotto != $rdata['codice_prodotto'] ) ? 0 : $passeggero_si_start;

                            if ($rdata['codice_prodotto'] != 'Total') {
                                if ($rdata['pax'] > 1 && ( $rdata['type'] == 'Reimbursement' || $rdata['type'] == 'Presentation' )) {
                                    $passeggero_arr = $this->webservicemodel->getPasseggero($rdata['collaboratore'], $rdata['accompagnatore'], $rdata['codice_prodotto']);
                                    $passeggero = explode(",", $passeggero_arr['passeggero']);
                                    for ($i = 0; $i < $rdata['pax']; $i++) {
                                        $pax = 1;
                                        $total = $rdata['amount_per_pax'] * $pax;
                                        $grand_total = $grand_total + $total;
                                        $pass = isset($passeggero[$passeggero_start])?$passeggero[$passeggero_start]:'';
                                        $exportData[] = array(
                                            'Collaboratore' => $rdata['collaboratore'],
                                            'Accompagnatore' => $rdata['accompagnatore'],
                                            'Campus' => $rdata['campus'],
                                            'Product Code' => $rdata['codice_prodotto'],
                                            'Pax Name' => $pass,
                                            'Type' => $rdata['type'],
                                            'Group' => $rdata['group'],
                                            'Pax' => $pax,
                                            'Amount Per Pax' => $rdata['amount_per_pax'],
                                            'Total' => $total
                                        );
                                        $passeggero_start++;
                                    }
                                } else if ($rdata['type'] == 'GLF') {
                                    $passeggero_arr = $this->webservicemodel->getPasseggeroSi($rdata['collaboratore'], $rdata['accompagnatore'], $rdata['codice_prodotto']);
                                    $passeggero = explode(",", $passeggero_arr['passeggero']);

                                    $total = $rdata['amount_per_pax'] * $rdata['pax'];
                                    $grand_total = $grand_total + $total;

                                    $exportData[] = array(
                                        'Collaboratore' => $rdata['collaboratore'],
                                        'Accompagnatore' => $rdata['accompagnatore'],
                                        'Campus' => $rdata['campus'],
                                        'Product Code' => $rdata['codice_prodotto'],
                                        'Pax Name' => $passeggero[$passeggero_si_start],
                                        'Type' => $rdata['type'],
                                        'Group' => $rdata['group'],
                                        'Pax' => $rdata['pax'],
                                        'Amount Per Pax' => $rdata['amount_per_pax'],
                                        'Total' => $rdata['total_reimbursement']
                                    );
                                    $passeggero_si_start++;
                                } else {
                                    $total = $rdata['amount_per_pax'] * $rdata['pax'];
                                    $grand_total = $grand_total + $total;

                                    $exportData[] = array(
                                        'Collaboratore' => $rdata['collaboratore'],
                                        'Accompagnatore' => $rdata['accompagnatore'],
                                        'Campus' => $rdata['campus'],
                                        'Product Code' => $rdata['codice_prodotto'],
                                        'Pax Name' => ( $rdata['type'] == 'Reimbursement' || $rdata['type'] == 'Presentation' ) ? $rdata['passeggero'] : "",
                                        'Type' => $rdata['type'],
                                        'Group' => $rdata['group'],
                                        'Pax' => $rdata['pax'],
                                        'Amount Per Pax' => $rdata['amount_per_pax'],
                                        'Total' => $rdata['total_reimbursement']
                                    );
                                }
                            }
                            $prev_codice_prodotto = $rdata['codice_prodotto'];
                        }
                        if (!empty($exportData)) {
                            // Empty row before total
                            $exportData[] = array(
                                'Collaboratore' => '',
                                'Accompagnatore' => '',
                                'Campus' => '',
                                'Product Code' => '',
                                'Pax Name' => '',
                                'Type' => '',
                                'Group' => '',
                                'Pax' => '',
                                'Amount Per Pax' => '',
                                'Total' => ''
                            );

                            $exportData[] = array(
                                'Collaboratore' => 'Total',
                                'Accompagnatore' => '',
                                'Campus' => '',
                                'Product Code' => '',
                                'Pax Name' => '',
                                'Type' => '',
                                'Group' => '',
                                'Pax' => '',
                                'Amount Per Pax' => '',
                                'Total' => $grand_total
                            );
                        }

                        $this->load->library('export');
                        $this->export->exportUsingPhpExcel($exportData, 'webserviceglreport');
                    }
                } else {
                    $data['title'] = 'plus-ed.com | Export by GL';
                    $data['breadcrumb1'] = 'Webservice management';
                    $data['breadcrumb2'] = 'Export by GL';

                    $data['collaboratore'] = $this->input->post('txtCollaboratore');
                    $data['accompagnatore'] = $this->input->post('txtAccompagnatore');

                    $glReportData = $this->_getGlReportData($data['collaboratore'], $data['accompagnatore']);
                    $data['reportData'] = $glReportData['report_data'];
                    $data['report_table_data'] = $glReportData['report_table_data'];
                    $data['report_analysis_data'] = $glReportData['report_analysis_data'];

                    if (APP_THEME == "OLD")
                        $this->load->view('plused_webservice_gl_report_data', $data);
                    else { // if(APP_THEME == "LTE")
                        $data['pageHeader'] = $data['breadcrumb2'];
                        $data['optionalDescription'] = "";
						//echo "<pre>";print_r($data);die;
                        $this->ltelayout->view('lte/reimbursement/webservice_gl_report_data', $data);
                    }
                }
            } else {
                $data['title'] = 'plus-ed.com | Export by GL';
                $data['breadcrumb1'] = 'Webservice management';
                $data['breadcrumb2'] = 'Export by GL';

                $data['accompagnatore'] = $this->webservicemodel->getDistinctDataByField('accompagnatore');
                $data['collaboratore'] = $this->webservicemodel->getDistinctDataByField('collaboratore');

                if (APP_THEME == "OLD")
                    $this->load->view('plused_webservice_gl_report', $data);
                else { // if(APP_THEME == "LTE")
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/reimbursement/webservice_gl_report', $data);
                }
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * function to get GLReport data
     * @author Preeti M
     * @since 13-July-2016
     */
    private function _getGlReportData($collaboratore, $accompagnatore) {
        $gl_report_data = $this->webservicemodel->getGlReportData($collaboratore, $accompagnatore);

        $reimbursement_eligibility_criteria = $this->webservicemodel->eligibilityCriteria('RIMBORSO');
        $double_turn_eligibility_criteria = $this->webservicemodel->eligibilityCriteria('BONUS DOPPIO TURNO');

        $report_data = $report_table_data = $report_analysis_data = array();
        foreach ($gl_report_data as $key => $gr_data) {
            $column_array = array();
            $total_columns = $gr_data['total_gl_rows'];
            $total_pax = 0;

            for ($i = $total_columns; $i > 0; $i--) {
                $pax_per_group = floor(( $gr_data['total_rows_cleared'] - $total_pax ) / $i);
                $column_array['Group ' . $i] = $pax_per_group;
                $total_pax = $total_pax + $pax_per_group;
            }

            $report_data[] = array(
                'collaboratore' => $gr_data['collaboratore'],
                'accompagnatore' => $gr_data['accompagnatore'],
                'codice_prodotto' => $gr_data['codice_prodotto'],
                'rows_including_gl' => $gr_data['total_rows_including_gl'],
                'rows_excluding_gl' => $gr_data['total_rows_excluding_gl'],
                'rows_excluding_gl_si' => $gr_data['total_rows_excluding_gl_si'],
                'rows_cleared' => $gr_data['total_rows_cleared'],
                'gl_rows' => $gr_data['total_gl_rows'],
                'additional_columns' => $column_array
            );
            $gl_report_data[$key]['groups'] = $column_array;
        }
		

        // Report table data
        $grand_total = $trinity_total = $magic_bonus_total = 0;
        $group_details = array();

        $db_eligibility = 0;
        foreach ($gl_report_data as $gr_data) {
            if (trim($gr_data['collaboratore']) == trim($gr_data['accompagnatore'])) {
                $country = $this->webservicemodel->getCountryForProduct($gr_data['codice_prodotto']);
                if ($country != '') {
                    if ($gr_data['total_rows_cleared'] >= $reimbursement_eligibility_criteria[$country]) {
                        if ($gr_data['total_rows_cleared'] >= $double_turn_eligibility_criteria[$country]) {
                            $db_eligibility++;
                        }
                    }
                }
            }
        }

        $mb_eligibility = 0;
        foreach ($gl_report_data as $gr_data) {
            $magic_bonus_rows = $trinity_rows = 0;
            if (trim($gr_data['collaboratore']) == trim($gr_data['accompagnatore'])) {
                // Magic bonus and trinity calculation
                $country = $this->webservicemodel->getCountryForProduct($gr_data['codice_prodotto']);
                //var_dump($reimbursement_eligibility_criteria[$country]);die;
                if ($country != '') {
                    foreach ($gr_data['groups'] as $group_name => $group) {
                        if ($group >= $reimbursement_eligibility_criteria[$country]) {
                            $mb_eligibility++;
                        }
                    }
                    if ($mb_eligibility > 0) {
                        $rowsData = $this->webservicemodel->getMagicBonusTrinityRows($gr_data['codice_prodotto'], $gr_data['collaboratore'], $gr_data['accompagnatore']);

                        if (!empty($rowsData)) {
                            // Magic bonus
                            $magic_bonus_rows = $rowsData['bonus_rows_cnt'];
                            $magic_bonus_total = $magic_bonus_total + $magic_bonus_rows;

                            // trinity
                            $trinity_rows = $rowsData['trinity_rows_cnt'];
                            $trinity_total = $trinity_total + $trinity_rows;
                        }
                    }
                }

                if (!empty($gr_data['groups'])) { 
                    $i = 0;

                    foreach ($gr_data['groups'] as $group_name => $group) {
                        $i++;
                        $accomodation = $country = $level = '';
                        $rimborso_bonus = $double_turn_bonus = 0;
                        $reimbursement = $double_turn_reimbusement = $total_reimbursement = 0;

                        $country = $this->webservicemodel->getCountryForProduct($gr_data['codice_prodotto']);
                        if ($country != '') {
                            if ($group >= $reimbursement_eligibility_criteria[$country]) {
                                $pax_data = $this->webservicemodel->getReportTableData($gr_data['codice_prodotto'], $group);
                                if (!empty($pax_data)) {
                                    foreach ($pax_data as $pdata) {
                                        $accomodation = $pdata['accomodation'];
                                        $country = $pdata['country'];
                                        $level = $pdata['level'];

                                        if (strpos($pdata['service'], 'RIMBORSO') !== false)
                                            $rimborso_bonus = $pdata['reimbursement'];
                                        else if (strpos($pdata['service'], 'BONUS DOPPIO TURNO') !== false)
                                            $double_turn_bonus = ( $db_eligibility > 1 ) ? $pdata['reimbursement'] : 0;
                                    }
                                }

                                $reimbursement = $rimborso_bonus;
                                if ($reimbursement > 0) {
                                    // Double turn bonus
                                    if ($group >= $double_turn_eligibility_criteria[$country]) {
                                        $double_turn_reimbusement = $double_turn_bonus;
                                    }
                                }

                                $total_reimbursement = $reimbursement * $group;
                                $grand_total = $grand_total + $total_reimbursement;
                            }
                        }

                        if ($group > 0 && $reimbursement > 0) {
                            // Report table data
                            $report_table_data[] = array(
                                'collaboratore' => $gr_data['collaboratore'],
                                'accompagnatore' => $gr_data['accompagnatore'],
                                'campus' => $gr_data['prodotto'],
                                'codice_prodotto' => $gr_data['codice_prodotto'],
                                'passeggero' => $gr_data['passeggero'],
                                'accomodation' => $accomodation,
                                'type' => 'Reimbursement',
                                'group' => 'Group ' . $i,
                                'country' => $country,
                                'level' => $level,
                                'pax' => $group,
                                'amount_per_pax' => $reimbursement,
                                'total_reimbursement' => $total_reimbursement
                            );
                        }

                        if ($double_turn_reimbusement > 0) {
                            // Double turn Bonus
                            $total_reimbursement = $double_turn_reimbusement * $group;
                            $grand_total = $grand_total + $total_reimbursement;

                            $report_table_data[] = array(
                                'collaboratore' => $gr_data['collaboratore'],
                                'accompagnatore' => $gr_data['accompagnatore'],
                                'campus' => $gr_data['prodotto'],
                                'codice_prodotto' => $gr_data['codice_prodotto'],
                                'passeggero' => $gr_data['passeggero'],
                                'accomodation' => $accomodation,
                                'type' => 'Double Session',
                                'group' => 'Group ' . $i,
                                'country' => $country,
                                'level' => $level,
                                'pax' => $group,
                                'amount_per_pax' => $double_turn_reimbusement,
                                'total_reimbursement' => $total_reimbursement
                            );
                        }

                        $group_details[$group_name][] = array(
                            'reimbursement' => $reimbursement,
                            'double_turn_reimbusement' => $double_turn_reimbusement
                        );
                    }
                }

                if ($magic_bonus_rows > 0) {
                    // Magic Bonus
                    $total_reimbursement = $magic_bonus_rows * EXTRA_REIMBURSEMENT;
                    $grand_total = $grand_total + $total_reimbursement;

                    $report_table_data[] = array(
                        'collaboratore' => $gr_data['collaboratore'],
                        'accompagnatore' => $gr_data['accompagnatore'],
                        'campus' => $gr_data['prodotto'],
                        'codice_prodotto' => $gr_data['codice_prodotto'],
                        'passeggero' => $gr_data['passeggero'],
                        'accomodation' => '',
                        'type' => 'Magic Bonus',
                        'group' => '',
                        'country' => '',
                        'level' => '',
                        'pax' => $magic_bonus_rows,
                        'amount_per_pax' => EXTRA_REIMBURSEMENT,
                        'total_reimbursement' => $total_reimbursement
                    );
                }

                // Si rows
                $si_row_total = 0;
                if ($gr_data['si_rows'] != '') {
                    foreach (explode(",", $gr_data['si_rows']) as $si_row) {
                        $si_row_total = $si_row_total + $si_row;
                        $report_table_data[] = array(
                            'collaboratore' => $gr_data['collaboratore'],
                            'accompagnatore' => $gr_data['accompagnatore'],
                            'campus' => $gr_data['prodotto'],
                            'codice_prodotto' => $gr_data['codice_prodotto'],
                            'passeggero' => $gr_data['passeggero'],
                            'accomodation' => '',
                            'type' => 'GLF',
                            'group' => '',
                            'country' => '',
                            'level' => '',
                            'pax' => '1',
                            'amount_per_pax' => $si_row,
                            'total_reimbursement' => $si_row
                        );
                    }
                }
                $grand_total = $grand_total + $si_row_total;

                if ($trinity_rows > 0) {
                    // Exam Bonus
                    $total_reimbursement = $trinity_rows * BONUS_EXAM_AMOUNT;
                    $grand_total = $grand_total + $total_reimbursement;

                    $report_table_data[] = array(
                        'collaboratore' => $gr_data['collaboratore'],
                        'accompagnatore' => $gr_data['accompagnatore'],
                        'campus' => $gr_data['prodotto'],
                        'codice_prodotto' => $gr_data['codice_prodotto'],
                        'passeggero' => $gr_data['passeggero'],
                        'accomodation' => '',
                        'type' => 'English Exam',
                        'group' => '',
                        'country' => '',
                        'level' => '',
                        'pax' => $trinity_rows,
                        'amount_per_pax' => BONUS_EXAM_AMOUNT,
                        'total_reimbursement' => $total_reimbursement
                    );
                }
            } else {
                if (empty($gr_data['groups']) && $gr_data['total_rows_cleared'] > 0) {
                    $presentation = $gr_data['costo_base'] * BONUS_PRESENTAZIONE_PERCENT;

                    $total_reimbursement = $presentation * $gr_data['total_rows_cleared'];
                    $grand_total = $grand_total + $total_reimbursement;

                    $report_table_data[] = array(
                        'collaboratore' => $gr_data['collaboratore'],
                        'accompagnatore' => $gr_data['accompagnatore'],
                        'campus' => $gr_data['prodotto'],
                        'codice_prodotto' => $gr_data['codice_prodotto'],
                        'passeggero' => $gr_data['passeggero'],
                        'accomodation' => '',
                        'type' => 'Presentation',
                        'group' => '',
                        'country' => '',
                        'level' => '',
                        'pax' => $gr_data['total_rows_cleared'],
                        'amount_per_pax' => $presentation,
                        'total_reimbursement' => $total_reimbursement
                    );
                }
            }
        }
		
		// Added >> Fee Accompagnamento
		if (!empty($report_table_data)) {
			if(FEE_ACCOMPAGNAMENTO)
			{
				$report_table_data[] = array(
					'collaboratore' => '',
					'accompagnatore' => '',
					'campus' => '',
					'codice_prodotto' => 'Fee Accompagnamento',
					'passeggero' => '',
					'accomodation' => '',
					'type' => '',
					'group' => '',
					'country' => '',
					'level' => '',
					'pax' => '',
					'amount_per_pax' => '',
					'total_reimbursement' => " - ".FEE_ACCOMPAGNAMENTO
				);
			}
        }

        if (!empty($report_table_data)) {
            $report_table_data[] = array(
                'collaboratore' => '',
                'accompagnatore' => '',
                'campus' => '',
                'codice_prodotto' => 'Total',
                'passeggero' => '',
                'accomodation' => '',
                'type' => '',
                'group' => '',
                'country' => '',
                'level' => '',
                'pax' => '',
                'amount_per_pax' => '',
                'total_reimbursement' => $grand_total
            );
        }

        ksort($group_details);
        foreach ($group_details as $group_name => $gdetail) {
            $reimbursement_eligibility = $double_turn_eligibility = 0;
            foreach ($gdetail as $group) {
                if ($group['reimbursement'] > 0)
                    $reimbursement_eligibility++;
                if ($group['double_turn_reimbusement'] > 0)
                    $double_turn_eligibility++;
            }
            $report_analysis_data[] = array(
                'group' => $group_name,
                'reimbursement_eligibility' => ( $reimbursement_eligibility > 0 ) ? 'Yes' : 'No',
                'double_turn_eligibility' => ( $double_turn_eligibility > 1 ) ? 'Yes' : 'No'
            );
        }
        $report_analysis_data[] = array(
            'magic_bonus_total' => $magic_bonus_total
        );
        $report_analysis_data[] = array(
            'trinity_total' => $trinity_total
        );


        $result = array(
            'report_data' => $report_data,
            'report_table_data' => $report_table_data,
            'report_analysis_data' => $report_analysis_data
        );
        return $result;
    }

    /**
     * function to get accompagnatore from collaboratore
     * @author Preeti M
     * @since 7-July-2016
     */
    function getAccompagnatore() {
        if ($this->session->userdata('role') == 550 || $this->session->userdata('role') == 551) {
            $txtCollaboratore = $this->input->post('txtCollaboratore');
            $accompagnatoreList = '';
            if ($txtCollaboratore != '')
                $accompagnatoreList = $this->webservicemodel->getAccompagnatoreFromCollaboratore($txtCollaboratore);

            if ($accompagnatoreList != '') {
                ?>
                <select id="txtAccompagnatore" name="txtAccompagnatore">
                    <option value="">Select Accompagnatore</option>
                    <option value="All">All</option>
                    <?php
                    if ($accompagnatoreList) {
                        foreach ($accompagnatoreList as $accompagnatore) {
                            ?>
                            <option value="<?php echo $accompagnatore; ?>"><?php echo $accompagnatore; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <?php
            } else {
                ?>
                <select id="txtAccompagnatore" name="txtAccompagnatore">
                    <option value="">Select Accompagnatore</option>
                </select>
                <?php
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    //End: functions by Preeti M
}

/* End of file webservice.php */