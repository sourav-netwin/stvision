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
	$CC = $excursion;
?>		
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
			<div class="grid_12 profile">
			
				<div class="header">
				
					<div class="title">
						<h2><?php echo $CC['exc_excursion'] ?></h2>
						<h3><?php echo $CC['exc_centro'] ?></h3>
					</div>
					<div class="avatar">
						<img src="<?php echo base_url(); ?>img/elements/profile/avatar_campus.png" />
					</div>
					
					<ul class="info">
						<li>
							<a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageExcursions" title="Back to excursions"><small>Back to excursions</small></a>
						</li>
					</ul><!-- End of ul.info -->
				</div><!-- End of .header -->
				<form class="validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/backoffice/cmsUpdateExcursion/<?php echo $CC['exc_id'] ?>" method="POST">
				<div class="details grid_12">
					<h2>Excursion Details</h2>
					<section>
						<table>
							<tr>
								<th style="width:150px;">Excursion:</th><td><input type="text" style="width:300px;" name="exc_excursion" id="exc_excursion"  value="<?php echo $CC['exc_excursion'] ?>"></td>
							</tr>
							<tr>
								<th style="width:150px;">Campus:</th>
									<td>
										<select style="width:300px;" name="exc_id_centro" id="exc_id_centro">
										<?php foreach($campus as $camp){ ?>
											<option value="<?php echo $camp['id'] ?>"<?php if($camp['id']==$CC['exc_id_centro']){ ?> selected="selected"<?php } ?>><?php echo $camp['nome_centri'] ?></option>
										<?php } ?>
										</select>
									</td>
							</tr>	
							<tr>
								<th style="width:150px;">Length:</th>
									<td>
										<select style="width:300px;" name="exc_length" id="exc_length">
											<option value="half day"<?php if($CC['exc_length']=="half day"){ ?> selected="selected"<?php } ?>>Half day</option>
											<option value="full day"<?php if($CC['exc_length']=="full day"){ ?> selected="selected"<?php } ?>>Full day</option>
										</select>
									</td>
							</tr>	
							<tr>
								<th style="width:150px;">Type:</th>
									<td>
										<select style="width:300px;" name="exc_type" id="exc_type">
											<option value="planned"<?php if($CC['exc_type']=="planned"){ ?> selected="selected"<?php } ?>>Planned</option>
											<option value="extra"<?php if($CC['exc_type']=="full day"){ ?> selected="selected"<?php } ?>>Extra</option>
										</select>
									</td>
							</tr>
							<tr>
								<th style="width:150px;">Weeks:</th>
									<td>
										<select style="width:300px;" name="exc_weeks" id="exc_weeks">
											<option value="1"<?php if($CC['exc_weeks']=="1"){ ?> selected="selected"<?php } ?>>1 week</option>
											<option value="2"<?php if($CC['exc_weeks']=="2"){ ?> selected="selected"<?php } ?>>2 weeks</option>
											<option value="3"<?php if($CC['exc_weeks']=="3"){ ?> selected="selected"<?php } ?>>3 weeks</option>
										</select>
									</td>
							</tr>															
						</table>					
					</section>
					<div class="actions">
						<div class="right">
							<input id="modprofile" type="submit" value="Update excursion details" name=modprofile />
						</div>
					</div>	
				</div>				
				<div class="clearfix"></div>
				</form>
				
				
			</div>
		</section><!-- End of #content -->

<script>



$(document).ready(function(){
	
	
});
</script>		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
