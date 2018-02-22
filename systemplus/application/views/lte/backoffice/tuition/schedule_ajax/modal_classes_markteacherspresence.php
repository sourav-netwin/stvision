<div class="row">
    <div class="col-sm-12">
        <form id="frmMarkTeachersPresencePerDay" >
            <input type="hidden" id="mtpClassDate" name="mtpClassDate" value="<?php echo $mtpClassDate;?>"/>
            <input type="hidden" id="mtpCampusId" name="mtpCampusId" value="<?php echo $mtpCampusId;?>"/>
        <table id="dataTablePresenceModal" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width:150px;">Class level</th>
                    <th style="width:120px;">Course</th>
                    <th style="width:100px;">#Students placed<br /><span class="agerange" title="Min age - Max age">(Age range)</span></th>
                    <th style="width:110px;">Class date</th>
                    <th class="no-sort">Lessons & Assigned teacher</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $campusId = 0;
                $classDate = '';
                $assignedCount = 0;
                $assignedTeachers = 0; 
                $CI = &get_instance();
                if ($all_classes)
                {
                    foreach ($all_classes as $class) {
                        $campusId = $class['cc_campus_id'];
                        $classDate = $class['class_date'];
                        $assignedCount = $assignedCount + $class["numberofbookings"];
                        $teachersArr = $CI->getTeachersForClass($class["class_id"]);                
                        $assignedTeachers = $teachersArr['teacher_assigned'];
                        ?>
                        <tr>
                            <td>
                                <label class="chReplicatelabel" for="chkClass_<?php echo $class["class_id"];?>">
                                <?php echo htmlspecialchars($class["class_name"].' #'.$class["class_id"]); ?></label>
                                <input type="hidden" id="selClass_<?php echo $class['class_id'];?>" name="mtpClassId[]" value="<?php echo $class['class_id'];?>" />
                            </td>
                            <td class="text-center">
                                <?php echo htmlspecialchars($class["cc_course_name"]); ?>
                            </td>
                            <td class="text-center">
                                <?php 
                                    echo $class["numberofbookings"]."<br />";
                                    echo "<span class='agerange'>(".$class['min_age'] .' - '. $class['max_age'].")</span>";
                                ?>
                            </td>
                            <td ><?php echo date("d/m/Y",strtotime($classDate));?></td>
                            <td class="text-center">
                                <?php echo $CI->getTeacherListingForMarkPresence($class['class_id']);?>
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
        </form>
    </div>
</div>
<script src="<?php echo LTE;?>plugins/mask/jquery.mask.min.js"></script>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">

<script>
    function iCheckInit(){
        $('.chMarkPresenceDay').iCheck('destroy'); 
        $('.chMarkPresenceDay').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
    }
    $(document).ready(function() {
        //chReplicate
        iCheckInit();
        
        $('.chMarkPresenceDay').on('ifUnchecked', function(event){
            var clId = $(this).attr('data-clid');
            $("#selCdComment" + clId).val("");
            $("#selCdComment" + clId).removeAttr('disabled');
        });
        
        $('.chMarkPresenceDay').on('ifChecked', function(event){
            var clId = $(this).attr('data-clid');
            $("#selCdComment" + clId).val("");
            $("#selCdComment" + clId).attr('disabled','disabled');
        });
        
    });
</script>