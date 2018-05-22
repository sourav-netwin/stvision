<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<h4 class="box-title" class="col-sm-12"><?php echo $escursione["exc_excursion_name"] ?> from <?php echo $campus ?> for <?php echo $tot_pax ?> pax</h4>
<form name="allbuses" id="allbuses" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/plusedConfirmBuses">
    <input type="hidden" name="id_exc_join" id="id_exc_join" value="<?php echo $escursione["exc_id"] ?>" />
<script>
var arrdate = new Array();
var depdate = new Array();
</script>
<div class="row">
    <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header">
                    <h4 class="box-title" class="col-sm-12">Available standby excursions</h4>
                </div>
                <div class="box-body">
                    <table class="datatable table table-bordered table-striped vertical-middle" width="99.9%" >
                        <thead>
                                <tr>
                                        <th style="width:150px">ID Bus</th>
                                        <th style="width:150px">Excursion date</th>
                                        <th style="text-align:right;width:150px">Tot Pax</th>									
                                        <th>&nbsp;</th>
                                </tr>
                        </thead>
                        <tbody>
                        <?php foreach($otherExc as $oExs){
                        ?>
                                <tr>
                                        <td>
                                                <?php echo $oExs["exb_buscompany_code"]?>
                                        </td>								
                                        <td class="center"><?php echo date("d/m/Y",strtotime($oExs["exb_excursion_date"]))?></td>
                                        <td style="text-align:right;"><?php echo $oExs["all_tot_pax"]?></td>
                                        <td class="center"><a href="<?php echo base_url(); ?>index.php/backoffice/busExcDetail/code_<?php echo $oExs["exb_buscompany_code"]?>" id="mycode_<?php echo $oExs["exb_buscompany_code"]?>">Review this excursion and add groups</a></td>
                                </tr>
                        <?php
                                }
                        ?>
                        </tbody>
                </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    &nbsp;
                </div>
                <!-- /.box-footer-->
            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h4 class="box-title" class="col-sm-12">Bookings review</h4>
                </div>
                <div class="box-body">
                    <table class="datatable table table-bordered table-striped vertical-middle" width="99.9%" >
                            <thead>
                                    <tr>
                                            <th>ID Book</th>
                                            <th>Agency</th>
                                            <th>Arrival Date</th>
                                            <th>Departure Date</th>
                                            <th style="text-align:right;">Tot Pax</th>									
                                    </tr>
                            </thead>
                            <tbody>
                            <?php foreach($bookings as $exs){
                            ?>
                                    <script>
                                            arrdate.push('<?php echo strtotime($exs["arrival_date"]. "+1day +3hours")?>');
                                            depdate.push('<?php echo strtotime($exs["departure_date"]. "-1 day +3hours")?>');
                                    </script>
                                    <tr>
                                            <td>
                                                    <?php echo $exs["exb_id_year"]?>_<?php echo $exs["exb_id_book"]?>
                                                    <input type="hidden" name="exc_numb[]" value="<?php echo $exs["exb_id"]?>" />
                                            </td>
                                            <td>
                                                    <?php echo $exs["businessname"]?>
                                            </td>									
                                            <td class="center"><?php echo date("d/m/Y",strtotime($exs["arrival_date"]))?></td>
                                            <td class="center"><?php echo date("d/m/Y",strtotime($exs["departure_date"]))?></td>
                                            <td style="text-align:right;"><?php echo $exs["tot_pax"]?></td>
                                    </tr>
                            <?php
                                    }
                            ?>
                            </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    &nbsp;
                </div>
                <!-- /.box-footer-->
            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h4 class="box-title" class="col-sm-12">Confirm bus transportation for selected excursions</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-lg-3">
                            <label for="selAgeRangeTo">Select Date for excursion</label>
                            <input class="required form-control" type="text" id="s_exc_date" name="s_exc_date" value="" />
                            <script>
                                var UrangeFrom=Math.max.apply(null,arrdate);
                                var UrangeTo=Math.min.apply(null,depdate);
                                var rangeFrom=new Date(Math.max.apply(null,arrdate)*1000);
                                var rangeTo=new Date(Math.min.apply(null,depdate)*1000);	
                                if(UrangeTo < UrangeFrom){
                                        alert("Error! Selected bookings dates doesn't allow the excursion! You'll be redirected on the previous selection screen!");
                                        history.back();
                                }
                            </script>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-3">
                            <label for="pickup_time">Pickup Time</label>
                            <input class="required form-control" type="text" id="pickup_time" name="pickup_time" value="" />					
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-3">
                            <label for="return_hour">Return Hour</label>
                            <input class="required form-control" type="text" id="return_hour" name="return_hour" value=""  />					
                        </div>
                        <div class="col-sm-12 mr-top-10">
                            <label for="return_hour">Pickup Place</label>
                            <textarea class="required form-control" id="pickup_place" name="pickup_place"><?php echo $pickupPlace ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mr-top-10">
                            <label>Bookings review</label>
                        </div>
                        <div class="col-sm-12 mr-top-10">
                            <table class=" table table-bordered table-striped vertical-middle" width="99.9%" >
                                <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th>Bus type</th>
                                            <th>Seats</th>
                                            <th style="text-align:right;">Cost</th>									
                                            <th>Select</th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $jnCurrency = '';
                                if($bus)
                                foreach($bus as $bb){
                                ?>
                                        <tr>
                                                <td>
                                                        <?php echo $bb["tra_cp_name"]?>
                                                </td>
                                                <td>
                                                        <?php echo $bb["tra_bus_name"]?>
                                                </td>									
                                                <td class="center"><?php echo $bb["tra_bus_seat"]?></td>
                                                <td style="text-align:right;"><?php echo $bb["jn_price"]?> <?php echo $bb["jn_currency"]?></td>
                                                <td class="center containcheck">
                                                    <select class="form-control bus_num" name="bus_<?php echo $bb["jn_id_bus"] ?>" id="bus_<?php echo $bb["jn_id_bus"] ?>">
                                                            <option value="0">-</option>
                                                            <option value="1">1 bus</option>
                                                            <option value="2">2 buses</option>
                                                            <option value="3">3 buses</option>
                                                            <option value="4">4 buses</option>
                                                            <option value="5">5 buses</option>
                                                    </select>
                                                    <input type="hidden" name="currency_<?php echo $bb["jn_id_bus"] ?>" id="currency_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["jn_currency"]?>" />
                                                    <input type="hidden" name="cost_<?php echo $bb["jn_id_bus"] ?>" id="cost_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["jn_price"]?>" />
                                                    <input type="hidden" class="tcost" name="totcost_<?php echo $bb["jn_id_bus"] ?>" id="totcost_<?php echo $bb["jn_id_bus"] ?>" value="0" />
                                                    <input type="hidden" name="pax_<?php echo $bb["jn_id_bus"] ?>" id="pax_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["tra_bus_seat"]?>" />
                                                    <input type="hidden" class="tpax" name="totpax_<?php echo $bb["jn_id_bus"] ?>" id="totpax_<?php echo $bb["jn_id_bus"] ?>" value="0" />									
                                                </td>
                                                
                                        </tr>
                                <?php
                                    $jnCurrency = $bb["jn_currency"];
                                        }
                                ?>
                                        <tr>
                                                <td colspan="2">&nbsp;</td>
                                                <td class="center"><input style="text-align:center;" class="silverinputborder" type="text" readonly value="0" name="suppax" id="suppax" /></td>
                                                <td style="text-align:right;"><input style="text-align:right;" class="silverinputborder" type="text" readonly value="0" name="supcost" id="supcost" /> <?php echo $jnCurrency;?></td>
                                                <td></td>
                                        </tr>	
                                        <tr>
                                                <td colspan="2">&nbsp;</td>
                                                <td class="center"><input style="text-align:center;border:none;box-shadow:none;background-color:transparent;width:150px;" type="text" readonly value="" name="exppax" id="exppax" /></td>
                                                <td colspan="2"><input style="text-align:right;border:none;box-shadow:none;background-color:transparent;width:150px;color:#5E6267;padding-right:0;" type="text" readonly value="" name="pricepax" id="pricepax" /> <?php echo $jnCurrency?> @pax</td>
                                        </tr>									
                                </tbody>
                        </table>
                        <input type="hidden" name="pppax" id="pppax" value="<?php echo $tot_pax?>" />
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-danger pull-right" id="bus_all" name="bus_all" class="alt_btn">Confirm bus transportation for selected excursions</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-footer-->
            </div>
    </div>
