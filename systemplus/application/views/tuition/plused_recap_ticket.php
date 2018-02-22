<?php $this -> load -> view('plused_header'); ?>

<style type="text/css">
	#category_chzn{
		width: 50% !important;
	}
	#selRefBooking_chzn{
		width: 50% !important;
	}
	.customfile {
		width: 50% !important;
	}
	.content{
		overflow: auto;
	}
	table.styled th{
		width: inherit !important;
	}
	@media(max-width: 650px){
		table td{
			min-height: 15px;
		}
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
	<?php $this -> load -> view('plused_sidebar'); ?>
	<!-- Here goes the content. -->
	<section id="content" class="container_12 clearfix" data-sort=true>
		<div class="grid_12">
			<div class="box">
				<div class="header">
					<h2>Recap Ticket</h2>
				</div>
				<div class="content">
					<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false}]}'>
						<thead>
							<tr>
								<th>#</th>
								<th style="width: 45px !important;">Priority</th>
								<th>Category</th>
								<th>Title</th>
								<th>Text</th>
								<th>Reference booking</th>
								<th class="center">Status</th>
								<th>Actions</th>
								<th>Operator Reply</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($rowDetails) {
								$count = 1;
								foreach ($rowDetails as $row) {
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
									<?php echo $row['ptc_attachment'] ?'<p><strong>Attachment: </strong> <a target="_blank" href="' . TICKET_CM_DWNLD . $row['ptc_attachment'] . '"><i class="glyphicon glyphicon-paperclip"></i></a></p>' : ''; ?>
								</div>
								<tr>
									<td><?php echo $count; ?></td>
									<td><?php echo $row['ptc_priority']; ?></td>
									<td><?php echo $row['ptc_category']; ?></td>
									<td><?php echo $row['ptc_title']; ?></td>
									<td><?php echo $row['ptc_content_small']; ?></td>
									<td class="center"><?php echo $row['ptc_ref_booking']; ?></td>
									<td><?php echo $row["ptc_closed"] == 0 ? '<span style="color: #107b10">Open</span>' : '<span style="color: #FF0000">Closed</span>' ?></td>
									<td style="white-space: nowrap;" class="center operation"><a href="javascript:void(0)" class="tktOpenClass dialogbtn"  data-id="dialog_modal_btn_<?php echo $row["ptc_id"] ?>" id="tktOpn_<?php echo $row["ptc_id"] ?>"><span class="glyphicon glyphicon-eye-open " toolTip title="View Details" ></span></a><?php echo $row['ptc_attachment'] ? '&nbsp;&nbsp;<a href="' . TICKET_CM_DWNLD . $row['ptc_attachment'] . '" target="_blank"><i class="glyphicon glyphicon-paperclip" toolTip title="Attachment"></i></a>' : ''; ?>
										<?php //echo $row["ptc_closed"] == 0 ? '&nbsp;&nbsp;<a href="javascript:void(0)" class="tktEdtClass" id="tktEdt_' . $row["ptc_id"] . '"><span class="glyphicon glyphicon-edit " toolTip title="Edit" ></span></a>&nbsp;&nbsp;<a href="javascript:void(0)" class="tktDelClass" id="tktDel_' . $row["ptc_id"] . '"><span class="glyphicon glyphicon-trash " toolTip title="Delete" ></span></a>' : '' ?>
									</td>
									<td style="white-space: nowrap;" class="center operation">
										<?php
										if ($row['ptc_bo_reply']) {
											?>
											<a href="javascript:void(0)" class="tktRplyOpenClass dialogbtn"  data-id="dialog_modal_rply_btn_<?php echo $row["ptc_id"] ?>" id="tktRplyOpn_<?php echo $row["ptc_id"] ?>"><span class="glyphicon glyphicon-eye-open " toolTip title="View Reply" ></span></a><?php echo $row['ptc_bo_attachment'] ? '&nbsp;&nbsp;<a href="' . TICKET_BO_DWNLD . $row['ptc_bo_attachment'] . '" target="_blank" class="BORplyVw" data-id="BORply_'.$row["ptc_id"].'"><i class="glyphicon glyphicon-paperclip" toolTip title="Reply Attachment"></i></a>' : ''; ?><?php echo $row['ptc_cm_read'] == 0 ? '<span class="notif_ico_sm blink_me glyphicon glyphicon-envelope" id="new_'.$row["ptc_id"].'"></span>' : '' ?>
											<?php
										}
										?>
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
		</div>	
	</section>	

</div>
<script>
	$(document).ready(function() {
		$( "li#mngTkt" ).addClass("current");
		$( "li#mngTkt a" ).addClass("open");		
		$( "li#mngTkt ul.sub" ).css('display','block');	
		$( "li#mngTkt ul.sub li#mngTkt_2" ).addClass("current");	
		
		$('[toolTip]').tipsy({gravity:'s'});
		
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
	});
	if($('.tuition_success').length > 0){
		setTimeout(function(){
			$($('.tuition_success')).fadeOut(5000, function(){
				$('.tuition_success').remove();
			});
		},10000);
	}
	$('body').on('click', ".tktEdtClass",function(e){
		e.preventDefault();
		var selId = $(this).attr('id').replace('tktEdt_', '');
		if(selId != '' && typeof selId != 'undefined'){
			$.ajax({
				type: "POST",
				data: {
					selId: selId
				},
				url: siteUrl + "backoffice/checkTicketStatus",
				success: function(response){
					if(response==1){
						var diaH = $(window).height()* 0.9;
						e.preventDefault();
						$('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(' + baseUrl + '/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
						.html($('<iframe/>', {
							'src' : siteUrl + "backoffice/openTicketEdit/"+selId,
							'style' :'width:100%;height: 100%;border:none;'
						})).appendTo('body')
						.dialog({
							'title' : 'Edit ticket',
							'width' : '50%',
							'height' : diaH,
							modal: true,
							buttons: [ {
									text: "Close",
									click: function() { $( this ).dialog( "close" ); }
								} ]
						});
					}else{
						alert("This ticket doesn't exists or it is locked");
					}
				}
			});
		}
	});
	$('body').on('click', '.tktDelClass', function(){
		var selId = $(this).attr('id').replace('tktDel_', '');
		if(selId != '' && typeof selId != 'undefined'){
			var c = confirm('Are you sure to delete this ticket?');
			if(c){
				$.ajax({
					url: siteUrl + 'backoffice/deleteTicket',
					type: 'POST',
					data: {
						selId: selId
					},
					success: function(data){
						if(data == 1){
							alert('Ticket deleted successfully');
							location.reload();
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
	});
	
	function makeReadByCm(selId){
		if(selId != '' && typeof selId != 'undefined'){
			$.ajax({
				url: siteUrl + 'backoffice/readByCm',
				type: 'POST',
				data: {
					selId: selId
				},
				success: function(data){
					if(data == 1){
						$('#new_'+selId).remove();
						checkNewCMAlert();
					}
				}
			});
		}
	}
	
	$('body').on('click', '.BORplyVw', function(){
			var selId = $(this).attr('data-id').replace('BORply_','');
			makeReadByCm(selId);
		});
	
	$('body').on('click', '.tktRplyOpenClass', function(){
		var selId = $(this).attr('id').replace('tktRplyOpn_','');
		makeReadByCm(selId);
	});
</script>	
<?php $this -> load -> view('plused_footer'); ?>
