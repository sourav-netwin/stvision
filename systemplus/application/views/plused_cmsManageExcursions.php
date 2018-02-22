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
		$( "li#cms_campus" ).addClass("current");
		$( "li#cms_campus a" ).addClass("open");		
		$( "li#cms_campus ul.sub" ).css('display','block');	
		$( "li#cms_campus ul.sub li#cms_campus_2" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/hammer-screwdriver.png">Manage Excursions<a style="float:right;" href="<?php echo base_url(); ?>index.php/backoffice/cmsAddExcursion" title="Add new excursion"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/plus-button.png" class="icon">Add new excursion</a></h2>
					</div>
					
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[0,"asc"]],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Excursion</th>
									<th>Campus</th>
									<th>Type</th>								
									<th>Weeks</th>
									<th style="width:100px;">&nbsp;</th>							
								</tr>
							</thead>
							<tbody>
							<?php foreach($excursions as $cam){
					
							?>
								<tr>
									<td><?php echo $cam["exc_excursion"]?></td>
									<td><?php echo $cam["exc_centro"]?></td>
									<td><?php echo $cam["exc_type"]?></td>
									<td><?php echo $cam["exc_weeks"]?></td>
									<td class="center" style="width:120px;">
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsEditExcursion/<?php echo $cam["exc_id"]?>" original-title="Edit excursion <?php echo $cam["exc_excursion"]?>" style="margin-left:0;"><i class="icon-edit"></i></a>
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsJoinAttrExc/<?php echo $cam["exc_id"]?>" original-title="Edit included attractions in <?php echo $cam["exc_excursion"]?>" style="margin-left:0;"><i class="icon-map-marker"></i></a>
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsJoinBusExc/<?php echo $cam["exc_id"]?>" original-title="Edit bus for <?php echo $cam["exc_excursion"]?>" style="margin-left:0;"><i class="icon-road"></i></a>
										<a data-gravity="s" class="button small grey tooltip" href="javascript:deleteExc(<?php echo $cam["exc_id"]?>);" original-title="Remove excursion <?php echo $cam["exc_excursion"]?>" style="margin-left:0;"><i class="icon-remove"></i></a>
									</td>
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
	function deleteExc(idEE){
			if(confirm("Are you sure you want to remove this excursion? All bookings and bus prices for this excursion will be removed!")){
				window.location.href = "<?php echo base_url(); ?>index.php/backoffice/cmsRemoveExcursion/"+idEE+"/<?php echo $tipoE ?>";
			}else{
			return void(0);
			}
	}
	</script>		
<?php $this->load->view('plused_footer');?>
