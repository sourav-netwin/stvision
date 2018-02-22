<section class="">
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);
                    if(isset($formData['error_message'])){
                        showSessionMessageIfAny($this,'error_message',$formData['error_message']);
                    }
                ?>
            </div>
        </div>
          <form method="post"  enctype="multipart/form-data" class="form-horizontal" id="frmExcursion" action="">
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="selCampus">Campus</label>
                <div class="col-sm-4">
                    <select class="form-control" multiple autocomplete="off" id="selCampus" name="selCampus[]"  >
                        <option value="">Select Campus</option>
                        <?php if($campusList){
                                foreach ($campusList as $campus){
                                    ?><option <?php echo (in_array($campus['id'],$formData['selCampus']) ? "selected='selected'" : '');?> data-valuta="<?php echo $campus['valuta_fattura'];?>" value="<?php echo $campus['id'];?>"><?php echo $campus['nome_centri'];?></option><?php 
                                }
                        }
                        ?>
                    </select>
                    <div class="error"><?php echo form_error('selCampus');?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="txtExcursion"><?php echo ($exc_type == 'transfer' ? 'Transfer' : 'Excursion')?></label>
                <div class="col-sm-4">
                    <input type="text" id="txtExcursion" name="txtExcursion" class="form-control required"  maxlength="250" value="<?php echo set_value('txtExcursion',  $formData['txtExcursion']);?>" >
                    <div class="error"><?php echo form_error('txtExcursion');?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="txtDescription">Brief description</label>
                <div class="col-sm-4">
                    <textarea class="form-control required" id="txtDescription" name="txtDescription"><?php echo set_value('txtDescription',$formData['txtDescription']);?></textarea>
                    <div class="error"><?php echo form_error('txtDescription');?></div>
                </div>
            </div>
            <?php if($exc_type == "excursion"){?>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtDayType">Full Day / Half Day</label>
                    <div class="col-sm-4">
                        <select id="txtDayType" name="txtDayType" class="form-control required" autocomplete="off">
                            <option value="">Select</option>
                            <option <?php echo ($formData['txtDayType'] == "Full Day" ? "selected" : "");?> value="Full Day">Full Day</option>
                            <option <?php echo ($formData['txtDayType'] == "Half Day" ? "selected" : "");?> value="Half Day">Half Day</option>
                        </select>
                        <div class="error"><?php echo form_error('txtDayType');?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="fileImage">Images</label>
                    <div class="col-sm-4">
                        <input type="file" id="fileImage" name="fileImage" />
                        <div class="error"><?php echo form_error('fileImage');?></div>
                    </div>
                </div>
            <?php if(!empty($formData['imageFile'])){?>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <img src="<?php echo base_url().EXCURSION_IMAGE_PATH.$formData['imageFile'];?>" width="200" />
                    </div>
                </div>
            <?php }?>
            <?php }else{?>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="txtDays">Days</label>
                <div class="col-sm-4">
                    <input value="<?php echo set_value('txtDays',$formData['txtDays']);?>"  onkeypress="return keyRestrict(event,'1234567890');"  type="text" id="txtDays" maxlength="3" name="txtDays" class="form-control required">
                    <div class="error"><?php echo form_error('txtDays');?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="txtAirport">Airport</label>
                <div class="col-sm-4">
                    <input value="<?php echo set_value('txtAirport',$formData['txtAirport']);?>"  maxlength="5" type="text" id="txtAirport" name="txtAirport" class="form-control required">
                    <div class="error"><?php echo form_error('txtAirport');?></div>
                </div>
            </div>
            <?php }?>
            <div class="form-group">
                <div class="form-data col-sm-10 col-md-offset-2">
                    <input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id;?>" />
                    <input type="hidden" id="exc_type" name="exc_type" value="<?php echo $exc_type;?>" />
                    <input class="btn btn-primary" type="submit" id="btnSave" name="btnSave" value="Submit" />
                    <input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url();?>index.php/excursion<?php echo ($exc_type == 'transfer' ? '/transfer' : '');?>'" />
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
<script src="<?php echo LTE; ?>plugins/select2/select2.full.min.js"></script>
<script>
    var pageHighlightMenu = "excursion/addedit/excursion";
    
    <?php 
        if($exc_type == 'transfer')
            echo "pageHighlightMenu = 'excursion/transfer';";
        else
            echo "pageHighlightMenu = 'excursion';";
    ?>
	$(document).ready(function() {
            
                $('#selCampus').select2({
                    dropdownAutoWidth : true,
                    width: '100%'
                });
                
                $.validator.addMethod("nonzero", function(value, element) {
                    if(value > 0)
                        return true;
                    else
                        return false;
                    }, "Should not be zero(0)");
                    
                $("#frmExcursion").validate({
                    errorElement:"div",
                    ignore: "",
                    rules: {
                        selCampus: {
                            required: true
                        },
                        txtExcursion: {
                            required: true
                        },
                        txtDescription: {
                            required: true
                        },
                        txtDayType: {
                            required:true
                        },
                        txtDays:{
                            nonzero: true,
                            required: true
                        },
                        txtAirport: {
                            required: true
                        }
                    },
                    messages: {
                        selCampus: "Please select campus",
                        txtExcursion: "Please enter <?php echo ($exc_type == 'transfer' ? 'transfer' : 'excursion');?> name",
                        txtDescription: "Please enter brief description",
                        txtDayType: {
                            required: "Please select Full Day / Half Day"
                        },
                        txtDays: {
                            required: "Please enter number of days"
                        },
                        txtAirport: {
                            required: "Please enter airport"
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    },
                    errorPlacement: function(error, element) {
                            if (element.attr("name") == "selCampus[]") {
                                    error.insertAfter(".select2-container");
                            }else{
                                    error.insertAfter(element);
                            }
                    }
                    
            });
	});
        
</script>