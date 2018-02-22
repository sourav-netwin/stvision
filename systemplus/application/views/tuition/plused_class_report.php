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
        <h1 class="grid_12 margin-top no-margin-top-phone">Tuition reports</h1>
        <div class="row" style="margin-right:10px;">
            <div class="grid_12" id="report-view">
                <input id="backToFilter" class="export-button" type="button" value="Back" />
                <input id="exportExcel" class="export-button" type="button" value="Export" />
                <table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false}]}' > <!-- OPTIONAL: with-prev-next -->
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
                                        <td class="center"><?php echo $record['nazionalita'];?></td>
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
        $(".dataTables_filter").hide();
        
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
<?php $this->load->view('plused_footer'); ?>
