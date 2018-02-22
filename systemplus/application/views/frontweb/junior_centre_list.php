<!--------------Datatable CSS and JS---------------->
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css">

<!---------------Sweet Alert CSS and JS----------------->
<link rel="stylesheet" href="<?php echo LTE; ?>plugins/sweetalert/sweetalert.css">
<script src="<?php echo LTE; ?>custom/custom.js"></script>
<script src="<?php echo LTE; ?>plugins/sweetalert/sweetalert.min.js"></script>

<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>

<!----------worldHigh js (to get all the country from amcharts)----------->
<script src="<?php echo LTE; ?>frontweb/worldHigh.js"></script>

<!--------------spectrum color selector CSS and JS------------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/spectrum.css">
<script src="<?php echo LTE; ?>frontweb/spectrum.js"></script>

<!-------------Bootstrap multiselect css and js---------------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/bootstrap-multiselect.css" />
<script src="<?php echo LTE; ?>frontweb/bootstrap-multiselect.js"></script>

<!------------custom javascript for Junior centre------------>
<script>
	var inactive_confirmation = "<?php echo $this->lang->line("inactive_confirmation"); ?>";
	var active_confirmation = "<?php echo $this->lang->line("active_confirmation"); ?>";
	var delete_confirmation = "<?php echo $this->lang->line("delete_confirmation"); ?>";
	var lte = "<?php echo LTE; ?>";
	var image_type_error_msg = "<?php echo $this->lang->line("image_type_error_msg"); ?>";
	var numeric_floating_number = "<?php echo $this->lang->line("numeric_floating_number"); ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var required_upload_image = "<?php echo $this->lang->line("required_upload_image"); ?>";
	var height1 = "<?php echo VIDEO_GALLERY_HEIGHT; ?>";
	var width1 = "<?php echo VIDEO_GALLERY_WIDTH; ?>";
	var minimum_image_dimension = "<?php echo $this->lang->line("minimum_image_dimension"); ?>";
	var pdf_type_error_msg = "<?php echo $this->lang->line('pdf_type_error_msg'); ?>";
	var valid_data_error_msg = "<?php echo $this->lang->line("valid_data_error_msg"); ?>";
	var duplicate_dynamic = "<?php echo $this->lang->line("duplicate_dynamic"); ?>";
	var required_upload_file = "<?php echo $this->lang->line('required_upload_file'); ?>";
	var please_select_dynamic = "<?php echo $this->lang->line('please_select_dynamic'); ?>";
	var enter_vimeo_url = "<?php echo $this->lang->line('enter_vimeo_url'); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/junior_centre_list.js?v=0.3"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<div class="col-sm-6 btn-create">
							<a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/frontweb/junior_centre/add_edit"><i class="fa fa-plus" aria-hidden="true"></i> Add junior centre</a>
						</div>
						<?php showSessionMessageIfAny($this);?>
					</div>
				</div>
				<div class="x_content box-body">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>SI no.</th>
								<th>Image</th>
								<th>Centre name</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!---------------------Upload Pdf file and description Modal Start----------------->
<div class="modal fade" id="uploadPdfModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title uploadPdfModal-title"></h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'uploadPdfModalForm',
				'method' =>'post'
			);
			echo form_open_multipart('' , $formAttribute);
?>
				<input type="hidden" name="uploadPdfModalType" id="uploadPdfModalType">
				<input type="hidden" name="juniorCentreId" id="juniorCentreId">
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">File description<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'file_description',
								'id' => 'file_description',
								'class' => 'form-control',
								'rows' => 2
							);
							echo form_textarea($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload file <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'id' => 'file_name',
								'name' => 'file_name',
								'type' => 'file'
							);
							echo form_input($inputFieldAttribute);
?>
							<span style="color: red;" id="fileUploadErrorMsg"></span>
							<small style="display:block">
								( Note : Only pdf files are allowed )
							</small>
						</div>
					</div>
					<div class="clearfix"></div><hr>
					<div id="uploadPdfModalTableWrapper"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="updateFeatureBtn" class="btn btn-info">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------Upload Pdf file and description Modal End----------------->

<!---------------------Dates Management Modal Start----------------->
<div class="modal fade" id="dateManagementModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Manage dates</h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'dateManagementModalForm',
				'method' =>'post'
			);
			echo form_open_multipart('' , $formAttribute);
