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
		$( ".dialogbtn" ).click(function() {
				var iddia = $(this).attr("id").replace('_btn','');
				//alert(iddia.replace('_btn',''));
				$( "#"+iddia ).dialog("open");
				return false;
		});
		$( ".windia" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}]
		});
	});
	</script>	

		<!-- Here goes the content. -->
		<?php
			$agdett=$agente[0];
		?>
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Bookings list - <?echo $agdett["businessname"]?> - <?echo $agdett["businesscountry"]?></h2>
					</div>
					
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-table-tools='{"display":true}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Booking ID</th>
									<th>Date in</th>								
									<th>Date Out</th>
									<th>Weeks</th>
									<th>Campus</th>
									<th>Pax</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($all_books as $book){
								$da=explode("-",$book["arrival_date"]);
								$dd=explode("-",$book["departure_date"]);
								$accos=$book["all_acco"];
					
							?>
								<tr>
									<td class="center"><a href="javascript:void(0);" id="dialog_modal_btn_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" class="dialogbtn">[View]</a> <?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>
									<div style="display: none;" id="dialog_modal_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" title="Booking detail - <?php echo $book["id_year"]?>_<?php echo $book["id_book"]?> - <?php echo $book["centro"]?>" class="windia">
										<p><strong>Date in: </strong><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?><br /><strong>Date out: </strong><?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?></p>
										<p><strong>Weeks: </strong><?php echo $book["weeks"]?></p>
										<p><strong>Accomodations</strong></p>
										<p>
											<ul>
										<?php
											foreach($accos as $acco){
												$tipo=$acco->tipo_pax;
												$accom=$acco->accomodation;
												$contot=$acco->contot;
												//print_r($acco);
										?>
											<li><strong><?php echo $tipo ?>: </strong><?php echo $accom ?>(<?php echo $contot ?>)</li>
										<?php
											}
										?>
											</ul>
										</p>
									</div></td>
									<td class="center"><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?></td>
									<td class="center"><?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?></td>
									<td class="center"><?php echo $book["weeks"]?></td>
									<td><?php echo $book["centro"]?></td>
									<td class="center"><?php echo $book["tot_pax"]?></td>
									<td class="n_<?php echo $book["status"]?>"><?php echo $book["status"]?><?php if($book["status"]=="active"){ ?> scadenza<?php } ?></td>
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
