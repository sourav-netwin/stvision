<?php

class Bo_accounting extends Controller {

	public function __construct() {

		parent::Controller();

		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('mbackoffice');
		$this -> load -> model('magenti');
		$this -> load -> model('gestione_centri_model');
		$this -> load -> library('session', 'email');
	}

	function view_active() {
		if ($this -> session -> userdata('ruolo') == "contabile") {
			$data["centri"] = $this -> mbackoffice -> getAllCampus();
			$data["payTypes"] = $this -> mbackoffice -> getAllPaymentTypes();
			$data["tutte_agenzie"] = $this -> mbackoffice -> getAllAgencies();
			$campus = isset($_POST['centri']) ? $_POST['centri'] : 'all';
			$status = 'active';
			$agent = isset($_POST['agenzia_in']) ? $_POST['agenzia_in'] : 'all';
			$datein = isset($_POST['date_in']) ? $_POST['date_in'] : 'all';
			$dateout = isset($_POST['date_out']) ? $_POST['date_out'] : 'all';
			$data["campus"] = $campus;
			$data["agenziefrom"] = $agent;
			$data["statusfrom"] = $status;
			$data["datafrom"] = $datein;
			$data["datato"] = $dateout;
			$data["all_books"] = $this -> mbackoffice -> overviewBookings($campus, $agent, $status, $datein, $dateout, 0);
			$data['title'] = 'plus-ed.com | Down payment';
			$data['breadcrumb1'] = 'Accounting';
			$data['breadcrumb2'] = 'Down payment';
			$this -> load -> view('plused_viewActive', $data);
		}
		else {
			redirect('backoffice', 'refresh');
		}
	}

	function viewActiveNew($status = "") {
		if ($this -> session -> userdata('ruolo') == "contabile") {
			$lastYear = $this -> mbackoffice -> getLastBookingYear();
			$data["season"] = isset($_POST['season']) ? $_POST['season'] : $lastYear;
			$data["centri"] = $this -> mbackoffice -> getAllCampus(1);
			$data["tutte_agenzie"] = $this -> mbackoffice -> getAllAgencies();
			$data["pStatus"] = $status;
			$data['title'] = 'plus-ed.com | Down payment';
			$data['breadcrumb1'] = 'Accounting';
			$data['breadcrumb2'] = 'Down payment';
			$this -> load -> view('plused_viewActiveNew', $data);
		}
		else {
			redirect('backoffice', 'refresh');
		}
	}

	function clear_records() {
		if ($this -> session -> userdata('ruolo') == "contabile") {
			if ($_POST) {
				foreach ($_POST as $key => $value) {
					$indice = explode("-", $key);
					if ($indice[0] == "clear") {
						//echo "writing booking ".$indice[1];
						$idtoclear = $indice[1];
						$thepax = "pax-" . $idtoclear;
						$thedeposit = "deposit-" . $idtoclear;
						$thepayment = "payment-" . $idtoclear;
						$thecurrency = "valuta-" . $idtoclear;
						$thenotes = "notes-" . $idtoclear;
						$currencydate = "currencyDate-" . $idtoclear;
						$this -> mbackoffice -> clear_id($idtoclear, $_POST[$thepax], $_POST[$thedeposit]);
						$justBkIdArr = explode("_", $idtoclear);
						$justBkId = $justBkIdArr[1];
						$this -> mbackoffice -> insertPayment($justBkId, $_POST[$thedeposit], $_POST[$thepayment], $_POST[$thecurrency], $_POST[$currencydate], "avere", "Deposit", $_POST[$thenotes]);
					}
				}
			}
			redirect('bo_accounting/view_active', 'refresh');
		}
		else {
			redirect('backoffice', 'refresh');
		}
	}

	function set_extras() {
		if ($this -> session -> userdata('ruolo') == "contabile") {
			$data['name'] = $this -> session -> userdata('first_name');
			$data['surname'] = $this -> session -> userdata('last_name');
			$data['centri'] = $this -> gestione_centri_model -> building();
			$data['tutte_agenzie'] = $this -> gestione_centri_model -> agency_building();
			$centro = isset($_POST['centri']) ? $_POST['centri'] : '';
			$form_data = isset($_POST['date_in']) ? $_POST['date_in'] : '';
			$form_stato = 'confirmed';
			$form_agenzia = isset($_POST['agenzia_in']) ? $_POST['agenzia_in'] : '';
			$data['campus'] = $centro;
			$data['datafrom'] = $form_data;
			$data['agenziefrom'] = $form_agenzia;
			$data['statusfrom'] = $form_stato;
			$data['all_insert'] = $this -> mbackoffice -> transfer_status($centro, $form_data, $form_agenzia, $form_stato, 1);
			//Script tot pax e gl
			$n_array = count($data['all_insert']);
			for ($i = 0; $i < $n_array; $i++) {
				@$lista_pax += $data['all_insert'][$i]['tot_pax'];
				@$lista_gl += $data['all_insert'][$i]['n_gruppo'];
			}
			@$data['tot_pax_list'] = $lista_pax;
			@$data['tot_gl_list'] = $lista_gl;
			//Fine script
			$totale_agency = $data['all_insert'];
			for ($i = 0; $i <= count($totale_agency); $i++) {
				@ $nome_agency = $data['all_insert'][$i]['id_agency'];
				$data['name_agency'][$i] = $this -> gestione_centri_model -> information_agency_nagency($nome_agency);
			}
			$totale_gl = $data['all_insert'];
			for ($i = 0; $i <= count($totale_gl); $i++) {
				@ $nome_gl = $data['all_insert'][$i]['id_nome_gruppo'];
				$data['gl'][$i] = $this -> gestione_centri_model -> information_name_gl($nome_gl);
			}
			$this -> load -> view('form_set_extras', $data);
		}
		else {
			redirect('backoffice', 'refresh');
		}
	}

