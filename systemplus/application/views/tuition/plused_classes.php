<script>
    $(document).ready(function() {
        var diaH = $(window).height() * 0.9;
        var diaW = $(window).width() * 0.9;
        $( ".dialogbtnview" ).click(function() {
                var iddia = $(this).attr("id").replace('_btn','');
                //alert(iddia.replace('_btn',''));
                var hiddCampusId = $("#hiddCampusId").val();  
                var hiddMyClassDate = $("#hiddMyClassDate").val(); 
                var classId = $(this).attr('data-id'); 
                var courseId = $(this).attr('data-course-id'); 
                var toview = "toview";
                // load students for the campus
                var loadingDiv = "<div class='showloading'></div>";
                $(".view_students_placed_" + classId).html(loadingDiv);
                $.post( SITE_PATH + "tuitions/getCampusStudents",{'campusId':hiddCampusId,'toview':toview,'dateOfClass':hiddMyClassDate,'courseId':courseId}, function( data ) {
                    $(".view_students_placed_" + classId).html(data);
                }); 
                $( "#"+iddia ).dialog({
                    modal: true,
                    hide: "",
                    show: "",
                    width : diaW,
                    height : diaH,
                    open: function( event, ui ) {
                        var pHeight = $("#dialog_modal_"+classId).height();//$(".classview").height();
                        $(".viewStudents").css('height',(pHeight - 160));
                    }
                });
                $( "#"+iddia ).dialog("open");
                return false;
        });
        
        $( ".classview" ).dialog({
                autoOpen: false,
                modal: true,
                buttons: [{
                        text: "Close",
                        click: function() { $(this).dialog("close"); }
                }]
        });
       
        $( ".windia-students" ).dialog({
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
                        $("#studentsList").css('height',(diaH - 160));
                    }
        });
        
        // ! Table
        // Initialize DataTables for dynamic tables
//        var table = $.fn.dataTable.fnTables();
//        if ( table.length > 0 ) {
//            $(table).dataTable().fnDestroy();
//        }
        $('table.dynamic').table();
    });
</script>

