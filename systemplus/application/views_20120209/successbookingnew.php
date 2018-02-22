<html>
<head>
<title>REGISTRATIONS</title>


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
	border:2px solid #d5d1af; 
	background:#EBF0CC; 
	color: #898670;
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
		
		<div id="middle" style="height:500px">		
			<div class="block_brown">
		<?php 	
				echo ("<br/>Thank you for your application and interest in PLUS<br/>");
				echo ("We have now commenced our recruitment campaign. <br/>If your application has been successful, you will be contacted to arrange a mutually convenient date and time to have a telephone interview. <br/>Successful applicants will be contacted within a month of receipt of application. <br/>Should you wish to discuss your application further, please contact the recruitment department on +44 207 2294435. We will happy  to be of assistance. We look forward to speaking to you in the very near future.:<br/> <br><br/>Welcome to Plus<br/>");
	?>
			</div>
</div>	
	<div id="right">
		<img  src="<?php echo base_url(); ?>images/image001_small.jpg">
		
	</div>
	<div id="footer">Copyright © 2010 PLUS EDUCATIONAL All rights reserved.</div>
</div>
</center>

</body>
</html>