<html>
<head>
<title><?=$title;?></title>


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
			<?php	echo anchor("cms/insertjob","Insert Job"); echo " | " . anchor("insert","Find"); echo " | "  . anchor("insert","Modify"); ?>

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
			echo form_open("centre_admin");
			echo "<p><label for='u'>Username</label><br/>";
			echo form_input($login_field) . "</p>";
			echo "<p><label for='p'>Password</label><br/>";
			echo form_password($pwd_field) . "</p>";
			echo form_submit('submit','login');
			echo form_close();
		?>
		<div class="error"><?=$info?></div>
	</div>		
	</div>
	<div id="footer_job">Cms Plus-ed</div>
</div>
</center>

</body>