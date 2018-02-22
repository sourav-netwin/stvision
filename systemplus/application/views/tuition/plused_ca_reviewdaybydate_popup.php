<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Vision - Plus-Ed</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/external/jquery-ui-1.8.21.custom.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/style.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/elements.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/NA_style.css" />

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
			ui-dialog{
				position: absolute !important;
				height: auto !important;
				width: 800px !important;
				top: 0px !important;
				left: 180px !important;
				display: block !important;
				z-index: 101 !important;
			}
			table td{
				height: 55px !important;
				vertical-align: middle !important;
			}
		</style>
		<script type="text/javascript">
			var arraycontabkgs = new Array();
		</script>
	</head>
	<body style="background-color:#fff;height:100%;">
		<div class="container-fluid">
			<ul class="nav nav-pills" role="tablist">
				<li role="presentation" class="active"><a href="#d" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span> <?php echo $campusname ?>  <?php echo date("d/m/Y", strtotime($datein)) ?> to <?php echo date("d/m/Y", strtotime($dateout)) ?></a></li>
			</ul>
			<div class="tab-content" style="margin-top:10px;">
				<div class="tab-pane fade in active" id="d" style="display: inline-block !important;">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row-fluid">
								<div class="col-12">
									<?php
									$dateArr = array();
									foreach ($dates as $dataArr) {
										$dateArr[] = strtotime($dataArr["start_date"]);
									}

									$contarighe = 1;
									?>
									<div id="tabAvail_" class="collapse in">
										
										<table class="table table-bordered table-condensed table-striped tabAvail" style="font-size:10px;">
											<thead>
												<tr>
													<th></th>
													<?php
													$datecycle = $datein;
													$cnttd = 0;
													while (strtotime($datecycle) <= strtotime($dateout)) {
														?>
														<th width="4%"><span <?php if (strtotime($datecycle) == strtotime($datechoose)) { ?>class="text-danger"<?php } ?>><?php echo date("d/m", strtotime($datecycle)) ?></span></th>
														<?php
														$datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
														if(isset($books[$cnttd]['booked'][0])){
															!isset($books[$cnttd]['booked'][1]) ? $books[$cnttd]['booked'][1] = 0 : '';
															!isset($books[$cnttd]['booked'][2]) ? $books[$cnttd]['booked'][2] = 0 : '';
															!isset($books[$cnttd]['booked'][3]) ? $books[$cnttd]['booked'][3] = 0 : '';
														}
														$std_val = isset($books[$cnttd]['booked']['standard']) ? $books[$cnttd]['booked']['standard'] : 0;
														$ens_val = isset($books[$cnttd]['booked']['ensuite']) ? $books[$cnttd]['booked']['ensuite'] : 0;
														$hms_val = isset($books[$cnttd]['booked']['homestay']) ? $books[$cnttd]['booked']['homestay'] : 0;
														$twi_val = isset($books[$cnttd]['booked']['twin']) ? $books[$cnttd]['booked']['twin'] : 0;
														$octoday[$cnttd] = !empty($books[$cnttd]['booked']) ? $std_val + $ens_val + $hms_val + $twi_val : 0;
														$cnttd += 1;
													}
													?>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td width="12%">In</td>
													<?php
													$datecycle = $datein;
													$cnttd = 0;
													while (strtotime($datecycle) <= strtotime($dateout)) {
														?>
														<td width="4%">
															<?php if($books[$cnttd]["num_in"] > 0){ ?><a href="javascript:void(0);" class="openDoorPaxList" id="od_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/door-open-in_green.png"><span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]["num_in"] ?></span></a><?php }else{ ?>&nbsp;<?php } ?>
														</td>
														<?php
														$datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
														$cnttd += 1;
													}
													?>
													
												</tr>
												<tr>
													<td width="12%">Out</td>
													<?php
													$datecycle = $datein;
													$cnttd = 0;
													while (strtotime($datecycle) <= strtotime($dateout)) {
														?>
														<td><?php if ($books[$cnttd]["num_out"] > 0) { ?><a href="javascript:void(0);" class="closeDoorPaxList" id="cd_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/door-open-out_red.png"><span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]["num_out"] ?></span></a><?php
													}
													else {
														?>&nbsp;<?php } ?></td>
														<?php
														$datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
														$cnttd += 1;
													}
													?>
													
												</tr>
												<tr>
													<td width="12%">Standard</td>
													<?php
													$datecycle = $datein;
													$cnttd = 0;
													while (strtotime($datecycle) <= strtotime($dateout)) {
														?>
														<td><?php if(isset($books[$cnttd]['booked']['standard'])){ if ($books[$cnttd]['booked']['standard'] > 0) { ?><a title="<?php echo date("d/m/Y", strtotime($books[$cnttd]["datat"])) ?> - Standard" class="openDayDetail" id ="opendetail_<?php echo $books[$cnttd]["datat"] ?>_1" href="javascript:void(0);"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/user-medium.png"><span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]['booked']['standard'] ?></span></a><?php
															}
															else {
														?>&nbsp;<?php }} ?></td>
														<?php
														$datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
														$cnttd += 1;
													}
													?>										
													
												</tr>
												<tr>
													<td width="12%">Ensuite</td>
													<?php
													$datecycle = $datein;
													$cnttd = 0;
													while (strtotime($datecycle) <= strtotime($dateout)) {
														?>
														<td><?php if(isset($books[$cnttd]['booked']['ensuite'])){ if ($books[$cnttd]['booked']['ensuite'] > 0) { ?><a title="<?php echo date("d/m/Y", strtotime($books[$cnttd]["datat"])) ?> - Ensuite" class="openDayDetail" id ="opendetail_<?php echo $books[$cnttd]["datat"] ?>_2" href="javascript:void(0);"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/user-share.png"><span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]['booked']['ensuite'] ?></span></a><?php
															}
															else {
														?>&nbsp;<?php }} ?></td>
														<?php
														$datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
														$cnttd += 1;
													}
													?>											
													
												</tr>
												<tr>
													<td width="12%">Homestay</td>
													<?php
													$datecycle = $datein;
													$cnttd = 0;
													while (strtotime($datecycle) <= strtotime($dateout)) {
														?>
														<td><?php if(isset($books[$cnttd]['booked']['homestay'])){ if ($books[$cnttd]['booked']['homestay'] > 0) { ?><a title="<?php echo date("d/m/Y", strtotime($books[$cnttd]["datat"])) ?> - Homestay" class="openDayDetail" id ="opendetail_<?php echo $books[$cnttd]["datat"] ?>_3" href="javascript:void(0);"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/home-medium.png"><span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]['booked']['homestay'] ?></span></a><?php
															}
															else {
														?>&nbsp;<?php }} ?></td>
														<?php
														$datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
														$cnttd += 1;
													}
													?>
												</tr>
												<tr>
													<td width="12%">Twin</td>
													<?php
													$datecycle = $datein;
													$cnttd = 0;
													while (strtotime($datecycle) <= strtotime($dateout)) {
														?>
														<td><?php if(isset($books[$cnttd]['booked']['twin'])){ if ($books[$cnttd]['booked']['twin'] > 0) { ?><a title="<?php echo date("d/m/Y", strtotime($books[$cnttd]["datat"])) ?> - Twin" class="openDayDetail" id ="opendetail_<?php echo $books[$cnttd]["datat"] ?>_4" href="javascript:void(0);"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/users.png"><span style="float:left;width:30px;text-align:center;"><?php echo $books[$cnttd]['booked']['twin'] ?></span></a><?php
															}
															else {
														?>&nbsp;<?php }} ?></td>
														<?php
														$datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
														$cnttd += 1;
													}
													?>
												</tr>
												<tr>
													<td width="12%">Transfers</td>
													<?php
													$datecycle = $datein;
													$cnttd = 0;
													while (strtotime($datecycle) <= strtotime($dateout)) {
														?>
														<td><?php if ($num_transfers[$cnttd] > 0) { ?><a href="javascript:void(0);" class="TransfersPaxList" id="tra_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/transfer_plane.png"><span style="float:left;width:30px;text-align:center;"><?php echo $num_transfers[$cnttd] ?></span></a><?php
															}
															else {
														?>&nbsp;<?php } ?></td>
														<?php
														$datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
														$cnttd += 1;
													}
													?>
												</tr>
												<tr>
													<td width="12%">Planned</td>
													<?php
													$datecycle = $datein;
													$cnttd = 0;
													while (strtotime($datecycle) <= strtotime($dateout)) {
														?>
														<td><?php if ($num_excursions[$cnttd] > 0) { ?><a href="javascript:void(0);" class="ExcursionsPaxList" id="exc_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bus_excursion.png"><span style="float:left;width:30px;text-align:center;"><?php echo $num_excursions[$cnttd] ?></span></a><?php
															}
															else {
														?>&nbsp;<?php } ?></td>
														<?php
														$datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
														$cnttd += 1;
													}
													?>
												</tr>
												<tr>
													<td width="12%">Extra</td>
													<?php
													$datecycle = $datein;
													$cnttd = 0;
													while (strtotime($datecycle) <= strtotime($dateout)) {
														?>
														<td><?php if ($num_extra_excursions[$cnttd] > 0) { ?><a href="javascript:void(0);" class="ExtraExcursionsPaxList" id="excExtra_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bus_excursion.png"><span style="float:left;width:30px;text-align:center;"><?php echo $num_extra_excursions[$cnttd] ?></span></a><?php
															}
															else {
														?>&nbsp;<?php } ?></td>
														<?php
														$datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
														$cnttd += 1;
													}
													?>
												</tr>
												<tr>
													<td width="12%">On campus today</td>
													<?php
													$datecycle = $datein;
													$cnttd = 0;
													while (strtotime($datecycle) <= strtotime($dateout)) {
														?>
														<td><?php if ($octoday[$cnttd] > 0) { ?><a style="padding:0 5px;" href="javascript:void(0);" class="allPaxList " title="View students list" id="od_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/edit-list-order.png"></a><a style="padding:0 5px; "href="javascript:void(0);" class="allBookList " title="View bookings list" id="od_<?php echo $books[$cnttd]["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/applications-stack.png"></a><span style="float:left;width:30px;text-align:center;"><?php echo $octoday[$cnttd] ?></span><?php
															}
															else {
														?>&nbsp;<?php } ?></td>
														<?php
														$datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
														$cnttd += 1;
													}
													?>
													
												</tr>
                                                <?php
                                                    //Review rule by selecting distinct campus id on plused_book_overnight table
                                                    if($campus==3 or $campus==54){
                                                 ?>

                                                <tr>
                                                    <td colspan="32" style="border: 2px solid #000;background-color: #000;height: auto !important;padding: 4px;color: #fff;">
                                                        OVERNIGHTS
                                                    </td>
                                                </tr>

                                                    <?php
                                                    foreach($simbookingOvernights[0] as $book){
                                                        //echo "<br />->".$book["arrival_date"]."--->".$book["departure_date"];
                                                        $da=explode("-",$book["arrival_date"]);
                                                        $dd=explode("-",$book["departure_date"]);
                                                        switch($book["status"]){
                                                            case "confirmed":
                                                                $statusBTS = "success";
                                                                break;
                                                            case "active":
                                                                $statusBTS = "warning";
                                                                break;
                                                            case "tbc":
                                                                $statusBTS = "info";
                                                                break;
                                                            case "elapsed":
                                                                $statusBTS = "danger";
                                                                break;
                                                        }
                                                        ?>
                                                        <tr id="riga_<?php echo $contarighe?>" class="overnight">
                                                            <td width="12%" class="n_<?php echo $book["status"] ?> text-center" style="border:1px solid #000;height: auto !important;"><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /> <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?></span></td>
                                                            <?php
                                                            //echo $datein."-->";
                                                            $datecycle = date ("Y-m-d", strtotime("+0 day", strtotime($datein)));
                                                            //$datecycle = $datein;
                                                            while (strtotime($datecycle) <= strtotime($dateout)) {
                                                                $datecycle = $datecycle." 00:00:00";
                                                                //echo $datecycle."---".$book["arrival_date"]."---".$book["departure_date"];
                                                                //sostituito <= con < nell'if successivo per liberare i posti oncampus il giorno della partenza!
                                                                if($datecycle>=$book["arrival_date"] and $datecycle<$book["departure_date"]){
                                                                    //echo "-Numero<br>";
                                                                    ?>
                                                                    <td width="4%" style="height: auto !important;" class="text-center <?php echo $statusBTS ?>" title="<?php echo $book["contaPieni"] ?>"><input class="contapax nobbg" type="text" readonly value="<?php echo $book["num_in"] ?>"></td>
                                                                <?php
                                                                }else{
                                                                    //echo "-Zero<br>";
                                                                    ?>
                                                                    <td width="4%" style="height: auto !important;" class="text-center" title="<?php echo $book["contaPieni"] ?>"><input class="contapax nobbg"  type="text" readonly value="0"></td>
                                                                <?php
                                                                }
                                                                $datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                                            }
                                                            ?>
                                                        </tr>
                                                        <?php
                                                        $contarighe++;
                                                    }
                                                    ?>

                                            <?php } ?>
											</tbody>
										</table>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
						
		
		<!--<input type="hidden" value="" name="hidDate" id="hidDate" />
		<input type="hidden" value="" name="typeForCsv" id="typeForCsv" />
		<input type="hidden" value="" name="accoForCsv" id="accoForCsv" />
		<input type="hidden" value="" name="accoForChList" id="accoForChList" />
		<input type="hidden" value="" name="accoForBook" id="accoForBook" />-->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url() ?>js/jquery.browser.min.js"></script>	
		<script src="<?php echo base_url() ?>js/jquery.printElement.min.js"></script>	
		<script>

			$(document).ready(function(){				
				$(".openDayDetail").click(function(){
					window.parent.$("#hidDate").val('');	
					window.parent.$("#accoForCsv").val('all');	
					window.parent.$("#typeForCsv").val('');				
					window.parent.$("#accoForChList").val('');
					window.parent.$("#transDate").val('');
					window.parent.$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
					var bytd = $(this).attr("id");
					//alert(bytd);
					var splitbytd = bytd.split("_");
					var bydate = splitbytd[1];
					window.parent.$("#hidDate").val(bydate);	
					var byacco = splitbytd[2];
					window.parent.$("#accoForCsv").val(byacco);
					//alert('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/'+splitbytd[2]+'/'+bydate+'/confirmed/');
					window.parent.$( "#dialog_modal" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/'+splitbytd[2]+'/'+bydate+'/confirmed/');
					return false;			
				});	
									
				$(".openDoorPaxList").click(function(){
					window.parent.$("#hidDate").val('');
					window.parent.$("#accoForCsv").val('all');	
					window.parent.$("#typeForCsv").val('arrival');
					window.parent.$("#accoForChList").val('');
					window.parent.$("#accoForBook").val('');
					window.parent.$("#transDate").val('');
					window.parent.$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
					var bytd = $(this).attr("id");
					var splitbytd = bytd.split("_");
					var bydate = splitbytd[1];	
					window.parent.$("#hidDate").val(bydate);
					window.parent.$("#dialog_modal").load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/'+bydate+'/confirmed/arrival');
					return false;			
				});		

				$(".closeDoorPaxList").click(function(){
					window.parent.$("#hidDate").val('');	
					window.parent.$("#accoForCsv").val('all');
					window.parent.$("#typeForCsv").val('departure');
					window.parent.$("#accoForChList").val('');
					window.parent.$("#accoForBook").val('');
					window.parent.$("#transDate").val('');
					window.parent.$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
					var bytd = $(this).attr("id");
					var splitbytd = bytd.split("_");
					var bydate = splitbytd[1];	
					window.parent.$("#hidDate").val(bydate);				
					window.parent.$( "#dialog_modal" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/'+bydate+'/confirmed/departure');
					return false;			
				});	

				$(".allPaxList").click(function(){
					window.parent.$("#hidDate").val('');	
					window.parent.$("#typeForCsv").val('');	
					window.parent.$("#accoForCsv").val('');
					window.parent.$("#accoForChList").val('all');
					window.parent.$("#accoForBook").val('');
					window.parent.$("#transDate").val('');
					window.parent.$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
					var bytd = $(this).attr("id");
					var splitbytd = bytd.split("_");
					var bydate = splitbytd[1];
					window.parent.$("#hidDate").val(bydate);	
					window.parent.$("#accoForCsv").val('all');				
					window.parent.$( "#dialog_modal" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/'+bydate+'/confirmed/null/null/all_list');
					return false;			
				});	
							
				$(".TransfersPaxList").click(function(){
					window.parent.$("#hidDate").val('');	
					window.parent.$("#typeForCsv").val('');	
					window.parent.$("#accoForCsv").val('');
					window.parent.$("#accoForChList").val('');
					window.parent.$("#accoForBook").val('');
					window.parent.$("#dialog_modal_tra").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
					var bytd = $(this).attr("id");
					var splitbytd = bytd.split("_");
					var bydate = splitbytd[1];
					window.parent.$("#transDate").val(bydate);
					window.parent.$( "#dialog_modal_tra" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_getTransfersBusCodesForDay/'+bydate);
					return false;			
				});	
							
				$(".ExcursionsPaxList").click(function(){
					window.parent.$("#hidDate").val('');	
					window.parent.$("#typeForCsv").val('');	
					window.parent.$("#accoForCsv").val('');	
					window.parent.$("#accoForChList").val('');
					window.parent.$("#accoForBook").val('');
					window.parent.$("#transDate").val('');
					window.parent.$("#dialog_modal_exc").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
					var bytd = $(this).attr("id");
					var splitbytd = bytd.split("_");
					var bydate = splitbytd[1];
					window.parent.$( "#dialog_modal_exc" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_getExcursionsBusCodesForDay/'+bydate);
					return false;			
				});		

				$(".ExtraExcursionsPaxList").click(function(){
					window.parent.$("#hidDate").val('');	
					window.parent.$("#typeForCsv").val('');	
					window.parent.$("#accoForCsv").val('');
					window.parent.$("#accoForChList").val('');
					window.parent.$("#accoForBook").val('');
					window.parent.$("#transDate").val('');
					window.parent.$("#dialog_modal_exc_extra").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
					var bytd = $(this).attr("id");
					var splitbytd = bytd.split("_");
					var bydate = splitbytd[1];
					window.parent.$( "#dialog_modal_exc_extra" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_getExtraExcursionsBusCodesForDay/'+bydate);
					return false;			
				});			
						
							
				$(".allBookList").click(function(){
					window.parent.$("#hidDate").val('');	
					window.parent.$("#typeForCsv").val('');	
					window.parent.$("#accoForCsv").val('');
					window.parent.$("#accoForChList").val('all');
					window.parent.$("#accoForBook").val('all');
					window.parent.$("#transDate").val('');
					window.parent.$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
					var bytd = $(this).attr("id");
					var splitbytd = bytd.split("_");
					var bydate = splitbytd[1];
					window.parent.$("#hidDate").val(bydate);	
					window.parent.$("#accoForCsv").val('all');				
					window.parent.$( "#dialog_modal" ).load('<?php echo base_url(); ?>index.php/backoffice/infoday2day/<?php echo $campus ?>/all/'+bydate+'/confirmed');
					return false;			
				});		

			});
			
		</script>
	</body>
</html>