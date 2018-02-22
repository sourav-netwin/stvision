<script>
    $(document).ready(function() {
        
    });
</script>

<table style="width: 100%;" id="teachersDataTableReplication_<?php echo $classId;?>" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-center" style="width:150px;">Teacher</th>
<!--            <th>Class level</th>-->
            <th class="text-center" style="width:100px;">From time</th>
            <th class="text-center" style="width:100px;">To time</th>
            <th class="text-center" style="width:100px;">Mark presence</th>
            <th class="text-center" style="width:100px;">Comment</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($all_teachers)
        {
            foreach ($all_teachers as $teacher) {
            //cl_id,class_campus_course_id,class_date,teacher_name,class_name,cc_campus_id,cc_course_type,nome_centri
                ?>
                <tr>
                    <td >
                        <?php echo html_entity_decode($teacher["teacher_name"]); ?>
                    </td>
<!--                    <td class="text-center"><?php //echo $teacher["class_name"]." #".$teacher["cl_class_id"]; ?></td>-->
                    <td class="text-center"><?php echo $teacher['cl_from_time']; ?></td>
                    <td class="text-center"><?php echo $teacher['cl_to_time']; ?></td>
                    <td class="text-center">
                        <input type="checkbox" <?php echo ($teacher['cl_presence_of_teacher'] == 1 ? "checked='checked'" : "");?> <?php echo ($teacher['cl_course_director_marked'] == 1 && $this->session->userdata('role') == 400 ? "disabled='disabled'" : "");?> class="chMarkPresenceDay" id="chkMarkPresence<?php echo $teacher["cl_id"];?>" data-clid="<?php echo $teacher["cl_id"];?>" name="lessonId[<?php echo $teacher["cl_class_id"];?>][<?php echo $teacher["cl_id"];?>][chkMarkPresence]" value="1" />
                    </td>
                    <td class="text-center">
                        <select class="form-control removeSelStyle" <?php echo ($teacher['cl_course_director_marked'] == 1 || $teacher['cl_presence_of_teacher'] == 1 ? "disabled='disabled'" : "");?> id="selCdComment<?php echo $teacher["cl_id"];?>" name="lessonId[<?php echo $teacher["cl_class_id"];?>][<?php echo $teacher["cl_id"];?>][selCdComment]">
                            <option value="">Select</option>
                            <option <?php echo ($teacher['cl_lesson_note'] == "Sickness" ? "selected='selected'" : "");?> value="Sickness">Sickness</option>
                            <option <?php echo ($teacher['cl_lesson_note'] == "Late arrival" ? "selected='selected'" : "");?> value="Late arrival">Late arrival</option>
                            <option <?php echo ($teacher['cl_lesson_note'] == "Early departure" ? "selected='selected'" : "");?> value="Early departure">Early departure</option>
                            <option <?php echo ($teacher['cl_lesson_note'] == "Other" ||
                                                        ($teacher['cl_lesson_note'] != "Sickness" && 
                                                        $teacher['cl_lesson_note'] != "Late arrival" && 
                                                        $teacher['cl_lesson_note'] != "Early departure" && 
                                                        $teacher['cl_lesson_note'] != "" && 
                                                        $teacher['cl_presence_of_teacher'] == 0)
                                                        ? "selected='selected'" : "");?> value="Other">Other</option>
                        </select>
                    </td>
                </tr>
                <?php
            }
        }
        else{
                ?>
                    <tr>
                        <td colspan="5">No records found.</td>
                    </tr>
                <?php 
            }
        ?>
    </tbody>
</table>
<style>
    .removeSelStyle{
        width:137px;
    }
</style>