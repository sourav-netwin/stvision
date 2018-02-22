<?php $this -> load -> view('plused_header'); ?>
<!-- The container of the sidebar and content box -->
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
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
	<style type="text/css">
		.container_12 .grid_2 {
			margin-bottom: 10px;
			padding: 0px 12px;
		}
		.container_12 .grid_2 label{
			font-weight: bold;
		}
		.chzn-container-single .chzn-single{
			width:100% !important;
		}
		.chzn-container .chzn-drop{
			width:106.7% !important;
		}
		input[type="text"]{
			width: 100%;
		}
		@media(max-width: 650px){
			table td, table th{
				min-height: 17px;
				width: auto !important;
				padding: 8px 12px !important;
			}
			#tot1{
				display: table-cell !important;
				height: 85px !important;
				vertical-align: bottom !important;
			}
			#tot2{
				display: table-cell !important;
				height: 119px !important;
				vertical-align: bottom !important;
			}
			.box{
				background-color: #ffffff;
			}
		}
		@media(max-width: 1065px){
			.container_12 .grid_2 {
				width: 18.667% !important;
			}
			.grid_1{
				width: 100% !important;
				text-align: center !important;
			}
		}
		@media(max-width: 935px){
			.container_12 .grid_2 {
				width: 98% !important;
			}
			.chzn-container-single .chzn-single{
				width: 302px !important;
			}
			.chzn-container .chzn-drop{
				width: 310px !important;
			}
			.customfile{
				width: 310px !important;
			}
			input[type="text"]{
				width: auto;
			}

		}
		@media(max-width: 405px){
			.chzn-container-single .chzn-single{
				width: 97% !important;
			}
			.chzn-container .chzn-drop{
				width: 100% !important;
			}
			.customfile{
				width: 100% !important;
			}
		}
	</style>
	<!-- Here goes the content. -->
	<section id="content" class="container_12 clearfix" data-sort=true>
		<h1 class="grid_12 margin-top no-margin-top-phone">Payments</h1>

		<div class="row">
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
						<h2>Payment Details</h2>
					</div>
					<div class="content" style="margin:10px;">
						<form id="addPaymentFinCM" name="addPaymentFinCM" action="<?php echo site_url() ?>/backoffice/insertCMSinglePayment" method="POST" onsubmit="return validateSubmit()"  enctype="multipart/form-data" >
							<div class="grid_2">
								<label>Type</label>
								<select class="form-control" id="P_typePay" name="P_typePay">
									<option value="paid">Paid</option>
									<!--<option value="due">Due</option>-->
									<option value="cashed">Cashed</option>
									<option value="refunded">Refunded</option>
								</select>
							</div>	
							<div class="grid_2">
								<label for="P_curDate">Payment date</label><br />
								<input class="form-control datepicker" type="text" id="P_curDate" name="P_curDate" readonly="readonly" />
							</div>	
							<div class="grid_2">
								<label for="P_amount">Amount/Due</label><br />
								<input class="form-control" type="text" id="P_amount" name="P_amount" maxlength="10" onkeypress="return keyRestrict(event,'1234567890');" />
							</div>	
							<div class="grid_2">
								<label>Currency</label>
								<select class="form-control" id="P_currency" name="P_currency">
									<option value="£">£</option>
									<option value="$">$</option>
									<option value="€">€</option>											
								</select>
							</div>									
							<div class="grid_2">
								<label>Service</label>
								<select class="form-control" id="P_operation" name="P_operation">
									<?php foreach ($payServices as $pS) { ?>
										<option value="<?php echo $pS["pcse_name"] ?>"><?php echo $pS["pcse_name"] ?></option>
									<?php } ?>
								</select>
							</div>		
							<div class="grid_2">
								<label>Method</label>
								<select class="form-control" id="P_method" name="P_method">
									<option value="CASH">CASH</option>
									<option value="CREDIT CARD">CREDIT CARD</option>
									<?php /*foreach ($payTypes as $pT) { ?>
										<option value="<?php echo $pT["pfcpt_name"] ?>"><?php echo $pT["pfcpt_name"] ?></option>
									<?php }*/ ?>
								</select>
							</div>	
							<!--<div class="grid_2">
								<label for="P_refBook">Referring Booking No.</label><br />
								<input class="form-control" type="text" id="P_refBook" name="P_refBook" maxlength="10" onkeypress="return keyRestrict(event,'1234567890');" />
							</div>	-->
							<div class="grid_2">
								<label>Booking ID</label>
								<select class="form-control" id="P_bookList" name="P_bookList">
									<option value="all">All</option>
									<?php
									if (!empty($payBookings)) {
										foreach ($payBookings as $pB) {
											?>
											<option value="<?php echo $pB["booking_id"] ?>"><?php echo $pB["booking_id"] ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>	
							<div class="grid_2">
								<label>Picture/File</label>
								<input type="file" name="CmPicFile" id="CmPicFile" style="z-index: 10 !important;" />
							</div>	
							<div class="grid_1 text-right">
								<button type="submit" style="margin-top:15px;" class="btn btn-primary" id="P_add" name="P_add" >Add</button>
							</div>
						</form>
					</div>
				</div>
			</div>	

			<div class="grid_12">
				<div class="box">
					<div class="header">
						<h2>Payment History</h2>
					</div>
					<div class="content" style="margin:10px; overflow: auto">
						<table class="styled" data-table-tools='{"display":false}'>
							<thead>
								<tr>
									<th>#</th><th>Booking ID</th><th>Operation Date</th><!--<th>Currency Date</th>--><th>Paid</th><th>Type</th><th>Cashed</th><th>Operation Type</th><th>Payment Method</th><th style="padding: 0 2px">Pictures/ Files</th><th style="padding: 0 2px">Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($payments)) {
									$totalDueGBP = 0;
									$totalDueUSD = 0;
									$totalDueEUR = 0;
									$totalCashedGBP = 0;
									$totalCashedUSD = 0;
									$totalCashedEUR = 0;
									$totalRefundGBP = 0;
									$totalRefundUSD = 0;
									$totalRefundEUR = 0;
									$totalDue = 0;
									$totalCashed = 0;
									$totalBalance = 0;
									$cnt = 1;
									$totalPaid = 0;
									$totalCashed = 0;
									foreach ($payments as $payment) {
										$fileExt = '';
										$iconName = '';
										if (!empty($payment['pcp_document'])) {
											$fileExt = pathinfo($payment['pcp_document'], PATHINFO_EXTENSION);
											if (strtolower($fileExt) == 'pdf') {
												$iconName = 'document-pdf.png';
											}
											else {
												$iconName = 'image.png';
											}
										}
										$clr = "#5e6267";
										if ($payment['pcp_pay_type'] == 'cashed') {
											$clr = "#090";
										}
										if ($payment['pcp_pay_type'] == 'paid') {
											$clr = "#c00";
										}
										if ($payment['pcp_pay_type'] == 'refunded') {
											$clr = "#FF6C00";
										}
										if ($payment['pcp_pay_type'] == 'paid') {
											$totalDue += $payment["pcp_amount"] * 1;
										}
										elseif ($payment['pcp_pay_type'] == 'cashed') {
											$totalCashed += $payment["pcp_amount"] * 1;
										}

										switch ($payment['pcp_currency']) {
											case "£":
												if ($payment['pcp_pay_type'] == 'paid') {
													$totalDueGBP += $payment["pcp_amount"] * 1;
												}
												elseif ($payment['pcp_pay_type'] == 'cashed') {
													$totalCashedGBP += $payment["pcp_amount"] * 1;
												}
												elseif ($payment['pcp_pay_type'] == 'refunded') {
													$totalRefundGBP += ($payment["pcp_amount"] * 1);
												}
												break;
											case "$":
												if ($payment['pcp_pay_type'] == 'paid') {
													$totalDueUSD += $payment["pcp_amount"] * 1;
												}
												elseif ($payment['pcp_pay_type'] == 'cashed') {
													$totalCashedUSD += $payment["pcp_amount"] * 1;
												}
												elseif ($payment['pcp_pay_type'] == 'refunded') {
													$totalRefundUSD += ($payment["pcp_amount"] * 1);
												}
												break;
											case "€":
												if ($payment['pcp_pay_type'] == 'paid') {
													$totalDueEUR += $payment["pcp_amount"] * 1;
												}
												elseif ($payment['pcp_pay_type'] == 'cashed') {
													$totalCashedEUR += $payment["pcp_amount"] * 1;
												}
												elseif ($payment['pcp_pay_type'] == 'refunded') {
													$totalRefundEUR += ($payment["pcp_amount"] * 1);
												}
												break;
										}
										?>
										<tr>
											<td><?php echo $cnt ?></td>
											<td><?php echo ucfirst($payment['pcp_book_id']) ?></td>
											<td><?php echo date('d/m/Y H:i', strtotime($payment['pcp_added_date'])) ?></td>
											<!--<td><?php //echo date('d/m/Y', strtotime($payment['pcp_pay_date']))      ?></td>-->
											<td style="text-align: right;"><div style="display: inline-block; white-space: nowrap;"> 
													<?php
													if ($payment['pcp_pay_type'] == 'paid') {
														echo number_format($payment['pcp_amount'], 2, ",", ".") . ' ' . $payment['pcp_currency'];
													}
													?>
												</div>
											</td>
											<td style="color:<?php echo $clr; ?>"><?php echo ucfirst($payment['pcp_pay_type']) ?></td>
											<td style="text-align: right;"><div style="display: inline-block; white-space: nowrap;">  
													<?php
													if ($payment['pcp_pay_type'] == 'cashed' || $payment['pcp_pay_type'] == 'refunded') {
														echo $payment['pcp_pay_type'] == 'cashed' ? number_format($payment['pcp_amount'], 2, ",", ".") . ' ' . $payment['pcp_currency'] : number_format(($payment['pcp_amount'] * -1), 2, ",", ".") . ' ' . $payment['pcp_currency'];
													}
													?>
												</div>
											</td>
											<td><?php echo $payment['pcp_service'] ?></td>
											<td><?php echo $payment['pcp_method'] ?></td>
											<td class="center" style="padding: 0 2px"><?php echo!empty($payment['pcp_document']) ? '<a href="' . PAYMENT_CM_DWNLD . $payment['pcp_document'] . '" target="_blank"><img src="' . base_url() . 'img/icons/packs/fugue/16x16/' . $iconName . '" /></a>' : '' ?></td>
											<td class="center" style="padding: 0 2px"><a href="javascript:void(0)" style="color: #FF0000" toolTip title="Delete" class="delPay" data-id="delPay_<?php echo $payment['pcp_id'] ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
										</tr>
										<?php
										$cnt += 1;
									}
									?>
									<tr>
										<td colspan="3" style="text-align: right; font-weight: bold">Total(GBP)</td><td style="text-align: right; font-weight: bold;"><div style="display: inline-block; white-space: nowrap;" id="tot1">  <?php echo number_format(($totalDueGBP), 2, ",", ".") . ' £' ?></div></td><td></td><td style="text-align: right; font-weight: bold;"><div style="display: inline-block; white-space: nowrap;">  <?php echo number_format(($totalCashedGBP - $totalRefundGBP), 2, ",", ".") . ' £' ?></div></td><td colspan="4" style="text-align: right; font-weight: bold;"><div style="display: inline-block; white-space: nowrap;" id="tot2">  <?php echo number_format((($totalCashedGBP - $totalRefundGBP) - $totalDueGBP), 2, ",", ".") . ' £' ?></div></td>
									</tr>
									<tr>
										<td colspan="3" style="text-align: right; font-weight: bold">Total(USD)</td><td style="text-align: right; font-weight: bold;"><div style="display: inline-block; white-space: nowrap;" id="tot1">  <?php echo number_format(($totalDueUSD), 2, ",", ".") . ' $' ?></div></td><td></td><td style="text-align: right; font-weight: bold;"><div style="display: inline-block; white-space: nowrap;">  <?php echo number_format(($totalCashedUSD - $totalRefundUSD), 2, ",", ".") . ' $' ?></div></td><td colspan="4" style="text-align: right; font-weight: bold;"><div style="display: inline-block; white-space: nowrap;" id="tot2">  <?php echo number_format((($totalCashedUSD - $totalRefundUSD) - $totalDueUSD), 2, ",", ".") . ' $' ?></div></td>
									</tr>
									<tr>
										<td colspan="3" style="text-align: right; font-weight: bold">Total(EUR)</td><td style="text-align: right; font-weight: bold;"><div style="display: inline-block; white-space: nowrap;" id="tot1">  <?php echo number_format(($totalDueEUR), 2, ",", ".") . ' €' ?></div></td><td></td><td style="text-align: right; font-weight: bold;"><div style="display: inline-block; white-space: nowrap;">  <?php echo number_format(($totalCashedEUR - $totalRefundEUR), 2, ",", ".") . ' €' ?></div></td><td colspan="4" style="text-align: right; font-weight: bold;"><div style="display: inline-block; white-space: nowrap;" id="tot2">  <?php echo number_format((($totalCashedEUR - $totalRefundEUR) - $totalDueEUR), 2, ",", ".") . ' €' ?></div></td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>	
			</form>
		</div>
	</section>	

</div>
<script>

	
	$(document).ready(function() {
		$( ".datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true,		  
			dateFormat: "dd/mm/yy",
			maxDate: "+1Y"
		}).datepicker("setDate", new Date());
		
		if($('.tuition_success').length > 0){
			setTimeout(function(){
				$($('.tuition_success')).fadeOut(5000, function(){
					$('.tuition_success').remove();
				});
			},10000);
		}
		
		$( "li#blncSht" ).addClass("current");
		$( "li#blncSht a" ).addClass("open");		
		$( "li#blncSht ul.sub" ).css('display','block');	
		$( "li#blncSht ul.sub li#blncSht_1" ).addClass("current");			
		
	});
	
	function validateSubmit(){
		var type = $('#P_typePay').val();
		var payDate = $('#P_curDate').val();
		var amount = $('#P_amount').val();
		var currency = $('#P_currency').val();
		var service = $('#P_operation').val();
		var method = $('#P_method').val();
		var bookList = $('#P_bookList').val();
		
		if(type == '' || typeof type == 'undefined'){
			alert('Plase select Type');
			return false;
		}
		else if(payDate == '' || typeof payDate == 'undefined'){
			alert('Plase select Payment Date');
			return false;
		}
		else if(amount == '' || typeof amount == 'undefined'){
			alert('Please enter the amount/due');
			return false;
		}
		else if(amount <= 0){
			alert('Amount should be greater than zero');
			return false;
		}
		else if(currency == '' || typeof currency == 'undefined'){
			alert('Plase select Currency');
			return false;
		}
		else if(service == '' || typeof service == 'undefined'){
			alert('Plase select Service');
			return false;
		}
		else if(method == '' || typeof method == 'undefined'){
			alert('Plase select Method');
			return false;
		}
		else if(bookList == '' || typeof bookList == 'undefined'){
			alert('Plase select Booking ID');
			return false;
		}
		else{
			var c = confirm('Are you sure to add this payment?');
			if(c){
				return true;
				
			}
			else{
				return false;
			}
		}
	}
	
	function checkBoook(refBook){
		if(refBook != '' && typeof refBook != 'undefined'){
			var retValue = 0;
			$.ajax({
				url: siteUrl+'backoffice/checkRefBooking',
				type: 'POST',
				async: false,
				data: {
					refBook: refBook
				},
				success: function(data){
					if(data == 1){
						retValue = '1';
					}
				}
			});
			return retValue;
		}
		else{
			return '1';
		}
		
	}
	
	$('body').on('click', '.delPay', function(){
		var selPay = $(this).attr('data-id').replace('delPay_','');
		if(selPay != '' && typeof selPay != 'undefined'){
			var c = confirm('Are you sure to delete this payment?');
			if(c){
				$.ajax({
					url: siteUrl+'backoffice/deleteCmPayment',
					type: 'POST',
					data: {
						selPay: selPay
					},
					success: function(data){
						location.reload(true);
					},
					error: function(){
						alert('Failed to delete payment');
					}
				});
			}
		}
	});
</script>	
<?php $this -> load -> view('plused_footer'); ?>
