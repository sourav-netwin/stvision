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
				<span><?echo $this->session->userdata('businessname') ?></span>
				<ul>
					<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
					<li class="line"></li>
					<li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
				</ul>
			</div>
			<input type="search" data-source="extras/search.php" placeholder="Search..." autocomplete="off" class="tooltip" title="e.g. Canterbury" data-gravity=s>
		</section><!-- End of .toolbar-->	
	
<?php $this->load->view('plused_sidebar');?>		
		
		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">Review Campus day 2 day - <?php echo $campusname?> - <?php echo ucfirst($accomodationname)?> accomodation</h1>
			<div class="grid_6">
				<div class="box">
					<div class="header">
						<h2>Select Campus</h2>
					</div>
					<div class="content">
							<form style="margin:10px;" id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/backoffice/reviewD2D" method="post">  
										<select name="centri" id="centricampus">
										<?php
											 foreach($centri as $key=>$item){
											 echo "<br />--->".$campus."---".$item['id']."<---";
											 ?>
											 <option <?if($campus==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?></option>
										<?php 	 }
										?>
									</select> 
							<input type="hidden" name="accomodation_in" value="<?php echo $accomodation;?>">  
							</form>					
					</div>
				</div>
			</div>
			<div class="grid_6">
				<div class="box">
					<div class="header">
						<h2>Select Accomodation</h2>
					</div>
					<div class="content">
							<form style="margin:10px;" id="box_acco" name="box_acco" action="<?php echo base_url(); ?>index.php/backoffice/reviewD2D" method="post">  
								<select name="accomodation_in" id="accomodation_in">
									<option <?php if($accomodation==1){?>selected <?php }?>value="1">Standard</option>
									<option <?php if($accomodation==2){?>selected <?php }?>value="2">Ensuite</option>
									<option <?php if($accomodation==3){?>selected <?php }?>value="3">Homestay</option>
								</select> 
								<input type="hidden" name="centri" value="<?php echo $campus;?>">
							</form>			
					</div>
				</div>
			</div>				
			<div class="grid_12">
				<div class="container">
					<div class="row">
						<div class="g12">
							<div id="eventCalendarCalendarLine"></div>
							<script>
								$(document).ready(function() {
									$("#eventCalendarCalendarLine").eventCalendar({
										eventsjson: '<?php echo base_url(); ?>json_files/<?php echo $json_name; ?>',
										showDayAsWeeks: false,
										showDescription: true
									});
								});
							</script>
						</div>
					</div>
				</div>
			</div><!-- End of .grid_12 -->	

		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	<script>
	$(document).ready(function() {
		$( "li#bobooking" ).addClass("current");
		$( "li#bobooking a" ).addClass("open");		
		$( "li#bobooking ul.sub" ).css('display','block');	
		$( "li#bobooking ul.sub li#bobooking_3" ).addClass("current");	
		$('#centricampus').change(function(){
			$('#box_campus').submit();
		});		
		$('#accomodation_in').change(function(){
			$('#box_acco').submit();
		});			
	});
	</script>	
	<script src="<?php echo base_url(); ?>js/jquery.eventCalendar.js" type="text/javascript"></script>
<?php $this->load->view('plused_footer');?>
