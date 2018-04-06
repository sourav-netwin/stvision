<section class="">
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);?>
            </div>
        </div>
        <form method="post" class="form-horizontal" id="frmAccManager" action="">
        <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtFirstname">Name</label>
                    <div class="col-sm-4">
                        <input type="text" id="txtFirstname" name="txtFirstname" class="form-control" maxlength="255" value="<?php echo set_value('txtFirstname',  $formData['txtFirstname']);?>" >
                        <div class="error"><?php echo form_error('txtFirstname');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtLastname">Surname</label>
                    <div class="col-sm-4">
                        <input type="text" id="txtLastname" name="txtLastname" class="form-control" maxlength="255" value="<?php echo set_value('txtLastname',  $formData['txtLastname']);?>" >
                        <div class="error"><?php echo form_error('txtLastname');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtEmail">Email</label>
                    <div class="col-sm-4">
                        <input type="text" id="txtEmail" name="txtEmail" class="form-control" maxlength="255" value="<?php echo set_value('txtEmail',  $formData['txtEmail']);?>" >
                        <div class="error"><?php echo form_error('txtEmail');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtPosition">Position</label>
                    <div class="col-sm-4">
                        <input value="<?php echo set_value('txtPosition',$formData['txtPosition']);?>"  type="text" id="txtPosition" name="txtPosition" maxlength="75" class="form-control">
                        <div class="error"><?php echo form_error('txtPosition');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtPassword">Password</label>
                    <div class="col-sm-4">
                        <input value=""  maxlength="16" type="text" id="txtPassword" name="txtPassword" class="form-control">
                        <div class="error"><?php echo form_error('txtPassword');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtConfPassword">Confirm password</label>
                    <div class="col-sm-4">
                        <input value=""  maxlength="16" type="text" id="txtConfPassword" name="txtConfPassword" class="form-control">
                        <div class="error"><?php echo form_error('txtConfPassword');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-data col-sm-10 col-md-offset-2">
                        <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id;?>" />
                        <input class="btn btn-primary" type="submit" id="btnSave" name="btnSave" value="Submit" />
                        <input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/accountmanager'" />
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
    var pageHighlightMenu = "accountmanager";
	$(document).ready(function() {
                $("#frmAccManager").validate({
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
                        txtPosition: {
                            required: true
                        },
                        <?php if($edit_id){?>
                        txtPassword:{
                            required: false
                        },
                        <?php }else{?>
                        txtPassword:{
                            required: true
                        },
                        <?php }?>
                        txtConfPassword:{
                            equalTo: "#txtPassword"
                        }
                    },
                    messages: {
                        txtFirstname: "Please enter name",
                        txtLastname: "Please enter surname",
                        txtEmail: "Please enter email address",
                        txtPosition: "Please enter position",
                        txtPassword: {
                            required: "Please enter password"
                        },
                        txtConfPassword: {
                            equalTo: "Password and confirm password does not match"
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
            });
	});
        
</script>