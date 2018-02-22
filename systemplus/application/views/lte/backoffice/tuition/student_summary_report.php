<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<section class="">
    <?php
    $CI = & get_instance();
    $campusArrayForGraph = array();
    $campusArray = array();
    $noRec = 0;
    if($resultData)
        $noRec = 1;
    ?>		
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <?php if(isset($bookingId)){?>
                    <span style="font-weight: bold;margin-bottom: 5px;padding-left: 2px;">Report for the booking id: <?php echo $bookingId;?></span>
                <?php }else{?>
                    <span style="font-weight: bold;margin-bottom: 5px;padding-left: 2px;">Report for the duration: <?php echo $fd;?> to <?php echo $td;?></span>
                <?php }?>
            </h3>
            <div class="pull-right">
                <input id="backToFilter" class="export-button btn btn-primary" type="button" value="Back" />
                <input id="exportExcel" <?php echo ($noRec ? "" : "disabled='disabled'");?> class="export-button btn btn-primary" type="button" value="Export" />
                <?php 
                    if(isset($error_message))
                        showSessionMessageIfAny($CI,'error',$error_message);
                ?>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">        
        <!-- Here goes the content. -->
        <div class="row">
            <div class="col-sm-12" id="report-view">
                <table class="datatable table table-bordered table-striped vertical-middle" >
                    <thead>
                            <tr>
                                <th>Campus</th>
                                <th>Course</th>
                                <th>Student</th>								
                                <th>Student course hours<br /> conducted</th>
                                <th>Booking id</th>
                                <th>Nationality</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($resultData){
                                foreach($resultData as $record){
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo $record["nome_centri"];?></td>
                                        <td class="center"><?php echo $record["cc_course_name"];?></td>
                                        <td class="center"><?php echo $record['nome']." ".$record['cognome'];?></td>
                                        <td class="center"><?php echo round($record["studentCourseHours"],2);?></td>
                                        <td class="center"><?php echo $record['id_year']."_".$record['id_book'];?></td>
                                        <td class="center"><?php echo ucwords($record['nazionalita']);?></td>
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
    var pageHighlightMenu = "tuitionsreports";
    var SITE_PATH = "<?php echo base_url();?>index.php/";
    $(document).ready(function() {
        
        $("#exportExcel").click(function(){
            var fromDate = "<?php echo $fd;?>";
            var toDate = "<?php echo $td;?>";
            var campuses = "<?php echo $campuses;?>";
            
            var courses = "<?php echo $courses;?>";
            
            var exportForm = $('<form method="post" action="'+SITE_PATH + "tuitionsreports/students"+'"></form>').appendTo('body');
            exportForm.append("<input type='hidden' name='campuses' value='"+ campuses +"' />");
            exportForm.append("<input type='hidden' name='courses' value='"+ courses +"' />");
            exportForm.append("<input type='hidden' name='fd' value='"+ fromDate +"' />");
            exportForm.append("<input type='hidden' name='td' value='"+ toDate +"' />");
            exportForm.append("<input type='hidden' name='type' value='export' />");
            exportForm.submit();
        });
        
        $("#backToFilter").click(function(){
            window.location.href= SITE_PATH + "tuitionsreports";
        });
        
    });
</script>