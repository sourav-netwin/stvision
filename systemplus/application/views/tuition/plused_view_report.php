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
        <h1 class="grid_12 margin-top no-margin-top-phone">Tuition reports</h1>
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
                <input id="backToFilter" class="export-button" type="button" value="Back" />
                <input id="exportExcel" class="export-button" type="button" value="Export" />
                <table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false}]}' > <!-- OPTIONAL: with-prev-next -->
                    <thead>
                            <tr>
                                <th>Campus</th>
                                <th>Course</th>
                                <th>Class</th>
                                <th>Class Date</th>
                                <th>Student</th>								
                                <th>Booking Id</th>
                                <th>Nationality</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($resultData){
                            $countCampusStudents = 0;
                            $countCourseStudents = 0;
                            $countClassStudents = 0;
                                foreach($resultData as $record){
                                    if(!array_key_exists($record['nome_centri'], $campusArrayForGraph)){
                                        $countCampusStudents = 0;
                                        $countCampusStudents++;
                                        $campusArrayForGraph[$record['nome_centri']] = $countCampusStudents;
                                        $campusCourses = $CI->countCampusCourses($resultData,$record['cc_campus_id']);
                                        array_push($campusArray,$campusCourses);
                                    }
                                    else
                                    {
                                        $countCampusStudents++;
                                        $campusArrayForGraph[$record['nome_centri']] = $countCampusStudents;
                                    }
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo $record["nome_centri"];?></td>
                                        <td class="center"><?php echo $record["cc_course_name"];?></td>
                                        <td class="center"><?php echo $record["class_name"];?></td>
                                        <td class="center"><?php echo date("d-m-Y",strtotime($record["class_date"]));?></td>
                                        <td class="center"><?php echo $record['nome'].' '.$record['cognome'];?></td>
                                        <td class="center"><?php echo $record['id_year']."_".$record['id_book'];?></td>
                                        <td class="center"><?php echo $record['nazionalita'];?></td>
                                    </tr>
                                    <?php 
                                }
                            }
                            $strData = "[['Campus', 'Course', 'Class', 'Students'],";
                            $noRec = 1;
                            if($campusArray){
                                foreach($campusArray as $campus){
                                    $strData .= "['".$campus['campus']."'".",".$campus['courses'].",".$campus['classes'].",".$campus['students']."],";
                                }
                            }
                            else {$noRec = 0;}
                            $strData = rtrim($strData,',');
                            $strData .= "]";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <h1 class="grid_12 margin-top no-margin-top-phone">Graphical representation</h1>
        <div class="row" style="margin-right: 10px;">
            <!--Div that will hold the pie chart-->
<!--            <div id="bar_chart_div" class="grid_6"></div>
            <div id="pie_chart_div" class="grid_6"></div>-->
            <div id="columnchart_material" style="height: 500" class="grid_12">
                <span id="graph-no-data" style="margin-left: 15px;">Loading...</span></div>
            
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
            <?php if(isset($bookingId)){?>
                window.location.href= SITE_PATH + "tuitionsreports/toexcel/booking";
            <?php }else{?>
                window.location.href= SITE_PATH + "tuitionsreports/toexcel";
            <?php }?>
        });
        
        $("#backToFilter").click(function(){
            window.location.href= SITE_PATH + "tuitionsreports/view";
        });
    });
</script>
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->

<script type="text/javascript">
    // Load the Visualization API and the piechart package.
    //google.load('visualization', '1.0', {'packages':['corechart']});
    google.load('visualization', '1.0', {'packages':['bar']});
    //google.charts.load('current', {'packages':['bar']});

    // Set a callback to run when the Google Visualization API is loaded.
    //google.setOnLoadCallback(drawChart);
    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    
    function drawChart() {
        <?php if($noRec){?>
        var data = google.visualization.arrayToDataTable(<?php echo $strData;?>);
        //var data = new google.visualization.DataTable('<?php //echo json_encode($campusArray);?>');
        /*[
          ['Campus', 'Course', 'Class', 'Students'],
          ['CANTERBARY', 1000, 400, 200],
          ['BEDFORD', 500, 400, 100]
        ]);*/
        var options = {
          chart: {
            title: 'Tuition report',
            subtitle: 'Students placed as per campus, course and class'
          },
          bars: 'vertical',
          vAxis: {format: 'decimal'},
          height: 400,
          colors: ['#1b9e77', '#d95f02', '#7570b3']          
        };

        //var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        //chart.draw(data, options);
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
        <?php }else{?>
            $("#graph-no-data").html('No data available for graph');
            $("#exportExcel").attr('disabled','disabled');
        <?php }?>
    }
    
    function doStats() {
        var statisticsOverview = {
            init: function() {
                console.log('init');
                drawChart();
            }
        };   
        statisticsOverview.init();
    }
google.setOnLoadCallback(doStats);
</script>
<?php $this->load->view('plused_footer'); ?>
