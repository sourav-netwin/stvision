<?php

/**
 * @Programmer  : Preeti M
 * @Maintainer  : Preeti M
 * @Created     : 25 July 2016
 * @Modified    :
 * @Description : ST history model
 */
Class Sthistorymodel extends Model {

    var $table_name = "st_history";

    function __construct() {
        parent::__construct();
        //$this -> db -> query('SET @@global.max_allowed_packet=16*1024*1024');
    }

    /**
     * operations
     * This function can be use for below operations
     * insert
     * @param string $action
     * @param array $data
     * @param int $edit_id
     * @return int
     * @throws Exception
     */
    public function operations($action, $data = array(), $edit_id = 0) {
        $result = null;
        try {
            switch ($action) {
                case 'insert':
                    $this->db->insert($this->table_name, $data);
                    $result = $this->db->insert_id();
                    break;
                default:
                    break;
            }
        } catch (Exception $exp) {
            throw $exp;
        }
        return $result;
    }

    /**
     * getDistinctDataByField
     * This function returns distinct values for field passed as parameter
     * param: field_name: column name
     * @return array
     */
    public function getDistinctDataByField($field_name, $strWhere = "", $orderBy = "asc") {

        $this->db->select($field_name);
        $this->db->where($field_name . " != ''");
        $this->db->distinct();
        $this->db->order_by($field_name, $orderBy);
        if (!empty($strWhere)) {
            $this->db->where($strWhere);
        }
        $query = $this->db->get($this->table_name);

        return $query->result_array();
    }

    /**
     * getReportData
     * This function returns report data
     * @param array - containing all field data that need to searched
     * @return array
     */
    public function getReportData($get_data, $order_by = 'anno') {

        $accumulative = 0;
        if (isset($get_data['accumulative']))
            $accumulative = $get_data['accumulative'];
        $checkagetoday = 0;
        if (isset($get_data['checkagetoday']))
            $checkagetoday = $get_data['checkagetoday'];


        // REPORT TYPE AS CORPORATE OR PROFESSORI
        $reportType = $get_data['reportType'];
        $groupByCollaboratoreField = "";
        // THIS IS FOR COLLABORATORE FILTER
        // AS PER CORPORATE OR PROFESSORI
        // FILTER IS APPLIED ON collaboratore OR azienda
        if ($reportType == "professori") {
            if ($get_data['collaboratore'] != '')
                $this->db->where('collaboratore', $get_data['collaboratore']);
            $groupByCollaboratoreField = "collaboratore";
        }
        elseif ($reportType == "corporate") {
            if ($get_data['collaboratore'] != '')
                $this->db->where('azienda', $get_data['collaboratore']);
            $groupByCollaboratoreField = "azienda";
        }


        if ($get_data['codice_prodotto'] != '')
            $this->db->where('codice_prodotto', $get_data['codice_prodotto']);
        if (!empty($get_data['tipologia_prodotto']))
            $this->db->where_in('tipologia_prodotto', $get_data['tipologia_prodotto']);
        if (!empty($get_data['destinazione_nazione']))
            $this->db->where_in('destinazione_nazione', $get_data['destinazione_nazione']);

        // COLLABORATORE FILTERS
        if (!empty($get_data['collaboratoreProvincia']))
            $this->db->where('collaboratoreProvincia', $get_data['collaboratoreProvincia']);
        if (!empty($get_data['collaboratoreNazione']))
            $this->db->where('collaboratoreNazione', $get_data['collaboratoreNazione']);
        if (!empty($get_data['collaboratoreRegione']))
            $this->db->where('collaboratoreRegione', $get_data['collaboratoreRegione']);
        if (!empty($get_data['collaboratoreMacroRegione']))
            $this->db->where('collaboratoreMacroRegione', $get_data['collaboratoreMacroRegione']);


        if (!empty($get_data['destinazione']))
            $this->db->where('destinazione', $get_data['destinazione']);
        if (!empty($get_data['anno']))
            $this->db->where('anno', $get_data['anno']);


        // CUSTOMER FILTERS
        //$strWhereCustomers = "";
        if (!empty($get_data['regione'])) {
            $this->db->where('regione', $get_data['regione']);
        }
        if (!empty($get_data['macro_regione'])) {
            $this->db->where('macro_regione', $get_data['macro_regione']);
        }
        if (!empty($get_data['nazione'])) {
            $this->db->where('nazione', $get_data['nazione']);
        }

        // date of birth : age range filters
        $ageOnField = "data_partenza";
        if ($checkagetoday)
            $ageOnField = "date(now())";

        if (!empty($get_data['ageStart']))
            $this->db->where('(datediff(' . $ageOnField . ', data_nascita) / 365.25) >= ', $get_data['ageStart']);
        if (!empty($get_data['ageEnd']))
            $this->db->where('(datediff(' . $ageOnField . ', data_nascita) / 365.25) <= ', $get_data['ageEnd']);


        //$this -> db -> where('id_accompagnatore = id_collaboratore');
        if (isset($get_data['exportType'])) {
            if ($get_data['exportType'] == "exportAll") {
                $this->db->group_by('sh_id');
                $this->db->select('passeggero,telefono,email,indirizzo,provincia,data_nascita,comune,cap,regione,macro_regione,nazione,sesso,tipologia_passeggero,sistemazione,codice_destinazione');
            } else {
                if ($accumulative == 1)
                    $this->db->group_by('anno,tipologia_prodotto,' . $groupByCollaboratoreField);
                else
                    $this->db->group_by('anno,codice_prodotto,' . $groupByCollaboratoreField);
            }
        }
        else {
            if ($accumulative == 1)
                $this->db->group_by('anno,tipologia_prodotto,' . $groupByCollaboratoreField);
            else
                $this->db->group_by('anno,codice_prodotto,' . $groupByCollaboratoreField);
        }

        $this->db->select('count(*) as pax,SUM(costo_base) as fatturato,id_accompagnatore,id_collaboratore,anno,collaboratore,collaboratoreProvincia,collaboratoreNazione,collaboratoreRegione,collaboratoreMacroRegione,regione,macro_regione,nazione,codice_prodotto,tipologia_prodotto,destinazione,destinazione_nazione,azienda', false);
        if ($order_by != '')
            $this->db->order_by($order_by);


        if (!empty($get_data['fatturatoMax'])) {//!empty($get_data['fatturatoMin']) && 
            if ($get_data['fatturatoMax'] == "> 500000")
                $this->db->having("fatturato >= " . $get_data['fatturatoMin'], null, false);
            else
                $this->db->having("fatturato >= " . $get_data['fatturatoMin'] . " AND fatturato <= " . $get_data['fatturatoMax'], null, false);
        }

        // REPORT TYPE AS CORPORATE OR PROFESSORI
        if ($reportType == "professori")
            $this->db->where('id_azienda', 0);
        elseif ($reportType == "corporate")
            $this->db->where('id_azienda != ', 0);


        $query = $this->db->get($this->table_name);

        //echo $this -> db -> last_query();die;

        return $query->result_array();
    }

    public function getSummaryData($get_data, $order_by = '') {

        // THIS IS FOR COLLABORATORE FILTER
        // AS PER CORPORATE OR PROFESSORI
        // FILTER IS APPLIED ON collaboratore OR azienda
        $reportType = $get_data['reportType'];
        if ($reportType == "professori") {
            if ($get_data['collaboratore'] != '')
                $this->db->where('collaboratore', $get_data['collaboratore']);
        }
        elseif ($reportType == "corporate") {
            if ($get_data['collaboratore'] != '')
                $this->db->where('azienda', $get_data['collaboratore']);
        }

        if ($get_data['codice_prodotto'] != '')
            $this->db->where('codice_prodotto', $get_data['codice_prodotto']);
        if (!empty($get_data['tipologia_prodotto']))
            $this->db->where_in('tipologia_prodotto', $get_data['tipologia_prodotto']);
        if (!empty($get_data['destinazione_nazione']))
            $this->db->where_in('destinazione_nazione', $get_data['destinazione_nazione']);

        // COLLABORATORE FILTERS
        if (!empty($get_data['collaboratoreProvincia']))
            $this->db->where('collaboratoreProvincia', $get_data['collaboratoreProvincia']);
        if (!empty($get_data['collaboratoreNazione']))
            $this->db->where('collaboratoreNazione', $get_data['collaboratoreNazione']);
        if (!empty($get_data['collaboratoreRegione']))
            $this->db->where('collaboratoreRegione', $get_data['collaboratoreRegione']);
        if (!empty($get_data['collaboratoreMacroRegione']))
            $this->db->where('collaboratoreMacroRegione', $get_data['collaboratoreMacroRegione']);



        if (!empty($get_data['destinazione']))
            $this->db->where('destinazione', $get_data['destinazione']);
        if (!empty($get_data['anno']))
            $this->db->where('anno', $get_data['anno']);

        // CUSTOMER FILTERS
        if (!empty($get_data['regione'])) {
            $this->db->where('regione', $get_data['regione']);
        }
        if (!empty($get_data['macro_regione'])) {
            $this->db->where('macro_regione', $get_data['macro_regione']);
        }
        if (!empty($get_data['nazione'])) {
            $this->db->where('macro_regione', $get_data['nazione']);
        }

        // date of birth : age range filters
        if (!empty($get_data['ageStart']))
            $this->db->where('(datediff(data_partenza, data_nascita) / 365.25) >= ', $get_data['ageStart']);
        if (!empty($get_data['ageEnd']))
            $this->db->where('(datediff(data_partenza, data_nascita) / 365.25) <= ', $get_data['ageEnd']);

        //$this -> db -> where('id_accompagnatore = id_collaboratore');
        $this->db->group_by('destinazione_nazione,codice_destinazione');

        $this->db->select('tipologia_prodotto, destinazione_nazione,codice_destinazione,sum(costo_base) as fatturato');
        if ($order_by != '')
            $this->db->order_by($order_by);

        $query = $this->db->get($this->table_name);

        //echo $this -> db -> last_query();die;

        return $query->result_array();
    }

    function getCollaboratorePax($collaboratoreType, $collaboratore) {
        // $collaboratore = $this->db->escape_str($collaboratore);
        /* $this -> db -> query('SET SESSION group_concat_max_len = 1000000');
          if (!empty($collaboratore))
          $this -> db -> where('collaboratore', $collaboratore);
          $this -> db -> group_by('year(data_partenza)');
          $this -> db -> select("count(*) as pax,year(data_partenza) as traveling_year,collaboratore,
          @currYear:= year(data_partenza),@paxName:= group_concat(passeggero), collaboratore,(select count(DISTINCT(passeggero)) as old_pax from st_history where collaboratore = '".  addslashes($collaboratore)."' and FIND_IN_SET (passeggero,@paxName) and year(data_partenza) < @currYear) as 'old_pax'
          ", false);
          $this -> db -> order_by('year(data_partenza)','desc');

          if($collaboratoreType == "professori")
          $this->db->where('id_azienda',0);
          elseif($collaboratoreType == "corporate")
          $this->db->where('id_azienda != ',0);
          $query = $this -> db -> get($this -> table_name);
          //echo $this -> db -> last_query();die;
          return $query -> result_array(); */
        $resultArray = array();
        $this->db->query('SET SESSION group_concat_max_len = 1000000');
        $this->db->select("year(data_partenza) as traveling_year, collaboratore, azienda,count(DISTINCT(passeggero)) as pax_count,
                            group_concat(DISTINCT(passeggero)) as pax_names");

        if ($collaboratoreType == "professori") {
            if (!empty($collaboratore))
                $this->db->where('collaboratore', $collaboratore);
            $this->db->where("id_azienda = 0 AND azienda = ''");
        }
        elseif ($collaboratoreType == "corporate") {
            if (!empty($collaboratore))
                $this->db->where('azienda', $collaboratore);
            $this->db->where("id_azienda != 0 AND azienda != ''");
        }
        $this->db->group_by('year(data_partenza)');
        $this->db->order_by('year(data_partenza)', 'desc');
        $queryResultSet = $this->db->get($this->table_name);

        if ($queryResultSet->num_rows()) {
            $queryResultSet = $queryResultSet->result_array();
            foreach ($queryResultSet as $resultRow) {
                $paxNames = $resultRow['pax_names'];
                $paxCount = $resultRow['pax_count'];
                $travelingYear = $resultRow['traveling_year'];
                $collaboratoreName = "";
                if ($collaboratoreType == "professori")
                    $collaboratoreName = $resultRow['collaboratore'];
                else
                    $collaboratoreName = $resultRow['azienda'];
                $previousPaxCount = $this->getPreviousPaxCount($paxNames, $travelingYear, $collaboratore, $collaboratoreType);
                $childArray = array(
                    'traveling_year' => $travelingYear,
                    'collaboratore' => $collaboratoreName,
                    'pax' => $paxCount,
                    'old_pax' => $previousPaxCount,
                );
                array_push($resultArray, $childArray);
            }
        }
        return $resultArray;
    }

    function getPreviousPaxCount($paxNames, $currentYear, $collaboratore, $collaboratoreType) {
        $paxNames = explode(',', $paxNames);
        $this->db->select("COUNT(distinct(passeggero)) as pax_count");
        $this->db->where_in('passeggero', $paxNames);
        $this->db->where("year(data_partenza) < ", $currentYear);
        if ($collaboratoreType == "professori") {
            if (!empty($collaboratore))
                $this->db->where('collaboratore', $collaboratore);
            $this->db->where("id_azienda = 0 AND azienda = ''");
        }
        elseif ($collaboratoreType == "corporate") {
            if (!empty($collaboratore))
                $this->db->where('azienda', $collaboratore);
            $this->db->where("id_azienda != 0 AND azienda != ''");
        }
        $result = $this->db->get($this->table_name);

        $pax_count = $result->row()->pax_count;
        return $pax_count;
    }

    function getCompareProfessoriPaxDetails($annoYears, $collaboratoreArr, $exportAllRecords = false) {
        $this->db->select("year(data_partenza) as traveling_year, collaboratore, tipologia_prodotto,destinazione_nazione,COUNT(passeggero) as pax, SUM(costo_base) as fatturato");

        if (!empty($collaboratoreArr))
            $this->db->where_in('collaboratore', $collaboratoreArr);
        if (!empty($annoYears))
            $this->db->where_in('year(data_partenza)', $annoYears);
        $this->db->where("id_azienda = 0 AND azienda = ''");

        if (!$exportAllRecords)
            $this->db->group_by('collaboratore, year(data_partenza),tipologia_prodotto,destinazione_nazione');
        else {
            $this->db->select('passeggero,data_nascita,telefono,email,indirizzo,provincia,comune,cap,regione,macro_regione,nazione');
            $this->db->group_by('sh_id');
        }

        $this->db->order_by('year(data_partenza),collaboratore', 'desc');
        $queryResultSet = $this->db->get($this->table_name);

        return $queryResultSet->result_array();
    }

    function getCompareProfessoriSecond($annoYears, $collaboratoreArr, $exportAllRecords = false) {
        $this->db->select("year(data_partenza) as traveling_year, collaboratore, tipologia_prodotto,destinazione_nazione,COUNT(passeggero) as pax, SUM(costo_base) as fatturato");

        if (!empty($collaboratoreArr))
            $this->db->where_in('collaboratore', $collaboratoreArr);
        if (!empty($annoYears))
            $this->db->where_in('year(data_partenza)', $annoYears);
        $this->db->where("id_azienda = 0 AND azienda = ''");

        if (!$exportAllRecords)
            $this->db->group_by('collaboratore, year(data_partenza),tipologia_prodotto,destinazione_nazione');
        else {
            $this->db->select('passeggero,telefono,email,indirizzo,provincia,comune,cap,regione,macro_regione,nazione');
            $this->db->group_by('sh_id');
        }

        $this->db->order_by('year(data_partenza)', 'desc');
        $queryResultSet = $this->db->get($this->table_name);
        return $queryResultSet->result_array();
    }

    /**
     * this function return collaboaratore having zero pax booked for current year
     * @return type 
     */
    function getComProfCollaboratoreZeroPax() {
        $this->db->select('collaboratore,count(passeggero) as pax_count');
        $this->db->where("collaboratore != ''");
        $this->db->order_by('collaboratore');
        $this->db->group_by('collaboratore');
        //$this->db->having("pax_count",0);
        $this->db->where("anno = year(now())");
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }

    /**
     * this function returns count for pax against tiplogia prodotto, collaboratore, year and nation.
     * @param type $tipologiaProdotto
     * @param type $collaboarotore
     * @param type $year
     * @param type $nation
     * @return type 
     */
    function getTiplogiaCollaboratore($collaboratoreMacroRegione, $tipologiaProdotto, $collaboarotore, $year, $nation) {
        $this->db->where('collaboratoreMacroRegione', $collaboratoreMacroRegione);
        $this->db->where('collaboratore', $collaboarotore);
        $this->db->where('tipologia_prodotto', $tipologiaProdotto);
        $this->db->where('anno', $year);
        if (!empty($nation))
            $this->db->where('destinazione_nazione', $nation);
        $this->db->select('count(passeggero) as pax_count');
        $result = $this->db->get($this->table_name);
        return $result->row()->pax_count;
    }

    function getTiplogiaCollaboratoreChart($tipologiaProdotto, $colMacroRegion, $year, $destiNazione) {

        $this->db->query('SET SESSION group_concat_max_len = 1000000');
        $this->db->where('collaboratoreMacroRegione', $colMacroRegion);
        $this->db->where('tipologia_prodotto', $tipologiaProdotto);
        $this->db->select('group_concat(collaboratore) as collaboratore');
        $this->db->where("anno = year(now())");

        $result = $this->db->get($this->table_name);
        $collaboratoreData = $result->row()->collaboratore;
        $collaboratoreArr = explode(',', $collaboratoreData);

        $this->db->flush_cache();

        $this->db->where_not_in("collaboratore", $collaboratoreArr);
        $this->db->where('collaboratoreMacroRegione', $colMacroRegion);
        $this->db->where('tipologia_prodotto', $tipologiaProdotto);
        $this->db->where('anno', $year);
        $this->db->where('destinazione_nazione', $destiNazione);
        $this->db->select('count(passeggero) as pax_count');
        $result = $this->db->get($this->table_name);
        return $result->row()->pax_count;
    }

    /**
     * this function returns array of all collaboratore of collaboratore macro region
     * collaboaratore having zero pax booked for current year
     * @param type $tipologiaProdotto
     * @param type $selCollaboratoreMacroRegione
     * @return type 
     */
    function getCollaboratoreForMarcroRegion($tipologiaProdotto, $selCollaboratoreMacroRegione, $txtAnnoYears, $selDestinazioneNazione) {
        $this->db->query('SET SESSION group_concat_max_len = 1000000');
        $this->db->where_in('collaboratoreMacroRegione', $selCollaboratoreMacroRegione);
        $this->db->where('tipologia_prodotto', $tipologiaProdotto);
        $this->db->select('group_concat(collaboratore) as collaboratore');
        $this->db->where("anno = year(now())");

        $result = $this->db->get($this->table_name);
        $collaboratoreData = $result->row()->collaboratore;
        $collaboratoreArr = explode(',', $collaboratoreData);

        $this->db->flush_cache();

        $this->db->where_in('collaboratoreMacroRegione', $selCollaboratoreMacroRegione);
        $this->db->where('tipologia_prodotto', $tipologiaProdotto);
        $this->db->select('collaboratoreMacroRegione,collaboratore,count(passeggero) as pax_count');
        $this->db->where_in("anno", $txtAnnoYears);
        $this->db->where_in("destinazione_nazione", $selDestinazioneNazione);
        $this->db->having("pax_count > ", 0);
        $this->db->where("anno != year(now())");
        $this->db->where_not_in("collaboratore", $collaboratoreArr);
        $this->db->group_by("collaboratoreMacroRegione,collaboratore");
        $result = $this->db->get($this->table_name);

        return $result->result_array();
    }

    public function reportPaxCount($searchValue = "", $data) {
        $paxTravelArray = $paxDestinazioneArray = array();
        if (!empty($data['destinazione_nazione'])) {
            $this->db->select("DISTINCT(passeggero)");
            $this->db->where_in('destinazione_nazione', $data['destinazione_nazione']);
            $paxDestinazioneResult = $this->db->get($this->table_name);

            foreach ($paxDestinazioneResult->result_array() as $value) {
                $paxDestinazioneArray[] = $value['passeggero'];
            }
        }

        if ($data['timesPaxTravelled'] != "") {
            $this->db->select("COUNT(passeggero) as pax_travelled, passeggero, data_nascita");
            $this->db->where("passeggero != accompagnatore", NULL, FALSE);
            if ($data['tipologiaProdotto'] != "")
                $this->db->where("tipologia_prodotto", $data['tipologiaProdotto']);
            if (!empty($paxDestinazioneArray))
                $this->db->where_in('passeggero', $paxDestinazioneArray);
            $this->db->having("pax_travelled >= ", $data['timesPaxTravelled']);
            $this->db->group_by("passeggero, data_nascita");
            $paxResult = $this->db->get($this->table_name);
            foreach ($paxResult->result_array() as $value) {
                $paxTravelArray[] = $value['passeggero'] . '#' . $value['data_nascita'];
            }
        }

        if (empty($paxTravelArray))
            return 0;

        $this->db->select("sh_id");
        $this->db->where("passeggero != accompagnatore", NULL, FALSE);

        if ($searchValue != "") {
            $is_date = $this->_checkIsAValidDate($searchValue);

            $like_cond = '(';
            $columnsArray = array('passeggero', 'anno', 'data_partenza', 'telefono', 'email', 'data_nascita', 'indirizzo', 'provincia', 'comune', 'cap', 'regione', 'macro_regione', 'nazione', 'destinazione_nazione');
            foreach ($columnsArray as $column) {
                if ($column == "regione") {
                    if ($data['regione'] == "")
                        $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
                }
                else if ($column == "macro_regione") {
                    if ($data['macroRegione'] == "")
                        $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
                }
                else if ($column == "nazione") {
                    if ($data['nazione'] == "")
                        $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
                }
                else if ($column == "data_partenza" OR $column == "data_nascita") {
                    if ($is_date) {
                        $formatted_date = DateTime::createFromFormat('d/m/Y', $searchValue)->format('Y-m-d'); //date_format($searchValue,"Y-m-d");
                        $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($formatted_date) . '%"';
                    } else
                        $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
                }
                else
                if ($column == "passeggero")
                    $like_cond .= $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
                else
                    $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
            }
            $like_cond .= ')';
            $this->db->where($like_cond);
        }

        if ($data['tipologiaProdotto'] != "")
            $this->db->where("tipologia_prodotto", $data['tipologiaProdotto']);

        if ($data['timesPaxTravelled'] != "") {
            $this->db->where_in("concat_ws('#',passeggero,data_nascita)", $paxTravelArray);
            $this->db->order_by('passeggero');
        }

        if ($data['regione'] != "")
            $this->db->where('regione', $data['regione']);

        if ($data['macroRegione'] != "")
            $this->db->where('macro_regione', $data['macroRegione']);

        if ($data['nazione'] != "")
            $this->db->where('nazione', $data['nazione']);

        $ageOnField = "date(now())";
        if ($data['startAge'] != "")
            $this->db->where('(datediff(' . $ageOnField . ', data_nascita) / 365.25) >= ', $data['startAge']);
        if ($data['endAge'] != "")
            $this->db->where('(datediff(' . $ageOnField . ', data_nascita) / 365.25) <= ', $data['endAge']);

        // year filter
        if ($data['annoYear'] != "")
            $this->db->where('anno', $data['annoYear']);

        if ($data['clientiDiretti'] != "") {
            //$this->db->where('tipo_cliente', 'Cliente Diretto');
            //"nominativo_cliente" = "OPZN"
            //$this->db->where('id_opzione', 'OPZN');
            $this->db->where('id_collaboratore', '51879');
        }

        $result = $this->db->get($this->table_name);
        return $result->num_rows();
    }

    /**
     * this function returns array of all records from st history table
     */
    function reportPaxListing($iPageSize, $iRecordStartFrom, $aOrderByCondition, $searchValue, $data) {

        $paxTravelArray = $paxDestinazioneArray = array();
        if (!empty($data['destinazione_nazione'])) {
            $this->db->select("DISTINCT(passeggero)");
            $this->db->where_in('destinazione_nazione', $data['destinazione_nazione']);
            $paxDestinazioneResult = $this->db->get($this->table_name);

            foreach ($paxDestinazioneResult->result_array() as $value) {
                $paxDestinazioneArray[] = $value['passeggero'];
            }
        }

        if ($data['timesPaxTravelled'] != "") {
            $this->db->select("COUNT(passeggero) as pax_travelled, passeggero, data_nascita, SUM(costo_base) as fatturato");
            $this->db->where("passeggero != accompagnatore", NULL, FALSE);
            if ($data['tipologiaProdotto'] != "")
                $this->db->where("tipologia_prodotto", $data['tipologiaProdotto']);
            if (!empty($paxDestinazioneArray))
                $this->db->where_in('passeggero', $paxDestinazioneArray);
            $this->db->having("pax_travelled >= ", $data['timesPaxTravelled']);
            $this->db->group_by("passeggero, data_nascita");
            $paxResult = $this->db->get($this->table_name);
            foreach ($paxResult->result_array() as $value) {
                $paxTravelArray[] = $value['passeggero'] . '#' . $value['data_nascita'];
            }
        }

        if (empty($paxTravelArray))
            return array();

        $this->db->select("passeggero, anno, data_partenza, telefono, email, data_nascita, indirizzo, provincia, comune, cap, regione, macro_regione, nazione, destinazione_nazione,costo_base as fatturato,sesso,tipologia_passeggero,sistemazione,codice_destinazione,destinazione");
        $this->db->where("passeggero != accompagnatore", NULL, FALSE);

        if ($searchValue != "") {
            $is_date = $this->_checkIsAValidDate($searchValue);

            $like_cond = '(';
            $columnsArray = array('passeggero', 'anno', 'data_partenza', 'telefono', 'email', 'data_nascita', 'indirizzo', 'provincia', 'comune', 'cap', 'regione', 'macro_regione', 'nazione', 'destinazione_nazione');
            foreach ($columnsArray as $column) {
                if ($column == "regione") {
                    if ($data['regione'] == "")
                        $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
                }
                else if ($column == "macro_regione") {
                    if ($data['macroRegione'] == "")
                        $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
                }
                else if ($column == "nazione") {
                    if ($data['nazione'] == "")
                        $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
                }
                else if ($column == "data_partenza" OR $column == "data_nascita") {
                    if ($is_date) {
                        $formatted_date = DateTime::createFromFormat('d/m/Y', $searchValue)->format('Y-m-d');
                        $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($formatted_date) . '%"';
                    } else
                        $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
                }
                else
                if ($column == "passeggero")
                    $like_cond .= $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
                else
                    $like_cond .= ' OR ' . $column . ' LIKE "%' . $this->db->escape_like_str($searchValue) . '%"';
            }
            $like_cond .= ')';
            $this->db->where($like_cond);
        }

        if ($data['tipologiaProdotto'] != "")
            $this->db->where("tipologia_prodotto", $data['tipologiaProdotto']);

        if ($data['timesPaxTravelled'] != "") {
            $this->db->where_in("concat_ws('#',passeggero,data_nascita)", $paxTravelArray);
            if (empty($aOrderByCondition))
                $this->db->order_by('passeggero, data_nascita');
        }

        if ($data['regione'] != "")
            $this->db->where('regione', $data['regione']);

        if ($data['macroRegione'] != "")
            $this->db->where('macro_regione', $data['macroRegione']);

        if ($data['nazione'] != "")
            $this->db->where('nazione', $data['nazione']);

        $ageOnField = "date(now())";
        if ($data['startAge'] != "")
            $this->db->where('(datediff(' . $ageOnField . ', data_nascita) / 365.25) >= ', $data['startAge']);
        if ($data['endAge'] != "")
            $this->db->where('(datediff(' . $ageOnField . ', data_nascita) / 365.25) <= ', $data['endAge']);

        // year filter
        if ($data['annoYear'] != "")
            $this->db->where('anno', $data['annoYear']);

        if ($data['clientiDiretti'] != "") {
            //$this->db->where('tipo_cliente', 'Cliente Diretto');
            //"nominativo_cliente" = "OPZN"
            //$this->db->where('id_opzione', 'OPZN');
            $this->db->where('id_collaboratore', '51879');
        }

        if (!empty($aOrderByCondition))
            $this->db->order_by($aOrderByCondition['column_name'], $aOrderByCondition['order_by']);

        if ($iPageSize != 0)
            $this->db->limit($iPageSize, $iRecordStartFrom);

        $result = $this->db->get($this->table_name);
        //echo $this->db->last_query();die;
        return ( $result->num_rows() > 0 ) ? $result->result_array() : array();
    }

    private function _checkIsAValidDate($date) {
        $d = DateTime::createFromFormat('d/m/Y', $date);
        return $d && $d->format('d/m/Y') === $date;
    }

    public function getReportDataProfessori($get_data, $params = array()) {
        $this->setSearchParamProfessori($get_data, "collaboratore");
        if ($get_data['collaboratore'] != '')
            $this->db->where('collaboratore', $get_data['collaboratore']);

        $this->db->select('count(*) as pax,SUM(costo_base) as fatturato,id_accompagnatore,id_collaboratore,anno,collaboratore,collaboratoreProvincia,collaboratoreNazione,collaboratoreRegione,collaboratoreMacroRegione,regione,macro_regione,nazione,codice_prodotto,tipologia_prodotto,destinazione,destinazione_nazione,azienda', false);
        $this->db->limit($params['offset'], $params['start']);
        $this->db->order_by($params['column'], $params['type']);
        $this->db->where('id_azienda', 0);
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }

    public function getReportDataProfessoriCount($get_data, $params = array()) {
        $this->db->select('COUNT(*)');
        $this->db->from($this->table_name);
        $this->setSearchParamProfessori($get_data, "collaboratore");

        if ($get_data['collaboratore'] != '')
            $this->db->where('collaboratore', $get_data['collaboratore']);

        if (!empty($get_data['fatturatoMax'])) {
            $this->db->select('SUM(costo_base) as fatturato');
        }
        $this->db->where('id_azienda', 0);
        $sql = $this->db->_compile_select();
        $query = $this->db->query('SELECT COUNT(*) as count FROM(' . $sql . ')as count');
        return $query->row()->count;
    }

    public function getReportDataCorporate($get_data, $params = array()) {
        $this->setSearchParamProfessori($get_data, "azienda");
        if ($get_data['collaboratore'] != '') {
            $this->db->where('azienda', $get_data['collaboratore']);
        }
        $this->db->where('id_azienda !=', 0);

        $this->db->select('count(*) as pax,SUM(costo_base) as fatturato,id_accompagnatore,id_collaboratore,anno,collaboratore,collaboratoreProvincia,collaboratoreNazione,collaboratoreRegione,collaboratoreMacroRegione,regione,macro_regione,nazione,codice_prodotto,tipologia_prodotto,destinazione,destinazione_nazione,azienda', false);
        $this->db->limit($params['offset'], $params['start']);
        $this->db->order_by($params['column'], $params['type']);

        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }

    public function getReportDataCorporateCount($get_data, $params = array()) {
        $this->db->select('COUNT(*)');
        $this->db->from($this->table_name);
        $this->setSearchParamProfessori($get_data, "azienda");

        if ($get_data['collaboratore'] != '')
            $this->db->where('collaboratore', $get_data['collaboratore']);

        if (!empty($get_data['fatturatoMax'])) {
            $this->db->select('SUM(costo_base) as fatturato');
        }
        $this->db->where('id_azienda !=', 0);
        $sql = $this->db->_compile_select();
        $query = $this->db->query('SELECT COUNT(*) as count FROM(' . $sql . ')as count');
        return $query->row()->count;
    }

    private function setSearchParamProfessori($get_data, $groupByCollaboratoreField) {
        $accumulative = 0;
        if (isset($get_data['accumulative']))
            $accumulative = $get_data['accumulative'];
        $checkagetoday = 0;
        if (isset($get_data['checkagetoday']))
            $checkagetoday = $get_data['checkagetoday'];

        if ($get_data['codice_prodotto'] != '')
            $this->db->where('codice_prodotto', $get_data['codice_prodotto']);
        if (!empty($get_data['tipologia_prodotto']))
            $this->db->where_in('tipologia_prodotto', $get_data['tipologia_prodotto']);
        if (!empty($get_data['destinazione_nazione']))
            $this->db->where_in('destinazione_nazione', $get_data['destinazione_nazione']);

        // COLLABORATORE FILTERS
        if (!empty($get_data['collaboratoreProvincia']))
            $this->db->where('collaboratoreProvincia', $get_data['collaboratoreProvincia']);
        if (!empty($get_data['collaboratoreNazione']))
            $this->db->where('collaboratoreNazione', $get_data['collaboratoreNazione']);
        if (!empty($get_data['collaboratoreRegione']))
            $this->db->where('collaboratoreRegione', $get_data['collaboratoreRegione']);
        if (!empty($get_data['collaboratoreMacroRegione']))
            $this->db->where('collaboratoreMacroRegione', $get_data['collaboratoreMacroRegione']);


        if (!empty($get_data['destinazione']))
            $this->db->where('destinazione', $get_data['destinazione']);
        if (!empty($get_data['anno']))
            $this->db->where('anno', $get_data['anno']);


        // CUSTOMER FILTERS
        //$strWhereCustomers = "";
        if (!empty($get_data['regione'])) {
            $this->db->where('regione', $get_data['regione']);
        }
        if (!empty($get_data['macro_regione'])) {
            $this->db->where('macro_regione', $get_data['macro_regione']);
        }
        if (!empty($get_data['nazione'])) {
            $this->db->where('nazione', $get_data['nazione']);
        }

        $ageOnField = "data_partenza";
        if ($checkagetoday)
            $ageOnField = "date(now())";

        if (!empty($get_data['ageStart']))
            $this->db->where('(datediff(' . $ageOnField . ', data_nascita) / 365.25) >= ', $get_data['ageStart']);
        if (!empty($get_data['ageEnd']))
            $this->db->where('(datediff(' . $ageOnField . ', data_nascita) / 365.25) <= ', $get_data['ageEnd']);

        if ($accumulative == 1)
            $this->db->group_by('anno,tipologia_prodotto,' . $groupByCollaboratoreField);
        else
            $this->db->group_by('anno,codice_prodotto,' . $groupByCollaboratoreField);

        if (!empty($get_data['fatturatoMax'])) {//!empty($get_data['fatturatoMin']) && 
            if ($get_data['fatturatoMax'] == "> 500000")
                $this->db->having("fatturato >= " . $get_data['fatturatoMin'], null, false);
            else
                $this->db->having("fatturato >= " . $get_data['fatturatoMin'] . " AND fatturato <= " . $get_data['fatturatoMax'], null, false);
        }

        if (!empty($get_data['search'])) {
            $this->db->where($groupByCollaboratoreField . ' LIKE "%' . mysql_real_escape_string($get_data['search']) . '%"');
        }
    }

    /* temporory not required. */
//        function getComProfTipologia($collaboratore){
//            $this -> db -> select('tipologia_prodotto');
//            $this->db->where("tipologia_prodotto != ''");
//            $this->db->where_in("collaboratore",$collaboratore);
//            $this -> db -> order_by('tipologia_prodotto');
//            $query = $this -> db -> get($this -> table_name);
//            return $query -> result_array();
//        }
}

//End Sthistory model
?>