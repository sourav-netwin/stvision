<?php
$this -> load -> view('plused_header');

/**
 * @modified_by Arunsankar S
 * @date : 07-04-2016
 */
?>
<style type="text/css">
	@media(max-width: 767px){
		.grid_4{
			width: 98% !important;
		}
	}
	@media(max-width: 1099px){
		.searchBx{
			width: 98% !important;
			text-align: center;
		}
		.searchBtn{
			width: 98% !important;
			text-align: center;
			margin: 10px;
		}
	}
	@media(max-width: 650px){
		.box{
			margin: 10px;
		}
		.retrBtn{
			margin: 10px;
			text-align: center;
		}
		.btnSpc{
			text-align: center;
		}
		#inTktFltr{
			margin: 10px;
			float: none !important;
		}
		#resetForm{
			margin: 10px;
			float: right !important;
		}
	}
	#inTktFltr{
		float: right;
		margin-right: 5px;
	}
	#resetForm{
		float: right;
	}
	.glyphicon-share-alt{
		-moz-transform: scaleX(-1);
        -o-transform: scaleX(-1);
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
        filter: FlipH;
        -ms-filter: "FlipH";
	}
	.box{
		background: #fafafa !important;
	}
	.content{
		overflow: auto;
	}
	table.styled th{
		padding: 8px 20px !important;
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

	<?php
	$this -> load -> view('plused_sidebar');
	?>		

	<!-- Here goes the content. -->
	<section id="content" class="container_12 clearfix" data-sort=true>
		<h1 class="grid_12 margin-top no-margin-top-phone">Manage Tickets</h1>

		<div class="row">
			<form style="margin:10px;" id="box_tktFltr" name="box_tktFltr" action="<?php echo base_url(); ?>index.php/ticketmanagement#searchTable" method="post">  
				<div class="grid_12">
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
					<div class="box">
						<div class="header">
							<h2>Campus
								<span style="float:right;">
									<a href="javascript:void(0);" id="s_USA">USA</a> - 
									<a href="javascript:void(0);" id="s_UK">UK</a> - 
									<a href="javascript:void(0);" id="s_EUR">EUR</a> - 
									<a href="javascript:void(0);" id="s_all">All</a> - 
									<a href="javascript:void(0);" id="s_none">None</a>
								</span>
							</h2>
						</div>
						<div class="content" style="padding:10px;">
							<div class="grid_3">
								<?php
								$contaCentri = 0;
								foreach ($centri as $key => $item) {
									?>
									<input type="checkbox" <?php echo in_array($item['id'], $campuses) ? 'checked' : ''; ?> class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="centri[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?><br />
									<?php
									$contaCentri++;
									if ($contaCentri % 5 == 0) {
										?>
									</div>
									<div class="grid_3">
										<?php
									}
								}
								?>	
							</div>
						</div>
					</div>
				</div>
				<div class="grid_12">
					<div class="box">
						<div class="header">
							<h2>Category
								<span style="float:right;">
									<a href="javascript:void(0);" id="ct_all">All</a> - 
									<a href="javascript:void(0);" id="ct_none">None</a>
								</span></h2>
						</div>
						<div class="content" style="padding:10px;">

							<div class="grid_3">
								<input class="chCategory" <?php echo in_array('HEALTH & SAFETY', $categories) ? 'checked' : ''; ?> type="checkbox" name="category[]" id="s_healthsafety" value="HEALTH & SAFETY">HEALTH & SAFETY<br />
								<input class="chCategory" <?php echo in_array('ATTRACTION', $categories) ? 'checked' : ''; ?> type="checkbox" name="category[]" id="s_attraction" value="ATTRACTION">ATTRACTION<br />
								<input class="chCategory" <?php echo in_array('BULLYING', $categories) ? 'checked' : ''; ?> type="checkbox" name="category[]" id="s_bullying" value="BULLYING">BULLYING<br />
								<input class="chCategory" <?php echo in_array('CUSTOMER CARE', $categories) ? 'checked' : ''; ?> type="checkbox" name="category[]" id="s_customercare" value="CUSTOMER CARE">CUSTOMER CARE<br />
								<input class="chCategory" <?php echo in_array('FACILITIES', $categories) ? 'checked' : ''; ?> type="checkbox" name="category[]" id="s_facilities" value="FACILITIES">FACILITIES<br />
							</div>
							<div class="grid_3">

								<input class="chCategory" <?php echo in_array('TRANSPORTATION', $categories) ? 'checked' : ''; ?> type="checkbox" name="category[]" id="s_transportaion" value="TRANSPORTATION">TRANSPORTATION<br />
								<input class="chCategory" <?php echo in_array('CATERING', $categories) ? 'checked' : ''; ?> type="checkbox" name="category[]" id="s_catering" value="CATERING">CATERING<br />
								<input class="chCategory" <?php echo in_array('HOME STAY', $categories) ? 'checked' : ''; ?> type="checkbox" name="category[]" id="s_homestay" value="HOME STAY">HOME STAY<br />
								<input class="chCategory" <?php echo in_array('ACTIVITY ON CAMPUS', $categories) ? 'checked' : ''; ?> type="checkbox" name="category[]" id="s_avtivityoncampus" value="ACTIVITY ON CAMPUS">ACTIVITY ON CAMPUS<br />
								<input class="chCategory" <?php echo in_array('PLUS STAFF', $categories) ? 'checked' : ''; ?> type="checkbox" name="category[]" id="s_plusstaff" value="PLUS STAFF">PLUS STAFF<br />

							</div>
						</div>
					</div>	
				</div>
				<div class="grid_3">
					<div class="box">
						<div class="header">
							<h2>Priority
								<span style="float:right;">
									<a href="javascript:void(0);" id="bk_all">All</a> - 
									<a href="javascript:void(0);" id="bk_none">None</a>
								</span>
							</h2>
						</div>
						<div class="content" style="padding:10px;height:68px;">
							<input class="chPriority" <?php echo in_array('low', $priorities) ? 'checked' : ''; ?> type="checkbox" name="priority[]" id="s_low" value="low"><span style="color:#05ca05">Low</span><br />
							<input class="chPriority" <?php echo in_array('medium', $priorities) ? 'checked' : ''; ?> type="checkbox" name="priority[]" id="s_medium" value="medium"><span style="color:#d0c100">Medium</span><br />
							<input class="chPriority" <?php echo in_array('high', $priorities) ? 'checked' : ''; ?> type="checkbox" name="priority[]" id="s_high" value="high"><span style="color:#FF0000">High</span><br />
						</div>
					</div>
				</div>	
				<div class="grid_3">
					<div class="box">
						<div class="header">
							<h2>Ticket status</h2>
						</div>
						<div class="content" style="padding:10px;height:68px;">
							<input class="chStatus" <?php echo in_array(0, $status) ? 'checked' : ''; ?> type="checkbox" name="status[]" id="s_open" value="0"><span style="color:#05ca05">Open</span><br />
							<input class="chStatus" <?php echo in_array(1, $status) ? 'checked' : ''; ?> type="checkbox" name="status[]" id="s_closed" value="1"><span style="color:#FF0000">Closed</span><br />
						</div>
					</div>
				</div>	
				<div class="grid_3">
					<div class="box">
						<div class="header">
							<h2>Hours passed since received</h2>
						</div>
						<div class="content" id="selHourDiv" style="padding:10px;height:68px;">
							<select id="selHours" name="selHours">
								<option value="">All</option>
								<option <?php echo $hour == 1 ? 'selected="selected"' : ''; ?> value="1">1 Hour</option>
								<option <?php echo $hour == 2 ? 'selected="selected"' : ''; ?> value="2">2 Hours</option>
								<option <?php echo $hour == 3 ? 'selected="selected"' : ''; ?> value="3">3 Hours</option>
								<option <?php echo $hour == 4 ? 'selected="selected"' : ''; ?> value="4">4 Hours</option>
								<option <?php echo $hour == 5 ? 'selected="selected"' : ''; ?> value="5">5 Hours</option>
								<option <?php echo $hour == 6 ? 'selected="selected"' : ''; ?> value="6">6 Hours</option>
								<option <?php echo $hour == 7 ? 'selected="selected"' : ''; ?> value="7">7 Hours</option>
								<option <?php echo $hour == 8 ? 'selected="selected"' : ''; ?> value="8">8 Hours</option>
								<option <?php echo $hour == 9 ? 'selected="selected"' : ''; ?> value="9">9 Hours</option>
								<option <?php echo $hour == 10 ? 'selected="selected"' : ''; ?> value="10">10 Hours</option>
								<option <?php echo $hour == 11 ? 'selected="selected"' : ''; ?> value="11">11 Hours</option>
								<option <?php echo $hour == 12 ? 'selected="selected"' : ''; ?> value="12">12 Hours</option>
								<option <?php echo $hour == 24 ? 'selected="selected"' : ''; ?> value="24">24 Hours</option>
								<option <?php echo $hour == 48 ? 'selected="selected"' : ''; ?> value="48">48 Hours</option>
								<option <?php echo $hour == 49 ? 'selected="selected"' : ''; ?> value="49">More than 48 hours</option>
							</select>
						</div>
					</div>	
				</div>
				<div class="grid_3">
					<div class="box">
						<div class="header">
							<h2>Date Filed</h2>
						</div>
						<div class="content" style="margin:10px;text-align:center;height:68px;">
							<input type="text" readonly id="dateFiled" name="dateFiled" value="<?php echo $dateFiled ? $dateFiled : '' ?>" style="cursor:pointer;" />
						</div>
					</div>
				</div>	
				<!--<div class="grid_3">
					<div class="box">
						<div class="header">
							<h2>Days passed since received</h2>
						</div>
						<div class="content" style="margin:10px;text-align:center;height:68px;">
							<input type="text" onkeypress="return keyRestrict(event,'1234567890');" id="daysPassed" name="daysPassed" value="<?php echo $daysPassed ? $daysPassed : '' ?>" style="cursor:pointer;" />
						</div>
					</div>
				</div>	-->
				<div class="grid_12" id="searchTable">
					<input type="reset" id="resetForm" value="Reset" /><input type="submit" name="inTktFltr" id="inTktFltr" value="Retrieve Tickets" />
				</div>
			</form>
			<div style="margin: 10px">
				<div class="grid_12" style="margin-top: 10px">

					<div class="box">
						<div class="header">
							<h2>Ticket Details</h2>
						</div>
						<div class="content">

							<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false}]}'>
								<thead>
									<tr>
										<th>#</th>
										<th>Campus</th>
										<th>Priority</th>
										<th>Category</th>
										<th>Title</th>
										<th>Text</th>
										<th>Reference booking</th>
										<th>From CM</th>
										<th>BO Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if ($tickets) {
										$count = 1;
										foreach ($tickets as $row) {
											if ($row['ptc_bo_reply']) {
												?>
											<div style="display: none;" id="dialog_modal_rply_<?php echo $row["ptc_id"] ?>" title="Reply Details - <?php echo htmlspecialchars($row['ptc_title']); ?>" class="windia"> 
												<p><strong>Message: </strong><?php echo $row['ptc_bo_reply']; ?></p>
												<?php echo $row['ptc_bo_attachment'] ? '<p><strong>Attachment: </strong><a target="_blank" href="' . TICKET_BO_DWNLD . $row['ptc_bo_attachment'] . '"><i class="glyphicon glyphicon-paperclip"></i></a></p>' : ''; ?>
											</div>
											<?php
										}
										?>
										<div style="display: none;" id="dialog_modal_<?php echo $row["ptc_id"] ?>" title="Ticket Details - <?php echo htmlspecialchars($row['ptc_title']); ?>" class="windia"> 
											<p><strong>Priority: </strong><?php echo $row['ptc_priority']; ?></p>
											<p><strong>Category: </strong><?php echo $row['ptc_category']; ?></p>
											<p><strong>Title: </strong><?php echo $row['ptc_title']; ?></p>
											<p><strong>Text: </strong><?php echo $row['ptc_content']; ?></p>
											<p><strong>Reference booking: </strong><?php echo $row['ptc_ref_booking']; ?></p>
											<?php echo $row['ptc_attachment'] ? '<p><strong>Attachment: </strong><a href="' . TICKET_CM_DWNLD . $row['ptc_attachment'] . '"><i class="glyphicon glyphicon-paperclip"></i></a></p>' : ''; ?>
										</div>
										<tr>
											<td><?php echo $count; ?></td>
											<td><?php echo $row['nome_centri'] ? $row['nome_centri'] : 'ALL'; ?></td>
											<td><?php echo $row['ptc_priority']; ?></td>
											<td><?php echo $row['ptc_category']; ?></td>
											<td><?php echo $row['ptc_title']; ?></td>
											<td><?php echo $row['ptc_content_small']; ?></td>
											<td class="center"><?php echo $row['ptc_ref_booking']; ?></td>
											<td style="white-space: nowrap;" class="center operation"><a href="javascript:void(0)" class="tktOpenClass dialogbtn"  data-id="dialog_modal_btn_<?php echo $row["ptc_id"] ?>" id="tktOpn_<?php echo $row["ptc_id"] ?>"><span class="glyphicon glyphicon-eye-open " toolTip title="View Details" ></span></a><?php echo $row['ptc_attachment'] ? '&nbsp;&nbsp;<a href="' . TICKET_CM_DWNLD . $row['ptc_attachment'] . '" target="_blank" class="CMAtch" data-id="CMVw_' . $row["ptc_id"] . '"><i class="glyphicon glyphicon-paperclip" toolTip title="Attachment"></i></a>' : ''; ?><!--&nbsp;&nbsp;<a href="javascript:void(0)" class="tktDelClass" id="tktDel_<?php //echo $row["ptc_id"]      ?>"><span class="glyphicon glyphicon-trash " toolTip title="Delete" ></span></a>--><?php echo $row['ptc_bo_read'] == 0 ? '<span class="notif_ico_sm blink_me glyphicon glyphicon-envelope" id="new_' . $row["ptc_id"] . '"></span>' : '' ?></td>
											<td style="white-space: nowrap;" class="center operation">
												<?php
												if ($row['ptc_bo_reply']) {
													?>
																		<a href="javascript:void(0)" class="tktRplyOpenClass dialogbtn"  data-id="dialog_modal_rply_btn_<?php echo $row["ptc_id"] ?>" id="tktRplyOpn_<?php echo $row["ptc_id"] ?>"><span class="glyphicon glyphicon-eye-open " toolTip title="View Reply" ></span></a><?php echo $row['ptc_bo_attachment'] ? '&nbsp;&nbsp;<a href="' . TICKET_BO_DWNLD . $row['ptc_bo_attachment'] . '" target="_blank"><i class="glyphicon glyphicon-paperclip" toolTip title="Reply Attachment"></i></a>' : ''; ?><!--&nbsp;&nbsp;<a href="javascript:void(0)" class="tktRplyEditClass" id="tktRplyEdit_<?php echo $row["ptc_id"] ?>"><span class="glyphicon glyphicon-edit " toolTip title="Edit Reply" ></span></a>&nbsp;&nbsp;<a href="javascript:void(0)" class="tktRplyDelClass" id="tktDelRply_<?php echo $row["ptc_id"] ?>"><span class="glyphicon glyphicon-trash " toolTip title="Delete Reply" ></span></a>-->
													<?php
												}
												else {
													?>
													<a href="javascript:void(0)" class="tktRplyClass" id="tktRply_<?php echo $row["ptc_id"] ?>"><span class="glyphicon glyphicon-share-alt " toolTip title="Reply" ></span></a>
													<?php
												}
												?>
												<a href="javascript:void(0)" class="<?php echo $row["ptc_closed"] == 0 ? 'tktCloseClass' : '' ?>" id="tktClose_<?php echo $row["ptc_id"] ?>"><span toolTip class="glyphicon <?php echo $row["ptc_closed"] == 0 ? 'glyphicon-unchecked' : 'glyphicon-check' ?>" <?php echo $row["ptc_closed"] == 0 ? 'title="Close Ticket"' : 'title="Ticket Closed"' ?>   ></span></a>
											</td>
										</tr>
										<?php
										$count += 1;
									}
								}
								?>
								</tbody>
							</table>
						</div>

					</div>
				</div>	
			</div>	
		</div>

	</section>	
