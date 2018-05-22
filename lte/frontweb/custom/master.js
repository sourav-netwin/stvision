/*
	This JS file is used to manage all custom javascript functionality(applicable for
	add/edit/list) related to the master module
	Current Version : 1.9
*/

var pageHighlightMenu = 'frontweb/master/index/'+moduleName;
$(document).ready(function(){
	if(pageType == 'list')
	{
		//Initialize datatable
		var table = $("#datatable").DataTable({
			processing : true,
			"createdRow": function( row, data, dataIndex ) {
				if(moduleName == 'manage_extra_activity')
				{
					if($(row).find('.btn-danger').data('delete_flag') == 1)
						$(row).css('background-color' , '#9fb48e');
				}
			},
			stateSave : true,
			serverSide : true,
			ajax : {
				url : baseUrl+'index.php/frontweb/master/datatable',
				type : 'POST',
				data : {'moduleName' : moduleName}
			},
			columnDefs : [{"targets" : [0,parseInt(actionColumnNo)] , "orderable" : false}]
		});

		//After click on the change status icon it will open the sweet alert and to confirm that it will change the status
		$(document).on('click' , '.statusIcon' , function(e){
			var message = ($(this).data('status') == 1) ? inactive_confirmation.replace('**module**' , $(this).data('module_title')) : active_confirmation.replace('**module**' ,  $(this).data('module_title'));
			var id = $(this).data('id');
			var module = $(this).data('module');
			var status = $(this).data('status');
			confirmAction(message , function(c){
				if(c){
					$.ajax({
						url : baseUrl+'index.php/frontweb/master/update_status',
						type : 'POST',
						data : {'id' : id , 'status' : status , 'module' : module},
						success : function(){
							table.ajax.reload();
						}
					});
				}
			} , true , true);
		});

		//Operations for master activity module only - Copy activity management
		if(moduleName == 'manage_fixed_activity')
		{
			//For master activity module , after click on the copy icon , we have opened one modal to select multiple dates
			$(document).on('click' , '.copyMasterActivity' , function(){
				$('#copyMasterActivityModal').find('.modalTitle').text('Copy master activity for '+$(this).parent().parent().parent().find('td').eq(1).text());
				$('#copyMasterActivityModal').find('#id').val($(this).data('id'));
				$('#copyMasterActivityModal').find('#centre_id').text($(this).parent().parent().parent().find('td').eq(1).text());
				$('#copyMasterActivityModal').find('#activity_name').text($(this).parent().parent().parent().find('td').eq(3).text());
				$('#copyMasterActivityModal').find('#arrival_date').text($(this).parent().parent().parent().find('td').eq(4).text());
				$('#copyMasterActivityModal').find('#departure_date').text($(this).parent().parent().parent().find('td').eq(5).text());

				//Get the student dropdoen values to show in the copy activity form
				$.ajax({
					url : baseUrl+'index.php/frontweb/master_activity/get_copy_student_group',
					type : 'POST',
					data : {'id' : $(this).data('id')},
					dataType : 'JSON',
					success : function(response){
						$('#copyMasterActivityModal').find('#student_group').empty().append(
							$('<option></option>').attr('value' , '').text('Please select group')
						);
						if(response.length > 0)
						{
							$.each(response , function(index , value){
								$('#copyMasterActivityModal').find('#student_group').append(
									$('<option></option>').attr('value' , value.student_group_id).text(value.group_name)
								);
							});
						}
					}
				});

				$('#copyMasterActivityModal').modal();
			});

			//Check required validation
			$('#copyMasterActivityForm').validate({
				errorElement : 'span',
				rules : {
					student_group : {
						required : true
					}
				}
			});
		}

		//After click on the add more icon it will add dynamic content for master modules through ajax call
		$(document).on('click' , '.addMoreTable' , function(){
			var $selector = $(this);
			if($selector.parent().find('i').length == 1)
				$selector.parent().append('<i class="fa fa-lg fa-minus-circle delete_section removeMoreTable" aria-hidden="true"></i>');
			$.ajax({
				url : baseUrl+'index.php/frontweb/master/get_extra_action_fields',
				type : 'POST',
				data : {
					'module' : $('#extraActionModal').find('#moduleName').val(),
					'id' : '',
					'ajaxCount' : 1
				},
				dataType : 'JSON',
				success : function(response){
					$selector.parent().parent().after(response.htmlStr);
					initSummernote();
				}
			});
		});

		//After click on the remove more icon it will remove dynamic content for master modules
		$(document).on('click' , '.removeMoreTable' , function(){
			$(this).parent().parent().remove();
			if($('.subTableWrapper').length == 1)
				$('.subTableWrapper').find('.removeMoreTable').remove();
		});
	}
	else if(pageType == 'add_edit')
	{
		//Initialize jquery validator to check the form validation
		$('#masterForm').validate({
			errorElement : 'span'
		});

		//Add validation rules to every field dynamically
		var fieldObject = JSON.parse(fieldArr);
		$.each(fieldObject , function(fieldKey , fieldValue){
			if(fieldValue.type != 'subtable')
			{
				fieldValue.validation.split('|').forEach(function(alowedTypes){
					if(/maxlength/g.test(alowedTypes))
					{
						var arr = alowedTypes.split(':');
						$('#'+fieldKey).rules('add' , {
							maxlength : arr[1]
						});
					}
					else if(alowedTypes == 'required')
					{
						$('#'+fieldKey).rules('add' , {
							required : true
						});

						//If any textare is presented as summernote then check the required validation
						if(fieldValue.type == 'textarea' && fieldValue.summernote == 1)
						{
							$('#masterForm').submit(function(){
								if($(this).valid())
								{
									var textareaStr = $('#'+fieldKey).summernote('isEmpty') ? '' : $('#'+fieldKey).summernote('code');
									if(strip_html_tags(textareaStr) == '')
									{
										$('#'+fieldKey+'_descriptionErrorMessage').text(please_enter_dynamic.replace('**field**' , fieldValue.fieldLabel));
										return false;
									}
									else
									{
										$('#'+fieldKey+'_descriptionErrorMessage').text('');
										return true;
									}
								}
							});
						}
					}
					else if(alowedTypes == 'validData')
					{
						$('#'+fieldKey).rules('add' , {
							validData : true
						});
					}
					else if(alowedTypes == 'numeric')
					{
						$('#'+fieldKey).rules('add' , {
							number : true
						});
					}
					else if(alowedTypes == 'imageRequired')
					{
						$('#'+fieldKey).rules('add' , {
							imageRequired : true
						});
					}
					else if(alowedTypes == 'checkImageExt')
					{
						$('#'+fieldKey).rules('add' , {
							checkImageExt : true
						});
					}
					else if(alowedTypes == 'checkImageWidth')
					{
						$('#'+fieldKey).rules('add' , {
							checkImageWidth : true
						});
					}
					else if(alowedTypes == 'url')
					{
						$('#'+fieldKey).rules('add' , {
							url : true
						});
					}
					else if(alowedTypes == 'validVimeoUrl')
					{
						$('#'+fieldKey).rules('add' , {
							validVimeoUrl : true
						});
					}
					else if(alowedTypes.indexOf('duplicate') != -1)
					{
						var arr = alowedTypes.split(':');
						$('#'+fieldKey).rules('add' , {
							remote: {
								url: baseUrl+'index.php/frontweb/master/check_duplicate',
								type: "post",
								async : false,
								data: {
									field : fieldKey,
									module : moduleName,
									flag : $('#flag').val(),
									id : id,
									dependField : (arr[1]) ? arr[1] : '',
									dependValue : function() {
										return (arr[1]) ? $('#'+arr[1]).val() : '';
									},
									data : function() {
										return $('#'+fieldKey).val();
									}
								}
							},
							messages: {
								remote : duplicate_dynamic.replace('**field**' , fieldValue.fieldLabel),
							}
						});
					}
				});
			}
		});

		//Add customize validation rules to check the valid data
		jQuery.validator.addMethod("validData" , function(value , element){
			if(/[()+<>\"\'%&;]/.test(value))
				return false;
			else
				return true;
		} , valid_data_error_msg);

		//Add customize rules to check the image required
		jQuery.validator.addMethod('imageRequired' , function(value , element){
			if(value == '' && $('#'+element.id+'_oldImg').val() == '')
				return false;
			else
				return true;
		} , required_upload_image);

		//Add customize rules to check the image width
		jQuery.validator.addMethod("checkImageWidth" , function(value , element){
			if($('#'+element.id+'_widthErrorFlag').val() == 2)
				return false;
			else
				return true;
		} , "");

		//Add customize rules to check the image extension(only jpg,jpeg and png allowed)
		jQuery.validator.addMethod("checkImageExt" , function (value , element){
			if(value)
			{
				if(splitByLastDot(value) == 'jpg' || splitByLastDot(value) == 'jpeg')
					return true;
				else
					return false;
			}
			else
				return true;
		} , image_type_error_msg);

		//Add custimize validation to check the entered url is video url or not
		jQuery.validator.addMethod('validVimeoUrl' , function(value , element){
			if(value.indexOf('vimeo.com') == -1)
				return false;
			else
				return true;
		} , enter_vimeo_url);

		//On change of the image , it checks the validation and load the image accordingly
		$.each(fieldObject , function(fieldKey , fieldValue){
			if(fieldValue.type == 'file' && fieldValue.fileType == 'image')
			{
				$('#'+fieldKey).on('change' , function(){
					$(this).next('span.error').text('');
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
								$('#'+fieldKey+'_onChangeImage').attr('src' , this.src);
								if(!(this.height >= fieldValue.height && this.width >= fieldValue.width))
								{
									$('#'+fieldKey+'_widthErrorFlag').val('2');
									$('#'+fieldKey+'_customErrorMessage').text(minimum_image_dimension.replace('**width**' , fieldValue.width).replace('**height**' , fieldValue.height));
									return false;
								}
								else
								{
									$('#'+fieldKey+'_widthErrorFlag').val('1');
									$('#'+fieldKey+'_changeFlag').val('2');
									$('#'+fieldKey+'_customErrorMessage').text('');
									return true;
								}
							};
						};
					}
				});
			}
		});
	}
});

function confirm_delete(moduleTitle)
{
	if(confirm(delete_confirmation.replace('**module**' , moduleTitle)))
		return true;
	else
		return false;
}

//This function is used to return string name after dot (used to get the file extension)
function splitByLastDot(str)
{
	if(str != '')
	{
		var arr = str.split('.');
		return arr[1].toLowerCase();
	}
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

//This function is used to initialize summernote
function initSummernote()
{
	$('.summernote').summernote({
		height: 200
	});
}
