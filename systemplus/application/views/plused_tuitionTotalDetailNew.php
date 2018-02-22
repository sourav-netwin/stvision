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
</head>
<body style="background-color:#fff;height:100%;">
<div class="container-fluid">
    <ul class="nav nav-pills" role="tablist">
        <li role="presentation" class="active"><a href="#d" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span> Multi Campus tuition from <?php echo date("d/m/Y",strtotime($datein)) ?> to <?php echo date("d/m/Y",strtotime($dateout)) ?></a></li>
    </ul>
    <div class="tab-content" style="margin-top:10px;">
        <div class="tab-pane fade in active" id="d">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-12">
						<?php 
								for($a=0;$a<count($simbooking);$a++){ 
									$contarighe=1;
									$dateArr = array();
									foreach($dates[$a] as $dataArr){
										$dateArr[] = strtotime($dataArr["start_date"]);
									}
						?>
							<input type="button" id="btnToggle_<?php echo $a ?>" class="btn btn-primary btnToggle" value="<?php echo $campusName[$a] ?>">
							<div id="tabAvail_<?php echo $a ?>" class="collapse in">
                            <table class="table table-bordered table-condensed table-striped tabAvail" style="font-size:9px;">
							<thead>
								<tr>
									<th width="7%" >Agency</th>
								<?php
									$datecycle = $datein;
									while (strtotime($datecycle) <= strtotime($dateout)) {
									$festivo=0;
									if(date("D",strtotime($datecycle))=="Sat" or date("D",strtotime($datecycle))=="Sun"){
										$festivo=1;
									}
								?>
									<th width="3%" <?php if(in_array(strtotime($datecycle),$dateArr) or $festivo==1){ ?>class="text-info info<?php if($festivo==1){ ?> text-danger danger<?php } ?>"<?php } ?>><span><?php echo date("d/m",strtotime($datecycle)) ?></span></th>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach($simbooking[$a] as $book){
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
								<tr id="riga_<?php echo $contarighe?>">
									<td width="7%" class="n_<?php echo $book["status"] ?>"><input type="hidden" value="<?php echo $book["num_in"] ?>" id="pax_<?php echo $contarighe?>"><span class="tdTool" data-toggle="tooltip" title="<?php echo $book["businessname"] ?>"><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /> <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?></span></td>
								<?php
									//echo $datein."-->";
									$datecycle = date ("Y-m-d", strtotime("+0 day", strtotime($datein)));
									//$datecycle = $datein;								
									while (strtotime($datecycle) <= strtotime($dateout)) {
									//echo $datecycle."<br>";
									//sostituito <= con < nell'if successivo per liberare i posti oncampus il giorno della partenza!
									if($datecycle>=$book["arrival_date"] and $datecycle<$book["departure_date"]){
								?>
									<td width="3%" class="text-center <?php echo $statusBTS ?>"><input class="contapax nobbg" id="pax_<?php echo $contarighe?>_<?php echo strtotime($datecycle)?>" type="text" readonly value="<?php echo $book["num_in"] ?>"></td>
								<?php
									}else{
								?>
									<td width="3%" class="text-center"><input class="contapax nobbg" id="pax_<?php echo $contarighe?>_<?php echo strtotime($datecycle)?>" type="text" readonly value="0"></td>
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
								<tr class="rigaAvail">
									<td>Students</td>
								<?php
									$datecycle = $datein;	
									foreach($simcalendar[$a] as $cAva) {	
										$festivo=0;
										if(date("D",strtotime($datecycle))=="Sat" or date("D",strtotime($datecycle))=="Sun"){
											$festivo=1;
										}
								?>
									<td <?php if($festivo==1){ ?>class="text-danger danger"<?php } ?>><input id="totava_<?php echo strtotime($datecycle)?>" type="text" class="nobbg" readonly value="<?php echo $cAva["booked"]?>"></td>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>	
								</tr>								
								<tr class="avalRow">
									<td>Teachers</td>
																<?php
									$datecycle = $datein;	
									foreach($simcalendar[$a] as $cAva) {	
										$festivo=0;
										if(date("D",strtotime($datecycle))=="Sat" or date("D",strtotime($datecycle))=="Sun"){
											$festivo=1;
										}
									
								?>
									<td <?php if($festivo==1){ ?>class="text-danger danger"<?php } ?>><input id="totava_<?php echo strtotime($datecycle)?>" type="text" class="nobbg" readonly value="<?php echo ceil($cAva["booked"]*1/15)?>"></td>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>	
								</tr>									
							</tbody>
						</table>
						</div>
						<?php } ?>
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
	$('.tdTool').tooltip();

	$("td input").each(function(){
		if($(this).val()=="0"){
			$(this).val("-");
		}
	});		
	});
</script>
</body>
</html>