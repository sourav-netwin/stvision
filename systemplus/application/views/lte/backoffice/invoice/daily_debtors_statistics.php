<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
    <div class="row">
        <div class="col-md-12">
            <?php showSessionMessageIfAny($this); ?>
            <form id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/invoice/debtorsstatistics" method="post">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="selCampus">
                                    <span class="text">Campus:</span>
                                </label>
                                <select class="form-control required" id="selCampus" name="selCampus"  >
                                    <option value="">Select Campus</option>
                                    <?php 
                                    if($contaCentri){
                                        foreach ($contaCentri as $campus){
                                            ?><option <?php echo ($campusId == $campus['id'] ? 'selected="selected"' : "");?> value="<?php echo $campus['id'];?>"><?php echo $campus['nome_centri'];?></option><?php 
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>
                                    <span class="text">From date:</span>
                                </label>
                                <input class="form-control" type="text" id="txtCalFromDate" name="txtCalFromDate" value="<?php echo $calFromDate;?>" />
                            </div>
                            <div class="col-sm-4">
                                <label>
                                    <span class="text">To date:</span>
                                </label>
                                <input class="form-control" type="text" id="txtCalToDate" name="txtCalToDate" value="<?php echo $calToDate;?>" />
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input id="getReport" type="submit" value="Get Report" class="btn btn-primary pull-right">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="exportExcelWrapper text-right"></div>
                </div>
                <div class="box-body scrollx">
                    <table class="table table-hovered table-bordered table-striped" id="reportTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Invoices Total</th>
                                <th>Cashed Total</th>
                                <th>Overdue Total</th>
                                <th>Ageing</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($reportData)) {
                                    foreach ($reportData as $report) { 
                            ?>
                                    <tr>
                                        <td><a href="#" data-toggle="tooltip" title="<?php echo $report['gr_bookings'];?>"><?php echo $report['today_date'] ?></a></td>
                                        <td><?php echo $report['total_cost'] ?></td>
                                        <td><?php echo $report["pfp_import"]; ?></td>
                                        <td><?php echo $report["overdue"]; ?></td>
                                        <td>-</td>
                                    </tr>
                                    
                            <?php }
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
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

    var SITE_PATH = "<?php echo base_url(); ?>";
    $(document).ready(function () {
        
        
    });
</script>