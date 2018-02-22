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
        var SUSER = "<?php echo $this->session->userdata('role');?>";
        
        </script>
        <script src="<?php echo base_url();?>js/tuition/tuition_schedule.js?v=1.1"></script>
        <script>
        $(document).ready(function() {
            var diaH = $(window).height() * 0.9;
            var diaW = $(window).width() * 0.9;
            $( ".windia_showlist_dialog" ).dialog({
                autoOpen: false,
                modal: true,
                hide: "",
                show: "",
                width : diaW,
                height : diaH,
                buttons: [{
                        text: "Close",
                        click: function() { $(this).dialog("close"); }
                        }],
                        open: function( event, ui ) {
                            $("#statsStudentsList").css('height',(diaH - 160));
                        }
            });
            $( "body" ).on( "click", ".showstdlist", function() {
                var uuidsStr = $(this).attr('data-uuid');
                var classDate = $(this).attr('data-classdate');
                var campusId = $(this).attr('data-campus-id');
                var dataTitle = $(this).attr('data-title');
                $.post( SITE_PATH + "tuitions/getStatsStudentsList",{'uuidsStr':uuidsStr,'classDate':classDate,'campusId':campusId}, function( data ) {
                    $("#statsStudentsList").html(data);
                    $('table.statsStdTable').table();
                    $("#statsStudentsList select").css('width','55px');
                    $("#statsStudentsList select").chosen();
                }); 
                $("#dialog_modal_std_showlist").dialog("open");
                $("#ui-dialog-title-dialog_modal_std_showlist").html(dataTitle);
            });
        });
	</script>	
       	<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
					<div class="header">
                                            <h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Tuitions schedule 
                                                <?php 
                                                if($campusList && is_array($campusList))
                                                {
                                                    $campus = $campusList[0];
                                                    echo " - " . $campus['nome_centri'];
                                                }
                                                ?></h2>
					</div>
					<div class="content">
						<div class="tabletools">
                                                    <div class="calendar-tool tuition-filter-left">
                                                            <label><span class="text">From Date:</span></label><input type="text" id="txtCalFromDate" name="fd" value="<?php echo date("d/m/Y",strtotime($calFromDate));?>" />
                                                            <label><span class="text">To Date:</span></label><input type="text" id="txtCalToDate" name="td" value="<?php echo date("d/m/Y",strtotime($calToDate));?>" />
                                                            <input type="button" value="Show" id="btnCalShow" class="btn btn-tuition" />
                                                    </div>
                                                    <div class="right tuition-filter-right">	
                                                        <div><span class="abook">#Green</span> - Number of students placed in class.</div>
                                                        <div><span class="pbook">#Red</span> - Total number of students on campus.</div>
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
                                                    <table id="tuitionCalTable" style="width:100%;">
                                                        <tr>
                                                            <th>Campus</th>
                                                        <?php 
                                                            $monthDates=array();
                                                            $date1 = new DateTime($calFromDate);
                                                            $date2 = new DateTime($calToDate);
                                                            $diff = 1 + $date2->diff($date1)->format("%a");
                                                            $currDate = $calFromDate;
                                                            for($d=1; $d<=$diff; $d++)
                                                            {
                                                                $todaysDay = date('l', strtotime($currDate));
                                                                $dontAllowToSchedule = FALSE;
                                                                if($todaysDay == "Saturday" || $todaysDay == "Sunday")
                                                                    $dontAllowToSchedule = TRUE;
                                                                $monthDates[] = date('Y-m-d', strtotime($currDate));
                                                                ?><th title="<?php echo $todaysDay;?>" class="<?php echo ($dontAllowToSchedule) ? 'satSun'  : '';?>"><?php echo date('d/m', strtotime($currDate));?></th><?php 
                                                                $currDate = date('Y-m-d', strtotime($currDate. ' + 1 days'));
                                                            }
                                                        ?></tr><?php    
                                                        if($campusList){
                                                            $CI = & get_instance();
                                                            //error_reporting(E_ALL);
                                                            $campus = $campusList[0];
                                                                foreach ($campusList as $campus){
                                                                    ?>
                                                                        <tr>
                                                                            <td>STUDENTS ON CAMPUS</td>
                                                                            <?php 
                                                                            foreach($monthDates as $dates){
                                                                                    $todaysDay = date('l', strtotime($dates));
                                                                                    $dontAllowToSchedule = FALSE;
                                                                                    if($todaysDay == "Saturday" || $todaysDay == "Sunday")
                                                                                    {
                                                                                        $dontAllowToSchedule = TRUE;
                                                                                    }
                                                                                ?><td class="<?php echo ($dontAllowToSchedule ? 'satSun' : '');?>">
                                                                                    <?php if(!$dontAllowToSchedule){?>
                                                                                    <i id="<?php echo strtotime($dates);?>" data-campus-id="<?php echo $campus['id'];?>" data-campus="<?php echo $campus['nome_centri'];?>" data-pickdate="<?php echo date('d/m/Y',  strtotime($dates));?>" data-book-date="<?php echo $dates;?>" class="icon-plus-book dialogbtn"></i>
                                                                                    <div><?php echo $CI->getTodaysBookings($dates,$campus['id']);?> </div>
                                                                                    <?php }else{ echo "--";}?>
                                                                                </td><?php 
                                                                            }
                                                                            ?>
                                                                        </tr>
                                                                    <?php 
                                                                }
                                                                
                                                                $testedStudents = "";
                                                                $studentsToBeTested = "";
                                                                $studentsLeavingTomorrow = "";
                                                                foreach($monthDates as $dates){
                                                                    $todaysDay = date('l', strtotime($dates));
                                                                    $dontAllowToSchedule = FALSE;
                                                                    if($todaysDay == "Saturday" || $todaysDay == "Sunday")
                                                                    {
                                                                        $dontAllowToSchedule = TRUE;
                                                                    }
                                                                    $qResult = $CI->getStudentsStats($dates,$campus['id']);
                                                                    if($qResult){
                                                                        foreach($qResult as $dayStats){
                                                                            // Tested Students
                                                                            $testedStudents .= "<td class='".($dontAllowToSchedule ? 'satSun' : '')."'>";
                                                                            if($dontAllowToSchedule){
                                                                               $testedStudents .= "<a href='javascript:void(0);'>--</a>"; 
                                                                            }
                                                                            else{
                                                                                $testedStudents .= "<a href='javascript:void(0);' data-title='Tested students list' data-campus-id='".$campus['id']."' data-classdate='".$dates."' data-uuid='".$dayStats['std_uuids']."' class='showstdlist hlt-link-a'>";
                                                                                $testedStudents .= $dayStats['students_count'];
                                                                                $testedStudents .= "</a>";
                                                                            }
                                                                            $testedStudents .= "</td>";
                                                                            
                                                                            // Students to be tested
                                                                            $studentsToBeTested .= "<td class='".($dontAllowToSchedule ? 'satSun' : '')."'>";
                                                                            if($dontAllowToSchedule){
                                                                               $studentsToBeTested .= "<a href='javascript:void(0);'>--</a>"; 
                                                                            }
                                                                            else{
                                                                                $studentsToBeTested .= "<a href='javascript:void(0);' data-title='To be tested students list' data-campus-id='".$campus['id']."' data-classdate='".$dates."' data-uuid='".$dayStats['untested_std_uuids']."' class='showstdlist hlt-link-a'>";
                                                                                $studentsToBeTested .= $dayStats['untested_students_count'];
                                                                                $studentsToBeTested .= "</a>";
                                                                            }
                                                                            $studentsToBeTested .= "</td>";
                                                                            
                                                                            // Students leaving tomorrow
                                                                            $studentsLeavingTomorrow .= "<td class='".($dontAllowToSchedule ? 'satSun' : '')."'>";
                                                                            
                                                                            $studentsLeavingTomorrow .= "<a href='javascript:void(0);' data-title='Leaving tomorrow students list' data-campus-id='".$campus['id']."' data-classdate='".$dates."' data-uuid='".$dayStats['leavingto_std_uuids']."' class='showstdlist hlt-link-a'>";
                                                                            $studentsLeavingTomorrow .= $dayStats['leavingto_students_count'];
                                                                            $studentsLeavingTomorrow .= "</a>";
                                                                            
                                                                            $studentsLeavingTomorrow .= "</td>";
                                                                        }
                                                                    }
                                                                        
                                                                }
                                                                
                                                                echo "<tr><td style='text-transform: uppercase;'>Tested Students</td>".$testedStudents."</tr>";
                                                                echo "<tr><td style='text-transform: uppercase;'>Students to be tested</td>".$studentsToBeTested."</tr>";
                                                                echo "<tr><td style='text-transform: uppercase;'>Students leaving tomorrow</td>".$studentsLeavingTomorrow."</tr>";
                                                                
                                                                /*
                                                                ?>
                                                                        <tr>
                                                                            <td style="text-transform: uppercase;">Tested Students</td>
                                                                            <?php 
                                                                            foreach($monthDates as $dates){
                                                                                $todaysDay = date('l', strtotime($dates));
                                                                                $dontAllowToSchedule = FALSE;
                                                                                if($todaysDay == "Saturday" || $todaysDay == "Sunday")
                                                                                {
                                                                                    $dontAllowToSchedule = TRUE;
                                                                                }
                                                                                ?><td class="<?php echo ($dontAllowToSchedule ? 'satSun' : '');?>">
                                                                                    <?php if(!$dontAllowToSchedule){
                                                                                        $studentsCount = $CI->getTestedStudentsCount($dates,$campus['id']);
                                                                                        if($studentsCount['students_count']){
                                                                                        ?>
                                                                                        <a href="javascript:void(0);" data-title="Tested students list" data-campus-id="<?php echo $campus['id'];?>" data-classdate="<?php echo $dates;?>" data-uuid="<?php echo $studentsCount['std_uuids'];?>" class="showstdlist hlt-link-a">
                                                                                        <?php echo $studentsCount['students_count'];?>
                                                                                        </a>
                                                                                        <?php }else{?>
                                                                                        0
                                                                                        <?php }?>
                                                                                    <?php }else{ echo "--";}?>
                                                                                </td><?php 
                                                                            }
                                                                            ?>
                                                                        </tr> 
                                                                        <tr>
                                                                            <td style="text-transform: uppercase;">Students to be tested</td>
                                                                            <?php 
                                                                            foreach($monthDates as $dates){
                                                                                $todaysDay = date('l', strtotime($dates));
                                                                                $dontAllowToSchedule = FALSE;
                                                                                if($todaysDay == "Saturday" || $todaysDay == "Sunday")
                                                                                {
                                                                                    $dontAllowToSchedule = TRUE;
                                                                                }
                                                                                ?><td class="<?php echo ($dontAllowToSchedule ? 'satSun' : '');?>">
                                                                                    <?php if(!$dontAllowToSchedule){
                                                                                        $studentsCount = $CI->getTobeTestedStudentsCount($dates,$campus['id']);
                                                                                        
                                                                                        if($studentsCount['students_count']){
                                                                                        ?>
                                                                                        <a href="javascript:void(0);" data-title="To be tested students list" data-campus-id="<?php echo $campus['id'];?>" data-classdate="<?php echo $dates;?>" data-uuid="<?php echo $studentsCount['std_uuids'];?>" class="showstdlist hlt-link-a">
                                                                                        <?php echo $studentsCount['students_count'];?>
                                                                                        </a>
                                                                                        <?php }else{?>
                                                                                        0
                                                                                        <?php }?>
                                                                                    <?php }else{ echo "--";}?>
                                                                                </td><?php 
                                                                            }
                                                                            ?>
                                                                        </tr> 
                                                                        <tr>
                                                                            <td style="text-transform: uppercase;">Students leaving tomorrow</td>
                                                                            <?php 
                                                                            foreach($monthDates as $dates){
                                                                                $todaysDay = date('l', strtotime($dates));
                                                                                $dontAllowToSchedule = FALSE;
                                                                                if($todaysDay == "Saturday" || $todaysDay == "Sunday")
                                                                                {
                                                                                    $dontAllowToSchedule = TRUE;
                                                                                }
                                                                                ?><td class="<?php echo ($dontAllowToSchedule ? 'satSun' : '');?>">
                                                                                    <?php //if(!$dontAllowToSchedule){
                                                                                        $studentsCount = $CI->getLeavingTomorrowStudentsCount($dates,$campus['id']);
                                                                                        if($studentsCount['students_count']){
                                                                                        ?>
                                                                                        <a href="javascript:void(0);" data-title="Leaving tomorrow students list" data-campus-id="<?php echo $campus['id'];?>" data-classdate="<?php echo $dates;?>" data-uuid="<?php echo $studentsCount['std_uuids'];?>" class="showstdlist hlt-link-a">
                                                                                        <?php echo $studentsCount['students_count'];?>
                                                                                        </a>
                                                                                        <?php }else{?>
                                                                                        0
                                                                                        <?php }?>
                                                                                    <?php //}else{ echo "--";}?>
                                                                                </td><?php 
                                                                            }
                                                                            ?>
                                                                        </tr> 
                                                                <?php */
                                                            
                                                        }
                                                        ?>
                                                    </table>
                                                    <?php 
