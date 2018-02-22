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
<?php $this->load->view('plused_sidebar');
	$CC = $company;
?>		
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
						<h2><?php echo $CC['tra_cp_name'] ?></h2>
						<h3><?php echo $CC['tra_cp_email'] ?></h3>
					</div>
					<div class="avatar">
						<img src="<?php echo base_url(); ?>img/elements/profile/avatar_bus.png" />
					</div>
					
					<ul class="info">
						<li>
							<a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageCoaches" title="Back to companies"><small>Back to companies</small></a>
						</li>
					</ul><!-- End of ul.info -->
				</div><!-- End of .header -->
				
				<div class="details grid_12">
					<h2>Company Details</h2>
					<form class="validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/backoffice/cmsUpdateCoach/<?php echo $CC['tra_cp_id'] ?>" method="POST">
					<section>
						<table>
							<tr>
								<th>Company:</th><td><input type="text" style="width:300px;" name="tra_cp_name" id="tra_cp_name" class="required" value="<?php echo $CC['tra_cp_name'] ?>"></td>
							</tr>
							<tr>
								<th>Address:</th><td><input type="text" style="width:450px;" name="tra_cp_address" id="tra_cp_address" class="required" value="<?php echo $CC['tra_cp_address'] ?>"></td>
							</tr>
							<tr>
								<th>Website:</th><td><input type="text" style="width:300px;" name="tra_cp_website" id="tra_cp_website" value="<?php echo $CC['tra_cp_website'] ?>"></td>
							</tr>
							<tr>
								<th>Contact name:</th><td><input type="text" style="width:300px;" name="tra_cp_contact_name" id="tra_cp_contact_name" class="required" value="<?php echo $CC['tra_cp_contact_name'] ?>"></td>
							</tr>	
							<tr>
								<th>Email:</th><td><input type="text" style="width:300px;" name="tra_cp_email" id="tra_cp_email" class="required" value="<?php echo $CC['tra_cp_email'] ?>"></td>
							</tr>								
							<tr>
								<th>Phone:</th><td><input type="text" style="width:300px;" name="tra_cp_phone" id="tra_cp_phone" class="required" value="<?php echo $CC['tra_cp_phone'] ?>"></td>
							</tr>
							<tr>
								<th>Emergency phone:</th><td><input type="text" style="width:300px;" name="tra_cp_emergency" id="tra_cp_emergency" class="required" value="<?php echo $CC['tra_cp_emergency'] ?>"></td>
							</tr>
							<tr>
								<th>Fax:</th><td><input type="text" name="tra_cp_fax" style="width:300px;" id="tra_cp_fax" class="required" value="<?php echo $CC['tra_cp_fax'] ?>"></td>
							</tr>							
						</table>
					</section>
					<div class="actions">
						<div class="right">
							<input id="modprofile" type="submit" value="Update company details" name=modprofile />
						</div>
					</div>	
					</form>
				</div>
				<div class="clearfix"></div>
				
				
				
			</div>
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>