<?php
/**
 * Class to control Join campus and company
 * @author Arunsankar
 * @modified 12-APR-2016
 * @modified_by Arunsankar
 */
class joincampuscompanymodel extends Model {

	private $tableName = 'plused_campus_company';

	/**
	 * function for get campus record
	 * @author Arunsankar
	 * @since 22-Mar-2016
	 * @return int
	 */
	function getCampusData() {
		$this -> db -> select('id, nome_centri')
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
	 * function for get company record
	 * @author Arunsankar
	 * @since 22-Mar-2016
	 * @return int
	 */
	function getCompanyData() {
		$this -> db -> select('tra_cp_id, tra_cp_name')
				-> from('plused_tra_companies')
				-> order_by('tra_cp_name');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return 0;
		}
	}

	function insertUpdate($campus, $companies) {
		$error = 0;
		$this -> db -> trans_start();
		if (is_array($companies)) {
			foreach ($companies as $company) {
				if (is_numeric($company)) {
					if ($this -> getCount($campus, $company)) {
						$data = array(
							'centri_id' => $campus,
							'tra_cp_id' => $company
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
			$this -> deleteMaping($campus, $companies);
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

	function deleteMaping($campus, $companies) {
		$error = 0;
		$delArray = array();
		if (is_array($companies)) {
			foreach ($companies as $company) {
				if (is_numeric($company)) {
					$this -> db -> where('(centri_id = ' . $campus . ' and tra_cp_id != ' . $company . ')');
				}
				else {
					$error += 1;
				}
			}
			if ($error == 0) {
				$this -> db -> delete('plused_campus_company');
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

	function getCount($campus, $company) {
		$this -> db -> select('count(*) as count')
				-> from($this -> tableName)
				-> where('centri_id', $campus)
				-> where('tra_cp_id', $company);
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
				case 'delete':
					$updateArr = array(
						'joc_is_deleted' => 1
					);
					$this -> db -> where('cam_id', $edit_id);
					$this -> db -> update($this -> tableName, $updateArr);
					$result = $edit_id;
					break;
				case 'changestatus':
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

	function getMappedCompanies($id) {
		$this -> db -> select('tra_cp_id')
				-> from('plused_campus_company')
				-> where('centri_id', $id);
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	function getMappedData() {
		$this -> db -> _protect_identifiers = FALSE;
		$this -> db -> select('a.centri_id, b.nome_centri, group_concat(concat(" ",c.tra_cp_name)) as tra_cp_name')
				-> from('plused_campus_company as a')
				-> join('centri as b', 'a.centri_id=b.id')
				-> join('plused_tra_companies as c', 'c.tra_cp_id=a.tra_cp_id')
				-> group_by('a.centri_id')
				-> order_by('b.nome_centri');
		$result = $this -> db -> get();
		if ($result -> num_rows()) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}
}