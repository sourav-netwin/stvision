<html>
<head>
<title><?php echo $title?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.ui.theme.css" media="screen" /> 


<script src="<?php echo base_url(); ?>js/jquery-1.4.4.js"></script> 
	<script src="<?php echo base_url(); ?>js/jquery.ui.core.js"></script> 
	<script src="<?php echo base_url(); ?>js/jquery.ui.widget.js"></script> 
	<script src="<?php echo base_url(); ?>js/jquery.ui.datepicker.js"></script> 

<style type="text/css">

h4{
	color:#555;
	

}
.small{
	font-size: 9px;
	color: #999;
}
form {
		
	font-size: 12px;
	color: #002166;
	display: block;
	padding:0 0 0 10px;
}

.separa {
	margin:10px 0 10px 0;
	padding:10px;
	border:1px solid #ccc;
	background-color:#bbb;
}
hr{
	margin:10px 0 10px 0;
}
.head {
		font:bold 11px Verdana, Arial, Helvetica, sans-serif; text-transform:uppercase;
		width:50%;
		background-color:#eee;
		color:#999;
		padding:4px;
}
#all {
 
	background-color:#fafafa;
	border:1px solid #ccc;
	-moz-border-radius: 15px;
	border-radius: 15px;
	padding:20px;
	margin:0 0 6px 10px;
	}
.button{
	cursor:hand;
	background-color:#fafafa;
	border:1px solid #ccc;
	-moz-border-radius: 4px;
	border-radius: 4px;
	padding:4px;
	margin:0;
	width:77px;
}

#menu_up{
	display:block;
	float:left;
	width:100%;
	border:1px solid #ccc;
}

</style>

<script> 
	$(function() {
		$( "#datepicker_start" ).datepicker();
		$( "#datepicker_end" ).datepicker();
	});
</script> 

</head>
<body style="background-image:none;">

<script type="text/javascript"> 
//<![CDATA[
function showSlidingDiv(nomediv){
	 var elementi=document.getElementsByName("faq");
    
    for (var i=0;i<elementi.length;i++)
    {
       elementi[i].style.display="none"
    }
	$("#"+nomediv).toggle(400); 
 
}
//]]>
function hideSlidingDiv(nomediv){
	$("#"+nomediv).toggle(400);
 
}
//]]>
</script> 

<div id="main" style="margin:0px; padding:0;">
<div id="container">
		<div id="middle">	
			<h1 class="blu"><?php echo $heading;?></h1>
				<table width="100%" cellspacing="12" cellpadding="12" >
									  <tr><td>Multiple contract</td></tr>
									  
									  <?php 
										$idsegment="cms/update_mcontract/" . $this->uri->segment(3);
										echo form_open($idsegment);
												foreach($getcandidate_multiplo as $nome)
									  {
									  ?>
										 
										<tr><td><h5>Date Start</h5></td></tr><tr><td><input type="text" id="datepicker_start" name="date_start" value="<?php echo $nome['date_start']?>"></td></tr>
									 <tr><td><h5>Date End</h5></td></tr><tr><td><input type="text" id="datepicker_end" name="date_end" value="<?php echo $nome['date_end']?>"></td></tr>
									 <tr><td><h5>Weekly Salary</h5></td></tr><tr><td><input type="text" name="salary" value="<?php echo $nome['salary']?>"></td></tr>
									 <tr><td><h5>Center</h5></td></tr>
									 <tr>
										<td>
											<?php
												  $options = array(
												  $nome['center_def']=>$nome['center_def'],
												  'BATH'=>'BATH',
												  'BEDFORD'=>'BEDFORD',
												  'CAMBRIDGE'=>'CAMBRIDGE',
												  'CANTERBURY'=>'CANTERBURY',
												  'CHELMSFORD'=>'CHELMSFORD',
												  'CHELTENHAM'=>'CHELTENHAM',
												  'CHESTER'=>'CHESTER',
												  'EDINBURGH'=>'EDINBURGH',
												  'LEICESTER'=>'LEICESTER',
												  'CHATHAM'=>'LONDON CHATAM',
												  'LONDON GREENWICH'=>'LONDON GREENWICH',
												  'LONDON DOCKLANDS'=>'LONDON DOCKLANDS',
												  'LONDON ROEHAMPTON'=>'LONDON ROEHAMPTON',
												  'LOUGHBOROUGH'=>'LOUGHBOROUGH',
												  'MAYNOOTH'=>'MAYNOOTH',
												  'NORWICH'=>'NORWICH',
												  'PLYMOUTH'=>'PLYMOUTH',
												  'PORTSMOUTH'=>'PORTSMOUTH',
												  'SHEFFIELD'=>'SHEFFIELD',
												  'STANDREWS'=>'ST. ANDREWS',
												  'DUBLIN'=>'DUBLIN',
												  'GALWAY'=>'GALWAY'
												);

											echo form_dropdown('center_def', $options, 'choose');
											?>
											<?php
												echo "<input type=\"hidden\" name=\"id_agent\" value=\"".$nome['id_personal']."\">";
												//Chiude foreach
											}
											?>
										</td>
										</tr>
										 <tr><td><h5>Status</h5></td></tr>
									 <tr>
										<td>
											<?php
												 $options = array(
											  'unread'=> 'unread',
											  'interesting'=> 'interesting',
											  'interview'=> 'interview',
											  'notofinterest'=> 'not of interest',
											  'underreview'=> 'under review',
											  'sentcontract'=> 'sent contract', 
											  'employed'=> 'employed'
										);	
										echo form_dropdown('status', $options, $nome['status']);
											?>
										</td>
										</tr>
									 <tr><td><h5>Type of contract</h5></td></tr>
									 <tr>
										<td>
											<?php
												 $options = array(
											  'Activity Leader'=> 'Activity Leader',
											  'Airport Co-ordinator'=> 'Airport Co-ordinator',
											  'Campus Manager'=> 'Campus Manager',
											  'Coreographer'=> 'Coreographer',
											  'Course Director'=> 'Course Director',
											  'Assistant Course Director'=> 'Assistant Course Director', 
											  'Sport Leader'=> 'Sport Leader',
											  'Teacher'=> 'Teacher'
										);	
										echo form_dropdown('type_contract', $options, $nome['type_contract']);
											?>
										</td>
										</tr>
										<tr><td colspan="2" align="right"><input class="button" type="submit" value="Submit" /></td></tr>
										</form>
				</table>
				</div>
		</div>
	</div>
</body>