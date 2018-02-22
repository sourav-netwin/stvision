<?php

class Gestione_centri_model extends Model{


function insertBook(){
    $st_ensuite = $this->input->xss_clean($this->input->post('st_ensuite'));
	$st_standard = $this->input->xss_clean($this->input->post('st_standard'));
	$st_homestay = $this->input->xss_clean($this->input->post('st_homestay'));
	$st_twin = $this->input->xss_clean($this->input->post('st_twin'));
    	$gl_ensuite = $this->input->xss_clean($this->input->post('gl_ensuite'));
	$gl_standard = $this->input->xss_clean($this->input->post('gl_standard'));
	$gl_homestay = $this->input->xss_clean($this->input->post('gl_homestay'));
	$gl_twin = $this->input->xss_clean($this->input->post('gl_twin'));
	$tot_pax = $st_ensuite+$st_standard+$st_homestay+$st_twin+$gl_ensuite+$gl_standard+$gl_homestay+$gl_twin;
	$arr = explode("/", $this->input->post('arrival_date'));
	$data_arrivo=$arr[2]."-".$arr[0]."-".$arr[1];
	$arr2 = explode("/", $this->input->post('departure_date'));
	$data_partenza=$arr2[2]."-".$arr2[0]."-".$arr2[1];
    $data = array(
      'id_prodotto' => $this->input->xss_clean($this->input->post('prod_select')),
      'id_centro' => $this->input->xss_clean($this->input->post('center_select')),
	  'id_agente' => $this->session->userdata('id'),
	  'arrival_date' => $data_arrivo,
	  'departure_date' => $data_partenza,
	  'weeks' => $this->input->xss_clean($this->input->post('n_weeks')),
	  'tot_pax' => $tot_pax,
	  'id_year' => date("Y")
        );
    $this->db->insert('plused_book', $data);
    //echo $this->db->last_query();
	return $this->db->insert_id();
}

function insertRows($book_id,$anno,$id_agente){
    	$st_ensuite = $this->input->xss_clean($this->input->post('st_ensuite'));
	$st_standard = $this->input->xss_clean($this->input->post('st_standard'));
	$st_homestay = $this->input->xss_clean($this->input->post('st_homestay'));
	$st_twin = $this->input->xss_clean($this->input->post('st_twin'));
    	$gl_ensuite = $this->input->xss_clean($this->input->post('gl_ensuite'));
	$gl_standard = $this->input->xss_clean($this->input->post('gl_standard'));
	$gl_homestay = $this->input->xss_clean($this->input->post('gl_homestay'));
	$gl_twin = $this->input->xss_clean($this->input->post('gl_twin'));
	$arr = explode("/", $this->input->post('arrival_date'));
	$data_arrivo=$arr[2]."-".$arr[0]."-".$arr[1];
	$arr2 = explode("/", $this->input->post('departure_date'));
	$data_partenza=$arr2[2]."-".$arr2[0]."-".$arr2[1];
        
	for($x=0;$x<$st_ensuite;$x++){
		$newpwd="";
		do{
			$newpwd = $this->GESTgenerateUUID();
			$i = $this->GESTcheckUUID($newpwd);
		}while ($i > 0);
		//AGENTE STUDYTOURS, NON INSERISCO UUID
		if($id_agente==795)
			$newpwd="";
		$data = array(
			'id_year' => $anno,
			'id_book' => $book_id,
			'accomodation' => 'ensuite',
			'tipo_pax' => "STD",
			'andata_data_arrivo' => $data_arrivo,
			'ritorno_data_partenza' => $data_partenza,
			'data_arrivo_campus' => $data_arrivo,
			'data_partenza_campus' => $data_partenza,
			'uuid' => $newpwd
		);
		$this->db->insert('plused_rows', $data);
	}
	for($x=0;$x<$st_standard;$x++){
		$newpwd="";
		do{
			$newpwd = $this->GESTgenerateUUID();
			$i = $this->GESTcheckUUID($newpwd);
		}while ($i > 0);
		//AGENTE STUDYTOURS, NON INSERISCO UUID
		if($id_agente==795)
			$newpwd="";
		$data = array(
			'id_year' => $anno,
			'id_book' => $book_id,
			'accomodation' => 'standard',
			'tipo_pax' => "STD",
			'andata_data_arrivo' => $data_arrivo,
			'ritorno_data_partenza' => $data_partenza,
			'data_arrivo_campus' => $data_arrivo,
			'data_partenza_campus' => $data_partenza,
			'uuid' => $newpwd
		);
		$this->db->insert('plused_rows', $data);
	}
	for($x=0;$x<$st_homestay;$x++){
		$newpwd="";
		do{
			$newpwd = $this->GESTgenerateUUID();
			$i = $this->GESTcheckUUID($newpwd);
		}while ($i > 0);
		//AGENTE STUDYTOURS, NON INSERISCO UUID
		if($id_agente==795)
			$newpwd="";
		$data = array(
			'id_year' => $anno,
			'id_book' => $book_id,
			'accomodation' => 'homestay',
			'tipo_pax' => "STD",
			'andata_data_arrivo' => $data_arrivo,
			'ritorno_data_partenza' => $data_partenza,
			'data_arrivo_campus' => $data_arrivo,
			'data_partenza_campus' => $data_partenza,
			'uuid' => $newpwd
		);
		$this->db->insert('plused_rows', $data);
	}
	for($x=0;$x<$st_twin;$x++){
		$newpwd="";
		do{
			$newpwd = $this->GESTgenerateUUID();
			$i = $this->GESTcheckUUID($newpwd);
		}while ($i > 0);
		//AGENTE STUDYTOURS, NON INSERISCO UUID
		if($id_agente==795)
			$newpwd="";
		$data = array(
			'id_year' => $anno,
			'id_book' => $book_id,
			'accomodation' => 'twin',
			'tipo_pax' => "STD",
			'andata_data_arrivo' => $data_arrivo,
			'ritorno_data_partenza' => $data_partenza,
			'data_arrivo_campus' => $data_arrivo,
			'data_partenza_campus' => $data_partenza,
			'uuid' => $newpwd
		);
		$this->db->insert('plused_rows', $data);
	}
	for($x=0;$x<$gl_ensuite;$x++){
		$newpwd="";
		do{
			$newpwd = $this->GESTgenerateUUID();
			$i = $this->GESTcheckUUID($newpwd);
		}while ($i > 0);
		//AGENTE STUDYTOURS, NON INSERISCO UUID
		if($id_agente==795)
			$newpwd="";
		$data = array(
			'id_year' => $anno,
			'id_book' => $book_id,
			'accomodation' => 'ensuite',
			'tipo_pax' => "GL",
			'andata_data_arrivo' => $data_arrivo,
			'ritorno_data_partenza' => $data_partenza,
			'data_arrivo_campus' => $data_arrivo,
			'data_partenza_campus' => $data_partenza,
			'uuid' => $newpwd
		);
		$this->db->insert('plused_rows', $data);
	}
	for($x=0;$x<$gl_standard;$x++){
		$newpwd="";
		do{
			$newpwd = $this->GESTgenerateUUID();
			$i = $this->GESTcheckUUID($newpwd);
		}while ($i > 0);
		//AGENTE STUDYTOURS, NON INSERISCO UUID
		if($id_agente==795)
			$newpwd="";
		$data = array(
			'id_year' => $anno,
			'id_book' => $book_id,
			'accomodation' => 'standard',
			'tipo_pax' => "GL",
			'andata_data_arrivo' => $data_arrivo,
			'ritorno_data_partenza' => $data_partenza,
			'data_arrivo_campus' => $data_arrivo,
			'data_partenza_campus' => $data_partenza,
			'uuid' => $newpwd
		);
		$this->db->insert('plused_rows', $data);
	}
	for($x=0;$x<$gl_homestay;$x++){
		$newpwd="";
		do{
			$newpwd = $this->GESTgenerateUUID();
			$i = $this->GESTcheckUUID($newpwd);
		}while ($i > 0);
		//AGENTE STUDYTOURS, NON INSERISCO UUID
		if($id_agente==795)
			$newpwd="";
		$data = array(
			'id_year' => $anno,
			'id_book' => $book_id,
			'accomodation' => 'homestay',
			'tipo_pax' => "GL",
			'andata_data_arrivo' => $data_arrivo,
			'ritorno_data_partenza' => $data_partenza,
			'data_arrivo_campus' => $data_arrivo,
			'data_partenza_campus' => $data_partenza,
			'uuid' => $newpwd
		);
		$this->db->insert('plused_rows', $data);
	}
	for($x=0;$x<$gl_twin;$x++){
		$newpwd="";
		do{
			$newpwd = $this->GESTgenerateUUID();
			$i = $this->GESTcheckUUID($newpwd);
		}while ($i > 0);
		//AGENTE STUDYTOURS, NON INSERISCO UUID
		if($id_agente==795)
			$newpwd="";
		$data = array(
			'id_year' => $anno,
			'id_book' => $book_id,
			'accomodation' => 'twin',
			'tipo_pax' => "GL",
			'andata_data_arrivo' => $data_arrivo,
			'ritorno_data_partenza' => $data_partenza,
			'data_arrivo_campus' => $data_arrivo,
			'data_partenza_campus' => $data_partenza,
			'uuid' => $newpwd
		);
		$this->db->insert('plused_rows', $data);
	}
}

function getLastPaxByBkId($id_book){
	$data=array();
	$this->db->where(array('id_book' => $id_book , 'tipo_pax' => 'STD'));
	$this->db->order_by('id_prenotazione', 'desc');
	$Q=$this->db->get('plused_rows',1,0);
	//echo $this->db->last_query();
	if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
			$data[]=$row;
		}
	}
	$Q->free_result();
	return $data;
}

