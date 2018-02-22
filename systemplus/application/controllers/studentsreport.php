<?php

/**
 * @Programmer  : SK
 * @Maintainer  : SK
 * @Created     : 25-July-2016
 * @Modified    : Arunsankar
 * @Modified    : 13-June-2017
 * @Description : sudents report for backoffice operators
 */
class Studentsreport extends Controller {

    public function __construct() {

        parent::Controller();
        authSessionMenu($this);
        $this->load->helper(array('form', 'url', 'mpdf6'));
        $this->load->model('tuition/studentsmodel', 'studentsmodel');
        $this->load->library(array('session', 'email', 'ltelayout'));
    }

    /**
     * this function loads students test report page 
     */
    function index() {
        if ($this->session->userdata('username') && $this->session->userdata('role') != 200) {
            $data['title'] = "plus-ed.com | Test report";
            $data['breadcrumb1'] = 'Students';
            $data['breadcrumb2'] = 'Test report';
            $testDropdown = $this->studentsmodel->getStudentTest();
            $data['testDropdown'] = $testDropdown;
            if (APP_THEME == 'OLD') {
                $this->load->view('tuition/plused_students_test_report', $data);
            } else {
                $data['pageHeader'] = "Test report";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/students/students_test_report', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /*
     * this function creates the report for jquery datatable for student test report
     * @author Arunsankar
     */
    function getReport() {
        $request = $_REQUEST;
        $testId = $request['test'];
        $keyword = $request['studentName'];
        $param = datatable_param($request, 'id_prenotazione');
        $testData = $this->studentsmodel->getStudentTestData($testId, $keyword, $param);
        $testData = $this->makeReportData($testData);
        $testCount = $this->studentsmodel->getStudentTestCount($testId, $keyword);
        $count = 0;
        foreach ($testCount as $cnt) {
            $count = $count + $cnt['count'];
        }
        $testCount = array_sum($testCount);
        echo datatable_json($request['draw'], $count, $testData);
        exit(0);
    }

    function makeReportData($testData) {
        if (empty($testData)) {
            return array();
        }
        foreach ($testData as $key => $test) {
            $testData[$key]['ts_submitted_on'] = date('d/m/Y', strtotime($test["ts_submitted_on"]));
            if (empty($test["nome"]) && empty($test["cognome"])) {
                $testData[$key]['nome'] = '-';
            } else {
                $testData[$key]['nome'] = html_entity_decode($test["cognome"] . ' ' . $test["nome"]);
            }
            $testData[$key]['id_book'] = $test["id_book"] . '_' . $test["id_year"];
        }
        return $testData;
    }

    /*
     * this function exports the student rest report in excel file.
     * @author Arunsankar
     */
    function exportReport() {
        $testId = $this->input->post('test');
        $keyword = $this->input->post('studentName');
        $testData = $this->studentsmodel->getStudentTestData($testId, $keyword);
        $this->load->library('excel_180');
        $objPHPExcel = new PHPExcel();

        $rowCount = 3;
        $heading = 'Test Report';
        if (!empty($testId)) {
            $heading .= ' for ' . $testData[0]['test_title'];
        }
        if (!empty($keyword)) {
            $heading .= ' for ' . $keyword;
        }
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', $heading);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
        $this->setColumnAutoWidth($objPHPExcel, "A", "H");
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Test');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Submitted date');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Student name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'Campus name');
        $objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Booking ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Total questions');
        $objPHPExcel->getActiveSheet()->SetCellValue('G2', 'Correct answers');
        foreach ($testData as $data) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $data['test_title']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, date('d/m/Y', strtotime($data["ts_submitted_on"])));
            if (empty($data["nome"]) && empty($data["cognome"])) {
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '-');
            } else {
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, html_entity_decode($data["cognome"] . ' ' . $data["nome"]));
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $data['nome']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $data['nome_centri']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $data["id_book"] . '_' . $data["id_year"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $data['total_questions']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $data['correct_answers']);
            $rowCount++;
        }

        $styleArray = array(
            'font' => array(
                'bold' => true,
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($styleArray);
        ob_start();
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();

        $response = array(
            'file_name' => 'student_test_report',
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );
        echo json_encode($response);
        exit(0);
    }

    function setColumnAutoWidth($objPHPExcel, $rangeColFrom, $rangeColTo) {
        for ($col = $rangeColFrom; $col !== $rangeColTo; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }
    }

    /**
     * used to load records using ajax while searching. 
     */
    function ajaxsearch() {
        $testId = $this->input->post('test');
        $keyword = $this->input->post('keyword');
        $testData = $this->studentsmodel->getStudentTestData($testId, $keyword);
        if (APP_THEME == 'OLD') {
            ?>
            <table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"bFilter":false,"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
                <?php
            } else {
                ?>
                <table class="datatable table table-bordered table-hover width-full">
                    <?php
                }
                ?>

                <thead>
                    <tr>
                        <th>Test</th>
                        <th>Submitted date</th>								
                        <th>Student name</th>								
                        <th>Booking id</th>
                        <th>Total questions</th>
                        <th>Correct answers</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($testData)
                        foreach ($testData as $test) {
                            ?>
                            <tr>
                                <td class="center"><?php echo $test["test_title"]; ?></td>
                                <td class="center"><?php echo date('d/m/Y', strtotime($test["ts_submitted_on"])); ?></td>
                                <td class="center">
                                    <?php
                                    if (empty($test["nome"]) && empty($test["cognome"]))
                                        echo '-';
                                    else
                                        echo html_entity_decode($test["cognome"] . ' ' . $test["nome"]);
                                    ?>
                                </td>
                                <td class="center"><?php echo $test["id_book"] . '_' . $test["id_year"]; ?></td>
                                <td class="center"><?php echo $test["total_questions"]; ?></td>
                                <td class="center"><?php echo $test["correct_answers"]; ?></td>
                            </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
            <?php
        }

    }

    /* End of file studentsreport.php */
