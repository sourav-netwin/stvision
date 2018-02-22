<!--------------Datatable CSS and JS---------------->
<link href="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
<script src="<?php echo LTE; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo LTE; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<!----------Summernote CSS and JS--------->
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/summernote.css">
<script src="<?php echo LTE; ?>frontweb/summernote.js"></script>

<!----------Form validation js----------->
<script src="<?php echo base_url(); ?>js/tuition/jquery_validations1.9.0.js"></script>
<link rel="stylesheet" href="<?php echo LTE; ?>frontweb/style.css">

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel box">
				<div class="box-header col-sm-12">
					<div class="row">
						<div class="col-sm-6 btn-create">
							<a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/frontweb/course/add"><i class="fa fa-plus" aria-hidden="true"></i> Add course</a>
						</div>
						<?php showSessionMessageIfAny($this);?>
					</div>
				</div>
				<div class="x_content box-body">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Si no.</th>
								<th>Image</th>
								<th>Course name</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!---------------------Feature Modal Start--------------------->
<div class="modal fade" id="courseFeature" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Course Feature</h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'courseFeatures',
				'method' =>'post'
			);
			echo form_open_multipart('/frontweb/course/add_course_feature' , $formAttribute);
?>
				<div class="modal-body">
					<input type="hidden" id="global_more_count" name="global_more_count" value="1" />
					<input type="hidden" name='course_id' id="course_id" />
					<div id="featureContainer"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="updateFeatureBtn" class="btn btn-info">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------Feature Modal End--------------------->

<!---------------------Manage Brochure Modal Start----------------->
<div class="modal fade" id="uploadPdfModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Manage brochure</h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'uploadPdfModalForm',
				'method' =>'post'
			);
			echo form_open_multipart('' , $formAttribute);
?>
				<input type="hidden" name="juniorCentreId" id="juniorCentreId">
				<input type="hidden" name="uploadPdfModalType" id="uploadPdfModalType" value="brochure"/>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">File description<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'name' => 'file_description',
								'id' => 'file_description',
								'class' => 'form-control',
								'rows' => 2
							);
							echo form_textarea($inputFieldAttribute);
?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload file <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
<?php
							$inputFieldAttribute = array(
								'id' => 'file_name',
								'name' => 'file_name',
								'type' => 'file'
							);
							echo form_input($inputFieldAttribute);
?>
							<span style="color: red;" id="fileUploadErrorMsg"></span>
							<small style="display:block">
								( Note : Only pdf files are allowed )
							</small>
						</div>
					</div>
					<div class="clearfix"></div><hr>
					<div id="uploadPdfModalTableWrapper"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------Manage Brochure Modal End----------------->

<!---------------------Manage Application Form Modal Start----------------->
<div class="modal fade" id="formManageModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Manage Application Form</h4>
			</div>
<?php
			$formAttribute = array(
				'class' => 'form-horizontal form-label-left show-custom-error-tag',
				'id' => 'manageForm',
				'method' =>'post'
			);
			echo form_open_multipart('/frontweb/course/update_form' , $formAttribute);
?>
				<input type="hidden" name="globalCount" id="globalCount" >
				<div class="modal-body manageFormModalBody"></div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!---------------------Manage Application Form Modal End----------------->

