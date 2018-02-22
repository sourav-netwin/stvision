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
				<li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
				<li class="line"></li>
				<li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
			</ul>
		</div>
	</section><!-- End of .toolbar-->
	<?php $this -> load -> view('plused_sidebar'); ?>
	<script type="text/javascript">
		$(function(){
			$( "li#mnujobcontract" ).addClass("current");
			$( "li#mnujobcontract a" ).addClass("open");		
			$( "li#mnujobcontract ul.sub" ).css('display','block');	
                        $( "li#mnujobcontract ul.sub li#mnujobcontract_3" ).addClass("current");
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
                    $("#btnClear").click(function(){
                        //window.location.href = "<?php //echo base_url().'index.php/teachers/review';?>";
                        setTimeout(function(){$("#btnSearchApplication").trigger('click');;},'500');

                    });
                        
                    $( "body" ).on( "click", ".getappdetail", function() {
                        var ta_id = $(this).attr('data-ta-id');
                        var id = $(this).attr('data-track-id');
                        $.post( "<?php echo base_url();?>index.php/teachers/applicationdetail",{
                                'id':ta_id
                            }, function( data ) {
                                $("#teacherDetail_"+id).html(data);
                        });
                    });
                        
		});
		$( "body" ).on( "click", "#btnSearchApplication", function() {
			var txtName = $('#txtName').val();
			var position = $('#selPosition').val();
			var sex = $('#selSex').val();
			var currency = $('#selCurrency').val();
			var type = $('#selType').val();
			var rate = $('#selRate').val();
			var txtCalFromDate = $('#txtCalFromDate').val();
			var txtCalToDate = $('#txtCalToDate').val();
                    
			$.post( "<?php echo base_url(); ?>index.php/jobofferhistory/searchAjax",{
				'txtName':txtName,
				'position':position,
				'sex':sex,
				'currency':currency,
				'type':type,
				'rate':rate,
				'txtCalFromDate':txtCalFromDate,
				'txtCalToDate':txtCalToDate
			}, function( data ) {
				var oTable = $('table.dynamic').dataTable();
				var ott = TableTools.fnGetInstance('tableSearchResults');
				if ( typeof ott != 'undefinded' && ott != null) ott.fnSelectNone();
				oTable.fnClearTable();
				//oTable.fnDestroy();
				oTable.fnAddData(data);
				oTable.fnDraw();
				$("table.dynamic tr td:last-child").addClass('center operation');
				//$("table.dynamic tr td:last-child").addClass('operation');
			},'json');
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
				<div class="content" style="margin: 10px 10px 25px;">
					<form action="<?php echo base_url().'index.php/jobofferhistory/exporthistory';?>" method="post">
						<div class="form-data grid_4" >
							<div class="left-class">
								<label for="txtName" style="width: 115px;">
									<strong>Name</strong>
								</label>
							</div>
							<div class="left-class" style="width:100%;">
								<input maxlength="100" style="width: 97%;" type="text" id="txtName" name="txtName" value="" />
							</div>
						</div>
						<div class="form-data grid_4" >
							<div class="left-class">
								<label for="selPosition" style="width: 115px;">
									<strong>Position</strong>
								</label>
							</div>
							<div class="left-class" style="width:100%;">
								<select id="selPosition" name="selPosition"  ><option value="0">Select Position</option>
									<?php
									if (!empty($positiondetails)) {
										foreach ($positiondetails as $value) {
											?>
											<option value="<?php echo $value['pos_id'] ?>"><?php echo $value['pos_position'] ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-data grid_4" >
							<div class="left-class">
								<label for="selSex" style="width: 115px;">
									<strong>Gender</strong>
								</label>
							</div>
							<div class="left-class" style="width:100%;">
								<select id="selSex" name="selSex"  >
									<option value="">All</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
						</div>

						<div class="form-data grid_4" >
							<div class="left-class">
								<label for="selCurrency" style="width: 115px;">
									<strong>Currency</strong>
								</label>
							</div>
							<div class="left-class" style="width:100%;">
								<select id="selCurrency" name="selCurrency" >
									<option value="">Select Currency</option>
									<option value="GBP">GBP</option>
									<option value="EUR">EUR</option>
									<option value="USD">USD</option>
								</select>
							</div>
						</div>
						<div class="form-data grid_4" >
							<div class="left-class">
								<label for="selType" style="width: 115px;">
									<strong>Type</strong>
								</label>
							</div>
							<div class="left-class" style="width:100%;">
								<select id="selType" name="selType" >
									<option value="">Select Type</option>
									<option value="London">London</option>
									<option value="Non London">Non London</option>
									<option value="Academy 1">Academy 1</option>
									<option value="Academy 2">Academy 2</option>
								</select>
							</div>
						</div>
						<div class="form-data grid_4" >
							<div class="left-class">
								<label for="selRate" style="width: 115px;">
									<strong>Rate</strong>
								</label>
							</div>
							<div class="left-class" style="width:100%;">
								<select id="selRate" name="selRate" >
									<option value="">Select Rate</option>
									<?php
									for ($rateInx = 13; $rateInx <= 28; $rateInx++) {
										?>
										<option value="<?php echo $rateInx; ?>"><?php echo $rateInx; ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>


						<div class="form-data grid_12" >
							<div class="left-class">
								<label for="txtCalFromDate" style="width: 115px;">
									<strong>Offer date range</strong>
								</label>
							</div>
							<div class="left-class" style="width:100%;">
								<span class="text">From Date: </span>
								<input type="text" style="width:23.3%;" id="txtCalFromDate" name="fd" value="" />
								<span style="margin-left:1.2%;" class="text">To Date: </span>
								<input style="width:25.9%;" type="text" id="txtCalToDate" name="td" value="" /> 
							</div>
						</div>
						<div class="form-data grid_12 mr-top-10">
							<input id="btnSearchApplication" type="button" value="Search" >
							<input id="btnClear" type="reset" value="Clear" >
                                                        <input style="float:right;" id="btnExport" type="submit" value="Export" >
						</div>
					</form>
				</div>
                            <div class="tabletools">
                                <div class="left"></div>
                                <div class="right">
                                <?php 
                                    $success_message = $this->session->flashdata('success_message');
                                    if(!empty($success_message))
                                    {
                                        ?><div class="tuition_success"><?php echo $success_message;?></div><?php 
                                    }
                                    $error_message = $this->session->flashdata('error_message');
                                    if(!empty($error_message))
                                    {
                                        ?><div class="tuition_error"><?php echo $error_message;?></div><?php 
                                    }
                                ?>
                                </div>
                            </div>
				<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting":[[1,"asc"]],"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'>
					<thead>
						<tr>
							<th>Applicant Name</th>
							<th>Position</th>
							<th>Type</th>								
							<th>Offer Letter</th>
							<th>Offer Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (is_array($historydetails)) {
							foreach ($historydetails as $value) {
								?>
							<tr>
								<td><?php echo $value['ta_firstname'] . ' ' . $value['ta_lastname'] ?>
                                                                <div style="display: none;overflow-y: scroll;" id="dialog_modal_<?php echo $value['jof_id'] ?>" title="Job History - <?php echo htmlspecialchars($value['ta_firstname'] . ' ' . $value['ta_lastname']) ?>" class="windia">
                                                                        <div id="historRecord" class="box">
                                                                            <div class="header">
                                                                                <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Job offer detail</span></h2>
                                                                            </div>
                                                                            <div class="content">
                                                                                <div class="detailContainer">
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Applicant Name:</strong></div>
                                                                                        <div class="grid_3"><?php echo html_entity_decode($value['ta_firstname'] . ' ' . $value['ta_lastname']); ?></div>

                                                                                        <div class="grid_3"><strong>Position:</strong></div>
                                                                                        <div class="grid_3"><?php echo $value['pos_position']; ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Type:</strong></div>
                                                                                        <div class="grid_3"><?php echo $value['jof_teacher_type']; ?></div>

                                                                                        <div class="grid_3"><strong>Currency:</strong></div>
                                                                                        <div class="grid_3"><?php echo $value['jof_currency']; ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Rate:</strong></div>
                                                                                        <div class="grid_3"><?php echo $value['jof_rates']; ?></div>

                                                                                        <div class="grid_3"><strong>Wage:</strong></div>
                                                                                        <div class="grid_3"><?php echo $value['jof_wages']; ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Offer Letter:</strong></div>
                                                                                        <div class="grid_9 hlt-link"><?php echo $value['job_offer_file'] ? '<a target="_blank" href="' . base_url() . SENT_JOB_OFFER_PATH . $value['job_offer_file'] . '">' . $value['job_offer_file'] . '</a>' : '' ?></div>
                                                                                    </div>
                                                                                    <div class="clr">
                                                                                        <div class="grid_3"><strong>Offer Date:</strong></div>
                                                                                        <div class="grid_9"><?php echo date('d/m/Y', strtotime($value['jof_created_on'])) ?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="box">
                                                                            <div class="header">
                                                                                <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Teachers detail</span></h2>
                                                                            </div>
                                                                            <div class="content detailContainer">
                                                                                <div style="padding-top: 10px;" id="teacherDetail_<?php echo $value['jof_id'] ?>"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
								<td><?php echo $value['pos_position'] ?></td>
								<td><?php echo $value['jof_teacher_type'] ?></td>
								<td class="hlt-link"><?php echo $value['job_offer_file'] ? '<a target="_blank" href="' . base_url() . SENT_JOB_OFFER_PATH . $value['job_offer_file'] . '">' . $value['job_offer_file'] . '</a>' : '' ?></td>
								<td><?php echo date('d/m/Y', strtotime($value['jof_created_on'])); ?></td>
								<td class="center operation">
                                                                    <a title="View" href="javascript:void(0);" data-ta-id="<?php echo $value["jof_teacher_app_id"]; ?>" data-track-id="<?php echo $value['jof_id'] ?>" data-id="dialog_modal_btn_<?php echo $value['jof_id'] ?>" class="getappdetail dialogbtn">
                                                                            <span class="icon-eye-open"></span>
                                                                    </a>
                                                                    <a title="Add to contract" href="<?php echo base_url();?>index.php/contract/addedit/contract/<?php echo $value['jof_teacher_app_id'] ?>" data-id="<?php echo $value['jof_teacher_app_id'] ?>" >
                                                                            <span class="icon-copy"> Contract</span>
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
	</section>	
</div>
<?php $this -> load -> view('plused_footer'); ?>