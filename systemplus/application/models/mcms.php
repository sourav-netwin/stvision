<?php
class MCms extends Model{
function MCms(){
	parent::Model();
}



function getAllCv(){
		$data=array();
		//$this->db->select("id,categories,typeofjob,nposti,nation,location,parentid");
		$this->db->order_by('id desc');
		$Q=$this->db->get('job_contacts_all',50);
		if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
		$data[]=$row;
		}
	}
		$Q->free_result();
		return $data;
}

function getCandidate($rif){
	$data = array();
	$options = array('riferimento'=>$rif);
	$Q = $this->db->getwhere('job_contacts',$options);
	foreach ($Q->result_array() as $row){
		$data[]=$row;
	}
	
	$Q->free_result();

	return $data;
	
}

function addJob($mtcategories){

$data = array('categories'=>$mtcategories,
	'typeofjob'=>$_POST['typeofjob'],
	'nposti'=>$_POST['ncandidate'],
	'nation'=>$_POST['nation'],
	'jobdescription'=>$_POST['jobdescription'],
	'parentid'=>$_POST['categories']
);
$this->db->insert('jobsummer',$data);
}

function Deljob($id){

	$this->db->where('id', $id);
	$this->db->delete('jobsummer'); 
}

function DelProfile($id){

	$this->db->where('id', $id);
	$this->db->delete('job_contacts_all'); 
}
function Delmcontract($id){

	$this->db->where('id', $id);
	$this->db->delete('job_contract'); 
}
function ViewProfile($id){
	$data = array();
	$options = array('id'=>$id);
	$Q = $this->db->getwhere('job_contacts_all',$options);
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
//Contratti Multipli
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

function MultiploEdit($id){
	$data = array();
	$options = array('id'=>$id);
	$Q = $this->db->getwhere('job_contract',$options);
	foreach ($Q->result_array() as $row){
		$data[]=$row;
	}
	
	$Q->free_result();
	return $data;
}

// End contratti Multipli

function getby($fstatus,$fcentre,$fposition,$fmonthfrom,$accomodationcentre,$workplusbefore,$towncity,$surname,$datainsert){
	$data = array();
	
	if($fstatus) { 
		$this->db->where('status',$fstatus) ;
	};
	if($fcentre) { 

		$this->db->where('preferredcentre',$fcentre) ;
	};
	if($fposition)
	{ 

		$this->db->where('preferredposition',$fposition);
	};
	if($fmonthfrom)
	{ 
		$array = array('monthworkfrom >=' => $fmonthfrom);
		$this->db->where($array);
	};
	if($accomodationcentre)
	{ 
		$this->db->where('accomodationcentre',$accomodationcentre);
	};
	if($workplusbefore)
	{ 
		$this->db->where('workplusbefore',$workplusbefore);
	};	
	if($towncity)
	{ 
		$this->db->where('towncity',$towncity);
	};
	if($surname)
	{ 
		$this->db->like('cognome',$surname);
	};
		if($datainsert)
	{ 
		$this->db->where('stamp >',$datainsert);
	};

	$Q = $this->db->get('job_contacts_all');

	foreach ($Q->result_array() as $row){
		$data[]=$row;
	}

	$Q->free_result();
	return $data;
}

function update_candidate($id){
	//Conversione Date per mysql annno mese giorno
	$eur_date_start = $_POST['date_start']; 
	$eur_date_end = $_POST['date_end']; 

	$eur_time_start = strtotime($eur_date_start);
	$eur_time_end = strtotime($eur_date_end);

	$date_start=date('Y-m-d',$eur_time_start);
	$date_end=date('Y-m-d',$eur_time_end);

	
	$data = array(
               'id' => $id,
			   'status' => $_POST['status'],
			   'date_start' => $date_start,
			   'date_end' => $date_end,
			   'salary' => $_POST['salary'],
			   'center_def' => $_POST['center_def'],
			   'type_contract' => $_POST['type_contract'],
			   'comment' => $_POST['comment']

		
            );
	$this->db->where('id', $id);
	$this->db->update('job_contacts_all', $data);
}
function update_anagrafica_contratti($idagente){
	//Conversione Date per mysql annno mese giorno
	$eur_date_start = $_POST['date_start']; 
	$eur_date_end = $_POST['date_end']; 

	$eur_time_start = strtotime($eur_date_start);
	$eur_time_end = strtotime($eur_date_end);

	$date_start=date('Y-m-d',$eur_time_start);
	$date_end=date('Y-m-d',$eur_time_end);

	
	$data = array(
            
			   'status' => $_POST['status'],
			   'date_start' => $date_start,
			   'date_end' => $date_end,
			   'salary' => $_POST['salary'],
			   'center_def' => $_POST['center_def'],
			   'type_contract' => $_POST['type_contract'],


		
            );
	$this->db->where('id', $idagente);
	$this->db->update('job_contacts_all', $data);
}


function update_payroll($idagente,$centre){
	$data = array();
	//echo $idagente . " " . $centre; 
	$options = array('id_user'=>$idagente,'center_def'=>$centre);
	$Q = $this->db->getwhere('payroll',$options);
	foreach ($Q->result_array() as $row){
		$data[]=$row;
	}

	$Q->free_result();

	return $data;
	
}
function allinea_payroll($date_rif,$id_user,$centro){

	$this->db->where('date_rif', $date_rif);
	$this->db->where('id_user', $id_user);
	$this->db->where('center_def', $centro);
	$this->db->delete('payroll'); 
}
function aggiungi_payroll($datapay,$id_user,$center_def){
	
	$data = array(
               'id_user' => $id_user,
			   'date_rif' => $datapay,
			   'center_def' => $center_def
            );
	$this->db->insert('payroll', $data);
}
function update_candidate_new($id){
	//Conversione Date per mysql annno mese giorno
	$eur_date_start = $_POST['date_start']; 
	$eur_date_end = $_POST['date_end']; 

	$eur_time_start = strtotime($eur_date_start);
	$eur_time_end = strtotime($eur_date_end);

	$date_start=date('Y-m-d',$eur_time_start);
	$date_end=date('Y-m-d',$eur_time_end);

	
	$data = array(
               'id_personal' => $id,
			   'status' => $_POST['status'],
			   'date_start' => $date_start,
			   'date_end' => $date_end,
			   'salary' => $_POST['salary'],
			   'center_def' => $_POST['center_def'],
			   'type_contract' => $_POST['type_contract'],
			   'comment' => $_POST['comment'],
			   'status' => $_POST['status'],
			   'nome' => $_POST['nome'],
			   'cognome'=> $_POST['cognome']

		
            );
	$this->db->where('id', $id);
	$this->db->insert('job_contract', $data);
}
function update_mcontract($id){
	//Conversione Date per mysql annno mese giorno
	$eur_date_start = $_POST['date_start']; 
	$eur_date_end = $_POST['date_end']; 

	$eur_time_start = strtotime($eur_date_start);
	$eur_time_end = strtotime($eur_date_end);

	$date_start=date('Y-m-d',$eur_time_start);
	$date_end=date('Y-m-d',$eur_time_end);

	
	$data = array(
               'id' => $id,
			   'date_start' => $date_start,
			   'date_end' => $date_end,
			   'salary' => $_POST['salary'],
			   'center_def' => $_POST['center_def'],
			   'status' => $_POST['status'],
			   'type_contract' => $_POST['type_contract']
            );
	$this->db->where('id', $id);
	$this->db->update('job_contract', $data);
}
function create_mcontract($id){
	//Conversione Date per mysql annno mese giorno
	$eur_date_start = $_POST['date_start']; 
	$eur_date_end = $_POST['date_end']; 

	$eur_time_start = strtotime($eur_date_start);
	$eur_time_end = strtotime($eur_date_end);

	$date_start=date('Y-m-d',$eur_time_start);
	$date_end=date('Y-m-d',$eur_time_end);

	
	$data = array(
               'id_personal' => $id,
			   'date_start' => $date_start,
			   'date_end' => $date_end,
			   'salary' => $_POST['salary'],
			   'center_def' => $_POST['center_def'],
            );
	$this->db->insert('job_contract',$data);
	//Metto 1 in contratto multiplo per dire al DB che ci sono contratti multipli
	$data_job = array(
               'id' => $id,
			   'multiplo' => 1
            );
	$this->db->where('id', $id);
	$this->db->update('job_contacts_all', $data_job);

}
function Contract($id){
	$data = array();
	$options = array('id'=>$id);
	$Q = $this->db->getwhere('job_contacts_all',$options);
	foreach ($Q->result_array() as $row){
		$data[]=$row;
	}
	
	$Q->free_result();
	return $data;
}

function update_status($id){
	// data Timestamp
			$datestring = "%Y-%m-%d %h:%i";
			$time = time();
			$datasend=mdate($datestring, $time);

	$data = array(
               'id' => $id,
			   'status' => "sentcontract",
			   'stamp' => $datasend
            );
	$this->db->where('id', $id);
	$this->db->update('job_contacts_all', $data);
}

function addPdf($id, $filepdf, $filepdf1){
$data = array(
	'pdf'=>$filepdf,
	'certificate'=>$filepdf1

);
$this->db->where('id', $id);
$this->db->update('job_contacts_all',$data);
		
}

}
?>