<?php

/**
 * Class to control contract section
 * @since 14-MAR-2016
 * @author SK
 * 
 */
class Contract extends Controller {

    public function __construct() {

        parent::Controller();
        authSessionMenu($this);
        $this->load->helper(array('url','mpdf6'));
        $this->load->library('session');
        $this->load->model("tuition/contractmodel", "contractmodel");
        $this->load->model("tuition/teachersappmodel", "teachersappmodel");
    }

    /**
     * function to show contrat details
     * @author SK
     * @since 14-Mar-2016
     */
    function index() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Contract";
            $data['breadcrumb1'] = 'Job and contracts';
            $data['breadcrumb2'] = 'Manage contract';
            $data['contractdata'] = $this->contractmodel->getContractData();
            if(APP_THEME == 'OLD'){
                $this->load->view('tuition/plused_manage_contract', $data);
            }
            else{
                $data['pageHeader'] = "Manage contract";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/contract/manage_contract', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to display the add/edit option of contract
     * @author SK
     * @since 15-Mar-2016
     * @param int $edit_id
     */
    function addedit($edit_id = 0, $contract_app_id = 0) {
        if (!is_numeric($edit_id))
            $edit_id = 0;
        $data['contract_app_id'] = $contract_app_id;
        $this->load->library('form_validation');
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $frDate = explode('/', $this->input->post('fd'));
            $tDate = explode('/', $this->input->post('td'));
            if (array_key_exists(2, $frDate)) {
                $frDate = $frDate[2] . '-' . $frDate[1] . '-' . $frDate[0];
            }
            if (array_key_exists(2, $tDate)) {
                $tDate = $tDate[2] . '-' . $tDate[1] . '-' . $tDate[0];
            }
            $formData = array(
                'selApplicant' => trim($this->input->post('selApplicant')),
                'txtEmail' => trim($this->input->post('txtEmail')),
                'selPosition' => trim($this->input->post('selPosition')),
                'txtConFromDate' => $this->input->post('fd') ? $frDate : '',
                'txtConToDate' => $this->input->post('td') ? $tDate : '',
                'selCampus' => trim($this->input->post('selCampus')),
                'txtSalary' => trim($this->input->post('txtSalary')),
                'selCurrency' => trim($this->input->post('selCurrency')),
                'selResidential' => trim($this->input->post('selResidential')),
                'txtHoursPerWeek' => trim($this->input->post('txtHoursPerWeek')),
                'selExtraActivity' => trim($this->input->post('selExtraActivity')),
                'selBoard' => trim($this->input->post('selBoard')),
                'rdoReturnee' => trim($this->input->post('rdoReturnee')),
                'rdoContractSigned' => trim($this->input->post('rdoContractSigned')),
                'txtAddress' => trim($this->input->post('txtAddress')),
                'txtCity' => trim($this->input->post('txtCity')),
                'selPostCode' => trim($this->input->post('selPostCode')),
                'selCountry' => trim($this->input->post('selCountry')),
                'selWages' => trim($this->input->post('selWages'))
            );
            $data['edit_id'] = $edit_id;
             
            if (!empty($_POST['btnSave'])) {
                $formVal = array(
                    array(
                        'field' => 'selApplicant',
                        'label' => 'Appplicant',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'selPosition',
                        'label' => 'Position',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'fd',
                        'label' => 'From Date',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'td',
                        'label' => 'To Date',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'selCampus',
                        'label' => 'Campus',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'txtSalary',
                        'label' => 'Salary',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'selCurrency',
                        'label' => 'Currency',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'txtHoursPerWeek',
                        'label' => 'Hours/aweek',
                        'rules' => 'required'
                    )
                );
                $this->form_validation->set_rules($formVal);
                if ($this->form_validation->run() == TRUE) {
                    $applicantid = $this->input->post('selApplicant');
                    $emailAddress = $this->input->post('txtEmail');
                    $position = $this->input->post('selPosition');
                    $fromDate = $this->input->post('fd');
                    $toDate = $this->input->post('td');
                    $campus = $this->input->post('selCampus');
                    $salary = $this->input->post('txtSalary');
                    $currency = $this->input->post('selCurrency');
                    $hoursWeek = $this->input->post('txtHoursPerWeek');
                    $residential = $this->input->post('selResidential');
                    $extraActivity = $this->input->post('selExtraActivity');
                    $board = $this->input->post('selBoard');
                    $returnee = $this->input->post('rdoReturnee') == 'on' ? 1 : 0;
                    $contractSinged = $this->input->post('rdoContractSigned') == '1' ? 1 : 0;

                    $address = trim($this->input->post('txtAddress'));
                    $city = trim($this->input->post('txtCity'));
                    $postcode = trim($this->input->post('selPostCode'));
                    $country = trim($this->input->post('selCountry'));
                    $wages = trim($this->input->post('selWages'));

                    $fromDate = explode('/', $fromDate);
                    $toDate = explode('/', $toDate);
                    if (array_key_exists(2, $fromDate)) {
                        $fromDate = $fromDate[2] . '-' . $fromDate[1] . '-' . $fromDate[0];
                    }
                    if (array_key_exists(2, $toDate)) {
                        $toDate = $toDate[2] . '-' . $toDate[1] . '-' . $toDate[0];
                    }
                    $isDateRangeValid = TRUE;
                    if (strtotime($fromDate) == strtotime($toDate)) {
                        $isDateRangeValid = FALSE;
                    } elseif (strtotime($fromDate) > strtotime($toDate)) {
                        $isDateRangeValid = FALSE;
                    }
                    //$isDateValid = $this->contractmodel->checkDateRange($fromDate, $toDate, $applicantid);
                    $isDateValid = $isValidEdit = $this->contractmodel->checkDateRangeEdit($fromDate, $toDate, $applicantid, $edit_id);
                    
                    if ($isDateRangeValid) {
                        if ($edit_id) {
                            if ($isValidEdit) {
                                $update_data = array(
                                    'joc_application_id' => $applicantid,
                                    'joc_email' => $emailAddress,
                                    'joc_position_id' => $position,
                                    'joc_from_date' => $fromDate,
                                    'joc_to_date' => $toDate,
                                    'joc_campus_id' => $campus,
                                    'joc_salary' => $salary,
                                    'joc_currency' => $currency,
                                    'joc_res_non_res' => $residential,
                                    'joc_hourperweek_range' => $hoursWeek,
                                    'joc_extra_activities' => $extraActivity,
                                    'job_board_as' => $board,
                                    'joc_returnee' => $returnee,
                                    'joc_contract_signed' => $contractSinged,
                                    'joc_address' => $address,
                                    'joc_city' => $city,
                                    'joc_postcode' => $postcode,
                                    'joc_country' => $country,
                                    'joc_wages' => $wages
                                );

                                $result = $this->contractmodel->operations('update', $update_data, $edit_id);
                                if ($result) {
                                    $this->session->set_flashdata('success_message', 'Record updated successfully.');
                                    redirect('contract');
                                } else {
                                    $data['error_message'] = 'Unable to add record';
                                }
                            } else {
                                $data['error_message'] = 'Contract range already exists.';
                            }
                        } else {
                            if ($isDateValid) {
                                $insert_data = array(
                                    'joc_application_id' => $applicantid,
                                    'joc_email' => $emailAddress,
                                    'joc_position_id' => $position,
                                    'joc_from_date' => $fromDate,
                                    'joc_to_date' => $toDate,
                                    'joc_campus_id' => $campus,
                                    'joc_salary' => $salary,
                                    'joc_currency' => $currency,
                                    'joc_res_non_res' => $residential,
                                    'joc_hourperweek_range' => $hoursWeek,
                                    'joc_extra_activities' => $extraActivity,
                                    'job_board_as' => $board,
                                    'joc_returnee' => $returnee,
                                    'joc_contract_signed' => $contractSinged,
                                    'joc_address' => $address,
                                    'joc_city' => $city,
                                    'joc_postcode' => $postcode,
                                    'joc_country' => $country,
                                    'joc_wages' => $wages,
                                    'joc_created_on' => date('Y-m-d H:i:s')
                                );
                                $result = $this->contractmodel->operations('insert', $insert_data);
                                if ($result) {
                                    $this->session->set_flashdata('success_message', 'Record added successfully.');
                                    if (!empty($emailAddress)) {
                                        $applicantData = $this->contractmodel->getApplicantDetails($applicantid);
                                        if($applicantData)
                                        {
                                            if($currency == "EUR")
                                                $currencySymbol = "&euro;";
                                            else if($currency == "GBP")
                                                $currencySymbol = "&pound;";
                                            else if($currency == "USD")
                                                $currencySymbol = "$";

                                            //Get position from its id
                                            $contractPosition = $this->contractmodel->getPositionsName($position);
                                            $contractCampus = $this->contractmodel->getCampusName($campus);

                                            $templateData = array(
                                                                'recName' => $applicantData->ta_firstname ." ". $applicantData->ta_lastname,
                                                                'recAddress' => $address,
                                                                'recCity' => $city,
                                                                'recPostcode' => $postcode,
                                                                'recCountry' => $country,
                                                                'recWages' => $wages,
                                                                'recCurrencySymbol' => $currencySymbol,
                                                                'recSalary' => $salary,
                                                                'recFromDate' => $fromDate,
                                                                'recToDate' => $toDate,
                                                                'contractPosition' => $contractPosition,
                                                                'contractCampus' => $contractCampus,
                                                                'workHours' => $hoursWeek,
                                                                'boardAs' => $board,
                                                            );
                                            ob_start(); // start output buffer
                                            $this->load->view('tuition/email/pdf_job_contract_template', $templateData);
                                            $templateBody = ob_get_contents(); // get contents of buffer
                                            ob_end_clean();

                                                $academicContractFile = 'academic_contract_' . time();
                                                if (!file_exists(ACADEMIC_CONTRACT_FILE_PATH)) {
                                                    mkdir(ACADEMIC_CONTRACT_FILE_PATH, 0755,true);
                                                }
                                                //writeHtmlPdfAndSave($templateBody,$academicContractFile,ACADEMIC_CONTRACT_FILE_PATH);
                                                writeHtmlPdfAndSaveJobContract($templateBody,$academicContractFile,ACADEMIC_CONTRACT_FILE_PATH);
                                                $academicContractFile = $academicContractFile . ".pdf";
                                                // update file to database
                                                $updateContract = array(
                                                    'joc_contract_file' =>$academicContractFile
                                                ); 
                                                $this->contractmodel->operations('update', $updateContract,$result);
                                            // END OF FILE(ATTACHMENT)
                                            
                                            $senderEmail = PLUS_SENDER_EMAIL_ADDRESS;
                                            $receiverEmail = $emailAddress;
                                            $messageBody = "";
                                            $data['teacherName'] = $applicantData->ta_firstname ." ". $applicantData->ta_lastname ;
                                            $data['teacherEmail'] = $applicantData->ta_email;
                                            $data['loginUrl'] = base_url().'index.php/users';
                                            $randomPassword = random_string();
                                            $data['randomPassword'] = $randomPassword;
                                            ob_start(); // start output buffer
                                            $this->load->view('tuition/email/job_contract_template', $data);
                                            $messageBody = ob_get_contents(); // get contents of buffer
                                            ob_end_clean();
                                            $this->load->library('email');
                                            $this->email->set_newline("\r\n");
                                            $this->email->from($senderEmail, 'plus-ed.com');
                                            $this->email->to($receiverEmail);
                                            $this->email->subject("plus-ed.com | Contract");
                                            $this->email->message($messageBody);
                                            //$attachFile = FCPATH . 'pdf/job_contract.pdf';
                                            //$this->email->attach($attachFile);
                                            $this->email->send();
                                            
                                            // store users password in application table
                                            $updateArr = array(
                                                'ta_password' => md5($randomPassword)
                                            );
                                            $this->teachersappmodel->operations('update',$updateArr,$applicantid);
                                            // end of update
                                        }
                                    }
                                    redirect('contract');
                                } else {
                                    $data['error_message'] = 'Unable to add record';
                                }
                            } else {
                                $data['error_message'] = 'Contract range already exists';
                            }
                        }
                    } else {
                        $data['error_message'] = 'Invalid date range';
                    }
                } else {
                   
                    $formData = array(
                        'selApplicant' => trim($this->input->post('selApplicant')),
                        'txtEmail' => trim($this->input->post('txtEmail')),
                        'selPosition' => trim($this->input->post('selPosition')),
                        'txtConFromDate' => trim($this->input->post('fd')),
                        'txtConToDate' => trim($this->input->post('td')),
                        'selCampus' => trim($this->input->post('selCampus')),
                        'txtSalary' => trim($this->input->post('txtSalary')),
                        'selCurrency' => trim($this->input->post('selCurrency')),
                        'selResidential' => trim($this->input->post('selResidential')),
                        'txtHoursPerWeek' => trim($this->input->post('txtHoursPerWeek')),
                        'selExtraActivity' => trim($this->input->post('selExtraActivity')),
                        'selBoard' => trim($this->input->post('selBoard')),
                        'rdoReturnee' => trim($this->input->post('rdoReturnee') == 'on' ? 1 : 0),
                        'rdoContractSigned' => trim($this->input->post('rdoContractSigned') == '1' ? 1 : 0),
                        'txtAddress' => trim($this->input->post('txtAddress')),
                        'txtCity' => trim($this->input->post('txtCity')),
                        'selPostCode' => trim($this->input->post('selPostCode')),
                        'selCountry' => trim($this->input->post('selCountry')),
                        'selWages' => trim($this->input->post('selWages')),
                    );
                }
            } else {
                if ($edit_id) {
                    // get contract details for edit purpose
                    $contractdetails = $this->contractmodel->getData($edit_id); // $this->session->userdata('id')	
                    if ($contractdetails) {
                        $contractdetails = $contractdetails[0];
                        $formData = array(
                            'selApplicant' => $contractdetails['ta_id'],
                            'txtEmail' => $contractdetails['joc_email'],
                            'selPosition' => $contractdetails['pos_id'],
                            'txtConFromDate' => $contractdetails['joc_from_date'],
                            'txtConToDate' => $contractdetails['joc_to_date'],
                            'selCampus' => $contractdetails['id'],
                            'txtSalary' => $contractdetails['joc_salary'],
                            'selCurrency' => $contractdetails['joc_currency'],
                            'selResidential' => $contractdetails['joc_res_non_res'],
                            'txtHoursPerWeek' => $contractdetails['joc_hourperweek_range'],
                            'selExtraActivity' => $contractdetails['joc_extra_activities'],
                            'selBoard' => $contractdetails['job_board_as'],
                            'rdoReturnee' => $contractdetails['joc_returnee'],
                            'rdoContractSigned' => $contractdetails['joc_contract_signed'],
                            'txtAddress' => $contractdetails['joc_address'],
                            'txtCity' => $contractdetails['joc_city'],
                            'selPostCode' => $contractdetails['joc_postcode'],
                            'selCountry' => $contractdetails['joc_country'],
                            'selWages' => $contractdetails['joc_wages'],
                        );
                    }
                }
            }
            
            $data['title'] = "plus-ed.com | Add/Edit contract";
            $data['breadcrumb1'] = 'Job and contracts';
            $data['breadcrumb2'] = 'Add/Edit contract';
            $data['applicants'] = $this->contractmodel->getApplicantDetails();
            $data['positions'] = $this->contractmodel->getPositionData();
            $data['campuses'] = $this->contractmodel->getCampusData();
            $data['formData'] = $formData;
            $data["postcodeData"] = $this->teachersappmodel->getPostcodeData();
            if(APP_THEME == 'OLD'){
                    $this->load->view('tuition/plused_contract_add_edit', $data);
            }
            else{
                $data['pageHeader'] = "";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/contract/add_edit_contract', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }
    
    /**
     * deleteContract
     * This function is used to remove contract form system
     * @author SK
     * @since 15-Mar-2016
     * @param int $edit_id
     */
    function deleteContract($edit_id = 0) {
        $result = $this->contractmodel->operations('delete', null, $edit_id);
        if ($result) {
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('contract');
        } else {
            $this->session->set_flashdata('error_message', 'Unable to delete record.');
            redirect('contract');
        }
    }

    /**
     * contract_change_status
     * This function is used to toggle contract active status.
     * @author SK
     * @since 15-Mar-2015
     */
    function contract_change_status() {
        $teacherId = $this->input->post('id');
        $teacherStatus = $this->input->post('status');
        if ($teacherStatus == 1) {// change status to update..
            $teacherStatus = 0;
        } else {
            $teacherStatus = 1;
        }
        $udpateData = array(
            'joc_is_active' => $teacherStatus
        );
        $result = $this->contractmodel->operations('changestatus', $udpateData, $teacherId);
        if ($result) {
            if($teacherStatus)
                echo json_encode(array('result' => 1, 'message' => 'Contract activated successfully.', 'status' => $teacherStatus));
            else
                echo json_encode(array('result' => 1, 'message' => 'Contract deactivated successfully.', 'status' => $teacherStatus));
        }
        else
            echo json_encode(array('result' => 0, 'message' => 'Unable to change contract active/inactive status.'));
    }
    
    
    /**
     * change_academic_contract_status
     * This function is used to toggle contract status.
     * @author SK
     * @since 29-Apr-2015
     */
    function change_academic_contract_status() {
        $conId = $this->input->post('con_id');
        $conStatus = $this->input->post('con_status');
        if ($conStatus == 1) {// change contract status to update..
            $conStatus = 0;
        } else {
            $conStatus = 1;
        }
        $udpateData = array(
            'joc_contract_signed' => $conStatus
        );
        $result = $this->contractmodel->operations('changestatus', $udpateData, $conId);
        if ($result) {
            echo json_encode(array('result' => 1, 'message' => 'Contract status changed successfully.', 'status' => $conStatus));
        }
        else
            echo json_encode(array('result' => 0, 'message' => 'Unable to change contract status.'));
    }
    
    
    /**
     * Function to export the contract details as xls
     * @author SK
     * @since 16-Mar-2016
     */
    function exportcontract() {
        $contractData = $this->contractmodel->getContractData();
        $exportData = array();
        if (!empty($contractData)) {
            foreach ($contractData as $contract) {
                $exportRecord = array(
                    'Name' => htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']),
                    'Campus' => $contract["nome_centri"],
                    'Email' => $contract["joc_email"],
                    'Position' => $contract["pos_position"],
                    'From date' => date('d/m/Y', strtotime($contract["joc_from_date"])),
                    'To date' => date('d/m/Y', strtotime($contract["joc_to_date"])),
                    'Hours per week' => $contract["joc_hourperweek_range"],
                    'Wages' => $contract["joc_wages"],
                    'Salary' => $contract["joc_salary"],
                    'Currency' => $contract["joc_currency"],
                    'Residential' => $contract["joc_res_non_res"],
                    'Extra activities' => $contract["joc_extra_activities"],
                    'Returnee' => $contract["joc_is_active"] == 1 ? 'Active' : 'Inactive',
                    'Address' => $contract["joc_address"],
                    'City' => $contract["joc_city"],
                    'Postcode' => $contract["joc_postcode"],
                    'Country' => $contract["joc_country"],
                );
                array_push($exportData, $exportRecord);
            }
            $this->load->library('export');
            $this->export->to_excel($exportData, 'contract_details');
        } else {
            $this->session->set_flashdata('success_message', 'No records to export.');
            redirect('contract', 'refresh');
        }
    }

    public function getApplicantProfile() {
        $applicantId = $this->input->post('applicantId');
        $resultSet = $this->contractmodel->getApplicantDetails($applicantId);
        $resultData = array('status' => 0, 'result' => array());
        if ($resultSet) {
            $result = array(
                'email' => $resultSet->ta_email,
                'postcode' => $resultSet->ta_postcode,
                'address' => $resultSet->ta_address,
                'city' => $resultSet->ta_city,
                'country' => $resultSet->ta_country
            );
            echo json_encode(array('status' => 1, 'result' => $result));
        }
        else
            echo json_encode($resultData);
    }
    
    
    public function payrolls($selectedYear = "") {
        
        $conractData = $this->contractmodel->getContractPayrolls($selectedYear);
        
        $exportData = array();
        if($conractData)
        {
            
            foreach($conractData as $record){
                $NiCategory = "";
                /* 
                 * write M if the teacher is under 21 year when contract starts
                   write A if the teacher is over 21 years and under 65 years when contract starts
                   and write C if the teacher is over 65 years old
                 */
                if(!empty($record['ta_date_of_birth']) && $record['ta_date_of_birth'] != "0000-00-00 00:00:00")
                {
                    $age = date_diff(date_create($record['ta_date_of_birth']), date_create('today'))->y;
                    if($age < 21)
                        $NiCategory = "M";
                    elseif($age >= 21 && $age < 65)
                        $NiCategory = "A";
                    elseif ($age >= 65) {
                        $NiCategory = "C";
                    }
                }
                
                $p45 = "";
                if($record['ta_p45_status'] == 0)
                    $p45 = $record['ta_p45_starter_declaration'];
                else if($record['ta_p45_status'] == 1)
                    $p45 = "YES";
                    
                $exportRecord = array(
                    'Employee No' => '',
                    'Surname' => $record['ta_lastname'],
                    'Forename' => $record['ta_firstname'],
                    'Address1' => $record['ta_address'],
                    'Address2' => $record['ta_city'],
                    'Address3' => $record['ta_country'],
                    'Postcode' => $record['ta_postcode'],
                    'Email' => $record['joc_email'],
                    'Nationality' => ucwords($record['ta_nationality']),
                    'DateOfBirth' => $record['ta_date_of_birth'],
                    'Gender' => $record['ta_sex'],
                    'NiNumber' => $record['ta_ni_number'],
                    'NiCategory' => $NiCategory,
                    'PaymentMethod' => '',
                    'SortCode' => $record['tbd_sort_code'],
                    'AccountNumber' => $record['tbd_account_number'],
                    'CurrencyType' => $record['tbd_currency_type'],
                    'IBAN' => $record['tbd_iban'],
                    'SWIFT/BIC' => $record['tbd_swift_bic'],
                    'AccountName' => $record['tbd_account_name'],
                    'CostCode' => $record['nome_centri'],
                    'Department' => $record['pos_position'],
                    'StartDate' => $record['joc_from_date'],
                    'EndDate' => $record['joc_to_date'],
                    'Wages' => $record['joc_wages'],//joc_wages,joc_salary,joc_currency
                    'Salary' => $record['joc_salary'],
                   // 'Currency' => $record['joc_currency'],
                    'SR Plan' => $record['ta_slr_plan'],
                    'P45 Status' => $p45,
                    'Passport' => (empty($record['ta_passport_or_id_card']) ? '' : base_url(). PASSPORT_ID_CARD_FILE . $record['ta_passport_or_id_card']),
                );
                array_push($exportData, $exportRecord);
            }
            $this->load->library('export');
            $dateCols = array("DateOfBirth", "StartDate","EndDate");
            $colStringArray = array("O","P");
            $this->export->exportUsingPhpExcelWithLink($exportData, 'Contract_payrolls', $dateCols, $colStringArray);
        }
        else
            redirect ('contract');
    }

}
