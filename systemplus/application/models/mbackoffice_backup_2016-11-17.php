<?php
class Mbackoffice extends Model{

function Mbackoffice(){
	parent::Model();
}

function verifyuser($user,$pwd){
	$data = array();
	$options = array('username'=>$this->db->escape_str($user),'password'=>$this->db->escape_str($pwd));
	$Q=$this->db->getwhere('members',$options,1);

	if ($Q->num_rows() > 0){
		foreach ($Q->result_array() as $row){
				$row["ruolo"]=$row["role"];
				$data[] = $row;
		}
	}
	$Q->free_result();
	return $data;
}

    /**
    * getMemberForMatch
    * this function can be use to select member record using matched crieteria
    * @param array $matchedArr
    * @return int|mixed row
    */
    public function getMemberForMatch($matchedArr = array()){
        if(is_array($matchedArr)){
            if(!empty($matchedArr)){
                $this->db->where($matchedArr);
                $this->db->limit(1);
                $result = $this->db->get('members');
                if($result->num_rows())
                {
                    return $result->row();
                }
            }
        }
        return 0;
    }

     /**
    * updateMemberData
    * this function can be use to select member record using matched crieteria
    * @param array $matchedArr
    * @return int|mixed row
    */
    public function updateMemberData($updateArray = array(),$memberId = 0){
        if(is_array($updateArray)){
            if(!empty($updateArray) && is_numeric($memberId) && !empty($memberId)){
                $this->db->where('id',$memberId);
                $result = $this->db->update('members',$updateArray);
                return 1;
            }
        }
        return 0;
    }


function getLastBookingYear(){
		$this->db->select('YEAR(arrival_date) as ultimoAnno');
		$this->db->order_by("id_book", "desc");
		$this->db->limit(1);
        $Q=$this->db->get('plused_book');
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$lastYear=$row["ultimoAnno"];
			}
        }
        $Q->free_result();
        return $lastYear;
}

function overviewBookings($campus,$agent,$status,$datein,$dateout,$confirm=0,$season=0){
		$data=array();
		$lastYear=$this->getLastBookingYear();
		if($campus!="all")
			$this->db->where('id_centro',$campus);
		if($agent!="all")
			$this->db->where('id_agente',$agent);
		if($status!="all")
			$this->db->where('status',$status);
		/*if($datein!="all"){
				if($dateout!="all"){
					$this->db->where('id_agente',$dateout);
				}else{
					$this->db->where('id_agente',$datein);
				}
		}*/
		if($confirm < 2){
            	 	$this->db->where('can_confirm',$confirm);
		}
		//Aggiunto filtro data su stagione o su anno ultimo booking
		//$this->db->where('YEAR(arrival_date) = '.date("Y"));
		if($season==0)
			$season=$lastYear;
		$this->db->where('YEAR(arrival_date) = '.$season);
		//Modificato ordinamento di default on request il 13/02/2014 $this->db->order_by("data_insert", "desc");
		$this->db->order_by("arrival_date", "desc");
        $Q=$this->db->get('plused_book');
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				 $data2=array();
				 $this->db->select('valuta, valore_acconto');
				 $nomedelcentro = $row["id_centro"];
				 $this->db->where('id',$nomedelcentro);
				 $queryvaluta = $this->db->get('centri');
				 //echo $this->db->last_query();
				 $recordvaluta = $queryvaluta->result_array();
				 //print_r($row);
				 if($nomedelcentro != "None"){
					$row['valuta']=$recordvaluta[0]['valuta'];
					$row['valore_acconto']=$recordvaluta[0]['valore_acconto'];
				 }else{
					$row['valuta']="$";
					$row['valore_acconto']=0;
				 }
				$row['centro']=$this->centerNameById($row["id_centro"]);
				$row['all_acco'] = $this->magenti->getBookAccomodations($row["id_book"]);
				$row['agency'] = $this->magenti->plused_get_ag_details($row["id_agente"]);
				$contaNote = $this->mbackoffice->readBookingNotes($row["id_book"],0);
				$row["numNote"] = count($contaNote);
				$data[]=$row;
			}
        }
        $Q->free_result();
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
        return $data;
}

function overviewBookingsNew($campus,$agent,$status,$confirm=0,$season=0,$lm=0,$cfd=0,$locked=0){
		$data=array();
		$lastYear=$this->getLastBookingYear();
		if($campus!="all")
			$this->db->where('id_centro',$campus);
		if($agent!="")
			$this->db->where('id_agente',$agent);
		if($status!="all")
			$this->db->where('status',$status);
		if($lm==1)
			$this->db->where('flag_lm',1);
		if($cfd==1)
			$this->db->where('flag_cfd',1);
		if($locked==1)
			$this->db->where('lockPax',1);
		if($confirm < 2){
            	 	$this->db->where('can_confirm',$confirm);
		}
		//echo $agent;
		//Aggiunto filtro data su stagione o su anno ultimo booking
		//$this->db->where('YEAR(arrival_date) = '.date("Y"));
		if($season==0)
			$season=$lastYear;
		$this->db->where('YEAR(arrival_date) = '.$season);
		//Modificato ordinamento di default on request il 13/02/2014 $this->db->order_by("data_insert", "desc");
		$this->db->order_by("arrival_date", "desc");
        $Q=$this->db->get('plused_book');
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				 $data2=array();
				 $this->db->select('valuta, valore_acconto');
				 $nomedelcentro = $row["id_centro"];
				 $this->db->where('id',$nomedelcentro);
				 $queryvaluta = $this->db->get('centri');
				 //echo $this->db->last_query();
				 $recordvaluta = $queryvaluta->result_array();
				 //print_r($row);
				 if($nomedelcentro != "None"){
					 //echo $nomedelcentro."<br />";
					$row['valuta']=$recordvaluta[0]['valuta'];
					$row['valore_acconto']=$recordvaluta[0]['valore_acconto'];
				 }else{
					$row['valuta']="$";
					$row['valore_acconto']=0;
				 }
				$row['centro']=$this->centerNameById($row["id_centro"]);
				//$row['all_acco'] = $this->magenti->getBookAccomodations($row["id_book"]);
				$row['agency']['businessname'] = $this->agentNameById($row["id_agente"]);
				$row['agency']['businesscountry'] = $this->agentCountryById($row["id_agente"]);
				$contaNote = $this->mbackoffice->readBookingNotes($row["id_book"],0);
				$row["numNote"] = count($contaNote);
				$row["hasRoster"] = $this->mbackoffice->count_pax_uploaded($row["id_book"]);
				$row["saldoBilancio"] = $this->saldoById($row["id_book"]);
				$row["contaNote"] = count($this->mbackoffice->readBookingNotes($row["id_book"],0));
				$row["dueBilancio"] = $this->dueById($row["id_book"]);
				$data[]=$row;
			}
        }
        $Q->free_result();
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
        return $data;
}

function overviewSingleBooking($idBook){
		$data=array();
		$this->db->where('id_book = '.$idBook);
        $Q=$this->db->get('plused_book');
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				 $data2=array();
				 $this->db->select('valuta, valore_acconto');
				 $nomedelcentro = $row["id_centro"];
				 $this->db->where('id',$nomedelcentro);
				 $queryvaluta = $this->db->get('centri');
				 //echo $this->db->last_query();
				 $recordvaluta = $queryvaluta->result_array();
				 //print_r($row);
				 if($nomedelcentro != "None"){
					$row['valuta']=$recordvaluta[0]['valuta'];
					$row['valore_acconto']=$recordvaluta[0]['valore_acconto'];
				 }else{
					$row['valuta']="$";
					$row['valore_acconto']=0;
				 }
				$row['centro']=$this->centerNameById($row["id_centro"]);
				$row['all_acco'] = $this->magenti->getBookAccomodations($row["id_book"]);
				$row['agency'] = $this->magenti->plused_get_ag_details($row["id_agente"]);
				$data[]=$row;
			}
        }
        $Q->free_result();
        return $data;
}


function exportCSVBookings($campus,$agent,$status,$year){
		$data=array();
		if($campus!="all")
			$this->db->where('id_centro',$campus);
		if($agent!="all")
			$this->db->where('id_agente',$agent);
		if($status!="all")
		$this->db->where('status',$status);
		//Riaggiunto filtro sull'anno on request il 13/02/2014
		//$this->db->where('id_year',$year);
		$this->db->where('YEAR(arrival_date) = '.$year);
		$this->db->order_by("data_insert", "desc");
        $Q=$this->db->get('plused_book');
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				 $data2=array();
				 $this->db->select('valuta, valore_acconto');
				 $nomedelcentro = $row["id_centro"];
				 $this->db->where('id',$nomedelcentro);
				 $queryvaluta = $this->db->get('centri');
				 //echo $this->db->last_query();
				 $recordvaluta = $queryvaluta->result_array();
				 //print_r($row);
				 if($nomedelcentro != "None"){
					$row['valuta']=$recordvaluta[0]['valuta'];
					$row['valore_acconto']=$recordvaluta[0]['valore_acconto'];
				 }else{
					$row['valuta']="$";
					$row['valore_acconto']=0;
				 }
				$row['centro']=$this->centerNameById($row["id_centro"]);
				$row['all_acco'] = $this->magenti->getBookAccomodations($row["id_book"]);
				$row['agency'] = $this->magenti->plused_get_ag_details($row["id_agente"]);
				$data[]=$row;
			}
        }
        $Q->free_result();
        return $data;
}


function getFullInvoiceNew($idBook){

	$allAcco = $this->magenti->getBookAccomodations($idBook);
	$bkDett = $this->get_booking_detail($idBook);
	$weeks = $this->getWeeksByDaysByBkId($idBook);
	//print_r($allAcco);
	//print_r($bkDett);
	$fullInvoice = 0;
	foreach($allAcco as $acco){
		$costosingolo = 0;
		$costoriga = 0;
		switch($acco->accomodation){
    		case 'ensuite':
     		    $costosingolo=$bkDett[0]['costo_ensuite'];
     		    break;
    		case 'standard':
     		    $costosingolo=$bkDett[0]['costo_standard'];
     		    break;
			case 'homestay':
				$costosingolo=$bkDett[0]['costo_homestay'];
				break;
			case 'twin':
				$costosingolo=$bkDett[0]['costo_twin'];
				break;
		}
		$numPax = $acco->contot;
		$costoriga = ($costosingolo*1)*($numPax*1)*($weeks*1);
		//echo $costoriga."<br />";
		$fullInvoice += $costoriga;
		switch($bkDett[0]['valuta_fattura']){
			case 'GBP':
				$symbV = "£";
				break;
			case 'USD':
				$symbV = "$";
				break;
			case 'EUR':
				$symbV = "€";
				break;
		}
	}
	return $fullInvoice."___".$symbV;
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
        return $data[0]["nome_centri"];
}

function campusById($idcentro){
		$data=array();
        $this->db->where('id',$idcentro);
        $Q=$this->db->get('centri');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
        return $data;
}

function campusIdByBookingId($idBook){
		$this->db->select('id_centro');
        $this->db->where('id_book',$idBook);
        $Q=$this->db->get('plused_book');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$idCentro=$row["id_centro"];
			}
        }
        $Q->free_result();
        return $idCentro;
}

function yearIdByBookingId($idBook){
		$this->db->select('id_year');
        $this->db->where('id_book',$idBook);
        $Q=$this->db->get('plused_book');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$idYear=$row["id_year"];
			}
        }
        $Q->free_result();
        return $idYear;
}

function statusByBookingId($idBook){
		$this->db->select('status');
        $this->db->where('id_book',$idBook);
        $Q=$this->db->get('plused_book');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$status=$row["status"];
			}
        }
        $Q->free_result();
        return $status;
}

function dataTurnoByBookingId($idBook,$tipo){
		if($tipo=="in"){
			$this->db->select('arrival_date');
			$this->db->where('id_book',$idBook);
			$Q=$this->db->get('plused_book');
			if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
					$dataR=$row["arrival_date"];
				}
			}
		}else{
			$this->db->select('departure_date');
			$this->db->where('id_book',$idBook);
			$Q=$this->db->get('plused_book');
			if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
					$dataR=$row["departure_date"];
				}
			}
		}
		$Q->free_result();
		//echo "<br />".$idBook."---->".$dataR;
        return $dataR;
}

function attractionById($idAtt){
		$data=array();
        $this->db->where('pat_id',$idAtt);
        $Q=$this->db->get('plused_attractions');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
        return $data;
}

function centerIdByBkgId($id_year, $id_book){
		$data=array();
        $this->db->where('id_year',$id_year);
		$this->db->where('id_book',$id_book);
        $Q=$this->db->get('plused_book');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
        return $data[0]["id_centro"];
}

function centerPickupById($idcentro){
		$data=array();
        $this->db->where('id',$idcentro);
        $Q=$this->db->get('centri');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
        return $data[0]["school_name"]." - ".$data[0]["address"];
}

function centerIdByName($nomecentro){
		//echo $nomecentro;
		$data=array();
        $this->db->where('nome_centri',$nomecentro);
        $Q=$this->db->get('centri');
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }else{
			echo "ERROR! No access for campus $nomecentro. Please refer the error to Plus-Ed. Thank you.";
			die();
		}
        $Q->free_result();
        return $data[0]["id"];
}

function currencyIdByCode($code){
        $this->db->where('cur_codice',$code);
        $Q=$this->db->get('plused_tb_currency');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$moneta=$row;
			}
		}
        $Q->free_result();
        return $moneta["cur_id"];
}



function getUnjoinedSTBookings($season){
    $seasonArray = explode("-",$season);
    $anno = $seasonArray[0];
    $data=array();
    $dataDis=array();
    $queryDist = "SELECT id_ref_overnight FROM plused_book  WHERE YEAR(arrival_date) = $anno AND id_agente = 795 and id_ref_overnight is not null order by id_ref_overnight DESC";
    $Q=$this->db->query($queryDist);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $dataDis[]=$row["id_ref_overnight"];
        }
    }
    $Q->free_result();
    if(count($dataDis)==0)
        return $data;
    $querya = "SELECT CONCAT(id_year,' ',id_book) as booking, id_book FROM plused_book WHERE YEAR(arrival_date) = $anno AND id_agente = 795 AND id_book NOT IN (".implode(",", $dataDis).") order by id_book DESC";
    $Q=$this->db->query($querya);
    if ($Q->num_rows() > 0){
       foreach ($Q->result_array() as $row){
            $data[]=$row;
       }
    }
    $Q->free_result();
    return $data;
}



function fullInvoiceInserted($bkId){
		$where = ("pfp_tipo_servizio = 'Full Invoice' AND pfp_bk_id = ".$bkId);
        $this->db->where($where);
        $this->db->from('plused_fincon_payments');
        return $this->db->count_all_results();
}


function getBookAccomodations($id){
		$data=array();
		$querya = "SELECT COUNT(id_prenotazione) as conto, accomodation, tipo_pax FROM `plused_rows` WHERE id_book = $id group by accomodation, tipo_pax order by tipo_pax, accomodation";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$tipopasseggero = "Group Leaders";
				if($row["tipo_pax"]=="STD")
					$tipopasseggero = "Students";
				$row["tipologia_p"]=$tipopasseggero;
				$data[]=$row;
            }
		}
        $Q->free_result();
        return $data;
}

function getSingleBookAccomodations($id,$pax,$acco){
		$data=array();
		$querya = "SELECT COUNT(id_prenotazione) as conto FROM `plused_rows` WHERE id_book = $id AND accomodation = '$acco' AND tipo_pax = '$pax'";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
            }
		}
        $Q->free_result();
        return $data;
}


function getGlDetailsByBkId($id){
    $data=array();
    $querya = 'SELECT DISTINCT CONCAT(cognome," ",nome) as glName, nome_centri, id_agente, CONCAT(plused_book.id_year,"_",plused_book.id_book) as bkId, plused_rows.andata_data_arrivo, plused_rows.ritorno_data_partenza, plused_book.data_insert FROM plused_book,plused_rows, centri WHERE tipo_pax = "GL" AND id_centro = centri.id AND plused_book.id_book = plused_rows.id_book AND plused_book.id_book = '.$id.' ORDER BY glName';
    $Q=$this->db->query($querya);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[]=$row;
        }
    }
    $Q->free_result();
    return $data;
}


function getBKIDforInsert(){
		$data=array();
		$querya = "SELECT id_book FROM plused_book WHERE (status = 'active' OR status = 'confirmed') AND YEAR(arrival_date) = '2015'";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
            }
		}
        $Q->free_result();
        return $data;
}

function getAllCampus($attivi=0){
				$data=array();
				$this->db->order_by('nome_centri');
				if($attivi==1){
					$this->db->where('attivo',$attivi);
				}
                $Q=$this->db->get('centri');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function getAllCampusForDropdown($attivi=0){
    $data = array();
        $this->db->order_by('nome_centri');
        $this->db->select('id,nome_centri');
        if ($attivi == 1) {
            $this->db->where('attivo', $attivi);
        }
        $Q = $this->db->get('centri');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
}

function getAllAttractionTypes(){
				$data=array();
				$this->db->order_by('patt_id');
                $Q=$this->db->get('plused_attraction_type');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function getAllPaymentTypes(){
				$data=array();
				$this->db->order_by('pfcpt_order');
                $Q=$this->db->get('plused_fincon_payment_types');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function getAllPaymentServices(){
				$data=array();
				$this->db->order_by('pfcse_id');
                $Q=$this->db->get('plused_fincon_services');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function getAllCurrencies(){
				$data=array();
				$this->db->order_by('cur_nome_esteso');
                $Q=$this->db->get('plused_tb_currency');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function paymentsById($idBk){
		$data=array();
        $this->db->where('pfp_bk_id',$idBk);
		$this->db->order_by('pfp_data_operazione');
        $Q=$this->db->get('plused_fincon_payments');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
        return $data;
}

function saldoById($idBk){
		$data=array();
        $this->db->where('pfp_bk_id',$idBk);
		$this->db->order_by('pfp_data_operazione');
        $Q=$this->db->get('plused_fincon_payments');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
		$contaMoney=0;
		$contaDue=0;
		$lastValuta = "";
		foreach($data as $pay){
			$dOrA = "Cashed";
			$colorDorA = "#090";
			$dSign = "+";
			if($pay["pfp_dare_avere"]=="dare"){
				$dOrA = "Reimbursed";
				$colorDorA = "#c00";
				$dSign = "-";
			}
			if($pay["pfp_dare_avere"]=="acq"){
				$dOrA = "Due";
				$colorDorA = "#000";
				$dSign = "+";
			}
			$giroCifra = str_replace(",",".",$pay["pfp_importo"]);
			if($dOrA=="Cashed")
				$contaMoney += $giroCifra*1;
			else
				if($dOrA=="Reimbursed")
					$contaMoney -= $giroCifra*1;
				else
					$contaDue += $giroCifra*1;
			$lastValuta = $pay["pfp_valuta"];
		}
		$formattedMoney = number_format($contaMoney, 2,",",".");
		$formattedDue = number_format($contaDue, 2,",",".");
		$contaTotal = $contaMoney - $contaDue;
		$totalDue = number_format($contaTotal, 2,",",".")." ".$lastValuta;
        return $totalDue;
}

function dueById($idBk){
		$data=array();
        $this->db->where(array('pfp_bk_id' => $idBk, 'pfp_dare_avere' => "acq"));
		$this->db->order_by('pfp_data_operazione');
        $Q=$this->db->get('plused_fincon_payments');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
		$contaDue=0;
		$lastValuta = "";
		foreach($data as $pay){
			$dOrA = "Cashed";
			$colorDorA = "#090";
			$dSign = "+";
			$giroCifra = str_replace(",",".",$pay["pfp_importo"]);
			$contaDue += $giroCifra*1;
			$lastValuta = $pay["pfp_valuta"];
		}
		$formattedDue = number_format($contaDue, 2,",",".")." ".$lastValuta;
        return $formattedDue;
}

function getAllRegions(){
				$data=array();
				$this->db->order_by('reg_descrizione');
                $Q=$this->db->get('plused_tb_regione');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function getAllCountries(){
				$data=array();
				$this->db->order_by('cou_descrizione');
                $Q=$this->db->get('plused_tb_country');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function getAllCities(){
				$data=array();
				$this->db->order_by('cit_descrizione');
                $Q=$this->db->get('plused_tb_citta');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function getAllCompanies(){
				$data=array();
				$this->db->order_by('tra_cp_name');
                $Q=$this->db->get('plused_tra_companies');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function getAllAgencies(){
				$data=array();
                $this->db->order_by('businessname');
                $this->db->where('status =','active');
                $Q=$this->db->get('agenti');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function getAgenciesForAutoComplete($term){
	$data=array();
	$this->db->select('id,businessname');
	$this->db->like('businessname', $term, 'after');
    $Q = $this->db->get('agenti');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $rowOk["id"] = $row["id"];
			$rowOk["label"] = $row["businessname"];
			$rowOk["value"] = $row["id"];
			$data[]=$rowOk;
        }
    }
    $Q->free_result();
    return json_encode($data);
}

function change_booking_status($id,$stato,$dataok,$lm){
	if($dataok){
    		$data=array(
     		'status' => $stato,
			'data_scadenza' => $dataok,
			'flag_lm' => $lm
		);
	}else{
    		$data=array(
     			'status' => $stato,
				'flag_lm' => $lm
		);
	}
    $this->db->where('id_book', $id);
	$this->db->update('plused_book',$data);
	$agemail = $this->getAgentMailByOrderId($id);
	return $agemail;
}

function add_flag_payment($id){
	$data=array(
    		'flag_paid' => 1
	);
    $this->db->where('id_book', $id);
	$this->db->update('plused_book',$data);
	return true;
}

function add_flag_checkPay($id){
	$data=array(
    		'flag_checkpay' => 1
	);
    $this->db->where('id_book', $id);
	$this->db->update('plused_book',$data);
	return true;
}

function add_flag_cfd($id){
	$data=array(
    		'flag_cfd' => 1
	);
    $this->db->where('id_book', $id);
	$this->db->update('plused_book',$data);
	return true;
}


function changeDownloadVisa($id,$canDwn){
   	$data=array(
    		'downloadVisa' => $canDwn
	);
    $this->db->where('id_book', $id);
	$this->db->update('plused_book',$data);
	echo $this->db->last_query();
	return true;
}

function unlockRoster($idBook){
   	$data=array(
    		'lockPax' => 0,
			'downloadVisa' => 0,
			'template' => NULL,
			'template_date' => NULL
	);
    $this->db->where('id_book', $idBook);
	$this->db->update('plused_book',$data);

	$data=array(
    		'lockPax' => 0,
			'template' => NULL,
			'template_date' => NULL
	);
    $this->db->where('id_book', $idBook);
	$this->db->update('plused_rows',$data);
	return true;
}


function getAgentMailByOrderId($id){
	$querya = "SELECT agenti.email as agemail from agenti, plused_book where agenti.id=plused_book.id_agente and id_book = $id";
	$Q=$this->db->query($querya);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
			$agemail = $row["agemail"];
		}
	}
	return $agemail;

}

function get_booking_detail($id){
                $data=array();
                $this->db->where('id_book',$id);
                $Q = $this->db->get('plused_book');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
							$this->db->select('valuta,gruppo_fattura,valore_acconto,costo_homestay,costo_standard,costo_ensuite,costo_twin,nome_centri,located_in,valuta_fattura');
							$nomedelcentro = $row["id_centro"];
							$this->db->where('id',$nomedelcentro);
							$queryvaluta = $this->db->get('centri');
							$recordvaluta = $queryvaluta->result_array();
							$row['valuta']=utf8_decode($recordvaluta[0]['valuta']);
							$row['gruppo_fattura']=$recordvaluta[0]['gruppo_fattura'];
							$row['valore_acconto']=$recordvaluta[0]['valore_acconto'];
							$row['costo_homestay']=$recordvaluta[0]['costo_homestay'];
							$row['costo_standard']=$recordvaluta[0]['costo_standard'];
							$row['costo_ensuite']=$recordvaluta[0]['costo_ensuite'];
							$row['costo_twin']=$recordvaluta[0]['costo_twin'];
							$row['centro_name']=$recordvaluta[0]['nome_centri'];
							$row['located_in']=$recordvaluta[0]['located_in'];
							$row['valuta_fattura']=$recordvaluta[0]['valuta_fattura'];
                           	$data[] = $row;
							$queryvaluta->free_result();
                        }
                }
                $Q->free_result();
                return $data;
}


function agent_detail($id){
    $data = null;
     $this->db->where('id',$id);
              $Q = $this->db->get('agenti');
              if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data[] = $row;
                }
            }
            $Q->free_result();
            return $data;
}

function agentIdByBkIdYear($year,$book){
    $data = null;
	$this->db->select('id_agente');
    $this->db->where('id_year',$year);
	$this->db->where('id_book',$book);
    $Q = $this->db->get('plused_book');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row;
        }
    }
    $Q->free_result();
    return $data["id_agente"];
}

function agentIdByBkId($book){
    $data = null;
	$this->db->select('id_agente');
	$this->db->where('id_book',$book);
    $Q = $this->db->get('plused_book');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row;
        }
    }
    $Q->free_result();
    return $data["id_agente"];
}


function getWeeksByDaysByBkId($book){
    $daysTot = null;
	$this->db->select('arrival_date, departure_date');
	$this->db->where('id_book',$book);
    $Q = $this->db->get('plused_book');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $arrDay = strtotime($row['arrival_date']);
			$depDay = strtotime($row['departure_date']);
			$daysTot = round(($depDay - $arrDay)/86400);
        }
    }
    $Q->free_result();
	if($daysTot<8){
		$weeks=1;
	}else{
		if($daysTot<15){
			$weeks=2;
		}else{
			if($daysTot<22)
				$weeks=3;
			else
				$weeks=4;
		}
	}
    return $weeks;
}



function agentNameById($id){
    $data = null;
	$this->db->select('businessname');
    $this->db->where('id',$id);
    $Q = $this->db->get('agenti');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row;
        }
    }
    $Q->free_result();
    return $data["businessname"];
}

function agentCountryById($id){
    $data = null;
	$this->db->select('businesscountry');
    $this->db->where('id',$id);
    $Q = $this->db->get('agenti');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row;
        }
    }
    $Q->free_result();
    return $data["businesscountry"];
}

function getCmMailFromCampusId($idcampus){
    $cmmail = null;
	$querya = "SELECT email as cmmail from members where campusid_ref = $idcampus";
	$Q=$this->db->query($querya);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
			$cmmail = $row["cmmail"];
		}
	}
	return $cmmail;

}

function set_first_print($id){
		$data=array('print_1' => 1);
		$this->db->where('id_book', $id);
		$this->db->update('plused_book',$data);
}

function set_second_print($id){
		$data=array('print_2' => 1);
		$this->db->where('id_book', $id);
		$this->db->update('plused_book',$data);
}


//function ereditate dal vecchio gestione_contabile_model
 function transfer_status($centro,$from_data,$from_agenzia,$from_status){
              $data=array();
                $this->db->order_by('data_inizio');
		  if($centro){
               	 $this->db->where('id_centro',$centro);
		  }
		  if($from_data){
			$sql_data = date('Y-m-d',strtotime($from_data));
                	$this->db->where('data_inizio >=',$sql_data);
		  }
		  if($from_agenzia){
               	 $this->db->where('id_agency',$from_agenzia);
		  }
		  if($from_status){
               	 $this->db->where('status',$from_status);
		  }
                $Q = $this->db->get('periodi');
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
                            $data[] = $row;
                        }
                }
                $Q->free_result();
                return $data;
 }

function clear_id($idtoclear,$thepax,$thedeposit){
	 $data=array(
        'can_confirm' => 1,
		'status' => 'confirmed',
		'acconto_versato' => $thedeposit/*,
		'tot_pax' => $thepax*/
        );
		$annoid = explode("_",$idtoclear);
        $this->db->where('id_book', $annoid[1]);
		$this->db->where('id_year', $annoid[0]);
        $this->db->update('plused_book',$data);
 }

function insertPayment($idtoclear,$thedeposit,$thepayment,$thecurrency,$currencydate,$dareAvere,$theType,$thenotes){
	$data = array(
			'pfp_bk_id' => $idtoclear,
			'pfp_importo' => $thedeposit,
			'pfp_valuta' => $thecurrency,
			'pfp_data_valuta' => $currencydate,
			'pfp_dare_avere' => $dareAvere,
			'pfp_tipo_servizio' => $theType,
			'pfp_metodo_pagamento' => $thepayment,
			'pfp_note' => str_replace("'","''",$thenotes)
	);
	$this->db->insert('plused_fincon_payments', $data);
}


function deleteSinglePayment($idSP){
	$this->db->where('pfp_id', $idSP);
	$this->db->delete('plused_fincon_payments');
	return true;
}


function view_outstandings($centro,$from_data,$from_agenzia,$from_status,$confirm=1,$outstandings=9){
              $data=array();
                $this->db->order_by('data_inizio');
		  if($centro){
               	 $this->db->where('id_centro',$centro);
		  }
		  if($from_data){
			$sql_data = date('Y-m-d',strtotime($from_data));
                	$this->db->where('data_inizio >=',$sql_data);
		  }
		  if($from_agenzia){
               	 $this->db->where('id_agency',$from_agenzia);
		  }
		  if($from_status){
               	 $this->db->where('status',$from_status);
		  }
		  $this->db->where('final_status',$outstandings);
		//mettere confirm a 2 per avere sia i record cleared che quelli non cleared
		 if($confirm < 2){
            	 	$this->db->where('can_confirm',$confirm);
		 }
                $Q = $this->db->get('periodi');
				echo $this->db->last_query();
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
				 $row["gtotal"]=$this->mbackoffice->getfullprice($row["id"]);
				 //print_r($row);
				 $data2=array();
				 $acco = $row["accomodation"];
				 $this->db->select('valuta, valore_acconto, costo_homestay, costo_standard, costo_ensuite');
				 $nomedelcentro = $row["id_centro"];
				 $this->db->where('nome_centri',$nomedelcentro);
				 $queryvaluta = $this->db->get('centri');
				 $recordvaluta = $queryvaluta->result_array();
				 //print_r($row);
				 $row['valuta']=$recordvaluta[0]['valuta'];
				 $row['valore_acconto']=$recordvaluta[0]['valore_acconto'];
					switch ($acco) {
						case "Home stay":
							$row['costoperpax']=$recordvaluta[0]['costo_homestay'];
							break;
						case "College Standard":
							$row['costoperpax']=$recordvaluta[0]['costo_standard'];
							break;
						case "College En suite":
							$row['costoperpax']=$recordvaluta[0]['costo_ensuite'];
							break;
					}
				 //echo $acco."-".$row['costoperpax']."<br />";
                            $data[] = $row;
				$queryvaluta->free_result();
                        }
                }
                $Q->free_result();
                return $data;
}

function getfullprice($id){
	$data=array();
	$this->db->where('id',$id);
	$Q = $this->db->get('periodi');
	if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
			$data2=array();
			$acco = $row["accomodation"];
			$this->db->select('valuta, valore_acconto, costo_homestay, costo_standard, costo_ensuite');
			$nomedelcentro = $row["id_centro"];
			$this->db->where('nome_centri',$nomedelcentro);
			$queryvaluta = $this->db->get('centri');
			$recordvaluta = $queryvaluta->result_array();
			$row['valuta']=$recordvaluta[0]['valuta'];
			$row['valore_acconto']=$recordvaluta[0]['valore_acconto'];
			$row['costoperpax']=0;
			switch ($acco) {
				case "Home stay":
					$row['costoperpax']=$recordvaluta[0]['costo_homestay'];
					break;
				case "College Standard":
					$row['costoperpax']=$recordvaluta[0]['costo_standard'];
					break;
				case "College En suite":
					$row['costoperpax']=$recordvaluta[0]['costo_ensuite'];
					break;
			}
            $data[] = $row;
			$queryvaluta->free_result();
        }
    }
    $Q->free_result();
	$agentdiscount=(($row['tot_pax']*$row['costoperpax']*$row['weeks'])/100)*30; //RECUPERARE SCONTO DA AGENCY
	$totalegroupleaders=$row['extragl']*1;
	$scontoextra=$row['extradiscount']*1;
	$extraperiod=$row['extraperiod']*1;
	$accontoricevuto = $row['acconto_versato']*1;
	$costopax=$row['tot_pax']*$row['costoperpax']*$row['weeks'];
	//echo  $costopax.":-".$agentdiscount.":-".$scontoextra.":-".$accontoricevuto.":+".$totalegroupleaders.":+".$extraperiod;
	$grand_total = $costopax-$agentdiscount-$scontoextra-$accontoricevuto+$totalegroupleaders+$extraperiod;
	//echo "--->".$grand_total."<br />";
    return $grand_total;
}


