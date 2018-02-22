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
<?php
	$plan = $plan_detail[0];
	$status_ex1 = $status_ex[0];
	$statook="CONFIRMED";
	$coloreok="#00aa00";
	if($status_ex1=="STANDBY"){
		$statook="STAND BY";
		$coloreok="#dd0000";	
	}
	if($plan["exc_type"]=="planned"){
		$tipoe = "included";
	}else{
		$tipoe = "extra";	
	}
?>
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<form action="" name="excdetail" id="excdetail" class="grid12" method="POST">
					<fieldset class="detailsExc">
					<legend><?php echo ucfirst($tipoe) ?> excursion detail - Code: <?php echo $bus_code?><span style="float:right;color:<?php echo $coloreok ?>;"><?php echo $statook ?></span></legend>
						<div class="row" style="padding:8px 12px;">
							<h1 class="evidence"><?php echo $plan["exc_excursion"] ?> - <em><?php echo ucfirst($plan["exc_length"]) ?></em><font><?php echo ucfirst($tipoe) ?> excursion</font></h1>
							<p>Campus: <span><?php echo $plan["nome_centri"] ?></span></p>
							<p>Date: <span class="refstandby"><?php echo date("d/m/Y",strtotime($plan["pbe_excdate"])) ?></span></p>
							<p>Pickup place @ time: <span><?php echo $plan["pbe_pickupplace"] ?> @ </span><span class="refstandby"><?php echo date("H:i",strtotime($plan["pbe_hpickup"])) ?></span></p>
							<p>Return time: @ <span><?php echo date("H:i",strtotime($plan["pbe_hreturn"])) ?></span></p>
							<p>Pax Number: <span><?php echo $allpax ?></span></p>	
						</div>	
					</fieldset>
					<fieldset class="detailsExc">
					<legend>Bookings detail</legend>
						<?php
							foreach($bkg_detail as $book){
						?>
						<div class="row" style="padding:8px 12px;">
							<p>Booking reference: <span class="refstandby"><?php echo $book["pte_book_id"] ?></span><span>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /><?php echo $book["businessname"] ?> | <?php echo $book["pte_tot_pax"] ?> pax</span></p>
							<p>Booking dates: <span>from <?php echo date("d/m/Y",strtotime($book["arrival_date"])) ?> to <?php echo date("d/m/Y",strtotime($book["departure_date"])) ?></span></p>
						</div>	
						<?php
							}
						?>
					</fieldset>		
					<?php if($this->session->userdata('role')==100){ ?>
					<fieldset class="detailsExc">
					<legend>Bus and companies detail</legend>
						<?php
							$contabus = 1;
							foreach($bus_detail as $bus){
						?>
						<div class="row" style="padding:8px 12px;">
							<p>Bus type <?php echo $contabus?>: <span class="refstandby"><?php echo $bus["tra_cp_name"] ?></span><span> | <?php echo $bus["tra_bus_name"] ?> (<?php echo $bus["tra_bus_seat"] ?> seats)</span></p>
							<p>Cost: <span><?php echo $bus["pbe_qtybus"] ?> x <?php echo $bus["pbe_jnprice"] ?><?php echo $bus["pbe_jncurrency"] ?> = <strong><?php echo number_format($bus["pbe_qtybus"]*$bus["pbe_jnprice"],2,'.','') ?><?php echo $bus["pbe_jncurrency"] ?></span></p>
						</div>	
						<?php
							$contabus++;
							}
						?>
					</fieldset>	
					<fieldset class="detailsExc">
					<legend>Other groups on campus</legend>
						<?php
							if(count($others)){
								foreach($others as $oth){
							?>
							<div class="row" style="padding:8px 12px;">
								<p>Booking reference: <span class="refstandby"><?php echo $oth["id_year"] ?>_<?php echo $oth["id_book"] ?></span><span>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $oth["businesscountry"]?>.png" alt="<?php echo $oth["businesscountry"]?>" title="<?php echo $oth["businesscountry"]?>" /><?php echo $oth["businessname"] ?> | <?php echo $oth["tot_pax"] ?> pax</span></p>
								<p>Booking dates: <span>from <?php echo date("d/m/Y",strtotime($oth["arrival_date"])) ?> to <?php echo date("d/m/Y",strtotime($oth["departure_date"])) ?></span></p>
								<input type="button" class="blue bookForGroup" value="Book this excursion for group <?php echo $oth["id_year"] ?>_<?php echo $oth["id_book"] ?>" name="bookExc" id="bookExc_<?php echo $plan["pbe_jnidexc"] ?>_<?php echo $oth["id_book"] ?>_<?php echo $bus_code?>" />
							</div>	
							<?php
								}
							}else{
							?>
							<div class="row" style="padding:8px 12px;">
								<p>No booking on campus matching the selected excursion!</p>
							</div>								
							
							<?php
							}
						?>
					</fieldset>						
					<div class="actions">
						<div class="left">
							<a href="<?php echo base_url(); ?>index.php/backoffice/printPDFAllExc/<?php echo $bus_code?>" target="_blank"><input type="button" class="red" value="Print PDF for Companies" name="printPDFExc" id="printPDFExc" /></a>
						</div>					
						<div class="right">
							<input type="button" class="red" value="Reset" name="resetExc" id="resetExc" />
						<?php
						if($status_ex1=="STANDBY"){
						?>
							<input type="button" value="Confirm" name="confirmExc" id="confirmExc" />
						<?php
						}
						?>
						</div>
					</div><!-- End of .actions -->
					<?php } ?>
				</form>
			</div><!-- End of .grid_12 -->	

		</section><!-- End of #content -->
		
	</div><!-- End of #main -->

	<script>
	$(document).ready(function() {
		$( "li#boexcursions" ).addClass("current");
		$( "li#boexcursions a" ).addClass("open");		
		$( "li#boexcursions ul.sub" ).css('display','block');	
		$( "li#boexcursions ul.sub li#boexcursions" ).addClass("current");		
		$("#resetExc").click(function(){
			if(confirm("Are you sure you want to reset this excursion plan?")){
				window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busAllExcReset/<?php echo $bus_code?>/<?php echo $tipoe ?>");
			}
		});
		$("#confirmExc").click(function(){
			if(confirm("Are you sure you want to confirm this excursion plan?")){
				window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busAllExcConfirm/<?php echo $bus_code?>");
			}
		});		
		$(".bookForGroup").click(function(){
			if(confirm("Are you sure you want to book this excursion for the selected group?")){
				window.location.replace("<?php echo base_url(); ?>index.php/backoffice/bookExtraExcursionForGroup/"+$(this).attr("id"));
			}
		});		
	});
	</script>	
<?php $this->load->view('plused_footer');?>