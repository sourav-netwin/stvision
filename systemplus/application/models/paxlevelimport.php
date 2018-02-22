<?php

class Paxlevelimport extends Model {

    public function insert($paxInfo) {
        foreach ($paxInfo as $info) {
            $this->db->insert('pax_level', $info);
        }
    }

}
