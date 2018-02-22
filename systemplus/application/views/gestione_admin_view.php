<html>
<head>
<title><?php echo $title;?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 
<style type="text/css">

h5{
	font-family: Lucida Grande, Verdana, Sans-serif;
	margin:10px 10px 10px 0;
	font-size: 11px;
	color: #aaa57c;

}
td {
	width:100px;
	background-color:#eee;
	padding:6px;
}
table{
	margin:10px;
}
.block_brown{
	margin:10px 0 4px 0;
	padding:10px; 
	border:2px solid #d5d1af; 
	background:#EBF0CC; 
	color: #aaa57c;
}
.blue{
	background-color:#9c9;
	color:#fff;
	padding:10px;
}

</style>

</head>
<body>
<center>
<div id="main">
<div id="container">
	<img src="<?php echo base_url(); ?>images/up_job.jpg"/>
	<div id="menu_up">
			<?php	anchor("gestione/panelfilter","Find"); ?>

		</div>

		
		
		

		<div id="middle_cms">	
			<h1 class="blu"><?php echo $heading;?></h1>
				<div>
				<table cellspacing="1" cellpadding="12" width="900px">
				<tr>
				<td class="blue">Business Name</td><td class="blue">Status</td><td class="blue">Address</td><td class="blue">City</td><td class="blue">Business Phone</td><td class="blue">Email</td><td class="blue">MainMobile</td></tr>
				<?php 
							
							foreach ($getagente as $list=>$name){

									
									
									echo "<td>" . $name['businessname'] . " </td><td> " . $name['status'] . "</td><td>" . $name['businessaddress'] . " </td><td> " .$name['businesscity']  . "</td><td> " .  $name['businesstelephone']  . "</td><td>";
									
									// Se è interview metto il link a send contract e alzo l'alert 
									// Se è send contract controllo la data


									echo $name['email'] . "</td><td>".$name['mainmobile']."</td></tr>";
									
									}
							
							
							
				?>					
				<tr><td style="background-color:#fff" colspan="9">&nbsp;</td></tr>
				<tr><td align="center"><a href="<?php echo base_url(); ?>index.php/gestione/panelfilter">SEARCH PANEL</a></td></tr>
				</table>
				</div>
				

		</div>

		
	</div>
	<div id="footer_job">Cms Plus-ed</div>
</div>

</center>

</body>