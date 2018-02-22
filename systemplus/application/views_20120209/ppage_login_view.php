<html>
<head>
<title><?=$title;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/cms.css" media="screen" /> 

</head>
<body>
<div id="maincms">
		<img src="<?php echo base_url(); ?>images/logoplus.jpg"/>
		<hr>
		<div id="middle_panelcms">	
			<div class="rounded">
				<h1 class="blu"><?=$heading;?></h1>
					<h4>Insert your email address</h4>
					<?php
						echo form_open("personalpage/admin");
						
						echo form_input('email') . "<br/>";
						echo form_submit('submit',' Send ');
						echo form_close();
					?>
			</div>
		</div>
		<div class="minheight">
		</div>
		
	<div id="footer_job">Cms Plus-ed</div>
</div>
</body>