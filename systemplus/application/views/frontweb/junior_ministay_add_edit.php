<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css?v=1.1">

<!-------------Bootstrap multiselect css and js---------------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/bootstrap-multiselect.css" />
<script src="<?php echo LTE; ?>frontweb/bootstrap-multiselect.js"></script>

<!-------------Bootstrap Switch css and js---------------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/bootstrap-switch.css" />
<script src="<?php echo LTE; ?>frontweb/bootstrap-switch.js"></script>

<!----------Summernote CSS and JS--------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/summernote.css">
<script src="<?php echo LTE; ?>frontweb/summernote.js"></script>

<!------------Tinymce JS------------->
<script src="<?php echo LTE; ?>frontweb/tinymce/tinymce.min.js"></script>
<script src="<?php echo LTE; ?>custom/custom.js"></script>

<!--------------Custom js for junior ministay------------->
<script>
	var pageType = 'add_edit';
	var image_type_error_msg = "<?php echo $this->lang->line("image_type_error_msg"); ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var required_upload_image = "<?php echo $this->lang->line("required_upload_image"); ?>";
	var height1 = "<?php echo MINISTAY_VIDEO_GALLERY_HEIGHT; ?>";
	var width1 = "<?php echo MINISTAY_VIDEO_GALLERY_WIDTH; ?>";
	var minimum_image_dimension = "<?php echo $this->lang->line("minimum_image_dimension"); ?>";
	var height2 = "<?php echo JUNIOR_MINISTAY_HEIGHT; ?>";
	var width2 = "<?php echo JUNIOR_MINISTAY_WIDTH; ?>";
	var flag = "<?php echo ($id != '') ? 'es' : 'as'; ?>";
	var please_select_dynamic = "<?php echo $this->lang->line("please_select_dynamic"); ?>";
	var duplicate_dynamic = "<?php echo $this->lang->line("duplicate_dynamic"); ?>";
	var required_upload_file = "<?php echo $this->lang->line("required_upload_file"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/junior_ministay.js?v=1.1"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'juniorMiniStay',
						'method' =>'post'
					);
					echo form_open_multipart($actionUrl , $formAttribute);
?>
						<input type="hidden" id="successFlag" value="1" />
						<input type="hidden" name="flag" value="<?php echo ($id != '') ? 'es' : 'as'; ?>" />
						<div class="box box-primary"><div class="box-body">
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select centre<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$disableFlag = ($id != "") ? 'disabled' : '';
								echo form_dropdown('centre_id' , getCentreDetails() , (isset($post['centre_id']) ? $post['centre_id'] : '') , 'class="form-control" id="centre_id" '.$disableFlag);
?>
								<span id="centreErrorMessage" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
							</div>
						</div>
						<div class="form-group centreProgramWrapperClass">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select program<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$post['centre_program'] = isset($post['centre_program']) ? $post['centre_program'] : array();
								echo form_dropdown('centre_program[]' , getCourseProgramDetails() , $post['centre_program'] , 'class="form-control" id="centre_program" multiple="multiple"');
?>
								<span id="programErrorMessage" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select Section<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$post['centre_section'] = isset($post['centre_section']) ? $post['centre_section'] : array();
								echo form_dropdown('centre_section[]' , getCourseSectionDetails() , $post['centre_section'] , 'class="form-control" id="centre_section" multiple="multiple"');
?>
								<span id="sectionErrorMessage" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
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
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Show accomodation<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$checkedFlag = (isset($post['accomodation_show_flag']) && ($post['accomodation_show_flag'] == 1)) ? 'checked' : '';
?>
								<input value="" type="checkbox" name="accomodation_show_flag" id="accomodation_show_flag" <?php echo $checkedFlag; ?>>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Show plus team<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$checkedFlag = (isset($post['plus_team_show_flag']) && ($post['plus_team_show_flag'] == 1)) ? 'checked' : '';
?>
								<input value="" type="checkbox" name="plus_team_show_flag" id="plus_team_show_flag" <?php echo $checkedFlag; ?>>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Show course<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$checkedFlag = (isset($post['course_show_flag']) && ($post['course_show_flag'] == 1)) ? 'checked' : '';
?>
								<input value="" type="checkbox" name="course_show_flag" id="course_show_flag" <?php echo $checkedFlag; ?>>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload banner image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="imageChangeFlag" id="imageChangeFlag" value="1" />
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<input type="hidden" name="oldImg" id="oldImg" value="<?php echo (isset($post['centre_banner'])) ? $post['centre_banner'] : ''; ?>" />
								<label for="centre_banner">
<?php
									$imgPath = (isset($post['centre_banner'])) ? base_url().JUNIOR_MINISTAY_IMAGE_PATH.getThumbnailName($post['centre_banner']) : LTE.'frontweb/no_flag.jpg';
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
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo JUNIOR_MINISTAY_WIDTH; ?> X <?php echo JUNIOR_MINISTAY_HEIGHT; ?> pixel )
								</small>
								<span id="imgErrorMessage" style="color:#ff0000"><?php echo ($imageError != '') ? $imageError : ''; ?></span>
							</div>
						</div>
						<div class="dynamicProgramDetailsClass">
<?php
							if(!empty($post['programDetails']))
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
									'class' => 'btn btn-success submitButton',
									'value' => ($id != '') ? 'Update' : 'Submit'
								);
								echo form_submit($inputFieldAttribute);

								$inputFieldAttribute = array(
									'class' => 'btn btn-primary',
									'content' => 'Cancel',
									'onclick' => "window.location = '".base_url()."index.php/frontweb/junior_ministay'",
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