function addPaxToRoster($id_book){
	$oldPax = $this->getLastPaxByBkId($id_book);
	//print_r($oldPax);
	//die();
	do{
		$newpwd = $this->GESTgenerateUUID();
		$i = $this->GESTcheckUUID($newpwd);
	}while ($i > 0);
	$data = array(
		'id_year' => $oldPax[0]["id_year"],
		'id_book' => $id_book,
		'accomodation' => $oldPax[0]["accomodation"],
		'tipo_pax' => "STD",
		'andata_data_arrivo' => $oldPax[0]["andata_data_arrivo"],
		'ritorno_data_partenza' => $oldPax[0]["ritorno_data_partenza"],
		'data_arrivo_campus' => $oldPax[0]["data_arrivo_campus"],
		'data_partenza_campus' => $oldPax[0]["data_partenza_campus"],
		'uuid' => $newpwd
	);
	$this->db->insert('plused_rows', $data);
	$sqlCount = "UPDATE plused_book SET tot_pax = tot_pax + 1 WHERE id_book = $id_book";
	$Q=$this->db->query($sqlCount);
	return $oldPax[0]["accomodation"];
}


function delPaxFromRoster($id_prenotazione, $id_book){
	$data=array();
	//all'integrazione di trasportation/excursion check here per controlli
    $this->db->where('id_prenotazione',$id_prenotazione);
    $this->db->delete('plused_rows');
	$sqlCount = "UPDATE plused_book SET tot_pax = tot_pax - 1 WHERE id_book = $id_book";
	$Q=$this->db->query($sqlCount);
	return true;
}

function centerNameById($idcentro){
		$data=array();
        $this->db->where('id',$idcentro);
        $Q=$this->db->get('centri');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
        if(isset($data[0]["nome_centri"]))
            return $data[0]["nome_centri"];
        else
            return " - ";
}

function getCampusByLocation($location,$attivi=0){
        $data=array();
        $this->db->from('centri');
        $this->db->where('located_in',$location);
		if($attivi==1){
			$this->db->where('attivo',1);
		}
        $this->db->order_by('nome_centri', "asc");
        $Q=$this->db->get();
        if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
					$data[]=$row;
				}
        }
        $Q->free_result();
        return $data;
}

function getCampusByLocationProgram($location,$idProgramma,$attivi=0){
        $data=array();
        $this->db->from('centri');
		$this->db->join('plused_join_prodotti_centri', 'centri.id = plused_join_prodotti_centri.pjpc_centro');
        $this->db->where('centri.located_in',$location);
		$this->db->where('plused_join_prodotti_centri.pjpc_prodotto',$idProgramma);
		if($attivi==1){
			$this->db->where('centri.attivo',1);
		}
        $this->db->order_by('centri.nome_centri', "asc");
        $Q=$this->db->get();
        if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
					$data[]=$row;
				}
        }
        $Q->free_result();
        return $data;
}

function getPrefDest(){
        $data=array();
        $this->db->from('plused_popular_destinations');
        $this->db->order_by('pp_dest', "asc");
        $Q=$this->db->get();
        if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
					$data[]=$row;
				}
        }
        $Q->free_result();
        return $data;
}

    //Query per inserimento dati

    function insert($id_group,$stringa_id,$login){

       $data = array(

         //Insert booking IN //

        'data_inizio' => date('Y-m-d',strtotime($_POST['date_start'])),
        'ore_arrivo' => $this->input->xss_clean($this->input->post('arrival_time')),
        'n_volo_arrivo' => $this->input->xss_clean($this->input->post('arrival_flight')),

        //Insert booking OUT //

        'data_fine' => date('Y-m-d',strtotime($_POST['date_end'])),
        'ore_partenza' => $this->input->xss_clean($this->input->post('departure_time')),
        'n_volo_partenza' => $this->input->xss_clean($this->input->post('departure_flight')),
        'tot_pax' => $this->input->xss_clean($this->input->post('totpax')),

        // Select //
        'id_centro' => $this->input->xss_clean($this->input->post('scuole')),
        'accomodation' => $this->input->xss_clean($this->input->post('choose')),
        'id_airport_arrivo' => $this->input->xss_clean($this->input->post('aereo_in')),
        'id_airport_partenza' => $this->input->xss_clean($this->input->post('aereo_out')),
        'id_agency' => $this->input->xss_clean($this->input->post('agency')),
	 'weeks' => $this->input->xss_clean($this->input->post('weeks')),
        'n_gruppo' => $this->input->xss_clean($this->input->post('n_group')),
        'id_nome_gruppo' => $id_group,
        'rand' => $stringa_id,
        'arrival_service' => $this->input->xss_clean($this->input->post('service_in')),
        'partenza_service' => $this->input->xss_clean($this->input->post('service_out')),
        'user'=>$login

      );
        $this->db->insert('periodi', $data);
    }

function insert_plan($centro,$rand,$date_in,$date_out,$date_in,$type,$excursion,$durata,$user,$tot_pax,$group_leader,$agente,$n_gruppo){

   $data = array(

            'rand'          =>$rand,
            'center'        =>$centro,
            'date_in'       =>$date_in,
            'date_out'      =>$date_out,
            'type'          =>$type,
            'excursion'     =>$excursion,
            'user'          =>$user,
            'gl'            =>$group_leader,
            'agents'        =>$agente,
            'tot_pax'       =>$tot_pax,
            'n_gruppo'      =>$n_gruppo,
            'durata'        =>$durata,
       );
   $this->db->insert('excursion_plan_confirmed', $data);
}

function excursion_selected_7($last_rand){
         $data=array();
                $this->db->join('excursion_plan', 'excursion_plan.centro = periodi.id_centro');
                $this->db->where('rand',$last_rand);
                $this->db->where('durata <=','7');
                $Q=$this->db->get('periodi');
                if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                $data[]=$row;
                }
            }
            $Q->free_result();
            return $data;
}

function excursion_selected_14($last_rand){
         $data=array();
                $this->db->join('excursion_plan', 'excursion_plan.centro = periodi.id_centro');
                $this->db->where('rand',$last_rand);
                $this->db->where('durata >=','1');
                $this->db->where('durata <=','14');
                $Q=$this->db->get('periodi');
                if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                $data[]=$row;
                }
            }
            $Q->free_result();
            return $data;
}

function excursion_selected_extra_14($last_rand){
         $data=array();
                $this->db->join('excursion_plan', 'excursion_plan.centro = periodi.id_centro');
                $this->db->where('rand',$last_rand);
                $this->db->where('durata >=','1');
                $this->db->where('durata <=','21');
                $Q=$this->db->get('periodi');
                if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                $data[]=$row;
                }
            }
            $Q->free_result();
            return $data;
}

