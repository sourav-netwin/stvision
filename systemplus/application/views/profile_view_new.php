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
	
#slidingDiv1 {display: none;}
#slidingDiv2 {display: none;}
#slidingDiv3 {display: none;}
#slidingDiv4 {display: none;}

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
<script type="text/javascript">
function open_win(sito)
{
	window.location=sito
}
</script>
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
</head>
<body style="background-image:none;">

<div id="main" style="margin:0px; padding:0; width:990px;">
<div id="container">
		<div id="menu_up">
			<?php	echo anchor("cms","HOME");  echo " | "  . anchor("cms/panelfilter","Find"); ?>
		</div>

		
		
		<div id="left">
		
		</div>

		<div id="middle">	
			<h1 class="blu"><?php echo $heading;?></h1>
			    <div id="all"><a href="#" onClick="showSlidingDiv('slidingDiv1'); return false;">PERSONAL INFORMATION</a>
				
				<div id="slidingDiv1"  name="faq">
				
				<table cellspacing="12" cellpadding="12">
				<tr><td class="separa" colspan="2"><h4>PERSONAL INFORMATION</h4></td></tr>
				
				<?php 
									
										foreach ($getcandidate as $nome){
										?>
										<tr><td class="head">Title, Name Surname</td><td><h4><?php echo $nome['title'] . "&nbsp;" . $nome['nome'] . "&nbsp;" . $nome['cognome']; ?></h4></td></tr>
										<tr><td class="head">Gender</td><td><h4><?php echo $nome['malefemale']; ?></h4></td></tr>
										<tr><td class="head">Nationality</td><td><h4><?php echo $nome['nationality']; ?></h4></td></tr>
										<tr><td class="head">Email</td><td><h4><a href="mailto:<?php echo $nome['email']; ?>"><?php echo $nome['email']; ?></a></h4></td></tr>
										<tr><td class="head">Address</td><td><h4><?php echo $nome['address']; ?></h4></td></tr>
										<tr><td class="head">Permanent address Until</td><td><h4>Day:&nbsp;<?php echo $nome['dayaddress'] . "&nbsp;Month:&nbsp;" . $nome['monthaddress']; ?></h4></td></tr>
										<tr><td class="head">Status</td><td><h4><?php echo $nome['status']; ?></h4></td></tr>
										<tr><td class="head">Town</td><td><h4><?php echo $nome['towncity']; ?></h4></td></tr>
										<tr><td class="head">County</td><td><h4><?php echo $nome['county']; ?></h4></td></tr>
										<tr><td class="head">Country</td><td><h4><?php echo $nome['country']; ?></h4></td></tr>
										<tr><td class="head">Telephone</td><td><h4><?php echo $nome['telephone']; ?></h4></td></tr>
										<tr><td class="head">Mobile</td><td><h4><?php echo $nome['mobile']; ?></h4></td></tr>
										<tr><td class="head">Fax</td><td><h4><?php echo $nome['fax']; ?></h4></td></tr>
				
				</table>
				<a href="#" onClick="hideSlidingDiv('slidingDiv1'); return false;">chiudi</a> 
				</div>
				</div>
				<div id="all"><a href="#" onClick="showSlidingDiv('slidingDiv2'); return false;">WORK INFORMATION</a>
				<div id="slidingDiv2"  name="faq">
				<table cellspacing="12" cellpadding="12">

										<tr><td class="separa" colspan="2"><h4>Work Information</h4></td></tr>
										<tr><td class="head">Available for summer work from</td><td><h4>Day:&nbsp;<?php echo $nome['dayworkfrom'] . "&nbsp;Month:&nbsp;" . $nome['monthworkfrom']; ?></h4></td></tr>
										<tr><td class="head">Available for summer work until</td><td><h4>Day:&nbsp;<?php echo $nome['dayworkuntil'] . "&nbsp;Month:&nbsp;" . $nome['monthworkuntil']; ?></h4></td></tr>
										<tr><td class="head">Other time of the year?</td><td><h4><?php echo $nome['othertime']; ?></h4></td></tr>
										<tr><td class="head">Available from</td><td><h4>Day:&nbsp;<?php echo $nome['dayothertime'] . "&nbsp;Month:&nbsp;" . $nome['monthothertime']; ?></h4></td></tr>
										<tr><td class="head">Available Until</td><td><h4>Day:&nbsp;<?php echo $nome['dayothertimeuntil'] . "&nbsp;Month:&nbsp;" . $nome['monthothertimeuntil']; ?></h4></td></tr>
										<tr><td class="head">Work before for us</td><td><h4><?php echo $nome['workplusbefore']; ?></h4></td></tr>
										<tr><td class="head" colspan="2">Work before for us</td></tr>
										<tr><td colspan="2"><?php echo $nome['commentsworkplus']; ?></td></tr>
										<tr><td class="head" colspan="2">Restrictions residence in the UK</td></tr>
										<tr><td colspan="2"><?php echo $nome['restriction']; ?></td></tr>
										<tr><td class="head" colspan="2">Action pending</td></tr>
										<tr><td colspan="2"><?php echo $nome['criminal']; ?></td></tr>
										<tr><td colspan="2"><?php echo $nome['criminalinfo']; ?></td></tr>
				</table>
				<a href="#" onClick="hideSlidingDiv('slidingDiv2'); return false;">chiudi</a> 
				</div>
				</div>
				<div id="all"><a href="#" onClick="showSlidingDiv('slidingDiv3'); return false;">POSITION</a>
				<div id="slidingDiv3"  name="faq">
				<table cellspacing="12" cellpadding="12">
										<tr><td class="separa" colspan="2"><h4>POSITION</h4></td></tr>
										<tr><td class="head" >POSTION</td><td><?php echo $nome['preferredposition']; ?></td></tr>
										<tr><td class="head" >PREFERRED CENTER</td><td><?php echo $nome['preferredcentre']; ?></td></tr>
										<tr><td class="head" >ACCOMODATION</td><td><?php echo $nome['accomodationcentre']; ?></td></tr>
										<tr><td class="head" colspan="2">JOBHELD</td></tr>
										<tr><td colspan="2"><?php echo $nome['jobheld']; ?></td></tr>
										<tr><td class="separa" colspan="2"><h4>TEACHER</h4></td></tr>
										<tr><td class="head" >EFL</td><td><?php echo $nome['efl']; ?></td></tr>
										<tr><td class="head" >QUALIFICATION</td><td><?php echo $nome['qualification']; ?></td></tr>
										<tr><td class="head" >TEFL CERTIFICATE NUMBER</td><td><?php echo $nome['teflnumber']; ?></td></tr>
										<tr><td class="head" >TEFL PROVIDER</td><td><?php echo $nome['teflprovider']; ?></td></tr>
										<tr><td class="head" >HOURS OF ELT/TESOL</td><td><?php echo $nome['hourselttesol']; ?></td></tr>
										<tr><td class="head" >HOURS PRACTICE</td><td><?php echo $nome['hourspractice']; ?></td></tr>
										<tr><td class="head" >TEACHING IN UK</td><td><?php echo $nome['teachinguk']; ?></td></tr>
										<tr><td class="head" colspan="2">DESCRIPTION</td></tr>
										<tr><td colspan="2"><?php echo $nome['teachingukdesc']; ?></td></tr>
										<tr><td class="separa" colspan="2"><h4>ACTIVITY LEADERS</h4></td></tr>
										<tr><td class="head" >COACHING</td><td><?php echo $nome['coaching']; ?></td></tr>
										<tr><td class="head" colspan="2">DESCRIPTION</td></tr>
										<tr><td colspan="2"><?php echo $nome['coachingdesc']; ?></td></tr>
										<tr><td class="head" >FIRST AID</td><td><?php echo $nome['firstaid']; ?></td></tr>
										<tr><td class="head" >VALID FROM MONTH</td><td><?php echo $nome['monthaidfrom']; ?></td></tr>
										<tr><td class="head" >VALID FROM YEAR</td><td><?php echo $nome['yearaidfrom']; ?></td></tr>
										<tr><td class="head" >VALID UNTIL MONTH</td><td><?php echo $nome['monthaiduntil']; ?></td></tr>
										<tr><td class="head" >VALID UNTIL YEAR</td><td><?php echo $nome['yearaiduntil']; ?></td></tr>
										<tr><td class="head" colspan="2">NAME INSTITUTE</td></tr>
										<tr><td colspan="2"><?php echo $nome['institute']; ?></td></tr>
										<tr><td class="head" colspan="2">RECENT EMPLOYER</td></tr>
										<tr><td class="head" colspan="2">SPORT COREOGRAPHER</td></tr>
										<tr><td colspan="2"><?php echo $nome['sportcoreographer']; ?></td></tr>
										<tr><td class="head" >SPORT</td><td><?php echo $nome['sport']; ?></td></tr>
										<tr><td class="head" colspan="2">INTERVIEW</td></tr>
										<tr><td colspan="2"><?php echo $nome['interview']; ?></td></tr>
										<tr><td class="head" colspan="2">PERSONALITY</td></tr>
										<tr><td colspan="2"><?php echo $nome['personality']; ?></td></tr>
				</table>
				<a href="#" onClick="hideSlidingDiv('slidingDiv3'); return false;">chiudi</a> 
				</div>
				</div>
				<div id="all"><a href="#" onClick="showSlidingDiv('slidingDiv4'); return false;">OTHER</a>
				<div id="slidingDiv4"  name="faq">
				<table cellspacing="12" cellpadding="12">
										<tr><td class="separa" colspan="2"><h4>CRIMINAL INFO</h4></td></tr>
										<tr><td class="head" >CRIMINAL OFFENCE</td><td>
										<?php 
												if ($nome['criminal']){
												echo $nome['criminal'];
											}else{
												echo "no";
											}
										
										?>
										
										</td></tr>
										<tr><td class="head" >FURTHER INFORMATION</td><td><?php echo $nome['criminalinfo']; ?></td></tr>
										
										<tr><td class="separa" colspan="2"><h4>REFERENCE</h4></td></tr>
										<tr><td class="head" >EMAIL</td><td><?php echo $nome['refemail']; ?></td></tr>
										<tr><td class="head" >ADDRESS</td><td><?php echo $nome['refaddress']; ?></td></tr>
										<tr><td class="head" >TOWN</td><td><?php echo $nome['reftown']; ?></td></tr>
										<tr><td class="head" >COUNTY</td><td><?php echo $nome['refcounty']; ?></td></tr>
										<tr><td class="head" >POSTCODE</td><td><?php echo $nome['refpostcode']; ?></td></tr>
										<tr><td class="head" >COUNTRY</td><td><?php echo $nome['refcountry']; ?></td></tr>
										<tr><td class="head" >PHONE</td><td><?php echo $nome['refphonenumber']; ?></td></tr>
										<tr><td class="head" >FAX</td><td><?php echo $nome['reffax']; ?></td></tr>
										<tr><td class="separa" colspan="2"><h4>PDF DOCUMENT</h4></td></tr>
										<tr><td class="head" >CV</td><td><?php echo "<a target=\"_blank\" href=\"/apps/uploadpdf/" . $nome['pdf'] . ".pdf\">Click to view</a>"; ?></td></tr>
										<tr><td class="head" >CERTIFICATE</td><td><?php echo "<a target=\"_blank\" href=\"/apps/uploadpdf/" . $nome['certificate'] . ".pdf\">Click to view</a>"; ?></td></tr>
				</table>
				<a href="#" onClick="hideSlidingDiv('slidingDiv4'); return false;">chiudi</a> 
				</div>
				</div>
				<table width="100%" cellspacing="12" cellpadding="12" >
									<tr><td id="all" colspan="2"><h4>SETUP STATUS - <?php echo $nome['title'] . "&nbsp;" . $nome['nome'] . "&nbsp;" . $nome['cognome']; ?></h4></td></tr>
									  <?php
										$idsegment="cms/update_candidate/" . $this->uri->segment(3);
										echo form_open($idsegment);

										echo "<tr><td ><h5>Status</h5></td></tr><tr><td >";
										
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
										}
									  ?>
									  </td>
									  </tr>
									 <tr><td><h5>Date Start</h5></td></tr><tr><td><input type="text" id="datepicker_start" name="date_start" value=""></td></tr>
									 <tr><td><h5>Date End</h5></td></tr><tr><td><input type="text" id="datepicker_end" name="date_end" value=""></td></tr>
									 <tr><td><h5>Weekly Salary</h5></td></tr><tr><td><input type="text" name="salary" value=""></td></tr>
									 <tr><td><h5>Center</h5></td></tr>
									 <tr>
										<td>
											<?php
												  $options = array(
												  //$nome['center_def']=>$nome['center_def'],
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
										</td>
									 </tr>
									 <tr><td><h5>Type of contract</h5></td></tr>
									 <tr>
										<td>
											<?php
												  $options = array(
												  $nome['type_contract']=>$nome['type_contract'],
												  'Activity Leader'=>'Activity Leader',
												  'Airport Co-ordinator'=>'Airport Co-ordinator',
												  'Campus Manager'=>'Campus Manager',
												  'Coreographer'=>'Coreographer',
												  'Course Director'=>'Course Director',
												  'Assistant Course Director'=>'Assistant Course Director',
												  'Sport Leader'=>'Sport Leader',
												  'Teacher'=>'Teacher'
												);

											echo form_dropdown('type_contract', $options, 'choose');
											?>
										</td>
									 </tr>
									  <tr><td><h5>Notes</h5></td></tr>
									 <tr>
										<td >
										<textarea name="comment" style="background-color:#FBF6D0" rows="6" cols="45"><?php echo $nome['comment'] ?></textarea>
										</td>
									 </tr>
										<input type="hidden" name="nome" value="<?php echo $nome['nome'] ?>">
										<input type="hidden" name="cognome" value="<?php echo $nome['cognome'] ?>">
									  <tr><td colspan="2" align="right"><input class="button" type="submit" value="Submit" /></td></tr>
									  </form>
									  
									  <?php 
												echo "<tr><td colspan=\"2\"><h3 style=\"padding:10px 0;color:#fafafa;background-color:#ccc;width:100%\">Contract</h3></td></tr>";
												foreach($multiplo as $mcontract){

													echo "<tr><td colspan=\"2\"></td></tr>";
													echo "<tr><td colspan=\"2\"><h5>Center</h5> ".$mcontract['center_def']."</td></tr>";
													echo "<tr><td colspan=\"2\"><h5>Start at</h5> ".$mcontract['date_start']."</td></tr>";
													echo "<tr><td colspan=\"2\"><h5>End</h5> ".$mcontract['date_end']."</td></tr>";
													echo "<tr><td colspan=\"2\"><h5>Salary</h5> ".$mcontract['salary']."</td></tr>";
													echo "<tr><td colspan=\"2\"><h5>Status</h5> ".$mcontract['status']."</td></tr>";
													echo "<tr><td colspan=\"2\"><h5>type of contract</h5> ".$mcontract['type_contract']."</td></tr>";
													echo "<tr><td><input class=\"button\"type=\"button\" value=\"edit\" onclick=\"open_win('".base_url()."index.php/cms/EditMultiple/".$mcontract['id']."/')\" /></td>";
													echo "<td><input class=\"button\"type=\"button\" value=\"delete\" onclick=\"open_win('".base_url()."index.php/cms/del_mcontract/".$mcontract['id']."/".$this->uri->segment(3)."')\" /></td></tr>";
													echo "<tr><td><hr></td></tr>";
												}
											
									  ?>



									  <tr><td><?php echo anchor('cms/contract/'.$this->uri->segment(3), 'Generate Contract for this person?'); ?></td></tr>

									
				</table>
				</div>
		</div>
	</div>
</div>


</body>