//                                                    $data = array('all_classes'=>$all_classes);
//                                                    $this->load->view('tuition/plused_classes', $data);
                                                    ?>
                                                </div>
<!--                                            <div id="mycalendar"></div>-->
						
					</div><!-- End of .content -->
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
			
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	<style>
            #txtClassName_chzn{
                margin-top: 0px!important;
            }
        </style>
        <div style="display: none;" id="dialog_modal_std_showlist" title="" class="windia_showlist_dialog">
            <div id="statsStudentsDiv" class="box">
                <div class="header">
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon">
                        <span >Students list</span>
                        <div class="studentlist-legents">
                        <span class="studentlist-elmentary">Elementary  1 – 33</span>
                        <span class="studentlist-pre-int">Pre-intermediate  34 – 50</span>
                        <span class="studentlist-intermediate">Intermediate  51 – 66</span>
                        <span class="studentlist-upper-int">Upper-intermediate  67 – 83</span>
                        <span class="studentlist-advanced">Advanced  84 - 100</span>
                    </div>
                    </h2>
                </div>
                <div class="content">
                    <div id="statsStudentsList"></div>
                </div>
            </div>
        </div>
        
        
	<div style="display: none;" id="dialog_modal_create_class" title="Classes for the day" class="windia">
            <div id="createClass" class="box">
                <div class="header">
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span id="lblCreateClassHeader">Create new class</span></h2>
                </div>
                <div class="content">
                <form action="" id="frmClass" class="validate" method="post">
                        <div class="row">
                                <div class="form-data" >
                                    <span>All fields are mandatory.</span>
                                </div>
                        </div>
                        <div class="row">
                                <label >
                                    <strong>Date</strong>
                                </label>
                                <div  class="form-data">
                                    <label id="lblPickdate"></label>
                                    <hidden id="hiddClassDate" name="hiddClassDate" value="" />
                                    <hidden id="hiddMyClassDate" name="hiddMyClassDate" value="" />
                                </div>
                        </div>
                        <div id="forLoading" class="row">
                                <label>
                                    <strong>Campus</strong>
                                </label>
                                <div  class="form-data">
                                    <label id="lblCampus"></label>
                                    <hidden id="hiddCampusId" name="hiddCampusId" value="" />
                                </div>
                        </div>
                        <div class="row">
                                <label>
                                    <strong>Course</strong>
                                </label>
                                <div class="form-data">
                                    <select class="required" id="selCourse" name="selCourse"  >
                                        <option value="">Select Course</option>
                                    </select>
                                </div>
                        </div>
                        <div class="row">
                                <label>
                                    <strong>Class level</strong>
                                </label>
                                <div class="form-data">
