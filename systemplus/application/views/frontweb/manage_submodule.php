<!--------------Datatable CSS and JS---------------->
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		//initialize datatable
		var table = $("#datatable").DataTable();
	});
</script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css?v=1.1">

<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>

<?php

	if(!empty($moduleArr['field']))
	{
		foreach($moduleArr['field'] as $value)
		{
			if(isset($value['summernote']) && $value['summernote'] == 1)
			{
?>
				<!----------Summernote CSS and JS--------->
				<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/summernote.css">
				<script src="<?php echo LTE; ?>frontweb/summernote.js"></script>
				<script>
					$(document).ready(function(){
						$('.summernote').summernote({
							height: 200
						});
					});
				</script>
<?php
				break;
			}
			if(isset($value['tinymce']) && $value['tinymce'] == 1)
			{
?>
				<!------------Tinymce JS------------->
				<script src="<?php echo LTE; ?>frontweb/tinymce/tinymce.min.js"></script>
<?php
			}
		}
	}
?>
<!------------custom javascript for master modules------------>
<script>
	var pageType = 'add_edit';
	var id = "<?php echo $id; ?>";
	var moduleName = "<?php echo $moduleName; ?>";
	var fieldArr = '<?php echo json_encode($moduleArr['field']); ?>';
	var please_enter_dynamic = "<?php echo $this->lang->line("please_enter_dynamic"); ?>";
	var required_upload_image = "<?php echo $this->lang->line("required_upload_image"); ?>";
	var valid_data_error_msg = "<?php echo $this->lang->line("valid_data_error_msg"); ?>";
	var image_type_error_msg = "<?php echo $this->lang->line("image_type_error_msg"); ?>";
	var minimum_image_dimension = "<?php echo $this->lang->line("minimum_image_dimension"); ?>";
	var duplicate_dynamic = "<?php echo $this->lang->line("duplicate_dynamic"); ?>";
	var enter_vimeo_url = "<?php echo $this->lang->line("enter_vimeo_url"); ?>";
	var delete_confirmation = "<?php echo $this->lang->line("delete_confirmation"); ?>";
</script>
<script src="<?php echo LTE; ?>frontweb/custom/master.js?v=1.9"></script>


<!---------------------------Add Form Section Start---------------------------->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'masterForm',
						'method' =>'post'
					);
					echo form_open_multipart($actionUrl , $formAttribute);
?>
						<input type="hidden" name="flag" id="flag" value="<?php echo $flag; ?>" />
						<input type="hidden" name="foreignKeyValue"value="<?php echo $id; ?>" />
						<div class="box box-primary">
							<div class="box-body">
<?php
								if(!empty($moduleArr['field']))
								{
									foreach($moduleArr['field'] as $fieldKey => $fieldValue)
									{
?>
										<div class="form-group">
											<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">
<?php
												echo $fieldValue['fieldLabel'];
												if(strpos($fieldValue['validation'] , 'required') !== FALSE || strpos($fieldValue['validation'] , 'imageRequired') !== FALSE)
													echo '<span class="required">*</span>';
?>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<?php echo $this->mastermodel->setFormField($fieldKey , $fieldValue , $post); ?>
											</div>
										</div>
<?php
									}
								}
?>
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<?php
										$inputFieldAttribute = array(
											'class' => 'btn btn-success',
											'value' => 'Submit'
										);
										echo form_submit($inputFieldAttribute);

										$inputFieldAttribute = array(
											'class' => 'btn btn-primary',
											'content' => 'Cancel',
											'onclick' => "window.location = '".base_url()."index.php/frontweb/master/index/".$moduleArr['parentModule']."'",
											'style' => 'margin-left: 10px;'
										);
										echo form_button($inputFieldAttribute);
?>
									</div>
								</div>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!----------------------------Add Form Section End---------------------------->

<!--------------------------Listing Section Start----------------------------->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<div class="col-sm-6 btn-create"></div>
						<?php showSessionMessageIfAny($this);?>
					</div>
				</div>
				<div class="x_content box-body">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Si no.</th>
<?php
								if(!empty($moduleArr['list']))
								{
									foreach($moduleArr['list'] as $key => $value)
									{
										if($key == 'actionColumn')
											echo '<th>Action</th>';
										else
											echo '<th>'.$value['columnTitle'].'</th>';
									}

								}
?>
							</tr>
						</thead>
<?php
						if(!empty($listResult))
						{
							echo '<tbody>';
							foreach($listResult as $listValue)
							{
								echo '<tr><td>'.$listValue[0].'</td>';
								foreach($moduleArr['list'] as $listFields)
								{
									echo '<td>'.$listValue[$listFields['columnNo']].'</td>';
								}
								echo '</tr>';
							}
							echo '</tbody>';
						}
?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!--------------------------Listing Section END----------------------------->
