<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?=$title?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 

<style type="text/css">
<!--
.intro {
	color: #336699;
}
-->
</style>
</head>
<body>
<img src="<?php echo base_url(); ?>images/agenti_header.png" style="margin:10px 0 0 0">
<div id="container">
	<div id="bigbox">	
	<?php $this->load->view('agenti_tab');?>
		<div id="left" >
			<div class="left_menu" >
				<?php $this->load->view('agenti_left_marketing');?>
			</div>

		<div id="middle">

			<div id="up_middle" style="background:#fff url('../../images/agenti_up_middle.png') no-repeat; margin:0 0 0 0px; padding:5px 0 0 0; height:30px;"><h2>PLUS EXPERIENCE</h2>
			</div>
			<div id="text_middle_document" style="padding:10px 10px 40px 10px;text-align:left; font-size:11px;line-height:18px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x;">
			<img src="../../images/polaroid/plus-experience.png" style="float:left">
<br><br><p class="intro">And for those looking for the most stimulating study holiday, PLUS has created the EXPERIENCE package, an &ldquo;All inclusive&rdquo; programme that will make your study holiday even more special.</p><br>
The PLUS&nbsp; EXPERIENCE is a must for those who wish to truly discover their destinations. You will be able to explore quaint, beautifull villages, throughout the British Isles, legendary Scottish abbeys, or the wonderful Aran Islands in Ireland. Would you prefer a ride on the London Eye or a tour along the U2 trail in Dublin?<br>
A rafting course in Canada or a relaxing afternoon on a California beach? With the PLUS EXPERIENCE you only have to choose your location and let us take care of all the rest.
</div>
</div>

		<div id="right">
			<?php $this->load->view('agenti_right_marketing');?>
		</div>
		<?php $this->load->view('agenti_footer');?></body>
</div>

</html>