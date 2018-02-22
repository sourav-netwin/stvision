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
		$( "li#cms_bus" ).addClass("current");
		$( "li#cms_bus a" ).addClass("open");		
		$( "li#cms_bus ul.sub" ).css('display','block');	
		$( "li#cms_bus ul.sub li#cms_bus_1" ).addClass("current");	
		
		$(".deleteBus").click(function(e){
			e.preventDefault();
			if(confirm("Are you sure you want to delete this bus?")){
				window.location.href=$(this).attr("href");
			}
		});
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/hammer-screwdriver.png">Manage bus for <?php echo $company["tra_cp_name"]?>
                                                    <a style="float:right;" href="<?php echo base_url(); ?>index.php/backoffice/cmsAddBusForCoach/<?php echo $idC ?>" title="Add new bus for <?php echo $company["tra_cp_name"]?>">
                                                        <img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/plus-button.png" class="icon">Add new bus for <?php echo $company["tra_cp_name"]?></a>
                                                </h2>
					</div>
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[1,"asc"]],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": true},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Bus name</th>
									<th>Number of seats</th>
									<th>&nbsp;</th>							
								</tr>
							</thead>
							<tbody>
							<?php foreach($bus as $bb){
					
							?>
								<tr>
									<td><?php echo $bb["tra_bus_name"]?></td>
									<td><?php echo $bb["tra_bus_seat"]?></td>
									<td class="center">
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsEditBusForCoach/<?php echo $bb["tra_bus_cp_id"]?>/<?php echo $bb["tra_bus_id"]?>" original-title="Edit bus <?php echo $bb["tra_bus_name"]?>" style="margin-left:0;"><i class="icon-edit"></i></a>
										<a data-gravity="s" class="button small grey tooltip deleteBus" href="<?php echo base_url(); ?>index.php/backoffice/cmsDeleteBus/<?php echo $bb["tra_bus_id"]?>/<?php echo $bb["tra_bus_cp_id"]?>" original-title="Delete bus <?php echo $bb["tra_bus_name"]?>" style="margin-left:0;"><i class="icon-remove"></i></a>
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
