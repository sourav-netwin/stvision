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

			<div id="up_middle" style="background:#fff url('../../images/agenti_up_middle.png') no-repeat; margin:0 0 0 0px; padding:5px 0 0 0; height:30px;"><h2>ACTIVITIES ON CAMPUS</h2>
			</div>
			<div id="text_middle_document" style="padding:10px 10px 40px 10px;text-align:left; font-size:11px;line-height:18px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x;">
			<img src="../../images/polaroid/activities-campus.png" style="float:left">
<br><br><br>
<p class="intro">PLUS is extremely proud of its fun-filled, <br>action-packed leisure programme. PLUS ensures that students will always have plenty to do, all day long, seven days a week.</p><br>
Educational visit to places of cultural and historical interest form an important part of the course programme at each campus. Students are also able to enjoy sporting and leisure&nbsp; activities during the afternoon, while sports tournaments are organised by PLUS staff. Every night&nbsp; there will be a choice of disco-music (two/three times per week), films shows (with English subtitles), quizzes, treasure hunts, drama, workshops, table-tennis and other indoor games organised by our residential staff.
</div>
	
		</div>

		<div id="right">
			<?php $this->load->view('agenti_right_marketing');?>
		</div>
		<?php $this->load->view('agenti_footer');?></body>
</div>

</html>