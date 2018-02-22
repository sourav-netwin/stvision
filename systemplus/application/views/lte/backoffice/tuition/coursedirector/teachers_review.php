<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
    <div class="row">
    
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <div class="col-sm-6">
                
                </div>
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    Please enter teacher, duration 'from date' - 'to date' and click search button to filter.
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 form-group">
                    <label for="txtSearchText" class="control-label">Teacher</label>
                    <input type="text" class="form-control" id="txtSearchText" name="txtSearchText" value="" />
                </div>
                <div class="col-sm-3 form-group">
                    <label for="txtCalFromDate" class="control-label">From date</label>
                    <input type="text" class="form-control" readonly id="txtCalFromDate" name="fd" value="" />
                </div>
                <div class="col-sm-3 form-group">
                    <label for="txtCalToDate" class="control-label">To date</label>
                    <input class="form-control" type="text" readonly id="txtCalToDate" name="td" value="" /> 
                </div>
                <div class="col-sm-3 form-group mr-top-25">
                    <input id="btnSearch" class="btn btn-primary" type="submit" value="Search" >
                    <input id="btnClear" class="btn btn-danger" type="reset" value="Clear" >
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                        <div id="teachersDetailsDiv">
                            <table class="datatable table table-bordered table-striped vertical-middle" style="width:99.98%;" >
                                    <thead>
                                        <tr>
                                            <th>Teacher</th>
                                            <th>Date of birth</th>
                                            <th>From Date</th>								
                                            <th>To date</th>
                                            <th class="no-sort">Review & rating</th>
                                            <th class="no-sort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                            if (!empty($teachersData)) {
                                                    foreach ($teachersData as $contract) {
                                                    ?>
                                                    <div style="display: none;" id="dialog_modal_<?php echo $contract["joc_id"] ?>" title="<?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?>" > 
                                                        <div class="modal-header">
                                                            <h4><span class="modalTitle" >Teacher details as per contract</span>
                                                                <button aria-label="Close" onclick="$('#dialog_modal_teacher').modal('hide');" class="close" type="button">
                                                                <span aria-hidden="true">×</span></button>
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-3"><strong>Name:</strong></div>
                                                                <div class="col-sm-3"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></div>

                                                                <div class="col-sm-3"><strong>Email:</strong></div>
                                                                <div class="col-sm-3"><?php echo $contract["joc_email"]; ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-3"><strong>Campus:</strong></div>
                                                                <div class="col-sm-3"><?php echo $contract["nome_centri"]; ?></div>

                                                                <div class="col-sm-3"><strong>Position:</strong></div>
                                                                <div class="col-sm-3"><?php echo $contract["pos_position"]; ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-3"><strong>From date:</strong></div>
                                                                <div class="col-sm-3"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></div>

                                                                <div class="col-sm-3"><strong>To date:</strong></div>
                                                                <div class="col-sm-3"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-3"><strong>Hours per week:</strong></div>
                                                                <div class="col-sm-3"><?php echo $contract["joc_hourperweek_range"]; ?></div>

                                                                <div class="col-sm-3"><strong>Date of birth:</strong></div>
                                                                <div class="col-sm-3"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><span>Interview details</span></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-3"><strong>Interview notes:</strong></div>
                                                                <div class="col-sm-9"><?php echo htmlentities($contract['ta_interview_notes']); ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-3"><strong>Interview strong:</strong></div>
                                                                <div class="col-sm-9"><?php echo htmlentities($contract['ta_interview_strong']); ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-3"><strong>Interview weak:</strong></div>
                                                                <div class="col-sm-9"><?php echo htmlentities($contract['ta_interview_weak']); ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <tr>
                                                        <td class="center"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></td>
                                                        <td class="center"><?php echo ((empty($contract["ta_date_of_birth"]) || $contract["ta_date_of_birth"] == '0000-00-00 00:00:00') ? '' : date('d/m/Y', strtotime($contract["ta_date_of_birth"]))); ?></td>
                                                        <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></td>
                                                        <td class="center"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></td>
                                                        <td class="center"><div class="viewStar" id="viewfor_<?php echo $contract['joc_id'];?>" data-star="<?php echo $contract['rat_stars'];?>"></div></td>
                                                        <td class="center operation">
                                                            <a title="View" href="javascript:void(0);" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" data-id="dialog_modal_btn_<?php echo $contract["joc_id"]; ?>" class="min-wd-24 dialogbtn btn btn-xs btn-primary">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a title="Review & rating" href="javascript:void(0);" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" class="dialogstar min-wd-24 btn btn-xs btn-primary">
                                                                <i class="fa fa-star-o"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                            }
                                    }
                                    ?>
                                    </tbody>
                            </table>
                        </div>
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
    
    
    <div id="dialog_modal_teacher" data-backdrop="static" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="modal-data"></div>
                <div class="modal-footer">
                    <button  onclick="$('#dialog_modal_teacher').modal('hide');"  class="btn btn-default pull-left" type="button">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    <!-- review modal  -->
    <div id="dialog_modal_review" title="Teacher review & rating" data-backdrop="static" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><span>Teacher review & rating</span>
                        <button aria-label="Close" onclick="$('#dialog_modal_review').modal('hide');" class="close" type="button">
                        <span aria-hidden="true">×</span></button>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form action="" id="frmTeacherReview" class="validate" method="post">
                            <div class="row form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Mark star rating</label>
                                </div>
                                <div class="col-sm-9">
                                    <div id="formStar"></div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Notes</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea cols="5" rows="6" maxlength="250" id="txtReview" class="required form-control" name="txtReview"></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <input type="hidden" value="0" name="hidd_cont_id" id="hidd_cont_id" />
                                    <input type="hidden" value="0" name="hidd_teach_id" id="hidd_teach_id" />
                                    <input type="button" value="Submit" name="btnReview" id="btnReview" class="btn btn-primary">
                                    <input type="reset" value="Cancel" name="btnReviewCancel" id="btnReviewCancel" class="btn btn-danger">
                                    <div class="mr-top-10" id="reviewMessage"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button onclick="$('#dialog_modal_review').modal('hide');" class="btn btn-default pull-left" type="button">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var RATY_BASE_PATH = "<?php echo base_url();?>";
