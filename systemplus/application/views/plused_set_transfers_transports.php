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
		<?php 
		if($in_out=="inbound"){
		?>
		$( "li#botransfers ul.sub li#botransfers_1" ).addClass("current");	
		<?php 
		}else{
		?>
		$( "li#botransfers ul.sub li#botransfers_2" ).addClass("current");	
		<?php 
		}
		?>
	});
	var arrdate = new Array();
	var depdate = new Array();
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">Book bus for <?php echo $in_out ?> transfers</h1>
			<form name="allbuses" id="allbuses" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/plusedConfirmTransfersBuses">
			<input type="hidden" name="id_exc_join" id="id_exc_join" value="<?php echo $excursion_id ?>" />			
			<div class="grid_12">
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
									<th style="width:235px;">Flight Info</th>
									<th>Tot Pax</th>									
								</tr>
							</thead>
							<tbody>
							<?php foreach($allTransfers as $aT){
							?>
								<input type="hidden" name="exc_numb[]" value="<?php echo $aT["ptt_id"]?>">
								<tr>
									<td class="center">
										<?php echo $aT["ptt_book_id"]?>
									</td>
									<td class="center">
										<?php echo $aT["agency"]?>
									</td>									
									<td class="center" style="width:235px;"><div style="width:60px;background-color:#ddd;float:left;color:#17549B;"><?php echo date("H:i",strtotime($aT["ptt_dataora"]))?></div><div style="width:60px;background-color:#ccc;float:left;font-weight:bold;color:#333;"><?php echo $aT["ptt_flight"]?></div><div style="width:120px;background-color:#bbb;clear:left;float:left;font-weight:normal;color:#000;"><?php echo $aT["ptt_airport_from"]?> &#x2708; <?php echo $aT["ptt_airport_to"]?></div></td>
									<td class="center"><?php echo $aT["tot_pax"]?></td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="grid_8">
				<div class="box">
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/pin.png">Set Extra Info (please specify pickup place)</h2>
					</div>
					<div class="content" style="margin:8px 4px;">
							<label for="pickup_place">Extra Info</label>
							<?php
							if($in_out=="inbound"){
							?>
							<textarea id="pickup_place" name="pickup_place" style="width:80%;">FROM <?php echo str_replace("to/from","",$airport) ?> TO <?php echo $pickupPlace ?></textarea>					
							<?php
							}else{
							?>
							<textarea id="pickup_place" name="pickup_place" style="width:80%;">FROM <?php echo $pickupPlace ?> TO <?php echo str_replace("to/from","",$airport) ?></textarea>					
							<?php
							}
							?>
					</div>
				</div>
			</div>	
			<div class="grid_4">
				<div class="box">
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/clock-select.png">Select Pickup Time</h2>
					</div>
					<div class="content" style="margin:8px 4px;">
							<label for="pickup_time">Pickup Time</label>
							<input type="text" id="pickup_time" name="pickup_time" value="" style="width:60px;" />					
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
									<th>Bus type / Seats</th>
									<th>Transfer</th>
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
										<?php echo $bb["tra_bus_name"]?> / <?php echo $bb["tra_bus_seat"]?>
									</td>									
									<td><?php echo $bb["exc_excursion"]?></td>
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
								<input type="hidden" name="pppax" id="pppax" value="<?php echo $tot_pax?>" />
						</table>
						<table class="styled" style="border-top:1px solid #ddd;">
							<tfoot>
								<tr>
									<td style="text-align:right;"><button disabled class="button red block" id="bus_all" name="bus_all" class="alt_btn">Confirm bus transportation for selected excursions</button></td>
								</tr>
							</tfoot>
						</table>						
					</div><!-- End of .content -->
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
			<input type="hidden" name="quando_tra" id="quando_tra" value="<?php echo $quando?>" />
			</form>
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
	$("#pricepax").val(((supcost/<?php echo $tot_pax ?>)*1).toFixed(2));
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
	if($("#suppax").val() > 0){
		$('#bus_all').prop("disabled", false);
	}else{
		$('#bus_all').prop("disabled", true);
	}
  }
  $(document).ready(function(){
	var dateT = new Date(<?php echo date("Y",strtotime($aT["ptt_dataora"]))?>,<?php echo date("n",strtotime($aT["ptt_dataora"]))?>,<?php echo date("j",strtotime($aT["ptt_dataora"]))?>,<?php echo date("H",strtotime($aT["ptt_dataora"]))?>,<?php echo date("i",strtotime($aT["ptt_dataora"]))?>,0);
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
    $( "#pickup_time" ).timepicker({timeFormat: "hh:mm"}).timepicker("setTime", dateT);			
  });
  </script>
<?php $this->load->view('plused_footer');?>
