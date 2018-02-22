<link href="<?php echo LTE; ?>plugins/iCheck/all.css" rel="stylesheet">
<style type="text/css">
	@media(max-width: 500px){
		form .row > div{
			padding-left: 0 !important;
		}
	}
	@media(max-width: 400px){
		#btnExportResult,#btnExport{
			width: 180px !important;
			white-space: normal !important;
		}
	}
	@media(min-width: 401px){
		#btnExportResult{
			width: 320px !important;
		}
		#btnExport{
			width: 230px !important;
		}
	}
	.customfile{
		width: 250px !important;
		margin: 20px auto 0px !important;
	}
</style>

<!-- Here goes the content. -->
<div class="row">
	<div class="col-md-12">
		<form method="post" action="<?php echo base_url(); ?>index.php/excursionexportimport/export" onsubmit="return validateExport()">

			<div class="box">
				<div class="box-header with-border">
					<h2 class="box-title width-full">Select campus
						<span class="pull-right sort-text">
							<a href="javascript:void(0);" id="s_EUR">EUR</a> - 
							<a href="javascript:void(0);" id="s_GBP">GBP</a> - 
							<a href="javascript:void(0);" id="s_all">All</a> - 
							<a href="javascript:void(0);" id="s_none">None</a>
						</span>
					</h2>
				</div>
				<div class="box-body" style="margin:10px;">
					<div class="row">
						<div class="col-sm-4 col-md-3">
							<?php
							$contaCentri = 0;
							if (!empty($centri)) {
								foreach ($centri as $key => $item) {
									?>
							<input type="checkbox" checked="checked" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="campuses[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>">&nbsp;<label class="normal" for="c_<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?></label><br />
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
								echo '<div class="tuition_error">No mapped campuses found</div>';
							}
							?>	
						</div>
					</div>

					<div class="row" >
						<div class="form-data col-md-12" >
							<div style="text-align: center; margin-bottom: 10px">
								<?php
								if (!empty($centri)) {
									?>	
									<input class="btn btn-primary mr-top-10" type="submit" id="btnExport" name="btnExport" value="Export for bus prices insertion (.xlsx)" style="width: 230px;" />
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
			<div class="col-md-12 text-center">
			<input class="btn btn-primary" type="submit" id="btnExportResult" name="btnExportResult" value="Export all campus excursions, bus and prices (.xlsx)" style="width: 320px;" />
			</div>
			</div>
		</form>
	</div>
	<div class="col-md-12 text-center" >
		
		<div class="box mr-top-10">
			<form method="post" action="<?php echo base_url(); ?>index.php/excursionexportimport/import" enctype="multipart/form-data" onsubmit="return validateFile()">
				<div class="box-body">
					<div class="row">

						<div class="form-data text-center">

							<div class="row">
								<div class="col-sm-6 col-sm-offset-3 with-file">
									<input type="file" multiple id="importFile" name="importFile[]" class="margin-auto" />
								</div>
							</div>
							<div class="row">
								<input class="btn btn-primary mr-top-10" type="submit" id="btnImportFile" name="btnImportFile" value="Import" />
								<!--<input class="btn btn-primary mr-top-10" type="button" value="Import" disabled="disabled" />-->
								<!--<input class="btn btn-tuition" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url(); ?>index.php/contract'" />-->
							</div>



						</div>
						<div class="right" style="border: none">	
							<?php
							showSessionMessageIfAny($this);
							?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div><!-- End of .col-md-12 -->
<script src="<?php echo LTE; ?>plugins/iCheck/icheck.min.js"></script>
<script>
	$(document).ready(function() {
		initFileInput();
		$('input[type="checkbox"]').iCheck({checkboxClass: 'icheckbox_minimal-blue'});
		$.fn.myFunction = function(){
			var campuses = [];
			$("input.chCentri:checked").each(function(){
				campuses.push($(this).val());
			});
		}
		$(".chCentri").change(function(){
			$.fn.myFunction();
		});
		$("#s_EUR").click(function(){
			$("input.chCentri").each(function(){
				$(this).iCheck("uncheck");
			});
			$("input.sel_EUR").each(function(){
				$(this).iCheck("check");
			});
			$.fn.myFunction();
		});
		$("#s_GBP").click(function(){
			$("input.chCentri").each(function(){
				$(this).iCheck("uncheck");
			});
			$("input.sel_GBP").each(function(){
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
	function validateFile(){
		var fileInput = $.trim($("#importFile").val());
		if (!fileInput || fileInput == '') {      
			swal('Error','please select atleast one excel file');
			return false;    
		}
		else{
			return true;
		}
	}
	function validateExport(){
		var val = $("input[type=submit]:focus").attr('name');
		if(val == 'btnExport'){
			if($('.chCentri:checked').length < 1){
				swal('Error','Please select atleast one campus');
				return false;
			}
		}
		return true;
	}
</script>