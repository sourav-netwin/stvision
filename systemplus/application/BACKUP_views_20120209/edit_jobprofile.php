<html>
<head>
<title><?=$title?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 

<script type="text/javascript" src="<?php echo base_url(); ?>/css/ddlevelsfiles/ddlevelsmenu.js"></script>

<style type="text/css">

h5{
	font-family: Georgia, Times New Roman, Times, serif;
	margin:9px 0 0 0;
	

}
.red{
	color:#903;
}
.small{
	font-size: 9px;
	color: #999;
}
.big{
	font-family: Georgia, Times New Roman, Times, serif;
	font-size: 12px;
	font-weight:bold;
	color: #000;
}
form {
		
	font-size: 12px;
	color: #002166;
	display: block;
	padding:0 0 0 10px;
}

input {
	margin:0 0 10px 0;
	border:1px solid #ccc;
	background-color:#f5f5f5;
}

</style>

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
		
		</div>

		<div id="middle_admin">	
			<h1 class="blu"><?=$heading;?></h1>
				<div >
				<table cellspacing="12" cellpadding="12">
				<? 
									
										$idsegment="centre_admin/update_candidate/" . $this->uri->segment(3);
										
										foreach ($getcandidate as $nome){
										echo form_open($idsegment);
										?>
										<input type="hidden" name="id" value="<? echo $nome['id'] ?>" />
										<h5><?php echo $nome['sex'] ." - ". $nome['name'] ." - ". $nome['surname']; ?>
										<h5><span class="red">Location Assigned: </span><?php  echo $nome['location']; ?></h5>
										<h5><span class="red">Session from: </span><?php  echo $nome['datefrom_a']; ?></h5>
										<h5><span class="red">Session to: </span><?php  echo $nome['dateto_a']; ?></h5>
										<h5><span class="red">Other Location Assigned: </span><?php  echo $nome['locationassigned_b']; ?></h5>
										<h5><span class="red">Session from: </span><?php  echo $nome['datefrom_b']; ?></h5>
										<h5><span class="red">Session to: </span><?php  echo $nome['dateto_a']; ?></h5>
										
                       
                                        <div style="margin:10px 0 10px 0; padding:4px; background-color:#006699; color:#ffffff; width:420px">
										Note for operator
                                        </div>

										<h4>N Insurance</h4>
										<input type="text" name="ninsurance" value="<?php echo $nome['ninsurance']; ?>" size="50" /><br/>

										<h4>Extras</h4>
										<input type="text" name="bonus" value="<?php echo $nome['bonus']; ?>" size="50" /><br/>

										
									<h4>Evaluation</h4>
										<?
										$options = array(
											  '1' => '1',
											  '2' => '2',
											  '3' => '3',
											  '4' => '4',
											  '5' => '5'
										);	
										echo form_dropdown('evaluation', $options, $nome['evaluation']);
									?>

									<h4>Works Days</h4>
									<input type="text" name="day_work" value="<?php echo $nome['day_work']; ?>" size="10" /><br/>


										<div style="margin:4px; float:right"><input type="submit" value="Submit" /></div>
										<?php echo form_close();

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