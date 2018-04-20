<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css?v=1.1">

<?php
	$subModuleArr = array();
	if(!empty($moduleArr['field']))
	{
		foreach($moduleArr['field'] as $value)
		{
			if(isset($value['summernote']) && $value['summernote'] == 1)
			{
?>
				<!----------Summernote CSS and JS--------->
				<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/summernote.css">
				<script src="<?php echo LTE; ?>frontweb/summernote.js"></script>
				<script>
					$(document).ready(function(){
						$('.summernote').summernote({
							height: 200
						});
					});
				</script>
<?php
				break;
			}
			if($value['type'] == 'date')
			{
?>
				<!----------Datepicker CSS and JS--------->
				<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/datepicker.css">
				<script src="<?php echo LTE; ?>frontweb/bootstrap-datepicker.js"></script>
				<script>
					$(document).ready(function(){
						$('.datepicker').datepicker({
							format: "dd-mm-yyyy",
							autoclose: true
						});
					});
				</script>
<?php
			}
			if($value['type'] == 'subtable')
				$subModuleArr =  $this->mastermodel->getModule($value['module']);
		}
	}
?>

<!------------custom javascript for program course------------>
<script>
	var pageType = 'add_edit';
	var id = "<?php echo $id; ?>";
	var moduleName = "<?php echo $moduleName; ?>";
	var fieldArr = '<?php echo json_encode($moduleArr['field']); ?>';
	var subModuleArr =  '<?php echo json_encode($subModuleArr); ?>';
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var required_upload_image = "<?php echo $this->lang->line("required_upload_image"); ?>";
	var valid_data_error_msg = "<?php echo $this->lang->line("valid_data_error_msg"); ?>";
	var image_type_error_msg = "<?php echo $this->lang->line("image_type_error_msg"); ?>";
	var minimum_image_dimension = "<?php echo $this->lang->line("minimum_image_dimension"); ?>";
	var duplicate_dynamic = "<?php echo $this->lang->line("duplicate_dynamic"); ?>";
	var enter_vimeo_url = "<?php echo $this->lang->line("enter_vimeo_url"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/master.js?v=1.1"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'masterForm',
						'method' =>'post'
					);
					echo form_open_multipart($actionUrl , $formAttribute);
?>
						<input type="hidden" name="flag" id="flag" value="<?php echo $flag; ?>" />
						<div class="box box-primary">
							<div class="box-body">
<?php
								if(!empty($moduleArr['field']))
								{
									foreach($moduleArr['field'] as $fieldKey => $fieldValue)
									{
										if($fieldValue['type'] == 'subtable')
										{
											if(isset($post[$fieldKey]) && !empty($post[$fieldKey]))
											{
												echo '<input type = "hidden" id = "'.$fieldKey.'_gobalCount" value="'.count($post[$fieldKey]).'" >';
												foreach($post[$fieldKey] as $subTableValue)
													echo $this->mastermodel->createSubtable($fieldValue['module'] , $subTableValue , count($post[$fieldKey]));
											}
											else
											{
												echo '<input type = "hidden" id = "'.$fieldKey.'_gobalCount" value="1" >';
												echo $this->mastermodel->createSubtable($fieldValue['module'] , array() , 1);
											}
										}
										else
										{
?>
											<div class="form-group">
												<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">
<?php
													echo $fieldValue['fieldLabel'];
													if(strpos($fieldValue['validation'] , 'required') !== FALSE || strpos($fieldValue['validation'] , 'imageRequired') !== FALSE)
														echo '<span class="required">*</span>';
?>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<?php echo $this->mastermodel->setFormField($fieldKey , $fieldValue , $post , $fileUploadError); ?>
												</div>
											</div>
<?php
										}
									}
								}
?>
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
											'onclick' => "window.location = '".base_url()."index.php/frontweb/master/index/".$moduleName."'",
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

<?php
	if($moduleName == 'manage_fixed_activity')
	{
?>
		<!----------Timepicker CSS and JS--------->
		<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/bootstrap-combined.min.css">
		<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/bootstrap-datetimepicker.min.css">
		<script src="<?php echo LTE; ?>frontweb/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript">
			$('.timepicker').datetimepicker({
				pickDate: false
			});
		</script>
<?php
	}
?>
