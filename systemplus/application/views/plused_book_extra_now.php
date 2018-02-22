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
		
		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<form>
					<fieldset>
						<legend>Booking <?php echo $bookYear ?>_<?php echo $bookId ?> @ <?php echo $campusName ?></legend>
						<div class="row">
							<?php 
							if(count($excursionsBooked) > 0){
							?>
							<table style="width:100%;margin:15px 0;">
								<thead>
									<tr>
										<th style="text-align:left;padding:4px 0;">Group leader</th>
										<th style="text-align:left;padding:4px 0;">Excursion</th>
										<th style="text-align:left;padding:4px 0;">Status</th>
										<th style="text-align:left;padding:4px 0;">Bus Code</th>
										<th style="text-align:left;padding:4px 0;">Date</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($excursionsBooked as $eex){
									?>
									<tr>
										<td style="padding:4px 1px;"><?php echo $eex["glforthis"]?></td>
										<td style="padding:4px 1px;"><?php echo $eex["escursione"]?></td>
										<td style="padding:4px 1px;"><?php if($eex["pte_confirmed"]=="NO"){ echo "NOT CONFIRMED"; } else { echo $eex["pte_confirmed"]; }?></td>
										<td style="padding:4px 1px;"><?php echo $eex["pte_buscompany_code"]?></td>
										<td style="padding:4px 1px;"><?php if($eex["pte_excursion_date"]=="0000-00-00"){ echo "-";}else{echo date("d/m/Y",strtotime($eex["pte_excursion_date"]));}?></td>
										<td style="padding:4px 1px;text-align:center;">
											<?php if($eex["pte_confirmed"]=="NO"){ ?><a data-gravity="s" class="button small red tooltip removeEXC" href="<?php echo base_url(); ?>index.php/agents/removeAllExcursions/<?php echo $eex["pte_id"]?>/<?php echo $bookId ?>/<?php echo $campusId ?>/<?php echo $bookYear ?>" original-title="Remove extra excursion <?php echo $eex["escursione"]?>" style="margin-left:0;"><i class="icon-remove"></i></a><?php } ?>
											<a data-gravity="s" class="button small blue tooltip allPaxes" href="<?php echo base_url(); ?>index.php/agents/getAllExcursionsPaxFromExcID/<?php echo $eex["pte_id"]?>/<?php echo $bookId ?>/<?php echo $campusId ?>/<?php echo $bookYear ?>" name="GL and students included in the excursion <?php echo $eex["escursione"]?>" original-title="View students included in the excursion <?php echo $eex["escursione"]?>" style="margin-left:0;"><i class="icon-user"></i></a>
											<a data-gravity="s" target="_blank" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/agents/printProFormaById/<?php echo $eex["pte_id"]?>/<?php echo $bookId ?>/<?php echo $campusId ?>/<?php echo $bookYear ?>" name="Print excursion invoice" original-title="Print excursion invoice" style="margin-left:0;"><i class="icon-print"></i></a>
										</td>
									</tr>
									<?php
										}
									?>
								</tbody>
							</table>
							<?php
							}else{
							?>
							<table>
								<tr><td>No extra excursion booked for booking <?php echo $bookYear ?>_<?php echo $bookId ?></td></tr>
							</table>							
							<?php
							}
							?>
						</div>							
					</fieldset>
				</form>
				<div id="dettDAY" style="display:none;overflow-y:scroll;"></div>			
			</div>	
			<div class="grid_12">
				<form>
					<fieldset>
					<?php
					if($agentId==795){
					?>
					<legend>Select group leader and excursion</legend>
						<div class="row">
							<label for="prod_select">
								<strong>Group leader / All students</strong>
							</label>
							<div>
								<?php 

									if(count($groupleaders) > 0){
									?>							
									<select name=gl_select id=gl_select class="search required" data-placeholder="Choose a group leader or all students">
										<option value=""></option>
										<option value="all">All students in this booking</option>
										<?php
										foreach($groupleaders as $gl){
										?>
										<option value="<?php echo $gl["uuid"] ?>"><?php echo $gl["cognome"] ?> <?php echo $gl["nome"] ?></option> 
										<?php
										}
										?>
									</select>
									<?php
									}else{
									?>
									<select name=gl_select id=gl_select class="search required" data-placeholder="Choose a group leader or all students">
										<option value="">No roster uploaded for this group</option>
									</select>
									<?php
									}
								?>
							</div>
						</div>	
					<?php
					}else{
					?>
					<input type="hidden" id="gl_select" name="gl_select" value="all" />
					<?php
					}
					?>
						<div class="row">
							<label for="center_select">
								<strong>Extra excursion</strong>
							</label>
							<div>
								<select name=ee_select id=ee_select class="search required" data-placeholder="Choose an excursion">
									<option value=""></option>
									<?php
									foreach($excursions as $exc){
									?>
									<option value="<?php echo $exc["exc_id"] ?>"><?php echo ucfirst($exc["exc_length"]) ?> - <?php echo $exc["exc_excursion"] ?></option> 
									<?php
									}
									?>								
								</select>
							</div>
						</div>								
					</fieldset>
					<div class="actions">
						<div class="right">
							<input id="readpax" type="button" value="Retrieve students for excursion" name=readpax />
						</div>
					</div><!-- End of .actions -->
				</form>
			</div>
			<div class="grid_12">
				<form action="<?php echo base_url(); ?>index.php/agents/insertTestataExcursion/<?php echo $bookId ?>" name="eeform" id="eeform" class="grid12" method="POST">
					<fieldset>
						<legend>Group leader and students involved in extra excursion</legend>
						<div class="row" id="allstudents" style="border:0;"></div>
						<div class="row" id="allprices" style="border:0;"></div>
					</fieldset>
					<div class="actions">
						<div class="right">
							<input id="writeextra" type="button" value="Book excursion now" disabled=disabled name=writeextra />
						</div>
					</div>
					<input type="hidden" name="passGL" id="passGL" value="" />
					<input type="hidden" name="passEE" id="passEE" value="" />
					<input type="hidden" name="passNUMSTD" id="passNUMSTD" value="" />
					<input type="hidden" name="passPRICESTD" id="passPRICESTD" value="" />
					<input type="hidden" name="passCURRENCY" id="passCURRENCY" value="" />
					<input type="hidden" name="passCAMPUS" id="passCAMPUS" value="<?php echo $campusId ?>" />
					<input type="hidden" name="passTYPE" id="passTYPE" value="extra" />
					<input type="hidden" name="passBKID" id="passBKID" value="<?php echo $bookYear ?>_<?php echo $bookId ?>" />
				</form>
			</div><!-- End of .grid_12 -->	

		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	<script>
	$(document).ready(function() {
		$( "li#ag_excursions" ).addClass("current");
		$( "li#ag_excursions a" ).addClass("open");		
		$( "li#ag_excursions ul.sub" ).css('display','block');	
		$( "li#ag_excursions ul.sub li#ag_excursions_1" ).addClass("current");
		$("#gl_select").change(function(){
			$("#writeextra").attr("disabled","disabled");
			$("#allstudents").empty();
			$("#allprices").empty();
		});
		$("#ee_select").change(function(){
			$("#writeextra").attr("disabled","disabled");
			$("#allstudents").empty();
			$("#allprices").empty();
		});		
		$("#readpax").click(function(){
			if($("#gl_select").val()==""){
				alert("Select a group leader or all students!");
				return false;
			}else{
				$("#passGL").val($("#gl_select").val());
			}
			if($("#ee_select").val()==""){
				alert("Select an excursion!");
				return false;
			}else{
				$("#passEE").val($("#ee_select").val());
			}	
			$("#allstudents").html('retrieving students ...');
			$.ajax({
				type: "POST",
				data: "gluuid=" + $("#gl_select").val(),
				url: "<?php echo base_url(); ?>index.php/agents/retrieveStudentsByGl/<?php echo $bookId ?>",
				success: function(msg){
					if (msg != ''){
						$("#allstudents").html(msg).show();
						$("#writeextra").attr("disabled",false);
					}
					else{
						$("#allstudents").html('<em>No item results</em>');
					}
				}
			});	
			$.ajax({
				type: "POST",
				//data: "gluuid=" + $("#gl_select").val(),
				url: "<?php echo base_url(); ?>index.php/agents/bestBusPriceForExcursion/"+$("#passEE").val()+"/<?php echo $allNum ?>/<?php echo $stdNum ?>",
				success: function(msg){
					if (msg != ''){
						arrMsg = msg.split("___");
						$("#passNUMSTD").val(arrMsg[0]);
						$("#passPRICESTD").val(arrMsg[1]);
						$("#passCURRENCY").val(arrMsg[2]);
						$("#allprices").html("<p><b>Price per pax (only Students): <font style='color:#f00;'>"+arrMsg[1]+" "+arrMsg[2]+"</font></b></p>").show();
					}
					else{
						$("#allprices").html('<em>No prices retrieved</em>');
					}
				}
			});				
		});
		$("#writeextra").click(function(){
			$("#eeform").submit();
		});
		$(".removeEXC").click(function(e){
			//e.preventDefault();
			if(confirm("Are you sure you want to remove this excursion?")){
				return true;
			}else{
				return false;
			}
		});	
		
		$('.allPaxes').click(function(e){
			e.preventDefault();
			var dialog1 = $("#dettDAY").dialog({ 
				autoOpen: false,
				width: 800,
				modal: true,
				title: $(this).attr("name")
			});
			dialog1.html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");			
			dialog1.load($(this).attr("href"));
		});		
	});

	
	</script>	
<?php $this->load->view('plused_footer');?>
