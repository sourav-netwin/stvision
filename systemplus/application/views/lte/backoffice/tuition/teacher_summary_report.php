<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<section class="">
    <?php
    $CI = &get_instance();
    $campusArrayForGraph = array();
    $campusArray = array();
    ?>		
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                Report
            </h3>
            <div class="pull-right">
                <input id="backToFilter" class="export-button btn btn-primary" type="button" value="Back" />
                <input id="exportExcel" <?php echo (empty($resultData) ? 'disabled' : '');?> class="export-button btn btn-primary" type="button" value="Export" />
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        
        <!-- Here goes the content. -->
        <div class="row">
            <div class="col-sm-12" id="report-view">
                <table class="datatable table table-bordered table-striped vertical-middle" width="99.9%" >
                    <thead>
                            <tr>
                                <th>Campus</th>
                                <th>Teacher</th>		
                                <th>Start date (contract)</th>
                                <th>End date (contract)</th>
                                <th>Hours per week</th>
                                <th>Total work hours</th>
                                <th>Actual work hours&nbsp;<i class="glyphicon glyphicon-ok"></i></th>
                                <th>Number of lessons</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($resultData){
                                foreach($resultData as $record){
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo $record["nome_centri"];?></td>
                                        <td class="center"><?php echo $record['teach_first_name']." ".$record['teach_last_name'];?></td>
                                        <td class="center"><?php echo date("d/m/Y",strtotime($record["teach_from_date"]));?></td>
                                        <td class="center"><?php echo date("d/m/Y",strtotime($record["teach_to_date"]));?></td>
                                        <td class="center"><?php echo $record["joc_hourperweek_range"];?></td>
                                        <td class="center"><?php echo round($record["duration"],2);?></td>
                                        <td class="center"><?php echo round($record["actual_worked_hours"],2);?></td>
                                        <td class="center"><?php echo $record["number_of_lesson"];?></td>
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
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer-->
    </div>
</section>
<script src="<?php echo LTE;?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    var SITE_PATH = siteUrl;
    var pageHighlightMenu = "tuitionsreports/teachers";
    $(document).ready(function() {
        $("#exportExcel").click(function(){
           var exportForm = $('<form method="post" action="'+SITE_PATH + "tuitionsreports/summary/export"+'"></form>').appendTo('body');
           exportForm.append("<input type='hidden' name='campuses' value='<?php  echo (empty($campusIds) ? '' : implode(',', $campusIds));?>' />");
           exportForm.append("<input type='hidden' name='fd' value='<?php echo $fd;?>' />");
           exportForm.append("<input type='hidden' name='td' value='<?php echo $td;?>' />");
           exportForm.append("<input type='hidden' name='type' value='export' />");
           exportForm.submit();
        });
        
        $("#backToFilter").click(function(){
            window.location.href= SITE_PATH + "tuitionsreports/teachers";
        });
    });
</script>