<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Booking <?php echo $bookYear ?>_<?php echo $bookId ?> @ <?php echo $campusName ?></h4>
            </div>
            <div class="box-body">
                <?php 
                if(count($excursionsBooked) > 0){
                ?>
                <table class="table table-bordered table-striped">
                        <thead>
                                <tr>
                                        <th >Group leader</th>
                                        <th >Excursion</th>
                                        <th >Status</th>
                                        <th >Bus Code</th>
                                        <th >Date</th>
                                        <th class="no-sort">Actions</th>
                                </tr>
                        </thead>
                        <tbody>
                                <?php
                                        foreach($excursionsBooked as $eex){
                                ?>
                                <tr>
                                        <td ><?php echo $eex["glforthis"]?></td>
                                        <td ><?php echo $eex["escursione"]?></td>
                                        <td ><?php if($eex["pte_confirmed"]=="NO"){ echo "NOT CONFIRMED"; } else { echo $eex["pte_confirmed"]; }?></td>
                                        <td ><?php echo $eex["pte_buscompany_code"]?></td>
                                        <td ><?php if($eex["pte_excursion_date"]=="0000-00-00"){ echo "-";}else{echo date("d/m/Y",strtotime($eex["pte_excursion_date"]));}?></td>
                                        <td >
                                            <div class="btn-group">
                                                <?php if($eex["pte_confirmed"]=="NO"){ ?>
                                                <a href="<?php echo base_url(); ?>index.php/agents/removeAllExcursions/<?php echo $eex["pte_id"]?>/<?php echo $bookId ?>/<?php echo $campusId ?>/<?php echo $bookYear ?>" class="min-wd-24 btn btn-xs btn-danger removeEXC" >
                                                    <span data-original-title="Remove extra excursion <?php echo $eex["escursione"]?>" data-container="body" data-toggle="tooltip">
                                                        <i class="fa fa-trash"></i>
                                                    </span>
                                                </a>
                                                <?php } ?>
                                                <a href="<?php echo base_url(); ?>index.php/agents/getAllExcursionsPaxFromExcID/<?php echo $eex["pte_id"]?>/<?php echo $bookId ?>/<?php echo $campusId ?>/<?php echo $bookYear ?>" name="GL and students included in the excursion <?php echo $eex["escursione"]?>" class="min-wd-24 btn btn-xs btn-primary allPaxes" >
                                                    <span data-original-title="View students included in the excursion <?php echo $eex["escursione"]?>" data-container="body" data-toggle="tooltip">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                </a>
                                                <a target="_blank" href="<?php echo base_url(); ?>index.php/agents/printProFormaById/<?php echo $eex["pte_id"]?>/<?php echo $bookId ?>/<?php echo $campusId ?>/<?php echo $bookYear ?>" name="GL and students included in the excursion <?php echo $eex["escursione"]?>" class="min-wd-24 btn btn-xs btn-warning" name="Print excursion invoice" >
                                                    <span data-original-title="Print excursion invoice" data-container="body" data-toggle="tooltip">
                                                        <i class="fa fa-print"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </td>
                                </tr>
                                <?php
                                        }
                                ?>
                        </tbody>
                </table>
                <?php
                }else{
                ?>
                <table>
                        <tr><td>No extra excursion booked for booking <?php echo $bookYear ?>_<?php echo $bookId ?></td></tr>
                </table>							
                <?php
                }
                ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                &nbsp;
            </div>
            <!-- /.box-footer-->
        </div>
    </div>
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">
                <?php
                if($agentId==795){
                ?>
                <div class="box-header with-border">
                    <h4 class="box-title">Select group leader and excursion</h4>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-2 col-lg-2">
                        <label for="prod_select">
                                <strong>Group leader / All students</strong>
                        </label>
                    </div>
                    <div class="col-sm-9 col-md-6 col-lg-6">
                        <?php 

                                if(count($groupleaders) > 0){
                                ?>							
                                <select name=gl_select id=gl_select class="search required form-control" data-placeholder="Choose a group leader or all students">
                                        <option value=""></option>
                                        <option value="all">All students in this booking</option>
                                        <?php
                                        foreach($groupleaders as $gl){
                                        ?>
                                        <option value="<?php echo $gl["uuid"] ?>"><?php echo $gl["cognome"] ?> <?php echo $gl["nome"] ?></option> 
                                        <?php
                                        }
                                        ?>
                                </select>
                                <?php
                                }else{
                                ?>
                                <select name=gl_select id=gl_select class="search required" data-placeholder="Choose a group leader or all students">
                                        <option value="">No roster uploaded for this group</option>
                                </select>
                                <?php
                                }
                        ?>
                        </div>
                </div>
                <?php
                }else{
                ?>
                <input type="hidden" id="gl_select" name="gl_select" value="all" />
                <?php
                }
                ?>
                <div class="row">
                    <div class="col-sm-3 col-md-2 col-lg-2">
                        <label for="center_select">
                                <strong>Extra excursion</strong>
                        </label>
                    </div>
                    <div class="col-sm-9 col-md-6 col-lg-6">
                            <select name=ee_select id=ee_select class="search required form-control" data-placeholder="Choose an excursion">
                                    <option value="">Select excursion</option>
                                    <?php
                                    foreach($excursions as $exc){
                                    ?>
                                    <option value="<?php echo $exc["exc_id"] ?>"><?php echo ucfirst($exc["exc_length"]) ?> - <?php echo $exc["exc_excursion"] ?></option> 
                                    <?php
                                    }
                                    ?>								
                            </select>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <input class="btn btn-primary pull-right" id="readpax" type="button" value="Retrieve students for excursion" name=readpax />
            </div>
            <!-- /.box-footer-->
        </div>
    </div>
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">
                <form action="<?php echo base_url(); ?>index.php/agents/insertTestataExcursion/<?php echo $bookId ?>" name="eeform" id="eeform" class="grid12" method="POST">
                        <div class="with-border">
                            <h4 class="box-title">Group leader and students involved in extra excursion</h4>
                            <div id="allstudents" style="border:0;"></div>
                            <div id="allprices" style="border:0;"></div>
                        </div>
                        <div class="actions">
                            <div class="pull-right">
                                <input class="btn btn-primary" id="writeextra" type="button" value="Book excursion now" disabled=disabled name=writeextra />
                            </div>
                        </div>
                        <input type="hidden" name="passGL" id="passGL" value="" />
                        <input type="hidden" name="passEE" id="passEE" value="" />
                        <input type="hidden" name="passNUMSTD" id="passNUMSTD" value="" />
                        <input type="hidden" name="passPRICESTD" id="passPRICESTD" value="" />
                        <input type="hidden" name="passCURRENCY" id="passCURRENCY" value="" />
                        <input type="hidden" name="passCAMPUS" id="passCAMPUS" value="<?php echo $campusId ?>" />
                        <input type="hidden" name="passTYPE" id="passTYPE" value="extra" />
                        <input type="hidden" name="passBKID" id="passBKID" value="<?php echo $bookYear ?>_<?php echo $bookId ?>" />
                </form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                
            </div>
            <!-- /.box-footer-->
        </div>
    </div>
