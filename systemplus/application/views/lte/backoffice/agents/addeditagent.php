<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div class="row mr-bot-10">
          <div class="col-sm-6">
            
          </div>
          <?php showSessionMessageIfAny($this);?>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <form action='<?php echo base_url(); ?>index.php/manageagents/addeditAgents' method='post' id='agent_detail_form' class="form-horizontal">
				<input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id; ?>"/>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" >First name</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo htmlspecialchars(trim(set_value('txt_mainfirstname', $formData['txt_mainfirstname']))); ?>" id="txt_mainfirstname" name="txt_mainfirstname" class="form-control"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" >Last Name</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo htmlspecialchars(trim(set_value('txt_mainfamilyname', $formData['txt_mainfamilyname']))); ?>" id="txt_mainfamilyname" name="txt_mainfamilyname" class="form-control"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" >Agent email</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo htmlspecialchars(trim(set_value('txt_agentemail', $formData['txt_agentemail']))); ?>" id="txt_agentemail" name="txt_agentemail" class="form-control" readonly />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" >Business Name</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo htmlspecialchars(trim(set_value('txt_businessname', $formData['txt_businessname']))); ?>" id="txt_businessname" name="txt_businessname" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" >Business address</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo htmlspecialchars(trim(set_value('txt_businessaddress', $formData['txt_businessaddress']))); ?>" id="txt_businessaddress" name="txt_businessaddress" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" >Business city</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo htmlspecialchars(trim(set_value('txt_businesscity', $formData['txt_businesscity']))); ?>" id="txt_businesscity" name="txt_businesscity" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" >Business country</label>
					<div class="col-sm-6">
						<select class="form-control" id="txt_businesscountry" name="txt_businesscountry">
                            <option value="">Select Country</option>
                            <?php if($countries){
                                    foreach ($countries as $country){
                                        ?><option <?php echo ($formData['txt_businesscountry'] == $country['country'] ? "selected='selected'" : '');?> value="<?php echo $country['country'];?>"><?php echo $country['country'];?></option><?php 
                                    }
                            }
                            ?>
                        </select>
						
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label ">Business postal code</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo htmlspecialchars(trim(set_value('txt_businesspostalcode', $formData['txt_businesspostalcode']))); ?>" id="txt_businesspostalcode" name="txt_businesspostalcode" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label ">Business telephone</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo htmlspecialchars(trim(set_value('txt_businesstelephone', $formData['txt_businesstelephone']))); ?>" id="txt_businesstelephone" onkeypress="return keyRestrict(event,'1234567890+- ');" name="txt_businesstelephone" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label ">Account manager first name</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo htmlspecialchars(trim(set_value('txt_accountmanagerfirstname', $formData['txt_accountmanagerfirstname']))); ?>" id="txt_accountmanagerfirstname" name="txt_accountmanagerfirstname" class="form-control" readonly />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label ">Account manager last name</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo htmlspecialchars(trim(set_value('txt_accountmanagerfamilyname', $formData['txt_accountmanagerfamilyname']))); ?>" id="txt_accountmanagerfamilyname" name="txt_accountmanagerfamilyname" class="form-control" readonly />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label ">Account manager position</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo htmlspecialchars(trim(set_value('txt_accountmanagerposition', $formData['txt_accountmanagerposition']))); ?>" id="txt_accountmanagerposition" name="txt_accountmanagerposition" class="form-control" readonly />
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="submit" value="<?php echo ($edit_id ? "Update" : "Save"); ?>" class="btn btn-primary custom-success-btn"/>
						<input type="button" value="Cancel" style="margin-left:10px" class="btn btn-primary" onclick="javascript:window.location.href='<?php echo base_url(); ?>index.php/manageagents'"/>
					</div>
				</div>
			</form>
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
</div>



<script src="<?php echo LTE;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#agent_detail_form").validate({
                    rules: {
                        txt_mainfirstname: "required",
                        txt_mainfamilyname: "required",
						txt_businessname: "required",
						txt_businessaddress: "required",
						txt_businesscity: "required",
						txt_businesspostalcode: "required",
						txt_businesscountry: "required",
						txt_businesstelephone: "required",
						
                    },
                    messages: {
                        txt_mainfirstname: "Please enter name",
                        txt_mainfamilyname: "Please enter last name",
						txt_businessname: "Please enter business name",
						txt_businessaddress: "Please enter business address",
						txt_businesscity: "Please enter city",
						txt_businesspostalcode: "Please enter postal code",
						txt_businesscountry: "Please select country",
						txt_businesstelephone: "Please enter telephone number",
						
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
            });
});
  
</script>