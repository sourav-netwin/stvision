<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<section class="">
    <div class="row">
    
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);?>
            </div>
            <div id="priority-box" class="row" >
                <div class="col-sm-3">
                    <label for="selCampus">Campus:</label>
                    <select class="form-control" id="selCampus" autocomplete="off" name="selCampus"  >
                        <option value="">Select Campus</option>
                        <?php
                        if (!empty($campuses)) {
                            foreach ($campuses as $campus) {
                                ?>
                                <option value="<?php echo $campus['id'] ?>"><?php echo $campus['nome_centri'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="selPosition">Position:</label>
                    <select class="form-control" id="selPosition" autocomplete="off" name="selPosition"  >
                        <option value="">Select Position</option>
                        <?php
                        if (!empty($positions)) {
                            foreach ($positions as $position) {
                                ?>
                                <option value="<?php echo $position['pos_id'] ?>"><?php echo $position['pos_position'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="txtCalFromDate">From date:</label> 
                    <input autocomplete="off" class="form-control" type="text" id="txtCalFromDate" name="fd" value="<?php echo $fromDate;?>" />
                </div>
                <div class="col-sm-3">
                    <label for="txtCalToDate">To Date:</label> 
                    <input autocomplete="off"  class="form-control" type="text" id="txtCalToDate" name="td" value="<?php echo $toDate;?>" />
                </div>
                <div class="col-sm-6 mr-top-10">
                    <input class="btn btn-primary" type="button" value="Show / Reload" id="btnReload" />
                    <input class="btn btn-danger" type="button" value="Clear" id="btnClear" />
                </div>

            </div>
        </div>
        <div class="box-body">
            <table style="width: 100%;" id="dataTableStaffPriority" class="datatable table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Campus</th>
                        <th>Position</th>
                        <th>Applicant name</th>
                        <th>Email</th>
                        <th>Available from</th>								
                        <th>Available to</th>
                        <th class="col-text-numeric">Priority</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($contractdata)) {
                            foreach ($contractdata as $contract) {
                            ?>
                            <tr>
                                <td><?php echo $contract["nome_centri"]; ?></td>
                                <td><?php echo $contract["pos_position"]; ?></td>
                                <td><?php echo $contract['ta_firstname'] . ' ' . $contract['ta_lastname']; ?></td>
                                <td><?php echo $contract["joc_email"]; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></td>
                                <td  class="text-center">
                                    <input type="text" data-id="<?php echo $contract["joc_id"];?>" autocomplete="off" onkeypress="return keyRestrict(event,'1234567890');" class="priorityText form-control" value="<?php echo $contract['joc_staff_priority'];?>" maxleght="5" />
                                </td>
                            </tr>
                            <?php
                    }
            }
            ?>
            </tbody>
                <tfoot>
                    <tr>
                        <th>Campus</th>
                        <th>Position</th>
                        <th>Applicant name</th>
                        <th>Email</th>
                        <th>Available from</th>								
                        <th>Available to</th>
                        <th>Priority</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
      </div>
    </div>
</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>

    $(document).ready(function() {
            var loadingImg = "<span class='imgLoading loadingSpan' style='float:right;position:absolute;'><img  src='<?php echo base_url().'img/tuition/throbber.gif'?>' /></span>"
            var saveAlert = "<span class='saveAlert loadingSpan' style='float:right;position:absolute;color:green;'><i class='glyphicon glyphicon-ok'></i></span>"

            $( "body" ).on( "blur", ".priorityText", function() {
                var con_id = $(this).attr('data-id');
                var priority = $(this).val();
                var thisEle = $(this);
                thisEle.parent().append(loadingImg);
                $.post( "<?php echo base_url();?>index.php/staff/changepriority",{
                        'con_id':con_id,
                        'priority':priority
                    }, function( data ) {
                        //$("#btnReload").trigger('click');
                        thisEle.parent().find(".imgLoading").replaceWith(saveAlert);
                        thisEle.parent().find(".saveAlert").fadeOut(4500);
                });
            });

            $( "body" ).on( "click", "#btnReload", function() {
                var campus = $('#selCampus').val();
                var position = $('#selPosition').val();
                var fromDate = $("#txtCalFromDate").val();
                var toDate = $("#txtCalToDate").val();
                $.post( "<?php echo base_url();?>index.php/staff/contract_ajax",{
                            'campus':campus,
                            'position':position,
                            'fromDate':fromDate,
                            'toDate':toDate
                        }, function( data ) {
                    oTable.clear();
                    oTable.rows.add(data);
                    oTable.draw();
                    $("#data-grid tr td").addClass('center');
                    $("#data-grid tr td:last-child").addClass('operation');
                },'json');
            });

            $( "body" ).on( "click", "#btnClear", function() {
                $('#selCampus').val('');
                $('#selPosition').val('');
                $('#txtCalFromDate').val('<?php echo $fromDate;?>');
                $('#txtCalToDate').val('<?php echo $toDate;?>');
                $("#selCampus").trigger("liszt:updated");
                $("#selPosition").trigger("liszt:updated");
                $("#btnReload").trigger('click');
            });

            $( "#txtCalFromDate" ).datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,		  
                    dateFormat: "dd/mm/yy",		
                    numberOfMonths: 1,
                    onClose: function( selectedDate ) {
                            $(".txtCalFromDate").val(selectedDate);
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
                                $(".txtCalToDate").val(selectedDate);
                                $( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
                        }
            });
            
                
            
    });
        
</script>