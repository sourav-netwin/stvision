<div class="row">
	<!-- left column -->
	<div class="col-md-12">
		<!-- general form elements -->
		<div class="box box-primary">
			<form role="form" id="role_form" method="POST" action="<?php echo site_url() ?>/roles/submitRole">
				<div class="col-md-12 text-right top5"><a href="<?php echo site_url() ?>/roles"><button type="button" class="btn btn-primary btn-sm" ><i class="fa fa-chevron-left"></i>&nbsp;Back</button></a></div>
				<div class="box-body">
					<div class="col-md-6">
						<div class="form-group ">
							<label for="roleName">Role name<span class="required-field">*</span></label>
							<input type="text" class="form-control" id="roleName" name="roleName" required>
						</div>
                    </div>
					<?php
					$success_message = $this -> session -> flashdata('success_message');
					$error_message = $this -> session -> flashdata('error_message');
					if (!empty($success_message)) {
						?>
						<div class="col-md-12">
							<div class="alert alert-success alert-dismissable col-md-6">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<?php echo $success_message ?>
							</div>
						</div>
						<?php
					}
					if (!empty($error_message)) {
						?>
						<div class="col-md-12">
							<div class="alert alert-danger alert-dismissable col-md-6">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<?php echo $error_message ?>
							</div>
						</div>
						<?php
					}
					?>
				</div><!-- /.box-body -->

				<div class="box-footer ">
                    <button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div><!-- /.box -->
	</div><!--/.col (left) -->
</div>   <!-- /.row -->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script type="text/javascript">
	$("#role_form").validate();
</script>
