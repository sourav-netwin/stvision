<?php
class m_campusadmin extends Model{
function m_campusadmin(){
	parent::Model();
}



function getAllJob($campus){
		$data = array();
		$options = array('location'=>$campus);
		$Q = $this->db->getwhere('job_contacts', $options);
	
	foreach ($Q->result_array() as $row){
		$data[]=$row;
	}
	
	$Q->free_result();
	return $data;
}

function getCandidate($rif){
	$data = array();
	$options = array('id'=>$rif);
	$Q = $this->db->getwhere('job_contacts',$options);
	foreach ($Q->result_array() as $row){
		$data[]=$row;
	}
	
	$Q->free_result();
	return $data;
}
function update_candidate($id){
	
	$data = array(  
			'bonus' => $_POST['bonus'],
			'ninsurance' => $_POST['ninsurance'],
			'day_work' => $_POST['day_work'],
			'evaluation' => $_POST['evaluation']
            );
	$this->db->where('id', $id);
	$this->db->update('job_contacts', $data);
}


/*
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

function ViewProfile($id){
	$data = array();
	$options = array('id'=>$id);
	$Q = $this->db->getwhere('job_contacts',$options);
	foreach ($Q->result_array() as $row){
		$data[]=$row;
	}
	
	$Q->free_result();
	return $data;
}


function Contract($id){
	$data = array();
	$options = array('id'=>$id);
	$Q = $this->db->getwhere('job_contacts',$options);
	foreach ($Q->result_array() as $row){
		$data[]=$row;
	}
	$Q->free_result();
	return $data;
}

function update_status($id){
	
	$data = array(
               'id' => $id,
			   'status' => "send"
            );
	$this->db->where('id', $id);
	$this->db->update('job_contacts', $data);
}
*/

}
?>