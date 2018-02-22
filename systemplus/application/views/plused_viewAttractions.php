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
		$( "li#ag_attractions" ).addClass("current");
		$( "li#ag_attractions a" ).addClass("open");		
		$( "li#ag_attractions ul.sub" ).css('display','block');	
		$( "li#ag_attractions ul.sub li#ag_attractions_1" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">

					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/globe-model.png">Available attractions<a style="float:right;" href="<?php echo base_url(); ?>downloads/extras/view_and_book_excursions_and_attractions_guide.pdf" target="_blank" title="Guide for upload list"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/information-button.png" class="icon">How to book attractions</a></h2>
					</div>					
					
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[0,"asc"]],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Attraction</th>
									<th>Type</th>
									<th>Location</th>								
									<th style="width:100px;">&nbsp;</th>							
								</tr>
							</thead>
							<tbody>
							<?php foreach($campus as $cam){
					
							?>
								<tr>
									<td><?php echo $cam["pat_name"]?></td>
									<td><?php echo $cam["patt_name"]?></td>
									<td><?php echo $cam["cou_descrizione"]?> - <?php echo $cam["cit_descrizione"]?></td>
									<td class="center" style="width:100px;">
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/agents/viewAttractionDetail/<?php echo $cam["pat_id"]?>" original-title="View details for attraction <?php echo $cam["pat_name"]?>" style="margin-left:0;"><i class="icon-zoom-in"></i></a>									
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
<?php $this->load->view('plused_footer');?>
