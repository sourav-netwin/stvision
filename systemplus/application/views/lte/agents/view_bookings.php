<style>
    table tbody tr:nth-child(2n+1) td.n_confirmed,
    table tbody tr:nth-child(2n) td.n_confirmed{
            background-color:#9c9;
    }

    table tbody tr:nth-child(2n+1) td.n_active,
    table tbody tr:nth-child(2n) td.n_active{
            background-color:#ff9;
    }

    table tbody tr:nth-child(2n+1) td.n_elapsed,
    table tbody tr:nth-child(2n) td.n_elapsed{
            background-color:#f96;
    }

    table tbody tr:nth-child(2n+1) td.n_tbc,
    table tbody tr:nth-child(2n) td.n_tbc{
            background-color:#69f;
    }

    table tbody tr:nth-child(2n+1) td.n_rejected,
    table tbody tr:nth-child(2n) td.n_rejected{
            background-color:#f99;
    }
    
    
table tbody tr:nth-child(2n) td.pdf-create span,
table tbody tr:nth-child(2n) td.pdf-create-printed span, 
table tbody tr:nth-child(2n) td.pdf-create-payed span,
table tbody tr:nth-child(2n+1) td.pdf-create span,
table tbody tr:nth-child(2n+1) td.pdf-create-printed span, 
table tbody tr:nth-child(2n+1) td.pdf-create-payed span {
margin:0 auto;
display: block;
width: 30px;
height: 30px;
background: transparent url() center center no-repeat;
text-indent: -9999px;
}

table tbody tr:nth-child(2n) td.pdf-create span,
table tbody tr:nth-child(2n+1) td.pdf-create span{
	background-image:url('<?php echo base_url();?>img/added/pdf-create.png');
}

