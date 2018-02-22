<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">
                <form action="<?php echo base_url(); ?>index.php/agents/insertTestataExcursion/<?php echo $bookId ?>" name="eeform" id="eeform" class="grid12" method="POST">
                    <div class="with-border">
                        <h4 class="box-title">Booking <?php echo $bookYear ?>_<?php echo $bookId ?> @ <?php echo $campusName ?></h4>
                    </div>
                    <div class="col-sm-3 col-md-2 col-lg-2">
                        <label for="center_select">
                                <strong>Select excursion</strong>
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
                        <input type="hidden" name="gl_select" value="all" id="gl_select" />
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <input id="readpax" class="btn btn-primary pull-right" type="button" value="Retrieve students for excursion and prices" name=readpax />
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
                    </div>
                    <div id="allstudents" style="border:0;"></div>
                    <div id="allprices" style="border:0;"></div>
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
    pageHighlightMenu = "agents/viewExtraExcursions/confirmed/id_book/desc";
    $(document).ready(function() {
        $("#ee_select").change(function(){
                $("#writeextra").attr("disabled","disabled");
                $("#allstudents").empty();
                $("#allprices").empty();
        });		
        $("#readpax").click(function(){
                if($("#ee_select").val()==""){
                        swal("Error","Select an excursion!");
                        return false;
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
                        url: "<?php echo base_url(); ?>index.php/agents/bestBusPriceForExcursion/"+$("#ee_select").val()+"/<?php echo $allNum ?>/<?php echo $stdNum ?>",
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
    });

</script>