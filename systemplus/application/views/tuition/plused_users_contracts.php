<?php $this -> load -> view('plused_header'); ?>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix">
	<!-- The blue toolbar stripe -->
	<section class="toolbar">
		<div class="user">
			<div class="avatar">
				<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
				<!-- Evidenziare per icone attenzione <span>3</span> -->
			</div>
			<span><?php echo $this -> session -> userdata('businessname') ?></span>
			<ul>
				<li><a href="<?php echo base_url(); ?>index.php/users/profile">Profile</a></li>
				<li class="line"></li>
				<li><a href="<?php echo base_url(); ?>index.php/users/logout">Logout</a></li>
			</ul>
		</div>
	</section><!-- End of .toolbar-->
	<?php $this -> load -> view('plused_sidebar'); ?>
	<script type="text/javascript">
		$(function(){
			$( "li#myaccount" ).addClass("current");
			$( "li#myaccount a" ).addClass("open");		
			$( "li#myaccount ul.sub" ).css('display','block');	
                        $( "li#myaccount ul.sub li#myaccount_2" ).addClass("current");
			//$('table.dynamic').table();
			$(document).on('click', ".dialogbtn", function() {
				var iddia = $(this).attr("data-id").replace('_btn','');
				//alert(iddia.replace('_btn',''));
				$( "#"+iddia ).dialog("open");
				return false;
			});
			$( ".windia" ).dialog({
				autoOpen: false,
				modal: true,
                                width : '70%',
                                height : 550,
				buttons: [{
						text: "Close",
						click: function() { $(this).dialog("close"); }
					}]
			});
			
			
                        
                        // here we will get teachers application details.
                        $( "body" ).on( "click", ".getappdetail", function() {
                            var ta_id = $(this).attr('data-ta-id');
                            var id = $(this).attr('data-track-id');
                            $.post( "<?php echo base_url();?>index.php/teachers/applicationdetail",{
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
                
		
		$(document).on('click', '.paginate_button', function(){
			$("table.dynamic tr td:last-child").removeClass('center operation');
			$("table.dynamic tr td:last-child").addClass('center operation');
		});
	</script>
	<section id="content" class="container_12 clearfix" data-sort=true>
		<div class="grid_12">

			<div class="box">
				<div class="header">
					<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><?php echo $breadcrumb2; ?></h2>
				</div>
				<div class="content">
					<div class="tabletools">
						<div class="left">
							 
						</div>
						<div class="right">
                                                    <?php
                                                        $success_message = $this -> session -> flashdata('success_message');
                                                    if (!empty($success_message)) {
                                                            ?><div class="tuition_success"><?php echo $success_message; ?></div><?php
                                                        }
                                                        $error_message = $this -> session -> flashdata('error_message');
                                                        if (!empty($error_message)) {
                                                                        ?><div class="tuition_error"><?php echo $error_message; ?></div><?php
                                                        }
                                                    ?>
						</div>
					</div>
                                        <div class="gridFilters">
                                            <select id="contractStatusFilter">
                                                <option value="">Select contract status</option>
                                                <option value="Sent">Sent</option>
                                                <option value="Signed and received">Signed and received</option>
                                            </select>
                                        </div>
					<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
						<thead>
							<tr>
								<th>Campus</th>
								<th>Position</th>
								<th>From Date</th>								
								<th>To date</th>
								<th>Contract file</th>
								<th>Contract status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (!empty($contractdata)) {
								foreach ($contractdata as $contract) {
                                                                ?>
								<div style="display: none; height:440px!important;overflow-y: scroll;" id="dialog_modal_<?php echo $contract["joc_id"] ?>" title="Contract detail - <?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?>" class="windia"> 
                                                                    <div id="historRecord" class="box">
                                                                            <div class="header">
                                                                                <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Contract detail</span></h2>
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="detailContainer">
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Name:</strong></div>
                                                                                        <div class="grid_3"><?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?></div>

                                                                                        <div class="grid_3"><strong>Email:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["joc_email"]; ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Campus:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["nome_centri"]; ?></div>

                                                                                        <div class="grid_3"><strong>Position:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["pos_position"]; ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>From date:</strong></div>
                                                                                        <div class="grid_3"><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></div>

                                                                                        <div class="grid_3"><strong>To date:</strong></div>
                                                                                        <div class="grid_3"><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Hours per week:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["joc_hourperweek_range"]; ?></div>

                                                                                        <div class="grid_3"><strong>Wages:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["joc_wages"]; ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Salary:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["joc_salary"]; ?></div>

                                                                                        <div class="grid_3"><strong>Currency:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["joc_currency"]; ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Residential:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["joc_res_non_res"]; ?></div>

                                                                                        <div class="grid_3"><strong>Extra activities:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["joc_extra_activities"]; ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Returnee:</strong></div>
                                                                                        <div class="grid_3"><?php echo ($contract["joc_returnee"] == 1 ? 'Yes' : 'No'); ?></div>

                                                                                        <div class="grid_3"><strong>Address:</strong></div>
                                                                                        <div class="grid_3"><?php echo ($contract["joc_address"]); ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>City:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["joc_city"]; ?></div>

                                                                                        <div class="grid_3"><strong>Postcode:</strong></div>
                                                                                        <div class="grid_3"><?php echo ($contract["joc_postcode"]); ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Country:</strong></div>
                                                                                        <div class="grid_3"><?php echo $contract["joc_country"]; ?></div>

                                                                                        <div class="grid_3"><strong>Status:</strong></div>
                                                                                        <div class="grid_3"><span id="pop_<?php echo $contract["joc_id"] ?>"><?php echo ($contract["joc_is_active"] == 1 ? 'Active' : 'Inactive'); ?></span></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Contract file:</strong></div>
                                                                                        <div class="grid_9 hlt-link"><a target="_blank" href="<?php echo base_url(). ACADEMIC_CONTRACT_FILE_PATH . $contract["joc_contract_file"];?>"><?php echo $contract["joc_contract_file"];?></a></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Contract status:</strong></div>
                                                                                        <div class="grid_3"><?php echo ($contract["joc_contract_signed"] == 1 ? "Signed and received" : "Sent"); ?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="box">
                                                                            <div class="header">
                                                                                <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Teachers detail</span></h2>
                                                                            </div>
                                                                            <div class="content detailContainer">
                                                                                <div  style="padding-top: 10px;" id="teacherDetail_<?php echo $contract['joc_id']; ?>"></div>
                                                                            </div>
                                                                        </div>
								</div>
								<tr>
                                                                    <td><?php echo $contract["nome_centri"]; ?></td>
                                                                    <td><?php echo $contract["pos_position"]; ?></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></td>
                                                                    <td class="hlt-link"><a target="_blank" href="<?php echo base_url(). ACADEMIC_CONTRACT_FILE_PATH . $contract["joc_contract_file"];?>"><?php echo $contract["joc_contract_file"];?></a></td>
                                                                    <td style="width:80px;"><?php echo ($contract["joc_contract_signed"] == 1 ? "Signed and received" : "Sent"); ?></td>
                                                                    <td class="center operation">
                                                                            <a title="View" href="javascript:void(0);" data-ta-id="<?php echo $contract["joc_application_id"]; ?>" data-track-id="<?php echo $contract['joc_id']; ?>" data-id="dialog_modal_btn_<?php echo $contract["joc_id"]; ?>" class="getappdetail dialogbtn">
                                                                                    <span class="icon-eye-open"></span>
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
	</section>	
</div>
<style>
    table tr td{
        height: 16px;
    }
</style>
<?php $this -> load -> view('plused_footer'); ?>