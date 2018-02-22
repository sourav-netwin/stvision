<?php
/**
 * @modified_by Arunsankar S
 * @date : 07-04-2016
 */
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Vision - Plus-Ed</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/NA_style.css" />

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			.panel-title{
				font-size:12px;
			}
		</style>
		<script type="text/javascript">
			var arraycontabkgs = new Array();
		</script>
	</head>
	<body style="background-color:#fff;height:100%;">
		<div class="container-fluid">
			<ul class="nav nav-pills" role="tablist">
				<li role="presentation" class="active"><a href="#d" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span>Balance detail - <?php echo $campusName ?></a></li>
				<li role="presentation" class="pull-right"><a id="backToList" data-toggle="pill" style="cursor: pointer !important;"><span class="glyphicon glyphicon-chevron-left"></span> Back</a></li>
			</ul>
			<div class="tab-content" style="margin-top:10px;">
				<div class="tab-pane fade in active" id="d">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row-fluid">
								<div class="col-12">
									<table class="table table-bordered table-condensed table-striped" style="font-size:9px;">
										<thead>
											<tr>
												<th>#</th><th>Booking ID</th><th>Operation date</th><!--<th>Currency Date</th>--><th>Paid</th><th>Type</th><th>Cashed</th><th>Operation Type</th><th>Payment Method</th><th style="padding: 0 2px;width: 50px;">Pictures/ Files</th>
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
														<!--<td><?php //echo date('d/m/Y', strtotime($payment['pcp_pay_date']))            ?></td>-->
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
														<td class="text-center" style="padding: 0 2px"><?php echo!empty($payment['pcp_document']) ? '<a href="' . PAYMENT_CM_DWNLD . $payment['pcp_document'] . '" target="_blank"><img src="' . base_url() . 'img/icons/packs/fugue/16x16/' . $iconName . '" /></a>' : '' ?></td>
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
					</div>
				</div>
			</div>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript">
			var baseUrl = "<?php echo base_url(); ?>";
			var siteUrl = "<?php echo site_url(); ?>/";
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
		<?php /*
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
		  <script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/sorting/datetime-moment.js"></script>
		 */ ?>
		<script>
			$('#backToList').click(function(){
				parent.history.back();
				return false;
			});
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();
			});
		</script>
	</body>
</html>