<?php

/**
 * @Programmer  : Preeti M
 * @Maintainer  : Preeti M
 * @Created     : 17 June 2016
 * @Modified    :
 * @Description : Webservice model
 */
Class Webservicemodel extends Model {

    var $table_name = "webservice_book";

    function __construct() {
        parent::__construct();
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
    public function getDistinctDataByField($field_name) {

        $this->db->select($field_name);
        $this->db->distinct();
        $this->db->order_by($field_name);
        $this->db->where($field_name . " != ''");
        $query = $this->db->get($this->table_name);

        return $query->result_array();
    }

    /**
     * getReportData
     * This function returns report data
     * @param array - containing all field data that need to searched
     * @return array
     */
    public function getReportData($get_data) {

        if ($get_data['accompagnatore'] != '')
            $this->db->where('accompagnatore', $get_data['accompagnatore']);
        if ($get_data['collaboratore'] != '')
            $this->db->where('collaboratore', $get_data['collaboratore']);
        if ($get_data['prodotto'] != '')
            $this->db->like('prodotto', $get_data['prodotto']);
        if ($get_data['codice_prodotto'] != '')
            $this->db->where('codice_prodotto', $get_data['codice_prodotto']);
        if ($get_data['passeggero'] != '')
            $this->db->like('passeggero', $get_data['passeggero']);
        if ($get_data['tipologia_passeggero'] != '')
            $this->db->where('tipologia_passeggero', $get_data['tipologia_passeggero']);
        if ($get_data['glf'] != '')
            $this->db->where('glf', $get_data['glf']);

        $this->db->select('book_id, accompagnatore, collaboratore, prodotto, codice_prodotto, passeggero, tipologia_passeggero, glf, costo_base, importo_tasse_volo, importo_aeroporto_aggiuntivo, supplementi, pagamenti');
        $query = $this->db->get($this->table_name);

        return $query->result_array();
    }

    /**
     * getGlReportData
     * This function returns gl report data
     * @param string - collaboratore
     * @param string - accompagnatore
     * @return array
     */
    public function getGlReportData($collaboratore, $accompagnatore) {

        $select = "TRIM(collaboratore) as collaboratore,
                TRIM(accompagnatore) as accompagnatore,
                prodotto,
                codice_prodotto,
                group_concat(passeggero) as passeggero,
                Count(*) AS total_rows_including_gl,
                Sum(CASE tipologia_passeggero
                    WHEN 'GL' THEN 0
                    ELSE 1
                  end) AS total_rows_excluding_gl,
                Sum(CASE
                    WHEN tipologia_passeggero != 'GL' THEN (
                      CASE
                        WHEN glf != 'SI' THEN 1
                        ELSE 0
                      end )
                    ELSE 0
                  end) AS total_rows_excluding_gl_si,
                Sum(CASE
                      WHEN tipologia_passeggero != 'GL' THEN ( CASE
                        WHEN glf != 'SI' THEN ( CASE
                                                  WHEN costo_base + importo_tasse_volo
                                                          + importo_aeroporto_aggiuntivo +
                                                          supplementi
                                                          - pagamenti <= 2 THEN 1
                                                  ELSE 0
                                              end )
                        ELSE 0
                      end )
                    ELSE 0
                  end) AS total_rows_cleared,
                  Sum(CASE tipologia_passeggero
                    WHEN 'GL' THEN 1
                    ELSE 0
                  end) AS total_gl_rows,
                  costo_base,
                  group_concat(
                  CASE
                    WHEN tipologia_passeggero != 'GL' THEN (
                      CASE glf
                        WHEN 'SI' THEN ( -(round(costo_base+supplementi+importo_tasse_volo+importo_aeroporto_aggiuntivo-pagamenti,2)) )
                      END )
                  END) AS si_rows";
        $this->db->select($select, FALSE);

        if ($accompagnatore != 'All')
            $this->db->where("TRIM(accompagnatore)", trim($accompagnatore));
        $this->db->where("TRIM(collaboratore)", trim($collaboratore));

        $this->db->group_by("codice_prodotto");

        $query = $this->db->get($this->table_name);
       // echo $this->db->last_query();die;
        return $query->result_array();
    }

    /**
     * eligibilityCriteria
     * This function returns max from min pax for Different Countries for service specified
     * @param string - service
     * @return array
     */
    public function eligibilityCriteria($service) {
        $this->db->select("Min(min_pax) as min_pax, country");
        $this->db->from("pax_level");
        $this->db->where("service", "$service");
        $this->db->group_by("country");

        $query = $this->db->get();
        $result = $query->result_array();
        if (!empty($result)) {
            $res = array();
            foreach ($result as $value) {
                $res[$value['country']] = $value['min_pax'];
            }
            return $res;
        } else {
            return array();
        }
    }

    /**
     * getAccompagnatoreFromCollaboratore
     * This function returns accompagnatore for a specific collaboratore
     * @param string - collaboratore
     * @return array
     */
    public function getAccompagnatoreFromCollaboratore($collaboratore) {

        $result = array();
        $this->db->select("DISTINCT(accompagnatore)");
        $this->db->where("collaboratore", $collaboratore);

        $query = $this->db->get('webservice_book');

        foreach ($query->result_array() as $value) {
            array_push($result, $value['accompagnatore']);
        }
        return $result;
    }

    /**
     * getReportTableData
     * This function returns data from pax_level table
     * @param string - codice_prodotto
     * @param string - pax
     * @return array
     */
    public function getReportTableData($codice_prodotto, $pax) {

        $select = "product, GROUP_CONCAT(accomodation) as accomodation, country, level, service, reimbursement";
        $this->db->select($select);
        $this->db->where("product", $codice_prodotto);
        $this->db->where("$pax BETWEEN min_pax AND max_pax", NULL, FALSE);
        $this->db->group_by('service');
        $query = $this->db->get('pax_level');

        $result = $query->result_array();
        return (!empty($result) ) ? $result : array();
    }

    /**
     * getCountryForProduct
     * This function returns country for specific product from pax_level table
     * @param string - codice_prodotto
     * @param string - pax
     * @return string - country
     */
    public function getCountryForProduct($codice_prodotto) {

        $this->db->select("country");
        $this->db->where("product", $codice_prodotto);
        $this->db->limit(1);

        $query = $this->db->get('pax_level');

        $result = $query->row();
        if (!empty($result))
            return $query->row()->country;
        else
            return '';
    }

    /**
     * getMagicBonusTrinityRows
     * This function returns country for specific product from pax_level table
     * @param string - codice_prodotto
     * @param string - collaboratore
     * @param string - accompagnatore
     * @return array
     */
    public function getMagicBonusTrinityRows($codice_prodotto, $collaboratore, $accompagnatore) {
        $select = "Sum(CASE
                    WHEN tipologia_passeggero != 'GL' THEN (
                      CASE
                        WHEN glf != 'SI' THEN(
                          CASE
                            WHEN ( magic_eu = 1
                              OR sup_magic_eu = 1
                              OR magic_usa = 1
                              OR sup_magic_usa = 1 ) THEN 1
                            ELSE 0
                          end
                        )
                        ELSE 0
                      end
                    )
                    ELSE 0
                  end) AS bonus_rows_cnt,
                Sum(trinity) AS trinity_rows_cnt,
                CASE
                  WHEN (
                    costo_base+importo_tasse_volo+importo_aeroporto_aggiuntivo+supplementi-pagamenti ) <=2 THEN 1
                  ELSE 0
                END as std_cleared";
        $this->db->select($select);
        $this->db->where("accompagnatore", $accompagnatore);
        $this->db->where("collaboratore", $collaboratore);
        $this->db->where("codice_prodotto", $codice_prodotto);
        $this->db->having("std_cleared", "1");
        $this->db->limit(1);

        $query = $this->db->get($this->table_name);
        return $query->row_array();
    }

    /**
     * getPasseggero
     * This function returns passeggero
     * @param string - collaboratore
     * @param string - accompagnatore
     * @param string - codice_prodotto
     * @return array
     */
    public function getPasseggero($collaboratore, $accompagnatore, $codice_prodotto) {

        $select = "Group_concat(CASE
                WHEN tipologia_passeggero != 'GL' THEN ( CASE
                  WHEN glf != 'SI' THEN ( CASE
                    WHEN
                      costo_base + importo_tasse_volo
                      + importo_aeroporto_aggiuntivo +
                      supplementi
                      - pagamenti <= 2 THEN
                      passeggero
                    END )
                  END )
                END) AS passeggero";
        $this->db->select($select, FALSE);

        $this->db->like("accompagnatore", $accompagnatore);
        $this->db->like("collaboratore", $collaboratore);
        $this->db->where("codice_prodotto", $codice_prodotto);
        $this->db->limit(1);

        $query = $this->db->get($this->table_name);
        return $query->row_array();
    }

    /**
     * getPasseggeroSi
     * This function returns passeggero
     * @param string - collaboratore
     * @param string - accompagnatore
     * @param string - codice_prodotto
     * @return array
     */
    public function getPasseggeroSi($collaboratore, $accompagnatore, $codice_prodotto) {

        $select = "Group_concat(CASE
                WHEN glf = 'SI' THEN
                  passeggero
                END ) AS passeggero";
        $this->db->select($select, FALSE);

        $this->db->like("accompagnatore", $accompagnatore);
        $this->db->like("collaboratore", $collaboratore);
        $this->db->where("codice_prodotto", $codice_prodotto);
        $this->db->limit(1);

        $query = $this->db->get($this->table_name);
        return $query->row_array();
    }

    public function paginateReportData($get_data, $params) {

        if ($get_data['accompagnatore'] != '')
            $this->db->where('accompagnatore', $get_data['accompagnatore']);
        if ($get_data['collaboratore'] != '')
            $this->db->where('collaboratore', $get_data['collaboratore']);
        if ($get_data['prodotto'] != '')
            $this->db->like('prodotto', $get_data['prodotto']);
        if ($get_data['codice_prodotto'] != '')
            $this->db->where('codice_prodotto', $get_data['codice_prodotto']);
        if ($get_data['passeggero'] != '')
            $this->db->like('passeggero', $get_data['passeggero']);
        if ($get_data['tipologia_passeggero'] != '')
            $this->db->where('tipologia_passeggero', $get_data['tipologia_passeggero']);
        if ($get_data['glf'] != '')
            $this->db->where('glf', $get_data['glf']);

        $this->db->select('book_id, accompagnatore, collaboratore, prodotto, '
                . 'codice_prodotto, passeggero, tipologia_passeggero, glf, costo_base, '
                . 'importo_tasse_volo, importo_aeroporto_aggiuntivo, supplementi, pagamenti,'
                . '(costo_base+importo_tasse_volo+importo_aeroporto_aggiuntivo+supplementi) as total_due,'
                . '((costo_base+importo_tasse_volo+importo_aeroporto_aggiuntivo+supplementi)-pagamenti) as balance');
        $this->db->limit($params['offset'], $params['start']);
        $this->db->order_by($params['column'], $params['type']);
        $query = $this->db->get($this->table_name);

        return $query->result_array();
    }

    public function getReportCount($get_data) {

        if ($get_data['accompagnatore'] != '')
            $this->db->where('accompagnatore', $get_data['accompagnatore']);
        if ($get_data['collaboratore'] != '')
            $this->db->where('collaboratore', $get_data['collaboratore']);
        if ($get_data['prodotto'] != '')
            $this->db->like('prodotto', $get_data['prodotto']);
        if ($get_data['codice_prodotto'] != '')
            $this->db->where('codice_prodotto', $get_data['codice_prodotto']);
        if ($get_data['passeggero'] != '')
            $this->db->like('passeggero', $get_data['passeggero']);
        if ($get_data['tipologia_passeggero'] != '')
            $this->db->where('tipologia_passeggero', $get_data['tipologia_passeggero']);
        if ($get_data['glf'] != '')
            $this->db->where('glf', $get_data['glf']);
        $this->db->from($this->table_name);
        return $this->db->count_all_results();
    }

}

//End Webservice model
?>