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
                <?php if(isset($bookingId)){?>
                    Report for the booking id: <?php echo $bookingId;?>
                <?php }else{?>
                    Report for the duration: <?php echo $fd;?> to <?php echo $td;?>
                <?php }?>
            </h3>
            <div class="pull-right">
                <input id="backToFilter" class="export-button btn btn-primary" type="button" value="Back" />
                <input id="exportExcel" class="export-button btn btn-primary" type="button" value="Export" />
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
                                <th>Class</th>
                                <th>Class date</th>
                                <th>Student</th>								
                                <th>Booking id</th>
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
                                        <td class="text-center"><?php echo $record["nome_centri"];?></td>
                                        <td class="text-center"><?php echo $record["cc_course_name"];?></td>
                                        <td class="text-center"><?php echo $record["class_name"];?></td>
                                        <td class="text-center"><?php echo date("d-m-Y",strtotime($record["class_date"]));?></td>
                                        <td class="text-center"><?php echo $record['nome'].' '.$record['cognome'];?></td>
                                        <td class="text-center"><?php echo $record['id_year']."_".$record['id_book'];?></td>
                                        <td class="text-center"><?php echo ucwords($record['nazionalita']);?></td>
                                    </tr>
                                    <?php 
                                }
                            }
                            $strData = "[['Campuses', 'Courses', 'Classes', 'Students'],";
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
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer-->
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Graphical representation</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row" >
                <!--Div that will hold the pie chart-->
    <!--            <div id="bar_chart_div" class="grid_6"></div>
                <div id="pie_chart_div" class="grid_6"></div>-->
                <div id="columnchart_material" style="height: 500" class="col-sm-12">
                    <span id="graph-no-data">Loading...</span>
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
    var pageHighlightMenu = "tuitionsreports";
    
    $(document).ready(function() {
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
            subtitle: 'Students placed as per campuses, courses and classes'
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