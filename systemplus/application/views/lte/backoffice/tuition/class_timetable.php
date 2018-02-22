<link href="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">  
<section class="">
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);?>
            </div>
            <div id="priority-box" class="row" >
                <div class="col-sm-3">
                    <label for="txtCalFromDate">From Date:</label>
                    <input class="form-control" type="text" id="txtCalFromDate" name="fd" value="<?php echo date("d/m/Y",strtotime($calFromDate));?>" />
                </div>
                <div class="col-sm-3">
                    <label for="txtCalToDate">To Date:</label>
                    <input class="form-control" type="text" id="txtCalToDate" name="td" value="<?php echo date("d/m/Y",strtotime($calToDate));?>" />
                </div>
                <div class="col-sm-6">
                    <div><label for="txtCalToDate">&nbsp;</label></div>
                    <input type="button" value="Show" id="btnCalShow" class="btn btn-primary" />
                    <input class="btn btn-danger" type="button" value="Clear" id="btnClear" />
                </div>

            </div>
        </div>
        <div class="box-body tuitionCalDiv">
                <?php 
                if($campusList){
                        $CI = & get_instance();
                        $campus = $campusList[0];
                ?>
                <p>Class timetable for <?php echo (empty($campusId) ? 'ALL CAMPUSES' : $campus['nome_centri']);?></p>
                <table id="tuitionCalTable plan" class="table table-bordered table-striped vertical-middle">
                    <tr>
                        <th>Hours/Day</th>
                    <?php 
                        $monthDates=array();
                        $date1 = new DateTime($calFromDate);
                        $date2 = new DateTime($calToDate);
                        $diff = 1 + $date2->diff($date1)->format("%a");
                        $currDate = $calFromDate;
                        for($d=1; $d<=$diff; $d++)
                        {
                            $monthDates[] = date('Y-m-d', strtotime($currDate));
                            $todaysDay = date('l', strtotime($currDate));
                            $dontAllowToSchedule = FALSE;
                            if($todaysDay == "Saturday" || $todaysDay == "Sunday")
                            {
                                $dontAllowToSchedule = TRUE;
                            }
                            ?><th title="<?php echo $todaysDay;?>" data-toggle="tooltip" class="<?php echo ($dontAllowToSchedule ? 'satSun' : '');?>"><?php echo date('d/m', strtotime($currDate));?></th><?php 
                            $currDate = date('Y-m-d', strtotime($currDate. ' + 1 days'));
                        }
                    ?></tr><?php    
                            // GENERATE GRID FOR HOURS
                            $colInx = 1;
                            $rowInx = 1;
                            for($dayHour=7; $dayHour < 25; $dayHour++){
                                ?>
                                <tr>
                                    <td><?php $cellTime = str_pad($dayHour, 2, '0', STR_PAD_LEFT).':00';
                                                echo $cellTime; ?>
                                    </td>
                                    <?php 
                                    foreach($monthDates as $dates){
                                        $todaysDay = date('l', strtotime($dates));
                                        $dontAllowToSchedule = FALSE;
                                        if($todaysDay == "Saturday" || $todaysDay == "Sunday")
                                        {
                                            $dontAllowToSchedule = TRUE;
                                        }
                                        ?><td class="event_td <?php echo ($dontAllowToSchedule ? 'satSun' : '');?>" id="cell_<?php echo $colInx.'_'.$rowInx?>" data-time="<?php echo $cellTime.":00";?>" data-date="<?php echo $dates;?>">
                                            <?php if($colInx == 2 && $rowInx == 13){
                                                ?>

                                                <?php 
                                                }
                                            ?>
                                        </td><?php 
                                        $rowInx++;
                                    }
                                    ?>
                                </tr>
                                <?php $colInx++;
                            }
                    ?>
                </table>
                <?php 
//                                                    $data = array('all_classes'=>$all_classes);
//                                                    $this->load->view('tuition/plused_classes', $data);
                }
                ?>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
      </div>
      </div>
    </div>
