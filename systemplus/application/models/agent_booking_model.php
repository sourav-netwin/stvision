<?php

class Agent_booking_model extends Model {

    function agent_booking_model() {
        parent::Model();
    }

    function buildCampusByProgramId($idProgramma, $attivi = 0) {
        $this->db->from('centri');
        $this->db->join('plused_join_prodotti_centri', 'centri.id = plused_join_prodotti_centri.pjpc_centro');
        $this->db->where('plused_join_prodotti_centri.pjpc_prodotto', $idProgramma);
        if ($attivi == 1)
            $this->db->where('centri.attivo', 1);
        $this->db->order_by('centri.nome_centri', "asc");
        $query = $this->db->get();
        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }

    function getPackages($center, $user_id) {
        $sql = "SELECT *
						FROM
						(
							SELECT p.pack_package_id, p.pack_package
							FROM agnt_packages p
							WHERE p.pack_campus_id = ?
							AND p.pack_for_location = 0

							UNION

							SELECT p.pack_package_id, p.pack_package
							FROM agnt_packages p
							JOIN agnt_package_agents a ON a.pagnt_package_id = p.pack_package_id AND a.pagnt_agent_id = ?
							WHERE p.pack_campus_id = ?
							AND p.pack_for_location = 1
						) a
						ORDER BY a.pack_package
						";
        $query = $this->db->query($sql, array($center, $user_id, $center));
        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }

    function getAccomodations() {
        $this->db->select("*");
        $this->db->from("agnt_accommodation");
        $this->db->order_by("accom_name");
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }

    function findPackageAccomodation($package) {
        $this->db->select("a.accom_id, a.accom_name");
        $this->db->from("agnt_package_services s");
        $this->db->join("agnt_accommodation a", "a.accom_id = s.serv_service_id");
        $this->db->where("s.serv_package_id", $package);
        $this->db->where("serv_service_type", "Accommodation");
        $this->db->order_by("accom_name");
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }

    function findPackageComposition($package) {
        $this->db->select("pcomp_id");
        $this->db->from("agnt_package_compositions");
        $this->db->where("pcomp_package_id", $package);
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }

    function enrol_agent_booking($insert_data) {
        $this->db->insert('agnt_enrol_bookings', $insert_data);
        return $this->db->insert_id();
    }

