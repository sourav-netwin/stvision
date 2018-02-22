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
		$( "li#boexcursions" ).addClass("current");
		$( "li#boexcursions a" ).addClass("open");		
		$( "li#boexcursions ul.sub" ).css('display','block');	
		$( "li#boexcursions ul.sub li#boexcursions_1" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<form style="margin:10px;" id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/setUnplannedAllExcursions" method="post">  
				<h1 class="grid_12 margin-top no-margin-top-phone">Book excursions</h1>
				<div class="grid_5">
					<div class="box">
						<div class="header">
							<h2>Select Campus</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<select name="centri" id="centricampus">
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
							<h2>Select Excursion Type</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<select name="tipo" id="tipo">
								<?php /* <option <?php if($tipo=="planned"){?>selected <?php }?>value="planned">Included</option> */ ?>
								<option <?php if($tipo=="extra"){?>selected <?php }?>value="extra">Extra</option>
							</select> 		
						</div>
					</div>
				</div>	
				<div class="grid_2">
						<div class="content" style="margin-top:30px;text-align:center;">
							<input type="button" name="transpmi" id="transpmi" class="cercaid" value="Search" />
						</div>
				</div>	
			</form>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Book excursions</h2>
					</div>
					<div id="dettDAY" style="display:none;overflow-y:scroll;"></div>	
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
									<th>Booking ID</th>
									<th>Dates</th>
									<th>Agency</th>									
									<th>Excursion</th>								
									<th>Pax</th>
									<th>Select</th>
								</tr>
							</thead>
							<form name="allexcu" id="allexcu" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/setAllExcursionTransport">
							<tbody>
							<?php foreach($all_excursions as $exc){
							?>
								<tr>
									<td class="center n_<?php echo $exc["statopre"]?>">
										<span class="idofbook"><?php echo $exc["pte_book_id"]?></span>
									</td>
									<td class="center"><font style="color:#009900;clear:both;display:block;"><?php echo date("d/m/Y",strtotime($exc["arrival_date"]))?></font><font style="color:#990000;clear:both;display:block;"><?php echo date("d/m/Y",strtotime($exc["departure_date"]))?></font></td>
									<td><?php echo $exc["businessname"]?><font style="font-weight:bold;display:block;clear:both;"><?php echo $exc["myglname"]?></font><?php if($exc["pte_fromCampusManagerTick"]==1){ ?><font style="color:red">Booked by Campus Manager</font><br />Amount received: <?php echo $exc["pte_fromCampusManagerAmount"] ?> <?php echo $exc["pte_proforma_currency"] ?><?php } ?></td>
									<td><?php echo $exc["exc_excursion"]?><font style="font-weight:bold;display:block;clear:both;"><?php echo ucfirst($exc["exc_length"])?></font></td>									
									<td class="center"><a data-gravity="s" class="button small blue tooltip allPaxes" href="<?php echo base_url(); ?>index.php/backoffice/getAllExcursionsPaxFromExcID/<?php echo $exc["pte_id"]?>" name="GL and students included in the excursion <?php echo $exc["exc_excursion"]?>" original-title="View students included in the excursion <?php echo $exc["exc_excursion"]?>" style="width:20px;text-align:center;"><?php echo $exc["pte_tot_pax"]?></a></td>
									<td class="center containcheck"><input type="checkbox" name="excur_<?php echo $exc["pte_id"] ?>" value="<?php echo date("d-m-Y",strtotime($exc["arrival_date"]))?>_<?php echo date("d-m-Y",strtotime($exc["departure_date"]))?>_<?php echo $exc["exc_id"] ?>_<?php echo $exc["pte_tot_pax"] ?>" class="excn_<?php echo $exc["exc_id"] ?>" /></td>
									
								</tr>
							<?php
								}
							?>
							</tbody>
							<input type="hidden" value="<?php echo $campus ?>" name="id_centro" id="id_centro" />
							</form>
						</table>
						<table class="styled" style="border-top:1px solid #ddd;">
							<tfoot>
								<tr>
									<td style="text-align:right;"><button class="button red block" id="bus_all" name="bus_all" class="alt_btn">Set transportation for selected excursions</button></td>
								</tr>
							</tfoot>
						</table>						
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
	$(".containcheck input").click(function(){
		var arrclassi = $(this).attr("class").split(" ");
		var arrid = arrclassi[0].split("_");
		//alert(arrid[1]);
		$(".containcheck input").attr("disabled",true);
		var classenable = "excn_"+arrid[1];
		//alert(classenable);
		$(".containcheck input."+classenable).each(function() {
			$(this).removeAttr("disabled");
		});
	});
	$("#bus_all").click(function(){
		var contacheck=0;
		$(".containcheck input").each(function() {
			if($(this).attr("checked")=="checked"){
				if($(this).attr("disabled")!="disabled"){
					contacheck++;
				}
			}
		});
		if(contacheck > 0){
			$("#allexcu").submit();
		}else{
			alert("Select an excursion to book transfer!");
		}
	});
	
		
		$('.allPaxes').click(function(e){
			e.preventDefault();
			var dialog1 = $("#dettDAY").dialog({ 
				autoOpen: false,
				width: 800,
				modal: true,
				title: $(this).attr("name")
			});
			dialog1.html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");			
			dialog1.load($(this).attr("href"));
		});		
	
  });
  </script>
<?php $this->load->view('plused_footer');?>
