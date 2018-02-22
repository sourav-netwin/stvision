<?php

class Gestione_centri extends Controller {

function index() {
    //Controllo se l'utente è loggato

    $is_logged_in = $this->session->userdata('is_logged_in');
    if (!isset($is_logged_in) || ($is_logged_in != true)) {


        redirect('gestione_centri/login_permits');
        die();
    }
    // Fine controllo

    $this->load->model('gestione_centri_model');
    $this->load->helper(array('form', 'url'));

    $this->load->library('validation');
    //Popolo select
    //Routine di validazione dei campi form
    $rules['date_start'] = "required";
    $rules['date_end'] = "required";
    $rules['totpax'] = "required";
    $rules['arrival_time'] = "required";
    //$rules['arrival_airport'] = "required";
    $rules['arrival_flight'] = "required";
    $rules['departure_time'] = "required";
    //$rules['departure_airport'] = "required";
    $rules['departure_flight'] = "required";


    $this->validation->set_rules($rules);

    //Booking IN validation//

    $fields['date_start'] = 'Data inizio';
    $fields['arrival_time'] = 'Orario arrivo';
    //$fields['arrival_airport'] = 'Aereporto arrivo';
    $fields['arrival_flight'] = 'Numero volo arrivo';
    $fields['arrival_service'] = 'Servizio arrivo';

    //Booking OUT validation//

    $fields['date_end'] = 'Data fine';
    $fields['departure_time'] = 'Orario partenza';
    //$fields['departure_airport'] = "Aereporto partenza";
    $fields['departure_flight'] = "Numero volo partenza";
    $fields['departure_service'] = 'Servizio partenza';

    $fields['totpax'] = 'Totale passeggeri';
    $fields['building'] = 'Centri';
    $fields['agency_building'] = 'Agenzie';
    $fields['group_leader'] = 'Gruppo Leader';
    $fields['group'] = 'N Group Leader';
    $fields['airport'] = 'Aereoporto';


    $this->validation->set_error_delimiters('<div class="error"> ** ', ' ** </div>');

    $this->validation->set_fields($fields);


    if ($this->validation->run() == FALSE) {
        $data['centri'] = $this->gestione_centri_model->building();
        $data['agency'] = $this->gestione_centri_model->agency_building();
        $data['group'] = $this->gestione_centri_model->n_group_leader();
        $data['aereo_in'] = $this->gestione_centri_model->airport();
        $data['aereo_out'] = $this->gestione_centri_model->airport();
        $data['title'] = "Booking form";
        $this->load->view('form_start', $data);
    } else {

        $data['centri'] = $this->gestione_centri_model->insert();
        $this->load->view('form_validation');
    }
}
function add_agent(){
        //Controllo se l'utente è loggato

            $is_logged_in = $this->session->userdata('is_logged_in');
            if (!isset($is_logged_in) || ($is_logged_in != true)) {


        redirect('gestione_centri/login_permits');
        die();
    }


    $this->load->model('gestione_centri_model'); 
    $this->load->helper(array('form', 'url'));
    $this->load->library('validation');

    $rules['agent'] = "required";

    $this->validation->set_rules($rules);
    $fields['name'] = 'Agent';

    $this->validation->set_fields($fields);

    if ($this->validation->run() == FALSE) {
        $this->load->view('hp_insert_agent'); 
    } else {

        $data['centri'] = $this->gestione_centri_model->insert_agent();
        $this->load->view('form_validation');
    }

}

function add_destination(){
            //Controllo se l'utente è loggato

                $is_logged_in = $this->session->userdata('is_logged_in');
                if (!isset($is_logged_in) || ($is_logged_in != true)) {


            redirect('gestione_centri/login_permits');
            die();
        }
        
        
        $this->load->model('gestione_centri_model'); 
        $this->load->helper(array('form', 'url'));
        $this->load->library('validation');
        
        $rules['centri'] = "required";
        
        $this->validation->set_rules($rules);
        $fields['nome_centri'] = 'Centri';
        
        $this->validation->set_fields($fields);
        
        if ($this->validation->run() == FALSE) {
            $this->load->view('hp_insert_centri'); 
        } else {

            $data['centri'] = $this->gestione_centri_model->insert_center();
            $this->load->view('form_validation');
        }
        
}

//BOX LOGIN
function login() {

    $this->load->view('login_form');
}

// Login di errore
function login_error() {

    $data['error'] = "User or password incorrect .. please try again!";
    $this->load->view('login_form', $data);
}

// Login senza permessi
function login_permits() {

    //$data['permits'] = "Yuo don't have a permission to continue... register please! ";
    $this->load->view('login_form');
}

function logout() { {
        $this->session->sess_destroy();
        $data['logout'] = "You have been logged out.";
        $this->load->view('login_form', $data);
    }
}

//Controllo login corretta o sbagliata
function dati_ok() {

    $this->load->model('gestione_centri_model');
    $query = $this->gestione_centri_model->validate();

    if ($query) {
        echo "ok";
        $data = array(
            'username' => $this->input->post('username'),
            'is_logged_in' => true
        );
        $this->session->set_userdata($data);
        redirect('gestione_centri');
    } else {

        $this->login_error();
    }
}

/*
  function csv ()

  {
  $this->load->library('Csvreader');

  $filePath = 'http://localhost/plus/csv/products.csv';

  $data['csvData'] = $this->csvreader->parse_file($filePath);

  $this->load->view('csv_view', $data);
  }

 */

function presearch() {

    //Controllo se l'utente è loggato

    $is_logged_in = $this->session->userdata('is_logged_in');
    if (!isset($is_logged_in) || ($is_logged_in != true)) {


        redirect('gestione_centri/login_permits');
        die();
    }

    // Fine controllo
    $this->load->model('gestione_centri_model');
    $data['centri'] = $this->gestione_centri_model->building();
    $data['agency'] = $this->gestione_centri_model->agency_building();
    $data['cerca'] = 'Booking review';
    $this->load->view('form_search', $data);
}

function info() {
    //Controllo le informazioni riguaro a quell'id
    $this->load->model('gestione_centri_model');
    $day = $this->uri->segment(3);
    $centro = $this->uri->segment(4);
    $data['group'] = $this->gestione_centri_model->information($day, $centro);
    $data['nomi_centri'] = $this->gestione_centri_model->nomi_centri($centro);
    
    $data['nomi_agenzie'] = $this->gestione_centri_model->nomi_agenzie($data['group'][0]['id_agency']);
    $data['nomi_airport_arrive'] = $this->gestione_centri_model->nomi_air_arrive($data['group'][0]['id_airport_arrivo']);
    $data['nomi_airport_departure'] = $this->gestione_centri_model->nomi_air_dep($data['group'][0]['id_airport_partenza']);
    $this->load->view('info_details', $data);
}

function info_agency() {
    //Controllo le informazioni riguaro a quell'id
    $this->load->model('gestione_centri_model');
    $day = $this->uri->segment(3);
    $centro = $this->uri->segment(4);
    $data['group'] = $this->gestione_centri_model->information_agency($day,$centro);
    
    $data['nomi_agenzie'] = $this->gestione_centri_model->nomi_agenzie($data['group'][0]['id_agency']);
    $data['nomi_centri'] = $this->gestione_centri_model->nomi_centri($centro);
    $data['nomi_airport_arrive'] = $this->gestione_centri_model->nomi_air_arrive($data['group'][0]['id_airport_arrivo']);
    $data['nomi_airport_departure'] = $this->gestione_centri_model->nomi_air_dep($data['group'][0]['id_airport_partenza']);
    $this->load->view('info_details_agency', $data);
}

function search_agency() {
    $centri=array();
    //Controllo le informazioni riguaro a quell'id
    $this->load->model('gestione_centri_model');
    $idagency = $_POST['agency'];
    
    $data['agency'] = $this->gestione_centri_model->search_agency($idagency);
    
    $this->load->view('risult_search_agency', $data);
}

function search() {

    $this->load->helper(array('form', 'url'));
    $this->load->library('validation');
// Carica i valori mese x la ricerca (primo campo)//
    $mese_nome = $_POST['mese'];

// Carica l'elenco dei centr (secono campo)//
    $idcentro = $_POST['centro'];
    $data_check = '';
    
    $valorepax = array();
    $stringapax = array();
    $stringadati = array();
    $valore_id = array();
    $data_inizio= array();
    $valore_date= array();
    $valoreflag = array();

//Switch case che controlla i mesi e le date

    switch ($mese_nome) {


        case ("feb"):

            $mese = 29;
            if ($mese_nome == "feb") {
                $data_check = "2011-02-";
            }
            break;

        case ("nov" || "apr" || "giu" || "set"):

            $mese = 31;

            if ($mese_nome == "nov") {
                $data_check = "2011-11-";
            }
            if ($mese_nome == "apr") {
                $data_check = "2011-04-";
            }
            if ($mese_nome == "giu") {
                $data_check = "2011-06-";
            }
            if ($mese_nome == "set") {
                $data_check = "2011-09-";
            }

        default:

            $mese = 32;

            if ($mese_nome == "gen") {
                $data_check = "2011-01-";
            }
            if ($mese_nome == "mar") {
                $data_check = "2011-03-";
            }
            if ($mese_nome == "mag") {
                $data_check = "2011-05-";
            }
            if ($mese_nome == "lug") {
                $data_check = "2011-07-";
            }
            if ($mese_nome == "ago") {
                $data_check = "2011-08-";
            }
            if ($mese_nome == "ott") {
                $data_check = "2011-10-";
            }
            if ($mese_nome == "dic") {
                $data_check = "2011-12-";
            }
            break;
    }

    
    $tot_pax = 0;
    
    //$num_array_datafine=array();
    
    $this->load->model('gestione_centri_model');
    $insegnanti = $this->gestione_centri_model->proff($idcentro);
    $result = count($insegnanti);
    $data['insegnanti'] = $result;
    
    
    for ($i = 1; $i < $mese; $i++) {

        //Metto il valore 0 dai numeri 1 al 9//

        if ($i <= 9) {
            $check = $data_check . "0" . $i;
        } else {

            $check = $data_check . $i;   
       } 
             
                
        
        $data['somma'] = $this->gestione_centri_model->gruppo($check, $idcentro);
        $data['flagrecord'] = $this->gestione_centri_model->gruppoflag($check, $idcentro);


        $data['flaginfo']=array_push($valoreflag, $data['flagrecord'][0]['id']);
        
        $prova=$data['somma'] ;
        
           /*    
                    $i = 0;
                        foreach ($data['somma'] as $record) {
                            if ($record['data_inizio'] == condizione) {
                                echo "flag";
                               $i++;
                         }
                }*/

           // funzione prende datasomma cicla array somma tot

            foreach($prova as $chiave => $valore)
               {
              // echo $chiave." : ". $valore['tot_pax'] . " _ " .$valore['id']. "<br /><br />";
                array_push($valorepax, $valore['tot_pax']);
               
               }

               //echo $check. " - " . array_sum($valorepax) . "<br/>";
               // METTO IN DUE ARRAY CHE HANNO LA STESSA CHIAVE PAX E DATA DA PASSARE ALLA VIEW
//              Data 
                array_push($stringadati, $check);

//              Pax 
                array_push($stringapax, array_sum($valorepax));
                    $valorepax = array();
                 
                 
     
       }


    $data['mydata']= $stringadati;
    $data['mypax']= $stringapax;

                //$data['stringadata']=$valoreprint;
    
                
    $data['valoreflag']=$valoreflag;
    $data['datavisuale'] = $mese_nome;
    $data['id'] =  $idcentro;
    $data['date'] =  $data_inizio;
    $data['title'] = 'Booking  form';
    $this->load->view('risult_search', $data);

}

function take(){
               //Controllo se l'utente è loggato

        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || ($is_logged_in != true)) {


            redirect('gestione_centri/login_permits');
            die();
        }
        // Fine controllo
        $this->load->helper(array('form', 'url'));
        $this->load->library('validation');
        $this->validation->set_error_delimiters('<div class="error"> ** ', ' ** </div>');

