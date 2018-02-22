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
		<?php 
		}
		?>		
	});
	</script>	

		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<h1 class="grid_12 margin-top no-margin-top-phone">Overview campus booking</h1>
			<div class="row">
			<form style="margin:10px;" id="box_campus" name="box_campus" action="<?php echo base_url(); ?>index.php/backoffice/overviewBookings" method="post">  
				<div class="grid_3">
					<div class="box">
						<div class="header">
							<h2>Select Campus</h2>
						</div>
						<div class="content" style="margin:10px;">
											<select name="centri" id="centricampus">
													<option <?if($campus=="all"){?>selected <?php }?>value="all">All campus</option>
											<?php
												 foreach($centri as $key=>$item){?>
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
							<h2>Select Agency</h2>
						</div>
						<div class="content" style="margin:10px;"> 
											<select name="agenzia_in" id="agenzia_in">
													<option <?php if($agenziefrom=="all"){?>selected <?php }?>value="all">All agencies</option>
											<?php
												 foreach($tutte_agenzie as $key=>$item){?>
												 <option <?php if($agenziefrom==$item['id']){?>selected <?php }?>value="<?php echo $item['id']?>"><?php echo $item['businessname']?></option>
											<?php 	 }
											?>
										</select> 		
						</div>
					</div>
				</div>
				<div class="grid_2">
					<div class="box">
						<div class="header">
							<h2>Select Status</h2>
						</div>
						<div class="content" style="margin:10px;">
									<select name="stato_in" id="stato_in">
										<option <?php if($statusfrom=="all"){?>selected <?php }?>value="all">All status</option>
										<option <?php if($statusfrom=="tbc"){?>selected <?php }?>value="tbc">To be confirmed</option>
										<option <?php if($statusfrom=="active"){?>selected <?php }?>value="active">Active</option>
										<option <?php if($statusfrom=="elapsed"){?>selected <?php }?>value="elapsed">Elapsed</option>
										<option <?php if($statusfrom=="rejected"){?>selected <?php }?>value="rejected">Rejected</option>
										<option <?php if($statusfrom=="confirmed"){?>selected <?php }?>value="confirmed">Confirmed</option>
									</select> 
						</div>
					</div>
				</div>	
				<div class="grid_2">
					<div class="box">
						<div class="header">
							<h2>Select Season</h2>
						</div>
						<div class="content" style="margin:10px;">
									<select name="season" id="season">
										<?php for($y=2014;$y<=date("Y")+1;$y++){ ?>
										<option <?php if($season==$y){?>selected <?php }?>value="<?php echo $y ?>">Summer <?php echo $y ?></option>
										<?php } ?>
									</select> 
						</div>
					</div>
				</div>					
				<div class="grid_1" style="text-align:center;padding-top:30px;">
					<input type="submit" name="inviaO" id="inviaO" value="Search" />
				</div>				
			</form>					
			</div>
            <div id="dialogNew" style="display:none;">
                <iframe id="myIframe" src=""></iframe>
            </div>
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
						<table class="dynamic styled" data-filter-bar='always' data-table-tools='{"display":false}' data-data-table='{"bPaginate":false,"aaSorting":[],"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
							<thead>
								<tr>
									<th>Booking ID<br>Weeks/Pax</th>
									<th>Campus</th>									
									<th>Agency</th>
									<th>Date in/out</th>								
									<th>Status</th>
									<th>Actions</th>
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
                                        <a class="dialogNewBtn" href="http://plus-ed.com/vision_ag/index.php/backoffice/newAvail/<?php echo $book["id_book"]?>" title="Booking Ref <?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" id="ref-<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>">-</a>
										<span class="idofbook"><?php echo $book["id_year"]?>_<?php echo $book["id_book"]?></span><br>
										<?php echo $book["weeks"]?>w / <?php echo $book["tot_pax"]?> pax<?php if($book["lockPax"]==1){ ?><i class="icon-lock" style="font-size:12px;margin-left:4px;color:#ff0000;"></i><?php } ?>
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
									<td><?php echo $book["centro"]?></td>									
									<td class="center"><?php echo $agdett["businessname"]?></td>
									<td class="center"><?php echo $da[2]?>/<?php echo $da[1]?>/<?php echo $da[0]?><br /><?php echo $dd[2]?>/<?php echo $dd[1]?>/<?php echo $dd[0]?></td>
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
									<a data-gravity="s" class="button small grey tooltip dialogbtn" href="javascript:void(0);" id="dialog_modal_btn_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" original-title="View details"><i class="icon-zoom-in" style="font-size:14px;"></i></a>
									<?php 
									if($book['status']!='confirmed' or $this->session->userdata('ruolo')=='superuser') {?>
									<br><a data-gravity="s" class="button small grey tooltip" href="<?php echo base_url(); ?>index.php/backoffice/take/<?php echo $book['id_book']; ?>" original-title="Edit reservation"><i class="icon-pencil" style="font-size:14px;"></i></a>
									<?php
									}
									?>
									<?php 
									if($this->session->userdata('ruolo')=='superuser') {
									?>
									<br><a data-gravity="s" class="button small <?php if($book["numNote"] > 0){ ?>red<?php } else { ?>grey<?php } ?> tooltip dialognote" href="javascript:void(0);" id="dialog_modal_note_<?php echo $book["id_year"]?>_<?php echo $book["id_book"]?>" original-title="View/Insert notes"><i class="icon-align-left" style="font-size:14px;"></i></a>
									<?php
									}
									?>									
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
<script>
$(document).ready(function(){
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

    $('a.dialogNewBtn').on('click', function(e){
        var diaH = $(window).height()* 0.8;
        e.preventDefault();
        $('<div/>', {'class':'myDlgClass', 'id':'link-'+($(this).index()+1)})
            .html($('<iframe/>', {
                'src' : $(this).attr('href'),
                'style' :'width:100%; height:100%;border:none;'
            })).appendTo('body')
            .dialog({
                'title' : 'Booking ' +$(this).attr('id')+ ' detail',
                'width' : '90%',
                'height' : diaH,
                modal: true,
                buttons: [ {
                    text: "Close",
                    click: function() { $( this ).dialog( "close" ); }
                } ]
            });
    });
	
})
</script>
<?php $this->load->view('plused_footer');?>