function editBook($id_book){
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
	  'arrival_date' => $data_arrivo,
	  'departure_date' => $data_partenza,
	  'weeks' => $this->input->xss_clean($this->input->post('n_weeks')),
	  'tot_pax' => $tot_pax
        );
	$this->db->where('id_book', $id_book);
	$this->db->update('plused_book', $data);
}

function RE_insertRows($book_id,$anno){
	$this->db->where('id_book', $book_id);
	$this->db->where('id_year', $anno);
	$this->db->delete('plused_rows');
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
			$newpwd = $this->generateUUID();
			$i = $this->checkUUID($newpwd);
		}while ($i > 0);
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
			$newpwd = $this->generateUUID();
			$i = $this->checkUUID($newpwd);
		}while ($i > 0);
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
			$newpwd = $this->generateUUID();
			$i = $this->checkUUID($newpwd);
		}while ($i > 0);
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
			$newpwd = $this->generateUUID();
			$i = $this->checkUUID($newpwd);
		}while ($i > 0);
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
			$newpwd = $this->generateUUID();
			$i = $this->checkUUID($newpwd);
		}while ($i > 0);
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
			$newpwd = $this->generateUUID();
			$i = $this->checkUUID($newpwd);
		}while ($i > 0);
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
			$newpwd = $this->generateUUID();
			$i = $this->checkUUID($newpwd);
		}while ($i > 0);
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
			$newpwd = $this->generateUUID();
			$i = $this->checkUUID($newpwd);
		}while ($i > 0);
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


function OLD_insertCampusAvailability(){
    $st_ensuite = $this->input->xss_clean($this->input->post('st_ensuite'));
	$st_standard = $this->input->xss_clean($this->input->post('st_standard'));
	$st_homestay = $this->input->xss_clean($this->input->post('st_homestay'));

	$arr = explode("/", $this->input->post('arrival_date'));
	$data_arrivo=$arr[2]."-".$arr[0]."-".$arr[1];
	$arr2 = explode("/", $this->input->post('departure_date'));
	$data_partenza=$arr2[2]."-".$arr2[0]."-".$arr2[1];

	if($st_ensuite > 0){
		$data = array(
		  'id_campus' => $this->input->xss_clean($this->input->post('center_select')),
		  'start_date' => $data_arrivo,
		  'finish_date' => $data_partenza,
		  'accomodation_type' => 'ensuite',
		  'availability' => $st_ensuite
        );
		$this->db->insert('plused_campus_availability', $data);
	}
	if($st_standard > 0){
		$data = array(
		  'id_campus' => $this->input->xss_clean($this->input->post('center_select')),
		  'start_date' => $data_arrivo,
		  'finish_date' => $data_partenza,
		  'accomodation_type' => 'standard',
		  'availability' => $st_standard
        );
		$this->db->insert('plused_campus_availability', $data);
	}
	if($st_homestay > 0){
		$data = array(
		  'id_campus' => $this->input->xss_clean($this->input->post('center_select')),
		  'start_date' => $data_arrivo,
		  'finish_date' => $data_partenza,
		  'accomodation_type' => 'homestay',
		  'availability' => $st_homestay
        );
		$this->db->insert('plused_campus_availability', $data);
	}
}

function getBkCalendar($campus,$accomodation,$month,$year){
	// Set timezone
	date_default_timezone_set('UTC');
	// Start date
	$date = $year.'-'.$month.'-01';
	// End date
	$end_date = date ("Y-m-d", strtotime("+1 month -1day", strtotime($date)));
	//echo $date."--".$end_date;
	$contagiri = 0;
	while (strtotime($date) <= strtotime($end_date)) {
		$backjson[] = $this->getTotAva($campus,$accomodation,$date);
		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		$contagiri++;
	}
	return $backjson;
}

function getTotAva($campus,$accomodation,$date){
		$querya = "SELECT SUM(availability) as dispo FROM plused_campus_availability WHERE start_date <= '$date' AND finish_date >= '$date' AND accomodation_type = '$accomodation' AND id_campus = $campus";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["dispo"]){
					$avaok=0;
				}else{
					$avaok = $row["dispo"];
				}
				$multistatus = array("confirmed","active");
				$booked = $this->getTotBk($campus,$accomodation,$date,$multistatus);
				$avarest = $avaok-$booked;
				if($avarest >= 0){
					$record["avaOver"] = "r_available";
				}else{
					$record["avaOver"] = "r_overflow";
				}
				$record["totale"] = $avaok;
				$record["booked"] = $booked;
				$record["n_available"] = $avarest;
				$multistatus = array("confirmed");
				$confirmed = $this->getTotBk($campus,$accomodation,$date,$multistatus);
				$record["n_confirmed"] = $confirmed;
				$multistatus = array("active");
				$active = $this->getTotBk($campus,$accomodation,$date,$multistatus);
				$record["n_active"] = $active;
				$multistatus = array("tbc");
				$tbc = $this->getTotBk($campus,$accomodation,$date,$multistatus);
				$record["n_tbc"] = $tbc;
				$multistatus = array("elapsed");
				$elapsed = $this->getTotBk($campus,$accomodation,$date,$multistatus);
				$record["n_elapsed"] = $elapsed;
				$record["datat"] = $date;
				$record["num_in"] = $this->getArrBk($campus,$accomodation,$date);
				$record["num_out"] = $this->getDepBk($campus,$accomodation,$date);
            }
		}
        $Q->free_result();
		return $record;
}

function getTotAvaAllAccos($campus,$date, $multistatus,$glIncluded=1){
		$querya = "SELECT SUM(availability) as dispo FROM plused_campus_availability WHERE start_date <= '$date' AND finish_date >= '$date' AND id_campus = $campus";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["dispo"]){
					$avaok=0;
				}else{
					$avaok = $row["dispo"];
				}
				//$multistatus = array("confirmed","active");
				$booked = $this->getTotBk($campus,"",$date,$multistatus,$glIncluded);
				$avarest = $avaok-$booked;
				if($avarest >= 0){
					$record["avaOver"] = "r_available";
				}else{
					$record["avaOver"] = "r_overflow";
				}
				$record["totale"] = $avaok;
				$record["booked"] = $booked;
				$record["n_available"] = $avarest;
				$multistatus = array("confirmed");
				$confirmed = $this->getTotBk($campus,"",$date,$multistatus,$glIncluded);
				$record["n_confirmed"] = $confirmed;
				$multistatus = array("active");
				$active = $this->getTotBk($campus,"",$date,$multistatus,$glIncluded);
				$record["n_active"] = $active;
				$multistatus = array("tbc");
				$tbc = $this->getTotBk($campus,"",$date,$multistatus,$glIncluded);
				$record["n_tbc"] = $tbc;
				$multistatus = array("elapsed");
				$elapsed = $this->getTotBk($campus,"",$date,$multistatus,$glIncluded);
				$record["n_elapsed"] = $elapsed;
				$record["datat"] = $date;
            }
		}
        $Q->free_result();
		return $record;
}

function getTotBk($campus,$accomodation="",$date,$multistatus,$glIncluded=1){
		$bkok="";
		//print_r($multistatus);
		if($accomodation==""){
			// tolto dalla prossima riga il >= per departure date per togliere dai conti l'ultimo giorno di permanenza oncampus
			$querya="SELECT COUNT(plused_rows.id_prenotazione) as totale FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_book.arrival_date <= '$date' AND plused_book.departure_date > '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year";
		}else{
			// tolto dalla prossima riga il >= per departure date per togliere dai conti l'ultimo giorno di permanenza oncampus
			$querya="SELECT COUNT(plused_rows.id_prenotazione) as totale FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_book.arrival_date <= '$date' AND plused_book.departure_date > '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
		}
		if($glIncluded==0)
			$querya .= " AND plused_rows.tipo_pax <> 'GL'";
		$contastati = 0;
		if(count($multistatus)){
			$querya .= " AND(";
			foreach($multistatus as $stato){
				if($contastati > 0){
					$querya .= " OR";
				}
				$querya .= " plused_book.status = '$stato'";
				$contastati++;
			}
			$querya .= " )";
		}
		if($accomodation=="")
			$querya .= " ";
		else
			$querya .= " GROUP BY plused_rows.accomodation";
		//echo "<br />-".$querya."<br />";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["totale"]){
					$bkok=0;
				}else{
					$bkok = $row["totale"];
				}
            }
		}
        $Q->free_result();
		return $bkok+0;
}

function getD2DBk($campus,$accomodation,$date,$status){
    $data = array();
		//questa function, senza distinct, count e group by verra' buona per gli elenchi pax (campus manager...)
		if($accomodation != "all"){//agenti.businessname,
			$querya="SELECT DISTINCT plused_book.id_book,plused_book.id_year,  agenti.businesscountry, count(plused_rows.id_prenotazione) as pax_totali, plused_book.status, centri.nome_centri as centro, plused_book.arrival_date, plused_book.departure_date FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.arrival_date <= '$date' AND plused_book.departure_date >= '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
		}else{
			$querya="SELECT DISTINCT plused_book.id_book,plused_book.id_year, agenti.businesscountry, count(plused_rows.id_prenotazione) as pax_totali, plused_book.status, centri.nome_centri as centro, plused_book.arrival_date, plused_book.departure_date FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.arrival_date <= '$date' AND plused_book.departure_date >= '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year";
		}
		if($status==""){
			$querya.=" AND (plused_book.status = 'active' OR plused_book.status = 'confirmed')";
		}else{
			$querya.=" AND plused_book.status='".$status."'";
		}
		$querya.=" GROUP BY(plused_rows.id_book)";
		$Q=$this->db->query($querya);
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[] = $row;
            }
		}
        $Q->free_result();
		return $data;
}

function getD2DBkDate($campus,$accomodation,$date,$status){
		//questa function, senza distinct, count e group by verra' buona per gli elenchi pax (campus manager...)
		if($accomodation != "all"){//agenti.businessname,
			$querya="SELECT DISTINCT CONCAT(plused_book.id_year,'_',plused_book.id_book) as bookid,plused_book.arrival_date, plused_book.departure_date,centri.nome_centri as centro, count(plused_rows.id_prenotazione) as pax_totali    FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.arrival_date <= '$date' AND plused_book.departure_date >= '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
		}else{
			$querya="SELECT DISTINCT CONCAT(plused_book.id_year,'_',plused_book.id_book) as bookid,plused_book.arrival_date, plused_book.departure_date,centri.nome_centri as centro, count(plused_rows.id_prenotazione) as pax_totali FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.arrival_date <= '$date' AND plused_book.departure_date >= '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year";
		}
		if($status==""){
			$querya.=" AND (plused_book.status = 'active' OR plused_book.status = 'confirmed')";
		}else{
			$querya.=" AND plused_book.status='".$status."'";
		}
		$querya.=" GROUP BY(plused_rows.id_book)";
		$Q=$this->db->query($querya);
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[] = $row;
            }
		}
        $Q->free_result();
		return $data;
}


function getArrBk($campus,$accomodation="",$date){
		$arrbk="";
		//print_r($multistatus);
		if($accomodation=="")
			$querya="SELECT COUNT(plused_book.id_book) as num_in FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_book.arrival_date = '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_book.status = 'confirmed'";
		else
			$querya="SELECT COUNT(plused_book.id_book) as num_in FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_book.arrival_date = '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation' AND plused_book.status = 'confirmed' GROUP BY plused_rows.accomodation";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["num_in"]){
					$arrbk=0;
				}else{
					$arrbk = $row["num_in"];
				}
            }
		}
        $Q->free_result();
		return $arrbk+0;
}

function getDepBk($campus,$accomodation="",$date){
		$depbk="";
		//print_r($multistatus);
		if($accomodation=="")
			$querya="SELECT COUNT(plused_book.id_book) as num_in FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_book.departure_date = '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_book.status = 'confirmed'";
		else
			$querya="SELECT COUNT(plused_book.id_book) as num_in FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_book.departure_date = '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation' AND plused_book.status = 'confirmed' GROUP BY plused_rows.accomodation";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["num_in"]){
					$depbk=0;
				}else{
					$depbk = $row["num_in"];
				}
            }
		}
        $Q->free_result();
		return $depbk+0;
}

function getSimCalendar($campus,$accomodation,$datein,$dateout){
	// Set timezone
	date_default_timezone_set('UTC');
	// Start date
	$date = $datein;
	// End date
	$end_date = $dateout;
	//echo $date."--".$end_date;
	$contagiri = 0;
	while (strtotime($date) <= strtotime($end_date)) {
		$backcal[] = $this->getTotAva($campus,$accomodation,$date);
		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		$contagiri++;
	}
	return $backcal;
}

function getSimCalendarAllAccos($campus,$datein,$dateout,$multistatus,$glIncluded=1){
	// Set timezone
	date_default_timezone_set('UTC');
	// Start date
	$date = $datein;
	// End date
	$end_date = $dateout;
	//echo $date."--".$end_date;
	$contagiri = 0;
	while (strtotime($date) <= strtotime($end_date)) {
		$backcal[] = $this->getTotAvaAllAccos($campus,$date,$multistatus,$glIncluded);
		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		$contagiri++;
	}
	return $backcal;
}


function getSimBooking($campus,$accomodation,$datein,$dateout){
	// Set timezone
	date_default_timezone_set('UTC');
	// Start date
	$date = $datein;
	// End date
	$end_date = $dateout;
	//echo $date."--".$end_date;
	$backbkg=array();
	$contagiri = 0;
	$querya="SELECT DISTINCT plused_book.id_book, plused_book.id_year, agenti.businessname, COUNT(plused_book.id_book) as num_in, plused_book.arrival_date, plused_book.departure_date, plused_book.status FROM plused_book, plused_rows, agenti WHERE plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.departure_date >= '$datein' AND plused_book.arrival_date <= '$dateout' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation' AND (plused_book.status = 'confirmed' OR plused_book.status = 'active')";
	$querya .= " GROUP BY plused_rows.accomodation, plused_book.id_book ORDER BY num_in DESC";
	$Q=$this->db->query($querya);
	echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
					$backbkg[] = $row;
            }
		}
        $Q->free_result();
		//print_r($backbkg);
	return $backbkg;
}

function NA_getSimBooking_backoffice($campus,$accomodation,$datein,$dateout,$arrayStatus){
	// Set timezone
	date_default_timezone_set('UTC');
	// Start date
	$date = $datein;
	// End date
	$end_date = $dateout;
	//echo $date."--".$end_date;
	$backbkg=array();
	$contagiri = 0;
	/*
	MODIFICA DEL 17 giugno 2015 per spostare da opzionato a confermato
	$querya="SELECT DISTINCT plused_book.id_book, plused_book.id_year, agenti.businessname, COUNT(plused_book.id_book) as num_in, plused_book.arrival_date, plused_book.departure_date, plused_book.status, agenti.businesscountry FROM plused_book, plused_rows, agenti WHERE plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.departure_date >= '$datein' AND plused_book.arrival_date <= '$dateout' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation' AND ( ";
	$contastati=1;
	//echo count($arrayStatus);
	foreach($arrayStatus as $stat){
		$querya .= "plused_book.status = '".$stat."'";
		if($contastati < count($arrayStatus))
			$querya .= " OR ";
		$contastati++;
	}
	$querya .= ") GROUP BY plused_rows.accomodation, plused_book.id_book ORDER BY num_in DESC";
	*/
	$querya="SELECT DISTINCT plused_rows.id_book, plused_rows.id_year, agenti.businessname, COUNT(plused_rows.id_book) as num_in, plused_rows.data_arrivo_campus as arrival_date, plused_rows.data_partenza_campus as departure_date, plused_book.status, agenti.businesscountry, COUNT(CASE WHEN plused_rows.cognome IS NOT NULL AND plused_rows.cognome <> '' THEN 1 END) as contaPieni FROM plused_book, plused_rows, agenti WHERE plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_rows.data_arrivo_campus <= '$dateout' AND plused_rows.data_partenza_campus >= '$datein' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation' AND ( ";
	$contastati=1;
	//echo count($arrayStatus);
	foreach($arrayStatus as $stat){
		$querya .= "plused_book.status = '".$stat."'";
		if($contastati < count($arrayStatus))
			$querya .= " OR ";
		$contastati++;
	}
	$querya .= ") GROUP BY plused_rows.accomodation, plused_rows.data_partenza_campus, plused_rows.data_arrivo_campus, plused_book.id_book ORDER BY plused_book.id_book, num_in DESC";
	$Q=$this->db->query($querya);
	//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
					$backbkg[] = $row;
            }
		}
        $Q->free_result();
		//print_r($backbkg);
	return $backbkg;
}

    function NA_getSimBooking_overnight_backoffice($campus,$accomodation,$datein="",$dateout="",$arrayStatus){
        // Set timezone
        date_default_timezone_set('UTC');
        // Start date
        $date = $datein;
        // End date
        $end_date = $dateout;
        //echo $date."--".$end_date;
        $backbkg=array();
        $contagiri = 0;
        /*
        MODIFICA DEL 17 giugno 2015 per spostare da opzionato a confermato
        $querya="SELECT DISTINCT plused_book.id_book, plused_book.id_year, agenti.businessname, COUNT(plused_book.id_book) as num_in, plused_book.arrival_date, plused_book.departure_date, plused_book.status, agenti.businesscountry FROM plused_book, plused_rows, agenti WHERE plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.departure_date >= '$datein' AND plused_book.arrival_date <= '$dateout' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation' AND ( ";
        $contastati=1;
        //echo count($arrayStatus);
        foreach($arrayStatus as $stat){
            $querya .= "plused_book.status = '".$stat."'";
            if($contastati < count($arrayStatus))
                $querya .= " OR ";
            $contastati++;
        }
        $querya .= ") GROUP BY plused_rows.accomodation, plused_book.id_book ORDER BY num_in DESC";
        */
        //con date e accomodation da rows
        //$querya="SELECT DISTINCT plused_rows.id_book, plused_rows.id_year, agenti.businessname, COUNT(plused_rows.id_book) as num_in, plused_book_overnights.arrival_date as arrival_date, plused_book_overnights.departure_date as departure_date, plused_book_overnights.status, agenti.businesscountry, COUNT(CASE WHEN plused_rows.cognome IS NOT NULL AND plused_rows.cognome <> '' THEN 1 END) as contaPieni FROM plused_book_overnights, plused_rows, agenti WHERE plused_book_overnights.id_agente = agenti.id AND plused_book_overnights.id_centro = $campus AND plused_rows.data_arrivo_campus <= '$dateout' AND plused_rows.data_partenza_campus >= '$datein' AND plused_book_overnights.id_book = plused_rows.id_book AND plused_book_overnights.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation' AND ( ";
        //con date e accomodation da book_overnight
        $querya="SELECT DISTINCT plused_rows.id_book, plused_rows.id_year, agenti.businessname, COUNT(plused_rows.id_book) as num_in, plused_book_overnights.arrival_date as arrival_date, plused_book_overnights.departure_date as departure_date, plused_book_overnights.status, agenti.businesscountry, COUNT(CASE WHEN plused_rows.cognome IS NOT NULL AND plused_rows.cognome <> '' THEN 1 END) as contaPieni FROM plused_book_overnights, plused_rows, agenti WHERE plused_book_overnights.id_agente = agenti.id AND plused_book_overnights.id_centro = $campus AND plused_book_overnights.arrival_date <= '$dateout' AND plused_book_overnights.departure_date >= '$datein' AND plused_book_overnights.id_book = plused_rows.id_book AND plused_book_overnights.id_year = plused_rows.id_year AND plused_book_overnights.accomodation = '$accomodation' AND ( ";
        $contastati=1;
        //echo count($arrayStatus);
        foreach($arrayStatus as $stat){
            $querya .= "plused_book_overnights.status = '".$stat."'";
            if($contastati < count($arrayStatus))
                $querya .= " OR ";
            $contastati++;
        }
        //con date e accomodation da rows
        //$querya .= ") GROUP BY plused_rows.accomodation, plused_rows.data_partenza_campus, plused_rows.data_arrivo_campus, plused_book_overnights.id_book ORDER BY plused_book_overnights.id_book, num_in DESC";
        //con date e accomodation da book_overnight
        $querya .= ") GROUP BY plused_book_overnights.accomodation, plused_book_overnights.departure_date, plused_book_overnights.arrival_date, plused_book_overnights.id_book ORDER BY plused_book_overnights.id_book, num_in DESC";
        $Q=$this->db->query($querya);
        //echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $backbkg[] = $row;
            }
        }
        $Q->free_result();
        //print_r($backbkg);
        return $backbkg;
    }


function NA_getSimBookingAllAccos_backoffice($campus,$datein,$dateout,$arrayStatus,$includedGL=1){
	// Set timezone
	date_default_timezone_set('UTC');
	// Start date
	$date = $datein;
	// End date
	$end_date = $dateout;
	//echo $date."--".$end_date;
	$backbkg=array();
	$contagiri = 0;
	$querya="SELECT DISTINCT plused_book.id_book, plused_book.id_year, agenti.businessname, COUNT(plused_book.id_book) as num_in, plused_book.arrival_date, plused_book.departure_date, plused_book.status, agenti.businesscountry FROM plused_book, plused_rows, agenti WHERE plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.departure_date >= '$datein' AND plused_book.arrival_date <= '$dateout' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND ( ";
	$contastati=1;
	//echo count($arrayStatus);
	foreach($arrayStatus as $stat){
		$querya .= "plused_book.status = '".$stat."'";
		if($contastati < count($arrayStatus))
			$querya .= " OR ";
		$contastati++;
	}
	$querya .= ") ";
	if($includedGL==0)
		$querya .= "AND plused_rows.tipo_pax <> 'GL' ";
	$querya .= "GROUP BY plused_book.id_book ORDER BY num_in DESC";
	$Q=$this->db->query($querya);
	//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
					$backbkg[] = $row;
            }
		}
        $Q->free_result();
		//print_r($backbkg);
	return $backbkg;
}


function elapsedBookingsToElapse(){
		$dataOggi = date("Y-m-d");
		$queryUpd = "UPDATE plused_book SET status = 'elapsed' WHERE data_scadenza < '".$dataOggi."' AND status = 'active' AND acconto_versato = 0";
		$Q=$this->db->query($queryUpd);
		return $this->db->affected_rows();
}

function bookingExists($id){
                $this->db->where('id_book',$id);
                $Q = $this->db->from('plused_book');
				return $this->db->count_all_results();
}

function insertBkNote($idbk){
	if($this->input->post('testo') && $this->input->post('utente')){
		$data = array(
		  'n_testo' => $this->input->xss_clean($this->input->post('testo')),
		  'n_bkid' => $idbk,
		  'n_userid' => $this->input->xss_clean($this->input->post('utente')),
		  'n_public' => $this->input->xss_clean($this->input->post('notaPubblica'))
        );
		if($this->db->insert('plused_book_notes', $data)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	else{
		return FALSE;
	}

}

function sisByCenterId($idcentro){
					$data=array();
                    $this->db->from('plused_sistemazioni-centri');
                    $this->db->where('id_sis_centro',$idcentro);
                    $Q=$this->db->get();
                    if ($Q->num_rows() > 0){
						foreach ($Q->result_array() as $row){
							$data[]=$row;
						}
					}
                    $Q->free_result();
                    return $data;
	}

function getLowerSisById($idSis){
                    $this->db->from('plused_tb_accomodations');
                    $this->db->where('tba_id',$idSis);
                    $Q=$this->db->get();
                    if ($Q->num_rows() > 0){
						foreach ($Q->result_array() as $row){
							$lowSis=$row["tba_type_availability"];
						}
					}
                    $Q->free_result();
                    return $lowSis;
	}

function getAllSis(){
					$data=array();
					$this->db->order_by("tba_id","asc");
                    $this->db->from('plused_tb_accomodations');
                    $Q=$this->db->get();
                    if ($Q->num_rows() > 0){
						foreach ($Q->result_array() as $row){
							$data[]=$row;
						}
					}
                    $Q->free_result();
                    return $data;
}

function setUnplannedExcursions($campus,$tipo,$to,$from){
		$data=array();
		if($campus){
			$fromarray=explode("/",$from);
			$toarray=explode("/",$to);
			$frommysql = $fromarray[2]."-".$fromarray[1]."-".$fromarray[0];
			$tomysql = $toarray[2]."-".$toarray[1]."-".$toarray[0];
			$queryt = "SELECT id_year, id_book, exb_id, exc_excursion, businessname, businesscountry, nome_centri, exb_tot_pax, exc_weeks, plused_book.status as statopre, arrival_date, departure_date, exc_id, exc_length FROM plused_exc_bookings, plused_exc_all, plused_book, agenti, centri WHERE (plused_book.status = 'confirmed' OR plused_book.status = 'active') AND exc_id = exb_id_excursion and centri.id = exb_campus_id and agenti.id = id_agente and exb_id_book = id_book and exc_type = '".$tipo."' and centri.id = $campus AND exb_confirmed = 'NO' AND (plused_book.arrival_date <= '$tomysql' AND plused_book.departure_date >= '$frommysql') ORDER BY exb_id_excursion, exc_weeks, arrival_date, departure_date";
			//$queryt = "SELECT id_year, id_book, exb_id, exc_excursion, businessname, nome_centri, exb_tot_pax, exc_weeks, plused_book.status as statopre, arrival_date, departure_date FROM plused_exc_bookings, plused_exc_all, plused_book, agenti, centri WHERE (plused_book.status = 'confirmed' OR plused_book.status = 'active') AND exc_id = exb_id_excursion and centri.id = exb_campus_id and agenti.id = id_agente and exb_id_book = id_book and exc_type = '".$tipo."' and centri.id = $campus ORDER BY exb_id_excursion, exc_weeks";
			$Q=$this->db->query($queryt);
			//echo $this->db->last_query();
			if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
						$data[] = $row;
				}
			}
			$Q->free_result();
			//print_r($data);
			return $data;
		}else{
			return false;
		}
}

function viewPlannedExcursions($campus,$tipo,$to,$from,$status){
		$data=array();
		//if($campus){
			$fromarray=explode("/",$from);
			$toarray=explode("/",$to);
			$frommysql = $fromarray[2]."-".$fromarray[1]."-".$fromarray[0];
			$tomysql = $toarray[2]."-".$toarray[1]."-".$toarray[0];
			//$queryt2 = "SELECT SUM(exb_tot_pax) as allpax, exb_excursion_date, exb_buscompany_code, nome_centri, exb_confirmed, exc_excursion, exc_length, pbe_cm_done, pbe_cm_ok, pbe_cm_notes FROM plused_exc_bookings, plused_exc_all, centri, plused_bus_exc WHERE exb_buscompany_code = pbe_rndcode AND exb_campus_id = centri.id AND exb_id_excursion = exc_id AND exc_type = '".$tipo."' AND";
			$queryt2 = "SELECT SUM(exb_tot_pax) as allpax, exb_excursion_date, exb_buscompany_code, nome_centri, exb_confirmed, exc_excursion, exc_length FROM plused_exc_bookings, plused_exc_all, centri WHERE exb_campus_id = centri.id AND exb_id_excursion = exc_id AND exc_type = '".$tipo."' AND";
			if($status!="all")
				$queryt2 .= " exb_confirmed = '".$status."' AND";
			else
				$queryt2 .= " (exb_confirmed = 'STANDBY' OR exb_confirmed = 'YES') AND";
			if($campus){
				$queryt2 .= " exb_campus_id = $campus  AND";
			}
			$queryt2 .= "(exb_excursion_date <= '$tomysql' AND exb_excursion_date >= '$frommysql') GROUP BY exb_buscompany_code ORDER BY exb_excursion_date, nome_centri";

/*
			if($campus)
				$queryt = "SELECT SUM(exb_tot_pax) as allpax, exb_excursion_date, exb_buscompany_code, nome_centri FROM plused_exc_bookings, plused_exc_all, centri WHERE exb_campus_id = centri.id AND exb_campus_id = $campus AND exb_id_excursion = exc_id AND exc_type = '".$tipo."' AND exb_confirmed = '".$status."' AND (exb_excursion_date <= '$tomysql' AND exb_excursion_date >= '$frommysql') GROUP BY exb_buscompany_code ORDER BY exb_excursion_date, nome_centri";
			else
				$queryt = "SELECT SUM(exb_tot_pax) as allpax, exb_excursion_date, exb_buscompany_code, nome_centri FROM plused_exc_bookings, plused_exc_all, centri WHERE exb_campus_id = centri.id AND exb_id_excursion = exc_id AND exc_type = '".$tipo."' AND exb_confirmed = '".$status."' AND (exb_excursion_date <= '$tomysql' AND exb_excursion_date >= '$frommysql') GROUP BY exb_buscompany_code ORDER BY exb_excursion_date, nome_centri";
*/
			$Q=$this->db->query($queryt2);
			//echo "<br><br><br><br>".$this->db->last_query();
			if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
						$posti=0;
						$posti = $this->busSeatsForExcursion($row["exb_buscompany_code"]);
						$row["totPosti"] = $posti;
						$queryNotes = "SELECT pbe_cm_done, pbe_cm_ok, pbe_cm_notes FROM plused_bus_exc WHERE pbe_rndcode = '".$row["exb_buscompany_code"]."'";
						$QNotes=$this->db->query($queryNotes);
						if ($QNotes->num_rows() > 0){
							foreach ($QNotes->result_array() as $rowNotes){
								$row["pbe_cm_done"] = $rowNotes["pbe_cm_done"];
								$row["pbe_cm_ok"] = $rowNotes["pbe_cm_ok"];
								$row["pbe_cm_notes"] = $rowNotes["pbe_cm_notes"];
							}
						}
						$QNotes->free_result();
						$data[] = $row;
				}
			}
			$Q->free_result();
			//print_r($data);
			return $data;
		//}else{
		//	return false;
		//}
}

function viewBookedTransfers($campus,$tipo,$to,$from,$status){
			$data=array();
			$fromarray=explode("/",$from);
			$toarray=explode("/",$to);
			$frommysql = $fromarray[2]."-".$fromarray[1]."-".$fromarray[0];
			$tomysql = $toarray[2]."-".$toarray[1]."-".$toarray[0];

			$queryt2 = "SELECT SUM(ptt_tot_pax) as allpax, ptt_excursion_date, ptt_buscompany_code, nome_centri, ptt_type, ptt_confirmed, ptt_airport_to, ptt_airport_from FROM plused_tra_transfers, centri WHERE ptt_campus_id = centri.id AND";
			if($campus){
				$queryt2 .= " ptt_campus_id = $campus AND";
			}
			if($tipo!="all")
				$queryt2 .= " ptt_type = '".$tipo."' AND";
			if($status!="all")
				$queryt2 .= " ptt_confirmed = '".$status."' AND";
			else
				$queryt2 .= " (ptt_confirmed = 'STANDBY' OR ptt_confirmed = 'YES') AND";
			$queryt2 .= " (ptt_excursion_date <= '$tomysql' AND ptt_excursion_date >= '$frommysql') GROUP BY ptt_buscompany_code ORDER BY ptt_excursion_date, nome_centri";
			if($tipo=="inbound")
				$queryt2 .= ", ptt_airport_to";
			if($tipo=="outbound")
				$queryt2 .= ", ptt_airport_from";
			$Q=$this->db->query($queryt2);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
						$querycontarighe = "SELECT COUNT(pttr_id) as effettivi FROM plused_tra_transfers_rows, plused_tra_transfers WHERE pttr_trid = ptt_id AND ptt_buscompany_code = '".$row["ptt_buscompany_code"]."'";
						$Qconta=$this->db->query($querycontarighe);
						if ($Qconta->num_rows() > 0){
							foreach ($Qconta->result_array() as $rowConta){
								$row["effettivi"] = $rowConta["effettivi"];
							}
						}
						$queryvoli = "SELECT ptt_flight FROM plused_tra_transfers WHERE ptt_buscompany_code = '".$row["ptt_buscompany_code"]."' GROUP BY ptt_flight";
						$Qvoli=$this->db->query($queryvoli);
						if ($Qvoli->num_rows() > 0){
							$contaivoli=1;
							$stringavoli = "";
							foreach ($Qvoli->result_array() as $rowVoli){
								if($contaivoli>1 && $contaivoli <= count($Qvoli->result_array())){
									$stringavoli.= " - ";
								}
								$stringavoli .= $rowVoli["ptt_flight"];
								$contaivoli++;
							}
							$row["tuttivoli"] = $stringavoli;
						}
						$row["coaches"] = $this->getCompanyDetailsByBusCode($row["ptt_buscompany_code"]);
						$data[] = $row;
				}
			}
			$Q->free_result();
			//print_r($data);
			return $data;
}


