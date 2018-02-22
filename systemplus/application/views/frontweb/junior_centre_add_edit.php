<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css">

<!-------------Bootstrap multiselect css and js---------------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/bootstrap-multiselect.css" />
<script src="<?php echo LTE; ?>frontweb/bootstrap-multiselect.js"></script>

<!----------Summernote CSS and JS--------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/summernote.css">
<script src="<?php echo LTE; ?>frontweb/summernote.js"></script>

<!------------Tinymce JS------------->
<script src="<?php echo LTE; ?>frontweb/tinymce/tinymce.min.js"></script>
<script src="<?php echo LTE; ?>custom/custom.js"></script>

<script>
	var image_type_error_msg = "<?php echo $this->lang->line("image_type_error_msg"); ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var required_upload_image = "<?php echo $this->lang->line("required_upload_image"); ?>";
	var height1 = "<?php echo JUNIOR_CENTRE_HEIGHT; ?>";
	var width1 = "<?php echo JUNIOR_CENTRE_WIDTH; ?>";
	var minimum_image_dimension = "<?php echo $this->lang->line("minimum_image_dimension"); ?>";
	var flag = "<?php echo $flag; ?>";
	var please_select_dynamic = "<?php echo $this->lang->line("please_select_dynamic"); ?>";
	var duplicate_dynamic = "<?php echo $this->lang->line("duplicate_dynamic"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/junior_centre_add_edit.js?v=0.2"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'juniorCentre',
						'method' =>'post'
					);
					echo form_open_multipart('frontweb/junior_centre/add_edit/'.$id , $formAttribute);
?>
						<input type="hidden" id="successFlag" value="1" />
						<input type="hidden" name="flag" value="<?php echo $flag; ?>" />
						<div class="box box-primary"><div class="box-body">
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select centre<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$centreId = isset($post['centre_id']) ? $post['centre_id'] : '';
								$disableFlag = ($flag == 'es') ? 'disabled' : '';
								echo form_dropdown('centre_id' , getCentreDetails() , $centreId , 'class="form-control" id="centre_id" '.$disableFlag);
?>
								<span id="centreErrorMessage" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Accommodation content<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'accommodation',
									'id' => 'accommodation',
									'class' => 'form-control tinymce',
									'value' => isset($post['accommodation']) ? $post['accommodation'] : ''
								);
								echo form_textarea($inputFieldAttribute);
?>
								<span id="accommodationErrorMessage" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Course content<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'course',
									'id' => 'course',
									'class' => 'form-control tinymce',
									'value' => isset($post['course']) ? $post['course'] : ''
								);
								echo form_textarea($inputFieldAttribute);
?>
								<span id="courseErrorMessage" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select program<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$centreProgram = isset($post['centre_program']) ? $post['centre_program'] : '';
								echo form_dropdown('centre_program[]' , getCourseProgramDetails() , $centreProgram , 'class="form-control" id="centre_program" multiple="multiple"');
?>
								<span id="programErrorMessage" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload banner image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="imageChangeFlag" id="imageChangeFlag" value="1" />
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<input type="hidden" name="oldImg" id="oldImg" value="<?php echo isset($post['centre_banner']) ? $post['centre_banner'] : ''; ?>" />
								<label for="centre_banner">
<?php
									$imgPath = (isset($post['centre_banner']) && $post['centre_banner'] != '') ? base_url().JUNIOR_CENTRE_IMAGE_PATH.getThumbnailName($post['centre_banner']) : LTE.'frontweb/no_flag.jpg';
?>
									<img height="50" width="180" class="uploadImageProgramClass" src="<?php echo $imgPath; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'centre_banner',
									'name' => 'centre_banner',
									'type' => 'file',
									'style' => 'visibility: hidden;'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo JUNIOR_CENTRE_WIDTH; ?> X <?php echo JUNIOR_CENTRE_HEIGHT; ?> pixel )
								</small>
								<span id="imgErrorMessage" style="color:#ff0000"><?php echo ($imageError != '') ? $imageError : ''; ?></span>
							</div>
						</div>
						<div class="dynamicProgramDetailsClass">
<?php
							if(isset($post['programDetails']) && !empty($post['programDetails']))
							{
								foreach($post['programDetails'] as $value)
								{
?>
									<div class="programDetailsWrapper_<?php echo $value['program_id']; ?>">
										<div class="form-group">
											<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">
												Details of <?php echo strtolower($value['program_course_name']); ?><span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<textarea name="program_<?php echo $value['program_id']; ?>" id="program_<?php echo $value['program_id']; ?>" class="form-control summernote">
													<?php echo $value['program_details']; ?>
												</textarea>
												<span id="programDeatilsError_<?php echo $value['program_id']; ?>" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
											</div>
										</div>
									</div>
<?php
								}
							}
?>
						</div>
						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<?php
								$inputFieldAttribute = array(
									'class' => 'btn btn-success',
									'value' => ($flag == 'es') ? 'Update' : 'Submit'
								);
								echo form_submit($inputFieldAttribute);

								$inputFieldAttribute = array(
									'class' => 'btn btn-primary',
									'content' => 'Cancel',
									'onclick' => "window.location = '".base_url()."index.php/frontweb/junior_centre'",
									'style' => 'margin-left: 10px;'
								);
								echo form_button($inputFieldAttribute);
?>
							</div>
						</div>
						</div></div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
