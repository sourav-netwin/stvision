<html>
<head>
<title><?=$title?></title>


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
			<?php	echo anchor("cms","HOME");  echo " | "  . anchor("cms/insertjob","Insert"); echo " | " . anchor("insert","Find"); echo " | " .  anchor("insert","Delete"); echo  " | " . anchor("insert","Modify"); ?>

		</div>

		
		
		<div id="left">
		<div class="boxsilver_right"><img align="middle" src="<?php echo base_url(); ?>images/cube.png">&nbsp;Location:
	            <ul class="location">
                    <li>BATH</li>
                    <li>BEDFORD</li>
                    <li>CAMBRIDGE</li>
                    <li>CANTERBURY</li>
                    <li>CHELMSFORD</li>
                    <li>CHELTENHAM</li>
                    <li>CHESTER</li>
                    <li>EDINBURGH</li>
                    <li>LEEDS</li>
                    <li>LEICESTER</li>
                    <li>LONDON DOCKLANDS</li>
                    <li>LONDON ROEHAMPTON</li>
                    <li>NORWICH</li>
                    <li>PLYMOUTH</li>
                    <li>PORTSMOUTH</li>
                    <li>SHEFFIELD</li>
                    <li>ST. ANDREWS</li>
                 </ul>
        	</div>
		
		</div>

		<div id="middle">	
			<h1 class="blu"><?=$heading;?></h1>
				<div >
				<table cellspacing="7" cellpadding="7" >
				<? 
									
							if (count($getcandidate)){
								echo "<tr bgcolor=\"#d3e0e7\"><td>Status</td><td colspan=\"2\">Person</td><td>Time Subcription</td><td colspan=\"3\">Document</td></tr>";
								foreach ($getcandidate as $nome){
								echo "<tr><td>" . $nome['status'] . "</td><td>" . $nome['sex'] .  " </td><td> " . $nome['surname'] . "</td><td>" . $nome['stamp'] . "</td><td> " . anchor_popup(base_url() . "uploads/$nome[pdf].pdf", "CV") . "</td><td>" . anchor_popup(base_url() . "uploads/$nome[certificate].pdf", "Certificate")  . "</td><td> " . anchor("cms/panel_candidate/$nome[id]", "Menu") . "</td>	</tr>";
								}
							}
							else{
									echo "No candidate for this Job";
									echo "<br/>" . anchor("cms","Back to HOME");
								}
							
				?>								
				</table>
				</div>
				
		</div>

		<div id="right">
				
		</div>
		
	</div>
	<div id="footer">init</div>		
</div>
</center>

</body>