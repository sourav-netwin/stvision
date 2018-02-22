<?php
/**
 * @modified_by Arunsankar S
 * @date : 15-04-2016
 */
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Plus-Ed</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/NA_style.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery-ui-1.8.21.custom.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>css/elements.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/excursion.css" />

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			.panel-title{
				font-size:12px;
			}
			.ui-dialog{
				width: auto !important;
			}
			.ui-dialog .ui-dialog-titlebar-close:before{
				content: 'x' !important;
				display: block !important;
				text-indent: 0 !important;
				margin-top: -2px !important;
			}
			.ui-dialog .ui-dialog-titlebar-close{
				color: rgb(0, 0, 0);
				background: rgb(239, 239, 239) none repeat scroll 0% 0%;
			}
			.ui-dialog .ui-dialog-titlebar-close:hover{
				color: rgb(255, 255, 255);
				background: rgb(195, 71, 71) none repeat scroll 0% 0%;
			}
			.ui-dialog .ui-dialog-buttonpane button{
				background: rgb(239, 239, 239) none repeat scroll 0% 0%;
			}
			.ui-dialog .ui-dialog-buttonpane button:hover{
				background: #5b9fea;
			}
			.visa-panel-body{
				overflow: auto !important;
			}
			@media(max-width: 650px){
				.visa-panel{
					height: 55px !important;
				}
				#printVisaPax{
					float: left !important;
				}
				#lockWholeRoster{
					float: left !important;
				}
				.ui-dialog[aria-labelledby="ui-dialog-title-dialog_modal"]{
					width: 100% !important;
				}
				.ui-dialog[aria-labelledby="ui-dialog-title-dialog_modal"] .ui-button{
					display: block !important;
				}
				
			}
		</style>
	</head>
	<body style="background-color:transparent;" id="newAva2015">
		<div class="container-fluid">
			<ul class="nav nav-pills" role="tablist">
				<li id="pill_a" role="presentation" class="active"><a href="#a" data-toggle="pill"><span class="glyphicon glyphicon-search"></span> Booking details</a></li>
				<li id="pill_b" role="presentation"><a href="#b" data-toggle="pill"><span class="glyphicon glyphicon-user"></span> VISA</a></li>
				<?php
				if (isset($_SERVER["HTTP_REFERER"])) {
					if (!strpos($_SERVER["HTTP_REFERER"], "dashboard")) {
						?>
						<li role="presentation" class="pull-right"><a id="backToList" data-toggle="pill"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></li>
						<?php
					}
				}
				?>
			</ul>
			<?php
			$isFlocked = 0;
			$da = explode("-", $book[0]["arrival_date"]);
			$dd = explode("-", $book[0]["departure_date"]);
			$maxNoLmDate = date("d/m/Y", strtotime($book[0]["arrival_date"]) - (24 * 3600 * 30));
			$maxLmDate = date("d/m/Y", strtotime($book[0]["arrival_date"]) - (24 * 3600 * 1));
			//echo $maxNoLmDate;
			$storeId = $book[0]["id_book"];
			$campusId = $book[0]["id_centro"];
			$yearId = $book[0]["id_year"];
			$accos = $book[0]["all_acco"];
			$now = time();
			$your_date = strtotime($book[0]["arrival_date"]);
			$dayToArrive = round(($now - $your_date) / 86400 * -1);
			$valutaCampo = $book[0]["valuta"];
			$valoreAcconto = $book[0]["tot_pax"] * 1 * $book[0]["valore_acconto"] * 1;
			?>
			<div class="tab-content" style="margin-top:10px;">
				<div class="tab-pane fade in active" id="a">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Booking details - <strong><?php echo $yearId; ?>_<?php echo $storeId; ?></strong></h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">
									<address>
										<strong><?php echo $book[0]["id_year"] ?>_<?php echo $book[0]["id_book"] ?><?php if ($book[0]["id_ref_overnight"]) { ?> - <span style="color:#f00;">OVERNIGHT (<?php echo $book[0]["id_ref_overnight"] ?>)</span><?php } ?></strong><br>
										<?php echo $book[0]["centro"] ?> - [<?php echo $dayToArrive ?> days to arrival]<br>
										<strong>Date in: </strong><span id="ok_A_Date"><?php echo $da[2] ?>/<?php echo $da[1] ?>/<?php echo $da[0] ?></span><br>
										<strong>Date out: </strong><?php echo $dd[2] ?>/<?php echo $dd[1] ?>/<?php echo $dd[0] ?><br>
										<abbr title="Phone">P:</abbr> <?php echo $agente[0]["businesstelephone"] ?>
									</address>
								</div>					
								<div class="col-md-3">
									<address>
										<strong><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $agente[0]["businesscountry"] ?>.png" alt="<?php echo $agente[0]["businesscountry"] ?>" title="<?php echo $agente[0]["businesscountry"] ?>" /><?php echo $agente[0]["businessname"] ?></strong><br>
										<?php echo $agente[0]["businessaddress"] ?><br>
										<?php echo $agente[0]["businesscity"] ?>, <?php echo $agente[0]["businesscountry"] ?><br>
										<abbr title="Phone">P:</abbr> <?php echo $agente[0]["businesstelephone"] ?>
									</address>
								</div>
								<div class="col-md-3">
									<address>
										<strong><?php echo $agente[0]["mainfirstname"] ?> <?php echo $agente[0]["mainfamilyname"] ?></strong><br>
										<a href="mailto:<?php echo $agente[0]["email"] ?>"><?php echo $agente[0]["email"] ?></a>
									</address>
								</div>

							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade in" id="b">
					<div class="panel panel-primary">
						<div class="panel-heading visa-panel">
							<h3 class="panel-title">Booking roster - <strong><?php echo $yearId; ?>_<?php echo $storeId; ?></strong><?php if ($book[0]["lockPax"] == 1) { ?><span class="rLocked">LOCKED</span><?php
										}
										else {
											?> <span id="lockDisp"></span><?php } ?>
								<a id="printVisaPax" data-book="<?php echo $storeId ?>" target="_blank" style="float:right; margin-left: 5px;" href="javascript:void(0)" data-href="<?php echo site_url() ?>/agents/pdfLockedVisas/<?php echo $storeId ?>" ><span class="glyphicon glyphicon-print"></span> Print VISA for locked pax</a>
								<?php
								if ($book[0]["lockPax"] != 1) {
									?>
									&nbsp;<a id="lockWholeRoster" data-centro="<?php echo $campusId; ?>" data-id="<?php echo $storeId; ?>"  data-year="<?php echo $yearId; ?>" style="float:right; margin-left: 5px;" href="javascript:void(0)" ><span class="glyphicon glyphicon-lock"></span> Lock whole roster</a>
									<?php
								}
								?>
							</h3>
						</div>			
						<div class="panel-body visa-panel-body">
							<div class="row-fluid">
								<div class="col-12">
									<table id="NA_Roster" class="table table-bordered table-condensed table-striped">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th>Name</th>
												<th></th>
												<th></th>
												<th class="text-center">Accomodation</th>
												<th>Group Leader</th>
												<th>Info</th>
												<th>Share room</th>
												<th class="text-center">Campus Dates</th>
												<th class="text-center">Arrival Flight Info</th>
												<th class="text-center">Departure Flight Info</th>
												<th class="text-center">Template</th>
												<th class="text-center"></th>
											</tr>
										</thead>
										<tbody>
											<?php
											$counter = 1;
											foreach ($detMyPax as $mypax) {
												?>
											<div style="display: none;" id="dialog_modal_<?php echo $mypax["id_prenotazione"] ?>" title="Roster detail - <?php echo htmlentities($mypax["nome"] . ' ' . $mypax['cognome']); ?>" class="windia"> 
												<p><strong>Name: </strong><?php echo $mypax["nome"] ?></p>
												<p><strong>Surname: </strong><?php echo $mypax['cognome']; ?></p>
												<p><strong>DOB: </strong><?php echo date("d/m/Y", strtotime($mypax["pax_dob"])); ?></p>
												<p><strong>DOC: </strong><?php echo $mypax["numero_documento"]; ?></p>
												<p><strong>Type of pax: </strong><?php echo $mypax["tipo_pax"]; ?></p>
												<p><strong>Sex: </strong><?php echo $mypax["sesso"]; ?></p>
												<p><strong>Accommodation type: </strong><?php echo ucfirst($mypax["accomodation"]); ?></p>
												<p><strong>Group leader: </strong><?php echo $mypax["gl_rif"]; ?></p>
												<p><strong>Info: </strong><?php echo $mypax["salute"]; ?></p>
												<p><strong>Share room: </strong><?php echo $mypax["share_room"]; ?></p>
												<p><strong>Campus Arrival Date: </strong><?php echo date("d/m/Y", strtotime($mypax["data_arrivo_campus"])); ?></p>
												<p><strong>Campus Departure Date: </strong><?php echo date("d/m/Y", strtotime($mypax["data_partenza_campus"])); ?></p>
												<p><strong>Arrival Flight number: </strong><?php echo $mypax["andata_volo"]; ?></p>
												<p><strong>Arrival Flight date and time: </strong><?php echo date("d/m/Y", strtotime($mypax["andata_data_arrivo"])) . ' ' . date("H:i", strtotime($mypax["andata_data_arrivo"])); ?></p>
												<p><strong>Arrival airport: </strong><?php echo $mypax["andata_apt_arrivo"]; ?></p>
												<p><strong>Departure airport for the arrival flight: </strong><?php echo $mypax["andata_apt_partenza"]; ?></p>
												<p><strong>Departure Flight number: </strong><?php echo $mypax["ritorno_volo"]; ?></p>
												<p><strong>Departure Flight date and time: </strong><?php echo date("d/m/Y", strtotime($mypax["ritorno_data_partenza"])) . ' ' . date("H:i", strtotime($mypax["ritorno_data_partenza"])); ?></span></p>
												<p><strong>Departure airport: </strong><?php echo $mypax["ritorno_apt_partenza"]; ?></p>
												<p><strong>Arrival airport for the departure flight: </strong><?php echo $mypax["ritorno_apt_arrivo"]; ?></p>
											</div>
											<tr>
												<td class="text-center"><?php echo $counter ?></td>
												<td class="infoPax"><span <?php if ($mypax["tipo_pax"] == "GL") { ?> class="tdGl infoName" <?php
											}
											else {
													?> class="infoName" <?php } ?>><?php echo $mypax["cognome"] ?> <?php echo $mypax["nome"] ?></span><br />DOB: <?php echo date("d/m/Y", strtotime($mypax["pax_dob"])) ?> - DOC#: <?php echo $mypax["numero_documento"] ?></td>
												<td class="text-center info35"><span class="infoSex infoTipoPax"><?php echo $mypax["tipo_pax"] ?></span></td>	
												<td class="text-center info20"><span class="infoSex"><?php echo $mypax["sesso"] ?></span></td>									
												<td class="text-center infoAcco"><?php echo $mypax["accomodation"] ?></td>	
												<td><?php echo $mypax["gl_rif"] ?></td>
												<td><?php
																												 if ($mypax["salute"]) {
																													 echo $mypax["salute"];
																												 }
												?></td>
												<td><?php echo $mypax["share_room"] ?></td>
												<td class="text-center"><?php echo date("d/m/Y", strtotime($mypax["data_arrivo_campus"])) ?><br /><?php echo date("d/m/Y", strtotime($mypax["data_partenza_campus"])) ?></td>
												<td class="text-center infoFlights">Flight <strong><?php echo $mypax["andata_volo"] ?></strong> - <?php echo date("d/m/Y", strtotime($mypax["andata_data_arrivo"])) ?><br /><?php echo date("H:i", strtotime($mypax["andata_data_arrivo"])) ?> at <strong><?php echo $mypax["andata_apt_arrivo"] ?></strong> from <?php echo $mypax["andata_apt_partenza"] ?></td>
												<td class="text-center infoFlights">Flight <strong><?php echo $mypax["ritorno_volo"] ?></strong> - <?php echo date("d/m/Y", strtotime($mypax["ritorno_data_partenza"])) ?><br /><?php echo date("H:i", strtotime($mypax["ritorno_data_partenza"])) ?> from <strong><?php echo $mypax["ritorno_apt_partenza"] ?></strong> at <?php echo $mypax["ritorno_apt_arrivo"] ?></td>	
												<td  class="text-center" id="td_<?php echo $mypax["id_prenotazione"]; ?>">
													<?php
													if (!empty($templates)) {
														if ($book[0]["lockPax"] == 1) {
															$marSus = 0;
															?>
															<?php
															if ($mypax["template"] != '') {
																?> 
																<input class="tempSel"  type="hidden" id="selTemp_<?php echo $mypax["id_prenotazione"] ?>" value="<?php echo $mypax["template"] ?>" /> 
															<?php } ?>
															<select  style="width: 77px"
															<?php
															if ($mypax["template"] != '') {
																if ($mypax["template"] == 'UKIR') {
																	$tempTitle = 'UK/Ireland';
																}
																if ($mypax["template"] == 'USA') {
																	$tempTitle = 'USA';
																}
																if ($mypax["template"] == 'MAL') {
																	$tempTitle = 'Malta';
																}
																if ($mypax["template"] == 'UKIRGLSTD') {
																	$tempTitle = 'UK/Ireland - GL Standard';
																}
																if ($mypax["template"] == 'UKIRSTDSTD') {
																	$tempTitle = 'UK/Ireland - STD Standard';
																}
																if ($mypax["template"] == 'UKIRSTDST') {
																	$tempTitle = 'UK/Ireland - STD Short Term';
																}
																?> disabled="disabled" title="<?php echo $tempTitle; ?>" 
																		 <?php
																	 }
																	 else {
																		 ?>  class="tempSel"  id="selTemp_<?php echo $mypax["id_prenotazione"] ?>" <?php } ?> >
																	 <?php
																	 if ($mypax["template"] == '') {
																		 $dspCnt = 1;
																		 foreach ($templates as $template) {
																			 $chk = 0;
																			 $tempTitle = '';
																			 if ($template['template'] == 'UKIR') {
																				 $tempTitle = 'UK/Ireland';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($template['template'] == 'USA') {
																				 $tempTitle = 'USA';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($template['template'] == 'MAL') {
																				 $tempTitle = 'Malta';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($template['template'] == 'UKIRGLSTD') {
																				 $tempTitle = 'UK/Ireland - GL Standard';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($template['template'] == 'UKIRSTDSTD') {
																				 $tempTitle = 'UK/Ireland - STD Standard';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($template['template'] == 'UKIRSTDST') {
																				 $tempTitle = 'UK/Ireland - STD Short Term';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($chk > 0) {
																				 $marSus += 1;
																				 if ($dspCnt == 1) {
																					 ?>
																				<option value="">Select</option>
																				<?php
																				$dspCnt += 1;
																			}
																			?>
																			<option value="<?php echo $template['template'] ?>"><?php echo $tempTitle ?></option>
																			<?php
																		}
																		$chk = 0;
																	}
																	if ($marSus == 0) {
																		?>
																		<option value="">NA</option>
																		<?php
																	}
																}
																else {
																	$tempTitle = '';
																	if ($mypax["template"] == 'UKIR') {
																		$tempTitle = 'UK/Ireland';
																	}
																	if ($mypax["template"] == 'USA') {
																		$tempTitle = 'USA';
																	}
																	if ($mypax["template"] == 'MAL') {
																		$tempTitle = 'Malta';
																	}
																	if ($mypax["template"] == 'UKIRGLSTD') {
																		$tempTitle = 'UK/Ireland - GL Standard';
																	}
																	if ($mypax["template"] == 'UKIRSTDSTD') {
																		$tempTitle = 'UK/Ireland - STD Standard';
																	}
																	if ($mypax["template"] == 'UKIRSTDST') {
																		$tempTitle = 'UK/Ireland - STD Short Term';
																	}
																	?>
																	<option selected="selected" value="<?php echo $mypax['template'] ?>"><?php echo $tempTitle ?></option>
																	<?php
																}
																?>
															</select>
															<span class="selTmplDemo" data-id="<?php echo $mypax['id_prenotazione'] ?>" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 15px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>
															<?php
														}
														elseif ($mypax["lockPax"] == 1) {
															$marSus = 0;
															?>
															<?php if ($mypax["template"] != '') {
																?> 
																<input class="tempSel" type="hidden" id="selTemp_<?php echo $mypax["id_prenotazione"] ?>" value="<?php echo $mypax["template"] ?>" /> 
															<?php } ?>
															<select  style="width: 77px" 
															<?php
															if ($mypax["template"] != '') {
																$tempTitle = '';
																if ($mypax["template"] == 'UKIR') {
																	$tempTitle = 'UK/Ireland';
																}
																if ($mypax["template"] == 'USA') {
																	$tempTitle = 'USA';
																}
																if ($mypax["template"] == 'MAL') {
																	$tempTitle = 'Malta';
																}
																if ($mypax["template"] == 'UKIRGLSTD') {
																	$tempTitle = 'UK/Ireland - GL Standard';
																}
																if ($mypax["template"] == 'UKIRSTDSTD') {
																	$tempTitle = 'UK/Ireland - STD Standard';
																}
																if ($mypax["template"] == 'UKIRSTDST') {
																	$tempTitle = 'UK/Ireland - STD Short Term';
																}
																?> disabled="disabled" title="<?php echo $tempTitle; ?>" 
																		 <?php
																	 }
																	 else {
																		 ?> id="selTemp_<?php echo $mypax["id_prenotazione"] ?>"  class="tempSel" <?php } ?> >
																	 <?php
																	 if ($mypax["template"] == '') {
																		 $dspCnt = 1;
																		 foreach ($templates as $template) {
																			 $chk = 0;
																			 $tempTitle = '';
																			 if ($template['template'] == 'UKIR') {
																				 $tempTitle = 'UK/Ireland';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($template['template'] == 'USA') {
																				 $tempTitle = 'USA';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($template['template'] == 'MAL') {
																				 $tempTitle = 'Malta';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($template['template'] == 'UKIRGLSTD') {
																				 $tempTitle = 'UK/Ireland - GL Standard';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($template['template'] == 'UKIRSTDSTD') {
																				 $tempTitle = 'UK/Ireland - STD Standard';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($template['template'] == 'UKIRSTDST') {
																				 $tempTitle = 'UK/Ireland - STD Short Term';
																				 if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
																					 $chk += 1;
																				 }
																			 }
																			 if ($chk > 0) {
																				 $marSus += 1;
																				 if ($dspCnt == 1) {
																					 ?>
																				<option value="">Select</option>
																				<?php
																				$dspCnt += 1;
																			}
																			?>
																			<option value="<?php echo $template['template'] ?>"><?php echo $tempTitle ?></option>
																			<?php
																		}
																	}
																	if ($marSus == 0) {
																		?>
																		<option value="">NA</option>
																		<?php
																	}
																}
																else {
																	$tempTitle = '';
																	if ($mypax["template"] == 'UKIR') {
																		$tempTitle = 'UK/Ireland';
																	}
																	if ($mypax["template"] == 'USA') {
																		$tempTitle = 'USA';
																	}
																	if ($mypax["template"] == 'MAL') {
																		$tempTitle = 'Malta';
																	}
																	if ($mypax["template"] == 'UKIRGLSTD') {
																		$tempTitle = 'UK/Ireland - GL Standard';
																	}
																	if ($mypax["template"] == 'UKIRSTDSTD') {
																		$tempTitle = 'UK/Ireland - STD Standard';
																	}
																	if ($mypax["template"] == 'UKIRSTDST') {
																		$tempTitle = 'UK/Ireland - STD Short Term';
																	}
																	?>
																	<option selected="selected" value="<?php echo $mypax['template'] ?>"><?php echo $tempTitle ?></option>
																	<?php
																}
																?>
															</select>
															<span class="selTmplDemo" data-id="<?php echo $mypax['id_prenotazione'] ?>" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 15px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>
															<?php
														}
													}
													else {
														if ($book[0]["lockPax"] == 1) {
															?>
															<select style="width: 77px"><option value="">NA</option></select>
															<?php
														}
														elseif ($mypax["lockPax"] == 1) {
															?>
															<select style="width: 77px"><option value="">NA</option></select>
															<?php
														}
													}
													?>
												</td>
												<th class="text-center">
													<?php
													if ($book[0]["lockPax"] == 1) {
														?>
														<span class="glyphicon glyphicon-lock locked error" title="Roster Locked."></span>
														<?php
														if (!empty($templates)) {
															?>
															<a id="prntVisa_<?php echo $mypax["id_prenotazione"]; ?>" href="javascript:void(0)" data-href="<?php echo site_url() ?>/agents/pdfSingleVisa/<?php echo $mypax["id_prenotazione"]; ?>/<?php echo $storeId ?>" title="Print VISA" target="_blank" class="prinOpen"><span class="glyphicon glyphicon-print"></span></a>
															<?php
														}
													}
													elseif ($mypax["lockPax"] == 1) {
														?>
														<span class="glyphicon glyphicon-lock locked error" title="Roster Locked."></span>
														<?php
														if (!empty($templates)) {
															?>
															<a id="prntVisa_<?php echo $mypax["id_prenotazione"]; ?>"  href="javascript:void(0)" data-href="<?php echo site_url() ?>/agents/pdfSingleVisa/<?php echo $mypax["id_prenotazione"]; ?>/<?php echo $storeId ?>" title="Print VISA" target="_blank"  class="prinOpen"><span class="glyphicon glyphicon-print"></span></a>
															<?php
														}
													}
													else {
														?>
														<a href="javascript:void(0);" class="lockRoster" data-centro="<?php echo $campusId ?>" id="paxLoc_<?php echo $mypax["id_prenotazione"] ?>" title="Lock Roster"><span class="glyphicon glyphicon-lock"></span></a>
														<?php
													}
													?>

													<a href="javascript:void(0);" class="paxOpenClass" id="paxOpn_<?php echo $mypax["id_prenotazione"] ?>"><span class="glyphicon glyphicon-eye-open dialogbtn" title="View Detais" data-id="dialog_modal_btn_<?php echo $mypax["id_prenotazione"]; ?>"></span></a>
												</th>
											</tr>
											<?php
											$counter++;
										}
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>

		<div id="updatingAll"><img src="<?php echo base_url() ?>img/uploadingData.gif" title="Uploading data..." alt="Uploading data..."></div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript">
			var baseUrl = "<?php echo base_url(); ?>";
			var siteUrl = "<?php echo site_url(); ?>/";
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url() ?>js/bootstrap-timepicker.min.js"></script>
		<script type="text/javascript">
			var baseUrl = "<?php echo base_url(); ?>";
			var siteUrl = "<?php echo site_url(); ?>/";
		</script>
		<script>
			/*$( ".windiaTemp" ).dialog({
				autoOpen: false,
				modal: true,
				minHeight: 50,
				maxHeight: 500,
				buttons: [{
						text: "Close",
						click: function() { $(this).dialog("close"); }
					}]
			});*/
	
			$(document).on('click', '.lockRoster', function(e){
				e.preventDefault();
				var c = confirm('Are you sure to lock roster?');
				if(c){
					var elm = $(this);
					var parent = elm.parent();
					var rowId = elm.attr('id').replace('paxLoc_', '');
					var centroId = elm.attr('data-centro');
					$.ajax({
						url: siteUrl + 'agents/lockSingleRoster',
						type: 'POST',
						dataType: 'json',
						data: {
							rowId: rowId,
							centroId: centroId
						},
						success: function(data){
							if(data.status == 1){
								elm.remove();
								$('#td_'+rowId).html(data.result+'<span class="selTmplDemo" data-id="'+rowId+'" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 15px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>');
								parent.prepend('<span class="glyphicon glyphicon-lock locked" style="color: #FF0000" title="Roster Locked."></span>&nbsp<a id="prntVisa_'+rowId+'" href="javascript:void(0)" data-href="'+siteUrl+'agents/pdfSingleVisa/'+rowId+'/<?php echo $storeId ?>" title="Print VISA"  class="prinOpen"><span class="glyphicon glyphicon-print"></span></a>');
								alert('Roster locked successfully');
							}
							else if(data.status == 3){
								elm.remove();
								$('#td_'+rowId).html(data.result+'<span class="selTmplDemo" data-id="'+rowId+'" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 15px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>');
								parent.prepend('<span class="glyphicon glyphicon-lock locked" style="color: #FF0000" title="Roster Locked."></span>');
								alert('Roster locked successfully');
							}
							else if(data.status == 2){
								alert('Roster details are not complete. Failed to lock');
							}
							else{
								alert('Failed to lock Roster');
							}
						},
						error: function(){
							alert('Failed to lock Roster');
						}
					});
				}
		
			});
			$(document).on('click', '#lockWholeRoster', function(e){
				e.preventDefault();
				var c = confirm('Are you sure to lock whole roster?');
				if(c){
					var elm = $(this);
					var bookId = elm.attr('data-id');
					var yearId = elm.attr('data-year');
					var centroId = elm.attr('data-centro');
					$.ajax({
						url: siteUrl + 'agents/lockWholeRoster',
						type: 'POST',
						dataType: 'json',
						data: {
							bookId: bookId,
							yearId: yearId,
							centroId: centroId
						},
						success: function(data){
							if(data.status == 2){
								alert('There are incomplete rosters. Please fill all the details and retry.');
							}
							else if(data.status == 1){
								var winParent = window.parent.$('#compile_'+yearId+'_'+bookId).parent();
								window.parent.$('#compile_'+yearId+'_'+bookId).remove();
								winParent.append('<img src="'+baseUrl+'img/icons/packs/fugue/16x16/tick-button.png" class="icon">');
								window.location.href=siteUrl + 'agents/getVisaPopupDetails/<?php echo $storeId; ?>/b';
								return false;
								/*$('#lockWholeRoster').remove();
								
								$.each(data.result, function(i, item) {
									var html ='';
									if(item !== ''){
										var noTmpl = 0;
										var elm = $('#paxLoc_'+item);
										var parent = elm.parent();
										elm.remove();
										if(data.templ.length > 0){
											html += '<select class="tempSel" id="selTemp_'+item+'" ><option value="">Select</option>';
											$.each(data.templ, function(i1, templt){
												var tempTitle = '';
												if (templt['template'] == 'UKIR') {
													tempTitle = 'UK/Ireland';
												}
												if (templt['template'] == 'USA') {
													tempTitle = 'USA';
												}
												if (templt['template'] == 'MAL') {
													tempTitle = 'Malta';
												}
												html += '<option value="'+templt['template']+'">'+tempTitle+'</option>';
											});
											html += '</select><span class="selTmplDemo" data-id="'+rowId+'" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 15px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>';
										}
										else{
											html = '<select><option value="">NA</option></select>';
											noTmpl = 1;
										}
										var tmplHtml = '';
										if(noTmpl == 0){
											tmplHtml = '<a id="prntVisa_'+item+'" href="javascript:void(0)" data-href="'+siteUrl+'agents/pdfSingleVisa/'+item+'/<?php echo $storeId ?>" title="Print VISA"  class="prinOpen"><span class="glyphicon glyphicon-print"></span></a>';
										}
										parent.prepend('<span class="glyphicon glyphicon-lock locked" style="color: #FF0000" title="Roster Locked."></span>&nbsp'+tmplHtml);
										
										
										$('#td_'+item).html(html);
									}
								});
								
								$('#lockDisp').html('<span class="rLocked">LOCKED</span>');
								
								alert('Successfully locked whole rosters. You can now download VISA for entire pax');*/
							}
							else{
								alert('Failed to lock Whole Roster');
							}
						},
						error: function(){
							alert('Failed to lock Whole Roster');
						}
					});
				}
		
			});
			$(document).on('click', ".dialogbtn", function() {
				var iddia = $(this).attr("data-id").replace('_btn','');
				//alert(iddia.replace('_btn',''));
				$( "#"+iddia ).dialog("open");
				return false;
			});
			$( ".windia" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
						text: "Close",
						click: function() { $(this).dialog("close"); }
					}]
			});
			$('#backToList').click(function(){
				parent.history.back();
				return false;
			});
			$(document).on('change', '.tempSel', function(){
				var templ = $(this).val();
				var rowId = $(this).attr('id').replace('selTemp_', '');
				if(templ != '' && typeof templ != 'undefined'){
					$('.selTmplDemo[data-id='+rowId+']').css('display','inline-block');
				}
				else{
					$('.selTmplDemo[data-id='+rowId+']').css('display','none');
				}
			});
			function validateEmpty(rowId){
				var selValue = $('#selTemp_'+rowId).val();
				if(selValue == '' || typeof selValue == 'undefined'){
					alert('Please select template');
					return false;
				}
			}
			$(document).on('click', '.prinOpen', function(e){
				e.preventDefault();
				var elm = $(this);
				var rowId = $(this).attr('id').replace('prntVisa_','');
				var selValue = $('#selTemp_'+rowId).val();
				var c = true;
				if(selValue == '' || typeof selValue == 'undefined'){
					alert('Please select template');
					return false;
				}
				else{
					if(!$('#selTemp_'+rowId).is('input[type=hidden]')){
						c = confirm('Are you sure to print VISA? The template once selected can not change again.');
					}
					if(c){
						$.ajax({
							url: siteUrl+'agents/lockTemplate',
							type: 'POST',
							async: false,
							data: {
								rowId: rowId,
								selValue: selValue
							},
							success: function(data){
								if(data == 1){
									var elm1 = $('#selTemp_'+rowId);
									/*if($('#selTemp_'+rowId).parent().find('input[id=selTemp_'+rowId+']').length == 0){
										elm1.attr('disabled', 'disabled');
										elm1.removeClass('tempSel');
										elm1.removeAttr('id');
										elm1.parent().prepend('<input type="hidden" class="tempSel" id="selTemp_'+rowId+'" value="'+selValue+'" />');
									}*/
									setTimeout(function(){
										window.location.href=siteUrl + 'agents/getVisaPopupDetails/<?php echo $storeId; ?>/b';
									}, 1000);
									window.open(elm.attr('data-href')+'/'+selValue);
									return false;
								}
								else if(data == 2){
									alert('Nationality not found/Invalid nationality');
								}
								else{
									alert('Error occured. Could not print visa');
								}
							},
							error: function(){
								alert('Error occured. Could not print visa');
							}
						});
					}
						
				}
				
			});
			$('#printVisaPax').on('click', function(e){
				e.preventDefault();
				var elm = $(this);
				var bookId = elm.attr('data-book');
				if(bookId !== '' && typeof bookId != 'undefined'){
					$.ajax({
						url: siteUrl + 'agents/checkAnyPaxLocked',
						type: 'POST',
						data: {
							bookId: bookId
						},
						success: function(data){
							if(data == 1){
								var SelTmplCount = 0;
								var rowIds = '';
								var selCount = 0;
								var c = true;
								var totSelTmplCount = $('.tempSel').length;
								$('.tempSel').each(function(){
									if($(this).val() != '' && typeof $(this).val() != 'undefined'){
										if(!$(this).is('input[type=hidden]')){
											selCount += 1;
										}
										if(SelTmplCount == 0){
											rowIds += $(this).attr('id').replace('selTemp_', '')+'-'+$(this).val();
										}
										else{
											rowIds += '/'+$(this).attr('id').replace('selTemp_', '')+'-'+$(this).val();
										}
										SelTmplCount += 1;
									}
								});
								if(totSelTmplCount == 0 && SelTmplCount == 0){
									alert('No mapped templates found. Map some templates and try again!');
									return false;
								}
								if(totSelTmplCount != SelTmplCount){
									var rowIdsNoSel = '';
									var noSelTmplCount = 0;
									$('.tempSel').each(function(){
										if($(this).val() == '' || typeof $(this).val() == 'undefined'){
											if(noSelTmplCount == 0){
												rowIdsNoSel += $(this).attr('id').replace('selTemp_', '');
											}
											else{
												rowIdsNoSel += '/'+$(this).attr('id').replace('selTemp_', '');
											}
											noSelTmplCount += 1;
										}
									});
									$.ajax({
										url: siteUrl + 'agents/checkMappedTemplate',
										type: 'POST',
										async: false,
										data: {
											bookId: bookId,
											rowIds: rowIds
										},
										success: function(data){
											if(data == 1){
												var diaH = $(window).height()* 0.9;
												e.preventDefault();
												$('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(' + baseUrl + '/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
												.html($('<iframe/>', {
													'src' : siteUrl + "agents/visaLockedTemplate/"+bookId+"/"+rowIdsNoSel,
													'style' :'width:100%; height:100%;border:none;'
												})).appendTo('body')
												.dialog({
													'title' : '',
													'width' : '100%',
													'height' : diaH,
													modal: true,
													buttons: [ {
															text: "Close",
															click: function() { $( this ).dialog( "close" ); }
														} ]
												});
												//$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
												//$("#dialog_modal").load('<?php echo base_url(); ?>index.php/agents/visaLockedTemplate');
												//return false;
											}
											else if(data == 2){
												alert('Some/All pax\'s nationalities missing or invalid');
											}
											else{
												alert('No mapped templates found. Map some templates and try again!');
											}
										},
										error: function(){
											alert('Error occured. Could not continue VISA printing!');
										}
									});
								}
								else{
									if(selCount > 0){
										c = confirm('Are you sure to print VISA? The template once selected can not change again.');
									}
									if(c){
										$.ajax({
											url: siteUrl + 'agents/checkMappedTemplate',
											type: 'POST',
											async: false,
											data: {
												bookId: bookId,
												rowIds: rowIds
											},
											success: function(data){
												if(data == 1){
													$.ajax({
														url: siteUrl+'agents/checkBookLocked',
														type: 'POST',
														data: {
															bookId: bookId
														},
														success: function(data){
															if(data == 1){
																var diaH = $(window).height()* 0.9;
																$('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(' + baseUrl + '/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
																.html($('<iframe/>', {
																	'src' : siteUrl + "agents/visaLockedTemplate/"+bookId,
																	'style' :'width:100%; height:100%;border:none;'
																})).appendTo('body')
																.dialog({
																	'title' : '',
																	'width' : '100%',
																	'height' : diaH,
																	modal: true,
																	buttons: [ {
																			text: "Close",
																			click: function() { $( this ).dialog( "close" ); }
																		} ]
																});
															}
															else if(data == 2){
																setTimeout(function(){
																	window.location.href=siteUrl+"agents/getVisaPopupDetails/"+bookId+"/b";
																}, 1000);

																window.open(siteUrl + "agents/pdfLockedVisas/"+bookId+"/"+rowIds);
																return false;
															}
															else{
																alert('Error occured. Could not continue VISA printing!');
															}
														},
														error: function(){
															alert('Error occured. Could not continue VISA printing!');
														}
													});
												}
												else if(data == 2){
													alert('Some/All pax\'s nationalities missing or invalid');
												}
												else{
													alert('No mapped templates found. Map some templates and try again!');
												}
											},
											error: function(){
												alert('Error occured. Could not continue VISA printing!');
											}

										});
									}
										
									
								
									
									/*window.open(siteUrl + "agents/pdfLockedVisas/"+bookId+"/"+rowIds);
									return false;*/
								}
								/*$.ajax({
									url: siteUrl + 'agents/checkMappedTemplate',
									type: 'POST',
									data: {
										bookId: bookId
									},
									success: function(data){
										if(data == 1){
											var diaH = $(window).height()* 0.9;
											e.preventDefault();
											$('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(' + baseUrl + '/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
												.html($('<iframe/>', {
													'src' : siteUrl + "agents/visaLockedTemplate/"+bookId,
													'style' :'width:100%; height:100%;border:none;'
												})).appendTo('body')
												.dialog({
													'title' : 'Select Template',
													'width' : '100%',
													'height' : diaH,
													modal: true,
													buttons: [ {
														text: "Close",
														click: function() { $( this ).dialog( "close" ); }
													} ]
												});
											//$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
											//$("#dialog_modal").load('<?php echo base_url(); ?>index.php/agents/visaLockedTemplate');
											//return false;
										}
										else{
											alert('No mapped templates found. Map some templates and try again!');
										}
									},
									error: function(){
										alert('Error occured. Could not continue VISA printing!');
									}
								});*/
							}
							else{
								alert('No locked VISA found. Lock some  VISA and try again');
							}
						},
						error: function(){
							alert('Error occured. Could not continue VISA printing!');
						}
					});
				}
			});
			$(function(){
				$(".tab-pane").removeClass("active");
				$(".nav-pills > li").removeClass("active");
				$("#<?php echo $pill; ?>").addClass("active");
				$("#pill_<?php echo $pill; ?>").addClass("active");
			});
			$(document).on('click','.selTmplDemo', function(){
				var id = $(this).attr('data-id');
				var templ = $('#selTemp_'+id).val();
				if(templ != '' && typeof templ != 'undefined'){
					window.open(siteUrl+'agents/visaPDFDemo/'+templ);
				}
			});
		</script>
	</body>
</html>