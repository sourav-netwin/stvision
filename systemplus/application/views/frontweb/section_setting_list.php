<!--------------Datatable CSS and JS---------------->
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>

<!--------------Custom js for junior ministay------------->
<script>
	var valid_data_error_msg = "<?php echo $this->lang->line("valid_data_error_msg"); ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var duplicate_dynamic = "<?php echo $this->lang->line("duplicate_dynamic"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/section_setting.js?v=0.1"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<div class="col-sm-4 btn-create">
							<a class="btn btn-primary addExtraSection"><i class="fa fa-plus" aria-hidden="true"></i> Add extra section</a>
						</div>
						<div class="col-sm-4 btn-create">
							<?php echo form_dropdown('type' , unserialize(SECTION_SETTING_DROPDOWN) , '1' , 'class="form-control setTypeClass" id="type"'); ?>
						</div>
						<?php showSessionMessageIfAny($this);?>
					</div>
				</div>
				<div class="x_content box-body">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Si no.</th>
								<th>Section name</th>
								<th>Slug</th>
								<th>Sequence</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!---------------------Edit Name Modal Start----------------->
<div class="modal fade" id="editNameModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Section Name</h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'editNameModalForm',
				'method' =>'post'
			);
			echo form_open_multipart('' , $formAttribute);
?>
				<input type="hidden" name="section_id" id="section_id">
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Name<span class="required">*</span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'name',
								'id' => 'name',
								'class' => 'form-control'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info">Update</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------Edit Name Modal End----------------->

<!---------------------Add extra section Modal Start----------------->
<div class="modal fade" id="extraSectionModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add extra section</h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'extraSectionForm',
				'method' =>'post'
			);
			echo form_open_multipart('' , $formAttribute);
?>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Select Course<span class="required">*</span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
<?php
							echo form_dropdown('course_id' , unserialize(SECTION_SETTING_DROPDOWN) , '' , 'class="form-control" id="course_id"');
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Name<span class="required">*</span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'name',
								'id' => 'name',
								'class' => 'form-control',
								'autocomplete' => 'off'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Slug<span class="required">*</span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'slug',
								'id' => 'slug',
								'class' => 'form-control',
								'readonly' => TRUE
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info">Submit</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------Add extra section Modal End----------------->
