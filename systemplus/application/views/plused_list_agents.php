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
		$( "#dialog_form" ).dialog({
					autoOpen: false,
					modal: true,
					width: 400,
					beforeClose:function() {
						$("#rem_id_ag").val("");
						$("#form_remind").attr("action","");					
					},
					open: function(){ $(this).parent().css('overflow', 'visible'); $$.utils.forms.resize() }
				}).find('button.submit').click(function(){
					var $el = $(this).parents('.ui-dialog-content');
					if ($el.validate().form()) {
						$el.find('form')[0].submit();
						$el.find('form')[0].reset();
						$el.dialog('close');
					}
				}).end().find('button.cancel').click(function(){
					$("#rem_id_ag").val("");	
					$("#form_remind").attr("action","");					
					var $el = $(this).parents('.ui-dialog-content');
					$el.find('form')[0].reset();
					$el.dialog('close');;
		});

		
		$("#rem_datetime").datetimepicker('setDate', (new Date()));
		$("#rem_datetime").datetimepicker( "option", "dateFormat", "dd/mm/yy" );		
	});
	
	
		function apriReminder(idThis) {
			$("#rem_id_ag").val("");
			var idattr = idThis.split("_");
			var idag = idattr[1];
			var nameag = $("#agency_"+idag).text();
			$("#ui-dialog-title-dialog_form").text("Set reminder for agent "+nameag);			
			$("#rem_id_ag").val(idag);
			$("#form_remind").attr("action","<?php echo base_url(); ?>index.php/agents/insertReminder/"+idag);
			//alert(idag);
			$("#dialog_form").dialog("open");
			return false;
		}
	
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Agents list</h2>
					</div>
					
					<div class="content">
						<div class="tabletools">
							<div class="left"></div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-table-tools='{"display":true}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th>Business name</th>
									<th>Agent name</th>								
									<th>City</th>
									<th>Country</th>
									<th>CRM</th>
									<th>Bkgs</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($all_agents as $agent){
								$colorestato = "green";
								if($agent["status"] != "active")
										$colorestato = "red";
								switch ($agent["statuscrm"]) {
									case 'Prospect':
										$icocrm = "money";
										break;
									case 'Trusted':
										$icocrm = "hand-shake";
										break;
									case 'Undesired':
										$icocrm = "minus-circle";
										break;
								}
								switch ($agent["ranking"]) {
									case 'Small':
										$n_stars = 1;
										break;
									case 'Standard':
										$n_stars = 2;
										break;
									case 'Medium':
										$n_stars = 3;
										break;
									case 'Large':
										$n_stars = 4;
										break;
									case 'VIP':
										$n_stars = 5;
										break;										
								}								
							?>
								<tr>
									<td><span class="badge block <?php echo $colorestato?>" style="text-indent:-9999px;padding:1px 8px;"><?php echo $agent["status"]?></span></td>
									<td id="agency_<?php echo $agent["id"]?>"><?php echo $agent["businessname"]?><br /><?php for($contastar=1;$contastar<=$n_stars;$contastar++){ ?><img border="0" src="http://plus-ed.com/vision_ag/img/icons/packs/fugue/16x16/star-small.png" style="margin-left:-5px"><?php } ?></td>
									<td><?php echo $agent["mainfamilyname"]?> <?php echo $agent["mainfirstname"]?></td>
									<td><?php echo $agent["businesscity"]?></td>
									<td class="center"><?php echo $agent["businesscountry"]?></td>
									<td class="center"><img height="16" width="16" alt="<?php echo $agent["statuscrm"]?>" title="<?php echo $agent["statuscrm"]?>" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/<?php echo $icocrm ?>.png"><span style="display:none;"><?php echo $agent["statuscrm"]?></span></td>
									<td class="center"><?php echo $agent["contarighe"]?></td>
									<td class="center" style="width:100px;">
										<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/agents/manageAgent/<?php echo $agent["id"]?>" original-title="Edit agent profile" style="margin-left:0;"><i class="icon-pencil"></i></a>
										<a data-gravity="s" class="button small grey tooltip mleft_10" href="<?php echo base_url(); ?>index.php/agents/viewAgentBookings/<?php echo $agent["id"]?>" original-title="View agent booking" style="margin-left:0;"><i class="icon-list"></i></a>
										<a data-gravity="s" class="button small grey tooltip mleft_10" href="<?php echo base_url(); ?>index.php/agents/viewChatHistory/<?php echo $agent["id"]?>/sales" original-title="View conversation history" style="margin-left:0;"><i class="icon-comment"></i></a>	
<?php //if($this->session->userdata('email')=="a.sudetti@gmail.com"){?>		
										<a onclick="javascript:apriReminder('agente_<?php echo $agent["id"]?>');" data-gravity="s" id="agente_<?php echo $agent["id"]?>" class="button small grey tooltip mleft_10 openreminder" href="javascript:void(0);" original-title="Set agent reminder" style="margin-left:0;"><i class="icon-edit"></i></a>		
<?php
//}
?>											
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
				<div style="display: none;" id="dialog_form" title="Set reminder">
								<form action="" class="full validate" id="form_remind" method="POST">
									<div class="row">
										<label for="rem_messagetext">
											<strong>Reminder text</strong>
										</label>
										<div>
											<input class="required" type=text name="rem_messagetext" id="rem_messagetext" />
										</div>
									</div>
									<div class="row">
											<label for="rem_datetime">
												<strong>Reminder date/time</strong>
											</label>
											<div>
												<input  type="datetime" name="rem_datetime" id="rem_datetime" />
											</div>
									</div>	
									<div class="row">
											<label for="ch_from_am">
												<strong>Reminder type</strong>
												<small>(For better use)</small>
											</label>
											<div>
												<select class="required" name="rem_type" id="rem_type" data-placeholder="Choose reminder type">
													<option value="0">Send an email</option> 
													<option value="1">Make a call</option> 
													<option value="2">Call in Skype</option> 
													<option value="3">Go to meeting</option> 
													<option value="4">Remember birthday</option> 
												</select>
											</div>
									</div>										
									<input type="hidden" name="rem_id_ag" id="rem_id_ag" value="">
									<input type="hidden" name="rem_id_am" id="rem_id_am" value="<?echo $this->session->userdata('id') ?>">
								</form>
								<div class="actions">
									<div class="left">
										<button class="grey cancel">Cancel</button>
									</div>
									<div class="right">
										<button class="submit">Submit</button>
									</div>
								</div>
							</div>
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
