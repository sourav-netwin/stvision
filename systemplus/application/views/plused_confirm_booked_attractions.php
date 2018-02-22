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
		$( "li#boattractions" ).addClass("current");
		$( "li#boattractions a" ).addClass("open");		
		$( "li#boattractions ul.sub" ).css('display','block');	
		$( "li#boattractions ul.sub li#boattractions_1" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<form style="margin:10px;" id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/reviewBookedAttractions" method="post">  
				<h1 class="grid_12 margin-top no-margin-top-phone">Booked attractions</h1>
				<div class="grid_10">
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
				<div class="grid_2">
						<div class="content" style="margin-top:30px;text-align:center;">
							<input type="button" name="transpmi" id="transpmi" class="cercaid" value="Search" />
						</div>
				</div>	
			</form>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Booked attractions</h2>
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
									<th>Agency</th>									
									<th>Attraction</th>								
									<th>Pax</th>
									<th>Cost</th>
									<th>Confirm</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($all_excursions as $exc){
							$costArray = explode(".",$exc["atb_total_price"]);
							?>
								<tr id="n_<?php echo $exc["atb_id"]?>">
									<td class="center">
										<span class="idofbook"><?php echo $exc["atb_id_year"]?>_<?php echo $exc["atb_id_book"]?></span>
									</td>
									<td style="width:100px;"><?php echo $exc["businessname"]?></td>
									<td><?php echo $exc["pat_name"]?><font style="font-weight:bold;display:block;clear:both;">Students: <?php echo $exc["pat_student_price"]?> <?php echo $exc["cur_codice"]?> - Adults: <?php echo $exc["pat_adult_price"]?> <?php echo $exc["cur_codice"]?></font></td>									
									<td class="center"><?php echo $exc["atb_tot_pax"]?></td>
									<td class="center" style="width:100px;"><input type="text" name="cost1_<?php echo $exc["atb_id"]?>" id="cost1_<?php echo $exc["atb_id"]?>" value="<?php echo $costArray[0] ?>" style="text-align:right;width:30px;" maxlength="4"> , <input type="text" style="text-align:left;width:20px;" name="cost2_<?php echo $exc["atb_id"]?>" id="cost2_<?php echo $exc["atb_id"]?>" value="<?php echo $costArray[1] ?>" maxlength="2"></td>
									<td class="center"><a data-gravity="s" class="button red confAtt" href="javascript:void(0);" style="width:135px;" name="Confirm attraction" original-title="Confirm attraction" style="margin-left:0;" id="bookC_<?php echo $exc["atb_id"]?>">Confirm attraction</a></td>
									
								</tr>
							<?php
								}
							?>
							</tbody>
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
	
	$(".confAtt").click(function(e){
		if(confirm("Are you sure you want to confirm this attraction booking?")){
			arrattID = ($(this).attr("id")).split("_");
			inte = $("#cost1_"+arrattID[1]).val();
			deci = $("#cost2_"+arrattID[1]).val();
			$.ajax({
				url: '<?php echo base_url(); ?>index.php/backoffice/confirmBookAttraction/'+arrattID[1]+'/'+inte+'/'+deci,
				cache: false,
				type: 'POST',
				success: function(msg) {
					if(msg=="UPDATED"){
						$("#n_"+arrattID[1]).hide();
						alert("Attraction booking confirmed!");
					}else{
						alert("Invalid cost format!");
					}
				}
			});
		}else{
			return void(0);
		}
	});	
	
  });
  </script>
<?php $this->load->view('plused_footer');?>
