<?php

class Magenti extends Model {

    function Magenti() {
        parent::Model();
    }

    function getBookingsByAgent($agente, $status = 'all', $sort = "id_book", $sorttype = "desc") {
        $data = array();
        $this->db->where('id_agente', $agente);
        $this->db->where('YEAR(arrival_date)', 2018);
        if ($status != "all") {
            $this->db->where('status', $status);
        }
        $this->db->order_by($sort, $sorttype);
        $this->db->order_by('id_book', 'desc');
        $Q = $this->db->get('plused_book');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $row['centro'] = $this->gestione_centri_model->centerNameById($row["id_centro"]);
                $row['all_acco'] = $this->getBookAccomodations($row["id_book"]);
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getBookAccomodations($idb) {
        $sqlid = "SELECT tipo_pax, accomodation,data_arrivo_campus,data_partenza_campus, COUNT(*) as contot FROM plused_rows where id_book = $idb GROUP BY tipo_pax, accomodation,data_arrivo_campus,data_partenza_campus ORDER BY tipo_pax, accomodation";
        $query = $this->db->query($sqlid);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rowq) {
                $data[] = $rowq;
            }
            return $data;
        }
    }

    function getRowsByBookId($id) {
        $data = array();
        $this->db->select('a.*, b.plr_id, c.description')
                ->from('plused_rows as a')
                ->join('plused_pax_supplement as b', 'a.uuid=b.uuid', 'left')
                ->join('plused_roster_supplements as c', 'c.plr_id=b.plr_id', 'left')
                ->where('a.id_book', $id)
                ->order_by('a.tipo_pax', 'asc')
                ->order_by('accomodation', 'asc');
        /* $this->db->where('id_book',$id);
          $this->db->order_by('tipo_pax','asc');
          $this->db->order_by('accomodation','asc'); */
        $Q = $this->db->get();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getRowsNumByBookId($id, $paxType) {
        $this->db->where('id_book', $id);
        $this->db->where('tipo_pax', $paxType);
        $this->db->from('plused_rows');
        return $this->db->count_all_results();
    }

    function plused_getProducts($agente) {
        $data = array();
        $Q = $this->db->get('plused_prodotti');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $row['sconto'] = $this->getAgentDiscount($agente, $row["prd_id"]);
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function centerNameById($idcentro) {
        $data = array();
        $this->db->where('id', $idcentro);
        $Q = $this->db->get('centri');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data[0]["nome_centri"];
    }

    function plused_getAllProducts() {
        $data = array();
        $Q = $this->db->get('plused_prodotti');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getAgentDiscount($agente, $prodotto) {
        $data = array();
        $this->db->where('pa_idage', $agente);
        $this->db->where('pa_idprod', $prodotto);
        $Q = $this->db->get('plused_prodotti-agenti');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $sconto = $row["pa_sconto"];
            }
            $Q->free_result();
            return $sconto;
        } else {
            $Q->free_result();
            return 0;
        }
    }

    function thumbs($num, $offset) {

        $data = array();
        $this->db->order_by("descrizione", "tipo");
        $Q = $this->db->get('agenti_gallery', $num, $offset);


        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
        /*
          echo "<pre>";
          print_r($data);
          echo "</pre>";
         */
    }

    function thumbs_search($tipo) {

        $data = array();
        $this->db->where('tipo', $tipo);
        $this->db->order_by("descrizione", "tipo");
        $Q = $this->db->get('agenti_gallery');


        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
        /*
          echo "<pre>";
          print_r($data);
          echo "</pre>";
         */
    }

    function single($id) {

        $data = array();
        $options = array('id' => $id);
        $Q = $this->db->getwhere('agenti_gallery', $options);


        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }

        $Q->free_result();
        return $data;
    }

    /*     * ********************* CMS *************** */
    /* MEDIA GALLERY */

    function addImg($imgbig, $imgsmall) {
        $data = array(
            'imgname' => $imgbig,
            'imgthumb' => $imgsmall,
            'tipo' => $this->input->get_post('tipo', TRUE),
            'descrizione' => $this->input->get_post('notes', TRUE)
                /*
                  'pdf'=>$filebig,
                  'certificate'=>$filesmall
                 */
        );
        $this->db->insert('agenti_gallery', $data);
    }

//Controllo se esiste gi� la mail o il nome utente se si torno qualcosa e annullo

    function verify_mail($email, $login) {
        $data = array();
        $this->db->select('id,email,login');
        $this->db->where('email', $email);
        $this->db->or_where('login', $login);

        $Q = $this->db->get('agenti');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }

        $Q->free_result();
        return $data;
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

