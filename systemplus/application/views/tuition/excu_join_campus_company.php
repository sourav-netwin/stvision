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
	<?php $this -> load -> view('plused_sidebar'); ?>	
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
    <script>
        $(document).ready(function() {
            $( "li#jocampbus" ).addClass("current");
            $( "li#jocampbus a" ).addClass("open");		
            $( "li#jocampbus ul.sub" ).css('display','block');	
            $( "li#jocampbus ul.sub li#jocampbus_1" ).addClass("current");	
        });
		$('body').on('click', '.campEdit', function(){
			var id = $(this).attr('data-id');
			$("#selCampus").val(id);
			$("#selCampus").trigger("liszt:updated");
			$("#selCampus").change();
			scrollPageToTop();
		});
		$( "body" ).on( "change", "#selCampus", function() {
			var id = $(this).val();
			$('#selCompanies option').each(function(){
				$(this).removeAttr('selected');
			});
			$("#selCompanies").trigger("liszt:updated");
			if(id != '' && typeof id != 'undefined'){
				$.post( "<?php echo base_url(); ?>index.php/joincampuscompany/getCompanies",{
                    'id':id
                }, function( data ) {
                    if(parseInt(data.result))
                    {
						var valarray = [];
                        $.each(data.result, function(i, item) {
							valarray.push(item);
							$('#selCompanies').find('option[value='+item+']').attr('selected', 'selected');
						});
						$("#selCompanies").trigger("liszt:updated");
                    }
					else{
						$("#selCompanies").trigger("liszt:updated");
					}
                },'json'); 
			}
			
		});
		
    </script>
    <!-- Here goes the content. -->
    <section id="content" class="container_12 clearfix" data-sort=true>
        <div class="grid_12">
            <div class="box">
                <div class="header">
                    <h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png"><?php echo $breadcrumb2; ?></h2>
                </div>
                <div class="content">
                    <form method="post" class="validate" id="frmTeacher" action="">
                        <div class="row">
							<label for="selCampus" style="width: 115px;">
								<strong>Campus</strong>
							</label>
							<div class="form-data" style="margin-left: 130px;">
								<select class="required" id="selCampus" name="selCampus"  required>
									<option value="">Select Campus</option>
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
						<div class="row">
							<label for="selCompanies" style="width: 115px;">
								<strong>Companies</strong>
							</label>
							<div class="form-data" style="margin-left: 130px;">
								<select multiple class="required" id="selCompanies" name="selCompanies[]"  required>
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
								<div class="frm-error"><?php echo form_error('selCompanies'); ?></div>
							</div>
                        </div>
                        <div class="row">
							<div class="form-data" style="margin-left: 130px;">
								<!--<input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id; ?>" />-->
								<input class="btn btn-tuition" type="submit" id="btnMap" name="btnMap" value="Map" />
								<input class="btn btn-tuition" type="reset" id="btnCancel" name="btnCancel" value="Cancel" />
								<div class="right">	
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
			<div class="box">

				<div class="header">
					<h2><img class="icon" src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table.png">Mapped data</h2>
				</div>
				<table class="dynamic styled" data-filter-bar='always' data-max-items-per-page='10' data-table-tools='{"display":false}' data-data-table='{"aoColumns":[{"bSearchable": true,"bSortable": false},{"bSearchable": true,"bSortable": false},{"bSearchable": false,"bSortable": false}]}'>
					<thead>
						<tr>
							<th>Campus</th>
							<th>Companies</th>
							<th>Edit</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (is_array($mappeddata)) {
							foreach ($mappeddata as $map) {
								?>
								<tr><td><?php echo $map['nome_centri'] ?></td><td><?php echo $map['tra_cp_name'] ?></td>
									<td class="center operation">
										<a title="Edit" href="javascript:void(0)" data-id="<?php echo $map['centri_id'] ?>" class="campEdit">
											<span class="icon-edit"></span>
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
        </div><!-- End of .grid_12 -->
    </section><!-- End of #content -->
</div><!-- End of #main -->
<?php $this -> load -> view('plused_footer'); ?>