<!--                                    <input type="text" id="txtClassName" name="txtClassName" class="required alphanumericwithspace" style="max-width:200px;"  maxlength="255" value="" >-->
                                    <select id="txtClassName" name="txtClassName" >
                                        <option value="">Select class level</option>
                                        <option value="Beginner">Beginner</option>
                                        <option value="Elementary">Elementary</option>
                                        <option value="Lower Intermediate">Lower Intermediate</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Higher Intermediate">Higher Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                    </select>
<!--                                    <label for="txtClassName" generated="true" class="error" style="right: 268px; top: 0px;"></label>-->
                                </div>
                        </div>
                        <div class="row">
                                <label>
                                    <strong>Room ID</strong>
                                </label>
                                <div class="form-data">
                                    <input type="text" id="txtRoomNumber" name="txtRoomNumber" class="required alphanumericwithspace" style="max-width:200px;"  maxlength="255" value="" >
                                    <label for="txtRoomNumber" generated="true" class="error" style="right: 268px; top: 0px;"></label>
                                </div>
                        </div>
                        <div class="row">
                                <label>
                                    <strong>Students to be assigned</strong>
                                </label>
                                <div class="form-data">
                                    <a href="javascript:void(0);" id="lnkStudnetsList">Students list (0)</a>
                                    (Click on link to show list of students.)
                                    <div id="lblStudentsPerRooms"></div>
