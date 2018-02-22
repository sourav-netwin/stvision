
<!DOCTYPE html>
<html lang="en" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Plus-Ed</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />

		<link rel="stylesheet" href="<?php echo base_url() ?>css/NA_style.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/external/jquery-ui-1.8.21.custom.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>css/elements.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/layout.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/typographics.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/NA_style.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>css/excursion.css" />

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
			.ui-dialog{
				width: auto !important;
			}
			.ui-dialog .ui-dialog-titlebar-close:before{
				content: 'x' !important;
				display: block !important;
				text-indent: 0 !important;
				margin-top: -2px !important;
			}
			.ui-dialog .ui-dialog-titlebar-close{
				color: rgb(0, 0, 0);
				background: rgb(239, 239, 239) none repeat scroll 0% 0%;
			}
			.ui-dialog .ui-dialog-titlebar-close:hover{
				color: rgb(255, 255, 255);
				background: rgb(195, 71, 71) none repeat scroll 0% 0%;
			}
			.ui-dialog .ui-dialog-buttonpane button{
				background: rgb(239, 239, 239) none repeat scroll 0% 0%;
			}
			.ui-dialog .ui-dialog-buttonpane button:hover{
				background: #5b9fea;
			}
		</style>
	</head>
	<body style="background-color:#FFF;">

		<div class="box">
			<div class="header">
				<h2 style="font-size: 11px"><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Nationalities not mapped with campus</h2>
			</div>
			<div class="content" style="padding: 0px !important;">
				<table class="dynamic styled">
					<thead>
						<tr>
							<th>#</th>
							<th>Campus</th>
							<th>Nationalities</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($campTemp) {
							$cnt = 0;
							foreach ($campTemp as $camp => $temp) {
								$dataCnt = 0;
								$dataVal = '';
								if (sizeof($temp) == 1) {
									if (isset($tempNoNationality[$temp[0]])) {
										if (!empty($tempNoNationality[$temp[0]])) {
											$dataCnt += 1;
											$dataVal = $tempNoNationality[$temp[0]];
										}
									}
								}
								if (sizeof($temp) == 2) {
									$ary1 = explode(', ', $tempNoNationality[$temp[0]]);
									$ary2 = explode(', ', $tempNoNationality[$temp[1]]);
									$dataVal = implode(', ', array_intersect($ary1, $ary2));
									if (!empty($dataVal)) {
										$dataCnt += 1;
									}
								}
								if (sizeof($temp) == 3) {
									$ary1 = explode(', ', $tempNoNationality[$temp[0]]);
									$ary2 = explode(', ', $tempNoNationality[$temp[1]]);
									$ary3 = explode(', ', $tempNoNationality[$temp[2]]);
									$dataVal = implode(', ', array_intersect($ary1, $ary2, $ary3));
									if (!empty($dataVal)) {
										$dataCnt += 1;
									}
								}
								if ($dataCnt > 0) {
									?>
									<tr>
										<td><?php echo ($cnt += 1); ?></td>
										<td><?php echo $camp ?></td>
										<td>
											<?php
											echo $dataVal;
											?>
										</td>

									</tr>
									<?php
								}
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>

		<div id="updatingAll"><img src="<?php echo base_url() ?>img/uploadingData.gif" title="Uploading data..." alt="Uploading data..."></div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript">
			var baseUrl = "<?php echo base_url(); ?>";
			var siteUrl = "<?php echo site_url(); ?>/";
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url() ?>js/bootstrap-timepicker.min.js"></script>
		<script type="text/javascript">
			var baseUrl = "<?php echo base_url(); ?>";
			var siteUrl = "<?php echo site_url(); ?>/";
		</script>
	</body>
</html>