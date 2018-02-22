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
		$( "li#boplexcursions" ).addClass("current");
		$( "li#boplexcursions a" ).addClass("open");		
		$( "li#boplexcursions ul.sub" ).css('display','block');	
		$( "li#boplexcursions ul.sub li#boplexcursions_1" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<form style="margin:10px;" id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/setUnplannedExcursions" method="post">  
				<h1 class="grid_12 margin-top no-margin-top-phone">Book included excursions</h1>
				<div class="grid_4">
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
				<div class="grid_3">
					<div class="box">
						<div class="header">
							<h2>Select Excursion Type</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<select name="tipo" id="tipo">
								<option <?php if($tipo=="planned"){?>selected <?php }?>value="planned">Included</option>
							</select> 		
						</div>
					</div>
				</div>	
				<div class="grid_4">
					<div class="box">
						<div class="header">
							<h2>Select Date Range</h2>
						</div>
						<div class="content" style="margin:8px 4px;">						
							<label for="from">From</label>
							<input type="text" id="from" name="from" value="<?php echo $from ?>" style="width:80px;" />
							<label for="to">to</label>
							<input type="text" id="to" name="to" value="<?php echo $to ?>" style="width:80px;" />
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
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Book included excursions</h2>
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
									<th>Booking ID</th>
									<th>DateIn</th>
									<th>DateOut</th>
									<th>Agency</th>									
									<th>W</th>
									<th>Excursion</th>								
									<th>Pax</th>
									<th>Select</th>
								</tr>
							</thead>
							<form name="allexcu" id="allexcu" method="POST" action="<?php echo base_url(); ?>index.php/backoffice/setExcursionTransport">
							<tbody>
							<?php foreach($all_excursions as $exc){
							?>
								<tr>
									<td class="center n_<?php echo $exc["statopre"]?>">
										<span class="idofbook"><?php echo $exc["id_year"]?>_<?php echo $exc["id_book"]?></span>
									</td>
									<td class="center"><?php echo date("d/m/Y",strtotime($exc["arrival_date"]))?></td>
									<td class="center"><?php echo date("d/m/Y",strtotime($exc["departure_date"]))?></td>
									<td><img class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $exc["businesscountry"]?>.png" alt="<?php echo $exc["businesscountry"]?>" title="<?php echo $exc["businesscountry"]?>" /><?php echo $exc["businessname"]?></td>
									<td class="center"><?php echo $exc["exc_weeks"]?></td>
									<td><?php echo $exc["exc_excursion"]?><font style="font-weight:bold;display:block;clear:both;"><?php echo ucfirst($exc["exc_length"])?></font></td>									
									<td><?php echo $exc["exb_tot_pax"]?></td>
									<td class="center containcheck"><input type="checkbox" name="excur_<?php echo $exc["exb_id"] ?>" value="<?php echo date("d-m-Y",strtotime($exc["arrival_date"]))?>_<?php echo date("d-m-Y",strtotime($exc["departure_date"]))?>_<?php echo $exc["exc_id"] ?>_<?php echo $exc["exb_tot_pax"] ?>" class="excn_<?php echo $exc["exc_id"] ?>" id="group<?php echo $exc["id_book"]?>_<?php echo $exc["exb_id"] ?>" /></td>
									
								</tr>
							<?php
								}
							?>
							</tbody>
							<input type="hidden" value="<?php echo $campus ?>" name="id_centro" id="id_centro" />
							<input type="hidden" value="<?php echo $to ?>" name="to" id="to" />
							<input type="hidden" value="<?php echo $from ?>" name="from" id="from" />
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
    $( "#from" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      numberOfMonths: 1,
	  dateFormat: "dd/mm/yy",	  
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      numberOfMonths: 1,
	  dateFormat: "dd/mm/yy",
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
	$(".containcheck input").click(function(){
		var arrclassi = $(this).attr("class").split(" ");
		var arrid = arrclassi[0].split("_");
		var groupidclass = arrclassi[1];
		var fatherId = $(this).attr("id").split("_")[0];
		var fatherId2 = $(this).attr("id").split("_")[1];
		$(".containcheck input").attr("disabled",true);
		var classenable = "excn_"+arrid[1];
		var groupdisable = "group_"+arrid[1];
		//alert(classenable);
		$(".containcheck input."+classenable).each(function() {
			var secondId = $(this).attr("id").split("_")[0];
			var secondId2 = $(this).attr("id").split("_")[1];
			//alert(fatherId+"-"+secondId+" ... "+fatherId2+"-"+secondId2);
			if(fatherId != secondId){
				$(this).removeAttr("disabled");
			}else if(fatherId2 == secondId2){
				$(this).removeAttr("disabled");
			}else{
				$(this).removeAttr("checked");
			}
		});
	});
	$("#bus_all").click(function(){
		$("#allexcu").submit();
	});
  });
  </script>
<?php $this->load->view('plused_footer');?>
