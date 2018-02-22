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
<?php 
	$this->load->view('plused_sidebar');
	$camp=$campus[0];
?>	
	<script>
	$(document).ready(function() {
		$( "li#cms_campus" ).addClass("current");
		$( "li#cms_campus a" ).addClass("open");		
		$( "li#cms_campus ul.sub" ).css('display','block');	
		$( "li#cms_campus ul.sub li#cms_campus_1" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/hammer-screwdriver.png">Manage campus arrival dates<font style="float:right;">Add new arrival date</font><input type="hidden" name="rem_datetime" id="rem_datetime" /></h2>
					</div>
					
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[0,"asc"]],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Campus name</th>
									<th>Arrival date</th>
									<th style="width:100px;">&nbsp;</th>							
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach($dates as $date){
					
							?>
								<tr>
									<td><?php echo $camp["nome_centri"]?></td>
									<td><?php echo date("d/m/Y",strtotime($date["start_date"]))?></td>
									<td class="center containremover" style="width:100px;">
										<a data-gravity="s" class="button small grey tooltip" href="javascript:void(0);" original-title="Remove date <?php echo date("d/m/Y",strtotime($date["start_date"]))?> for <?php echo $camp["nome_centri"]?>" style="margin-left:0;" id="dataa_<?php echo $date["id"]?>"><i class="icon-remove"></i></a>										
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
			
			
			
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	<script>
	$(document).ready(function() {
	<?php /* <?php echo base_url(); ?>index.php/backoffice/cmsEditCampus/<?php echo $date["id"]?> */ ?>
		$( "td.containremover a" ).click(function(e){
			e.preventDefault();
			if(confirm("Are you sure you want to remove this arrival date for <?php echo $camp["nome_centri"]?>?")){
				var myid = $(this).attr("id").split("_");
				window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsDelDateCampus/"+myid[1]+"/<?php echo $camp["id"]?>";
			}
		});	
		
	  $(function() {
		$( "#rem_datetime" ).datepicker({
		buttonImage: 'http://plus-ed.com/vision_ag/img/icons/packs/fugue/16x16/plus-button.png',
		buttonText: "Choose a date",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        showOn: 'both',
		onSelect: function(dateText, inst) {
				var date = $(this).val().replace("/","__").replace("/","__");
				window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsAddDateCampus/"+date+"/<?php echo $camp["id"]?>";
		}
		});
	  });	

	$("img.ui-datepicker-trigger").css("float","right");
		
	});
	</script>		
<?php $this->load->view('plused_footer');?>
