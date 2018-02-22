<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?=$title?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 

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

			<div id="up_middle" style="background:#fff url('../../images/agenti_up_middle.png') no-repeat; margin:0 0 0 0px; padding:5px 0 0 0; height:30px;"><h2>THE PACKAGE INCLUDE</h2>
			</div>
			<div id="text_middle_document" style="padding:10px 10px 40px 10px;text-align:left; font-size:11px;line-height:18px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x;">
		<img src="../../images/polaroid/package-includes-bis.png" style="float:center">
            <ol>
          
              <li>20 English Language Lessons per week during mornings</li>
              <li>Multinational classes</li>
              <li>Maximum 15 students per class</li>
              <li>Full board package</li>
              <li>Full day and Half day excursions 7 day&rsquo;s a week supervised social activity with: Discos, sports, karaoke, films&hellip;</li>
              <li>Text book</li>
              <li>End of Course Diploma</li>
              <li>24 hours assistance with Worlwide coverage</li>
           
</div>
</div>

		<div id="right">
			<?php $this->load->view('agenti_right_marketing');?>
		</div>
		<?php $this->load->view('agenti_footer');?></body>
</div>

</html>