<script type = "text/javascript">
	var pageHighlightMenu = "frontweb/course";
	$(document).ready(function(){
		//For Datatable
		var table = $("#datatable").DataTable({
			processing : true,
			stateSave : true,
			serverSide : true,
			ajax : {
				url : '<?php echo base_url(); ?>index.php/frontweb/course/get_course',
				type : 'POST'
			},
			aoColumnDefs: [
				{"bSortable" : false , "aTargets" : [1,2,3]}
			]
		});

		//Show status page
		$(document).on('click' , '.global-list-status-icon' , function(e){
			var message = ($(this).find('.fa').data('status_type') == 1) ? '<?php echo str_replace("**module**" , "Course" , $this->lang->line("inactive_confirmation")); ?>' : '<?php echo str_replace("**module**" , "Course" , $this->lang->line("active_confirmation")); ?>';
			var id = $(this).find('.fa').data('course_id');
			var status = $(this).find('.fa').data('status_type');
			confirmAction(message , function(c){
				if(c){
					$.ajax({
						url : '<?php echo base_url(); ?>index.php/frontweb/course/update_status',
						type : 'POST',
						data : {'course_id' : id , 'course_status' : status},
						success : function(){
							table.ajax.reload();
						}
					});
				}
			} , true , true);
		});

		//Show all feature details
		$(document).on('click' , '#manageFeature' , function(){
			$('#course_id').val($(this).data('course_id'));
			$.ajax({
				url : '<?php echo base_url(); ?>index.php/frontweb/course/get_course_feature',
				data : {'course_id' : $(this).data('course_id')},
				type : 'POST',
				dataType : 'JSON',
				success : function(respond){
					$('#global_more_count').val(respond.total_record);
					$('#featureContainer').empty();
					$('#featureContainer').append(respond.str);
					$('.summernote').summernote({
						height: 200
					});
				}
			});
		});

		//After click on the plus icon it will append same rows
		$(document).on('click' , '.add_more_icon' , function(){
			$(this).attr('class' , 'fa fa-lg fa-minus-circle remove_more_icon');
			$('#global_more_count').val((parseInt($('#global_more_count').val())+1));
			var dynamic_count = $('#global_more_count').val();
			var str = '<div id="add_more_wrapper_'+dynamic_count+'" class="add_more_wrapper border-box">\
						<div class="form-group">\
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Title<span class="required">*</span></label>\
							<div class="col-md-9 col-sm-9 col-xs-12">\
								<input name="feature_title['+dynamic_count+']" id="feature_title['+dynamic_count+']" class="form-control" placeholder="Title" type="text">\
							</div><div class="clearfix"></div>\
						</div>\
						<div class="form-group">\
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>\
							<div class="col-md-9 col-sm-9 col-xs-12">\
								<textarea name="feature_description['+dynamic_count+']" id="feature_description_'+dynamic_count+'" class="form-control summernote"></textarea>\
								<span id="descriptionErrorMessage_'+dynamic_count+'" style="color:#ff0000"></span>\
							</div>\
						</div>\
						<div class="form-group">\
							<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Upload image <span class="required">*</span></label>\
							<div class="col-md-6 col-sm-6 col-xs-12">\
								<input type="hidden" name="imageChangeFlag['+dynamic_count+']" id="imageChangeFlag_'+dynamic_count+'" value="1" />\
								<input type="hidden" id="imgWidthErrorFlag_'+dynamic_count+'" value="1" />\
								<input type="hidden" name="oldImg['+dynamic_count+']" id="oldImg_'+dynamic_count+'" value="" />\
								<label for="feature_image_'+dynamic_count+'">\
									<img height="50" width="180" class="uploadImageProgramClass" src="<?php echo LTE.'frontweb/no_flag.jpg'; ?>"/>\
								</label>\
								<input class="feature_image_class" name="feature_image_'+dynamic_count+'" id="feature_image_'+dynamic_count+'" style="visibility: hidden;" type="file">\
								<small style="display:block">\
									( Note: Only JPG|JPEG|PNG images are allowed <br> &amp; image size should exact 800 X 500 pixel )\
								</small>\
								<span id="imgErrorMessage_'+dynamic_count+'" style="color:#ff0000"></span>\
							</div>\
						</div>\
					</div>\
					<div style="float: right;"><i class="fa fa-lg fa-plus-circle add_more_icon" aria-hidden="true" data-block_no='+dynamic_count+'></i></div><div class="clearfix"></div>';
					$('#featureContainer').append(str);
					$('.summernote').summernote({
						height: 200
					});
		});

		//After click on the minus icon it will delete that row
		$(document).on('click' , '.remove_more_icon' , function(){
			$('#add_more_wrapper_'+$(this).data('block_no')).remove();
			$(this).parent().remove();
		});

		//Dynamically add validation rules
		jQuery.validator.addMethod("validData",function(value,element){
			if(/[()+<>\"\'%&;]/.test(value)){
					return false;
			}else{
				return true;
			}
		},"<?php echo $this->lang->line('valid_data_error_msg'); ?>");

		jQuery.validator.addMethod("checkImageWidth",function(value,element){
			var ref_arr = element.id.split('_');
			if($('#imgWidthErrorFlag_'+ref_arr[2]).val() == 2){
					return false;
			}else{
				return true;
			}
		},"<?php echo str_replace(array('**width**' , '**height**') , array('800' , '500') , $this->lang->line('exact_image_size')); ?>");

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

		jQuery.validator.addMethod('checkImageAvailable' , function(value , element){
			var ref_arr = element.id.split('_');
			if(value == '' && $('#oldImg_'+ref_arr[2]).val() == '')
				return false;
			else
				return true;
		} , "<?php echo $this->lang->line('required_upload_image'); ?>");

		//Initialize form validation for features management
		$('#courseFeatures').validate({
			errorElement : 'span',
			rules : {
				'feature_title[1]' : {
					required : true,
					validData : true
				},
				'feature_image_1' : {
					checkImageAvailable : true,
					checkImageWidth : true,
					checkImageExt : true
				}
			},
			messages : {
				'feature_title[1]' : {
					required : "<?php echo str_replace('**field**' , 'Title' , $this->lang->line('please_enter_dynamic')); ?>"
				}
			}
		});

		//After click on the update button , check validation and update value for features
		$(document).on('click' , '#updateFeatureBtn' , function(){
			var textareaErrorFlag = 1;
			for(var i = 1 ; i <= $('#global_more_count').val() ; i++)
			{
				var textareaStr = $('#feature_description_'+i).summernote('isEmpty') ? '' : $('#feature_description_'+i).summernote('code');
				if(strip_html_tags(textareaStr) == '')
				{
					textareaErrorFlag = 2;
					$('#descriptionErrorMessage_'+i).text("<?php echo str_replace('**field**' , 'Description' , $this->lang->line('please_enter_dynamic')); ?>");
				}
				else
					$('#descriptionErrorMessage_'+i).text('');

				if(i > 1)
				{
					$("input[name*='feature_title["+i+"]']").rules("add", {
						required : true ,
						validData : true ,
						messages : {
							required : "<?php echo str_replace('**field**' , 'Title' , $this->lang->line('please_enter_dynamic')); ?>"
						}
					});
					$("input[name*='feature_image_"+i+"']").rules("add", {
						checkImageAvailable : true,
						checkImageWidth : true,
						checkImageExt : true
					});
				}
			}
			if(!($('#courseFeatures').valid() === true && textareaErrorFlag == 1))
				return false;
		});

		//With the change of feature images it checks for the validation and load that image
		$(document).on('change' , '.feature_image_class' , function(){
			var ref_arr = $(this).attr('id').split('_');
			var $img_source = $(this).parent().find('.uploadImageProgramClass');
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
						$img_source.attr('src' , this.src);
						if(!(this.height == 500 && this.width == 800))
						{
							$('#imgWidthErrorFlag_'+ref_arr[2]).val('2');
							$('#imgErrorMessage_'+ref_arr[2]).text("<?php echo str_replace(array('**width**' , '**height**') , array('800' , '500') , $this->lang->line('exact_image_size')); ?>");
							return false;
						}
						else
						{
							$('#imgWidthErrorFlag_'+ref_arr[2]).val('1');
							$('#imgErrorMessage_'+ref_arr[2]).text('');
							$('#imageChangeFlag_'+ref_arr[2]).val('2');
							return true;
						}
					}
				}
			}
		});

		//After click on extra management icon for pdf management open modal with dynamic content
		$(document).on('click' , '.pdf-management-class' , function(e){
			$('#uploadPdfModalForm')[0].reset();
			$('#juniorCentreId').val($(this).data('course_master_id'));
			loadPdfManagementTable($(this).data('course_master_id'));
			$('#uploadPdfModal').modal();
		});

		//Ad dynamic validation rules in jquery validator for checking pdf file extension
		jQuery.validator.addMethod("checkPdfExt" , function (value , element){
			if(value)
			{
				if(splitByLastDot(value) == 'pdf')
					return true;
				else
					return false;
			}
			else
				return true;
		} , "<?php echo $this->lang->line('pdf_type_error_msg'); ?>");

		//Initialize jquery validator for input fields for pdf management section
		$('#uploadPdfModalForm').validate({
			errorElement : 'span',
			rules : {
				file_description : {
					required : true
				},
				file_name : {
					required : true ,
					checkPdfExt : true
				}
			},
			messages : {
				file_description : {
					required : "<?php echo str_replace('**field**' , 'Description' , $this->lang->line('please_enter_dynamic')); ?>"
				},
				file_name : {
					required : "<?php echo $this->lang->line('required_upload_file'); ?>"
				}
			}
		});

		//This section is used to submit the form through ajax
		$('#uploadPdfModalForm').submit(function(e){
			$('#fileUploadErrorMsg').text('');
			if($(this).valid())
			{
				e.preventDefault();
				var formData = new FormData(this);
				$.ajax({
					url : '<?php echo base_url(); ?>index.php/frontweb/junior_centre/upload_pdf_management',
					type : 'POST',
					data : formData,
					contentType: false,
					cache: false,
					processData: false,
					dataType : 'JSON',
					success : function(response){
						if(response.fileUploadErrorMsg != '')
							$('#fileUploadErrorMsg').text(response.fileUploadErrorMsg);
						else
						{
							$('#uploadPdfModalForm')[0].reset();
							loadPdfManagementTable($('#juniorCentreId').val());
						}
					}
				});
			}
		});

		//After click on delete icon from modal table , the record will delete from database
		$(document).on('click' , '.deletePdf' , function(){
			if(confirm('<?php echo str_replace('**module**' , 'Pdf' , $this->lang->line('delete_confirmation')); ?>'))
			{
				var juniorcentreid = $(this).data('juniorcentreid');
				$.ajax({
					url : '<?php echo base_url(); ?>index.php/frontweb/junior_centre/delete_pdf_management',
					data : {'id' : $(this).data('refid') , 'uploadpdfmodaltype' : 'brochure'},
					type : 'POST',
					dataType : 'JSON',
					success : function(response){
						$('#uploadPdfModalForm')[0].reset();
						loadPdfManagementTable(juniorcentreid);
					}
				});
			}
		});

		//After click on manage application form icon , open modal
		$(document).on('click' , '.formManagement' , function(e){
			$('#manageForm')[0].reset();
			$.ajax({
				url : '<?php echo base_url(); ?>index.php/frontweb/course/show_form_management',
				type : 'POST',
				dataType : 'JSON',
				'success' : function(response){
					if(response.design)
						$('.manageFormModalBody').empty().append(response.design);
					if(response.count)
						$('#globalCount').val(response.count);
				}
			});
			$('#formManageModal').modal();
		});

		//After click on the add more icon append new content for application form management
		$(document).on('click' , '.add_section' , function(){
			var newCount = parseInt($('#globalCount').val())+1;
			$('#globalCount').val(newCount);
			$('.sectionWrapper').last().clone().prop('id' , 'sectionWrapper_'+newCount).appendTo('.manageFormModalBody');
			$('#sectionWrapper_'+newCount).find('.labelName').prop('id' , 'label_name['+newCount+']').prop('name' , 'label_name['+newCount+']').val('');
			$('#sectionWrapper_'+newCount).find('.fieldType').prop('id' , 'field_type['+newCount+']').prop('name' , 'field_type['+newCount+']').val('');
			$('#sectionWrapper_'+newCount).find('.requiredFlag').prop('id' , 'required_flag['+newCount+']').prop('name' , 'required_flag['+newCount+']').prop('checked' , false);
			$('#sectionWrapper_'+newCount).find('.fieldSequence').prop('id' , 'sequence['+newCount+']').prop('name' , 'sequence['+newCount+']').val('');
			$('#sectionWrapper_'+newCount).find('.multipleValue').parent().parent().remove();

			$(this).parent().empty().append('<i class="fa fa-lg fa-minus-circle remove_section" aria-hidden="true"></i>');
			$('#sectionWrapper_'+newCount).find('.addRemoveSection').empty()
			.append('<i class="fa fa-lg fa-minus-circle remove_section" aria-hidden="true"></i><i class="fa fa-lg fa-plus-circle add_section" aria-hidden="true"></i>');
		});

		//After click on the delete section icon , remove the section accordingly (for applicartion form management)
		$(document).on('click' , '.remove_section' , function(){
			$(this).parent().parent().remove();
			var newCount = $('.sectionWrapper').length;
			if(newCount == 1)
				$('.sectionWrapper').find('.addRemoveSection').empty().append('<i class="fa fa-lg fa-plus-circle add_section" aria-hidden="true"></i>');
			else
				$('.sectionWrapper').last().find('.addRemoveSection').empty().append('<i class="fa fa-lg fa-minus-circle remove_section" aria-hidden="true"></i><i class="fa fa-lg fa-plus-circle add_section" aria-hidden="true"></i>');
		});

		//If field type is checkbox/radio button/dropdown then open one box to add multiple values
		$(document).on('change' , '.fieldType' , function(){
			if($(this).val() == 'checkbox' || $(this).val() == 'radio' || $(this).val() == 'dropdown')
			{
				var referenceArr = $(this).parent().parent().parent().parent().attr('id').split('_');
				var str = '<div class="form-group">\
								<label class="control-label custom-control-label col-md-3 col-sm-3 col-xs-12">Field Values<span class="required">*</span></label>\
								<div class="col-md-6 col-sm-6 col-xs-12">\
									<textarea name="multiple_value['+referenceArr[1]+']" id="multiple_value['+referenceArr[1]+']" class="form-control multipleValue" rows="2" required></textarea>\
								</div>\
							</div>';
				$(this).parent().parent().after(str);
			}
		});
	});

	//This function is used to show the confirm box to the admin to delete any record
	function confirm_delete()
	{
		if(confirm('<?php echo str_replace('**module**' , 'Course' , $this->lang->line('delete_confirmation')); ?>'))
			return true;
		else
			return false;
	}

	//This function is used to remove html taags from the inputted string
	function strip_html_tags(str)
	{
		if(str == '')
			return '';
		else
			str = str.toString();
		return str.replace(/<[^>]*>/g , '');
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

	//Function is used to load modal table for pdf upload management dynamically
	function loadPdfManagementTable(juniorCentreId)
	{
		$("#uploadPdfModalTableWrapper").empty();
		$.ajax({
			url : '<?php echo base_url(); ?>index.php/frontweb/junior_centre/get_pdf_management',
			data : {'juniorCentreId' : juniorCentreId , 'uploadPdfModalType' : 'brochure'},
			type : 'POST',
			dataType : 'JSON',
			success : function(response){
				if(response.pdfManagemnetDetails)
					$("#uploadPdfModalTableWrapper").append(response.pdfManagemnetDetails);
				$("#uploadPdfModalTable").DataTable();
			}
		});
	}
</script>
