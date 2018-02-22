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
		$( "li#bobooking" ).addClass("current");
		$( "li#bobooking a" ).addClass("open");		
		$( "li#bobooking ul.sub" ).css('display','block');	
		$( "li#bobooking ul.sub li#bobooking_2" ).addClass("current");	
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
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">Confirm cleared bookings</h1>
			<div class="grid_4">
				<div class="box">
					<div class="header">
						<h2>Select Campus</h2>
					</div>
					<div class="content">
							<form style="margin:10px;" id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/backoffice/overviewBookings" method="post">  
										<select name="centri" id="centricampus">
												<option <?if($campus=="all"){?>selected <?php }?>value="all">All campus</option>
										<?php
											 foreach($centri as $key=>$item){?>
											 <option <?if($campus==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['nome_centri']?></option>
										<?php 	 }
										?>
									</select> 
							<input type="hidden" name="date_in" value="<?php echo $datafrom;?>">  
							<input type="hidden" name="date_out" value="<?php echo $datato;?>">
							<input type="hidden" name="agenzia_in" value="<?php echo $agenziefrom;?>">  
							<input type="hidden" name="stato_in" value="<?php echo $statusfrom;?>">  
							</form>					
					</div>
				</div>
			</div>
			<div class="grid_4">
				<div class="box">
					<div class="header">
						<h2>Select Agency</h2>
					</div>
					<div class="content">
							<form style="margin:10px;" id="box_agency" name="box_agency" action="<?php echo base_url(); ?>index.php/backoffice/overviewBookings" method="post">  
										<select name="agenzia_in" id="agenzia_in">
												<option <?php if($agenziefrom=="all"){?>selected <?php }?>value="all">All agencies</option>
										<?php
											 foreach($tutte_agenzie as $key=>$item){?>
											 <option <?php if($agenziefrom==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['businessname']?></option>
										<?php 	 }
										?>
									</select> 
								  <input type="hidden" name="centri" value="<?php echo $campus;?>">
							<input type="hidden" name="date_in" value="<?php echo $datafrom;?>">  
							<input type="hidden" name="stato_in" value="<?php echo $statusfrom;?>">  
							</form>				
					</div>
				</div>
			</div>
			<div class="grid_4">&nbsp;</div>				
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Confirm cleared bookings</h2>
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
									<th>Booking ID</th>
									<th>Campus</th>									
									<th>Agency</th>
									<th>Date in/out</th>								
									<th>Weeks</th>
									<th>Pax</th>
									<th>Status</th>
									<th>Edit</th>
									<th>Outstanding</th>									
									<th>Deposit Inv.</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($all_books as $book){
								$da=explode("-",$book["arrival_date"]);
								$dd=explode("-",$book["departure_date"]);
								$accos=$book["all_acco"];
								$agdett=$book["agency"][0];
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
										?>
											<li><strong><?php echo $tipo ?>: </strong><?php echo $accom ?>(<?php echo $contot ?>)</li>
										<?php
											}
										?>
											</ul>
										</p>
									</div></td>
									<td><?php echo $book["centro"]?></td>									
									<td class="center"><?php echo $agdett["businessname"]?></td>
									<td class="center"><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?><br /><?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?></td>
									<td class="center"><?php echo $book["weeks"]?></td>
									<td class="center"><?php echo $book["tot_pax"]?></td>
									<td style="width:140px;" id="cell_<?php echo $book["id_book"]?>" class="col_stato center n_<?php echo $book["status"]?>">
										<?php if($book['status']!='confirmed' && $book['status']!='tbc' && $book['status']!='elapsed'){?>
											<form name="riga_<?php echo $book['id_book']; ?>" id="riga_<?php echo $book['id_book']; ?>" action="" method="POST">
											<select class="change_status" name="status_<?php echo $book['id_book']; ?>" id="status_<?php echo $book['id_book']; ?>">
												<option<?php if($book['status']=='rejected'){?> selected<?php }?> value="rejected">Rejected</option>
												<option<?php if($book['status']=='active'){?> selected<?php }?> value="active">Active</option>
												<?php if($book['can_confirm']!=0){?>
												<option<?php if($book['status']=='confirmed'){?> selected<?php }?> value="confirmed">Confirmed</option>			
												<?php }?>
											</select>
											<?php if($book['status']=='active'){?>
												<br /><span class="date_until">Until <?php echo date('d/m/Y',strtotime($book['data_scadenza']))?></span>
											<?php }?>
											</form>
										<?php }else{?>
											<?php	if($book['status']=='confirmed'){
												?>
													<div id="me_rejected_<?php echo $book['id_book']; ?>">Confirmed</div>
													<?php if($this->session->userdata('ruolo')=='superuser'){?>
													<div id="me_nobutton_<?php echo $book['id_book']; ?>"><input type="button" name="reject_<?php echo $book['id_book']; ?>" class="rejectme" id="reject_<?php echo $book['id_book']; ?>" value="Reject" /></div>
													<?php }else{?>
													<div>&nbsp;</div>
													<?php }?>
										<?php 		}else{
													if($book['status']=='elapsed'){?>
												<div id="id_elapsed_<?php echo $book['id_book']; ?>">Elapsed - <?php echo date('d/m/Y',strtotime($book['data_scadenza']))?></div>
												<div id="hide_me_<?php echo $book['id_book']; ?>">
													<input style="width:70px;" id="elapsed_<?php echo $book['id_book']; ?>" class="tbc-date" data-date-format="dd-mm-yy" type="date" name="date_to_tbc_<?php echo $book['id_book']; ?>" value="Set date"><input class="setdate_button" name="bt_elapsed_<?php echo $book['id_book']; ?>" id="bt_elapsed_<?php echo $book['id_book']; ?>" type="button" value="Set" style="margin-left:10px;"></div>
										<?php		}else{?>
												<div id="id_tbc_<?php echo $book['id_book']; ?>">To be confirmed</div>
												<div id="hide_me_<?php echo $book['id_book']; ?>">
													<input style="width:70px;" id="tbc_<?php echo $book['id_book']; ?>" class="tbc-date" data-date-format="dd-mm-yy" type="date" name="date_to_tbc_<?php echo $book['id_book']; ?>" value="Set date"><input class="setdate_button" name="bt_tbc_<?php echo $book['id_book']; ?>" id="bt_tbc_<?php echo $book['id_book']; ?>" type="button" value="Set" style="margin-left:10px;"></div>
										<?php			}
												}?>
										<?php  }?>									
									</td>
									<td class="center">
									<?php 
									if($book['status']!='confirmed' or $this->session->userdata('role')=='superuser') {?>
									<a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/take/<?php echo $book['id_book']; ?>" original-title="Edit reservation"><i class="icon-pencil"></i></a>
									<?php
									}else{?>
									-
									<?php
									}
									?>
									</td>
									<?php
										$costocampus=$book['valore_acconto'];
										$coloreout = "#0c0;";
										if($book['tot_pax']*$costocampus > $book['acconto_versato'])
											$coloreout = "#c00;";
									?>
									<td class="center">Due: <?php echo $book['tot_pax']*$costocampus; ?> <?php echo $book['valuta']?><br />Payed: <font style="font-weight:bold;color:<?php echo $coloreout ?>"><?php echo $book['acconto_versato']?></font> <?php echo $book['valuta']?></td>
									<td class="pdf-create-payed"><a target="_blank" href= "<?php echo base_url(); ?>index.php/backoffice/invoice_pdf/<?php echo $book ['id_book']; ?>" title="Print Deposit Invoice"><span>Print Deposit Invoice</span></a></td>
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
$(document).ready(function(){
	$('#centricampus').change(function(){
		$('#loading-data').show();
		$('#box_campus').submit();
	});
	$('#agenzia_in').change(function(){
		$('#loading-data').show();
		$('#box_agency').submit();
	});
	$('#stato_in').change(function(){
		$('#loading-data').show();
		$('#box_status').submit();
	});
	$('.setdate_button').click(function(){
		var dtts_arr = $(this).attr("id").split("_");
		var dtts = "#"+dtts_arr[1]+"_"+dtts_arr[2];
		if($(dtts).val()!="Set date"){
			//alert($(dtts).val());
			//alert(dtts_arr[1]);
			var id_record = dtts_arr[2];
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/backoffice/change_booking_status/"+id_record+"/active/"+$(dtts).val()+"",
				success: function(html){
					$("#hide_me_"+id_record).hide();
					$("#cell_"+id_record).removeClass("n_tbc").removeClass("n_elapsed").addClass("n_active");
					$("#id_"+dtts_arr[1]+"_"+id_record).html("Active<br>Until "+$(dtts).val().replace("-","/").replace("-","/"));
				}
			});
		}
	});	
 	$('.rejectme').click(function() {
		arr_record=$(this).attr("name").split("_");
		id_record=arr_record[1];
		//alert(id_record);
		nuovostato="rejected";
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/backoffice/change_booking_status/"+id_record+"/"+nuovostato+"",
			success: function(html){
				$("#me_nobutton_"+id_record).hide();			
				$("#cell_"+id_record).removeClass("n_confirmed").addClass("n_rejected");
				$("#me_rejected_"+id_record).html("Rejected");
			}
		});
	});	
 	$('.change_status').change(function() {
		//alert("change");
		arr_record=$(this).attr("name").split("_");
		id_record=arr_record[1];
		nuovostato=$(this).val();
		//alert(nuovostato);
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/backoffice/change_booking_status/"+id_record+"/"+nuovostato+"",
			success: function(html){
				$("#cell_"+id_record).removeClass("n_confirmed").removeClass("n_rejected").removeClass("n_active").addClass("n_"+nuovostato);
			}
		});
	});	
	
 	$('.edit-extragl').blur(function() {
		arr_record=$(this).attr("name").split("-");
		id_record=arr_record[1];
		nuovostato=$(this).val();
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/backoffice/change_extragl_value/"+id_record+"/"+$(this).val()+"",
			success: function(html){
				$("#extragl-"+id_record).css("backgroundColor","#00ff44");
			}
		});
	});	
	
})
</script>
<?php $this->load->view('plused_footer');?>