function viewLostTransfers(){
			$data=array();

			$queryt2 = "SELECT SUM(ptt_tot_pax) as allpax, ptt_excursion_date, ptt_buscompany_code, nome_centri, ptt_type, ptt_confirmed, ptt_airport_to, ptt_airport_from, ptt_id, ptt_flight FROM plused_tra_transfers, centri WHERE ptt_campus_id = centri.id AND ptt_confirmed = 'NO'";
			$queryt2 .= "  GROUP BY ptt_id ORDER BY ptt_excursion_date, nome_centri";
			$Q=$this->db->query($queryt2);
			//echo $this->db->last_query();
			if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
						$data[] = $row;
				}
			}
			$Q->free_result();
			//echo $this->db->last_query();
			//print_r($data);
			return $data;
}

function actionResetLostTransfers(){
	$qDelNum = "DELETE FROM plused_tra_transfers_rows WHERE pttr_trid IN (SELECT ptt_id FROM plused_tra_transfers WHERE ptt_confirmed = 'NO')";
	$Q=$this->db->query($qDelNum);
	//echo $qDelNum;
	$qDelTest = "DELETE FROM plused_tra_transfers WHERE ptt_confirmed = 'NO'";
	$Q=$this->db->query($qDelTest);
	//echo $qDelTest;
	//die();
	return true;
}


function viewPlannedAllExcursions($campus,$tipo,$to,$from,$status){
		$data=array();
			$fromarray=explode("/",$from);
			$toarray=explode("/",$to);
			$frommysql = $fromarray[2]."-".$fromarray[1]."-".$fromarray[0];
			$tomysql = $toarray[2]."-".$toarray[1]."-".$toarray[0];

			$queryt2 = "SELECT SUM(pte_tot_pax) as allpax, pte_excursion_date, pte_buscompany_code, nome_centri, pte_type, pte_confirmed, pte_excursion_id, exc_excursion, exc_length FROM plused_tra_excursions, centri, plused_exc_all WHERE exc_id = pte_excursion_id AND pte_campus_id = centri.id AND";
			if($campus){
				$queryt2 .= " pte_campus_id = $campus AND";
			}
			if($tipo!="all")
				$queryt2 .= " pte_type = '".$tipo."' AND";
			if($status!="all")
				$queryt2 .= " pte_confirmed = '".$status."' AND";
			else
				$queryt2 .= " (pte_confirmed = 'STANDBY' OR pte_confirmed = 'YES') AND";
			$queryt2 .= " (pte_excursion_date <= '$tomysql' AND pte_excursion_date >= '$frommysql') GROUP BY pte_buscompany_code ORDER BY pte_excursion_date, nome_centri";

			$Q=$this->db->query($queryt2);
			//echo $this->db->last_query();
			if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
						$querycontarighe = "SELECT COUNT(pter_id) as effettivi FROM plused_tra_excursions_rows, plused_tra_excursions WHERE pter_trid = pte_id AND pte_buscompany_code = '".$row["pte_buscompany_code"]."'";
						$Qconta=$this->db->query($querycontarighe);
						//if($this->session->userdata('email')=="a.sudetti@gmail.com"){
						//	echo $this->db->last_query();
						//}
						if ($Qconta->num_rows() > 0){
							foreach ($Qconta->result_array() as $rowConta){
								$row["effettivi"] = $rowConta["effettivi"];
							}
						}
						$data[] = $row;
				}
			}
			$Q->free_result();
			//print_r($data);
			return $data;
}

function insertAllExc($year){
			//$queryt = "SELECT id_year, id_book, id_centro, tot_pax, weeks FROM plused_book WHERE YEAR(arrival_date) = ".$year." AND id_book = 680";
			$queryt = "SELECT id_year, id_book, id_centro, tot_pax, weeks, arrival_date, status FROM plused_book WHERE YEAR(arrival_date) = ".$year." and status = 'confirmed' AND id_book NOT IN (SELECT DISTINCT exb_id_book FROM plused_exc_bookings)";
			$Q=$this->db->query($queryt);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
						$actualweeks = $row["weeks"];
						for($weeks=1;$weeks<=$actualweeks;$weeks++){
							//echo "<pre><br>".$actualweeks."-->".$weeks."<br><br>";
							$query2 = "SELECT exc_id, exc_excursion, exc_type, exc_weeks FROM plused_exc_all WHERE exc_type = 'planned' AND exc_weeks = ".$weeks." AND exc_id_centro = ".$row["id_centro"]." ORDER BY exc_weeks";
							$Q2=$this->db->query($query2);
							$numero = $Q2->num_rows();
							//echo "------".$numero."------";
							//echo $this->db->last_query();
							if($numero==0){
								$Q2->free_result();
								$nuovaweeks = $weeks % 2;
								//echo "........".$nuovaweeks.".......";
								$query2 = "SELECT exc_id, exc_excursion, exc_type, exc_weeks FROM plused_exc_all WHERE exc_type = 'planned' AND exc_weeks = ".$nuovaweeks." AND exc_id_centro = ".$row["id_centro"]." ORDER BY exc_weeks";
								$Q2=$this->db->query($query2);
							}
							if ($Q2->num_rows() > 0){
								foreach ($Q2->result_array() as $row2){
									$dataexc=array();
									$row["exc_id"] = $row2["exc_id"];
									$row["exc_excursion"] = $row2["exc_excursion"];
									$row["exc_type"] = $row2["exc_type"];
									$dataexc = array(
									  'exb_id_year' => $row["id_year"],
									  'exb_id_book' => $row["id_book"],
									  'exb_campus_id' => $row["id_centro"],
									  'exb_tot_pax' => $row["tot_pax"],
									  'exb_id_excursion' => $row["exc_id"],
									  'exb_type' => $row["exc_type"]
									);
									//print_r($row);
									//print_r($dataexc);

									$this->db->insert('plused_exc_bookings', $dataexc);
								}
							}
							$Q2->free_result();
							//echo "</pre>";
						}
				}
			}
			$Q->free_result();
			echo "insert terminato";
			die();
}

function viewCmConfirmedTransfers($campus=0,$company=0){
	$data=array();
	if($company > 0){
			if($campus > 0){
				$querybk = "SELECT SUM(pbe_jnprice) as totalone, pbe_rndcode,tra_cp_name,pbe_excdate,ptt_type,ptt_airport_from,ptt_airport_to,nome_centri FROM plused_bus_exc, plused_tra_companies, plused_tra_bus, plused_tra_transfers, centri WHERE ptt_campus_id = id AND pbe_cm_ok > 0 AND pbe_op_ok = 0 AND pbe_jnidbus = tra_bus_id AND tra_bus_cp_id = tra_cp_id AND tra_cp_id = $company AND ptt_campus_id = $campus AND ptt_buscompany_code = pbe_rndcode GROUP BY pbe_rndcode ORDER BY pbe_excdate";
			}else{
				$querybk = "SELECT SUM(pbe_jnprice) as totalone, pbe_rndcode,tra_cp_name,pbe_excdate,ptt_type,ptt_airport_from,ptt_airport_to,nome_centri FROM plused_bus_exc, plused_tra_companies, plused_tra_bus, plused_tra_transfers,centri WHERE ptt_campus_id = id AND pbe_cm_ok > 0 AND pbe_op_ok = 0 AND pbe_jnidbus = tra_bus_id AND tra_bus_cp_id = tra_cp_id AND tra_cp_id = $company AND ptt_buscompany_code = pbe_rndcode GROUP BY pbe_rndcode ORDER BY pbe_excdate";
			}
	}else{
			if($campus > 0){
				$querybk = "SELECT SUM(pbe_jnprice) as totalone, pbe_rndcode,tra_cp_name,pbe_excdate,ptt_type,ptt_airport_from,ptt_airport_to,nome_centri FROM plused_bus_exc, plused_tra_companies, plused_tra_bus, plused_tra_transfers,centri WHERE ptt_campus_id = id AND pbe_cm_ok > 0 AND pbe_op_ok = 0 AND pbe_jnidbus = tra_bus_id AND tra_bus_cp_id = tra_cp_id AND ptt_campus_id = $campus AND ptt_buscompany_code = pbe_rndcode GROUP BY pbe_rndcode ORDER BY pbe_excdate";
			}else{
				$querybk = "SELECT SUM(pbe_jnprice) as totalone, pbe_rndcode,tra_cp_name,pbe_excdate,ptt_type,ptt_airport_from,ptt_airport_to,nome_centri FROM plused_bus_exc, plused_tra_companies, plused_tra_bus, plused_tra_transfers,centri WHERE ptt_campus_id = id AND pbe_cm_ok > 0 AND pbe_op_ok = 0 AND pbe_jnidbus = tra_bus_id AND tra_bus_cp_id = tra_cp_id AND ptt_buscompany_code = pbe_rndcode GROUP BY pbe_rndcode ORDER BY pbe_excdate";
			}
	}
	$Q2=$this->db->query($querybk);
	if ($Q2->num_rows() > 0){
        foreach ($Q2->result_array() as $row){
            $data[] = $row;
        }
    }
	/*
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	*/
	return $data;
}

function excursionById($id){
     $this->db->where('exc_id',$id);
              $Q = $this->db->get('plused_exc_all');
              if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data = $row;
                }
            }
            $Q->free_result();
            return $data;
}

function bkgDetailsForExcursion($arr_key){
	$data=array();
	foreach($arr_key as $key=>$value){
		$querybk = "SELECT exb_id_book, exb_id_year, arrival_date, departure_date, agenti.businessname, agenti.businesscountry, tot_pax, exb_id FROM plused_exc_bookings, plused_book, agenti WHERE plused_book.id_book = exb_id_book AND exb_id = ".$value." AND plused_book.id_agente = agenti.id";
		$Q2=$this->db->query($querybk);
        if ($Q2->num_rows() > 0){
            foreach ($Q2->result_array() as $row){
                $data[] = $row;
            }
        }
	}
	return $data;
}

function getOtherExcursions($excId,$campusId,$from,$to){
	$data=array();
	$querybk = "SELECT exb_buscompany_code, exb_excursion_date, SUM(exb_tot_pax) as all_tot_pax FROM plused_exc_bookings WHERE exb_id_excursion = ".$excId." AND exb_campus_id = ".$campusId." AND exb_excursion_date <= '".$to."' AND exb_excursion_date >= '".$from."' AND exb_buscompany_code <> '' AND exb_confirmed = 'STANDBY' GROUP BY exb_buscompany_code";
	//echo $querybk;
	$Q2=$this->db->query($querybk);
    if ($Q2->num_rows() > 0){
        foreach ($Q2->result_array() as $row){
            $data[] = $row;
        }
    }
	return $data;
}


function bkgDetailsForTransfer($arr_key){
	$data=array();
	foreach($arr_key as $key=>$value){
		$bkgexploded = array();
		$querybk = "SELECT ptt_book_id, ptt_dataora, ptt_airport_from, ptt_airport_to, ptt_flight, ptt_tot_pax, ptt_id, ptt_type FROM plused_tra_transfers WHERE ptt_id = ".$value; //." AND plused_book.id_agente = agenti.id";
		$Q2=$this->db->query($querybk);
        if ($Q2->num_rows() > 0){
            foreach ($Q2->result_array() as $row){
				$bkgexploded = explode("_",$row["ptt_book_id"]);
				$idAgente = $this->agentIdByBkIdYear($bkgexploded[0],$bkgexploded[1]);
				$row["businessname"] = $this->agentNameById($idAgente);
				$row["businesscountry"] = $this->agentCountryById($idAgente);
				$this->db->where('pttr_trid', $row["ptt_id"]);
				$this->db->from('plused_tra_transfers_rows');
				$row["realpax"] = $this->db->count_all_results();
                $data[] = $row;
            }
        }
	}
	return $data;
}

function bkgDetailsForAllExcursions($arr_key){
	$data=array();
	foreach($arr_key as $key=>$value){
		$bkgexploded = array();
		$querybk = "SELECT pte_book_id, pte_excursion_date, pte_tot_pax, pte_id, pte_type, arrival_date, departure_date FROM plused_tra_excursions, plused_book WHERE CONCAT(id_year,'_',id_book) = pte_book_id AND pte_id = ".$value;
		$Q2=$this->db->query($querybk);
        if ($Q2->num_rows() > 0){
            foreach ($Q2->result_array() as $row){
				$bkgexploded = explode("_",$row["pte_book_id"]);
				$idAgente = $this->agentIdByBkIdYear($bkgexploded[0],$bkgexploded[1]);
				$row["businessname"] = $this->agentNameById($idAgente);
				$row["businesscountry"] = $this->agentCountryById($idAgente);
				$this->db->where('pter_trid', $row["pte_id"]);
				$this->db->from('plused_tra_excursions_rows');
				$row["realpax"] = $this->db->count_all_results();
                $data[] = $row;
            }
        }
	}
	return $data;
}

function busListForExcursion($exc_id){
	$data=array();
	$querybk = "SELECT jn_id, jn_id_bus, jn_price, cur_codice as jn_currency, tra_cp_name, tra_bus_name, tra_bus_seat FROM plused_tb_currency, plused_exc_join, plused_tra_companies, plused_tra_bus WHERE jn_currency = cur_id AND jn_id_bus = tra_bus_id AND tra_bus_cp_id = tra_cp_id AND jn_id_exc = ".$exc_id;
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}

function totalBusList(){
	$data=array();
	$querybk = "SELECT tra_bus_id, tra_cp_name, tra_bus_name, tra_bus_seat FROM plused_tra_companies, plused_tra_bus WHERE tra_bus_cp_id = tra_cp_id ORDER BY tra_cp_name, tra_bus_seat";
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}

function busListForTransfers($campusId,$airport,$type){
	$tipo = "in";
	if($type=="outbound")
		$tipo = "out";
	$data=array();
	$querybk = "SELECT exc_excursion, exc_airport, jn_id_bus, jn_price, cur_codice as jn_currency, tra_cp_name, tra_bus_name, tra_bus_seat, exc_id FROM plused_exc_join, plused_tra_companies, plused_tra_bus, plused_exc_all, plused_tb_currency WHERE (exc_transfer_type = 'both' OR exc_transfer_type = '".$tipo."') AND cur_id = jn_currency AND exc_type = 'transfer' AND exc_id = jn_id_exc AND jn_id_bus = tra_bus_id AND tra_bus_cp_id = tra_cp_id AND exc_airport = '".$airport."' AND exc_id_centro = ".$campusId;
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}

function busCode(){
	$length = 10;
	$string = '';
	$index = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	for ($i=0; $i < $length; $i++) {
		$string .= $index[rand(0, strlen($index) -1)];
	}
	return $string;
}

function standbyCodeExcursion($busCode,$vnum,$excDate){
	$qUpdNum = "UPDATE plused_exc_bookings SET exb_buscompany_code = '".$busCode."', exb_confirmed = 'STANDBY', exb_excursion_date = '".$excDate."' WHERE exb_id = $vnum";
	//echo $qUpdNum;
	$Q=$this->db->query($qUpdNum);
	return true;
}

function standbyTransferExcursion($busCode,$vnum,$excDate){
	$qUpdNum = "UPDATE plused_tra_transfers SET ptt_buscompany_code = '".$busCode."', ptt_confirmed = 'STANDBY' WHERE ptt_id = $vnum";
	//echo $qUpdNum;
	$Q=$this->db->query($qUpdNum);
	return true;
}

function standbyCodeAllExcursions($busCode,$vnum,$excDate){
	$qUpdNum = "UPDATE plused_tra_excursions SET pte_buscompany_code = '".$busCode."', pte_confirmed = 'STANDBY', pte_excursion_date = '".$excDate."' WHERE pte_id = $vnum";
	//echo $qUpdNum;
	$Q=$this->db->query($qUpdNum);
	return true;
}

function setExcReview($busCode){
	$flagServiceDone = $this->input->xss_clean($this->input->post('cm_service_completed'));
	$flagCmKo = $this->input->xss_clean($this->input->post('cm_bus_not_compliant'));
	$notesCm = $this->input->xss_clean($this->input->post('cm_exc_notes'));
	$qUpdNum = "UPDATE plused_bus_exc SET pbe_cm_notes = '".str_replace("'","''",$notesCm)."', pbe_cm_ok = ".$flagCmKo.", pbe_cm_done = ".$flagServiceDone." WHERE pbe_rndcode = '".$busCode."'";
	//echo $qUpdNum;
	$Q=$this->db->query($qUpdNum);
	return true;
}

function addBusTab($numIdBus,$qtyBus,$excDate,$busCode){
	$strCostoBus = "cost_".$numIdBus;
	$strCurrencyBus = "currency_".$numIdBus;
	$data = array(
		  'pbe_jnidbus' => $numIdBus,
		  'pbe_rndcode' => $busCode,
		  'pbe_qtybus' => $qtyBus,
		  'pbe_jnidexc' => $this->input->xss_clean($this->input->post('id_exc_join')),
		  'pbe_jnprice' => $this->input->xss_clean($this->input->post($strCostoBus)),
		  'pbe_jncurrency' => $this->input->xss_clean($this->input->post($strCurrencyBus)),
		  'pbe_excdate' => $excDate,
		  'pbe_hpickup' => $this->input->xss_clean($this->input->post('pickup_time')),
		  'pbe_hreturn' => $this->input->xss_clean($this->input->post('return_hour')),
		  'pbe_pickupplace' => $this->input->xss_clean($this->input->post('pickup_place'))
    );
	//print_r($data);
	$this->db->insert('plused_bus_exc', $data);
}

function remBusTab($busCode){
	$this->db->where('pbe_rndcode', $busCode);
	$this->db->delete('plused_bus_exc');
	return true;
}


function busDetailForExcursion($busCode){
	$data=array();
	$querybk = "SELECT pbe_jnidbus, pbe_jnprice, pbe_jncurrency, pbe_qtybus, tra_cp_name, tra_bus_name, tra_bus_seat, tra_cp_id, tra_cp_phone FROM plused_tra_companies, plused_tra_bus, plused_bus_exc WHERE tra_bus_cp_id = tra_cp_id AND pbe_rndcode = '".$busCode."' AND pbe_jnidbus = tra_bus_id";
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}

function busSeatsForExcursion($busCode){
	$totSeats = 0;
	$querybk = "SELECT pbe_qtybus, tra_bus_seat FROM plused_tra_bus, plused_bus_exc WHERE pbe_rndcode = '".$busCode."' AND pbe_jnidbus = tra_bus_id";
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $totSeats = $totSeats + ($row["pbe_qtybus"]*$row["tra_bus_seat"]);
        }
    }
    $Q->free_result();
    return $totSeats;
}

function retrieveTraOk($traDate, $flightN, $nPax){
	$data=array();
	$querybk = "SELECT COUNT(pttr_id) as postiOccupati, ptt_buscompany_code, ptt_confirmed, nome_centri as oldName FROM centri, plused_tra_transfers, plused_bus_exc, plused_tra_bus, plused_tra_transfers_rows WHERE ptt_campus_id = centri.id AND pttr_trid = ptt_id AND ptt_buscompany_code = pbe_rndcode AND ptt_excursion_date = '".$traDate."' AND ptt_confirmed <> 'NO' AND ptt_flight = '".$flightN."' AND tra_bus_id =  pbe_jnidbus";
	$Q=$this->db->query($querybk);
    //echo $this->db->last_query();
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
			$postiBus = $this->busSeatsForExcursion($row["ptt_buscompany_code"]);
			$row["postiBus"] = $postiBus;
			$row["nPax"] = $nPax;
            //print_r($row);
			$postiLiberi = $row["postiBus"]*1 - $row["postiOccupati"]*1;
			if($postiLiberi >= $nPax){
				$data[] = $row;
			}
        }
    }
    $Q->free_result();
	//print_r($data);
	return $data;
}

function excDetail($busCode){
	$data=array();
	$querybk = "SELECT DISTINCT pbe_jnidexc, pbe_excdate, pbe_hpickup, pbe_hreturn, pbe_pickupplace, exc_excursion, exc_type, exc_length, nome_centri, pbe_cm_ok, pbe_cm_notes, pbe_cm_done, exc_id_centro FROM plused_bus_exc, plused_exc_all, centri WHERE pbe_rndcode = '".$busCode."' AND pbe_jnidexc = exc_id AND exc_id_centro = centri.id";
	$Q=$this->db->query($querybk);
	//echo $this->db->last_query();
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}

function getExcIdsFromBusCode($busCode){
	$data = array();
	$this->db->select('exb_id');
	$this->db->where('exb_buscompany_code',$busCode);
    $Q = $this->db->get('plused_exc_bookings');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row["exb_id"];
		}
    }
    $Q->free_result();
    return $data;
}

function getTraIdsFromBusCode($busCode){
	$data = array();
	$this->db->select('ptt_id');
	$this->db->where('ptt_buscompany_code',$busCode);
    $Q = $this->db->get('plused_tra_transfers');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row["ptt_id"];
		}
    }
    $Q->free_result();
    return $data;
}

function getAllExcIdsFromBusCode($busCode){
	$data = array();
	$this->db->select('pte_id');
	$this->db->where('pte_buscompany_code',$busCode);
    $Q = $this->db->get('plused_tra_excursions');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row["pte_id"];
		}
    }
    $Q->free_result();
    return $data;
}

function getExcPaxForBusCode($busCode){
	$querybk = "SELECT SUM(exb_tot_pax) as allpax FROM plused_exc_bookings WHERE exb_buscompany_code = '$busCode' GROUP BY exb_buscompany_code";
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row["allpax"];
        }
    }
    $Q->free_result();
    return $data;
}

function getIsModifiedForBusCode($busCode){
	$querybk = "SELECT exb_modified FROM plused_exc_bookings WHERE exb_buscompany_code = '$busCode' GROUP BY exb_buscompany_code ORDER BY exb_modified DESC LIMIT 0,1";
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row["exb_modified"];
        }
    }
    $Q->free_result();
    return $data;
}

function getTraPaxForBusCode($busCode){
	$querybk = "SELECT SUM(ptt_tot_pax) as allpax FROM plused_tra_transfers WHERE ptt_buscompany_code = '$busCode' GROUP BY ptt_buscompany_code";
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row["allpax"];
        }
    }
    $Q->free_result();
    return $data;
}

function getAllExcPaxForBusCode($busCode){
	$querybk = "SELECT SUM(pte_tot_pax) as allpax FROM plused_tra_excursions WHERE pte_buscompany_code = '$busCode' GROUP BY pte_buscompany_code";
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row["allpax"];
        }
    }
    $Q->free_result();
    return $data;
}

function getTraRealPaxForBusCode($busCode){
	$querybk = "SELECT COUNT(pttr_id) as effettivi FROM plused_tra_transfers, plused_tra_transfers_rows WHERE pttr_trid = ptt_id AND ptt_buscompany_code = '$busCode'";
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row["effettivi"];
        }
    }
    $Q->free_result();
    return $data;
}

function getAllExcRealPaxForBusCode($busCode){
	$querybk = "SELECT COUNT(pter_id) as effettivi FROM plused_tra_excursions, plused_tra_excursions_rows WHERE pter_trid = pte_id AND pte_buscompany_code = '$busCode'";
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row["effettivi"];
        }
    }
    $Q->free_result();
    return $data;
}


function busExcReset($busCode){
	$qCopyNum = "SELECT pbe_rndcode, CONCAT('From ',exc_centro,' to ',exc_excursion,' - ',exc_length,' || ',exc_type) as canExc, CONCAT(pbe_qtybus,' - ',tra_cp_name,' ',tra_bus_name) as canBus, CONCAT(pbe_jnprice,' ',pbe_jncurrency) as canPrice, pbe_excdate FROM plused_exc_all, plused_bus_exc, plused_tra_bus, plused_tra_companies WHERE pbe_jnidbus = tra_bus_id AND tra_bus_cp_id = tra_cp_id AND pbe_rndcode = '".$busCode."' AND exc_id = pbe_jnidexc";
	$Q=$this->db->query($qCopyNum);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
				$data = array(
					  'pcb_rndcode' => $row["pbe_rndcode"],
					  'pcb_excursion' => $row["canExc"],
					  'pcb_bus' => $row["canBus"],
					  'pcb_price' => $row["canPrice"],
					  'pcb_exc_date' => $row["pbe_excdate"],
					  'pcb_can_date' => date("Y-m-d"),
					  'pcb_can_user' => $this->session->userdata('email')
				);
				$this->db->insert('plused_canceled_bus', $data);
		}
    }
	//INVIO MAIL PER CANCELED BUS
			$a_email = "smarra@plus-ed.com";
			$cc_email = "campus@plus-ed.com, l.pombo@plus-ed.com, e.bettoni@plus-ed.com";
			$bcc_email = "a.sudetti@gmail.com";
			$this->load->library('email');
			$mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
			$mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
			$mymessage .=   "<strong>  Please pay your attention to the transportation for planned excursion with bus code ".$busCode." that has been removed now! </strong><br/><br/><br />";
			$mymessage .=   "<strong>Plus Sales Office</strong>" ."<br/><br/>";
			$mymessage .=   "</body></html>";

			$this->email->from('info@plus-ed.com', 'Plus Sales Office');
			$this->email->to($a_email);
			$this->email->cc($cc_email);
			$this->email->bcc($bcc_email);
			$this->email->subject('Plus Sales Office - Planned excursion: '.$busCode.' canceled now.');
			$this->email->message($mymessage);
			$this->email->send();
	//FINE INVO MAIL PER CANCELED BUS
	$qUpdNum = "UPDATE plused_exc_bookings SET exb_buscompany_code = '', exb_confirmed = 'NO', exb_excursion_date = '0000-00-00', exb_modified = 0 WHERE exb_buscompany_code = '".$busCode."'";
	$Q=$this->db->query($qUpdNum);
	//echo $qUpdNum."<br>";
	$qDelNum = "DELETE FROM plused_bus_exc WHERE pbe_rndcode = '".$busCode."'";
	$Q=$this->db->query($qDelNum);
	//echo $qDelNum;
	//die();
	return true;
}

function addGroupToBusCode($busCode,$exbId,$excDate){
	$qUpdNum = "UPDATE plused_exc_bookings SET exb_buscompany_code = '".$busCode."', exb_confirmed = 'STANDBY', exb_excursion_date = '".$excDate."' WHERE exb_id = ".$exbId;
	$Q=$this->db->query($qUpdNum);
	$qUPDCode = "UPDATE plused_exc_bookings SET exb_confirmed = 'STANDBY', exb_modified = 1 WHERE exb_buscompany_code = '".$busCode."'";
	$Q=$this->db->query($qUPDCode);
	return true;
}

function busTraReset($busCode){
	$data = array();
	$this->db->select('ptt_id');
	$this->db->where('ptt_buscompany_code',$busCode);
    $Q = $this->db->get('plused_tra_transfers');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
				$qDelRighe = "DELETE FROM plused_tra_transfers_rows WHERE pttr_trid = ".$row["ptt_id"];
				$Q2=$this->db->query($qDelRighe);
				$qDelTesta = "DELETE FROM plused_tra_transfers WHERE ptt_id = ".$row["ptt_id"];
				$Q3=$this->db->query($qDelTesta);
		}
    }
	$qDelNum = "DELETE FROM plused_bus_exc WHERE pbe_rndcode = '".$busCode."'";
	$Q4=$this->db->query($qDelNum);
	return true;
}

function busAllExcReset($busCode){
	$qCopyNum = "SELECT pbe_rndcode, CONCAT('From ',exc_centro,' to ',exc_excursion,' - ',exc_length,' || ',exc_type) as canExc, CONCAT(pbe_qtybus,' - ',tra_cp_name,' ',tra_bus_name) as canBus, CONCAT(pbe_jnprice,' ',pbe_jncurrency) as canPrice, pbe_excdate FROM plused_exc_all, plused_bus_exc, plused_tra_bus, plused_tra_companies WHERE pbe_jnidbus = tra_bus_id AND tra_bus_cp_id = tra_cp_id AND pbe_rndcode = '".$busCode."' AND exc_id = pbe_jnidexc";
	$Q=$this->db->query($qCopyNum);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
				$data = array(
					  'pcb_rndcode' => $row["pbe_rndcode"],
					  'pcb_excursion' => $row["canExc"],
					  'pcb_bus' => $row["canBus"],
					  'pcb_price' => $row["canPrice"],
					  'pcb_exc_date' => $row["pbe_excdate"],
					  'pcb_can_date' => date("Y-m-d"),
					  'pcb_can_user' => $this->session->userdata('email')
				);
				$this->db->insert('plused_canceled_bus', $data);
		}
    }
	//INVIO MAIL PER CANCELED BUS
			$a_email = "smarra@plus-ed.com";
			$cc_email = "campus@plus-ed.com, l.pombo@plus-ed.com, dos@plus-ed.com, e.bettoni@plus-ed.com";
			$bcc_email = "a.sudetti@gmail.com";
			$this->load->library('email');
			$mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
			$mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
			$mymessage .=   "<strong>  Please pay your attention to the transportation for extra excursion with bus code ".$busCode." that has been removed now! </strong><br/><br/><br />";
			$mymessage .=   "<strong>Plus Sales Office</strong>" ."<br/><br/>";
			$mymessage .=   "</body></html>";

			$this->email->from('info@plus-ed.com', 'Plus Sales Office');
			$this->email->to($a_email);
			$this->email->cc($cc_email);
			$this->email->bcc($bcc_email);
			$this->email->subject('Plus Sales Office - Extra excursion: '.$busCode.' canceled now.');
			$this->email->message($mymessage);
			$this->email->send();
	//FINE INVO MAIL PER CANCELED BUS
	$qUpdNum = "UPDATE plused_tra_excursions SET pte_buscompany_code = '', pte_confirmed = 'NO', pte_excursion_date = '0000-00-00' WHERE pte_buscompany_code = '".$busCode."'";
	$Q=$this->db->query($qUpdNum);
	//echo $qUpdNum."<br>";
	$qDelNum = "DELETE FROM plused_bus_exc WHERE pbe_rndcode = '".$busCode."'";
	$Q=$this->db->query($qDelNum);
	return true;
}

function busExcConfirm($busCode){
	$qUpdNum = "UPDATE plused_exc_bookings SET exb_confirmed = 'YES' WHERE exb_buscompany_code = '".$busCode."'";
	$Q=$this->db->query($qUpdNum);
	return true;
}

function busTraConfirm($busCode){
	$qUpdNum = "UPDATE plused_tra_transfers SET ptt_confirmed = 'YES' WHERE ptt_buscompany_code = '".$busCode."'";
	$Q=$this->db->query($qUpdNum);
	return true;
}

function busAllExcConfirm($busCode){
	$qUpdNum = "UPDATE plused_tra_excursions SET pte_confirmed = 'YES' WHERE pte_buscompany_code = '".$busCode."'";
	$Q=$this->db->query($qUpdNum);
	return true;
}

function getExcStatusByBusCode($busCode){
	$data = array();
	$this->db->select('exb_confirmed');
	$this->db->distinct();
	$this->db->where('exb_buscompany_code',$busCode);
    $Q = $this->db->get('plused_exc_bookings');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row["exb_confirmed"];
		}
    }
    $Q->free_result();
    return $data;
}

function getTraStatusByBusCode($busCode){
	$data = array();
	$this->db->select('ptt_confirmed');
	$this->db->distinct();
	$this->db->where('ptt_buscompany_code',$busCode);
    $Q = $this->db->get('plused_tra_transfers');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row["ptt_confirmed"];
		}
    }
    $Q->free_result();
    return $data;
}

