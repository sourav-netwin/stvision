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
	});
	</script>			

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12 profile">
			
				<div class="header">
				
					<div class="title">
						<h2>Add new bus for <?php echo $company["tra_cp_name"]?></h2>
					</div>
					<div class="avatar">
						<img src="<?php echo base_url(); ?>img/elements/profile/avatar_bus.png" />
					</div>
					
					<ul class="info">
						<li>
							<a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageBusCoaches/<?php echo $idC?>" title="Back to company"><small>Back to company</small></a>
						</li>
					</ul><!-- End of ul.info -->
				</div><!-- End of .header -->
				
				<div class="details grid_12">
					<h2>Bus Details</h2>
					<form class="validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/backoffice/cmsInsertBusForCoach/<?php echo $idC?>" method="POST">
					<section>
						<table>
							<tr>
								<th>Bus name (eg. Bus 29 seater):</th><td><input type="text" style="width:300px;" name="tra_bus_name" id="tra_bus_name" class="required" value=""></td>
							</tr>
							<tr>
								<th>Seats:</th><td><input class="contastudenti" data-type="spinner" name="tra_bus_seat" id="tra_bus_seat" value="0" min="0" max="100" /></td>
							</tr>
						</table>
					</section>
					<div class="actions">
						<div class="right">
							<input id="addbus" type="submit" value="Insert new bus" name=addbus />
						</div>
					</div>	
					</form>
				</div>
				<div class="clearfix"></div>
				
				
				
			</div>
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