<!--                                    <select class="required" multiple="" id="selBookings" name="selBookings"  >
                                    </select>-->
                                </div>
                        </div>
                        <div class="row">
                            <div class="form-data">
                                <input type="hidden" value="0" name="class_edit_id" id="class_edit_id">
                                <input type="button" value="Submit" name="btnCreateClass" id="btnCreateClass" class="btn btn-tuition">
                                <input type="reset" value="Cancel" name="btnCancel" id="btnCancel" class="btn btn-tuition">
                                <div id="classMessage"></div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <div id="classListing" class="box">
        <div class="header">
            <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon">All classes <span style="color:red;" id="lbl-unassigned"></span><span style="color:red;" id="lbl-unassigned-teacher"></span></h2>
        </div>
        <div id="classListingData" class="content"></div>
        </div>
        </div>
        
        <!-- Teacher and room pop-up -->
        <div style="display: none;" id="dialog_modal_teacher_class" title="Assign teachers" class="techerview">
            <div id="createTeacher" class="box">
                <div class="header">
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span id="lblNewTeacher">Add new teacher</span></h2>
                </div>
                <div class="content">
                    <form action="" id="frmTeacher" class="validate" method="post">
                        <div class="row">
                                <div class="form-data" >
                                    <span>All fields are mandatory.</span>
                                </div>
                        </div>
                        <div class="row">
                                <label >
                                    <strong>Campus-Course-Date</strong>
                                </label>
                                <div class="form-data" >
                                    <label id="lblTechCampus"></label>-<label id="lblTechCourse"></label>-<label id="lblTechDate"></label>
                                    <br /><label id="courseHoursStats" title="Assigned hours / Total hours">Course hours: --/--</label>
                                </div>
                        </div>
                        <div class="row">
                                <label >
                                    <strong>Class level</strong>
                                </label>
                                <div  class="form-data">
                                    <label id="lblClass"></label>
                                </div>
                        </div>
                        <div class="row">
                                <label id="lblTeacher">
                                    <strong>Teacher</strong>
                                </label>
                                <div class="form-data">
                                    <select class="required" id="selTeacher" name="selTeacher"  >
                                        <option value="">Select Teacher</option>
                                    </select>
                                </div>
                        </div>
                        <div class="row">
                                <label>
                                    <strong>From time</strong>
                                </label>
                                <div class="form-data">
                                    <input type="text" style="position: absolute; width: 0px;border: none;padding: 0;" />
                                    <input type="text" id="txtFromTime" name="txtFromTime" class="required" onkeypress="return keyRestrict(event,'');"  style="max-width:200px;"  maxlength="8" value="" >
                                </div>
                        </div>
                        <div class="row">
                                <label>
                                    <strong>To time</strong>
                                </label>
                                <div class="form-data">
                                    <input type="text" id="txtToTime" name="txtToTime" class="required" onkeypress="return keyRestrict(event,'');" style="max-width:200px;"  maxlength="8" value="" >
                                </div>
                        </div>
                        <div class="row">
                                <div class="form-data">
                                    <input type="hidden" value="0" name="lesson_edit_id" id="lesson_edit_id">
                                    <input type="hidden" value="0" name="hidd_class_id" id="hidd_class_id">
                                    <input type="hidden" value="0" name="hidd_course_id" id="hidd_course_id">
                                    <input type="button" value="Submit" name="btnAddTeacher" id="btnAddTeacher" class="btn btn-tuition">
                                    <input type="reset" value="Cancel" name="btnTechCancel" id="btnTechCancel" class="btn btn-tuition">
                                    <div id="teacherMessage"></div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="teacherListing" class="box">
                <div class="header">
                        <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon">All teachers</h2>
                </div>
                <div id="teacherListingData" class="content"></div>
            </div>
        </div>
        
        <div style="display: none;" id="dialog_modal_presence_of_teacher" title="Mark presence of teacher" class="windia-presence">
            <div id="presenceDiv" class="box">
                <div class="header">
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Mark presence of teacher</span></h2>
                </div>
                <div class="content">
                    <form action="" id="frmPresence" class="validate myform" method="post">