function ultimo_id(){
        $data=array();
            $this->db->select('id');
            $this->db->order_by('id', "desc");
            $Q=$this->db->get('periodi',1);
            if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
            $data[]=$row;
            }
        }
            $Q->free_result();
            return $data;
}

function ultimo_rand(){
        $data=array();
            $this->db->select('rand');
            $this->db->order_by('id', "desc");
            $Q=$this->db->get('periodi',1);
            if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
            $data[]=$row;
            }
        }
            $Q->free_result();
            return $data;
}

function insert_room(){
    $data = array(
        'id_centro'                 => $this->input->xss_clean(strtoupper($this->input->post('centri'))),
        'date_in'                   => $this->input->xss_clean($this->input->post('date_in')),
        'date_end'                  => $this->input->xss_clean($this->input->post('date_end')),
        'single'                    => $this->input->xss_clean($this->input->post('single')),
        'double'                    => $this->input->xss_clean($this->input->post('double')),
        'single_ensuite'            => $this->input->xss_clean($this->input->post('single_ensuite')),
        'double_ensuite'            => $this->input->xss_clean($this->input->post('double_ensuite')),
        'triple'                    => $this->input->xss_clean($this->input->post('triple')),
        'triple_ensuite'            => $this->input->xss_clean($this->input->post('triple_ensuite')),
        'quadruple'                 => $this->input->xss_clean($this->input->post('quadruple')),
        'quadruple_ensuite'         => $this->input->xss_clean($this->input->post('quadruple_ensuite')),
        'tot_standard'              => $this->input->xss_clean($this->input->post('tot_standard')),
        'tot_ensuite'               => $this->input->xss_clean($this->input->post('tot_ensuite')),
        'halls_of_residence_1'      => $this->input->xss_clean($this->input->post('halls_of_residence_1')),
        'halls_of_residence_2'      => $this->input->xss_clean($this->input->post('halls_of_residence_2')),
        'halls_of_residence_3'      => $this->input->xss_clean($this->input->post('halls_of_residence_3')),
        'halls_of_residence_4'      => $this->input->xss_clean($this->input->post('halls_of_residence_4')),
        'halls_of_residence_5'      => $this->input->xss_clean($this->input->post('halls_of_residence_5'))

    );
    $this->db->insert('periodi_centri', $data);
}

function insert_excursions($login){
    $data = array(

        'id_pratica'       => $this->input->xss_clean($this->input->post('rand')),
        'agents'           => $this->input->xss_clean($this->input->post('agent')),
        'gl'               => $this->input->xss_clean($this->input->post('gl')),
        'type'             => $this->input->xss_clean($this->input->post('gender')),
        'excursion'        => $this->input->xss_clean($this->input->post('excursion')),
        'centro'           => $this->input->xss_clean($this->input->post('centro')),
        'data_in'          => $this->input->xss_clean($this->input->post('data_inizio')),
        'data_out'         => $this->input->xss_clean($this->input->post('data_fine')),
        'tot_pax'          => $this->input->xss_clean($this->input->post('tot_pax')),
        'price_14'         => $this->input->xss_clean($this->input->post('price_14')),
        'price_16'         => $this->input->xss_clean($this->input->post('price_16')),
        'price_24'         => $this->input->xss_clean($this->input->post('price_24')),
        'price_25'         => $this->input->xss_clean($this->input->post('price_25')),
        'price_28'         => $this->input->xss_clean($this->input->post('price_28')),
        'price_29'         => $this->input->xss_clean($this->input->post('price_29')),
        'price_33'         => $this->input->xss_clean($this->input->post('price_33')),
        'price_35'         => $this->input->xss_clean($this->input->post('price_35')),
        'price_38'         => $this->input->xss_clean($this->input->post('price_38')),
        'price_41'         => $this->input->xss_clean($this->input->post('price_41')),
        'price_45'         => $this->input->xss_clean($this->input->post('price_45')),
        'price_49'         => $this->input->xss_clean($this->input->post('price_49')),
        'price_50'         => $this->input->xss_clean($this->input->post('price_50')),
        'price_51'         => $this->input->xss_clean($this->input->post('price_51')),
        'price_53'         => $this->input->xss_clean($this->input->post('price_53')),
        'price_55'         => $this->input->xss_clean($this->input->post('price_55')),
        'price_57'         => $this->input->xss_clean($this->input->post('price_57')),
        'price_70'         => $this->input->xss_clean($this->input->post('price_70')),
        'price_75'         => $this->input->xss_clean($this->input->post('price_75')),
        'user'             =>$login
        );
     $this->db->insert('excursion_confirmed', $data);
}


function update_excursion_confirmed($tot_pax,$price_14,$price_16,$price_24,$price_25,$price_28,$price_29,$price_33,$price_35,$price_38,$price_41,$price_45,$price_49,$price_50,$price_51,$price_53,$price_55,$price_57,$price_70,$price_75,$to,$centro,$gender,$rand){
         $data=array(


           'tot_pax'            =>$tot_pax,
           'price_14'         => $price_14,
            'price_16'         => $price_16,
            'price_24'         => $price_24,
            'price_25'         => $price_25,
            'price_28'         => $price_28,
            'price_29'         => $price_29,
            'price_33'         => $price_33,
            'price_35'         => $price_35,
            'price_38'         => $price_38,
            'price_41'         => $price_41,
            'price_45'         => $price_45,
            'price_49'         => $price_49,
            'price_50'         => $price_50,
            'price_51'         => $price_51,
            'price_53'         => $price_53,
            'price_55'         => $price_55,
            'price_57'         => $price_57,
            'price_70'         => $price_70,
            'price_75'         => $price_75



);
        $this->db->where('id_pratica', $rand);
        $this->db->where('centro', $centro);
        $this->db->where('excursion', $to);
        $this->db->where('type', $gender);
        $this->db->update('excursion_confirmed',$data);
}


function insert_extra_excursions($rand,$excursion,$extra_ex,$prezzo,$indirizzo,$opzione,$login){
    $data = array(
        'pratica'               => $rand,
        'excursion'             => $excursion,
        'extra_excursion'       => $extra_ex,
        'address'               => $indirizzo,
        'price'                 => $prezzo,
        'opzione'               => $opzione,
        'user'                  => $login
        );
     $this->db->insert('excursion_extra_confirmed', $data);
}

function insert_agent(){
    $data = array(
        'name' => $this->input->xss_clean($this->input->post('agent')),
        'nation' => $this->input->xss_clean($this->input->post('nation')),
        'address' => $this->input->xss_clean($this->input->post('address'))
        );
    $this->db->insert('agency', $data);
}

function insert_gruppo(){

    $data = array(
      'name_group' => $this->input->xss_clean($this->input->post('group')),
      'id_agency' => $this->input->xss_clean($this->input->post('agency')),
        );
    $this->db->insert('group', $data);
}

function nome_gruppo($id_name){
      $data=array();
                    $this->db->order_by("id", "desc");
                    $this->db->limit(1);
                    $this->db->where('name_group',$id_name);
                    $Q=$this->db->get('group');
                    if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                    $data[]=$row;
                    }
            }
                    $Q->free_result();
                    return $data;
}


