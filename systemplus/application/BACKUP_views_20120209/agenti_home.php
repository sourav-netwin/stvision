<html>
<head>
<title><?php echo $title; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
</head>
<body>
	<img src="<?php echo base_url(); ?>images/agenti_header.png" style="margin:10px 0 0 0">
	<div id="container">

		<div id="bigbox">
			<?php $this->load->view('agenti_tab');?>
				<div class="content_box">
					<div id="box_big" style="background:#fff url('<?php echo base_url(); ?>images/agents_enrol.png') no-repeat;">
						<a style="color:#fff;" href="<?php echo base_url(); ?>index.php/agenti/enrol"><h4>Check the availability and make your own booking at any of our destination.</h4>
						<p>ENTER</p>
                                                </a>
                                
				  </div>		
					<div id="box_big" style="background:#fff url('<?php echo base_url(); ?>images/agents_marketing1.png') no-repeat;">
						<a style="color:#fff;" href="http://www.plus-ed.com/apps/index.php/agenti/marketing"><h4>Download Agents manual , price list <br/> accommodation fact <br/>sheet and  images.<br/>presentations and <br/>Image.</h4>
						<p>ENTER</p>
                                                </a>					</div>	
				<div id="box_big" style="background:#fff url('<?php echo base_url(); ?>images/agents_booking.png') no-repeat;">
						<a style="color:#fff;" href="<?php echo base_url(); ?>index.php/agenti/search_by_agency"><h4>Review the status  of each reservation for all our  brands.</h4>
						<p>ENTER</p>
                                                </a>
				  </div>		
					<div id="box_big" style="background:#fff url('<?php echo base_url(); ?>images/agents_mobile.png') no-repeat;">
						<h3 style="color:#fff;">IN PLUS PATNER ZONE!</h3>
						<h4 style="color:#2d211a">We have developed this website to allow you to interact with US as if you were with us in one of our offices. You will have the opportunity to visit our 36 campus round the world by clicking on the agents video , to download materials ,photos , en-roll online , review the status of your bookings and payments, all of this at the touch of a button.<br/><br/>
						If you need any help just send us a mail at<a class="red" href="mailto:agentsupport@plus-ed.com"> agentsupport@plus-ed.com</a> </h4>
						
				  </div>
				</div>
				<div id="homenews">
				<strong>NEWS</strong><br/><br/>
				<strong>3rd JANUARY</strong><br/>
				New UK Programme 2011: PLUS ACADEMY in Bedford & Leicester<br/><br/>
				<hr>
				<strong>5th JANUARY</strong><br/>
				Opening the first PLUS Eco Campus in Florida<br/><br/>
				<hr>
				<strong>10th JANUARY</strong><br/>
				PLUS opens a new campus on the US West Coast: San Franscisco<br/><br/>
				<hr>
				<strong>17th JANUARY</strong><br/>
				PLUS opened Recruitment for 2011, selecting Summer Staff from some of the best UK Universities.<br/><br/>
				<hr>
				<strong>18th JANUARY</strong><br/>
				PLUS launches its fourth campus in London: Greenwich <br/><br/>
				</div>
	</div>
	<?php $this->load->view('agenti_footer');?>
</div>

</body>
</html>