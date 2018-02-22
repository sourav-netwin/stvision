<html>
<head>
<title><?=$title?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" />
<style type="text/css">
<!--
.bianco {
	color: #CCCCCC
}
-->
</style>
</head>
<body>
<img src="<?php echo base_url(); ?>images/agenti_header.png" style="margin:10px 0 0 0">
<div id="container">
	<div id="bigbox">
	<?php $this->load->view('agenti_tab');?>
		<div id="left">
			<div class="left_menu" style="margin:28px 0 0 0">
				<ul>
				<li><a class="a" href="<?php echo base_url(); ?>index.php/agenti/gallery">ALL PHOTOS</a></li>
				<li><a class="a" href="<?php echo base_url(); ?>index.php/agenti/gallery_search/college">COLLEGE</a></li>
				<li><a class="a" href="<?php echo base_url(); ?>index.php/agenti/gallery_search/cities">CITIES</a></li>
				<li><a class="a" href="<?php echo base_url(); ?>index.php/agenti/gallery_search/people">STUDENTS</a></li>
                <p><span class="bianco"><strong>Just click</strong> on the Categories <br>
                you require and select the images you prefer.<br>
                Then simply click <br>
                “download” and the image <br>
                will be automatically <br>
                transferred to your computer.</span></p>
				
			</ul>
			</div>
			<img src="http://www.plus-ed.com/apps/images/agent_news_end.png" >
		</div>

		<div id="middle_gallery">
			<div id="up_middle" style="display:block; background:#fff url('<?php echo base_url(); ?>images/agenti_up_middle.png') no-repeat; padding:5px 0 0 0; height:30px;"><h2 style="text-align:left; margin:0 0 0 40px">MEDIA GALLERY</h2>
			</div>
			<div id="text_middle" style="display:block; float:left; width:670px; padding:10px 10px 40px 0px; text-align:left; font-size:12px;line-height:18px; background:#fff url('<?php echo base_url(); ?>images/agenti_pattern_text.png') repeat-x;">
				<?
				foreach ($th as $name=>$list){
										echo "<div class=\"foto\">";
										echo "<a href=\"" . base_url() . "index.php?/agenti/myimage/". $list['id'] . "\"><img style=\"display:block; float:left; width:110px; height:66px;\" src=\"" . base_url() . "images/gallery/". $list['imgthumb'] . ".jpg\">"; 
										echo	 "<span>" . $list['descrizione'] . "</span></a></div>";
										
										}
										
				?>
			</div>
		<div style="display:block; clear:both; background-color:#eee; margin:10px 0 0 0; width:680px;"><?php echo $this->pagination->create_links(); ?></div>	
		</div>
		
	

	</div>
		<?php $this->load->view('agenti_footer');?>
</div>

</body>
</html>