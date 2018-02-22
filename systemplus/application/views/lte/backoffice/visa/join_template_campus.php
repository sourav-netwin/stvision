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
				<h3 class="box-title"><?php echo $breadcrumb2; ?></h3>
			</div>
			<div class="box-body">
				<form method="post" id="joinCampTempForm" action="<?php echo base_url(); ?>index.php/jointemplatecampus/joinTempCamp" onsubmit="return validateJoin()">
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
									<h2 class="box-title width-full">Select campus
										<span class="pull-right sort-text">
											<a href="javascript:void(0);" id="s_UK">UK</a> - 
											<a href="javascript:void(0);" id="s_IRL">IRL</a> - 
											<a href="javascript:void(0);" id="s_USA">USA</a> - 
											<a href="javascript:void(0);" id="s_all">All</a> - 
											<a href="javascript:void(0);" id="s_none">None</a>
										</span>
									</h2>
								</div>
								<div class="box-body">
									<div class="col-sm-4 col-md-3">
										<?php
										$contaCentri = 0;
										if (!empty($centri)) {
											foreach ($centri as $key => $item) {
												$location = '';
												if ($item['located_in'] == 'United Kingdom') {
													$location = 'UK';
												}
												if ($item['located_in'] == 'USA') {
													$location = 'USA';
												}
												if ($item['located_in'] == 'Ireland') {
													$location = 'IRL';
												}
												if ($item['located_in'] == 'Malta') {
													$location = 'MAL';
												}
												if ($item['located_in'] == 'UK/Ireland - GL Standard') {
													$location = 'UKIRGLSTD';
												}
												if ($item['located_in'] == 'UK/Ireland - STD Standard') {
													$location = 'UKIRSTDSTD';
												}
												if ($item['located_in'] == 'UK/Ireland - STD Short Term') {
													$location = 'UKIRSTDST';
												}
												?>
												<input type="checkbox" autocomplete="off" class="chCentri sel_<?php echo $location ?>" name="campuses[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>">&nbsp;<label class="normal" for="c_<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?></label><br/>
												<?php
												$contaCentri++;
												if ($contaCentri % 5 == 0) {
													?>
												</div>
												<div class="col-sm-4 col-md-3">
													<?php
												}
											}
										}
										else {
											echo '<div class="danger text-center width-full">No campuses found</div>';
										}
										?>	
									</div>
								</div>
							</div>
							<div class="form-data col-md-12" >
								<div style="text-align: center; margin-bottom: 10px">
									<?php
									if (!empty($centri)) {
										?>	
										<input class="btn btn-primary" type="submit" id="btnMap" name="btnMap" value="Map" />&nbsp;&nbsp;<input class="btn btn-warning" type="button" id="btnCancelMap" name="btnCancelMap" value="Cancel map" />&nbsp;&nbsp;<input class="btn btn-danger" type="reset" value="Reset" onclick="clearCheck()" />
									<?php } ?>
								</div>

							</div>
						</div>
					</div>

				</form>
			</div><!-- End of .content -->
		</div><!-- End of .box -->
		<div class="row">
			<div class="map-place-message col-md-12">
				<?php
				if ($unmappedList) {
					?>
					<span class="text-danger break-word">The following campuses haven't a template mapped yet: <strong><?php echo $unmappedList; ?></strong></span>
					<?
				}
				else {
					?>
					<span class="text-success">All campus are mapped</span>
					<?php
				}
				?>
			</div>
		</div>
		<div class="box" >

			<div class="box-header with-border">
				<h2 class="box-title width-full">Mapped data</h2>
			</div>
			<div class="box-body">
				<table class="datatable table table-bordered table-hover width-full">
					<thead>
						<tr>
							<th class="width-200">Template</th>
							<th>Campuses</th>
							<!--<th>Edit</th>-->
						</tr>
					</thead>
					<tbody>
						<?php
						if (is_array($mappedCentri)) {
							foreach ($mappedCentri as $map) {
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
								if ($map["template"] == 'UKIRGLSTD') {
									$location = 'UK/Ireland - GL Standard';
								}
								if ($map["template"] == 'UKIRSTDSTD') {
									$location = 'UK/Ireland - STD Standard';
								}
								if ($map["template"] == 'UKIRSTDST') {
									$location = 'UK/Ireland - STD Short Term';
								}
								?>
								<tr><td><?php echo $location ?></td><td><?php echo $map['nome_centri'] ?></td>
									<!--<td class="center operation">
										<a title="Edit" href="javascript:void(0)" data-id="<?php echo $map['template'] ?>" class="campEdit">
											<span class="icon-edit"></span>
										</a>
									</td>-->
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
			var campuses = [];
			$("input.chCentri:checked").each(function(){
				campuses.push($(this).val());
			});
		}
		$(".chCentri").change(function(){
			$.fn.myFunction();
		});
		$("#s_UK").click(function(){
			$("input.chCentri").each(function(){
				$(this).iCheck("uncheck");
			});
			$("input.sel_UK").each(function(){
				$(this).iCheck("check");
			});
			$.fn.myFunction();
		});
		$("#s_USA").click(function(){
			$("input.chCentri").each(function(){
				$(this).iCheck("uncheck");
			});
			$("input.sel_USA").each(function(){
				$(this).iCheck("check");
			});
			$.fn.myFunction();
		});
		$("#s_IRL").click(function(){
			$("input.chCentri").each(function(){
				$(this).iCheck("uncheck");
			});
			$("input.sel_IRL").each(function(){
				$(this).iCheck("check");
			});
			$.fn.myFunction();
		});
		$("#s_all").click(function(){
			$("input.chCentri").each(function(){
				$(this).iCheck("check");
			});
			$.fn.myFunction();
		});
                
		$("#s_none").click(function(){
			$("input.chCentri").each(function(){
				$(this).iCheck("uncheck");
			});
		});
	});
		
	function validateJoin(){
		var template = $('#selTemplate').val();
		var campusLen = $('input:checkbox[name=campuses]:checked').length;
		if(template == '' || typeof template == 'undefined'){
			swal('Error','Please select a template');
			return false;
		}
		else if($('#btnMap').val() == 'Map' && $('.chCentri:checked').length == 0){
			swal('Error','Please select campus/campuses to map');
			return false;
		}
		else{
			return true;
		}
	}
	$( "body" ).on( "change", "#selTemplate", function() {
		var id = $(this).val();
		$("input.chCentri").each(function(){
			$(this).iCheck("uncheck");
		});
		$('#btnMap').val('Map');
		if(id != '' && typeof id != 'undefined'){
			$('#selTmplDemo').css('visibility','visible');
			$.post( siteUrl+"jointemplatecampus/getCampuses",{
				'id':id
			}, function( data ) {
				if(parseInt(data.result))
				{
					var valarray = [];
					$.each(data.result, function(i, item) {
						valarray.push(item);
						$("input.chCentri").each(function(){
							if($(this).attr('id') == 'c_'+item){
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
		$("input.chCentri").each(function(){
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
		
	$('body').on('click','#btnCancelMap',function(){
		var templ = $('#selTemplate').val();
		if(templ != '' && typeof templ != 'undefined'){
			var action = false;
			$.ajax({
				url: siteUrl+'jointemplatecampus/checkMapCount',
				type: 'POST',
				data: {
					selTemplate: $('#selTemplate').val()
				},
				success: function(data){
					if(data == '1'){
						confirmAction('Are you sure to cancel mapping of selected template?', function(s){
							if(s){
								var data = $('#joinCampTempForm').serialize() + '&btnCancelMap=clicked';
								$.ajax({
									url: siteUrl+'jointemplatecampus/joinTempCamp',
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