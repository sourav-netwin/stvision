<?php

/**
 * Class to control Excursion Import and Export queriess
 * @since 18-MAR-2016
 * @author Arunsankar
 * @modified 12-APR-2016
 * @modified_by Arunsankar
 */
class Excursionexpimpmodel extends Model {

	private $tableName = 'plused_exc_join';

	/**
	 * Function to get export details as xls file
	 */
	function getExportData($campuses) {
		$this -> db -> _protect_identifiers = FALSE;
		$mapData = $this -> getCampusCompanyMap($campuses);
		$this -> db -> select('"" as jn_id, c.exc_id, b.id,b.nome_centri, c.exc_length,c.exc_excursion,c.exc_type,c.exc_weeks, e.tra_bus_id, d.tra_cp_name, e.tra_bus_name,"" as jn_price,"" as Cost,"" as Budget,f.cur_id as jn_currency, b.valuta_fattura')
				-> from('centri as b')
				-> join('plused_exc_all as c', 'c.exc_id_centro=b.id')
				-> join('plused_tra_companies as d', '1')
				-> join('plused_tra_bus as e', 'e.tra_bus_cp_id=d.tra_cp_id')
				-> join('plused_tb_currency as f', 'f.cur_codice=b.valuta_fattura');
		$loop = 0;
		if (!empty($mapData)) {
			foreach ($mapData as $map) {
				if ($loop == 0) {
					$this -> db -> where('(b.id = ' . $map['centri_id'] . ' and d.tra_cp_id = ' . $map['tra_cp_id'] . ')');
				}
				else {
					$this -> db -> or_where('(b.id = ' . $map['centri_id'] . ' and d.tra_cp_id = ' . $map['tra_cp_id'] . ')');
				}
				$loop += 1;
			}
		}
		$this -> db -> order_by('b.id, d.tra_cp_id,c.exc_length,c.exc_excursion, c.exc_type, c.exc_weeks, e.tra_bus_name');

		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Function to get the mapped campus company details
	 * @param array $campuses
	 * @return array/boolean
	 */
	function getCampusCompanyMap($campuses) {
		$this -> db -> select('centri_id, tra_cp_id')
				-> from('plused_campus_company')
				-> order_by('centri_id');
		$count = 0;
		foreach ($campuses as $campus) {
			if ($count == 0) {
				$this -> db -> where('centri_id', $campus);
			}
			else {
				$this -> db -> or_where('centri_id', $campus);
			}
			$count += 1;
		}
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Function to get export result as xls file
	 */
	function getExportResultData() {
		$this -> db -> _protect_identifiers = FALSE;
		$this -> db -> select('a.jn_id, a.jn_id_exc, a.jn_id_campus,b.nome_centri, c.exc_length,c.exc_excursion,c.exc_type,c.exc_weeks, a.jn_id_bus, d.tra_cp_name, e.tra_bus_name,a.jn_price,a.jn_cost, a.jn_budget, a.jn_currency')
				-> from('plused_exc_join as a')
				-> join('centri as b', 'a.jn_id_campus=b.id')
				-> join('plused_exc_all as c', 'c.exc_id=a.jn_id_exc')
				-> join('plused_tra_bus as e', 'e.tra_bus_id=jn_id_bus')
				-> join('plused_tra_companies as d', 'd.tra_cp_id=e.tra_bus_cp_id')
				-> order_by('b.nome_centri, d.tra_cp_name');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	function getImportCount($jn_id_exc, $jn_id_campus, $jn_id_bus, $jn_currency) {
		$this -> db -> select('count(*) as count')
				-> from('plused_exc_join')
				-> where('jn_id_exc', $jn_id_exc)
				-> where('jn_id_campus', $jn_id_campus)
				-> where('jn_id_bus', $jn_id_bus)
				-> where('jn_currency', $jn_currency);
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			$resultData = $result -> result_array();
			if ($resultData[0]['count'] > 0) {
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
		else {
			return FALSE;
		}
	}

	/**
	 * operations
	 * This function can be use for below operations
	 * @author Arunsankar
	 * @since 22-Mar-2016
	 * insert | update | delete | changestatus
	 * @param string $action insert | update | delete | changestatus
	 * @param array $data
	 * @param int $edit_id
	 * @return int
	 * @throws Exception 
	 */
	public function operations($action, $data = array(), $edit_id = 0) {
		$result = null;
		try {
			switch ($action) {
				case 'insert':
					$this -> db -> insert($this -> tableName, $data);
					$result = $this -> db -> insert_id();
					break;
				case 'update':
					$this -> db -> where('cam_id', $edit_id);
					$this -> db -> update($this -> tableName, $data);
					$result = $edit_id;
					break;
				default:
					break;
			}
		}
		catch (Exception $exp) {
			throw $exp;
		}
		return $result;
	}

	/**
	 * Function to insert into exc_join
	 * @author Arunsankar
	 * @since 23-Mar-2016
	 * @param array $sheetVal
	 */
	function insertImport($sheetVal) {
		$data = array(
			'jn_id_exc' => $sheetVal[1],
			'jn_id_campus' => $sheetVal[2],
			'jn_id_bus' => $sheetVal[8],
			'jn_price' => $sheetVal[11],
			'jn_cost' => $sheetVal[12],
			'jn_budget' => $sheetVal[13],
			'jn_currency' => $sheetVal[14],
		);
		$isInsert = $this -> operations('insert', $data);
		if ($isInsert) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}	

	/**
	 * getCampusList
	 * This function returns list of campuses
	 * @return array
	 * @throws Exception 
	 */
	public function getMapCampusList($attivi = 1) {
		$result = null;
		try {
			$this -> db -> select('distinct(a.centri_id) as id,b.nome_centri, b.valuta_fattura')
					-> from('plused_campus_company as a')
					-> join('centri as b', 'a.centri_id=b.id')
					-> order_by('a.centri_id');
			if ($attivi == 1) {
				$this -> db -> where('b.attivo', $attivi);
			}
			$res = $this -> db -> get();
			if ($res -> num_rows()) {
				$result = $res -> result_array();
			}
			$res -> free_result();
		}
		catch (Exception $exp) {
			throw $exp;
		}
		return $result;
	}

	/**
	 * Function get data for backup
	 * @author Arunsankar
	 * @since 23-Mar-2016
	 * @modified 06-Apr-2016
	 * @modified_by Arunsankar
	 */
	public function backupJoin() {
		$this -> db -> _protect_identifiers = FALSE;
		$this -> db -> select('a.jn_id, a.jn_id_exc, a.jn_id_campus,b.nome_centri, c.exc_length,c.exc_excursion,c.exc_type,c.exc_weeks, a.jn_id_bus, e.tra_cp_name, d.tra_bus_name,a.jn_price,a.jn_cost,a.jn_budget,f.cur_id as jn_currency, b.valuta_fattura')
				-> from('plused_exc_join as a')
				-> join('centri as b', 'b.id=a.jn_id_campus')
				-> join('plused_exc_all as c', 'c.exc_id=a.jn_id_exc')
				-> join('plused_tra_bus as d', 'd.tra_bus_id=a.jn_id_bus')
				-> join('plused_tra_companies as e', 'e.tra_cp_id=d.tra_bus_cp_id')
				-> join('plused_tb_currency as f', 'f.cur_codice=b.valuta_fattura')
				-> order_by('a.jn_id_campus, e.tra_cp_id,c.exc_length,c.exc_excursion, a.jn_id_bus');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Function to delete all data from exc_join
	 * @author Arunsankar
	 * @since 23-Mar-2016
	 */
	public function deleteAllJoin() {
		$this -> db -> empty_table('plused_exc_join');
	}
}

/* End of file excursionexportimport.php */
/* Location: ./systemplus/application/models/tuition/excursionexportimport.php */