<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[1,"asc"]],"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
    <thead>
        <tr>
            <th style="border-left: 1px solid #ccc;">Class level</th>
            <th>Room ID</th>
            <th>Course</th>
            <th>#Students placed<br /><span class="agerange" title="Min age - Max age">(Age range)</span></th>
            <th>Class availability</th>
            <th>Nationality</th>
            <th>Testing score</th>
            <th>Teachers<br /><span class="agerange">(From time - to time)</span></th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $campusId = 0;
        $classDate = '';
        $assignedCount = 0;
        $assignedTeachers = 0; 
        $teacherCountArr = array();
        $CI = &get_instance();
        if ($all_classes)
            foreach ($all_classes as $class) {
                $campusId = $class['cc_campus_id'];
                $classDate = $class['class_date'];
                $assignedCount = $assignedCount + $class["numberofbookings"];
                $nationalityFlags = $class['htmlImg'];//$CI->getNationalityFlags($class["class_id"]);
                $knowledgeLangRange = $class['lang_min_max'];//$CI->getStudentsKnowledgeLanguage($class["class_id"]);
                $teachersArr = $CI->getTeachersForClass($class["class_id"]);                
//                $currTeacher = $teachersArr['teachersArr'];
//                if(count($currTeacher))
//                foreach($currTeacher as $tcount){
//                    array_push($teacherCountArr, $tcount);
//                }
                $teacherForClass = $teachersArr['cellValue'];
                $assignedTeachers = $teachersArr['teacher_assigned'];
                ?>
                <tr>
                    <td class="center">
                        <?php echo htmlspecialchars($class["class_name"].' #'.$class["class_id"]); ?>
                        <div style="display: none;" id="dialog_modal_<?php echo $class["class_id"]; ?>" title="Class detail - <?php echo htmlspecialchars($class["class_name"].' #'.$class["class_id"]); ?>" class="classview">
                            <div style="height:95px;">
                            <span class="lbl-space"><strong>Class level: </strong><label class="std-classname"><?php echo htmlspecialchars($class["class_name"].' #'.$class["class_id"]); ?></label></span>
                            <span class="lbl-space"><strong>Room ID: </strong><label class="std-classroom"><?php echo ($class["class_room_number"]); ?></span>
                            <span class="lbl-space"><strong>Course: </strong><label class="std-coursename"><?php echo htmlspecialchars($class["cc_course_name"]); ?></span>
                            <span class="lbl-space"><strong>#Students placed: </strong><label class="std-noofstudents"><?php echo $class["numberofbookings"]; ?></span>
                            <span class="lbl-space"><strong>Class availability: </strong>
                                <?php 
                                    $availablity = CLASS_STUDENTS_AVALABILITY - $class["numberofbookings"];
                                    if($availablity <= CLASS_STUDENTS_AVALABILITY){
                                        echo "<label style='color:green'>".$availablity."</label>";
                                    }
                                    else
                                        echo "<label style='color:red'>+".$availablity."</label>";
                                ?>
                            </span>
                            <span class="lbl-space"><strong>Nationality: </strong><?php echo $nationalityFlags; ?></span>
                            <span class="lbl-space"><strong>Testing score: </strong><?php echo $knowledgeLangRange; ?></span>
                            </div>
                            
                            <div class="box">
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
                                <div class="content viewStudents">
                                    <div class="view_students_placed_<?php echo $class["class_id"] ?>"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="center"><?php echo ($class['class_room_number']); ?></td>
                    <td class="center">
                        <?php echo htmlspecialchars($class["cc_course_name"]); ?>
                    </td>
                    <td class="center">
                        <?php 
                                echo $class["numberofbookings"]."<br />";
                                echo "<span class='agerange'>(".$class['min_age'] .' - '. $class['max_age'].")</span>";
                        ?>
                    </td>
                    <td class="center">
                        <?php 
                            $availablity = CLASS_STUDENTS_AVALABILITY - $class["numberofbookings"];
                            if($availablity <= CLASS_STUDENTS_AVALABILITY){
                                echo "<div style='color:green'>".$availablity."</div>";
                            }
                            else
                                echo "<div style='color:red'>+".$availablity."</div>";
                        ?></td>
                    <td class="center"> <?php echo $nationalityFlags;
//                            echo "<div class='natinality-div' title='".$nationalityFlags."'>";
//                            if(strlen($nationalityFlags) > 150)
//                                echo substr($nationalityFlags, 0,150);
//                            else
//                                echo trim($nationalityFlags,', ');
//                            echo "</div>";
                    ?> </td>
                    <td class="center">
                        <?php echo $knowledgeLangRange;?> 
                    </td>
                    <td class="center"><?php echo $teacherForClass;?></td>
                    <td class="center operation">
                        <a data-coursename="<?php echo htmlspecialchars($class["cc_course_name"]); ?>" data-class="<?php echo htmlspecialchars($class["class_name"]); ?>" title="Assign teachers" href="javascript:void(0);" data-course-id="<?php echo $class["class_campus_course_id"]; ?>" data-id="<?php echo $class["class_id"]; ?>" class="assign_teacher_room">
                            <span class="icon-user"></span>&nbsp;
                        </a>
                        <a title="View" href="javascript:void(0);" id="dialog_modal_btn_<?php echo $class["class_id"]; ?>" data-course-id="<?php echo $class['class_campus_course_id'];?>" data-id="<?php echo $class['class_id'];?>" class="dialogbtnview">
                            <span  class="icon-eye-open"></span>
                        </a>
                        <a title="Print" href="javascript:void(0);" data-course-id="<?php echo $class['class_campus_course_id'];?>" data-id="<?php echo $class['class_id'];?>" class="dialogbtnprint">
                            <span  class="icon-print"></span>
                        </a>
                        <a title="Add students and edit class" class="editClass" data-id="<?php echo $class['class_id'];?>" href="javascript:void(0);">
                            <span class="icon-edit"></span>
                        </a>
                        <a title="Delete" class="deleteClass" data-id="<?php echo $class['class_id'];?>" href="javascript:void(0);">
                            <span class="icon-remove"></span>
                        </a>
                    </td>
                </tr>
                <?php
            }
            $lblunassignedCount = $totalBookingForDay - $bookingsAssigned;
            //$assignedTeachers = //count(array_unique($teacherCountArr));
            $lblunassignedTeacherCount = $availableTeachers - $assignedTeachers;
        ?>
    </tbody>
</table>
<input type="hidden" id="hidd-lblunassignedCount" value="<?php echo $lblunassignedCount;?>" />
<input type="hidden" id="hidd-lblunassignedTeacherCount" value="<?php echo $lblunassignedTeacherCount;?>" />
<input type="hidden" id="hidd-class-campus-id" value="<?php echo $campusId;?>" />
<input type="hidden" id="hidd-class-date" value="<?php echo $classDate;?>" />