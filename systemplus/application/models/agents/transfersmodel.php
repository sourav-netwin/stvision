<?php
/**
 * Class for transfers management(Model)
 * @author Sandip
 * @since 28-May-2018
 */
class Transfersmodel extends Model {
    
    function __construct() {
        parent::__construct();
    }
    
    function getAllCampus($attivi = 0) {
        $data = array();
        $this->db->order_by('nome_centri');
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
    
    function setTransfers($campus = "", $when, $status = 'confirmed') {
        $data = array();
        $dataarr = explode("/", $when);
        $whenOk = $dataarr[2] . "-" . $dataarr[1] . "-" . $dataarr[0];
        $this->db->select("DISTINCT 
            CONCAT(plused_rows.id_year,'_',plused_rows.id_book) as bookid, 
            andata_data_arrivo, andata_apt_partenza, andata_apt_arrivo, 
            andata_volo, COUNT(id_prenotazione) as totnumpax, 
            plused_book.status as statopre, businessname, businesscountry, 
            plused_book.id_book, plused_book.id_year, centri.nome_centri, 
            centri.id as idcentro, plused_rows.accomodation",false);
        $this->db->from("plused_rows");
        $this->db->join("plused_book","plused_book.id_book = plused_rows.id_book 
            AND plused_book.id_year = plused_rows.id_year");
        $this->db->join("centri","centri.id = plused_book.id_centro");
        $this->db->join("agenti","plused_book.id_agente = agenti.id");
        $this->db->join("plused_tra_transfers_rows","plused_rows.uuid = plused_tra_transfers_rows.pttr_uuid AND pttr_type = 'inbound'","LEFT");
        $this->db->where("plused_rows.andata_data_arrivo >=","$whenOk 00:00:00");
        $this->db->where("plused_rows.andata_data_arrivo <=","$whenOk 23:59:00");
        if(!empty($campus))
            $this->db->where("plused_book.id_centro",$campus);
        $this->db->where("plused_book.status",$status);
        $this->db->where("(plused_rows.uuid != plused_tra_transfers_rows.pttr_uuid OR plused_tra_transfers_rows.pttr_uuid IS NULL)");
        $this->db->where("(andata_apt_partenza is not null AND andata_apt_arrivo is not null)");
        
        $this->db->group_by("bookid,andata_data_arrivo,andata_volo");
        $this->db->order_by("plused_rows.andata_data_arrivo ASC,
            plused_book.id_book DESC,plused_rows.gl_rif ASC,
            plused_rows.tipo_pax ASC, plused_rows.cognome ASC");
        $Q = $this->db->get();
        //echo $this->db->last_query();die;
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $query2 = "SELECT COUNT(id_prenotazione) as tot_pax 
                    FROM plused_rows 
                    WHERE id_book = " . $row["id_book"] . " 
                    AND id_year = " . $row["id_year"] . " 
                    AND andata_data_arrivo = '0000-00-00 00:00:00';";
                //echo $this->db->last_query();
                $Q2 = $this->db->query($query2);
                if ($Q->num_rows() > 0) {
                    foreach ($Q2->result_array() as $row2) {
                        $row["totForBook"] = $row2["tot_pax"];
                        $maybeTransfers = $this->retrieveTraOk($whenOk, $row["andata_volo"], $row["totnumpax"]);
                        if (count($maybeTransfers)) {
                            $tranOk = $maybeTransfers[0];
                            //echo count($tranOk)."--".count($maybeTransfers);
                            if ($tranOk["postiBus"] > 0) {
                                $row["ptt_buscompany_code"] = $tranOk["ptt_buscompany_code"];
                                $row["oldName"] = $tranOk["oldName"];
                            } else {
                                $row["ptt_buscompany_code"] = "";
                                $row["oldName"] = "";
                            }
                        } else {
                            $row["ptt_buscompany_code"] = "";
                            $row["oldName"] = "";
                        }
                    }
                }
                $row["id_ref_overnight"] = "";
                $row["start_end_overnight"] = "";
                $queryOver = "SELECT id_ref_overnight, start_end_overnight 
                    FROM plused_book WHERE id_book = " . $row["id_book"];
                $Qover = $this->db->query($queryOver);
                if ($Qover->num_rows() > 0) {
                    foreach ($Qover->result_array() as $rowOver) {
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
    
    function setTransfersOut($campus = "", $when, $status = 'confirmed') {
        $data = array();
        $dataarr = explode("/", $when);
        $whenOk = $dataarr[2] . "-" . $dataarr[1] . "-" . $dataarr[0];
        $this->db->select("DISTINCT 
            CONCAT(plused_rows.id_year,'_',plused_rows.id_book) as bookid, 
            ritorno_data_partenza, ritorno_apt_partenza, ritorno_apt_arrivo, 
            ritorno_volo, COUNT(id_prenotazione) as totnumpax, 
            plused_book.status as statopre, businessname, businesscountry, 
            plused_book.id_book, plused_book.id_year, centri.nome_centri, 
            centri.id as idcentro, plused_rows.accomodation",false);
        $this->db->from("plused_rows");
        $this->db->join("plused_book","plused_book.id_book = plused_rows.id_book 
            AND plused_book.id_year = plused_rows.id_year");
        $this->db->join("centri","centri.id = plused_book.id_centro");
        $this->db->join("agenti","plused_book.id_agente = agenti.id");
        $this->db->join("plused_tra_transfers_rows","plused_rows.uuid = plused_tra_transfers_rows.pttr_uuid AND pttr_type = 'inbound'","LEFT");
        $this->db->where("plused_rows.ritorno_data_partenza >=","$whenOk 00:00:00");
        $this->db->where("plused_rows.ritorno_data_partenza <=","$whenOk 23:59:00");
        if(!empty($campus))
            $this->db->where("plused_book.id_centro",$campus);
        $this->db->where("plused_book.status",$status);
        $this->db->where("(plused_rows.uuid != plused_tra_transfers_rows.pttr_uuid OR plused_tra_transfers_rows.pttr_uuid IS NULL)");
        $this->db->where("(andata_apt_partenza is not null AND andata_apt_arrivo is not null)");
        
        $this->db->group_by("bookid,ritorno_data_partenza,ritorno_volo");
        $this->db->order_by("plused_rows.ritorno_data_partenza ASC,
            plused_book.id_book DESC,plused_rows.gl_rif ASC,
            plused_rows.tipo_pax ASC,plused_rows.cognome ASC");
        $Q = $this->db->get();
        //echo $this->db->last_query();die;
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $query2 = "SELECT COUNT(id_prenotazione) as tot_pax FROM plused_rows 
                            WHERE 
                            id_book = " . $row["id_book"] . " 
                            AND id_year = " . $row["id_year"] . " 
                            AND ritorno_data_partenza = '0000-00-00 00:00:00';";
                //echo $this->db->last_query();
                $Q2 = $this->db->query($query2);
                if ($Q->num_rows() > 0) {
                    foreach ($Q2->result_array() as $row2) {
                        $row["totForBook"] = $row2["tot_pax"];
                    }
                }
                $row["id_ref_overnight"] = "";
                $row["start_end_overnight"] = "";
                $queryOver = "SELECT id_ref_overnight, start_end_overnight 
                    FROM plused_book WHERE id_book = " . $row["id_book"];
                $Qover = $this->db->query($queryOver);
                if ($Qover->num_rows() > 0) {
                    foreach ($Qover->result_array() as $rowOver) {
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
    
    function setTransfersOutNotInUse($campus = "", $when, $status = 'confirmed') {
        $data = array();
        $dataarr = explode("/", $when);
        $whenOk = $dataarr[2] . "-" . $dataarr[1] . "-" . $dataarr[0];
        if ($campus == "") {
            $querya = "SELECT DISTINCT CONCAT(plused_rows.id_year,'_',plused_rows.id_book) as bookid, 
            ritorno_data_partenza, ritorno_apt_partenza, ritorno_apt_arrivo, 
            ritorno_volo, COUNT(id_prenotazione) as totnumpax, 
            plused_book.status as statopre, businessname, businesscountry, 
            plused_book.id_book, plused_book.id_year, centri.nome_centri, 
            centri.id as idcentro, plused_rows.accomodation 
            FROM plused_rows, 
            plused_book, 
            agenti, 
            centri 
            WHERE centri.id = plused_book.id_centro 
            AND plused_book.id_agente = agenti.id 
            AND plused_book.id_book = plused_rows.id_book 
            AND plused_book.id_year = plused_rows.id_year 
            AND ritorno_data_partenza >= '$whenOk 00:00:00' 
            AND ritorno_data_partenza <= '$whenOk 23:59:00' 
            AND plused_book.status='" . $status . "' 
                AND plused_rows.uuid NOT IN 
                (SELECT pttr_uuid FROM plused_tra_transfers_rows 
                WHERE pttr_type = 'outbound') 
                GROUP BY bookid, ritorno_data_partenza, 
                ritorno_volo ORDER BY plused_rows.ritorno_data_partenza ASC, 
                plused_book.id_book DESC, 
                plused_rows.gl_rif ASC, 
                plused_rows.tipo_pax ASC, 
                plused_rows.cognome ASC";
        } else {
            $querya = "SELECT DISTINCT CONCAT(plused_rows.id_year,'_',plused_rows.id_book) 
            as bookid, ritorno_data_partenza, 
            ritorno_apt_partenza, ritorno_apt_arrivo, 
            ritorno_volo, COUNT(id_prenotazione) as totnumpax, 
            plused_book.status as statopre, businessname, businesscountry, 
            plused_book.id_book, plused_book.id_year, centri.nome_centri, 
            centri.id as idcentro, plused_rows.accomodation 
            FROM plused_rows, plused_book, agenti, centri WHERE centri.id = plused_book.id_centro AND  plused_book.id_agente = agenti.id AND plused_book.id_centro = $campus AND plused_book.id_book = plused_rows.id_book AND plused_book.id_year = plused_rows.id_year AND ritorno_data_partenza >= '$whenOk 00:00:00' AND ritorno_data_partenza <= '$whenOk 23:59:00' AND plused_book.status='" . $status . "' AND plused_rows.uuid NOT IN (SELECT pttr_uuid FROM plused_tra_transfers_rows WHERE pttr_type = 'outbound') GROUP BY bookid, ritorno_data_partenza, ritorno_volo ORDER BY plused_rows.ritorno_data_partenza ASC, plused_book.id_book DESC, plused_rows.gl_rif ASC, plused_rows.tipo_pax ASC, plused_rows.cognome ASC";
        }
        $Q = $this->db->query($querya);
        //echo $this->db->last_query();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $query2 = "SELECT COUNT(id_prenotazione) as tot_pax FROM plused_rows 
                            WHERE 
                            id_book = " . $row["id_book"] . " 
                            AND id_year = " . $row["id_year"] . " 
                            AND ritorno_data_partenza = '0000-00-00 00:00:00';";
                $Q2 = $this->db->query($query2);
                if ($Q->num_rows() > 0) {
                    foreach ($Q2->result_array() as $row2) {
                        $row["totForBook"] = $row2["tot_pax"];
                    }
                }
                $row["id_ref_overnight"] = "";
                $row["start_end_overnight"] = "";
                $queryOver = "SELECT id_ref_overnight, start_end_overnight 
                    FROM plused_book WHERE id_book = " . $row["id_book"];
                $Qover = $this->db->query($queryOver);
                if ($Qover->num_rows() > 0) {
                    foreach ($Qover->result_array() as $rowOver) {
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
    
    function retrieveTraOk($traDate, $flightN, $nPax) {
        $data = array();
        $querybk = "SELECT COUNT(pttr_id) as postiOccupati, ptt_buscompany_code, 
            ptt_confirmed, nome_centri as oldName 
            FROM 
            centri, plused_tra_transfers, plused_bus_exc, plused_tra_bus, 
            plused_tra_transfers_rows 
            WHERE ptt_campus_id = centri.id 
                AND pttr_trid = ptt_id 
                AND ptt_buscompany_code = pbe_rndcode 
                AND ptt_excursion_date = '" . $traDate . "' 
                AND ptt_confirmed <> 'NO' 
                AND ptt_flight = '" . $flightN . "' 
                AND tra_bus_id =  pbe_jnidbus";
        $Q = $this->db->query($querybk);
        //echo $this->db->last_query();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $postiBus = $this->busSeatsForExcursion($row["ptt_buscompany_code"]);
                $row["postiBus"] = $postiBus;
                $row["nPax"] = $nPax;
                //print_r($row);
                $postiLiberi = $row["postiBus"] * 1 - $row["postiOccupati"] * 1;
                if ($postiLiberi >= $nPax) {
                    $data[] = $row;
                }
            }
        }
        $Q->free_result();
        //print_r($data);
        return $data;
    }
    
    function busSeatsForExcursion($busCode) {
        $totSeats = 0;
        $querybk = "SELECT pbe_qtybus, tra_bus_seat FROM plused_tra_bus, plused_bus_exc WHERE pbe_rndcode = '" . $busCode . "' AND pbe_jnidbus = tra_bus_id";
        $Q = $this->db->query($querybk);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $totSeats = $totSeats + ($row["pbe_qtybus"] * $row["tra_bus_seat"]);
            }
        }
        $Q->free_result();
        return $totSeats;
    }
    
    function setTransfersTransport($type, $quando) {        
        $transfer = $this->input->post('transfer');
        $transfer_id_array = array();
        if ($transfer)
            foreach ($transfer as $key => $value) {
                $rigatransfer = explode("_", $value);
                $id_year = $rigatransfer[0];
                $id_book = $rigatransfer[1];
                $datetimefordb = date("Y-m-d H:i", $rigatransfer[2]);
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
                    'ptt_book_id' => $id_year . "_" . $id_book,
                    'ptt_excursion_date' => $quando,
                    'ptt_tot_pax' => $my_tot_pax
                );
                $this->db->insert('plused_tra_transfers', $data);
                $transfer_id = $this->db->insert_id();
                $transfer_id_array[] = $transfer_id;
                //echo "<br>".$key." | ".$type."----> ".$id_year."_".$id_book." | ".$datetimefordb." | ".$air_from." | ".$air_to." | ".$flight." | ".$id_campus;
                if ($type == "inbound")
                    $queryprova = "SELECT uuid FROM plused_rows 
                        WHERE andata_volo = '" . $flight . "' 
                        AND andata_data_arrivo = '" . $datetimefordb . "' 
                        AND id_book = $id_book 
                        AND id_year = $id_year 
                        AND uuid NOT IN 
                        (SELECT pttr_uuid FROM plused_tra_transfers_rows 
                        WHERE pttr_type = 'inbound')";
                if ($type == "outbound")
                    $queryprova = "SELECT uuid FROM plused_rows 
                        WHERE ritorno_volo = '" . $flight . "' 
                            AND ritorno_data_partenza = '" . $datetimefordb . "' 
                        AND id_book = $id_book AND id_year = $id_year 
                        AND uuid NOT IN 
                        (SELECT pttr_uuid FROM plused_tra_transfers_rows 
                        WHERE pttr_type = 'outbound')";
                $Q = $this->db->query($queryprova);
                foreach ($Q->result_array() as $row) {
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
    
    function getTransfersByID($arrayTr) {
        $data = array();
        foreach ($arrayTr as $singTr) {
            $this->db->where('ptt_id', $singTr);
            $Q = $this->db->get('plused_tra_transfers');
            if ($Q->num_rows() > 0) {
                foreach ($Q->result_array() as $row) {
                    $this->db->where('pttr_trid', $singTr);
                    $this->db->from('plused_tra_transfers_rows');
                    $row["tot_pax"] = $this->db->count_all_results();
                    $arrayBK = explode("_", $row["ptt_book_id"]);
                    $idAgente = $this->agentIdByBkIdYear($arrayBK[0], $arrayBK[1]);
                    $row["agency"] = $this->agentNameById($idAgente);
                    $data[] = $row;
                }
            }
        }
        return $data;
    }
    
    function agentIdByBkIdYear($year, $book) {
        $data = null;
        $this->db->select('id_agente');
        $this->db->where('id_year', $year);
        $this->db->where('id_book', $book);
        $Q = $this->db->get('plused_book');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data = $row;
            }
        }
        $Q->free_result();
        return $data["id_agente"];
    }
    
    function agentNameById($id) {
        $data = null;
        $this->db->select('businessname');
        $this->db->where('id', $id);
        $Q = $this->db->get('agenti');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data = $row;
            }
        }
        $Q->free_result();
        return $data["businessname"];
    }
    
    function busListForTransfers($campusId, $airport, $type) {
        $tipo = "in";
        if ($type == "outbound")
            $tipo = "out";
        $data = array();
        $this->db->select("
            exc_excursion_name as exc_excursion, exc_airport, jn_id_bus, jn_cost as jn_price, 
            cur_codice as jn_currency, tra_cp_name, tra_bus_name, tra_bus_seat, 
            exc_id
        ");
        $this->db->from("plused_exc_join");
        $this->db->join("agnt_excursions","jn_id_exc = exc_id");
        $this->db->join("agnt_campus_excursion","exc_id = excm_exc_id");
        $this->db->join("plused_tra_bus","jn_id_bus = tra_bus_id");
        $this->db->join("plused_tra_companies","tra_bus_cp_id = tra_cp_id");
        $this->db->join("plused_tb_currency","jn_currency = cur_id");        
        $this->db->where("(exc_transfer_type = 'both' OR exc_transfer_type = '" . $tipo . "')");
        $this->db->where("exc_type","transfer");
        $this->db->where("exc_airport",$airport);
        $this->db->where("excm_campus_id",$campusId);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }
    
    function centerPickupById($idcentro) {
        $data = array();
        $this->db->where('id', $idcentro);
        $Q = $this->db->get('centri');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data[0]["school_name"] . " - " . str_replace("#", ", ", $data[0]["address"]);
    }
    
    function busCode() {
        $length = 10;
        $string = '';
        $index = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $string .= $index[rand(0, strlen($index) - 1)];
        }
        return $string;
    }
    
    function standbyTransferExcursion($busCode, $vnum, $excDate) {
        $qUpdNum = "UPDATE plused_tra_transfers SET ptt_buscompany_code = '" . $busCode . "', ptt_confirmed = 'STANDBY' WHERE ptt_id = $vnum";
        //echo $qUpdNum;
        $Q = $this->db->query($qUpdNum);
        return true;
    }
    
    function addBusTab($numIdBus, $qtyBus, $excDate, $busCode) {
        $strCostoBus = "cost_" . $numIdBus;
        $strCurrencyBus = "currency_" . $numIdBus;
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
        //print_r($data);die;
        $this->db->insert('plused_bus_exc', $data);
    }
    
    /**
     * Transfers details page model funnctions
     *  
     */
    
    function busDetailForExcursion($busCode) {
        $data = array();
        $this->db->select("pbe_jnidbus, pbe_jnprice, pbe_jncurrency, pbe_qtybus, 
            tra_cp_name, tra_bus_name, tra_bus_seat, tra_cp_id, tra_cp_phone");
        $this->db->from("plused_tra_bus");
        $this->db->join("plused_tra_companies","tra_bus_cp_id = tra_cp_id");
        $this->db->join("plused_bus_exc","tra_bus_id = pbe_jnidbus");
        $this->db->where("pbe_rndcode",$busCode);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }
    
    function getTraIdsFromBusCode($busCode) {
        $data = array();
        $this->db->select('ptt_id');
        $this->db->where('ptt_buscompany_code', $busCode);
        $Q = $this->db->get('plused_tra_transfers');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row["ptt_id"];
            }
        }
        $Q->free_result();
        return $data;
    }

    function bkgDetailsForTransfer($arr_key) {
        $data = array();
        foreach ($arr_key as $key => $value) {
            $bkgexploded = array();
            $querybk = "SELECT ptt_book_id, ptt_dataora, ptt_airport_from, 
                ptt_airport_to, ptt_flight, ptt_tot_pax, ptt_id, ptt_type 
                FROM plused_tra_transfers WHERE ptt_id = " . $value; //." AND plused_book.id_agente = agenti.id";
            $Q2 = $this->db->query($querybk);
            if ($Q2->num_rows() > 0) {
                foreach ($Q2->result_array() as $row) {
                    $bkgexploded = explode("_", $row["ptt_book_id"]);
                    $idAgente = $this->agentIdByBkIdYear($bkgexploded[0], $bkgexploded[1]);
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
    
    function agentCountryById($id) {
        $data = null;
        $this->db->select('businesscountry');
        $this->db->where('id', $id);
        $Q = $this->db->get('agenti');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data = $row;
            }
        }
        $Q->free_result();
        return $data["businesscountry"];
    }
    
    function getTraPaxForBusCode($busCode) {
        $this->db->select("SUM(ptt_tot_pax) as allpax");
        $this->db->from("plused_tra_transfers");
        $this->db->where("ptt_buscompany_code",$busCode);
        $this->db->group_by("ptt_buscompany_code");
        $Q = $this->db->get();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data = $row["allpax"];
            }
        }
        $Q->free_result();
        return $data;
    }
    
    function getTraRealPaxForBusCode($busCode) {
        $this->db->select("COUNT(pttr_id) as effettivi");
        $this->db->from("plused_tra_transfers");
        $this->db->join("plused_tra_transfers_rows","pttr_trid = ptt_id");
        $this->db->where("ptt_buscompany_code",$busCode);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data = $row["effettivi"];
            }
        }
        $Q->free_result();
        return $data;
    }
    
    function getTraStatusByBusCode($busCode) {
        $data = array();
        $this->db->select('ptt_confirmed');
        $this->db->distinct();
        $this->db->where('ptt_buscompany_code', $busCode);
        $Q = $this->db->get('plused_tra_transfers');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row["ptt_confirmed"];
            }
        }
        $Q->free_result();
        return $data;
    }
    
    function getTraTypeByBusCode($busCode) {
        $this->db->select('ptt_type');
        $this->db->distinct();
        $this->db->where('ptt_buscompany_code', $busCode);
        $Q = $this->db->get('plused_tra_transfers');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data = $row["ptt_type"];
            }
        }
        $Q->free_result();
        return $data;
    }
    
    function excDetail($busCode) {
        $data = array();
        $this->db->select("DISTINCT pbe_jnidexc, pbe_excdate, pbe_hpickup, 
            pbe_hreturn, pbe_pickupplace, exc_excursion_name as exc_excursion, 
            exc_type, exc_day_type as exc_length, 
            nome_centri, pbe_cm_ok, pbe_cm_notes, pbe_cm_done, excm_campus_id as exc_id_centro",FALSE);
        $this->db->from("plused_bus_exc be");
        $this->db->join("agnt_excursions exc","be.pbe_jnidexc = exc.exc_id");
        $this->db->join("agnt_campus_excursion c_exc","exc.exc_id = c_exc.excm_exc_id");
        $this->db->join("centri c","c_exc.excm_campus_id = c.id");
        $this->db->where("pbe_rndcode",$busCode);
        $Q = $this->db->get();
        //echo $this->db->last_query();die;
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }
    
    function viewBookedTransfers($campus, $tipo, $to, $from, $status) {
        $data = array();
        $fromarray = explode("/", $from);
        $toarray = explode("/", $to);
        $frommysql = $fromarray[2] . "-" . $fromarray[1] . "-" . $fromarray[0];
        $tomysql = $toarray[2] . "-" . $toarray[1] . "-" . $toarray[0];

        $queryt2 = "SELECT SUM(ptt_tot_pax) as allpax, ptt_excursion_date, 
            ptt_buscompany_code, nome_centri, ptt_type, ptt_confirmed, 
            ptt_airport_to, ptt_airport_from 
            FROM 
            plused_tra_transfers, 
            centri 
            WHERE ptt_campus_id = centri.id AND";
        if ($campus) {
            $queryt2 .= " ptt_campus_id = $campus AND";
        }
        if ($tipo != "all")
            $queryt2 .= " ptt_type = '" . $tipo . "' AND";
        if ($status != "all")
            $queryt2 .= " ptt_confirmed = '" . $status . "' AND";
        else
            $queryt2 .= " (ptt_confirmed = 'STANDBY' OR ptt_confirmed = 'YES') AND";
        $queryt2 .= " (ptt_excursion_date <= '$tomysql' AND ptt_excursion_date >= '$frommysql') GROUP BY ptt_buscompany_code ORDER BY ptt_excursion_date, nome_centri";
        if ($tipo == "inbound")
            $queryt2 .= ", ptt_airport_to";
        if ($tipo == "outbound")
            $queryt2 .= ", ptt_airport_from";
        $Q = $this->db->query($queryt2);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $querycontarighe = "SELECT COUNT(pttr_id) as effettivi 
                    FROM plused_tra_transfers_rows, plused_tra_transfers 
                    WHERE pttr_trid = ptt_id 
                    AND ptt_buscompany_code = '" . $row["ptt_buscompany_code"] . "'";
                $Qconta = $this->db->query($querycontarighe);
                if ($Qconta->num_rows() > 0) {
                    foreach ($Qconta->result_array() as $rowConta) {
                        $row["effettivi"] = $rowConta["effettivi"];
                    }
                }
                $queryvoli = "SELECT ptt_flight 
                    FROM plused_tra_transfers 
                    WHERE ptt_buscompany_code = '" . $row["ptt_buscompany_code"] . "' 
                        GROUP BY ptt_flight";
                $Qvoli = $this->db->query($queryvoli);
                if ($Qvoli->num_rows() > 0) {
                    $contaivoli = 1;
                    $stringavoli = "";
                    foreach ($Qvoli->result_array() as $rowVoli) {
                        if ($contaivoli > 1 && $contaivoli <= count($Qvoli->result_array())) {
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
    
    function getCompanyDetailsByBusCode($buscode) {
        $datatra = array();
        $querya = "SELECT tra_cp_name, tra_cp_phone 
            FROM plused_bus_exc, plused_tra_bus, plused_tra_companies 
            WHERE pbe_jnidbus = tra_bus_id 
            AND tra_bus_cp_id = tra_cp_id 
            AND pbe_rndcode = '" . $buscode . "'";
        $Q = $this->db->query($querya);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $datatra[] = $row;
            }
        }
        $Q->free_result();
        return $datatra;
    }
    
    function busTraReset($busCode) {
        $this->db->select('ptt_id');
        $this->db->where('ptt_buscompany_code', $busCode);
        $Q = $this->db->get('plused_tra_transfers');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $qDelRighe = "DELETE FROM plused_tra_transfers_rows 
                    WHERE pttr_trid = " . $row["ptt_id"];
                $this->db->query($qDelRighe);
                $qDelTesta = "DELETE FROM plused_tra_transfers 
                    WHERE ptt_id = " . $row["ptt_id"];
                $this->db->query($qDelTesta);
            }
        }
        $qDelNum = "DELETE FROM plused_bus_exc 
            WHERE pbe_rndcode = '" . $busCode . "'";
        $this->db->query($qDelNum);
        return true;
    }
    
    function busTraConfirm($busCode) {
        $qUpdNum = "UPDATE plused_tra_transfers SET 
            ptt_confirmed = 'YES' 
            WHERE ptt_buscompany_code = '" . $busCode . "'";
        $this->db->query($qUpdNum);
        return true;
    }
    
    function addPaxToExistingTransfer($busCode, $idBook, $idYear, $totPax) {
        $commonDetails = $this->getTraCommonDetails($busCode);
        $cd = $commonDetails[0];
        $data = array(
            'ptt_type' => "inbound",
            'ptt_dataora' => $cd["ptt_dataora"],
            'ptt_campus_id' => $cd["ptt_campus_id"],
            'ptt_airport_from' => $cd["ptt_airport_from"],
            'ptt_airport_to' => $cd["ptt_airport_to"],
            'ptt_flight' => $cd["ptt_flight"],
            'ptt_book_id' => $idYear . "_" . $idBook,
            'ptt_excursion_date' => $cd["ptt_excursion_date"],
            'ptt_confirmed' => $cd["ptt_confirmed"],
            'ptt_buscompany_code' => $cd["ptt_buscompany_code"],
            'ptt_tot_pax' => $totPax
        );
        $this->db->insert('plused_tra_transfers', $data);
        $idInserito = $this->db->insert_id();
        $queryprova = "SELECT uuid FROM plused_rows WHERE andata_volo = '" . $cd["ptt_flight"] . "' AND andata_data_arrivo = '" . $cd["ptt_dataora"] . "' AND id_book = " . $idBook . " AND id_year = " . $idYear . " AND uuid NOT IN (SELECT pttr_uuid FROM plused_tra_transfers_rows WHERE pttr_type = 'inbound')";
        $Q = $this->db->query($queryprova);
        foreach ($Q->result_array() as $row) {
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
    
    function getTraCommonDetails($busCode) {
        $data = array();
        $this->db->where('ptt_buscompany_code', $busCode);
        $this->db->limit(1);
        $Q = $this->db->get('plused_tra_transfers');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }
    
    function ca_getTransfersPaxFromBusCode($busCode) {
        $datatra = array();
        $querya = "SELECT CONCAT (plused_rows.id_year,'_',plused_rows.id_book) as bookID, 
        concat(plused_rows.cognome,' ',plused_rows.nome) as pax, 
        plused_rows.tipo_pax, businessname, ptt_dataora, ptt_airport_from, 
        ptt_airport_to, ptt_flight 
        FROM plused_rows, 
            plused_tra_transfers, 
            plused_tra_transfers_rows, 
            plused_book, 
            agenti 
        WHERE agenti.id = plused_book.id_agente 
            AND plused_rows.uuid = plused_tra_transfers_rows.pttr_uuid 
            AND pttr_trid =  ptt_id 
            AND ptt_buscompany_code = '$busCode' 
            AND plused_rows.id_book = plused_book.id_book 
        ORDER BY plused_book.id_book, plused_rows.tipo_pax, plused_rows.cognome";
        $Q = $this->db->query($querya);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $datatra[] = $row;
            }
        }
        $Q->free_result();
        //print_r($datatra);
        return $datatra;
    }
    
    function viewLostTransfers() {
        $data = array();
        $queryt2 = "SELECT SUM(ptt_tot_pax) as allpax, ptt_excursion_date, ptt_buscompany_code, nome_centri, ptt_type, ptt_confirmed, ptt_airport_to, ptt_airport_from, ptt_id, ptt_flight FROM plused_tra_transfers, centri WHERE ptt_campus_id = centri.id AND ptt_confirmed = 'NO'";
        $queryt2 .= "  GROUP BY ptt_id ORDER BY ptt_excursion_date, nome_centri";
        $Q = $this->db->query($queryt2);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }
    
    function actionResetLostTransfers() {
        $qDelNum = "DELETE FROM plused_tra_transfers_rows 
            WHERE pttr_trid IN 
            (SELECT ptt_id FROM plused_tra_transfers 
            WHERE ptt_confirmed = 'NO')";
        $Q = $this->db->query($qDelNum);
        $qDelTest = "DELETE FROM plused_tra_transfers WHERE ptt_confirmed = 'NO'";
        $Q = $this->db->query($qDelTest);
        return true;
    }
}

/*End of file transfers.php*/
