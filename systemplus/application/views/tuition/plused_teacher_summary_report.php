<?php $this->load->view('plused_header'); ?>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix reportsFilters">

    <!-- The blue toolbar stripe -->
    <section class="toolbar">
        <div class="user">
            <div class="avatar">
                <img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
                <!-- Evidenziare per icone attenzione <span>3</span> -->
            </div>
            <span><?php echo $this->session->userdata('businessname') ?></span>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
            </ul>
        </div>
    </section><!-- End of .toolbar-->

    <?php $this->load->view('plused_sidebar');?>		
    <!-- Here goes the content. -->
    <section id="content" class="container_12 clearfix" data-sort=true>
        <h1 class="grid_12 margin-top no-margin-top-phone">Teacher work summary report</h1>
        <div class="row" style="margin-right:10px;">
            <div class="grid_12" id="report-view">
                <input id="backToFilter" class="export-button" type="button" value="Back" />
                
                <input id="exportExcel" class="export-button" type="button" value="Export" />
                
                <table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"bSort":false, "aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false}]}' > <!-- OPTIONAL: with-prev-next -->
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
    </section>
</div>
<script>
    var SITE_PATH = "<?php echo base_url();?>index.php/";
    $(document).ready(function() {
        $( "li#mnutuition" ).addClass("current");
        $( "li#mnutuition a" ).addClass("open");		
        $( "li#mnutuition ul.sub" ).css('display','block');	
        $( "li#mnutuition ul.sub li#mnutuition_6" ).addClass("current");	
        /**/
        //$(".dataTables_filter").hide();
        
        $("#exportExcel").click(function(){
           //window.location.href= SITE_PATH + "tuitionsreports/teachers/export";
           
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
<?php $this->load->view('plused_footer'); ?>