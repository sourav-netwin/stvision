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
	#printDiv{
		display: none;
	}
	#printBtn, #xlsBtn{
		background-color: #4C8CE1;
		padding: 0px 5px;
		color: rgb(255, 255, 255);
	}
	@media(max-width: 360px){
		#iconDiv{
			float: right;
		}
		#prntSpn{
			float: right !important;
		}
		#xlsSpn{
			float: none !important;
		}
		#hdMain h2{

		}
		#xlsSpn{
			margin-top: 13px;
		}
		#printBtn{
			display: inline-block;
			width: 10px;
			overflow: hidden;
			height: 15px;
			margin-top: -3px;
		}
		#xlsBtn{
			display: inline-block;
			width: 10px;
			overflow: hidden;
			height: 15px;
			margin-top: -3px;
		}
	}
	.bookPrint{
		display: none;
	}

	@media(max-width: 650px){
		table.styled thead tr th, table.styled tbody tr td{
			min-height: 17px;
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
	<!-- Here goes the content. -->
	<section id="content" class="container_12 clearfix" data-sort=true>
		<div class="grid_12">
			<div class="box">
				<div class="header" id="hdMain">
					<h2><?php echo $breadcrumb2;?>
						<span id="iconDiv"><span id="prntSpn" style="float: right;"><a id="printBtn" title="Print Credentials" style="padding: 3px 10px;margin-left: 10px;" href="javascript:void(0)" /><span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print Credentials</a></span>&nbsp;&nbsp;<span id="xlsSpn" style="float: right"><a title="Download Excel" style="padding: 3px 12px;" id="xlsBtn" href="javascript:void(0)" /><span class="glyphicon glyphicon-download"></span>&nbsp;&nbsp;Download Excel</a></span></span></h2>
				</div>
				<div class="content">
					<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": true,"bSortable": true},{"bSearchable": false,"bSortable": false}]}'>
						<thead>
							<tr>
								<th>#</th>
								<th>Booking ID</th>
								<th>Agent Nationality</th>
								<th>Arrival Date</th>
								<th>Departure Date</th>
								<th>No. GL(s)</th>
								<th>No. STD(s)</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$cnt = 1;
                                                        if($gldetails)
							foreach ($gldetails as $gld) {
								?>
								<tr>
									<td class="center"><?php echo $cnt ?></td>
									<td class="center"><?php echo $gld['book_id'] ?></td>
									<td class="center"><?php echo $gld['businesscountry'] ? '<img src="' . base_url() . 'img/flags/16/' . $gld['businesscountry'] . '.png" toolTip title="' . $gld['businesscountry'] . '"/>' : '' ?></td>
									<td class="center"><?php echo $gld['data_arrivo_campus'] ? date('d/m/Y', strtotime($gld['data_arrivo_campus'])) : '' ?></td>
									<td class="center"><?php echo $gld['data_partenza_campus'] ? date('d/m/Y', strtotime($gld['data_partenza_campus'])) : '' ?></td>
									<td class="center"><?php echo $gld['Glcount'] ?></td>
									<td class="center"><?php echo $gld['Stdcount'] ?></td>
									<td class="center">
										<?php
										if ($gld['Glcount'] > 0) {
											?>
											<a href="javascript:void(0)" class="xlsRow" data-id="<?php echo $gld['book_id'] ?>" title="Excel" toolTip><span class="glyphicon glyphicon-download"></span></a>&nbsp;&nbsp;<a href="javascript:void(0)" class="printRow" data-id="<?php echo $gld['book_id'] ?>" title="Print" toolTip><span class="glyphicon glyphicon-print"></span></a>
											<?php
										}
										?>
									</td>
								</tr>
								<?php
								$cnt += 1;
							}
							?>
						</tbody>
					</table>
					<table id="printDiv" style="border: 1px solid; border-collapse: collapse">
						<tr>
							<th colspan="6" style="text-align: center; border: 1px solid;">Survey URL: <a href="http://plus-ed.com/vision_ag/index.php/survey">http://plus-ed.com/vision_ag/index.php/survey</a></th>
						</tr>
						<tr>
							<th style="text-align: center; border: 1px solid;">#</th>
                                                        <th style="text-align: center; border: 1px solid;">Name</th>
                                                        <th style="text-align: center; border: 1px solid;">Surname</th>
                                                        <th style="text-align: center; border: 1px solid;">Date of birth</th>
                                                        <th style="text-align: center; border: 1px solid;">Pax Type</th>
                                                        <th style="text-align: center; border: 1px solid;">Booking ID</th>
						</tr>
						<?php
						$cnt = 1;
                                                if($gldetails)
						foreach ($gldetails as $gld) {
							if ($gld) {
								$gluuidArr = explode(',', $gld['gluuid']);
								if (!empty($gluuidArr)) {
									foreach ($gluuidArr as $uuid) {
										$uuidArr = explode(':', $uuid);
										$aVal = isset($uuidArr[2]) ? $uuidArr[2] : '';
										$bVal = isset($uuidArr[3]) ? $uuidArr[3] : '';
										$cVal = $gld['book_id'];
										$dVal = isset($uuidArr[0]) ? $uuidArr[0] : '';
										$eVal = '';
										if (isset($uuidArr[1])) {
											$eVal = $uuidArr[1] ? date('d/m/Y', strtotime($uuidArr[1])) : '';
										}
										?>
										<tr>
											<td style="border: 1px solid;"><?php echo $cnt; ?></td>
                                                                                        <td style="border: 1px solid;"><?php echo $aVal ?></td>
                                                                                        <td style="border: 1px solid;"><?php echo $bVal ?></td>
                                                                                        <td style="border: 1px solid;"><?php echo $eVal ?></td>
                                                                                        <td style="border: 1px solid;"><?php echo $dVal ?></td>
                                                                                        <td style="border: 1px solid;"><?php echo $cVal ?></td>
										</tr>
										<?php
										$cnt += 1;
									}
								}
							}
							?>
							<?php
						}
						?>
					</table>
					<?php
                                        if($gldetails)
					foreach ($gldetails as $gld) {
						if ($gld) {
							$gluuidArr = explode(',', $gld['gluuid']);
							if (!empty($gluuidArr)) {
								?>
								<table class="bookPrint" id="printDiv-<?php echo $gld['book_id'] ?>" style="border: 1px solid; border-collapse: collapse">
									<tr>
										<th colspan="6" style="text-align: center; border: 1px solid;">Survey URL: <a href="http://plus-ed.com/vision_ag/index.php/survey">http://plus-ed.com/vision_ag/index.php/survey</a></th>
									</tr>
									<tr>
										<th style="text-align: center; border: 1px solid;">#</th>
                                                                                <th style="text-align: center; border: 1px solid;">Name</th>
                                                                                <th style="text-align: center; border: 1px solid;">Surname</th>
                                                                                <th style="text-align: center; border: 1px solid;">Date of birth</th>
                                                                                <th style="text-align: center; border: 1px solid;">Pax Type</th>
                                                                                <th style="text-align: center; border: 1px solid;">Booking ID</th>
										<?php
										$cnt = 1;
										foreach ($gluuidArr as $uuid) {

											$uuidArr = explode(':', $uuid);
											$aVal = isset($uuidArr[2]) ? $uuidArr[2] : '';
											$bVal = isset($uuidArr[3]) ? $uuidArr[3] : '';
											$cVal = $gld['book_id'];
											$dVal = isset($uuidArr[0]) ? $uuidArr[0] : '';
											$eVal = '';
											if (isset($uuidArr[1])) {
												$eVal = $uuidArr[1] ? date('d/m/Y', strtotime($uuidArr[1])) : '';
											}
											?>

										</tr>
										<tr>
											<td style="border: 1px solid;"><?php echo $cnt; ?></td>
                                                                                        <td style="border: 1px solid;"><?php echo $aVal ?></td>
                                                                                        <td style="border: 1px solid;"><?php echo $bVal ?></td>
                                                                                        <td style="border: 1px solid;"><?php echo $eVal ?></td>
                                                                                        <td style="border: 1px solid;"><?php echo $dVal ?></td>
                                                                                        <td style="border: 1px solid;"><?php echo $cVal ?></td>
										</tr>

										<?php
										$cnt += 1;
									}
									?>
								</table>
								<?php
							}
						}
						?>
						<?php
					}
					?>

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
<script src="<?php echo base_url() ?>js/jquery.browser.min.js"></script>	
<script src="<?php echo base_url() ?>js/jquery.printElement.min.js"></script>
<script>
	$(document).ready(function() {
		$( "li#mngSrvy" ).addClass("current");
		$( "li#mngSrvy a" ).addClass("open");		
		$( "li#mngSrvy ul.sub" ).css('display','block');	
		$( "li#mngSrvy ul.sub li#mngSrvy_1" ).addClass("current");	
		
		$('[toolTip]').tipsy({gravity:'s'});
		$('body').on('click', '#printBtn', function(){
			$("#printDiv").printElement();
		});
		$('body').on('click', '.printRow', function(){
			var book = $(this).attr('data-id');
			$("#printDiv-"+book).printElement();
		});
	});
	$(document).on('click', '.paginate_button,.first paginate_button,.last paginate_button', function(){
		setTimeout(function(){
			$('[toolTip]').tipsy({gravity:'s'});
		},200);
	});
	
	$('body').on('click', '#xlsBtn', function(){
		window.open(siteUrl + 'backoffice/exportGldetails');
	});
	$('body').on('click', '.xlsRow', function(){
		var book = $(this).attr('data-id');
		window.open(siteUrl + 'backoffice/exportGldetailsRow/'+book);
	});
</script>	
<?php $this -> load -> view('plused_footer'); ?>
