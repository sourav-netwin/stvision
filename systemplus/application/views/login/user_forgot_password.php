<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo $title; ?></title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="<?php echo LTE; ?>bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo LTE; ?>dist/css/AdminLTE.min.css">
		<!-- iCheck -->
		<link rel="stylesheet" href="<?php echo LTE; ?>plugins/iCheck/square/blue.css">
		<link rel="stylesheet" href="<?php echo LTE; ?>custom/custom.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<!-- Your logos -->
			<!--    <a href="<?php //echo base_url();       ?>index.php/students"><img src="<?php //echo base_url();       ?>img/logo-light.png" alt="plus-ed.com"></a>-->
				<a href="<?php echo base_url(); ?>index.php/vauth/backoffice"><img style="margin-left: 68px" src="<?php echo base_url(); ?>img/logo-light.png" alt="plus-ed.com"></a>
			<!--    <a class="phone-title" href="login.html"><img src="<?php //echo base_url();       ?>img/logo-mobile.png" alt="plus-ed.com" height="22" width="70" /></a>-->
			</div>
			<!-- /.login-logo -->
			<div class="login-box-body">
				<p class="login-box-msg">Enter your email address!</p>
				<div class="row">
					<?php
					$formResult = $this -> session -> flashdata('forgot_pass_msg');
					if (isset($formResult)) {
						if($formResult=="notexist"){
							?>
							<div class="col-md-12">
								<div class="alert alert-danger alert-dismissable text-center">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									The entered email does not exist.
								</div>
							</div>
							<?php
						}
						if($formResult=="success"){
							?>
							<div class="col-md-12">
								<div class="alert alert-success alert-dismissable text-center">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									We have changed your password and sent it to your email box.
								</div>
							</div>
							<?php
						}
					}
					?>
				</div>
				<form id="frmLogin" action="<?php echo base_url(); ?>index.php/vauth/userforgotpassword" method="post" >
					<div class="form-group has-feedback">
						<input tabindex=1 type="text" class="required noerror form-control" placeholder="Email address" name="txtEmailAddress" id="txtEmailAddress" />
					</div>
					<div class="row">
						<div class="col-xs-8 mr-top-7">
							<a href="<?php echo base_url(); ?>index.php/vauth/users">Login</a><br>
						</div>
						<!-- /.col -->
						<div class="col-xs-4">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
			<!-- /.login-box-body -->
		</div>
		<!-- /.login-box -->

		<!-- jQuery 2.2.3 -->
		<script src="<?php echo LTE; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- Bootstrap 3.3.6 -->
		<script src="<?php echo LTE; ?>bootstrap/js/bootstrap.min.js"></script>
		<!-- iCheck -->
		<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
		<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
		<style>
			.login-box, .register-box {
				margin: 4% auto;
			}
		</style>
		<script>
			$(function () {
				$("#frmLogin").validate({
					//errorElement:"div",
					ignore: "",
					rules: {
						login_name: {
							required: true
						},
						login_surname: {
							required: true
						},
						selDay: {
							required: true
						},
						selMonth: {
							required: true
						},
						selYear: {
							required: true
						}
					},
					messages: {
						login_name: "Please enter your name",
						login_surname: "Please enter your surname",
						selDay: "Please select day of your date of birth",
						selMonth: "Please select month of your date of birth",
						selYear: "Please select year of your date of birth"
					},
					submitHandler: function(form) {
						form.submit();
					}
				});
      
      
				//    $('input').iCheck({
				//      checkboxClass: 'icheckbox_square-blue',
				//      radioClass: 'iradio_square-blue',
				//      increaseArea: '20%' // optional
				//    });
			});
		</script>
	</body>
</html>