</script>
<script src="<?php echo base_url(); ?>js/raty/jquery.raty.js"></script>
<script>
    $(document).ready(function() {
        
        $(document).on('click', ".dialogbtn", function() {
            var iddia = $(this).attr("data-id").replace('_btn','');
            var modalTitle = $( "#"+iddia ).attr('title');
            var modalData = $( "#"+iddia ).html();
            $("#modal-data").html(modalData);
            $("#dialog_modal_teacher .modalTitle").html(modalTitle + ", Teacher details as per contract");
            $("#dialog_modal_teacher").modal('show');
            
            return false;
        });

        $( "#txtCalFromDate" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,		  
            dateFormat: "dd/mm/yy",		
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                $( "#txtCalToDate" ).datepicker( "option", "minDate", selectedDate );
            }
        });

        $( "#txtCalToDate" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,		  
            dateFormat: "dd/mm/yy",		
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                    $( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
            }
        });


        $( "body" ).on( "click", "#btnSearch", function() {
        var keyword = $('#txtSearchText').val();
        var fromDate = $('#txtCalFromDate').val();
        var toDate = $('#txtCalToDate').val();
        $.post( "<?php echo base_url();?>index.php/tuitions/ajaxFilterCDTeachersReview",{
                    'keyword':keyword,
                    'fromDate':fromDate,
                    'toDate':toDate
                }, function( data ) {
                $("#teachersDetailsDiv").html(data);
                //load raty
                $('.viewStar').each(function(e,ele){
                    var stars = $(ele).attr('data-star');
                    var id = $(ele).attr('id');
                    if(!parseInt(stars))
                        stars = 0;
                    if($("#"+id).html() == '')
                    $("#"+id).raty({readOnly:true,start:stars,hintList:[]});
                });
                initDataTable();
                // load popup
                //$("#dialog_modal_review").modal('show');
        },'html');
        });

        $( "body" ).on( "click", "#btnClear", function() {
        $('#txtSearchText').val('');
        $('#txtCalFromDate').val('');
        $('#txtCalToDate').val('');
        $("#btnSearch").trigger('click');
        });

        $("body").on('click', ".dialogstar", function() {
            $( "#dialog_modal_review" ).modal("show");
            var teach_id = $(this).attr('data-ta-id');
            var cont_id = $(this).attr('data-track-id');
            $("#hidd_cont_id").val(cont_id);
            $("#hidd_teach_id").val(teach_id);
            // load review on popup
            $("#btnReviewCancel").trigger('click');
            // end.
            return false;
        });

        $('#formStar').raty({hintList:[]});
        $('.viewStar').each(function(e,ele){
            var stars = $(ele).attr('data-star');
            var id = $(ele).attr('id');
            if(!parseInt(stars))
                stars = 0;
            if($("#"+id).html() == '')
                $("#"+id).raty({readOnly:true,start:stars,hintList:[]});
        });
        // load on pagination
        //$("body").on("click",".paginate_button a",function(){
        $(".paginate_button a").click(function(){
            $('.viewStar').each(function(e,ele){
                var stars = $(ele).attr('data-star');
                var id = $(ele).attr('id');
                if(!parseInt(stars))
                    stars = 0;
                if($("#"+id).html() == '')
                $("#"+id).raty({readOnly:true,start:stars,hintList:[]});
            });
        });
        // 


        // send user input
        $("body").on("click","#btnReview",function(){
            $("#reviewMessage").html('');
            $("#reviewMessage").removeClass('tuition_success');
            $("#reviewMessage").removeClass('tuition_error');
            var cont_id = $("#hidd_cont_id").val();
            var teach_id = $("#hidd_teach_id").val();
            var review = $("#txtReview").val();
            var r_stars = $("#frmTeacherReview [name=score]").val();
            if (review != '') {
                $.post( "<?php echo base_url();?>index.php/tuitions/teacherrating",{
                        'cont_id':cont_id,
                        'teach_id':teach_id,
                        'r_stars':r_stars,
                        'review':review
                    }, function( data ) {
                    $("#reviewMessage").html(data.message);
                    if(parseInt(data.result))
                    {
                        $("#reviewMessage").addClass('tuition_success');
                        $.fn.raty.click(r_stars, '#viewfor_'+cont_id);
                    }
                    else
                        $("#reviewMessage").addClass('tuition_error');
                },'json');
            }
            else{
                $("#reviewMessage").html("Please enter note.");
                $("#reviewMessage").addClass('tuition_error');
            }
        });
        //end
        $("body").on("click","#btnReviewCancel",function(){
            $("#reviewMessage").html('');
            $("#reviewMessage").removeClass('tuition_success');
            $("#reviewMessage").removeClass('tuition_error');
            $("#txtReview").val('');
            $.fn.raty.click(0, '#formStar');
            $("#frmTeacherReview [name=score]").val('')
            var cont_id = $("#hidd_cont_id").val();
            var teach_id = $("#hidd_teach_id").val();
            // load review on popup
                $.post( "<?php echo base_url();?>index.php/tuitions/getteacherreview",{
                    'cont_id':cont_id,
                    'teach_id':teach_id
                },function(data){
                    if(parseInt(data.result)){
                        var row = data.dataset;
                        $("#txtReview").val(row.rat_review_text);
                        $.fn.raty.click(row.rat_stars, '#formStar');
                    }
                },'json');
            // end.
        });
    });
</script>