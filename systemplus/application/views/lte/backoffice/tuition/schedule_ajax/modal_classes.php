<script>
    $(document).ready(function () {
        var diaH = $(window).height() * 0.9;
        var diaW = $(window).width() * 0.9;
        $(".dialogbtnview").click(function () {
            var iddia = $(this).attr("id").replace('_btn', '');
            //alert(iddia.replace('_btn',''));
            var hiddCampusId = $("#hiddCampusId").val();
            var hiddMyClassDate = $("#hiddMyClassDate").val();
            var classId = $(this).attr('data-id');
            var courseId = $(this).attr('data-course-id');
            var toview = "toview";
            // load students for the campus
            var loadingDiv = "<div class='showloading'></div>";
            $(".view_students_placed_" + classId).html(loadingDiv);
            $.post(SITE_PATH + "tuitions/getCampusStudents", {'campusId': hiddCampusId, 'toview': toview, 'dateOfClass': hiddMyClassDate, 'courseId': courseId}, function (data) {
                $(".view_students_placed_" + classId).html(data);
            });

            $("#" + iddia).modal("show");
            return false;
        });

        $(".classview").dialog({
            autoOpen: false,
            modal: true,
            buttons: [{
                    text: "Close",
                    click: function () {
                        $(this).dialog("close");
                    }
                }]
        });

        /*$( ".windia-students" ).dialog({
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
         }); */

        // ! Table
        // Initialize DataTables for dynamic tables
        //        var table = $.fn.dataTable.fnTables();
        //        if ( table.length > 0 ) {
        //            $(table).dataTable().fnDestroy();
        //        }
        //$('table.dynamic').table();
        initDataTable("dataTableClassesModal");
    });