    function booked_pax($enroll_id, $package_id, $id_agente, $arrival_date, $departure_date) {
        $package_composition = $this->findPackageComposition($package_id);

        foreach ($package_composition as $pc) {
            $comp = $pc['pcomp_id'];
            $value = $this->input->post('st_' . $comp);

            if ($value > 0) {
                for ($x = 0; $x < $value; $x++) {
                    $newpwd = "";
                    do {
                        $newpwd = $this->GESTgenerateUUID();
                        $i = $this->GESTcheckUUID($newpwd);
                    } while ($i > 0);

                    //AGENTE STUDYTOURS, NON INSERISCO UUID
                    if ($id_agente == 795)
                        $newpwd = "";

                    $data = array(
                        'booked_enroll_id' => $enroll_id,
                        'booked_package_composition' => $comp,
                        'booked_tipo_pax' => 'STD',
                        'booked_pax_campus_arrival_date' => $arrival_date,
                        'booked_pax_campus_departure_date' => $departure_date,
                        'booked_pax_arrival_flight_date' => $arrival_date,
                        'booked_pax_departure_flight_date' => $departure_date,
                        'booked_uuid' => $newpwd
                    );
                    $this->db->insert('agnt_booked_pax', $data);
                }
            }
        }

        $package_accomodation = $this->findPackageAccomodation($package_id);
        foreach ($package_accomodation as $pa) {
            $accom = $pa['accom_id'];
            $value = $this->input->post('gl_' . $accom);
            $free_gl_value = $this->input->post('free_gl_' . $accom);

            if ($value > 0) {
                $free_gl_cnt = 0;
                for ($x = 0; $x < $value; $x++) {
                    $free_gl_cnt++;
                    $newpwd = "";
                    do {
                        $newpwd = $this->GESTgenerateUUID();
                        $i = $this->GESTcheckUUID($newpwd);
                    } while ($i > 0);

                    //AGENTE STUDYTOURS, NON INSERISCO UUID
                    if ($id_agente == 795)
                        $newpwd = "";

                    $is_free = ( $free_gl_value >= $free_gl_cnt ) ? '1' : '0';
                    $data = array(
                        'booked_enroll_id' => $enroll_id,
                        'booked_package_accomodation' => $accom,
                        'booked_tipo_pax' => 'GL',
                        'booked_is_free' => $is_free,
                        'booked_pax_campus_arrival_date' => $arrival_date,
                        'booked_pax_campus_departure_date' => $departure_date,
                        'booked_pax_arrival_flight_date' => $arrival_date,
                        'booked_pax_departure_flight_date' => $departure_date,
                        'booked_uuid' => $newpwd
                    );
                    $this->db->insert('agnt_booked_pax', $data);
                }
            }
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
        $this->db->where('booked_uuid', $password);
        $this->db->from('agnt_booked_pax');
        return $this->db->count_all_results();
    }

    function getAccountMail($agent_id) {
        $this->db->select("a.email");
        $this->db->from("plused_account-manager a");
        $this->db->join("agenti b", "b.account = a.id");
        $this->db->where("b.id", $agent_id);
        $this->db->limit(1);
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->row()->email : "";
    }

    function getBookingsByAgent($agent_id) {
        $this->db->select("a.*, p.pack_package_id, p.pack_package, c.nome_centri");
        $this->db->from("agnt_enrol_bookings a");
        $this->db->join("agnt_packages p", "p.pack_package_id = a.enrol_package_id");
        $this->db->join("centri c", "c.id = p.pack_campus_id");
        $this->db->where('enrol_created_by', $agent_id);
        $this->db->order_by('enroll_id', 'desc');
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }

    function getBookingComposition($enroll_id) {
        $this->db->select("COUNT(b.booked_pax_id) AS cnt, b.booked_tipo_pax, a.accom_name, ct.courses_type, act.act_activity_name, c.pcomp_week, c.pcomp_full_price, c.pcomp_price_a, c.pcomp_price_b, c.pcomp_price_c, cent.valuta ");
        $this->db->from("agnt_booked_pax b");
        $this->db->join("agnt_package_compositions c", "c.pcomp_id = b.booked_package_composition");
        $this->db->join("agnt_accommodation a", "a.accom_id = c.pcomp_accom_id", "left");
        $this->db->join("agnt_courses_type ct", "ct.courses_type_id = c.pcomp_course_type_id", "left");
        $this->db->join("agnt_activities act", "act.act_id = c.pcomp_activity_id", "left");
        $this->db->join("agnt_packages p", "p.pack_package_id = c.pcomp_package_id", "left");
        $this->db->join("centri cent", "cent.id = p.pack_campus_id");
        $this->db->where('booked_enroll_id', $enroll_id);
        $this->db->group_by('booked_package_composition, booked_tipo_pax');
        $this->db->order_by('booked_tipo_pax');
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }

    function bookingExists($id) {
        $this->db->select("enroll_id");
        $this->db->from('agnt_enrol_bookings');
        $this->db->where('enroll_id', $id);

        $query = $this->db->get();
        return ( $query->num_rows() > 0 ) ? 1 : 0;
    }

    function getPackageDate($package) {
        $this->db->select("DATE_FORMAT(pack_start_date, '%d/%m/%Y') as st_date, DATE_FORMAT(pack_expiry_date, '%d/%m/%Y') as end_date", FALSE);
        $this->db->from("agnt_packages");
        $this->db->where("pack_package_id", $package);
        $this->db->limit(1);
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->row_array() : array();
    }

    function findDatesByCenter($center) {
        $this->db->select("DATE_FORMAT(start_date, '%d/%m/%Y') as st_date", FALSE);
        $this->db->from('date_plus');
        $this->db->where('codice', $center);
        $this->db->order_by('start_date');
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }

    function findPackagePrice($package, $week = 0) {
        $this->db->select("comp.pcomp_id, a.accom_name, ct.courses_type, act.act_activity_name, comp.pcomp_week, c.valuta, comp.pcomp_total_cost, comp.pcomp_full_price, comp.pcomp_price_a, comp.pcomp_price_b, comp.pcomp_price_c, comp.pcomp_excursion_cost", FALSE);
        $this->db->from("agnt_package_compositions comp");
        $this->db->join("agnt_accommodation a", "a.accom_id = comp.pcomp_accom_id");
        $this->db->join("agnt_courses_type ct", "ct.courses_type_id = comp.pcomp_course_type_id", "left");
        $this->db->join("agnt_activities act", "act.act_id = comp.pcomp_activity_id", "left");
        $this->db->join("agnt_packages p", "p.pack_package_id = comp.pcomp_package_id", "left");
        $this->db->join("centri c", "c.id = p.pack_campus_id");
        $this->db->where("comp.pcomp_package_id", $package);
        if ($week > 0)
            $this->db->where("comp.pcomp_week", $week);
        $this->db->order_by("comp.pcomp_week, a.accom_id, ct.courses_type_id, act.act_id");
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }

    function getPackageCompositionDetails($pack_comp_id) {
        $this->db->select("comp.pcomp_id, comp.pcomp_week, c.valuta, comp.pcomp_total_cost, comp.pcomp_full_price, comp.pcomp_price_a, comp.pcomp_price_b, comp.pcomp_price_c");
        $this->db->from("agnt_package_compositions comp");
        $this->db->join("agnt_packages p", "p.pack_package_id = comp.pcomp_package_id", "left");
        $this->db->join("centri c", "c.id = p.pack_campus_id");
        $this->db->where("comp.pcomp_id", $pack_comp_id);
        $this->db->limit(1);
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->row_array() : array();
    }

    function getPackageAccomodationPrice($pack_accom_id, $package) {
        $this->db->select("s.serv_cost, c.valuta");
        $this->db->from("agnt_package_services s");
        $this->db->join("agnt_packages p", "p.pack_package_id = s.serv_package_id", "left");
        $this->db->join("centri c", "c.id = p.pack_campus_id");
        $this->db->where("s.serv_service_id", $pack_accom_id);
        $this->db->where("s.serv_service_type", 'Accommodation');
        $this->db->where("s.serv_package_id", $package);
        $this->db->limit(1);
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->row_array() : 0;
    }

    function getBookingAccomodation($enroll_id) {
        $this->db->select("COUNT(b.booked_pax_id) AS cnt, b.booked_tipo_pax, a.accom_name, s.serv_cost, c.valuta, SUM(CASE WHEN b.booked_is_free > 0 THEN 1 ELSE 0 END) AS free_gl", FALSE);
        $this->db->from("agnt_booked_pax b");
        $this->db->join("agnt_accommodation a", "a.accom_id = b.booked_package_accomodation");
        $this->db->join("agnt_enrol_bookings eb", "eb.enroll_id = b.booked_enroll_id");
        $this->db->join("agnt_packages p", "p.pack_package_id = eb.enrol_package_id");
        $this->db->join("centri c", "c.id = p.pack_campus_id");
        $this->db->join("agnt_package_services s", "s.serv_service_id = a.accom_id AND s.serv_package_id = p.pack_package_id AND serv_service_type = 'Accommodation'");
        $this->db->where('booked_enroll_id', $enroll_id);
        $this->db->group_by('booked_package_accomodation');
        $this->db->order_by('s.serv_cost');
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }

    function getBookingsDetails($enroll_id) {
        $this->db->select("a.*, p.*, c.nome_centri,c.valuta,c.id as centri_id, c.address, c.located_in, c.post_code");
        $this->db->from("agnt_enrol_bookings a");
        $this->db->join("agnt_packages p", "p.pack_package_id = a.enrol_package_id");
        $this->db->join("centri c", "c.id = p.pack_campus_id");
        $this->db->where('enroll_id', $enroll_id);
        $this->db->limit(1);
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->row_array() : array();
    }

    function getBookingAgentDetails($agentId) {
        $this->db->where('id', $agentId);
        $this->db->select('id,businessname,businessaddress,businesscity,businesspostalcode,businesscountry,businesstelephone,pricecategory');
        $result = $this->db->get('agenti');
        if ($result->num_rows())
            return (Array) $result->row();
        else
            return 0;
    }

    function getBookingsDetailsByTipo($enroll_id, $tipo) {
        $result = array();

        if ($tipo == 'STD')
            $this->db->select("booked_package_composition as id, COUNT(booked_pax_id) as cnt");
        else
            $this->db->select("booked_package_accomodation as id, COUNT(booked_pax_id) as cnt");

        $this->db->from("agnt_booked_pax");
        $this->db->where('booked_enroll_id', $enroll_id);
        $this->db->where('booked_tipo_pax', $tipo);
        if ($tipo == 'STD')
            $this->db->group_by('booked_package_composition');
        else
            $this->db->group_by('booked_package_accomodation');
        $query = $this->db->get();

        foreach ($query->result_array() as $value) {
            $result[$value['id']] = $value['cnt'];
        }

        return $result;
    }

    function delete_booking($enroll_id) {
        $this->db->where('booked_enroll_id', $enroll_id);
        $this->db->delete('agnt_booked_pax');
    }

    function update_enrol_agent_booking($enroll_id, $data) {
        $this->db->where('enroll_id', $enroll_id);
        $this->db->update('agnt_enrol_bookings', $data);
    }

    function getPackageDetails($package_id) {
        $this->db->select("pack_free_gl_per_pax, pack_extra_gl_price");
        $this->db->from("agnt_packages");
        $this->db->where('pack_package_id', $package_id);
        $this->db->limit(1);
        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->row_array() : array();
    }

    function paginateBookingData($agent_id, $param, $search) {
        $this->db->select("a.*, p.pack_package_id, p.pack_package, c.nome_centri,(enrol_booked_students+enrol_booked_gl) as pax");
        $this->db->from("agnt_enrol_bookings a");
        $this->db->join("agnt_packages p", "p.pack_package_id = a.enrol_package_id");
        $this->db->join("centri c", "c.id = p.pack_campus_id");
        $this->db->where('enrol_created_by', $agent_id);
        if (!empty($search)) {
            $this->db->where('(enroll_id LIKE "%' . mysql_real_escape_string($search) . '%" OR '
                    . 'pack_package LIKE "%' . mysql_real_escape_string($search) . '%" OR '
                    . 'nome_centri LIKE "%' . mysql_real_escape_string($search) . '%")');
        }
        if ($param['column'] == 'id_book') {
            $this->db->order_by('enrol_created_on', $param['type']);
            $this->db->order_by('enroll_id', $param['type']);
        } else {
            $this->db->order_by($param['column'], $param['type']);
        }
        $this->db->limit($param['offset'], $param['start']);

        $query = $this->db->get();

        return ( $query->num_rows() > 0 ) ? $query->result_array() : array();
    }

    function getBookingCount($agent_id, $search) {
        $this->db->select("a.*, p.pack_package_id, p.pack_package, c.nome_centri");
        $this->db->from("agnt_enrol_bookings a");
        $this->db->join("agnt_packages p", "p.pack_package_id = a.enrol_package_id");
        $this->db->join("centri c", "c.id = p.pack_campus_id");
        $this->db->where('enrol_created_by', $agent_id);
        return $this->db->count_all_results();
    }

}