//Inserisco l'utente
    function insert_user($id, $session_id) {

        $data = array(
            'confirm' => xss_clean($session_id)
        );
        $this->db->where('id', $id);
        $this->db->update('agenti', $data);
    }

    function verifyUser($user, $pwd) {
        $data = array();
        $options = array('login' => $this->db->escape_str($user), 'password' => $this->db->escape_str($pwd), 'status' => 'active');
        $Q = $this->db->getwhere('agenti', $options, 1);

        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $row["ruolo"] = "agente";
                $data[] = $row;
            }
            $Q->free_result();
            return $data;
        } else {
            $options = array('email' => $this->db->escape_str($user), 'pwd' => $this->db->escape_str($pwd));
            $Q2 = $this->db->getwhere('plused_account-manager', $options, 1);
            if ($Q2->num_rows() > 0) {
                foreach ($Q2->result_array() as $row) {
                    $row["ruolo"] = "manager";
                    $data[] = $row;
                }
                $Q2->free_result();
                return $data;
            } else {
                $options = array('email' => $this->db->escape_str($user), 'pwd' => $this->db->escape_str($pwd));
                $Q3 = $this->db->getwhere('plused_mediaviewers', $options, 1);
                if ($Q3->num_rows() > 0) {
                    foreach ($Q3->result_array() as $row) {
                        $row["ruolo"] = "mediaViewer";
                        $data[] = $row;
                    }
                    $Q3->free_result();
                    return $data;
                } else {
                    $Q3->free_result();
                    return $data;
                }
            }
        }
    }

    function changePassword($memberId, $roleId, $oldPassword, $newPassword) {
        $result = 0;
        if ($roleId == 99) { // THIS IS AGENT
            $options = array(
                'id' => $this->db->escape_str($memberId),
                'status' => 'active'
            );
            $resultSet = $this->db->getwhere('agenti', $options, 1);
            if ($resultSet->num_rows() > 0) {
                $dbPassword = $resultSet->row()->password;
                if ($dbPassword == $oldPassword) {
                    // update new password
                    $updatePassword = array(
                        'password' => $newPassword
                    );
                    $this->db->where('id', $memberId);
                    $this->db->update('agenti', $updatePassword);
                    $result = 1;
                } else
                    $result = -1; // OLD PASSWORD IS WRONG
            } else
                $result = 0; // NO SUCH MEMBER AVAILABLE
        }
        elseif ($roleId == 98) { // THIS IS ACCOUNT MANAGER
            $options = array(
                'id' => $this->db->escape_str($memberId)
            );
            $resultSet = $this->db->getwhere('plused_account-manager', $options, 1);
            if ($resultSet->num_rows() > 0) {
                $dbPassword = $resultSet->row()->pwd;
                if ($dbPassword == $oldPassword) {
                    // update new password
                    $updatePassword = array(
                        'pwd' => $newPassword
                    );
                    $this->db->where('id', $memberId);
                    $this->db->update('plused_account-manager', $updatePassword);
                    $result = 1;
                } else
                    $result = -1; // OLD PASSWORD IS WRONG
            } else
                $result = 0; // NO SUCH MEMBER AVAILABLE
        }
        elseif ($roleId == 97) { // THIS IS Media Viewer
            $options = array(
                'id' => $this->db->escape_str($memberId)
            );
            $resultSet = $this->db->getwhere('plused_mediaviewers', $options, 1);
            if ($resultSet->num_rows() > 0) {
                $dbPassword = $resultSet->row()->pwd;
                if ($dbPassword == $oldPassword) {
                    // update new password
                    $updatePassword = array(
                        'pwd' => $newPassword
                    );
                    $this->db->where('id', $memberId);
                    $this->db->update('plused_mediaviewers', $updatePassword);
                    $result = 1;
                } else
                    $result = -1; // OLD PASSWORD IS WRONG
            } else
                $result = 0; // NO SUCH MEMBER AVAILABLE
        }
        return $result;
    }

    function genera_credenziali($id, $businessname) {

        //Genero username e password
        $login = $businessname . "_" . random_string('alnum', 5);
        $password = random_string('numeric', 8);
        $data = array(
            'login' => xss_clean($login),
            'password' => xss_clean($password)
        );

        $this->db->where('id', $id);
        $this->db->update('agenti', $data);
    }

    function recuperaMail($id) {

        $Q = $this->db->getwhere('agenti', array('id' => $id));

        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataend[] = $row;
            }
        }

        $Q->free_result();
        return $dataend;
    }

    function checkAgentExists($email) {
        $Q = $this->db->getwhere('agenti', array('email' => $email));
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataend = $row["id"];
            }
        } else {
            $dataend = false;
        }
        $Q->free_result();
        return $dataend;
    }

    function recuperaID($bname) {

// Recupera ID controllando il nome della compagnia per proseguire registrazione
        $data = array();
        $options = array('businessname' => $bname);
        $Q = $this->db->getwhere('agenti', $options);


        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }

        $Q->free_result();

        return $data;
    }

    function recuperaIDbooking($bname) {

// Recupera ID controllando il nome della compagnia per proseguire registrazione
        $data = array();
        $options = array('email' => $bname);
        $Q = $this->db->getwhere('job_contacts_all', $options);


        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }

        $Q->free_result();
        return $data;
    }

    function recuperaMailbooking($id) {
        //$data = array();
        $this->db->select('id,email');
        $Q = $this->db->getwhere('job_contacts_all', array('id' => $id));

        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }

        $Q->free_result();
        return $data;
    }

    function plused_insert_agente($business_name, $address, $postal_code, $city, $country, $email, $phone, $firstname, $familyname, $hmstudents, $portionjs, $portionll, $portionup, $destinations) {
        $password = random_string('numeric', 8);
        $data = array(
            'login' => $this->input->xss_clean($email),
            'status' => "pending",
            'password' => $password,
            'businessname' => $this->input->xss_clean($business_name),
            'businessaddress' => $this->input->xss_clean($address),
            'businesscity' => $this->input->xss_clean($city),
            'businesspostalcode' => $this->input->xss_clean($postal_code),
            'businesscountry' => $this->input->xss_clean($country),
            'businesstelephone' => $this->input->xss_clean($phone),
            'email' => $this->input->xss_clean($email),
            'mainfirstname' => $this->input->xss_clean($firstname),
            'mainfamilyname' => $this->input->xss_clean($familyname),
            'companystudent' => $this->input->xss_clean($hmstudents),
            'companyjunior' => $this->input->xss_clean($portionjs),
            'companylanguage' => $this->input->xss_clean($portionll),
            'companyuniversity' => $this->input->xss_clean($portionup)
        );
        if ($this->db->insert('agenti', $data)) {
            $age_id = $this->db->insert_id();
            foreach ($destinations as $desti) {
                //print_r($desti);
                $idd = $this->plused_getPopDestID($desti);
                $datadesti = array(
                    'ppa_id_dest' => $idd,
                    'ppa_id_ag' => $age_id
                );
                $this->db->insert('plused_popdest-agenti', $datadesti);
            }
            return true;
        } else {
            return false;
        }
    }

    function plused_getPopDestID($destinazione) {
        $dataend = array();
        $Q = $this->db->getwhere('plused_popular_destinations', array('pp_dest' => $destinazione));

        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $iddestin = $row["pp_id"];
            }
        }

        $Q->free_result();
        return $iddestin;
    }

    function plused_verify_mail($email) {
        $data = array();
        $this->db->select('id,email');
        $this->db->where('email', $email);

        $Q = $this->db->get('agenti');
        if ($Q->num_rows() > 0) {
            $Q->free_result();
            return false;
        } else {
            $Q->free_result();
            return true;
        }
    }

    function plused_get_ag_details($id) {
        $dataend = array();
        $this->db->where('agenti.id', $id);
        $this->db->from('agenti');
        $this->db->select('agenti.*,plused_account-manager.firstname as acc_manager_firstname,plused_account-manager.familyname as acc_manager_lastname,plused_account-manager.email as acc_manager_email');
        $this->db->join('plused_account-manager','agenti.account = plused_account-manager.id','left');
        $Q = $this->db->get();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataend[] = $row;
            }
        }

        $Q->free_result();
        return $dataend;
    }

    function getMyAgents($account) {
        $dataend = array();
        $Q = $this->db->getwhere('agenti', array('account' => $account));
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $this->db->where('id_agente', $row["id"]);
                $Qcount = $this->db->count_all_results('plused_book');
                $row["contarighe"] = $Qcount;
                $dataend[] = $row;
            }
        }
        $Q->free_result();
        return $dataend;
    }

    function checkAgentAccount($agent, $account) {
        $this->db->where('account', $account);
        $this->db->where('id', $agent);
        $this->db->from('agenti');
        return $this->db->count_all_results();
    }

    function checkAgentOrder($agent, $order) {
        $this->db->where('id_book', $order);
        $this->db->where('id_agente', $agent);
        $this->db->from('plused_book');
        return $this->db->count_all_results();
    }

    function checkExcInBk($pte_id, $pte_book_id) {
        $this->db->where('pte_book_id', $pte_book_id);
        $this->db->where('pte_id', $pte_id);
        $this->db->from('plused_tra_excursions');
        return $this->db->count_all_results();
    }

    function clearCommissionAgents($agent) {
        $this->db->where('pa_idage', $agent);
        $this->db->delete('plused_prodotti-agenti');
        return true;
    }

    function setCommissionAgents($agent, $idprodotto, $scontoprodotto) {
        $data = array(
            'pa_idage' => $agent,
            'pa_sconto' => $scontoprodotto,
            'pa_idprod' => $idprodotto
        );
        $this->db->insert('plused_prodotti-agenti', $data);
        return true;
    }

    function setStatusAgents($id, $status) {

        $data = array(
            'status' => $status
        );
        $this->db->where('id', $id);
        $this->db->update('agenti', $data);
    }

    function setRankingAgents($id, $rank) {

        $data = array(
            'ranking' => $rank
        );
        $this->db->where('id', $id);
        $this->db->update('agenti', $data);
    }

    function getAccountMail($agent_id) {
        $data = array();
        $querya = "SELECT a.email FROM `plused_account-manager` as a, `agenti` as b WHERE a.id = b.account and b.id = $agent_id";
        $Q = $this->db->query($querya);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function updateAgentField($id, $key, $value) {

        $data = array(
            $key => $value
        );
        $this->db->where('id', $id);
        $this->db->update('agenti', $data);
    }

    function plused_getAllDOI($idprodotto = 1) {
        $data = array();
        $this->db->select('id, nome_centri,located_in, id_prodotto');
        $this->db->order_by("id_prodotto, located_in, nome_centri");
        $this->db->where('id_prodotto', $idprodotto);
        $Q = $this->db->get('centri');


        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function clearDOIAgents($agent) {
        $this->db->where('doi_id_ag', $agent);
        $this->db->delete('plused_doi_agenti');
        return true;
    }

    function setDOIAgents($agent, $idcampus) {
        $data = array(
            'doi_id_ag' => $agent,
            'doi_id_dest' => $idcampus
        );
        $this->db->insert('plused_doi_agenti', $data);
        return true;
    }

    function getDOIAgents($agent) {
        $data = array();
        $this->db->select('doi_id_dest');
        $this->db->where('doi_id_ag', $agent);
        $Q = $this->db->get('plused_doi_agenti');


        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function plused_insertProspect($business_name, $address, $postal_code, $city, $country, $email, $phone, $firstname, $familyname, $mobilephone, $skypename, $origin, $statuscrm, $accountm) {
        $password = random_string('numeric', 8);
        $data = array(
            'login' => $this->input->xss_clean($email),
            'status' => "pending",
            'password' => $password,
            'businessname' => $this->input->xss_clean($business_name),
            'businessaddress' => $this->input->xss_clean($address),
            'businesscity' => $this->input->xss_clean($city),
            'businesspostalcode' => $this->input->xss_clean($postal_code),
            'businesscountry' => $this->input->xss_clean($country),
            'businesstelephone' => $this->input->xss_clean($phone),
            'email' => $this->input->xss_clean($email),
            'mainfirstname' => $this->input->xss_clean($firstname),
            'mainfamilyname' => $this->input->xss_clean($familyname),
            'mobilephone' => $this->input->xss_clean($mobilephone),
            'skypename' => $this->input->xss_clean($skypename),
            'origin' => $this->input->xss_clean($origin),
            'statuscrm' => $this->input->xss_clean($statuscrm),
            'account' => $this->input->xss_clean($accountm)
        );
        if ($this->db->insert('agenti', $data)) {
            $age_id = $this->db->insert_id();
            return $age_id;
        } else {
            return false;
        }
    }

    function getChatsByAgent($agente, $account, $tipo) {
        $data = array();
        $this->db->where('ch_id_am', $account);
        $this->db->where('ch_id_ag', $agente);
        $this->db->where('ch_category', $tipo);
        $this->db->order_by('ch_datetime', 'desc');
        $Q = $this->db->get('plused_chat_history');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function plused_insertChat($agent, $accountm, $ch_messagetext, $ch_datetime, $ch_type, $ch_from_am, $ch_category) {
        //echo "--->".strtotime($ch_datetime)."<---";
        $pieces = explode("/", $ch_datetime);
        //print_r($pieces);
        $newdt = $pieces[1] . "/" . $pieces[0] . "/" . $pieces[2];
        $mysqltime = date("Y-m-d H:i:s", strtotime($newdt));
        //echo "--->".$mysqltime."<---";
        //die();
        $data = array(
            'ch_messagetext' => $this->input->xss_clean($ch_messagetext),
            'ch_datetime' => $this->input->xss_clean($mysqltime),
            'ch_type' => $this->input->xss_clean($ch_type),
            'ch_from_am' => $this->input->xss_clean($ch_from_am),
            'ch_id_ag' => $this->input->xss_clean($agent),
            'ch_id_am' => $this->input->xss_clean($accountm),
            'ch_category' => $this->input->xss_clean($ch_category)
        );
        if ($this->db->insert('plused_chat_history', $data)) {
            return true;
        } else {
            return false;
        }
    }

    function plused_insertReminder($agent, $accountm, $rem_messagetext, $rem_datetime, $rem_type) {
        //echo "--->".$rem_datetime."<---";
        $pieces = explode("/", $rem_datetime);
        //print_r($pieces);
        $newdt = $pieces[1] . "/" . $pieces[0] . "/" . $pieces[2];
        //echo $newdt;
        //echo "--->".strtotime($newdt)."<---";
        $mysqltime = date("Y-m-d H:i:s", strtotime($newdt));
        //echo "--->".$mysqltime."<---";
        //die();
        $data = array(
            'rem_messagetext' => $this->input->xss_clean($rem_messagetext),
            'rem_datetime' => $this->input->xss_clean($mysqltime),
            'rem_type' => $this->input->xss_clean($rem_type),
            'rem_id_ag' => $this->input->xss_clean($agent),
            'rem_id_am' => $this->input->xss_clean($accountm)
        );
        if ($this->db->insert('plused_reminders', $data)) {
            return true;
        } else {
            return false;
        }
    }

    function getRemindersByAM($account, $completi = 0, $limita = 5) {
        $data = array();
        $Q = $this->db->query("SELECT agenti.businessname as r_agente, plused_reminders.rem_type as r_tipo, plused_reminders.rem_datetime as r_data, plused_reminders.rem_messagetext as r_testo, plused_reminders.rem_id as r_id FROM plused_reminders, agenti WHERE plused_reminders.rem_completed = " . $completi . " AND agenti.id = plused_reminders.rem_id_ag AND rem_id_am = " . $account . " ORDER BY rem_datetime asc LIMIT 0," . $limita);
        //echo $this->db->last_query();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getAllYearRemindersByAM($account, $month, $year) {
        //echo "-->".$month;
        if (!$year)
            $year = date("Y");
        if (!$month)
            $month = date("m");
        //echo "-->".$month;
        $data = array();
        $Q = $this->db->query("SELECT agenti.businessname as r_agente, plused_reminders.rem_type as r_tipo, plused_reminders.rem_datetime as r_data, plused_reminders.rem_messagetext as r_testo, plused_reminders.rem_id as r_id, plused_reminders.rem_completed as r_completo FROM plused_reminders, agenti WHERE agenti.id = plused_reminders.rem_id_ag AND rem_id_am = " . $account . " AND rem_datetime >= '" . $year . "-" . $month . "-01' and rem_datetime < date_add('" . $year . "-" . $month . "-01',interval 1 month) ORDER BY rem_datetime asc");
        //echo $this->db->last_query();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function completeReminder($id, $remi) {
        $data = array(
            'rem_completed' => 1
        );
        $this->db->where('rem_id_am', $id);
        $this->db->where('rem_id', $remi);
        $this->db->update('plused_reminders', $data);
    }

    function searchAP() {
        $term = $_REQUEST['term'];
        //$term = "mal";
        $qstring = "SELECT ap_id, ap_intcode, ap_name FROM plused_tra_airports_stations WHERE (ap_name LIKE '%" . $term . "%' OR ap_intcode LIKE '%" . $term . "%') AND ap_intcode <> ''";
        $Q = $this->db->query($qstring);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $row1['id'] = $row['ap_id'];
                $row1['value'] = $row['ap_intcode'] . " - " . $row['ap_name'];
                $row1['sigla'] = $row['ap_intcode'];
                $row_set[] = $row1;
            }
        }
        echo '{"airports":' . json_encode(($row_set)) . '}';
    }

    function searchNat() {
        $term = $_REQUEST['term'];
        //$term = "mal";
        $qstring = "SELECT nat_id, nationality FROM plused_nationality WHERE nationality LIKE '%" . $term . "%'";
        $Q = $this->db->query($qstring);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $row1['id'] = $row['nat_id'];
                $row1['value'] = $row['nationality'];
                $row1['sigla'] = $row['nationality'];
                $row_set[] = $row1;
            }
        }
        echo '{"nationalities":' . json_encode(($row_set)) . '}';
    }

    function getLockPaxByBookId($id) {
        $Q = $this->db->getwhere('plused_book', array('id_book' => $id));

        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $lockPax = $row["lockPax"];
            }
        }
        $Q->free_result();
        return $lockPax;
    }

    function getDwnVisaByBookId($id) {
        $where = array(
            'id_book' => $id,
            'lockPax' => 1
        );
        $Q = $this->db->getwhere('plused_book', $where);
        $downloadVisa = 0;
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $downloadVisa = $row["downloadVisa"];
            }
        }
        $Q->free_result();
        return $downloadVisa;
    }

    function getDwnSingleVisa($id) {
        $Q = $this->db->getwhere('plused_row', array('id_prenotazione' => $id));
        $donwnloadVisa = 0;
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $downloadVisa = $row["downloadVisa"];
            }
        }
        $Q->free_result();
        return $downloadVisa;
    }

    function postaPax($id) {
        //print_r($_POST);
        if ($id == "") {
            echo "NO ID";
            die();
        }
        if ($_POST["noChanges"] == "SEND") {
            $lstring = "UPDATE plused_book SET lockPax = 1 WHERE id_book = $id";
            $L = $this->db->query($lstring);
        }
        $ustring = "UPDATE plused_rows SET visa = 0 WHERE id_book = $id";
        if ($id) {
            $U = $this->db->query($ustring);
        } else {
            echo "NO ID";
            die();
        }
        $mapArr = array();
        foreach ($_POST as $key => $value) {
            if ($key != "noChanges") {
                if ($value) {
                    $arpre = explode("__", $key);
                    $idpre = $arpre[1];
                    $fieldpre = $arpre[0];
                    $okValue = $value;
                    if ($fieldpre == "data_arrivo_campus" || $fieldpre == "data_partenza_campus" || $fieldpre == "pax_dob") {
                        $expData = explode("/", $value);
                        $okValue = $expData[2] . "-" . $expData[1] . "-" . $expData[0];
                    }
                    if ($fieldpre == "andata_data_arrivo" || $fieldpre == "ritorno_data_partenza") {
                        $expDataT = explode(" ", $value);
                        $expData = explode("/", $expDataT[0]);
                        $okValue = $expData[2] . "-" . $expData[1] . "-" . $expData[0];
                        if ($fieldpre == "andata_data_arrivo") {
                            $campoOra = "ora_arrivo_volo__" . $idpre;
                        } else {
                            $campoOra = "ora_partenza_volo__" . $idpre;
                        }
                        $okValue .= " " . $_POST[$campoOra];
                    }
                    if ($fieldpre == "visa") {
                        $okValue = 1;
                    }
                    if ($fieldpre != "ora_arrivo_volo" && $fieldpre != "ora_partenza_volo" && $fieldpre != "suppl") {
                        $qstring = "UPDATE plused_rows SET " . $fieldpre . " = '" . mysql_real_escape_string($okValue) . "' WHERE id_prenotazione = $idpre AND id_book = $id";
                        //echo $qstring."<br>";
                        $Q = $this->db->query($qstring);
                    }

                    if (($fieldpre == "suppl") && $okValue) {
                        $this->db->select('uuid')
                                ->from('plused_rows')
                                ->where('id_prenotazione', $idpre);
                        $result = $this->db->get();
                        if ($result->num_rows() > 0) {
                            $resultArray = $result->result_array();
                            if (!in_array($resultArray[0]['uuid'] . '-' . $okValue, $mapArr)) {
                                $this->db->select('count(*) as count')
                                        ->from('plused_pax_supplement')
                                        ->where('uuid', $resultArray[0]['uuid']);
                                $result = $this->db->get();
                                if ($result->num_rows() > 0) {
                                    $resArr = $result->result_array();
                                    if ($resArr[0]['count'] > 0) {
                                        $data = array(
                                            'plr_id' => $okValue
                                        );
                                        $this->db->where('uuid', $resultArray[0]['uuid']);
                                        $this->db->update('plused_pax_supplement', $data);
                                    } else {
                                        $mapArr[] = $resultArray[0]['uuid'] . '-' . $okValue;
                                        $data = array(
                                            'uuid' => $resultArray[0]['uuid'],
                                            'plr_id' => $okValue
                                        );
                                        $this->db->insert('plused_pax_supplement', $data);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /*
      function insertExcursion($centro, $book, $year){
      $queryt = "SELECT id_year, id_book, id_centro, tot_pax, weeks FROM plused_book WHERE id_year = $year AND id_book = $book";
      $Q=$this->db->query($queryt);
      if ($Q->num_rows() > 0){
      foreach ($Q->result_array() as $row){
      $query2 = "SELECT exc_id, exc_excursion, exc_type FROM plused_exc_all WHERE exc_type = 'planned' AND exc_weeks <= ".$row["weeks"]." AND exc_id_centro = ".$row["id_centro"]." ORDER BY exc_id_centro";
      $Q2=$this->db->query($query2);
      //echo $this->db->last_query();
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
      $this->db->insert('plused_exc_bookings', $dataexc);
      }
      }
      $Q2->free_result();
      }
      }
      $Q->free_result();
      return true;
      }
     */

    function getGlByBookingId($id) {
        $data = array();
        $qstring = "SELECT plused_rows.uuid, plused_rows.cognome, plused_rows.nome FROM plused_rows, plused_book WHERE plused_book.id_book = $id AND plused_book.id_book = plused_rows.id_book and plused_rows.tipo_pax = 'GL' AND plused_rows.cognome <> '' AND plused_rows.nome <> '' ORDER BY plused_rows.cognome ASC";
        $Q = $this->db->query($qstring);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getExcursionGlByTestataId($id) {
        $qgl = "SELECT pter_uuid FROM plused_tra_excursions_rows WHERE pter_trid = $id ORDER BY pter_id ASC LIMIT 0,1";
        $Q = $this->db->query($qgl);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $rowgl) {
                $uuidforthis = $rowgl["pter_uuid"];
            }
        }
        $Q->free_result();
        $qstring = "SELECT CONCAT(plused_rows.cognome,' ', plused_rows.nome) as firstgl FROM plused_rows WHERE plused_rows.uuid = '" . $uuidforthis . "'";
        $Q = $this->db->query($qstring);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $glforthis = $row["firstgl"];
            }
        }
        $Q->free_result();
        return $glforthis;
    }

    function getExtraExcbyCampusId($campusId) {
        $data = array();
        $qstring = "SELECT exc_id, exc_length, exc_excursion FROM plused_exc_all WHERE exc_type = 'extra' AND exc_id_centro = $campusId ORDER BY exc_length DESC, exc_excursion ASC";
        $Q = $this->db->query($qstring);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function bestBusPriceForExcursion($exc_id, $min_pax, $stdPax) {
        $data = array();
        //$querybk = "SELECT jn_id, jn_id_bus, jn_price, cur_codice as jn_currency, tra_cp_name, tra_bus_name, tra_bus_seat FROM plused_tb_currency, plused_exc_join, plused_tra_companies, plused_tra_bus WHERE jn_currency = cur_id AND jn_id_bus = tra_bus_id AND tra_bus_cp_id = tra_cp_id AND jn_id_exc = ".$exc_id." AND tra_bus_seat >= ".$min_pax." ORDER BY jn_price ASC LIMIT 0,1";
        $querybk = "SELECT jn_id, jn_id_bus, jn_price, cur_codice as jn_currency, tra_cp_name, tra_bus_name, tra_bus_seat FROM plused_tb_currency, plused_exc_join, plused_tra_companies, plused_tra_bus WHERE jn_currency = cur_id AND jn_id_bus = tra_bus_id AND tra_bus_cp_id = tra_cp_id AND jn_id_exc = " . $exc_id . " AND tra_bus_seat >= " . $min_pax . " ORDER BY jn_price ASC LIMIT 0,1";
        $Q = $this->db->query($querybk);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        $busPrice = $data[0]["jn_price"] * 1 + $data[0]["jn_price"] / 100 * 15;
        $paxPrice = number_format($busPrice / $stdPax, 2, ",", "");
        //echo $data[0]["jn_price"]*1 ."--->". $busPrice."--->". $paxPrice;
        $curPrice = $data[0]["jn_currency"];
        return $stdPax . "___" . $paxPrice . "___" . $curPrice;
    }

    function retrieveStudentsByGl($bookId) {
        $data = array();
        $uuid = $_REQUEST['gluuid'];
        if ($uuid != "all") {
            $qstring = "SELECT uuid, CONCAT (cognome, ' ', nome) as nominativo, tipo_pax FROM plused_rows WHERE uuid = '" . $uuid . "'";
            $Q = $this->db->query($qstring);
            if ($Q->num_rows() > 0) {
                foreach ($Q->result_array() as $row) {
                    $glref = $row["nominativo"];
                    $gluuid = $row["uuid"];
                    $data[] = $row;
                }
            }
            $Q->free_result();
            $qstring2 = "SELECT uuid, CONCAT (cognome, ' ', nome) as nominativo, tipo_pax FROM plused_rows WHERE id_book = $bookId AND gl_rif = '" . $glref . "' AND uuid <> '" . $gluuid . "' ORDER BY tipo_pax ASC, cognome ASC";
            $Q2 = $this->db->query($qstring2);
            if ($Q2->num_rows() > 0) {
                foreach ($Q2->result_array() as $row2) {
                    $data[] = $row2;
                }
            }
            $Q2->free_result();
        } else {
            $qstring2 = "SELECT uuid, CONCAT (cognome, ' ', nome) as nominativo, tipo_pax FROM plused_rows WHERE id_book = $bookId ORDER BY tipo_pax ASC, cognome ASC";
            $Q2 = $this->db->query($qstring2);
            if ($Q2->num_rows() > 0) {
                foreach ($Q2->result_array() as $row2) {
                    $data[] = $row2;
                }
            }
            $Q2->free_result();
        }
        $contaci = 1;
        foreach ($data as $paxx) {
            if (APP_THEME == "OLD") {
                ?>
                <p style="float:left;width:33%;<?php if ($paxx["tipo_pax"] == "GL") { ?>font-weight:bold;<?php } ?>"><span style="float:left;width:30px;"><?php echo $contaci ?>)</span> - <span style="float:left;width:25px;"><?php echo $paxx["tipo_pax"] ?></span><?php echo $paxx["nominativo"] ?></p><input type="hidden" name="uuidpax[]" value="<?php echo $paxx["uuid"] ?>" style="clear:both;" />
                <?php
            } else {
                ?>
                <div class="col-sm-4 col-md-4" style="<?php if ($paxx['tipo_pax'] == 'GL') { ?>font-weight:bold;<?php } ?>">
                    <span style="float:left;width:30px;">
                        <?php echo $contaci ?>)
                    </span> -
                    <span style="float:left;width:25px;">
                        <?php echo $paxx["tipo_pax"] ?>
                    </span>
                    <?php echo $paxx["nominativo"] ?>
                </div>
                <input type="hidden" name="uuidpax[]" value="<?php echo $paxx["uuid"] ?>" style="clear:both;" />
                <?php
            }
            $contaci++;
        }
    }

    function insertTestataExcursion($exc_type, $campus_id, $exc_id, $book_id, $num_pax, $price, $num_std, $currency) {
        $data = array(
            'pte_type' => $exc_type,
            'pte_campus_id' => $campus_id,
            'pte_excursion_id' => $exc_id,
            'pte_book_id' => $book_id,
            'pte_tot_pax' => $num_pax,
            'pte_proforma_price' => $price,
            'pte_proforma_num_std' => $num_std,
            'pte_proforma_currency' => $currency
        );
        $this->db->insert('plused_tra_excursions', $data);
        return true;
    }

    function insertRigaExcursion($uniid, $lastTestataid, $exc_type) {
        $data = array(
            'pter_trid' => $lastTestataid,
            'pter_type' => $exc_type,
            'pter_uuid' => $uniid
        );
        $this->db->insert('plused_tra_excursions_rows', $data);
        return true;
    }

    function getBookedExcursionsByBkId($id, $type) {
        $data = array();
        $queryexc = "SELECT pte_id, CONCAT(exc_excursion,' - ',exc_length) as escursione, pte_excursion_date, pte_buscompany_code, pte_confirmed, pte_tot_pax FROM plused_tra_excursions, plused_exc_all WHERE pte_type = '" . $type . "' AND pte_book_id = '" . $id . "' AND pte_excursion_id = exc_id";
        $Q = $this->db->query($queryexc);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $glforthis = $this->getExcursionGlByTestataId($row["pte_id"]);
                $row["glforthis"] = $glforthis;
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function removeAllExcursions($pte_id) {
        $qDelRighe = "DELETE FROM plused_tra_excursions_rows WHERE pter_trid = " . $pte_id;
        //echo $qDelRighe."<br>";
        $Q2 = $this->db->query($qDelRighe);
        $qDelTesta = "DELETE FROM plused_tra_excursions WHERE pte_id = " . $pte_id;
        //echo $qDelTesta."<br>";
        $Q3 = $this->db->query($qDelTesta);
        return true;
    }

    function countAllExcursionsByBookingID($book_id, $tipo = "extra") {
        $this->db->where("pte_book_id", $book_id);
        $this->db->where("pte_type", $tipo);
        $this->db->from("plused_tra_excursions");
        return $this->db->count_all_results();
    }

    function getAllExcursionsPaxFromExcID($pte_id) {
        $datatra = array();
        $querya = "SELECT CONCAT (plused_rows.id_year,'_',plused_rows.id_book) as bookID, concat(plused_rows.cognome,' ',plused_rows.nome) as pax, plused_rows.tipo_pax, businessname, pte_excursion_date FROM plused_rows, plused_tra_excursions, plused_tra_excursions_rows, plused_book, agenti WHERE agenti.id = plused_book.id_agente AND plused_rows.uuid = plused_tra_excursions_rows.pter_uuid AND pter_trid =  pte_id AND pte_id = $pte_id AND plused_rows.id_book = plused_book.id_book ORDER BY plused_book.id_book, plused_rows.tipo_pax, plused_rows.cognome";
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

    function getExtraExcDetailById($pte_id) {
        $data = array();
        $querya = "SELECT pte_id, pte_book_id, pte_tot_pax, pte_proforma_price, pte_proforma_num_std, pte_proforma_currency, exc_centro, exc_length, exc_excursion FROM plused_exc_all, plused_tra_excursions WHERE pte_id = " . $pte_id . " AND pte_excursion_id = exc_id";
        $Q = $this->db->query($querya);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        //print_r($data);
        return $data;
    }

    function agentAttractionById($idAtt) {
        $data = array();
        $querya = "SELECT pat_name, pat_desc, pat_opening_time, pat_entertainment_group, pat_address, pat_lat, pat_lon, pat_notes_1, pat_student_price, pat_adult_price, pat_phone, pat_email, pat_website, patt_name, cou_descrizione, cit_descrizione, cur_codice, pat_currency_id FROM plused_attractions, plused_attraction_type, plused_tb_country, plused_tb_citta, plused_tb_currency WHERE pat_id = " . $idAtt . " AND patt_id = pat_type_id AND cou_id = pat_country_id AND cit_id = pat_city_id AND pat_currency_id = cur_id";
        $Q = $this->db->query($querya);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function bookAttractionNow($id_book, $id_year, $id_attr, $id_campus, $allNum, $STDprice, $cur_id) {
        $data = array(
            'atb_id_book' => $id_book,
            'atb_id_year' => $id_year,
            'atb_id_attraction' => $id_attr,
            'atb_campus_id' => $id_campus,
            'atb_tot_pax' => $allNum,
            'atb_total_price' => $STDprice,
            'atb_currency' => $cur_id
        );
        $this->db->insert('plused_att_bookings', $data);
        return true;
    }

    function getAllAgentAttractions($idAgent) {
        $data = array();
        $querya = "SELECT atb_id, atb_id_book, atb_id_year, atb_id_attraction, nome_centri, atb_tot_pax, atb_total_price, atb_currency, atb_confirmed, pat_name, cou_descrizione, cit_descrizione, cur_codice FROM plused_att_bookings, plused_attractions, plused_tb_country, plused_tb_citta, plused_tb_currency, plused_book, centri WHERE id_agente = " . $idAgent . " AND pat_id = atb_id_attraction AND atb_id_book = id_book AND cou_id = pat_country_id AND cit_id = pat_city_id AND pat_currency_id = cur_id AND id = atb_campus_id";
        $Q = $this->db->query($querya);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function remBookAttraction($atbId, $bookId) {
        $qDelRighe = "DELETE FROM plused_att_bookings WHERE atb_id = " . $atbId . " AND atb_id_book = " . $bookId;
        //echo $qDelRighe."<br>";
        $Q2 = $this->db->query($qDelRighe);
        return true;
    }

    function getAttractionDetailById($idAtt) {
        $data = array();
        $querya = "SELECT atb_id, atb_id_book, atb_id_year, atb_id_attraction, nome_centri, atb_tot_pax, atb_total_price, atb_currency, atb_confirmed, pat_name, cou_descrizione, cit_descrizione, cur_codice FROM plused_att_bookings, plused_attractions, plused_tb_country, plused_tb_citta, plused_tb_currency, plused_book, centri WHERE atb_id = " . $idAtt . " AND pat_id = atb_id_attraction AND atb_id_book = id_book AND cou_id = pat_country_id AND cit_id = pat_city_id AND pat_currency_id = cur_id AND id = atb_campus_id";
        $Q = $this->db->query($querya);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    /**
     * Start: functions by Arunsankar
     * @since 13 Apr 2016
     * @modified 27-Apr-2016
     * @modified_by Arunsankar
     */

    /**
     *
     * @param type $id_book
     * @return type
     */
    function getBookDet($id_book) {
        $data = array();
        $sqlid = "SELECT id_centro, MIN(data_arrivo_campus) as mindatein, MAX(data_partenza_campus) as maxdateout FROM plused_book, plused_rows WHERE plused_rows.id_book = plused_book.id_book AND plused_book.id_book = $id_book";
        $query = $this->db->query($sqlid);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rowq) {
                $data[] = $rowq;
            }
            return $data;
        }
    }

    function agentIdByBkId($book) {
        $data = null;
        $this->db->select('id_agente');
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

    function agent_detail($id) {
        $data = null;
        $this->db->where('id', $id);
        $Q = $this->db->get('agenti');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function overviewSingleBooking($idBook) {
        $data = array();
        $this->db->where('id_book = ' . $idBook);
        $Q = $this->db->get('plused_book');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data2 = array();
                $this->db->select('valuta, valore_acconto');
                $nomedelcentro = $row["id_centro"];
                $this->db->where('id', $nomedelcentro);
                $queryvaluta = $this->db->get('centri');
                $recordvaluta = $queryvaluta->result_array();
                if ($nomedelcentro != "None") {
                    $row['valuta'] = $recordvaluta[0]['valuta'];
                    $row['valore_acconto'] = $recordvaluta[0]['valore_acconto'];
                } else {
                    $row['valuta'] = "$";
                    $row['valore_acconto'] = 0;
                }
                $row['centro'] = $this->centerNameById($row["id_centro"]);
                $row['all_acco'] = $this->magenti->getBookAccomodations($row["id_book"]);
                $row['agency'] = $this->magenti->plused_get_ag_details($row["id_agente"]);
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getUnjoinedSTBookings($season) {
        $seasonArray = explode("-", $season);
        $anno = $seasonArray[0];
        $data = array();
        $dataDis = array();
        $queryDist = "SELECT id_ref_overnight FROM plused_book  WHERE YEAR(arrival_date) = $anno AND id_agente = 795 and id_ref_overnight is not null order by id_ref_overnight DESC";
        $Q = $this->db->query($queryDist);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataDis[] = $row["id_ref_overnight"];
            }
        }
        $Q->free_result();
        if (count($dataDis) == 0)
            return $data;
        $querya = "SELECT CONCAT(id_year,' ',id_book) as booking, id_book FROM plused_book WHERE YEAR(arrival_date) = $anno AND id_agente = 795 AND id_book NOT IN (" . implode(",", $dataDis) . ") order by id_book DESC";
        $Q = $this->db->query($querya);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function detMyPaxForRosterBackoffice($year, $book) {
        $data = array();
        $this->db->select('a.*, b.nat_id')
                ->from('plused_rows as a')
                ->join('plused_nationality as b', 'b.nationality=a.nazionalita', 'left')
                ->where('a.id_year', $year)
                ->where('a.id_book', $book)
                ->order_by("a.gl_rif", "asc")
                ->order_by("a.tipo_pax", "asc");
        $Q = $this->db->get();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $row["bookid"] = $row["id_year"] . "_" . $row["id_book"];
                $idAgente = $this->agentIdByBkIdYear($row["id_year"], $row["id_book"]);
                $row["businessname"] = $this->agentNameById($idAgente);
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function detMyPaxForRosterBackofficeLock($year, $book, $rowIdsNoSel) {
        $bookLock = 0;
        if (isset($rowIdsNoSel[0])) {
            unset($rowIdsNoSel[0]);
        }
        $this->db->select('count(*) as count')
                ->from('plused_book')
                ->where('id_book', $book)
                ->where('id_year', $year)
                ->where('lockPax', '1');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            $resArray = $res->result_array();
            if ($resArray[0]['count'] > 0) {
                $bookLock = 1;
            }
        }

        $orWhere = '';
        $cnt = 0;
        if (!empty($rowIdsNoSel)) {
            foreach ($rowIdsNoSel as $noSel) {
                if ($cnt > 0) {
                    $orWhere .= ' or id_prenotazione = ' . $noSel . ' ';
                } else {
                    $orWhere .= ' id_prenotazione = ' . $noSel . ' ';
                }
                $cnt += 1;
            }
            $this->db->where('(' . $orWhere . ')');


            $data = array();
            $this->db->select('a.*, b.nat_id');
            $this->db->from('plused_rows as a');
            $this->db->join('plused_nationality as b', 'b.nationality=a.nazionalita', 'left');
            if ($bookLock !== 1) {
                $this->db->where('a.lockPax', '1');
            }
            $this->db->where('a.id_year', $year);
            $this->db->where('a.id_book', $book);
            $this->db->order_by("a.gl_rif", "asc");
            $this->db->order_by("a.tipo_pax", "asc");
            $this->db->order_by("a.cognome", "asc");
            $Q = $this->db->get();
            if ($Q->num_rows() > 0) {
                foreach ($Q->result_array() as $row) {
                    $row["bookid"] = $row["id_year"] . "_" . $row["id_book"];
                    $idAgente = $this->agentIdByBkIdYear($row["id_year"], $row["id_book"]);
                    $row["businessname"] = $this->agentNameById($idAgente);
                    $data[] = $row;
                }
            }
            $Q->free_result();
            return $data;
        } else {
            return false;
        }
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

    function paymentsById($idBk) {
        $data = array();
        $this->db->where('pfp_bk_id', $idBk);
        $this->db->order_by('pfp_data_operazione');
        $Q = $this->db->get('plused_fincon_payments');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getAllPaymentTypes() {
        $data = array();
        $this->db->order_by('pfcpt_order');
        $Q = $this->db->get('plused_fincon_payment_types');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getAllPaymentServices() {
        $data = array();
        $this->db->order_by('pfcse_id');
        $Q = $this->db->get('plused_fincon_services');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function count_pax_uploaded($idbook) {
        $this->db->where('cognome IS NOT NULL');
        $this->db->where('cognome <>', '');
        $this->db->where('id_book', $idbook);
        $this->db->from('plused_rows');
        $contaCognomi = $this->db->count_all_results();
        return $contaCognomi;
    }

    function readBookingNotes($bkId, $public = 0) {
        $data = array();
        if ($public == 1)
            $this->db->where('n_public', 1);
        $this->db->where('n_bkid', $bkId);
        $this->db->order_by('n_datetime', "desc");
        $Q = $this->db->get('plused_book_notes');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function bookingExists($id) {
        $this->db->where('id_book', $id);
        $Q = $this->db->from('plused_book');
        return $this->db->count_all_results();
    }

    function lockSingleRoster($rowId) {
        $this->db->select('count(*) as count')
                ->from('plused_rows')
                ->where('(id_prenotazione IS NOT NULL AND id_prenotazione != \'\')')
                ->where('(id_book IS NOT NULL AND id_book != \'\')')
                ->where('(id_year IS NOT NULL AND id_prenotazione != \'\')')
                ->where('(accomodation IS NOT NULL AND id_year != \'\')')
                ->where('(cognome IS NOT NULL AND cognome != \'\')')
                ->where('(nome IS NOT NULL AND nome != \'\')')
                ->where('(sesso IS NOT NULL AND sesso != \'\')')
                ->where('(numero_documento IS NOT NULL AND numero_documento != \'\')')
                ->where('(tipo_pax IS NOT NULL AND tipo_pax != \'\')')
                ->where('(pax_dob IS NOT NULL AND pax_dob != \'\')')
                ->where('(andata_data_arrivo IS NOT NULL AND andata_data_arrivo != \'\')')
                ->where('(andata_apt_partenza IS NOT NULL AND andata_apt_partenza != \'\')')
                ->where('(andata_apt_arrivo IS NOT NULL AND andata_apt_arrivo != \'\')')
                ->where('(andata_volo IS NOT NULL AND andata_volo != \'\')')
                ->where('(ritorno_data_partenza IS NOT NULL AND ritorno_data_partenza != \'\')')
                ->where('(ritorno_apt_partenza IS NOT NULL AND ritorno_apt_partenza != \'\')')
                ->where('(ritorno_apt_arrivo IS NOT NULL AND ritorno_apt_arrivo != \'\')')
                ->where('(ritorno_volo IS NOT NULL AND ritorno_volo != \'\')')
                ->where('(data_arrivo_campus IS NOT NULL AND data_arrivo_campus != \'\')')
                ->where('(data_partenza_campus IS NOT NULL AND data_partenza_campus != \'\')')
                ->where('id_prenotazione', $rowId);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            if ($resultArray[0]['count'] > 0) {
                $data = array(
                    'lockPax' => 1
                );
                $this->db->where('id_prenotazione', $rowId);
                if ($this->db->update('plused_rows', $data)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return '2';
            }
        } else {
            return '2';
        }
    }

    function lockWholeRoster($bookId, $yearId) {
        $this->db->_protect_identifiers = FALSE;
        $this->db->select('count(*) as count')
                ->from('plused_rows')
                ->where('((id_prenotazione IS NULL OR id_prenotazione = \'\')')
                ->or_where('(id_book IS NULL OR id_book = \'\')')
                ->or_where('(id_year IS NULL OR id_year = \'\')')
                ->or_where('(accomodation IS NULL OR accomodation = \'\')')
                ->or_where('(cognome IS NULL OR cognome = \'\')')
                ->or_where('(nome IS NULL OR nome = \'\')')
                ->or_where('(sesso IS NULL OR sesso = \'\')')
                ->or_where('(numero_documento IS NULL OR numero_documento = \'\')')
                ->or_where('(tipo_pax IS NULL OR tipo_pax = \'\')')
                ->or_where('(pax_dob IS NULL OR pax_dob = \'\')')
                ->or_where('(andata_data_arrivo IS NULL OR andata_data_arrivo = \'\')')
                ->or_where('(andata_apt_partenza IS NULL OR andata_apt_partenza = \'\')')
                ->or_where('(andata_apt_arrivo IS NULL OR andata_apt_arrivo = \'\')')
                ->or_where('(andata_volo IS NULL OR andata_volo = \'\')')
                ->or_where('(ritorno_data_partenza IS NULL OR ritorno_data_partenza = \'\')')
                ->or_where('(ritorno_apt_partenza IS NULL OR ritorno_apt_partenza = \'\')')
                ->or_where('(ritorno_apt_arrivo IS NULL OR ritorno_apt_arrivo = \'\')')
                ->or_where('(ritorno_volo IS NULL OR ritorno_volo = \'\')')
                ->or_where('(data_arrivo_campus IS NULL OR data_arrivo_campus = \'\')')
                ->or_where('(data_partenza_campus IS NULL OR data_partenza_campus = \'\'))')
                ->where('id_book', $bookId)
                ->where('id_year', $yearId);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            if ($resultArray[0]['count'] == 0) {
                $this->db->_protect_identifiers = FALSE;
                $this->db->select('id_prenotazione')
                        ->from('plused_rows')
                        ->where('(id_prenotazione IS NOT NULL AND id_prenotazione != \'\')')
                        ->where('(id_book IS NOT NULL AND id_book != \'\')')
                        ->where('(id_year IS NOT NULL AND id_prenotazione != \'\')')
                        ->where('(accomodation IS NOT NULL AND id_year != \'\')')
                        ->where('(cognome IS NOT NULL AND cognome != \'\')')
                        ->where('(nome IS NOT NULL AND nome != \'\')')
                        ->where('(sesso IS NOT NULL AND sesso != \'\')')
                        ->where('(numero_documento IS NOT NULL AND numero_documento != \'\')')
                        ->where('(tipo_pax IS NOT NULL AND tipo_pax != \'\')')
                        ->where('(pax_dob IS NOT NULL AND pax_dob != \'\')')
                        ->where('(andata_data_arrivo IS NOT NULL AND andata_data_arrivo != \'\')')
                        ->where('(andata_apt_partenza IS NOT NULL AND andata_apt_partenza != \'\')')
                        ->where('(andata_apt_arrivo IS NOT NULL AND andata_apt_arrivo != \'\')')
                        ->where('(andata_volo IS NOT NULL AND andata_volo != \'\')')
                        ->where('(ritorno_data_partenza IS NOT NULL AND ritorno_data_partenza != \'\')')
                        ->where('(ritorno_apt_partenza IS NOT NULL AND ritorno_apt_partenza != \'\')')
                        ->where('(ritorno_apt_arrivo IS NOT NULL AND ritorno_apt_arrivo != \'\')')
                        ->where('(ritorno_volo IS NOT NULL AND ritorno_volo != \'\')')
                        ->where('(data_arrivo_campus IS NOT NULL AND data_arrivo_campus != \'\')')
                        ->where('(data_partenza_campus IS NOT NULL AND data_partenza_campus != \'\')')
                        ->where('id_book', $bookId)
                        ->where('id_year', $yearId);
                $idResult = $this->db->get();
                $dataArray = $idResult->result_array();
                $dataDet['result'] = array();
                foreach ($dataArray as $dataElement) {
                    $dataDet['result'][] = $dataElement['id_prenotazione'];
                }
                $data = array(
                    'lockPax' => 1,
                    'downloadVisa' => 1
                );
                $where = array(
                    'id_book' => $bookId,
                    'id_year' => $yearId
                );
                $this->db->where($where);
                if ($this->db->update('plused_book', $data)) {
                    $dataDet['status'] = '1';
                    return $dataDet;
                } else {
                    $dataDet['status'] = '0';
                    return $dataDet;
                }
            } else {
                $data['status'] = '2';
                return $data;
            }
        } else {
            $data['status'] = '2';
            return $data;
        }
    }

    function get_booking_detail($id) {
        $data = array();
        $this->db->where('id_book', $id);
        $Q = $this->db->get('plused_book');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $this->db->select('valuta,address,post_code,gruppo_fattura,valore_acconto,costo_homestay,costo_standard,costo_ensuite,costo_twin,nome_centri,located_in,valuta_fattura,school_name');
                $nomedelcentro = $row["id_centro"];
                $this->db->where('id', $nomedelcentro);
                $queryvaluta = $this->db->get('centri');
                $recordvaluta = $queryvaluta->result_array();
                $row['address'] = utf8_decode($recordvaluta[0]['address']);
                $row['post_code'] = utf8_decode($recordvaluta[0]['post_code']);
                $row['valuta'] = utf8_decode($recordvaluta[0]['valuta']);
                $row['gruppo_fattura'] = $recordvaluta[0]['gruppo_fattura'];
                $row['valore_acconto'] = $recordvaluta[0]['valore_acconto'];
                $row['costo_homestay'] = $recordvaluta[0]['costo_homestay'];
                $row['costo_standard'] = $recordvaluta[0]['costo_standard'];
                $row['costo_ensuite'] = $recordvaluta[0]['costo_ensuite'];
                $row['costo_twin'] = $recordvaluta[0]['costo_twin'];
                $row['centro_name'] = $recordvaluta[0]['nome_centri'];
                $row['located_in'] = $recordvaluta[0]['located_in'];
                $row['valuta_fattura'] = $recordvaluta[0]['valuta_fattura'];
                $row['school_name'] = $recordvaluta[0]['school_name'];
                $data[] = $row;
                $queryvaluta->free_result();
            }
        }
        $Q->free_result();
        return $data;
    }

    function getDwnVisaByLock($id) {
        $this->db->select('count(*) as count')
                ->from('plused_book')
                ->where('id_book', $id)
                ->where('lockPax', 1);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            if ($resultArray[0]['count'] > 0) {
                return TRUE;
            } else {
                $this->db->select('count(*) as count')
                        ->from('plused_rows')
                        ->where('id_book', $id)
                        ->where('lockPax', 1);
                $result = $this->db->get();
                if ($result->num_rows() > 0) {
                    $resultArray = $result->result_array();
                    if ($resultArray[0]['count'] > 0) {
                        return TRUE;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }
        return FALSE;
    }

    function getSngVisaByLock($id, $book) {
        $this->db->select('count(*) as count')
                ->from('plused_book')
                ->where('id_book', $book)
                ->where('lockPax', 1);
        $resultBook = $this->db->get();
        if ($resultBook->num_rows() > 0) {
            $resultBookArray = $resultBook->result_array();
            if ($resultBookArray[0]['count'] > 0) {
                return TRUE;
            } else {
                $this->db->select('count(*) as count')
                        ->from('plused_rows')
                        ->where('id_prenotazione', $id)
                        ->where('lockPax', 1);
                $result = $this->db->get();
                if ($result->num_rows() > 0) {
                    $resultArray = $result->result_array();
                    if ($resultArray[0]['count'] > 0) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                }
            }
        }

        return FALSE;
    }

    function listPax($book, $type = "GL", $locked = NULL) {
        $data = array();
        $locked == 1 ? $this->db->where('lockPax', 1) : '';
        $this->db->select('id_prenotazione,nome, cognome, sesso, pax_dob, numero_documento, template, template_date');
        $this->db->where('id_book', $book);
        $this->db->where('tipo_pax', $type);
        $this->db->order_by("gl_rif", "asc");
        $this->db->order_by("tipo_pax", "asc");
        $this->db->order_by("cognome", "asc");
        $Q = $this->db->get('plused_rows');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function listSinglePax($id) {
        $data = array();
        $this->db->select('nome, cognome, tipo_pax, sesso, pax_dob, numero_documento, template, template_date');
        $this->db->where('id_prenotazione', $id);
        $this->db->order_by("gl_rif", "asc");
        $this->db->order_by("tipo_pax", "asc");
        $this->db->order_by("cognome", "asc");
        $Q = $this->db->get('plused_rows');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function checkPaxLock($yearId, $bookId) {
        $this->db->select('count(*) as count')
                ->from('plused_book')
                ->where('id_book', $bookId)
                ->where('id_year', $yearId)
                ->where('lockPax', '1');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            if ($resultArray[0]['count'] > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function checkAnyPaxLocked($bookId) {
        $this->db->select('count(*) as count')
                ->from('plused_book')
                ->where('id_book', $bookId)
                ->where('lockPax', '1');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            if ($resultArray[0]['count'] > 0) {
                return TRUE;
            } else {
                $this->db->select('count(*) as count')
                        ->from('plused_rows')
                        ->where('id_book', $bookId)
                        ->where('lockPax', '1');
                $result = $this->db->get();
                if ($result->num_rows() > 0) {
                    $resultArray = $result->result_array();
                    if ($resultArray[0]['count'] > 0) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                } else {
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Function to get the list of mapped template with campus
     * @author Arunsankar
     * @param type $idCentri
     * @return boolean
     */
    function getTemplateList($idCentri) {
        $this->db->select('distinct(template)')
                ->from('plused_temp_campus')
                ->where('centri_id', $idCentri);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $resultArray = $result->result_array();
        } else {
            return FALSE;
        }
    }

    /**
     * Function to get the template list with nationality mapped
     * @author Arunsankar
     * @param type $idCentri
     * @return boolean
     */
    function getTemplateListNatMapped($idCentri) {
        $this->db->select('concat(a.template,b.nat_id) as tempMap, a.template', false)
                ->from('plused_temp_campus as a')
                ->join('plused_temp_nationality as b', 'a.template=b.template')
                ->where('a.centri_id', $idCentri);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $resultArray = $result->result_array();
        } else {
            return FALSE;
        }
    }

    /**
     * Function to get the template list without nationality mapped
     * @author Arunsankar
     * @param type $idCentri
     * @return boolean
     */
    function getTemplateListWithoutNatMapped($idCentri) {
        $this->db->select('a.template as tempMap, a.template', false)
                ->from('plused_temp_campus as a')
                ->where('a.centri_id', $idCentri);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $resultArray = $result->result_array();
        } else {
            return FALSE;
        }
    }

    /**
     * Function to check the booking is locked
     * @author Arunsankar
     * @param type $bookId
     * @return string|boolean
     */
    function checkBookLocked($bookId) {
        $this->db->select('count(*) as count')
                ->from('plused_book')
                ->where('id_book', $bookId)
                ->where('lockPax', '1');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            if ($resultArray[0]['count'] > 0) {
                return 'locked';
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Function to check the template is valid or not
     * @author Arunsankar
     * @param type $template
     * @param type $book
     * @return boolean
     */
    function checkValidTemplate($template, $book) {
        $this->db->select('id_centro')
                ->from('plused_book')
                ->where('id_book', $book);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            $this->db->select('count(*) as count')
                    ->from('plused_temp_campus')
                    ->where('centri_id', $resultArray[0]['id_centro'])
                    ->where('template', $template);
            $result = $this->db->get();
            if ($result->num_rows()) {
                $resultArr = $result->result_array();
                if ($resultArr[0]['count'] > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Function to check the booking is mapped with template
     * @author Arunsankar
     * @param type $book
     * @return boolean
     */
    function checkMappedTemplate($book) {
        $this->db->select('count(*) as count')
                ->from('plused_temp_campus as a')
                ->join('plused_book as b', 'a.centri_id = b.id_centro')
                ->where('b.id_book', $book);
        $result = $this->db->get();
        if ($result->num_rows()) {
            $resultArray = $result->result_array();
            if ($resultArray[0]['count'] > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Get campus id form book id
     * @author Arunsankar
     * @param type $bookId
     * @return boolean
     */
    function getCentriId($bookId) {
        $this->db->select('distinct(id_centro) as id_centro')
                ->from('plused_book')
                ->where('id_book', $bookId);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            return $resultArray[0]['id_centro'];
        } else {
            return FALSE;
        }
    }

    /**
     * Fucntion to lock a single template
     * @author Arunsankar
     * @param type $rowId
     * @param type $selValue
     * @return boolean
     */
    function lockTemplate($rowId, $selValue) {
        $data = array(
            'template' => $selValue,
            'template_date' => date('Y-m-d H:i:s')
        );
        $where = array(
            'id_prenotazione' => $rowId,
            'template' => NULL
        );
        $this->db->where($where);
        $isUpdate = $this->db->update('plused_rows', $data);
        if ($isUpdate) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Function to lock the selected templates with the pax
     * @author Arunsankar
     * @param int $bookId
     * @param array $rowArr
     * @param char $iniTmpl
     * @return boolean
     */
    function lockTemplates($bookId, $rowArr, $iniTmpl = NULL) {
        foreach ($rowArr as $row) {
            $rowVal = explode('-', $row);
            if ($rowVal[1]) {
                $data = array(
                    'template' => $rowVal[1],
                    'template_date' => date('Y-m-d H:i:s')
                );
                $where = array(
                    'id_prenotazione' => $rowVal[0]
                );
                $this->db->where($where);
                $isUpdate = $this->db->update('plused_rows', $data);
            }
        }
        if ($iniTmpl != '') {
            $data = array(
                'template' => $iniTmpl,
                'template_date' => date('Y-m-d H:i:s')
            );
            $where = array(
                'id_book' => $bookId
            );
            $isUpdate = $this->db->update('plused_book', $data);
        }
        if ($isUpdate) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Function to get book id form pax id
     * @author Arunsankar
     * @param type $rowId
     * @return boolean
     */
    function getBookId($rowId) {
        $this->db->select('id_book')
                ->from('plused_rows')
                ->where('id_prenotazione', $rowId);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            return $resultArray[0]['id_book'];
        } else {
            return FALSE;
        }
    }

    /**
     * Fucntion to cross check the nationality, campus and pax
     * @author Arunsankar
     * @param type $bookId
     * @param type $template
     * @param type $id
     * @return boolean
     */
    function checkNationality($bookId, $template, $id) {
        $nationality = '';
        $natId = '';
        $this->db->select('nazionalita')
                ->from('plused_rows')
                ->where('id_prenotazione', $id);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            $nationality = $resultArray[0]['nazionalita'];
        }
        if ($nationality) {
            $this->db->select('nat_id')
                    ->from('plused_nationality')
                    ->where('nationality', $nationality);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                $resultArray = $result->result_array();
                $natId = $resultArray[0]['nat_id'];
            }
        }
        $this->db->select('id_centro')
                ->from('plused_book')
                ->where('id_book', $bookId);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            $this->db->select('template')
                    ->from('plused_temp_campus')
                    ->where('centri_id', $resultArray[0]['id_centro'])
                    ->where('template', $template);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                $resultArray = $result->result_array();
                $this->db->select('count(*) as count')
                        ->from('plused_temp_nationality')
                        ->where('nat_id', $natId)
                        ->where('template', $resultArray[0]['template']);
                $result = $this->db->get();
                if ($result->num_rows() > 0) {
                    $resultArray = $result->result_array();
                    if ($resultArray[0]['count'] > 0) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Function to check if the typed nationality is available
     * @param type $nationality
     * @return boolean
     */
    function checkTypedNationality($nationality) {
        $this->db->select('count(*) as count')
                ->from('plused_nationality')
                ->where('nationality', $nationality);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            if ($resultArray[0]['count'] > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Function to get campus details from book id
     * @author Arunsankar
     * @param int $id
     * @return boolean, array
     */
    function getCampusByBookId($id) {
        $this->db->select('a.id_centro, b.nome_centri')
                ->from('plused_book as a')
                ->join('centri as b', 'a.id_centro=b.id')
                ->where('b.attivo', 1)
                ->where('a.id_book', $id);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    /**
     * Function to get the list of courses from supplement table
     * @author Arunsankar
     * @param int $idCentro
     * @return boolean, array
     */
    function getCourseList($idCentro) {
        $this->db->select('a.plr_id, a.description')
                ->from('plused_roster_supplements as a')
                ->join('plused_roster_supplement_types as b', 'a.supl_id=b.id')
                ->where('a.centri_id', $idCentro);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    function getNationality() {
        $this->db->select('nationality')
                ->from('plused_nationality')
                ->where('active', 1)
                ->order_by('nationality');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $resultArray = $result->result_array();
        } else {
            return FALSE;
        }
    }

    function getNationalityString() {
        $this->db->query('SET SESSION group_concat_max_len = 1000000');
        $this->db->select('substring_index(group_concat(nationality SEPARATOR \',\'), \',\', 10) as nationality', false)
                ->from('plused_nationality')
                ->where('active', 1)
                ->limit(10);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resultArray = $result->result_array();
            return $resultArray[0]['nationality'];
        } else {
            return FALSE;
        }
    }

    /**
     * Function to insert into plused_rows
     * @author Arunsankar
     * @since 18-May-2016
     * @param array $sheetVal
     */
    function insertPaxImport($sheetVal) {
        $data = array(
            'cognome' => $sheetVal[1],
            'nome' => $sheetVal[2],
            'sesso' => $sheetVal[3],
            'pax_dob' => $sheetVal[4],
            'numero_documento' => $sheetVal[5],
            'salute' => $sheetVal[6],
            'share_room' => $sheetVal[7],
            'gl_rif' => $sheetVal[8],
        );
        $isInsert = $this->db->insert('plused_rows', $data);
        if ($isInsert) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Function to update plused_rows
     * @author Arunsankar
     * @since 18-May-2016
     * @param array $sheetVal
     */
    function updatePaxImport($sheetVal) {
        $data = array(
            'cognome' => $sheetVal[1],
            'nome' => $sheetVal[2],
            'sesso' => $sheetVal[3],
            'pax_dob' => $sheetVal[4],
            'nazionalita' => $sheetVal[7],
            'accomodation' => $sheetVal[8],
            'numero_documento' => $sheetVal[9],
            'salute' => $sheetVal[10],
            'share_room' => $sheetVal[11],
            'gl_rif' => $sheetVal[12]
        );
        $this->db->where('id_prenotazione', $sheetVal[13]);
        $isUpdate = $this->db->update('plused_rows', $data);
        if ($isUpdate) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Function to get the count of pax
     * @author Arunsankar
     * @since 19-May-2016
     * @param int $paxId
     * @return boolean
     */
    function getImportPaxCount($paxId) {
        $this->db->select('count(*) as count')
                ->from('plused_rows')
                ->where('id_prenotazione', $paxId);
        $result = $this->db->get();
        if ($result->num_rows()) {
            $resultData = $result->result_array();
            if ($resultData[0]['count'] > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Function to check the pax is locked
     * @author Arunsankar
     * @since 19-May-2016
     * @param int $paxId
     * @return boolean
     */
    function checkPaxIsLocked($paxId) {
        $this->db->select('count(*) as count')
                ->from('plused_rows')
                ->where('id_prenotazione', $paxId)
                ->where('lockPax', 1);
        $result = $this->db->get();
        if ($result->num_rows()) {
            $resultData = $result->result_array();
            if ($resultData[0]['count'] == 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Function to check the pax is valid
     * @author Arunsankar
     * @since 19-May-2016
     * @param int $paxId
     * @param int $bookId
     * @return boolean
     */
    function checkPaxIsValid($paxId, $bookId) {
        $this->db->select('count(*) as count')
                ->from('plused_rows')
                ->where('id_prenotazione', $paxId)
                ->where('id_book', $bookId);
        $result = $this->db->get();
        if ($result->num_rows()) {
            $resultData = $result->result_array();
            if ($resultData[0]['count'] > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Function to check the template is locked to booking
     * @author Arunsankar
     * @since 19-May-2016
     * @param char $template
     * @param int $bookId
     * @return boolean
     */
    function checkBookTemplate($bookId, $template) {
        $this->db->select('count(*) as count')
                ->from('plused_book')
                ->where('id_book', $bookId)
                ->where('template', $template)
                ->where('lockPax', 1);
        $result = $this->db->get();
        if ($result->num_rows()) {
            $resultData = $result->result_array();
            if ($resultData[0]['count'] > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Function to check the total count of single pax
     * @author Arunsankar
     * @since 04-Apr-2017
     * @param int $bookId
     * @return boolean
     */
    function checkBookLockedPax($bookId) {
        $this->db->select('count(*) as count')
                ->from('plused_rows')
                ->where('id_book', $bookId)
                ->where('lockPax', 1);
        $result = $this->db->get();
        if ($result->num_rows()) {
            $resultData = $result->result_array();
            if ($resultData[0]['count'] > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Function to check the template is locked
     * @author Arunsankar
     * @since 19-May-2016
     * @param char $template
     * @param int $rowid
     * @param int $bookId
     * @return boolean
     */
    function checkLockTemplate($template, $rowid, $bookId) {
        $this->db->select('count(*) as count')
                ->from('plused_book')
                ->where('id_book', $bookId)
                ->where('lockPax', 1);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $resArray = $result->result_array();
            if ($resArray[0]['count'] == 0) {
                $this->db->where('lockPax', 1);
            }
        }
        $this->db->select('count(*) as count')
                ->from('plused_rows')
                ->where('id_prenotazione', $rowid)
                ->where('template', $template);
        $result = $this->db->get();
        if ($result->num_rows()) {
            $resultData = $result->result_array();
            if ($resultData[0]['count'] > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function getAgentForMatch($user) {
        $data = array();
        $options = array('login' => $this->db->escape_str($user), 'status' => 'active');
        $Q = $this->db->getwhere('agenti', $options, 1);

        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $row["ruolo"] = "agente";
                $data[] = $row;
            }
            $Q->free_result();
            return $data;
        } else {
            $options = array('email' => $this->db->escape_str($user));
            $Q2 = $this->db->getwhere('plused_account-manager', $options, 1);
            if ($Q2->num_rows() > 0) {
                foreach ($Q2->result_array() as $row) {
                    $row["ruolo"] = "manager";
                    $data[] = $row;
                }
                $Q2->free_result();
                return $data;
            } else {
                $options = array('email' => $this->db->escape_str($user));
                $Q3 = $this->db->getwhere('plused_mediaviewers', $options, 1);
                if ($Q3->num_rows() > 0) {
                    foreach ($Q3->result_array() as $row) {
                        $row["ruolo"] = "mediaViewer";
                        $data[] = $row;
                    }
                    $Q3->free_result();
                    return $data;
                } else {
                    $Q3->free_result();
                    return $data;
                }
            }
        }
    }

    function updateAgentData($password, $agentId = 0, $role) {
        if ($password != "" && is_numeric($agentId) && !empty($agentId) && $role != "") {
            if ($role == 'agente') {
                $updateArr = array('password' => $password);
                $table = 'agenti';
            } else if ($role == 'manager') {
                $updateArr = array('pwd' => $password);
                $table = 'plused_account-manager';
            } else if ($role == 'mediaViewer') {
                $updateArr = array('pwd' => $password);
                $table = 'plused_mediaviewers';
            }

            $this->db->where('id', $agentId);
            $result = $this->db->update($table, $updateArr);
            return 1;
        }
        return 0;
    }

    function setBusinessName($agent, $business_name) {
        $this->db->where('id', $agent);
        $result = $this->db->update('agenti', array('businessname' => $business_name));
    }

    function setPriceCategory($agent, $price_category) {
        $this->db->where('id', $agent);
        $result = $this->db->update('agenti', array('pricecategory' => $price_category));
    }

    //end: functions by Arunsankar S

    function setEmailAddress($agent, $email_address) {
        $this->db->where('email', $email_address);
        $result = $this->db->get('agenti');
        if ($result->num_rows()) {
            return 0;
        } else {
            $this->db->where('id', $agent);
            $result = $this->db->update('agenti', array('email' => $email_address));
            return 1;
        }
        return 0;
    }

    /* Author : Arunsankar 
     * Purpose: Get distinct contries from agenti table
     */

    function getAgentCountryList() {
        $this->db->select("distinct(businesscountry) as country");
        $this->db->from('agenti');
        $this->db->orderBy('businesscountry');
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->result_array() : array();
    }

    /* Author : Arunsankar 
     * Purpose: Get agent details with account manager
     */

    function getAgentDetails($id = 0) {
        $this->db->select("a.id, CONCAT(a.mainfirstname,' ',a.mainfamilyname) as agentname, a.mainfirstname, a.mainfamilyname,a.email as agentemail, a.businessname, a.businessaddress, a.businesscity, a.businesscountry, a.businesspostalcode, a.businesstelephone,  account, CONCAT( am.firstname, ' ', am.familyname ) as account_manager_name, am.firstname, am.familyname, am.position", FALSE);
        $this->db->from("agenti a");
        $this->db->join("`plused_account-manager` am", "am.id = a.account");

        if ($id) {
            $this->db->where(array('a.id' => $id));
        }

        $result = $this->db->get();
        //echo $this->db->last_query();exit;
        return ($result->num_rows() > 0) ? $result->result_array() : array();
    }

    /* Author : Arunsankar 
     * Purpose: Get agent details with account manager
     */

    function getAgentDetailsUsingFilter($agentName = '', $accountmanagername = '', $selCountry = array()) {
        $this->db->select("a.id, CONCAT(a.mainfirstname,' ',a.mainfamilyname) as agentname, a.mainfirstname, a.mainfamilyname, a.email as agentemail, a.businessaddress, a.businesspostalcode, a.businesstelephone, a.businessname, a.businesscity, a.businesscountry, CONCAT( am.firstname, ' ', am.familyname ) as account_manager_name, am.firstname, am.familyname, am.position", FALSE);
        $this->db->from("agenti a");
        $this->db->join("`plused_account-manager` am", "am.id = a.account");

        if ($selCountry) {
            $this->db->where_in('a.businesscountry', $this->db->escape($selCountry));
        }

        if ($agentName) {
            $this->db->or_like("CONCAT(a.mainfirstname,' ',a.mainfamilyname)", $agentName);
        }

        if ($accountmanagername) {
            $this->db->or_like("CONCAT( am.firstname, ' ', am.familyname )", $accountmanagername);
        }

        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->result_array() : array();
    }

    /* Author : Arunsankar 
     * Purpose: Get agent details for autocomplete
     */

    function getAgentNameAutoComplete($name) {
        $data = array();
        $this->db->select("a.id,a.mainfirstname,a.mainfamilyname");
        $this->db->or_like("CONCAT( a.mainfirstname, ' ', a.mainfirstname )", $name);
        $result = $this->db->get('agenti a');
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $rowOk["id"] = $row["id"];
                $rowOk["label"] = $row["mainfirstname"] . ' ' . $row["mainfamilyname"];
                $rowOk["value"] = $row["id"];
                $data[] = $rowOk;
            }
        }
        $result->free_result();
        return json_encode($data);
    }
    
    /* Author : SK 
     * Purpose: Get businessname details for autocomplete
     */
    function getBusinessNameAutoComplete($name) {
        $data = array();
        $this->db->select("a.id,a.businessname");
        $this->db->or_like("a.businessname", $name);
        $result = $this->db->get('agenti a');
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $rowOk["id"] = $row["id"];
                $rowOk["label"] = $row["businessname"];
                $rowOk["value"] = $row["businessname"];
                $data[] = $rowOk;
            }
        }
        $result->free_result();
        return json_encode($data);
    }

    /* Author : Arunsankar 
     * Purpose: Get account manager details for autocomplete
     */

    function getAccountManagerNameAutoComplete($name) {
        $data = array();
        $this->db->select("am.id,am.firstname,am.familyname");
        $this->db->or_like(array('firstname' => $name, 'familyname' => $name));
        $result = $this->db->get('plused_account-manager am');
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $rowOk["id"] = $row["id"];
                $rowOk["label"] = $row["firstname"] . ' ' . $row["familyname"];
                $rowOk["value"] = $row["id"];
                $data[] = $rowOk;
            }
        }
        $result->free_result();
        return json_encode($data);
    }

    /* Author : Arunsankar 
     * Purpose: Get distinct contries from agenti table
     */

    function getCountryList() {
        $this->db->select("distinct(cou_descrizione) as country");
        $this->db->from('plused_tb_country');
        $this->db->orderBy('cou_descrizione');
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->result_array() : array();
    }

    /* Author : Arunsankar 
     * Purpose: To Add and updated agent details
     */

    public function Agentaction($action, $arrData = array(), $edit_id = 0) {
        switch ($action) {
            case 'insert':
                $this->db->insert('agenti', $arrData);
                return $this->db->insert_id();
                break;
            case 'update':
                $this->db->where('id', $edit_id);
                $this->db->update('agenti', $arrData);
                return $edit_id;
                break;
            case 'delete':
                $this->db->where('id', $edit_id);
                $this->db->delete('agenti');
                return $edit_id;
                break;
        }
    }

    /* Author : Arunsankar 
     * Purpose: To change the transfer status for particular booking for all pax
     */

    public function updateTransferStatus($bookId, $status) {
        $this->db->where('id_book', $bookId);
        $arrData = array(
            'flag_transfer' => $status
        );
        $this->db->update('plused_book', $arrData);
        return 1;
    }

    function paginateAgentData($search, $params = array()) {
        $this->db->select("a.id, CONCAT(a.mainfirstname,' ',a.mainfamilyname) as agentname, a.businessname, a.businesscity, a.businesscountry, CONCAT( am.firstname, ' ', am.familyname ) as account_manager_name, am.position", FALSE);

        $this->agentSearchParam($search);
        $this->db->limit($params['offset'], $params['start']);
        $this->db->order_by($params['column'], $params['type']);

        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->result_array() : array();
    }

    function getAgentCount($search) {
        $this->agentSearchParam($search);

        return $this->db->count_all_results();
    }

    function getAgentInfo($id) {
        $this->db->select("a.id, CONCAT(a.mainfirstname,' ',a.mainfamilyname) as agentname, a.mainfirstname, a.mainfamilyname, a.email as agentemail, a.businessaddress, a.businesspostalcode, a.businesstelephone, a.businessname, a.businesscity, a.businesscountry, CONCAT( am.firstname, ' ', am.familyname ) as account_manager_name, am.firstname, am.familyname, am.position", FALSE);
        $this->db->from("agenti a");
        $this->db->join("`plused_account-manager` am", "am.id = a.account");
        $this->db->where('a.id', $id);

        $result = $this->db->get();
        return $result->row_array();
    }

    function agentSearchParam($search) {
        $this->db->from("agenti a");
        $this->db->join("`plused_account-manager` am", "am.id = a.account");

        if ($search['selCountry']) {
            $this->db->where_in('a.businesscountry', $this->db->escape($search['selCountry']));
        }

        if ($search['agentName']) {
            $this->db->like("CONCAT(a.mainfirstname,' ',a.mainfamilyname)", $search['agentName']);
        }
        
        if ($search['businessName']) {
            $this->db->like("a.businessname", $search['businessName']);
        }

        if ($search['accountManager']) {
            $this->db->like("CONCAT( am.firstname, ' ', am.familyname )", $search['accountManager']);
        }

        if ($search['search']) {
            $this->db->where('(businessname LIKE "%' . $search['search'] . '%" OR '
                    . 'businesscity LIKE "%' . $search['search'] . '%" OR '
                    . 'businessname LIKE "%' . $search['search'] . '%" OR '
                    . 'businesscountry LIKE "%' . $search['search'] . '%" OR '
                    . 'a.businesscountry LIKE "%' . $search['search'] . '%" OR '
                    . 'CONCAT(a.mainfirstname," ",a.mainfamilyname) LIKE "%' . $search['search'] . '%" OR '
                    . 'CONCAT( am.firstname, " ", am.familyname ) LIKE "%' . $search['search'] . '%" OR '
                    . 'position LIKE "%' . $search['search'] . '%")');
        }
    }
    
    function getCampusPdfForAgent($campus_id) {
        $this->db->select("campus_single_pdf_id,title,pdf_path");
        $this->db->from("plused_campus_single_pdf_for_agents");
        $this->db->where("campus_id", $campus_id);
        $this->db->order_by("sequence","asc");
        $data = $this->db->get();
        if($data->num_rows())
            return $data->result_array();
        else
            return 0;
    }

}
