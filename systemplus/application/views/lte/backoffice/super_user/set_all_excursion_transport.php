<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script type="text/javascript">
    var arrdate = new Array();
    var depdate = new Array();
</script>
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
        <h4 class="box-title"><?php echo $escursione["exc_excursion"] ?> from <?php echo $campus ?> for <?php echo $tot_pax ?> pax</h4>
        </div>
        <div class="box-body row">
            <form name="allbuses" id="allbuses" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/plusedConfirmBusesAllExcursions">
                <input type="hidden" name="id_exc_join" id="id_exc_join" value="<?php echo $escursione["exc_id"] ?>" />
                <div class="col-sm-12">
                        <h4 class="box-title">Bookings review</h4>
                        <table class="datatable table table-bordered table-striped" style="width:99.98%;">
                                <thead>
                                        <tr>
                                                <th>ID Book</th>
                                                <th>Agency</th>
                                                <th>Arrival Date</th>
                                                <th>Departure Date</th>
                                                <th class="text-right">Tot Pax</th>									
                                        </tr>
                                </thead>
                                <tbody>
                                <?php foreach($bookings as $exs){
                                ?>
                                        <input type="hidden" name="exc_numb[]" value="<?php echo $exs["pte_id"]?>">
                                        <script>
                                                arrdate.push('<?php echo strtotime($exs["arrival_date"]. "+1day +3hours")?>');
                                                depdate.push('<?php echo strtotime($exs["departure_date"]. "-1 day +3hours")?>');
                                        </script>
                                        <tr>
                                                <td>
                                                        <?php echo $exs["pte_book_id"]?>
                                                </td>
                                                <td>
                                                        <?php echo $exs["businessname"]?>
                                                </td>									
                                                <td class="text-center"><?php echo date("d/m/Y",strtotime($exs["arrival_date"]))?></td>
                                                <td class="text-center"><?php echo date("d/m/Y",strtotime($exs["departure_date"]))?></td>
                                                <td class="text-right"><?php echo $exs["pte_tot_pax"]?></td>
                                        </tr>
                                <?php
                                        }
                                ?>
                                </tbody>
                        </table>
                </div>
        </form>
        </div>
        </div>
        </div>
    </div>
