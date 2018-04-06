<!--------------Datatable CSS and JS---------------->
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css?v=1.1">

<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>

<!---------------------------Add Form Section Start---------------------------->
<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
<?php
					$formAttribute = array(
						'class' => 'form-horizontal form-label-left show-custom-error-tag',
						'id' => 'juniorCentrePhotoGallery',
						'method' =>'post'
					);
					echo form_open_multipart('frontweb/junior_ministay/photo_gallery/'.$juniorMiniStayId , $formAttribute);
?>
						<input type="hidden" name="flag" value="as" />
						<div class="box box-primary"><div class="box-body">
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Short description<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'id' => 'short_description',
									'name' => 'short_description',
									'class' => 'form-control',
									'placeholder' => 'Short description'
								);
								echo form_input($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
<?php
								$inputFieldAttribute = array(
									'id' => 'description',
									'name' => 'description',
									'class' => 'form-control',
									'rows' => 2
								);
								echo form_textarea($inputFieldAttribute);
?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload image <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="hidden" id="imgWidthErrorFlag" value="1" />
								<label for="photo">
									<img class="uploadImageProgramClass" width = 180 height = 50 src="<?php echo LTE.'frontweb/no_flag.jpg'; ?>"/>
								</label>
<?php
								$inputFieldAttribute = array(
									'id' => 'photo',
									'name' => 'photo',
									'type' => 'file',
									'style' => 'visibility: hidden;'
								);
								echo form_input($inputFieldAttribute);
?>
								<small style="display:block">
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; Image dimension should be greater or equal to <?php echo PHOTO_GALLERY_WIDTH; ?> X <?php echo PHOTO_GALLERY_HEIGHT; ?> pixel )
								</small>
								<span id="imgErrorMessage" style="color:#ff0000"><?php echo ($imageError != '') ? $imageError : ''; ?></span>
							</div>
						</div>
						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<?php
								$inputFieldAttribute = array(
									'class' => 'btn btn-success submitBtn',
									'value' => 'Submit'
								);
								echo form_submit($inputFieldAttribute);

								$inputFieldAttribute = array(
									'class' => 'btn btn-primary',
									'content' => 'Cancel',
									'onclick' => "window.location = '".base_url()."index.php/frontweb/junior_ministay'",
									'style' => 'margin-left: 10px;'
								);
								echo form_button($inputFieldAttribute);
?>
							</div>
						</div>
						</div></div>
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
								<th>Image</th>
								<th>Short description</th>
								<th>Description</th>
								<th style="width: 150px;">Sequence</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
<?php
							if(!empty($photoGalleryDetails))
							{
								foreach($photoGalleryDetails as $value)
								{
?>
									<tr>
										<td><?php echo $value['si_no']; ?></td>
										<td><?php echo $value['photo']; ?></td>
										<td><?php echo $value['short_description']; ?></td>
										<td><?php echo $value['description']; ?></td>
										<td><?php echo $value['sequence']; ?></td>
										<td><?php echo $value['action']; ?></td>
									</tr>
<?php
								}
							}
?>
						</tbody>
					</table>
				</div>
			</div>
			<!----------Ajax Loader HTML--------->
			<div class="waitClass" style="display: none;">
				<img src='<?php echo LTE; ?>frontweb/loader.gif' class="waitClassImg" />
			</div>
		</div>
	</div>
</div>
<!--------------------------Listing Section END----------------------------->

<script type = "text/javascript">
	var pageHighlightMenu = "frontweb/junior_ministay";
	$(document).ready(function(){
		//initialize datatable
		var table = $("#datatable").DataTable();

		//Add dynamic rules for checking file extension
		jQuery.validator.addMethod("validData",function(value,element){
			if(/[()+<>\"\'%&;]/.test(value)){
					return false;
			}else{
				return true;
			}
		},"<?php echo $this->lang->line('valid_data_error_msg'); ?>");

		jQuery.validator.addMethod("checkImageWidth",function(value,element){
			if($('#imgWidthErrorFlag').val() == 2){
					return false;
			}else{
				return true;
			}
		},"");

		jQuery.validator.addMethod("checkImageExt" , function (value , element){
			if(value)
			{
				if(splitByLastDot(value) == 'jpg' || splitByLastDot(value) == 'png' || splitByLastDot(value) == 'jpeg')
					return true;
				else
					return false;
			}
			else
				return true;
		} , "<?php echo $this->lang->line('image_type_error_msg'); ?>");

		//Initialize jquery validator for input fields for pdf management section
		$('#juniorCentrePhotoGallery').validate({
			errorElement : 'span',
			rules : {
				short_description : {
					required : true,
					validData : true
				},
				description : {
					required : true
				},
				photo : {
					required : true ,
					checkImageWidth : true,
					checkImageExt : true
				}
			},
			messages : {
				short_description : {
					required : "<?php echo str_replace('**field**' , 'Short description' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				description : {
					required : "<?php echo str_replace('**field**' , 'Description' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				photo : {
					required : "<?php echo $this->lang->line('required_upload_file'); ?>"
				}
			}
		});

		//Onchange of the photo check validation and load accordingly
		$('#photo').on('change' , function(){
			var files = (this.files) ? this.files : [];
			if(!files.length || !window.FileReader)
				return;
			if(/^image/.test(files[0]['type']))
			{
				var reader = new FileReader();
				reader.readAsDataURL(files[0]);
				reader.onload = function(){
					var image = new Image();
					image.src = this.result;
					image.onload = function(){
						$('.uploadImageProgramClass').attr('src' , this.src);
						if(!(this.height >= <?php echo PHOTO_GALLERY_HEIGHT; ?> && this.width >= <?php echo PHOTO_GALLERY_WIDTH; ?>))
						{
							$('#imgWidthErrorFlag').val('2');
							$('#imgErrorMessage').text("<?php echo str_replace(array('**width**' , '**height**') , array(PHOTO_GALLERY_WIDTH , PHOTO_GALLERY_HEIGHT) , $this->lang->line('minimum_image_dimension')); ?>");
							return false;
						}
						else
						{
							$('#imgWidthErrorFlag').val('1');
							$('#imgErrorMessage').text('');
							return true;
						}
					}
				}
			}
		});

		//onchange of the sequence value it will update in the database
		$('.changeSequence').on('change' , function(){
			$('.waitClass').css('display' , 'block');
			$.ajax({
				url : '<?php echo base_url(); ?>index.php/frontweb/junior_ministay/update_sequence',
				data : {'module' : 'photo_gallery' , 'id' : $(this).data('ref_id') , 'sequence' : $(this).val()},
				type : 'POST',
				dataType : 'JSON',
				success : function(){
					$('.waitClass').css('display' , 'none');
				}
			});
		});
	});

	function confirm_delete()
	{
		if(confirm('<?php echo str_replace('**module**' , 'ptoto gallery' , $this->lang->line('delete_confirmation')); ?>'))
			return true;
		else
			return false;
	}

	//This function is used to return string name after dot
	function splitByLastDot(str)
	{
		if(str != '')
		{
			var arr = str.split('.');
			return arr[1];
		}
	}
</script>
