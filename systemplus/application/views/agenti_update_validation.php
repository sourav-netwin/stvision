<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title><?php echo $title; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/agenti.css" media="screen" /> 
<style type="text/css">
<!--
form, label {
	padding:0;
	margin:0;
	color: #999;
	clear:both;
	text-align:left;;
}
select{
	display:block;
	clear:both;
}


-->
</style>
</head>
<body>

<img src="<?php echo base_url(); ?>images/agenti_header.png" style="margin:10px 0 0 0">
<div id="container" >
	<div id="bigbox" >	
	<?php $this->load->view('agenti_tab');?>
		<div id="left" >
                    
			<div class="left_menu" >
				<?php $this->load->view('agenti_left_enrol');?>
			</div>
                    <img src="<?php echo base_url(); ?>images/agent_news_end.png" >
                  </div>

		<div id="middle" >
      
            <fieldset class="confirm">
                    <h4 class="msg_confirm">The system has been uploaded</h4>
                       <p>To add a new group booking click <a href="<?php echo base_url(); ?>index.php/agenti/enrol" class="confirm_link">new booking form</a></p>
                       <p>To review all modify any bookings uploaded click <a href="<?php echo base_url(); ?>index.php/agenti/search_by_agency" class="confirm_link">your booking</a></p>
             </fieldset>  
		</div>
		</div>

                     		
		<?php $this->load->view('agenti_footer');?>

</div>
    <!--?php   
        }
      ?-->
</body>
</html>