table tbody tr:nth-child(2n) td.pdf-create-printed span,
table tbody tr:nth-child(2n+1) td.pdf-create-printed span{
	background-image:url('<?php echo base_url();?>img/added/pdf-create-printed.png');
}
table tbody tr:nth-child(2n) td.pdf-create-payed span,
table tbody tr:nth-child(2n+1) td.pdf-create-payed span{
        background-image:url('<?php echo base_url();?>img/added/pdf-create-payed.png');
}
.ui-datepicker {
  font-size: smaller;
}
</style>
<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<link href="<?php echo base_url();?>css/added.css" rel="stylesheet">  
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header with-border col-sm-12  mr-bot-10">
            <h4 class="box-title">Bookings</h4>
            <div class="box-tools pull-right">
                <a style="float:right;" href="<?php echo base_url(); ?>downloads/extras/guide_for_insert_list_vision.pdf" target="_blank" data-toggle="tooltip" title="Guide for insert pax list"><i class="fa fa-info-circle"> How to insert your pax lists</i></a>
            </div>
        </div>
        <div class="box-body">
            <div class="row mr-bot-10">
                <div class="col-sm-6 btn-create">
                    <a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>index.php/agents/enrol"><i class="fa fa-plus"> Enrol new group</i></a>
                </div>
                <?php showSessionMessageIfAny($this);?>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    
            <table class="datatable table table-bordered table-striped" style="width: 99.98%;"> 
                <thead>
                        <tr>
                                <th>Booking id</th>
                                <th>Date in</th>								
                                <th>Date out</th>
                                <th>Weeks</th>
                                <th>Campus</th>
                                <th>Pax</th>
                                <th>Status</th>
                                <th class="depCol no-sort">Deposit invoice</th>	
                                <th class="paxCol no-sort">Pax list</th>
                                <th class="no-sort">VISA</th>
                        </tr>
                </thead>
                <tbody>
                        <?php
                        foreach ($all_books as $book) {
                                $da = explode("-", $book["arrival_date"]);
                                $dd = explode("-", $book["departure_date"]);
                                $ds = explode("-", $book["data_scadenza"]);
                                $accos = $book["all_acco"];
                                ?>
                                <tr>
                                    <td class="center">
                                        <a title="View booking detail" data-toggle="tooltip" href="javascript:void(0);" id="dialog_modal_btn_<?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?>" class="dialogbtn btn btn-xs btn-info">[View]</a> 
                                            <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?>
                                            <div style="display: none;" id="dialog_modal_<?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?>" title="Booking detail - <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?> - <?php echo $book["centro"] ?>">
                                                    <p><strong>Date in: </strong><?php echo $da[2] ?>/<?php echo $da[1] ?>/<?php echo $da[0] ?><br /><strong>Date out: </strong><?php echo $dd[2] ?>/<?php echo $dd[1] ?>/<?php echo $dd[0] ?></p>
                                                    <p><strong>Weeks: </strong><?php echo $book["weeks"] ?></p>
                                                    <p><strong>Accommodations</strong></p>
                                                    <p>
                                                    <ul>
                                                            <?php
                                                            if($accos)
                                                            foreach ($accos as $acco) {
                                                                    $tipo = $acco -> tipo_pax;
                                                                    $accom = $acco -> accomodation;
                                                                    $contot = $acco -> contot;
                                                                    //print_r($acco);
                                                                    ?>
                                                                    <li><strong><?php echo $tipo ?>: </strong><?php echo $accom ?>(<?php echo $contot ?>)</li>
                                                                    <?php
                                                            }
                                                            ?>
                                                    </ul>
                                                    </p>
                                            </div>
                                    </td>
                                    <td class="center"><?php echo $da[2] ?>/<?php echo $da[1] ?>/<?php echo $da[0] ?></td>
                                    <td class="center"><?php echo $dd[2] ?>/<?php echo $dd[1] ?>/<?php echo $dd[0] ?></td>
                                    <td class="center"><?php echo $book["weeks"] ?></td>
                                    <td><?php echo $book["centro"] ?></td>
                                    <td class="center"><?php echo $book["tot_pax"] ?></td>
                                    <?php
                                    switch ($book["status"]) {
                                            case 'tbc':
                                                    $statob = "To be confirmed";
                                                    break;
                                            default:
                                                    $statob = ucfirst($book["status"]);
                                                    break;
                                    }
                                    ?>
                                    <td class="n_<?php echo $book["status"] ?>"><?php echo $statob ?><?php if ($book["status"] == "active") { ?> until <?php echo isset($ds[2]) ? $ds[2] : '' ?>/<?php echo isset($ds[1]) ? $ds[1] : '' ?>/<?php echo isset($ds[0]) ? $ds[0] : '' ?><?php } ?></td>
                                    <?php if ($book['status'] != 'active' and $book['status'] != 'confirmed') { ?>
                                            <td class="center depCol">-</td>
                                            <?php
                                    }
                                    else {
                                            if ($book['acconto_versato'] > 0) {
                                                    ?>
                                                    <td class="pdf-create-payed center depCol">
                                                        <a target="_blank" data-toggle="tooltip" href= "<?php echo base_url(); ?>index.php/agents/invoice_pdf/<?php echo $book ['id_book']; ?>" title="Print deposit invoice"><span>Print deposit invoice</span></a></td>
                                                    <?php
                                            }
                                            else {
                                                    if ($book['print_1'] > 0) {
                                                            ?>	
                                                            <td class="pdf-create-printed center depCol"><a target="_blank" href= "<?php echo base_url(); ?>index.php/agents/invoice_pdf_no_acconto/<?php echo $book ['id_book']; ?>" data-toggle="tooltip"  title="Print deposit invoice"><span>Print deposit invoice</span></a></td>
                                                            <?php }
                                                    else {
                                                            ?>
                                                            <td class="pdf-create center depCol"><a target="_blank" href= "<?php echo base_url(); ?>index.php/agents/invoice_pdf_no_acconto/<?php echo $book ['id_book']; ?>" data-toggle="tooltip"  title="Print deposit invoice"><span>Print deposit invoice</span></a></td>
                                                            <?php }
                                                    ?>
                                                            <?php }
                                                    ?>
                                            <?php } ?>
                                    <td class="center paxCol">
                                            <?php
                                            if ($book['status'] == 'confirmed') {
                                                    if ($book['lockPax'] == 0) {
                                                            ?>
                                                            <a id="compile_<?php echo $book ['id_year']; ?>_<?php echo $book ['id_book']; ?>" class="btn btn-xs btn-info insertPaxList" data-href="<?php echo base_url(); ?>index.php/agents/editPaxList/<?php echo $book ['id_year']; ?>/<?php echo $book ['id_book']; ?>" title="Insert pax details" data-toggle="tooltip" ><i class="fa fa-list"></i></a>
                                                            <?php /* <a target="_blank" data-gravity="s" id="compile_<?php echo $book ['id_year']; ?>_<?php echo $book ['id_book']; ?>" class="button small grey tooltip insertPaxList" href="<?php echo base_url(); ?>index.php/agents/editPaxList/<?php echo $book ['id_year']; ?>/<?php echo $book ['id_book']; ?>" original-title="Insert pax details" style="margin-left:0;"><i class="icon-th-list"></i></a> */ ?>
                                                            <?php
                                                    }
                                                    else {
                                                            ?>
                                                            <img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/tick-button.png" class="icon">
                                                            <?php
                                                    }
                                            }
                                            else {
                                                    echo "-";
                                            }
                                            ?>									
                                    </td>
                                            <td class="center">	

                                                    <a href="javascript:void(0)" data-toggle="tooltip"  title="VISA details" class="visaPopup" data-id="<?php echo $book["id_book"] ?>" style="margin-left:0;"><i class="glyphicon glyphicon-new-window"></i></a>

                                            </td>
                                </tr>
    <?php
    }
    ?>
                </tbody>
        </table>
                </div>
            </div>
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
    <div class="col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <h4 class="box-title"><i class="fa fa-info-circle"> Status label</i></h4>
            </div>
            <div class="box-body">
                <div class="alert note sticky no-margin-bottom">
                        <ul class="legenda">
                                <li><span class="li-tbc">To be confirmed</span>Your booking has been submitted and is waiting for confirmation by Head Office</li>
                                <li><span class="li-active">Active</span>We have reserved spaces for your group and these will be valid until the expiration date shown</li>
                                <li><span class="li-confirmed">Confirmed</span>Your booking is now confirmed and the deposit has being cleared</li>
                                <li><span class="li-elapsed">Elapsed</span>No deposit was received before the expiration date given</li>
                                <li><span class="li-rejected">Rejected</span>Your booking can not be accepted. Please contact a sales representative</li>
                        </ul>
                </div>
            </div>
            <div class="box-footer"></div>
        </div>
    </div>
