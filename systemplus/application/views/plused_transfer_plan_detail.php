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
	$tipoe = "transfer";
?>
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<form action="" name="excdetail" id="excdetail" class="grid12" method="POST">
					<fieldset class="detailsExc">
					<legend><?php echo ucfirst($tipo_ex)?> transfer detail - Code: <?php echo $bus_code?><span style="float:right;color:<?php echo $coloreok ?>;"><?php echo $statook ?></span></legend>
						<div class="row" style="padding:8px 12px;">
							<?php
							if($tipo_ex=="inbound"){
							?>
							<h1 class="evidence">Transfer inbound from <?php echo str_replace("to/from","",$plan["exc_excursion"]) ?> to <?php echo $plan["nome_centri"] ?><font><?php echo ucfirst($tipoe) ?></font></h1>
							<p>From airport: <span><?php echo str_replace("to/from","",$plan["exc_excursion"]) ?></span></p>
							<p>To campus: <span><?php echo $plan["nome_centri"] ?></span></p>
							<?php
							}else{
							?>
							<h1 class="evidence">Transfer outbound from <?php echo $plan["nome_centri"] ?> to <?php echo str_replace("to/from","",$plan["exc_excursion"]) ?><font><?php echo ucfirst($tipoe) ?></font></h1>
							<p>From campus: <span><?php echo $plan["nome_centri"] ?></span></p>
							<p>To airport: <span><?php echo str_replace("to/from","",$plan["exc_excursion"]) ?></span></p>							
							<?php
							}
							?>
							<p>Date: <span class="refstandby"><?php echo date("d/m/Y",strtotime($plan["pbe_excdate"])) ?></span></p>
							<p>Extra Info: <span><?php echo $plan["pbe_pickupplace"] ?></span></p>
							<?php
							if(date("H:i",strtotime($plan["pbe_hpickup"]))!="00:00"){
							?>							
							<p>Pickup time: <span class="refstandby"><?php echo date("H:i",strtotime($plan["pbe_hpickup"])) ?></span></p>
							<?php
							}
							?>							
							<?php
							if($ruolo==100){
							?>
							<p>Pax Number: <span><?php echo $allpax ?><?php if($allpax != $effettivi){ ?><font style="color:#f00;font-weight:bold;"> (<?php echo $effettivi ?> actual pax)</font><?php } ?></span><a style="float:right;" href="javascript:void(0);" class="viewEntirePaxList"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/edit-list-order.png"><span style="float:right;width:100px;text-align:center;">View pax list</span></a></p>
							<?php
							}else{
							?>
							<p>Pax Number: <span><?php echo $effettivi ?><a style="float:right;" href="javascript:void(0);" class="viewEntirePaxList"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/edit-list-order.png"></span><span style="float:right;width:100px;text-align:center;">View pax list</span></a></p>
							<?php
							}
							?>							
						</div>	
					</fieldset>
					<fieldset class="detailsExc">
					<legend>Transfer detail</legend>
						<?php
							//print_r($bkg_detail);
							foreach($bkg_detail as $book){
						?>
						<div class="row" style="padding:8px 12px;">
							<?php
							if($ruolo==100){
							?>						
							<p>Booking reference: <span><?php echo $book["ptt_book_id"] ?>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /><?php echo $book["businessname"] ?> | <?php echo $book["ptt_tot_pax"] ?> pax <?php if($book["realpax"] != $book["ptt_tot_pax"]){ ?><font style="font-weight:bold;color:red;">(<?php echo $book["realpax"] ?> actual pax)</font><?php } ?></span></p>
							<?php
							}else{
							?>
							<p>Booking reference: <span><?php echo $book["ptt_book_id"] ?>  |  <img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $book["businesscountry"]?>.png" alt="<?php echo $book["businesscountry"]?>" title="<?php echo $book["businesscountry"]?>" /><?php echo $book["businessname"] ?> | <?php echo $book["realpax"] ?> pax </span></p>
							<?php
							}
							?>							
							<p>Flight Detail: <span><?php echo $book["ptt_flight"] ?>@</span><span class="refstandby"><?php echo date("H:i",strtotime($book["ptt_dataora"])) ?></span> | <?php echo $book["ptt_airport_from"] ?> &#x2708; <?php echo $book["ptt_airport_to"] ?></span></p>
						</div>	
						<?php
							}
						?>
					</fieldset>	

					<fieldset class="detailsExc">
					<legend>Bus and companies detail</legend>
						<?php
							$contabus = 1;
							foreach($bus_detail as $bus){
						?>
						<div class="row" style="padding:8px 12px;">
							<p>Bus type <?php echo $contabus?>: <span class="refstandby"><?php echo $bus["tra_cp_name"] ?></span><span> | <?php echo $bus["pbe_qtybus"] ?> x <?php echo $bus["tra_bus_name"] ?> (<?php echo $bus["tra_bus_seat"] ?> seats)</span></p>
							<?php
								if($ruolo==100){
							?>
							<p>Cost: <span><?php echo $bus["pbe_qtybus"] ?> x <?php echo $bus["pbe_jnprice"] ?><?php echo $bus["pbe_jncurrency"] ?> = <strong><?php echo number_format($bus["pbe_qtybus"]*$bus["pbe_jnprice"],2,'.','') ?><?php echo $bus["pbe_jncurrency"] ?></strong></span></p>
							<?php
							}
							?>
						</div>	
						<?php
							$contabus++;
							}
						?>
					</fieldset>		
					<?php
					if($ruolo==100){
					?>					
					<div class="actions">
						<div class="left">
							<a href="<?php echo base_url(); ?>index.php/backoffice/printPDFTra/<?php echo $bus_code?>" target="_blank"><input type="button" class="red" value="Print PDF for Companies" name="printPDFTra" id="printPDFTra" /></a>
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
					<?php
					}
					?>
				</form>
			</div><!-- End of .grid_12 -->	

		</section><!-- End of #content -->		
		<div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_paxlist" title="Pax List | Bus code <?php echo $bus_code?> (Please set orientation to LANDSCAPE before print!)" class="windia"></div>	

	</div><!-- End of #main -->

	<script src="<?php echo base_url(); ?>js/jquery.printElement.min.js"></script>	
	<script>
	$(document).ready(function() {
		$( "li#botransfers" ).addClass("current");
		$( "li#botransfers a" ).addClass("open");		
		$( "li#botransfers ul.sub" ).css('display','block');	
		$( "li#botransfers ul.sub li#botransfers_3" ).addClass("current");			
		
		$( ".windia" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				},{
					text: "Print",
					click: function() { $(".windia table").printElement(); }
				}],
				height : 500,
				width: 800
		});		
		
		$("#resetExc").click(function(){
			if(confirm("Are you sure you want to reset this transfer plan?")){
				window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busTraReset/<?php echo $bus_code?>");
			}
		});
		$("#confirmExc").click(function(){
			if(confirm("Are you sure you want to confirm this transfer plan?")){
				window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busTraConfirm/<?php echo $bus_code?>");
			}
		});		
		$(".viewEntirePaxList").click(function(){
				$("#dialog_modal_paxlist").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				$( "#dialog_modal_paxlist" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_getTransfersPaxFromBusCode/<?php echo $bus_code?>/<?php echo $tipo_ex?>');
				return false;			
		});			
	
	});
	</script>	
<?php $this->load->view('plused_footer');?>