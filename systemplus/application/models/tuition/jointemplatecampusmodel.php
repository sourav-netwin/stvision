<?php

/**
 * Class to control Join templates and campus
 * @author Arunsankar
 * @since 25-Apr-2016
 */
class jointemplatecampusmodel extends Model {

	private $tableName = 'plused_temp_campus';

	/**
	 * function for get campus record
	 * @author Arunsankar
	 * @since 25-Apr-2016
	 * @return int array
	 */
	function getCampusData() {
		$this -> db -> select('id, nome_centri,located_in')
				-> from('centri')
				-> where('attivo', 1)
				-> order_by('nome_centri');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return 0;
		}
	}

	/**
	 * Function to map/unmap using campus id and template
	 * @author Arunsankar
	 * @since 25-Apr-2016
	 */
	function mapTemplateCampus($selTemplate, $campuses) {
		$error = 0;
		$this -> db -> trans_start();
		if (is_array($campuses)) {
			foreach ($campuses as $campus) {
				if (is_numeric($campus)) {
					if ($this -> getCount($campus, $selTemplate)) {
						$data = array(
							'centri_id' => $campus,
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
			$this -> deleteMaping($selTemplate, $campuses);
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
	function deleteMaping($selTemplate, $campuses) {
		$error = 0;
		$delArray = array();
		if (is_array($campuses)) {
			foreach ($campuses as $campus) {
				if (is_numeric($campus)) {
					$this -> db -> where('(centri_id != ' . $campus . ' and template = \'' . $selTemplate . '\')');
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
		if($this -> db -> delete($this -> tableName)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	function getRowCount($selTemplate){
		$this -> db -> select('count(*) as count')
				-> from($this -> tableName)
				-> where('template', $selTemplate);
		$result = $this -> db -> get();
		if($result -> num_rows()){
			$resultArray = $result -> result_array();
			if($resultArray[0]['count'] > 0){
				return '1';
			}
			else{
				return '0';
			}
		}
		else{
			return '0';
		}
	}

	function getCount($campus, $selTemplate) {
		$this -> db -> select('count(*) as count')
				-> from($this -> tableName)
				-> where('centri_id', $campus)
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
	 * @since 25-Apr-2016
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
		$this -> db -> select('a.tec_id, a.centri_id, a.template, group_concat(concat(" ",b.nome_centri) order by b.nome_centri) as nome_centri')
				-> from('plused_temp_campus as a')
				-> join('centri as b', 'a.centri_id=b.id')
				-> group_by('a.template');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	function getMappedCampuses($id) {
		$this -> db -> select('centri_id')
				-> from('plused_temp_campus')
				-> where('template', $id);
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}
	
	function getUnmappedList(){
		$this -> db -> select('group_concat(nome_centri order by nome_centri SEPARATOR \', \') as nome_centri', FALSE)
				-> from('centri')
				-> where('id not in (select centri_id from plused_temp_campus)')
				->where('attivo', 1);
		$result = $this -> db -> get();
		if($result -> num_rows() > 0){
			$resultArray = $result -> result_array();
			return $resultArray[0]['nome_centri'];
		}
		else{
			return FALSE;
		}
	}
}