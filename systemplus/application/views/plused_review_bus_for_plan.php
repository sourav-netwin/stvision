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
	<script>
	$(document).ready(function() {
		$( "li#boplexcursions" ).addClass("current");
		$( "li#boplexcursions a" ).addClass("open");		
		$( "li#boplexcursions ul.sub" ).css('display','block');	
		$( "li#boplexcursions ul.sub li#boplexcursions_1" ).addClass("current");	
	});
	var arrdate = new Array();
	var depdate = new Array();
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<form name="allbuses" id="allbuses" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/plusedConfirmReviewBuses/<?php echo $bus_code?>">
			
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
			
			
				<div class="box">
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Bookings review</h2>
					</div>
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="styled" data-table-tools='{"display":false}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>ID Book</th>
									<th>Agency</th>
									<th>Arrival Date</th>
									<th>Departure Date</th>
									<th style="text-align:right;">Tot Pax</th>									
								</tr>
							</thead>
							<tbody>
							<?php foreach($bkg_detail as $exs){
							?>
								<input type="hidden" name="exc_numb[]" value="<?php echo $exs["exb_id"]?>">
								<tr>
									<td>
										<?php echo $exs["exb_id_year"]?>_<?php echo $exs["exb_id_book"]?>
									</td>
									<td>
										<?php echo $exs["businessname"]?>
									</td>									
									<td class="center"><?php echo date("d/m/Y",strtotime($exs["arrival_date"]))?></td>
									<td class="center"><?php echo date("d/m/Y",strtotime($exs["departure_date"]))?></td>
									<td style="text-align:right;"><?php echo $exs["tot_pax"]?></td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>				
			<div class="grid_12">
				<div class="box">
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/train-metro.png">Bus review and selection</h2>
					</div>
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="styled" data-table-tools='{"display":false}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Company</th>
									<th>Bus type</th>
									<th>Seats</th>
									<th style="text-align:right;">Cost</th>									
									<th>Select</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($bus as $bb){
							?>
								<tr>
									<td>
										<?php echo $bb["tra_cp_name"]?>
									</td>
									<td>
										<?php echo $bb["tra_bus_name"]?>
									</td>									
									<td class="center"><?php echo $bb["tra_bus_seat"]?></td>
									<td style="text-align:right;"><?php echo $bb["jn_price"]?> <?php echo $bb["jn_currency"]?></td>
									<td class="center containcheck">
										<select class="bus_num" name="bus_<?php echo $bb["jn_id_bus"] ?>" id="bus_<?php echo $bb["jn_id_bus"] ?>">
											<option value="0">-</option>
											<option value="1">1 bus</option>
											<option value="2">2 buses</option>
											<option value="3">3 buses</option>
											<option value="4">4 buses</option>
											<option value="5">5 buses</option>
										</select>
									</td>
									<input type="hidden" name="currency_<?php echo $bb["jn_id_bus"] ?>" id="currency_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["jn_currency"]?>" />
									<input type="hidden" name="cost_<?php echo $bb["jn_id_bus"] ?>" id="cost_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["jn_price"]?>" />
									<input type="hidden" class="tcost" name="totcost_<?php echo $bb["jn_id_bus"] ?>" id="totcost_<?php echo $bb["jn_id_bus"] ?>" value="0" />
									<input type="hidden" name="pax_<?php echo $bb["jn_id_bus"] ?>" id="pax_<?php echo $bb["jn_id_bus"] ?>" value="<?php echo $bb["tra_bus_seat"]?>" />
									<input type="hidden" class="tpax" name="totpax_<?php echo $bb["jn_id_bus"] ?>" id="totpax_<?php echo $bb["jn_id_bus"] ?>" value="0" />									
								</tr>
							<?php
								}
							?>
								<tr>
									<td colspan="2">&nbsp;</td>
									<td class="center"><input style="text-align:center;" type="text" readonly value="0" name="suppax" id="suppax" /></td>
									<td style="text-align:right;"><input style="text-align:right;" type="text" readonly value="0" name="supcost" id="supcost" /> <?php echo $bb["jn_currency"]?></td>
									<td></td>
								</tr>	
								<tr>
									<td colspan="2">&nbsp;</td>
									<td class="center"><input style="text-align:center;border:none;box-shadow:none;background-color:transparent;width:150px;" type="text" readonly value="" name="exppax" id="exppax" /></td>
									<td colspan="2"><input style="text-align:right;border:none;box-shadow:none;background-color:transparent;width:150px;color:#5E6267;padding-right:0;" type="text" readonly value="" name="pricepax" id="pricepax" /> <?php echo $bb["jn_currency"]?> @pax</td>
								</tr>									
							</tbody>
								<input type="hidden" name="pppax" id="pppax" value="<?php echo $allpax?>" />
						</table>
						<table class="styled" style="border-top:1px solid #ddd;">
							<tfoot>
								<tr>
									<td style="text-align:right;"><button class="button red block" id="bus_all" name="bus_all" class="alt_btn">Confirm bus review for excursion plan detail - Code: <?php echo $bus_code?></button></td>
								</tr>
							</tfoot>
						</table>						
					</div><!-- End of .content -->
				</div><!-- End of .box -->
				<input type="hidden" name="id_exc_join" id="id_exc_join" value="<?php echo $plan["pbe_jnidexc"] ?>" />
				<input type="hidden" name="pickup_time" id="pickup_time" value="<?php echo $plan["pbe_hpickup"] ?>" />
				<input type="hidden" name="return_hour" id="return_hour" value="<?php echo $plan["pbe_hreturn"] ?>" />
				<input type="hidden" name="pickup_place" id="pickup_place" value="<?php echo $plan["pbe_pickupplace"] ?>" />
				<input type="hidden" name="s_exc_date" id="s_exc_date" value="<?php echo $plan["pbe_excdate"] ?>" />
				</form>
			</div><!-- End of .grid_12 -->
		</section><!-- End of #content -->
	</div><!-- End of #main -->
  <script>
  function aggpaxcost(){
	var supcost = 0;
	var suppax = 0;
	$(".tcost").each(function(){
		supcost += $(this).val()*1;
	});
	$(".tpax").each(function(){
		suppax += $(this).val()*1;
	});	
	$("#supcost").val(supcost.toFixed(2));
	$("#suppax").val(suppax);
	$("#pricepax").val(((supcost/<?php echo $allpax ?>)*1).toFixed(2));
	var diff = $("#suppax").val() - $("#pppax").val();
	if(diff < 0){
		$("#suppax").css("background-color","#880000");
		$("#suppax").css("color","#ffffff");	
		$("#exppax").val(diff+" pax remaining!");		
	}
	if(diff >= 0 && diff <= 5){
		$("#suppax").css("background-color","#008800");
		$("#suppax").css("color","#ffffff");	
		$("#exppax").val("Just "+diff+" extra seats selected!");			
	}
	if(diff > 5){
		$("#suppax").css("background-color","#d14000");
		$("#suppax").css("color","#ffffff");	
		$("#exppax").val(diff+" extra seats selected!");		
	}

  }
  $(document).ready(function(){
	aggpaxcost();
	$(".bus_num").change(function(){
		var arrclassi = $(this).attr("id").split("_");
		var arrid = "#cost_"+arrclassi[1];
		var totid = "#totcost_"+arrclassi[1];
		var arrpx = "#pax_"+arrclassi[1];
		var totpx = "#totpax_"+arrclassi[1];
		$(totid).val($(arrid).val()*$(this).val());
		$(totpx).val($(arrpx).val()*$(this).val());
		aggpaxcost();
	});	
  });
  </script>
<?php $this->load->view('plused_footer');?>
