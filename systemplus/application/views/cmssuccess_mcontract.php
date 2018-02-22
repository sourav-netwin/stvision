<html>
<head>
<title>Successfully trasmitted</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/cms.css" media="screen" /> 

</head>
<body>
<div id="maincms">
		<img src="<?php echo base_url(); ?>images/logoplus.jpg"/>
		<hr>
		<div id="middle_panelcms">	
			<div class="rounded_outline">
					<h3>Your operation is successfully trasmitted!</h3>
					<h5><?php //echo anchor('cms/contract/'.$this->uri->segment(3), 'Generate Contract for this person?'); ?></h5>
					<h5><?php echo anchor('cms/viewprofile/'.$this->uri->segment(3), 'Back to control panel'); ?></h5>
		</div>
		</div>
		<div class="minheight">
		</div>
		
	<div id="footer_job">Cms Plus-ed</div>
</div>
</body>