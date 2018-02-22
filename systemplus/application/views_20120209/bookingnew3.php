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
				<li>LEEDS</li>
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
				  $idsegment="appform/insertinfo_four/" . $this->uri->segment(3);
				  
			?>
			
			

			<?php echo form_open_multipart($idsegment); ?>
			
			<div class="block_brown">
				FOR ACTIVITY LEADERS AND CAMPUS STAFF
			</div> 
			<h5>Do you have a valid First Aid certificate?</h5>
			<?
				  $options = array(
                  ''=>'',
				  'yes'=>'Yes',
                  'no'=>'No'
                );

			echo form_dropdown('firstaid', $options, '$this->validation->firstaid');
			?>
			<h5>First Aid Certificate valid from</h5>
			Month <?
				  $options = array(
                  '1'=> '1',
                  '2'=> '2',
				  '3'=> '3',
				  '4'=> '4',
				  '5'=> '5',
				  '6'=> '6',
				  '7'=> '7',
				  '8'=> '8',
				  '9'=> '9',
				  '10'=> '10',
				  '11'=> '11',
				  '12'=> '12',
				  
                );

			echo form_dropdown('monthaidfrom', $options);
			?>
			Year <?
				  $options = array(
                  '2010'=> '2010',
                  '2009'=> '2011',
				  '2008'=> '2012',
				  '2007'=> '2013',
				  '2006'=> '2006',
				  '2005'=> '2005',
				  '2004'=> '2004',
				  '2003'=> '2003',
				  '2002'=> '2002',
				  '2001'=> '2001',
				  '2000'=> '2000',
				  'sup'=> 'sup.'
                );

			echo form_dropdown('yearaidfrom', $options);
			?>
			<h5>First Aid Certificate valid until</h5>
				Month <?
				  $options = array(
                  '1'=> '1',
                  '2'=> '2',
				  '3'=> '3',
				  '4'=> '4',
				  '5'=> '5',
				  '6'=> '6',
				  '7'=> '7',
				  '8'=> '8',
				  '9'=> '9',
				  '10'=> '10',
				  '11'=> '11',
				  '12'=> '12',
				  
                );

			echo form_dropdown('monthaiduntil', $options);
			?>
			Year <?
				  $options = array(
                  '2010'=> '2010',
                  '2009'=> '2011',
				  '2008'=> '2012',
				  '2007'=> '2013',
				  '2006'=> '2014',
				  '2005'=> '2015',
				  '2004'=> '2016',
				  '2003'=> '2017',
				  '2002'=> '2018',
				  'sup'=> 'sup.'
                );

			echo form_dropdown('yearaiduntil', $options);
			?>
			<div class="block_brown">
			Education, Technical and Professional Qualifications
			</div>
			<h5>Please name any institute or professional body in full and include attainment level</h5>
			<textarea NAME="institute" COLS=40 ROWS=6></textarea>
			<h5>Please give details of jobs held in 3 years, starting with your current or most recent employer. Include Employer name and full address; Job held.</h5>
			<textarea NAME="recentemployer" COLS=40 ROWS=6></textarea>
			<div class="block_brown">
				Practical experience
			</div>
			<h5>Please give details of any experience you have in the following areas:SPORT, COREOGRAPHER</h5>
			<textarea NAME="sportcoreographer" COLS=40 ROWS=6></textarea>
			<h5>Which sport would you fell confident to teach to Kids at our camps</h5>
			<?
				  $options = array(
                  ''=>'',
				  'Rugby'=>'Rugby',
                  'Football'=>'Football',
				  'Volleyball'=>'Volleyball',
				  'Basketball'=>'Basketball',
				  'Cricket'=>'Cricket',
				  'Swimming'=>'Swimming',
				  'Tennis'=>'Tennis',
                );

			echo form_dropdown('sport', $options, 'No ');
			?>
			
			<h5>PLUS normally conducts telephone interviews. Please state below if you cannot undertake a telephone interview. (Face to face interviews at our Head Office can be arranged if required).</h5>
			<textarea NAME="interview" COLS=40 ROWS=6></textarea>
			<h5>Please state 3 positive and 3 negative points of your personality.</h5>
			<textarea NAME="personality" COLS=40 ROWS=6></textarea>
			
			
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
