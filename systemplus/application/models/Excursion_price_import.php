<?php

class Excursion_price_import extends Model {

    public function companyExists($company) {
        $this->db->from('plused_tra_companies');
        $this->db->where('tra_cp_name', trim($company));
        $res = $this->db->get();
        $res = $res->row();
        return $res;
    }

    public function busTypeExists($companyId, $busType) {
        if (strpos($busType, 'Standard') === false) {
            $busType = intval($busType);
            $seater = $busType . ' seater';
            $seats = $busType . ' seats';
        } else {
            $seater = $busType;
            $seats = $busType;
        }
        $this->db->from('plused_tra_bus');
        $this->db->where('tra_bus_cp_id', $companyId);
        $this->db->where('(tra_bus_name = "' . $seats . '" OR tra_bus_name = "' . $seater . '")');
        $res = $this->db->get();
        $res = $res->row();
        return $res;
    }

    public function addCompany($company) {
        $data = array('tra_cp_name' => $company, 'tra_cp_email' => '', 'tra_cp_emergency' => '');
        $this->db->insert('plused_tra_companies', $data);
        return $this->db->insert_id();
    }

    public function addBusType($companyId, $busType) {
        $data = array(
            'tra_bus_cp_id' => $companyId,
            'tra_bus_name' => $busType,
            'tra_bus_seat' => intval($busType),
            'tra_bus_cost' => 0.00,
            'tra_bus_currency' => 'B',
        );
        $this->db->insert('plused_tra_bus', $data);
        return $this->db->insert_id();
    }

    public function getCampus($campus) {
        $this->db->select('id, nome_centri as name');
        $this->db->from('centri');
        $this->db->where('nome_centri', trim($campus));
        $res = $this->db->get();
        $res = $res->row();
        return $res;
    }

    public function getExcursion($excursion, $week, $length, $type, $campus, $excursionType) {
        $this->db->from('plused_exc_all');
        $this->db->where('exc_id_centro', $campus);
        $this->db->where('exc_excursion', trim($excursion));
        $this->db->where('exc_weeks', $week);
        $this->db->where('exc_length', trim($length));
        $this->db->where('exc_type', $type);
        $this->db->where('exc_transfer_type', $excursionType);
        $res = $this->db->get();
        $res = $res->row();
        return $res;
    }

    public function insertJoin($data) {
        return $this->db->insert('plused_exc_join', $data);
    }

}
