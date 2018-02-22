<link rel="stylesheet" href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css">
<div class="row">
	<?php
	showSessionMessageIfAny($this);
	?>
</div>
<div class="row">
	<div class="col-md-12">

		<div class="box">
			<div class="box-header with-border">
				<h2 class="box-title"><?php echo $breadcrumb2; ?></h2>
                                <span class="pull-right">
                                    <a href="<?php echo base_url();?>index.php/users/contractEmployment">Download Contract of Employment - Summer Staff</a>
                                </span>
			</div>
			<div class="box-body">
				<table class="table table-bordered table-hover width-full vertical-middle" id="contractTable">
					<thead>
						<tr>
							<th>Campus</th>
							<th>Position</th>
							<th>From date</th>								
							<th>To date</th>
							<th>Contract file</th>
							<th>Contract status</th>
							<th class="no-sort text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (!empty($contractdata)) {
							foreach ($contractdata as $contract) {
								?>
							<div class="modal fade modalShow " id="dialog_modal_<?php echo $contract["joc_id"] ?>" data-track-id="<?php echo $contract['joc_id']; ?>"  data-ta-id="<?php echo $contract["joc_application_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog large" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="myModalLabel">Contract details</h4>
										</div>
										<div class="modal-body">
											<div class="box">
												<div class="box-header with-border">
													<h2 class="box-title">Contract details - <?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></h2>
												</div>
												<div class="box-body">
													<div class="row">
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Name:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></div>

														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Email:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["joc_email"]; ?></div>
													</div>
													<div class="row">
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Campus:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["nome_centri"]; ?></div>

														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Position:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["pos_position"]; ?></div>
													</div>
													<div class="row">
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>From date:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></div>

														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>To date:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></div>
													</div>
													<div class="row">
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Hours per week:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["joc_hourperweek_range"]; ?></div>

														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Wages:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["joc_wages"]; ?></div>
													</div>
													<div class="row">
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Salary:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["joc_salary"]; ?></div>

														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Currency:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["joc_currency"]; ?></div>
													</div>
													<div class="row">
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Residential:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["joc_res_non_res"]; ?></div>

														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Extra activities:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["joc_extra_activities"]; ?></div>
													</div>
													<div class="row">
                                                                                                                <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Board as basis:</strong></div>
                                                                                                                <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["job_board_as"];?></div>
                                                                                                                
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Returnee:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($contract["joc_returnee"] == 1 ? 'Yes' : 'No'); ?></div>
													</div>
                                                                                                        <div class="row">
                                                                                                                <div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Address:</strong></div>
														<div class="col-sm-9 col-md-9 break-word mr-bt-tp-3"><?php echo ($contract["joc_address"]); ?></div>
                                                                                                        </div>
													<div class="row">
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>City:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["joc_city"]; ?></div>

														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Postcode:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($contract["joc_postcode"]); ?></div>
													</div>
													<div class="row">
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Country:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo $contract["joc_country"]; ?></div>

														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Status:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><span id="pop_<?php echo $contract["joc_id"] ?>"><?php echo ($contract["joc_is_active"] == 1 ? 'Active' : 'Inactive'); ?></span></div>
													</div>
													<div class="row">
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Contract file:</strong></div>
														<div class="col-sm-9 col-md-9 break-word mr-bt-tp-3 hlt-link"><a target="_blank" href="<?php echo base_url() . ACADEMIC_CONTRACT_FILE_PATH . $contract["joc_contract_file"]; ?>"><?php echo $contract["joc_contract_file"]; ?></a></div>
													</div>
													<div class="row">
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Contract status:</strong></div>
														<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><?php echo ($contract["joc_contract_signed"] == 1 ? "Signed and received" : "Sent"); ?></div>
													</div>
												</div>
											</div>
											<div class="box">
												<div class="box-header with-border">
													<h2 class="box-title">Teachers details</h2>
												</div>
												<div class="box-body detailContainer">
													<div id="teacherDetail_<?php echo $contract['joc_id']; ?>">
														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<tr>
									<td><?php echo $contract["nome_centri"]; ?></td>
									<td><?php echo $contract["pos_position"]; ?></td>
									<td><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></td>
									<td><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></td>
									<td class="hlt-link"><a target="_blank" href="<?php echo base_url() . ACADEMIC_CONTRACT_FILE_PATH . $contract["joc_contract_file"]; ?>"><?php echo $contract["joc_contract_file"]; ?></a></td>
									<td style="width:80px;"><?php echo ($contract["joc_contract_signed"] == 1 ? "Signed and received" : "Sent"); ?></td>
									<td class="text-center operation">
										<a href="javascript:void(0);" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" data-id="dialog_modal_btn_<?php echo $contract["joc_id"]; ?>" class="getappdetail dialogbtn btn btn-primary btn-xs" data-toggle="modal" data-target="#dialog_modal_<?php echo $contract["joc_id"] ?>">
											<span class="fa fa-eye" title="View" data-toggle="tooltip"></span>
										</a>
									</td>
								</tr>
								<?php
							}
						}
						?>
						</tbody>
				</table>
			</div>

		</div>
	</div>
