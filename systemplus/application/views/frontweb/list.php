<!--------------Datatable CSS and JS---------------->
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<!---------------Sweet Alert CSS and JS----------------->
<link rel="stylesheet" href="<?php echo LTE; ?>plugins/sweetalert/sweetalert.css">
<script src="<?php echo LTE; ?>custom/custom.js"></script>
<script src="<?php echo LTE; ?>plugins/sweetalert/sweetalert.min.js"></script>

<!------------custom javascript for for master modules------------>
<script>
	var pageType = 'list';
	var baseUrl = "<?php echo base_url(); ?>";
	var actionColumnNo = "<?php echo $moduleArr['list']['actionColumn']['columnNo']; ?>";
	var moduleName = "<?php echo $moduleName; ?>";
	var inactive_confirmation = "<?php echo $this->lang->line("inactive_confirmation"); ?>";
	var active_confirmation = "<?php echo $this->lang->line("active_confirmation"); ?>";
	var delete_confirmation = "<?php echo $this->lang->line("delete_confirmation"); ?>";
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var please_select_dynamic = "<?php echo $this->lang->line("please_select_dynamic"); ?>";
	var duplicate_dynamic = "<?php echo $this->lang->line("duplicate_dynamic"); ?>";
	var valid_data_error_msg = "<?php echo $this->lang->line("valid_data_error_msg"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/master.js?v=2.3"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<div class="col-sm-6 btn-create">
							<?php $url = ($moduleName == 'manage_fixed_activity') ? 'master_activity/add_edit' : 'master/add_edit/'.$moduleName; ?>
							<a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/frontweb/<?php echo $url; ?>">
								<i class="fa fa-plus" aria-hidden="true"></i> Add <?php echo strtolower($moduleArr['title']); ?>
							</a>
						</div>
						<?php showSessionMessageIfAny($this);?>
					</div>
				</div>
				<div class="x_content box-body">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Si no.</th>
<?php
								if(!empty($moduleArr['list']))
								{
									foreach($moduleArr['list'] as $key => $value)
									{
										if($key == 'actionColumn')
											echo '<th>Action</th>';
										else
											echo '<th>'.$value['columnTitle'].'</th>';
									}

								}
?>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	if($moduleName == 'manage_fixed_activity')
	{
?>
		<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css">
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

		<!--------------This is the copy master activity modal(Start)--------------->
		<div class="modal fade" id="copyMasterActivityModal" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title modalTitle">Copy master activity</h4>
					</div>
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'copyMasterActivityForm',
						'method' =>'post'
					);
					echo form_open_multipart('frontweb/master_activity/copy' , $formAttribute);
?>
						<input type="hidden" name="id" id="id">
						<div class="modal-body">
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">
									Select centre<span class="required">*</span>
								</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="form-control" id="centre_id"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">
									Activity name<span class="required">*</span>
								</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="form-control" id="activity_name"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">
									Arrival date<span class="required">*</span>
								</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="form-control" id="arrival_date"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">
									Departure date<span class="required">*</span>
								</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="form-control" id="departure_date"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">
									Student group<span class="required">*</span>
								</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
<?php
									echo form_dropdown('student_group' , array('' => 'Please select group') , '' , 'class="form-control" id="student_group"');
?>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-info">Save</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		<!--------------This is the copy master activity modal(End)--------------->
<?php
	}
	elseif($moduleName == 'manage_activity_photogallery')
	{
?>
		<!-------------Bootstrap multiselect css and js---------------->
		<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/bootstrap-multiselect.css" />
		<script src="<?php echo LTE; ?>frontweb/bootstrap-multiselect.js"></script>

		<!--------------This is the copy master activity modal(Start)--------------->
		<div class="modal fade" id="copyPhotoModal" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title modalTitle">Copy photo gallery</h4>
					</div>
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'copyPhotoForm',
						'method' =>'post'
					);
					echo form_open_multipart('frontweb/master/copy_photo' , $formAttribute);
?>
						<input type="hidden" name="id" id="id">
						<div class="modal-body">
							<div class="form-group">
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">
									Select centre<span class="required">*</span>
								</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
<?php
									echo form_dropdown('centre_id[]' , getCentreDetails() , '' , 'class="form-control multiSelect" multiple="multiple"');
?>
									<br><span class="error centreErrorMsg"></span>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-info">Save</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		<!--------------This is the copy master activity modal(End)--------------->
<?php
	}
?>

