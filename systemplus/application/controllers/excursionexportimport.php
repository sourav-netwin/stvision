<?php

/**
 * Class to control Excursion Import and Export section
 * @since 18-MAR-2016
 * @author Arunsankar
 * @modified 12-APR-2016
 * @modified_by Arunsankar
 */
class Excursionexportimport extends Controller {

    public function __construct() {

        parent::Controller();
        if (!$this->session->userdata('role')) {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
        authSessionMenu($this);
        set_time_limit(EXPORT_TIME_LIMIT);
        ini_set('memory_limit', EXPORT_MEM_LIMIT);
        $this->load->helper(array('url'));
        $this->load->model("tuition/excursionexpimpmodel", "excursionexpimpmodel");
    }

    /**
     * Show import export UI
     * @author Arunsankar
     * @since 18-Mar-2016
     */
    function index() {
//        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Excursion Export and Import";
            $data['breadcrumb1'] = 'Excursion management';
            $data['breadcrumb2'] = 'Export and import';
            $data["centri"] = $this->excursionexpimpmodel->getMapCampusList();
            if (APP_THEME == 'OLD') {
                $this->load->view('tuition/excu_excusrsion_expimp', $data);
            } else {
                $data['pageHeader'] = "Export and import";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/excursion/export_import', $data);
            }
//        } else {
//            $this->session->sess_destroy();
//            redirect('backoffice', 'refresh');
//        }
    }

    /**
     * Function to export details as xls file
     * @author Arunsankar
     * @since 18-03-2016
     */
    function export() {

//        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            if (!empty($_POST['btnExport'])) {
                if (isset($_POST['campuses'][0])) {
                    $campuses = $this->input->post('campuses');
                    $exportRecord = $this->excursionexpimpmodel->getExportData($campuses);
                    $this->load->library('excel_180');
                    $this->load->library('zip');

                    $isNewSheet = 1;
                    $sheetno = 0;
                    $loopcount = 0;
                    $disconnect = 0;
                    $newsheet = $this->excel_180->createSheet($sheetno);
                    $this->excel_180->setActiveSheetIndex($sheetno);

                    //Making certain columns hidden
                    $newsheet->getColumnDimension('B')->setVisible(FALSE);
                    $newsheet->getColumnDimension('C')->setVisible(FALSE);
                    $newsheet->getColumnDimension('I')->setVisible(FALSE);
                    $newsheet->getColumnDimension('O')->setVisible(FALSE);

                    $rowCount = 1;
                    $filecount = 1;
                    $filearray = array();
                    $mastcount = sizeof($exportRecord);
                    $filename = '';
                    if ($exportRecord) {
                        foreach ($exportRecord as $export) {
                            if ($disconnect != 0) {//if new file generated then initialize library again
                                $sheetno = 0;
                                $this->load->library('excel_180');
                                $newsheet = $this->excel_180->createSheet($sheetno);
                                $this->excel_180->setActiveSheetIndex($sheetno);
                                //Making certain columns hidden
                                $newsheet->getColumnDimension('B')->setVisible(FALSE);
                                $newsheet->getColumnDimension('C')->setVisible(FALSE);
                                $newsheet->getColumnDimension('I')->setVisible(FALSE);
                                $newsheet->getColumnDimension('O')->setVisible(FALSE);
                                $disconnect = 0;
                            }
                            $newone = 0;
                            $column = 'A';
                            $export['jn_id'] = NULL;
                            $export['jn_price'] = NULL;
                            if ($isNewSheet == 1) {//if a new sheet then add heading
                                $headArray = array('jn_id', 'jn_id_exc', 'jn_id_campus', 'Campus', 'full/half day', 'Where', 'Planned/extra', 'Week', 'jn_id_bus', 'Company', 'Seats', 'jn_price', 'jn_cost', 'jn_budget', 'jn_currency', 'Currency');
                                $newsheet->fromArray($headArray, NULL, 'A1'); //heading place at first row
                                $rowCount += 1;
                            }
                            $isNewSheet = 0;
                            if (!empty($export)) {
                                foreach ($export as $key => $val) {
                                    $export[$key] = trim($val, '=');
                                }
                            }
                            $newsheet->fromArray($export, NULL, 'A' . $rowCount);
                            $filenm = $exportRecord[$loopcount]['nome_centri']; //setting file name
                            $sheetname = $exportRecord[$loopcount]['tra_cp_name']; //setting sheet name
                            if (strlen($exportRecord[$loopcount]['tra_cp_name']) > 31) {//if sheet name length is > 31 add dots
                                $sheetname = substr($exportRecord[$loopcount]['tra_cp_name'], 0, 27) . "...";
                            }
                            $rowCount += 1;
                            $newsheet->getStyle('A1:P1')->getFont()->setBold(true);
                            if (isset($exportRecord[$loopcount + 1]['tra_cp_name'])) {
                                if ($exportRecord[$loopcount + 1]['tra_cp_name'] != $exportRecord[$loopcount]['tra_cp_name']) {//if company name is differs, then create a new sheet
                                    $sheetno += 1;
                                    $newone += 1;
                                    $rowCount = 1;
                                    //setting protection for each sheet. if not sheet can be easily modified
                                    $newsheet->getProtection()->setPassword('G8#!H#t@2ZTVEW@');
                                    $newsheet->getProtection()->setSheet(TRUE);
                                    //making price fields editable 
                                    $newsheet->getStyle('L1:N' . $newsheet->getHighestDataRow())->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                                    $newsheet->setTitle($sheetname);
                                    //setting column width
                                    for ($col = 'A'; $col <= 'P'; $col++) {
                                        if ($col == 'L' OR $col == 'M' OR $col == 'N') {
                                            $newsheet->getColumnDimension($col)->setWidth(10); //setting width for price fields
                                        } else {
                                            $newsheet->getColumnDimension($col)->setAutoSize(TRUE); //setting auto size to columns
                                        }
                                    }
                                    //making some columns hidden
                                    $newsheet->getColumnDimension('B')->setVisible(FALSE);
                                    $newsheet->getColumnDimension('C')->setVisible(FALSE);
                                    $newsheet->getColumnDimension('I')->setVisible(FALSE);
                                    $newsheet->getColumnDimension('O')->setVisible(FALSE);

                                    $newsheet = $this->excel_180->createSheet($sheetno); //creating new sheet
                                }
                            } else {//if is the last sheet
                                $newsheet->getProtection()->setPassword('G8#!H#t@2ZTVEW@');
                                $newsheet->getProtection()->setSheet(TRUE);
                                $newsheet->getStyle('L1:N' . $newsheet->getHighestDataRow())->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                                for ($col = 'A'; $col <= 'P'; $col++) {
                                    if ($col == 'L' OR $col == 'M' OR $col == 'N') {
                                        $newsheet->getColumnDimension($col)->setWidth(10);
                                    } else {
                                        $newsheet->getColumnDimension($col)->setAutoSize(TRUE); //setting auto size to columns
                                    }
                                }
                                $newsheet->getColumnDimension('B')->setVisible(FALSE);
                                $newsheet->getColumnDimension('C')->setVisible(FALSE);
                                $newsheet->getColumnDimension('I')->setVisible(FALSE);
                                $newsheet->getColumnDimension('O')->setVisible(FALSE);
                                $newsheet->setTitle($sheetname);
                            }
                            if (isset($exportRecord[$loopcount + 1]['id'])) {
                                if ($exportRecord[$loopcount + 1]['id'] != $exportRecord[$loopcount]['id']) {//creating new excel file if another campus found
                                    $sheetno = 1;
                                    $newone += 1;
                                    $disconnect = 1;
                                    $rowCount = 1;
                                    $filename = $exportRecord[$loopcount]['nome_centri'] . '.xls';
                                    $writeObj = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
                                    $filecount += 1;
                                    $filearray[] = $filename;
                                    //Remove unwanted empty worksheet generating in each workbook 
                                    $workSheetArray = $this->excel_180->getSheetNames();
                                    $removeNum = 0;

                                    //removing empty sheets created at the end using index
                                    foreach ($workSheetArray as $key => $val) {
                                        if (strpos(trim($val), "Worksheet") === 0) {
                                            $this->excel_180->removeSheetByIndex($key - $removeNum);
                                            $removeNum += 1;
                                        }
                                    }

                                    header('Content-Type: application/application/vnd.ms-excel');
                                    header('Cache-Control: max-age=0');
                                    $writeObj->save(EXPORT_TEMP_PATH . $filename); //save file in server
                                }
                            } else {//if is last file
                                $filename = $filenm . '.xls';
                                $writeObj = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
                                $filecount += 1;
                                $filearray[] = $filename;
                                //Remove unwanted empty worksheet generating in each workbook 
                                $workSheetArray = $this->excel_180->getSheetNames();
                                $removeNum = 0;

                                //removing empty sheets created at the end using index
                                foreach ($workSheetArray as $key => $val) {
                                    if (strpos(trim($val), "Worksheet") === 0) {
                                        $this->excel_180->removeSheetByIndex($key - $removeNum);
                                        $removeNum += 1;
                                    }
                                }

                                header('Content-Type: application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                                header('Cache-Control: max-age=0');
                                $writeObj->save(EXPORT_TEMP_PATH . $filename); //save file in server
                                $downloadedFileCount = sizeof($filearray);
                            }
                            if ($newone > 0) {//if new file to be generated, then destroy all previous objects
                                $isNewSheet = 1;
                                if ($disconnect != 0) {
                                    $this->excel_180->__destruct();
                                }
                            }
                            $loopcount += 1;
                        }
                        for ($i = 0; $i < $downloadedFileCount; $i++) {
                            $this->zip->read_file(EXPORT_TEMP_PATH . $filearray[$i]); //read all files for add to zip
                        }
                        $this->zip->download('excursion_files.zip'); //download zip file through browser
                    } else {
                        $this->session->set_flashdata('error_message', 'No excursions found for the campus');
                        redirect('excursionexportimport');
                    }
                } else {
                    $this->session->set_flashdata('error_message', 'Please select atleast one campus');
                    redirect('excursionexportimport');
                }
            }

            if (!empty($_POST['btnExportResult'])) {//export final result
                $exportRecord = $this->excursionexpimpmodel->getExportResultData();
                $this->load->library('excel_180');
                $sheet = $this->excel_180->getActiveSheet();
                $exceldata = array();
                $exceldata[] = array('jn_id', 'jn_id_exc', 'jn_id_campus', 'Campus', 'full/half day', 'Where', 'Planned/extra', 'Week', 'jn_id_bus', 'Company', 'Seats', 'jn_price', 'jn_cost', 'jn_budget', 'jn_currency');
                if ($exportRecord) {
                    foreach ($exportRecord as $export) {
                        if (!empty($export)) {
                            foreach ($export as $key => $val) {
                                $export[$key] = trim($val, '=');
                            }
                        }
                        array_push($exceldata, $export);
                    }
                    //insert data into excel file
                    $sheet->fromArray($exceldata, NULL, 'A1');
                    $sheet->getStyle('A1:O1')->getFont()->setBold(true);
                    //setting color for each column
                    $sheet->getStyle('A1:C' . $sheet->getHighestDataRow())
                            ->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '80AFBF')
                                        )
                                    )
                    );
                    $sheet->getStyle('D1:H' . $sheet->getHighestDataRow())
                            ->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => 'A4BA9C')
                                        )
                                    )
                    );

                    $sheet->getStyle('I1:I' . $sheet->getHighestDataRow())
                            ->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '80AFBF')
                                        )
                                    )
                    );
                    $sheet->getStyle('J1:K' . $sheet->getHighestDataRow())
                            ->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => 'F5F500')
                                        )
                                    )
                    );

                    $sheet->getStyle('L1:N' . $sheet->getHighestDataRow())
                            ->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => 'A4BA9C')
                                        )
                                    )
                    );
                    $sheet->getStyle('O1:O' . $sheet->getHighestDataRow())
                            ->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '80AFBF')
                                        )
                                    )
                    );
                    $writeObj = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
                    $filename = 'join_result.xls';
                    header('Content-type: application/application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $filename . '"');
                    $writeObj->save('php://output'); //download file via browser
                } else {
                    $this->session->set_flashdata('error_message', 'No records found to export');
                    redirect('excursionexportimport');
                }
            }