</div>
<div id="dialog_modal_view" data-backdrop="static" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="modal-title-span"></span>
                    <button aria-label="Close" onclick="$('#dialog_modal_view').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_view').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--<div style="overflow:scroll;"  title="" class="windiaList"></div>	-->
<div id="dialog_modal" data-backdrop="static" class="modal">
    <div class="modal-dialog modal-lg-95-per">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pax List | Booking detail
                    <button aria-label="Close" onclick="$('#dialog_modal').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body" >
            </div>
            <div class="modal-footer">
                <button id="btnCloseAndSendData" class="buttonSendPax btn btn-primary pull-left" type="button">Close and send data (No more changes allowed!)</button>
                <button id="btnCloseAndSaveDraft" class="btn btn-primary pull-right" type="button">Close and save draft</button>
                <button id="btnCopyCommonData" class="btn btn-primary pull-right" type="button">Copy common data from first line</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="dialog_modal_booking_detail" class="modal">
    <div class="modal-dialog modal-lg-95-per">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Booking detail
                    <button aria-label="Close" onclick="$('#dialog_modal_booking_detail').modal('hide');window.location.reload();" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body" >
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_booking_detail').modal('hide');window.location.reload();"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="dialog_modal_booking_detail_visa" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="dmbdv_title">Booking detail</span>
                    <button aria-label="Close" onclick="$('#dialog_modal_booking_detail_visa').modal('hide');$('body').addClass('modal-open');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body" >
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_booking_detail_visa').modal('hide');$('body').addClass('modal-open');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<style>
	.valBorder{
		border:1px solid red;
	}