<!--                        <div class="row">
                                <div class="form-data" >
                                    <span> * fields are mandatory.</span>
                                </div>
                        </div>-->
                        <div class="row">
                                <label >
                                    <strong>Class-Teacher</strong>
                                </label>
                                <div class="form-data" >
                                    <span id="lblPresenceClassTeacher"></span>
                                </div>
                        </div>
                        <div class="row">
                                <label >
                                    <strong>Mark as present</strong>
                                </label>
                                <div class="form-data" >
                                    <label><input type="checkbox" id="chkPresence" name="chkPresence" value="1" />
                                    Mark teacher as present.</label>
                                </div>
                        </div>
                        <div class="row">
                                <label>
                                    <strong>Notes</strong>
                                </label>
                                <div class="form-data">
                                    <textarea cols="5" rows="8" maxlength="250"  id="txtPrensenceNotes" name="txtPrensenceNotes"></textarea>
                                </div>
                        </div>
                        <div class="row">
                                <div class="form-data">
                                    <input type="hidden" value="0" name="presence_lesson_id" id="presence_lesson_id">
                                    <input type="button" value="Submit" name="btnPresence" id="btnPresence" class="btn btn-tuition">
                                    <input type="reset" value="Cancel" name="btnPresenceCancel" id="btnPresenceCancel" class="btn btn-tuition">
                                    <div id="presenceMessage"></div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div style="display: none;" id="dialog_modal_students_list" title="Students list" class="windia-students">
            <div id="studentsDiv" class="box">
                <div class="header">
                    <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Students list</span>
                    <div class="studentlist-legents">
                        <span class="studentlist-elmentary">Elementary  1 – 33</span>
                        <span class="studentlist-pre-int">Pre-intermediate  34 – 50</span>
                        <span class="studentlist-intermediate">Intermediate  51 – 66</span>
                        <span class="studentlist-upper-int">Upper-intermediate  67 – 83</span>
                        <span class="studentlist-advanced">Advanced  84 - 100</span>
                    </div>
                    </h2>
                </div>
                <div class="content">
                    <div id="studentsList"></div>
                </div>
            </div>
        </div>
        <div style="display: none;" id="dialog_modal_students_list_print" title="Students list" class="windia-students-print">
            <div class="box1">
                <div class="content">
                    <div id="studentsListPrint"></div>
                </div>
            </div>
        </div>
        
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