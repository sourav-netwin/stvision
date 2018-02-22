<html>
<head>
<title><?=$title?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 

<style type="text/css">

h5{
	font-family: Georgia, Times New Roman, Times, serif;
	margin:9px 0 0 0;
	

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

		<div id="middle">	
			<h1 class="blu"><?=$heading;?></h1>
				<div >
				<table cellspacing="12" cellpadding="12">
				<? 
									
										$idsegment="cms/update_candidate/" . $this->uri->segment(3);
										
										foreach ($getcandidate as $nome){
										echo form_open($idsegment);
										?>
										<input type="hidden" name="id" value="<? echo $nome['id'] ?>" />
										<h5><?php echo $nome['sex']; ?></h5>
										<input type="text" name="name" value="<?php echo $nome['name']; ?>" size="50" />
										<h5>Surname</h5>
										<input type="text" name="surname" value="<?php echo $nome['surname']; ?>" size="50" />
										<h5>email</h5>
										<input type="text" name="email" value="<?php echo $nome['email']; ?>" size="50" />
										<h5>Phone</h5>
										<input type="text" name="phone" value="<?php echo $nome['phone']; ?>" size="30" />
										<h5>HomeAddress</h5>
										<input type="text" name="homeaddress" value="<?php echo $nome['homeaddress']; ?>" size="60" />
										<h5>Campus selected</h5>
										<input type="text" name="centre" value="<?php echo $nome['centre']; ?>" size="50" />
                                        <h5>Nationality</h5>
										<input type="text" name="nationality" value="<?php echo $nome['nationality']; ?>" size="30" />
                                        <h5>Nativelanguage</h5>
										<input type="text" name="nativelanguage" value="<?php echo $nome['nativelanguage']; ?>" size="30" />
                     					<h5>Other languages spoken</h5>
										<input type="text" name="otherlanguagesspoken" value="<?php echo $nome['otherlanguagesspoken']; ?>" size="30" />
                     					<h5>Level</h5>
										<input type="text" name="levelspoken" value="<?php echo $nome['levelspoken']; ?>" size="10" />
                                        <h5>Work before for us</h5>
										<input type="text" name="workbefore" value="<?php echo $nome['workbefore']; ?>" size="30" />
                     					<h5>Available:<br/>From &nbsp; 
										<input type="text" name="available_from" value="<?php echo $nome['available_from']; ?>" size="15" />
                     					&nbsp;To&nbsp;
										<input type="text" name="available_to" value="<?php echo $nome['available_to']; ?>" size="15" />
                     					</h5>
					 					<h5>Initial Tefl</h5>
										<input type="text" name="initialtefl" value="<?php echo $nome['initialtefl']; ?>" size="30" />
                                        <h5>Higher Tefl</h5>
										<input type="text" name="highertefl" value="<?php echo $nome['highertefl']; ?>" size="30" />
										<h5>Highertefl year</h5>
										<input type="text" name="highertefl_year" value="<?php echo $nome['highertefl_year']; ?>" size="10" />
										<h5>First Aid</h5>
										<input type="text" name="first_aid" value="<?php echo $nome['first_aid']; ?>" size="10" />
										<h5>Criminal Offence...</h5>
										<input type="text" name="criminal" value="<?php echo $nome['criminal']; ?>" size="10" />
										<h5>Crb</h5>
										<input type="text" name="crb" value="<?php echo $nome['crb']; ?>" size="10" />
										<h5>Permit</h5>
										<input type="text" name="permit" value="<?php echo $nome['permit']; ?>" size="10" />
										<h5>UK Bank</h5>
										<input type="text" name="bank" value="<?php echo $nome['bank']; ?>" size="10" />
										<h5>Medical Detail</h5>
										<input type="text" name="medical" value="<?php echo $nome['medical']; ?>" size="70" />
										
										<?php 
											echo form_close();

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