</div>
<div id="dettDAY" data-backdrop="static" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="title-replace"></span>
                    <button aria-label="Close" onclick="$('#dettDAY').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button  onclick="$('#dettDAY').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    pageHighlightMenu = "agents/bookExtraExcursions/confirmed/id_centro/asc";
    $(document).ready(function() {
        $("#gl_select").change(function(){
                    $("#writeextra").attr("disabled","disabled");
                    $("#allstudents").empty();
                    $("#allprices").empty();
            });
            $("#ee_select").change(function(){
                    $("#writeextra").attr("disabled","disabled");
                    $("#allstudents").empty();
                    $("#allprices").empty();
            });		
            $("#readpax").click(function(){
                    if($("#gl_select").val()==""){
                            swal("Error","Select a group leader or all students!");
                            return false;
                    }else{
                            $("#passGL").val($("#gl_select").val());
                    }
                    if($("#ee_select").val()==""){
                            swal("Error","Select an excursion!");
                            return false;
                    }else{
                            $("#passEE").val($("#ee_select").val());
                    }	
                    $("#allstudents").html('retrieving students ...');
                    $.ajax({
                            type: "POST",
                            data: "gluuid=" + $("#gl_select").val(),
                            url: "<?php echo base_url(); ?>index.php/agents/retrieveStudentsByGl/<?php echo $bookId ?>",
                            success: function(msg){
                                    if (msg != ''){
                                            $("#allstudents").html(msg).show();
                                            $("#writeextra").attr("disabled",false);
                                    }
                                    else{
                                            $("#allstudents").html('<em>No item results</em>');
                                    }
                            }
                    });	
                    $.ajax({
                            type: "POST",
                            //data: "gluuid=" + $("#gl_select").val(),
                            url: "<?php echo base_url(); ?>index.php/agents/bestBusPriceForExcursion/"+$("#passEE").val()+"/<?php echo $allNum ?>/<?php echo $stdNum ?>",
                            success: function(msg){
                                    if (msg != ''){
                                            arrMsg = msg.split("___");
                                            $("#passNUMSTD").val(arrMsg[0]);
                                            $("#passPRICESTD").val(arrMsg[1]);
                                            $("#passCURRENCY").val(arrMsg[2]);
                                            $("#allprices").html("<p style='margin-left:15px;'><b>Price per pax (only Students): <font style='color:#f00;'>"+arrMsg[1]+" "+arrMsg[2]+"</font></b></p>").show();
                                    }
                                    else{
                                            $("#allprices").html('<em>No prices retrieved</em>');
                                    }
                            }
                    });				
            });
            $("#writeextra").click(function(){
                    $("#eeform").submit();
            });
            $(".removeEXC").click(function(e){
                    //e.preventDefault();
                    if(confirm("Are you sure you want to remove this excursion?")){
                            return true;
                    }else{
                            return false;
                    }
            });	

            $('.allPaxes').click(function(e){
                    e.preventDefault();
                    $("#dettDAY").modal('show');
                    $("#dettDAY .title-replace").html($(this).attr("name"));			
                    $("#dettDAY .modal-body").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />');			
                    $("#dettDAY .modal-body").load($(this).attr("href"));
            });	
    });

</script>