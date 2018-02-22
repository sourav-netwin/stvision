<html>
<head>
<title><?php echo $title; ?></title>
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
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><?php echo anchor("job/cat/1", " Teaching");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><?php echo anchor("job/cat/3", " Summer Job");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><?php echo anchor("job/cat/2", " Marketing");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><?php echo anchor("job/cat/4", " Operation");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><?php echo anchor("job/cat/5", " Finance");?> </div>
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/folder.png"><?php echo anchor("job/cat/7", " Sales");?> </div>
		</div>

		<div id="middle">	
			<h1 class="blu"><?php $heading;?></h1>
				The continuing success of PLUS Group depends upon recruiting the most talented people. Apply now if you have what it takes to succeed within a dynamic, growing company. Please view our current opportunities below.<br/>
				<div id="table">
				<h1 class="blu">List of jobs by Function</h1>
				
						<?php $this->load->view('categorie');?>
				
				</div>
				
		</div>

		<div id="right_edit">
				<img  src="<?php echo base_url(); ?>images/image001.jpg"> 
		</div>
	<div id="footer_job">Copyright &copy; 2012 PLUS EDUCATIONAL All rights reserved. </div>		
</div>
</center>
</body>