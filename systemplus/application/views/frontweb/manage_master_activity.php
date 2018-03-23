<!----------Datepicker CSS and JS--------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/datepicker.css">
<script src="<?php echo LTE; ?>frontweb/bootstrap-datepicker.js"></script>

<!-----------------Jquery ui CSS and JS------------------->
<!-- <script src="<?php echo LTE; ?>frontweb/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/jquery-ui.css"> -->

<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css">

<!------------custom javascript for master activity------------>
<script>
	var id = "<?php echo $id; ?>";
	var baseUrl = "<?php echo base_url(); ?>";
	var flag = "<?php echo $flag; ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var please_select_dynamic = "<?php echo $this->lang->line("please_select_dynamic"); ?>";
	var duplicate_dynamic = "<?php echo $this->lang->line("duplicate_dynamic"); ?>";
	var start_end_date_validation = "<?php echo $this->lang->line("start_end_date_validation"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/manage_master_activity.js?v=0.3"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'masterActivityForm',
				'method' =>'post'
			);
			echo form_open_multipart('frontweb/master_activity/add_edit/'.$id , $formAttribute);
?>
				<input type="hidden" name="flag" id="flag" value="<?php echo $flag; ?>" />
				<input type="hidden" id="globalCount" value="1">
				<div class="x_panel box">
					<div class="box-header col-sm-12">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-6 form-group">
									<label class="control-label custom-control-label col-lg-4">Select centre<span class="required">*</span></label>
									<div class="col-lg-8">
<?php
										$centreId = (isset($post['centre_id'])) ? $post['centre_id'] : '';
										echo form_dropdown('centre_id' , getCentreDetails() , $centreId , 'class="form-control" id="centre_id"');
?>
										<span class="error showErrorMessage"></span>
									</div>
								</div>
								<div class="col-lg-6 form-group">
									<label class="control-label custom-control-label col-lg-4">Activity name<span class="required">*</span></label>
									<div class="col-lg-8">
<?php
										$inputAttribute = array(
											'name' => 'activity_name',
											'id' => 'activity_name',
											'class' => 'form-control',
											'value' => (isset($post['activity_name'])) ? $post['activity_name'] : '',
											'placeholder' => 'Activity Name'
										);
										echo form_input($inputAttribute);
?>
										<span class="error showErrorMessage"></span>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-lg-6 form-group">
									<label class="control-label custom-control-label col-lg-4">Arrival date<span class="required">*</span></label>
									<div class="col-lg-8">
<?php
										$inputAttribute = array(
											'name' => 'arrival_date',
											'id' => 'arrival_date',
											'class' => 'form-control datepicker',
											'value' => (isset($post['arrival_date'])) ? $post['arrival_date'] : '',
											'placeholder' => 'dd-mm-yyyy'
										);
										echo form_input($inputAttribute);
?>
										<span class="error showErrorMessage"></span>
									</div>
								</div>
								<div class="col-lg-6 form-group">
									<label class="control-label custom-control-label col-lg-4">Departure date<span class="required">*</span></label>
									<div class="col-lg-8">
<?php
										$inputAttribute = array(
											'name' => 'departure_date',
											'id' => 'departure_date',
											'class' => 'form-control datepicker',
											'value' => (isset($post['departure_date'])) ? $post['departure_date'] : '',
											'placeholder' => 'dd-mm-yyyy'
										);
										echo form_input($inputAttribute);
?>
										<span class="error showErrorMessage"></span>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-lg-8 form-group">
									<label class="control-label custom-control-label col-lg-3">Student group</label>
									<div class="col-lg-9">
<?php
										$inputAttribute = array(
											'id' => 'group_names',
											'class' => 'form-control',
											'placeholder' => 'Group names',
											'disabled' => TRUE,
											'style' => 'color : green'
										);
										echo form_input($inputAttribute);
?>
									</div>
								</div>
								<div class="col-lg-4 form-group" style="padding-left: 20px;">
									<button type="button" class="btn btn-info" id="generateTable">
										<i class="fa fa-plus"></i>&nbsp;&nbsp;Generate Table
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="x_content box-body"></div>
				</div>
				<div class="clearfix"></div>

				<div class="x_panel">
					<div class="x_content">
						<div class="box box-primary">
							<div class="box-body">
								<div class="col-lg-12">
									<div id="previewContainer"></div>
									<div id="activityDetailsContainer"></div>
								</div>
								<div class="clearfix"></div><br>

								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
<?php
										$inputFieldAttribute = array(
											'class' => 'btn btn-success',
											'value' => ($id != '') ? 'Update' : 'Submit',
											'id' => 'submitButton',
											'style' => 'display:none'
										);
										echo form_submit($inputFieldAttribute);

										$inputFieldAttribute = array(
											'class' => 'btn btn-primary',
											'content' => 'Cancel',
											'onclick' => "window.location = '".base_url()."index.php/frontweb/master/index/manage_fixed_activity'",
											'style' => 'margin-left: 10px;'
										);
										echo form_button($inputFieldAttribute);
?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<!---------------------Manage Activity details modal Start----------------->
<div class="modal fade" id="activityDetailsModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title modalTitle"></h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'activityDetailsForm',
				'method' =>'post'
			);
			echo form_open_multipart('' , $formAttribute);
?>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Type of activity<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'program_name',
								'id' => 'program_name',
								'class' => 'form-control',
								'placeholder' => 'Type of activity'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Location<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'location',
								'id' => 'location',
								'class' => 'form-control',
								'placeholder' => 'Location'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Activity<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'activity',
								'id' => 'activity',
								'class' => 'form-control',
								'placeholder' => 'Activity'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Start time<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'from_time',
								'id' => 'from_time',
								'class' => 'form-control',
								'placeholder' => 'Start time',
								'readonly' => TRUE
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Finish time<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'to_time',
								'id' => 'to_time',
								'class' => 'form-control',
								'placeholder' => 'Finish time',
								'readonly' => TRUE
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Managed by</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'managed_by',
								'id' => 'managed_by',
								'class' => 'form-control',
								'placeholder' => 'Managed by'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------Manage Activity details modal End----------------->
