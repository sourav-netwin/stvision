<section class="content">
    <div class="row">
                    <div class="col-md-4">
                    <!-- DIRECT SEARCH PRIMARY -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                        <h3 class="box-title">Booking id direct search</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="input-group">
                            <input id="searchBk" name="searchBk" type="text" class="form-control" >
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-flat" name="inviaBk" id="inviaBk" >Search booking</button>
                                </span>
                            </div>
                        </div>
                        <!-- /.box-footer-->
                    </div>
                    <!--/.direct-chat -->
                </div>
                <?php showSessionMessageIfAny($this);?>
                </div>
    <div class="row">
       <div class="col-md-12">
        <form id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/backoffice/overviewBookingsNew" method="post">
          <div class="box box-primary">
<!--            <div class="box-header with-border">
              <h3 class="box-title">Sales</h3>
            </div>-->
            <!-- /.box-header -->
            <!-- /.box-body -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mr-bot-10 mr-top-10">
                        <label >Campus:</label>
                        <div class="box-tools pull-right sort-text">
                            <a href="javascript:void(0);" id="s_USA">USA</a> -
                            <a href="javascript:void(0);" id="s_UK">UK</a> -
                            <a href="javascript:void(0);" id="s_EUR">EUR</a> -
                            <a href="javascript:void(0);" id="s_all">All</a> -
                            <a href="javascript:void(0);" id="s_none">None</a>
                        </div>
                    </div>
                </div>
                <div class="row mr-bot-10">
                    <div class="col-sm-3">
                        <?php
                        $contaCentri = 0;
                        foreach ($centri as $key => $item) {
                            $contaCentri++;
                            ?>
                                <input type="checkbox" autocomplete="off" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="centri[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"> <label class="normal" for="c_<?php echo  $item['id']; ?>"><?php echo $item['nome_centri'] ?></label><br />
                            <?php

                            if ($contaCentri % 5 == 0) {
                                ?>
                            </div>
                            <div class="col-sm-3">
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="mr-bot-10 mr-top-10">
                        <label for="season">Season / Agency</label>
                        </div>
                        <div class="mr-bot-10" >
                        <select class="form-control mr-bot-10" name="season" id="season">
                            <?php for ($y = 2014; $y <= date("Y") + 1; $y++) { ?>
                                    <option <?php if ($season == $y) { ?>selected <?php } ?>value="<?php echo $y ?>"><?php echo $y ?> season</option>
                            <?php } ?>
                        </select>
                        <input type="text" name="ag_complete" id="ag_complete" class="form-control ui-autocomplete-input" autocomplete="off" >
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="mr-bot-10 mr-top-10">
                            <label>Bookings status:</label>
                            <div class="box-tools pull-right sort-text">
                                <a href="javascript:void(0);" id="bk_all">All</a> -
                                <a href="javascript:void(0);" id="bk_none">None</a>
                            </div>
                        </div>
                        <div class="mr-bot-10" >
                            <input class="chStatus" type="checkbox" name="status[]" id="s_confirmed" value="confirmed"> <label for="s_confirmed" class="normal" >Confirmed</label><br />
                                <input class="chStatus" type="checkbox" name="status[]" id="s_active" value="active"> <label for="s_active" class="normal" >Active</label><br />
                                <input class="chStatus" type="checkbox" name="status[]" id="s_elapsed" value="elapsed"> <label for="s_elapsed" class="normal" >Elapsed</label><br />
                                <input class="chStatus" type="checkbox" name="status[]" id="s_tbc" value="tbc"> <label for="s_tbc" class="normal" >To Be Confirmed</label><br />
                                <input class="chStatus" type="checkbox" name="status[]" id="s_rejected" value="rejected"> <label for="s_rejected" class="normal" >Rejected</label><br />
                        </div>
                    </div>
                    <div class="col-sm-3">
                            <div class="mr-bot-10 mr-top-10">
                                <label>Bookings flag</label>
                                <div class="box-tools pull-right sort-text">
                                    <a href="javascript:void(0);" id="flg_all">All</a> -
                                    <a href="javascript:void(0);" id="flg_none">None</a>
                                </div>
                            </div>
                            <div class="mr-bot-10">
                                <input class="chFlag" type="checkbox" name="flag[]" id="f_lm" value="lm"> <label for="f_lm" class="normal" >Last Minute</label><br />
                                <input class="chFlag" type="checkbox" name="flag[]" id="f_cfd" value="cfd"> <label for="f_cfd" class="normal" >Cleared for Departure</label><br />
                                <input class="chFlag" type="checkbox" name="flag[]" id="f_rlock" value="rlock"> <label for="f_rlock" class="normal" >Locked Rosters</label><br />
                            </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <input id="inviaO" name="inviaO" type="button" value="Retrieve bookings" class="btn btn-primary pull-right">
            </div>
            <!-- /.box-footer-->
          </div>
            <input name="agenzia_in" id="idAgente" value="" type="hidden" />
          <!--/.direct-chat -->
        </form>
    </div>
    </div>
</section>

<div id="dialog_modal_retrive_data" data-backdrop="static" class="modal">
    <div class="modal-dialog modal-lg-95-per">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Bookings detail
                    <button aria-label="Close" onclick="$('#dialog_modal_retrive_data').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div id="retriveDataDiv" class="modal-body">
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_retrive_data').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<input type="hidden" value="0" id="hiddPageNumber" />
<style>
    .ui-widget-content{
        overflow: auto;
        max-height: 170px;
    }
</style>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE; ?>custom/backoffice.js"></script>
<script>
    function iCheckInit(){
        $('input.chCentri').iCheck('destroy');
        $('input.chStatus').iCheck('destroy');
        $('input.chFlag').iCheck('destroy');
        $('input.chCentri').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
        $('input.chStatus').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
        $('input.chFlag').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
    }

    var SITE_PATH = "<?php echo base_url();?>";

    $(document).ready(function() {
        iCheckInit();

        $.fn.myFunction = function(){
            var centri = [];
            $("input.chCentri:checked").each(function(){
                centri.push($(this).val());
            });
        }


        //$(".chCentri").change(function(){
        $('.chCentri').on('ifChanged', function(event){
            $.fn.myFunction();
        });


        $("#s_USA").click(function(){
            $("input.chCentri").each(function(){
                $(this).iCheck("uncheck");
            });
            $("input.sel_USD").each(function(){
                $(this).iCheck("check");
            });
            $.fn.myFunction();
        });

        $("#s_UK").click(function(){
            $("input.chCentri").each(function(){
                $(this).iCheck("uncheck");
            });
            $("input.sel_GBP").each(function(){
                $(this).iCheck("check");
            });
            $.fn.myFunction();
        });

        $("#s_EUR").click(function(){
            $("input.chCentri").each(function(){
                $(this).iCheck("uncheck");
            });
            $("input.sel_EUR").each(function(){
                $(this).iCheck("check");
            });
            $.fn.myFunction();
        });
        $("#s_all").click(function(){
            $("input.chCentri").each(function(){
                $(this).iCheck("check");
            });
            $.fn.myFunction();
        });

        $("#s_none").click(function(){
            $("input.chCentri").each(function(){
                $(this).iCheck("uncheck");
            });
        });
        $("#bk_all").click(function(){
                $("input.chStatus").each(function(){
                        $(this).iCheck("check");
                });
        });

        $("#bk_none").click(function(){
                $("input.chStatus").each(function(){
                        $(this).iCheck("uncheck");
                });
        });
        $("#flg_all").click(function(){
                $("input.chFlag").each(function(){
                        $(this).iCheck("check");
                });
        });

        $("#flg_none").click(function(){
                $("input.chFlag").each(function(){
                        $(this).iCheck("uncheck");
                });
        });

        <?php
        if ($pStatus == "tbc") {
            ?>
                $("input.chCentri").each(function(){
                        //$(this).attr("checked",true);
                        $(this).iCheck("check");
                });
                //$("#s_<?php //echo $pStatus ?>").attr("checked",true);
                $("#s_<?php echo $pStatus ?>").iCheck("check");
            <?php
        }
        ?>


        $("#inviaBk").click(function(e){
                e.preventDefault();
                var bookingId = $("#searchBk").val();
                loadBookingDetail(bookingId);
        });

        $('body').on('click',"#backToList",function(e){
                e.preventDefault();
				console.log("back");
                $('#dialog_modal_retrive_data').modal('hide');
				$('#viewDashboardDetailModal').modal('hide');
                //$("#inviaO").trigger('click');
                // Reset datatable pagination to the last page which was selected.
                var pageNum = $("#hiddPageNumber").val();
                //data-dt-idx
                setTimeout(function(){
                    $(".pageContainer li a[data-dt-idx="+pageNum+"]").click();
                },700);
        });


        $("#ag_complete").autocomplete({
                source: function (request, response) {
                        // request.term is the term searched for.
                        // response is the callback function you must call to update the autocomplete's
                        // suggestion list.
                        $.ajax({
                                url: "getAgenciesForAutoComplete/"+request.term,
                                dataType: "json",
                                success: response,
                                error: function () {
                                        response([]);
                                }
                        });
                }
        });

        /* SEARCH BY BOOKING ID */
        $("#ag_complete").on("autocompleteselect", function (e, ui) {
                e.preventDefault();
                $("#idAgente").val(ui.item.id);
                this.value = ui.item.label;
        });


        // REPORTS - BY FILTERS
        $('#inviaO').on('click', function(e){
            var centriChecked = $('input.chCentri:checked').length;
            var statusChecked = $('input.chStatus:checked').length;
            if(centriChecked==0){
                swal("Error","Please, select one or more campus!");
                return false;
            }else{
                if(statusChecked==0){
                    swal("Error","Please, select one or more status!");
                    return false;
                }
            }
            if($("#ag_complete").val()==""){
                $("#idAgente").val("");
            }
            e.preventDefault();
            passingData = $('#box_campus').serialize();

            $.get( "<?php echo base_url();?>index.php/backoffice/overviewBookingsDetailNew/?"+passingData, function( data ) {
                $("#retriveDataDiv").html('');
                $("#dialog_modal_retrive_data").modal("show");
                $("#retriveDataDiv").html(data);
            });
            setTimeout(function(){
                unloading();
            },3000);
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
<script type="text/javascript">
    $('[data-toggle="tooltip"]').tooltip();
        $('body').on('click','.viewRefBook',function(){
            $("#hiddPageNumber").val($(".pageContainer li.active a").attr('data-dt-idx'));
        arrRef=$(this).attr("id").split("_");
            idRef=arrRef[1];
            $.get( "<?php echo base_url();?>index.php/backoffice/newAvail/"+idRef+"/"+arrRef[2], function( data ) {
          $("#retriveDataDiv").html('');
          $("#retriveDataDiv").html(data);
          $('.tooltip').hide();

        });
      });
//Pax editing
        $('body').on('click','.visaControl',function(){
    //$('.visaControl').click(function(){
            if(confirm("Are you sure you want to toggle Visas availability for this booking? If you enable them (the icon will become green), the agent will be able to print Visas!"))
            {
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
            }
            else
            {
                return false;
            }
    });
</script>