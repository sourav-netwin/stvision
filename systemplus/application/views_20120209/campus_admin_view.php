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

		
		
		

		<div id="middle_cms">	
			<h1 class="blu"><?=$heading;?></h1>
				<div >
				<table cellspacing="12" cellpadding="12">
				<? 
							
							
							foreach ($getjob as $name){
									echo "<tr><td>" . anchor("cms/Deletjob/$name[id]", "[x] Delete") . "</td><td>" . $name['categories'] .  " </td><td> " . $name['typeofjob'] . "</td><td>" . $name['location'] . "</td><td>" . $name['nposti'] . " </td><td> " . $name['nation']  . "</td><td> " . anchor("cms/findcandidate/$name[id]", "VIEW Application") . "</td></tr>";	
									
									}
							
							
							
				?>								
				</table>
				</div>
				
		</div>

		
	</div>
	<div id="footer_job">Cms Plus-ed</div>
</div>
</center>

</body>