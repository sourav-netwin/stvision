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
		<div id="left">
			<div class="left_menu" >
				<ul>
				<li><a class="a" href="marketingsummer">PLUS JUNIOR</a></li>
				<li><a class="a" href="#">PLUS EDUCATIONAL</a></li>
				<li><a class="a" href="#">PLUS UNIVERSITY</a></li>
				<li><a class="a" href="#">PLUS HIGH SCHOOL</a></li>
				<br/><br/>
				<li><a class="a" href="#">VISA</a></li>
				<li><a class="a" href="#">PAYMENTS</a></li>
				</ul>
			</div>
			<img src="../../images/agent_news_end.png" >		
		</div>

		<div id="middle">
			<div id="up_middle" style="background:#fff url('../../images/agenti_up_middle.png') no-repeat; margin:0 0 0 0px; padding:5px 0 0 0; height:30px;"><h2>DOWNLOAD AND PRINTED MATERIAL</h2>
			</div>
			<div id="text_middle" style="padding:10px 10px 40px 10px;text-align:left; font-size:12px;line-height:18px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x;">
			<img src="../../images/cover_gallery2.png" style="float:left;">In this section you can find materials you might want to download or order in a printed version.<br>
			We have divided materials by brand. You will find brochures and prospectuses with application forms, fees, agent manuals, pre-arrival information, flyers, etc.<br> <br/>
			</div>
			<div id="up_middle" style="background:#fff url('../../images/agenti_up_middle.png') no-repeat; margin:0 0 0 0px; padding:5px 0 0 0; height:30px;"><h2>ACCOMMODATION FACTSHEETS</h2>
			</div>
			<div id="text_middle" style="padding:10px;text-align:left; font-size:12px;line-height:18px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x;">
			<img src="../../images/facsheet.png" style="float:left;">We have prepared a selected list of information for all our locations around the world, providing you with a detailed list of amenities, accommodation facilities, activities and excursions for each of our Centres in the UK, Ireland, Malta, Canada and North America.<br/>
			This will give you access to a wide range of information to help you choose the best package tailored to your own need.<br/>
			<strong>Just click on the destination .......! </strong> 

			</div>

		</div>

		<div id="right">
			<div id="up_gallery" style="background:#fff url('../../images/agenti_up_gallery.png') no-repeat; padding:5px 0 0 0; height:30px;"><h2>IMAGE GALLERY</h2></div>
			<div id="text_gallery" style="padding:0 10px 0 10px; text-align:left; font-size:12px; background:#fff url('../../images/agenti_pattern_text.png') repeat-x; line-height:18px;">
			<img src="../../images/gallery_general.png" style="margin:0 0 0 30px; text-align:center;"><br clear="all"><h4>Welcome to PLUS IMAGE GALLERY!</h4>
			<p>You can find a broad range of images of all our centres, cities, facilities, and students in our Image Library.
			This will be the ideal tool for choosing the best photos to prepare your own brochure and marketing material.
			How does it work? : Just click on the Categories you require and select the images you prefer. Then simply click “download” and the image will be automatically transferred to your computer. </p>
			<p><a href="http://www.plus-ed.com/apps/index.php/agenti/gallery">Image Gallery</a></p>
			<br> 
			  
			  </p>
			</div>

		</div>
	</div>
		<?php $this->load->view('agenti_footer');?>
</div>

</body>
</html>