<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <?php 
    $agdett = $agente[0];
    ?>
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Bookings list - <? echo $agdett["businessname"] ?> - <? echo $agdett["businesscountry"] ?></h4>
            </div>
            <div class="box-body">
                <?php showSessionMessageIfAny($this);
                ?>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table id="customDataTable" class="datatable table table-bordered table-striped"> <!-- OPTIONAL: with-prev-next -->
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Date in</th>								
                                    <th>Date Out</th>
                                    <th>Weeks</th>
                                    <th>Campus</th>
                                    <th>Pax</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($all_books as $book) {
                                    $da = explode("-", $book["arrival_date"]);
                                    $dd = explode("-", $book["departure_date"]);
                                    $accos = $book["all_acco"];
                                    ?>
                                    <tr>
                                        <td class="center"><a href="javascript:void(0);" data-year="<?php echo $book["id_year"]; ?>" data-status="<?php echo $book["status"]; ?>" data-bk-checked="<?php echo $book["flag_elapsed"];?>" data-elapsed-note="<?php echo $book["flag_elapsed_comment"];?>" data-bk-id="<?php echo $book["id_book"] ?>" id="dialog_modal_btn_<?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?>" class="dialogbtn">[View]</a> <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?>
                                            <div style="display: none;" id="dialog_modal_<?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?>" title="Booking detail - <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?> - <?php echo $book["centro"] ?>" >
                                                <p><strong>Date in: </strong><?php echo $da[2] ?>/<?php echo $da[1] ?>/<?php echo $da[0] ?><br /><strong>Date out: </strong><?php echo $dd[2] ?>/<?php echo $dd[1] ?>/<?php echo $dd[0] ?></p>
                                                <p><strong>Weeks: </strong><?php echo $book["weeks"] ?></p>
                                                <p><strong>Accomodations</strong></p>
                                                <p>
                                                <ul>
                                                    <?php
                                                    foreach ($accos as $acco) {
                                                        $tipo = $acco->tipo_pax;
                                                        $accom = $acco->accomodation;
                                                        $contot = $acco->contot;
                                                        //print_r($acco);
                                                        ?>
                                                        <li><strong><?php echo $tipo ?>: </strong><?php echo $accom ?>(<?php echo $contot ?>)</li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                                </p>
                                            </div></td>
                                        <td class="center"><?php echo $da[2] ?>/<?php echo $da[1] ?>/<?php echo $da[0] ?></td>
                                        <td class="center"><?php echo $dd[2] ?>/<?php echo $dd[1] ?>/<?php echo $dd[0] ?></td>
                                        <td class="center"><?php echo $book["weeks"] ?></td>
                                        <td><?php echo $book["centro"] ?></td>
                                        <td class="center"><?php echo $book["tot_pax"] ?></td>
                                        <td class="n_<?php echo $book["status"] ?>"><?php echo $book["status"] ?><?php if ($book["status"] == "active") { ?> scadenza<?php } ?><?php if ($book["status"] == "elapsed" && $book["flag_elapsed"] == 1) { echo " (checked)";}?></td>
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
<div id="dialog_modal_id" data-backdrop="static" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="modal-title-span"></span>
                    <button aria-label="Close" onclick="$('#dialog_modal_id').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div id="modal-body-custom" class="modal-body">
                
            </div>
            <div id="elapsedCheckedDiv" class="modal-body">
                <div class="row">
                    <!-- Elapsed flag -->
                    <div class="col-md-6 mr-top-10">
                        <label class="text-danger">
                        <input type="checkbox" id="chkElapsedChecked" value="1" />    
                        Elapsed checked</label><br />
                        <input type="text" class="form-control" id="txtElapsedNote" name="txtElapsedNote" value="" />
                    </div>
                    <div class="col-md-2 mr-top-10 text-center">
                        <button type="button" style="margin-top:25px;" class="btn btn-primary" id="btnElapsedMarked" >Mark elapsed note</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dialog_modal_id').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var pageHighlightMenu = "agents/listAgents";
    $(document).ready(function() {
        $( ".dialogbtn" ).click(function() {
            var iddia = $(this).attr("id").replace('_btn','');
            //alert(iddia.replace('_btn',''));
            //$( "#"+iddia ).dialog("open");
            var title = $( "#"+iddia ).attr('title');
            var bkId =  $(this).attr('data-bk-id');
            var year =  $(this).attr('data-year');
            var bkStatus =  $(this).attr('data-status');
            
            if(bkStatus == "elapsed")
            {
                $("#elapsedCheckedDiv").show();
                $("#btnElapsedMarked").attr('data-id',bkId);
                $("#btnElapsedMarked").attr('data-year',year);
                var elapsedNote = $(this).attr('data-elapsed-note');
                var elapsedFlag = $(this).attr('data-bk-checked');
                $("#txtElapsedNote").val(elapsedNote);
                if(parseInt(elapsedFlag))
                {
                    $("#chkElapsedChecked").prop('checked',true);
                    disableElapsedChecked(true);
                }
                else
                {
                    $("#chkElapsedChecked").prop('checked',false);
                    disableElapsedChecked(false);
                }
            }
            else
                $("#elapsedCheckedDiv").hide();
            $("#dialog_modal_id #modal-body-custom").html($( "#"+iddia ).html());
            $("#dialog_modal_id .modal-title-span").html(title);
            $("#dialog_modal_id").modal('show');
            return false;
        });
        
        $("#btnElapsedMarked").on( "click", function() 
        {
            var id = $(this).attr('data-id');
            var year = $(this).attr('data-year');
            var elapsedNote = $("#txtElapsedNote").val();
            var elapsedChecked = $("#chkElapsedChecked").prop('checked');
            if(elapsedChecked && elapsedNote != ""){
                $.post(siteUrl + "backoffice/updateElapsedMarkedNote",
                    {'id':id,'elapsedNote':elapsedNote,'elapsedChecked':elapsedChecked},function(data){
                        if(data.result){
                            swal("Success","Booking elapsed note updated.");
                            $("#dialog_modal_btn_"+year+"_"+id).attr('data-elapsed-note',elapsedNote);
                            if(elapsedChecked)
                                elapsedChecked = 1;
                            else
                                elapsedChecked = 0;
                            $("#dialog_modal_btn_"+year+"_"+id).attr('data-bk-checked',elapsedChecked);
                        }
                    },'json');
            }else{
                swal("Warning","Please mark checkbox as checked and enter note text.");
            }
        });
        
    });
    function disableElapsedChecked(dis){
        if(dis){
            $("#txtElapsedNote").attr('disabled','disabled');
            $("#chkElapsedChecked").attr('disabled','disabled');
            $("#btnElapsedMarked").attr('disabled','disabled'); 
        }
        else
        {
            $("#txtElapsedNote").removeAttr('disabled');
            $("#chkElapsedChecked").removeAttr('disabled');
            $("#btnElapsedMarked").removeAttr('disabled');
        }
    }
    
</script>
<style>
    .table tbody tr:nth-child(2n+1) td.n_confirmed, .table tbody tr:nth-child(2n) td.n_confirmed {
    background-color: #9c9;
}
.table tbody tr:nth-child(2n+1) td.n_active, .table tbody tr:nth-child(2n) td.n_active {
    background-color: #ff9;
}
.table tbody tr:nth-child(2n+1) td.n_elapsed, .table tbody tr:nth-child(2n) td.n_elapsed {
    background-color: #f96;
}
.table tbody tr:nth-child(2n+1) td.n_tbc, .table tbody tr:nth-child(2n) td.n_tbc {
    background-color: #69f;
}
.table tbody tr:nth-child(2n+1) td.n_rejected, .table tbody tr:nth-child(2n) td.n_rejected {
    background-color: #f99;
}
</style>