function getAllExcStatusByBusCode($busCode){
	$data = array();
	$this->db->select('pte_confirmed');
	$this->db->distinct();
	$this->db->where('pte_buscompany_code',$busCode);
    $Q = $this->db->get('plused_tra_excursions');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row["pte_confirmed"];
		}
    }
    $Q->free_result();
    return $data;
}

function getTraTypeByBusCode($busCode){
	$this->db->select('ptt_type');
	$this->db->distinct();
	$this->db->where('ptt_buscompany_code',$busCode);
    $Q = $this->db->get('plused_tra_transfers');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row["ptt_type"];
		}
    }
    $Q->free_result();
    return $data;
}

function getAllExcTypeByBusCode($busCode){
	$this->db->select('pte_type');
	$this->db->distinct();
	$this->db->where('pte_buscompany_code',$busCode);
    $Q = $this->db->get('plused_tra_excursions');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row["pte_type"];
		}
    }
    $Q->free_result();
    return $data;
}

function companyById($id){
     $this->db->where('tra_cp_id',$id);
              $Q = $this->db->get('plused_tra_companies');
              if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data = $row;
                }
            }
            $Q->free_result();
            return $data;
}

function busById($id){
     $this->db->where('tra_bus_id',$id);
              $Q = $this->db->get('plused_tra_bus');
              if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                        $data = $row;
                }
            }
            $Q->free_result();
            return $data;
}

function busByCompanyId($id){
	$data = array();
    $this->db->where('tra_bus_cp_id',$id);
	$this->db->orderby('tra_bus_seat','asc');
    $Q = $this->db->get('plused_tra_bus');
             if ($Q->num_rows() > 0){
               foreach ($Q->result_array() as $row){
                       $data[] = $row;
               }
           }
           $Q->free_result();
           return $data;
}

function traExcursionExists($id){
                $this->db->where('exb_buscompany_code',$id);
                $Q = $this->db->from('plused_exc_bookings');
				return $this->db->count_all_results();
}

function traTransferExists($id){
                $this->db->where('ptt_buscompany_code',$id);
                $Q = $this->db->from('plused_tra_transfers');
				return $this->db->count_all_results();
}

function traExtraExists($id){
                $this->db->where('pte_buscompany_code',$id);
                $Q = $this->db->from('plused_tra_excursions');
				return $this->db->count_all_results();
}

function importStudyCSV(){
	//echo "importo";
	$seldb="TRUNCATE TABLE plused_studytours_rows_import";
	$Q=$this->db->query($seldb);
	$row=0;
	$errori_riga = array();
	if (($handle = fopen("/var/www/html/www.plus-ed.com/export_pax/prova_import.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$num = count($data);
			$row++;
			$cod_vision_array=explode("_",trim($data[15]));
			//echo "<br>$row-->".count($cod_vision_array);
			if(count($cod_vision_array)==2){
				$zeros = "";
				$id_year = $cod_vision_array[0];
				$id_book = $cod_vision_array[1];
				$idCentro = $this->campusIdByBookingId($id_book);
				$inTurnoVision = $this->dataTurnoByBookingId($id_book,"in");
				$outTurnoVision = $this->dataTurnoByBookingId($id_book,"out");
				$uuid=trim($data[0]);
				$l_uuid = strlen($uuid);
				$rr = 12-$l_uuid;
				for($ar=0;$ar<$rr;$ar++){
					$zeros .= "0";
				}
				$uuidzeros = $zeros.$uuid;
				//echo $uuidzeros;
				$cognome=ucwords(strtolower(str_replace("'","''",trim($data[2]))));
				$nome=ucwords(strtolower(str_replace("'","''",trim($data[3]))));
				$sesso=trim($data[4]);
				$salute=str_replace("'","''",trim($data[5]));
				$numero_documento=trim($data[7]);
				$tipo_pax=trim($data[13]);
				$gl_rif=str_replace("'","''",trim($data[16]));
				$share_room=str_replace("'","''",trim($data[28]));
				$pax_dob=trim($data[29]);
				$accomodation=trim($data[30]);
				switch ($accomodation) {
					case "College":
						$acco_ok = "standard";
						break;
					case "Famiglia":
						$acco_ok = "homestay";
						break;
					case "Ensuite":
						$acco_ok = "ensuite";
						break;
				}
				$andata_data_arrivo=trim($data[18]);
				$andata_apt_partenza=trim($data[19]);
				$andata_apt_arrivo=trim($data[20]);
				$andata_volo=trim($data[21]);
				$ritorno_data_partenza=trim($data[22]);
				$ritorno_apt_partenza=trim($data[24]);
				$ritorno_apt_arrivo=trim($data[25]);
				$ritorno_volo=trim($data[26]);
				$destinazione=str_replace("'","''",trim($data[27]));
				$voloIn = $andata_data_arrivo;
				$voloOut = $ritorno_data_partenza;
				$inTurno = $voloIn;
				$outTurno = $voloOut;
				if($voloIn==""){
					$voloIn = $inTurnoVision;
					$inTurno = $inTurnoVision;
				}
				if($voloOut==""){
					$voloOut = $outTurnoVision;
					$outTurno = $outTurnoVision;
				}

				$arrInt=explode(" ",$inTurno);
				$inTurno = $arrInt[0];
				$arrOut=explode(" ",$outTurno);
				$outTurno = $arrOut[0];

				// ACCROCCHIO DEL CAZZO DA TOGLIERE IL PROSSIMO ANNO!!! verifica sugli id dei centri per cui spostare le date di arrivo/partenza
				if($idCentro == "4"){
					if($inTurnoVision=="2014-07-11")
						$inTurno = "2014-07-13";
				}
				if($idCentro == "20"){
					if($inTurnoVision=="2014-07-08")
						$outTurno = "2014-07-19";
					if($inTurnoVision=="2014-07-22")
						$outTurno = "2014-08-02";
				}
				if($idCentro == "26"){
					if($outTurnoVision=="2014-07-28")
						$outTurno = "2014-07-26";
					if($outTurnoVision=="2014-07-14")
						$outTurno = "2014-07-12";
				}
				$insertsql = "INSERT INTO plused_studytours_rows_import (id_book, id_year, uuid, cognome, nome, sesso, salute, numero_documento, tipo_pax, gl_rif, share_room, pax_dob, andata_data_arrivo, andata_apt_partenza, andata_apt_arrivo, andata_volo, ritorno_data_partenza, ritorno_apt_partenza, ritorno_apt_arrivo, ritorno_volo, destinazione, accomodation, data_arrivo_campus, data_partenza_campus) VALUES 	(".$id_book.",".$id_year.",'".$uuidzeros."','".$cognome."','".$nome."','".$sesso."','".$salute."','".$numero_documento."','".$tipo_pax."','".$gl_rif."','".$share_room."','".$pax_dob."','".$voloIn."','".$andata_apt_partenza."','".$andata_apt_arrivo."','".$andata_volo."','".$voloOut."','".$ritorno_apt_partenza."','".$ritorno_apt_arrivo."','".$ritorno_volo."','".$destinazione."', '".$acco_ok."','".$inTurno."','".$outTurno."')";
				//echo "<br />".$insertsql;
				$Q=$this->db->query($insertsql);
				//echo "<br />".$this->db->insert_id();
			}else{
				$errori_riga[]=$row;
			}
		}
		fclose($handle);
		// FORK ANNO 2013 PER SPOSTARE LE SISTEMAZIONI COLLEGE IN ENSUITE ANZICHE' STANDARD
		// NEI COLLEGE DI DREW, LOS ANGELES, BOSTON, MIAMI AND FLORIDA, SAN FRANCISCO, FELICIAN
		// RIMUOVERE ASSOLUTAMENTE E UNIFORMARE IN DEV LE ACCOMODATION!!!
		$qupdateAccomodation = "UPDATE plused_studytours_rows_import SET accomodation = 'ensuite' WHERE (destinazione = 'Pitzer College' OR destinazione = \"Saint Mary's College of California\" OR destinazione = 'Drew University' OR destinazione = 'Miami & Florida Experience Crowne Plaza Oceanfront' OR destinazione = 'Curry College' OR destinazione = 'Felician College')";
		$QUA=$this->db->query($qupdateAccomodation);
		//echo $this->db->last_query();
		//FINE FORK
	}
	//echo "--".count($errori_riga);
	if(count($errori_riga)>0){
		print_r($errori_riga);
		die("Error import!");
	}
	return true;
}

function syncStudyPax(){
	$data=array();
	$numDev = 0;
	$numVis = 0;
	$qConcat = "SELECT COUNT( id_prenotazione ) as numero_dev , CONCAT( id_year, '_', id_book )as bkgnum , id_year, id_book FROM plused_studytours_rows_import GROUP BY CONCAT( id_year, '_', id_book )";
	$Q=$this->db->query($qConcat);
	//echo $this->db->last_query();
	if ($Q->num_rows() > 0){
		$mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
		$mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
        foreach ($Q->result_array() as $row){
			$query2 = "SELECT COUNT( id_prenotazione ) as numero_rows FROM plused_rows WHERE id_year = ".$row["id_year"]." AND id_book = ".$row["id_book"];
			$Q2=$this->db->query($query2);
			//echo $this->db->last_query();
			if ($Q2->num_rows() > 0){
				foreach ($Q2->result_array() as $row2){
					$row["numero_vision"] = $row2["numero_rows"];
				}
			}
			$Q2->free_result();
			$data[] = $row;
			$numDev += $row["numero_dev"];
			$numVis += $row["numero_vision"];
			//6 righe commentate
			$delRighe = $this->removeStudyPax($row["id_year"],$row["id_book"]);
			$newRighe = $this->readStudyPax($row["id_year"],$row["id_book"]);
			$righeTestata = count($newRighe);
			$updRighe = $this->updateTestataBook($righeTestata,$row["id_year"],$row["id_book"]);
			$updExcursions = $this->updateExcursionBookings($righeTestata,$row["id_year"],$row["id_book"]);
			$insRighe = $this->insertStudyPax($newRighe,$row["id_year"],$row["id_book"]);
			$year =  $this->yearIdByBookingId($row["id_book"]);
			if($row["numero_dev"] != $row["numero_vision"]){
				$cmpId = $this->campusIdByBookingId($row["id_book"]);
				$cmpName = $this->centerNameById($cmpId);
				$mailto = $this->getCmMailFromCampusId($cmpId);
				$mymessage .=   "<br/><br/><strong>Booking ".$year."_".$row["id_book"]." </strong><br />";
				$mymessage .=   "Roster for StudyTours booking ".$year."_".$row["id_book"]." has been changed @".$cmpName.". <br /> Old pax number:  <strong>".$row["numero_vision"]."</strong><br /> New pax number:  <strong>".$row["numero_dev"]."</strong><br />";

			}

			$statBk = $this->statusByBookingId($row["id_book"]);
			if($statBk == "elapsed" or $statBk == "rejected"){
				$mymessage .=   "<br/><br/><strong>Booking ".$year."_".$row["id_book"]." </strong><br />";
				$mymessage .=   "<strong>ATTENTION!</strong>  -  Roster updated for <strong>".$statBk."</strong> StudyTours booking ".$year."_".$row["id_book"]."<br />";
			}

			//echo "<br />---------->".$righeTestata;
        }
		$mymessage .=   "<strong>Plus Sales Office</strong>" ."<br/><br/>";
		$mymessage .=   "</body></html>";
		$this->load->library('email');
		$mailccarray = array('operations@plus-ed.com','k.klosinska@plus-ed.com','m.marra@studytours.it','c.sironi@studytours.it','v.verta@studytours.it','dos@plus-ed.com');
		$this->email->from('info@plus-ed.com', 'Plus Sales Office');
		$this->email->to('smarra@plus-ed.com');
		//$this->email->to('a.sudetti@gmail.com');
		$this->email->cc($mailccarray);
		$this->email->bcc('a.sudetti@gmail.com');
		$this->email->subject('Plus Sales Office - Roster changes for StudyTours bookings');
		$this->email->message($mymessage);
		$this->email->send();
    }
    $Q->free_result();
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	echo "<br />Dev: ".$numDev;
	echo "<br />Vis: ".$numVis;
    //die();
}

function removeStudyPax($year,$book){
	$queryDel = "DELETE FROM plused_rows WHERE (id_year = ".$year." AND id_book = ".$book.")";
	$Q=$this->db->query($queryDel);
	//echo "<br />".$queryDel;
	return true;
}

function readStudyPax($year,$book){
	$data = array();
	$this->db->where('id_year',$year);
	$this->db->where('id_book',$book);
    $Q = $this->db->get('plused_studytours_rows_import');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
			unset($row['id_prenotazione']);
            $data[] = $row;
        }
    }
    $Q->free_result();
	//print_r($data);
    return $data;
}

function updateTestataBook($pax,$year,$book){
	$queryUpd = "UPDATE plused_book SET tot_pax = ".$pax." WHERE (id_year = ".$year." AND id_book = ".$book.")";
	$Q=$this->db->query($queryUpd);
	//echo "<br />".$queryUpd;
	return true;
}

function updateExcursionBookings($pax,$year,$book){
	$queryUpd = "UPDATE plused_exc_bookings SET exb_tot_pax = ".$pax." WHERE (exb_id_year = ".$year." AND exb_id_book = ".$book.")";
	$Q=$this->db->query($queryUpd);
	//echo "<br />".$queryUpd;
	return true;
}

function insertStudyPax($nuoveRighe,$year,$book){
	foreach($nuoveRighe as $riga){
		$this->db->insert('plused_rows', $riga);
	}
	return true;
}

function checkTransfersStudy($tipo){
	$notification_text = "";
	if($tipo=="inbound"){
		$queryPT = "SELECT nome_centri, ptt_buscompany_code as buscode, CONCAT(plused_rows.id_year,'_', plused_rows.id_book) as bookid, CONCAT (cognome,' ', nome) as pax,  pttr_uuid, pttr_dataora, andata_data_arrivo, pttr_flight FROM centri, plused_rows, plused_tra_transfers_rows, plused_book, plused_tra_transfers WHERE pttr_trid = ptt_id AND pttr_uuid = uuid AND plused_book.id_book = plused_rows.id_book AND plused_book.id_agente = 795 AND andata_data_arrivo <> pttr_dataora AND centri.id = ptt_campus_id AND pttr_type = 'inbound'";
		$Q=$this->db->query($queryPT);
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$notification_text .= "<br /><br />Transfer code: <b>".$row["buscode"]."</b><br />Pax name: <b>".$row["pax"]."</b> (bookingID: <b>".$row["bookid"]."@".$row["nome_centri"]."</b>)<br />Old datetime: <b>".$row["pttr_dataora"]."</b> / New datetime: <b>".$row["andata_data_arrivo"]."</b>";
				$uuidRem = $row["pttr_uuid"];
				$queryDel = "DELETE FROM plused_tra_transfers_rows WHERE pttr_uuid = '".$uuidRem."'";
				$QDEL=$this->db->query($queryDel);
			}
		}
		$queryPT2 = "SELECT pttr_uuid, ptt_buscompany_code as buscode, pttr_dataora FROM plused_tra_transfers_rows, plused_tra_transfers WHERE pttr_type = 'inbound' AND pttr_trid = ptt_id AND pttr_uuid NOT IN (SELECT uuid FROM plused_rows)";
		$Q2=$this->db->query($queryPT2);
		if ($Q2->num_rows() > 0){
			foreach ($Q2->result_array() as $row2){
				$notification_text .= "<br /><br />Transfer code: <b>".$row2["buscode"]."</b><br />Pax canceled<br />Old datetime: <b>".$row2["pttr_dataora"]."</b> / New datetime: <b> PAX CANCELED</b>";
				$uuidRem2 = $row2["pttr_uuid"];
				$queryDel2 = "DELETE FROM plused_tra_transfers_rows WHERE pttr_uuid = '".$uuidRem2."'";
				$QDEL2=$this->db->query($queryDel2);
			}
		}

		if($notification_text!=""){
			return $notification_text;
		}
		else{
			return false;
		}
	}
	if($tipo=="outbound"){
		$queryPT = "SELECT nome_centri, ptt_buscompany_code as buscode, CONCAT(plused_rows.id_year,'_', plused_rows.id_book) as bookid, CONCAT (cognome,' ', nome) as pax,  pttr_uuid, pttr_dataora, ritorno_data_partenza, pttr_flight FROM centri, plused_rows, plused_tra_transfers_rows, plused_book, plused_tra_transfers WHERE pttr_trid = ptt_id AND pttr_uuid = uuid AND plused_book.id_book = plused_rows.id_book AND plused_book.id_agente = 795 AND ritorno_data_partenza <> pttr_dataora AND centri.id = ptt_campus_id AND pttr_type = 'outbound'";
		$Q=$this->db->query($queryPT);
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$notification_text .= "<br /><br />Transfer code: <b>".$row["buscode"]."</b><br />Pax name: <b>".$row["pax"]."</b> (bookingID: <b>".$row["bookid"]."@".$row["nome_centri"]."</b>)<br />Old datetime: <b>".$row["pttr_dataora"]."</b> / New datetime: <b>".$row["ritorno_data_partenza"]."</b>";
				$uuidRem = $row["pttr_uuid"];
				$queryDel = "DELETE FROM plused_tra_transfers_rows WHERE pttr_uuid = '".$uuidRem."'";
				$QDEL=$this->db->query($queryDel);
			}
		}
		$queryPT2 = "SELECT pttr_uuid, ptt_buscompany_code as buscode, pttr_dataora FROM plused_tra_transfers_rows, plused_tra_transfers WHERE pttr_type = 'outbound' AND pttr_trid = ptt_id AND pttr_uuid NOT IN (SELECT uuid FROM plused_rows)";
		$Q2=$this->db->query($queryPT2);
		if ($Q2->num_rows() > 0){
			foreach ($Q2->result_array() as $row2){
				$notification_text .= "<br /><br />Transfer code: <b>".$row2["buscode"]."</b><br />Pax canceled<br />Old datetime: <b>".$row2["pttr_dataora"]."</b> / New datetime: <b> PAX CANCELED</b>";
				$uuidRem2 = $row2["pttr_uuid"];
				$queryDel2 = "DELETE FROM plused_tra_transfers_rows WHERE pttr_uuid = '".$uuidRem2."'";
				$QDEL2=$this->db->query($queryDel2);
			}
		}

		if($notification_text!=""){
			return $notification_text;
		}
		else{
			return false;
		}
	}
}

function detMyPax($year,$book){
	$data = array();
	$this->db->where('id_year',$year);
	$this->db->where('id_book',$book);
	$this->db->order_by("gl_rif", "asc");
	$this->db->order_by("tipo_pax", "asc");
	$this->db->order_by("cognome", "asc");
    $Q = $this->db->get('plused_rows');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
			unset($row['uuid']);
			unset($row['id_prenotazione']);
			unset($row['destinazione']);
			unset($row['last_status']);
			$row["bookid"] = $row["id_year"]."_".$row["id_book"];
			$idAgente = $this->agentIdByBkIdYear($row["id_year"],$row["id_book"]);
			$row["businessname"] = $this->agentNameById($idAgente);
			unset($row['id_year']);
			unset($row['id_book']);
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}

function detSinglePax($id_prenotazione){
	$data = array();
	$this -> db -> select('a.*, b.plr_id')
			-> from('plused_rows as a')
			-> join('plused_pax_supplement as b', 'a.uuid=b.uuid', 'left')
			->where('id_prenotazione',$id_prenotazione);
    $Q = $this->db->get();
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}

function detMyPaxForRosterBackoffice($year,$book){
	$data = array();
	$this->db->where('id_year',$year);
	$this->db->where('id_book',$book);
	$this->db->order_by("gl_rif", "asc");
	$this->db->order_by("tipo_pax", "asc");
	$this->db->order_by("cognome", "asc");
    $Q = $this->db->get('plused_rows');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
			$row["bookid"] = $row["id_year"]."_".$row["id_book"];
			$idAgente = $this->agentIdByBkIdYear($row["id_year"],$row["id_book"]);
			$row["businessname"] = $this->agentNameById($idAgente);
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}

function listPax($book,$type="GL"){
	$data = array();
	$this->db->select('nome, cognome, sesso, pax_dob, numero_documento');
	$this->db->where('id_book',$book);
	$this->db->where('tipo_pax',$type);
	$this->db->order_by("gl_rif", "asc");
	$this->db->order_by("tipo_pax", "asc");
	$this->db->order_by("cognome", "asc");
    $Q = $this->db->get('plused_rows');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}



  function sendRosterMail($type="added", $idBook){
		$idcampus = $this->campusIdByBookingId($idBook);
		$nomeCampus  = $this->centerNameById($idcampus);
		$mailto = $this->getCmMailFromCampusId($idcampus);
		$year =  $this->yearIdByBookingId($idBook);
		$this->load->library('email');
		$mymessage = "<!DOCTYPE HTML PUBLIC =22-//W3C//DTD HTML 4.01 Transitional//EN=22 =22http://www.w3.org/TR/html4/loose.dtd=22>";
		$mymessage .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />";
		$mymessage .=   "<strong>Booking ".$year."_".$idBook." </strong><br/><br/>";
        $mymessage .=   "<strong>To Accounts Department</strong><br/>";
        $mymessage .=   "Invoice to be issued for a student ".$type ." for booking ".$year."_".$idBook." since the booking has been changed.<br /><br />";
        $mymessage .=   "<strong>To Academic Department and Operation Department</strong><br/>";
		$mymessage .=   "Roster for booking ".$year."_".$idBook." has been changed @".$nomeCampus.". Pax ".$type."<br />";
		$mymessage .=   "<strong>Plus Sales Office</strong>" ."<br/><br/>";
		$mymessage .=   "</body></html>";
		$mailccarray = array('l.pombo@plus-ed.com','k.klosinska@plus-ed.com','a.kavak@plus-ed.com','n.shabanova@plus-ed.com','l.gorman@plus-ed.com','michelle.gloster@plus-ed.com','michael.hollinshead@plus-ed.com');
		$this->email->from('info@plus-ed.com', 'Plus Sales Office');
		$this->email->to('smarra@plus-ed.com');
		$this->email->cc($mailccarray);
		$this->email->bcc('a.sudetti@gmail.com');
		$this->email->subject('Plus Sales Office - Roster changed for booking '.$year.'_'.$idBook.' @'.$nomeCampus.' - Pax '.$type);
		$this->email->message($mymessage);
		$this->email->send();
		return true;
  }


/*function getD2DBkPax($campus,$accomodation,$date,$status){
		//questa function, senza distinct, count e group by verra' buona per gli elenchi pax (campus manager...)
		$querya="SELECT plused_rows.cognome, plused_rows.nome, plused_book.id_book,plused_book.id_year, agenti.businessname, plused_book.status, centri.nome_centri as centro, plused_book.arrival_date, plused_book.departure_date FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.arrival_date <= '$date' AND plused_book.departure_date >= '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
		if($status==""){
			$querya.=" AND (plused_book.status = 'active' OR plused_book.status = 'confirmed')";
		}else{
			$querya.=" AND plused_book.status='".$status."'";
		}
		$querya.=" ORDER BY plused_book.arrival_date DESC, plused_book.id_book DESC";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[] = $row;
            }
		}
        $Q->free_result();
		return $data;
}*/

function getD2DBkArrivalPax($campus,$accomodation,$date,$status,$tipo){
		//questa function, senza distinct, count e group by verra' buona per gli elenchi pax (campus manager...)
		switch ($tipo) {
			case "arrival":
				$querya="SELECT CONCAT(plused_book.id_book,'_',plused_book.id_year) as bookid, centri.nome_centri as centro, agenti.businessname, plused_book.status, plused_rows.tipo_pax, plused_rows.accomodation, plused_rows.cognome, plused_rows.nome, plused_rows.sesso, plused_rows.pax_dob, plused_rows.salute, plused_rows.numero_documento, plused_rows.gl_rif, plused_rows.share_room, plused_rows.andata_data_arrivo, plused_rows.andata_volo, plused_rows.andata_apt_arrivo, plused_rows.andata_apt_partenza, plused_rows.ritorno_data_partenza, plused_rows.ritorno_volo, plused_rows.ritorno_apt_partenza, plused_rows.ritorno_apt_arrivo FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.arrival_date = '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
				break;
			case "departure":
				$querya="SELECT CONCAT(plused_book.id_book,'_',plused_book.id_year) as bookid, centri.nome_centri as centro, agenti.businessname, plused_book.status, plused_rows.tipo_pax, plused_rows.accomodation, plused_rows.cognome, plused_rows.nome, plused_rows.sesso, plused_rows.pax_dob, plused_rows.salute, plused_rows.numero_documento, plused_rows.gl_rif, plused_rows.share_room, plused_rows.andata_data_arrivo, plused_rows.andata_volo, plused_rows.andata_apt_arrivo, plused_rows.andata_apt_partenza, plused_rows.ritorno_data_partenza, plused_rows.ritorno_volo, plused_rows.ritorno_apt_partenza, plused_rows.ritorno_apt_arrivo FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.departure_date = '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
				break;
			default:
				$querya="SELECT CONCAT(plused_book.id_book,'_',plused_book.id_year) as bookid, centri.nome_centri as centro, agenti.businessname, plused_book.status, plused_rows.tipo_pax, plused_rows.accomodation, plused_rows.cognome, plused_rows.nome, plused_rows.sesso, plused_rows.pax_dob, plused_rows.salute, plused_rows.numero_documento, plused_rows.gl_rif, plused_rows.share_room, plused_rows.andata_data_arrivo, plused_rows.andata_volo, plused_rows.andata_apt_arrivo, plused_rows.andata_apt_partenza, plused_rows.ritorno_data_partenza, plused_rows.ritorno_volo, plused_rows.ritorno_apt_partenza, plused_rows.ritorno_apt_arrivo FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.arrival_date <= '$date' AND plused_book.departure_date > '$date' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
				break;
		}
		if($status==""){
			$querya.=" AND (plused_book.status = 'active' OR plused_book.status = 'confirmed')";
		}else{
			$querya.=" AND plused_book.status='".$status."'";
		}
		$querya.=" ORDER BY plused_book.arrival_date DESC, plused_book.id_book DESC, plused_rows.gl_rif ASC, plused_rows.tipo_pax ASC, plused_rows.cognome ASC";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[] = $row;
            }
		}
        $Q->free_result();
		return $data;
}

function setTransfers($campus="",$when,$status='confirmed'){
		$data = array();
		$dataarr = explode("/",$when);
		$whenOk = $dataarr[2]."-".$dataarr[1]."-".$dataarr[0];
		if($campus==""){
			$querya="SELECT DISTINCT CONCAT(plused_rows.id_year,'_',plused_rows.id_book) as bookid, andata_data_arrivo, andata_apt_partenza, andata_apt_arrivo, andata_volo, COUNT(id_prenotazione) as totnumpax, plused_book.status as statopre, businessname, businesscountry, plused_book.id_book, plused_book.id_year, centri.nome_centri, centri.id as idcentro, plused_rows.accomodation FROM plused_rows, plused_book, agenti, centri WHERE centri.id = plused_book.id_centro AND plused_book.id_agente = agenti.id AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND andata_data_arrivo >= '$whenOk 00:00:00' AND andata_data_arrivo <= '$whenOk 23:59:00' AND plused_book.status='".$status."' AND plused_rows.uuid NOT IN (SELECT pttr_uuid FROM plused_tra_transfers_rows WHERE pttr_type = 'inbound') GROUP BY bookid, andata_data_arrivo, andata_volo ORDER BY plused_rows.andata_data_arrivo ASC, plused_book.id_book DESC, plused_rows.gl_rif ASC, plused_rows.tipo_pax ASC, plused_rows.cognome ASC";
		}else{
			$querya="SELECT DISTINCT CONCAT(plused_rows.id_year,'_',plused_rows.id_book) as bookid, andata_data_arrivo, andata_apt_partenza, andata_apt_arrivo, andata_volo, COUNT(id_prenotazione) as totnumpax, plused_book.status as statopre, businessname, businesscountry, plused_book.id_book, plused_book.id_year, centri.nome_centri, centri.id as idcentro, plused_rows.accomodation FROM plused_rows, plused_book, agenti, centri WHERE centri.id = plused_book.id_centro AND  plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND andata_data_arrivo >= '$whenOk 00:00:00' AND andata_data_arrivo <= '$whenOk 23:59:00' AND plused_book.status='".$status."' AND plused_rows.uuid NOT IN (SELECT pttr_uuid FROM plused_tra_transfers_rows WHERE pttr_type = 'inbound') GROUP BY bookid, andata_data_arrivo, andata_volo ORDER BY plused_rows.andata_data_arrivo ASC, plused_book.id_book DESC, plused_rows.gl_rif ASC, plused_rows.tipo_pax ASC, plused_rows.cognome ASC";
		}
		$Q=$this->db->query($querya);
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$query2 = "SELECT COUNT(id_prenotazione) as tot_pax FROM plused_rows WHERE id_book = ".$row["id_book"]." AND id_year = ".$row["id_year"]." AND andata_data_arrivo = '0000-00-00 00:00:00';";
				//echo $this->db->last_query();
				$Q2=$this->db->query($query2);
				if ($Q->num_rows() > 0){
					foreach ($Q2->result_array() as $row2){
						$row["totForBook"] = $row2["tot_pax"];
						$maybeTransfers = $this->retrieveTraOk($whenOk, $row["andata_volo"], $row["totnumpax"]);
						if(count($maybeTransfers)){
							$tranOk = $maybeTransfers[0];
							//echo count($tranOk)."--".count($maybeTransfers);
							if($tranOk["postiBus"] > 0){
								$row["ptt_buscompany_code"] = $tranOk["ptt_buscompany_code"];
                                $row["oldName"] = $tranOk["oldName"];
							}else{
								$row["ptt_buscompany_code"] = "";
                                $row["oldName"] = "";
							}
						}else{
							$row["ptt_buscompany_code"] = "";
                            $row["oldName"] = "";
						}
					}
				}
                $row["id_ref_overnight"] = "";
                $row["start_end_overnight"] = "";
                $queryOver = "SELECT id_ref_overnight, start_end_overnight FROM plused_book WHERE id_book = ".$row["id_book"];
                $Qover=$this->db->query($queryOver);
                if ($Qover->num_rows() > 0){
                    foreach ($Qover->result_array() as $rowOver){
                        $row["id_ref_overnight"] = $rowOver["id_ref_overnight"];
                        $row["start_end_overnight"] = $rowOver["start_end_overnight"];
                    }
                }
                $Qover->free_result();
				$data[] = $row;
            }
		}
        $Q->free_result();
		return $data;
}

