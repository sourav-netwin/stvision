<?php

class Enrol_model extends Model {

    function insertBook($weeks) {
        $st_ensuite = $this->input->xss_clean($this->input->post('st_ensuite'));
        $st_standard = $this->input->xss_clean($this->input->post('st_standard'));
        $st_homestay = $this->input->xss_clean($this->input->post('st_homestay'));
        $st_twin = $this->input->xss_clean($this->input->post('st_twin'));
        $gl_ensuite = $this->input->xss_clean($this->input->post('gl_ensuite'));
        $gl_standard = $this->input->xss_clean($this->input->post('gl_standard'));
        $gl_homestay = $this->input->xss_clean($this->input->post('gl_homestay'));
        $gl_twin = $this->input->xss_clean($this->input->post('gl_twin'));
        $tot_pax = $st_ensuite + $st_standard + $st_homestay + $st_twin + $gl_ensuite + $gl_standard + $gl_homestay + $gl_twin;
        $arr = explode("/", $this->input->post('arrival_date'));
        $data_arrivo = $arr[2] . "-" . $arr[0] . "-" . $arr[1];
        $arr2 = explode("/", $this->input->post('departure_date'));
        $data_partenza = $arr2[2] . "-" . $arr2[0] . "-" . $arr2[1];
        $data = array(
            'id_prodotto' => $this->input->xss_clean($this->input->post('prod_select')),
            'id_centro' => $this->input->xss_clean($this->input->post('center_select')),
            'id_agente' => $this->session->userdata('id'),
            'arrival_date' => $data_arrivo,
            'departure_date' => $data_partenza,
            'weeks' => $weeks,
            'tot_pax' => $tot_pax,
            'id_year' => date("Y")
        );
        $this->db->insert('plused_book', $data);
        return $this->db->insert_id();
    }

    function insertRows($book_id, $anno, $id_agente) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $st_ensuite = $this->input->xss_clean($this->input->post('st_ensuite'));
        $st_standard = $this->input->xss_clean($this->input->post('st_standard'));
        $st_homestay = $this->input->xss_clean($this->input->post('st_homestay'));
        $st_twin = $this->input->xss_clean($this->input->post('st_twin'));
        $gl_ensuite = $this->input->xss_clean($this->input->post('gl_ensuite'));
        $gl_standard = $this->input->xss_clean($this->input->post('gl_standard'));
        $gl_homestay = $this->input->xss_clean($this->input->post('gl_homestay'));
        $gl_twin = $this->input->xss_clean($this->input->post('gl_twin'));
        $arr = explode("/", $this->input->post('arrival_date'));
        $data_arrivo = $arr[2] . "-" . $arr[0] . "-" . $arr[1];
        $arr2 = explode("/", $this->input->post('departure_date'));
        $data_partenza = $arr2[2] . "-" . $arr2[0] . "-" . $arr2[1];

        for ($x = 0; $x < $st_ensuite; $x++) {
            $newpwd = "";
            do {
                $newpwd = $this->GESTgenerateUUID();
                $i = $this->GESTcheckUUID($newpwd);
            } while ($i > 0);
            //AGENTE STUDYTOURS, NON INSERISCO UUID
            if ($id_agente == 795)
                $newpwd = "";
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
        for ($x = 0; $x < $st_standard; $x++) {
            $newpwd = "";
            do {
                $newpwd = $this->GESTgenerateUUID();
                $i = $this->GESTcheckUUID($newpwd);
            } while ($i > 0);
            //AGENTE STUDYTOURS, NON INSERISCO UUID
            if ($id_agente == 795)
                $newpwd = "";
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
        for ($x = 0; $x < $st_homestay; $x++) {
            $newpwd = "";
            do {
                $newpwd = $this->GESTgenerateUUID();
                $i = $this->GESTcheckUUID($newpwd);
            } while ($i > 0);
            //AGENTE STUDYTOURS, NON INSERISCO UUID
            if ($id_agente == 795)
                $newpwd = "";
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
        for ($x = 0; $x < $st_twin; $x++) {
            $newpwd = "";
            do {
                $newpwd = $this->GESTgenerateUUID();
                $i = $this->GESTcheckUUID($newpwd);
            } while ($i > 0);
            //AGENTE STUDYTOURS, NON INSERISCO UUID
            if ($id_agente == 795)
                $newpwd = "";
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
        for ($x = 0; $x < $gl_ensuite; $x++) {
            $newpwd = "";
            do {
                $newpwd = $this->GESTgenerateUUID();
                $i = $this->GESTcheckUUID($newpwd);
            } while ($i > 0);
            //AGENTE STUDYTOURS, NON INSERISCO UUID
            if ($id_agente == 795)
                $newpwd = "";
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
        for ($x = 0; $x < $gl_standard; $x++) {
            $newpwd = "";
            do {
                $newpwd = $this->GESTgenerateUUID();
                $i = $this->GESTcheckUUID($newpwd);
            } while ($i > 0);
            //AGENTE STUDYTOURS, NON INSERISCO UUID
            if ($id_agente == 795)
                $newpwd = "";
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
        for ($x = 0; $x < $gl_homestay; $x++) {
            $newpwd = "";
            do {
                $newpwd = $this->GESTgenerateUUID();
                $i = $this->GESTcheckUUID($newpwd);
            } while ($i > 0);
            //AGENTE STUDYTOURS, NON INSERISCO UUID
            if ($id_agente == 795)
                $newpwd = "";
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
        for ($x = 0; $x < $gl_twin; $x++) {
            $newpwd = "";
            do {
                $newpwd = $this->GESTgenerateUUID();
                $i = $this->GESTcheckUUID($newpwd);
            } while ($i > 0);
            //AGENTE STUDYTOURS, NON INSERISCO UUID
            if ($id_agente == 795)
                $newpwd = "";
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

    function GESTgenerateUUID() {
        $length = 12;
        $temp = array();
        $exec = array();
        $alpha_upper = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $exec[] = 1;
        $alpha_lower = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $exec[] = 2;
        $number = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $exec[] = 3;
        $exec_count = count($exec) - 1;
        $input_index = 0;
        for ($i = 1; $i <= $length; $i++) {
            switch ($exec[$input_index]) {
                case 1:
                    shuffle($alpha_upper);
                    $temp[] = $alpha_upper[0];
                    unset($alpha_upper[0]);
                    break;

                case 2:
                    shuffle($alpha_lower);
                    $temp[] = $alpha_lower[0];
                    unset($alpha_lower[0]);
                    break;

                case 3:
                    shuffle($number);
                    $temp[] = $number[0];
                    unset($number[0]);
                    break;
            }
            if ($input_index < $exec_count) {
                $input_index++;
            } else {
                $input_index = 0;
            }
        }
        shuffle($temp);
        $password = implode($temp);
        return $password;
    }

    function GESTcheckUUID($password) {
        $this->db->where('uuid', $password);
        $this->db->from('plused_rows');
        return $this->db->count_all_results();
    }

}

?>
