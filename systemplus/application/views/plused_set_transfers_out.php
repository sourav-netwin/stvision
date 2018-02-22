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
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<form style="margin:10px;" id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/setTransfers/<?php echo $in_out ?>" method="post">  
				<h1 class="grid_12 margin-top no-margin-top-phone">Book outbound transfers</h1>
				<div class="grid_6">
					<div class="box">
						<div class="header">
							<h2>Select Campus</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<select name="centri" id="centricampus">
								<option value="">All Campus</option>
								<?php
									 foreach($centri as $key=>$item){?>
								 <option <?if($campus==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?></option>
								<?php 	 }
								?>
							</select> 
						</div>
					</div>
				</div>
				<div class="grid_5">
					<div class="box">
						<div class="header">
							<h2>Select Date</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<?php 
							if($in_out=="inbound"){
							?>
							<label for="when">Arrival day</label>
							<?php
							}else{
							?>
							<label for="when">Departure day</label>
							<?php
							}
							?>
							<input type="text" id="when" name="when" value="<?php echo $when ?>" style="width:80px;" />
						</div>
					</div>
				</div>	
				<div class="grid_1">
						<div class="content" style="margin-top:30px;text-align:center;">
							<input type="button" name="transpmi" id="transpmi" class="cercaid" value="Search" />
						</div>
				</div>	
			</form>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Book <?php echo $in_out ?> transfers</h2>
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
									<th>Campus</th>
									<th>Booking ID</th>
									<th>Agency</th>									
									<th>Departure Date</th>
									<th style="width:235px;">Departure Flight</th>																															
									<th>Pax</th>
									<th>Select</th>
								</tr>
							</thead>
							<?php
							$arrdataw = explode("/",$when);
							//print_r($arrdataw);
							$datagiusta = $arrdataw[2]."-".$arrdataw[1]."-".$arrdataw[0];
							?>
							<form name="alltran" id="alltran" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/setTransfersTransport/<?php echo $in_out ?>/<?php echo $campus ?>/<?php echo $datagiusta ?>">
							<tbody>
							<?php 
							if(count($all_transfers)>0){
							foreach($all_transfers as $exc){
							?>
								<tr>
									<td><?php echo $exc["nome_centri"]?></td>
									<td class="center n_<?php echo $exc["statopre"]?>">
										<span class="idofbook"><?php echo $exc["bookid"]?><?php if($exc["start_end_overnight"]=="start"){ ?><br /><span style="background-color: #FFF;color: #f00;padding: 1px 4px;border-radius: 5px;font-size: 10px;">NO TRNSF OUT (ref. <?php echo $exc["id_ref_overnight"] ?>)</span><?php } ?><br /><font style="color:#f00"><?php echo $exc["totForBook"]?> pax unmatched</font></span>
									</td>
									<td><img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $exc["businesscountry"]?>.png" alt="<?php echo $exc["businesscountry"]?>" title="<?php echo $exc["businesscountry"]?>" /><?php echo $exc["businessname"]?></td>
									<td class="center"><?php echo date("d/m/Y",strtotime($exc["ritorno_data_partenza"]))?></td>
									<td class="center" style="width:235px;"><div style="width:60px;background-color:#ddd;float:left;color:#17549B;"><?php echo date("H:i",strtotime($exc["ritorno_data_partenza"]))?></div><div style="width:60px;background-color:#ccc;float:left;font-weight:bold;color:#333;"><?php echo $exc["ritorno_volo"]?></div><div style="width:120px;background-color:#bbb;clear:left;float:left;font-weight:normal;color:#000;"><?php echo $exc["ritorno_apt_partenza"]?> &#x2708; <?php echo $exc["ritorno_apt_arrivo"]?></div></td>
									<td><?php echo $exc["totnumpax"]?></td>
									<td class="center containcheck"><input <?php if($campus=="" or $exc["ritorno_volo"]=="" or $exc["ritorno_apt_partenza"] == ""){ ?>disabled <?php } ?>type="checkbox" name="transfer[]" value="<?php echo $exc["bookid"]?>_<?php echo date("U",strtotime($exc["ritorno_data_partenza"]))?>_<?php echo $exc["ritorno_apt_partenza"]?>_<?php echo $exc["ritorno_apt_arrivo"]?>_<?php echo $exc["ritorno_volo"]?>_<?php echo $exc["idcentro"]?>_<?php echo $exc["totnumpax"]?>" class="transfer" /></td>
									
								</tr>
							<?php
								}
							}
							?>
							</tbody>
							</form>
						</table>
						<?php 
							if(count($all_transfers)>0){
						?>
						<table class="styled" style="border-top:1px solid #ddd;">
							<tfoot>
								<tr>
									<td style="text-align:right;"><button <?php if($campus==""){ ?>disabled <?php } ?>class="button red block" id="tra_all" name="tra_all" class="alt_btn">Set transportation for selected transfers</button></td>
								</tr>
							</tfoot>
						</table>	
						<?php	
							}
						?>
					</div><!-- End of .content -->
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
		</section><!-- End of #content -->
	</div><!-- End of #main -->
<script>
$(document).ready(function(){
	$('#transpmi').click(function(){
		$('#loading-data').show();
		$('#box_transport').submit();
	});
})
</script>
  <script>
  $(document).ready(function(){
    $( "#when" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      numberOfMonths: 1,
	  dateFormat: "dd/mm/yy"
    });
	$("#tra_all").click(function(){
		$("#alltran").submit();
	});
  });
  </script>
<?php $this->load->view('plused_footer');?>
