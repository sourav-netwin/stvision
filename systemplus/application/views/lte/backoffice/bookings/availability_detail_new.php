<script>
    var arraycontabkgs = new Array();
</script>
<div class="box">
            <div class="box-header with-border text-center">
              <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="#d" style="cursor:default;" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span> Availability on <?php echo $campusname ?> from <?php echo date("d/m/Y",strtotime($datein)) ?> to <?php echo date("d/m/Y",strtotime($dateout)) ?></a></li>
                </ul>
            </div>
            <!-- /.box-header -->
            <div class="box-body test-head">
                <?php
                $dateArr = array();
                foreach ($dates as $dataArr) {
                    $dateArr[] = strtotime($dataArr["start_date"]);
                }
                for ($a = 0; $a < count($simbooking); $a++) {
                    $contarighe = 1;
                    ?>
                    
                    <div class="row">
                        <div class="col-sm-12 mr-bot-10">
                            <input type="button" id="btnToggle_<?php echo $a ?>" class="btn btn-primary btnToggle" value="<?php echo ucfirst($_REQUEST["accomodation"][$a]); ?> accomodation">
                        </div>
                    </div>
                    <div class="row">
                        <div style="overflow-x: auto;" id="tabAvail_<?php echo $a ?>" class="collapse col-sm-12 in">
                        <table class="table table-bordered table-condensed table-striped tabAvail" style="font-size:9px;">
                            <thead>
                                <tr>
                                    <th >Agency</th>
                                    <?php
                                    $datecycle = $datein;
                                    while (strtotime($datecycle) <= strtotime($dateout)) {
                                        ?>
                                        <th  <?php if (in_array(strtotime($datecycle), $dateArr)) { ?>class="text-info info"<?php } ?>><span <?php if (strtotime($datecycle) == strtotime($datechoose)) { ?>class="text-danger"<?php } ?>><?php echo date("d/m", strtotime($datecycle)) ?></span></th>
                                        <?php
                                        $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($simbooking[$a] as $book) {
                                    //echo "<br />->".$book["arrival_date"]."--->".$book["departure_date"];
                                    $da = explode("-", $book["arrival_date"]);
                                    $dd = explode("-", $book["departure_date"]);
                                    switch ($book["status"]) {
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
                                    <tr id="riga_<?php echo $contarighe ?>">
                                        <td  class="n_<?php echo $book["status"] ?>"><input type="hidden" value="<?php echo $book["num_in"] ?>" id="pax_<?php echo $contarighe ?>"><a href="http://plus-ed.com/vision_ag/index.php/backoffice/newAvail/<?php echo $book["id_book"] ?>/a" title="Go to booking detail"><span class="tdTool" data-toggle="tooltip" title="<?php echo $book["businessname"] ?>"><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"] ?>.png" alt="<?php echo $book["businesscountry"] ?>" title="<?php echo $book["businesscountry"] ?>" /> <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?></span></a></td>
                                        <?php
                                        //echo $datein."-->";
                                        $datecycle = date("Y-m-d", strtotime("+0 day", strtotime($datein)));
                                        //$datecycle = $datein;
                                        while (strtotime($datecycle) <= strtotime($dateout)) {
                                            $datecycle = $datecycle . " 00:00:00";
                                            //echo $datecycle."---".$book["arrival_date"]."---".$book["departure_date"];
                                            //sostituito <= con < nell'if successivo per liberare i posti oncampus il giorno della partenza!
                                            if ($datecycle >= $book["arrival_date"] and $datecycle < $book["departure_date"]) {
                                                //echo "-Numero<br>";
                                                ?>
                                                <td  class="text-center <?php echo $statusBTS ?>" title="<?php echo $book["contaPieni"] ?>"><input class="contapax nobbg" id="<?php echo $_REQUEST["accomodation"][$a] ?>_pax_<?php echo $contarighe ?>_<?php echo strtotime($datecycle) ?>" type="text" readonly value="<?php echo $book["num_in"] ?>"></td>
                                                <?php
                                            } else {
                                                //echo "-Zero<br>";
                                                ?>
                                                <td  class="text-center" title="<?php echo $book["contaPieni"] ?>"><input class="contapax nobbg" id="<?php echo $_REQUEST["accomodation"][$a] ?>_pax_<?php echo $contarighe ?>_<?php echo strtotime($datecycle) ?>" type="text" readonly value="0"></td>
                                                <?php
                                            }
                                            $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                        }
                                        ?>									
                                    </tr>
                                    <?php
                                    $contarighe++;
                                }
                                ?>
                                <tr class="rigaAvail">
                                    <td>Allotment</td>
                                    <?php
                                    $datecycle = $datein;
                                    foreach ($simcalendar[$a] as $cAva) {
                                        ?>
                                        <td><input id="<?php echo $_REQUEST["accomodation"][$a] ?>_totava_<?php echo strtotime($datecycle) ?>" type="text" class="nobbg form-control" readonly value="<?php echo $cAva["totale"] ?>"></td>
                                        <?php
                                        $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                    }
                                    ?>	
                                </tr>
                                <tr>
                                    <td>Booked</td>
                                    <?php
                                    $datecycle = $datein;
                                    while (strtotime($datecycle) <= strtotime($dateout)) {
                                        ?>
                                        <td><input class="nobbg form-control" type="text" readonly id="<?php echo $_REQUEST["accomodation"][$a] ?>_totpax_<?php echo strtotime($datecycle) ?>" value="0"></td>
                                        <?php
                                        $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                    }
                                    ?>	
                                </tr>	
                                <tr class="avalRow">
                                    <td>Availability</td>
                                    <?php
                                    $datecycle = $datein;
                                    while (strtotime($datecycle) <= strtotime($dateout)) {
                                        ?>
                                        <td class="text-center"><input class="nobbg form-control" type="text" readonly id="<?php echo $_REQUEST["accomodation"][$a] ?>_leftava_<?php echo strtotime($datecycle) ?>" value="0"></td>
                                        <?php
                                        $datecycle = date("Y-m-d", strtotime("+1 day", strtotime($datecycle)));
                                    }
                                    ?>	
                                </tr>									
                            </tbody>
                        </table>
                    </div>
                </div>
            <script type="text/javascript">
                arraycontabkgs[<?php echo $a ?>]=<?php echo $contarighe - 1 ?>;
            </script>
        <?php } ?>
    </div>
</div>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE; ?>custom/backoffice.js"></script>
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
	
                $('.goToBookingDetail').on('click', function(e){
                    e.preventDefault();
                    var bookingId = $(this).attr('data-book-id');
                    loadBookingDetail(bookingId);
                    
                });
                
                $('#retriveDataDiv').on('mouseover', function(e){
                    $("body").addClass('modal-open');
                });
                
                
                 /* BOOKING MODAL JS */
                $('body').on('click',".pDeleteMe",function(){
			var bookId = $('#bkDetBookId').val();
			var elm = $(this);
			confirmAction("Are you sure you want to remove this line?", function(s){
				if(s){
					var DatKo = elm.attr("id").split("_");
					var idToDel = DatKo[1];
					request = $.ajax({
						url: siteUrl + "backoffice/deleteSinglePayment/"+idToDel
					});
					request.done(function (response, textStatus, jqXHR){
						loadBookingDetail(bookId,'f');
					});
				}
			},true,true);
		});
									
							
									

		$('body').on('change',"#P_typePay",function(){
			if($(this).val()=="acq"){
				$("#P_curDate").attr("disabled",true);
				$("#P_method").attr("disabled",true);
			}else{
				$("#P_curDate").prop("disabled",false);
				$("#P_method").prop("disabled",false);
			}
		});		
									
									
								
		$('body').on('click','#P_add',function(){
			if($("#P_amount").val()==""){
				swal("Error","Please insert the amount!");
				return false;
			}
			if($("#P_typePay").val()!="acq"){
				if($("#P_curDate").val()==""){
					swal("Error","Please insert the currency date!");
					return false;
				}
			}
			var bookId = $('#bkDetBookId').val();
			confirmAction("Are you sure you want to add this payment?", function(s){
				if(s){
					var passingData = $('#addPaymentFinCon').serialize();
					var $inputs = $('#addPaymentFinCon').find("input, select, button, textarea");
					$inputs.prop("disabled", true);
					$.ajax({
						url: siteUrl + "backoffice/insertSinglePayment",
						type: "post",
						data: passingData,
						success: function(){
							$inputs.prop("disabled", false);
							swal('Success', 'Payment added successfully');
							loadBookingDetail(bookId,'f');
						},
						error:function(){
							swal('Error','Failed to add payment');
						}
					});
				}
			},true,true);
		});
								
		$('body').on('click',"#B_notificaPayment",function(){
			if($("#statusPaymentFinCon").val()=="B_paid"){
				bPaid();
			}
		});	
									
		$('body').on('click',"#B_notificaCleared",function(){
			if($("#statusClearedFinCon").val()=="B_cleared"){
				bCleared();
			}
		});	
                
    /* END OF BOOKING MODAL JS*/
    
});
</script>