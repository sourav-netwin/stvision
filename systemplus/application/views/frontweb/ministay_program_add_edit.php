<!----------Summernote CSS and JS--------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/summernote.css">
<script src="<?php echo LTE; ?>frontweb/summernote.js"></script>

<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css?v=1.1">

<!-------------Bootstrap multiselect css and js---------------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/bootstrap-multiselect.css" />
<script src="<?php echo LTE; ?>frontweb/bootstrap-multiselect.js"></script>

<!------------custom javascript for program course------------>
<script>
	var pageType = 'add_edit';
	var valid_data_error_msg = "<?php echo $this->lang->line("valid_data_error_msg"); ?>";
	var image_type_error_msg = "<?php echo $this->lang->line("image_type_error_msg"); ?>";
	var required_upload_image = "<?php echo $this->lang->line("required_upload_image"); ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var height1 = "<?php echo MINISTAY_PROGRAM_HEIGHT; ?>";
	var width1 = "<?php echo MINISTAY_PROGRAM_THUMB_WIDTH; ?>";
	var minimum_image_dimension = "<?php echo $this->lang->line("minimum_image_dimension"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/ministay_program.js?v=1.3"></script>

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
					echo form_open_multipart('/frontweb/ministay_program/add_edit/'.$id , $formAttribute);
?>
						<input type="hidden" name="flag" value="<?php echo $flag; ?>" />
						<div class="box box-primary"><div class="box-body">
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Program name<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'program_name',
									'id' => 'program_name',
									'class' => 'form-control',
									'placeholder' => 'Program Name',
									'value' => isset($post['program_name']) ? $post['program_name'] : ''
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
									'name' => 'description',
									'id' => 'description',
									'class' => 'form-control summernote',
									'value' => isset($post['description']) ? $post['description'] : ''
								);
								echo form_textarea($inputFieldAttribute);
?>
							<span id="descriptionErrorMessage" style="color:#ff0000"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select program</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$courseProgram = isset($post['course_program']) ? $post['course_program'] : '';
								echo form_dropdown('course_program[]' , getCourseProgramDetails() , $courseProgram , 'class="form-control" id="course_program" multiple="multiple"');
?>
								<small style="display:block">
									( Note: Already Add on program is added )
								</small>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload logo <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="imageChangeFlag" id="imageChangeFlag" value="1" />
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<input type="hidden" name="oldImg" id="oldImg" value="<?php echo isset($post['logo']) ? $post['logo'] : ''; ?>" />
								<label for="logo">
<?php
									$imgPath = isset($post['logo']) ? base_url().MINISTAY_PROGRAM_IMAGE_PATH.getThumbnailName($post['logo']) : LTE.'frontweb/no_flag.jpg';
?>
									<img height="87" width="90" class="uploadImageProgramClass" src="<?php echo $imgPath; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'logo',
									'name' => 'logo',
									'type' => 'file',
									'style' => 'visibility: hidden;'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo MINISTAY_PROGRAM_WIDTH; ?> X <?php echo MINISTAY_PROGRAM_HEIGHT; ?> pixel )
								</small>
								<span id="imgErrorMessage" style="color:#ff0000"><?php echo ($imageError != '') ? $imageError : ''; ?></span>
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
									'onclick' => "window.location = '".base_url()."index.php/frontweb/ministay_program'",
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