<div class="row">
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-header">
                <h4><i class="fa fa-calendar"> Select Date for excursion</i></h4>
            </div>
            <div class="box-body">
                    <label for="from">Excursion Date</label>
                    <input type="text" id="s_exc_date" name="s_exc_date" value="" class="form-control" />
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
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-header">
                <h4><i class="fa fa-clock-o"> Select Pickup Time</i></h4>
            </div>
            <div class="box-body">
                    <label for="pickup_time">Pickup Time</label>
                    <input type="text" id="pickup_time" name="pickup_time" value="" class="form-control" />									
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-header">
                <h4><i class="fa fa-clock-o"> Select Return Hour for excursion</i></h4>
            </div>
            <div class="box-body">
                    <label for="return_hour">Return Hour</label>
                    <input type="text" id="return_hour" name="return_hour" value="" class="form-control" />					
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h4><i class="fa fa-plane"> Set Pickup Place</i></h4>
            </div>
            <div class="box-body">
                    <label for="pickup_place">Pickup Place</label>
                    <textarea id="pickup_place" name="pickup_place" class="form-control"><?php echo $pickupPlace ?></textarea>					
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h4><i class="fa fa-train"> Bus review and selection</i></h4>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" style="width:99.98%;">
                    <thead>
                            <tr>
                                    <th>Company</th>
                                    <th>Bus type</th>
                                    <th style="width: 20%;">Seats</th>
                                    <th style="width: 30%;" class="text-right">Cost</th>									
                                    <th>Select</th>
                            </tr>
                    </thead>
                    <tbody>
                    <?php foreach($bus as $bb){
                    ?>
                            <tr>
                                    <td>
                                            <?php echo $bb["tra_cp_name"]?>
                                    </td>
                                    <td>
                                            <?php echo $bb["tra_bus_name"]?>
                                    </td>									
                                    <td class="text-center"><?php echo $bb["tra_bus_seat"]?></td>
                                    <td style="text-align:right;"><?php echo $bb["jn_price"]?> <?php echo $bb["jn_currency"]?></td>
                                    <td class="text-center containcheck">
                                            <select class="bus_num form-control" name="bus_<?php echo $bb["jn_id_bus"] ?>" id="bus_<?php echo $bb["jn_id_bus"] ?>">
                                                    <option value="0">-</option>
                                                    <option value="1">1 bus</option>
                                                    <option value="2">2 buses</option>
                                                    <option value="3">3 buses</option>
                                                    <option value="4">4 buses</option>
                                                    <option value="5">5 buses</option>
                                            </select>
                                    </td>
                                    <input type="hidden" name="currency_<?php echo $bb["jn_id_bus"] ?>" id="currency_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["jn_currency"]?>" />
                                    <input type="hidden" name="cost_<?php echo $bb["jn_id_bus"] ?>" id="cost_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["jn_price"]?>" />
                                    <input type="hidden" class="tcost" name="totcost_<?php echo $bb["jn_id_bus"] ?>" id="totcost_<?php echo $bb["jn_id_bus"] ?>" value="0" />
                                    <input type="hidden" name="pax_<?php echo $bb["jn_id_bus"] ?>" id="pax_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["tra_bus_seat"]?>" />
                                    <input type="hidden" class="tpax" name="totpax_<?php echo $bb["jn_id_bus"] ?>" id="totpax_<?php echo $bb["jn_id_bus"] ?>" value="0" />									
                            </tr>
                    <?php
                            }
                    ?>
                            <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td class="text-center">
                                        <input class="form-control" style="width: 200px;" type="text" readonly value="0" name="suppax" id="suppax" />
                                    </td>
                                    <td >
                                        <div class="pull-right">
                                            <input class="form-control" style="width: 200px;float:left;margin-right: 5px;" type="text" readonly value="0" name="supcost" id="supcost" />
                                            <span> <?php echo $bb["jn_currency"]?></span>
                                        </div>
                                    </td>
                                    <td>
                                        &nbsp;
                                    </td>
                            </tr>	
                            <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td class="text-center">
                                        <input class="form-control" style="width: 200px;border:none;box-shadow:none;background-color:transparent;" type="text" readonly value="" name="exppax" id="exppax" />
                                    </td>
                                    <td >
                                        <div class="pull-right">
                                            <input class="form-control" style="width: 200px; float:left;margin-right: 5px;border:none;box-shadow:none;background-color:transparent;text-align: right;color:#5E6267;" type="text" readonly value="" name="pricepax" id="pricepax" />
                                            <span > <?php echo $bb["jn_currency"]?> @pax</span>
                                        </div>
                                    </td>
                                    <td>
                                        &nbsp;
                                    </td>
                            </tr>									
                    </tbody>
                            <input type="hidden" name="pppax" id="pppax" value="<?php echo $tot_pax?>" />
            </table>
            </div>
        </div>
    </div>
</div>
        <!-- /.box-body -->
        <div class="box-footer text-right">
          <button class="btn btn-danger alt_btn" id="bus_all" name="bus_all">Confirm bus transportation for selected excursions</button>
        </div>
        <!-- /.box-footer-->
      </div>
    </div>
  </div>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
pageHighlightMenu = "backoffice/viewPlannedAllExcursions";    
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
	$("#bus_all").click(function(e){
		e.preventDefault();
		if($( "#s_exc_date" ).val()==""){
			alert("Select a date for excursion!");
			return false;
		}
		if(($("#suppax").val() - $("#pppax").val()) < 0){
			alert("Select more bus for pax involved in the excursion!");
			return false;
		}
		$("#allbuses").submit();
	});
  });
</script>