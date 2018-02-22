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
?>		
		
		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">Campus trips & participants</h1>
			<form style="margin:10px;" id="searchAll" name="searchAll" action="<?php echo base_url(); ?>index.php/backoffice/new_reviewday2day_pax_new" method="post"> 
			<div class="grid_4">
				<div class="box">
					<div class="header">
						<h2>Select Campus</h2>
					</div>
					<div class="content" style="padding:10px;">  
										<select name="centri" id="centricampus">
										<?php
											 foreach($centri as $key=>$item){
											 //echo "<br />--->".$campus."---".$item['id']."<---";
											 ?>
											 <option <?if($campus==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?></option>
										<?php 	 }
										?>
									</select> 				
					</div>
				</div>
			</div>			
			<div class="grid_3">
				<div class="box">
					<div class="header">
						<h2>Select Month</h2>
					</div>
					<div class="content" style="padding:10px;">
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
					</div>
				</div>
			</div>	
			<div class="grid_3">
				<div class="box">
					<div class="header">
						<h2>Select Year</h2>
					</div>
					<div class="content" style="padding:10px;">
								<select name="year_in" id="year_in">
									<?php
									for($annino=2012;$annino<=date("Y");$annino++){
									?>
									<option <?php if($year==$annino){?>selected <?php }?>value="<?php echo $annino ?>"><?php echo $annino ?></option>
									<?php
									}
									?>
								</select> 								
					</div>
				</div>
			</div>	
			<div class="grid_2" style="text-align:center;">			
				<input type="button" name="inviaRic" id="inviaRic" value="Search" style="margin-top:30px" />
			</div>
			</form>
			<div class="grid_12">
				<div class="box">
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/calendar.png"><?php echo $campusname?> - <?php echo $monthnames[$month] ?> <?php echo $year ?></h2>
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
										<th style="width:30px;">Day</th>
										<th style="width:90px;">Date</th>
										<th style="width:50px;">In</th>
										<th style="width:50px;padding:8px;">Out</th>
										<th style="width:40px;">Standard</th>
										<th style="width:40px;">Ensuite</th>
										<th style="width:40px;">Homestay</th>
										<th style="width:40px;">Transfers</th>
										<th style="width:40px;">Planned</th>
										<th style="width:40px;">Extra</th>
										<th>On campus today</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									//print_r($num_transfers);
									$daycount = 1;
									foreach($bkgmesestandard as $key=>$book){
									$classeRiga = "riga_dispari";
									$octoday = 0;
									$da=explode("-",$book["datat"]);
									$dow = date ("l", strtotime($book["datat"]));
									$octoday += $book["n_confirmed"] + $bkgmeseensuite[$key]["n_confirmed"] + $bkgmesehomestay[$key]["n_confirmed"];
									if($daycount % 2){
										$classeRiga = "riga_pari";
									}
								?>
									<tr class="<?php echo $classeRiga ?>">
										<td class="center" style="width:30px;<?php if($dow=="Sunday"){ echo 'color:#c00;'; } ?>"><?php echo substr($dow,0,3)?></td>
										<td class="center" style="width:90px;<?php if($dow=="Sunday"){ echo 'color:#c00;'; } ?>"><?php echo $daycount?> <?php echo substr($monthnames[$month],0,3)?> <?php echo $da[0]?></td>
										<td class="center" style="width:50px;"><?php if($book["num_in"] > 0){ ?><a href="javascript:void(0);" class="openDoorPaxList" id="od_<?php echo $book["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/door-open-in_green.png"><span style="float:left;width:30px;text-align:center;"><?php echo $book["num_in"] ?></span></a><?php }else{ ?>&nbsp;<?php } ?></td>
										<td class="center" style="width:50px;"><?php if($book["num_out"] > 0){ ?><a href="javascript:void(0);" class="closeDoorPaxList" id="cd_<?php echo $book["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/door-open-out_red.png"><span style="float:left;width:30px;text-align:center;"><?php echo $book["num_out"] ?></span></a><?php }else{ ?>&nbsp;<?php } ?></td>
										<td class="center" style="width:60px;"><?php if($book["n_confirmed"] > 0){ ?><a title="<?php echo date("d/m/Y",strtotime($book["datat"])) ?> - Standard" class="openDayDetail" id ="opendetail_<?php echo $book["datat"] ?>_1" href="javascript:void(0);"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/user-medium.png"><span style="float:left;width:30px;text-align:center;"><?php echo $book["n_confirmed"] ?></span></a><?php }else{ ?>&nbsp;<?php } ?></td>
										<td class="center" style="width:60px;"><?php if($bkgmeseensuite[$key]["n_confirmed"] > 0){ ?><a title="<?php echo date("d/m/Y",strtotime($bkgmeseensuite[$key]["datat"])) ?> - Ensuite" class="openDayDetail" id ="opendetail_<?php echo $book["datat"] ?>_2" href="javascript:void(0);"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/user-share.png"><span style="float:left;width:30px;text-align:center;"><?php echo $bkgmeseensuite[$key]["n_confirmed"] ?></span></a><?php }else{ ?>&nbsp;<?php } ?></td>
										<td class="center" style="width:60px;"><?php if($bkgmesehomestay[$key]["n_confirmed"] > 0){ ?><a title="<?php echo date("d/m/Y",strtotime($bkgmesehomestay[$key]["datat"])) ?> - Homestay" class="openDayDetail" id ="opendetail_<?php echo $book["datat"] ?>_3" href="javascript:void(0);"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/home-medium.png"><span style="float:left;width:30px;text-align:center;"><?php echo $bkgmesehomestay[$key]["n_confirmed"] ?></span></a><?php }else{ ?>&nbsp;<?php } ?></td>
										<td class="center" style="width:60px;"><?php if($num_transfers[$key] > 0){ ?><a href="javascript:void(0);" class="TransfersPaxList" id="tra_<?php echo $book["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/transfer_plane.png"><span style="float:left;width:30px;text-align:center;"><?php echo $num_transfers[$key] ?></span></a><?php }else{ ?>&nbsp;<?php } ?></td>
										<td class="center" style="width:60px;"><?php if($num_excursions[$key] > 0){ ?><a href="javascript:void(0);" class="ExcursionsPaxList" id="exc_<?php echo $book["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bus_excursion.png"><span style="float:left;width:30px;text-align:center;"><?php echo $num_excursions[$key] ?></span></a><?php }else{ ?>&nbsp;<?php } ?></td>
										<td class="center" style="width:60px;"><?php if($num_extra_excursions[$key] > 0){ ?><a href="javascript:void(0);" class="ExtraExcursionsPaxList" id="excExtra_<?php echo $book["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bus_excursion.png"><span style="float:left;width:30px;text-align:center;"><?php echo $num_extra_excursions[$key] ?></span></a><?php }else{ ?>&nbsp;<?php } ?></td>
										<td class="center" style="width:90px;"><?php if($octoday > 0){ ?><a style="padding:0 5px;" href="javascript:void(0);" class="allPaxList tooltip" original-title="View students list" id="od_<?php echo $book["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/edit-list-order.png"></a><a style="padding:0 5px; "href="javascript:void(0);" class="allBookList tooltip"  original-title="View bookings list" id="od_<?php echo $book["datat"] ?>"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/applications-stack.png"></a><span style="float:left;width:30px;text-align:center;"><?php echo $octoday ?></span><?php }else{ ?>&nbsp;<?php } ?></td>
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
		<div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_tra" title="Transfers | Bus codes details" class="windia_tra"></div>						
		<div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_exc" title="Planned Excursions | Bus codes details" class="windia_exc"></div>					
		<div style="display: none;overflow:scroll;width:800px;" id="dialog_modal_exc_extra" title="Extra Excursions | Bus codes details" class="windia_exc_extra"></div>	
		<input type="hidden" value="" name="hidDate" id="hidDate" />
		<input type="hidden" value="" name="typeForCsv" id="typeForCsv" />
		<input type="hidden" value="" name="accoForCsv" id="accoForCsv" />
	</div>
	<script src="http://plus-ed.com/vision_ag/js/jquery.printElement.min.js"></script>	
	<script>
	$(document).ready(function() {
		$( "li#bocampus" ).addClass("current");
		$( "li#bocampus a" ).addClass("open");		
		$( "li#bocampus ul.sub" ).css('display','block');	
		$( "li#bocampus ul.sub li#bocampus_2" ).addClass("current");	

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
					text: "Export as Excel file",
					click: function() {
						var myHidDate = $("#hidDate").val();
						var myTypeForCsv = $("#typeForCsv").val();
						var myAccoForCsv = $("#accoForCsv").val();
						//alert('<?php echo base_url(); ?>index.php/backoffice/csvArrivalPax_pax/<?php echo $campus ?>/'+myAccoForCsv+'/'+myHidDate+'/confirmed/'+myTypeForCsv);
						window.location.href = '<?php echo base_url(); ?>index.php/backoffice/csvArrivalPax_pax/<?php echo $campus ?>/'+myAccoForCsv+'/'+myHidDate+'/confirmed/'+myTypeForCsv;
					}
				}],
				height : 500,
				width: 800
		});
		
		$( ".windia_tra" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}],
				height : 500,
				width: 800
		});		
		
		$( ".windia_exc" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}],
				height : 500,
				width: 800
		});	

		$( ".windia_exc_extra" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}],
				height : 500,
				width: 800
		});			
			
		$(".openDoorPaxList").click(function(){
				$("#hidDate").val('');
				$("#accoForCsv").val('all');	
				$("#typeForCsv").val('arrival');
				$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];	
				$("#hidDate").val(bydate);
				$("#dialog_modal").load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/'+bydate+'/confirmed/arrival/<?php echo $campus ?>');
				return false;			
		});		

		$(".closeDoorPaxList").click(function(){
				$("#hidDate").val('');	
				$("#accoForCsv").val('all');
				$("#typeForCsv").val('departure');				
				$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];	
				$("#hidDate").val(bydate);				
				$( "#dialog_modal" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/'+bydate+'/confirmed/departure/<?php echo $campus ?>');
				return false;			
		});	

		$(".allPaxList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('');	
				$("#accoForCsv").val('');				
				$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$("#hidDate").val(bydate);	
				$("#accoForCsv").val('all');				
				$( "#dialog_modal" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/all/'+bydate+'/confirmed/all/<?php echo $campus ?>');
				return false;			
		});	

		$(".openDayDetail").click(function(){
				$("#hidDate").val('');	
				$("#accoForCsv").val('all');	
				$("#typeForCsv").val('');				
				$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				//alert(bytd);
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$("#hidDate").val(bydate);	
				var byacco = splitbytd[2];
				$("#accoForCsv").val(byacco);
				//alert('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/'+splitbytd[2]+'/'+bydate+'/confirmed/');
				$( "#dialog_modal" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_infoday2dayArrivalPax_pax/'+splitbytd[2]+'/'+bydate+'/confirmed/all/<?php echo $campus ?>');
				return false;			
		});		

		$(".TransfersPaxList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('');	
				$("#accoForCsv").val('');				
				$("#dialog_modal_tra").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$( "#dialog_modal_tra" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_getTransfersBusCodesForDay/'+bydate+'/<?php echo $campus ?>');
				return false;			
		});	
		
		$(".ExcursionsPaxList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('');	
				$("#accoForCsv").val('');				
				$("#dialog_modal_exc").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$( "#dialog_modal_exc" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_getExcursionsBusCodesForDay/'+bydate+'/<?php echo $campus ?>');
				return false;			
		});		

		$(".ExtraExcursionsPaxList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('');	
				$("#accoForCsv").val('');				
				$("#dialog_modal_exc_extra").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$( "#dialog_modal_exc_extra" ).load('<?php echo base_url(); ?>index.php/backoffice/ca_getExtraExcursionsBusCodesForDay/'+bydate+'/<?php echo $campus ?>');
				return false;			
		});			
	
		
		$(".allBookList").click(function(){
				$("#hidDate").val('');	
				$("#typeForCsv").val('');	
				$("#accoForCsv").val('');				
				$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var bydate = splitbytd[1];
				$("#hidDate").val(bydate);	
				$("#accoForCsv").val('all');				
				$( "#dialog_modal" ).load('<?php echo base_url(); ?>index.php/backoffice/infoday2day/<?php echo $campus ?>/all/'+bydate+'/confirmed');
				return false;			
		});	

		$("#inviaRic").click(function(){
			$("#searchAll").submit();
		});
		
	});
	</script>	
<?php $this->load->view('plused_footer');?>
