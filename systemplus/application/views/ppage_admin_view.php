<html>
<head>
<title><?=$title;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/generalphp.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/layout.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/cms.css" media="screen" /> 

</head>
<body>
<div id="maincms"  style="height:600px;">
		<img src="<?php echo base_url(); ?>images/logoplus.jpg"/>
		<hr>
		<div id="middle_panelcms">	
			<div class="rounded"  style="height:600px ; width:100%; margin:0; padding:0;">
			<?php echo $this->validation->error_string; ?>
			<h1 class="blu"><?=$heading;?></h1>
						<h4>Dear <?=$title;?> <?=$nome;?> <?=$cognome;?></h4>
					<?php
						$hidden = array('id' => $hideid);
						echo form_open_multipart("personalpage/checkuserok","",$hidden);
						echo "<br><p>Number of Insurance <br></p>";
						echo form_input('insurance') . "</p>";
						echo "<br><p>Name of account holder <br><i>(name as it appears on bank account)</i></p>";
						echo form_input('accountname') . "</p>";
						echo "<p>Account Number</p>";
						echo form_input('accountnumber') . "</p>";
						echo "<p>Sort code</p>";
						echo form_input('sortcode') . "<br/>";

						?>

						<h5>Please upload an up-to-date CV (.pdf max or .doc 500Kb)</h5>
						<input type="file" name="cvfile" size="20" />
						<h5>Please upload your degree certificate Browse (.pdf or .doc max 500Kb)</h5>
						<input type="file" name="userfile" size="20" />

						<?
						echo form_submit('submit',' Send ');
						echo form_close();
					?>
</div>
		</div>
		<div class="minheight">
		<br/>		<br/>		<br/>		<br/>		<br/>
		</div>
		
	<div id="footer_job">Dashboard Teacher</div>
</div>
</body>