function setTransfersOut($campus="",$when,$status='confirmed'){
		$data = array();
		$dataarr = explode("/",$when);
		$whenOk = $dataarr[2]."-".$dataarr[1]."-".$dataarr[0];
		if($campus==""){
			$querya="SELECT DISTINCT CONCAT(plused_rows.id_year,'_',plused_rows.id_book) as bookid, ritorno_data_partenza, ritorno_apt_partenza, ritorno_apt_arrivo, ritorno_volo, COUNT(id_prenotazione) as totnumpax, plused_book.status as statopre, businessname, businesscountry, plused_book.id_book, plused_book.id_year, centri.nome_centri, centri.id as idcentro, plused_rows.accomodation FROM plused_rows, plused_book, agenti, centri WHERE centri.id = plused_book.id_centro AND plused_book.id_agente = agenti.id AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND ritorno_data_partenza >= '$whenOk 00:00:00' AND ritorno_data_partenza <= '$whenOk 23:59:00' AND plused_book.status='".$status."' AND plused_rows.uuid NOT IN (SELECT pttr_uuid FROM plused_tra_transfers_rows WHERE pttr_type = 'outbound') GROUP BY bookid, ritorno_data_partenza, ritorno_volo ORDER BY plused_rows.ritorno_data_partenza ASC, plused_book.id_book DESC, plused_rows.gl_rif ASC, plused_rows.tipo_pax ASC, plused_rows.cognome ASC";
		}else{
			$querya="SELECT DISTINCT CONCAT(plused_rows.id_year,'_',plused_rows.id_book) as bookid, ritorno_data_partenza, ritorno_apt_partenza, ritorno_apt_arrivo, ritorno_volo, COUNT(id_prenotazione) as totnumpax, plused_book.status as statopre, businessname, businesscountry, plused_book.id_book, plused_book.id_year, centri.nome_centri, centri.id as idcentro, plused_rows.accomodation FROM plused_rows, plused_book, agenti, centri WHERE centri.id = plused_book.id_centro AND  plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND ritorno_data_partenza >= '$whenOk 00:00:00' AND ritorno_data_partenza <= '$whenOk 23:59:00' AND plused_book.status='".$status."' AND plused_rows.uuid NOT IN (SELECT pttr_uuid FROM plused_tra_transfers_rows WHERE pttr_type = 'outbound') GROUP BY bookid, ritorno_data_partenza, ritorno_volo ORDER BY plused_rows.ritorno_data_partenza ASC, plused_book.id_book DESC, plused_rows.gl_rif ASC, plused_rows.tipo_pax ASC, plused_rows.cognome ASC";
		}
		$Q=$this->db->query($querya);
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$query2 = "SELECT COUNT(id_prenotazione) as tot_pax FROM plused_rows WHERE id_book = ".$row["id_book"]." AND id_year = ".$row["id_year"]." AND ritorno_data_partenza = '0000-00-00 00:00:00';";
				$Q2=$this->db->query($query2);
				if ($Q->num_rows() > 0){
					foreach ($Q2->result_array() as $row2){
						$row["totForBook"] = $row2["tot_pax"];
					}
				}
                $row["id_ref_overnight"] = "";
                $row["start_end_overnight"] = "";
                $queryOver = "SELECT id_ref_overnight, start_end_overnight FROM plused_book WHERE id_book = ".$row["id_book"];
                $Qover=$this->db->query($queryOver);
                if ($Qover->num_rows() > 0){
                    foreach ($Qover->result_array() as $rowOver){
                        $row["id_ref_overnight"] = $rowOver["id_ref_overnight"];
                        $row["start_end_overnight"] = $rowOver["start_end_overnight"];
                    }
                }
                $Qover->free_result();
                $data[] = $row;
            }
		}
        $Q->free_result();
		return $data;
}


function setTransfersTransport($type,$quando){
			foreach($this->input->post('transfer') as $key=>$value){
				$rigatransfer = explode("_",$value);
				$id_year = $rigatransfer[0];
				$id_book = $rigatransfer[1];
				$datetimefordb = date("Y-m-d H:i",$rigatransfer[2]);
				$air_from = $rigatransfer[3];
				$air_to = $rigatransfer[4];
				$flight = $rigatransfer[5];
				$id_campus = $rigatransfer[6];
				$my_tot_pax = $rigatransfer[7];
				$data = array(
					  'ptt_type' => $type,
					  'ptt_dataora' => $datetimefordb,
					  'ptt_campus_id' => $id_campus,
					  'ptt_airport_from' => $air_from,
					  'ptt_airport_to' => $air_to,
					  'ptt_flight' => $flight,
					  'ptt_book_id' => $id_year."_".$id_book,
					  'ptt_excursion_date' => $quando,
					  'ptt_tot_pax' => $my_tot_pax
				);
				$this->db->insert('plused_tra_transfers', $data);
				$transfer_id = $this->db->insert_id();
				$transfer_id_array[] = $transfer_id;
				//echo "<br>".$key." | ".$type."----> ".$id_year."_".$id_book." | ".$datetimefordb." | ".$air_from." | ".$air_to." | ".$flight." | ".$id_campus;
				if($type=="inbound")
					$queryprova = "SELECT uuid FROM plused_rows WHERE andata_volo = '".$flight."' AND andata_data_arrivo = '".$datetimefordb."' AND id_book = $id_book AND id_year = $id_year AND uuid NOT IN (SELECT pttr_uuid FROM plused_tra_transfers_rows WHERE pttr_type = 'inbound')";
				if($type=="outbound")
					$queryprova = "SELECT uuid FROM plused_rows WHERE ritorno_volo = '".$flight."' AND ritorno_data_partenza = '".$datetimefordb."' AND id_book = $id_book AND id_year = $id_year AND uuid NOT IN (SELECT pttr_uuid FROM plused_tra_transfers_rows WHERE pttr_type = 'outbound')";
				$Q=$this->db->query($queryprova);
				foreach ($Q->result_array() as $row){
					$datariga = array(
						'pttr_trid' => $transfer_id,
						'pttr_type' => $type,
						'pttr_uuid' => $row["uuid"],
						'pttr_dataora' => $datetimefordb,
						'pttr_airport_from' => $air_from,
						'pttr_airport_to' => $air_to,
						'pttr_flight' => $flight
					);
					$this->db->insert('plused_tra_transfers_rows', $datariga);
				}
				$Q->free_result();
			}
			return $transfer_id_array;
}

function getTraCommonDetails($busCode){
	$data = array();
	$this->db->where('ptt_buscompany_code',$busCode);
	$this->db->limit(1);
    $Q = $this->db->get('plused_tra_transfers');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}

function addPaxToExistingTransfer($busCode,$idBook,$idYear,$totPax){
	$commonDetails = $this->mbackoffice->getTraCommonDetails($busCode);
	$cd = $commonDetails[0];
	$data = array(
					'ptt_type' => "inbound",
					'ptt_dataora' => $cd["ptt_dataora"],
					'ptt_campus_id' => $cd["ptt_campus_id"],
					'ptt_airport_from' => $cd["ptt_airport_from"],
					'ptt_airport_to' => $cd["ptt_airport_to"],
					'ptt_flight' => $cd["ptt_flight"],
					'ptt_book_id' => $idYear."_".$idBook,
					'ptt_excursion_date' => $cd["ptt_excursion_date"],
					'ptt_confirmed' => $cd["ptt_confirmed"],
					'ptt_buscompany_code' => $cd["ptt_buscompany_code"],
					'ptt_tot_pax' => $totPax
	);
	$this->db->insert('plused_tra_transfers', $data);
	$idInserito = $this->db->insert_id();


	$queryprova = "SELECT uuid FROM plused_rows WHERE andata_volo = '".$cd["ptt_flight"]."' AND andata_data_arrivo = '".$cd["ptt_dataora"]."' AND id_book = ".$idBook." AND id_year = ".$idYear." AND uuid NOT IN (SELECT pttr_uuid FROM plused_tra_transfers_rows WHERE pttr_type = 'inbound')";


	$Q=$this->db->query($queryprova);
				foreach ($Q->result_array() as $row){
					$datariga = array(
						'pttr_trid' => $idInserito,
						'pttr_type' => "inbound",
						'pttr_uuid' => $row["uuid"],
						'pttr_dataora' => $cd["ptt_dataora"],
						'pttr_airport_from' => $cd["ptt_airport_from"],
						'pttr_airport_to' => $cd["ptt_airport_to"],
						'pttr_flight' => $cd["ptt_flight"]
					);
	$this->db->insert('plused_tra_transfers_rows', $datariga);
				}
	$Q->free_result();
	return true;
}

function generateUUID(){
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

function checkUUID($password){
	$this->db->where('uuid',$password);
	$this->db->from('plused_rows');
	return $this->db->count_all_results();
}

function insertUUIDRows(){
		$this->db->select('id_prenotazione');
		$this->db->where('uuid',"");
		$query = $this->db->get('plused_rows');
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$newpwd="";
				$idgiro = $row["id_prenotazione"];
				do{
					$newpwd = $this->generateUUID();
					$i = $this->checkUUID($newpwd);
				}while ($i > 0);
			$dataupd = array(
              'uuid' => $newpwd
            );

			$this->db->where('id_prenotazione', $idgiro);
			$this->db->update('plused_rows', $dataupd);
			echo "<br>".$this->db->last_query();
			}
		}
		$query->free_result();
		die();
}

function getTransfersByID($arrayTr){
	foreach($arrayTr as $singTr){
			$this->db->where('ptt_id',$singTr);
			$Q=$this->db->get('plused_tra_transfers');
			if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
					$this->db->where('pttr_trid', $singTr);
					$this->db->from('plused_tra_transfers_rows');
					$row["tot_pax"] = $this->db->count_all_results();
					$arrayBK = explode("_",$row["ptt_book_id"]);
					$idAgente = $this->agentIdByBkIdYear($arrayBK[0],$arrayBK[1]);
					$row["agency"] = $this->agentNameById($idAgente);
					$data[] = $row;
				}
			}
	}
	return $data;
}

//NUOVE FUNCTION TRANSPORTATION 2014

function otherGroupsForExc($idExc,$dateExc,$involvedBooks){
	$data=array();
	$queryProp = "SELECT id_year, id_book, businessname, businesscountry, tot_pax, arrival_date, departure_date, exb_id FROM plused_book, plused_exc_bookings, agenti WHERE id_agente = agenti.id AND exb_confirmed = 'NO' AND exb_id_book = id_book AND exb_id_excursion = ".$idExc." and exb_excursion_date = '0000-00-00' AND arrival_date < '".$dateExc."' AND departure_date > '".$dateExc."' AND plused_book.status = 'confirmed' ";
	foreach($involvedBooks as $sBook){
		$queryProp.="AND id_book <> $sBook ";
	}
	$qRows=$this->db->query($queryProp);
	//echo $this->db->last_query();
	if ($qRows->num_rows() > 0){
		foreach ($qRows->result_array() as $rowR){
			$data[] = $rowR;
		}
	}
	return $data;
}

function otherGroupsForAllExc($idCampus,$idExc,$dateExc,$involvedBooks){
	$data=array();
	$queryProp = "SELECT id_year, id_book, businessname, businesscountry, tot_pax, arrival_date, departure_date FROM plused_book, agenti WHERE id_centro = $idCampus AND id_agente = agenti.id AND arrival_date < '".$dateExc."' AND departure_date > '".$dateExc."' AND plused_book.status = 'confirmed' ";
	foreach($involvedBooks as $sBook){
		$queryProp.="AND id_book <> $sBook ";
	}
	$qRows=$this->db->query($queryProp);
	//echo $this->db->last_query();
	if ($qRows->num_rows() > 0){
		foreach ($qRows->result_array() as $rowR){
			$data[] = $rowR;
		}
	}
	return $data;
}

function otherGroupsForTransfers($tipo,$idCampus,$idExc,$dateExc,$involvedBooks){
	$data=array();
	if($tipo=="inbound"){
		$queryProp = "SELECT id_year, id_book, businessname, businesscountry, tot_pax, arrival_date, departure_date FROM plused_book, agenti WHERE id_centro = $idCampus AND id_agente = agenti.id AND arrival_date <= '".$dateExc." 23:59:00' AND arrival_date > '".$dateExc." 00:00:00' AND plused_book.status = 'confirmed' ";
	}else{
		$queryProp = "SELECT id_year, id_book, businessname, businesscountry, tot_pax, arrival_date, departure_date FROM plused_book, agenti WHERE id_centro = $idCampus AND id_agente = agenti.id AND departure_date <= '".$dateExc." 23:59:00' AND departure_date > '".$dateExc." 00:00:00' AND plused_book.status = 'confirmed' ";
	}
	foreach($involvedBooks as $sBook){
		$queryProp.="AND id_book <> $sBook ";
	}
	$qRows=$this->db->query($queryProp);
	//echo $this->db->last_query();
	if ($qRows->num_rows() > 0){
		foreach ($qRows->result_array() as $rowR){
			$data[] = $rowR;
		}
	}
	//print_r($data);
	return $data;
}


function bookExtraExcursionForGroup($excId,$bookId,$busCode,$fromCa=0,$amount=0){
	$amount = str_replace("comma",",",$amount);
	$bookingDetail = $this->get_booking_detail($bookId);
	$pte_book_id = $bookingDetail[0]["id_year"]."_".$bookingDetail[0]["id_book"];
	$pte_type = "extra";
	$pte_excursion_id = $excId;
	$pte_confirmed = "NO";
	$pte_excursion_date = "0000-00-00";
	$pte_campus_id = $this->campusIdByBookingId($bookId);
	$glNum = $this->magenti->getRowsNumByBookId($bookId,"GL");
	$stdNum = $this->magenti->getRowsNumByBookId($bookId,"STD");
	$pte_tot_pax = $glNum+$stdNum;
	$pte_proforma_num_std = $stdNum;
	$prices =$this->magenti->bestBusPriceForExcursion($excId,$pte_tot_pax,$stdNum);
	$aPrices = explode("___",$prices);
	$pte_proforma_price = $aPrices[1];
	$pte_proforma_currency = $aPrices[2];
	$data = array(
	  'pte_type' => $pte_type,
	  'pte_campus_id' => $pte_campus_id,
	  'pte_excursion_id' => $pte_excursion_id,
	  'pte_book_id' => $pte_book_id,
	  'pte_confirmed' => $pte_confirmed,
	  'pte_excursion_date' => $pte_excursion_date,
	  'pte_tot_pax' => $pte_tot_pax,
	  'pte_proforma_price' => $pte_proforma_price,
	  'pte_proforma_num_std' => $pte_proforma_num_std,
	  'pte_proforma_currency' => $pte_proforma_currency,
	  'pte_fromCampusManagerTick' => $fromCa,
	  'pte_fromCampusManagerAmount' => $amount
	);
	$this->db->insert('plused_tra_excursions', $data);
	$insertId = $this->db->insert_id();
	$uuidRighe = $this->readUUIDAgentsPax($bookingDetail[0]["id_year"],$bookingDetail[0]["id_book"]);
	//print_r($uuidRighe);
	foreach($uuidRighe as $singUID){
		$this->magenti->insertRigaExcursion($singUID,$insertId,$pte_type);
	}

}

//IMPORT PAXLIST AGENTS


function importAgentsCSV($idyearbook){
	$seldb="TRUNCATE TABLE plused_agents_rows_import";
	$Q=$this->db->query($seldb);
	$row=0;
	$errori_riga = array();

	if (($handle = fopen("/var/www/html/www.plus-ed.com/import_agents_pax/".$idyearbook.".csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$num = count($data);
			$row++;
				$id_book=trim($data[0]);
				$id_year=trim($data[1]);
				$accomodation=strtolower(trim($data[2]));
				$cognome=ucwords(strtolower(str_replace("'","''",trim($data[3]))));
				$nome=ucwords(strtolower(str_replace("'","''",trim($data[4]))));
				$sesso=trim($data[5]);
				$salute=str_replace("'","''",trim($data[6]));
				$numero_documento=trim($data[7]);
				$tipo_pax=strtoupper(trim($data[8]));
				$gl_rif=str_replace("'","''",trim($data[9]));
				$share_room=str_replace("'","''",trim($data[10]));
				$pax_dob=trim($data[11]);
				$andata_data_arrivo=trim($data[12]);
				$andata_apt_partenza=trim($data[13]);
				$andata_apt_arrivo=trim($data[14]);
				$andata_volo=trim($data[15]);
				$ritorno_data_partenza=trim($data[16]);
				$ritorno_apt_partenza=trim($data[17]);
				$ritorno_apt_arrivo=trim($data[18]);
				$ritorno_volo=trim($data[19]);
				$insertsql = "INSERT INTO plused_agents_rows_import (id_book, id_year, accomodation, cognome, nome, sesso, salute, numero_documento, tipo_pax, gl_rif, share_room, pax_dob, andata_data_arrivo, andata_apt_partenza, andata_apt_arrivo, andata_volo, ritorno_data_partenza, ritorno_apt_partenza, ritorno_apt_arrivo, ritorno_volo) VALUES (".$id_book.",".$id_year.",'".$accomodation."','".$cognome."','".$nome."','".$sesso."','".$salute."','".$numero_documento."','".$tipo_pax."','".$gl_rif."','".$share_room."','".$pax_dob."','".$andata_data_arrivo."','".$andata_apt_partenza."','".$andata_apt_arrivo."','".$andata_volo."','".$ritorno_data_partenza."','".$ritorno_apt_partenza."','".$ritorno_apt_arrivo."','".$ritorno_volo."')";
				$Q=$this->db->query($insertsql);
		}
		fclose($handle);
		$syncMe = $this->syncAgentsPax($idyearbook);
		if($syncMe){
			$itWorks = "OK";
		}else{
			$itWorks = "KO - ".$syncMe;
		}
		return $itWorks;
	}else{
		return false;
	}
}



function syncAgentsPax($idyearbook){
	$data=array();
	$arraybook = explode("_",$idyearbook);
	$idyear = $arraybook[0];
	$idbook = $arraybook[1];
	$queryRows = "SELECT count(*) as tot_pax, id_book, id_year, accomodation, tipo_pax FROM plused_rows where id_book = ".$idbook." and id_year = ".$idyear." GROUP BY id_book, id_year, accomodation, tipo_pax ORDER BY accomodation, tipo_pax";
	$queryImport = "SELECT count(*) as tot_pax, id_book, id_year, accomodation, tipo_pax FROM plused_agents_rows_import where id_book = ".$idbook." and id_year = ".$idyear." GROUP BY id_book, id_year, accomodation, tipo_pax ORDER BY accomodation, tipo_pax";
	$qRows=$this->db->query($queryRows);
	$qImport=$this->db->query($queryImport);
	//echo $queryRows."<br>";
	//echo $queryImport;
	if ($qRows->num_rows() > 0){
		foreach ($qRows->result_array() as $rowR){
			$dataR[] = $rowR;
		}
	}
	if ($qImport->num_rows() > 0){
		foreach ($qImport->result_array() as $rowI){
			$dataI[] = $rowI;
		}
	}
	/*
	echo "<pre>";
		print_r($dataR);
	echo "</pre>";
	echo "<pre>";
		print_r($dataI);
	echo "</pre>";
	*/
	$lR = count($dataR);
	$lI = count($dataI);

	if($lR != $lI){
		echo "Different Arrays Count<br />";
		return false;
		die();
	}

	for($c=0;$c<$lR;$c++){
		if(!($dataR[$c]["tot_pax"]==$dataI[$c]["tot_pax"] && $dataR[$c]["id_book"]==$dataI[$c]["id_book"] && $dataR[$c]["id_year"]==$dataI[$c]["id_year"] && $dataR[$c]["accomodation"]==$dataI[$c]["accomodation"] && $dataR[$c]["tipo_pax"]==$dataI[$c]["tipo_pax"])){
			echo "Different Arrays Values<br />";
			return false;
			die();
		}
	}

	$reaRighe = $this->readUUIDAgentsPax($idyear,$idbook);
	$updRigheImport = $this->updAgentsPaxImport($reaRighe);
	if(!$updRigheImport){
		echo "No Update Import<br />";
		return false;
		die();
	}
	$updRigheRows = $this->updateAgentsPaxRows($idyear,$idbook,$reaRighe);
	if(!$updRigheRows){
		echo "No Update Rows<br />";
		return false;
		die();
	}
	return true;
}

function updateAgentsPaxRows($idyear,$idbook,$arrUUID){
	$contaR = count($arrUUID);
	$contaA = 0;
	for($a=1;$a<=$contaR;$a++){
		$datiAggiorna = array();
		$datiNuovi = array();
		$this->db->where('uuid', $arrUUID[$contaA]);
		$this->db->where('id_book', $idbook);
		$this->db->where('id_year', $idyear);
		$Q=$this->db->get('plused_agents_rows_import');
		if($Q->num_rows() == 1){
			foreach ($Q->result_array() as $row){
				$datiAggiorna = $row;
			}
			$datiNuovi = array(
               'accomodation' => $datiAggiorna["accomodation"],
               'cognome' => $datiAggiorna["cognome"],
			   'nome' => $datiAggiorna["nome"],
			   'sesso' => $datiAggiorna["sesso"],
			   'salute' => $datiAggiorna["salute"],
			   'numero_documento' => $datiAggiorna["numero_documento"],
			   'tipo_pax' => $datiAggiorna["tipo_pax"],
			   'gl_rif' => $datiAggiorna["gl_rif"],
			   'share_room' => $datiAggiorna["share_room"],
			   'pax_dob' => $datiAggiorna["pax_dob"],
			   'andata_data_arrivo' => $datiAggiorna["andata_data_arrivo"],
			   'andata_apt_partenza' => $datiAggiorna["andata_apt_partenza"],
			   'andata_apt_arrivo' => $datiAggiorna["andata_apt_arrivo"],
			   'andata_volo' => $datiAggiorna["andata_volo"],
			   'ritorno_data_partenza' => $datiAggiorna["ritorno_data_partenza"],
			   'ritorno_apt_partenza' => $datiAggiorna["ritorno_apt_partenza"],
			   'ritorno_apt_arrivo' => $datiAggiorna["ritorno_apt_arrivo"],
			   'ritorno_volo' => $datiAggiorna["ritorno_volo"]
            );
			$this->db->where('uuid', $arrUUID[$contaA]);
			$this->db->where('id_book', $idbook);
			$this->db->where('id_year', $idyear);
			$this->db->update('plused_rows', $datiNuovi);
			//echo "<br />".$this->db->last_query();
			if($this->db->affected_rows() > 1){
				return false;
			}
		}else{
			return false;
		}
		$contaA++;
	}
	return true;
}



function readUUIDAgentsPax($year,$book){
	$data = array();
	$this->db->select('uuid');
	$this->db->where('id_year',$year);
	$this->db->where('id_book',$book);
	$this->db->order_by("tipo_pax", "asc");
    $Q = $this->db->get('plused_rows');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row["uuid"];
        }
    }
    $Q->free_result();
    return $data;
}

function updAgentsPaxImport($arrUUID){
	$contaA = 0;
	$contaR = count($arrUUID);
	$this->db->from('plused_agents_rows_import');
	$contaRighe = $this->db->count_all_results();
	if($contaR != $contaRighe){
		return false;
	}
	for($a=1;$a<=$contaR;$a++){
		$queryUPD = "UPDATE plused_agents_rows_import SET uuid= '".$arrUUID[$contaA]."' WHERE id_prenotazione = ".$a;
		$contaA++;
		$Q=$this->db->query($queryUPD);
	}
	return true;
}

function count_pax_uploaded($idbook){
	$this->db->where('cognome IS NOT NULL');
	$this->db->where('cognome <>','');
	$this->db->where('id_book',$idbook);
	$this->db->from('plused_rows');
	$contaCognomi = $this->db->count_all_results();
	return $contaCognomi;
}

function paxRosterLocked($idbook){
	$locked = 0;
	$this->db->select('lockPax');
	$this->db->where('id_book',$idbook);
	 $Q = $this->db->get('plused_book');
	if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $locked = $row["lockPax"];
        }
    }
    $Q->free_result();
    return $locked;
}

function getAccoByPaxId($idPax){
	$this->db->select('accomodation');
	$this->db->where('id_prenotazione',$idPax);
	$Q = $this->db->get('plused_rows');
	if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $acco = $row["accomodation"];
        }
    }
    $Q->free_result();
    return $acco;
}

function updateSinglePax($id, $bookId){
		if($id==""){
			echo "NO ID";
			die();
		}
		foreach($_POST as $fieldpre=>$value){
				if($value){
					$idpre = $id;
					$okValue=$value;
					if($fieldpre=="data_arrivo_campus" || $fieldpre =="data_partenza_campus" || $fieldpre=="pax_dob"){
						$expData = explode("/",$value);
						$okValue = $expData[2]."-".$expData[1]."-".$expData[0];
					}
					if($fieldpre=="andata_data_arrivo" || $fieldpre =="ritorno_data_partenza"){
						$expDataT = explode(" ",$value);
						$expData = explode("/",$expDataT[0]);
						$okValue = $expData[2]."-".$expData[1]."-".$expData[0];
						if($fieldpre=="andata_data_arrivo"){
							$campoOra = "ora_arrivo_volo";
						}else{
							$campoOra = "ora_partenza_volo";
						}
						$okValue .= " ".$_POST[$campoOra];
					}
					if($fieldpre=="transfer_in" || $fieldpre =="transfer_out" || $fieldpre =="visa"){
						$okValue = 1;
					}
					if($fieldpre!="ora_arrivo_volo" && $fieldpre!="ora_partenza_volo" && $fieldpre!="old_accomodation" && $fieldpre!="suppl"){
						$qstring = "UPDATE plused_rows SET ".$fieldpre." = '".mysql_real_escape_string($okValue)."' WHERE id_prenotazione = $idpre AND id_book = $bookId";
						//echo $qstring."<br>";
						$Q=$this->db->query($qstring);
					}
					if($fieldpre=="suppl" && $okValue){
						$this -> db -> select('uuid')
								-> from('plused_rows')
								-> where('id_prenotazione',$idpre);
						$result = $this -> db -> get();
						if($result -> num_rows() > 0){
							$resultArray = $result -> result_array();
							$this -> db -> select('count(*) as count')
									-> from('plused_pax_supplement')
									-> where('uuid',$resultArray[0]['uuid']);
							$result = $this -> db -> get();
							if($result -> num_rows() > 0){
								$resArr = $result -> result_array();
								if($resArr[0]['count'] > 0){
									$data = array(
										'plr_id' => $okValue
									);
									$this -> db -> where('uuid', $resultArray[0]['uuid']);
									$this -> db -> update('plused_pax_supplement', $data);
								}
								else{
									$mapArr[] = $resultArray[0]['uuid'].'-'.$okValue;
									$data = array(
										'uuid'=>$resultArray[0]['uuid'],
										'plr_id'=>$okValue
									);
									$this->db->insert('plused_pax_supplement', $data);
								}
							}
						}
					}
				}
		}
		$newAcc = $_POST["accomodation"];
		$oldAcc = $_POST["old_accomodation"];
		$costoNew = 0;
		$costoOld = 0;
		if($newAcc != $oldAcc){
			//Aggiungere un DUE negativo per la vecchia accomodation e aggiungere un DUE positivo per la nuova accomodation
				$costoNewAr = explode("___",$this->getSingleAccoPrice($newAcc,$bookId));
				$costoNew = $costoNewAr[0];
				$valutaNew = $costoNewAr[1];
				$costoOldAr = explode("___",$this->getSingleAccoPrice($oldAcc,$bookId));
				$costoOld = $costoOldAr[0];
				$valutaOld = $costoOldAr[1];
				$insertNew = $this->insertPayment($bookId,$costoNew,NULL,$valutaNew,NULL,"acq","Accomodation Change","");
				$insertOld = $this->insertPayment($bookId,$costoOld*-1,NULL,$valutaOld,NULL,"acq","Accomodation Change","");
		}
		return TRUE;
}


function getSingleAccoPrice($accomodation, $idBook){
	$bkDett = $this->get_booking_detail($idBook);
	$weeks = $this->getWeeksByDaysByBkId($idBook);
	switch($accomodation){
		case 'ensuite':
			$costosingolo=$bkDett[0]['costo_ensuite'];
		break;
		case 'standard':
			$costosingolo=$bkDett[0]['costo_standard'];
		break;
		case 'homestay':
			$costosingolo=$bkDett[0]['costo_homestay'];
		break;
		case 'twin':
			$costosingolo=$bkDett[0]['costo_twin'];
		break;
	}
	$costoriga = ($costosingolo*1)*($weeks*1);
	switch($bkDett[0]['valuta_fattura']){
		case 'GBP':
			$symbV = "£";
		break;
		case 'USD':
			$symbV = "$";
		break;
		case 'EUR':
			$symbV = "€";
		break;
	}
	return $costoriga."___".$symbV;
}


//NEW FUNCTIONS PER REVIEWDAY2DAY - TERMINATI I TEST RIMUOVERE TUTTE LE FUNCTIONS SENZA SUFFISSO _pax, IDEM DAL CONTROLLER E IDEM PER LE VIEW

function getBkCalendar_pax($campus,$accomodation,$month,$year){
	// Set timezone
	date_default_timezone_set('UTC');
	// Start date
	$date = $year.'-'.$month.'-01';
	// End date
	$end_date = date ("Y-m-d", strtotime("+1 month -1day", strtotime($date)));
	//echo $date."--".$end_date;
	$contagiri = 0;
	while (strtotime($date) <= strtotime($end_date)) {
		$backjson[] = $this->getTotAva_pax($campus,$accomodation,$date);
		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		$contagiri++;
	}
	return $backjson;
}

function ca_getBkCalendar_pax($campus,$accomodation,$month,$year){
	// Set timezone
	date_default_timezone_set('UTC');
	// Start date
	$date = $year.'-'.$month.'-01';
	// End date
	$end_date = date ("Y-m-d", strtotime("+1 month -1day", strtotime($date)));
	//echo $date."--".$end_date;
	$contagiri = 0;
	while (strtotime($date) <= strtotime($end_date)) {
		$backjson[] = $this->ca_getTotAva_pax($campus,$accomodation,$date);
		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		$contagiri++;
	}
	return $backjson;
}


function getTotAva_pax($campus,$accomodation,$date){
		$querya = "SELECT SUM(availability) as dispo FROM plused_campus_availability WHERE start_date <= '$date' AND finish_date >= '$date' AND accomodation_type = '$accomodation' AND id_campus = $campus";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["dispo"]){
					$avaok=0;
				}else{
					$avaok = $row["dispo"];
				}
				$multistatus = array("confirmed","active");
				$booked = $this->getTotBk_pax($campus,$accomodation,$date,$multistatus);
				$avarest = $avaok-$booked;
				if($avarest >= 0){
					$record["avaOver"] = "r_available";
				}else{
					$record["avaOver"] = "r_overflow";
				}
				$record["totale"] = $avaok;
				$record["booked"] = $booked;
				$record["n_available"] = $avarest;
				$multistatus = array("confirmed");
				$confirmed = $this->getTotBk_pax($campus,$accomodation,$date,$multistatus);
				$record["n_confirmed"] = $confirmed;
				$multistatus = array("active");
				$active = $this->getTotBk_pax($campus,$accomodation,$date,$multistatus);
				$record["n_active"] = $active;
				$multistatus = array("tbc");
				$tbc = $this->getTotBk_pax($campus,$accomodation,$date,$multistatus);
				$record["n_tbc"] = $tbc;
				$multistatus = array("elapsed");
				$elapsed = $this->getTotBk_pax($campus,$accomodation,$date,$multistatus);
				$record["n_elapsed"] = $elapsed;
				$record["datat"] = $date;
				$record["num_in"] = $this->getArrBk_pax($campus,$accomodation,$date);
				$record["num_out"] = $this->getDepBk_pax($campus,$accomodation,$date);
            }
		}
        $Q->free_result();
		return $record;
}


function ca_getTotAva_pax($campus,$accomodation,$date){
		$querya = "SELECT SUM(availability) as dispo FROM plused_campus_availability WHERE start_date <= '$date' AND finish_date >= '$date' AND accomodation_type = '$accomodation' AND id_campus = $campus";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["dispo"]){
					$avaok=0;
				}else{
					$avaok = $row["dispo"];
				}
				$multistatus = array("confirmed","active");
				$booked = $this->getTotBk_pax($campus,$accomodation,$date,$multistatus);
				$avarest = $avaok-$booked;
				if($avarest >= 0){
					$record["avaOver"] = "r_available";
				}else{
					$record["avaOver"] = "r_overflow";
				}
				$record["totale"] = $avaok;
				$record["booked"] = $booked;
				$record["n_available"] = $avarest;
				$multistatus = array("confirmed");
				$confirmed = $this->getTotBk_pax($campus,$accomodation,$date,$multistatus);
				$record["n_confirmed"] = $confirmed;
				$multistatus = array("active");
				$active = $this->getTotBk_pax($campus,$accomodation,$date,$multistatus);
				$record["n_active"] = $active;
				$multistatus = array("tbc");
				$tbc = $this->getTotBk_pax($campus,$accomodation,$date,$multistatus);
				$record["n_tbc"] = $tbc;
				$multistatus = array("elapsed");
				$elapsed = $this->getTotBk_pax($campus,$accomodation,$date,$multistatus);
				$record["n_elapsed"] = $elapsed;
				$record["datat"] = $date;
				$record["num_in"] = $this->ca_getArrBk_pax($campus,$date);
				$record["num_out"] = $this->ca_getDepBk_pax($campus,$date);
            }
		}
        $Q->free_result();
		return $record;
}


function getTotBk_pax($campus,$accomodation,$date,$multistatus){
		$bkok="";
		$querya="SELECT COUNT(plused_rows.id_prenotazione) as totale FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_rows.data_arrivo_campus <= '$date 23:59' AND plused_rows.data_partenza_campus > '$date 23:59' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
		$contastati = 0;
		if(count($multistatus)){
			$querya .= " AND(";
			foreach($multistatus as $stato){
				if($contastati > 0){
					$querya .= " OR";
				}
				$querya .= " plused_book.status = '$stato'";
				$contastati++;
			}
			$querya .= " )";
		}
		$querya .= " GROUP BY plused_rows.accomodation";
		//echo "<br />-".$querya."<br />";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["totale"]){
					$bkok=0;
				}else{
					$bkok = $row["totale"];
				}
            }
		}
        $Q->free_result();
		return $bkok+0;
}

