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
				<h2 class="box-title width-full"><?php echo $breadcrumb2; ?><a href="<?php echo base_url() . 'index.php/contract/exportcontract'; ?>" class="pull-right"><input id="btnExport" type="submit" value="Export" class="btn btn-primary btn-sm" ></a></h2>
			</div>
			<div class="box-body">
				<a class="open-add-client-dialog btn btn-sm btn-primary mr-bot-10" href="<?php echo base_url(); ?>index.php/contract/addedit"><i class="fa fa-plus"></i>&nbsp;Create new contract</a>

				<table class="table table-bordered table-hover width-full vertical-middle" id="contractTable">
					<thead>
						<tr>
							<th>Applicant name</th>
							<th>Email</th>
							<th>Campus</th>
							<th>Position</th>
							<th>From date</th>								
							<th>To date</th>
							<th>Contract status</th>
							<th class="no-sort">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (!empty($contractdata)) {
							foreach ($contractdata as $contract) {
								?>
							<div class="modal fade modalShow " id="dialog_modal_contract_<?php echo $contract["joc_id"]; ?>" data-ta-id="<?php echo $contract["joc_application_id"];?>" data-track-id="<?php echo $contract['joc_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog large" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="myModalLabel">Contract detail - <?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></h4>
										</div>
										<div class="modal-body">
											<div id="historRecord" class="box">
												<div class="box-header with-border">
													<h2 class="box-title">Contract detail</h2>
												</div>
												<div class="box-body">
													<div class="detailContainer">
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
															<div class="col-sm-9 col-md-9 hlt-link break-word"><a target="_blank" href="<?php echo base_url() . ACADEMIC_CONTRACT_FILE_PATH . $contract["joc_contract_file"]; ?>"><?php echo $contract["joc_contract_file"]; ?></a></div>
														</div>
														<div class="row">
															<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3"><strong>Contract status:</strong></div>
															<div class="col-sm-3 col-md-3 break-word mr-bt-tp-3" id="view-con-status-<?php echo $contract["joc_id"]; ?>"><?php echo ($contract["joc_contract_signed"] == 1 ? "Signed and received" : "Sent"); ?></div>
                                                                                                                        
														</div>
													</div>
												</div>
											</div>
											<div class="box">
												<div class="box-header with-border">
													<h2 class="box-title">Teachers detail</h2>
												</div>
												<div class="box-body detailContainer">
													<div id="teacherDetail_<?php echo $contract['joc_id']; ?>"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<tr>
								<td><?php echo $contract['ta_firstname'] . ' ' . $contract['ta_lastname']; ?></td>
								<td><?php echo $contract["joc_email"]; ?></td>
								<td><?php echo $contract["nome_centri"]; ?></td>
								<td><?php echo $contract["pos_position"]; ?></td>
								<td><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></td>
								<td><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></td>
								<td id="con-status-<?php echo $contract["joc_id"]; ?>">
                                                                    <?php 
                                                                    if($contract["joc_contract_signed"] == 1){
                                                                        echo "Signed and received";
                                                                    }else {
                                                                        echo "Sent<br />
                                                                            <small>"; 
                                                                        $now = new DateTime(); // or your date as well
                                                                        $created_date = new DateTime($contract['joc_created_on']);
                                                                        //// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'
                                                                        $interval = date_diff($now, $created_date);
                                                                        $intervalYear = $interval->format("%y");
                                                                        if($intervalYear) echo $intervalYear." year(s) ";
                                                                        $intervalMonth = $interval->format("%m");
                                                                        if($intervalMonth) echo $intervalMonth." month(s) ";
                                                                        $intervalDay = $interval->format("%d");
                                                                        if($intervalDay) echo $intervalDay." day(s) ago";
                                                                        //echo floor($datediff / (60 * 60 * 24));
                                                                        echo "</small>";
                                                                    }?>
                                                                </td>
								<td data-filter="<?php echo date('Y',strtotime($contract['joc_created_on']));?>" class="center operation text-center">
									<div class="btn-group min-wd-95">
										<a href="javascript:void(0);" data-toggle="modal" data-target="#dialog_modal_contract_<?php echo $contract["joc_id"]; ?>" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" data-id="dialog_modal_btn_<?php echo $contract["joc_id"]; ?>" class="getappdetail dialogbtn btn btn-xs btn-info">
											<span  title="View" data-toggle="tooltip" class="fa fa-eye"></span>
										</a>
										<a title="Edit" data-toggle="tooltip" href="<?php echo base_url() . 'index.php/contract/addedit/' . $contract["joc_id"]; ?>" class=" btn btn-xs btn-warning">
											<span class="fa fa-edit"></span>
										</a>
										<a class="changeStatus btn btn-xs btn-info" data-toggle="tooltip" data-status="<?php echo $contract['joc_is_active']; ?>" data-id="<?php echo $contract['joc_id']; ?>" title="Change active/inactive status" href="javascript:void(0);"><span class="fa <?php echo ($contract['joc_is_active'] == '1' ? 'fa-check-square-o' : 'fa-square-o'); ?>"></span></a>
										<a title="Delete" data-toggle="tooltip" id="dltContract" data-id="<?php echo $contract["joc_id"]; ?>" class="btn btn-xs btn-danger">
											<span class="fa fa-trash"></span>
										</a>
									</div>
									<a class="hlt-link-a change-con-status font-12" data-con-id="<?php echo $contract["joc_id"]; ?>" data-con-status="<?php echo $contract["joc_contract_signed"]; ?>" title="Change contract status" href="javascript:void(0);">
										<span class="icon-send">Change contract status</span>
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
<script type="text/javascript">
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
					$(this).addClass('col-sm-12');
				});
				var column = this;
				var select = $('<div class="col-sm-12"><select id="contractYearFilter" class="form-control mr-bot-5" style="margin-right:10px;"><option value="">Select contract year</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option></select><select id="contractStatusFilter" class="form-control mr-bot-5"><option value="">Select contract status</option><option value="Sent">Sent</option><option value="Signed and received">Signed and received</option></select></div>')
				.insertAfter( $('#contractTable_wrapper .row .col-sm-12').first());
			}
		} );	
                $("#contractYearFilter").val("2017");
                
		$('body').on('change','#contractStatusFilter', function(){
			objTable.columns(6).search(this.value).draw();
		});
                $('body').on('change','#contractYearFilter', function(){
			objTable.columns(7).search(this.value).draw();
		});
                $("#contractYearFilter").trigger("change");
