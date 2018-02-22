<?php $this->load->view('plused_header');?>
<script src="<?php echo base_url();?>js/jquery.browser.min.js"></script> 
<script src="<?php echo base_url();?>js/jquery.printElement.min.js"></script>
<?php /*<link href='<?php echo base_url();?>js/fullcalendar/fullcalendar.css' rel='stylesheet' />
<script src='<?php echo base_url();?>js/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo base_url();?>js/fullcalendar/fullcalendar.min.js'></script>*/?>
	<!-- The container of the sidebar and content box -->
	<div role="main" id="main" class="container_12 clearfix">
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
    <script>
        var SITE_PATH = "<?php echo base_url();?>index.php/";
        </script>
<!--        <script src="<?php //echo base_url();?>js/tuition/tuition_schedule.js"></script>-->
        <script>
        // COURSE DIRECTOR HOURS CALENDAR
        $(document).ready(function() {
            $("#tuitionCalTable th:[title]").tipsy({gravity:'s'});
           
            $( "li#mnutuition" ).addClass("current");
            $( "li#mnutuition a" ).addClass("open");		
            $( "li#mnutuition ul.sub" ).css('display','block');
            $( "li#mnutuition ul.sub li#mnutuition_8" ).addClass("current");

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

                var classEvents = JSON.parse('<?php echo $classTeachers;?>');
                for (var key in classEvents) {
                    if (classEvents.hasOwnProperty(key)) {
                        var val = classEvents[key];
                        createEvent(val);
                    }
                }
                $('.custom-event').tipsy({gravity: 'se'});
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
                        eleHeight = ((numberOfCell * 2.5) + numberOfCell * 47);
                    $( this ).append("<div title='"+myClass.class_name+ " #"+ myClass.cl_class_id +"' style='background-color:"+rand+";height:"+eleHeight+"px;' class='custom-event'></div>");
                    
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
       	<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
					<div class="header">
                                            <h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Class timetable</h2>
					</div>
					<div class="content">
						<div class="tabletools">
                                                    <div class="calendar-tool tuition-filter-left">
                                                            <label><span class="text">From Date:</span></label><input type="text" id="txtCalFromDate" name="fd" value="<?php echo date("d/m/Y",strtotime($calFromDate));?>" />
                                                            <label><span class="text">To Date:</span></label><input type="text" id="txtCalToDate" name="td" value="<?php echo date("d/m/Y",strtotime($calToDate));?>" />
                                                            <input type="button" value="Show" id="btnCalShow" class="btn btn-tuition" />
                                                    </div>
                                                    <div class="right tuition-filter-right">	
                                                        <?php 
                                                            $success_message = $this->session->flashdata('success_message');
                                                            if(!empty($success_message))
                                                            {
                                                                ?><div class="tuition_success"><?php echo $success_message;?></div><?php 
                                                            }
                                                            $error_message = $this->session->flashdata('error_message');
                                                            if(!empty($error_message))
                                                            {
                                                                ?><div class="tuition_error"><?php echo $error_message;?></div><?php 
                                                            }
                                                        ?>
                                                    </div>
						</div>
                                                <div class="tuitionCalDiv">
                                                    <?php 
                                                    if($campusList){
                                                            $CI = & get_instance();
                                                            $campus = $campusList[0];
                                                    ?>
                                                    <p>Class timetable for <?php echo (empty($campusId) ? 'ALL CAMPUSES' : $campus['nome_centri']);?></p>
                                                    <table id="tuitionCalTable" style="width:100%;">
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
                                                                ?><th title="<?php echo $todaysDay;?>" class="<?php echo ($dontAllowToSchedule ? 'satSun' : '');?>"><?php echo date('d/m', strtotime($currDate));?></th><?php 
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
<!--                                            <div id="mycalendar"></div>-->
						
					</div><!-- End of .content -->
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
			
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	
    <script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
    <script>
        function formatIntToTime(inputStr){
                var sec_num = parseInt(inputStr, 10); // don't forget the second param
                var hours   = Math.floor(sec_num / 3600);
                var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
                var seconds = sec_num - (hours * 3600) - (minutes * 60);

                if (hours   < 10) {hours   = "0"+hours;}
                if (minutes < 10) {minutes = "0"+minutes;}
                if (seconds < 10) {seconds = "0"+seconds;}
                var time    = hours+':'+minutes;
                return time;
        }
    </script>
        <?php $this->load->view('plused_footer');?>