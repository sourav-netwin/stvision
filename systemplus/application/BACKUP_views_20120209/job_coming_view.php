<html>
<head>
<title><?=$title?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/ddlevelsfiles/ddlevelsmenu-base.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/ddlevelsfiles/ddlevelsmenu-topbar.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/ddlevelsfiles/ddlevelsmenu-sidebar.css" />
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
		
		<div class="boxsilver_right_blue"><img align="middle" src="<?php echo base_url(); ?>images/cube.png"> <strong>JOB OPPORTUNITY</strong></div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><? echo anchor("#", " Teaching");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><? echo anchor("job/cat/3", " Summer Job");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><? echo anchor("#", " Marketing");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><? echo anchor("#", " Operation");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><? echo anchor("#", " Finance");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><? echo anchor("#", " Sales");?> </div>
		</div>

		<div id="middle">	
			<h1 class="blu"><?=$heading;?></h1>
				
				<div id="table">
				<div style="display:block; margin:40px 4px 4px 4px; height:520px;">
				There are no current opportunity for teaching in our all year round schools , please click on our summer job section for summer teaching position.
				<br/><br/>
				<? echo anchor("job/cat/3", " Summer Job");?>
				</div>
				</div>
				
		</div>

		<div id="right_edit">
				<img  src="<?php echo base_url(); ?>images/image001.jpg"> 
		</div>
	<div id="footer_job">Copyright © 2009 PLUS EDUCATIONAL All rights reserved. </div>		
</div>
</center>

</body>