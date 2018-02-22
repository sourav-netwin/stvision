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
							<a data-gravity="e" class="tooltip" href="<?php echo base_url(); ?>index.php/agents/insertedBookings" original-title="Review your bookings">
								<strong><?php echo $n_books?></strong>
								<small>Bookings</small>
							</a>
						</li>
					</ul><!-- End of ul.info -->
				</div><!-- End of .header -->
				
				<div class="details grid_12">
					<h2>Personal Details</h2>
					<a class="open-profile-dialog" href="javascript:void(0);"><span class="icon icon-pencil"></span>Change password</a>
					<section>
						<table>
							<tr>
								<th>Name:</th><td><?php echo $this->session->userdata('mainfirstname') ?> <?echo $this->session->userdata('mainfamilyname') ?></td>
							</tr>
							<tr>
								<th>Email:</th><td><?php echo $this->session->userdata('email') ?></td>
							</tr>
							<tr>
								<th>Telephone:</th><td><?php echo $ag_details[0]['businesstelephone'] ?></td>
							</tr>
							<tr>
								<th>Address:</th><td><?php echo $ag_details[0]['businessaddress'] ?></td>
							</tr>
							<tr>
								<th>Postal Code:</th><td><?php echo $ag_details[0]['businesspostalcode'] ?></td>
							</tr>
							<tr>
								<th>City:</th><td><?php echo $ag_details[0]['businesscity'] ?></td>
							</tr>
							<tr>
								<th>Country:</th><td><?echo $this->session->userdata('country') ?></td>
							</tr>
						</table>
					</section>
				</div><!-- End of .details -->
				
				
				
				<div class="clearfix"></div>
				
				<!-- Example Profile Dialog -->							
				<div style="display: none;" id="profile-dialog" title="Change password">
				
					<form action="" class="validate">
						<div class="row">
							<label for="d1_password">
								<strong>Old password</strong>
							</label>
							<div>
								<input class="required" type=password name=d1_password id=d1_password />
							</div>
						</div>
						<div class="row">
							<label for="d2_password">
								<strong>New password</strong>
							</label>
							<div>
								<input class="required" type=password name=d2_password id=d2_password />
							</div>
						</div>
						<div class="row">
							<label for="d3_password">
								<strong>Confirm new password</strong>
							</label>
							<div>
								<input class="required" type=password name=d3_password id=d3_password equalto="#d2_password" />
							</div>
						</div>
					</form>
					
					<div class="actions">
						<div class="right">
							<button class="submit">Submit</button>
						</div>
					</div>
					
				</div><!-- End of #profile-dialog -->
				
			</div>
				
			<script>
				$$.ready(function() {				
				// Profile Dialog
				
				$( "#profile-dialog" ).dialog({
					autoOpen: false,
					modal: true,
					width: 400,
					open: function(){ $(this).parent().css('overflow', 'visible'); $$.utils.forms.resize() }
				}).find('button.submit').click(function(){
					var $el = $(this).parents('.ui-dialog-content');
					if ($el.validate().form()) {
						$el.dialog('close');
					}
				}).end().find('button.cancel').click(function(){
					var $el = $(this).parents('.ui-dialog-content');
					$el.find('form')[0].reset();
					$el.dialog('close');;
				});
				
				$( ".open-profile-dialog" ).click(function() {
					$( "#profile-dialog" ).dialog( "open" );
					return false;
				});
			});
			</script>
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
