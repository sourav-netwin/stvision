<section class="">
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this,"",$errorMessage);?>
            </div>
        </div>
        <form method="post" enctype="multipart/form-data" class="form-horizontal" id="frmCategoryProgram" action="">
        <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtName">Name</label>
                    <div class="col-sm-4">
                        <input type="text" id="txtName" name="txtName" class="form-control required" maxlength="255" value="<?php echo set_value('txtName',  $formData['txtName']);?>" >
                        <div class="error"><?php echo form_error('txtName');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="imageFile">Images</label>
                    <div class="col-sm-4">
                        <input type="file" id="imageFile" name="imageFile" />
                        <input type="hidden" name="oldImage" value="<?php echo $formData['imageFile'];?>" />
                        <div class="error"><?php echo form_error('imageFile');?></div>
                    </div>
                </div>
                <?php if(!empty($formData['imageFile'])){
                    $thumbnailImage = getThumbnailName($formData['imageFile']);
                    ?>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <img src="<?php echo base_url().CATEGORY_PROGRAM_IMAGE_PATH.$thumbnailImage;?>" width="<?php echo CATEGORY_PROGRAM_THUMB_WIDTH;?>"  />
                        </div>
                    </div>
                <?php }?>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtBriefDescription">Brief description</label>
                    <div class="col-sm-4">
                        <textarea id="txtBriefDescription" name="txtBriefDescription" class="form-control required"><?php echo set_value('txtBriefDescription',$formData['txtBriefDescription']);?></textarea>
                        <div class="error"><?php echo form_error('txtBriefDescription');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtExtDescription">Extended description</label>
                    <div class="col-sm-8">
                        <textarea id="txtExtDescription" name="txtExtDescription" class="editor form-control required"><?php echo set_value('txtExtDescription',$formData['txtExtDescription']);?></textarea>
                        <div class="error"><?php echo form_error('txtExtDescription');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-data col-sm-10 col-md-offset-2">
                        <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id;?>" />
                        <input class="btn btn-primary" type="submit" id="btnSave" name="btnSave" value="Submit" />
                        <input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/categoryprogram'" />
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
    var pageHighlightMenu = "categoryprogram";
	$(document).ready(function() {
                $("#frmCategoryProgram").validate({
                    errorElement:"div",
                    ignore: "",
                    rules: {
                        txtName: "required",
                        txtBriefDescription: {
                            required: true
                        },
                        txtExtDescription: {
                            required: true
                        }
                    },
                    messages: {
                        txtName: "Please enter category program name",
                        txtBriefDescription: "Please enter brief description",
                        txtExtDescription: "Please enter extended description"
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
            });
	});
</script>