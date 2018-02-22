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
		$( "li#manage_ag" ).addClass("current");
		$( "li#manage_ag a" ).addClass("open");		
		$( "li#manage_ag ul.sub" ).css('display','block');	
		$( "li#manage_ag ul.sub li#man_ag_1" ).addClass("current");
	});
	</script>		

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12 profile">
			
				<div class="header">
				
					<div class="title">
						<h2><?php echo $ag_details[0]['businessname'] ?></h2>
						<h3><?php echo $ag_details[0]['businesscountry'] ?></h3>
					</div>
					<div class="avatar">
						<img src="<?php echo base_url(); ?>img/elements/profile/avatar.png" />
					</div>
					
					<ul class="info">
						<li>
							<a data-gravity="e" class="tooltip" href="<?php echo base_url(); ?>index.php/agents/viewAgentBookings/<?php echo $ag_details[0]['id'] ?>" original-title="View agent bookings">
								<strong><?php echo $n_books?></strong>
								<small>Bookings</small>
							</a>
						</li>
					</ul><!-- End of ul.info -->
				</div><!-- End of .header -->
				
				<div class="details grid_12">
					<h2>Personal Details</h2>
					<a href="<?php echo base_url(); ?>index.php/agents/viewAgentBookings/<?php echo $ag_details[0]['id'] ?>"><span class="icon icon-list"></span>View agent bookings</a>
					<form class="validate" name="persoprofile" id="persoprofile" action="<?php echo base_url(); ?>index.php/agents/updateProfileAgent/<?php echo $ag_details[0]['id'] ?>" method="POST">
					<section>
						<table>
							<tr>
								<th>Name:</th><td><input type="text" name="mainfamilyname" class="required" value="<?php echo $ag_details[0]['mainfamilyname'] ?>"> <input type="text" name="mainfirstname" class="required" value="<?php echo $ag_details[0]['mainfirstname'] ?>"></td>
							</tr>
							<tr>
								<th>Email:</th><td><?php echo $ag_details[0]['email'] ?></td>
							</tr>
							<tr>
								<th>Telephone:</th><td><input type="text" name="businesstelephone" value="<?php echo $ag_details[0]['businesstelephone'] ?>"></td>
							</tr>
							<tr>
								<th>Mobile phone:</th><td><input type="text" name="mobilephone" value="<?php echo $ag_details[0]['mobilephone'] ?>"></td>
							</tr>	
							<tr>
								<th>Skype name:</th><td><input type="text" name="skypename" value="<?php echo $ag_details[0]['skypename'] ?>"></td>
							</tr>								
							<tr>
								<th>Address:</th><td><input type="text" style="width:250px;" name="businessaddress" value="<?php echo $ag_details[0]['businessaddress'] ?>"></td>
							</tr>
							<tr>
								<th>Postal Code:</th><td><input type="text" name="businesspostalcode" value="<?php echo $ag_details[0]['businesspostalcode'] ?>"></td>
							</tr>
							<tr>
								<th>City:</th><td><input type="text" name="businesscity" value="<?php echo $ag_details[0]['businesscity'] ?>"></td>
							</tr>
							<tr>
								<th>Country:</th><td><?php echo $ag_details[0]['businesscountry'] ?></td>
							</tr>
							<tr>
								<th>Origin:</th><td>
                                                                        <select name="origin" id="origin">
                                                                                <option value="">Select origin</option>
                                                                                <option value="Fairs"<?php if($ag_details[0]['origin']=="Fairs"){ ?> selected<?php } ?>>Fairs</option>
                                                                                <option value="Internet"<?php if($ag_details[0]['origin']=="Internet"){ ?> selected<?php } ?>>Internet</option>
                                                                                <option value="Advertising LTM"<?php if($ag_details[0]['origin']=="Advertising LTM"){ ?> selected<?php } ?>>Advertising LTM</option>
                                                                                <option value="Word of mouth"<?php if($ag_details[0]['origin']=="Word of mouth"){ ?> selected<?php } ?>>Word of mouth</option>
                                                                        </select>
                                                        </td>
							</tr>
							<tr>
								<th>Client status:</th><td>
													<select name="statuscrm" id="statuscrm">
														<option value="Trusted"<?php if($ag_details[0]['statuscrm']=="Trusted"){ ?> selected<?php } ?>>Trusted</option>
														<option value="Prospect"<?php if($ag_details[0]['statuscrm']=="Prospect"){ ?> selected<?php } ?>>Prospect</option>
														<option value="Undesired"<?php if($ag_details[0]['statuscrm']=="Undesired"){ ?> selected<?php } ?>>Undesired</option>
													</select>
											</td>
							</tr>							
						</table>
					</section>
					<div class="actions">
						<div class="right">
							<input id="modprofile" type="submit" value="Update personal details" name=modprofile />
						</div>
					</div>	
					</form>
				</div>
