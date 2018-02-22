<html>
<head>
<title><?php echo $title; ?></title>
<style type="text/css">

.location {
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 9px;
 color: #3d7db5;
 margin:0 0 0 16px;
 list-style-type:square ;
}
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/ddlevelsfiles/ddlevelsmenu-base.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>/css/ddlevelsfiles/ddlevelsmenu.js"></script>
<script type="text/javascript">
	ddlevelsmenu.setup("ddtopmenubar", "topbar");
</script>
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
		
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><? echo anchor("job/insertinfo_one", " Click here to apply");?></div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/back.png"><? echo anchor("job/cat/3", " Back");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/back.png"><? echo anchor("job/", " Back to home");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/cube.png">&nbsp;Location:
		<? // echo  $mainf['location']; ?>
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
						<h1 class="blu">Job Description</h1>

						<? echo $mainf['jobdescription'];?>
						
						<div class="boxsilver">
						<img style="float:left; margin:8px" src="<?php echo base_url(); ?>images/folder.png">
						Application Form:<br/>
						<? echo  anchor("job/insertinfo_one", "Click here to apply");?>
						</div>						
			</div>	
		<div id="right_edit">
			<div class="column_r" style="width:243px;">
				<a href="<?php echo base_url(); ?>pdf/Holiday_Village2010.pdf" target="_blank"><img src="<?php echo base_url(); ?>images/image001_small.jpg"><br/>
				<span class="h2small blu" >Plus Holiday Resorts</span></a>
				<br clear="all"><h1 class="blu">We offer</h1>
				A stimulating work environment<br>
				<ul>
				<li>The opportunity to enhance your skills</li>
				<li>Competitive salaries</li>
				<li>a 2 WEEK HOLIDAY BONUS for 2 people in some of the most celebrated Italian summer resorts (Retail guide price € 700- 800)</li>
				</ul>
				<a href="http://www.plus-ed.com/apps/index.php/job/insertinfo_one"><center><h1>JOIN US</h1></center></a>
				For more information:<br> <ul>
				<a href="http://www.plus-ed.com/apps/index.php/job/bonus"><li>Holiday bonus regulations</li><li>Some of our centers</li></a>
				<a href="http://www.plus-ed.com/apps/index.php/job/testimonial"><li>Testimonial Letter</a></li></ul>
				<br/>
			</div>
		</div>
		
	<div id="footer">Copyright © 2010 PLUS EDUCATIONAL All rights reserved.</div>		
</div>
</center>

</body>