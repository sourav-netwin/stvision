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

			<div id="up_middle" style="background:#fff url('../../images/agenti_up_middle.png') no-repeat; margin:0 0 0 0px; padding:5px 0 0 0; height:30px;"><h2>OUR COURSES</h2>
			</div>
			<div id="text_middle_document" style="padding:10px 10px 40px 10px;text-align:left; font-size:11px;line-height:18px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x;">
			<img src="../../images/polaroid/our-courses2.png" style="float:left">
<br><br><br><br>
<p class="intro">PLUS provied a comprehensive range <br>of programmes for studente who wish <br>to Study Abroad.</p>
<br>
<p>Our courses are designed for students who wish to become more proficient in English and more confident in their speaking and listening skills. <br> Our highly-interactive course&nbsp; reflects this awareness and is focused on fuctional and communicative language studies with a specific focus on vocabulary and pronunciation skills. We use specially &ndash; designed text books wich have been specifically written for teenage students on short summer courses. There are gennerally 12-13 students in a class with a maximum of 15 students. The courses are planned around 20 lessons per week (45 minutes each) from Monday to Friday wich is a total of 15 hours a week, at up to five different levels from Beginner to Advanced.</p>
			</div>
			

		</div>

		<div id="right">
			<?php $this->load->view('agenti_right_marketing');?>
		</div>
		<?php $this->load->view('agenti_footer');?></body>
</div>

</html>