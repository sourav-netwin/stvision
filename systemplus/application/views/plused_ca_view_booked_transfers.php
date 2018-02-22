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
		$( "li#botransport" ).addClass("current");
		$( "li#botransport a" ).addClass("open");		
		$( "li#botransport ul.sub" ).css('display','block');	
		$( "li#botransport ul.sub li#botransport_7" ).addClass("current");	
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<form style="margin:10px;" id="box_transport" name="box_transport" action="<?php echo base_url(); ?>index.php/backoffice/ca_viewBookedTransfers" method="post">  
				<h1 class="grid_12 margin-top no-margin-top-phone">View booked transfers</h1>
				<div class="grid_5">
					<div class="box">
						<div class="header">
							<h2>Select Type</h2>
						</div>
						<div class="content" style="margin:8px 4px;">
							<select name="tipo" id="tipo">
								<option <?php if($tipo=="inbound"){?>selected <?php }?>value="inbound">Inbound</option>
								<option <?php if($tipo=="outbound"){?>selected <?php }?>value="outbound">Outbound</option>
							</select> 		
						</div>
					</div>
				</div>	
				<div class="grid_5">
					<div class="box">
						<div class="header">
							<h2>Select Date Range</h2>
						</div>
						<div class="content" style="margin:8px 4px;">						
							<label for="from">From</label>
							<input type="text" id="from" name="from" value="<?php echo $from ?>" style="width:80px;" />
							<label for="to">to</label>
							<input type="text" id="to" name="to" value="<?php echo $to ?>" style="width:80px;" />
						</div>
					</div>
				</div>	
				<div class="grid_2">
						<div class="content" style="margin-top:30px;text-align:center;">
							<input type="button" name="transpmi" id="transpmi" class="cercaid" value="Search" />
						</div>
				</div>	
			</form>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">View booked transfers</h2>
					</div>
		
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<table class="styled" data-table-tools='{"display":false}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Reference Code</th>
									<th>Transfer Date</th>
									<th>Campus</th>
									<th>Airport</th>
									<th>Flight Details</th>
									<th>Pax Number</th>
									<th>View Detail</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($all_transfers as $exc){
							?>
								<tr>
									<td class="center">
										<span class="idofbook"><?php echo $exc["ptt_buscompany_code"]?></span>
									</td>
									<td class="center"><?php echo date("d/m/Y",strtotime($exc["ptt_excursion_date"]))?></td>
									<td class="center"><?php echo $exc["nome_centri"]?></td>
									<?php 
										if($tipo=="inbound"){ 
									?>
										<td class="center">
											<?php
										if(!empty($flgDetails)){
											$aptDet = array();
											$cnt = 0;
											if(isset($flgDetails[$exc["ptt_buscompany_code"]])){
												foreach($flgDetails[$exc["ptt_buscompany_code"]] as $flight){
													if(!in_array($flight["ptt_airport_to"], $aptDet)){
														if($cnt == 0){
															echo $flight["ptt_airport_to"];
														}
														else{
															echo ', '.$flight["ptt_airport_to"];
														}
														$aptDet[] = $flight["ptt_airport_to"];
														$cnt += 1;
													}
												}
											}
										}
										?>
										</td>
									<?php
										}else{
									?>
										<td class="center">
											<?php
										if(!empty($flgDetails)){
											$aptDet = array();
											$cnt = 0;
											if(isset($flgDetails[$exc["ptt_buscompany_code"]])){
												foreach($flgDetails[$exc["ptt_buscompany_code"]] as $flight){
													if(!in_array($flight["ptt_airport_from"], $aptDet)){
														if($cnt == 0){
															echo $flight["ptt_airport_from"];
														}
														else{
															echo ', '.$flight["ptt_airport_from"];
														}
														$aptDet[] = $flight["ptt_airport_from"];
														$cnt += 1;
													}
												}
											}
										}
										?>
										</td>
									<?php
										}
									?>
										<td class="center">
										<?php
										if(!empty($flgDetails)){
											if(isset($flgDetails[$exc["ptt_buscompany_code"]])){
												foreach($flgDetails[$exc["ptt_buscompany_code"]] as $flight){
													echo '<span class="refstandby">'.$flight['ptt_book_id'].'</span>&nbsp;&nbsp'.$flight["ptt_flight"].'@</span><span class="refstandby">'.date("H:i",strtotime($flight["ptt_dataora"])).'</span> | '.$flight["ptt_airport_from"].'&#x2708;'.$flight["ptt_airport_to"].'<br />';
												}
											}
										}
										?>
									</td>
									<td class="center"><?php echo $exc["effettivi"]?></td>
									<td class="center">
										<a data-gravity="s" class="button small grey tooltip dialogbtn" id="code_<?php echo $exc["ptt_buscompany_code"]?>" href="javascript:void(0);" original-title="View detail"><i class="icon-zoom-in" style="font-size:14px;"></i></a>
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
	$('#transpmi').click(function(){
		$('#loading-data').show();
		$('#box_transport').submit();
	});
})
</script>
  <script>
  $(document).ready(function(){
    $( "#from" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      numberOfMonths: 1,
	  dateFormat: "dd/mm/yy",	  
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1d",
      changeMonth: true,
      numberOfMonths: 1,
	  dateFormat: "dd/mm/yy",
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
	$(".dialogbtn").click(function(){
		window.location.replace("<?php echo base_url(); ?>index.php/backoffice/busTraDetail/"+$(this).attr("id"));
	});
  });
  </script>
<?php $this->load->view('plused_footer');?>
