<?php

/**
 * Class to import Excursion price Import
 * @since 20-APR-2017
 * @author Arunsankar
 */
class Importtemp extends Controller {

	public function __construct() {

		parent::Controller();
		set_time_limit(EXPORT_TIME_LIMIT);
		ini_set('memory_limit', EXPORT_MEM_LIMIT);
		$this->load->helper(array('url'));
		$this->load->model("Excursion_price_import", "import");
	}

	/**
	 * read excel file and make array for importing into database
	 * @author Arunsankar
	 * @since 18-Mar-2016
	 */
	function index() {
            DIE("THIS FUNCTIONALITY IS BLOCKED");
		$this->load->library('excel_180');
		$file = 'downloads/Coach_services_2017_DEF_UK.xls';
		$fileType = PHPExcel_IOFactory::identify($file);
		$objReader = PHPExcel_IOFactory::createReader($fileType);
		$objPHPExcel = $objReader->load($file);
		$center = '';
		$busTypes = array();
		foreach ($objPHPExcel->getAllSheets() as $rowNumber => $sheet) {
			$dataToImport = array();
			$sheetData = $sheet->toArray();
			foreach ($sheetData as $key => $value) {
				if ($key == 0) {
					// center/campus
					$campus = $this->import->getCampus($value[1]);
					// echo $campus->name . '<br>';
				} elseif ($key == 1) {
					$company = array_filter($value);
				} elseif ($value[0] == 'bus_type') {
					// for getting bus type
					$busTypes = array_filter(array_slice($value, 7, count($value), true));
					$busTypes = $this->addBusTypes($busTypes, $sheetData[$key + 1][5]);
					// echo "<pre>";
					// echo $sheetData[$key + 1][5] . '<br>';
					// print_r($busTypes);
					// echo "</pre>";
				} else {
					if (empty($value[1])) {
						break;
					}

					$week = empty($value[4]) ? 0 : $value[4];
					$type = strtolower($value[0]);
					$excursionName = '';
					$excursionType = '';
					if ($type == 'transfers') {
						$excursionName = $value[1];
						if ($value[6] == 'Inbound' || $value[6] == 'Outbound') {
							$excursionName = $excursionName . ' ' . strtolower($value[6]);
						}
						if ($value[6] == 'Inbound') {
							$excursionType = 'in';
						} elseif ($value[6] == 'Outbound') {
							$excursionType = 'out';
						} else {
							$excursionType = 'both';
						}
						$length = '';
						$type = 'transfer';
					} else {
						$length = empty($value[2]) ? 'half day' : 'full day';
						$excursionName = $value[1];
						$excursionType = '-';
					}
					$excursion = $this->import->getExcursion($excursionName, $week, $length, $type, $campus->id, $excursionType); // parameters: excursion,week,length,type,campus, excursion_type
					foreach ($busTypes as $busKey => $bus) {
						if (empty($value[$busKey])) {
							continue;
						}
						$dataToImport[$campus->id][] = array(
							'excursion' => @$excursion->exc_id,
							'bus_type_id' => $bus['bus_type_id'],
							'company' => $value[5],
							'price' => empty($value[$busKey]) ? 0 : floatval($value[$busKey]),
							'currency' => $campus->name == 'DUBLIN' ? 3 : 2,
						);
					}
				}
			}
			$this->importPrice($dataToImport);
		}
		die('<h1>Success</h1>');
	}

	/**
	 * add company and bus types if not available in database and return array of bus types
	 * @author Arunsankar
	 * @since 18-Mar-2016
	 */
	private function addBusTypes($busTypes, $company) {
		$types = array();
		$isExists = $this->import->companyExists($company);
		if (!$isExists) {
			$companyId = $this->import->addCompany($company, $busTypes);
			foreach ($busTypes as $key => $busType) {
				$types[$key]['bus_type'] = $busType;
				$types[$key]['bus_type_id'] = $this->import->addBusType($companyId, $busType);
			}
			return $types;
		}
		foreach ($busTypes as $key => $busType) {
			$types[$key]['bus_type'] = $busType;
			$bus = $this->import->busTypeExists($isExists->tra_cp_id, trim($busType));
			if (!$bus) {
				$types[$key]['bus_type_id'] = $this->import->addBusType($isExists->tra_cp_id, $busType);
			} else {
				$types[$key]['bus_type_id'] = $bus->tra_bus_id;
			}
		}
		return $types;
	}

	/**
	 * import price into database
	 * @author Arunsankar
	 * @since 18-Mar-2016
	 */
	public function importPrice($data) {
		$campus = implode('', array_keys($data));
		foreach ($data[$campus] as $row) {
			$data = array(
				'jn_id_exc' => $row['excursion'],
				'jn_id_campus' => $campus,
				'jn_id_bus' => $row['bus_type_id'],
				'jn_price' => $row['price'],
				'jn_currency' => $row['currency'],
			);
			$this->import->insertJoin($data);
		}
		return true;
	}

}