/* BACKUP PRIMA DI LAVORO DATE
function getTotBk_pax($campus,$accomodation,$date,$multistatus){
		$bkok="";
		$querya="SELECT COUNT(plused_rows.id_prenotazione) as totale FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_rows.andata_data_arrivo <= '$date 23:59' AND plused_rows.ritorno_data_partenza > '$date 23:59' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
		$contastati = 0;
		if(count($multistatus)){
			$querya .= " AND(";
			foreach($multistatus as $stato){
				if($contastati > 0){
					$querya .= " OR";
				}
				$querya .= " plused_book.status = '$stato'";
				$contastati++;
			}
			$querya .= " )";
		}
		$querya .= " GROUP BY plused_rows.accomodation";
		//echo "<br />-".$querya."<br />";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["totale"]){
					$bkok=0;
				}else{
					$bkok = $row["totale"];
				}
            }
		}
        $Q->free_result();
		return $bkok+0;
} */

function getArrBk_pax($campus,$accomodation,$date){
		$arrbk="";
		//print_r($multistatus);
		$querya="SELECT COUNT(plused_book.id_book) as num_in FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_rows.data_arrivo_campus >= '$date 00:00' AND plused_rows.data_arrivo_campus <= '$date 23:59' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation' AND plused_book.status = 'confirmed'";
		$querya .= " GROUP BY plused_rows.accomodation";
		$Q=$this->db->query($querya);
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["num_in"]){
					$arrbk=0;
				}else{
					$arrbk = $row["num_in"];
				}
            }
		}
        $Q->free_result();
		return $arrbk+0;
}

function getDepBk_pax($campus,$accomodation,$date){
		$depbk="";
		//print_r($multistatus);
		$querya="SELECT COUNT(plused_book.id_book) as num_in FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_rows.data_partenza_campus >= '$date 00:00' AND plused_rows.data_partenza_campus <= '$date 23:59' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation' AND plused_book.status = 'confirmed'";
		$querya .= " GROUP BY plused_rows.accomodation";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["num_in"]){
					$depbk=0;
				}else{
					$depbk = $row["num_in"];
				}
            }
		}
        $Q->free_result();
		return $depbk+0;
}

function ca_getArrBk_pax($campus,$date){
		$arrbk="";
		//print_r($multistatus);
		$querya="SELECT COUNT(plused_book.id_book) as num_in FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_rows.data_arrivo_campus >= '$date 00:00' AND plused_rows.data_arrivo_campus <= '$date 23:59' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_book.status = 'confirmed'";
		//$querya .= " GROUP BY plused_rows.accomodation";
		$Q=$this->db->query($querya);
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["num_in"]){
					$arrbk=0;
				}else{
					$arrbk = $row["num_in"];
				}
            }
		}
        $Q->free_result();
		return $arrbk+0;
}

function ca_getDepBk_pax($campus,$date){
		$depbk="";
		//print_r($multistatus);
		$querya="SELECT COUNT(plused_book.id_book) as num_in FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_rows.data_partenza_campus >= '$date 00:00' AND plused_rows.data_partenza_campus <= '$date 23:59' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_book.status = 'confirmed'";
		//$querya .= " GROUP BY plused_rows.accomodation";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["num_in"]){
					$depbk=0;
				}else{
					$depbk = $row["num_in"];
				}
            }
		}
        $Q->free_result();
		return $depbk+0;
}

function getD2DBkArrivalPax_pax($campus,$accomodation,$date,$status,$tipo){
		//questa function, senza distinct, count e group by verra' buona per gli elenchi pax (campus manager...)
		switch ($tipo) {
			case "arrival":
				$querya="SELECT CONCAT(plused_book.id_book,'_',plused_book.id_year) as bookid, centri.nome_centri as centro, agenti.businessname, plused_book.status, plused_rows.tipo_pax, plused_rows.accomodation, plused_rows.cognome, plused_rows.nome, plused_rows.sesso, plused_rows.pax_dob, plused_rows.salute, plused_rows.numero_documento, plused_rows.gl_rif, plused_rows.share_room, plused_rows.andata_data_arrivo, plused_rows.andata_volo, plused_rows.andata_apt_arrivo, plused_rows.andata_apt_partenza, plused_rows.ritorno_data_partenza, plused_rows.ritorno_volo, plused_rows.ritorno_apt_partenza, plused_rows.ritorno_apt_arrivo, plused_rows.data_arrivo_campus, plused_rows.data_partenza_campus  FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_rows.data_arrivo_campus >= '$date 00:00' AND plused_rows.data_arrivo_campus <= '$date 23:59' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
				break;
			case "departure":
				$querya="SELECT CONCAT(plused_book.id_book,'_',plused_book.id_year) as bookid, centri.nome_centri as centro, agenti.businessname, plused_book.status, plused_rows.tipo_pax, plused_rows.accomodation, plused_rows.cognome, plused_rows.nome, plused_rows.sesso, plused_rows.pax_dob, plused_rows.salute, plused_rows.numero_documento, plused_rows.gl_rif, plused_rows.share_room, plused_rows.andata_data_arrivo, plused_rows.andata_volo, plused_rows.andata_apt_arrivo, plused_rows.andata_apt_partenza, plused_rows.ritorno_data_partenza, plused_rows.ritorno_volo, plused_rows.ritorno_apt_partenza, plused_rows.ritorno_apt_arrivo, plused_rows.data_arrivo_campus, plused_rows.data_partenza_campus  FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_rows.data_partenza_campus >= '$date 00:00' AND plused_rows.data_partenza_campus <= '$date 23:59' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
				break;
			default:
				$depDate = date('Y-m-d', strtotime($date . ' + 1 day'));
				$querya="SELECT CONCAT(plused_book.id_book,'_',plused_book.id_year) as bookid, centri.nome_centri as centro, agenti.businessname, plused_book.status, plused_rows.tipo_pax, plused_rows.accomodation, plused_rows.cognome, plused_rows.nome, plused_rows.sesso, plused_rows.pax_dob, plused_rows.salute, plused_rows.numero_documento, plused_rows.gl_rif, plused_rows.share_room, plused_rows.andata_data_arrivo, plused_rows.andata_volo, plused_rows.andata_apt_arrivo, plused_rows.andata_apt_partenza, plused_rows.ritorno_data_partenza, plused_rows.ritorno_volo, plused_rows.ritorno_apt_partenza, plused_rows.ritorno_apt_arrivo, plused_rows.data_arrivo_campus, plused_rows.data_partenza_campus  FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_rows.data_arrivo_campus <= '$date 23:59' AND plused_rows.data_partenza_campus >= '$depDate 00:00' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND plused_rows.accomodation = '$accomodation'";
				break;
		}

		if($status==""){
			$querya.=" AND (plused_book.status = 'active' OR plused_book.status = 'confirmed')";
		}else{
			$querya.=" AND plused_book.status='".$status."'";
		}
		$querya.=" ORDER BY plused_book.id_book DESC, plused_rows.gl_rif ASC, plused_rows.tipo_pax ASC, plused_rows.cognome ASC, plused_rows.andata_data_arrivo DESC";
		$Q=$this->db->query($querya);
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[] = $row;
            }
		}
        $Q->free_result();
		return $data;
}

function ca_getD2DBkArrivalPax_pax($accomodation,$date,$status,$tipo,$campusPassed="", $forChild=""){
		switch ($accomodation) {
			case 1:
			case 'standard':
				$accomodation = 'standard';
				break;
			case 2:
			case 'ensuite':
				$accomodation = 'ensuite';
				break;
			case 3:
			case 'homestay':
				$accomodation = 'homestay';
				break;
			case 4:
			case 'twin':
				$accomodation = 'twin';
				break;
			default:
				$accomodation = "all";
		}

		if($campusPassed==""){
			$campus = $this->mbackoffice->centerIdByName($this->session->userdata('businessname'));
		}else{
			$campus = $campusPassed;
		}

		switch ($tipo) {
			case "arrival"://agenti.businessname,
				$querya="SELECT CONCAT(plused_book.id_year,'_',plused_book.id_book) as bookid, centri.nome_centri as centro,  plused_book.status, plused_rows.tipo_pax, plused_rows.accomodation, plused_rows.cognome, plused_rows.nome, plused_rows.sesso, plused_rows.pax_dob, plused_rows.salute, plused_rows.numero_documento, plused_rows.gl_rif, plused_rows.share_room, plused_rows.andata_data_arrivo, plused_rows.andata_volo, plused_rows.andata_apt_arrivo, plused_rows.andata_apt_partenza, plused_rows.ritorno_data_partenza, plused_rows.ritorno_volo, plused_rows.ritorno_apt_partenza, plused_rows.ritorno_apt_arrivo, plused_rows.data_arrivo_campus, plused_rows.data_partenza_campus FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_rows.data_arrivo_campus >= '$date 00:00' AND plused_rows.data_arrivo_campus <= '$date 23:59' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year";
				break;
			case "departure":
				$querya="SELECT CONCAT(plused_book.id_year,'_',plused_book.id_book) as bookid, centri.nome_centri as centro,  plused_book.status, plused_rows.tipo_pax, plused_rows.accomodation, plused_rows.cognome, plused_rows.nome, plused_rows.sesso, plused_rows.pax_dob, plused_rows.salute, plused_rows.numero_documento, plused_rows.gl_rif, plused_rows.share_room, plused_rows.andata_data_arrivo, plused_rows.andata_volo, plused_rows.andata_apt_arrivo, plused_rows.andata_apt_partenza, plused_rows.ritorno_data_partenza, plused_rows.ritorno_volo, plused_rows.ritorno_apt_partenza, plused_rows.ritorno_apt_arrivo, plused_rows.data_arrivo_campus, plused_rows.data_partenza_campus  FROM plused_book, plused_rows, agenti, centri WHERE plused_book.id_centro = centri.id AND plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_rows.data_partenza_campus >= '$date 00:00' AND plused_rows.data_partenza_campus <= '$date 23:59' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year";
				break;
			default:
				//echo "default: ".$date." - <br>";
				$appTo = '';
				$forChild == 'all' ? $appTo = ' , group_concat(plused_roster_supplements.description) as description ' : '';
				$depDate = date('Y-m-d', strtotime($date . ' + 1 day'));
				$querya="SELECT CONCAT(plused_book.id_year,'_',plused_book.id_book) as bookid, centri.nome_centri as centro,  plused_book.status, plused_rows.tipo_pax, plused_rows.accomodation, plused_rows.cognome, plused_rows.nome, plused_rows.sesso, plused_rows.pax_dob, plused_rows.salute, plused_rows.numero_documento, plused_rows.gl_rif, plused_rows.share_room, plused_rows.andata_data_arrivo, plused_rows.andata_volo, plused_rows.andata_apt_arrivo, plused_rows.andata_apt_partenza, plused_rows.ritorno_data_partenza, plused_rows.ritorno_volo, plused_rows.ritorno_apt_partenza, plused_rows.ritorno_apt_arrivo, plused_rows.data_arrivo_campus, plused_rows.data_partenza_campus".$appTo." FROM plused_book join plused_rows on plused_book.id_book = plused_rows.id_book join agenti on plused_book.id_agente = agenti.id join centri on plused_book.id_centro = centri.id left join plused_pax_supplement on plused_pax_supplement.uuid = plused_rows.uuid left join plused_roster_supplements on plused_roster_supplements.plr_id=plused_pax_supplement.plr_id WHERE plused_book.id_centro = $campus AND plused_rows.data_arrivo_campus <= '$date 23:59' AND plused_rows.data_partenza_campus >= '$depDate 00:00' AND  plused_book.id_year = plused_rows.id_year";
				break;
		}

		if($accomodation != "all"){
			$querya.=" AND plused_rows.accomodation = '$accomodation'";
		}

		if($status==""){
			$querya.=" AND plused_book.status = 'confirmed'";
		}else{
			$querya.=" AND plused_book.status='".$status."'";
		}
		$querya.="  group by plused_rows.id_prenotazione ORDER BY plused_book.id_book DESC, plused_rows.gl_rif ASC, plused_rows.tipo_pax ASC, plused_rows.accomodation DESC, plused_rows.cognome ASC, plused_rows.andata_data_arrivo DESC";
			//echo $querya;die;
		$Q=$this->db->query($querya);
		//echo $this->db->last_query();
		$data = array();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[] = $row;
            }
		}
        $Q->free_result();
		return $data;
}

function ca_getTransfersNum($campus,$month,$year){
	date_default_timezone_set('UTC');
	$date = $year.'-'.$month.'-01';
	$end_date = date ("Y-m-d", strtotime("+1 month -1day", strtotime($date)));
	$contagiri = 0;
	while (strtotime($date) <= strtotime($end_date)) {
		$backnum[] = $this->ca_getTransfersNumForDay($campus,$date);
		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		$contagiri++;
	}
	return $backnum;
}

function ca_getTransfersNumForDay($campus,$date){
		$tranum = "";
		$querya="SELECT COUNT(ptt_id) as transfers FROM plused_tra_transfers WHERE ptt_campus_id = $campus AND ptt_dataora >= '$date 00:00' AND ptt_dataora <= '$date 23:59' AND ptt_confirmed = 'YES' GROUP BY ptt_buscompany_code";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["transfers"]){
					$tranum=0;
				}else{
					//$tranum += $row["transfers"];
					$tranum++;
				}
            }
		}
        $Q->free_result();
		$tranum+=0;
		//echo "<br>".$this->db->last_query()."--------".$tranum."<br>";
		return $tranum;
}

function ca_getExcursionsNum($campus,$month,$year){
	date_default_timezone_set('UTC');
	$date = $year.'-'.$month.'-01';
	$end_date = date ("Y-m-d", strtotime("+1 month -1day", strtotime($date)));
	$contagiri = 0;
	while (strtotime($date) <= strtotime($end_date)) {
		$backnum[] = $this->ca_getExcursionsNumForDay($campus,$date);
		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		$contagiri++;
	}
	return $backnum;
}

function ca_getExcursionsNumForDay($campus,$date){
		$tranum = "";
		$querya="SELECT COUNT(exb_id) as excursions FROM plused_exc_bookings WHERE exb_campus_id = $campus AND exb_excursion_date = '$date' AND (exb_confirmed = 'YES' OR exb_confirmed = 'STANDBY') GROUP BY exb_buscompany_code";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["excursions"]){
					$tranum=0;
				}else{
					//$tranum += $row["excursions"];
					$tranum++;
				}
            }
		}
        $Q->free_result();
		$tranum+=0;
		//echo "<br>".$this->db->last_query()."--------".$tranum."<br>";
		return $tranum;
}

function ca_getExcursionsBusCodesForDay($date,$campus){
		$datatra=array();
		$querya="SELECT exc_excursion, exc_length, exb_type, exb_buscompany_code, exb_tot_pax, exb_excursion_date, exb_confirmed FROM plused_exc_bookings, plused_exc_all WHERE exb_id_excursion = exc_id AND exb_campus_id = $campus AND exb_excursion_date = '$date' AND (exb_confirmed = 'YES' OR exb_confirmed = 'STANDBY') GROUP BY exb_buscompany_code";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$datatra[] = $row;
            }
		}
        $Q->free_result();
		return $datatra;
}

function ca_getExtraExcursionsBusCodesForDay($date,$campus){
		$datatra=array();
		$querya="SELECT exc_excursion, exc_length, pte_type, pte_buscompany_code, pte_tot_pax, pte_excursion_date, pte_confirmed FROM plused_tra_excursions, plused_exc_all WHERE pte_excursion_id = exc_id AND pte_campus_id = $campus AND pte_excursion_date = '$date' AND (pte_confirmed = 'YES' OR pte_confirmed = 'STANDBY') GROUP BY pte_buscompany_code";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$datatra[] = $row;
            }
		}
        $Q->free_result();
		return $datatra;
}


function ca_getTransfersBusCodesForDay($date,$campus){
		$datatra=array();
		$querya="SELECT ptt_dataora, ptt_type, ptt_airport_from, ptt_airport_to, ptt_flight, COUNT(pttr_trid) as tuttipax, ptt_buscompany_code FROM plused_tra_transfers, plused_tra_transfers_rows WHERE pttr_trid = ptt_id AND ptt_campus_id = $campus AND ptt_excursion_date = '$date' AND ptt_confirmed = 'YES' GROUP BY ptt_buscompany_code";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$datatra[] = $row;
            }
		}
        $Q->free_result();
		return $datatra;
}

function ca_getExtraExcursionsNum($campus,$month,$year){
	date_default_timezone_set('UTC');
	$date = $year.'-'.$month.'-01';
	$end_date = date ("Y-m-d", strtotime("+1 month -1day", strtotime($date)));
	$contagiri = 0;
	while (strtotime($date) <= strtotime($end_date)) {
		$backnum[] = $this->ca_getExtraExcursionsNumForDay($campus,$date);
		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		$contagiri++;
	}
	return $backnum;
}

function ca_getExtraExcursionsNumForDay($campus,$date){
		$tranum = "";
		$querya="SELECT COUNT(pte_id) as excursions FROM plused_tra_excursions WHERE pte_campus_id = $campus AND pte_excursion_date = '$date' AND (pte_confirmed = 'YES' OR pte_confirmed = 'STANDBY') GROUP BY pte_buscompany_code";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				if(!$row["excursions"]){
					$tranum=0;
				}else{
					$tranum ++;
				}
            }
		}
        $Q->free_result();
		$tranum+=0;
		//echo "<br>".$this->db->last_query()."--------".$tranum."<br>";
		return $tranum;
}


function ca_getTransfersPaxFromBusCode($busCode){
		$datatra=array();
		$querya="SELECT CONCAT (plused_rows.id_year,'_',plused_rows.id_book) as bookID, concat(plused_rows.cognome,' ',plused_rows.nome) as pax, plused_rows.tipo_pax, businessname, ptt_dataora, ptt_airport_from, ptt_airport_to, ptt_flight FROM plused_rows, plused_tra_transfers, plused_tra_transfers_rows, plused_book, agenti WHERE agenti.id = plused_book.id_agente AND plused_rows.uuid = plused_tra_transfers_rows.pttr_uuid AND pttr_trid =  ptt_id AND ptt_buscompany_code = '$busCode' AND plused_rows.id_book = plused_book.id_book ORDER BY plused_book.id_book, plused_rows.tipo_pax, plused_rows.cognome";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$datatra[] = $row;
            }
		}
        $Q->free_result();
		//print_r($datatra);
		return $datatra;
}

function getLocationByCampusId($campusid){
	$this->db->select('located_in');
	$this->db->where('id',$campusid);
    $Q = $this->db->get('centri');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data = $row["located_in"];
        }
    }
    $Q->free_result();
    return $data;
}

function getAccomodationsByCampusId($campusid){
	$data=array();
	$this->db->select('sistemazione');
	$this->db->where('id_sis_centro',$campusid);
    $Q = $this->db->get('plused_sistemazioni-centri');
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}

function setUnplannedAllExcursions($campus,$tipo){
		$data=array();
		if($campus){
			$query1 = "SELECT pte_id, exc_id, exc_excursion, nome_centri, pte_tot_pax, pte_book_id, exc_length, pte_campus_id, pte_fromCampusManagerTick, pte_fromCampusManagerAmount, pte_proforma_currency FROM plused_tra_excursions, plused_exc_all, centri WHERE exc_id = pte_excursion_id and centri.id = pte_campus_id and exc_type = '".$tipo."' and centri.id = $campus AND pte_confirmed = 'NO' ORDER BY exc_id, pte_book_id";
			$Q=$this->db->query($query1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
						$queryfill = "SELECT plused_book.arrival_date, plused_book.departure_date, plused_book.status as statopre, agenti.businessname FROM plused_book, agenti WHERE CONCAT(plused_book.id_year,'_',plused_book.id_book) = '".$row["pte_book_id"]."' AND plused_book.id_agente = agenti.id";
						$Qfill=$this->db->query($queryfill);
						if($Qfill->num_rows() > 0){
							foreach ($Qfill->result_array() as $rowfill){
								$row["arrival_date"] = $rowfill["arrival_date"];
								$row["departure_date"] = $rowfill["departure_date"];
								$row["statopre"] = $rowfill["statopre"];
								$row["businessname"] = $rowfill["businessname"];
							}
						}
						$glname = $this->getExcursionGlByTestataId($row["pte_id"]);
						$row["myglname"] = $glname;
						$data[] = $row;
				}
			}
			$Q->free_result();
			//print_r($data);
			return $data;
		}else{
			return false;
		}
}

function bkgDetailsForAllExcursion($arr_key){
	$data=array();
	foreach($arr_key as $key=>$value){
		$querybk = "SELECT pte_book_id, arrival_date, departure_date, agenti.businessname, pte_tot_pax, pte_id FROM plused_tra_excursions, plused_book, agenti WHERE CONCAT(plused_book.id_year,'_',plused_book.id_book) = pte_book_id AND pte_id = ".$value." AND plused_book.id_agente = agenti.id";
		$Q2=$this->db->query($querybk);
        if ($Q2->num_rows() > 0){
            foreach ($Q2->result_array() as $row){
                $data[] = $row;
            }
        }
	}
	return $data;
}

function getExcursionGlByTestataId($id){
    $glforthis = array();
		$qgl = "SELECT pter_uuid FROM plused_tra_excursions_rows WHERE pter_trid = $id ORDER BY pter_id ASC LIMIT 0,1";
		$Q=$this->db->query($qgl);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $rowgl){
				$uuidforthis = $rowgl["pter_uuid"];
            }
		}
		$Q->free_result();
		$qstring = "SELECT CONCAT(plused_rows.cognome,' ', plused_rows.nome) as firstgl FROM plused_rows WHERE plused_rows.uuid = '".$uuidforthis."'";
		$Q=$this->db->query($qstring);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$glforthis = $row["firstgl"];
            }
		}
		$Q->free_result();
		return $glforthis;
}

function getAllExcursionsPaxFromExcID($pte_id){
		$datatra=array();
		$querya="SELECT CONCAT (plused_rows.id_year,'_',plused_rows.id_book) as bookID, concat(plused_rows.cognome,' ',plused_rows.nome) as pax, plused_rows.tipo_pax, businessname, pte_excursion_date FROM plused_rows, plused_tra_excursions, plused_tra_excursions_rows, plused_book, agenti WHERE agenti.id = plused_book.id_agente AND plused_rows.uuid = plused_tra_excursions_rows.pter_uuid AND pter_trid =  pte_id AND pte_id = $pte_id AND plused_rows.id_book = plused_book.id_book ORDER BY plused_book.id_book, plused_rows.tipo_pax, plused_rows.cognome";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$datatra[] = $row;
            }
		}
        $Q->free_result();
		//print_r($datatra);
		return $datatra;
}

function getCompanyDetailsByBusCode($buscode){
		$datatra=array();
		$querya="SELECT tra_cp_name, tra_cp_phone FROM plused_bus_exc, plused_tra_bus, plused_tra_companies WHERE pbe_jnidbus = tra_bus_id AND tra_bus_cp_id = tra_cp_id AND pbe_rndcode = '".$buscode."'";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$datatra[] = $row;
            }
		}
        $Q->free_result();
		return $datatra;
		/*
		foreach($datatra as $ccp){
		?>
			<?php echo $ccp["tra_cp_name"] ?> -
		<?php
		}*/
}

function cmsUpdateCoach($idC){
		$tra_cp_name = $this->input->xss_clean($this->input->post('tra_cp_name'));
		$tra_cp_address = $this->input->xss_clean($this->input->post('tra_cp_address'));
		$tra_cp_website = $this->input->xss_clean($this->input->post('tra_cp_website'));
		$tra_cp_contact_name = $this->input->xss_clean($this->input->post('tra_cp_contact_name'));
		$tra_cp_email = $this->input->xss_clean($this->input->post('tra_cp_email'));
		$tra_cp_phone = $this->input->xss_clean($this->input->post('tra_cp_phone'));
		$tra_cp_emergency = $this->input->xss_clean($this->input->post('tra_cp_emergency'));
		$tra_cp_fax = $this->input->xss_clean($this->input->post('tra_cp_fax'));
		$data=array(
			'tra_cp_name' => $tra_cp_name,
			'tra_cp_address' => $tra_cp_address,
			'tra_cp_website' => $tra_cp_website,
			'tra_cp_contact_name' => $tra_cp_contact_name,
			'tra_cp_email' => $tra_cp_email,
			'tra_cp_phone' => $tra_cp_phone,
			'tra_cp_emergency' => $tra_cp_emergency,
			'tra_cp_fax' => $tra_cp_fax
		);
		$this->db->where('tra_cp_id', $idC);
		$this->db->update('plused_tra_companies',$data);
		return true;
}

function cmsInsertCoach(){
		$tra_cp_name = $this->input->xss_clean($this->input->post('tra_cp_name'));
		$tra_cp_address = $this->input->xss_clean($this->input->post('tra_cp_address'));
		$tra_cp_website = $this->input->xss_clean($this->input->post('tra_cp_website'));
		$tra_cp_contact_name = $this->input->xss_clean($this->input->post('tra_cp_contact_name'));
		$tra_cp_email = $this->input->xss_clean($this->input->post('tra_cp_email'));
		$tra_cp_phone = $this->input->xss_clean($this->input->post('tra_cp_phone'));
		$tra_cp_emergency = $this->input->xss_clean($this->input->post('tra_cp_emergency'));
		$tra_cp_fax = $this->input->xss_clean($this->input->post('tra_cp_fax'));
		$data=array(
			'tra_cp_name' => $tra_cp_name,
			'tra_cp_address' => $tra_cp_address,
			'tra_cp_website' => $tra_cp_website,
			'tra_cp_contact_name' => $tra_cp_contact_name,
			'tra_cp_email' => $tra_cp_email,
			'tra_cp_phone' => $tra_cp_phone,
			'tra_cp_emergency' => $tra_cp_emergency,
			'tra_cp_fax' => $tra_cp_fax
		);
		$this->db->insert('plused_tra_companies',$data);
		return true;
}


function cmsInsertBusForCoach($idC){
		$tra_bus_name = $this->input->xss_clean($this->input->post('tra_bus_name'));
		$tra_bus_seat = $this->input->xss_clean($this->input->post('tra_bus_seat'));
		$data=array(
			'tra_bus_name' => $tra_bus_name,
			'tra_bus_seat' => $tra_bus_seat,
			'tra_bus_cp_id' => $idC
		);
		$this->db->insert('plused_tra_bus',$data);
		return true;
}

function cmsUpdateBusForCoach($idB){
		$tra_bus_name = $this->input->xss_clean($this->input->post('tra_bus_name'));
		$tra_bus_seat = $this->input->xss_clean($this->input->post('tra_bus_seat'));
		$data=array(
			'tra_bus_name' => $tra_bus_name,
			'tra_bus_seat' => $tra_bus_seat
		);
		$this->db->where('tra_bus_id', $idB);
		$this->db->update('plused_tra_bus',$data);
		return true;
}

function cmsDeleteBus($idBus){
	$queryDel = "DELETE FROM plused_tra_bus WHERE tra_bus_id = ".$idBus;
	//echo $queryDel;
	$Q=$this->db->query($queryDel);
	return true;
}

function getAllExcTraCampus($campus,$tipoA){
	$data = array();
	$querya="SELECT * FROM plused_exc_all WHERE exc_id_centro = ".$campus." AND (";
	$giri = count($tipoA);
	$contagiri = 0;
	foreach($tipoA as $tipo){
		$querya .= " exc_type = '".$tipo. "'";
		$contagiri++;
		if($contagiri < $giri)
			$querya .= " OR ";
	}
	$querya .= ");";
    $Q=$this->db->query($querya);
	//echo $this->db->last_query();
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
    }
    $Q->free_result();
    return $data;
}

function cmsUpdateCampus($idC){
		$nome_centri = $this->input->xss_clean($this->input->post('nome_centri'));
		$school_name = $this->input->xss_clean($this->input->post('school_name'));
		$sis_acco = $this->input->xss_clean($this->input->post('sisacco'));
		$city = $this->input->xss_clean($this->input->post('city'));
		$address = $this->input->xss_clean($this->input->post('address'));
		$post_code = $this->input->xss_clean($this->input->post('post_code'));
		$located_in = $this->input->xss_clean($this->input->post('located_in'));
		$plus_contact = $this->input->xss_clean($this->input->post('plus_contact'));
		$plus_contact_number = $this->input->xss_clean($this->input->post('plus_contact_number'));
		$cm_mail = $this->input->xss_clean($this->input->post('cm_mail'));
		$page_1 = $this->input->xss_clean($this->input->post('page_1'));
		$page_3 = $this->input->xss_clean($this->input->post('page_3'));
		$data=array(
			'nome_centri' => $nome_centri,
			'school_name' => $school_name,
			'address' => $address."#".$city,
			'post_code' => $post_code,
			'located_in' => $located_in,
			'plus_contact' => $plus_contact,
			'plus_contact_number' => $plus_contact_number,
			'cm_mail' => $cm_mail,
			'page_1' => $page_1,
			'page_3' => $page_3
		);
		$this->db->where('id', $idC);
		$this->db->update('centri',$data);
		$this->db->delete('plused_join_centri_psg', array('jn_cpsg_idc' => $idC));
		$this->db->delete('plused_join_centri_pso', array('jn_cpso_idc' => $idC));
		$serg = $this->getAllServizi();
		foreach($serg as $seg){
			$nomecampo = "cpsg_".$seg["psg_id"];
			$valorecampo = $this->input->xss_clean($this->input->post($nomecampo));
			//echo "<br>-".$nomecampo."---".$valorecampo;
			if($valorecampo!=""){
				$datag = array(
					'jn_cpsg_idc' => $idC,
					'jn_cpsg_ids' => $seg["psg_id"],
					'jn_cpsg_text' => $valorecampo
				);
				$this->db->insert('plused_join_centri_psg',$datag);
			}
		}

		$sero = $this->getAllServizi("opzionali");
		foreach($sero as $seo){
			$nomecampo = "cpso_".$seo["pso_id"];
			$valorecampo = $this->input->xss_clean($this->input->post($nomecampo));
			if($valorecampo!=""){
				$datao = array(
					'jn_cpso_idc' => $idC,
					'jn_cpso_ids' => $seo["pso_id"],
					'jn_cpso_text' => $valorecampo
				);
				$this->db->insert('plused_join_centri_pso',$datao);
			}
		}
		$this->db->delete('plused_sistemazioni-centri', array('id_sis_centro' => $idC));
		if(count($sis_acco) > 0){
			foreach($sis_acco as $sSisKey => $sSisName){
				$dataA = array(
					'id_sis_centro' => $idC,
					'sistemazione' => $sSisName
				);
				$this->db->insert('plused_sistemazioni-centri',$dataA);
			}
		}

		return true;
}

function cmsDelDateCampus($idDate){
	$queryDel = "DELETE FROM date_plus WHERE (id = ".$idDate.")";
	$Q=$this->db->query($queryDel);
	//echo "<br />".$queryDel;
	return true;
}

function cmsDelCampusAvailability($idDate){
	$queryDel = "DELETE FROM plused_campus_availability WHERE (id = ".$idDate.")";
	$Q=$this->db->query($queryDel);
	//echo "<br />".$queryDel;
	return true;
}

function cmsAddDateCampus($dataC,$idC){
		$dataAr = explode("__",$dataC);
		$dataOk = $dataAr[2]."-".$dataAr[0]."-".$dataAr[1];
		$data=array(
			'start_date' => $dataOk,
			'codice' => $idC
		);
		$this->db->insert('date_plus',$data);
		return true;
}

