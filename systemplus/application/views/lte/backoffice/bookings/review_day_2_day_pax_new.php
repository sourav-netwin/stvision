<?php
    $monthnames = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
?>
<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<style>
    @media only screen and (max-width: 400px) {
        #btn_modal_dialog_export {
            margin-right: 9px;
        }
    }
</style>
<section class="content">
    <div class="row">
        <form id="searchAll" name="searchAll" action="<?php echo base_url(); ?>index.php/backoffice/new_reviewday2day_pax_new" method="post"> 
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Select campus</h3>
                    </div>
                    <div class="box-body" >  
                        <select name="centri" class="form-control" id="centricampus">
                            <?php
                            foreach ($centri as $key => $item) {
                                //echo "<br />--->".$campus."---".$item['id']."<---";
                                ?>
                                <option <?php if ($campus == $item['id']) { ?>selected <?php } ?>value="<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Select month</h3>
                    </div>
                    <div class="box-body" >
                        <select name="month_in" class="form-control" id="month_in">
                            <option <?php if ($month == 1) { ?>selected <?php } ?>value="1">January</option>
                            <option <?php if ($month == 2) { ?>selected <?php } ?>value="2">February</option>
                            <option <?php if ($month == 3) { ?>selected <?php } ?>value="3">March</option>
                            <option <?php if ($month == 4) { ?>selected <?php } ?>value="4">April</option>
                            <option <?php if ($month == 5) { ?>selected <?php } ?>value="5">May</option>
                            <option <?php if ($month == 6) { ?>selected <?php } ?>value="6">June</option>
                            <option <?php if ($month == 7) { ?>selected <?php } ?>value="7">July</option>
                            <option <?php if ($month == 8) { ?>selected <?php } ?>value="8">August</option>
                            <option <?php if ($month == 9) { ?>selected <?php } ?>value="9">September</option>
                            <option <?php if ($month == 10) { ?>selected <?php } ?>value="10">October</option>
                            <option <?php if ($month == 11) { ?>selected <?php } ?>value="11">November</option>
                            <option <?php if ($month == 12) { ?>selected <?php } ?>value="12">December</option>
                        </select> 									
                    </div>
                </div>
            </div>	
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Select year</h3>
                    </div>
                    <div class="box-body" >
                        <select name="year_in" class="form-control" id="year_in">
                            <?php
                            for ($annino = 2012; $annino <= date("Y"); $annino++) {
                                ?>
                                <option <?php if ($year == $annino) { ?>selected <?php } ?>value="<?php echo $annino ?>"><?php echo $annino ?></option>
                                <?php
                            }
                            ?>
                        </select> 								
                    </div>
                </div>
            </div>	
            <div class="col-lg-3 col-md-4 col-sm-6 mr-bot-5">			
                <input type="button" class="btn btn-primary" name="inviaRic" id="inviaRic" value="Search" />
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $campusname?> - <?php echo $monthnames[$month] ?> <?php echo $year ?></h3>
                    </div>
                    <div id="dettDAY" style="display:none;overflow-y:scroll;"></div>
                    <div class="box-body" style="overflow-y: auto;">
<!--                <div class="tabletools">
                            <div class="left"></div>
                            <div class="right"></div>
                    </div>					-->
                    <table class="table table-bordered table-hover table-striped vertical-middle"> <!-- OPTIONAL: with-prev-next -->
                            <thead>
                                    <tr>
                                            <th>Day</th>
                                            <th>Date</th>
                                            <th>In</th>
                                            <th>Out</th>
                                            <th>Standard</th>
                                            <th>Ensuite</th>
                                            <th>Homestay</th>
                                            <th>Transfers</th>
                                            <th>Planned</th>
                                            <th>Extra</th>
                                            <th>On campus today</th>
                                    </tr>
                            </thead>
                            <tbody>
                            <?php 
                                    //print_r($num_transfers);
                                    $daycount = 1;
                                    foreach($bkgmesestandard as $key=>$book){
                                    $classeRiga = "riga_dispari";
                                    $octoday = 0;
                                    $da=explode("-",$book["datat"]);
                                    $dow = date ("l", strtotime($book["datat"]));
                                    $octoday += $book["n_confirmed"] + $bkgmeseensuite[$key]["n_confirmed"] + $bkgmesehomestay[$key]["n_confirmed"];
                                    if($daycount % 2){
                                            $classeRiga = "riga_pari";
                                    }
                            ?>
                                    <tr class="<?php echo $classeRiga ?>">
                                        <td class="center" style="<?php if($dow=="Sunday"){ ?>color:#c00;<?php } ?>"><?php echo substr($dow,0,3)?></td>
                                        <td class="center" style="<?php if($dow=="Sunday"){ ?>color:#c00;<?php } ?>"><?php echo $daycount?> <?php echo substr($monthnames[$month],0,3)?> <?php echo $da[0]?></td>
                                        <td class="center" ><?php if($book["num_in"] > 0){ ?>
                                            <a href="javascript:void(0);" class="btn btn-xs openDoorPaxList" id="od_<?php echo $book["datat"] ?>">
                                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/door-open-in_green.png">
<!--                                                <i class="fa fa-sign-in"></i>-->
                                                <span ><?php echo $book["num_in"] ?></span>
                                            </a>
                                            <?php }else{ ?>&nbsp;<?php } ?>
                                        </td>
                                        <td class="center" ><?php if($book["num_out"] > 0){ ?>
                                            <a href="javascript:void(0);" class="btn btn-xs closeDoorPaxList" id="cd_<?php echo $book["datat"] ?>">
                                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/door-open-out_red.png">
<!--                                                <i class="fa fa-sign-out"></i>-->
                                                <span ><?php echo $book["num_out"];?></span>
                                            </a><?php }else{ ?>&nbsp;<?php } ?></td>
                                        <td class="center" ><?php if($book["n_confirmed"]  > 0){ ?>
                                            <a data-toggle="tooltip" title="<?php echo date("d/m/Y",strtotime($book["datat"])) ?> - Standard" class="btn btn-xs openDayDetail" id ="opendetail_<?php echo $book["datat"] ?>_1" href="javascript:void(0);">
                                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/user-medium.png">
<!--                                                <i class="fa fa-user"></i>-->
                                                <span ><?php echo $book["n_confirmed"] ?></span>
                                            </a><?php }else{ ?>&nbsp;<?php } ?>
                                        </td>
                                        <td class="center" ><?php if($bkgmeseensuite[$key]["n_confirmed"]  > 0){ ?>
                                            <a data-toggle="tooltip" title="<?php echo date("d/m/Y",strtotime($bkgmeseensuite[$key]["datat"])) ?> - Ensuite" class="btn btn-xs openDayDetail" id ="opendetail_<?php echo $book["datat"] ?>_2" href="javascript:void(0);">
                                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/user-share.png">
<!--                                                <i class="fa fa-user"></i>-->
                                                <span><?php echo $bkgmeseensuite[$key]["n_confirmed"] ?></span>
                                            </a><?php }else{ ?>&nbsp;<?php } ?>
                                        </td>
                                        <td class="center" ><?php if($bkgmesehomestay[$key]["n_confirmed"] > 0){ ?>
                                            <a data-toggle="tooltip" title="<?php echo date("d/m/Y",strtotime($bkgmesehomestay[$key]["datat"])) ?> - Homestay" class="btn btn-xs openDayDetail" id ="opendetail_<?php echo $book["datat"] ?>_3" href="javascript:void(0);">
                                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/home-medium.png">
<!--                                                <i class="fa fa-user"></i>-->
                                                <span ><?php echo $bkgmesehomestay[$key]["n_confirmed"] ?></span>
                                            </a><?php }else{ ?>&nbsp;<?php } ?>
                                        </td>
                                        <td class="center" ><?php if($num_transfers[$key] > 0){ ?>
                                            <a href="javascript:void(0);" class="btn btn-xs TransfersPaxList" id="tra_<?php echo $book["datat"] ?>">
                                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/transfer_plane.png">
<!--                                                <i class="fa fa-user"></i>-->
                                                <span><?php echo $num_transfers[$key] ?></span>
                                            </a>
                                            <?php }else{ ?>&nbsp;<?php } ?>
                                        </td>
                                        <td class="center" ><?php if($num_excursions[$key] > 0){ ?>
                                            <a href="javascript:void(0);" class="btn btn-xs ExcursionsPaxList" id="exc_<?php echo $book["datat"] ?>">
                                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bus_excursion.png">
<!--                                                <i class="fa fa-user"></i>-->
                                                <span><?php echo $num_excursions[$key] ?></span>
                                            </a><?php }else{ ?>&nbsp;<?php } ?>
                                        </td>
                                        <td class="center" ><?php if($num_extra_excursions[$key] > 0){ ?>
                                            <a href="javascript:void(0);" class="btn btn-xs ExtraExcursionsPaxList" id="excExtra_<?php echo $book["datat"] ?>">
                                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bus_excursion.png">
<!--                                                <i class="fa fa-user"></i>-->
                                                <span><?php echo $num_extra_excursions[$key] ?></span>
                                            </a><?php }else{ ?>&nbsp;<?php } ?>
                                        </td>
                                        <td class="center" >
                                            <?php if($octoday > 0){ ?>
                                            <a href="javascript:void(0);" data-toggle="tooltip" class="btn btn-xs allPaxList"  title="View students list" id="od_<?php echo $book["datat"] ?>">
                                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/edit-list-order.png">
<!--                                                <i class="fa fa-list-ol"></i>-->
                                            </a>
                                            <a href="javascript:void(0);" data-toggle="tooltip" class="btn btn-xs allBookList"  title="View bookings list" id="od_<?php echo $book["datat"] ?>">
                                                <img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/applications-stack.png">
<!--                                                <i class="fa fa-list-alt"></i>-->
                                            </a>
                                            <span >
                                                <?php echo $octoday ?></span><?php 
                                                }
                                                else
                                                { ?>&nbsp;<?php } ?>
                                        </td>
                                    </tr>
                            <?php
                                    $daycount++;
                            }
                            ?>
                            </tbody>
                    </table>	
            </div>
            </div>
    </div>
    </div>
<!--    <div style="display: none;overflow:scroll;width:800px;" id="" title="" class="windia"></div>				-->
    <div id="dialog_modal" data-backdrop="static" class="modal">
        <div class="modal-dialog modal-lg-95-per">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pax List | Booking detail  (Please set orientation to LANDSCAPE before print!)
                        <button aria-label="Close" onclick="$('#dialog_modal').modal('hide');" class="close" type="button">
                            <span aria-hidden="true">×</span></button>
                    </h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button  onclick="$('#dialog_modal').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
                    <button  onclick="$('#dialog_modal table').printElement();"  class="btn btn-primary pull-right" type="button">Print</button>
                    <button  id="btn_modal_dialog_export"  class="btn btn-primary pull-right" type="button">Export as Excel file</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
<!--    <div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_tra" title="Transfers | Bus codes details" class="windia_tra"></div>						-->
    <div id="dialog_modal_tra" data-backdrop="static" class="modal">
        <div class="modal-dialog modal-lg-95-per">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Transfers | Bus codes details
                        <button aria-label="Close" onclick="$('#dialog_modal_tra').modal('hide');" class="close" type="button">
                            <span aria-hidden="true">×</span></button>
                    </h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button  onclick="$('#dialog_modal_tra').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    
<!--    <div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_exc" title="Planned Excursions | Bus codes details" class="windia_exc"></div>					-->
    <div id="dialog_modal_exc" data-backdrop="static" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Planned Excursions | Bus codes details
                        <button aria-label="Close" onclick="$('#dialog_modal_exc').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                    </h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button  onclick="$('#dialog_modal_exc').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    
    
<!--    <div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_exc_extra" title="Extra Excursions | Bus codes details" class="windia_exc_extra"></div>	-->
    <div id="dialog_modal_exc_extra" data-backdrop="static" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Extra Excursions | Bus codes details
                        <button aria-label="Close" onclick="$('#dialog_modal_exc_extra').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                    </h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button  onclick="$('#dialog_modal_exc_extra').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    
    <input type="hidden" value="" name="hidDate" id="hidDate" />
    <input type="hidden" value="" name="typeForCsv" id="typeForCsv" />
    <input type="hidden" value="" name="accoForCsv" id="accoForCsv" />
</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>js/jquery.browser.min.js"></script> 
<script src="<?php echo base_url();?>js/jquery.printElement.min.js"></script>	
<script>
                $("#btn_modal_dialog_export").click(function(){
                    var myHidDate = $("#hidDate").val();
                    var myTypeForCsv = $("#typeForCsv").val();
                    var myAccoForCsv = $("#accoForCsv").val();
                    window.location.href = '<?php echo base_url(); ?>index.php/backoffice/csvArrivalPax_pax/<?php echo $campus ?>/'+myAccoForCsv+'/'+myHidDate+'/confirmed/'+myTypeForCsv;
                });
                
		
//		$( ".windia_tra" ).dialog({
//				autoOpen: false,
//				modal: true,
//				buttons: [{
//					text: "Close",
//					click: function() { $(this).dialog("close"); }
//				}],
//				height : 500,
//				width: 800
//		});		
		
		$( ".windia_exc" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}],
				height : 500,
				width: 800
		});	

		$( ".windia_exc_extra" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}],
				height : 500,
				width: 800
		});			
			
		$(".openDoorPaxList").click(function(){
				$("#hidDate").val('');
				$("#accoForCsv").val('all');	
				$("#typeForCsv").val('arrival');
				$("#dialog_modal .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];	
				$("#hidDate").val(bydate);
				$("#dialog_modal .modal-body").load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/'+bydate+'/confirmed/arrival/<?php echo $campus ?>');
                                $("#dialog_modal").modal('show');
				return false;			
		});		

		$(".closeDoorPaxList").click(function(){
				$("#hidDate").val('');	
				$("#accoForCsv").val('all');
				$("#typeForCsv").val('departure');				
				$("#dialog_modal .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];	
				$("#hidDate").val(bydate);				
				$( "#dialog_modal .modal-body" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/'+bydate+'/confirmed/departure/<?php echo $campus ?>');
                                $("#dialog_modal").modal('show');
				return false;			
		});	

		$(".allPaxList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('');	
				$("#accoForCsv").val('');				
				$("#dialog_modal .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$("#hidDate").val(bydate);	
				$("#accoForCsv").val('all');				
				$( "#dialog_modal .modal-body" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/'+bydate+'/confirmed/all/<?php echo $campus ?>');
                                $("#dialog_modal").modal('show');
				return false;			
		});	

		$(".openDayDetail").click(function(){
				$("#hidDate").val('');	
				$("#accoForCsv").val('all');	
				$("#typeForCsv").val('');				
				$("#dialog_modal .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
				var bytd = $(this).attr("id");
				//alert(bytd);
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$("#hidDate").val(bydate);	
				var byacco = splitbytd[2];
				$("#accoForCsv").val(byacco);
				//alert('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/'+splitbytd[2]+'/'+bydate+'/confirmed/');
				$( "#dialog_modal .modal-body" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/'+splitbytd[2]+'/'+bydate+'/confirmed/all/<?php echo $campus ?>');
                                $("#dialog_modal").modal('show');
				return false;			
		});		

		$(".TransfersPaxList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('');	
				$("#accoForCsv").val('');				
				$("#dialog_modal_tra .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$( "#dialog_modal_tra .modal-body" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_getTransfersBusCodesForDay/'+bydate+'/<?php echo $campus ?>');
                                $("#dialog_modal_tra").modal('show');
				return false;			
		});	
		
		$(".ExcursionsPaxList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('');	
				$("#accoForCsv").val('');				
				$("#dialog_modal_exc .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$( "#dialog_modal_exc .modal-body" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_getExcursionsBusCodesForDay/'+bydate+'/<?php echo $campus ?>');
                                $("#dialog_modal_exc").modal('show');
				return false;			
		});		

		$(".ExtraExcursionsPaxList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('');	
				$("#accoForCsv").val('');				
				$("#dialog_modal_exc_extra .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$( "#dialog_modal_exc_extra .modal-body" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_getExtraExcursionsBusCodesForDay/'+bydate+'/<?php echo $campus ?>');
                                $("#dialog_modal_exc_extra").modal('show');
				return false;			
		});			
	
		
		$(".allBookList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('');	
				$("#accoForCsv").val('');				
				$("#dialog_modal .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$("#hidDate").val(bydate);	
				$("#accoForCsv").val('all');				
				$( "#dialog_modal .modal-body" ).load('<?php echo base_url(); ?>index.php/backoffice/infoday2day/<?php echo $campus ?>/all/'+bydate+'/confirmed');
                                $("#dialog_modal").modal('show');
				return false;			
		});	

		$("#inviaRic").click(function(){
			$("#searchAll").submit();
		});
		
</script>