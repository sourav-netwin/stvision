<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-md-12">
        <form id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/setUnplannedAllExcursions" method="post">  
            <div class="box box-primary">
                <div class="box-body">
                    <h4 class="box-title" class="col-sm-12">Book excursions</h4>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <label >Select campus</label>
                            <div class="form-data">
                                <select name="centri" class="form-control" id="centricampus">
                                    <?php foreach ($centri as $key => $item) { ?>
                                        <option <?php if ($campus == $item['id']) { ?>selected <?php } ?>value="<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?></option>
                                    <?php }
                                    ?>
                                </select> 
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <label>Select excursion type</label>
                            <div class="form-data">
                                <select class="form-control" name="tipo" id="tipo">
                                    <option <?php if ($tipo == "planned") { ?>selected <?php } ?>value="planned">Included</option>
                                </select> 		
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="button" name="transpmi" id="transpmi" class="btn btn-primary mr-top-10" value="Search" />
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    &nbsp;
                </div>
                <!-- /.box-footer-->
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <h4 class="box-title">Book excursions</h4>
                <div class="row">
                    <div class="col-sm-12">
                        <form name="allexcu" id="allexcu" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/setAllExcursionTransport">
                            <table class="datatable table table-bordered table-striped" style="width:99.98%;">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Dates</th>
                                        <th>Agency</th>									
                                        <th>Excursion</th>								
                                        <th>Pax</th>
                                        <th class="no-sort">Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($all_excursions as $exc){
                                    ?>
                                        <tr>
                                                <td class="text-center n_<?php echo $exc["statopre"]?>">
                                                        <span class="idofbook"><?php echo $exc["pte_book_id"]?></span>
                                                </td>
                                                <td class="text-center"><font style="color:#009900;clear:both;display:block;"><?php echo date("d/m/Y",strtotime($exc["arrival_date"]))?></font><font style="color:#990000;clear:both;display:block;"><?php echo date("d/m/Y",strtotime($exc["departure_date"]))?></font></td>
                                                <td><?php echo $exc["businessname"]?>
                                                    <font style="font-weight:bold;display:block;clear:both;"><?php echo $exc["myglname"]?></font><?php if($exc["pte_fromCampusManagerTick"]==1){ ?><font style="color:red">Booked by Campus Manager</font><br />Amount received: <?php echo $exc["pte_fromCampusManagerAmount"] ?> <?php echo $exc["pte_proforma_currency"] ?><?php } ?></td>
                                                <td><?php echo $exc["exc_excursion"]?><font style="font-weight:bold;display:block;clear:both;"><?php echo ucfirst($exc["exc_length"])?></font></td>									
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                    <a class="allPaxes btn btn-xs btn-info" data-toggle="tooltip" href="<?php echo base_url(); ?>index.php/backoffice/getAllExcursionsPaxFromExcID/<?php echo $exc["pte_id"]?>" name="GL and students included in the excursion <?php echo $exc["exc_excursion"]?>" title="View students included in the excursion <?php echo $exc["exc_excursion"]?>" >
                                                        <i class="fa"><?php echo $exc["pte_tot_pax"]?></i>
                                                    </a>
                                                    </div>
                                                </td>
                                                <td class="text-center containcheck">
                                                    <input type="checkbox" name="excur_<?php echo $exc["pte_id"] ?>" value="<?php echo date("d-m-Y",strtotime($exc["arrival_date"]))?>_<?php echo date("d-m-Y",strtotime($exc["departure_date"]))?>_<?php echo $exc["exc_id"] ?>_<?php echo $exc["pte_tot_pax"] ?>" class="excn_<?php echo $exc["exc_id"] ?> chExcn" /></td>

                                        </tr>
                                <?php
                                        }
                                ?>
                                </tbody>
                                <input type="hidden" value="<?php echo $campus ?>" name="id_centro" id="id_centro" />
                            </table>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-danger pull-right" id="bus_all" name="bus_all" class="alt_btn">Set transportation for selected excursions</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dialog_modal_dettDAY" data-backdrop="static" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span id="popupName"></span>
                    <button aria-label="Close" onclick="$('#dialog_modal_dettDAY').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div id="modalBody" class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_dettDAY').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
	$('#transpmi').click(function(){
		$('#loading-data').show();
		$('#box_transport').submit();
	});
        $(".containcheck input").click(function(){
		var arrclassi = $(this).attr("class").split(" ");
		var arrid = arrclassi[0].split("_");
		//alert(arrid[1]);
		$(".containcheck input").attr("disabled",true);
		var classenable = "excn_"+arrid[1];
		//alert(classenable);
		$(".containcheck input."+classenable).each(function() {
			$(this).removeAttr("disabled");
		});
	});
	$("#bus_all").click(function(){
		var contacheck=0;
		$(".containcheck input").each(function() {
			if($(this).prop("checked")){
				if($(this).attr("disabled")!="disabled"){
					contacheck++;
				}
			}
		});
		if(contacheck > 0){
			$("#allexcu").submit();
		}else{
			alert("Select an excursion to book transfer!");
		}
	});
	//chExcn
		
        $('.allPaxes').click(function(e){
                e.preventDefault();
//                var dialog1 = $("#dettDAY").dialog({
//                        autoOpen: false,
//                        width: 800,
//                        modal: true,
//                        title: $(this).attr("name")
//                });
                $("#dialog_modal_dettDAY").modal('show');
                $("#modalBody").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');			
                var popupName = $(this).attr('name');
                $.post($(this).attr("href"),function(data){
                    $("#modalBody").html(data);
                    $("#popupName").html(popupName);
                    $("#modalBody table").removeAttr('style');
                    $("#modalBody table").addClass('table table-bordered table-striped');
                });
                
        });		
	
    });
</script>