?>
				<input type="hidden" name="dateJuniorCentreId" id="dateJuniorCentreId">
				<input type="hidden" name="flag" id="datesFlag" value="as" />
				<input type="hidden" name="datesId" id="datesId" />
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Arrival dates<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'date',
								'id' => 'date',
								'class' => 'form-control',
								'type' => 'date'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select weeks<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							for($i  = 1 ; $i <= 5 ; $i++)
							{
								echo $i.' <input type="checkbox" class="datesWeek" name="week[]" value="'.$i.'" />'.nbs(10);
							}
?>
							<br><span id="weekErrorMessage" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select program<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							echo form_dropdown('program_id[]' , getCourseProgramDetails() , '' , 'class="form-control" id="program_id" multiple="multiple"');
?>
							<span id="programErrorMessage" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Overnight</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'overnight',
								'id' => 'overnight',
								'class' => 'form-control'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="clearfix"></div><hr>
					<div id="dateManagementModalTableWrapper"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="updatedateBtn" class="btn btn-info">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------Dates Management Modal End----------------->

<!---------------------Video Gallery Management Modal Start----------------->
<div class="modal fade" id="videoManagementModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Video gallery management</h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'videoManagementModalForm',
				'method' =>'post'
			);
			echo form_open_multipart('frontweb/junior_centre/add_video_gallery_management' , $formAttribute);
?>
				<input type="hidden" name="videoJuniorCentreId" id="videoJuniorCentreId">
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Video url<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'video_url',
								'id' => 'video_url',
								'class' => 'form-control',
								'placeholder' => 'Url'
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
								'class' => 'form-control',
								'rows' => '2'
							);
							echo form_textarea($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Video image <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="hidden" id="imgWidthErrorFlag" value="1" />
							<label for="video_image">
								<img class="uploadImageProgramClass" width = 180 height = 50 src="<?php echo LTE.'frontweb/no_flag.jpg'; ?>"/>
							</label>
<?php
							$inputFieldAttribute = array(
								'id' => 'video_image',
								'name' => 'video_image',
								'type' => 'file',
								'style' => 'visibility: hidden;'
							);
							echo form_input($inputFieldAttribute);
?>
							<small style="display:block">
								( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo VIDEO_GALLERY_WIDTH; ?> X <?php echo VIDEO_GALLERY_HEIGHT; ?> pixel )
							</small>
							<span id="imgErrorMessage" style="color:#ff0000"></span>
						</div>
					</div>
					<div class="clearfix"></div><hr>
					<div id="videoManagementModalTableWrapper"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="updatedateBtn" class="btn btn-info">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------Video Gallery Management Modal End----------------->

<!---------------------International Mix Management Modal Start----------------->
<div class="modal fade" id="internationalMixManagementModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">International mix management</h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'internationalMixManagementModalForm',
				'method' =>'post'
			);
			echo form_open_multipart('' , $formAttribute);
?>
				<input type="hidden" name="internationalMixJuniorCentreId" id="internationalMixJuniorCentreId">
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select country<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							echo form_dropdown('country_name' , array() , '' , 'class="form-control" id="country_name"');
?>
							<span id="countryErrorMessage" style="color:#ff0000;display: inline-block;margin-top: 8px;"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Percentage<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'percentage',
								'id' => 'percentage',
								'class' => 'form-control',
								'placeholder' => 'Percentage(in %)'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select color<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'color_code',
								'id' => 'color_code',
								'class' => 'form-control'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="clearfix"></div><hr>
					<div id="internationalMixManagementModalTableWrapper"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="updatedateBtn" class="btn btn-info">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------International Mix Management Modal End----------------->

<!---------------------Add extra section's content Modal Start----------------->
<div class="modal fade" id="extraSectionContentModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Extra section content</h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'extraSectionContentForm',
				'method' =>'post'
			);
			echo form_open_multipart('' , $formAttribute);
?>
				<input type="hidden" name="juniorCentreId" id="juniorCentreId">
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Extra section<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							echo form_dropdown('extra_section_id' , getExtraSection(1) , '' , 'class="form-control" id="extra_section_id"');
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
								'class' => 'form-control',
								'rows' => 2
							);
							echo form_textarea($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload file <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'id' => 'file_name',
								'name' => 'file_name',
								'type' => 'file'
							);
							echo form_input($inputFieldAttribute);
?>
							<span style="color: red;" id="fileUploadErrorMsg"></span>
							<small style="display:block">
								( Note : Only pdf files are allowed )
							</small>
						</div>
					</div>
					<div class="clearfix"></div><hr>
					<div id="extraSectionTableWrapper"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------Add extra section's content Modal End----------------->
