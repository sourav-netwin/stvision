<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css">

<?php
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
		}
	}
?>

<!------------custom javascript for program course------------>
<script>
	var pageType = 'add_edit';
	var id = "<?php echo $id; ?>";
	var moduleName = "<?php echo $moduleName; ?>";
	var fieldArr = '<?php echo json_encode($moduleArr['field']); ?>';
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var required_upload_image = "<?php echo $this->lang->line("required_upload_image"); ?>";
	var valid_data_error_msg = "<?php echo $this->lang->line("valid_data_error_msg"); ?>";
	var image_type_error_msg = "<?php echo $this->lang->line("image_type_error_msg"); ?>";
	var minimum_image_dimension = "<?php echo $this->lang->line("minimum_image_dimension"); ?>";
	var duplicate_dynamic = "<?php echo $this->lang->line("duplicate_dynamic"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/master.js?v=0.2"></script>

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
?>
										<div class="form-group">
											<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">
<?php
												echo $fieldValue['fieldLabel'];
												if(strpos($fieldValue['validation'] , 'required') !== FALSE)
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