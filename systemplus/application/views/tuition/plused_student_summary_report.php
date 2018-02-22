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

    <?php
    $CI = &get_instance();
    $this->load->view('plused_sidebar');
    $campusArrayForGraph = array();
    $campusArray = array();
    ?>		
    <!-- Here goes the content. -->
    <section id="content" class="container_12 clearfix" data-sort=true>
        <h1 class="grid_12 margin-top no-margin-top-phone">Tuition student summary reports</h1>
        <div class="row">
            <div class="grid_12" >
            <?php if(isset($bookingId)){?>
                <span style="font-weight: bold;margin-bottom: 5px;padding-left: 2px;">Report for the booking id: <?php echo $bookingId;?></span>
            <?php }else{?>
                <span style="font-weight: bold;margin-bottom: 5px;padding-left: 2px;">Report for the duration: <?php echo $fd;?> to <?php echo $td;?></span>
            <?php }?>
            </div>
        </div>
        <div class="row" style="margin-right:10px;">
            <div class="grid_12" id="report-view">
                <?php 
                    if(isset($success_message))
                    if(!empty($success_message))
                    {
                        ?>
                        <div style="float: right;margin-left: 5px;margin-top: 7px;width:250px;">
                        <div class="tuition_success"><?php echo $success_message;?></div></div><?php 
                    }
                    if(isset($error_message))
                    if(!empty($error_message))
                    {
                        ?>
                        <div style="float: right;margin-left: 5px;margin-top: 7px;width:250px;">
                        <div class="tuition_error"><?php echo $error_message;?></div></div><?php 
                    }
                ?>
                <input id="backToFilter" class="export-button" type="button" value="Back" />
                <input id="exportExcel" class="export-button" type="button" value="Export" />
                <table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false}]}' > <!-- OPTIONAL: with-prev-next -->
                    <thead>
                            <tr>
                                <th>Campus</th>
                                <th>Course</th>
                                <th>Student</th>								
                                <th>Student course hours<br /> conducted</th>
                                <th>Booking Id</th>
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
                                        <td class="center"><?php echo $record['nazionalita'];?></td>
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
        $( "li#mnutuition ul.sub li#mnutuition_5" ).addClass("current");	
        /**/
        //$(".dataTables_filter").hide();
        
        
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
<?php $this->load->view('plused_footer'); ?>
