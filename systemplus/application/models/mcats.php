<?php
class MCats extends Model{
function MCats(){
	parent::Model();
}
function getCategory($id){
$data = array();
$options = array('id'=>$id);
$Q = $this->db->getwhere('job_categories',$options,1);
if ($Q->num_rows() > 0){
$data = $Q->row_array();
}
$Q->free_result();
return $data;
}
function getAllCategories(){
$data = array();
$Q = $this->db->get('job_categories');
if ($Q->num_rows() > 0){
foreach ($Q->result_array() as $row){
$data[] = $row;
}
}
$Q->free_result();
return $data;
}

function getCategoriesNav(){
	$data = array();
	$Q=$this->db->get('job_categories');
	if ($Q->num_rows() > 0){
		foreach ($Q->result() as $row){
			$data[$row->id] = $row->name;
		}
	}
	$Q->free_result();
	return $data;
}


}


?>