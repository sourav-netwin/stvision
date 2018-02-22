<?php $this->load->view('plused_header');?>
	<!-- The container of the sidebar and content box -->
	<div role="main" id="main" class="container_12 clearfix">
	
		<!-- The blue toolbar stripe -->
		<section class="toolbar">
			<div class="user">
				<div class="avatar">
					<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
					<!-- Evidenziare per icone attenzione <span>3</span> -->
				</div>
				<span><?php echo $this->session->userdata('businessname') ?></span>
				<ul>
				<?php 
                                $bOArray = array(200,300,400,100); // BACKOFFICE USERS ROLE IDS
                                if($this->session->userdata('username') && in_array($this->session->userdata('role'), $bOArray)){
                                    ?>
                                        <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
                                        <li class="line"></li>
                                        <li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
                                    <?php 
                                }elseif($this->session->userdata('role')!=97){ ?>	
					<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
					<li class="line"></li>
                                        <li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
				<?php }else{ ?>
                                        <li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
				<?php } ?>
					
				</ul>
			</div>
		</section><!-- End of .toolbar-->
<?php $this->load->view('plused_sidebar');?>		
	<script>
	$(document).ready(function() {
		$( "li#dashboard" ).addClass("current");
		$( "li#dashboard a" ).addClass("open");		
		$( "li#dashboard ul.sub" ).css('display','block');	
<?php if($this->session->userdata('role')==98){ ?>			
		$(".close").click(function(){
			var arremi = $(this).attr("id").split("_");
			var chiudo = arremi[1];
			$.ajax({
				type: "POST",
				data: "idremi=" + chiudo,
				url: "<?php echo base_url(); ?>index.php/agents/completeReminder"
			});
		});
<?php } ?>	
<?php if($this->session->userdata('ruolo')=="superuser" || $this->session->userdata('ruolo')=="contabile"){ ?>	
	$('.goToDetail').on('click', function(e){
        var diaH = $(window).height()* 0.9;
        e.preventDefault();
		passingData = $(this).attr("id").split("__");
        $('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(http://plus-ed.com/vision_ag/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
            .html($('<iframe/>', {
                'src' : "<?php echo site_url();?>/backoffice/newAvail/"+passingData[1],
                'style' :'width:100%; height:100%;border:none;',
            })).appendTo('body')
            .dialog({
                'title' : 'Bookings detail',
                'width' : '90%',
                'height' : diaH,
                modal: true,
                buttons: [ {
                    text: "Close",
                    click: function() { $( this ).dialog( "close" ); }
                } ]
            });
    });	
<?php } ?>	
	});
	</script>		

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">Plus Vision Dashboard</h1>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/monitor.png" class="icon">Welcome to Plus partner zone</h2>
					</div>
					
					<div class="content">
						<p>We have developed this website to allow you to interact with US as if you were with us in one of our offices. You will have the opportunity to visit our campus round the world by clicking on the agents video , to download materials, photos, en-roll online, review the status of your bookings and payments, all of this at the touch of a button.</p><div class="alert information sticky bottom no-margin"><span class="icon"></span>If you need any <strong>help</strong> just send us a mail at <a href="mailto:agentsupport@plus-ed.com">agentsupport@plus-ed.com</a></div>
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
<?php if($this->session->userdata('role')==98){ ?>										

						<?php
							$adesso = strtotime("now");
							foreach($remindme as $remino){
								$datagiro = strtotime($remino["r_data"]);
								$diffgiro = $datagiro-$adesso;
								if($diffgiro > 0)
									$coloreg = "success";
								if($diffgiro <= 0 and $diffgiro >= -86400)
									$coloreg = "warning";
								if($diffgiro < -86400)
									$coloreg = "error";									
								//echo $coloreg."--".$diffgiro."<br />";
								
								$pieces = explode(" ", $remino["r_data"]);
								//print_r($pieces);
								$piecesdata = explode("-", $pieces[0]);
								$newdt = $piecesdata[2]."/".$piecesdata[1]."/".$piecesdata[0];
								$piecestime = explode(":", $pieces[1]);
								$newti = $piecestime[0].":".$piecestime[1];		
								switch ($remino["r_tipo"]) {
									case 0:
										$imgtipo = "mail";
										break;
									case 1:
										$imgtipo = "telephone-handset";
										break;
									case 2:
										$imgtipo = "skype";
										break;
									case 3:
										$imgtipo = "hand-shake";
										break;
									case 4:
										$imgtipo = "present";
										break;								
								}
						?>
						<div class="alert <?php echo $coloreg?>" style="padding-left:5px;">
							<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/calendar.png">
							<strong><?php echo $newdt?> <?php echo $newti?> - <?php echo $remino["r_agente"]?>:</strong> <?php echo $remino["r_testo"]?>
							<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/<?php echo $imgtipo?>.png" style="float:right;margin-right:105px;">
							<span class="close" id="remi_<?php echo $remino["r_id"]?>">Mark as complete</span>
						</div>
						<?php
							}
						?>

<?php
}
?>					
			</div>
			<?php if($this->session->userdata('ruolo')=="superuser"){ ?> 
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>
							<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/exclamation-red.png" class="icon">Bookings alerts (TO BE CONFIRMED) - All
							<?php /*
							<span style="float:right;">
								<a href="<?php echo base_url(); ?>index.php/backoffice/overviewBookingsNew/tbc">Go to overview</a>
							</span> */ ?>
						</h2>
					</div>
					
					<div class="content">
						<?php 
						$now = time();
						foreach($tbc_bk as $bk){ 
							$your_date = strtotime($bk["data_insert"]);
							$difference = round(($now - $your_date)/86400*-1);
							//$your_date2 = strtotime($book[0]["arrival_date"]);
							//$dayToArrive = round(($now - $your_date2)/86400*-1);
						?>
							<p class="rigaDash"><font <?php if($difference < -3){ ?>style="color:#900;"<?php } ?>><?php echo date("d/m/Y",strtotime($bk["data_insert"])) ?> [<?php echo abs($difference) ?> days]</font><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?><a href="javascript:void(0);" title="View detail" class="goToDetail" id="bkg__<?php echo $bk["id_book"] ?>">View</a></p>
						<?php
						}
						?>
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
			</div>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>
							<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/exclamation-red.png" class="icon">Bookings alerts (ELAPSED - PAYMENT CHECKED) - All
							<?php /*
							<span style="float:right;">
								<a href="<?php echo base_url(); ?>index.php/backoffice/overviewBookingsNew/confirmed">Go to overview</a>
							</span> */ ?>
						</h2>
					</div>
					
					<div class="content">
						<?php 
						$now = time();
						$elapsed_sorted = array_reverse($elapsed_bk, TRUE);
						foreach($elapsed_sorted as $bk){ 
							$your_date = strtotime($bk["data_insert"]);
							$difference = round(($now - $your_date)/86400*-1);
							$your_date2 = strtotime($bk["arrival_date"]);
							$dayToArrive = round(($now - $your_date2)/86400*-1);
							$flag_paid = $bk["flag_paid"];
							//spostare a 20 anziche' 80 finiti i test e, nell'if successivo a 5 anziche' 50
							if($flag_paid==1){
						?>
							<p class="rigaDash"><font style="color:#900;"><?php echo date("d/m/Y",strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?><a href="javascript:void(0);" title="View detail" class="goToDetail" id="bkg__<?php echo $bk["id_book"] ?>">View</a></p>
						<?php
							}
						}
						?>
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
			</div>	
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>
							<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/exclamation-red.png" class="icon">Bookings alerts (ELAPSED) - 70 days from departure (50 days in red)
							<?php /*
							<span style="float:right;">
								<a href="<?php echo base_url(); ?>index.php/backoffice/overviewBookingsNew/confirmed">Go to overview</a>
							</span> */ ?>
						</h2>
					</div>
					
					<div class="content">
						<?php 
						$now = time();
						$elapsed_sorted = array_reverse($elapsed_bk, TRUE);
						foreach($elapsed_sorted as $bk){ 
							$your_date = strtotime($bk["data_insert"]);
							$difference = round(($now - $your_date)/86400*-1);
							$your_date2 = strtotime($bk["arrival_date"]);
							$dayToArrive = round(($now - $your_date2)/86400*-1);
							$flag_paid = $bk["flag_paid"];
							//spostare a 20 anziche' 70 finiti i test e, nell'if successivo a 5 anziche' 50
							if($dayToArrive <=70 && $flag_paid == 0){
						?>
							<p class="rigaDash"><font <?php if($dayToArrive <= 50){ ?>style="color:#900;"<?php } ?>><?php echo date("d/m/Y",strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?><a href="javascript:void(0);" title="View detail" class="goToDetail" id="bkg__<?php echo $bk["id_book"] ?>">View</a></p>
						<?php
							}
						}
						?>
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
			</div>				
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>
							<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/exclamation-red.png" class="icon">Bookings alerts (CONFIRMED - NOT CLEARED FOR DEPARTURE)  - 70 days from departure (40 days in red)
							<?php /*
							<span style="float:right;">
								<a href="<?php echo base_url(); ?>index.php/backoffice/overviewBookingsNew/confirmed">Go to overview</a>
							</span> */ ?>
						</h2>
					</div>
					
					<div class="content">
						<?php 
						$now = time();
						$confirmed_sorted = array_reverse($confirmed_bk, TRUE);
						foreach($confirmed_sorted as $bk){ 
							$your_date = strtotime($bk["data_insert"]);
							$difference = round(($now - $your_date)/86400*-1);
							$your_date2 = strtotime($bk["arrival_date"]);
							$dayToArrive = round(($now - $your_date2)/86400*-1);
							$flag_cfd = $bk["flag_cfd"];
							//spostare a 20 anziche' 70 finiti i test e, nell'if successivo a 5 anziche' 40
							if($dayToArrive <=70 && $flag_cfd == 0){
						?>
							<p class="rigaDash"><font <?php if($dayToArrive <= 40){ ?>style="color:#900;"<?php } ?>><?php echo date("d/m/Y",strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?><a href="javascript:void(0);" title="View detail" class="goToDetail" id="bkg__<?php echo $bk["id_book"] ?>">View</a></p>
						<?php
							}
						}
						?>
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
			</div>				
			<?php } ?>
			<?php if($this->session->userdata('ruolo')=="contabile"){ ?> 
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>
							<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/exclamation-red.png" class="icon">Bookings alerts (ELAPSED - CHECK FOR PAYMENT) - All
							<?php /*
							<span style="float:right;">
								<a href="<?php echo base_url(); ?>index.php/backoffice/overviewBookingsNew/confirmed">Go to overview</a>
							</span> */ ?>
						</h2>
					</div>
					
					<div class="content">
						<?php 
						$now = time();
						$elapsed_sorted = array_reverse($elapsed_bk, TRUE);
						foreach($elapsed_sorted as $bk){ 
							$your_date = strtotime($bk["data_insert"]);
							$difference = round(($now - $your_date)/86400*-1);
							$your_date2 = strtotime($bk["arrival_date"]);
							$dayToArrive = round(($now - $your_date2)/86400*-1);
							$flag_checkpay = $bk["flag_checkpay"];
							$flag_paid = $bk["flag_paid"];
							//spostare a 20 anziche' 80 finiti i test e, nell'if successivo a 5 anziche' 50
							if($flag_checkpay==1 && $flag_paid==0){
						?>
							<p class="rigaDash"><font style="color:#900;"><?php echo date("d/m/Y",strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?><a href="javascript:void(0);" title="View detail" class="goToDetail" id="bkg__<?php echo $bk["id_book"] ?>">View</a></p>
						<?php
							}
						}
						?>
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
			</div>				
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>
							<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/exclamation-red.png" class="icon">Bookings alerts (ACTIVE) - 60 days from departure (45 days in red)
							<?php /*
							<span style="float:right;">
								<a href="<?php echo base_url(); ?>index.php/backoffice/overviewBookingsNew/confirmed">Go to overview</a>
							</span> */ ?>
						</h2>
					</div>
					
					<div class="content">
						<?php 
						$now = time();
						$active_sorted = array_reverse($active_bk, TRUE);
						foreach($active_sorted as $bk){ 
							$your_date = strtotime($bk["data_insert"]);
							$difference = round(($now - $your_date)/86400*-1);
							$your_date2 = strtotime($bk["arrival_date"]);
							$dayToArrive = round(($now - $your_date2)/86400*-1);
							$flag_paid = $bk["flag_paid"];
							//spostare a 20 anziche' 60 finiti i test e, nell'if successivo a 5 anziche' 45
							if($dayToArrive <=60){
						?>
							<p class="rigaDash"><font <?php if($dayToArrive <= 45){ ?>style="color:#900;"<?php } ?>><?php echo date("d/m/Y",strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?><a href="javascript:void(0);" title="View detail" class="goToDetail" id="bkg__<?php echo $bk["id_book"] ?>">View</a></p>
						<?php
							}
						}
						?>
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
			</div>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>
							<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/exclamation-red.png" class="icon">Bookings alerts (CONFIRMED) - 70 days from departure (40 days in red) - <font style="text-decoration:underline;">Green flag</font>: Cleared for Departure / <font style="text-decoration:underline;">White flag</font>: Not yet Cleared
							<?php /*
							<span style="float:right;">
								<a href="<?php echo base_url(); ?>index.php/backoffice/overviewBookingsNew/confirmed">Go to overview</a>
							</span> */ ?>
						</h2>
					</div>
					
					<div class="content">
						<?php 
						$now = time();
						$confirmed_sorted = array_reverse($confirmed_bk, TRUE);
						foreach($confirmed_sorted as $bk){ 
							$your_date = strtotime($bk["data_insert"]);
							$difference = round(($now - $your_date)/86400*-1);
							$your_date2 = strtotime($bk["arrival_date"]);
							$dayToArrive = round(($now - $your_date2)/86400*-1);
							$flag_cfd = $bk["flag_cfd"];
							//spostare a 20 anziche' 70 finiti i test e, nell'if successivo a 5 anziche' 40
							if($dayToArrive <=70){
						?>
							<p class="rigaDash"><font <?php if($dayToArrive <= 40){ ?>style="color:#900;"<?php } ?>><?php echo date("d/m/Y",strtotime($bk["arrival_date"])) ?> [<?php echo abs($dayToArrive) ?> days]</font><img src="http://plus-ed.com/vision_ag/img/icons/packs/fugue/16x16/flag-<?php if($flag_cfd==1){ ?>green<?php }else{ ?>white<?php } ?>.png" class="icon"><b><?php echo $bk["id_year"] ?>_<?php echo $bk["id_book"] ?> | <?php echo $bk["centro"] ?></b> - <?php echo $bk["agency"]["businessname"] ?><a href="javascript:void(0);" title="View detail" class="goToDetail" id="bkg__<?php echo $bk["id_book"] ?>">View</a><em><?php echo $bk["saldoBilancio"] ?></em></p>
						<?php
							}
						}
						?>
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
			</div>	
				
			<?php } ?>
			
			<?php if($this->session->userdata('role')==100){
				?>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>
							<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/ticket.png" class="icon">Ticket alerts  - Newest 20 numbers <span style="color: #FF0000">[<?php echo $openCount ?> Open Tickets]</span> <a style="float: right" href="<?php echo site_url().'/ticketmanagement' ?>" >View all tickets</a>							
						</h2>
					</div>
					<div class="content">
						<?php 
						$now = time();
						$confirmed_sorted = array_reverse($confirmed_bk, TRUE);
						if(!empty($open_tickets)){
							foreach($open_tickets as $ticket){ 
								$openDate = date('d/m/Y', strtotime($ticket['ptc_created_time'])).'['.($ticket['dateDf'] == 0 ? 'Today' : $ticket['dateDf'].' Day(s)' ).']';
								$message = strlen($ticket['ptc_content']) > 100 ? substr($ticket['ptc_content'], 0, 100).'...' : $ticket['ptc_content'];
							?>
								<p class="rigaDash"><font style="color:#900;"><?php echo $openDate ?></font><b><?php echo $ticket['nome_centri'] ? $ticket['nome_centri'].' | '.$ticket['ptc_title'] : 'ALL | ' .$ticket['ptc_title'] ?></b> - <?php echo $message ?></p>
							<?php
								
							}
						}
							
						?>
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
			</div>
			<?php
			} 
			?>
			
<?php if($this->session->userdata('role')!=100 && $this->session->userdata('role')!=200){ 
		if($this->session->userdata('role')!=97){
?>	
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/flag.png" class="icon">How to upload your pax lists</h2>
					</div>
					<div class="content">
						<p><a href="<?php echo base_url(); ?>index.php/agents/insertedBookings" title="Review your bookings"><strong>In the "Booking review" section</strong></a>, you'll find the excel sheet which we ask you to fill for each Group booking with all the details for students and group leaders who will attend our programmes this summer.<br />The information provided is very important to secure all services and well being for all our students. <br /><a href="<?php echo base_url(); ?>downloads/extras/guide_for_upload_list_vision.pdf" target="_blank" title="Guide for upload list"><strong>Download here the brief description</strong></a> of the fields you are asked to fill in and why we need them, we also ask you to follow the instructions on how to fill in the information required.<br />Once you have filled in all the relevant details please forward to <a href="mailto:plus@plus-ed.com">plus@plus-ed.com</a> using the book id as subject.</p><div class="alert warning sticky bottom no-margin"><span class="icon"></span>If you need any <strong>help</strong> just send us a mail at <a href="mailto:agentsupport@plus-ed.com">agentsupport@plus-ed.com</a></div>
					</div>
					
				</div>
			</div>
			<div class="grid_4">
				<div class="box">
				
					<div class="header">
						<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/book--plus.png" class="icon">Enrol</h2>
					</div>
					
					<div class="content">
						<p>Check the availability and make your own booking at any of our destination.</p>
					</div>
					<div class="content center-elements"><p><a class="button" href="<?php echo base_url(); ?>index.php/agents/enrol">Enter</a></p></div>
					
				</div><!-- End of .box -->
			</div>
			<div class="grid_4">
				<div class="box">
				
					<div class="header">
						<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/ui-layered-pane.png" class="icon">Download marketing materials</h2>
					</div>
					
					<div class="content">
						<p>Download brochures, agents manual, price list accommodation factsheet and more.</p>
					</div>
					<div class="content center-elements"><p><a class="button" href="<?php echo base_url(); ?>index.php/agents/mkt_material_pj">Enter</a></p></div>
					
				</div><!-- End of .box -->
			</div>
			<div class="grid_4">
				<div class="box">
				
					<div class="header">
						<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/books-stack.png" class="icon">Review your bookings</h2>
					</div>
					
					<div class="content">
						<p>Review the status of each reservation for all our brands.</p></div><div class="content center-elements"><p><a class="button" href="<?php echo base_url(); ?>index.php/agents/insertedBookings">Enter</a></p></div>
					
				</div><!-- End of .box -->
			</div>
<?php
	}
}
?>			
			
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
