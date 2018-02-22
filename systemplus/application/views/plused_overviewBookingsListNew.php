<?php 
/**
 * @modified_by Arunsankar S
 * @date : 07-04-2016
 */
?>
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
    <link rel="stylesheet" href="<?php echo base_url()?>css/NA_style.css" />

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
<script type="text/javascript">
var arraycontabkgs = new Array();
</script>
</head>
<body style="background-color:#fff;height:100%;">
<div class="container-fluid">
    <ul class="nav nav-pills" role="tablist">
        <li role="presentation" class="active"><a href="#d" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span> Bookings detail</a></li>
    </ul>
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
								for($a=0;$a<count($allCampus);$a++){ 
									$contarighe=1;
									$contastati=0;
									//print_r($allCampus[$a]["all_books"]);
									foreach($allCampus[$a]["all_books"] as $bkStatus){
										$contastati=$contastati+count($bkStatus)*1;
										//echo "<br />-".$contastati;
									}
									//echo "<br /><br /><br />";
									if($contastati>0){
						?>
							<input type="button" id="btnToggle_<?php echo $a ?>" class="btn btn-primary btnToggle" value="<?php echo $allCampus[$a]["campusName"]; ?>">
							<div id="tabAvail_<?php echo $a ?>" class="collapse in">
                            <table class="table table-bordered table-condensed table-striped tabAvail" style="font-size:9px;">
							<thead>
								<tr>
									<th class="text-center">Ref Id <span class="glyphicon glyphicon-sort"></span></th>
									<th>Pax <span class="glyphicon glyphicon-sort"></span></th>
									<th>Agency <span class="glyphicon glyphicon-sort"></span></th>
									<th class="text-center">Campus in/out</th>
									<th class="text-center">Days <span class="glyphicon glyphicon-sort"></span></th>
									<th class="text-center">Status <span class="glyphicon glyphicon-sort"></span></th>
									<th class="text-center" title="Last Minute">LST</th>
									<th class="text-center" title="Cleared for Departure">CFD</th>
									<th class="text-center" title="Deposit invoice">Dep</th>
									<th class="text-center" title="Full invoice">Ful</th>
									<th class="text-center" title="Roster">Ros</th>
									<th class="text-center" title="Visa">Vis</th>
									<th class="text-center" title="Notes">Not</th>
									<th class="text-center">Sales</th>
									<th class="text-center">Outstanding</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$now = time();
									foreach($allCampus[$a]["all_books"] as $bkStatus){ ?>
									<?php 
										foreach($bkStatus as $singoloBk){ 
											$da=explode("-",$singoloBk["arrival_date"]);
											$dd=explode("-",$singoloBk["departure_date"]);
											switch($singoloBk["status"]){
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
										<td class="text-center"><a target="_blank" href="<?php echo base_url(); ?>index.php/backoffice/invoice_pdf_no_acconto/<?php echo $singoloBk["id_book"] ?>" title="Download Deposit invoice"><span class="glyphicon glyphicon-file"></span></a></td>
										<td class="text-center">
											<?php if($singoloBk["flag_cfd"]==1){ ?>
											<a target="_blank" href="javascript:void(0);" title="Download Full invoice"><span class="glyphicon glyphicon-file"></span></a>
											<?php } else { ?>
											<span class="glyphicon glyphicon-file"></span>
											<?php } ?>
										</td>
										<td class="text-center"><span  title="Roster (red: locked / black: in progress)" id="bkgRos_<?php echo $singoloBk["id_book"] ?>_b" class="viewRefBook glyphicon glyphicon-list-alt<?php if($singoloBk["hasRoster"] > 0){ ?> evidIco<?php } ?><?php if($singoloBk["lockPax"] == 1){ ?> evidIcoRed<?php } ?> clickRoster"></span></td>
										<td class="text-center">
											<?php 
											//lasciare attiva solo condizione if per disabilitare controllo su roster locked
											/*if($singoloBk["lockPax"] == 1){ */ ?>
											<?php if($singoloBk["hasRoster"] > 0){ ?>
											<span title="Visas (black: available but not printable / green: printable by the agent)" class="glyphicon glyphicon-globe evidIco<?php if($singoloBk["downloadVisa"] == 1){ ?> evidIcoGreen<?php } ?> visaControl" id="enaDisVisa_<?php echo $singoloBk["id_book"] ?>_<?php echo $singoloBk["downloadVisa"]; ?>"></span>
											<?php } else { ?>
											<span class="glyphicon glyphicon-globe" title="Visas not available. Need locked roster"></span>
											<?php } ?>
										</td>
										<td class="text-center"><span id="bkgNot_<?php echo $singoloBk["id_book"] ?>_e" title="Booking notes (black: notes available)" class="viewRefBook glyphicon glyphicon-align-left clickNote<?php if($singoloBk["contaNote"] > 0){ ?> evidIco<?php } ?>"></span></td>
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
											
											switch($arrDue[1]){
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
										}?>
								<?php } ?>
							</tbody>
						</table>
						</div>
						<?php		}
							} 
							$totalRecGBP = $totalDueGBP + $totalOutGBP;
							$totalRecUSD = $totalDueUSD + $totalOutUSD;
							$totalRecEUR = $totalDueEUR + $totalOutEUR;
							?>
                        </div>					
                    </div>
					<div class="row-fluid">
						<table class="table table-bordered table-condensed table-striped" style="font-size:9px;">
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

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
	var baseUrl = "<?php echo base_url(); ?>";
	var siteUrl = "<?php echo site_url(); ?>/";
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<?php /*
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/sorting/datetime-moment.js"></script>
*/ ?>
<script>


$(document).ready(function(){
<?php 
	for($a=0;$a<count($allCampus);$a++){ 
?>
	$("#btnToggle_<?php echo $a?>").click(function(){
        $("#tabAvail_<?php echo $a?>").collapse('toggle');
    });	
<?php 
	}
?>

  $('[data-toggle="tooltip"]').tooltip();
  $('.viewRefBook').click(function(){
		arrRef=$(this).attr("id").split("_");
		idRef=arrRef[1];
		window.location.href= siteUrl + 'backoffice/newAvail/'+idRef+"/"+arrRef[2];
		return false;
  });
  $('.visaControl').click(function(){
		if(confirm("Are you sure you want to toggle Visas availability for this booking? If you enable them (the icon will become green), the agent will be able to print Visas!")){
			canDwnl = 1;
			arrRef=$(this).attr("id").split("_");
			idRef=arrRef[1];
			enableMe=arrRef[2];
			if(enableMe==1)
				canDwnl = 0;
			//alert(idRef+"  "+enableMe);
			$.ajax({
				url: siteUrl + "backoffice/changeDownloadVisa/"+idRef+"/"+canDwnl+"",
				success: function(html){
					if(canDwnl==0){
						$("#enaDisVisa_"+idRef+"_"+enableMe).removeClass("evidIcoGreen");
						$("#enaDisVisa_"+idRef+"_"+enableMe).removeClass("evidIco");
						$("#enaDisVisa_"+idRef+"_"+enableMe).addClass("evidIco");
						$("#enaDisVisa_"+idRef+"_"+enableMe).attr("id","enaDisVisa_"+idRef+"_0");
					}else{
						$("#enaDisVisa_"+idRef+"_"+enableMe).removeClass("evidIcoGreen");
						$("#enaDisVisa_"+idRef+"_"+enableMe).removeClass("evidIco");					
						$("#enaDisVisa_"+idRef+"_"+enableMe).addClass("evidIcoGreen");
						$("#enaDisVisa_"+idRef+"_"+enableMe).attr("id","enaDisVisa_"+idRef+"_1");
					}
				}
			});
			return false;
		}else{
			return false;
		}
  });  
  <?php /* $.fn.dataTable.moment( 'DD/MM/YYYY' ); */ ?>
  $('.tabAvail').DataTable({
	paging: false,
	searching: false,
	info: false,
	columns: [
		null,
		null,
		null,
		{"orderable" : false},
		{"type": "num"},
		null,
		{"orderable" : false},
		{"orderable" : false},
		{"orderable" : false},
		{"orderable" : false},
		{"orderable" : false},
		{"orderable" : false},
		{"orderable" : false},
		{"orderable" : false},
		{"orderable" : false}
		]
  });

	});
</script>
</body>
</html>