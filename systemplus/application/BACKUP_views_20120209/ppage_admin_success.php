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
			<div class="rounded_outline">
					<h1 class="blu"><?=$heading;?></h1>
						Dear <?=$nome;?> <?=$cognome;?>	<br>print your Contract<br/><br/>
		</div>

					<?php

						echo form_open("personalpage/contract");
						echo form_submit('submit',' Print ');
						echo form_close();
					?> 
					<br/><br/>

		</div>

		<div class="minheight">
		</div>
		
	<div id="footer_job">Cms Plus-ed</div>
</div>
</body>