<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css">
<!-- Here goes the content. -->
<div class="row">
	<?php
	showSessionMessageIfAny($this);
	?>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $breadcrumb2; ?></h2>
			</div>
			<div class="box-body">
				<form method="post" id="joinTempNatForm" action="<?php echo base_url(); ?>index.php/jointemplatenationality/joinTempNat" onsubmit="return validateJoin()">
					<div class="row form-group">
						<label for="selTemplate" class="col-sm-2">
							Template
						</label>
						<div class="col-sm-4">
							<select id="selTemplate" name="selTemplate" class="form-control width-80-per display-inline">
								<option value="">Select an option</option>
								<option value="UKIR">UK/Ireland</option>
								<option value="USA">USA</option>
								<option value="MAL">Malta</option>
								<option value="UKIRGLSTD">UK/Ireland - GL Standard</option>
								<option value="UKIRSTDSTD">UK/Ireland - STD Standard</option>
								<option value="UKIRSTDST">UK/Ireland - STD Short Term</option>
							</select>
							<span id="selTmplDemo" title="Preview Template" class="template-demo" data-toggle="tooltip"><i class="glyphicon glyphicon-list-alt"></i></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">

							<div class="box">
								<div class="box-header with-border">
									<h2 class="box-title width-full">Select nationality
										<span class="sort-text pull-right">
											<?php
											if ($continents) {
												foreach ($continents as $continent) {
													?>
													<a href="javascript:void(0);" class="continentList" id="s_<?php echo str_replace('. ', '', strtolower($continent['continent'])) ?>"><?php echo $continent['continent'] ?></a> - 
													<?php
												}
											}
											?>
											<a href="javascript:void(0);" id="s_all">All</a> - 
											<a href="javascript:void(0);" id="s_none">None</a>
										</span>
									</h2>
								</div>
								<div class="box-body">
									<div class="row">
										<div class="col-sm-4 col-md-3">
											<?php
											$contaNationality = 0;
											if (!empty($nationalities)) {
												foreach ($nationalities as $key => $item) {
													?>
													<input type="checkbox" autocomplete="off" class="chNationality s_<?php echo str_replace('. ', '', strtolower($item['continent'])) ?>" name="nationalities[]" id="n_<?php echo $item['nat_id'] ?>" value="<?php echo $item['nat_id'] ?>">&nbsp;<label class="normal" for="n_<?php echo $item['nat_id'] ?>"><?php echo $item['nationality'] ?></label><br />
													<?php
													$contaNationality++;
													if ($contaNationality % 5 == 0) {
														?>
													</div>
													<div class="col-sm-4 col-md-3">
														<?php
													}
												}
											}
											else {
												echo '<div class="danger text-center width-full">No nationalities found</div>';
											}
											?>	
										</div>
									</div>
								</div>
							</div>
							<div class="form-data col-md-12" >
								<div style="text-align: center; margin-bottom: 10px">
									<?php
									if (!empty($nationalities)) {
										?>	
										<input class="btn btn-primary" type="submit" id="btnMap" name="btnMap" value="Map" />&nbsp;&nbsp;<input class="btn btn-warning" type="button" id="btnCancelMap" name="btnCancelMap" value="Cancel map" style="width: 95px !important;" />&nbsp;&nbsp;<input class="btn btn-danger" type="reset" value="Reset" onclick="clearCheck()" />
									<?php } ?>
								</div>
							</div>
						</div>

					</div>
				</form>
			</div><!-- End of .content -->
		</div><!-- End of .box -->
		<div>
			<?php
			$dataCnt = 0;
			if ($campTemp) {
				foreach ($campTemp as $camp => $temp) {
					$cnt = sizeof($temp);
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
				}
			}
			?>
			<div class="row">
				<div class="map-place-message col-md-12">
					<?php
					if ($dataCnt > 0) {
						?>
						<span class="text-danger">Some/All nationalities aren't mapped</span>&nbsp;&nbsp;<span id="errorNotif" class="text-danger cursor-pointer"><i class="glyphicon glyphicon-exclamation-sign"></i></span>
						<?php
					}
					elseif (!$campTemp) {
						?>
						<span class="text-danger">No mapping found between template and campus. Please map some and check for unmapped nationalities</span>
						<?php
					}
					else {
						?>
						<span class="text-success">All nationalities are mapped</span>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="box">

			<div class="box-header with-border">
				<h2 class="box-title">Mapped data</h2>
			</div>
			<div class="box-body">
				<table class="datatable table table-bordered table-hover width-full">
					<thead>
						<tr>
							<th class="width-200">Template</th>
							<th>Nationalities</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (is_array($mappedNationalities)) {
							foreach ($mappedNationalities as $map) {
								$location = '';
								if ($map['template'] == 'UKIR') {
									$location = 'UK/Ireland';
								}
								if ($map['template'] == 'USA') {
									$location = 'USA';
								}
								if ($map['template'] == 'MAL') {
									$location = 'Malta';
								}
								if ($map['template'] == 'UKIRGLSTD') {
									$location = 'UK/Ireland - GL Standard';
								}
								if ($map['template'] == 'UKIRSTDSTD') {
									$location = 'UK/Ireland - STD Standard';
								}
								if ($map['template'] == 'UKIRSTDST') {
									$location = 'UK/Ireland - STD Short Term';
								}
								?>
								<tr><td><?php echo $location ?></td><td><?php echo $map['nationality'] ?></td>

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
</div><!-- End of .col-md-12 -->
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<script>
	$(document).ready(function() {
		$('input[type="checkbox"]').iCheck({checkboxClass: 'icheckbox_square-blue'});
		$.fn.myFunction = function(){
			var nationalities = [];
			$("input.chNationality:checked").each(function(){
				nationalities.push($(this).val());
			});
		}
		$("#s_all").click(function(){
			$("input.chNationality").each(function(){
				$(this).iCheck("check");
			});
			$.fn.myFunction();
		});
                
		$("#s_none").click(function(){
			$("input.chNationality").each(function(){
				$(this).iCheck("uncheck");
			});
		});
	});
		
	function validateJoin(){
		var template = $('#selTemplate').val();
		var campusLen = $('input:checkbox[name=nationalities]:checked').length;
		if(template == '' || typeof template == 'undefined'){
			swal('Error','Please select a template');
			return false;
		}
		else if($('#btnMap').val() == 'Map' && $('.chNationality:checked').length == 0){
			swal('Error','Please select nationality/nationlaities to map');
			return false;
		}
		else{
			return true;
		}
	}
	$( "body" ).on( "change", "#selTemplate", function() {
		var id = $(this).val();
		$("input.chNationality").each(function(){
			$(this).iCheck("uncheck");
		});
		$('#btnMap').val('Map');
		if(id != '' && typeof id != 'undefined'){
			$('#selTmplDemo').css('visibility','visible');
			$.post( "<?php echo base_url(); ?>index.php/jointemplatenationality/getNationalities",{
				'id':id
			}, function( data ) {
				if(parseInt(data.result))
				{
					var valarray = [];
					$.each(data.result, function(i, item) {
						valarray.push(item);
						$("input.chNationality").each(function(){
							if($(this).attr('id') == 'n_'+item){
								$(this).iCheck("check");
							}
						});
					});
				}
				if(data.result.length > 0){
					$('#btnMap').val('Update');
				}
			},'json'); 
		}
		else{
			$('#selTmplDemo').css('visibility','hidden');
		}
			
	});
		
	function clearCheck(){
		$("input.chNationality").each(function(){
			$(this).iCheck("uncheck");
		});
		$('#btnMap').val('Map');
		$('#selTmplDemo').css('visibility', 'hidden');
	}
		
	$(document).on('click','#selTmplDemo', function(){
		var templ = $('#selTemplate').val();
		if(templ != '' && typeof templ != 'undefined'){
			window.open(siteUrl+'backoffice/visaPDFDemo/'+templ);
		}
	});
	$(document).on('click', '#errorNotif', function(){
		$.ajax({
			url: siteUrl + "jointemplatenationality/nationalityNoMapCampus",
			type: 'POST',
			data: {},
			success: function(data){
				createModal('noMapModal', 'Nationalities not mapped with campus', data, 'large');
			},
			error: function(){
				swal('Error', 'No details found');
			}
		});
	});
	$(document).on('click', '.continentList', function(){
		var continent = $(this).attr('id').replace('s_','');
		$("input.chNationality").each(function(){
			$(this).iCheck("uncheck");
		});
		$("input.s_"+continent).each(function(){
			$(this).iCheck("check");
		});
		$.fn.myFunction();
			
	});
	$('body').on('click','#btnCancelMap',function(){
		var templ = $('#selTemplate').val();
		if(templ != '' && typeof templ != 'undefined'){
			var action = false;
			$.ajax({
				url: siteUrl + 'jointemplatenationality/getJoinCount',
				type: 'POST',
				data: {
					selTemplate: templ
				},
				success: function(data){
					if(data == '1'){
						confirmAction('Are you sure to cancel mapping of selected template?', function(s){
							if(s){
								var data = $('#joinTempNatForm').serialize() + '&btnCancelMap=clicked';
								$.ajax({
									url: siteUrl +'jointemplatenationality/joinTempNat',
									type: 'POST',
									data: data,
									success: function(){
										location.reload(true);
									},
									error: function(){
										location.reload(true);
									}
								});
							}
						}, true, true);
					}
					else{
						swal('Error', 'No mapped records found');
					}
				},
				error: function(){
					swal('Error', 'No mapped records found');
				}
			});
						
		}
		else{
			swal('Error','Please select a template');
			return false;
		}
		return action;	
	});
	
		
</script>