</div>
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<style>
    #contractTable_filter input{
        width:73%;
    }
</style>
<script type="text/javascript">
     var SITE_PATH = siteUrl;
	$(function(){
		var objTable = $('#contractTable').DataTable( {
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"responsive": true,
			"order": [],
			"sScrollX": true,
			"columnDefs": [
				{
					"targets"  : 'no-sort',
					"orderable": false
				},
				{
					"targets"  : 'col-text-numeric',
					"sSortDataType": 'dom-text-numeric'
				}
			],
			initComplete: function () {
				$('#contractTable_wrapper .row .col-sm-6').each(function(){
					$(this).removeClass('col-sm-6');
					$(this).addClass('col-sm-4');
				});
				var column = this;
				var select = $('<div class="col-sm-4 mr-bot-5"><select id="contractStatusFilter" class="form-control input-sm"><option value="">Select contract status</option><option value="Sent">Sent</option><option value="Signed and received">Signed and received</option></select></div>')
				.insertAfter( $('#contractTable_wrapper .row .col-sm-4').first());
			}
		} );	
		$('body').on('change','#contractStatusFilter', function(){
			objTable.columns(5).search(this.value).draw();
		});
//		$(document).on('click', ".dialogbtn", function() {
//			var iddia = $(this).attr("data-id").replace('_btn','');
//			//alert(iddia.replace('_btn',''));
//			$( "#"+iddia ).dialog("open");
//			return false;
//		});
//		$( ".windia" ).dialog({
//			autoOpen: false,
//			modal: true,
//			width : '70%',
//			height : 550,
//			buttons: [{
//					text: "Close",
//					click: function() { $(this).dialog("close"); }
//				}]
//		});
			
			
                        
		// here we will get teachers application details.
//		$( "body" ).on( "click", ".getappdetail", function() {
//			var ta_id = $(this).attr('data-ta-id');
//			var id = $(this).attr('data-track-id');
//			$.post( "<?php echo base_url(); ?>index.php/teachers/applicationdetail",{
//				'id':ta_id
//			}, function( data ) {
//				$("#teacherDetail_"+id).html(data);
//			});
//		});
		$('.modalShow').on('shown.bs.modal', function (e) {
			var ta_id = $(this).attr('data-ta-id');
			var id = $(this).attr('data-track-id');
			$("#teacherDetail_"+id).html('');
			$.post( SITE_PATH + "teachers/applicationdetail",{
				'id':ta_id
			}, function( data ) {
				$("#teacherDetail_"+id).html(data);
			});
		});
                        
		$('#contractStatusFilter').on( 'change', function () {
			var oTable = $('table.dynamic').dataTable();
			oTable.fnFilter( this.value , 5 );
		});
	});
</script>