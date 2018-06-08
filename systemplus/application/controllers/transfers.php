<?php

/**
 * Class to manage transfers
 * @author SK
 * @since 28-May-2018
 */
class Transfers extends Controller {

    public function __construct() {
        parent::Controller();
        authSessionMenu($this);
        $this->load->model('agents/transfersmodel', 'transfersmodel');
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'email', 'ltelayout', 'form_validation'));
    }

    /**
     * Set transfer
     * this function is used to load available bookings pax list to select
     * tranfers
     * @param string $in_out is a type as inbound / outbound
     */
    function setTransfers($in_out) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->transfersmodel->getAllCampus();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : "";
            $when = isset($_POST['when']) ? $_POST['when'] : date("d/m/Y");
            $data["campus"] = $campus;
            $data["when"] = $when;
            $data["in_out"] = $in_out;
            if ($in_out == "inbound")
                $data["all_transfers"] = $this->transfersmodel->setTransfers($campus, $when);
            else
                $data["all_transfers"] = $this->transfersmodel->setTransfersOut($campus, $when);
            $data['title'] = 'plus-ed.com | Book ' . $in_out . ' transfers';
            $data['breadcrumb1'] = 'Transfers';
            $data['breadcrumb2'] = 'Book ' . $in_out . ' transfers';
            if ($in_out == "inbound") {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/transfers/set_transfers', $data);
            } else {
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/transfers/set_transfers_out', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function setTransfersTransport($type, $campus, $quando) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            if (!empty($_POST)) {
                $tuttiPax = 0;
                $insertTransfers = $this->transfersmodel->setTransfersTransport($type, $quando);
                $allTransfers = $this->transfersmodel->getTransfersById($insertTransfers);
                foreach ($allTransfers as $uT) {
                    $tuttiPax+=$uT["tot_pax"];
                    if ($type == "inbound") {
                        $airport = $uT["ptt_airport_to"];
                    } else {
                        $airport = $uT["ptt_airport_from"];
                    }
                }
                if ($tuttiPax <= 0) {
                    echo "ERROR";
                    die();
                }
                $data["tot_pax"] = $tuttiPax;
                $data["bus"] = $this->transfersmodel->busListForTransfers($campus, $airport, $type);
                $data["pickupPlace"] = $this->transfersmodel->centerPickupById($campus);
                $data["excursion_id"] = 0;
                $data["airport"] = "";
                if ($data["bus"]) {
                    $data["excursion_id"] = $data["bus"][0]["exc_id"];
                    $data["airport"] = $data["bus"][0]["exc_excursion"];
                }
                //print_r($allTransfers);
                //print_r($data["bus"]);
                $data["in_out"] = $type;
                $data["quando"] = $quando;
                $data["allTransfers"] = $allTransfers;
                $data['title'] = 'plus-ed.com | Book bus for' . $type . ' transfers';
                $data['breadcrumb1'] = 'Transfers';
                $data['breadcrumb2'] = 'Book bus for ' . $type . ' transfers';

                if (APP_THEME == "OLD")
                    $this->load->view('plused_set_transfers_transports', $data);
                else { // if(APP_THEME == "LTE")
                    $data['pageHeader'] = $data['breadcrumb2'];
                    $data['optionalDescription'] = "";
                    $this->ltelayout->view('lte/backoffice/transfers/set_transfers_transports', $data);
                }
            } else {
                redirect('transfers/setTransfers/' . $type, 'refresh');
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function plusedConfirmTransfersBuses() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            //foreach($_POST as $key => $value){
            //	echo "<br> $key ---> $value";
            //}
            //die();
            $exc_numb = isset($_POST['exc_numb']) ? $_POST['exc_numb'] : '';
            if ($exc_numb == '') {
                echo "ERROR! No Bookings involved!";
                die();
            } else {
                $quando_tra = isset($_POST['quando_tra']) ? $_POST['quando_tra'] : '';
                if ($quando_tra == '') {
                    echo "ERROR! No Transfer Date!";
                    die();
                } else {
                    $exc_date = $quando_tra;
                    $busCode = $this->transfersmodel->busCode();
                    //print_r($exc_numb);
                    //die();
                    foreach ($exc_numb as $knum => $vnum) {
                        $this->transfersmodel->standbyTransferExcursion($busCode, $vnum, $exc_date);
                    }
                }
            }
            foreach ($_POST as $key => $value) {
                $pos = strpos($key, "bus_");
                if ($pos !== false) {
                    if ($value > 0) {
                        $arrnumbus = explode("_", $key);
                        $numIdBus = $arrnumbus[1];
                        $addBusTab = $this->transfersmodel->addBusTab($numIdBus, $value, $exc_date, $busCode);
                        //echo "||$addBusTab|| <br>--->$key --> id bus = $numIdBus | qty bus = $value | id exc = ".$_POST['id_exc_join']." | costo singolo bus = ".$_POST[$strCostoBus]." | data escursione = ".$exc_date." | hpickup = ".$_POST['pickup_time']." | hreturn = ".$_POST['return_hour']." | place pickup = ".$_POST['pickup_place']." | currency = ".$_POST[$strCurrencyBus];
                    }
                }
            }
            //REDIRECT AL DETTAGLIO PASSANDO IN GET $busCode
            redirect('transfers/busTraDetail/code_' . $busCode, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }

    function busTraDetail($codeBus) {
//tutti i riferimenti commentati a plused_exc_bookings devono essere girati a plused_tra_transfers
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $codeBusArr = explode("_", $codeBus);
            $data['title'] = 'plus-ed.com | Transfer plan detail - Code ' . $codeBusArr[1];
            $data['breadcrumb1'] = 'Transportation';
            $data['breadcrumb2'] = 'Transfer plan detail - Code ' . $codeBusArr[1];
            $data["bus_detail"] = $this->transfersmodel->busDetailForExcursion($codeBusArr[1]);
            $data["plan_detail"] = $this->transfersmodel->excDetail($codeBusArr[1]);
            $arrayescursioni = $this->transfersmodel->getTraIdsFromBusCode($codeBusArr[1]);
            $data["bkg_detail"] = $this->transfersmodel->bkgDetailsForTransfer($arrayescursioni);
            $data["bus_code"] = $codeBusArr[1];
            $data["allpax"] = $this->transfersmodel->getTraPaxForBusCode($codeBusArr[1]);
            $data["effettivi"] = $this->transfersmodel->getTraRealPaxForBusCode($codeBusArr[1]);
            $data["status_ex"] = $this->transfersmodel->getTraStatusByBusCode($codeBusArr[1]);
            $data["tipo_ex"] = $this->transfersmodel->getTraTypeByBusCode($codeBusArr[1]);
            $arrayPrenotazioni = array();
            foreach ($data["bkg_detail"] as $sbooking) {
                $onlyBookA = explode("_", $sbooking["ptt_book_id"]);
                $onlyBook = $onlyBookA[1];
                array_push($arrayPrenotazioni, $onlyBook);
            }

            $data["ruolo"] = $this->session->userdata('role');
            $data['pageHeader'] = $data['breadcrumb2'];
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/transfers/transfer_plan_detail', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }
    
    function busTraReset($codeBus) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $this->transfersmodel->busTraReset($codeBus);
            redirect('transfers/viewBookedTransfers', 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }
    
    function busDetailForExcursion($buscode) {
        $data["coaches"] = $this->transfersmodel->busDetailForExcursion($buscode);

        if (APP_THEME == "OLD")
            $this->load->view('plused_detCoaches', $data);
        else { // if(APP_THEME == "LTE")
            $this->load->view('lte/backoffice/transfers/det_coaches', $data);
        }
    }
    
    function viewBookedTransfers() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["centri"] = $this->transfersmodel->getAllCampus();
            $campus = isset($_POST['centri']) ? $_POST['centri'] : '';
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'all';
            $from = isset($_POST['from']) ? $_POST['from'] : date("d/m/Y");
            $fromA = explode("/", $from);
            $fromGirato = $fromA[2] . "-" . $fromA[1] . "-" . $fromA[0];
            $to = isset($_POST['to']) ? $_POST['to'] : date("d/m/Y", strtotime($fromGirato . "+ 7 days"));
            $status = isset($_POST['status']) ? $_POST['status'] : 'all';
            $data["campus"] = $campus;
            $data["tipo"] = $tipo;
            $data["to"] = $to;
            $data["from"] = $from;
            $data["status"] = $status;
            $data["all_transfers"] = $this->transfersmodel->viewBookedTransfers($campus, $tipo, $to, $from, $status);
            $data['title'] = 'plus-ed.com | View booked transfers';
            $data['breadcrumb1'] = 'Transfers';
            $data['breadcrumb2'] = 'View booked transfers';

            if (APP_THEME == "OLD")
                $this->load->view('plused_view_booked_transfers', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/transfers/view_booked_transfers', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }
    
    function busTraConfirm($codeBus) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $this->transfersmodel->busTraConfirm($codeBus);
            redirect('transfers/viewBookedTransfers', 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }
    
    function ca_getTransfersPaxFromBusCode($busCode, $tipo) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data['allPaxOnBus'] = $this->transfersmodel->ca_getTransfersPaxFromBusCode($busCode);
            $data['codebus'] = $busCode;
            $data['tipo'] = $tipo;
            $this->load->view('lte/backoffice/transfers/plused_micro_detMyPaxOnBus', $data);
        } else {
            redirect('backoffice', 'refresh');
        }
    }
    
    function addPaxToExistingTransfer($busCode, $idBook, $idYear, $totPax) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $this->transfersmodel->addPaxToExistingTransfer($busCode, $idBook, $idYear, $totPax);
            redirect('transfers/busTraDetail/code_' . $busCode, 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }
    
    function resetLostTransfers() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data["losttransfers"] = $this->transfersmodel->viewLostTransfers();
            $data['title'] = 'plus-ed.com | Lost and found transfers';
            $data['breadcrumb1'] = 'Transfers';
            $data['breadcrumb2'] = 'Lost and found transfers';
            if (APP_THEME == "OLD")
                $this->load->view('plused_reset_transfers', $data);
            else { // if(APP_THEME == "LTE")
                $data['pageHeader'] = $data['breadcrumb2'];
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/transfers/reset_transfers', $data);
            }
        } else {
            redirect('backoffice', 'refresh');
        }
    }
    
    function actionResetLostTrasfers() {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $this->transfersmodel->actionResetLostTransfers();
            redirect('transfers/resetLostTransfers', 'refresh');
        } else {
            redirect('backoffice', 'refresh');
        }
    }
}
/* End of file roles.php */