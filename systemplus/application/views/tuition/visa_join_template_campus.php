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
		.customfile{
			width: 250px !important;
			margin: 20px auto 0px !important;
		}
		@media(max-width: 900px) {
			#selTemplate_chzn{
				width: 90% !important;
			}
		}
		@media(max-width: 415px) {
			#selTemplate_chzn{
				width: 85% !important;
			}
		}
		@media(max-width: 330px) {
			#selTemplate_chzn{
				width: 70% !important;
			}
		}
		@media(min-width: 900px) {
			#selTemplate_chzn{
				width: 50% !important;
			}
		}
		@media(max-width: 333px){
			.header-large{
				height: 25px;
				text-align: center;
			}
			.sort-span{
				float: right;
				text-align: center;
				width: 100%;
			}
		}
		@media(max-width: 367px){
			input[type="reset"]{
				margin-top: 5px;
			}
		}
		@media(max-width: 370px){
			input[aria-controls="DataTables_Table_0"]{
				width: 85px;
			}
		}
	</style>
	<?php $this -> load -> view('plused_sidebar'); ?>	
    <script>
        $(document).ready(function() {
            $( "li#jovisamgt" ).addClass("current");
            $( "li#jovisamgt a" ).addClass("open");		
            $( "li#jovisamgt ul.sub" ).css('display','block');	
            $( "li#jovisamgt ul.sub li#jovisamgt_1" ).addClass("current");	
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
					$(this).attr("checked",false);
				});
				$("input.sel_UK").each(function(){
					$(this).attr("checked",true);
				});
				$.fn.myFunction();
			});
			$("#s_USA").click(function(){
				$("input.chCentri").each(function(){
					$(this).attr("checked",false);
				});
				$("input.sel_USA").each(function(){
					$(this).attr("checked",true);
				});
				$.fn.myFunction();
			});
			$("#s_IRL").click(function(){
				$("input.chCentri").each(function(){
					$(this).attr("checked",false);
				});
				$("input.sel_IRL").each(function(){
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
		
		function validateJoin(){
			var template = $('#selTemplate').val();
			var campusLen = $('input:checkbox[name=campuses]:checked').length;
			if(template == '' || typeof template == 'undefined'){
				alert('Please select a template');
				return false;
			}
			else{
				return true;
			}
		}
		$( "body" ).on( "change", "#selTemplate", function() {
			var id = $(this).val();
			$("input.chCentri").each(function(){
				$(this).attr("checked",false);
			});
			$('#btnMap').val('Map');
			if(id != '' && typeof id != 'undefined'){
				$('#selTmplDemo').css('visibility','visible');
				$.post( "<?php echo base_url(); ?>index.php/jointemplatecampus/getCampuses",{
                    'id':id
                }, function( data ) {
                    if(parseInt(data.result))
                    {
						var valarray = [];
                        $.each(data.result, function(i, item) {
							valarray.push(item);
							$("input.chCentri").each(function(){
								if($(this).attr('id') == 'c_'+item){
									$(this).attr("checked",true);
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
		$('body').on('click', '.campEdit', function(){
			var id = $(this).attr('data-id');
			$("#selTemplate").val(id);
			$("#selTemplate").trigger("liszt:updated");
			$("#selTemplate").change();
		});
		
		function clearCheck(){
			$("input.chCentri").each(function(){
				$(this).attr("checked",false);
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
		
		function confirmCancel(){
			var templ = $('#selTemplate').val();
			if(templ != '' && typeof templ != 'undefined'){
				var c = confirm('Are you sure to cancel mapping of selected template?');
				if(c){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				alert('Please select a template');
				return false;
			}
			
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
					<form method="post" action="<?php echo base_url(); ?>index.php/jointemplatecampus/joinTempCamp" onsubmit="return validateJoin()">

						<div class="content" style="margin: 10px;">
							<div class="grid_12">
								<table style="width: 100%">
									<tr>
										<td style="width: 70px; vertical-align: middle">
											<label for="selTemplate">
												<strong>Template</strong>
											</label>
										</td>
										<td>
											<select id="selTemplate" name="selTemplate">
												<option value="">Select an Option</option>
												<option value="UKIR">UK/Ireland</option>
												<option value="USA">USA</option>
												<option value="MAL">Malta</option>
												<option value="UKIRGLSTD">UK/Ireland - GL Standard</option>
												<option value="UKIRSTDSTD">UK/Ireland - STD Standard</option>
												<option value="UKIRSTDST">UK/Ireland - STD Short Term</option>
											</select>
											<span id="selTmplDemo" title="Preview Template" style="display: inline-block; visibility: hidden; vertical-align: text-top; margin-top: -12px; font-size: 20px; cursor: pointer; color: #007DA5;"><i class="glyphicon glyphicon-list-alt"></i></span>
											<div class="frm-error"><?php echo form_error('selTemplate'); ?></div>
										</td>
									</tr>
								</table>
								<div class="box">
									<div class="header">
										<h2 class="header-large">Select campus
											<span style="float:right;" class="sort-span">
												<a href="javascript:void(0);" id="s_UK">UK</a> - 
												<a href="javascript:void(0);" id="s_IRL">IRL</a> - 
												<a href="javascript:void(0);" id="s_USA">USA</a> - 
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
													<input type="checkbox" class="chCentri sel_<?php echo $location ?>" name="campuses[]" id="c_<?php echo $item['id'] ?>" value="<?php echo $item['id'] ?>"><?php echo $item['nome_centri'] ?><br />
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
												echo '<div class="tuition_error">No campuses found</div>';
											}
											?>	
										</div>
										<div class="frm-error"><?php echo form_error('campuses'); ?></div>
									</div>
								</div>
								<div class="form-data grid_12" >
									<div style="text-align: center; margin-bottom: 10px">
										<?php
										if (!empty($centri)) {
											?>	
											<input class="btn btn-tuition" type="submit" id="btnMap" name="btnMap" value="Map" />&nbsp;&nbsp;<input class="btn btn-tuition" type="submit" id="btnCancelMap" name="btnCancelMap" value="Cancel Map" onclick="return confirmCancel()" style="width: 95px !important;" />&nbsp;&nbsp;<input class="btn btn-tuition" type="reset" value="Reset" onclick="clearCheck()" />
										<?php } ?>
									</div>
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

						</div>
					</form>
                </div><!-- End of .content -->
            </div><!-- End of .box -->
			<div>
				<?php
				if($unmappedList){
					?>
				<span style="color:#FF0000">The following campuses haven't a template mapped yet: <?php echo $unmappedList; ?></span>
				<?
				}
				else{
					?>
				<span style="color:rgb(0, 103, 57);font-size: 13px;">All campus are mapped</span>
				<?php
				}
				?>
			</div>
			<div class="box" style="margin-top: 25px;">

				<div class="header">
					<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Mapped data</h2>
				</div>
				<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false}]}'>
					<thead>
						<tr>
							<th>Template</th>
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
        </div><!-- End of .grid_12 -->
    </section><!-- End of #content -->
</div><!-- End of #main -->
<?php $this -> load -> view('plused_footer'); ?>