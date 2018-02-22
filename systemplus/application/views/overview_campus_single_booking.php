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
		$( "li#bobooking ul.sub li#bobooking_1" ).addClass("current");	
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
		<?php 
		if($this->session->userdata('ruolo')=='superuser') {
		?>		
		$( ".notedia" ).dialog({
				autoOpen: false,
				modal: true,
				width: 600,
				height: 450,
				buttons: [{
					text: "Submit",
					click: function(e) {
						e.preventDefault();
						if($("#notatxt").val()==""){
							alert("Please fill the note field!");
						}else{
						var nPublic = 0;
						if($("#publicNote").prop('checked')){
							nPublic = 1
						}
						$.post("<?php echo base_url(); ?>index.php/backoffice/insertBkNote/"+$("#thisBk").val()+"", { testo: $("#notatxt").val(), utente: "<?php echo $this->session->userdata('mainfamilyname')?>", notaPubblica: nPublic })
						.done(function(data) {
							$( ".notedia" ).dialog("close");
							alert("Note has been inserted correctly!");
						});

						}
					}
				},{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}]
		});		
		$( ".dialognote" ).click(function() {
				$("#notatxt").val("");
				$("#thisBk").val("");
				$("#oldNotes").val("");
				$("#publicNote").prop('checked', false);
				var idnota = $(this).attr("id").split("note_");
				var justid = idnota[1].split("_");
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/backoffice/readBookingNotes/"+justid[1]+"",
					success: function(html){
						$("#oldNotes").val(html);
					}
				});
				$( "#note_modal" ).dialog("option", "title", "Insert note for Booking "+idnota[1]);
				$("#thisBk").val(justid[1]);
				$( "#note_modal" ).dialog("open");
				return false;
		});	
