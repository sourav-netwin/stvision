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
		<?php
		$lockAll = 0;
		if ($locked == 'locked') {
			?>
			<table style="width: 100%; background: #FFF;">
				<tr>
					<td>
						Initial page template
					</td>
					<td style="padding: 10px">
						<?php
						if ($book[0]['template'] != '') {
							$tempTitle = '';
							if ($book[0]["template"] == 'UKIR') {
								$tempTitle = 'UK/Ireland';
							}
							if ($book[0]["template"] == 'USA') {
								$tempTitle = 'USA';
							}
							if ($book[0]["template"] == 'MAL') {
								$tempTitle = 'Malta';
							}
							if ($book[0]['template'] == 'UKIRGLSTD') {
								$tempTitle = 'UK/Ireland - GL Standard';
							}
							if ($book[0]['template'] == 'UKIRSTDSTD') {
								$tempTitle = 'UK/Ireland - STD Standard';
							}
							if ($book[0]['template'] == 'UKIRSTDST') {
								$tempTitle = 'UK/Ireland - STD Short Term';
							}
							$lockAll += 1;
							?>
							<input type="hidden" value="<?php echo $book[0]['template']; ?>" id="initTmpl" />
							<select disabled="disabled" title="<?php echo $tempTitle; ?>" style="width: 77px"><option selected="selected" value="<?php echo $book[0]['template']; ?>"><?php echo $tempTitle; ?></option></select>
							<?php
						}
						else {
							?>
							<select id="initTmpl" style="width: 77px">
								<?php
								$selLoc = array();
								$dspCnt = 1;
								$marSus = 0;
								foreach ($detMyPaxFir as $mypax) {
									$locAdd = 0;
									?>

									<?php
									foreach ($templates as $template) {
										$chk = 0;
										$location = '';
										if ($template['template'] == 'USA') {
											$location = 'USA';
											if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
												$chk += 1;
											}
										}
										if ($template['template'] == 'UKIR') {
											$location = 'UK/Ireland';
											if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
												$chk += 1;
											}
										}
										if ($template['template'] == 'MAL') {
											$location = 'Malta';
											if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
												$chk += 1;
											}
										}
										if ($template['template'] == 'UKIRGLSTD') {
											$location = 'UK/Ireland - GL Standard';
											if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
												$chk += 1;
											}
										}
										if ($template['template'] == 'UKIRSTDSTD') {
											$location = 'UK/Ireland - STD Standard';
											if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
												$chk += 1;
											}
										}
										if ($template['template'] == 'UKIRSTDST') {
											$location = 'UK/Ireland - STD Short Term';
											if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
												$chk += 1;
											}
										}
										if (($chk > 0) && (!in_array($location, $selLoc))) {
											$selLoc[] = $location;
											$marSus += 1;
											if ($dspCnt == 1) {
												?>
												<option value="">Select</option>
												<?php
												$dspCnt += 1;
											}
											?>
											<option value="<?php echo $template['template'] ?>"><?php echo $location ?></option>
											<?php
										}
										$chk = 0;
									}
								}
								if ($marSus == 0) {
									?>
									<option value="">NA</option>
									<?php
								}
								?>
		<!--<select id="initTmpl">
			<option value="">Select</option>
			<option value="UKIR">UK/Ireland</option>
			<option value="USA">USA</option>
			<option value="MAL">Malta</option>-->
							</select>
							<span class="selInitTmplDemo" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -4px; font-size: 13px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>

							<?php
						}
						?>


					</td>
				</tr>
			</table>
			<?php
		}
		if (!empty($detMyPax)) {
			?>
			<div class="box">
				<div class="header">
					<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Pax list</h2>
				</div>
				<div class="content" style="padding: 0px !important;">
					<table class="table table-bordered table-condensed table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Template</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$cnt = 1;
							foreach ($detMyPax as $mypax) {
								$dspCnt = 1;
								$marSus = 0;
								?>
								<tr>
									<td><?php echo $cnt; ?></td>
									<td><?php echo $mypax["cognome"] ?> <?php echo $mypax["nome"] ?></td>
									<td>
										<select style="width: 77px" id="templSelWhole_<?php echo $mypax['id_prenotazione'] ?>" class="chznSelect">

											<?php
											foreach ($templates as $template) {
												$chk = 0;
												$location = '';
												if ($template['template'] == 'USA') {
													$location = 'USA';
													if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
														$chk += 1;
													}
												}
												if ($template['template'] == 'UKIR') {
													$location = 'UK/Ireland';
													if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
														$chk += 1;
													}
												}
												if ($template['template'] == 'MAL') {
													$location = 'Malta';
													if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
														$chk += 1;
													}
												}
												if ($template['template'] == 'UKIRGLSTD') {
													$location = 'UK/Ireland - GL Standard';
													if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
														$chk += 1;
													}
												}
												if ($template['template'] == 'UKIRSTDSTD') {
													$location = 'UK/Ireland - STD Standard';
													if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
														$chk += 1;
													}
												}
												if ($template['template'] == 'UKIRSTDST') {
													$location = 'UK/Ireland - STD Short Term';
													if ($template['template'] . $mypax["nat_id"] == $template['tempMap']) {
														$chk += 1;
													}
												}
												if ($chk > 0) {
													$marSus += 1;
													if ($dspCnt == 1) {
														?>
														<option value="">Select</option>
														<?php
														$dspCnt += 1;
													}
													?>
													<option value="<?php echo $template['template'] ?>"><?php echo $location ?></option>
													<?php
												}
												$chk = 0;
											}
											if ($marSus == 0) {
												?>
												<option value="">NA</option>
												<?php
											}
											?>
										</select>
										<span class="tmplDemo" data-id="<?php echo $mypax['id_prenotazione'] ?>" title="Preview Template" style="display: none; vertical-align: text-top; margin-top: -3px; margin-bottom: -4px; font-size: 13px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>
									</td>
								</tr>
								<?php
								$cnt += 1;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<?php
		}
		?>




		<div class="col-12" style="background-color:#FFF;">
			<table style="width: 100%">
				<tr>
					<td colspan="2" style="text-align: center; padding: 10px"><input type="button" value="Print VISA" id="printLockedVisa" /></td>
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
			var bookId = "<?php echo $bookId ?>";
			$('#printLockedVisa').on('click', function(){
				var parentLocation = window.parent.location+'';
				var parentLocationArray = parentLocation.split("/");
				if((parentLocationArray[parentLocationArray.length - 1] == 'a') || (parentLocationArray[parentLocationArray.length - 1] == 'b')){
					var cnt = 0;
					parentLocation = '';
					$.each(parentLocationArray, function(i, item) {
						cnt += 1;
						if(cnt <= parentLocationArray.length - 1){
							parentLocation += item+'/'
						}
					});
					parentLocation += 'b'
				}
				else{
					parentLocation += '/b'
				}
				var iniTmpl = $('#initTmpl').val();
				var iniUri = '';
				var locked = "<?php echo $locked ?>";
				if((iniTmpl == '' && locked == 'locked') || (typeof iniTmpl == 'undefined' && locked == 'locked')){
					alert('Please select initial page template');
					return false;
				}
				if(iniTmpl != '' && typeof iniTmpl != 'undefined'){
					iniUri = '-'+iniTmpl;
				}
				var rowIds = '';
				var rowArr = [];
				var SelTmplCount = 0;
				$('.tempSel', parent.document).each(function(){
					var rowId = $(this).attr('id').replace('selTemp_', '');
					var selValue = $(this).val();
					$('.chznSelect').each(function(){
						var idRow = $(this).attr('id').replace('templSelWhole_', '');
						var valSelect = $(this).val();
						rowArr.push(idRow+'-'+valSelect);
					});
					rowArr.push(rowId+'-'+selValue);
					var elm1 = $('#selTemp_'+rowId);
					if($('#selTemp_'+rowId).parent().find('input[id=selTemp_'+rowId+']').length == 0){
						elm1.attr('disabled', 'disabled');
						elm1.removeClass('tempSel');
						elm1.removeAttr('id');
						elm1.parent().prepend('<input type="hidden" class="tempSel" id="selTemp_'+rowId+'" value="'+selValue+'" />');
					}
					if($(this).val() != '' && typeof $(this).val() != 'undefined'){
						if(SelTmplCount == 0){
							rowIds += $(this).attr('id').replace('selTemp_', '')+'-'+$(this).val();
						}
						else{
							rowIds += '/'+$(this).attr('id').replace('selTemp_', '')+'-'+$(this).val();
						}
						SelTmplCount += 1;
					}
				});
				var noselCnt = 0;
				var selCount = 0;
				var c = true;
				$('.chznSelect').each(function(){
					if($(this).val() != '' && typeof $(this).val() != 'undefined'){
						if(!$(this).is('input[type=hidden]')){
							selCount += 1;
						}
						if(SelTmplCount == 0){
							rowIds += $(this).attr('id').replace('templSelWhole_', '')+'-'+$(this).val();
						}
						else{
							rowIds += '/'+$(this).attr('id').replace('templSelWhole_', '')+'-'+$(this).val();
						}
						SelTmplCount += 1;
					}
					else{
						noselCnt += 1;
					}
				});
				if($('#initTmpl').length > 0){
					if(!$('#initTmpl').is('input[type=hidden]')){
						selCount += 1;
					}
				}
				if(noselCnt > 0){
					alert('Please select one template from each row');
					return false;
				}
				else{
					if(selCount > 0){
						c = confirm('Are you sure to print VISA? The template once selected can not change again.');
					}
					if(c){
						$.ajax({
							url: siteUrl+'agents/lockAllTmpl',
							type: 'POST',
							data: {
								rowArr: JSON.stringify(rowArr),
								iniTmpl: iniTmpl,
								bookId: bookId
							},
							success: function(data){
								if(data == 1){
									if($('input[id=initTmpl]').length == 0){
										var elm = $('#initTmpl');
										elm.attr('disabled', 'disabled');
										elm.removeAttr('id');
										elm.parent().prepend('<input type="hidden" value="'+iniTmpl+'" id="initTmpl" />');
									}
									window.parent.location.href = parentLocation;
									window.open(siteUrl+"agents/pdfLockedVisas/<?php echo $bookId ?>"+iniUri+"/"+rowIds);
								}
								else if(data == 2){
									alert('Missing/Invalid nationalities found');
								}
								else{
									alert('Error occured. Can not print VISA.');
								}
							},
							error: function(){
								alert('Error occured. Can not print VISA.');
							}
						});
					}
				}
			});
			$(document).on('click','.selInitTmplDemo', function(){
				var templ = $('#initTmpl').val();
				if(templ != '' && typeof templ != 'undefined'){
					window.open(siteUrl+'agents/visaPDFDemo/'+templ);
				}
			});
			$(document).on('change','#initTmpl', function(){
				var value = $(this).val();
				if(value != '' && typeof value != 'undefined'){
					$('.selInitTmplDemo').css('display', 'inline-block');
				}
				else{
					$('.selInitTmplDemo').css('display', 'none');
				}
				
			});
			$(document).on('click','.selTmplDemo', function(){
				var id = $(this).attr('data-id');
				var templ = $('#templSelWhole_'+id).val();
				if(templ != '' && typeof templ != 'undefined'){
					window.open(siteUrl+'agents/visaPDFDemo/'+templ);
				}
			});
			$(document).on('click','.tmplDemo', function(){
				var id = $(this).attr('data-id');
				var templ = $('#templSelWhole_'+id).val();
				if(templ != '' && typeof templ != 'undefined'){
					window.open(siteUrl+'agents/visaPDFDemo/'+templ);
				}
			});
			$(document).on('change','.chznSelect', function(){
				var value = $(this).val();
				var id = $(this).attr('id').replace('templSelWhole_','');
				if(value != '' && typeof value != 'undefined'){
					$('.tmplDemo[data-id='+id+']').css('display', 'inline-block');
				}
				else{
					$('.tmplDemo[data-id='+id+']').css('display', 'none');
				}
				
			});
			$(function(){
<?php
if ($lockAll > 0) {
	?>
				window.parent.$('.ui-dialog-title').html('Print VISA with selected initial page');
	<?php
}
else {
	?>
				window.parent.$('.ui-dialog-title').html('Select Template');
	<?php
}
?>
	});
		
		</script>
	</body>
</html>