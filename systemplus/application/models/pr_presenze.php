<?php
class PR_presenze extends Model{
function PR_presenze(){
	parent::Model();
}

function getTeachers($centro){
	$anno=date("Y");
	//Così non considero gli anni passati

$data = array();
$this->db->select("nome,cognome,center_def,status,date_start,date_end,id,checkpay,id_personal");

$this->db->where('center_def',$centro);
$this->db->where('date_start >', $anno.'-01-01');
$this->db->where('status','employed');
//$this->db->where('pwd',$term1);
	
	$Q = $this->db->get('job_contract');
	if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data[] = $row;
			
		}
	}
		$Q->free_result();
		return $data;
}

function usercenter($user,$password){
	$data = array();

	$this->db->where('user',$user);
	$this->db->where('password',$password);
		
		$Q = $this->db->get('user_center');
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[] = $row;
				
			}
		}
			//print_r($data);
			$Q->free_result();
			return $data;

}


function getTeacherExist($id){
$data = array();

$this->db->where('id_user',$id);
	
	$Q = $this->db->get('payroll');
	if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data[] = $row;
			
		}
	}
		$Q->free_result();
		return $data;
}

function getTeacher($id,$center){
$data = array();
$this->db->select("cognome, nome, center_def,status,date_start,date_end,id,id_personal");

$this->db->where('id_personal',$id);
$this->db->where('center_def',$center);
//$this->db->where('pwd',$term1);
	
	$Q = $this->db->get('job_contract');
	if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data[] = $row;
			
		}
	}
			
		$Q->free_result();
		return $data;
}

function findhour($id, $key, $item){

	$this->db->where('id_user',$id);
	$this->db->where('date_rif',$key);
	$Q = $this->db->get('payroll');
	if ($Q->num_rows() > 0){
		return TRUE;	
	}
		
}



function writehour($id, $key, $item,$center){
$data = array(
		'id_user'=>$id,
		'date_rif'=>$key,
		'work'=>$item,
		'center_def'=>$center
		
		
	
);
	$this->db->insert('payroll', $data);
}


function updatehour($key, $item){
	//Routine per inserire campo note
	if(substr($key,0,2)=="m_"){
			
			$inserisci='motivi';
			$key=substr($key,2);
		}else{
			$inserisci='work';
	}
$data = array(
		$inserisci=>$item
);

	$this->db->where('id',$key);
	$this->db->update('payroll', $data);
}

function details($id,$p,$weekact01,$weekact02,$residential,$bonus,$evaluation){
$data = array(
		'id_user'=>$id,
		'p'=>$p,
		'activity_one'=>$weekact01,
		'activity_two'=>$weekact02,
		'residential'=>$residential,
		'bonus'=>$bonus,
		'valuation'=>$evaluation
		
		
	
);
	$this->db->insert('employee_details', $data);
}

function DetailExist($id){
$data = array();

	$this->db->where('id_user',$id);	
	$Q = $this->db->get('employee_details');
	
	if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data[] = $row;
			
		}
	}
		
		$Q->free_result();
		return $data;
}

function detailsupdate($id,$p,$weekact01,$weekact02,$residential,$bonus,$evaluation){
$data = array(

		'p'=>$p,
		'activity_one'=>$weekact01,
		'activity_two'=>$weekact02,
		'residential'=>$residential,
		'bonus'=>$bonus,
		'valuation'=>$evaluation	
);
	$this->db->where('id_user',$id);
	$this->db->update('employee_details', $data);
}

/***  ADMIN CENTER ****/

function getCenterMenu(){
$data = array();
	$this->db->select("nome_centri");


	$Q = $this->db->get('centri');
	if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data[] = $row;
			
		}
	}
		/*
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		*/

		$Q->free_result();
		return $data;
}

function TeachersHours($id){
	$data = array();

	$this->db->where('id_user',$id);
	//$this->db->where('pwd',$term1);
	
	$Q = $this->db->get('payroll');
	if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data[] = $row;
			
		}
	}

		
		$Q->free_result();
		return $data;
}

function TeachersPay($id){
$data = array();
$this->db->select("nome,cognome,center_def,date_start,date_end,id,salary,sortcode,account_number,account_name,insurance,address,email,nationality,county,postcode,towncity,checkpay");

$this->db->where('id',$id);
//$this->db->where('pwd',$term1);
	
	$Q = $this->db->get('job_contacts_all');
	if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data[] = $row;
			
		}
	}

		$Q->free_result();
		return $data;
}

function TeachersDetails($id)
	{
$data = array();

$this->db->where('id_user',$id);
	
	$Q = $this->db->get('employee_details');
	if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data[] = $row;
			
		}
	}


		$Q->free_result();
		return $data;
}

function autorizza($id,$yesorno,$center){
	//echo $id ." - ". $yesorno;
$data = array(		
		'checkpay'=>$yesorno,
	);
	$this->db->where('id_personal',$id);
	$this->db->where('center_def',$center);
	$this->db->update('job_contract', $data);
}
}
?>