//        } else {
//            $this->session->sess_destroy();
//            redirect('backoffice', 'refresh');
//        }
    }

    /**
     * Function for import the operator entered data
     * @author Arunsankar
     * @since 22-03-2016 
     */
    function import() {
        $this->load->library('excel_180');
//        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $errorCount = 0;
            $importCount = 0;
            if (!empty($_FILES['importFile']['name'][0])) {//if file is not empty
                $this->db->trans_start(); //begin transaction
                $this->_backupAllJoin(); //backup all data from exc_join table
                $this->excursionexpimpmodel->deleteAllJoin(); //delete all record from exc_join table
                $fileCount = sizeof($_FILES['importFile']['name']); //get total file count
                for ($i = 0; $i < $fileCount; $i++) {
                    if ($_FILES['importFile']['name'][$i] !== '') {
                        $mimes = array('application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //setting the file mime type(.xls, .xlsx)
                        if (in_array($_FILES['importFile']['type'][$i], $mimes)) {//validate file mime type
                            $fileName = $_FILES['importFile']['tmp_name'][$i];
                            try {
                                $fileType = PHPExcel_IOFactory::identify($fileName);
                                $objReader = PHPExcel_IOFactory::createReader($fileType);
                                $objPHPExcel = $objReader->load($fileName);
                                $sheets = array();
                                foreach ($objPHPExcel->getAllSheets() as $sheet) {
                                    $sheetsarray = $sheet->toArray();
                                    unset($sheetsarray[0]);
                                    foreach ($sheetsarray as $sheetVal) {
                                        //replace comma(,) with dot(.)
                                        $sheetVal[11] == str_replace(',', '.', $sheetVal[11]);
                                        $sheetVal[12] == str_replace(',', '.', $sheetVal[12]);
                                        $sheetVal[13] == str_replace(',', '.', $sheetVal[13]);
                                        $iscostvalid = TRUE;
                                        $isbudgetvalid = TRUE;
                                        if (!empty($sheetVal[12])) {
                                            if (!is_numeric($sheetVal[12])) {
                                                $iscostvalid = FALSE;
                                            }
                                        }
                                        if (!empty($sheetVal[13])) {
                                            if (!is_numeric($sheetVal[13])) {
                                                $isbudgetvalid = FALSE;
                                            }
                                        }
                                        if (!empty($sheetVal[11]) && is_numeric($sheetVal[11]) && sizeof($sheetVal) == 16 && $iscostvalid && $isbudgetvalid) {//validating price and row count
                                            $isCount = $this->excursionexpimpmodel->getImportCount($sheetVal[1], $sheetVal[2], $sheetVal[8], $sheetVal[14]);
                                            //if a new record
                                            if (!$isCount) {
                                                $isInsert = $this->excursionexpimpmodel->insertImport($sheetVal);
                                                if (!$isInsert) {
                                                    $errorCount += 1;
                                                } else {
                                                    $importCount += 1;
                                                }
                                            }
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error_message', 'Import failed');
                                redirect('excursionexportimport');
                            }
                        } else {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('error_message', 'Invalid file. Only .xls or .xlsx is allowed');
                            redirect('excursionexportimport');
                        }
                    } else {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('error_message', 'No files found');
                        redirect('excursionexportimport');
                    }
                }
                if ($errorCount > 0) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error_message', 'Import failed');
                    redirect('excursionexportimport');
                } else {
                    if ($importCount > 0) {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('success_message', 'Files successfully imported');
                        redirect('excursionexportimport');
                    } else {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('error_message', 'No data have been imported');
                        redirect('excursionexportimport');
                    }
                }
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error_message', 'No files found');
                redirect('excursionexportimport');
            }
//        } else {
//            $this->db->trans_rollback();
//            $this->session->sess_destroy();
//            redirect('backoffice', 'refresh');
//        }
    }

    /**
     * Function for backup all old join data 
     * and delete all files other than last 10 days backup
     * @author Arunsankar
     * @since 23-03-2016 
     */
    function _backupAllJoin() {
        $exportRecord = $this->excursionexpimpmodel->backupJoin();
        $this->load->library('excel_180');
        $this->load->library('zip');

        $isNewSheet = 1;
        $sheetno = 0;
        $loopcount = 0;
        $disconnect = 0;
        $newsheet = $this->excel_180->createSheet($sheetno);
        $this->excel_180->setActiveSheetIndex($sheetno);
        $newsheet->getColumnDimension('B')->setVisible(FALSE);
        $newsheet->getColumnDimension('C')->setVisible(FALSE);
        $newsheet->getColumnDimension('I')->setVisible(FALSE);
        $newsheet->getColumnDimension('O')->setVisible(FALSE);

        $rowCount = 1;
        $filecount = 1;
        $filearray = array();
        $mastcount = sizeof($exportRecord);
        $filename = '';
        foreach ($exportRecord as $export) {
            if ($disconnect != 0) {
                $sheetno = 0;

                $this->load->library('excel_180');
                $newsheet = $this->excel_180->createSheet($sheetno);
                $this->excel_180->setActiveSheetIndex($sheetno);
                $newsheet->getColumnDimension('B')->setVisible(FALSE);
                $newsheet->getColumnDimension('C')->setVisible(FALSE);
                $newsheet->getColumnDimension('I')->setVisible(FALSE);
                $newsheet->getColumnDimension('O')->setVisible(FALSE);
                $disconnect = 0;
            }
            $newone = 0;
            $column = 'A';
            if ($isNewSheet == 1) {
                $headArray = array('jn_id', 'jn_id_exc', 'jn_id_campus', 'Campus', 'full/half day', 'Where', 'Planned/extra', 'Week', 'jn_id_bus', 'Company', 'Seats', 'jn_price', 'jn_cost', 'jn_budget', 'jn_currency', 'Currency');
                $newsheet->fromArray($headArray, NULL, 'A1');
                $rowCount += 1;
            }
            $isNewSheet = 0;
            if (!empty($export)) {
                foreach ($export as $key => $val) {
                    $export[$key] = trim($val, '=');
                }
            }
            $newsheet->fromArray($export, NULL, 'A' . $rowCount);
            $filenm = $exportRecord[$loopcount]['nome_centri'];
            $sheetname = $exportRecord[$loopcount]['tra_cp_name'];
            if (strlen($exportRecord[$loopcount]['tra_cp_name']) > 31) {
                $sheetname = substr($exportRecord[$loopcount]['tra_cp_name'], 0, 27) . "...";
            }
            $newsheet->getStyle('A1:P1')->getFont()->setBold(true);
            $rowCount += 1;
            if (isset($exportRecord[$loopcount + 1]['tra_cp_name'])) {
                if ($exportRecord[$loopcount + 1]['tra_cp_name'] != $exportRecord[$loopcount]['tra_cp_name']) {
                    $sheetno += 1;
                    $newone += 1;
                    $rowCount = 1;
                    $newsheet->getProtection()->setPassword('G8#!H#t@2ZTVEW@');
                    $newsheet->getProtection()->setSheet(TRUE);
                    $newsheet->getStyle('L1:N' . $newsheet->getHighestDataRow())->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                    $newsheet->setTitle($sheetname);
                    for ($col = 'A'; $col <= 'P'; $col++) {
                        if ($col == 'L' OR $col == 'M' OR $col == 'N') {
                            $newsheet->getColumnDimension($col)->setWidth(10);
                        } else {
                            $newsheet->getColumnDimension($col)->setAutoSize(TRUE); //setting auto size to columns
                        }
                    }
                    $newsheet->getColumnDimension('B')->setVisible(FALSE);
                    $newsheet->getColumnDimension('C')->setVisible(FALSE);
                    $newsheet->getColumnDimension('I')->setVisible(FALSE);
                    $newsheet->getColumnDimension('O')->setVisible(FALSE);
                    $newsheet = $this->excel_180->createSheet($sheetno);
                }
            } else {
                $newsheet->getProtection()->setPassword('G8#!H#t@2ZTVEW@');
                $newsheet->getProtection()->setSheet(TRUE);
                $newsheet->getStyle('L1:N' . $newsheet->getHighestDataRow())->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                for ($col = 'A'; $col <= 'P'; $col++) {
                    if ($col == 'L' OR $col == 'M' OR $col == 'N') {
                        $newsheet->getColumnDimension($col)->setWidth(10);
                    } else {
                        $newsheet->getColumnDimension($col)->setAutoSize(TRUE); //setting auto size to columns
                    }
                }
                $newsheet->getColumnDimension('B')->setVisible(FALSE);
                $newsheet->getColumnDimension('C')->setVisible(FALSE);
                $newsheet->getColumnDimension('I')->setVisible(FALSE);
                $newsheet->getColumnDimension('O')->setVisible(FALSE);
                $newsheet->setTitle($sheetname);
            }
            if (isset($exportRecord[$loopcount + 1]['jn_id_campus'])) {
                if ($exportRecord[$loopcount + 1]['jn_id_campus'] != $exportRecord[$loopcount]['jn_id_campus']) {

                    $sheetno = 1;
                    $newone += 1;
                    $disconnect = 1;
                    $rowCount = 1;
                    $filename = $exportRecord[$loopcount]['nome_centri'] . '.xls';
                    $writeObj = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
                    $filecount += 1;
                    $filearray[] = $filename;
                    //Remove unwanted empty worksheet generating in each workbook 
                    $workSheetArray = $this->excel_180->getSheetNames();
                    $removeNum = 0;
                    foreach ($workSheetArray as $key => $val) {
                        if (strpos(trim($val), "Worksheet") === 0) {
                            $this->excel_180->removeSheetByIndex($key - $removeNum);
                            $removeNum += 1;
                        }
                    }
                    header('Content-Type: application/application/vnd.ms-excel');
                    header('Cache-Control: max-age=0');
                    $writeObj->save(EXPORT_BACKUP_PATH . $filename);
                }
            } else {
                $sheetno = 1;
                $newone += 1;
                $disconnect = 1;
                $rowCount = 1;
                $filename = $exportRecord[$loopcount]['nome_centri'] . '.xls';
                $writeObj = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
                $filecount += 1;
                $filearray[] = $filename;
                //Remove unwanted empty worksheet generating in each workbook 
                $workSheetArray = $this->excel_180->getSheetNames();
                $removeNum = 0;
                foreach ($workSheetArray as $key => $val) {
                    if (strpos(trim($val), "Worksheet") === 0) {
                        $this->excel_180->removeSheetByIndex($key - $removeNum);
                        $removeNum += 1;
                    }
                }
                header('Content-Type: application/application/vnd.ms-excel');
                header('Cache-Control: max-age=0');
                $writeObj->save(EXPORT_BACKUP_PATH . $filename);
            }

            if ($newone > 0) {

                $isNewSheet = 1;
                if ($disconnect != 0) {
                    $this->excel_180->__destruct();
                }
            }
            $loopcount += 1;
        }
        $downloadedFileCount = sizeof($filearray);
        for ($i = 0; $i < $downloadedFileCount; $i++) {
            $this->zip->read_file(EXPORT_BACKUP_PATH . $filearray[$i]);
        }

        if ($this->zip->archive(EXPORT_BACKUP_PATH . 'excursion_files_backup_' . date('d-m-Y His') . '.zip')) {
            for ($i = 0; $i < $downloadedFileCount; $i++) {
                unlink(EXPORT_BACKUP_PATH . $filearray[$i]);
            }
        }
        //delete old backup files. 
        $files = array();
        $folder = EXPORT_BACKUP_PATH;
        foreach (scandir($folder) as $node) {
            $nodePath = $folder . $node;
            if (is_dir($nodePath))
                continue;
            $dateValue = trim(str_replace('excursion_files_backup_', '', str_replace('.zip', '', $node)));
            $nodetime = strtotime($dateValue);
            $files[$nodePath] = $nodetime;
        }
        arsort($files);
        $oldfiles = array_slice($files, 10);
        if (!empty($files) && !empty($oldfiles)) {
            foreach ($files as $path => $time) {
                if (in_array($time, $oldfiles)) {
                    unlink($path);
                }
            }
        }
    }

}
