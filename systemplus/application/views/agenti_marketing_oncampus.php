<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?=$title?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 

<style type="text/css">
<!--
.intro {
	color: #336699;
	font-style: normal;
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

			<div id="up_middle" style="background:#fff url('../../images/agenti_up_middle.png') no-repeat; margin:0 0 0 0px; padding:5px 0 0 0; height:30px;"><h2>WHO'S WHO ON CAMPUS</h2>
			</div>
			<div id="text_middle_document" style="padding:10px 10px 40px 10px;text-align:left; font-size:11px;line-height:18px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x;">
			<br><img src="../../images/polaroid/who-campus.png" style="float:left">
			<br><br><strong>Course Director</strong><br>
  The Course Director has overall responsability for academic side of&nbsp; the programme. He guides the teachers and ensures lessons are running about their study programme, don&rsquo;t hesitate to speak to him.
  </p>
<br><p><strong>Campus Manager</strong><br>
  The Campus Manager has overall responsibility for the wellbeing of all students while staying at our PLUS center. He will check on the accomodation, catering, excursions&nbsp; and leisure programme to ensure everything is of the high standars we insist upon at our centres. Come and talk to the Campus manager any time about anything!</p>

<p><strong>Activity Leader</strong><br>
  Activity Leaders run the afternoon and evening activities on campus. Students can recognise them by their PLUS Uniforms. They are all native English speakers and can help students practise their English while playing sports and enjoying the many leisure activities.</p>
<p><strong>Teacher</strong><br>
  PLUS teachers lead classes every morning and students will get to know their teacher very well. Teachers are qualified native English speakers and want to help students improve their English while having fun with the language. Teachers also help out with some afternoon and evening activities and join the weekend excursions.</p>

</div>
</div>

<div id="right">
<?php $this->load->view('agenti_right_marketing');?>
</div>
<?php $this->load->view('agenti_footer');?></body>
</div>

</html>