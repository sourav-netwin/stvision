<!----------Summernote CSS and JS--------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/summernote.css">
<script src="<?php echo LTE; ?>frontweb/summernote.js"></script>

<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css">

<!------------custom javascript for program course------------>
<script>
	var pageType = 'add_edit';
	var valid_data_error_msg = "<?php echo $this->lang->line("valid_data_error_msg"); ?>";
	var image_type_error_msg = "<?php echo $this->lang->line("image_type_error_msg"); ?>";
	var required_upload_image = "<?php echo $this->lang->line("required_upload_image"); ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var height1 = "<?php echo PROGRAM_COURSE_HEIGHT; ?>";
	var width1 = "<?php echo PROGRAM_COURSE_WIDTH; ?>";
	var height2 = "<?php echo PROGRAM_FRONT_HEIGHT; ?>";
	var width2 = "<?php echo PROGRAM_FRONT_WIDTH; ?>";
	var minimum_image_dimension = "<?php echo $this->lang->line("minimum_image_dimension"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/program_course.js?v=0.2"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'programDetails',
						'method' =>'post'
					);
					echo form_open_multipart('/frontweb/program_course/add_edit/'.$id , $formAttribute);
?>
						<input type="hidden" name="flag" value="<?php echo $flag; ?>" />
						<div class="box box-primary"><div class="box-body">
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Program name<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'program_course_name',
									'id' => 'program_course_name',
									'class' => 'form-control',
									'placeholder' => 'Program Name',
									'value' => isset($post['program_course_name']) ? $post['program_course_name'] : ''
								);
								echo form_input($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'program_course_description',
									'id' => 'program_course_description',
									'class' => 'form-control summernote',
									'value' => isset($post['program_course_description']) ? $post['program_course_description'] : ''
								);
								echo form_textarea($inputFieldAttribute);
?>
							<span id="descriptionErrorMessage" style="color:#ff0000"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload logo <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="imageChangeFlag" id="imageChangeFlag" value="1" />
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<input type="hidden" name="oldImg" id="oldImg" value="<?php echo isset($post['program_course_logo']) ? $post['program_course_logo'] : ''; ?>" />
								<label for="program_course_logo">
<?php
									$imgPath = isset($post['program_course_logo']) ? base_url().PROGRAM_COURSE_IMAGE_PATH.getThumbnailName($post['program_course_logo']) : LTE.'frontweb/no_flag.jpg';
?>
									<img height="87" width="90" class="uploadImageProgramClass" src="<?php echo $imgPath; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'program_course_logo',
									'name' => 'program_course_logo',
									'type' => 'file',
									'style' => 'visibility: hidden;'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo PROGRAM_COURSE_WIDTH; ?> X <?php echo PROGRAM_COURSE_HEIGHT; ?> pixel )
								</small>
								<span id="imgErrorMessage" style="color:#ff0000"><?php echo ($imageError != '') ? $imageError : ''; ?></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload Home Image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="imageChangeFlagFront" id="imageChangeFlagFront" value="1" />
								<input type="hidden" id="imgWidthErrorFlagFront" value="1" />
								<input type="hidden" name="oldImgFront" id="oldImgFront" value="<?php echo isset($post['program_front_image']) ? $post['program_front_image'] : ''; ?>" />
								<label for="program_front_image">
<?php
									$imgPath = isset($post['program_front_image']) ? base_url().PROGRAM_FRONT_IMAGE_PATH.getThumbnailName($post['program_front_image']) : LTE.'frontweb/no_flag.jpg';
?>
									<img height="50" width="180" class="uploadImageProgramClassHome" src="<?php echo $imgPath; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'program_front_image',
									'name' => 'program_front_image',
									'type' => 'file',
									'style' => 'visibility: hidden;'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo PROGRAM_FRONT_WIDTH; ?> X <?php echo PROGRAM_FRONT_HEIGHT; ?> pixel )
								</small>
								<span id="imgErrorMessageFront" style="color:#ff0000"><?php echo ($imageErrorFront != '') ? $imageErrorFront : ''; ?></span>
							</div>
						</div>

						<div class="ln_solid"></div>
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
									'onclick' => "window.location = '".base_url()."index.php/frontweb/program_course'",
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