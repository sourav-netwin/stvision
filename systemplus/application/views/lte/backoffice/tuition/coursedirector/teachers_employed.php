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
                    Please enter value for teacher, duration 'from date' - 'to date' and click search button to filter.
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
                                                <td class="center operation">
                                                    <a title="View" href="#" data-toggle="modal" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" data-id="dialog_modal_btn_<?php echo $contract["joc_id"]; ?>"  class="min-wd-24 dialogbtn btn btn-xs btn-primary" >
                                                        <span data-original-title="View" data-container="body" data-toggle="tooltip">
                                                            <i class="fa fa-eye"></i></span>
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
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
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
            $.post( "<?php echo base_url();?>index.php/tuitions/filterCDTeachers",{
                        'keyword':keyword,
                        'fromDate':fromDate,
                        'toDate':toDate
                    }, function( data ) {
                    $("#teachersDetailsDiv").html(data);
                    initDataTable();
            },'html');
        });

        $( "body" ).on( "click", "#btnClear", function() {
            $('#txtSearchText').val('');
            $('#txtCalFromDate').val('');
            $('#txtCalToDate').val('');
            $("#btnSearch").trigger('click');
        });

                
    });
</script>