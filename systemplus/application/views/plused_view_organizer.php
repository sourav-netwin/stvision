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
		$( "li#manage_crm" ).addClass("current");
		$( "li#manage_crm a" ).addClass("open");		
		$( "li#manage_crm ul.sub" ).css('display','block');	
		$( "li#manage_crm ul.sub li#man_crm_1" ).addClass("current");	
	});
	</script>		

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
					<div class="header">
						<form action="" name="cambiaAnno" id="cambiaAnno" method="POST">
						<h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/calendar.png" class="icon">Organizer</h2>
						<div style="width:150px;position:absolute;top:3px;right:55px;float:right;height:auto;">
								<input data-type="spinner" name=annoOrg id=annoOrg value="<?php echo $annoAttuale?>" min="2011" max="<?php echo date("Y" )?>" />
						</div>
						<div style="width:50px;position:absolute;top:3px;right:5px;float:right;height:auto;">
								<input type="button" name="send" id="send" value="Send">
						</div>
						</form>
					</div>
					<div class="content">
					<div id="accordionmesi">
					<?php 
					$month = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemeber", "December");
					for($mese=1;$mese<=12;$mese++){
					?>
						<h3><a href="#"><?php echo $month[$mese] ?> (<?php echo count($remindme[$mese]) ?>)</a></h3>
						<div>
						<?php
							if(count($remindme[$mese])){
								$adesso = strtotime("now");
								foreach($remindme[$mese] as $remino){
									$datagiro = strtotime($remino["r_data"]);
									$diffgiro = $datagiro-$adesso;
									if($diffgiro > 0)
										$coloreg = "success";
									if($diffgiro <= 0 and $diffgiro >= -86400)
										$coloreg = "warning";
									if($diffgiro < -86400)
										$coloreg = "error";									
									//echo $coloreg."--".$diffgiro."<br />";
									if($remino["r_completo"]==1)
										$coloreg = "note";	
									$pieces = explode(" ", $remino["r_data"]);
									//print_r($pieces);
									$piecesdata = explode("-", $pieces[0]);
									$newdt = $piecesdata[2]."/".$piecesdata[1]."/".$piecesdata[0];
									$piecestime = explode(":", $pieces[1]);
									$newti = $piecestime[0].":".$piecestime[1];		
									switch ($remino["r_tipo"]) {
										case 0:
											$imgtipo = "mail";
											break;
										case 1:
											$imgtipo = "telephone-handset";
											break;
										case 2:
											$imgtipo = "skype";
											break;
										case 3:
											$imgtipo = "hand-shake";
											break;
										case 4:
											$imgtipo = "present";
											break;								
									}
							?>
							<div class="alert <?php echo $coloreg?>" style="padding-left:5px;">
								<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/calendar.png">
								<strong><?php echo $newdt?> <?php echo $newti?> - <?php echo $remino["r_agente"]?>:</strong> <?php echo $remino["r_testo"]?>
								<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/<?php echo $imgtipo?>.png" style="float:right;margin-right:105px;">
								<?php 
									if($remino["r_completo"]==0){ 
								?>
								<span class="close" id="remi_<?php echo $remino["r_id"]?>">Mark as complete</span>
								<?php
									}else{
								?>
								<span style="font-weight:bold;position:absolute;right:8px;">Completed</span>
								<?php
									}
								?>
							</div>
							<?php
								}
							}else{
								echo "No reminders";
							}
						?>
						</div>
					<?php
					}
					?>	
					</div>
					</div>
				</div><!-- End of .box -->
			</div>
		</section><!-- End of #content -->
	</div><!-- End of #main -->
	<script>
		$(document).ready(function(){
			$( "#accordionmesi" ).accordion({ collapsible: true, active:false,autoHeight: false, clearStyle: true });
			$(".close").click(function(){
				var arremi = $(this).attr("id").split("_");
				var chiudo = arremi[1];
				$.ajax({
					type: "POST",
					data: "idremi=" + chiudo,
					url: "<?php echo base_url(); ?>index.php/agents/completeReminder"
				});
			});
			$("#send").click(function(){
				$("#cambiaAnno").attr("action","<?php echo base_url(); ?>index.php/agents/viewOrganizer/"+$("#annoOrg").val());
				$("#cambiaAnno").submit();
			});
		});
	</script>
<?php $this->load->view('plused_footer');?>