function insert_center(){
    $data = array(
      'nome_centri' => $this->input->xss_clean(strtoupper($this->input->post('nome_centri'))),
      'address' => $this->input->xss_clean($this->input->post('address')),
      'school_name' => $this->input->xss_clean($this->input->post('school_name')),
      'rooms' => $this->input->xss_clean($this->input->post('rooms')),
      'address' => $this->input->xss_clean($this->input->post('address')),
    'post_code' => $this->input->xss_clean($this->input->post('post_code')),
    'telephone' => $this->input->xss_clean($this->input->post('telephone')),
    'plus_contact' => $this->input->xss_clean($this->input->post('plus_contact')),
    'plus_contact_number' => $this->input->xss_clean($this->input->post('plus_contact_number')),
    'plus_office' => $this->input->xss_clean($this->input->post('plus_office')),
        'standard' => $this->input->xss_clean($this->input->post('standard')),
        'ensuite' => $this->input->xss_clean($this->input->post('ensuite')),
        'homestay' => $this->input->xss_clean($this->input->post('homestay')),
    'tennis' => $this->input->xss_clean($this->input->post('tennis')),
    'swimming_pool_out' => $this->input->xss_clean($this->input->post('swimming_pool_out')),
    'swimming_pool_in' => $this->input->xss_clean($this->input->post('swimming_pool_in')),
    'soccer' => $this->input->xss_clean($this->input->post('soccer')),
    'basket' => $this->input->xss_clean($this->input->post('basket')),
    'gym' => $this->input->xss_clean($this->input->post('gym')),
    'cricket' => $this->input->xss_clean($this->input->post('cricket')),
    'muti_task_gym' => $this->input->xss_clean($this->input->post('muti_task_gym')),
    'incuded_college_fee_sport' => $this->input->xss_clean($this->input->post('incuded_college_fee_sport')),
    'incuded_college_fee_rooms' => $this->input->xss_clean($this->input->post('incuded_college_fee_rooms')),
    'age_limit_required' => $this->input->xss_clean($this->input->post('age_limit_required')),
    'min_age' => $this->input->xss_clean($this->input->post('min_age_req')),
    'excursion_included_1_full' => $this->input->xss_clean($this->input->post('excursion_included_1')),
    'excursion_included_2_full' => $this->input->xss_clean($this->input->post('excursion_included_2')),
    'excursion_included_3_full' => $this->input->xss_clean($this->input->post('excursion_included_3')),
    'excursion_included_1_half' => $this->input->xss_clean($this->input->post('excursion_half_1')),
    'excursion_included_2_half' => $this->input->xss_clean($this->input->post('excursion_half_2')),
    'excursion_included_3_half' => $this->input->xss_clean($this->input->post('excursion_half_3')),
    'halls_residence_1' => $this->input->xss_clean($this->input->post('halls_residence_1')),
    'halls_residence_2' => $this->input->xss_clean($this->input->post('halls_residence_2')),
    'halls_residence_3' => $this->input->xss_clean($this->input->post('halls_residence_3')),
    'halls_residence_4' => $this->input->xss_clean($this->input->post('halls_residence_4')),
    'halls_residence_5' => $this->input->xss_clean($this->input->post('halls_residence_5')),

        );
    $this->db->insert('centri', $data);
}

function all_excursions($centro){
 $data=array();
                    $this->db->where('nome_centri',$centro);
                    $Q=$this->db->get('centri');
                    if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                    $data[]=$row;
                    }
            }
                    $Q->free_result();
                    return $data;
              }


function insert_escursion(){
    $data = array(
      'itinerario' => $this->input->xss_clean($this->input->post('escursioni')),

        );
    $this->db->insert('escursions', $data);
}

function building(){
               $data=array();
                    //$this->db->select("id,categories,typeofjob,nposti,nation,location,parentid");
                    $this->db->order_by('nome_centri');
                    $Q=$this->db->get('centri');
                    if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                    $data[]=$row;
                    }
            }
                    $Q->free_result();
                    return $data;
}

function buildCampusByProgramId($idProgramma,$attivi=0){
               $data=array();
        $this->db->from('centri');
		$this->db->join('plused_join_prodotti_centri', 'centri.id = plused_join_prodotti_centri.pjpc_centro');
		$this->db->where('plused_join_prodotti_centri.pjpc_prodotto',$idProgramma);
		if($attivi==1){
			$this->db->where('centri.attivo',1);
		}
        $this->db->order_by('centri.nome_centri', "asc");
        $Q=$this->db->get();
                    if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                    $data[]=$row;
                    }
            }
                    $Q->free_result();
                    return $data;
}


function list_campus_info($campus){
    $data=array();

                    $this->db->from('centri');
                    $this->db->where('nome_centri',$campus);
                    $Q=$this->db->get();
                    if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                    $data[]=$row;
                    }
            }
                    $Q->free_result();
                    return $data;
}

function edit_campus($centro){
               $data=array();

                    $this->db->from('centri');
                    $this->db->where('nome_centri',$centro);
                    $Q=$this->db->get();
                    if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                    $data[]=$row;
                    }
            }
                    $Q->free_result();
                    return $data;
}

 function  update_campus($id){

     $data=array(

           'id'                         => $id,
           'nome_centri'                =>strtoupper($_POST ['nome_centri']),
           'address'                    =>$_POST ['address'],
           'school_name'                =>$_POST ['school_name'],
           'post_code'                  =>$_POST ['post_code'],
           'telephone'                  =>$_POST ['telephone'],
           'plus_contact'               =>$_POST ['plus_contact'],
           'plus_contact_number'        =>$_POST ['plus_contact_number'],
           'plus_office'                =>$_POST ['plus_office'],
           'standard'                   =>@$_POST ['standard'],
           'ensuite'                    =>@$_POST ['ensuite'],
           'homestay'                   =>@$_POST ['homestay'],
           'swimming_pool_out'          =>@$_POST ['swimming_pool_out'],
           'swimming_pool_in'           =>@$_POST ['swimming_pool_in'],
           'basket'                     =>@$_POST ['basket'],
           'table_tennis'               =>@$_POST ['table_tennis'],
           'volleyball'                 =>@$_POST ['volleyball'],
           'baseball'                   =>@$_POST ['baseball'],
           'badminton'                  =>@$_POST ['badminton'],
           'gym'                        =>@$_POST ['gym'],
           'muti_task_gym'              =>@$_POST ['muti_task_gym'],
           'tennis'                     =>@$_POST ['tennis'],
           'soccer'                     =>@$_POST ['soccer'],
           'cricket'                    =>@$_POST ['cricket'],
           'incuded_college_fee_sport'  =>@$_POST ['incuded_college_fee_sport'],
           'age_limit_required'         =>@$_POST ['age_limit_required'],
           'min_age'                    =>@$_POST ['min_age'],
           'rooms'                      =>@$_POST ['rooms'],
           'incuded_college_fee_rooms'  =>@$_POST ['incuded_college_fee_rooms'],
           'halls_residence_1'          =>$_POST ['halls_residence_1'],
           'halls_residence_2'          =>$_POST ['halls_residence_2'],
           'halls_residence_3'          =>$_POST ['halls_residence_3'],
           'halls_residence_4'          =>$_POST ['halls_residence_4'],
           'halls_residence_5'          =>$_POST ['halls_residence_5'],
           'excursion_included_1_full'  =>$_POST ['excursion_included_1_full'],
           'excursion_included_2_full'  =>$_POST ['excursion_included_2_full'],
           'excursion_included_3_full'  =>$_POST ['excursion_included_3_full'],
           'excursion_included_1_half'  =>$_POST ['excursion_included_1_half'],
           'excursion_included_2_half'  =>$_POST ['excursion_included_2_half'],
           'excursion_included_3_half'  =>$_POST ['excursion_included_3_half']
);
        $this->db->where('id', $id);
        $this->db->update('centri',$data);


              }
function reupera_password($email){
$data=array();

    $this->db->select('password,email,login');
    $this->db->where('email',$email);
    $Q=$this->db->get('agenti');
    if ($Q->num_rows() > 0){
    foreach ($Q->result_array() as $row){
    $data[]=$row;
    }
}
    $Q->free_result();
    return $data;
}
function accomodation($nome_centri){
    $data=array();

$this->db->where('nome_centri',$nome_centri);
                    $Q=$this->db->get('centri');
                    if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                    $data[]=$row;
                    }
            }

                    $Q->free_result();
                    return $data;
}
function groupleader_log($id){
$data=array();

    $this->db->distinct();
    $this->db->select('name_group');
    $this->db->where('id_agency',$id);
    //$this->db->order_by('name_group');
    $Q=$this->db->get('group');
    if ($Q->num_rows() > 0){
    foreach ($Q->result_array() as $row){
    $data[]=$row;
    }
}
    $Q->free_result();
    return $data;
}

