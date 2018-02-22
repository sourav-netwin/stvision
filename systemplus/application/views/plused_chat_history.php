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
		/*dateFormat: 'dd-mm-yy'*/
		$("#ch_datetime").datetimepicker('setDate', (new Date()));
		$("#ch_datetime").datetimepicker( "option", "dateFormat", "dd/mm/yy" );
		/* $("#accordioninsert").accordion({active: false}); */
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
							<form class="grid_12 validate" method="POST" action="<?php echo base_url(); ?>index.php/agents/insertChat/<?php echo $ag_details[0]['id'] ?>">
						<div id="accordioninsert" class="accordion toggle">
						<h3><a href="#">Click here to insert new conversation - Agent <?php echo $ag_details[0]['businessname'] ?> - <?php echo $ag_details[0]['businesscountry'] ?></a></h3>
						<div>							
								<fieldset>
									<legend>Insert conversation fields</legend>
										<div class="row">
											<label for="ch_category">
												<strong>Category</strong>
												<small>(Sales / Operations)</small>
											</label>
											<div>
												<select class="required" name="ch_category" id="ch_category" data-placeholder="Choose category">
													<option value="">Choose category</option>
													<option value="sales">Sales</option> 
													<option value="operations">Operations</option> 
												</select>
											</div>
										</div>
										<div class="row">
											<label for="ch_messagetext">
												<strong>Message</strong>
												<small>(copy and paste)</small>
											</label>
											<div>
												<textarea class="required" rows=5 name="ch_messagetext" id="ch_messagetext"></textarea>
											</div>
										</div>	
										<div class="row">
											<label for="ch_datetime">
												<strong>Conversation date/time</strong>
											</label>
											<div>
												<input type="datetime" name="ch_datetime" id="ch_datetime" />
											</div>
										</div>										
										<div class="row">
											<label for="ch_from_am">
												<strong>Sender</strong>
												<small>(You / Agent <?php echo $ag_details[0]['businessname'] ?>)</small>
											</label>
											<div>
												<select class="required" name="ch_from_am" id="ch_from_am" data-placeholder="Choose the sender">
													<option value="">Choose the sender</option>
													<option value="0">Agent <?php echo $ag_details[0]['businessname'] ?></option> 
													<option value="1">You</option> 
												</select>
											</div>
										</div>										
										<div class="row">
											<label>
												<strong>Conversation type</strong>
											</label>
											<div>
												<div><input class="required" type="radio" name="ch_type" id="ch_type0" value="0"><label for="ch_type0">Mail</label></div>											
												<div><input class="required" type="radio" name="ch_type" id="ch_type1" value="1"><label for="ch_type1">Skype</label></div>
												<div><input class="required" type="radio" name="ch_type" id="ch_type2" value="2"><label for="ch_type2">Phone</label></div>
												<div><input class="required" type="radio" name="ch_type" id="ch_type3" value="3"><label for="ch_type3">SMS</label></div>
												<div><input class="required" type="radio" name="ch_type" id="ch_type4" value="4"><label for="ch_type4">Live conversation</label></div>
											</div>
										</div>		
										<div class="actions">
											<div class="right">
												<input type="submit" value="Submit" name=submit />
											</div>
										</div>										
								</fieldset>
						</div>
						</div>									
								<input type="hidden" name="ch_id_ag" id="ch_id_ag" value="<?php echo $ag_details[0]['id'] ?>">
								<input type="hidden" name="ch_id_am" id="ch_id_am" value="">
							</form>	
			</div>
			<div class="grid_12">
				<div class="box">
					<?php
					if($categoria=="sales"){
					?>
					<div class="header">
						<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/balloons.png" class="icon">SALES | Conversation history - Agent <?php echo $ag_details[0]['businessname'] ?> - <?php echo $ag_details[0]['businesscountry'] ?><a href="<?php echo base_url(); ?>index.php/agents/viewChatHistory/<?php echo $ag_details[0]['id'] ?>/operations"><button class="block" style="position:absolute;right:0px;top:-2px">View OPERATIONS history</button></a></h2>
					</div>
					<?php
					}else{
					?>
					<div class="header">
						<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/balloons.png" class="icon">OPERATIONS | Conversation history - Agent <?php echo $ag_details[0]['businessname'] ?> - <?php echo $ag_details[0]['businesscountry'] ?><a href="<?php echo base_url(); ?>index.php/agents/viewChatHistory/<?php echo $ag_details[0]['id'] ?>/sales"><button class="block" style="position:absolute;right:0px;top:-2px">View SALES history</button></a></h2>
					</div>					
					<?php
					}
					?>
					<div class="content">
						<div class="spacer"></div>
						<div class="messages chat full">
						<?php foreach($all_chats as $chat){
						switch ($chat["ch_type"]) {
							case 0:
								$imgtipo = "mail";
								break;
							case 1:
								$imgtipo = "skype";
								break;
							case 2:
								$imgtipo = "telephone-handset";
								break;
							case 3:
								$imgtipo = "mobile-phone";
								break;
							case 4:
								$imgtipo = "user-share";
								break;								
						}
						$datetime = strtotime($chat["ch_datetime"]);
						$okidate = date("d/m/Y H:i", $datetime);
						?>
							<div class="msg<?php if($chat["ch_from_am"]==0){ ?> reply<?php } ?>">
								<img src="<?php echo base_url(); ?>img/icons/packs/iconsweets2/25x25/<?php if($chat["ch_from_am"]==1){ ?>admin-<?php } ?>user-2.png">
								<div class="content">
									<h3><?php if($chat["ch_from_am"]==0){ ?><?php echo $ag_details[0]['businessname'] ?> <span>says:</span><?php } else { ?>You <span>say:</span> <?php } ?><small><?php echo $okidate?><img style="margin-left:5px;" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/<?php echo $imgtipo?>.png" class="icon"></small></h3>
									<p><?php echo $chat["ch_messagetext"]?></p>
								</div>
							</div>
						<?php
						}
						?>
						</div><!-- End of .messages -->
						
					</div><!-- End of .content -->
				</div>
			</div><!-- End of .grid_12 -->
			
			
			
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
