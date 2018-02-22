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
<?php $this->load->view('plused_sidebar'); ?>		
	<script>
	$(document).ready(function() {
		$( "li#ag_attractions" ).addClass("current");
		$( "li#ag_attractions a" ).addClass("open");		
		$( "li#ag_attractions ul.sub" ).css('display','block');	
		$( "li#ag_attractions ul.sub li#ag_attractions_2" ).addClass("current");	
	});
	</script>			

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<form>
					<fieldset>
						<legend>Booked Attraction</legend>
						<div class="row">
							<?php 
							if(count($allAtt) > 0){
							?>
							<table style="width:100%;margin:15px 0;">
								<thead>
									<tr>
										<th style="text-align:left;padding:4px 0;">Book Id</th>
										<th style="text-align:left;padding:4px 0;">Campus</th>
										<th style="text-align:left;padding:4px 0;">Students</th>
										<th style="text-align:left;padding:4px 0;">Attraction</th>
										<th style="text-align:left;padding:4px 0;">Status</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($allAtt as $eex){
											$colorF = "#990000";
											$statusF = "STANDBY";
											if($eex["atb_confirmed"]=="YES"){
												$statusF = "CONFIRMED";
												$colorF = "#009900";
											}
									?>
									<tr>
										<td style="padding:4px 1px;line-height:30px;"><?php echo $eex["atb_id_year"]?>_<?php echo $eex["atb_id_book"]?></td>
										<td style="padding:4px 1px;line-height:30px;"><?php echo $eex["nome_centri"]?></td>
										<td style="padding:4px 1px;line-height:30px;"><?php echo $eex["atb_tot_pax"]?></td>
										<td style="padding:4px 1px;line-height:30px;"><?php echo $eex["pat_name"]?></td>
										<td style="padding:4px 1px;line-height:30px;color:<?php echo $colorF ?>"><strong><?php echo $statusF?></strong></td>
										<td style="padding:1px;text-align:center;">
											<?php if($eex["atb_confirmed"]=="STANDBY"){ ?>
											<a data-gravity="s" class="button red remAtt" href="javascript:void(0);" style="width:135px;" name="Remove booked attraction now" original-title="Remove booked attraction now" style="margin-left:0;" id="bookA_<?php echo $eex["atb_id"]?>_<?php echo $eex["atb_id_book"]?>">Remove booked attraction</a>
											<?php } ?>
											<?php //if($eex["atb_confirmed"]=="YES"){ ?>
											<a data-gravity="s" class="button blue tooltip viewAtt" href="javascript:void(0);" style="width:135px;" name="View attraction invoice" original-title="View attraction invoice" style="margin-left:0;" id="viewA_<?php echo $eex["atb_id"]?>_<?php echo $eex["atb_id_book"]?>">View attraction invoice</a>
											<?php //} ?>											
										</td>
									</tr>
									<?php
										}
									?>
								</tbody>
							</table>
							<?php
							}else{
							?>
							<table>
								<tr><td>No booked attractions available</td></tr>
							</table>							
							<?php
							}
							?>
						</div>							
					</fieldset>
				</form>	
			</div>			
		</section><!-- End of #content -->
<script>


$(document).ready(function(){
	
	$(".remAtt").click(function(e){
		if(confirm("Are you sure you want to remove this attraction booking?")){
			arrattID = ($(this).attr("id")).split("_");
			window.location.href="<?php echo base_url(); ?>index.php/agents/remBookAttraction/"+arrattID[1]+"/"+arrattID[2];
		}else{
			return void(0);
		}
	});
	
	$(".viewAtt").click(function(e){
			arrattID = ($(this).attr("id")).split("_");
			window.open("<?php echo base_url(); ?>index.php/agents/PDF_BookAttraction/"+arrattID[1]+"/"+arrattID[2]);
			return void(0);
	});	
	
});
</script>		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
