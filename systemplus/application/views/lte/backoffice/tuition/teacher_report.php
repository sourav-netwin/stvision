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
                Teacher work report
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
                <table class="datatable table table-bordered table-striped vertical-middle" width="99.9%" >
                    <thead>
                            <tr>
                                <th>Teacher</th>
                                <th>Class</th>		
                                <th>Date</th>
                                <th>From time</th>
                                <th>To time</th>
                                <th>Worked time</th>
                                <th>Course</th>
                                <th>Campus</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $classArrayForGraph = array();
                        $dateArrayForGraph = array();
                        $teacherName = "";
                        if($resultData){
                            $countClassLesson = 0;
                            $countDateLesson = 0;
                                foreach($resultData as $record){
                                    $classDate = date("d/m/Y",strtotime($record["class_date"]));
                                    $teacherName = $record['teach_first_name']." ".$record['teach_last_name'];
                                    if(!array_key_exists($record['class_name'], $classArrayForGraph)){
                                        $countClassLesson = 0;
                                        $countClassLesson++;
                                        $classArrayForGraph[$record['class_name']] = $countClassLesson;

                                    }
                                    else
                                    {
                                        $countClassLesson = $classArrayForGraph[$record['class_name']];
                                        $countClassLesson++;
                                        $classArrayForGraph[$record['class_name']] = $countClassLesson;
                                    }
                                    
                                    if(!array_key_exists($classDate, $dateArrayForGraph)){
                                        $countDateLesson = 0;
                                        $countDateLesson++;
                                        $dateArrayForGraph[$classDate] = $countDateLesson;

                                    }
                                    else
                                    {
                                        $countDateLesson = $dateArrayForGraph[$classDate];
                                        $countDateLesson++;
                                        $dateArrayForGraph[$classDate] = $countDateLesson;
                                    }
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo $record['teach_first_name']." ".$record['teach_last_name'];?></td>
                                        <td class="center"><?php echo $record["class_name"];?></td>
                                        <td class="center"><?php echo date("d/m/Y",strtotime($record["class_date"]));?></td>
                                        <td class="center"><?php echo $record["cl_from_time"];?></td>
                                        <td class="center"><?php echo $record["cl_to_time"];?></td>
                                        <td class="center"><?php echo $record["worktime"];?></td>
                                        <td class="center"><?php echo $record["cc_course_name"];?></td>
                                        <td class="center"><?php echo $record["nome_centri"];?></td>
                                    </tr>
                                    <?php 
                                }
                            }
                            $strData = "[['Classes', 'Lesson(s)'],"; //, { role: 'style' }
                            $noRec = 1;
                            if($classArrayForGraph){
                                foreach($classArrayForGraph as $key => $value){
                                    
                                    $strData .= "['".$key."'".",".$value."],"; //,'#b87333'
                                }
                            }
                            else {$noRec = 0;}
                            $strData = rtrim($strData,',');
                            $strData .= "]";
                            
                            // date string for graph
                            $strDateData = "[['Date(s)', 'Lesson(s)'],"; //, { role: 'style' }
                            $noDateRec = 1;
                            if($dateArrayForGraph){
                                foreach($dateArrayForGraph as $key => $value){
                                    
                                    $strDateData .= "['".$key."'".",".$value."],"; //,'#b87333'
                                }
                            }
                            else {$noDateRec = 0;}
                            $strDateData = rtrim($strDateData,',');
                            $strDateData .= "]";
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
                <input onclick="drawDateChart();" style="display: none;" type="button" value="Date-wise" id="btnDatewise" />
                <div id="columnchart_material" style="height: 500" class="col-sm-12">
                    <span id="graph-no-data" style="margin-left: 15px;">Loading...</span></div>
                <div id="columnchart_for_date" style="height: 500" class="col-sm-12">
                    <span id="graph-no-data-date" style="margin-left: 15px;">Loading...</span></div>
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
          
           var exportForm = $('<form method="post" action="'+SITE_PATH + "tuitionsreports/teachers/export"+'"></form>').appendTo('body');
           exportForm.append("<input type='hidden' name='campusId' value='<?php echo $campusId;?>' />");
           exportForm.append("<input type='hidden' name='teacherId' value='<?php echo $teacherId;?>' />");
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
        
        <?php if($noRec){
           // $charWidth = 400;
           // if($noRec == 1) $charWidth = 230; 
            ?>
        var data = google.visualization.arrayToDataTable(<?php echo $strData;?>);
        var options = {
          chart: {
            title: '<?php echo $teacherName;?> class wise report',
            subtitle: 'Lesson(s) taught per classe for duration'
          },
          bars: 'vertical',
          vAxis: {format: 'decimal'},
          height: 400,
          //width: <?php //echo $charWidth;?>,
          colors: ['#b87333', 'silver']
        };
        /*
         ,
          bar: { groupWidth: "25%" }
         **/
        //var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        //chart.draw(data, options);
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
        
        <?php }else{?>
            $("#graph-no-data").html('No data available for graph');
            $("#exportExcel").attr('disabled','disabled');
        <?php }?>
    }
    
    function drawDateChart() {
        <?php if($noDateRec){?>
        var data = google.visualization.arrayToDataTable(<?php echo $strDateData;?>);
        var options = {
          chart: {
            title: '<?php echo $teacherName;?> date-wise report',
            subtitle: 'Lesson(s) taught per day for duration'
          },
          bars: 'vertical',
          vAxis: {  
            format: 'decimal'
          },
          height: 400,
          //width:450,
          colors: ['#b87333', 'silver']
        };
        /*,
          bar: { groupWidth: '10%' }*/
        //var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        //chart.draw(data, options);
        var chart = new google.charts.Bar(document.getElementById('columnchart_for_date'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
        <?php }else{?>
            $("#graph-no-data-date").html('No data available for graph');
        <?php }?>
    }
    
    function doStats() {
        var statisticsOverview = {
            init: function() {
                console.log('init');
                drawChart();
                setTimeout("$('#btnDatewise').trigger('click');", 3000);
            }
        };   
        statisticsOverview.init();
    }
    google.setOnLoadCallback(doStats);
</script>