function cmsAddCampusAvailability($idC){
		$dateFinish = $this->input->xss_clean($this->input->post('dateFinish'));
		$dateStart = $this->input->xss_clean($this->input->post('dateStart'));
		$numAcco = $this->input->xss_clean($this->input->post('numAcco'));
		$tipoAcc = $this->input->xss_clean($this->input->post('tipoAcc'));
		$dataArS = explode("/",$dateStart);
		$dataArF = explode("/",$dateFinish);
		$dataOkS = $dataArS[2]."-".$dataArS[1]."-".$dataArS[0];
		$dataOkF = $dataArF[2]."-".$dataArF[1]."-".$dataArF[0];
		$data=array(
			'start_date' => $dataOkS,
			'finish_date' => $dataOkF,
			'availability' => $numAcco,
			'id_campus' => $idC,
			'accomodation_type' => $tipoAcc
		);
		$this->db->insert('plused_campus_availability',$data);
		return true;
}

function getAllServizi($tipo="globali"){
				$data=array();
				if($tipo=="globali"){
					$this->db->order_by('psg_priorita');
					$Q=$this->db->get('plused_servizi_globali');
				}else{
					$this->db->order_by('pso_priorita');
					$Q=$this->db->get('plused_servizi_opzionali');
				}
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function getAllCampusServizi($idcampus,$tipo="globali"){
				$data=array();
				if($tipo=="globali"){
					$this->db->where('jn_cpsg_idc',$idcampus);
					$Q=$this->db->get('plused_join_centri_psg');
				}else{
					$this->db->where('jn_cpso_idc',$idcampus);
					$Q=$this->db->get('plused_join_centri_pso');
				}
                if ($Q->num_rows() > 0){
                    foreach ($Q->result_array() as $row){
						$data[]=$row;
                    }
				}
                $Q->free_result();
                return $data;
}

function getAllAttractions(){
		$data=array();
		$querya = "SELECT pat_id, pat_name, pat_type_id, pat_entertainment_group, patt_name, reg_descrizione, cou_descrizione, cit_descrizione FROM plused_attraction_type, plused_attractions, plused_tb_regione, plused_tb_country, plused_tb_citta WHERE pat_type_id = patt_id AND cou_id = pat_country_id AND cit_id = pat_city_id AND reg_id = pat_regione_id ORDER BY pat_name, reg_descrizione, cou_descrizione, cit_descrizione";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
            }
		}
        $Q->free_result();
		//print_r($data);
        return $data;
}

function getAllExcursions($type,$campus=""){
		$data=array();
		if($campus=="")
			$querya = "SELECT * FROM plused_exc_all WHERE exc_type = '".$type."' ORDER BY exc_excursion, exc_centro, exc_weeks";
		else
			$querya = "SELECT * FROM plused_exc_all WHERE exc_id_centro = ".$campus." AND exc_type = '".$type."' ORDER BY exc_excursion, exc_centro, exc_weeks";
		//echo $querya;
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
            }
		}
        $Q->free_result();
		//print_r($data);
        return $data;
}

function getAllServices($idCp = "",$idCampus = "", $dataExcFrom = "", $dataExcTo = "", $exc_type = "", $status = "all"){
		$data=array();

		$querya = "SELECT tra_cp_id, tra_cp_name, tra_bus_name, tra_bus_seat, pbe_rndcode, pbe_qtybus, exc_centro, exc_excursion, exc_type, pbe_excdate, exb_confirmed, SUM(exb_tot_pax) as exb_tot_pax FROM plused_bus_exc, plused_tra_bus, plused_tra_companies, plused_exc_all, plused_exc_bookings WHERE pbe_rndcode = exb_buscompany_code AND pbe_jnidbus = tra_bus_id AND tra_cp_id = tra_bus_cp_id AND exc_id = pbe_jnidexc ";

		if($idCp!="")
			$querya .= "AND tra_cp_id = ".$idCp." ";

		if($idCampus!="")
			$querya .= "AND exc_id_centro = ".$idCampus." ";

		if($dataExcFrom!="" && $dataExcTo!="")
			$querya .= "AND (pbe_excdate >= '".$dataExcFrom."' AND pbe_excdate <= '".$dataExcTo."') ";

		if($exc_type!="")
			$querya .= "AND exc_type = '".$exc_type."' ";

		if($status!="all")
			$querya .= "AND exb_confirmed = '".$status."' ";


		$querya .= "GROUP BY pbe_rndcode ORDER BY pbe_excdate DESC, tra_cp_name, pbe_id DESC, pbe_rndcode";

		$Q=$this->db->query($querya);
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
            }
		}
        $Q->free_result();
        return $data;
}


function cmsUpdateAttraction($idA){
		$pat_name = $this->input->xss_clean($this->input->post('pat_name'));
		$pat_desc = $this->input->xss_clean($this->input->post('pat_desc'));
		$pat_opening_time = $this->input->xss_clean($this->input->post('pat_opening_time'));
		$pat_entertainment_group = $this->input->xss_clean($this->input->post('pat_entertainment_group'));
		$pat_type_id = $this->input->xss_clean($this->input->post('pat_type_id'));
		$pat_address = $this->input->xss_clean($this->input->post('pat_address'));
		$pat_lat = $this->input->xss_clean($this->input->post('actualLat'));
		$pat_lon = $this->input->xss_clean($this->input->post('actualLon'));
		$pat_regione_id = $this->input->xss_clean($this->input->post('pat_regione_id'));
		$pat_country_id = $this->input->xss_clean($this->input->post('pat_country_id'));
		$pat_city_id = $this->input->xss_clean($this->input->post('pat_city_id'));
		$pat_notes_1 = $this->input->xss_clean($this->input->post('pat_notes_1'));
		$pat_student_price = $this->input->xss_clean($this->input->post('pat_student_price'));
		$pat_adult_price = $this->input->xss_clean($this->input->post('pat_adult_price'));
		$pat_currency_id = $this->input->xss_clean($this->input->post('pat_currency_id'));
		$pat_phone = $this->input->xss_clean($this->input->post('pat_phone'));
		$pat_email = $this->input->xss_clean($this->input->post('pat_email'));
		$pat_website = $this->input->xss_clean($this->input->post('pat_website'));
		$data=array(
			'pat_name' => $pat_name,
			'pat_desc' => $pat_desc,
			'pat_opening_time' => $pat_opening_time,
			'pat_entertainment_group' => $pat_entertainment_group,
			'pat_type_id' => $pat_type_id,
			'pat_address' => $pat_address,
			'pat_lat' => $pat_lat,
			'pat_lon' => $pat_lon,
			'pat_regione_id' => $pat_regione_id,
			'pat_country_id' => $pat_country_id,
			'pat_city_id' => $pat_city_id,
			'pat_notes_1' => $pat_notes_1,
			'pat_student_price' => $pat_student_price,
			'pat_adult_price' => $pat_adult_price,
			'pat_currency_id' => $pat_currency_id,
			'pat_phone' => $pat_phone,
			'pat_email' => $pat_email,
			'pat_website' => $pat_website
		);
		$this->db->where('pat_id', $idA);
		$this->db->update('plused_attractions',$data);
		return true;
}

function cmsInsertAttraction(){
		$pat_name = $this->input->xss_clean($this->input->post('pat_name'));
		$pat_desc = $this->input->xss_clean($this->input->post('pat_desc'));
		$pat_opening_time = $this->input->xss_clean($this->input->post('pat_opening_time'));
		$pat_entertainment_group = $this->input->xss_clean($this->input->post('pat_entertainment_group'));
		$pat_type_id = $this->input->xss_clean($this->input->post('pat_type_id'));
		$pat_address = $this->input->xss_clean($this->input->post('pat_address'));
		$pat_lat = $this->input->xss_clean($this->input->post('actualLat'));
		$pat_lon = $this->input->xss_clean($this->input->post('actualLon'));
		$pat_regione_id = $this->input->xss_clean($this->input->post('pat_regione_id'));
		$pat_country_id = $this->input->xss_clean($this->input->post('pat_country_id'));
		$pat_city_id = $this->input->xss_clean($this->input->post('pat_city_id'));
		$pat_notes_1 = $this->input->xss_clean($this->input->post('pat_notes_1'));
		$pat_student_price = $this->input->xss_clean($this->input->post('pat_student_price'));
		$pat_adult_price = $this->input->xss_clean($this->input->post('pat_adult_price'));
		$pat_currency_id = $this->input->xss_clean($this->input->post('pat_currency_id'));
		$pat_phone = $this->input->xss_clean($this->input->post('pat_phone'));
		$pat_email = $this->input->xss_clean($this->input->post('pat_email'));
		$pat_website = $this->input->xss_clean($this->input->post('pat_website'));
		$data=array(
			'pat_name' => $pat_name,
			'pat_desc' => $pat_desc,
			'pat_opening_time' => $pat_opening_time,
			'pat_entertainment_group' => $pat_entertainment_group,
			'pat_type_id' => $pat_type_id,
			'pat_address' => $pat_address,
			'pat_lat' => $pat_lat,
			'pat_lon' => $pat_lon,
			'pat_regione_id' => $pat_regione_id,
			'pat_country_id' => $pat_country_id,
			'pat_city_id' => $pat_city_id,
			'pat_notes_1' => $pat_notes_1,
			'pat_student_price' => $pat_student_price,
			'pat_adult_price' => $pat_adult_price,
			'pat_currency_id' => $pat_currency_id,
			'pat_phone' => $pat_phone,
			'pat_email' => $pat_email,
			'pat_website' => $pat_website
		);
		$this->db->insert('plused_attractions',$data);
		return true;
}

function cmsUpdateExcursion($idE){
		$exc_id_centro = $this->input->xss_clean($this->input->post('exc_id_centro'));
		$exc_centro = $this->centerNameById($exc_id_centro);
		$exc_length = $this->input->xss_clean($this->input->post('exc_length'));
		$exc_excursion = $this->input->xss_clean($this->input->post('exc_excursion'));
		$exc_type = $this->input->xss_clean($this->input->post('exc_type'));
		$exc_weeks = $this->input->xss_clean($this->input->post('exc_weeks'));
		$exc_days = $exc_weeks*7;
		$exc_airport = "-";
		$data=array(
			'exc_id_centro' => $exc_id_centro,
			'exc_centro' => $exc_centro,
			'exc_length' => $exc_length,
			'exc_excursion' => $exc_excursion,
			'exc_type' => $exc_type,
			'exc_weeks' => $exc_weeks,
			'exc_days' => $exc_days,
			'exc_airport' => $exc_airport
		);
		$this->db->where('exc_id', $idE);
		$this->db->update('plused_exc_all',$data);
		return $exc_type;
}

function cmsInsertExcursion(){
		$exc_id_centro = $this->input->xss_clean($this->input->post('exc_id_centro'));
		$exc_centro = $this->centerNameById($exc_id_centro);
		$exc_length = $this->input->xss_clean($this->input->post('exc_length'));
		$exc_excursion = $this->input->xss_clean($this->input->post('exc_excursion'));
		$exc_type = $this->input->xss_clean($this->input->post('exc_type'));
		$exc_weeks = $this->input->xss_clean($this->input->post('exc_weeks'));
		$exc_days = $exc_weeks*7;
		$exc_airport = "-";
		$data=array(
			'exc_id_centro' => $exc_id_centro,
			'exc_centro' => $exc_centro,
			'exc_length' => $exc_length,
			'exc_excursion' => $exc_excursion,
			'exc_type' => $exc_type,
			'exc_weeks' => $exc_weeks,
			'exc_days' => $exc_days,
			'exc_airport' => $exc_airport
		);
		$this->db->insert('plused_exc_all',$data);
		return $exc_type;
}

function cmsRemoveExcursion($idE){
	$queryDel = "DELETE FROM plused_exc_all WHERE exc_id = ".$idE;
	//echo $queryDel;
	$Q=$this->db->query($queryDel);
	$queryDelBus = "DELETE FROM plused_exc_join WHERE jn_id_exc = ".$idE;
	//echo $queryDelBus;
	//die();
	$Q=$this->db->query($queryDelBus);
	return true;
}

function attrByExcId($exc){
		$data=array();
		$querya = "SELECT pjea_id, pat_id, pat_name, patt_name, pat_student_price, pat_adult_price, cur_codice FROM plused_tb_currency, plused_attraction_type, plused_attractions, plused_join_exc_attr WHERE cur_id = pat_currency_id AND pat_type_id = patt_id AND pat_id = pjea_id_a AND pjea_id_e = ".$exc." ORDER BY patt_name";
		$Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
		}
		//echo $this->db->last_query();
        $Q->free_result();
        return $data;
	}

function cmsDelAttrExc($idRiga){
	$queryDel = "DELETE FROM plused_join_exc_attr WHERE (pjea_id = ".$idRiga.")";
	$Q=$this->db->query($queryDel);
	return true;
}

function cmsAddAttractionToExc($idAttr,$idExc){
		$data=array(
			'pjea_id_a' => $idAttr,
			'pjea_id_e' => $idExc
		);
		$this->db->insert('plused_join_exc_attr',$data);
		return true;
}

function cmsDelBusExc($idRiga){
	$queryDel = "DELETE FROM plused_exc_join WHERE (jn_id = ".$idRiga.")";
	//echo $queryDel;
	$Q=$this->db->query($queryDel);
	return true;
}

function cmsUpdateBusExcPrice($idRiga,$intero,$decimale){
		$prezzo = $intero.".".$decimale;
		$data=array(
			'jn_price' => $prezzo
		);
		$this->db->where('jn_id', $idRiga);
		$this->db->update('plused_exc_join',$data);
		return true;
}

function cmsAddBusToExc($idExc,$idCampus,$idBus,$prezzoAdd,$idCur){
		$data=array(
			'jn_id_exc' => $idExc,
			'jn_id_campus' => $idCampus,
			'jn_id_bus' => $idBus,
			'jn_price' => $prezzoAdd,
			'jn_currency' => $idCur
		);
		$this->db->insert('plused_exc_join',$data);
		return true;
}

function getAllBookedAttractions($campus,$status){
		$data=array();
        $querya = "SELECT atb_id, atb_id_book, atb_id_year, atb_id_attraction, nome_centri, atb_tot_pax, atb_total_price, atb_currency, atb_confirmed, pat_name, cou_descrizione, cit_descrizione, cur_codice, businessname, pat_student_price, pat_adult_price, atb_confirmed_date FROM plused_att_bookings, plused_attractions, plused_tb_country, plused_tb_citta, plused_tb_currency, plused_book, centri, agenti WHERE atb_confirmed = '".$status."' AND centri.id = ".$campus." AND pat_id = atb_id_attraction AND atb_id_book = id_book AND cou_id = pat_country_id AND cit_id = pat_city_id AND pat_currency_id = cur_id AND centri.id = atb_campus_id AND agenti.id = plused_book.id_agente";
        $Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
        return $data;
}

function confirmBookAttraction($idAtb,$inte,$deci){
		$prezzo = $inte.".".$deci;
		$data=array(
			'atb_confirmed_date' => date("Y-m-d"),
			'atb_total_price' => $prezzo,
			'atb_confirmed' => "YES"
		);
		$this->db->where('atb_id', $idAtb);
		$this->db->update('plused_att_bookings',$data);
		return true;
}

function getAllCanceledBus(){
		$data=array();
        $this->db->order_by('pcb_rndcode');
        $Q=$this->db->get('plused_canceled_bus');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
        return $data;
}

function readBookingNotes($bkId,$public=0){
		$data=array();
		if($public==1)
			$this->db->where('n_public', 1);
		$this->db->where('n_bkid', $bkId);
        $this->db->order_by('n_datetime',"desc");
        $Q=$this->db->get('plused_book_notes');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
        return $data;
}

function ca_getPriceForAttraction($idAtt,$numGL,$numSTD){
	$data=array();
	$querybk = "SELECT pat_student_price as STD, pat_adult_price as GL, cur_codice FROM plused_attractions, plused_tb_currency WHERE pat_id = ".$idAtt." AND pat_currency_id = cur_id";
	$Q=$this->db->query($querybk);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
    }
	//echo $data[0]["GL"];
    $Q->free_result();
	$glPrice =  number_format(str_replace(",",".",$data[0]["GL"])*1*$numGL,2,",","");
	$stdPrice =  number_format(str_replace(",",".",$data[0]["STD"])*1*$numSTD,2,",","");
	//echo $glPrice ."--->". $stdPrice."--->". $allPrice;
	$curPrice = $data[0]["cur_codice"];
	//echo $allPrice."___".$curPrice;
	return $glPrice."___". $stdPrice."___".$curPrice;
}

function ca_bookAttractionNow($id_book, $id_year, $id_attr, $id_campus, $allNum, $STDprice, $cur_id, $CMprice){
	$data = array(
		'atb_id_book'=>$id_book,
		'atb_id_year'=>$id_year,
		'atb_id_attraction'=>$id_attr,
		'atb_campus_id'=>$id_campus,
		'atb_tot_pax'=>$allNum,
		'atb_total_price'=>str_replace("comma",".",$STDprice),
		'atb_currency'=>$cur_id,
		'atb_fromCMTick'=> 1,
		'atb_fromCMAmount'=>str_replace("comma",".",$CMprice)
	);
	$this->db->insert('plused_att_bookings', $data);
	return true;
}

function cms_getAvaByCampusId($idC){
		$data=array();
        $this->db->order_by('start_date','desc');
		$this->db->where('id_campus', $idC);
        $Q=$this->db->get('plused_campus_availability');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$data[]=$row;
			}
        }
        $Q->free_result();
        return $data;
}

    //nuove function availability prefisso NA (new availability)

    function NA_getCalendarTable1($idb){
        $data=array();
        //MODIFICARE SE VENGONO AGGIUNTI TIPI PAX (ADT)
        $sqlid = "SELECT accomodation,data_arrivo_campus, data_partenza_campus, COUNT(tipo_pax) as contot,COUNT(IF(tipo_pax='GL',1,NULL)) AS contoGL, COUNT(IF(tipo_pax='STD',1,NULL)) AS contoSTD FROM plused_rows where id_book = $idb GROUP BY accomodation, DATE(data_arrivo_campus), DATE(data_partenza_campus) ORDER BY data_arrivo_campus, tipo_pax, accomodation";
        $query = $this->db->query($sqlid);
        if($query->num_rows()> 0)
        {
            foreach($query->result() as $rowq)
            {
                $data[] = $rowq;
            }
            return $data;
        }
    }

    function NA_getCalendarTable2($idb){
        $data=array();
        //MODIFICARE SE VENGONO AGGIUNTI TIPI PAX (ADT)
        $sqlid = "SELECT accomodation,data_arrivo_campus, data_partenza_campus, COUNT(tipo_pax) as contot,COUNT(IF(tipo_pax='GL',1,NULL)) AS contoGL, COUNT(IF(tipo_pax='STD',1,NULL)) AS contoSTD FROM plused_rows where id_book = $idb GROUP BY accomodation ORDER BY data_arrivo_campus, tipo_pax, accomodation";
        $query = $this->db->query($sqlid);
        if($query->num_rows()> 0)
        {
            foreach($query->result() as $rowq)
            {
                $data[] = $rowq;
            }
            return $data;
        }
    }

    function NA_getBookDet($id_book){
        $data = array();
        $sqlid = "SELECT id_centro, MIN(data_arrivo_campus) as mindatein, MAX(data_partenza_campus) as maxdateout FROM plused_book, plused_rows WHERE plused_rows.id_book = plused_book.id_book AND plused_book.id_book = $id_book";
        $query = $this->db->query($sqlid);
        if($query->num_rows()> 0)
        {
            foreach($query->result() as $rowq)
            {
                $data[] = $rowq;
            }
            return $data;
        }
    }


    function NA_getSimCalendar($campus,$accomodation,$datein,$dateout){
        // Set timezone
        date_default_timezone_set('UTC');
        // Start date
        $date = $datein;
        // End date
        $end_date = $dateout;
        //echo $date."--".$end_date;
        $contagiri = 0;
        while (strtotime($date) <= strtotime($end_date)) {
            $backcal[] = $this->NA_getTotAva($campus,$accomodation,$date);
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contagiri++;
        }
        return $backcal;
    }

    function NA_getSimBooking($accomodation,$datein,$dateout,$id_book){
        // Set timezone
        date_default_timezone_set('UTC');
        // Start date
        $date = $datein;
        // End date
        $end_date = $dateout;
        //echo $date."--".$end_date;
        $backbkg=array();
        $contagiri = 0;
        while (strtotime($datein) <= strtotime($dateout)) {
            $querya = "SELECT accomodation, COUNT(id_prenotazione) as num_in, status from plused_rows, plused_book WHERE accomodation = '".$accomodation."' AND plused_book.id_book = plused_rows.id_book AND plused_rows.id_book = $id_book AND DATE(data_arrivo_campus) <= '".$datein."' AND DATE(data_partenza_campus) > '".$datein."'";
            $Q=$this->db->query($querya);
            //echo "<br>".$datein."->".$this->db->last_query();
            if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                    $backbkg[] = $row;
                }
            }
            $Q->free_result();
            $datein = date ("Y-m-d", strtotime("+1 day", strtotime($datein)));
        }
        /*
        echo "<pre>";
        print_r($backbkg);
        echo "<pre>";
        print_r($backbkg);
        */
        return $backbkg;
    }


    function NA_getTotAva($campus,$accomodation,$date){
        $querya = "SELECT SUM(availability) as dispo FROM plused_campus_availability WHERE start_date <= '$date' AND finish_date >= '$date' AND accomodation_type = '$accomodation' AND id_campus = $campus";
        $Q=$this->db->query($querya);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                if(!$row["dispo"]){
                    $avaok=0;
                }else{
                    $avaok = $row["dispo"];
                }
                $multistatus = array("confirmed","active");
                $booked = $this->getTotBk($campus,$accomodation,$date,$multistatus);
                $avarest = $avaok-$booked;
                if($avarest >= 0){
                    $record["avaOver"] = "r_available";
                }else{
                    $record["avaOver"] = "r_overflow";
                }
                $record["totale"] = $avaok;
                $record["booked"] = $booked;
                $record["n_available"] = $avarest;
                $multistatus = array("confirmed");
                $confirmed = $this->getTotBk($campus,$accomodation,$date,$multistatus);
                $record["n_confirmed"] = $confirmed;
                $multistatus = array("active");
                $active = $this->getTotBk($campus,$accomodation,$date,$multistatus);
                $record["n_active"] = $active;
                $multistatus = array("tbc");
                $tbc = $this->getTotBk($campus,$accomodation,$date,$multistatus);
                $record["n_tbc"] = $tbc;
                $multistatus = array("elapsed");
                $elapsed = $this->getTotBk($campus,$accomodation,$date,$multistatus);
                $record["n_elapsed"] = $elapsed;
                $record["datat"] = $date;
                $record["num_in"] = $this->getArrBk($campus,$accomodation,$date);
                $record["num_out"] = $this->getDepBk($campus,$accomodation,$date);
            }
        }
        $Q->free_result();
        return $record;
    }

	function findCenterOpeningByDate($date, $limit=15){
					$data=array();
					$querya = "SELECT codice, nome_centri, start_date FROM date_plus, centri WHERE centri.id = date_plus.codice AND centri.attivo = 1 ORDER BY ABS( DATEDIFF( start_date,'".$date."' ) ), nome_centri LIMIT ".$limit;
                    $Q=$this->db->query($querya);
                    if ($Q->num_rows() > 0){
						foreach ($Q->result_array() as $row){
							$data[]=$row;
						}
					}
                    $Q->free_result();
                    return $data;
	}

//WS DEV METHODS


function importStudyJSON(){
	$wsdl_url = 'http://devtours.studytours.it/ws/vision.asmx?wsdl';
	$client = new SoapClient($wsdl_url, array('soap_version' => SOAP_1_1));
	$params = array(
		'_UserId' => 'visioN@0315',
		'_Psw' => 'j%asbwY3'
	);
	$result = $client->getPrenotazioni($params);
	$jsonR = $result->getPrenotazioniResult;
	$task_array = json_decode($jsonR,true);
	/*
	echo "<pre>";
	print_r($task_array);
	echo "</pre>";
	die(); */
	$seldb="TRUNCATE TABLE plused_studytours_rows_import";
	$Q=$this->db->query($seldb);
	$row=0;
	$errori_riga = array();
	if ($task_array){
		foreach($task_array as $data) {
			/*if($row<=10){
				echo "<pre>";
				print_r($data);
				echo "</pre>";
			}*/
			$num = count($data);
			$row++;
			$cod_vision_array=explode("_",trim($data["CodiceLondra"]));
			echo "<br>$row-->".count($cod_vision_array);
			if(count($cod_vision_array)==2){
				$zeros = "";
				$id_year = $cod_vision_array[0];
				$id_book = $cod_vision_array[1];
				$idCentro = $this->campusIdByBookingId($id_book);
				$inTurnoVision = $this->dataTurnoByBookingId($id_book,"in");
				$outTurnoVision = $this->dataTurnoByBookingId($id_book,"out");
				$uuid=trim($data["IdPrenotazione"]);
				$l_uuid = strlen($uuid);
				$rr = 12-$l_uuid;
				for($ar=0;$ar<$rr;$ar++){
					$zeros .= "0";
				}
				$uuidzeros = $zeros.$uuid;
				//echo $uuidzeros;
				$cognome=ucwords(strtolower(str_replace("'","''",trim($data["Cognome"]))));
				$nome=ucwords(strtolower(str_replace("'","''",trim($data["Nome"]))));
				$sesso=trim($data["Sesso"]);
				$salute=str_replace("'","''",trim($data["Salute"]));
				$numero_documento=trim($data["Documento_Numero"]);
				$tipo_pax=trim($data["TipologiaPasseggero"]);
				$gl_rif=str_replace("'","''",trim($data["Accompagnatore"]));
				$share_room=str_replace("'","''",trim($data["Alloggiare"]));
				$pax_dob=trim($data["DataNascita"]);
				$accomodation=trim($data["Sistemazione"]);
				switch ($accomodation) {
					case "College":
						$acco_ok = "standard";
						break;
					case "Famiglia":
						$acco_ok = "homestay";
						break;
					case "Ensuite":
						$acco_ok = "ensuite";
						break;
				}
				$andata_data_arrivo = "";
				$inTurno = "";
				if(trim($data["Partenza_DataArrivo"])!="")
					$andata_data_arrivo=date("Y-m-d H:i:s",str_replace("000)/","",str_replace("/Date(","",trim($data["Partenza_DataArrivo"]))));
				if(trim($data["campusDataArrivo"])!="")
					$inTurno=date("Y-m-d H:i:s",str_replace("000)/","",str_replace("/Date(","",trim($data["campusDataArrivo"]))));
				//$andata_data_arrivo=date("Y-m-d H:i:s",trim($data["Partenza_DataArrivo"])*1);
				$andata_apt_partenza=trim($data["Partenza_APTPartenza"]);
				$andata_apt_arrivo=trim($data["Partenza_APTArrivo"]);
				$andata_volo=trim($data["Partenza_NVoloPartenza"]);
				$ritorno_data_partenza = "";
				$outTurno = "";
				if(trim($data["Ritorno_DataPartenza"])!="")
					$ritorno_data_partenza=date("Y-m-d H:i:s",str_replace("000)/","",str_replace("/Date(","",trim($data["Ritorno_DataPartenza"]))));
				if(trim($data["campusDataPartenza"])!="")
					$outTurno=date("Y-m-d H:i:s",str_replace("000)/","",str_replace("/Date(","",trim($data["campusDataPartenza"]))));
				//$ritorno_data_partenza=date("Y-m-d H:i:s",trim($data["Ritorno_DataPartenza"])*1);
				$ritorno_apt_partenza=trim($data["Ritorno_APTPartenza"]);
				$ritorno_apt_arrivo=trim($data["Ritorno_APTArrivo"]);
				$ritorno_volo=trim($data["Ritorno_NVoloArrivo"]);
				$destinazione=str_replace("'","''",trim($data["Destinazione"]));
				$voloIn = $andata_data_arrivo;
				$voloOut = $ritorno_data_partenza;
				if($inTurno==""){
					$inTurno = $inTurnoVision;
				}
				if($outTurno==""){
					$outTurno = $outTurnoVision;
				}
				//$inTurno = $voloIn;
				//$outTurno = $voloOut;
				if($voloIn==""){
					$voloIn = $inTurnoVision;
					//$inTurno = $inTurnoVision;
				}
				if($voloOut==""){
					$voloOut = $outTurnoVision;
					//$outTurno = $outTurnoVision;
				}

				$arrInt=explode(" ",$inTurno);
				//$inTurno = $arrInt[0];
				$arrOut=explode(" ",$outTurno);
				//$outTurno = $arrOut[0];
				echo "<br />".$uuidzeros."---".$voloIn."---".$voloOut."---".$inTurno."---".$outTurno."<----";
				// ACCROCCHIO DEL CAZZO DA TOGLIERE IL PROSSIMO ANNO!!! verifica sugli id dei centri per cui spostare le date di arrivo/partenza
				if($idCentro == "4"){
					if($inTurnoVision=="2014-07-11")
						$inTurno = "2014-07-13";
				}
				if($idCentro == "20"){
					if($inTurnoVision=="2014-07-08")
						$outTurno = "2014-07-19";
					if($inTurnoVision=="2014-07-22")
						$outTurno = "2014-08-02";
				}
				if($idCentro == "26"){
					if($outTurnoVision=="2014-07-28")
						$outTurno = "2014-07-26";
					if($outTurnoVision=="2014-07-14")
						$outTurno = "2014-07-12";
				}
				$insertsql = "INSERT INTO plused_studytours_rows_import (id_book, id_year, uuid, cognome, nome, sesso, salute, numero_documento, tipo_pax, gl_rif, share_room, pax_dob, andata_data_arrivo, andata_apt_partenza, andata_apt_arrivo, andata_volo, ritorno_data_partenza, ritorno_apt_partenza, ritorno_apt_arrivo, ritorno_volo, destinazione, accomodation, data_arrivo_campus, data_partenza_campus) VALUES 	(".$id_book.",".$id_year.",'".$uuidzeros."','".$cognome."','".$nome."','".$sesso."','".$salute."','".$numero_documento."','".$tipo_pax."','".$gl_rif."','".$share_room."','".$pax_dob."','".$voloIn."','".$andata_apt_partenza."','".$andata_apt_arrivo."','".$andata_volo."','".$voloOut."','".$ritorno_apt_partenza."','".$ritorno_apt_arrivo."','".$ritorno_volo."','".$destinazione."', '".$acco_ok."','".$inTurno."','".$outTurno."')";
				//echo "<br />".$insertsql;
				$Q=$this->db->query($insertsql);
				//echo "<br />".$this->db->insert_id();
			}else{
				$errori_riga[]=$row;
                //echo "<br/>Errore riga ".$uuid." -> ".$data["CodiceLondra"];
			}
		}
		// FORK ANNO 2013 PER SPOSTARE LE SISTEMAZIONI COLLEGE IN ENSUITE ANZICHE' STANDARD
		// NEI COLLEGE DI DREW, LOS ANGELES, BOSTON, MIAMI AND FLORIDA, SAN FRANCISCO, FELICIAN
		// RIMUOVERE ASSOLUTAMENTE E UNIFORMARE IN DEV LE ACCOMODATION!!!
		$qupdateAccomodation = "UPDATE plused_studytours_rows_import SET accomodation = 'ensuite' WHERE (destinazione = 'Pitzer College' OR destinazione = \"Saint Mary's College of California\" OR destinazione = 'Drew University' OR destinazione = 'Miami & Florida Experience Crowne Plaza Oceanfront' OR destinazione = 'Curry College' OR destinazione = 'Felician College')";
		$QUA=$this->db->query($qupdateAccomodation);
		//echo $this->db->last_query();
		//FINE FORK
	}
	//echo "--".count($errori_riga);
	if(count($errori_riga)>0){
		print_r($errori_riga);
		die("Error import!");
	}
	echo $row."--".count($task_array);
	return true;
}



function newDuplicateOvernight(){
    $parentBook = $this->get_booking_detail($_POST["tRef"]);
    print_r($parentBook);
}

