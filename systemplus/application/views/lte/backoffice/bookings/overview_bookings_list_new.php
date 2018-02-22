<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url()?>css/NA_style.css" />
<div class="container-fluid">
  <a href="#d" class="btn btn-primary"><span class="glyphicon glyphicon-calendar"></span> Bookings detail</a>
  <div class="tab-content" style="margin-top:10px;">
    <div class="tab-pane fade in active" id="d">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="row-fluid">
            <div class="col-12">
							<?php 
								$totalDueGBP = 0;
								$totalDueUSD = 0;
								$totalDueEUR = 0;
								$totalOutGBP = 0;
								$totalOutUSD = 0;
								$totalOutEUR = 0;								
								for($a=0;$a<count($allCampus);$a++)
								{ 
									$contarighe=1;
									$contastati=0;
									foreach($allCampus[$a]["all_books"] as $bkStatus)
									{
										$contastati=$contastati+count($bkStatus)*1;
									}
									if($contastati>0)
									{
							?>
										<input type="button" id="btnToggle_<?php echo $a ?>" class="btn btn-primary btnToggle" value="<?php echo $allCampus[$a]["campusName"]; ?>">
										<div id="tabAvail_<?php echo $a ?>" class="collapse in pageContainer table-responsive" style="padding-top: 10px;">
                      <table class="table datatable table-bordered table-striped tabAvail">
												<thead>
													<tr>
														<th>Ref Id</span></th>
														<th>Pax</span></th>
														<th>Agency</span></th>
														<th>Campus in/out</th>
														<th>Days</span></th>
														<th>Status</span></th>
														<th class="no-sort" title="Last Minute">LST</th>
														<th class="no-sort" title="Cleared for Departure">CFD</th>
														<th class="no-sort" title="Deposit invoice">Dep</th>
														<th class="no-sort" title="Full invoice">Ful</th>
														<th class="no-sort" title="Roster">Ros</th>
														<th class="no-sort" title="Visa">Vis</th>
														<th class="no-sort" title="Notes">Not</th>
														<th>Sales</th>
														<th>Outstanding</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														$now = time();
														foreach($allCampus[$a]["all_books"] as $bkStatus)
														{
															foreach($bkStatus as $singoloBk)
															{ 
																$da=explode("-",$singoloBk["arrival_date"]);
																$dd=explode("-",$singoloBk["departure_date"]);
																switch($singoloBk["status"])
																{
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
																	case "rejected":
																		$statusBTS = "warning2";
																		break;													
																}	
																$your_date = strtotime($singoloBk["arrival_date"]);
																$difference = round(($now - $your_date)/86400*-1);										
													?>
																<tr class="newBkList">
																	<!--<td class="text-center <?php echo $statusBTS ?>"><?php echo $singoloBk["id_book"] ?>_<?php echo $singoloBk["id_year"] ?></td>-->
																	<td class="text-center <?php echo $statusBTS ?>"><button type="button" class="btn btn-default btn-xs viewRefBook" data-toggle="tooltip" data-placement="top" title="View Booking Ref. <?php echo $singoloBk["id_book"] ?>_<?php echo $singoloBk["id_year"] ?>" id="bkgRef_<?php echo $singoloBk["id_book"] ?>_a"><?php echo $singoloBk["id_book"] ?>_<?php echo $singoloBk["id_year"] ?></button></td>
																	<td class="text-center"><?php echo $singoloBk["tot_pax"] ?>/<span class="fln"><?php echo $singoloBk["hasRoster"] ?></span></td>
																	<td><img style="margin:-1px 5px 0 5px;float:left;" src="<?php echo base_url(); ?>img/flags/16/<?php echo $singoloBk["agency"]["businesscountry"]?>.png" alt="<?php echo $singoloBk["agency"]["businesscountry"]?>" title="<?php echo $singoloBk["agency"]["businesscountry"]?>" /><?php echo $singoloBk["agency"]["businessname"]?><?php /*echo $singoloBk["numNote"] */?></td>
																	<td><span class="glyphicon glyphicon-arrow-right"></span><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?><br /><span class="glyphicon glyphicon-arrow-left"></span><?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?></td>
																	<td class="text-center"<?php if($difference < 110){ ?>style="color:#900;"<?php } ?>><?php echo $difference ?></td>
																	<td class="text-center <?php echo $statusBTS ?>"><?php echo $singoloBk["status"] ?><?php if($singoloBk["status"]=="active"){ ?><span class="dataActive"><?php echo date("d/m/Y",strtotime($singoloBk["data_scadenza"])); ?></span><?php } ?></td>
																	<td class="text-center"><?php if($singoloBk["flag_lm"]==1){ ?><span class="glyphicon glyphicon-ok" title="Last Minute booking"></span><?php } ?></td>
																	<td class="text-center"><?php if($singoloBk["flag_cfd"]==1){ ?><span class="glyphicon glyphicon-ok" title="Cleared for Departure booking"></span><?php } ?></td>
																	<td class="text-center"><a target="_blank" href="<?php echo base_url(); ?>index.php/backoffice/invoice_pdf_no_acconto/<?php echo $singoloBk["id_book"] ?>" data-toggle="tooltip" title="Download Deposit invoice"><span class="glyphicon glyphicon-file"></span></a></td>
																	<td class="text-center">
																		<?php if($singoloBk["flag_cfd"]==1){ ?>
																		<a target="_blank" href="javascript:void(0);" data-toggle="tooltip" title="Download Full invoice"><span class="glyphicon glyphicon-file"></span></a>
																		<?php } else { ?>
																		<span class="glyphicon glyphicon-file"></span>
																		<?php } ?>
																	</td>
																	<td class="text-center"><span data-toggle="tooltip" title="Roster (red: locked / black: in progress)" id="bkgRos_<?php echo $singoloBk["id_book"] ?>_b" class="viewRefBook glyphicon glyphicon-list-alt<?php if($singoloBk["hasRoster"] > 0){ ?> evidIco<?php } ?><?php if($singoloBk["lockPax"] == 1){ ?> evidIcoRed<?php } ?> clickRoster"></span></td>
																	<td class="text-center">
																		<?php 
																		//lasciare attiva solo condizione if per disabilitare controllo su roster locked
																		/*if($singoloBk["lockPax"] == 1){ */ ?>
																		<?php if($singoloBk["hasRoster"] > 0){ ?>
																		<span data-toggle="tooltip" title="Visas (black: available but not printable / green: printable by the agent)" class="glyphicon glyphicon-globe evidIco<?php if($singoloBk["downloadVisa"] == 1){ ?> evidIcoGreen<?php } ?> visaControl" id="enaDisVisa_<?php echo $singoloBk["id_book"] ?>_<?php echo $singoloBk["downloadVisa"]; ?>"></span>
																		<?php } else { ?>
																		<span data-toggle="tooltip" class="glyphicon glyphicon-globe" title="Visas not available. Need locked roster"></span>
																		<?php } ?>
																	</td>
																	<td class="text-center"><span data-toggle="tooltip" id="bkgNot_<?php echo $singoloBk["id_book"] ?>_e" title="Booking notes (black: notes available)" class="viewRefBook glyphicon glyphicon-align-left clickNote<?php if($singoloBk["contaNote"] > 0){ ?> evidIco<?php } ?>"></span></td>
																	<td class="text-right">
																		<?php echo $singoloBk["dueBilancio"] ?>&nbsp;
																	</td>
																	<td class="text-right">
																		<?php echo $singoloBk["saldoBilancio"] ?>&nbsp;
																	</td>
																</tr>
														<?php 
																$arrDue = explode(" ",$singoloBk["dueBilancio"]);
																$arrOut = explode(" ",$singoloBk["saldoBilancio"]);
												
																switch($arrDue[1])
																{
																	case "£":
																		$totalDueGBP +=  str_replace(",",".",str_replace(".","",$arrDue[0]))*1; 
																		$totalOutGBP +=  str_replace(",",".",str_replace(".","",$arrOut[0]))*1; 
																		break;
																	case "$":
																		$totalDueUSD +=  str_replace(",",".",str_replace(".","",$arrDue[0]))*1; 
																		$totalOutUSD +=  str_replace(",",".",str_replace(".","",$arrOut[0]))*1; 
																		break;
																	case "€":
																		$totalDueEUR +=  str_replace(",",".",str_replace(".","",$arrDue[0]))*1; 
																		$totalOutEUR +=  str_replace(",",".",str_replace(".","",$arrOut[0]))*1; 
																		break;
																} 
															}
								 						} 
							 						?>
												</tbody>
											</table>
										</div>
						<?php	}
								} 
								$totalRecGBP = $totalDueGBP + $totalOutGBP;
								$totalRecUSD = $totalDueUSD + $totalOutUSD;
								$totalRecEUR = $totalDueEUR + $totalOutEUR;
							?>
            </div>					
          </div>
					<div class="row-fluid table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th class="text-right">Sales&nbsp;</th>
									<th class="text-right">Received&nbsp;</th>
									<th class="text-right">Outstanding&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-right">GBP</td>
									<td class="text-right"><?php echo number_format($totalDueGBP, 2,",",".")." GBP"; ?></td>
									<td class="text-right"><?php echo number_format($totalRecGBP, 2,",",".")." GBP"; ?></td>
									<td class="text-right"><?php echo number_format($totalOutGBP, 2,",",".")." GBP"; ?></td>
								</tr>
								<tr>
									<td class="text-right">USD</td>
									<td class="text-right"><?php echo number_format($totalDueUSD, 2,",",".")." USD"; ?></td>
									<td class="text-right"><?php echo number_format($totalRecUSD, 2,",",".")." USD"; ?></td>
									<td class="text-right"><?php echo number_format($totalOutUSD, 2,",",".")." USD"; ?></td>
								</tr>
								<tr>
									<td class="text-right">EUR</td>
									<td class="text-right"><?php echo number_format($totalDueEUR, 2,",",".")." EUR"; ?></td>
									<td class="text-right"><?php echo number_format($totalRecEUR, 2,",",".")." EUR"; ?></td>
									<td class="text-right"><?php echo number_format($totalOutEUR, 2,",",".")." EUR"; ?></td>
								</tr>								
							</tbody>
						</table>
					</div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		$(".tabAvail").DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true,
                    "responsive": true,
                    "order": [],
                    "columnDefs": [
                    {
                        "targets"  : 'no-sort',
                        "orderable": false
                    },
                    {
                        "targets"  : 'col-text-numeric',
                        "sSortDataType": 'dom-text-numeric'
                    },
                    {
                        "targets"  : 'col-html-formated-numeric',
                        "sSortDataType": 'dom-html-formated-numeric'
                    }
                    ]
                    });

		<?php 
			for($a=0;$a<count($allCampus);$a++)
			{ 
		?>
				$("#btnToggle_<?php echo $a?>").click(function()
				{
        	$("#tabAvail_<?php echo $a?>").collapse('toggle');
    		});	
	<?php 
			}
		?>
	});
</script>