</style>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
	$(document).ready(function() {
            $(".dialogbtn").on('click',function(){
                var id = $(this).attr('id');
                var modalId = id.replace('_btn', '');
                $("#modal-title-span").html($("#"+modalId).attr('title'));
                $("#dialog_modal_view .modal-body").html($("#"+modalId).html());
                $("#dialog_modal_view").modal('show');
            });
            
            
            $(document).on('click',"#btnCopyCommonData",function(e){
                    $('#copyFirst').trigger('click');
            });
            $(document).on('click',"#btnCloseAndSaveDraft",function(e){
                    $("#noChanges").val("NOSEND");
                    $("#postaPax").submit(); 
            });
			$("body").on('blur',".reqField",function(e){
				if($(this).val() != "")
					$(this).removeClass("valBorder");
			});
            $("body").on('click',"#btnCloseAndSendData",function(e){
					$(".reqField").removeClass("valBorder");
                    var campiVuoti = 0;	
                    $(".reqField").each(function(){
                            if($(this).val().length==0){
                                    //swal("Error",$(this).attr("id"));
                                    campiVuoti++;
                            }
                    });	
                    if(campiVuoti==0){
                            if(confirm("Are you sure you want to confirm pax data? No more changes will be allowed after you send them!")){					
                                    $("#noChanges").val("SEND");
                                    $("#postaPax").submit(); 
                            }else{
                                    return void(0);
                            }
                    }else{
                            swal("Error","Please fill-in all fields in the roster! ("+campiVuoti+" more fields needed)");
							$(".reqField").each(function(){
								if($(this).val().length==0){
									$(this).addClass("valBorder");
								}
							});	
                            return void(0);
                    }
            });
            
            $(document).on('click',".insertPaxList",function(e){
			e.preventDefault();
			var bytd = $(this).attr("id");
			var splitbytd = bytd.split("_");
			var idYear = splitbytd[1];	
			var idBook = splitbytd[2];
			$.ajax({
				url: siteUrl + 'agents/checkPaxLock',
				type: 'POST',
				data: {
					bookId: idBook,
					yearId: idYear
				},
				success: function(data){
					if(data == '1'){
						$("#dialog_modal .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');
						$("#dialog_modal .modal-body").load('<?php echo base_url(); ?>index.php/agents/editPaxList/'+idYear+'/'+idBook);
                                                $("#dialog_modal").modal('show');
						return false;	
					}
					else{
						swal("Error",'Roster locked. Can not modify records');
						return false;	
					}
				},
				error: function(){
					swal("Error",'Failed to complete action');
					return false;	
				}
			});
						
		});
	});
	$('.visaPopup').on('click', function(e){
		var elm = $(this);
		var bookId = elm.attr('data-id');
		if(bookId != '' && typeof bookId != 'undefined'){
			$.ajax({
				url: siteUrl + 'agents/bookingExists',
				type: 'POST',
				data: {
					bookId: bookId
				},
				success: function(response){
					if(response==1){
						e.preventDefault();
						$("#dialog_modal_booking_detail .modal-body").html("");
						$.get(siteUrl + "agents/getVisaPopupDetails/"+bookId,function(data){
						   $("#dialog_modal_booking_detail .modal-body").html(data);
						   $("#dialog_modal_booking_detail").modal('show');
						});
						
					}else{
						swal("Error","This booking id doesn't exists!");
					}
				},
				error: function(){
					swal("Error","This booking id doesn't exists!");
				}
			});
		}
	});
        
</script>