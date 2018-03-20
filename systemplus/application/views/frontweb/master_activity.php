<!----------Datepicker CSS and JS--------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/datepicker.css">
<script src="<?php echo LTE; ?>frontweb/bootstrap-datepicker.js"></script>

<!----------Timepicker CSS and JS--------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/bootstrap-combined.min.css">
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/bootstrap-datetimepicker.min.css">
<script src="<?php echo LTE; ?>frontweb/bootstrap-datetimepicker.min.js"></script>

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
<script src="<?php echo LTE; ?>frontweb/custom/master_activity.js?v=0.1"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'masterActivityForm',
						'method' =>'post'
					);
					echo form_open_multipart('frontweb/master_activity/add_edit/'.$id , $formAttribute);
?>
						<input type="hidden" id="globalErrorFlag" value="1">
						<input type="hidden" name="flag" id="flag" value="<?php echo $flag; ?>" />
						<div class="box box-primary">
							<div class="box-body">
								<div class="col-lg-3">
									<div class="form-group">
<?php
										$centreId = (isset($post['centre_id'])) ? $post['centre_id'] : '';
										echo form_dropdown('centre_id' , getCentreDetails() , $centreId , 'class="form-control" id="centre_id"');
?>
										<span class="error showErrorMessage"></span>
									</div>
									<div class="form-group">
<?php
										$inputAttribute = array(
											'name' => 'date',
											'id' => 'date',
											'class' => 'form-control datepicker',
											'placeholder' => 'dd-mm-yyyy',
											'value' => (isset($post['date'])) ? $post['date'] : ''
										);
										echo form_input($inputAttribute);
?>
										<span class="error showDuplicateError"></span>
									</div>
<?php
										if(isset($post['details']) && !empty($post['details']))
										{
											foreach($post['details'] as $value)
												echo $this->master_activity_model->getAddMoreField($value , count($post['details']));
										}
										else
											echo $this->master_activity_model->getAddMoreField(array() , 1);
?>
								</div>
								<div class="col-lg-9">
									<div class="previewContainer">
										<div class="col-lg-5">
<?php
											$inputAttribute = array(
												'name' => 'start_date',
												'id' => 'start_date',
												'class' => 'form-control datepicker',
												'placeholder' => 'Start Date'
											);
											echo form_input($inputAttribute);
?>
											<span class="error showErrorMessage"></span>
										</div>
										<div class="col-lg-5">
<?php
											$inputAttribute = array(
												'name' => 'end_date',
												'id' => 'end_date',
												'class' => 'form-control datepicker',
												'placeholder' => 'End Date'
											);
											echo form_input($inputAttribute);
?>
											<span class="error showErrorMessage"></span>
										</div>
										<div class="col-lg-2">
											<button class="btn btn-warning searchPreview" type="button">
												<i class="fa fa-search"></i>  Search
											</button>
										</div>
										<div class="clearfix"></div><br>
										<div id="previewContainer"></div>
									</div>
								</div>
								<div class="clearfix"></div><br>

								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<?php
										$inputFieldAttribute = array(
											'class' => 'btn btn-success',
											'value' => ($id != '') ? 'Update' : 'Submit'
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
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
