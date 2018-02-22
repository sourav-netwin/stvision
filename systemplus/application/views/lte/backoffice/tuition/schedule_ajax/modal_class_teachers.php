<script>
    $(document).ready(function() {
        
        $( ".dialogteacherbtnview" ).click(function() {
                var iddia = $(this).attr("id").replace('_btn','');
                var myHtml = $("#"+iddia).html();
                $("#dialog_modal_teacher_view").modal('show');
                $("#viewTeacherModalBody").html(myHtml);
                return false;
        });
        /*$( ".dialogteacherbtnview" ).click(function() {
                var iddia = $(this).attr("id").replace('_btn','');
                //alert(iddia.replace('_btn',''));
                $( "#"+iddia ).dialog("open");
                return false;
        });

        $( ".teacherdetailview" ).dialog({
                autoOpen: false,
                modal: true,
                buttons: [{
                        text: "Close",
                        click: function() { $(this).dialog("close"); }
                }]
        });
        
        $( ".windia-presence" ).dialog({
                autoOpen: false,
                modal: true,
                hide: "",
                show: "",
                width : 500,
                height : 635,
                buttons: [{
                        text: "Close",
                        click: function() { $(this).dialog("close"); }
                }]
        });
        
        */
        
        // ! Table
        // Initialize DataTables for dynamic tables
        //$('table.dynamicTechers').table();
        
    });
</script>

<table style="width: 100%;" id="teachersDataTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th >Teacher</th>
            <th>Class level</th>
            <th>From time</th>
            <th>To time</th>
            <th>Date</th>
            <th>Presence</th>
            <th class="no-sort">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($all_teachers)
            foreach ($all_teachers as $teacher) {
            //cl_id,class_campus_course_id,class_date,teacher_name,class_name,cc_campus_id,cc_course_type,nome_centri
                ?>
                <tr>
                    <td >
                        <?php echo html_entity_decode($teacher["teacher_name"]); ?>
                        <div style="display: none;" id="dialog_modal_tech_<?php echo $teacher['cl_id'] ?>" title="Teacher detail"  class="teacherdetailview">
                            <p><strong>Teacher: </strong><?php echo html_entity_decode($teacher["teacher_name"]); ?></p>
                            <p><strong>Class level: </strong><?php echo $teacher["class_name"]." #".$teacher["cl_class_id"]; ?></p>
                            <p><strong>From time: </strong><?php echo date("H:i",strtotime($teacher["cl_from_time"])); ?></p>
                            <p><strong>To time: </strong><?php echo date("H:i",strtotime($teacher["cl_to_time"])); ?></p>
                            <p><strong>Date: </strong><?php echo date('d/m/Y', strtotime($teacher["class_date"])); ?></p>
                        </div>
                    </td>
                    <td class="text-center"><?php echo $teacher["class_name"]." #".$teacher["cl_class_id"]; ?></td>
                    <td class="text-center"><?php echo date("H:i",strtotime($teacher["cl_from_time"])); ?></td>
                    <td class="text-center"><?php echo date("H:i",strtotime($teacher['cl_to_time'])); ?></td>
                    <td class="text-center"><?php echo date('d/m/Y', strtotime($teacher["class_date"])); ?></td>
                    <td class="text-center">
                        <a data-original-title="Presence of teacher" data-toggle="tooltip" href="javascript:void(0);" data-id="<?php echo $teacher["cl_id"]; ?>" class="presence_of_teacher">
                            <i class="fa fa-user"></i>&nbsp;Presence of teacher
                        </a>
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a data-original-title="View" href="javascript:void(0);" data-toggle="tooltip" id="dialog_modal_tech_btn_<?php echo $teacher["cl_id"]; ?>" class="dialogteacherbtnview min-wd-24 btn btn-xs btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a data-original-title="Edit" data-toggle="tooltip" class="editTeacher min-wd-24 btn btn-xs btn-warning" data-id="<?php echo $teacher['cl_id'];?>" data-from-time="<?php echo date("H:i",strtotime($teacher['cl_from_time']));?>" data-to-time="<?php echo date("H:i",strtotime($teacher['cl_to_time']));?>" data-teach-id="<?php echo $teacher['cl_teacher_id'];?>"  href="javascript:void(0);">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a data-original-title="Delete" data-toggle="tooltip" class="deleteTeacher min-wd-24 btn btn-xs btn-danger" data-id="<?php echo $teacher['cl_id'];?>"  href="javascript:void(0);">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>