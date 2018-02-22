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
			tr.newBkList td:nth-child(2) {
				width: 40px !important;
				font-weight: inherit !important;
				font-size: 10px !important;
			}
			tr.newBkList td:nth-child(4) {
				width: 90px;
				text-align: right !important;
			}
			.tooltip{
				font-size: 10px;
			}
			tr.newBkList td:nth-child(7){
				text-indent: 0px !important;
			}
			tr.newBkList td:nth-child(6){
				color: #000 !important;
				font-weight: normal !important;
				font-size: 10px !important;
			}
			tr.newBkList td:nth-child(5) {
				color: #000 !important;
				font-weight: normal !important;
				font-size: 10px !important;
			}
			tr.newBkList td:first-child {
				font-weight: normal !important;
			}
		</style>
		<script type="text/javascript">
			var arraycontabkgs = new Array();
		</script>
	</head>
	<body style="background-color:#fff;height:100%;">
		<div class="container-fluid">
			<ul class="nav nav-pills" role="tablist">
				<li role="presentation" class="active"><a href="#d" data-toggle="pill"><span class="glyphicon glyphicon-calendar"></span>Balance detail</a></li>
			</ul>
			<div class="tab-content" style="margin-top:10px;">
				<div class="tab-pane fade in active" id="d">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row-fluid">
								<div class="col-12">
									<?php
									if (!empty($balances)) {
										$totalDueGBP = 0;
										$totalDueUSD = 0;
										$totalDueEUR = 0;
										$totalCashedGBP = 0;
										$totalCashedUSD = 0;
										$totalCashedEUR = 0;
										$totalRefundGBP = 0;
										$totalRefundUSD = 0;
										$totalRefundEUR = 0;
										$totalCashedDueGBP = 0;
										$totalCashedDueUSD = 0;
										$totalCashedDueEUR = 0;
										$totalDue = 0;
										$totalCashed = 0;
										$totalBalance = 0;
										foreach ($balances as $balance) {
											?>
											<input type="button" id="btnToggle_<?php echo $balance['campus_id'] ?>" class="btn btn-primary btnToggle" value="<?php echo $balance["nome_centri"]; ?>">
											<div id="tabAvail_<?php echo $balance['campus_id'] ?>" class="collapse in">
												<table class="table table-bordered table-condensed table-striped tabAvail" style="font-size:9px;">
													<thead>
														<tr>
															<th class="text-center">Campus Name</th>
															<th class="text-center">Currency</th>
															<th class="text-right">Total Paid</th>
															<th class="text-right">Total Cashed</span></th>
															<th class="text-right">Total Refunded</th>
															<th class="text-right">Total Balance</th>
															<th class="text-center">Download Documents</th>
														</tr>
													</thead>
													<tbody>
														<tr class="newBkList">

															<td class="text-center" rowspan="3"><button type="button" class="btn btn-default btn-xs viewRefCampus" data-toggle="tooltip" data-placement="top" title="View Balance <?php echo $balance["nome_centri"] ?>" id="cmpRef_<?php echo $balance["campus_id"] ?>"><?php echo $balance["nome_centri"] ?></button></td>
															<td class="text-center">GBP</td>
															<td class="text-right"><?php echo number_format($balance["total_due_gbp"], 2, ",", ".") . ' £' ?></td>
															<td class="text-right"><?php echo number_format($balance["total_cashed_gbp"], 2, ",", ".") . ' £' ?></td>
															<td class="text-right"><?php echo number_format(($balance["total_refunded_gbp"] * -1), 2, ",", ".") . ' £' ?></td>
															<td class="text-right"><?php echo number_format($balance["total_cashed_paid_gbp"], 2, ",", ".") . ' £' ?></td>
															<td class="text-center" rowspan="3">
																<?php
																if (!empty($balance['documents'])) {
																	?>
																	<a href="javascript:void(0)" class="downDocument" data-id="down_<?php echo $balance["campus_id"] ?>"><img src="<?php echo base_url() ?>img/icons/packs/fugue/16x16/folder-zipper.png" /></a>
																	<?php
																}
																?>
															</td>
														</tr>
														<tr class="newBkList">
															<td class="text-center">USD</td>
															<td class="text-right"><?php echo number_format($balance["total_due_usd"], 2, ",", ".") . ' $' ?></td>
															<td class="text-right"><?php echo number_format($balance["total_cashed_usd"], 2, ",", ".") . ' $' ?></td>
															<td class="text-right"><?php echo number_format(($balance["total_refunded_usd"] * -1), 2, ",", ".") . ' £' ?></td>
															<td class="text-right"><?php echo number_format($balance["total_cashed_paid_usd"], 2, ",", ".") . ' $' ?></td>
														</tr>
														<tr class="newBkList">
															<td class="text-center">EUR</td>
															<td class="text-right"><?php echo number_format($balance["total_due_eur"], 2, ",", ".") . ' €' ?></td>
															<td class="text-right"><?php echo number_format($balance["total_cashed_eur"], 2, ",", ".") . ' €' ?></td>
															<td class="text-right"><?php echo number_format(($balance["total_refunded_eur"] * -1), 2, ",", ".") . ' £' ?></td>
															<td class="text-right"><?php echo number_format($balance["total_cashed_paid_eur"], 2, ",", ".") . ' €' ?></td>
														</tr>


														<?php
														$totalDueGBP += $balance["total_due_gbp"] * 1;
														$totalCashedGBP += $balance["total_cashed_gbp"] * 1;
														$totalRefundGBP += $balance["total_refunded_gbp"] * 1;
														$totalDueUSD += $balance["total_due_usd"] * 1;
														$totalCashedUSD += $balance["total_cashed_usd"] * 1;
														$totalRefundUSD += $balance["total_refunded_usd"] * 1;
														$totalDueEUR += $balance["total_due_eur"] * 1;
														$totalCashedEUR += $balance["total_cashed_eur"] * 1;
														$totalRefundEUR += $balance["total_refunded_eur"] * 1;
														$totalCashedDueGBP += $balance["total_cashed_paid_gbp"] * 1;
														$totalCashedDueUSD += $balance["total_cashed_paid_usd"] * 1;
														$totalCashedDueEUR += $balance["total_cashed_paid_eur"] * 1;
														?>

													</tbody>
												</table>
											</div>
											<?php
										}
									}
									else {
										echo '<div style="color:#FF0000; text-align:center">No Balances found.</div>';
									}
									?>
								</div>					
							</div>
							<?php
							if (!empty($balances)) {
								?>
								<div class="row-fluid">
									<table class="table table-bordered table-condensed table-striped" style="font-size:9px;">
										<thead>
											<tr>
												<th class="text-center">Currency</th>
												<th class="text-right">Total Paid</th>
												<th class="text-right">Total Cashed</th>
												<th class="text-right">Total Refunded</th>
												<th class="text-right">Total Balance</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-center">GBP</td>
												<td class="text-right"><?php echo number_format($totalDueGBP, 2, ",", ".") . " GBP"; ?></td>
												<td class="text-right"><?php echo number_format($totalCashedGBP, 2, ",", ".") . " GBP"; ?></td>
												<td class="text-right"><?php echo number_format(($totalRefundGBP * -1), 2, ",", ".") . " GBP"; ?></td>
												<td class="text-right"><?php echo number_format($totalCashedDueGBP, 2, ",", ".") . " GBP"; ?></td>
											</tr>
											<tr>
												<td class="text-center">USD</td>
												<td class="text-right"><?php echo number_format($totalDueUSD, 2, ",", ".") . " USD"; ?></td>
												<td class="text-right"><?php echo number_format($totalCashedUSD, 2, ",", ".") . " USD"; ?></td>
												<td class="text-right"><?php echo number_format(($totalRefundUSD * -1), 2, ",", ".") . " USD"; ?></td>
												<td class="text-right"><?php echo number_format($totalCashedDueUSD, 2, ",", ".") . " USD"; ?></td>
											</tr>
											<tr>
												<td class="text-center">EUR</td>
												<td class="text-right"><?php echo number_format($totalDueEUR, 2, ",", ".") . " EUR"; ?></td>
												<td class="text-right"><?php echo number_format($totalCashedEUR, 2, ",", ".") . " EUR"; ?></td>
												<td class="text-right"><?php echo number_format(($totalRefundEUR * -1), 2, ",", ".") . " EUR"; ?></td>
												<td class="text-right"><?php echo number_format($totalCashedDueEUR, 2, ",", ".") . " EUR"; ?></td>
											</tr>								
										</tbody>
									</table>
								</div>
							<?php } ?>
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


			$(document).ready(function(){


				$('[data-toggle="tooltip"]').tooltip();
				$('.downDocument').click(function(){
					var selCampus = $(this).attr("data-id").replace("down_","");
					window.open(siteUrl + 'bo_accounting/downloadAllCmDocument/'+selCampus, '_blank');
					return false;
				});
				$('.viewRefCampus').on('click', function(){
					var selCampus = $(this).attr("id").replace("cmpRef_","");
					window.location.href = siteUrl + 'bo_accounting/viewSingleCmTr/'+selCampus;
				}); 

			});
		</script>
	</body>
</html>