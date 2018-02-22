<html>
<head>
<title><?php echo $title ?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" />

</head>
<body>
<center>
<div id="main">
<div id="container">
		<img src="<?php echo base_url(); ?>images/up_job.jpg"/>
		<div id="menu_up">
			

		</div>
	<div >
		<div class="input_find">
		<?php
			echo form_open("gestione/filter");
			?>
			</div>
			
			<div class="desc_left">Business Name</div>
			<div  class="input_find">
				<input type="text" name="businessname" value="" size="25" />
			</div>

			<?php
			echo "<br/>" . form_submit('submit','Search');
			echo form_close();
			?>
	</div>		
	</div>
	<div id="footer_job">Cms Rubrica</div>
</div>
</center>
</body>