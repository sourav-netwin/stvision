<section class="">
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <form method="post" class="form-horizontal" id="frmRooms" action="">
        <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="selCampus">Campus</label>
                    <div class="col-sm-4">
                        <select class="form-control required" id="selCampus" name="selCampus"  >
                            <option value="">Select Campus</option>
                            <?php if($campusList){
                                    foreach ($campusList as $campus){
                                        ?><option <?php echo ($formData['selCampus'] == $campus['id'] ? "selected='selected'" : '');?> value="<?php echo $campus['id'];?>"><?php echo $campus['nome_centri'];?></option><?php 
                                    }
                            }
                            ?>
                        </select>
                        <div class="error"><?php echo form_error('selCampus');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtNumberOfRooms">Number of rooms</label>
                    <div class="col-sm-4">
                        <input type="text" id="txtNumberOfRooms" name="txtNumberOfRooms" class="form-control required" onkeypress="return keyRestrict(event,'1234567890');" maxlength="5" value="<?php echo (int)set_value('txtNumberOfRooms',  $formData['txtNumberOfRooms']);?>" >
                        <div class="error"><?php echo form_error('txtNumberOfRooms');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtNumberOfStudents">Number of students / room</label>
                    <div class="col-sm-4">
                        <input value="<?php echo (int)set_value('txtNumberOfStudents',$formData['txtNumberOfStudents']);?>" onkeypress="return keyRestrict(event,'1234567890');"  type="text" id="txtNumberOfStudents" name="txtNumberOfStudents" maxlength="5" class="form-control required">
                        <div class="error"><?php echo form_error('txtNumberOfStudents');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtAllotmentFromDate">Allotment from date</label>
                    <div class="col-sm-4">
                        <input value="<?php echo set_value('txtAllotmentFromDate',date('d/m/Y',strtotime($formData['txtAllotmentFromDate'])));?>"  onkeypress="return keyRestrict(event,'1234567890/');"  type="text" id="txtAllotmentFromDate" name="txtAllotmentFromDate" class="form-control required">
                        <div class="error"><?php echo form_error('txtAllotmentFromDate');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtAllotmentToDate">Allotment to date</label>
                    <div class="col-sm-4">
                        <input value="<?php echo set_value('txtAllotmentToDate',date('d/m/Y',strtotime($formData['txtAllotmentToDate'])));?>"  onkeypress="return keyRestrict(event,'1234567890/');"  type="text" id="txtAllotmentToDate" name="txtAllotmentToDate" class="form-control required">
                        <div class="error"><?php echo form_error('txtAllotmentToDate');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-data col-sm-10 col-md-offset-2">
                        <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id;?>" />
                        <input class="btn btn-primary" type="submit" id="btnSave" name="btnSave" value="Submit" />
                        <input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/campusrooms'" />
                    </div>
                </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            &nbsp;
        </div>
        <!-- /.box-footer-->
        </form>
      </div>
      </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script>
    var pageHighlightMenu = "campusrooms";
	$(document).ready(function() {
                $( "#txtAllotmentFromDate" ).datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,		  
                    dateFormat: "dd/mm/yy",		
                    numberOfMonths: 1,
                    onClose: function( selectedDate ) {
                        $( "#txtAllotmentToDate" ).datepicker( "option", "minDate", selectedDate );
                    }
                });

                $( "#txtAllotmentToDate" ).datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd/mm/yy",		
                        numberOfMonths: 1,
                        onClose: function( selectedDate ) {
                            $( "#txtAllotmentFromDate" ).datepicker( "option", "maxDate", selectedDate );
                        }
                });
                
                $.validator.addMethod(
                    "australianDate",
                    function(value, element) {
                        return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
                    },
                    "Please enter a date in the format dd/mm/yyyy"
                );
                $.validator.addMethod("nonzero", function(value, element) {
                    if(value > 0)
                        return true;
                    else
                        return false;
                    }, "Should not be zero(0)");
                    
                $("#frmRooms").validate({
                    errorElement:"div",
                    ignore: "",
                    rules: {
                        selCampus: "required",
                        txtNumberOfRooms: {
                            required: true,
                            nonzero: true
                        },
                        txtNumberOfStudents: {
                            required: true,
                            nonzero: true
                        },
                        txtAllotmentFromDate:{
                            australianDate: true,
                            required: true
                        },
                        txtAllotmentToDate: {
                            australianDate: true,
                            required: true
                        }
                    },
                    messages: {
                        selCampus: "Please select campus",
                        txtNumberOfRooms: "Please enter number of rooms",
                        txtNumberOfStudents: "Please enter number of students per room",
                        txtAllotmentFromDate: {
                            required: "Please select valid from date"
                        },
                        txtAllotmentToDate: {
                            required: "Please select valid to date"
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
            });
	});
        
</script>