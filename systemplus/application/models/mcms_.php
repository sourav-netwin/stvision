<?php
class MCms extends Model{
function MCms(){
	parent::Model();
}



function getAllJob(){
		$data=array();
		$this->db->select("id,categories,typeofjob,nposti,nation,location");
		$this->db->order_by("nation");
		$Q=$this->db->get('jobsummer');
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

function update_candidate($id){
	
	$data = array(
               'id' => $id,
               'name' => $_POST['name'],
               'surname' => $_POST['surname'],
			   'email' => $_POST['email'],
			   'notes' => $_POST['notes'],
			   'cost01' => $_POST['cost01'],
			   'data_contratto' => $_POST['data_contratto'],
			   'location' => $_POST['location'],
			   'status' => $_POST['status']
            );
	$this->db->where('id', $id);
	$this->db->update('job_contacts', $data);
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


}
?>