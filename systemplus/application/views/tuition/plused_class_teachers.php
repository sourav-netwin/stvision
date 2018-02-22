<script>
    $(document).ready(function() {
        $( ".dialogteacherbtnview" ).click(function() {
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
        
        
        
        // ! Table
        // Initialize DataTables for dynamic tables
        $('table.dynamicTechers').table();
    });
</script>

<table class="dynamicTechers styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[1,"asc"]],"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
    <thead>
        <tr>
            <th style="border-left: 1px solid #ccc;">Teacher</th>
            <th>Class level</th>
            <th>From time</th>
            <th>To time</th>
            <th>Date</th>
            <th>Presence</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($all_teachers)
            foreach ($all_teachers as $teacher) {
            //cl_id,class_campus_course_id,class_date,teacher_name,class_name,cc_campus_id,cc_course_type,nome_centri
                ?>
                <tr>
                    <td class="center">
                        <?php echo html_entity_decode($teacher["teacher_name"]); ?>
                        <div style="display: none;" id="dialog_modal_tech_<?php echo $teacher['cl_id'] ?>" title="Teacher detail"  class="teacherdetailview">
                            <p><strong>Teacher: </strong><?php echo html_entity_decode($teacher["teacher_name"]); ?></p>
                            <p><strong>Class level: </strong><?php echo $teacher["class_name"]." #".$teacher["cl_class_id"]; ?></p>
                            <p><strong>From time: </strong><?php echo $teacher["cl_from_time"]; ?></p>
                            <p><strong>To time: </strong><?php echo $teacher["cl_to_time"]; ?></p>
                            <p><strong>Date: </strong><?php echo date('d/m/Y', strtotime($teacher["class_date"])); ?></p>
                        </div>
                    </td>
                    <td class="center"><?php echo $teacher["class_name"]." #".$teacher["cl_class_id"]; ?></td>
                    <td class="center"><?php echo $teacher["cl_from_time"]; ?></td>
                    <td class="center"><?php echo $teacher['cl_to_time']; ?></td>
                    <td class="center"><?php echo date('d/m/Y', strtotime($teacher["class_date"])); ?></td>
                    <td class="center operation">
                        <a title="Presence of teacher" href="javascript:void(0);" data-id="<?php echo $teacher["cl_id"]; ?>" class="presence_of_teacher">
                            <span class="icon-user"></span>&nbsp;Presence of teacher
                        </a>
                    </td>
                    <td class="center operation">
                        <a title="View" href="javascript:void(0);" id="dialog_modal_tech_btn_<?php echo $teacher["cl_id"]; ?>" class="dialogteacherbtnview">
                            <span class="icon-eye-open"></span>
                        </a>
                        <a title="Edit" class="editTeacher" data-id="<?php echo $teacher['cl_id'];?>" data-from-time="<?php echo $teacher['cl_from_time'];?>" data-to-time="<?php echo $teacher['cl_to_time'];?>" data-teach-id="<?php echo $teacher['cl_teacher_id'];?>" href="javascript:void(0);">
                            <span class="icon-edit"></span>
                        </a>
                        <a title="Delete" class="deleteTeacher" data-id="<?php echo $teacher['cl_id'];?>" href="javascript:void(0);">
                            <span class="icon-remove"></span>
                        </a>
                    </td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>