<html>
<head>
<title><?=$title;?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 

</head>
<body>
<center>
<div id="main">
<div id="container">
		<img src="<?php echo base_url(); ?>images/up_job.jpg"/>
		<div id="menu_up">
			<?php	echo anchor("cms/insertjob","Find Session"); echo " | " . anchor("insert","Find Name"); echo " | "  . anchor("insert","Free Search"); ?>

		</div>

		
		
		

		<div id="middle_admin">	
			<h1 class="blu"><?=$heading;?></h1>
				<div >
				<table cellspacing="8" cellpadding="22">
				<? 
							
							echo "<tr style=\"background-color:#cce\"><td width=\"50\"></td><td>Sex</td><td>Name - Surname</td><td>Address</td><td> Nationality</td><td>Location</td><td>Nationality</td><td>Session</td><td>Days</td><td>Evaluation</td><td>N Insurance</td></tr>";
							
							foreach ($getjob as $name){
									
									echo "<tr style=\"background-color:#eee\"><td width=\"50\">" . anchor("centre_admin/edit_jobprofile/$name[id]", "[Edit]") . "</td><td>" . $name['sex'] .  " </td><td> " . $name['name'] . " - " . $name['surname'] . "</td><td>" . $name['homeaddress'] . " </td><td> " . $name['nationality']  . "</td><td> " . $name['location']  . "</td><td> " . $name['nationality']  . "</td><td> a" .  "</td><td>" . $name['day_work']  ."</td><td> " . $name['evaluation'].  "</td><td>" . $name['ninsurance'].  "</td></tr>";
									
									
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