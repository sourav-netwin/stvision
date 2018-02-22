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
<?php $this->load->view('plused_sidebar');
	$CC = $excursion;
?>		
	<script>
	$(document).ready(function() {
		$( "li#cms_campus" ).addClass("current");
		$( "li#cms_campus a" ).addClass("open");		
		$( "li#cms_campus ul.sub" ).css('display','block');	
		$( "li#cms_campus ul.sub li#cms_campus_2" ).addClass("current");	
	});
	</script>			

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/hammer-screwdriver.png">Manage attractions in <?php echo $CC['exc_excursion'] ?> <a id="addMe" style="float:right;" href="javascript:void(0);" title="Add attractions included in <?php echo $CC['exc_excursion'] ?>"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/plus-button.png" class="icon">Add new attraction</a></h2>
					</div>	
				<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">	
								<?php echo $CC['exc_excursion'] ?> from <?php echo $CC['exc_centro'] ?> | <?php echo $CC['exc_type'] ?> | <?php echo $CC['exc_length'] ?>							
							</div>
						</div>
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[0,"asc"]],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Attraction</th>
									<th>Type</th>
									<th>Students price</th>
									<th>Adults price</th>
									<th style="width:100px;">&nbsp;</th>							
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach($attrs as $attr){
					
							?>
								<tr>
									<td><?php echo $attr["pat_name"]?></td>
									<td><?php echo $attr["patt_name"]?></td>
									<td style="text-align:right;"><?php echo $attr["pat_student_price"]?> <?php echo $attr["cur_codice"]?></td>
									<td style="text-align:right;"><?php echo $attr["pat_adult_price"]?> <?php echo $attr["cur_codice"]?></td>
									<td class="center containremover" style="width:100px;">
										<a data-gravity="s" class="button small grey tooltip" href="javascript:void(0);" original-title="Remove attraction <?php echo $attr["pat_name"]?>" style="margin-left:0;" id="attra_<?php echo $attr["pjea_id"]?>"><i class="icon-remove"></i></a>										
									</td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
				</div>				
				<div class="clearfix"></div>
				
				</div>
			</div>
			<div id="dialog-modal" title="Add an attraction to <?php echo $CC['exc_excursion'] ?>" style="display:none;">
				<form style="border:none;background-color:transparent;" name="addAttE" id="addAttE" action="<?php echo base_url(); ?>index.php/backoffice/cmsAddAttractionToExc/<?php echo $CC['exc_id'] ?>" method="POST">
					<select name="add_attra" id="add_attra">
					<?php 
						foreach($attractions as $at){
					?>
						<option value="<?php echo $at["pat_id"]?>"><?php echo $at["pat_name"]?></option>
					<?php
						}
					?>
					</select>
				</form>
			</div>
		</section><!-- End of #content -->

<script>



$(document).ready(function(){
		$( "td.containremover a" ).click(function(e){
			e.preventDefault();
			if(confirm("Are you sure you want to remove this attraction from <?php echo $CC['exc_excursion'] ?>?")){
				var myid = $(this).attr("id").split("_");
				window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsDelAttrExc/"+myid[1]+"/<?php echo $CC['exc_id'] ?>";
			}
		});

		$("a#addMe").click(function(){
			$( "#dialog-modal" ).dialog({
				height: 350,
				width: 550,
				modal: true,
				buttons: {
					"Add Attraction": function() {
						$("#addAttE").submit();
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
	
});
</script>		
	</div><!-- End of #main -->
<?php $this->load->view('plused_footer');?>
