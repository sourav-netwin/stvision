<?php $this -> load -> view('plused_header'); ?>
<style type="text/css">
	@media(max-width: 650px){
		.paxCol{
			height: 22px !important;
		}
		.depCol{
			height: 30px !important;
			vertical-align: middle;
		}
	}
</style>
<!-- The container of the sidebar and content box -->

<div role="main" id="main" class="container_12 clearfix">

	<!-- The blue toolbar stripe -->
	<section class="toolbar">
		<div class="user">
			<div class="avatar">
				<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
				<!-- Evidenziare per icone attenzione <span>3</span> -->
			</div>
			<span><? echo $this -> session -> userdata('businessname') ?></span>
			<ul>
				<li><a href="<?php echo base_url(); ?>index.php/agents/changeCredential">Profile</a></li>
				<li class="line"></li>
				<li><a href="<?php echo base_url(); ?>index.php/agents/logout">Logout</a></li>
			</ul>
		</div>
	</section><!-- End of .toolbar-->
	<?php $this -> load -> view('plused_sidebar'); ?>		
	<script>
		$(document).ready(function() {
			$( "li#bookings" ).addClass("current");
			$( "li#bookings a" ).addClass("open");		
			$( "li#bookings ul.sub" ).css('display','block');	
			$( "li#bookings ul.sub li#bookings_1" ).addClass("current");	
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
		});
	
	</script>	

	<!-- Here goes the content. -->
	<section id="content" class="container_12 clearfix" data-sort=true>
		<div class="grid_12">
			<div class="box">

				<div class="header">
					<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Bookings<a style="float:right;" href="<?php echo base_url(); ?>downloads/extras/guide_for_insert_list_vision.pdf" target="_blank" title="Guide for insert pax list"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/information-button.png" class="icon">How to insert your pax lists</a></h2>
				</div>

				<div class="content">
					<div class="tabletools">
						<div class="left">
							<a class="open-add-client-dialog" href="<?php echo base_url(); ?>index.php/agents/enrol"><i class="icon-plus"></i>Enrol new group</a>
						</div>
						<div class="right">								
						</div>
					</div>
					<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[6,"asc"]],"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},null,{"bSearchable": true,"bSortable": false},null,{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
						<thead>
							<tr>
                                                            <th>Booking ID</th>
                                                            <th>Date in</th>								
                                                            <th>Date Out</th>
                                                            <th>Weeks</th>
                                                            <th>Campus</th>
                                                            <th>Pax</th>
                                                            <th>Status</th>
                                                            <th class="depCol">Deposit invoice</th>	
                                                            <th class="paxCol">Pax list</th>
                                                            <th>VISA</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($all_books as $book) {
								$da = explode("-", $book["arrival_date"]);
								$dd = explode("-", $book["departure_date"]);
								$ds = explode("-", $book["data_scadenza"]);
								$accos = $book["all_acco"];
								?>
								<tr>
									<td class="center"><a href="javascript:void(0);" id="dialog_modal_btn_<?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?>" class="dialogbtn">[View]</a> <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?>
										<div style="display: none;" id="dialog_modal_<?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?>" title="Booking detail - <?php echo $book["id_year"] ?>_<?php echo $book["id_book"] ?> - <?php echo $book["centro"] ?>" class="windia">
											<p><strong>Date in: </strong><?php echo $da[2] ?>/<?php echo $da[1] ?>/<?php echo $da[0] ?><br /><strong>Date out: </strong><?php echo $dd[2] ?>/<?php echo $dd[1] ?>/<?php echo $dd[0] ?></p>
											<p><strong>Weeks: </strong><?php echo $book["weeks"] ?></p>
											<p><strong>Accommodations</strong></p>
											<p>
											<ul>
												<?php
												foreach ($accos as $acco) {
													$tipo = $acco -> tipo_pax;
													$accom = $acco -> accomodation;
													$contot = $acco -> contot;
													//print_r($acco);
													?>
													<li><strong><?php echo $tipo ?>: </strong><?php echo $accom ?>(<?php echo $contot ?>)</li>
													<?php
												}
												?>
											</ul>
											</p>
										</div></td>
									<td class="center"><?php echo $da[2] ?>/<?php echo $da[1] ?>/<?php echo $da[0] ?></td>
									<td class="center"><?php echo $dd[2] ?>/<?php echo $dd[1] ?>/<?php echo $dd[0] ?></td>
									<td class="center"><?php echo $book["weeks"] ?></td>
									<td><?php echo $book["centro"] ?></td>
									<td class="center"><?php echo $book["tot_pax"] ?></td>
									<?php
									switch ($book["status"]) {
										case 'tbc':
											$statob = "To be confirmed";
											break;
										default:
											$statob = ucfirst($book["status"]);
											break;
									}
									?>
									<td class="n_<?php echo $book["status"] ?>"><?php echo $statob ?><?php if ($book["status"] == "active") { ?> until <?php echo isset($ds[2]) ? $ds[2] : '' ?>/<?php echo isset($ds[1]) ? $ds[1] : '' ?>/<?php echo isset($ds[0]) ? $ds[0] : '' ?><?php } ?></td>
									<?php if ($book['status'] != 'active' and $book['status'] != 'confirmed') { ?>
										<td class="center depCol">-</td>
										<?php
									}
									else {
										if ($book['acconto_versato'] > 0) {
											?>
											<td class="pdf-create-payed center depCol"><a target="_blank" href= "<?php echo base_url(); ?>index.php/agents/invoice_pdf/<?php echo $book ['id_book']; ?>" title="Print Deposit Invoice"><span>Print Deposit Invoice</span></a></td>
											<?php
										}
										else {
											if ($book['print_1'] > 0) {
												?>	
												<td class="pdf-create-printed center depCol"><a target="_blank" href= "<?php echo base_url(); ?>index.php/agents/invoice_pdf_no_acconto/<?php echo $book ['id_book']; ?>" title="Print Deposit Invoice"><span>Print Deposit Invoice</span></a></td>
												<?php }
											else {
												?>
												<td class="pdf-create center depCol"><a target="_blank" href= "<?php echo base_url(); ?>index.php/agents/invoice_pdf_no_acconto/<?php echo $book ['id_book']; ?>" title="Print Deposit Invoice"><span>Print Deposit Invoice</span></a></td>
												<?php }
											?>
												<?php }
											?>
										<?php } ?>
									<td class="center paxCol">
										<?php
										if ($book['status'] == 'confirmed') {
											if ($book['lockPax'] == 0) {
												?>
												<a data-gravity="s" id="compile_<?php echo $book ['id_year']; ?>_<?php echo $book ['id_book']; ?>" class="button small grey tooltip insertPaxList" data-href="<?php echo base_url(); ?>index.php/agents/editPaxList/<?php echo $book ['id_year']; ?>/<?php echo $book ['id_book']; ?>" original-title="Insert pax details" style="margin-left:0;"><i class="icon-th-list"></i></a>
												<?php /* <a target="_blank" data-gravity="s" id="compile_<?php echo $book ['id_year']; ?>_<?php echo $book ['id_book']; ?>" class="button small grey tooltip insertPaxList" href="<?php echo base_url(); ?>index.php/agents/editPaxList/<?php echo $book ['id_year']; ?>/<?php echo $book ['id_book']; ?>" original-title="Insert pax details" style="margin-left:0;"><i class="icon-th-list"></i></a> */ ?>
												<?php
											}
											else {
												?>
												<img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/tick-button.png" class="icon">
												<?php
											}
										}
										else {
											echo "-";
										}
										?>									
									</td>
										<td class="center">	

											<a href="javascript:void(0)" title="Popup Details" class="visaPopup" data-id="<?php echo $book["id_book"] ?>" style="margin-left:0;"><span class="glyphicon glyphicon-new-window"></span></a>

										</td>
								</tr>
	<?php
}
?>
						</tbody>
					</table>
				</div><!-- End of .content -->
			</div><!-- End of .box -->
			<div class="right" style="border: none">	
				<?php
				$success_message = $this -> session -> flashdata('success_message');
				$error_message = $this -> session -> flashdata('error_message');
				if (!empty($success_message)) {
					?><div class="tuition_success"><?php echo $success_message; ?></div><?php
				}
				if (!empty($error_message)) {
					?><div class="tuition_error"><?php echo $error_message; ?></div><?php
				}
				?>
			</div>
			<div class="alert note sticky no-margin-bottom">
				<span class="icon"></span>
				<strong>Status label</strong>
				<ul class="legenda">
					<li><span class="li-tbc">To be confirmed</span>Your booking has been submitted and is waiting for confirmation by Head Office</li>
					<li><span class="li-active">Active</span>We have reserved spaces for your group and these will be valid until the expiration date shown</li>
					<li><span class="li-confirmed">Confirmed</span>Your booking is now confirmed and the deposit has being cleared</li>
					<li><span class="li-elapsed">Elapsed</span>No deposit was received before the expiration date given</li>
					<li><span class="li-rejected">Rejected</span>Your booking can not be accepted. Please contact a sales representative</li>
			</div>			
		</div><!-- End of .grid_12 -->



	</section><!-- End of #content -->

