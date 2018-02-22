<link rel="stylesheet" href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css">
<div class="row">
	<!-- left column -->
	<div class="col-md-12">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-body">
				<?php
				$success_message = $this -> session -> flashdata('success_message');
				$error_message = $this -> session -> flashdata('error_message');
				if (!empty($success_message)) {
					?>
					<div class="col-md-12 col-md-offset-4">
						<div class="alert alert-success alert-dismissable col-md-4 text-center">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $success_message ?>
						</div>
					</div>
					<?php
				}
				if (!empty($error_message)) {
					?>
					<div class="col-md-12 col-md-offset-4">
						<div class="alert alert-danger alert-dismissable col-md-4 text-center">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $error_message ?>
						</div>
					</div>
					<?php
				}
				?>
				<div class="col-md-12 text-center margin-bottom-responsive"><button type="button" id="addRole" class="btn btn-primary btn-sm" ><i class="fa fa-plus"></i>&nbsp;Add new role</button></div>
				<table id="example2" class="datatable table table-bordered table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Role Name</th>
							<th class="no-sort text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($roleDetails) {
							$count = 1;
							foreach ($roleDetails as $role) {
								?>
								<tr>
									<td><?php echo $count; ?></td>
									<td><?php echo $role['role_name']; ?></td>
									<td class="text-center" style="min-width: 70px;">
										<div class="btn-group">
											<button type="button" class="btn btn-xs btn-info editRole" data-toggle="tooltip"  title="Edit" data-id="<?php echo $role['role_id']; ?>"><i class="fa fa-edit"></i></button>
											<button type="button" class="btn btn-xs btn-warning changeRoleStatus" data-toggle="tooltip" data-id="<?php echo $role['role_id']; ?>"  title="Active/Inactive"><i class="fa <?php echo $role['role_is_active'] == 1 ? 'fa-check-square-o' : 'fa-square-o'; ?>"></i></button>
											<button type="button" class="btn btn-xs btn-danger deleteRole" data-toggle="tooltip" data-id="<?php echo $role['role_id']; ?>"  title="Delete"><i class="fa fa-trash"></i></button>
										</div>
									</td>
								</tr>
								<?php
								$count++;
							}
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<th>#</th>
							<th>Role Name</th>
							<th class="no-sort text-center">Actions</th>
						</tr>
					</tfoot>

				</table>
			</div>

		</div><!-- /.box -->
	</div><!--/.col (left) -->
</div>   <!-- /.row -->
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script type="text/javascript">
	$('body').on('click', '.editRole', function(){
		var roleId = $(this).attr('data-id');
                    $.post( siteUrl+'roles/getRoleDetails',{
                        'roleId':roleId
                    }, function( data ) {
                        if(data != 0){
                                var html = '<form role="form" id="role_edit_form" method="POST" action="<?php echo site_url() ?>/roles/editRole"><div class="box-body"><div class="col-md-12"><div class="form-group " id="editMessage"><label for="roleName">Role name<span class="required-field">*</span></label><input type="text" alpha-space-numeric-only class="form-control" id="roleName" name="roleName" value="'+data+'" required maxlength="100" /><input type="hidden" name="roleId" id="roleId" value="'+roleId+'" /></div></div></div><div class="box-footer text-center"><button type="submit" class="btn btn-primary">Submit</button>&nbsp;&nbsp<button type="reset" class="btn btn-danger">Reset</button></div></form>';
                                createModal('', 'Edit role', html);
                                $("#role_edit_form").validate();
                                var html = '';
                        }
                        else{
                                swal('Error', 'No records found');
                        }
                    },'html');
	});
	$('body').on('click', '#addRole', function(){
		var html = '<form role="form" id="role_add_form" method="POST" action="<?php echo site_url() ?>/roles/submitRole"><div class="box-body"><div class="col-md-12"><div class="form-group " id="addMessage"><label for="roleName">Role name<span class="required-field">*</span></label><input type="text" alpha-space-numeric-only class="form-control" id="roleName" name="roleName" value="" required maxlength="100" /></div></div></div><div class="box-footer text-center "><button type="submit" class="btn btn-primary">Submit</button>&nbsp;&nbsp<button type="reset" class="btn btn-danger">Reset</button></div></form>';
		createModal('', 'Add role', html);
		$("#role_add_form").validate();
		var html = '';
	});
	
	$('body').on('submit','#role_add_form', function(e){
		var roleName = $('#roleName').val();
		var submit = false;
		$.ajax({
			url: siteUrl+'roles/checkRoleExists',
			type: 'POST',
			async: false,
			data:{
				roleName:roleName
			},
			success: function(data){
				if(data == 1){
					submit = true;
				}
				else{
					submit = false;
					$('#addMessage').append('<div class="alert alert-danger alert-dismissable col-md-12 top5 text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>This role already exists</div>');
				}
			},
			error: function(){
				swal('Error', 'Failed to add role');
			}
		});
		return submit;
	});
	
	$('body').on('submit','#role_edit_form', function(e){
		var roleName = $('#roleName').val();
		var roleId = $('#roleId').val();
		var submit = false;
		$.ajax({
			url: siteUrl+'roles/checkRoleExistsOther',
			type: 'POST',
			async: false,
			data:{
				roleName:roleName,
				roleId:roleId
			},
			success: function(data){
				if(data == 1){
					submit = true;
				}
				else{
					submit = false;
					$('#editMessage').append('<div class="alert alert-danger alert-dismissable col-md-12 top5 text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>This role already exists</div>');
				}
			},
			error: function(){
				swal('Error', 'Failed to edit role');
			}
		});
		return submit;
	});
	$('body').on('click','.changeRoleStatus', function(){
		var elm = $(this);
		var roleId = elm.attr('data-id');
		if(roleId != '' && typeof roleId != 'undefined'){
			confirmAction('Are you sure to change the status?', function(s){
				if(s){
					$.ajax({
						url: siteUrl+'roles/changeRoleStatus',
						type: 'POST',
						async: false,
						data:{
							roleId:roleId
						},
						success: function(data){
							if(data == 'activated' || data == 'inactivated'){
								elm.find('i').toggleClass('fa-check-square-o fa-square-o');
								swal('Success', 'The role is '+data+' successfully');
							}
							else{
								swal('Error', 'Failed to change role status');
							}
						},
						error: function(){
							swal('Error', 'Failed to change role status');
						}
					});
				}
			},false,true);
		}
				
	});
	
	$('body').on('click','.deleteRole', function(){
		var elm = $(this);
		var roleId = elm.attr('data-id');
		if(roleId != '' && typeof roleId != 'undefined'){
			confirmAction('Are you sure to delete the role?', function(s){
				if(s){
					$.ajax({
						url: siteUrl+'roles/deleteRole',
						type: 'POST',
						async: false,
						data:{
							roleId:roleId
						},
						success: function(data){
							if(data == 1){
								elm.parent().parent().parent().remove();
								location.reload(true);
							}
							else{
								swal('Error', 'Failed to delete role');
							}
						},
						error: function(){
							swal('Error', 'Failed to delete role');
						}
					});
				}
			});
		}
				
	});
</script>