	function view_confirmed($stato_finale) {
		if ($this -> session -> userdata('ruolo') == "contabile") {
			$data['name'] = $this -> session -> userdata('first_name');
			$data['surname'] = $this -> session -> userdata('last_name');
			$data['centri'] = $this -> gestione_centri_model -> building();
			$data['tutte_agenzie'] = $this -> gestione_centri_model -> agency_building();
			$centro = isset($_POST['centri']) ? $_POST['centri'] : '';
			$form_data = isset($_POST['date_in']) ? $_POST['date_in'] : '';
			$form_stato = 'confirmed';
			$form_agenzia = isset($_POST['agenzia_in']) ? $_POST['agenzia_in'] : '';
			$data['campus'] = $centro;
			$data['datafrom'] = $form_data;
			$data['agenziefrom'] = $form_agenzia;
			$data['statusfrom'] = $form_stato;
			$data['statocheck'] = $stato_finale;
			$data['all_insert'] = $this -> mbackoffice -> view_outstandings($centro, $form_data, $form_agenzia, $form_stato, 1, $stato_finale);
			//Script tot pax e gl
			$n_array = count($data['all_insert']);
			for ($i = 0; $i < $n_array; $i++) {
				@$lista_pax += $data['all_insert'][$i]['tot_pax'];
				@$lista_gl += $data['all_insert'][$i]['n_gruppo'];
			}
			@$data['tot_pax_list'] = $lista_pax;
			@$data['tot_gl_list'] = $lista_gl;
			//Fine script
			$totale_agency = $data['all_insert'];
			for ($i = 0; $i <= count($totale_agency); $i++) {
				@ $nome_agency = $data['all_insert'][$i]['id_agency'];
				$data['name_agency'][$i] = $this -> gestione_centri_model -> information_agency_nagency($nome_agency);
			}
			$totale_gl = $data['all_insert'];
			for ($i = 0; $i <= count($totale_gl); $i++) {
				@ $nome_gl = $data['all_insert'][$i]['id_nome_gruppo'];
				$data['gl'][$i] = $this -> gestione_centri_model -> information_name_gl($nome_gl);
			}
			$this -> load -> view('form_view_confirmed', $data);
		}
		else {
			redirect('backoffice', 'refresh');
		}
	}
	/**
	 * Start: Additions by Arunsankar
	 * @since 29-June-2016
	 */

	/**
	 * Function to show page for CM balance page
	 * @author Arunsankar
	 * @since 29-June-2016
	 */
	function cm_balances() {
		if ($this -> session -> userdata('ruolo') == "contabile") {
			$data['title'] = 'plus-ed.com | Review CM Balances';
			$data['breadcrumb1'] = 'Accounting';
			$data['breadcrumb2'] = 'Review CM Balances';
			$data["centri"] = $this -> mbackoffice -> getAllCampus(1);
			$data["balancs"] = $this -> mbackoffice -> getCmBalance();
			$this -> load -> view('plused_cm_balances', $data);
		}
		else {
			redirect('backoffice', 'refresh');
		}
	}

	/**
	 * Function to show popup for CM balance for selected campuses
	 * @author Arunsankar
	 * @since 29-June-2016
	 */
	function cmBalanceView() {
		if ($this -> session -> userdata('ruolo') == "contabile") {
			$campusIdList = func_get_args();
			$data["balances"] = $this -> mbackoffice -> getCmBalance($campusIdList);
			$data['title'] = 'plus-ed.com | Review CM Balances';
			$data['breadcrumb1'] = 'Accounting';
			$data['breadcrumb2'] = 'Review CM Balances';
			$this -> load -> view('plused_cm_balances_popup', $data);
		}
		else {
			redirect('backoffice', 'refresh');
		}
	}

	/**
	 * Function to download all available documents in a campus
	 * @author Arunsankar
	 * @since 29-June-2016
	 */
	function downloadAllCmDocument($campusId) {
		if ($this -> session -> userdata('ruolo') == "contabile" && !empty($campusId)) {
			$this -> load -> library('zip');
			$documentList = $this -> mbackoffice -> getCmBookList($campusId);
			$campusName = $this -> mbackoffice -> getCampusNameFromId($campusId);
			if (!empty($documentList)) {
				$documentCount = sizeof($documentList);
				for ($i = 0; $i < $documentCount; $i++) {
					$this -> zip -> read_file(PAYMENT_CM_PATH . $documentList[$i]); //read all files for add to zip
				}
				$this -> zip -> download($campusName . '_documents.zip'); //download zip file through browser
			}
			else {
				redirect('backoffice', 'refresh');
			}
		}
		else {
			redirect('backoffice', 'refresh');
		}
	}

	/**
	 * Function to show page for individual campus balance
	 * @author Arunsankar
	 * @since 29-June-2016
	 */
	function viewSingleCmTr($campusId) {
		if ($this -> session -> userdata('ruolo') == "contabile" && !empty($campusId)) {
			$data['payments'] = $this -> mbackoffice -> getCmPayments($campusId);
			$data['title'] = 'plus-ed.com | Review CM Balances';
			$data['breadcrumb1'] = 'Accounting';
			$data['breadcrumb2'] = 'Review CM Balances';
			$data['campusName'] = $this -> mbackoffice -> getCampusNameFromId($campusId);
			$this -> load -> view('plused_cm_balances_single', $data);
		}
		else {
			redirect('backoffice', 'refresh');
		}
	}
	/* End: Additions by Arunsankar */
}

?>