function groupleader($id){
$data=array();
    //$this->db->select("id,categories,typeofjob,nposti,nation,location,parentid");
    $this->db->where('id_agency',$id);
    $this->db->order_by('name_group');
    $Q=$this->db->get('group');
    if ($Q->num_rows() > 0){
    foreach ($Q->result_array() as $row){
    $data[]=$row;
    }
}
    $Q->free_result();
    return $data;
}


function airport(){
               $data=array();
                    $this->db->order_by('id');
                    $Q=$this->db->get('airport');
                    if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                    $data[]=$row;
                    }
            }
                    $Q->free_result();
                    return $data;
              }
  function airport_back(){
               $data=array();
                    $this->db->order_by('id');
                    $Q=$this->db->get('airport_back');
                    if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                    $data[]=$row;
                    }
            }
                    $Q->free_result();
                    return $data;
              }
    //Query per la  select che prende dinamicamente l'elenco dell'agenzie

function agency_building(){
               $data=array();

                    $this->db->order_by('login');
                    $this->db->where('mainfirstname !=','');
                    $this->db->where('mainfamilyname !=','');
                    $Q=$this->db->get('agenti');
                    if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                    $data[]=$row;
                    }
            }


                    $Q->free_result();
                    return $data;
              }
function validate(){

                    $this->db->where('username',$this->input->post('username'));
                    $this->db->where('password',$this->input->post('password'));
                    $Q= $this->db->get('members');
                    $Q->num_rows;

                    if($Q->num_rows() > 0){

                        return true;
                    }

              }


function count(){
$data = array();
    $this->db->where('data_inizio',$check);
    $this->db->where('id_centro',$idcentro);
    $Q = $this->db->get('periodi');
    if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                    $data[] = $row;
            }
    }

    $Q->free_result();
    return $data;

}

//Aggiornamento

   function take($id_p){
              $data=array();
              $this->db->where('id', $id_p);
              $Q = $this->db->get('periodi');
              if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
            }
            $Q->free_result();
            return $data;

        }

function update($id){
          $data=array(
              'id' => $id,
              'accomodation'=>      $_POST['choose'],
              'data_inizio' =>      date('Y-m-d',strtotime($_POST['date_start'])),
              'ore_arrivo' =>       $_POST['arrival_time'],
              //'arrival_service' =>  $_POST['service_in'],
              'n_volo_arrivo' =>    $_POST['arrival_flight'],
              'data_fine' =>        date('Y-m-d',strtotime($_POST['date_end'])),
              'ore_partenza' =>     $_POST['departure_time'],
              'n_volo_partenza' =>  $_POST['departure_flight'],
             // 'partenza_service' => $_POST['service_out'],
              'tot_pax' =>          $_POST['totpax'],
              //'id_nome_gruppo' =>   $_POST['gl'],
              'id_centro' =>        $_POST['scuole'],
              'id_airport_arrivo' =>$_POST['aereo_in'],
              'id_airport_partenza' =>$_POST['aereo_out'],
             // 'id_agency' =>        $_POST['agency'],
              'n_gruppo' =>         $_POST['n_group'],
             // 'id_nome_gruppo'=>     $_POST['agent']
          );
          $this->db->where('id', $id);
          $this->db->update('periodi',$data);

}

function update_gl($id_gl,$gl){
    $data=array(
               'name_group' => $gl
          );
          $this->db->where('id', $id_gl);
          $this->db->update('group',$data);
}


function update_group($gl,$gl_name){
 $data=array(
               'name_group' => $gl_name
          );
          $this->db->where('id', $gl);
          $this->db->update('group',$data);
}

function proff($idcentro,$check){
        // Prendo il nome del centro associato all'id

            $this->db->select('nome_centri');
            $this->db->where('nome_centri',$idcentro);

            $Q = $this->db->get('centri');
            foreach ($Q->result_array() as $row){
                     $datacenter[] = $row;
            }

            $centro = strtoupper ($datacenter[0]['nome_centri']);



           //Prendo il risultato della query appena eseguita e faccio un count

            $data = array();
            $this->db->where('status','employed');
            $this->db->where('center_def',$centro);
            $this->db->where('date_start <=',$check);
            $this->db->where('date_end >=',$check);
            $Q = $this->db->get('job_contacts_all');
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

                        $Q->free_result();
                        return $data;

        }

function list_price($centro){
    $data=array();
    $this->db->from('tratte');
    $this->db->where('from',$centro);

                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function escursioni(){
    $data=array();
    $this->db->from('escursions');
                   $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function elenco_id_yourbooking ($centro,$id_periodi){
        $data=array();
            $this->db->from('periodi');
            $this->db->where('id_centro',$centro);
            $this->db->where('id',$id_periodi);
                   $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function elenco_destinations ($centro,$type){
    $data=array();
            $this->db->distinct();
            $this->db->select('itinerario');
            $this->db->from('escursions');
            $this->db->where('centro',$centro);
            $this->db->where('type',$type);
                   $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function prenotazione_escursione($to,$centro,$gender){
            $data=array();
            $this->db->where('to',$to);
            $this->db->where('from',$centro);
            $this->db->where('tipo',$gender);
            $this->db->join('transport', 'transport.coach_companies = tratte.id_companies');
            $Q = $this->db->get('tratte');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

}


function extra_excursions ($ex){
            $data=array();
            $this->db->where('centro',$ex);
            $this->db->distinct();
            $this->db->select('nome');
            $Q = $this->db->get('excursion_extra');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}


function confirme_excursions($rand){
               $data=array();
               $this->db->from('excursion_confirmed');
                $this->db->where('id_pratica',$rand);
                $this->db->order_by('id', 'desc');
                $this->db->limit(1);
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}


function extra_excursion_details ($extra_ex,$ex){
                $data=array();
                $this->db->from('excursion_extra');
                $this->db->where('centro',$ex);
                $this->db->where('nome',$extra_ex);
                $this->db->order_by('id', 'desc');
                $this->db->limit(1);
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}


function resume_excursion_details ($rand,$excursion){
                $data=array();
                $this->db->where('pratica',$rand);
                $this->db->where('excursion',$excursion);
                $Q = $this->db->get('excursion_extra_confirmed');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function delete_excursion($id){
             $data=array();
                //$this->db->select('*');
                $this->db->where('id',$id);
                $this->db->delete('excursion_confirmed', array('id' => $id));

}

function delete_extra_excursion($id){
             $data=array();
                //$this->db->select('*');
                $this->db->where('id',$id);
                $this->db->delete('excursion_extra_confirmed', array('id' => $id));

}

/*
function prenotazione_escursione_bus($coach_companies){
            $data=array();
            $this->db->from('transport');
            $this->db->where('coach_companies',$coach_companies);
            $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}
 *
 */

function information($day,$centro){

            $data=array();
                $this->db->from('periodi');
                //$this->db->join('group', 'group.id = periodi.id_nome_gruppo');
                //$this->db->join('agency', 'agency.id = periodi.id_agency');
                $this->db->where('data_inizio',$day);
                $this->db->where('id_centro',$centro);
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

            }

function information_tuition_agency_nagency($nome_agency){

            $data=array();
                $this->db->select('id,name');
                $this->db->where('id',$nome_agency);
                $Q = $this->db->get('agency');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

            }


function information_tuition_name_gl($nome_gl){

            $data=array();
                $this->db->select('id,name_group');
                $this->db->where('id',$nome_gl);
                $Q = $this->db->get('group');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

            }

function lista_voli($day,$centro){

            $data=array();
                $this->db->from('arrivi_centri');
                $this->db->where('Arrival',$day);
                $this->db->where('Centre',$centro);
                $this->db->group_by ('Inbound_Flight');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

            }

function lista_voli_excel($day,$centro){

            $data=array();
                $this->db->from('arrivi_centri');
                $this->db->where('Arrival',$day);
                $this->db->where('Centre',$centro);
                $this->db->group_by ('Inbound_Flight');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

            }

function lista_voli_partenze($day,$centro){

            $data=array();
                $this->db->from('arrivi_centri');
                $this->db->where('Departure',$day);
                $this->db->where('Centre',$centro);
                $this->db->group_by ('Outbound_Flight');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

            }

function lista_voli_partenze_excel($day,$centro){

            $data=array();
                $this->db->from('arrivi_centri');
                $this->db->where('Departure',$day);
                $this->db->where('Centre',$centro);
                $this->db->group_by ('Outbound_Flight');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

            }

function detail_pax_volo($prova,$day){
        $data=array();

                $this->db->from('arrivi_centri');
                $this->db->where('Arrival',$day);
                $this->db->where('Inbound_Flight',$prova);
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

}

function detail_pax_volo_excel($prova,$day){
        $data=array();

                $this->db->from('arrivi_centri');
                $this->db->where('Arrival',$day);
                $this->db->where('Inbound_Flight',$prova);
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

}

function detail_pax_volo_dep($prova,$day){
        $data=array();

                $this->db->from('arrivi_centri');
                $this->db->where('Departure',$day);
                $this->db->where('Outbound_Flight',$prova);
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

}

function detail_pax_volo_dep_excel($prova,$day){
        $data=array();

                $this->db->from('arrivi_centri');
                $this->db->where('Departure',$day);
                $this->db->where('Outbound_Flight',$prova);
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

}

function nomi_centri($centro){

   $data=array();
              $this->db->where('id', $centro);
              $Q = $this->db->get('centri');
              if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
            }
            $Q->free_result();
            return $data;

}

function nomi_centers($idcenter){

   $data=array();
              $this->db->from('centri');
              $this->db->where('id',$idcenter);

              $Q = $this->db->get();
              if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
            }
            $Q->free_result();
            return $data;

}

function lista_escursioni(){
    $data=array();
                    $this->db->order_by('itinerario ');
                    $Q=$this->db->get('escursions');
                    if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                    $data[]=$row;
                    }
            }
                    $Q->free_result();
                    return $data;
}

function nomi_agenzie($idagenzia){

   $data=array();
              $this->db->from('agency');
              $this->db->where('id',$idagenzia);

              $Q = $this->db->get();
              if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
            }
            $Q->free_result();
            return $data;

}

