<section class="content">
	<div class="row">
        <div class="col-md-3">
			<!-- Profile Image -->
			<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle" src="<?php echo LTE; ?>dist/img/avatar5.png" alt="<?php echo $this -> session -> userdata('businessname') ?>">

					<h3 class="profile-username text-center"><?php echo $this -> session -> userdata('businessname') ?></h3>

					<p class="text-muted text-center"><?php echo $this -> session -> userdata('country') ?></p>

				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
        </div>
        <div class="col-md-9">

			<!-- About Me Box -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Personal details</h3>
					<div class="box-tools pull-right">

						<button class="btn btn-box-tool" type="button" id="changePwdBtn">
							<i class="fa fa-pencil"></i> Change password
						</button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<th>Name:</th><td><?php echo $this -> session -> userdata('mainfirstname') ?> <?php echo $this -> session -> userdata('mainfamilyname') ?></td>
							</tr>
							<tr>
								<th>Email:</th><td><?php echo $this -> session -> userdata('email') ?></td>
							</tr>
							<tr>
								<th>Telephone:</th><td><?php echo $usersData -> ta_telephone; ?></td>
							</tr>
							<tr>
								<th>Address:</th><td><?php echo $usersData -> ta_address; ?></td>
							</tr>
							<tr>
								<th>Postal Code:</th><td><?php echo $usersData -> ta_postcode; ?></td>
							</tr>
							<tr>
								<th>City:</th><td><?php echo $usersData -> ta_city; ?></td>
							</tr>
							<tr>
								<th>Country:</th><td><?php echo $this -> session -> userdata('country') ?></td>
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
		var html = '<form id="frmCPassword" action="" class="validate">\n\
						<div class="box-body">\n\
						<div class="col-md-12">\n\
						<div class="form-group">\n\
							<label for="d1_password">\n\
								<strong>Old password<span class="required-field">*</span></strong>\n\
							</label>\n\
							<div>\n\
								<input class="required form-control" type=password name=d1_password id=d1_password />\n\
							</div>\n\
						</div>\n\
						<div class="form-group">\n\
							<label for="d2_password">\n\
								<strong>New password<span class="required-field">*</span></strong>\n\
							</label>\n\
							<div>\n\
								<input class="required form-control" type=password name=d2_password id=d2_password />\n\
							</div>\n\
						</div>\n\
						<div class="form-group">\n\
							<label for="d3_password">\n\
								<strong>Confirm new password<span class="required-field">*</span></strong>\n\
							</label>\n\
							<div>\n\
								<input class="required form-control" type=password name=d3_password id=d3_password equalto="#d2_password" />\n\
							</div>\n\
						</div>\n\
						</div>\n\
						</div>\n\
						<div class="box-footer text-center "><button type="submit" class="btn btn-primary">Submit</button>&nbsp;&nbsp<button type="reset" class="btn btn-danger">Reset</button></div>\n\
					</form>';
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
			url: siteUrl+'users/changeCredentials',
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
