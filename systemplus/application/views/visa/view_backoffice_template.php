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

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
	</head>
	<body style="background-color:#FFF;">
			<div class="col-12" style="background-color:#FFF;">
				<table style="width: 100%">
					<tr>
						<td colspan="2" style="text-align: center; padding-bottom: 5px; font-size: 13px" >Please select a template before print</td>
					</tr>
					<tr>
						<td style="font-size: 13px">Template</td>
						<td>
							<select style="font-size: 13px;width: 60%;" id="templSelWhole" name="templSelWhole" class="chznSelect">
								<option value="">Select One option</option>
								<option value="UKIR">UK/Ireland</option>
								<option value="USA">USA</option>
								<option value="MAL">Malta</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center; padding: 10px"><input style="height: 25px; font-size: 11px;" type="button" value="Print VISA" id="printBackVisa" /></td>
					</tr>
				</table>
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
		<script>
			$('#printBackVisa').on('click', function(){
				var templ = $('#templSelWhole').val();
				if(templ == '' || typeof templ == 'undefined'){
					alert('Please select a template');
				}
				else{
					window.open(siteUrl+"backoffice/pdf_visas/<?php echo $bookId ?>/"+templ);
				}
			});
		
		</script>
	</body>
</html>