<link rel="stylesheet" href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css">
<style type="text/css">
	@media(max-width: 900px) {
		#selCampus_chzn{
			width: 100% !important;
		}
	}
	@media(min-width: 900px) {
		#selCampus_chzn{
			width: 50% !important;
		}
	}
	table.styled:not(.borders) tbody tr:last-child td{
		border-bottom: 1px solid #dfdfdf;
		border-right: 1px solid #dfdfdf;

	}

	.frm-error.inline{
		display: block !important;
	}
	#selCompanies_chzn{
		width: 100% !important;
	}
</style>

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
				<h3 class="box-title">Select details</h3>
			</div>
			<div class="box-body">
				<form method="post" class="validate" id="frmCampComp" action="">
					<div class="row form-group">
						<label for="selCampus" class="col-sm-2">
							<strong>Campus</strong>
						</label>
						<div class="col-sm-4">
							<select class="required form-control" id="selCampus" name="selCampus"  required>
								<option value="">Select campus</option>
								<?php
								if (!empty($campuses)) {
									foreach ($campuses as $campus) {
										?>
										<option <?php echo ($formData['selCampus'] == $campus['id'] ? "selected='selected'" : ''); ?> value="<?php echo $campus['id'] ?>"><?php echo $campus['nome_centri'] ?></option>
										<?php
									}
								}
								?>
							</select>
							<div class="frm-error"><?php echo form_error('selCampus'); ?></div>
						</div>
					</div>
					<div class="row form-group">
						<label for="selCompanies"  class="col-sm-2">
							<strong>Companies</strong>
						</label>
						<div class="col-sm-10">
							<select multiple class="required width-full" id="selCompanies" name="selCompanies[]"  required>
								<?php
								if (!empty($companies)) {
									foreach ($companies as $company) {
										?>
										<option <?php echo (in_array($company['tra_cp_id'], $formData['selCompanies']) ? "selected='selected'" : ''); ?> value="<?php echo $company['tra_cp_id'] ?>"><?php echo $company['tra_cp_name'] ?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<!--<input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id; ?>" />-->
							<input class="btn btn-primary" type="submit" id="btnMap" name="btnMap" value="Map" />
							<input class="btn btn-danger" type="reset" id="btnCancel" name="btnCancel" value="Cancel" />
						</div>
					</div>
				</form>
			</div><!-- End of .content -->
		</div><!-- End of .box -->
		<div class="box">

			<div class="box-header with-border">
				<h2 class="box-title">Mapped data</h2>
			</div>
			<div class="box-body">
				<table class="datatable table table-bordered table-hover width-full">
					<thead>
						<tr>
							<th>Campus</th>
							<th>Companies</th>
							<th class="text-center no-sort">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (is_array($mappeddata)) {
							foreach ($mappeddata as $map) {
								?>
								<tr><td><?php echo $map['nome_centri'] ?></td><td><?php echo $map['tra_cp_name'] ?></td>
									<td class="text-center operation">
										<a title="Edit" href="javascript:void(0)" data-toggle="tooltip" title="Edit" data-id="<?php echo $map['centri_id'] ?>" class="campEdit btn btn-warning btn-xs">
											<i class="fa fa-edit"></i>
										</a>
									</td>
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
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<script src="<?php echo LTE; ?>plugins/select2/select2.full.min.js"></script>
<script>
	$(document).ready(function() {
		$("#frmCampComp").validate({
			//errorElement:"div",
			ignore: [],
			rules: {
				selCampus: {
					required: true
				},
				selCompanies: {
					required: true
				}
			},
			messages: {
				selCampus: "Please select campus",
				'selCompanies[]': "Please select atleast one company"
			},
			submitHandler: function(form) {
				form.submit();
			},
			errorPlacement: function(error, element) {
				if (element.attr("name") == "selCompanies[]") {
					error.insertAfter(".select2-container");
				}else{
					error.insertAfter(element);
				}
			}
		});
		$('#selCompanies').select2({
			dropdownAutoWidth : true,
			width: '100%'
		});	
	});
	$('body').on('click', '.campEdit', function(){
		var id = $(this).attr('data-id');
		$("#selCampus").val(id);
		$("#selCampus").change();
		scrollPageToTop();
	});
	$( "body" ).on( "change", "#selCampus", function() {
		var id = $(this).val();
		//		$('#selCompanies option').each(function(){
		//			$(this).removeAttr('selected');
		//		});
		$("#selCompanies").val('').trigger('change');
		if(id != '' && typeof id != 'undefined'){
			$.post( "<?php echo base_url(); ?>index.php/joincampuscompany/getCompanies",{
				'id':id
			}, function( data ) {
				if(parseInt(data.result))
				{
					var valarray = [];
					$.each(data.result, function(i, item) {
						valarray.push(item);
						//						$('#selCompanies').find('option[value='+item+']').attr('selected', 'selected');
					});
					$("#selCompanies").val(valarray).trigger('change');
				}
				else{
					$("#selCompanies").val('').trigger("change");
				}
			},'json'); 
		}
			
	});
	$('body').on('change',"#selCompanies", function(){
		$("#selCompanies").valid();
	});
	$('body').on('change',"#selCampus", function(){
		$("#selCampus").valid();
	});
	$("#btnCancel").click(function(){
        $("#selCompanies").val('').trigger('change');
    });
		
</script>