$( ".windiaList" ).dialog({
				autoOpen: false,
				modal: true,
				width: screen.width-40,
				height: 500,
				maxWidth: screen.width-40,
				maxHeight: 500,
				buttons: [{
					text: "Close and save draft",
					click: function() { 
							$("#noChanges").val("NOSEND");
							$(this).dialog().find("#postaPax").submit(); 
					}
				},{
					text: "Close and send data (No more changes allowed!)",
					class: "buttonSendPax",
					click: function() { 
							var campiVuoti = 0;	
							$(".reqField").each(function(){
								if($(this).val().length==0){
									//alert($(this).attr("id"));
									campiVuoti++;
								}
							});	
							if(campiVuoti==0){
								if(confirm("Are you sure you want to confirm pax data? No more changes will be allowed after you send them!")){					
									$("#noChanges").val("SEND");
									$(this).dialog().find("#postaPax").submit(); 
								}else{
									return void(0);
								}
							}else{
									alert("Please fill-in all fields in the roster! ("+campiVuoti+" more fields needed)");	
									return void(0);
							}
					}
				},{
					text: "Copy Common Data from first line",
					click: function() { $("#copyFirst").trigger("click"); }
				}]
		});		
		<?php 
		}
		?>		
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">Overview campus booking</h1>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Overview campus booking</h2>
					</div>
		
					<div class="content">
						<div class="tabletools">
							<div class="left">
							</div>
							<div class="right">								
							</div>
						</div>
						<?php 
						if($this->session->userdata('ruolo')=='superuser') {
						?>						
						<div style="display: none;" id="note_modal" title="Insert note for Booking" class="notedia">
							<div class="row">
										<label for="notatxt">
											<strong>Note</strong>
										</label>
										<div>
											<textarea class="nogrow" name="notatxt" id="notatxt" rows="6" style="width:100%;"></textarea>
											<input type="hidden" name="thisBk" id="thisBk" value="" />
										</div>
							</div>
							<div class="row">
										<label for="publicNote">
											<strong>Note is public</strong>
										</label>
										<div>
											<input type="checkbox" value="yes" name="publicNote" id="publicNote" />
										</div>
							</div>		
							<hr />
							<div class="row">
										<label for="oldNotes">
											<strong>Old Notes</strong>
										</label>
										<div>
											<textarea class="nogrow" name="oldNotes" id="oldNotes" rows="6" style="width:100%;"></textarea>
										</div>
							</div>							
						</div>
						<?php 
						}
						?>						
						<table class="styled"> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Booking Ref.</th>																
									<th>Status</th>
									<th>Deposit Inv.</th>
									<th>Full Inv.</th>
									<th>Visa</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								//print_r($all_books);
								foreach($all_books as $book){
								$da=explode("-",$book["arrival_date"]);
								$dd=explode("-",$book["departure_date"]);
								$accos=$book["all_acco"];
								$agdett=$book["agency"][0];
							?>
								<tr>
									<td class="center">
										<span class="idofbook" style="font-size:16px;">
											<?php
											if($book['status']!='confirmed' or $this->session->userdata('ruolo')=='superuser') {
											?>
											<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>@<?php echo $book["centro"]?>
											<a data-gravity="s" id="compile_<?php echo $book ['id_year']; ?>_<?php echo $book ['id_book']; ?>" class="small tooltip insertPaxList" href="javascript:void(0);" original-title="Edit booking details" style="margin-left:0;"><i class="icon-edit" style="font-size:16px;margin-left:4px;color:#1148ff;"></i></a>
											<?php
											}else{
											echo $book["id_year"]?>_<?php echo $book["id_book"]?>@<?php echo $book["centro"];
											}
											if($book["lockPax"]==1){ ?><i original-title="Roster locked" data-gravity="s" class="icon-lock tooltip" style="font-size:16px;margin-left:4px;color:#ff0000;"></i><?php 
											}
											?>
											<a data-gravity="s" class="small tooltip dialogbtn" href="javascript:void(0);" id="dialog_modal_btn_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" original-title="View accomodation details"><i class="icon-user" style="font-size:16px;margin-left:4px;color:#1148ff;"></i></a>
											<?php
											if($this->session->userdata('ruolo')=='superuser') {
											?>
											<a data-gravity="s" class="small tooltip dialognote" href="javascript:void(0);" id="dialog_modal_note_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" original-title="View/Insert notes"><i class="icon-align-left" style="font-size:14px;margin-left:4px;color:#000;"></i></a>
											<?php
											}
											?></span><br />
											<span class="idofbook" style="font-size:14px;float:none;"><img style="margin-top:-1px;" class="lilFlag" src="<?php echo base_url(); ?>img/flags/16/<?php echo $agdett["businesscountry"]?>.png" alt="<?php echo $agdett["businesscountry"]?>" title="<?php echo $agdett["businesscountry"]?>" /><?php echo $agdett["businessname"]?></span> - <?php echo $book["weeks"]?>w / <?php echo $book["tot_pax"]?> pax<br /><i class="icon-arrow-down" style="font-size:12px;margin-right:4px;color:#090;"></i><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?><i class="icon-arrow-up" style="font-size:12px;margin-left:20px;margin-right:4px;color:#c00;"></i><?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?>
										
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
										</div>
									</td>							
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
									<?php
									if($book['status']!='active' and $book['status']!='confirmed'){?>
									<td class="center">-</td>
									<?php 
									}else{
										if($book['acconto_versato'] > 0) {?>
											<td class="pdf-create-payed"><a target="_blank" href= "<?php echo base_url(); ?>index.php/backoffice/invoice_pdf/<?php echo $book ['id_book']; ?>" title="Print Deposit Invoice"><span>Print Deposit Invoice</span></a></td>
										<?php
										}else{
											if($book['print_1'] > 0) {?>	
											<td class="pdf-create-printed"><a target="_blank" href= "<?php echo base_url(); ?>index.php/backoffice/invoice_pdf_no_acconto/<?php echo $book ['id_book']; ?>" title="Print Deposit Invoice"><span>Print Deposit Invoice</span></a></td>
											<?php
											}else{?>
											<td class="pdf-create"><a target="_blank" href= "<?php echo base_url(); ?>index.php/backoffice/invoice_pdf_no_acconto/<?php echo $book ['id_book']; ?>" title="Print Deposit Invoice"><span>Print Deposit Invoice</span></a></td>
											<?php
											}?>
										<?php
										}?>
									<?php }?>
<?php
				if($book['acconto_versato'] > 0) {?>
				<td>
				<table class="group pdfTable">
				<?php
					if($book['saldo_versato'] > 0) {?>
						<tr><td class="pdf-create-payed"><a target="_blank" href= "<?php echo base_url(); ?>index.php/gestione_centri/invoice_pdf_no_saldo/<?php echo $book ['id_book']; ?>" title="Print Final Invoice"><span>Print Final Invoice</span></a></td></tr>
						<?php /*
						<!--<tr><td style="text-align:center;"><input class="edit-extragl" type="text" name="extragl-<?php echo $book['id']?>" id="extragl-<?php echo $book['id']?>" value="<?php echo $book['extragl']*1; ?>" /><span style="display:block"><?php echo $book['valuta']?></span></td></tr>--> */ ?>
					<?php
					}else{
						if($book['print_2'] > 0) {?>	
						<tr><td class="pdf-create-printed"><a target="_blank" href= "<?php echo base_url(); ?>index.php/gestione_centri/invoice_pdf_no_saldo/<?php echo $book ['id_book']; ?>" title="Print Final Invoice"><span>Print Final Invoice</span></a></td></tr>
						<?php //sostituito nel name id con id_book ??? ?>
						<tr><td class="last_td"><input class="edit-extragl" type="text" name="extragl-<?php echo $book['id_book']?>" id="extragl-<?php echo $book ['id_book']; ?>" value="<?php echo $book['extragl']*1; ?>" /><span class="valutaOver"><?php echo $book['valuta']?></span></td></tr>
						<?php
						}else{?>
						<tr><td class="pdf-create"><a target="_blank" href= "<?php echo base_url(); ?>index.php/gestione_centri/invoice_pdf_no_saldo/<?php echo $book ['id_book']; ?>" title="Print Final Invoice"><span>Print Final Invoice</span></a></td></tr>
						<tr><td class="last_td"><input class="edit-extragl" type="text" name="extragl-<?php echo $book ['id_book']; ?>" id="extragl-<?php echo $book ['id_book']; ?>" value="<?php echo $book['extragl']*1; ?>" /><span class="valutaOver"><?php echo $book['valuta']?></span></td></tr>
						<?php
						}?>
					<?php
					}?>
					</tr>
				</table>
				</td>
				<?php
				}else{?>
						<td class="center">-</td>
				<?php
				}?>
						<?php if($book ['lockPax']==1){ ?>
							<td class="pdf-visa"><a data-gravity="s" class="button small grey tooltip" target="_blank" href="<?php echo base_url(); ?>index.php/backoffice/pdf_visas/<?php echo $book['id_book']; ?>" id="print_dialog_modal_btn_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" original-title="Print VISA"><i class="icon-print" style="font-size:14px;"></i></a><br /><br /><input type="checkbox" class="dwnVISA" name="dwnVisa_<?php echo $book['id_book']; ?>" id="dwnVisa_<?php echo $book['id_book']; ?>" <?php if($book['downloadVisa']==1){ ?>checked<?php } ?>></td>
						<?php } else { ?>
							<td class="center">-</td>
						<?php } ?>
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
	<?php
		if($book['status']!='confirmed' or $this->session->userdata('ruolo')=='superuser') {
	?>
	<div style="overflow:scroll;" id="dialog_modal" title="Pax List | Booking detail" class="windiaList"></div>	
	<?php
		}
	?>	
<script>
$(document).ready(function(){

		$(".insertPaxList").click(function(e){
				e.preventDefault();
				$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
				var bytd = $(this).attr("id");
				var splitbytd = bytd.split("_");
				var idYear = splitbytd[1];	
				var idBook = splitbytd[2];
				$("#dialog_modal").load('<?php echo base_url(); ?>index.php/backoffice/amendmentBooking/'+idYear+'/'+idBook);
				return false;			
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
		if(confirm("Are you sure you want to reject this booking?")){
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/backoffice/change_booking_status/"+id_record+"/"+nuovostato+"",
			success: function(html){
				$("#me_nobutton_"+id_record).hide();			
				$("#cell_"+id_record).removeClass("n_confirmed").addClass("n_rejected");
				$("#me_rejected_"+id_record).html("Rejected");
			}
		});
		}else{
			return void(0);
		}
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
	
	$('.dwnVISA').change(function(){
		canDwn = 0;
		arr_record=$(this).attr("id").split("_");
		id_record=arr_record[1];		
		if($(this).attr("checked")=="checked"){
			canDwn = 1;
		}
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/backoffice/changeDownloadVisa/"+id_record+"/"+canDwn+"",
			success: function(html){
				if(canDwn==1){
					alert("Agent can now download VISA generated for this booking!");
				}else{
					alert("Agent can't download VISA generated for this booking anymore!");
				}
			}
		});
	});
	
})
</script>
<?php $this->load->view('plused_footer');?>
