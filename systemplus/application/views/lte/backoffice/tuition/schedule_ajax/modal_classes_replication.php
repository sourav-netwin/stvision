<div class="row">
    <div class="col-sm-12">
        <form id="frmRepClass" >
            <input type="hidden" name="org_class_date" value="<?php echo $rep_class_date;?>"/>
            <input type="hidden" name="rep_campus_id" value="<?php echo $rep_campus_id;?>"/>
        <table id="dataTableReplicationClassesModal" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width:150px;">Class level</th>
                    <th style="width:100px;">Room ID</th>
                    <th style="width:120px;">Course</th>
                    <th style="width:100px;">#Students placed<br /><span class="agerange" title="Min age - Max age">(Age range)</span></th>
                    <th style="width:110px;">Class date</th>
                    <th style="width:120px;">Replication date</th>
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
                    foreach ($all_classes as $class) {
                        $campusId = $class['cc_campus_id'];
                        $classDate = $class['class_date'];
                        $assignedCount = $assignedCount + $class["numberofbookings"];
                        $teachersArr = $CI->getTeachersForClass($class["class_id"]);                
                        $assignedTeachers = $teachersArr['teacher_assigned'];
                        ?>
                        <tr>
                            <td>
                                <label class="chReplicatelabel" for="chkClass_<?php echo $class["class_id"];?>"><input type="checkbox" name="chkReplicate" class="chReplicate" data-class-id="<?php echo $class["class_id"];?>" id="chkClass_<?php echo $class["class_id"];?>" />
                                <?php echo htmlspecialchars($class["class_name"].' #'.$class["class_id"]); ?></label>
                                <br /><span class="label label-<?php echo ($class["class_type"] == "Regular" ? 'success' : 'warning');?>">
                                    <?php echo htmlspecialchars($class["class_type"]); ?>
                                </span>
                                <input type="hidden" id="selClass_<?php echo $class['class_id'];?>" name="rm_repClassId[]" value="<?php echo $class['class_id'];?>" />
                            </td>
                            <td class="text-center"><?php echo ($class['class_room_number']); ?></td>
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
                                <input type="text" class="form-control classReplicateDate" placeholder="dd/mm/yyyy" data-mask="00/00/0000" id="txtReplClassDate_<?php echo $class["class_id"];?>" data-class-id="<?php echo $class["class_id"];?>" name="rm_repClassDate[]" value="" />
                            </td>
                            <td class="text-center">
                                <?php echo $CI->getTeacherListingForReplication($class['class_id']);?>
                            </td>
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
        $('.chReplicate').iCheck('destroy'); 
        $('.chReplicate').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '10%' // optional
        });
    }
    $(document).ready(function() {
        //chReplicate
        iCheckInit();
        
        $('.chReplicate').on('ifUnchecked', function(event){
            var classId = $(this).attr('data-class-id');
            var inputName = $("#selClass_" + classId).attr('name');
            $("#selClass_" + classId).attr('name','rm_repClassId[]');
            $("#txtReplClassDate_" + classId).removeAttr('required');
            $("#txtReplClassDate_" + classId).attr('name','rm_repClassDate[]');
            $("#teachersDataTableReplication_" + classId + " input[type=text]").removeAttr('required');
            
        });
        
        $('.chReplicate').on('ifChecked', function(event){
            var classId = $(this).attr('data-class-id');
            $("#selClass_" + classId).attr('name',"repClassId[]");
            $("#txtReplClassDate_" + classId).attr('required', 'required');
            $("#txtReplClassDate_" + classId).attr('name','repClassDate[]');
            $("#teachersDataTableReplication_" + classId + " input[type=text]").attr('required','required');
        });
        
        $( ".classReplicateDate" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,		  
            dateFormat: "dd/mm/yy",
            minDate: "<?php echo date("d/m/Y",strtotime($rep_class_date . "+1 days"));?>",
            numberOfMonths: 1,
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day != 0), ''];// && day != 6 // weekend validation
            }
//            onClose: function( selectedDate ) {
//                    $( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
//            }
        });
        
        $.validator.addMethod('mindate',function(v,el,minDate){
            if (this.optional(el)){
                return true;
            }
            var curDate = $(el).datepicker('getDate');
            var day = curDate.getDay();
            if(day == 0) return false; //|| day == 6 // weekend validation
            return minDate < curDate;
        }, 'Please specify a correct date');
        
        $.validator.addMethod("time24", function(value, element) {
            if (!/^\d{2}:\d{2}$/.test(value)) return false;
            var parts = value.split(':');
            if (parts[0] > 23 || parts[1] > 59) return false;
            return true;
        }, "Invalid time");
        
        $("#frmRepClass").validate({
            errorElement:"div",
            ignore: "disabled",
            rules: {
            },
            messages: {
            },
            submitHandler: function(form) {

            }
        });
                
        $.validator.addClassRules("classReplicateDate", {
            //required: true,
            mindate: new Date(<?php echo date("Y",strtotime($rep_class_date));?>,<?php echo date("m",strtotime($rep_class_date)) - 1;?>,<?php echo date("d",strtotime($rep_class_date));?>)
        },'required.');
        $.validator.addMethod("required", function(value, element) {
            if (value == "" || typeof value == 'undefined') return false;
            return true;
        }, "required");
        $.validator.addClassRules("validTime", {
           //required:true,
           time24: true
        },'Invalid time');
        
//        $.validator.addMethod('minDate', function(value, element) {
//            return parseInt(value) % 5 == 0
//        }, 'Number must be divisible by 5');
        
//        $.validator.addClassRules("classReplicateDate", {
//            minDate: true
//        },'class date should be greater than current day.');
        
    });
</script>