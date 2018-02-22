<?php
/**
 * This controller is created to set cron jobs
 * @author Sandip Kalbhile
 * @since 05-Apr-2017
 */
class Backofficemigrate extends Controller {

	public function __construct() {

		parent::Controller();

		$this->load->model('mbackoffice');
		$this->load->library(array('session', 'email'));
	}

	/**
	 * @since 05-Apr-2017
	 */
	function excursions() {
		$this->mbackoffice->migrateExcursions();
	}

	/**
	 * this function will receive xls file and import all records to exc_all with its campuses
	 */
	function importNewExcursions() {
		 DIE("THIS FUNCTIONALITY IS BLOCKED");
		$this->load->library('excel_180');
		try {
			$fileName = "../teacherApplications/excursion_for_2017.ods";
			$fileType = PHPExcel_IOFactory::identify($fileName);
			$objReader = PHPExcel_IOFactory::createReader($fileType);
			$objPHPExcel = $objReader->load($fileName);
			$sheets = array();
			foreach ($objPHPExcel->getAllSheets() as $sheet) {
				$sheetsarray = $sheet->toArray();
				//var_dump($sheetsarray);die;
				unset($sheetsarray[0]);
				$i = 0;

				foreach ($sheetsarray as $sheetVal) {
					$campusName = $sheetVal[1];
					$excursionName = $sheetVal[2];
					$campusId = $this->mbackoffice->getCampusIdFromName($campusName, TRUE);

					$excursionType = "";
					$excLength = ($sheetVal[3] == "X" ? "full day" : "half day");
					$excWeek = $sheetVal[5];
					if (trim($sheetVal[6]) == "EXTRA") {
						$excursionType = "extra";
					} elseif (trim($sheetVal[6]) == "PLANNED") {
						$excursionType = "planned";
					} elseif (trim($sheetVal[6]) == "TRANSFERS") {
						$excursionType = "transfer";
					}
					$types = explode(',', trim($sheetVal[7]));
					foreach ($types as $type) {
						$excursion = $excursionName;
						if ($type == 'in' || $type == 'out') {
							$excursion = $excursionName . ' ' . $type . 'bound';
						}
						$excursionInsert = array(
							'exc_id_centro' => $campusId,
							'exc_centro' => trim($campusName),
							'exc_length' => ($type == '-') ? $excLength : '',
							'exc_excursion' => $excursion,
							'exc_type' => $excursionType,
							'exc_days' => $excWeek * 7,
							'exc_weeks' => (empty($excWeek) ? 0 : $excWeek),
							'exc_airport' => ($type == '-') ? '-' : $sheetVal[8],
							'exc_transfer_type' => ($type == '-') ? '-' : $type,
						);
						// echo "<pre>";
						// print_r($excursionInsert);
						// echo "</pre>";
						$excId = $this->mbackoffice->insertExcursion($excursionInsert);
					}
				}
			}
			die("All records imported!!");
		} catch (Exception $e) {
			echo "Unable to import excursion!";
		}
	}

} /* End of file Backofficemigrate.php */