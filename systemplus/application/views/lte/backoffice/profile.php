<section class="content">
	<div class="row">
        <div class="col-md-3">
			<!-- Profile Image -->
			<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle" src="<?php echo LTE; ?>dist/img/avatar5.png" alt="<?php echo $this -> session -> userdata('mainfirstname'); ?> <?php echo $this -> session -> userdata('mainfamilyname') ?>">

					<h3 class="profile-username text-center"><?php echo $this -> session -> userdata('businessname'); ?></h3>

					<p class="text-muted text-center"><?php echo $this -> session -> userdata('country'); ?></p>
					<p class="text-muted text-center"><?php echo ($this -> session -> userdata('ruolo') == "Students" ? "Student" : ucfirst($this -> session -> userdata('ruolo'))); ?></p>

				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
        </div>
        <div class="col-md-9">

			<!-- About Me Box -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Personal Details</h3>
					<div class="box-tools pull-right">

						<button class="btn btn-box-tool" type="button" id="changePwdBtn">
							<i class="fa fa-pencil"></i> Change password
						</button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="table-responsive">
					<table class="table">
						<tbody><tr>
								<th style="width:25%">Name:</th>
								<td><?php echo $this -> session -> userdata('mainfirstname'); ?> <?php echo $this -> session -> userdata('mainfamilyname'); ?></td>
							</tr>
							<tr>
								<th>Email:</th>
								<td><?php echo $this -> session -> userdata('email') ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
        </div>
    </div>
</section>

<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script type="text/javascript">
	$('body').on('click', '#changePwdBtn', function(){
		var html = '<form role="form" id="frmCPassword" method="POST" action=""><div class="box-body"><div class="col-md-12"><div class="form-group "><label for="roleName">Old password<span class="required-field">*</span></label><input type="password" class="form-control" id="d1_password" name="d1_password" value="" required maxlength="100" /></div><div class="form-group "><label for="roleName">New password<span class="required-field">*</span></label><input type="password" class="form-control" id="d2_password" name="d2_password" value="" required maxlength="100" /></div><div class="form-group "><label for="roleName">Confirm new password<span class="required-field">*</span></label><input type="password" class="form-control" id="d3_password" name="d3_password" equalto="#d2_password" value="" required maxlength="100" /></div></div></div><div class="box-footer text-center "><button type="submit" class="btn btn-primary">Submit</button>&nbsp;&nbsp<button type="reset" class="btn btn-danger">Reset</button></div></form>';
		createModal('changePwdModal','Change password',html,'small');
		$("#frmCPassword").validate({
			ignore: "",
			messages: {
				d1_password: "Please enter old password",
				d2_password: "Please enter new password",
				d3_password: {
					required: "Please confirm new password",
					equalTo: "Please enter the same password as above"
				}
			}
		});
	});
	$('body').on('submit','#frmCPassword', function(e){
		e.preventDefault();
		var oldPassword = $('#d1_password').val();
		var newPassword = $('#d2_password').val();
		var confPassword = $('#d3_password').val();
		
		$.ajax({
			url: siteUrl+'backoffice/changeCredentials',
			type: 'POST',
			dataType: 'json',
			data:{
				'oldPassword':oldPassword,
				'newPassword':newPassword
			},
			success: function(data){
				if(data.result == '1'){
					removeModal('changePwdModal');
					swal('Success', data.message);
				}
				else{
					swal('Error', data.message);
				}
			},
			error: function(){
				swal('Error', 'Failed to change password');
			}
		});
	});
</script>
