<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo $title ?></title>

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
		
                        <h2 style="margin:10px 8px 0 0;">Password Recovery</h2>
			<h2 style="margin:10px 0 0 0;">Your email incorrect, please try again.</h2>
			<div class="login_container_form">

					<?php echo form_open('agenti/send_password'); ?>
						<div class="input_form">Insert your email</div>
						<div>
                                                    <input type="text" name="user" value="" size="40" />
                                                </div>
						<div style="margin:0 0 0 0px"><input type="submit" value="send" /></div>
					</form>
			</div>		
		
		</div>
		<div style="margin:10px 0 10px 52px; text-align:center;"><img src="<?php echo base_url(); ?>images/loginformdown.png"></div>
		
				<?php $this->load->view('agenti_footer');?>			
	 </div>
</div>
</body>
</html>
