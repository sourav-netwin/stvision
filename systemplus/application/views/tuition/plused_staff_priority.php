<?php $this->load->view('plused_header');?>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
	<!-- The container of the sidebar and content box -->
	<div role="main" id="main" class="container_12 clearfix">
	
		<!-- The blue toolbar stripe -->
		<section class="toolbar">
			<div class="user">
				<div class="avatar">
					<img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
					<!-- Evidenziare per icone attenzione <span>3</span> -->
				</div>
				<span><?php echo $this->session->userdata('businessname') ?></span>
				<ul>
					<li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
					<li class="line"></li>
					<li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
				</ul>
			</div>
		</section><!-- End of .toolbar-->
<?php $this->load->view('plused_sidebar');?>	
                <style>
                    .container_12 .grid_3 {
                        width: 26%;
                    }
                    @media screen and (max-width: 1050px) and (min-width: 500px) {
                        .hasDatepicker{
                            float: left !important;
                            margin-left: 5px;
                            position: absolute;
                            width: 70px !important;
                        }
                        .container_12 .grid_3 {
                            width: 31%;
                        }
                    }
                </style>
	<script>
	$(document).ready(function() {
		$( "li#mnutuition" ).addClass("current");
		$( "li#mnutuition a" ).addClass("open");		
		$( "li#mnutuition ul.sub" ).css('display','block');	
		$( "li#mnutuition ul.sub li#mnutuition_3" ).addClass("current");	
                var loadingImg = "<span class='imgLoading loadingSpan' style='float:right;position:absolute;'><img  src='<?php echo base_url().'img/tuition/throbber.gif'?>' /></span>"
                var saveAlert = "<span class='saveAlert loadingSpan' style='float:right;position:absolute;color:green;'><i class='glyphicon glyphicon-ok'></i></span>"

                $( "body" ).on( "blur", ".priorityText", function() {
                    var con_id = $(this).attr('data-id');
                    var priority = $(this).val();
                    var thisEle = $(this);
                    thisEle.parent().append(loadingImg);
                    $.post( "<?php echo base_url();?>index.php/staff/changepriority",{
                            'con_id':con_id,
                            'priority':priority
                        }, function( data ) {
                            //$("#btnReload").trigger('click');
                            thisEle.parent().find(".imgLoading").replaceWith(saveAlert);
                            thisEle.parent().find(".saveAlert").fadeOut(4500);
                    });
                });
                
                $( "body" ).on( "click", "#btnReload", function() {
                    var campus = $('#selCampus').val();
                    var position = $('#selPosition').val();
                    var fromDate = $("#txtCalFromDate").val();
                    var toDate = $("#txtCalToDate").val();
                    $.post( "<?php echo base_url();?>index.php/staff/contract_ajax",{
                                'campus':campus,
                                'position':position,
                                'fromDate':fromDate,
                                'toDate':toDate
                            }, function( data ) {
                        var oTable = $('table.dynamic').dataTable();
                        oTable.fnClearTable();
                        oTable.fnAddData(data);
                        oTable.fnDraw();
                        $("#data-grid tr td").addClass('center');
                        $("#data-grid tr td:last-child").addClass('operation');
                    },'json');
                });
                
                $( "body" ).on( "click", "#btnClear", function() {
                    $('#selCampus').val('');
                    $('#selPosition').val('');
                    $('#txtCalFromDate').val('<?php echo $fromDate;?>');
                    $('#txtCalToDate').val('<?php echo $toDate;?>');
                    $("#selCampus").trigger("liszt:updated");
                    $("#selPosition").trigger("liszt:updated");
                    $("#btnReload").trigger('click');
                });
                
                $( "#txtCalFromDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",		
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$(".txtCalFromDate").val(selectedDate);
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
                                    $(".txtCalToDate").val(selectedDate);
                                    $( "#txtCalFromDate" ).datepicker( "option", "maxDate", selectedDate );
                            }
                });
                
	});
	</script>	
		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Staff priority</h2>
					</div>
					
					<div class="content">
                                            <div id="priority-box" class="row" >
                                                <div class="grid_3">
                                                <select id="selCampus" autocomplete="off" name="selCampus"  >
                                                    <option value="">Select Campus</option>
                                                    <?php
                                                    if (!empty($campuses)) {
                                                        foreach ($campuses as $campus) {
                                                            ?>
                                                            <option value="<?php echo $campus['id'] ?>"><?php echo $campus['nome_centri'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                </div>
                                                <div class="grid_3">
                                                    <select id="selPosition" autocomplete="off" name="selPosition"  >
                                                        <option value="">Select Position</option>
                                                        <?php
                                                        if (!empty($positions)) {
                                                            foreach ($positions as $position) {
                                                                ?>
                                                                <option value="<?php echo $position['pos_id'] ?>"><?php echo $position['pos_position'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="grid_3">
                                                    <label style="vertical-align: middle;" for="txtCalFromDate">From date:</label> <input autocomplete="off" style="float:right;" type="text" id="txtCalFromDate" name="fd" value="<?php echo $fromDate;?>" />
                                                </div>
                                                <div class="grid_3" style="clear: both;">
                                                    <label style="vertical-align: middle;" for="txtCalToDate">To Date:</label> <input autocomplete="off" style="float:right;" type="text" id="txtCalToDate" name="td" value="<?php echo $toDate;?>" />
                                                </div>
                                                <div class="grid_6">
                                                    <input type="button" value="Show / Reload" id="btnReload" />
                                                    <input type="button" value="Clear" id="btnClear" />
                                                </div>
                                                
                                            </div>
						<div class="tabletools">
                                                    <div class="left">
                                                    </div>
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
						<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aaSorting": [],"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'> <!-- OPTIONAL: with-prev-next -->
						<thead>
							<tr>
								<th>Campus</th>
								<th>Position</th>
								<th>Applicant Name</th>
								<th>Email</th>
								<th>Available From</th>								
								<th>Available To</th>
								<th>Priority</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (!empty($contractdata)) {
								foreach ($contractdata as $contract) {
                                                                ?>
								<div style="display: none; height:440px!important;overflow-y: scroll;" id="dialog_modal_<?php echo $contract["joc_id"] ?>" title="Contract detail - <?php echo htmlentities($contract['ta_firstname'] . ' ' . $contract['ta_lastname']); ?>" class="windia"> 
                                                                        <div class="box">
                                                                            <div class="header">
                                                                                <h2><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png" class="icon"><span >Teachers detail</span></h2>
                                                                            </div>
                                                                        </div>
								</div>
								<tr>
                                                                    <td><?php echo $contract["nome_centri"]; ?></td>
                                                                    <td><?php echo $contract["pos_position"]; ?></td>
                                                                    <td><?php echo $contract['ta_firstname'] . ' ' . $contract['ta_lastname']; ?></td>
                                                                    <td><?php echo $contract["joc_email"]; ?></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($contract["joc_from_date"])); ?></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($contract["joc_to_date"])); ?></td>
                                                                    <td class="center operation">
                                                                        <input type="text" data-id="<?php echo $contract["joc_id"];?>" autocomplete="off" onkeypress="return keyRestrict(event,'1234567890');" class="priorityText" value="<?php echo $contract['joc_staff_priority'];?>" maxleght="5" />
                                                                    </td>
								</tr>
								<?php
							}
						}
						?>
						</tbody>
					</table>
					</div><!-- End of .content -->
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
			
		</section><!-- End of #content -->
		
	</div><!-- End of #main -->
	
<?php $this->load->view('plused_footer');?>