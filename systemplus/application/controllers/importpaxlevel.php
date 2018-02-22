<?php

/**
 * Class to import pax level
 * @since 24-MAY-2017
 * @author Arunsankar
 */
class Importpaxlevel extends Controller {

    private $country;
    private $level;
    private $range;
    private $service;
    private $accomodations;
    private $paxInfo;
    private $count = 0;
    private $accomCount = 0;

    public function __construct() {

        parent::Controller();
        set_time_limit(EXPORT_TIME_LIMIT);
        ini_set('memory_limit', EXPORT_MEM_LIMIT);
        $this->load->helper(array('url'));
        $this->load->model("paxlevelimport", "import");
        die('THIS FUNCTIONALITY HAS BEEN BLOCKED');
    }

    /**
     * read excel file and make array for importing into database
     * @author Arunsankar
     * @since 24-MAY-2017
     */
    function index() {
        $this->load->library('excel_180');
        $file = 'downloads/Copia_di_Rimborsi_EU_USA_2017additional.xls';
        $fileType = PHPExcel_IOFactory::identify($file);
        $objReader = PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load($file);
        foreach ($objPHPExcel->getAllSheets() as $rowNumber => $sheet) {
            $sheetData = $sheet->toArray();
            foreach ($sheetData as $key => $value) {
                if ($rowNumber == 0) {
                    $this->country = 'EU';
                } elseif ($rowNumber == 1) {
                    $this->country = 'US';
                }
                if ($value[0] == 'level') {
                    $this->setLevel($value[1]);
                } elseif ($value[0] == 'range') {
                    $this->setRange($value);
                } elseif ($value[0] == 'service') {
                    $this->setService($value);
                } elseif ($value[0] == 'accomodation') {
                    $this->setAccomodations($value);
                } elseif ($value[0] == 'finish') {
                    $this->setPaxInfo();
                    $this->service = array();
                    $this->accomodations = array();
                    $this->accomCount = 0;
                }
            }
        }
        $this->import->insert($this->paxInfo);
        die('<h1>Success</h1>');
    }

    private function setLevel($level) {
        $this->level = $level;
    }

    private function setRange($range) {
        $this->range = array();
        if (empty($range)) {
            return;
        }
        $range = array_filter($range);
        $cnt = 0;
        foreach ($range as $key => $value) {
            if ($key <= 1) {
                continue;
            }
            $rangeExplode = explode('/', $value);
            $this->range[$cnt]['min_pax'] = $rangeExplode[0];
            $this->range[$cnt]['max_pax'] = isset($rangeExplode[1]) ? $rangeExplode[1] : $rangeExplode[0];
            ++$cnt;
        }
    }

    private function setService($reimbursment) {
        $reimbursment = array_filter($reimbursment, function($var) {
            return ($var !== NULL && $var !== FALSE && $var !== '');
        });
        $service = trim($reimbursment[1]);
        $this->service[$service] = array_slice($reimbursment, 2, count($reimbursment));
    }

    private function setAccomodations($accomodations) {
        $accomodations = array_filter($accomodations);
        if (!isset($accomodations[1])) {
            return;
        }
        $this->accomodations[$this->accomCount]['accom'] = strtolower($accomodations[1]);
        $this->accomodations[$this->accomCount]['product_code'] = $accomodations[2];
        ++$this->accomCount;
    }

    private function setPaxInfo() {
        foreach ($this->accomodations as $key => $accomodation) {
            foreach ($this->service as $service => $reimbursment) {
                foreach ($this->range as $rangeKey => $range) {
                    if (!isset($reimbursment[$rangeKey])) {
                        continue;
                    }
                    $this->paxInfo[$this->count]['country'] = $this->country;
                    $this->paxInfo[$this->count]['level'] = $this->level;
                    $this->paxInfo[$this->count]['min_pax'] = $range['min_pax'];
                    $this->paxInfo[$this->count]['max_pax'] = $range['max_pax'];
                    $this->paxInfo[$this->count]['service'] = $service;
                    $this->paxInfo[$this->count]['reimbursement'] = $reimbursment[$rangeKey];
                    $this->paxInfo[$this->count]['accomodation'] = $accomodation['accom'];
                    $this->paxInfo[$this->count]['product'] = $accomodation['product_code'];
                    ++$this->count;
                }
            }
        }
    }

}
