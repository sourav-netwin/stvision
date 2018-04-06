<section class="">
    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header col-sm-12">
            <div class="row">
                <?php showSessionMessageIfAny($this);
                ?>
            </div>
        </div>
        <form id="frmContent" action="<?php echo base_url(); ?>index.php/emailtemplate/addedit<?php echo (!empty($aFormData['emt_id']) ? '/'.$aFormData['emt_id'] : '');?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <div class="box-body">
                <input type="hidden" id="hidEmtID" name="hidEmtID" value="<?php echo $aFormData['emt_id'];?>" >
                <div class="form-group">
                        <label class="col-sm-2 control-label">From email<span class="error" ></span></label>
                        <div class="col-sm-6">
                            <input type="email" value="<?php echo set_value('emt_from_email',isset($aFormData['emt_from_email'])?$aFormData['emt_from_email'] : '');?>" class="form-control email required" id="emt_from_email" name="emt_from_email">
                        </div>
                </div>
                <div class="form-group">
                        <label class="col-sm-2 control-label">To type<span class="error" ></span></label>
                        <div class="col-sm-6" style="margin-top: 7px;">
                            <?php echo ($aFormData['emt_to'] == 1) ? 'Admin' : 'User'; ?> 
                        </div>
                </div>
                <?php if($aFormData['emt_to'] != 2){ ?>
                <div class="form-group">
                        <label class="col-sm-2 control-label">To email</label>
                        <div class="col-sm-6">
                            <input type="email" value="<?php echo set_value('emt_to_email',isset($aFormData['emt_to_email'])?$aFormData['emt_to_email'] : '');?>" class="form-control email" id="emt_to_email" name="emt_to_email">
                        </div>
                </div>
                <?php }else{ ?>
                    <input type="hidden" value="<?php echo set_value('emt_to_email',isset($aFormData['emt_to_email'])?$aFormData['emt_to_email'] : ''); ?>" class="form-control email" name="emt_to_email">
                <?php } ?>
                
                <div class="form-group">
                        <label class="col-sm-2 control-label">Email title<span class="error" ></span></label>
                        <div class="col-sm-6">
                            <input type="text" value="<?php echo set_value('emt_title',isset($aFormData['emt_title'])?$aFormData['emt_title'] : '');?>" class="form-control" id="emt_title" name="emt_title">
                        </div>
                </div>                                        
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email body<span class="error" ></span></label>
                    <span class="error"><?php echo form_error('emt_text');?></span>
                    <div class="col-sm-9">
                        <textarea value="" rows="3" id="emt_text" name="emt_text" class="editor form-control"><?php echo set_value('emt_text',isset($aFormData['emt_text'])?$aFormData['emt_text']:'');?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                    <input type="submit" id="en_submit" name="en_submit" value="<?php echo (empty($aFormData['emt_id'])) ? ' Add ' : 'Update' ?>" class="btn btn-primary" />
                    <input type="button" id="submit" value="Cancel" class="btn btn-primary" onclick="javascript:window.location.href='<?php echo base_url().'index.php/emailtemplate';?>'"/>
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
    var pageHighlightMenu = "emailtemplate";
    $(document).ready(function() {
        $.validator.addMethod("validEmail", function(value, element) 
        {
            if(value == '') 
                return true;
            var temp1;
            temp1 = true;
            var ind = value.indexOf('@');
            var str2=value.substr(ind+1);
            var str3=str2.substr(0,str2.indexOf('.'));
            if(str3.lastIndexOf('-')==(str3.length-1)||(str3.indexOf('-')!=str3.lastIndexOf('-')))
                return false;
            var str1=value.substr(0,ind);
            if((str1.lastIndexOf('_')==(str1.length-1))||(str1.lastIndexOf('.')==(str1.length-1))||(str1.lastIndexOf('-')==(str1.length-1)))
                return false;
            str = /(^[a-zA-Z0-9]+[\._-]{0,1})+([a-zA-Z0-9]+[_]{0,1})*@([a-zA-Z0-9]+[-]{0,1})+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,3})$/;
            temp1 = str.test(value);
            return temp1;
        }, "Please enter valid email.");

        $(".sidebar-nav #emailtemplate").addClass("act");

        $.validator.addMethod("alphanum", function(value, element) {
            return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
        }, "Page url must contain only letters, numbers or dashes.");
        
        $('#frmContent').validate({
            rules: {
                emt_from_email: {
                    required: true,
                    validEmail : true
                },
                emt_to_email: {
                    validEmail : true
                },
                emt_to: {
                    required: true
                },
                emt_title: {
                    required: true             
                },
                emt_text: {
                    required: true
                }
            },
            messages: {
                emt_from_email: {
                    required: "Please enter from email."
                },
                emt_to_email: {
                    required: "Please enter to email."
                },
                emt_to: {
                    required: "Please enter to."
                },
                emt_title: {
                    required: "Please enter email title."
                },
                en_txtpageurl: {
                    required: "Please enter page url.",
                    remote: "This url is already taken."
                },
                emt_text: {
                    required: "Please enter email body."
                }
            }
        });
    });
</script>