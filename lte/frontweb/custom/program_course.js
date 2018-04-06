/*
	This JS file is to manage custom javascript functionality(for both add/edit/list)
	related to the program course module
	Current Version : 1.1
*/

var pageHighlightMenu = "frontweb/program_course";
$(document).ready(function(){
	if(pageType == 'list')
	{
		//Initialize datatable
		var table = $("#datatable").DataTable({
			processing : true,
			stateSave : true,
			serverSide : true,
			ajax : {
				url : 'program_course/get_program',
				type : 'POST'
			},
			aoColumnDefs: [
				{"bSortable" : false , "aTargets" : [1,2,3]}
			]
		});
	}
	else if(pageType == 'add_edit')
	{
		//Initialize summernote
		$('.summernote').summernote({
			height: 200
		});

		//Add customize validation rules
		jQuery.validator.addMethod("validData",function(value,element){
			if(/[()+<>\"\'%&;]/.test(value)){
					return false;
			}else{
				return true;
			}
		} , valid_data_error_msg);

		jQuery.validator.addMethod('checkRequired' , function(value , element){
			if(element.id == 'program_course_logo')
				var imageNameField = 'oldImg';
			else if(element.id = 'program_front_image')
				var imageNameField = 'oldImgFront';
			if(value == '' && $('#'+imageNameField).val() == '')
				return false;
			else
				return true;
		} , required_upload_image);

		jQuery.validator.addMethod("checkImageWidth",function(value,element){
			if($('#imgWidthErrorFlag').val() == 2 || $('#imgWidthErrorFlagFront').val() == 2){
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
		} , image_type_error_msg);

		//Jquery validator
		$('#programDetails').validate({
			errorElement : 'span',
			rules : {
				program_course_name : {
					required : true,
					validData : true
				},
				program_course_logo : {
					checkRequired : true,
					checkImageWidth : true,
					checkImageExt : true
				},
				program_front_image : {
					checkRequired : true,
					checkImageWidth : true,
					checkImageExt : true
				}
			},
			messages : {
				program_course_name : {
					required : please_enter_dynamic.replace('**field**' , 'Program Name')
				}
			},
			submitHandler : function(){
				var textareaStr = $('#program_course_description').summernote('isEmpty') ? '' : $('#program_course_description').summernote('code');
				if(strip_html_tags(textareaStr) == '')
				{
					$('#descriptionErrorMessage').text(please_enter_dynamic.replace('**field**' , 'Description'));
					return false;
				}
				else
				{
					$('#descriptionErrorMessage').text('');
					$('#programDetails').submit();
					return true;
				}
			}
		});
	}

	$(document).on('click' , '.global-list-status-icon' , function(e){
		var message = ($(this).find('.fa').data('status_type') == 1) ? inactive_confirmation.replace('**module**' , 'Program') : active_confirmation.replace('**module**' , 'Program');
		var id = $(this).find('.fa').data('program_id');
		var status = $(this).find('.fa').data('status_type');
		confirmAction(message , function(c){
			if(c){
				$.ajax({
					url : 'program_course/update_status',
					type : 'POST',
					data : {'program_id' : id , 'program_status' : status},
					success : function(){
						table.ajax.reload();
					}
				});
			}
		} , true , true);
	});

	//on change of course logo check validation and also change image
	$('#program_course_logo').on('change' , function(){
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
					$('.uploadImageProgramClass').attr('src' , this.src);
					if(!(this.height >= height1 && this.width >= width1))
					{
						$('#imgWidthErrorFlag').val('2');
						$('#imgErrorMessage').text(minimum_image_dimension.replace('**width**' , width1).replace('**height**' , height1));
						return false;
					}
					else
					{
						$('#imgWidthErrorFlag').val('1');
						$('#imageChangeFlag').val('2');
						$('#imgErrorMessage').text('');
						return true;
					}
				};
			};
		}
	});

	//On change of home page image check validation and change the image
	$('#program_front_image').on('change' , function(){
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
					$('.uploadImageProgramClassHome').attr('src' , this.src);
					if(!(this.height >= height2 && this.width >= width2))
					{
						$('#imgWidthErrorFlagFront').val('2');
						$('#imgErrorMessageFront').text(minimum_image_dimension.replace('**width**' , width2).replace('**height**' , height2));
						return false;
					}
					else
					{
						$('#imgWidthErrorFlagFront').val('1');
						$('#imageChangeFlagFront').val('2');
						$('#imgErrorMessageFront').text('');
						return true;
					}
				};
			};
		}
	});
});

function confirm_delete()
{
	if(confirm(delete_confirmation.replace('**module**' , 'Course Program')))
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

//This function is used to remove html taags from the inputted string
function strip_html_tags(str)
{
	if(str == '')
		return '';
	else
		str = str.toString();
	return str.replace(/<[^>]*>/g , '');
}
