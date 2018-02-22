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
		$( "li#botransport" ).addClass("current");
		$( "li#botransport a" ).addClass("open");		
		$( "li#botransport ul.sub" ).css('display','block');	
		$( "li#botransport ul.sub li#botransport_9" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Canceled Bus Review</h2>
					</div>
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": true,"bSortable": true}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Bus Code</th>								
									<th style="text-align:left;">Excursion</th>
									<th style="text-align:left;">Bus Involved</th>
									<th style="text-align:right;">Bus Cost</th>
									<th>Excursion Date</th>
									<th>Cancelation Date</th>
									<th style="text-align:left;">User</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($all_canceled as $exc){ ?>
								<tr>
									<td><?php echo $exc["pcb_rndcode"]?></td>
									<td><?php echo $exc["pcb_excursion"]?></td>
									<td><?php echo $exc["pcb_bus"]?></td>
									<td style="text-align:right;"><?php echo $exc["pcb_price"] ?></td>
									<td class="neretto"><?php echo $exc["pcb_exc_date"]?></td>
									<td class="neretto"><?php echo $exc["pcb_can_date"]?></td>	
									<td style="text-align:left;"><?php echo $exc["pcb_can_user"] ?></td>									
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
						<table class="styled" style="border-top:1px solid #ddd;">
						</table>						
					</div>
				</div>
			</div>
			<div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_buslist" title="Bus List | Bus code" class="windia"></div>
		</section>
	</div>
<?php $this->load->view('plused_footer');?>
