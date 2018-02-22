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
	$dataCheckExc = strtotime($plan["pbe_excdate"]);
	$dataCheckToday = strtotime(date("Y-m-d"));
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
							<p>Booking reference: <span class="refstandby"><?php echo $book["exb_id_year"] ?>_<?php echo $book["exb_id_book"] ?></span><span>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /><?php echo $book["businessname"] ?> | <?php echo $book["tot_pax"] ?> pax</span></p>
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
							$contaposti=0;
							$contabus = 1;
							foreach($bus_detail as $bus){
						?>
						<div class="row" style="padding:8px 12px;">
							<p>Bus type <?php echo $contabus?>: <span class="refstandby"><?php echo $bus["tra_cp_name"] ?></span><span> | <?php echo $bus["tra_bus_name"] ?> (<?php echo $bus["tra_bus_seat"] ?> seats)</span></p>
							<p>Cost: <span><?php echo $bus["pbe_qtybus"] ?> x <?php echo $bus["pbe_jnprice"] ?><?php echo $bus["pbe_jncurrency"] ?> = <strong><?php echo number_format($bus["pbe_qtybus"]*$bus["pbe_jnprice"],2,'.','') ?><?php echo $bus["pbe_jncurrency"] ?></span></p>
						</div>	
						<?php
							$contaposti = $contaposti+($bus["pbe_qtybus"]*$bus["tra_bus_seat"]);
							$contabus++;
							}
						$tipoalert = "success";
						$infoalert = $allpax." pax - ".$contaposti." seats on booked bus";
						if($allpax > $contaposti){
							$tipoalert = "error";
							$infoalert = $allpax." pax - ".$contaposti." seats on booked bus - <a href='".base_url()."index.php/backoffice/reviewBusForPlan/".$bus_code."'>Click here</a> to review bus seats";
						}	
						?>
						<div class="alert <?php echo $tipoalert ?>">
							<span class="icon"></span>
							<?php echo $infoalert ?>
						</div>
					</fieldset>		
					<?php if($dataCheckExc > $dataCheckToday){ 
					?>
					<fieldset class="detailsExc">
					<legend>Other groups on campus</legend>
						<?php
							if(count($others)){
								foreach($others as $oth){
							?>
							<div class="row" style="padding:8px 12px;">
								<p>Booking reference: <span class="refstandby"><?php echo $oth["id_year"] ?>_<?php echo $oth["id_book"] ?></span><span>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $oth["businesscountry"]?>.png" alt="<?php echo $oth["businesscountry"]?>" title="<?php echo $oth["businesscountry"]?>" /><?php echo $oth["businessname"] ?> | <?php echo $oth["tot_pax"] ?> pax</span></p>
								<p>Booking dates: <span>from <?php echo date("d/m/Y",strtotime($oth["arrival_date"])) ?> to <?php echo date("d/m/Y",strtotime($oth["departure_date"])) ?></span></p>
								<input type="button" class="blue addGroup" value="Add group <?php echo $oth["id_year"] ?>_<?php echo $oth["id_book"] ?> to excursion code <?php echo $bus_code?>" name="addExc" id="addExc_<?php echo $oth["exb_id"] ?>" />
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
					<?php } ?>
					<fieldset class="detailsExc">
							<legend>Campus Manager excursion review</legend>
									<div class="row" style="padding:8px 12px;">
										<p><label style="width:170px;float:left;">Service completed </label><input type="checkbox" name="service_completed_view" disabled value="yes"<?php if($plan["pbe_cm_done"]==1){ ?> checked="checked" <?php } ?>></p>
									</div>						
									<div class="row" style="padding:8px 12px;">
										<p><label style="width:170px;float:left;">Bus Service not compliant </label><input type="checkbox" name="bus_not_compliant_view" disabled value="yes"<?php if($plan["pbe_cm_ok"]==1){ ?> checked="checked" <?php } ?>></p>
									</div>	
									<div class="row" style="padding:8px 12px;">
										<p><label style="width:170px;float:left;">Excursion/Service Notes </label><textarea disabled style="width:400px;" name="exc_notes_view"><?php echo $plan["pbe_cm_notes"]?></textarea></p>
									</div>						
					</fieldset>	
					<div class="actions">
						<div class="left">
							<a href="<?php echo base_url(); ?>index.php/backoffice/printPDFExc/<?php echo $bus_code?>" target="_blank"><input type="button" class="red" value="Print PDF for Companies" name="printPDFExc" id="printPDFExc" /></a>
						</div>					
						<div class="right">
						<?php if($dataCheckExc > $dataCheckToday){ 
						?>
							<input type="button" class="red" value="Reset" name="resetExc" id="resetExc" />
						<?php
						if($status_ex1=="STANDBY"){
						?>
							<input type="button" value="Confirm" name="confirmExc" id="confirmExc" />
						<?php
						}
						}
						?>
						</div>
					</div><!-- End of .actions -->	
<?php }else{ ?>
			<fieldset class="detailsExc">
					<legend>Bus and companies detail</legend>
						<?php
							$contabus = 1;
							foreach($bus_detail as $bus){
						?>
						<div class="row" style="padding:8px 12px;">
							<p>Bus type <?php echo $contabus?>: <span class="refstandby"><?php echo $bus["tra_cp_name"] ?></span><span> | <?php echo $bus["pbe_qtybus"] ?> x <?php echo $bus["tra_bus_name"] ?> (<?php echo $bus["tra_bus_seat"] ?> seats)</span></p>
						</div>	
						<?php
							$contabus++;
							}
						?>
			</fieldset>
			<?php if($dataCheckExc <= $dataCheckToday){ 
			?>
			<fieldset class="detailsExc">
					<legend>Excursion review</legend>
							<div class="row" style="padding:8px 12px;">
								<p><label style="width:170px;float:left;">Service completed </label><input type="checkbox" name="service_completed" id="service_completed" value="yes"<?php if($plan["pbe_cm_done"]==1){ ?> checked="checked" <?php } ?>></p>
							</div>						
							<div class="row" style="padding:8px 12px;">
								<p><label style="width:170px;float:left;">Bus Service not compliant </label><input type="checkbox" name="bus_not_compliant" id="bus_not_compliant" value="yes"<?php if($plan["pbe_cm_ok"]==1){ ?> checked="checked" <?php } ?>></p>
							</div>	
							<div class="row" style="padding:8px 12px;">
								<p><label style="width:170px;float:left;">Excursion/Service Notes </label><textarea style="width:400px;" name="exc_notes" id="exc_notes"><?php echo $plan["pbe_cm_notes"]?></textarea></p>
							</div>						
			</fieldset>	
					<div class="actions">
						<div class="left"></div>					
						<div class="right">
							<input type="button" class="red" value="Set review for excursion" name="setRevExc" id="setRevExc" />
						</div>
					</div>	
			<?php	
			}
			?>
<?php } ?>					
				</form>
<?php if($this->session->userdata('role')==200){ ?>					
						<form name="revExcForm" id="revExcForm" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/setExcReview/<?php echo $bus_code?>">
							<input type="hidden" name="cm_bus_not_compliant" id="cm_bus_not_compliant" value="" />
							<input type="hidden" name="cm_service_completed" id="cm_service_completed" value="" />
							<input type="hidden" name="cm_exc_notes" id="cm_exc_notes" value="" />
						</form>	
<?php } ?>						
				
				
			</div><!-- End of .grid_12 -->	

		</section><!-- End of #content -->
	</div><!-- End of #main -->

	<script>
	$(document).ready(function() {
		$( "li#boplexcursions" ).addClass("current");
		$( "li#boplexcursions a" ).addClass("open");		
		$( "li#boplexcursions ul.sub" ).css('display','block');	
		$( "li#boplexcursions ul.sub li#boplexcursions_2" ).addClass("current");

		<?php if($this->session->userdata('role')==100){ ?>	
		
		$("#resetExc").click(function(){
			if(confirm("Are you sure you want to reset this excursion plan?")){
				window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busExcReset/<?php echo $bus_code?>");
			}
		});
		$("#confirmExc").click(function(){
			if(confirm("Are you sure you want to confirm this excursion plan?")){
				window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busExcConfirm/<?php echo $bus_code?>");
			}
		});	
		$(".addGroup").click(function(){
			if(confirm("Are you sure you want to add this group to the excursion plan?")){
				var exbId = $(this).attr("id").split("_")[1];
				window.location.replace("<?php echo base_url(); ?>index.php/backoffice/addGroupToBusCode/<?php echo $bus_code?>/"+exbId+"/<?php echo $plan["pbe_excdate"] ?>");
				return false;
			}
		});	

		<?php }else{ ?>
		
		$("#setRevExc").click(function(){
			if(confirm("Are you sure you want to review informations and notes for this excursion plan?")){
				if($("#bus_not_compliant").attr("checked")=="checked"){
					$("#cm_bus_not_compliant").val("1");
				}else{
					$("#cm_bus_not_compliant").val("0");
				}	
				if($("#service_completed").attr("checked")=="checked"){
					$("#cm_service_completed").val("1");
				}else{
					$("#cm_service_completed").val("0");
				}				
				$("#cm_exc_notes").val($("#exc_notes").val());				
				$("#revExcForm").submit();
			}
		});	
		<?php } ?>
		
	});
	</script>	
<?php $this->load->view('plused_footer');?>