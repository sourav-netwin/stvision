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
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/calendar--plus.png">Insert new campus availability for <?php echo $camp["nome_centri"] ?></h2>
					</div>
					
					<div class="content">
						<table class="styled"> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Campus name</th>
									<th>Accomodation type</th>
									<th>Availability #</th>
									<th>Start date</th>
									<th>End date</th>	
									<th>&nbsp;</th>										
								</tr>
							</thead>
							<form name="formSaveAva" id="formSaveAva" action="<?php echo base_url(); ?>index.php/backoffice/cmsAddCampusAvailability/<?php echo $camp["id"] ?>" method="POST">
								<tbody>
									<tr>
										<td><?php echo $camp["nome_centri"]?></td>
										<td class="center">
											<select name="tipoAcc" id="tipoAcc">
												<option value="">Select a type</option>
												<?php foreach($campusSis as $tSis){ ?>
												<option value="<?php echo strtolower($tSis["sistemazione"]) ?>"><?php echo $tSis["sistemazione"] ?></option>
												<?php } ?>
											</select>
										</td>
										<td class="center"><input type="text" id="numAcco" name="numAcco" /></td>
										<td class="center"><input type="text" readonly id="dateStart" name="dateStart" /></td>
										<td class="center"><input type="text" readonly id="dateFinish" name="dateFinish" /></td>
										<td class="center"><input class="red" type="button" id="saveAva" name="saveAva" value="Insert new availability" /></td>
									</tr>
								</tbody>
							</form>
						</table>
					</div><!-- End of .content -->
				</div><!-- End of .box -->	

				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/hammer-screwdriver.png"><?php echo $camp["nome_centri"] ?> campus availability</h2>
					</div>
					
					<div class="content">
						<table class="styled"> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Campus name</th>
									<th>Accomodation type</th>
									<th>Availability #</th>
									<th>Start date</th>
									<th>End date</th>
									<th style="width:100px;">&nbsp;</th>							
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach($dates as $date){
					
							?>
								<tr>
									<td><?php echo $camp["nome_centri"]?></td>
									<td><?php echo $date["accomodation_type"]?></td>
									<td><?php echo $date["availability"]?></td>
									<td><?php echo date("d/m/Y",strtotime($date["start_date"]))?></td>
									<td><?php echo date("d/m/Y",strtotime($date["finish_date"]))?></td>
									<td class="center containremover" style="width:100px;">
										<a data-gravity="s" class="button small grey tooltip" href="javascript:void(0);" original-title="Remove this availability for <?php echo $camp["nome_centri"]?>" style="margin-left:0;" id="dataa_<?php echo $date["id"]?>"><i class="icon-remove"></i></a>										
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
			if(confirm("Are you sure you want to remove this availability for <?php echo $camp["nome_centri"]?>?")){
				var myid = $(this).attr("id").split("_");
				window.location.href="<?php echo base_url(); ?>index.php/backoffice/cmsDelCampusAvailability/"+myid[1]+"/<?php echo $camp["id"]?>";
			}
		});	

		
		$( "#dateStart" ).datepicker({
		  changeMonth: true,
		  changeYear: true,		  
		  dateFormat: "dd/mm/yy",
		  maxDate: "+1Y",
		  onClose: function( selectedDate ) {
			$( "#dateFinish" ).datepicker( "option", "minDate", selectedDate );
		  }
		});
		$( "#dateFinish" ).datepicker({
		  changeMonth: true,
		  changeYear: true,		
		  dateFormat: "dd/mm/yy",		  
		  onClose: function( selectedDate ) {
			$( "#dateStart" ).datepicker( "option", "maxDate", selectedDate );
		  }
		});

		$("#saveAva").click(function(){
			if($("#numAcco").val()=="" || $("#dateStart").val()=="" || $("#dateFinish").val()=="" || $("#tipoAcc").val()==""){
				alert("Please fill-in all the required fileds!");
				return void(0);
			}else{
				var rx = new RegExp(/\d+/);
				if(rx.test($("#numAcco").val())){
					$("#formSaveAva").submit();
				}else{
					alert("Please insert only digits in Availability field!");
					return void(0);
				}
			}
		});
		
	});
	</script>		
<?php $this->load->view('plused_footer');?>