</div>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<script src="<?php echo base_url(); ?>js/app.js"></script>
<script type="text/javascript">
	var baseUrl = "<?php echo base_url(); ?>";
	var siteUrl = "<?php echo site_url(); ?>/";
</script>
<script>

	
	$(document).ready(function() {
		$('[toolTip]').tipsy({gravity:'s'});
		if($('.tuition_success').length > 0){
			setTimeout(function(){
				$($('.tuition_success')).fadeOut(5000, function(){
					$('.tuition_success').remove();
				});
			},10000);
		}
		$(document).on('click', ".dialogbtn", function() {
			var iddia = $(this).attr("data-id").replace('_btn','');
			$( "#"+iddia ).dialog("open");
			return false;
		});
		$( ".windia" ).dialog({
			autoOpen: false,
			modal: true,
			width: 'auto',
			buttons: [{
					text: "Close",
					click: function() { $(this).dialog("close"); }
				}]
		});
		$( "#dateFiled" ).datepicker({
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",
			maxDate: "+1Y"
		}).datepicker();
		
		$("#s_USA").click(function(){
			$("input.chCentri").each(function(){
				$(this).attr("checked",false);
			});
			$("input.sel_USD").each(function(){
				$(this).attr("checked",true);
			});		
		});
	
		$("#s_UK").click(function(){
			$("input.chCentri").each(function(){
				$(this).attr("checked",false);
			});
			$("input.sel_GBP").each(function(){
				$(this).attr("checked",true);
			});		
		});	
	
		$("#s_EUR").click(function(){
			$("input.chCentri").each(function(){
				$(this).attr("checked",false);
			});
			$("input.sel_EUR").each(function(){
				$(this).attr("checked",true);
			});		
		});		
		$("#s_all").click(function(){
			$("input.chCentri").each(function(){
				$(this).attr("checked",true);
			});
		});	

		$("#s_none").click(function(){
			$("input.chCentri").each(function(){
				$(this).attr("checked",false);
			});
		});	
		$("#hp_all").click(function(){
			$("input.chHours").each(function(){
				$(this).attr("checked",true);
			});
		});	

		$("#hp_none").click(function(){
			$("input.chHours").each(function(){
				$(this).attr("checked",false);
			});
		});	
		$("#bk_all").click(function(){
			$("input.chPriority").each(function(){
				$(this).attr("checked",true);
			});
		});	

		$("#bk_none").click(function(){
			$("input.chPriority").each(function(){
				$(this).attr("checked",false);
			});
		});	
		$("#ct_all").click(function(){
			$("input.chCategory").each(function(){
				$(this).attr("checked",true);
			});
		});	

		$("#ct_none").click(function(){
			$("input.chCategory").each(function(){
				$(this).attr("checked",false);
			});
		});	
		window.triggerSubmit = function(){
			$('#inTktFltr').trigger('click');
		}
		$('body').on('click', ".tktRplyClass",function(e){
			e.preventDefault();
			
			var selId = $(this).attr('id').replace('tktRply_', '');
			if(selId != '' && typeof selId != 'undefined'){
				$.ajax({
					type: "POST",
					data: {
						selId: selId
					},
					url: siteUrl + "ticketmanagement/checkTicketStatus",
					success: function(response){
						if(response==1){
							var diaH = $(window).height()* 0.52;
							e.preventDefault();
							$('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(' + baseUrl + '/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
							.html($('<iframe/>', {
								'src' : siteUrl + "ticketmanagement/openTicketReply/"+selId,
								'style' :'width:100%;height: 100%;border:none;'
							})).appendTo('body')
							.dialog({
								'title' : 'Reply to ticket',
								'width' : '50%',
								'height' : diaH,
								modal: true,
								buttons: [ {
										text: "Close",
										click: function() { $( this ).dialog( "close" ); }
									} ]
							});
						}else{
							alert("This ticket doesn't exists!");
						}
					}
				});
			}
			
		});
		/*$('body').on('click', ".tktRplyEditClass",function(e){
			e.preventDefault();
			
			var selId = $(this).attr('id').replace('tktRplyEdit_', '');
			if(selId != '' && typeof selId != 'undefined'){
				$.ajax({
					type: "POST",
					data: {
						selId: selId
					},
					url: siteUrl + "ticketmanagement/checkTicketStatus",
					success: function(response){
						if(response==1){
							var diaH = $(window).height()* 0.6;
							e.preventDefault();
							$('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(' + baseUrl + '/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
							.html($('<iframe/>', {
								'src' : siteUrl + "ticketmanagement/editTicketReply/"+selId,
								'style' :'width:100%;height: 100%;border:none;'
							})).appendTo('body')
							.dialog({
								'title' : 'Edit Reply',
								'width' : '50%',
								'height' : diaH,
								modal: true,
								buttons: [ {
										text: "Close",
										click: function() { $( this ).dialog( "close" ); }
									} ]
							});
						}else{
							alert("This ticket doesn't exists!");
						}
					}
				});
			}
			
		});*/
		/*$('body').on('click', '.tktDelClass', function(){
			var selId = $(this).attr('id').replace('tktDel_', '');
			if(selId != '' && typeof selId != 'undefined'){
				var c = confirm('Are you sure to delete this ticket?');
				if(c){
					$.ajax({
						url: siteUrl + 'ticketmanagement/deleteTicket',
						type: 'POST',
						data: {
							selId: selId
						},
						success: function(data){
							if(data == 1){
								$('#box_tktFltr').submit();
							}
							else{
								alert('Failed to delete ticket');
							}
						},
						error: function(){
							alert('Failed to delete ticket');
						}
					});
				}
			}
		});*/
		
		/*$('body').on('click', '.tktRplyDelClass', function(){
			var selId = $(this).attr('id').replace('tktDelRply_', '');
			if(selId != '' && typeof selId != 'undefined'){
				var c = confirm('Are you sure to delete this reply?');
				if(c){
					$.ajax({
						url: siteUrl + 'ticketmanagement/deleteTicketReply',
						type: 'POST',
						data: {
							selId: selId
						},
						success: function(data){
							if(data == 1){
								$('#box_tktFltr').submit();
							}
							else{
								alert('Failed to delete reply');
							}
						},
						error: function(){
							alert('Failed to delete reply');
						}
					});
				}
			}
		});*/
	
		$('body').on('click', '.tktCloseClass', function(){
			var elm = $(this);
			var selId = elm.attr('id').replace('tktClose_', '');
			if(selId != '' && typeof selId != 'undefined'){
				var c = confirm('Are you sure to close the ticket?');
				if(c){
					$.ajax({
						url: siteUrl + 'ticketmanagement/changeTicketStatus',
						type: 'POST',
						data: {
							selId: selId
						},
						success: function(data){
							if(data == 1){
								if(elm.find('span').hasClass('glyphicon-unchecked')){
									elm.find('span').removeClass('glyphicon-unchecked');
									elm.find('span').addClass('glyphicon-check');
									elm.find('span').attr('title', 'Ticket Closed');
								}
								else if(elm.find('span').hasClass('glyphicon-check')){
									elm.find('span').removeClass('glyphicon-check');
									elm.find('span').addClass('glyphicon-unchecked');
									elm.find('span').attr('title', 'Close Ticket');
								}
								elm.removeClass('tktCloseClass');
								$('[toolTip]').tipsy({gravity:'s'});
							}
							else{
								alert('Failed to close ticket');
							}
						},
						error: function(){
							alert('Failed to close ticket');
						}
					});
				}
			}
		});
		
		function makeReadByBo(selId){
			if(selId != '' && typeof selId != 'undefined'){
				$.ajax({
					url: siteUrl + 'ticketmanagement/readByBo',
					type: 'POST',
					data: {
						selId: selId
					},
					success: function(data){
						if(data == 1){
							$('#new_'+selId).remove();
							checkNewBOAlert();
						}
					}
				});
			}
		}
		
		$('body').on('click', '.CMAtch', function(){
			var selId = $(this).attr('data-id').replace('CMVw_','');
			makeReadByBo(selId);
		});
		
		$('body').on('click', '.tktOpenClass', function(){
			var selId = $(this).attr('id').replace('tktOpn_','');
			makeReadByBo(selId);
		});
		
		$('body #selHours_chzn .active-result').on('click', function(){
			$('#selHourDiv').scrollTop(0);
		});
		$( "li#tktbomgt" ).addClass("current");
		$( "li#tktbomgt a" ).addClass("open");		
		$( "li#tktbomgt ul.sub" ).css('display','block');	
		$( "li#tktbomgt ul.sub li#tktbomgt_1" ).addClass("current");	
		
	});
	$('body').on('click', '#resetForm', function(e){
		e.preventDefault();
		window.location.href = "<?php echo site_url() ?>/ticketmanagement";
	});
</script>	
<?php $this -> load -> view('plused_footer'); ?>
