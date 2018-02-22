<link rel="stylesheet" href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css">
<div class="row">
    <?php
	showSessionMessageIfAny($this);
    ?>
</div>
<div class="row">
<form name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/backoffice/cmsInsertCoach" method="POST">
<div class="col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Add new coach company</h4>
            <div class="pull-right">
                <a data-toggle="tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsManageCoaches" title="Back to companies">
                    <small>Back to companies</small>
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="box-title mr-bot-10">
                <strong>Company details</strong>
            </div>
            <div class="row form-group">
                <div class="col-sm-3 col-md-3 col-lg-2">Company:</div>
                <div class="form-data col-sm-9 col-md-9 col-lg-4">
                    <input type="text" name="tra_cp_name" id="tra_cp_name" class="required form-control" value="">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-3 col-md-3 col-lg-2">Address:</div>
                <div class="col-sm-9 col-md-9 col-lg-4">
                    <textarea class="required form-control"  name="tra_cp_address" id="tra_cp_address" ></textarea>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-3 col-md-3 col-lg-2">Website:</div>
                <div class="col-sm-9 col-md-9 col-lg-4">
                    <input type="text" name="tra_cp_website" id="tra_cp_website" class="form-control" value="">
                    <small>(Please enter valid url with 'http://' or 'https://' as starting text.)</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-3 col-md-3 col-lg-2">Contact name:</div>
                <div class="col-sm-9 col-md-9 col-lg-4">
                    <input type="text" name="tra_cp_contact_name" id="tra_cp_contact_name" class="required form-control" value="">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-3 col-md-3 col-lg-2">Email:</div>
                <div class="col-sm-9 col-md-9 col-lg-4">
                    <input type="text" name="tra_cp_email" id="tra_cp_email" class="required form-control" value="">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-3 col-md-3 col-lg-2">Phone:</div>
                <div class="col-sm-9 col-md-9 col-lg-4">
                    <input type="text" name="tra_cp_phone" id="tra_cp_phone" class="required form-control" value="">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-3 col-md-3 col-lg-2">Emergency phone:</div>
                <div class="col-sm-9 col-md-9 col-lg-4">
                    <input type="text" name="tra_cp_emergency" id="tra_cp_emergency" class="required form-control" value="">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-3 col-md-3 col-lg-2">Fax:</div>
                <div class="col-sm-9 col-md-9 col-lg-4">
                    <input type="text" name="tra_cp_fax" id="tra_cp_fax" class="required form-control" value="">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-offset-3 col-lg-offset-2 col-sm-9 col-md-9 col-lg-4">
                    <input id="addprofile" class="btn btn-primary" type="submit" value="Insert new company" name="addprofile" />
                </div>
            </div>
        </div>
    <!-- /.box-body -->
    <div class="box-footer">
        &nbsp;
    </div>
    <!-- /.box-footer-->
    </div>
</div>
</form>
</div>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script type="text/javascript">
    pageHighlightMenu = "backoffice/cmsManageCoaches";
    $(function(){
//        $.validator.addMethod( "url2", function( value, element ) {
//            return this.optional( element ) || /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)*(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test( value );
//        }, $.validator.messages.url );

        $("#persoprofile").validate({
            errorElement:"div",
            ignore: "",
            rules: {
                tra_cp_name: "required",
                tra_cp_address: "required",
                tra_cp_contact_name: "required",
                tra_cp_website: {
                    url:true
                },
                tra_cp_email: {
                    required:true,
                    email:true
                },
                tra_cp_phone: "required",
                tra_cp_emergency: "required",
                tra_cp_fax: "required"
            },
            messages: {
                tra_cp_name: "Please enter company name",
                tra_cp_address: "Please enter address",
                tra_cp_contact_name: "Please enter contact name",
                tra_cp_email: "Please enter email",
                tra_cp_phone: "Please enter phone",
                tra_cp_emergency: "Please enter emergency phone number",
                tra_cp_fax: "Please enter fax number"
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>