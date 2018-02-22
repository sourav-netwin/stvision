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
	font-family: Georgia, Times New Roman, Times, serif;
	margin:9px 0 0 0;
	font-size: 10px;

}
.small{
	font-size: 9px;
	color: #999;
}
form {
		
	font-size: 12px;
	background:#EBF0F5; 
	color: #002166;
	display: block;
	padding:0 0 0 10px;
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
				  $idsegment="job/insertinfo/" . $this->uri->segment(3);
				  
			?>
			
			<?php echo form_open_multipart($idsegment); ?>

			<input type="hidden" name="idannuncio" value="<? echo $this->uri->segment(3) ?>" />
			<br/>
			
			<?
				  $options = array(
                  'mr'=> 'Mr',
                  'ms'=> 'Ms',
				  'miss'=> 'Miss'
                );

			echo form_dropdown('malefemale', $options);
			?>

			<h5>Name</h5>
			<input type="text" name="nome" value="<?php echo $this->validation->nome;?>" size="50" />
			<h5>Surname</h5>
			<input type="text" name="cognome" value="<?php echo $this->validation->cognome;?>" size="50" />
			<h5>Email Address</h5>
			<input type="text" name="myemail" value="<?php echo $this->validation->email;?>" size="50" />
			
			<h5>Home Address</h5>
			<input type="text" name="indirizzo" value="<?php echo $this->validation->indirizzo;?>" size="55" />
			<h5>Phone Number</h5>
			<input type="text" name="phonenumber" value="" size="20" />
			<h5>Nationality</h5>
			<input type="text" name="nationality" value="" size="50" />
			<h5>Native Language</h5>
			<input type="text" name="nativelanguage" value="" size="50" />	
			<h5>Other Languages Spoken and Level of Fluency:</h5>
				<input type="text" name="otherlanguagesspoken" value="" size="30" />
				<?
					  $options = array(
					  'ns'=>'NS',
					  'f'=>'F',
					  'int'=> 'INT',
					  'el'=>'EL'
					);
					echo form_dropdown('levelspoken', $options, 'NS');
				?>

			<h5>Have you worked for PLUS before?</h5>
			<?
				  $options = array(
                  'yes'=>'yes',
                  'no'=>'no'
                );

			echo form_dropdown('workplusbefore', $options, 'No');
			?>
			<h5>When are you available to work for us?</h5>
			from:<input type="text" name="from" value="YYYY-MM-DD" size="15" />
			
			to: <input type="text" name="to" value="YYYY-MM-DD" size="15" />
			<h5>Please insert the centres for which you would like to be considered</h5>
			<input type="text" name="centre" value="" size="50" />
			<h5 >* Initial TEFL qualification (e.g. CELTA/Trinity CertTESOL)<br/><span class="red">Required for Teaching position</span></h5>
			<input type="text" name="initialtefl" value="" size="50" />
			<h5 >* Higher TEFL qualification (e.g. DELTA / Trinity Dip / Masters)<br/><span class="red">Required for Teaching position</span></h5>
			<input type="text" name="highertefl" value="" size="50" />
			<h5 >* How many years of full-time TEFL experience do you have?<br/><span class="red">Required for Teaching position</span></h5>
			<input type="text" name="highertefl_year" value="" size="9" />
			<h5>Do you have a valid First Aid certificate?</h5>
			<?
				  $options = array(
                  'yes'=>'yes',
                  'no'=>'no'
                );

			echo form_dropdown('firstaid', $options, 'No ');
			?>
			<h5>Have you ever been convicted of a criminal offence? </h5>
			<h5 class="small">In compliance with The Protection of Children Act 1999, applicants are advised that police checks may be carried out to ensure suitability to work with children. Please note that people employed to work with children or young people are not covered by the Rehabilitation of Offenders Act 1974  and are required to declare all convictions, spent or otherwise. If you have answered yes, please add a brief note of explanation.
			</h5>
			<?
				  $options = array(
                  'yes'=>'yes',
                  'no'=>'no'
                );

			echo form_dropdown('criminal', $options, 'No ');
			?>
			
			<h5>Do you have a valid enhanced crb disclosure certificate?</h5>
			<?
				  $options = array(
                  'yes'=>'yes',
                  'no'=>'no'
                );

			echo form_dropdown('crb', $options, 'No ');
			?>
			
			<h5>Do you hold a valid work permit? (Non EU applicants only)</h5>
			<h5 class="small">Please note that we are NOT able to obtain permits for applicants for temporary posts.</h5>
			<?
				  $options = array(
                  'yes'=>'yes',
                  'no'=>'no'
                );

			echo form_dropdown('permit', $options, 'No ');
			?>

			<h5>Do you have any medical conditions that we should know about? </h5>
			<h5 class="small">If yes, please give details. For your own safety, it is particularly important for us to know if you are diabetic or epileptic.</h5>
			<input type="text" name="medical" value="" size="50" />
			
			<h5>Do you have access to a uk bank account?</h5>
			<h5 class="small">PLUS pays its teachers by means of a cheque in Pounds Sterling. If you do not have a UK bank account you will need to have someone to whom your cheque can be paid on your behalf. We WILL NOT pay you in cash, or issue a ‘Pay Cash’ cheque, for security reasons.</h5>
			<?
				  $options = array(
                  'yes'=>'yes',
                  'no'=>'no'
                );

			echo form_dropdown('bank', $options, 'No ');
			?>
			<h5>Please upload an up-to-date CV (.pdf max 500Kb)</h5>
			<input type="file" name="cvfile" size="20" />
			<h5>Please upload your degree certificate Browse (.pdf max 500Kb)</h5>
			<input type="file" name="userfile" size="20" />
			
			
			<div><input type="submit" value="Submit" /></div>
			

			</form>
			<h5 class="red">* Required  for Teaching position</h5><br/>
</div>	
	<div id="right">
		<img  src="<?php echo base_url(); ?>images/image001_small.jpg">
		
	</div>
		
	<div id="footer">init</div>		
</div>
</center>

</body>
