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
        <li role="presentation" class="active"><a href="#d" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span> Multi Campus Availability from <?php echo date("d/m/Y",strtotime($datein)) ?> to <?php echo date("d/m/Y",strtotime($dateout)) ?></a></li>
    </ul>
    <div class="tab-content" style="margin-top:10px;">
        <div class="tab-pane fade in active" id="d">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-12">
						<?php 
								foreach($statusArray as $statovecchio){
									$statiNew[] = "n_".$statovecchio;
								}
								//print_r($statiNew);
								for($a=0;$a<count($campusArray);$a++){ 
								
								$dateArr = array();
								foreach($dates[$a] as $dataArr){
									$dateArr[] = strtotime($dataArr["start_date"]);
								}
						?>
							<input style="width:200px;text-align:left;" type="button" value="<?php echo $campusName[$a]; ?>" class="btn btn-primary btnToggle" id="btnToggle_0">
							<div id="tabAvail_<?php echo $a ?>" class="collapse in">
                            <table class="table table-bordered table-condensed table-striped tabAvail" style="font-size:9px;">
							<thead>
								<tr>
									<th width="7%" >&nbsp;</th>
								<?php
									$datecycle = $datein;
									while (strtotime($datecycle) <= strtotime($dateout)) {
								?>
									<th width="3%" <?php if(in_array(strtotime($datecycle),$dateArr)){ ?>class="text-info info"<?php } ?>><span <?php if(strtotime($datecycle)==strtotime($datechoose)){ ?>class="text-danger"<?php } ?>><?php echo date("d/m",strtotime($datecycle)) ?></span></th>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>
								</tr>
							</thead>
							<tbody>
								<tr class="rigaAvail">
									<td>Allotment</td>
								<?php
									$datecycle = $datein;	
									$contagiorni=0;
									while (strtotime($datecycle) <= strtotime($dateout)) {
								?>
									<td><input type="text" readonly value="<?php echo $simcalendar[$a][$contagiorni]["totale"]?>"></td>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
										$contagiorni++;
									}
								?>	
								</tr>
								<tr>
									<td>Booked</td>
								<?php
									$datecycle = $datein;	
									$contagiorni=0;										
									while (strtotime($datecycle) <= strtotime($dateout)) {
										/*
										$totGiorno=0;
										if(in_array("n_confirmed",$statiNew))
											$totGiorno=$totGiorno+$simcalendar[$a][$contagiorni]["n_confirmed"];
										if(in_array("n_active",$statiNew))
											$totGiorno=$totGiorno+$simcalendar[$a][$contagiorni]["n_active"];
										if(in_array("n_elapsed",$statiNew))
											$totGiorno=$totGiorno+$simcalendar[$a][$contagiorni]["n_elapsed"];
										if(in_array("n_tbc",$statiNew))
											$totGiorno=$totGiorno+$simcalendar[$a][$contagiorni]["n_tbc"];
										*/
								?>
									<td><input type="text" readonly value="<?php echo $simcalendar[$a][$contagiorni]["booked"];?>"></td>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
										$contagiorni++;										
									}
								?>	
								</tr>	
								<tr class="avalRow">
									<td>Availability</td>
								<?php
									$datecycle = $datein;	
									$contagiorni=0;									
									while (strtotime($datecycle) <= strtotime($dateout)) {
								?>
									<td class="text-center <?php if($simcalendar[$a][$contagiorni]["n_available"] >= 0){ ?>success<? }else{ ?>danger<?php } ?>"><input type="text" readonly value="<?php echo $simcalendar[$a][$contagiorni]["n_available"]?>"></td>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
										$contagiorni++;										
									}
								?>	
								</tr>									
							</tbody>
						</table>
						</div>
						<?php
							}
						?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script>

$(document).ready(function(){
	$("td input").each(function(){
		if($(this).val()=="0"){
			$(this).val("-");
		}
	});
});
</script>
</body>
</html>