//		$(document).on('click', ".dialogbtn", function() {
//			var iddia = $(this).attr("data-id").replace('_btn','');
//			$( "#"+iddia ).dialog("open");
//			return false;
//		});
			
		$( "#txtCalFromDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$( "#txtCalToDate" ).datepicker( "option", "minDate", selectedDate );
			}
		});

		$( "#txtCalToDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
		$('.modalShow').on('shown.bs.modal', function (e) {
			//var ta_id = $(this).attr('id').replace('dialog_modal_contract_','');
			var id = $(this).attr('data-track-id');
                        var ta_id = $(this).attr('data-ta-id');
			$("#teacherDetail_"+id).html('');
			$.post( siteUrl+"teachers/applicationdetail",{
				'id':ta_id
			}, function( data ) {
				$("#teacherDetail_"+id).html(data);
			});
		});
                        
		$('#contractStatusFilter').on( 'change', function () {
			var oTable = $('table.dynamic').dataTable();
			oTable.fnFilter( this.value , 6 );
		});
	});
                
	$(document).on('click',".changeStatus",function(){
		var thisEle = $(this);
		var id = $(this).attr('data-id');
		var status = $(this).attr('data-status');
		confirmAction('Are you sure to change active/inactive status?', function(s){
			if(s){
				$.post( "<?php echo base_url(); ?>index.php/contract/contract_change_status",{'id':id,'status':status}, function( data ) {
					if(parseInt(data.result)){
						if(parseInt(data.status))
						{
							thisEle.children().switchClass('fa-square-o','fa-check-square-o');
							$('#pop_'+id).html('Active');
							thisEle.attr('data-status',data.status);
						}
						else
						{
							thisEle.children().switchClass('fa-check-square-o','fa-square-o');
							$('#pop_'+id).html('Inactive');
							thisEle.attr('data-status',data.status);
						}
					}
				},'json');
			}
		},true, true);
	});
                
	$(document).on('click',".change-con-status",function(){
		var con_id = $(this).attr('data-con-id');
		var con_status = $(this).attr('data-con-status');
		var thisEle = $(this);
		confirmAction('Are you sure to change contract status?', function(s){
			if(s){
				$.post( "<?php echo base_url(); ?>index.php/contract/change_academic_contract_status",{'con_id':con_id,'con_status':con_status}, function( data ) {
					if(parseInt(data.result)){
						if(parseInt(data.status))
						{
							$('#con-status-'+con_id).html('Signed and received');
							$('#view-con-status-'+con_id).html('Signed and received');
							thisEle.attr('data-con-status',data.status);
						}
						else
						{
							$('#con-status-'+con_id).html('Sent');
							$('#view-con-status-'+con_id).html('Sent');
							thisEle.attr('data-con-status',data.status);
						}
					}
					else{

					}
				},'json');
			}
		},true, true);
	});
	$('body').on('click', '#dltContract', function(){
		var elm = $(this);
		confirmAction('Are you sure to delete the contract?', function(s){
			if(s){
				var id = elm.attr('data-id');
				window.location.replace(siteUrl + 'contract/deletecontract/'+id);
			}
		},true, true);
	});
                
                
	$(document).on('click', '.paginate_button', function(){
		$("table.dynamic tr td:last-child").removeClass('center operation');
		$("table.dynamic tr td:last-child").addClass('center operation');
	});
</script>