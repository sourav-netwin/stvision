<?php

/**
 * Class to control import history data from webservice
 * @since 25-July-2016
 * @author Preeti M
 *
 */
class Sthistory extends Controller {

    function __construct() {

        parent::Controller();

        $this->load->helper(array('form', 'url'));
        $this->load->library('session', 'email');
        $this->load->model('sthistorymodel');
    }

    /**
     * function to import data returned from webservice for history
     * @author Preeti M
     * @since 25-July-2016
     */
    function import() {

        if ($this->session->userdata('role') == 550) {
            $data['title'] = "plus-ed.com | Import file";
            $data['breadcrumb1'] = 'ST history data';
            $data['breadcrumb2'] = 'Import file';

            if (!empty($_POST)) {
                // Code added to import static CSV file to DB
                $this->load->library('csvimport');
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', '7200');

                //$file = '../teacherApplications/storico.csv';
                //$file = '../teacherApplications/20161229/storico2002_28122016.csv';
                //$file = '../teacherApplications/20161229/storico2003_28122016.csv';
                //$file = '../teacherApplications/20161229/storico2009_2004_28122016.csv';
                //$file = '../teacherApplications/20161229/storico2010_28122016.csv';
                $file = '../teacherApplications/20161229/storico2016_2011_28122016.csv';
                $csv_array = $this->csvimport->get_array($file, '', '', '', ';');

                $result = $this->importContent($csv_array);

                if ($result['failed'] == 0) {
                    $this->session->set_flashdata("success_message", $result['success'] . " of " . $result['total'] . " records imported successfully.");
                    redirect('sthistory/import');
                } else {
                    $this->session->set_flashdata("error_message", $result['failed'] . " of " . $result['total'] . " records failed to import successfully.");
                    redirect('sthistory/import');
                }
            }

            $this->load->view('plused_st_history_import', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * function to import data to DB
     * @author Preeti M
     * @since 26-July-2016
     */
    private function importContent($data) {
        //$this -> db -> truncate('st_history');

        $total_records = count($data);
        $insert_array = array();
        for ($i = 0; $i < $total_records; $i++) {
            // echo "<pre>";
            // print_r($data[$i]);die;

            $insert_data['anno'] = $this->_remove_null($data[$i]["Anno"]);
            $insert_data['id_prenotazione'] = $this->_remove_null($data[$i]["IdPrenotazione"]);
            $insert_data['id_prenotazione_web'] = $this->_remove_null($data[$i]["idPrenotazioneWEB"]);
            $insert_data['data_prenotazione'] = $this->_safe_strtotime($data[$i]["DataPrenotazione"]);
            $insert_data['id_opzione'] = $this->_remove_null($data[$i]["IdOpzione"]);
            $insert_data['opzione_pax'] = $this->_remove_null($data[$i]["OpzionePax"]);
            $insert_data['opzione_opzionato'] = $this->_remove_null($data[$i]["OpzioneOpzionato"]);
            $insert_data['id_nominativo_opzione'] = $this->_remove_null($data[$i]["IdNominativoOpzione"]);
            $insert_data['nominativo_opzione'] = $this->_remove_null($data[$i]["NominativoOpzione"]);
            $insert_data['id_collaboratore'] = $this->_remove_null($data[$i]["IdCollaboratore"]);
            $insert_data['collaboratore'] = $this->_remove_null($data[$i]["Collaboratore"]);

            // NEW COLABORATOR FILES ADDED - 4
            $insert_data['collaboratoreProvincia'] = $this->_remove_null($data[$i]["collaboratoreProvincia"]);
            $insert_data['collaboratoreNazione'] = $this->_remove_null($data[$i]["collaboratoreNazione"]);
            $insert_data['collaboratoreRegione'] = $this->_remove_null($data[$i]["collaboratoreRegione"]);
            $insert_data['collaboratoreMacroRegione'] = $this->_remove_null($data[$i]["collaboratoreMacroRegione"]);
            // END: NEW COLABORATOR FILES ADDED - 4

            $insert_data['id_accompagnatore'] = $this->_remove_null($data[$i]["IdAccompagnatore"]);
            $insert_data['accompagnatore'] = $this->_remove_null($data[$i]["Accompagnatore"]);
            if (array_key_exists('accompagnatoreAzienda', $data[$i]))
                $insert_data['accompagantore_azienda'] = $this->_remove_null($data[$i]["accompagnatoreAzienda"]);
            else
                $insert_data['accompagantore_azienda'] = $this->_remove_null($data[$i]["accompagantoreAzienda"]);
            $insert_data['id_passeggero'] = $this->_remove_null($data[$i]["IdPasseggero"]);
            $insert_data['passeggero'] = $this->_remove_null($data[$i]["Passeggero"]);
            $insert_data['passeggero_azienda'] = $this->_remove_null($data[$i]["passeggeroAzienda"]);
            $insert_data['indirizzo'] = $this->_remove_null($data[$i]["Indirizzo"]);
            $insert_data['provincia'] = $this->_remove_null($data[$i]["Provincia"]);
            $insert_data['comune'] = $this->_remove_null($data[$i]["Comune"]);
            $insert_data['cap'] = $this->_remove_null($data[$i]["Cap"]);
            $insert_data['data_iscrizione'] = $this->_safe_strtotime($data[$i]["DataIscrizione"]);
            $insert_data['titolo'] = $this->_remove_null($data[$i]["Titolo"]);
            $insert_data['indirizzo_spedizione'] = $this->_remove_null($data[$i]["IndirizzoSpedizione"]);
            $insert_data['cap_spedizione'] = $this->_remove_null($data[$i]["CapSpedizione"]);
            $insert_data['comune_spedizione'] = $this->_remove_null($data[$i]["ComuneSpedizione"]);
            $insert_data['provincia_spedizione'] = $this->_remove_null($data[$i]["ProvinciaSpedizione"]);
            $insert_data['telefono'] = $this->_remove_null($data[$i]["Telefono"]);
            $insert_data['fax'] = $this->_remove_null($data[$i]["Fax"]);
            $insert_data['cellulare'] = $this->_remove_null($data[$i]["Cellulare"]);
            $insert_data['telefono_estivo'] = $this->_remove_null($data[$i]["Telefonoestivo"]);
            $insert_data['email'] = $this->_remove_null($data[$i]["Email"]);
            $insert_data['partita_iva'] = $this->_remove_null($data[$i]["PartitaIva"]);
            $insert_data['codice_fiscale'] = $this->_remove_null($data[$i]["CodiceFiscale"]);
            $insert_data['id_tipologia_cliente'] = $this->_remove_null($data[$i]["IdTipologiaCliente"]);
            $insert_data['tipo_cliente'] = $this->_remove_null($data[$i]["TipoCliente"]);
            $insert_data['data_nascita'] = $this->_safe_strtotime($data[$i]["DataNascita"]);
            $insert_data['comune_nascita'] = $this->_remove_null($data[$i]["ComuneNascita"]);
            $insert_data['comune_codice_nascita'] = $this->_remove_null($data[$i]["ComuneCodiceNascita"]);
            $insert_data['provincia_nascita'] = $this->_remove_null($data[$i]["ProvinciaNascita"]);
            $insert_data['nazione_nascita'] = $this->_remove_null($data[$i]["NazioneNascita"]);
            $insert_data['email_riferimento'] = $this->_remove_null($data[$i]["emailRiferimento"]);
            $insert_data['sesso'] = $this->_remove_null($data[$i]["Sesso"]);
            $insert_data['uscita_serale'] = $this->_remove_null($data[$i]["UscitaSerale"]);
            $insert_data['salute'] = $this->_remove_null($data[$i]["Salute"]);
            $insert_data['figli'] = $this->_remove_null($data[$i]["Figli"]);
            $insert_data['stato_civile'] = $this->_remove_null($data[$i]["StatoCivile"]);
            $insert_data['coniuge'] = $this->_remove_null($data[$i]["Coniuge"]);
            $insert_data['coniuge_societa'] = $this->_remove_null($data[$i]["ConiugeSocieta"]);
            $insert_data['coniuge_professione'] = $this->_remove_null($data[$i]["ConiugeProfessione"]);
            $insert_data['tipologia_scuola'] = $this->_remove_null($data[$i]["TipologiaScuola"]);
            $insert_data['materia'] = $this->_remove_null($data[$i]["Materia"]);
            $insert_data['lingua'] = $this->_remove_null($data[$i]["Lingua"]);
            $insert_data['opera_settore'] = $this->_remove_null($data[$i]["OperaSettore"]);
            $insert_data['itc'] = $this->_remove_null($data[$i]["ITC"]);
            $insert_data['collaboratore_passato'] = $this->_remove_null($data[$i]["CollaboratorePassato"]);
            $insert_data['azienda'] = $this->_remove_null($data[$i]["Azienda"]);
            $insert_data['id_azienda'] = $this->_remove_null($data[$i]["IdAzienda"]);
            $insert_data['padre_nome'] = $this->_remove_null($data[$i]["PadreNome"]);
            $insert_data['padre_cognome'] = $this->_remove_null($data[$i]["PadreCognome"]);
            $insert_data['padre_cellulare'] = $this->_remove_null($data[$i]["PadreCellulare"]);
            $insert_data['padre_telefono'] = $this->_remove_null($data[$i]["PadreTelefono"]);
            $insert_data['padre_email'] = $this->_remove_null($data[$i]["PadreEmail"]);
            $insert_data['padre_professione'] = $this->_remove_null($data[$i]["PadreProfessione"]);
            $insert_data['padre_data_nascita'] = $this->_safe_strtotime($data[$i]["PadreDataNascita"]);
            $insert_data['madre_nome'] = $this->_remove_null($data[$i]["MadreNome"]);
            $insert_data['madre_cognome'] = $this->_remove_null($data[$i]["MadreCognome"]);
            $insert_data['madre_cellulare'] = $this->_remove_null($data[$i]["MadreCellulare"]);
            $insert_data['madre_telefono'] = $this->_remove_null($data[$i]["MadreTelefono"]);
            $insert_data['madre_email'] = $this->_remove_null($data[$i]["MadreEmail"]);
            $insert_data['madre_professione'] = $this->_remove_null($data[$i]["MadreProfessione"]);
            $insert_data['madre_data_nascita'] = $this->_safe_strtotime($data[$i]["MadreDataNascita"]);
            $insert_data['documento_tipologia'] = $this->_remove_null($data[$i]["Documento_Tipologia"]);
            $insert_data['documento_numero'] = $this->_remove_null($data[$i]["Documento_Numero"]);
            $insert_data['documento_data_rilascio'] = $this->_safe_strtotime($data[$i]["Documento_DataRilascio"]);
            $insert_data['documento_data_scadenza'] = $this->_safe_strtotime($data[$i]["Documento_DataScadenza"]);
            $insert_data['documento_luogo_rilascio'] = $this->_remove_null($data[$i]["Documento_LuogoRilascio"]);
            $insert_data['documento_rilasciato'] = $this->_remove_null($data[$i]["Documento_Rilasciato"]);
            $insert_data['documento_nazione'] = $this->_remove_null($data[$i]["Documento_Nazione"]);
            $insert_data['regione'] = $this->_remove_null($data[$i]["Regione"]);
            $insert_data['macro_regione'] = $this->_remove_null($data[$i]["MacroRegione"]);
            $insert_data['nazione'] = $this->_remove_null($data[$i]["Nazione"]);
            $insert_data['id_corporate'] = $this->_remove_null($data[$i]["IdCorporate"]);
            $insert_data['tipo_fattura'] = $this->_remove_null($data[$i]["TipoFattura"]);
            $insert_data['glf'] = $this->_remove_null($data[$i]["GLF"]);
            $insert_data['pnr'] = $this->_remove_null($data[$i]["PNR"]);
            $insert_data['data_partenza'] = $this->_safe_strtotime($data[$i]["DataPartenza"]);
            $insert_data['data_arrivo_ritorno'] = $this->_safe_strtotime($data[$i]["DataArrivoRitorno"]);
            $insert_data['apt_partenza'] = $this->_remove_null($data[$i]["APTPartenza"]);
            $insert_data['campus_data_arrivo'] = $this->_safe_strtotime($data[$i]["campusDataArrivo"]);
            $insert_data['campus_data_partenza'] = $this->_safe_strtotime($data[$i]["campusDataPartenza"]);
            $insert_data['codice_famiglia'] = $this->_remove_null($data[$i]["CodiceFamiglia"]);
            $insert_data['famiglia'] = $this->_remove_null($data[$i]["Famiglia"]);
            $insert_data['alloggiare'] = $this->_remove_null($data[$i]["Alloggiare"]);
            $insert_data['tipologia_passeggero'] = $this->_remove_null($data[$i]["TipologiaPasseggero"]);
            $insert_data['id_prodotto'] = $this->_remove_null($data[$i]["IdProdotto"]);
            $insert_data['codice_prodotto'] = $this->_remove_null($data[$i]["CodiceProdotto"]);
            $insert_data['prodotto'] = $this->_remove_null($data[$i]["Prodotto"]);
            $insert_data['tipologia_prodotto'] = $this->_remove_null($data[$i]["tipologiaProdotto"]);
            $insert_data['pax'] = $this->_remove_null($data[$i]["Pax"]);
            $insert_data['sistemazione'] = $this->_remove_null($data[$i]["Sistemazione"]);
            $insert_data['codice_destinazione'] = $this->_remove_null($data[$i]["CodiceDestinazione"]);
            $insert_data['destinazione'] = $this->_remove_null($data[$i]["Destinazione"]);
            $insert_data['destinazione_nazione'] = $this->_remove_null($data[$i]["DestinazioneNazione"]);
            $insert_data['livello'] = $this->_remove_null($data[$i]["Livello"]);

            $insert_data['costo_base'] = str_replace(",", ".", $this->_remove_null($data[$i]["CostoBase"]));
            $insert_data['costo_arpt_aggiuntivo'] = str_replace(",", ".", $this->_remove_null($data[$i]["CostoArptAggiuntivo"]));
            $insert_data['supplementi'] = str_replace(",", ".", $this->_remove_null($data[$i]["Supplementi"]));
            $insert_data['pagamenti'] = str_replace(",", ".", $this->_remove_null($data[$i]["Pagamenti"]));

            $insert_id = $this->sthistorymodel->operations('insert', $insert_data);
            array_push($insert_array, $insert_id);
        }

        $successfull_import = $failed_import = 0;
        for ($i = 0; $i < $total_records; $i++) {
            if ($insert_array[$i] <= 0)
                $failed_import++;
            else
                $successfull_import++;
        }

        return array('success' => $successfull_import, 'failed' => $failed_import, 'total' => $total_records);
    }

    /**
     * function to format date
     * @author Preeti M
     * @since 26-July-2016
     */
    private function _safe_strtotime($string) {
        if ($string == 'NULL' || $string == '' || $string == '00:00:00')
            return "0000-00-00 00:00:00";

        if (!preg_match("/\d{4}/", $string, $match))
            return "0000-00-00 00:00:00"; //year must be in YYYY form
        $year = intval($match[0]); //converting the year to integer

        if ($year >= 1970)
            return date("Y-m-d H:i:s", strtotime($string)); //the year is after 1970 - no problems even for Windows

        if (stristr(PHP_OS, "WIN") && !stristr(PHP_OS, "DARWIN")) { //OS seems to be Windows, not Unix nor Mac
            $diff = 1975 - $year; //calculating the difference between 1975 and the year
            $new_year = $year + $diff; //year + diff = new_year will be for sure > 1970
            $new_date = date("Y-m-d H:i:s", strtotime(str_replace($year, $new_year, $string))); //replacing the year with the new_year, try strtotime, rendering the date
            return str_replace($new_year, $year, $new_date); //returning the date with the correct year
        }
        return date("Y-m-d H:i:s", strtotime($string)); //do normal strtotime
    }

    /**
     * function to replace null with blank
     * @author Preeti M
     * @since 26-July-2016
     */
    private function _remove_null($string) {
        return ( $string == 'NULL' ) ? '' : $string;
    }

    /**
     * function to display search filter and data for reports for st history data
     * @author Preeti M
     * @since 1-August-2016
     */
    function report($reportType = "") {

        if ($this->session->userdata('role') == 550) {
            if (!empty($reportType)) {
                $data['reportType'] = $reportType;
                if (!empty($_POST)) {

                    if (isset($_POST['type'])) {
                        ini_set('date.timezone', 'UTC');
                        $this->load->library('excel_180');

                        if ($_POST['type'] == "exportAll") {
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', '3600');
                        }
                        $data['collaboratore'] = $this->input->post('txtCollaboratore');
                        $data['codice_prodotto'] = $this->input->post('txtCodiceProdotto');
                        $data['tipologia_prodotto'] = ( $this->input->post('selTipologiaProdotto') ) ? explode(",", $this->input->post('selTipologiaProdotto')) : "";
                        $data['destinazione_nazione'] = ( $this->input->post('selDestinazioneNazione') ) ? explode(",", $this->input->post('selDestinazioneNazione')) : "";

                        $data['regione'] = $this->input->post('selRegione');
                        $data['macro_regione'] = $this->input->post('selMacroRegione');
                        $data['nazione'] = $this->input->post('selNazione');

                        $data['collaboratoreProvincia'] = $this->input->post('selCollaboratoreProvincia');
                        $data['collaboratoreNazione'] = $this->input->post('selCollaboratoreNazione');
                        $data['collaboratoreRegione'] = $this->input->post('selCollaboratoreRegione');
                        $data['collaboratoreMacroRegione'] = $this->input->post('selCollaboratoreMacroRegione');

                        $data['destinazione'] = $this->input->post('selDestinazione');
                        $data['anno'] = $this->input->post('selAnno');

                        $data['ageStart'] = $this->input->post('selStartAge');
                        $data['ageEnd'] = $this->input->post('selEndAge');

                        $data['fatturatoMin'] = $this->input->post('selFatturatoMin');
                        $data['fatturatoMax'] = $this->input->post('selFatturatoMax');

                        $data['accumulative'] = $this->input->post('chkAccumulative');
                        $data['checkagetoday'] = $this->input->post('chkCheckAgeToday');

                        //$getData = array( 'collaboratore' => $data['collaboratore'], 'codice_prodotto' => $data['codice_prodotto'], 'tipologia_prodotto' => $data['tipologia_prodotto'], 'destinazione_nazione' => $data['destinazione_nazione']);
                        $getData = array(
                            'collaboratore' => $data['collaboratore'],
                            'codice_prodotto' => $data['codice_prodotto'],
                            'tipologia_prodotto' => $data['tipologia_prodotto'],
                            'destinazione_nazione' => $data['destinazione_nazione'],
                            'regione' => $data['regione'],
                            'macro_regione' => $data['macro_regione'],
                            'nazione' => $data['nazione'],
                            'collaboratoreProvincia' => $data['collaboratoreProvincia'],
                            'collaboratoreNazione' => $data['collaboratoreNazione'],
                            'collaboratoreRegione' => $data['collaboratoreRegione'],
                            'collaboratoreMacroRegione' => $data['collaboratoreMacroRegione'],
                            'destinazione' => $data['destinazione'],
                            'anno' => $data['anno'],
                            'ageStart' => $data['ageStart'],
                            'ageEnd' => $data['ageEnd'],
                            'exportType' => $_POST['type'],
                            'fatturatoMin' => $data['fatturatoMin'],
                            'fatturatoMax' => $data['fatturatoMax'],
                            'reportType' => $data['reportType'],
                            'accumulative' => $data['accumulative'],
                            'checkagetoday' => $data['checkagetoday']
                        );

                        $resultData = $this->sthistorymodel->getReportData($getData, 'collaboratore');

                        $summary_data = '';
                        $data['summary_data'] = '';
                        if (!empty($getData['anno']) && !empty($getData['collaboratore'])) {
                            $summary_data = $this->sthistorymodel->getSummaryData($getData);
                        }
                        if (!empty($summary_data)) {
                            foreach ($summary_data as $summary) {
                                $data['summary_data'][$summary['tipologia_prodotto']][$summary['destinazione_nazione']][] = array(
                                    'codice_destinazione' => $summary['codice_destinazione'],
                                    'fatturato' => $summary['fatturato']
                                );
                            }
                        }
                        if ($resultData) {

                            $exportData = array();
                            // IF EXPORT ALL: SKIP ALL CONDITIONS
                            if ($_POST['type'] == "exportAll") {
                                $exportData = array(array('Anno', 'Collaboratore', 'Azienda', 'Provincia collaboratore', 'Nazione collaboratore', 'Regione collaboratore', 'Macroregione collaboratore', 'Codice prodotto', 'Tipologia prodotto', 'Destinazione', 'Destinazione nazione', 'Passenger', 'Telefono', 'Email', 'Data Nascita', 'Sesso', 'Tipologia Passeggero', 'Sistemazione', 'Codice Destinazione', 'Indirizzo', 'Provincia', 'Comune', 'Cap', 'Regione', 'Macro regione', 'Nazione', 'Pax', 'Fatturato'));
                            } elseif (empty($data['accumulative'])) {
                                if ($reportType == 'corporate')
                                    $exportData = array(array('Anno', 'Azienda', 'Codice prodotto', 'Tipologia prodotto', 'Destinazione', 'Destinazione nazione', 'Pax', 'Fatturato'));
                                else
                                    $exportData = array(array('Anno', 'Collaboratore', 'Provincia collaboratore', 'Nazione collaboratore', 'Regione collaboratore', 'Macroregione collaboratore', 'Codice prodotto', 'Tipologia prodotto', 'Destinazione', 'Destinazione nazione', 'Pax', 'Fatturato'));
                            }
                            else {
                                if ($reportType == 'corporate')
                                    $exportData = array(array('Anno', 'Azienda', 'Tipologia prodotto', 'Pax', 'Fatturato'));
                                else
                                    $exportData = array(array('Anno', 'Collaboratore', 'Provincia collaboratore', 'Nazione collaboratore', 'Regione collaboratore', 'Macroregione collaboratore', 'Tipologia prodotto', 'Pax', 'Fatturato'));
                            }
                            foreach ($resultData as $record) {
                                // IF EXPORT ALL: SKIP ALL CONDITIONS
                                if ($_POST['type'] == "exportAll") {
                                    $exportRecord = array(
                                        'Anno' => $record['anno'],
                                        'Collaboratore' => $record['collaboratore'],
                                        'Azienda' => $record['azienda'],
                                        'Provincia collaboratore' => $record['collaboratoreProvincia'],
                                        'Nazione collaboratore' => $record['collaboratoreNazione'],
                                        'Regione collaboratore' => $record['collaboratoreRegione'],
                                        'Macroregione collaboratore' => $record['collaboratoreMacroRegione'],
                                        'Codice prodotto' => $record['codice_prodotto'],
                                        'Tipologia prodotto' => $record['tipologia_prodotto'],
                                        'Destinazione' => $record['destinazione'],
                                        'Destinazione nazione' => $record['destinazione_nazione'],
                                        //passenger,telefono,email,indirizzo,provincia,comune,cap,regione,macro_regione,nazione
                                        'Passeggero' => $record['passeggero'],
                                        'Telefono' => $record['telefono'],
                                        'Email' => $record['email'],
                                        'Data Nascita' => date('d/m/Y', strtotime($record['data_nascita'])),
                                        'Sesso' => $record['sesso'],
                                        'Tipologia Passeggero' => $record['tipologia_passeggero'],
                                        'Sistemazione' => $record['sistemazione'],
                                        'Codice Destinazione' => $record['codice_destinazione'],
                                        'Indirizzo' => $record['indirizzo'],
                                        'Provincia' => $record['provincia'],
                                        'Comune' => $record['comune'],
                                        'Cap' => $record['cap'],
                                        'Regione' => $record['regione'],
                                        'Macro regione' => $record['macro_regione'],
                                        'Nazione' => $record['nazione'],
                                        'Pax' => $record['pax'],
                                        'Fatturato' => number_format($record["fatturato"], 2, ',', '.')
                                    );
                                    array_push($exportData, $exportRecord);
                                } elseif ($reportType == 'corporate') {
                                    // CORPORATE REPORT
                                    if (empty($data['accumulative'])) {
                                        $exportRecord = array(
                                            'Anno' => $record['anno'],
                                            'Azienda' => $record['azienda'],
                                            'Codice prodotto' => $record['codice_prodotto'],
                                            'Tipologia prodotto' => $record['tipologia_prodotto'],
                                            'Destinazione' => $record['destinazione'],
                                            'Destinazione nazione' => $record['destinazione_nazione'],
                                            'Pax' => $record['pax'],
                                            'Fatturato' => number_format($record["fatturato"], 2, ',', '.')
                                        );
                                    } else {
                                        $exportRecord = array(
                                            'Anno' => $record['anno'],
                                            'Azienda' => $record['azienda'],
                                            'Tipologia prodotto' => $record['tipologia_prodotto'],
                                            'Pax' => $record['pax'],
                                            'Fatturato' => number_format($record["fatturato"], 2, ',', '.')
                                        );
                                    }
                                    array_push($exportData, $exportRecord);
                                } else {
                                    if (empty($data['accumulative'])) {
                                        $exportRecord = array(
                                            'Anno' => $record['anno'],
                                            'Collaboratore' => $record['collaboratore'],
                                            'Provincia collaboratore' => $record['collaboratoreProvincia'],
                                            'Nazione collaboratore' => $record['collaboratoreNazione'],
                                            'Regione collaboratore' => $record['collaboratoreRegione'],
                                            'Macroregione collaboratore' => $record['collaboratoreMacroRegione'],
                                            'Codice prodotto' => $record['codice_prodotto'],
                                            'Tipologia prodotto' => $record['tipologia_prodotto'],
                                            'Destinazione' => $record['destinazione'],
                                            'Destinazione nazione' => $record['destinazione_nazione'],
                                            'Pax' => $record['pax'],
                                            'Fatturato' => number_format($record["fatturato"], 2, ',', '.')
                                        );
                                    } else {
                                        $exportRecord = array(
                                            'Anno' => $record['anno'],
                                            'Collaboratore' => $record['collaboratore'],
                                            'Provincia collaboratore' => $record['collaboratoreProvincia'],
                                            'Nazione collaboratore' => $record['collaboratoreNazione'],
                                            'Regione collaboratore' => $record['collaboratoreRegione'],
                                            'Macroregione collaboratore' => $record['collaboratoreMacroRegione'],
                                            'Tipologia prodotto' => $record['tipologia_prodotto'],
                                            'Pax' => $record['pax'],
                                            'Fatturato' => number_format($record["fatturato"], 2, ',', '.')
                                        );
                                    }
                                    array_push($exportData, $exportRecord);
                                }
                            }
//            $this->load->library('export');
//            $this->export->exportUsingPhpExcel( $exportData, 'sthistoryreport' );
                            //New export start

                            $sheet = $this->excel_180->getActiveSheet();
                            $column = 'A';
                            $cnt = 1;
                            if (!empty($data['summary_data'])) {
                                $totalFatturato = 0;
                                $sheet->setCellValue('A' . $cnt, 'Collaboratore');
                                $sheet->getStyle('A' . $cnt)->getFont()->setBold(true);
                                $sheet->setCellValue('B' . $cnt, trim($getData['collaboratore'], '='));

                                foreach ($data['summary_data'] as $tipoProdo => $countries) {
                                    ++$cnt;
                                    $sheet->setCellValue('A' . ++$cnt, 'Tipologia Prodotto');
                                    $sheet->getStyle('A' . $cnt)->getFont()->setBold(true);
                                    $sheet->setCellValue('B' . $cnt, trim($tipoProdo, '='));

                                    ++$cnt;
                                    $sheet->setCellValue('A' . ++$cnt, 'Country');
                                    $sheet->setCellValue('B' . $cnt, 'Campus');
                                    $sheet->setCellValue('C' . $cnt, 'Fatturato');
                                    $sheet->getStyle('A' . $cnt . ':C' . $cnt)->getFont()->setBold(true);

                                    foreach ($countries as $country => $values) {
                                        $sheet->setCellValue('A' . ++$cnt, trim($country, '='));
                                        $recEachCnt = 0;
                                        foreach ($values as $key => $val) {
                                            if ($recEachCnt > 0) {
                                                $cnt++;
                                            }
                                            $sheet->setCellValue('B' . $cnt, trim($val['codice_destinazione'], '='));
                                            $sheet->setCellValue('C' . $cnt, trim($val['fatturato'], '='));
                                            $totalFatturato += $val['fatturato'] * 1;
                                            $recEachCnt++;
                                        }
                                    }
                                }
                                $sheet->setCellValue('B' . ++$cnt, 'Total');
                                $sheet->setCellValue('C' . $cnt, $totalFatturato);
                                $sheet->getStyle('B' . $cnt . ':C' . $cnt)->getFont()->setBold(true);
                                $cnt++;
                            }
                            if ($cnt > 1) {
                                $cnt++;
                            }
                            $sheet->fromArray($exportData, NULL, 'A' . $cnt);
                            $sheet->getStyle('A' . $cnt . ':W' . $cnt)->getFont()->setBold(true);
                            //			$sheet -> setCellValue('A2', 'Name');
                            $filename = 'export_st.xls';
                            header('Content-Type: application/vnd.ms-excel');
                            header('Content-Disposition: attachment;filename="' . $filename . '"');
                            header('Cache-Control: max-age=0');
                            $objWriter = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
                            $objWriter->save('php://output');
                            die();
                            //New export end
                        } else
                            redirect('sthistory/report');
                    }
                    else {

                        $data['title'] = 'plus-ed.com | ST history data report';
                        $data['breadcrumb1'] = 'ST history data';
                        $data['breadcrumb2'] = 'ST history data report' . ' - ' . $reportType;

                        $data['collaboratore'] = $this->input->post('txtCollaboratore');
                        $data['codice_prodotto'] = $this->input->post('txtCodiceProdotto');
                        $data['tipologia_prodotto'] = $this->input->post('selTipologiaProdotto');
                        $data['destinazione_nazione'] = $this->input->post('selDestinazioneNazione');

                        $data['regione'] = $this->input->post('selRegione');
                        $data['macro_regione'] = $this->input->post('selMacroRegione');
                        $data['nazione'] = $this->input->post('selNazione');

                        $data['collaboratoreProvincia'] = $this->input->post('selCollaboratoreProvincia');
                        $data['collaboratoreNazione'] = $this->input->post('selCollaboratoreNazione');
                        $data['collaboratoreRegione'] = $this->input->post('selCollaboratoreRegione');
                        $data['collaboratoreMacroRegione'] = $this->input->post('selCollaboratoreMacroRegione');

                        $data['destinazione'] = $this->input->post('selDestinazione');
                        $data['anno'] = $this->input->post('selAnno');

                        $data['ageStart'] = $this->input->post('selStartAge');
                        $data['ageEnd'] = $this->input->post('selEndAge');

                        $data['fatturatoMin'] = $this->input->post('selFatturatoMin');
                        $data['fatturatoMax'] = $this->input->post('selFatturatoMax');
                        // $getData = array( 'collaboratore' => $data['collaboratore'], 'codice_prodotto' => $data['codice_prodotto'], 'tipologia_prodotto' => $data['tipologia_prodotto'], 'destinazione_nazione' => $data['destinazione_nazione'] );
                        $data['accumulative'] = $this->input->post('chkAccumulative');
                        $data['checkagetoday'] = $this->input->post('chkCheckAgeToday');

                        $getData = array(
                            'collaboratore' => $data['collaboratore'],
                            'codice_prodotto' => $data['codice_prodotto'],
                            'tipologia_prodotto' => $data['tipologia_prodotto'],
                            'destinazione_nazione' => $data['destinazione_nazione'],
                            'regione' => $data['regione'],
                            'macro_regione' => $data['macro_regione'],
                            'nazione' => $data['nazione'],
                            'collaboratoreProvincia' => $data['collaboratoreProvincia'],
                            'collaboratoreNazione' => $data['collaboratoreNazione'],
                            'collaboratoreRegione' => $data['collaboratoreRegione'],
                            'collaboratoreMacroRegione' => $data['collaboratoreMacroRegione'],
                            'destinazione' => $data['destinazione'],
                            'anno' => $data['anno'],
                            'ageStart' => $data['ageStart'],
                            'ageEnd' => $data['ageEnd'],
                            'fatturatoMin' => $data['fatturatoMin'],
                            'fatturatoMax' => $data['fatturatoMax'],
                            'reportType' => $data['reportType'],
                            'accumulative' => $data['accumulative'],
                            'checkagetoday' => $data['checkagetoday']
                        );

                        $data['report_data'] = $this->sthistorymodel->getReportData($getData);
                        $summary_data = '';
                        $data['summary_data'] = '';
                        if (!empty($data['anno']) && !empty($data['collaboratore'])) {
                            $summary_data = $this->sthistorymodel->getSummaryData($getData);
                        }
                        if (!empty($summary_data)) {
                            foreach ($summary_data as $summary) {
                                $data['summary_data'][$summary['tipologia_prodotto']][$summary['destinazione_nazione']][] = array(
                                    'codice_destinazione' => $summary['codice_destinazione'],
                                    'fatturato' => $summary['fatturato']
                                );
                            }
                        }

//		  echo '<pre>';
//		  print_r($data['summary_data']);die;

                        if (APP_THEME == "OLD")
                            $this->load->view('plused_st_history_report_data', $data);
                        else { // if(APP_THEME == "LTE")
                            $data['pageHeader'] = $data['breadcrumb2'];
                            $data['optionalDescription'] = "";
                            if ($reportType == 'professori') {
                                $this->ltelayout->view('lte/wsimports/st_history_report_data_professori', $data);
                            } elseif ($reportType == 'corporate') {
                                $this->ltelayout->view('lte/wsimports/st_history_report_data_corporate', $data);
                            } else {
                                $this->ltelayout->view('lte/wsimports/st_history_report_data', $data);
                            }
                        }
                    }
                } else {
                    $data['title'] = 'plus-ed.com | ST history data report';
                    $data['breadcrumb1'] = 'ST history';
                    $data['breadcrumb2'] = 'ST history data report' . ' - ' . $reportType;

                    if ($reportType == "professori") {
                        $data['collaboratore'] = $this->sthistorymodel->getDistinctDataByField('collaboratore', "id_azienda = 0 AND azienda = ''");
                    } else {
                        $data['collaboratore'] = $this->sthistorymodel->getDistinctDataByField('azienda', "id_azienda != 0 AND azienda != ''");
                    }

                    $data['codice_prodotto'] = $this->sthistorymodel->getDistinctDataByField('codice_prodotto');
                    $data['tipologia_prodotto'] = $this->sthistorymodel->getDistinctDataByField('tipologia_prodotto');
                    $data['destinazione_nazione'] = $this->sthistorymodel->getDistinctDataByField('destinazione_nazione');

                    $data['regione'] = $this->sthistorymodel->getDistinctDataByField('regione');
                    $data['macro_regione'] = $this->sthistorymodel->getDistinctDataByField('macro_regione');
                    $data['nazione'] = $this->sthistorymodel->getDistinctDataByField('nazione');

                    $data['collaboratoreProvincia'] = $this->sthistorymodel->getDistinctDataByField('collaboratoreProvincia');
                    $data['collaboratoreNazione'] = $this->sthistorymodel->getDistinctDataByField('collaboratoreNazione');
                    $data['collaboratoreRegione'] = $this->sthistorymodel->getDistinctDataByField('collaboratoreRegione');
                    $data['collaboratoreMacroRegione'] = $this->sthistorymodel->getDistinctDataByField('collaboratoreMacroRegione');

                    $data['destinazione'] = $this->sthistorymodel->getDistinctDataByField('destinazione');
                    $data['anno'] = $this->sthistorymodel->getDistinctDataByField('anno');

                    if (APP_THEME == "OLD")
                        $this->load->view('plused_st_history_report_filters', $data);
                    else { // if(APP_THEME == "LTE")
                        $data['pageHeader'] = $data['breadcrumb2'];
                        $data['optionalDescription'] = "";
                        $this->ltelayout->view('lte/wsimports/st_history_report_filters', $data);
                    }
                }
            } else {

                if (!empty($_POST)) {
                    if (isset($_POST['type'])) {
                        ini_set('date.timezone', 'UTC');
                        $this->load->library('excel_180');

                        if ($_POST['type'] == "exportAll") {
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', '3600');
                        }
                        $data['collaboratore'] = $this->input->post('txtCollaboratore');
                        $data['codice_prodotto'] = $this->input->post('txtCodiceProdotto');
                        $data['tipologia_prodotto'] = ( $this->input->post('selTipologiaProdotto') ) ? explode(",", $this->input->post('selTipologiaProdotto')) : "";
                        $data['destinazione_nazione'] = ( $this->input->post('selDestinazioneNazione') ) ? explode(",", $this->input->post('selDestinazioneNazione')) : "";

                        $data['regione'] = $this->input->post('selRegione');
                        $data['macro_regione'] = $this->input->post('selMacroRegione');
                        $data['nazione'] = $this->input->post('selNazione');

                        $data['collaboratoreProvincia'] = $this->input->post('selCollaboratoreProvincia');
                        $data['collaboratoreNazione'] = $this->input->post('selCollaboratoreNazione');
                        $data['collaboratoreRegione'] = $this->input->post('selCollaboratoreRegione');
                        $data['collaboratoreMacroRegione'] = $this->input->post('selCollaboratoreMacroRegione');

                        $data['destinazione'] = $this->input->post('selDestinazione');
                        $data['anno'] = $this->input->post('selAnno');

                        $data['ageStart'] = $this->input->post('selStartAge');
                        $data['ageEnd'] = $this->input->post('selEndAge');

                        //$getData = array( 'collaboratore' => $data['collaboratore'], 'codice_prodotto' => $data['codice_prodotto'], 'tipologia_prodotto' => $data['tipologia_prodotto'], 'destinazione_nazione' => $data['destinazione_nazione']);
                        $getData = array(
                            'collaboratore' => $data['collaboratore'],
                            'codice_prodotto' => $data['codice_prodotto'],
                            'tipologia_prodotto' => $data['tipologia_prodotto'],
                            'destinazione_nazione' => $data['destinazione_nazione'],
                            'regione' => $data['regione'],
                            'macro_regione' => $data['macro_regione'],
                            'nazione' => $data['nazione'],
                            'collaboratoreProvincia' => $data['collaboratoreProvincia'],
                            'collaboratoreNazione' => $data['collaboratoreNazione'],
                            'collaboratoreRegione' => $data['collaboratoreRegione'],
                            'collaboratoreMacroRegione' => $data['collaboratoreMacroRegione'],
                            'destinazione' => $data['destinazione'],
                            'anno' => $data['anno'],
                            'ageStart' => $data['ageStart'],
                            'ageEnd' => $data['ageEnd'],
                            'exportType' => $_POST['type']
                        );

                        $resultData = $this->sthistorymodel->getReportData($getData, 'collaboratore');

                        $summary_data = '';
                        $data['summary_data'] = '';
                        if (!empty($getData['anno']) && !empty($getData['collaboratore'])) {
                            $summary_data = $this->sthistorymodel->getSummaryData($getData);
                        }
                        if (!empty($summary_data)) {
                            foreach ($summary_data as $summary) {
                                $data['summary_data'][$summary['tipologia_prodotto']][$summary['destinazione_nazione']][] = array(
                                    'codice_destinazione' => $summary['codice_destinazione'],
                                    'fatturato' => $summary['fatturato']
                                );
                            }
                        }
                        if ($resultData) {

                            $exportData = array(array('Anno', 'Collaboratore', 'Provincia collaboratore', 'Nazione collaboratore', 'Regione collaboratore', 'Macroregione collaboratore', 'Codice prodotto', 'Tipologia prodotto', 'Destinazione', 'Destinazione nazione', 'Pax', 'Fatturato'));
                            foreach ($resultData as $record) {
                                $exportRecord = array(
                                    'Anno' => $record['anno'],
                                    'Collaboratore' => $record['collaboratore'],
                                    'Provincia collaboratore' => $record['collaboratoreProvincia'],
                                    'Nazione collaboratore' => $record['collaboratoreNazione'],
                                    'Regione collaboratore' => $record['collaboratoreRegione'],
                                    'Macroregione collaboratore' => $record['collaboratoreMacroRegione'],
                                    'Codice prodotto' => $record['codice_prodotto'],
                                    'Tipologia prodotto' => $record['tipologia_prodotto'],
                                    'Destinazione' => $record['destinazione'],
                                    'Destinazione nazione' => $record['destinazione_nazione'],
                                    'Pax' => $record['pax'],
                                    'Fatturato' => number_format($record["fatturato"] * 1 / 100, 2, ',', '.')
                                );
                                array_push($exportData, $exportRecord);
                            }
//            $this->load->library('export');
//            $this->export->exportUsingPhpExcel( $exportData, 'sthistoryreport' );
                            //New export start

                            $sheet = $this->excel_180->getActiveSheet();
                            $column = 'A';
                            $cnt = 1;
                            if (!empty($data['summary_data'])) {
                                $totalFatturato = 0;
                                $sheet->setCellValue('A' . $cnt, 'Collaboratore');
                                $sheet->getStyle('A' . $cnt)->getFont()->setBold(true);
                                $sheet->setCellValue('B' . $cnt, trim($getData['collaboratore'], '='));

                                foreach ($data['summary_data'] as $tipoProdo => $countries) {
                                    ++$cnt;
                                    $sheet->setCellValue('A' . ++$cnt, 'Tipologia Prodotto');
                                    $sheet->getStyle('A' . $cnt)->getFont()->setBold(true);
                                    $sheet->setCellValue('B' . $cnt, trim($tipoProdo, '='));

                                    ++$cnt;
                                    $sheet->setCellValue('A' . ++$cnt, 'Country');
                                    $sheet->setCellValue('B' . $cnt, 'Campus');
                                    $sheet->setCellValue('C' . $cnt, 'Fatturato');
                                    $sheet->getStyle('A' . $cnt . ':C' . $cnt)->getFont()->setBold(true);

                                    foreach ($countries as $country => $values) {
                                        $sheet->setCellValue('A' . ++$cnt, trim($country, '='));
                                        $recEachCnt = 0;
                                        foreach ($values as $key => $val) {
                                            if ($recEachCnt > 0) {
                                                $cnt++;
                                            }
                                            $sheet->setCellValue('B' . $cnt, trim($val['codice_destinazione'], '='));
                                            $sheet->setCellValue('C' . $cnt, trim($val['fatturato'], '='));
                                            $totalFatturato += $val['fatturato'] * 1;
                                            $recEachCnt++;
                                        }
                                    }
                                }
                                $sheet->setCellValue('B' . ++$cnt, 'Total');
                                $sheet->setCellValue('C' . $cnt, $totalFatturato);
                                $sheet->getStyle('B' . $cnt . ':C' . $cnt)->getFont()->setBold(true);
                                $cnt++;
                            }
                            if ($cnt > 1) {
                                $cnt++;
                            }
                            $sheet->fromArray($exportData, NULL, 'A' . $cnt);
                            $sheet->getStyle('A' . $cnt . ':L' . $cnt)->getFont()->setBold(true);
                            //			$sheet -> setCellValue('A2', 'Name');
                            $filename = 'export_st.xls';
                            header('Content-Type: application/vnd.ms-excel');
                            header('Content-Disposition: attachment;filename="' . $filename . '"');
                            header('Cache-Control: max-age=0');
                            $objWriter = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
                            $objWriter->save('php://output');
                            die();
                            //New export end
                        } else
                            redirect('sthistory/report');
                    }
                    else {

                        $data['title'] = 'plus-ed.com | ST history data report';
                        $data['breadcrumb1'] = 'ST history data';
                        $data['breadcrumb2'] = 'ST history data report';

                        $data['collaboratore'] = $this->input->post('txtCollaboratore');
                        $data['codice_prodotto'] = $this->input->post('txtCodiceProdotto');
                        $data['tipologia_prodotto'] = $this->input->post('selTipologiaProdotto');
                        $data['destinazione_nazione'] = $this->input->post('selDestinazioneNazione');

                        $data['regione'] = $this->input->post('selRegione');
                        $data['macro_regione'] = $this->input->post('selMacroRegione');
                        $data['nazione'] = $this->input->post('selNazione');

                        $data['collaboratoreProvincia'] = $this->input->post('selCollaboratoreProvincia');
                        $data['collaboratoreNazione'] = $this->input->post('selCollaboratoreNazione');
                        $data['collaboratoreRegione'] = $this->input->post('selCollaboratoreRegione');
                        $data['collaboratoreMacroRegione'] = $this->input->post('selCollaboratoreMacroRegione');

                        $data['destinazione'] = $this->input->post('selDestinazione');
                        $data['anno'] = $this->input->post('selAnno');

                        $data['ageStart'] = $this->input->post('selStartAge');
                        $data['ageEnd'] = $this->input->post('selEndAge');
                        // $getData = array( 'collaboratore' => $data['collaboratore'], 'codice_prodotto' => $data['codice_prodotto'], 'tipologia_prodotto' => $data['tipologia_prodotto'], 'destinazione_nazione' => $data['destinazione_nazione'] );

                        $getData = array(
                            'collaboratore' => $data['collaboratore'],
                            'codice_prodotto' => $data['codice_prodotto'],
                            'tipologia_prodotto' => $data['tipologia_prodotto'],
                            'destinazione_nazione' => $data['destinazione_nazione'],
                            'regione' => $data['regione'],
                            'macro_regione' => $data['macro_regione'],
                            'nazione' => $data['nazione'],
                            'collaboratoreProvincia' => $data['collaboratoreProvincia'],
                            'collaboratoreNazione' => $data['collaboratoreNazione'],
                            'collaboratoreRegione' => $data['collaboratoreRegione'],
                            'collaboratoreMacroRegione' => $data['collaboratoreMacroRegione'],
                            'destinazione' => $data['destinazione'],
                            'anno' => $data['anno'],
                            'ageStart' => $data['ageStart'],
                            'ageEnd' => $data['ageEnd']
                        );

                        $data['report_data'] = $this->sthistorymodel->getReportData($getData);
                        $summary_data = '';
                        $data['summary_data'] = '';
                        if (!empty($data['anno']) && !empty($data['collaboratore'])) {
                            $summary_data = $this->sthistorymodel->getSummaryData($getData);
                        }
                        if (!empty($summary_data)) {
                            foreach ($summary_data as $summary) {
                                $data['summary_data'][$summary['tipologia_prodotto']][$summary['destinazione_nazione']][] = array(
                                    'codice_destinazione' => $summary['codice_destinazione'],
                                    'fatturato' => $summary['fatturato']
                                );
                            }
                        }

//		  echo '<pre>';
//		  print_r($data['summary_data']);die;

                        $this->load->view('plused_st_history_report_data', $data);
                    }
                } else {
                    $data['title'] = 'plus-ed.com | ST history data report';
                    $data['breadcrumb1'] = 'ST history';
                    $data['breadcrumb2'] = 'ST history data report';

                    $data['collaboratore'] = $this->sthistorymodel->getDistinctDataByField('collaboratore');
                    $data['codice_prodotto'] = $this->sthistorymodel->getDistinctDataByField('codice_prodotto');
                    $data['tipologia_prodotto'] = $this->sthistorymodel->getDistinctDataByField('tipologia_prodotto');
                    $data['destinazione_nazione'] = $this->sthistorymodel->getDistinctDataByField('destinazione_nazione');

                    $data['regione'] = $this->sthistorymodel->getDistinctDataByField('regione');
                    $data['macro_regione'] = $this->sthistorymodel->getDistinctDataByField('macro_regione');
                    $data['nazione'] = $this->sthistorymodel->getDistinctDataByField('nazione');

                    $data['collaboratoreProvincia'] = $this->sthistorymodel->getDistinctDataByField('collaboratoreProvincia');
                    $data['collaboratoreNazione'] = $this->sthistorymodel->getDistinctDataByField('collaboratoreNazione');
                    $data['collaboratoreRegione'] = $this->sthistorymodel->getDistinctDataByField('collaboratoreRegione');
                    $data['collaboratoreMacroRegione'] = $this->sthistorymodel->getDistinctDataByField('collaboratoreMacroRegione');

                    $data['destinazione'] = $this->sthistorymodel->getDistinctDataByField('destinazione');
                    $data['anno'] = $this->sthistorymodel->getDistinctDataByField('anno');

                    $this->load->view('plused_st_history_report_filters', $data);
                }
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    //End: functions by Preeti M

    function collaboratorepax() {
        authSessionMenu($this);
        if (!empty($_POST)) {//if ($this -> input -> server('REQUEST_METHOD') == 'POST') {
            $collaboratore = $this->input->post('txtCollaboratore');
            $collaboratoreType = $this->input->post('hiddCollaboratoreType');
            $isExport = $this->input->post('isExport');
            $resultSet = $this->sthistorymodel->getCollaboratorePax($collaboratoreType, $collaboratore);
            if (empty($isExport)) {
                $data['txtCollaboratore'] = $collaboratore;
                $data['hiddCollaboratoreType'] = $collaboratoreType;
                $data['resultData'] = $resultSet;
                $data['title'] = 'plus-ed.com | Collaboratore pax - ' . $collaboratoreType;
                $data['breadcrumb1'] = 'ST history data';
                $data['breadcrumb2'] = 'Collaboratore pax - ' . $collaboratoreType;

                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/wsimports/st_history_collaboratore_pax_data', $data);
            } else {
                $exportData = array();
                foreach ($resultSet as $record) {
                    $prevPaxPercent = round($record["old_pax"] * 100 / $record["pax"], 2);
                    if ($collaboratoreType == "corporate") {
                        $exportRecord = array(
                            'Traveling year [ data partenza ]' => $record['traveling_year'],
                            'Azienda' => $record['collaboratore'],
                            'Pax' => $record['pax'],
                            'Previous pax' => $record['old_pax'],
                            'Previous pax %' => $prevPaxPercent
                        );
                    } else {
                        $exportRecord = array(
                            'Traveling year [ data partenza ]' => $record['traveling_year'],
                            'Collaboratore' => $record['collaboratore'],
                            'Pax' => $record['pax'],
                            'Previous pax' => $record['old_pax'],
                            'Previous pax %' => $prevPaxPercent
                        );
                    }
                    array_push($exportData, $exportRecord);
                }
                //array_to_csv_export($exportData, 'collaboratore_pax_by_years');
                $this->load->library('export');
                $this->export->to_excel($exportData, 'collaboratore_pax_by_years');
            }
        } else {
            $data['title'] = 'plus-ed.com | Collaboratore pax';
            $data['breadcrumb1'] = 'ST history data';
            $data['breadcrumb2'] = 'Collaboratore pax';

            $data['collaboratoreProfessori'] = $this->sthistorymodel->getDistinctDataByField('collaboratore', "id_azienda = 0 AND azienda = ''");
            $data['collaboratoreCorporate'] = $this->sthistorymodel->getDistinctDataByField('azienda', "id_azienda != 0 AND azienda != ''");


            $data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/wsimports/st_history_collaboratore_pax', $data);
        }
    }

    function compareprofessori() {
        authSessionMenu($this);
        if (!empty($_POST)) {//if ($this -> input -> server('REQUEST_METHOD') == 'POST') {
            $annoYears = $this->input->post('anno');
            $collaboratoreArr = $this->input->post('selCollaboratorePro');
            $collaboratoreType = $this->input->post('hiddCollaboratoreType');
            $isExport = $this->input->post('isExport');
            if (empty($isExport)) {
                $resultSet = $this->sthistorymodel->getCompareProfessoriPaxDetails($annoYears, $collaboratoreArr);
                $data['txtAnnoYears'] = $annoYears;
                $data['txtCollaboratore'] = $collaboratoreArr;
                $data['hiddCollaboratoreType'] = $collaboratoreType;
                $data['resultData'] = $resultSet;
                $data['title'] = 'plus-ed.com | Compare professori pax';
                $data['breadcrumb1'] = 'ST history data';
                $data['breadcrumb2'] = 'Compare professori pax';

                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/wsimports/st_history_compare_professori_data', $data);
            } else {
                if (!is_array($annoYears) && !empty($annoYears))
                    $annoYears = explode(',', $annoYears);

                if (!is_array($collaboratoreArr) && !empty($collaboratoreArr))
                    $collaboratoreArr = explode(',', $collaboratoreArr);

                $exportAllRecords = false;
                if ($isExport == 2)
                    $exportAllRecords = true;

                $resultSet = $this->sthistorymodel->getCompareProfessoriPaxDetails($annoYears, $collaboratoreArr, $exportAllRecords);

                $exportData = array();
                foreach ($resultSet as $record) {
                    if (!$exportAllRecords) {
                        $exportRecord = array(
                            'Collaboratore' => $record['collaboratore'],
                            'Traveling year [ data partenza ]' => $record['traveling_year'],
                            'Tipologia prodotto' => $record['tipologia_prodotto'],
                            'Destinazione nazione' => $record['destinazione_nazione'],
                            'Pax' => $record['pax'],
                            'Fatturatto' => number_format($record["fatturato"], 2, ',', '.')
                        );
                    } else {
                        $exportRecord = array(
                            'Collaboratore' => $record['collaboratore'],
                            'Traveling year [ data partenza ]' => $record['traveling_year'],
                            'Tipologia prodotto' => $record['tipologia_prodotto'],
                            'Destinazione nazione' => $record['destinazione_nazione'],
                            //passenger,telefono,email,indirizzo,provincia,comune,cap,regione,macro_regione,nazione
                            'Passeggero' => $record['passeggero'],
                            'Telefono' => $record['telefono'],
                            'Email' => $record['email'],
                            'Data Nascita' => date("d/m/Y", strtotime($record['data_nascita'])),
                            'Indirizzo' => $record['indirizzo'],
                            'Provincia' => $record['provincia'],
                            'Comune' => $record['comune'],
                            'Cap' => $record['cap'],
                            'Regione' => $record['regione'],
                            'Macro regione' => $record['macro_regione'],
                            'Nazione' => $record['nazione'],
                            'Pax' => $record['pax'],
                            'Fatturatto' => number_format($record["fatturato"], 2, ',', '.')
                        );
                    }
                    array_push($exportData, $exportRecord);
                }

                $this->load->library('export');
                $this->export->to_excel($exportData, 'compare_professori_pax_by_years');
                //$this->export->exportUsingPhpExcel($exportData, 'compare_professori_pax_by_years');
            }
        } else {
            $data['title'] = 'plus-ed.com | Compare professori pax';
            $data['breadcrumb1'] = 'ST history data';
            $data['breadcrumb2'] = 'Compare professori pax';

            $data['collaboratoreProfessori'] = $this->sthistorymodel->getDistinctDataByField('collaboratore', "id_azienda = 0 AND azienda = ''");
            $data['anno'] = $this->sthistorymodel->getDistinctDataByField('anno');

            $data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/wsimports/st_history_compare_professori', $data);
        }
    }

    /**
     * This function is for compare collaboratore booked pax count if they have zero booked in current year 
     */
    function compareprofessorisecond($ischart = "") {
        authSessionMenu($this);
        if (!empty($_POST)) {//if ($this -> input -> server('REQUEST_METHOD') == 'POST') {
            ini_set('max_execution_time', 120);
            //var_dump($_POST);die;
            // post submit
            $annoYears = $this->input->post('anno');
            $selCollaboratoreMacroRegione = $this->input->post('selCollaboratoreMacroRegione');
            $selTiplogiaProdotto = $this->input->post('selTiplogiaProdotto');
            $selDestinazioneNazione = $this->input->post('selDestinazioneNazione');
            $isExport = $this->input->post('isExport');
            if (empty($isExport)) {
                // set page data
                $data['txtAnnoYears'] = $annoYears;
                $data['selCollaboratoreMacroRegione'] = $selCollaboratoreMacroRegione;
                $data['selTiplogiaProdotto'] = $selTiplogiaProdotto;
                if (!empty($selDestinazioneNazione))
                    $data['selDestinazioneNazione'] = $selDestinazioneNazione;
                else {
                    $resultArr = $this->sthistorymodel->getDistinctDataByField('destinazione_nazione');
                    $new = array();
                    foreach ($resultArr as $k => $v) {
                        $new[$k] = $v['destinazione_nazione'];
                    }
                    $data['selDestinazioneNazione'] = $new;
                }
                if ($ischart == 'chart') {
                    // retrive data
                    // page starts here
                    $data['title'] = 'plus-ed.com | Compare professori pax';
                    $data['breadcrumb1'] = 'ST history data';
                    $data['breadcrumb2'] = 'Compare professori II chart';
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/wsimports/st_history_compare_professori_2_data_chart', $data);
                } else {
                    $data['title'] = 'plus-ed.com | Compare professori pax';
                    $data['breadcrumb1'] = 'ST history data';
                    $data['breadcrumb2'] = 'Compare professori pax';

                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/wsimports/st_history_compare_professori_2_data', $data);
                }
            }
        } else {
            $data['title'] = 'plus-ed.com | Compare professori II';
            $data['breadcrumb1'] = 'ST history data';
            $data['breadcrumb2'] = 'Compare professori II';

            //$data['collaboratoreProfessori'] = $this -> sthistorymodel -> getComProfCollaboratoreZeroPax('collaboratore',"id_azienda = 0 AND azienda = ''");
            $data['collaboratoreProfessori'] = $this->sthistorymodel->getDistinctDataByField('collaboratoreMacroRegione', "id_azienda = 0 AND azienda = ''");
            $data['tipologiaProdotto'] = $this->sthistorymodel->getDistinctDataByField('tipologia_prodotto');
            $data['destinazioneNazione'] = $this->sthistorymodel->getDistinctDataByField('destinazione_nazione');
            $data['anno'] = $this->sthistorymodel->getDistinctDataByField('anno', '', 'desc');

            $data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";
            $data['ischart'] = $ischart;
            $this->ltelayout->view('lte/wsimports/st_history_compare_professori_2', $data);
        }
    }

    /**
     * This function returns an array for table row to 
     * display collaboratore with there pax booked count as per year and contries
     * @param type $tipologiaProdotto
     * @param type $selCollaboratoreMacroRegione
     * @param type $txtAnnoYears
     * @param type $selDestinazioneNazione
     * @return array 
     */
    function getColTipologiaPaxCount($tipologiaProdotto, $selCollaboratoreMacroRegione, $txtAnnoYears, $selDestinazioneNazione) {
        $resultData = array();

        $collaboratoreData = $this->sthistorymodel->getCollaboratoreForMarcroRegion($tipologiaProdotto, $selCollaboratoreMacroRegione, $txtAnnoYears, $selDestinazioneNazione);

        foreach ($collaboratoreData as $collaborotoreArr) {
            $rowArr = array();
            $rowArr['collaboratoreMR'] = $collaborotoreArr['collaboratoreMacroRegione'];
            $rowArr['collaboratore'] = $collaborotoreArr['collaboratore'];
            foreach ($txtAnnoYears as $year) {
                foreach ($selDestinazioneNazione as $nation) {
                    $tipoColPaxCount = $this->sthistorymodel->getTiplogiaCollaboratore($rowArr['collaboratoreMR'], $tipologiaProdotto, $rowArr['collaboratore'], $year, $nation);
                    $smallNation = strtolower($nation);
                    $rowArr[$year . '-' . $smallNation] = $tipoColPaxCount;
                }
            }
            array_push($resultData, $rowArr);
        }

        return $resultData;
    }

    function getColTipologiaPaxCountForChart($tipologiaProdotto, $colMacroRegion, $txtAnnoYears, $destiNazione) {
        $rowArr = array();
        foreach ($txtAnnoYears as $year) {
            $tipoColPaxCount = $this->sthistorymodel->getTiplogiaCollaboratoreChart($tipologiaProdotto, $colMacroRegion, $year, $destiNazione);
            $rowArr[$year . '-' . $destiNazione] = $tipoColPaxCount;
        }
        return $rowArr;
    }

    function reportpax() {
        authSessionMenu($this);

        $data['title'] = 'plus-ed.com | Report for pax (diretti)';
        $data['breadcrumb1'] = 'ST history data';
        $data['breadcrumb2'] = 'Report for pax (diretti)';

        $data['pageHeader'] = $data['breadcrumb2'];
        $data['optionalDescription'] = "";

        if (!empty($_POST)) {
            $data['destinazione_nazione'] = $this->input->post('selDestinazioneNazione');

            $data['tipologiaProdotto'] = $this->input->post('selTipologiaProdotto');
            $data['timesPaxTravelled'] = $this->input->post('timesPaxTravelled');

            $data['regione'] = $this->input->post('selRegione');
            $data['macroRegione'] = $this->input->post('selMacroRegione');
            $data['nazione'] = $this->input->post('selNazione');
            $data['startAge'] = $this->input->post('selStartAge');
            $data['endAge'] = $this->input->post('selEndAge');
            $data['clientiDiretti'] = $this->input->post('clientiDiretti');
            $data['annoYear'] = $this->input->post('selAnno');


            $isExport = $this->input->post('isExport');
            if ($isExport) {
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', '0');
                $paxListing = $this->sthistorymodel->reportPaxListing(0, 0, array(), "", $data);
                $exportData = array();
                if (!empty($paxListing)) {
                    foreach ($paxListing as $record) {
                        $exportRecord = array(
                            'Passeggero' => $record['passeggero'],
                            'Anno' => $record['anno'],
                            'Data partenza' => date('d/m/Y', strtotime($record['data_partenza'])),
                            'Telefono' => $record['telefono'],
                            'Email' => $record['email'],
                            'Data nascita' => date('d/m/Y', strtotime($record['data_nascita'])),
                            'Sesso' => $record['sesso'],
                            'Tipologia Passeggero' => $record['tipologia_passeggero'],
                            'Sistemazione' => $record['sistemazione'],
                            'Codice Destinazione' => $record['codice_destinazione'],
                            'Indirizzo' => $record['indirizzo'],
                            'Provincia' => $record['provincia'],
                            'Comune' => $record["comune"],
                            'Cap' => $record['cap'],
                            'Regione' => $record['regione'],
                            'Macro regione' => $record['macro_regione'],
                            'Nazione' => $record['nazione'],
                            'Destinazione' => $record['destinazione'],
                            'Destinazione nazione' => $record['destinazione_nazione'],
                            'Fatturato' => $record['fatturato']
                        );
                        array_push($exportData, $exportRecord);
                    }
                }
                $this->load->library('export');
                $this->export->exportUsingPhpExcel($exportData, 'report_pax');
            } else
                $this->ltelayout->view('lte/wsimports/st_history_report_pax_data', $data);
        }
        else {
            $data['tipologia_prodotto'] = $this->sthistorymodel->getDistinctDataByField('tipologia_prodotto');
            $data['destinazione_nazione'] = $this->sthistorymodel->getDistinctDataByField('destinazione_nazione');
            $data['regione'] = $this->sthistorymodel->getDistinctDataByField('regione');
            $data['macro_regione'] = $this->sthistorymodel->getDistinctDataByField('macro_regione');
            $data['nazione'] = $this->sthistorymodel->getDistinctDataByField('nazione');
            $data['annoYear'] = $this->sthistorymodel->getDistinctDataByField('anno');
            $this->ltelayout->view('lte/wsimports/st_history_report_pax_filters', $data);
        }
    }

    /*
     * Purpose: Load Report pax with Ajax with datatable JS
     * Date: 21 Nov 2016
     */

    public function report_pax_listing() {
        $iDraw = $this->input->post('draw');
        $iPageSize = $this->input->post('length');
        $iRecordStartFrom = $this->input->post('start');

        $iOrderByColumn = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : "";
        $sOrderBy = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "";

        $aOrderByCondition = array();
        if ($iOrderByColumn != "" && $sOrderBy != "") {
            $columnsArray = array('passeggero', 'anno', 'data_partenza', 'telefono', 'email', 'data_nascita', 'indirizzo', 'provincia', 'comune', 'cap', 'regione', 'macro_regione', 'nazione', 'destinazione_nazione');
            $aOrderByCondition = array('column_name' => $columnsArray[$iOrderByColumn], 'order_by' => $sOrderBy);
        }
        $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : "";

        $getData['destinazione_nazione'] = ( $this->input->post('destinazioneNazione') ) ? explode(",", $this->input->post('destinazioneNazione')) : "";

        $getData['tipologiaProdotto'] = $this->input->post('tipologiaProdotto');
        $getData['timesPaxTravelled'] = $this->input->post('timesPaxTravelled');

        $getData['regione'] = $this->input->post('regione');
        $getData['macroRegione'] = $this->input->post('macroRegione');
        $getData['nazione'] = $this->input->post('nazione');
        $getData['startAge'] = $this->input->post('startAge');
        $getData['endAge'] = $this->input->post('endAge');
        $getData['clientiDiretti'] = $this->input->post('clientiDiretti');
        $getData['annoYear'] = $this->input->post('selAnno');

        $paxCount = $this->sthistorymodel->reportPaxCount($searchValue, $getData);
        $paxListing = $this->sthistorymodel->reportPaxListing($iPageSize, $iRecordStartFrom, $aOrderByCondition, $searchValue, $getData);
        if ($paxCount > 0) {
            foreach ($paxListing as $key => $val) {
                $aDataTableResponse[$key] = array($val['passeggero'], $val['anno'], date('d/m/Y', strtotime($val['data_partenza'])), $val['telefono'], $val['email'], date('d/m/Y', strtotime($val['data_nascita'])), $val['indirizzo'], $val['provincia'], $val['comune'], $val['cap'], $val['regione'], $val['macro_regione'], $val['nazione'], $val['destinazione_nazione']);
            }
        } else {
            $aDataTableResponse = "";
        }

        if (!empty($aDataTableResponse) && count($aDataTableResponse) > 0) {
            echo json_encode(array("draw" => $iDraw, "recordsTotal" => $paxCount, "recordsFiltered" => $paxCount, "data" => $aDataTableResponse));
        } else {
            echo json_encode(array("recordsTotal" => 0, "recordsFiltered" => 0, "data" => ''));
        }
    }

    public function historyDataProfessori() {
        $request = $_REQUEST;
        if (!$request['professoriGet']) {
            echo json_encode(array('error' => true, 'message' => 'Invalid Request'));
            exit(0);
        }
        parse_str($request['historyParam'], $searchData);

        $getData = array(
            'collaboratore' => @$searchData['txtCollaboratore'],
            'codice_prodotto' => @$searchData['txtCodiceProdotto'],
            'tipologia_prodotto' => @$searchData['selTipologiaProdotto'],
            'destinazione_nazione' => @$searchData['selDestinazioneNazione'],
            'regione' => @$searchData['selRegione'],
            'macro_regione' => @$searchData['selMacroRegione'],
            'nazione' => @$searchData['selNazione'],
            'collaboratoreProvincia' => @$searchData['selCollaboratoreProvincia'],
            'collaboratoreNazione' => @$searchData['selCollaboratoreNazione'],
            'collaboratoreRegione' => @$searchData['selCollaboratoreRegione'],
            'collaboratoreMacroRegione' => @$searchData['selCollaboratoreMacroRegione'],
            'destinazione' => @$searchData['selDestinazione'],
            'anno' => @$searchData['selAnno'],
            'ageStart' => @$searchData['selStartAge'],
            'ageEnd' => @$searchData['selEndAge'],
            'fatturatoMin' => @$searchData['selFatturatoMin'],
            'fatturatoMax' => @$searchData['selFatturatoMax'],
            'accumulative' => @$searchData['chkAccumulative'],
            'checkagetoday' => @$searchData['chkCheckAgeToday'],
            'search' => $request['search']['value']
        );

        $param = datatable_param($request, 'anno');
        $reportData = $this->sthistorymodel->getReportDataProfessori($getData, $param);
        $reportCount = $this->sthistorymodel->getReportDataProfessoriCount($getData);
        if (empty($reportData)) {
            $reportData = array();
        } else {
            $reportData = $this->makeProfessoriReportData($reportData);
        }
        echo datatable_json($request['draw'], $reportCount, $reportData);
        exit(0);
    }

    public function historyDataCorporate() {
        $request = $_REQUEST;
        if (!$request['professoriGet']) {
            echo json_encode(array('error' => true, 'message' => 'Invalid Request'));
            exit(0);
        }
        parse_str($request['historyParam'], $searchData);

        $getData = array(
            'collaboratore' => @$searchData['txtCollaboratore'],
            'codice_prodotto' => @$searchData['txtCodiceProdotto'],
            'tipologia_prodotto' => @$searchData['selTipologiaProdotto'],
            'destinazione_nazione' => @$searchData['selDestinazioneNazione'],
            'regione' => @$searchData['selRegione'],
            'macro_regione' => @$searchData['selMacroRegione'],
            'nazione' => @$searchData['selNazione'],
            'destinazione' => @$searchData['selDestinazione'],
            'anno' => @$searchData['selAnno'],
            'ageStart' => @$searchData['selStartAge'],
            'ageEnd' => @$searchData['selEndAge'],
            'fatturatoMin' => @$searchData['selFatturatoMin'],
            'fatturatoMax' => @$searchData['selFatturatoMax'],
            'accumulative' => @$searchData['chkAccumulative'],
            'checkagetoday' => @$searchData['chkCheckAgeToday'],
            'search' => $request['search']['value']
        );

        $param = datatable_param($request, 'anno');
        $reportData = $this->sthistorymodel->getReportDataCorporate($getData, $param);
        $reportCount = $this->sthistorymodel->getReportDataCorporateCount($getData);
        if (empty($reportData)) {
            $reportData = array();
        } else {
            $reportData = $this->makeProfessoriReportData($reportData);
        }
        echo datatable_json($request['draw'], $reportCount, $reportData);
        exit(0);
    }

    private function makeProfessoriReportData($reportData) {
        if (empty($reportData)) {
            return array();
        }
        foreach ($reportData as $key => $data) {
            $reportData[$key]['fatturato'] = number_format($data["fatturato"], 2, ',', '.');
        }
        return $reportData;
    }

    /* temporory not required */
//        function gettipologia(){
//            $collaboratore = $this->input->post('collaboratore');
//            $data['tipologiaProdotto'] = $this -> sthistorymodel -> getComProfTipologia($collaboratore);
//        }
}

/* End of file webservice.php */