<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$title?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/ddlevelsfiles/ddlevelsmenu-base.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>/css/ddlevelsfiles/ddlevelsmenu.js"></script>
<script type="text/javascript">
	ddlevelsmenu.setup("ddtopmenubar", "topbar");
</script>
<style type="text/css">

h5{
	font-family: Lucida Grande, Verdana, Sans-serif;
	margin:10px 10px 10px 0;
	font-size: 11px;
	color: #aaa57c;

}
.small{
	font-size: 9px;
	color: #999;
}
form {
	
	font-family: Lucida Grande, Verdana, Sans-serif;
	font-size: 11px;
	background:#fff; 
	color: #aaa57c;
	display: block;
	
	padding:0 0 0 0px;
}

input {
	margin:0 0 10px 0;
	border:1px solid #ccc;
	background-color:#f5f5f5;
}
.location {
 display:block;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 9px;
 color: #3d7db5;
 margin:0 0 0 16px;
 list-style-type:square ;
}
.block_brown{
	margin:10px 0 4px 0;
	padding:10px; 
	border:1px solid #ccc; 
	background:#fafafa; 
	color: #777;
}

</style>
</head>
<body>
<center>
<div id="main">
<div id="container">
		<img src="<?php echo base_url(); ?>images/up_job.jpg"/>
		<div id="menu_up">
			<?php $this->load->view('menu_up');?>
		</div>

		
		<div id="left">
			<img src="<?php echo base_url(); ?>images/image001.jpg">
			<div class="boxsilver_right">
				<img align="middle" src="<?php echo base_url(); ?>images/cube.png">&nbsp;Location:
		
				<ul class="location">
				<li>BATH</li>
				<li>BEDFORD</li>
				<li>CAMBRIDGE</li>
				<li>CANTERBURY</li>
				<li>CHELMSFORD</li>
				<li>CHELTENHAM</li>
				<li>CHESTER</li>
				<li>EDINBURGH</li>
				<li>LEEDS</li>
				<li>LEICESTER</li>
				<li>LONDON DOCKLANDS</li>
				<li>LONDON ROEHAMPTON</li>
				<li>NORWICH</li>
				<li>PLYMOUTH</li>
				<li>PORTSMOUTH</li>
				<li>SHEFFIELD</li>
				<li>ST. ANDREWS</li>
				<li>DUBLIN</li>
				<li>GALWAY</li>
				</ul>
			</div>
		</div>
		
		<div id="middle">		
		<h1 class="blu">Application Form</h1>
			<?php echo $this->validation->error_string; 
				  $idsegment="appform/" . $this->uri->segment(3);
				  
			?>
			
			

			<?php echo form_open_multipart($idsegment); ?>
			<div class="block_brown">
			Please read the job descriptions and person specifications carefully before completing this form. 
			PLUS  Summer is committed to protecting your privacy. We will not disclose or sell your name or email address to any other companies. 
			If you experience any problems using this form, please contact  recruitment@plus-ed.com
			Complete each step of the form by filling in the fields and then clicking on the 'Next section' button. It will take 10 minutes of your time. Once each step has been submitted, you will be able to review your answers on a summary page before sending your responses to us.
			</div> 
			

			<input type="hidden" name="idannuncio" value="<? echo $this->uri->segment(3) ?>" />
			<br/>
			<div class="block_brown">
			Personal information
			</div> 
			<h5>Title</h5>
			<?
				  $options = array(
                  ''=> '',
				  'prof'=> 'Prof',
                  'mr'=> 'Mr',
				  'miss'=> 'Miss',
				  'mrs'=> 'Mrs',

                );

			echo form_dropdown('title', $options);
			?>

			<h5>First Name</h5>
			<input type="text" name="nome" value="<?php echo $this->validation->nome;?>" size="50" />
			<h5>Surname</h5>
			<input type="text" name="cognome" value="<?php echo $this->validation->cognome;?>" size="50" />
			<h5>Gender</h5>
			<?
				  $options = array(
                  ''=> '',
				  'male'=> 'male',
                  'female'=> 'female'
                );

			echo form_dropdown('malefemale', $options);
			?>
			<h5>Nationality</h5>
			<input type="text" name="nationality" value="" size="50" />
			
			<h5>email</h5>
			<input type="text" name="email" value="<? echo $this->validation->email;?>" size="50" />
			
			<div style="display:block; margin:10px; padding:10px;float:right;"><input type="submit" value="Next" /></div>
			</form>
			
</div>	
	<div id="right">
		<img  src="<?php echo base_url(); ?>images/image001_small.jpg">
		
	</div>
		
	<div id="footer">Copyright © 2010 PLUS EDUCATIONAL All rights reserved.</div>		
</div>
</center>

</body>
