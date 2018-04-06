<!--------------Datatable CSS and JS---------------->
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>

<!------------custom javascript for Junior centre------------>
<script>
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var password_validation = "<?php echo $this->lang->line("password_validation"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/manage_video.js?v=1.1"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-5 btn-create">
							<a class="btn btn-success passwordGenerator">
								<i class="fa fa-cogs" aria-hidden="true" style="margin-right: 5px;"></i>
								<?php echo (!empty($credentialDetails)) ? 'Regenerate Password' : 'Generate Password'; ?>
							</a>
						</div>
					</div>
				</div>
				<div class="x_content box-body">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Si no.</th>
								<th>Centre Name</th>
								<th>Student's Password</th>
								<th>Manager's Password</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
<?php
							if(!empty($credentialDetails))
							{
								$siNo = 1;
								foreach($credentialDetails as $value)
								{
?>
									<tr>
										<td><?php echo $siNo++; ?></td>
										<td><?php echo $value['nome_centri'] ?></td>
										<td><?php echo $value['password']; ?></td>
										<td><?php echo $value['manager_password']; ?></td>
										<td>
											<a data-toggle="tooltip" data-original-title="Change Password" class="btn btn-xs btn-primary btn-wd-24 changePasswordClass" data-id="<?php echo $value['plus_video_id']; ?>">
												<span><i class="fa fa-key" aria-hidden="true"></i></span>
											</a>
										</td>
									</tr>
<?php
								}
							}
?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!---------------------Change Password Modal Start----------------->
<div class="modal fade" id="changePasswordModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Change Password</h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'changePasswordForm',
				'method' =>'post'
			);
			echo form_open_multipart('' , $formAttribute);
?>
				<input type="hidden" name="plus_video_id" id="plus_video_id">
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Student's Password<span class="required">*</span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'password',
								'id' => 'password',
								'class' => 'form-control'
							);
							echo form_input($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Manager's Password<span class="required">*</span></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'manager_password',
								'id' => 'manager_password',
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
<!---------------------Change Password Modal End----------------->
