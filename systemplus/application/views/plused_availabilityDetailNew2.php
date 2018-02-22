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
        <li role="presentation" class="active"><a href="#d" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span> Availability on <?php echo $campusname ?> from <?php echo date("d/m/Y",strtotime($datein)) ?> to <?php echo date("d/m/Y",strtotime($dateout)) ?></a></li>
    </ul>
    <div class="tab-content" style="margin-top:10px;">
        <div class="tab-pane fade in active" id="d">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-12">
						<?php 
								$dateArr = array();
								foreach($dates as $dataArr){
									$dateArr[] = strtotime($dataArr["start_date"]);
								}
								for($a=0;$a<count($simbooking);$a++){ 
									$contarighe=1;
						?>
							<input type="button" id="btnToggle_<?php echo $a ?>" class="btn btn-primary btnToggle" value="<?php echo ucfirst($_REQUEST["accomodation"][$a]); ?> accomodation">
							<div id="tabAvail_<?php echo $a ?>" class="collapse in">
                            <table class="table table-bordered table-condensed table-striped tabAvail" style="font-size:9px;">
							<thead>
								<tr>
									<th width="7%" >Agency</th>
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
							<?php 
								foreach($simbooking[$a] as $book){
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
								<tr id="riga_<?php echo $contarighe?>">
                                                                    <td width="7%" class="n_<?php echo $book["status"] ?>"><input type="hidden" value="<?php echo $book["num_in"] ?>" id="pax_<?php echo $contarighe?>"><a href="<?php echo base_url();?>index.php/backoffice/newAvail/<?php echo $book["id_book"] ?>/a" title="Go to booking detail"><span class="tdTool" data-toggle="tooltip" title="<?php echo $book["businessname"] ?>"><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /> <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?></span></a></td>
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
									<td width="3%" class="text-center <?php echo $statusBTS ?>" title="<?php echo $book["contaPieni"] ?>"><input class="contapax nobbg" id="<?php echo $_REQUEST["accomodation"][$a] ?>_pax_<?php echo $contarighe?>_<?php echo strtotime($datecycle)?>" type="text" readonly value="<?php echo $book["num_in"] ?>"></td>
								<?php
									}else{
										//echo "-Zero<br>";
								?>
									<td width="3%" class="text-center" title="<?php echo $book["contaPieni"] ?>"><input class="contapax nobbg" id="<?php echo $_REQUEST["accomodation"][$a] ?>_pax_<?php echo $contarighe?>_<?php echo strtotime($datecycle)?>" type="text" readonly value="0"></td>
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

                            <?php //Inizio Overnights ?>


                            <?php
                            foreach($simbookingOvernights[$a] as $book){
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
                                    <td width="7%" class="n_<?php echo $book["status"] ?>" style="border:2px solid #000;"><input type="hidden" value="<?php echo $book["num_in"] ?>" id="pax_<?php echo $contarighe?>"><a href="http://plus-ed.com/vision_ag/index.php/backoffice/newAvail/<?php echo $book["id_book"] ?>/a" title="Go to booking detail"><span class="tdTool" data-toggle="tooltip" title="<?php echo $book["businessname"] ?>"><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /> <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?></span></a></td>
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
                                            <td width="3%" class="text-center <?php echo $statusBTS ?>" title="<?php echo $book["contaPieni"] ?>"><input class="contapax nobbg" id="<?php echo $_REQUEST["accomodation"][$a] ?>_pax_<?php echo $contarighe?>_<?php echo strtotime($datecycle)?>" type="text" readonly value="<?php echo $book["num_in"] ?>"></td>
                                        <?php
                                        }else{
                                            //echo "-Zero<br>";
                                            ?>
                                            <td width="3%" class="text-center" title="<?php echo $book["contaPieni"] ?>"><input class="contapax nobbg" id="<?php echo $_REQUEST["accomodation"][$a] ?>_pax_<?php echo $contarighe?>_<?php echo strtotime($datecycle)?>" type="text" readonly value="0"></td>
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


                            <?php //Fine Overnights ?>
								<tr class="rigaAvail">
									<td>Allotment</td>
								<?php
									$datecycle = $datein;	
									foreach($simcalendar[$a] as $cAva) {	
								?>
									<td><input id="<?php echo $_REQUEST["accomodation"][$a] ?>_totava_<?php echo strtotime($datecycle)?>" type="text" class="nobbg" readonly value="<?php echo $cAva["totale"]?>"></td>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>	
								</tr>
								<tr>
									<td>Booked</td>
								<?php
									$datecycle = $datein;								
									while (strtotime($datecycle) <= strtotime($dateout)) {
								?>
									<td><input class="nobbg" type="text" readonly id="<?php echo $_REQUEST["accomodation"][$a] ?>_totpax_<?php echo strtotime($datecycle)?>" value="0"></td>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>	
								</tr>	
								<tr class="avalRow">
									<td>Availability</td>
								<?php
									$datecycle = $datein;								
									while (strtotime($datecycle) <= strtotime($dateout)) {
								?>
									<td class="text-center"><input class="nobbg" type="text" readonly id="<?php echo $_REQUEST["accomodation"][$a] ?>_leftava_<?php echo strtotime($datecycle)?>" value="0"></td>
								<?php
										$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
									}
								?>	
								</tr>									
							</tbody>
						</table>
						</div>
						<script type="text/javascript">
							arraycontabkgs[<?php echo $a ?>]=<?php echo $contarighe-1 ?>;
						</script>
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
function updatebkd(ggt, dateloop2, acco){
	var i=0;
		while(i<dateloop2.length){
			var somma = 0;
			for(girx=1;girx<=ggt;girx++){
				var idattualex = "#"+acco+"_pax_"+girx+"_"+dateloop2[i];
				//alert(idattualex);
				//alert($(idattualex).val());
				iddasommare = $(idattualex).val();
				if(iddasommare=="0")
					iddasommare=0;
				somma = somma+(iddasommare*1);
				//alert(somma);
			}
				idttriga="#"+acco+"_totpax_"+dateloop2[i];
				idttava="#"+acco+"_totava_"+dateloop2[i];
				idleftava="#"+acco+"_leftava_"+dateloop2[i];
				var totava = $(idttava).val();
				$(idttriga).val(somma);
				var leftava = totava*1-somma*1;
				var classeavanzo = "success";
				if(leftava < 0)
					classeavanzo = "danger";
				$(idleftava).val(leftava);
				$(idleftava).parent("td").addClass(classeavanzo);
			i++;
		}
		//alert(somma);
} 

$(document).ready(function(){
	$('.tdTool').tooltip();
	dateloop = new Array(); 
	<?php
		$datecycle = $datein;	
		$contagirini = 0;
		while (strtotime($datecycle) <= strtotime($dateout)) {
	?>
		dateloop[<?php echo $contagirini?>]="<?php echo strtotime($datecycle)?>";
	<?php
			$datecycle = date ("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
			$contagirini++;
		}
	foreach($_REQUEST["accomodation"] as $key => $value){
	?>	
	updatebkd(arraycontabkgs[<?php echo $key?>], dateloop, '<?php echo $value ?>');
	$("#btnToggle_<?php echo $key?>").click(function(){
        $("#tabAvail_<?php echo $key?>").collapse('toggle');
    });
	<?php
	}
	?>
	$("td input").each(function(){
		if($(this).val()=="0"){
			$(this).val("-");
		}
	});		
	});
</script>
</body>
</html>