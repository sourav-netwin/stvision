<html>
<head>
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
				<ul>
				<li><a class="a" href="<?php echo base_url(); ?>index.php/agenti/gallery">ALL PHOTOS</a></li>
				<li><a class="a" href="<?php echo base_url(); ?>index.php/agenti/gallery/college">COLLEGE</a></li>
				<li><a class="a" href="#">CITIES</a></li>
				<li><a class="a" href="<?php echo base_url(); ?>index.php/agenti/gallery/people">STUDENTS</a></li>
			</ul>
			</div>
			<img src="<?php echo base_url(); ?>images/agent_news_end.png" >	
		</div>

		<div id="middle">
			<div id="up_middle" style="display:block; background:#fff url('<?php echo base_url(); ?>images/agenti_up_middle.png') no-repeat; margin:0 0 0 0px; padding:5px 0 0 0; height:30px;"><h2 style="text-align:left; margin:0 0 0 40px">MEDIA GALLERY</h2>
			</div>
			<div id="text_middle" style="display:block; float:left;padding:10px 10px 40px 10px;
			text-align:left; font-size:12px;line-height:18px; background:#fff url('<?php echo base_url(); ?>images/agenti_pattern_text.png') repeat-x;">
					<? echo "<img src=\"" . base_url() . "images/gallery/$imgbig.jpg\" width=\"451\">"; ?>
			</div>
			
		</div>
		<div id="right">
			<div id="up_gallery" style="background:#fff url('<?php echo base_url(); ?>/images/agenti_up_gallery.png') no-repeat; padding:5px 0 0 0; height:30px;"><h2>IMAGE LIBRARY</h2></div>
			<div id="text_gallery" style="padding:0 10px 0 10px; text-align:left; font-size:12px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x; line-height:18px;">
				<ul>
					<li><a  class="red" href="<?php echo base_url(); ?>index.php/agenti/higres/<? echo $this->uri->segment(3); ?>">Download Hi-Res</a></li>
					<li><a  class="red" href="<?php echo base_url(); ?>index.php/agenti/gallery/">Back to gallery</a></li>
				</ul>
			</div>
		</div>
		
	</div>
		<?php $this->load->view('agenti_footer');?>
</div>

</body>
</html>