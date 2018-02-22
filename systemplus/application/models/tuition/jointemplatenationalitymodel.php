<?php

/**
 * Class to control Join templates and nationality
 * @author Arunsankar
 * @since 04-May-2016
 */
class jointemplatenationalitymodel extends Model {

	/**
	 * function for get campus record
	 * @author Arunsankar
	 * @since 04-May-2016
	 * @return int array
	 */
	private $tableName = 'plused_temp_nationality';

	function getNationalityData() {
		$this -> db -> select('nat_id, nationality, continent')
				-> from('plused_nationality')
				-> where('active', 1)
				-> order_by('nationality');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return 0;
		}
	}

	
	function mapTemplateNationality($selTemplate, $nationalities) {
		$error = 0;
		$this -> db -> trans_start();
		if (is_array($nationalities)) {
			foreach ($nationalities as $nationality) {
				if (is_numeric($nationality)) {
					if ($this -> getCount($nationality, $selTemplate)) {
						$data = array(
							'nat_id' => $nationality,
							'template' => $selTemplate
						);
						$isInsert = $this -> operations('insert', $data);
						if (!$isInsert) {
							$error += 1;
						}
					}
				}
				else {
					$error += 1;
				}
			}
			$this -> deleteMaping($selTemplate, $nationalities);
			if ($error == 0) {
				$this -> db -> trans_commit();
				return TRUE;
			}
		}
		else {
			$this -> db -> trans_rollback();
			return FALSE;
		}
	}

	/**
	 * Function to delete mapping
	 * @param int $selTemplate
	 * @param array $campuses
	 * @return boolean
	 */
	function deleteMaping($selTemplate, $nationalities) {
		$error = 0;
		$delArray = array();
		if (is_array($nationalities)) {
			foreach ($nationalities as $nationality) {
				if (is_numeric($nationality)) {
					$this -> db -> where('(nat_id != ' . $nationality . ' and template = \'' . $selTemplate . '\')');
				}
				else {
					$error += 1;
				}
			}
			if ($error == 0) {
				$this -> db -> delete($this -> tableName);
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
	 * Function to delete mapping
	 * @param int $selTemplate
	 * @param array $campuses
	 * @return boolean
	 */
	function deleteMapingFromTemplate($selTemplate) {
		$this -> db -> where('template', $selTemplate);
		if ($this -> db -> delete($this -> tableName)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function getRowCount($selTemplate) {
		$this -> db -> select('count(*) as count')
				-> from($this -> tableName)
				-> where('template', $selTemplate);
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			$resultArray = $result -> result_array();
			if ($resultArray[0]['count'] > 0) {
				return '1';
			}
			else {
				return '0';
			}
		}
		else {
			return '0';
		}
	}

	function getCount($nationality, $selTemplate) {
		$this -> db -> select('count(*) as count')
				-> from($this -> tableName)
				-> where('nat_id', $nationality)
				-> where('template', $selTemplate);
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			$resultArray = $result -> result_array();
			if ($resultArray[0]['count'] == 0) {
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
	 * @since 05-May-2016
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
					$this -> db -> where('tec_id', $edit_id);
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

	function getMappedData() {
		$this -> db -> _protect_identifiers = FALSE;
		$this -> db -> select('a.ten_id, a.nat_id, a.template, group_concat(concat(" ",b.nationality) order by b.nationality) as nationality')
				-> from('plused_temp_nationality as a')
				-> join('plused_nationality as b', 'a.nat_id=b.nat_id')
				-> group_by('a.template');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	function getMappedNationalities($id) {
		$this -> db -> select('nat_id')
				-> from('plused_temp_nationality')
				-> where('template', $id);
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	function getMapStatus() {
		$this -> db -> select('count(*) as count')
				-> from('plused_nationality')
				-> where('nat_id not in (select nat_id from plused_temp_nationality)')
				-> where('active', 1);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			return $resultArray[0]['count'];
		}
		else {
			return FALSE;
		}
	}

	function getContinents() {
		$this -> db -> select('distinct continent as continent')
				-> from('plused_nationality')
				-> where('active', 1)
				-> order_by('continent');
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			return $resultArray = $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	function getCampusTemplate() {
		$this -> db -> select('b.nome_centri, a.template')
				-> from('plused_temp_campus as a')
				-> join('centri as b', 'b.id=a.centri_id');
		$campTempResult = $this -> db -> get();
		if ($campTempResult -> num_rows() > 0) {
			$resultArray = $campTempResult -> result_array();
			$campTempArray = array();
			foreach ($resultArray as $val) {
				$campTempArray[$val['nome_centri']][] = $val['template'];
			}
			return $campTempArray;
		}
		else {
			return false;
		}
	}

	function getNoMapCampusNat($campTemp) {
		$notList = array();
		$getArray = array();
		foreach ($campTemp as $val) {
			foreach ($val as $value) {
				if (!isset($getArray[$value])) {
					$this -> db -> query('SET SESSION group_concat_max_len = 1000000');
					$this -> db -> _protect_identifiers = FALSE;
					$this -> db -> select('group_concat(concat(" ",nationality) order by nationality) as nationality')
							-> from('plused_nationality')
							-> where('nat_id not in (select nat_id from plused_temp_nationality where template=\''.$value.'\')');
					$result = $this -> db -> get();
					if ($result -> num_rows() > 0) {
						$resultArray = $result -> result_array();
						$getArray[$value] = $resultArray[0]['nationality'];
					}
				}
			}
		}
		return $getArray;
	}
	
}