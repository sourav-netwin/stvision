<?php

/**
 * Class to manage role management
 * @author Arunsankar
 * @since 03-Aug-2016
 */
class Roles extends Controller {

	public function __construct() {

		parent::Controller();
                // check user session and menus with their access.
                authSessionMenu($this);
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> library(array('session', 'email', 'ltelayout', 'form_validation'));
		$this -> load -> model('role/rolemanagemodel');
                // check user session and menus with their access.
                //authSessionMenu($this);
	}

	/**
	 * Function to view the add role page
	 * @author Arunsankar
	 * @since 03-Aug-2016
	 */
	function index() {
		$data = array();
		$data['title'] = "plus-ed.com | Role management";
		$data['breadcrumb1'] = 'Role management';
		$data['breadcrumb2'] = 'Roles';
		$data['pageHeader'] = "Roles";
		$data['optionalDescription'] = "";
		$data['roleDetails'] = $this -> rolemanagemodel -> getRoleDetails('', '', 0);
               
		$this -> ltelayout -> view('role/view_role', $data);
	}

	/**
	 * Function to save the new role details
	 * @author Arunsankar
	 * @since 03-Aug-2016
	 */
	function submitRole() {
		$validationRules = array(
			array(
				'field' => 'roleName',
				'label' => 'Role name',
				'rules' => 'required'
			)
		);
		$this -> form_validation -> set_rules($validationRules);
		if ($this -> form_validation -> run($validationRules) === TRUE) {
			$roleName = $this -> input -> post('roleName');
			$insertData = array(
				'role_name' => $roleName
			);
			$isAlreadyExists = $this -> rolemanagemodel -> checkRoleNameExists($roleName);//Check the role name already exists in non deleted records
			if (!$isAlreadyExists) {//If role not exists
				$isInsert = $this -> rolemanagemodel -> insertRole($insertData);
				if ($isInsert) {
					$this -> session -> set_flashdata('success_message', 'Role added successfully');
				}
				else {
					$this -> session -> set_flashdata('error_message', 'Failed to add role');
				}
			}
			else {
				$this -> session -> set_flashdata('error_message', 'This role already exists. Try with another');
			}
		}
		else {
			$this -> session -> set_flashdata('error_message', 'Fields with * are mandatory');
		}
		redirect('roles', 'refresh');
	}

	/**
	 * Function to edit the new role details
	 * @author Arunsankar
	 * @since 03-Aug-2016
	 */
	function editRole() {
		$validationRules = array(
			array(
				'field' => 'roleName',
				'label' => 'Role name',
				'rules' => 'required'
			),
			array(
				'field' => 'roleId',
				'label' => 'Role id',
				'rules' => 'required'
			)
		);
		$this -> form_validation -> set_rules($validationRules);
		if ($this -> form_validation -> run($validationRules) === TRUE) {
			$roleName = $this -> input -> post('roleName');
			$roleId = $this -> input -> post('roleId');
			$updateData = array(
				'role_name' => $roleName
			);
			$where = array(
				'role_id' => $roleId
			);
			$isAlreadyExists = $this -> rolemanagemodel -> checkRoleNameExistsOnOther($roleName, $roleId);//Check the role not exists in other non deleted records
			if (!$isAlreadyExists) {//If role not exists
				$isInsert = $this -> rolemanagemodel -> updateRole($updateData, $where);
				if ($isInsert) {
					$this -> session -> set_flashdata('success_message', 'Role updated successfully');
				}
				else {
					$this -> session -> set_flashdata('error_message', 'Failed to update role');
				}
			}
			else {
				$this -> session -> set_flashdata('error_message', 'This role already exists. Try with another');
			}
		}
		else {
			$this -> session -> set_flashdata('error_message', 'Fields with * are mandatory');
		}
		redirect('roles', 'refresh');
	}

	/**
	 * Function to check the role name exists when add a new role
	 * @author Arunsankar
	 * @since 04-Aug-2016
	 */
	function checkRoleExists() {
		$roleName = $this -> input -> post('roleName');
		$isAlreadyExists = $this -> rolemanagemodel -> checkRoleNameExists($roleName);
		if (!$isAlreadyExists) {
			echo '1';
		}
		else {
			echo '0';
		}
	}

	/**
	 * Function to check the role name exists when edit a role
	 * @author Arunsankar
	 * @since 04-Aug-2016
	 */
	function checkRoleExistsOther() {
		$roleName = $this -> input -> post('roleName');
		$roleId = $this -> input -> post('roleId');
		$isAlreadyExists = $this -> rolemanagemodel -> checkRoleNameExistsOnOther($roleName, $roleId);
		if (!$isAlreadyExists) {
			echo '1';
		}
		else {
			echo '0';
		}
	}

	/**
	 * Function to get the role details
	 * @author Arunsankar
	 * @since 03-Aug-2016
	 */
	function getRoleDetails() {
		$roleId = $this -> input -> post('roleId');
		if (!empty($roleId)) {
			$roleNameArray = $this -> rolemanagemodel -> getRoleDetails($roleId);
			if (isset($roleNameArray['role_name'])) {
				echo $roleNameArray['role_name'];
			}
			else {
				echo '0';
			}
		}
		else {
			echo '0';
		}
	}

	/**
	 * Function to change the role status (Active/Inactive)
	 * @author Arunsankar
	 * @since 04-Aug-2016
	 */
	function changeRoleStatus() {
		$roleId = $this -> input -> post('roleId');
		if (!empty($roleId)) {
			$roleChangeStatus = $this -> rolemanagemodel -> changeRoleStatus($roleId);
			if ($roleChangeStatus) {
				echo $roleChangeStatus;
			}
			else {
				echo '0';
			}
		}
		else {
			echo '0';
		}
	}

	/**
	 * Function to delete(soft delete) the role
	 * @author Arunsankar
	 * @since 04-Aug-2016
	 */
	function deleteRole() {
		$roleId = $this -> input -> post('roleId');
		if (!empty($roleId)) {
			$isRoleDeleted = $this -> rolemanagemodel -> deleteRole($roleId);
			if ($isRoleDeleted) {
				$this -> session -> set_flashdata('success_message', 'Role deleted successfully');
				echo '1';
			}
			else {
				echo '0';
			}
		}
		else {
			echo '0';
		}
	}
}

/* End of file roles.php */