        $this->load->model('gestione_centri_model');
        $data['agency'] = $this->gestione_centri_model->agency_building();
        $data['centri'] = $this->gestione_centri_model->building();
        $data['group'] = $this->gestione_centri_model->n_group_leader();
        $data['aereo_in'] = $this->gestione_centri_model->airport();
        $data['aereo_out'] = $this->gestione_centri_model->airport();
        $id_p = $this->uri->segment(3);
        $data['up'] = $this->gestione_centri_model->take($id_p);
        $this->load->view('form_update', $data);

    }
 function update(){
            $this->load->model('gestione_centri_model');
            $id = $this->uri->segment(3);
            $data['update'] = $this->gestione_centri_model->update($id);
            $this->load->view('confirm_update', $data);
        }

 function confirm_datain(){
            $this->load->model('gestione_centri_model');

            $id = $this->uri->segment(3);
            $data['ok'] = $this->gestione_centri_model->ok_in($id);
            $this->load->view('confirm_ok', $data);

        }
        
 function confirm_dataout(){
            $this->load->model('gestione_centri_model');

            $id = $this->uri->segment(3);
            $data['ok'] = $this->gestione_centri_model->ok_out($id);
            $this->load->view('confirm_ok', $data);

        }        
 function list_confirm(){
        //Controllo se l'utente è loggato

                $is_logged_in = $this->session->userdata('is_logged_in');
                if (!isset($is_logged_in) || ($is_logged_in != true)) {


            redirect('gestione_centri/login_permits');
            die();
        }
            $this->load->model('gestione_centri_model');
            $data['list_confirm'] = $this->gestione_centri_model->list_ok();
          
            
            $this->load->view('form_list', $data);

        }
function list_no_checkin(){
            //Controllo se l'utente è loggato

                $is_logged_in = $this->session->userdata('is_logged_in');
                if (!isset($is_logged_in) || ($is_logged_in != true)) {


            redirect('gestione_centri/login_permits');
            die();
        }
       $this->load->model('gestione_centri_model');
       $data['list_no_checkin'] = $this->gestione_centri_model->list_no_checkin();
       
       $this->load->view('form_list_no_checkin', $data);  
}
function list_no_checkout(){
            //Controllo se l'utente è loggato

                $is_logged_in = $this->session->userdata('is_logged_in');
                if (!isset($is_logged_in) || ($is_logged_in != true)) {


            redirect('gestione_centri/login_permits');
            die();
        }
        
       $this->load->model('gestione_centri_model');
       $data['list_no_checkout'] = $this->gestione_centri_model->list_no_checkout();
       $this->load->view('form_list_no_checkout', $data);  
}
      

}
?>