</div><!-- End of #main -->
<div style="overflow:scroll;" id="dialog_modal" title="Pax List | Booking detail" class="windiaList"></div>	
<?php
if ($bookId) {
	?>
	<?php
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click',".insertPaxList",function(e){
			e.preventDefault();
			var bytd = $(this).attr("id");
			var splitbytd = bytd.split("_");
			var idYear = splitbytd[1];	
			var idBook = splitbytd[2];
			$.ajax({
				url: siteUrl + 'agents/checkPaxLock',
				type: 'POST',
				data: {
					bookId: idBook,
					yearId: idYear
				},
				success: function(data){
					if(data == '1'){
						$("#dialog_modal").html('<img src="<?php echo base_url(); ?>img/jquery-ui/ajax-loader.gif" />').dialog("open");
							
						$("#dialog_modal").load('<?php echo base_url(); ?>index.php/agents/editPaxList/'+idYear+'/'+idBook);
						return false;	
					}
					else{
						alert('Roster locked. Can not modify records');
						return false;	
					}
				},
				error: function(){
					alert('Failed to complete action');
					return false;	
				}
			});
						
		});
	});
	$('.visaPopup').on('click', function(e){
		var elm = $(this);
		var bookId = elm.attr('data-id');
		if(bookId != '' && typeof bookId != 'undefined'){
			$.ajax({
				url: siteUrl + 'agents/bookingExists',
				type: 'POST',
				data: {
					bookId: bookId
				},
				success: function(response){
					if(response==1){
						var diaH = $(window).height()* 0.9;
						e.preventDefault();
						$('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(' + baseUrl + '/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
						.html($('<iframe/>', {
							'src' : siteUrl + "agents/getVisaPopupDetails/"+bookId,
							'style' :'width:100%; height:100%;border:none;'
						})).appendTo('body')
						.dialog({
							'title' : 'Bookings detail',
							'width' : '90%',
							'height' : diaH,
							modal: true,
							buttons: [ {
									text: "Close",
									click: function() { $( this ).dialog( "close" ); }
								} ]
						});
					}else{
						alert("This booking id doesn't exists!");
					}
				},
				error: function(){
					alert("This booking id doesn't exists!");
				}
			});
		}
	});
</script>
<?php $this -> load -> view('plused_footer'); ?>
