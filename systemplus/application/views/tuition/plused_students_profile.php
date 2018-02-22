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
				<span><?php echo $this->session->userdata('businessname') ?></span>
				<ul>
					<li><a href="<?php echo base_url(); ?>index.php/students/profile">Profile</a></li>
					<li class="line"></li>
					<li><a href="<?php echo base_url(); ?>index.php/students/logout">Logout</a></li>
				</ul>
			</div>
		</section><!-- End of .toolbar-->
<?php $this->load->view('plused_sidebar');?>		
	<script>
	$(document).ready(function() {
		$( "li#dashboard" ).addClass("current");
		$( "li#dashboard a" ).addClass("open");		
		$( "li#dashboard ul.sub" ).css('display','block');	
	});
	</script>		

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12 profile">
			
				<div class="header">
				
					<div class="title">
						<h2><?php echo $this->session->userdata('businessname') ?></h2>
						<h3><?php echo $this->session->userdata('country') ?></h3>
					</div>
					<div class="avatar">
						<img src="<?php echo base_url(); ?>img/elements/profile/avatar.png" />
					</div>
					
					<ul class="info">
                                            <li>
                                                
                                            </li>
					</ul><!-- End of ul.info -->
				</div><!-- End of .header -->
				
				<div class="details grid_12">
					<h2>Personal Details</h2>
					<section>
						<table>
							<tr>
								<th>Name:</th><td><?php echo $this->session->userdata('mainfirstname'); ?> <?php echo $this->session->userdata('mainfamilyname') ?></td>
							</tr>
							<tr>
								<th>UUID:</th><td><?php echo $this->session->userdata('uuid'); ?></td>
							</tr>
							<tr>
								<th>Date of birth:</th><td><?php echo date("d/m/Y",strtotime($this->session->userdata('pax_dob')));?></td>
							</tr>
						</table>
					</section>
				</div><!-- End of .details -->
				
				
				
				<div class="clearfix"></div>
			
			</div>
				
			<script>
                            var SITE_PATH = "<?php echo base_url();?>index.php/";
                            $$.ready(function() {				

                            });
			</script>
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
