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
	$monthnames = array("","January","February","March","April","May","June","July","August","September","October","November","December");
    switch($accomodation){
        case 1:
            $accoSimulator = "standard";
            break;
        case 2:
            $accoSimulator = "ensuite";
            break;
        case 3:
            $accoSimulator = "homestay";
            break;
    
    }
?>		
		
		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">Review Campus day 2 day</h1>
			<div class="grid_3">
				<div class="box">
					<div class="header">
						<h2>Select Campus</h2>
					</div>
					<div class="content">
							<form style="margin:10px;" id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/backoffice/reviewday2day" method="post">  
										<select name="centri" id="centricampus">
										<?php
											 foreach($centri as $key=>$item){
											 //echo "<br />--->".$campus."---".$item['id']."<---";
											 ?>
											 <option <?if($campus==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?></option>
										<?php 	 }
										?>
									</select> 
							<input type="hidden" name="accomodation_in" value="<?php echo $accomodation;?>">  
							<input type="hidden" name="month_in" value="<?php echo $month;?>"> 
							<input type="hidden" name="year_in" value="<?php echo $year;?>"> 
							</form>					
					</div>
				</div>
			</div>
			<div class="grid_3">
				<div class="box">
					<div class="header">
						<h2>Select Accomodation</h2>
					</div>
					<div class="content">
							<form style="margin:10px;" id="box_acco" name="box_acco" action="<?php echo base_url(); ?>index.php/backoffice/reviewday2day" method="post">  
								<select name="accomodation_in" id="accomodation_in">
									<option <?php if($accomodation==1){?>selected <?php }?>value="1">Standard</option>
									<option <?php if($accomodation==2){?>selected <?php }?>value="2">Ensuite</option>
									<option <?php if($accomodation==3){?>selected <?php }?>value="3">Homestay</option>
								</select> 
								<input type="hidden" name="centri" value="<?php echo $campus;?>">
								<input type="hidden" name="month_in" value="<?php echo $month;?>"> 
								<input type="hidden" name="year_in" value="<?php echo $year;?>"> 								
							</form>			
					</div>
				</div>
			</div>	
			<div class="grid_3">
				<div class="box">
					<div class="header">
						<h2>Select Month</h2>
					</div>
					<div class="content">
							<form style="margin:10px;" id="box_month" name="box_month" action="<?php echo base_url(); ?>index.php/backoffice/reviewday2day" method="post">  
								<select name="month_in" id="month_in">
									<option <?php if($month==1){?>selected <?php }?>value="1">January</option>
									<option <?php if($month==2){?>selected <?php }?>value="2">February</option>
									<option <?php if($month==3){?>selected <?php }?>value="3">March</option>
									<option <?php if($month==4){?>selected <?php }?>value="4">April</option>
									<option <?php if($month==5){?>selected <?php }?>value="5">May</option>
									<option <?php if($month==6){?>selected <?php }?>value="6">June</option>
									<option <?php if($month==7){?>selected <?php }?>value="7">July</option>
									<option <?php if($month==8){?>selected <?php }?>value="8">August</option>
									<option <?php if($month==9){?>selected <?php }?>value="9">September</option>
									<option <?php if($month==10){?>selected <?php }?>value="10">October</option>
									<option <?php if($month==11){?>selected <?php }?>value="11">November</option>
									<option <?php if($month==12){?>selected <?php }?>value="12">December</option>
								</select> 
								<input type="hidden" name="accomodation_in" value="<?php echo $accomodation;?>">  								
								<input type="hidden" name="centri" value="<?php echo $campus;?>">
								<input type="hidden" name="year_in" value="<?php echo $year;?>">
							</form>			
					</div>
				</div>
			</div>	
			<div class="grid_3">
				<div class="box">
					<div class="header">
						<h2>Select Year</h2>
					</div>
					<div class="content">
							<form style="margin:10px;" id="box_year" name="box_year" action="<?php echo base_url(); ?>index.php/backoffice/reviewday2day" method="post">  
								<select name="year_in" id="year_in">
									<?php
									for($annino=2012;$annino<=date("Y");$annino++){
									?>
									<option <?php if($year==$annino){?>selected <?php }?>value="<?php echo $annino ?>"><?php echo $annino ?></option>
									<?php
									}
									?>
								</select> 
								<input type="hidden" name="accomodation_in" value="<?php echo $accomodation;?>">  								
								<input type="hidden" name="centri" value="<?php echo $campus;?>">
								<input type="hidden" name="month_in" value="<?php echo $month;?>">
							</form>			
					</div>
				</div>
			</div>				
			<div class="grid_12">
				<div class="box">
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/calendar.png"><?php echo $campusname?> - <?php echo ucfirst($accomodationname)?> accomodation (<?php echo $monthnames[$month] ?> <?php echo $year ?>)<a  style="float:right;" href="<?php echo base_url(); ?>index.php/backoffice/simulatorday2day/<?php echo $campus;?>/<?php echo $accoSimulator;?>/<?php echo $year;?>-<?echo $month?>-01/<?php echo $year;?>-<?echo $month?>-<?php echo count($bkgmese) ?>" title="Simulate month"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/calendar-blue.png">Launch simulation</a></h2>
					</div>
					<div id="dettDAY" style="display:none;overflow-y:scroll;"></div>
					<div class="content">
							<div class="tabletools">
								<div class="left"></div>
								<div class="right"></div>
							</div>					
							<table class="styled" data-table-tools='{"display":false}'> <!-- OPTIONAL: with-prev-next -->
								<thead>
									<tr>
										<th style="width:80px;">Day</th>
										<th style="width:110px;">Date</th>
										<th style="width:50px;">In</th>
										<th style="width:50px;padding:8px;">Out</th>
										<th>Allocation</th>									
										<th>Booked</th>
										<th>Availability</th>								
										<th style="width:230px;">Status details</th>
										<th>Detail</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$daycount = 1;
									foreach($bkgmese as $book){
									$da=explode("-",$book["datat"]);
									$dow = date ("l", strtotime($book["datat"]))
								?>
									<tr class="<?php echo $book["avaOver"] ?>">
										<td class="center" style="width:80px;<?php if($dow=="Sunday"){ ?>color:#c00;<?php } ?>"><?php echo $dow?></td>
										<td class="center" style="width:110px;<?php if($dow=="Sunday"){ ?>color:#c00;<?php } ?>"><?php echo $daycount?> <?php echo $monthnames[$month]?> <?php echo $da[0]?></td>
										<td class="center"><?if($book["num_in"] > 0){ ?><a href="javascript:void(0);" class="openDoorPaxList" id="od_<?php echo $book["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/door-open-in.png"> <?php echo $book["num_in"] ?></a><?php }else{ ?>&nbsp;<?php } ?></td>
										<td class="center"><?if($book["num_out"] > 0){ ?><a href="javascript:void(0);" class="closeDoorPaxList" id="cd_<?php echo $book["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/door-open-out.png"> <?php echo $book["num_out"] ?></a><?php }else{ ?>&nbsp;<?php } ?></td>
										<td class="center"><strong><?php echo $book["totale"] ?></strong></td>
										<td class="center"><strong><?php echo $book["booked"] ?></strong></td>
										<td class="center"><strong><?php echo $book["n_available"] ?></strong></td>
										<td style="width:230px;">
											<table style="border:1px solid #444;" class="statusdetails">
												<tr>
													<td class="n_confirmed"><?php if($book["n_confirmed"] > 0){ ?><a title="<?php echo date("d/m/Y",strtotime($book["datat"])) ?> - Confirmed bookings" class="opendetail" href="<?php echo base_url(); ?>index.php/backoffice/infoday2day/<?php echo $campus ?>/<?php echo $accomodation ?>/<?php echo $book["datat"] ?>/confirmed"><?php echo $book["n_confirmed"] ?></a><?php }else{ ?><?php echo $book["n_confirmed"] ?><?php } ?></td>
													<td class="n_active"><?php if($book["n_active"] > 0){ ?><a title="<?php echo date("d/m/Y",strtotime($book["datat"])) ?> - Active bookings" class="opendetail" href="<?php echo base_url(); ?>index.php/backoffice/infoday2day/<?php echo $campus ?>/<?php echo $accomodation ?>/<?php echo $book["datat"] ?>/active"><?php echo $book["n_active"] ?></a><?php }else{ ?><?php echo $book["n_active"] ?><?php } ?></td>
													<td class="n_tbc"><?php if($book["n_tbc"] > 0){ ?><a title="<?php echo date("d/m/Y",strtotime($book["datat"])) ?> - TBC bookings" class="opendetail" href="<?php echo base_url(); ?>index.php/backoffice/infoday2day/<?php echo $campus ?>/<?php echo $accomodation ?>/<?php echo $book["datat"] ?>/tbc"><?php echo $book["n_tbc"] ?></a><?php }else{ ?><?php echo $book["n_tbc"] ?><?php } ?></td>
													<td class="n_elapsed"><?php if($book["n_elapsed"] > 0){ ?><a title="<?php echo date("d/m/Y",strtotime($book["datat"])) ?> - Elapsed bookings" class="opendetail" href="<?php echo base_url(); ?>index.php/backoffice/infoday2day/<?php echo $campus ?>/<?php echo $accomodation ?>/<?php echo $book["datat"] ?>/elapsed"><?php echo $book["n_elapsed"] ?></a><?php }else{ ?><?php echo $book["n_elapsed"] ?><?php } ?></td>
												</tr>
											</table>
										</td>
										<td class="center" style="width:30px;">
										<?php if($book["n_confirmed"] > 0){ ?><a href="javascript:void(0);" class="allPaxList" id="od_<?php echo $book["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/edit-list-order.png"></a><?php }else{ ?>-<?php } ?>
										</td>
									</tr>
								<?php
									$daycount++;
								}
								?>
								</tbody>
							</table>	
						</div>
				</div>
			</div>	
		</section>	
		<div style="display: none;overflow:scroll;width:800px;" id="dialog_modal" title="Pax List | Booking detail  (Please set orientation to LANDSCAPE before print!)" class="windia"></div>				
		<input type="hidden" value="" name="hidDate" id="hidDate" />
		<input type="hidden" value="" name="typeForCsv" id="typeForCsv" />
	</div>
	<script src="http://plus-ed.com/vision_ag/js/jquery.printElement.min.js"></script>	
	<script>
	$(document).ready(function() {
		$( "li#bobooking" ).addClass("current");
		$( "li#bobooking a" ).addClass("open");		
		$( "li#bobooking ul.sub" ).css('display','block');	
		$( "li#bobooking ul.sub li#bobooking_3" ).addClass("current");	
		$('#centricampus').change(function(){
			$('#box_campus').submit();
		});		
		$('#accomodation_in').change(function(){
			$('#box_acco').submit();
		});	
		$('#month_in').change(function(){
			$('#box_month').submit();
		});	
		$('#year_in').change(function(){
			$('#box_year').submit();
		});
		$('.opendetail').click(function(e){
			e.preventDefault();
			var dialog1 = $("#dettDAY").dialog({ 
				autoOpen: false,
				width: 900,
				modal: true,
				title: $(this).attr("title")+" | <?php echo $campusname?> - <?php echo ucfirst($accomodationname)?> "
			});
			dialog1.load($(this).attr("href")).dialog('open');
		});
		$( ".windia" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				},{
					text: "Print",
					click: function() { $(".windia table").printElement(); }
				},{
					text: "Export as .csv",
					click: function() {
						var myHidDate = $("#hidDate").val();
						var myTypeForCsv = $("#typeForCsv").val();
						window.location.href = '<?php echo base_url(); ?>index.php/backoffice/csvArrivalPax/<?php echo $campus ?>/<?php echo $accomodation ?>/'+myHidDate+'/confirmed/'+myTypeForCsv;
					}
				}],
				height : 500,
				width: 800
		});
			
		$(".openDoorPaxList").click(function(){
				$("#hidDate").val('');
				$("#typeForCsv").val('arrival');
				$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];	
				$("#hidDate").val(bydate);
				$("#dialog_modal").load('<?php echo base_url(); ?>index.php/backoffice/infoday2dayArrivalPax/<?php echo $campus ?>/<?php echo $accomodation ?>/'+bydate+'/confirmed/arrival');
				return false;			
		});		

		$(".closeDoorPaxList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('departure');				
				$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];	
				$("#hidDate").val(bydate);				
				$( "#dialog_modal" ).load('<?php echo base_url(); ?>index.php/backoffice/infoday2dayArrivalPax/<?php echo $campus ?>/<?php echo $accomodation ?>/'+bydate+'/confirmed/departure');
				return false;			
		});	

		$(".allPaxList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('');				
				$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$("#hidDate").val(bydate);				
				$( "#dialog_modal" ).load('<?php echo base_url(); ?>index.php/backoffice/infoday2dayArrivalPax/<?php echo $campus ?>/<?php echo $accomodation ?>/'+bydate+'/confirmed/');
				return false;			
		});			
	});
	</script>	
<?php $this->load->view('plused_footer');?>
