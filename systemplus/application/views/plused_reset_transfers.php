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
		</section><!-- End of .toolbar-->
<?php $this->load->view('plused_sidebar');?>		
	<script>
	$(document).ready(function() {
		$( "li#botransfers" ).addClass("current");
		$( "li#botransfers a" ).addClass("open");		
		$( "li#botransfers ul.sub" ).css('display','block');	
		$( "li#botransfers ul.sub li#botransfers_5" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">Lost and found transfers</h1>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Lost and found transfers</h2>
					</div>
		
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="styled"> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Transfer Date</th>
									<th>Campus</th>
									<th>Type</th>
									<th>Airport</th>
									<th>Flight(s)<br />N. pax</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($losttransfers as $exc){				
							?>
								<tr>
									<td class="center"><?php echo date("d/m/Y",strtotime($exc["ptt_excursion_date"]))?></td>
									<td class="center"><span class="idofbook"><?php echo $exc["nome_centri"]?></span></td>	
									<td class="center">
									<?php 
										if($exc["ptt_type"]=="inbound"){ 
									?>
										<font style="color:#009900;font-weight:bold;">INBOUND</font>
									<?php
										}
									?>									
									<?php 
										if($exc["ptt_type"]=="outbound"){ 
									?>
										<font style="color:#990000;font-weight:bold;">OUTBOUND</font>
									<?php
										}
									?>	
									</td>									
									<?php 
										if($exc["ptt_type"]=="inbound"){ 
									?>
										<td class="center"><?php echo $exc["ptt_airport_to"]?></td>
									<?php
										}else{
									?>
										<td class="center"><?php echo $exc["ptt_airport_from"]?></td>
									<?php
										}
									?>
									<td class="center neretto"><em><?php echo $exc["ptt_flight"]?></em><br /><?php echo $exc["allpax"]?> pax</td>									
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
						<div class="actions">				
							<div class="right">
								<input type="button" class="red" value="Reset Transfers" name="resetTra" id="resetTra" />
							</div>
						</div>						
					</div>
				</div>
			</div>
		</section>
	</div>
  <script>
  $(document).ready(function(){
    $("#resetTra").click(function(){
		if(confirm("Are you sure you want to reset all the lost transfers?")){
			window.location.replace("<?php echo base_url(); ?>index.php/backoffice/actionResetLostTrasfers/");
		}else{
			return void(0);
		}
	});
	
  });
  </script>
<?php $this->load->view('plused_footer');?>