function duplicatingOvernights(){
    $lastYear=$this->getLastBookingYear();
    $dataDis=array();
    $queryDist = "SELECT id_book, id_ref_overnight, arrival_date, departure_date  FROM plused_book  WHERE YEAR(arrival_date) = $lastYear AND id_agente = 795 and id_ref_overnight is not null order by id_ref_overnight DESC";
    $Q=$this->db->query($queryDist);
    if ($Q->num_rows() > 0){
        foreach ($Q->result_array() as $row){
            $dataDis[]=$row;
        }
    }
    $Q->free_result();
    //echo "<pre>";
    //print_r($dataDis);
    //echo "</pre>";
    //duplicare righe
    foreach($dataDis as $overS){
        $booking = $overS["id_ref_overnight"];
        $overnight = $overS["id_book"];
        $queryCopy = "SELECT * FROM plused_studytours_rows_import WHERE id_book = ".$booking;
        $Q=$this->db->query($queryCopy);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $lastZero = 0;
                $row["id_book"] = $overnight;
                for($i=0; $i<strlen($row["uuid"]); $i++){
                   if($row["uuid"][$i]!="0" and $lastZero==0){
                       $lastZero = $i-1;
                   }
                }
                //echo "<br />".$row["uuid"]." - ";
                $row["uuid"][$lastZero] = "X";
                //echo $row["uuid"];
                $row["data_arrivo_campus"] = $overS["arrival_date"];
                $row["data_partenza_campus"] = $overS["departure_date"];
                $dataNew[]=$row;
            }
        }
        $Q->free_result();
    }
    /*
    echo "<pre>";
    print_r($dataNew);
    echo "</pre>";
    */
    foreach($dataNew as $dn){
        $insertsql = "INSERT INTO plused_studytours_rows_import (
        id_book, id_year, uuid, cognome, nome, sesso, salute, numero_documento, tipo_pax, gl_rif, share_room, pax_dob, andata_data_arrivo, andata_apt_partenza, andata_apt_arrivo, andata_volo, ritorno_data_partenza, ritorno_apt_partenza, ritorno_apt_arrivo, ritorno_volo, destinazione, accomodation, data_arrivo_campus, data_partenza_campus) VALUES (".$dn["id_book"].",2015,'".$dn["uuid"]."','".addslashes($dn["cognome"])."','".addslashes($dn["nome"])."','".$dn["sesso"]."','".addslashes($dn["salute"])."','".$dn["numero_documento"]."','".$dn["tipo_pax"]."','".addslashes($dn["gl_rif"])."','".addslashes($dn["share_room"])."','".$dn["pax_dob"]."','".$dn["andata_data_arrivo"]."','".$dn["andata_apt_partenza"]."','".$dn["andata_apt_arrivo"]."','".$dn["andata_volo"]."','".$dn["ritorno_data_partenza"]."','".$dn["ritorno_apt_partenza"]."','".$dn["ritorno_apt_arrivo"]."','".$dn["ritorno_volo"]."','NULL', 'standard','".$dn["data_arrivo_campus"]."','".$dn["data_partenza_campus"]."')";
        //echo "<br />".$insertsql;
        $Q=$this->db->query($insertsql);
    }
}

function checkNoteExists($idNotaDev){
	$this->db->where('n_idNotaDev',$idNotaDev);
	$this->db->from('plused_book_notes');
	return $this->db->count_all_results();
}

function importStudyNotesJSON(){
	$wsdl_url = 'http://devtours.studytours.it/ws/vision.asmx?wsdl';
	$client = new SoapClient($wsdl_url, array('soap_version' => SOAP_1_1));
	$params = array(
		'_UserId' => 'visioN@0315',
		'_Psw' => 'j%asbwY3',
		'_totale' => true
	);
	$result = $client->getNoteGruppo($params);
	$jsonR = $result->getNoteGruppoResult;
	$task_array = json_decode($jsonR,true);
	foreach($task_array as $nota){
		$idNotaDev = $nota["IdNota"];
		//echo trim($nota["ultimaModifica"])."<br />";
		$formTS = str_replace(")/","",str_replace("/Date(","",trim($nota["ultimaModifica"])));
		//echo $formTS."<br />";
		$dataOk = date("Y-m-d H:i:s",substr($formTS,0,-3));
		//echo $dataOk;
		$splitId = explode("_",$nota["CodiceLondra"]);
		$testo = $nota["Nota"];
		$user = $nota["Utente"];
		$stato = $nota["Stato"];
		$isPublic = 0;
		if($nota["Pubblica"])
			$isPublic = 1;
		$data = array(
			'n_datetime' => $dataOk,
			'n_testo' => $testo,
			'n_bkid' => $splitId[1],
			'n_userid' => $user,
			'n_public' => $isPublic,
			'n_idNotaDev' => $idNotaDev
		);
		if($stato!="DELETE"){
			if($this->checkNoteExists($idNotaDev)==1){
				$this->db->where('n_idNotaDev', $idNotaDev);
				$this->db->update('plused_book_notes',$data);
			}else{
				$this->db->insert('plused_book_notes', $data);
			}
		}else{
			$this->db->where('n_idNotaDev', $idNotaDev);
			$this->db->delete('plused_book_notes');
		}
	}
	return true;
}

//new transfers functions

function getSimCalendarAllTransfers($campus,$datein,$dateout,$direction="inbound"){
	// Set timezone
	date_default_timezone_set('UTC');
	// Start date
	$date = $datein;
	// End date
	$end_date = $dateout;
	//echo $date."--".$end_date;
	$contagiri = 0;
	while (strtotime($date) <= strtotime($end_date)) {
		//echo $date."<br />";
		$passaData = date("d/m/Y",strtotime($date));
		$backcal[] = $this->getCalTransfers($campus,$passaData,$direction);
		$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		$contagiri++;
	}
	return $backcal;
}

function getCalTransfers($campus="",$when, $type="inbound"){
		$totali= 0;
		$nonprenotati= 0;
		$data = array();
		$dataarr = explode("/",$when);
		$whenOk = $dataarr[2]."-".$dataarr[1]."-".$dataarr[0];
        if($type=="inbound")
		    $querya="SELECT DATE(andata_data_arrivo) as data_arrivo, COUNT(id_prenotazione) as totnumpax FROM plused_rows, plused_book WHERE plused_book.id_centro = $campus AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND andata_data_arrivo >= '$whenOk 00:00:00' AND andata_data_arrivo <= '$whenOk 23:59:00' AND (plused_book.status='confirmed' OR plused_book.status='active') GROUP BY DATE(plused_rows.andata_data_arrivo) ORDER BY DATE(plused_rows.andata_data_arrivo) ASC";
        else
            $querya="SELECT DATE(ritorno_data_partenza) as data_arrivo, COUNT(id_prenotazione) as totnumpax FROM plused_rows, plused_book WHERE plused_book.id_centro = $campus AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND ritorno_data_partenza >= '$whenOk 00:00:00' AND ritorno_data_partenza <= '$whenOk 23:59:00' AND (plused_book.status='confirmed' OR plused_book.status='active') GROUP BY DATE(plused_rows.ritorno_data_partenza) ORDER BY DATE(plused_rows.ritorno_data_partenza) ASC";
		$Q=$this->db->query($querya);
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$totali = $row["totnumpax"];
            }
		}
        $Q->free_result();
        if($type=="inbound")
		    $queryb="SELECT DATE(andata_data_arrivo) as data_arrivo, COUNT(id_prenotazione) as totnumpax FROM plused_rows, plused_book WHERE plused_book.id_centro = $campus AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND andata_data_arrivo >= '$whenOk 00:00:00' AND andata_data_arrivo <= '$whenOk 23:59:00' AND (plused_book.status='confirmed' OR plused_book.status='active') AND plused_rows.uuid NOT IN (SELECT pttr_uuid FROM plused_tra_transfers_rows WHERE pttr_type = 'inbound')  GROUP BY DATE(plused_rows.andata_data_arrivo) ORDER BY DATE(plused_rows.andata_data_arrivo) ASC";
        else
            $queryb="SELECT DATE(ritorno_data_partenza) as data_arrivo, COUNT(id_prenotazione) as totnumpax FROM plused_rows, plused_book WHERE plused_book.id_centro = $campus AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND ritorno_data_partenza >= '$whenOk 00:00:00' AND ritorno_data_partenza <= '$whenOk 23:59:00' AND (plused_book.status='confirmed' OR plused_book.status='active') AND plused_rows.uuid NOT IN (SELECT pttr_uuid FROM plused_tra_transfers_rows WHERE pttr_type = 'outbound')  GROUP BY DATE(plused_rows.ritorno_data_partenza) ORDER BY DATE(plused_rows.ritorno_data_partenza) ASC";
		$Q=$this->db->query($queryb);
		//echo $this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$nonprenotati = $row["totnumpax"];
            }
		}
		$booked = $totali - $nonprenotati;
        $Q->free_result();
		return array("totali"=>$totali,"nonPrenotati"=>$nonprenotati,"booked"=>$booked);
}

/**
 * Start: Functions by arunsankar
 */

/**
 * Function to unlock single roster
 * @author Arunsankar
 * @since 19-Apr-2016
 * @param int $rowId
 * @return boolean|string
 */
function unlockSingleRoster($rowId) {
		$data = array(
			'lockPax' => 0,
			'template' => NULL,
			'template_date' => NULL
		);
		$this -> db -> where('id_prenotazione', $rowId);
		if ($this -> db -> update('plused_rows', $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function searchNat(){
		$term = $_REQUEST['term'];
		$qstring = "SELECT nat_id, nationality FROM plused_nationality WHERE nationality LIKE '%".$term."%'";
		$Q=$this->db->query($qstring);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
				$row1['id']=$row['nat_id'];
				$row1['value']=$row['nationality'];
				$row1['sigla']=$row['nationality'];
				$row_set[] = $row1;
            }
		}
		echo '{"nationalities":'.json_encode(($row_set)).'}';
	}

	function checkTypedNationality($nationality){
		$this -> db -> select('count(*) as count')
				-> from('plused_nationality')
				-> where('nationality', $nationality);
		$result = $this -> db -> get();
		if($result -> num_rows() > 0){
			$resultArray = $result -> result_array();
			if($resultArray[0]['count'] > 0){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}

	function getCampusByBookId($id){
		$this -> db -> select('a.id_centro, b.nome_centri')
				-> from('plused_book as a')
				-> join('centri as b', 'a.id_centro=b.id')
				-> where('b.attivo', 1)
				-> where('a.id_book', $id);
        $result = $this -> db -> get();
		if($result -> num_rows() > 0){
			return $result -> result_array();
		}
		else{
			return FALSE;
		}
	}

	function getCourseList($idCentro){
		$this -> db -> select('a.plr_id, a.description')
				-> from('plused_roster_supplements as a')
				-> join('plused_roster_supplement_types as b', 'a.supl_id=b.id')
				-> where('a.centri_id', $idCentro);
        $result = $this -> db -> get();
		if($result -> num_rows() > 0){
			return $result -> result_array();
		}
		else{
			return FALSE;
		}
	}

	function remUuidByPaxId($idPax){
		$this -> db -> select('uuid')
				-> from('plused_rows')
				-> where('id_prenotazione', $idPax);
		$result = $this -> db -> get();

		if($result -> num_rows() > 0){
			$resultArray = $result -> result_array();
			$data = array(
				'uuid' => $resultArray[0]['uuid']
			);
			$this->db->where('uuid', $resultArray[0]['uuid']);
			$this -> db -> delete('plused_pax_supplement');
		}
	}

	function ca_getTransfersNumSingle($campus, $dateSel, $month, $year) {
		date_default_timezone_set('UTC');
		$date = $year . '-' . $month . '-01';
		$end_date = date ("Y-m-d", strtotime("+1 month -1day", strtotime($date)));
		$contagiri = 0;
		$dateinA = $month."/".$dateSel."/".$year;
		$datech = date('Y-m-d',strtotime($dateinA));
		$datein = date('Y-m-d',strtotime($dateinA. "-15 days"));
		$dateout = date('Y-m-d',strtotime($dateinA . "+15 days"));
		while (strtotime($datein) <= strtotime($dateout)) {
			$backnum[] = $this -> ca_getTransfersNumForDay($campus, $datein);
			$datein = date ("Y-m-d", strtotime("+1 day", strtotime($datein)));
			$contagiri++;
		}
		return $backnum;
	}

	function ca_getExcursionsNumSingle($campus, $dateSel, $month, $year) {
		date_default_timezone_set('UTC');
		$date = $year . '-' . $month . '-01';
		$end_date = date ("Y-m-d", strtotime("+1 month -1day", strtotime($date)));
		$contagiri = 0;
		$dateinA = $month."/".$dateSel."/".$year;
		$datech = date('Y-m-d',strtotime($dateinA));
		$datein = date('Y-m-d',strtotime($dateinA. "-15 days"));
		$dateout = date('Y-m-d',strtotime($dateinA . "+15 days"));
		while (strtotime($datein) <= strtotime($dateout)) {
			$backnum[] = $this -> ca_getExcursionsNumForDay($campus, $datein);
			$datein = date ("Y-m-d", strtotime("+1 day", strtotime($datein)));
			$contagiri++;
		}
		return $backnum;
	}

	function ca_getExtraExcursionsNumSingle($campus, $dateSel, $month, $year) {
		date_default_timezone_set('UTC');
		$date = $year . '-' . $month . '-01';
		$end_date = date ("Y-m-d", strtotime("+1 month -1day", strtotime($date)));
		$contagiri = 0;
		$dateinA = $month."/".$dateSel."/".$year;
		$datech = date('Y-m-d',strtotime($dateinA));
		$datein = date('Y-m-d',strtotime($dateinA. "-15 days"));
		$dateout = date('Y-m-d',strtotime($dateinA . "+15 days"));
		while (strtotime($datein) <= strtotime($dateout)) {
			$backnum[] = $this -> ca_getExtraExcursionsNumForDay($campus, $datein);
			$datein = date ("Y-m-d", strtotime("+1 day", strtotime($datein)));
			$contagiri++;
		}
		return $backnum;
	}

	function ca_getBkCalendar_paxSingle($campus, $accomodation, $dateSel, $month, $year) {
		// Set timezone
		date_default_timezone_set('UTC');
		// Start date
		$date = $year . '-' . $month . '-01';
		// End date
		$end_date = date ("Y-m-d", strtotime("+1 month -1day", strtotime($date)));
		//echo $date."--".$end_date;
		$contagiri = 0;
		$dateinA = $month."/".$dateSel."/".$year;
		$datech = date('Y-m-d',strtotime($dateinA));
		$datein = date('Y-m-d',strtotime($dateinA. "-15 days"));
		$dateout = date('Y-m-d',strtotime($dateinA . "+15 days"));
		while (strtotime($datein) <= strtotime($dateout)) {
			$backjson[] = $this -> ca_getTotAva_paxDay($campus, $datein);
			$datein = date ("Y-m-d", strtotime("+1 day", strtotime($datein)));
			$contagiri++;
		}
		return $backjson;
	}

	function getBookingRefFromCentro($campusId){
		$this -> db -> select('CONCAT(id_year, \'_\', id_book) as booking_id', false)
				-> from('plused_book')
				-> where('id_centro', $campusId)
				-> where('id_year', date('Y'));
		$result = $this -> db -> get();
		if($result -> num_rows() > 0){
			return $result -> result_array();
		}
		return FALSE;
	}

	function insertTicket($data){
		$table = 'plused_ticket_cm';
		if($this -> db -> insert($table, $data)){
			return TRUE;
		}
		return FALSE;
	}

	function updateTicket($data, $where){
		$table = 'plused_ticket_cm';
		$this -> db -> where($where);
		if($this -> db -> update($table, $data)){
			return TRUE;
		}
		return FALSE;
	}

	function getTicketDetails($ptcId='', $campus = ''){
		if($ptcId){
			$this -> db -> where('ptc_id', $ptcId);
		}
		$this -> db -> select('ptc_id,campus_id,ptc_priority,ptc_category,ptc_title,case when char_length(ptc_content) > 100 then concat(substring(ptc_content,1,100),\'...\',\'&nbsp;&nbsp;<a href="javascript:void(0)" id="tktOpn_\',ptc_id,\'" class="morelink dialogbtn tktOpenClass" data-id="dialog_modal_btn_\',ptc_id,\'">more</a>\') else ptc_content end as ptc_content_small,ptc_content ,ptc_attachment,ptc_ref_booking,ptc_bo_reply,ptc_bo_attachment,ptc_bo_reply_time,ptc_bo_reply_by,ptc_closed,ptc_closed_time,ptc_cm_read,ptc_bo_read,ptc_created_time,ptc_created_by,ptc_active', false)
				-> from('plused_ticket_cm')
				-> where('campus_id', $campus);
		$result = $this -> db -> get();
		if($result -> num_rows() > 0){
			return $result -> result_array();
		}
		return FALSE;
	}

	function getOpenTicketDetails($limit='20'){
		$this -> db -> select('a.*, DATEDIFF(\''.date('Y-m-d').'\', a.ptc_created_time) as dateDf, c.nome_centri ',  false)
				-> from('plused_ticket_cm as a')
				-> join('centri as c','a.campus_id=c.id', 'left')
				-> where('a.ptc_closed', 0)
				-> order_by('a.ptc_created_time')
				-> limit($limit);
		$result = $this -> db -> get();
		if($result -> num_rows() > 0){
			return $result -> result_array();
		}
		return FALSE;
	}

	function getOpenTicketCount(){
		$this -> db -> select('count(*) as count')
				-> from('plused_ticket_cm')
				-> where('ptc_closed', 0);
		$result = $this -> db -> get();
		if($result -> num_rows() > 0){
			$resArray = $result -> result_array();
			return $resArray[0]['count'];
		}
		return FALSE;
	}

	function deleteTicket($selId) {
		$this -> db -> where('ptc_id', $selId);
		if($this -> db -> delete('plused_ticket_cm')){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	function checkTicketStatus($selId) {
		$this -> db -> select('count(*) as count')
				-> from('plused_ticket_cm')
				-> where('ptc_id', $selId)
				-> where('ptc_closed', 0)
				-> where('ptc_active', 1);
		$result = $this -> db -> get();
		if($result -> num_rows() > 0){
			$resultArray = $result -> result_array();
			if($resultArray[0]['count'] > 0){
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}

	function removeAttachment($selId){
		$table = 'plused_ticket_cm';
		$this -> db -> where('ptc_id', $selId);
		$data = array(
			'ptc_attachment' => ''
		);
		if($this -> db -> update($table, $data)){
			return TRUE;
		}
		return FALSE;
	}

	function getCampusNameFromId($id){
		$this -> db -> select('nome_centri')
				-> from('centri')
				-> where('attivo', 1)
				-> where('id', $id);
        $result = $this -> db -> get();
		if($result -> num_rows() > 0){
			$resultArray = $result -> result_array();
			return $resultArray[0]['nome_centri'];
		}
		else{
			return FALSE;
		}
	}

	function getGlDetails($campus) {
                $this -> db -> query('SET SESSION group_concat_max_len = 1000000');
		$this -> db -> select('concat(a.id_year,\'_\',a.id_book) as book_id, sum(case when b.tipo_pax = \'GL\' then 1 else 0 end) Glcount, GROUP_CONCAT(case when b.tipo_pax = \'GL\' || b.tipo_pax = \'STD\' then CONCAT(COALESCE(b.tipo_pax, \'\'),\':\',COALESCE(b.pax_dob, \'\'),\':\',COALESCE(b.nome, \'\'),\':\',COALESCE(b.cognome, \'\')) end ORDER BY b.tipo_pax,b.nome ASC) as gluuid, sum(case when b.tipo_pax = \'STD\' then 1 else 0 end) Stdcount,d.businesscountry, b.data_arrivo_campus, b.data_partenza_campus', false)
				-> from('plused_book as a')
				-> join('plused_rows as b', 'a.id_book = b.id_book')
				//-> join('plused_nationality as c', 'b.nazionalita = c.nationality', 'left')
				-> join('agenti as d', 'a.id_agente = d.id')
				-> where('id_centro', $campus)
				-> where('a.id_year = b.id_year')
				-> where('a.status','confirmed')
				-> group_by('concat(a.id_year,\'_\',a.id_book)', false)
				-> order_by('a.id_year desc, a.id_book asc');
		$result = $this -> db -> get();
		if($result -> num_rows() > 0){
			return $result -> result_array();
		}
		else{
			return FALSE;
		}
	}
	function getGlDetailsRow($campus, $year, $bookId) {
                $this -> db -> query('SET SESSION group_concat_max_len = 1000000');
		$this -> db -> select('concat(a.id_year,\'_\',a.id_book) as book_id, sum(case when b.tipo_pax = \'GL\' then 1 else 0 end) Glcount, GROUP_CONCAT(case when b.tipo_pax = \'GL\' || b.tipo_pax = \'STD\' then CONCAT(COALESCE(b.tipo_pax, \'\'),\':\',COALESCE(b.pax_dob, \'\'),\':\',COALESCE(b.nome, \'\'),\':\',COALESCE(b.cognome, \'\')) end ORDER BY b.tipo_pax,b.nome ASC) as gluuid, sum(case when b.tipo_pax = \'STD\' then 1 else 0 end) Stdcount,d.businesscountry, b.data_arrivo_campus, b.data_partenza_campus', false)
				-> from('plused_book as a')
				-> join('plused_rows as b', 'a.id_book = b.id_book')
				//-> join('plused_nationality as c', 'b.nazionalita = c.nationality', 'left')
				-> join('agenti as d', 'a.id_agente = d.id')
				-> where('id_centro', $campus)
				-> where('a.id_year = b.id_year')
				-> where('a.id_year', $year)
				-> where('a.id_book', $bookId)
				-> where('a.status','confirmed')
				-> group_by('concat(a.id_year,\'_\',a.id_book)', false)
				-> order_by('a.id_year desc, a.id_book asc');
		$result = $this -> db -> get();
		if($result -> num_rows() > 0){
			return $result -> result_array();
		}
		else{
			return FALSE;
		}
	}

	function getCmPayments($campus, $bookId = "") {
		if (!empty($bookId)) {
			$this -> db -> where('pcp_book_id', $bookId);
		}
		$this -> db -> select('*')
				-> from('plused_fincm_payments')
				-> where('campus_id', $campus)
				-> order_by('pcp_added_date', 'desc');
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	function getAllCMPaymentServices() {
		$data = array();
		$this -> db -> order_by('pcse_name');
		$Q = $this -> db -> get('plused_fincm_services');
		if ($Q -> num_rows() > 0) {
			foreach ($Q -> result_array() as $row) {
				$data[] = $row;
			}
		}
		$Q -> free_result();
		return $data;
	}

	function insertCmPayment($data) {
		$table = 'plused_fincm_payments';
		if ($this -> db -> insert($table, $data)) {
			return TRUE;
		}
		return FALSE;
	}

	function deleteCmPayment($selPay){
		$table = 'plused_fincm_payments';
		$where = array(
			'pcp_id' => $selPay
		);
		if($this -> db -> delete($table, $where)){
			return TRUE;
		}
		return FALSE;
	}

	function getCmBalance($campusIDs = "") {
		if (!empty($campusIDs)) {
			$cnt = 1;
			foreach($campusIDs as $campusID){
				if($cnt == 1){
					$this -> db -> where('campus_id', $campusID);
				}
				else{
					$this -> db -> or_where('campus_id', $campusID);
				}
				$cnt += 1;
			}
		}
		$this -> db -> select("a.campus_id,
			a.pcp_currency,
			b.nome_centri,
			sum(CASE WHEN a.pcp_pay_type = 'paid' AND a.pcp_currency='£' THEN pcp_amount ELSE 0 END) as total_due_gbp,
			sum(CASE WHEN a.pcp_pay_type = 'paid' AND a.pcp_currency='$' THEN pcp_amount ELSE 0 END) as total_due_usd,
			sum(CASE WHEN a.pcp_pay_type = 'paid' AND a.pcp_currency='€' THEN pcp_amount ELSE 0 END) as total_due_eur,
			sum(CASE WHEN a.pcp_pay_type = 'cashed' AND a.pcp_currency='£' THEN pcp_amount ELSE 0 END) as total_cashed_gbp,
			sum(CASE WHEN a.pcp_pay_type = 'cashed' AND a.pcp_currency='$' THEN pcp_amount ELSE 0 END) as total_cashed_usd,
			sum(CASE WHEN a.pcp_pay_type = 'cashed' AND a.pcp_currency='€' THEN pcp_amount ELSE 0 END) as total_cashed_eur,
			sum(CASE WHEN a.pcp_pay_type = 'refunded' AND a.pcp_currency='£' THEN pcp_amount ELSE 0 END) as total_refunded_gbp,
			sum(CASE WHEN a.pcp_pay_type = 'refunded' AND a.pcp_currency='$' THEN pcp_amount ELSE 0 END) as total_refunded_usd,
			sum(CASE WHEN a.pcp_pay_type = 'refunded' AND a.pcp_currency='€' THEN pcp_amount ELSE 0 END) as total_refunded_eur,
			(sum(CASE WHEN a.pcp_pay_type = 'cashed' AND a.pcp_currency='£' THEN pcp_amount ELSE 0 END) - sum(CASE WHEN a.pcp_pay_type = 'refunded' AND a.pcp_currency='£' THEN pcp_amount ELSE 0 END)) - sum(CASE WHEN a.pcp_pay_type = 'paid' AND a.pcp_currency='£' THEN pcp_amount ELSE 0 END) as total_cashed_paid_gbp,
			(sum(CASE WHEN a.pcp_pay_type = 'cashed' AND a.pcp_currency='$' THEN pcp_amount ELSE 0 END) - sum(CASE WHEN a.pcp_pay_type = 'refunded' AND a.pcp_currency='$' THEN pcp_amount ELSE 0 END)) - sum(CASE WHEN a.pcp_pay_type = 'paid' AND a.pcp_currency='$' THEN pcp_amount ELSE 0 END) as total_cashed_paid_usd,
			(sum(CASE WHEN a.pcp_pay_type = 'cashed' AND a.pcp_currency='€' THEN pcp_amount ELSE 0 END) - sum(CASE WHEN a.pcp_pay_type = 'refunded' AND a.pcp_currency='€' THEN pcp_amount ELSE 0 END)) - sum(CASE WHEN a.pcp_pay_type = 'paid' AND a.pcp_currency='€' THEN pcp_amount ELSE 0 END) as total_cashed_paid_eur,
			group_concat(if (a.pcp_document ='', null, a.pcp_document)) as documents", false)
				-> from('plused_fincm_payments as a')
				-> join('centri as b', 'a.campus_id=b.id')
				-> group_by('a.campus_id');
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			return $result -> result_array();
		}
		else {
			return FALSE;
		}
	}

	function getCmBookList($campusID){
		$this -> db -> select('pcp_document')
				-> from('plused_fincm_payments')
				-> where('campus_id', $campusID);
		$result = $this -> db -> get();
		$docArray = array();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			foreach($resultArray as $row){
				if(!empty($row['pcp_document'])){
					$docArray[] = $row['pcp_document'];
				}
			}
			return $docArray;
		}
		else {
			return FALSE;
		}

	}

	function checkRefBooking($bookRef){
		$this -> db -> select('count(*) as count')
				-> from('plused_book')
				-> where('id_book', $bookRef);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			if($resultArray[0]['count'] > 0){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		else {
			return FALSE;
		}
	}

	function ca_getTotAva_paxDay($campus, $date) {
		$querya = "SELECT SUM(case when accomodation_type='standard' then availability else 0 end) as dispo_std,SUM(case when accomodation_type='ensuite' then availability else 0 end) as dispo_ens,SUM(case when accomodation_type='homestay' then availability else 0 end) as dispo_hms,SUM(case when accomodation_type='twin' then availability else 0 end) as dispo_twi FROM plused_campus_availability WHERE start_date <= '$date' AND finish_date >= '$date' AND id_campus = $campus";
		$Q = $this -> db -> query($querya);
		if ($Q -> num_rows() > 0) {
			foreach ($Q -> result_array() as $row) {
				$multistatus = array("confirmed", "active");
				$booked = $this -> getTotBk_paxDay($campus, $date, $multistatus);
				$record["booked"] = $booked;
				$record["datat"] = $date;
				$record["num_in"] = $this -> ca_getArrBk_pax($campus, $date);
				$record["num_out"] = $this -> ca_getDepBk_pax($campus, $date);
			}
		}
		$Q -> free_result();
		return $record;
	}

	function getTotBk_paxDay($campus, $date) {
		$bkok = "";
		$querya = "SELECT
			plused_rows.accomodation,
			SUM(case when  plused_book.status='confirmed' then 1 else 0 end) as totale_confirmed
			FROM plused_book, plused_rows WHERE plused_book.id_centro = $campus AND plused_rows.data_arrivo_campus <= '$date 23:59' AND plused_rows.data_partenza_campus > '$date 23:59' AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year";
		$contastati = 0;
		$querya .= " GROUP BY plused_rows.accomodation";
		$Q = $this -> db -> query($querya);
		if ($Q -> num_rows() > 0) {
			$resArray =  $Q -> result_array();
			$actArray = array();
			foreach($resArray as $res){
				$actArray[$res['accomodation']] = $res['totale_confirmed'];
			}
			return $actArray;
		}
		return FALSE;
	}

	function cmsInsertCampusImage( $campus_id, $title, $filename )
	{
		$data = array(
			'campus_id' => $campus_id,
			'title' => $title,
			'image_path' => $filename
		);
		$this->db->insert('plused_campus_image',$data);
		return $this->db->insert_id();
	}

	function cmsInsertCampusPdf( $campus_id, $insert_data )
	{
		// Check if record exists
		$this->db->select("campus_pdf_id");
		$this->db->from("plused_campus_pdf");
		$this->db->where("campus_id", $campus_id);
		$this->db->limit(1);
		$query = $this->db->get();
		$id = ( $query->num_rows() > 0 ) ? $query->row()->campus_pdf_id: 0;

		if( $id == 0 )
		{
			$insert_data['campus_id'] = $campus_id;
			$this->db->insert('plused_campus_pdf',$insert_data);
			return $this->db->insert_id();
		}
		else
		{
			// update data
			$data = array();

			if( $insert_data['pdf_title_1'] != '' )
				$data['pdf_title_1'] = $insert_data['pdf_title_1'];
			if( $insert_data['pdf_title_2'] != '' )
				$data['pdf_title_2'] = $insert_data['pdf_title_2'];
			if( $insert_data['pdf_title_3'] != '' )
				$data['pdf_title_3'] = $insert_data['pdf_title_3'];
			if( $insert_data['pdf_path_1'] != '' )
				$data['pdf_path_1'] = $insert_data['pdf_path_1'];
			if( $insert_data['pdf_path_2'] != '' )
				$data['pdf_path_2'] = $insert_data['pdf_path_2'];
			if( $insert_data['pdf_path_3'] != '' )
				$data['pdf_path_3'] = $insert_data['pdf_path_3'];

			$this->db->where('campus_pdf_id', $id);
			$this->db->update('plused_campus_pdf', $data);
			return $id;
		}

	}

	function getCampusPdf( $campus_id )
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("plused_campus_pdf");
		$this->db->where("campus_id",$campus_id);
		$this->db->limit(1);
		$query = $this->db->get();

        return $query->row_array();
	}

	function cmsInsertCampusSinglePdf( $campus_id, $title, $filename )
	{
		$data = array(
			'campus_id' => $campus_id,
			'title' => $title,
			'pdf_path' => $filename
		);
		$this->db->insert('plused_campus_single_pdf',$data);
		return $this->db->insert_id();
	}

	function getCampusImages( $campus_id )
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("plused_campus_image");
		$this->db->where("campus_id",$campus_id);
		$query = $this->db->get();

        return $query->result_array();
	}

	function getCampusImage( $campus_image_id )
	{
		$data = array();
		$this->db->select("image_path");
		$this->db->from("plused_campus_image");
		$this->db->where("campus_image_id",$campus_image_id);
		$this->db->limit(1);
		$query = $this->db->get();

        return $query->row()->image_path;
	}
	

	function getCampusSinglePdfs( $campus_id )
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("plused_campus_single_pdf");
		$this->db->where("campus_id",$campus_id);
		$query = $this->db->get();

        return $query->result_array();
	}

	function getCampusSinglePdf( $campus_pdf_id )
	{
		$data = array();
		$this->db->select("pdf_path");
		$this->db->from("plused_campus_single_pdf");
		$this->db->where("campus_single_pdf_id",$campus_pdf_id);
		$this->db->limit(1);
		$query = $this->db->get();

        return $query->row()->pdf_path;
	}

	function deleteCampusRecord( $delete_data, $table_name )
	{
		$this->db->where( $delete_data );
		$this->db->delete( $table_name ); 
	}
	/**
 * End: Functions by arunsankar
 */


}
?>
