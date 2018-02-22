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
		$( "li#botransport ul.sub li#botransport_3" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">View companies details</h1>
			<?php
			foreach($companies as $cp){
			?>
			<div class="grid_12">
				<div class="box">
					<div class="header">
						<h2><?php echo $cp["tra_cp_name"] ?><font style="float:right;color:#dd0000;">Emergency Line: <?php echo $cp["tra_cp_emergency"] ?></font></h2>
					</div>
					<div class="content" style="margin:8px 4px;">
						<?php echo $cp["tra_cp_address"] ?><br />
						Tel: <?php echo $cp["tra_cp_phone"] ?> - Fax: <?php echo $cp["tra_cp_fax"] ?> - Email: <?php echo $cp["tra_cp_email"] ?><br />
					</div>
					<div class="footer">
						<a style="margin:10px 5px;float:left;" href="<?php echo base_url(); ?>backoffice/cms_coach_company/<?php echo $cp["tra_cp_id"] ?>" title="Edit <?php echo $cp["tra_cp_name"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/pencil-small.png"></a>
						<a style="margin:10px 5px;float:left;" href="<?php echo base_url(); ?>backoffice/cms_bus_coach_company/<?php echo $cp["tra_cp_id"] ?>" title="Edit bus for <?php echo $cp["tra_cp_name"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bus_excursion.png"></a>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</section><!-- End of #content -->
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
