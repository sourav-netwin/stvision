<section class="">
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <form method="post" class="form-horizontal" id="frmCourse" action="">
        <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="selCampus">Campus</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="selCampus" name="selCampus"  >
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
                    <label class="col-sm-2 control-label" for="txtCourseName">Course</label>
                    <div class="col-sm-4">
                        <input type="text" id="txtCourseName" name="txtCourseName"  class="form-control" maxlength="250" value="<?php echo set_value('txtCourseName',  $formData['txtCourseName']);?>" >
                        <div class="error"><?php echo form_error('txtCourseName');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" style="margin-top: -7px;" for="radCourseType">Type</label>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-xs-6">
                            <input <?php echo ($formData['radCourseType'] == 'Classic' ? "checked='checked'" : '');?> class="" type="radio" id="radCourseTypeClassic" value="Classic" name="radCourseType" />
                            <label for="radCourseTypeClassic" >Classic</label>
                        </div>
                        <div class="col-xs-6">
                            <input <?php echo ($formData['radCourseType'] == 'Zig-Zag' ? "checked='checked'" : '');?> class="" type="radio" id="radCourseTypeZigZag" value="Zig-Zag" name="radCourseType" />
                            <label for="radCourseTypeZigZag" >Zig-Zag</label>
                        </div>
                        </div>
                        <div style="margin-top: 0px!important;" class="error"><?php echo form_error('radCourseType');?></div>
                        <div for="radCourseType" generated="true" class="error"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtTotalHours">Total hours</label>
                    <div class="col-sm-4">
                        <input value="<?php echo (int)set_value('txtTotalHours',$formData['txtTotalHours']);?>" maxlength="5" onkeypress="return keyRestrict(event,'1234567890.');"  type="text" id="txtTotalHours" name="txtTotalHours" class="form-control">
                        <div class="error"><?php echo form_error('txtTotalHours');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-data col-sm-10 col-md-offset-2">
                        <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id;?>" />
                        <input class="btn btn-primary" type="submit" id="btnSave" name="btnSave" value="Submit" />
                        <input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/backoffice/campusCourses'" />
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
                
                $("#frmCourse").validate({
                    errorElement:"div",
                    ignore: "",
                    rules: {
                        selCampus: "required",
                        txtCourseName: "required",
                        'radCourseType': {
                            required: true
                        },
                        txtTotalHours:{
                            required: true
                        }
                    },
                    messages: {
                        selCampus: "Please select campus",
                        txtCourseName: "Please enter course name",
                        'radCourseType': "Please select at least one type",
                        txtTotalHours: {
                            required: "Please enter total hours"
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
            });
	});
        
</script>