function nomi_gruppo($idgruppo){

   $data=array();

              $this->db->from('group');
              $this->db->where('id',$idgruppo);

              $Q = $this->db->get();
              if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
            }
            $Q->free_result();
            return $data;

}

function search_by_center($center,$login){
      $data = array();
        $this->db->from('periodi');
        $this->db->where('id_centro',$center);
        $this->db->where('user',$login);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
        }
        $Q->free_result();
        return $data;

}

function search_by_date($data_inizio,$login){
      $data = array();
        $this->db->from('periodi');
        $this->db->where('data_inizio',$data_inizio);
        $this->db->where('user',$login);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
        }
        $Q->free_result();
        return $data;

}

function search_by_date_dep($data_fine,$login){
        $data = array();
        $this->db->from('periodi');
        $this->db->where('data_fine',$data_fine);
        $this->db->where('user',$login);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
        }
        $Q->free_result();
        return $data;
}

function nomi_air_arrive($idarrivo){

   $data=array();
             $this->db->from('airport');
             $this->db->where('id',$idarrivo);
              $Q = $this->db->get('');
              if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
            }
            $Q->free_result();
            return $data;

}

function nomi_air_dep($idpart){

  $data=array();
             $this->db->from('airport_back');
             $this->db->where('id',$idpart);
              $Q = $this->db->get('');
              if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
            }
            $Q->free_result();
            return $data;


}

function information_agency($id_pratica){

$data=array();
                $this->db->from('periodi');
                $this->db->where('rand',$id_pratica);
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

            }


