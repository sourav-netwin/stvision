<script>
    $(document).ready(function() {
        
    });
</script>

<table style="width: 100%;" id="teachersDataTableReplication_<?php echo $classId;?>" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width:150px;">Teacher</th>
<!--            <th>Class level</th>-->
            <th style="width:100px;">From time</th>
            <th style="width:100px;">To time</th>
            <th style="width:100px;">New from time</th>
            <th style="width:100px;">New to time</th>
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
                        <input type="hidden" name="lessonId[<?php echo $teacher["cl_class_id"];?>][<?php echo $teacher["cl_id"];?>][teacherId]" value="<?php echo $teacher['cl_teacher_id'];?>">
                    </td>
<!--                    <td class="text-center"><?php //echo $teacher["class_name"]." #".$teacher["cl_class_id"]; ?></td>-->
                    <td class="text-center"><?php echo $teacher['cl_from_time']; ?></td>
                    <td class="text-center"><?php echo $teacher['cl_to_time']; ?></td>
                    <td class="text-center"><input data-mask="00:00" placeholder="hh:mm" type="text" class="form-control validTime removeStyle" id="txtRepFromTime_<?php echo $teacher["cl_id"];?>" name="lessonId[<?php echo $teacher["cl_class_id"];?>][<?php echo $teacher["cl_id"];?>][newFromTime]" value="<?php echo $teacher['cl_from_time']; ?>" /></td>
                    <td class="text-center"><input data-mask="00:00" placeholder="hh:mm" type="text" class="form-control validTime removeStyle" id="txtRepToTime_<?php echo $teacher["cl_id"];?>" name="lessonId[<?php echo $teacher["cl_class_id"];?>][<?php echo $teacher["cl_id"];?>][newToTime]" value="<?php echo $teacher['cl_to_time']; ?>" /></td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>