</script>
<div class="row">
    <div class="col-sm-12">
        <table id="dataTableClassesModal" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Class level</th>
                    <th>Room ID</th>
                    <th>Course</th>
                    <th>#Students placed<br /><span class="agerange" title="Min age - Max age">(Age range)</span></th>
                    <th>Class availability</th>
                    <th>Nationality</th>
                    <th>Testing score</th>
                    <th>Teachers<br /><span class="agerange">(From time - to time)</span></th>
                    <th class="no-sort">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $campusId = 0;
                $classDate = '';
                $assignedCount = 0;
                $assignedTeachers = 0;
                $teacherCountArr = array();
                $classIdsArr = array();
                $CI = &get_instance();
                if ($all_classes)
                    foreach ($all_classes as $class) {
                        $campusId = $class['cc_campus_id'];
                        $classDate = $class['class_date'];
                        $assignedCount = $assignedCount + $class["numberofbookings"];
                        $nationalityFlags = $class['htmlImg']; //$CI->getNationalityFlags($class["class_id"]);
                        $knowledgeLangRange = $class['lang_min_max']; //$CI->getStudentsKnowledgeLanguage($class["class_id"]);
                        $teachersArr = $CI->getTeachersForClass($class["class_id"]);
                        $classIdsArr[] = $class["class_id"];
                        //                $currTeacher = $teachersArr['teachersArr'];
                        //                if(count($currTeacher))
                        //                foreach($currTeacher as $tcount){
                        //                    array_push($teacherCountArr, $tcount);
                        //                }
                        $teacherForClass = $teachersArr['cellValue'];
                        $assignedTeachers = $teachersArr['teacher_assigned'];
                        ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($class["class_name"] . ' #' . $class["class_id"]); ?>
                                <br /><span class="label label-<?php echo ($class["class_type"] == "Regular" ? 'success' : 'warning');?>">
                                    <?php echo htmlspecialchars($class["class_type"]); ?>
                                </span>
                                <div id="dialog_modal_<?php echo $class["class_id"]; ?>" class="modal">
                                    <div class="modal-dialog modal-lg-95-per">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-label="Close" onclick="$('#dialog_modal_<?php echo $class["class_id"]; ?>').modal('hide');
                                                                $('body').addClass('modal-open');"  class="close" type="button">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Class detail - <?php echo htmlspecialchars($class["class_name"] . ' #' . $class["class_id"]); ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-3"><strong>Class level: </strong><label class="std-classname"><?php echo htmlspecialchars($class["class_name"] . ' #' . $class["class_id"]); ?></label></div>
                                                    <div class="col-sm-3"><strong>Room ID: </strong><label class="std-classroom"><?php echo ($class["class_room_number"]); ?></div>
                                                    <div class="col-sm-3"><strong>Course: </strong><label class="std-coursename"><?php echo htmlspecialchars($class["cc_course_name"]); ?></div>
                                                    <div class="col-sm-3"><strong>Class type: </strong><span class="label label-<?php echo ($class["class_type"] == "Regular" ? 'success' : 'warning');?>"><?php echo htmlspecialchars($class["class_type"]); ?></span></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3"><strong>#Students placed: </strong><label class="std-noofstudents"><?php echo $class["numberofbookings"]; ?></div>
                                                    <div class="col-sm-3"><strong>Class availability: </strong>
                                                        <?php
                                                        $availablity = CLASS_STUDENTS_AVALABILITY - $class["numberofbookings"];
                                                        if ($availablity <= CLASS_STUDENTS_AVALABILITY) {
                                                            echo "<label style='color:green'>" . $availablity . "</label>";
                                                        } else
                                                            echo "<label style='color:red'>+" . $availablity . "</label>";
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-3"><strong>Nationality: </strong><?php echo $nationalityFlags; ?></div>
                                                    <div class="col-sm-3"><strong>Testing score: </strong><?php echo $knowledgeLangRange; ?></div>
                                                </div>

                                                <div class="box box-primary">
                                                    <div class="box-header">
                                                        <h4 class="box-title">Students list</h4>
                                                        <div class="studentlist-legents pull-right">
                                                            <div class="studentlist-elmentary">Elementary  1 – 33</div>
                                                            <div class="studentlist-pre-int">Pre-intermediate  34 – 50</div>
                                                            <div class="studentlist-intermediate">Intermediate  51 – 66</div>
                                                            <div class="studentlist-upper-int">Upper-intermediate  67 – 83</div>
                                                            <div class="studentlist-advanced">Advanced  84 - 100</div>
                                                        </div>
                                                    </div>

                                                    <div class="content viewStudents">
                                                        <div class="view_students_placed_<?php echo $class["class_id"] ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </td>
                            <td class="text-center"><?php echo ($class['class_room_number']); ?></td>
                            <td class="text-center">
                                <?php echo htmlspecialchars($class["cc_course_name"]); ?>
                            </td>
                            <td class="text-center">
                                <?php
                                echo $class["numberofbookings"] . "<br />";
                                echo "<span class='agerange'>(" . $class['min_age'] . ' - ' . $class['max_age'] . ")</span>";
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                $availablity = CLASS_STUDENTS_AVALABILITY - $class["numberofbookings"];
                                if ($availablity <= CLASS_STUDENTS_AVALABILITY) {
                                    echo "<div style='color:green'>" . $availablity . "</div>";
                                } else
                                    echo "<div style='color:red'>+" . $availablity . "</div>";
                                ?></td>
                            <td class="text-center"> <?php
                                echo $nationalityFlags;
                                //                            echo "<div class='natinality-div' title='".$nationalityFlags."'>";
                                //                            if(strlen($nationalityFlags) > 150)
                                //                                echo substr($nationalityFlags, 0,150);
                                //                            else
                                //                                echo trim($nationalityFlags,', ');
                                //                            echo "</div>";
                                ?> </td>
                            <td class="text-center">
                                <?php echo $knowledgeLangRange; ?> 
                            </td>
                            <td class="text-center"><?php echo $teacherForClass; ?></td>
                            <td class="text-center min-wd-116">
                                <div class="btn-group">
                                    <a data-coursename="<?php echo htmlspecialchars($class["cc_course_name"]); ?>" data-toggle="tooltip" data-class="<?php echo htmlspecialchars($class["class_name"]); ?>" data-original-title="Assign teachers" href="javascript:void(0);" data-course-id="<?php echo $class["class_campus_course_id"]; ?>" data-id="<?php echo $class["class_id"]; ?>" class="assign_teacher_room min-wd-24 btn btn-xs btn-primary">
                                        <i class="fa fa-user"></i>
                                    </a>
                                    <a data-original-title="View" href="javascript:void(0);" data-toggle="tooltip" id="dialog_modal_btn_<?php echo $class["class_id"]; ?>" data-course-id="<?php echo $class['class_campus_course_id']; ?>" data-id="<?php echo $class['class_id']; ?>" class="dialogbtnview min-wd-24 btn btn-xs btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a data-original-title="Export" href="javascript:void(0);" data-toggle="tooltip"  data-course-id="<?php echo $class['class_campus_course_id']; ?>" data-id="<?php echo $class['class_id']; ?>" class="export_excel min-wd-24 btn btn-xs btn-warning">
                                        <i class="fa fa-file-excel-o"></i>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a data-original-title="Print" data-toggle="tooltip" href="javascript:void(0);" data-course-id="<?php echo $class['class_campus_course_id']; ?>" data-id="<?php echo $class['class_id']; ?>" class="dialogbtnprint min-wd-24 btn btn-xs btn-info">
                                        <i class="fa fa-print"></i>
                                    </a>
                                    <a data-original-title="Add students and edit class" data-toggle="tooltip" class="editClass min-wd-24 btn btn-xs btn-warning" data-id="<?php echo $class['class_id']; ?>" href="javascript:void(0);">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a data-original-title="Delete" data-toggle="tooltip" class="deleteClass min-wd-24 btn btn-xs btn-danger" data-id="<?php echo $class['class_id']; ?>" href="javascript:void(0);">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                $lblunassignedCount = $totalBookingForDay - $bookingsAssigned;
                //$assignedTeachers = //count(array_unique($teacherCountArr));
                $assignedTeachers = $CI->_getClassTeachersCountForTheDay($classIdsArr);
                //print_r($assignedTeachers);die;
                $lblunassignedTeacherCount = $availableTeachers - $assignedTeachers;
                ?>
            </tbody>
        </table>
    </div>
</div>
<input type="hidden" id="hidd-lblunassignedCount" value="<?php echo $lblunassignedCount; ?>" />
<input type="hidden" id="hidd-lblunassignedTeacherCount" value="<?php echo $lblunassignedTeacherCount; ?>" />
<input type="hidden" id="hidd-class-campus-id" value="<?php echo $campusId; ?>" />
<input type="hidden" id="hidd-class-date" value="<?php echo $classDate; ?>" />
<input type="hidden" id="hidd-class-count" value="<?php echo count($all_classes); ?>" />

<script>
    $(function () {
        $( "body" ).on( "click", ".export_excel", function() {
            var hiddCampusId = $("#hiddCampusId").val();
            var hiddMyClassDate = $("#hiddMyClassDate").val();
            var classId = $(this).attr('data-id');
            var courseId = $(this).attr('data-course-id');
            $.post('<?php echo base_url(); ?>' + "index.php/tuitions/getCampusStudentsForExport", {'campusId': hiddCampusId, 'dateOfClass': hiddMyClassDate, 'courseId': courseId, 'classId': classId}, function (data) {
                var $a = $("<a>");
                $a.attr("href", data.file);
                $("body").append($a);
                $a.attr("download", "" + data.file_name + ".xls");
                $a[0].click();
                $a.remove();
            }, 'json');
        });
    });
</script>