function excursion_pack($centro){
    $data=array();
                $this->db->from('centri');
                $this->db->where('nome_centri',$centro);
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function excursion_pack_half_7($centro){

    $data=array();
                $this->db->from('excursion_plan');
                $this->db->where('centro',$centro);
                $this->db->where('type','half day');
                $this->db->where('durata <=','7');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function excursion_pack_full_7($centro){
    $data=array();
                $this->db->from('excursion_plan');
                $this->db->where('centro',$centro);
                $this->db->where('type','full day');
                $this->db->where('durata <=','7');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function excursion_pack_half_14($centro){

    $data=array();
                $this->db->from('excursion_plan');
                $this->db->where('centro',$centro);
                $this->db->where('type','half day');
                $this->db->where('durata >=','1');
                $this->db->where('durata <=','14');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function excursion_pack_full_14($centro){
    $data=array();
                $this->db->from('excursion_plan');
                $this->db->where('centro',$centro);
                $this->db->where('type','full day');
                $this->db->where('durata >=','1');
                $this->db->where('durata <=','14');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function excursion_pack_half_21($centro){

    $data=array();
                $this->db->from('excursion_plan');
                $this->db->where('centro',$centro);
                $this->db->where('type','half day');
                $this->db->where('durata >=','1');
                $this->db->where('durata <=','21');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function excursion_pack_full_21($centro){
    $data=array();
                $this->db->from('excursion_plan');
                $this->db->where('centro',$centro);
                $this->db->where('type','full day');
                $this->db->where('durata >=','1');
                $this->db->where('durata <=','21');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function excursion_plan($rand){
    $data=array();
                $this->db->from('excursion_confirmed');
                $this->db->where('id_pratica',$rand);
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function delete_ex_plan($last_rand){
        $this->db->where('rand', $last_rand);
        $this->db->delete('excursion_plan_confirmed');
}

function list_excursion_scheda ($id_pratica){
    $data=array();
                $this->db->from('excursion_confirmed');
                $this->db->where('id_pratica',$id_pratica);
                $this->db->where('type','Full Day');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function list_excursion_scheda_half($id_pratica){
    $data=array();
                $this->db->from('excursion_confirmed');
                $this->db->where('id_pratica',$id_pratica);
                $this->db->where('type','Half Day');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function list_extra_excursion_scheda ($id_pratica){
    $data=array();
                $this->db->from('excursion_extra_confirmed');
                $this->db->where('pratica',$id_pratica);
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function list_transfer($id_pratica){
        $data=array();
                $this->db->from('excursion_confirmed');
                $this->db->where('id_pratica',$id_pratica);
                $this->db->where('type','Transfer');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
}

function information_agency_nagency($nome_agency){
            $data=array();
                $this->db->select('id,login');
                $this->db->where('id',$nome_agency);
                $Q = $this->db->get('agenti');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;

            }

 function information_name_gl($nome_gl){
             $data=array();
                $this->db->select('id,name_group');
                $this->db->where('id',$nome_gl);
                $Q = $this->db->get('group');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
 }

function cerca($check,$idcentro){
          $data = array();
            $this->db->where('data_inizio',$check);
            $this->db->where('id_centro',$idcentro);
            $Q = $this->db->get('periodi');
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }
            $Q->free_result();
            return $data;

        }

function details_rooms($periodo,$campus){
    $data = array();
    $this->db->from('periodi_centri');
    $this->db->where('id_centro',$campus);
    $this->db->where('date_in',$periodo);
            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }
            $Q->free_result();
            return $data;

}


function search_agency($login){
      $data = array();
        $this->db->from('periodi');
        $this->db->where('user',$login);
        //$this->db->where('status','TBC');
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
        }
        $Q->free_result();
        return $data;

    }

function search_agency_confermation($login){
      $data = array();
        $this->db->from('periodi');
        $this->db->where('user',$login);
        $this->db->where('status','confermation');
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
        }
        $Q->free_result();
        return $data;

    }

function search_agency_admin(){
      $data = array();
        $this->db->from('periodi');
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
        }
        $Q->free_result();
        return $data;

    }
     function information_pax($day, $centro){
          $data = array();
            $this->db->from('arrivi_centri');
            $this->db->where('Centre',$centro);
            $this->db->where('Arrival <=',$day);
            $this->db->where('Departure >=',$day);
            $this->db->order_by ('Departure');
            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }
            $Q->free_result();
            return $data;

        }

     function information_pax_excel($day, $centro){
          $data = array();
            $this->db->from('arrivi_centri');
            $this->db->where('Centre',$centro);
            $this->db->where('Arrival <=',$day);
            $this->db->where('Departure >=',$day);
            $this->db->order_by ('Departure');
            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }
            $Q->free_result();
            return $data;

        }

function gruppoflag($check,$idcentro){
          $data = array();
            $this->db->select('id,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_inizio',$check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }

function arrive_standard($check,$idcentro){
          $data = array();
            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('accomodation','College Standard');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_inizio',$check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }

function arrive_disp_ensuite($check,$idcentro){
          $data = array();
            $this->db->select('id,date_in,date_end,halls_of_residence_1,halls_of_residence_2,halls_of_residence_3,halls_of_residence_4,halls_of_residence_5,single,single_ensuite,double,double_ensuite,triple,triple_ensuite,quadruple,quadruple_ensuite,tot_standard,tot_ensuite,id_centro');
            $this->db->from('periodi_centri');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('date_in',$check);

            $this->db->group_by ("periodi_centri.date_in");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }

function arrive_ensuite($check,$idcentro){
          $data = array();
            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('accomodation','College En suite');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_inizio',$check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }

function arrive_hs($check,$idcentro){
          $data = array();
            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('accomodation','Home stay');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_inizio',$check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }

 function gruppoflag_excel($check,$idcentro){
          $data = array();
            $this->db->from('arrivi_centri');
            $this->db->where('Centre',$idcentro);
            $this->db->where('Arrival',$check);
            $this->db->order_by ("Arrival");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }
 function gruppo_departure_excel($check,$idcentro){
               $data = array();
                $this->db->from('arrivi_centri');
                $this->db->where('Centre',$idcentro);
                $this->db->where('Departure',$check);
                $this->db->order_by ("Departure");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

 }
 function gruppo_departure($check,$idcentro){
          $data = array();


            $this->db->select('id,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_fine',$check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }
function departure_standard($check,$idcentro){
          $data = array();


            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('accomodation','College Standard');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_fine',$check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }

function departure_disp_ensuite($check,$idcentro){
          $data = array();

            $this->db->select('id,date_in,date_end,halls_of_residence_1,halls_of_residence_2,halls_of_residence_3,halls_of_residence_4,halls_of_residence_5,single,single_ensuite,double,double_ensuite,triple,triple_ensuite,quadruple,quadruple_ensuite,tot_standard,tot_ensuite,id_centro');
            $this->db->from('periodi_centri');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('date_end',$check);
            $this->db->group_by ("periodi_centri.date_in");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }


function departure_ensuite($check,$idcentro){
          $data = array();


            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('accomodation','College En suite');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_fine',$check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }

function departure_hs($check,$idcentro){
          $data = array();


            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('accomodation','Home stay');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_fine',$check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }

function gruppo($check,$idcentro){
          $data = array();
            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_inizio <=',$check);
            $this->db->where('data_fine >', $check);
            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }

function disp($check,$idcentro){
   $data = array();
          $this->db->select('id,date_in,date_end,halls_of_residence_1,halls_of_residence_2,halls_of_residence_3,halls_of_residence_4,halls_of_residence_5,single,single_ensuite,double,double_ensuite,triple,triple_ensuite,quadruple,quadruple_ensuite,tot_standard,tot_ensuite,id_centro');
        $this->db->from('periodi_centri');
        $this->db->where('id_centro',$idcentro);
        $this->db->where('date_in <=',$check);
        $this->db->where('date_end >', $check);
        $this->db->group_by ("periodi_centri.date_in");

        $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

}

 function accomodation_standard($check,$idcentro){
          $data = array();
            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('accomodation','College Standard');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_inizio <=',$check);
            $this->db->where('data_fine >', $check);
            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }

function accomodation_ensuite($check,$idcentro){
          $data = array();
            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('accomodation','College En suite');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_inizio <=',$check);
            $this->db->where('data_fine >', $check);
            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }
function accomodation_hs($check,$idcentro){
          $data = array();
            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('tot_pax');
            $this->db->from('periodi');
            $this->db->where('accomodation','Home stay');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_inizio <=',$check);
            $this->db->where('data_fine >', $check);
            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

        }

function somma_gl($check,$idcentro){

    $data = array();
            $this->db->select('id,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('n_gruppo');
            $this->db->from('periodi');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('data_inizio <=',$check);
            $this->db->where('data_fine >', $check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

}

function somma_gl_standard($check,$idcentro){

    $data = array();
            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('n_gruppo');
            $this->db->from('periodi');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('accomodation','College Standard');
            $this->db->where('data_inizio <=',$check);
            $this->db->where('data_fine >', $check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

}

function somma_gl_ensuite($check,$idcentro){

    $data = array();
            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('n_gruppo');
            $this->db->from('periodi');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('accomodation','College En suite');
            $this->db->where('data_inizio <=',$check);
            $this->db->where('data_fine >', $check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

}

function somma_gl_hs($check,$idcentro){

    $data = array();
            $this->db->select('id,accomodation,data_inizio,ore_arrivo,n_volo_arrivo,arrival_service,data_fine,ore_partenza,airport_partenza,n_volo_partenza,partenza_service,tot_pax,id_centro,id_agency,gruppo,n_gruppo,id_airport_arrivo,id_airport_partenza,confirm_in,confirm_out');
            $this->db->select_sum('n_gruppo');
            $this->db->from('periodi');
            $this->db->where('id_centro',$idcentro);
            $this->db->where('accomodation','Home stay');
            $this->db->where('data_inizio <=',$check);
            $this->db->where('data_fine >', $check);

            $this->db->group_by ("data_inizio");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;

}

function totale_rooms($check,$idcentro){
    $data = array();
    $this->db->select('id,date_in,date_end,single,single_ensuite,double,double_ensuite,halls_of_residence_1,halls_of_residence_2,halls_of_residence_3,halls_of_residence_4,halls_of_residence_5');
    $this->db->select_sum('tot_standard');
    $this->db->from('periodi_centri');
    $this->db->where('id_centro',$idcentro);
    $this->db->where('date_in <=',$check);
    $this->db->where('date_end >=', $check);
    $this->db->group_by ("date_in");
            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;
}

function totale_rooms_ensuite($check,$idcentro){
    $data = array();
    $this->db->select('id,date_in,date_end,single,single_ensuite,double,double_ensuite,halls_of_residence_1,halls_of_residence_2,halls_of_residence_3,halls_of_residence_4,halls_of_residence_5');
    $this->db->select_sum('tot_ensuite');
    $this->db->from('periodi_centri');
    $this->db->where('id_centro',$idcentro);
    $this->db->where('date_in <=',$check);
    $this->db->where('date_end >=', $check);
    $this->db->group_by ("date_in");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;
}

function confirm_somma_pax($idcentro,$check){
    $data = array();
    $this->db->from('arrivi_centri');
    $this->db->where('Centre',$idcentro);
    $this->db->where('Type_of_Passenger','STD');
    $this->db->where('Arrival <=',$check);
    $this->db->where('Departure >=',$check);
    $this->db->order_by ("Arrival");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;
}


function confirm_somma_gl($idcentro,$check){
    $data = array();
    $this->db->from('arrivi_centri');
    $this->db->where('Centre',$idcentro);
    $this->db->where('Type_of_Passenger','GL');
    $this->db->where('Arrival <=',$check);
    $this->db->where('Departure >=',$check);
    $this->db->order_by ("Arrival");

            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;
}



        function rooms($idcentro){
            $data = array();
            $this->db->select('rooms');
            $this->db->from('centri');
            $this->db->where('id',$idcentro);
            $Q = $this->db->get();
            if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                    }
            }

            $Q->free_result();
            return $data;
        }


function ok_in($id,$login){

    $data=array(
      'id' => $id,
      'confirm_in' => 'YES'

                );
        $this->db->from('periodi');
        $this->db->where('id', $id);
        $this->db->where('user', $login);
        $this->db->update('periodi',$data);

}

function ok_out($id){

    $data=array(
      'id' => $id,
      'confirm_out' => 'YES'

                );
        $this->db->from('periodi');
        $this->db->where('id', $id);
        $this->db->update('periodi',$data);

}

function list_ok (){
        $data=array();
        $this->db->from('periodi');
        $this->db->join('agency', 'agency.id = periodi.id_agency');
        $this->db->join('group', 'group.id = periodi.id_nome_gruppo');
        $this->db->order_by('data_inizio', 'desc');
                $Q = $this->db->get();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
   }

function list_no_checkin(){
          $data=array();
          $this->db->from('periodi');
          $this->db->join('group', 'group.id = periodi.id_nome_gruppo');
          $this->db->join('agency', 'agency.id = periodi.id_agency');
          $this->db->where('confirm_in','NO');
            $this->db->order_by('data_inizio', 'desc');
                    $Q = $this->db->get();
                    if ($Q->num_rows() > 0){
                        foreach ($Q->result_array() as $row){
                                $data[] = $row;
                            }
                    }
                    $Q->free_result();
                    return $data;
}

function list_no_checkout(){
          $data=array();
          $this->db->from('periodi');
          $this->db->join('group', 'group.id = periodi.id_nome_gruppo');
          $this->db->join('agency', 'agency.id = periodi.id_agency');
          $this->db->where('confirm_out','NO');
            $this->db->order_by('data_inizio', 'desc');
                    $Q = $this->db->get();
                    if ($Q->num_rows() > 0){
                        foreach ($Q->result_array() as $row){
                                $data[] = $row;
                            }
                    }
                    $Q->free_result();
                    return $data;
}


function modify_csv(){
        $data=array();
                    $Q = $this->db->get('domain_csv');
                    if ($Q->num_rows() > 0){
                        foreach ($Q->result_array() as $row){
                                $data[] = $row;
}
                    }
                    $Q->free_result();
                    return $data;
}

function delete_csv($id){
  $this->load->database();
  $this->db->delete('domain_csv', array('id' => $id));
}


// Delete All //
function delete_ex_conf($rand){
    $data=array();
        $this->db->where('id_pratica',$rand);
        $this->db->delete('excursion_confirmed', array('id_pratica' => $rand));
}

function delete_ex_ex_conf($rand){
    $data=array();
        $this->db->where('pratica',$rand);
        $this->db->delete('excursion_extra_confirmed', array('pratica' => $rand));
 }

 function delete_ex_plan_conf($rand){
    $data=array();
        $this->db->where('rand',$rand);
        $this->db->delete('excursion_plan_confirmed', array('rand' => $rand));
 }

 function delete_join_trasp($rand){
    $data=array();
        $this->db->where('id_pratica',$rand);
        $this->db->delete('join_transport', array('id_pratica' => $rand));
 }

  function delete_periodi($rand){
    $data=array();
        $this->db->where('rand',$rand);
        $this->db->delete('periodi', array('rand' => $rand));
 }

// fine Delete All //


function insert_csv(){

       $data = array(

         //Insert booking IN //

        'Centre' => $this->input->xss_clean($this->input->post('centre')),
        'Name' => $this->input->xss_clean($this->input->post('name')),
        'Surname' => $this->input->xss_clean($this->input->post('surname')),
        'Nationality' => $this->input->xss_clean($this->input->post('nationality')),
        'DOB' => $this->input->xss_clean($this->input->post('dob_date')),
        'Gender' => $this->input->xss_clean($this->input->post('gender')),
        'Type_of_Passenger' => $this->input->xss_clean($this->input->post('top')),
        'Accommodation' => $this->input->xss_clean($this->input->post('accomodation')),
        'Allergies_Food_Intolerances' => $this->input->xss_clean($this->input->post('allergies')),
        'Inbound_Flight' => $this->input->xss_clean($this->input->post('inbound_flight')),
        'Arrival' => $this->input->xss_clean($this->input->post('arrival_date')),
        'Departure' => $this->input->xss_clean($this->input->post('departure_date')),
        'ATime' => $this->input->xss_clean($this->input->post('arrival_time')),
        'Inbound_Airport' => $this->input->xss_clean($this->input->post('aereo_in')),
        'Outbound_Flight' => $this->input->xss_clean($this->input->post('outbound_flight')),
        'DTime' => $this->input->xss_clean($this->input->post('departure_time')),
        'Outbound_Airport' => $this->input->xss_clean($this->input->post('aereo_out')),
        'Passaport' => $this->input->xss_clean($this->input->post('passaport')),
        'Group_Leaders_name' => $this->input->xss_clean($this->input->post('gl')),
        'Agent' => $this->input->xss_clean($this->input->post('agency'))
      );
        $this->db->insert('domain_csv', $data);
    }

function findDatesByCenter($centro){
					$data=array();
                    $this->db->from('date_plus');
                    $this->db->where('codice',$centro);
					$this->db->order_by('start_date', 'asc');
                    $Q=$this->db->get();
                    if ($Q->num_rows() > 0){
						foreach ($Q->result_array() as $row){
							$data[]=$row;
						}
					}
					//echo $this->db->last_query();
                    $Q->free_result();
                    return $data;
	}
function findAccoByCenter($centro){
					$data=array();
                    $this->db->from('plused_sistemazioni-centri');
                    $this->db->where('id_sis_centro',$centro);
                    $Q=$this->db->get();
                    if ($Q->num_rows() > 0){
						foreach ($Q->result_array() as $row){
							$data[]=$row;
						}
					}
                    $Q->free_result();
                    return $data;
	}

function findIDBack($idcentro){
		    $data=array();
		    $this->db->select('idback');
                    $this->db->from('plused_join_centri');
                    $this->db->where('idvision',$idcentro);
                    $Q=$this->db->get();
                    if ($Q->num_rows() > 0){
						foreach ($Q->result_array() as $row){
							$data[]=$row;
						}
					}
                    $Q->free_result();
                    return $data;
	}


function GESTgenerateUUID(){
	$length = 12;
	$temp = array();
	$exec = array();
	$alpha_upper = array( "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z" );
	$exec[] = 1;
	$alpha_lower = array( "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z" );
	$exec[] = 2;
	$number = array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 );
	$exec[] = 3;
	$exec_count = count( $exec ) - 1;
	$input_index = 0;
	for ( $i = 1; $i <= $length; $i++ ) {
			switch( $exec[$input_index] ) {
				case 1:
				shuffle( $alpha_upper );
				$temp[] = $alpha_upper[0];
				unset( $alpha_upper[0] );
				break;

				case 2:
				shuffle( $alpha_lower );
				$temp[] = $alpha_lower[0];
				unset( $alpha_lower[0] );
				break;

				case 3:
				shuffle( $number );
				$temp[] = $number[0];
				unset( $number[0] );
				break;
			}
			if ( $input_index < $exec_count ) {
				$input_index++;
			} else {
				$input_index = 0;
			}
	}
	shuffle($temp);
	$password = implode( $temp );
	return $password;
}

function GESTcheckUUID($password){
	$this->db->where('uuid',$password);
	$this->db->from('plused_rows');
	return $this->db->count_all_results();
}

	function getCampusWithVideos()
	{
	    $this->db->select("c.id, c.nome_centri, ci.title, ci.image_path, cv.campus_video_1, cv.campus_video_2, cv.campus_video_3, cv.campus_video_4");
	    $this->db->from("centri c");
	    $this->db->join("plused_campus_image ci","ci.campus_id = c.id", "left");
	    $this->db->join("plused_campus_video cv","cv.campus_id = c.id");
	    $this->db->where('c.attivo',1);
	    $this->db->group_by('c.id');
	    $this->db->order_by('c.nome_centri', "asc");

	    $query = $this->db->get();
	    return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
	}

	function getCampusWithImages( $type )
	{
		$result = array();

	    $this->db->select("c.id, c.nome_centri, ci.title, ci.image_path");
	    $this->db->from("centri c");
	    $this->db->join("plused_campus_image ci","ci.campus_id = c.id");
	    $this->db->where('c.attivo',1);
	    $this->db->where('ci.category',$type);
	    $this->db->order_by('c.nome_centri', "asc");
	    $this->db->order_by('ci.campus_image_id', "desc");

	    $query = $this->db->get();
	    if( $query->num_rows() > 0 )
	    {
	    	foreach ( $query->result_array() as $row )
	    	{
	    		$result[$row['nome_centri'].'_'.$row['id']][] = array( 'image_name' => $row['image_path'], 'title' => $row['title'] );
	    	}
	    }
	    return $result;
	}

}
?>
