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
    <link rel="stylesheet" href="<?php echo base_url()?>css/NA_style.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>css/fonts/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url()?>css/bootstrap-timepicker.min.css" />
	<link rel="stylesheet" href="<?php echo base_url()?>css/excursion.css" />

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
	
</style>
<style type="text/css">
			.ui-dialog .ui-dialog-titlebar-close{
				position: relative !important;
				right: -2.7em !important;
			}
			.ui-dialog .ui-dialog-titlebar-close::before{
				content: 'x' !important;
				display: block !important;
				text-indent: 0 !important;
				margin-top: -4px !important;
			}
		</style>
</head>
<body style="background-color:transparent;" id="newAva2015">
<div class="container-fluid">
    <ul class="nav nav-pills" role="tablist">
        <li id="pill_a" role="presentation" class="active"><a href="#a" data-toggle="pill"><span class="glyphicon glyphicon-search"></span> Booking details</a></li>
        <li id="pill_b" role="presentation"><a href="#b" data-toggle="pill"><span class="glyphicon glyphicon-user"></span> Roster</a></li>
        <li id="pill_c" role="presentation"><a href="#c" data-toggle="pill"><span class="glyphicon glyphicon-random"></span> Transfer and excursions</a></li>
        <li id="pill_d" role="presentation"><a href="#d" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span> Calendar view</a></li>
        <li id="pill_e" role="presentation"><a href="#e" data-toggle="pill"><span class="glyphicon glyphicon-inbox"></span> Documents</a></li>
		<li id="pill_f" role="presentation"><a href="#f" data-toggle="pill"><span class="glyphicon glyphicon-credit-card"></span> Payments</a></li>
		<?php 
			if(isset($_SERVER["HTTP_REFERER"])){
				if(!strpos($_SERVER["HTTP_REFERER"],"dashboard")){ ?>
		<li role="presentation" class="pull-right"><a id="backToList" data-toggle="pill"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></li>
		<?php 
				}
			} ?>
    </ul>
	<?php
		$isFlocked = 0;
		$da=explode("-",$book[0]["arrival_date"]);
		$dd=explode("-",$book[0]["departure_date"]);
		$maxNoLmDate = date("d/m/Y",strtotime($book[0]["arrival_date"]) - (24*3600*30));
		$maxLmDate = date("d/m/Y",strtotime($book[0]["arrival_date"]) - (24*3600*1));
		//echo $maxNoLmDate;
		$storeId = $book[0]["id_book"];
		$yearId = $book[0]["id_year"];
		$accos=$book[0]["all_acco"];
		$now = time();
		$your_date = strtotime($book[0]["arrival_date"]);
		$dayToArrive = round(($now - $your_date)/86400*-1);
		$valutaCampo = $book[0]["valuta"];
		$valoreAcconto = $book[0]["tot_pax"]*1 * $book[0]["valore_acconto"]*1;
	?>
    <div class="tab-content" style="margin-top:10px;">
        <div class="tab-pane fade in active" id="a">
            <div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Booking details - <strong><?php echo $yearId;?>_<?php echo $storeId;?></strong></h3>
				</div>
                <div class="panel-body">
					<div class="row">
						<div class="col-md-3">
							<address>
							  <strong><?php echo $book[0]["id_year"] ?>_<?php echo $book[0]["id_book"] ?><?php if($book[0]["id_ref_overnight"]){ ?> - <span style="color:#f00;">OVERNIGHT (<?php echo $book[0]["id_ref_overnight"] ?>)</span><?php } ?></strong><br>
							  <?php echo $book[0]["centro"] ?> - [<?php echo $dayToArrive ?> days to arrival]<br>
							  <strong>Date in: </strong><span id="ok_A_Date"><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?></span><br>
							  <strong>Date out: </strong><?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?><br>
							  <abbr title="Phone">P:</abbr> <?php echo $agente[0]["businesstelephone"] ?>
							</address>
						</div>					
						<div class="col-md-3">
							<address>
							  <strong><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $agente[0]["businesscountry"]?>.png" alt="<?php echo $agente[0]["businesscountry"]?>" title="<?php echo $agente[0]["businesscountry"]?>" /><?php echo $agente[0]["businessname"] ?></strong><br>
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
						<div class="col-md-3">
							<address>
							  <strong>Rosters and Visas</strong><ul class="listaInBk">
							  <?php 
								if($hasRoster > 0){
									if($book[0]["lockPax"] == 1){
										$isFlocked = 1;
										 echo "<li>Roster Locked - <a href='javascript:void(0);' class='unlockBookingRoster'>Click here</a> to unlock roster for this booking</li>";
									}else{
										echo "<li>Roster in progress</li>";
									}
								}else{
										echo "<li>No roster available</li>";
								}

								//if($book[0]["lockPax"] == 1){
									if($book[0]["downloadVisa"] == 1){
										echo "<li>Visa available and printable by the agent";
									}else{
										echo "<li>Visa available and not printable by the agent";
									}
									?>
									 - <a id="printVisaPax" data-book="<?php echo $storeId ?>" target="_blank" href="javascript:void(0)" data-href="<?php echo site_url()?>/backoffice/pdf_visas/<?php echo $storeId ?>">Click here</a> to print Visas for this booking</li>
									<?
								//}else{
								//	echo "<li>Visas not available. Need locked roster</li>";
								//}
								?>
								</ul>
							</address>
						</div>
                        <?php if($book[0]["id_agente"]==795){ ?>
                        <div class="col-md-12" id="overnightBox">
                            <hr />
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="text-info">Study Tours overnight settings</label>
                                    <select class="form-control" id="periodOvernight" name="periodOvernight">
                                        <option value="">Select overnight period</option>
                                        <option value="start">Before campus</option>
                                        <option value="end">After campus</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-info">&nbsp;</label>
                                    <select class="form-control" id="durationOvernight" name="durationOvernight">
                                        <option value="">Select overnight duration</option>
                                        <option value="1">One night overnight</option>
                                        <option value="2">Two nights overnight</option>
                                        <option value="3">Three nights overnight</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-info">&nbsp;</label>
                                    <select class="form-control" id="campusOvernight" name="campusOvernight">
                                        <option value="">Select overnight campus</option>
                                        <?php foreach($centri as $c){ ?>
                                        <option value="<?php echo $c["id"]; ?>"><?php echo $c["nome_centri"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3 text-right">
                                    <button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_setOvernight" >Set overnight</button>
                                </div>
                            </div>
                            <hr />
                        </div>
                        <?php } ?>
						<div class="col-md-12">
							<div class="row">
								<?php if($book[0]["status"]=="tbc"){ ?>
								<div class="col-md-4">
									<label class="text-info">To be confirmed</label>
									<select class="form-control" id="statusBooking">
										<option value="B_activate">Activate booking</option>
										<option value="B_reject">Reject booking</option>
									</select>
								</div>	
								<div class="col-md-2">
									<label for="lm_flag">Last minute</label><br />
									<input type="checkbox" id="lm_flag" style="height:25px;" value="1" />
								</div>	
								<div class="col-md-3">
									<label for="B_active">Activate until</label><br />
									<input class="form-control" type="text" id="B_active" class="datepicker" />
								</div>		
								<div class="col-md-3 text-right">
									<button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_cambiaStato" >Change status</button>
								</div>									
								<?php } ?>
								<?php if($book[0]["status"]=="rejected"){ ?>
								<div class="col-md-12">
									<label style="color:#c00;">Rejected</label>
								</div>	
								<?php } ?>								
								<?php if($book[0]["status"]=="active"){ ?>
									<div class="col-md-4">
										<label style="color:#fc0;">Active</label>
										<p>until <?php echo date("d/m/Y",strtotime($book[0]["data_scadenza"])); ?></p>
										<select class="form-control" id="statusBookingFinCon">
										<?php if($this->session->userdata('ruolo')=="contabile" ){ ?>
											<option value="B_confirm">Confirm booking</option>
										<?php } ?>	
											<option value="B_reject">Reject booking</option>
										</select>
									</div>	
									<div class="col-md-2 text-center">
										<button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_confermaBooking" >Change status</button>
									</div>
								<?php } ?>
								<?php if($book[0]["status"]=="elapsed"){ ?>
									<?php if($this->session->userdata('ruolo')=="contabile" ){ ?>
										<?php if($book[0]["flag_paid"]==0){ ?>
											<div class="col-md-6">
												<label class="text-danger">Elapsed</label><br />
												<?php if($book[0]["flag_checkpay"]==1){ ?>
													A check payment notification is pending for this booking!
												<?php } ?><br />
												<select class="form-control" id="statusPaymentFinCon">
													<option value="B_paid">Booking paid</option>
												</select>
											</div>	
											<div class="col-md-2 text-center">
												<br /><button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_notificaPayment" >Notify payment to backoffice</button>
											</div>
										<?php } else { ?>
											<div class="col-md-10">
												<label class="text-danger">Elapsed</label>
													<br />A payment for this booking has already been notified to backoffice!
											</div>										
										<?php }?>
									<?php }else{ ?>
										<?php if($book[0]["flag_paid"]==1){ ?>
										<div class="col-md-4">
											<label class="text-danger">Elapsed</label><br />A payment for this booking has been registered!
											<select class="form-control" id="statusBooking">
												<option value="B_confirm">Confirm booking</option>
											</select>
										</div>		
										<div class="col-md-3 text-right">
											<br /><button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_cambiaStato" >Change status</button>
										</div>	
										<?php }else{ ?>
											<?php if($book[0]["flag_checkpay"]==0){ ?>
												<div class="col-md-4">
													<label class="text-danger">Elapsed</label>
													<select class="form-control" id="statusBooking">
														<option value="B_activate">Activate booking</option>
													</select>
												</div>	
												<div class="col-md-2">
													<label for="lm_flag">Last minute</label><br />
													<input type="checkbox" id="lm_flag" style="height:25px;" value="1" />
												</div>	
												<div class="col-md-3">
													<label for="B_active">Activate until</label><br />
													<input class="form-control" type="text" id="B_active" class="datepicker" />
												</div>		
												<div class="col-md-3 text-right">
													<button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_cambiaStato" >Change status</button>
												</div>		
												<div class="col-md-12">
													<hr />
													<p>If the agent assures you that the deposit has been already paid, click the button below to notify this to the accounting!</p>
													<button type="button" class="btn btn-primary" id="B_checkPayment" >Notify check payment to accounting</button>
												</div>
											<?php } else { ?>
												<div class="col-md-10">
													<label class="text-danger">Elapsed</label>
														<br />A check payment for this booking has already been notified to accounting!<br />Please wait for the accounting to confirm the payment.
												</div>												
											<?php } ?>
										<?php } ?>
									<?php } ?>									
								<?php } ?>	
								<?php if($book[0]["status"]=="confirmed"){ ?>
									<?php if($this->session->userdata('ruolo')=="contabile" ){ ?>
										<?php if($book[0]["flag_cfd"]==0){ ?>
											<div class="col-md-6">
												<label class="text-success">Confirmed</label><br />
												<select class="form-control" id="statusClearedFinCon">
													<option value="B_cleared">Booking cleared for departure</option>
												</select>
											</div>	
											<div class="col-md-2 text-center">
												<button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_notificaCleared" >Clear booking</button>
											</div>
										<?php } else { ?>
											<div class="col-md-10">
												<label class="text-success">Confirmed and Cleared for Departure</label>
													<br />This booking has been cleared for departure!
											</div>										
										<?php }?>
									<?php }else{ ?>
											<div class="col-md-6">
												<label class="text-success">Confirmed<?php if($book[0]["flag_cfd"]==1){ ?> and Cleared for Departure<?php } ?></label>
												<select class="form-control" id="statusBooking">
													<option value="B_reject">Reject booking</option>
												</select>
											</div>		
											<div class="col-md-3 text-right">
												<button type="button" style="margin-top:25px;" class="btn btn-primary" id="B_cambiaStato" >Change status</button>
											</div>	
									<?php } ?>
								<?php } ?>									
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="b">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Booking roster - <strong><?php echo $yearId;?>_<?php echo $storeId;?></strong><?php if($isFlocked == 1){ ?><span class="rLocked">LOCKED</span><?php } ?>
						<a id="exportRosterPax" style="float:right; margin-left: 5px;" href="<?php echo site_url() ?>/backoffice/exportRoster/<?php echo $storeId; ?>" ><span class="glyphicon glyphicon-download-alt"></span> Export</a>
						
						<a id="addRosterPax" style="float:right;" href="javascript:void(0);" ><span class="glyphicon glyphicon-plus"></span> Add new pax to this booking</a>
						
						<?php if($isFlocked == 1){ ?>
						<a id="addRosterPax" style="float:right;margin-right:20px;" href="javascript:void(0);" class="unlockBookingRoster"><span class="glyphicon glyphicon-lock"></span> Unlock roster</a>
						<?php } ?>
					</h3>
				</div>			
                <div class="panel-body">
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
									<th class="text-center"></th>
								</tr>
								</thead>
								<tbody>
							<?php
								$counter = 1;
								foreach($detMyPax as $mypax){
							?>
	<tr>
		<td class="text-center"><?php echo $counter ?></td>
		<td class="infoPax"><span <?php if($mypax["tipo_pax"]=="GL"){?> class="tdGl infoName" <?php }else{ ?> class="infoName" <?php } ?>><?php echo $mypax["cognome"] ?> <?php echo $mypax["nome"] ?></span><?php echo ($mypax["lockPax"] == 1 OR $isFlocked == 1) ? '&nbsp<span title="Roster locked" class="locked glyphicon glyphicon-lock" style="font-size:9px; cursor: default !important;"></span>' : '' ?><br />DOB: <?php echo date("d/m/Y", strtotime($mypax["pax_dob"])) ?> - DOC#: <?php echo $mypax["numero_documento"] ?></td>
		<td class="text-center info35"><span class="infoSex infoTipoPax"><?php echo $mypax["tipo_pax"] ?></span></td>	
		<td class="text-center info20"><span class="infoSex"><?php echo $mypax["sesso"] ?></span></td>									
		<td class="text-center infoAcco"><?php echo $mypax["accomodation"] ?></td>	
		<td><?php echo $mypax["gl_rif"] ?></td>
		<td><?php if($mypax["salute"]){ echo $mypax["salute"]; } ?></td>
		<td><?php echo $mypax["share_room"] ?></td>
		<td class="text-center"><?php echo date("d/m/Y",strtotime($mypax["data_arrivo_campus"])) ?><br /><?php echo date("d/m/Y",strtotime($mypax["data_partenza_campus"])) ?></td>
		<td class="text-center infoFlights">Flight <strong><?php echo $mypax["andata_volo"] ?></strong> - <?php echo date("d/m/Y", strtotime($mypax["andata_data_arrivo"])) ?><br /><?php echo date("H:i", strtotime($mypax["andata_data_arrivo"])) ?> at <strong><?php echo $mypax["andata_apt_arrivo"] ?></strong> from <?php echo $mypax["andata_apt_partenza"] ?></td>
		<td class="text-center infoFlights">Flight <strong><?php echo $mypax["ritorno_volo"] ?></strong> - <?php echo date("d/m/Y", strtotime($mypax["ritorno_data_partenza"])) ?><br /><?php echo date("H:i", strtotime($mypax["ritorno_data_partenza"])) ?> from <strong><?php echo $mypax["ritorno_apt_partenza"] ?></strong> at <?php echo $mypax["ritorno_apt_arrivo"] ?></td>		
		<th class="text-center">
			<?php echo ($mypax["lockPax"] == 1 && $isFlocked != 1) ? '<a href="javascript:void(0);" class="paxUnlClass" id="paxUnl_'.$mypax["id_prenotazione"].'"><span title="Unlock Roster" class="icon-unlock" style="font-size: 19px;text-decoration: none !important"></span></a>' : '' ?>
			<a href="javascript:void(0);" class="paxModClass" id="paxMod_<?php echo $mypax["id_prenotazione"] ?>"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="javascript:void(0);" class="paxRemClass" id="paxRem_<?php echo $mypax["id_prenotazione"] ?>"><span class="glyphicon glyphicon-remove"></span></a>
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
        <div class="tab-pane fade in" id="c">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Transfers and excursions - <strong><?php echo $yearId;?>_<?php echo $storeId;?></strong></h3>
				</div>
                <div class="panel-body">
				</div>
			</div>
        </div>
        <div class="tab-pane fade in" id="d">
            <div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Calendar view - <strong><?php echo $yearId;?>_<?php echo $storeId;?></strong></h3>
				</div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-12">
                            <table id="NA_Calendar" class="table table-bordered table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th>Accomodation</th>
                                        <th>Campus date IN</th>
                                        <th>Campus date OUT</th>
                                        <th>GL</th>
                                        <th>STD</th>
                                        <?php /*<th class="text-center">Actions</th>*/ ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($all_acco as $accom){
                                        $contoGL = $accom->contoGL;
                                        $contoSTD = $accom->contoSTD
                                        ?>
                                        <tr>
                                            <td><?php echo ucfirst($accom->accomodation); ?></td>
                                            <td><?php echo date("d/m/Y",strtotime($accom->data_arrivo_campus)); ?></td>
                                            <td><?php echo date("d/m/Y",strtotime($accom->data_partenza_campus)); ?></td>
                                            <td><span class="contaTP"><?php if($contoGL > 0){ echo $contoGL ?></span><span class="glyphicon glyphicon-user"></span><?php } else { ?>-<?php } ?></td>
                                            <td><span class="contaTP"><?php if($contoSTD > 0){ echo $contoSTD ?></span><span class="glyphicon glyphicon-user"></span><?php } else { ?>-<?php } ?></td>
                                            <?php /*<td class="text-center">
                                                <a href="#" title="View detail"><span class="glyphicon glyphicon-search"></span></a>
                                                <a href="#"><span class="glyphicon glyphicon-calendar"></span><a>
                                            </td> */ ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-12">
                            <?php /*
                            <table class="table table-bordered table-condensed table-striped" style="font-size:9px;">
                                <thead>
                                <tr>
                                    <th>Agency</th>
                                    <?php
                                    $saved_datein = $datein;
                                    while (strtotime($datein) <= strtotime($dateout)) {
                                        ?>
                                        <th><?php echo date("d/m",strtotime($datein)) ?></th>
                                        <?php
                                        $datein = date ("Y-m-d", strtotime("+1 day", strtotime($datein)));
                                    }
                                    $datein = $saved_datein;
                                    ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
 */
                                $contarighe=0;
                                foreach($simbooking as $simbookingS){
                                        /*
                                        echo $contarighe."<pre>";
                                        print_r($arrayAcco);
                                        echo "</pre><br><br>";
                                        */
                                    $contagiorniMese = 0;
                                    $giorniMese = array(0,0);
                                    $nomeMese = array("","");
                                    $oldmese = "";
                                    $saved_datein = $datein;
                                    while (strtotime($datein) <= strtotime($dateout)) {
                                        if($contagiorniMese==0){
                                            $indiceMese = 0;
                                            $nomeMese[$indiceMese]=date("F",strtotime($datein));
                                        }
                                        else{
                                            if($oldmese != date("m",strtotime($datein))){
                                                $indiceMese++;
                                                $nomeMese[$indiceMese]=date("F",strtotime($datein));
                                            }
                                        }
                                        $giorniMese[$indiceMese] = $giorniMese[$indiceMese]+1;
                                        $oldmese = date("m",strtotime($datein));
                                        $datein = date ("Y-m-d", strtotime("+1 day", strtotime($datein)));
                                        $contagiorniMese++;
                                    }
                                    //print_r($giorniMese);
                                    //print_r($nomeMese);
                                    ?>
                                <table class="table table-bordered table-condensed table-striped" style="font-size:9px;">
                                    <tbody>
                                        <tr>
                                            <td width="7%"><strong><?php echo ucfirst($arrayAcco[$contarighe]) ?></strong></td>
                                            <td class="text-center tdMese0" colspan="<?php echo $giorniMese[0] ?>"><?php echo $nomeMese[0] ?></td>
                                            <td class="text-center tdMese1" colspan="<?php echo $giorniMese[1] ?>"><?php echo $nomeMese[1] ?></td>
                                        </tr>
                                        <tr>
                                            <td width="7%">Day</th>
                                            <?php
                                            $datein = $saved_datein;
                                            $contagiorniMese2 = 0;
                                            while (strtotime($datein) <= strtotime($dateout)) {
                                                ?>
                                                <th width="3%" class="text-center<?php if($contagiorniMese2 < $giorniMese[0]){ ?> tdMese0<?php } else { ?> tdMese1<?php } ?>"><?php echo date("d",strtotime($datein)) ?></td>
                                                <?php
                                                $datein = date ("Y-m-d", strtotime("+1 day", strtotime($datein)));
                                             $contagiorniMese2++;
                                            }
                                            $datein = $saved_datein;
                                            ?>
                                        </tr>
                                        <tr id="riga_<?php echo $contarighe?>">
                                            <td width="7%">Booking</td>
                                            <?php
                                            foreach($simbookingS as $book){
                                                ?>
                                                    <td width="3%" class="text-center <?php if($book["num_in"] > 0){ ?>info<?php } else { ?>active<?php } ?>"><?php echo $book["num_in"] ?></td>
                                                <?php
                                            }
                                            $datein = $saved_datein;
                                            ?>
                                        </tr>
                                        <tr id="riga_ava_<?php echo $contarighe?>">
                                            <td width="7%">Availability</td>
                                            <?php
                                            foreach($simcalendar[$contarighe] as $ava){
                                                ?>
                                                <td width="3%" class="text-center <?php if($ava["n_available"] >= 0){ ?>success<?php } else { ?>danger<?php } ?>"><?php echo $ava["n_available"] ?></td>
                                            <?php
                                            }
                                            $datein = $saved_datein;
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                                    $contarighe++;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="e">
			<div class="row" style="background-color:#fff;">
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								Documents - <strong><?php echo $yearId;?>_<?php echo $storeId;?></strong>
							</h3>
						</div>
						<div class="panel-body">
                            <a target="_blank" href="<?php echo site_url(); ?>/backoffice/printPDFAllGlByBkId/<?php echo $storeId; ?>" ><span class="glyphicon glyphicon-download-alt"></span> Download <strong>Group leader background check form</strong></a>
						</div>
					</div>
				</div>
				<div class="col-md-6">				
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								Notes - <strong><?php echo $yearId;?>_<?php echo $storeId;?></strong>
								<a id="addBkNotes" style="float:right;" href="javascript:void(0);" ><span class="glyphicon glyphicon-plus"></span> Add new note to this booking</a>
							</h3>
						</div>
						<div class="panel-body">
							<?php
							foreach($insertNote as $nota){
								echo date("d/m/Y H:i",strtotime($nota["n_datetime"]))." - User: ".$nota["n_userid"];
								if($nota["n_public"]==1){
									echo " | Public note";
								}
								echo "<br />".$nota["n_testo"];
								echo "<br />----------------------------------------------<br /><br />";
							}
							?>
						</div>
					</div>	
				</div>
			</div>
        </div>
        <div class="tab-pane fade in" id="f">
            <div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Payments history - <strong><?php echo $yearId;?>_<?php echo $storeId;?></strong><?php if($this->session->userdata('ruolo')=="contabile" ){ ?><b style="float:right;">Deposit due: <?php echo number_format($valoreAcconto, 2,",",".")." ".$valutaCampo ; ?></b><?php } ?></h3>
				</div>
                <div class="panel-body">
					<?php if($this->session->userdata('ruolo')=="contabile" ){ ?>
					<div class="row-fluid" style="margin-bottom:20px;">
						<form id="addPaymentFinCon" name="addPaymentFinCon" action="<?php echo site_url() ?>/backoffice/insertSinglePayment" method="POST">
							<div class="col-12">
								<div class="row">
									<div class="col-md-2">
										<label>Type</label>
										<select class="form-control" id="P_typePay" name="P_typePay">
											<option value="avere">Cashed</option>
											<option value="dare">Refounded</option>
											<option value="acq">Due</option>
										</select>
									</div>	
									<div class="col-md-2">
										<label for="P_curDate">Payment date</label><br />
										<input class="form-control" type="text" id="P_curDate" name="P_curDate" class="datepicker" />
									</div>	
									<div class="col-md-2">
										<label for="P_amount">Amount/Due</label><br />
										<input class="form-control" type="text" id="P_amount" name="P_amount" />
									</div>	
									<div class="col-md-1">
										<label>Currency</label>
										<select class="form-control" id="P_currency" name="P_currency">
											<option value="£">£</option>
											<option value="$">$</option>
											<option value="€">€</option>											
										</select>
									</div>									
									<div class="col-md-2">
										<label>Service</label>
										<select class="form-control" id="P_operation" name="P_operation">
										<?php foreach($payServices as $pS){ ?>
											<option value="<?php echo $pS["pfcse_name"] ?>"><?php echo $pS["pfcse_name"] ?></option>
										<?php } ?>
										</select>
									</div>		
									<div class="col-md-2">
										<label>Method</label>
										<select class="form-control" id="P_method" name="P_method">
											<?php foreach($payTypes as $pT){ ?>
											<option value="<?php echo $pT["pfcpt_name"] ?>"><?php echo $pT["pfcpt_name"] ?></option>
											<?php } ?>
										</select>
									</div>							
									<div class="col-md-1 text-right">
										<button type="button" style="margin-top:25px;" class="btn btn-primary" id="P_add" name="P_add" >Add</button>
									</div>																
								</div>
							</div>
							<input type="hidden" name="mybkid" id="mybkid" value="<?php echo $storeId ?>" />
						</form>
					</div>
					<?php } ?>
					 <div class="row-fluid">
                        <div class="col-12">
							<table id="NA_Payments" class="table table-bordered table-condensed table-striped">
								<thead>
								<tr>
									<th class="text-center">Operation date</th>
									<th class="text-center">Currency date</th>
									<th class="text-center">Due</th>
									<th class="text-center">Type</th>
									<th class="text-center">Amount</th>
									<th class="text-center">Operation type</th>
									<th>Payment method</th>
									<th>Notes</th>
								</tr>
								</thead>
								<tbody>
									<?php 
										$contaMoney=0;
										$contaDue=0;
										$lastValuta = "";
										foreach($payments as $pay){ 
											$dOrA = "Cashed";
											$colorDorA = "#090";
											$dSign = "+";
											if($pay["pfp_dare_avere"]=="dare"){
												$dOrA = "Refounded";
												$colorDorA = "#c00";
												$dSign = "-";
											}
											if($pay["pfp_dare_avere"]=="acq"){
												$dOrA = "Due";
												$colorDorA = "#000";
												$dSign = "+";
											}											
											$giroCifra = str_replace(",",".",$pay["pfp_importo"]);
											if($dOrA=="Cashed")
												$contaMoney += $giroCifra*1;
											else
												if($dOrA=="Refounded")
													$contaMoney -= $giroCifra*1;
												else
													$contaDue += $giroCifra*1;
									?>
									<tr>
										<td class="text-center">
											<?php if($this->session->userdata('ruolo')=="contabile" ){ ?>
												<button id="delP_<?php echo $pay["pfp_id"] ?>" type="button" class="pDeleteMe btn btn-danger btn-xs" style="padding-top:2px;margin-right:5px;">Delete</button>	
											<?php } ?>
											<?php echo date("d/m/Y H:i",strtotime($pay["pfp_data_operazione"]))?>
										</td>
										<td class="text-center"><?php if(!is_null($pay["pfp_data_valuta"])){ echo date("d/m/Y",strtotime($pay["pfp_data_valuta"])); }?></td>
										<td class="text-right" style="font-weight:bold;color:#000;"><?php if($pay["pfp_dare_avere"]=="acq"){ echo /*$dSign." ".*/number_format($giroCifra, 2,",",".")." ".$pay["pfp_valuta"];}?></td>
										<td class="text-center" style="font-weight:bold;color:<?php echo $colorDorA; ?>"><?php echo $dOrA?></td>
										<td class="text-right"><?php if($pay["pfp_dare_avere"]!="acq"){ echo $dSign." ".number_format($giroCifra, 2,",",".")." ".$pay["pfp_valuta"];}?></td>
										<td class="text-center"><?php echo $pay["pfp_tipo_servizio"]?></td>
										<td><?php echo $pay["pfp_metodo_pagamento"]?></td>
										<td><?php echo $pay["pfp_note"]?></td>
									</tr>
									<?php 
										$lastValuta = $pay["pfp_valuta"];
										} 
									$formattedMoney = number_format($contaMoney, 2,",",".");
									$formattedDue = number_format($contaDue, 2,",",".");
									$contaTotal = $contaMoney - $contaDue;
									$totalDue = number_format($contaTotal, 2,",",".");
									?>
									<tr><td colspan="8">&nbsp;</td></tr>
									<tr>
										<td colspan="2" class="text-right" style="font-weight:bold;">Total</td>
										<td class="text-right" style="font-weight:bold;"><?php echo $formattedDue; ?> <?php echo $lastValuta; ?></td>
										<td>&nbsp;</td>
										<td class="text-right" style="font-weight:bold;"><?php echo $formattedMoney; ?> <?php echo $lastValuta; ?></td>
										<td colspan="3" class="text-right" style="font-weight:bold;"><?php echo $totalDue; ?> <?php echo $lastValuta; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>
        </div>		
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Pax editing</h4>
      </div>
      <div class="modal-body" id="modalBody">
        loading pax...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModalNote" tabindex="-1" role="dialog" aria-labelledby="myModalLabelNote" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelNote">Insert note</h4>
      </div>
      <div class="modal-body" id="modalBody">
        <textarea id="newNoteBk" name="newNoteBk" style="width:90%;"></textarea><br /><br />
		<label for="isPubNote">Note is public (visible by Campus Managers)</label><br />
		<input type="checkbox" name="isPubNote" id="isPubNote" value="1" />
      </div>
      <div class="modal-footer">
		<button type="button" id="saveNote" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>		
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
<script src="<?php echo base_url()?>js/bootstrap-timepicker.min.js"></script>
<script>

	function bConfirm(){
		if(confirm("Are you sure you want to confirm this booking?")){
			$.ajax({
				url: siteUrl + "backoffice/change_booking_status/<?php echo $storeId ?>/confirmed",
				success: function(html){
					location.reload();
				}
			});
		}else{
			return false;
		}
	}

	function bReject(){
		if(confirm("Are you sure you want to reject this booking?")){
			$.ajax({
				url: siteUrl + "backoffice/change_booking_status/<?php echo $storeId ?>/rejected",
				success: function(html){
					location.reload();
				}
			});
		}else{
			return false;
		}
	}
	
	function bPaid(){
		if(confirm("Are you sure you want to notify to operator the payment for this booking?")){
			$.ajax({
				url: siteUrl + "backoffice/add_flag_payment/<?php echo $storeId ?>",
				success: function(html){
					location.reload();
				}
			});
		}else{
			return false;
		}
	}	
	
	function bCleared(){
		if(confirm("Are you sure you want to clear this booking for departure?")){
			$.ajax({
				url: siteUrl + "backoffice/add_flag_cfd/<?php echo $storeId ?>",
				success: function(html){
					location.reload();
				}
			});
		}else{
			return false;
		}
	}	
	
	function bCheckPaid(){
		if(confirm("Are you sure you want to notify to accounting to check the payment for this booking?")){
			$.ajax({
				url: siteUrl + "backoffice/add_flag_checkPay/<?php echo $storeId ?>",
				success: function(html){
					location.reload();
				}
			});
		}else{
			return false;
		}
	}		
	
	function bActivate(){
		var lmFlag = 0;
		if($("#lm_flag").prop("checked"))
			lmFlag = 1;
		//alert(lmFlag);
		var DatKo = $("#B_active").val().split("/");
		var Yok = DatKo[2];
		var Mok = DatKo[1];
		var Dok = DatKo[0];
		var DatOk = DatKo[0]+"-"+DatKo[1]+"-"+DatKo[2];
		//alert(DatOk);
		if(confirm("Are you sure you want to activate this booking until "+$("#B_active").val()+"?")){
			$.ajax({
				url: siteUrl + "backoffice/change_booking_status/<?php echo $storeId ?>/active/"+DatOk+"/"+lmFlag,
				success: function(html){
					location.reload();
				}
			});
		}else{
			return false;
		}
	}
	
	function getFrameElement() {
		var iframes= parent.document.getElementsByTagName('iframe');
		for (var i= iframes.length; i-->0;) {
			var iframe= iframes[i];
			try {
				var idoc= 'contentDocument' in iframe? iframe.contentDocument : iframe.contentWindow.document;
			} catch (e) {
				continue;
			}
			if (idoc===document)
				return iframe;
		}
		return null;
	}	
	
	
	$(document).ready(function(){		
		$(".tab-pane").removeClass("active");
		$(".nav-pills > li").removeClass("active");
		$("#<?php echo $pill; ?>").addClass("active");
		$("#pill_<?php echo $pill; ?>").addClass("active");
		
		<?php if($this->session->userdata('ruolo')=="contabile" ){ ?>
		
		document.getElementById('addPaymentFinCon').reset();
		
		$(".pDeleteMe").click(function(){
			if(confirm("Are you sure you want to remove this line?")){
				var DatKo = $(this).attr("id").split("_");
				var idToDel = DatKo[1];
				request = $.ajax({
						url: siteUrl + "backoffice/deleteSinglePayment/"+idToDel
					});
				request.done(function (response, textStatus, jqXHR){
					//alert("deleted");
					location.reload();
				});
			}else{
				return false;
			}
		});
		
		$("#P_curDate").datepicker({
		  dateFormat: "dd/mm/yy"
		});
		

		$("#P_typePay").change(function(){
			if($(this).val()=="acq"){
				$("#P_curDate").attr("disabled",true);
				$("#P_method").attr("disabled",true);
			}else{
					$("#P_curDate").prop("disabled",false);
					$("#P_method").prop("disabled",false);
			}
		});		
		
		
	
		$('#P_add').click(function(){
			if($("#P_amount").val()==""){
				alert("Please insert the amount!");
				return false;
			}
			if($("#P_typePay").val()!="acq"){
				if($("#P_curDate").val()==""){
					alert("Please insert the currency date!");
					return false;
				}
			}
			if(confirm("Are you sure you want to add this payment?")){
				passingData = $('#addPaymentFinCon').serialize();
				var $inputs = $('#addPaymentFinCon').find("input, select, button, textarea");
				$inputs.prop("disabled", true);
				request = $.ajax({
					url: siteUrl + "backoffice/insertSinglePayment",
					type: "post",
					data: passingData
				});
				request.done(function (response, textStatus, jqXHR){
					$inputs.prop("disabled", false);
					location.reload();
				});
			}else{
				return false;
			}
		});
	
		$("#B_notificaPayment").click(function(){
			if($("#statusPaymentFinCon").val()=="B_paid"){
				bPaid();
			}
		});	
		
		$("#B_notificaCleared").click(function(){
			if($("#statusClearedFinCon").val()=="B_cleared"){
				bCleared();
			}
		});			
		
		<?php } ?>
		$('[data-toggle="tooltip"]').tooltip();
		$('#backToList').click(function(){
			parent.history.back();
			return false;
		});
		
		$("#B_confermaBooking").click(function(){
			if($("#statusBookingFinCon").val()=="B_confirm"){
				bConfirm();
			}
			if($("#statusBookingFinCon").val()=="B_reject"){
				bReject();
			}			
		});		
		
		$("#B_active").datepicker({
		  dateFormat: "dd/mm/yy",
		  maxDate: "<?php echo $maxNoLmDate ?>"
		});
		$( "#B_active" ).datepicker( "setDate", "<?php echo $maxNoLmDate ?>" );
		$("#statusBooking").change(function(){
			if($(this).val()=="B_reject"){
				$("#B_active").attr("disabled",true);
				$("#lm_flag").attr("disabled",true);
			}
			if($(this).val()=="B_activate"){
					$("#B_active").prop("disabled",false);
					$("#lm_flag").prop("disabled",false);
			}
		});
		$("#B_checkPayment").click(function(){
				bCheckPaid();
		});			
		$("#lm_flag").change(function(){
			if($(this).prop("checked")){
				$( "#B_active" ).datepicker( "option", "maxDate", "<?php echo $maxLmDate ?>" );
			}else{
				$( "#B_active" ).datepicker( "setDate", "<?php echo $maxNoLmDate ?>" );
				$( "#B_active" ).datepicker( "option", "maxDate", "<?php echo $maxNoLmDate ?>" );
			}
		});
		$("#B_cambiaStato").click(function(){
			if($("#statusBooking").val()=="B_reject"){
				bReject();
			}
			if($("#statusBooking").val()=="B_activate"){
				bActivate();
			}
			if($("#statusBooking").val()=="B_confirm"){
				bConfirm();
			}			
		});


		$('.unlockBookingRoster').click(function(){
			if(confirm("Are you sure you want to unlock roster for this payment?")){
				$("#updatingAll").show();
				$.ajax({
					url: siteUrl + "backoffice/unlockRoster/<?php echo $storeId ?>",
					success: function(html){
						window.location.href=siteUrl + 'backoffice/newAvail/<?php echo $storeId; ?>/b';
					}
				});
			}else{
				return false;
			}
		});


		$('.paxRemClass').click(function(){
			if(confirm("Are you sure you want to delete this pax from the booking?")){
				$("#updatingAll").show();
				var paxKo = $(this).attr("id").split("_");
				var idToDel = paxKo[1];
				$.ajax({
					url: siteUrl + "backoffice/delRosterPax/"+idToDel+"/<?php echo $storeId; ?>",
					success: function(html){
						window.location.href=siteUrl + 'backoffice/newAvail/<?php echo $storeId; ?>/b';
					}
				});
			}else{
				return false;
			}
		});
		
		$('#addRosterPax').click(function(){
			if(confirm("Are you sure you want to add a pax to the booking?")){
				$("#updatingAll").show();
				$.ajax({
					url: siteUrl + "backoffice/addRosterPax/<?php echo $storeId; ?>",
					success: function(html){
						window.location.href=siteUrl + 'backoffice/newAvail/<?php echo $storeId; ?>/b';
					}
				});
			}else{
				return false;
			}
		});		

		$('.paxModClass').click(function(){
			var paxKo = $(this).attr("id").split("_");
			var idToMod = paxKo[1];
			$("#modalBody").load(siteUrl + "backoffice/modRosterPax/"+idToMod+"/<?php echo $storeId; ?>");
			$('#myModal').modal()
		});	
		
		$("#addBkNotes").click(function(){
			$('#myModalNote').modal();			
		});
		
		$("#saveNote").click(function(e){
			e.preventDefault();
			if($("#newNoteBk").val()==""){
				alert("Please fill the note field!");
			}else{
				var nPublic = 0;
				if($("#isPubNote").prop('checked')){
					nPublic = 1
				}
				$.post(siteUrl + "backoffice/insertBkNote/<?php echo $storeId; ?>", { testo: $("#newNoteBk").val(), utente: "<?php echo $this->session->userdata('mainfamilyname')?>", notaPubblica: nPublic })
				.done(function(data) {
					$( "#myModalNote" ).modal('toggle');
					$("#updatingAll").show();
					window.location.href=siteUrl + '/backoffice/newAvail/<?php echo $storeId; ?>/e';
				});
			}
		});

        $("#B_setOvernight").click(function(){
            if($("#durationOvernight").val()=="" || $("#periodOvernight").val()=="" || $("#campusOvernight").val()==""){
                alert("Please set duration, period and campus for overnight");
                return false;
            }else{
                $("#B_setOvernight").attr("disabled",true);
                $.ajax({
                    method: "POST",
                    url: siteUrl + "backoffice/newDuplicateOvernight",
                    data: "tWhen=" + $("#periodOvernight").val() + "&tNights=" + $("#durationOvernight").val() + "&tCampus=" + $("#campusOvernight").val() + "&tRef=<?php echo $storeId; ?>"
                }).done(function(html){
                    if(html=="ok"){
                        alert("Overnight for booking <?php echo $yearId;?>_<?php echo $storeId;?> has been setted!");
                        $("#overnightBox").hide();
                    }
                });
                return false;
            }
        });

		<?php if($dayToArrive < 30){ ?>
			$("#lm_flag").prop("checked",true);
			if($("#lm_flag").prop("checked")){
				$( "#B_active" ).datepicker( "option", "maxDate", "<?php echo $maxLmDate ?>" );
			}
		<?php } ?>
	});
	
	$(document).on('click', '.paxUnlClass', function(e){
				e.preventDefault();
				var c = confirm('Are you sure to unlock roster?');
				if(c){
					var elm = $(this);
					var parent = elm.parent().parent();
					var rowId = elm.attr('id').replace('paxUnl_', '');
					$.ajax({
						url: siteUrl + 'backoffice/unlockSingleRoster',
						type: 'POST',
						data: {
							rowId: rowId
						},
						success: function(data){
							if(data == 1){
								elm.remove();
								parent.find('.glyphicon-lock').remove();
								alert('Roster unlocked successfully');
							}
							else{
								alert('Failed to unlock Roster');
							}
						},
						error: function(){
							alert('Failed to unlock Roster');
						}
					});
				}
		
			});
			$('#printVisaPax').on('click', function(e){
				e.preventDefault();
				var elm = $(this);
				var bookId = elm.attr('data-book');
				if(bookId !== '' && typeof bookId != 'undefined'){
					var diaH = $(window).height()* 0.5;
					e.preventDefault();
					$('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(' + baseUrl + '/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
						.html($('<iframe/>', {
							'src' : siteUrl + "backoffice/visaTemplates/"+bookId,
							'style' :'width:100%; height:100%;border:none;'
						})).appendTo('body')
						.dialog({
							'title' : 'Select Template',
							'width' : '50%',
							'height' : diaH,
							modal: true,
							buttons: [ {
								text: "Close",
								click: function() { $( this ).dialog( "close" ); }
							} ]
						});
				}
			});
</script>
</body>
</html>