</div>
</form>

<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
function aggpaxcost(){
	var supcost = 0;
	var suppax = 0;
	$(".tcost").each(function(){
		supcost += $(this).val()*1;
	});
	$(".tpax").each(function(){
		suppax += $(this).val()*1;
	});	
	$("#supcost").val(supcost.toFixed(2));
	$("#suppax").val(suppax);
	$("#pricepax").val(((supcost/<?php echo $tot_pax ?>)*1).toFixed(2));
	var diff = $("#suppax").val() - $("#pppax").val();
	if(diff < 0){
		$("#suppax").css("background-color","#880000");
		$("#suppax").css("color","#ffffff");	
		$("#exppax").val(diff+" pax remaining!");		
	}
	if(diff >= 0 && diff <= 5){
		$("#suppax").css("background-color","#008800");
		$("#suppax").css("color","#ffffff");	
		$("#exppax").val("Just "+diff+" extra seats selected!");			
	}
	if(diff > 5){
		$("#suppax").css("background-color","#d14000");
		$("#suppax").css("color","#ffffff");	
		$("#exppax").val(diff+" extra seats selected!");		
	}

  }
  $(document).ready(function(){
	aggpaxcost();
	$(".bus_num").change(function(){ 
		var arrclassi = $(this).attr("id").split("_");
		var arrid = "#cost_"+arrclassi[1];
		var totid = "#totcost_"+arrclassi[1];
		var arrpx = "#pax_"+arrclassi[1];
		var totpx = "#totpax_"+arrclassi[1];
		$(totid).val($(arrid).val()*$(this).val());
		$(totpx).val($(arrpx).val()*$(this).val());
		aggpaxcost();
	});
        $( "#s_exc_date" ).datepicker({
                    defaultDate: rangeFrom,
                    numberOfMonths: 1,
                    dateFormat: "dd/mm/yy",
                    minDate: rangeFrom,
                    maxDate: rangeTo
        });	
        $( "#pickup_time" ).timepicker({
                    timeFormat: "hh:mm"
            });		
        $( "#return_hour" ).timepicker({
		timeFormat: "hh:mm"
	});
        
        $("#allbuses").validate({
            errorElement:"div",
            ignore: "",
            rules: {
                    s_exc_date: "required",
                    pickup_time: "required",
                    return_hour: "required"
            },
            messages: {
                    s_exc_date: "Please select date of excursion",
                    pickup_time: "Please select pickup time",
                    return_hour: "Please select return hours"
            },
            submitHandler: function(form) {
                    if($("#suppax").val() > 0)
                        form.submit();
                    else{
                        swal("Alert","Please select bus to confirm");
                    }
            }
        });
        
  });
</script>