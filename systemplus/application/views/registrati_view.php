<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?=$title?></title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<style type="text/css">

a{

	font-family: Monaco, Verdana, Sans-serif;
	font-size: 11px;
	color: #eee;
	text-align:center; 
 
}


</style>
</head>
<body>
<img src="<?php echo base_url(); ?>images/agenti_header.png" style="margin:10px 0 0 0">
<div id="container">
	<div id="login">
		<div style="margin:10px 0 0 52px; text-align:center;"><img src="<?php echo base_url(); ?>images/loginformup.png"></div>
		<div class="login_container">
			<h2 style="margin:10px 0 0 0;">Your Account</h2> (Step 4 - 4)
			<div class="login_container_form">
				<?php echo $this->validation->error_string; ?>
					<?php echo form_open('agenti/registrazioneEnd/' . $this->uri->segment(3)); ?>
						<div class="input_form">Username</div><div><input type="text" name="username" value="<?php echo $this->validation->username;?>" size="30" /></div>
						<div class="input_form">Password</div><div><input type="password" name="password" value="<?php echo $this->validation->password;?>" size="30" /></div>
						<div class="input_form">Password Confirm</div><div><input type="password" name="passconf" value="<?php echo $this->validation->passconf;?>" size="30" /></div>
						<div class="input_form">Email Address</div><div><input type="text" name="myemail" value="<?php echo $this->validation->myemail;?>" size="30" /></div>
						<div style="margin:0 0 0 0px"><input type="submit" value="Submit" /></div>
					</form>
			</div>		
		</div>		
		<div style="margin:10px 0 0 52px; text-align:center;"><img src="<?php echo base_url(); ?>images/loginformdown.png"></div>
	 </div>
	<?php $this->load->view('agenti_footer');?>			
</div>

</body>
</html>
