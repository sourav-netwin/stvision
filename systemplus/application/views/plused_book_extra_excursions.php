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
		$( "li#ag_excursions" ).addClass("current");
		$( "li#ag_excursions a" ).addClass("open");		
		$( "li#ag_excursions ul.sub" ).css('display','block');	
		$( "li#ag_excursions ul.sub li#ag_excursions_1" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Bookings<a style="float:right;" href="<?php echo base_url(); ?>downloads/extras/view_and_book_excursions_and_attractions_guide.pdf" target="_blank" title="Guide for upload list"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/information-button.png" class="icon">How to book extra excursions</a></h2>
					</div>
					
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[1,"asc"]],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Booking ID</th>
									<th>Campus</th>
									<th>Date in</th>								
									<th>Date Out</th>
									<th>Weeks</th>
									<th>Pax</th>
									<th>Book now</th>
									<th>Qty booked</th>									
								</tr>
							</thead>
							<tbody>
							<?php foreach($all_books as $book){
								$da=explode("-",$book["arrival_date"]);
								$dd=explode("-",$book["departure_date"]);
								$ds=explode("-",$book["data_scadenza"]);
								$accos=$book["all_acco"];								
					
							?>
								<tr>
									<td class="center"><?php echo $book["id_year"]?>_<?php echo $book["id_book"]?></td>
									<td><?php echo $book["centro"]?></td>
									<td class="center"><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?></td>
									<td class="center"><?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?></td>
									<td class="center"><?php echo $book["weeks"]?></td>					
									<td class="center"><?php echo $book["tot_pax"]?></td>
									<td class="center"><a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/agents/bookExtraNow/<?php echo $book["id_book"]?>/<?php echo $book["id_centro"]?>/<?php echo $book["id_year"]?>" original-title="Book extra excursion for booking <?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" style="margin-left:0;"><i class="icon-edit"></i></a></td>
									<td class="center"><?php echo $book["conta_ex"]?></td>
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
