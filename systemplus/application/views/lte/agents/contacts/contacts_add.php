<section class="">
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <form method="post" class="form-horizontal" id="frmContacts" action="">
        <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtFirstname">Name</label>
                    <div class="col-sm-4">
                        <input type="text" id="txtFirstname" name="txtFirstname" class="form-control required" maxlength="255" value="<?php echo set_value('txtFirstname',  $formData['txtFirstname']);?>" >
                        <div class="error"><?php echo form_error('txtFirstname');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtLastname">Surname</label>
                    <div class="col-sm-4">
                        <input type="text" id="txtLastname" name="txtLastname" class="form-control required" maxlength="255" value="<?php echo set_value('txtLastname',  $formData['txtLastname']);?>" >
                        <div class="error"><?php echo form_error('txtLastname');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtEmail">Email</label>
                    <div class="col-sm-4">
                        <input type="text" id="txtEmail" name="txtEmail" class="form-control required" maxlength="255" value="<?php echo set_value('txtEmail',  $formData['txtEmail']);?>" >
                        <div class="error"><?php echo form_error('txtEmail');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtPhoneNumber">Phone number</label>
                    <div class="col-sm-4">
                        <input value="<?php echo set_value('txtPhoneNumber',$formData['txtPhoneNumber']);?>" onkeypress="return keyRestrict(event,'+1234567890');"  type="text" id="txtPhoneNumber" name="txtPhoneNumber" maxlength="14" class="form-control required">
                        <div class="error"><?php echo form_error('txtPhoneNumber');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtRole">Role</label>
                    <div class="col-sm-4">
                        <input value="<?php echo set_value('txtRole',$formData['txtRole']);?>"  maxlength="255" type="text" id="txtRole" name="txtRole" class="form-control required">
                        <div class="error"><?php echo form_error('txtRole');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="selCategory">Category</label>
                    <div class="col-sm-4">
                        <select id="selCategory" name="selCategory" class="form-control">
                            <option value="">Select Campus</option>
                            <option <?php echo ($formData['selCategory'] == "Sales and Marketing" ? "selected" : '');?> value="Sales and Marketing">Sales and Marketing</option>
                            <option <?php echo ($formData['selCategory'] == "Operations" ? "selected" : '');?> value="Operations">Operations</option>
                            <option <?php echo ($formData['selCategory'] == "Finance" ? "selected" : '');?> value="Finance">Finance</option>
                            <option <?php echo ($formData['selCategory'] == "Sole Proprietor" ? "selected='selected'" : '');?> value="Sole Proprietor">Sole Proprietor</option>
                        </select>
                        <div class="error"><?php echo form_error('selCategory');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-data col-sm-10 col-md-offset-2">
                        <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id;?>" />
                        <input type="hidden" id="agent_id" name="agent_id" value="<?php echo $agent_id;?>" />
                        <input class="btn btn-primary" type="submit" id="btnSave" name="btnSave" value="Submit" />
                        <input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/contacts'" />
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
    var pageHighlightMenu = "contacts";
	$(document).ready(function() {
                                  
                $("#frmContacts").validate({
                    errorElement:"div",
                    ignore: "",
                    rules: {
                        txtFirstname: {
                            required: true
                        },
                        txtLastname: {
                            required: true
                        },
                        txtEmail: {
                            email:true,
                            required: true
                        },
                        txtPhoneNumber: {
                            required: true
                        },
                        txtRole:{
                            required: true
                        },
                        selCategory: {
                            required: true
                        }
                    },
                    messages: {
                        txtFirstname: "Please enter name",
                        txtLastname: "Please enter surname",
                        txtEmail: "Please enter email address",
                        txtPhoneNumber: "Please enter phone number",
                        txtRole: {
                            required: "Please enter role"
                        },
                        selCategory: {
                            required: "Please select category"
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
            });
	});
        
</script>