<?php /*if($this->session->userdata('email')=="a.sudetti@gmail.com"){ */?>
				<div class="details grid_12">
					<h2>Destinations of interest</h2>
					<form action="<?php echo base_url(); ?>index.php/agents/updateProductsAgent/<?php echo $ag_details[0]['id'] ?>" name="prodform" id="prodform" class="grid12" method="POST">
				
				<?php
					foreach($all_prodotti as $prodotto){
				?>			
					<section>
						<h2 style="text-transform:uppercase;margin-left:10px;"><b><?php echo $prodotto["prd_name"]?></b></h2>
						<a class="button block blue selall" id="sel_all_<?php echo $prodotto["prd_id"]?>" href="javascript:void(0);">Select all</a>
						<a class="button block red deselall" id="desel_all_<?php echo $prodotto["prd_id"]?>" href="javascript:void(0);">Deselect all</a>
						<table>
						<tr>
						<td>
						<ul style="list-style-type:none;float:left;width:99%;margin:0;padding:0;">
							<?php foreach($doi[$prodotto["prd_id"]] as $singdest){
							?>
							<li style="float:left;margin:0;display:inline;width:33%;padding:0 0 15px 0;">
								<input style="width:10%;" class="doi_<?php echo $prodotto["prd_id"]?>" type="checkbox" id="doi_<?php echo $ag_details[0]['id'] ?>_<?php echo $singdest["id"]?>" name="doi_<?php echo $ag_details[0]['id'] ?>_<?php echo $singdest["id"]?>" value="1" />
								<label style="width:90%;"><?php echo $singdest["nome_centri"]?></label>
							</li>
							<?php
							}
							?>
						</ul>
						</td>
						</tr>
						</table>
					</section>
				<?php
				}
				?>				
					<div class="actions">
						<div class="right">
							<input id="moddesti" type="submit" value="Update destinations of interest" name=moddesti />
						</div>
					</div>						
					</form>
				</div>
<?php
/* } */
?>		
				<div class="details grid_12">
					<h2>Profile Details</h2>
						<form action="<?php echo base_url(); ?>index.php/agents/updateStatusAgent/<?php echo $ag_details[0]['id'] ?>" name="commform" id="commform" class="grid12" method="POST">
						<?php
						foreach($all_prodotti as $prodotto){
						?>
						<div class="row" id="row_pr_<?php echo $prodotto["prd_id"]?>">
							<label for="spinner_<?php echo $prodotto["prd_id"]?>">
								<strong>% <?php echo $prodotto["prd_name"]?> commission</strong>
							</label>
							<div>
								<input class="contastudenti" data-type="spinner" name=spinner_<?php echo $prodotto["prd_id"]?> id=spinner_<?php echo $prodotto["prd_id"]?> value="<?php echo $prodotto['sconto']?>" min="0" max="35" />
							</div>
						</div>	
						<?php
						}
						?>	
						<div class="row">
							<label for="ranking_select">
								<strong>Client Ranking</strong>
							</label>
							<div>
								<select name=ranking_select id=ranking_select class="search required" data-placeholder="Choose a rank">
									<option value="Small"<?php if($ag_details[0]['ranking']!="Small"){?> selected<?php } ?>>Small</option>
									<option value="Standard"<?php if($ag_details[0]['ranking']=="Standard"){?> selected<?php } ?>>Standard</option> 
									<option value="Medium"<?php if($ag_details[0]['ranking']=="Medium"){?> selected<?php } ?>>Medium</option> 
									<option value="Large"<?php if($ag_details[0]['ranking']=="Large"){?> selected<?php } ?>>Large</option> 
									<option value="VIP"<?php if($ag_details[0]['ranking']=="VIP"){?> selected<?php } ?>>VIP</option> 
								</select>
							</div>
						</div>							
						<div class="row">
							<label for="status_select">
								<strong>Status</strong>
							</label>
							<div>
								<select name=status_select id=status_select class="search required" data-placeholder="Choose a product">
									<option value="pending"<?php if($ag_details[0]['status']!="active"){?> selected<?php } ?>>Pending</option>
									<option value="active"<?php if($ag_details[0]['status']=="active"){?> selected<?php } ?>>Active</option> 
								</select>
							</div>
						</div>	
					<div class="actions">
						<div class="left">
							<input id="credentag" type="button" class="red" value="Send credentials" name=credentag />
						</div>
						<div class="right">
							<input id="writeag" type="button" value="Update status and commissions" name=writeag />
						</div>
					</div>					
						</form>
				</div>
				
				
				
				<div class="clearfix"></div>
				
				
				
			</div>
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	<script>
	$(document).ready(function(){
		$("#writeag").click(function(){
			document.getElementById("commform").submit();		
		});
		$("#credentag").click(function(){
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/agents/send_agent_credentials/<?php echo $ag_details[0]['id'] ?>",
				success: function(html){
					alert("Credentials has been sent to the agent");
				}
			});		
		});
		<?php
		foreach($doi_agent as $doi_attivo){
		?>
		$("#doi_<?php echo $ag_details[0]['id'] ?>_<?php echo $doi_attivo["doi_id_dest"]?>").attr('checked', true);
		<?php
		}
		?>
		$(".selall").click(function(){
			var idst = $(this).attr("id").split("_");
			var globalsel = ".doi_"+idst[2];
			$(globalsel).attr('checked', true);
		});
		$(".deselall").click(function(){
			var idst = $(this).attr("id").split("_");
			var globalsel = ".doi_"+idst[2];
			$(globalsel).attr('checked', false);
		});		
	});
	</script>
<?php $this->load->view('plused_footer');?>
