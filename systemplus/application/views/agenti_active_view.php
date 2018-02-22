<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?=$title?></title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<style type="text/css">

a{

	font-family: Monaco, Verdana, Sans-serif;
	font-size: 11px;
	color: #eee;
	text-align:center; 
 
}


</style>
</head>
<body>
<img src="<?php echo base_url(); ?>images/agenti_header.png" style="margin:10px 0 0 0">
<div id="container">
	<div id="bigbox">
			<div id="box_login" style="padding:100px 0 0 0; width:501px; color:#fff">
				<div style="text-align:center;">
					<?=$message?> <br/>						
				</div>
				<div style="margin:150px 40px 0 48px; padding:10px; text-align:center;">	
					<?php 
					if($message == "Duplicate Mail Or Duplicate Username"){
						echo anchor('agenti/registrazioneEnd/' . $this->uri->segment(3), 'Retry ');
					}
					else{
						echo anchor('agenti/', ' Login'); 	
					}
					?>
				</div>
			</div>
		<a href="<?php echo base_url(); ?>index.php/agenti/logged">CodeIgniter.</a></p>
		<?php $this->load->view('agenti_footer');?>					
	</div>
</div>

</body>
</html