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

			<div id="up_middle" style="background:#fff url('../../images/agenti_up_middle.png') no-repeat; margin:0 0 0 0px; padding:5px 0 0 0; height:30px;"><h2>HOME STAY OR CAMPUS ACCOMODATION</h2>
			</div>
			<div id="text_middle_document" style="padding:10px 10px 40px 10px;text-align:left; font-size:11px;line-height:18px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x;">
			<img src="../../images/polaroid/accomodation-campus.png" style="float:left">
<br><br><br><br><p>Your new home abroad is an important part of your study experience, particulary as enjoying life outside of school will help you to learn more effectively in&nbsp; the classroom. </p>
<p class="intro">PLUS offers accomodation worldwide with options designed to give you the opportunity to interact with native&nbsp; speakers or fellow students and to experience more of culture of your chosen study destination.</p>
</div>

		</div>

		<div id="right">
			<?php $this->load->view('agenti_right_marketing');?>
		</div>
		<?php $this->load->view('agenti_footer');?></body>
</div>

</html>