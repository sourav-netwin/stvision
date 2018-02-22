<?php $this -> load -> view('plused_header'); ?>
<script src="<?php echo base_url(); ?>js/tuition/validation_functions.js"></script>
<!-- The container of the sidebar and content box -->
<div role="main" id="main" class="container_12 clearfix">
    <!-- The blue toolbar stripe -->
    <section class="toolbar">
        <div class="user">
            <div class="avatar">
                <img src="<?php echo base_url(); ?>img/layout/content/toolbar/user/avatar.png">
                <!-- Evidenziare per icone attenzione <span>3</span> -->
            </div>
            <span><?php echo $this -> session -> userdata('businessname') ?></span>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/profile">Profile</a></li>
                <li class="line"></li>
                <li><a href="<?php echo base_url(); ?>index.php/backoffice/logout">Logout</a></li>
            </ul>
        </div>
    </section><!-- End of .toolbar-->
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
	<?php $this -> load -> view('plused_sidebar'); ?>	
    <script>
        $(document).ready(function() {
            $( "li#jocampbus" ).addClass("current");
            $( "li#jocampbus a" ).addClass("open");		
            $( "li#jocampbus ul.sub" ).css('display','block');	
            $( "li#jocampbus ul.sub li#jocampbus_2" ).addClass("current");	
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
					$(this).attr("checked",false);
				});
				$("input.sel_EUR").each(function(){
					$(this).attr("checked",true);
				});
				$.fn.myFunction();
			});
			$("#s_GBP").click(function(){
				$("input.chCentri").each(function(){
					$(this).attr("checked",false);
				});
				$("input.sel_GBP").each(function(){
					$(this).attr("checked",true);
				});
				$.fn.myFunction();
			});
			$("#s_all").click(function(){
				$("input.chCentri").each(function(){
					$(this).attr("checked",true);
				});
				$.fn.myFunction();
			});
                
			$("#s_none").click(function(){
				$("input.chCentri").each(function(){
					$(this).attr("checked",false);
				});
			});
        });
		function validateFile(){
			var fileInput = $.trim($("#importFile").val());
			if (!fileInput || fileInput == '') {      
                alert('please select atleast one excel file');
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
					alert('Please select atleast one campus');
					return false;
				}
			}
			return true;
		}
    </script>	
    <!-- Here goes the content. -->
    <section id="content" class="container_12 clearfix" data-sort=true>
        <div class="grid_12">
            <div class="box">
                <div class="header">
                    <h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><?php echo $breadcrumb2; ?></h2>
                </div>
                <div class="content">
					<form method="post" action="<?php echo base_url(); ?>index.php/excursionexportimport/export" onsubmit="return validateExport()">

						<div class="content" style="margin: 10px;">
							<div class="grid_12">
								<div class="box">
									<div class="header">
										<h2>Select campus
											<span style="float:right;">
												<a href="javascript:void(0);" id="s_EUR">EUR</a> - 
												<a href="javascript:void(0);" id="s_GBP">GBP</a> - 
												<a href="javascript:void(0);" id="s_all">All</a> - 
												<a href="javascript:void(0);" id="s_none">None</a>
											</span>
										</h2>
									</div>
									<div class="content" style="margin:10px;">
										<div class="grid_3">
											<?php
											$contaCentri = 0;
											if (!empty($centri)) {
												foreach ($centri as $key => $item) {
													?>
													<input type="checkbox" checked="checked" class="chCentri sel_<?php echo $item['valuta_fattura'] ?>" name="campuses[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?><br />
													<?php
													$contaCentri++;
													if ($contaCentri % 5 == 0) {
														?>
													</div>
													<div class="grid_3">
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
									<div class="form-data grid_12" >
										<div style="text-align: center; margin-bottom: 10px">
											<?php
											if (!empty($centri)) {
												?>	
												<input class="btn btn-tuition" type="submit" id="btnExport" name="btnExport" value="Export for bus prices insertion (.xlsx)" style="width: 230px;" />
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<div class="form-data grid_12" >
								<div class="div-exp-btn">
									<input class="btn btn-tuition" type="submit" id="btnExportResult" name="btnExportResult" value="Export all campus excursions, bus and prices (.xlsx)" style="width: 320px;" />
								</div>
							</div>
						</div>
					</form>
					<form method="post" action="<?php echo base_url(); ?>index.php/excursionexportimport/import" enctype="multipart/form-data" onsubmit="return validateFile()">
						<div class="row" style="border-top: 1px solid rgb(189, 185, 185);">

							<div class="form-data" style="text-align: center; border: none">
								<input type="file" multiple id="importFile" name="importFile[]" style="width: 200px" />
								<!--<input class="btn btn-tuition" type="submit" id="btnImportFile" name="btnImportFile" value="Import" />-->
								<input class="btn btn-tuition" type="button" value="Import" disabled="disabled" />
								<!--<input class="btn btn-tuition" type="reset" id="btnCancel" name="btnCancel" value="Cancel" onclick="window.location.href='<?php echo base_url(); ?>index.php/contract'" />-->

							</div>
							<div class="right" style="border: none">	
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
							</div>
						</div>
					</form>
                </div><!-- End of .content -->
            </div><!-- End of .box -->
        </div><!-- End of .grid_12 -->
    </section><!-- End of #content -->
</div><!-- End of #main -->
<?php $this -> load -> view('plused_footer'); ?>