<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<style>
    .dataTables_scrollBody{
        width: 101%!important;
    }
</style>
<section class="">
    <?php
    $CI = &get_instance();
    $campusArrayForGraph = array();
    $campusArray = array();
    ?>		
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                Tuition report
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
                                <th>Student</th>								
                                <th>Booking Id</th>
                                <th>Nationality</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $classArrayForGraph = array();
                        $courseName = "";
                        if($resultData){
                            $countClassStudents = 0;
                                foreach($resultData as $record){
                                    $courseName = $record['cc_course_name'];
                                    if(!array_key_exists($record['class_name'], $classArrayForGraph)){
                                        $countClassStudents = 0;
                                        $countClassStudents++;
                                        $classArrayForGraph[$record['class_name']] = $countClassStudents;

                                    }
                                    else
                                    {
                                        $countClassStudents = $classArrayForGraph[$record['class_name']];
                                        $countClassStudents++;
                                        $classArrayForGraph[$record['class_name']] = $countClassStudents;
                                    }
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo $record["nome_centri"];?></td>
                                        <td class="center"><?php echo $record["cc_course_name"];?></td>
                                        <td class="center"><?php echo $record["class_name"];?></td>
                                        <td class="center"><?php echo $record['nome']."_".$record['cognome'];?></td>
                                        <td class="center"><?php echo $record['id_year']." ".$record['id_book'];?></td>
                                        <td class="center"><?php echo ucwords($record['nazionalita']);?></td>
                                    </tr>
                                    <?php 
                                }
                            }
                            $strData = "[['Class', 'Students'],"; //, { role: 'style' }
                            $noRec = 1;
                            if($classArrayForGraph){
                                foreach($classArrayForGraph as $key => $value){
                                    
                                    $strData .= "['".$key."'".",".$value."],"; //,'#b87333'
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
    var SITE_PATH = "<?php echo base_url();?>index.php/";
    var pageHighlightMenu = "tuitionsreports";
    $(document).ready(function() {
        
        $("#exportExcel").click(function(){
           window.location.href= SITE_PATH + "tuitionsreports/classreporttoexcel";
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
        var options = {
          chart: {
            title: '<?php echo $courseName;?> class report',
            subtitle: 'Students placed per classes for the day and course'
          },
          bars: 'vertical',
          vAxis: {format: 'decimal'},
          height: 400,
          width:450,
          colors: ['#b87333', 'silver']
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