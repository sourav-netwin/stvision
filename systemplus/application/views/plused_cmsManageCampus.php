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
		$( "li#cms_campus ul.sub li#cms_campus_1" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/hammer-screwdriver.png">Manage campus<a style="float:right;" href="<?php echo base_url(); ?>index.php/backoffice/cmsAddCampus" title="Add new campus"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/plus-button.png" class="icon">Add new campus</a></h2>
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
									<th>Campus name</th>
									<th>School name</th>
									<th>Location</th>								
									<th>Mail</th>
									<th style="width:180px;">&nbsp;</th>							
								</tr>
							</thead>
							<tbody>
							<?php foreach($campus as $cam){
					
							?>
								<tr>
									<td<?php if($cam["attivo"]==0){ ?> style="color:#f00;"<?php } ?>><?php echo $cam["nome_centri"]?></td>
									<td><?php echo $cam["school_name"]?></td>
									<td><?php echo $cam["located_in"]?></td>
									<td><?php echo $cam["cm_mail"]?></td>
									<td class="center" style="width:180px;">
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsEditCampus/<?php echo $cam["id"]?>" original-title="Edit campus <?php echo $cam["nome_centri"]?>" style="margin-left:0;"><i class="icon-edit"></i></a>
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsManageExcursions/planned/<?php echo $cam["id"]?>" original-title="Edit planned excursions for <?php echo $cam["nome_centri"]?>" style="margin-left:0;"><i class="icon-globe"></i></a>
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsManageExcursions/extra/<?php echo $cam["id"]?>" original-title="Edit extra excursions for <?php echo $cam["nome_centri"]?>" style="margin-left:0;"><i class="icon-star"></i></a>
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsManageExcTraCampus/<?php echo $cam["id"]?>/transfer" original-title="Edit transfers for <?php echo $cam["nome_centri"]?>" style="margin-left:0;"><i class="icon-plane"></i></a>
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsManageDatesCampus/<?php echo $cam["id"]?>" original-title="Edit arrival dates for <?php echo $cam["nome_centri"]?>" style="margin-left:0;"><i class="icon-calendar"></i></a>
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/cmsManageCampusAvailability/<?php echo $cam["id"]?>" original-title="Manage campus availability for <?php echo $cam["nome_centri"]?>" style="margin-left:0;"><i class="icon-cogs"></i></a>											
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
