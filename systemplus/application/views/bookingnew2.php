<html>
<head>
<title><?=$title?></title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/ddlevelsfiles/ddlevelsmenu-base.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>/css/ddlevelsfiles/ddlevelsmenu.js"></script>
<script type="text/javascript">
	ddlevelsmenu.setup("ddtopmenubar", "topbar");
</script>
<style type="text/css">

h5{
	font-family: Lucida Grande, Verdana, Sans-serif;
	margin:10px 10px 10px 0;
	font-size: 11px;
	color: #aaa57c;

}
.small{
	font-size: 9px;
	color: #999;
}
form {
	
	font-family: Lucida Grande, Verdana, Sans-serif;
	font-size: 11px;
	background:#fff; 
	color: #aaa57c;
	display: block;
	
	padding:0 0 0 0px;
}

input {
	margin:0 0 10px 0;
	border:1px solid #ccc;
	background-color:#f5f5f5;
}
.location {
 display:block;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 9px;
 color: #3d7db5;
 margin:0 0 0 16px;
 list-style-type:square ;
}
.block_brown{
	margin:10px 0 4px 0;
	padding:10px; 
	border:2px solid #d5d1af; 
	background:#EBF0CC; 
	color: #aaa57c;
}

</style>
</head>
<body>
<center>
<div id="main">
<div id="container">
		<img src="<?php echo base_url(); ?>images/up_job.jpg"/>
		<div id="menu_up">
			<?php $this->load->view('menu_up');?>
		</div>

		
		<div id="left">
			<img src="<?php echo base_url(); ?>images/image001.jpg">
			<div class="boxsilver_right">
				<img align="middle" src="<?php echo base_url(); ?>images/cube.png">&nbsp;Location:
		
				<ul class="location">
				<li>BATH</li>
				<li>BEDFORD</li>
				<li>CAMBRIDGE</li>
				<li>CANTERBURY</li>
				<li>CHATHAM</li>
				<li>CHELMSFORD</li>
				<li>CHELTENHAM</li>
				<li>CHESTER</li>
				<li>EDINBURGH</li>
				<li>LONDON GREENWICH</li>
				<li>LEICESTER</li>
				<li>LONDON DOCKLANDS</li>
				<li>LONDON ROEHAMPTON</li>
				<li>NORWICH</li>
				<li>PLYMOUTH</li>
				<li>PORTSMOUTH</li>
				<li>SHEFFIELD</li>
				<li>ST. ANDREWS</li>
				<li>DUBLIN</li>
				<li>GALWAY</li>
				</ul>
			</div>
		</div>
		
		<div id="middle">		
		<h1 class="blu">Application Form</h1>
			<?php echo $this->validation->error_string; 
				  $idsegment="/appform/insertinfo_three/" . $this->uri->segment(3);
				  
			?>
			
			<?php echo form_open_multipart($idsegment); ?>
			
			<div class="block_brown">
			Position
			</div> 
			<h5>Preferred position</h5>
			<?
				  $options = array(
                  'choose'=>'choose...',
                  'Activity Leader'=>'Activity Leader',
				  'Airport Co-ordinator'=>'Airport Co-ordinator',
				  'Campus Manager'=>'Campus Manager',
				  'Choreographer'=>'Choreographer',
				  'Course Director'=>'Course Director',
				  'Assistant Course Director'=>'Assistant Course Director',
				  'Sport Leader'=>'Sport Leader',
				  'Teacher'=>'Teacher'

                );

			echo form_dropdown('preferredposition', $options, 'choose');
			?>
			<div class="block_brown">Preferred Centre</div> 
			<h5>Preferred Center</h5>
			<?
				  $options = array(
                  'choose'=>'choose...',
				  'BATH'=>'BATH',
                  'BEDFORD'=>'BEDFORD',
				  'CAMBRIDGE'=>'CAMBRIDGE',
				  'CANTERBURY'=>'CANTERBURY',
				  'CHELMSFORD'=>'CHELMSFORD',
				  'CHELTENHAM'=>'CHELTENHAM',
				  'CHESTER'=>'CHESTER',
				  'EDINBURGH'=>'EDINBURGH',
				  'LEICESTER'=>'LEICESTER',
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

			echo form_dropdown('preferredcentre', $options, 'choose');
			?>
			
			
			<div class="block_brown">
			Qualifications 
			</div> 
			<h5>Do you require accommodation for your first choice of centre? </h5>
			<?
				  $options = array(
                  ''=>'',
				  'yes'=>'Yes',
                  'no'=>'No'
                );

			echo form_dropdown('accomodationcentre', $options, '$this->validation->accomodationcentre');
			?>

			<h5>Please give details of jobs held, in 3 years, starting with your current or most recent employer. Include Employer name and full address; Job held</h5>
			<textarea NAME="jobheld" COLS=40 ROWS=6></textarea>
			<h5>Do you hold an EFL teaching qualification? *  Yes  No</h5>
			<?
				  $options = array(
                  ''=>'',
				  'yes'=>'Yes',
                  'no'=>'No'
                );

			echo form_dropdown('efl', $options, '');
			?>
			<h5>If yes, please select type of qualification</h5>
			<?
				   $options = array(
                  ''=>'',
				  'ma'=>'MA APPLIED LINGUISTIC',
                  'rsacelta'=>'RSA CELTA',
                  'rsadelta'=>'RSA DELTA',
                  'tesol'=>'TESOL',
                  'trinitycertificate'=>'TRINITY CERTIFICATE',
                  'trinitylic'=>'TRINITY LIC. DIP.'
                );

			echo form_dropdown('qualification', $options, '');
			?> 
			<h5>Registration number of TEFL course</h5>
			<input type="text" name="teflnumber" value="" size="50" />
			<h5>TEFL course provider</h5>
			<input type="text" name="teflprovider" value="" size="50" />
			<h5>ELT/TESOL course input (total number of hours) </h5>
			<input type="text" name="hourselttesol" value="" size="10" />
			<h5>Supervised ELT/TESOL teaching practice (total number of hours</h5>
			<input type="text" name="hourspractice" value="" size="10" />
			<h5>Do you have experience of teaching in the UK or abroad? </h5>
			<?
				  $options = array(
                  ''=>'',
				  'yes'=>'Yes',
                  'no'=>'No'
                );

			echo form_dropdown('teachinguk', $options, '');
			?>
			<h5>If yes, please give a brief description</h5>
			<textarea NAME="teachingukdesc" COLS=40 ROWS=6></textarea>
			<h5>Do you hold a coaching qualification? </h5>
			<?
				  $options = array(
                  ''=>'',
				  'yes'=>'Yes',
                  'no'=>'No'
                );

			echo form_dropdown('coaching', $options, '');
			?>
			<h5>If yes, please list the coaching qualifications and dates valid from/to</h5>
			<textarea NAME="coachingdesc" COLS=40 ROWS=6></textarea>
			
			
			<div style="display:block; margin:10px; padding:10px;float:right;"><input type="submit" value="Next" /></div>
			</form>
			
</div>	
	<div id="right">
		<img  src="<?php echo base_url(); ?>images/image001_small.jpg">
		
	</div>
		
		<div id="footer">Copyright © 2010 PLUS EDUCATIONAL All rights reserved.</div>		
</div>
</center>

</body>
