<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<!------------custom javascript for program course------------>
<script>
	var pageType = 'add_edit';
	var valid_data_error_msg = "<?php echo $this->lang->line("valid_data_error_msg"); ?>";
	var image_type_error_msg = "<?php echo $this->lang->line("image_type_error_msg"); ?>";
	var required_upload_image = "<?php echo $this->lang->line("required_upload_image"); ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var please_select_dynamic = "<?php echo $this->lang->line("please_select_dynamic"); ?>";
	var height1 = "<?php echo PROGRAM_HEIGHT; ?>";
	var width1 = "<?php echo PROGRAM_WIDTH; ?>";
	var minimum_image_dimension = "<?php echo $this->lang->line("minimum_image_dimension"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/program_banner.js?v=1.1"></script>

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
					echo form_open_multipart('/frontweb/program/add_edit/'.$id , $formAttribute);
?>
						<input type="hidden" name="flag" value="<?php echo ($id != '') ? 'es' : 'as'; ?>" />
						<div class="box box-primary"><div class="box-body">
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Language<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$languageId = isset($post['language_id']) ? $post['language_id'] : '';
								echo form_dropdown('language_id' , getLanguageDetails() , $languageId , 'class="form-control" id="language_id"');
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Program title<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'program_title',
									'id' => 'program_title',
									'class' => 'form-control',
									'placeholder' => 'Program Title',
									'value' => isset($post['program_title']) ? $post['program_title'] : ''
								);
								echo form_input($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Short description<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'program_short_description',
									'id' => 'program_short_description',
									'class' => 'form-control',
									'placeholder' => 'Short Description',
									'value' => isset($post['program_short_description']) ? $post['program_short_description'] : ''
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
									'name' => 'program_description',
									'id' => 'program_description',
									'class' => 'form-control',
									'value' => isset($post['program_description']) ? $post['program_description'] : ''
								);
								echo form_textarea($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Link<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'name' => 'more_link',
									'id' => 'more_link',
									'class' => 'form-control',
									'placeholder' => 'Link',
									'value' => isset($post['more_link']) ? $post['more_link'] : ''
								);
								echo form_input($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" name="imageChangeFlag" id="imageChangeFlag" value="1" />
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<input type="hidden" name="oldImg" id="oldImg" value="<?php echo isset($post['program_image']) ? $post['program_image'] : ''; ?>" />
								<label for="program_image">
<?php
									$imgPath = isset($post['program_image']) ? base_url().PROGRAM_IMAGE_PATH.getThumbnailName($post['program_image']) : LTE.'frontweb/no_flag.jpg';
?>
									<img style="cursor: pointer;border: 1px solid #ccc;" height="50" width="180" class="uploadImageProgramClass" src="<?php echo $imgPath; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'program_image',
									'name' => 'program_image',
									'type' => 'file',
									'style' => 'visibility: hidden;'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo PROGRAM_WIDTH; ?> X <?php echo PROGRAM_HEIGHT; ?> pixel )
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
									'value' => 'Update'
								);
								echo form_submit($inputFieldAttribute);

								$inputFieldAttribute = array(
									'class' => 'btn btn-primary',
									'content' => 'Cancel',
									'onclick' => "window.location = '".base_url()."index.php/frontweb/program'",
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
