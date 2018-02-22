<?php
class MCatsjob extends Model{
function MCatsjob(){
	parent::Model();
}



function navcategorie(){
	$data = array();
	$Q=$this->db->get('categories');
	
	if ($Q->num_rows() > 0){
		foreach ($Q->result() as $row){
			$data[$row->parentid] = $row->name;
			//$data[$row->id] = $row->name;
			
			//echo ">" . $data[$row->id];
			
		}
	
	}

	$Q->free_result();
	return $data;
}

function getCategory($parentid){
	$data = array();
	$options = array('parentid'=>$parentid);
	$Q = $this->db->getwhere('jobsummer',$options);
	if ($Q->num_rows() > 0){
		$data = $Q->result_array();	
	}
	
	$Q->free_result();
	return $data;
}

function getDescription($id){
	$data = array();
	$options = array('id'=>$id);
	$Q = $this->db->getwhere('jobsummer',$options);
	if ($Q->num_rows() > 0){
		$data = $Q->row_array();	
	}
	
	$Q->free_result();
	return $data;

}


function getAllCategories(){
		$data=array();
		$Q=$this->db->get('jobsummer');
		if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
		$data[]=$row;
		}
		}
		$Q->free_result();
		return $data;
}

function addUser($filepdf, $filepdf1){
$data = array(
	'name'=>$_POST['nome'],
	'surname'=>$_POST['cognome'],
	'email'=>$_POST['myemail'],
	'riferimento'=>$_POST['idannuncio'],
	'sex'=>$_POST['malefemale'],
	'homeaddress'=>$_POST['indirizzo'],
	'phone'=>$_POST['phonenumber'],
	'nationality'=>$_POST['nationality'],
	'nativelanguage'=>$_POST['nativelanguage'],
	'otherlanguagesspoken'=>$_POST['otherlanguagesspoken'],
	'levelspoken'=>$_POST['levelspoken'],
	'workbefore'=>$_POST['workplusbefore'],
	'available_from'=>$_POST['from'],
	'available_to'=>$_POST['to'],
	'centre'=>$_POST['centre'],
	'initialtefl'=>$_POST['initialtefl'],
	'highertefl'=>$_POST['highertefl'],
	'highertefl_year'=>$_POST['highertefl_year'],
	'first_aid'=>$_POST['firstaid'],
	'criminal'=>$_POST['criminal'],
	'crb'=>$_POST['crb'],
	'permit'=>$_POST['permit'],
	'medical'=>$_POST['medical'],
	'bank'=>$_POST['bank'],
	'pdf'=>$filepdf,
	'certificate'=>$filepdf1

);
$this->db->insert('job_contacts',$data);
		
}

}
?>