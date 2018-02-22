<?php

/**
 * Class for role management(Model)
 * @author Arunsankar
 * @since 03-Aug-2016
 */
class Rolemanagemodel extends Model {

	private $table = 'plused_role';

	/**
	 * Function to check the new role name already exists
	 * @author Arunsankar
	 * @since 03-Aug-2016
	 * @param string $roleName
	 * @return boolean
	 */
	function checkRoleNameExists($roleName) {
		$this -> db -> select('count(*) as count')
				-> from($this -> table)
				-> where('role_name', $roleName)
				-> where('role_is_deleted', 0);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			if ($resultArray[0]['count'] > 0) {
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}

	/**
	 * Function to check the role name is already present when edit the role
	 * @author Arunsankar
	 * @since 03-Aug-2016
	 * @param string $roleName
	 * @param int $roleId
	 * @return boolean
	 */
	function checkRoleNameExistsOnOther($roleName, $roleId) {
		$this -> db -> select('count(*) as count')
				-> from($this -> table)
				-> where('role_name', $roleName)
				-> where('role_is_deleted', 0)
				-> where_not_in('role_id', $roleId);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			if ($resultArray[0]['count'] > 0) {
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}

	/**
	 * Function to insert the new role
	 * @author  Arunsankar
	 * @since 03-Aug-2016
	 * @param array $data
	 * @return boolean
	 */
	function insertRole($data) {
		$isInsert = $this -> db -> insert($this -> table, $data);
		if ($isInsert) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Function to get role details
	 * @author  Arunsankar
	 * @since 03-Aug-2016
	 * @param int $roleId
	 * @param int $active
	 * @param int $deleted
	 * @return array
	 */
	function getRoleDetails($roleId = "", $active = "", $deleted = "") {
		if ($roleId !== "") {
			$this -> db -> where('role_id', $roleId);
		}
		if ($active !== "") {
			$this -> db -> where('role_is_active', $active);
		}
		if ($deleted !== "") {
			$this -> db -> where('role_is_deleted', $deleted);
		}
		$this -> db -> select('role_id, role_name, role_is_active')
				-> from('plused_role');
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			if (!empty($roleId)) {
				$resultArray = $result -> result_array();
				return $resultArray[0];
			}
			return $result -> result_array();
		}
		return FALSE;
	}

	/**
	 * Fucntion to update the role
	 * @author  Arunsankar
	 * @since 04-Aug-2016
	 * @param array $data
	 * @param array $where
	 * @return boolean
	 */
	function updateRole($data, $where) {
		$this -> db -> where($where);
		$isUpdated = $this -> db -> update($this -> table, $data);
		if ($isUpdated) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Function to change the role status
	 * @author  Arunsankar
	 * @since 04-Aug-2016
	 * @param int $roleId
	 * @return boolean
	 */
	function changeRoleStatus($roleId) {
		$newStatus = '';
		$newStatusText = '';
		$this -> db -> select('role_is_active')
				-> from('plused_role')
				-> where('role_id', $roleId);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			if ($resultArray[0]['role_is_active'] == 1) {
				$newStatus = 0;
				$newStatusText = 'inactivated';
			}
			else {
				$newStatus = 1;
				$newStatusText = 'activated';
			}
			$this -> db -> where('role_id', $roleId);
			$isUpdated = $this -> db -> update($this -> table, array('role_is_active' => $newStatus));
			if ($isUpdated) {
				return $newStatusText;
			}
			return FALSE;
		}
		return FALSE;
	}

	/**
	 * Function to soft delete the role
	 * @author  Arunsankar
	 * @since 03-Aug-2016
	 * @param int $roleId
	 * @return boolean
	 */
	function deleteRole($roleId) {
		$data = array(
			'role_is_deleted' => 1
		);
		$this -> db -> where('role_id', $roleId);
		$isDeleted = $this -> db -> update($this -> table, $data);
		if ($isDeleted) {
			return TRUE;
		}
		return FALSE;
	}
}

/*End of file rolemanagementmodel.php*/
