<html>
<head>
<title><?=$title;?></title>


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
	<div id="menu_up">
			<?php	echo anchor("cms/updatepdf","Insert Job"); echo " | " . anchor("cms/panelfilter","Find"); echo " | "  . anchor("#","Modify"); ?>

		</div>

		
		
		

		<div id="middle_cms">	
			<h1 class="blu"><?=$heading;?></h1>
				<div>
				<table cellspacing="1" cellpadding="12" width="900px">
				<tr>
				<td class="blue">Insert pdf</td><td class="blue">Edit</td><td class="blue">NAME SURNAME</td><td class="blue">SEX</td><td class="blue">DATE</td><td class="blue">CENTRE</td><td class="blue">STATUS</td><td class="blue">Ref Email</td><td class="blue">Alert</td></tr>
				<? 
							
							foreach ($getcv as $list=>$name){

									//Data
									$mydate = substr($name['stamp'], -19, 10);
									
									
									echo "<tr><td>" . anchor("cms/updatepdf/$name[id]", "[>] PDF") . "</td><td>" . anchor("cms/ViewProfile/$name[id]", "[+] Edit") .  " </td><td> " . $name['nome'] . " - " . $name['cognome'] . "</td><td>" . $name['malefemale'] . " </td><td> " . $mydate  . "</td><td> " .  $name['preferredcentre']  . "</td><td>";
									
									// Se è interview metto il link a send contract e alzo l'alert 
									// Se è send contract controllo la data
									if ($name['status'] == "interview"){
										echo "<a href='contract/$name[id]'>" . $name['status'] . "</a></td><td>";
										$alert = "Contract?";
									}
									elseif ($name['status'] == "sentcontract"){
										$prima_data=$mydate;
										$seconda_data="now";
										$differenza_in_giorni=(int)(abs(strtotime ("$prima_data") - strtotime ("$seconda_data"))/86400);
										
										echo  $name['status'] . "</td><td>";
										$alert = $differenza_in_giorni . " ago";
									}
									else{
										$alert = "";
										echo $name['status'] . "</td><td>";
									}
									


									echo $name['refemail'] . "</td><td>".$alert."</td></tr>";
									
									
									}
							
							
							
				?>					
				<tr><td style="background-color:#fff" colspan="9">&nbsp;</td></tr>
				<tr><td align="center"><a href="<?php echo base_url(); ?>index.php/cms/panelfilter">SEARCH PANEL</a></td></tr>
				</table>
				</div>
				

		</div>

		
	</div>
	<div id="footer_job">Cms Plus-ed</div>
</div>

</center>

</body>