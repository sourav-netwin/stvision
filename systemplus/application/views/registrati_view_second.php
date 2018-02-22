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
			<h2 style="margin:10px 0 0 0;">Contact Detail</h2> (Step 2 - 4)

			<div class="login_container_form">
				<?php echo $this->validation->error_string; ?>
					<?php echo form_open('agenti/registrazioneSecond/' . $this->uri->segment(3)); ?>
						<div class="input_form">Title</div>
						<div style="display:block; float:left;">
						<select name="maintitle">
							<option value="Mr" <?php echo set_select('maintitle', 'Mr', TRUE); ?> >Mr</option>
							<option value="Miss" <?php echo set_select('maintitle', 'Miss'); ?> >Miss</option>
							<option value="Miss" <?php echo set_select('maintitle', 'Mrs'); ?> >Mrs</option>
							<option value="Miss" <?php echo set_select('maintitle', 'Dr'); ?> >Dr</option>
							<option value="Miss" <?php echo set_select('maintitle', 'Prof'); ?> >Prof</option>
						</select>
						</div>
						<div class="input_form">First Name</div><div><input type="input" name="mainfirst" value="<?php echo $this->validation->mainfirst;?>" size="30" /></div>
						<div class="input_form">Family Name</div><div><input type="input" name="mainfamilyname" value="<?php echo $this->validation->mainfamilyname;?>" size="30" /></div>
						<div class="input_form">Position / job Title</div><div><input type="text" name="mainposition" value="<?php echo $this->validation->mainposition;?>" size="30" /></div>
						<div class="input_form">Telephone</div><div><input type="text" name="maintelephone" value="<?php echo $this->validation->maintelephone;?>" size="30" /></div>
						<div style="margin:0 0 0 0px"><input type="submit" value="Next" /></div>
					</form>
			</div>		
		</div>
		<div style="margin:10px 0 0 52px; text-align:center;"><img src="<?php echo base_url(); ?>images/loginformdown.png"></div>
		
				<?php $this->load->view('agenti_footer');?>			
	 </div>
</div>
</body>
</html>