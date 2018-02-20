/*
	This JS file is used to manage all custom javascript functionality(applicable for
	add/edit/list) related to the master module
	Current Version : 0.2
*/

var pageHighlightMenu = 'frontweb/master/index/'+moduleName;
$(document).ready(function(){
	if(pageType == 'list')
	{
		//Initialize datatable
		var table = $("#datatable").DataTable({
			processing : true,
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
				else if(alowedTypes == 'duplicate')
				{
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
				if(splitByLastDot(value) == 'jpg' || splitByLastDot(value) == 'png' || splitByLastDot(value) == 'jpeg')
					return true;
				else
					return false;
			}
			else
				return true;
		} , image_type_error_msg);

		$.each(fieldObject , function(fieldKey , fieldValue){
			if(fieldValue.type == 'file' && fieldValue.fileType == 'image')
			{
				//On change of the image , it checks the validation and load the image accordingly
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
