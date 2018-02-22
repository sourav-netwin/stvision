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

		<div>
	<h2> Please login to Access the Dashboard </h2>
			<?php
			$login_field = array(
					"name"=>"user",
					"id"=>"user",
					"maxlength"=>"64",
					"size"=>"20"
					);

			$pwd_field = array(
					"name"=>"password",
					"id"=>"password",
					"maxlength"=>"64",
					"size"=>"20"
			);
			echo form_open("gestione");
			echo "<p><label for='u'>Username</label><br/>";
			echo form_input($login_field) . "</p>";
			echo "<p><label for='p'>Password</label><br/>";
			echo form_password($pwd_field) . "</p>";
			echo form_submit('submit','login');
			echo form_close();
		?>
		<div class="error"><?php echo $info?></div>
	</div>		
	</div>
	<div id="footer_job">Cms Plus-ed</div>
</div>
</center>

</body>