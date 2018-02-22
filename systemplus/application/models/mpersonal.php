<?php
class mpersonal extends Model{
function mpersonal(){
	parent::Model();
}





function checkmail($email){
		
		$data=array();
		//$this->db->select("id,email,nome,cognome,indirizzo,status");
		$Q = $this->db->get_where('job_contacts_all', array('email' => $email));
		if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data[]=$row;
		}
	}
	

		$Q->free_result();
		return $data;		
}

function update_status($id,$sortcode,$accountnumber,$accountname,$insurance){
	
	$miadata=date('Y-m-d');
	 
	$data = array(
			   'sortcode' => $sortcode,
			   'account_number' => $accountnumber,
			   'account_name' => $accountname,
			   'insurance' => $insurance
		
            );
	$this->db->where('id', $id);
	$this->db->update('job_contacts_all', $data);
}

function Multiplo($id){
	$data = array();
	$options = array('id_personal'=>$id);
	$Q = $this->db->getwhere('job_contract',$options);
	foreach ($Q->result_array() as $row){
		$data[]=$row;
	}
	/*
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	*/
	$Q->free_result();
	return $data;
}

function activecontract($id){
		
		$data1=array();
		$this->db->select("id,date_start,date_end,salary,center_def,type_contract,title,nome,cognome");
		$Q = $this->db->get_where('job_contacts_all', array('id' => $id));
		if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data1[]=$row;
		}
	}
	
		$Q->free_result();
		return $data1;
}

function printcontract($id){
		
		$data=array();
		//$this->db->select("id,date_start,date_end,salary,center_def,type_contract,title,nome,cognome");
		$Q = $this->db->get_where('job_contacts_all', array('id' => $id));
		if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data[]=$row;
		}
	}
	
		$Q->free_result();
		return $data;
}

function addPdf($id, $filepdf, $filepdf1){
$data = array(
	'pdf'=>$filepdf,
	'certificate'=>$filepdf1

);
$this->db->where('id', $id);
$this->db->update('job_contacts_all',$data);
		
}

function Contract($logmail){
	
	$data = array();
	$options = array('email'=>$logmail);
	$Q = $this->db->getwhere('job_contacts_all',$options);
	foreach ($Q->result_array() as $row){
		$data[]=$row;
	}

	
	$Q->free_result();
	return $data;
}

}
?>