</section>
<script>
var SITE_PATH = siteUrl;
var pageHighlightMenu = "tuitions/plan";
// COURSE DIRECTOR HOURS CALENDAR
        $(document).ready(function() {
            $( "#txtCalFromDate" ).datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,		  
                    dateFormat: "dd/mm/yy",		
                    numberOfMonths: 1,
                    onClose: function( selectedDate ) {
                            $(".txtCalFromDate").val(selectedDate);
                            $( "#txtCalToDate" ).datepicker( "option", "minDate", selectedDate );
                            var from = selectedDate.split("/");
                            var f = new Date(from[2], from[1] - 1, from[0]);
                            var sDate = new Date(f);
                            sDate.setMonth(sDate.getMonth() + 1);
                            $( "#txtCalToDate" ).datepicker( "option", "maxDate", sDate );
                    }
            });

            $( "#txtCalToDate" ).datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        changeYear: true,		  
                        dateFormat: "dd/mm/yy",		
                        numberOfMonths: 1,
                        onClose: function( selectedDate ) {
                                $(".txtCalToDate").val(selectedDate);
                                $( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
                        }
            });

            $("#btnCalShow").click(function(){
                var calFromDate = $("#txtCalFromDate").val();
                    calFromDate = calFromDate.replace('/', "-");
                    calFromDate = calFromDate.replace('/', "-");
                    calFromDate = encodeURIComponent(calFromDate);
                var calToDate = $("#txtCalToDate").val();
                    calToDate = calToDate.replace('/', "-");
                    calToDate = calToDate.replace('/', "-");
                    calToDate = encodeURIComponent(calToDate);
                window.location.href = SITE_PATH + 'tuitions/plan/' + calFromDate + '/' + calToDate;
            });
            
            $("#btnClear").click(function(){
                   window.location.href = SITE_PATH + 'tuitions/plan';
            });

                var classEvents = JSON.parse('<?php echo $classTeachers;?>');
                for (var key in classEvents) {
                    if (classEvents.hasOwnProperty(key)) {
                        var val = classEvents[key];
                        createEvent(val);
                    }
                }
        });
        
        // COURSE DIRECTOR HOURS CALENDAR
         var rand = "";
         function createEvent(myClass){
             var colorsArr = ['#FF0000','#FFFF00','#00FF00','#00FFFF','#80ff00','#00ffbf','#b34d4d'];
             rand = colorsArr[Math.floor(Math.random() * colorsArr.length)];
             $( ".event_td" ).each(function( index ) {
                if($( this ).attr('data-date') == myClass.class_date && $( this ).attr('data-time').substring(0, 2) == myClass.cl_from_time.substring(0, 2) )
                {
                    var numberOfCell = parseInt(myClass.cl_to_time.substring(0, 2)) - parseInt(myClass.cl_from_time.substring(0, 2));
                    var eleHeight = 47;
                    if(numberOfCell != 1)
                        eleHeight = ((numberOfCell * 0) + numberOfCell * 47);
                    $( this ).append("<div data-toggle='tooltip' title='"+myClass.class_name+ " #"+ myClass.cl_class_id +"' style='background-color:"+rand+";height:"+eleHeight+"px;' class='custom-event'></div>");
                    
                    var totalClasses = $(this).find('.custom-event').length;
                    var parentWidth = $(this).width();
                    if(totalClasses > 1)
                    {
                        var setLeft = 0;
                        var plusCount = 0;
                        $(this).find('.custom-event').each(function( index ) {
                        var parentTd =  $(this);
                            if((parentWidth - 12) >= setLeft)
                            {
                                $(this).css('left',setLeft);
                                setLeft = setLeft + 12;
                            }
                            else{
                                plusCount++;
                                parentTd.append("<div class='custom-event' style='right:0'>+<br/>"+plusCount+"<div>");
                            }
                        });
                    }
                }
            });
         }
</script>