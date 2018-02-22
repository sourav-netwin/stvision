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
		<style type="text/css">
			@media(max-width: 650px){
				table.styled thead tr th, table.styled tbody tr td{
					min-height: 17px;
				}
				table.styled thead tr th:last-child{
					min-height: 34px;
					vertical-align: middle !important;
				}
			}
		</style>
	<script>
	$(document).ready(function() {
		$( "li#cabookings" ).addClass("current");
		$( "li#cabookings a" ).addClass("open");		
		$( "li#cabookings ul.sub" ).css('display','block');	
		$( "li#cabookings ul.sub li#cabookings_1" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Bookings and excursions</h2>
					</div>
					<div style="display: none;" id="note_modal" title="Insert note for Booking" class="notedia">
							<div class="row">
										<label for="oldNotes">
											<strong>Old Notes</strong>
										</label>
										<div>
											<textarea class="nogrow" name="oldNotes" disabled id="oldNotes" rows="16" style="width:100%;"></textarea>
										</div>
							</div>							
						</div>		
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='50' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Agency Nationality</th>
									<th>Booking Id</th>
									<th>Date In</th>
									<th>Date Out</th>
									<th>Pax Number</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($all_books as $bk){
							?>
								<tr>
									<td class="center">
										<img original-title="<?php echo $bk["agency"][0]["businesscountry"]?>" src="<?php echo base_url() ?>img/flags/16/<?php echo $bk["agency"][0]["businesscountry"] ?>.png" tooltip="">
										<!--<span class="idofbook"><?php //echo $bk["agency"][0]["businessname"]?></span>-->
									</td>
									<td class="center"><?php echo $bk["id_year"]?>_<?php echo $bk["id_book"]?></td>
									<td class="center"><?php echo date("d/m/Y",strtotime($bk["arrival_date"]))?></td>
									<td class="center"><?php echo date("d/m/Y",strtotime($bk["departure_date"]))?></td>
									<td class="center"><?php echo $bk["tot_pax"]?></td>
									<td class="center">
										<a data-gravity="s" class="button small grey tooltip dialognote" id="code__<?php echo $bk["id_year"]?>__<?php echo $bk["id_book"]?>" href="<?php echo base_url(); ?>index.php/backoffice/ca_viewNotes/<?php echo $bk["id_year"]?>/<?php echo $bk["id_book"]?>" original-title="View notes for booking Id <?php echo $bk["id_year"]?>_<?php echo $bk["id_book"]?>"><i class="icon-align-left" style="font-size:14px;"></i></a>
										<?php
										if($bk["agency"][0]["id"]!=795){
										?>
										<a data-gravity="s" class="button small grey tooltip dialogbtn" id="code__<?php echo $bk["id_year"]?>__<?php echo $bk["id_book"]?>" href="<?php echo base_url(); ?>index.php/backoffice/ca_viewBookXx/<?php echo $bk["id_year"]?>/<?php echo $bk["id_book"]?>/<?php echo $bk["agency"][0]["id"]?>" original-title="View/Book extra excursions for booking Id <?php echo $bk["id_year"]?>_<?php echo $bk["id_book"]?>"><i class="icon-picture" style="font-size:14px;"></i></a>
										<?php
										}
										?>
										<?php
										if($bk["agency"][0]["id"]!=795){
										?>
										<a data-gravity="s" class="button small grey tooltip dialogbtn" id="codeatt__<?php echo $bk["id_year"]?>__<?php echo $bk["id_book"]?>" href="<?php echo base_url(); ?>index.php/backoffice/ca_viewBookAtt/<?php echo $bk["id_year"]?>/<?php echo $bk["id_book"]?>/<?php echo $bk["agency"][0]["id"]?>" original-title="View/Book attractions for booking Id <?php echo $bk["id_year"]?>_<?php echo $bk["id_book"]?>"><i class="icon-camera" style="font-size:14px;"></i></a>
										<?php
										}
										?>										
									</td>									
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
						<table class="styled" style="border-top:1px solid #ddd;">
						</table>						
					</div><!-- End of .content -->
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
		</section><!-- End of #content -->
	</div><!-- End of #main -->

  <script>
  $(document).ready(function(){
	  $('[toolTip]').tipsy({gravity:'s'});
		$( ".notedia" ).dialog({
				autoOpen: false,
				modal: true,
				width: 600,
				height: 450,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}]
		});		
		$( ".dialognote" ).click(function() {
				$("#oldNotes").val("");
				var idnota = $(this).attr("id").split("code__");
				var justid = idnota[1].split("__");
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/backoffice/readBookingNotes/"+justid[1]+"/1",
					success: function(html){
						$("#oldNotes").val(html);
					}
				});
				$( "#note_modal" ).dialog("option", "title", "View notes for Booking "+idnota[1]);
				$("#thisBk").val(justid[1]);
				$( "#note_modal" ).dialog("open");
				return false;
		});	
  });
  </script>
<?php $this->load->view('plused_footer');?>
