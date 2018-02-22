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

			<div id="up_middle" style="background:#fff url('../../images/agenti_up_middle.png') no-repeat; margin:0 0 0 0px; padding:5px 0 0 0; height:30px;"><h2>OUR TEAM</h2>
			</div>
			<div id="text_middle_document" style="padding:10px 10px 40px 10px;text-align:left; font-size:11px;line-height:18px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x;">
			<img src="../../images/polaroid/our-team.png" style="float:left">
<p class="intro">PLUS recruits only fully-qualified personnel <br>to work in our summer schools.  We strive to employ enthusiastic and charismatic staff who we know can deliver a fantastic summer programme. Our aim is for this to not <br> 
only be a study holiday but also one where <br>the students will develop and be aware of international differences. </p>

<p>Our centres are staffed with people from a wide range of backgrounds which will add to the overall cultural experience the students will have.We ensure all our summer camps are places where students can improve their language skills and build their confidence academically as well  as socially.
  
<br><br>
  Our Course Directors are always highly-experienced as both teachers and managers and are able to ensure the smooth running of the centre while overseeing the tuition programme. All teachers working for PLUS, either as Residential Teachers or Non-Residential Teachers have undertaken intensive TEFL teacher training courses to conform to the British Council criteria.</p>

<p><strong>30 YEARS OF EXPERIENCE</strong> <br>
Plus starter operating in the ELT market in 1972. Today, our group with offices in England, Ireland, the USA, Italy and Malta, represents one of the world’s largest and finest organisation in language teaching.

Our success is recognised by over 20.000 student from all around the world who choose PLUS every year for their Study Holiday experience. </p>
</div>
</div>

		<div id="right">
			<?php $this->load->view('agenti_right_marketing');?>
		</div>
<?php $this->load->view('agenti_footer');?></body>
</div>

</html>